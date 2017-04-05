
ALTER TABLE `employees` ADD `barcode`   varchar(75) COLLATE utf8_bin UNIQUE;
ALTER TABLE `punchlist` ADD `punchnext` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '';

UPDATE `dbversion` SET `dbversion` = '1.5';
