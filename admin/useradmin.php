<?php

session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - User Summary</title>\n";

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

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <table class=hide width=100% border=0 cellpadding=1 cellspacing=0>\n";
echo "        <tr><td class=left_rows height=11></td></tr>\n";
echo "        <tr><td class=left_rows_headings height=18 valign=middle>Users</td></tr>\n";
echo "        <tr><td class=current_left_rows height=18 align=left valign=middle><img src='../images/icons/user.png' alt='User Summary' />&nbsp;&nbsp;
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
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png' alt='Edit System Settings' />
                &nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";

$user_count = mysql_query("select empfullname from ".$db_prefix."employees
                           order by empfullname");
@$user_count_rows = mysql_num_rows($user_count);

$admin_count = mysql_query("select empfullname from ".$db_prefix."employees where admin = '1'");
@$admin_count_rows = mysql_num_rows($admin_count);

$time_admin_count = mysql_query("select empfullname from ".$db_prefix."employees where time_admin = '1'");
@$time_admin_count_rows = mysql_num_rows($time_admin_count);

$reports_count = mysql_query("select empfullname from ".$db_prefix."employees where reports = '1'");
@$reports_count_rows = mysql_num_rows($reports_count);

echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <table width=90% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% halign=left>User Summary</th></tr>\n";
echo "              <tr><td height=40 class=table_rows nowrap halign=left><img src='../images/icons/user_green.png' />&nbsp;&nbsp;Total 
                      Users: $user_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_orange.png' />&nbsp;&nbsp;
                      Sys Admin Users: $admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_red.png' />&nbsp;&nbsp;
                      Time Admin Users: $time_admin_count_rows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/icons/user_suit.png' />&nbsp;
                      &nbsp;Reports Users: $reports_count_rows</td></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=90% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <th class=table_heading nowrap width=3% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=13% align=left>Username</th>\n";
echo "                <th class=table_heading nowrap width=18% align=left>Display Name</th>\n";
//echo "                <th class=table_heading nowrap width=23% align=left>Email Address</th>\n";
echo "                <th class=table_heading nowrap width=10% align=left>Office</th>\n";
echo "                <th class=table_heading nowrap width=10% align=left>Group</th>\n";
echo "                <th class=table_heading width=3% align=center>Disabled</th>\n";
echo "                <th class=table_heading width=3% align=center>Sys Admin</th>\n";
echo "                <th class=table_heading width=3% align=center>Time Admin</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Reports</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading width=3% align=center>Chg Pwd</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th>\n";
echo "              </tr>\n";

$row_count = 0;

$query = "select empfullname, displayname, email, groups, office, admin, reports, time_admin, disabled from ".$db_prefix."employees
          order by empfullname";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$empfullname = stripslashes("".$row['empfullname']."");
$displayname = stripslashes("".$row['displayname']."");

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr class=table_border bgcolor='$row_color'><td nowrap class=table_rows width=3%>&nbsp;$row_count</td>\n";
echo "                <td class=table_rows nowrap width=13%>&nbsp;<a title=\"Edit User: $empfullname\" class=footer_links 
                    href=\"useredit.php?username=$empfullname&officename=".$row["office"]."\">$empfullname</a></td>\n";
echo "                <td class=table_rows nowrap width=18%>&nbsp;$displayname</td>\n";
//echo "                <td class=table_rows nowrap width=23%>&nbsp;".$row["email"]."</td>\n";
echo "                <td class=table_rows nowrap width=10%>&nbsp;".$row['office']."</td>\n";
echo "                <td class=table_rows nowrap width=10%>&nbsp;".$row['groups']."</td>\n";

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
}
echo "          </table></td></tr>\n";
include '../footer.php'; 
exit;
?>
