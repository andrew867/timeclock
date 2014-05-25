<?php
/**
 * Current employee punch-in/out status for entry.php
 */

if (!isset($_SESSION['application'])) {
    header('Location:entry.php');
    exit;
}

require_once 'config.inc.php';
require_once 'lib.common.php';

// Configuration variables.
global $timefmt, $datefmt, $timecard_display_hours_minutes;

// Get status
list($in_or_out, $color, $inout, $timestamp, $notes) = get_employee_status($empfullname);

// Compute hours
$punch_time = local_timestamp($timestamp);
$hours = compute_hours($punch_time, local_timestamp());

$h_color = htmlentities($color);
$h_inout = htmlentities($inout);

$h_time = date($timefmt, $punch_time);
$h_date = date($datefmt, $punch_time);

if ($in_or_out == 1) {
    if ($timecard_display_hours_minutes == "yes") {
        $h_hours = hrs_min($hours);
    } else {
        $h_hours = sprintf("%01.02f", $hours);
    }
} else {
    $h_hours = '';
}

$h_notes = htmlentities($notes);
?>
<table class="misc_items timecard_list" border="0" cellpadding="2" cellspacing="0" style="margin:0 auto;">
    <thead>
    <tr>
        <th align="left">In/Out</th>
        <th align="center">Time</th>
        <th align="center">Date</th>
        <th align="center" class="hrs" title="Regular work hours.">Hrs</th>
        <th align="left" class="notes">Note</th>
    </tr>
    </thead>
    <tbody>
    <tr class="display_row">
        <td align="left" style="color:<?php echo $h_color; ?>"><?php echo $h_inout; ?></td>
        <td align="right"><?php echo $h_time; ?></td>
        <td align="right"><?php echo $h_date; ?></td>
        <td align="right" class="hrs"><?php echo $h_hours; ?></td>
        <td align="left" class="notes"><?php echo $h_notes; ?></td>
    </tr>
    </tbody>
</table>
