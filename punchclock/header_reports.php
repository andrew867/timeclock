<?php
/**
 * Setup Punchclock reports.
 *
 * Wrapper around Timeclock header.
 * This loads in the javascript for managing the Offices, Groups, and Employee dropdown
 * fields for entering report parameters.
 */

require_once 'config.inc.php';

$punchclock_path = getcwd();
chdir("$TIMECLOCK_PATH/reports");
ob_start();

include "header_get_reports.php";

$header = ob_get_contents();
ob_end_clean();
chdir($punchclock_path);

// Need to adjust relative links to point to timeclock path.
$header = preg_replace('/( (src|href)=[\'"])(?!http:)/', "$1$TIMECLOCK_URL/reports/", $header);
// Put title into valid place
$header = preg_replace('/(<html>)/', "$1\n<title>$PAGE_TITLE</title>", $header);

print $header;
?>
