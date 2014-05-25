<?php
/**
 * Punchclock password change form.
 *
 * This is an AJAX form and it returns incomplete HTML fragments.
 */

session_start();
if (!isset($_SESSION['application']))
    die("Invalid invocation."); // set in punchclock.php

require_once 'config.inc.php';
require_once 'lib.common.php';
turn_off_magic_quotes();

// Connect to db.
$db = mysql_connect($db_hostname, $db_username, $db_password)
or die("Could not connect to the database.");
mysql_select_db($db_name);

// Parse arguments
$change_password = isset($_GET['change_password']) ? true : false;
$forgot_password = isset($_GET['forgot_password']) ? true : false;
$emp = isset($_GET['emp']) ? $_GET['emp'] : null;

$empfullname = isset($_POST['empfullname']) ? $_POST['empfullname'] : null;
$old_password = isset($_POST['old_password']) ? $_POST['old_password'] : null;
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

if (!$empfullname)
    $empfullname = $emp; // from url or form entry
if (!$empfullname)
    die(error_msg("Unrecognized employee.")); // no employee specified

$h_empfullname = htmlentities($empfullname);
$u_empfullname = rawurlencode($empfullname);

$displayname = get_employee_name($empfullname);
$h_displayname = htmlentities($displayname);

$name_header = $show_display_name == 'yes' ? $h_displayname : $h_empfullname;

// Process form submission.
if ($old_password) {

    // Validate password
    if (is_valid_password($empfullname, $old_password)) {

        // Check if new password is same as confirm password entry
        if ($new_password === $confirm_password) {

            // Save password.
            if (save_employee_password($empfullname, $new_password)) {
                $_SESSION['authenticated'] = $empfullname;
                exit_next("entry.ajax.php?emp=$u_empfullname");
            } else {
                print error_msg("Cannot save your new password. " . mysql_error());
            }
        } else {
            print error_msg("Your new password and the confirm password do not match.<br/>Please re-enter and confirm your new password.");
        }
    } else {
        print error_msg("Password is incorrect. Please try again.");
    }
}

// Forgot password form.
if ($forgot_password) {
    print <<<End_Of_HTML

<div id="password_change_form">
<form action="entry.ajax.php" method="get" class="nyroModal">
<table align="center" class="table_border" width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr><th class="rightside_heading" nowrap align="left" colspan="3"><img src="$TIMECLOCK_URL/images/icons/lock_edit.png" />&nbsp;&nbsp;&nbsp;Forgot your password?</th></tr>
  <tr><td height="15" colspan="3">&nbsp;</td></tr>
  <tr><th colspan="3" align="left" style="padding-left:32px;">$name_header</th></tr>
  <tr><td height="15" colspan="3">&nbsp;</td></tr>
  <tr><td align="left"><p>It is not possible to lookup your old password. You will have to see a supervisor and have them change your password in the administration pages.</p></td></tr>
  <tr><td height="15" colspan="3">&nbsp;</td></tr>
</table>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="3" class="buttons">
  <tr><td><a href="javascript:history.back();" class="nyroModalClose"><img src="$TIMECLOCK_URL/images/buttons/done_button.png" border="0" /></a></td></tr>
</table>
<input type="hidden" name="empfullname" value="$h_empfullname" />
</form>
</div>

End_Of_HTML;
    exit;
}

// Password change form.
?>

<div id="password_change_form">
    <form action="password.ajax.php" method="post" class="nyroModal">
        <table align="center" class="table_border" width="100%" border="0" cellpadding="3" cellspacing="0">
            <tr>
                <th class="rightside_heading" nowrap align="left" colspan="3"><img
                        src="<?php echo $TIMECLOCK_URL; ?>/images/icons/lock_edit.png"/>&nbsp;&nbsp;&nbsp;Change your
                    password
                </th>
            </tr>
            <tr>
                <td height="15" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <th colspan="3" align="left" style="padding-left:32px;"><?php echo $name_header; ?></th>
            </tr>
            <tr>
                <td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Old Password:</td>
                <td colspan="2" width="80%"
                    style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                    <input type="password" size="25" maxlength="50" name="old_password" value=""/>&nbsp;*
                </td>
            </tr>
            <tr>
                <td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>New Password:</td>
                <td colspan="2" width="80%"
                    style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                    <input type="password" size="25" maxlength="50" name="new_password" value=""/>&nbsp;*
                </td>
            </tr>
            <tr>
                <td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Confirm Password:</td>
                <td colspan="2" width="80%"
                    style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                    <input type="password" size="25" maxlength="50" name="confirm_password" value=""/>&nbsp;*
                </td>
            </tr>
            <tr>
                <td height="15" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td class="table_rows" align="right" colspan="3" style="color:red;font-family:Tahoma;font-size:10px;">*&nbsp;required&nbsp;</td>
            </tr>
        </table>
        <table align="center" width="100%" border="0" cellpadding="0" cellspacing="3" class="buttons">
            <tr>
                <td width="30"><input type="image" name="submit" value="Next" align="middle"
                                      src="<?php echo $TIMECLOCK_URL; ?>/images/buttons/next_button.png"/></td>
                <td><a href="javascript:history.back();" class="nyroModalClose"><img
                            src="<?php echo $TIMECLOCK_URL; ?>/images/buttons/cancel_button.png" border="0"/></a></td>
            </tr>
        </table>
        <input type="hidden" name="empfullname" value="<?php echo $h_empfullname; ?>"/>
    </form>
</div>
