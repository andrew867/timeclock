<?php

session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];
$current_page = "timerpt.php";

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

echo "<title>$title - Daily Time Report</title>\n";

if ($request == 'GET') {

include 'header_get_reports.php';

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
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/report.png' />&nbsp;&nbsp;&nbsp;Daily 
                    Time Report</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <input type='hidden' name='date_format' value='$js_datefmt'>\n";
if ($username_dropdown_only == "yes") {

$query = "select * from ".$db_prefix."employees order by empfullname asc";
$result = mysql_query($query);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td colspan=2 align=left width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                  <select name='user_name'>\n";
echo "                    <option value ='All'>All</option>\n";

while ($row=mysql_fetch_array($result)) {
  $tmp_empfullname = stripslashes("".$row['empfullname']."");
  echo "                    <option>$tmp_empfullname</option>\n";
}

echo "                  </select>&nbsp;*</td></tr>\n";
mysql_free_result($result);
} else {
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Choose Office:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='office_name' onchange='group_names();'>\n";
echo "                      </select></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Choose Group:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='group_name' onchange='user_names();'>\n";
echo "                      </select></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Choose Username:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='user_name'>\n";
echo "                      </select></td></tr>\n";
}
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
if (strtolower($ip_logging) == "yes") {
echo "              <tr><td class=table_rows height=25 valign=bottom>2.&nbsp;&nbsp;&nbsp;Display connecting ip address information?
                      </td></tr>\n";
if ($display_ip == "yes") {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='tmp_display_ip' value='1'
                      checked>&nbsp;Yes<input type='radio' name='tmp_display_ip' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='tmp_display_ip' value='1' >&nbsp;Yes
                      <input type='radio' name='tmp_display_ip' value='0' checked>&nbsp;No</td></tr>\n";
}
}
echo "              <tr><td height=10></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='index.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php';
exit;

} else {

include 'header_post_reports.php';

@$office_name = $_POST['office_name'];
@$group_name = $_POST['group_name'];
$fullname = stripslashes($_POST['user_name']);
$from_date = $_POST['from_date'];
$to_date = $_POST['to_date'];
@$tmp_display_ip = $_POST['tmp_display_ip'];
@$tmp_csv = $_POST['csv'];

$fullname = addslashes($fullname);

// begin post error checking //

if ($fullname != "All") {
$query = "select * from ".$db_prefix."employees where empfullname = '".$fullname."'";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
$empfullname = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");
}
if (!isset($empfullname)) {echo "Something is fishy here.\n"; exit;}
}
$fullname = stripslashes($fullname);

if (($office_name != "All") && (!empty($office_name))) {
$query = "select officename from ".$db_prefix."offices where officename = '".$office_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$getoffice = "".$row['officename']."";
}
if (!isset($getoffice)) {echo "Something smells fishy here.\n"; exit;}
}
if (($group_name != "All") && (!empty($group_name))) {
$query = "select groupname from ".$db_prefix."groups where groupname = '".$group_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$getgroup = "".$row['groupname']."";
}
if (!isset($getgroup)) {echo "Something smells fishy here.\n"; exit;}
}

