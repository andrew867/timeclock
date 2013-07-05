<?php
session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

include '../config.inc.php';
if ($request == 'GET') {include 'header_get_sysedit.php'; include 'topmain.php';}
echo "<title>$title - Edit System Settings</title>\n";

$filename = '../config.inc.php';
$row_count = '0';
$row_color = ($row_count % 2) ? $color2 : $color1;

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

if (!file_exists($filename)) {
echo "            <table align=center width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <td height=25 class=table_rows_red>config.inc.php does not exist!</td></tr>\n";
echo "                <td height=25 class=table_rows_red>It has either been deleted, renamed, moved, or was never installed.</td></tr>\n";
echo "            </table></td></tr>\n";include '../footer.php';
exit;
}

if (!is_readable($filename)) {
echo "            <table align=center width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr>\n";
echo "                <td class=table_rows_red>config.inc.php is not readable by your webserver user!</td></tr>\n";
echo "              <tr><td height=25 class=table_rows_red>Change the permissions accordingly on config.inc.php for this user, or assign this file 
                      to another owner, preferably your webserver user.</td></tr>\n";
if(PHP_OS != 'WIN32') {
$user = posix_getpwuid(fileowner($filename));
$group = posix_getgrgid(filegroup($filename));

echo "              <tr><td height=25 class=table_rows_red> Current owner of config.inc.php is&nbsp;";
echo $user["name"];
echo ".";
echo $group["name"];
echo "&nbsp;&nbsp;(user.group).</td></tr>\n";
}
echo "            </table></td></tr>\n";include '../footer.php';
}

if ($request == 'GET') {

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr valign=top>\n";
echo "    <td class=left_main width=180 align=left scope=col>\n";
echo "      <form name='form' action='$self' method='post'>\n";
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
echo "        <tr><td class=current_left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png' 
                alt='Edit System Settings' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";

if ($disable_sysedit == "yes") {
echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><td height=25 class=table_rows_red>This page has been <b>disabled</b> within config.inc.php.</td></tr>";
echo "            </table></td></tr>\n";include '../footer.php';
exit;
}

if (!is_writable($filename)) {
if(PHP_OS != 'WIN32') {
$user = posix_getpwuid(fileowner($filename));
$group = posix_getgrgid(filegroup($filename));
$process_user = posix_getpwuid(posix_getuid());
$process_group = posix_getgrgid(posix_getgid());

echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><td height=25 class=table_rows_red>The PHP Timeclock config file, config.inc.php, <b><i>is not writable</i></b> by your webserver 
                      user:&nbsp;";
echo "<b>";
echo $process_user['name'];
echo "</b>.<b>";
echo $process_group['name'];
echo "</b>&nbsp;&nbsp;(user.group).</td></tr>\n";
echo "              <tr><td height=25 class=table_rows_red>To edit the System Settings within PHP Timeclock, either change the permissions
                      on config.inc.php for this user, or assign this file to another owner, preferably your webserver user.</td></tr>\n";
echo "              <tr><td height=25 class=table_rows_red> Current owner of config.inc.php is&nbsp;<b>";
echo $user["name"];
echo "</b>.<b>";
echo $group["name"];
echo "</b>&nbsp;&nbsp;(user.group).</td></tr>\n";
echo "            </table></td></tr>\n";include '../footer.php';
exit;

} else {

echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><td height=25 class=table_rows_red>The PHP Timeclock config file, config.inc.php, <b><i>is not writable</i></b> by your webserver 
                      user!</td></tr>\n";
echo "              <tr><td height=25 class=table_rows_red>To edit the System Settings within PHP Timeclock, either change the permissions 
                      on config.inc.php for this user, or assign this file to another owner, preferably your webserver user.</td></tr>\n";
echo "            </table></td></tr>\n";include '../footer.php';
exit;
}}

// begin double-checking of some of the settings in config.inc.php //

if ($refresh != "none") {
  $tmp_refresh = intval($refresh);
  if (!empty($tmp_refresh)) {
    $refresh = $tmp_refresh;
  }
}

if (strlen($color1) > 7) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>color1</b> is not a valid color.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($color2) > 7) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>color2</b> is not a valid color.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif ((!eregi ("^(#[a-fA-F0-9]{6})+$", $color1)) && (!eregi ("^([a-fA-F0-9]{6})+$", $color1))) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>color1</b> is not a valid color.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif ((!eregi ("^(#[a-fA-F0-9]{6})+$", $color2)) && (!eregi ("^([a-fA-F0-9]{6})+$", $color2))) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>color2</b> is not a valid color.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($logo) > 200) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>logo</b> is longer than the allowed 200 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($refresh) > 10) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>refresh</b> is longer than the allowed 10 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($email) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>email</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($date_link) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>date_link</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($app_name) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>app_name</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif (strlen($app_version) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>app_version</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif ((strlen($metar) > 4) || (!eregi ("^([a-zA-Z]{4})+$", $metar))) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>metar</b> is not a valid metar.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif ((strlen($city) > 100)) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>city</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}elseif ((!is_integer($refresh)) || (empty($refresh))) {
if ((empty($refresh)) || ($refresh != 'none')){ 
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>refresh</b> should be an integer (other than zero) or set to \"none\".</td></tr>\n";
echo "            </table>\n";
$evil = "1";
echo "            <br />\n";
}
}elseif (!isset($evil)) {
  for ($x=0;$x<count($links);$x++) {
    $links[$x] = addslashes($links[$x]);
      if (strlen($links[$x]) > 100) {
        $evil_link = "1";
      }
  }
  for ($x=0;$x<count($display_links);$x++) {
    $display_links[$x] = addslashes($display_links[$x]);
      if (strlen($display_links[$x]) > 100) {
        $evil_display_link = "1";
      }
  }
  for ($x=0;$x<count($allowed_networks);$x++) {
      if (strlen($allowed_networks[$x]) > 21) {
        $evil_allowed_network = "1";
      }
  }
  if (isset($evil_link)) {
        echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
        echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                          <td class=table_rows_red height=25>One of the <b>links</b> is longer than the allowed 100 characters.</td></tr>\n";
        echo "            </table>\n";
        echo "            <br />\n";
  } elseif (isset($evil_display_link)) {
    echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                      <td class=table_rows_red height=25>One of the <b>display_links</b> is longer than the allowed 100 characters.</td></tr>\n";
    echo "            </table>\n";
    echo "            <br />\n";
  } elseif (isset($evil_allowed_network)) {
    echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                      <td class=table_rows_red height=25>One of the <b>allowed_networks</b> is longer than the allowed 21 characters.</td></tr>\n";
    echo "            </table>\n";
    echo "            <br />\n";
  } elseif ((!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+([a|p]+m)$", $report_start_time, $start_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+( [a|p]+m)$", $report_start_time, $start_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])$", $report_start_time, $start_time_regs))) {
      echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
      echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                        <td class=table_rows_red height=25><b>report_start_time</b> is not a valid time.</td></tr>\n";
      echo "            </table>\n";
      echo "            <br />\n";
  } elseif ((!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+([a|p]+m)$", $report_end_time, $end_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+( [a|p]+m)$", $report_end_time, $end_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])$", $report_end_time, $end_time_regs))) {
      echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
      echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                        <td class=table_rows_red height=25><b>report_end_time</b> is not a valid time.</td></tr>\n";
      echo "            </table>\n";
      echo "            <br />\n";
  } elseif ((isset($start_time_regs)) && (isset($end_time_regs))) {
      $start_h = $start_time_regs[1]; $start_m = $start_time_regs[2];
      $end_h = $end_time_regs[1]; $end_m = $end_time_regs[2];
      if (($start_h > 23) || ($start_m > 59)) {
        echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
        echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                          <td class=table_rows_red height=25><b>report_start_time</b> is not a valid time.</td></tr>\n";
        echo "            </table>\n";
        echo "            <br />\n";
      } elseif (($end_h > 23) || ($end_m > 59)) {
        echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
        echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                          <td class=table_rows_red height=25><b>report_end_time</b> is not a valid time.</td></tr>\n";
        echo "            </table>\n";
        echo "            <br />\n";
      } 
  }
}

// end double-checking of some of the settings in config.inc.php

echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Edit System Settings</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Listed below are the 
                      settings that have been chosen within config.inc.php, the config file for PHP Timeclock. Edit as you see fit. Then 
                      click the \"Next\" button near the bottom of the page to continue.</td></tr>\n";
echo "              <tr><td height=40 class=table_rows width=10% align=left style='padding-left:4px;color:#27408b;'><b><u>VARIABLE</u></b></td>
                  <td class=table_rows width=10% align=left style='color:#27408b;'><b><u>VALUE</u></b></td>
                  <td class=table_rows width=80% align=left style='padding-left:10px;color:#27408b;'><b><u>DESCRIPTION</u></b></td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>MySql DB Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_hostname:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_hostname</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the hostname for your 
                      mysql server, default is <b>localhost</b>.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_hostname\" value=\"$db_hostname\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the name of the mysql 
                      database you created during the install.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_name\" value=\"$db_name\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_username:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_username</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the mysql username you 
                      created during the install.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_username\" value=\"$db_username\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_password:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>********</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the mysql password for 
                      the username you created during the install.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_password\" value=\"$db_password\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_prefix:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_prefix</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This adds a prefix to the
                      tablenames in the database. This can be helpful if you have an existing mysql database that you would like to use with PHP
                      Timeclock. If you are unaware of what is meant by 'table prefix', then please leave this option as is. Default is to leave it
                      blank.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_prefix\" value=\"$db_prefix\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>dbversion:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$dbversion</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the versioning number of 
                      the current database for PHP Timeclock.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"dbversion\" value=\"$dbversion\">\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Passwords and Security</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_passwd:</td>\n";
