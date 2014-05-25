<?php
/**
 * Enter punch-in/out time.
 *
 * This is a non-ajax punchclock entry form that can be used independently
 * by employees on their own computer or by mobile users.
 */

$current_page = "entry.php";

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

$msg = '';
$error_msg = '';

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

if ($empfullname) {
    $u_empfullname = rawurlencode($empfullname);
    $h_empfullname = htmlentities($empfullname);
    $h_name_header = $show_display_name == 'yes' ? htmlentities(get_employee_name($empfullname)) : $h_empfullname;
}

// Authorize employee
$authorized = isset($_SESSION['authenticated']) ? ($_SESSION['authenticated'] == $empfullname) : false;

if (!$authorized) {
    $_SESSION['login_title'] = "";
    $_SESSION['login_error_msg'] = $error_msg;
    $_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
    exit_next("login.php" . ($u_empfullname ? "?emp=$u_empfullname" : ''));
}

////////////////////////////////////////
if ($authorized && isset($_POST['inout'])) {
    // Post employee time.

    $inout = $_POST['inout'];
    $q_inout = mysql_real_escape_string($inout);
    $h_inout = htmlentities($inout);

    $notes = isset($_POST['notes']) ? $_POST['notes'] : '';
    $q_notes = mysql_real_escape_string($notes);
    $h_notes = htmlentities($notes);

    $q_empfullname = mysql_real_escape_string($empfullname);

    // Validate and get inout display color.
    $query = "select color from " . $db_prefix . "punchlist where punchitems = '$q_inout'";
    $punchlist_result = mysql_query($query);
    $inout_color = mysql_result($punchlist_result, 0, 0);
    if (!$inout_color) {
        #print error_msg("In/Out Status is not in the database.");
        trigger_error('In/Out Status is not in the database.', E_USER_WARNING);
        exit;
    }
    $h_color = htmlentities($inout_color);

    // Record time.
    $tz_stamp = utm_timestamp();
    $ip = (strtolower($ip_logging) == "yes") ? "'" . get_ipaddress() . "'" : 'NULL';

    $insert_query = <<<End_Of_SQL
insert into {$db_prefix}info (fullname, `inout`, timestamp, notes, ipaddress)
values ('$q_empfullname', '$q_inout', '$tz_stamp', '$q_notes', $ip)
End_Of_SQL;

    $update_query = <<<End_Of_SQL
update {$db_prefix}employees
set tstamp = '$tz_stamp'
where empfullname = '$q_empfullname'
End_Of_SQL;

    if (mysql_query($insert_query)) {
        mysql_query($update_query)
        or trigger_error('entry: cannot update tstamp in employee record. ' . mysql_error(), E_USER_WARNING);
    } else {
        trigger_error('entry: cannot insert timestamp into info record. ' . mysql_error(), E_USER_WARNING);
    }

    # Uncomment next to display success message. The entry status display also shows last punch-in/out.
    #$msg .= "<span color=\"$h_color\">$h_inout</span> time entry recorded.\n";

    // Fall through to re-enter next punch-in/out time.
}

////////////////////////////////////////
// Display the entry form.

$PAGE_TITLE = "My Time Entry - $title";

if ($entry_display_timecard == 'yes') {

    // Summarize employee hours for the current week.
    list ($today_hours, $week_hours, $overtime_hours) = current_week_hours($empfullname);
    if ($timecard_display_hours_minutes == 'yes') {
        $today_hours = hrs_min($today_hours) . " hrs:min";
        $week_hours = hrs_min($week_hours) . " hrs:min";
        $overtime_hours = hrs_min($overtime_hours) . " hrs:min";
    } else {
        $today_hours = sprintf("%01.02f hrs", $today_hours);
        $week_hours = sprintf("%01.02f hrs", $week_hours);
        $overtime_hours = sprintf("%01.02f hrs", $overtime_hours);
    }

    $overtime_line = $overtime_hours > 0 ? "\n<tr><th>Overtime:</th><td>$overtime_hours</td></tr>\n" : '';
    $current_week_summary = <<<End_Of_HTML

<div class="hours-summary">
<table>
<tr><th>Today:</th><td>$today_hours</td></tr>
<tr><th>This Week:</th><td>$week_hours</td></tr>$overtime_line
<tr><td colspan="2"><a href="timecard.php?emp=$u_empfullname" target="_blank">Timecard</a></td></tr>
</table>
</div>

End_Of_HTML;
}