if (isset($tmp_display_ip)) {
if (($tmp_display_ip != '1') && (!empty($tmp_display_ip))) {
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
                    Choose \"yes\" or \"no\" to the \"<b>Display connecting ip address information?</b>\" question.</td></tr>\n";
echo "            </table>\n";
}}
elseif (isset($tmp_csv)) {
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
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/report.png' />&nbsp;&nbsp;&nbsp;Daily 
                    Time Report</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <input type='hidden' name='date_format' value='$js_datefmt'>\n";
if ($username_dropdown_only == "yes") {

$query = "select * from ".$db_prefix."employees order by empfullname asc";
$result = mysql_query($query);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td colspan=2 align=left width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                  <select name='user_name'>\n";
echo "                    <option value ='All'>All</option>\n";

while ($row=mysql_fetch_array($result)) {
  $empfullname_tmp = stripslashes("".$row['empfullname']."");
  echo "                    <option>$empfullname_tmp</option>\n";
}

echo "                  </select>&nbsp;*</td></tr>\n";
mysql_free_result($result);
} else {

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Choose Office:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='office_name' onchange='group_names();'>\n";
echo "                      </select></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Choose Group:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='group_name' onfocus='group_names();'>
                          <option selected>$group_name</option>\n";
echo "                      </select></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Choose Username:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='user_name' onfocus='user_names();'>
                          <option selected>$fullname</option>\n";
echo "                      </select></td></tr>\n";
}
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
if ($display_ip == "yes") {
echo "              <tr><td class=table_rows height=25 valign=bottom>2.&nbsp;&nbsp;&nbsp;Display connecting ip address information?
                      </td></tr>\n";
if ($tmp_display_ip == "1") {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='tmp_display_ip' value='1'
                      checked>&nbsp;Yes<input type='radio' name='tmp_display_ip' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "              <tr><td class=table_rows align=left nowrap style='padding-left:15px;'><input type='radio' name='tmp_display_ip' value='1' >&nbsp;Yes
                      <input type='radio' name='tmp_display_ip' value='0' checked>&nbsp;No</td></tr>\n";
}
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

$tmp_fullname = stripslashes($fullname);
if ((strtolower($user_or_display) == "display") && ($tmp_fullname != "All")) {
$tmp_fullname = stripslashes($displayname);
}
if (($office_name == "All") && ($group_name == "All") && ($tmp_fullname == 'All')) {$tmp_fullname = "Offices: All --> Groups: All --> Users: All";}
elseif ((empty($office_name)) && (empty($group_name)) && ($tmp_fullname == 'All'))  {$tmp_fullname = "All Users";}
elseif ((empty($office_name)) && (empty($group_name)) && ($tmp_fullname != 'All'))  {$tmp_fullname = $tmp_fullname;}
elseif (($office_name != "All") && ($group_name == "All") && ($tmp_fullname == 'All')) {$tmp_fullname = "Office: $office_name --> Groups: All -->
 Users: All";}
elseif (($office_name != "All") && ($group_name != "All") && ($tmp_fullname == 'All')) {$tmp_fullname = "Office: $office_name --> Group: $group_name -->
 Users: All";}
$rpt_name="$tmp_fullname";

echo "            <table width=100% align=center class=misc_items border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><td width=80% style='font-size:9px;color:#000000;padding-left:10px;'>Run on: $rpt_time, $rpt_date</td><td nowrap
                      style='font-size:9px;color:#000000;'>$rpt_name</td></tr>\n";
echo "               <tr><td width=80%></td><td nowrap style='font-size:9px;color:#000000;'>Date Range: $from_date - $to_date</td></tr>\n";
if (!empty($tmp_csv)) {
  echo "               <tr class=notprint><td width=80%></td><td nowrap style='font-size:9px;color:#000000;'><a style='color:#27408b;font-size:9px;
                         text-decoration:underline;' 
                         href=\"get_csv.php?rpt=timerpt&display_ip=$tmp_display_ip&csv=$tmp_csv&office=$office_name&group=$group_name&fullname=$fullname&from=$from_timestamp&to=$to_timestamp&tzo=$tzo\">Download CSV File</a></td></tr>\n"; 
}
echo "            </table>\n";

$employees_cnt = 0;
$employees_empfullname = array();
$employees_displayname = array();
$row_count = 0;
$page_count = 0;

// retrieve a list of users //

$fullname = addslashes($fullname);

if (strtolower($user_or_display) == "display") {

    if (($office_name == "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname == 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname != 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL and empfullname = '".$fullname."' order by 
                  displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and tstamp IS NOT NULL order by 
                  displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."'  and 
                  tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname != "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."' and
                  empfullname = '".$fullname."' and tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);
    }

} else {

    if (($office_name == "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname == 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname != 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL and empfullname = '".$fullname."' order by 
                  empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and tstamp IS NOT NULL order by 
                  empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."'  and 
                  tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname != "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."' and
                  empfullname = '".$fullname."' and tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);
    }
}

while ($row=mysql_fetch_array($result)) {

  $employees_empfullname[] = stripslashes("".$row['empfullname']."");
  $employees_displayname[] = stripslashes("".$row['displayname']."");
  $employees_cnt++;
}
for ($x=0;$x<$employees_cnt;$x++) {

    $fullname = stripslashes($fullname);
    if (($employees_empfullname[$x] == $fullname) || ($fullname == "All")) {

        $row_color = $color2; // Initial row color

        $employees_empfullname[$x] = addslashes($employees_empfullname[$x]);
        $employees_displayname[$x] = addslashes($employees_displayname[$x]);

        $query = "select ".$db_prefix."info.fullname, ".$db_prefix."info.`inout`, ".$db_prefix."info.timestamp, ".$db_prefix."info.notes, 
                  ".$db_prefix."info.ipaddress, ".$db_prefix."punchlist.in_or_out, ".$db_prefix."punchlist.punchitems, ".$db_prefix."punchlist.color
                  from ".$db_prefix."info, ".$db_prefix."punchlist, ".$db_prefix."employees
                  where ".$db_prefix."info.fullname like ('".$employees_empfullname[$x]."') and ".$db_prefix."info.timestamp >= '".$from_timestamp."'
                  and ".$db_prefix."info.timestamp <= '".$to_timestamp."' and ".$db_prefix."info.`inout` = ".$db_prefix."punchlist.punchitems 
                  and ".$db_prefix."employees.empfullname = '".$employees_empfullname[$x]."' and ".$db_prefix."employees.empfullname <> 'admin'
                  order by ".$db_prefix."info.timestamp asc";
        $result = mysql_query($query);

        while ($row=mysql_fetch_array($result)) {

            $display_stamp = "".$row["timestamp"]."";
            $time = date($timefmt, $display_stamp);
            $date = date($datefmt, $display_stamp);

            if ($row_count == 0) {
                if ($page_count == 0) {

                    echo "            <table class=misc_items width=100% border=0 cellpadding=2 cellspacing=0>\n";
                    echo "              <tr class=notprint>\n";
                    echo "                <td nowrap width=20% align=left style='padding-left:10px;padding-right:10px;font-size:11px;color:#27408b;
                    text-decoration:underline;'>Name</td>\n";
                    echo "                <td nowrap width=7% align=left style='padding-left:10px;font-size:11px;color:#27408b;
                    text-decoration:underline;'>In/Out</td>\n";
                    echo "                <td nowrap width=5% align=right style='padding-right:10px;font-size:11px;color:#27408b;
                    text-decoration:underline;'>Time</td>\n";
                    echo "                <td nowrap width=5% align=right style='padding-left:10px;font-size:11px;color:#27408b;
                    text-decoration:underline;'>Date</td>\n";
                    if ($tmp_display_ip == "1") {
                        echo "                <td nowrap width=15% align=left style='padding-left:10px;font-size:11px;color:#27408b;
                        text-decoration:underline;'>Originating IP</td>\n";
                    }
                    echo "                <td style='padding-left:10px;'><a style='font-size:11px;color:#27408b;text-decoration:underline;'>Notes</td>\n";

                } else {

                    // display report name and page number of printed report above the column headings of each printed page //

                    $temp_page_count = $page_count + 1;
                    echo "              <tr><td colspan=2 class=notdisplay style='font-size:9px;color:#000000;padding-left:10px;'>Run on: $rpt_time,
                      $rpt_date (page $temp_page_count)</td><td class=notdisplay nowrap style='font-size:9px;color:#000000;'
                      align=right colspan=4>$rpt_name</td></tr>\n";
                    echo "              <tr><td class=notdisplay align=right colspan=6 nowrap style='font-size:9px;color:#000000;'>
                      Date Range: $from_date - $to_date</td></tr>\n";
                }
                echo "              <tr class=notdisplay>\n";
                echo "                <td nowrap width=20% align=left style='padding-left:10px;padding-right:10px;font-size:11px;color:#27408b;
                    text-decoration:underline;'>Name</td>\n";
                echo "                <td nowrap width=7% align=left
                    style='padding-left:10px;font-size:11px;color:#27408b;text-decoration:underline;'>In/Out</td>\n";
                echo "                <td nowrap width=5% align=right
                    style='padding-right:10px;font-size:11px;color:#27408b;text-decoration:underline;'>Time</td>\n";
                echo "                <td nowrap width=5% align=right
                    style='padding-left:10px;font-size:11px;color:#27408b;text-decoration:underline;'>Date</td>\n";
                if ($tmp_display_ip == "1") {
                    echo "                <td nowrap width=15% align=left
                        style='padding-left:10px;font-size:11px;color:#27408b;text-decoration:underline;'>Originating IP</td>\n";
                }
                echo "                <td style='padding-left:10px;'><a style='font-size:11px;color:#27408b;text-decoration:underline;'>Notes</td>\n";
                echo "              </tr>\n";
            }

            // begin alternating row colors //
  
            $row_color = ($row_count % 2) ? $color1 : $color2;
  
            // display the query results //

            $display_stamp = $display_stamp + @$tzo;
            $time = date($timefmt, $display_stamp);
            $date = date($datefmt, $display_stamp);
  
            if (strtolower($user_or_display) == "display") {
                echo stripslashes("              <tr class=display_row><td nowrap width=20% bgcolor='$row_color' style='padding-left:10px;
                      padding-right:10px;'>$employees_displayname[$x]</td>\n");
            } else {
                echo stripslashes("              <tr class=display_row><td nowrap width=20% bgcolor='$row_color' style='padding-left:10px;
                      padding-right:10px;'>$employees_empfullname[$x]</td>\n");
            }
            echo "                <td nowrap align=left width=7% style='background-color:$row_color;color:".$row["color"].";
                  padding-left:10px;'>".$row["inout"]."</td>\n";
            echo "                <td nowrap align=right width=5% bgcolor='$row_color' style='padding-right:10px;'>".$time."</td>\n";
            echo "                <td nowrap align=right width=5% bgcolor='$row_color' style='padding-left:10px;'>".$date."</td>\n";
            if ($tmp_display_ip == "1") {
                echo "                <td nowrap align=left width=15% style='background-color:$row_color;color:".$row["color"].";
                      padding-left:10px;'>".$row["ipaddress"]."</td>\n";
            }
            echo stripslashes("                <td bgcolor='$row_color' style='padding-left:10px;'>".$row["notes"]."</td>\n");
            echo "              </tr>\n";

            $row_count++;

            // output 40 rows per printed page //

            if ($row_count == 40) {
                echo "              <tr style=\"page-break-before:always;\"></tr>\n";
                $row_count = 0;
                $page_count++;
            }
        }
    }
}
}
exit;
?>
