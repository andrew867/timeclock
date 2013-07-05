<?php

/*
****************************************************************************
Be sure to set appropriate permissions on this file as it contains sensitive
username and password information!
****************************************************************************
*/


/* --- REQUIRED CHANGES --- */


/* mysql info --- $db_hostname is the hostname for your mysql server, default is localhost.
              --- $db_username is the mysql username you created during the install.
              --- $db_password is the mysql password for the username you created during
                  the install.
              --- $db_name is the mysql database you created during the install. */

$db_hostname = "localhost";
$db_username = "";
$db_password = "";
$db_name = "";


/* --- RECOMMENDED CHANGES --- */


/* This adds a prefix to the tablenames in the database. This can be helpful if you
   have an existing mysql database that you would like to use with PHP Timeclock.
   If you are unaware of what is meant by "table prefix", then please leave this
   option as is. Default is to leave it blank. */

$db_prefix = "";


/* Choose "yes" to restrict the ip addresses that can connect to PHP Timeclock. If
   "yes" is chosen, you MUST input the allowed networks in the $allowed_networks
   array below. Otherwise, choosing "yes" here and leaving $allowed_networks
   blank will cause PHP Timeclock to reject everyone attempting to connect to it.
   Default is "no". */

$restrict_ips = "no";


/* Insert the networks or ip addresses you wish to allow to connect to PHP Timeclock
   into the $allowed_networks array below. There is not a limit on how many networks
   or addresses that can be included in this array. This will currently only work for
   ipv4 addresses, ipv6 may be supported in a future release. If $restrict_ips is
   set to "no", this option is ignored.

   * will work:
   * xxx.xxx.xxx.xxx        (exact)
   * xxx.xxx.xxx.[yyy-zzz]  (range)
   * xxx.xxx.xxx.xxx/nn     (CIDR)
   *
   * will NOT work:
   * xxx.xxx.xxx.xx[yyy-zzz]  (range, partial octets not supported)
   * xxx.xxx.xxx.yyy - xxx.xxx.xxx.zzz (range, entire networks not supported).
   * xxx.xxx. (range, less than 4 octets not supported).

   example --> $allowed_networks = array("10.0.0.4","192.168.1.[11-20]","192.168.4.0/24","192.0.0.0/8");
*/

$allowed_networks = array();


/* Choose "yes" if you want to disable the Edit System Settings page within PHP 
   Timeclock. This page allows you to make *most* of your changes to the 
   config.inc.php file through the PHP Timeclock interface instead of editing 
   the config.inc.php file by hand. Many will view this as a possible security risk  
   and might would rather disable this functionality. Default is "no". */

$disable_sysedit = "no";


/* Choose whether to use encrypted passwords along with the usernames. Options are
   "yes" or "no". If "yes" is chosen, users will be required to enter a password
   whenever they change their status. Default is "no". */

$use_passwd = "no";


/* If you only want certain users to have the ability to view and run the reports, 
   change $use_reports_password to "yes". Default is "no"; */

$use_reports_password = "no";


/* Enable the option to log the ip addresses of the connecting computers when users
   punch-in/out, or when a time is manually added, edited, or deleted. Default is
   "yes". */

$ip_logging = "yes";


/* An email address to display in the footer (footer.php). Set it to "none" to ignore
   this option. */

$email = "none";


/* --- OPTIONAL CHANGES --- */