// Define auto-refresh script for header.php
$refresh_script = ($entry_refresh != "none") ? "setTimeout(function(){ location.href='?emp=$u_empfullname'; },$entry_refresh*1000);" : '';
$PAGE_SCRIPT = <<<End_Of_HTML
<script type="text/javascript">
//<![CDATA[
$(function(){
	// Show and hide "synchronizing" message.
	$('form input:first').focus();
	$('#message').css({visibility:'visible'});
	setTimeout(function(){ $('#message').css({visibility:'hidden'}); }, 500);

	$refresh_script
});
//]]>
</script>
End_Of_HTML;
$PAGE_BODY_ID = 'entry';
?>

<?php include 'header.php'; ?>
<div id="message">Synchronizing, Please Wait...</div>
<?php include "time.php"; ?>
<?php if ($msg)
    print msg($msg); ?>
<?php if ($error_msg)
    print error_msg($error_msg); ?>

<div id="entry_form">
    <form action="entry.php" method="post">
        <table align=center class=table_border width=100% border=0 cellpadding=3 cellspacing=0>
            <col width="10%">
            <col width="80%">
            <col width="10%">
            <tr>
                <th class="rightside_heading" nowrap align="left" colspan="3"><img
                        src="<?php echo $TIMECLOCK_URL; ?>/images/icons/clock_add.png"/>&nbsp;&nbsp;&nbsp;Punch In /
                    Punch Out
                </th>
            </tr>
            <tr>
                <td height="15" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="3" align="left" style="padding-left:32px;"><?php echo "$h_name_header"; ?><a
                        href="?emp=<?php echo $u_empfullname; ?>" class="refresh-link">Refresh</a></th>
            </tr>
            <tr>
                <td height="15" colspan="3"><?php include "entry_status.php"; ?></td>
            </tr>
            <tr>
                <td height="15" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td class="table_rows" height="25" align="right" nowrap>Note :</td>
                <td colspan="2"><input type="text" maxlength="250" name="notes" value="" style="width:90%"/></td>
            </tr>
            <tr>
                <td height=15 colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td class="table_rows" height="25" style="padding-left:32px;" colspan="3">
                    <?php

                    // query to produce buttons for the punchlist items //
                    $query = "select punchitems,color,in_or_out from " . $db_prefix . "punchlist order by in_or_out desc, color, punchitems";
                    $punchlist_result = mysql_query($query);
                    while ($row = mysql_fetch_array($punchlist_result)) {
                        $punchclass = $row['in_or_out'] ? 'punch-in' : 'punch-out';
                        echo "<input type=\"submit\" name=\"inout\" value=\"{$row['punchitems']}\" class=\"$punchclass\" style=\"color:{$row['color']}\" />\n";
                    }
                    mysql_free_result($punchlist_result);

                    ?>
                </td>
            </tr>
            <tr>
                <td height="15" colspan="3">&nbsp;</td>
            </tr>
        </table>
        <?php echo $current_week_summary; ?>

        <table align="center" border="0" cellpadding="0" cellspacing="3" class="buttons">
            <tr>
                <td><a href="?logout"><img src="<?php echo $TIMECLOCK_URL; ?>/images/buttons/done_button.png"
                                           border="0"/></a></td>
            </tr>
        </table>

        <input type="hidden" name="empfullname" value="<?php echo $h_empfullname; ?>"/>
    </form>
</div>
<?php include 'footer.php'; ?>
