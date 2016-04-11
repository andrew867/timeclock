<?php

session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

include '../config.inc.php';
include '../admin/header.php';
if ($use_reports_password == "yes") {

    if (!isset($_SESSION['valid_reports_user'])) {

        echo "<title>$title</title>\n";
        
        include 'topmain.php';


        echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
        echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Reports</td></tr>\n";
        echo "  <tr class=right_main_text>\n";
        echo "    <td align=center valign=top scope=row>\n";
        echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
        echo "        <tr class=right_main_text><td align=center>You are not presently logged in, or do not have permission to view this page.</td></tr>\n";
        echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='../login_reports.php'><u>here</u></a> to login.</td></tr>\n";
        echo "      </table><br /></td></tr></table>\n";
        exit;
    }
}



if ($use_reports_password == "yes") {
    include '../admin/topmain.php';
} else {
    include 'topmain.php';
}
?>
<section id="main-content">
    <section class="wrapper">
<div class="row">
<a href="timerpt.php" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <div class="info-box blue-bg">
      <i class="fa fa-list-alt"></i>
      <div class="count">Daily Time</div>
      <div class="title">Report</div>
  </div><!--/.info-box-->
</a><!--/.col-->

<a href="total_hours.php" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <div class="info-box brown-bg">
      <i class="fa fa-list-alt"></i>
      <div class="count">Hours Worked</div>
      <div class="title">Report</div>
  </div><!--/.info-box-->
</a><!--/.col-->

<a href="audit.php" class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
  <div class="info-box dark-bg">
      <i class="fa fa-list-alt"></i>
      <div class="count">Audit</div>
      <div class="title">Log</div>
  </div><!--/.info-box-->
</a><!--/.col-->



</div><!--/.row-->
</section>
</section>
</body>
<?php
include 'footer.php';
?>
