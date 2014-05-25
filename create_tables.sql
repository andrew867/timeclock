# if you would like to utilize a table prefix when creating these tables, be sure to reflect that in config.inc.php so the program
# will be aware of it. this option is $db_prefix. if you are unaware of what is meant by utilizing a 'table prefix', then please disregard.

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
)
  ENGINE =MyISAM;

# --------------------------------------------------------

#
# Table structure for table `dbversion`
#

CREATE TABLE dbversion (
  dbversion DECIMAL(5, 1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (dbversion)
)
  ENGINE =MyISAM;

#
# Dumping data for table `dbversion`
#

INSERT INTO dbversion VALUES ('1.4');

# --------------------------------------------------------

#
# Table structure for table `employees`
#

CREATE TABLE employees (
  empfullname     VARCHAR(50) NOT NULL DEFAULT '',
  tstamp          BIGINT(14) DEFAULT NULL,
  employee_passwd VARCHAR(25) NOT NULL DEFAULT '',
  displayname     VARCHAR(50) NOT NULL DEFAULT '',
  email           VARCHAR(75) NOT NULL DEFAULT '',
  groups          VARCHAR(50) NOT NULL DEFAULT '',
  office          VARCHAR(50) NOT NULL DEFAULT '',
  admin           TINYINT(1)  NOT NULL DEFAULT '0',
  reports         TINYINT(1)  NOT NULL DEFAULT '0',
  time_admin      TINYINT(1)  NOT NULL DEFAULT '0',
  disabled        TINYINT(1)  NOT NULL DEFAULT '0',
  PRIMARY KEY (empfullname)
)
  ENGINE =MyISAM;

#
# Dumping data for table `employees`
#

INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');

# --------------------------------------------------------

#
# Table structure for table `groups`
#

CREATE TABLE groups (
  groupname VARCHAR(50) NOT NULL DEFAULT '',
  groupid   INT(10)     NOT NULL AUTO_INCREMENT,
  officeid  INT(10)     NOT NULL DEFAULT '0',
  PRIMARY KEY (groupid)
)
  ENGINE =MyISAM;

# --------------------------------------------------------

#
# Table structure for table `info`
#

CREATE TABLE info (
  fullname  VARCHAR(50) NOT NULL DEFAULT '',
  `inout`   VARCHAR(50) NOT NULL DEFAULT '',
  timestamp BIGINT(14) DEFAULT NULL,
  notes     VARCHAR(250) DEFAULT NULL,
  ipaddress VARCHAR(39) NOT NULL DEFAULT '',
  KEY fullname (fullname)
)
  ENGINE =MyISAM;

# --------------------------------------------------------

#
# Table structure for table `metars`
#

CREATE TABLE metars (
  metar     VARCHAR(255) NOT NULL DEFAULT '',
  timestamp TIMESTAMP    NOT NULL,
  station   VARCHAR(4)   NOT NULL DEFAULT '',
  PRIMARY KEY (station),
  UNIQUE KEY station (station)
)
  ENGINE =MyISAM;

# --------------------------------------------------------

#
# Table structure for table `offices`
#

CREATE TABLE offices (
  officename VARCHAR(50) NOT NULL DEFAULT '',
  officeid   INT(10)     NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (officeid)
)
  ENGINE =MyISAM;

# --------------------------------------------------------

#
# Table structure for table `punchlist`
#

CREATE TABLE punchlist (
  punchitems VARCHAR(50) NOT NULL DEFAULT '',
  color      VARCHAR(7)  NOT NULL DEFAULT '',
  in_or_out  TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (punchitems)
)
  ENGINE =MyISAM;

#
# Dumping data for table `punchlist`
#

INSERT INTO punchlist VALUES ('in', '#009900', 1);
INSERT INTO punchlist VALUES ('out', '#FF0000', 0);
INSERT INTO punchlist VALUES ('break', '#FF9900', 0);
INSERT INTO punchlist VALUES ('lunch', '#0000FF', 0);

# --------------------------------------------------------


