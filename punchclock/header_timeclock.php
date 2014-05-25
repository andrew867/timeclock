<?php
/**
 * Punchclock header.
 * Wrapper around Timeclock header.
 */

require_once 'config.inc.php';

$punchclock_path = getcwd();
chdir("$TIMECLOCK_PATH");
ob_start();

include "topmain.php";

$header = ob_get_contents();
ob_end_clean();
chdir($punchclock_path);

// Need to adjust relative links to point to timeclock path.
$header = preg_replace('/( (src|href)=[\'"])(?!http:)/', "$1$TIMECLOCK_URL/", $header);

print $header;
?>
