<?php
/**
 * Export timeclock hours.
 */

$current_page = "export.php";

require_once 'config.inc.php';
require_once 'lib.common.php';
require_once 'lib.select.php';
turn_off_magic_quotes();

session_start();
$_SESSION['application'] = $current_page; // security

////////////////////////////////////////
// Authorize
if ($use_reports_password == "yes") {
    if (!isset($_SESSION['valid_reports_user']) && !isset($_SESSION['valid_user'])) {
        include 'setup_timeclock.php'; // authorize and initialize like timeclock.php
        $PAGE_TITLE = "Export - $title";
        include 'header.php';
        print <<<End_Of_HTML
<table width=100% border=0 cellpadding=7 cellspacing=1 style="margin-top:12px;">
  <tr class=right_main_text><td height=10 align=center valign=top scope=row class=title_underline>PHP Timeclock Reports</td></tr>
  <tr class=right_main_text>
    <td align=center valign=top scope=row>
      <table width=200 border=0 cellpadding=5 cellspacing=0>
        <tr class=right_main_text><td align=center>You are not presently logged in, or do not have permission to view this page.</td></tr>
        <tr class=right_main_text><td align=center>Click <a class=admin_headings href='$TIMECLOCK_URL/login_reports.php'><u>here</u></a> to login.</td></tr>
      </table><br />
    </td>
  </tr>
</table>
End_Of_HTML;
        include "footer.php";
        exit;
    }
}

////////////////////////////////////////
// Get report parameters

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Report parameters entry
    setcookie('dragtable-export_table', '', time() - 3600, $_SERVER['PHP_SELF']); // delete cookie, put columns in default order

    $PAGE_TITLE = "Export - $title";
    include "header_reports.php";
    include "header_timeclock.php";

    print <<<End_Of_HTML

<table width="100%" height="85%" border="0" cellpadding="0" cellspacing="1" style="border:solid #BBB 1px;">
  <tr valign="top">
    <td>
      <table width="100%" border="0" cellpadding="10" cellspacing="1" style="margin-top:12px;">
        <tr class="right_main_text">
          <td valign="top">
            <form name="form" action="{$_SERVER['PHP_SELF']}" method="post" onsubmit="return isFromOrToDate();">
            <input type="hidden" name="date_format" value="$js_datefmt" />
            <table align="center" class="table_border" width="60%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <th class="rightside_heading" nowrap halign="left" colspan="3"><img src="$TIMECLOCK_URL/images/icons/report.png" />&nbsp;&nbsp;&nbsp; Export Hours Worked</th>
              </tr>
              <tr><td height="15"></td></tr>
End_Of_HTML;

    if ($username_dropdown_only == "yes") {
        $select_options = select_options("SELECT empfullname,displayname FROM {$db_prefix}employees ORDER BY displayname ASC");
        print <<<End_Of_HTML

              <tr><td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Username:</td>
                  <td colspan="2" align="left" width="80%" style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                 <select name='user_name'>
<option value ='All'>All</option>
$select_options
                 </select>&nbsp;*</td>
              </tr>
End_Of_HTML;
    } else {
        print <<<End_Of_HTML

              <tr>
                <td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Choose Office:</td>
                <td colspan="2" width="80%" style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                  <select name="office_name" onchange="group_names();"></select>
                </td>
              </tr>
              <tr>
                <td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Choose Group:</td>
                <td colspan="2" width="80%" style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                  <select name="group_name" onchange="user_names();"></select>
                </td>
              </tr>
              <tr>
                <td class="table_rows" height="25" width="20%" style="padding-left:32px;" nowrap>Choose Username:</td>
                <td colspan="2" width="80%" style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                  <select name="user_name"></select>
                </td>
              </tr>
End_Of_HTML;
    }

    print <<<End_Of_HTML

              <tr>
                <td class="table_rows" width="20%" nowrap style="padding-left:32px;">From Date: ($tmp_datefmt)</td>
                <td width=80% style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                  <input type="text" size="10" maxlength="10" name="from_date" style="color:#27408b" />&nbsp;*&nbsp;&nbsp;
                  <a href="#" name="from_date_anchor" id="from_date_anchor" onclick="form.from_date.value='';cal.select(document.forms['form'].from_date,'from_date_anchor','$js_datefmt');return false;" style="font-size:11px;color:#27408b;">Pick Date</a>
                </td>
              <tr>
              <tr>
                <td class="table_rows" width=20% nowrap style="padding-left:32px;">To Date: ($tmp_datefmt)</td>
                <td width="80%" style="color:red;font-family:Tahoma;font-size:10px;padding-left:20px;">
                  <input type="text" size="10" maxlength="10" name="to_date" style="color:#27408b" />&nbsp;*&nbsp;&nbsp;
                  <a href="#" onclick="form.to_date.value='';cal.select(document.forms['form'].to_date,'to_date_anchor','$js_datefmt');return false;" name="to_date_anchor" id="to_date_anchor" style="font-size:11px;color:#27408b;">Pick Date</a>
                </td>
              <tr>
              <tr>
                <td class="table_rows" align="right" colspan="3" style="color:red;font-family:Tahoma;font-size:10px;">*&nbsp;required&nbsp;</td>
              </tr>
            </table>

