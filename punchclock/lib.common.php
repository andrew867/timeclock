<?php
/**
 * Punchclock functions.
 */

require_once 'config.inc.php';

////////////////////////////////////////
function make_id($empfullname) {
    // Make an DOM ID string from the employee id
    // Add emp_ prefix and change spaces into underlines.
    return 'emp_' . preg_replace('/ /', '_', $empfullname);
}

function unmake_id($id) {
    return preg_replace('/_/', ' ', preg_replace('/^emp_/', '', $id));
}


////////////////////////////////////////
function lookup_employee($empfullname) {
    // Return valid empfullname or null
    global $db_prefix;
    $name = null;
    $q_empfullname = mysql_real_escape_string($empfullname);
    $result = mysql_query("SELECT empfullname FROM {$db_prefix}employees WHERE empfullname = '$q_empfullname'");
    if (!$result || mysql_num_rows($result) == 0) {
        // Check if displayname was entered.
        $q_empfullname = mysql_real_escape_string(strtolower($empfullname));
        $result = mysql_query("SELECT empfullname FROM {$db_prefix}employees WHERE lower(displayname) = '$q_empfullname'")
        or trigger_error('lookup_employee: no result: ' . mysql_error(), E_USER_WARNING);
    }
    if ($result && mysql_num_rows($result) == 1) {
        $name = mysql_result($result, 0, 0);
    }
    if ($result)
        mysql_free_result($result);

    return $name;
}

////////////////////////////////////////
function get_employee_name($empfullname) {
    global $db_prefix;
    $q_empfullname = mysql_real_escape_string($empfullname);
    $result = mysql_query("SELECT displayname FROM {$db_prefix}employees WHERE empfullname = '$q_empfullname'");
    if (!$result) {
        trigger_error('get_employee_name: no result: ' . mysql_error(), E_USER_WARNING);

        return false;
    }
    $name = mysql_result($result, 0, 0);
    mysql_free_result($result);

    return $name;
}

////////////////////////////////////////
function get_employee_password($empfullname) {
    global $db_prefix;
    $q_empfullname = mysql_real_escape_string($empfullname);
    $result = mysql_query("SELECT employee_passwd FROM {$db_prefix}employees WHERE empfullname = '$q_empfullname'");
    if (!$result) {
        trigger_error('get_employee_password: no result: ' . mysql_error(), E_USER_WARNING);

        return false;
    }
    $password = mysql_result($result, 0, 0);
    mysql_free_result($result);

    return $password;
}

////////////////////////////////////////
function is_valid_password($empfullname, $password) {
    global $use_passwd;
    $employee_passwd = get_employee_password($empfullname);
    if ($use_passwd) {
        $password = crypt($password, 'xy');
    }

    return ($password == $employee_passwd);
}

////////////////////////////////////////
function save_employee_password($empfullname, $new_password) {
    global $db_prefix;
    $password = crypt($new_password, 'xy');
    $q_empfullname = mysql_real_escape_string($empfullname);
    $q_password = mysql_real_escape_string($password);
    $result = mysql_query("UPDATE {$db_prefix}employees SET employee_passwd = '$q_password' WHERE empfullname = '$q_empfullname'");
    if (!$result) {
        trigger_error('save_employee_password: cannot save new password: ' . mysql_error(), E_USER_WARNING);

        return false;
    }
    mysql_free_result($result);

    return true;
}

////////////////////////////////////////
function get_employee_status($empfullname) {
    // Get employee's current punch-in/out status and time.
    // Return array of in/out(1/0), punch code, timestamp, and notes.
    global $db_prefix;
    $q_empfullname = mysql_real_escape_string($empfullname);
    $query = <<<End_Of_SQL
select {$db_prefix}employees.*, {$db_prefix}info.*, {$db_prefix}punchlist.*
  from {$db_prefix}employees
  left join {$db_prefix}info on {$db_prefix}info.fullname = {$db_prefix}employees.empfullname
        and {$db_prefix}info.timestamp = {$db_prefix}employees.tstamp
  left join {$db_prefix}punchlist on {$db_prefix}punchlist.punchitems = {$db_prefix}info.`inout`
 where {$db_prefix}employees.disabled <> '1'
   and employees.empfullname = '$q_empfullname'
End_Of_SQL;
    $result = mysql_query($query);
    if (!$result) {
        trigger_error('get_employee_status: no result: ' . mysql_error(), E_USER_WARNING);

        return false;
    }
    $row = mysql_fetch_assoc($result);
    mysql_free_result($result);

    return array($row['in_or_out'], $row['color'], $row['inout'], $row['timestamp'], $row['notes']);
}

////////////////////////////////////////
function compute_work_hours($start_time, $end_time, $week_hours) {
    // Compute work and overtime hours between two times.
    $hours = compute_hours($start_time, $end_time);
    $overtime = compute_overtime_hours($hours, $week_hours);
    $hours -= $overtime;

    return array($hours, $overtime);
}

function compute_hours($start_time, $end_time) {
    // Compute number of hours between start and end time.
    $start_time -= $start_time % 60; // round down to full minute
    $end_time -= $end_time % 60; // round down to full minute
    return ((($end_time - $start_time) / 60) / 60);
}

function compute_overtime_hours($hours, $week_hours) {
    // Compute the amount of overtime for $hours. The $week_hours is the current
    // sum of hours worked in the week (before including $hours in its total).
    global $overtime_week_limit;
    if (($overtime_week_limit > 0) && (($week_hours + $hours) > $overtime_week_limit)) {
        $overlimit = ($week_hours + $hours) - $overtime_week_limit;

        return $overlimit < $hours ? $overlimit : $hours;
    }

    return 0;
}

