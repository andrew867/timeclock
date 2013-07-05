<?php

session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];
$current_page = "audit.php";

include '../config.inc.php';

if ($use_reports_password == "yes") {

if (!isset($_SESSION['valid_reports_user'])) {

echo "<title>$title</title>\n";
include '../admin/header.php';
include '../admin/topmain.php';

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Reports</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>You are not presently logged in, or do not have permission to view this page.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='../login_reports.php'><u>here</u></a> to login.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}
}

echo "<title>$title - Audit Log</title>\n";

if ($request == 'GET') {

include '../admin/header_date.php';

if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post' onsubmit=\"return isFromOrToDate();\">\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td class=table_rows width=20 align=center><img src='../images/icons/information.png' /></td><td class=table_rows
                      style='color:#3366CC;'>This report will display all information pertaining to punch-in/out times that have been 
                      added, edited, or deleted from PHP Timeclock.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";


echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/report.png' />&nbsp;&nbsp;&nbsp;Audit Log</th>
                    </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <input type='hidden' name='date_format' value='$js_datefmt'>\n";
echo "              <tr><td class=table_rows style='padding-left:32px;' width=20% nowrap>From Date: ($tmp_datefmt)</td><td
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;' width=80% >
                      <input type='text' size='10' maxlength='10' name='from_date' style='color:#27408b'>&nbsp;*&nbsp;&nbsp;
                      <a href=\"#\" onclick=\"form.from_date.value='';cal.select(document.forms['form'].from_date,'from_date_anchor','$js_datefmt');
                      return false;\" name=\"from_date_anchor\" id=\"from_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows style='padding-left:32px;' width=20% nowrap>To Date: ($tmp_datefmt)</td><td
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;' width=80% >
                      <input type='text' size='10' maxlength='10' name='to_date' style='color:#27408b'>&nbsp;*&nbsp;&nbsp;
                      <a href=\"#\" onclick=\"form.to_date.value='';cal.select(document.forms['form'].to_date,'to_date_anchor','$js_datefmt');
                      return false;\" name=\"to_date_anchor\" id=\"to_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <div style=\"position:absolute;visibility:hidden;background-color:#ffffff;layer-background-color:#ffffff;\" id=\"mydiv\"
                 height=200>&nbsp;</div>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td class=table_rows height=25 valign=bottom>1.&nbsp;&nbsp;&nbsp;Export to CSV? (link to CSV file will be in the top right of 
                      the next page)</td></tr>\n";
if (strtolower($export_csv) == "yes") {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='csv' value='1' checked>&nbsp;Yes
                      <input type='radio' name='csv' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='csv' value='1'>&nbsp;Yes
                      <input type='radio' name='csv' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td height=10></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='index.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php';
exit;

} else {

include '../admin/header_date.php';

$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
@$tmp_csv = $_POST['csv'];

// begin post error checking //

if (isset($tmp_csv)) {
if (($tmp_csv != '1') && (!empty($tmp_csv))) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Choose \"yes\" or \"no\" to the \"<b>Export to CSV?</b>\" question.</td></tr>\n";
echo "            </table>\n";
}}

if (!isset($evil_post)) {
if (empty($from_date)) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid From Date is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([0-9]?[0-9])+[-|/|.]+([0-9]?[0-9])+[-|/|.]+(([0-9]{2})|([0-9]{4}))$", $from_date, $date_regs)) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid From Date is required.</td></tr>\n";
echo "            </table>\n";

} else {

if ($calendar_style == "amer") {
//if (isset($date_regs)) {$from_month = $date_regs[1]; $from_day = $date_regs[2]; $from_year = $date_regs[3];}
if (isset($date_regs)) {$from_month = $date_regs[1]; $from_day = $date_regs[2]; $from_year = $date_regs[3];}
if ($from_month > 12 || $from_day > 31) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid From Date is required.</td></tr>\n";
echo "            </table>\n";
}}

elseif ($calendar_style == "euro") {
if (isset($date_regs)) {$from_month = $date_regs[2]; $from_day = $date_regs[1]; $from_year = $date_regs[3];}
if ($from_month > 12 || $from_day > 31) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid From Date is required.</td></tr>\n";
echo "            </table>\n";
}}}}

if (!isset($evil_post)) {
if (empty($to_date)) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid To Date is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([0-9]?[0-9])+[-|/|.]+([0-9]?[0-9])+[-|/|.]+(([0-9]{2})|([0-9]{4}))$", $to_date, $date_regs)) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid To Date is required.</td></tr>\n";
echo "            </table>\n";

} else {

if ($calendar_style == "amer") {
if (isset($date_regs)) {$to_month = $date_regs[1]; $to_day = $date_regs[2]; $to_year = $date_regs[3];}
if ($to_month > 12 || $to_day > 31) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid To Date is required.</td></tr>\n";
echo "            </table>\n";
}}

