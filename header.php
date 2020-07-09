<?php

include 'functions.php';

ob_start();
echo "<html>\n";

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

// connect to db anc check for correct db version //

@ $db = mysqli_connect($db_hostname, $db_username, $db_password);
if (!$db) {
    echo "Error: Could not connect to the database. Please try again later.";
    exit;
}
mysqli_select_db($db,$db_name);

$table = "dbversion";
$result = mysqli_query($db,"SHOW TABLES LIKE '" . $db_prefix . $table . "'");
@$rows = mysqli_num_rows($result);

if ($rows == "1") {
    $dbexists = "1";
} else {
    $dbexists = "0";
}

$db_version_result = mysqli_query($db,"select * from " . $db_prefix . "dbversion");
while (@$row = mysqli_fetch_array($db_version_result)) {
    @$my_dbversion = "" . $row["dbversion"] . "";
}

// include css and timezone offset//

if (($use_client_tz == "yes") && ($use_server_tz == "yes")) {
    echo 'Please reconfigure your config.inc.php file, you cannot have both $use_client_tz AND $use_server_tz set to \'yes\'';
    exit;
}

echo "<head>\n";
if ($use_client_tz == "yes") {
    if (!isset($_COOKIE['tzoffset'])) {
        include 'tzoffset.php';
        echo "<meta http-equiv='refresh' content='0;URL=timeclock.php'>\n";
    }
}

echo "<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />\n";
echo "<link rel='stylesheet' type='text/css' media='print' href='css/print.css' />\n";

// set refresh rate for each page //

if ($refresh == "none") {
    echo "</head>\n";
} else {
    echo "<meta http-equiv='refresh' content=\"$refresh;URL=timeclock.php\">\n";
    echo "<script language=\"javascript\" src=\"scripts/pnguin_timeclock.js\"></script>\n";
    echo "</head>\n";
}

setTimeZone();

?>
<body>
