<?php
/**
 * Setup timeclock database and authorizations.
 *
 * This was assembled from timeclock header*.php files
 * but excludes any html output (except for errors and
 * to return to the browser so it can set its local timezone).
 */

if (!isset($_SESSION['application']))
    die("Invalid invocation.");

require_once "$TIMECLOCK_PATH/functions.php";

// grab the connecting ip address. //

$connecting_ip = get_ipaddress();
if (empty($connecting_ip)) {
    return false;
}

// determine if connecting ip address is allowed to connect to PHP Timeclock //

if ($restrict_ips == "yes") {
    for ($x = 0; $x < count($allowed_networks); $x++) {
        $is_allowed = ip_range($allowed_networks[$x], $connecting_ip);
        if (!empty($is_allowed)) {
            $allowed = true;
        }
    }
    if (!isset($allowed)) {
        echo "You are not authorized to view this page.";
        exit;
    }
}

// check for correct db version //

@ $db = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db) {
    echo "Error: Could not connect to the database. Please try again later.";
    exit;
}
mysql_select_db($db_name);

$table = "dbversion";
$result = mysql_query("SHOW TABLES LIKE '" . $db_prefix . $table . "'");
$rows = $result ? mysql_num_rows($result) : 0;
$dbexists = $rows == 1 ? "1" : "0";

$db_version_result = mysql_query("select * from " . $db_prefix . "dbversion");
while (@$row = mysql_fetch_array($db_version_result)) {
    @$my_dbversion = "" . $row["dbversion"] . "";
}

// include css and timezone offset//

if (($use_client_tz == "yes") && ($use_server_tz == "yes")) {
    die("Please reconfigure your config.inc.php file, you cannot have both \$use_client_tz AND \$use_server_tz set to 'yes'");
}

// Note: set global $tzo for included timeclock functions. It is not used in punchclock.
if ($use_client_tz == "yes") {
    if (isset($_COOKIE['tzoffset'])) {
        $tzo = $_COOKIE['tzoffset'];
        settype($tzo, "integer");
        $tzo = $tzo * 60;
    } else {
        // Return to browser so it can set cookie identifying its local timezone.
        echo "<html><head>\n";
        echo "<meta http-equiv=\"refresh\" content=\"0;URL={$SERVER['PHP_SELF']}?{$SERVER['QUERY_STRING']}\">\n";
        include "$TIMECLOCK_PATH/tzoffset.php";
        echo "</head><body></body></html>\n";
        exit;
    }
} elseif ($use_server_tz == "yes") {
    $tzo = date('Z');
} else {
    $tzo = "1";
}
?>