elseif ($calendar_style == "euro") {
if (isset($date_regs)) {$to_month = $date_regs[2]; $to_day = $date_regs[1]; $to_year = $date_regs[3];}
if ($to_month > 12 || $to_day > 31) {
$evil_post = '1';
if ($use_reports_password == "yes") {
include '../admin/topmain.php';
} else {
include 'topmain.php';
}
echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid To Date is required.</td></tr>\n";
echo "            </table>\n";
}}}}

if (isset($evil_post)) {
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post' onsubmit=\"return isFromOrToDate();\">\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/report.png' />&nbsp;&nbsp;&nbsp;Audit Log</th>
                    </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <input type='hidden' name='date_format' value='$js_datefmt'>\n";
echo "              <tr><td class=table_rows style='padding-left:32px;' width=20% nowrap>From Date: ($tmp_datefmt)</td><td
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;' width=80% >
                      <input type='text' size='10' maxlength='10' name='from_date' value='$from_date' style='color:#27408b'>&nbsp;*&nbsp;&nbsp;
                      <a href=\"#\" onclick=\"form.from_date.value='';cal.select(document.forms['form'].from_date,'from_date_anchor','$js_datefmt');
                      return false;\" name=\"from_date_anchor\" id=\"from_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows style='padding-left:32px;' width=20% nowrap>To Date: ($tmp_datefmt)</td><td
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;' width=80% >
                      <input type='text' size='10' maxlength='10' name='to_date' value='$to_date' style='color:#27408b'>&nbsp;*&nbsp;&nbsp;
                      <a href=\"#\" onclick=\"form.to_date.value='';cal.select(document.forms['form'].to_date,'to_date_anchor','$js_datefmt');
                      return false;\" name=\"to_date_anchor\" id=\"to_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <div style=\"position:absolute;visibility:hidden;background-color:#ffffff;layer-background-color:#ffffff;\" id=\"mydiv\"
                 height=200>&nbsp;</div>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td class=table_rows height=25 valign=bottom>1.&nbsp;&nbsp;&nbsp;Export to CSV? (link to CSV file will be in the top right of 
                      the next page)</td></tr>\n";
if ($tmp_csv == "1") {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='csv' value='1'
                      checked>&nbsp;Yes<input type='radio' name='csv' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='csv' value='1' >&nbsp;Yes
                      <input type='radio' name='csv' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td height=10></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='index.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php'; 
exit;
}

// end post error checking //

if (!empty($from_date)) {
    $from_date = "$from_month/$from_day/$from_year";
    $from_timestamp = strtotime($from_date) - @$tzo;
    $from_date = $_POST['from_date'];
}
if (!empty($to_date)) {
    $to_date = "$to_month/$to_day/$to_year";
    $to_timestamp = strtotime($to_date) + 86400 - @$tzo;
    $to_date = $_POST['to_date'];
}

$time = time();
$rpt_hour = gmdate('H',$time);
$rpt_min = gmdate('i',$time);
$rpt_sec = gmdate('s',$time);
$rpt_month = gmdate('m',$time);
$rpt_day = gmdate('d',$time);
$rpt_year = gmdate('Y',$time);
$rpt_stamp = mktime ($rpt_hour, $rpt_min, $rpt_sec, $rpt_month, $rpt_day, $rpt_year);

$rpt_stamp = $rpt_stamp + @$tzo;
$rpt_time = date($timefmt, $rpt_stamp);
$rpt_date = date($datefmt, $rpt_stamp);

echo "<table width=100% align=center class=misc_items border=0 cellpadding=3 cellspacing=0>\n";
echo "  <tr><td width=80% style='font-size:9px;color:#000000;padding-left:10px;'>Run on: $rpt_time, $rpt_date</td><td nowrap
                style='font-size:9px;color:#000000;'>Audit Log</td></tr>\n";
echo "  <tr><td width=80%></td><td nowrap style='font-size:9px;color:#000000;'>Date Range: $from_date - $to_date</td></tr>\n";
if (!empty($tmp_csv)) {
  echo "  <tr class=notprint><td width=80%></td><td nowrap style='font-size:9px;color:#000000;'><a style='color:#27408b;font-size:9px;
                  text-decoration:underline;' 
                  href=\"get_csv.php?rpt=auditlog&&csv=$tmp_csv&from=$from_timestamp&to=$to_timestamp&tzo=$tzo\">Download CSV File</a></td></tr>\n";
}
echo "</table>\n";

$row_count = 0;
$page_count = 0;
$cnt = 0;
$modified_when = array();
$modified_from = array();
$modified_to = array();
$modified_by_ip = array();
$modified_by_user = array();
$modified_why = array();

$row_color = $color2; // Initial row color

$query = "select * from ".$db_prefix."audit where modified_when >= '".$from_timestamp."' and modified_when <= '".$to_timestamp."'
          order by modified_when asc";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

  $modified_when[] = "".$row["modified_when"]."";
  $modified_from[] = "".$row["modified_from"]."";
  $modified_to[] = "".$row["modified_to"]."";
  $modified_by_ip[] = "".$row["modified_by_ip"]."";
  $modified_by_user[] = stripslashes("".$row["modified_by_user"]."");
  $modified_why[] = "".$row["modified_why"]."";
  $user_modified[] = "".$row["user_modified"]."";
  $cnt++;
}

