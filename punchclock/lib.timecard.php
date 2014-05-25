<?php
/**
 * Timecard functions.
 */

require_once 'config.inc.php';
require_once 'lib.common.php';
require_once 'class.Timecard.php';

////////////////////////////////////////
function current_week_hours($empfullname) {
    global $one_week;
    $begin_local_timestamp = work_week_begin();
    $end_local_timestamp = $begin_local_timestamp + $one_week;
    $tc = new Timecard($empfullname, $begin_local_timestamp, $end_local_timestamp);
    list($row_count, $total_hours, $overtime_hours, $today_hours) = $tc->tally();

    return array($today_hours, $total_hours, $overtime_hours);
}

////////////////////////////////////////
function timecard_html($empfullname, $local_timestamp_in_week) {
    // Return html of employee's timecard.
    global $show_display_name, $one_week;

    // SQL search parameters for one work week.
    $begin_local_timestamp = work_week_begin($local_timestamp_in_week);
    $end_local_timestamp = $begin_local_timestamp + $one_week;

    // Define helper functions for printing timecard header, footer, and for printing every row.
    function print_header($tc) {
        // Print timecard html header.
        global $overtime_week_limit, $timecard_display_running_total;

        $overtime_col = $overtime_week_limit > 0 ? "\n    <th align=\"center\" class=\"ovt\" title=\"Overtime hours\">OT</th>" : '';
        $total_col = $timecard_display_running_total == "yes" ? "\n    <th align=\"center\" class=\"total\" title=\"Running total of regular work hours and overtime to date.\">Total</th>" : '';
        print <<<End_Of_HTML

<table class="misc_items timecard_list" border="0" cellpadding="2" cellspacing="0" style="margin:0 auto;">
  <thead>
  <tr>
    <th align="left">In/Out</th>
    <th align="center">Time</th>
    <th align="center">Date</th>
    <th align="center" class="hrs" title="Regular work hours.">Hrs</th>$overtime_col$total_col
    <th align="left" class="notes">Notes</th>
  </tr>
  </thead>
  <tbody>
End_Of_HTML;
    }

    function print_row($tc) {
        // Configuration variables.
        global $timefmt, $datefmt;
        global $overtime_week_limit, $timecard_list_punch_outs, $timecard_display_hours_minutes;
        global $timecard_hours_include_overtime, $timecard_display_running_total;
        static $print_count = 0;

        if (($tc->in_or_out == 1) || $timecard_list_punch_outs == 'yes') {
            $h_color = htmlentities($tc->row['color']);
            $h_inout = htmlentities($tc->row['inout']);

            $h_time = date($timefmt, $tc->start_time);
            $h_date = date($datefmt, $tc->start_time);

            if ($timecard_display_hours_minutes == "yes") {
                $h_hours = hrs_min((($timecard_hours_include_overtime == "yes") ? ($tc->hours + $tc->overtime) : $tc->hours));
                $h_overtime = hrs_min($tc->overtime);
                $h_total = hrs_min(($tc->week_hours + $tc->overtime_hours));
            } else {
                $h_hours = sprintf("%01.02f", (($timecard_hours_include_overtime == "yes") ? ($tc->hours + $tc->overtime) : $tc->hours));
                $h_overtime = sprintf("%01.02f", $tc->overtime);
                $h_total = sprintf("%01.02f", ($tc->week_hours + $tc->overtime_hours));
            }

            $h_notes = htmlentities($tc->row['notes']);

            if ($tc->in_or_out != 1) {
                // Don't display hours on "out" records.
                $h_hours = $h_overtime = $h_total = '';
            }

            $row_class = (++$print_count % 2) ? 'odd' : 'even';
            $overtime_col = $overtime_week_limit > 0 ? "\n    <td align=\"right\" class=\"ovt\">$h_overtime</td>" : '';
            $total_col = $timecard_display_running_total == "yes" ? "\n    <td align=\"right\" class=\"total\">$h_total</td>" : '';
            print <<<End_Of_HTML

  <tr class="display_row $row_class">
    <td align="left" style="color:$h_color">$h_inout</td>
    <td align="right">$h_time</td>
    <td align="right">$h_date</td>
    <td align="right" class="hrs">$h_hours</td>$overtime_col$total_col
    <td align="left" class="notes">$h_notes</td>
  </tr>
End_Of_HTML;
        }
    }

    function print_footer($tc) {
        global $timecard_display_running_total, $timecard_hours_include_overtime;
        global $timecard_display_hours_minutes, $overtime_week_limit;

        // Set flag to print paragraph of totals if they're not already obvious.
        $print_totals = ($timecard_display_running_total == "yes" || $timecard_hours_include_overtime != "yes") ? true : false;

        $h_total_hours = sprintf("%01.02f", ($tc->week_hours + $tc->overtime_hours));
        $h_totals = ($print_totals) ? "\n<p>Total for week: " . hrs_min($tc->week_hours + $tc->overtime_hours) . " ($h_total_hours hours)</p>" : '';

        $h_ovt_total_hours = sprintf("%01.02f", $tc->overtime_hours);
        $h_overtime_totals = ($print_totals && $tc->overtime_hours > 0) ? "\n<p>Total overtime: " . hrs_min($tc->overtime_hours) . " ($h_ovt_total_hours hours)</p>" : '';

        $h_day_total_hours = sprintf("%01.02f", $tc->today_hours);
        $h_today_hours = ($tc->today_hours !== null) ? "<p>Total today: " . hrs_min($tc->today_hours) . " ($h_day_total_hours hours)</p>" : '';

        if ($timecard_display_running_total != "yes") {
            // Print row of totals
            $total_hours = $timecard_hours_include_overtime == "yes" ? ($tc->week_hours + $tc->overtime_hours) : $tc->week_hours;
            $h_hours = $timecard_display_hours_minutes == "yes" ? hrs_min($total_hours) : $h_total_hours;
            $overtime_col = $overtime_week_limit > 0 ? "\n    <td align=\"right\" class=\"ovt\">" . ($timecard_display_hours_minutes == "yes" ? hrs_min($tc->overtime_hours) : $h_ovt_total_hours) . "</td>" : '';
            $total_col = $timecard_display_running_total == "yes" ? "\n    <td align=\"right\" class=\"total\">" . ($timecard_display_hours_minutes == "yes" ? hrs_min($tc->week_hours + $tc->overtime_hours) : $h_total_hours) . "</td>" : '';
            print <<<End_Of_HTML
  <tr class="total_row">
    <td align="left"></td>
    <td align="right"></td>
    <td align="right"></td>
    <td align="right" class="hrs">$h_hours</td>$overtime_col$total_col
    <td align="left" class="notes"></td>
  </tr>
End_Of_HTML;
        }

        print <<<End_Of_HTML
  </tbody>
</table>
End_Of_HTML;
        if ($timecard_display_running_total == "yes" || $timecard_hours_include_overtime != "yes" || $h_today_hours) {
            // Add totals text if totals are not already displayed or if summing the hours column is confusing.
            print <<<End_Of_HTML

<div class="totals">
$h_today_hours$h_totals$h_overtime_totals
</div>

End_Of_HTML;
        }
    }

    // End of helper function definitions.

    // Print timecard page header.
    $h_name_header = htmlentities(($show_display_name == 'yes' ? get_employee_name($empfullname) : $empfullname));
    $begin_date = date('l F j, Y', $begin_local_timestamp);
    print <<<End_Of_HTML

<div class="timecard">
<h2>Timecard</h2>
<h3>$h_name_header</h3>
<h4>Week beginning $begin_date</h4>
End_Of_HTML;

    // Print timecard.
    $tc = new Timecard($empfullname, $begin_local_timestamp, $end_local_timestamp);
    list($row_count, $total_hours, $overtime_hours, $today_hours) = $tc->walk(print_header, print_row, print_footer);
    if ($row_count <= 0)
        print error_msg("No records were found.");

    // Print timecard page footer.
    print <<<End_Of_HTML
</div> <!-- timecard -->

End_Of_HTML;
}

?>
