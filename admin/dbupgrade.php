<?php
session_start();

include '../config.inc.php';
include 'header.php';
include 'topmain.php';
echo "<title>$title - Upgrade Database</title>\n";

function msg_changed($msg) {
    echo "<tr><td width=10 class=table_rows style='padding-left:25px;color:#0000FF;font-weight:bold;'>Changed</td><td class=table_rows align=left>:&nbsp;$msg</td></tr>\n";
}

function msg_added($msg) {
    echo "<tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Added</td><td class=table_rows align=left>:&nbsp;$msg</td></tr>\n";
}

function msg_converted($msg) {
    echo "<tr><td width=10 class=table_rows style='padding-left:25px;color:#FF9900;font-weight:bold;'>Converted</td><td class=table_rows align=left>:&nbsp;$msg</td></tr>\n";
}

// Ensure that the corresponding table exists, creates it if missing.
// Note: need not create all columns since we will add any missing columns
// with ensure_field.
function ensure_table($table, $columns, $engine = "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin") {
    global $db_name;
    global $db_prefix;
    $rows = mysqli_num_rows(tc_query("SHOW TABLES LIKE '$db_prefix$table'"));

    if (empty($rows)) {
        tc_query("CREATE TABLE $db_prefix$table ($columns) $engine");
        msg_added("<b>$table</b> table has been added to the <u>$db_name</u> database.");
        return 1;
    }
    return 0;
}

// Ensure field is present and has correct type. Does not check other
// attributes (NULL, default, ...)
function ensure_field($table, $field, $type, $extra) {
    global $db_prefix;
    $result = tc_query("SHOW FIELDS FROM $db_prefix$table LIKE '$field'");

    while ($row = mysqli_fetch_array($result)) {
        $current_type = "" . $row['Type'] . "";
        if (strtolower($type) !== strtolower($current_type)) {
            tc_query("ALTER TABLE $db_prefix$table CHANGE `$field` `$field` $type $extra");
            msg_changed("<b>$field</b> field in <u>$table</u> table has been changed from type $current_type to type $type.");
            return 1;
        }
    }

    if (empty($current_type)) {
        tc_query("ALTER TABLE $db_prefix$table ADD `$field` $type $extra;");
        msg_added("<b>$field</b> field has been added to the <u>$table</u> table.");
        return 1;
    }

    return 0;
}

// Ensure a simple non-primary/non-unique index is present on the named
// field. If a primary/unique index exists, we won't create another.
function ensure_index($table, $field) {
    global $db_prefix;
    $rows = mysqli_num_rows(tc_query("SHOW INDEX FROM $db_prefix$table WHERE column_name = ?", $field));

    if (empty($rows)) {
        tc_query("CREATE INDEX {$db_prefix}{$table}_{$field} ON {$db_prefix}{$table} (`{$field}`)");
        msg_added("INDEX has been added to the <u>{$table}.{$field}</u> column.");
        return 1;
    }
    return 0;
}


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
    echo "      </table><br /></td></tr></table>\n";
    exit;
}

$changes_made = 0;
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

$count = "0";
$result = tc_query("show grants for current_user()");
while ($row = mysqli_fetch_array($result)) {
    $abc = stripslashes("" . $row["0"] . "");
    if (((preg_match("/\bgrant\b/i", $abc)) && (preg_match("/\bselect\b/i", $abc)) &&
         (preg_match("/\binsert\b/i", $abc)) && (preg_match("/\bupdate\b/i", $abc)) &&
         (preg_match("/\bdelete\b/i", $abc)) && (preg_match("/\bcreate\b/i", $abc)) &&
         (preg_match("/\balter\b/i", $abc)) && (preg_match("/\bon `\Q$db_name`.*\E to '\Q$db_username\E'@/i", $abc))) ||
        (preg_match("/\bgrant all privileges on \Q`$db_name`.*\E to '\Q$db_username\E'@'/i", $abc)) ||
        (preg_match("/\bgrant all privileges on \*\.\* to '\Q$db_username\E'@/i", $abc))
    ) {
        $count++;
    }
}

