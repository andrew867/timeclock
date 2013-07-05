
# if you would like to utilize a table prefix when upgrading these tables, be sure to use the one you have setup in config.inc.php.
# this option is $db_prefix.  if you are unaware of what is meant by utilizing a 'table prefix', then please disregard.


###################################################################
#                                                                 #
# If upgrading from version 1.01 or 1.0, run these sql statements #
# below on the PHP Timeclock database.                            #
#                                                                 #
###################################################################

#
# Table structure for table `audit`
#

CREATE TABLE audit (
  modified_by_ip varchar(39) NOT NULL default '',
  modified_by_user varchar(50) NOT NULL default '',
  modified_when bigint(14) NOT NULL,
  modified_from bigint(14) NOT NULL,
  modified_to bigint(14) NOT NULL,
  modified_why varchar(250) NOT NULL default '',
  user_modified varchar(50) NOT NULL default '',
  PRIMARY KEY  (modified_when),
  UNIQUE KEY modified_when (modified_when)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# dbversion table
#

UPDATE `dbversion` SET `dbversion` = '1.4';

# --------------------------------------------------------

#
# info table
#

ALTER TABLE `info` ADD `ipaddress` VARCHAR(39) NOT NULL default '';

# --------------------------------------------------------

#
# employees table
#

ALTER TABLE `employees` ADD `disabled` TINYINT(1) NOT NULL default '0';

# --------------------------------------------------------


########################################################################
#                                                                      #
# If upgrading from version 0.9.4-1 or 0.9.4, run these sql statements #
# below on the PHP Timeclock database.                                 #
#                                                                      #
########################################################################

#
# Table structure for table `audit`
#

CREATE TABLE audit (
  modified_by varchar(50) NOT NULL default '',
  modified_when bigint(14) NOT NULL,
  modified_from bigint(14) NOT NULL,
  modified_to bigint(14) NOT NULL,
  modified_why varchar(250) NOT NULL default '',
  PRIMARY KEY  (modified_when),
  UNIQUE KEY modified_when (modified_when)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# dbversion table
#

UPDATE `dbversion` SET `dbversion` = '1.4';

# --------------------------------------------------------

#
# employees table
#

ALTER TABLE `employees` ADD `displayname` VARCHAR(50) NOT NULL default '';
ALTER TABLE `employees` ADD `email` VARCHAR(75) NOT NULL default '';
ALTER TABLE `employees` ADD `groups` VARCHAR(50) NOT NULL default '';
ALTER TABLE `employees` ADD `office` VARCHAR(50) NOT NULL default '';
ALTER TABLE `employees` ADD `admin` TINYINT(1) NOT NULL default '0';
ALTER TABLE `employees` ADD `reports` TINYINT(1) NOT NULL default '0';
ALTER TABLE `employees` ADD `time_admin` TINYINT(1) NOT NULL default '0';
ALTER TABLE `employees` ADD `disabled` TINYINT(1) NOT NULL default '0';
INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');

# --------------------------------------------------------

#
# groups table
#

CREATE TABLE groups (
  groupname varchar(50) NOT NULL default '',
  groupid int(10) NOT NULL auto_increment,
  officeid int(10) NOT NULL default '0',
  PRIMARY KEY  (groupid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# info table
#

ALTER TABLE `info` CHANGE `inout` `inout` VARCHAR(50) NOT NULL;
ALTER TABLE `info` ADD `ipaddress` VARCHAR(39) NOT NULL default '';

# --------------------------------------------------------

#
# offices table
#

CREATE TABLE offices (
  officename varchar(50) NOT NULL default '',
  officeid int(10) NOT NULL auto_increment,
  PRIMARY KEY  (officeid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# punchlist table
#

ALTER TABLE `punchlist` CHANGE `punchitems` `punchitems` VARCHAR(50) NOT NULL;
ALTER TABLE `punchlist` ADD `in_or_out` TINYINT(1) DEFAULT '0' NOT NULL;
UPDATE `punchlist` SET `in_or_out` = '1' WHERE `punchitems` = 'in' LIMIT 1;
UPDATE `punchlist` SET `in_or_out` = '0' WHERE `punchitems` = 'out' LIMIT 1;
UPDATE `punchlist` SET `in_or_out` = '0' WHERE `punchitems` = 'break' LIMIT 1;
UPDATE `punchlist` SET `in_or_out` = '0' WHERE `punchitems` = 'lunch' LIMIT 1;
