<?php
/**
 * Timecard entries of employee punch-in/out times and hours.
 *
 * This is an AJAX form and it returns incomplete HTML fragments.
 */

session_start();
if (!isset($_SESSION['application']))
    die("Invalid invocation."); // set in punchclock.php

require_once 'config.inc.php';
require_once 'lib.common.php';
require_once 'lib.timecard.php';
turn_off_magic_quotes();

// Parse arguments.
$emp = isset($_GET['emp']) ? $_GET['emp'] : null;
$empfullname = isset($_REQUEST['empfullname']) ? $_REQUEST['empfullname'] : null;

if (!$empfullname)
    $empfullname = $emp; // from url or form entry
if (!$empfullname)
    die(error_msg("Unrecognized employee.")); // no employee specified

// To run this report, employee must have been authorized to punch-in/out first.
$authorized = isset($_SESSION['authenticated']) ? ($_SESSION['authenticated'] == $empfullname) : false;

if (!$authorized) {
    die(error_msg("Not authorized to run this report."));
}

// Find which week to print timecard.
$local_timestamp_in_week = isset($_REQUEST['t']) ? ($_REQUEST['t']) : local_timestamp();

if (isset($_REQUEST['prev']))
    $local_timestamp_in_week -= $one_week;
if (isset($_REQUEST['next']))
    $local_timestamp_in_week += $one_week;

// Connect to db.
$db = mysql_connect($db_hostname, $db_username, $db_password)
or die("Could not connect to the database.");
mysql_select_db($db_name);

$u_empfullname = rawurlencode($empfullname);

// Print navigation buttons to next and previous week.
// Note: cannot put title attribute on <a> as nyroModal uses that for a title over the next display.
print <<<End_Of_HTML
<div class="nav-buttons">
<a href="timecard.ajax.php?emp=$empfullname&t=$local_timestamp_in_week&prev" class="nyroModal"><img src="images/prev_page.gif" alt="Previous" /></a><a href="timecard.ajax.php?emp=$empfullname&t=$local_timestamp_in_week&next" class="nyroModal"><img src="images/next_page.gif" alt="Next" /></a>
</div>
End_Of_HTML;

// Print timecard.
print timecard_html($empfullname, $local_timestamp_in_week);

print "<a id=\"printer_friendly\" href=\"timecard.php?emp=$empfullname&t=$local_timestamp_in_week\" target=\"_blank\">Printer Friendly</a>";
?>
