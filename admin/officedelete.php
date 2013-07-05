<?php
session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

include '../config.inc.php';
if ($request !== 'POST') {include 'header_get.php';include 'topmain.php';}
echo "<title>$title - Delete Office</title>\n";

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
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Office' />&nbsp;&nbsp;
                <a class=admin_headings href=\"officeedit.php?officename=$get_office\">Edit Office</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officedelete.php?officename=$get_office\">Delete Office</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />
                &nbsp;&nbsp;<a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
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

$query = "select * from ".$db_prefix."offices where officename = '".$get_office."'";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$officename = "".$row['officename']."";
$officeid = "".$row['officeid']."";
}

if (!isset($officename)) {echo "Office name is not defined for this group.\n"; exit;}

$query2 = "select office from ".$db_prefix."employees where office = '".$get_office."'";
$result2 = mysql_query($query2);
@$user_cnt = mysql_num_rows($result2);

$query3 = "select * from ".$db_prefix."groups where officeid = '".$officeid."'";
$result3 = mysql_query($query3);
@$group_cnt = mysql_num_rows($result3);

if ($user_cnt > 0) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td>";
  if ($user_cnt == 1) { 
echo "<td class=table_rows_red>This office 
                    contains $user_cnt user. This user must be moved to another office and group before it can be deleted.</td></tr>\n";
  } else {
echo "<td class=table_rows_red>This office 
                    contains $user_cnt users. These users must be moved to another office and group before it can be deleted.</td></tr>\n";
  }
echo "            </table>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/brick_delete.png' />&nbsp;&nbsp;&nbsp;Delete Office
                </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office Name:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='post_officename' value=\"$officename\">$get_office</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left width=80% 
                      style='padding-left:20px;' class=table_rows><input type='hidden' name='group_cnt' value=\"$group_cnt\">$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left 
                      class=table_rows width=80% style='padding-left:20px;'><input type='hidden' name='user_cnt' value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <input type='hidden' name='post_officeid' value=\"$officeid\">\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";

  if ($user_cnt == 1) { 
  echo "              <tr><td class=table_rows height=53>Move this user to which office?&nbsp;&nbsp;&nbsp;&nbsp;\n";
  } else {
  echo "              <tr><td class=table_rows height=53>Move these users to which office?&nbsp;&nbsp;&nbsp;&nbsp;\n";
  }

echo "                <select name='office_name' onchange='group_names();'>
                  <option selected>Choose One</option>\n";
echo "                </select>&nbsp;&nbsp;&nbsp;Which Group?\n";
echo "                <select name='group_name'>\n";
echo "                </select></td></tr></table>\n";

echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Delete Office' 
                      src='../images/buttons/next_button.png'></td><td><a href='officeadmin.php'>
                      <img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php'; exit;

} elseif ($user_cnt == '0') {

echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/brick_delete.png' />&nbsp;&nbsp;&nbsp;Delete Office
                </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office Name:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='post_officename' value=\"$officename\">$get_office</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left width=80% 
                      style='padding-left:20px;'class=table_rows><input type='hidden' name='group_cnt' value=\"$group_cnt\">$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left width=80% 
                      style='padding-left:20px;' class=table_rows><input type='hidden' name='user_cnt' value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <input type='hidden' name='post_officeid' value=\"$officeid\">\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <input type='hidden' name='group_name' value='no_group_users'>\n";
echo "              <input type='hidden' name='office_name' value='no_office_users'>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Delete Office' 
                      src='../images/buttons/next_button.png'></td><td><a href='officeadmin.php'>
                      <img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php'; exit;
} exit;
}

elseif ($request == 'POST') {

include 'header_post.php';include 'topmain.php';

$post_officename = $_POST['post_officename'];
@$office_name = $_POST['office_name'];
@$group_name = $_POST['group_name'];
$post_officeid = $_POST['post_officeid'];
$group_cnt = $_POST['group_cnt'];
$user_cnt = $_POST['user_cnt'];

// begin post validation //

if ((!empty($post_officename)) || (!empty($post_officeid))) {
$query = "select * from ".$db_prefix."offices where officename = '".$post_officename."' and officeid = '".$post_officeid."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$officename = "".$row['officename']."";
$officeid = "".$row['officeid']."";
}
mysql_free_result($result);
}

if ((!isset($officename)) || (!isset($officeid))) {echo "Office name is not defined.\n"; exit;}

if ((!empty($office_name)) && ($office_name != 'no_office_users')) {
$query = "select * from ".$db_prefix."offices where officename = '".$office_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_officename = "".$row['officename']."";
$tmp_officeid = "".$row['officeid']."";
}
mysql_free_result($result);
if ((!isset($tmp_officename)) || (!isset($tmp_officeid))) {echo "Office name is not defined for this group.\n"; exit;}
}

