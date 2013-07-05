# if you would like to utilize a table prefix when creating these tables, be sure to reflect that in config.inc.php so the program
# will be aware of it. this option is $db_prefix. if you are unaware of what is meant by utilizing a 'table prefix', then please disregard.

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
# Table structure for table `dbversion`
#

CREATE TABLE dbversion (
  dbversion decimal(5,1) NOT NULL default '0.0',
  PRIMARY KEY  (dbversion)
) TYPE=MyISAM;

#
# Dumping data for table `dbversion`
#

INSERT INTO dbversion VALUES ('1.4');

# --------------------------------------------------------

#
# Table structure for table `employees`
#

CREATE TABLE employees (
  empfullname varchar(50) NOT NULL default '',
  tstamp bigint(14) default NULL,
  employee_passwd varchar(25) NOT NULL default '',
  displayname varchar(50) NOT NULL default '',
  email varchar(75) NOT NULL default '',
  groups varchar(50) NOT NULL default '',
  office varchar(50) NOT NULL default '',
  admin tinyint(1) NOT NULL default '0',
  reports tinyint(1) NOT NULL default '0',
  time_admin tinyint(1) NOT NULL default '0',
  disabled tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (empfullname)
) TYPE=MyISAM;

#
# Dumping data for table `employees`
#

INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');

# --------------------------------------------------------

#
# Table structure for table `groups`
#

CREATE TABLE groups (
  groupname varchar(50) NOT NULL default '',
  groupid int(10) NOT NULL auto_increment,
  officeid int(10) NOT NULL default '0',
  PRIMARY KEY  (groupid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `info`
#

CREATE TABLE info (
  fullname varchar(50) NOT NULL default '',
  `inout` varchar(50) NOT NULL default '',
  timestamp bigint(14) default NULL,
  notes varchar(250) default NULL,
  ipaddress varchar(39) NOT NULL default '',
  KEY fullname (fullname)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `metars`
#

CREATE TABLE metars (
  metar varchar(255) NOT NULL default '',
  timestamp timestamp(14) NOT NULL,
  station varchar(4) NOT NULL default '',
  PRIMARY KEY  (station),
  UNIQUE KEY station (station)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `offices`
#

CREATE TABLE offices (
  officename varchar(50) NOT NULL default '',
  officeid int(10) NOT NULL auto_increment,
  PRIMARY KEY  (officeid)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `punchlist`
#

CREATE TABLE punchlist (
  punchitems varchar(50) NOT NULL default '',
  color varchar(7) NOT NULL default '',
  in_or_out tinyint(1) default NULL,
  PRIMARY KEY  (punchitems)
) TYPE=MyISAM;

#
# Dumping data for table `punchlist`
#

INSERT INTO punchlist VALUES ('in', '#009900', 1);
INSERT INTO punchlist VALUES ('out', '#FF0000', 0);
INSERT INTO punchlist VALUES ('break', '#FF9900', 0);
INSERT INTO punchlist VALUES ('lunch', '#0000FF', 0);

# --------------------------------------------------------