End_Of_HTML;

    // Report options entry
    print <<<End_Of_HTML

            <div style="position:absolute;visibility:hidden;background-color:#ffffff;layer-background-color:#ffffff;" id="mydiv" height=200>&nbsp;</div>

            <table align="center" width="60%" border="0" cellpadding="0" cellspacing="3">

End_Of_HTML;

    // Column option checkboxes
    print <<<End_Of_HTML
              <tr>
                <td class="table_rows" height="25" valign="bottom">1.&nbsp;&nbsp;&nbsp;Select the table columns that are to be exported.</td>
              </tr>
              <tr>
                <td class="table_rows" align="left" nowrap style="padding-left:15px;">
                  <label title="Column identifies hours as regular or overtime."><input type="checkbox" name="c_reg_ot" value="1" checked="checked" /> Regular/Overtime</label>
                  <label title="In/Out status or task code."><input type="checkbox" name="c_inout" value="1" /> Task/Status</label>
                  <label title="Date hours were worked."><input type="checkbox" name="c_date" value="1" checked="checked" /> Date</label>
                  <label title="Employee name or ID."><input type="checkbox" name="c_employee" value="1" checked="checked" /> Employee</label>
                  <label title="Employee name"><input type="checkbox" name="c_name" value="1" /> Name</label>
                  <label title="Employee's group."><input type="checkbox" name="c_group" value="1" checked="checked" /> Group</label>
                  <label title="Employee's office or location."><input type="checkbox" name="c_office" value="1" checked="checked" /> Office</label>
                </td>
              </tr>

End_Of_HTML;

    // Next/Cancel buttons
    print <<<End_Of_HTML
              <tr><td height="10"></td></tr>
            </table>

            <table align="center" width="60%" border="0" cellpadding="0" cellspacing="3">
              <tr>
                <td width="30"><input type="image" name="submit" value="Next" align="middle" src="$TIMECLOCK_URL/images/buttons/next_button.png" /></td>
                <td><a href="index.php"><img src="$TIMECLOCK_URL/images/buttons/cancel_button.png" border="0" /></a></td>
              </tr>
            </table>
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

End_Of_HTML;

    include "footer_timeclock.php";

    print <<<End_Of_HTML
</body>
</html>
End_Of_HTML;
    exit;

}

////////////////////////////////////////
// Generate report

include 'setup_timeclock.php'; // authorize and initialize like timeclock.php

// Program parameters.
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : null;
$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : null;
$date_fmt = isset($_POST['date_fmt']) ? $_POST['date_fmt'] : null;
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
$group_name = isset($_POST['group_name']) ? $_POST['group_name'] : null;
$office_name = isset($_POST['office_name']) ? $_POST['office_name'] : null;

// Program options.
$c_reg_ot = bool($_POST['c_reg_ot']);
$c_inout = bool($_POST['c_inout']);
$c_date = bool($_POST['c_date']);
$c_employee = bool($_POST['c_employee']);
$c_name = bool($_POST['c_name']);
$c_group = bool($_POST['c_group']);
$c_office = bool($_POST['c_office']);

////////////////////////////////////////
$PAGE_TITLE = "Export - $title";
$PAGE_STYLE = <<<End_Of_HTML
<style type="text/css">
@media print {
	.page { background-color:#FFF; border:0; }
	.topmain_row_color { display:none; }
	.options { display:none; }
	.buttons, .select-buttons { display:none; }
	.misc_items { color:#222; }
}
</style>
End_Of_HTML;
$PAGE_SCRIPT = <<<End_Of_HTML
<script type="text/javascript" src="scripts/textrange.js"></script>
<script type="text/javascript" src="scripts/sorttable.js"></script>
<script type="text/javascript" src="scripts/dragtable.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
	$('.export_items thead th').click(function(){
		// redo alternate row shading
		$('.export_items tbody tr').each(function(index){
			$(this).removeClass('even odd').addClass( (index % 2 ? 'even' : 'odd') );
		});
	}).attr({title:"Click to sort table, drag to rearrange columns."});
});
//]]>
</script>
End_Of_HTML;

include 'header.php';
include 'export_display.php';
include 'footer.php';
?>
