--# ====================================================================
--# Variables in the script added by Jammi Dee
--# 05/09/2012
--# This will make the dbwaveerp script a little bit flexible.
--# ====================================================================
set @varEntity 		  = 'LALULLA';
set @varAdminID 	  = 'SADMIN';
set @varRootID 		  = '000000';
set @varStartDate   =  DATE_FORMAT(curdate(), '%Y-%m-%d');
set @varEndDate     =  DATE_ADD(@varStartDate, INTERVAL 365 DAY);
set @varStartTime   =  DATE_FORMAT(curdate(), '%H:%i:%S');


drop database if exists cgone;
create database if not exists cgone;

use cgone;

-- Date: 02/02/2025
-- Created By : Jammi Dee jammi_dee@yahoo.com

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id`              int(11) NOT NULL AUTO_INCREMENT,
  `photo`           varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name`            varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mobile`          varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `package`         varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `area`            varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `staff`           varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount`          varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `user_id`         varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password`        varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `join_date`       varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `advance`         varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email`           varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pass`            varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location`        varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `role`            varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status`          varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `router_id`       int(11) NOT NULL DEFAULT '1',
  `lat`             decimal(10,6) NOT NULL DEFAULT '0.000000',
  `lon`             decimal(10,6) NOT NULL DEFAULT '0.000000',
  `model`           varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `serial_no`       varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N/A',
  `number_of_ports` int(11) NOT NULL DEFAULT '0',
  `wan_bandwidth`   int(11) NOT NULL DEFAULT '0',
  `property_id`     varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NONE',
  `remarks`         text COLLATE utf8_unicode_ci,
  `pppoe_name`      varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pppoe_password`  varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pppoe_service`   varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pppoe_profile`   varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hotspot_server`  varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hotspot_name`    varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hotspot_pass`    varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hotspot_profile` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `routerip`        varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'IP address of the router',
  `routerport`      int(11) DEFAULT NULL COMMENT 'The port being used by the router',
  `routeradm`       varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The router admin account name',
  `routerpass`      varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The password for the router',
  `petc_code`       varchar(20) COLLATE utf8_unicode_ci DEFAULT 'NA',
  `search_quota`    int(11) DEFAULT '100',
  `starttime`       int(11) DEFAULT '0',
  `endtime`         int(11) DEFAULT '24',
  `search_unli`     tinyint(1) DEFAULT '0',
  `time_unli`       tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=377 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--# ====================================================================
--# Project       : Wave ERP Framework
--# Description   : Table for handling Table information in the system
--# Owner         : Jammi Dee
--# Date          : 10/10/2015
--# Revision      : 1.0.0 
--# Last Modified : 10/10/2015
--# Modified By   : Jammi Dee
--#
--#					The initial data of this table must be coming from
--#					the scripts executed during database configuration.
--#
--#					tabletype = SYS, APP
--#					appowner 	= determines the application that owns the
--#								the table. Usually the application ID
--#
--#
--# ====================================================================
drop table if exists systables;
create table systables(
 id           int             NOT NULL AUTO_INCREMENT,
 entityid 		varchar(20) 		default "_NA_",
 dbname 			varchar(200) 		default "CGONE",
 tabname 			varchar(200) 		default "_NA_",
 tabdesc 			varchar(200) 		default "_NA_",
 tabsql 			varchar(5000) 	default "_NA_",
 tablegrp			varchar(20) 		default '_NA_',
 tabletype		varchar(20) 		default 'SYS',
 appowner			varchar(20) 		default 'SYS',
 colcount			int					    default 0,
 sstatus 			varchar(20) 		default 'ACTIVE',
 deleted 			int 			      default 0,

 PRIMARY KEY 	(id)

);

--# Fill up the uniq key of table
--# added by Jammi Dee 10/10/2015
drop trigger if exists newtblSysTables;
CREATE TRIGGER newtblSysTables
BEFORE INSERT ON tblSysTables
FOR EACH ROW SET NEW.juid = UUID();

