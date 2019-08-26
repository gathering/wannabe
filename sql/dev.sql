-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: mysql    Database: wannabe
-- ------------------------------------------------------
-- Server version	5.7.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `__db_version__`
--

DROP TABLE IF EXISTS `__db_version__`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `__db_version__` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(20) NOT NULL DEFAULT '0',
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sql_up` longtext,
  `sql_down` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `__db_version__`
--

LOCK TABLES `__db_version__` WRITE;
/*!40000 ALTER TABLE `__db_version__` DISABLE KEYS */;
INSERT INTO `__db_version__` VALUES (1,'0',NULL,NULL,NULL,NULL),(2,'20130330000000',NULL,'20130330000000_initial_do_not_touch.migration','\n-- MySQL dump 10.13  Distrib 5.1.66, for debian-linux-gnu (x86_64)\n--\n-- Host: localhost    Database: wannabe\n-- ------------------------------------------------------\n-- Server version	5.1.66-0+squeeze1-log\n\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n/*!40101 SET NAMES utf8 */;\n/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;\n/*!40103 SET TIME_ZONE=\'+00:00\' */;\n/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;\n/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;\n/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'NO_AUTO_VALUE_ON_ZERO\' */;\n/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;\n\n--\n-- Table structure for table `wb4_accreditation_accesses`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_accreditation_accesses` (\n  `accreditation_id` int(10) NOT NULL,\n  `accreditation_group_id` int(10) NOT NULL,\n  PRIMARY KEY (`accreditation_id`,`accreditation_group_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_accreditation_group_members`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_accreditation_group_members` (\n  `accreditation_group_id` int(10) NOT NULL,\n  `user_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`accreditation_group_id`,`user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_accreditation_groups`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_accreditation_groups` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL DEFAULT \'0\',\n  `name` varchar(50) NOT NULL,\n  PRIMARY KEY (`id`,`event_id`),\n  UNIQUE KEY `event_id` (`event_id`,`name`)\n) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_accreditations`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_accreditations` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) NOT NULL,\n  `company_name` varchar(128) NOT NULL,\n  `realname` varchar(128) NOT NULL,\n  `password` varchar(128) DEFAULT NULL,\n  `phonenumber` varchar(32) NOT NULL,\n  `email` varchar(128) NOT NULL,\n  `numpersons` tinyint(4) NOT NULL,\n  `arrivaldate` date NOT NULL DEFAULT \'0000-00-00\',\n  `departuredate` date NOT NULL DEFAULT \'0000-00-00\',\n  `actual_arrival` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `actual_departure` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `pictures` tinyint(1) DEFAULT NULL,\n  `film` tinyint(1) DEFAULT NULL,\n  `tour` tinyint(1) DEFAULT NULL,\n  `smsalert` tinyint(1) DEFAULT NULL,\n  `extended_info` text,\n  `internal_comment` text,\n  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  `updated` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `badge_id` int(11) DEFAULT NULL,\n  `accepted` tinyint(2) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_aclobjects`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_aclobjects` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `path` varchar(255) NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for aclobjects\n\nINSERT INTO `wb4_aclobjects` (`id`, `path`) VALUES\n(340, \'/dev/*\');\n\n--\n-- Table structure for table `wb4_aclobjects_crews`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_aclobjects_crews` (\n  `crew_id` int(10) unsigned NOT NULL,\n  `aclobject_id` int(10) unsigned NOT NULL,\n  `read` tinyint(1) DEFAULT \'0\',\n  `write` tinyint(1) DEFAULT \'0\',\n  `manage` tinyint(1) DEFAULT \'0\',\n  `superuser` tinyint(1) DEFAULT \'0\'\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_aclobjects_roles`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_aclobjects_roles` (\n  `role` int(10) NOT NULL,\n  `aclobject_id` int(10) unsigned NOT NULL,\n  `read` tinyint(1) DEFAULT \'0\',\n  `write` tinyint(1) DEFAULT \'0\',\n  `manage` tinyint(1) DEFAULT \'0\',\n  `superuser` tinyint(1) DEFAULT \'0\'\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for aclobjects_roles\n\nINSERT INTO `wb4_aclobjects_roles` (`role`, `aclobject_id`, `read`, `write`, `manage`, `superuser`) VALUES\n(-1, 340, 1, 1, 0, 0);\n\n--\n-- Table structure for table `wb4_aclobjects_users`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_aclobjects_users` (\n  `user_id` int(10) unsigned NOT NULL,\n  `aclobject_id` int(10) unsigned NOT NULL,\n  `read` tinyint(1) DEFAULT \'0\',\n  `write` tinyint(1) DEFAULT \'0\',\n  `manage` tinyint(1) DEFAULT \'0\',\n  `superuser` tinyint(1) DEFAULT \'0\'\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for aclobjects_users\n\nINSERT INTO `wb4_aclobjects_users` (`user_id`, `aclobject_id`, `read`, `write`, `manage`, `superuser`) VALUES\n(1, 340, 1, 1, 1, 1),\n(1918, 340, 1, 1, 1, 1),\n(2193, 340, 1, 1, 1, 1),\n(3073, 340, 1, 1, 1, 1),\n(4304, 340, 1, 1, 1, 1),\n(4607, 340, 1, 1, 1, 1),\n(4918, 340, 1, 1, 1, 1),\n(6195, 340, 1, 1, 1, 1);\n\n--\n-- Table structure for table `wb4_api_applications`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_api_applications` (\n  `id` char(36) NOT NULL,\n  `name` varchar(255) NOT NULL,\n  `description` text,\n  `creator_id` int(11) unsigned NOT NULL,\n  `enabled` tinyint(1) DEFAULT \'0\',\n  `created` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` datetime DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=InnoDB DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_api_keys`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_api_keys` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `apikey` varchar(32) DEFAULT NULL,\n  `revoked` tinyint(1) DEFAULT \'0\',\n  `user_id` int(10) unsigned NOT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `api_application_id` char(36) DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_api_sessions`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_api_sessions` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `sessionkey` varchar(32) NOT NULL,\n  `infinite` tinyint(1) DEFAULT \'0\',\n  `user_id` int(10) unsigned NOT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_available_fields`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_available_fields` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `event_id` int(11) DEFAULT NULL,\n  `application_fieldtype_id` int(11) DEFAULT NULL,\n  `application_page_id` int(11) DEFAULT NULL,\n  `name` varchar(50) DEFAULT NULL,\n  `description` text,\n  `created` datetime DEFAULT NULL,\n  `updated` datetime DEFAULT NULL,\n  `deleted` datetime DEFAULT NULL,\n  `crew_id` int(11) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  KEY `crewapplication_fieldtype_id` (`application_fieldtype_id`),\n  KEY `crewapplication_page_id` (`application_page_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=310 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_choices`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_choices` (\n  `application_document_id` int(11) DEFAULT NULL,\n  `crew_id` int(11) DEFAULT NULL,\n  `event_id` int(11) DEFAULT NULL,\n  `priority` int(11) NOT NULL,\n  `revision` int(11) DEFAULT \'0\',\n  `draft` tinyint(4) DEFAULT \'1\',\n  `handled` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `accepted` tinyint(4) DEFAULT \'0\' COMMENT \'Contains 1 if the choice is accepted\',\n  `denied` tinyint(4) DEFAULT \'0\' COMMENT \'Contains 1 if the choice is denied.\',\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `waiting` tinyint(4) DEFAULT \'0\',\n  PRIMARY KEY (`id`),\n  KEY `crewapplication_document_id` (`application_document_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=11003 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_documents`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_documents` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `event_id` int(11) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  `orderedchoices` tinyint(4) DEFAULT \'0\',\n  `created` datetime DEFAULT NULL,\n  `updated` datetime DEFAULT NULL,\n  `deleted` datetime DEFAULT NULL,\n  `draft` tinyint(4) DEFAULT \'1\',\n  `handled` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `enableprivacy` tinyint(4) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=4696 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_field_types`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_field_types` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `name` varchar(50) DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_fields`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_fields` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `application_document_id` int(11) DEFAULT NULL,\n  `application_availablefield_id` int(11) DEFAULT NULL,\n  `value` blob,\n  `revision` int(11) DEFAULT \'0\',\n  `created` datetime DEFAULT NULL,\n  `draft` tinyint(4) DEFAULT \'1\',\n  `crew_id` int(11) DEFAULT \'0\',\n  PRIMARY KEY (`id`),\n  KEY `crewapplication_availablefield_id` (`application_availablefield_id`),\n  KEY `crewapplication_document_id` (`application_document_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=21507 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_pages`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_pages` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `event_id` int(11) DEFAULT NULL,\n  `name` varchar(128) DEFAULT NULL,\n  `description` text,\n  `position` int(11) DEFAULT \'0\',\n  `type` enum(\'custom\',\'crewchoice\',\'crewwhy\',\'crewfield\',\'crewquestion\') DEFAULT NULL,\n  `crew_id` int(11) DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_application_settings`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_settings` (\n  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `choices` int(11) unsigned DEFAULT \'3\',\n  `privacy` int(11) unsigned DEFAULT \'0\',\n  `priority` int(11) unsigned DEFAULT \'0\',\n  `crewquestion` int(11) unsigned DEFAULT \'0\',\n  `event_id` int(10) unsigned NOT NULL,\n  `deniedtext` text,\n  `donestring` text,\n  `mailsubject` text,\n  `mailstring` text,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for application_settings\n\nINSERT INTO `wb4_application_settings` VALUES (1,3,0,0,0,18,\'Vi beklager å måtte meddele at du ikke har blitt tatt opp som crewmedlem. Vi takker for søknaden og ønsker deg velkommen tilbake som crewsøker til neste arrangement! Om du har spørsmål til prosessen rundt behandlingen av din søknad kan du ta kontakt med co [at] gathering.org.\',\'Din søknad er registrert og vil bli behandlet så fort som mulig. Hvis du har noen spørsmål, ikke nøl med å kontakte vår crewombudsman på co [at] gathering.org. Husk at du kan endre din søknad på hvilket som helst tidspunkt, hvis du ønsker det. Når din søknad har blitt behandlet vil du motta en epost som inneholder resultatet. Du vil også motta denne siden på epost øyeblikkelig.\',\'Din søknad er mottatt.\',\'Din søknad er registrert og vil bli behandlet så fort som mulig.\r\n\r\nHvis du har noen spørsmål, ikke nøl med å kontakte vårt crewombud på co@gathering.org\r\n\r\nHusk at du kan endre din søknad på hvilket som helst tidspunkt, hvis du ønsker det.\r\n\r\nNår din søknad har blitt behandlet vil du motta en epost som inneholder resultatet.\r\n\r\nSlik ser din søknad ut:\');\n\n--\n-- Table structure for table `wb4_application_tags`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_application_tags` (\n  `application_document_id` int(10) unsigned NOT NULL DEFAULT \'0\',\n  `user_id` int(10) unsigned NOT NULL,\n  `tag` varchar(32) NOT NULL DEFAULT \'\',\n  PRIMARY KEY (`application_document_id`,`user_id`,`tag`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_carplates`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_carplates` (\n  `user_id` int(10) NOT NULL DEFAULT \'0\',\n  `carplate` varchar(16) DEFAULT NULL,\n  PRIMARY KEY (`user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_cleanup_dates`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_cleanup_dates` (\n  `cid` int(8) unsigned NOT NULL AUTO_INCREMENT,\n  `event` mediumint(5) unsigned NOT NULL,\n  `name` varchar(100) CHARACTER SET latin1 NOT NULL,\n  PRIMARY KEY (`cid`),\n  KEY `event` (`event`)\n) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_cleanup_positions`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_cleanup_positions` (\n  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `cid` mediumint(8) unsigned NOT NULL,\n  `user` int(11) unsigned NOT NULL,\n  `ok` tinyint(1) unsigned NOT NULL,\n  PRIMARY KEY (`pid`),\n  KEY `cid` (`cid`,`user`)\n) ENGINE=MyISAM AUTO_INCREMENT=1163 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_countries`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_countries` (\n  `code` varchar(2) NOT NULL DEFAULT \'\',\n  `name` varchar(60) DEFAULT NULL,\n  `priority` smallint(6) DEFAULT \'0\',\n  PRIMARY KEY (`code`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for countries \n\nINSERT INTO `wb4_countries` (`code`, `name`, `priority`) VALUES\n(\'AF\', \'Afghanistan\', 0),\n(\'AL\', \'Albania\', 0),\n(\'DZ\', \'Algeria\', 0),\n(\'AS\', \'American Samoa\', 0),\n(\'AD\', \'Andorra\', 0),\n(\'AO\', \'Angola\', 0),\n(\'AI\', \'Anguilla\', 0),\n(\'AG\', \'Antigua and Barbuda\', 0),\n(\'AR\', \'Argentina\', 0),\n(\'AM\', \'Armenia\', 0),\n(\'AW\', \'Aruba\', 0),\n(\'AU\', \'Australia\', 0),\n(\'AT\', \'Austria\', 0),\n(\'AZ\', \'Azerbaijan\', 0),\n(\'BS\', \'Bahamas\', 0),\n(\'BH\', \'Bahrain\', 0),\n(\'BD\', \'Bangladesh\', 0),\n(\'BB\', \'Barbados\', 0),\n(\'BY\', \'Belarus\', 0),\n(\'BE\', \'Belgium\', 0),\n(\'BZ\', \'Belize\', 0),\n(\'BJ\', \'Benin\', 0),\n(\'BM\', \'Bermuda\', 0),\n(\'BT\', \'Bhutan\', 0),\n(\'BO\', \'Bolivia\', 0),\n(\'BA\', \'Bosnia and Herzegovina\', 0),\n(\'BW\', \'Botswana\', 0),\n(\'BR\', \'Brazil\', 0),\n(\'VG\', \'British Virgin Islands\', 0),\n(\'BN\', \'Brunei Darussalam\', 0),\n(\'BG\', \'Bulgaria\', 0),\n(\'BF\', \'Burkina Faso\', 0),\n(\'BI\', \'Burundi\', 0),\n(\'KH\', \'Cambodia\', 0),\n(\'CM\', \'Cameroon\', 0),\n(\'CA\', \'Canada\', 0),\n(\'CV\', \'Cape Verde\', 0),\n(\'KY\', \'Cayman Islands\', 0),\n(\'CF\', \'Central African Republic\', 0),\n(\'TD\', \'Chad\', 0),\n(\'CL\', \'Chile\', 0),\n(\'CN\', \'China\', 0),\n(\'CO\', \'Colombia\', 0),\n(\'KM\', \'Comoros\', 0),\n(\'CK\', \'Cook Islands\', 0),\n(\'CR\', \'Costa Rica\', 0),\n(\'CI\', \'Cote d\'\'Ivoire\', 0),\n(\'HR\', \'Croatia\', 0),\n(\'CU\', \'Cuba\', 0),\n(\'CY\', \'Cyprus\', 0),\n(\'CZ\', \'Czech Republic\', 0),\n(\'CG\', \'Democratic Republic of the Congo\', 0),\n(\'DK\', \'Denmark\', 1),\n(\'DJ\', \'Djibouti\', 0),\n(\'DM\', \'Dominica\', 0),\n(\'DO\', \'Dominican Republic\', 0),\n(\'TP\', \'East Timor\', 0),\n(\'EC\', \'Ecuador\', 0),\n(\'EG\', \'Egypt\', 0),\n(\'SV\', \'El Salvador\', 0),\n(\'GQ\', \'Equatorial Guinea\', 0),\n(\'ER\', \'Eritrea\', 0),\n(\'EE\', \'Estonia\', 0),\n(\'ET\', \'Ethiopia\', 0),\n(\'EU\', \'Europe\', 0),\n(\'FO\', \'Faeroe Islands\', 0),\n(\'FK\', \'Falkland Islands (Malvinas)\', 0),\n(\'FJ\', \'Fiji\', 0),\n(\'FI\', \'Finland\', 1),\n(\'FR\', \'France\', 0),\n(\'GF\', \'French Guiana\', 0),\n(\'PF\', \'French Polynesia\', 0),\n(\'GA\', \'Gabon\', 0),\n(\'GM\', \'Gambia\', 0),\n(\'GE\', \'Georgia\', 0),\n(\'DE\', \'Germany\', 1),\n(\'GH\', \'Ghana\', 0),\n(\'GI\', \'Gibraltar\', 0),\n(\'GR\', \'Greece\', 0),\n(\'GL\', \'Greenland\', 0),\n(\'GD\', \'Grenada\', 0),\n(\'GP\', \'Guadeloupe\', 0),\n(\'GU\', \'Guam\', 0),\n(\'GT\', \'Guatemala\', 0),\n(\'GN\', \'Guinea\', 0),\n(\'GW\', \'Guinea-Bissau\', 0),\n(\'GY\', \'Guyana\', 0),\n(\'HT\', \'Haiti\', 0),\n(\'VA\', \'Holy See\', 0),\n(\'HN\', \'Honduras\', 0),\n(\'HK\', \'Hong Kong\', 0),\n(\'HU\', \'Hungary\', 0),\n(\'IS\', \'Iceland\', 0),\n(\'IN\', \'India\', 0),\n(\'ID\', \'Indonesia\', 0),\n(\'IR\', \'Iran\', 0),\n(\'IQ\', \'Iraq\', 0),\n(\'IE\', \'Ireland\', 0),\n(\'IL\', \'Israel\', 0),\n(\'IT\', \'Italy\', 0),\n(\'JM\', \'Jamaica\', 0),\n(\'JP\', \'Japan\', 0),\n(\'JO\', \'Jordan\', 0),\n(\'KZ\', \'Kazakhstan\', 0),\n(\'KE\', \'Kenya\', 0),\n(\'KI\', \'Kiribati\', 0),\n(\'KW\', \'Kuwait\', 0),\n(\'KG\', \'Kyrgyzstan\', 0),\n(\'LA\', \'Lao People\'\'s Democratic Republic\', 0),\n(\'LV\', \'Latvia\', 0),\n(\'LB\', \'Lebanon\', 0),\n(\'LS\', \'Lesotho\', 0),\n(\'LR\', \'Liberia\', 0),\n(\'LY\', \'Libyan Arab Jamahiriya\', 0),\n(\'LI\', \'Liechtenstein\', 0),\n(\'LT\', \'Lithuania\', 0),\n(\'LU\', \'Luxembourg\', 0),\n(\'MO\', \'Macao Special Administrative Region of China\', 0),\n(\'MG\', \'Madagascar\', 0),\n(\'MW\', \'Malawi\', 0),\n(\'MY\', \'Malaysia\', 0),\n(\'MV\', \'Maldives\', 0),\n(\'ML\', \'Mali\', 0),\n(\'MT\', \'Malta\', 0),\n(\'MH\', \'Marshall Islands\', 0),\n(\'MQ\', \'Martinique\', 0),\n(\'MR\', \'Mauritania\', 0),\n(\'MU\', \'Mauritius\', 0),\n(\'MX\', \'Mexico\', 0),\n(\'FM\', \'Micronesia Federated States of,\', 0),\n(\'MC\', \'Monaco\', 0),\n(\'MN\', \'Mongolia\', 0),\n(\'MS\', \'Montserrat\', 0),\n(\'MA\', \'Morocco\', 0),\n(\'MZ\', \'Mozambique\', 0),\n(\'MM\', \'Myanmar\', 0),\n(\'NA\', \'Namibia\', 0),\n(\'NR\', \'Nauru\', 0),\n(\'NP\', \'Nepal\', 0),\n(\'NL\', \'Netherlands\', 0),\n(\'AN\', \'Netherlands Antilles\', 0),\n(\'NC\', \'New Caledonia\', 0),\n(\'NZ\', \'New Zealand\', 0),\n(\'NI\', \'Nicaragua\', 0),\n(\'NE\', \'Niger\', 0),\n(\'NG\', \'Nigeria\', 0),\n(\'NU\', \'Niue\', 0),\n(\'NF\', \'Norfolk Island\', 0),\n(\'KP\', \'North Korea\', 0),\n(\'MP\', \'Northern Mariana Islands\', 0),\n(\'NO\', \'Norway\', 2),\n(\'OM\', \'Oman\', 0),\n(\'PK\', \'Pakistan\', 0),\n(\'PW\', \'Palau\', 0),\n(\'PS\', \'Palestinian Territory, Occupied\', 0),\n(\'PA\', \'Panama\', 0),\n(\'PG\', \'Papua New Guinea\', 0),\n(\'PY\', \'Paraguay\', 0),\n(\'PE\', \'Peru\', 0),\n(\'PH\', \'Philippines\', 0),\n(\'PN\', \'Pitcairn\', 0),\n(\'PL\', \'Poland\', 0),\n(\'PT\', \'Portugal\', 0),\n(\'PR\', \'Puerto Rico\', 0),\n(\'QA\', \'Qatar\', 0),\n(\'RE\', \'Réunion\', 0),\n(\'MD\', \'Republic of Moldova\', 0),\n(\'RO\', \'Romania\', 0),\n(\'RU\', \'Russia\', 0),\n(\'RW\', \'Rwanda\', 0),\n(\'SH\', \'Saint Helena\', 0),\n(\'KN\', \'Saint Kitts and Nevis\', 0),\n(\'LC\', \'Saint Lucia\', 0),\n(\'PM\', \'Saint Pierre and Miquelon\', 0),\n(\'VC\', \'Saint Vincent and the Grenadines\', 0),\n(\'WS\', \'Samoa\', 0),\n(\'SM\', \'San Marino\', 0),\n(\'ST\', \'Sao Tome and Principe\', 0),\n(\'SA\', \'Saudi Arabia\', 0),\n(\'SN\', \'Senegal\', 0),\n(\'CS\', \'Serbia and Montenegro\', 0),\n(\'SC\', \'Seychelles\', 0),\n(\'SL\', \'Sierra Leone\', 0),\n(\'SG\', \'Singapore\', 0),\n(\'SK\', \'Slovakia\', 0),\n(\'SI\', \'Slovenia\', 0),\n(\'SB\', \'Solomon Islands\', 0),\n(\'SO\', \'Somalia\', 0),\n(\'ZA\', \'South Africa\', 0),\n(\'KR\', \'South Korea\', 0),\n(\'ES\', \'Spain\', 0),\n(\'LK\', \'Sri Lanka\', 0),\n(\'SD\', \'Sudan\', 0),\n(\'SR\', \'Suriname\', 0),\n(\'SJ\', \'Svalbard and Jan Mayen Islands\', 0),\n(\'SZ\', \'Swaziland\', 0),\n(\'SE\', \'Sweden\', 1),\n(\'CH\', \'Switzerland\', 0),\n(\'SY\', \'Syrian Arab Republic\', 0),\n(\'TW\', \'Taiwan\', 0),\n(\'TJ\', \'Tajikistan\', 0),\n(\'TH\', \'Thailand\', 0),\n(\'MK\', \'The former Yugoslav Republic of Macedonia\', 0),\n(\'TG\', \'Togo\', 0),\n(\'TK\', \'Tokelau\', 0),\n(\'TO\', \'Tonga\', 0),\n(\'TT\', \'Trinidad and Tobago\', 0),\n(\'TN\', \'Tunisia\', 0),\n(\'TR\', \'Turkey\', 0),\n(\'TM\', \'Turkmenistan\', 0),\n(\'TC\', \'Turks and Caicos Islands\', 0),\n(\'TV\', \'Tuvalu\', 0),\n(\'UG\', \'Uganda\', 0),\n(\'UA\', \'Ukraine\', 0),\n(\'AE\', \'United Arab Emirates\', 0),\n(\'GB\', \'United Kingdom\', 0),\n(\'TZ\', \'United Republic of Tanzania\', 0),\n(\'US\', \'United States\', 0),\n(\'VI\', \'United States Virgin Islands\', 0),\n(\'UY\', \'Uruguay\', 0),\n(\'UZ\', \'Uzbekistan\', 0),\n(\'VU\', \'Vanuatu\', 0),\n(\'VE\', \'Venezuela\', 0),\n(\'VN\', \'Viet Nam\', 0),\n(\'WF\', \'Wallis and Futuna Islands\', 0),\n(\'EH\', \'Western Sahara\', 0),\n(\'YE\', \'Yemen\', 0),\n(\'YU\', \'Yugoslavia\', 0),\n(\'ZM\', \'Zambia\', 0),\n(\'ZW\', \'Zimbabwe\', 0);\n\n--\n-- Table structure for table `wb4_crew_effects_items`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_crew_effects_items` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) NOT NULL,\n  `title` varchar(50) NOT NULL,\n  `sizes` varchar(128) NOT NULL,\n  `price` int(10) NOT NULL,\n  `amount_free` int(10) DEFAULT NULL,\n  `image` varchar(255) DEFAULT NULL,\n  `description` text,\n  `allow_change` tinyint(1) DEFAULT \'1\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_crew_effects_orders`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_crew_effects_orders` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) NOT NULL,\n  `user_id` int(10) NOT NULL,\n  `item_id` int(10) NOT NULL,\n  `item_size` varchar(50) NOT NULL,\n  `item_amount` int(10) unsigned NOT NULL,\n  `paid` tinyint(1) NOT NULL,\n  `givenextra` tinyint(1) NOT NULL,\n  `givenfree` tinyint(1) NOT NULL,\n  `paid_time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`),\n  KEY `userid` (`user_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=1484 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_crews`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_crews` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `crew_id` int(10) unsigned NOT NULL DEFAULT \'0\',\n  `name` varchar(64) NOT NULL,\n  `hidden` tinyint(1) DEFAULT \'0\',\n  `canapply` tinyint(1) DEFAULT \'0\',\n  `event_id` int(10) unsigned NOT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `content` text,\n  PRIMARY KEY (`id`),\n  KEY `crew_id` (`crew_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for crews\n\nINSERT INTO `wb4_crews` (`id`, `crew_id`, `name`, `hidden`, `canapply`, `event_id`, `created`, `updated`, `deleted`, `content`) VALUES\n(261, 0, \'Dev\', 0, 0, 18, \'2013-01-29 01:18:27\', \'2013-01-29 12:58:52\', \'0000-00-00 00:00:00\', \'\'),\n(262, 0, \'A\', 0, 0, 18, \'2013-02-12 13:28:26\', \'2013-02-12 13:28:26\', \'0000-00-00 00:00:00\', \'\'),\n(263, 0, \'B\', 0, 0, 18, \'2013-02-12 13:28:30\', \'2013-02-12 13:28:30\', \'0000-00-00 00:00:00\', \'\'),\n(264, 0, \'C\', 0, 0, 18, \'2013-02-12 13:28:34\', \'2013-02-12 13:28:34\', \'0000-00-00 00:00:00\', \'\'),\n(265, 0, \'D\', 0, 0, 18, \'2013-02-12 13:28:37\', \'2013-02-12 13:28:37\', \'0000-00-00 00:00:00\', \'\'),\n(266, 0, \'E\', 0, 0, 18, \'2013-02-12 13:28:41\', \'2013-02-12 13:28:41\', \'0000-00-00 00:00:00\', \'\'),\n(267, 0, \'F\', 0, 0, 18, \'2013-02-12 13:28:44\', \'2013-02-12 13:28:44\', \'0000-00-00 00:00:00\', \'\'),\n(268, 0, \'G\', 0, 0, 18, \'2013-02-12 13:28:47\', \'2013-02-12 13:28:47\', \'0000-00-00 00:00:00\', \'\'),\n(269, 0, \'H\', 0, 0, 18, \'2013-02-12 13:28:51\', \'2013-02-12 13:28:51\', \'0000-00-00 00:00:00\', \'\'),\n(270, 0, \'I\', 0, 0, 18, \'2013-02-12 13:28:55\', \'2013-02-12 13:28:55\', \'0000-00-00 00:00:00\', \'\'),\n(271, 0, \'J\', 0, 0, 18, \'2013-02-12 13:53:06\', \'2013-02-12 13:53:06\', \'0000-00-00 00:00:00\', \'\'),\n(272, 0, \'K\', 0, 0, 18, \'2013-02-12 13:53:10\', \'2013-02-12 13:53:10\', \'0000-00-00 00:00:00\', \'\'),\n(273, 0, \'L\', 0, 0, 18, \'2013-02-12 13:53:13\', \'2013-02-12 13:53:13\', \'0000-00-00 00:00:00\', \'\'),\n(274, 0, \'M\', 0, 0, 18, \'2013-02-12 13:53:16\', \'2013-02-12 13:53:16\', \'0000-00-00 00:00:00\', \'\'),\n(275, 0, \'N\', 0, 0, 18, \'2013-02-12 13:53:20\', \'2013-02-12 13:53:20\', \'0000-00-00 00:00:00\', \'\'),\n(276, 0, \'O\', 0, 0, 18, \'2013-02-12 13:53:24\', \'2013-02-12 13:53:24\', \'0000-00-00 00:00:00\', \'\'),\n(277, 0, \'P\', 0, 0, 18, \'2013-02-12 13:53:27\', \'2013-02-12 13:53:27\', \'0000-00-00 00:00:00\', \'\'),\n(278, 0, \'Q\', 0, 0, 18, \'2013-02-12 13:53:30\', \'2013-02-12 13:53:30\', \'0000-00-00 00:00:00\', \'\'),\n(279, 0, \'R\', 0, 0, 18, \'2013-02-12 13:53:34\', \'2013-02-12 13:53:34\', \'0000-00-00 00:00:00\', \'\'),\n(280, 0, \'S\', 0, 0, 18, \'2013-02-12 13:53:37\', \'2013-02-12 13:53:37\', \'0000-00-00 00:00:00\', \'\'),\n(281, 0, \'T\', 0, 0, 18, \'2013-02-12 13:53:40\', \'2013-02-12 13:53:40\', \'0000-00-00 00:00:00\', \'\'),\n(282, 0, \'U\', 0, 0, 18, \'2013-02-12 13:53:43\', \'2013-02-12 13:53:43\', \'0000-00-00 00:00:00\', \'\'),\n(283, 0, \'V\', 0, 0, 18, \'2013-02-12 13:54:00\', \'2013-02-12 13:54:00\', \'0000-00-00 00:00:00\', \'\'),\n(284, 0, \'W\', 0, 0, 18, \'2013-02-12 13:54:04\', \'2013-02-12 13:54:04\', \'0000-00-00 00:00:00\', \'\'),\n(285, 0, \'X\', 0, 0, 18, \'2013-02-12 13:54:07\', \'2013-02-12 13:54:07\', \'0000-00-00 00:00:00\', \'\'),\n(286, 0, \'Y\', 0, 0, 18, \'2013-02-12 13:54:10\', \'2013-02-12 13:54:10\', \'0000-00-00 00:00:00\', \'\'),\n(287, 0, \'Z\', 0, 0, 18, \'2013-02-12 13:54:14\', \'2013-02-12 13:54:14\', \'0000-00-00 00:00:00\', \'\');\n\n--\n-- Table structure for table `wb4_crews_users`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_crews_users` (\n  `user_id` int(10) unsigned NOT NULL,\n  `crew_id` int(10) unsigned NOT NULL,\n  `team_id` int(10) unsigned NOT NULL DEFAULT \'0\',\n  `leader` tinyint(2) DEFAULT \'0\',\n  `title` varchar(32) DEFAULT NULL,\n  `assigned` datetime DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`user_id`,`crew_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for table wb4_crews_users\n\nINSERT INTO `wb4_crews_users`(user_id, crew_id, team_id, leader, assigned) VALUES\n(1, 261, 0, 3, NOW()),\n(1918, 261, 0, 3, NOW()),\n(2193, 261, 0, 3, NOW()),\n(3073, 261, 0, 3, NOW()),\n(4304, 261, 0, 3, NOW()),\n(4607, 261, 0, 3, NOW()),\n(4918, 261, 0, 3, NOW()),\n(6195, 261, 0, 3, NOW());\n\n--\n-- Table structure for table `wb4_daypass`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_daypass` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned NOT NULL,\n  `accepted` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_dispatch_cases`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_dispatch_cases` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `problem_id` int(10) unsigned NOT NULL,\n  `created_user_id` int(10) unsigned DEFAULT NULL,\n  `seat` varchar(32) DEFAULT NULL,\n  `row` varchar(32) NOT NULL,\n  `switch` varchar(32) NOT NULL,\n  `priority` int(10) unsigned DEFAULT \'3\',\n  `delegated_user_id` int(10) unsigned DEFAULT NULL,\n  `delegatedtime` datetime DEFAULT NULL,\n  `isresolved` tinyint(1) DEFAULT \'0\',\n  `resolved_user_id` int(10) unsigned DEFAULT NULL,\n  `resolvedtime` datetime DEFAULT NULL,\n  `description` text,\n  `created` datetime DEFAULT NULL,\n  `updated` datetime DEFAULT NULL,\n  `deleted` datetime DEFAULT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_dispatch_problems`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_dispatch_problems` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) DEFAULT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_enroll_greetings`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_enroll_greetings` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `crew_id` int(10) unsigned NOT NULL,\n  `message` text,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_enroll_mailfields`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_enroll_mailfields` (\n  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `enroll_mail_id` int(11) unsigned NOT NULL,\n  `name` varchar(10000) NOT NULL,\n  `name_as_header` int(11) unsigned NOT NULL DEFAULT \'1\',\n  `content` varchar(10000) DEFAULT NULL,\n  `position` int(11) unsigned DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_enroll_mails`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_enroll_mails` (\n  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `enroll_setting_id` int(11) unsigned NOT NULL,\n  `subject` varchar(10000) NOT NULL,\n  `type` enum(\'accepted\',\'denied\',\'pending\',\'waiting\') NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for wb4_enroll_mails\n\nINSERT INTO `wb4_enroll_mails` VALUES \n(13,1,\'Informasjon fra wannabe\',\'denied\'),\n(14,1,\'Oppdatering fra wannabe\',\'pending\'),\n(16,1,\'Du har blitt satt på venteliste!\',\'waiting\'),\n(17,1,\'Velkommen i crew!\',\'accepted\');\n\n--\n-- Table structure for table `wb4_enroll_settings`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_enroll_settings` (\n  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(11) unsigned NOT NULL,\n  `enrollactive` int(11) unsigned NOT NULL DEFAULT \'0\',\n  `greetingactive` int(11) unsigned NOT NULL DEFAULT \'0\',\n  `enrollaccept` int(11) unsigned NOT NULL DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for wb4_enroll_settings\n\nINSERT INTO `wb4_enroll_settings` VALUES (1,18,0,0,0);\n\n--\n-- Table structure for table `wb4_events`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_events` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(200) DEFAULT NULL,\n  `reference` varchar(200) DEFAULT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `modified` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `locationname` varchar(128) NOT NULL,\n  `latitude` varchar(32) DEFAULT NULL,\n  `longitude` varchar(32) DEFAULT NULL,\n  `start` datetime DEFAULT NULL,\n  `end` datetime DEFAULT NULL,\n  `urlmode` enum(\'path\',\'domain\') DEFAULT \'path\',\n  `email` varchar(32) NOT NULL DEFAULT \'wannabe@gathering.org\',\n  `hide` tinyint(1) DEFAULT \'0\',\n  `disable` tinyint(1) DEFAULT \'0\',\n  `can_apply_for_crew` tinyint(1) DEFAULT \'1\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for events\n\nINSERT INTO `wb4_events` (`id`, `name`, `reference`, `created`, `modified`, `deleted`, `locationname`, `latitude`, `longitude`, `start`, `end`, `urlmode`, `email`, `hide`, `disable`, `can_apply_for_crew`) VALUES\n(18, \'Development\', \'dev\', \'2013-01-28 00:00:00\', \'2013-01-28 00:00:00\', \'0000-00-00 00:00:00\', \'Roy\', \'23.3\', \'45.45\', \'2013-08-13 00:00:00\', \'2013-08-15 00:00:00\', \'path\', \'wannabe@gathering.org\', 0, 0, 0);\n\n--\n-- Table structure for table `wb4_events_menuitems`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_events_menuitems` (\n  `menuitem_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  `position` int(10) unsigned DEFAULT \'0\',\n  `hidden` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`menuitem_id`,`event_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_front_news`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_front_news` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(100) DEFAULT \'News\',\n  `title` varchar(100) DEFAULT \'Wannabe\',\n  `content` mediumtext,\n  `active` tinyint(1) DEFAULT \'1\',\n  `left_box` tinyint(1) DEFAULT \'0\',\n  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  `created` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for front_news\n\nINSERT INTO `wb4_front_news` (`id`, `name`, `title`, `content`, `active`, `left_box`, `updated`, `created`, `deleted`) VALUES\n(1, \'Hva er wannabe\', \'¿Hvø ær Wünnåbø?\', \'Wannabe er en arrangementsdatabase bereget for frivillige arrangementer.<br /> Vil du bruke wannabe til ditt arrangement? Send inn en <a href=\"mailto:wannabe@gathering.org\">forespørsel</a>.\', 1, 1, \'2011-10-01 22:07:09\', \'2011-09-22 01:03:17\', \'0000-00-00 00:00:00\'),\n(2, \'Wannabe til iOS\', \'Wannabe til iOS\', \'Last news wannabe-applikasjonen fra iTunes. <a href=\"http://www.existemi.no/\">Finn ut mer</a>.\', 1, 0, \'2011-09-21 23:05:02\', \'2011-09-22 01:05:02\', \'0000-00-00 00:00:00\'),\n(3, \'Which\', \'Which crew?\', \'Read through the <a href=\"/tg13/Crew/Description\">descriptions</a> to see which crew will fit you best!\', 1, 0, \'2012-10-28 16:14:11\', \'2011-10-07 10:56:03\', \'0000-00-00 00:00:00\'),\n(4, \'Apply\', \'Apply for crew!\', \'As <a href=\"http://www.gathering.org/\">TG13</a> draws nearer we are yet again in need of <em>you</em> to apply now so that, together, we can make this years event the best one ever!\', 1, 1, \'2012-10-28 16:13:42\', \'2011-10-07 20:48:38\', \'0000-00-00 00:00:00\'),\n(5, \'Hvilket crew?\', \'Hvilket crew?\', \'Se gjennom <a href=\"/tg13/Crew/Description\">beskrivelsene</a> for å finne ut hvilket crew du ønsker å bidra i.\', 1, 0, \'2012-10-28 16:13:08\', \'2011-10-07 21:57:00\', \'0000-00-00 00:00:00\'),\n(6, \'Søk crew!\', \'Søk crew!\', \'<a href=\"http://www.gathering.org\">TG13</a> nærmer seg med stormskritt, og vi trenger at nettopp du legger inn din søknad, slik at du kan gjøre årets arrangement til det største noen sinne!\', 1, 1, \'2012-10-28 16:12:14\', \'2011-10-07 22:00:06\', \'0000-00-00 00:00:00\'),\n(7, \'Test\', \'Test\', \'Tester vi ser du\', 0, 0, \'2012-03-14 21:09:18\', \'2011-11-27 05:15:15\', \'0000-00-00 00:00:00\'),\n(8, \'ijajeogij\', \'aoijeoigj\', \'Norsk\', 0, 0, \'2012-03-14 21:16:25\', \'2012-03-14 22:16:25\', \'0000-00-00 00:00:00\');\n\n--\n-- Table structure for table `wb4_geocodes`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_geocodes` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `address` varchar(128) DEFAULT \'\',\n  `longitude` varchar(128) DEFAULT \'0\',\n  `latitude` varchar(128) DEFAULT \'0\',\n  `cached` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `invalid` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=400 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for geocodes\n\nINSERT INTO `wb4_geocodes` (`id`, `address`, `longitude`, `latitude`, `cached`, `invalid`) VALUES\n(320, \'Bedringens vei 1 1920 SØRUMSAND\', \'11.239805899999965\', \'59.9850923\', \'2013-02-22 10:34:18\', 0);\n\n--\n-- Table structure for table `wb4_i18n`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_i18n` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `locale` varchar(6) NOT NULL,\n  `model` varchar(255) NOT NULL,\n  `foreign_key` int(10) NOT NULL,\n  `field` varchar(255) NOT NULL,\n  `content` text,\n  PRIMARY KEY (`id`),\n  KEY `locale` (`locale`),\n  KEY `model` (`model`),\n  KEY `row_id` (`foreign_key`),\n  KEY `field` (`field`)\n) ENGINE=MyISAM AUTO_INCREMENT=292 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for i18n\n\nINSERT INTO `wb4_i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES\n(2, \'eng\', \'FrontNews\', 3, \'content\', \'Read through the <a href=\"/tg13/Crew/Description\">descriptions</a> to see which crew will fit you best!\'),\n(1, \'eng\', \'FrontNews\', 3, \'title\', \'Which crew?\'),\n(3, \'eng\', \'FrontNews\', 4, \'title\', \'Apply for crew!\'),\n(4, \'eng\', \'FrontNews\', 4, \'content\', \'As <a href=\"http://www.gathering.org/\">TG13</a> draws nearer we are yet again in need of <em>you</em> to apply now so that, together, we can make this years event the best one ever!\'),\n(5, \'nob\', \'FrontNews\', 5, \'title\', \'Hvilket crew?\'),\n(6, \'nob\', \'FrontNews\', 5, \'content\', \'Se gjennom <a href=\"/tg13/Crew/Description\">beskrivelsene</a> for å finne ut hvilket crew du ønsker å bidra i.\'),\n(7, \'nob\', \'FrontNews\', 6, \'title\', \'Søk crew!\'),\n(8, \'nob\', \'FrontNews\', 6, \'content\', \'<a href=\"http://www.gathering.org\">TG13</a> nærmer seg med stormskritt, og vi trenger at nettopp du legger inn din søknad, slik at du kan gjøre årets arrangement til det største noen sinne!\'),\n(9, \'nob\', \'Menuitem\', 1, \'name\', \'Vis profil\'),\n(10, \'nob\', \'Menuitem\', 2, \'name\', \'Ditt\'),\n(11, \'nob\', \'Menuitem\', 3, \'name\', \'Oppmøte\'),\n(12, \'nob\', \'Menuitem\', 4, \'name\', \'Logg ut\'),\n(13, \'nob\', \'Menuitem\', 7, \'name\', \'Søknader\'),\n(14, \'nob\', \'Menuitem\', 8, \'name\', \'Crew\'),\n(15, \'nob\', \'Menuitem\', 9, \'name\', \'IRC-nøkler\'),\n(16, \'nob\', \'Menuitem\', 10, \'name\', \'Profilbildekontroll\'),\n(17, \'nob\', \'Menuitem\', 13, \'name\', \'Cola-tavler\'),\n(18, \'nob\', \'Menuitem\', 14, \'name\', \'Brukerstøtte\'),\n(19, \'nob\', \'Menuitem\', 15, \'name\', \'Hittegods\'),\n(20, \'nob\', \'Menuitem\', 17, \'name\', \'Adgangskort\'),\n(21, \'nob\', \'Menuitem\', 18, \'name\', \'Oppmøte\'),\n(22, \'nob\', \'Menuitem\', 20, \'name\', \'Administrasjon\'),\n(23, \'nob\', \'Menuitem\', 23, \'name\', \'Rediger profil\'),\n(24, \'nob\', \'Menuitem\', 24, \'name\', \'Bil en annen bruker\'),\n(25, \'nob\', \'Menuitem\', 33, \'name\', \'Arrangement\'),\n(26, \'nob\', \'Menuitem\', 35, \'name\', \'Behandle\'),\n(27, \'nob\', \'Menuitem\', 36, \'name\', \'Brukerinformasjon\'),\n(28, \'nob\', \'Menuitem\', 50, \'name\', \'Bilskilter\'),\n(29, \'nob\', \'Menuitem\', 53, \'name\', \'Logistikk\'),\n(30, \'nob\', \'Menuitem\', 60, \'name\', \'Søknadsspørsmål\'),\n(31, \'nob\', \'Menuitem\', 61, \'name\', \'Velkomsthilsner\'),\n(32, \'nob\', \'Menuitem\', 67, \'name\', \'Medisinske behov\'),\n(33, \'nob\', \'Menuitem\', 68, \'name\', \'Ernæringsbehov\'),\n(34, \'nob\', \'Menuitem\', 71, \'name\', \'Statistikk\'),\n(35, \'nob\', \'Menuitem\', 72, \'name\', \'Presseakkreditering\'),\n(36, \'nob\', \'Menuitem\', 77, \'name\', \'SMS\'),\n(37, \'nob\', \'Menuitem\', 85, \'name\', \'Meny\'),\n(38, \'nob\', \'Menuitem\', 87, \'name\', \'Beskrivelser\'),\n(39, \'nob\', \'Menuitem\', 88, \'name\', \'Søknader\'),\n(40, \'nob\', \'Menuitem\', 89, \'name\', \'Opptak\'),\n(41, \'nob\', \'Menuitem\', 90, \'name\', \'Tilgangskontroll\'),\n(42, \'nob\', \'Menuitem\', 94, \'name\', \'Innsjekking\'),\n(43, \'nob\', \'Menuitem\', 97, \'name\', \'Scene-tavler\'),\n(44, \'nob\', \'Menuitem\', 96, \'name\', \'E-postlister\'),\n(45, \'nob\', \'Menuitem\', 98, \'name\', \'Ryddetider\'),\n(46, \'nob\', \'Menuitem\', 102, \'name\', \'Sovekart\'),\n(47, \'eng\', \'Menuitem\', 1, \'name\', \'View profile\'),\n(48, \'eng\', \'Menuitem\', 2, \'name\', \'Your\'),\n(49, \'eng\', \'Menuitem\', 4, \'name\', \'Sign out\'),\n(50, \'eng\', \'Menuitem\', 7, \'name\', \'Applications\'),\n(51, \'eng\', \'Menuitem\', 8, \'name\', \'Crew\'),\n(52, \'eng\', \'Menuitem\', 9, \'name\', \'IRC keys\'),\n(53, \'eng\', \'Menuitem\', 10, \'name\', \'Profile picture control\'),\n(54, \'eng\', \'Menuitem\', 13, \'name\', \'Score board\'),\n(55, \'eng\', \'Menuitem\', 14, \'name\', \'Dispatch\'),\n(56, \'eng\', \'Menuitem\', 15, \'name\', \'Lost and found\'),\n(57, \'eng\', \'Menuitem\', 17, \'name\', \'Access card\'),\n(58, \'eng\', \'Menuitem\', 18, \'name\', \'Attendance\'),\n(59, \'eng\', \'Menuitem\', 20, \'name\', \'Administration\'),\n(60, \'eng\', \'Menuitem\', 23, \'name\', \'Edit profile\'),\n(61, \'eng\', \'Menuitem\', 24, \'name\', \'Become another user\'),\n(62, \'eng\', \'Menuitem\', 33, \'name\', \'Event\'),\n(63, \'eng\', \'Menuitem\', 35, \'name\', \'Manage\'),\n(64, \'eng\', \'Menuitem\', 36, \'name\', \'User information\'),\n(65, \'eng\', \'Menuitem\', 50, \'name\', \'Car plates\'),\n(66, \'eng\', \'Menuitem\', 53, \'name\', \'Logistics\'),\n(67, \'eng\', \'Menuitem\', 60, \'name\', \'Application questions\'),\n(68, \'eng\', \'Menuitem\', 61, \'name\', \'Greetings\'),\n(69, \'eng\', \'Menuitem\', 67, \'name\', \'Medical needs\'),\n(70, \'eng\', \'Menuitem\', 68, \'name\', \'Nutritional needs\'),\n(71, \'eng\', \'Menuitem\', 71, \'name\', \'Statistics\'),\n(72, \'eng\', \'Menuitem\', 72, \'name\', \'Press accreditation\'),\n(73, \'eng\', \'Menuitem\', 77, \'name\', \'SMS\'),\n(74, \'eng\', \'Menuitem\', 85, \'name\', \'Menu\'),\n(75, \'eng\', \'Menuitem\', 87, \'name\', \'Descriptions\'),\n(76, \'eng\', \'Menuitem\', 88, \'name\', \'Application\'),\n(77, \'eng\', \'Menuitem\', 89, \'name\', \'Enrollment\'),\n(78, \'eng\', \'Menuitem\', 90, \'name\', \'Access control\'),\n(79, \'eng\', \'Menuitem\', 94, \'name\', \'Check in\'),\n(80, \'eng\', \'Menuitem\', 97, \'name\', \'Stage board\'),\n(81, \'eng\', \'Menuitem\', 96, \'name\', \'Mailingslists\'),\n(82, \'eng\', \'Menuitem\', 98, \'name\', \'Cleanup\'),\n(83, \'eng\', \'Menuitem\', 102, \'name\', \'Sleep map\'),\n(84, \'nob\', \'Menuitem\', 104, \'name\', \'Ditt crew\'),\n(85, \'nob\', \'Menuitem\', 105, \'name\', \'Liste\'),\n(86, \'nob\', \'Menuitem\', 106, \'name\', \'nick\'),\n(87, \'nob\', \'Menuitem\', 107, \'name\', \'Moduler\'),\n(88, \'nob\', \'Menuitem\', 108, \'name\', \'Klær\'),\n(89, \'eng\', \'Menuitem\', 104, \'name\', \'Your crew\'),\n(90, \'eng\', \'Menuitem\', 105, \'name\', \'List\'),\n(91, \'eng\', \'Menuitem\', 106, \'name\', \'nick\'),\n(92, \'eng\', \'Menuitem\', 107, \'name\', \'Modules\'),\n(93, \'eng\', \'Menuitem\', 108, \'name\', \'Clothing\'),\n(94, \'nob\', \'Menuitem\', 109, \'name\', \'Endre arrangement\'),\n(95, \'eng\', \'Menuitem\', 109, \'name\', \'Change event\'),\n(96, \'eng\', \'Phonetype\', 1, \'name\', \'Mobile\'),\n(97, \'eng\', \'Phonetype\', 2, \'name\', \'Home\'),\n(98, \'eng\', \'Phonetype\', 3, \'name\', \'Work\'),\n(99, \'nob\', \'Phonetype\', 1, \'name\', \'Mobil\'),\n(100, \'nob\', \'Phonetype\', 2, \'name\', \'Hjem\'),\n(101, \'nob\', \'Phonetype\', 3, \'name\', \'Arbeid\'),\n(102, \'nob\', \'FrontNews\', 7, \'title\', \'Test\'),\n(103, \'nob\', \'FrontNews\', 7, \'content\', \'Tester vi ser du\'),\n(104, \'nob\', \'Menuitem\', 110, \'name\', \'Crew\'),\n(105, \'eng\', \'Menuitem\', 110, \'name\', \'Crew\'),\n(106, \'eng\', \'MenuItem\', 111, \'name\', \'News\'),\n(107, \'nob\', \'MenuItem\', 111, \'name\', \'Nyheter\'),\n(108, \'nob\', \'Menuitem\', 113, \'name\', \'E-postlister\'),\n(109, \'eng\', \'Menuitem\', 113, \'name\', \'Mailing lists\'),\n(110, \'eng\', \'Menuitem\', 114, \'name\', \'Privacy\'),\n(111, \'nob\', \'Menuitem\', 114, \'name\', \'Personvern\'),\n(112, \'eng\', \'Menuitem\', 115, \'name\', \'Needs\'),\n(113, \'nob\', \'Menuitem\', 115, \'name\', \'Behov\'),\n(143, \'eng\', \'Task\', 3, \'message\', \'Please fill in any needs you might have\'),\n(142, \'nob\', \'Task\', 3, \'message\', \'Vennligst fyll inn eventuelle behov du har\'),\n(140, \'eng\', \'PictureRule\', 7, \'rule_text\', \'The picture must be at least 320x427 pixels in size.\'),\n(139, \'nob\', \'PictureRule\', 7, \'denied_text\', \'Ditt bilde er ikke stort nok. Last opp et bilde som er større enn 320x427 piksler størrelse.\'),\n(138, \'nob\', \'PictureRule\', 7, \'rule_text\', \'Bildet må være over 320x427 piksler størrelse.\'),\n(156, \'nob\', \'Task\', 2, \'message\', \'Vennligst oppgi din størrelse\'),\n(154, \'nob\', \'Task\', 4, \'glenn\', \'aegaeg\'),\n(155, \'eng\', \'Task\', 4, \'glenn\', \'134134\'),\n(144, \'nob\', \'FrontNews\', 8, \'title\', \'aoijeoigj\'),\n(145, \'nob\', \'FrontNews\', 8, \'content\', \'Norsk\'),\n(141, \'eng\', \'PictureRule\', 7, \'denied_text\', \'Your picture was too small. Upload a picture which is at least 320x427 pixels in size.\'),\n(126, \'nob\', \'Menuitem\', 116, \'name\', \'Creweffekter\'),\n(127, \'eng\', \'Menuitem\', 116, \'name\', \'Crew effects\'),\n(128, \'nob\', \'Menuitem\', 117, \'name\', \'Creweffekter\'),\n(129, \'eng\', \'Menuitem\', 117, \'name\', \'Crew effects\'),\n(130, \'eng\', \'Menuitem\', 118, \'name\', \'Crew effects\'),\n(131, \'nob\', \'Menuitem\', 118, \'name\', \'Creweffekter\'),\n(132, \'nob\', \'Menuitem\', 119, \'name\', \'Bilderegler\'),\n(133, \'eng\', \'Menuitem\', 119, \'name\', \'Picture rules\'),\n(134, \'eng\', \'Menuitem\', 120, \'name\', \'Tasks\'),\n(135, \'nob\', \'Menuitem\', 120, \'name\', \'Oppgaver\'),\n(157, \'eng\', \'Task\', 2, \'message\', \'Please fill in your size\'),\n(158, \'nob\', \'Menuitem\', 121, \'name\', \'Oppmøte\'),\n(159, \'eng\', \'Menuitem\', 121, \'name\', \'Showup time\'),\n(160, \'nob\', \'Task\', 4, \'message\', \'Vennligst sett din oppmøtetid\'),\n(161, \'eng\', \'Task\', 4, \'message\', \'Please set your showup time\'),\n(162, \'eng\', \'Menuitem\', 122, \'name\', \'Accreditation\'),\n(163, \'nob\', \'Menuitem\', 122, \'name\', \'Akkreditering\'),\n(164, \'nob\', \'Task\', 5, \'message\', \'Din oppmøtetid har blitt avslått, vennglist sett en ny\'),\n(165, \'eng\', \'Task\', 5, \'message\', \'You showup time has been denied, please provide a new\'),\n(166, \'nob\', \'Menuitem\', 123, \'name\', \'Mattider\'),\n(167, \'nob\', \'Menuitem\', 124, \'name\', \'Mattider\'),\n(168, \'eng\', \'Menuitem\', 124, \'name\', \'Meal times\'),\n(169, \'eng\', \'Menuitem\', 123, \'name\', \'Meal times\'),\n(170, \'nob\', \'PictureRule\', 10, \'rule_text\', \'Profilbildet trykkes på ditt personlige ID-kort. Kortet fungerer som en identifikasjon og gir deg adgang til arrangementet. Bildet må derfor best mulig identifisere deg, og tilfredsstille spesifikke krav til kvalitet og utforming. Dersom bildet ikke fyller disse kravene, blir du bedt om å laste opp et nytt bilde.\'),\n(171, \'nob\', \'PictureRule\', 10, \'denied_text\', \'Profilbildet ditt tilfredstiller ikke kravene for å identifisere deg godt nok.\'),\n(172, \'eng\', \'PictureRule\', 10, \'rule_text\', \'The profile picture will be printed on your personal ID card. The card serves as an identification and gives you access to the event. The image must identify you, and satisfy the specific requirements for quality and layout. If your image does not meet these requirements, you will be prompted to upload a new image.\'),\n(173, \'eng\', \'PictureRule\', 10, \'denied_text\', \'Your profile photo does not meet the requirements to identify you well enough.\'),\n(174, \'nob\', \'PictureRule\', 11, \'rule_text\', \'Bildet skal tas rett forfra og vise hele ansiktet. Ikke halfprofil.\'),\n(175, \'nob\', \'PictureRule\', 11, \'denied_text\', \'Bildet skal tas rett forfra og vise hele ansiktet. Ikke halvprofil!\'),\n(176, \'eng\', \'PictureRule\', 11, \'rule_text\', \'The picture must be taken directly from the front and show the whole face. Not half profile!\'),\n(177, \'eng\', \'PictureRule\', 11, \'denied_text\', \'The picture must be taken directly from the front and show the whole face. Not half profile!\'),\n(178, \'nob\', \'PictureRule\', 12, \'rule_text\', \'Bakgrunnen skal være lys eller nøytral\'),\n(179, \'nob\', \'PictureRule\', 12, \'denied_text\', \'Bakgrunnen i profilbildene må være lys eller nøytral. Vennligst last opp et bilde som tilfredstiller dette kravet\'),\n(180, \'eng\', \'PictureRule\', 12, \'rule_text\', \'The background must be light or neutral\'),\n(181, \'eng\', \'PictureRule\', 12, \'denied_text\', \'The background in profile pictures must be light or neutral. Please upload a photo that meets this requirement\'),\n(182, \'nob\', \'PictureRule\', 13, \'rule_text\', \'Øynene skal være åpne, synlige og ikke dekkes av hår\'),\n(183, \'nob\', \'PictureRule\', 13, \'denied_text\', \'Ditt bilde møter ikke kravene om synlighet av øyne. De skal ikke være dekket av hår og må ikke være lukket\'),\n(184, \'eng\', \'PictureRule\', 13, \'rule_text\', \'The eyes must be open, visible and not covered by hair\'),\n(185, \'eng\', \'PictureRule\', 13, \'denied_text\', \'Your image does not meet the requirements for visibility of the eyes. They should not be covered by hair, and they must not be closed\'),\n(186, \'nob\', \'PictureRule\', 14, \'rule_text\', \'Detaljer i ansiktet må vises tydelig\'),\n(187, \'nob\', \'PictureRule\', 14, \'denied_text\', \'Ditt bilde møter ikke kravene for bildegodkjenning. Alle detaljer i ansiktet må vises tydelig\'),\n(188, \'eng\', \'PictureRule\', 14, \'rule_text\', \'Details of the face must be clearly displayed\'),\n(189, \'eng\', \'PictureRule\', 14, \'denied_text\', \'Your image does not meet the requirements for picture approval. Details of the face must be clearly displayed\'),\n(190, \'nob\', \'PictureRule\', 15, \'rule_text\', \'Briller er tillatt. Unngå at innfatningen skjuler noe av øynene eller reflekterer lys\'),\n(191, \'nob\', \'PictureRule\', 15, \'denied_text\', \'Ditt bilde møter ikke kravene for bildegodkjenning. Vi tillater naturligvis bilder med briller, men unngå bilder der innfatningen skjuler noe av øynene eller reflekterer lys\'),\n(192, \'eng\', \'PictureRule\', 15, \'rule_text\', \'Glasses are permitted. Please avoid frame that hides some of your eyes or reflect light\'),\n(193, \'eng\', \'PictureRule\', 15, \'denied_text\', \'Your image does not meet the requirements for profile approval. We do allow pictures with glasses, but please avoid pictures where the frame hides some of your eyes or reflect light\'),\n(194, \'nob\', \'PictureRule\', 16, \'rule_text\', \'Brilleglass skal ikke være farget (solbriller er ikke tillatt)\'),\n(195, \'nob\', \'PictureRule\', 16, \'denied_text\', \'Ditt bilde møter ikke kravene for bildegodkjenning. Vi tillater naturligvis bilder med briller, men unngå brilleglass som er farget (solbriller er ikke tillatt)\'),\n(196, \'eng\', \'PictureRule\', 16, \'rule_text\', \'Glasses should not be colored (sunglasses are not allowed)\'),\n(197, \'eng\', \'PictureRule\', 16, \'denied_text\', \'Your image does not meet the requirements for picture approval. We do allow pictures with glasses, but avoid lenses that are colored (sunglasses are not allowed)\'),\n(198, \'nob\', \'PictureRule\', 17, \'rule_text\', \'Hodeplagg er ikke tillatt\'),\n(199, \'nob\', \'PictureRule\', 17, \'denied_text\', \'Ditt bilde møter ikke kravene for bildegodkjenning. Hodeplagg er ikke tillatt (caps, hatt, hårbøyle med kaninører og lignende)\'),\n(200, \'eng\', \'PictureRule\', 17, \'rule_text\', \'Headgear is not permitted\'),\n(201, \'eng\', \'PictureRule\', 17, \'denied_text\', \'Your image does not meet the requirements for picture approval. Headgear is not allowed (cap, hat, headband with rabbit ears, etc.)\'),\n(202, \'nob\', \'PictureRule\', 18, \'rule_text\', \'… men hodeplagg med religiøse og/eller særskilte årsaker er ok, dersom du bruker tilsvarende hodeplagg under arrangementet\'),\n(203, \'nob\', \'PictureRule\', 18, \'denied_text\', \'Ditt bilde møter ikke kravene for bildegodkjenning. Hodeplagg er ikke tillatt (caps, hatt, hårbøyle med kaninører og lignende)\'),\n(204, \'eng\', \'PictureRule\', 18, \'rule_text\', \'... but headgear with religious and/or specific causes are ok, if you are using similar headgear during the event\'),\n(205, \'eng\', \'PictureRule\', 18, \'denied_text\', \'Your image does not meet the requirements for picture approval. Headgear is not allowed (cap, hat, headband with rabbit ears, etc.)\'),\n(206, \'nob\', \'PictureRule\', 19, \'rule_text\', \'Bildet må ha et størrelsesforhold på 3:4 (0.75:1), bruk beskjæringsfunksjonen for å oppnå dette.\'),\n(207, \'nob\', \'PictureRule\', 19, \'denied_text\', \'Ditt bilde har feil størrelsesforhold. Last opp nytt bilde og benytt deg av beskjæringsfunksjonen i Wannabe for å oppnå dette.\'),\n(208, \'eng\', \'PictureRule\', 19, \'rule_text\', \'The picture must has an aspect ratio of 3:4 (0.75:1). Use the crop function to achieve this.\'),\n(209, \'eng\', \'PictureRule\', 19, \'denied_text\', \'Your picture has the wrong aspect ratio. Upload a new picture and use the crop function in Wannabe to achieve correct aspect ratio.\'),\n(210, \'nob\', \'PictureRule\', 20, \'rule_text\', \'Bildet skal være av ditt ansikt, ikke hele overkroppen\'),\n(211, \'nob\', \'PictureRule\', 20, \'denied_text\', \'Ansiktet ditt er for lite, og vil synes dårlig på ID-kortene, last opp et bilde hvor kun ditt ansikt er i fokus.\'),\n(212, \'eng\', \'PictureRule\', 20, \'rule_text\', \'The picture should be of you face, not your whole upper body.\'),\n(213, \'eng\', \'PictureRule\', 20, \'denied_text\', \'Your face is too small and will be poorly visible on the ID cards. Please upload a new picture.\'),\n(214, \'nob\', \'Menuitem\', 125, \'name\', \'Bilskilt\'),\n(215, \'nob\', \'Menuitem\', 126, \'name\', \'Bilskilter\'),\n(216, \'eng\', \'Menuitem\', 126, \'name\', \'Car plates\'),\n(217, \'eng\', \'Menuitem\', 125, \'name\', \'Car plate\'),\n(218, \'eng\', \'Menuitem\', 127, \'name\', \'Slideshow\'),\n(219, \'nob\', \'Menuitem\', 127, \'name\', \'Lysbildefremvisning\'),\n(220, \'nob\', \'Menuitem\', 128, \'name\', \'SMS\'),\n(221, \'eng\', \'Menuitem\', 128, \'name\', \'SMS\'),\n(222, \'eng\', \'Menuitem\', 129, \'name\', \'Cleanup\'),\n(223, \'nob\', \'Menuitem\', 129, \'name\', \'Rydding\'),\n(224, \'eng\', \'Menuitem\', 130, \'name\', \'Lost and found\'),\n(225, \'nob\', \'Menuitem\', 130, \'name\', \'Tapt og funnet\'),\n(226, \'eng\', \'Menuitem\', 131, \'name\', \'Keycard\'),\n(227, \'nob\', \'Menuitem\', 131, \'name\', \'Nokkelkort\'),\n(230, \'nob\', \'Task\', 6, \'message\', \'Vennligst velg din mattid\'),\n(231, \'eng\', \'Task\', 6, \'message\', \'Please choose you meal time\'),\n(232, \'nob\', \'Menuitem\', 133, \'name\', \'Sovekart\'),\n(233, \'eng\', \'Menuitem\', 133, \'name\', \'Sleeping places\'),\n(234, \'nob\', \'Menuitem\', 134, \'name\', \'KANDU-Medlemskap\'),\n(235, \'eng\', \'Menuitem\', 134, \'name\', \'KANDU Membership\'),\n(236, \'nob\', \'Task\', 7, \'message\', \'a\'),\n(237, \'eng\', \'Task\', 7, \'message\', \'b\'),\n(238, \'nob\', \'Task\', 8, \'message\', \'Vennligst oppgi din størrelse\'),\n(239, \'eng\', \'Task\', 8, \'message\', \'Please fill in your size\'),\n(240, \'nob\', \'Task\', 9, \'message\', \'Vennligst fyll inn eventuelle behov du har\'),\n(241, \'eng\', \'Task\', 9, \'message\', \'Please fill in any needs you might have\'),\n(242, \'nob\', \'Task\', 10, \'message\', \'Vennligst sett din oppmøtetid\'),\n(243, \'eng\', \'Task\', 10, \'message\', \'Please set your showup time\'),\n(244, \'nob\', \'Task\', 11, \'message\', \'Vennligst velg din mattid\'),\n(245, \'eng\', \'Task\', 11, \'message\', \'Please choose you meal time\'),\n(246, \'nob\', \'Task\', 12, \'message\', \'Velg ditt medlemskap\'),\n(247, \'eng\', \'Task\', 12, \'message\', \'Choose your membership\'),\n(254, \'nob\', \'Term\', 2, \'title\', \'Rettigheter\'),\n(253, \'eng\', \'Menuitem\', 135, \'name\', \'Terms\'),\n(252, \'nob\', \'Menuitem\', 135, \'name\', \'Rettigheter\'),\n(255, \'nob\', \'Term\', 2, \'content\', \'Som frivillig crew-medlem vet jeg at det stilles krav til meg og mitt arbeid.\r\n\r\nArrangøren av The Gathering, KANDU, får fritt benytte seg av alt arbeid som utføres for The Gathering, som f.eks. systemutvikling, grafikk, konsept, med mer.\r\n\r\nKANDU beholder bruksrett til alt som er utviklet og produsert også etter at crew-medlemmet avslutter sitt engasjement i organisasjonen. Materiellet kan i tillegg videreutvikles av The Gathering.\r\n\r\nCrew-medlemmet som produserte og/eller utviklet materiellet beholder allikevel rettigheten til å videreutvikle og/eller selge materiellet etter at engasjementet i organisasjonen er avsluttet.\r\n\r\nKANDU kan ikke videreselge materiellet, men står fritt til å bruke det så lenge dette ikke er i et kommersielt øyemed.\'),\n(256, \'eng\', \'Term\', 2, \'title\', \'Terms\'),\n(257, \'eng\', \'Term\', 2, \'content\', \'As a volunteering crew member, I acknowledge that requirements are set for myself and my efforts.\r\n\r\nThe organizer of The Gathering, KANDU, may freely use any and all work produced for The Gathering, for example developed systems, graphics, concepts and more.\r\n\r\nKANDU retains the right to use everything developed and produced by the crew member also after the member ends involvement in the organization. The product may also be further developed by The Gathering.\r\n\r\nThe crew member who produced and/or developed the product will nevertheless retain the right to further develop and/or sell the product after the involvement in the organization is ended.\r\n\r\nKANDU may not resell the product, but shall be free to use it as long as it is not used in a commercial context.\');\n\n--\n-- Table structure for table `wb4_improtocols`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_improtocols` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(200) NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for improtocols\n\nINSERT INTO `wb4_improtocols` (`id`, `name`) VALUES\n(1, \'MSN\'),\n(2, \'ICQ\'),\n(3, \'AIM\'),\n(4, \'AOL\'),\n(5, \'Skype\'),\n(6, \'GTalk\');\n\n--\n-- Table structure for table `wb4_irc_channel_key_crews`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_irc_channel_key_crews` (\n  `irc_channel_key_id` int(10) NOT NULL,\n  `crew_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`irc_channel_key_id`,`crew_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for irc_channel_key_crews\n\nINSERT INTO `wb4_irc_channel_key_crews` (`irc_channel_key_id`, `crew_id`) VALUES\n(16, 261);\n\n--\n-- Table structure for table `wb4_irc_channel_keys`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_irc_channel_keys` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL DEFAULT \'0\',\n  `channelname` varchar(32) NOT NULL,\n  `channelkey` varchar(64) NOT NULL,\n  `updated` datetime DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`,`event_id`),\n  UNIQUE KEY `event_id` (`event_id`,`channelname`)\n) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for irc_channel_keys\n\nINSERT INTO `wb4_irc_channel_keys` (`id`, `event_id`, `channelname`, `channelkey`, `updated`) VALUES\n(16, 18, \'#irc\', \'kaffe\', \'2013-02-17 05:02:47\');\n\n--\n-- Table structure for table `wb4_kandu_memberships`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_kandu_memberships` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned NOT NULL,\n  `choice` int(1) NOT NULL DEFAULT \'0\',\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_keycard_cards`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_keycard_cards` (\n  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `card_number` int(11) unsigned NOT NULL,\n  `event_id` int(11) unsigned DEFAULT NULL,\n  `handed_out` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_keycard_handouts`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_keycard_handouts` (\n  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `card_id` int(11) unsigned DEFAULT NULL,\n  `event_id` int(11) unsigned DEFAULT NULL,\n  `name` varchar(255) NOT NULL,\n  `seat` varchar(255) DEFAULT NULL,\n  `phone` varchar(255) DEFAULT NULL,\n  `deposit` varchar(255) DEFAULT NULL,\n  `deposit_desc` text,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=339 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_bulks`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_bulks` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `amount` int(10) unsigned DEFAULT \'0\',\n  `amountleft` int(10) unsigned DEFAULT \'0\',\n  `created` datetime DEFAULT NULL,\n  `modified` datetime DEFAULT NULL,\n  `deleted` datetime DEFAULT NULL,\n  `name` varchar(255) DEFAULT NULL,\n  `description` varchar(255) DEFAULT NULL,\n  `logistic_supplier_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_items`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_items` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) DEFAULT NULL,\n  `description` text,\n  `comment` text,\n  `logistic_supplier_id` int(10) unsigned DEFAULT NULL,\n  `serialnumber` varchar(255) DEFAULT NULL,\n  `created` datetime DEFAULT NULL,\n  `modified` datetime DEFAULT NULL,\n  `deleted` tinyint(1) DEFAULT \'0\',\n  `logistic_bulk_id` int(10) unsigned DEFAULT \'0\',\n  `event_id` int(10) unsigned DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=543 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_items_logistic_tags`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_items_logistic_tags` (\n  `logistic_item_id` int(10) unsigned NOT NULL,\n  `logistic_tag_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`logistic_item_id`,`logistic_tag_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_locations`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_locations` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) NOT NULL,\n  `address` varchar(255) DEFAULT NULL,\n  `postcode` varchar(16) DEFAULT NULL,\n  `longitude` varchar(16) DEFAULT \'0\',\n  `latitude` varchar(16) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_statuses`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_statuses` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) NOT NULL,\n  `canonicalname` varchar(255) NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_storages`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_storages` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) NOT NULL,\n  `logistic_location_id` int(10) unsigned NOT NULL,\n  `comment` text,\n  `deleted` tinyint(1) DEFAULT \'0\',\n  `event_id` int(10) unsigned DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_suppliers`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_suppliers` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `company` varchar(255) NOT NULL,\n  `contact` varchar(25) DEFAULT NULL,\n  `email` varchar(255) NOT NULL,\n  `address` varchar(255) DEFAULT NULL,\n  `postcode` varchar(16) DEFAULT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_tags`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_tags` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) NOT NULL,\n  `comment` text,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_logistic_transactions`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_logistic_transactions` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `logistic_item_id` int(10) unsigned DEFAULT NULL,\n  `logistic_bulk_id` int(10) unsigned DEFAULT \'0\',\n  `logistic_status_id` int(10) unsigned NOT NULL,\n  `user_id` int(10) unsigned NOT NULL,\n  `received_user_id` int(10) unsigned NOT NULL,\n  `doneby_id` int(10) unsigned NOT NULL,\n  `donedate` datetime DEFAULT NULL,\n  `amount` int(10) unsigned DEFAULT \'0\',\n  `created` datetime DEFAULT NULL,\n  `comment` text,\n  `logistic_storage_id` int(10) unsigned DEFAULT \'0\',\n  `storage_comment` varchar(255) DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  KEY `idx_logistic_transactions_user_id` (`user_id`),\n  KEY `idx_logistic_transactions_logistic_item_id` (`logistic_item_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=2390 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_lost_and_founds`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_lost_and_founds` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `name` varchar(255) NOT NULL,\n  `type` tinyint(2) NOT NULL DEFAULT \'0\',\n  `description` text NOT NULL,\n  `found_where` text NOT NULL,\n  `found_when` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `reported_by` varchar(255) NOT NULL,\n  `reported_by_contact` text,\n  `delivered_to` varchar(255) DEFAULT NULL,\n  `delivered_to_contact` text,\n  `resolved` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `resolved_by` int(10) unsigned DEFAULT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=223 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Temporary table structure for view `wb4_mailinglistaddresses`\n--\n\nSET @saved_cs_client     = @@character_set_client;\nSET character_set_client = utf8;\n/*!50001 CREATE TABLE `wb4_mailinglistaddresses` (\n  `address` varchar(128),\n  `username` varchar(50),\n  `mailinglist` varchar(64),\n  `event_id` int(11) unsigned,\n  `event_reference` varchar(200),\n  `realname` varchar(128)\n) ENGINE=MyISAM */;\nSET character_set_client = @saved_cs_client;\n\n--\n-- Temporary table structure for view `wb4_mailinglistaddresses_notopts`\n--\n\nSET @saved_cs_client     = @@character_set_client;\nSET character_set_client = utf8;\n/*!50001 CREATE TABLE `wb4_mailinglistaddresses_notopts` (\n  `address` varchar(128),\n  `username` varchar(50),\n  `mailinglist` varchar(64),\n  `mailinglist_id` int(11) unsigned,\n  `event_id` int(11) unsigned,\n  `event_reference` varchar(200),\n  `realname` varchar(128),\n  `optional` tinyint(4)\n) ENGINE=MyISAM */;\nSET character_set_client = @saved_cs_client;\n\n--\n-- Temporary table structure for view `wb4_mailinglistmoderators`\n--\n\nSET @saved_cs_client     = @@character_set_client;\nSET character_set_client = utf8;\n/*!50001 CREATE TABLE `wb4_mailinglistmoderators` (\n  `email` varchar(128),\n  `mailinglist` varchar(64),\n  `moderatorpassword` varchar(32)\n) ENGINE=MyISAM */;\nSET character_set_client = @saved_cs_client;\n\n--\n-- Table structure for table `wb4_mailinglistrule_teams`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_mailinglistrule_teams` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `mailinglist_id` int(10) unsigned NOT NULL,\n  `action` enum(\'add\',\'remove\') DEFAULT NULL,\n  `team_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`),\n  KEY `mailinglist_id` (`mailinglist_id`),\n  KEY `team_id` (`team_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_mailinglistrule_users`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_mailinglistrule_users` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `mailinglist_id` int(10) unsigned NOT NULL,\n  `action` enum(\'add\',\'remove\') DEFAULT NULL,\n  `user_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`),\n  KEY `mailinglist_id` (`mailinglist_id`),\n  KEY `user_id` (`user_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_mailinglistrules`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_mailinglistrules` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `mailinglist_id` int(10) unsigned NOT NULL,\n  `action` enum(\'add\',\'remove\') DEFAULT NULL,\n  `crew_id` int(10) unsigned NOT NULL,\n  `leader` int(11) DEFAULT \'-1\',\n  `enable_moderator` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`),\n  KEY `mailinglist_id` (`mailinglist_id`),\n  KEY `crew_id` (`crew_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=1360 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_mailinglists`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_mailinglists` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `address` varchar(64) NOT NULL,\n  `synced` datetime DEFAULT NULL,\n  `moderatorpassword` varchar(32) NOT NULL DEFAULT \'\',\n  `crew_id` int(10) unsigned NOT NULL COMMENT \'contains the crew_id which have manage rights to this mailinglists\',\n  `optional` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`),\n  KEY `event_id` (`event_id`),\n  KEY `crew_id` (`crew_id`),\n  KEY `address` (`address`)\n) ENGINE=MyISAM AUTO_INCREMENT=285 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Temporary table structure for view `wb4_mailinglistsecurityhacks`\n--\n\nSET @saved_cs_client     = @@character_set_client;\nSET character_set_client = utf8;\n/*!50001 CREATE TABLE `wb4_mailinglistsecurityhacks` (\n  `address` varchar(128),\n  `mailinglist` varchar(36),\n  `event_id` varchar(1),\n  `event_reference` varchar(4),\n  `realname` varchar(128)\n) ENGINE=MyISAM */;\nSET character_set_client = @saved_cs_client;\n\n--\n-- Table structure for table `wb4_mailman_passwords`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_mailman_passwords` (\n  `mailinglist` varchar(255) NOT NULL DEFAULT \'\',\n  `email` varchar(255) NOT NULL,\n  `password` varchar(255) DEFAULT NULL,\n  PRIMARY KEY (`mailinglist`,`email`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_mealtimes`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_mealtimes` (\n  `user_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  `mealtime` int(10) DEFAULT \'0\',\n  PRIMARY KEY (`user_id`,`event_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_menuitems`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_menuitems` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `parent_id` int(10) unsigned DEFAULT \'0\',\n  `event_id` int(10) unsigned DEFAULT \'0\',\n  `requireevent` tinyint(1) DEFAULT \'1\',\n  `name` varchar(50) DEFAULT NULL,\n  `path` varchar(100) DEFAULT NULL,\n  `position` int(10) unsigned DEFAULT \'0\',\n  `hidden` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for menuitems\n\nINSERT INTO `wb4_menuitems` (`id`, `parent_id`, `event_id`, `requireevent`, `name`, `path`, `position`, `hidden`) VALUES\n(1, 106, 0, 1, \'Din side\', \'/Profile\', 1, 0),\n(2, 8, 0, 1, \'Ditt crew\', \'/Crew/View\', 1, 0),\n(109, 106, 0, 0, \'Change event\', \'/Event/change\', 98, 0),\n(4, 106, 0, 0, \'Logg ut\', \'/User/Logout\', 99, 0),\n(7, 35, 0, 1, \'Crewopptak\', \'/Enroll\', 1, 0),\n(8, 0, 0, 1, \'Crew\', \'/Crew\', 1, 0),\n(9, 35, 0, 1, \'IRC-nøkler\', \'/IrcChannelKeyAdmin\', 5, 0),\n(10, 35, 0, 1, \'Bildesensur\', \'/PictureApprove\', 8, 0),\n(13, 107, 0, 1, \'Cola-tavler\', \'/Scoreboard\', 8, 1),\n(14, 107, 0, 1, \'Dispatch\', \'/Dispatch\', 1, 1),\n(15, 107, 0, 1, \'Tapt og Funnet\', \'/LostFound\', 2, 1),\n(17, 107, 0, 1, \'Nøkkelkort\', \'/Keycard\', 4, 1),\n(18, 35, 0, 1, \'Oppmøtetider\', \'/ShowupTimes/moderate\', 4, 0),\n(20, 0, 0, 1, \'Administrasjon\', \'/Admin\', 4, 0),\n(23, 106, 0, 1, \'Rediger profil\', \'/Profile/Edit\', 2, 0),\n(24, 20, 0, 1, \'Bli en annen bruker\', \'/Admin/Sudo\', 7, 1),\n(33, 20, 0, 1, \'Arrangement\', \'/EventAdmin\', 1, 0),\n(35, 0, 0, 1, \'Crewadministrasjon\', \'/Crew/Edit\', 2, 0),\n(36, 106, 0, 1, \'Brukerinfo\', \'/UserPref\', 3, 1),\n(50, 35, 0, 1, \'Carplates\', \'/Carplates\', 12, 1),\n(53, 107, 0, 1, \'Logistikk\', \'/Logistic\', 3, 0),\n(60, 35, 0, 1, \'Spørsmål i søknad\', \'/ApplicationManager/Question\', 2, 0),\n(61, 35, 0, 1, \'Velkomsthilsen\', \'/ApplicationManager/Greeting\', 3, 0),\n(105, 8, 0, 1, \'Liste\', \'/Crew\', 2, 0),\n(106, 0, 0, 0, \'nick\', \'/Profile\', 5, 0),\n(107, 0, 0, 1, \'Moduler\', \'/\', 3, 0),\n(108, 35, 0, 1, \'Clothing\', \'/Clothing\', 11, 1),\n(67, 35, 0, 1, \'Medisinske behov\', \'/NeedsAdmin/medical\', 6, 0),\n(68, 35, 0, 1, \'Matallergier\', \'/NeedsAdmin/nutritional\', 7, 0),\n(71, 8, 0, 1, \'Statistikk\', \'/Crew/Statistics\', 3, 1),\n(72, 107, 0, 1, \'Presse\', \'/Press\', 5, 1),\n(77, 107, 0, 1, \'SMS\', \'/Sms\', 6, 1),\n(85, 20, 0, 1, \'Endre menyen\', \'/Admin/Menu\', 2, 1),\n(87, 8, 0, 1, \'Crewbeskrivelser\', \'/Crew/Description\', 4, 0),\n(88, 20, 0, 1, \'Crewapplication\', \'/ApplicationAdmin\', 5, 0),\n(89, 20, 0, 1, \'Enroll\', \'/EnrollAdmin\', 6, 0),\n(90, 20, 0, 1, \'ACL\', \'/Access\', 3, 0),\n(94, 20, 0, 1, \'Checkin\', \'/Checkin\', 8, 1),\n(97, 107, 0, 1, \'Slideshow\', \'/Sceneboard\', 7, 1),\n(96, 20, 0, 1, \'Epostlister\', \'/MailinglistAdmin\', 4, 0),\n(98, 35, 0, 1, \'Ryddeliste\', \'/Cleanup\', 10, 1),\n(102, 107, 0, 1, \'Sovekart\', \'/Sleeping\', 9, 1),\n(104, 35, 0, 1, \'Ditt Crew\', \'/Crew/Edit\', 0, 0),\n(110, 20, 0, 1, \'CrewAdmin\', \'/CrewAdmin\', 9, 0),\n(111, 20, 0, 1, \'FrontNewsManager\', \'/FrontNewsManager\', 10, 0),\n(113, 106, 0, 1, \'mailinglsit\', \'/MailingList\', 3, 0),\n(114, 106, 0, 1, \'privacy\', \'/Privacy\', 4, 0),\n(115, 106, 0, 1, \'needs\', \'/Needs/\', 5, 0),\n(116, 106, 0, 1, \'Creweffectsorder\', \'/CrewEffectsOrder\', 6, 0),\n(117, 20, 0, 1, \'Creweffectsitems\', \'/CrewEffectsItems\', 11, 0),\n(118, 35, 0, 1, \'Creweffectsoverview\', \'/CrewEffectsOrder/overview\', 13, 0),\n(119, 35, 0, 1, \'picture rules\', \'/PictureRule\', 9, 0),\n(120, 20, 0, 1, \'tasks\', \'/TaskAdmin\', 12, 0),\n(121, 106, 0, 1, \'showup\', \'/ShowupTimes\', 7, 0),\n(122, 107, 0, 1, \'accreditation\', \'/Accreditation\', 10, 0),\n(123, 35, 0, 1, \'Mealtime\', \'/Mealtime/view\', 14, 0),\n(124, 106, 0, 1, \'Mealtime\', \'/Mealtime\', 14, 0),\n(125, 106, 0, 1, \'carplate\', \'/Carplate\', 8, 0),\n(126, 35, 0, 1, \'carplate\', \'/CarplateAdmin\', 12, 0),\n(127, 107, 0, 1, \'slideshow\', \'/Slideshow\', 11, 0),\n(128, 107, 0, 1, \'smsmessage\', \'/SmsMessage\', 12, 0),\n(129, 8, 0, 1, \'Cleanup\', \'/Crew/Cleanup\', 5, 0),\n(130, 107, 0, 1, \'Lost and found\', \'/LostAndFound\', 5, 0),\n(131, 107, 0, 1, \'Keycard handout\', \'/KeycardHandout\', 13, 0),\n(132, 107, 0, 1, \'Keycard cards\', \'/KeycardCard\', 12, 0),\n(133, 107, 0, 1, \'sleepingmap\', \'/SleepingPlaces\', 63, 0),\n(134, 106, 0, 1, \'Kandu Membership\', \'/KanduMembership\', 5, 0),\n(135, 20, 0, 1, \'terms\', \'/TermAdmin\', 13, 0);\n\n-- Data for sms budgets menu items (not dumped data)\n\ninsert into wb4_menuitems (parent_id, name, path, position) values (20, \'SmsBudsjetter\', \'/SmsBudgetiAdmin\', 16);\nset @last_id = LAST_INSERT_ID();\ninsert into wb4_i18n (locale, model, foreign_key, field, content) values (\'nob\', \'Menuitem\', @last_id, \'name\', \'SMS-budsjetter\');\ninsert into wb4_i18n (locale, model, foreign_key, field, content) values (\'eng\', \'Menuitem\', @last_id, \'name\', \'SMS-budgets\');\n\n--\n-- Table structure for table `wb4_message_senders`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_message_senders` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) NOT NULL,\n  `email` varchar(255) NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_messages`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_messages` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned DEFAULT NULL,\n  `crew_id` int(10) unsigned DEFAULT NULL,\n  `team_id` int(10) unsigned DEFAULT NULL,\n  `message_sender_id` int(10) unsigned NOT NULL,\n  `sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  `content` text,\n  `subject` varchar(255) NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_needs`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_needs` (\n  `user_id` int(10) NOT NULL,\n  `medicalneeds` text,\n  `nutritionalneeds` text,\n  PRIMARY KEY (`user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_phonetypes`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_phonetypes` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(200) NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for phonetypes\n\nINSERT INTO `wb4_phonetypes` (`id`, `name`) VALUES\n(1, \'Mobil\'),\n(2, \'Hjem\'),\n(3, \'Arbeid\');\n\n--\n-- Table structure for table `wb4_picture_approval_statuses`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_picture_approval_statuses` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `picture_approval_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  `fetched` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `printed` datetime DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=InnoDB AUTO_INCREMENT=1102 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_picture_approvals`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_picture_approvals` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `user_id` int(10) unsigned NOT NULL,\n  `approved` tinyint(1) DEFAULT \'0\',\n  `picture_rule_id` int(10) unsigned DEFAULT \'0\',\n  `custom_denied_reason` text,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `user_id` (`user_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=2038 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for picture_approvals\n\nINSERT INTO `wb4_picture_approvals` (`id`, `updated`, `user_id`, `approved`, `picture_rule_id`, `custom_denied_reason`) VALUES\n(1794, \'2013-01-29 00:42:45\', 6389, 0, 0, NULL),\n(1795, \'2013-01-29 00:48:00\', 6390, 0, 0, NULL),\n(1796, \'2013-01-29 00:58:32\', 1, 0, 0, NULL),\n(1797, \'2013-02-17 04:43:33\', 6391, 0, 0, NULL),\n(1798, \'2013-02-22 10:42:31\', 1918, 0, 0, NULL);\n\n--\n-- Table structure for table `wb4_picture_rules`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_picture_rules` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `rule_text` text,\n  `denied_text` text,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_secure_files`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_secure_files` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `path` varchar(255) NOT NULL,\n  `expires` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `name` varchar(255) DEFAULT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_showup_times`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_showup_times` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  `date` varchar(50) DEFAULT NULL,\n  `hour` varchar(50) DEFAULT NULL,\n  `comment` text,\n  `approved` int(1) DEFAULT NULL,\n  `message` text,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=730 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_sleeping_places`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_sleeping_places` (\n  `section` varchar(20) DEFAULT NULL,\n  `status` tinyint(4) DEFAULT NULL\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_slideshows`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_slideshows` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) DEFAULT NULL,\n  `description` text,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_slideshows_slides`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_slideshows_slides` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) DEFAULT NULL,\n  `title` varchar(255) DEFAULT NULL,\n  `content` text,\n  `bg_url` varchar(255) DEFAULT NULL,\n  `url` varchar(255) DEFAULT NULL,\n  `date_from` datetime DEFAULT NULL,\n  `date_to` datetime DEFAULT NULL,\n  `duration` int(10) DEFAULT NULL,\n  `show_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_sms_budgets`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_sms_budgets` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `sms_sent` int(11) DEFAULT NULL,\n  `sms_limit` int(11) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  `event_id` int(11) DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_sms_messages`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_sms_messages` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `number` varchar(20) CHARACTER SET latin1 DEFAULT NULL,\n  `message` text CHARACTER SET latin1,\n  `sent` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=8635 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_tasks`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_tasks` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(50) NOT NULL,\n  `message` text,\n  `redirect` varchar(255) NOT NULL,\n  `enabled` tinyint(1) DEFAULT \'0\',\n  `event_id` int(10) unsigned NOT NULL,\n  `allow_sub` tinyint(1) DEFAULT \'0\',\n  `model` varchar(255) DEFAULT \'\',\n  `condition` text,\n  `complete_with_model` tinyint(1) DEFAULT NULL,\n  `skip_button` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for tasks\n\nINSERT INTO `wb4_tasks` (`id`, `name`, `message`, `redirect`, `enabled`, `event_id`, `allow_sub`, `model`, `condition`, `complete_with_model`, `skip_button`) VALUES\n(1, \'\', NULL, \'\', 0, 16, 0, \'\', \'\', 1, 0),\n(2, \'Creweffekter\', \'Please fill in your size\', \'/CrewEffectsOrder\', 1, 16, 0, \'CrewEffectsOrder\', \'App::import(\'\'Model\'\',\'\'CrewEffectsOrder\'\');\r\n$model = new CrewEffectsOrder();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(3, \'Needs\', \'Please fill in any needs you might have\', \'/Needs\', 1, 16, 0, \'Needs\', \'\', 1, 1),\n(4, \'Oppmøte\', \'Please set your showup time\', \'/ShowupTimes\', 1, 16, 0, \'ShowupTime\', \'App::import(\'\'Model\'\',\'\'ShowupTime\'\');\r\n$model = new ShowupTime();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(5, \'Oppmøte avslått\', \'You showup time has been denied, please provide a new\', \'/ShowupTimes\', 0, 16, 0, \'ShowupTime\', \'App::import(\'\'Model\'\',\'\'ShowupTime\'\');\r\n$model = new ShowupTime();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\r\nif(empty($result)) {\r\n  $result = true;\r\n} else if(!empty($result) && $result[\'\'ShowupTime\'\'][\'\'approved\'\'] == 1) {\r\n  $result = null;\r\n}\', 1, 0),\n(6, \'Mattid\', \'Please choose you meal time\', \'/Mealtime\', 1, 16, 0, \'Mealtime\', \'App::import(\'\'Model\'\',\'\'Mealtime\'\');\r\n$model = new Mealtime();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(7, \'KANDU-medlemskap\', \'b\', \'/KanduMembership\', 0, 16, 1, \'KanduMembership\', \'App::import(\'\'Model\'\',\'\'KanduMembership\'\');\r\n$model = new KanduMembership();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(8, \'Creweffekter\', \'Please fill in your size\', \'/CrewEffectsOrder\', 0, 17, 0, \'CrewEffectsOrder\', \'App::import(\'\'Model\'\',\'\'CrewEffectsOrder\'\');\r\n$model = new CrewEffectsOrder();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(9, \'Needs\', \'Please fill in any needs you might have\', \'/Needs\', 0, 17, 0, \'Needs\', \'\', 1, 1),\n(10, \'Oppmøte avslått\', \'Please set your showup time\', \'/ShowupTimes\', 0, 17, 0, \'ShowupTime\', \'App::import(\'\'Model\'\',\'\'ShowupTime\'\');\r\n$model = new ShowupTime();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(11, \'Mattid\', \'Please choose you meal time\', \'/Mealtime\', 0, 17, 0, \'Mealtime\', \'App::import(\'\'Model\'\',\'\'Mealtime\'\');\r\n$model = new Mealtime();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0),\n(12, \'KANDU-medlemskap\', \'Choose your membership\', \'/KanduMembership\', 0, 17, 1, \'KanduMembership\', \'App::import(\'\'Model\'\',\'\'KanduMembership\'\');\r\n$model = new KanduMembership();\r\n$result = $model->find(\'\'first\'\', array(\r\n  \'\'conditions\'\' => array(\r\n    \'\'event_id\'\' => WB::$event->id,\r\n    \'\'user_id\'\' => WB::$user[\'\'User\'\'][\'\'id\'\']\r\n  )\r\n));\', 0, 0);\n\n--\n-- Table structure for table `wb4_teams`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_teams` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `crew_id` int(10) unsigned NOT NULL,\n  `name` varchar(64) NOT NULL,\n  `locked` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=864 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for teams\n\nINSERT INTO `wb4_teams` (`id`, `crew_id`, `name`, `locked`) VALUES\n(0, 0, \'NO\', 0);\n\n--\n-- Table structure for table `wb4_terms`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_terms` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `title` varchar(50) NOT NULL,\n  `content` text,\n  `version` varchar(50) DEFAULT NULL,\n  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  `active` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for terms\n\nINSERT INTO `wb4_terms` (`id`, `event_id`, `title`, `content`, `version`, `updated`, `active`) VALUES\n(2, 17, \'Terms\', \'As a volunteering crew member, I acknowledge that requirements are set for myself and my efforts.\r\n\r\nThe organizer of The Gathering, KANDU, may freely use any and all work produced for The Gathering, for example developed systems, graphics, concepts and more.\r\n\r\nKANDU retains the right to use everything developed and produced by the crew member also after the member ends involvement in the organization. The product may also be further developed by The Gathering.\r\n\r\nThe crew member who produced and/or developed the product will nevertheless retain the right to further develop and/or sell the product after the involvement in the organization is ended.\r\n\r\nKANDU may not resell the product, but shall be free to use it as long as it is not used in a commercial context.\', \'1.1\', \'2012-12-01 21:29:58\', 1);\n\n--\n-- Table structure for table `wb4_user_mailprefs`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_user_mailprefs` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  `mailinglist_id` int(10) unsigned NOT NULL,\n  `subscribe` tinyint(1) DEFAULT \'1\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=5534 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_user_privacies`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_user_privacies` (\n  `user_id` int(10) unsigned NOT NULL,\n  `address` tinyint(1) DEFAULT \'0\',\n  `email` tinyint(1) DEFAULT \'0\',\n  `phone` tinyint(1) DEFAULT \'0\',\n  `birth` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_user_profile_hashes`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_user_profile_hashes` (\n  `user_id` int(10) unsigned NOT NULL,\n  `hash` varchar(25) DEFAULT \'0\',\n  PRIMARY KEY (`user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_user_tasks`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_user_tasks` (\n  `user_id` int(10) unsigned NOT NULL,\n  `task_id` int(10) unsigned NOT NULL,\n  `completed` tinyint(1) DEFAULT \'0\',\n  `event_id` int(10) unsigned NOT NULL,\n  UNIQUE KEY `task_id` (`task_id`,`user_id`,`event_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_user_terms`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_user_terms` (\n  `user_id` int(10) unsigned NOT NULL,\n  `event_id` int(10) unsigned NOT NULL,\n  `accepted` datetime DEFAULT \'0000-00-00 00:00:00\',\n  UNIQUE KEY `user_id` (`user_id`,`event_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_userhistories`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_userhistories` (\n  `user_id` int(10) unsigned NOT NULL,\n  `eventname` varchar(64) NOT NULL DEFAULT \'\',\n  `crewname` varchar(64) DEFAULT NULL,\n  `title` varchar(32) DEFAULT NULL,\n  PRIMARY KEY (`user_id`,`eventname`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_userims`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_userims` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned NOT NULL,\n  `improtocol_id` int(10) unsigned NOT NULL,\n  `address` varchar(128) NOT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=9707 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_userphones`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_userphones` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `user_id` int(10) unsigned NOT NULL,\n  `number` varchar(32) NOT NULL,\n  `operator` varchar(20) NOT NULL,\n  `phonetype_id` int(10) unsigned NOT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  PRIMARY KEY (`id`),\n  KEY `phonenumber` (`number`),\n  KEY `phonenumber_id` (`number`,`user_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=10648 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_users`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_users` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `username` varchar(50) NOT NULL,\n  `password` varchar(128) NOT NULL,\n  `realname` varchar(128) NOT NULL,\n  `address` varchar(128) DEFAULT NULL,\n  `postcode` varchar(16) DEFAULT NULL,\n  `town` varchar(50) DEFAULT NULL,\n  `countrycode` varchar(8) DEFAULT NULL,\n  `email` varchar(128) DEFAULT NULL,\n  `birth` datetime DEFAULT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `updated` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `deleted` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `sexe` enum(\'undefined\',\'male\',\'female\') DEFAULT \'undefined\',\n  `verified` datetime NOT NULL,\n  `verificationcode` varchar(128) DEFAULT NULL,\n  `nickname` varchar(128) NOT NULL,\n  `image` varchar(128) DEFAULT NULL,\n  `resetpasswordcode` varchar(48) DEFAULT NULL,\n  `longitude` varchar(16) DEFAULT \'0\',\n  `latitude` varchar(16) DEFAULT \'0\',\n  `lastactive` datetime DEFAULT NULL,\n  `language` varchar(8) DEFAULT \'\',\n  `registered` text,\n  PRIMARY KEY (`id`),\n  KEY `email` (`email`),\n  KEY `user_id` (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=6483 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for users \n\nINSERT INTO `wb4_users` (`id`, `username`, `password`, `realname`, `address`, `postcode`, `town`, `countrycode`, `email`, `birth`, `created`, `updated`, `deleted`, `sexe`, `verified`, `verificationcode`, `nickname`, `image`, `resetpasswordcode`, `longitude`, `latitude`, `lastactive`, `language`, `registered`) VALUES\n(1, \'dev\', \'00b540c76dafa6dd46e4fab60826c3d7\', \'Dev root\', \'Bedringens vei 1\', \'1920\', \'SØRUMSAND\', \'NO\', \'root@localhost\', \'1985-01-01 00:00:00\', \'2013-01-29 00:45:03\', \'2013-01-29 01:17:57\', \'0000-00-00 00:00:00\', \'male\', \'2013-01-29 00:58:32\', \'8fb9e87edb1d1f65f88d75f9128b7e0b\', \'root\', NULL, NULL, \'0\', \'0\', NULL, \'eng\', \'done\'),\n(1918, \'existemi\', \'35002b1c555ad3b0bb4af8e90d511294\', \'Roy Viggo Larsen\', \'Jernbanevegen 14\', \'1920\', \'SØRUMSAND\', \'NO\', \'roy@existemi.no\', \'1985-11-03 00:00:00\', \'2013-02-17 04:43:11\', \'2013-02-17 04:50:51\', \'0000-00-00 00:00:00\', \'male\', \'2013-02-17 04:43:33\', \'26d478835a727e18216b5b995f9c0a11\', \'existemi\', NULL, NULL, \'0\', \'0\', NULL, \'eng\', \'done\'),\n(2193,\'Spacix\',\'70352d0eca0385ee574dcfb232eb1e8c\',\'Aleksander Grande\',\'Simensbråtveien 25\',\'1182\',\'OSLO\',\'NO\',\'aleksandergrande@gmail.com\',\'1983-09-25 00:00:00\',\'2006-10-23 08:08:17\',\'2012-01-26 12:17:34\',\'0000-00-00 00:00:00\',\'male\',\'2006-10-23 08:08:42\',\'1a3ea9de2663094681bc56b64dea7c52\',\'Spacix\',NULL,NULL,\'10.7961830\',\'59.8993821\',\'2013-03-25 19:15:42\',\'nob\',\'done\'),\n(3073,\'Menelya\',\'e45392a9d9f6db3657386d3d5e743840\',\'Therese Hansen\',\'Lindebergåsen 60 A\',\'1068\',\'OSLO\',\'NO\',\'tg@blowjob.no\',\'1985-05-31 00:00:00\',\'2006-10-23 12:12:10\',\'2012-12-14 00:05:52\',\'0000-00-00 00:00:00\',\'female\',\'2006-10-23 12:12:45\',\'bbd4274feb0bbd38abe776976b8a718f\',\'Menelya\',NULL,NULL,\'10.8846134\',\'59.9307207\',\'2013-03-25 19:13:22\',\'nob\',\'done\'),\n(4304,\'fictive\',\'a54d33d925619b59877f23ca4bd9d65e\',\'Espen Jacobsson\',\'Stokkanhaugen 174\',\'7048\',\'TRONDHEIM\',\'NO\',\'espenjacobsson@gmail.com\',\'1988-03-13 00:00:00\',\'2008-01-28 15:01:06\',\'2013-03-05 20:21:17\',\'0000-00-00 00:00:00\',\'male\',\'2008-01-28 15:02:18\',\'4f74576e1880089b49e227fdaadb6717\',\'fictive\',NULL,NULL,\'10.4125019\',\'63.4147373\',\'2013-03-25 16:39:17\',\'eng\',\'done\'),\n(4607,\'evegard\',\'05a4c8eb58ceaa1feb303a01795c3d6e\',\'Vegard Edvardsen\',\'Blestervegen 22\',\'2618\',\'Lillehammer\',\'NO\',\'vegard.edvardsen@gmail.com\',\'1990-03-19 00:00:00\',\'2008-11-19 19:50:50\',\'2013-01-07 18:15:02\',\'0000-00-00 00:00:00\',\'male\',\'2013-01-07 18:15:02\',\'901fb2470f2884f9bb721c60adbaed33\',\'evegard\',NULL,NULL,\'10.4662306\',\'61.1152713\',\'2013-03-25 15:40:25\',\'nob\',\'done\'),\n(4918,\'lizter\',\'7f46a9a89ff6efcda5f34b56edf38240\',\'Christian Strand Young\',\'Eirik Jarls gate 6\',\'7030\',\'TRONDHEIM\',\'NO\',\'christian@strandyoung.com\',\'1990-04-03 00:00:00\',\'2009-04-14 00:46:51\',\'2013-03-19 20:18:41\',\'0000-00-00 00:00:00\',\'male\',\'2009-04-14 00:47:13\',\'84d4edaf8c58f753075984b42d5269fc\',\'lizter\',NULL,NULL,\'10.4252449\',\'63.4170905\',\'2013-03-25 19:08:17\',\'nob\',\'done\'),\n(6195,\'melwil\',\'6da9c569e267242778608f2edc2a4a5b\',\'Håvard Slettvold\',\'Dalavegen 50\',\'6856\',\'SOGNDAL\',\'NO\',\'slettvold@gmail.com\',\'1986-08-25 00:00:00\',\'2012-11-06 21:14:11\',\'2013-03-03 20:22:11\',\'0000-00-00 00:00:00\',\'male\',\'2012-11-06 21:14:19\',\'6045cd9335149c88a25d2a6e097281df\',\'melwil\',NULL,NULL,\'0\',\'0\',\'2013-03-25 19:19:03\',\'eng\',\'done\');\n\n--\n-- Table structure for table `wb4_vote_campaigns`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_vote_campaigns` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `name` varchar(255) NOT NULL,\n  `starts` datetime NOT NULL,\n  `ends` datetime NOT NULL,\n  `created` datetime NOT NULL,\n  `deleted` datetime NOT NULL,\n  `description` text,\n  `passphrase` varchar(25) DEFAULT NULL,\n  `short_desc` varchar(50) DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_vote_options`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_vote_options` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `campaign_id` int(10) unsigned NOT NULL,\n  `name` varchar(255) NOT NULL,\n  `url` varchar(255) DEFAULT NULL,\n  `created` datetime NOT NULL,\n  `deleted` datetime NOT NULL,\n  `description` text NOT NULL,\n  `user_id` int(10) unsigned DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_vote_votes`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_vote_votes` (\n  `campaign_id` int(10) unsigned NOT NULL,\n  `option_id` int(10) unsigned NOT NULL,\n  `user_id` int(10) unsigned NOT NULL,\n  `created` datetime DEFAULT NULL,\n  PRIMARY KEY (`campaign_id`,`user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_wardrobe_card_borrowers`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_wardrobe_card_borrowers` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `name` varchar(255) DEFAULT NULL,\n  `seat` varchar(255) DEFAULT NULL,\n  `row` varchar(255) DEFAULT NULL,\n  `deposit` varchar(255) DEFAULT NULL,\n  `wardrobe_card_id` int(10) unsigned NOT NULL,\n  `phone` varchar(255) DEFAULT NULL,\n  `deposit_comment` varchar(255) DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_wardrobe_cards`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_wardrobe_cards` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `card` varchar(255) DEFAULT NULL,\n  `wardrobe` varchar(255) DEFAULT NULL,\n  `in_use` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_wikipages`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_wikipages` (\n  `title` varchar(255) NOT NULL,\n  `revision` int(10) unsigned NOT NULL,\n  `created` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `user_id` int(10) unsigned NOT NULL,\n  `comment` varchar(255) DEFAULT NULL,\n  `content` mediumtext,\n  `event_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`title`,`revision`),\n  KEY `wikipages_ix` (`title`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_wikirelations`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_wikirelations` (\n  `wikipage_title` varchar(255) NOT NULL,\n  `table` varchar(16) NOT NULL,\n  `table_id` int(10) unsigned NOT NULL\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Final view structure for view `wb4_mailinglistaddresses`\n--\n\n/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistaddresses`*/;\n/*!50001 SET @saved_cs_client          = @@character_set_client */;\n/*!50001 SET @saved_cs_results         = @@character_set_results */;\n/*!50001 SET @saved_col_connection     = @@collation_connection */;\n/*!50001 SET character_set_client      = latin1 */;\n/*!50001 SET character_set_results     = latin1 */;\n/*!50001 SET collation_connection      = latin1_swedish_ci */;\n/*!50001 CREATE ALGORITHM=UNDEFINED */\n/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */\n/*!50001 VIEW `wb4_mailinglistaddresses` AS (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrules` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`crew_id` = `uc`.`crew_id`) and (`mr`.`action` = \'add\') and (`uc`.`leader` >= `mr`.`leader`) and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`) and (((`m`.`optional` = 1) and ((select `ui`.`subscribe` from `wb4_user_mailprefs` `ui` where ((`ui`.`user_id` = `u`.`id`) and (`ui`.`event_id` = `e`.`id`) and (`ui`.`mailinglist_id` = `m`.`id`)) limit 1) = 1)) or (`m`.`optional` <> 1)))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_teams` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`team_id` = `uc`.`team_id`) and (`mr`.`action` = \'add\') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`) and (((`m`.`optional` = 1) and ((select `ui`.`subscribe` from `wb4_user_mailprefs` `ui` where ((`ui`.`user_id` = `u`.`id`) and (`ui`.`event_id` = `e`.`id`) and (`ui`.`mailinglist_id` = `m`.`id`) and (`ui`.`subscribe` = 1)) limit 1) = 1)) or (`m`.`optional` <> 1)))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_users` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`user_id` = `uc`.`user_id`) and (`mr`.`action` = \'add\') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`) and (((`m`.`optional` = 1) and ((select `ui`.`subscribe` from `wb4_user_mailprefs` `ui` where ((`ui`.`user_id` = `u`.`id`) and (`ui`.`event_id` = `e`.`id`) and (`ui`.`mailinglist_id` = `m`.`id`) and (`ui`.`subscribe` = 1)) limit 1) = 1)) or (`m`.`optional` <> 1)))) */;\n/*!50001 SET character_set_client      = @saved_cs_client */;\n/*!50001 SET character_set_results     = @saved_cs_results */;\n/*!50001 SET collation_connection      = @saved_col_connection */;\n\n--\n-- Final view structure for view `wb4_mailinglistaddresses_notopts`\n--\n\n/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistaddresses_notopts`*/;\n/*!50001 SET @saved_cs_client          = @@character_set_client */;\n/*!50001 SET @saved_cs_results         = @@character_set_results */;\n/*!50001 SET @saved_col_connection     = @@collation_connection */;\n/*!50001 SET character_set_client      = latin1 */;\n/*!50001 SET character_set_results     = latin1 */;\n/*!50001 SET collation_connection      = latin1_swedish_ci */;\n/*!50001 CREATE ALGORITHM=UNDEFINED */\n/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */\n/*!50001 VIEW `wb4_mailinglistaddresses_notopts` AS (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`id` AS `mailinglist_id`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname`,`m`.`optional` AS `optional` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrules` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`crew_id` = `uc`.`crew_id`) and (`mr`.`action` = \'add\') and (`uc`.`leader` >= `mr`.`leader`) and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`id` AS `mailinglist_id`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname`,`m`.`optional` AS `optional` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_teams` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`team_id` = `uc`.`team_id`) and (`mr`.`action` = \'add\') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`id` AS `mailinglist_id`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname`,`m`.`optional` AS `optional` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_users` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`user_id` = `uc`.`user_id`) and (`mr`.`action` = \'add\') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`))) */;\n/*!50001 SET character_set_client      = @saved_cs_client */;\n/*!50001 SET character_set_results     = @saved_cs_results */;\n/*!50001 SET collation_connection      = @saved_col_connection */;\n\n--\n-- Final view structure for view `wb4_mailinglistmoderators`\n--\n\n/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistmoderators`*/;\n/*!50001 SET @saved_cs_client          = @@character_set_client */;\n/*!50001 SET @saved_cs_results         = @@character_set_results */;\n/*!50001 SET @saved_col_connection     = @@collation_connection */;\n/*!50001 SET character_set_client      = latin1 */;\n/*!50001 SET character_set_results     = latin1 */;\n/*!50001 SET collation_connection      = latin1_swedish_ci */;\n/*!50001 CREATE ALGORITHM=UNDEFINED */\n/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */\n/*!50001 VIEW `wb4_mailinglistmoderators` AS (select distinct `u`.`email` AS `email`,`m`.`address` AS `mailinglist`,`m`.`moderatorpassword` AS `moderatorpassword` from ((((`wb4_mailinglists` `m` join `wb4_users` `u`) join `wb4_crews_users` `uc`) join `wb4_crews` `c`) join `wb4_mailinglistrules` `mrule`) where ((`uc`.`user_id` = `u`.`id`) and (`m`.`id` = `mrule`.`mailinglist_id`) and (`uc`.`crew_id` = `mrule`.`crew_id`) and (((`c`.`id` = `uc`.`crew_id`) and ((`c`.`id` = `m`.`crew_id`) or (`mrule`.`enable_moderator` = 1))) or (`uc`.`crew_id` = (select `c2`.`id` from `wb4_crews` `c2` where (`c2`.`id` = `c`.`crew_id`)))) and (`uc`.`leader` > 2) and ((`m`.`crew_id` > 0) or (`mrule`.`enable_moderator` = 1)))) */;\n/*!50001 SET character_set_client      = @saved_cs_client */;\n/*!50001 SET character_set_results     = @saved_cs_results */;\n/*!50001 SET collation_connection      = @saved_col_connection */;\n\n/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;\n/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;\n/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\n/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;\n\n-- Dump completed on 2013-03-29 20:53:57\n\n-- Dev data\ninsert into wb4_sms_budgets (sms_sent, sms_limit, user_id, event_id) values (10, 20, 4304, 18);\ninsert into wb4_sms_budgets (sms_sent, sms_limit, user_id, event_id) values (50, 100, 4918, 18);\ninsert into wb4_sms_budgets (sms_sent, sms_limit, user_id, event_id) values (10, 100, 6195, 18);\n\n','\n\n'),(3,'20140224180420',NULL,'20140224180420_added_tables_for_cfad_plugin.migration','\nCREATE TABLE IF NOT EXISTS `wb4_cfad_application_available_fields` (\n    `id` int(11) NOT NULL AUTO_INCREMENT,\n    `event_id` int(11) DEFAULT NULL,\n    `application_fieldtype_id` int(11) DEFAULT NULL,\n    `application_page_id` int(11) DEFAULT NULL,\n    `name` varchar(50) DEFAULT NULL,\n    `description` text,\n    `created` datetime DEFAULT NULL,\n    `updated` datetime DEFAULT NULL,\n    `deleted` datetime DEFAULT NULL,\n    `crew_id` int(11) DEFAULT NULL,\n    `user_id` int(11) DEFAULT NULL,\n    PRIMARY KEY (`id`),\n    KEY `crewapplication_fieldtype_id` (`application_fieldtype_id`),\n    KEY `crewapplication_page_id` (`application_page_id`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_application_choices` (\n    `application_document_id` int(11) DEFAULT NULL,\n    `crew_id` int(11) DEFAULT NULL,\n    `event_id` int(11) DEFAULT NULL,\n    `priority` int(11) NOT NULL,\n    `revision` int(11) DEFAULT \'0\',\n    `draft` tinyint(4) DEFAULT \'1\',\n    `handled` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n    `accepted` tinyint(4) DEFAULT \'0\' COMMENT \'Contains 1 if the choice is accepted\',\n    `denied` tinyint(4) DEFAULT \'0\' COMMENT \'Contains 1 if the choice is denied.\',\n    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n    PRIMARY KEY (`id`),\n    KEY `crewapplication_document_id` (`application_document_id`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_application_documents` (\n    `id` int(11) NOT NULL AUTO_INCREMENT,\n    `event_id` int(11) DEFAULT NULL,\n    `user_id` int(11) DEFAULT NULL,\n    `created` datetime DEFAULT NULL,\n    `updated` datetime DEFAULT NULL,\n    `deleted` datetime DEFAULT NULL,\n    `draft` tinyint(4) DEFAULT \'1\',\n    `handled` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n    PRIMARY KEY (`id`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_application_fields` (\n    `id` int(11) NOT NULL AUTO_INCREMENT,\n    `application_document_id` int(11) DEFAULT NULL,\n    `application_availablefield_id` int(11) DEFAULT NULL,\n    `value` blob,\n    `revision` int(11) DEFAULT \'0\',\n    `created` datetime DEFAULT NULL,\n    `draft` tinyint(4) DEFAULT \'1\',\n    `crew_id` int(11) DEFAULT \'0\',\n    PRIMARY KEY (`id`),\n    KEY `crewapplication_availablefield_id` (`application_availablefield_id`),\n    KEY `crewapplication_document_id` (`application_document_id`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_application_pages` (\n    `id` int(11) NOT NULL AUTO_INCREMENT,\n    `event_id` int(11) DEFAULT NULL,\n    `name` varchar(128) DEFAULT NULL,\n    `description` text,\n    `position` int(11) DEFAULT \'0\',\n    `type` enum(\'custom\',\'crewchoice\',\'crewwhy\',\'crewfield\') DEFAULT NULL,\n    `crew_id` int(11) DEFAULT NULL,\n    PRIMARY KEY (`id`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_application_settings` (\n    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n    `choices` int(11) unsigned DEFAULT \'3\',\n    `can_apply` int(11) unsigned DEFAULT \'0\',\n    `event_id` int(10) unsigned NOT NULL,\n    PRIMARY KEY (`id`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_crews` (\n    `crew_id` int(10) unsigned NOT NULL,\n    `event_id` int(10) unsigned NOT NULL,\n    PRIMARY KEY (`crew_id`)\n) ENGINE=InnoDB DEFAULT CHARSET=utf8;\n\nCREATE TABLE IF NOT EXISTS `wb4_cfad_users` (\n    `user_id` int(10) unsigned NOT NULL,\n    `crew_id` int(10) unsigned NOT NULL,\n    `assigned` datetime DEFAULT NULL\n) ENGINE=InnoDB DEFAULT CHARSET=utf8;\n','\n\nDROP TABLE IF EXISTS `wb4_cfad_application_available_fields`;\n\nDROP TABLE IF EXISTS `wb4_cfad_application_choices`;\n\nDROP TABLE IF EXISTS `wb4_cfad_application_documents`;\n\nDROP TABLE IF EXISTS `wb4_cfad_application_fields`;\n\nDROP TABLE IF EXISTS `wb4_cfad_application_pages`;\n\nDROP TABLE IF EXISTS `wb4_cfad_application_settings`;\n\nDROP TABLE IF EXISTS `wb4_cfad_crews`;\n\nDROP TABLE IF EXISTS `wb4_cfad_users`;\n\n'),(4,'20140302163947',NULL,'20140302163947_added_required_inserts_for_logistic_statuses.migration','\nLOCK TABLES `wb4_logistic_statuses` WRITE;\nDELETE FROM `wb4_logistic_statuses`;\n/*!40000 ALTER TABLE `wb4_logistic_statuses` DISABLE KEYS */;\nINSERT INTO `wb4_logistic_statuses` VALUES (1,\'REGISTERED\',\'Registered\'),(2,\'IN_TRANSIT\',\'In transit\'),(3,\'ARRIVED\',\'Arrived\'),(4,\'CHECKED_OUT\',\'Checked out\'),(5,\'CHECKED_IN\',\'Checked in\'),(6,\'RETURNED\',\'Returned\'),(7,\'MOVED\',\'Moved\'),(8,\'UNREGISTERED\',\'Unregistered\'),(9,\'REREGISTERED\',\'Re-registered\');                                                    \n/*!40000 ALTER TABLE `wb4_logistic_statuses` ENABLE KEYS */;\nUNLOCK TABLES;\n','\nLOCK TABLES `wb4_logistic_statuses` WRITE;\nDELETE FROM `wb4_logistic_statuses`;\nUNLOCK TABLES;\n'),(5,'20140302191956',NULL,'20140302191956_removed_event_id_from_logistic_tables.migration','\nalter table wb4_logistic_bulks drop column event_id;\nalter table wb4_logistic_items drop column event_id;\nalter table wb4_logistic_storages drop column event_id;\nalter table wb4_logistic_suppliers drop column event_id;\nalter table wb4_logistic_tags drop column event_id;\n\n','\nalter table wb4_logistic_bulks add column event_id int(10) unsigned default 0;\nalter table wb4_logistic_items add column event_id int(10) unsigned default 0;\nalter table wb4_logistic_storages add column event_id int(10) unsigned default 0;\nalter table wb4_logistic_suppliers add column event_id int(10) unsigned default 0;\nalter table wb4_logistic_tags add column event_id int(10) unsigned default 0;\n\n'),(6,'20140303121454',NULL,'20140303121454_added_date_column_for_cfad_users.migration','\nalter table wb4_cfad_users add column date datetime;\n\n','\nalter table wb4_cfad_users drop column date;\n\n'),(7,'20140303150121',NULL,'20140303150121_added_id_to_cfad_users.migration','\nALTER TABLE wb4_cfad_users ADD COLUMN id int(10) unsigned not null auto_increment primary key FIRST;\n\n','\nALTER TABLE wb4_cfad_users DROP COLUMN id;\n\n'),(8,'20140304084045',NULL,'20140304084045_added_required_inserts_for_application_fieldtype.migration','\nLOCK TABLES `wb4_application_field_types` WRITE;\nDELETE FROM `wb4_application_field_types`;\n/*!40000 ALTER TABLE `wb4_application_field_types` DISABLE KEYS */;\nINSERT INTO `wb4_application_field_types` VALUES (6,\'textarea\'),(7,\'text\'),(8,\'crewchoice\'),(9,\'checkbox\'),(10,\'crewwhy\');                                                    \n/*!40000 ALTER TABLE `wb4_application_field_types` ENABLE KEYS */;\nUNLOCK TABLES;\n','\nLOCK TABLES `wb4_application_field_types` WRITE;\nDELETE FROM `wb4_application_field_types`;\nUNLOCK TABLES;\n'),(9,'20140304162846',NULL,'20140304162846_added_type_column_to_logistic_bulks.migration','\nALTER TABLE wb4_logistic_bulks ADD COLUMN type enum(\'series\',\'bulk\');\n\n','\nALTER TABLE wb4_logistic_bulks DROP COLUMN type;\n\n'),(10,'20140322112713',NULL,'20140322112713_alter_table_irc_channel_crews_add_column_id.migration','\nALTER TABLE wb4_irc_channel_key_crews DROP primary key;\nALTER TABLE wb4_irc_channel_key_crews ADD COLUMN id int(10) unsigned auto_increment PRIMARY KEY FIRST;\n','\nALTER TABLE wb4_irc_channel_key_crews DROP COLUMN id;\nALTER TABLE wb4_irc_channel_key_crews ADD PRIMARY KEY (irc_channel_key_id, crew_id);\n'),(11,'20140322161900',NULL,'20140322161900_added_prev_storage_column_to_logistic_transactions.migration','\nALTER TABLE wb4_logistic_transactions ADD COLUMN prev_logistic_storage_id INT AFTER logistic_storage_id;\n\n','\nALTER TABLE wb4_logistic_transactions DROP COLUMN prev_logistic_storage_id;\n\n'),(12,'20140322174206',NULL,'20140322174206_added_datetime_col_to_logistic_transactions.migration','\nalter table wb4_logistic_transactions add column deleted datetime default NULL;\n','\nalter table wb4_logistic_transactions drop column deleted;\n'),(13,'20140322175004',NULL,'20140322175004_logistic_hand_out_comments.migration','\nALTER TABLE wb4_logistic_transactions ADD COLUMN hand_out_comment TEXT;\nALTER TABLE wb4_logistic_transactions DROP COLUMN received_user_id;\n','\nALTER TABLE wb4_logistic_transactions DROP COLUMN hand_out_comment;\n'),(14,'20140323180155',NULL,'20140323180155_fix_smsbudget_menulink.migration','\nUPDATE wb4_menuitems SET path = \"/SmsBudgetAdmin\" WHERE path = \"/SmsBudgetiAdmin\";\n','\n\n'),(15,'20140330000000',NULL,'20140330000000_cleanup_initial.migration','\nDROP TABLE IF EXISTS `wb4_cleanups`;\nDROP TABLE IF EXISTS `wb4_cleanup_dates`;\nDROP TABLE IF EXISTS `wb4_cleanup_positions`;\nDROP TABLE IF EXISTS `wb4_cleanup_exempt_crews`;\n\n-- Table structure\n\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_cleanups` (\n  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` mediumint(5) unsigned NOT NULL,\n  `description` text,\n  `time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `cleanup_positions_upcoming` int(11) unsigned default 0,\n  `cleanup_positions_completed` int(11) unsigned default 0,\n  PRIMARY KEY (`id`),\n  KEY `event` (`event_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_cleanup_positions` (\n  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,\n  `cleanup_id` int(8) unsigned NOT NULL,\n  `user_id` int(11) unsigned NOT NULL,\n  `completed` tinyint(1) unsigned NOT NULL DEFAULT \'0\',\n  `comment` varchar(255) NOT NULL DEFAULT \'\',\n  PRIMARY KEY (`id`),\n  KEY (`cleanup_id`, `user_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n\nCREATE TABLE `wb4_cleanup_exempt_crews` (\n  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` mediumint(5) unsigned NOT NULL,\n  `crew_id` int(8) unsigned NOT NULL,\n  `exempted_by` int(11) unsigned NOT NULL,\n  PRIMARY KEY (`id`),\n  KEY (`crew_id`, `event_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1;\n\n-- Menu items\n-- Delete old\n\nDELETE FROM wb4_menuitems WHERE name = \'Cleanup\';\nDELETE FROM wb4_i18n WHERE content = \'Cleanup\';\nDELETE FROM wb4_i18n WHERE content = \'Rydding\';\n\n-- Create new\n\nINSERT INTO wb4_menuitems (parent_id, name, path, position) values (107, \'CleanupRegistration\', \'/Cleanup\', 10);\nset @last_id = LAST_INSERT_ID();\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'nob\', \'Menuitem\', @last_id, \'name\', \'Registrere rydding\');\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'eng\', \'Menuitem\', @last_id, \'name\', \'Cleanup registration\');\n\nINSERT INTO wb4_menuitems (parent_id, name, path, position) values (20, \'CleanupAdmin\', \'/Cleanup/Admin\', 17);\nset @last_id = LAST_INSERT_ID();\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'nob\', \'Menuitem\', @last_id, \'name\', \'Rydding\');\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'eng\', \'Menuitem\', @last_id, \'name\', \'Cleanup\');\n\nINSERT INTO wb4_menuitems (parent_id, name, path, position) values (106, \'CleanupTimes\', \'/Cleanup/Times\', 20);\nset @last_id = LAST_INSERT_ID();\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'nob\', \'Menuitem\', @last_id, \'name\', \'Ryddetider\');\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'eng\', \'Menuitem\', @last_id, \'name\', \'Cleanup times\');\n','\nDROP TABLE IF EXISTS `wb4_cleanups`;\nDROP TABLE IF EXISTS `wb4_cleanup_positions`;\nDROP TABLE IF EXISTS `wb4_cleanup_exempt_crews`;\n\n--\n-- Table structure for table `wb4_cleanup_dates`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_cleanup_dates` (\n  `cid` int(8) unsigned NOT NULL AUTO_INCREMENT,\n  `event` mediumint(5) unsigned NOT NULL,\n  `name` varchar(100) CHARACTER SET latin1 NOT NULL,\n  PRIMARY KEY (`cid`),\n  KEY `event` (`event`)\n) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n--\n-- Table structure for table `wb4_cleanup_positions`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_cleanup_positions` (\n  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,\n  `cid` mediumint(8) unsigned NOT NULL,\n  `user` int(11) unsigned NOT NULL,\n  `ok` tinyint(1) unsigned NOT NULL,\n  PRIMARY KEY (`pid`),\n  KEY `cid` (`cid`,`user`)\n) ENGINE=MyISAM AUTO_INCREMENT=1163 DEFAULT CHARSET=utf8;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\nDELETE FROM wb4_menuitems WHERE name = \'CleanupRegistration\';\nDELETE FROM wb4_menuitems WHERE name = \'CleanupAdmin\';\nDELETE FROM wb4_i18n WHERE content = \'Registrere rydding\';\nDELETE FROM wb4_i18n WHERE content = \'Cleanup registration\';\n\nINSERT INTO wb4_menuitems (parent_id, name, path, position) values (8, \'Cleanup\', \'/Crew/Cleanup\', 5);\nset @last_id = LAST_INSERT_ID();\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'nob\', \'Menuitem\', @last_id, \'name\', \'Rydding\');\nINSERT INTO wb4_i18n (locale, model, foreign_key, field, content) values (\'eng\', \'Menuitem\', @last_id, \'name\', \'Cleanup\');\n\n'),(16,'20140405183112',NULL,'20140405183112_added_maximum_field_to_cleanup.migration','\nalter table wb4_cleanups add maximum int(10) unsigned;\n','\nalter table wb4_cleanups drop column maximum;\n'),(17,'20140417154338',NULL,'20140417154338_changed_badge_id_to_varchar.migration','\nALTER TABLE wb4_accreditations MODIFY COLUMN badge_id varchar(128) DEFAULT NULL;\n','\nALTER TABLE wb4_accreditations MODIFY COLUMN badge_id int(11) DEFAULT NULL;\n'),(18,'20150127221839',NULL,'20150127221839_add_ordinary_show_time.migration','\nALTER TABLE wb4_events ADD show_time datetime;\n','\nALTER TABLE wb4_events DROP COLUMN show_time;\n'),(19,'20150301113928',NULL,'20150301113928_add_new_crew_list.migration','\n\nCREATE TABLE IF NOT EXISTS `wb4_mailinglistrule_crewnews` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `mailinglist_id` int(10) unsigned NOT NULL,\n  PRIMARY KEY (`id`),\n  KEY `mailinglist_id` (`mailinglist_id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n\nCREATE ALGORITHM=UNDEFINED DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER VIEW `wb4_mailinglistaddresses_crewnew` AS (\nSELECT DISTINCT u.realname, u.username, u.email, m.address, m.event_id\nFROM wb4_users AS u, wb4_mailinglists AS m \nLEFT JOIN wb4_mailinglistrule_crewnews AS mrcn \n    ON m.id = mrcn.mailinglist_id \nWHERE mrcn.mailinglist_id IS NOT NULL \nAND u.id IN \n    (SELECT cu.user_id \n    FROM wb4_crews_users as cu \n    LEFT JOIN wb4_userhistories AS uh \n        ON cu.user_id = uh.user_id \n    WHERE uh.user_id IS NULL) \nAND u.id IN \n    (SELECT cu.user_id \n    FROM wb4_events AS e\n    LEFT JOIN wb4_crews AS c \n        ON e.id = c.event_id\n    LEFT JOIN wb4_crews_users AS cu \n        ON c.id = cu.crew_id \n    WHERE cu.user_id IS NOT NULL\n    )\n)\n\n','\n\nDROP TABLE IF EXISTS `wb4_mailinglistrule_crewnews`;\n\nDROP VIEW IF EXISTS `wb4_mailinglistaddresses_crewnew`;\n\n'),(20,'20150305183426',NULL,'20150305183426_rename_order_change_allow.migration','\nALTER TABLE wb4_crew_effects_items CHANGE allow_change allow_order tinyint(1);\n','\nALTER TABLE wb4_crew_effects_items CHANGE allow_order allow_change tinyint(1);\n'),(21,'20150306135449',NULL,'20150306135449_change_crewnew_view.migration','\n\nDROP VIEW IF EXISTS `wb4_mailinglistaddresses_crewnew`;\n\nCREATE ALGORITHM=UNDEFINED DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER VIEW `wb4_mailinglistaddress_crewnews` AS (\nSELECT DISTINCT u.realname, u.username, u.email AS address, m.address AS mailinglist, m.event_id, e.reference AS event_reference\nFROM wb4_users AS u, wb4_mailinglists AS m\nLEFT JOIN wb4_mailinglistrule_crewnews AS mrcn\n    ON m.id = mrcn.mailinglist_id\nLEFT JOIN wb4_events AS e\n    ON e.id = m.event_id\nWHERE mrcn.mailinglist_id IS NOT NULL\nAND u.id IN\n    (SELECT cu.user_id\n    FROM wb4_crews_users as cu\n    LEFT JOIN wb4_userhistories AS uh\n        ON cu.user_id = uh.user_id\n    WHERE uh.user_id IS NULL)\nAND u.id IN\n    (SELECT cu.user_id\n    FROM wb4_events AS ev\n    LEFT JOIN wb4_crews AS c\n        ON ev.id = c.event_id\n    LEFT JOIN wb4_crews_users AS cu\n        ON c.id = cu.crew_id\n    WHERE cu.user_id IS NOT NULL AND ev.id = m.event_id)\n);\n\n','\n\nDROP VIEW IF EXISTS `wb4_mailinglistaddress_crewnews`;\n\n'),(22,'20150317214500',NULL,'20150317214500_add_type_to_logistic_storage.migration','\n\nALTER TABLE wb4_logistic_storages ADD COLUMN type ENUM (\'default\', \'unrig\') NOT NULL DEFAULT \'default\';\n\n','\n\nALTER TABLE wb4_logistic_storages DROP COLUMN type;\n\n'),(23,'20150317224500',NULL,'20150317224500_add_unrig_destination_to_logistic_items.migration','\n\nALTER TABLE wb4_logistic_items ADD COLUMN unrig_storage_id INTEGER(10) UNSIGNED NULL;\n\n','\n\nALTER TABLE wb4_logistic_items DROP COLUMN unrig_storage_id;\n\n'),(24,'20150319215020',NULL,'20150319215020_enroll_disable.migration','\nALTER TABLE wb4_application_choices ADD disabled tinyint(4);\nUPDATE wb4_application_choices SET disabled = 0;\n','\nALTER TABLE wb4_application_choices DROP disabled;\n'),(25,'20150324193000',NULL,'20150324193000_add_condition_to_logistic_items.migration','\n\nALTER TABLE wb4_logistic_items ADD COLUMN `condition` ENUM(\'ok\',\'damaged\',\'destroyed\',\'lost\') NOT NULL DEFAULT \'ok\';\n\n','\n\nALTER TABLE wb4_logistic_items DROP COLUMN `condition`;\n\n'),(26,'20150324230000',NULL,'20150324230000_add_barcode_to_logistic_item.migration','\n\nALTER TABLE wb4_logistic_items ADD COLUMN barcode VARCHAR(255) NULL AFTER logistic_supplier_id;\n\n','\n\nALTER TABLE wb4_logistic_items DROP COLUMN barcode;\n\n'),(27,'20150330190833',NULL,'20150330190833_add_badge_table.migration','\n	CREATE TABLE `wb4_badges` (\n	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n	  `user_id` int(10) unsigned DEFAULT NULL,\n	  `nfc_id` varchar(255) DEFAULT NULL,\n	  `event_id` int(10) unsigned NOT NULL,\n	  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n	  `type` enum(\'crew\',\'press\',\'invited\',\'hoa\',\'iss\') NOT NULL DEFAULT \'crew\',\n	  `active` tinyint(1) DEFAULT \'1\',\n	  PRIMARY KEY (`id`)\n	) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;\n','\n	DROP TABLE wb4_badges;\n'),(28,'20150331210812',NULL,'20150331210812_add_lost_and_found_storage_places.migration','\n\nCREATE TABLE IF NOT EXISTS `wb4_lost_and_found_storage_places` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `name` varchar(50) NOT NULL,\n  `active` tinyint(1) DEFAULT \'1\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n\n','\n\n'),(29,'20150331211004',NULL,'20150331211004_add_lost_and_found_categories.migration','\nCREATE TABLE IF NOT EXISTS `wb4_lost_and_found_categories` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `name` varchar(50) NOT NULL,\n  `active` tinyint(1) DEFAULT \'1\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n\n','\n\n'),(30,'20150331211325',NULL,'20150331211325_add_lost_items.migration','\nCREATE TABLE IF NOT EXISTS `wb4_lost_items` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `category_id` int(10) unsigned NOT NULL,\n  `storage_place_id` int(10) unsigned DEFAULT NULL,\n  `description` text NOT NULL,\n  `last_seen_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `last_seen_where` text,\n  `lost_by` text,\n  `lost_registered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `lost_registered_logged_in_user` int(10) unsigned NOT NULL,\n  `lost_registered_by` int(10) unsigned NOT NULL,\n  `found_by` text,\n  `found_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `found_logged_in_user` int(10) unsigned DEFAULT NULL,\n  `found_registered_by` int(10) unsigned DEFAULT NULL,\n  `resolved` tinyint(1) NOT NULL,\n  `resolved_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `resolved_logged_in_user` int(10) unsigned DEFAULT NULL,\n  `resolved_registered_by` int(10) unsigned DEFAULT NULL,\n  `resolved_delivered_by` int(10) unsigned DEFAULT NULL,\n  `resolved_description` text,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n','\n'),(31,'20150331211423',NULL,'20150331211423_add_found_items.migration','\n\nUPDATE `wb4_menuitems` SET path = \"/LostAndFoundV2\" WHERE id = 130;\n\nCREATE TABLE IF NOT EXISTS `wb4_found_items` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) unsigned NOT NULL,\n  `category_id` int(10) unsigned NOT NULL,\n  `description` text NOT NULL,\n  `storage_place_id` int(10) unsigned NOT NULL,\n  `found_by` text,\n  `found_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `found_logged_in_user` int(10) unsigned NOT NULL,\n  `found_registered_by` int(10) unsigned NOT NULL,\n  `resolved` tinyint(1) NOT NULL,\n  `resolved_description` text,\n  `resolved_date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\',\n  `resolved_delivered_by` int(10) unsigned DEFAULT NULL,\n  `resolved_delivered_to` text NOT NULL,\n  `resolved_logged_in_user` int(10) unsigned DEFAULT NULL,\n  `resolved_registered_by` int(10) unsigned DEFAULT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n\n','\n\n'),(32,'20150402161257',NULL,'20150402161257_sms_message_sent_by_and_event_id.migration','\n\nALTER TABLE wb4_sms_messages \nADD sent_by_id int(10) NOT NULL\nDEFAULT -1;\n\n\nALTER TABLE wb4_sms_messages \nADD event_id int(10) NOT NULL\nDEFAULT -1;\n\n','\n\n'),(33,'20160209222940',NULL,'20160209222940_privacy_hidden_defaults.migration','\nUPDATE wb4_user_privacies SET phone = 1;\nUPDATE wb4_user_privacies SET address = 1;\nALTER TABLE wb4_user_privacies ADD COLUMN allow_crew TINYINT(1) DEFAULT 0 NOT NULL;\n','\nALTER TABLE wb4_user_privacies DROP COLUMN allow_crew;\n'),(34,'20160322005145',NULL,'20160322005145_other_type_badge.migration','\nALTER TABLE wb4_badges MODIFY COLUMN type enum(\'crew\',\'press\',\'invited\',\'hoa\',\'iss\', \'other\') DEFAULT \'crew\' NOT NULL;\nALTER TABLE wb4_badges ADD COLUMN specification VARCHAR(255) NULL AFTER type;\n','\nALTER TABLE wb4_badges MODIFY COLUMN type enum(\'crew\',\'press\',\'invited\',\'hoa\',\'iss\') DEFAULT \'crew\' NOT NULL;\nALTER TABLE wb4_badges DROP COLUMN specification;\n'),(35,'20160323023621',NULL,'20160323023621_slideshow_types.migration','\nALTER TABLE wb4_slideshows_slides ADD COLUMN type varchar(255) NULL;\n','\nALTER TABLE wb4_slideshows_slides DROP COLUMN type;\n'),(36,'20170301201015',NULL,'20170301201015_kandumembershipsettings.migration','\nCREATE TABLE IF NOT EXISTS `wb4_kandu_membership_settings` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `event_id` int(10) NOT NULL,\n  `enabled` tinyint(1) NOT NULL DEFAULT \'0\',\n  `year` int(4) NOT NULL,\n  `expires` datetime NOT NULL,\n  PRIMARY KEY (`id`)\n) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;\n','\nDROP TABLE IF EXISTS `wb4_kandu_membership_settings`;\n'),(37,'20170325214015',NULL,'20170325214015_add_updated_on_to_needs.migration','\nALTER TABLE wb4_needs ADD COLUMN updated_on DATETIME NULL DEFAULT NULL;\n','\nALTER TABLE wb4_needs DROP COLUMN updated_on;\n'),(38,'20170925194923',NULL,'20170925194923_added_deactivated_flag_crew_effects.migration','\nALTER TABLE wb4_crew_effects_orders ADD order_deactivated TINYINT( 1 ) NOT NULL DEFAULT \'0\';\n','\nALTER TABLE wb4_crew_effects_orders DROP order_deactivated;\n'),(39,'20170927184711',NULL,'20170927184711_added_mailinglist_procedure.migration','\n\nCREATE DEFINER=`wannabe`@`localhost` PROCEDURE mailinglistaddresses(IN mailinglist_id INT)\nBEGIN\nSELECT\n	u.email as address,\n    u.username,\n    u.realname\nFROM (\n	SELECT DISTINCT sub.user_id, sub.id, sub.optional\n	FROM (\n		SELECT cu.user_id, ml.id, ml.optional\n		FROM wb4_mailinglistrules mlr\n		LEFT JOIN wb4_crews_users cu\n		ON mlr.crew_id = cu.crew_id\n		LEFT JOIN wb4_mailinglists ml\n		ON mlr.mailinglist_id = ml.id\n		WHERE ml.id = mailinglist_id\n		AND cu.leader >= mlr.leader\n		UNION\n		SELECT cu.user_id, ml.id, ml.optional\n		FROM wb4_mailinglistrule_teams mlrt\n		LEFT JOIN wb4_teams t\n		ON mlrt.team_id = t.id\n		LEFT JOIN wb4_crews_users cu\n		ON t.id = cu.team_id\n		LEFT JOIN wb4_mailinglists ml\n		ON mlrt.mailinglist_id = ml.id\n		WHERE ml.id = mailinglist_id\n		UNION\n		SELECT mlru.user_id, ml.id, ml.optional\n		FROM wb4_mailinglistrule_users mlru\n		LEFT JOIN wb4_mailinglists ml\n		ON mlru.mailinglist_id = ml.id\n		WHERE ml.id = mailinglist_id\n	) sub\n) ml\nINNER JOIN wb4_users u\nON u.id = ml.user_id\nLEFT JOIN wb4_user_mailprefs ump\nON ump.user_id = ml.user_id\nAND ump.mailinglist_id = ml.id\nWHERE ump.subscribe IS NULL\nOR ump.subscribe <> 0\nORDER BY u.realname ASC;\nEND;\n/\n\nCREATE INDEX USER_LIST\nON wb4_user_mailprefs (mailinglist_id, user_id);\n\n','\n\nALTER TABLE wb4_user_mailprefs DROP INDEX USER_LIST;\n\nDROP PROCEDURE IF EXISTS mailinglistaddresses;\n\n'),(40,'20171010210411',NULL,'20171010210411_sorted_crew.migration','\nALTER TABLE  `wb4_crews` ADD  `sorted_weight` INT( 6 ) NOT NULL DEFAULT  \'0\';\nALTER TABLE  `wb4_application_available_fields` CHANGE  `name`  `name` VARCHAR( 128 ) NULL DEFAULT NULL;\n','\nALTER TABLE wb4_crews DROP sorted_weight;\nALTER TABLE  `wb4_application_available_fields` CHANGE  `name`  `name` VARCHAR( 50 ) NULL DEFAULT NULL;\n'),(41,'20171019224653',NULL,'20171019224653_allergifix.migration','\nALTER TABLE `wb4_needs` ADD `allergies` VARCHAR( 254 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL AFTER `nutritionalneeds`;\n','\nALTER TABLE `wb4_needs` DROP `allergies`;\n'),(42,'20171205091615',NULL,'20171205091615_added_mailinglist_membership_procedure.migration','\n\nCREATE DEFINER=`wannabe`@`localhost` PROCEDURE `mailinglistmemberships`(IN user_id INT, IN event_id INT)\nBEGIN\nSELECT\n	ml.id as mailinglist_id,\n	ml.address as mailinglist,\n    ml.optional\nFROM (\n	SELECT DISTINCT sub.user_id, sub.id, sub.optional, sub.address\n	FROM (\n		SELECT cu.user_id, ml.id, ml.optional, ml.address\n		FROM wb4_mailinglistrules mlr\n		LEFT JOIN wb4_crews_users cu\n		ON mlr.crew_id = cu.crew_id\n		LEFT JOIN wb4_mailinglists ml\n		ON mlr.mailinglist_id = ml.id\n		WHERE cu.user_id = user_id\n		AND cu.leader >= mlr.leader\n        AND ml.event_id = event_id\n		UNION\n		SELECT cu.user_id, ml.id, ml.optional, ml.address\n		FROM wb4_mailinglistrule_teams mlrt\n		LEFT JOIN wb4_teams t\n		ON mlrt.team_id = t.id\n		LEFT JOIN wb4_crews_users cu\n		ON t.id = cu.team_id\n		LEFT JOIN wb4_mailinglists ml\n		ON mlrt.mailinglist_id = ml.id\n		WHERE cu.user_id = user_id\n        AND ml.event_id = event_id\n		UNION\n		SELECT mlru.user_id, ml.id, ml.optional, ml.address\n		FROM wb4_mailinglistrule_users mlru\n		LEFT JOIN wb4_mailinglists ml\n		ON mlru.mailinglist_id = ml.id\n		WHERE mlru.user_id = user_id\n        AND ml.event_id = event_id\n	) sub\n) ml\nLEFT JOIN wb4_user_mailprefs ump\nON ump.user_id = ml.user_id\nAND ump.mailinglist_id = ml.id\nWHERE ump.subscribe IS NULL\nOR ump.subscribe <> 0\nORDER BY ml.address ASC;\nEND;\n/\n\n','\n\nDROP PROCEDURE IF EXISTS mailinglistmemberships;\n\n'),(43,'20180215001615',NULL,'20180215001615_changes_to_mailinglist_membership_procedure.migration','\n\nDROP PROCEDURE IF EXISTS mailinglistmemberships;\n\nCREATE DEFINER=`wannabe`@`localhost` PROCEDURE `mailinglistmemberships`(IN user_id INT, IN event_id INT)\nBEGIN\nSELECT\n	ml.id as mailinglist_id,\n	ml.address as mailinglist,\n    ml.optional,\n    ml.crew_id as manage_crew\nFROM (\n	SELECT DISTINCT sub.user_id, sub.id, sub.optional, sub.address, sub.crew_id\n	FROM (\n		SELECT cu.user_id, ml.id, ml.optional, ml.address, ml.crew_id\n		FROM wb4_mailinglistrules mlr\n		LEFT JOIN wb4_crews_users cu\n		ON mlr.crew_id = cu.crew_id\n		LEFT JOIN wb4_mailinglists ml\n		ON mlr.mailinglist_id = ml.id\n		WHERE cu.user_id = user_id\n		AND cu.leader >= mlr.leader\n        AND ml.event_id = event_id\n		UNION\n		SELECT cu.user_id, ml.id, ml.optional, ml.address, ml.crew_id\n		FROM wb4_mailinglistrule_teams mlrt\n		LEFT JOIN wb4_teams t\n		ON mlrt.team_id = t.id\n		LEFT JOIN wb4_crews_users cu\n		ON t.id = cu.team_id\n		LEFT JOIN wb4_mailinglists ml\n		ON mlrt.mailinglist_id = ml.id\n		WHERE cu.user_id = user_id\n        AND ml.event_id = event_id\n		UNION\n		SELECT mlru.user_id, ml.id, ml.optional, ml.address, ml.crew_id\n		FROM wb4_mailinglistrule_users mlru\n		LEFT JOIN wb4_mailinglists ml\n		ON mlru.mailinglist_id = ml.id\n		WHERE mlru.user_id = user_id\n        AND ml.event_id = event_id\n	) sub\n) ml\nLEFT JOIN wb4_user_mailprefs ump\nON ump.user_id = ml.user_id\nAND ump.mailinglist_id = ml.id\nWHERE ump.subscribe IS NULL\nOR ump.subscribe <> 0\nORDER BY ml.address ASC;\nEND;\n/\n\n','\n\nDROP PROCEDURE IF EXISTS mailinglistmemberships;\n\n'),(44,'20180217140210',NULL,'20180217140210_add_master_to_slideshows.migration','\nALTER TABLE `wb4_slideshows` ADD COLUMN `master` INT(10) NULL DEFAULT 0 AFTER `event_id`;\n','\nALTER TABLE `wb4_slideshows` DROP `master`;\n'),(45,'20180309001615',NULL,'20180309001615_changes_to_logistic_tables_procedure.migration','\nALTER TABLE `wb4_logistic_items` CHANGE `barcode` `AssetTag` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL ;\nALTER TABLE `wb4_logistic_items` ADD `parent` INT( 10 ) UNSIGNED NULL DEFAULT NULL AFTER `condition` ;\nALTER TABLE `wb4_logistic_transactions` CHANGE `user_id` `user_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL ;\nALTER TABLE `wb4_logistic_transactions` ADD `crew_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL AFTER `user_id` ;\n','\n\n\n\n'),(46,'20181007150955',NULL,'20181007150955_fixed_terms.migration','\nALTER TABLE `wb4_user_terms` DROP INDEX `user_id`;\nALTER TABLE `wb4_user_terms` ADD COLUMN `terms_id` INT(10) NULL AFTER `event_id`;\nALTER TABLE `wb4_user_terms` MODIFY COLUMN `accepted` timestamp DEFAULT CURRENT_TIMESTAMP;\nALTER TABLE `wb4_user_terms` ADD CONSTRAINT `wb4_user_terms_user_id_terms_id_pk` UNIQUE (`user_id`, `terms_id`);\n','\nALTER TABLE `wb4_user_terms` DROP INDEX `wb4_user_terms_user_id_terms_id_pk`;\nALTER TABLE `wb4_user_terms` MODIFY COLUMN `accepted` datetime NULL DEFAULT \'0000-00-00 00:00:00\';\nALTER TABLE `wb4_user_terms` DROP `terms_id`;\n'),(47,'20181014093734',NULL,'20181014093734_added_application_comments_and_priority.migration','\nALTER TABLE `wb4_application_documents` ADD COLUMN `priority` TINYINT NOT NULL DEFAULT \'6\';\nCREATE TABLE `wb4_application_comments` (\n	`id` INT(10) NOT NULL AUTO_INCREMENT,\n	`application_document_id` INT(10) NOT NULL,\n	`user_id` INT(10) UNSIGNED NOT NULL DEFAULT \'0\',\n	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,\n	`content` TEXT NOT NULL,\n	PRIMARY KEY (`id`)\n)\n','\nALTER TABLE `wb4_application_documents` DROP `priority`;\nDROP TABLE IF EXISTS `wb4_application_comments`;\n'),(48,'20181201014634',NULL,'20181201014634_update_wb4_mailinglistmoderators_view.migration','\nALTER ALGORITHM = UNDEFINED DEFINER = `wannabe`@`localhost` SQL SECURITY DEFINER VIEW `wb4_mailinglistmoderators` AS (\nSELECT DISTINCT u.email AS email, m.address AS mailinglist, m.moderatorpassword AS moderatorpassword\nFROM wb4_mailinglists m\nJOIN wb4_users u\nJOIN wb4_crews_users uc\nJOIN wb4_mailinglistrules mrule\nWHERE uc.user_id = u.id\nAND m.id = mrule.mailinglist_id\nAND uc.crew_id = mrule.crew_id\nAND uc.leader >= mrule.leader\nAND mrule.enable_moderator =1\n)\n','\nDROP VIEW wb4_mailinglistmoderators\nCREATE ALGORITHM=UNDEFINED DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER VIEW `wb4_mailinglistmoderators` AS (select distinct `u`.`email` AS `email`,`m`.`address` AS `mailinglist`,`m`.`moderatorpassword` AS `moderatorpassword` from ((((`wb4_mailinglists` `m` join `wb4_users` `u`) join `wb4_crews_users` `uc`) join `wb4_crews` `c`) join `wb4_mailinglistrules` `mrule`) where ((`uc`.`user_id` = `u`.`id`) and (`m`.`id` = `mrule`.`mailinglist_id`) and (`uc`.`crew_id` = `mrule`.`crew_id`) and (((`c`.`id` = `uc`.`crew_id`) and ((`c`.`id` = `m`.`crew_id`) or (`mrule`.`enable_moderator` = 1))) or (`uc`.`crew_id` = (select `c2`.`id` from `wb4_crews` `c2` where (`c2`.`id` = `c`.`crew_id`)))) and (`uc`.`leader` > 2) and ((`m`.`crew_id` > 0) or (`mrule`.`enable_moderator` = 1))))\n'),(49,'20190821183041',NULL,'20190821183041_remove_user_geolocation_data.migration','\n\n-- Remove location columns from user table\nalter table wb4_users drop column longitude;\nalter table wb4_users drop column latitude;\n\n-- Drop geocodes table\nDROP TABLE IF EXISTS `wb4_geocodes`;\n\n','\n\n-- Add location columns to user table\nalter table wb4_users add column longitude varchar(16) DEFAULT \'0\';\nalter table wb4_users add column latitude varchar(16) DEFAULT \'0\';\n\n-- Recreate geocodes table\n--\n-- Table structure for table `wb4_geocodes`\n--\n\n/*!40101 SET @saved_cs_client     = @@character_set_client */;\n/*!40101 SET character_set_client = utf8 */;\nCREATE TABLE `wb4_geocodes` (\n  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n  `address` varchar(128) DEFAULT \'\',\n  `longitude` varchar(128) DEFAULT \'0\',\n  `latitude` varchar(128) DEFAULT \'0\',\n  `cached` datetime DEFAULT \'0000-00-00 00:00:00\',\n  `invalid` tinyint(1) DEFAULT \'0\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=400 DEFAULT CHARSET=latin1;\n/*!40101 SET character_set_client = @saved_cs_client */;\n\n-- Data for geocodes\n\nINSERT INTO `wb4_geocodes` (`id`, `address`, `longitude`, `latitude`, `cached`, `invalid`) VALUES\n(320, \'Bedringens vei 1 1920 SØRUMSAND\', \'11.239805899999965\', \'59.9850923\', \'2013-02-22 10:34:18\', 0);\n\n');
/*!40000 ALTER TABLE `__db_version__` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_accreditation_accesses`
--

DROP TABLE IF EXISTS `wb4_accreditation_accesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_accreditation_accesses` (
  `accreditation_id` int(10) NOT NULL,
  `accreditation_group_id` int(10) NOT NULL,
  PRIMARY KEY (`accreditation_id`,`accreditation_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_accreditation_accesses`
--

LOCK TABLES `wb4_accreditation_accesses` WRITE;
/*!40000 ALTER TABLE `wb4_accreditation_accesses` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_accreditation_accesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_accreditation_group_members`
--

DROP TABLE IF EXISTS `wb4_accreditation_group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_accreditation_group_members` (
  `accreditation_group_id` int(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`accreditation_group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_accreditation_group_members`
--

LOCK TABLES `wb4_accreditation_group_members` WRITE;
/*!40000 ALTER TABLE `wb4_accreditation_group_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_accreditation_group_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_accreditation_groups`
--

DROP TABLE IF EXISTS `wb4_accreditation_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_accreditation_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`,`event_id`),
  UNIQUE KEY `event_id` (`event_id`,`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_accreditation_groups`
--

LOCK TABLES `wb4_accreditation_groups` WRITE;
/*!40000 ALTER TABLE `wb4_accreditation_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_accreditation_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_accreditations`
--

DROP TABLE IF EXISTS `wb4_accreditations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_accreditations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `company_name` varchar(128) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `phonenumber` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  `numpersons` tinyint(4) NOT NULL,
  `arrivaldate` date NOT NULL DEFAULT '0000-00-00',
  `departuredate` date NOT NULL DEFAULT '0000-00-00',
  `actual_arrival` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actual_departure` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pictures` tinyint(1) DEFAULT NULL,
  `film` tinyint(1) DEFAULT NULL,
  `tour` tinyint(1) DEFAULT NULL,
  `smsalert` tinyint(1) DEFAULT NULL,
  `extended_info` text,
  `internal_comment` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `badge_id` varchar(128) DEFAULT NULL,
  `accepted` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_accreditations`
--

LOCK TABLES `wb4_accreditations` WRITE;
/*!40000 ALTER TABLE `wb4_accreditations` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_accreditations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_aclobjects`
--

DROP TABLE IF EXISTS `wb4_aclobjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_aclobjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_aclobjects`
--

LOCK TABLES `wb4_aclobjects` WRITE;
/*!40000 ALTER TABLE `wb4_aclobjects` DISABLE KEYS */;
INSERT INTO `wb4_aclobjects` VALUES (340,'/dev/*');
/*!40000 ALTER TABLE `wb4_aclobjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_aclobjects_crews`
--

DROP TABLE IF EXISTS `wb4_aclobjects_crews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_aclobjects_crews` (
  `crew_id` int(10) unsigned NOT NULL,
  `aclobject_id` int(10) unsigned NOT NULL,
  `read` tinyint(1) DEFAULT '0',
  `write` tinyint(1) DEFAULT '0',
  `manage` tinyint(1) DEFAULT '0',
  `superuser` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_aclobjects_crews`
--

LOCK TABLES `wb4_aclobjects_crews` WRITE;
/*!40000 ALTER TABLE `wb4_aclobjects_crews` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_aclobjects_crews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_aclobjects_roles`
--

DROP TABLE IF EXISTS `wb4_aclobjects_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_aclobjects_roles` (
  `role` int(10) NOT NULL,
  `aclobject_id` int(10) unsigned NOT NULL,
  `read` tinyint(1) DEFAULT '0',
  `write` tinyint(1) DEFAULT '0',
  `manage` tinyint(1) DEFAULT '0',
  `superuser` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_aclobjects_roles`
--

LOCK TABLES `wb4_aclobjects_roles` WRITE;
/*!40000 ALTER TABLE `wb4_aclobjects_roles` DISABLE KEYS */;
INSERT INTO `wb4_aclobjects_roles` VALUES (-1,340,1,1,0,0);
/*!40000 ALTER TABLE `wb4_aclobjects_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_aclobjects_users`
--

DROP TABLE IF EXISTS `wb4_aclobjects_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_aclobjects_users` (
  `user_id` int(10) unsigned NOT NULL,
  `aclobject_id` int(10) unsigned NOT NULL,
  `read` tinyint(1) DEFAULT '0',
  `write` tinyint(1) DEFAULT '0',
  `manage` tinyint(1) DEFAULT '0',
  `superuser` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_aclobjects_users`
--

LOCK TABLES `wb4_aclobjects_users` WRITE;
/*!40000 ALTER TABLE `wb4_aclobjects_users` DISABLE KEYS */;
INSERT INTO `wb4_aclobjects_users` VALUES (1,340,1,1,1,1),(1918,340,1,1,1,1),(2193,340,1,1,1,1),(3073,340,1,1,1,1),(4304,340,1,1,1,1),(4607,340,1,1,1,1),(4918,340,1,1,1,1),(6195,340,1,1,1,1);
/*!40000 ALTER TABLE `wb4_aclobjects_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_api_applications`
--

DROP TABLE IF EXISTS `wb4_api_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_api_applications` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `creator_id` int(11) unsigned NOT NULL,
  `enabled` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `updated` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_api_applications`
--

LOCK TABLES `wb4_api_applications` WRITE;
/*!40000 ALTER TABLE `wb4_api_applications` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_api_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_api_keys`
--

DROP TABLE IF EXISTS `wb4_api_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_api_keys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `apikey` varchar(32) DEFAULT NULL,
  `revoked` tinyint(1) DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `api_application_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_api_keys`
--

LOCK TABLES `wb4_api_keys` WRITE;
/*!40000 ALTER TABLE `wb4_api_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_api_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_api_sessions`
--

DROP TABLE IF EXISTS `wb4_api_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_api_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sessionkey` varchar(32) NOT NULL,
  `infinite` tinyint(1) DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_api_sessions`
--

LOCK TABLES `wb4_api_sessions` WRITE;
/*!40000 ALTER TABLE `wb4_api_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_api_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_available_fields`
--

DROP TABLE IF EXISTS `wb4_application_available_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_available_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `application_fieldtype_id` int(11) DEFAULT NULL,
  `application_page_id` int(11) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crewapplication_fieldtype_id` (`application_fieldtype_id`),
  KEY `crewapplication_page_id` (`application_page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=310 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_available_fields`
--

LOCK TABLES `wb4_application_available_fields` WRITE;
/*!40000 ALTER TABLE `wb4_application_available_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_available_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_choices`
--

DROP TABLE IF EXISTS `wb4_application_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_choices` (
  `application_document_id` int(11) DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `revision` int(11) DEFAULT '0',
  `draft` tinyint(4) DEFAULT '1',
  `handled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `accepted` tinyint(4) DEFAULT '0' COMMENT 'Contains 1 if the choice is accepted',
  `denied` tinyint(4) DEFAULT '0' COMMENT 'Contains 1 if the choice is denied.',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `waiting` tinyint(4) DEFAULT '0',
  `disabled` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crewapplication_document_id` (`application_document_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11003 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_choices`
--

LOCK TABLES `wb4_application_choices` WRITE;
/*!40000 ALTER TABLE `wb4_application_choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_comments`
--

DROP TABLE IF EXISTS `wb4_application_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `application_document_id` int(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_comments`
--

LOCK TABLES `wb4_application_comments` WRITE;
/*!40000 ALTER TABLE `wb4_application_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_documents`
--

DROP TABLE IF EXISTS `wb4_application_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `orderedchoices` tinyint(4) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `draft` tinyint(4) DEFAULT '1',
  `handled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enableprivacy` tinyint(4) DEFAULT '0',
  `priority` tinyint(4) NOT NULL DEFAULT '6',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4696 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_documents`
--

LOCK TABLES `wb4_application_documents` WRITE;
/*!40000 ALTER TABLE `wb4_application_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_field_types`
--

DROP TABLE IF EXISTS `wb4_application_field_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_field_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_field_types`
--

LOCK TABLES `wb4_application_field_types` WRITE;
/*!40000 ALTER TABLE `wb4_application_field_types` DISABLE KEYS */;
INSERT INTO `wb4_application_field_types` VALUES (6,'textarea'),(7,'text'),(8,'crewchoice'),(9,'checkbox'),(10,'crewwhy');
/*!40000 ALTER TABLE `wb4_application_field_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_fields`
--

DROP TABLE IF EXISTS `wb4_application_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_document_id` int(11) DEFAULT NULL,
  `application_availablefield_id` int(11) DEFAULT NULL,
  `value` blob,
  `revision` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `draft` tinyint(4) DEFAULT '1',
  `crew_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `crewapplication_availablefield_id` (`application_availablefield_id`),
  KEY `crewapplication_document_id` (`application_document_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21507 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_fields`
--

LOCK TABLES `wb4_application_fields` WRITE;
/*!40000 ALTER TABLE `wb4_application_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_pages`
--

DROP TABLE IF EXISTS `wb4_application_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` text,
  `position` int(11) DEFAULT '0',
  `type` enum('custom','crewchoice','crewwhy','crewfield','crewquestion') DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_pages`
--

LOCK TABLES `wb4_application_pages` WRITE;
/*!40000 ALTER TABLE `wb4_application_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_settings`
--

DROP TABLE IF EXISTS `wb4_application_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `choices` int(11) unsigned DEFAULT '3',
  `privacy` int(11) unsigned DEFAULT '0',
  `priority` int(11) unsigned DEFAULT '0',
  `crewquestion` int(11) unsigned DEFAULT '0',
  `event_id` int(10) unsigned NOT NULL,
  `deniedtext` text,
  `donestring` text,
  `mailsubject` text,
  `mailstring` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_settings`
--

LOCK TABLES `wb4_application_settings` WRITE;
/*!40000 ALTER TABLE `wb4_application_settings` DISABLE KEYS */;
INSERT INTO `wb4_application_settings` VALUES (1,3,0,0,0,18,'Vi beklager å måtte meddele at du ikke har blitt tatt opp som crewmedlem. Vi takker for søknaden og ønsker deg velkommen tilbake som crewsøker til neste arrangement! Om du har spørsmål til prosessen rundt behandlingen av din søknad kan du ta kontakt med co [at] gathering.org.','Din søknad er registrert og vil bli behandlet så fort som mulig. Hvis du har noen spørsmål, ikke nøl med å kontakte vår crewombudsman på co [at] gathering.org. Husk at du kan endre din søknad på hvilket som helst tidspunkt, hvis du ønsker det. Når din søknad har blitt behandlet vil du motta en epost som inneholder resultatet. Du vil også motta denne siden på epost øyeblikkelig.','Din søknad er mottatt.','Din søknad er registrert og vil bli behandlet så fort som mulig.\r\n\r\nHvis du har noen spørsmål, ikke nøl med å kontakte vårt crewombud på co@gathering.org\r\n\r\nHusk at du kan endre din søknad på hvilket som helst tidspunkt, hvis du ønsker det.\r\n\r\nNår din søknad har blitt behandlet vil du motta en epost som inneholder resultatet.\r\n\r\nSlik ser din søknad ut:');
/*!40000 ALTER TABLE `wb4_application_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_application_tags`
--

DROP TABLE IF EXISTS `wb4_application_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_application_tags` (
  `application_document_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `tag` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`application_document_id`,`user_id`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_application_tags`
--

LOCK TABLES `wb4_application_tags` WRITE;
/*!40000 ALTER TABLE `wb4_application_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_application_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_badges`
--

DROP TABLE IF EXISTS `wb4_badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_badges` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `nfc_id` varchar(255) DEFAULT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` enum('crew','press','invited','hoa','iss','other') NOT NULL DEFAULT 'crew',
  `specification` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_badges`
--

LOCK TABLES `wb4_badges` WRITE;
/*!40000 ALTER TABLE `wb4_badges` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_carplates`
--

DROP TABLE IF EXISTS `wb4_carplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_carplates` (
  `user_id` int(10) NOT NULL DEFAULT '0',
  `carplate` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_carplates`
--

LOCK TABLES `wb4_carplates` WRITE;
/*!40000 ALTER TABLE `wb4_carplates` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_carplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_application_available_fields`
--

DROP TABLE IF EXISTS `wb4_cfad_application_available_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_application_available_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `application_fieldtype_id` int(11) DEFAULT NULL,
  `application_page_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crewapplication_fieldtype_id` (`application_fieldtype_id`),
  KEY `crewapplication_page_id` (`application_page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_application_available_fields`
--

LOCK TABLES `wb4_cfad_application_available_fields` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_application_available_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_application_available_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_application_choices`
--

DROP TABLE IF EXISTS `wb4_cfad_application_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_application_choices` (
  `application_document_id` int(11) DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `priority` int(11) NOT NULL,
  `revision` int(11) DEFAULT '0',
  `draft` tinyint(4) DEFAULT '1',
  `handled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `accepted` tinyint(4) DEFAULT '0' COMMENT 'Contains 1 if the choice is accepted',
  `denied` tinyint(4) DEFAULT '0' COMMENT 'Contains 1 if the choice is denied.',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `crewapplication_document_id` (`application_document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_application_choices`
--

LOCK TABLES `wb4_cfad_application_choices` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_application_choices` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_application_choices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_application_documents`
--

DROP TABLE IF EXISTS `wb4_cfad_application_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_application_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `draft` tinyint(4) DEFAULT '1',
  `handled` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_application_documents`
--

LOCK TABLES `wb4_cfad_application_documents` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_application_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_application_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_application_fields`
--

DROP TABLE IF EXISTS `wb4_cfad_application_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_application_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_document_id` int(11) DEFAULT NULL,
  `application_availablefield_id` int(11) DEFAULT NULL,
  `value` blob,
  `revision` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `draft` tinyint(4) DEFAULT '1',
  `crew_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `crewapplication_availablefield_id` (`application_availablefield_id`),
  KEY `crewapplication_document_id` (`application_document_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_application_fields`
--

LOCK TABLES `wb4_cfad_application_fields` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_application_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_application_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_application_pages`
--

DROP TABLE IF EXISTS `wb4_cfad_application_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_application_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `description` text,
  `position` int(11) DEFAULT '0',
  `type` enum('custom','crewchoice','crewwhy','crewfield') DEFAULT NULL,
  `crew_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_application_pages`
--

LOCK TABLES `wb4_cfad_application_pages` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_application_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_application_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_application_settings`
--

DROP TABLE IF EXISTS `wb4_cfad_application_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_application_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `choices` int(11) unsigned DEFAULT '3',
  `can_apply` int(11) unsigned DEFAULT '0',
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_application_settings`
--

LOCK TABLES `wb4_cfad_application_settings` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_application_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_application_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_crews`
--

DROP TABLE IF EXISTS `wb4_cfad_crews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_crews` (
  `crew_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`crew_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_crews`
--

LOCK TABLES `wb4_cfad_crews` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_crews` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_crews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cfad_users`
--

DROP TABLE IF EXISTS `wb4_cfad_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cfad_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `crew_id` int(10) unsigned NOT NULL,
  `assigned` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cfad_users`
--

LOCK TABLES `wb4_cfad_users` WRITE;
/*!40000 ALTER TABLE `wb4_cfad_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cfad_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cleanup_exempt_crews`
--

DROP TABLE IF EXISTS `wb4_cleanup_exempt_crews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cleanup_exempt_crews` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(5) unsigned NOT NULL,
  `crew_id` int(8) unsigned NOT NULL,
  `exempted_by` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `crew_id` (`crew_id`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cleanup_exempt_crews`
--

LOCK TABLES `wb4_cleanup_exempt_crews` WRITE;
/*!40000 ALTER TABLE `wb4_cleanup_exempt_crews` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cleanup_exempt_crews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cleanup_positions`
--

DROP TABLE IF EXISTS `wb4_cleanup_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cleanup_positions` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `cleanup_id` int(8) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `completed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cleanup_id` (`cleanup_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cleanup_positions`
--

LOCK TABLES `wb4_cleanup_positions` WRITE;
/*!40000 ALTER TABLE `wb4_cleanup_positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cleanup_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_cleanups`
--

DROP TABLE IF EXISTS `wb4_cleanups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_cleanups` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(5) unsigned NOT NULL,
  `description` text,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cleanup_positions_upcoming` int(11) unsigned DEFAULT '0',
  `cleanup_positions_completed` int(11) unsigned DEFAULT '0',
  `maximum` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_cleanups`
--

LOCK TABLES `wb4_cleanups` WRITE;
/*!40000 ALTER TABLE `wb4_cleanups` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_cleanups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_countries`
--

DROP TABLE IF EXISTS `wb4_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_countries` (
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(60) DEFAULT NULL,
  `priority` smallint(6) DEFAULT '0',
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_countries`
--

LOCK TABLES `wb4_countries` WRITE;
/*!40000 ALTER TABLE `wb4_countries` DISABLE KEYS */;
INSERT INTO `wb4_countries` VALUES ('AF','Afghanistan',0),('AL','Albania',0),('DZ','Algeria',0),('AS','American Samoa',0),('AD','Andorra',0),('AO','Angola',0),('AI','Anguilla',0),('AG','Antigua and Barbuda',0),('AR','Argentina',0),('AM','Armenia',0),('AW','Aruba',0),('AU','Australia',0),('AT','Austria',0),('AZ','Azerbaijan',0),('BS','Bahamas',0),('BH','Bahrain',0),('BD','Bangladesh',0),('BB','Barbados',0),('BY','Belarus',0),('BE','Belgium',0),('BZ','Belize',0),('BJ','Benin',0),('BM','Bermuda',0),('BT','Bhutan',0),('BO','Bolivia',0),('BA','Bosnia and Herzegovina',0),('BW','Botswana',0),('BR','Brazil',0),('VG','British Virgin Islands',0),('BN','Brunei Darussalam',0),('BG','Bulgaria',0),('BF','Burkina Faso',0),('BI','Burundi',0),('KH','Cambodia',0),('CM','Cameroon',0),('CA','Canada',0),('CV','Cape Verde',0),('KY','Cayman Islands',0),('CF','Central African Republic',0),('TD','Chad',0),('CL','Chile',0),('CN','China',0),('CO','Colombia',0),('KM','Comoros',0),('CK','Cook Islands',0),('CR','Costa Rica',0),('CI','Cote d\'Ivoire',0),('HR','Croatia',0),('CU','Cuba',0),('CY','Cyprus',0),('CZ','Czech Republic',0),('CG','Democratic Republic of the Congo',0),('DK','Denmark',1),('DJ','Djibouti',0),('DM','Dominica',0),('DO','Dominican Republic',0),('TP','East Timor',0),('EC','Ecuador',0),('EG','Egypt',0),('SV','El Salvador',0),('GQ','Equatorial Guinea',0),('ER','Eritrea',0),('EE','Estonia',0),('ET','Ethiopia',0),('EU','Europe',0),('FO','Faeroe Islands',0),('FK','Falkland Islands (Malvinas)',0),('FJ','Fiji',0),('FI','Finland',1),('FR','France',0),('GF','French Guiana',0),('PF','French Polynesia',0),('GA','Gabon',0),('GM','Gambia',0),('GE','Georgia',0),('DE','Germany',1),('GH','Ghana',0),('GI','Gibraltar',0),('GR','Greece',0),('GL','Greenland',0),('GD','Grenada',0),('GP','Guadeloupe',0),('GU','Guam',0),('GT','Guatemala',0),('GN','Guinea',0),('GW','Guinea-Bissau',0),('GY','Guyana',0),('HT','Haiti',0),('VA','Holy See',0),('HN','Honduras',0),('HK','Hong Kong',0),('HU','Hungary',0),('IS','Iceland',0),('IN','India',0),('ID','Indonesia',0),('IR','Iran',0),('IQ','Iraq',0),('IE','Ireland',0),('IL','Israel',0),('IT','Italy',0),('JM','Jamaica',0),('JP','Japan',0),('JO','Jordan',0),('KZ','Kazakhstan',0),('KE','Kenya',0),('KI','Kiribati',0),('KW','Kuwait',0),('KG','Kyrgyzstan',0),('LA','Lao People\'s Democratic Republic',0),('LV','Latvia',0),('LB','Lebanon',0),('LS','Lesotho',0),('LR','Liberia',0),('LY','Libyan Arab Jamahiriya',0),('LI','Liechtenstein',0),('LT','Lithuania',0),('LU','Luxembourg',0),('MO','Macao Special Administrative Region of China',0),('MG','Madagascar',0),('MW','Malawi',0),('MY','Malaysia',0),('MV','Maldives',0),('ML','Mali',0),('MT','Malta',0),('MH','Marshall Islands',0),('MQ','Martinique',0),('MR','Mauritania',0),('MU','Mauritius',0),('MX','Mexico',0),('FM','Micronesia Federated States of,',0),('MC','Monaco',0),('MN','Mongolia',0),('MS','Montserrat',0),('MA','Morocco',0),('MZ','Mozambique',0),('MM','Myanmar',0),('NA','Namibia',0),('NR','Nauru',0),('NP','Nepal',0),('NL','Netherlands',0),('AN','Netherlands Antilles',0),('NC','New Caledonia',0),('NZ','New Zealand',0),('NI','Nicaragua',0),('NE','Niger',0),('NG','Nigeria',0),('NU','Niue',0),('NF','Norfolk Island',0),('KP','North Korea',0),('MP','Northern Mariana Islands',0),('NO','Norway',2),('OM','Oman',0),('PK','Pakistan',0),('PW','Palau',0),('PS','Palestinian Territory, Occupied',0),('PA','Panama',0),('PG','Papua New Guinea',0),('PY','Paraguay',0),('PE','Peru',0),('PH','Philippines',0),('PN','Pitcairn',0),('PL','Poland',0),('PT','Portugal',0),('PR','Puerto Rico',0),('QA','Qatar',0),('RE','Réunion',0),('MD','Republic of Moldova',0),('RO','Romania',0),('RU','Russia',0),('RW','Rwanda',0),('SH','Saint Helena',0),('KN','Saint Kitts and Nevis',0),('LC','Saint Lucia',0),('PM','Saint Pierre and Miquelon',0),('VC','Saint Vincent and the Grenadines',0),('WS','Samoa',0),('SM','San Marino',0),('ST','Sao Tome and Principe',0),('SA','Saudi Arabia',0),('SN','Senegal',0),('CS','Serbia and Montenegro',0),('SC','Seychelles',0),('SL','Sierra Leone',0),('SG','Singapore',0),('SK','Slovakia',0),('SI','Slovenia',0),('SB','Solomon Islands',0),('SO','Somalia',0),('ZA','South Africa',0),('KR','South Korea',0),('ES','Spain',0),('LK','Sri Lanka',0),('SD','Sudan',0),('SR','Suriname',0),('SJ','Svalbard and Jan Mayen Islands',0),('SZ','Swaziland',0),('SE','Sweden',1),('CH','Switzerland',0),('SY','Syrian Arab Republic',0),('TW','Taiwan',0),('TJ','Tajikistan',0),('TH','Thailand',0),('MK','The former Yugoslav Republic of Macedonia',0),('TG','Togo',0),('TK','Tokelau',0),('TO','Tonga',0),('TT','Trinidad and Tobago',0),('TN','Tunisia',0),('TR','Turkey',0),('TM','Turkmenistan',0),('TC','Turks and Caicos Islands',0),('TV','Tuvalu',0),('UG','Uganda',0),('UA','Ukraine',0),('AE','United Arab Emirates',0),('GB','United Kingdom',0),('TZ','United Republic of Tanzania',0),('US','United States',0),('VI','United States Virgin Islands',0),('UY','Uruguay',0),('UZ','Uzbekistan',0),('VU','Vanuatu',0),('VE','Venezuela',0),('VN','Viet Nam',0),('WF','Wallis and Futuna Islands',0),('EH','Western Sahara',0),('YE','Yemen',0),('YU','Yugoslavia',0),('ZM','Zambia',0),('ZW','Zimbabwe',0);
/*!40000 ALTER TABLE `wb4_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_crew_effects_items`
--

DROP TABLE IF EXISTS `wb4_crew_effects_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_crew_effects_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `sizes` varchar(128) NOT NULL,
  `price` int(10) NOT NULL,
  `amount_free` int(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `allow_order` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_crew_effects_items`
--

LOCK TABLES `wb4_crew_effects_items` WRITE;
/*!40000 ALTER TABLE `wb4_crew_effects_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_crew_effects_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_crew_effects_orders`
--

DROP TABLE IF EXISTS `wb4_crew_effects_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_crew_effects_orders` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `item_size` varchar(50) NOT NULL,
  `item_amount` int(10) unsigned NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `givenextra` tinyint(1) NOT NULL,
  `givenfree` tinyint(1) NOT NULL,
  `paid_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order_deactivated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userid` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1484 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_crew_effects_orders`
--

LOCK TABLES `wb4_crew_effects_orders` WRITE;
/*!40000 ALTER TABLE `wb4_crew_effects_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_crew_effects_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_crews`
--

DROP TABLE IF EXISTS `wb4_crews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_crews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `crew_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL,
  `hidden` tinyint(1) DEFAULT '0',
  `canapply` tinyint(1) DEFAULT '0',
  `event_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `content` text,
  `sorted_weight` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `crew_id` (`crew_id`)
) ENGINE=MyISAM AUTO_INCREMENT=288 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_crews`
--

LOCK TABLES `wb4_crews` WRITE;
/*!40000 ALTER TABLE `wb4_crews` DISABLE KEYS */;
INSERT INTO `wb4_crews` VALUES (261,0,'Dev',0,0,18,'2013-01-29 01:18:27','2013-01-29 12:58:52','0000-00-00 00:00:00','',0),(262,0,'A',0,0,18,'2013-02-12 13:28:26','2013-02-12 13:28:26','0000-00-00 00:00:00','',0),(263,0,'B',0,0,18,'2013-02-12 13:28:30','2013-02-12 13:28:30','0000-00-00 00:00:00','',0),(264,0,'C',0,0,18,'2013-02-12 13:28:34','2013-02-12 13:28:34','0000-00-00 00:00:00','',0),(265,0,'D',0,0,18,'2013-02-12 13:28:37','2013-02-12 13:28:37','0000-00-00 00:00:00','',0),(266,0,'E',0,0,18,'2013-02-12 13:28:41','2013-02-12 13:28:41','0000-00-00 00:00:00','',0),(267,0,'F',0,0,18,'2013-02-12 13:28:44','2013-02-12 13:28:44','0000-00-00 00:00:00','',0),(268,0,'G',0,0,18,'2013-02-12 13:28:47','2013-02-12 13:28:47','0000-00-00 00:00:00','',0),(269,0,'H',0,0,18,'2013-02-12 13:28:51','2013-02-12 13:28:51','0000-00-00 00:00:00','',0),(270,0,'I',0,0,18,'2013-02-12 13:28:55','2013-02-12 13:28:55','0000-00-00 00:00:00','',0),(271,0,'J',0,0,18,'2013-02-12 13:53:06','2013-02-12 13:53:06','0000-00-00 00:00:00','',0),(272,0,'K',0,0,18,'2013-02-12 13:53:10','2013-02-12 13:53:10','0000-00-00 00:00:00','',0),(273,0,'L',0,0,18,'2013-02-12 13:53:13','2013-02-12 13:53:13','0000-00-00 00:00:00','',0),(274,0,'M',0,0,18,'2013-02-12 13:53:16','2013-02-12 13:53:16','0000-00-00 00:00:00','',0),(275,0,'N',0,0,18,'2013-02-12 13:53:20','2013-02-12 13:53:20','0000-00-00 00:00:00','',0),(276,0,'O',0,0,18,'2013-02-12 13:53:24','2013-02-12 13:53:24','0000-00-00 00:00:00','',0),(277,0,'P',0,0,18,'2013-02-12 13:53:27','2013-02-12 13:53:27','0000-00-00 00:00:00','',0),(278,0,'Q',0,0,18,'2013-02-12 13:53:30','2013-02-12 13:53:30','0000-00-00 00:00:00','',0),(279,0,'R',0,0,18,'2013-02-12 13:53:34','2013-02-12 13:53:34','0000-00-00 00:00:00','',0),(280,0,'S',0,0,18,'2013-02-12 13:53:37','2013-02-12 13:53:37','0000-00-00 00:00:00','',0),(281,0,'T',0,0,18,'2013-02-12 13:53:40','2013-02-12 13:53:40','0000-00-00 00:00:00','',0),(282,0,'U',0,0,18,'2013-02-12 13:53:43','2013-02-12 13:53:43','0000-00-00 00:00:00','',0),(283,0,'V',0,0,18,'2013-02-12 13:54:00','2013-02-12 13:54:00','0000-00-00 00:00:00','',0),(284,0,'W',0,0,18,'2013-02-12 13:54:04','2013-02-12 13:54:04','0000-00-00 00:00:00','',0),(285,0,'X',0,0,18,'2013-02-12 13:54:07','2013-02-12 13:54:07','0000-00-00 00:00:00','',0),(286,0,'Y',0,0,18,'2013-02-12 13:54:10','2013-02-12 13:54:10','0000-00-00 00:00:00','',0),(287,0,'Z',0,0,18,'2013-02-12 13:54:14','2013-02-12 13:54:14','0000-00-00 00:00:00','',0);
/*!40000 ALTER TABLE `wb4_crews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_crews_users`
--

DROP TABLE IF EXISTS `wb4_crews_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_crews_users` (
  `user_id` int(10) unsigned NOT NULL,
  `crew_id` int(10) unsigned NOT NULL,
  `team_id` int(10) unsigned NOT NULL DEFAULT '0',
  `leader` tinyint(2) DEFAULT '0',
  `title` varchar(32) DEFAULT NULL,
  `assigned` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`,`crew_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_crews_users`
--

LOCK TABLES `wb4_crews_users` WRITE;
/*!40000 ALTER TABLE `wb4_crews_users` DISABLE KEYS */;
INSERT INTO `wb4_crews_users` VALUES (1,261,0,3,NULL,'2019-08-20 21:49:06'),(1918,261,0,3,NULL,'2019-08-20 21:49:06'),(2193,261,0,3,NULL,'2019-08-20 21:49:06'),(3073,261,0,3,NULL,'2019-08-20 21:49:06'),(4304,261,0,3,NULL,'2019-08-20 21:49:06'),(4607,261,0,3,NULL,'2019-08-20 21:49:06'),(4918,261,0,3,NULL,'2019-08-20 21:49:06'),(6195,261,0,3,NULL,'2019-08-20 21:49:06');
/*!40000 ALTER TABLE `wb4_crews_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_daypass`
--

DROP TABLE IF EXISTS `wb4_daypass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_daypass` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `accepted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=344 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_daypass`
--

LOCK TABLES `wb4_daypass` WRITE;
/*!40000 ALTER TABLE `wb4_daypass` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_daypass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_dispatch_cases`
--

DROP TABLE IF EXISTS `wb4_dispatch_cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_dispatch_cases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `problem_id` int(10) unsigned NOT NULL,
  `created_user_id` int(10) unsigned DEFAULT NULL,
  `seat` varchar(32) DEFAULT NULL,
  `row` varchar(32) NOT NULL,
  `switch` varchar(32) NOT NULL,
  `priority` int(10) unsigned DEFAULT '3',
  `delegated_user_id` int(10) unsigned DEFAULT NULL,
  `delegatedtime` datetime DEFAULT NULL,
  `isresolved` tinyint(1) DEFAULT '0',
  `resolved_user_id` int(10) unsigned DEFAULT NULL,
  `resolvedtime` datetime DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_dispatch_cases`
--

LOCK TABLES `wb4_dispatch_cases` WRITE;
/*!40000 ALTER TABLE `wb4_dispatch_cases` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_dispatch_cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_dispatch_problems`
--

DROP TABLE IF EXISTS `wb4_dispatch_problems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_dispatch_problems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_dispatch_problems`
--

LOCK TABLES `wb4_dispatch_problems` WRITE;
/*!40000 ALTER TABLE `wb4_dispatch_problems` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_dispatch_problems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_enroll_greetings`
--

DROP TABLE IF EXISTS `wb4_enroll_greetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_enroll_greetings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `crew_id` int(10) unsigned NOT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_enroll_greetings`
--

LOCK TABLES `wb4_enroll_greetings` WRITE;
/*!40000 ALTER TABLE `wb4_enroll_greetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_enroll_greetings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_enroll_mailfields`
--

DROP TABLE IF EXISTS `wb4_enroll_mailfields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_enroll_mailfields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `enroll_mail_id` int(11) unsigned NOT NULL,
  `name` varchar(10000) NOT NULL,
  `name_as_header` int(11) unsigned NOT NULL DEFAULT '1',
  `content` varchar(10000) DEFAULT NULL,
  `position` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_enroll_mailfields`
--

LOCK TABLES `wb4_enroll_mailfields` WRITE;
/*!40000 ALTER TABLE `wb4_enroll_mailfields` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_enroll_mailfields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_enroll_mails`
--

DROP TABLE IF EXISTS `wb4_enroll_mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_enroll_mails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `enroll_setting_id` int(11) unsigned NOT NULL,
  `subject` varchar(10000) NOT NULL,
  `type` enum('accepted','denied','pending','waiting') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_enroll_mails`
--

LOCK TABLES `wb4_enroll_mails` WRITE;
/*!40000 ALTER TABLE `wb4_enroll_mails` DISABLE KEYS */;
INSERT INTO `wb4_enroll_mails` VALUES (13,1,'Informasjon fra wannabe','denied'),(14,1,'Oppdatering fra wannabe','pending'),(16,1,'Du har blitt satt på venteliste!','waiting'),(17,1,'Velkommen i crew!','accepted');
/*!40000 ALTER TABLE `wb4_enroll_mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_enroll_settings`
--

DROP TABLE IF EXISTS `wb4_enroll_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_enroll_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) unsigned NOT NULL,
  `enrollactive` int(11) unsigned NOT NULL DEFAULT '0',
  `greetingactive` int(11) unsigned NOT NULL DEFAULT '0',
  `enrollaccept` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_enroll_settings`
--

LOCK TABLES `wb4_enroll_settings` WRITE;
/*!40000 ALTER TABLE `wb4_enroll_settings` DISABLE KEYS */;
INSERT INTO `wb4_enroll_settings` VALUES (1,18,0,0,0);
/*!40000 ALTER TABLE `wb4_enroll_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_events`
--

DROP TABLE IF EXISTS `wb4_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `reference` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locationname` varchar(128) NOT NULL,
  `latitude` varchar(32) DEFAULT NULL,
  `longitude` varchar(32) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `urlmode` enum('path','domain') DEFAULT 'path',
  `email` varchar(32) NOT NULL DEFAULT 'wannabe@gathering.org',
  `hide` tinyint(1) DEFAULT '0',
  `disable` tinyint(1) DEFAULT '0',
  `can_apply_for_crew` tinyint(1) DEFAULT '1',
  `show_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_events`
--

LOCK TABLES `wb4_events` WRITE;
/*!40000 ALTER TABLE `wb4_events` DISABLE KEYS */;
INSERT INTO `wb4_events` VALUES (18,'Development','dev','2013-01-28 00:00:00','2013-01-28 00:00:00','0000-00-00 00:00:00','Roy','23.3','45.45','2013-08-13 00:00:00','2013-08-15 00:00:00','path','wannabe@gathering.org',0,0,0,NULL);
/*!40000 ALTER TABLE `wb4_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_events_menuitems`
--

DROP TABLE IF EXISTS `wb4_events_menuitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_events_menuitems` (
  `menuitem_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned DEFAULT '0',
  `hidden` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`menuitem_id`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_events_menuitems`
--

LOCK TABLES `wb4_events_menuitems` WRITE;
/*!40000 ALTER TABLE `wb4_events_menuitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_events_menuitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_found_items`
--

DROP TABLE IF EXISTS `wb4_found_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_found_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `storage_place_id` int(10) unsigned NOT NULL,
  `found_by` text,
  `found_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `found_logged_in_user` int(10) unsigned NOT NULL,
  `found_registered_by` int(10) unsigned NOT NULL,
  `resolved` tinyint(1) NOT NULL,
  `resolved_description` text,
  `resolved_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resolved_delivered_by` int(10) unsigned DEFAULT NULL,
  `resolved_delivered_to` text NOT NULL,
  `resolved_logged_in_user` int(10) unsigned DEFAULT NULL,
  `resolved_registered_by` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_found_items`
--

LOCK TABLES `wb4_found_items` WRITE;
/*!40000 ALTER TABLE `wb4_found_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_found_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_front_news`
--

DROP TABLE IF EXISTS `wb4_front_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_front_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT 'News',
  `title` varchar(100) DEFAULT 'Wannabe',
  `content` mediumtext,
  `active` tinyint(1) DEFAULT '1',
  `left_box` tinyint(1) DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_front_news`
--

LOCK TABLES `wb4_front_news` WRITE;
/*!40000 ALTER TABLE `wb4_front_news` DISABLE KEYS */;
INSERT INTO `wb4_front_news` VALUES (1,'Hva er wannabe','¿Hvø ær Wünnåbø?','Wannabe er en arrangementsdatabase bereget for frivillige arrangementer.<br /> Vil du bruke wannabe til ditt arrangement? Send inn en <a href=\"mailto:wannabe@gathering.org\">forespørsel</a>.',1,1,'2011-10-01 22:07:09','2011-09-22 01:03:17','0000-00-00 00:00:00'),(2,'Wannabe til iOS','Wannabe til iOS','Last news wannabe-applikasjonen fra iTunes. <a href=\"http://www.existemi.no/\">Finn ut mer</a>.',1,0,'2011-09-21 23:05:02','2011-09-22 01:05:02','0000-00-00 00:00:00'),(3,'Which','Which crew?','Read through the <a href=\"/tg13/Crew/Description\">descriptions</a> to see which crew will fit you best!',1,0,'2012-10-28 16:14:11','2011-10-07 10:56:03','0000-00-00 00:00:00'),(4,'Apply','Apply for crew!','As <a href=\"http://www.gathering.org/\">TG13</a> draws nearer we are yet again in need of <em>you</em> to apply now so that, together, we can make this years event the best one ever!',1,1,'2012-10-28 16:13:42','2011-10-07 20:48:38','0000-00-00 00:00:00'),(5,'Hvilket crew?','Hvilket crew?','Se gjennom <a href=\"/tg13/Crew/Description\">beskrivelsene</a> for å finne ut hvilket crew du ønsker å bidra i.',1,0,'2012-10-28 16:13:08','2011-10-07 21:57:00','0000-00-00 00:00:00'),(6,'Søk crew!','Søk crew!','<a href=\"http://www.gathering.org\">TG13</a> nærmer seg med stormskritt, og vi trenger at nettopp du legger inn din søknad, slik at du kan gjøre årets arrangement til det største noen sinne!',1,1,'2012-10-28 16:12:14','2011-10-07 22:00:06','0000-00-00 00:00:00'),(7,'Test','Test','Tester vi ser du',0,0,'2012-03-14 21:09:18','2011-11-27 05:15:15','0000-00-00 00:00:00'),(8,'ijajeogij','aoijeoigj','Norsk',0,0,'2012-03-14 21:16:25','2012-03-14 22:16:25','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `wb4_front_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_i18n`
--

DROP TABLE IF EXISTS `wb4_i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM AUTO_INCREMENT=300 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_i18n`
--

LOCK TABLES `wb4_i18n` WRITE;
/*!40000 ALTER TABLE `wb4_i18n` DISABLE KEYS */;
INSERT INTO `wb4_i18n` VALUES (2,'eng','FrontNews',3,'content','Read through the <a href=\"/tg13/Crew/Description\">descriptions</a> to see which crew will fit you best!'),(1,'eng','FrontNews',3,'title','Which crew?'),(3,'eng','FrontNews',4,'title','Apply for crew!'),(4,'eng','FrontNews',4,'content','As <a href=\"http://www.gathering.org/\">TG13</a> draws nearer we are yet again in need of <em>you</em> to apply now so that, together, we can make this years event the best one ever!'),(5,'nob','FrontNews',5,'title','Hvilket crew?'),(6,'nob','FrontNews',5,'content','Se gjennom <a href=\"/tg13/Crew/Description\">beskrivelsene</a> for å finne ut hvilket crew du ønsker å bidra i.'),(7,'nob','FrontNews',6,'title','Søk crew!'),(8,'nob','FrontNews',6,'content','<a href=\"http://www.gathering.org\">TG13</a> nærmer seg med stormskritt, og vi trenger at nettopp du legger inn din søknad, slik at du kan gjøre årets arrangement til det største noen sinne!'),(9,'nob','Menuitem',1,'name','Vis profil'),(10,'nob','Menuitem',2,'name','Ditt'),(11,'nob','Menuitem',3,'name','Oppmøte'),(12,'nob','Menuitem',4,'name','Logg ut'),(13,'nob','Menuitem',7,'name','Søknader'),(14,'nob','Menuitem',8,'name','Crew'),(15,'nob','Menuitem',9,'name','IRC-nøkler'),(16,'nob','Menuitem',10,'name','Profilbildekontroll'),(17,'nob','Menuitem',13,'name','Cola-tavler'),(18,'nob','Menuitem',14,'name','Brukerstøtte'),(19,'nob','Menuitem',15,'name','Hittegods'),(20,'nob','Menuitem',17,'name','Adgangskort'),(21,'nob','Menuitem',18,'name','Oppmøte'),(22,'nob','Menuitem',20,'name','Administrasjon'),(23,'nob','Menuitem',23,'name','Rediger profil'),(24,'nob','Menuitem',24,'name','Bil en annen bruker'),(25,'nob','Menuitem',33,'name','Arrangement'),(26,'nob','Menuitem',35,'name','Behandle'),(27,'nob','Menuitem',36,'name','Brukerinformasjon'),(28,'nob','Menuitem',50,'name','Bilskilter'),(29,'nob','Menuitem',53,'name','Logistikk'),(30,'nob','Menuitem',60,'name','Søknadsspørsmål'),(31,'nob','Menuitem',61,'name','Velkomsthilsner'),(32,'nob','Menuitem',67,'name','Medisinske behov'),(33,'nob','Menuitem',68,'name','Ernæringsbehov'),(34,'nob','Menuitem',71,'name','Statistikk'),(35,'nob','Menuitem',72,'name','Presseakkreditering'),(36,'nob','Menuitem',77,'name','SMS'),(37,'nob','Menuitem',85,'name','Meny'),(38,'nob','Menuitem',87,'name','Beskrivelser'),(39,'nob','Menuitem',88,'name','Søknader'),(40,'nob','Menuitem',89,'name','Opptak'),(41,'nob','Menuitem',90,'name','Tilgangskontroll'),(42,'nob','Menuitem',94,'name','Innsjekking'),(43,'nob','Menuitem',97,'name','Scene-tavler'),(44,'nob','Menuitem',96,'name','E-postlister'),(45,'nob','Menuitem',98,'name','Ryddetider'),(46,'nob','Menuitem',102,'name','Sovekart'),(47,'eng','Menuitem',1,'name','View profile'),(48,'eng','Menuitem',2,'name','Your'),(49,'eng','Menuitem',4,'name','Sign out'),(50,'eng','Menuitem',7,'name','Applications'),(51,'eng','Menuitem',8,'name','Crew'),(52,'eng','Menuitem',9,'name','IRC keys'),(53,'eng','Menuitem',10,'name','Profile picture control'),(54,'eng','Menuitem',13,'name','Score board'),(55,'eng','Menuitem',14,'name','Dispatch'),(56,'eng','Menuitem',15,'name','Lost and found'),(57,'eng','Menuitem',17,'name','Access card'),(58,'eng','Menuitem',18,'name','Attendance'),(59,'eng','Menuitem',20,'name','Administration'),(60,'eng','Menuitem',23,'name','Edit profile'),(61,'eng','Menuitem',24,'name','Become another user'),(62,'eng','Menuitem',33,'name','Event'),(63,'eng','Menuitem',35,'name','Manage'),(64,'eng','Menuitem',36,'name','User information'),(65,'eng','Menuitem',50,'name','Car plates'),(66,'eng','Menuitem',53,'name','Logistics'),(67,'eng','Menuitem',60,'name','Application questions'),(68,'eng','Menuitem',61,'name','Greetings'),(69,'eng','Menuitem',67,'name','Medical needs'),(70,'eng','Menuitem',68,'name','Nutritional needs'),(71,'eng','Menuitem',71,'name','Statistics'),(72,'eng','Menuitem',72,'name','Press accreditation'),(73,'eng','Menuitem',77,'name','SMS'),(74,'eng','Menuitem',85,'name','Menu'),(75,'eng','Menuitem',87,'name','Descriptions'),(76,'eng','Menuitem',88,'name','Application'),(77,'eng','Menuitem',89,'name','Enrollment'),(78,'eng','Menuitem',90,'name','Access control'),(79,'eng','Menuitem',94,'name','Check in'),(80,'eng','Menuitem',97,'name','Stage board'),(81,'eng','Menuitem',96,'name','Mailingslists'),(295,'eng','Menuitem',143,'name','Cleanup registration'),(83,'eng','Menuitem',102,'name','Sleep map'),(84,'nob','Menuitem',104,'name','Ditt crew'),(85,'nob','Menuitem',105,'name','Liste'),(86,'nob','Menuitem',106,'name','nick'),(87,'nob','Menuitem',107,'name','Moduler'),(88,'nob','Menuitem',108,'name','Klær'),(89,'eng','Menuitem',104,'name','Your crew'),(90,'eng','Menuitem',105,'name','List'),(91,'eng','Menuitem',106,'name','nick'),(92,'eng','Menuitem',107,'name','Modules'),(93,'eng','Menuitem',108,'name','Clothing'),(94,'nob','Menuitem',109,'name','Endre arrangement'),(95,'eng','Menuitem',109,'name','Change event'),(96,'eng','Phonetype',1,'name','Mobile'),(97,'eng','Phonetype',2,'name','Home'),(98,'eng','Phonetype',3,'name','Work'),(99,'nob','Phonetype',1,'name','Mobil'),(100,'nob','Phonetype',2,'name','Hjem'),(101,'nob','Phonetype',3,'name','Arbeid'),(102,'nob','FrontNews',7,'title','Test'),(103,'nob','FrontNews',7,'content','Tester vi ser du'),(104,'nob','Menuitem',110,'name','Crew'),(105,'eng','Menuitem',110,'name','Crew'),(106,'eng','MenuItem',111,'name','News'),(107,'nob','MenuItem',111,'name','Nyheter'),(108,'nob','Menuitem',113,'name','E-postlister'),(109,'eng','Menuitem',113,'name','Mailing lists'),(110,'eng','Menuitem',114,'name','Privacy'),(111,'nob','Menuitem',114,'name','Personvern'),(112,'eng','Menuitem',115,'name','Needs'),(113,'nob','Menuitem',115,'name','Behov'),(143,'eng','Task',3,'message','Please fill in any needs you might have'),(142,'nob','Task',3,'message','Vennligst fyll inn eventuelle behov du har'),(140,'eng','PictureRule',7,'rule_text','The picture must be at least 320x427 pixels in size.'),(139,'nob','PictureRule',7,'denied_text','Ditt bilde er ikke stort nok. Last opp et bilde som er større enn 320x427 piksler størrelse.'),(138,'nob','PictureRule',7,'rule_text','Bildet må være over 320x427 piksler størrelse.'),(156,'nob','Task',2,'message','Vennligst oppgi din størrelse'),(154,'nob','Task',4,'glenn','aegaeg'),(155,'eng','Task',4,'glenn','134134'),(144,'nob','FrontNews',8,'title','aoijeoigj'),(145,'nob','FrontNews',8,'content','Norsk'),(141,'eng','PictureRule',7,'denied_text','Your picture was too small. Upload a picture which is at least 320x427 pixels in size.'),(126,'nob','Menuitem',116,'name','Creweffekter'),(127,'eng','Menuitem',116,'name','Crew effects'),(128,'nob','Menuitem',117,'name','Creweffekter'),(129,'eng','Menuitem',117,'name','Crew effects'),(130,'eng','Menuitem',118,'name','Crew effects'),(131,'nob','Menuitem',118,'name','Creweffekter'),(132,'nob','Menuitem',119,'name','Bilderegler'),(133,'eng','Menuitem',119,'name','Picture rules'),(134,'eng','Menuitem',120,'name','Tasks'),(135,'nob','Menuitem',120,'name','Oppgaver'),(157,'eng','Task',2,'message','Please fill in your size'),(158,'nob','Menuitem',121,'name','Oppmøte'),(159,'eng','Menuitem',121,'name','Showup time'),(160,'nob','Task',4,'message','Vennligst sett din oppmøtetid'),(161,'eng','Task',4,'message','Please set your showup time'),(162,'eng','Menuitem',122,'name','Accreditation'),(163,'nob','Menuitem',122,'name','Akkreditering'),(164,'nob','Task',5,'message','Din oppmøtetid har blitt avslått, vennglist sett en ny'),(165,'eng','Task',5,'message','You showup time has been denied, please provide a new'),(166,'nob','Menuitem',123,'name','Mattider'),(167,'nob','Menuitem',124,'name','Mattider'),(168,'eng','Menuitem',124,'name','Meal times'),(169,'eng','Menuitem',123,'name','Meal times'),(170,'nob','PictureRule',10,'rule_text','Profilbildet trykkes på ditt personlige ID-kort. Kortet fungerer som en identifikasjon og gir deg adgang til arrangementet. Bildet må derfor best mulig identifisere deg, og tilfredsstille spesifikke krav til kvalitet og utforming. Dersom bildet ikke fyller disse kravene, blir du bedt om å laste opp et nytt bilde.'),(171,'nob','PictureRule',10,'denied_text','Profilbildet ditt tilfredstiller ikke kravene for å identifisere deg godt nok.'),(172,'eng','PictureRule',10,'rule_text','The profile picture will be printed on your personal ID card. The card serves as an identification and gives you access to the event. The image must identify you, and satisfy the specific requirements for quality and layout. If your image does not meet these requirements, you will be prompted to upload a new image.'),(173,'eng','PictureRule',10,'denied_text','Your profile photo does not meet the requirements to identify you well enough.'),(174,'nob','PictureRule',11,'rule_text','Bildet skal tas rett forfra og vise hele ansiktet. Ikke halfprofil.'),(175,'nob','PictureRule',11,'denied_text','Bildet skal tas rett forfra og vise hele ansiktet. Ikke halvprofil!'),(176,'eng','PictureRule',11,'rule_text','The picture must be taken directly from the front and show the whole face. Not half profile!'),(177,'eng','PictureRule',11,'denied_text','The picture must be taken directly from the front and show the whole face. Not half profile!'),(178,'nob','PictureRule',12,'rule_text','Bakgrunnen skal være lys eller nøytral'),(179,'nob','PictureRule',12,'denied_text','Bakgrunnen i profilbildene må være lys eller nøytral. Vennligst last opp et bilde som tilfredstiller dette kravet'),(180,'eng','PictureRule',12,'rule_text','The background must be light or neutral'),(181,'eng','PictureRule',12,'denied_text','The background in profile pictures must be light or neutral. Please upload a photo that meets this requirement'),(182,'nob','PictureRule',13,'rule_text','Øynene skal være åpne, synlige og ikke dekkes av hår'),(183,'nob','PictureRule',13,'denied_text','Ditt bilde møter ikke kravene om synlighet av øyne. De skal ikke være dekket av hår og må ikke være lukket'),(184,'eng','PictureRule',13,'rule_text','The eyes must be open, visible and not covered by hair'),(185,'eng','PictureRule',13,'denied_text','Your image does not meet the requirements for visibility of the eyes. They should not be covered by hair, and they must not be closed'),(186,'nob','PictureRule',14,'rule_text','Detaljer i ansiktet må vises tydelig'),(187,'nob','PictureRule',14,'denied_text','Ditt bilde møter ikke kravene for bildegodkjenning. Alle detaljer i ansiktet må vises tydelig'),(188,'eng','PictureRule',14,'rule_text','Details of the face must be clearly displayed'),(189,'eng','PictureRule',14,'denied_text','Your image does not meet the requirements for picture approval. Details of the face must be clearly displayed'),(190,'nob','PictureRule',15,'rule_text','Briller er tillatt. Unngå at innfatningen skjuler noe av øynene eller reflekterer lys'),(191,'nob','PictureRule',15,'denied_text','Ditt bilde møter ikke kravene for bildegodkjenning. Vi tillater naturligvis bilder med briller, men unngå bilder der innfatningen skjuler noe av øynene eller reflekterer lys'),(192,'eng','PictureRule',15,'rule_text','Glasses are permitted. Please avoid frame that hides some of your eyes or reflect light'),(193,'eng','PictureRule',15,'denied_text','Your image does not meet the requirements for profile approval. We do allow pictures with glasses, but please avoid pictures where the frame hides some of your eyes or reflect light'),(194,'nob','PictureRule',16,'rule_text','Brilleglass skal ikke være farget (solbriller er ikke tillatt)'),(195,'nob','PictureRule',16,'denied_text','Ditt bilde møter ikke kravene for bildegodkjenning. Vi tillater naturligvis bilder med briller, men unngå brilleglass som er farget (solbriller er ikke tillatt)'),(196,'eng','PictureRule',16,'rule_text','Glasses should not be colored (sunglasses are not allowed)'),(197,'eng','PictureRule',16,'denied_text','Your image does not meet the requirements for picture approval. We do allow pictures with glasses, but avoid lenses that are colored (sunglasses are not allowed)'),(198,'nob','PictureRule',17,'rule_text','Hodeplagg er ikke tillatt'),(199,'nob','PictureRule',17,'denied_text','Ditt bilde møter ikke kravene for bildegodkjenning. Hodeplagg er ikke tillatt (caps, hatt, hårbøyle med kaninører og lignende)'),(200,'eng','PictureRule',17,'rule_text','Headgear is not permitted'),(201,'eng','PictureRule',17,'denied_text','Your image does not meet the requirements for picture approval. Headgear is not allowed (cap, hat, headband with rabbit ears, etc.)'),(202,'nob','PictureRule',18,'rule_text','… men hodeplagg med religiøse og/eller særskilte årsaker er ok, dersom du bruker tilsvarende hodeplagg under arrangementet'),(203,'nob','PictureRule',18,'denied_text','Ditt bilde møter ikke kravene for bildegodkjenning. Hodeplagg er ikke tillatt (caps, hatt, hårbøyle med kaninører og lignende)'),(204,'eng','PictureRule',18,'rule_text','... but headgear with religious and/or specific causes are ok, if you are using similar headgear during the event'),(205,'eng','PictureRule',18,'denied_text','Your image does not meet the requirements for picture approval. Headgear is not allowed (cap, hat, headband with rabbit ears, etc.)'),(206,'nob','PictureRule',19,'rule_text','Bildet må ha et størrelsesforhold på 3:4 (0.75:1), bruk beskjæringsfunksjonen for å oppnå dette.'),(207,'nob','PictureRule',19,'denied_text','Ditt bilde har feil størrelsesforhold. Last opp nytt bilde og benytt deg av beskjæringsfunksjonen i Wannabe for å oppnå dette.'),(208,'eng','PictureRule',19,'rule_text','The picture must has an aspect ratio of 3:4 (0.75:1). Use the crop function to achieve this.'),(209,'eng','PictureRule',19,'denied_text','Your picture has the wrong aspect ratio. Upload a new picture and use the crop function in Wannabe to achieve correct aspect ratio.'),(210,'nob','PictureRule',20,'rule_text','Bildet skal være av ditt ansikt, ikke hele overkroppen'),(211,'nob','PictureRule',20,'denied_text','Ansiktet ditt er for lite, og vil synes dårlig på ID-kortene, last opp et bilde hvor kun ditt ansikt er i fokus.'),(212,'eng','PictureRule',20,'rule_text','The picture should be of you face, not your whole upper body.'),(213,'eng','PictureRule',20,'denied_text','Your face is too small and will be poorly visible on the ID cards. Please upload a new picture.'),(214,'nob','Menuitem',125,'name','Bilskilt'),(215,'nob','Menuitem',126,'name','Bilskilter'),(216,'eng','Menuitem',126,'name','Car plates'),(217,'eng','Menuitem',125,'name','Car plate'),(218,'eng','Menuitem',127,'name','Slideshow'),(219,'nob','Menuitem',127,'name','Lysbildefremvisning'),(220,'nob','Menuitem',128,'name','SMS'),(221,'eng','Menuitem',128,'name','SMS'),(294,'nob','Menuitem',143,'name','Registrere rydding'),(224,'eng','Menuitem',130,'name','Lost and found'),(225,'nob','Menuitem',130,'name','Tapt og funnet'),(226,'eng','Menuitem',131,'name','Keycard'),(227,'nob','Menuitem',131,'name','Nokkelkort'),(230,'nob','Task',6,'message','Vennligst velg din mattid'),(231,'eng','Task',6,'message','Please choose you meal time'),(232,'nob','Menuitem',133,'name','Sovekart'),(233,'eng','Menuitem',133,'name','Sleeping places'),(234,'nob','Menuitem',134,'name','KANDU-Medlemskap'),(235,'eng','Menuitem',134,'name','KANDU Membership'),(236,'nob','Task',7,'message','a'),(237,'eng','Task',7,'message','b'),(238,'nob','Task',8,'message','Vennligst oppgi din størrelse'),(239,'eng','Task',8,'message','Please fill in your size'),(240,'nob','Task',9,'message','Vennligst fyll inn eventuelle behov du har'),(241,'eng','Task',9,'message','Please fill in any needs you might have'),(242,'nob','Task',10,'message','Vennligst sett din oppmøtetid'),(243,'eng','Task',10,'message','Please set your showup time'),(244,'nob','Task',11,'message','Vennligst velg din mattid'),(245,'eng','Task',11,'message','Please choose you meal time'),(246,'nob','Task',12,'message','Velg ditt medlemskap'),(247,'eng','Task',12,'message','Choose your membership'),(254,'nob','Term',2,'title','Rettigheter'),(253,'eng','Menuitem',135,'name','Terms'),(252,'nob','Menuitem',135,'name','Rettigheter'),(255,'nob','Term',2,'content','Som frivillig crew-medlem vet jeg at det stilles krav til meg og mitt arbeid.\r\n\r\nArrangøren av The Gathering, KANDU, får fritt benytte seg av alt arbeid som utføres for The Gathering, som f.eks. systemutvikling, grafikk, konsept, med mer.\r\n\r\nKANDU beholder bruksrett til alt som er utviklet og produsert også etter at crew-medlemmet avslutter sitt engasjement i organisasjonen. Materiellet kan i tillegg videreutvikles av The Gathering.\r\n\r\nCrew-medlemmet som produserte og/eller utviklet materiellet beholder allikevel rettigheten til å videreutvikle og/eller selge materiellet etter at engasjementet i organisasjonen er avsluttet.\r\n\r\nKANDU kan ikke videreselge materiellet, men står fritt til å bruke det så lenge dette ikke er i et kommersielt øyemed.'),(256,'eng','Term',2,'title','Terms'),(257,'eng','Term',2,'content','As a volunteering crew member, I acknowledge that requirements are set for myself and my efforts.\r\n\r\nThe organizer of The Gathering, KANDU, may freely use any and all work produced for The Gathering, for example developed systems, graphics, concepts and more.\r\n\r\nKANDU retains the right to use everything developed and produced by the crew member also after the member ends involvement in the organization. The product may also be further developed by The Gathering.\r\n\r\nThe crew member who produced and/or developed the product will nevertheless retain the right to further develop and/or sell the product after the involvement in the organization is ended.\r\n\r\nKANDU may not resell the product, but shall be free to use it as long as it is not used in a commercial context.'),(292,'nob','Menuitem',142,'name','SMS-budsjetter'),(293,'eng','Menuitem',142,'name','SMS-budgets'),(296,'nob','Menuitem',144,'name','Rydding'),(297,'eng','Menuitem',144,'name','Cleanup'),(298,'nob','Menuitem',145,'name','Ryddetider'),(299,'eng','Menuitem',145,'name','Cleanup times');
/*!40000 ALTER TABLE `wb4_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_improtocols`
--

DROP TABLE IF EXISTS `wb4_improtocols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_improtocols` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_improtocols`
--

LOCK TABLES `wb4_improtocols` WRITE;
/*!40000 ALTER TABLE `wb4_improtocols` DISABLE KEYS */;
INSERT INTO `wb4_improtocols` VALUES (1,'MSN'),(2,'ICQ'),(3,'AIM'),(4,'AOL'),(5,'Skype'),(6,'GTalk');
/*!40000 ALTER TABLE `wb4_improtocols` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_irc_channel_key_crews`
--

DROP TABLE IF EXISTS `wb4_irc_channel_key_crews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_irc_channel_key_crews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `irc_channel_key_id` int(10) NOT NULL,
  `crew_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_irc_channel_key_crews`
--

LOCK TABLES `wb4_irc_channel_key_crews` WRITE;
/*!40000 ALTER TABLE `wb4_irc_channel_key_crews` DISABLE KEYS */;
INSERT INTO `wb4_irc_channel_key_crews` VALUES (1,16,261);
/*!40000 ALTER TABLE `wb4_irc_channel_key_crews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_irc_channel_keys`
--

DROP TABLE IF EXISTS `wb4_irc_channel_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_irc_channel_keys` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL DEFAULT '0',
  `channelname` varchar(32) NOT NULL,
  `channelkey` varchar(64) NOT NULL,
  `updated` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`,`event_id`),
  UNIQUE KEY `event_id` (`event_id`,`channelname`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_irc_channel_keys`
--

LOCK TABLES `wb4_irc_channel_keys` WRITE;
/*!40000 ALTER TABLE `wb4_irc_channel_keys` DISABLE KEYS */;
INSERT INTO `wb4_irc_channel_keys` VALUES (16,18,'#irc','kaffe','2013-02-17 05:02:47');
/*!40000 ALTER TABLE `wb4_irc_channel_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_kandu_membership_settings`
--

DROP TABLE IF EXISTS `wb4_kandu_membership_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_kandu_membership_settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `year` int(4) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_kandu_membership_settings`
--

LOCK TABLES `wb4_kandu_membership_settings` WRITE;
/*!40000 ALTER TABLE `wb4_kandu_membership_settings` DISABLE KEYS */;
INSERT INTO `wb4_kandu_membership_settings` VALUES (1,18,0,2019,'2019-01-01 23:59:00');
/*!40000 ALTER TABLE `wb4_kandu_membership_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_kandu_memberships`
--

DROP TABLE IF EXISTS `wb4_kandu_memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_kandu_memberships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `choice` int(1) NOT NULL DEFAULT '0',
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=165 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_kandu_memberships`
--

LOCK TABLES `wb4_kandu_memberships` WRITE;
/*!40000 ALTER TABLE `wb4_kandu_memberships` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_kandu_memberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_keycard_cards`
--

DROP TABLE IF EXISTS `wb4_keycard_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_keycard_cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_number` int(11) unsigned NOT NULL,
  `event_id` int(11) unsigned DEFAULT NULL,
  `handed_out` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_keycard_cards`
--

LOCK TABLES `wb4_keycard_cards` WRITE;
/*!40000 ALTER TABLE `wb4_keycard_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_keycard_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_keycard_handouts`
--

DROP TABLE IF EXISTS `wb4_keycard_handouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_keycard_handouts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_id` int(11) unsigned DEFAULT NULL,
  `event_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `seat` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `deposit` varchar(255) DEFAULT NULL,
  `deposit_desc` text,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=339 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_keycard_handouts`
--

LOCK TABLES `wb4_keycard_handouts` WRITE;
/*!40000 ALTER TABLE `wb4_keycard_handouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_keycard_handouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_bulks`
--

DROP TABLE IF EXISTS `wb4_logistic_bulks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_bulks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` int(10) unsigned DEFAULT '0',
  `amountleft` int(10) unsigned DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logistic_supplier_id` int(10) unsigned NOT NULL,
  `type` enum('series','bulk') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_bulks`
--

LOCK TABLES `wb4_logistic_bulks` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_bulks` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_bulks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_items`
--

DROP TABLE IF EXISTS `wb4_logistic_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `comment` text,
  `logistic_supplier_id` int(10) unsigned DEFAULT NULL,
  `AssetTag` varchar(255) DEFAULT NULL,
  `serialnumber` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `logistic_bulk_id` int(10) unsigned DEFAULT '0',
  `unrig_storage_id` int(10) unsigned DEFAULT NULL,
  `condition` enum('ok','damaged','destroyed','lost') NOT NULL DEFAULT 'ok',
  `parent` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=543 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_items`
--

LOCK TABLES `wb4_logistic_items` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_items_logistic_tags`
--

DROP TABLE IF EXISTS `wb4_logistic_items_logistic_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_items_logistic_tags` (
  `logistic_item_id` int(10) unsigned NOT NULL,
  `logistic_tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`logistic_item_id`,`logistic_tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_items_logistic_tags`
--

LOCK TABLES `wb4_logistic_items_logistic_tags` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_items_logistic_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_items_logistic_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_locations`
--

DROP TABLE IF EXISTS `wb4_logistic_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  `longitude` varchar(16) DEFAULT '0',
  `latitude` varchar(16) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_locations`
--

LOCK TABLES `wb4_logistic_locations` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_statuses`
--

DROP TABLE IF EXISTS `wb4_logistic_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `canonicalname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_statuses`
--

LOCK TABLES `wb4_logistic_statuses` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_statuses` DISABLE KEYS */;
INSERT INTO `wb4_logistic_statuses` VALUES (1,'REGISTERED','Registered'),(2,'IN_TRANSIT','In transit'),(3,'ARRIVED','Arrived'),(4,'CHECKED_OUT','Checked out'),(5,'CHECKED_IN','Checked in'),(6,'RETURNED','Returned'),(7,'MOVED','Moved'),(8,'UNREGISTERED','Unregistered'),(9,'REREGISTERED','Re-registered');
/*!40000 ALTER TABLE `wb4_logistic_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_storages`
--

DROP TABLE IF EXISTS `wb4_logistic_storages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_storages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logistic_location_id` int(10) unsigned NOT NULL,
  `comment` text,
  `deleted` tinyint(1) DEFAULT '0',
  `type` enum('default','unrig') NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_storages`
--

LOCK TABLES `wb4_logistic_storages` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_storages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_storages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_suppliers`
--

DROP TABLE IF EXISTS `wb4_logistic_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(255) NOT NULL,
  `contact` varchar(25) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_suppliers`
--

LOCK TABLES `wb4_logistic_suppliers` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_suppliers` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_tags`
--

DROP TABLE IF EXISTS `wb4_logistic_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_tags`
--

LOCK TABLES `wb4_logistic_tags` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_logistic_transactions`
--

DROP TABLE IF EXISTS `wb4_logistic_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_logistic_transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `logistic_item_id` int(10) unsigned DEFAULT NULL,
  `logistic_bulk_id` int(10) unsigned DEFAULT '0',
  `logistic_status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `crew_id` int(10) unsigned DEFAULT NULL,
  `doneby_id` int(10) unsigned NOT NULL,
  `donedate` datetime DEFAULT NULL,
  `amount` int(10) unsigned DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `comment` text,
  `logistic_storage_id` int(10) unsigned DEFAULT '0',
  `prev_logistic_storage_id` int(11) DEFAULT NULL,
  `storage_comment` varchar(255) DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `hand_out_comment` text,
  PRIMARY KEY (`id`),
  KEY `idx_logistic_transactions_user_id` (`user_id`),
  KEY `idx_logistic_transactions_logistic_item_id` (`logistic_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2390 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_logistic_transactions`
--

LOCK TABLES `wb4_logistic_transactions` WRITE;
/*!40000 ALTER TABLE `wb4_logistic_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_logistic_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_lost_and_found_categories`
--

DROP TABLE IF EXISTS `wb4_lost_and_found_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_lost_and_found_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_lost_and_found_categories`
--

LOCK TABLES `wb4_lost_and_found_categories` WRITE;
/*!40000 ALTER TABLE `wb4_lost_and_found_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_lost_and_found_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_lost_and_found_storage_places`
--

DROP TABLE IF EXISTS `wb4_lost_and_found_storage_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_lost_and_found_storage_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_lost_and_found_storage_places`
--

LOCK TABLES `wb4_lost_and_found_storage_places` WRITE;
/*!40000 ALTER TABLE `wb4_lost_and_found_storage_places` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_lost_and_found_storage_places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_lost_and_founds`
--

DROP TABLE IF EXISTS `wb4_lost_and_founds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_lost_and_founds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `found_where` text NOT NULL,
  `found_when` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reported_by` varchar(255) NOT NULL,
  `reported_by_contact` text,
  `delivered_to` varchar(255) DEFAULT NULL,
  `delivered_to_contact` text,
  `resolved` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resolved_by` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=223 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_lost_and_founds`
--

LOCK TABLES `wb4_lost_and_founds` WRITE;
/*!40000 ALTER TABLE `wb4_lost_and_founds` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_lost_and_founds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_lost_items`
--

DROP TABLE IF EXISTS `wb4_lost_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_lost_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `storage_place_id` int(10) unsigned DEFAULT NULL,
  `description` text NOT NULL,
  `last_seen_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_seen_where` text,
  `lost_by` text,
  `lost_registered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lost_registered_logged_in_user` int(10) unsigned NOT NULL,
  `lost_registered_by` int(10) unsigned NOT NULL,
  `found_by` text,
  `found_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `found_logged_in_user` int(10) unsigned DEFAULT NULL,
  `found_registered_by` int(10) unsigned DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL,
  `resolved_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resolved_logged_in_user` int(10) unsigned DEFAULT NULL,
  `resolved_registered_by` int(10) unsigned DEFAULT NULL,
  `resolved_delivered_by` int(10) unsigned DEFAULT NULL,
  `resolved_description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_lost_items`
--

LOCK TABLES `wb4_lost_items` WRITE;
/*!40000 ALTER TABLE `wb4_lost_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_lost_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `wb4_mailinglistaddress_crewnews`
--

DROP TABLE IF EXISTS `wb4_mailinglistaddress_crewnews`;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistaddress_crewnews`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `wb4_mailinglistaddress_crewnews` (
  `realname` tinyint NOT NULL,
  `username` tinyint NOT NULL,
  `address` tinyint NOT NULL,
  `mailinglist` tinyint NOT NULL,
  `event_id` tinyint NOT NULL,
  `event_reference` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `wb4_mailinglistaddresses`
--

DROP TABLE IF EXISTS `wb4_mailinglistaddresses`;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistaddresses`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `wb4_mailinglistaddresses` (
  `address` tinyint NOT NULL,
  `username` tinyint NOT NULL,
  `mailinglist` tinyint NOT NULL,
  `event_id` tinyint NOT NULL,
  `event_reference` tinyint NOT NULL,
  `realname` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `wb4_mailinglistaddresses_notopts`
--

DROP TABLE IF EXISTS `wb4_mailinglistaddresses_notopts`;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistaddresses_notopts`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `wb4_mailinglistaddresses_notopts` (
  `address` tinyint NOT NULL,
  `username` tinyint NOT NULL,
  `mailinglist` tinyint NOT NULL,
  `mailinglist_id` tinyint NOT NULL,
  `event_id` tinyint NOT NULL,
  `event_reference` tinyint NOT NULL,
  `realname` tinyint NOT NULL,
  `optional` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `wb4_mailinglistmoderators`
--

DROP TABLE IF EXISTS `wb4_mailinglistmoderators`;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistmoderators`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `wb4_mailinglistmoderators` (
  `email` tinyint NOT NULL,
  `mailinglist` tinyint NOT NULL,
  `moderatorpassword` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `wb4_mailinglistrule_crewnews`
--

DROP TABLE IF EXISTS `wb4_mailinglistrule_crewnews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailinglistrule_crewnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mailinglist_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mailinglist_id` (`mailinglist_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailinglistrule_crewnews`
--

LOCK TABLES `wb4_mailinglistrule_crewnews` WRITE;
/*!40000 ALTER TABLE `wb4_mailinglistrule_crewnews` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailinglistrule_crewnews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mailinglistrule_teams`
--

DROP TABLE IF EXISTS `wb4_mailinglistrule_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailinglistrule_teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mailinglist_id` int(10) unsigned NOT NULL,
  `action` enum('add','remove') DEFAULT NULL,
  `team_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mailinglist_id` (`mailinglist_id`),
  KEY `team_id` (`team_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailinglistrule_teams`
--

LOCK TABLES `wb4_mailinglistrule_teams` WRITE;
/*!40000 ALTER TABLE `wb4_mailinglistrule_teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailinglistrule_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mailinglistrule_users`
--

DROP TABLE IF EXISTS `wb4_mailinglistrule_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailinglistrule_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mailinglist_id` int(10) unsigned NOT NULL,
  `action` enum('add','remove') DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mailinglist_id` (`mailinglist_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailinglistrule_users`
--

LOCK TABLES `wb4_mailinglistrule_users` WRITE;
/*!40000 ALTER TABLE `wb4_mailinglistrule_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailinglistrule_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mailinglistrules`
--

DROP TABLE IF EXISTS `wb4_mailinglistrules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailinglistrules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mailinglist_id` int(10) unsigned NOT NULL,
  `action` enum('add','remove') DEFAULT NULL,
  `crew_id` int(10) unsigned NOT NULL,
  `leader` int(11) DEFAULT '-1',
  `enable_moderator` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `mailinglist_id` (`mailinglist_id`),
  KEY `crew_id` (`crew_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1360 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailinglistrules`
--

LOCK TABLES `wb4_mailinglistrules` WRITE;
/*!40000 ALTER TABLE `wb4_mailinglistrules` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailinglistrules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mailinglists`
--

DROP TABLE IF EXISTS `wb4_mailinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailinglists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `address` varchar(64) NOT NULL,
  `synced` datetime DEFAULT NULL,
  `moderatorpassword` varchar(32) NOT NULL DEFAULT '',
  `crew_id` int(10) unsigned NOT NULL COMMENT 'contains the crew_id which have manage rights to this mailinglists',
  `optional` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `crew_id` (`crew_id`),
  KEY `address` (`address`)
) ENGINE=MyISAM AUTO_INCREMENT=285 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailinglists`
--

LOCK TABLES `wb4_mailinglists` WRITE;
/*!40000 ALTER TABLE `wb4_mailinglists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailinglists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mailinglistsecurityhacks`
--

DROP TABLE IF EXISTS `wb4_mailinglistsecurityhacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailinglistsecurityhacks` (
  `address` varchar(128) DEFAULT NULL,
  `mailinglist` varchar(36) DEFAULT NULL,
  `event_id` varchar(1) DEFAULT NULL,
  `event_reference` varchar(4) DEFAULT NULL,
  `realname` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailinglistsecurityhacks`
--

LOCK TABLES `wb4_mailinglistsecurityhacks` WRITE;
/*!40000 ALTER TABLE `wb4_mailinglistsecurityhacks` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailinglistsecurityhacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mailman_passwords`
--

DROP TABLE IF EXISTS `wb4_mailman_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mailman_passwords` (
  `mailinglist` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mailinglist`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mailman_passwords`
--

LOCK TABLES `wb4_mailman_passwords` WRITE;
/*!40000 ALTER TABLE `wb4_mailman_passwords` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mailman_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_mealtimes`
--

DROP TABLE IF EXISTS `wb4_mealtimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_mealtimes` (
  `user_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `mealtime` int(10) DEFAULT '0',
  PRIMARY KEY (`user_id`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_mealtimes`
--

LOCK TABLES `wb4_mealtimes` WRITE;
/*!40000 ALTER TABLE `wb4_mealtimes` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_mealtimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_menuitems`
--

DROP TABLE IF EXISTS `wb4_menuitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_menuitems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT '0',
  `event_id` int(10) unsigned DEFAULT '0',
  `requireevent` tinyint(1) DEFAULT '1',
  `name` varchar(50) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `position` int(10) unsigned DEFAULT '0',
  `hidden` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_menuitems`
--

LOCK TABLES `wb4_menuitems` WRITE;
/*!40000 ALTER TABLE `wb4_menuitems` DISABLE KEYS */;
INSERT INTO `wb4_menuitems` VALUES (1,106,0,1,'Din side','/Profile',1,0),(2,8,0,1,'Ditt crew','/Crew/View',1,0),(109,106,0,0,'Change event','/Event/change',98,0),(4,106,0,0,'Logg ut','/User/Logout',99,0),(7,35,0,1,'Crewopptak','/Enroll',1,0),(8,0,0,1,'Crew','/Crew',1,0),(9,35,0,1,'IRC-nøkler','/IrcChannelKeyAdmin',5,0),(10,35,0,1,'Bildesensur','/PictureApprove',8,0),(13,107,0,1,'Cola-tavler','/Scoreboard',8,1),(14,107,0,1,'Dispatch','/Dispatch',1,1),(15,107,0,1,'Tapt og Funnet','/LostFound',2,1),(17,107,0,1,'Nøkkelkort','/Keycard',4,1),(18,35,0,1,'Oppmøtetider','/ShowupTimes/moderate',4,0),(20,0,0,1,'Administrasjon','/Admin',4,0),(23,106,0,1,'Rediger profil','/Profile/Edit',2,0),(24,20,0,1,'Bli en annen bruker','/Admin/Sudo',7,1),(33,20,0,1,'Arrangement','/EventAdmin',1,0),(35,0,0,1,'Crewadministrasjon','/Crew/Edit',2,0),(36,106,0,1,'Brukerinfo','/UserPref',3,1),(50,35,0,1,'Carplates','/Carplates',12,1),(53,107,0,1,'Logistikk','/Logistic',3,0),(60,35,0,1,'Spørsmål i søknad','/ApplicationManager/Question',2,0),(61,35,0,1,'Velkomsthilsen','/ApplicationManager/Greeting',3,0),(105,8,0,1,'Liste','/Crew',2,0),(106,0,0,0,'nick','/Profile',5,0),(107,0,0,1,'Moduler','/',3,0),(108,35,0,1,'Clothing','/Clothing',11,1),(67,35,0,1,'Medisinske behov','/NeedsAdmin/medical',6,0),(68,35,0,1,'Matallergier','/NeedsAdmin/nutritional',7,0),(71,8,0,1,'Statistikk','/Crew/Statistics',3,1),(72,107,0,1,'Presse','/Press',5,1),(77,107,0,1,'SMS','/Sms',6,1),(85,20,0,1,'Endre menyen','/Admin/Menu',2,1),(87,8,0,1,'Crewbeskrivelser','/Crew/Description',4,0),(88,20,0,1,'Crewapplication','/ApplicationAdmin',5,0),(89,20,0,1,'Enroll','/EnrollAdmin',6,0),(90,20,0,1,'ACL','/Access',3,0),(94,20,0,1,'Checkin','/Checkin',8,1),(97,107,0,1,'Slideshow','/Sceneboard',7,1),(96,20,0,1,'Epostlister','/MailinglistAdmin',4,0),(98,35,0,1,'Ryddeliste','/Cleanup',10,1),(102,107,0,1,'Sovekart','/Sleeping',9,1),(104,35,0,1,'Ditt Crew','/Crew/Edit',0,0),(110,20,0,1,'CrewAdmin','/CrewAdmin',9,0),(111,20,0,1,'FrontNewsManager','/FrontNewsManager',10,0),(113,106,0,1,'mailinglsit','/MailingList',3,0),(114,106,0,1,'privacy','/Privacy',4,0),(115,106,0,1,'needs','/Needs/',5,0),(116,106,0,1,'Creweffectsorder','/CrewEffectsOrder',6,0),(117,20,0,1,'Creweffectsitems','/CrewEffectsItems',11,0),(118,35,0,1,'Creweffectsoverview','/CrewEffectsOrder/overview',13,0),(119,35,0,1,'picture rules','/PictureRule',9,0),(120,20,0,1,'tasks','/TaskAdmin',12,0),(121,106,0,1,'showup','/ShowupTimes',7,0),(122,107,0,1,'accreditation','/Accreditation',10,0),(123,35,0,1,'Mealtime','/Mealtime/view',14,0),(124,106,0,1,'Mealtime','/Mealtime',14,0),(125,106,0,1,'carplate','/Carplate',8,0),(126,35,0,1,'carplate','/CarplateAdmin',12,0),(127,107,0,1,'slideshow','/Slideshow',11,0),(128,107,0,1,'smsmessage','/SmsMessage',12,0),(143,107,0,1,'CleanupRegistration','/Cleanup',10,0),(130,107,0,1,'Lost and found','/LostAndFoundV2',5,0),(131,107,0,1,'Keycard handout','/KeycardHandout',13,0),(132,107,0,1,'Keycard cards','/KeycardCard',12,0),(133,107,0,1,'sleepingmap','/SleepingPlaces',63,0),(134,106,0,1,'Kandu Membership','/KanduMembership',5,0),(135,20,0,1,'terms','/TermAdmin',13,0),(142,20,0,1,'SmsBudsjetter','/SmsBudgetAdmin',16,0),(144,20,0,1,'CleanupAdmin','/Cleanup/Admin',17,0),(145,106,0,1,'CleanupTimes','/Cleanup/Times',20,0);
/*!40000 ALTER TABLE `wb4_menuitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_message_senders`
--

DROP TABLE IF EXISTS `wb4_message_senders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_message_senders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_message_senders`
--

LOCK TABLES `wb4_message_senders` WRITE;
/*!40000 ALTER TABLE `wb4_message_senders` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_message_senders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_messages`
--

DROP TABLE IF EXISTS `wb4_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `crew_id` int(10) unsigned DEFAULT NULL,
  `team_id` int(10) unsigned DEFAULT NULL,
  `message_sender_id` int(10) unsigned NOT NULL,
  `sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_messages`
--

LOCK TABLES `wb4_messages` WRITE;
/*!40000 ALTER TABLE `wb4_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_needs`
--

DROP TABLE IF EXISTS `wb4_needs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_needs` (
  `user_id` int(10) NOT NULL,
  `medicalneeds` text,
  `nutritionalneeds` text,
  `allergies` varchar(254) NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_needs`
--

LOCK TABLES `wb4_needs` WRITE;
/*!40000 ALTER TABLE `wb4_needs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_needs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_phonetypes`
--

DROP TABLE IF EXISTS `wb4_phonetypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_phonetypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_phonetypes`
--

LOCK TABLES `wb4_phonetypes` WRITE;
/*!40000 ALTER TABLE `wb4_phonetypes` DISABLE KEYS */;
INSERT INTO `wb4_phonetypes` VALUES (1,'Mobil'),(2,'Hjem'),(3,'Arbeid');
/*!40000 ALTER TABLE `wb4_phonetypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_picture_approval_statuses`
--

DROP TABLE IF EXISTS `wb4_picture_approval_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_picture_approval_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `picture_approval_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `fetched` datetime DEFAULT '0000-00-00 00:00:00',
  `printed` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_picture_approval_statuses`
--

LOCK TABLES `wb4_picture_approval_statuses` WRITE;
/*!40000 ALTER TABLE `wb4_picture_approval_statuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_picture_approval_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_picture_approvals`
--

DROP TABLE IF EXISTS `wb4_picture_approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_picture_approvals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned NOT NULL,
  `approved` tinyint(1) DEFAULT '0',
  `picture_rule_id` int(10) unsigned DEFAULT '0',
  `custom_denied_reason` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2044 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_picture_approvals`
--

LOCK TABLES `wb4_picture_approvals` WRITE;
/*!40000 ALTER TABLE `wb4_picture_approvals` DISABLE KEYS */;
INSERT INTO `wb4_picture_approvals` VALUES (1794,'2013-01-29 00:42:45',6389,0,0,NULL),(1795,'2013-01-29 00:48:00',6390,0,0,NULL),(1796,'2013-01-29 00:58:32',1,0,0,NULL),(1797,'2013-02-17 04:43:33',6391,0,0,NULL),(1798,'2013-02-22 10:42:31',1918,0,0,NULL),(2038,'2019-08-21 19:30:10',2193,0,0,NULL),(2039,'2019-08-21 19:30:10',4918,0,0,NULL),(2040,'2019-08-21 19:30:10',4304,0,0,NULL),(2041,'2019-08-21 19:30:10',6195,0,0,NULL),(2042,'2019-08-21 19:30:10',3073,0,0,NULL),(2043,'2019-08-21 19:30:10',4607,0,0,NULL);
/*!40000 ALTER TABLE `wb4_picture_approvals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_picture_rules`
--

DROP TABLE IF EXISTS `wb4_picture_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_picture_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rule_text` text,
  `denied_text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_picture_rules`
--

LOCK TABLES `wb4_picture_rules` WRITE;
/*!40000 ALTER TABLE `wb4_picture_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_picture_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_secure_files`
--

DROP TABLE IF EXISTS `wb4_secure_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_secure_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `expires` datetime DEFAULT '0000-00-00 00:00:00',
  `name` varchar(255) DEFAULT NULL,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_secure_files`
--

LOCK TABLES `wb4_secure_files` WRITE;
/*!40000 ALTER TABLE `wb4_secure_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_secure_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_showup_times`
--

DROP TABLE IF EXISTS `wb4_showup_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_showup_times` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `date` varchar(50) DEFAULT NULL,
  `hour` varchar(50) DEFAULT NULL,
  `comment` text,
  `approved` int(1) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=730 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_showup_times`
--

LOCK TABLES `wb4_showup_times` WRITE;
/*!40000 ALTER TABLE `wb4_showup_times` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_showup_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_sleeping_places`
--

DROP TABLE IF EXISTS `wb4_sleeping_places`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_sleeping_places` (
  `section` varchar(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_sleeping_places`
--

LOCK TABLES `wb4_sleeping_places` WRITE;
/*!40000 ALTER TABLE `wb4_sleeping_places` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_sleeping_places` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_slideshows`
--

DROP TABLE IF EXISTS `wb4_slideshows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_slideshows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `event_id` int(10) unsigned NOT NULL,
  `master` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_slideshows`
--

LOCK TABLES `wb4_slideshows` WRITE;
/*!40000 ALTER TABLE `wb4_slideshows` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_slideshows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_slideshows_slides`
--

DROP TABLE IF EXISTS `wb4_slideshows_slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_slideshows_slides` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `bg_url` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `duration` int(10) DEFAULT NULL,
  `show_id` int(10) unsigned NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_slideshows_slides`
--

LOCK TABLES `wb4_slideshows_slides` WRITE;
/*!40000 ALTER TABLE `wb4_slideshows_slides` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_slideshows_slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_sms_budgets`
--

DROP TABLE IF EXISTS `wb4_sms_budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_sms_budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_sent` int(11) DEFAULT NULL,
  `sms_limit` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_sms_budgets`
--

LOCK TABLES `wb4_sms_budgets` WRITE;
/*!40000 ALTER TABLE `wb4_sms_budgets` DISABLE KEYS */;
INSERT INTO `wb4_sms_budgets` VALUES (14,10,20,4304,18),(15,50,100,4918,18),(16,10,100,6195,18);
/*!40000 ALTER TABLE `wb4_sms_budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_sms_messages`
--

DROP TABLE IF EXISTS `wb4_sms_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_sms_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `message` text CHARACTER SET latin1,
  `sent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sent_by_id` int(10) NOT NULL DEFAULT '-1',
  `event_id` int(10) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8635 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_sms_messages`
--

LOCK TABLES `wb4_sms_messages` WRITE;
/*!40000 ALTER TABLE `wb4_sms_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_sms_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_tasks`
--

DROP TABLE IF EXISTS `wb4_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `message` text,
  `redirect` varchar(255) NOT NULL,
  `enabled` tinyint(1) DEFAULT '0',
  `event_id` int(10) unsigned NOT NULL,
  `allow_sub` tinyint(1) DEFAULT '0',
  `model` varchar(255) DEFAULT '',
  `condition` text,
  `complete_with_model` tinyint(1) DEFAULT NULL,
  `skip_button` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_tasks`
--

LOCK TABLES `wb4_tasks` WRITE;
/*!40000 ALTER TABLE `wb4_tasks` DISABLE KEYS */;
INSERT INTO `wb4_tasks` VALUES (1,'',NULL,'',0,16,0,'','',1,0),(2,'Creweffekter','Please fill in your size','/CrewEffectsOrder',1,16,0,'CrewEffectsOrder','App::import(\'Model\',\'CrewEffectsOrder\');\r\n$model = new CrewEffectsOrder();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(3,'Needs','Please fill in any needs you might have','/Needs',1,16,0,'Needs','',1,1),(4,'Oppmøte','Please set your showup time','/ShowupTimes',1,16,0,'ShowupTime','App::import(\'Model\',\'ShowupTime\');\r\n$model = new ShowupTime();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(5,'Oppmøte avslått','You showup time has been denied, please provide a new','/ShowupTimes',0,16,0,'ShowupTime','App::import(\'Model\',\'ShowupTime\');\r\n$model = new ShowupTime();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));\r\nif(empty($result)) {\r\n  $result = true;\r\n} else if(!empty($result) && $result[\'ShowupTime\'][\'approved\'] == 1) {\r\n  $result = null;\r\n}',1,0),(6,'Mattid','Please choose you meal time','/Mealtime',1,16,0,'Mealtime','App::import(\'Model\',\'Mealtime\');\r\n$model = new Mealtime();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(7,'KANDU-medlemskap','b','/KanduMembership',0,16,1,'KanduMembership','App::import(\'Model\',\'KanduMembership\');\r\n$model = new KanduMembership();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(8,'Creweffekter','Please fill in your size','/CrewEffectsOrder',0,17,0,'CrewEffectsOrder','App::import(\'Model\',\'CrewEffectsOrder\');\r\n$model = new CrewEffectsOrder();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(9,'Needs','Please fill in any needs you might have','/Needs',0,17,0,'Needs','',1,1),(10,'Oppmøte avslått','Please set your showup time','/ShowupTimes',0,17,0,'ShowupTime','App::import(\'Model\',\'ShowupTime\');\r\n$model = new ShowupTime();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(11,'Mattid','Please choose you meal time','/Mealtime',0,17,0,'Mealtime','App::import(\'Model\',\'Mealtime\');\r\n$model = new Mealtime();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0),(12,'KANDU-medlemskap','Choose your membership','/KanduMembership',0,17,1,'KanduMembership','App::import(\'Model\',\'KanduMembership\');\r\n$model = new KanduMembership();\r\n$result = $model->find(\'first\', array(\r\n  \'conditions\' => array(\r\n    \'event_id\' => WB::$event->id,\r\n    \'user_id\' => WB::$user[\'User\'][\'id\']\r\n  )\r\n));',0,0);
/*!40000 ALTER TABLE `wb4_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_teams`
--

DROP TABLE IF EXISTS `wb4_teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `crew_id` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `locked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=864 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_teams`
--

LOCK TABLES `wb4_teams` WRITE;
/*!40000 ALTER TABLE `wb4_teams` DISABLE KEYS */;
INSERT INTO `wb4_teams` VALUES (0,0,'NO',0);
/*!40000 ALTER TABLE `wb4_teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_terms`
--

DROP TABLE IF EXISTS `wb4_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` text,
  `version` varchar(50) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_terms`
--

LOCK TABLES `wb4_terms` WRITE;
/*!40000 ALTER TABLE `wb4_terms` DISABLE KEYS */;
INSERT INTO `wb4_terms` VALUES (2,17,'Terms','As a volunteering crew member, I acknowledge that requirements are set for myself and my efforts.\r\n\r\nThe organizer of The Gathering, KANDU, may freely use any and all work produced for The Gathering, for example developed systems, graphics, concepts and more.\r\n\r\nKANDU retains the right to use everything developed and produced by the crew member also after the member ends involvement in the organization. The product may also be further developed by The Gathering.\r\n\r\nThe crew member who produced and/or developed the product will nevertheless retain the right to further develop and/or sell the product after the involvement in the organization is ended.\r\n\r\nKANDU may not resell the product, but shall be free to use it as long as it is not used in a commercial context.','1.1','2012-12-01 21:29:58',1);
/*!40000 ALTER TABLE `wb4_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_user_mailprefs`
--

DROP TABLE IF EXISTS `wb4_user_mailprefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_user_mailprefs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `mailinglist_id` int(10) unsigned NOT NULL,
  `subscribe` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `USER_LIST` (`mailinglist_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5534 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_user_mailprefs`
--

LOCK TABLES `wb4_user_mailprefs` WRITE;
/*!40000 ALTER TABLE `wb4_user_mailprefs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_user_mailprefs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_user_privacies`
--

DROP TABLE IF EXISTS `wb4_user_privacies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_user_privacies` (
  `user_id` int(10) unsigned NOT NULL,
  `address` tinyint(1) DEFAULT '0',
  `email` tinyint(1) DEFAULT '0',
  `phone` tinyint(1) DEFAULT '0',
  `birth` tinyint(1) DEFAULT '0',
  `allow_crew` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_user_privacies`
--

LOCK TABLES `wb4_user_privacies` WRITE;
/*!40000 ALTER TABLE `wb4_user_privacies` DISABLE KEYS */;
INSERT INTO `wb4_user_privacies` VALUES (1,1,0,1,0,0),(2193,1,0,1,0,0),(4918,1,0,1,0,0),(4304,1,0,1,0,0),(6195,1,0,1,0,0),(1918,1,0,1,0,0),(3073,1,0,1,0,0),(4607,1,0,1,0,0);
/*!40000 ALTER TABLE `wb4_user_privacies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_user_profile_hashes`
--

DROP TABLE IF EXISTS `wb4_user_profile_hashes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_user_profile_hashes` (
  `user_id` int(10) unsigned NOT NULL,
  `hash` varchar(25) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_user_profile_hashes`
--

LOCK TABLES `wb4_user_profile_hashes` WRITE;
/*!40000 ALTER TABLE `wb4_user_profile_hashes` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_user_profile_hashes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_user_tasks`
--

DROP TABLE IF EXISTS `wb4_user_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_user_tasks` (
  `user_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `event_id` int(10) unsigned NOT NULL,
  UNIQUE KEY `task_id` (`task_id`,`user_id`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_user_tasks`
--

LOCK TABLES `wb4_user_tasks` WRITE;
/*!40000 ALTER TABLE `wb4_user_tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_user_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_user_terms`
--

DROP TABLE IF EXISTS `wb4_user_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_user_terms` (
  `user_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `terms_id` int(10) DEFAULT NULL,
  `accepted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `wb4_user_terms_user_id_terms_id_pk` (`user_id`,`terms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_user_terms`
--

LOCK TABLES `wb4_user_terms` WRITE;
/*!40000 ALTER TABLE `wb4_user_terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_user_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_userhistories`
--

DROP TABLE IF EXISTS `wb4_userhistories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_userhistories` (
  `user_id` int(10) unsigned NOT NULL,
  `eventname` varchar(64) NOT NULL DEFAULT '',
  `crewname` varchar(64) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`eventname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_userhistories`
--

LOCK TABLES `wb4_userhistories` WRITE;
/*!40000 ALTER TABLE `wb4_userhistories` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_userhistories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_userims`
--

DROP TABLE IF EXISTS `wb4_userims`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_userims` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `improtocol_id` int(10) unsigned NOT NULL,
  `address` varchar(128) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9707 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_userims`
--

LOCK TABLES `wb4_userims` WRITE;
/*!40000 ALTER TABLE `wb4_userims` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_userims` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_userphones`
--

DROP TABLE IF EXISTS `wb4_userphones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_userphones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `number` varchar(32) NOT NULL,
  `operator` varchar(20) NOT NULL,
  `phonetype_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `phonenumber` (`number`),
  KEY `phonenumber_id` (`number`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10648 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_userphones`
--

LOCK TABLES `wb4_userphones` WRITE;
/*!40000 ALTER TABLE `wb4_userphones` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_userphones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_users`
--

DROP TABLE IF EXISTS `wb4_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(128) NOT NULL,
  `realname` varchar(128) NOT NULL,
  `address` varchar(128) DEFAULT NULL,
  `postcode` varchar(16) DEFAULT NULL,
  `town` varchar(50) DEFAULT NULL,
  `countrycode` varchar(8) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `birth` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sexe` enum('undefined','male','female') DEFAULT 'undefined',
  `verified` datetime NOT NULL,
  `verificationcode` varchar(128) DEFAULT NULL,
  `nickname` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `resetpasswordcode` varchar(48) DEFAULT NULL,
  `lastactive` datetime DEFAULT NULL,
  `language` varchar(8) DEFAULT '',
  `registered` text,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6483 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_users`
--

LOCK TABLES `wb4_users` WRITE;
/*!40000 ALTER TABLE `wb4_users` DISABLE KEYS */;
INSERT INTO `wb4_users` VALUES (1,'dev','00b540c76dafa6dd46e4fab60826c3d7','Dev root','Bedringens vei 1','1920','SØRUMSAND','NO','root@localhost','1985-01-01 00:00:00','2013-01-29 00:45:03','2013-01-29 01:17:57','0000-00-00 00:00:00','male','2013-01-29 00:58:32','8fb9e87edb1d1f65f88d75f9128b7e0b','root',NULL,NULL,'2019-08-21 18:12:59','eng','done'),(1918,'existemi','35002b1c555ad3b0bb4af8e90d511294','Roy Viggo Larsen','Jernbanevegen 14','1920','SØRUMSAND','NO','roy@existemi.no','1985-11-03 00:00:00','2013-02-17 04:43:11','2013-02-17 04:50:51','0000-00-00 00:00:00','male','2013-02-17 04:43:33','26d478835a727e18216b5b995f9c0a11','existemi',NULL,NULL,NULL,'eng','done'),(2193,'Spacix','70352d0eca0385ee574dcfb232eb1e8c','Aleksander Grande','Simensbråtveien 25','1182','OSLO','NO','aleksandergrande@gmail.com','1983-09-25 00:00:00','2006-10-23 08:08:17','2012-01-26 12:17:34','0000-00-00 00:00:00','male','2006-10-23 08:08:42','1a3ea9de2663094681bc56b64dea7c52','Spacix',NULL,NULL,'2013-03-25 19:15:42','nob','done'),(3073,'Menelya','e45392a9d9f6db3657386d3d5e743840','Therese Hansen','Lindebergåsen 60 A','1068','OSLO','NO','tg@blowjob.no','1985-05-31 00:00:00','2006-10-23 12:12:10','2012-12-14 00:05:52','0000-00-00 00:00:00','female','2006-10-23 12:12:45','bbd4274feb0bbd38abe776976b8a718f','Menelya',NULL,NULL,'2013-03-25 19:13:22','nob','done'),(4304,'fictive','a54d33d925619b59877f23ca4bd9d65e','Espen Jacobsson','Stokkanhaugen 174','7048','TRONDHEIM','NO','espenjacobsson@gmail.com','1988-03-13 00:00:00','2008-01-28 15:01:06','2013-03-05 20:21:17','0000-00-00 00:00:00','male','2008-01-28 15:02:18','4f74576e1880089b49e227fdaadb6717','fictive',NULL,NULL,'2013-03-25 16:39:17','eng','done'),(4607,'evegard','05a4c8eb58ceaa1feb303a01795c3d6e','Vegard Edvardsen','Blestervegen 22','2618','Lillehammer','NO','vegard.edvardsen@gmail.com','1990-03-19 00:00:00','2008-11-19 19:50:50','2013-01-07 18:15:02','0000-00-00 00:00:00','male','2013-01-07 18:15:02','901fb2470f2884f9bb721c60adbaed33','evegard',NULL,NULL,'2013-03-25 15:40:25','nob','done'),(4918,'lizter','7f46a9a89ff6efcda5f34b56edf38240','Christian Strand Young','Eirik Jarls gate 6','7030','TRONDHEIM','NO','christian@strandyoung.com','1990-04-03 00:00:00','2009-04-14 00:46:51','2013-03-19 20:18:41','0000-00-00 00:00:00','male','2009-04-14 00:47:13','84d4edaf8c58f753075984b42d5269fc','lizter',NULL,NULL,'2013-03-25 19:08:17','nob','done'),(6195,'melwil','6da9c569e267242778608f2edc2a4a5b','Håvard Slettvold','Dalavegen 50','6856','SOGNDAL','NO','slettvold@gmail.com','1986-08-25 00:00:00','2012-11-06 21:14:11','2013-03-03 20:22:11','0000-00-00 00:00:00','male','2012-11-06 21:14:19','6045cd9335149c88a25d2a6e097281df','melwil',NULL,NULL,'2013-03-25 19:19:03','eng','done');
/*!40000 ALTER TABLE `wb4_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_vote_campaigns`
--

DROP TABLE IF EXISTS `wb4_vote_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_vote_campaigns` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `starts` datetime NOT NULL,
  `ends` datetime NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  `description` text,
  `passphrase` varchar(25) DEFAULT NULL,
  `short_desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_vote_campaigns`
--

LOCK TABLES `wb4_vote_campaigns` WRITE;
/*!40000 ALTER TABLE `wb4_vote_campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_vote_campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_vote_options`
--

DROP TABLE IF EXISTS `wb4_vote_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_vote_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  `description` text NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_vote_options`
--

LOCK TABLES `wb4_vote_options` WRITE;
/*!40000 ALTER TABLE `wb4_vote_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_vote_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_vote_votes`
--

DROP TABLE IF EXISTS `wb4_vote_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_vote_votes` (
  `campaign_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`campaign_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_vote_votes`
--

LOCK TABLES `wb4_vote_votes` WRITE;
/*!40000 ALTER TABLE `wb4_vote_votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_vote_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_wardrobe_card_borrowers`
--

DROP TABLE IF EXISTS `wb4_wardrobe_card_borrowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_wardrobe_card_borrowers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `seat` varchar(255) DEFAULT NULL,
  `row` varchar(255) DEFAULT NULL,
  `deposit` varchar(255) DEFAULT NULL,
  `wardrobe_card_id` int(10) unsigned NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `deposit_comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_wardrobe_card_borrowers`
--

LOCK TABLES `wb4_wardrobe_card_borrowers` WRITE;
/*!40000 ALTER TABLE `wb4_wardrobe_card_borrowers` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_wardrobe_card_borrowers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_wardrobe_cards`
--

DROP TABLE IF EXISTS `wb4_wardrobe_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_wardrobe_cards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `card` varchar(255) DEFAULT NULL,
  `wardrobe` varchar(255) DEFAULT NULL,
  `in_use` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_wardrobe_cards`
--

LOCK TABLES `wb4_wardrobe_cards` WRITE;
/*!40000 ALTER TABLE `wb4_wardrobe_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_wardrobe_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_wikipages`
--

DROP TABLE IF EXISTS `wb4_wikipages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_wikipages` (
  `title` varchar(255) NOT NULL,
  `revision` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `event_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`title`,`revision`),
  KEY `wikipages_ix` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_wikipages`
--

LOCK TABLES `wb4_wikipages` WRITE;
/*!40000 ALTER TABLE `wb4_wikipages` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_wikipages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wb4_wikirelations`
--

DROP TABLE IF EXISTS `wb4_wikirelations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wb4_wikirelations` (
  `wikipage_title` varchar(255) NOT NULL,
  `table` varchar(16) NOT NULL,
  `table_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wb4_wikirelations`
--

LOCK TABLES `wb4_wikirelations` WRITE;
/*!40000 ALTER TABLE `wb4_wikirelations` DISABLE KEYS */;
/*!40000 ALTER TABLE `wb4_wikirelations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `wb4_mailinglistaddress_crewnews`
--

/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistaddress_crewnews`*/;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistaddress_crewnews`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `wb4_mailinglistaddress_crewnews` AS (select distinct `u`.`realname` AS `realname`,`u`.`username` AS `username`,`u`.`email` AS `address`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference` from (`wb4_users` `u` join ((`wb4_mailinglists` `m` left join `wb4_mailinglistrule_crewnews` `mrcn` on((`m`.`id` = `mrcn`.`mailinglist_id`))) left join `wb4_events` `e` on((`e`.`id` = `m`.`event_id`)))) where ((`mrcn`.`mailinglist_id` is not null) and `u`.`id` in (select `cu`.`user_id` from (`wb4_crews_users` `cu` left join `wb4_userhistories` `uh` on((`cu`.`user_id` = `uh`.`user_id`))) where isnull(`uh`.`user_id`)) and `u`.`id` in (select `cu`.`user_id` from ((`wb4_events` `ev` left join `wb4_crews` `c` on((`ev`.`id` = `c`.`event_id`))) left join `wb4_crews_users` `cu` on((`c`.`id` = `cu`.`crew_id`))) where ((`cu`.`user_id` is not null) and (`ev`.`id` = `m`.`event_id`))))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `wb4_mailinglistaddresses`
--

/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistaddresses`*/;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistaddresses`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `wb4_mailinglistaddresses` AS (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrules` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`crew_id` = `uc`.`crew_id`) and (`mr`.`action` = 'add') and (`uc`.`leader` >= `mr`.`leader`) and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`) and (((`m`.`optional` = 1) and ((select `ui`.`subscribe` from `wb4_user_mailprefs` `ui` where ((`ui`.`user_id` = `u`.`id`) and (`ui`.`event_id` = `e`.`id`) and (`ui`.`mailinglist_id` = `m`.`id`)) limit 1) = 1)) or (`m`.`optional` <> 1)))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_teams` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`team_id` = `uc`.`team_id`) and (`mr`.`action` = 'add') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`) and (((`m`.`optional` = 1) and ((select `ui`.`subscribe` from `wb4_user_mailprefs` `ui` where ((`ui`.`user_id` = `u`.`id`) and (`ui`.`event_id` = `e`.`id`) and (`ui`.`mailinglist_id` = `m`.`id`) and (`ui`.`subscribe` = 1)) limit 1) = 1)) or (`m`.`optional` <> 1)))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_users` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`user_id` = `uc`.`user_id`) and (`mr`.`action` = 'add') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`) and (((`m`.`optional` = 1) and ((select `ui`.`subscribe` from `wb4_user_mailprefs` `ui` where ((`ui`.`user_id` = `u`.`id`) and (`ui`.`event_id` = `e`.`id`) and (`ui`.`mailinglist_id` = `m`.`id`) and (`ui`.`subscribe` = 1)) limit 1) = 1)) or (`m`.`optional` <> 1)))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `wb4_mailinglistaddresses_notopts`
--

/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistaddresses_notopts`*/;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistaddresses_notopts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `wb4_mailinglistaddresses_notopts` AS (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`id` AS `mailinglist_id`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname`,`m`.`optional` AS `optional` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrules` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`crew_id` = `uc`.`crew_id`) and (`mr`.`action` = 'add') and (`uc`.`leader` >= `mr`.`leader`) and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`id` AS `mailinglist_id`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname`,`m`.`optional` AS `optional` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_teams` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`team_id` = `uc`.`team_id`) and (`mr`.`action` = 'add') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`))) union (select distinct `u`.`email` AS `address`,`u`.`username` AS `username`,`m`.`address` AS `mailinglist`,`m`.`id` AS `mailinglist_id`,`m`.`event_id` AS `event_id`,`e`.`reference` AS `event_reference`,`u`.`realname` AS `realname`,`m`.`optional` AS `optional` from ((((`wb4_users` `u` join `wb4_crews_users` `uc`) join `wb4_mailinglistrule_users` `mr`) join `wb4_mailinglists` `m`) join `wb4_events` `e`) where ((`u`.`id` = `uc`.`user_id`) and (`mr`.`user_id` = `uc`.`user_id`) and (`mr`.`action` = 'add') and (`m`.`id` = `mr`.`mailinglist_id`) and (`e`.`id` = `m`.`event_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `wb4_mailinglistmoderators`
--

/*!50001 DROP TABLE IF EXISTS `wb4_mailinglistmoderators`*/;
/*!50001 DROP VIEW IF EXISTS `wb4_mailinglistmoderators`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`wannabe`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `wb4_mailinglistmoderators` AS (select distinct `u`.`email` AS `email`,`m`.`address` AS `mailinglist`,`m`.`moderatorpassword` AS `moderatorpassword` from (((`wb4_mailinglists` `m` join `wb4_users` `u`) join `wb4_crews_users` `uc`) join `wb4_mailinglistrules` `mrule`) where ((`uc`.`user_id` = `u`.`id`) and (`m`.`id` = `mrule`.`mailinglist_id`) and (`uc`.`crew_id` = `mrule`.`crew_id`) and (`uc`.`leader` >= `mrule`.`leader`) and (`mrule`.`enable_moderator` = 1))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-21 18:52:06
