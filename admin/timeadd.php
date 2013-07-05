<?php
session_start();

include '../config.inc.php';
include 'header_date.php';
include 'topmain.php';
echo "<title>$title - Add Time</title>\n";

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

if (($timefmt == "G:i") || ($timefmt == "H:i")) {
  $timefmt_24hr = '1';
  $timefmt_24hr_text = '24 hr format';
  $timefmt_size = '5';
} else {
  $timefmt_24hr = '0';
  $timefmt_24hr_text = '12 hr format';
  $timefmt_size = '8';
}

if ((!isset($_SESSION['valid_user'])) && (!isset($_SESSION['time_admin_valid_user']))) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Administration</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>You are not presently logged in, or do not have permission to view this page.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='../login.php'><u>here</u></a> to login.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

if ($request == 'GET') {

if (!isset($_GET['username'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Error!</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=300 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>How did you get here?</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Go back to the <a class=admin_headings href='timeadmin.php'>Add/Edit/Delete Time</a> page to 
                add a time.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

$get_user = stripslashes($_GET['username']);

disabled_acct($get_user);

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user_add.png' alt='Create New User' />&nbsp;&nbsp;
                <a class=admin_headings href='usercreate.php'>Create New User</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/magnifier.png' alt='User Search' />&nbsp;&nbsp;
                <a class=admin_headings href='usersearch.php'>User Search</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Offices</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/brick.png' alt='Office Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='officeadmin.php'>Office Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />&nbsp;&nbsp;
                <a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Groups</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group.png' alt='Group Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='groupadmin.php'>Group Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />&nbsp;&nbsp;
                <a class=admin_headings href='groupcreate.php'>Create New Group</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle colspan=2>In/Out Status</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application.png' alt='Status Summary' />
                &nbsp;&nbsp;<a class=admin_headings href='statusadmin.php'>Status Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_add.png' alt='Create Status' />&nbsp;&nbsp;
                <a class=admin_headings href='statuscreate.php'>Create Status</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle colspan=2>Miscellaneous</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/clock.png' alt='Add/Edit/Delete Time' />
                &nbsp;&nbsp;<a class=admin_headings href='timeadmin.php'>Add/Edit/Delete Time</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Add Time' />
                &nbsp;&nbsp;<a class=admin_headings href=\"timeadd.php?username=$get_user\">Add Time</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Time' />
                &nbsp;&nbsp;<a class=admin_headings href=\"timeedit.php?username=$get_user\">Edit Time</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Time' />
                &nbsp;&nbsp;<a class=admin_headings href=\"timedelete.php?username=$get_user\">Delete Time</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/application_edit.png' 
                alt='Edit System Settings' /> &nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";

$get_user = addslashes($get_user);

$query = "select * from ".$db_prefix."employees where empfullname = '".$get_user."' order by empfullname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$username = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");
}
mysql_free_result($result);

$get_user = stripslashes($_GET['username']);

echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post' onsubmit=\"return isDate()\">\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/clock_add.png' />&nbsp;&nbsp;&nbsp;Add Time
                    </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "                <input type='hidden' name='date_format' value='$js_datefmt'>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>
                      <input type='hidden' name='post_username' value=\"$username\">$username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>
                      <input type='hidden' name='post_displayname' value=\"$displayname\">$displayname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Date: ($tmp_datefmt)</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text'
                      size='10' maxlength='10' name='post_date'>&nbsp;*&nbsp;&nbsp;&nbsp;<a href=\"#\" 
                      onclick=\"form.post_date.value='';cal.select(document.forms['form'].post_date,'post_date_anchor','$js_datefmt'); 
                      return false;\" name=\"post_date_anchor\" id=\"post_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='10' maxlength='$timefmt_size' name='post_time'>&nbsp;*&nbsp;&nbsp;
                      <a style='text-decoration:none;font-size:11px;color:#27408b;'>($timefmt_24hr_text)</a></td></tr>\n";
echo "                <input type='hidden' name='get_user' value=\"$get_user\">\n";
echo "                <input type='hidden' name='timefmt_24hr' value=\"$timefmt_24hr\">\n";
echo "                <input type='hidden' name='timefmt_24hr_text' value=\"$timefmt_24hr_text\">\n";
echo "                <input type='hidden' name='timefmt_size' value=\"$timefmt_size\">\n";

// query to populate dropdown with statuses //

$query2 = "select * from ".$db_prefix."punchlist order by punchitems asc";
$result2 = mysql_query($query2);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Status:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='post_statusname'>\n";
echo "                        <option value ='1'>Choose One</option>\n";

while ($row2=mysql_fetch_array($result2)) {
  echo "                        <option>".$row2['punchitems']."</option>\n";
}
echo "                      </select>&nbsp;*</td></tr>\n";
mysql_free_result($result2);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Notes:</td><td align=left colspan=2 width=80% 
                      style='padding-left:20px;'><input type='text' size='17' maxlength='250' name='post_notes'></td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <div style=\"position:absolute;visibility:hidden;background-color:#ffffff;layer-background-color:#ffffff;\" id=\"mydiv\"
                 height=200>&nbsp;</div>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Add Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='timeadmin.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php'; exit;
}

elseif ($request == 'POST') {

$get_user = stripslashes($_POST['get_user']);
$post_username = stripslashes($_POST['post_username']);
$post_displayname = stripslashes($_POST['post_displayname']);
$post_date = $_POST['post_date'];
$post_time = $_POST['post_time'];
$post_statusname = $_POST['post_statusname'];
$post_notes = $_POST['post_notes'];
$timefmt_24hr = $_POST['timefmt_24hr'];
$timefmt_24hr_text = $_POST['timefmt_24hr_text'];
$timefmt_size = $_POST['timefmt_size'];
$date_format = $_POST['date_format'];

$get_user = addslashes($get_user);
$post_username = addslashes($post_username);
$post_displayname = addslashes($post_displayname);

// begin post validation //

if (!empty($get_user)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$get_user."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_get_user = "".$row['empfullname']."";
}
if (!isset($tmp_get_user)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($post_username)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_username = "".$row['empfullname']."";
}
if (!isset($tmp_username)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($post_displayname)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."' and displayname = '".$post_displayname."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_post_displayname = "".$row['displayname']."";
}
if (!isset($tmp_post_displayname)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($post_statusname)) {
  if ($post_statusname != '1') {

    $query = "select * from ".$db_prefix."punchlist where punchitems = '".$post_statusname."'";
    $result = mysql_query($query);

    while ($row=mysql_fetch_array($result)) {
      $punchitems = "".$row['punchitems']."";
      $color = "".$row['color']."";
    }
    mysql_free_result($result);
    if (!isset($punchitems)) {echo "Something is fishy here.\n"; exit;}
  } else {
    $punchitems = '1';
  }
}

if (($timefmt == "G:i") || ($timefmt == "H:i")) {
  $tmp_timefmt_24hr = '1';
  $tmp_timefmt_24hr_text = '24 hr format';
  $tmp_timefmt_size = '5';
} else {
  $tmp_timefmt_24hr = '0';
  $tmp_timefmt_24hr_text = '12 hr format';
  $tmp_timefmt_size = '8';
}

if (($timefmt_24hr != $tmp_timefmt_24hr) || ($timefmt_24hr_text != $tmp_timefmt_24hr_text) || ($timefmt_size != $tmp_timefmt_size)) {
  echo "Something is fishy here.\n"; exit;
}
if ($date_format != $js_datefmt) {echo "Something is fishy here.\n"; exit;}

$post_notes = ereg_replace("[^[:alnum:] \,\.\?-]","",$post_notes);
if ($post_notes == "") {$post_notes = " ";}

// end post validation //

//if ($get_user != $post_username) {exit;}
//if (($timefmt_24hr !== '0') && ($timefmt_24hr !== '1')) {exit;}
//if (($timefmt_24hr_text !== '24 hr format') && ($timefmt_24hr_text !== '12 hr format')) {exit;}
//if (($timefmt_size != '5') && ($timefmt_size != '7')) {exit;}

$get_user = stripslashes($get_user);
$post_username = stripslashes($post_username);
$post_displayname = stripslashes($post_displayname);

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user_add.png' alt='Create New User' />&nbsp;&nbsp;
                <a class=admin_headings href='usercreate.php'>Create New User</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/magnifier.png' alt='User Search' />&nbsp;&nbsp;
                <a class=admin_headings href='usersearch.php'>User Search</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Offices</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/brick.png' alt='Office Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='officeadmin.php'>Office Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />&nbsp;&nbsp;
                <a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Groups</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group.png' alt='Group Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='groupadmin.php'>Group Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />&nbsp;&nbsp;
                <a class=admin_headings href='groupcreate.php'>Create New Group</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle colspan=2>In/Out Status</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application.png' alt='Status Summary' />
                &nbsp;&nbsp;<a class=admin_headings href='statusadmin.php'>Status Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_add.png' alt='Create Status' />&nbsp;&nbsp;
                <a class=admin_headings href='statuscreate.php'>Create Status</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle colspan=2>Miscellaneous</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/clock.png' alt='Add/Edit/Delete Time' />
                &nbsp;&nbsp;<a class=admin_headings href='timeadmin.php'>Add/Edit/Delete Time</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Add Time' />
                &nbsp;&nbsp;<a class=admin_headings href=\"timeadd.php?username=$get_user\">Add Time</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Time' />
                &nbsp;&nbsp;<a class=admin_headings href=\"timeedit.php?username=$get_user\">Edit Time</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Time' />
                &nbsp;&nbsp;<a class=admin_headings href=\"timedelete.php?username=$get_user\">Delete Time</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/application_edit.png' 
                alt='Edit System Settings' /> &nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <br />\n";

if ((empty($post_date)) || (empty($post_time)) || ($post_statusname == '1') || (!eregi ("^([[:alnum:]]| |-|_|\.)+$", $post_statusname)) ||
(!eregi ("^([0-9]{1,2})[-,/,.]([0-9]{1,2})[-,/,.](([0-9]{2})|([0-9]{4}))$", $post_date))) { 
$evil_post = '1';
if (empty($post_date)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Date is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (empty($post_time)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Time is required.</td></tr>\n";
echo "            </table>\n";
}
elseif ($post_statusname == "1") {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A Status must be chosen.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([[:alnum:]]| |-|_|\.)+$", $post_statusname)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Alphanumeric characters, hyphens, underscores, spaces, and periods are allowed in a Status Name.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([0-9]{1,2})[-,/,.]([0-9]{1,2})[-,/,.](([0-9]{2})|([0-9]{4}))$", $post_date)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Date is required.</td></tr>\n";
echo "            </table>\n";
}
} // end if

elseif ($timefmt_24hr == '0') {

if ((!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+([a|p]+m)$", $post_time, $time_regs)) && (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+( [a|p]+m)$", $post_time, 
$time_regs))) {
$evil_time = '1';
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Time is required.</td></tr>\n";
echo "            </table>\n";

} else {

if (isset($time_regs)) {$h = $time_regs[1]; $m = $time_regs[2];}
$h = $time_regs[1]; $m = $time_regs[2];
if (($h > 12) || ($m > 59)) {
$evil_time = '1';
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Time is required.</td></tr>\n";
echo "            </table>\n";
}}}

elseif ($timefmt_24hr == '1') {
if (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])$", $post_time, $time_regs)) {
$evil_time = '1';
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Time is required.</td></tr>\n";
echo "            </table>\n";

} else {

if (isset($time_regs)) {$h = $time_regs[1]; $m = $time_regs[2];}
$h = $time_regs[1]; $m = $time_regs[2];
if (($h > 24) || ($m > 59)) {
$evil_time = '1';
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Time is required.</td></tr>\n";
echo "            </table>\n";
}}}

