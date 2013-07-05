<?php
session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Edit Office</title>\n";

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

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

if (!isset($_GET['officename'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Error!</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=300 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>How did you get here?</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Go back to the <a class=admin_headings href='officeadmin.php'>Office Summary</a> page to edit 
            offices.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

$get_office = $_GET['officename'];

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
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officeedit.php?officename=$get_office\">Edit Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officedelete.php?officename=$get_office\">Delete Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />
                &nbsp;&nbsp;<a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Groups</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group.png' alt='Group Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='groupadmin.php'>Group Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />
                &nbsp;&nbsp;<a class=admin_headings href='groupcreate.php'>Create New Group</a></td></tr>\n";
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

$query = "select * from ".$db_prefix."offices where officename = '".$get_office."'";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$officename = "".$row['officename']."";
$officeid = "".$row['officeid']."";
}

if (!isset($officename)) {echo "Office name is not defined.\n"; exit;}
if (!isset($officeid)) {echo "Office name is not defined.\n"; exit;}

$query2 = "select * from ".$db_prefix."employees where office = '".$get_office."'";
$result2 = mysql_query($query2);
@$user_cnt = mysql_num_rows($result2);

$query3 = "select * from ".$db_prefix."groups where officeid = '".$officeid."'";
$result3 = mysql_query($query3);
@$group_cnt = mysql_num_rows($result3);

echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/brick_edit.png' />&nbsp;&nbsp;&nbsp;Edit Office
                -&nbsp;$get_office</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Office Name:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='50' name='post_officename' value=\"$officename\">&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left width=80%
                      class=table_rows style='padding-left:20px;'><input type='hidden' name='group_cnt' 
                      value=\"$group_cnt\">$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left width=80%
                      class=table_rows style='padding-left:20px;'><input type='hidden' name='user_cnt' 
                      value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <input type='hidden' name='post_officeid' value=\"$officeid\">\n";
echo "              <input type='hidden' name='get_office' value=\"$get_office\">\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Office' src='../images/buttons/next_button.png'></td>
                  <td><a href='officeadmin.php'><img src='../images/buttons/cancel_button.png' border='0'></td></tr></table>";

if ($group_cnt == '0') {
  echo "</form></td></tr>\n";
}

if ($group_cnt != '0') {

echo "</form>\n";
echo "            <br /><br /><br /><hr /><br />\n";
echo "            <table width=60% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>$get_office Groups</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/group.png' />&nbsp;&nbsp;Total
                      Groups: $group_cnt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total Users: $user_cnt</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=60% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=87% align=left>Group Name</th>\n";
echo "                <th class=table_heading nowrap width=4% align=center>Users</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th></tr>\n";

$row_count = 0;

$query = "select * from ".$db_prefix."groups where officeid = ('".$officeid."') order by groupname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$tmp_group = "".$row['groupname']."";

$query3 = "select * from ".$db_prefix."employees where office = '".$officename."' and groups = '".$tmp_group."'";
$result3 = mysql_query($query3);
@$group_user_cnt = mysql_num_rows($result3);

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows width=87% align=left>&nbsp;<a class=footer_links title=\"Edit Group: ".$row["groupname"]."\"
                    href=\"groupedit.php?groupname=".$row["groupname"]."&officename=$get_office\">$tmp_group</a></td>\n";
echo "                <td class=table_rows width=4% align=center><input type='hidden' name='group_user_cnt' 
                    value=\"$group_user_cnt\">$group_user_cnt</td>\n";

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Edit Group: ".$row["groupname"]."\" href=\"groupedit.php?groupname=$tmp_group&officename=$get_office\" >
                    Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Delete Group: ".$row["groupname"]."\" href=\"groupdelete.php?groupname=$tmp_group&officename=$get_office\" >
                    Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a title=\"Edit Group: ".$row["groupname"]."\" 
                    href=\"groupedit.php?groupname=$tmp_group&officename=$get_office\">
                    <img border=0 src='../images/icons/application_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Delete Group: ".$row["groupname"]."\" 
                    href=\"groupdelete.php?groupname=$tmp_group&officename=$get_office\">
                    <img border=0 src='../images/icons/delete.png' /></a></td></tr>\n";
}
}
echo "            </table></td></tr>\n";
}include '../footer.php'; exit;
}

