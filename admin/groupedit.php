<?php
session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Edit Group</title>\n";

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (!isset($_SESSION['valid_user'])) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Administration</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=300 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>You are currently not logged in.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='../login.php'><u>here</u></a> to login.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

if ($request == 'GET') {

if ((!isset($_GET['groupname'])) && (!isset($_GET['officename']))) {

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Error!</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=300 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>How did you get here?</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Go back to the <a class=admin_headings href='groupadmin.php'>Group Summary</a> page to edit groups.
            </td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}

$get_group = $_GET['groupname'];
$get_office = $_GET['officename'];

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";

// display links in top left of each page //

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
echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Group' />
                &nbsp;&nbsp;<a class=admin_headings href=\"groupedit.php?groupname=$get_group&officename=$get_office\">Edit Group</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Group' />
                &nbsp;&nbsp;<a class=admin_headings href=\"groupdelete.php?groupname=$get_group&officename=$get_office\">Delete Group</a></td></tr>\n";
echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />
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

$query = "select * from ".$db_prefix."groups, ".$db_prefix."offices where officename = '".$get_office."' and groupname = '".$get_group."'";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$officename = "".$row['officename']."";
$officeid = "".$row['officeid']."";
$groupname = "".$row['groupname']."";
$groupid = "".$row['groupid']."";
}

if (!isset($officename)) {echo "Office name is not defined for this group.\n"; exit;}
if (!isset($groupname)) {echo "Group name is not defined for this group.\n"; exit;}

$query2 = "select * from ".$db_prefix."employees where office = '".$get_office."' and groups = '".$get_group."'";
$result2 = mysql_query($query2);
@$user_cnt = mysql_num_rows($result2);

echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/group_edit.png' />&nbsp;&nbsp;&nbsp;Edit Group
                -&nbsp;$get_group</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Group Name:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='50' name='post_groupname' value=\"$get_group\">&nbsp;*</td></tr>\n";

// query to populate dropdown with office names //

$query3 = "select * from ".$db_prefix."offices
           order by officename asc";

$result3 = mysql_query($query3);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Parent Office:</td><td colspan=2 width=80% 
                      style='padding-left:20px;'><select name='post_officename'>\n"; 

while ($row=mysql_fetch_array($result3)) {
  if ("".$row['officename']."" == $get_office) {
  echo "                    <option selected>".$row['officename']."</option>\n";
  } else {
  echo "                    <option>".$row['officename']."</option>\n";
  }
}
echo "                  </select></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left width=80%
                      style='padding-left:20px;' class=table_rows><input type='hidden' name='user_cnt' 
                      value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <input type='hidden' name='orig_officeid' value=\"$officeid\">\n";
echo "              <input type='hidden' name='post_groupid' value=\"$groupid\">\n";
echo "              <input type='hidden' name='get_group' value=\"$get_group\">\n";
echo "              <input type='hidden' name='get_office' value=\"$get_office\">\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Group' src='../images/buttons/next_button.png'></td>
                  <td><a href='groupadmin.php'><img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form>\n";