if (eregi ("^([0-9]{1,2})[-,/,.]([0-9]{1,2})[-,/,.](([0-9]{2})|([0-9]{4}))$", $post_date, $date_regs)) {
if ($calendar_style == "amer") {
if (isset($date_regs)) {$month = $date_regs[1]; $day = $date_regs[2]; $year = $date_regs[3];}
if ($month > 12 || $day > 31) {
$evil_date = '1';
if (!isset($evil_post)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Date is required.</td></tr>\n";
echo "            </table>\n";
}}} 

elseif ($calendar_style == "euro") {
if (isset($date_regs)) {$month = $date_regs[2]; $day = $date_regs[1]; $year = $date_regs[3];}
if ($month > 12 || $day > 31) {
$evil_date = '1';
if (!isset($evil_post)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A valid Date is required.</td></tr>\n";
echo "            </table>\n";
}}}}

if ((isset($evil_post)) || (isset($evil_date)) || (isset($evil_time))) {
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post' onsubmit=\"return isDate()\">\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/clock_add.png' />&nbsp;&nbsp;&nbsp;Add Time
                    </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "                <input type='hidden' name='date_format' value='$js_datefmt'>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>
                      <input type='hidden' name='post_username' value=\"$post_username\">$post_username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>
                      <input type='hidden' name='post_displayname' value=\"$post_displayname\">$post_displayname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Date:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text'
                      size='10' maxlength='10' name='post_date' value='$post_date'>&nbsp;*&nbsp;&nbsp;&nbsp;<a href=\"#\"
                      onclick=\"cal.select(document.forms['form'].post_date,'post_date_anchor','$js_datefmt');
                      return false;\" name=\"post_date_anchor\" id=\"post_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='10' maxlength='$timefmt_size' name='post_time' value='$post_time'>&nbsp;*&nbsp;&nbsp;
                      <a style='text-decoration:none;font-size:11px;color:#27408b;'>($timefmt_24hr_text)</a></td></tr>\n";
echo "                <input type='hidden' name='get_user' value=\"$get_user\">\n";
echo "                <input type='hidden' name='timefmt_24hr' value=\"$timefmt_24hr\">\n";
echo "                <input type='hidden' name='timefmt_24hr_text' value=\"$timefmt_24hr_text\">\n";
echo "                <input type='hidden' name='timefmt_size' value=\"$timefmt_size\">\n";

// query to populate dropdown with statuses //

$query2 = "select * from ".$db_prefix."punchlist order by punchitems asc";
$result2 = mysql_query($query2);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Status:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='post_statusname'>\n";
echo "                        <option value ='1'>Choose One</option>\n";

while ($row2=mysql_fetch_array($result2)) {
  if ($post_statusname == "".$row2['punchitems']."") {
    echo "                        <option selected>".$row2['punchitems']."</option>\n";
  } else {
    echo "                        <option>".$row2['punchitems']."</option>\n";
}}
echo "                      </select>&nbsp;*</td></tr>\n";
mysql_free_result($result2);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Notes:</td><td align=left colspan=2 width=80% 
                      style='padding-left:20px;'><input type='text' size='17' maxlength='250' name='post_notes' value='$post_notes'></td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <div style=\"position:absolute;visibility:hidden;background-color:#ffffff;layer-background-color:#ffffff;\" id=\"mydiv\"
                 height=200>&nbsp;</div>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Add Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='timeadmin.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n";include '../footer.php';
exit;

} else {

$post_username = addslashes($post_username);
$post_displayname = addslashes($post_displayname);

// configure timestamp to insert/update

if ($calendar_style == "euro") {
//  $post_date = "$day/$month/$year";
  $post_date = "$month/$day/$year";
}
elseif ($calendar_style == "amer") {
  $post_date = "$month/$day/$year";
}

$timestamp = strtotime($post_date . " " . $post_time) - $tzo;

// check for duplicate time for $post_username

$query = "select * from ".$db_prefix."info where fullname = '".$post_username."'";
$result = mysql_query($query);

$post_username = stripslashes($post_username);
$post_displayname = stripslashes($post_displayname);

while ($row=mysql_fetch_array($result)) {

$info_table_timestamp = "".$row['timestamp']."";
if ($timestamp == $info_table_timestamp) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Duplicate time exists for this user on this date. Time not added..</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post' onsubmit=\"return isDate()\">\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/clock_add.png' />&nbsp;&nbsp;&nbsp;Add Time
                    </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "                <input type='hidden' name='date_format' value='$js_datefmt'>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>
                      <input type='hidden' name='post_username' value=\"$post_username\">$post_username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>
                      <input type='hidden' name='post_displayname' value=\"$post_displayname\">$post_displayname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Date:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text'
                      size='10' maxlength='10' name='post_date' value='$post_date'>&nbsp;*&nbsp;&nbsp;&nbsp;<a href=\"#\"
                      onclick=\"cal.select(document.forms['form'].post_date,'post_date_anchor','$js_datefmt');
                      return false;\" name=\"post_date_anchor\" id=\"post_date_anchor\" style='font-size:11px;color:#27408b;'>Pick Date</a></td><tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='10' maxlength='$timefmt_size' name='post_time' value='$post_time'>&nbsp;*&nbsp;&nbsp;
                      <a style='text-decoration:none;font-size:11px;color:#27408b;'>($timefmt_24hr_text)</a></td></tr>\n";
echo "                <input type='hidden' name='get_user' value=\"$get_user\">\n";
echo "                <input type='hidden' name='timefmt_24hr' value=\"$timefmt_24hr\">\n";
echo "                <input type='hidden' name='timefmt_24hr_text' value=\"$timefmt_24hr_text\">\n";
echo "                <input type='hidden' name='timefmt_size' value=\"$timefmt_size\">\n";

// query to populate dropdown with statuses //

$query2 = "select * from ".$db_prefix."punchlist order by punchitems asc";
$result2 = mysql_query($query2);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Status:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='post_statusname'>\n";
echo "                        <option value ='1'>Choose One</option>\n";

while ($row2=mysql_fetch_array($result2)) {
  if ($post_statusname == "".$row2['punchitems']."") {
    echo "                        <option selected>".$row2['punchitems']."</option>\n";
  } else {
    echo "                        <option>".$row2['punchitems']."</option>\n";
}}
echo "                      </select>&nbsp;*</td></tr>\n";
mysql_free_result($result2);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Notes:</td><td align=left colspan=2 width=80% 
                      style='padding-left:20px;'><input type='text' size='17' maxlength='250' name='post_notes' value='$post_notes'></td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <div style=\"position:absolute;visibility:hidden;background-color:#ffffff;layer-background-color:#ffffff;\" id=\"mydiv\"
                 height=200>&nbsp;</div>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Add Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='timeadmin.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n";include '../footer.php';
exit;
  }
}
mysql_free_result($result);