elseif ($request == 'POST') {

$post_officename = $_POST['post_officename'];
$post_officeid = $_POST['post_officeid'];
$get_office = $_POST['get_office'];
$group_cnt = $_POST['group_cnt'];
$user_cnt = $_POST['user_cnt'];
@$group_user_cnt = $_POST['group_user_cnt'];

// begin post validation //

if (!empty($get_office)) {
$query = "select * from ".$db_prefix."offices where officename = '".$get_office."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$getoffice = "".$row['officename']."";
}
mysql_free_result($result);
if (!isset($getoffice)) {echo "Office is not defined.\n"; exit;}
}

if (!empty($post_officeid)) {
$query = "select * from ".$db_prefix."offices where officeid = '".$post_officeid."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$post_officeid = "".$row['officeid']."";
}
mysql_free_result($result);
if (!isset($post_officeid)) {echo "Office id is not defined.\n"; exit;}
}

$query2 = "select office from ".$db_prefix."employees where office = '".$get_office."'";
$result2 = mysql_query($query2);
@$tmp_user_cnt = mysql_num_rows($result2);

$query3 = "select * from ".$db_prefix."groups where officeid = '".$post_officeid."'";
$result3 = mysql_query($query3);
@$tmp_group_cnt = mysql_num_rows($result3);

if ($user_cnt != $tmp_user_cnt) {echo "Posted user count does not equal actual user count for this office.\n"; exit;}
if ($group_cnt != $tmp_group_cnt) {echo "Posted group count does not equal actual group count for this office.\n"; exit;}