--# Added by Jammi Dee 10/10/2015
insert into systables(entityid, dbname, tabname, tabdesc, tablegrp, tabletype, appowner, colcount, sstatus)
values(@varEntity, 'CGONE','systables','System Tables','DEFAULT', 'SYS', 'CGONE', 12, 'ACTIVE' );

--# List of Lookups information in the system
--# ====================================================================
--# Project         : Wave ERP Framework
--# Description   	: Table for holding all possible lookup information
--#					  in the entire ERP system.
--# Owner           : Jammi Dee
--# Date            : 06/19/2014
--# Revision      	: 1.0.0
--# Last Modified 	: 06/19/2014
--# Modified By   	: Jammi Dee
--#
--# markerdate		- any data that represents date, any purpose of the
--#					  lookup.
--# Well Global Lookups:
--#
--#						Location
--#						Cost Center
--#						Department
--# ====================================================================
drop table if exists lookup;
CREATE TABLE lookup(
id			        int           NOT NULL AUTO_INCREMENT,
entityid 		    varchar(50),
appid 			    varchar(36),
keyid 			    varchar(20),
itemid 			    varchar(20),
description 	  varchar(200),

colstr01 		    varchar(20) 	default "_NA_",
colstr02 		    varchar(20) 	default "_NA_",
colstr03 		    varchar(20) 	default "_NA_",
colnum01 		    double 			  default 0.0,
colnum02 		    double 			  default 0.0,
coldate01 		  date			,
coldate02 		  date			,
coltime01 		  time			,
coltime02 		  time			,

contact			    varchar(200) 	default "_NA_",
address			    varchar(200) 	default "_NA_",
city			      varchar(200) 	default "_NA_",
postal			    varchar(200) 	default "_NA_",
markerdate		  date 		 	,
phone			      varchar(20) 	default "(000) 000-0000",
fax				      varchar(20) 	default "(000) 000-0000",
telex			      varchar(20) 	default "(000) 000-0000",

sstatus 		    varchar(20) 	default "ACTIVE",
pid				      varchar(36) 	default "000000",
userid 			    varchar(20) 	default "_NA_",
deleted 		    int 		      default 0,
PRIMARY KEY 	  (id)
);

--# Fill up the uniq key of table
drop trigger if exists newLookup;
CREATE TRIGGER newLookup
BEFORE INSERT ON tblLookup 
FOR EACH ROW SET NEW.juid = UUID();

--# Added by Jammi Dee 10/10/2015
insert into systables(entityid, dbname, tabname, tabdesc, tablegrp, tabletype, appowner, colcount, sstatus)
values(@varEntity, 'CGONE','lookup','Framework wide lookup table','DEFAULT', 'SYS', 'CGONE', 27, 'ACTIVE' );