$user_count = mysql_query("select empfullname from ".$db_prefix."employees where groups = ('".$get_group."') and office = ('".$get_office."')
                           order by empfullname");
@$user_count_rows = mysql_num_rows($user_count);

$admin_count = mysql_query("select empfullname from ".$db_prefix."employees where admin = '1' and groups = ('".$get_group."') 
                            and office = ('".$get_office."')");
@$admin_count_rows = mysql_num_rows($admin_count);

$time_admin_count = mysql_query("select empfullname from ".$db_prefix."employees where time_admin = '1' and groups = ('".$get_group."') 
                                 and office = ('".$get_office."')");
@$time_admin_count_rows = mysql_num_rows($time_admin_count);

$reports_count = mysql_query("select empfullname from ".$db_prefix."employees where reports = '1' and groups = ('".$get_group."') 
                              and office = ('".$get_office."')");
@$reports_count_rows = mysql_num_rows($reports_count);

if ($user_count_rows > '0') {

echo "            <br /><br /><br /><hr /><br />\n";
echo "            <table width=90% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>Members of $get_group Group in $get_office Office</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total
                      Users: $user_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_orange.png' />&nbsp;&nbsp;
                      Sys Admin Users: $admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_red.png' />&nbsp;&nbsp;
                      Time Admin Users: $time_admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_suit.png' />&nbsp;
                      &nbsp;Reports Users: $reports_count_rows</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=90% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Username</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Display Name</th>\n";
echo "                <th class=table_heading nowrap width=28% align=left>Email Address</th>\n";
echo "                <th class=table_heading width=3% align=center>Disabled</th>\n";
echo "                <th class=table_heading width=3% align=center>Sys Admin</th>\n";
echo "                <th class=table_heading width=3% align=center>Time Admin</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Reports</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading width=5% align=center>Change Passwd</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th></tr>\n";

$row_count = 0;

$query = "select empfullname, displayname, email, groups, office, admin, reports, time_admin, disabled from ".$db_prefix."employees
          where groups = ('".$get_group."') and office = ('".$get_office."') order by empfullname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$empfullname = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows width=23%>&nbsp;<a title=\"Edit User: $empfullname\" class=footer_links
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">$empfullname</a></td>\n";
echo "                <td class=table_rows width=23%>&nbsp;$displayname</td>\n";
echo "                <td class=table_rows width=28%>&nbsp;".$row["email"]."</td>\n";

if ("".$row["disabled"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/cross.png' /></td>\n";
} else {
  $disabled = "";
  echo "                <td class=table_rows width=3% align=center>".$disabled."</td>\n";
}
if ("".$row["admin"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $admin = "";
  echo "                <td class=table_rows width=3% align=center>".$admin."</td>\n";
}
if ("".$row["time_admin"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $time_admin = "";
  echo "                <td class=table_rows width=3% align=center>".$time_admin."</td>\n";
}
if ("".$row["reports"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $reports = "";
  echo "                <td class=table_rows width=3% align=center>".$reports."</td>\n";
}

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Edit User: $empfullname\"
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Change Password: $empfullname\"
                    href=\"chngpasswd.php?username=$empfullname&officename=".$row["office"]."\">Chg Pwd</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Delete User: $empfullname\"
                    href=\"userdelete.php?username=$empfullname&officename=".$row["office"]."\">Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a title=\"Edit User: $empfullname\"
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">
                    <img border=0 src='../images/icons/application_edit.png' /></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Change Password: $empfullname\"
                    href=\"chngpasswd.php?username=$empfullname&officename=".$row["office"]."\"><img border=0
                    src='../images/icons/lock_edit.png' /></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Delete User: $empfullname\"
                    href=\"userdelete.php?username=$empfullname&officename=".$row["office"]."\">
                    <img border=0 src='../images/icons/delete.png' /></td></tr>\n";
}
}}
if ($user_count_rows > '0') {
  echo "            </table></td></tr>\n";include '../footer.php'; exit;
} elseif ($user_count_rows == '0') {
  echo "            </td></tr>\n";include '../footer.php'; exit;
}}

elseif ($request == 'POST') {

$post_officename = $_POST['post_officename'];
@$post_officeid = $_POST['post_officeid'];
$orig_officeid = $_POST['orig_officeid'];
$post_groupname = $_POST['post_groupname'];
@$post_groupid = $_POST['post_groupid'];
$get_group = $_POST['get_group'];
$get_office = $_POST['get_office'];
$user_cnt = $_POST['user_cnt'];
$post_groupname = stripslashes($post_groupname);
$post_groupname = addslashes($post_groupname);

$string = strstr($post_groupname, "\'");

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

if (!empty($get_group)) {
$query = "select * from ".$db_prefix."groups where groupname = '".$get_group."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$getgroup = "".$row['groupname']."";
}
mysql_free_result($result);
}
if (!isset($getgroup)) {echo "Group is not defined for this user. Go back and associate this user with a group.\n"; exit;}

if (!empty($post_officename)) {
$query = "select * from ".$db_prefix."offices where officename = '".$post_officename."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$officename = "".$row['officename']."";
$tmp_officeid = "".$row['officeid']."";
}
mysql_free_result($result);
}
if (!isset($officename)) {echo "Office name is not defined for this group.\n"; exit;}

if (!empty($post_officeid)) {
$query = "select * from ".$db_prefix."offices where officeid = '".$post_officeid."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$post_officeid = "".$row['officeid']."";
$post_officeid = $tmp_officeid;
}
mysql_free_result($result);
if (!isset($post_officeid)) {echo "Office id is not defined for this group.\n"; exit;}
} else {
$post_officeid = $tmp_officeid;
}

if (!empty($orig_officeid)) {
$query = "select * from ".$db_prefix."offices where officeid = '".$orig_officeid."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$origofficeid = "".$row['officeid']."";
}
mysql_free_result($result);
}
if (!isset($origofficeid)) {echo "Office name is not defined for this group.\n"; exit;}

if (!empty($post_groupid)) {
$query = "select * from ".$db_prefix."groups where groupid = '".$post_groupid."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$groupid = "".$row['groupid']."";
}
mysql_free_result($result);
}
if (!isset($groupid)) {echo "Group id is not defined for this group.\n"; exit;}

$query = "select * from ".$db_prefix."employees where office = '".$get_office."' and groups = '".$get_group."'";
$result = mysql_query($query);
@$tmp_user_cnt = mysql_num_rows($result);

if ($user_cnt != $tmp_user_cnt) {echo "Posted user count does not equal actual user count for this group.\n"; exit;}

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";

if (empty($string)) {

$query = "select * from ".$db_prefix."groups where groupname = '".$post_groupname."' and officeid = '".$post_officeid."'";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
$dupe = '1';
}
}

