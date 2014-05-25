<?php
/**
 * Punchclock display rows of employees.
 */

if (!isset($_SESSION['application'])) {
    header('Location:punchclock.php');
    exit;
}

// Hardwire sortcolumn and sortdirection.
$sortcolumn = $show_display_name == 'yes' ? 'displayname' : 'empfullname';
$sortdirection = 'asc';

// Construct query
$office_clause = $display_office == 'all' ? '' : "   and {$db_prefix}employees.office = '" . mysql_real_escape_string($display_office) . "'\n";
$groups_clause = $display_group == 'all' ? '' : "   and {$db_prefix}employees.groups = '" . mysql_real_escape_string($display_group) . "'\n";

$query = <<<End_Of_SQL
select {$db_prefix}employees.*, {$db_prefix}info.*, {$db_prefix}punchlist.*
  from {$db_prefix}employees
  left join {$db_prefix}info on {$db_prefix}info.fullname = {$db_prefix}employees.empfullname
        and {$db_prefix}info.timestamp = {$db_prefix}employees.tstamp
  left join {$db_prefix}punchlist on {$db_prefix}punchlist.punchitems = {$db_prefix}info.`inout`
 where {$db_prefix}employees.disabled <> '1'
   and {$db_prefix}employees.empfullname <> 'admin'
{$office_clause}{$groups_clause}order by $sortcolumn $sortdirection
End_Of_SQL;

$result = mysql_query($query)
or trigger_error("punchclock_display: Cannot select employees. " . mysql_error(), E_USER_WARNING);

$row_count = 0;
while ($row = mysql_fetch_array($result)) {

    if ($row_count == 0) {

        // Table header
        print <<<End_Of_HTML

<table class="misc_items emp_list" width="100%" border="0" cellpadding="2" cellspacing="0">
  <thead>
  <tr>
    <th width="20%" align="left">Name</th>
    <th width="7%" align="left">In/Out</th>
    <th width="5%" align="center">Time</th>
    <th width="5%" align="center">Date</th>
End_Of_HTML;

        if ($display_office_name == "yes")
            print <<<End_Of_HTML

    <th width="10%" align="left">Office</th>
End_Of_HTML;

        if ($display_group_name == "yes")
            print <<<End_Of_HTML

    <th width="10%" align="left">Group</th>
End_Of_HTML;

        print <<<End_Of_HTML

    <th align="left">Notes</th>
  </tr>
  </thead>
  <tbody>
End_Of_HTML;
    }

    $row_count++;
    $row_class = ($row_count % 2) ? 'odd' : 'even';

    if ($row['timestamp'] > 0) {
        $display_stamp = local_timestamp($row['timestamp']);
        $time = date($timefmt, $display_stamp);
        $date = date($datefmt, $display_stamp);
    } else {
        // New employees do not have timestamp to display yet.
        $time = $date = '';
    }

    $u_empfullname = urlencode($row['empfullname']);

    $h_name = htmlentities(($show_display_name == 'yes' ? $row['displayname'] : $row['empfullname']));
    $h_color = htmlentities($row['color']);
    $h_inout = htmlentities($row['inout']);
    $h_office = htmlentities($row['office']);
    $h_groups = htmlentities($row['groups']);
    $h_notes = htmlentities($row['notes']);

    // Make DOM id out of employee fullname column (which is assumed to be their employee id).
    $id = htmlentities(make_id($row['empfullname']));

    print <<<End_Of_HTML

  <tr class="display_row $row_class" id="$id">
    <td align="left"><a href="entry.php?emp=$u_empfullname">$h_name</a></td>
    <td align="left" style="color:$h_color">$h_inout</td>
    <td align="right">$time</td>
    <td align="right">$date</td>
End_Of_HTML;

    if ($display_office_name == "yes")
        print <<<End_Of_HTML

    <td align="left">$h_office</td>
End_Of_HTML;

    if ($display_group_name == "yes")
        print <<<End_Of_HTML

    <td align="left">$h_groups</td>
End_Of_HTML;

    print <<<End_Of_HTML

    <td align="left">$h_notes</td>
  </tr>
End_Of_HTML;
}

if ($row_count > 0) {
    print <<<End_Of_HTML

  </tbody>
</table>

End_Of_HTML;
} else {
    print error_msg("No active employee records were found.");
}

mysql_free_result($result);
?>