if ((!empty($group_name)) && ($group_name != 'no_group_users')) {
$query = "select * from ".$db_prefix."groups where groupname = '".$group_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$tmp_groupname = "".$row['groupname']."";
$tmp_groupid = "".$row['groupid']."";
}
mysql_free_result($result);
if ((!isset($tmp_groupname)) || (!isset($tmp_groupid))) {echo "Office name is not defined for this group.\n"; exit;}
}

$query2 = "select office from ".$db_prefix."employees where office = '".$post_officename."'";
$result2 = mysql_query($query2);
@$tmp_user_cnt = mysql_num_rows($result2);

$query3 = "select * from ".$db_prefix."groups where officeid = '".$post_officeid."'";
$result3 = mysql_query($query3);
@$tmp_group_cnt = mysql_num_rows($result3);

if ($user_cnt != $tmp_user_cnt) {echo "Posted user count does not equal actual user count for this office.\n"; exit;}
if ($group_cnt != $tmp_group_cnt) {echo "Posted group count does not equal actual group count for this office.\n"; exit;}

// end post validation //

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

if ((empty($office_name)) || (empty($group_name)) || ($office_name == $post_officename)) {

echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Office' />&nbsp;&nbsp;
                <a class=admin_headings href=\"officeedit.php?officename=$post_officename\">Edit Office</a></td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Office' />
                &nbsp;&nbsp;<a class=admin_headings href=\"officedelete.php?officename=$post_officename\">Delete Office</a></td></tr>\n";

} else { 

echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Office' />&nbsp;&nbsp;
                Edit Office</td></tr>\n";
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Office' />
                &nbsp;&nbsp;Delete Office</td></tr>\n";
}

echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/brick_add.png' alt='Create New Office' />
                &nbsp;&nbsp;<a class=admin_headings href='officecreate.php'>Create New Office</a></td></tr>\n";
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

if ((empty($office_name)) || (empty($group_name))) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td>\n";
echo "                <td class=table_rows_red nowrap>To delete this office, you must choose to move its' current users to another 
                      office <b>AND</b> group.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
} elseif ($office_name == $post_officename) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td>\n";
echo "                <td class=table_rows_red nowrap>To delete this office, you must choose to move its' current users to a <b>DIFFERENT</b> 
                      office and group.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
} else {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/accept.png' /></td>
                <td class=table_rows_green>Office deleted successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
}
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/brick_delete.png' />&nbsp;&nbsp;&nbsp;Delete Office
                </th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";

if ((empty($office_name)) || (empty($group_name)) || ($office_name == $post_officename)) {

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office Name:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'><input type='hidden' name='post_officename'
                      value=\"$post_officename\">$post_officename</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left 
                      class=table_rows width=80% style='padding-left:20px;'><input type='hidden' name='group_cnt'
                      value=\"$group_cnt\">$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left 
                      class=table_rows width=80% style='padding-left:20px;'><input type='hidden' name='user_cnt'
                      value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <input type='hidden' name='post_officeid' value=\"$post_officeid\">\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";

  if ($user_cnt == 1) { 
  echo "            <tr><td class=table_rows height=53>Move this user to which office?&nbsp;&nbsp;&nbsp;&nbsp;\n";
  } else {
  echo "            <tr><td class=table_rows height=53>Move these users to which office?&nbsp;&nbsp;&nbsp;&nbsp;\n";
  }

echo "                <select name='office_name' onchange='group_names();'>
                  <option selected>Choose One</option>\n";
echo "                </select>&nbsp;&nbsp;&nbsp;Which Group?\n";
echo "                <select name='group_name' onfocus='group_names();'>\n";
echo "                </select></td></tr></table>\n";

echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Delete Office' 
                      src='../images/buttons/next_button.png'></td><td><a href='officeadmin.php'>
                      <img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php'; exit;

} else {

if ($user_cnt > 0) {
$query4 = "update ".$db_prefix."employees set office = ('".$office_name."'), groups = ('".$group_name."') where office = ('".$post_officename."')";
$result4 = mysql_query($query4);
}

$query5 = "delete from ".$db_prefix."offices where officeid = '".$post_officeid."'";
$result5 = mysql_query($query5);

$query6 = "delete from ".$db_prefix."groups where officeid = '".$post_officeid."'";
$result6 = mysql_query($query6);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Office Name:</td><td align=left class=table_rows 
                      width=80% style='padding-left:20px;'>$post_officename</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Group Count:</td><td align=left 
                      class=table_rows width=80% style='padding-left:20px;'>$group_cnt</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left 
                      class=table_rows width=80% style='padding-left:20px;'>$user_cnt</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=20 align=left>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='officeadmin.php'><img src='../images/buttons/done_button.png' border='0'></td></tr></table></td>
              </tr>\n";
include '../footer.php'; exit;
}}
?>
