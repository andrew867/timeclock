# if you would like to utilize a table prefix when creating these tables, be sure to reflect that in config.inc.php so the program
# will be aware of it. this option is $db_prefix. if you are unaware of what is meant by utilizing a 'table prefix', then please disregard.

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `modified_by_ip` varchar(39) COLLATE utf8_bin NOT NULL DEFAULT '',
  `modified_by_user` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `modified_when` bigint(14) NOT NULL,
  `modified_from` bigint(14) NOT NULL,
  `modified_to` bigint(14) NOT NULL,
  `modified_why` varchar(250) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_modified` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `dbversion`
--

CREATE TABLE `dbversion` (
  `dbversion` decimal(5,1) NOT NULL DEFAULT '0.0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO dbversion VALUES ('1.4');
-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `empfullname` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `tstamp` bigint(14) DEFAULT NULL,
  `employee_passwd` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '',
  `displayname` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `email` varchar(75) COLLATE utf8_bin NOT NULL DEFAULT '',
  `groups` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `office` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `reports` tinyint(1) NOT NULL DEFAULT '0',
  `time_admin` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupname` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `groupid` int(10) NOT NULL,
  `officeid` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `fullname` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `inout` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timestamp` bigint(14) DEFAULT NULL,
  `notes` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `ipaddress` varchar(39) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `metars`
--

CREATE TABLE `metars` (
  `metar` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timestamp` timestamp NOT NULL,
  `station` varchar(4) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `officename` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `officeid` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `punchlist`
--

CREATE TABLE `punchlist` (
  `punchitems` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '',
  `color` varchar(7) COLLATE utf8_bin NOT NULL DEFAULT '',
  `in_or_out` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`modified_when`),
  ADD UNIQUE KEY `modified_when` (`modified_when`);

--
-- Indexes for table `dbversion`
--
ALTER TABLE `dbversion`
  ADD PRIMARY KEY (`dbversion`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`empfullname`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD KEY `fullname` (`fullname`);

--
-- Indexes for table `metars`
--
ALTER TABLE `metars`
  ADD PRIMARY KEY (`station`),
  ADD UNIQUE KEY `station` (`station`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`officeid`);

--
-- Indexes for table `punchlist`
--
ALTER TABLE `punchlist`
  ADD PRIMARY KEY (`punchitems`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `officeid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  
  --
  -- Insert default data. Version, admin login, etc. 
  --
  
  INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');
  INSERT INTO dbversion VALUES ('1.4');
  INSERT INTO punchlist VALUES ('in', '#009900', 1);
  INSERT INTO punchlist VALUES ('out', '#FF0000', 0);
  INSERT INTO punchlist VALUES ('break', '#FF9900', 0);
  INSERT INTO punchlist VALUES ('lunch', '#0000FF', 0);
  