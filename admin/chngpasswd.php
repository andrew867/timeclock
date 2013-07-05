<?php
session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Change Password</title>\n";

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

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
echo "        <tr class=right_main_text><td align=center>Go back to the <a class=admin_headings href='useradmin.php'>User Summary</a> 
            page to change passwords.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

$get_user = $_GET['username'];
@$get_office = $_GET['officename'];

if (get_magic_quotes_gpc()) {$get_user = stripslashes($get_user);}

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";

// display links in top left of each page //

echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />&nbsp;&nbsp;
                <a class=admin_headings href=\"useredit.php?username=$get_user&officename=$get_office\">Edit User</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
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
echo "            <br />\n";

$get_user = addslashes($get_user);

$query = "select empfullname from ".$db_prefix."employees where empfullname = '".$get_user."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$username = stripslashes("".$row['empfullname']."");
}
mysql_free_result($result);
if (!isset($username)) {echo "username is not defined for this user.\n"; exit;}

if (!empty($get_office)) {
$query = "select * from ".$db_prefix."offices where officename = '".$get_office."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$getoffice = "".$row['officename']."";
}
mysql_free_result($result);
}
if (!isset($getoffice)) {echo "Office is not defined for this user. Go back and associate this user with an office.\n"; exit;}

echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/lock_edit.png' />&nbsp;&nbsp;&nbsp;Change 
                      Password</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td style='padding-left:20px;' 
                      align=left class=table_rows width=80%><input type='hidden' name='post_username' value=\"$username\">$username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Password</td><td colspan=2 
                      style='padding-left:20px;'><input type='password' size='25' maxlength='25' name='new_password'></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Confirm Password:</td><td colspan=2 
                      style='padding-left:20px;'><input type='password' size='25' maxlength='25'name='confirm_password'>
                      </td></tr>\n"; 
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <input type='hidden' name='get_office' value='$get_office'>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Change Password' 
                  src='../images/buttons/next_button.png'></td>
                  <td><a href='useradmin.php'><img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
include '../footer.php';
exit;
}

elseif ($request == 'POST') {

$post_username = stripslashes($_POST['post_username']);
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];
$get_office = $_POST['get_office'];

// begin post validation //

if (!empty($get_office)) {
$query = "select * from ".$db_prefix."offices where officename = '".$get_office."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$getoffice = "".$row['officename']."";
}
mysql_free_result($result);
}
if (!isset($getoffice)) {echo "Office is not defined for this user. Go back and associate this user with an office.\n"; exit;}

// end post validation //

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />&nbsp;&nbsp;
                <a class=admin_headings href=\"useredit.php?username=$post_username&officename=$get_office\">Edit User</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
                &nbsp;&nbsp;<a class=admin_headings href=\"chngpasswd.php?username=$post_username&officename=$get_office\">Change Password</a></td>
                </tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete User' />&nbsp;&nbsp;
                <a class=admin_headings href=\"userdelete.php?username=$post_username&officename=$get_office\">Delete User</a></td></tr>\n";
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

$post_username = addslashes($post_username);

// begin post validation //

if (!empty($post_username)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$username = "".$row['empfullname']."";
}
mysql_free_result($result);
if (!isset($username)) {echo "username is not defined for this user.\n"; exit;}
}

$post_username = stripslashes($post_username);

//if (!eregi ("^([[:alnum:]]|~|\!|@|#|\$|%|\^|&|\*|\(|\)|-|\+|`|_|\=|\{|\}|\[|\]|\||\:|\<|\>|\.|,|\?)+$", $new_password)) {   
if (!eregi ("^([[:alnum:]]|~|\!|@|#|\$|%|\^|&|\*|\(|\)|-|\+|`|_|\=|[{]|[}]|\[|\]|\||\:|\<|\>|\.|,|\?)+$", $new_password)) {   
$evil_password = '1';
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Single and double quotes, backward and forward slashes, semicolons, and spaces are not allowed when creating a Password.</td></tr>\n";
echo "            </table>\n";
}
elseif ($new_password !== $confirm_password) {
$evil_password = '1';
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Passwords do not match.</td></tr>\n";
echo "            </table>\n";
}

// end post validation //

if (isset($evil_password)) {

echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/lock_edit.png' />&nbsp;&nbsp;&nbsp;Change 
                    Password</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows width=20% height=25 style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows width=80% 
                      style='padding-left:20px;'><input type='hidden' name='post_username' value=\"$post_username\">$post_username</td></tr>\n";
echo "              <tr><td class=table_rows width=20% height=25 style='padding-left:32px;' nowrap>New Password:</td><td colspan=2 
                      style='padding-left:20px;' width=80%><input type='password' size='25' maxlength='25' name='new_password'></td></tr>\n";
echo "              <tr><td class=table_rows width=20% height=25 style='padding-left:32px;' nowrap>Confirm Password:</td><td colspan=2 
                      style='padding-left:20px;' width=80%><input type='password' size='25' maxlength='25'name='confirm_password'>
                      </td></tr>\n"; 
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <input type='hidden' name='get_office' value=\"$get_office\">\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Change Password' 
                      src='../images/buttons/next_button.png'></td><td><a href='useradmin.php'>
                      <img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n";
include '../footer.php';
exit;

} else {

$new_password = crypt($new_password, 'xy');
$confirm_password = crypt($confirm_password, 'xy');

$post_username = addslashes($post_username);

$query = "update ".$db_prefix."employees set employee_passwd = ('".$new_password."') where empfullname = ('".$post_username."')";
$result = mysql_query($query);

$post_username = stripslashes($post_username);

echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td class=table_rows width=20 align=center><img src='../images/icons/accept.png' /></td>
                <td class=table_rows_green>&nbsp;Password changed successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/lock_edit.png' />&nbsp;&nbsp;&nbsp;Change 
                      Password</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows width=20% height=25 style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows width=80% 
                      style='padding-left:20px;'><input type='hidden' name='post_username' value=\"$post_username\">$post_username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Password</td><td align=left class=table_rows 
                      colspan=2 style='padding-left:20px;' width=80%>***hidden***</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='useradmin.php'><img src='../images/buttons/done_button.png' border='0'></td></tr>
            </table></td></tr>\n"; 
include '../footer.php';
exit;
}
}
?>