/* Choose the way dates are displayed. DO NOT EDIT THESE DATE VARIABLES MANUALLY UNLESS YOU 
   KNOW WHAT YOU ARE DOING. Instead, change these date variables via the Edit System Settings
   page in the Administration section of PHP Timeclock (sysedit.php). $datefmt default is 
   "n/j/y", $js_datefmt default is "M/d/yy", $tmp_datefmt default is "m/d/yy", and 
   $calendar_style default is "amer". You will need to choose date formats with matching 
   numbers, ie: if format number 10 is used for $datefmt, then format number 10 will need to 
   be used for $js_format and $tmp_format as well. "euro" will need to be chosen for date 
   format numbers 1-6, and "amer" will need to be chosen for date format numbers 7-12. 
   Again, if you are confused, i urge you to change these settings via the Edit System 
   Settings page in the Administration Section. Choosing mismatched options will lead to 
   much confusion and plenty of headaches later.

   Possibilities for these variables are:

   $calendar_style --> 1) amer
                       2) euro

   $datefmt --> 1) j.n.Y       $js_datefmt --> 1) d.M.yyyy       $tmp_datefmt --> 1) d.m.yyyy
                2) j/n/Y                       2) d/M/yyyy                        2) d/m/yyyy
                3) j-n-Y                       3) d-M-yyyy                        3) d-m-yyyy
                4) j.n.y                       4) d.M.yy                          4) d.m.yy
                5) j/n/y                       5) d/M/yy                          5) d/m/yy
                6) j-n-y                       6) d-M-yy                          6) d-m-yy
                7) n.j.Y                       7) M.d.yyyy                        7) m.d.yyyy
                8) n/j/Y                       8) M/d/yyyy                        8) m/d/yyyy
                9) n-j-Y                       9) M-d-yyyy                        9) m-d-yyyy
               10) n.j.y                      10) M.d.yy                         10) m.d.yy
               11) n/j/y                      11) M/d/yy                         11) m/d/yy
               12) n-j-y                      12) M-d-yy                         12) m-d-yy */

$datefmt = "n/j/Y";
$js_datefmt = "M/d/yyyy";
$tmp_datefmt = "m/d/yyyy";
$calendar_style = "amer";


/* Choose the way times are displayed. Default is "g:i a".

   Possibilities for this variable are:

   $timefmt --> 1) G:i
                2) H:i
                3) g:i A
                4) g:i a
                5) g:iA
                6) g:ia    */

$timefmt = "g:i a";


/* Display only activity for the the current day instead of the last entry from each user.
   Default is "no". */

$display_current_users = "no";


/* Show a Display Name instead of a Username for each user on the main page.
   Default is "no". */

$show_display_name = "no";


/* Display punch-in/out times for only a certain office on the main page of the application.
   Replace "all" with the office you wish to display below. Default is "all". */

$display_office = "all";


/* Display punch-in/out times for only a certain group on the main page of the application.
   Replace "all" with the group you wish to display below. Default is "all". */

$display_group = "all";


/* Display a column on the main page that shows the office each person is affiliated with. 
   Default is "no". */

$display_office_name = "no";


/* Display a column on the main page that shows the group each person is affiliated with. 
   Default is "no". */

$display_group_name = "no";


/* A logo or graphic, this is displayed in the top left of each page.
   Set it to "none" to ignore this option. */

$logo = "images/logos/phptimeclock.png";


/* This sets the refresh rate (in seconds) for index.php. If the application is kept open,
   it will refresh every $refresh seconds to display the most current info. Default
   is 300. Set it to "none" to ignore this option. */

$refresh = "300";


/* This creates a clickable date in the top right of each page. By Default, it links to 
   "This Day in History" on the historychannel.com website. Set it to "none" to ignore this option. */

$date_link = "http://www.historychannel.com/tdih";


/* These are alternating row colors for the main page and for reports. */

$color1 = "#EFEFEF";
$color2 = "#FBFBFB";


/* Insert/change/delete below the ACTUAL links to websites you wish to display in the
   topleft side of each page (leftmain.php). These links can link to anything you want
   them to -- websites, other web-based applications, etc. Default number of links is 6.
   Set $links to "none" to ignore this option. Ex: $links = "none"; */

$links = array("http://slashdot11.org/","http://slashdot22.org/","http://slashdot33.org/","http://slashdot44.org/","http://slashdot55.org/","http://slashdot66.org/");


/* Insert/change/delete below the display names for the links you inserted above. 
   If $links is set to "none", this option is ignored. */

$display_links = array("Book a Meeting Room","Google News","Mailing Lists","Slashdot","Vacation Calendar");


/* --- REPORTING INFO --- */


/* The settings in this section are simply default settings. They can easily be changed each
   time you run a report. */

/* Choose whether to paginate the Hours Worked report or not. Setting this option to "yes"
   will print the totals for each user on their own page. Default is "yes". */

$paginate = "yes";


