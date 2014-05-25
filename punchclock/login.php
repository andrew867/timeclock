<?php
/**
 * Login employee
 */

$current_page = "login.php";

require_once 'config.inc.php';
require_once 'lib.common.php';
turn_off_magic_quotes();

// Check for logout
if (isset($_REQUEST['logout'])) {
    session_stop();
    unset($_GET['emp']); // safety
    unset($_REQUEST['empfullname']); // safety
    // Fall through and display login form.
}

session_start();
$_SESSION['application'] = $current_page; // security

$return_url = isset($_SESSION['login_return_url']) ? $_SESSION['login_return_url'] : '/';
$msg = isset($_SESSION['login_msg']) ? $_SESSION['login_msg'] : '';
$error_msg = isset($_SESSION['login_error_msg']) ? $_SESSION['login_error_msg'] : '';
unset($_SESSION['login_msg']); // reinitialize
unset($_SESSION['login_error_msg']); // reinitialize

include 'setup_timeclock.php'; // authorize and initialize

// Parse arguments.
$emp = isset($_REQUEST['emp']) ? $_REQUEST['emp'] : null;
$empfullname = isset($_REQUEST['empfullname']) ? $_REQUEST['empfullname'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

if (!$empfullname)
    $empfullname = $emp; // from url or form entry

if ($empfullname) {
    $empfullname = lookup_employee($empfullname);
    if (!$empfullname) {
        $error_msg .= "Name was not recognized. Please re-enter your name.\n";
    }
}

////////////////////////////////////////
if (!$empfullname) {
    unset($_SESSION['authenticated']);

    // Get employee name

    $PAGE_TITLE = "Login - $title";
    $PAGE_STYLE = <<<End_Of_HTML
<link rel="stylesheet" type="text/css" media="screen" href="css/jquery.suggest.css" />
End_Of_HTML;

    $PAGE_SCRIPT = <<<End_Of_HTML
<script type="text/javascript" src="scripts/jquery.suggest.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
	$('#emp').suggest('suggest.ajax.php');
	$('form input:first').focus();
});
//]]>
</script>
End_Of_HTML;

    include 'header.php';
    if ($msg)
        print msg($msg);
    if ($error_msg)
        print error_msg($error_msg);
    print <<<End_Of_HTML

<div id="employee_entry_form">
<form action="{$_SERVER['PHP_SELF']}" method="get">
<table align="center" class="table_border" width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
	<th class="rightside_heading" nowrap align="left" colspan="3"><img src="$TIMECLOCK_URL/images/icons/clock_add.png" />&nbsp;&nbsp;&nbsp;Enter your name
	</th>
  </tr>
  <tr><td height="15" colspan="3"></td></tr>
  <tr><td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Employee Name:</td>
      <td colspan="2" width="80%" style="color:red;font-family:Tahoma;font-size:10px;">
	  <input type="text" size="25" maxlength="50" name="emp" id="emp" value="" />&nbsp;*</td></tr>
  <tr><td height="15" colspan="3">&nbsp;</td></tr>
  <tr><td class="table_rows" align="right" colspan="3" style="color:red;font-family:Tahoma;font-size:10px;">*&nbsp;required&nbsp;</td></tr>
</table>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="3" class="buttons">
  <tr><td width="30"><input type="image" name="submit" value="Next" align="middle" src="$TIMECLOCK_URL/images/buttons/next_button.png" /></td>
      <td><a href="index.php"><img src="$TIMECLOCK_URL/images/buttons/cancel_button.png" border="0" /></a></td></tr>
</table>
</form>
</div>

End_Of_HTML;

    include 'footer.php';
    exit;
}

////////////////////////////////////////
if ($use_passwd == 'yes') {
    $authenticated = isset($_SESSION['authenticated']) ? ($_SESSION['authenticated'] == $empfullname) : false;

    if ((!$authenticated) && (isset($_SESSION['time_admin_valid_user']) || isset($_SESSION['valid_user']))) {
        // Allow time administrators and system administrators to bypass the password screen.
        $_SESSION['authenticated'] = $empfullname;
        $authenticated = true;
    }

    if (!$authenticated && $password) {

        // Validate password
        if (is_valid_password($empfullname, $password)) {
            $_SESSION['authenticated'] = $empfullname;
            $authenticated = true;
        } else {
            $error_msg .= "Password is incorrect. Please try again.\n";
        }
    }

    if (!$authenticated) {
        $u_empfullname = rawurlencode($empfullname);
        $h_empfullname = htmlentities($empfullname);
        $h_name_header = $show_display_name == 'yes' ? htmlentities(get_employee_name($empfullname)) : $h_empfullname;

        // Security: make sure no one is already authenticated before displaying password screen.
        unset($_SESSION['authenticated']);

        // Authenticate employee
        $PAGE_TITLE = "Login - $title";
        $PAGE_SCRIPT = <<<End_Of_HTML
<script type="text/javascript">$(function(){ $('form input:first').focus(); });</script>
End_Of_HTML;
        include 'header.php';
        if ($msg)
            print msg($msg);
        if ($error_msg)
            print error_msg($error_msg);
        print <<<End_Of_HTML
<div id="password_entry_form">
<form action="{$_SERVER['PHP_SELF']}" method="post">
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
	<a href="password.php?forgot_password&emp=$u_empfullname">Forgot your password</a>
        &nbsp;&nbsp;
	<a href="password.php?emp=$u_empfullname">Change your password</a></td></tr>
  <tr><td height=15 colspan="3">&nbsp;</td></tr>
  <tr><td class=table_rows align=right colspan=3 style='color:red;font-family:Tahoma;font-size:10px;'>*&nbsp;required&nbsp;</td></tr>
</table>
<table align=center width=100% border=0 cellpadding=0 cellspacing=3 class="buttons">
  <tr><td width=30><input type='image' name='submit' value='Next' align='middle' src='$TIMECLOCK_URL/images/buttons/next_button.png' /></td>
      <td><a href='?emp='><img src='$TIMECLOCK_URL/images/buttons/cancel_button.png' border='0' /></a></td></tr>
</table>
<input type="hidden" name="empfullname" value="$h_empfullname" />
</form>
</div>
End_Of_HTML;
        include 'footer.php';
        exit;
    }
}

////////////////////////////////////////
// Successful login
$_SESSION['authenticated'] = $empfullname;
$return_url = preg_replace('/\bemp(fullname)?=.*?&(.*)$/', '$2', $return_url); // remove possible emp= from url
$return_url .= (preg_match('/[?]/', $return_url) ? '&' : '?') . "emp=" . rawurlencode($empfullname); // add emp= argument to url
exit_next($return_url);
?>
