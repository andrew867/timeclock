<?php
session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Upgrade Database</title>\n";

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

$count = "0";
$tmp_count = "0";
$emp_tstamp_count = "0";
$info_timestamp_count = "0";
$passed_or_not = "0";
$gmt_offset = date('Z');

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
echo "        <tr><td class=left_rows height=18 align=left valign=middle><img src='../images/icons/application_edit.png'
                alt='Edit System Settings' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='sysedit.php'>Edit System Settings</a></td></tr>\n";
echo "        <tr><td class=current_left_rows height=18 align=left valign=middle><img src='../images/icons/database_go.png'
                alt='Upgrade Database' />&nbsp;&nbsp;&nbsp;<a class=admin_headings href='dbupgrade.php'>Upgrade Database</a></td></tr>\n";
echo "      </table></td>\n";
echo "    <td align=left class=right_main scope=col>\n";
echo "      <table width=100% height=100% border=0 cellpadding=10 cellspacing=1>\n";
echo "        <tr class=right_main_text>\n";
echo "          <td valign=top>\n";
echo "            <br />\n";

// determine the privileges of the PHP Timeclock user //

$result = mysql_query("show grants for current_user()");
while ($row = mysql_fetch_array($result)) {
  $abc = stripslashes("".$row["0"]."");
  if (((preg_match("/\bgrant\b/i", $abc)) && (preg_match("/\bselect\b/i", $abc)) && 
     (preg_match("/\binsert\b/i", $abc)) && (preg_match("/\bupdate\b/i", $abc)) && 
     (preg_match("/\bdelete\b/i", $abc)) && (preg_match("/\bcreate\b/i", $abc)) && 
     (preg_match("/\balter\b/i", $abc)) && (preg_match("/\bon `$db_name`\.\* to '$db_username'@'$db_hostname|%\b/i", $abc))) ||
     (preg_match("/\bgrant all privileges on `$db_name`\.\* to '$db_username'@'$db_hostname|%' \b/i", $abc)) ||
     (preg_match("/\bgrant all privileges on \*\.\* to '$db_username'@'$db_hostname|%' \b/i", $abc))) { 
  $count++;}}