if (!empty($count)) {

    if ($request == 'GET') {

        $user_admin = tc_select_value("empfullname", "employees", "empfullname = 'admin'");

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
                      border='0'></td></tr></table></form></td></tr>\n";
        include '../footer.php';
        exit;

    } else {

        @$recreate_admin = $_POST['recreate_admin'];

        if (isset($recreate_admin)) {
            if (($recreate_admin != '1') && (!empty($recreate_admin))) {
                echo "Something is fishy here.";
                exit;
            }
        }

        echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
        echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left style='padding-left:25px;'>Upgrading Database......</th></tr>\n";
        echo "              <tr><td height=15></td></tr>\n";


        // TABLE: audit //
        $changes_made += ensure_table("audit", "modified_when bigint(14)");

        $changes_made += ensure_field("audit", "modified_when",    "bigint(14)",   "");
        $changes_made += ensure_field("audit", "modified_from",    "bigint(14)",   "NOT NULL");
        $changes_made += ensure_field("audit", "modified_to",      "bigint(14)",   "NOT NULL");
        $changes_made += ensure_field("audit", "modified_by_ip",   "varchar(39)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("audit", "modified_by_user", "varchar(50)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("audit", "modified_why",     "varchar(250)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("audit", "user_modified",    "varchar(50)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");

        $changes_made += ensure_index("audit", "modified_when");

        // TABLE: employees //
        $changes_made += ensure_table("employees", "empfullname varchar(50) PRIMARY KEY COLLATE utf8_bin");

        $result = tc_query("SHOW FIELDS FROM {$db_prefix}employees");
        while ($row = mysqli_fetch_array($result)) {
            $name = "" . $row["Field"] . "";
            $type = strtolower("" . $row["Type"] . "");

            // This one needs some data conversion:
            if (($name == 'tstamp') && ($type != 'bigint(14)')) {
                tc_query("ALTER TABLE {$db_prefix}employees CHANGE tstamp tstamp BIGINT(14) DEFAULT NULL");
                msg_changed("<b>$name</b> field in <u>employees</u> table has been changed from type $type to type BIGINT(14).");
                $changes_made += 1;

                tc_query("UPDATE {$db_prefix}employees SET tstamp = (unix_timestamp(tstamp) - '$gmt_offset')");
                $num_rows = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
                if (!empty($num_rows)) {
                    msg_converted("<b>$num_rows rows</b> in the employees table were converted from a mysql timestamp to a unix timestamp.");
                }
            }
        }

        $changes_made += ensure_field("employees", "empfullname",      "varchar(50)", "PRIMARY KEY COLLATE utf8_bin");
        $changes_made += ensure_field("employees", "tstamp",           "bigint(14)",  "DEFAULT NULL");
        $changes_made += ensure_field("employees", "employee_passwd",  "varchar(25)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("employees", "displayname",      "varchar(50)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("employees", "email",            "varchar(75)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("employees", "barcode",          "varchar(75)", "COLLATE utf8_bin UNIQUE");
        $changes_made += ensure_field("employees", "groups",           "varchar(50)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("employees", "office",           "varchar(50)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("employees", "admin",            "tinyint(1)",  "NOT NULL DEFAULT '0'");
        $changes_made += ensure_field("employees", "reports",          "tinyint(1)",  "NOT NULL DEFAULT '0'");
        $changes_made += ensure_field("employees", "time_admin",       "tinyint(1)",  "NOT NULL DEFAULT '0'");
        $changes_made += ensure_field("employees", "disabled",         "tinyint(1)",  "NOT NULL DEFAULT '0'");


        // TABLE: groups //
        $changes_made += ensure_table("groups", "groupid int(10) AUTO_INCREMENT PRIMARY KEY");

        $changes_made += ensure_field("groups", "groupid",   "int(10)",     "AUTO_INCREMENT PRIMARY KEY");
        $changes_made += ensure_field("groups", "groupname", "varchar(50)", "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("groups", "officeid",  "int(10)",     "NOT NULL DEFAULT '0'");


        // TABLE: info //
        $changes_made += ensure_table("info", "fullname varchar(50) COLLATE utf8_bin NOT NULL DEFAULT ''");

        $result = tc_query("SHOW FIELDS FROM {$db_prefix}info");
        while ($row = mysqli_fetch_array($result)) {
            $name = "" . $row["Field"] . "";
            $type = strtolower("" . $row["Type"] . "");

            // This one needs some data conversion:
            if (($name == 'timestamp') && ($type != 'bigint(14)')) {
                tc_query("ALTER TABLE {$db_prefix}info CHANGE timestamp timestamp BIGINT(14) DEFAULT NULL");
                msg_changed("<b>$name</b> field in <u>info</u> table has been changed from type $type to type BIGINT(14).");
                $changes_made += 1;

                tc_query("UPDATE {$db_prefix}info SET timestamp = (unix_timestamp(tstamp) - '$gmt_offset')");
                $num_rows = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
                if (!empty($num_rows)) {
                    msg_converted("<b>$num_rows rows</b> in the info table were converted from a mysql timestamp to a unix timestamp.");
                }
            }
        }

        $changes_made += ensure_field("info", "fullname",  "varchar(50)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("info", "inout",     "varchar(50)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("info", "timestamp", "bigint(14)",   "DEFAULT NULL");
        $changes_made += ensure_field("info", "notes",     "varchar(250)", "COLLATE utf8_bin DEFAULT NULL");
        $changes_made += ensure_field("info", "ipaddress", "varchar(39)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");

        $changes_made += ensure_index("info", "fullname");
        $changes_made += ensure_index("info", "timestamp");


        // TABLE: metars //
        $changes_made += ensure_table("metars", "station varchar(4) PRIMARY KEY COLLATE utf8_bin");

        $changes_made += ensure_field("metars", "station",   "varchar(4)",    "PRIMARY KEY COLLATE utf8_bin");
        $changes_made += ensure_field("metars", "metar",     "varchar(255)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("metars", "timestamp", "timestamp",     "NOT NULL");


        // TABLE: offices //
        $changes_made += ensure_table("offices", "officeid int(10) AUTO_INCREMENT PRIMARY KEY");

        $changes_made += ensure_field("offices", "officeid",   "int(10)",     "AUTO_INCREMENT PRIMARY KEY");
        $changes_made += ensure_field("offices", "officename", "varchar(50)", "COLLATE utf8_bin NOT NULL DEFAULT ''");


        // TABLE: punchlist //
        $changes_made += ensure_table("punchlist", "punchitems varchar(50) PRIMARY KEY COLLATE utf8_bin");

        $changes_made += ensure_field("punchlist", "punchitems", "varchar(50)", "PRIMARY KEY COLLATE utf8_bin");
        $changes_made += ensure_field("punchlist", "punchnext",  "varchar(50)", "varchar(50) COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("punchlist", "color",      "varchar(7)",  "COLLATE utf8_bin NOT NULL DEFAULT ''");
        $changes_made += ensure_field("punchlist", "in_or_out",  "tinyint(1)",  "DEFAULT NULL");


        // TABLE: dbversion //
        $changes_made += ensure_table("dbversion", "dbversion decimal(5,1) NOT NULL DEFAULT '0.0'");

        $changes_made += ensure_field("dbversion", "dbversion", "decimal(5,1)", "NOT NULL DEFAULT '0.0'");

        $current_dbversion = tc_select_value("dbversion", "dbversion");
        if (empty($current_dbversion)) {
            tc_insert_strings("dbversion", array("dbversion" => $dbversion));
            $changes_made += 1;
            msg_changed("the database is now at version $dbversion.");
        }
        elseif ($current_dbversion != $dbversion) {
            tc_update_strings("dbversion", array("dbversion" => $dbversion));
            msg_changed("the database has been upgraded from version <b>$current_dbversion</b> to version <b>$dbversion</b>.");
            $changes_made += 1;
        }

        // Recreate admin //
        if (isset($recreate_admin) and $recreate_admin == '1') {
            $admin = "admin";
            $admin_user = tc_select_value("empfullname", "employees", "empfullname = ?", $admin);

            if (!isset($admin_user)) {
                tc_insert_strings("employees", array(
                    "empfullname"     => $admin,
                    "employee_passwd" => 'xy.RY2HT1QTc2',
                    "displayname"     => 'administrator',
                    "admin"           => 1,
                    "reports"         => 1,
                    "time_admin"      => 1,
                ));
                msg_added("<b>$admin</b> user has been added to the <u>$db_name</u> database.");
                $changes_made += 1;
            }
        }


        if (empty($changes_made)) {
            echo "<tr><td class=table_rows style='padding-left:25px;' height=40 valign=bottom colspan=2><b>No changes were made to the database.</b></td></tr>\n";
        } else {
            echo "<tr><td class=table_rows style='padding-left:25px;' height=40 valign=bottom colspan=2><b>Your database is now up to date.</b></td></tr>\n";
        }
        echo "            </table>\n";
        echo "          </td>\n";
        echo "        </tr>\n";
        include '../footer.php';
        exit;
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
