<?php
/**
 * Export display of hours.
 */

if (!isset($_SESSION['application'])) {
    header('Location:export.php');
    exit;
}

require_once 'class.Timecard.php';

// Construct query parameters
$begin_local_timestamp = make_timestamp($from_date); // begins at midnight
$end_local_timestamp = make_timestamp($to_date) + $one_day - 1; // through end of day

$begin_utm_timestamp = utm_timestamp($begin_local_timestamp);
$end_utm_timestamp = utm_timestamp($end_local_timestamp);

$employee_clause = $user_name == 'All' ? '' : "   and {$db_prefix}employees.empfullname = '" . mysql_real_escape_string($user_name) . "'\n";
$office_clause = $office_name == 'All' ? '' : "   and {$db_prefix}employees.office = '" . mysql_real_escape_string($office_name) . "'\n";
$groups_clause = $group_name == 'All' ? '' : "   and {$db_prefix}employees.groups = '" . mysql_real_escape_string($group_name) . "'\n";

// Select employees whose timecards need to be scanned.
$query = <<<End_Of_SQL
select distinct fullname
  from {$db_prefix}info
  left join {$db_prefix}employees on {$db_prefix}info.fullname = {$db_prefix}employees.empfullname
where timestamp between $begin_utm_timestamp and $end_utm_timestamp
{$employee_clause}{$office_clause}{$groups_clause}order by 1
End_Of_SQL;

$result = mysql_query($query)
or trigger_error("export_display: Cannot select employees. " . mysql_error(), E_USER_WARNING);

// Scan employee timecards between given dates and record computed hours.
setup_record_hours();
$week_begin_local_timestamp = work_week_begin($begin_local_timestamp);
$GLOBALS['tc_begin_local_timestamp'] = $begin_local_timestamp; // for filtering records between week begin and report begin date

while ($row = mysql_fetch_array($result)) {

    $empfullname = $row['fullname'];

    // Scan all employee timecards for each week between begin and end dates.
    $begin = $week_begin_local_timestamp;
    while ($begin < $end_local_timestamp) {
        $end = min(($begin + $one_week), $end_local_timestamp);

        // Walk each timecard and insert records into temporary database table t_computed_hours.
        $tc = new Timecard($empfullname, $begin, $end);
        list($timecard_row_count, $total_hours, $overtime_hours) = $tc->walk(null, record_hours, null);

        $begin = $end;
    }
}

// Setup export columns and query.
$cols = '';
if ($c_office)
    $cols .= ",office";
if ($c_group)
    $cols .= ",groups";
if ($c_employee)
    $cols .= ",empfullname";
if ($c_name)
    $cols .= ",displayname";
if ($c_date)
    $cols .= ",hours_date";
if ($c_inout)
    $cols .= ",`inout`,color";
if ($c_reg_ot)
    $cols .= ",reg_ot";

$group_by_clause = $cols ? "group by " . substr($cols, 1) . "\n" : '';
$order_by_clause = $cols ? "order by " . substr($cols, 1) . "\n" : '';
$order_by_clause = preg_replace('/reg_ot/', 'reg_ot desc', $order_by_clause);

// Select hour records.
$query = <<<End_Of_SQL
select coalesce(sum(hours),0) as sum_hours $cols
  from t_computed_hours
{$group_by_clause}{$order_by_clause}
End_Of_SQL;

$result = mysql_query($query)
or trigger_error("export_display: Cannot select hours. " . mysql_error(), E_USER_WARNING);

// Print export page header.
$begin_date = date('l F j, Y', $begin_local_timestamp);
$end_date = date('l F j, Y', $end_local_timestamp);
$h_user_name = htmlentities($user_name);
$h_group_name = htmlentities($group_name);
$h_office_name = htmlentities($office_name);
$chk_reg_ot = $c_reg_ot ? ' checked="checked"' : '';
$chk_inout = $c_inout ? ' checked="checked"' : '';
$chk_date = $c_date ? ' checked="checked"' : '';
$chk_employee = $c_employee ? ' checked="checked"' : '';
$chk_name = $c_name ? ' checked="checked"' : '';
$chk_group = $c_group ? ' checked="checked"' : '';
$chk_office = $c_office ? ' checked="checked"' : '';
$options_style = isset($_POST['redo']) ? '' : ' style="display:none"';
$options_link_class = isset($_POST['redo']) ? ' class="open"' : '';

print <<<End_Of_HTML
<div class="export">
<h2>Export Hours</h2>
<h3>$begin_date <small>through</small> $end_date</h3>

