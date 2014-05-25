<?php
/**
 * Timecard entries of employee punch-in/out times and hours.
 */

$current_page = "timecard.php";

require_once 'config.inc.php';
require_once 'lib.common.php';
require_once 'lib.timecard.php';
turn_off_magic_quotes();

// Check for logout
if (isset($_REQUEST['logout'])) {
    session_stop();
    unset($_GET['emp']); // safety
    unset($_REQUEST['empfullname']); // safety
    exit_next(preg_replace('/[^\/]*$/', '', $_SERVER['PHP_SELF'])); // goto index page
}

session_start();
$_SESSION['application'] = $current_page; // security

include 'setup_timeclock.php'; // authorize and initialize

// Parse arguments.
$emp = isset($_GET['emp']) ? $_GET['emp'] : null;
$empfullname = isset($_REQUEST['empfullname']) ? $_REQUEST['empfullname'] : null;

if (!$empfullname)
    $empfullname = $emp; // from url or form entry

// Lookup valid employee
if ($empfullname) {
    $empfullname = lookup_employee($empfullname);
    if (!$empfullname) {
        $error_msg .= "Name was not recognized. Please re-enter your name.\n";
        unset($_SESSION['authenticated']);
    }
}

// Authorize employee
$authorized = $empfullname && isset($_SESSION['authenticated']) ? ($_SESSION['authenticated'] == $empfullname) : false;
if (!$authorized)
    $authorized = ($empfullname && isset($_SESSION['valid_user'])) ? true : false; // check if administrator
if (!$authorized)
    $authorized = ($empfullname && isset($_SESSION['time_admin_valid_user'])) ? true : false; // check if time administrator
if (!$authorized) {
    ##die(error_msg("Not authorized to run this report."));
    $_SESSION['login_error_msg'] = $error_msg;
    $_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
    exit_next("login.php" . ($empfullname ? "?emp=$u_empfullname" : ''));
}

// Find which week to print timecard.
$local_timestamp_in_week = isset($_REQUEST['t']) ? ($_REQUEST['t']) : local_timestamp();

if (isset($_REQUEST['prev']))
    $local_timestamp_in_week -= $one_week;
if (isset($_REQUEST['next']))
    $local_timestamp_in_week += $one_week;

// Display timecard.
$PAGE_TITLE = "Timecard - $title";
$PAGE_STYLE = <<<End_Of_HTML
<style type="text/css">
.nav-buttons { float:right; margin-top:8px; margin-right:8px; }
@media print {
	.page { width:50%; min-width:400px; }
	.buttons { display:none; }
	.nav-buttons { display:none; }
	.topmain_row_color { display:none; }
	.misc_items { color:#222; }
}
</style>
End_Of_HTML;
$PAGE_CONTENT_HEADER = <<<End_Of_HTML
<div class="nav-buttons">
<a href="?emp=$empfullname&t=$local_timestamp_in_week&prev" title="Previous timecard."><img src="images/prev_page.gif" alt="Previous" /></a><a href="?emp=$empfullname&t=$local_timestamp_in_week&next" title="Next timecard."><img src="images/next_page.gif" alt="Next" /></a>
</div>
End_Of_HTML;

include 'header.php';

print timecard_html($empfullname, $local_timestamp_in_week);

print <<<End_Of_HTML

<table align="center" border="0" cellpadding="0" cellspacing="3" class="buttons">
  <tr><td><a href="?logout"><img src="$TIMECLOCK_URL/images/buttons/done_button.png" border="0" /></a></td></tr>
</table>

End_Of_HTML;

include 'footer.php';
