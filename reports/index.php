<?php

session_start();

$self = $_SERVER['PHP_SELF'];
$request = $_SERVER['REQUEST_METHOD'];

include '../config.inc.php';

if ($use_reports_password == "yes") {

if (!isset($_SESSION['valid_reports_user'])) {

echo "<title>$title</title>\n";
include '../admin/header.php';
include 'topmain.php';

echo "<table width=100% border=0 cellpadding=7 cellspacing=1>\n";
echo "  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Reports</td></tr>\n";
echo "  <tr class=right_main_text>\n";
echo "    <td align=center valign=top scope=row>\n";
echo "      <table width=200 border=0 cellpadding=5 cellspacing=0>\n";
echo "        <tr class=right_main_text><td align=center>You are not presently logged in, or do not have permission to view this page.</td></tr>\n";
echo "        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='../login_reports.php'><u>here</u></a> to login.</td></tr>\n";
echo "      </table><br /></td></tr></table>\n"; exit;
}
}

include '../admin/header.php';

if ($use_reports_password == "yes") {
include 'topmain.php';
} else {
include 'topmain.php';
}
echo "<title>$title - Reports</title>\n";

echo "<table width=100% height=89% border=0 cellpadding=0 cellspacing=1>\n";
echo "  <tr class=right_main_text height=40><td align=center class=title_underline style='color:#853d27;'>Run Reports</td></tr>\n";
echo "  <tr class=right_main_text height=25>\n";
echo "    <td align=center valign=top>&#8226;&nbsp;<a class=admin_headings href='timerpt.php'>Daily Time Report</a>&nbsp;&#8226;</td></tr>\n";
echo "  <tr class=right_main_text height=25>\n";
echo "    <td align=center valign=top>&#8226;&nbsp;<a class=admin_headings href='total_hours.php'>Hours Worked Report</a>&nbsp;&#8226;</td></tr>\n";
echo "  <tr class=right_main_text height=92%>\n";
echo "    <td align=center valign=top>&#8226;&nbsp;<a class=admin_headings href='audit.php'>Audit Log</a>&nbsp;&#8226;</td></tr>\n";
include '../footer.php';
?>

