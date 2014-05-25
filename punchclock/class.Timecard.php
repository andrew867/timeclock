<?php
/**
 * Timecard object for an employee for one work week (or less).
 */

require_once 'config.inc.php';
require_once 'lib.common.php';

class Timecard {
    var $empfullname; // employee id of timecard
    var $begin_local_timestamp; // beginning of timecard week
    var $end_local_timestamp; // end of timecard week

    var $row; // current database row values
    var $next_row; // previous database row values

    var $in_or_out; // 1: in, 0: out
    var $start_time; // start time of individual time records
    var $end_time; // end time of individual time records
    var $hours; // regular hours of current record
    var $overtime; // overtime hours of current record

    var $today_hours; // number of hours worked today
    var $week_hours; // sum of regular hours
    var $overtime_hours; // sum of overtime hours
    var $total_hours; // total of regular hours and overtime hours

    function Timecard($empfullname, $begin_local_timestamp, $end_local_timestamp) {
        $this->empfullname = $empfullname;
        $this->begin_local_timestamp = $begin_local_timestamp;
        $this->end_local_timestamp = $end_local_timestamp;
    }

    function tally() {
        return $this->walk();
    }

    function walk($onBefore = null, $onEveryRow = null, $onAfter = null) {

        // Search employee time records and walk through them.
        // The beginning time $begin_local_timestamp, a local timestamp, must be set
        // to be the beginning of the week of interest. The sum of weekly hours and the
        // computation of overtime commences from the $this->begin_local_timestamp. The
        // $this->end_local_timestamp is for the end of the work week. It cannot span more than one
        // week otherwise the computation of overtime is wrong. Argument functions are used
        // to actually print (or process) the entries.

        // Returns a 4 element array of number of 1) rows processed, 2) the total work hours,
        // 3) total overtime hours, and 4) total hours worked today.

        // Configuration variables.
        global $show_display_name, $timefmt, $datefmt;
        global $overtime_week_limit, $timecard_list_punch_outs, $timecard_punchitem;

        // Initialize totals
        $this->week_hours = 0;
        $this->overtime_hours = 0;
        $this->today_hours = null; // not used unless week includes today

        // Set flag to tally today's hours if within current week.
        $local_timestamp = local_timestamp(); // current time
        if ($local_timestamp >= $this->begin_local_timestamp && $local_timestamp <= $this->end_local_timestamp) {
            // In current work week, set flag to look for and sum today's hours too.
            $do_today_hours = true;
            $today_date = date('Ymd', local_timestamp());
            $this->today_hours = 0;
        }

        // Initialize
        $row_count = 0;

        // Make SQL search parameters.
        $begin_utm_timestamp = utm_timestamp($this->begin_local_timestamp); // must be beginning of work week
        $end_utm_timestamp = utm_timestamp($this->end_local_timestamp); // can be any time within work week

        if ($this->begin_local_timestamp < $local_timestamp) {
            // Get previous record to timecard to see if employee is already signed in at beginning of the period.
            $result = mysql_query($this->_query_prev_record($begin_utm_timestamp))
            or trigger_error('Timecard->walk: no previous result: ' . mysql_error(), E_USER_WARNING);

            if ($result && mysql_num_rows($result) > 0) {
                $this->row = mysql_fetch_array($result);
                if ($this->row['in_or_out'] == 1) {
                    $row_count++;

                    // Initialize
                    $this->start_time = day_timestamp($this->begin_local_timestamp);;
                    $this->in_or_out = $this->row['in_or_out'];
                    $this->row['notes'] = "(cont.)"; // add note

                    // Trigger onBefore function.
                    if ($onBefore)
                        $onBefore($this);
                }
                mysql_free_result($result);
            }
        }

        // Get timecard entries.
        $query = $this->_query($begin_utm_timestamp, $end_utm_timestamp);
        $result = mysql_query($query)
        or trigger_error('Timecard->walk: no result: ' . mysql_error(), E_USER_WARNING);

        // Process timecard entries.
        while (($this->next_row = mysql_fetch_array($result))) {
            $row_count++;
            $this->end_time = local_timestamp($this->next_row['timestamp']); // normalize timestamp to local time
            if ($row_count == 1) {
                // Initialize
                $this->start_time = $this->end_time;
                $this->in_or_out = $this->next_row['in_or_out'];
                $this->row = $this->next_row;

                // Trigger onBefore function.
                if ($onBefore)
                    $onBefore($this);

                continue;
            }

            // Is employee punched in?
            if ($this->in_or_out == 1) {
                list ($this->hours, $this->overtime) = compute_work_hours($this->start_time, $this->end_time, $this->week_hours);
                if ($do_today_hours)
                    $this->today_hours += compute_day_hours($today_date, $this->start_time, $this->end_time);
                $this->week_hours += $this->hours;
                $this->overtime_hours += $this->overtime;
                $this->total_hours = $this->week_hours + $this->overtime_hours;
            }

            // Trigger onEveryRow function.
            if ($onEveryRow)
                $onEveryRow($this);

            // Re-initialize
            $this->start_time = $this->end_time;
            $this->in_or_out = $this->next_row['in_or_out'];
            $this->row = $this->next_row;
        }

        // Complete processing of the last time record.
        if ($row_count > 0) {
            $row_count++;

            if ($this->in_or_out == 1) {
                // Last record still has employee punched in.
                $this->end_time = $this->end_local_timestamp > $local_timestamp ? $local_timestamp : $this->end_local_timestamp;
                list ($this->hours, $this->overtime) = compute_work_hours($this->start_time, $this->end_time, $this->week_hours);
                if ($do_today_hours)
                    $this->today_hours += compute_day_hours($today_date, $this->start_time, $this->end_time);
                $this->week_hours += $this->hours;
                $this->overtime_hours += $this->overtime;
                $this->total_hours = $this->week_hours + $this->overtime_hours;

                // Add another record into timecard indicating pseudo punch-out at current time or end of week.

                // Trigger onEveryRow function.
                if ($onEveryRow)
                    $onEveryRow($this);

                // Re-initialize
                $this->start_time = $this->end_time;
                $this->in_or_out = 0;
                $this->row = $this->next_row;

                // Fill in pseudo row
                $this->row['in_or_out'] = $this->in_or_out;
                $this->row['color'] = '#333';
                $this->row['inout'] = $this->row['punchitems'] = $timecard_punchitem;
                $this->row['notes'] = ($this->end_time == $local_timestamp)
                    ? "(current time) " . $this->row['notes'] // add note
                    : "(end of period) " . $this->row['notes']; // add note
            }

            // Trigger onEveryRow function.
            if ($onEveryRow)
                $onEveryRow($this);

            // Trigger onAfter function.
            if ($onAfter)
                $onAfter($this);
        }

        mysql_free_result($result);

        return array($row_count, $this->total_hours, $this->overtime_hours, $this->today_hours);
    }

