# About

This project is PHP Timeclock with the Punchclock add-on already installed.

# This Fork

I replaced the phpweather in the left hand sidebar with the saratoga-weather display, which works, and just looks nicer. 
See (http://saratoga-weather.org/metars.php) for examples, the original code can be downloaded from 
(http://saratoga-weather.org/scripts-metar.php#metar).   

Added two variables in `config.inc.php` to support the improved weather display `$WxTimeZone` and `$WxList`. 

All calls to the various *mysql_* functions have been replaced with calls to *mysqli* functions 
where they are compatible, or re-written where nessesary. 

The various problems with un-initialized variables have been fixed. 

All calls to ereg() have been replaced with calls to preg_match and 
the regular expressions edited as needed. 

Function calls in the `lib.timeclock.php` which were passing functions as parameters were not quoting 
the function names being passed, resulting in "Undefined constant" errors.  All of those have been fixed. 

As of 25 January 2017, the system now works in PHP 5.6 and mysql 5.7. 


# Timeclock - What Is It?

(from http://timeclock.sf.net/ ...)

It is a simple yet effective web-based timeclock system. It allows you to track all employee time 
as well as upcoming vacations and more, and it can replace manual sign-in/sign-out sheets.

An administration piece is included which allows an administrator to add or delete users, change a 
user's time or password (if using passwords is enabled), and hide the reports from your users where 
only an admin or a reports user has access to them. These reports can be run to show daily activitiy 
or for a range of dates, and can be run for all users, or individually for each user.

This product is distributed under the GPL. This program is free software; you can redistribute it and/or 
modify it under the terms of the GNU GeneralPublic License version 2, as published by the 
Free Software Foundation.


# Punchclock - What Is It?

(from http://www.acmebase.org/punchclock/ ...)

Punchclock is a drop-in enhancement to the Open Source PHP Timeclock software. 

Punchclock enhances PHP Timeclock with 5 extra features:

 - Computes overtime hours.
 - Keeps time cards for each employee.
 - Punchclock entry intended to replace your punchclock at the door.
 - Personal data entry screen for office personnel and mobile devices.
 - Flexible export to your spreadsheet or business software.
    
## PHP Timeclock source credits
- Copyright (C) 2006 Ken Papizan <pappyzan_at_users.sourceforge.net>


### REQUIREMENTS:

 -  at least PHP 5.3.x, with mysqli support
 -  MySQL
 -  Webserver

### TESTED:

 -  PHP 5.6.19 with mysqli support
 -  MySQL 5.7.22
 -  Apache 2.4.18
 
Any version of mysql or webserver software that supports php, whether it's an earlier 
version than what's tested or later, will probably work fine.

##Installation

### New Install

 - Unpack the distribution into your webserver's document root directory. 
 - Create a database named "timeclock" or whatever you wish to name it.
 - Create a mysql user named "timeclock" (or whatever you wish to name it) with a password.
 - Give this user at least SELECT, UPDATE, INSERT, DELETE, ALTER, and CREATE privileges to ONLY 
    this database.
 -  Import the tables using the create_tables.sql script included in this distribution.
 -  Edit config.inc.php.
 -  Open index.php with your web browser.
 -  Click on the Administration link on the right side of the page. Input "admin" (without the quotes) 
    for the username and "admin" (without the quotes) for the password. Please change the password 
    for this admin user after the initial setup of PHP Timeclock is complete.
 -  Create at least one office by clicking on the Create Office link on the left side of the page. 
    You MUST create an office to achieve the desired results. Create more offices if needed.
 -  Create at least one group by clicking on the Create Group link on the left side of the page. 
    You MUST create a group to achieve the desired results. Create more groups if needed.
 -  Add your users by clicking on the Create New Users link, and assign them to the office(s) and
    group(s) you created above. Give Sys Admin level access for users who will administrate 
    PHP Timeclock. Give Time Admin level access for users who will need to edit users' time, but 
    who will not need Sys Admin level access. If you require the reports to be secured so only 
    certain users can run them, then give these users reports level access. 


### Migration from another verison (ie: old official release)

 -  Backup your current install directory and database.
 -  Delete all files in your current install directory.
 -  Copy all files from a zip of this repo's master branch 
 (https://github.com/boatright/timeclock/archive/master.zip) into your install directory.
 -  Modify the new `config.inc.php` file to match your old settings, make sure you correctly 
 set your timezone in php.ini (recommended) or `config.inc.php`.
 - See the notes in config.inc.php about entering the new variables for weather display. 

# FAQs

##Roles

Admin level access and reports level access are completely separate from each other. 
Just because a user has admin level access does not give that user reports level access. 
You must specifically give them reports level access when you are creating or editing the users, 
if you choose to secure these reports for these users. To make PHP Timeclock lock down the 
reports to only these users, set the use_reports_password setting in config.inc.php to "yes".


##License

This software and changes made are licensed under the GNU GENERAL PUBLIC LICENSE 2 as found in docs/LICENSE
