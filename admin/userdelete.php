<?php
session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Delete User</title>\n";

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
echo "        <tr class=right_main_text><td align=center>Go back to the <a class=admin_headings href='useradmin.php'>User Summary</a> page to delete users.
            </td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

$get_user = stripslashes($_GET['username']);
@$get_office = $_GET['officename'];

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />&nbsp;&nbsp;
                <a class=admin_headings href=\"useredit.php?username=$get_user&officename=$get_office\">Edit User</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
                &nbsp;&nbsp;<a class=admin_headings href=\"chngpasswd.php?username=$get_user&officename=$get_office\">Change Password</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete User' />
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

$username = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");
$user_email = "".$row['email']."";
$office = "".$row['office']."";
$groups = "".$row['groups']."";
$admin = "".$row['admin']."";
$reports = "".$row['reports']."";
$time_admin = "".$row['time_admin']."";
}
mysql_free_result($result);
$get_user = stripslashes($get_user);

// make sure you cannot delete the last admin user in the system!! //

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
                    Cannot delete this user. This user is the last Sys Admin User in the system. Go back and give another user Sys Admin
                    privileges before attempting to delete this user again.</td></tr>\n";
echo "            </table>\n";
}
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/user_delete.png' />&nbsp;&nbsp;&nbsp;Delete 
                    User</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='post_username' value=\"$username\">$username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='display_name' value=\"$displayname\">$displayname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Email Address:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='email_addy' value=\"$user_email\">$user_email</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='office_name' value=\"$office\">$office</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='group_name' value=\"$groups\">$groups</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Sys Admin:</td>\n";
if ($admin == "1") {$admin_yes_no = "Yes";} else {$admin_yes_no = "No";}
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='hidden' name='admin_perms' 
                      value='$admin'>$admin_yes_no</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Time Admin:</td>\n";
if ($time_admin == "1") {$time_admin_yes_no = "Yes";} else {$time_admin_yes_no = "No";}
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='hidden' name='time_admin_perms' 
                      value='$time_admin'>$time_admin_yes_no</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Reports:</td>\n";
if ($reports == "1") {$reports_yes_no = "Yes";} else {$reports_yes_no = "No";}
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='hidden' name='reports_perms' 
                      value='$reports'>$reports_yes_no</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
if (isset($evil)) {
echo "            <table style='display:none;' align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
} else {
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
}
echo "              <tr><td class=table_rows height=40 width=10><input type='checkbox' name='delete_all_user_data' value='1'></td>
                  <td class=table_rows height=53>Delete all punch-in/out history for this user?</td></tr></table>\n";
if (isset($evil)) {
echo "            <table style='display:none;' align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
} else {
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
}
echo "              <tr><td width=30><input type='image' name='submit' value='Delete User' 
                    src='../images/buttons/next_button.png'></td><td><a href='useradmin.php'><img src='../images/buttons/cancel_button.png' 
                    border='0'></td></tr></table></form></td></tr>\n";
include '../footer.php'; exit;
}

elseif ($request == 'POST') {

$post_username = stripslashes($_POST['post_username']);
$display_name = stripslashes($_POST['display_name']);
$email_addy = $_POST['email_addy'];
$office_name = $_POST['office_name'];
$group_name = $_POST['group_name'];
$admin_perms = $_POST['admin_perms'];
$reports_perms = $_POST['reports_perms'];
$time_admin_perms = $_POST['time_admin_perms'];
@$delete_data = $_POST['delete_all_user_data'];

$post_username = addslashes($post_username);
$display_name = addslashes($display_name);

// begin post validation //

if (!empty($post_username)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_username = "".$row['empfullname']."";
}
if (!isset($tmp_username)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($display_name)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."' and displayname = '".$display_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_display_name = "".$row['displayname']."";
}
if (!isset($tmp_display_name)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($email_addy)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."' and email = '".$email_addy."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_email_addy = "".$row['email']."";
}
if (!isset($tmp_email_addy)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($office_name)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."' and office = '".$office_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_office_name = "".$row['office']."";
}
if (!isset($tmp_office_name)) {echo "Something is fishy here.\n"; exit;}
}

if (!empty($group_name)) {
$query = "select * from ".$db_prefix."employees where empfullname = '".$post_username."' and groups = '".$group_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_group_name = "".$row['groups']."";
}
if (!isset($tmp_group_name)) {echo "Something is fishy here.\n"; exit;}
}

if (($admin_perms != '0') && ($admin_perms != '1')) {echo "Something is fishy here.\n"; exit;}
if (($reports_perms != '0') && ($reports_perms != '1')) {echo "Something is fishy here.\n"; exit;}
if (($time_admin_perms != '0') && ($time_admin_perms != '1')) {echo "Something is fishy here.\n"; exit;}
if ((isset($delete_data)) && ($delete_data != '1')) {echo "Something is fishy here.\n"; exit;}

// end post validation //

$query2 = "delete from ".$db_prefix."employees where empfullname = ('".$post_username."')";
$result2 = mysql_query($query2);

if ($delete_data == "1") {
$query3 = "delete from ".$db_prefix."info where fullname = ('".$post_username."')";
$result3 = mysql_query($query3);
}

$post_username = stripslashes($post_username);
$display_name = stripslashes($display_name);

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='useradmin.php'>User Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit User' />
                &nbsp;&nbsp;Edit User</td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Change Password' />
                &nbsp;&nbsp;Change Password</td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete User' />
                &nbsp;&nbsp;Delete User</td></tr>\n";
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
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/accept.png' /></td><td class=table_rows_green>&nbsp;User 
                    deleted successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/user_delete.png' />&nbsp;&nbsp;&nbsp;Delete 
                    User</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Username:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='post_username' value=\"$post_username\">$post_username</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Display Name:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='display_name' value=\"$display_name\">$display_name</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Email Address:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='email_addy' value=\"$email_addy\">$email_addy</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='office_name' value=\"$office_name\">$office_name</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='group_name' value=\"$group_name\">$group_name</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Sys Admin:</td>\n";
if ($admin_perms == "1") {$admin_yes_no = "Yes";} else {$admin_yes_no = "No";}
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='hidden' name='admin_perms' 
                      value='$admin_perms'>$admin_yes_no</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Reports:</td>\n";
if ($time_admin_perms == "1") {$time_admin_yes_no = "Yes";} else {$time_admin_yes_no = "No";}
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='hidden' name='time_admin_perms' 
                      value='$time_admin_perms'>$time_admin_yes_no</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Reports:</td>\n";
if ($reports_perms == "1") {$reports_yes_no = "Yes";} else {$reports_yes_no = "No";}
echo "                  <td class=table_rows align=left width=80% style='padding-left:20px;'><input type='hidden' name='reports_perms' 
                      value='$reports_perms'>$reports_yes_no</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=20 align=left>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='useradmin.php'><img src='../images/buttons/done_button.png' border='0'></td></tr></table></td></tr>\n";
include '../footer.php'; exit;
}
?>