function compute_day_hours($date, $start_time, $end_time) {
    // Compute number of hours that fall within the given date.
    global $one_day;
    $start_date = date('Ymd', $start_time);
    $end_date = date('Ymd', $end_time);
    if ($start_date == $date && $end_date == $date) {
        return compute_hours($start_time, $end_time);
    }
    if ($start_date == $date) {
        $end_time = day_timestamp($start_time + $one_day) - 1;

        return compute_hours($start_time, $end_time);
    }
    if ($end_date == $date) {
        $start_time = day_timestamp($end_time);

        return compute_hours($start_time, $end_time);
    }

    return 0;
}

function hrs_min($hours) {
    // Return string of hours:minutes from given decimal hours.
    // Round minutes slightly to accommodate numbers like 25.99999998
    return sprintf("%02d:%02d", floor($hours), floor((($hours - floor($hours)) * 60) + .1));
}

////////////////////////////////////////
function work_week_begin($local_timestamp = null) {
    // Return local timestamp of the beginning of the work week.
    global $begin_week_day, $one_day;
    if ($local_timestamp == null)
        $local_timestamp = time() - server_timezone_offset() + timezone_offset();
    $local_daystamp = day_timestamp($local_timestamp);
    $local_day_of_week = date('w', $local_daystamp);
    $ndays = $local_day_of_week - $begin_week_day;
    if ($ndays < 0)
        $ndays += 7;

    return $local_daystamp - ($ndays * $one_day);
}

////////////////////////////////////////
function utm_timestamp($local_timestamp = null) {
    // UTM timestamp for time, default is current local time.
    if ($local_timestamp == null)
        return time() - server_timezone_offset();

    return $local_timestamp - timezone_offset();
}

function local_timestamp($utm_timestamp = null) {
    // Local timestamp for time, default is current time.
    if ($utm_timestamp == null)
        $utm_timestamp = time() - server_timezone_offset();

    return $utm_timestamp + timezone_offset();
}

function day_timestamp($local_timestamp = null) {
    // Local timestamp for the beginning of the day, default is current local time.
    if ($local_timestamp == null)
        $local_timestamp = time() - server_timezone_offset() + timezone_offset();
    $month = date('m', $local_timestamp);
    $day = date('d', $local_timestamp);
    $year = date('Y', $local_timestamp);

    return mktime(0, 0, 0, $month, $day, $year);
}

function make_timestamp($date_str) {
    // Make local timestamp from date string of mm/dd/yyyy or dd/mm/yyyy.
    global $calendar_style;
    $arr = preg_split('/\W/', $date_str);
    $ts = $calendar_style == "euro" ? mktime(0, 0, 0, $arr[1], $arr[0], $arr[2]) : mktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);

    return $ts;
}

function server_timezone_offset() {
    // Get time zone offset of this server.
    global $use_server_tz;

    if ($use_server_tz == "yes") {
        $tzo = date('Z');
    } else {
        $tzo = 0;
    }

    return $tzo;
}

function timezone_offset() {
    // Get time zone offset (from timeclock header.php)
    global $use_client_tz, $use_server_tz;

    if ($use_client_tz == "yes") {
        if (isset($_COOKIE['tzoffset'])) {
            $tzo = $_COOKIE['tzoffset'];
            settype($tzo, "integer");
            $tzo = $tzo * 60;
        }
    } elseif ($use_server_tz == "yes") {
        $tzo = date('Z');
    } else {
        $tzo = 0;
    }

    return $tzo;
}

////////////////////////////////////////
function exit_next($url) {
    // Go to next page
    header("Location: $url");
    exit;

    // Following causes browser to "blank screen" between pages.
    print <<<End_Of_HTML
<html><head><meta http-equiv="Refresh" CONTENT="0; URL=$url"></head><body></body></html>
End_Of_HTML;
    exit;
}

////////////////////////////////////////
function session_stop() {
    // Counterpart to php session_start(). Adapted from php.net.
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
        unset($_COOKIE[session_name()]);
    }
    $_SESSION = array();
    @session_destroy();
}

////////////////////////////////////////
function bool($str = null) {
    // true/false or yes/no
    if ($str && preg_match('/^\s*(no|false|0+)\s*$/i', $str))
        return false;
    if ($str)
        return true;

    return false;
}

////////////////////////////////////////
function turn_off_magic_quotes() {
    if (get_magic_quotes_gpc()) {
        remove_magic_quotes($_GET);
        remove_magic_quotes($_POST);
        remove_magic_quotes($_COOKIE);
        remove_magic_quotes($_REQUEST);
        ini_set('magic_quotes_gpc', 0);
    }
    set_magic_quotes_runtime(0);
}

function remove_magic_quotes(&$array) {
    if (empty($array))
        return;
    foreach (array_keys($array) as $key) {
        if (is_array($array[$key])) {
            remove_magic_quotes($array[$key]);
        } else {
            $array[$key] = stripslashes($array[$key]);
        }
    }
}

////////////////////////////////////////
function msg($msg) {
    return <<< EOF
<div class="message">
$msg
</div>
EOF;
}

////////////////////////////////////////
function error_msg($msg) {
    return <<< EOF
<div class="error">
$msg
</div>
EOF;
}

?>