if ((empty($post_officename)) || (!eregi ("^([[:alnum:]]| |-|_|\.)+$", $post_officename))) {

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
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officeedit.php?officename=$get_office\">Edit Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officedelete.php?officename=$get_office\">Delete Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />
                &nbsp;&nbsp;<a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Groups</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group.png' alt='Group Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='groupadmin.php'>Group Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />
                &nbsp;&nbsp;<a class=admin_headings href='groupcreate.php'>Create New Group</a></td></tr>\n";
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

if (empty($post_officename)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    An Office Name is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([[:alnum:]]| |-|_|\.)+$", $post_officename)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Alphanumeric characters, hyphens, underscores, spaces, and periods are allowed when creating an Office Name.</td></tr>\n";
echo "            </table>\n";
}
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/brick_edit.png' />&nbsp;&nbsp;&nbsp;Edit Office
                -&nbsp;$get_office</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Office Name:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px'><input type='text' 
                      size='25' maxlength='50' name='post_officename' value=\"$post_officename\">&nbsp;*</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left width=80% 
                      style='padding-left:20px;' class=table_rows><input type='hidden' name='group_cnt' 
                      value=\"$group_cnt\">$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left 
                      style='padding-left:20px;' class=table_rows><input type='hidden' name='user_cnt' 
                      value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <input type='hidden' name='post_officeid' value=\"$post_officeid\">\n";
echo "              <input type='hidden' name='get_office' value=\"$get_office\">\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Office' src='../images/buttons/next_button.png'></td>
                  <td><a href='officeadmin.php'><img src='../images/buttons/cancel_button.png' border='0'></td></tr></table>";

if ($group_cnt == '0') {
  echo "</form></td></tr>\n";
}

if ($group_cnt != '0') {

echo "</form>\n";
echo "            <br /><br /><br /><hr /><br />\n";
echo "            <table width=60% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>$get_office Groups</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/group.png' />&nbsp;&nbsp;Total
                      Groups: $group_cnt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total Users: $user_cnt</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=60% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr>\n";

echo "                <th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=87% align=left>Group Name</th>\n";
echo "                <th class=table_heading nowrap width=4% align=center>Users</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th>\n";
echo "              </tr>\n";

$row_count = 0;

$query = "select * from ".$db_prefix."groups where officeid = ('".$post_officeid."') order by groupname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$tmp_group = "".$row['groupname']."";

$query3 = "select * from ".$db_prefix."employees where office = '".$get_office."' and groups = '".$tmp_group."'";
$result3 = mysql_query($query3);
@$group_user_cnt = mysql_num_rows($result3);

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows width=87% align=left>&nbsp;<a class=footer_links
                    href=\"groupedit.php?groupname=".$row["groupname"]."&officename=$get_office\">$tmp_group</a></td>\n";
echo "                <td class=table_rows width=4% align=center>$group_user_cnt</td>\n";

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Edit Group: ".$row["groupname"]."\" href=\"groupedit.php?groupname=$tmp_group&officename=$get_office\" >
                    Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Delete Group: ".$row["groupname"]."\" href=\"groupdelete.php?groupname=$tmp_group&officename=$get_office\" >
                    Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a href=\"groupedit.php?groupname=$tmp_group&officename=$get_office\">
                    <img border=0 src='../images/icons/application_edit.png' title=\"Edit Group: ".$row["groupname"]."\" /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a href=\"groupdelete.php?groupname=$tmp_group&officename=$get_office\">
                    <img border=0 src='../images/icons/delete.png' title=\"Delete Group: ".$row["groupname"]."\" /></a></td></tr>\n";
}
}
echo "            </table></td></tr>\n";
}
include '../footer.php'; exit;

} else {

///////////////////////////////////////////////////////////////////////////////////////////////

$officeid_query = "select * from ".$db_prefix."offices where officename = ('".$post_officename."')";
$officeid_result = mysql_query($officeid_query);
while ($row=mysql_fetch_array($officeid_result)) {
  $post_officeid = "".$row['officeid']."";
}

$query4 = "update ".$db_prefix."employees set office = ('".$post_officename."') where office = ('".$get_office."')";
$result4 = mysql_query($query4);

$query5 = "update ".$db_prefix."offices set officename = ('".$post_officename."') where officename = ('".$get_office."')";
$result5 = mysql_query($query5);

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
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officeedit.php?officename=$post_officename\">Edit Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officedelete.php?officename=$post_officename\">Delete Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />
                &nbsp;&nbsp;<a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
echo "        <tr><td class=left_rows height=33></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Groups</td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group.png' alt='Group Summary' />&nbsp;&nbsp;
                <a class=admin_headings href='groupadmin.php'>Group Summary</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />
                &nbsp;&nbsp;<a class=admin_headings href='groupcreate.php'>Create New Group</a></td></tr>\n";
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
                <td class=table_rows_green>&nbsp;Office properties updated successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/brick_edit.png' />&nbsp;&nbsp;&nbsp;Edit Office
                -&nbsp;$get_office</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Office Name:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$post_officename</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$user_cnt</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=20 align=left>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='officeadmin.php'><img src='../images/buttons/done_button.png' 
                      border='0'></a></td></tr></table>";

if ($group_cnt == '0') {
  echo "</td></tr>\n";
}

if ($group_cnt != '0') {

echo "\n";
echo "            <br /><br /><br /><hr /><br />\n";
echo "            <table width=60% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>$post_officename Groups</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/group.png' />&nbsp;&nbsp;Total
                      Groups: $group_cnt&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total Users: $user_cnt</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=60% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr>\n";

echo "                <th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=87% align=left>Group Name</th>\n";
echo "                <th class=table_heading nowrap width=4% align=center>Users</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th>\n";
echo "              </tr>\n";

$row_count = 0;

$query = "select * from ".$db_prefix."groups where officeid = ('".$post_officeid."') order by groupname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$tmp_group = "".$row['groupname']."";

$query3 = "select * from ".$db_prefix."employees where office = '".$post_officename."' and groups = '".$tmp_group."'";
$result3 = mysql_query($query3);
@$group_user_cnt = mysql_num_rows($result3);

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows width=87% align=left>&nbsp;<a class=footer_links
                    href=\"groupedit.php?groupname=".$row["groupname"]."&officename=$post_officename\">$tmp_group</a></td>\n";
echo "                <td class=table_rows width=4% align=center>$group_user_cnt</td>\n";

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Edit Group: ".$row["groupname"]."\" href=\"groupedit.php?groupname=$tmp_group&officename=$post_officename\" >
                    Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Delete Group: ".$row["groupname"]."\" href=\"groupdelete.php?groupname=$tmp_group&officename=$post_officename\" >
                    Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a href=\"groupedit.php?groupname=$tmp_group&officename=$post_officename\">
                    <img border=0 src='../images/icons/application_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a href=\"groupdelete.php?groupname=$tmp_group&officename=$post_officename\">
                    <img border=0 src='../images/icons/delete.png' /></a></td></tr>\n";
}
}
echo "            </table></td></tr>\n";
}
}
include '../footer.php'; exit;
}
?>