if (!empty($count)) { 

if ($request == 'GET') {

$query_admin = "select empfullname from ".$db_prefix."employees where empfullname = 'admin'";
$result_admin = mysql_query($query_admin);

while ($row = mysql_fetch_array($result_admin)) {
    $user_admin = "".$row["empfullname"]."";
}

echo "            <form name='form' action='$self' method='post'>\n";
echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/database_go.png' />&nbsp;&nbsp;&nbsp;Upgrade 
                      Database </th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td colspan=2 class=table_rows align=left valign=bottom style='padding-left:32px;padding-right:32px;'>If you are greeted with a
                      message in red stating \"Your database is out of date\", upgrade it by clicking on the \"Next\" button below. If 
                      you do not see this message, then your database is currently up to date and nothing further needs to be done.</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td colspan=2 class=table_rows align=left valign=bottom style='padding-left:32px;padding-right:32px;'>In the process of  
                      upgrading the database, all necessary modifications and changes of the db will be completed, including any alterations, 
                      conversions, or additions that are needed for this release of PHP Timeclock to function properly.</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td colspan=2 class=table_rows align=left valign=bottom style='padding-left:32px;padding-right:32px;'>Please click on the 
                      \"Next\" button below and follow the instructions, if any are given.</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table>\n";

if (!isset($user_admin)) {
    echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";
    echo "              <tr><td class=table_rows width=10><input type='checkbox' name='recreate_admin' value='1'></td>
                  <td class=table_rows height=53>Re-create the admin user?</td></tr></table>\n";
}

echo "            <table align=center width=60% border=0 cellpadding=0 cellspacing=3>\n";

if (isset($user_admin)) {
    echo "              <tr><td height=40>&nbsp;</td></tr>\n";
}

echo "              <tr><td width=30><input type='image' name='submit' value='Upgrade DB' align='middle'
                      src='../images/buttons/next_button.png'></td><td><a href='index.php'><img src='../images/buttons/cancel_button.png'
                      border='0'></td></tr></table></form></td></tr>\n"; include '../footer.php'; exit;

} else {

@$recreate_admin = $_POST['recreate_admin'];

if (isset($recreate_admin)) {
    if (($recreate_admin != '1') && (!empty($recreate_admin))) {
        echo "Something is fishy here."; exit;
    }
}

echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left style='padding-left:25px;'>Upgrading Database......</th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";


// track the database changes that have been made since version 0.9 //

// employees table additions //

$field = "employee_passwd";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field VARCHAR(25) NOT NULL;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "displayname";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field VARCHAR(50) NOT NULL;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "email";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field VARCHAR(75) NOT NULL;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "groups";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field VARCHAR(50) NOT NULL;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "office";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field VARCHAR(50) NOT NULL;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "admin";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field TINYINT(1) NOT NULL default '0';");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "reports";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field TINYINT(1) NOT NULL default '0';");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "time_admin";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field TINYINT(1) NOT NULL default '0';");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

$field = "disabled";
$result = mysql_query("SHOW fields from ".$db_prefix."employees LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."employees ADD $field TINYINT(1) NOT NULL default '0';");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

// employees table changes //

$result = mysql_query("SHOW FIELDS FROM ".$db_prefix."employees");
while ($row = mysql_fetch_array($result)) {
  $name = "".$row["Field"]."";
  $type = "".$row["Type"]."";
  $tmp_type = strtoupper($type);

  if (($name == 'empfullname') && ($type != 'varchar(50)')) {
    $alter_result = mysql_query("ALTER TABLE ".$db_prefix."employees CHANGE empfullname empfullname VARCHAR(50) NOT NULL");
    echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                      align=left>:&nbsp;<b>$name</b> field in <u>employees</u> table has been changed from type $tmp_type to type VARCHAR(50).</td></tr>\n";
    $passed_or_not = "1";
  }
  if (($name == 'tstamp') && ($type != 'bigint(14)')) {
    $alter_result = mysql_query("ALTER TABLE ".$db_prefix."employees CHANGE tstamp tstamp BIGINT(14) DEFAULT NULL");
    echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                      align=left>:&nbsp;<b>$name</b> field in <u>employees</u> table has been changed from type $tmp_type to type BIGINT(14).</td></tr>\n";
    $emp_tstamp_count++;
    $passed_or_not = "1";
  }
}
mysql_free_result($result);

// info table additions //

$field = "ipaddress";
$result = mysql_query("SHOW fields from ".$db_prefix."info LIKE '".$field."'");
@$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."info ADD $field VARCHAR(39) NOT NULL;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>employees</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

// info table changes //

$result = mysql_query("SHOW FIELDS FROM ".$db_prefix."info");
while ($row = mysql_fetch_array($result)) {
  $name = "".$row["Field"]."";
  $type = "".$row["Type"]."";
  $tmp_type = strtoupper($type);

  if (($name == 'inout') && ($type != 'varchar(50)')) {
    $alter_result = mysql_query("ALTER TABLE ".$db_prefix."info CHANGE `inout` `inout` VARCHAR(50) NOT NULL");
    echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                      align=left>:&nbsp;<b>$name</b> field in <u>info</u> table has been changed from type $tmp_type to type VARCHAR(50).</td></tr>\n";
    $passed_or_not = "1";
  }
  if (($name == 'timestamp') && ($type != 'bigint(14)')) {
    $alter_result = mysql_query("ALTER TABLE ".$db_prefix."info CHANGE timestamp timestamp BIGINT(14) DEFAULT NULL");
    echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                      align=left>:&nbsp;<b>$name</b> field in <u>info</u> table has been changed from type $tmp_type to type BIGINT(14).</td></tr>\n";
    $info_timestamp_count++;
    $passed_or_not = "1";
  }
}
mysql_free_result($result);

// punchlist table additions //

$field = "in_or_out";
$result = mysql_query("SHOW fields from ".$db_prefix."punchlist LIKE '".$field."'");
$rows = mysql_num_rows($result);

if (empty($rows)) {
$passwd_query = mysql_query("ALTER TABLE ".$db_prefix."punchlist ADD $field TINYINT(1) NOT NULL default '0';");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$field</b> field has been added to the <u>punchlist</u> table.</td></tr>\n";
$passed_or_not = "1";
} 

// punchlist table changes //

$result = mysql_query("SHOW FIELDS FROM ".$db_prefix."punchlist");
while ($row = mysql_fetch_array($result)) {
  $name = "".$row["Field"]."";
  $type = "".$row["Type"]."";
  $tmp_type = strtoupper($type);

  if (($name == 'punchitems') && ($type != 'varchar(50)')) {
    $alter_result = mysql_query("ALTER TABLE ".$db_prefix."punchlist CHANGE punchitems punchitems VARCHAR(50) NOT NULL");
    echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                      align=left>:&nbsp;<b>$name</b> field in <u>punchlist</u> table has been changed from type $tmp_type to type VARCHAR(50).</td></tr>\n";
    $passed_or_not = "1";
  }
}
mysql_free_result($result);

// add metars table //

$table = "metars";
$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
$rows = mysql_num_rows($result);

if (empty($rows)) {
$metars_query = mysql_query("CREATE TABLE ".$db_prefix."metars (metar varchar(255) NOT NULL default '',
                             timestamp timestamp(14) NOT NULL, station varchar(4) NOT NULL default '',
                             PRIMARY KEY  (station), UNIQUE KEY station (station)) TYPE=MyISAM;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$table</b> table has been added to the <u>$db_name</u> database.</td></tr>\n";
$passed_or_not = "1";
} 

// add dbversion table //

$table = "dbversion";
$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
$rows = mysql_num_rows($result);

if (empty($rows)) {
$dbversion_query = mysql_query("CREATE TABLE ".$db_prefix."dbversion (dbversion decimal(5,1) NOT NULL default '0.0',
                             PRIMARY KEY  (dbversion)) TYPE=MyISAM;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$table</b> table has been added to the <u>$db_name</u> database.</td></tr>\n";
$passed_or_not = "1";
}

// dbversion table changes //

$table = "dbversion";
$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
$rows = mysql_num_rows($result);

if (!empty($rows)) {
  $dbversion_result = mysql_query("select * from ".$db_prefix."dbversion");
  while ($row = mysql_fetch_array($dbversion_result)) {
    $tmp_dbversion = "".$row["dbversion"]."";
  }
  if (!isset($tmp_dbversion)) {
    $compare_result = mysql_query("INSERT INTO ".$db_prefix."dbversion (dbversion) VALUES ('".$dbversion."');");
    echo "                  <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                          align=left>:&nbsp;the version of the database is $dbversion.</td></tr>\n";
    $passed_or_not = "1";
  } elseif (@$tmp_dbversion != $dbversion) {
      $update_query = "update dbversion set ".$db_prefix."dbversion = '".$dbversion."'";
      $update_result = mysql_query($update_query);
    echo "                  <tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows 
                          align=left>:&nbsp;the version of the database has been changed from <b>$tmp_dbversion</b> to <b>$dbversion</b>.</td></tr>\n";
    $passed_or_not = "1";
  } 
}

// add offices table //

$table = "offices";
$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
$rows = mysql_num_rows($result);

if (empty($rows)) {
$metars_query = mysql_query("CREATE TABLE ".$db_prefix."offices (officename varchar(50) NOT NULL default '',
                             officeid int(10) NOT NULL auto_increment,
                             PRIMARY KEY  (officeid), UNIQUE KEY officeid (officeid)) TYPE=MyISAM;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$table</b> table has been added to the <u>$db_name</u> database.</td></tr>\n";
$passed_or_not = "1";
} 

// add groups table //

$table = "groups";
$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
$rows = mysql_num_rows($result);

if (empty($rows)) {
$metars_query = mysql_query("CREATE TABLE ".$db_prefix."groups (groupname varchar(50) NOT NULL default '',
                             groupid int(10) NOT NULL auto_increment,
                             officeid int(10) NOT NULL default '0',
                             PRIMARY KEY  (groupid), UNIQUE KEY groupid (groupid)) TYPE=MyISAM;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$table</b> table has been added to the <u>$db_name</u> database.</td></tr>\n";
$passed_or_not = "1";
} 

// add audit table //

$table = "audit";
$result = mysql_query("SHOW TABLES LIKE '".$db_prefix.$table."'");
$rows = mysql_num_rows($result);

if (empty($rows)) {
$audit_query = mysql_query("CREATE TABLE ".$db_prefix."audit (modified_by_ip varchar(39) NOT NULL default '', 
                             modified_by_user varchar(50) NOT NULL default '',
                             modified_when bigint(14) NOT NULL, modified_from bigint(14) NOT NULL, 
                             modified_to bigint(14) NOT NULL, modified_why varchar(250) NOT NULL default '',
                             user_modified varchar(50) NOT NULL,
                             PRIMARY KEY  (modified_when), UNIQUE KEY modified_when (modified_when)) TYPE=MyISAM;");
echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                      align=left>:&nbsp;<b>$table</b> table has been added to the <u>$db_name</u> database.</td></tr>\n";
$passed_or_not = "1";
} 

if (isset($recreate_admin)) {

    if ($recreate_admin == '1') {

        // add admin user //

        $admin = "admin";

        $query_admin = "select empfullname from ".$db_prefix."employees where empfullname = '".$admin."'";
        $result_admin = mysql_query($query_admin);

        while ($row_admin = mysql_fetch_array($result_admin)) {
            $admin_user = stripslashes("".$row_admin['empfullname']."");
        }

        if (!isset($admin_user)) {
            $add_admin_query = mysql_query("INSERT INTO ".$db_prefix."employees 
                                            VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');");

            echo "              <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows 
                                  align=left>:&nbsp;<b>$admin</b> user has been added to the <u>$db_name</u> database.</td></tr>\n";
            $passed_or_not = "1";
        }
    }
}
 
// convert mysql timestamps to unix timestamps //

if (!empty($emp_tstamp_count)) {
$emp_tstamp_result = mysql_query("update ".$db_prefix."employees set tstamp = (unix_timestamp(tstamp) - '".$gmt_offset."')");
$employee_rows= mysql_affected_rows();

  if (!empty($employee_rows)) {
  echo "                <tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Converted</td><td class=table_rows 
                   align=left>:&nbsp;<b>$employee_rows rows</b> in the employees table were converted from a mysql timestamp to a unix 
                   timestamp.</td></tr>\n";
  }
}
unset($emp_tstamp_count);

if (!empty($info_timestamp_count)) {
$info_timestamp_result = mysql_query("update ".$db_prefix."info set timestamp = (unix_timestamp(timestamp) - '".$gmt_offset."')");
$info_rows= mysql_affected_rows();

  if (!empty($info_rows)) {
  echo "                <tr><td width=10 class=table_rows style='padding-left:25px;color:purple;font-weight:bold;'>Converted</td><td class=table_rows 
                   align=left>:<b>$info_rows rows</b> in the info table were converted from a mysql timestamp to a unix timestamp.</b></td></tr>\n";
  }
}
unset($info_timestamp_count);

if (empty($passed_or_not)) {
echo "              <tr><td class=table_rows style='padding-left:25px;' height=40 valign=bottom colspan=2><b>No changes were made to the 
                      database.</b></td></tr>\n";
} else {
echo "              <tr><td class=table_rows style='padding-left:25px;' height=40 valign=bottom colspan=2><b>Your database is now up to date.</b>
                      </td></tr>\n";
}
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
include '../footer.php'; exit;
}
} else {

echo "            <table align=center class=table_border width=60% border=0 cellpadding=3 cellspacing=0>\n";
echo "              <tr><th class=rightside_heading nowrap halign=left colspan=3><img src='../images/icons/database_go.png' />&nbsp;&nbsp;&nbsp;Upgrade 
                      Database </th></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td colspan=2 class=table_rows align=left valign=bottom style='padding-left:32px;padding-right:32px;'>Your mysql 
                      user, $db_username@$db_hostname, does not have the required SELECT, INSERT, UPDATE, DELETE, CREATE, and ALTER 
                      privileges for the $db_name database.</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "              <tr><td colspan=2 class=table_rows align=left valign=bottom style='padding-left:32px;padding-right:32px;'>Return to this page after 
                      $db_username@$db_hostname has been granted these privileges on the $db_name database.</td></tr>\n";
echo "              <tr><td height=15></td></tr>\n";
echo "            </table></td></tr>\n";
include '../footer.php'; 
exit;
}
?>
