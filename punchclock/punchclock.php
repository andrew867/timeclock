<?php
/**
 * punchclock - timeclock for employees to punch in and out.
 *
 * This program displays a list of employees which they can click on for
 * a pop up form to punch them in or out.
 *
 * Derived from and intended to be used with timeclock.php v1.04
 */

$current_page = "punchclock.php";

require_once 'config.inc.php';
require_once 'lib.common.php';
require_once 'lib.select.php';
turn_off_magic_quotes();

# Uncomment next to force logout and always run punchclock without privileges 
#session_stop();

session_start();
$_SESSION['application'] = $current_page; // security

include 'setup_timeclock.php'; // authorize and initialize like timeclock.php

$PAGE_TITLE = "Punchclock - $title";

// Program options.
if (isset($_REQUEST['office'])) {
    $office = $_REQUEST['office'];
    $h_office = htmlentities($office);
    $q_office = mysql_real_escape_string($office);
    $u_office = rawurlencode($office);

    $display_office = $office ? $office : 'all'; // override config option
    $PAGE_TITLE = "Punchclock - $h_office - $title"; // browser window title
}

if (isset($_REQUEST['group'])) {
    $group = $_REQUEST['group'];
    $h_group = htmlentities($group);
    $q_group = mysql_real_escape_string($group);
    $u_group = rawurlencode($group);

    $display_group = $group ? $group : 'all'; // override config option
}

if ($punchclock_select_offices == "yes") {
    $select_options = select_options("SELECT officename FROM {$db_prefix}offices ORDER BY officename", $office);
    $select_offices = <<<End_Of_HTML
<select id="select_offices" onchange="location.href='?office='+encodeURIComponent(this.value)+'&amp;group='">
<option value="">-- All Offices --</option>
$select_options
</select>

End_Of_HTML;
}

if ($punchclock_select_groups == "yes") {
    $sql = $office
        ? "select groupname from {$db_prefix}groups"
          . " join {$db_prefix}offices on {$db_prefix}groups.officeid = {$db_prefix}offices.officeid"
          . " where {$db_prefix}offices.officename = '$q_office'"
          . " order by groupname"
        : "SELECT groupname FROM {$db_prefix}groups ORDER BY groupname";
    $select_options = select_options($sql, $group);
    $select_groups = <<<End_Of_HTML
<select id="select_groups" onchange="location.href='?office=$u_office&amp;group='+encodeURIComponent(this.value)">
<option value="">-- All Groups --</option>
$select_options
</select>

End_Of_HTML;
}

$office_title = ($punchclock_select_offices != "yes" && $office != 'all') ? "<h2 id=\"office\">$h_office</h2>" : '';

$PAGE_STYLE = <<<End_Of_HTML
<link rel="stylesheet" type="text/css" media="screen" href="css/nyroModal.css" />
<style type="text/css">
media print {
	.emp_list tbody { height:auto; color:#222; }
}
</style>
End_Of_HTML;
if ($punchclock_refresh != "none")
    $punchclock_refresh_script = "display.schedule_refresh($punchclock_refresh);";
$PAGE_SCRIPT = <<<End_Of_HTML
<script type="text/javascript" src="scripts/jquery.scrollTo-1.3.3-min.js"></script>
<script type="text/javascript" src="scripts/jquery.nyroModal-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/punchclock.js"></script>
<script type="text/javascript">
//<![CDATA[
$(function(){
	// Add click handlers to table rows.
	$('.display_row').click(function(e){
		e.preventDefault();
		display.lock();			// prevent refresh while entry forms are open
		keyboard.unbind_handler();	// no scrolling while entry forms are open
		var id = this.id.replace(/^emp_/,'').replace(/_/g,' ');	// remove emp_ prefix and change _ to spaces
		$.nyroModalManual({
			url:'entry.ajax.php?emp='+encodeURIComponent(id),
			minHeight:250,
			endFillContent:function(){setTimeout(function(){ $('form input:first').focus(); },500);}
		});
		return false;
	}).attr({title:'Click to punch in or punch out.'});

	// Resize window, make tbody of table scrollable. Only works in FF now.
	if ($.browser.mozilla) {
		var orig_tbody_height = $('.emp_list tbody').height();

		var page_border_width = 1;			// assume for now
		var page_top_offset = $('.page').offset().top + page_border_width;;
		var page_bottom_offset = page_top_offset;	// assume same as top

		var tbody_top_offset = $('.emp_list tbody tr:first').offset().top;
		var tbody_bottom_offset = $('.footer').height() + page_bottom_offset;

		var resize_page = function(){
			var compute_tbody_height = $(window).height() - tbody_top_offset - tbody_bottom_offset;
			if (compute_tbody_height < orig_tbody_height) {
				$('.emp_list tbody').height(compute_tbody_height);
			} else {
				$('.emp_list tbody').css({height:'auto'});
			}
		};
		$(window).unbind('resize');
		$(window).resize(resize_page).resize();

		// Setup keyboard handler to scroll to name beginning with the key press.
		keyboard.set_scroll_body_height(orig_tbody_height);
		keyboard.bind_handler();
	}

	// Setup nyroModal event to unlock display so it can be synchronized after popup forms are complete.
	$.fn.nyroModal.settings.endRemove = function() { display.unlock(); if ($.browser.mozilla) keyboard.bind_handler(); }

	// Show and hide "synchronizing" message.
	setTimeout(function(){ $('#message').css({visibility:'hidden'}); }, 1000);

	$punchclock_refresh_script
});
//]]>
</script>
End_Of_HTML;
$PAGE_CONTENT_HEADER = "$office_title$select_offices$select_groups";

include 'header.php';
print "<div id=\"message\">Synchronizing, Please Wait...</div>\n";
include 'time.php';
include 'punchclock_display.php';
include 'footer.php';
?>
