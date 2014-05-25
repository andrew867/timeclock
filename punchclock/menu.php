<?php
/**
 * Home page.
 *
 * Display menu of punchclocks for each office and main timeclock page.
 */

$current_page = "menu.php";

session_start();
$_SESSION['application'] = $current_page; // security

include 'config.inc.php';
include 'setup_timeclock.php'; // authorize and initialize

$PAGE_TITLE = "Menu = $title";
$PAGE_STYLE = <<<End_Of_HTML
<style type="text/css">
a:link, a:visited, a:active { color: #27408b; text-decoration: none; }
a:hover { font-size:inherit; text-decoration:none; }
#entry_links, #office_links, #timeclock_links, #export_links  { width:300px; margin:15px auto; font-size:13px; line-height:25px; }
#entry_links li, #office_links li, #timeclock_links li, #export_links li { list-style:none; padding-left:10px; }
#entry_links li:hover, #office_links li:hover, #timeclock_links li:hover, #export_links li:hover { color:#853d27; text-decoration:underline; }
#entry_links li:hover a, #office_links li:hover a,#timeclock_links li:hover a, #export_links li:hover a { color:#853d27; font-size:inherit; }
</style>
End_Of_HTML;

include 'header.php';
?>
<ul id="entry_links">
    <li><a href="entry.php">My Time Entry</a></li>
    <li><a href="timecard.php">My Timecard</a></li>
</ul>
<?php
// Construct list of links to punchclocks for each office.

$result = mysql_query("SELECT officename FROM offices ORDER BY officename");

$row_count = 0;
while ($row = mysql_fetch_array($result)) {
    $row_count++;
    if ($row_count == 1) {
        print <<<End_Of_HTML

<ul id="office_links">
End_Of_HTML;
    }

    $h_officename = htmlentities($row["officename"]);
    $u_officename = rawurlencode($row["officename"]);

    $targetname = preg_replace('/\W/', '', $row["officename"]);
    # Uncomment the following to open punchclock in new window with minimum chrome.
    #	print <<<End_Of_HTML
    #
    #  <li><a href="punchclock.php?office=$u_officename" target="$targetname" onclick="window.open('','$targetname','resizable,scrollbars').focus();return true;">$h_officename Punchclock</a></li>
    #End_Of_HTML;
    # Uncomment following to open punchclock in current browser window.
    print <<<End_Of_HTML

  <li><a href="punchclock.php?office=$u_officename">$h_officename Punchclock</a></li>
End_Of_HTML;
}

if ($row_count > 0)
    print <<<End_Of_HTML

</ul>

End_Of_HTML;

mysql_free_result($result);

if ($row_count == 0) {
    print <<<End_Of_HTML
<ul id="office_links">
  <li><a href="punchclock.php">Punchclock</a></li>
</ul>
End_Of_HTML;

}
?>

<ul id="timeclock_links">
    <li><a href="<?php echo "$TIMECLOCK_URL"; ?>/timeclock.php">Timeclock Main Program</a></li>
    <li><a href="<?php echo "$TIMECLOCK_URL"; ?>/login_reports.php">Timeclock Reports</a></li>
    <li><a href="<?php echo "$TIMECLOCK_URL"; ?>/login.php">Timeclock Administration</a></li>
</ul>

<ul id="export_links">
    <li><a href="export.php">Export Hours</a></li>
</ul>

<?php include 'footer.php'; ?>
