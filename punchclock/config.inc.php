<?php

/*
****************************************************************************
Add to timeclock configuration variables.
****************************************************************************
*/

/* --- PUNCHCLOCK CONFIGURATION ---  */

/* --- REQUIRED CHANGES --- */


/* The $TIMECLOCK_PATH needs to be set to the directory path of the timeclock.php
 * program on the server. The $TIMECLOCK_PATH is used by PHP to include other
 * parts to the program. The default is "..", the directory just above this
 * punchclock program directory. */

$TIMECLOCK_PATH = isset($ENV['TIMECLOCK_PATH']) ? $ENV['TIMECLOCK_PATH'] : '..';

/* The $TIMECLOCK_URL needs to be set to the url of the timeclock.php
 * program. The $TIMECLOCK_URL is used by browser to display images and such. 
 * The default is "..", the directory just above this punchclock program directory. */

$TIMECLOCK_URL = isset($ENV['TIMECLOCK_URL']) ? $ENV['TIMECLOCK_URL'] : '..';


/* --- RECOMMENDED CHANGES --- */

/* This sets the refresh rate (in seconds) for punchclock.php. If the application is kept open,
   it will refresh every $punchclock_refresh seconds to display the most current info. Default
   is 60. Set it to "none" to ignore this option. */

$punchclock_refresh = "60";

/* Allow users to select the offices from a drop-down menu on the punchclock screen. 
   The default value is "yes". */

$punchclock_select_offices = "yes";

/* Allow users to select groups from a drop-down menu on the punchclock screen.
   The default is "yes". */

$punchclock_select_groups = "yes";

/* Employees can see a daily/weekly/overtime tally of their hours on the punchclock form and
   a link to see their timecard for the week. Set the $punchclock_display_timecard to "yes" to
   display a summary of the hours the employee has worked for the current day, the current week,
   and their possibly overtime hours (see the overtime configuration variables below). The default
   value is "yes". */

$punchclock_display_timecard = "yes";

/* This sets the refresh rate (in seconds) for entry.php. If the application is kept open,
   it will refresh every $entry_refresh seconds to display the most current info. Default
   is 300. Set it to "none" to ignore this option. */

$entry_refresh = "300";

/* Employees can see a daily/weekly/overtime tally of their hours on the entry form and
   a link to see their timecard for the week. Set the $entry_display_timecard to "yes" to
   display a summary of the hours the employee has worked for the current day, the current week,
   and their possibly overtime hours (see the overtime configuration variables below). The default
   value is "yes". */

$entry_display_timecard = "yes";

/* Overtime is computed by summing the total number of hours in a week over $overtime_week_limit.
   Set the limit to 0 if overtime is not to be computed. Set the $overtime_week_limit to the
   number of hours needed to work in a week before the time becomes overtime. Default value is 40. */

$overtime_week_limit = 35;

/* The day of the week starting a pay period can be specified by setting $begin_week_day to
   0 for Sunday, 1 for Monday, and so on. The default is 0 for Sunday. */

$begin_week_day = 0;

/* Timecards can list the punch-out entries on a separate line on the timecard report. Otherwise,
   only the punch-in times are displayed along with the hours worked. The default is "yes". */

$timecard_list_punch_outs = "yes";

/* Time can be displayed as a decimal hours (e.g. 1.50) or as hours and minutes (e.g. 1:30) 
   depending upon the setting of $timecard_display_hours_minutes. If it is set to "yes",
   time is shown as hours and minutes like 12:45. The default is "yes". */

$timecard_display_hours_minutes = "yes";

/* A running total of the weeks hours can be displayed in a column by setting the variable
   $timecard_display_running_total to "yes". If set to "no", the variable below
   $timecard_hours_include_overtime is set to "yes" and a total line is added to the
   timecard summing up the total hours for the week. "The default value is "no". */

$timecard_display_running_total = "no";

/* If a running total column is displayed on the timecard, The Hrs column on the timecard
   can display only the Regular hours worked during the period or it can display the sum
   of regular hours and overtime hours worked. The default is "no", display only the regular
   hours. */

$timecard_hours_include_overtime = "no";

/* Timecards sometimes have pseudo-lines entered by the software, for example, the line identifying
   the current time. The punchitem (task code) printed on the timecard for those lines is set
   by $timecard_punchitem configuration variable. The default value is simply "-". */

$timecard_punchitem = "-";

/* Removing In/Out status codes is allowed in Timeclock but the computation of hours and overtime in
   Punchclock timecards is incorrect without knowing if the status code was "In" or "Out". The
   $default_in_or_out setting can be set to 1 (In) or 0 (Out). The default value is 1. */

$default_in_or_out = 1;

/* --- DO NOT CHANGE ANYTHING BELOW THIS LINE!!! --- */

// Get the timeclock configuration variables.
include "$TIMECLOCK_PATH/config.inc.php";

// Time constants
$one_day = (24 * 60 * 60); // number of timestamp units (seconds) in a day
$one_week = (7 * 24 * 60 * 60); // number of timestamp units (seconds) in a week

?>
