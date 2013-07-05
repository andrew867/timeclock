<?php
session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

include '../config.inc.php';
if ($request !== 'POST') {include 'header_get.php';include 'topmain.php';}
echo "<title>$title - Edit User</title>\n";

if (!isset($_SESSION['valid_user'])) {

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
echo "        <tr class=right_main_text><td align=center>Go back to the <a class=admin_headings href='useradmin.php'>User Summary</a> page to edit users.
                </td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

$get_user = $_GET['username'];
@$get_office = $_GET['officename'];

if (get_magic_quotes_gpc()) {$get_user = stripslashes($get_user);}

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />
                &nbsp;&nbsp;<a class=admin_headings href=\"useredit.php?username=$get_user&officename=$get_office\">Edit User</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
                &nbsp;&nbsp;<a class=admin_headings href=\"chngpasswd.php?username=$get_user&officename=$get_office\">Change Password</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete User' />
                &nbsp;&nbsp;<a class=admin_headings href=\"userdelete.php?username=$get_user&officename=$get_office\">Delete User</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/user_add.png' alt='Create New User' />
                &nbsp;&nbsp;<a class=admin_headings href='usercreate.php'>Create New User</a></td></tr>\n";
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
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png' alt='Edit System Settings' />
                &nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";

$get_user = addslashes($get_user);

$row_count = 0;

$query = "select * from ".$db_prefix."employees where empfullname = '".$get_user."' order by empfullname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

$username = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");
$user_email = "".$row['email']."";
$groups_tmp = "".$row['groups']."";
$office = "".$row['office']."";
$admin = "".$row['admin']."";
$reports = "".$row['reports']."";
$time_admin = "".$row['time_admin']."";
$disabled = "".$row['disabled']."";
}
mysql_free_result($result);

// make sure you cannot edit the admin perms for the last admin user in the system!! //

if (!empty($admin)) {
  $admin_count = mysql_query("select empfullname from ".$db_prefix."employees where admin = '1'");
  @$admin_count_rows = mysql_num_rows($admin_count);
  if (@$admin_count_rows == "1") {
    $evil = "1";
  }
}
if (isset($evil)) {
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Cannot edit the Sys Admin properties of this user as this user is the last Sys Admin User in the system. Go back and give another user
                    Sys Admin privileges before attempting to edit the Sys Admin properties of this user.</td></tr>\n";
echo "            </table>\n";
}
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/user_edit.png' />&nbsp;&nbsp;&nbsp;Edit User</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'><input type='hidden' name='post_username' value=\"$username\">$username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='25' maxlength='50' name='display_name' value=\"$displayname\">&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Email Address:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='25' maxlength='75' name='email_addy' value='$user_email'>&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='office_name' onchange='group_names();'>
                        <option selected>$office</option>\n";
echo "                      </select>&nbsp;*</td></tr>\n";
if ($groups_tmp == "") {
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='group_name' onfocus='group_names();'>
                        <option selected>&nbsp;</option>\n";
} else {
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='group_name' onfocus='group_names();'>
                        <option selected>$groups_tmp</option>\n";
}
echo "                      </select>&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Sys Admin User?</td>\n";