    // Private methods.
    function _query($begin_utm_timestamp, $end_utm_timestamp) {
        // Find records on an employee's timecard
        global $db_prefix, $default_in_or_out;
        $q_empfullname = mysql_real_escape_string($this->empfullname);

        return <<<End_Of_SQL
select	{$db_prefix}info.*,
	{$db_prefix}punchlist.punchitems,
	{$db_prefix}punchlist.color,
	coalesce({$db_prefix}punchlist.in_or_out,$default_in_or_out) as in_or_out,
	{$db_prefix}employees.displayname,
	{$db_prefix}employees.groups,
	{$db_prefix}employees.office
from {$db_prefix}info
left join {$db_prefix}punchlist on {$db_prefix}info.inout = {$db_prefix}punchlist.punchitems
left join {$db_prefix}employees on {$db_prefix}info.fullname = {$db_prefix}employees.empfullname
where {$db_prefix}info.fullname = '$q_empfullname'
  and {$db_prefix}info.timestamp >= $begin_utm_timestamp
  and {$db_prefix}info.timestamp <= $end_utm_timestamp
order by {$db_prefix}info.timestamp
End_Of_SQL;
    }

    function _query_prev_record($begin_utm_timestamp) {
        // Find previous record to those selelected for an employee's timecard
        global $db_prefix, $default_in_or_out;
        $q_empfullname = mysql_real_escape_string($this->empfullname);

        return <<<End_Of_SQL
select	{$db_prefix}info.*,
	{$db_prefix}punchlist.punchitems,
	{$db_prefix}punchlist.color,
	coalesce({$db_prefix}punchlist.in_or_out,$default_in_or_out) as in_or_out,
	{$db_prefix}employees.displayname,
	{$db_prefix}employees.groups,
	{$db_prefix}employees.office
from {$db_prefix}info
left join {$db_prefix}punchlist on {$db_prefix}info.inout = {$db_prefix}punchlist.punchitems
left join {$db_prefix}employees on {$db_prefix}info.fullname = {$db_prefix}employees.empfullname
where {$db_prefix}info.fullname = '$q_empfullname'
  and {$db_prefix}info.timestamp < $begin_utm_timestamp
order by {$db_prefix}info.timestamp desc
limit 1
End_Of_SQL;
    }
}

?>
