TimeClock PHP7
=====
About
=====

This project is the PHP7 compatible PHP Timeclock v1.04 with the Punchclock add-on already installed.

This Fork - What Is It?
=======================
-  major refactor of DB functions ->mysqli.
-  major refactor of project functions to adapt & work with mysqli functions.
-  major upgrade to php code removed deprecated functions introduced compatible functions with PHP7.
-  refactored code that was ambiguous simplified some code.
-  fixed all warning and notices that caused some issues and bugs on the project.
-  changes may not be optimal but are enough to get the project working with php7.
-  audit log page does not display data for me on my tests (this could be an issue from before) could be fixed not a major issue.

Timeclock - What Is It?
=======================

(from http://timeclock.sf.net/ ...)

It is a simple yet effective web-based timeclock system. It allows you to track all employee time as well as upcoming vacations and more, and it can replace manual sign-in/sign-out sheets.

An administration piece is included which allows an administrator to add or delete users, change a user's time or password (if using passwords is enabled), and hide the reports from your users where only an admin or a reports user has access to them. These reports can be run to show daily activity or for a range of dates, and can be run for all users, or individually for each user.

This product is distributed under the GPL. This program is free software; you can redistribute it and/or modify it under the terms of the GNU GeneralPublic License version 2, as published by the Free Software Foundation.


Punchclock - What Is It?
========================

(from http://www.acmebase.org/punchclock/ ...)

Punchclock is a drop-in enhancement to the Open Source PHP Timeclock software.

Punchclock enhances PHP Timeclock with 5 extra features:

    Computes overtime hours.
    Keeps time cards for each employee.
    Punchclock entry intended to replace your punchclock at the door.
    Personal data entry screen for office personnel and mobile devices.
    Flexible export to your spreadsheet or business software.

PHP Timeclock
Version 1.04
http://sourceforge.net/projects/timeclock
Copyright (C) 2006 Ken Papizan <pappyzan_at_users.sourceforge.net>


REQUIREMENTS:

 -  at least PHP 5.6, with mysql support
 -  MySQL
 -  Webserver

TESTED:

 -  PHP 5.6, 7.2 with mysql support
 -  MySQL 3.23.49, 4.0.17, 5.0.18
 -  Apache 1.3.22, 1.3.29, 2.2.0
 -  Firefox 1.0 - 1.5.0.4, Firefox 1.0 Preview Release, IE 6.0 SP1, IE 6.0 SP2 for XP, IE 7.0 beta 2

Any version of mysql or webserver software that supports php, whether it's an earlier
version than what's tested or later, will probably work fine.



##Installation

New Install
___

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


Migration from another verison of 1.04 (ie: old official release)
___

 -  Backup your current install directory and database.
 -  Delete all files in your current install directory.
 -  Copy all files from a zip of this repo's master branch (https://github.com/andrew867/timeclock/archive/master.zip) into your install directory.
 -  Modify the new `config.inc.php` file to match your old settings, make sure you correctly set your timezone in php.ini (recommended) or `config.inc.php`.


##Roles
Admin level access and reports level access are completely separate from each other. Just because a user has admin level access does not give that user reports level access. You must specifically give them reports level access when you are creating or editing the users, if you choose to secure these reports for these users. To make PHP Timeclock lock down the reports to only these users, set the use_reports_password setting in config.inc.php to "yes".


##License
________

This software and changes made are licensed under the GNU GENERAL PUBLIC LICENSE 2 as found in docs/LICENSE