if (isset($evil)) {
if ($admin == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input disabled type='radio' name='admin_perms' value='1' 
                      checked>&nbsp;Yes&nbsp;<input disabled type='radio' name='admin_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input disabled type='radio' name='admin_perms' value='1'
                      >&nbsp;Yes&nbsp;<input disabled type='radio' name='admin_perms' value='0' checked>&nbsp;No</td></tr>\n";
}
} else {
if ($admin == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='admin_perms' value='1' 
                      checked>&nbsp;Yes&nbsp;<input type='radio' name='admin_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='admin_perms' value='1'
                      >&nbsp;Yes&nbsp;<input type='radio' name='admin_perms' value='0' checked>&nbsp;No</td></tr>\n";
}}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time Admin User?</td>\n";
if ($time_admin == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='time_admin_perms' value='1' 
                      checked>&nbsp;Yes&nbsp;<input type='radio' name='time_admin_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='time_admin_perms' value='1'>&nbsp;Yes
                      <input type='radio' name='time_admin_perms' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Reports User?</td>\n";
if ($reports == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='reports_perms' value='1' 
                      checked>&nbsp;Yes&nbsp;<input type='radio' name='reports_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='reports_perms' value='1'>&nbsp;Yes
                      <input type='radio' name='reports_perms' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Account Disabled?</td>\n";
if ($disabled == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='disabled' value='1' 
                      checked>&nbsp;Yes&nbsp;<input type='radio' name='disabled' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='disabled' value='1'>&nbsp;Yes
                      <input type='radio' name='disabled' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
if (isset($evil)) {
  echo "<input type='hidden' name='evil' value='$evil'>\n";
}
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "                  <input type='hidden' name='get_office' value='$get_office'>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit User' align='middle' 
                      src='../images/buttons/next_button.png'></td><td><a href='useradmin.php'><img src='../images/buttons/cancel_button.png' 
                      border='0'></td></tr></table></form></td></tr>\n";include '../footer.php'; exit;
}

elseif ($request == 'POST') {

include 'header_post.php';include 'topmain.php';

$post_username = stripslashes($_POST['post_username']);
$display_name = stripslashes($_POST['display_name']);
$email_addy = $_POST['email_addy'];
$office_name = $_POST['office_name'];
@$get_office = $_POST['get_office'];	
@$group_name = $_POST['group_name'];
@$admin_perms = $_POST['admin_perms'];
$reports_perms = $_POST['reports_perms'];
$time_admin_perms = $_POST['time_admin_perms'];
$post_disabled = $_POST['disabled'];
@$evil = $_POST['evil'];

if (isset($evil)) {
  if ($evil != '1') {echo "Something is fishy here."; exit;}
}

if (isset($evil)) {$admin_perms = "1";}
$post_username = addslashes($post_username);

if (!empty($post_username)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_username = "".$row['empfullname']."";
}
if (!isset($tmp_username)) {echo "$tmp_username, $post_username. Something is fishy here.\n"; exit;}
}

$post_username = stripslashes($post_username);
$tmp_post_username = stripslashes($post_username);
$string = strstr($display_name, "\"");

if ((!eregi ("^([[:alnum:]]| |-|'|,)+$", $display_name)) || (empty($display_name)) || (empty($email_addy)) || (empty($office_name)) || (empty($group_name)) ||
(!eregi ("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $email_addy)) || (($admin_perms != '1') && (!empty($admin_perms))) ||
(($reports_perms != '1') && (!empty($reports_perms))) || (($time_admin_perms != '1') && (!empty($time_admin_perms))) || (($post_disabled != '1') && 
(!empty($post_disabled))) || (!empty($string))) {

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />
                &nbsp;&nbsp;<a class=admin_headings href=\"useredit.php?username=$tmp_post_username&officename=$get_office\">Edit User</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
                &nbsp;&nbsp;<a class=admin_headings href=\"chngpasswd.php?username=$tmp_post_username&officename=$get_office\">Change Password</a></td>
                </tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete User' />
                &nbsp;&nbsp;<a class=admin_headings href=\"userdelete.php?username=$tmp_post_username&officename=$get_office\">Delete User</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/user_add.png' alt='Create New User' />
                &nbsp;&nbsp;<a class=admin_headings href='usercreate.php'>Create New User</a></td></tr>\n";
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
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png' alt='Edit System Settings' />
                &nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <br />\n";

// begin post validation //

if (empty($display_name)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A Display Name is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (empty($email_addy)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    An Email Address is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (empty($office_name)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    An Office is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (empty($group_name)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A Group is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (!empty($string)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Double Quotes are not allowed when creating an Username.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([[:alnum:]]| |-|'|,)+$", $display_name)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Alphanumeric characters, hyphens, apostrophes, commas, and spaces are allowed when creating a Display Name.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $email_addy)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Alphanumeric characters, underscores, periods, and hyphens are allowed when creating an Email Address.</td></tr>\n";
echo "            </table>\n";
}
elseif (($admin_perms != '1') && (!empty($admin_perms))) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Choose \"yes\" or \"no\" for Sys Admin Perms.</td></tr>\n";
echo "            </table>\n";
}
elseif (($reports_perms != '1') && (!empty($reports_perms))) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Choose \"yes\" or \"no\" for Reports Perms.</td></tr>\n";
echo "            </table>\n";
}
elseif (($time_admin_perms != '1') && (!empty($time_admin_perms))) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Choose \"yes\" or \"no\" for Time Admin Perms.</td></tr>\n";
echo "            </table>\n";
}
elseif (($post_disabled != '1') && (!empty($post_disabled))) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Choose \"yes\" or \"no\" for User Account Disabled.</td></tr>\n";
echo "            </table>\n";
}

if (!empty($office_name)) {
$query = "select * from ".$db_prefix."offices where officename = '".$office_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_officename = "".$row['officename']."";
}
mysql_free_result($result);
if (!isset($tmp_officename)) {echo "Office is not defined.\n"; exit;}
}

if (!empty($group_name)) {
$query = "select * from ".$db_prefix."groups where groupname = '".$group_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_groupname = "".$row['groupname']."";
}
mysql_free_result($result);
if (!isset($tmp_officename)) {echo "Group is not defined.\n"; exit;}
}

// end post validation //

if (!empty($string)) {$display_name = stripslashes($display_name);}

echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/user_edit.png' />&nbsp;&nbsp;&nbsp;Edit User</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'><input type='hidden' name='post_username'  
                      value=\"$post_username\">$tmp_post_username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='25' maxlength='50' name='display_name' value=\"$display_name\">&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Email Address:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <input type='text' size='25' maxlength='75' name='email_addy' value='$email_addy'>&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='office_name' onchange='group_names();'>\n";
echo "                      </select>&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'>
                      <select name='group_name' onfocus='group_names();'>
                        <option selected>$group_name</option>\n";
echo "                      </select>&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Sys Admin User?</td>\n";
if (isset($evil)) {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input disabled type='radio' name='admin_perms' value='1' 
                      checked>&nbsp;Yes&nbsp;<input disabled type='radio' name='admin_perms' value='0'>&nbsp;No</td></tr>\n";
} elseif ($admin_perms == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='admin_perms' value='1' 
                      checked>&nbsp;Yes<input type='radio' name='admin_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='admin_perms' value='1'>&nbsp;Yes
                      <input type='radio' name='admin_perms' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time Admin User?</td>\n";
if ($time_admin_perms == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='time_admin_perms' value='1' 
                      checked>&nbsp;Yes<input type='radio' name='time_admin_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='time_admin_perms' value='1'>&nbsp;Yes
                      <input type='radio' name='time_admin_perms' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Reports User?</td>\n";
if ($reports_perms == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='reports_perms' value='1' 
                      checked>&nbsp;Yes<input type='radio' name='reports_perms' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='reports_perms' value='1'>&nbsp;Yes
                      <input type='radio' name='reports_perms' value='0' checked>&nbsp;No</td></tr>\n";
}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Account Disabled?</td>\n";
if ($post_disabled == "1") {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='disabled' value='1' 
                      checked>&nbsp;Yes<input type='radio' name='disabled' value='0'>&nbsp;No</td></tr>\n";
} else {
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='radio' name='disabled' value='1'>&nbsp;Yes
                      <input type='radio' name='disabled' value='0' checked>&nbsp;No</td></tr>\n";
}

echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp&nbsp;;required</td></tr>\n";
echo "            </table>\n";
if (isset($evil)) {
  echo "<input type='hidden' name='evil' value='$evil'>\n";
}
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "                  <input type='hidden' name='get_office' value='$get_office'>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit User' align='middle' 
                      src='../images/buttons/next_button.png'></td><td><a href='useradmin.php'><img src='../images/buttons/cancel_button.png' 
                      border='0'></td></tr></table></form></td></tr>\n";include '../footer.php'; 
$post_username = stripslashes($post_username);
$display_name = stripslashes($display_name);
exit;
}

$post_username = stripslashes($post_username);
$display_name = stripslashes($display_name);
$post_username = addslashes($post_username);
$display_name = addslashes($display_name);

$query3 = "update ".$db_prefix."employees set displayname = ('".$display_name."'), email = ('".$email_addy."'), groups = ('".$group_name."'),
	   office = ('".$office_name."'), admin = ('".$admin_perms."'), reports = ('".$reports_perms."'), time_admin = ('".$time_admin_perms."'),
           disabled = ('".$post_disabled."')
           where empfullname = ('".$post_username."')";
$result3 = mysql_query($query3);

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />
                &nbsp;&nbsp;<a class=admin_headings href=\"useredit.php?username=$tmp_post_username&officename=$office_name\">Edit User</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
                &nbsp;&nbsp;<a class=admin_headings href=\"chngpasswd.php?username=$tmp_post_username&officename=$office_name\">Change Password</a></td>
                </tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete User' />
                &nbsp;&nbsp;<a class=admin_headings href=\"userdelete.php?username=$tmp_post_username&officename=$office_name\">Delete User</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/user_add.png' alt='Create New User' />
                &nbsp;&nbsp;<a class=admin_headings href='usercreate.php'>Create New User</a></td></tr>\n";
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
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png' alt='Edit System Settings' />
                &nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/accept.png' /></td>
                <td class=table_rows_green>&nbsp;User properties updated successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/user_edit.png' />&nbsp;&nbsp;&nbsp;Edit User</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";

$query4 = "select empfullname, displayname, email, groups, office, admin, reports, time_admin, disabled from ".$db_prefix."employees
	  where empfullname = '".$post_username."'
          order by empfullname";
$result4 = mysql_query($query4);

while ($row=mysql_fetch_array($result4)) {

$username = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");
$user_email = "".$row['email']."";
$office = "".$row['office']."";
$groups = "".$row['groups']."";
$admin = "".$row['admin']."";
$reports = "".$row['reports']."";
$time_admin = "".$row['time_admin']."";
$disabled = "".$row['disabled']."";
}
mysql_free_result($result4);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows  
                      colspan=2 width=80% style='padding-left:20px;'>$displayname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Email Address:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$user_email</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$office</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$groups</td></tr>\n";
if ($admin == "1") {$admin = "Yes";} else {$admin = "No";}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Sys Admin User?</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$admin</td></tr>\n";
if ($time_admin == "1") {$time_admin = "Yes";} else {$time_admin = "No";}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time Admin User?</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$time_admin</td></tr>\n";
if ($reports == "1") {$reports = "Yes";} else {$reports = "No";}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Reports User?</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$reports</td></tr>\n";
if ($disabled == "1") {$disabled = "Yes";} else {$disabled = "No";}
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Account Disabled?</td><td align=left 
class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$disabled</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=20 align=left>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='useradmin.php'><img src='../images/buttons/done_button.png' border='0'></a></td></tr></table></td></tr>\n";
include '../footer.php'; exit;
}
?>