if ($use_passwd == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_passwd\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_passwd\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($use_passwd == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_passwd\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_passwd\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_passwd\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This provides the option 
                      for the users to input their password when individually punching in/out of the timeclock. Default 
                      is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_reports_password:</td>\n";
if ($use_reports_password == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_reports_password\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_reports_password\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($use_reports_password == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_reports_password\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_reports_password\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_reports_password\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>If ALL users need access to 
                      ALL the reports provided, then set this to \"no\". Default is \"<b>no</b>\".</td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>restrict_ips:</td>\n";
if ($restrict_ips == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"restrict_ips\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"restrict_ips\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($restrict_ips == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"restrict_ips\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"restrict_ips\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"restrict_ips\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose \"yes\" to restrict the
                      ip addresses that can connect to PHP Timeclock. If \"yes\" is chosen, you MUST input the allowed networks in the
                      allowed_networks array below. Otherwise, choosing \"yes\" here and leaving allowed_networks blank will cause PHP Timeclock
                      to reject everyone attempting to connect to it. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>allowed_networks:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>\n";
if ($allowed_networks == "none") {
  $allowed_networks = "0";
}
for ($x=0;$x<count($allowed_networks);$x++) {
if (empty($allowed_networks[$x])) {
  echo "                      <input type=\"text\" size=\"21\" maxlength=\"21\" name=\"allowed_networks[$x]\" />\n";
} else {
  echo "                      <input type=\"text\" size=\"21\" maxlength=\"21\" name=\"allowed_networks[$x]\" value=\"$allowed_networks[$x]\" />\n";
}
}
if (count($allowed_networks) < '5') {
for($x=count($allowed_networks);$x<'5';$x++) {
echo "                      <input type=\"text\" size=\"21\" maxlength=\"21\" name=\"allowed_networks[$x]\" />\n";
}}
echo "                  </td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are the networks or ip
                      addresses you wish to allow to connect to PHP Timeclock. This will currently only work for ipv4 addresses, ipv6 may be supported 
                      in a future release. If <b>restrict_ips</b> is set to \"<b>no</b>\", this option is ignored. To add more than 5 networks, you 
                      will need to add them manually in config.inc.php.<p>
                      <b><u>examples that will work</u></b>:<br>10.0.0.4<br>192.168.1.[11-20]<br>192.168.1.0/24<br>192.0.0.0/8<br><br>
                      <b><u>examples that will NOT work</u></b>:<br>10.1.1.15[0-9]<br>10.1.1.1 - 10.1.1.254<br>10.1.1.</p><br></td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>ip_logging:</td>\n";
if ($ip_logging == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"ip_logging\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"ip_logging\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($ip_logging == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"ip_logging\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"ip_logging\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"ip_logging\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Enable the option to log 
                      the ip addresses of the connecting computers when users punch-in/out, or when a time is manually added, edited, or deleted.
                      Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>disable_sysedit:</td>\n";
if ($disable_sysedit == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"disable_sysedit\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"disable_sysedit\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"disable_sysedit\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choosing \"yes\" disables 
                      ALL access to <u>this</u> page (sysedit.php). It can be re-enabled in config.inc.php. Default is \"<b>no</b>\".</td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color align=left>Dates and Times</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Choose the way dates and times are to be 
                      displayed throughout the entire application.</td></tr>\n";
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'><u>Date 
                      Format:</u></td></tr>\n";
echo "              <tr><td width=100% colspan=3><table width=100% border=0 cellpadding=0 cellspacing=0>\n";
if ($tmp_datefmt == "d.m.yyyy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" checked />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" />&nbsp;d-m-yyyy</td></tr>\n";
} elseif ($tmp_datefmt == "d/m/yyyy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" checked />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' 
                      class=table_rows width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" />&nbsp;d-m-yyyy</td></tr>\n";
} elseif ($tmp_datefmt == "d-m-yyyy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" checked />&nbsp;d-m-yyyy</td></tr>\n";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" />&nbsp;d-m-yyyy</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($tmp_datefmt == "d.m.yy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" checked />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" />&nbsp;d-m-yy</td></tr>\n";
} elseif ($tmp_datefmt == "d/m/yy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" checked />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" />&nbsp;d-m-yy</td></tr>\n";
} elseif ($tmp_datefmt == "d-m-yy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" checked />&nbsp;d-m-yy</td></tr>\n";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" />&nbsp;d-m-yy</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($tmp_datefmt == "m.d.yyyy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" checked />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\" />&nbsp;m-d-yyyy</td></tr>\n";
} elseif ($tmp_datefmt == "m/d/yyyy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" checked />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\" />&nbsp;m-d-yyyy</td></tr>\n";
} elseif ($tmp_datefmt == "m-d-yyyy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\" checked />&nbsp;m-d-yyyy</td></tr>\n";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\"  />&nbsp;m-d-yyyy</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($tmp_datefmt == "m.d.yy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" checked />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" />&nbsp;m-d-yy</td></tr>";
} elseif ($tmp_datefmt == "m/d/yy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=15% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=15% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" checked />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=70% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" />&nbsp;m-d-yy</td></tr>";
} elseif ($tmp_datefmt == "m-d-yy") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" checked />&nbsp;m-d-yy</td></tr>";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" />&nbsp;m-d-yy</td></tr>";
}
if (($tmp_datefmt != "d.m.yyyy") && ($tmp_datefmt != "d/m/yyyy") && ($tmp_datefmt != "d-m-yyyy") && ($tmp_datefmt != "d.m.yy") && 
($tmp_datefmt != "d/m/yy") && ($tmp_datefmt != "d-m-yy") && ($tmp_datefmt != "m.d.yyyy") && ($tmp_datefmt != "m/d/yyyy") && 
($tmp_datefmt != "m-d-yyyy") && ($tmp_datefmt != "m.d.yy") && ($tmp_datefmt != "m/d/yy") && ($tmp_datefmt != "m-d-yy")) {
echo "              <tr><td colspan=3 valign=bottom height=30 bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>A valid Date 
                      Format has not been chosen in config.inc.php!! Choose one from above.</b></td></tr>\n";
}
echo "</table></td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'><u>Time 
                      Format:</u></td></tr>\n";
if ($timefmt == "G:i") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"1\" checked />24 hour format without leading zeroes</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"1\" />24 hour format without leading zeroes</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($timefmt == "H:i") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"2\" checked />24 hour format with leading zeroes</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"2\" />24 hour format with leading zeroes</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($timefmt == "g:i A") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"3\" checked />12 hour format with uppercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"3\" />12 hour format with uppercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($timefmt == "g:i a") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"4\" checked />12 hour format with lowercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"4\" />12 hour format with lowercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($timefmt == "g:iA") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"5\" checked />12 hour format with uppercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"5\" />12 hour format with uppercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($timefmt == "g:ia") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"6\" checked />12 hour format with lowercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"6\" />12 hour format with lowercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
}
if (($timefmt != "G:i") && ($timefmt != "H:i") && ($timefmt != "g:i A") && ($timefmt != "g:i a") && ($timefmt != "g:iA") && 
($timefmt != "g:ia")) {
echo "              <tr><td colspan=3 valign=bottom height=30 bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>A valid Time 
                      Format has not been chosen in config.inc.php!! Choose one from above.</b></td></tr>\n";
}
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color align=left>Reports Settings</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Choose the way the reports are 
                      formatted <u>by default</u>. Most of these default settings can be changed when the reports are run.</td></tr>\n";
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>
                      <u>Round a User's Time:</u></td></tr>\n";
echo "              <tr><td width=100% colspan=3><table width=100% border=0 cellpadding=0 cellspacing=0>\n";
if ($round_time == '1') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"1\" checked />&nbsp;To the nearest 5 minutes (1/12th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"4\" />&nbsp;To the nearest 20 minutes (1/3rd of an hour)</td></tr>\n";
} elseif ($round_time == '4') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"1\" />&nbsp;To the nearest minutes (1/12th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"4\" checked/>&nbsp;To the nearest 20 minutes (1/3rd of an hour)</td></tr>\n";
} else {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"1\" />&nbsp;To the nearest 5 minutes (1/12th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"4\" />&nbsp;To the nearest 20 minutes (1/3rd of an hour)</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($round_time == '2') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"2\" checked />&nbsp;To the nearest 10 minutes (1/6th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"5\" />&nbsp;To the nearest 30 minutes (1/2 of an hour)</td></tr>\n";
} elseif ($round_time == '5') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"2\" />&nbsp;To the nearest 10 minutes (1/6th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"5\" checked/>&nbsp;To the nearest 30 minutes (1/2 of an hour)</td></tr>\n";
} else {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"2\" />&nbsp;To the nearest 10 minutes (1/6th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"5\" />&nbsp;To the nearest 30 minutes (1/2 of an hour)</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($round_time == '3') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"3\" checked />&nbsp;To the nearest 15 minutes (1/4th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"0\" />&nbsp;Do not round.</td></tr>\n";
} elseif (empty($round_time)) {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"3\" />&nbsp;To the nearest 15 minutes (1/4th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"0\" checked />&nbsp;Do not round.</td></tr>\n";
} else {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"3\" />&nbsp;To the nearest 15 minutes (1/4th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"0\" />&nbsp;Do not round.</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ((!empty($round_time)) && ($round_time != '1') && ($round_time != '2') && ($round_time != '3') && ($round_time != '4') && ($round_time != '5')) {
echo "              <tr><td colspan=3 valign=bottom height=30 bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top 
                      style='padding-left:5px;'><b>A valid Rounding Method has not been chosen in config.inc.php!! Choose one from above.</b></td></tr>\n";
}
echo "            </table></td></tr>\n";
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>
                      <u>Other Reports Settings:</u></td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>paginate:</td>\n";
if ($paginate == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"paginate\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"paginate\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($paginate == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"paginate\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"paginate\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"paginate\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to paginate 
                      the Hours Worked report or not. Setting this option to \"yes\" will print each user's time on their own separate page. 
                      Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>show_details:</td>\n";
if ($show_details == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_details\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"show_details\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($show_details == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_details\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"show_details\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"show_details\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to show the 
                      punch-in/out details for each punch for each user on the Hours Worked report or not. Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>report_start_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"8\"
                      name=\"report_start_time\" value=\"$report_start_time\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These two variables,
                      report_start_time and report_end_time, are designed to work with the Hours Worked report. They are there to provide a starting
                      time to go along with the starting date, and an ending time to go along with the ending date for the dates specified when the 
                      report is run. Default is \"<b>00:00</b>\" (12:00am). 12 hour and 24 hour formats are supported.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>report_end_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"8\"
                      name=\"report_end_time\" value=\"$report_end_time\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is \"<b>23:59</b>\" 
                      (11:59pm). 12 hour and 24 hour formats are supported.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>username_dropdown_only:</td>\n";
if ($username_dropdown_only == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"username_dropdown_only\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"username_dropdown_only\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($username_dropdown_only == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"username_dropdown_only\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"username_dropdown_only\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"username_dropdown_only\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this variable to 
                      \"yes\" will display a single dropdown box containing usernames to choose from when running the reports. Setting this 
                      variable to \"no\" will instead display a triple dropdown box containing offices, groups, and usernames to choose from when running 
                      the reports. A single dropdown box works well if there are just a few usernames in the system, and a triple dropdown 
                      works well if multiple offices and/or groups are in the system. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>user_or_display:</td>\n";
if (strtolower($user_or_display) == "user") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"user_or_display\" 
                      value=\"1\" checked />&nbsp;User<input type=\"radio\" name=\"user_or_display\" value=\"0\" />&nbsp;Display</td>\n";
} elseif (strtolower($user_or_display) == "display") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"user_or_display\" 
                      value=\"1\" />&nbsp;User<input type=\"radio\" name=\"user_or_display\" value=\"0\" checked />&nbsp;Display</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"User\" or \"Display\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"user_or_display\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to print
                      displaynames or usernames for each user when reports are run. Options for this variable are \"user\" and \"display\".
                      Default is \"<b>user</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_ip:</td>\n";
if (strtolower($display_ip) == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_ip\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_ip\" value=\"0\" />&nbsp;No</td>\n";
} elseif (strtolower($display_ip) == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_ip\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_ip\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_ip\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to include
                      in the reports the ip addresses of the systems that connect to sign-in/out into PHP Timeclock or not. This option
                      is useful for auditing purposes. The <b>ip_logging</b> option must be set to \"<b>yes</b>\" in order for this option to 
                      work as expected. Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>export_csv:</td>\n";
if (strtolower($export_csv) == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"export_csv\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"export_csv\" value=\"0\" />&nbsp;No</td>\n";
} elseif (strtolower($export_csv) == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"export_csv\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"export_csv\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"export_csv\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose \"<b>yes</b>\" to 
                      export the reports to a comma delimited file (.csv). Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Timezone Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_client_tz:</td>\n";
if ($use_client_tz == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_client_tz\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_client_tz\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($use_client_tz == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_client_tz\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_client_tz\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_client_tz\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this option to 
                      \"yes\" will display the punch-in/out times according to the timezone of the connecting computer, providing javascript is 
                      enabled in the user's browser. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_server_tz:</td>\n";
if ($use_server_tz == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_server_tz\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_server_tz\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($use_server_tz == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_server_tz\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_server_tz\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_server_tz\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this option to 
                      \"yes\" will display the punch-in/out times according to the timezone of the web server. Setting this option to \"no\" AND setting 
                      'use_client_tz' to \"no\" will display the punch-in/out times in GMT. Default is \"<b>yes</b>\".
                 </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Display Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>color1:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"7\"
                      name=\"color1\" value=\"$color1\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>When times are displayed 
                      anywhere within PHP Timeclock, they are displayed with these two alternating row colors. Default is \"<b>#EFEFEF</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>color2:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"7\"
                      name=\"color2\" value=\"$color2\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% alitn=left style='padding-left:10px;' valign=top>Default is 
                      \"<b>#FBFBFB</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_current_users:</td>\n";
if ($display_current_users == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_current_users\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_current_users\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($display_current_users == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_current_users\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_current_users\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_current_users\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only the current 
                      day's activity instead of the last entry from each user. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>show_display_name:</td>\n";
if ($show_display_name == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_display_name\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"show_display_name\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($show_display_name == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_display_name\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"show_display_name\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"show_display_name\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Show a user's Display Name 
                      instead of their username on the main page. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_office:</td>\n";
echo "                     <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                            <select name='office_name' onchange='group_names();'>
                          <option selected>$display_office</option>\n";
echo "                      </select></td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a certain 
                      office on the main page of the application, instead of all the users. Default is \"<b>all</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_group:</td>\n";
if (($display_office == "all") || ($display_office == "All")) {

echo "                     <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                             <select name='group_name'>
                          <option value = 'all'>all</option>\n";

$query = "select DISTINCT(groupname) from groups order by groupname asc";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
  if ("".$row['groupname']."" == $display_group) {
  echo "                    <option selected>".$row['groupname']."</option>\n";
  } else {
  echo "                    <option>".$row['groupname']."</option>\n";
  }
}
echo "                      </select></td>\n";
} else {
echo "                     <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                             <select name='group_name' onfocus='group_names();'>
                          <option selected>$display_group</option>\n";
echo "                      </select></td>\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only a certain 
                      group on the main page of the application, instead of a particular office, or all the users. If \"all\" is chosen for the 
                      office, then you can choose any group in the list. This is there for if you have 2 or more groups with the same name, but with 
                      each having a different parent office. In this case, if you wanted to display all members of the groups with the same name, you 
                      could do this without having to choose an office. Default is \"<b>all</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;

echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_office_name:</td>\n";
if ($display_office_name == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_office_name\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_office_name\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($display_office_name == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_office_name\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_office_name\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_office_name\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a column on the 
                      main page that shows the office each user is affiliated with. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_group_name:</td>\n";
if ($display_group_name == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_group_name\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_group_name\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($display_group_name == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_group_name\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_group_name\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_group_name\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a column on the 
                      main page that shows the group each user is affiliated with. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_weather:</td>\n";
if ($display_weather == "yes") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_weather\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_weather\" value=\"0\" />&nbsp;No</td>\n";
} elseif ($display_weather == "no") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_weather\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_weather\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_weather\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>To display local weather 
                      info on the left side of the application just below the submit button, set this to \"yes\". Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>metar:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"4\"
                      name=\"metar\" value=\"$metar\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the ICAO (International 
                      Civil Aviation Organization) for your local airport. This is the unique four letter international ID for the airport. METAR 
                      reports are created at roughly 4500 airports from around the world, so you probably live near one of them. The airports make a 
                      report once or twice an hour, and these reports are stored at the National Weather Service and are publically available via HTTP 
                      or FTP. Visit <a href='https://pilotweb.nas.faa.gov/qryhtml/icao/' class=admin_headings style='text-decoration:underline;'> 
                      https://pilotweb.nas.faa.gov/qryhtml/icao/</a> to find a corresponding ICAO near you. If 'display_weather' is set 
                      to \"no\", this option is ignored. If 'display_weather' is set to \"yes\", you must provide an ICAO here.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$city = htmlentities($city);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>city:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"30\" maxlength=\"100\"
                      name=\"city\" value=\"$city\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the city and state (or 
                      can be city and country, or really can be anything you want) of the airport for the ICAO used above. If 'display_weather' is set 
                      to \"no\", this option is ignored.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>links:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>\n";
if ($links == "none") {
  $links = "0";
}
for ($x=0;$x<count($links);$x++) {
$links[$x] = htmlentities($links[$x]);
if (empty($links[$x])) {
  echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"links[$x]\" />\n";
} else {
  echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"links[$x]\" value=\"$links[$x]\" />\n";
}
}
if (count($links) < '10') {
for($x=count($links);$x<'10';$x++) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"links[$x]\" />\n";
}}
echo "                  </td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are links to 
                      websites, other web-based applications, etc., that you wish to display in the topleft of the application just below the 
                      logo. To display these links accordingly, use the 'display_links' option in conjunction with this option. To add more than 10 
                      links, you will need to add them manually in config.inc.php. Leave all 10 blanks empty to ignore this option.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_links:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>\n";

if ($display_links == "none") {
  $display_links = "0";
}
for ($x=0;$x<count($display_links);$x++) {
$display_links[$x] = htmlentities($display_links[$x]);
if (empty($display_links[$x])) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"display_links[$x]\" />\n";
} else {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"display_links[$x]\" value=\"$display_links[$x]\" />\n";
}
}
if (count($display_links) < '10') {
for($x=count($display_links);$x<'10';$x++) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"display_links[$x]\" />\n";
}}
echo "                  </td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are the display names 
                      for the links chosen above, meaning these are the items that are actually displayed in PHP Timeclock. The number of 
                      display_links MUST equal the number of links you have chosen above, in order for this option to work as expected. To add more 
                      than 10 links, you will need to add them manually in config.inc.php. Leave all 10 blanks empty to ignore this option.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$logo = htmlentities($logo);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>logo:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"30\" maxlength=\"200\"
                      name=\"logo\" value=\"$logo\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is a logo or graphic 
                      displayed in the top left of each page. Set it to \"none\" to ignore this option.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>refresh:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"10\"
                      name=\"refresh\" value=\"$refresh\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the refresh rate (in 
                      seconds) for the application. If PHP Timeclock is kept open, it will refresh this number of seconds to display the most current 
                      information. Set it to \"none\" to ignore this option. Default is <b>300</b>.
                 </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Miscellaneous Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>email:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"32\" maxlength=\"100\"
                      name=\"email\" value=\"$email\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is an email address to 
                      display in the footer. Set it to \"none\" to ignore this option.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$date_link = htmlentities($date_link);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>date_link:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"32\" maxlength=\"100\"
                      name=\"date_link\" value=\"$date_link\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>If your users click on the 
                      displayed date in the top right of the application, they will be taken to this website. Set it to \"none\" to ignore this option. 
                      Default is 'This Day in History', <b>http://www.historychannel.com/tdih</b>.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$app_name = htmlentities($app_name);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>app_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"25\" maxlength=\"100\"
                      name=\"app_name\" value=\"$app_name\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the first half of the 
                      'title' shown below.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$app_version = htmlentities($app_version);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>app_version:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"25\" maxlength=\"100\"
                      name=\"app_version\" value=\"$app_version\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the second half of the 
                      'title' shown below.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>title:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$title</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the title in the header. 
                      This is what is displayed in the title bar of your web browser, and it is what the page will be named by default when you make a 
                      \"favorite\" or \"bookmark\" in your web browser.
                  </td></tr>\n";
echo "          </table>\n";
echo "          <input type=\"hidden\" name=\"title\" value=\"$title\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td width=62 valign=middle><input type='image' name='submit' value='Add Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='index.php'><img src='../images/buttons/cancel_button.png' 
                      border='0'></td></tr></table></form></td></tr>\n";include '../footer.php'; exit;

} elseif ($request == 'POST') {

include 'header_post_sysedit.php'; include 'topmain.php';

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
echo "        <tr><td class=current_left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png'
                alt='Edit System Settings' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <form name='form' action='$self' method='post'>\n";

$post_db_hostname = $_POST['db_hostname'];
$post_db_name = $_POST['db_name'];
$post_db_username = $_POST['db_username'];
$post_db_password = $_POST['db_password'];
$post_db_prefix = $_POST['db_prefix'];
$post_dbversion = $_POST['dbversion'];
$post_use_passwd = $_POST['use_passwd'];
$post_use_reports_password = $_POST['use_reports_password'];
@$post_tmp_datefmt = $_POST['tmp_datefmt'];
@$post_timefmt = $_POST['timefmt'];
$post_use_client_tz = $_POST['use_client_tz'];
$post_use_server_tz = $_POST['use_server_tz'];
$post_color1 = $_POST['color1'];
$post_color2 = $_POST['color2'];
$post_office_name = $_POST['office_name'];
$post_group_name = $_POST['group_name'];
$post_display_current_users = $_POST['display_current_users'];
$post_display_weather = $_POST['display_weather'];
$post_show_display_name = $_POST['show_display_name'];
$post_display_office_name = $_POST['display_office_name'];
$post_display_group_name = $_POST['display_group_name'];
$post_metar = $_POST['metar'];
$post_city = addslashes($_POST['city']);
$post_links = $_POST['links'];
$post_display_links = $_POST['display_links'];
$post_logo = addslashes($_POST['logo']);
$post_refresh = $_POST['refresh'];

if ($post_refresh != "none") {$tmp_refresh = intval($post_refresh);
  if (!empty($tmp_refresh)) {$post_refresh = $tmp_refresh;
  }
}

$post_email = $_POST['email'];
$post_date_link = addslashes($_POST['date_link']);
$post_app_name = addslashes($_POST['app_name']);
$post_app_version = addslashes($_POST['app_version']);
$post_title = $_POST['title'];
@$post_round_time = $_POST['round_time'];
$post_paginate = $_POST['paginate'];
$post_show_details = $_POST['show_details'];
$post_username_dropdown_only = $_POST['username_dropdown_only'];
$post_disable_sysedit = $_POST['disable_sysedit'];
$post_user_or_display = $_POST['user_or_display'];
$post_report_start_time = $_POST['report_start_time'];
$post_report_end_time = $_POST['report_end_time'];
$post_display_ip = $_POST['display_ip'];
$post_ip_logging = $_POST['ip_logging'];
$post_export_csv = $_POST['export_csv'];
$post_restrict_ips = $_POST['restrict_ips'];
$post_allowed_networks = $_POST['allowed_networks'];

// begin post validation //

if ($post_office_name != 'all') {
$query = "select * from offices where officename = '".$post_office_name."'";
$result = mysql_query($query);
while ($row=mysql_fetch_array($result)) {
$officename = "".$row['officename']."";
}
if (!isset($officename)) {echo "Office name is not in the database.\n"; exit;}
}

if ($post_group_name != 'all') {
$query2 = "select * from groups where groupname = '".$post_group_name."'";
$result2 = mysql_query($query2);
while ($row2=mysql_fetch_array($result2)) {
$groupname = "".$row2['groupname']."";
}
if (!isset($groupname)) {echo "Group name is not in the database.\n"; exit;}
}

if ($post_db_hostname != $db_hostname) {echo "db_hostname in config.inc.php does not equal the posted db_hostname. Something is fishy here.\n"; exit;}
if ($post_db_name != $db_name) {echo "db_name in config.inc.php does not equal the posted db_name. Something is fishy here.\n"; exit;}
if ($post_db_username != $db_username) {echo "db_username in config.inc.php does not equal the posted db_username. Something is fishy here.\n"; exit;}
if ($post_db_password != $db_password) {echo "db_password in config.inc.php does not equal the posted db_password. Something is fishy here.\n"; exit;}
if ($post_db_prefix != $db_prefix) {echo "db_prefix in config.inc.php does not equal the posted db_prefix. Something is fishy here.\n"; exit;}
if ($post_dbversion != $dbversion) {echo "dbversion in config.inc.php does not equal the posted dbversion. Something is fishy here.\n"; exit;}
if ($post_title != $title) {echo "title in config.inc.php does not equal the posted title. Something is fishy here.\n"; exit;}

if (($post_use_passwd != '0') && ($post_use_passwd != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>use_passwd</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_use_reports_password != '0') && ($post_use_reports_password != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>use_reports_password</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_restrict_ips != '0') && ($post_restrict_ips != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>restrict_ips</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_disable_sysedit != '0') && ($post_disable_sysedit != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>disable_sysedit</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_user_or_display != '0') && ($post_user_or_display != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>user_or_display</b> does not equal \"user\" or \"display\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_display_ip != '0') && ($post_display_ip != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>display_ip</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_ip_logging != '0') && ($post_ip_logging != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>ip_logging</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_export_csv != '0') && ($post_export_csv != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>export_csv</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_tmp_datefmt != '1') && ($post_tmp_datefmt != '2') && ($post_tmp_datefmt != '3') && ($post_tmp_datefmt != '4') && 
($post_tmp_datefmt != '5') && ($post_tmp_datefmt != '6') && ($post_tmp_datefmt != '7') && ($post_tmp_datefmt != '8') && ($post_tmp_datefmt != '9') && 
($post_tmp_datefmt != '10') && ($post_tmp_datefmt != '11') && ($post_tmp_datefmt != '12')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>Date Format</b> is not a valid date format.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_timefmt != '1') && ($post_timefmt != '2') && ($post_timefmt != '3') && ($post_timefmt != '4') && 
($post_timefmt != '5') && ($post_timefmt != '6')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>Time Format</b> is not a valid time format.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif ((!empty($post_round_time)) && ($post_round_time != '1') && ($post_round_time != '2') && ($post_round_time != '3') && ($post_round_time != '4') 
&& ($post_round_time != '5')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>Round a Users Time</b> is not a valid option.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_use_client_tz != '0') && ($post_use_client_tz != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>use_client_tz</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_use_server_tz != '0') && ($post_use_server_tz != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>use_server_tz</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_use_server_tz == '1') && ($post_use_client_tz == '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>use_server_tz</b> and <b>use_client_tz</b> cannot both be set to  \"yes\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif ((!eregi ("^(#[a-fA-F0-9]{6})+$", $post_color1)) && (!eregi ("^([a-fA-F0-9]{6})+$", $post_color1))) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>color1</b> is not a valid color.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif ((!eregi ("^(#[a-fA-F0-9]{6})+$", $post_color2)) && (!eregi ("^([a-fA-F0-9]{6})+$", $post_color2))) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>color2</b> is not a valid color.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_display_current_users != '0') && ($post_display_current_users != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>display_current_users</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_show_display_name != '0') && ($post_show_display_name != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>show_display_name</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_display_office_name != '0') && ($post_display_office_name != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>display_office_name</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_display_group_name != '0') && ($post_display_group_name != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>display_group_name</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_paginate != '0') && ($post_paginate != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>paginate</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_show_details != '0') && ($post_show_details != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>show_display</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_username_dropdown_only != '0') && ($post_username_dropdown_only != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>username_dropdown_only</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (($post_display_weather != '0') && ($post_display_weather != '1')) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>display_weather</b> does not equal \"yes\" or \"no\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif ((isset($post_metar)) && (!eregi ("^([a-zA-Z]{4})+$", $post_metar))) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>metar</b> is not a valid metar.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif ((isset($post_city)) && (strlen($post_city)) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>city</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (strlen($post_logo) > 200) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25>The path to your <b>logo</b> is longer than the allowed 200 characters.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif ((!is_integer($post_refresh)) || (empty($post_refresh))) {
if ((empty($post_refresh)) || ($post_refresh != 'none')){ 
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>refresh</b> should be an integer (other than zero) or set to \"none\".</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}
}elseif ((!eregi ("^([[:alnum:]]|_|\.|-)+@([[:alnum:]]|\.|-)+(\.)([a-z]{2,4})$", $post_email)) && ($post_email != "none")) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25>Only alphanumeric characters, underscores, periods, and hyphens are allowed when creating an Email 
                      Address.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (strlen($post_date_link) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>date_link</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (strlen($post_app_name) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>app_name</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (strlen($post_app_version) > 100) {
echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                  <td class=table_rows_red height=25><b>app_version</b> is longer than the allowed 100 characters.</td></tr>\n";
echo "            </table>\n";
$evil_post = "1";
}elseif (!isset($evil_post)) {
  for ($x=0;$x<count($post_links);$x++) {
    $post_links[$x] = addslashes($post_links[$x]);
      if (strlen($post_links[$x]) > 100) {
        $evil_links = "1";
        $evil_post = "1";
      }
  }
  for ($x=0;$x<count($post_display_links);$x++) {
    $post_display_links[$x] = addslashes($post_display_links[$x]);
      if (strlen($post_display_links[$x]) > 100) {
        $evil_display_links = "1";
        $evil_post = "1";
      }
  }
  for ($x=0;$x<count($post_allowed_networks);$x++) {
      if ((strlen($post_allowed_networks[$x]) > 21)) {
        $evil_allowed_networks_length = "1";
        $evil_post = "1";
      } elseif ((!eregi("^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$", $post_allowed_networks[$x], $net_regs)) &&
        (!eregi("^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/([0-9]?[0-9]?[0-9])$", $post_allowed_networks[$x], $net_regs)) &&
        (!eregi("^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.\[([0-9]?[0-9]?[0-9])\-([0-9]?[0-9]?[0-9])\]$", $post_allowed_networks[$x], $net_regs)) &&
        (!empty($post_allowed_networks[$x]))) {
          $evil_allowed_networks = "1";
          $evil_post = "1";
      } elseif ((eregi("^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$", $post_allowed_networks[$x], $net_regs)) ||
        (eregi("^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/([0-9]?[0-9]?[0-9])$", $post_allowed_networks[$x], $net_regs)) ||
        (eregi("^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.\[([0-9]?[0-9]?[0-9])\-([0-9]?[0-9]?[0-9])\]$", $post_allowed_networks[$x], $net_regs)) ||
        (!empty($post_allowed_networks[$x]))) {

        if (strstr($post_allowed_networks[$x], '/')) {
            if ((($net_regs[1] < '0') || ($net_regs[1] > '255')) || (($net_regs[2] < '0') || ($net_regs[2] > '255')) || (($net_regs[3] < '0') || 
                ($net_regs[3] > '255')) || (($net_regs[4] < '0') || ($net_regs[4] > '255')) || ((isset($net_regs[5])) && (($net_regs[5] < '0') || 
                ($net_regs[5] > '32')))) {
                $evil_allowed_networks = "1";
                $evil_post = "1";
            }
        } else {
            if ((($net_regs[1] < '0') || ($net_regs[1] > '255')) || (($net_regs[2] < '0') || ($net_regs[2] > '255')) || (($net_regs[3] < '0') || 
                ($net_regs[3] > '255')) || (($net_regs[4] < '0') || ($net_regs[4] > '255')) || ((isset($net_regs[5])) && (($net_regs[5] < '0') || 
                ($net_regs[5] > '255')))) {
                $evil_allowed_networks = "1";
                $evil_post = "1";
            }
        }
      }
  }
  if (isset($evil_links)) {
    echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                      <td class=table_rows_red height=25>One of the <b>links</b> is longer than the allowed 100 characters.</td></tr>\n";
    echo "            </table>\n";
  } elseif (isset($evil_display_links)) {
    echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                      <td height=25 class=table_rows_red>one of the <b>display_links</b> is more than the allowed 100 characters.</td></tr>\n";
    echo "            </table>\n";
  } elseif (isset($evil_allowed_networks)) {
    echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                      <td height=25 class=table_rows_red>one of the <b>allowed_networks</b> is not a valid ip address or network.</td></tr>\n";
    echo "            </table>\n";
  } elseif (isset($evil_allowed_networks_length)) {
    echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                      <td height=25 class=table_rows_red>one of the <b>allowed_networks</b> is more than the allowed 21 characters.</td></tr>\n";
    echo "            </table>\n";
  } elseif ((!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+([a|p]+m)$", $post_report_start_time, $start_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+( [a|p]+m)$", $post_report_start_time, $start_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])$", $post_report_start_time, $start_time_regs))) {
      echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
      echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                        <td class=table_rows_red height=25><b>report_start_time</b> is not a valid time.</td></tr>\n";
      echo "            </table>\n";
      echo "            <br />\n";
      $evil_post = "1";
  } elseif ((!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+([a|p]+m)$", $post_report_end_time, $end_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])+( [a|p]+m)$", $post_report_end_time, $end_time_regs)) && 
    (!eregi ("^([0-9]?[0-9])+:+([0-9]+[0-9])$", $post_report_end_time, $end_time_regs))) {
      echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
      echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                        <td class=table_rows_red height=25><b>report_end_time</b> is not a valid time.</td></tr>\n";
      echo "            </table>\n";
      echo "            <br />\n";
      $evil_post = "1";
  } elseif ((isset($start_time_regs)) && (isset($end_time_regs))) {
      $start_h = $start_time_regs[1]; $start_m = $start_time_regs[2];
      $end_h = $end_time_regs[1]; $end_m = $end_time_regs[2];
      if (($start_h > 23) || ($start_m > 59)) {
        echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
        echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                          <td class=table_rows_red height=25><b>report_start_time</b> is not a valid time.</td></tr>\n";
        echo "            </table>\n";
        echo "            <br />\n";
        $evil_post = "1";
      } elseif (($end_h > 23) || ($end_m > 59)) {
        echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
        echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/cancel.png' /></td>
                          <td class=table_rows_red height=25><b>report_end_time</b> is not a valid time.</td></tr>\n";
        echo "            </table>\n";
        echo "            <br />\n";
        $evil_post = "1";
      } 
  }
}

// end post validation //

if (isset($evil_post)) {

echo "            <br />\n";
echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Edit System Settings</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Listed below are the 
                      settings that have been chosen within config.inc.php, the config file for PHP Timeclock. Edit as you see fit. Then 
                      click the \"Next\" button near the bottom of the page to continue.</td></tr>\n";
echo "              <tr><td height=40 class=table_rows width=10% align=left style='padding-left:4px;color:#27408b;'><b><u>VARIABLE</u></b></td>
                  <td class=table_rows width=10% align=left style='color:#27408b;'><b><u>VALUE</u></b></td>
                  <td class=table_rows width=80% align=left style='padding-left:10px;color:#27408b;'><b><u>DESCRIPTION</u></b></td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>MySql DB Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_hostname:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_hostname</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the hostname for your 
                      mysql server, default is <b>localhost</b>.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_hostname\" value=\"$post_db_hostname\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the name of the mysql 
                      database you created during the install.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_name\" value=\"$post_db_name\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_username:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_username</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the mysql username you 
                      created during the install.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_username\" value=\"$post_db_username\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_password:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>********</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the mysql password for 
                      the username you created during the install.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_password\" value=\"$post_db_password\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_prefix:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_prefix</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This adds a prefix to the
                      tablenames in the database. This can be helpful if you have an existing mysql database that you would like to use with PHP
                      Timeclock. If you are unaware of what is meant by 'table prefix', then please leave this option as is. Default is to leave it
                      blank.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"db_prefix\" value=\"$post_db_prefix\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>dbversion:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$dbversion</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the versioning number of 
                      the current database for PHP Timeclock.</td></tr>\n";
echo "              <input type=\"hidden\" name=\"dbversion\" value=\"$post_dbversion\">\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Passwords</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_passwd:</td>\n";
if ($post_use_passwd == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_passwd\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_passwd\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_use_passwd)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_passwd\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_passwd\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_passwd\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This provides the option 
                      for the users to input their password when individually punching in/out of the timeclock. Default 
                      is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_reports_password:</td>\n";
if ($post_use_reports_password == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_reports_password\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_reports_password\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_use_reports_password)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_reports_password\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_reports_password\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_reports_password\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>If ALL users need access to 
                      ALL the reports provided, then set this to \"no\". Default is \"<b>no</b>\".</td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>restrict_ips:</td>\n";
if ($post_restrict_ips == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"restrict_ips\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"restrict_ips\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_restrict_ips)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"restrict_ips\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"restrict_ips\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"restrict_ips\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose \"yes\" to restrict the
                      ip addresses that can connect to PHP Timeclock. If \"yes\" is chosen, you MUST input the allowed networks in the
                      allowed_networks array below. Otherwise, choosing \"yes\" here and leaving allowed_networks blank will cause PHP Timeclock
                      to reject everyone attempting to connect to it. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>allowed_networks:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>\n";
for ($x=0;$x<count($post_allowed_networks);$x++) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"21\" name=\"allowed_networks[$x]\" value=\"$post_allowed_networks[$x]\" />\n";
}
if (count($post_allowed_networks) < '5') {
for($x=count($post_allowed_networks);$x<'5';$x++) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"21\" name=\"allowed_networks[$x]\" />\n";
}}
echo "                  </td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are the networks or ip
                      addresses you wish to allow to connect to PHP Timeclock. This will currently only work for ipv4 addresses, ipv6 may be supported 
                      in a future release. If <b>restrict_ips</b> is set to \"<b>no</b>\", this option is ignored. To add more than 5 networks, you 
                      will need to add them manually in config.inc.php.<p>
                      <b><u>examples that will work</u></b>:<br>10.0.0.4<br>192.168.1.[11-20]<br>192.168.1.0/24<br>192.0.0.0/8<br><br>
                      <b><u>examples that will NOT work</u></b>:<br>10.1.1.15[0-9]<br>10.1.1.1 - 10.1.1.254<br>10.1.1.</p><br></td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>ip_logging:</td>\n";
if ($post_ip_logging == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"ip_logging\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"ip_logging\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_ip_logging)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"ip_logging\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"ip_logging\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"ip_logging\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Enable the option to log 
                      the ip addresses of the connecting computers when users punch-in/out, or when a time is manually added, edited, or deleted.
                      Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>disable_sysedit:</td>\n";
if ($post_disable_sysedit == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"disable_sysedit\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"disable_sysedit\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_disable_sysedit)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"disable_sysedit\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"disable_sysedit\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"disable_sysedit\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choosing \"yes\" disables 
                      ALL access to <u>this</u> page (sysedit.php). It can be re-enabled in config.inc.php. Default is \"<b>no</b>\".</td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color align=left>Dates and Times</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Choose the way dates and times are to be 
                      displayed throughout the entire application.</td></tr>\n";
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'><u>Date 
                      Format:</u></td></tr>\n";
echo "              <tr><td width=100% colspan=3><table width=100% border=0 cellpadding=0 cellspacing=0>\n";
if ($post_tmp_datefmt == "1") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" checked />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" />&nbsp;d-m-yyyy</td></tr>\n";
} elseif ($post_tmp_datefmt == "2") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" checked />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' 
                      class=table_rows width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" />&nbsp;d-m-yyyy</td></tr>\n";
} elseif ($post_tmp_datefmt == "3") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" checked />&nbsp;d-m-yyyy</td></tr>\n";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"1\" />&nbsp;d.m.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"2\" />&nbsp;d/m/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"3\" />&nbsp;d-m-yyyy</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_tmp_datefmt == "4") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" checked />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" />&nbsp;d-m-yy</td></tr>\n";
} elseif ($post_tmp_datefmt == "5") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" checked />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" />&nbsp;d-m-yy</td></tr>\n";
} elseif ($post_tmp_datefmt == "6") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" checked />&nbsp;d-m-yy</td></tr>\n";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"4\" />&nbsp;d.m.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"5\" />&nbsp;d/m/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"6\" />&nbsp;d-m-yy</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_tmp_datefmt == "7") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" checked />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\" />&nbsp;m-d-yyyy</td></tr>\n";
} elseif ($post_tmp_datefmt == "8") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" checked />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=80% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\" />&nbsp;m-d-yyyy</td></tr>\n";
} elseif ($post_tmp_datefmt == "9") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\" checked />&nbsp;m-d-yyyy</td></tr>\n";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"7\" />&nbsp;m.d.yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"8\" />&nbsp;m/d/yyyy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"9\"  />&nbsp;m-d-yyyy</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_tmp_datefmt == "10") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" checked />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" />&nbsp;m-d-yy</td></tr>";
} elseif ($post_tmp_datefmt == "11") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=15% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=15% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" checked />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows 
                      width=70% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" />&nbsp;m-d-yy</td></tr>";
} elseif ($post_tmp_datefmt == "12") {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" checked />&nbsp;m-d-yy</td></tr>";
} else {
echo "              <tr><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" 
                      value=\"10\" />&nbsp;m.d.yy</td><td nowrap bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                      <input type=\"radio\" name=\"tmp_datefmt\" value=\"11\" />&nbsp;m/d/yy</td><td nowrap bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top><input type=\"radio\" name=\"tmp_datefmt\" value=\"12\" />&nbsp;m-d-yy</td></tr>";
}
if (($post_tmp_datefmt != "1") && ($post_tmp_datefmt != "2") && ($post_tmp_datefmt != "3") && ($post_tmp_datefmt != "4") &&
($post_tmp_datefmt != "5") && ($post_tmp_datefmt != "6") && ($post_tmp_datefmt != "7") && ($post_tmp_datefmt != "8") &&
($post_tmp_datefmt != "9") && ($post_tmp_datefmt != "10") && ($post_tmp_datefmt != "11") && ($post_tmp_datefmt != "12")) {
echo "              <tr><td colspan=3 valign=bottom height=30 bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>A valid Date
                      Format has not been chosen in config.inc.php!! Choose one from above.</b></td></tr>\n";
}
echo "</table></td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'><u>Time 
                      Format:</u></td></tr>\n";
if ($post_timefmt == "1") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"1\" checked />24 hour format without leading zeroes</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"1\" />24 hour format without leading zeroes</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_timefmt == "2") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"2\" checked />24 hour format with leading zeroes</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"2\" />24 hour format with leading zeroes</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_timefmt == "3") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"3\" checked />12 hour format with uppercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"3\" />12 hour format with uppercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_timefmt == "4") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"4\" checked />12 hour format with lowercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"4\" />12 hour format with lowercase am/pm indicator, including a space between the minutes and 
                      meridiems</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_timefmt == "5") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"5\" checked />12 hour format with uppercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"5\" />12 hour format with uppercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_timefmt == "6") {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"6\" checked />12 hour format with lowercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
} else {
echo "              <tr><td colspan=3 bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"timefmt\" 
                      value=\"6\" />12 hour format with lowercase am/pm indicator, no space between the minutes and meridiems</td></tr>\n";
}
if (($post_timefmt != "1") && ($post_timefmt != "2") && ($post_timefmt != "3") && ($post_timefmt != "4") && ($post_timefmt != "5") && 
($post_timefmt != "6")) {
echo "              <tr><td colspan=3 valign=bottom height=30 bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>A valid Time 
                      Format has not been chosen in config.inc.php!! Choose one from above.</b></td></tr>\n";
}
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color align=left>Reports Settings</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Choose the way the reports are 
                      formatted <u>by default</u>. Most of these default settings can be changed when the reports are run.</td></tr>\n";
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>
                      <u>Round a User's Time:</u></td></tr>\n";
echo "              <tr><td width=100% colspan=3><table width=100% border=0 cellpadding=0 cellspacing=0>\n";
if ($post_round_time == '1') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"1\" checked />&nbsp;To the nearest 5 minutes (1/12th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"4\" />&nbsp;To the nearest 20 minutes (1/3rd of an hour)</td></tr>\n";
} elseif ($post_round_time == '4') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"1\" />&nbsp;To the nearest 5 minutes (1/12th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"4\" checked/>&nbsp;To the nearest 20 minutes (1/3rd of an hour)</td></tr>\n";
} else {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"1\" />&nbsp;To the nearest 5 minutes (1/12th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"4\" />&nbsp;To the nearest 20 minutes (1/3rd of an hour)</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_round_time == '2') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"2\" checked />&nbsp;To the nearest 10 minutes (1/6th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"5\" />&nbsp;To the nearest 30 minutes (1/2 of an hour)</td></tr>\n";
} elseif ($post_round_time == '5') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"2\" />&nbsp;To the nearest 10 minutes (1/6th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"5\" checked/>&nbsp;To the nearest 30 minutes (1/2 of an hour)</td></tr>\n";
} else {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"2\" />&nbsp;To the nearest 10 minutes (1/6th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"5\" />&nbsp;To the nearest 30 minutes (1/2 of an hour)</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ($post_round_time == '3') {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"3\" checked />&nbsp;To the nearest 15 minutes (1/4th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"0\" />&nbsp;Do not round.</td></tr>\n";
} elseif (empty($post_round_time)) {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"3\" />&nbsp;To the nearest 15 minutes (1/4th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"0\" checked />&nbsp;Do not round.</td></tr>\n";
} else {
echo "              <tr><td bgcolor='$row_color' class=table_rows width=20% align=left valign=top nowrap><input type=\"radio\" name=\"round_time\" 
                      value=\"3\" />&nbsp;To the nearest 15 minutes (1/4th of an hour)</td><td bgcolor='$row_color' class=table_rows width=80% 
                      align=left valign=top>
                      <input type=\"radio\" name=\"round_time\" value=\"0\" />&nbsp;Do not round.</td></tr>\n";
}
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
if ((!empty($post_round_time)) && ($post_round_time != '1') && ($post_round_time != '2') && ($post_round_time != '3') && ($post_round_time != '4') && 
($post_round_time != '5')) 
{
echo "              <tr><td colspan=3 valign=bottom height=30 bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top 
                      style='padding-left:5px;'><b>A valid Rounding Method has not been chosen in config.inc.php!! Choose one from above.</b></td></tr>\n";
}
echo "            </table></td></tr>\n";
echo "              <tr><td height=25 valign=bottom colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>
                      <u>Other Reports Settings:</u></td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>paginate:</td>\n";
if ($post_paginate == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"paginate\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"paginate\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_paginate)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"paginate\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"paginate\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"paginate\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to paginate 
                      the Hours Worked report or not. Setting this option to \"yes\" will print each user's time on their own separate page. 
                      Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>show_details:</td>\n";
if ($post_show_details == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_details\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"show_details\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_show_details)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_details\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"show_details\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"show_details\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to show the 
                      punch-in/out details for each punch for each user on the Hours Worked report or not. Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>report_start_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"8\"
                      name=\"report_start_time\" value=\"$post_report_start_time\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These two variables,
                      report_start_time and report_end_time, are designed to work with the Hours Worked report. They are there to provide a starting
                      time to go along with the starting date, and an ending time to go along with the ending date for the dates specified when the 
                      report is run. Default is \"<b>00:00</b>\" (12:00am). 12 hour and 24 hour formats are supported.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>report_end_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"8\"
                      name=\"report_end_time\" value=\"$post_report_end_time\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is \"<b>23:59</b>\" 
                      (11:59pm). 12 hour and 24 hour formats are supported.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>username_dropdown_only:</td>\n";
if ($post_username_dropdown_only == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"username_dropdown_only\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"username_dropdown_only\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_username_dropdown_only)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"username_dropdown_only\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"username_dropdown_only\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"username_dropdown_only\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this variable to 
                      \"yes\" will display a single dropdown box containing usernames to choose from when running the reports. Setting this 
                      variable to \"no\" will instead display a triple dropdown box containing offices, groups, and usernames to choose from when running 
                      the reports. A single dropdown box works well if there are just a few usernames in the system, and a triple dropdown 
                      works well if multiple offices and/or groups are in the system. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>user_or_display:</td>\n";
if ($post_user_or_display == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"user_or_display\" 
                      value=\"1\" checked />&nbsp;User<input type=\"radio\" name=\"user_or_display\" value=\"0\" />&nbsp;Display</td>\n";
} elseif (empty($post_user_or_display)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"user_or_display\" 
                      value=\"1\" />&nbsp;User<input type=\"radio\" name=\"user_or_display\" value=\"0\" checked />&nbsp;Display</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"User\" or \"Display\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"user_or_display\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to print 
                      displaynames or usernames for each user when reports are run. Options for this variable are \"user\" and \"display\". 
                      Default is \"<b>user</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_ip:</td>\n";
if ($post_display_ip == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_ip\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_ip\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_display_ip)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_ip\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_ip\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_ip\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to include
                      in the reports the ip addresses of the systems that connect to sign-in/out into PHP Timeclock or not. This option
                      is useful for auditing purposes. The <b>ip_logging</b> option must be set to \"<b>yes</b>\" in order for this option to work as
                      expected. Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>export_csv:</td>\n";
if ($post_export_csv == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"export_csv\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"export_csv\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_export_csv)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"export_csv\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"export_csv\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"export_csv\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose \"<b>yes</b>\" to 
                      export the reports to a comma delimited file (.csv). Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Timezone Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_client_tz:</td>\n";
if ($post_use_client_tz == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_client_tz\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_client_tz\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_use_client_tz)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_client_tz\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_client_tz\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_client_tz\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this option to 
                      \"yes\" will display the punch-in/out times according to the timezone of the connecting computer, providing javascript is 
                      enabled in the user's browser. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_server_tz:</td>\n";
if ($post_use_server_tz == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_server_tz\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"use_server_tz\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_use_server_tz)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"use_server_tz\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"use_server_tz\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"use_server_tz\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this option to 
                      \"yes\" will display the punch-in/out times according to the timezone of the web server. Setting this option to \"no\" AND setting 
                      'use_client_tz' to \"no\" will display the punch-in/out times in GMT. Default is \"<b>yes</b>\".
                 </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Display Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>color1:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"7\"
                      name=\"color1\" value=\"$post_color1\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>When times are displayed 
                      anywhere within PHP Timeclock, they are displayed with these two alternating row colors. Default is \"<b>#EFEFEF</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>color2:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"7\"
                      name=\"color2\" value=\"$post_color2\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% alitn=left style='padding-left:10px;' valign=top>Default is 
                      \"<b>#FBFBFB</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_current_users:</td>\n";
if ($post_display_current_users == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_current_users\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_current_users\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_display_current_users)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_current_users\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_current_users\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_current_users\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only the current 
                      day's activity instead of the last entry from each user. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>show_display_name:</td>\n";
if ($post_show_display_name == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_display_name\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"show_display_name\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_show_display_name)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"show_display_name\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"show_display_name\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"show_display_name\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Show a user's Display Name 
                      instead of their username on the main page. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_office:</td>\n";
echo "                     <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                            <select name='office_name' onchange='group_names();'>
//                          <option selected>$post_office_name</option>\n";
echo "                      </select></td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a certain 
                      office on the main page of the application, instead of all the users. Default is \"<b>all</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_group:</td>\n";
if (($display_office == "all") || ($display_office == "All")) {
echo "                     <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                             <select name='group_name'>
                          <option value = 'all'>all</option>\n";
$query = "select DISTINCT(groupname) from groups order by groupname asc";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {
  if ("".$row['groupname']."" == $post_group_name) {
  echo "                    <option selected>".$row['groupname']."</option>\n";
  } else {
  echo "                    <option>".$row['groupname']."</option>\n";
  }
}
echo "                      </select></td>\n";
} else {
echo "                     <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>
                             <select name='group_name' onfocus='group_names();'>
                          <option selected>$post_group_name</option>\n";
echo "                      </select></td>\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only a certain 
                      group on the main page of the application, instead of a particular office, or all the users. If \"all\" is chosen for the 
                      office, then you can choose any group in the list. This is there for if you have 2 or more groups with the same name, but with 
                      each having a different parent office. In this case, if you wanted to display all members of the groups with the same name, you 
                      could do this without having to choose an office. Default is \"<b>all</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_office_name:</td>\n";
if ($post_display_office_name == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_office_name\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_office_name\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_display_office_name)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_office_name\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_office_name\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_office_name\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a column on the 
                      main page that shows the office each user is affiliated with. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_group_name:</td>\n";
if ($post_display_group_name == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_group_name\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_group_name\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_display_group_name)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_group_name\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_group_name\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_group_name\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a column on the 
                      main page that shows the group each user is affiliated with. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_weather:</td>\n";
if ($post_display_weather == "1") {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_weather\" 
                      value=\"1\" checked />&nbsp;Yes<input type=\"radio\" name=\"display_weather\" value=\"0\" />&nbsp;No</td>\n";
} elseif (empty($post_display_weather)) {
echo "                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"radio\" name=\"display_weather\" 
                      value=\"1\" />&nbsp;Yes<input type=\"radio\" name=\"display_weather\" value=\"0\" checked />&nbsp;No</td>\n";
} else {
echo "                  <td bgcolor='$row_color' class=table_rows_red width=10% align=left valign=top><b>\"Yes\" or \"No\" has not been chosen in 
                      config.inc.php</b></td>\n";
echo "              <input type=\"hidden\" name=\"display_weather\" value=\"2\">\n";
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>To display local weather 
                      info on the left side of the application just below the submit button, set this to \"yes\". Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>metar:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"4\"
                      name=\"metar\" value=\"$post_metar\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the ICAO (International 
                      Civil Aviation Organization) for your local airport. This is the unique four letter international ID for the airport. METAR 
                      reports are created at roughly 4500 airports from around the world, so you probably live near one of them. The airports make a 
                      report once or twice an hour, and these reports are stored at the National Weather Service and are publically available via HTTP 
                      or FTP. Visit <a href='https://pilotweb.nas.faa.gov/qryhtml/icao/' class=admin_headings style='text-decoration:underline;'> 
                      https://pilotweb.nas.faa.gov/qryhtml/icao/</a> to find a corresponding ICAO near you. If 'display_weather' is set 
                      to \"no\", this option is ignored. If 'display_weather' is set to \"yes\", you must provide an ICAO here.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$post_city = stripslashes($post_city);
$post_city = htmlentities($post_city);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>city:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"30\" maxlength=\"100\"
                      name=\"city\" value=\"$post_city\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the city and state (or 
                      can be city and country, or really can be anything you want) of the airport for the ICAO used above. If 'display_weather' is set 
                      to \"no\", this option is ignored.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>links:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>\n";
for ($x=0;$x<count($post_links);$x++) {
$post_links[$x] = stripslashes($post_links[$x]);
$post_links[$x] = htmlentities($post_links[$x]);
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"links[$x]\" value=\"$post_links[$x]\" />\n";
}
if (count($post_links) < '10') {
for($x=count($post_links);$x<'10';$x++) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"links[$x]\" />\n";
}}
echo "                  </td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are links to 
                      websites, other web-based applications, etc., that you wish to display in the topleft of the application just below the 
                      logo. To display these links accordingly, use the 'display_links' option in conjunction with this option. To add more than 10 
                      links, you will need to add them manually in config.inc.php. Leave all 10 blanks empty to ignore this option.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_links:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>\n";
for ($x=0;$x<count($post_display_links);$x++) {
$post_display_links[$x] = stripslashes($post_display_links[$x]);
$post_display_links[$x] = htmlentities($post_display_links[$x]);
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"display_links[$x]\" value=\"$post_display_links[$x]\" />\n";
}
if (count($post_display_links) < '10') {
for($x=count($post_display_links);$x<'10';$x++) {
echo "                      <input type=\"text\" size=\"30\" maxlength=\"100\" name=\"display_links[$x]\" />\n";
}}
echo "                  </td>\n";
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are the display names 
                      for the links chosen above, meaning these are the items that are actually displayed in PHP Timeclock. The number of 
                      display_links MUST equal the number of links you have chosen above, in order for this option to work as expected. To add more 
                      than 10 links, you will need to add them manually in config.inc.php. Leave all 10 blanks empty to ignore this option.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$post_logo = stripslashes($post_logo);
$post_logo = htmlentities($post_logo);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>logo:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"30\" maxlength=\"200\"
                      name=\"logo\" value=\"$post_logo\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is a logo or graphic 
                      displayed in the top left of each page. Set it to \"none\" to ignore this option.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>refresh:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"10\" maxlength=\"10\"
                      name=\"refresh\" value=\"$post_refresh\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the refresh rate (in 
                      seconds) for the application. If PHP Timeclock is kept open, it will refresh this number of seconds to display the most current 
                      information. Set it to \"none\" to ignore this option. Default is <b>300</b>.
                 </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Miscellaneous Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>email:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"32\" maxlength=\"100\"
                      name=\"email\" value=\"$post_email\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is an email address to 
                      display in the footer. Set it to \"none\" to ignore this option.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$post_date_link = stripslashes($post_date_link);
$post_date_link = htmlentities($post_date_link);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>date_link:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"32\" maxlength=\"100\"
                      name=\"date_link\" value=\"$post_date_link\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>If your users click on the 
                      displayed date in the top right of the application, they will be taken to this website. Set it to \"none\" to ignore this option. 
                      Default is 'This Day in History', <b>http://www.historychannel.com/tdih</b>.
                 </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$post_app_name = stripslashes($post_app_name);
$post_app_name = htmlentities($post_app_name);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>app_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"25\" maxlength=\"100\"
                      name=\"app_name\" value=\"$post_app_name\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the first half of the 
                      'title' shown below.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
$post_app_version = stripslashes($post_app_version);
$post_app_version = htmlentities($post_app_version);
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>app_version:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top><input type=\"text\" size=\"25\" maxlength=\"100\"
                      name=\"app_version\" value=\"$post_app_version\" /></td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the second half of the 
                      'title' shown below.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>title:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$post_app_name $post_app_version</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the title in the header. 
                      This is what is displayed in the title bar of your web browser, and it is what the page will be named by default when you make a 
                      \"favorite\" or \"bookmark\" in your web browser.
                  </td></tr>\n";
echo "          </table>\n";
echo "          <input type=\"hidden\" name=\"title\" value=\"$title\">\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><td height=40>&nbsp;</td></tr>\n";
echo "              <tr><td width=62 valign=middle><input type='image' name='submit' value='Add Time' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='index.php'><img src='../images/buttons/cancel_button.png' 
                      border='0'></td></tr></table></form></td></tr>\n";include '../footer.php'; exit;

} else {

if (!empty($post_use_passwd)) {$post_use_passwd = "yes";} else {$post_use_passwd = "no";}
if (!empty($post_use_reports_password)) {$post_use_reports_password = "yes";} else {$post_use_reports_password = "no";}
if (!empty($post_use_client_tz)) {$post_use_client_tz = "yes";} else {$post_use_client_tz = "no";}
if (!empty($post_use_server_tz)) {$post_use_server_tz = "yes";} else {$post_use_server_tz = "no";}
if (!empty($post_display_current_users)) {$post_display_current_users = "yes";} else {$post_display_current_users = "no";}
if (!empty($post_display_weather)) {$post_display_weather = "yes";} else {$post_display_weather = "no";}
if (!empty($post_show_display_name)) {$post_show_display_name = "yes";} else {$post_show_display_name = "no";}
if (!empty($post_display_office_name)) {$post_display_office_name = "yes";} else {$post_display_office_name = "no";}
if (!empty($post_display_group_name)) {$post_display_group_name = "yes";} else {$post_display_group_name = "no";}
if (!empty($post_paginate)) {$post_paginate = "yes";} else {$post_paginate = "no";}
if (!empty($post_show_details)) {$post_show_details = "yes";} else {$post_show_details = "no";}
if (!empty($post_username_dropdown_only)) {$post_username_dropdown_only = "yes";} else {$post_username_dropdown_only = "no";}
if (!empty($post_disable_sysedit)) {$post_disable_sysedit = "yes";} else {$post_disable_sysedit = "no";}
if (!empty($post_user_or_display)) {$post_user_or_display = "user";} else {$post_user_or_display = "display";}
if (!empty($post_display_ip)) {$post_display_ip = "yes";} else {$post_display_ip = "no";}
if (!empty($post_ip_logging)) {$post_ip_logging = "yes";} else {$post_ip_logging = "no";}
if (!empty($post_export_csv)) {$post_export_csv = "yes";} else {$post_export_csv = "no";}
if (!empty($post_restrict_ips)) {$post_restrict_ips = "yes";} else {$post_restrict_ips = "no";}

if ($post_tmp_datefmt == "1") {$datefmt = "j.n.Y"; $js_datefmt = "d.M.yyyy"; $tmp_datefmt = "d.m.yyyy"; $calendar_style = "euro";}
if ($post_tmp_datefmt == "2") {$datefmt = "j/n/Y"; $js_datefmt = "d/M/yyyy"; $tmp_datefmt = "d/m/yyyy"; $calendar_style = "euro";}
if ($post_tmp_datefmt == "3") {$datefmt = "j-n-Y"; $js_datefmt = "d-M-yyyy"; $tmp_datefmt = "d-m-yyyy"; $calendar_style = "euro";}
if ($post_tmp_datefmt == "4") {$datefmt = "j.n.y"; $js_datefmt = "d.M.yy"; $tmp_datefmt = "d.m.yy"; $calendar_style = "euro";}
if ($post_tmp_datefmt == "5") {$datefmt = "j/n/y"; $js_datefmt = "d/M/yy"; $tmp_datefmt = "d/m/yy"; $calendar_style = "euro";}
if ($post_tmp_datefmt == "6") {$datefmt = "j-n-y"; $js_datefmt = "d-M-yy"; $tmp_datefmt = "d-m-yy"; $calendar_style = "euro";}
if ($post_tmp_datefmt == "7") {$datefmt = "n.j.Y"; $js_datefmt = "M.d.yyyy"; $tmp_datefmt = "m.d.yyyy"; $calendar_style = "amer";}
if ($post_tmp_datefmt == "8") {$datefmt = "n/j/Y"; $js_datefmt = "M/d/yyyy"; $tmp_datefmt = "m/d/yyyy"; $calendar_style = "amer";}
if ($post_tmp_datefmt == "9") {$datefmt = "n-j-Y"; $js_datefmt = "M-d-yyyy"; $tmp_datefmt = "m-d-yyyy"; $calendar_style = "amer";}
if ($post_tmp_datefmt == "10") {$datefmt = "n.j.y"; $js_datefmt = "M.d.yy"; $tmp_datefmt = "m.d.yy"; $calendar_style = "amer";}
if ($post_tmp_datefmt == "11") {$datefmt = "n/j/y"; $js_datefmt = "M/d/yy"; $tmp_datefmt = "m/d/yy"; $calendar_style = "amer";}
if ($post_tmp_datefmt == "12") {$datefmt = "n-j-y"; $js_datefmt = "M-d-yy"; $tmp_datefmt = "m-d-yy"; $calendar_style = "amer";}

if ($post_timefmt == "1") {$timefmt = "G:i";}
if ($post_timefmt == "2") {$timefmt = "H:i";}
if ($post_timefmt == "3") {$timefmt = "g:i A";}
if ($post_timefmt == "4") {$timefmt = "g:i a";}
if ($post_timefmt == "5") {$timefmt = "g:iA";}
if ($post_timefmt == "6") {$timefmt = "g:ia";}

if ($post_links == "none") {
  $post_links = "none";
} else {
  $y = count($post_links); $abc = "";
    for ($x=0;$x<$y;$x++) {
      if (!empty($post_links[$x])) {
        if ($x == count($post_links) - 1) {
          $abc = "$abc\"$post_links[$x]\"";
        } else { 
          $abc = "$abc\"$post_links[$x]\",";
        }
      }
    }
  $var = "array(";
  $post_links = "$var$abc);";
  if (strrchr($post_links,",")) {
    $a = strrchr($post_links,","); $post_links = str_replace("$a", ");", $post_links);
  } 
  if ($post_links == "array();") {
   $post_links = "\"none\";";
  }
}

if ($post_display_links == "none") {
  $post_display_links = "none";
} else {
  $y = count($post_display_links); $abc = "";
    for ($x=0;$x<$y;$x++) {
      if (!empty($post_display_links[$x])) {
        if ($x == count($post_display_links) - 1) {
          $abc = "$abc\"$post_display_links[$x]\"";
        } else { 
          $abc = "$abc\"$post_display_links[$x]\",";
        }
      }
    }
  $var = "array(";
  $post_display_links = "$var$abc);";
  if (strrchr($post_display_links,",")) {
    $a = strrchr($post_display_links,","); $post_display_links = str_replace("$a", ");", $post_display_links);
  } 
  if ($post_display_links == "array();") {
   $post_display_links = "\"none\";";
  }
}

if (empty($post_allowed_networks)) {
  $post_allowed_networks = "";
} else {
  $y = count($post_allowed_networks); $abc = "";
    for ($x=0;$x<$y;$x++) {
      if (!empty($post_allowed_networks[$x])) {
        if ($x == count($post_allowed_networks) - 1) {
          $abc = "$abc\"$post_allowed_networks[$x]\"";
        } else { 
          $abc = "$abc\"$post_allowed_networks[$x]\",";
        }
      }
    }
  $var = "array(";
  $post_allowed_networks = "$var$abc);";
  if (strrchr($post_allowed_networks,",")) {
    $a = strrchr($post_allowed_networks,","); $post_allowed_networks = str_replace("$a", ");", $post_allowed_networks);
  } 
}




// begin writing the new config.inc.php file //

$string = '<?php

/*
****************************************************************************
Be sure to set appropriate permissions on this file as it contains sensitive
username and password information!
****************************************************************************
*/


/* --- REQUIRED CHANGES --- */


/* mysql info --- $db_hostname is the hostname for your mysql server, default is localhost.
              --- $db_username is the mysql username you created during the install.
              --- $db_password is the mysql password for the username you created during
                  the install.
              --- $db_name is the mysql database you created during the install. */

$db_hostname = "'. $post_db_hostname .'";
$db_username = "'. $post_db_username .'";
$db_password = "'. $post_db_password .'";
$db_name = "'. $post_db_name .'";


/* --- RECOMMENDED CHANGES --- */


/* This adds a prefix to the tablenames in the database. This can be helpful if you
   have an existing mysql database that you would like to use with PHP Timeclock.
   If you are unaware of what is meant by "table prefix", then please leave this
   option as is. Default is to leave it blank. */

$db_prefix = "'. $post_db_prefix .'";


/* Choose "yes" to restrict the ip addresses that can connect to PHP Timeclock. If
   "yes" is chosen, you MUST input the allowed networks in the $allowed_networks
   array below. Otherwise, choosing "yes" here and leaving $allowed_networks
   blank will cause PHP Timeclock to reject everyone attempting to connect to it.
   Default is "no". */

$restrict_ips = "'. $post_restrict_ips .'";


/* Insert the networks or ip addresses you wish to allow to connect to PHP Timeclock
   into the $allowed_networks array below. There is not a limit on how many networks
   or addresses that can be included in this array. This will currently only work for
   ipv4 addresses, ipv6 may be supported in a future release. If $restrict_ips is
   set to "no", this option is ignored.

   * will work:
   * xxx.xxx.xxx.xxx        (exact)
   * xxx.xxx.xxx.[yyy-zzz]  (range)
   * xxx.xxx.xxx.xxx/nn     (CIDR)
   *
   * will NOT work:
   * xxx.xxx.xxx.xx[yyy-zzz]  (range, partial octets not supported)
   * xxx.xxx.xxx.yyy - xxx.xxx.xxx.zzz (range, entire networks not supported).
   * xxx.xxx. (range, less than 4 octets not supported).

   example --> $allowed_networks = array("10.0.0.4","192.168.1.[11-20]","192.168.4.0/24","192.0.0.0/8");
*/

$allowed_networks = '. $post_allowed_networks .'


/* Choose "yes" if you want to disable the Edit System Settings page within PHP 
   Timeclock. This page allows you to make *most* of your changes to the 
   config.inc.php file through the PHP Timeclock interface instead of editing 
   the config.inc.php file by hand. Many will view this as a possible security risk  
   and might would rather disable this functionality. Default is "no". */

$disable_sysedit = "'. $post_disable_sysedit .'";


/* Choose whether to use encrypted passwords along with the usernames. Options are
   "yes" or "no". If "yes" is chosen, users will be required to enter a password
   whenever they change their status. Default is "no". */

$use_passwd = "'. $post_use_passwd .'";


/* If you only want certain users to have the ability to view and run the reports, 
   change $use_reports_password to "yes". Default is "no"; */

$use_reports_password = "'. $post_use_reports_password .'";


/* Enable the option to log the ip addresses of the connecting computers when users
   punch-in/out, or when a time is manually added, edited, or deleted. Default is
   "yes". */

$ip_logging = "'. $post_ip_logging .'";


/* An email address to display in the footer (footer.php). Set it to "none" to ignore
   this option. */

$email = "'. $post_email .'";


/* --- OPTIONAL CHANGES --- */


/* Choose the way dates are displayed. DO NOT EDIT THESE DATE VARIABLES MANUALLY UNLESS YOU 
   KNOW WHAT YOU ARE DOING. Instead, change these date variables via the Edit System Settings
   page in the Administration section of PHP Timeclock (sysedit.php). $datefmt default is 
   "n/j/y", $js_datefmt default is "M/d/yy", $tmp_datefmt default is "m/d/yy", and 
   $calendar_style default is "amer". You will need to choose date formats with matching 
   numbers, ie: if format number 10 is used for $datefmt, then format number 10 will need to 
   be used for $js_format and $tmp_format as well. "euro" will need to be chosen for date 
   format numbers 1-6, and "amer" will need to be chosen for date format numbers 7-12. 
   Again, if you are confused, i urge you to change these settings via the Edit System 
   Settings page in the Administration Section. Choosing mismatched options will lead to 
   much confusion and plenty of headaches later.

   Possibilities for these variables are:

   $calendar_style --> 1) amer
                       2) euro

   $datefmt --> 1) j.n.Y       $js_datefmt --> 1) d.M.yyyy       $tmp_datefmt --> 1) d.m.yyyy
                2) j/n/Y                       2) d/M/yyyy                        2) d/m/yyyy
                3) j-n-Y                       3) d-M-yyyy                        3) d-m-yyyy
                4) j.n.y                       4) d.M.yy                          4) d.m.yy
                5) j/n/y                       5) d/M/yy                          5) d/m/yy
                6) j-n-y                       6) d-M-yy                          6) d-m-yy
                7) n.j.Y                       7) M.d.yyyy                        7) m.d.yyyy
                8) n/j/Y                       8) M/d/yyyy                        8) m/d/yyyy
                9) n-j-Y                       9) M-d-yyyy                        9) m-d-yyyy
               10) n.j.y                      10) M.d.yy                         10) m.d.yy
               11) n/j/y                      11) M/d/yy                         11) m/d/yy
               12) n-j-y                      12) M-d-yy                         12) m-d-yy */

$datefmt = "'. $datefmt .'";
$js_datefmt = "'. $js_datefmt .'";
$tmp_datefmt = "'. $tmp_datefmt .'";
$calendar_style = "'. $calendar_style .'";


/* Choose the way times are displayed. Default is "g:i a".

   Possibilities for this variable are:

   $timefmt --> 1) G:i
                2) H:i
                3) g:i A
                4) g:i a
                5) g:iA
                6) g:ia    */

$timefmt = "'. $timefmt .'";


/* Display only activity for the the current day instead of the last entry from each user.
   Default is "no". */

$display_current_users = "'. $post_display_current_users .'";


/* Show a Display Name instead of a Username for each user on the main page.
   Default is "no". */

$show_display_name = "'. $post_show_display_name .'";


/* Display punch-in/out times for only a certain office on the main page of the application.
   Replace "all" with the office you wish to display below. Default is "all". */

$display_office = "'. $post_office_name .'";


/* Display punch-in/out times for only a certain group on the main page of the application.
   Replace "all" with the group you wish to display below. Default is "all". */

$display_group = "'. $post_group_name .'";


/* Display a column on the main page that shows the office each person is affiliated with. 
   Default is "no". */

$display_office_name = "'. $post_display_office_name .'";


/* Display a column on the main page that shows the group each person is affiliated with. 
   Default is "no". */

$display_group_name = "'. $post_display_group_name .'";


/* A logo or graphic, this is displayed in the top left of each page.
   Set it to "none" to ignore this option. */

$logo = "'. $post_logo .'";


/* This sets the refresh rate (in seconds) for index.php. If the application is kept open,
   it will refresh every $refresh seconds to display the most current info. Default
   is 300. Set it to "none" to ignore this option. */

$refresh = "'. $post_refresh .'";


/* This creates a clickable date in the top right of each page. By Default, it links to 
   "This Day in History" on the historychannel.com website. Set it to "none" to ignore this option. */

$date_link = "'. $post_date_link .'";


/* These are alternating row colors for the main page and for reports. */

$color1 = "'. $post_color1 .'";
$color2 = "'. $post_color2 .'";


/* Insert/change/delete below the ACTUAL links to websites you wish to display in the
   topleft side of each page (leftmain.php). These links can link to anything you want
   them to -- websites, other web-based applications, etc. Default number of links is 6.
   Set $links to "none" to ignore this option. Ex: $links = "none"; */

$links = '. $post_links .'


/* Insert/change/delete below the display names for the links you inserted above. 
   If $links is set to "none", this option is ignored. */

$display_links = '. $post_display_links .'


/* --- REPORTING INFO --- */


/* The settings in this section are simply default settings. They can easily be changed each
   time you run a report. */

/* Choose whether to paginate the Hours Worked report or not. Setting this option to "yes"
   will print the totals for each user on their own page. Default is "yes". */

$paginate = "'. $post_paginate .'";


/* Choose whether to show the punch-in/out details for each punch for each user on the 
   Hours Worked report or not. Default is "yes". */

$show_details = "'. $post_show_details .'";


/* Choose how to round the time worked within the Hours Worked report for each user. This
   simply tells the report how to format the total hours worked for the Hours Worked Report.
   Default is "0".

   Possibilities for this variable are:

   $round_time --> 0) Do not round.
                   1) Round to the nearest 5 minutes.
                   2) Round to the nearest 10 minutes.
                   3) Round to the nearest 15 minutes.
                   4) Round to the nearest 20 minutes.
                   5) Round to the nearest 30 minutes.                                     */

$round_time = "'. $post_round_time .'";


/* The two variables below, $report_start_time and $report_end_time, are designed to work with
   the Hours Worked report. They are there to give you a starting time to go along with the
   starting date, and an ending time to go along with the ending date for the dates specified
   when the report is run. Default is 00:00 (12:00am) for $report_start_time and
   23:59 (11:59pm) for $report_end_time. 12 hour and 24 hour formats are supported. */

$report_start_time = "'. $post_report_start_time .'";
$report_end_time = "'. $post_report_end_time .'";


/* Setting this variable to "yes" will display a single dropdown box containing usernames 
   to choose from when running the reports. Setting this variable to "no" will instead 
   display a triple dropdown box containing offices, groups, and usernames to choose from 
   when running the reports. A single dropdown box works well if there are just a few 
   usernames in the system, and a triple dropdown works well if multiple offices and/or 
   groups are in the system. Default is "no". */

$username_dropdown_only = "'. $post_username_dropdown_only .'";


/* Choose whether to print displaynames or usernames for each user when reports are run.
   Options for this variable are "user" and "display". Default is "user". */

$user_or_display = "'. $post_user_or_display .'";


/* Choose whether to include in the reports the ip addresses of the systems that connect to 
   sign-in/out into PHP Timeclock or not. This option is useful for auditing purposes. The 
   ip_logging option must be set to "yes" in order for this option to work as expected.
   Default is "yes". */

$display_ip = "'. $post_display_ip .'";


/* Reports can be exported to a comma delimited file (.csv). Setting this to "yes" will
   export the reports to .csv files. Default is "no" */

$export_csv = "'. $post_export_csv .'";


/* --- TIMEZONE INFO --- */


/* If you have users who are in different timezones, you may wish to display the punch-in/out
   times according to the timezone they are currently in. Setting this option to "yes" will
   display the punch-in/out times in the timezone of their connecting systems. The timezone
   info is pulled from the web browser of the user via javascript and stored in a cookie on their
   system. The default setting is "no". */

$use_client_tz = "'. $post_use_client_tz .'";


/* To display the punch-in/out times in the timezone of the web server, leave this option set
   to "yes". Setting this option to "no" AND setting the above $use_client_tz option to "no",
   will display the punch-in/out times in GMT. Default is "yes". */

$use_server_tz = "'. $post_use_server_tz .'";


/* --- WEATHER INFO ---  */


/* Include local weather info on the left side of the main page just below the Submit button.
   If you would like to include this feature, set $display_weather to "yes". Default is "no". */

$display_weather = "'. $post_display_weather .'";


/* ICAO (International Civil Aviation Organization) for your local airport. This is the
   unique four letter international ID for the airport. METAR reports are created at
   roughly 4500 airports from around the world, so you probably live near one of them.
   The airports make a report once or twice an hour, and these reports are stored at the
   National Weather Service and are publically available via HTTP or FTP. Visit
   https://pilotweb.nas.faa.gov/qryhtml/icao/ to find a corresponding ICAO near you. If
   $display_weather is set to "no", this option is ignored. If $display_weather is set to
   "yes", you MUST provide an ICAO here. */

$metar = "'. $post_metar .'";


/* This is the city and country (or can be city and state) of the airport for
   the ICAO used above. The max length for this field is 100 characters.
   If $display_weather is set to "no", this option is ignored. */

$city = "'. $post_city .'";


/* --- APP NAME, VERSION NUMBER, ETC. --- */


$app_name = "'. $post_app_name .'";
$app_version = "'. $post_app_version .'";

/* Sets the title in the header. This is what the page will be named by default when you
   make a "favorite" or "bookmark" in your browser. Change as you see fit. */

$title = "$app_name $app_version";


/* --- DO NOT CHANGE ANYTHING BELOW THIS LINE!!! --- */


$dbversion = "'. $post_dbversion .'";
?>';

$fp = fopen("$filename", "w") or die("can't open: $php_errormsg");
fwrite($fp, $string) or die("can't write: $php_errormsg");
fclose($fp) or die("can't close: $php_errormsg");

// end writing the new config.inc.php file //

include '../config.inc.php';

echo "            <table align=center class=table_border width=100% border=0 cellpadding=0 cellspacing=3>\n";
echo "              <tr><td width=20 align=center height=25 class=table_rows><img src='../images/icons/accept.png' /></td>
                  <td class=table_rows_green height=25>&nbsp;System Settings updated successfully.</td></tr>\n";
echo "            </table>\n";
echo "            <br />\n";

include '../templates/admin_index_tpl.php';
include '../footer.php'; exit;
}
}
?>