/* Choose whether to show the punch-in/out details for each punch for each user on the 
   Hours Worked report or not. Default is "yes". */

$show_details = "yes";


/* Choose how to round the time worked within the Hours Worked report for each user. This
   simply tells the report how to format the total hours worked for the Hours Worked Report.
   Default is "0".

   Possibilities for this variable are:

   $round_time --> 0) Do not round.
                   1) Round to the nearest 5 minutes.
                   2) Round to the nearest 10 minutes.
                   3) Round to the nearest 15 minutes.
                   4) Round to the nearest 20 minutes.
                   5) Round to the nearest 30 minutes.                                     */

$round_time = "0";


/* The two variables below, $report_start_time and $report_end_time, are designed to work with
   the Hours Worked report. They are there to give you a starting time to go along with the
   starting date, and an ending time to go along with the ending date for the dates specified
   when the report is run. Default is 00:00 (12:00am) for $report_start_time and
   23:59 (11:59pm) for $report_end_time. 12 hour and 24 hour formats are supported. */

$report_start_time = "00:00";
$report_end_time = "23:59";


/* Setting this variable to "yes" will display a single dropdown box containing usernames 
   to choose from when running the reports. Setting this variable to "no" will instead 
   display a triple dropdown box containing offices, groups, and usernames to choose from 
   when running the reports. A single dropdown box works well if there are just a few 
   usernames in the system, and a triple dropdown works well if multiple offices and/or 
   groups are in the system. Default is "no". */

$username_dropdown_only = "no";


/* Choose whether to print displaynames or usernames for each user when reports are run.
   Options for this variable are "user" and "display". Default is "user". */

$user_or_display = "user";


/* Choose whether to include in the reports the ip addresses of the systems that connect to 
   sign-in/out into PHP Timeclock or not. This option is useful for auditing purposes. The 
   ip_logging option must be set to "yes" in order for this option to work as expected.
   Default is "yes". */

$display_ip = "yes";


/* Reports can be exported to a comma delimited file (.csv). Setting this to "yes" will
   export the reports to .csv files. Default is "no" */

$export_csv = "no";


/* --- TIMEZONE INFO --- */


/* If you have users who are in different timezones, you may wish to display the punch-in/out
   times according to the timezone they are currently in. Setting this option to "yes" will
   display the punch-in/out times in the timezone of their connecting systems. The timezone
   info is pulled from the web browser of the user via javascript and stored in a cookie on their
   system. The default setting is "no". */

$use_client_tz = "no";


/* To display the punch-in/out times in the timezone of the web server, leave this option set
   to "yes". Setting this option to "no" AND setting the above $use_client_tz option to "no",
   will display the punch-in/out times in GMT. Default is "yes". */

$use_server_tz = "yes";


/* --- WEATHER INFO ---  */


/* Include local weather info on the left side of the main page just below the Submit button.
   If you would like to include this feature, set $display_weather to "yes". Default is "no". */

$display_weather = "no";


/* ICAO (International Civil Aviation Organization) for your local airport. This is the
   unique four letter international ID for the airport. METAR reports are created at
   roughly 4500 airports from around the world, so you probably live near one of them.
   The airports make a report once or twice an hour, and these reports are stored at the
   National Weather Service and are publically available via HTTP or FTP. Visit
   https://pilotweb.nas.faa.gov/qryhtml/icao/ to find a corresponding ICAO near you. If
   $display_weather is set to "no", this option is ignored. If $display_weather is set to
   "yes", you MUST provide an ICAO here. */

$metar = "KJAN";


/* This is the city and country (or can be city and state) of the airport for
   the ICAO used above. The max length for this field is 100 characters.
   If $display_weather is set to "no", this option is ignored. */

$city = "Jackson, Mississippi";


/* --- APP NAME, VERSION NUMBER, ETC. --- */


$app_name = "PHP Timeclock";
$app_version = "1.04";

/* Sets the title in the header. This is what the page will be named by default when you
   make a "favorite" or "bookmark" in your browser. Change as you see fit. */

$title = "$app_name $app_version";


/* --- DO NOT CHANGE ANYTHING BELOW THIS LINE!!! --- */


$dbversion = "1.4";
?>