for ($x=0;$x<$cnt;$x++) {

    if (!empty($modified_when[$x])) {
        $modified_when[$x] = $modified_when[$x] + @$tzo;
        $modified_when_time = date($timefmt, $modified_when[$x]);
        $modified_when_date = date($datefmt, $modified_when[$x]);
    } else {
        exit;
    }
    if (!empty($modified_from[$x])) {
        $modified_from[$x] = $modified_from[$x] + @$tzo;
        $modified_from_time = date($timefmt, $modified_from[$x]);
        $modified_from_date = date($datefmt, $modified_from[$x]);
    } else {
        $modified_from_time = "".$row["modified_from"]."";
        $modified_from_date = "".$row["modified_from"]."";
    }
    if (!empty($modified_to[$x])) {
        $modified_to[$x] = $modified_to[$x] + @$tzo;
        $modified_to_time = date($timefmt, $modified_to[$x]);
        $modified_to_date = date($datefmt, $modified_to[$x]);
    } else {
        $modified_to_time = "".$row["modified_to"]."";
        $modified_to_date = "".$row["modified_to"]."";
    }
    if ((!empty($modified_from[$x])) && (empty($modified_to[$x]))) {
        $modified_status = "Deleted";
        $modified_color = "#FF0000";
    } elseif ((!empty($modified_from[$x])) && (!empty($modified_to[$x]))) {
        $modified_status = "Edited";
        $modified_color = "#FF9900";
    } elseif ((empty($modified_from[$x])) && (!empty($modified_to[$x]))) {
        $modified_status = "Added";
        $modified_color = "#009900";
    }
    if ($row_count == 0) {
        if ($page_count == 0) {
            echo "<table class=misc_items width=100% border=0 cellpadding=2 cellspacing=0>\n";
            echo "  <tr><td height=15></td></tr>\n";
            echo "  <tr class=notprint>\n";
            echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>User Modified</td>\n";
            echo "    <td nowrap width=10% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Action Taken</td>\n";
            echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified When</td>\n";
            echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified By</td>\n";
            echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified By IP</td>\n";
            echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified From</td>\n";
            echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified To</td></tr>\n";

        } else {

            // display report name and page number of printed report above the column headings of each printed page //

            $temp_page_count = $page_count + 1;
            echo "  <tr><td colspan=2 class=notdisplay style='font-size:9px;color:#000000;padding-left:10px;'>Run on: $rpt_time,
                  $rpt_date (page $temp_page_count)</td><td class=notdisplay nowrap style='font-size:9px;color:#000000;'
                  align=right colspan=4>$rpt_name</td></tr>\n";
            echo "  <tr><td class=notdisplay align=right colspan=6 nowrap style='font-size:9px;color:#000000;'>
                  Date Range: $from_date - $to_date</td></tr>\n";
        }
        echo "  <tr class=notdisplay>\n";
        echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified User</td>\n";
        echo "    <td nowrap width=10% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Action Taken</td>\n";
        echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified When</td>\n";
        echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified By</td>\n";
        echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified By IP</td>\n";
        echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified From</td>\n";
        echo "    <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
        text-decoration:underline;'>Modified To</td></tr>\n";
    }

    // begin alternating row colors //
  
    $row_color = ($row_count % 2) ? $color1 : $color2;
  
    // display the query results //

    echo "  <tr><td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'>$user_modified[$x]</td>\n";
    echo "    <td nowrap align=left width=10% style='background-color:$row_color;color:$modified_color;
        padding-left:10px;'>$modified_status</td>\n";
    echo "  <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'>$modified_when_date,&nbsp;$modified_when_time</td>\n";
    echo "    <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'>$modified_by_user[$x]</td>\n";
    echo "    <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'>$modified_by_ip[$x]</td>\n";
    if (!empty($modified_from[$x])) {
        echo "    <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'>$modified_from_date,&nbsp;$modified_from_time</td>\n";
    } else {
        echo "    <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'></td>\n";
    }
    if (!empty($modified_to[$x])) {
        echo "    <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'>$modified_to_date,&nbsp;$modified_to_time</td></tr>\n";
    } else {
        echo "    <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
        padding-left:10px;'></td></tr>\n";
    }
    $row_count++;

    // output 40 rows per printed page //

    if ($row_count == 40) {
        echo "  <tr style=\"page-break-before:always;\"></tr>\n";
        $row_count = 0;
        $page_count++;
    }
}
echo "</table>\n";
}
exit;
?>