if ((empty($post_groupname)) || (!eregi ("^([[:alnum:]]| |-|_|\.)+$", $post_groupname)) || (!empty($string))) {
$evil_group = '1';
}

// end post validation //

// display links in top left of each page //

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

if (isset($evil_group)) {

echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Group' />
                &nbsp;&nbsp;<a class=admin_headings href=\"groupedit.php?groupname=$get_group&officename=$get_office\">Edit Group</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Group' />
                &nbsp;&nbsp;<a class=admin_headings href=\"groupdelete.php?groupname=$get_group&officename=$get_office\">Delete Group</a></td></tr>\n";

} else {

echo "        <tr><td class=current_left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Edit Group' />
                &nbsp;&nbsp;<a class=admin_headings href=\"groupedit.php?groupname=$post_groupname&officename=$post_officename\">Edit Group</a></td></tr>\n";
echo "        <tr><td class=left_rows_indent height=18 align=left valign=middle><img src='../images/icons/arrow_right.png' alt='Delete Group' />
                &nbsp;&nbsp;<a class=admin_headings href=\"groupdelete.php?groupname=$post_groupname&officename=$post_officename\">Delete Group</a>
                </td></tr>\n";
}

echo "        <tr><td class=left_rows_border_top height=18 align=left valign=middle><img src='../images/icons/group_add.png' alt='Create New Group' />
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

