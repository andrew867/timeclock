<?php
session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Status Summary</title>\n";

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
echo "        <tr><td class=current_left_rows height=18 align=left valign=middle><img src='../images/icons/application.png' alt='Status Summary' />
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
echo "            <table width=60% align=center height=40 border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading_no_color nowrap width=100% valign=top halign=left>Status Summary</th></tr>\n";
echo "            </table>\n";
echo "            <table class=table_border width=60% align=center border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th class=table_heading nowrap width=7% align=left>&nbsp;</th>\n";
echo "                <th class=table_heading nowrap width=23% align=left>Status Name</th>\n";
echo "                <th class=table_heading nowrap width=60% align=left>Color</th>\n";
echo "                <th class=table_heading nowrap width=4% align=center>In/Out</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Edit</th>\n";
echo "                <th class=table_heading nowrap width=3% align=center>Delete</th></tr>\n";

$row_count = 0;

$query = "select * from ".$db_prefix."punchlist";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

$punchitem = "".$row['punchitems']."";
$color = "".$row['color']."";
$in_or_out = "".$row['in_or_out']."";

$row_count++;
$row_color = ($row_count % 2) ? $color2 : $color1;

if ($in_or_out == '1') {
  $in_or_out_tmp = 'In';
} elseif ($in_or_out == '0') {
  $in_or_out_tmp = 'Out';
}

echo "              <tr class=table_border bgcolor='$row_color'><td nowrap class=table_rows width=7%>&nbsp;$row_count</td>\n";
echo "                <td nowrap class=table_rows width=23%>&nbsp;<a class=footer_links title='Edit Status: $punchitem'
                    href='statusedit.php?statusname=$punchitem'>$punchitem</a></td>\n";
echo "                <td class=table_rows width=60% align=left style='color:$color';>&nbsp;$color</td>\n";
echo "                <td nowrap class=table_rows width=4% align=center>$in_or_out_tmp</td>\n";

if ((strpos($user_agent, "MSIE 6")) || (strpos($user_agent, "MSIE 5")) || (strpos($user_agent, "MSIE 4")) || (strpos($user_agent, "MSIE 3"))) {

echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;' title=\"Edit Status: $punchitem\" 
                    href=\"statusedit.php?statusname=$punchitem\">Edit</a></td>\n";
echo "                <td class=table_rows width=3% align=center><a style='color:#27408b;text-decoration:underline;' title=\"Delete Status: $punchitem\" 
                    href=\"statusdelete.php?statusname=$punchitem\">Delete</a></td></tr>\n";
} else {
echo "                <td class=table_rows width=3% align=center><a title=\"Edit Status: $punchitem\" href=\"statusedit.php?statusname=$punchitem\">
                    <img border=0 src='../images/icons/application_edit.png' /></a></td>\n";
echo "                <td class=table_rows width=3% align=center><a title=\"Delete Status: $punchitem\" href=\"statusdelete.php?statusname=$punchitem\">
                    <img border=0 src='../images/icons/delete.png' /></a></td></tr>\n";
}
}
echo "          </table></td></tr>\n";
include '../footer.php';
?>