<div class="options">
<a href="javascript:;"$options_link_class onclick="$(this).toggleClass('open');$('#options').slideToggle()">Options</a>
<div id="options"$options_style>
<form method="post" action="{$_SERVER['PHP_SELF']}">
<input type="hidden" name="from_date" value="$from_date" />
<input type="hidden" name="to_date" value="$to_date" />
<input type="hidden" name="user_name" value="$h_user_name" />
<input type="hidden" name="group_name" value="$h_group_name" />
<input type="hidden" name="office_name" value="$h_office_name" />
<input type="hidden" name="redo" value="1" />
<table border="0" cellpadding="0" cellspacing="3">
  <tr>
    <td class="table_rows" height="25" valign="bottom">1.&nbsp;&nbsp;&nbsp;Select the table columns that are to be exported.</td>
  </tr>
  <tr>
    <td class="table_rows" align="left" nowrap style="padding-left:15px;">
      <label title="Column identifies hours as regular or overtime."><input type="checkbox" name="c_reg_ot" value="1" onclick="this.form.submit()"$chk_reg_ot /> Regular/Overtime</label>
      <label title="In/Out status or task code."><input type="checkbox" name="c_inout" value="1" onclick="this.form.submit()"$chk_inout /> Task/Status</label>
      <label title="Date hours were worked."><input type="checkbox" name="c_date" value="1" onclick="this.form.submit()"$chk_date /> Date</label>
      <label title="Employee name or ID."><input type="checkbox" name="c_employee" value="1" onclick="this.form.submit()"$chk_employee /> Employee</label>
      <label title="Employee name"><input type="checkbox" name="c_name" value="1" onclick="this.form.submit()"$chk_name /> Name</label>
      <label title="Employee's group."><input type="checkbox" name="c_group" value="1" onclick="this.form.submit()"$chk_group /> Group</label>
      <label title="Employee's office or location."><input type="checkbox" name="c_office" value="1" onclick="this.form.submit()"$chk_office /> Office</label>
    </td>
  </tr>
</table>
</div>
</div><!-- options -->

End_Of_HTML;

// Build export table html.
$row_count = 0;
while ($row = mysql_fetch_array($result)) {

    if ($row_count == 0) {
        // Table header
        print <<<End_Of_HTML

<div class="select-buttons">
<a href="javascript:;" class="select-button" onclick="Utils.Selection.clear();Utils.Selection.add(Utils.Ranges.selectNode(jQuery('#export_table').get(0)))">Select All</a>
<a href="javascript:;" class="select-button" onclick="Utils.Selection.clear();Utils.Selection.add(Utils.Ranges.selectNode(jQuery('#export_table tbody').get(0)))">Select Data</a>
<span class="tip">Copy and paste into your spreadsheet.</span>
</div>
<table id="export_table" class="misc_items export_items sortable draggable" border="0" cellpadding="2" cellspacing="0">
  <thead>
  <tr>
    <th align="right" title="Click to sort table, drag to rearrange columns.">Hours</th>

End_Of_HTML;
        if ($c_reg_ot)
            echo "    <th align=\"left\">Reg/OT</th>\n";
        if ($c_inout)
            echo "    <th align=\"left\">Task/Status</th>\n";
        if ($c_date)
            echo "    <th align=\"left\">Date</th>\n";
        if ($c_employee)
            echo "    <th align=\"left\">Employee</th>\n";
        if ($c_name)
            echo "    <th align=\"left\">Name</th>\n";
        if ($c_group)
            echo "    <th align=\"left\">Group</th>\n";
        if ($c_office)
            echo "    <th align=\"left\">Office</th>\n";
        print <<<End_Of_HTML
  </tr>
  </thead>
  <tbody>
End_Of_HTML;
    }

    // Every row
    $row_count++;
    $row_class = ($row_count % 2) ? 'odd' : 'even';

    $hours = sprintf("%01.02f", $row['sum_hours']);
    $reg_ot = $row['reg_ot'] == 'O' ? 'OT' : 'Reg';
    $h_inout = htmlentities($row['inout']);
    $h_color = $row['color'] ? htmlentities($row['color']) : 'inherit';
    $date = $row['hours_date'];
    $h_empfullname = htmlentities($row['empfullname']);
    $h_name = htmlentities($row['displayname']);
    $h_groups = htmlentities($row['groups']);
    $h_office = htmlentities($row['office']);

    print <<<End_Of_HTML

  <tr class="display_row $row_class">
    <td align="right">$hours</td>

End_Of_HTML;
    if ($c_reg_ot)
        echo "    <td align=\"center\">$reg_ot</td>\n";
    if ($c_inout)
        echo "    <td align=\"left\" style=\"color:$h_color\">$h_inout</td>\n";
    if ($c_date)
        echo "    <td align=\"left\">$date</td>\n";
    if ($c_employee)
        echo "    <td align=\"left\">$h_empfullname</td>\n";
    if ($c_name)
        echo "    <td align=\"left\">$h_name</td>\n";
    if ($c_group)
        echo "    <td align=\"left\">$h_groups</td>\n";
    if ($c_office)
        echo "    <td align=\"left\">$h_office</td>\n";
    print <<<End_Of_HTML
  </tr>
End_Of_HTML;
}

