<?php

include '../config.inc.php';
include '../functions.php';

@$db = mysql_pconnect($db_hostname, $db_username, $db_password);
if (!$db) {echo "Error: Could not connect to the database. Please try again later."; exit;}
mysql_select_db($db_name);

if (($_GET['rpt'] == 'timerpt') && (isset($_GET['display_ip'])) && (isset($_GET['csv'])) && (isset($_GET['office'])) && (isset($_GET['group'])) && 
(isset($_GET['fullname'])) && (isset($_GET['from'])) && (isset($_GET['to'])) && (isset($_GET['tzo']))) {

$tmp_display_ip = $_GET['display_ip'];
$tmp_csv = $_GET['csv'];
$office_name = $_GET['office'];
$group_name = $_GET['group'];
$fullname = $_GET['fullname'];
$from_timestamp = $_GET['from'];
$to_timestamp = $_GET['to'];
$tzo = $_GET['tzo'];

$employees_cnt = 0;
$employees_empfullname = array();
$employees_displayname = array();
$row_count = 0;
$page_count = 0;

// retrieve a list of users //

$fullname = addslashes($fullname);

if (strtolower($user_or_display) == "display") {

    if (($office_name == "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname == 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname != 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL and empfullname = '".$fullname."' order by 
                  displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and tstamp IS NOT NULL order by 
                  displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."'  and 
                  tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname != "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."' and
                  empfullname = '".$fullname."' and tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);
    }

} else {

    if (($office_name == "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname == 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname != 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL and empfullname = '".$fullname."' order by 
                  empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and tstamp IS NOT NULL order by 
                  empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."'  and 
                  tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname != "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."' and
                  empfullname = '".$fullname."' and tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    }
}

while ($row=mysql_fetch_array($result)) {

  $employees_empfullname[] = stripslashes("".$row['empfullname']."");
  $employees_displayname[] = stripslashes("".$row['displayname']."");
  $employees_cnt++;
}

if (!empty($tmp_display_ip)) {
  $headings = "Name, In/Out, Time, Date, IP Address, Notes,\n";
} else {
  $headings = "Name, In/Out, Time, Date, Notes,\n";
}
$string = "";

for ($x=0;$x<$employees_cnt;$x++) {

    $fullname = stripslashes($fullname);
    if (($employees_empfullname[$x] == $fullname) || ($fullname == "All")) {

        $row_color = $color2; // Initial row color

        $employees_empfullname[$x] = addslashes($employees_empfullname[$x]);
        $employees_displayname[$x] = addslashes($employees_displayname[$x]);

        $query = "select ".$db_prefix."info.fullname, ".$db_prefix."info.`inout`, ".$db_prefix."info.timestamp, ".$db_prefix."info.notes, 
                  ".$db_prefix."info.ipaddress, ".$db_prefix."punchlist.in_or_out, ".$db_prefix."punchlist.punchitems, ".$db_prefix."punchlist.color
                  from ".$db_prefix."info, ".$db_prefix."punchlist, ".$db_prefix."employees
                  where ".$db_prefix."info.fullname like '".$employees_empfullname[$x]."' 
                  and ".$db_prefix."info.timestamp >= '".$from_timestamp."' and ".$db_prefix."info.timestamp <= '".$to_timestamp."' 
                  and ".$db_prefix."info.`inout` = ".$db_prefix."punchlist.punchitems
                  and ".$db_prefix."employees.empfullname = '".$employees_empfullname[$x]."'
                  order by ".$db_prefix."info.timestamp asc";
        $result = mysql_query($query);

        while ($row=mysql_fetch_array($result)) {

            $display_stamp = "".$row["timestamp"]."";
            $time = date($timefmt, $display_stamp);
            $date = date($datefmt, $display_stamp);

            // display the query results //

            $display_stamp = $display_stamp + @$tzo;
            $time = date($timefmt, $display_stamp);
            $date = date($datefmt, $display_stamp);

            if (strtolower($user_or_display) == "display") {
              $displayname = stripslashes($employees_displayname[$x]);
            } else {
              $empfullname = stripslashes($employees_empfullname[$x]);
            }
            $inout = "".$row["inout"]."";
            if (!empty($tmp_display_ip)) {
                $ipaddress = "".$row["ipaddress"]."";
            }
            $notes = stripslashes("".$row["notes"]."");

            if (strtolower($user_or_display) == "display") {
              if (!empty($tmp_display_ip)) {
                $string .= "$displayname, $inout, $time, $date, $ipaddress, $notes,\n";
              } else {
                $string .= "$displayname, $inout, $time, $date, $notes,\n";
              }
            } else {
              if (!empty($tmp_display_ip)) {
                $string .= "$empfullname, $inout, $time, $date, $ipaddress, $notes,\n";
              } else {   
                $string .= "$empfullname, $inout, $time, $date, $notes,\n";
              }
           }
        }
    }
}
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=total_hours.csv");
header("Pragma: no-cache");
header("Expires: 0");
echo "$headings$string";

} elseif (($_GET['rpt'] == 'hrs_wkd') && (isset($_GET['display_ip'])) && (isset($_GET['csv'])) && (isset($_GET['office'])) && (isset($_GET['group'])) &&
(isset($_GET['fullname'])) && (isset($_GET['from'])) && (isset($_GET['to'])) && (isset($_GET['tzo'])) && (isset($_GET['paginate'])) && 
(isset($_GET['round'])) && (isset($_GET['details'])) && (isset($_GET['rpt_run_on'])) && (isset($_GET['rpt_date'])) && (isset($_GET['from_date']))) {

$tmp_display_ip = $_GET['display_ip'];
$tmp_csv = $_GET['csv'];
$office_name = $_GET['office'];
$group_name = $_GET['group'];
$fullname = $_GET['fullname'];
$from_timestamp = $_GET['from'];
$to_timestamp = $_GET['to'];
$tzo = $_GET['tzo'];
$tmp_paginate = $_GET['paginate'];
$tmp_round_time = $_GET['round'];
$tmp_show_details = $_GET['details'];
$rpt_stamp = $_GET['rpt_run_on'];
$rpt_date = $_GET['rpt_date'];
$from_date = $_GET['from_date'];

$employees_cnt = 0;
$employees_empfullname = array();
$employees_displayname = array();
$info_cnt = 0;
$info_fullname = array();
$info_inout = array();
$info_timestamp = array();
$info_notes = array();
$info_date = array();
$info_start_time = array();
$info_end_time = array();
$punchlist_in_or_out = array();
$punchlist_punchitems = array();
$secs = 0;
$total_hours = 0;
$row_count = 0;
$page_count = 0;
$punch_cnt = 0;
$tmp_z = 0;

// retrieve a list of users //

$fullname = addslashes($fullname);

if (strtolower($user_or_display) == "display") {

    if (($office_name == "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname == 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname != 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL and empfullname = '".$fullname."' order by 
                  displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and tstamp IS NOT NULL order by 
                  displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."'  and 
                  tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname != "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."' and
                  empfullname = '".$fullname."' and tstamp IS NOT NULL order by displayname asc";
        $result = mysql_query($query);

    }

} else {

    if (($office_name == "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname == 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif ((empty($office_name)) && (empty($group_name)) && ($fullname != 'All')) {

        $query = "select empfullname, displayname from ".$db_prefix."employees WHERE tstamp IS NOT NULL and empfullname = '".$fullname."' order by 
                  empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name == "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and tstamp IS NOT NULL order by 
                  empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname == "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."'  and 
                  tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    } elseif (($office_name != "All") && ($group_name != "All") && ($fullname != "All")) {

        $query = "select empfullname, displayname from ".$db_prefix."employees where office = '".$office_name."' and groups = '".$group_name."' and
                  empfullname = '".$fullname."' and tstamp IS NOT NULL order by empfullname asc";
        $result = mysql_query($query);

    }
}

while ($row=mysql_fetch_array($result)) {

  $employees_empfullname[] = stripslashes("".$row['empfullname']."");
  $employees_displayname[] = stripslashes("".$row['displayname']."");
  $employees_cnt++;
}

if ($tmp_show_details == "1") {
    if (!empty($tmp_display_ip)) {
        $headings = "Name, In/Out, Time, Date, IP Address, Notes, Daily Totals, Employee Totals,\n";
    } else {
        $headings = "Name, In/Out, Time, Date, Notes, Daily Totals, Employee Totals,\n";
    }
} else {
    $headings = "Name, Date, Daily Totals, Employee Totals,\n";
}
$string = "";

for ($x=0;$x<$employees_cnt;$x++) {

    $fullname = stripslashes($fullname);
    if (($employees_empfullname[$x] == $fullname) || ($fullname == "All")) {

    $employees_empfullname[$x] = addslashes($employees_empfullname[$x]);
    $employees_displayname[$x] = addslashes($employees_displayname[$x]);

    $query = "select ".$db_prefix."info.fullname, ".$db_prefix."info.`inout`, ".$db_prefix."info.timestamp, ".$db_prefix."info.notes, 
              ".$db_prefix."info.ipaddress, ".$db_prefix."punchlist.in_or_out, ".$db_prefix."punchlist.punchitems, ".$db_prefix."punchlist.color
              from ".$db_prefix."info, ".$db_prefix."punchlist, ".$db_prefix."employees
              where ".$db_prefix."info.fullname like ('".$employees_empfullname[$x]."') and ".$db_prefix."info.timestamp >= '".$from_timestamp."'
              and ".$db_prefix."info.timestamp < '".$to_timestamp."' and ".$db_prefix."info.`inout` = ".$db_prefix."punchlist.punchitems 
              and ".$db_prefix."employees.empfullname = '".$employees_empfullname[$x]."'
              order by ".$db_prefix."info.timestamp asc";
    $result = mysql_query($query);

    while ($row=mysql_fetch_array($result)) {

      $info_fullname[] = stripslashes("".$row['fullname']."");
      $info_inout[] = "".$row['inout']."";
      $info_timestamp[] = "".$row['timestamp']."" + $tzo;
      $info_notes[] = "".$row['notes']."";
      $info_ipaddress[] = "".$row['ipaddress']."";
      $punchlist_in_or_out[] = "".$row['in_or_out']."";
      $punchlist_punchitems[] = "".$row['punchitems']."";
      $punchlist_color[] = "".$row['color']."";
      $info_cnt++;
    }

    $employees_empfullname[$x] = stripslashes($employees_empfullname[$x]);
    $employees_displayname[$x] = stripslashes($employees_displayname[$x]);

    for ($y=0;$y<$info_cnt;$y++) {

      $info_date[] = date($datefmt, $info_timestamp[$y]);
      $info_start_time[] = strtotime($info_date[$y]);
      $info_end_time[] = $info_start_time[$y] + 86399;

      if (isset($tmp_info_date)) {
          if ($tmp_info_date == $info_date[$y]) {
              if (empty($punchlist_in_or_out[$y])) {
                  $punch_cnt++;
                    if ($status == "out") {
                        $secs = $secs + ($info_timestamp[$y] - $out_time);
                    } elseif ($status == "in") {
                        $secs = $secs + ($info_timestamp[$y] - $in_time);
                    }
                  $status = "out";
                  $out_time = $info_timestamp[$y];
                  if ($y == $info_cnt - 1) {
                      $hours = secsToHours($secs, $tmp_round_time);
                      $total_hours = $total_hours + $hours;
                      $hours = number_format($hours, 2);
                      if ($tmp_show_details == "1") {
                          for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                              $time_formatted = date($timefmt, $info_timestamp[$z]);
                              if (strtolower($user_or_display) == "display") {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              } else {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              }
                              $tmp_z++;
                          }
                      } else {
                          if (strtolower($user_or_display) == "display") {
                              $string .= "$employees_displayname[$x], $info_date[$y], $hours, ,\n";
                          } else {
                              $string .= "$employees_empfullname[$x], $info_date[$y], $hours, ,\n";
                          }
                      }
                      $secs = 0;
                      $punch_cnt = 0;
                  }
              } else {
                  $punch_cnt++;
                  if ($y == $info_cnt - 1) {
                      if (($info_timestamp[$y] <= $rpt_stamp) && ($rpt_stamp < ($to_timestamp + $tzo)) && ($info_date[$y] == $rpt_date)) {
                          if ($status == "in") {
                              $secs = $secs + ($rpt_stamp - $info_timestamp[$y]) + ($info_timestamp[$y] - $in_time);
                          } elseif ($status == "out") {
                              $secs = $secs + ($rpt_stamp - $info_timestamp[$y]);
                          }
                          $currently_punched_in = '1';
                      } elseif (($info_timestamp[$y] <= $rpt_stamp) && ($info_date[$y] == $rpt_date)) {
                          if ($status == "in") {
                              $secs = $secs + (($to_timestamp + $tzo) - $info_timestamp[$y]) + ($info_timestamp[$y] - $in_time);
                          } elseif ($status == "out") {
                              $secs = $secs + (($to_timestamp + $tzo) - $info_timestamp[$y]);
                          }
                          $currently_punched_in = '1';
                      } else {
                          $secs = $secs + (($info_end_time[$y] + 1) - $info_timestamp[$y]);
                      }
                  } else {
                      if ($status == "in") {
                          $secs = $secs + ($info_timestamp[$y] - $in_time);
                      }
                      $in_time = $info_timestamp[$y];
                      $previous_days_end_time = $info_end_time[$y] + 1;
                  }
                  $status = "in";
                  if ($y == $info_cnt - 1) {
                      $hours = secsToHours($secs, $tmp_round_time);
                      $total_hours = $total_hours + $hours;
                      $hours = number_format($hours, 2);
                      if ($tmp_show_details == "1") {
                          for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                              $time_formatted = date($timefmt, $info_timestamp[$z]);
                              if (strtolower($user_or_display) == "display") {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              } else {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              }
                              $tmp_z++;
                          }
                      } else {
                          if (strtolower($user_or_display) == "display") {
                              $string .= "$employees_displayname[$x], $info_date[$y], $hours, ,\n";
                          } else {
                              $string .= "$employees_empfullname[$x], $info_date[$y], $hours, ,\n";
                          }
                      }
                  $secs = 0;
                  $punch_cnt = 0;
                  }
              }
          } else {

              //// print totals for previous day ////

              //// if the previous has only a single In punch and no Out punches, configure the $secs ////

              if (isset($tmp_info_date)) {
                  if ($status == "out") {
                      $secs = $secs;
                  } elseif ($status == "in") {
                      $secs = $secs + ($previous_days_end_time - $in_time);
                  }
                  $hours = secsToHours($secs, $tmp_round_time);
                  $total_hours = $total_hours + $hours;
                  $hours = number_format($hours, 2);
                  $row_color = $color2; // Initial row color
                  if (empty($y)) {
                      $yy = 0;
                  } else {
                      $yy = $y - 1;
                  }
                  if ($tmp_show_details == "1") {
                      for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                          $time_formatted = date($timefmt, $info_timestamp[$z]);
                          if (strtolower($user_or_display) == "display") {
                              if (!empty($tmp_display_ip)) {
                                  if ($z == $punch_cnt) {  
                                      $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                  } else {  
                                      $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                  }
                              } else {
                                  if ($z == $punch_cnt) {  
                                      $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_notes[$z], $hours, ,\n";
                                  } else {
                                      $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_notes[$z], , ,\n";
                                  }
                              }
                          } else {
                              if (!empty($tmp_display_ip)) {
                                  if ($z == $punch_cnt) {  
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                  } else {
                                  $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                  }
                              } else {
                                  if ($z == $punch_cnt) {  
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_notes[$z], $hours, ,\n";
                                  } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$yy], $info_notes[$z], , ,\n";
                                  }
                              }
                          }
                          $tmp_z++;
                      }
                  } else {
                      if (strtolower($user_or_display) == "display") {
                          $string .= "$employees_displayname[$x], $info_date[$yy], $hours, ,\n";
                      } else {
                          $string .= "$employees_empfullname[$x], $info_date[$yy], $hours, ,\n";
                      }
                  }
              $secs = 0;
              unset($in_time);
              unset($out_time);
              unset($previous_days_end_time);
              unset($status);
              unset($tmp_info_date);
              unset($date_formatted);
              }
              $tmp_info_date = $info_date[$y];
              $previous_days_end_time = $info_end_time[$y] + 1;
              $punch_cnt++;
              if (empty($punchlist_in_or_out[$y])) {
                  $status = "out";
                  $secs = $info_timestamp[$y] - $info_start_time[$y];
                  $out_time = $info_timestamp[$y];
                  $previous_days_end_time = $info_end_time[$y] + 1;
                  if ($y == $info_cnt - 1) {
                      $hours = secsToHours($secs, $tmp_round_time);
                      $total_hours = $total_hours + $hours;
                      $hours = number_format($hours, 2);
                      if ($tmp_show_details == "1") {
                          for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                              $time_formatted = date($timefmt, $info_timestamp[$z]);
                              if (strtolower($user_or_display) == "display") {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              } else {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              }
                              $tmp_z++;
                          }
                      } else {
                          if (strtolower($user_or_display) == "display") {
                              $string .= "$employees_displayname[$x], $info_date[$y], $hours, ,\n";
                          } else {
                              $string .= "$employees_empfullname[$x], $info_date[$y], $hours, ,\n";
                          }
                      }
                      $secs = 0;
                      $punch_cnt = 0;
                  }
              } else {
                  if ($y == $info_cnt - 1) {
                      if (($info_timestamp[$y] <= $rpt_stamp) && ($rpt_stamp < ($to_timestamp + $tzo)) && ($info_date[$y] == $rpt_date)) {
                          $secs = $secs + ($rpt_stamp - $info_timestamp[$y]);
                          $currently_punched_in = '1';
                      } elseif (($info_timestamp[$y] <= $rpt_stamp) && ($info_date[$y] == $rpt_date)) {
                          $secs = $secs + (($to_timestamp + $tzo) - $info_timestamp[$y]);
                          $currently_punched_in = '1';
                      } else {
                          $secs = $secs + (($info_end_time[$y] + 1) - $info_timestamp[$y]);
                      }
                  } else {
                      $status = "in";
                      $in_time = $info_timestamp[$y];
                      $previous_days_end_time = $info_end_time[$y] + 1;
                  }
                  if ($y == $info_cnt - 1) {
                      $hours = secsToHours($secs, $tmp_round_time);
                      $total_hours = $total_hours + $hours;
                      $hours = number_format($hours, 2);
                      if ($tmp_show_details == "1") {
                          for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                              $time_formatted = date($timefmt, $info_timestamp[$z]);
                              if (strtolower($user_or_display) == "display") {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              } else {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              }
                              $tmp_z++;
                          }
                      } else {
                          if (strtolower($user_or_display) == "display") {
                              $string .= "$employees_displayname[$x], $info_date[$y], $hours, ,\n";
                          } else {
                              $string .= "$employees_empfullname[$x], $info_date[$y], $hours, ,\n";
                          }
                      }
                      $secs = 0;
                      $punch_cnt = 0;
                  }
              }
          }
      } else {
          ///// this is for the start of the first entry for the first day /////

          $tmp_info_date = $info_date[$y];
          $previous_days_end_time = $info_end_time[$y] + 1;
          if (empty($punchlist_in_or_out[$y])) {
              $out = 1;
              $status = "out";
              if ($info_date[$y] == $from_date) {
                  $secs = $info_timestamp[$y] - $from_timestamp - $tzo;
              } else {
                  $secs = $info_timestamp[$y] - $info_start_time[$y];
              }
              $out_time = $info_timestamp[$y];
              $previous_days_end_time = $info_end_time[$y] + 1;
              if ($y == $info_cnt - 1) {
                  $hours = secsToHours($secs, $tmp_round_time);
                  $total_hours = $total_hours + $hours;
                  $hours = number_format($hours, 2);
                  if ($y == $info_cnt - 1) {
                      $hours = secsToHours($secs, $tmp_round_time);
                      $total_hours = $total_hours + $hours;
                      if ($tmp_show_details == "1") {
                          for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                              $time_formatted = date($timefmt, $info_timestamp[$z]);
                              if (strtolower($user_or_display) == "display") {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              } else {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              }
                              $tmp_z++;
                          }
                      } else {
                          if (strtolower($user_or_display) == "display") {
                              $string .= "$employees_displayname[$x], $info_date[$y], $hours, ,\n";
                          } else {
                              $string .= "$employees_empfullname[$x], $info_date[$y], $hours, ,\n";
                          }
                      }
                  }
                  $secs = 0;
                  $punch_cnt = 0;
              }
          } else {
              $secs = 0;
              $status = "in";
              $in_time = $info_timestamp[$y];
              $previous_days_end_time = $info_end_time[$y] + 1;
              if ($y == $info_cnt - 1) {
                  if (($info_timestamp[$y] <= $rpt_stamp) && ($rpt_stamp < ($to_timestamp + $tzo)) && ($info_date[$y] == $rpt_date)) {
                      $secs = $secs + ($rpt_stamp - $info_timestamp[$y]);
                      $currently_punched_in = '1';
                  } elseif (($info_timestamp[$y] <= $rpt_stamp) && ($info_date[$y] == $rpt_date)) {
                      $secs = $secs + (($to_timestamp + $tzo) - $info_timestamp[$y]);
                      $currently_punched_in = '1';
                  } else {
                      $secs = $secs + (($info_end_time[$y] + 1) - $info_timestamp[$y]);
                  }
              }
              if ($y == $info_cnt - 1) {
                  $hours = secsToHours($secs, $tmp_round_time);
                  $total_hours = $total_hours + $hours;
                  $hours = number_format($hours, 2);
                  if ($y == $info_cnt - 1) {
                      $hours = secsToHours($secs, $tmp_round_time);
                      $total_hours = $total_hours + $hours;
                      if ($tmp_show_details == "1") {
                          for ($z=$tmp_z;$z<=$punch_cnt;$z++) {
                              $time_formatted = date($timefmt, $info_timestamp[$z]);
                              if (strtolower($user_or_display) == "display") {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_displayname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              } else {
                                  if (!empty($tmp_display_ip)) {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], $hours, ,\n";
                                      } else {
                                      $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_ipaddress[$z], $info_notes[$z], , ,\n";
                                      }
                                  } else {
                                      if ($z == $punch_cnt) {  
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], $hours, ,\n";
                                      } else {
                                          $string .= "$employees_empfullname[$x], $info_inout[$z], $time_formatted, $info_date[$y], $info_notes[$z], , ,\n";
                                      }
                                  }
                              }
                              $tmp_z++;
                          }
                      } else {
                          if (strtolower($user_or_display) == "display") {
                              $string .= "$employees_displayname[$x], $info_date[$y], $hours, ,\n";
                          } else {
                              $string .= "$employees_empfullname[$x], $info_date[$y], $hours, ,\n";
                          }
                      }
                  }
                  $secs = 0;
                  $punch_cnt = 0;
              }
          }
      } // ends if (isset($tmp_info_date))
    } // ends for $y

    unset($in_time);
    unset($out_time);
    unset($previous_days_end_time);
    unset($status);
    unset($tmp_info_date);
    unset($date_formatted);
    $my_total_hours = number_format($total_hours, 2);
    if ($tmp_show_details == "1") {
        if (strtolower($user_or_display) == "display") {
            if (!empty($tmp_display_ip)) {
                $string .= "$employees_displayname[$x], , , , , , , $my_total_hours,\n";
            } else {
                $string .= "$employees_displayname[$x], , , , , , $my_total_hours,\n";
            }
        } else {
            if (!empty($tmp_display_ip)) {
                $string .= "$employees_empfullname[$x], , , , , , , $my_total_hours, \n";
            } else {
                $string .= "$employees_empfullname[$x], , , , , , $my_total_hours\n";
            }
        }
    } else {
        if (strtolower($user_or_display) == "display") {
            $string .= "$employees_displayname[$x], , , $my_total_hours,\n";
        } else {
            $string .= "$employees_empfullname[$x], , , $my_total_hours, \n";
        }
    }

    //// reset everything before running the loop on the next user ////

    $tmp_z = 0;
    $row_count = 0;
    $total_hours = 0;
    $my_total_hours = 0;
    $info_cnt = 0;
    $punch_cnt = 0;
    $secs = 0;
    unset($info_fullname);
    unset($info_inout);
    unset($info_timestamp);
    unset($info_notes);
    unset($info_ipaddress);
    unset($punchlist_in_or_out);
    unset($punchlist_punchitems);
    unset($punchlist_color);
    unset($info_date);
    unset($info_start_time);
    unset($info_end_time);
    unset($tmp_info_date);
    unset($hours);
    unset($date_formatted);
    unset($currently_punched_in);
    } // end if
} // end for $x
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=total_hours.csv");
header("Pragma: no-cache");
header("Expires: 0");
echo "$headings$string";

} elseif (($_GET['rpt'] == 'auditlog') && (isset($_GET['csv'])) && (isset($_GET['from'])) && (isset($_GET['to'])) && (isset($_GET['tzo']))) {

$tmp_csv = $_GET['csv'];
$from_timestamp = $_GET['from'];
$to_timestamp = $_GET['to'];
$tzo = $_GET['tzo'];

$row_count = 0;
$page_count = 0;
$cnt = 0;
$modified_when = array();
$modified_from = array();
$modified_to = array();
$modified_by_ip = array();
$modified_by_user = array();
$modified_why = array();

$row_color = $color2; // Initial row color

$query = "select * from ".$db_prefix."audit where modified_when >= '".$from_timestamp."' and modified_when <= '".$to_timestamp."'
          order by modified_when asc";
$result = mysql_query($query);

while ($row=mysql_fetch_array($result)) {

  $modified_when[] = "".$row["modified_when"]."";
  $modified_from[] = "".$row["modified_from"]."";
  $modified_to[] = "".$row["modified_to"]."";
  $modified_by_ip[] = "".$row["modified_by_ip"]."";
  $modified_by_user[] = stripslashes("".$row["modified_by_user"]."");
  $modified_why[] = "".$row["modified_why"]."";
  $cnt++;
}

$headings = "Action Taken, Modified When, Modified From, Modified To, Modified By, Modified By IP,\n";
$string = "";

for ($x=0;$x<$cnt;$x++) {

    if (!empty($modified_when[$x])) {
        $modified_when_time = date($timefmt, $modified_when[$x]);
        $modified_when_date = date($datefmt, $modified_when[$x]);
    } else {
        exit;
    }
    if (!empty($modified_from[$x])) {
        $modified_from_time = date($timefmt, $modified_from[$x]);
        $modified_from_date = date($datefmt, $modified_from[$x]);
    } else {
        $modified_from_time = "".$row["modified_from"]."";
        $modified_from_date = "".$row["modified_from"]."";
    }
    if (!empty($modified_to[$x])) {
        $modified_to_time = date($timefmt, $modified_to[$x]);
        $modified_to_date = date($datefmt, $modified_to[$x]);
    } else {
        $modified_to_time = "".$row["modified_to"]."";
        $modified_to_date = "".$row["modified_to"]."";
    }
    if ((!empty($modified_from[$x])) && (empty($modified_to[$x]))) {
        $modified_status = "Deleted";
        $modified_color = "#FF0000";
    } elseif ((!empty($modified_from[$x])) && (!empty($modified_to[$x]))) {
        $modified_status = "Edited";
        $modified_color = "#FF9900";
    } elseif ((empty($modified_from[$x])) && (!empty($modified_to[$x]))) {
        $modified_status = "Added";
        $modified_color = "#009900";
    }

    $string .= "$modified_status, $modified_when_date $modified_when_time, $modified_from_date $modified_from_time, $modified_to_date $modified_to_time, $modified_by_user[$x], $modified_by_ip[$x],\n";
}
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=total_hours.csv");
header("Pragma: no-cache");
header("Expires: 0");
echo "$headings$string";
}
exit;
?>
