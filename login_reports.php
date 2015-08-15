<?php
session_start();

include 'config.inc.php';
include 'header.php';


$self = $_SERVER['PHP_SELF'];

if (isset($_POST['login_userid']) && (isset($_POST['login_password']))) {
    $login_userid = $_POST['login_userid'];
    $login_password = crypt($_POST['login_password'], 'xy');

    $query = "select empfullname, employee_passwd, reports from " . $db_prefix . "employees
              where empfullname = '" . $login_userid . "'";
    $result = mysql_query($query);

    while ($row = mysql_fetch_array($result)) {

        $reports_username = "" . $row['empfullname'] . "";
        $reports_password = "" . $row['employee_passwd'] . "";
        $reports_auth = "" . $row['reports'] . "";
    }

    if (($login_userid == @$reports_username) && ($login_password == @$reports_password) && ($reports_auth == "1")) {
        $_SESSION['valid_reports_user'] = $login_userid;
    }

}

if (isset($_SESSION['valid_reports_user'])) {
    echo "<script type='text/javascript' language='javascript'> window.location.href = 'reports/index.php';</script>";
    exit;

} else {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
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
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">

      <form class="login-form" name='auth' method='post' action=''>        
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name='login_userid' class="form-control" placeholder="Username" autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name='login_password' class="form-control" placeholder="Password">
            </div>
           
            <button class="btn btn-primary btn-lg btn-block" onClick='admin.php' type="submit">Login</button>
           
        </div>
      </form>

    </div>

  <?php
}

echo "</body>\n";
echo "</html>\n";
?>
