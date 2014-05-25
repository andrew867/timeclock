<?php
/**
 * Punchclock entry form.
 *
 * This is an AJAX form and it returns incomplete HTML fragments.
 */

session_start();
if (!isset($_SESSION['application']))
    die("Invalid invocation.");

require_once 'config.inc.php';
require_once 'lib.common.php';
require_once 'lib.timecard.php';
require_once "$TIMECLOCK_PATH/functions.php";
turn_off_magic_quotes();

// Connect to db.
$db = mysql_connect($db_hostname, $db_username, $db_password)
or die("Could not connect to the database.");
mysql_select_db($db_name);

// Parse arguments.
$emp = isset($_GET['emp']) ? $_GET['emp'] : null;
$empfullname = isset($_REQUEST['empfullname']) ? $_REQUEST['empfullname'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

if (!$empfullname)
    $empfullname = $emp; // from url or form entry
if (!$empfullname)
    die(error_msg("Unrecognized employee.")); // no employee specified

$h_empfullname = htmlentities($empfullname);
$u_empfullname = rawurlencode($empfullname);

$h_name_header = $show_display_name == 'yes' ? htmlentities(get_employee_name($empfullname)) : $h_empfullname;

// Authentication and authorization flags.
$authenticated = isset($_SESSION['authenticated']) ? ($_SESSION['authenticated'] == $empfullname) : false;
$authorized_to_enter_time = isset($_SESSION['authorized_to_enter_time']) ? ($_SESSION['authorized_to_enter_time'] == $empfullname) : false;
$authorized_to_post_time = isset($_SESSION['authorized_to_post_time']) ? ($_SESSION['authorized_to_post_time'] == $empfullname) : false;

if ($authorized_to_post_time && isset($_POST['inout'])) {
    // Clear all authorization flags.
    unset($_SESSION['authenticated']);
    unset($_SESSION['authorized_to_enter_time']);
    unset($_SESSION['authorized_to_post_time']);

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
        or trigger_error('punchclock: cannot update tstamp in employee record. ' . mysql_error(), E_USER_WARNING);
    } else {
        trigger_error('punchclock: cannot insert timestamp into info record. ' . mysql_error(), E_USER_WARNING);
    }

    // Update display line on punchclock list and close form.
    $id = make_id($empfullname);
    $display_stamp = local_timestamp($tz_stamp);
    $time = date($timefmt, $display_stamp);
    $date = date($datefmt, $display_stamp);

    # Note nyroModal 1.6.2: must have LF (IE needs characters) outside of <script> otherwise nyroModal window does not close.
    print <<<End_Of_HTML
<p>stupid text to get this to work in IE</p>
<script type="text/javascript">
//<![CDATA[
// Post results to main page employee list
$('#$id td').each(function(index){
	if (index == 1) {
		this.innerHTML = "$h_inout";
		this.style.color = "$inout_color";
	}
	if (index == 2) this.innerHTML = "$time";
	if (index == 3) this.innerHTML = "$date";
});
$('#$id td:last').each(function(){
	this.innerHTML = "$h_notes";
});
$.nyroModalRemove();	// close form
//]]>
</script>
End_Of_HTML;
    exit;
}

if ($use_passwd == 'yes') {
    // Allow time administrators and system administrators to bypass the password screen.
    if ((!$authenticated || !$authorized_to_enter_time) && (isset($_SESSION['time_admin_valid_user']) || isset($_SESSION['valid_user']))) {
        $_SESSION['authenticated'] = $empfullname;
        $_SESSION['authorized_to_enter_time'] = $empfullname;
        $_SESSION['authorized_to_post_time'] = $empfullname;
        $authenticated = $authorized_to_enter_time = $authorized_to_post_time = true;
    }

    if ((!$authenticated || !$authorized_to_enter_time) && $password) {

        // Validate password
        if (is_valid_password($empfullname, $password)) {
            $_SESSION['authenticated'] = $empfullname;
            $_SESSION['authorized_to_enter_time'] = $empfullname;
            $_SESSION['authorized_to_post_time'] = $empfullname;
            $authenticated = $authorized_to_enter_time = $authorized_to_post_time = true;
        } else {
            print error_msg("Password is incorrect. Please try again.");
        }
    }

    if (!$authenticated || !$authorized_to_enter_time) {

        // Security: make sure no one is already authenticated before displaying password screen.
        unset($_SESSION['authenticated']);
        unset($_SESSION['authorized_to_enter_time']);
        unset($_SESSION['authorized_to_post_time']);

        // Authenticate employee
        print <<<End_Of_HTML

<div id="password_entry_form">
<form action="entry.ajax.php" method="post" class="nyroModal">
<table align=center class=table_border width=100% border=0 cellpadding=3 cellspacing=0>
  <tr>
	<th class=rightside_heading nowrap align=left colspan=3><img src='$TIMECLOCK_URL/images/icons/clock_add.png' />&nbsp;&nbsp;&nbsp;Enter your password
	</th>
  </tr>
  <tr><td height=15 colspan="3"></td></tr>
  <tr><th colspan="3" align="left" style='padding-left:32px;'>$h_name_header</th></tr>
  <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap>Password:</td>
      <td colspan=2 width=80% style='color:red;font-family:Tahoma;font-size:10px;'>
	  <input type='password' size='25' maxlength='50' name='password' value="" />&nbsp;*</td></tr>
  <tr><td class=table_rows height=25 width=20% style='padding-left:32px;' nowrap colspan="3">
	<a href="password.ajax.php?forgot_password&emp=$u_empfullname" class="nyroModal">Forgot your password</a>
        &nbsp;&nbsp;
	<a href="password.ajax.php?emp=$u_empfullname" class="nyroModal">Change your password</a></td></tr>
  <tr><td height=15 colspan="3">&nbsp;</td></tr>
  <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>
</table>
<table align=center width=100% border=0 cellpadding=0 cellspacing=3 class="buttons">
  <tr><td width=30><input type='image' name='submit' value='Next' align='middle' src='$TIMECLOCK_URL/images/buttons/next_button.png' /></td>
      <td><a href='javascript:history.back();' class="nyroModalClose"><img src='$TIMECLOCK_URL/images/buttons/cancel_button.png' border='0' /></a></td></tr>
</table>
<input type="hidden" name="empfullname" value="$h_empfullname" />
</form>
</div>

End_Of_HTML;
        exit;
    }
} else {
    $_SESSION['authenticated'] = $empfullname; // no passwords, so always true.
    $_SESSION['authorized_to_enter_time'] = $empfullname; // no passwords, so always true.
    $_SESSION['authorized_to_post_time'] = $empfullname; // no passwords, so always true.
}