-- Added by Jammi Dee 07/09/2025
CREATE TABLE `system_logs` (
  `id`             INT          NOT NULL AUTO_INCREMENT,
  `entityid`       VARCHAR(50)  DEFAULT '_NA_',                  -- for multi-tenant logs
  `user_id`        INT          DEFAULT NULL,                    -- null if guest
  `action_type`    VARCHAR(50)  NOT NULL,                        -- e.g., login, failed_login, update, delete
  `action_details` TEXT         NOT NULL,                        -- more info like route, input summary
  `ip_address`     VARCHAR(45)  NOT NULL,
  `user_agent`     TEXT         NOT NULL,
  `created_at`     DATETIME     DEFAULT CURRENT_TIMESTAMP,
  `severity`       ENUM('INFO', 'WARNING', 'ERROR') DEFAULT 'INFO',
  `is_suspicious`  BOOLEAN      DEFAULT FALSE,

  -- Additional system fields
  `sstatus`        VARCHAR(36)  DEFAULT 'ACTIVE',
  `pid`            INT          DEFAULT 0,
  `userid`         INT          DEFAULT 0,
  `deleted`        INT          DEFAULT 0,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--# Added by Jammi Dee 07/10/2015
-- Added by Jammi Dee 08/27/2025
INSERT INTO systables(entityid, dbname, tabname, tabdesc, tablegrp, tabletype, appowner, colcount, sstatus)
VALUES (@varEntity, 'CGONE', 'system_logs', 'Framework wide log table', 'DEFAULT', 'SYS', 'CGONE', 13, 'ACTIVE');

-- Add new fields for multi-tenancy and system metadata
ALTER TABLE system_logs
ADD COLUMN `entityid`   VARCHAR(50)  DEFAULT '_NA_' AFTER `id`,
ADD COLUMN `sstatus`    VARCHAR(36)  DEFAULT 'ACTIVE' AFTER `is_suspicious`,
ADD COLUMN `pid`        INT          DEFAULT 0 AFTER `sstatus`,
ADD COLUMN `userid`     INT          DEFAULT 0 AFTER `pid`,
ADD COLUMN `deleted`    INT          DEFAULT 0 AFTER `userid`,

-- Modify column for consistency with your standards
MODIFY COLUMN `severity` ENUM('INFO', 'WARNING', 'ERROR') DEFAULT 'INFO',

-- Ensure character set and collation match
CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


--# ====================================================================
--# Project       : Wave ERP Framework
--# Description   : Table for system settings and configuration
--# Owner         : Jammi Dee
--# Date          : 10/10/2015
--# Revision      : 1.0.0 
--# Last Modified : 10/10/2015
--# Modified By   : Jammi Dee
--#
--#                 This table stores general system-wide settings such
--#                 as branding, contact, payment, and API configurations.
--#
--#                 tabletype = SYS
--#                 appowner  = CGONE
--#
--# ====================================================================
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id`           INT          NOT NULL AUTO_INCREMENT,
  `entityid`     VARCHAR(50)  DEFAULT '_NA_',
  `logo`         VARCHAR(255) NOT NULL,
  `favicon`      VARCHAR(255) NOT NULL,
  `name`         VARCHAR(255) NOT NULL,
  `slogan`       VARCHAR(255) NOT NULL,
  `mobile`       VARCHAR(255) NOT NULL,
  `email`        VARCHAR(255) NOT NULL,
  `currency`     VARCHAR(255) NOT NULL,
  `paymentmethod`VARCHAR(255) NOT NULL,
  `paymentacc`   VARCHAR(255) NOT NULL,
  `vat`          FLOAT        NOT NULL,
  `smsapi`       VARCHAR(50)  NOT NULL,
  `emailapi`     VARCHAR(50)  NOT NULL,
  `smsonbills`   INT          NOT NULL,
  `emailonbills` INT          NOT NULL,
  `mkipadd`      VARCHAR(50)  DEFAULT NULL,
  `mkuser`       VARCHAR(50)  DEFAULT NULL,
  `mkpassword`   VARCHAR(50)  DEFAULT NULL,
  `address`      VARCHAR(255) NOT NULL,
  `city`         VARCHAR(255) NOT NULL,
  `country`      VARCHAR(255) NOT NULL,
  `zip`          VARCHAR(255) NOT NULL,
  `location`     VARCHAR(255) NOT NULL,
  `copyright`    VARCHAR(255) NOT NULL,
  `kenadekha`    VARCHAR(255) DEFAULT NULL,
  
  `sstatus`      VARCHAR(36)  DEFAULT 'ACTIVE',
  `pid`          INT          DEFAULT 0,
  `userid`       INT          DEFAULT 0,
  `deleted`      INT          DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--# Added by Jammi Dee 10/10/2015
INSERT INTO systables(entityid, dbname, tabname, tabdesc, tablegrp, tabletype, appowner, colcount, sstatus)
VALUES (@varEntity, 'CGONE', 'settings', 'System Settings', 'DEFAULT', 'SYS', 'CGONE', 26, 'ACTIVE');

ALTER TABLE `settings` ADD COLUMN `entityid` VARCHAR(50) DEFAULT 'NA' AFTER `id`;
ALTER TABLE `settings`
  ADD COLUMN `sstatus` VARCHAR(36) DEFAULT 'ACTIVE',
  ADD COLUMN `pid` INT DEFAULT 0,
  ADD COLUMN `userid` INT DEFAULT 0,
  ADD COLUMN `deleted` INT DEFAULT 0;