<?php
echo "            <table width=100% border=0 cellpadding=0 cellspacing=0>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>System Settings</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Listed below are the 
                      settings that have been chosen within config.inc.php, the config file for PHP Timeclock.</td></tr>\n";
echo "              <tr><td height=40 class=table_rows width=10% align=left style='padding-left:4px;color:#27408b;'><b><u>VARIABLE</u></b></td>
                  <td class=table_rows width=10% align=left style='color:#27408b;'><b><u>VALUE</u></b></td>
                  <td class=table_rows width=80% align=left style='padding-left:10px;color:#27408b;'><b><u>DESCRIPTION</u></b></td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>MySql DB Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_hostname:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_hostname</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the hostname for your 
                      mysql server, default is <b>localhost</b>.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the name of the mysql 
                      database you created during the install.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_username:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_username</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the mysql username you 
                      created during the install.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_password:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>********</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the mysql password for 
                      the username you created during the install.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>db_prefix:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$db_prefix</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This adds a prefix to the 
                      tablenames in the database. This can be helpful if you have an existing mysql database that you would like to use with PHP 
                      Timeclock. If you are unaware of what is meant by 'table prefix', then please leave this option as is. Default is to leave it 
                      blank.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>dbversion:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$dbversion</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the versioning number of 
                      the current database for PHP Timeclock.</td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Passwords and Security</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_passwd:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$use_passwd</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This provides the option for the 
                      users to input their password when individually punching in/out of the timeclock. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_reports_password:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$use_reports_password</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>If ALL users need access to ALL 
                      the reports provided, then set this to \"no\". Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>restrict_ips:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$restrict_ips</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose \"yes\" to restrict the ip 
                      addresses that can connect to PHP Timeclock. If \"yes\" is chosen, you MUST input the allowed networks in the 
                      allowed_networks array below. Otherwise, choosing \"yes\" here and leaving allowed_networks blank will cause PHP Timeclock 
                      to reject everyone attempting to connect to it. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>allowed_networks:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>view these via the 'Edit System Settings' link on the left.</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are the networks or ip 
                      addresses you wish to allow to connect to PHP Timeclock. There is not a limit on how many networks or addresses that can be 
                      included in this array. This will currently only work for ipv4 addresses, ipv6 may be supported in a future release. If 
                      restrict_ips is set to \"no\", this option is ignored.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2: $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>ip_logging:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$ip_logging</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Enable the option to log the ip 
                      addresses of the connecting computers when users punch-in/out, or when a time is manually added, edited, or deleted.
                      Default is \"<b>yes</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>disable_sysedit:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$disable_sysedit</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choosing \"yes\" disables
                      ALL access to the Edit System Settings page (sysedit.php). It can be re-enabled in config.inc.php. Default is \"<b>no</b>\".
                 </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Dates and Times</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Choose the way dates and times are to be 
                      displayed throughout the entire application:</td></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' height=25 valign=bottom>calendar_style:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=bottom>$calendar_style</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=bottom>Default is \"<b>amer</b>\".
                      </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>datefmt:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$datefmt</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is 
                      \"<b>n/j/y</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>js_datefmt:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$js_datefmt</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is 
                      \"<b>M/d/yy</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>tmp_datefmt:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$tmp_datefmt</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is 
                      \"<b>m/d/yy</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>timefmt:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$timefmt</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is \"<b>g:i a</b>\".
                      </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Reports Settings</th></tr>\n";