// check to see if this would be the most recent time for $post_username. if so, run the update query for the employees table.

$post_username = addslashes($post_username);
$post_displayname = addslashes($post_displayname);

$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."'";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
  $employees_table_timestamp = "".$row['tstamp']."";
}
mysql_free_result($result);

if ($timestamp > $employees_table_timestamp) {
$update_query = "update ".$db_prefix."employees set tstamp = '".$timestamp."' where empfullname = '".$post_username."'";
$update_result = mysql_query($update_query);
}

// determine who the authenticated user is for audit log

if (isset($_SESSION['valid_user'])) {$user = $_SESSION['valid_user'];}
elseif (isset($_SESSION['time_admin_valid_user'])) {$user = $_SESSION['time_admin_valid_user'];} 
else {$user = "";}

// configure current time to insert for audit log

$time = time();
$time_hour = gmdate('H', $time);
$time_min = gmdate('i', $time);
$time_sec = gmdate('s', $time);
$time_month = gmdate('m', $time);
$time_day = gmdate('d', $time);
$time_year = gmdate('Y', $time);
$time_tz_stamp = mktime ($time_hour, $time_min, $time_sec, $time_month, $time_day, $time_year);

// this needs to be changed later
$post_why = "";

// add the time to the info table for $post_username

$query = "insert into ".$db_prefix."info (fullname, `inout`, timestamp, notes) values ('".$post_username."', '".$post_statusname."', '".$timestamp."', 
          '".$post_notes."')";