if ($row_count > 0) {
    print <<<End_Of_HTML

  </tbody>
</table>

End_Of_HTML;
} else {
    print error_msg("No records were found.");
}

print <<<End_Of_HTML

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="3" class="buttons">
  <tr><td><a href="index.php"><img src="$TIMECLOCK_URL/images/buttons/done_button.png" border="0" /></a></td></tr>
</table>

End_Of_HTML;

mysql_free_result($result);

////////////////////////////////////////
function setup_record_hours() {
    // Create temp database table to hold records of computed timecard hours.
    $sql = <<<End_Of_SQL
create temporary table t_computed_hours (
  `hours` float,
  `reg_ot` char(1),
  `inout` varchar(50),
  `color` varchar(7),
  `hours_date` varchar(16),
  `empfullname` varchar(50),
  `displayname` varchar(50),
  `groups` varchar(50),
  `office` varchar(50)
)
End_Of_SQL;
    mysql_query("DROP TABLE IF EXISTS t_computed_hours");
    mysql_query($sql)
    or trigger_error("export_display: Cannot create temporary table t_computed_hours. " . mysql_error(), E_USER_WARNING);
}

function record_hours($tc) {
    // Insert records of computed hours into temp database table.
    // Helper function for Timecard::walk().

    if ($tc->in_or_out == 1) {
        // Don't record records between the beginning of the work week and the report's begin date.
        if ($tc->end_time < $GLOBALS['tc_begin_local_timestamp'])
            return;
        if ($tc->start_time < $GLOBALS['tc_begin_local_timestamp']) {
            // Person punched in before start time of report and punched out after.
            // Adjust hours to be just those from the beginning of day.
            $start_time = $GLOBALS['tc_begin_local_timestamp'];
            $begin_hours = compute_hours($start_time, $tc->end_time);
            if ($begin_hours < $tc->overtime) {
                $overtime = $tc->overtime - $begin_hours;
                $hours = $tc->hours;
            } else {
                $overtime = 0;
                $hours - $tc->hours - ($begin_hours - $tc->overtime);
            }
        } else {
            // Normal case.
            $start_time = $tc->start_time;
            $hours = $tc->hours;
            $overtime = $tc->overtime;
        }

        if (round($hours, 3) > 0) {
            $reg_ot = 'R';
            $q_inout = mysql_real_escape_string($tc->row['inout']);
            $q_color = mysql_real_escape_string($tc->row['color']);
            $q_employee = mysql_real_escape_string($tc->row['fullname']);
            $q_name = mysql_real_escape_string($tc->row['displayname']);
            $q_group = mysql_real_escape_string($tc->row['groups']);
            $q_office = mysql_real_escape_string($tc->row['office']);
            #$date        = date('Y-m-d H:i',$start_time); ## debug
            $date = date('Y-m-d', $start_time);
            $sql = <<<End_Of_SQL
insert into t_computed_hours (hours,reg_ot,`inout`,color,hours_date,empfullname,displayname,groups,office)
values ($hours,'$reg_ot','$q_inout','$q_color','$date','$q_employee','$q_name','$q_group','$q_office')
End_Of_SQL;
            mysql_query($sql)
            or trigger_error("export_display: Cannot insert regular hours into temp table. " . mysql_error(), E_USER_WARNING);
        }

        if (round($overtime, 3) > 0) {
            $reg_ot = 'O';
            $q_inout = mysql_real_escape_string($tc->row['inout']);
            $q_color = mysql_real_escape_string($tc->row['color']);
            $q_employee = mysql_real_escape_string($tc->row['fullname']);
            $q_name = mysql_real_escape_string($tc->row['displayname']);
            $q_group = mysql_real_escape_string($tc->row['groups']);
            $q_office = mysql_real_escape_string($tc->row['office']);
            #$date        = date('Y-m-d H:i',$start_time); ## debug
            $date = date('Y-m-d', $start_time);
            $sql = <<<End_Of_SQL
insert into t_computed_hours (hours,reg_ot,`inout`,color,hours_date,empfullname,displayname,groups,office)
values ($overtime,'$reg_ot','$q_inout','$q_color','$date','$q_employee','$q_name','$q_group','$q_office')
End_Of_SQL;
            mysql_query($sql)
            or trigger_error("export_display: Cannot insert overtime hours into temp table. " . mysql_error(), E_USER_WARNING);
        }
    }
}

?>