echo "              <tr><td colspan=3 class=table_rows width=10% align=left style='padding-left:4px;'>Choose the way the reports are
                      formatted <u>by default</u>. Most of these default settings can be changed when the reports are run.</td></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>round_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$round_time</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose how to round 
                      the time worked within the reports for each user. This simply tells the report how to format the total hours worked for the 
                      Hours Worked Report. Default is \"<b>0</b>\", meaning do not round.
                      </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>paginate:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$paginate</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to paginate 
                      the Hours Worked report or not. Setting this option to \"yes\" will print each user's time on their own separate page. 
                      Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>show_details:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$show_details</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to show the 
                      punch-in/out details for each punch for each user on the Hours Worked report or not. Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>report_start_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$report_start_time</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These two variables, 
                      report_start_time and report_end_time, are designed to work with the Hours Worked report. They are there to provide a starting 
                      time to go along with the starting date, and an ending time to go along with the ending date for the dates specified when the report 
                      is run. Default is \"<b>00:00</b>\" (12:00am). 12 hour and 24 hour formats are supported.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>report_end_time:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$report_end_time</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is \"<b>23:59</b>\" 
                      (11:59pm). 12 hour and 24 hour formats are supported.</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>username_dropdown_only:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$username_dropdown_only</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this variable to \"yes\"
                      will display a single dropdown box containing usernames to choose from when running the reports. Setting this variable 
                      to \"no\" will instead display a triple dropdown box containing offices, groups, and usernames to choose from when running the 
                      reports. A single dropdown box works well if there are just a few usernames in the system, and a triple dropdown 
                      works well if multiple offices and/or groups are in the system. Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>user_or_display:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$user_or_display</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to print
                      displaynames or usernames for each user when reports are run. Options for this variable are \"user\" and \"display\".
                      Default is \"<b>user</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_ip:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_ip</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose whether to include
                      in the reports the ip addresses of the systems that connect to sign-in/out into PHP Timeclock or not. This option
                      is useful for auditing purposes. The <b>ip_logging</b> option must be set to \"<b>yes</b>\" in order for this option to work as 
                      expected. Default is \"<b>yes</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>export_csv:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$export_csv</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Choose \"<b>yes</b>\" to export 
                    the reports to a comma delimited file (.csv). Default is \"<b>no</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Timezone Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_client_tz:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$use_client_tz</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this option to \"yes\" 
                      will display the punch-in/out times according to the timezone of the connecting computer, providing javascript is enabled in the 
                      user's browser. Default is \"<b>no</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>use_server_tz:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$use_server_tz</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Setting this option to \"yes\" 
                      will display the punch-in/out times according to the timezone of the web server. Setting this option to \"no\" AND setting 
                      'use_client_tz' to \"no\" will display the punch-in/out times in GMT. Default is \"<b>yes</b>\".
                  </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Display Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>color1:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$color1</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>When times are displayed in PHP 
                      Timeclock, they are displayed with these two alternating row colors. Default is \"<b>#EFEFEF</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>color2:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$color2</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Default is \"<b>#FBFBFB</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_current_users:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_current_users</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only the current day's 
                      activity instead of the last entry from each user. Default is \"<b>no</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>show_display_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$show_display_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Show a user's Display Name 
                      instead of their username on the main page. Default is \"<b>no</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_office:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_office</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only a certain office on 
                      the main page of the application, instead of all the users. Default is \"<b>all</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_group:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_group</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display only a certain
                      group on the main page of the application, instead of a particular office, or all the users. If \"all\" is chosen for the
                      office, then you can choose any group in the list. This is there for if you have 2 or more groups with the same name, but with
                      each having a different parent office. In this case, if you wanted to display all members of the groups with the same name, you
                      could do this without having to choose an office. Default is \"<b>all</b>\".</td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_office_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_office_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a column on the main 
                      page that shows the office each user is affiliated with. Default is \"<b>no</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_group_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_group_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Display a column on the main 
                      page that shows the group each user is affiliated with. Default is \"<b>no</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_weather:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$display_weather</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>To display local weather info on 
                      the left side of the application just below the submit button, set this to \"yes\". Default is \"<b>no</b>\".
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>metar:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$metar</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the ICAO (International 
                      Civil Aviation Organization) for your local airport. This is the unique four letter international ID for the airport. METAR 
                      reports are created at roughly 4500 airports from around the world, so you probably live near one of them. The airports make a 
                      report once or twice an hour, and these reports are stored at the National Weather Service and are publically available via HTTP 
                      or FTP. Visit <a href='https://pilotweb.nas.faa.gov/qryhtml/icao/' class=admin_headings style='text-decoration:underline;'> 
                      https://pilotweb.nas.faa.gov/qryhtml/icao/</a> to find a corresponding ICAO near you. If 'display_weather' is set 
                      to \"no\", this option is ignored. If 'display_weather' is set to \"yes\", you MUST provide an ICAO here.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>city:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$city</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is the city and state (or 
                      can be city and country) of the airport for the ICAO used above. If 'display_weather' is set to \"no\", this option is ignored.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>links:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>";
if ($links == "none") {
echo "$links\n";
} else {
$tmp = count($links);
if ($tmp == "1") {
echo "$tmp link -- view it via the 'Edit System Settings' link on the left.\n";
} else {
echo "$tmp links -- view them via the 'Edit System Settings' link on the left.\n";
}
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are links to 
                            websites, other web-based applications, etc., that you wish to display in the topleft of the application just below the 
                            logo. Set it to \"none\" to ignore this option. 
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>display_links:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>";
if ($display_links == "none") {
echo "$display_links\n";
} else {
$tmp = count($display_links);
if ($tmp == "1") {
echo "$tmp link -- view it via the 'Edit System Settings' link on the left.\n";
} else {
echo "$tmp links -- view them via the 'Edit System Settings' link on the left.\n";
}
}
echo "                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>These are the display names 
                            for the links chosen above. The number of display names MUST equal the number of links you have chosen above. If the 'links' 
                            option above is set to \"none\", this option is ignored.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>logo:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$logo</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is a logo or graphic 
                      displayed in the top left of each page. Set it to \"none\" to ignore this option.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>refresh:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$refresh</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the refresh rate (in 
                      seconds) for the application. If PHP Timeclock is kept open, it will refresh this number of seconds to display the most current 
                      information. Set it to \"none\" to ignore this option. Default is <b>300</b>.
                  </td></tr>\n";
$row_count = '0'; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td nowrap style='border:solid #888888;border-width:0px 0px 1px 0px;' colspan=3>&nbsp;</td></tr>\n";
echo "              <tr><th colspan=3 class=table_heading_no_color nowrap align=left>Miscellaneous Settings</th></tr>\n";
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>email:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$email</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>This is an email address to 
                      display in the footer. Set it to \"none\" to ignore this option.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>date_link:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$date_link</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>If your users click on the 
                      displayed date in the top right of the application, they will be taken to this website. Set it to \"none\" to ignore this option. 
                      Default is 'This Day in History', <a href='http://www.historychannel.com/tdih' class=admin_headings 
                      style='text-decoration:underline;'><b>http://www.historychannel.com/tdih</b></a>.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>app_name:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$app_name</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the first half of the 
                      'title'.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>app_version:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$app_version</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the second half of the 
                      'title'.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "              <tr><td bgcolor='$row_color' class=table_rows width=10% align=left style='padding-left:4px;' valign=top>title:</td>
                  <td bgcolor='$row_color' class=table_rows width=10% align=left valign=top>$title</td>
                  <td bgcolor='$row_color' class=table_rows width=80% align=left style='padding-left:10px;' valign=top>Sets the title in the header. 
                      This is what is displayed in the title bar of your web browser, and it is what the page will be named by default when you make a 
                      \"favorite\" or \"bookmark\" in your web browser.
                  </td></tr>\n";
$row_count++; $row_color = ($row_count % 2) ? $color2 : $color1;
echo "            </table>\n";
?>