if ((isset($evil_group)) || (isset($dupe))) {

if (empty($post_groupname)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    A Group Name is required.</td></tr>\n";
echo "            </table>\n";
}
elseif (!eregi ("^([[:alnum:]]| |-|_|\.)+$", $post_groupname)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    Alphanumeric characters, hyphens, underscores, spaces, and periods are allowed when creating a Group Name.</td></tr>\n";
echo "            </table>\n";
}
elseif (!empty($string)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                   Apostrohpes are not allowed when editing a Group Name.</td></tr>\n";
echo "            </table>\n";
}
elseif (isset($dupe)) {
echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/cancel.png' /></td><td class=table_rows_red>
                    This combination of groupname and officename already exist. Please choose another groupname and/or officename.</td></tr>\n";
echo "            </table>\n";
}

if (!empty($string)) {$post_groupname = stripslashes($post_groupname);}

echo "            <br />\n";
echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/group_edit.png' />&nbsp;&nbsp;&nbsp;Edit Group
                -&nbsp;$get_group</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Group Name:</td><td colspan=2 width=80%
                      style='color:red;font-family:Tahoma;font-size:10px;padding-left:20px;'><input type='text' 
                      size='25' maxlength='50' name='post_groupname' value=\"$post_groupname\">&nbsp;*</td></tr>\n";

// query to populate dropdown with office names //

$query3 = "select * from ".$db_prefix."offices
           order by officename asc";

$result3 = mysql_query($query3);

echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Parent Office:</td><td colspan=2 width=80% 
                      style='padding-left:20px;'><select name='post_officename'>\n"; 

while ($row=mysql_fetch_array($result3)) {
  if ("".$row['officename']."" == $post_officename) {
  $post_officeid = "".$row['officeid']."";
  echo "                    <option selected>".$row['officename']."</option>\n";
  } else {
  echo "                    <option>".$row['officename']."</option>\n";
  }
}
echo "                  </select></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left width=80%
                      class=table_rows style='padding-left:20px;'><input type='hidden' name='user_cnt' 
                      value=\"$user_cnt\">$user_cnt</td></tr>\n";
echo "              <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=40></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <input type='hidden' name='orig_officeid' value=\"$orig_officeid\">\n";
echo "              <input type='hidden' name='post_officeid' value=\"$post_officeid\">\n";
echo "              <input type='hidden' name='post_groupid' value=\"$post_groupid\">\n";
echo "              <input type='hidden' name='get_group' value=\"$get_group\">\n";
echo "              <input type='hidden' name='get_office' value=\"$get_office\">\n";
echo "              <input type='hidden' name='user_cnt' value=\"$user_cnt\">\n";
echo "              <tr><td width=30><input type='image' name='submit' value='Edit Group' src='../images/buttons/next_button.png'></td>
                  <td><a href='groupadmin.php'><img src='../images/buttons/cancel_button.png' border='0'></td></tr></table></form>\n";

$user_count = mysql_query("select empfullname from ".$db_prefix."employees where groups = ('".$get_group."') and office = ('".$get_office."')
                           order by empfullname");
@$user_count_rows = mysql_num_rows($user_count);

$admin_count = mysql_query("select empfullname from ".$db_prefix."employees where admin = '1' and groups = ('".$get_group."') 
                            and office = ('".$get_office."')");
@$admin_count_rows = mysql_num_rows($admin_count);

$time_admin_count = mysql_query("select empfullname from ".$db_prefix."employees where time_admin = '1' and groups = ('".$get_group."') 
                                 and office = ('".$get_office."')");
@$time_admin_count_rows = mysql_num_rows($time_admin_count);

$reports_count = mysql_query("select empfullname from ".$db_prefix."employees where reports = '1' and groups = ('".$get_group."') 
                              and office = ('".$get_office."')");
@$reports_count_rows = mysql_num_rows($reports_count);

if ($user_count_rows > '0') {

echo "            <br /><br /><br /><hr /><br />\n";
echo "            <table width=90% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>Members of $get_group Group in $get_office Office</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total
                      Users: $user_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_orange.png' />&nbsp;&nbsp;
                      Sys Admin Users: $admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_red.png' />&nbsp;&nbsp;
                      Time Admin Users: $time_admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_suit.png' />&nbsp;
                      &nbsp;Reports Users: $reports_count_rows</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=90% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Username</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Display Name</th>\n";
echo "                <th class=table_heading nowrap width=28% align=left>Email Address</th>\n";
echo "                <th class=table_heading width=3% align=center>Disabled</th>\n";
echo "                <th class=table_heading width=3% align=center>Sys Admin</th>\n";
echo "                <th class=table_heading width=3% align=center>Time Admin</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Reports</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading width=5% align=center>Change Passwd</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th></tr>\n";

$row_count = 0;

$query = "select empfullname, displayname, email, groups, office, admin, reports, time_admin, disabled from ".$db_prefix."employees
          where groups = ('".$get_group."') and office = ('".$get_office."') order by empfullname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$empfullname = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows width=23%>&nbsp;<a class=footer_links title=\"Edit User: $empfullname\"
                    href=\"useredit.php?username=$empfullname\">$empfullname</a></td>\n";
echo "                <td class=table_rows width=23%>&nbsp;$displayname</td>\n";
echo "                <td class=table_rows width=28%>&nbsp;".$row["email"]."</td>\n";

if ("".$row["disabled"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/cross.png' /></td>\n";
} else {
  $disabled = "";
  echo "                <td class=table_rows width=3% align=center>".$disabled."</td>\n";
}
if ("".$row["admin"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $admin = "";
  echo "                <td class=table_rows width=3% align=center>".$admin."</td>\n";
}
if ("".$row["time_admin"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $time_admin = "";
  echo "                <td class=table_rows width=3% align=center>".$time_admin."</td>\n";
}
if ("".$row["reports"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $reports = "";
  echo "                <td class=table_rows width=3% align=center>".$reports."</td>\n";
}

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Edit User: $empfullname\"
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Change Password: $empfullname\"
                    href=\"chngpasswd.php?username=$empfullname&officename=".$row["office"]."\">Chg Pwd</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Delete User: $empfullname\"
                    href=\"userdelete.php?username=$empfullname&officename=".$row["office"]."\">Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a title=\"Edit User: $empfullname\" 
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">
                    <img border=0 src='../images/icons/application_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Change Password: $empfullname\" 
                    href=\"chngpasswd.php?username=$empfullname&officename=".$row["office"]."\"><img border=0
                    src='../images/icons/lock_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Delete User: $empfullname\" 
                    href=\"userdelete.php?username=$empfullname&officename=".$row["office"]."\">
                    <img border=0 src='../images/icons/delete.png' /></a></td></tr>\n";
}
}}
if ($user_count_rows > '0') {
  echo "            </table></td></tr>\n";include '../footer.php'; exit;
} elseif ($user_count_rows == '0') {
  echo "            </td></tr>\n";include '../footer.php'; exit;
}

} else {

$query4 = "update ".$db_prefix."employees set groups = ('".$post_groupname."'), office = ('".$post_officename."') 
           where groups = ('".$get_group."') and office = ('".$get_office."')";
$result4 = mysql_query($query4);

$query5 = "update ".$db_prefix."groups set groupname = ('".$post_groupname."'), officeid = ('".$post_officeid."') 
           where groupname = ('".$get_group."') and officeid = ('".$orig_officeid."')";
$result5 = mysql_query($query5);

echo "            <table align=center class=table_border width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr>\n";
echo "                <td class=table_rows width=20 align=center><img src='../images/icons/accept.png' /></td>
                <td class=table_rows_green>&nbsp;Group properties updated successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/group_edit.png' />&nbsp;&nbsp;&nbsp;Edit Group
                -&nbsp;$get_group</th>\n";
echo "              </tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Group Name:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$post_groupname</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>New Parent Office:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$post_officename</td></tr>\n";
echo "              <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>User Count:</td><td align=left class=table_rows 
                      colspan=2 width=80% style='padding-left:20px;'>$user_cnt</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";
echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td height=20 align=left>&nbsp;</td></tr>\n";
echo "              <tr><td><a href='groupadmin.php'><img src='../images/buttons/done_button.png' 
                      border='0'></a></td></tr></table>\n";

$user_count = mysql_query("select empfullname from ".$db_prefix."employees where groups = ('".$post_groupname."') and office = ('".$post_officename."')
                           order by empfullname");
@$user_count_rows = mysql_num_rows($user_count);

$admin_count = mysql_query("select empfullname from ".$db_prefix."employees where admin = '1' and groups = ('".$post_groupname."') and 
                            office = ('".$post_officename."')");
@$admin_count_rows = mysql_num_rows($admin_count);

$time_admin_count = mysql_query("select empfullname from ".$db_prefix."employees where time_admin = '1' and groups = ('".$post_groupname."') and 
                                 office = ('".$post_officename."')");
@$time_admin_count_rows = mysql_num_rows($time_admin_count);

$reports_count = mysql_query("select empfullname from ".$db_prefix."employees where reports = '1' and groups = ('".$post_groupname."') and 
                              office = ('".$post_officename."')");
@$reports_count_rows = mysql_num_rows($reports_count);

if ($user_count_rows > '0') {

echo "            <br /><br /><br /><hr /><br />\n";
echo "            <table width=90% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>Members of $post_groupname Group in $post_officename 
                      Office</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total
                      Users: $user_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_orange.png' />&nbsp;&nbsp;
                      Sys Admin Users: $admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_red.png' />&nbsp;&nbsp;
                      Time Admin Users: $time_admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_suit.png' />&nbsp;
                      &nbsp;Reports Users: $reports_count_rows</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=90% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Username</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Display Name</th>\n";
echo "                <th class=table_heading nowrap width=28% align=left>Email Address</th>\n";
echo "                <th class=table_heading width=3% align=center>Disabled</th>\n";
echo "                <th class=table_heading width=3% align=center>Sys Admin</th>\n";
echo "                <th class=table_heading width=3% align=center>Time Admin</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Reports</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading width=5% align=center>Change Passwd</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th></tr>\n";

$row_count = 0;

$query = "select empfullname, displayname, email, groups, office, admin, reports, time_admin, disabled from ".$db_prefix."employees
          where groups = ('".$post_groupname."') order by empfullname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$empfullname = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows width=24%>&nbsp;<a class=footer_links title=\"Edit User: $empfullname\"
                    href=\"useredit.php?username=$empfullname\">$empfullname</a></td>\n";
echo "                <td class=table_rows width=24%>&nbsp;$displayname</td>\n";
echo "                <td class=table_rows width=29%>&nbsp;".$row["email"]."</td>\n";

if ("".$row["disabled"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/cross.png' /></td>\n";
} else {
  $disabled = "";
  echo "                <td class=table_rows width=3% align=center>".$disabled."</td>\n";
}
if ("".$row["admin"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $admin = "";
  echo "                <td class=table_rows width=3% align=center>".$admin."</td>\n";
}
if ("".$row["time_admin"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $time_admin = "";
  echo "                <td class=table_rows width=3% align=center>".$time_admin."</td>\n";
}
if ("".$row["reports"]."" == 1) {
  echo "                <td class=table_rows width=3% align=center><img src='../images/icons/accept.png' /></td>\n";
} else {
  $reports = "";
  echo "                <td class=table_rows width=3% align=center>".$reports."</td>\n";
}

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Edit User: $empfullname\"
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Change Password: $empfullname\"
                    href=\"chngpasswd.php?username=$empfullname&officename=".$row["office"]."\">Chg Pwd</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;'
                    title=\"Delete User: $empfullname\"
                    href=\"userdelete.php?username=$empfullname&officename=".$row["office"]."\">Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a title=\"Edit User: $empfullname\" 
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">
                    <img border=0 src='../images/icons/application_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Change Password: $empfullname\" 
                    href=\"chngpasswd.php?username=$empfullname&officename=".$row["office"]."\"><img border=0
                    src='../images/icons/lock_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Delete User: $empfullname\" 
                    href=\"userdelete.php?username=$empfullname&officename=".$row["office"]."\">
                    <img border=0 src='../images/icons/delete.png' /></a></td></tr>\n";
}
}}
if ($user_count_rows > '0') {
  echo "            </table></td></tr>\n";include '../footer.php'; exit;
} elseif ($user_count_rows == '0') {
  echo "            </td></tr>\n";include '../footer.php'; exit;
}}}
?>