// Display the punchclock entry form.
// A user is authorized for the display of the form only one time.
// This prevents a user from displaying the form and then canceling out of
// the form allowing the form to be displayed again without entering a password.
if (isset($_SESSION['authorized_to_enter_time']))
    unset($_SESSION['authorized_to_enter_time']);

if ($punchclock_display_timecard == 'yes') {

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

    $overtime_line = $overtime_hours > 0 ? "<tr><th>Overtime:</th><td>$overtime_hours</td></tr>\n" : '';
    $current_week_summary = <<<End_Of_HTML

<div class="hours-summary">
<table>
<tr><th>Today:</th><td>$today_hours</td></tr>
<tr><th>This Week:</th><td>$week_hours</td></tr>
$overtime_line
<tr><td colspan="2"><a href="timecard.ajax.php?emp=$u_empfullname" class="nyroModal">Timecard</a></td></tr>
</table>
</div>
End_Of_HTML;
}
?>

<div id="entry_form">
    <form action="entry.ajax.php" method="post" class="nyroModal">
        <table align=center class=table_border width=100% border=0 cellpadding=3 cellspacing=0>
            <tr>
                <th class=rightside_heading nowrap align=left colspan=3><img
                        src='<?php echo $TIMECLOCK_URL; ?>/images/icons/clock_add.png'/>&nbsp;&nbsp;&nbsp;Punch In /
                    Punch Out
                </th>
            </tr>
            <tr>
                <td height=15 colspan="3"></td>
            </tr>
            <tr>
                <th colspan="3" align="left" style='padding-left:32px;'><?php echo "$h_name_header"; ?></th>
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
                <td class="table_rows" height="25" style="padding-left:32px;" nowrap colspan="3">
                    <?php

                    // query to produce buttons for punchlist items //
                    $query = "select punchitems,color,in_or_out from " . $db_prefix . "punchlist order by in_or_out desc, color, punchitems";
                    $punchlist_result = mysql_query($query);
                    while ($row = mysql_fetch_array($punchlist_result)) {
                        $punchclass = $row['in_or_out'] ? 'punch-in' : 'punch-out';
                        ## Note: nyroModel plays with submit buttons so the following does not work.
                        ## The value of the submit button is not passed to the server. As a workaround
                        ## use an onclick handler that copies button value to a hidden text field.
                        ##echo "<input type=\"submit\" name=\"inout\" value=\"{$row['punchitems']}\" class=\"$punchclass\" style=\"color:{$row['color']}\" />\n";
                        echo "<input type=\"submit\" value=\"{$row['punchitems']}\" class=\"$punchclass\" style=\"color:{$row['color']}\" onclick=\"this.form.inout.value=this.value;\" />\n";
                    }
                    mysql_free_result($punchlist_result);
                    ?>
                </td>
            </tr>
            <tr>
                <td height=15 colspan="3">&nbsp;</td>
            </tr>
        </table>
        <?php echo $current_week_summary; ?>
        <table align=center border=0 cellpadding=0 cellspacing=3 class="buttons">
            <tr>
                <td><a href='javascript:history.back();' class="nyroModalClose"><img
                            src='<?php echo $TIMECLOCK_URL; ?>/images/buttons/cancel_button.png' border='0'/></a></td>
            </tr>
        </table>
        <input type="hidden" name="empfullname" value="<?php echo $h_empfullname; ?>"/>
        <input type="hidden" name="inout" value=""/>
    </form>
</div>