$result = mysql_query($query);

// add the results to the audit table 

if (strtolower($ip_logging) == "yes") {
$query2 = "insert into ".$db_prefix."audit (modified_by_ip, modified_by_user, modified_when, modified_from, modified_to, modified_why, user_modified) values 
           ('".$connecting_ip."', '".$user."', '".$time_tz_stamp."', '0', '".$timestamp."', '".$post_why."', '".$post_username."')";
$result2 = mysql_query($query2);
} else {
$query2 = "insert into ".$db_prefix."audit (modified_by_user, modified_when, modified_from, modified_to, modified_why, user_modified) values 
           ('".$user."', '".$time_tz_stamp."', '0', '".$timestamp."', '".$post_why."', '".$post_username."')";
$result2 = mysql_query($query2);
}

$post_username = stripslashes($post_username);
$post_displayname = stripslashes($post_displayname);
$post_date = date($datefmt, $timestamp + $tzo);

echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "              <td class=table_rows width=20 align=center><img src='../images/icons/accept.png' /></td><td class=table_rows_green>
                  &nbsp;Time added successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post' onsubmit=\"return isDate();\">\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/clock_add.png' />&nbsp;&nbsp;&nbsp;Add Time
                    </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
colspan=2 width=80% style='padding-left:20px;'>$post_username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows 
colspan=2 width=80% style='padding-left:20px;'>$post_displayname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Date:</td><td align=left class=table_rows 
colspan=2 width=80% style='padding-left:20px;'>$post_date</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time:</td><td align=left class=table_rows 
colspan=2 width=80% style='padding-left:20px;'>$post_time</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Status:</td><td align=left class=table_rows colspan=2 
width=80% style='color:$color;padding-left:20px;'>$post_statusname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Notes:</td><td align=left class=table_rows 
colspan=2 width=80% style='padding-left:20px;'>$post_notes</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=20 align=left>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='timeadmin.php'><img src='../images/buttons/done_button.png' border='0'></td></tr></table></td></tr>\n";
include '../footer.php';
exit;
}
}
?>
