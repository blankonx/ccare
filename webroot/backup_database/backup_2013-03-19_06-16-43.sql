-- MySQL dump 10.13  Distrib 5.1.33, for Win32 (ia32)
--
-- Host: localhost    Database: db_ccare
-- ------------------------------------------------------
-- Server version	5.1.33-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alergi`
--

DROP TABLE IF EXISTS `alergi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alergi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `family_folder` int(6) unsigned zerofill NOT NULL,
  `alergi` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `family_folder` (`family_folder`) USING BTREE,
  CONSTRAINT `alergi_ibfk_1` FOREIGN KEY (`family_folder`) REFERENCES `patients` (`family_folder`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alergi`
--

LOCK TABLES `alergi` WRITE;
/*!40000 ALTER TABLE `alergi` DISABLE KEYS */;
/*!40000 ALTER TABLE `alergi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anamnese_diagnoses`
--

DROP TABLE IF EXISTS `anamnese_diagnoses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anamnese_diagnoses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned DEFAULT NULL,
  `anamnese` varchar(255) NOT NULL DEFAULT '',
  `icd_code` varchar(5) DEFAULT NULL,
  `icd_name` varchar(255) NOT NULL DEFAULT '',
  `icd_id` int(11) unsigned DEFAULT NULL,
  `explanation` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `log` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `id_arsip` (`visit_id`),
  KEY `icd_id` (`icd_id`),
  CONSTRAINT `anamnese_diagnoses_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `anamnese_diagnoses_ibfk_2` FOREIGN KEY (`icd_id`) REFERENCES `ref_icds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anamnese_diagnoses`
--

LOCK TABLES `anamnese_diagnoses` WRITE;
/*!40000 ALTER TABLE `anamnese_diagnoses` DISABLE KEYS */;
INSERT INTO `anamnese_diagnoses` (`id`, `visit_id`, `anamnese`, `icd_code`, `icd_name`, `icd_id`, `explanation`, `date`, `log`) VALUES (13,1,'pusing, batuk','J00','Nasofaringitis akut [common cold]',3779,'balik lagi stlh 7 hari','2013-03-18 13:05:59','no'),(14,2,'pusing terus','I10','Hipertensi esensial (primer)',3443,'periksa ke spesialis','2013-03-18 13:18:45','no'),(15,3,'pusing, batuk','R05','Batuk',7367,'periksa dahak','2013-03-18 17:50:46','no'),(16,3,'','J00','Nasofaringitis akut [common cold]',3779,'','2013-03-18 17:50:46','no'),(17,3,'','R51','Sakit kepala (pusing)',7534,'','2013-03-18 17:50:46','no'),(18,4,'tak','Z00','Pemeriksaan dan penyelidikan umum pada orang-orang tanpa keluhan atau melaporkan diagnosis',9529,'ok','2013-03-19 04:25:30','no'),(19,6,'pusing, pilek','Z00','Pemeriksaan dan penyelidikan umum pada orang-orang tanpa keluhan atau melaporkan diagnosis',9529,'-','2013-03-19 04:57:15','no'),(20,7,'pusing, pilek','J05','Laringitis obstruktif akut [croup] dan epiglottitis',3800,'-','2013-03-19 05:02:14','no'),(21,8,'-','Z00','Pemeriksaan dan penyelidikan umum pada orang-orang tanpa keluhan atau melaporkan diagnosis',9529,'-','2013-03-19 05:04:14','no'),(22,9,'-','Z00','Pemeriksaan dan penyelidikan umum pada orang-orang tanpa keluhan atau melaporkan diagnosis',9529,'','2013-03-19 05:09:17','no'),(23,10,'-','A39.5','Penyakit jantung akibat meningokokus',195,'','2013-03-19 05:47:11','no');
/*!40000 ALTER TABLE `anamnese_diagnoses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `msg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chats`
--

LOCK TABLES `chats` WRITE;
/*!40000 ALTER TABLE `chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `session_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `session_data`) VALUES ('0456b85e7ce732a80d6f25f51475d45a','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64; rv:19.0) Gecko',1363638932,'a:4:{s:2:\"id\";s:1:\"1\";s:3:\"pwd\";s:32:\"ac43724f16e9241d990427ab7c8f4228\";s:4:\"name\";s:13:\"Administrator\";s:8:\"group_id\";s:1:\"1\";}'),('4a0c11052768775d8e2a19d86ebbdcb3','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64; rv:19.0) Gecko',1363648561,'a:5:{s:2:\"id\";s:1:\"1\";s:3:\"pwd\";s:32:\"ac43724f16e9241d990427ab7c8f4228\";s:4:\"name\";s:13:\"Administrator\";s:8:\"group_id\";s:1:\"1\";s:12:\"report_param\";a:13:{s:15:\"payment_type_id\";s:0:\"\";s:13:\"kelompok_umur\";s:0:\"\";s:3:\"sex\";s:0:\"\";s:4:\"unit\";s:3:\"day\";s:9:\"day_start\";s:2:\"18\";s:11:\"month_start\";s:1:\"3\";s:10:\"year_start\";s:4:\"2013\";s:7:\"day_end\";s:2:\"19\";s:9:\"month_end\";s:1:\"3\";s:8:\"year_end\";s:4:\"2013\";s:8:\"icd_code\";a:1:{i:0;s:0:\"\";}s:8:\"icd_name\";a:1:{i:0;s:0:\"\";}s:6:\"icd_id\";a:1:{i:0;s:0:\"\";}}}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clinic_modules`
--

DROP TABLE IF EXISTS `clinic_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clinic_modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `clinic_id` tinyint(3) unsigned zerofill NOT NULL,
  `module_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id` (`module_id`),
  KEY `clinic_id` (`clinic_id`),
  CONSTRAINT `clinic_modules_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `ref_modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clinic_modules_ibfk_3` FOREIGN KEY (`clinic_id`) REFERENCES `ref_clinics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinic_modules`
--

LOCK TABLES `clinic_modules` WRITE;
/*!40000 ALTER TABLE `clinic_modules` DISABLE KEYS */;
INSERT INTO `clinic_modules` (`id`, `clinic_id`, `module_id`) VALUES (1,001,1),(2,001,2),(3,001,3),(4,001,4),(5,002,1),(6,002,4),(8,053,4),(20,017,1),(21,017,2),(22,017,3),(23,017,4),(28,001,12),(29,006,13),(30,006,4),(34,009,1),(35,009,4),(36,052,24),(37,052,25),(38,057,26),(40,054,4),(66,007,1),(67,007,4),(68,003,1),(69,003,4),(70,053,12),(71,053,27),(72,053,28),(74,054,29),(75,056,30),(76,081,1),(77,081,4),(80,056,31),(82,058,1),(83,058,4),(84,058,12),(86,086,1),(87,086,4),(88,087,1),(89,087,4),(90,088,1),(115,185,1),(116,185,4),(122,188,1),(123,188,4),(138,196,1),(139,196,4),(140,182,4),(144,051,32),(145,055,31),(146,051,32),(147,197,1),(148,197,4);
/*!40000 ALTER TABLE `clinic_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examinations`
--

DROP TABLE IF EXISTS `examinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examinations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned DEFAULT NULL,
  `sistole` smallint(6) DEFAULT NULL,
  `diastole` smallint(6) DEFAULT NULL,
  `temperature` decimal(6,2) DEFAULT NULL,
  `pulse` tinyint(3) DEFAULT NULL,
  `physic_anamnese` text,
  `respiration` decimal(6,2) DEFAULT NULL,
  `weight` decimal(6,2) DEFAULT NULL,
  `height` decimal(6,2) DEFAULT NULL,
  `blood_type` char(2) DEFAULT NULL,
  `log` enum('yes','no') NOT NULL DEFAULT 'no',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `no_reg` (`visit_id`),
  CONSTRAINT `examinations_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examinations`
--

LOCK TABLES `examinations` WRITE;
/*!40000 ALTER TABLE `examinations` DISABLE KEYS */;
INSERT INTO `examinations` (`id`, `visit_id`, `sistole`, `diastole`, `temperature`, `pulse`, `physic_anamnese`, `respiration`, `weight`, `height`, `blood_type`, `log`, `date`) VALUES (12,1,120,90,'35.00',12,'TAK','12.00','65.00','176.00','B','no','2013-03-18 13:05:59'),(13,2,180,130,'34.00',12,'Ok','12.00','67.00','170.00','B','no','2013-03-18 13:18:45'),(14,3,130,100,'35.00',12,'OK','12.00','55.00','155.00','B','no','2013-03-18 17:50:46'),(15,4,120,90,'34.00',12,'Ok','12.00','55.00','155.00','B','no','2013-03-19 04:25:30'),(16,5,120,90,'34.00',12,'OK','12.00','23.00','100.00','B','no','2013-03-19 04:32:38'),(17,6,120,90,'34.00',12,'Ok','12.00','60.00','155.00','AB','no','2013-03-19 04:57:15'),(18,7,NULL,NULL,NULL,NULL,'OK',NULL,'60.00','157.00',NULL,'no','2013-03-19 05:02:14'),(19,8,120,90,NULL,NULL,NULL,NULL,'60.00','170.00',NULL,'no','2013-03-19 05:04:14'),(20,9,120,90,NULL,NULL,'ok',NULL,'66.00','176.00',NULL,'no','2013-03-19 05:09:17'),(21,10,120,90,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'no','2013-03-19 05:47:11');
/*!40000 ALTER TABLE `examinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expert_anamnese_diagnose_details`
--

DROP TABLE IF EXISTS `expert_anamnese_diagnose_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expert_anamnese_diagnose_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `expert_anamnese_diagnose_id` int(11) unsigned NOT NULL,
  `anamnese_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `anamnese_id` (`anamnese_id`),
  KEY `expert_anamnese_diagnose_id` (`expert_anamnese_diagnose_id`),
  CONSTRAINT `expert_anamnese_diagnose_details_ibfk_1` FOREIGN KEY (`anamnese_id`) REFERENCES `ref_anamneses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `expert_anamnese_diagnose_details_ibfk_2` FOREIGN KEY (`expert_anamnese_diagnose_id`) REFERENCES `expert_anamnese_diagnoses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expert_anamnese_diagnose_details`
--

LOCK TABLES `expert_anamnese_diagnose_details` WRITE;
/*!40000 ALTER TABLE `expert_anamnese_diagnose_details` DISABLE KEYS */;
INSERT INTO `expert_anamnese_diagnose_details` (`id`, `expert_anamnese_diagnose_id`, `anamnese_id`) VALUES (4,4,8),(5,5,9),(6,6,10),(7,7,11),(8,8,12),(9,9,13),(10,10,14),(11,11,15),(12,12,14),(13,13,16),(14,14,8),(15,15,8),(16,16,17),(17,17,17),(18,18,17);
/*!40000 ALTER TABLE `expert_anamnese_diagnose_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expert_anamnese_diagnoses`
--

DROP TABLE IF EXISTS `expert_anamnese_diagnoses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expert_anamnese_diagnoses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `icd_id` int(11) unsigned NOT NULL,
  `score` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `icd_id` (`icd_id`),
  CONSTRAINT `expert_anamnese_diagnoses_ibfk_1` FOREIGN KEY (`icd_id`) REFERENCES `ref_icds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expert_anamnese_diagnoses`
--

LOCK TABLES `expert_anamnese_diagnoses` WRITE;
/*!40000 ALTER TABLE `expert_anamnese_diagnoses` DISABLE KEYS */;
INSERT INTO `expert_anamnese_diagnoses` (`id`, `name`, `icd_id`, `score`) VALUES (1,'',3804,1),(2,'',9529,1),(3,'',9529,1),(4,'',3801,1),(5,'',5,1),(6,'',7530,1),(7,'',6,1),(8,'',3779,1),(9,'',9529,1),(10,'',3779,1),(11,'',3443,1),(12,'',7367,1),(13,'',9529,1),(14,'',9529,1),(15,'',3800,1),(16,'',9529,1),(17,'',9529,1),(18,'',195,1);
/*!40000 ALTER TABLE `expert_anamnese_diagnoses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_menu`
--

DROP TABLE IF EXISTS `group_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned NOT NULL,
  `menu_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `group_menu_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `ref_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `group_menu_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `ref_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7503 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_menu`
--

LOCK TABLES `group_menu` WRITE;
/*!40000 ALTER TABLE `group_menu` DISABLE KEYS */;
INSERT INTO `group_menu` (`id`, `group_id`, `menu_id`) VALUES (4349,14,87),(4354,14,86),(4355,14,112),(4532,10,87),(4533,10,1),(4534,10,2),(4538,10,5),(4540,10,7),(4543,10,66),(4550,10,53),(4552,10,57),(4553,10,58),(4555,10,92),(4556,10,127),(4557,10,126),(4562,10,86),(4563,10,112),(4564,4,87),(4565,4,1),(4569,4,5),(4571,4,7),(4574,4,66),(4581,4,53),(4583,4,57),(4584,4,58),(4586,4,92),(4587,4,127),(4588,4,126),(4593,4,86),(4594,4,112),(5181,13,87),(5186,13,98),(5187,13,139),(5188,13,142),(5189,13,146),(5190,13,5),(5192,13,7),(5195,13,66),(5202,13,53),(5204,13,57),(5205,13,58),(5207,13,92),(5208,13,127),(5209,13,126),(5213,13,117),(5214,13,114),(5215,13,118),(5216,13,86),(5217,13,112),(5218,11,87),(5223,11,107),(5224,11,105),(5229,11,98),(5230,11,139),(5231,11,142),(5232,11,146),(5233,11,86),(5234,11,112),(5264,9,87),(5265,9,1),(5266,9,2),(5268,9,143),(5270,9,5),(5272,9,7),(5275,9,66),(5282,9,53),(5284,9,57),(5285,9,58),(5287,9,92),(5288,9,127),(5289,9,126),(5293,9,86),(5294,9,112),(5295,15,87),(5300,15,98),(5301,15,139),(5302,15,142),(5303,15,146),(5308,15,5),(5310,15,7),(5313,15,66),(5320,15,53),(5322,15,57),(5323,15,58),(5325,15,92),(5326,15,127),(5327,15,126),(5331,15,86),(5332,15,112),(5417,12,87),(5421,12,5),(5423,12,7),(5426,12,66),(5432,12,53),(5434,12,57),(5435,12,58),(5437,12,92),(5439,12,86),(5440,12,112),(5842,22,87),(5843,22,5),(5845,22,7),(5848,22,66),(5855,22,53),(5857,22,57),(5858,22,58),(5860,22,92),(5861,22,127),(5862,22,126),(5866,22,86),(5867,22,112),(5903,24,87),(5905,24,107),(5906,24,105),(5909,24,98),(5910,24,139),(5911,24,142),(5912,24,146),(5917,24,5),(5919,24,7),(5922,24,66),(5929,24,53),(5931,24,57),(5932,24,58),(5934,24,92),(5935,24,127),(5936,24,126),(5940,24,8),(5941,24,11),(5942,24,125),(5943,24,72),(5945,24,74),(5947,24,10),(5955,24,17),(5956,24,86),(5957,24,112),(6665,25,87),(6666,25,1),(6667,25,2),(6669,25,143),(6677,25,107),(6678,25,105),(6681,25,98),(6682,25,139),(6683,25,142),(6684,25,146),(6685,25,158),(6686,25,5),(6688,25,153),(6691,25,7),(6694,25,66),(6700,25,162),(6701,25,166),(6703,25,53),(6705,25,57),(6706,25,58),(6708,25,92),(6709,25,127),(6710,25,126),(6729,25,8),(6730,25,125),(6731,25,72),(6733,25,74),(6735,25,10),(6740,25,78),(6741,25,13),(6743,25,138),(6744,25,145),(6745,25,117),(6746,25,114),(6747,25,118),(6751,25,80),(6752,25,15),(6753,25,16),(6757,25,17),(6758,25,108),(6759,25,109),(6763,25,86),(6764,25,112),(6765,25,168),(6766,26,87),(6767,26,1),(6768,26,2),(6770,26,143),(6778,26,107),(6779,26,105),(6782,26,98),(6783,26,139),(6784,26,142),(6785,26,146),(6786,26,158),(6791,26,5),(6793,26,153),(6796,26,7),(6799,26,66),(6805,26,162),(6806,26,166),(6808,26,53),(6810,26,57),(6811,26,58),(6813,26,92),(6814,26,127),(6815,26,126),(6834,26,8),(6835,26,125),(6836,26,86),(6837,26,112),(6838,26,168),(6881,3,87),(6882,3,1),(6883,3,2),(6890,3,5),(6892,3,153),(6895,3,7),(6898,3,66),(6904,3,162),(6905,3,166),(6907,3,53),(6909,3,57),(6910,3,58),(6912,3,92),(6913,3,127),(6914,3,126),(6931,3,86),(6932,3,112),(6933,3,168),(7429,1,87),(7430,1,1),(7431,1,2),(7432,1,170),(7433,1,171),(7434,1,172),(7435,1,173),(7436,1,5),(7437,1,153),(7438,1,7),(7439,1,66),(7440,1,162),(7441,1,166),(7442,1,53),(7443,1,57),(7444,1,58),(7445,1,92),(7446,1,127),(7447,1,126),(7448,1,169),(7449,1,8),(7450,1,11),(7451,1,125),(7452,1,72),(7453,1,74),(7454,1,10),(7455,1,78),(7456,1,13),(7457,1,138),(7458,1,145),(7459,1,117),(7460,1,114),(7461,1,118),(7462,1,80),(7463,1,15),(7464,1,16),(7465,1,17),(7466,1,108),(7467,1,109),(7468,1,111),(7469,1,86),(7470,1,112),(7471,1,168),(7472,2,87),(7473,2,1),(7474,2,2),(7475,2,5),(7476,2,153),(7477,2,7),(7478,2,66),(7479,2,162),(7480,2,166),(7481,2,53),(7482,2,57),(7483,2,58),(7484,2,92),(7485,2,127),(7486,2,126),(7487,2,169),(7488,2,8),(7489,2,125),(7490,2,108),(7491,2,109),(7492,2,86),(7493,2,112),(7494,2,168),(7495,1,174),(7496,1,175),(7497,1,176),(7498,1,177),(7500,1,179),(7501,1,180),(7502,1,181);
/*!40000 ALTER TABLE `group_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `classname` varchar(255) NOT NULL,
  `functionname` varchar(255) NOT NULL,
  `query` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_certificates`
--

DROP TABLE IF EXISTS `medical_certificates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_certificates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned NOT NULL,
  `doctor_id` int(11) unsigned zerofill NOT NULL,
  `no` varchar(100) DEFAULT NULL,
  `result` varchar(100) NOT NULL DEFAULT '',
  `medical_certificate_explanation_id` tinyint(3) unsigned zerofill DEFAULT NULL,
  `medical_certificate_explanation_other` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visit_id` (`visit_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `medical_certificates_ibfk_3` (`medical_certificate_explanation_id`),
  CONSTRAINT `medical_certificates_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medical_certificates_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `ref_paramedics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medical_certificates_ibfk_3` FOREIGN KEY (`medical_certificate_explanation_id`) REFERENCES `ref_medical_certificate_explanations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_certificates`
--

LOCK TABLES `medical_certificates` WRITE;
/*!40000 ALTER TABLE `medical_certificates` DISABLE KEYS */;
/*!40000 ALTER TABLE `medical_certificates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_latest_mr_number`
--

DROP TABLE IF EXISTS `patient_latest_mr_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient_latest_mr_number` (
  `id` int(6) unsigned zerofill NOT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_latest_mr_number`
--

LOCK TABLES `patient_latest_mr_number` WRITE;
/*!40000 ALTER TABLE `patient_latest_mr_number` DISABLE KEYS */;
INSERT INTO `patient_latest_mr_number` (`id`, `ip_address`) VALUES (000001,NULL);
/*!40000 ALTER TABLE `patient_latest_mr_number` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `family_folder` int(6) unsigned zerofill NOT NULL,
  `nik` char(30) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `sex` enum('Laki-laki','Perempuan') NOT NULL DEFAULT 'Laki-laki',
  `birth_place` varchar(100) NOT NULL DEFAULT '',
  `birth_date` date DEFAULT NULL,
  `address` varchar(100) NOT NULL DEFAULT '',
  `no_kontak` varchar(30) NOT NULL DEFAULT '',
  `job_id` tinyint(3) unsigned zerofill DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `marital_status_id` tinyint(3) unsigned DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  PRIMARY KEY (`family_folder`),
  KEY `job_id` (`job_id`),
  KEY `user_id` (`user_id`),
  KEY `family_folder` (`family_folder`),
  KEY `marital_status_id` (`marital_status_id`),
  CONSTRAINT `patients_ibfk_3` FOREIGN KEY (`job_id`) REFERENCES `ref_jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `patients_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `patients_ibfk_5` FOREIGN KEY (`marital_status_id`) REFERENCES `ref_marital_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` (`family_folder`, `nik`, `name`, `sex`, `birth_place`, `birth_date`, `address`, `no_kontak`, `job_id`, `user_id`, `marital_status_id`, `registration_date`) VALUES (000001,'3404565120810001','Harry','Laki-laki','Sleman','1980-08-23','Samimapan, Ct Depok, Sleman','081123423535',013,1,1,'2013-03-18'),(000002,'3404045654745745','Suhartini','Perempuan','Sleman','1955-12-25','Samimapan , Condong Catur ','081328181312',005,1,1,'2013-03-18'),(000003,'1412542346346346','Niken Larasati','Perempuan','Sleman','1987-01-04','Perum Dayu B5','0821421412412',012,1,1,'2013-03-19'),(000004,'2355262362623626','Teuku Restu','Laki-laki','Sleman','2011-10-09','Samimapan Ct Cc ','-',011,1,2,'2013-03-19'),(000005,'2385798235923959','Yunita','Perempuan','Bantul','1990-04-23','Bantul','045346346346',013,1,1,'2013-03-19');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned DEFAULT NULL,
  `cost_type_id` tinyint(3) unsigned zerofill NOT NULL,
  `treatment_id` int(11) unsigned DEFAULT NULL,
  `prescribe_id` bigint(20) unsigned DEFAULT NULL,
  `receipt_id` int(10) unsigned zerofill DEFAULT NULL,
  `payment_type_id` tinyint(3) unsigned zerofill DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'cost=jumlah yg harus dibayarkan',
  `discount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `pay` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'pay=jumlah yg dibayarkan',
  `paid` enum('yes','no') NOT NULL DEFAULT 'no' COMMENT 'paid=lunas:yes,no',
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cost_type_id` (`cost_type_id`),
  KEY `treatment_id` (`treatment_id`),
  KEY `prescribe_id` (`prescribe_id`),
  KEY `receipt_id` (`receipt_id`),
  KEY `user_id` (`user_id`),
  KEY `visit_id` (`visit_id`),
  KEY `payment_type_id` (`payment_type_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`cost_type_id`) REFERENCES `ref_cost_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`treatment_id`) REFERENCES `treatments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`prescribe_id`) REFERENCES `prescribes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payments_ibfk_4` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payments_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payments_ibfk_6` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `payments_ibfk_7` FOREIGN KEY (`payment_type_id`) REFERENCES `ref_payment_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='tabel pembayaran';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` (`id`, `visit_id`, `cost_type_id`, `treatment_id`, `prescribe_id`, `receipt_id`, `payment_type_id`, `name`, `cost`, `discount`, `pay`, `paid`, `user_id`) VALUES (1,2,002,10,NULL,NULL,002,'Surat Rujukan','15000.00','0.00','15000.00','yes',1),(2,2,002,11,NULL,NULL,002,'Konsultasi Dokter','45000.00','0.00','45000.00','yes',1),(3,3,002,12,NULL,NULL,004,'Konsultasi Dokter','45000.00','0.00','0.00','no',NULL),(4,3,002,13,NULL,NULL,004,'Surat Rujukan','15000.00','0.00','0.00','no',NULL),(5,4,002,14,NULL,NULL,002,'Konsultasi Dokter','45000.00','0.00','0.00','no',NULL),(6,5,002,15,NULL,NULL,001,'Konsultasi Dokter','45000.00','0.00','0.00','no',NULL),(7,6,002,16,NULL,NULL,002,'Konsultasi Dokter','50000.00','0.00','0.00','no',NULL),(8,7,002,17,NULL,NULL,001,'Surat Rujukan','15000.00','0.00','0.00','no',NULL),(9,8,002,18,NULL,NULL,001,'','0.00','0.00','0.00','no',NULL),(10,9,002,19,NULL,NULL,002,'','0.00','0.00','0.00','no',NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescribes`
--

DROP TABLE IF EXISTS `prescribes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescribes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned DEFAULT '0',
  `drug_id` int(11) unsigned NOT NULL,
  `drug_name` varchar(255) NOT NULL DEFAULT '',
  `mix_name` varchar(100) DEFAULT NULL,
  `dosis1` int(2) unsigned NOT NULL DEFAULT '0',
  `dosis2` decimal(3,2) unsigned NOT NULL DEFAULT '0.00',
  `days` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `qty` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `mix_qty` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `unit` varchar(100) NOT NULL DEFAULT '',
  `mix_unit` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL,
  `randomnumber` varchar(100) DEFAULT NULL,
  `log` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `id_pasien` (`visit_id`),
  KEY `drug_id` (`drug_id`),
  CONSTRAINT `prescribes_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prescribes_ibfk_2` FOREIGN KEY (`drug_id`) REFERENCES `ref_drugs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COMMENT='RESEP';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescribes`
--

LOCK TABLES `prescribes` WRITE;
/*!40000 ALTER TABLE `prescribes` DISABLE KEYS */;
INSERT INTO `prescribes` (`id`, `visit_id`, `drug_id`, `drug_name`, `mix_name`, `dosis1`, `dosis2`, `days`, `qty`, `mix_qty`, `cost`, `unit`, `mix_unit`, `date`, `randomnumber`, `log`) VALUES (11,1,31,'01031-Paracetamol tablet 500mg',NULL,3,'1.00',0,'10.00',NULL,'0.00','TABLET',NULL,'2013-03-18 13:05:59',NULL,'no'),(12,2,2,'01002-Amoksisillin sirup kering 125mg/5ml',NULL,3,'1.00',0,'15.00',NULL,'0.00','BOTOL',NULL,'2013-03-18 13:18:45',NULL,'no'),(13,3,62,'02015-Asam askorbat (vit c) tablet 50mg',NULL,3,'1.00',0,'15.00',NULL,'0.00','TABLET',NULL,'2013-03-18 17:50:46',NULL,'no'),(14,4,62,'02015-Asam askorbat (vit c) tablet 50mg',NULL,3,'1.00',0,'9.00',NULL,'0.00','TABLET',NULL,'2013-03-19 04:25:30',NULL,'no'),(15,5,62,'02015-Asam askorbat (vit c) tablet 50mg',NULL,3,'1.00',0,'9.00',NULL,'0.00','TABLET',NULL,'2013-03-19 04:32:38',NULL,'no'),(16,6,62,'02015-Asam askorbat (vit c) tablet 50mg',NULL,3,'1.00',0,'10.00',NULL,'0.00','TABLET',NULL,'2013-03-19 04:57:15',NULL,'no'),(17,7,62,'02015-Asam askorbat (vit c) tablet 50mg',NULL,3,'1.00',0,'10.00',NULL,'0.00','TABLET',NULL,'2013-03-19 05:02:14',NULL,'no'),(18,8,62,'',NULL,0,'0.00',0,'0.00',NULL,'0.00','',NULL,'2013-03-19 05:04:14',NULL,'no'),(19,9,62,'',NULL,0,'0.00',0,'0.00',NULL,'0.00','',NULL,'2013-03-19 05:09:17',NULL,'no');
/*!40000 ALTER TABLE `prescribes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabel kwitansi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts`
--

LOCK TABLES `receipts` WRITE;
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_anamneses`
--

DROP TABLE IF EXISTS `ref_anamneses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_anamneses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_anamneses`
--

LOCK TABLES `ref_anamneses` WRITE;
/*!40000 ALTER TABLE `ref_anamneses` DISABLE KEYS */;
INSERT INTO `ref_anamneses` (`id`, `name`) VALUES (17,'-'),(5,'BATUK, PILEK'),(3,'Demam 3 hari, Nafsu makan kurang'),(11,'demam 4 hari'),(9,'demam sangat tinggi sekali 3 hari'),(2,'Gigi cenut-cenut'),(12,'ihiiirrrrr....'),(13,'OK AJA TUCHH'),(15,'pusing terus'),(14,'pusing, batuk'),(1,'Pusing, demam, panas dingin'),(8,'pusing, pilek'),(10,'pusing, pilek, demam, batuk'),(16,'tak');
/*!40000 ALTER TABLE `ref_anamneses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_blood_pressure_formula`
--

DROP TABLE IF EXISTS `ref_blood_pressure_formula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_blood_pressure_formula` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `sistole_min` int(6) unsigned NOT NULL,
  `sistole_max` int(6) unsigned NOT NULL,
  `diastole_min` int(6) unsigned NOT NULL,
  `diastole_max` int(6) unsigned NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='sistole/diastole tidak pake koma';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_blood_pressure_formula`
--

LOCK TABLES `ref_blood_pressure_formula` WRITE;
/*!40000 ALTER TABLE `ref_blood_pressure_formula` DISABLE KEYS */;
INSERT INTO `ref_blood_pressure_formula` (`id`, `sistole_min`, `sistole_max`, `diastole_min`, `diastole_max`, `status`) VALUES (1,0,120,0,79,'Normal'),(2,120,139,80,89,'Pre-Hipertensi'),(3,140,159,90,99,'HT Stage I'),(4,160,1000000,100,1000000,'HT Stage II');
/*!40000 ALTER TABLE `ref_blood_pressure_formula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_continue`
--

DROP TABLE IF EXISTS `ref_continue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_continue` (
  `id` tinyint(2) unsigned zerofill NOT NULL,
  `name` varchar(100) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_continue`
--

LOCK TABLES `ref_continue` WRITE;
/*!40000 ALTER TABLE `ref_continue` DISABLE KEYS */;
INSERT INTO `ref_continue` (`id`, `name`, `active`) VALUES (01,'Rawat Jalan','yes'),(02,'Rawat Inap','yes'),(03,'Rujuk','yes');
/*!40000 ALTER TABLE `ref_continue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_cost_type`
--

DROP TABLE IF EXISTS `ref_cost_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_cost_type` (
  `id` tinyint(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='tabel jenis biaya';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_cost_type`
--

LOCK TABLES `ref_cost_type` WRITE;
/*!40000 ALTER TABLE `ref_cost_type` DISABLE KEYS */;
INSERT INTO `ref_cost_type` (`id`, `name`, `active`) VALUES (001,'Retribusi','yes'),(002,'Tindakan','yes'),(003,'Obat','yes'),(004,'Lain-lain','yes');
/*!40000 ALTER TABLE `ref_cost_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_drugs`
--

DROP TABLE IF EXISTS `ref_drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_drugs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) unsigned DEFAULT NULL,
  `category` enum('drug','bhp') DEFAULT 'drug',
  `code` varchar(5) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `unit` varchar(20) DEFAULT NULL,
  `supplier` varchar(255) NOT NULL DEFAULT '-',
  `expired_date` varchar(255) DEFAULT NULL,
  `unit_terbesar` varchar(255) DEFAULT NULL,
  `jml_per_unit_terbesar` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `ref_drugs_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `ref_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=622 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_drugs`
--

LOCK TABLES `ref_drugs` WRITE;
/*!40000 ALTER TABLE `ref_drugs` DISABLE KEYS */;
INSERT INTO `ref_drugs` (`id`, `supplier_id`, `category`, `code`, `name`, `unit`, `supplier`, `expired_date`, `unit_terbesar`, `jml_per_unit_terbesar`) VALUES (1,1,'drug','01001','Albendazol tablet 400 mg','TABLET','-',NULL,NULL,'0.00'),(2,1,'drug','01002','Amoksisillin sirup kering 125mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(3,1,'drug','01003','Amoksisillin kapsul 250mg','CAPSUL','-',NULL,NULL,'0.00'),(4,1,'drug','01004','Amoksisillin kaplet 500mg','TABLET','-',NULL,NULL,'0.00'),(5,1,'drug','01005','Ampisilin sirup kering 125 mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(6,1,'drug','01006','Ampisilin tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(7,1,'drug','01007','Besi sirup / Ferrosus sulfat syr','BOTOL','-',NULL,NULL,'0.00'),(8,1,'drug','01008','Deksametason injeksi 5mg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(9,1,'drug','01009','Diazepam injeksi 5mg/ml-2ml','AMPUL','-',NULL,NULL,'0.00'),(10,1,'drug','01010','Difenhidramin HCL inj10mg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(11,1,'drug','01011','Epinefrina HCL/Bitartrat(adrenalin)inj01%','AMPUL','-',NULL,NULL,'0.00'),(12,1,'drug','01012','Garam oralit untuk 200ml air','SASE','-',NULL,NULL,'0.00'),(13,1,'drug','01013','Glucosa larutan infus 5% steril','BOTOL','-',NULL,NULL,'0.00'),(14,1,'drug','01014','Glucosa larutan infus10% steril','BOTOL','-',NULL,NULL,'0.00'),(15,1,'drug','01015','Glucosa larutan infus 40% steril','BOTOL','-',NULL,NULL,'0.00'),(16,1,'drug','01016','Insulin reguler','AMPUL','-',NULL,NULL,'0.00'),(17,1,'drug','01017','Iodiol kapsul lunak','CAPSUL','-',NULL,NULL,'0.00'),(18,1,'drug','01018','Ketamin injeksi 10mg/ml','AMPUL','-',NULL,NULL,'0.00'),(19,1,'drug','01019','Kloramfenikol kapsul 250mg','CAPSUL','-',NULL,NULL,'0.00'),(20,1,'drug','01020','Klorokuin tablet 150mg','TABLET','-',NULL,NULL,'0.00'),(21,1,'drug','01021','Kodein fosfat tablet 10mg','TABLET','-',NULL,NULL,'0.00'),(22,1,'drug','01022','Sulfadoxin 500+pirimetamin25mg tablet','TABLET','-',NULL,NULL,'0.00'),(23,1,'drug','01023','Kotrimoksazol Sirup / Primadex Sirup','BOTOL','-',NULL,NULL,'0.00'),(24,1,'drug','01024','Kotrimoksazol tablet dewasa 480mg','TABLET','-',NULL,NULL,'0.00'),(25,1,'drug','01025','Kotrimoksazol tablet pediatrik 120mg','TABLET','-',NULL,NULL,'0.00'),(26,1,'drug','01026','Kuinin (kina)tablet 200mg','TABLET','-',NULL,NULL,'0.00'),(27,1,'drug','01027','Kuinin dihidroklorida injeksi 25%-2ml','AMPUL','-',NULL,NULL,'0.00'),(28,1,'drug','01028','Lidokain komp injeksi 2ml','AMPUL','-',NULL,NULL,'0.00'),(29,1,'drug','01029','Natrium klorida larutan infus 0.9% steril','BOTOL','-',NULL,NULL,'0.00'),(30,1,'drug','01030','Oksitosin injeksi 10ui/ml-1ml (Pitogin inj)','AMPUL','-',NULL,NULL,'0.00'),(31,1,'drug','01031','Paracetamol tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(32,1,'drug','01032','Petidin HCL injeksi 50mg/ml-2ml','AMPUL','-',NULL,NULL,'0.00'),(33,1,'drug','01033','Pirantel tablet 125','TABLET','-',NULL,NULL,'0.00'),(34,1,'drug','01034','Prazikuantel tablet 600mg','TABLET','-',NULL,NULL,'0.00'),(35,1,'drug','01035','Prednisone tablet','TABLET','-',NULL,NULL,'0.00'),(36,1,'drug','01036','Primakuin tablet 15mg','TABLET','-',NULL,NULL,'0.00'),(37,1,'drug','01037','Rabies immune globulin(human)150iu/ml','AMPUL','-',NULL,NULL,'0.00'),(38,1,'drug','01038','Ringer laktat larutan infus steril','BOTOL','-',NULL,NULL,'0.00'),(39,1,'drug','01039','Serum anti bisa ular polivalen INJ 5ml( ABU)','AMPUL','-',NULL,NULL,'0.00'),(40,1,'drug','01040','Serum anti bisa ular polivalen inj 50ml( ABU)','AMPUL','-',NULL,NULL,'0.00'),(41,1,'drug','01041','Serum anti difteri injeksi 20 000 iu/vial(ADS)','VIAL','-',NULL,NULL,'0.00'),(42,1,'drug','01042','Serum anti tetanus inj 1 500 ui/amp(ATS)','AMPUL','-',NULL,NULL,'0.00'),(43,1,'drug','01043','Serum anti tetanus injeksi 20 000 ui/amp(ATS)','VIAL','-',NULL,NULL,'0.00'),(44,1,'drug','01044','Suspensi seng insulin inj 40 ui/ml-10ml(human)','AMPUL','-',NULL,NULL,'0.00'),(45,1,'drug','01045','Tiopental Natrium serb inj 1000 mg/amp','AMPUL','-',NULL,NULL,'0.00'),(46,1,'drug','01046','Vaksin rabies vero','AMPUL','-',NULL,NULL,'0.00'),(47,1,'drug','01047','Bekarbon tablet','TABLET','-',NULL,NULL,'0.00'),(48,1,'drug','02001','Alopurinol tablet 100 mg','TABLET','-',NULL,NULL,'0.00'),(49,1,'drug','02002','Aminofilin tablet 200mg','TABLET','-',NULL,NULL,'0.00'),(50,1,'drug','02003','Aminofilin injeksi 24mg/ml-10ml','AMPUL','-',NULL,NULL,'0.00'),(51,1,'drug','02004','Amittriptilin HCL tablet salut 25mg','TABLET','-',NULL,NULL,'0.00'),(52,1,'drug','02005','Antalgin injeksi 250mg/ml-2ml','AMPUL','-',NULL,NULL,'0.00'),(53,1,'drug','02006','Antalgin (Metampiron)tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(54,1,'drug','02007','Antasida DOEN tablet','TABLET','-',NULL,NULL,'0.00'),(55,1,'drug','02008','Bacitracin salep komb antibakteri','TUBE','-',NULL,NULL,'0.00'),(56,1,'drug','02009','Anti hemoroid DOEN kombinasi','SUPP','-',NULL,NULL,'0.00'),(57,1,'drug','02010','Antifungi Doen komb+AsBenzoat+Ass','POT','-',NULL,NULL,'0.00'),(58,1,'drug','02011','Antimigren tartrat 1 mg + kofein 50mg','TABLET','-',NULL,NULL,'0.00'),(59,1,'drug','02012','Antiparkinson DOEN tab komb karbidopa','TABLET','-',NULL,NULL,'0.00'),(60,1,'drug','02013','Aqua pro inj steril bebas pirogen 20 ML','VIAL','-',NULL,NULL,'0.00'),(61,1,'drug','02014','Aquades streril 500 ML','BOTOL','-',NULL,NULL,'0.00'),(62,1,'drug','02015','Asam askorbat (vit c) tablet 50mg','TABLET','-',NULL,NULL,'0.00'),(63,1,'drug','02016','Asam askorbat (vit c) tablet 250mg','TABLET','-',NULL,NULL,'0.00'),(64,1,'drug','02017','Asam klorida 0.1 N 100 ml','BOTOL','-',NULL,NULL,'0.00'),(65,1,'drug','02018','Asam sulfosalisilat 20%','BOTOL','-',NULL,NULL,'0.00'),(66,1,'drug','02019','Asetosal tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(67,1,'drug','02020','Asetosal tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(68,1,'drug','02021','Atropin sulfat tablet 0.5mg','TABLET','-',NULL,NULL,'0.00'),(69,1,'drug','02022','Atropin sulfat tetes mata 0.5%','BOTOL','-',NULL,NULL,'0.00'),(70,1,'drug','02023','Atropin sulfat injeksi 0.25mg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(71,1,'drug','02024','Betametason krim 0.1%','TUBE','-',NULL,NULL,'0.00'),(72,1,'drug','02025','Deksametason tablet 0.5mg','TABLET','-',NULL,NULL,'0.00'),(73,1,'drug','02026','Dekstran 70-larutan infus 6% steril','BOTOL','-',NULL,NULL,'0.00'),(74,1,'drug','02027','Dektrometorfan sirup 10mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(75,1,'drug','02028','Dektrometorfan tablet 15mg','TABLET','-',NULL,NULL,'0.00'),(76,1,'drug','02029','Diazepam tablet 2mg','TABLET','-',NULL,NULL,'0.00'),(77,1,'drug','02030','Diazepam tablet 5mg','TABLET','-',NULL,NULL,'0.00'),(78,1,'drug','02031','Digoksin tablet 0.25mg','TABLET','-',NULL,NULL,'0.00'),(79,1,'drug','02032','Efedrin HCL tablet 25mg','TABLET','-',NULL,NULL,'0.00'),(80,1,'drug','02033','Ekstrak belladon tablet 10mg','TABLET','-',NULL,NULL,'0.00'),(81,1,'drug','02034','Fenitoin natrium injeksi 50mg/ml','AMPUL','-',NULL,NULL,'0.00'),(82,1,'drug','02035','Fenitoin natrium kapsul 30mg','CAPSUL','-',NULL,NULL,'0.00'),(83,1,'drug','02036','Fenitoin natrium kapsul 100mg','CAPSUL','-',NULL,NULL,'0.00'),(84,1,'drug','02037','Fenobarbital injeksi 50mg/ml-2ml','AMPUL','-',NULL,NULL,'0.00'),(85,1,'drug','02038','Fenobarbital tablet 30mg','TABLET','-',NULL,NULL,'0.00'),(86,1,'drug','02039','Fenobarbital tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(87,1,'drug','02040','Fenoksimetil penisilina tablet 250mg','TABLET','-',NULL,NULL,'0.00'),(88,1,'drug','02041','Fenoksimetil penisilina tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(89,1,'drug','02042','Fenol gliserol tts telinga 10% / Carbo glicerin','BOTOL','-',NULL,NULL,'0.00'),(90,1,'drug','02043','Fitomenadion (vit k ) injeksi 10mg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(91,1,'drug','02044','Fitomenadion (vit k ) tablet 10mg','TABLET','-',NULL,NULL,'0.00'),(92,1,'drug','02045','Furosemid tablet 40mg','TABLET','-',NULL,NULL,'0.00'),(93,1,'drug','02046','Gameksan emulsi  1 %','BOTOL','-',NULL,NULL,'0.00'),(94,1,'drug','02047','Gentian violet larutan 1%','BOTOL','-',NULL,NULL,'0.00'),(95,1,'drug','02048','Glibenclamid tablet 5mg','TABLET','-',NULL,NULL,'0.00'),(96,1,'drug','02049','Gliseril guayakolat tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(97,1,'drug','02051','Gliserin','BOTOL','-',NULL,NULL,'0.00'),(98,1,'drug','02052','Griseofulvin tablet 125mg micronized','TABLET','-',NULL,NULL,'0.00'),(99,1,'drug','02053','Haloperidol tablet 0.5mg','TABLET','-',NULL,NULL,'0.00'),(100,1,'drug','02054','Haloperidol tablet 1.5mg','TABLET','-',NULL,NULL,'0.00'),(101,1,'drug','02055','Hidroklorotiazid (HCT) tablet 25mg','TABLET','-',NULL,NULL,'0.00'),(102,1,'drug','02056','Hidrokortison krim 2.5%','TUBE','-',NULL,NULL,'0.00'),(103,1,'drug','02057','Ibuprofen tablet 200mg','TABLET','-',NULL,NULL,'0.00'),(104,1,'drug','02058','Ibuprofen tablet 400mg','TABLET','-',NULL,NULL,'0.00'),(105,1,'drug','02059','Ipeka sirup 0.14%','BOTOL','-',NULL,NULL,'0.00'),(106,1,'drug','02060','Isosorbid dinitrat tablet sublingual 5mg','TABLET','-',NULL,NULL,'0.00'),(107,1,'drug','02061','Kalium permaganat serbuk 5 GR','POT','-',NULL,NULL,'0.00'),(108,1,'drug','02062','Kalsium laktat (kalk) tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(109,1,'drug','02063','Karbamazepin tablet 200mg','TABLET','-',NULL,NULL,'0.00'),(110,1,'drug','02064','Klofazimin kapsul 100mg micronize','CAPSUL','-',NULL,NULL,'0.00'),(111,1,'drug','02065','Kloramfenicol salep mata 1%','TUBE','-',NULL,NULL,'0.00'),(112,1,'drug','02066','Kloramfenicol tetes telinga 3%','BOTOL','-',NULL,NULL,'0.00'),(113,1,'drug','02067','Klorfeniramin maleat (CTM) tablet 4mg','TABLET','-',NULL,NULL,'0.00'),(114,1,'drug','02068','Klorpromazin HCL injeksi 5mg/ml-2ml','AMPUL','-',NULL,NULL,'0.00'),(115,1,'drug','02069','Klorpromazin HCL injeksi 25mg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(116,1,'drug','02070','Klorpromazin HCL 25mg tablet salut','TABLET','-',NULL,NULL,'0.00'),(117,1,'drug','02071','Klorpromazin HCL 100mg tablet salut','TABLET','-',NULL,NULL,'0.00'),(118,1,'drug','02072','Klorpropamid tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(119,1,'drug','02073','Magnesium sulfat injeksi (iv)20%-25ml','AMPUL','-',NULL,NULL,'0.00'),(120,1,'drug','02074','Magnesium sulfat injeksi (iv)40%-25ml','AMPUL','-',NULL,NULL,'0.00'),(121,1,'drug','02075','Magnesium sulfat serbuk 30 gram','POT','-',NULL,NULL,'0.00'),(122,1,'drug','02076','Mebendazole sirup 100mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(123,1,'drug','02077','Mebendazole tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(124,1,'drug','02078','Metilergometrin maleat inj 0.200mg/1ml','AMPUL','-',NULL,NULL,'0.00'),(125,1,'drug','02079','Metilergometrin maleat tablet salut 0.125mgl','TABLET','-',NULL,NULL,'0.00'),(126,1,'drug','02080','Metronidazol tablet 250mg','TABLET','-',NULL,NULL,'0.00'),(127,1,'drug','02081','Natrium bikarbonat tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(128,1,'drug','02082','Natrium fluoresin tetes mata 2%','BOTOL','-',NULL,NULL,'0.00'),(129,1,'drug','02083','Natrium tiosulfat injeksi 25%/10ml','AMPUL','-',NULL,NULL,'0.00'),(130,1,'drug','02084','Nistatin tablet vaginal 100.000iu/g','SUPP','-',NULL,NULL,'0.00'),(131,1,'drug','02085','Nistatin tablet salut 500.000IU','TABLET','-',NULL,NULL,'0.00'),(132,1,'drug','02086','Obat batuk hitam (OBH) cairan','BOTOL','-',NULL,NULL,'0.00'),(133,1,'drug','02087','Oksitetrasiklin HCL salep mata 1%','TUBE','-',NULL,NULL,'0.00'),(134,1,'drug','02088','Oksitetrasiklin HCL injeksi (im)50mg/ml-10ml','VIAL','-',NULL,NULL,'0.00'),(135,1,'drug','02089','Oksitetrasiklin HCL salep 3%','TUBE','-',NULL,NULL,'0.00'),(136,1,'drug','02090','Paraformaldehid tablet 1 gram','TABLET','-',NULL,NULL,'0.00'),(137,1,'drug','02091','Parasetamol sirup 120mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(138,1,'drug','02092','Parasetamol tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(139,1,'drug','02093','Perfenazin HCL tablet 4mg','TABLET','-',NULL,NULL,'0.00'),(140,1,'drug','02094','Perfenazin HCL tablet 16mg','TABLET','-',NULL,NULL,'0.00'),(141,1,'drug','02095','Pilokarpin HCL/nitrat tetes mata 2%','BOTOL','-',NULL,NULL,'0.00'),(142,1,'drug','02096','Piridoksin HCL (vit B6) tablet 10mg','TABLET','-',NULL,NULL,'0.00'),(143,1,'drug','02097','Polikresulen/Albotil concetrate 10ml','BOTOL','-',NULL,NULL,'0.00'),(144,1,'drug','02098','Polipeptida Kombinasi DOEN lart infus steril','BOTOL','-',NULL,NULL,'0.00'),(145,1,'drug','02099','Propiltiourasil tablet 100mg','TABLET','-',NULL,NULL,'0.00'),(146,1,'drug','02100','Propranolol HCL 40mg tablet','TABLET','-',NULL,NULL,'0.00'),(147,1,'drug','02101','Reserpin tablet 0.10mg','TABLET','-',NULL,NULL,'0.00'),(148,1,'drug','02102','Reserpin tablet 0.25mg','TABLET','-',NULL,NULL,'0.00'),(149,1,'drug','02103','Salbutamol tablet 2mg','TABLET','-',NULL,NULL,'0.00'),(150,1,'drug','02104','Salep 2-4 komb as salisilat+as belerang endapan','POT','-',NULL,NULL,'0.00'),(151,1,'drug','02105','Salisil bedak 2%  50 Gram','KOTAK','-',NULL,NULL,'0.00'),(152,1,'drug','02106','Salisil spiritus 10%','BOTOL','-',NULL,NULL,'0.00'),(153,1,'drug','02107','Sianokobalamin (vit B12) inj 500mcg/ml-1','AMPUL','-',NULL,NULL,'0.00'),(154,1,'drug','02108','Sulfadimidin tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(155,1,'drug','02109','Sulfasetamida natrium tetes mata 15%','BOTOL','-',NULL,NULL,'0.00'),(156,1,'drug','02110','Tetrakain HCL tetes mata 0.5%','BOTOL','-',NULL,NULL,'0.00'),(157,1,'drug','02111','Tetrasiklin HCL kapsul 250mg','CAPSUL','-',NULL,NULL,'0.00'),(158,1,'drug','02112','Tetrasiklin HCL kapsul 500mg','CAPSUL','-',NULL,NULL,'0.00'),(159,1,'drug','02113','Tiamin HCL inj 100mg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(160,1,'drug','02114','Tiamin Hc L  mononitrat (vit B1) tablet 50mg','TABLET','-',NULL,NULL,'0.00'),(161,1,'drug','02115','Triheksifenidil hidroklorida tablet 2mg','TABLET','-',NULL,NULL,'0.00'),(162,1,'drug','02116','Vitamin B complex tablet','TABLET','-',NULL,NULL,'0.00'),(163,1,'drug','02117','Obat anti tuberculosa kategori I dewasa','PAKET','-',NULL,NULL,'0.00'),(164,1,'drug','02118','Obat anti tuberculosa kategori II dewasa','PAKET','-',NULL,NULL,'0.00'),(165,1,'drug','02119','Obat anti tuberculosa kategori III dewasa','PAKET','-',NULL,NULL,'0.00'),(166,1,'drug','02120','Obat anti tuberculosa sisipan dewasa','PAKET','-',NULL,NULL,'0.00'),(167,1,'drug','02121','Obat anti tuberculosa katagori anak','PAKET','-',NULL,NULL,'0.00'),(168,1,'drug','02122','Tri Sulfa tab','TABLET','-',NULL,NULL,'0.00'),(169,1,'drug','02123','Aquades Steril 1000 ML','BOTOL','-',NULL,NULL,'0.00'),(170,1,'drug','02124','Decatona 100mg Capsul','CAPSUL','-',NULL,NULL,'0.00'),(171,1,'drug','02125','Decatona 30 mg Capsul','CAPSUL','-',NULL,NULL,'0.00'),(172,1,'drug','02126','Asam Klorida 0,1 N 1000 ml','BOTOL','-',NULL,NULL,'0.00'),(173,1,'drug','02127','Sianokobalamin ( vit,12 ) ijn 1000 mcg/ml-1ml','AMPUL','-',NULL,NULL,'0.00'),(174,1,'drug','02128','Betahistin Mesilat 6 mg','TABLET','-',NULL,NULL,'0.00'),(175,1,'drug','02129','Bisoprolol tablet 5 mg','TABLET','-',NULL,NULL,'0.00'),(176,1,'drug','02130','Cetirizine tablet 10 mg','TABLET','-',NULL,NULL,'0.00'),(177,1,'drug','02131','Domperidon tablet 10 mg','TABLET','-',NULL,NULL,'0.00'),(178,1,'drug','02132','Klindamisin kapsul 150 mg','CAPSUL','-',NULL,NULL,'0.00'),(179,1,'drug','02133','Meloksikam tablet 7,5 mg','TABLET','-',NULL,NULL,'0.00'),(180,1,'drug','02134','Metilprednisolon tablet 4 mg','TABLET','-',NULL,NULL,'0.00'),(181,1,'drug','02135','Piracetam tablet 800 mg','TABLET','-',NULL,NULL,'0.00'),(182,1,'drug','02136','Tramadol tablet 50 mg','TABLET','-',NULL,NULL,'0.00'),(183,1,'drug','02137','Sefadroxil Syr kering 125 mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(184,1,'drug','02138','Sefiksim Syr kering 100mg/5ml','BOTOL','-',NULL,NULL,'0.00'),(185,1,'drug','02139','Kalium diklofenak  25 mg','TABLET','-',NULL,NULL,'0.00'),(186,1,'drug','02140','Propanolol tablet 10 mg','TABLET','-',NULL,NULL,'0.00'),(187,1,'drug','02141','Sefiksim kapsul 100 mg','CAPSUL','-',NULL,NULL,'0.00'),(188,1,'drug','02142','Domperidon suspensi 5 mg/5 ml','BOTOL','-',NULL,NULL,'0.00'),(189,1,'drug','02143','Alopurinol tablet 300 mg','TABLET','-',NULL,NULL,'0.00'),(190,1,'drug','02144','Hidrokortison krim 1%','TUBE','-',NULL,NULL,'0.00'),(191,1,'drug','02145','Alprazolam tablet 0,25 mg (Alganax)','TABLET','-',NULL,NULL,'0.00'),(192,1,'drug','02146','Alprazolam tablet 0,5 mg','TABLET','-',NULL,NULL,'0.00'),(193,1,'drug','02147','Metformin HCl tablet 500 mg','TABLET','-',NULL,NULL,'0.00'),(194,1,'drug','02148','Salbutamol tablet 4 mg','TABLET','-',NULL,NULL,'0.00'),(195,1,'drug','02149','Klindamicin capsul 300 mg','CAPSUL','-',NULL,NULL,'0.00'),(196,1,'drug','03001','Air raksa dental use','BOTOL','-',NULL,NULL,'0.00'),(197,1,'drug','03002','Alkahner /Dentorit/Cavit/CAVITON','POT','-',NULL,NULL,'0.00'),(198,1,'drug','03003','Devitalisasi pasta (non arsen)/Devitasol F','POT','-',NULL,NULL,'0.00'),(199,1,'drug','03004','Etil klorida semprot','BOTOL','-',NULL,NULL,'0.00'),(200,1,'drug','03005','Eugenol cairan','BOTOL','-',NULL,NULL,'0.00'),(201,1,'drug','03006','Flour tablet 0.5mg','TABLET','-',NULL,NULL,'0.00'),(202,1,'drug','03007','Formokresol(pengganti TKF)','BOTOL','-',NULL,NULL,'0.00'),(203,1,'drug','03008','Glass ionomer cement (GC IX)','SET','-',NULL,NULL,'0.00'),(204,1,'drug','03009','Kalsium hidroksida pasta/Urbical/Calcidor','SET','-',NULL,NULL,'0.00'),(205,1,'drug','03010','Klorfenol kamfer menthol (CHKM)','BOTOL','-',NULL,NULL,'0.00'),(206,1,'drug','03011','Mummifying pasta/ Iodoform paste','BOTOL','-',NULL,NULL,'0.00'),(207,1,'drug','03012','Semen seng fosfat serbuk dan cairan/Multifix','SET','-',NULL,NULL,'0.00'),(208,1,'drug','03013','Silver amalgam serbuk 65-75%/ F 400','BOTOL','-',NULL,NULL,'0.00'),(209,1,'drug','03014','Spons gelatin cubides /Curaspon  Dental','DENTAL','-',NULL,NULL,'0.00'),(210,1,'drug','03015','Temporary stopping fletcher(Fletcher)serbuk','SET','-',NULL,NULL,'0.00'),(211,1,'drug','04001','Acyclovir 200 mg tablet (OGB)','TABLET','-',NULL,NULL,'0.00'),(212,1,'drug','04002','Acyclovir 400 mg tablet (OGB)','TABLET','-',NULL,NULL,'0.00'),(213,1,'drug','04003','Acyclovir cream (OGB)','TUBE','-',NULL,NULL,'0.00'),(214,1,'drug','04004','Adona AC tablet','TABLET','-',NULL,NULL,'0.00'),(215,1,'drug','04005','Alinamin F Injeksi','AMPUL','-',NULL,NULL,'0.00'),(216,1,'drug','04006','Ambroxol Syr (OGB)','BOTOL','-',NULL,NULL,'0.00'),(217,1,'drug','04007','Ambroxol 30mg tablet (OGB)','TABLET','-',NULL,NULL,'0.00'),(218,1,'drug','04008','Amoxan Drops/Amobiotik Drop','BOTOL','-',NULL,NULL,'0.00'),(219,1,'drug','04009','Amoxan Inj 1000 mg','VIAL','-',NULL,NULL,'0.00'),(220,1,'drug','04010','Ampicillin Inj 1 gr (OGB)','VIAL','-',NULL,NULL,'0.00'),(221,1,'drug','04011','Asam Mefenamat 500 mg tab (OGB)','TABLET','-',NULL,NULL,'0.00'),(222,1,'drug','04012','Baralgin Inj 2 ml','AMPUL','-',NULL,NULL,'0.00'),(223,1,'drug','04013','Bioplacenton Jelly','TUBE','-',NULL,NULL,'0.00'),(224,1,'drug','04014','Bisolvan Injeksi','AMPUL','-',NULL,NULL,'0.00'),(225,1,'drug','04015','Borax Gliserin 8 ml','BOTOL','-',NULL,NULL,'0.00'),(226,1,'drug','04016','Bricasma Injeksi','AMPUL','-',NULL,NULL,'0.00'),(227,1,'drug','04017','Buscopan Injeksi','AMPUL','-',NULL,NULL,'0.00'),(228,1,'drug','04018','Kandistatin drops','BOTOL','-',NULL,NULL,'0.00'),(229,1,'drug','04019','Catapres Injeksi','AMPUL','-',NULL,NULL,'0.00'),(230,1,'drug','04020','Caustin','BOTOL','-',NULL,NULL,'0.00'),(231,1,'drug','04021','Ceftriaxone 1 gram Inj','VIAL','-',NULL,NULL,'0.00'),(232,1,'drug','04022','Chloramfecort H Cream Zalf Kulit','TUBE','-',NULL,NULL,'0.00'),(233,1,'drug','04023','Cimetidin 200 mg tab (OGB)','TABLET','-',NULL,NULL,'0.00'),(234,1,'drug','04024','Cimetidin Injeksi','AMPUL','-',NULL,NULL,'0.00'),(235,1,'drug','04025','Cycloven Inj KB','VIAL','-',NULL,NULL,'0.00'),(236,1,'drug','04026','Cyprofloxacin tab 500 mg (OGB)','TABLET','-',NULL,NULL,'0.00'),(237,1,'drug','04027','Daryantulle','KOTAK','-',NULL,NULL,'0.00'),(238,1,'drug','04028','Depo Provera Inj KB/Depo Progestin','VIAL','-',NULL,NULL,'0.00'),(239,1,'drug','04029','Dextamin tab','TABLET','-',NULL,NULL,'0.00'),(240,1,'drug','04030','DHBP Inj (Dehydrobensperidol)','AMPUL','-',NULL,NULL,'0.00'),(241,1,'drug','04031','Diaform tab','TABLET','-',NULL,NULL,'0.00'),(242,1,'drug','04032','Dormicum 5 mg/ ml Injeksi','AMPUL','-',NULL,NULL,'0.00'),(243,1,'drug','04033','Doxyciclin cap 100 mg (OGB)','CAPSUL','-',NULL,NULL,'0.00'),(244,1,'drug','04034','Dulcolax tab','TABLET','-',NULL,NULL,'0.00'),(245,1,'drug','04035','Ephedrin Injeksi','AMPUL','-',NULL,NULL,'0.00'),(246,1,'drug','04036','Epidosin Injeksi','AMPUL','-',NULL,NULL,'0.00'),(247,1,'drug','04037','Erithromisin syr 200 mg/5 ml (OGB)','BOTOL','-',NULL,NULL,'0.00'),(248,1,'drug','04038','Erithromisin capsul 500 mg  (OGB)','CAPSUL','-',NULL,NULL,'0.00'),(249,1,'drug','04039','Fentanyl 50 mg/ ml Inj','AMPUL','-',NULL,NULL,'0.00'),(250,1,'drug','04040','Flagyl Infus/Metronidazole inf','BOTOL','-',NULL,NULL,'0.00'),(251,1,'drug','04041','Gentamycin salep kulit 01% 5gr(OGB)','TUBE','-',NULL,NULL,'0.00'),(252,1,'drug','04042','H 2 O 2  3 % 1000 ML','BOTOL','-',NULL,NULL,'0.00'),(253,1,'drug','04043','Halotan  Injeksi 250 ML','BOTOL','-',NULL,NULL,'0.00'),(254,1,'drug','04044','Histolan Tab','TABLET','-',NULL,NULL,'0.00'),(255,1,'drug','04045','Ichtiol Salep','POT','-',NULL,NULL,'0.00'),(256,1,'drug','04046','Insulin reg Inj 40 iu/ml-10 ml (human)','VIAL','-',NULL,NULL,'0.00'),(257,1,'drug','04047','Kanamycin Inj 2 gram','VIAL','-',NULL,NULL,'0.00'),(258,1,'drug','04048','Kaotate Syr/ Guanistrape syr','BOTOL','-',NULL,NULL,'0.00'),(259,1,'drug','04049','Ketokenazol Cream','TUBE','-',NULL,NULL,'0.00'),(260,1,'drug','04050','Ketokenazol 200 mg tab','TABLET','-',NULL,NULL,'0.00'),(261,1,'drug','04051','Kloramphenikol Tetes Mata','BOTOL','-',NULL,NULL,'0.00'),(262,1,'drug','04052','Kloramphenikol syr','BOTOL','-',NULL,NULL,'0.00'),(263,1,'drug','04053','L muvit sirup','BOTOL','-',NULL,NULL,'0.00'),(264,1,'drug','04054','Loratadin tablet 10mg','TABLET','-',NULL,NULL,'0.00'),(265,1,'drug','04055','Lyncomicin 500mg cap','CAPSUL','-',NULL,NULL,'0.00'),(266,1,'drug','04056','Marcain 0.5% injeksi','VIAL','-',NULL,NULL,'0.00'),(267,1,'drug','04057','Melon injeksi','BOTOL','-',NULL,NULL,'0.00'),(268,1,'drug','04058','Methergin injeksi','AMPUL','-',NULL,NULL,'0.00'),(269,1,'drug','04059','Metochlorpamid sirup','BOTOL','-',NULL,NULL,'0.00'),(270,1,'drug','04060','Metochlorpamid tablet','TABLET','-',NULL,NULL,'0.00'),(271,1,'drug','04061','Metronidazole tablet 500mg','TABLET','-',NULL,NULL,'0.00'),(272,1,'drug','04062','Miconazol 2% cream (OGB)','TUBE','-',NULL,NULL,'0.00'),(273,1,'drug','04063','Natrium diklofenac 50mg tablet (OGB)','TABLET','-',NULL,NULL,'0.00'),(274,1,'drug','04064','Nifedipin tablet (OGB)','TABLET','-',NULL,NULL,'0.00'),(275,1,'drug','04065','Norculon injeksi / Norcuron inj','AMPUL','-',NULL,NULL,'0.00'),(276,1,'drug','04066','Papaverin tablet 40mg (OGB)','TABLET','-',NULL,NULL,'0.00'),(277,1,'drug','04067','Pentotal injeksi','AMPUL','-',NULL,NULL,'0.00'),(278,1,'drug','04068','Piroxicam 20mg (OGB)','TABLET','-',NULL,NULL,'0.00'),(279,1,'drug','04069','Pregnolin tablet','TABLET','-',NULL,NULL,'0.00'),(280,1,'drug','04070','Primolut N tablet','TABLET','-',NULL,NULL,'0.00'),(281,1,'drug','04071','Primperan injeksi','AMPUL','-',NULL,NULL,'0.00'),(282,1,'drug','04072','Profenid suppos','SUPP','-',NULL,NULL,'0.00'),(283,1,'drug','04073','Prostigmin injeksi','AMPUL','-',NULL,NULL,'0.00'),(284,1,'drug','04074','Recovol/Depripan 10mg/ml','AMPUL','-',NULL,NULL,'0.00'),(285,1,'drug','04075','Simvastatin','TABLET','-',NULL,NULL,'0.00'),(286,1,'drug','04076','Sintocinon injeksi','AMPUL','-',NULL,NULL,'0.00'),(287,1,'drug','04077','Stesolid rectal 10mg','TUBE','-',NULL,NULL,'0.00'),(288,1,'drug','04078','Stesolid rectal 5mg','TUBE','-',NULL,NULL,'0.00'),(289,1,'drug','04079','Succynal siccum 100mg injeksi','AMPUL','-',NULL,NULL,'0.00'),(290,1,'drug','04080','Systabon injeksi','AMPUL','-',NULL,NULL,'0.00'),(291,1,'drug','04081','Tambah darah tablet','SASE','-',NULL,NULL,'0.00'),(292,1,'drug','04082','Toradol injeksi','AMPUL','-',NULL,NULL,'0.00'),(293,1,'drug','04083','Tramadol injeksi','AMPUL','-',NULL,NULL,'0.00'),(294,1,'drug','04084','Transamin injeksi','AMPUL','-',NULL,NULL,'0.00'),(295,1,'drug','04085','Transamin tablet 250mg','TABLET','-',NULL,NULL,'0.00'),(296,1,'drug','04086','Trombophob gel','TUBE','-',NULL,NULL,'0.00'),(297,1,'drug','04087','Tyrax tablet','TABLET','-',NULL,NULL,'0.00'),(298,1,'drug','04088','Urispas tablet','TABLET','-',NULL,NULL,'0.00'),(299,1,'drug','04089','Vitamin B12 tablet','TABLET','-',NULL,NULL,'0.00'),(300,1,'drug','04090','Valium injeksi','AMPUL','-',NULL,NULL,'0.00'),(301,1,'drug','04091','Vitamin A 100 000 iu','CAPSUL','-',NULL,NULL,'0.00'),(302,1,'drug','04092','Xylocain 2% gel 10 gram','TUBE','-',NULL,NULL,'0.00'),(303,1,'drug','04093','Vitamin A 200 000 ui','CAPSUL','-',NULL,NULL,'0.00'),(304,1,'drug','04094','Benzatin Benzil Penisilin 2.4 jt inj','VIAL','-',NULL,NULL,'0.00'),(305,1,'drug','04095','Kaca sediaan / Slides/objec glass','KOTAK','-',NULL,NULL,'0.00'),(306,1,'drug','04096','Microscopy larutan/Immersion oil','BOTOL','-',NULL,NULL,'0.00'),(307,1,'drug','04098','Tissu Lensa/ Lens Tissues','BUAH','-',NULL,NULL,'0.00'),(308,1,'drug','04099','Armovit tab','TABLET','-',NULL,NULL,'0.00'),(309,1,'drug','04100','Augell Lub jelly 82 grultrasonic gell','TUBE','-',NULL,NULL,'0.00'),(310,1,'drug','04101','Bioneuron inj','AMPUL','-',NULL,NULL,'0.00'),(311,1,'drug','04102','Burraginol supp','BOX','-',NULL,NULL,'0.00'),(312,1,'drug','04103','Co Amoxyclav 625 tab','TABLET','-',NULL,NULL,'0.00'),(313,1,'drug','04104','Catopril 25 mg tab','TABLET','-',NULL,NULL,'0.00'),(314,1,'drug','04105','Deflamat 75 CR tab','CAPSUL','-',NULL,NULL,'0.00'),(315,1,'drug','04106','Deflamat 100 CR tab','CAPSUL','-',NULL,NULL,'0.00'),(316,1,'drug','04107','Duvadilan inj','AMPUL','-',NULL,NULL,'0.00'),(317,1,'drug','04108','Fevrin drop 15 ml','BOTOL','-',NULL,NULL,'0.00'),(318,1,'drug','04109','Gentamycin  80 mg inj','AMPUL','-',NULL,NULL,'0.00'),(319,1,'drug','04110','Geriavita tab','BOX','-',NULL,NULL,'0.00'),(320,1,'drug','04111','Hypobach 100','AMPUL','-',NULL,NULL,'0.00'),(321,1,'drug','04112','Kolkatriol F tab','TABLET','-',NULL,NULL,'0.00'),(322,1,'drug','04113','Lanakeloid cream','TUBE','-',NULL,NULL,'0.00'),(323,1,'drug','04114','Kanarco 1000 mg inj','VIAL','-',NULL,NULL,'0.00'),(324,1,'drug','04115','Lanakeloid tab','TABLET','-',NULL,NULL,'0.00'),(325,1,'drug','04116','NB Tropical oint','TUBE','-',NULL,NULL,'0.00'),(326,1,'drug','04117','Ofloxacin tab','TABLET','-',NULL,NULL,'0.00'),(327,1,'drug','04118','Ossoral 200 mg tab','TABLET','-',NULL,NULL,'0.00'),(328,1,'drug','04119','Oxtercyd inj','VIAL','-',NULL,NULL,'0.00'),(329,1,'drug','04120','Pehavral  tab','BOX','-',NULL,NULL,'0.00'),(330,1,'drug','04121','Poncodryl  Sirup','BOTOL','-',NULL,NULL,'0.00'),(331,1,'drug','04122','Pronalges tab','TABLET','-',NULL,NULL,'0.00'),(332,1,'drug','04123','Pronalges inj','AMPUL','-',NULL,NULL,'0.00'),(333,1,'drug','04124','Furosemid  inj','AMPUL','-',NULL,NULL,'0.00'),(334,1,'drug','04125','Calsium gluconat inj','BOX','-',NULL,NULL,'0.00'),(335,1,'drug','04126','Pyralvex','BOTOL','-',NULL,NULL,'0.00'),(336,1,'drug','04127','Tensigard tab','TABLET','-',NULL,NULL,'0.00'),(337,1,'drug','04128','Vicanatal  tab','TABLET','-',NULL,NULL,'0.00'),(338,1,'drug','04129','Zumatab Sirup','BOTOL','-',NULL,NULL,'0.00'),(339,1,'drug','04130','Ardium tab','TABLET','-',NULL,NULL,'0.00'),(340,1,'drug','04131','Kenacort tab','TABLET','-',NULL,NULL,'0.00'),(341,1,'drug','04132','Virazid 100 tab','TABLET','-',NULL,NULL,'0.00'),(342,1,'drug','04133','Exluton 28 Limas (ibu Menyusui)','STRIP','-',NULL,NULL,'0.00'),(343,1,'drug','04134','Kondom','LUSIN','-',NULL,NULL,'0.00'),(344,1,'drug','04135','Microginon tab LIBI/Pilkab tab','STRIP','-',NULL,NULL,'0.00'),(345,1,'drug','04136','Cendo Tropin 0.5 %','BOTOL','-',NULL,NULL,'0.00'),(346,1,'drug','04137','Cendo Fluorescein 2%','BOTOL','-',NULL,NULL,'0.00'),(347,1,'drug','04138','Cendo Cetamide 15%','BOTOL','-',NULL,NULL,'0.00'),(348,1,'drug','04139','Cendo Carpine 2%','BOTOL','-',NULL,NULL,'0.00'),(349,1,'drug','04140','Cendo Tetracaine 0.5%','BOTOL','-',NULL,NULL,'0.00'),(350,1,'drug','04141','Aether','BOTOL','-',NULL,NULL,'0.00'),(351,1,'drug','04142','Dietilcarbomazin 100 mg','TABLET','-',NULL,NULL,'0.00'),(352,1,'drug','04143','Mikrodiol 30 tab KB','STRIP','-',NULL,NULL,'0.00'),(353,1,'drug','04144','Vitrex (Micro Haematocrit)','TUBE','-',NULL,NULL,'0.00'),(354,1,'drug','04145','Ranitidin inj','AMPUL','-',NULL,NULL,'0.00'),(355,1,'drug','04146','Mersitrophyl 1 gr inj','AMPUL','-',NULL,NULL,'0.00'),(356,1,'drug','04147','Mersitrophyl 400 mg tab','TABLET','-',NULL,NULL,'0.00'),(357,1,'drug','04148','Mersitrophyl 500 mg/5 ml syr','BOTOL','-',NULL,NULL,'0.00'),(358,1,'drug','04149','Versilon 6 mg tab','TABLET','-',NULL,NULL,'0.00'),(359,1,'drug','04150','Catopril 12.5 mg tab','TABLET','-',NULL,NULL,'0.00'),(360,1,'drug','04151','Asam folat 1 mg tab','TABLET','-',NULL,NULL,'0.00'),(361,1,'drug','04152','Dopamin 200 mg inj','AMPUL','-',NULL,NULL,'0.00'),(362,1,'drug','04153','Klonidine Hcl 0.15 mg tab','TABLET','-',NULL,NULL,'0.00'),(363,1,'drug','04154','Diltiazem Hcl 30 mg tab','TABLET','-',NULL,NULL,'0.00'),(364,1,'drug','04155','Aspar K tab','TABLET','-',NULL,NULL,'0.00'),(365,1,'drug','04156','Amiodaron 200 mg/Tyarit tab','TABLET','-',NULL,NULL,'0.00'),(366,1,'drug','04157','Betason N Cream 5 gr','TUBE','-',NULL,NULL,'0.00'),(367,1,'drug','04158','Dobutamine inj amp','AMPUL','-',NULL,NULL,'0.00'),(368,1,'drug','04159','Ascardia 80 mg tab','TABLET','-',NULL,NULL,'0.00'),(369,1,'drug','04160','Spirolakton 25 mg tab','TABLET','-',NULL,NULL,'0.00'),(370,1,'drug','04161','Ranitidin 150 mg tab','TABLET','-',NULL,NULL,'0.00'),(371,1,'drug','04162','Asam Mefenamat 250 mg cap','CAPSUL','-',NULL,NULL,'0.00'),(372,1,'drug','04163','ZN','TEST','-',NULL,NULL,'0.00'),(373,1,'drug','04164','Arsen test','TEST','-',NULL,NULL,'0.00'),(374,1,'drug','04165','Cyanid test','TEST','-',NULL,NULL,'0.00'),(375,1,'drug','04166','Nitrit','TEST','-',NULL,NULL,'0.00'),(376,1,'drug','04167','Artem (Artemether 80 mg) inj','AMPUL','-',NULL,NULL,'0.00'),(377,1,'drug','04168','Artesunate Inj','VIAL','-',NULL,NULL,'0.00'),(378,1,'drug','04169','Artesdiaquine tab/ ACT','PAKET','-',NULL,NULL,'0.00'),(379,1,'drug','04170','Piroxicam tab 10 mg','TABLET','-',NULL,NULL,'0.00'),(380,1,'drug','04171','Phenilbutazon','TABLET','-',NULL,NULL,'0.00'),(381,1,'drug','04172','Sefotaxim inj 1 gr','VIAL','-',NULL,NULL,'0.00'),(382,1,'drug','04173','Thiamfenikol kap 500 mg','CAPSUL','-',NULL,NULL,'0.00'),(383,1,'drug','04174','Bromhexin Hcl tab (Bronex)','TABLET','-',NULL,NULL,'0.00'),(384,1,'drug','04175','FG Troches tab','TABLET','-',NULL,NULL,'0.00'),(385,1,'drug','04176','Combantrin syr','BOTOL','-',NULL,NULL,'0.00'),(386,1,'drug','04177','Antasida DOEN suspensi','BOTOL','-',NULL,NULL,'0.00'),(387,1,'drug','04178','Sefadroxil 500 mg kap','CAPSUL','-',NULL,NULL,'0.00'),(388,1,'drug','04179','Conterpain Cream 15 gr','TUBE','-',NULL,NULL,'0.00'),(389,1,'drug','04180','Scabicid cream','TUBE','-',NULL,NULL,'0.00'),(390,1,'drug','04181','Evion 200 soft kaps','CAPSUL','-',NULL,NULL,'0.00'),(391,1,'drug','04182','Paratusin tablet','TABLET','-',NULL,NULL,'0.00'),(392,1,'drug','04183','Omeprazol kapsul 20 mg','CAPSUL','-',NULL,NULL,'0.00'),(393,1,'drug','04184','Zistic 500 mg','CAPSUL','-',NULL,NULL,'0.00'),(394,1,'drug','04185','Flutamol kapsul','CAPSUL','-',NULL,NULL,'0.00'),(395,1,'drug','04186','Folavit tablet','TABLET','-',NULL,NULL,'0.00'),(396,1,'drug','04187','Dialac 1 gr','ZAK','-',NULL,NULL,'0.00'),(397,1,'drug','04188','Pelancr Asi (Asifit kaplt)','KAPLET','-',NULL,NULL,'0.00'),(398,1,'drug','04189','Zink 20 mg Dispersible tab','TABLET','-',NULL,NULL,'0.00'),(399,1,'drug','04190','Alphamol drop','BOTOL','-',NULL,NULL,'0.00'),(400,1,'drug','04191','Multi Vitamin syr (Calcidol +DHA+Lysin)','BOTOL','-',NULL,NULL,'0.00'),(401,1,'drug','04192','Striptomisin sebuk inj 1000 mg/ml','VIAL','-',NULL,NULL,'0.00'),(402,1,'drug','04193','Piracetam 1200 mg','TABLET','-',NULL,NULL,'0.00'),(403,1,'drug','04194','Hypochlorite 1 %','BOTOL','-',NULL,NULL,'0.00'),(404,1,'drug','04195','Folamil','TABLET','-',NULL,NULL,'0.00'),(405,1,'drug','04196','kombipak Azithtromycin - cefixime','PAKET','-',NULL,NULL,'0.00'),(406,1,'drug','04197','Gentamicyn tets mata','BOTOL','-',NULL,NULL,'0.00'),(407,1,'drug','04198','Molakrim','TUBE','-',NULL,NULL,'0.00'),(408,1,'drug','04199','Neo Kaulana Syr','BOTOL','-',NULL,NULL,'0.00'),(409,1,'drug','04200','Tetagam inj','AMPUL','-',NULL,NULL,'0.00'),(410,1,'bhp','05001','Abocate No. 18','SET','-',NULL,NULL,'0.00'),(411,1,'bhp','05002','Abocate No. 20','SET','-',NULL,NULL,'0.00'),(412,1,'bhp','05003','Abocate No. 22','SET','-',NULL,NULL,'0.00'),(413,1,'bhp','05004','Abocate No. 24','SET','-',NULL,NULL,'0.00'),(414,1,'bhp','05005','Alat suntik sekali pakai 1ml','PCS','-',NULL,NULL,'0.00'),(415,1,'bhp','05006','Alat suntik sekali pakai 3ml/2.5ml','PCS','-',NULL,NULL,'0.00'),(416,1,'bhp','05007','Alat suntik sekali pakai 5ml','PCS','-',NULL,NULL,'0.00'),(417,1,'bhp','05008','Alat suntik sekali pakai 10ml','PCS','-',NULL,NULL,'0.00'),(418,1,'bhp','05009','Anisol  5ml/botol','BOTOL','-',NULL,NULL,'0.00'),(419,1,'bhp','05010','Cat gut chromic 1/0 kaset','ROL','-',NULL,NULL,'0.00'),(420,1,'bhp','05011','Cat gut chromic 2/0 kaset','ROL','-',NULL,NULL,'0.00'),(421,1,'bhp','05012','Cat gut chromic 3/0 kaset','ROL','-',NULL,NULL,'0.00'),(422,1,'bhp','05013','Cat gut Chormic 2/0 dgn jarum','LUSIN','-',NULL,NULL,'0.00'),(423,1,'bhp','05014','Dexon 2-0 (Cuthing)','SET','-',NULL,NULL,'0.00'),(424,1,'bhp','05015','Dexon 3-0 (Cuthing)','SET','-',NULL,NULL,'0.00'),(425,1,'bhp','05016','Larutan Eosin 50 ml','BOTOL','-',NULL,NULL,'0.00'),(426,1,'bhp','05017','Etakridin(rivanol)larutan 0.1% btl 300ml','BOTOL','-',NULL,NULL,'0.00'),(427,1,'bhp','05018','Etanol /Alkohol 70% 1000 ML','BOTOL','-',NULL,NULL,'0.00'),(428,1,'bhp','05019','Foley catheter no 18','BUAH','-',NULL,NULL,'0.00'),(429,1,'bhp','05020','Hand scund steril no 6','PASANG','-',NULL,NULL,'0.00'),(430,1,'bhp','05021','Hand scund steril no 7','PASANG','-',NULL,NULL,'0.00'),(431,1,'bhp','05022','Hand scund steril no 7.5','PASANG','-',NULL,NULL,'0.00'),(432,1,'bhp','05023','Hand scund steril no 8','PASANG','-',NULL,NULL,'0.00'),(433,1,'bhp','05024','Hibiscrub / Hydrex 5 liter','BOTOL','-',NULL,NULL,'0.00'),(434,1,'bhp','05025','Infusion set anak','SET','-',NULL,NULL,'0.00'),(435,1,'bhp','05026','Infusion set dewasa','SET','-',NULL,NULL,'0.00'),(436,1,'bhp','05027','Jarum jahit (bedah) no 9 s/d 14','LUSIN','-',NULL,NULL,'0.00'),(437,1,'bhp','05028','Kapas berlemak 500gr','BUNGKUS','-',NULL,NULL,'0.00'),(438,1,'bhp','05029','Kapas pembalut/absorben 250gr','BUNGKUS','-',NULL,NULL,'0.00'),(439,1,'bhp','05030','Kartu golongan darah','LEMBAR','-',NULL,NULL,'0.00'),(440,1,'bhp','05031','Kasa kompres 40/40 steril','PCS','-',NULL,NULL,'0.00'),(441,1,'bhp','05032','Kasa pembalut 2m x 80cm','ROL','-',NULL,NULL,'0.00'),(442,1,'bhp','05033','Kasa pembalut hidrofil 4 m x 15 cm','ROL','-',NULL,NULL,'0.00'),(443,1,'bhp','05034','Kasa pembalut hidrofil 4 m x 3 cm','ROL','-',NULL,NULL,'0.00'),(444,1,'bhp','05035','Kasa pembalut hidrofil 40 m x 80 cm','ROL','-',NULL,NULL,'0.00'),(445,1,'bhp','05036','Kateter disposible','BUAH','-',NULL,NULL,'0.00'),(446,1,'bhp','05037','Larutan asam asetate 6%','BOTOL','-',NULL,NULL,'0.00'),(447,1,'bhp','05038','Larutan benedict 100 ml/500 ml','BOTOL','-',NULL,NULL,'0.00'),(448,1,'bhp','05039','Larutan Eosin 2% 100 ml','BOTOL','-',NULL,NULL,'0.00'),(449,1,'bhp','05040','Larutan etanol asam','BOTOL','-',NULL,NULL,'0.00'),(450,1,'bhp','05041','Larutan giemsa stain','BOTOL','-',NULL,NULL,'0.00'),(451,1,'bhp','05042','Larutan Hyem','BOTOL','-',NULL,NULL,'0.00'),(452,1,'bhp','05043','Larutan karbol fuksin','BOTOL','-',NULL,NULL,'0.00'),(453,1,'bhp','05044','Larutan metilen biru 100 ML','BOTOL','-',NULL,NULL,'0.00'),(454,1,'bhp','05045','Larutan turk','BOTOL','-',NULL,NULL,'0.00'),(455,1,'bhp','05046','Latex/tes kehamilan','TEST','-',NULL,NULL,'0.00'),(456,1,'bhp','05047','Lisol mengandung kresol tersabun 50%','BOTOL','-',NULL,NULL,'0.00'),(457,1,'bhp','05048','Lugol  (Pewarna Gram)','BOTOL','-',NULL,NULL,'0.00'),(458,1,'bhp','05049','Masker','PCS','-',NULL,NULL,'0.00'),(459,1,'bhp','05050','Metanol','BOTOL','-',NULL,NULL,'0.00'),(460,1,'bhp','05051','N 2 0','TABUNG','-',NULL,NULL,'0.00'),(461,1,'bhp','05052','Nedle 25 G X 1 (untuk Bias)','KOTAK','-',NULL,NULL,'0.00'),(462,1,'bhp','05053','Nedle heacting G 15-1212','LUSIN','-',NULL,NULL,'0.00'),(463,1,'bhp','05054','Nedle heacting G 3-1312/G 7X26 Circle Dr marton','LUSIN','-',NULL,NULL,'0.00'),(464,1,'bhp','05055','Nedle heacting G 3/4/G 9016B/R.10 Dr Marton','LUSIN','-',NULL,NULL,'0.00'),(465,1,'bhp','05056','Nedle heacting G 7-1312','LUSIN','-',NULL,NULL,'0.00'),(466,1,'bhp','05057','NGT no 6','PCS','-',NULL,NULL,'0.00'),(467,1,'bhp','05058','NGT no 8','PCS','-',NULL,NULL,'0.00'),(468,1,'bhp','05059','Ose Jarum','SET','-',NULL,NULL,'0.00'),(469,1,'bhp','05060','Oxygen dalam tabung 40 liter Voucer','LEMBAR','-',NULL,NULL,'0.00'),(470,1,'bhp','05061','Pembalut gips/Fixplast 10 cm x 2,7 m','ROL','-',NULL,NULL,'0.00'),(471,1,'bhp','05062','Pisau badah (bisturi) no 21','KOTAK','-',NULL,NULL,'0.00'),(472,1,'bhp','05063','Plester 2 inch x 5 yard','ROL','-',NULL,NULL,'0.00'),(473,1,'bhp','05064','Povidon iodida 10%-30ml','BOTOL','-',NULL,NULL,'0.00'),(474,1,'bhp','05065','Povidon iodida 10%-300ml','BOTOL','-',NULL,NULL,'0.00'),(475,1,'bhp','05066','Povidon iodida 10%-1000ml','BOTOL','-',NULL,NULL,'0.00'),(476,1,'bhp','05067','Reagen pemeriksaan gol darah/BGRanti D','SET','-',NULL,NULL,'0.00'),(477,1,'bhp','05068','Reagen pemeriksaTrombocit/ReesEcher 100 ML/Lar Amonium Oxalat','BOTOL','-',NULL,NULL,'0.00'),(478,1,'bhp','05069','Reagen Zeil nelsen (BTA) 100 ml','BOTOL','-',NULL,NULL,'0.00'),(479,1,'bhp','05070','Serum gol darah /BGR anti A&B','SET','-',NULL,NULL,'0.00'),(480,1,'bhp','05071','Silk 3/0 kaset','ROL','-',NULL,NULL,'0.00'),(481,1,'bhp','05072','Silk (benang sutera)no 3/0 dg jarum','LUSIN','-',NULL,NULL,'0.00'),(482,1,'bhp','05073','Test widal','SET','-',NULL,NULL,'0.00'),(483,1,'bhp','05074','Urine bag','BUAH','-',NULL,NULL,'0.00'),(484,1,'bhp','05075','Reagen strip urine 3 parameter (PH) / Cybow','KOTAK','-',NULL,NULL,'0.00'),(485,1,'bhp','05076','Wing nedle 23','PCS','-',NULL,NULL,'0.00'),(486,1,'bhp','05077','Wing nedle no 25 G','PCS','-',NULL,NULL,'0.00'),(487,1,'bhp','05078','Yodium 1%','BOTOL','-',NULL,NULL,'0.00'),(488,1,'bhp','05079','Plastik kantong etiket obat besar','BALL','-',NULL,NULL,'0.00'),(489,1,'bhp','05080','Plastik kantong etiket obat 6,5x805 cm','BALL','-',NULL,NULL,'0.00'),(490,1,'bhp','05081','Kertas perkamen Ukuran 75 X 100 Cm','RIM','-',NULL,NULL,'0.00'),(491,1,'bhp','05082','Cat gut Plain 3/0 dgn jarum','LUSIN','-',NULL,NULL,'0.00'),(492,1,'bhp','05083','Cat gut Plain 3/0','LUSIN','-',NULL,NULL,'0.00'),(493,1,'bhp','05084','Nedle Heacting B 9-1204 (Otot) B9-1112','LUSIN','-',NULL,NULL,'0.00'),(494,1,'bhp','05085','Nedle Heacting   9x30 (G9 1132 Kulit)','LUSIN','-',NULL,NULL,'0.00'),(495,1,'bhp','05086','Etanol 96 %','BOTOL','-',NULL,NULL,'0.00'),(496,1,'bhp','05087','Blood Adm Set (Giving Set)','SET','-',NULL,NULL,'0.00'),(497,1,'bhp','05088','Vaselin','KLG','-',NULL,NULL,'0.00'),(498,1,'bhp','05089','Thorax Chateter 20 F','PCS','-',NULL,NULL,'0.00'),(499,1,'bhp','05090','Thorax chateter 24 F','PCS','-',NULL,NULL,'0.00'),(500,1,'bhp','05091','Dexon 4-0 (Chromic)','BOX','-',NULL,NULL,'0.00'),(501,1,'bhp','05092','X  Ray Film 30 x40','BOX','-',NULL,NULL,'0.00'),(502,1,'bhp','05093','Cassette Film Rontgen CE 30x40','BUAH','-',NULL,NULL,'0.00'),(503,1,'bhp','05094','Developer Liquid','BOTOL','-',NULL,NULL,'0.00'),(504,1,'bhp','05095','Pot salep transparan 30 gr/20 gr','POT','-',NULL,NULL,'0.00'),(505,1,'bhp','05096','Plastik Kantong Obat 15x33 cm','BALL','-',NULL,NULL,'0.00'),(506,1,'bhp','05097','Fixer Liquid','BOTOL','-',NULL,NULL,'0.00'),(507,1,'bhp','05098','Vicril 1','BOX','-',NULL,NULL,'0.00'),(508,1,'bhp','05099','Vicril 3-0','BOX','-',NULL,NULL,'0.00'),(509,1,'bhp','05100','Vicril 4-0','BOX','-',NULL,NULL,'0.00'),(510,1,'bhp','05101','Vicril 5-0','BOX','-',NULL,NULL,'0.00'),(511,1,'bhp','05102','Prolen  no 1','BOX','-',NULL,NULL,'0.00'),(512,1,'bhp','05103','Prolen  no 2-0','BOX','-',NULL,NULL,'0.00'),(513,1,'bhp','05104','Prolen  3-0','LUSIN','-',NULL,NULL,'0.00'),(514,1,'bhp','05105','Prolen  4-0','BOX','-',NULL,NULL,'0.00'),(515,1,'bhp','05106','Leucodur 6 Inch','ROL','-',NULL,NULL,'0.00'),(516,1,'bhp','05107','Leucodur 4 inch','ROL','-',NULL,NULL,'0.00'),(517,1,'bhp','05108','Leucodur 3 Inch','ROL','-',NULL,NULL,'0.00'),(518,1,'bhp','05109','Leucoband 6 Inch / Artiflex','ROL','-',NULL,NULL,'0.00'),(519,1,'bhp','05110','Leucoband 4 Inch / Artiflex','ROL','-',NULL,NULL,'0.00'),(520,1,'bhp','05111','Leucoband 3 Inch / Artiflex','ROL','-',NULL,NULL,'0.00'),(521,1,'bhp','05112','Leucocrepe 6 Inch','ROL','-',NULL,NULL,'0.00'),(522,1,'bhp','05113','Leucocrepe 4 Inch','ROL','-',NULL,NULL,'0.00'),(523,1,'bhp','05114','Spongostan / Hemospone','DENTAL','-',NULL,NULL,'0.00'),(524,1,'bhp','05115','Dettol Liquid antiseptic 750 ml','BOTOL','-',NULL,NULL,'0.00'),(525,1,'bhp','05116','Kartu stock obat','LEMBAR','-',NULL,NULL,'0.00'),(526,1,'bhp','05117','Reagent Kolesterol','SET','-',NULL,NULL,'0.00'),(527,1,'bhp','05118','Reagent Urid Acid','SET','-',NULL,NULL,'0.00'),(528,1,'bhp','05119','Reagent Gula Darah','SET','-',NULL,NULL,'0.00'),(529,1,'bhp','05120','Reagent Urea','SET','-',NULL,NULL,'0.00'),(530,1,'bhp','05121','Reagent Kreatinin','SET','-',NULL,NULL,'0.00'),(531,1,'bhp','05122','Reagent  G O T','SET','-',NULL,NULL,'0.00'),(532,1,'bhp','05123','Reagent  G P T','SET','-',NULL,NULL,'0.00'),(533,1,'bhp','05124','Reagent Triglicerida','SET','-',NULL,NULL,'0.00'),(534,1,'bhp','05125','Deck Glass','SET','-',NULL,NULL,'0.00'),(535,1,'bhp','05126','Blood Lancet','PCS','-',NULL,NULL,'0.00'),(536,1,'bhp','05127','Cat gut cromic 3/0 dg jarum','LUSIN','-',NULL,NULL,'0.00'),(537,1,'bhp','05128','Cat gut chromic 2/0','LUSIN','-',NULL,NULL,'0.00'),(538,1,'bhp','05129','Cat gut Plain 2/0','LUSIN','-',NULL,NULL,'0.00'),(539,1,'bhp','05130','Cat gut Plain 2/0 dg jarum','LUSIN','-',NULL,NULL,'0.00'),(540,1,'bhp','05131','Silk (benang sutera) 3/0','LUSIN','-',NULL,NULL,'0.00'),(541,1,'bhp','05132','Pisau bedah(bisturi) no 15','KOTAK','-',NULL,NULL,'0.00'),(542,1,'bhp','05133','Pisau bedah (bisturi) no 22','KOTAK','-',NULL,NULL,'0.00'),(543,1,'bhp','05134','Pisau bedah (bisturi) no 11','KOTAK','-',NULL,NULL,'0.00'),(544,1,'bhp','05135','Pisau bedah (bisturi) no 24','KOTAK','-',NULL,NULL,'0.00'),(545,1,'bhp','05136','Pisau bedah (bisturi) no 10','KOTAK','-',NULL,NULL,'0.00'),(546,1,'bhp','05137','Pisau bedah (bisturi) no 23','KOTAK','-',NULL,NULL,'0.00'),(547,1,'bhp','05138','Cat gut chromic no 0  kaset','ROL','-',NULL,NULL,'0.00'),(548,1,'bhp','05139','Larutan Kinyoun','BOTOL','-',NULL,NULL,'0.00'),(549,1,'bhp','05140','Larutan Gabet','BOTOL','-',NULL,NULL,'0.00'),(550,1,'bhp','05141','Larutan Metilen biru 50 ml','BOTOL','-',NULL,NULL,'0.00'),(551,1,'bhp','05142','Larutan','BOTOL','-',NULL,NULL,'0.00'),(552,1,'bhp','05143','Pisau Bedah (Bisturi) no 20','KOTAK','-',NULL,NULL,'0.00'),(553,1,'bhp','05144','Handscoon (Ansell) no 6    Steril','PASANG','-',NULL,NULL,'0.00'),(554,1,'bhp','05145','Handscoon (Ansell) no 7,5  Steril','PASANG','-',NULL,NULL,'0.00'),(555,1,'bhp','05146','Handscoon (Ansell) no 7    steril','PASANG','-',NULL,NULL,'0.00'),(556,1,'bhp','05147','Handscoon (Ansell) no 8    Steril','PASANG','-',NULL,NULL,'0.00'),(557,1,'bhp','05148','Jarum Spinal Needle 25G x 3 1/2','PCS','-',NULL,NULL,'0.00'),(558,1,'bhp','05149','Cat Gut Chromic no 1','ROL','-',NULL,NULL,'0.00'),(559,1,'bhp','05150','Cat Gut Chromic no 2','ROL','-',NULL,NULL,'0.00'),(560,1,'bhp','05151','Resuscitator Anak','SET','-',NULL,NULL,'0.00'),(561,1,'bhp','05152','Resuscitator Dewasa','SET','-',NULL,NULL,'0.00'),(562,1,'bhp','05153','Alat suntik sekali pakai 20 ML','PCS','-',NULL,NULL,'0.00'),(563,1,'bhp','05154','Laringoscopes Stad And Fiber Optic','SET','-',NULL,NULL,'0.00'),(564,1,'bhp','05155','Cat gut Plain 3/0 kaset 100 M','ROL','-',NULL,NULL,'0.00'),(565,1,'bhp','05156','Cat gut plain 2/0 kaset 100 M','ROL','-',NULL,NULL,'0.00'),(566,1,'bhp','05157','Cat gut Plain  0 kaset 100 M','ROL','-',NULL,NULL,'0.00'),(567,1,'bhp','05158','Cat gut Plain  1 kaset 50 M','ROL','-',NULL,NULL,'0.00'),(568,1,'bhp','05159','Jelly USG/EKG (Aquasonic)','TUBE','-',NULL,NULL,'0.00'),(569,1,'bhp','05160','Endotracheal tube no 6.5','SET','-',NULL,NULL,'0.00'),(570,1,'bhp','05161','Endotracheal tube no 7.5','SET','-',NULL,NULL,'0.00'),(571,1,'bhp','05162','Endotracheal tube no 7','SET','-',NULL,NULL,'0.00'),(572,1,'bhp','05163','Endotracheal tube no 6','SET','-',NULL,NULL,'0.00'),(573,1,'bhp','05164','Umbilical Cord Clamps','PCS','-',NULL,NULL,'0.00'),(574,1,'bhp','05165','Doek Besar 90 x 125 cm','LEMBAR','-',NULL,NULL,'0.00'),(575,1,'bhp','05166','Doek Besar 60 x 90 cm','LEMBAR','-',NULL,NULL,'0.00'),(576,1,'bhp','05167','NGT no 4','PCS','-',NULL,NULL,'0.00'),(577,1,'bhp','05168','Venflon no 18','PCS','-',NULL,NULL,'0.00'),(578,1,'bhp','05169','Reagen lg G/lg M/ Dengue lg G/lg M (Stick)','TEST','-',NULL,NULL,'0.00'),(579,1,'bhp','05170','Oxygen dalam tabung 40 liter','TABUNG','-',NULL,NULL,'0.00'),(580,1,'bhp','05171','Nedle Heacthing G 3/4 Kulit (Pb 3-1194)','LUSIN','-',NULL,NULL,'0.00'),(581,1,'bhp','05172','Nedle 21Gx11/2','PCS','-',NULL,NULL,'0.00'),(582,1,'bhp','05173','Nedle 23 Gx11/4','PCS','-',NULL,NULL,'0.00'),(583,1,'bhp','05174','HCG Urine stick test','TEST','-',NULL,NULL,'0.00'),(584,1,'bhp','05175','Haemometer','SET','-',NULL,NULL,'0.00'),(585,1,'bhp','05176','Tensimeter','SET','-',NULL,NULL,'0.00'),(586,1,'bhp','05177','Pot Salep 10 gr','POT','-',NULL,NULL,'0.00'),(587,1,'bhp','05178','Plastik Kantong Obat ukuran 35x55 cm','BUNGKUS','-',NULL,NULL,'0.00'),(588,1,'bhp','05179','Alkohol Swab','PCS','-',NULL,NULL,'0.00'),(589,1,'bhp','05180','Label Stiker Obat 10 cmx5cm','LEMBAR','-',NULL,NULL,'0.00'),(590,1,'bhp','05181','Object glass','PCS','-',NULL,NULL,'0.00'),(591,1,'bhp','05182','Etakridin (rivanol)larutan 0,1 % 100 ml','BOTOL','-',NULL,NULL,'0.00'),(592,1,'bhp','05183','PH Paper','BOX','-',NULL,NULL,'0.00'),(593,1,'bhp','05184','Roll Paper','ROL','-',NULL,NULL,'0.00'),(594,1,'bhp','05185','Vacutainer Swab','PCS','-',NULL,NULL,'0.00'),(595,1,'bhp','05186','Micropipette tipis ( yellow tipe )','BOX','-',NULL,NULL,'0.00'),(596,1,'bhp','05187','Xilol / Xilene','BOTOL','-',NULL,NULL,'0.00'),(597,1,'bhp','05188','Imersil Oil Mikroskop 100 ml','BOTOL','-',NULL,NULL,'0.00'),(598,1,'bhp','05189','KOH 10 %','BOTOL','-',NULL,NULL,'0.00'),(599,1,'bhp','05190','Lens Peper','BOX','-',NULL,NULL,'0.00'),(600,1,'bhp','05191','Medicine Packet SI-20','BOX','-',NULL,NULL,'0.00'),(601,1,'bhp','05192','Alkohol Swab','KOTAK','-',NULL,NULL,'0.00'),(602,1,'bhp','05193','Cotton Aplicaton Sterile','BOX','-',NULL,NULL,'0.00'),(603,1,'bhp','05194','Methylated Spirit','BOTOL','-',NULL,NULL,'0.00'),(604,1,'bhp','05195','Klem Tali Pusat Bayi','PCS','-',NULL,NULL,'0.00'),(605,1,'drug','05196','Tialysin plus syr 60 ml','BOTOL','-',NULL,NULL,'0.00'),(606,1,'bhp','05197','Klep Tali Pusat','PCS','-',NULL,NULL,'0.00'),(607,1,'drug','05198','Erithromycin 250 mg','CAPSUL','-',NULL,NULL,'0.00'),(608,1,'bhp','05198','Nedle Heacting B 3/4-12 (Segitiga) ','Lusin','-',NULL,NULL,'0.00'),(609,1,'bhp','05199','Handscoon size S','Pasang','-',NULL,NULL,'0.00'),(610,1,'bhp','05200','Handscoon size L','Pasang','-',NULL,NULL,'0.00'),(611,1,'drug','05201','Propanolol 40 mg','Tablet','-',NULL,NULL,'0.00'),(612,1,'bhp','05201','Alat suntik sekali pakai 10 ml','Pcs','-',NULL,NULL,'0.00'),(613,1,'drug','01011','Klindamicin 150 mg','Capsul','-',NULL,NULL,'0.00'),(614,1,'bhp','05202','Daryant-Tulle','Lembar','-',NULL,NULL,'0.00'),(615,1,'drug','01012','Clindamycin 150 mg','Capsul','-',NULL,NULL,'0.00'),(617,1,'drug','05203','Lanzoprazol kapsul 30 mg','Capsul','-',NULL,NULL,'0.00'),(618,1,'drug','05204','Livron B Plek Tablet','Tablet','-',NULL,NULL,'0.00'),(619,1,'bhp','05203','Kasa Hidrofil steril uk.16x16(isi 16 lbr)','Kotak','-',NULL,NULL,'0.00'),(620,1,'bhp','05204','Kasa Pembalut Hidrofil Steril uk 18x22cm(isi 12lmb)','Kotak','-',NULL,NULL,'0.00'),(621,1,'drug','05205','Cetrizine','Tablet','-',NULL,NULL,'0.00');
/*!40000 ALTER TABLE `ref_drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_educations`
--

DROP TABLE IF EXISTS `ref_educations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_educations` (
  `id` tinyint(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_educations`
--

LOCK TABLES `ref_educations` WRITE;
/*!40000 ALTER TABLE `ref_educations` DISABLE KEYS */;
INSERT INTO `ref_educations` (`id`, `name`, `active`) VALUES (001,'Belum Sekolah','yes'),(002,'SD','yes'),(003,'SMP','yes'),(004,'SMA','yes'),(005,'D3','yes'),(006,'S1','yes'),(007,'S2','yes'),(008,'S3','yes'),(009,'Lain-lain','yes');
/*!40000 ALTER TABLE `ref_educations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_groups`
--

DROP TABLE IF EXISTS `ref_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_groups`
--

LOCK TABLES `ref_groups` WRITE;
/*!40000 ALTER TABLE `ref_groups` DISABLE KEYS */;
INSERT INTO `ref_groups` (`id`, `name`) VALUES (1,'Administrator'),(2,'Dokter');
/*!40000 ALTER TABLE `ref_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_icd_categories`
--

DROP TABLE IF EXISTS `ref_icd_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_icd_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rom` varchar(15) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_icd_categories`
--

LOCK TABLES `ref_icd_categories` WRITE;
/*!40000 ALTER TABLE `ref_icd_categories` DISABLE KEYS */;
INSERT INTO `ref_icd_categories` (`id`, `rom`, `name`) VALUES (1,'I','PENYAKIT INFEKSI PADA USUS'),(2,'II','PENYAKIT TUBERKULOSA'),(3,'III','PENYAKIT BAKTERI'),(4,'IV','INFEKSI AKIBAT HUBUNGAN SEKSUAL'),(5,'V','PENYAKIT VIRUS'),(6,'VI','PENYAKIT JAMUR'),(7,'VII','PENYAKIT PROTOZOA'),(8,'VIII','PENYAKIT KECACINGAN'),(9,'IX','PEDIKULOSIS'),(10,'X','NEOPLASMA MALIGNA'),(11,'XI','NEOPLASMA BERIGNA'),(12,'XII','ANEMIA'),(13,'XIII','GANGGUAN ENDOKRIN, NUTRISI DAN METABOLIK'),(14,'XIV','GANGGUAN MENTAL DAN PERILAKU'),(15,'XV','PENYAKIT SUSUNAN SYARAF'),(16,'XVI','PENYAKIT MATA DAN ADNEKSA'),(17,'XVII','PENYAKIT PADA TELINGA DAN MASTOID'),(18,'XVIII','PENYAKIT PEMBULUH DARAH'),(19,'XIX','PENYAKIT SISTEM PERNAFASAN'),(20,'XX','PENYAKIT PADA RONGGA MULUT, GLANDULA SALIVARIUS DAN RAHANG'),(21,'XXI','PENYAKIT SISTEM SALURAN PENCERNAAN'),(22,'XXII','PENYAKIT KULIT'),(23,'XXIII','PENYAKIT OTOT DAN JARINGAN PENGIKAT'),(24,'XXIV','PENYAKIT SISTEM UROGENITAL'),(25,'XXV','PENYAKIT ORGAN GENITAL LAKI-LAKI'),(26,'XXVI','PENYAKIT ORGAN WANITA'),(27,'XXVII','SEBAB KELAINAN KEBIDANAN LANGSUNG'),(28,'XXVIII','KEADAAN TERTENTU PADA MASA PERINATAL'),(29,'XXIX','KELAINAN KONGENITAL'),(30,'XXX','SISTOMATOLOGI DAN TANPA PADA SISTEM SIRKULASI DAN RESPIRATORIUS'),(31,'XXXI','SIMTOMATOLOGI DAN TANDA PADA SISTEM PENCERNAAN DAN ABDOMEN'),(32,'XXXII','SIMTOMATOLOGI DAN TANDA PADA SISTEM URINARIUS'),(33,'XXXIII','GEJALA DAN TANDA UMUM'),(34,'XXXIV','TRAUMA'),(35,'XXXV','BENDA ASING'),(36,'XXXVI','LUKA BAKAR DAN KOROSIF'),(37,'XXXVII','KERACUNAN & KECELAKAAN'),(38,'XXXVIII','LAIN-LAIN');
/*!40000 ALTER TABLE `ref_icd_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_icd_group`
--

DROP TABLE IF EXISTS `ref_icd_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_icd_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_icd_group`
--

LOCK TABLES `ref_icd_group` WRITE;
/*!40000 ALTER TABLE `ref_icd_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_icd_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_icd_group_detail`
--

DROP TABLE IF EXISTS `ref_icd_group_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_icd_group_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `icd_group_id` int(11) unsigned NOT NULL,
  `icd_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id_icd_id` (`icd_group_id`,`icd_id`) USING BTREE,
  KEY `icd_id` (`icd_id`),
  CONSTRAINT `ref_icd_group_detail_ibfk_2` FOREIGN KEY (`icd_id`) REFERENCES `ref_icds` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ref_icd_group_detail_ibfk_3` FOREIGN KEY (`icd_group_id`) REFERENCES `ref_icd_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_icd_group_detail`
--

LOCK TABLES `ref_icd_group_detail` WRITE;
/*!40000 ALTER TABLE `ref_icd_group_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_icd_group_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_icds`
--

DROP TABLE IF EXISTS `ref_icds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_icds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sp2tp` varchar(15) NOT NULL DEFAULT '',
  `icd_category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `code` varchar(8) DEFAULT NULL,
  `sub_icd` varchar(5) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `wabah` int(1) DEFAULT '0' COMMENT 'klo 1 = wabah',
  `p_nular` int(1) DEFAULT '0' COMMENT 'klo 1 = p nular',
  `p_tdknular` int(1) DEFAULT '0' COMMENT 'klo 1 = p tdk nular',
  `singkat` varchar(10) DEFAULT NULL,
  `sex` int(1) DEFAULT '0' COMMENT 'klo 1=laki, 2 = cew, 0 = umum',
  `kata_kunci` varchar(255) DEFAULT NULL,
  `kelompok` set('umum','kia','gigi') DEFAULT 'umum',
  PRIMARY KEY (`id`),
  KEY `icd` (`code`),
  KEY `icd_category_id` (`icd_category_id`),
  CONSTRAINT `ref_icds_ibfk_1` FOREIGN KEY (`icd_category_id`) REFERENCES `ref_icd_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9816 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_icds`
--

LOCK TABLES `ref_icds` WRITE;
/*!40000 ALTER TABLE `ref_icds` DISABLE KEYS */;
/*!40000 ALTER TABLE `ref_icds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_jobs`
--

DROP TABLE IF EXISTS `ref_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_jobs` (
  `id` tinyint(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_jobs`
--

LOCK TABLES `ref_jobs` WRITE;
/*!40000 ALTER TABLE `ref_jobs` DISABLE KEYS */;
INSERT INTO `ref_jobs` (`id`, `name`, `active`) VALUES (001,'Pegawai Negeri Sipil','yes'),(002,'TNI/ABRI/POLRI','yes'),(003,'Petani','yes'),(004,'Pedagang','yes'),(005,'Ibu Rumah Tangga','yes'),(006,'Pelajar','yes'),(008,'Pensiunan','yes'),(011,'Lain-lain','yes'),(012,'Karyawan','yes'),(013,'BUMN','yes'),(014,'Mahasiswa','yes'),(017,'Guru Swasta / Honor','yes');
/*!40000 ALTER TABLE `ref_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_kelompok_umur`
--

DROP TABLE IF EXISTS `ref_kelompok_umur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_kelompok_umur` (
  `noid` int(2) NOT NULL AUTO_INCREMENT,
  `kelompok_umur` varchar(2) NOT NULL DEFAULT '',
  `sat` char(2) NOT NULL,
  `kelompok_umur1` varchar(2) NOT NULL DEFAULT '',
  `sat1` char(2) NOT NULL,
  PRIMARY KEY (`noid`,`kelompok_umur`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_kelompok_umur`
--

LOCK TABLES `ref_kelompok_umur` WRITE;
/*!40000 ALTER TABLE `ref_kelompok_umur` DISABLE KEYS */;
INSERT INTO `ref_kelompok_umur` (`noid`, `kelompok_umur`, `sat`, `kelompok_umur1`, `sat1`) VALUES (1,'0','h','7','h'),(2,'8','h','28','h'),(3,'1','bl','1','th'),(4,'2','th','4','th'),(5,'5','th','9','th'),(6,'10','th','14','th'),(7,'15','th','19','th'),(8,'20','th','44','th'),(9,'45','th','54','th'),(10,'55','th','59','th'),(11,'60','th','64','th'),(12,'65','th','69','th'),(13,'>','th','70','th');
/*!40000 ALTER TABLE `ref_kelompok_umur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_marital_status`
--

DROP TABLE IF EXISTS `ref_marital_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_marital_status` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_marital_status`
--

LOCK TABLES `ref_marital_status` WRITE;
/*!40000 ALTER TABLE `ref_marital_status` DISABLE KEYS */;
INSERT INTO `ref_marital_status` (`id`, `name`) VALUES (1,'Kawin'),(2,'Belum Kawin'),(3,'Janda'),(4,'Duda');
/*!40000 ALTER TABLE `ref_marital_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_medical_certificate_explanations`
--

DROP TABLE IF EXISTS `ref_medical_certificate_explanations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_medical_certificate_explanations` (
  `id` tinyint(3) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_medical_certificate_explanations`
--

LOCK TABLES `ref_medical_certificate_explanations` WRITE;
/*!40000 ALTER TABLE `ref_medical_certificate_explanations` DISABLE KEYS */;
INSERT INTO `ref_medical_certificate_explanations` (`id`, `name`, `active`) VALUES (001,'Melanjutkan Pendidikan','yes'),(002,'Melamar Pekerjaan','yes'),(003,'Pengangkatan Pegawai','yes'),(004,'Lain-lain','yes');
/*!40000 ALTER TABLE `ref_medical_certificate_explanations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_menu`
--

DROP TABLE IF EXISTS `ref_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ordering` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_menu`
--

LOCK TABLES `ref_menu` WRITE;
/*!40000 ALTER TABLE `ref_menu` DISABLE KEYS */;
INSERT INTO `ref_menu` (`id`, `parent_id`, `level`, `name`, `url`, `ordering`) VALUES (1,0,1,'RME Pasien','#',2),(2,1,2,'Input Data Pemeriksaan Pasien','admission/indoor',2),(5,0,0,'Laporan','#',12),(7,5,1,'Kunjungan','#',5),(8,0,0,'Manajemen Data','#',14),(10,72,2,'Jenis Pasien','admdata/payment',9),(11,8,1,'Profil','admdata/profile',12),(13,78,2,'Tindakan','admdata/treatment',10),(15,80,2,'Operator','admdata/user',15),(16,80,2,'Group','admdata/group',16),(17,8,1,'Menu','admdata/menu',28),(53,5,1,'Pasien','#',6),(57,53,2,'Berdasar Pekerjaan','report/patient_job',2),(58,53,2,'Berdasar Jenis Kelamin','report/patient_sex',3),(66,7,2,'Berdasar Jenis Pasien','report/visit_by_payment_type',3),(72,8,1,'Data Dasar','#',20),(74,72,2,'Pekerjaan','admdata/job',2),(78,8,1,'Data Medis','#',23),(80,8,1,'Pengguna','#',26),(86,0,0,'Keluar','login/logout',26),(87,0,1,'Dashboard','home/dashboard',1),(92,5,1,'10 Besar Penyakit','report/sepuluh_besar',8),(98,103,2,'Distribusi Farmasi','pharmacy/report_drug_in_out',2),(105,102,2,'Obat Masuk Keluar','apotek/report_drug_in_out',4),(107,102,2,'Obat Keluar','report/drug_out',1),(108,8,1,'Tools','#',29),(109,108,2,'Backup & Restore Database','tools/backup_database',1),(111,108,2,'Kosongkan Database','tools/empty_database',15),(112,0,1,'Petunjuk Manual','webroot/Manual_Book_ccare.pdf',27),(114,117,2,'Obat','admdata/drug',1),(117,8,1,'Data Obat','#',24),(118,117,2,'Supplier','admdata/supplier',12),(125,8,1,'Pasien','admdata/patient',18),(126,92,2,'10 Besar Penyakit Anak-Dewasa','report/sepuluh_besar_anak_dewasa',2),(127,92,2,'10 Besar Penyakit','report/sepuluh_besar',1),(138,78,3,'Kelompok Penyakit','admdata/group_icd',12),(139,103,3,'Posisi Stock','pharmacy/report_stock',3),(142,103,3,'Obat Kadaluwarsa','pharmacy/report_stock_expired',4),(143,1,2,'Surat Keterangan Sehat','admission/sks',5),(145,78,3,'Data ICD','admdata/icd',13),(146,103,3,'LPLPO','pharmacy/lplpo',5),(153,5,1,'Kunjungan Pasien','report/kunjungan_pasien_unik',2),(158,103,2,'Laporan 10 Besar Obat Keluar','pharmacy/sepuluh_besar_obat',6),(162,7,3,'Laporan Kunjungan Pasien Berdasarkan Usia','report/kunjungan_golusia',9),(166,7,3,'Lap. Kunjungan Berdasarkan JENKEL ','report/kunjungan_sex_patients',10),(168,0,1,'Video c-Care','webroot/ccare.avi',28),(169,5,2,'Sensus Pasien','report/visit_sensus',9),(170,0,1,'Billing','#',3),(171,170,1,'Antrian Billing','kasir/queue',1),(172,170,2,'Rekap Harian','kasir/harian',2),(173,170,2,'Rekap Tagihan Pasien','kasir/rekap_pasien',3),(174,5,1,'Kirim Laporan E-Claim','#',13),(175,174,3,'Lap. Rujukan','report/lap_rujukan',3),(176,174,3,'Laporan Jamkesmas','report/lap_jamkesmas',2),(177,174,3,'Laporan Morbiditas','report/lap_morbiditas',1),(179,5,2,'Laporan Morbiditas','report/print_morbiditas',10),(180,5,2,'Laporan Jamkesmas','report/print_jamkesmas',11),(181,5,2,'Laporan Rujukan','report/print_rujukan',12);
/*!40000 ALTER TABLE `ref_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_modules`
--

DROP TABLE IF EXISTS `ref_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `group` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `ordering` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group`,`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_modules`
--

LOCK TABLES `ref_modules` WRITE;
/*!40000 ALTER TABLE `ref_modules` DISABLE KEYS */;
INSERT INTO `ref_modules` (`id`, `name`, `group`, `filename`, `ordering`) VALUES (1,'General Checkup','visit','general_checkup',1),(2,'Surat Keterangan Sehat','visit','medical_certificate',2),(3,'Surat Keterangan Sakit','visit','sickness_explanation',3),(4,'History','visit','history',10),(5,'Pregnant','pregnant','pregnant',1),(6,'Nifas','pregnant','nifas',7),(7,'Neonatal','pregnant','neonatal',8),(9,'Kunjungan Kehamilan','visit_pregnant','visit_pregnant',5),(10,'Asuhan','keperawatan','asuhan',1),(11,'Observasi','observasi','observasi',1),(12,'Permintaan Pemeriksaan Lab','visit','pemeriksaan_lab',9),(13,'Pemeriksaan Lab','lab','pemeriksaan_lab',1),(14,'Resep','reseponline','reseponline',1),(15,'Resep','resepoffline','resepoffline',2),(17,'History','reseponline','reseponlinehistory',3),(18,'General Checkup','inpatient','general_checkup',2),(19,'Keperawatan','inpatient','keperawatan',3),(20,'Observasi Cairan','inpatient','observasi_cairan',4),(22,'Dashboard','inpatient','dashboard',1),(23,'Permintaan Pemeriksaan Lab','visit','rawatinap_pemeriksaan_lab',9),(24,'Pemeriksaan KB Baru','kia','kb',2),(25,'Pemeriksaan KB Ulang','kia','kb_ulang',3),(26,'Imunisasi','kia','imunisasi',0),(27,'Riwayat Kehamilan','kia','hamil',2),(28,'Pemeriksaan Kehamilan','kia','hamil_ulang',3),(29,'Bersalin','kia','bersalin',3),(30,'Pemeriksaan Nifas','kia','nifas',3),(31,'Pemeriksaan Neonatus','kia','neonatus',4),(32,'Pemeriksaan Caten','kia','caten',0);
/*!40000 ALTER TABLE `ref_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_payment_types`
--

DROP TABLE IF EXISTS `ref_payment_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_payment_types` (
  `id` tinyint(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `id_dinas` char(2) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_payment_types`
--

LOCK TABLES `ref_payment_types` WRITE;
/*!40000 ALTER TABLE `ref_payment_types` DISABLE KEYS */;
INSERT INTO `ref_payment_types` (`id`, `id_dinas`, `name`, `active`) VALUES (01,'01','UMUM','yes'),(02,'02','ASKES PNS','yes'),(03,'03','JPS','yes'),(04,NULL,'JAMKESDA','yes'),(05,NULL,'JPKM','yes'),(06,NULL,'Sekolah','yes'),(07,NULL,'Gratis','yes'),(08,NULL,'JAMKESPROV','yes'),(09,NULL,'JAMPERSAL','yes');
/*!40000 ALTER TABLE `ref_payment_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_pemeriksaan_lab`
--

DROP TABLE IF EXISTS `ref_pemeriksaan_lab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_pemeriksaan_lab` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pemeriksaan_lab_category_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `nilai_minimum` decimal(10,2) NOT NULL,
  `nilai_maximum` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ordering` int(11) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pemeriksaan_lab_category_id` (`pemeriksaan_lab_category_id`),
  CONSTRAINT `ref_pemeriksaan_lab_ibfk_1` FOREIGN KEY (`pemeriksaan_lab_category_id`) REFERENCES `ref_pemeriksaan_lab_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_pemeriksaan_lab`
--

LOCK TABLES `ref_pemeriksaan_lab` WRITE;
/*!40000 ALTER TABLE `ref_pemeriksaan_lab` DISABLE KEYS */;
INSERT INTO `ref_pemeriksaan_lab` (`id`, `pemeriksaan_lab_category_id`, `name`, `satuan`, `nilai_minimum`, `nilai_maximum`, `price`, `ordering`) VALUES (29,1,'RBC','10e6/ul','4.00','5.50','0.00',0),(30,1,'HCT','%','36.00','48.00','0.00',0),(31,1,'MCV','um3','80.00','100.00','0.00',0),(32,1,'RDW','%','12.00','15.00','0.00',0),(33,1,'HGB','g/dl','12.00','16.00','0.00',0),(34,1,'MCH','pg','26.00','34.00','0.00',0),(35,1,'MCHC','g/dl','32.00','36.00','0.00',0),(36,1,'PLT','10e3/ul','150.00','400.00','0.00',0),(37,1,'PCT','%','0.01','9.99','0.00',0),(38,1,'MPV','um3','7.60','10.80','0.00',0),(39,1,'PDW','um3','0.10','99.90','0.00',0),(40,1,'WBC','10e3/ul','4.50','10.00','0.00',0),(41,1,'LYMF','10e3/ul','1.20','3.50','0.00',0),(42,1,'MID','10e3/ul','0.10','1.00','0.00',0),(43,1,'GRAN','10e3/ul','1.40','7.00','0.00',0),(44,1,'Masa Pendarahan (BT)','Menit','1.00','6.00','0.00',0),(45,1,'Masa Pembekuan (CT)','Menit','2.00','10.00','0.00',0),(46,1,'Malaria',NULL,'0.00','0.00','0.00',0),(47,1,'Filaria',NULL,'0.00','0.00','0.00',0),(48,1,'Golongan Darah',NULL,'0.00','0.00','0.00',0),(49,1,'Pem. Silang (Cross)',NULL,'0.00','0.00','0.00',0),(50,3,'Warna / Kejernihan',NULL,'0.00','0.00','0.00',0),(52,3,'Protein',NULL,'0.00','0.00','0.00',0),(53,3,'Reduksi',NULL,'0.00','0.00','0.00',0),(54,3,'Urobilin',NULL,'0.00','0.00','0.00',0),(55,3,'Bilirubin',NULL,'0.00','0.00','0.00',0),(56,3,'Darah Samar ',NULL,'0.00','0.00','0.00',0),(58,12,'Lecosit','L/P','0.00','0.00','0.00',0),(59,12,'Epitel','L/P','0.00','0.00','0.00',0),(60,12,'Kristal',NULL,'0.00','0.00','0.00',0),(61,12,'Slinder',NULL,'0.00','0.00','0.00',0),(62,13,'Konsistensi','Lembek','0.00','0.00','0.00',0),(63,13,'Lendir','Negatif','0.00','0.00','0.00',0),(64,13,'Darah','Negatif','0.00','0.00','0.00',0),(65,13,'Eritrosit','Negatif','0.00','0.00','0.00',0),(66,13,'Lecosit','L/P','0.00','0.00','0.00',0),(67,13,'Amoeba','Negatif','0.00','0.00','0.00',0),(68,13,'Krista','Negatif','0.00','0.00','0.00',0),(69,13,'Askaris','Negatif','0.00','0.00','0.00',0),(70,13,'Ankylostoma','Negatif','0.00','0.00','0.00',0),(71,13,'Trichoris Trichiuma','Negatif','0.00','0.00','0.00',0),(72,8,'Gravindex',NULL,'0.00','0.00','0.00',0),(73,14,'Secret Uretra / Vagina',NULL,'0.00','0.00','0.00',0),(74,9,'Pemeriksaan BTA A (sewaktu)',NULL,'0.00','0.00','0.00',0),(75,9,'Pemeriksaan BTA B (Pagi)',NULL,'0.00','0.00','0.00',0),(76,9,'Pemeriksaan BTA C (sewaktu)',NULL,'0.00','0.00','0.00',0),(77,13,'Lendir','Negatif','0.00','0.00','0.00',0),(79,12,'Eritrosit','L/P','0.00','0.00','0.00',0),(81,3,'PH','','5.00','9.00','0.00',0),(82,3,'Albumin','','0.00','0.00','0.00',0),(84,1,'GRAN    (  %  )','   %','50.00','70.00','0.00',0),(85,1,'MID   (   %  )','   %','2.00','10.00','0.00',0),(86,1,'LYMF    (   %  )','   %','20.00','40.00','0.00',0);
/*!40000 ALTER TABLE `ref_pemeriksaan_lab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_pemeriksaan_lab_categories`
--

DROP TABLE IF EXISTS `ref_pemeriksaan_lab_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_pemeriksaan_lab_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `ordering` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_pemeriksaan_lab_categories`
--

LOCK TABLES `ref_pemeriksaan_lab_categories` WRITE;
/*!40000 ALTER TABLE `ref_pemeriksaan_lab_categories` DISABLE KEYS */;
INSERT INTO `ref_pemeriksaan_lab_categories` (`id`, `name`, `ordering`) VALUES (1,'Darah',1),(2,'Gula Darah',7),(3,'Urine',2),(4,'Faal Hati',8),(5,'Lemak',9),(6,'Faal Ginjal',10),(7,'Imun Serologi',11),(8,'Kehamilan',3),(9,'Dahak',12),(10,'Permintaan Pemeriksaan USG',13),(11,'Permintaan Pemeriksaan ECG',14),(12,'Sendiment',4),(13,'Feaces',5),(14,'Secret Uretra/Vagina',6);
/*!40000 ALTER TABLE `ref_pemeriksaan_lab_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_poedji_rochjati`
--

DROP TABLE IF EXISTS `ref_poedji_rochjati`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_poedji_rochjati` (
  `id` tinyint(3) unsigned zerofill NOT NULL,
  `category` tinyint(3) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `score` tinyint(3) NOT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_poedji_rochjati`
--

LOCK TABLES `ref_poedji_rochjati` WRITE;
/*!40000 ALTER TABLE `ref_poedji_rochjati` DISABLE KEYS */;
INSERT INTO `ref_poedji_rochjati` (`id`, `category`, `name`, `score`, `active`) VALUES (001,1,'Skor Awal Ibu Hamil',2,'yes'),(002,1,'Terlalu Muda Hamil < 16 th',4,'yes'),(003,1,'Terlalu Tua Hamil > 35 th',4,'yes'),(004,1,'Terlalu Lambat Hamil | kawin > 4 th',4,'yes'),(005,1,'Terlalu Lama Hamil Lagi ( > 10 th)',4,'yes'),(006,1,'Terlalu Cepat Hamil lagi (< 2 th)',4,'yes'),(007,1,'Terlalu Banyak Anak, 4/lebih',4,'yes'),(008,1,'Terlalu Pendek < 145 cm',4,'yes'),(009,1,'Pernah Gagal Kehamilan',4,'yes'),(010,1,'Pernah di Vakum/Tarikan Tang',4,'yes'),(011,1,'Uri Dirogoh',4,'yes'),(012,1,'Pernah di beri transfusi',4,'yes'),(013,1,'Pernah di Operasi Sesar',8,'yes'),(014,2,'Kurang Darah',4,'yes'),(016,2,'Malaria',4,'yes'),(017,2,'TBC Paru',4,'yes'),(018,2,'Payah Jantung',4,'yes'),(019,2,'Kencing Manis',4,'yes'),(020,2,'Penyakit Menular Seksual',4,'yes'),(021,3,'Bengkak Pada Muka/Tungkai dan Hipertensi',4,'yes'),(022,3,'Hamil Kembar 2 atau lebih',4,'yes'),(023,3,'Hamil Kembar Air',4,'yes'),(024,3,'Bayi Mati dalam Kandungan',4,'yes'),(025,3,'Kehamilan Lebih Bulan',4,'yes'),(026,3,'Letak Sungsang',8,'yes'),(027,3,'Letak Lintang',8,'yes'),(028,3,'Pendarahan Pada Kehamilan ini',8,'yes'),(029,3,'Pre Eklampsia Berat/ Kejang-kejang',8,'yes');
/*!40000 ALTER TABLE `ref_poedji_rochjati` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_profiles`
--

DROP TABLE IF EXISTS `ref_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_profiles` (
  `code` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `spesialisasi` varchar(255) NOT NULL COMMENT 'spesialisasi dokternya',
  `name` varchar(100) NOT NULL DEFAULT '',
  `no_str` varchar(60) NOT NULL DEFAULT '',
  `awal_berlaku_str` date NOT NULL DEFAULT '0000-00-00',
  `akhir_berlaku_str` date NOT NULL DEFAULT '0000-00-00',
  `no_sip` varchar(60) NOT NULL DEFAULT '',
  `awal_berlaku_sip` date NOT NULL DEFAULT '0000-00-00',
  `akhir_berlaku_sip` date NOT NULL DEFAULT '0000-00-00',
  `address` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(70) DEFAULT NULL COMMENT 'email dokter',
  `photo` varchar(100) NOT NULL DEFAULT '',
  `screensaver` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `screensaver_delay` int(10) unsigned NOT NULL,
  `report_header_1` varchar(100) DEFAULT NULL,
  `id_register` int(11) DEFAULT NULL COMMENT 'Id Register  Aplikasi  c-Care',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_profiles`
--

LOCK TABLES `ref_profiles` WRITE;
/*!40000 ALTER TABLE `ref_profiles` DISABLE KEYS */;
INSERT INTO `ref_profiles` (`code`, `spesialisasi`, `name`, `no_str`, `awal_berlaku_str`, `akhir_berlaku_str`, `no_sip`, `awal_berlaku_sip`, `akhir_berlaku_sip`, `address`, `phone`, `email`, `photo`, `screensaver`, `screensaver_delay`, `report_header_1`, `id_register`) VALUES (1,'Dokter Penyakit Dalam','dr. Paijo Dimejo Prawiro, Sp.OG, P.hd','123456789 001','2012-01-01','2017-01-01','987654321 001','2017-01-04','0000-00-00','Samirono Baru 58, CCT, Depok, Sleman, DIY','081328xxxxx',NULL,'c_logo.gif','logosisfo.png',600000,'PRAKTEK DOKTER',NULL);
/*!40000 ALTER TABLE `ref_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_spesialisasi_tipe`
--

DROP TABLE IF EXISTS `ref_spesialisasi_tipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_spesialisasi_tipe` (
  `id` tinyint(2) unsigned zerofill NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='Spesialisasi dokternya';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_spesialisasi_tipe`
--

LOCK TABLES `ref_spesialisasi_tipe` WRITE;
/*!40000 ALTER TABLE `ref_spesialisasi_tipe` DISABLE KEYS */;
INSERT INTO `ref_spesialisasi_tipe` (`id`, `name`, `active`) VALUES (01,'Dokter Umum','yes'),(02,'Dokter Penyakit Dalam','yes');
/*!40000 ALTER TABLE `ref_spesialisasi_tipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_suppliers`
--

DROP TABLE IF EXISTS `ref_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_suppliers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_suppliers`
--

LOCK TABLES `ref_suppliers` WRITE;
/*!40000 ALTER TABLE `ref_suppliers` DISABLE KEYS */;
INSERT INTO `ref_suppliers` (`id`, `name`) VALUES (1,'PT KALBE FARMA');
/*!40000 ALTER TABLE `ref_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_treatment_categories`
--

DROP TABLE IF EXISTS `ref_treatment_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_treatment_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_treatment_categories`
--

LOCK TABLES `ref_treatment_categories` WRITE;
/*!40000 ALTER TABLE `ref_treatment_categories` DISABLE KEYS */;
INSERT INTO `ref_treatment_categories` (`id`, `name`) VALUES (1,'PENGOBATAN UMUM/KONSULTASI');
/*!40000 ALTER TABLE `ref_treatment_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_treatment_price`
--

DROP TABLE IF EXISTS `ref_treatment_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_treatment_price` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `treatment_id` int(11) unsigned zerofill NOT NULL,
  `payment_type_id` tinyint(3) unsigned zerofill NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `treatment_id_2` (`treatment_id`,`payment_type_id`),
  KEY `treatment_id` (`treatment_id`),
  KEY `payment_type_id` (`payment_type_id`),
  CONSTRAINT `ref_treatment_price_ibfk_1` FOREIGN KEY (`treatment_id`) REFERENCES `ref_treatments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ref_treatment_price_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `ref_payment_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3475 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_treatment_price`
--

LOCK TABLES `ref_treatment_price` WRITE;
/*!40000 ALTER TABLE `ref_treatment_price` DISABLE KEYS */;
INSERT INTO `ref_treatment_price` (`id`, `treatment_id`, `payment_type_id`, `price`) VALUES (3469,00000000246,001,'50000.00'),(3470,00000000246,002,'45000.00'),(3471,00000000246,003,'50000.00'),(3472,00000000247,001,'15000.00'),(3473,00000000247,002,'15000.00'),(3474,00000000247,003,'15000.00');
/*!40000 ALTER TABLE `ref_treatment_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ref_treatments`
--

DROP TABLE IF EXISTS `ref_treatments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref_treatments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `treatment_category_id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `treatment_category_id` (`treatment_category_id`),
  CONSTRAINT `ref_treatments_ibfk_1` FOREIGN KEY (`treatment_category_id`) REFERENCES `ref_treatment_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_treatments`
--

LOCK TABLES `ref_treatments` WRITE;
/*!40000 ALTER TABLE `ref_treatments` DISABLE KEYS */;
INSERT INTO `ref_treatments` (`id`, `treatment_category_id`, `name`, `price`) VALUES (246,1,'Konsultasi Dokter','0.00'),(247,1,'Surat Rujukan','0.00');
/*!40000 ALTER TABLE `ref_treatments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tools_backup_database`
--

DROP TABLE IF EXISTS `tools_backup_database`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tools_backup_database` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `filename` varchar(100) NOT NULL,
  `filesize` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools_backup_database`
--

LOCK TABLES `tools_backup_database` WRITE;
/*!40000 ALTER TABLE `tools_backup_database` DISABLE KEYS */;
INSERT INTO `tools_backup_database` (`id`, `name`, `date`, `filename`, `filesize`) VALUES (1,'180313','2013-03-18 00:44:26','backup_2013-03-18_07-44-23.sql','1090771'),(2,'18 Maret 2013','2013-03-18 14:20:03','backup_2013-03-18_21-20-00.sql','1090036');
/*!40000 ALTER TABLE `tools_backup_database` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tools_empty_database`
--

DROP TABLE IF EXISTS `tools_empty_database`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tools_empty_database` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools_empty_database`
--

LOCK TABLES `tools_empty_database` WRITE;
/*!40000 ALTER TABLE `tools_empty_database` DISABLE KEYS */;
INSERT INTO `tools_empty_database` (`id`, `name`, `date`) VALUES (1,'tes','2013-03-18 02:48:01');
/*!40000 ALTER TABLE `tools_empty_database` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treatments`
--

DROP TABLE IF EXISTS `treatments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treatments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `visit_id` bigint(20) unsigned DEFAULT NULL,
  `visit_inpatient_detail_id` bigint(20) unsigned DEFAULT NULL,
  `treatment_id` int(11) unsigned NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `cost` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `date` datetime NOT NULL,
  `log` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `visit_id` (`visit_id`),
  KEY `treatment_id` (`treatment_id`),
  KEY `visit_inpatient_detail_id` (`visit_inpatient_detail_id`),
  CONSTRAINT `treatments_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `visits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `treatments_ibfk_2` FOREIGN KEY (`treatment_id`) REFERENCES `ref_treatments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `treatments_ibfk_3` FOREIGN KEY (`visit_inpatient_detail_id`) REFERENCES `visits_inpatient_detail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatments`
--

LOCK TABLES `treatments` WRITE;
/*!40000 ALTER TABLE `treatments` DISABLE KEYS */;
INSERT INTO `treatments` (`id`, `visit_id`, `visit_inpatient_detail_id`, `treatment_id`, `name`, `cost`, `date`, `log`) VALUES (10,2,NULL,247,'Surat Rujukan','15000.00','2013-03-18 13:18:45','no'),(11,2,NULL,246,'Konsultasi Dokter','45000.00','2013-03-18 13:18:45','no'),(12,3,NULL,246,'Konsultasi Dokter','45000.00','2013-03-18 17:50:46','no'),(13,3,NULL,247,'Surat Rujukan','15000.00','2013-03-18 17:50:46','no'),(14,4,NULL,246,'Konsultasi Dokter','45000.00','2013-03-19 04:25:30','no'),(15,5,NULL,246,'Konsultasi Dokter','45000.00','2013-03-19 04:32:38','no'),(16,6,NULL,246,'Konsultasi Dokter','50000.00','2013-03-19 04:57:15','no'),(17,7,NULL,247,'Surat Rujukan','15000.00','2013-03-19 05:02:14','no'),(18,8,NULL,247,'','0.00','2013-03-19 05:04:14','no'),(19,9,NULL,247,'','0.00','2013-03-19 05:09:17','no');
/*!40000 ALTER TABLE `treatments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) unsigned DEFAULT NULL,
  `clinic_id` int(11) unsigned DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `login_count` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `clinic_id`, `username`, `pwd`, `name`, `email`, `last_login`, `login_count`) VALUES (1,1,NULL,'admin','ac43724f16e9241d990427ab7c8f4228','Administrator','','2013-03-19 03:48:16',53),(2,2,NULL,'harryvieri','0079fcb602361af76c4fd616d60f9414','dr. Harryvieri Sun, Sp.oG, P.hd','sunandarharry@gmail.com','2012-03-07 16:59:56',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `view_drugs`
--

DROP TABLE IF EXISTS `view_drugs`;
/*!50001 DROP VIEW IF EXISTS `view_drugs`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_drugs` (
  `drug_id` int(11) unsigned,
  `drug` varchar(100),
  `code` varchar(5),
  `unit` varchar(20)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_menu`
--

DROP TABLE IF EXISTS `view_menu`;
/*!50001 DROP VIEW IF EXISTS `view_menu`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_menu` (
  `parent_id` int(11) unsigned,
  `id` int(11) unsigned,
  `parent_name` varchar(255),
  `name` varchar(255),
  `parent_url` varchar(255),
  `url` varchar(255),
  `parent_ordering` int(11) unsigned,
  `child_ordering` int(11) unsigned
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_parent_menu`
--

DROP TABLE IF EXISTS `view_parent_menu`;
/*!50001 DROP VIEW IF EXISTS `view_parent_menu`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_parent_menu` (
  `id` int(11) unsigned,
  `parent_id` int(11) unsigned,
  `name` varchar(255),
  `url` varchar(255),
  `ordering` int(11) unsigned
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_ref_drugs`
--

DROP TABLE IF EXISTS `view_ref_drugs`;
/*!50001 DROP VIEW IF EXISTS `view_ref_drugs`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_ref_drugs` (
  `drug_id` int(11) unsigned,
  `drug` varchar(100),
  `code` varchar(5),
  `unit` varchar(20)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_ref_profiles`
--

DROP TABLE IF EXISTS `view_ref_profiles`;
/*!50001 DROP VIEW IF EXISTS `view_ref_profiles`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_ref_profiles` (
  `name` varchar(100),
  `spesialisasi` varchar(255),
  `no_str` varchar(60),
  `awal_str` varchar(10),
  `akhir_str` varchar(10),
  `no_sip` varchar(60),
  `awal_sip` varchar(10),
  `akhir_sip` varchar(10),
  `address` varchar(100),
  `phone` varchar(100),
  `photo` varchar(100),
  `screensaver` varchar(100),
  `screensaver_delay` int(10) unsigned,
  `report_header_1` varchar(100)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `family_folder` int(6) unsigned zerofill NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `payment_type_id` tinyint(3) unsigned zerofill NOT NULL,
  `insurance_no` varchar(255) DEFAULT NULL,
  `nama_asuransi` varchar(100) DEFAULT NULL,
  `address` varchar(100) NOT NULL DEFAULT '',
  `no_kontak` varchar(30) NOT NULL,
  `job_id` tinyint(3) unsigned zerofill DEFAULT NULL,
  `resume` varchar(255) NOT NULL DEFAULT '',
  `continue_id` tinyint(2) unsigned zerofill DEFAULT NULL,
  `served` enum('yes','no') NOT NULL DEFAULT 'no',
  `continue_to` varchar(255) DEFAULT NULL,
  `specialis` varchar(150) DEFAULT NULL,
  `paramedic` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `user_id` (`user_id`),
  KEY `payment_type_id` (`payment_type_id`),
  KEY `job_id` (`job_id`),
  KEY `family_folder` (`family_folder`),
  CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`family_folder`) REFERENCES `patients` (`family_folder`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visits_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visits_ibfk_4` FOREIGN KEY (`payment_type_id`) REFERENCES `ref_payment_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visits_ibfk_8` FOREIGN KEY (`job_id`) REFERENCES `ref_jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
INSERT INTO `visits` (`id`, `family_folder`, `date`, `user_id`, `payment_type_id`, `insurance_no`, `nama_asuransi`, `address`, `no_kontak`, `job_id`, `resume`, `continue_id`, `served`, `continue_to`, `specialis`, `paramedic`) VALUES (1,000001,'2013-03-18 13:05:00',1,002,'34235534646','Inhealth','Samimapan, CT depok, sleman','081123423535',013,'',NULL,'no',NULL,NULL,'dr. Harryvieri Sun, Sp.oG, P.hd'),(2,000001,'2013-03-18 13:18:00',1,002,'34235534646','Inhealth','Samimapan, Ct Depok, Sleman','081123423535',013,'',NULL,'no',NULL,NULL,'dr. Harryvieri Sun, Sp.oG, P.hd'),(3,000002,'2013-03-18 17:50:00',1,004,'2424124124','-','Samimapan , Condong Catur ','081328181312',005,'',NULL,'no',NULL,NULL,'dr. Harryvieri Sun, Sp.oG, P.hd'),(4,000003,'2013-03-19 04:25:00',1,002,'97979770997','Inhealth','Perum dayu b5','0821421412412',012,'',03,'no','Panti Rapih','Gigi','dr. Harryvieri Sun, Sp.oG, P.hd'),(5,000004,'2013-03-19 04:32:00',1,001,'','','samimapan ct cc ','-',011,'',03,'no','Betesda','Penyakit DAlam','dr. Harryvieri Sun, Sp.oG, P.hd'),(6,000002,'2013-03-19 04:57:00',1,002,'2424124124','-','Samimapan , Condong Catur ','081328181312',005,'',NULL,'no',NULL,NULL,NULL),(7,000005,'2013-03-19 05:02:00',1,001,'','','BANTUL','045346346346',013,'',13,'no',NULL,NULL,NULL),(8,000001,'2013-03-19 05:04:00',1,001,'34235534646','Inhealth','Samimapan, Ct Depok, Sleman','081123423535',013,'',03,'no',NULL,NULL,NULL),(9,000003,'2013-03-19 05:09:00',1,002,'97979770997','Inhealth','Perum Dayu B5','0821421412412',012,'',03,'no','Betesda','Gigi','dr. Harryvieri Sun, Sp.oG, P.hd'),(10,000001,'2013-03-19 05:47:00',1,002,'34235534646','Inhealth','Samimapan, Ct Depok, Sleman','081123423535',013,'',03,'no','PKU Muhammadiyah','Jantung','Administrator');
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `view_drugs`
--

/*!50001 DROP TABLE `view_drugs`*/;
/*!50001 DROP VIEW IF EXISTS `view_drugs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_drugs` AS select `rd`.`id` AS `drug_id`,`rd`.`name` AS `drug`,`rd`.`code` AS `code`,`rd`.`unit` AS `unit` from `ref_drugs` `rd` group by `rd`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_menu`
--

/*!50001 DROP TABLE `view_menu`*/;
/*!50001 DROP VIEW IF EXISTS `view_menu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_menu` AS select `menu_child`.`parent_id` AS `parent_id`,`menu_child`.`id` AS `id`,`menu_parent`.`name` AS `parent_name`,`menu_child`.`name` AS `name`,`menu_parent`.`url` AS `parent_url`,`menu_child`.`url` AS `url`,`menu_parent`.`ordering` AS `parent_ordering`,`menu_child`.`ordering` AS `child_ordering` from ((`ref_menu` `menu_child` join `view_parent_menu` `menu_parent` on((`menu_parent`.`id` = `menu_child`.`parent_id`))) join `group_menu` `gm` on((`gm`.`menu_id` = `menu_child`.`id`))) group by `menu_child`.`id` order by `menu_parent`.`ordering`,`menu_child`.`ordering` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_parent_menu`
--

/*!50001 DROP TABLE `view_parent_menu`*/;
/*!50001 DROP VIEW IF EXISTS `view_parent_menu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_parent_menu` AS select `ref_menu`.`id` AS `id`,`ref_menu`.`parent_id` AS `parent_id`,`ref_menu`.`name` AS `name`,`ref_menu`.`url` AS `url`,`ref_menu`.`ordering` AS `ordering` from `ref_menu` where isnull(`ref_menu`.`parent_id`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_ref_drugs`
--

/*!50001 DROP TABLE `view_ref_drugs`*/;
/*!50001 DROP VIEW IF EXISTS `view_ref_drugs`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_ref_drugs` AS select `rd`.`id` AS `drug_id`,`rd`.`name` AS `drug`,`rd`.`code` AS `code`,`rd`.`unit` AS `unit` from `ref_drugs` `rd` group by `rd`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_ref_profiles`
--

/*!50001 DROP TABLE `view_ref_profiles`*/;
/*!50001 DROP VIEW IF EXISTS `view_ref_profiles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = latin1 */;
/*!50001 SET character_set_results     = latin1 */;
/*!50001 SET collation_connection      = latin1_swedish_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_ref_profiles` AS select `rp`.`name` AS `name`,`rp`.`spesialisasi` AS `spesialisasi`,`rp`.`no_str` AS `no_str`,date_format(`rp`.`awal_berlaku_str`,'%d/%m/%Y') AS `awal_str`,date_format(`rp`.`akhir_berlaku_str`,'%d/%m/%Y') AS `akhir_str`,`rp`.`no_sip` AS `no_sip`,date_format(`rp`.`awal_berlaku_sip`,'%d/%m/%Y') AS `awal_sip`,date_format(`rp`.`akhir_berlaku_sip`,'%d/%m/%Y') AS `akhir_sip`,`rp`.`address` AS `address`,`rp`.`phone` AS `phone`,`rp`.`photo` AS `photo`,`rp`.`screensaver` AS `screensaver`,`rp`.`screensaver_delay` AS `screensaver_delay`,`rp`.`report_header_1` AS `report_header_1` from `ref_profiles` `rp` */;
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

-- Dump completed on 2013-03-18 23:16:45