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
  modified_by_ip   VARCHAR(39)  NOT NULL DEFAULT '',
  modified_by_user VARCHAR(50)  NOT NULL DEFAULT '',
  modified_when    BIGINT(14)   NOT NULL,
  modified_from    BIGINT(14)   NOT NULL,
  modified_to      BIGINT(14)   NOT NULL,
  modified_why     VARCHAR(250) NOT NULL DEFAULT '',
  user_modified    VARCHAR(50)  NOT NULL DEFAULT '',
  PRIMARY KEY (modified_when),
  UNIQUE KEY modified_when (modified_when)
) TYPE = MyISAM;

# --------------------------------------------------------

#
# dbversion table
#

UPDATE `dbversion`
SET `dbversion` = '1.4';

# --------------------------------------------------------

#
# info table
#

ALTER TABLE `info` ADD `ipaddress` VARCHAR(39) NOT NULL DEFAULT '';

# --------------------------------------------------------

#
# employees table
#

ALTER TABLE `employees` ADD `disabled` TINYINT(1) NOT NULL DEFAULT '0';

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
  modified_by   VARCHAR(50)  NOT NULL DEFAULT '',
  modified_when BIGINT(14)   NOT NULL,
  modified_from BIGINT(14)   NOT NULL,
  modified_to   BIGINT(14)   NOT NULL,
  modified_why  VARCHAR(250) NOT NULL DEFAULT '',
  PRIMARY KEY (modified_when),
  UNIQUE KEY modified_when (modified_when)
) TYPE = MyISAM;

# --------------------------------------------------------

#
# dbversion table
#

UPDATE `dbversion`
SET `dbversion` = '1.4';

# --------------------------------------------------------

#
# employees table
#

ALTER TABLE `employees` ADD `displayname` VARCHAR(50) NOT NULL DEFAULT '';
ALTER TABLE `employees` ADD `email` VARCHAR(75) NOT NULL DEFAULT '';
ALTER TABLE `employees` ADD `groups` VARCHAR(50) NOT NULL DEFAULT '';
ALTER TABLE `employees` ADD `office` VARCHAR(50) NOT NULL DEFAULT '';
ALTER TABLE `employees` ADD `admin` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `employees` ADD `reports` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `employees` ADD `time_admin` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `employees` ADD `disabled` TINYINT(1) NOT NULL DEFAULT '0';
INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');

# --------------------------------------------------------

#
# groups table
#

CREATE TABLE groups (
  groupname VARCHAR(50) NOT NULL DEFAULT '',
  groupid   INT(10)     NOT NULL AUTO_INCREMENT,
  officeid  INT(10)     NOT NULL DEFAULT '0',
  PRIMARY KEY (groupid)
) TYPE = MyISAM;

# --------------------------------------------------------

#
# info table
#

ALTER TABLE `info` CHANGE `inout` `inout` VARCHAR(50) NOT NULL;
ALTER TABLE `info` ADD `ipaddress` VARCHAR(39) NOT NULL DEFAULT '';

# --------------------------------------------------------

#
# offices table
#

CREATE TABLE offices (
  officename VARCHAR(50) NOT NULL DEFAULT '',
  officeid   INT(10)     NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (officeid)
) TYPE = MyISAM;

# --------------------------------------------------------

#
# punchlist table
#

ALTER TABLE `punchlist` CHANGE `punchitems` `punchitems` VARCHAR(50) NOT NULL;
ALTER TABLE `punchlist` ADD `in_or_out` TINYINT(1) DEFAULT '0' NOT NULL;
UPDATE `punchlist`
SET `in_or_out` = '1'
WHERE `punchitems` = 'in'
LIMIT 1;
UPDATE `punchlist`
SET `in_or_out` = '0'
WHERE `punchitems` = 'out'
LIMIT 1;
UPDATE `punchlist`
SET `in_or_out` = '0'
WHERE `punchitems` = 'break'
LIMIT 1;
UPDATE `punchlist`
SET `in_or_out` = '0'
WHERE `punchitems` = 'lunch'
LIMIT 1;
