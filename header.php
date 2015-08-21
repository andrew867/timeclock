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

@ $db = mysql_pconnect($db_hostname, $db_username, $db_password);
if (!$db) {
    echo "Error: Could not connect to the database. Please try again later.";
    exit;
}
mysql_select_db($db_name);

$table = "dbversion";
$result = mysql_query("SHOW TABLES LIKE '" . $db_prefix . $table . "'");
@$rows = mysql_num_rows($result);

if ($rows == "1") {
    $dbexists = "1";
} else {
    $dbexists = "0";
}

$db_version_result = mysql_query("select * from " . $db_prefix . "dbversion");
while (@$row = mysql_fetch_array($db_version_result)) {
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

?>
 
    
<?php


// set refresh rate for each page //  

if ($refresh == "none") {
    echo "</head>\n";
} else {
    echo "<meta http-equiv='refresh' content=\"$refresh;URL=timeclock.php\">\n";
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PHP TimeClock, Admin">
    <meta name="author" content="Wael Ali">
    <meta name="keyword" content="PHP TimeClock, Bootstrap, Responsive">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Admin Login</title>
   <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
   
 
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css">
	<link href="css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
	
<link rel='stylesheet' type='text/css' media='screen' href='css/default.css' />
<link rel='stylesheet' type='text/css' media='print' href='css/print.css' />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
	
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
    <?php
    echo "<script language=\"javascript\" src=\"scripts/pnguin_timeclock.js\"></script>\n";
    echo "</head>\n";
}

setTimeZone();

?>
<body>
