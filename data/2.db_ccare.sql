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
INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `session_data`) VALUES ('0456b85e7ce732a80d6f25f51475d45a','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64; rv:19.0) Gecko',1363638932,'a:4:{s:2:\"id\";s:1:\"1\";s:3:\"pwd\";s:32:\"ac43724f16e9241d990427ab7c8f4228\";s:4:\"name\";s:13:\"Administrator\";s:8:\"group_id\";s:1:\"1\";}'),('4a0c11052768775d8e2a19d86ebbdcb3','127.0.0.1','Mozilla/5.0 (Windows NT 6.2; WOW64; rv:19.0) Gecko',1363649166,'a:5:{s:2:\"id\";s:1:\"1\";s:3:\"pwd\";s:32:\"ac43724f16e9241d990427ab7c8f4228\";s:4:\"name\";s:13:\"Administrator\";s:8:\"group_id\";s:1:\"1\";s:12:\"report_param\";a:13:{s:15:\"payment_type_id\";s:0:\"\";s:13:\"kelompok_umur\";s:0:\"\";s:3:\"sex\";s:0:\"\";s:4:\"unit\";s:3:\"day\";s:9:\"day_start\";s:2:\"18\";s:11:\"month_start\";s:1:\"3\";s:10:\"year_start\";s:4:\"2013\";s:7:\"day_end\";s:2:\"19\";s:9:\"month_end\";s:1:\"3\";s:8:\"year_end\";s:4:\"2013\";s:8:\"icd_code\";a:1:{i:0;s:0:\"\";}s:8:\"icd_name\";a:1:{i:0;s:0:\"\";}s:6:\"icd_id\";a:1:{i:0;s:0:\"\";}}}');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expert_anamnese_diagnose_details`
--

LOCK TABLES `expert_anamnese_diagnose_details` WRITE;
/*!40000 ALTER TABLE `expert_anamnese_diagnose_details` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expert_anamnese_diagnoses`
--

LOCK TABLES `expert_anamnese_diagnoses` WRITE;
/*!40000 ALTER TABLE `expert_anamnese_diagnoses` DISABLE KEYS */;
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
INSERT INTO `ref_anamneses` (`id`, `name`) VALUES (13,'-'),(5,'BATUK, PILEK'),(3,'Demam 3 hari, Nafsu makan kurang'),(9,'demam 4 hari'),(7,'demam sangat tinggi sekali 3 hari'),(2,'Gigi cenut-cenut'),(10,'OK AJA TUCHH'),(12,'pusing terus'),(11,'pusing, batuk'),(1,'Pusing, demam, panas dingin'),(6,'pusing, pilek'),(8,'pusing, pilek, demam, batuk');
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
  `code` varchar(10) NOT NULL,
  `name` varchar(200) NOT NULL DEFAULT '',
  `unit` varchar(20) DEFAULT NULL,
  `supplier` varchar(255) NOT NULL DEFAULT '-',
  `expired_date` varchar(255) DEFAULT NULL,
  `unit_terbesar` varchar(255) DEFAULT NULL,
  `jml_per_unit_terbesar` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `ref_drugs_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `ref_suppliers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16384 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_drugs`
--

LOCK TABLES `ref_drugs` WRITE;
/*!40000 ALTER TABLE `ref_drugs` DISABLE KEYS */;
INSERT INTO `ref_drugs` (`id`, `supplier_id`, `category`, `code`, `name`, `unit`, `supplier`, `expired_date`, `unit_terbesar`, `jml_per_unit_terbesar`) VALUES (12701,NULL,'drug','DRx0013059','NUTRILON SOYA 4','Bubuk','Nutricia',NULL,NULL,'0.00'),(12702,NULL,'drug','DRx0013060','NUTRIMA','Bubuk','Nutricia',NULL,NULL,'0.00'),(12703,NULL,'drug','DRx0013061','NUTRIMA','Bubuk','Nutricia',NULL,NULL,'0.00'),(12704,NULL,'drug','DRx0013062','NUTRIMA 1+','Bubuk','Nutricia',NULL,NULL,'0.00'),(12705,NULL,'drug','DRx0013063','NUTRIMA 4+','Bubuk','Nutricia',NULL,NULL,'0.00'),(12706,NULL,'drug','DRx0013064','NUTRIMA KID','Bubuk','Nutricia',NULL,NULL,'0.00'),(12707,NULL,'drug','DRx0013065','NUTRIMA KID','Bubuk','Nutricia',NULL,NULL,'0.00'),(12708,NULL,'drug','DRx0013066','NUTRIMA MADU','Bubuk','Nutricia',NULL,NULL,'0.00'),(12709,NULL,'drug','DRx0013067','NUTRISOL-S 5%','Lar Infus','Mitsubishi Pharma Guangzhou',NULL,NULL,'0.00'),(12710,NULL,'drug','DRx0013068','NUTRISON','Bubuk','Nutricia',NULL,NULL,'0.00'),(12711,NULL,'drug','DRx0013069','NUTRISON STANDARD','Lar','Nutricia',NULL,NULL,'0.00'),(12712,NULL,'drug','DRx0013070','NUTROPLEX PLUS','Sir','Medifarma',NULL,NULL,'0.00'),(12713,NULL,'drug','DRx0013071','NUVISION','Tab Salut Selaput','Guardian Pharmatama',NULL,NULL,'0.00'),(12714,NULL,'drug','DRx0013072','NUVONEURAL','Tab','Armoxindo Farma',NULL,NULL,'0.00'),(12715,NULL,'drug','DRx0013073','NYMIKO','Susp','Sanbe',NULL,NULL,'0.00'),(12716,NULL,'drug','DRx0013074','NYOLOL','Gel','Novartis Indonesia',NULL,NULL,'0.00'),(12717,NULL,'drug','DRx0013075','NYOLOL','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(12718,NULL,'drug','DRx0013076','OA','Kaps','Interbat',NULL,NULL,'0.00'),(12719,NULL,'drug','DRx0013077','OA FORTE','Kapl Forte','Interbat',NULL,NULL,'0.00'),(12720,NULL,'drug','DRx0013078','OATEOFEM','Kaps Lunak','Kalbe Farma',NULL,NULL,'0.00'),(12721,NULL,'drug','DRx0013079','OBDHAMIN','Kaps','Solas',NULL,NULL,'0.00'),(12722,NULL,'drug','DRx0013080','OBH BERLICO','Sir','Berlico Mulia Farma',NULL,NULL,'0.00'),(12723,NULL,'drug','DRx0013081','OBH BERLICO','Sir','Berlico Mulia Farma',NULL,NULL,'0.00'),(12724,NULL,'drug','DRx0013082','OBHDRYL','Sir','Ikapharmindo',NULL,NULL,'0.00'),(12725,NULL,'drug','DRx0013083','OBICAL','Tab Salut Selaput','Medifarma',NULL,NULL,'0.00'),(12726,NULL,'drug','DRx0013084','OBIPLUZ','Kaps Lunak','Darya-Varia',NULL,NULL,'0.00'),(12727,NULL,'drug','DRx0013085','OBTERAN','Tetes','Prafa',NULL,NULL,'0.00'),(12728,NULL,'drug','DRx0013086','OCIDERM-N','Krim','Pyridam',NULL,NULL,'0.00'),(12729,NULL,'drug','DRx0013087','OCTALBIN','Lar','Kalbe Farma',NULL,NULL,'0.00'),(12730,NULL,'drug','DRx0013088','OCTALBIN','Lar','Kalbe Farma',NULL,NULL,'0.00'),(12731,NULL,'drug','DRx0013089','OCTALBIN','Lar','Kalbe Farma',NULL,NULL,'0.00'),(12732,NULL,'drug','DRx0013090','OCTALBIN','Lar','Kalbe Farma',NULL,NULL,'0.00'),(12733,NULL,'drug','DRx0013091','OCULEX','Kaps','Interbat',NULL,NULL,'0.00'),(12734,NULL,'drug','DRx0013092','OCULEX','Sir','Interbat',NULL,NULL,'0.00'),(12735,NULL,'drug','DRx0013093','OCULOSAN','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(12736,NULL,'drug','DRx0013094','OCULOTECT','Gel','Novartis Indonesia',NULL,NULL,'0.00'),(12737,NULL,'drug','DRx0013095','ODACE','Tab','Darya-Varia',NULL,NULL,'0.00'),(12738,NULL,'drug','DRx0013096','OFERTIL','Tab','Bernofarm',NULL,NULL,'0.00'),(12739,NULL,'drug','DRx0013097','OFLOXACIN OGB DEXA','Tab Salut Selaput','Dexa Medica',NULL,NULL,'0.00'),(12740,NULL,'drug','DRx0013098','OFLOXACIN OGB DEXA','Tab Salut Selaput','Dexa Medica',NULL,NULL,'0.00'),(12741,NULL,'drug','DRx0013099','OILUM BODY SCRUB+WHITENING','Sabun Batang','Galenium Pharmasia Lab',NULL,NULL,'0.00'),(12742,NULL,'drug','DRx0013100','OKAVAX','Vial','Biken/Aventis Pasteur',NULL,NULL,'0.00'),(12743,NULL,'drug','DRx0013101','O-LAC','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(12744,NULL,'drug','DRx0013102','OLMETEC','Tab Salut Selaput','Pfizer',NULL,NULL,'0.00'),(12745,NULL,'drug','DRx0013103','OLMETEC','Tab Salut Selaput','Pfizer',NULL,NULL,'0.00'),(12746,NULL,'drug','DRx0013104','OMEPRAZOLE HEXPHARM','Kaps','Hexpharm',NULL,NULL,'0.00'),(12747,NULL,'drug','DRx0013105','OMEVELL','Kaps','Novell Pharma',NULL,NULL,'0.00'),(12748,NULL,'drug','DRx0013106','OMZ','Amp','Ferron',NULL,NULL,'0.00'),(12749,NULL,'drug','DRx0013107','OMZ','Kaps','Ferron',NULL,NULL,'0.00'),(12750,NULL,'drug','DRx0013108','ONDAVELL','Amp','Novell Pharma',NULL,NULL,'0.00'),(12751,NULL,'drug','DRx0013109','ONDAVELL','Amp','Novell Pharma',NULL,NULL,'0.00'),(12752,NULL,'drug','DRx0013110','ONDAVELL','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(12753,NULL,'drug','DRx0013111','ONDAVELL','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(12754,NULL,'drug','DRx0013112','ONE-ALPHA','Kaps Lunak','Darya- Varia/LEO Pharma',NULL,NULL,'0.00'),(12755,NULL,'drug','DRx0013113','ONE-ALPHA','Kaps Lunak','Darya-Varia/LEO Pharma',NULL,NULL,'0.00'),(12756,NULL,'drug','DRx0013114','ONE-ALPHA','Kaps Lunak','Darya- Varia/LEO Pharma',NULL,NULL,'0.00'),(12757,NULL,'drug','DRx0013115','ONETIC 4','Amp','Fahrenheit',NULL,NULL,'0.00'),(12758,NULL,'drug','DRx0013116','ONETIC 4','Tab Salut Selaput','Fahrenheit',NULL,NULL,'0.00'),(12759,NULL,'drug','DRx0013117','OPIBION','Kaps','Otto',NULL,NULL,'0.00'),(12760,NULL,'drug','DRx0013118','OPICEL','Krim','Otto',NULL,NULL,'0.00'),(12761,NULL,'drug','DRx0013119','OPILAX','Sir','Otto',NULL,NULL,'0.00'),(12762,NULL,'drug','DRx0013120','OPILAX','Sir','Otto',NULL,NULL,'0.00'),(12763,NULL,'drug','DRx0013121','OPINEURON','Tab','Otto',NULL,NULL,'0.00'),(12764,NULL,'drug','DRx0013122','OPINO','Gel','Soho/Tropon',NULL,NULL,'0.00'),(12765,NULL,'drug','DRx0013123','OPIXIME','Kapl','Otto',NULL,NULL,'0.00'),(12766,NULL,'drug','DRx0013124','OPREZOL','Kaps','Kimia Farma',NULL,NULL,'0.00'),(12767,NULL,'drug','DRx0013125','OPTHA-LL','Kaps','Landson',NULL,NULL,'0.00'),(12768,NULL,'drug','DRx0013126','OPTHIL','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(12769,NULL,'drug','DRx0013127','OPTHIL','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(12770,NULL,'drug','DRx0013128','OPTIBET','Tetes','Sanbe',NULL,NULL,'0.00'),(12771,NULL,'drug','DRx0013129','OPTIFRESH','Tetes','Konimex',NULL,NULL,'0.00'),(12772,NULL,'drug','DRx0013130','OPTIFRESH','Tetes','Konimex',NULL,NULL,'0.00'),(12773,NULL,'drug','DRx0013131','OPTIMAX','Kapl','Ferron',NULL,NULL,'0.00'),(12774,NULL,'drug','DRx0013132','OPTIVIUM LIVER SUPPORT','Tab','Cynergen Health',NULL,NULL,'0.00'),(12775,NULL,'drug','DRx0013133','ORADEXON','Amp','Organon',NULL,NULL,'0.00'),(12776,NULL,'drug','DRx0013134','ORALIT','Bubuk','Kimia Farma',NULL,NULL,'0.00'),(12777,NULL,'drug','DRx0013135','ORALIT-200','Bubuk','Novell Pharma',NULL,NULL,'0.00'),(12778,NULL,'drug','DRx0013136','ORAP FORTE','Tab Forte','Janssen-Cilag',NULL,NULL,'0.00'),(12779,NULL,'drug','DRx0013137','OREGAN','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(12780,NULL,'drug','DRx0013138','ORTHOSIPHONIS FOLIUM','Tab','Soho',NULL,NULL,'0.00'),(12781,NULL,'drug','DRx0013139','OSATROL','Salep','Darya-Varia',NULL,NULL,'0.00'),(12782,NULL,'drug','DRx0013140','OSATROL','Tetes','Darya-Varia',NULL,NULL,'0.00'),(12783,NULL,'drug','DRx0013141','OSCAL','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(12784,NULL,'drug','DRx0013142','OSCAL','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(12785,NULL,'drug','DRx0013143','OSFIT','Kapl','Kalbe Farma',NULL,NULL,'0.00'),(12786,NULL,'drug','DRx0013144','OSFLEX','Pre-filled','Novell Pharma',NULL,NULL,'0.00'),(12787,NULL,'drug','DRx0013145','OSIMAX','Sir','Tempo Scan Pacific',NULL,NULL,'0.00'),(12788,NULL,'drug','DRx0013146','OSKADON','Tab','Supra Ferbindo',NULL,NULL,'0.00'),(12789,NULL,'drug','DRx0013147','OSKADRYL','Tab','Supra Ferbindo',NULL,NULL,'0.00'),(12790,NULL,'drug','DRx0013148','OSKAMAG','Tab','Supra Ferbindo',NULL,NULL,'0.00'),(12791,NULL,'drug','DRx0013149','OSKASAL','Krim','Supra Ferbindo',NULL,NULL,'0.00'),(12792,NULL,'drug','DRx0013150','OSKASAL','Krim','Supra Ferbindo',NULL,NULL,'0.00'),(12793,NULL,'drug','DRx0013151','OSKAVIT','Kapl','Supra Ferbindo',NULL,NULL,'0.00'),(12794,NULL,'drug','DRx0013152','OSMETIN 3','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(12795,NULL,'drug','DRx0013153','OSMYCIN','Sir','Pharos',NULL,NULL,'0.00'),(12796,NULL,'drug','DRx0013154','OSMYCN','Tab','Pharos',NULL,NULL,'0.00'),(12797,NULL,'drug','DRx0013155','OSSOPAN 200','Tab','Darya-Varia/Pierre Fabre',NULL,NULL,'0.00'),(12798,NULL,'drug','DRx0013156','OSSOPAN 800','Kapl Salut Selaput','Darya-Varia/Pierre Fabre',NULL,NULL,'0.00'),(12799,NULL,'drug','DRx0013157','OSSOVIT','Kapl','Interbat',NULL,NULL,'0.00'),(12800,NULL,'drug','DRx0013158','OSSOVIT','Sir','Interbat',NULL,NULL,'0.00'),(12801,NULL,'drug','DRx0013159','OSTARIN','Susp','Otto',NULL,NULL,'0.00'),(12802,NULL,'drug','DRx0013160','OSTARIN','Susp Forte','Otto',NULL,NULL,'0.00'),(12803,NULL,'drug','DRx0013161','OSTE FORTE','Kapl Forte','Soho',NULL,NULL,'0.00'),(12804,NULL,'drug','DRx0013162','OSTELA','Kapl','Coronet',NULL,NULL,'0.00'),(12805,NULL,'drug','DRx0013163','OSTELA','Kapl Forte','Coronet',NULL,NULL,'0.00'),(12806,NULL,'drug','DRx0013164','OSTELOX','Tab','Sanbe',NULL,NULL,'0.00'),(12807,NULL,'drug','DRx0013165','OSTELOX','Tab','Sanbe',NULL,NULL,'0.00'),(12808,NULL,'drug','DRx0013166','OSTEOCAL PLUS','Tab Kunyah','Nicholas',NULL,NULL,'0.00'),(12809,NULL,'drug','DRx0013167','OSTEOCARE','Sir','Vitabiotics',NULL,NULL,'0.00'),(12810,NULL,'drug','DRx0013168','OSTEOCARE','Tab','Vitabiotics',NULL,NULL,'0.00'),(12811,NULL,'drug','DRx0013169','OSTEOFAR','Tab','Fahrenheit',NULL,NULL,'0.00'),(12812,NULL,'drug','DRx0013170','OSTEOFLAM','Kaps','Soho',NULL,NULL,'0.00'),(12813,NULL,'drug','DRx0013171','OSTEOKOM','Kapl Salut Selaput','Lapi',NULL,NULL,'0.00'),(12814,NULL,'drug','DRx0013172','OSTEOKOM FORTE','Bubuk Forte','Lapi',NULL,NULL,'0.00'),(12815,NULL,'drug','DRx0013173','OSTEONATE OD','Tab','Kalbe Farma',NULL,NULL,'0.00'),(12816,NULL,'drug','DRx0013174','OSTEONIC','Kapl','Nicholas',NULL,NULL,'0.00'),(12817,NULL,'drug','DRx0013175','OSTEOPOR','Kaps','Combiphar',NULL,NULL,'0.00'),(12818,NULL,'drug','DRx0013176','OSTEOR/OSTEOR PLUS','Kapl','Pyridam',NULL,NULL,'0.00'),(12819,NULL,'drug','DRx0013177','OSTEOR/OSTEOR PLUS','Kapl Forte','Pyridam',NULL,NULL,'0.00'),(12820,NULL,'drug','DRx0013178','OSTEOR-C','Krim','Pyridam',NULL,NULL,'0.00'),(12821,NULL,'drug','DRx0013179','OSTEOVELL','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(12822,NULL,'drug','DRx0013180','OSTRID','Kapl Salut Selaput','Otto',NULL,NULL,'0.00'),(12823,NULL,'drug','DRx0013181','OSTRIOL','Kaps Lunak','Fahrenheit',NULL,NULL,'0.00'),(12824,NULL,'drug','DRx0013182','OSVION PLUS','Kaps','Solas',NULL,NULL,'0.00'),(12825,NULL,'drug','DRx0013183','OTORYL','Tab','Otto',NULL,NULL,'0.00'),(12826,NULL,'drug','DRx0013184','OTRIVIN','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(12827,NULL,'drug','DRx0013185','OTRIVIN','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(12828,NULL,'drug','DRx0013186','OTSU-D5','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12829,NULL,'drug','DRx0013187','OTSU-D5','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12830,NULL,'drug','DRx0013188','OTSU-D5','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12831,NULL,'drug','DRx0013189','OTSU-NS','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12832,NULL,'drug','DRx0013190','OTSU-NS','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12833,NULL,'drug','DRx0013191','OTSU-NS','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12834,NULL,'drug','DRx0013192','OTSUTRAN 40','Lar Infus','Otsuka',NULL,NULL,'0.00'),(12835,NULL,'drug','DRx0013193','OVABION','Kapl Salut Gula','Berlico Mulia Farma',NULL,NULL,'0.00'),(12836,NULL,'drug','DRx0013194','OVESTIN','Tab','Organon',NULL,NULL,'0.00'),(12837,NULL,'drug','DRx0013195','OVIDREL','Vial','DKSH/Sereno',NULL,NULL,'0.00'),(12838,NULL,'drug','DRx0013196','OVURILA','Gel','Nufarindo',NULL,NULL,'0.00'),(12839,NULL,'drug','DRx0013197','OXCAL','Kaps','Solas',NULL,NULL,'0.00'),(12840,NULL,'drug','DRx0013198','OXEPA','Lar','Abbott',NULL,NULL,'0.00'),(12841,NULL,'drug','DRx0013199','OXEPA','Lar','Abbott',NULL,NULL,'0.00'),(12842,NULL,'drug','DRx0013200','OXIPRES','Kapl','Sandoz',NULL,NULL,'0.00'),(12843,NULL,'drug','DRx0013201','OXSORALEN','Lot','SDM Lab',NULL,NULL,'0.00'),(12844,NULL,'drug','DRx0013202','OXTERCID','Vial','Interbat',NULL,NULL,'0.00'),(12845,NULL,'drug','DRx0013203','OXYFORT','Tab Kunyah','Soho',NULL,NULL,'0.00'),(12846,NULL,'drug','DRx0013204','OXYLA','Amp','Novell Pharma',NULL,NULL,'0.00'),(12847,NULL,'drug','DRx0013205','OXYVIT','Kapl Salut Selaput','Ferron',NULL,NULL,'0.00'),(12848,NULL,'drug','DRx0013206','OZEN','Sir','Pharos',NULL,NULL,'0.00'),(12849,NULL,'drug','DRx0013207','OZEN','Tab Salut Selaput','Pharos',NULL,NULL,'0.00'),(12850,NULL,'drug','DRx0013208','OZEN','Tetes','Pharos',NULL,NULL,'0.00'),(12851,NULL,'drug','DRx0013209','OZID','Kaps','Darya-Varia',NULL,NULL,'0.00'),(12852,NULL,'drug','DRx0013210','PABANOX','Krim','SDM Lab',NULL,NULL,'0.00'),(12853,NULL,'drug','DRx0013211','PALLAGICIN','Amp','Baxter',NULL,NULL,'0.00'),(12854,NULL,'drug','DRx0013212','PALOXI','Vial','Kalbe Farma',NULL,NULL,'0.00'),(12855,NULL,'drug','DRx0013213','PAMOL','Supp','Interbat',NULL,NULL,'0.00'),(12856,NULL,'drug','DRx0013214','PAMOL','Supp','Interbat',NULL,NULL,'0.00'),(12857,NULL,'drug','DRx0013215','PAMOL','Tetes','Interbat',NULL,NULL,'0.00'),(12858,NULL,'drug','DRx0013216','PANADOL ACTIFAST','Kapl','Sterling',NULL,NULL,'0.00'),(12859,NULL,'drug','DRx0013217','PANTOGAR','Kaps','Combiphar',NULL,NULL,'0.00'),(12860,NULL,'drug','DRx0013218','PANTOZOL','Tab','Pharos/ALTANA',NULL,NULL,'0.00'),(12861,NULL,'drug','DRx0013219','PANTOZOL','Tab','Pharos/ALTANA',NULL,NULL,'0.00'),(12862,NULL,'drug','DRx0013220','PAPAVERINE BERLICO','Tab','Berlico Mulia Farma',NULL,NULL,'0.00'),(12863,NULL,'drug','DRx0013221','PAPAVERINE HCL','Amp','Soho/Ethica',NULL,NULL,'0.00'),(12864,NULL,'drug','DRx0013222','PAPAVERINE HCL','Tab','Soho/Ethica',NULL,NULL,'0.00'),(12865,NULL,'drug','DRx0013223','PARABUTOL','Tab','Prafa',NULL,NULL,'0.00'),(12866,NULL,'drug','DRx0013224','PARACETAMOL HEXPHARM','Kapl','Hexpharm',NULL,NULL,'0.00'),(12867,NULL,'drug','DRx0013225','PARACETAMOL OGB DEXA','Sir','Dexa Medica',NULL,NULL,'0.00'),(12868,NULL,'drug','DRx0013226','PARACETOL','Enema','Prafa',NULL,NULL,'0.00'),(12869,NULL,'drug','DRx0013227','PARACETOL','Sir','Prafa',NULL,NULL,'0.00'),(12870,NULL,'drug','DRx0013228','PARACETOL','Tab','Prafa',NULL,NULL,'0.00'),(12871,NULL,'drug','DRx0013229','PARACETOL','Tab','Prafa',NULL,NULL,'0.00'),(12872,NULL,'drug','DRx0013230','PARANOX F','Krim','Roi Surya Prima',NULL,NULL,'0.00'),(12873,NULL,'drug','DRx0013231','PARANOX F','Lot','Roi Surya Prima',NULL,NULL,'0.00'),(12874,NULL,'drug','DRx0013232','PARANOX SPF 33 CREAM','Krim','Roi Surya Prima',NULL,NULL,'0.00'),(12875,NULL,'drug','DRx0013233','PARASOL','Krim','SDM Lab',NULL,NULL,'0.00'),(12876,NULL,'drug','DRx0013234','PARATUSIN','Tab','Prafa',NULL,NULL,'0.00'),(12877,NULL,'drug','DRx0013235','PARDOZ','Tab','Kalbe Farma',NULL,NULL,'0.00'),(12878,NULL,'drug','DRx0013236','PARIET','Tab Salut Enterik','Eisai',NULL,NULL,'0.00'),(12879,NULL,'drug','DRx0013237','PARSIFEN','Kapl Salut Selaput','Ifars',NULL,NULL,'0.00'),(12880,NULL,'drug','DRx0013238','PASQUAM','Krim','Sanbe',NULL,NULL,'0.00'),(12881,NULL,'drug','DRx0013239','PATANOL','Tetes','Alcon',NULL,NULL,'0.00'),(12882,NULL,'drug','DRx0013240','PAVULON','Amp','Organon',NULL,NULL,'0.00'),(12883,NULL,'drug','DRx0013241','PAXUS','Vial','Kalbe Farma',NULL,NULL,'0.00'),(12884,NULL,'drug','DRx0013242','PAXUS','Vial','Kalbe Farma',NULL,NULL,'0.00'),(12885,NULL,'drug','DRx0013243','PECTUM','Eksp','Solas',NULL,NULL,'0.00'),(12886,NULL,'drug','DRx0013244','PECTUM','Eksp','Solas',NULL,NULL,'0.00'),(12887,NULL,'drug','DRx0013245','PEDAF','Tab','Otto',NULL,NULL,'0.00'),(12888,NULL,'drug','DRx0013246','PEDIACEL','Pre-filled','Sanofi Pasteur',NULL,NULL,'0.00'),(12889,NULL,'drug','DRx0013247','PEDIALYTE','Lar','Abbott',NULL,NULL,'0.00'),(12890,NULL,'drug','DRx0013248','PEDIASURE','Bubuk','Abbott',NULL,NULL,'0.00'),(12891,NULL,'drug','DRx0013249','PEDIASURE','Bubuk','Abbott',NULL,NULL,'0.00'),(12892,NULL,'drug','DRx0013250','PEG INTRON','Vial','Schering-Plough',NULL,NULL,'0.00'),(12893,NULL,'drug','DRx0013251','PEG INTRON','Vial','Schering-Plough',NULL,NULL,'0.00'),(12894,NULL,'drug','DRx0013252','PEG INTRON','Vial','Schering-Plough',NULL,NULL,'0.00'),(12895,NULL,'drug','DRx0013253','PEG INTRON','Vial','Schering-Plough',NULL,NULL,'0.00'),(12896,NULL,'drug','DRx0013254','PEG INTRON','Vial','Schering-Plough',NULL,NULL,'0.00'),(12897,NULL,'drug','DRx0013255','PEGASYS','Inj','Roche',NULL,NULL,'0.00'),(12898,NULL,'drug','DRx0013256','PEGASYS','Inj','Roche',NULL,NULL,'0.00'),(12899,NULL,'drug','DRx0013257','PELASTIN IV DRIP','Lar Infus','Sanbe',NULL,NULL,'0.00'),(12900,NULL,'drug','DRx0013258','PELOSMA','Kaps','Bernofarm',NULL,NULL,'0.00'),(12901,NULL,'drug','DRx0013259','PELOSMA','Kaps','Bernofarm',NULL,NULL,'0.00'),(12902,NULL,'drug','DRx0013260','PENAGON','Kapl','Metiska Farma',NULL,NULL,'0.00'),(12903,NULL,'drug','DRx0013261','PENTACIN','Tetes','Darya-Varia',NULL,NULL,'0.00'),(12904,NULL,'drug','DRx0013262','PENTOXIFILLINE OGB DEXA','Amp','Dexa Medica',NULL,NULL,'0.00'),(12905,NULL,'drug','DRx0013263','PENTOXIFILLINE OGB DEXA','Kaps Salut Gula Lepa','Dexa Medica',NULL,NULL,'0.00'),(12906,NULL,'drug','DRx0013264','PEPLACINE','Lar Infus','Sanofi Aventis',NULL,NULL,'0.00'),(12907,NULL,'drug','DRx0013265','PEPTI 2000','Bubuk','Nutricia',NULL,NULL,'0.00'),(12908,NULL,'drug','DRx0013266','PEPTI-JUNIOR','Bubuk','Nutricia',NULL,NULL,'0.00'),(12909,NULL,'drug','DRx0013267','PEPTISOL VANILA','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(12910,NULL,'drug','DRx0013268','PERACON','Sir','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12911,NULL,'drug','DRx0013269','PERACON','Tab Salut Gula','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12912,NULL,'drug','DRx0013270','PERACON','Tab Salut Gula','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12913,NULL,'drug','DRx0013271','PERACON','Tetes','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12914,NULL,'drug','DRx0013272','PERDIPINE','Amp','Astellas',NULL,NULL,'0.00'),(12915,NULL,'drug','DRx0013273','PERDIPINE','Amp','Astellas',NULL,NULL,'0.00'),(12916,NULL,'drug','DRx0013274','PERINAL','Kapl Salut Selaput','Tempo Scan Pacific',NULL,NULL,'0.00'),(12917,NULL,'drug','DRx0013275','PERMYO','Tab Salut Selaput','Ferron',NULL,NULL,'0.00'),(12918,NULL,'drug','DRx0013276','PERSIDAL','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(12919,NULL,'drug','DRx0013277','PERSIDAL','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(12920,NULL,'drug','DRx0013278','PERVITA','Kapl Salut Selaput','Sanbe',NULL,NULL,'0.00'),(12921,NULL,'drug','DRx0013279','PHALTREXIA','Tab','Pharos',NULL,NULL,'0.00'),(12922,NULL,'drug','DRx0013280','PHARFLOX','Tab Salut Selaput','Pharos',NULL,NULL,'0.00'),(12923,NULL,'drug','DRx0013281','PHARFLOX','Tab Salut Selaput','Pharos',NULL,NULL,'0.00'),(12924,NULL,'drug','DRx0013282','PHARMATON VIT','Kapl Salut Selaput','Boehringer Ingelheim/Pharmaton Lugano',NULL,NULL,'0.00'),(12925,NULL,'drug','DRx0013283','PHARODIME','Vial','Pharos',NULL,NULL,'0.00'),(12926,NULL,'drug','DRx0013284','PHAROTHROCIN','Kapl Kunyah','Pharos',NULL,NULL,'0.00'),(12927,NULL,'drug','DRx0013285','PHAROTHROCIN','Kaps','Pharos',NULL,NULL,'0.00'),(12928,NULL,'drug','DRx0013286','PHAROTHROCIN','Sir Kering','Pharos',NULL,NULL,'0.00'),(12929,NULL,'drug','DRx0013287','PHAROTHROCIN','Tab','Pharos',NULL,NULL,'0.00'),(12930,NULL,'drug','DRx0013288','PHENYLBUTAZON BERLICO','Kapl Salut Selaput','Berlico Mulia Farma',NULL,NULL,'0.00'),(12931,NULL,'drug','DRx0013289','PHISOHEX REFORMULATED','Emulsi','Sanofi Aventis',NULL,NULL,'0.00'),(12932,NULL,'drug','DRx0013290','PHISOHEX REFORMULATED','Emulsi','Sanofi Aventis',NULL,NULL,'0.00'),(12933,NULL,'drug','DRx0013291','PHOSCAL','Kapl Salut Selaput','Armoxindo Farma',NULL,NULL,'0.00'),(12934,NULL,'drug','DRx0013292','PHYLLOCONTIN CONTINUS','Tab','Mahakam Beta Farma/Mundipharma',NULL,NULL,'0.00'),(12935,NULL,'drug','DRx0013293','PHYSIOTENS','Tab Salut Selaput','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12936,NULL,'drug','DRx0013294','PHYSIOTENS','Tab Salut Selaput','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12937,NULL,'drug','DRx0013295','PIL KELUARGA BERENCANA','Tab','Bayer Schering Pharma',NULL,NULL,'0.00'),(12938,NULL,'drug','DRx0013296','PINFETIL','Tab','Novell Pharma',NULL,NULL,'0.00'),(12939,NULL,'drug','DRx0013297','PIPERACYL','Sir','Tempo Scan Pacific/Bode',NULL,NULL,'0.00'),(12940,NULL,'drug','DRx0013298','PIPERACYL','Sir','Tempo Scan Pacific/Bode',NULL,NULL,'0.00'),(12941,NULL,'drug','DRx0013299','PIRACETAM HEXPHARM','Amp','Hexpharm',NULL,NULL,'0.00'),(12942,NULL,'drug','DRx0013300','PIRACETAM HEXPHARM','Amp','Hexpharm',NULL,NULL,'0.00'),(12943,NULL,'drug','DRx0013301','PIRACETAM HEXPHARM','Tab Salut Selaput','Hexpharm',NULL,NULL,'0.00'),(12944,NULL,'drug','DRx0013302','PIRACETAM HEXPHARM','Tab Salut Selaput','Hexpharm',NULL,NULL,'0.00'),(12945,NULL,'drug','DRx0013303','PIRACETAM HEXPHARM','Tab Salut Selaput','Hexpharm',NULL,NULL,'0.00'),(12946,NULL,'drug','DRx0013304','PIRACETAM LUCAS DJAJA','Amp','Lucas Djaja',NULL,NULL,'0.00'),(12947,NULL,'drug','DRx0013305','PIRACETAM LUCAS DJAJA','Amp','Lucas Djaja',NULL,NULL,'0.00'),(12948,NULL,'drug','DRx0013306','PIRACETAM OGB DEXA','Amp','Dexa Medica',NULL,NULL,'0.00'),(12949,NULL,'drug','DRx0013307','PIRACETAM OGB DEXA','Amp','Dexa Medica',NULL,NULL,'0.00'),(12950,NULL,'drug','DRx0013308','PIRACETAM OGB DEXA','Kapl Salut Selaput','Dexa Medica',NULL,NULL,'0.00'),(12951,NULL,'drug','DRx0013309','PIRACETAM OGB DEXA','Kapl Salut Selaput','Dexa Medica',NULL,NULL,'0.00'),(12952,NULL,'drug','DRx0013310','PIRACETAM OGB DEXA','Kaps','Dexa Medica',NULL,NULL,'0.00'),(12953,NULL,'drug','DRx0013311','PIRACETAM OGB DEXA','Lar Infus','Dexa Medica',NULL,NULL,'0.00'),(12954,NULL,'drug','DRx0013312','PIRASKA 125','Tab','Supra Ferbindo',NULL,NULL,'0.00'),(12955,NULL,'drug','DRx0013313','PIRATROF','Amp','Novell Pharma',NULL,NULL,'0.00'),(12956,NULL,'drug','DRx0013314','PIRATROF','Amp','Novell Pharma',NULL,NULL,'0.00'),(12957,NULL,'drug','DRx0013315','PIRATROF','Tab','Novell Pharma',NULL,NULL,'0.00'),(12958,NULL,'drug','DRx0013316','PIRONEC','Amp','Novell Pharma',NULL,NULL,'0.00'),(12959,NULL,'drug','DRx0013317','PIRONEC','Kaps','Novell Pharma',NULL,NULL,'0.00'),(12960,NULL,'drug','DRx0013318','PIROXICAM HEXPHARM','Tab','Hexpharm',NULL,NULL,'0.00'),(12961,NULL,'drug','DRx0013319','PLANAK','Tab','Fahrenheit',NULL,NULL,'0.00'),(12962,NULL,'drug','DRx0013320','PLANIBU','Vial','Fahrenheit',NULL,NULL,'0.00'),(12963,NULL,'drug','DRx0013321','PLANIBU','Vial','Fahrenheit',NULL,NULL,'0.00'),(12964,NULL,'drug','DRx0013322','PLASBUMIN-5','Lar Infus','Dipa Pharmalab Intersains',NULL,NULL,'0.00'),(12965,NULL,'drug','DRx0013323','PLASIL','Amp','Kimia Farma',NULL,NULL,'0.00'),(12966,NULL,'drug','DRx0013324','PLASIL','Tab','Kimia Farma',NULL,NULL,'0.00'),(12967,NULL,'drug','DRx0013325','PLASMINEX','Amp','Sanbe',NULL,NULL,'0.00'),(12968,NULL,'drug','DRx0013326','PLASMINEX','Tab Salut Selaput','Sanbe',NULL,NULL,'0.00'),(12969,NULL,'drug','DRx0013327','PLATINOX','Vial','Sandoz',NULL,NULL,'0.00'),(12970,NULL,'drug','DRx0013328','PLATINOX','Vial','Sandoz',NULL,NULL,'0.00'),(12971,NULL,'drug','DRx0013329','PLATOSIN','Vial','Pharmachemie',NULL,NULL,'0.00'),(12972,NULL,'drug','DRx0013330','PLATOSIN','Vial','Pharmachemie',NULL,NULL,'0.00'),(12973,NULL,'drug','DRx0013331','POLIKOS','Tab Salut Selaput','Landson',NULL,NULL,'0.00'),(12974,NULL,'drug','DRx0013332','POLIKOS','Tab Salut Selaput','Landson',NULL,NULL,'0.00'),(12975,NULL,'drug','DRx0013333','POLIVIT','Sir','Abdi Ibrahim',NULL,NULL,'0.00'),(12976,NULL,'drug','DRx0013334','POLYBENZA AQ','Gel','Roi Surya Prima',NULL,NULL,'0.00'),(12977,NULL,'drug','DRx0013335','POLYBENZA AQ','Gel','Roi Surya Prima',NULL,NULL,'0.00'),(12978,NULL,'drug','DRx0013336','POLYSILANE FOR CHILDREN','Gran','Pharos',NULL,NULL,'0.00'),(12979,NULL,'drug','DRx0013337','PONCOSOLVON','Sir','Armoxindo Farma',NULL,NULL,'0.00'),(12980,NULL,'drug','DRx0013338','PORTAGYL','Lar Infus','Prafa',NULL,NULL,'0.00'),(12981,NULL,'drug','DRx0013339','POSTINOR-2','Tab','Tunggal Idaman Abadi/Gedeon Richter',NULL,NULL,'0.00'),(12982,NULL,'drug','DRx0013340','POSYD','Vial','Pharmachemie',NULL,NULL,'0.00'),(12983,NULL,'drug','DRx0013341','POTAZEN','Tab Salut Selaput','Medikon',NULL,NULL,'0.00'),(12984,NULL,'drug','DRx0013342','PRAGESOL','Amp','Novell Pharma',NULL,NULL,'0.00'),(12985,NULL,'drug','DRx0013343','PRALAX','Sir','Pratapa Nirmala',NULL,NULL,'0.00'),(12986,NULL,'drug','DRx0013344','PRAMUR','Tab','Prafa',NULL,NULL,'0.00'),(12987,NULL,'drug','DRx0013345','PRAMUR','Tab','Prafa',NULL,NULL,'0.00'),(12988,NULL,'drug','DRx0013346','PRANKREON FOR CHILDREN','Gran','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(12989,NULL,'drug','DRx0013347','PRATROPIL','Kaps','Fahrenheit',NULL,NULL,'0.00'),(12990,NULL,'drug','DRx0013348','PRAVACHOL','Tab','Bristol- Myers Squibb',NULL,NULL,'0.00'),(12991,NULL,'drug','DRx0013349','PRAVLON','Lar','Prafa',NULL,NULL,'0.00'),(12992,NULL,'drug','DRx0013350','PRAXION','Sir','Pharos',NULL,NULL,'0.00'),(12993,NULL,'drug','DRx0013351','PRAXION','Sir Forte','Pharos',NULL,NULL,'0.00'),(12994,NULL,'drug','DRx0013352','PRAXION','Tetes','Pharos',NULL,NULL,'0.00'),(12995,NULL,'drug','DRx0013353','PRAZOTEC','Kaps','Fahrenheit',NULL,NULL,'0.00'),(12996,NULL,'drug','DRx0013354','PREDA','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(12997,NULL,'drug','DRx0013355','PREDNICORT','Kapl','Otto',NULL,NULL,'0.00'),(12998,NULL,'drug','DRx0013356','PREDNICORT','Tab','Otto',NULL,NULL,'0.00'),(12999,NULL,'drug','DRx0013357','PREDNISON BERLICO','Tab','Berlico Mulia Farma',NULL,NULL,'0.00'),(13000,NULL,'drug','DRx0013358','PREDNISON HEXPHARM','Tab','Hexpharm',NULL,NULL,'0.00'),(13001,NULL,'drug','DRx0013359','PREDNOX','Kapl','Pyridam',NULL,NULL,'0.00'),(13002,NULL,'drug','DRx0013360','PREGNACARE','Kaps','Vitabiotics',NULL,NULL,'0.00'),(13003,NULL,'drug','DRx0013361','PREGNASEA','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(13004,NULL,'drug','DRx0013362','PREGTENOL','Tab','Fahrenheit',NULL,NULL,'0.00'),(13005,NULL,'drug','DRx0013363','PREGVOMIT','Tab Salut Gula','Fahrenheit',NULL,NULL,'0.00'),(13006,NULL,'drug','DRx0013364','PREMENCE','Kaps','Vitabiotics',NULL,NULL,'0.00'),(13007,NULL,'drug','DRx0013365','PRENAGEN EMEMSIS','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13008,NULL,'drug','DRx0013366','PRENAGEN IBU HAMIL','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13009,NULL,'drug','DRx0013367','PRENAGEN IBU HAMIL','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13010,NULL,'drug','DRx0013368','PRENAGEN IBU HAMIL','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13011,NULL,'drug','DRx0013369','PRENAGEN IBU MENYUSUI','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13012,NULL,'drug','DRx0013370','PRENAGEN PLUS DHA','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13013,NULL,'drug','DRx0013371','PRENAGEN PLUS DHA','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13014,NULL,'drug','DRx0013372','PRENAGEN PLUS DHA','Bubuk','Sanghiang Perkasa/Kalbe',NULL,NULL,'0.00'),(13015,NULL,'drug','DRx0013373','PRENATAL','Kapl Salut Gula','Erlimpex',NULL,NULL,'0.00'),(13016,NULL,'drug','DRx0013374','PRENATIN-DF','Kapl ','Soho',NULL,NULL,'0.00'),(13017,NULL,'drug','DRx0013375','PRESTRENOL','Tab','Interbat',NULL,NULL,'0.00'),(13018,NULL,'drug','DRx0013376','PRETILON','Tab','Sandoz',NULL,NULL,'0.00'),(13019,NULL,'drug','DRx0013377','PRETILON','Tab','Sandoz',NULL,NULL,'0.00'),(13020,NULL,'drug','DRx0013378','PRETILON','Tab','Sandoz',NULL,NULL,'0.00'),(13021,NULL,'drug','DRx0013379','PREVENAR','Pre-filled','Wyeth',NULL,NULL,'0.00'),(13022,NULL,'drug','DRx0013380','PREXIGE','Tab Salut Selaput','Novartis Indonesia',NULL,NULL,'0.00'),(13023,NULL,'drug','DRx0013381','PREXUM','Tab','Servier',NULL,NULL,'0.00'),(13024,NULL,'drug','DRx0013382','PRIFEN','Kapl','Soho',NULL,NULL,'0.00'),(13025,NULL,'drug','DRx0013383','PRIMADERM','Krim','Roi Surya Prima',NULL,NULL,'0.00'),(13026,NULL,'drug','DRx0013384','PRIMADERM','Salep','Roi Surya Prima',NULL,NULL,'0.00'),(13027,NULL,'drug','DRx0013385','PRIMADOL','Kapl','Soho',NULL,NULL,'0.00'),(13028,NULL,'drug','DRx0013386','PRIMA-E','Kaps Lunak','Sandoz',NULL,NULL,'0.00'),(13029,NULL,'drug','DRx0013387','PRIMA-E','Kaps Lunak','Sandoz',NULL,NULL,'0.00'),(13030,NULL,'drug','DRx0013388','PRIMA-E','Kaps Lunak','Sandoz',NULL,NULL,'0.00'),(13031,NULL,'drug','DRx0013389','PRIMATAM','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13032,NULL,'drug','DRx0013390','PRIMATAM','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13033,NULL,'drug','DRx0013391','PRIMENE 10%','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13034,NULL,'drug','DRx0013392','PRIMENE 10%','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13035,NULL,'drug','DRx0013393','PRIMODIUM','Tab','Ikapharmindo',NULL,NULL,'0.00'),(13036,NULL,'drug','DRx0013394','PRIMPERAN','Supp','Soho/Delagrange',NULL,NULL,'0.00'),(13037,NULL,'drug','DRx0013395','PRIMPERAN','Supp','Soho/Delagrange',NULL,NULL,'0.00'),(13038,NULL,'drug','DRx0013396','PRIMSULFON','Susp','Novell Pharma',NULL,NULL,'0.00'),(13039,NULL,'drug','DRx0013397','PRIMSULFON','Tab','Novell Pharma',NULL,NULL,'0.00'),(13040,NULL,'drug','DRx0013398','PRIMUNOX','Kaps','Solas',NULL,NULL,'0.00'),(13041,NULL,'drug','DRx0013399','PRITANOL','Tab','Molex Ayus',NULL,NULL,'0.00'),(13042,NULL,'drug','DRx0013400','PRITASMA','Tab','Molex Ayus',NULL,NULL,'0.00'),(13043,NULL,'drug','DRx0013401','PRO-BANTHINE','Tab','Soho',NULL,NULL,'0.00'),(13044,NULL,'drug','DRx0013402','PROBIO-C','Tetes','Ikapharmindo',NULL,NULL,'0.00'),(13045,NULL,'drug','DRx0013403','PROBIOTIN','Kaps','Tropica Mas Pharma',NULL,NULL,'0.00'),(13046,NULL,'drug','DRx0013404','PROCAINE PENICILLIN-G MEIJI','Vial','Meiji',NULL,NULL,'0.00'),(13047,NULL,'drug','DRx0013405','PROCAL 3','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13048,NULL,'drug','DRx0013406','PROCAL 3','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13049,NULL,'drug','DRx0013407','PROCAL GOLD 3','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13050,NULL,'drug','DRx0013408','PROCAL GOLD 3','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13051,NULL,'drug','DRx0013409','PROCAL GOLD 3 WITH LUTEIN','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13052,NULL,'drug','DRx0013410','PROCEFA','Vial','Promed',NULL,NULL,'0.00'),(13053,NULL,'drug','DRx0013411','PROCEPIM','Vial','Meprofarm',NULL,NULL,'0.00'),(13054,NULL,'drug','DRx0013412','PROCETAM','Amp','Meprofarm',NULL,NULL,'0.00'),(13055,NULL,'drug','DRx0013413','PROCETAM','Kaps','Meprofarm',NULL,NULL,'0.00'),(13056,NULL,'drug','DRx0013414','PROCETAM','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13057,NULL,'drug','DRx0013415','PROCETAM','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13058,NULL,'drug','DRx0013416','PROCLOZAM','Tab','Meprofarm',NULL,NULL,'0.00'),(13059,NULL,'drug','DRx0013417','PROCOLD','Kapl','Kalbe Farma',NULL,NULL,'0.00'),(13060,NULL,'drug','DRx0013418','PROCOLD','Kapl','Kalbe Farma',NULL,NULL,'0.00'),(13061,NULL,'drug','DRx0013419','PROCOLIC','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13062,NULL,'drug','DRx0013420','PROCUR PLUS','Kaps Lunak','Guardian Pharmatama',NULL,NULL,'0.00'),(13063,NULL,'drug','DRx0013421','PRODERMAL','Krim','Meprofarm',NULL,NULL,'0.00'),(13064,NULL,'drug','DRx0013422','PROFACIN','Kapl','Corsa',NULL,NULL,'0.00'),(13065,NULL,'drug','DRx0013423','PROFACIN','Tab','Corsa',NULL,NULL,'0.00'),(13066,NULL,'drug','DRx0013424','PROFIKA','Supp','Ikapharmindo',NULL,NULL,'0.00'),(13067,NULL,'drug','DRx0013425','PROFIKA','Tab Salut Enterik','Ikapharmindo',NULL,NULL,'0.00'),(13068,NULL,'drug','DRx0013426','PROFIKA','Tab Salut Enterik','Ikapharmindo',NULL,NULL,'0.00'),(13069,NULL,'drug','DRx0013427','PROFUNGAL','Krim','Kalbe Farma',NULL,NULL,'0.00'),(13070,NULL,'drug','DRx0013428','PROGESTON','Tab','Meprofarm',NULL,NULL,'0.00'),(13071,NULL,'drug','DRx0013429','PROHESSEN','Drag','Pharos',NULL,NULL,'0.00'),(13072,NULL,'drug','DRx0013430','PROHIBIT','Kaps','Sandoz',NULL,NULL,'0.00'),(13073,NULL,'drug','DRx0013431','PROIMBUS','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13074,NULL,'drug','DRx0013432','PROLACTA WITH DHA BABY','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(13075,NULL,'drug','DRx0013433','PROLACTA WITH FOR MOTHER','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(13076,NULL,'drug','DRx0013434','PROLECIN','Kapl Salut Selaput','Promed',NULL,NULL,'0.00'),(13077,NULL,'drug','DRx0013435','PROLENE CHOCOLATE','Bubuk','Fonterra',NULL,NULL,'0.00'),(13078,NULL,'drug','DRx0013436','PROLENE CHOCOLATE','Bubuk','Fonterra',NULL,NULL,'0.00'),(13079,NULL,'drug','DRx0013437','PROLENE CHOCOLATE','Bubuk','Fonterra',NULL,NULL,'0.00'),(13080,NULL,'drug','DRx0013438','PROLENE VANILA','Bubuk','Fonterra',NULL,NULL,'0.00'),(13081,NULL,'drug','DRx0013439','PROLENE VANILA','Bubuk','Fonterra',NULL,NULL,'0.00'),(13082,NULL,'drug','DRx0013440','PROLEPSI','Kapl Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13083,NULL,'drug','DRx0013441','PROLEPSI','Kapl Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13084,NULL,'drug','DRx0013442','PROLEVOX','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13085,NULL,'drug','DRx0013443','PROLEVOX','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13086,NULL,'drug','DRx0013444','PROMACTIL','Tab Salut Selaput','Combiphar',NULL,NULL,'0.00'),(13087,NULL,'drug','DRx0013445','PROMAG','Tab Kunyah','Kalbe Farma',NULL,NULL,'0.00'),(13088,NULL,'drug','DRx0013446','PROMAG','Tab Kunyah','Kalbe Farma',NULL,NULL,'0.00'),(13089,NULL,'drug','DRx0013447','PROMAG DOUBLE ACTION','Tab Kunyah','Kalbe Farma',NULL,NULL,'0.00'),(13090,NULL,'drug','DRx0013448','PROMAVED','Sir','Promed',NULL,NULL,'0.00'),(13091,NULL,'drug','DRx0013449','PROMAVED','Sir','Promed',NULL,NULL,'0.00'),(13092,NULL,'drug','DRx0013450','PROMENO','Tab Salut Selaput','Interbat',NULL,NULL,'0.00'),(13093,NULL,'drug','DRx0013451','PROMENSIL','Tab','Ikapharmindo',NULL,NULL,'0.00'),(13094,NULL,'drug','DRx0013452','PROMETHAZINE IKAPHARMINDO','Sir','Ikapharmindo',NULL,NULL,'0.00'),(13095,NULL,'drug','DRx0013453','PROMEZOL','Kaps','Promed',NULL,NULL,'0.00'),(13096,NULL,'drug','DRx0013454','PROMIL 2','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13097,NULL,'drug','DRx0013455','PROMIL 2','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13098,NULL,'drug','DRx0013456','PROMIL GOLD 2','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13099,NULL,'drug','DRx0013457','PROMIL GOLD 2','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13100,NULL,'drug','DRx0013458','PROMIL GOLD 2 WITH LUTEIN','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13101,NULL,'drug','DRx0013459','PROMISE GOLD 4 WITH LUTEIN','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13102,NULL,'drug','DRx0013460','PROMOCID','Tab Salut Selaput','Mugi Labs',NULL,NULL,'0.00'),(13103,NULL,'drug','DRx0013461','PRONETIC','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13104,NULL,'drug','DRx0013462','PROPYRETIC','Susp','Combiphar',NULL,NULL,'0.00'),(13105,NULL,'drug','DRx0013463','PROPYRETIC','Susp','Combiphar',NULL,NULL,'0.00'),(13106,NULL,'drug','DRx0013464','PROPYRETIC','Susp','Combiphar',NULL,NULL,'0.00'),(13107,NULL,'drug','DRx0013465','PRORENAL','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(13108,NULL,'drug','DRx0013466','PRORIS','Supp','Pharos',NULL,NULL,'0.00'),(13109,NULL,'drug','DRx0013467','PROSEVAL','Kaps','Solas',NULL,NULL,'0.00'),(13110,NULL,'drug','DRx0013468','PROSOBEE','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13111,NULL,'drug','DRx0013469','PROSOGAN FD','Tab','Takeda',NULL,NULL,'0.00'),(13112,NULL,'drug','DRx0013470','PROSON  ','Krim','Bernofarm',NULL,NULL,'0.00'),(13113,NULL,'drug','DRx0013471','PROSON N','Krim','Bernofarm',NULL,NULL,'0.00'),(13114,NULL,'drug','DRx0013472','PROSURE','Bubuk','Abbott',NULL,NULL,'0.00'),(13115,NULL,'drug','DRx0013473','PROTECAL','Tab Eff','Konimex',NULL,NULL,'0.00'),(13116,NULL,'drug','DRx0013474','PROTERINE','Tab','Novell Pharma',NULL,NULL,'0.00'),(13117,NULL,'drug','DRx0013475','PROTERINE','Tab','Novell Pharma',NULL,NULL,'0.00'),(13118,NULL,'drug','DRx0013476','PROTEXIN','Bubuk','Combiphar',NULL,NULL,'0.00'),(13119,NULL,'drug','DRx0013477','PROTEXIN','Kaps','Combiphar',NULL,NULL,'0.00'),(13120,NULL,'drug','DRx0013478','PROTEXIN','Tab Kunyah','Combiphar',NULL,NULL,'0.00'),(13121,NULL,'drug','DRx0013479','PROTHYRA','Tab','Sunthi Sepuri',NULL,NULL,'0.00'),(13122,NULL,'drug','DRx0013480','PROTICA','Kaps','Ethica',NULL,NULL,'0.00'),(13123,NULL,'drug','DRx0013481','PROTICA','Kaps','Ethica',NULL,NULL,'0.00'),(13124,NULL,'drug','DRx0013482','PROTIFAR','Bubuk','Nutricia',NULL,NULL,'0.00'),(13125,NULL,'drug','DRx0013483','PROTIFAR BUNDA','Bubuk','Nutricia',NULL,NULL,'0.00'),(13126,NULL,'drug','DRx0013484','PROTIFED','Sir','Graha Farma',NULL,NULL,'0.00'),(13127,NULL,'drug','DRx0013485','PROTIFED','Sir','Graha Farma',NULL,NULL,'0.00'),(13128,NULL,'drug','DRx0013486','PROTIFED','Tab','Graha Farma',NULL,NULL,'0.00'),(13129,NULL,'drug','DRx0013487','PROTIFED','Tab','Graha Farma',NULL,NULL,'0.00'),(13130,NULL,'drug','DRx0013488','PROTOFEN','Supp','Kimia Farma',NULL,NULL,'0.00'),(13131,NULL,'drug','DRx0013489','PROTOFEN','Tab Salut Selaput','Kimia Farma',NULL,NULL,'0.00'),(13132,NULL,'drug','DRx0013490','PROTOPIC','Salep','Janssen-Cilag/Astellas',NULL,NULL,'0.00'),(13133,NULL,'drug','DRx0013491','PROTOPIC','Salep','Janssen-Cilag/Astellas',NULL,NULL,'0.00'),(13134,NULL,'drug','DRx0013492','PROTOS','Bubuk','Servier',NULL,NULL,'0.00'),(13135,NULL,'drug','DRx0013493','PROVAMED','Tab Salut Selaput','Promed',NULL,NULL,'0.00'),(13136,NULL,'drug','DRx0013494','PROVIRON','Tab','Bayer Schering Pharma',NULL,NULL,'0.00'),(13137,NULL,'drug','DRx0013495','PROWORM','Kapl','Hexpharm',NULL,NULL,'0.00'),(13138,NULL,'drug','DRx0013496','PROXCIP','Kapl Salut Selaput','Mugi Labs',NULL,NULL,'0.00'),(13139,NULL,'drug','DRx0013497','PROXIDAM','Kaps Lunak','Meprofarm',NULL,NULL,'0.00'),(13140,NULL,'drug','DRx0013498','PROZA','Sir','Landson',NULL,NULL,'0.00'),(13141,NULL,'drug','DRx0013499','PSP','Kaps','Sahabat Lingkungan Hidup',NULL,NULL,'0.00'),(13142,NULL,'drug','DRx0013500','PULMICORT','Turbuhaler','Astra Zeneca',NULL,NULL,'0.00'),(13143,NULL,'drug','DRx0013501','PULNA FORTE','Tab Salut Selaput','Landson',NULL,NULL,'0.00'),(13144,NULL,'drug','DRx0013502','PUREGON','Vial','Organon',NULL,NULL,'0.00'),(13145,NULL,'drug','DRx0013503','PYCAMETH','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13146,NULL,'drug','DRx0013504','PYLAQUIN','Krim','Roi Surya Prima',NULL,NULL,'0.00'),(13147,NULL,'drug','DRx0013505','PYLITEP','Tab','Hexpharm',NULL,NULL,'0.00'),(13148,NULL,'drug','DRx0013506','PYREX','Sir','Novell Pharma',NULL,NULL,'0.00'),(13149,NULL,'drug','DRx0013507','PYREX','Tab','Novell Pharma',NULL,NULL,'0.00'),(13150,NULL,'drug','DRx0013508','PYREX','Tetes','Novell Pharma',NULL,NULL,'0.00'),(13151,NULL,'drug','DRx0013509','PYRIDOL','Sir','Pyridam',NULL,NULL,'0.00'),(13152,NULL,'drug','DRx0013510','PYRIDOXINI HCL SOHO','Amp','Soho/Ethica',NULL,NULL,'0.00'),(13153,NULL,'drug','DRx0013511','PYRIDOXINI HCL SOHO','Amp','Soho/Ethica',NULL,NULL,'0.00'),(13154,NULL,'drug','DRx0013512','PYRIDOXINI HCL SOHO','Tab','Soho/Ethica',NULL,NULL,'0.00'),(13155,NULL,'drug','DRx0013513','PYRIDOXINI HCL SOHO','Tab','Soho/Ethica',NULL,NULL,'0.00'),(13156,NULL,'drug','DRx0013514','PYTRAMIC','Tab Salut Selaput','Pyridam',NULL,NULL,'0.00'),(13157,NULL,'drug','DRx0013515','QINOX','Kapl Salut Selaput','Solas',NULL,NULL,'0.00'),(13158,NULL,'drug','DRx0013516','QITAL','Tab','Ethica',NULL,NULL,'0.00'),(13159,NULL,'drug','DRx0013517','Q-TEN','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(13160,NULL,'drug','DRx0013518','Q-TEN','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(13161,NULL,'drug','DRx0013519','Q-TEN','Kaps Lunak','Novell Pharma',NULL,NULL,'0.00'),(13162,NULL,'drug','DRx0013520','QUELICIN','Vial','Abbott',NULL,NULL,'0.00'),(13163,NULL,'drug','DRx0013521','QUIDEX','Lar Infus','Ferron',NULL,NULL,'0.00'),(13164,NULL,'drug','DRx0013522','QUIDEX','Tab Salut Selaput','Ferron',NULL,NULL,'0.00'),(13165,NULL,'drug','DRx0013523','RADIVIT','Kapl Salut Selaput','Molex Ayus',NULL,NULL,'0.00'),(13166,NULL,'drug','DRx0013524','RAHISTIN','Tab','Kimia Farma',NULL,NULL,'0.00'),(13167,NULL,'drug','DRx0013525','RAIVAS','Amp','Dexa medica',NULL,NULL,'0.00'),(13168,NULL,'drug','DRx0013526','RAMICORT','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13169,NULL,'drug','DRx0013527','RAMIPRIL OGB DEXA','Tab','Dexa medica',NULL,NULL,'0.00'),(13170,NULL,'drug','DRx0013528','RAMIPRIL OGB DEXA','Tab','Dexa medica',NULL,NULL,'0.00'),(13171,NULL,'drug','DRx0013529','RAMIXAL','Tab','Sandoz',NULL,NULL,'0.00'),(13172,NULL,'drug','DRx0013530','RAMIXAL','Tab','Sandoz',NULL,NULL,'0.00'),(13173,NULL,'drug','DRx0013531','RAMIXAL','Tab','Sandoz',NULL,NULL,'0.00'),(13174,NULL,'drug','DRx0013532','RAMIXAL','Tab','Sandoz',NULL,NULL,'0.00'),(13175,NULL,'drug','DRx0013533','RANCUS','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13176,NULL,'drug','DRx0013534','RANILEX 150','Tab Salut Selaput','Molex Ayus',NULL,NULL,'0.00'),(13177,NULL,'drug','DRx0013535','RANILEX 300','Kapl Salut Selaput','Molex Ayus',NULL,NULL,'0.00'),(13178,NULL,'drug','DRx0013536','RANIN','Inj','Pharos',NULL,NULL,'0.00'),(13179,NULL,'drug','DRx0013537','RANITIDINE HEXPARM','Amp ','Hexpharm',NULL,NULL,'0.00'),(13180,NULL,'drug','DRx0013538','RANITIDINE HEXPARM','Tab','Hexpharm',NULL,NULL,'0.00'),(13181,NULL,'drug','DRx0013539','RANTICID','Tab','Kimia Farma',NULL,NULL,'0.00'),(13182,NULL,'drug','DRx0013540','RANTIN','Amp','Kalbe Farma',NULL,NULL,'0.00'),(13183,NULL,'drug','DRx0013541','RATAX','Kaps','Pyridam',NULL,NULL,'0.00'),(13184,NULL,'drug','DRx0013542','RAVITA','Tab Kunyah','Combiphar',NULL,NULL,'0.00'),(13185,NULL,'drug','DRx0013543','REBETOL','Kaps','Schering-Plough',NULL,NULL,'0.00'),(13186,NULL,'drug','DRx0013544','REBIF','Pre-filled','DKSH/Serono',NULL,NULL,'0.00'),(13187,NULL,'drug','DRx0013545','REBIF','Pre-filled','DKSH/Serono',NULL,NULL,'0.00'),(13188,NULL,'drug','DRx0013546','REBOQUIN','Tab','Dexa Medica',NULL,NULL,'0.00'),(13189,NULL,'drug','DRx0013547','RECHOL','Tab Salut Selaput','Pharos',NULL,NULL,'0.00'),(13190,NULL,'drug','DRx0013548','RECO','Salep','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13191,NULL,'drug','DRx0013549','RECO','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13192,NULL,'drug','DRx0013550','RECODRYL','Vial','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13193,NULL,'drug','DRx0013551','RECODRYL','Vial','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13194,NULL,'drug','DRx0013552','RECOMINT','Sir','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13195,NULL,'drug','DRx0013553','RECOVIT','Sir','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13196,NULL,'drug','DRx0013554','RECOVIT','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13197,NULL,'drug','DRx0013555','RECOVIT PLUS','Kaps','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13198,NULL,'drug','DRx0013556','REDOXON DOUBLE ACTION','Tab Eff','Bayer Schering Pharma',NULL,NULL,'0.00'),(13199,NULL,'drug','DRx0013557','REDOXON DOUBLE ACTION','Tab Kunyah','Bayer Schering Pharma',NULL,NULL,'0.00'),(13200,NULL,'drug','DRx0013558','REDUCTIL','Kaps','Abbott',NULL,NULL,'0.00'),(13201,NULL,'drug','DRx0013559','REDUCTIL','Kaps','Abbott',NULL,NULL,'0.00'),(13202,NULL,'drug','DRx0013560','REFLEXOR','Krim','Combiphar',NULL,NULL,'0.00'),(13203,NULL,'drug','DRx0013561','REFLEXOR','Tab','Combiphar',NULL,NULL,'0.00'),(13204,NULL,'drug','DRx0013562','REGIT','Sir','Landson',NULL,NULL,'0.00'),(13205,NULL,'drug','DRx0013563','REGIT','Tab Salut Selaput','Landson',NULL,NULL,'0.00'),(13206,NULL,'drug','DRx0013564','REGIT','Tetes','Landson',NULL,NULL,'0.00'),(13207,NULL,'drug','DRx0013565','REGIVELL','Amp','Novell Pharma',NULL,NULL,'0.00'),(13208,NULL,'drug','DRx0013566','REGLUS-500','Tab','Landson',NULL,NULL,'0.00'),(13209,NULL,'drug','DRx0013567','RELIDE 2','Tab','Fahrenheit',NULL,NULL,'0.00'),(13210,NULL,'drug','DRx0013568','RELIV','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13211,NULL,'drug','DRx0013569','RELIVAN','Amp','Novell Pharma',NULL,NULL,'0.00'),(13212,NULL,'drug','DRx0013570','REMACAM','Tab','Mugi Labs',NULL,NULL,'0.00'),(13213,NULL,'drug','DRx0013571','REMAKRIM','Krim','Medikon',NULL,NULL,'0.00'),(13214,NULL,'drug','DRx0013572','REMAPRO','Tab Salut Enterik','Mersifarma TM',NULL,NULL,'0.00'),(13215,NULL,'drug','DRx0013573','REMICADE','Vial','Tanabe Indonesia',NULL,NULL,'0.00'),(13216,NULL,'drug','DRx0013574','REMIFEMIN','Tab','Merck',NULL,NULL,'0.00'),(13217,NULL,'drug','DRx0013575','REMINYL','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13218,NULL,'drug','DRx0013576','REMINYL','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13219,NULL,'drug','DRx0013577','REMINYL','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13220,NULL,'drug','DRx0013578','REMOPAIN','Amp','Dexa Medica',NULL,NULL,'0.00'),(13221,NULL,'drug','DRx0013579','REMOPAIN','Amp','Dexa Medica',NULL,NULL,'0.00'),(13222,NULL,'drug','DRx0013580','RENAFIT','Bubuk','Ikapharmindo',NULL,NULL,'0.00'),(13223,NULL,'drug','DRx0013581','RENAQUIL','Tab','Fahrenheit',NULL,NULL,'0.00'),(13224,NULL,'drug','DRx0013582','RENAX','Kaps','Interbat',NULL,NULL,'0.00'),(13225,NULL,'drug','DRx0013583','RENNIE','Tab','Roche',NULL,NULL,'0.00'),(13226,NULL,'drug','DRx0013584','RENNIE','Tab','Roche',NULL,NULL,'0.00'),(13227,NULL,'drug','DRx0013585','RENODIOL','Tab Salut Gula','Sanbe',NULL,NULL,'0.00'),(13228,NULL,'drug','DRx0013586','RENOVIT','Kapl','Konimex',NULL,NULL,'0.00'),(13229,NULL,'drug','DRx0013587','RENOVIT','Kaps','Konimex',NULL,NULL,'0.00'),(13230,NULL,'drug','DRx0013588','RENVOL','Emulgel','Otto',NULL,NULL,'0.00'),(13231,NULL,'drug','DRx0013589','RENXAMIN','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13232,NULL,'drug','DRx0013590','RENXAMIN','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13233,NULL,'drug','DRx0013591','RESCUVOLIN','Tab','Pharmachemie',NULL,NULL,'0.00'),(13234,NULL,'drug','DRx0013592','RESCUVOLIN','Vial','Pharmachemie',NULL,NULL,'0.00'),(13235,NULL,'drug','DRx0013593','RESIBRON','Amp','Ikapharmindo',NULL,NULL,'0.00'),(13236,NULL,'drug','DRx0013594','RESIBRON','Kapl Salut Selaput','Ikapharmindo',NULL,NULL,'0.00'),(13237,NULL,'drug','DRx0013595','RESIBRON','Kapl Salut Selaput','Ikapharmindo',NULL,NULL,'0.00'),(13238,NULL,'drug','DRx0013596','RESKUIN','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13239,NULL,'drug','DRx0013597','RESKUIN','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13240,NULL,'drug','DRx0013598','RESKUIN','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13241,NULL,'drug','DRx0013599','RESVICA','Kapl Salut Enterik','Dexa Medica',NULL,NULL,'0.00'),(13242,NULL,'drug','DRx0013600','RETICOPEN','Kapl Salut Selaput','Landson',NULL,NULL,'0.00'),(13243,NULL,'drug','DRx0013601','RETIN-A','Krim','Janssen-Cilag',NULL,NULL,'0.00'),(13244,NULL,'drug','DRx0013602','RETIN-A','Krim','Janssen-Cilag',NULL,NULL,'0.00'),(13245,NULL,'drug','DRx0013603','RETIN-A','Krim','Janssen-Cilag',NULL,NULL,'0.00'),(13246,NULL,'drug','DRx0013604','RETIVIT','Tab Salut Selaput','Sanbe',NULL,NULL,'0.00'),(13247,NULL,'drug','DRx0013605','REVOLAN','Amp','Sanbe',NULL,NULL,'0.00'),(13248,NULL,'drug','DRx0013606','REVOLAN','Kaps','Sanbe',NULL,NULL,'0.00'),(13249,NULL,'drug','DRx0013607','REVOLAN','Kaps Salut Selaput','Sanbe',NULL,NULL,'0.00'),(13250,NULL,'drug','DRx0013608','REXAVIN','Kapl','Ifars',NULL,NULL,'0.00'),(13251,NULL,'drug','DRx0013609','REXAVIN','Kapl','Ifars',NULL,NULL,'0.00'),(13252,NULL,'drug','DRx0013610','REXIL','Kaps','Mestika Farma',NULL,NULL,'0.00'),(13253,NULL,'drug','DRx0013611','REXIMAX','Kaps','Nufarindo',NULL,NULL,'0.00'),(13254,NULL,'drug','DRx0013612','REYATAZ','Kaps','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13255,NULL,'drug','DRx0013613','REYATAZ','Kaps','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13256,NULL,'drug','DRx0013614','REYATAZ','Kaps','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13257,NULL,'drug','DRx0013615','REZONAX','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(13258,NULL,'drug','DRx0013616','RG-Q','Tab','Combiphar',NULL,NULL,'0.00'),(13259,NULL,'drug','DRx0013617','RHEMACOX','Tab','Actavis',NULL,NULL,'0.00'),(13260,NULL,'drug','DRx0013618','RHEMACOX','Tab','Actavis',NULL,NULL,'0.00'),(13261,NULL,'drug','DRx0013619','RHEMAFAR','Kapl','Ifars',NULL,NULL,'0.00'),(13262,NULL,'drug','DRx0013620','RHEUMADEN','Kaps','Novell Pharma',NULL,NULL,'0.00'),(13263,NULL,'drug','DRx0013621','RHEUMADEN','Kaps','Novell Pharma',NULL,NULL,'0.00'),(13264,NULL,'drug','DRx0013622','RHEUMAKUR','Kaps Lunak','Darya-Varia',NULL,NULL,'0.00'),(13265,NULL,'drug','DRx0013623','RHEUMAPILL','Kapl','Supra Ferbindo',NULL,NULL,'0.00'),(13266,NULL,'drug','DRx0013624','RHEUMATIN','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13267,NULL,'drug','DRx0013625','RHEUMATIN FORTE','Kapl Salut Selaput F','Sandoz',NULL,NULL,'0.00'),(13268,NULL,'drug','DRx0013626','RHINOFED','Susp','Dexa Medica',NULL,NULL,'0.00'),(13269,NULL,'drug','DRx0013627','RHINOS SR','Kaps','Dexa Medica',NULL,NULL,'0.00'),(13270,NULL,'drug','DRx0013628','RIABAL','Tab','Hexpharm',NULL,NULL,'0.00'),(13271,NULL,'drug','DRx0013629','RIBUNAL','Susp','Combiphar',NULL,NULL,'0.00'),(13272,NULL,'drug','DRx0013630','RIBUNAL','Susp Forte','Combiphar',NULL,NULL,'0.00'),(13273,NULL,'drug','DRx0013631','RIF 150','Kaps','Armoxindo Farma',NULL,NULL,'0.00'),(13274,NULL,'drug','DRx0013632','RIFACIN','Kaptab','Prafa',NULL,NULL,'0.00'),(13275,NULL,'drug','DRx0013633','RIFACIN','Kaptab','Prafa',NULL,NULL,'0.00'),(13276,NULL,'drug','DRx0013634','RIFAMPICIN HEXPHARM','Kapl','Hexpharm',NULL,NULL,'0.00'),(13277,NULL,'drug','DRx0013635','RIFAMPICIN HEXPHARM','Kapl','Hexpharm',NULL,NULL,'0.00'),(13278,NULL,'drug','DRx0013636','RILLUS','Tab Kunyah','Kalbe Farma',NULL,NULL,'0.00'),(13279,NULL,'drug','DRx0013637','RIMACTANE','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13280,NULL,'drug','DRx0013638','RIMACTANE','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13281,NULL,'drug','DRx0013639','RIMACTAZID PAED','Tab Kunyah','Sandoz',NULL,NULL,'0.00'),(13282,NULL,'drug','DRx0013640','RIMCURE 3-FDC','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13283,NULL,'drug','DRx0013641','RIMCURE PAED','Tab Kunyah','Sandoz',NULL,NULL,'0.00'),(13284,NULL,'drug','DRx0013642','RIMSTAR 4-FDC','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13285,NULL,'drug','DRx0013643','RINDOBION 5000','Kapl Salut Selaput','Yarindo Farmatama',NULL,NULL,'0.00'),(13286,NULL,'drug','DRx0013644','RINGER GLUKOSA','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(13287,NULL,'drug','DRx0013645','RINGER GLUKOSA','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(13288,NULL,'drug','DRx0013646','RINGER LAKTAT WIDA','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(13289,NULL,'drug','DRx0013647','RINGER LAKTAT WIDA','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(13290,NULL,'drug','DRx0013648','RINGER SOLUTION','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(13291,NULL,'drug','DRx0013649','RINGER SOLUTION','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(13292,NULL,'drug','DRx0013650','RINOLIC 100','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13293,NULL,'drug','DRx0013651','RINOLIC 300','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13294,NULL,'drug','DRx0013652','RINVOX','Kapl Salut Selaput','Yarindo Farmatama',NULL,NULL,'0.00'),(13295,NULL,'drug','DRx0013653','RISINA','Sir','Tempo Scan Pacific',NULL,NULL,'0.00'),(13296,NULL,'drug','DRx0013654','RISINA','Tab Salut Selaput','Tempo Scan Pacific',NULL,NULL,'0.00'),(13297,NULL,'drug','DRx0013655','RISPERDAL','Lar','Janssen-Cilag',NULL,NULL,'0.00'),(13298,NULL,'drug','DRx0013656','RISPERDAL','Tab Salut Selaput','Janssen-Cilag',NULL,NULL,'0.00'),(13299,NULL,'drug','DRx0013657','RISPERDAL','Tab Salut Selaput','Janssen-Cilag',NULL,NULL,'0.00'),(13300,NULL,'drug','DRx0013658','RISPERDAL','Tab Salut Selaput','Janssen-Cilag',NULL,NULL,'0.00'),(13301,NULL,'drug','DRx0013659','RISPERDAL CONSTA','Vial','Janssen-Cilag/Alkermes Therapeutics',NULL,NULL,'0.00'),(13302,NULL,'drug','DRx0013660','RISPERDAL CONSTA','Vial','Janssen-Cilag/Alkermes Therapeutics',NULL,NULL,'0.00'),(13303,NULL,'drug','DRx0013661','RISPERDAL CONSTA','Vial','Janssen-Cilag/Alkermes Therapeutics',NULL,NULL,'0.00'),(13304,NULL,'drug','DRx0013662','RITALIN/RITALIN LA','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(13305,NULL,'drug','DRx0013663','RITALIN/RITALIN LA','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(13306,NULL,'drug','DRx0013664','RITALIN/RITALIN LA','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(13307,NULL,'drug','DRx0013665','RITALIN','Tab','Novartis Indonesia',NULL,NULL,'0.00'),(13308,NULL,'drug','DRx0013666','RITALIN/RITALIN LA','Tab Lepas Lambat','Novartis Indonesia',NULL,NULL,'0.00'),(13309,NULL,'drug','DRx0013667','ROBUMIN DRIP','Lar Infus','Novell Pharma',NULL,NULL,'0.00'),(13310,NULL,'drug','DRx0013668','ROBUMIN DRIP','Lar Infus','Novell Pharma',NULL,NULL,'0.00'),(13311,NULL,'drug','DRx0013669','ROBUMIN','Vial','Novell Pharma',NULL,NULL,'0.00'),(13312,NULL,'drug','DRx0013670','ROCALTROL','Kaps','Roche',NULL,NULL,'0.00'),(13313,NULL,'drug','DRx0013671','ROCALTROL','Kaps','Roche',NULL,NULL,'0.00'),(13314,NULL,'drug','DRx0013672','ROCALTROL','Kaps','Roche',NULL,NULL,'0.00'),(13315,NULL,'drug','DRx0013673','ROCULAX','Amp','Kalbe Farma',NULL,NULL,'0.00'),(13316,NULL,'drug','DRx0013674','ROKSICAP','Kaps','Sanbe/Cafrifarmindo',NULL,NULL,'0.00'),(13317,NULL,'drug','DRx0013675','ROLAC','Amp','Actavis',NULL,NULL,'0.00'),(13318,NULL,'drug','DRx0013676','ROLAC','Amp','Actavis',NULL,NULL,'0.00'),(13319,NULL,'drug','DRx0013677','ROMICEF','Vial','Meprofarm',NULL,NULL,'0.00'),(13320,NULL,'drug','DRx0013678','ROMILAR/ROMILAR EXPECTORANT','Drag','Bayer Schering Pharma',NULL,NULL,'0.00'),(13321,NULL,'drug','DRx0013679','ROMILAR/ROMILAR EXPECTORANT','Sir','Bayer Schering Pharma',NULL,NULL,'0.00'),(13322,NULL,'drug','DRx0013680','RONEM','Vial','Fahrenheit',NULL,NULL,'0.00'),(13323,NULL,'drug','DRx0013681','RONEM','Vial','Fahrenheit',NULL,NULL,'0.00'),(13324,NULL,'drug','DRx0013682','RONEX','Amp','Pharos',NULL,NULL,'0.00'),(13325,NULL,'drug','DRx0013683','ROVADIN','Sir','Otto',NULL,NULL,'0.00'),(13326,NULL,'drug','DRx0013684','ROVAMYCINE','Tab','Sanofi Aventis',NULL,NULL,'0.00'),(13327,NULL,'drug','DRx0013685','ROVERTON','Kapl','Ifars',NULL,NULL,'0.00'),(13328,NULL,'drug','DRx0013686','ROVERTON','Sir','Ifars',NULL,NULL,'0.00'),(13329,NULL,'drug','DRx0013687','ROXBI','Vial','Sandoz',NULL,NULL,'0.00'),(13330,NULL,'drug','DRx0013688','RUBIDOX','Vial','Sandoz',NULL,NULL,'0.00'),(13331,NULL,'drug','DRx0013689','RUBIDOX','Vial','Sandoz',NULL,NULL,'0.00'),(13332,NULL,'drug','DRx0013690','RYCEF','Vial','Interbat',NULL,NULL,'0.00'),(13333,NULL,'drug','DRx0013691','RYDIAN','Tab Salut Selaput','Guardian Pharmatama',NULL,NULL,'0.00'),(13334,NULL,'drug','DRx0013692','RYTMONORM','Tab Salut Selaput','Abbott',NULL,NULL,'0.00'),(13335,NULL,'drug','DRx0013693','RYVEL','Sir','Novell Pharma',NULL,NULL,'0.00'),(13336,NULL,'drug','DRx0013694','RYVEL','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(13337,NULL,'drug','DRx0013695','RYVEL','Tetes','Novell Pharma',NULL,NULL,'0.00'),(13338,NULL,'drug','DRx0013696','RYZEN','Lar','UCB Pharma',NULL,NULL,'0.00'),(13339,NULL,'drug','DRx0013697','RYZEN','Tab','UCB Pharma',NULL,NULL,'0.00'),(13340,NULL,'drug','DRx0013698','RYZEN','Tetes','UCB Pharma',NULL,NULL,'0.00'),(13341,NULL,'drug','DRx0013699','RYZO','Kapl Salut Selaput','Soho',NULL,NULL,'0.00'),(13342,NULL,'drug','DRx0013700','S-26','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13343,NULL,'drug','DRx0013701','S-26','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13344,NULL,'drug','DRx0013702','S-26 GOLD','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13345,NULL,'drug','DRx0013703','S-26 GOLD','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13346,NULL,'drug','DRx0013704','S-26 GOLD 1 WITH LUTEIN','Bubuk','Wyeth Nutrition',NULL,NULL,'0.00'),(13347,NULL,'drug','DRx0013705','S-26 MOM','Tab','Wyeth',NULL,NULL,'0.00'),(13348,NULL,'drug','DRx0013706','S-26 MOM','Tab','Wyeth',NULL,NULL,'0.00'),(13349,NULL,'drug','DRx0013707','S-26 RITF GOLD 1 WITH LUTEIN','Lar','Wyeth Nutrition',NULL,NULL,'0.00'),(13350,NULL,'drug','DRx0013708','SACCHARIN','Tab','Soho',NULL,NULL,'0.00'),(13351,NULL,'drug','DRx0013709','SAFOL','Amp','Novell Pharma',NULL,NULL,'0.00'),(13352,NULL,'drug','DRx0013710','SAGALON','Krim','SDM Lab',NULL,NULL,'0.00'),(13353,NULL,'drug','DRx0013711','SAGESTAM','Tetes','Sanbe',NULL,NULL,'0.00'),(13354,NULL,'drug','DRx0013712','SAHNE','Krim','Eisai',NULL,NULL,'0.00'),(13355,NULL,'drug','DRx0013713','SAIZEN','Vial','DKSH/Sereno',NULL,NULL,'0.00'),(13356,NULL,'drug','DRx0013714','SAIZEN','Vial','DKSH/Sereno',NULL,NULL,'0.00'),(13357,NULL,'drug','DRx0013715','SALGEN','Salep','Erlimpex',NULL,NULL,'0.00'),(13358,NULL,'drug','DRx0013716','SALOFALK','Enema','Darya - Varia/Dr Falk',NULL,NULL,'0.00'),(13359,NULL,'drug','DRx0013717','SALOFALK','Supp','Darya - Varia/Dr Falk',NULL,NULL,'0.00'),(13360,NULL,'drug','DRx0013718','SALOFALK','Tab Salut Enterik','Darya - Varia/Dr Falk',NULL,NULL,'0.00'),(13361,NULL,'drug','DRx0013719','SANAFLU PLUS','Sir','Sanbe',NULL,NULL,'0.00'),(13362,NULL,'drug','DRx0013720','SAN-B-PLEX BABY DROPS','Tetes','Sanbe',NULL,NULL,'0.00'),(13363,NULL,'drug','DRx0013721','SANCORMYCIN','Salep','Sanbe',NULL,NULL,'0.00'),(13364,NULL,'drug','DRx0013722','SANDEPRIL 50','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13365,NULL,'drug','DRx0013723','SANDOCEF','Vial','Sandoz',NULL,NULL,'0.00'),(13366,NULL,'drug','DRx0013724','SANDOCEF','Vial','Sandoz',NULL,NULL,'0.00'),(13367,NULL,'drug','DRx0013725','SANGOBION','Sir','Merck',NULL,NULL,'0.00'),(13368,NULL,'drug','DRx0013726','SANGOBION ACTIFE','Sir','Merck',NULL,NULL,'0.00'),(13369,NULL,'drug','DRx0013727','SANOSVIT','Sir','Novell Pharma',NULL,NULL,'0.00'),(13370,NULL,'drug','DRx0013728','SANTA-E','Kapl Kunyah','Sanbe',NULL,NULL,'0.00'),(13371,NULL,'drug','DRx0013729','SANTA-E','Kapl Kunyah','Sanbe',NULL,NULL,'0.00'),(13372,NULL,'drug','DRx0013730','SANTIBI','Tab','Sanbe',NULL,NULL,'0.00'),(13373,NULL,'drug','DRx0013731','SARTAXAL','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13374,NULL,'drug','DRx0013732','SCANALGIN','Kapl Salut Selaput','Tempo Scan Pacific',NULL,NULL,'0.00'),(13375,NULL,'drug','DRx0013733','SCANDENE','Gel','Tempo Scan Pacific',NULL,NULL,'0.00'),(13376,NULL,'drug','DRx0013734','SCANDEXON','Tab','Tempo Scan Pacific',NULL,NULL,'0.00'),(13377,NULL,'drug','DRx0013735','SCANIDIN','Tab','Tempo Scan Pacific',NULL,NULL,'0.00'),(13378,NULL,'drug','DRx0013736','SCANMECOB','Kaps','Tempo Scan Pacific',NULL,NULL,'0.00'),(13379,NULL,'drug','DRx0013737','SCANSEPTA','Gargle','Tempo Scan Pacific',NULL,NULL,'0.00'),(13380,NULL,'drug','DRx0013738','SCANSEPTA','Lar','Tempo Scan Pacific',NULL,NULL,'0.00'),(13381,NULL,'drug','DRx0013739','SCANSEPTA','Lar','Tempo Scan Pacific',NULL,NULL,'0.00'),(13382,NULL,'drug','DRx0013740','SCANTROPIL','Kapl Salut Selaput','Tempo Scan Pacific',NULL,NULL,'0.00'),(13383,NULL,'drug','DRx0013741','SCANTROPIL','Kapl Salut Selaput','Tempo Scan Pacific',NULL,NULL,'0.00'),(13384,NULL,'drug','DRx0013742','SCELTO','Amp','Pharos',NULL,NULL,'0.00'),(13385,NULL,'drug','DRx0013743','SCELTO','Amp','Pharos',NULL,NULL,'0.00'),(13386,NULL,'drug','DRx0013744','SCOPAMIN','Amp','Otto',NULL,NULL,'0.00'),(13387,NULL,'drug','DRx0013745','SCOPAMIN','Tab Salut Selaput','Otto',NULL,NULL,'0.00'),(13388,NULL,'drug','DRx0013746','SCOPAMIN PLUS','Kapl Salut Selaput','Otto',NULL,NULL,'0.00'),(13389,NULL,'drug','DRx0013747','SCOTT\'S E VITA','Lar','GlaxoSmithKline',NULL,NULL,'0.00'),(13390,NULL,'drug','DRx0013748','SCOTT\'S E VITA','Lar','GlaxoSmithKline',NULL,NULL,'0.00'),(13391,NULL,'drug','DRx0013749','SCOTT\'S EMULSION ORANGE','Lar','GlaxoSmithKline',NULL,NULL,'0.00'),(13392,NULL,'drug','DRx0013750','SEBELIUM-10','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13393,NULL,'drug','DRx0013751','SEBELIUM-5','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13394,NULL,'drug','DRx0013752','SEBIVO','Tab Salut Selaput','Novartis Indonesia',NULL,NULL,'0.00'),(13395,NULL,'drug','DRx0013753','SEDAKTER','Sir','Corsa',NULL,NULL,'0.00'),(13396,NULL,'drug','DRx0013754','SEDAKTER','Tab','Corsa',NULL,NULL,'0.00'),(13397,NULL,'drug','DRx0013755','SELOXY','Kapl Salut Selaput','Ferron',NULL,NULL,'0.00'),(13398,NULL,'drug','DRx0013756','SELVIM','Kapl','Ifars',NULL,NULL,'0.00'),(13399,NULL,'drug','DRx0013757','SEMI-DAONIL','Tab','Sanofi Aventis',NULL,NULL,'0.00'),(13400,NULL,'drug','DRx0013758','SEPTADINE','Lar','Prafa',NULL,NULL,'0.00'),(13401,NULL,'drug','DRx0013759','SEPTADINE','Lar','Prafa',NULL,NULL,'0.00'),(13402,NULL,'drug','DRx0013760','SER-AP-ES','Tab','Novartis Indonesia',NULL,NULL,'0.00'),(13403,NULL,'drug','DRx0013761','SERENAL-10','Drag','Sankyo',NULL,NULL,'0.00'),(13404,NULL,'drug','DRx0013762','SEREVENT','Diskhaler','GlaxoSmithKline',NULL,NULL,'0.00'),(13405,NULL,'drug','DRx0013763','SEREVENT','Inhaler','GlaxoSmithKline',NULL,NULL,'0.00'),(13406,NULL,'drug','DRx0013764','SEREVENT','Rotadisk','GlaxoSmithKline',NULL,NULL,'0.00'),(13407,NULL,'drug','DRx0013765','SERLOF','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13408,NULL,'drug','DRx0013766','SERNADE','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(13409,NULL,'drug','DRx0013767','SEROLIN','Tab','Kalbe Farma/Pharmacia & Upjohn',NULL,NULL,'0.00'),(13410,NULL,'drug','DRx0013768','SEROQUEL','Tab','Astra Zeneca',NULL,NULL,'0.00'),(13411,NULL,'drug','DRx0013769','SEROQUEL','Tab','Astra Zeneca',NULL,NULL,'0.00'),(13412,NULL,'drug','DRx0013770','SEROQUEL','Tab','Astra Zeneca',NULL,NULL,'0.00'),(13413,NULL,'drug','DRx0013771','SEROQUEL','Tab','Astra Zeneca',NULL,NULL,'0.00'),(13414,NULL,'drug','DRx0013772','SETROVEL','Amp','Novell Pharma',NULL,NULL,'0.00'),(13415,NULL,'drug','DRx0013773','SEVORANE','Lar','Abbott',NULL,NULL,'0.00'),(13416,NULL,'drug','DRx0013774','SGM 1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13417,NULL,'drug','DRx0013775','SGM 1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13418,NULL,'drug','DRx0013776','SGM 1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13419,NULL,'drug','DRx0013777','SGM 2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13420,NULL,'drug','DRx0013778','SGM 2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13421,NULL,'drug','DRx0013779','SGM 2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13422,NULL,'drug','DRx0013780','SGM 3','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13423,NULL,'drug','DRx0013781','SGM 3','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13424,NULL,'drug','DRx0013782','SGM 3','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13425,NULL,'drug','DRx0013783','SGM BBLR','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13426,NULL,'drug','DRx0013784','SGM BBLR','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13427,NULL,'drug','DRx0013785','SGM LLM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13428,NULL,'drug','DRx0013786','SGM LLM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13429,NULL,'drug','DRx0013787','SGM SEREAL','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13430,NULL,'drug','DRx0013788','SHARKO INSIDE','Kaps','Sahabat Lingkungan Hidup',NULL,NULL,'0.00'),(13431,NULL,'drug','DRx0013789','SHARKO INSIDE','Vial','Sahabat Lingkungan Hidup',NULL,NULL,'0.00'),(13432,NULL,'drug','DRx0013790','SHELROD-PLUS','Tab Salut Enterik','Medikon',NULL,NULL,'0.00'),(13433,NULL,'drug','DRx0013791','SIBELIUM-10','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13434,NULL,'drug','DRx0013792','SIBELIUM-5','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13435,NULL,'drug','DRx0013793','SIBITAL','Amp','Mersifarma TM',NULL,NULL,'0.00'),(13436,NULL,'drug','DRx0013794','SICLAXIM','Vial','Mersifarma TM',NULL,NULL,'0.00'),(13437,NULL,'drug','DRx0013795','SICLAXIM','Vial','Mersifarma TM',NULL,NULL,'0.00'),(13438,NULL,'drug','DRx0013796','SIFROL','Tab','Boehringer Ingelheim',NULL,NULL,'0.00'),(13439,NULL,'drug','DRx0013797','SIFROL','Tab','Boehringer Ingelheim',NULL,NULL,'0.00'),(13440,NULL,'drug','DRx0013798','SIFROL','Tab','Boehringer Ingelheim',NULL,NULL,'0.00'),(13441,NULL,'drug','DRx0013799','SILAMOX FORTE','Kaps Forte','Prafa',NULL,NULL,'0.00'),(13442,NULL,'drug','DRx0013800','SILEX','Sir','Darya-Varia',NULL,NULL,'0.00'),(13443,NULL,'drug','DRx0013801','SILUM 10','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13444,NULL,'drug','DRx0013802','SILUM 5','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13445,NULL,'drug','DRx0013803','SIMCEF','Kaps','Erlimpex',NULL,NULL,'0.00'),(13446,NULL,'drug','DRx0013804','SIMCEF','Sir Kering','Erlimpex',NULL,NULL,'0.00'),(13447,NULL,'drug','DRx0013805','SIMCHOL','Tab Salut Selaput','Ikapharmindo',NULL,NULL,'0.00'),(13448,NULL,'drug','DRx0013806','SIMILAC ADVANCE','Bubuk','Abbott',NULL,NULL,'0.00'),(13449,NULL,'drug','DRx0013807','SIMILAC ADVANCE','Bubuk','Abbott',NULL,NULL,'0.00'),(13450,NULL,'drug','DRx0013808','SIMILAC ADVANCE LF','Bubuk','Abbott',NULL,NULL,'0.00'),(13451,NULL,'drug','DRx0013809','SIMILAC MAMA\'S  BEST','Bubuk','Abbott',NULL,NULL,'0.00'),(13452,NULL,'drug','DRx0013810','SIMVASTATIN HEXPHARM','Tab','Hexpharm',NULL,NULL,'0.00'),(13453,NULL,'drug','DRx0013811','SIMVASTATIN OGB DEXA','Kaps','Dexa Medica',NULL,NULL,'0.00'),(13454,NULL,'drug','DRx0013812','SIMVASTATIN OGB DEXA','Kaps','Dexa Medica',NULL,NULL,'0.00'),(13455,NULL,'drug','DRx0013813','SINORIC','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13456,NULL,'drug','DRx0013814','SINORIC','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13457,NULL,'drug','DRx0013815','SINRAL','Tab','Bernoparm',NULL,NULL,'0.00'),(13458,NULL,'drug','DRx0013816','SINRAL','Tab','Bernoparm',NULL,NULL,'0.00'),(13459,NULL,'drug','DRx0013817','SINUPRET','Tetes','Darya-Varia/Bionorica',NULL,NULL,'0.00'),(13460,NULL,'drug','DRx0013818','SIRIMOX','Kaps','Sanbe',NULL,NULL,'0.00'),(13461,NULL,'drug','DRx0013819','SIRIMOX','Sir Kering','Sanbe',NULL,NULL,'0.00'),(13462,NULL,'drug','DRx0013820','SIRIMOX','Sir Kering Forte','Sanbe',NULL,NULL,'0.00'),(13463,NULL,'drug','DRx0013821','SIZORIL','Tab','Meprofarm',NULL,NULL,'0.00'),(13464,NULL,'drug','DRx0013822','SIZORIL','Tab','Meprofarm',NULL,NULL,'0.00'),(13465,NULL,'drug','DRx0013823','SLIP-IZZZ','Tab Salut Selaput','Ikapharmindo',NULL,NULL,'0.00'),(13466,NULL,'drug','DRx0013824','SLOAN\'S LINIMENT','Liniment','CCM Pharma',NULL,NULL,'0.00'),(13467,NULL,'drug','DRx0013825','SMECTA','Bubuk','Beafour Ipsen',NULL,NULL,'0.00'),(13468,NULL,'drug','DRx0013826','SMECTA','Bubuk','Beafour Ipsen',NULL,NULL,'0.00'),(13469,NULL,'drug','DRx0013827','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13470,NULL,'drug','DRx0013828','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13471,NULL,'drug','DRx0013829','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13472,NULL,'drug','DRx0013830','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13473,NULL,'drug','DRx0013831','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13474,NULL,'drug','DRx0013832','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13475,NULL,'drug','DRx0013833','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13476,NULL,'drug','DRx0013834','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13477,NULL,'drug','DRx0013835','SNM','Bubuk','Sari Husada',NULL,NULL,'0.00'),(13478,NULL,'drug','DRx0013836','SOBEE PLUS','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13479,NULL,'drug','DRx0013837','SOCEF','Vial','Soho',NULL,NULL,'0.00'),(13480,NULL,'drug','DRx0013838','SOCLAF','Vial','Soho',NULL,NULL,'0.00'),(13481,NULL,'drug','DRx0013839','SOCLOR','Kaps','Soho',NULL,NULL,'0.00'),(13482,NULL,'drug','DRx0013840','SOCLOR','Sir Kering','Soho',NULL,NULL,'0.00'),(13483,NULL,'drug','DRx0013841','SODERMA','Krim','Soho',NULL,NULL,'0.00'),(13484,NULL,'drug','DRx0013842','SODIME','Vial','Soho',NULL,NULL,'0.00'),(13485,NULL,'drug','DRx0013843','SODIUM BICARBONATE 8.4% PFRIMMER','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13486,NULL,'drug','DRx0013844','SODIUM BICARBONATE 8.4% PFRIMMER','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13487,NULL,'drug','DRx0013845','SODIUM CHLORIDE 0.9% EURO-MED','Lar Infus','Euro-Med',NULL,NULL,'0.00'),(13488,NULL,'drug','DRx0013846','SODIUM CHLORIDE 0.9% EURO-MED','Lar Infus','Euro-Med',NULL,NULL,'0.00'),(13489,NULL,'drug','DRx0013847','SODIUM CHLORIDE 0.9% IRRIGATION EURO-MED','Lar Infus','Euro-Med',NULL,NULL,'0.00'),(13490,NULL,'drug','DRx0013848','SODIUM NETROPRUSSIDE DBL','Amp','Tempo Scan Pacific/DBL',NULL,NULL,'0.00'),(13491,NULL,'drug','DRx0013849','SODIUM PHENYTOIN','Amp','Ikapharmindo',NULL,NULL,'0.00'),(13492,NULL,'drug','DRx0013850','SOHOBION','Tab Salut Selaput','Soho',NULL,NULL,'0.00'),(13493,NULL,'drug','DRx0013851','SOHOBION 5000','Tab Salut Selaput','Soho',NULL,NULL,'0.00'),(13494,NULL,'drug','DRx0013852','SOHOFLAM','Tab Salut Selaput','Soho',NULL,NULL,'0.00'),(13495,NULL,'drug','DRx0013853','SOHOLIN','Amp','Soho',NULL,NULL,'0.00'),(13496,NULL,'drug','DRx0013854','SOHOTIN','Tab','Soho',NULL,NULL,'0.00'),(13497,NULL,'drug','DRx0013855','SOLAC','Sir','Soho',NULL,NULL,'0.00'),(13498,NULL,'drug','DRx0013856','SOLANEURON','Kapl','Solas',NULL,NULL,'0.00'),(13499,NULL,'drug','DRx0013857','SOLANS','Kaps','Soho',NULL,NULL,'0.00'),(13500,NULL,'drug','DRx0013858','SOLARE SUNBLOCK PLUS WHITENING','Lot','Galenium Pharmasia Lab',NULL,NULL,'0.00'),(13501,NULL,'drug','DRx0013859','SOLNIFEC','Tab','Ifars',NULL,NULL,'0.00'),(13502,NULL,'drug','DRx0013860','SOLPENOX','Kaps','Solas',NULL,NULL,'0.00'),(13503,NULL,'drug','DRx0013861','SOMATOSTATIN-UCB','Vial','UCB Pharma',NULL,NULL,'0.00'),(13504,NULL,'drug','DRx0013862','SOMATOSTATIN-UCB','Vial','UCB Pharma',NULL,NULL,'0.00'),(13505,NULL,'drug','DRx0013863','SOMEROL','Tab','Soho',NULL,NULL,'0.00'),(13506,NULL,'drug','DRx0013864','SOMEROL','Tab','Soho',NULL,NULL,'0.00'),(13507,NULL,'drug','DRx0013865','SOMEROL','Vial','Soho',NULL,NULL,'0.00'),(13508,NULL,'drug','DRx0013866','SOMEROL','Vial','Soho',NULL,NULL,'0.00'),(13509,NULL,'drug','DRx0013867','SONICOR 16','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13510,NULL,'drug','DRx0013868','SONICOR 4','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13511,NULL,'drug','DRx0013869','SONIGEN','Krim','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13512,NULL,'drug','DRx0013870','SOPERAM','Vial','Soho',NULL,NULL,'0.00'),(13513,NULL,'drug','DRx0013871','SOPRADEX ','Tetes','Sanofi Aventis',NULL,NULL,'0.00'),(13514,NULL,'drug','DRx0013872','SORBITOL CORSA/SANOFI-SYNTHELABO','Bubuk','Corsa/Sanofi-Synthelabo',NULL,NULL,'0.00'),(13515,NULL,'drug','DRx0013873','SOROV','Kapl','Soho',NULL,NULL,'0.00'),(13516,NULL,'drug','DRx0013874','SOTENS','Kapl Salut Selaput','Soho',NULL,NULL,'0.00'),(13517,NULL,'drug','DRx0013875','SOTROPIL','Amp','Soho',NULL,NULL,'0.00'),(13518,NULL,'drug','DRx0013876','SOTROPIL','Amp','Soho',NULL,NULL,'0.00'),(13519,NULL,'drug','DRx0013877','SOTROPIL','Kapl','Soho',NULL,NULL,'0.00'),(13520,NULL,'drug','DRx0013878','SOTROPIL','Kapl','Soho',NULL,NULL,'0.00'),(13521,NULL,'drug','DRx0013879','SOTROPIL','Kaps','Soho',NULL,NULL,'0.00'),(13522,NULL,'drug','DRx0013880','SOXIETAS','Tab','Soho',NULL,NULL,'0.00'),(13523,NULL,'drug','DRx0013881','SOXIETAS','Tab','Soho',NULL,NULL,'0.00'),(13524,NULL,'drug','DRx0013882','SP TROCHES MEIJI','Tab Hisap','Meiji',NULL,NULL,'0.00'),(13525,NULL,'drug','DRx0013883','SP TROCHES MEIJI','Tab Hisap','Meiji',NULL,NULL,'0.00'),(13526,NULL,'drug','DRx0013884','SPASHI','Amp','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13527,NULL,'drug','DRx0013885','SPASHI','Tab Salut Selaput','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13528,NULL,'drug','DRx0013886','SPASHI PLUS','Kapl Salut Selaput','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13529,NULL,'drug','DRx0013887','SPASLIC','Kapl','Berlico Mulia Farma',NULL,NULL,'0.00'),(13530,NULL,'drug','DRx0013888','SPASMIUM','Drag','Soho',NULL,NULL,'0.00'),(13531,NULL,'drug','DRx0013889','SPASMOMEN','Tab Salut Selaput','Dexa Medica/A Menarini',NULL,NULL,'0.00'),(13532,NULL,'drug','DRx0013890','SPAXIM','Kaps','Sandoz',NULL,NULL,'0.00'),(13533,NULL,'drug','DRx0013891','SPAXIM','Kaps','Sandoz',NULL,NULL,'0.00'),(13534,NULL,'drug','DRx0013892','SPAXIM','Sir Kering','Sandoz',NULL,NULL,'0.00'),(13535,NULL,'drug','DRx0013893','SPEDIFEN','Tab Salut Selaput','Zambon',NULL,NULL,'0.00'),(13536,NULL,'drug','DRx0013894','SPERSADEX COMP','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(13537,NULL,'drug','DRx0013895','SPERSANICOL','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(13538,NULL,'drug','DRx0013896','SPERSANICOL','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(13539,NULL,'drug','DRx0013897','SPIRAMYCIN OGB DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(13540,NULL,'drug','DRx0013898','SPIRIVA','Inhaler','Boehringer Ingelheim',NULL,NULL,'0.00'),(13541,NULL,'drug','DRx0013899','SPIRIVA','Inhaler','Boehringer Ingelheim',NULL,NULL,'0.00'),(13542,NULL,'drug','DRx0013900','SPIROLA','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13543,NULL,'drug','DRx0013901','SPIROLA','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13544,NULL,'drug','DRx0013902','SPIRUMATE','Kaps','ASB/PALS',NULL,NULL,'0.00'),(13545,NULL,'drug','DRx0013903','SPIRUMATE','Kaps','ASB/PALS',NULL,NULL,'0.00'),(13546,NULL,'drug','DRx0013904','SPITADERM','Lar','Paragerm',NULL,NULL,'0.00'),(13547,NULL,'drug','DRx0013905','SPORACID','Kaps','Ferron',NULL,NULL,'0.00'),(13548,NULL,'drug','DRx0013906','SPORANOX','Kaps','Ferron',NULL,NULL,'0.00'),(13549,NULL,'drug','DRx0013907','SPORANOX','Lar','Ferron',NULL,NULL,'0.00'),(13550,NULL,'drug','DRx0013908','SPORETIK','Sir Kering','Sanbe',NULL,NULL,'0.00'),(13551,NULL,'drug','DRx0013909','SPOREX','Krim','Tempo Scan Pacific',NULL,NULL,'0.00'),(13552,NULL,'drug','DRx0013910','SPRYCEL','Tab Salut Selaput','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13553,NULL,'drug','DRx0013911','SPRYCEL','Tab Salut Selaput','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13554,NULL,'drug','DRx0013912','SPRYCEL','Tab Salut Selaput','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13555,NULL,'drug','DRx0013913','STABACTAM','Vial','Fahrenheit',NULL,NULL,'0.00'),(13556,NULL,'drug','DRx0013914','STABLON','Tab','Servier',NULL,NULL,'0.00'),(13557,NULL,'drug','DRx0013915','STACARE','Tab','Nufarindo',NULL,NULL,'0.00'),(13558,NULL,'drug','DRx0013916','STALEVO','Tab Salut Selaput','Novartis Indonesia',NULL,NULL,'0.00'),(13559,NULL,'drug','DRx0013917','STALEVO','Tab Salut Selaput','Novartis Indonesia',NULL,NULL,'0.00'),(13560,NULL,'drug','DRx0013918','STAMINO','Kapl Salut Selaput','Tropica Mas Pharma',NULL,NULL,'0.00'),(13561,NULL,'drug','DRx0013919','STAMINO','Sir','Tropica Mas Pharma',NULL,NULL,'0.00'),(13562,NULL,'drug','DRx0013920','STAMINO','Sir','Tropica Mas Pharma',NULL,NULL,'0.00'),(13563,NULL,'drug','DRx0013921','STANDACILLIN','Kaps','Sandoz',NULL,NULL,'0.00'),(13564,NULL,'drug','DRx0013922','STARLIX','Tab Salut Selaput','Novartis Indonesia',NULL,NULL,'0.00'),(13565,NULL,'drug','DRx0013923','STARMUNO','Kapl Salut Selaput','Kalbe Farma',NULL,NULL,'0.00'),(13566,NULL,'drug','DRx0013924','STARMUNO','Sir','Kalbe Farma',NULL,NULL,'0.00'),(13567,NULL,'drug','DRx0013925','STARXON','Vial','Interbat',NULL,NULL,'0.00'),(13568,NULL,'drug','DRx0013926','STAVIT','Tab Salut Selaput','Nufarindo',NULL,NULL,'0.00'),(13569,NULL,'drug','DRx0013927','STAZOL','Tab','Bernoparm',NULL,NULL,'0.00'),(13570,NULL,'drug','DRx0013928','STELATOPIA CLEANSING CREAM','Krim','Interbat',NULL,NULL,'0.00'),(13571,NULL,'drug','DRx0013929','STELATOPIA EMOLIENT CREAM','Krim','Interbat',NULL,NULL,'0.00'),(13572,NULL,'drug','DRx0013930','STELATOPIA MILKY BATH OIL','Sabun Cair','Interbat',NULL,NULL,'0.00'),(13573,NULL,'drug','DRx0013931','STENIROL','Tab','Guardian Pharmatama',NULL,NULL,'0.00'),(13574,NULL,'drug','DRx0013932','STENIROL','Tab','Guardian Pharmatama',NULL,NULL,'0.00'),(13575,NULL,'drug','DRx0013933','STEOPOR','Kapl Salut Selaput','Otto',NULL,NULL,'0.00'),(13576,NULL,'drug','DRx0013934','STILNOX','Tab','Sanofi Aventis',NULL,NULL,'0.00'),(13577,NULL,'drug','DRx0013935','STIMOX','Kaps','Solas',NULL,NULL,'0.00'),(13578,NULL,'drug','DRx0013936','STIMOX','Sir','Solas',NULL,NULL,'0.00'),(13579,NULL,'drug','DRx0013937','STIMULIT','Tab','Fahrenheit',NULL,NULL,'0.00'),(13580,NULL,'drug','DRx0013938','STOMACAIN','Tab','Combiphar',NULL,NULL,'0.00'),(13581,NULL,'drug','DRx0013939','STOMADON','Tab','Soho',NULL,NULL,'0.00'),(13582,NULL,'drug','DRx0013940','STRONGER NEO-MINOPHAGEN C','Amp','Dexa Medica',NULL,NULL,'0.00'),(13583,NULL,'drug','DRx0013941','STUGERON','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13584,NULL,'drug','DRx0013942','STUGERON','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13585,NULL,'drug','DRx0013943','SUBUTEX','Tab Sublingual','Schering-Plough',NULL,NULL,'0.00'),(13586,NULL,'drug','DRx0013944','SUBUTEX','Tab Sublingual','Schering-Plough',NULL,NULL,'0.00'),(13587,NULL,'drug','DRx0013945','SULCOLON','Tab','Bernoparm',NULL,NULL,'0.00'),(13588,NULL,'drug','DRx0013946','SULFAS FERROSUS','Drag','Kimia Farma',NULL,NULL,'0.00'),(13589,NULL,'drug','DRx0013947','SULFITIS','Tab Salut Enterik','Fahrenheit',NULL,NULL,'0.00'),(13590,NULL,'drug','DRx0013948','SULPERAZON','Vial','Pfizer',NULL,NULL,'0.00'),(13591,NULL,'drug','DRx0013949','SUMAGESIC','Sir','Medifarma/UAP',NULL,NULL,'0.00'),(13592,NULL,'drug','DRx0013950','SUMAGESIC','Sir','Medifarma/UAP',NULL,NULL,'0.00'),(13593,NULL,'drug','DRx0013951','SUMAGESIC','Tetes','Medifarma/UAP',NULL,NULL,'0.00'),(13594,NULL,'drug','DRx0013952','SUN RECOME','Bubuk','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(13595,NULL,'drug','DRx0013953','SUPLASYN','Vial','Dipa Pharmalab Intersains ',NULL,NULL,'0.00'),(13596,NULL,'drug','DRx0013954','SUPLIN','Lar Infus','Sandoz',NULL,NULL,'0.00'),(13597,NULL,'drug','DRx0013955','SUPRA FLU','Tab','Kimia Farma',NULL,NULL,'0.00'),(13598,NULL,'drug','DRx0013956','SUPRABION','Kaps','Berlico Mulia Farma',NULL,NULL,'0.00'),(13599,NULL,'drug','DRx0013957','SUPRADYN','Kapl','Bayer Schering Pharma',NULL,NULL,'0.00'),(13600,NULL,'drug','DRx0013958','SUPRADYN','Tab Eff','Bayer Schering Pharma',NULL,NULL,'0.00'),(13601,NULL,'drug','DRx0013959','SUPRAFENID','Amp','Meprofarm',NULL,NULL,'0.00'),(13602,NULL,'drug','DRx0013960','SUPRAFENID','Supp','Meprofarm',NULL,NULL,'0.00'),(13603,NULL,'drug','DRx0013961','SUPRANAL','Tab','Dexa Medica',NULL,NULL,'0.00'),(13604,NULL,'drug','DRx0013962','SUPRANE','Lar','Kalbe Farma',NULL,NULL,'0.00'),(13605,NULL,'drug','DRx0013963','SUPRAZID 300','Tab','Armoxindo Farma',NULL,NULL,'0.00'),(13606,NULL,'drug','DRx0013964','SURBEX-T','Lar','Abbott',NULL,NULL,'0.00'),(13607,NULL,'drug','DRx0013965','SURBEX-T','Tab Salut Selaput','Abbott',NULL,NULL,'0.00'),(13608,NULL,'drug','DRx0013966','SURBEX-Z','Tab Salut Selaput','Abbott',NULL,NULL,'0.00'),(13609,NULL,'drug','DRx0013967','SURVANTA','Vial','Abbott',NULL,NULL,'0.00'),(13610,NULL,'drug','DRx0013968','SUSTAGEN JUNIOR','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13611,NULL,'drug','DRx0013969','SUSTAGEN JUNIOR','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13612,NULL,'drug','DRx0013970','SUSTAGEN JUNIOR','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13613,NULL,'drug','DRx0013971','SUSTAGEN KID','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13614,NULL,'drug','DRx0013972','SUSTAGEN KID','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13615,NULL,'drug','DRx0013973','SUSTAGEN KID','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13616,NULL,'drug','DRx0013974','SUSTAGEN SCHOOL','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13617,NULL,'drug','DRx0013975','SUSTAGEN SCHOOL','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13618,NULL,'drug','DRx0013976','SUSTAGEN SCHOOL','Bubuk','Mead Johnson',NULL,NULL,'0.00'),(13619,NULL,'drug','DRx0013977','SYMBICORT 160/4.5 MCG/DOSIS','Turbuhaler','Astra Zeneca',NULL,NULL,'0.00'),(13620,NULL,'drug','DRx0013978','SYMBICORT 160/4.5 MCG/DOSIS','Turbuhaler','Astra Zeneca',NULL,NULL,'0.00'),(13621,NULL,'drug','DRx0013979','SYMBICORT 80/4.5 MCG','Turbuhaler','Astra Zeneca',NULL,NULL,'0.00'),(13622,NULL,'drug','DRx0013980','SYNBIO','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(13623,NULL,'drug','DRx0013981','SYNECLAV','Kapl','Coronet',NULL,NULL,'0.00'),(13624,NULL,'drug','DRx0013982','SYNECLAV','Sir','Coronet',NULL,NULL,'0.00'),(13625,NULL,'drug','DRx0013983','SYNECLAV','Sir Kering Forte','Coronet',NULL,NULL,'0.00'),(13626,NULL,'drug','DRx0013984','SYNFLEX','Kapl','Darya-Varia',NULL,NULL,'0.00'),(13627,NULL,'drug','DRx0013985','SYNFLEX','Kapl','Darya-Varia',NULL,NULL,'0.00'),(13628,NULL,'drug','DRx0013986','SYNTOCINON','Amp','Novartis Indonesia',NULL,NULL,'0.00'),(13629,NULL,'drug','DRx0013987','TAKELIN','Amp','Mersifarma TM',NULL,NULL,'0.00'),(13630,NULL,'drug','DRx0013988','TAKELIN','Amp','Mersifarma TM',NULL,NULL,'0.00'),(13631,NULL,'drug','DRx0013989','TAMOFEN','Tab Salut Selaput','Kalbe Farma',NULL,NULL,'0.00'),(13632,NULL,'drug','DRx0013990','TAMOPLEX','Tab','Pharmachemie',NULL,NULL,'0.00'),(13633,NULL,'drug','DRx0013991','TAMOPLEX','Tab','Pharmachemie',NULL,NULL,'0.00'),(13634,NULL,'drug','DRx0013992','TAMOXIFEN EBEWE','Tab','Ferron/Ebewe',NULL,NULL,'0.00'),(13635,NULL,'drug','DRx0013993','TAMOXIFEN EBEWE','Tab','Ferron/Ebewe',NULL,NULL,'0.00'),(13636,NULL,'drug','DRx0013994','TANAKAN','Tab','Beaufour Ipsen',NULL,NULL,'0.00'),(13637,NULL,'drug','DRx0013995','TANAPRESS','Tab','Tanabe Indonesia',NULL,NULL,'0.00'),(13638,NULL,'drug','DRx0013996','TANFLEX','Gargle','Combiphar',NULL,NULL,'0.00'),(13639,NULL,'drug','DRx0013997','TARGOCID','Vial','Sanofi Aventis',NULL,NULL,'0.00'),(13640,NULL,'drug','DRx0013998','TARID OTIC','Tetes','Kalbe/Daiichi',NULL,NULL,'0.00'),(13641,NULL,'drug','DRx0013999','TARKA','Kaps','Abbott',NULL,NULL,'0.00'),(13642,NULL,'drug','DRx0014000','TARKA','Kaps','Abbott',NULL,NULL,'0.00'),(13643,NULL,'drug','DRx0014001','TAXEN','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13644,NULL,'drug','DRx0014002','TAXEN','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13645,NULL,'drug','DRx0014003','TAXEN','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13646,NULL,'drug','DRx0014004','TAXIMAX','Vial','Nufarindo',NULL,NULL,'0.00'),(13647,NULL,'drug','DRx0014005','TB VIT 6','Sir','Meprofarm',NULL,NULL,'0.00'),(13648,NULL,'drug','DRx0014006','TB ZET','Tab','Meprofarm',NULL,NULL,'0.00'),(13649,NULL,'drug','DRx0014007','TEARS NATURALE II','Tetes','Alcon',NULL,NULL,'0.00'),(13650,NULL,'drug','DRx0014008','TELFAST BD','Tab','Sanofi Aventis',NULL,NULL,'0.00'),(13651,NULL,'drug','DRx0014009','TELFAST HD','Tab Salut Selaput','Sanofi Aventis',NULL,NULL,'0.00'),(13652,NULL,'drug','DRx0014010','TELFAST PLUS','Tab Lepas Lambat','Sanofi Aventis',NULL,NULL,'0.00'),(13653,NULL,'drug','DRx0014011','TELFAST PLUS','Tab Lepas Lambat','Sanofi Aventis',NULL,NULL,'0.00'),(13654,NULL,'drug','DRx0014012','TEMODAL','Kaps','Schering-Plough',NULL,NULL,'0.00'),(13655,NULL,'drug','DRx0014013','TEMODAL','Kaps','Schering-Plough',NULL,NULL,'0.00'),(13656,NULL,'drug','DRx0014014','TEMODAL','Kaps','Schering-Plough',NULL,NULL,'0.00'),(13657,NULL,'drug','DRx0014015','TEMODAL','Kaps','Schering-Plough',NULL,NULL,'0.00'),(13658,NULL,'drug','DRx0014016','TEMPRA/TEMPRA FORTE','Sir Forte','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13659,NULL,'drug','DRx0014017','TENAPRIL','Kapl','Dexa medica',NULL,NULL,'0.00'),(13660,NULL,'drug','DRx0014018','TENAPRIL','Kapl','Dexa medica',NULL,NULL,'0.00'),(13661,NULL,'drug','DRx0014019','TENAPRIL','Kapl','Dexa medica',NULL,NULL,'0.00'),(13662,NULL,'drug','DRx0014020','TENAPRIL','Kapl','Dexa medica',NULL,NULL,'0.00'),(13663,NULL,'drug','DRx0014021','TENAZIDE','Tab','Combiphar',NULL,NULL,'0.00'),(13664,NULL,'drug','DRx0014022','TENBLOK','Tab','Kimia Farma',NULL,NULL,'0.00'),(13665,NULL,'drug','DRx0014023','TENBLOK','Tab','Kimia Farma',NULL,NULL,'0.00'),(13666,NULL,'drug','DRx0014024','TENORMIN','Inj','Astra Zeneca',NULL,NULL,'0.00'),(13667,NULL,'drug','DRx0014025','TENSAAR','Tab Salut Selaput','Kimia Farma',NULL,NULL,'0.00'),(13668,NULL,'drug','DRx0014026','TENSIPHAR','Tab','Actavis',NULL,NULL,'0.00'),(13669,NULL,'drug','DRx0014027','TENSIPHAR','Tab','Actavis',NULL,NULL,'0.00'),(13670,NULL,'drug','DRx0014028','TEPAXIN','Kaps','Takeda',NULL,NULL,'0.00'),(13671,NULL,'drug','DRx0014029','TEQUINOL 500','Kapl Salut Selaput','Otto',NULL,NULL,'0.00'),(13672,NULL,'drug','DRx0014030','TERA CORTRIL OPHTH','Salep','Pfizer',NULL,NULL,'0.00'),(13673,NULL,'drug','DRx0014031','TERADI','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13674,NULL,'drug','DRx0014032','TERASMA EXPECTORANT','Sir','Medikon',NULL,NULL,'0.00'),(13675,NULL,'drug','DRx0014033','TERFIN','Tab','Interbat',NULL,NULL,'0.00'),(13676,NULL,'drug','DRx0014034','TERIL','Tab','Merck',NULL,NULL,'0.00'),(13677,NULL,'drug','DRx0014035','TERMICEF','Vial','Nufarindo',NULL,NULL,'0.00'),(13678,NULL,'drug','DRx0014036','TERMISIL','Krim','Ferron',NULL,NULL,'0.00'),(13679,NULL,'drug','DRx0014037','TERMISIL','Krim','Ferron',NULL,NULL,'0.00'),(13680,NULL,'drug','DRx0014038','TERMOREX','Tetes','Konimex',NULL,NULL,'0.00'),(13681,NULL,'drug','DRx0014039','TERONETIC','Tab','Astra Zeneca',NULL,NULL,'0.00'),(13682,NULL,'drug','DRx0014040','TERRAMYCIN POLY TOPICAL','Salep','Pfizer',NULL,NULL,'0.00'),(13683,NULL,'drug','DRx0014041','TERRELL','Lar','Fahrenheit',NULL,NULL,'0.00'),(13684,NULL,'drug','DRx0014042','TERRELL','Lar','Fahrenheit',NULL,NULL,'0.00'),(13685,NULL,'drug','DRx0014043','TETRACT-HIB','Vial','Sanofi Pasteur',NULL,NULL,'0.00'),(13686,NULL,'drug','DRx0014044','TETRACT-HIB','Vial','Sanofi Pasteur',NULL,NULL,'0.00'),(13687,NULL,'drug','DRx0014045','TETRAMYCIN','Kaps','Pfizer',NULL,NULL,'0.00'),(13688,NULL,'drug','DRx0014046','TETRAMYCIN','Kaps','Pfizer',NULL,NULL,'0.00'),(13689,NULL,'drug','DRx0014047','TETRAMYCIN','Vial','Pfizer',NULL,NULL,'0.00'),(13690,NULL,'drug','DRx0014048','TETRIS','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13691,NULL,'drug','DRx0014049','TEVOX','Lar Infus','Actavis',NULL,NULL,'0.00'),(13692,NULL,'drug','DRx0014050','TEVOX','Tab Salut Selaput','Actavis',NULL,NULL,'0.00'),(13693,NULL,'drug','DRx0014051','THEOCHODIL','Sir','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13694,NULL,'drug','DRx0014052','THEOCHODIL','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13695,NULL,'drug','DRx0014053','THERAGRAN-GOLD','Tab Salut Selaput','Bristol- Myers Squibb',NULL,NULL,'0.00'),(13696,NULL,'drug','DRx0014054','THROMBO ASPILETS','Tab Salut Enterik','Medifarma/UAP',NULL,NULL,'0.00'),(13697,NULL,'drug','DRx0014055','THROMBO ASPILETS','Tab Salut Enterik','Medifarma/UAP',NULL,NULL,'0.00'),(13698,NULL,'drug','DRx0014056','THROMBOGEL','Gel','Tunggal Idaman Abadi/Nordmark',NULL,NULL,'0.00'),(13699,NULL,'drug','DRx0014057','THROMBOREDUCTIN','Kaps','AOP Orphan',NULL,NULL,'0.00'),(13700,NULL,'drug','DRx0014058','THROMBOREDUCTIN','Kaps','AOP Orphan',NULL,NULL,'0.00'),(13701,NULL,'drug','DRx0014059','THYMUN 3','Kaps','Sahabat Lingkungan Hidup',NULL,NULL,'0.00'),(13702,NULL,'drug','DRx0014060','THYROXINE ALPHARMA','Tab','Actavis',NULL,NULL,'0.00'),(13703,NULL,'drug','DRx0014061','THYROXINE ALPHARMA','Tab','Actavis',NULL,NULL,'0.00'),(13704,NULL,'drug','DRx0014062','TIACINON','Amp','Tunggal Idaman Abadi',NULL,NULL,'0.00'),(13705,NULL,'drug','DRx0014063','TIBITOL','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13706,NULL,'drug','DRx0014064','TIBITOL','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13707,NULL,'drug','DRx0014065','TICARD','Tab Salut Selaput','Sanbe',NULL,NULL,'0.00'),(13708,NULL,'drug','DRx0014066','TICLID','Tab','Sanofi Aventis',NULL,NULL,'0.00'),(13709,NULL,'drug','DRx0014067','TICLON','Tab Salut Selaput','Interbat',NULL,NULL,'0.00'),(13710,NULL,'drug','DRx0014068','TICLOPHAR','Tab Salut Selaput','Actavis',NULL,NULL,'0.00'),(13711,NULL,'drug','DRx0014069','TIENAM','Vial','Merck Sharp & Dohme',NULL,NULL,'0.00'),(13712,NULL,'drug','DRx0014070','TILCOTIL','Tab','Roche',NULL,NULL,'0.00'),(13713,NULL,'drug','DRx0014071','TILSAN','Tab Salut Selaput','Otto',NULL,NULL,'0.00'),(13714,NULL,'drug','DRx0014072','TIM-OPTHAL','Tetes','Sanbe',NULL,NULL,'0.00'),(13715,NULL,'drug','DRx0014073','TIM-OPTHAL','Tetes','Sanbe',NULL,NULL,'0.00'),(13716,NULL,'drug','DRx0014074','TINSET','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13717,NULL,'drug','DRx0014075','TIRAYT','Tab','Fahrenheit',NULL,NULL,'0.00'),(13718,NULL,'drug','DRx0014076','TIRIZ','Tab Salut Selaput','Lapi',NULL,NULL,'0.00'),(13719,NULL,'drug','DRx0014077','TIRIZ','Tetes','Lapi',NULL,NULL,'0.00'),(13720,NULL,'drug','DRx0014078','TIRMACLO','Tab Salut Enterik','Mersifarma TM',NULL,NULL,'0.00'),(13721,NULL,'drug','DRx0014079','TISON','Kapl','Landson',NULL,NULL,'0.00'),(13722,NULL,'drug','DRx0014080','TISON','Tab','Landson',NULL,NULL,'0.00'),(13723,NULL,'drug','DRx0014081','TISON','Tab','Landson',NULL,NULL,'0.00'),(13724,NULL,'drug','DRx0014082','TIVILAC','Tab','Fahrenheit',NULL,NULL,'0.00'),(13725,NULL,'drug','DRx0014083','TIVOMIT','Kapl','Berlico Mulia Farma',NULL,NULL,'0.00'),(13726,NULL,'drug','DRx0014084','TIVOMIT','Sir','Berlico Mulia Farma',NULL,NULL,'0.00'),(13727,NULL,'drug','DRx0014085','TIZOS','Vial','Dexa Medica',NULL,NULL,'0.00'),(13728,NULL,'drug','DRx0014086','TOESAL','Tab','Dexa Medica',NULL,NULL,'0.00'),(13729,NULL,'drug','DRx0014087','TOMAAG','Kapl Kunyah','Yarindo Farmatama',NULL,NULL,'0.00'),(13730,NULL,'drug','DRx0014088','TOMIT','Amp','Interbat',NULL,NULL,'0.00'),(13731,NULL,'drug','DRx0014089','TOMIT','Tab','Interbat',NULL,NULL,'0.00'),(13732,NULL,'drug','DRx0014090','TONAR','Kapl Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13733,NULL,'drug','DRx0014091','TONOCALCIN','Amp','Tempo Scan Pacific/Alpa Wassermann',NULL,NULL,'0.00'),(13734,NULL,'drug','DRx0014092','TOPAMAX','Kaps','Janssen-Cilag',NULL,NULL,'0.00'),(13735,NULL,'drug','DRx0014093','TOPAMAX','Kaps','Janssen-Cilag',NULL,NULL,'0.00'),(13736,NULL,'drug','DRx0014094','TOPAMAX','Kaps','Janssen-Cilag',NULL,NULL,'0.00'),(13737,NULL,'drug','DRx0014095','TOPAMAX','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13738,NULL,'drug','DRx0014096','TOPAMAX','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13739,NULL,'drug','DRx0014097','TOPAMAX','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13740,NULL,'drug','DRx0014098','TOPCILLIN','Kapl','Kalbe Farma',NULL,NULL,'0.00'),(13741,NULL,'drug','DRx0014099','TOPGESIC','Kaps Salut Selaput','Kimia Farma',NULL,NULL,'0.00'),(13742,NULL,'drug','DRx0014100','TOPILAR-FAPG','Krim','Darya-Varia/Syntex',NULL,NULL,'0.00'),(13743,NULL,'drug','DRx0014101','TOPILAR-N','Krim','Darya-Varia/Syntex',NULL,NULL,'0.00'),(13744,NULL,'drug','DRx0014102','TORADOL','Tab','Roche',NULL,NULL,'0.00'),(13745,NULL,'drug','DRx0014103','TORAMINE','Amp','Otto',NULL,NULL,'0.00'),(13746,NULL,'drug','DRx0014104','TORAMINE','Amp','Otto',NULL,NULL,'0.00'),(13747,NULL,'drug','DRx0014105','TORASIC','Amp','Kalbe Farma',NULL,NULL,'0.00'),(13748,NULL,'drug','DRx0014106','TORASIC','Amp','Kalbe Farma',NULL,NULL,'0.00'),(13749,NULL,'drug','DRx0014107','TORASIC','Tab Salut Selaput','Kalbe Farma',NULL,NULL,'0.00'),(13750,NULL,'drug','DRx0014108','TORPAIN','Amp','Ikapharmindo',NULL,NULL,'0.00'),(13751,NULL,'drug','DRx0014109','TOTILAC','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13752,NULL,'drug','DRx0014110','TRACETIN','Salep','Otto',NULL,NULL,'0.00'),(13753,NULL,'drug','DRx0014111','TRACNE','Krim','Interbat',NULL,NULL,'0.00'),(13754,NULL,'drug','DRx0014112','TRACNE','Krim','Interbat',NULL,NULL,'0.00'),(13755,NULL,'drug','DRx0014113','TRAGESIK','Amp','Kalbe Farma',NULL,NULL,'0.00'),(13756,NULL,'drug','DRx0014114','TRAGESIK','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(13757,NULL,'drug','DRx0014115','TRAMADOL HEXPHARM','Kaps','Hexpharm',NULL,NULL,'0.00'),(13758,NULL,'drug','DRx0014116','TRAMAL','Amp','Pharos/Grunenthal',NULL,NULL,'0.00'),(13759,NULL,'drug','DRx0014117','TRAMAL','Kaps','Pharos/Grunenthal',NULL,NULL,'0.00'),(13760,NULL,'drug','DRx0014118','TRAMUS','Amp','Dexa Medica',NULL,NULL,'0.00'),(13761,NULL,'drug','DRx0014119','TRANEXID','Amp','Dexa Medica',NULL,NULL,'0.00'),(13762,NULL,'drug','DRx0014120','TRANEXID','Amp','Dexa Medica',NULL,NULL,'0.00'),(13763,NULL,'drug','DRx0014121','TRANEXID','Kaps','Dexa Medica',NULL,NULL,'0.00'),(13764,NULL,'drug','DRx0014122','TRANEXID','Tab Salut Selaput','Dexa Medica',NULL,NULL,'0.00'),(13765,NULL,'drug','DRx0014123','TRANSAMIN','Tab Salut Selaput','Otto/Daiichi',NULL,NULL,'0.00'),(13766,NULL,'drug','DRx0014124','TRANSMUCO','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13767,NULL,'drug','DRx0014125','TRANXA','Amp','Bernoparm',NULL,NULL,'0.00'),(13768,NULL,'drug','DRx0014126','TRASIK','Amp','Fahrenheit',NULL,NULL,'0.00'),(13769,NULL,'drug','DRx0014127','TRASIK','Kaps','Fahrenheit',NULL,NULL,'0.00'),(13770,NULL,'drug','DRx0014128','TRAVATAN','Tetes','Alcon',NULL,NULL,'0.00'),(13771,NULL,'drug','DRx0014129','TRAZEP','Tube Rectal','Fahrenheit',NULL,NULL,'0.00'),(13772,NULL,'drug','DRx0014130','TRENAT','Amp','Interbat',NULL,NULL,'0.00'),(13773,NULL,'drug','DRx0014131','TRENFYL','Tab','Pharos',NULL,NULL,'0.00'),(13774,NULL,'drug','DRx0014132','TRENTAL','Amp','Sanofi Aventis',NULL,NULL,'0.00'),(13775,NULL,'drug','DRx0014133','TRENTIN','Krim','Ikapharmindo',NULL,NULL,'0.00'),(13776,NULL,'drug','DRx0014134','TRENTIN','Krim','Ikapharmindo',NULL,NULL,'0.00'),(13777,NULL,'drug','DRx0014135','TRENTOX','Kapl Salut Gula','Ferron',NULL,NULL,'0.00'),(13778,NULL,'drug','DRx0014136','TRENXY','Vial','Danpac Pharma',NULL,NULL,'0.00'),(13779,NULL,'drug','DRx0014137','TRIAMCORT','Krim','Interbat',NULL,NULL,'0.00'),(13780,NULL,'drug','DRx0014138','TRIAMINIC BATUK','Sir','Novartis Indonesia',NULL,NULL,'0.00'),(13781,NULL,'drug','DRx0014139','TRIAMINIC EXPECTORANT','Sir','Novartis Indonesia',NULL,NULL,'0.00'),(13782,NULL,'drug','DRx0014140','TRIAMINIC PILEK','Sir','Novartis Indonesia',NULL,NULL,'0.00'),(13783,NULL,'drug','DRx0014141','TRIBESTAN','Tab','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(13784,NULL,'drug','DRx0014142','TRIBOST','Sir','Ethica',NULL,NULL,'0.00'),(13785,NULL,'drug','DRx0014143','TRIBOST','Tab','Ethica',NULL,NULL,'0.00'),(13786,NULL,'drug','DRx0014144','TRICHOL','Kaps','Galenium Pharmasia Lab',NULL,NULL,'0.00'),(13787,NULL,'drug','DRx0014145','TRICHOSTATIC','Tab Vag','Pharos',NULL,NULL,'0.00'),(13788,NULL,'drug','DRx0014146','TRICKER','Amp','Meprofarm',NULL,NULL,'0.00'),(13789,NULL,'drug','DRx0014147','TRICKER','Tab Salut Selaput','Meprofarm',NULL,NULL,'0.00'),(13790,NULL,'drug','DRx0014148','TRICLOFEM','Vial','Tunggal Idaman Abadi ',NULL,NULL,'0.00'),(13791,NULL,'drug','DRx0014149','TRIDEX 100','Lar Infus','Sanbe',NULL,NULL,'0.00'),(13792,NULL,'drug','DRx0014150','TRIDEX 27A','Lar Infus','Sanbe',NULL,NULL,'0.00'),(13793,NULL,'drug','DRx0014151','TRIDEZ','Salep','Sandoz',NULL,NULL,'0.00'),(13794,NULL,'drug','DRx0014152','TRIFEDRIN','Sir','Otto',NULL,NULL,'0.00'),(13795,NULL,'drug','DRx0014153','TRIFEDRIN','Tab','Otto',NULL,NULL,'0.00'),(13796,NULL,'drug','DRx0014154','TRIFLEXOR','Tab','Combiphar',NULL,NULL,'0.00'),(13797,NULL,'drug','DRx0014155','TRIFLUID','Lar Infus','Otsuka',NULL,NULL,'0.00'),(13798,NULL,'drug','DRx0014156','TRILAC','Vial','Novell Pharma',NULL,NULL,'0.00'),(13799,NULL,'drug','DRx0014157','TRIMINIC PILEK','Sir','Novartis Indonesia',NULL,NULL,'0.00'),(13800,NULL,'drug','DRx0014158','TRIMOVAX MERIEUX','Vial','Sanofi Pasteur',NULL,NULL,'0.00'),(13801,NULL,'drug','DRx0014159','TRINOLDIOL-28','Tab KB','Sunthi Sepuri/Wyeth-Ayerst',NULL,NULL,'0.00'),(13802,NULL,'drug','DRx0014160','TRINOLON','Tab','Kimia Farma',NULL,NULL,'0.00'),(13803,NULL,'drug','DRx0014161','TRIOFUSIN 1000','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13804,NULL,'drug','DRx0014162','TRIOFUSIN 1000','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13805,NULL,'drug','DRx0014163','TRIOFUSIN 1600','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13806,NULL,'drug','DRx0014164','TRIOFUSIN 500','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13807,NULL,'drug','DRx0014165','TRIOFUSIN E 1000','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13808,NULL,'drug','DRx0014166','TRIOSTEE','Kapl','Tropica Mas Pharma',NULL,NULL,'0.00'),(13809,NULL,'drug','DRx0014167','TRIPACEL','Vial','Sanofi Pasteur',NULL,NULL,'0.00'),(13810,NULL,'drug','DRx0014168','TRIPENEM','Vial','Dexa Medica',NULL,NULL,'0.00'),(13811,NULL,'drug','DRx0014169','TRIPENEM','Vial','Dexa Medica',NULL,NULL,'0.00'),(13812,NULL,'drug','DRx0014170','TRIPID','Kaps','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(13813,NULL,'drug','DRx0014171','TRIQUILAR ED','Tab','Bayer Schering Pharma',NULL,NULL,'0.00'),(13814,NULL,'drug','DRx0014172','TRISULFA BERLICO','Kapl','Berlico Mulia Farma',NULL,NULL,'0.00'),(13815,NULL,'drug','DRx0014173','TRISULFA BERLICO','Kapl','Berlico Mulia Farma',NULL,NULL,'0.00'),(13816,NULL,'drug','DRx0014174','TRIZEDON MR','Tab Salut Selaput','Servier',NULL,NULL,'0.00'),(13817,NULL,'drug','DRx0014175','TRIZOLE','Susp','Medifarma/Pediatrica',NULL,NULL,'0.00'),(13818,NULL,'drug','DRx0014176','TRODEB','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13819,NULL,'drug','DRx0014177','TRODEX','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13820,NULL,'drug','DRx0014178','TROLAC','Amp','Bernoparm',NULL,NULL,'0.00'),(13821,NULL,'drug','DRx0014179','TROLIP','Kaps','Dexa Medica',NULL,NULL,'0.00'),(13822,NULL,'drug','DRx0014180','TROLIP','Kaps','Dexa Medica',NULL,NULL,'0.00'),(13823,NULL,'drug','DRx0014181','TROPIDINE','Kaps','Tropica Mas Pharma',NULL,NULL,'0.00'),(13824,NULL,'drug','DRx0014182','TROPIDROL','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13825,NULL,'drug','DRx0014183','TROPIDROL','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13826,NULL,'drug','DRx0014184','TROPIDROL','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13827,NULL,'drug','DRx0014185','TROSYD','Bubuk','Pfizer',NULL,NULL,'0.00'),(13828,NULL,'drug','DRx0014186','TRUNAL DX','Amp','Ferron/Heumann',NULL,NULL,'0.00'),(13829,NULL,'drug','DRx0014187','TRUNAL DX','Amp','Ferron/Heumann',NULL,NULL,'0.00'),(13830,NULL,'drug','DRx0014188','TRUNAL DX','Kaps','Ferron/Heumann',NULL,NULL,'0.00'),(13831,NULL,'drug','DRx0014189','TRUNAL DX','Supp','Ferron/Heumann',NULL,NULL,'0.00'),(13832,NULL,'drug','DRx0014190','TRUNAL-DX RETARD','Tab Lepas Lambat','Ferron/Heumann',NULL,NULL,'0.00'),(13833,NULL,'drug','DRx0014191','TRUVIT','Sir','Solas',NULL,NULL,'0.00'),(13834,NULL,'drug','DRx0014192','TURPAN','Tab','Corsa',NULL,NULL,'0.00'),(13835,NULL,'drug','DRx0014193','TUSERAN FORTE','Kaps Forte','Medifarma',NULL,NULL,'0.00'),(13836,NULL,'drug','DRx0014194','TUSERAN PEDIA DMP','Sir','Medifarma/UAP',NULL,NULL,'0.00'),(13837,NULL,'drug','DRx0014195','TUSSIGON','Sir','Novell Pharma',NULL,NULL,'0.00'),(13838,NULL,'drug','DRx0014196','TUSSIGON','Sir','Novell Pharma',NULL,NULL,'0.00'),(13839,NULL,'drug','DRx0014197','TUTOFUSIN LC','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13840,NULL,'drug','DRx0014198','TUTOFUSIN LC','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13841,NULL,'drug','DRx0014199','TUTOFUSIN OPS','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(13842,NULL,'drug','DRx0014200','VAKSIN TWINRIX','Pre-filled','GlaxoSmithKline',NULL,NULL,'0.00'),(13843,NULL,'drug','DRx0014201','TYASON','Vial','Landson',NULL,NULL,'0.00'),(13844,NULL,'drug','DRx0014202','TYGACIL','Vial','Wyeth',NULL,NULL,'0.00'),(13845,NULL,'drug','DRx0014203','TYPHERIX','Pre-filled','GlaxoSmithKline',NULL,NULL,'0.00'),(13846,NULL,'drug','DRx0014204','VAKSIN TYPHIM VI','Inj','Sanofi Pasteur',NULL,NULL,'0.00'),(13847,NULL,'drug','DRx0014205','VAKSINT YPHIM VI','Vial','Sanofi Pasteur',NULL,NULL,'0.00'),(13848,NULL,'drug','DRx0014206','ULCEDINE','Kaps','United American',NULL,NULL,'0.00'),(13849,NULL,'drug','DRx0014207','ULCERAN','Kaps','Sandoz',NULL,NULL,'0.00'),(13850,NULL,'drug','DRx0014208','ULFAPRIM','Susp','Hexpharm',NULL,NULL,'0.00'),(13851,NULL,'drug','DRx0014209','ULFAPRIM','Tab','Hexpharm',NULL,NULL,'0.00'),(13852,NULL,'drug','DRx0014210','ULSAFATE','Susp','Combiphar',NULL,NULL,'0.00'),(13853,NULL,'drug','DRx0014211','ULSANIC','Tab','Darya - Varia/Chugai',NULL,NULL,'0.00'),(13854,NULL,'drug','DRx0014212','ULSANIC','Tab','Darya - Varia/Chugai',NULL,NULL,'0.00'),(13855,NULL,'drug','DRx0014213','ULSICRAL','Susp','Ikapharmindo',NULL,NULL,'0.00'),(13856,NULL,'drug','DRx0014214','ULSICRAL','Susp','Ikapharmindo',NULL,NULL,'0.00'),(13857,NULL,'drug','DRx0014215','ULTRAPROCT N','Krim','Bayer Schering Pharma',NULL,NULL,'0.00'),(13858,NULL,'drug','DRx0014216','ULTRAPROCT N','Supp','Bayer Schering Pharma',NULL,NULL,'0.00'),(13859,NULL,'drug','DRx0014217','ULZOL','Kaps','Ethica',NULL,NULL,'0.00'),(13860,NULL,'drug','DRx0014218','UNIVASC','Tab','Pharos',NULL,NULL,'0.00'),(13861,NULL,'drug','DRx0014219','UNIVASC','Tab','Pharos ',NULL,NULL,'0.00'),(13862,NULL,'drug','DRx0014220','UNIVOXY','kapl','Tropica Mas Pharma',NULL,NULL,'0.00'),(13863,NULL,'drug','DRx0014221','URDAHEX','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(13864,NULL,'drug','DRx0014222','UREDERM','Krim','Roi Surya Prima',NULL,NULL,'0.00'),(13865,NULL,'drug','DRx0014223','URFAMYCIN','Kaps','Zambon',NULL,NULL,'0.00'),(13866,NULL,'drug','DRx0014224','URFAMYCIN','Kaps','Zambon',NULL,NULL,'0.00'),(13867,NULL,'drug','DRx0014225','URFAMYCIN','Sir Kering','Zambon',NULL,NULL,'0.00'),(13868,NULL,'drug','DRx0014226','URICNOL','Tab','Kimia Farma',NULL,NULL,'0.00'),(13869,NULL,'drug','DRx0014227','URIXIN','Tab','Abbott',NULL,NULL,'0.00'),(13870,NULL,'drug','DRx0014228','UROKINASE-GCC','Vial','Sanbe/GCC Korea',NULL,NULL,'0.00'),(13871,NULL,'drug','DRx0014229','UROXAL','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(13872,NULL,'drug','DRx0014230','URSOCHOL','Tab','Zambon',NULL,NULL,'0.00'),(13873,NULL,'drug','DRx0014231','UTREX','Kaps','Sandoz',NULL,NULL,'0.00'),(13874,NULL,'drug','DRx0014232','VAGIZOL','Tab','Kimia Farma',NULL,NULL,'0.00'),(13875,NULL,'drug','DRx0014235','VAGIZOL','Tab Vag','Kimia Farma',NULL,NULL,'0.00'),(13876,NULL,'drug','DRx0014236','VALCYTE','Tab','Roche',NULL,NULL,'0.00'),(13877,NULL,'drug','DRx0014237','VALDA','Sir','Sterling',NULL,NULL,'0.00'),(13878,NULL,'drug','DRx0014238','VALDIMEX','Amp','Mersifarma TM',NULL,NULL,'0.00'),(13879,NULL,'drug','DRx0014239','VALDIMEX','Tab','Mersifarma TM',NULL,NULL,'0.00'),(13880,NULL,'drug','DRx0014240','VALERON','Krim','Konimex',NULL,NULL,'0.00'),(13881,NULL,'drug','DRx0014241','VALSARTAN-NI','Tab Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(13882,NULL,'drug','DRx0014242','VALTREX','Tab Salut Selaput','GlaxoSmithKline',NULL,NULL,'0.00'),(13883,NULL,'drug','DRx0014243','VALVED','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13884,NULL,'drug','DRx0014244','VALVED','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13885,NULL,'drug','DRx0014245','VALVED DM','Sir','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13886,NULL,'drug','DRx0014246','VALVIR','Kapl Salut Selaput','Soho',NULL,NULL,'0.00'),(13887,NULL,'drug','DRx0014247','VAMIN GLUCOSE','Lar','Fresenius',NULL,NULL,'0.00'),(13888,NULL,'drug','DRx0014248','VAMIN GLUCOSE','Lar','Fresenius',NULL,NULL,'0.00'),(13889,NULL,'drug','DRx0014249','VAMIN GLUCOSE','Lar','Fresenius',NULL,NULL,'0.00'),(13890,NULL,'drug','DRx0014250','VANCEP','Vial','Fahrenheit',NULL,NULL,'0.00'),(13891,NULL,'drug','DRx0014251','VANCOMYCIN ABBOTT','Vial','Abbott',NULL,NULL,'0.00'),(13892,NULL,'drug','DRx0014252','VARICELLA VACCINE','Vial','Green Cross/Berna Biotech',NULL,NULL,'0.00'),(13893,NULL,'drug','DRx0014253','VASCON','Amp','Fahrenheit',NULL,NULL,'0.00'),(13894,NULL,'drug','DRx0014254','VASDALAT/VASDALAT RETARD','Tab Lepas Lambat','Kalbe Farma',NULL,NULL,'0.00'),(13895,NULL,'drug','DRx0014255','VASTIGO','Tab','Dexa Medica',NULL,NULL,'0.00'),(13896,NULL,'drug','DRx0014256','VAXIGRIP','Inj','Sanofi Pasteur',NULL,NULL,'0.00'),(13897,NULL,'drug','DRx0014257','VAXIGRIP','Inj','Sanofi Pasteur',NULL,NULL,'0.00'),(13898,NULL,'drug','DRx0014258','V-BLOC','Tab','Kalbe Farma',NULL,NULL,'0.00'),(13899,NULL,'drug','DRx0014259','VEDIUM','Kapl Salut Selaput','Medikon',NULL,NULL,'0.00'),(13900,NULL,'drug','DRx0014260','VEGETA','Bubuk','Sari Enesis Indah',NULL,NULL,'0.00'),(13901,NULL,'drug','DRx0014261','VELCADE','Vial','Schering-Plough',NULL,NULL,'0.00'),(13902,NULL,'drug','DRx0014262','VELCOX','Tab','Novell Pharma',NULL,NULL,'0.00'),(13903,NULL,'drug','DRx0014263','VELCOX','Tab','Novell Pharma',NULL,NULL,'0.00'),(13904,NULL,'drug','DRx0014264','VELOSTIN','Gel','Solas',NULL,NULL,'0.00'),(13905,NULL,'drug','DRx0014265','VENARON','Kaps','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(13906,NULL,'drug','DRx0014266','VENARON','Kaps','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(13907,NULL,'drug','DRx0014267','VENASMA','Tab','Hexpharm',NULL,NULL,'0.00'),(13908,NULL,'drug','DRx0014268','VENASMA','Tab','Hexpharm',NULL,NULL,'0.00'),(13909,NULL,'drug','DRx0014269','VENOFER','Amp','Combiphar/Vifor',NULL,NULL,'0.00'),(13910,NULL,'drug','DRx0014270','VENOS','Kaps','Soho',NULL,NULL,'0.00'),(13911,NULL,'drug','DRx0014271','VENOS','Kaps','Soho',NULL,NULL,'0.00'),(13912,NULL,'drug','DRx0014272','VENOSMIL','Gel','Kalbe Farma',NULL,NULL,'0.00'),(13913,NULL,'drug','DRx0014273','VENOSMIL','Gel','Kalbe Farma',NULL,NULL,'0.00'),(13914,NULL,'drug','DRx0014274','VENOSMIL','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(13915,NULL,'drug','DRx0014275','VENOSMIL','Kaps','Kalbe Farma',NULL,NULL,'0.00'),(13916,NULL,'drug','DRx0014276','VENTATIS','Inhaler','Bayer Schering Pharma',NULL,NULL,'0.00'),(13917,NULL,'drug','DRx0014277','VENTOLIN','Inhaler','GlaxoSmithKline',NULL,NULL,'0.00'),(13918,NULL,'drug','DRx0014278','VENTOLIN','Rotacap','GlaxoSmithKline',NULL,NULL,'0.00'),(13919,NULL,'drug','DRx0014279','VENTOLIN','Rotahaler','GlaxoSmithKline',NULL,NULL,'0.00'),(13920,NULL,'drug','DRx0014280','VENTOLIN','Sir','GlaxoSmithKline',NULL,NULL,'0.00'),(13921,NULL,'drug','DRx0014281','VENTOLIN EXPECTORANT','Sir','GlaxoSmithKline',NULL,NULL,'0.00'),(13922,NULL,'drug','DRx0014282','VERALEX','Tab','Pharmachemie',NULL,NULL,'0.00'),(13923,NULL,'drug','DRx0014283','VERAPLEX','Tab','Combiphar',NULL,NULL,'0.00'),(13924,NULL,'drug','DRx0014284','VERCURE','Tab','Tempo Scan Pacific',NULL,NULL,'0.00'),(13925,NULL,'drug','DRx0014285','VERMOX','Sir','Janssen-Cilag',NULL,NULL,'0.00'),(13926,NULL,'drug','DRx0014286','VERMOX 500','Sir','Janssen-Cilag',NULL,NULL,'0.00'),(13927,NULL,'drug','DRx0014287','VERMOX 500','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13928,NULL,'drug','DRx0014288','VERMOX 500','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(13929,NULL,'drug','DRx0014289','VERON','Gel','Medikon',NULL,NULL,'0.00'),(13930,NULL,'drug','DRx0014290','VERONA','Kaps','Solas',NULL,NULL,'0.00'),(13931,NULL,'drug','DRx0014291','VERORAB (MOVAX RABIES VERO)','Inj','Sanofi Pasteur',NULL,NULL,'0.00'),(13932,NULL,'drug','DRx0014292','VERORAB (MOVAX RABIES VERO)','Inj','Sanofi Pasteur',NULL,NULL,'0.00'),(13933,NULL,'drug','DRx0014293','VERSILON 6','Tab Salut Selaput','Mersifarma TM',NULL,NULL,'0.00'),(13934,NULL,'drug','DRx0014294','VERTEX','Tab','Meprofarm',NULL,NULL,'0.00'),(13935,NULL,'drug','DRx0014295','VERTIVOM','Amp','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13936,NULL,'drug','DRx0014296','VERTIVOM','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13937,NULL,'drug','DRx0014297','VERTIVOM','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13938,NULL,'drug','DRx0014298','VERU-MERZ','Gel','Combiphar/Merz',NULL,NULL,'0.00'),(13939,NULL,'drug','DRx0014299','VERU-MERZ','Gel','Combiphar/Merz',NULL,NULL,'0.00'),(13940,NULL,'drug','DRx0014300','VESICARE','Tab Salut Selaput','Astellas',NULL,NULL,'0.00'),(13941,NULL,'drug','DRx0014301','VESICARE','Tab Salut Selaput','Astellas',NULL,NULL,'0.00'),(13942,NULL,'drug','DRx0014302','VESPERUM','Susp','Ifars',NULL,NULL,'0.00'),(13943,NULL,'drug','DRx0014303','VFEND','Tab Salut Selaput','Pfizer',NULL,NULL,'0.00'),(13944,NULL,'drug','DRx0014304','VFEND','Tab Salut Selaput','Pfizer',NULL,NULL,'0.00'),(13945,NULL,'drug','DRx0014305','VFEND','Vial','Pfizer',NULL,NULL,'0.00'),(13946,NULL,'drug','DRx0014306','VIACLAV','Kapl Salut Selaput','Kalbe Farma',NULL,NULL,'0.00'),(13947,NULL,'drug','DRx0014308','VICCILLIN-SX','Vial','Meiji',NULL,NULL,'0.00'),(13948,NULL,'drug','DRx0014309','VICCILLIN-SX','Vial','Meiji',NULL,NULL,'0.00'),(13949,NULL,'drug','DRx0014310','VIDINTAL','Tab Salut Selaput','Tunggal Idaman Abadi ',NULL,NULL,'0.00'),(13950,NULL,'drug','DRx0014311','VIDISEP','Lar','Kimia Farma',NULL,NULL,'0.00'),(13951,NULL,'drug','DRx0014312','VIDISEP','Lar','Kimia Farma',NULL,NULL,'0.00'),(13952,NULL,'drug','DRx0014313','VIDISEP','Lar','Kimia Farma',NULL,NULL,'0.00'),(13953,NULL,'drug','DRx0014314','VIDISEP','Lar','Kimia Farma',NULL,NULL,'0.00'),(13954,NULL,'drug','DRx0014315','VIDORAN SMART','Tab Kunyah','Tempo Scan Pacific',NULL,NULL,'0.00'),(13955,NULL,'drug','DRx0014316','VIFLOX','Tab','Tropica Mas Pharma',NULL,NULL,'0.00'),(13956,NULL,'drug','DRx0014317','VIGORAL','Kaps','Westmont',NULL,NULL,'0.00'),(13957,NULL,'drug','DRx0014318','VINAFLUOR','Tab','Nicholas',NULL,NULL,'0.00'),(13958,NULL,'drug','DRx0014319','VINBLASTINE PCH','Vial','Pharmachemie',NULL,NULL,'0.00'),(13959,NULL,'drug','DRx0014320','VINBLASTINE SULPHATE DBL','Vial','Tempo Scan Pacific/DBL',NULL,NULL,'0.00'),(13960,NULL,'drug','DRx0014321','VINCRISTINE KALBE','Vial','Kalbe Farma',NULL,NULL,'0.00'),(13961,NULL,'drug','DRx0014322','VINCRISTINE KALBE','Vial','Kalbe Farma',NULL,NULL,'0.00'),(13962,NULL,'drug','DRx0014323','VINCRISTINE PCH','Vial','Pharmachemie',NULL,NULL,'0.00'),(13963,NULL,'drug','DRx0014324','VINCRISTINE PCH','Vial','Pharmachemie',NULL,NULL,'0.00'),(13964,NULL,'drug','DRx0014325','VINCRISTINE SULPHATE DBL','Vial','Tempo Scan Pacific/DBL',NULL,NULL,'0.00'),(13965,NULL,'drug','DRx0014326','VINCRISTINE SULPHATE DBL','Vial','Tempo Scan Pacific/DBL',NULL,NULL,'0.00'),(13966,NULL,'drug','DRx0014327','VINCRISTINE SULPHATE DBL','Vial','Tempo Scan Pacific/DBL',NULL,NULL,'0.00'),(13967,NULL,'drug','DRx0014328','VINPO-E','Kaps Lunak','Hexpharm',NULL,NULL,'0.00'),(13968,NULL,'drug','DRx0014329','VIONIN NF','Kapl Salut Selaput','Tempo Scan Pacific',NULL,NULL,'0.00'),(13969,NULL,'drug','DRx0014330','VIOPOR','Kapl Salut Selaput','Otto',NULL,NULL,'0.00'),(13970,NULL,'drug','DRx0014331','VIOQUIN','Kapl Salut Selaput','Gracia Pharmindo',NULL,NULL,'0.00'),(13971,NULL,'drug','DRx0014332','VIOSTIN S 400','Kaps','Pharos',NULL,NULL,'0.00'),(13972,NULL,'drug','DRx0014333','VIOSTIN S 400','Kaps','Pharos',NULL,NULL,'0.00'),(13973,NULL,'drug','DRx0014334','VIPRAM','Kapl Salut Selaput','Novell Pharma',NULL,NULL,'0.00'),(13974,NULL,'drug','DRx0014335','VIPRAM','Sir','Novell Pharma',NULL,NULL,'0.00'),(13975,NULL,'drug','DRx0014336','VIPRES','Kaptab','Bernofarm',NULL,NULL,'0.00'),(13976,NULL,'drug','DRx0014337','VIPRES','Kaptab','Bernofarm',NULL,NULL,'0.00'),(13977,NULL,'drug','DRx0014338','VIPRO-G','Tab Eff','Simex',NULL,NULL,'0.00'),(13978,NULL,'drug','DRx0014339','VIRALIS 200','Kapl','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13979,NULL,'drug','DRx0014340','VIRALIS 400','Kapl','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13980,NULL,'drug','DRx0014341','VIRAMUNE','Tab','Boehringer Ingelheim',NULL,NULL,'0.00'),(13981,NULL,'drug','DRx0014342','VIRAZIDE','Kaps','Armoxindo Farma',NULL,NULL,'0.00'),(13982,NULL,'drug','DRx0014343','VIRCOVIR','Krim','Corsa',NULL,NULL,'0.00'),(13983,NULL,'drug','DRx0014344','VIRULES','Krim','Kimia Farma',NULL,NULL,'0.00'),(13984,NULL,'drug','DRx0014345','VIRULES','Tab','Kimia Farma',NULL,NULL,'0.00'),(13985,NULL,'drug','DRx0014346','VIRULES','Tab','Kimia Farma',NULL,NULL,'0.00'),(13986,NULL,'drug','DRx0014347','VISINE EXTRA','Tetes','Pfizer',NULL,NULL,'0.00'),(13987,NULL,'drug','DRx0014348','VISINE LR','Tetes','Pfizer',NULL,NULL,'0.00'),(13988,NULL,'drug','DRx0014349','VISINE LR','Tetes','Pfizer',NULL,NULL,'0.00'),(13989,NULL,'drug','DRx0014350','VISIVIT','Kapl Salut Selaput','Soho',NULL,NULL,'0.00'),(13990,NULL,'drug','DRx0014351','VISIVIT','Sir','Pharos',NULL,NULL,'0.00'),(13991,NULL,'drug','DRx0014352','VISOLIN','Tetes','Darya-Varia',NULL,NULL,'0.00'),(13992,NULL,'drug','DRx0014353','VISTO','Tetes','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13993,NULL,'drug','DRx0014354','VISUDYNE','Vial','Novartis Indonesia',NULL,NULL,'0.00'),(13994,NULL,'drug','DRx0014355','VITA - VISION','Kaps','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(13995,NULL,'drug','DRx0014356','VITABION','Kaps','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(13996,NULL,'drug','DRx0014357','VITACAL-D','Tab Kunyah','Otto',NULL,NULL,'0.00'),(13997,NULL,'drug','DRx0014358','VITACORE FORTE','Kapl Salut Selaput','Coronet',NULL,NULL,'0.00'),(13998,NULL,'drug','DRx0014359','VITACUR','Sir','Lapi',NULL,NULL,'0.00'),(13999,NULL,'drug','DRx0014360','VITAFEROL','Tab Kunyah','Otto',NULL,NULL,'0.00'),(14000,NULL,'drug','DRx0014361','VITAL EAR OIL','Tetes','Medikon',NULL,NULL,'0.00'),(14001,NULL,'drug','DRx0014362','VITALAC -1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14002,NULL,'drug','DRx0014363','VITALAC -1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14003,NULL,'drug','DRx0014364','VITALAC -1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14004,NULL,'drug','DRx0014365','VITALAC -1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14005,NULL,'drug','DRx0014366','VITALAC -1','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14006,NULL,'drug','DRx0014367','VITALAC -2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14007,NULL,'drug','DRx0014368','VITALAC -2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14008,NULL,'drug','DRx0014369','VITALAC -2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14009,NULL,'drug','DRx0014370','VITALAC -2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14010,NULL,'drug','DRx0014371','VITALAC -2','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14011,NULL,'drug','DRx0014372','VITALAC BL','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14012,NULL,'drug','DRx0014373','VITALONG C TRC','Kaps','Bernofarm',NULL,NULL,'0.00'),(14013,NULL,'drug','DRx0014374','VITALUX','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(14014,NULL,'drug','DRx0014375','VITALUX PLUS','Tab','Novartis Indonesia',NULL,NULL,'0.00'),(14015,NULL,'drug','DRx0014376','VITAMAM 1','Kaps','Novell Pharma',NULL,NULL,'0.00'),(14016,NULL,'drug','DRx0014377','VITAMAM 2','Kaps','Novell Pharma',NULL,NULL,'0.00'),(14017,NULL,'drug','DRx0014378','VITAMEX C','Tab Hisap','Konimex',NULL,NULL,'0.00'),(14018,NULL,'drug','DRx0014379','VITAMIN  B COMPLEX GMP','Vial','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14019,NULL,'drug','DRx0014380','VITAMIN  B COMPLEX GMP','Vial','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14020,NULL,'drug','DRx0014381','VITAMIN A KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14021,NULL,'drug','DRx0014382','VITAMIN A KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14022,NULL,'drug','DRx0014383','VITAMIN A KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14023,NULL,'drug','DRx0014384','VITAMIN B COMPLEX KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14024,NULL,'drug','DRx0014385','VITAMIN B COMPLEX SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14025,NULL,'drug','DRx0014386','VITAMIN B COMPLEX SOHO/ETHICA','Vial','Soho/Ethica',NULL,NULL,'0.00'),(14026,NULL,'drug','DRx0014387','VITAMIN B1 SOHO/ETHICA','Amp','Soho/Ethica',NULL,NULL,'0.00'),(14027,NULL,'drug','DRx0014388','VITAMIN B1 SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14028,NULL,'drug','DRx0014389','VITAMIN B1 SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14029,NULL,'drug','DRx0014390','VITAMIN B1 SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14030,NULL,'drug','DRx0014391','VITAMIN B12 KIMIA FARMA','Amp','Kimia Farma',NULL,NULL,'0.00'),(14031,NULL,'drug','DRx0014392','VITAMIN B12 KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14032,NULL,'drug','DRx0014393','VITAMIN B12 SOHO/ETHICA','Amp','Soho/Ethica',NULL,NULL,'0.00'),(14033,NULL,'drug','DRx0014394','VITAMIN B12 SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14034,NULL,'drug','DRx0014395','VITAMIN B12 SOHO/ETHICA','Vial','Soho/Ethica',NULL,NULL,'0.00'),(14035,NULL,'drug','DRx0014396','VITAMIN B6 KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14036,NULL,'drug','DRx0014397','VITAMIN C KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14037,NULL,'drug','DRx0014398','VITAMIN C SOHO/ETHICA','Amp','Soho/Ethica',NULL,NULL,'0.00'),(14038,NULL,'drug','DRx0014399','VITAMIN C SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14039,NULL,'drug','DRx0014400','VITAMIN C SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14040,NULL,'drug','DRx0014401','VITAMIN C SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14041,NULL,'drug','DRx0014402','VITAMIN K KF','Amp','Kimia Farma',NULL,NULL,'0.00'),(14042,NULL,'drug','DRx0014403','VITAMIN K KF','Drag','Kimia Farma',NULL,NULL,'0.00'),(14043,NULL,'drug','DRx0014404','VITAMULTI','Kapl','Otto',NULL,NULL,'0.00'),(14044,NULL,'drug','DRx0014405','VITANOX','Kapl Salut Selaput','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14045,NULL,'drug','DRx0014406','VITAP','Kapl Salut Selaput','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14046,NULL,'drug','DRx0014407','VITAPLUS','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14047,NULL,'drug','DRx0014408','VITAPLUS','Bubuk','Sari Husada',NULL,NULL,'0.00'),(14048,NULL,'drug','DRx0014409','VITASLIM','Kapl Salut Selaput','Soho',NULL,NULL,'0.00'),(14049,NULL,'drug','DRx0014410','VIT-EVER','Kapl Salut Selaput','Ifars',NULL,NULL,'0.00'),(14050,NULL,'drug','DRx0014411','VITMAM 3','Kaps','Novell Pharma',NULL,NULL,'0.00'),(14051,NULL,'drug','DRx0014412','VITRIMIX','Lar','Fresenius',NULL,NULL,'0.00'),(14052,NULL,'drug','DRx0014413','VITRIMIX','Lar','Fresenius',NULL,NULL,'0.00'),(14053,NULL,'drug','DRx0014414','VITRO-MEGA','Kaps','Solas',NULL,NULL,'0.00'),(14054,NULL,'drug','DRx0014415','VIUSID','Bubuk','Interbat',NULL,NULL,'0.00'),(14055,NULL,'drug','DRx0014416','VIVOTIF','Kaps Salut Enterik','Berna Biotech',NULL,NULL,'0.00'),(14056,NULL,'drug','DRx0014417','VIZIBEX','Tab Salut Selaput','Mugi Labs',NULL,NULL,'0.00'),(14057,NULL,'drug','DRx0014418','VOLDILEX','Kaps','Solas',NULL,NULL,'0.00'),(14058,NULL,'drug','DRx0014419','VOLEQUIN','Vial','Dexa Medica',NULL,NULL,'0.00'),(14059,NULL,'drug','DRx0014420','VOLMATIK','Tab Salut Enterik','Mugi Labs',NULL,NULL,'0.00'),(14060,NULL,'drug','DRx0014421','VOLMATIK','Tab Salut Enterik','Mugi Labs',NULL,NULL,'0.00'),(14061,NULL,'drug','DRx0014422','VOLTADEX RETARD','Tab Lepas Lambat','Dexa Medica',NULL,NULL,'0.00'),(14062,NULL,'drug','DRx0014423','VOLTAREN','Tab Salut Selaput Le','Novartis Indonesia',NULL,NULL,'0.00'),(14063,NULL,'drug','DRx0014424','VOLTAREN OPHTHA','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(14064,NULL,'drug','DRx0014425','VOLTAREN OPHTHA','Tetes','Novartis Indonesia',NULL,NULL,'0.00'),(14065,NULL,'drug','DRx0014426','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14066,NULL,'drug','DRx0014427','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14067,NULL,'drug','DRx0014428','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14068,NULL,'drug','DRx0014429','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14069,NULL,'drug','DRx0014430','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14070,NULL,'drug','DRx0014431','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14071,NULL,'drug','DRx0014432','VOLUVEN','Lar Infus','Fresenius',NULL,NULL,'0.00'),(14072,NULL,'drug','DRx0014433','VOMETA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14073,NULL,'drug','DRx0014434','VOMETA FT ','Tab Lepas Cepat','Dexa Medica',NULL,NULL,'0.00'),(14074,NULL,'drug','DRx0014435','VOMIDEX','Amp','Dexa Medica',NULL,NULL,'0.00'),(14075,NULL,'drug','DRx0014436','VOMIDONE','Susp','Pharos',NULL,NULL,'0.00'),(14076,NULL,'drug','DRx0014437','VOMIDONE','Tab Salut Selaput','Pharos',NULL,NULL,'0.00'),(14077,NULL,'drug','DRx0014438','VOMIDONE','Tetes','Pharos',NULL,NULL,'0.00'),(14078,NULL,'drug','DRx0014439','VOMILAT','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14079,NULL,'drug','DRx0014440','VOMILES','Tab','Hexpharm',NULL,NULL,'0.00'),(14080,NULL,'drug','DRx0014441','VOMISTOP','Tab Salut Selaput','Gracia Pharmindo',NULL,NULL,'0.00'),(14081,NULL,'drug','DRx0014442','VOMITAS','Sir','Kalbe Farma',NULL,NULL,'0.00'),(14082,NULL,'drug','DRx0014443','VOXIN','Kapl Salut Selaput','Gracia Pharmindo',NULL,NULL,'0.00'),(14083,NULL,'drug','DRx0014444','VTAMIN B12 SOHO/ETHICA','Tab','Soho/Ethica',NULL,NULL,'0.00'),(14084,NULL,'drug','DRx0014445','VYTORIN','Tab','Schering-Plough',NULL,NULL,'0.00'),(14085,NULL,'drug','DRx0014446','VYTORIN','Tab','Schering-Plough',NULL,NULL,'0.00'),(14086,NULL,'drug','DRx0014447','WARFARIN EISAI','Tab','Eisai',NULL,NULL,'0.00'),(14087,NULL,'drug','DRx0014448','WIAMOX','Kapl','Landson',NULL,NULL,'0.00'),(14088,NULL,'drug','DRx0014449','WIAMOX','Sir Kering','Landson',NULL,NULL,'0.00'),(14089,NULL,'drug','DRx0014450','WIDA 1/2 DAD','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14090,NULL,'drug','DRx0014451','WIDA 1/2 DAD','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14091,NULL,'drug','DRx0014452','WIDA D5','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14092,NULL,'drug','DRx0014453','WIDA D5','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14093,NULL,'drug','DRx0014454','WIDA D5 -NS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14094,NULL,'drug','DRx0014455','WIDA D5 -NS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14095,NULL,'drug','DRx0014456','WIDA D10','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14096,NULL,'drug','DRx0014457','WIDA D10','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14097,NULL,'drug','DRx0014458','WIDA D5-1/2 NS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14098,NULL,'drug','DRx0014459','WIDA D5-1/4 NS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14099,NULL,'drug','DRx0014460','WIDA NS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14100,NULL,'drug','DRx0014461','WIDA NS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14101,NULL,'drug','DRx0014462','WIDA NSI','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14102,NULL,'drug','DRx0014463','WIDA RD','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14103,NULL,'drug','DRx0014464','WIDA RL','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14104,NULL,'drug','DRx0014465','WIDA RL','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14105,NULL,'drug','DRx0014466','WIDA RS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14106,NULL,'drug','DRx0014467','WIDA RS','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14107,NULL,'drug','DRx0014468','WIDAHES','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(14108,NULL,'drug','DRx0014469','WIDECILLIN','Bubuk','Meiji',NULL,NULL,'0.00'),(14109,NULL,'drug','DRx0014470','WIDECILLIN','Bubuk','Meiji',NULL,NULL,'0.00'),(14110,NULL,'drug','DRx0014471','WIDECILLIN','Kaps','Meiji',NULL,NULL,'0.00'),(14111,NULL,'drug','DRx0014472','WIDROX','Kaps','Landson',NULL,NULL,'0.00'),(14112,NULL,'drug','DRx0014473','WINTOGENO EXTRA','Krim','Actavis',NULL,NULL,'0.00'),(14113,NULL,'drug','DRx0014474','WINTOGENO EXTRA','Liniment','Actavis',NULL,NULL,'0.00'),(14114,NULL,'drug','DRx0014475','WYETH GOLD LUTEIN','Bubuk','Wyeth',NULL,NULL,'0.00'),(14115,NULL,'drug','DRx0014476','XALACOM','Tetes','Pfizer',NULL,NULL,'0.00'),(14116,NULL,'drug','DRx0014477','XALATAN','Tetes','Pfizer',NULL,NULL,'0.00'),(14117,NULL,'drug','DRx0014478','XANDA','Sir','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(14118,NULL,'drug','DRx0014479','XANDA','Sir','Teguhsindo Lestaritama',NULL,NULL,'0.00'),(14119,NULL,'drug','DRx0014480','XANVIT','Kapl Salut Selaput','Soho',NULL,NULL,'0.00'),(14120,NULL,'drug','DRx0014481','XANVIT','Sir','Soho',NULL,NULL,'0.00'),(14121,NULL,'drug','DRx0014482','XANVIT','Sir','Soho',NULL,NULL,'0.00'),(14122,NULL,'drug','DRx0014483','XATRAL EL','Tab','Sanofi Aventis',NULL,NULL,'0.00'),(14123,NULL,'drug','DRx0014484','X-CAM','Tab','Meprofarm',NULL,NULL,'0.00'),(14124,NULL,'drug','DRx0014485','X-CAM','Tab','Meprofarm',NULL,NULL,'0.00'),(14125,NULL,'drug','DRx0014486','XEITY','Tab','Lapi',NULL,NULL,'0.00'),(14126,NULL,'drug','DRx0014487','XENOPROM','Vial','Novell Pharma',NULL,NULL,'0.00'),(14127,NULL,'drug','DRx0014488','XEPALIUM','Tab','Metiska Farma',NULL,NULL,'0.00'),(14128,NULL,'drug','DRx0014489','XEPALIUM','Tab','Metiska Farma',NULL,NULL,'0.00'),(14129,NULL,'drug','DRx0014490','XEPAVIT','kapl','Metiska Farma',NULL,NULL,'0.00'),(14130,NULL,'drug','DRx0014491','XEPAZYM','Kapl','Metiska Farma',NULL,NULL,'0.00'),(14131,NULL,'drug','DRx0014492','XEPHATRITIS','Tab Salut Enterik','Metiska Farma',NULL,NULL,'0.00'),(14132,NULL,'drug','DRx0014493','XERADIN','Tab','Metiska Farma',NULL,NULL,'0.00'),(14133,NULL,'drug','DRx0014494','XEVOLAC','Amp','Novell Pharma',NULL,NULL,'0.00'),(14134,NULL,'drug','DRx0014495','XEVOLAC','Amp','Novell Pharma',NULL,NULL,'0.00'),(14135,NULL,'drug','DRx0014496','XILOCAINE 2%','Amp','Astra Zeneca',NULL,NULL,'0.00'),(14136,NULL,'drug','DRx0014497','XILOCAINE 2%','Amp','Astra Zeneca',NULL,NULL,'0.00'),(14137,NULL,'drug','DRx0014498','XILOCAINE 2%','Amp','Astra Zeneca',NULL,NULL,'0.00'),(14138,NULL,'drug','DRx0014499','XIMEX CYLOWAM','Tetes','Konimex',NULL,NULL,'0.00'),(14139,NULL,'drug','DRx0014500','XIMEX KONIGEN','Tetes','Konimex',NULL,NULL,'0.00'),(14140,NULL,'drug','DRx0014501','XIMEX OPTICOM','Tetes','Konimex',NULL,NULL,'0.00'),(14141,NULL,'drug','DRx0014502','XIMEX OPTIXITROL','Tetes','Konimex',NULL,NULL,'0.00'),(14142,NULL,'drug','DRx0014503','XON - CE','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14143,NULL,'drug','DRx0014504','XYLOCAINE SPRAY','Spray','Astra Zeneca',NULL,NULL,'0.00'),(14144,NULL,'drug','DRx0014505','XYLOCARD','Inj','Astra Zeneca',NULL,NULL,'0.00'),(14145,NULL,'drug','DRx0014506','XYZAL','Tab','UCB Pharma',NULL,NULL,'0.00'),(14146,NULL,'drug','DRx0014507','YALONE','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14147,NULL,'drug','DRx0014508','YARIFLAM','Tab Salut Enterik','Yarindo Farmatama',NULL,NULL,'0.00'),(14148,NULL,'drug','DRx0014509','YARIFLAM','Tab Salut Enterik','Yarindo Farmatama',NULL,NULL,'0.00'),(14149,NULL,'drug','DRx0014510','YARISMA','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14150,NULL,'drug','DRx0014511','YARIVEN','Susp','Yarindo Farmatama',NULL,NULL,'0.00'),(14151,NULL,'drug','DRx0014512','YASMIN','Tab','Bayer Schering Pharma',NULL,NULL,'0.00'),(14152,NULL,'drug','DRx0014513','YAVON','Sir','Yarindo Farmatama',NULL,NULL,'0.00'),(14153,NULL,'drug','DRx0014514','YAVON','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14154,NULL,'drug','DRx0014515','YOSENOB','Kaps','Nufarindo',NULL,NULL,'0.00'),(14155,NULL,'drug','DRx0014516','YUSIMOX','Sir Kering Forte','Ifars',NULL,NULL,'0.00'),(14156,NULL,'drug','DRx0014517','ZAC','Kaps','Ikapharmindo',NULL,NULL,'0.00'),(14157,NULL,'drug','DRx0014518','ZAC','Kaps','Ikapharmindo',NULL,NULL,'0.00'),(14158,NULL,'drug','DRx0014519','ZACTIN','Kaps','Merck',NULL,NULL,'0.00'),(14159,NULL,'drug','DRx0014520','ZADAXIN','Vial','Tempo Scan Pacific/SciClone',NULL,NULL,'0.00'),(14160,NULL,'drug','DRx0014521','ZADAXIN','Vial','Tempo Scan Pacific/SciClone',NULL,NULL,'0.00'),(14161,NULL,'drug','DRx0014522','ZAMEL','Sir','Novell Pharma',NULL,NULL,'0.00'),(14162,NULL,'drug','DRx0014523','ZANIDIP','Tab Salut Selaput','Solvay Pharmaceuticals',NULL,NULL,'0.00'),(14163,NULL,'drug','DRx0014524','ZANTAC','Sir','GlaxoSmithKline',NULL,NULL,'0.00'),(14164,NULL,'drug','DRx0014525','ZANTAC','Sir','GlaxoSmithKline',NULL,NULL,'0.00'),(14165,NULL,'drug','DRx0014526','ZANTADIN','Amp','Soho',NULL,NULL,'0.00'),(14166,NULL,'drug','DRx0014527','ZANTADIN','Tab','Soho',NULL,NULL,'0.00'),(14167,NULL,'drug','DRx0014528','ZANTIFAR','Kapl Salut Selaput','Ifars',NULL,NULL,'0.00'),(14168,NULL,'drug','DRx0014529','ZANTRON','Tab','Pyridam',NULL,NULL,'0.00'),(14169,NULL,'drug','DRx0014530','ZAROM','Kaps','Pyridam',NULL,NULL,'0.00'),(14170,NULL,'drug','DRx0014531','ZEFIDIM','Vial','Kalbe Farma',NULL,NULL,'0.00'),(14171,NULL,'drug','DRx0014532','ZELAVEL','Lar Infus','Novell Pharma',NULL,NULL,'0.00'),(14172,NULL,'drug','DRx0014533','ZELAVEL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14173,NULL,'drug','DRx0014534','ZELAVEL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14174,NULL,'drug','DRx0014535','ZELFACE','Krim','Ferron',NULL,NULL,'0.00'),(14175,NULL,'drug','DRx0014536','ZELMAC','Tab','Novartis Indonesia',NULL,NULL,'0.00'),(14176,NULL,'drug','DRx0014537','ZELMAC','Tab','Novartis Indonesia',NULL,NULL,'0.00'),(14177,NULL,'drug','DRx0014538','ZEMYC DRIP','Lar Infus','Pharos',NULL,NULL,'0.00'),(14178,NULL,'drug','DRx0014539','ZERLIN','Tab','Pharos',NULL,NULL,'0.00'),(14179,NULL,'drug','DRx0014540','ZEROPAIN','Krim','Konimex',NULL,NULL,'0.00'),(14180,NULL,'drug','DRx0014541','ZESTAM','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14181,NULL,'drug','DRx0014542','ZEVIT-C','Kapl','Tempo Scan Pacific',NULL,NULL,'0.00'),(14182,NULL,'drug','DRx0014543','ZICHO','Kapl Salut Selaput','Nicholas',NULL,NULL,'0.00'),(14183,NULL,'drug','DRx0014544','ZICHO','Kaps','Nicholas',NULL,NULL,'0.00'),(14184,NULL,'drug','DRx0014545','ZIDIFEC','Vial','Sanbe/Cafrifarmindo',NULL,NULL,'0.00'),(14185,NULL,'drug','DRx0014546','ZINC PHARMACORE','Kaps','Pharmacore',NULL,NULL,'0.00'),(14186,NULL,'drug','DRx0014547','ZINC PHARMACORE','Kaps','Pharmacore',NULL,NULL,'0.00'),(14187,NULL,'drug','DRx0014548','ZINNAT','Susp','GlaxoSmithKline',NULL,NULL,'0.00'),(14188,NULL,'drug','DRx0014549','ZITANID','Tab','Novell Pharma',NULL,NULL,'0.00'),(14189,NULL,'drug','DRx0014550','ZOLACORT','Krim','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14190,NULL,'drug','DRx0014551','ZOLADEX LA','Pre-filled','Astra Zeneca',NULL,NULL,'0.00'),(14191,NULL,'drug','DRx0014552','ZOLAGEL','Krim','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14192,NULL,'drug','DRx0014553','ZOLMIA','Tab Salut Selaput','Fahrenheit',NULL,NULL,'0.00'),(14193,NULL,'drug','DRx0014554','ZOLORAL-SS','Shampo','Ikapharmindo',NULL,NULL,'0.00'),(14194,NULL,'drug','DRx0014555','ZONAL','Tab Salut Gula','Kalbe Farma',NULL,NULL,'0.00'),(14195,NULL,'drug','DRx0014556','ZOVAST','Kapl Salut Selaput','Darya-Varia',NULL,NULL,'0.00'),(14196,NULL,'drug','DRx0014557','ZOVIRAX','Krim','GlaxoSmithKline',NULL,NULL,'0.00'),(14197,NULL,'drug','DRx0014558','ZOVIRAX','Salep','GlaxoSmithKline',NULL,NULL,'0.00'),(14198,NULL,'drug','DRx0014559','ZOVIRAX','Vial','GlaxoSmithKline',NULL,NULL,'0.00'),(14199,NULL,'drug','DRx0014560','ZULTROP','Kapl','Tropica Mas Pharma',NULL,NULL,'0.00'),(14200,NULL,'drug','DRx0014561','ZULTROP','Kapl','Tropica Mas Pharma',NULL,NULL,'0.00'),(14201,NULL,'drug','DRx0014562','ZULTROP FORTE','Kapl Forte','Tropica Mas Pharma',NULL,NULL,'0.00'),(14202,NULL,'drug','DRx0014563','ZUMAFLOX','Lar Infus','Sandoz',NULL,NULL,'0.00'),(14203,NULL,'drug','DRx0014564','ZUMAMET','Tab Salut Selaput','Sandoz',NULL,NULL,'0.00'),(14204,NULL,'drug','DRx0014565','ZUMASID','Tab','Sandoz',NULL,NULL,'0.00'),(14205,NULL,'drug','DRx0014566','ZUMATRAM','Amp','Sandoz',NULL,NULL,'0.00'),(14206,NULL,'drug','DRx0014567','ZUMATROL','Tab','Sandoz',NULL,NULL,'0.00'),(14207,NULL,'drug','DRx0014568','ZUMAZOL','Krim','Sandoz',NULL,NULL,'0.00'),(14208,NULL,'drug','DRx0014569','ZUMAZOL','Krim','Sandoz',NULL,NULL,'0.00'),(14209,NULL,'drug','DRx0014570','ZYCLORAX','Krim','Mugi Labs',NULL,NULL,'0.00'),(14210,NULL,'drug','DRx0014571','ZYCLORAX','Tab','Mugi Labs',NULL,NULL,'0.00'),(14211,NULL,'drug','DRx0014572','ZYFLOX','Tab Salut Selaput','Promed',NULL,NULL,'0.00'),(14212,NULL,'drug','DRx0014573','ZYFLOX','Tab Salut Selaput','Promed',NULL,NULL,'0.00'),(14213,NULL,'drug','DRx0014574','ZYLORIC','Tab','GlaxoSmithKline',NULL,NULL,'0.00'),(14214,NULL,'drug','DRx0014575','ZYLORIC','Tab','GlaxoSmithKline',NULL,NULL,'0.00'),(14215,NULL,'drug','DRx0014576','ZYPREXA','Tab','Eli Lilly',NULL,NULL,'0.00'),(14216,NULL,'drug','DRx0014577','ZYPREXA','Tab','Eli Lilly',NULL,NULL,'0.00'),(14217,NULL,'drug','DRx0014578','ZYPREXA','Vial','Eli Lilly',NULL,NULL,'0.00'),(14218,NULL,'drug','DRx0014579','ZYVOX','Lar Infus','Pfizer',NULL,NULL,'0.00'),(14219,NULL,'drug','DRx0014580','ZYVOX','Susp','Pfizer',NULL,NULL,'0.00'),(14220,NULL,'drug','DRx0014581','ZYVOX','Tab','Pfizer',NULL,NULL,'0.00'),(14221,NULL,'drug','DRx0014582','153 SM - EDTMP','Inj','CIS, Gif-Sur-Yvette, France',NULL,NULL,'0.00'),(14222,NULL,'drug','DRx0014583','2 A 500 ML OTSUKA ','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14223,NULL,'drug','DRx0014584','ACARBOSE DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14224,NULL,'drug','DRx0014585','ACENDRIL','Tab','Hars',NULL,NULL,'0.00'),(14225,NULL,'drug','DRx0014586','ACETON LOKAL','Lar','',NULL,NULL,'0.00'),(14226,NULL,'drug','DRx0014587','ACID ACETIC 98% 1 L','Lar','',NULL,NULL,'0.00'),(14227,NULL,'drug','DRx0014588','ACID BENZOIC 1 KG','Bubuk','',NULL,NULL,'0.00'),(14228,NULL,'drug','DRx0014589','ACID BORIC CRYSTAL','Bubuk','',NULL,NULL,'0.00'),(14229,NULL,'drug','DRx0014590','ACID SALYCIL','Bubuk','',NULL,NULL,'0.00'),(14230,NULL,'drug','DRx0014591','ACNE GEL','Gel','',NULL,NULL,'0.00'),(14231,NULL,'drug','DRx0014592','ACTOPLATIN','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14232,NULL,'drug','DRx0014593','ACTOPLATIN','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14233,NULL,'drug','DRx0014594','ACTRAPID NOVOLET','Vial','Novo Nordisk',NULL,NULL,'0.00'),(14234,NULL,'drug','DRx0014595','ACYCLOVIR INFA','Salep','Info Farma',NULL,NULL,'0.00'),(14235,NULL,'drug','DRx0014596','ACYCLOVIR KF','Salep','Kimia Farma',NULL,NULL,'0.00'),(14236,NULL,'drug','DRx0014597','ACYCLOVIR KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14237,NULL,'drug','DRx0014598','ACYCLOVIR KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14238,NULL,'drug','DRx0014599','ACYCLOVIR PHAPROS','Salep','Phapros',NULL,NULL,'0.00'),(14239,NULL,'drug','DRx0014600','ACYCLOVIR YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14240,NULL,'drug','DRx0014601','ACYCLOVIR NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14241,NULL,'drug','DRx0014602','ACYCLOVIR NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14242,NULL,'drug','DRx0014603','ACYCLOVIR INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14243,NULL,'drug','DRx0014604','ACYCLOVIR INDOFARMA','Cream','Indofarma Tbk',NULL,NULL,'0.00'),(14244,NULL,'drug','DRx0014605','ACYCLOVIR DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14245,NULL,'drug','DRx0014606','ACYCLOVIR DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14246,NULL,'drug','DRx0014607','ADENOFIR','Kaps','',NULL,NULL,'0.00'),(14247,NULL,'drug','DRx0014608','ADRICIN','Vial','Novell Pharma',NULL,NULL,'0.00'),(14248,NULL,'drug','DRx0014609','ADRICIN','Vial','Novell Pharma',NULL,NULL,'0.00'),(14249,NULL,'drug','DRx0014610','AETHOXYSKLEROL 3 %','Amp ','Rajawali/Kreussler',NULL,NULL,'0.00'),(14250,NULL,'drug','DRx0014611','AGRIPPAL','Inj','Novartis Indonesia',NULL,NULL,'0.00'),(14251,NULL,'drug','DRx0014612','ALBENDAZOL INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14252,NULL,'drug','DRx0014613','ALBENDAZOL PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(14253,NULL,'drug','DRx0014614','ALBENDAZOL INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14254,NULL,'drug','DRx0014615','ALCOHOL SWAB','Sachet','',NULL,NULL,'0.00'),(14255,NULL,'drug','DRx0014616','ALDOMER','Tab Salut Film','Mersifarma TM',NULL,NULL,'0.00'),(14256,NULL,'drug','DRx0014617','ALEXAN','Vial','Ferron',NULL,NULL,'0.00'),(14257,NULL,'drug','DRx0014618','ALEXAN','Vial','Ferron',NULL,NULL,'0.00'),(14258,NULL,'drug','DRx0014619','ALKOHOL 96 % 20 L','Lar','',NULL,NULL,'0.00'),(14259,NULL,'drug','DRx0014620','ALKOHOL ABSOLUT PA 2,5 L ','Lar','',NULL,NULL,'0.00'),(14260,NULL,'drug','DRx0014621','ALKOHOL NUFA','Lar','Nufa Farma',NULL,NULL,'0.00'),(14261,NULL,'drug','DRx0014622','ALLOPURINOL HEXAPHARM','Tab','Hexpharm Jaya',NULL,NULL,'0.00'),(14262,NULL,'drug','DRx0014623','ALLOPURINOL HEXAPHARM','Tab','Hexpharm Jaya',NULL,NULL,'0.00'),(14263,NULL,'drug','DRx0014624','ALLOPURINOL YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14264,NULL,'drug','DRx0014625','ALOXTRA','Tab','Pharos',NULL,NULL,'0.00'),(14265,NULL,'drug','DRx0014626','ALUVIA','Tab','Abbot',NULL,NULL,'0.00'),(14266,NULL,'drug','DRx0014627','ALYNOL','Tab','Pharos',NULL,NULL,'0.00'),(14267,NULL,'drug','DRx0014628','AMBROXOL NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14268,NULL,'drug','DRx0014629','AMLODIPIN HEXAPHARM','Tab','Hexapharm',NULL,NULL,'0.00'),(14269,NULL,'drug','DRx0014630','AMLODIPIN DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14270,NULL,'drug','DRx0014631','AMLODIPIN BERNOFARM','Tab','Pratama',NULL,NULL,'0.00'),(14271,NULL,'drug','DRx0014632','AMLODIPIN PRATAMA','Tab','Hexapharm',NULL,NULL,'0.00'),(14272,NULL,'drug','DRx0014633','AMLODIPIN MEDIKON','Tab','Medikon Prima Laboratories (Ogb)',NULL,NULL,'0.00'),(14273,NULL,'drug','DRx0014634','AMMONIUM SULFAT MERCK','Lar','',NULL,NULL,'0.00'),(14274,NULL,'drug','DRx0014635','AMOXICILLIN ( GENERIK )','Tab','',NULL,NULL,'0.00'),(14275,NULL,'drug','DRx0014636','AMOXICILLIN ( GENERIK )','Tab','',NULL,NULL,'0.00'),(14276,NULL,'drug','DRx0014637','AMOXICILLIN INDOFARMA','Kapl','Indofarma Tbk',NULL,NULL,'0.00'),(14277,NULL,'drug','DRx0014638','AMOXICILLIN INDOFARMA','Sir','Indofarma Tbk',NULL,NULL,'0.00'),(14278,NULL,'drug','DRx0014639','AMOXICILLIN INFA','Sir','Info Farma',NULL,NULL,'0.00'),(14279,NULL,'drug','DRx0014640','AMOXICILLIN HEXAPHARM','Sir','Hexpharm Jaya',NULL,NULL,'0.00'),(14280,NULL,'drug','DRx0014641','AMOXICILLIN HEXAPHARM','Tab','Hexpharm Jaya',NULL,NULL,'0.00'),(14281,NULL,'drug','DRx0014642','ANESFAR','Vial','',NULL,NULL,'0.00'),(14282,NULL,'drug','DRx0014643','ANESTESI TOPIKAL LMX','Spray','',NULL,NULL,'0.00'),(14283,NULL,'drug','DRx0014644','ANEXIN','Tab','Sanbe Farma',NULL,NULL,'0.00'),(14284,NULL,'drug','DRx0014645','ANIOS TERMINAL SPORE ASEPTANIOS FRANCE','Lar','Anios Laboratories',NULL,NULL,'0.00'),(14285,NULL,'drug','DRx0014646','ANTACIDA DOEN KF','Sir','',NULL,NULL,'0.00'),(14286,NULL,'drug','DRx0014647','ANTACIDA DOEN ERLA','Tab','Erla',NULL,NULL,'0.00'),(14287,NULL,'drug','DRx0014648','ANTACIDA DOEN MUTI','Tab','Muti',NULL,NULL,'0.00'),(14288,NULL,'drug','DRx0014649','ANTACIDA DOEN KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14289,NULL,'drug','DRx0014650','ANTALGIN DUTA','Amp','Duta',NULL,NULL,'0.00'),(14290,NULL,'drug','DRx0014651','ANTALGIN SAKA','Tab','Saka Farma',NULL,NULL,'0.00'),(14291,NULL,'drug','DRx0014652','ANTI HAEMOROID KF','Supp','Kimia Farma',NULL,NULL,'0.00'),(14292,NULL,'drug','DRx0014653','ANTIPLAT','Tab','',NULL,NULL,'0.00'),(14293,NULL,'drug','DRx0014654','AQUA DM','Lar','',NULL,NULL,'0.00'),(14294,NULL,'drug','DRx0014655','AQUAPACK','Lar','',NULL,NULL,'0.00'),(14295,NULL,'drug','DRx0014656','AROMA FINE FAST SET','Sack','',NULL,NULL,'0.00'),(14296,NULL,'drug','DRx0014657','AROMA FINE NORMAL SET','Sack','',NULL,NULL,'0.00'),(14297,NULL,'drug','DRx0014658','ARSVAMON','Tab','',NULL,NULL,'0.00'),(14298,NULL,'drug','DRx0014659','ASAM ASETAT GLACIAL MERCK','Lar','Merck',NULL,NULL,'0.00'),(14299,NULL,'drug','DRx0014660','ASAM SITRAT 1 KG BAHAN BAKU','Lar','',NULL,NULL,'0.00'),(14300,NULL,'drug','DRx0014661','ASAM SITRAT BAHAN BAKU','Bubuk','',NULL,NULL,'0.00'),(14301,NULL,'drug','DRx0014662','ASAM TRANEKSAMAT BERNOFARM','Inj','Bernofarm',NULL,NULL,'0.00'),(14302,NULL,'drug','DRx0014663','ASAM TRANEKSAMAT BERNOFARM','Inj','Bernofarm',NULL,NULL,'0.00'),(14303,NULL,'drug','DRx0014664','ASEPTI-ZYME','Lar','Intervet',NULL,NULL,'0.00'),(14304,NULL,'drug','DRx0014665','ASEPTY STERYL 28','Lar','',NULL,NULL,'0.00'),(14305,NULL,'drug','DRx0014666','ASTRINGENT R1 5 60 ML','Lar','',NULL,NULL,'0.00'),(14306,NULL,'drug','DRx0014667','ASTRINGENT R1 60 ML','Lar','',NULL,NULL,'0.00'),(14307,NULL,'drug','DRx0014668','ATRACURIUM HAMELN','Amp','Hameln Pharma',NULL,NULL,'0.00'),(14308,NULL,'drug','DRx0014669','ATRACURIUM HAMELN','Amp','Hameln Pharma',NULL,NULL,'0.00'),(14309,NULL,'drug','DRx0014670','ATRANAC','Tab','Corsa',NULL,NULL,'0.00'),(14310,NULL,'drug','DRx0014671','ATRANAC','Tab','Corsa',NULL,NULL,'0.00'),(14311,NULL,'drug','DRx0014672','AUROVISC','Pre-filled','Aurolab',NULL,NULL,'0.00'),(14312,NULL,'drug','DRx0014673','AVAGARD HANDRUB','Lar','',NULL,NULL,'0.00'),(14313,NULL,'drug','DRx0014674','AVIRANZ','Tab','Ranbaxy',NULL,NULL,'0.00'),(14314,NULL,'drug','DRx0014675','BALANCING TONER','Lar','',NULL,NULL,'0.00'),(14315,NULL,'drug','DRx0014676','BANADOZ','Tab','Sandoz Indonesia',NULL,NULL,'0.00'),(14316,NULL,'drug','DRx0014677','BAYCLIN','Lar','SC Johnson',NULL,NULL,'0.00'),(14317,NULL,'drug','DRx0014678','BBTVISC 1,5%','Lar','Bohus Biotech',NULL,NULL,'0.00'),(14318,NULL,'drug','DRx0014679','BD BBS 500 ML SN LOT - 100807','Lar','',NULL,NULL,'0.00'),(14319,NULL,'drug','DRx0014680','BEAUCOUP','Lar','',NULL,NULL,'0.00'),(14320,NULL,'drug','DRx0014681','BEDAK SALISIL KF','Bubuk','Kimia Farma',NULL,NULL,'0.00'),(14321,NULL,'drug','DRx0014682','BETA-ONE','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14322,NULL,'drug','DRx0014683','BETA-ONE','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14323,NULL,'drug','DRx0014684','BIBAG SOD. BICARBONAT','Lar','',NULL,NULL,'0.00'),(14324,NULL,'drug','DRx0014685','BIONEMI','Kaps','Gracia Pharmindo',NULL,NULL,'0.00'),(14325,NULL,'drug','DRx0014686','BIOPLACENTON TULLE','Kain Kassa','Kalbe Farma',NULL,NULL,'0.00'),(14326,NULL,'drug','DRx0014687','BIORAZON','Vial','Otto Pharmaceutical Industries',NULL,NULL,'0.00'),(14327,NULL,'drug','DRx0014688','BIPHENYLOL + PROPANOL','Lar','',NULL,NULL,'0.00'),(14328,NULL,'drug','DRx0014689','BISCOR','Tab','Dexa medica',NULL,NULL,'0.00'),(14329,NULL,'drug','DRx0014690','BISOPROLOL NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14330,NULL,'drug','DRx0014691','BLISTRA','Amp','Pharos',NULL,NULL,'0.00'),(14331,NULL,'drug','DRx0014692','BONDI','Kaps','Ethica Industri Farmasi',NULL,NULL,'0.00'),(14332,NULL,'drug','DRx0014693','BONDRONATE','Vial','Roche Indonesia',NULL,NULL,'0.00'),(14333,NULL,'drug','DRx0014694','BONE ONE','Tab','Dipa Pharmalab Intersains/Teijin',NULL,NULL,'0.00'),(14334,NULL,'drug','DRx0014695','BOTOX ALLERGAN INJ','Vial','',NULL,NULL,'0.00'),(14335,NULL,'drug','DRx0014696','BREXEL 20','Vial','Kalbe Farma',NULL,NULL,'0.00'),(14336,NULL,'drug','DRx0014697','BREXEL 80','Vial','Kalbe Farma',NULL,NULL,'0.00'),(14337,NULL,'drug','DRx0014698','BRILLIANT C BLUE MERCK','Lar','Merck',NULL,NULL,'0.00'),(14338,NULL,'drug','DRx0014699','BRM','Kaps','',NULL,NULL,'0.00'),(14339,NULL,'drug','DRx0014700','BROMOSAL','Tab','Hars',NULL,NULL,'0.00'),(14340,NULL,'drug','DRx0014701','BROMOSAL','Tab','Hars',NULL,NULL,'0.00'),(14341,NULL,'drug','DRx0014702','BRUFEN SYRUP','Sir','Abbott',NULL,NULL,'0.00'),(14342,NULL,'drug','DRx0014703','BUBUK MASKER','Bubuk','',NULL,NULL,'0.00'),(14343,NULL,'drug','DRx0014704','BUBUK PEELING','Bubuk','',NULL,NULL,'0.00'),(14344,NULL,'drug','DRx0014705','BUNASCAN SPINAL 0,5% HEAVY','Amp','Fahrenheit',NULL,NULL,'0.00'),(14345,NULL,'drug','DRx0014706','BUSERELIN','Vial','',NULL,NULL,'0.00'),(14346,NULL,'drug','DRx0014707','BUSULFAN','tab salut','',NULL,NULL,'0.00'),(14347,NULL,'drug','DRx0014708','BUTOCONAZOLE NITRATE','Krim','',NULL,NULL,'0.00'),(14348,NULL,'drug','DRx0014709','C3F8 GAZ','Tabung','',NULL,NULL,'0.00'),(14349,NULL,'drug','DRx0014710','CALAMINE','Lot','',NULL,NULL,'0.00'),(14350,NULL,'drug','DRx0014711','CALC CARBONAT JEPANG 1 KG','Bubuk','',NULL,NULL,'0.00'),(14351,NULL,'drug','DRx0014712','CAMPAIN','Tab','Hars',NULL,NULL,'0.00'),(14352,NULL,'drug','DRx0014713','CAMPAIN','Tab','Hars',NULL,NULL,'0.00'),(14353,NULL,'drug','DRx0014714','CANTHACUR','Lar','',NULL,NULL,'0.00'),(14354,NULL,'drug','DRx0014715','CAPTOPRIL INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14355,NULL,'drug','DRx0014716','CAPTOPRIL KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14356,NULL,'drug','DRx0014717','CAPTOPRIL LANDSON','Tab','Landson',NULL,NULL,'0.00'),(14357,NULL,'drug','DRx0014718','CAPTOPRIL PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(14358,NULL,'drug','DRx0014719','CAPTROPIL DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14359,NULL,'drug','DRx0014720','CAPTROPIL DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14360,NULL,'drug','DRx0014721','CAPTROPIL DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14361,NULL,'drug','DRx0014722','CARBAMAZEPINE INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14362,NULL,'drug','DRx0014723','CARBO GLYCERIN 10%','Lar','',NULL,NULL,'0.00'),(14363,NULL,'drug','DRx0014724','CARBOPLATIN MERCK','Vial','Merck',NULL,NULL,'0.00'),(14364,NULL,'drug','DRx0014725','CARBOPLATIN MERCK','Vial','Merck',NULL,NULL,'0.00'),(14365,NULL,'drug','DRx0014726','CARDISMO','Tab','Phapros, Tbk',NULL,NULL,'0.00'),(14366,NULL,'drug','DRx0014727','CARTYLO','Tab','Kimia Farma',NULL,NULL,'0.00'),(14367,NULL,'drug','DRx0014728','CATHEJEL JELY 2%','Gel','',NULL,NULL,'0.00'),(14368,NULL,'drug','DRx0014729','CAVIT G-44313 04661','Botol','',NULL,NULL,'0.00'),(14369,NULL,'drug','DRx0014730','CEALBUMIN 20% ASKESKIN','Lar Infus','Graha Farma',NULL,NULL,'0.00'),(14370,NULL,'drug','DRx0014731','CEFADROXIL SOHO','Kaps','Soho Industri Pharmasi',NULL,NULL,'0.00'),(14371,NULL,'drug','DRx0014732','CEFADROXIL BERNOFARM','Kaps','Bernofarm',NULL,NULL,'0.00'),(14372,NULL,'drug','DRx0014733','CEFADROXIL BERNOFARM','Sir Kering','Bernofarm',NULL,NULL,'0.00'),(14373,NULL,'drug','DRx0014734','CEFADROXIL INFA','Sir Kering','Indo Farma',NULL,NULL,'0.00'),(14374,NULL,'drug','DRx0014735','CEFADROXIL LANDSON','Sir Kering','Landson',NULL,NULL,'0.00'),(14375,NULL,'drug','DRx0014736','CEFALEXIN','Tab','Indo Farma',NULL,NULL,'0.00'),(14376,NULL,'drug','DRx0014737','CEFEPIME HEXAPHARM','Inj','Hexpharm Jaya',NULL,NULL,'0.00'),(14377,NULL,'drug','DRx0014738','CEFIXIME LANSON','Sir Kering','Landson',NULL,NULL,'0.00'),(14378,NULL,'drug','DRx0014739','CEFIXIME NULAB','Kaps','Nulab Pharmaceutical Indonesia (Divisi Ogb)',NULL,NULL,'0.00'),(14379,NULL,'drug','DRx0014740','CEFIXIME MEDIKON','Kaps','Medikon Prima Laboratories (Ogb)',NULL,NULL,'0.00'),(14380,NULL,'drug','DRx0014741','CEFOPERAZONE','Vial','Hexpharm Jaya',NULL,NULL,'0.00'),(14381,NULL,'drug','DRx0014742','CEFOTAXIME BERNOFARM','Vial','Bernofarm',NULL,NULL,'0.00'),(14382,NULL,'drug','DRx0014743','CEFSIX','Vial','Mersifarma TM',NULL,NULL,'0.00'),(14383,NULL,'drug','DRx0014744','CEFTIZOXIME','Vial','',NULL,NULL,'0.00'),(14384,NULL,'drug','DRx0014745','CEFTRIAXONE BERNOFARM','Vial','Bernofarm',NULL,NULL,'0.00'),(14385,NULL,'drug','DRx0014746','CELEMIN 10+','Lar Infus','Clar',NULL,NULL,'0.00'),(14386,NULL,'drug','DRx0014747','CELEMIN 5S+','Lar Infus','Clar',NULL,NULL,'0.00'),(14387,NULL,'drug','DRx0014748','CENDO CENFRES MNDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14388,NULL,'drug','DRx0014749','CENDO EDTA','Tetes','Cendo',NULL,NULL,'0.00'),(14389,NULL,'drug','DRx0014750','CENDO EYE FRESH MONODOSE','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14390,NULL,'drug','DRx0014751','CENDO FLOXA MNDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14391,NULL,'drug','DRx0014752','CENDO NONCORT MONODOSE','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14392,NULL,'drug','DRx0014753','CENDO OPTALGON','Tetes','Cendo',NULL,NULL,'0.00'),(14393,NULL,'drug','DRx0014754','CENDO PANTOCAIN 0,5% MDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14394,NULL,'drug','DRx0014755','CENDO PANTOCAIN 0,2% MDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14395,NULL,'drug','DRx0014756','CENDO POLIDEX','Tetes','Cendo',NULL,NULL,'0.00'),(14396,NULL,'drug','DRx0014757','CENDO POLIDEX','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14397,NULL,'drug','DRx0014758','CENDO POLINEL','Tetes','Cendo',NULL,NULL,'0.00'),(14398,NULL,'drug','DRx0014759','CENDO POLYGRAN EYE OINT 3,5 G','Salep','Cendo',NULL,NULL,'0.00'),(14399,NULL,'drug','DRx0014760','CENDO POLYGRAN MNDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14400,NULL,'drug','DRx0014761','CENDO PROTAGENT A MONODOSE','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14401,NULL,'drug','DRx0014762','CENDO TEARSLUB MINIDOSE','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14402,NULL,'drug','DRx0014763','CENDO TIMOL 0,25%','Tetes','Cendo',NULL,NULL,'0.00'),(14403,NULL,'drug','DRx0014764','CENDO TIMOL 0,5%','Tetes','Cendo',NULL,NULL,'0.00'),(14404,NULL,'drug','DRx0014765','CENDO TIMOL 1 %','Tetes','Cendo',NULL,NULL,'0.00'),(14405,NULL,'drug','DRx0014766','CENDO VOSAMA MNDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14406,NULL,'drug','DRx0014767','CENDO XITROL SALEP','Salep','Cendo',NULL,NULL,'0.00'),(14407,NULL,'drug','DRx0014768','CENDO XYTROL MNDS','Tetes Monodose','Cendo',NULL,NULL,'0.00'),(14408,NULL,'drug','DRx0014769','CENDO TROPINE 0,5%','Tetes','Cendo',NULL,NULL,'0.00'),(14409,NULL,'drug','DRx0014770','CENTRASIC','Tab','Graha Farma',NULL,NULL,'0.00'),(14410,NULL,'drug','DRx0014771','CENTRASIC','Vial','Graha Farma',NULL,NULL,'0.00'),(14411,NULL,'drug','DRx0014772','CEPALIN EXTR, ALLANTOIN','Krim','',NULL,NULL,'0.00'),(14412,NULL,'drug','DRx0014773','CERAMAX','Lar Infus','Kalbe Farma, Tbk',NULL,NULL,'0.00'),(14413,NULL,'drug','DRx0014774','CETIRIZINE INF','Tab Salut Selaput','Info Farma',NULL,NULL,'0.00'),(14414,NULL,'drug','DRx0014775','CHLORALHYDRAS 1 KG','Bubuk','',NULL,NULL,'0.00'),(14415,NULL,'drug','DRx0014776','CHLORAMPHENICOL BASE 1 KG','Bubuk','',NULL,NULL,'0.00'),(14416,NULL,'drug','DRx0014777','CHLORHEX 2%','Lar','',NULL,NULL,'0.00'),(14417,NULL,'drug','DRx0014778','CHLORHEX 2%','Lar','',NULL,NULL,'0.00'),(14418,NULL,'drug','DRx0014779','CIDARAL','Tab','Hars',NULL,NULL,'0.00'),(14419,NULL,'drug','DRx0014780','CIDEX 2%','Lar','Johnson',NULL,NULL,'0.00'),(14420,NULL,'drug','DRx0014781','CIDEX 2%','Lar','Johnson',NULL,NULL,'0.00'),(14421,NULL,'drug','DRx0014782','CIDEX OPA','Lar','',NULL,NULL,'0.00'),(14422,NULL,'drug','DRx0014783','CIDEZYME','Lar','',NULL,NULL,'0.00'),(14423,NULL,'drug','DRx0014784','CIDEZYME','Lar','',NULL,NULL,'0.00'),(14424,NULL,'drug','DRx0014785','CIPROFLOXACIN BERNOFARM','Tab','Bernofarm',NULL,NULL,'0.00'),(14425,NULL,'drug','DRx0014786','CIPROFLOXACIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14426,NULL,'drug','DRx0014787','CIPROFLOXACIN NOVELL','Capl','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14427,NULL,'drug','DRx0014788','CIPROX','Lar Infus','Clar',NULL,NULL,'0.00'),(14428,NULL,'drug','DRx0014789','CISPLATIN MERCK','Vial','Merck',NULL,NULL,'0.00'),(14429,NULL,'drug','DRx0014790','CISPLATIN MERCK','Vial','Merck',NULL,NULL,'0.00'),(14430,NULL,'drug','DRx0014791','CITROSOL','Tab','Otto Pharmaceutical Industries',NULL,NULL,'0.00'),(14431,NULL,'drug','DRx0014792','CLEANSING MILK','Lar','',NULL,NULL,'0.00'),(14432,NULL,'drug','DRx0014793','CLEANSING SCRUB BP','Salep','',NULL,NULL,'0.00'),(14433,NULL,'drug','DRx0014794','CLIN 4% GEL 10 G','Gel','',NULL,NULL,'0.00'),(14434,NULL,'drug','DRx0014795','CLORILEX 25','Tab','Mersifarma TM',NULL,NULL,'0.00'),(14435,NULL,'drug','DRx0014796','CO2 KAP 25 KG','Tabung','',NULL,NULL,'0.00'),(14436,NULL,'drug','DRx0014797','CO-AMOXYCLAV','Tab','Indo Farma',NULL,NULL,'0.00'),(14437,NULL,'drug','DRx0014798','COARTEM','Tab','Novell Pharma',NULL,NULL,'0.00'),(14438,NULL,'drug','DRx0014799','COFEIN LOKAL','Bubuk','',NULL,NULL,'0.00'),(14439,NULL,'drug','DRx0014800','COMPOSITE A2 Z250 3M ESPE','Tube','3m ESPE',NULL,NULL,'0.00'),(14440,NULL,'drug','DRx0014801','COMPOSITE A3 Z250 3M ESPE','Tube','3m ESPE',NULL,NULL,'0.00'),(14441,NULL,'drug','DRx0014802','COMPOSITE A3,5 Z250 3M ESPE','Tube','3m ESPE',NULL,NULL,'0.00'),(14442,NULL,'drug','DRx0014803','COMPOSITE C4 Z250 3M ESPE','Tube','3m ESPE',NULL,NULL,'0.00'),(14443,NULL,'drug','DRx0014804','CORRECTIVE NIGHT CREAM','Krim','',NULL,NULL,'0.00'),(14444,NULL,'drug','DRx0014805','CORSADOL','Tab','Corsa',NULL,NULL,'0.00'),(14445,NULL,'drug','DRx0014806','CORTESA','Tab','Hars',NULL,NULL,'0.00'),(14446,NULL,'drug','DRx0014807','CORTISON','Amp','',NULL,NULL,'0.00'),(14447,NULL,'drug','DRx0014808','COTRIMOXAZOLE INDOFARMA','Susp','Indofarma',NULL,NULL,'0.00'),(14448,NULL,'drug','DRx0014809','COTRIMOXAZOLE SUNT','Tab','Sunthi Sepuri',NULL,NULL,'0.00'),(14449,NULL,'drug','DRx0014810','COTRIMOXAZOLE KF','Sir','Kimia Farma',NULL,NULL,'0.00'),(14450,NULL,'drug','DRx0014811','CRESOPHENE','Lar','',NULL,NULL,'0.00'),(14451,NULL,'drug','DRx0014812','CROMOLYN','Drops','',NULL,NULL,'0.00'),(14452,NULL,'drug','DRx0014813','CRYPTAL DRIP','Lar Infus','Fahrenheit',NULL,NULL,'0.00'),(14453,NULL,'drug','DRx0014814','CTM GMP','Tab','Global Multi Pharmalab (GMP)',NULL,NULL,'0.00'),(14454,NULL,'drug','DRx0014815','CUB CONCENTRATE TYPE AK 10 L','Lar','',NULL,NULL,'0.00'),(14455,NULL,'drug','DRx0014816','CUB CONCENTRATE TYPE AT 7 L','Lar','',NULL,NULL,'0.00'),(14456,NULL,'drug','DRx0014817','CUSTODIOL','Supp','Pharos',NULL,NULL,'0.00'),(14457,NULL,'drug','DRx0014818','CUTISOFT HAND SCRUB','Lar','',NULL,NULL,'0.00'),(14458,NULL,'drug','DRx0014819','CYCLOPHOSPHAMIDE KALBE','Vial','Kalbe Farma',NULL,NULL,'0.00'),(14459,NULL,'drug','DRx0014820','CYCLOVID','Vial','Novell Pharma',NULL,NULL,'0.00'),(14460,NULL,'drug','DRx0014821','CYCLOVID','Vial','Novell Pharma',NULL,NULL,'0.00'),(14461,NULL,'drug','DRx0014822','CYCLOVID','Vial','Novell Pharma',NULL,NULL,'0.00'),(14462,NULL,'drug','DRx0014823','CYGEST','Pessary','Actavis Indonesia (Ogb+Ethical)',NULL,NULL,'0.00'),(14463,NULL,'drug','DRx0014824','CYTODROX','Kaps','',NULL,NULL,'0.00'),(14464,NULL,'drug','DRx0014825','DACTINOMYCIN','Vial','',NULL,NULL,'0.00'),(14465,NULL,'drug','DRx0014826','DAILY CREAM 10','Krim','',NULL,NULL,'0.00'),(14466,NULL,'drug','DRx0014827','DAILY CREAM 25','Krim','',NULL,NULL,'0.00'),(14467,NULL,'drug','DRx0014828','DAILY CREAM 50','Krim','',NULL,NULL,'0.00'),(14468,NULL,'drug','DRx0014829','DAUNOCIN','Vial','VHB (Cytocare)',NULL,NULL,'0.00'),(14469,NULL,'drug','DRx0014830','DECATRIM FORTE','Tab','Hars',NULL,NULL,'0.00'),(14470,NULL,'drug','DRx0014831','DECATROCIN DS','Sir','Hars',NULL,NULL,'0.00'),(14471,NULL,'drug','DRx0014832','DEXTROMETHORPHAN INDOFARMA','Sir','Indo Farma',NULL,NULL,'0.00'),(14472,NULL,'drug','DRx0014833','DEXTROMETHORPHAN INDOFARMA','Tab','Info Farma',NULL,NULL,'0.00'),(14473,NULL,'drug','DRx0014834','DEXTROMETHORPHAN KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14474,NULL,'drug','DRx0014835','DEXTROMETHORPHAN MUTI','Sir','Muti',NULL,NULL,'0.00'),(14475,NULL,'drug','DRx0014836','DELLAMIDON','Vial','',NULL,NULL,'0.00'),(14476,NULL,'drug','DRx0014837','DEPAKOTE','Tab Salut Enterik','Abbott',NULL,NULL,'0.00'),(14477,NULL,'drug','DRx0014838','DEPAKOTE ER','Tab Salut Enterik','Abbott',NULL,NULL,'0.00'),(14478,NULL,'drug','DRx0014839','DEPAKOTE ER','Tab Salut Enterik','Abbott',NULL,NULL,'0.00'),(14479,NULL,'drug','DRx0014840','DERMANIOS SCRUB 4%','Lar','Anios Laboratories',NULL,NULL,'0.00'),(14480,NULL,'drug','DRx0014841','DESINFEKTAN C 100%','Lar','',NULL,NULL,'0.00'),(14481,NULL,'drug','DRx0014842','DESMANOL 20%','Lar','Schülke & Mayr',NULL,NULL,'0.00'),(14482,NULL,'drug','DRx0014843','DEXAMETHASON INFA','Amp','Info Farma',NULL,NULL,'0.00'),(14483,NULL,'drug','DRx0014844','DEXANORM','Tab','Dexa Medica',NULL,NULL,'0.00'),(14484,NULL,'drug','DRx0014845','DEXOSYN','Cream','Pharos',NULL,NULL,'0.00'),(14485,NULL,'drug','DRx0014846','DEXTROSE 10 % WIDATRA','Lar Infus','Widatra',NULL,NULL,'0.00'),(14486,NULL,'drug','DRx0014847','DEXTROSE 10% ECOSOL','Lar Infus','Buminusantara Bestari Perkasa/B Braun',NULL,NULL,'0.00'),(14487,NULL,'drug','DRx0014848','DEXTROSE 5% + NACL 0.45%','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14488,NULL,'drug','DRx0014849','DEXTROSE 5% + NORMAL SALINE OTSU','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14489,NULL,'drug','DRx0014850','DEXTROSE PIGGY BACK','Lar Infus','',NULL,NULL,'0.00'),(14490,NULL,'drug','DRx0014851','DIABETASOL','Bubuk','',NULL,NULL,'0.00'),(14491,NULL,'drug','DRx0014852','DIALDEHYD','Lar','',NULL,NULL,'0.00'),(14492,NULL,'drug','DRx0014853','DIAVERSA','Tab','',NULL,NULL,'0.00'),(14493,NULL,'drug','DRx0014854','DIAZEPAM INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14494,NULL,'drug','DRx0014855','DIAZEPAM YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14495,NULL,'drug','DRx0014856','DIAZEPAM YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14496,NULL,'drug','DRx0014857','DIAZOL','Lar Infus','',NULL,NULL,'0.00'),(14497,NULL,'drug','DRx0014858','DIETHYLSTILBESTROL','Inj','',NULL,NULL,'0.00'),(14498,NULL,'drug','DRx0014859','DILTIAZEM INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14499,NULL,'drug','DRx0014860','DOCETERE','Vial','Ferron',NULL,NULL,'0.00'),(14500,NULL,'drug','DRx0014861','DOCETERE','Vial','Ferron',NULL,NULL,'0.00'),(14501,NULL,'drug','DRx0014862','DOXYCYCLINE YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14502,NULL,'drug','DRx0014863','DOLONES','Krim','Sanbe Farma',NULL,NULL,'0.00'),(14503,NULL,'drug','DRx0014864','DOPINE','Amp','Clar',NULL,NULL,'0.00'),(14504,NULL,'drug','DRx0014865','DOTAREM','Vial','',NULL,NULL,'0.00'),(14505,NULL,'drug','DRx0014866','DOXORUBICIN ACTAVIS','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14506,NULL,'drug','DRx0014867','DOXORUBICIN ACTAVIS','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14507,NULL,'drug','DRx0014868','DOXORUBICIN NOVELL','Vial','Novell Pharma',NULL,NULL,'0.00'),(14508,NULL,'drug','DRx0014869','DOXORUBICIN NOVELL','Vial','Novell Pharma',NULL,NULL,'0.00'),(14509,NULL,'drug','DRx0014870','DOXOTIL','Vial','Dipa Pharmalab Intersains Indonesia',NULL,NULL,'0.00'),(14510,NULL,'drug','DRx0014871','DOXOTIL','Vial','Dipa Pharmalab Intersains Indonesia',NULL,NULL,'0.00'),(14511,NULL,'drug','DRx0014872','DUODERM EXTRA THIN','Kain Kassa','',NULL,NULL,'0.00'),(14512,NULL,'drug','DRx0014873','DUODERM HYDRO ACTIV','Gel','',NULL,NULL,'0.00'),(14513,NULL,'drug','DRx0014874','DUROGESIC','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(14514,NULL,'drug','DRx0014875','DUROGESIC','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(14515,NULL,'drug','DRx0014876','DUVIRAL TAB','Tab','Kimia Farma',NULL,NULL,'0.00'),(14516,NULL,'drug','DRx0014877','EBETAXEL','Vial','Ferron',NULL,NULL,'0.00'),(14517,NULL,'drug','DRx0014878','ECOSOL 1/2 DAG','Lar Infus','Buminusantara Bestari Perkasa/B Braun',NULL,NULL,'0.00'),(14518,NULL,'drug','DRx0014879','ECOSOL 2A','Lar Infus','Buminusantara Bestari Perkasa/B Braun',NULL,NULL,'0.00'),(14519,NULL,'drug','DRx0014880','ECRON INJ 10 MG','Vial','',NULL,NULL,'0.00'),(14520,NULL,'drug','DRx0014881','EFAVIR TAB 200 MG','Tab','Cipla',NULL,NULL,'0.00'),(14521,NULL,'drug','DRx0014882','EFAVIR TAB 600 MG','Tab','Cipla',NULL,NULL,'0.00'),(14522,NULL,'drug','DRx0014883','EPHEDRINE INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14523,NULL,'drug','DRx0014884','EKG JELLY PARKER','Gel','',NULL,NULL,'0.00'),(14524,NULL,'drug','DRx0014885','ELECTRODE CONTACT SPRAY','Spray','',NULL,NULL,'0.00'),(14525,NULL,'drug','DRx0014886','ELITE CEMENT 100 POWDER 125 G','Bubuk','',NULL,NULL,'0.00'),(14526,NULL,'drug','DRx0014887','ELLGY H2O','Lotion','Merapi Utama Pharma (Hoe)',NULL,NULL,'0.00'),(14527,NULL,'drug','DRx0014888','ELLGY H2O','Cream','Merapi Utama Pharma (Hoe)',NULL,NULL,'0.00'),(14528,NULL,'drug','DRx0014889','ENAKUR','Tab','Hars',NULL,NULL,'0.00'),(14529,NULL,'drug','DRx0014890','ENDOMETASON IVORY 14 G','Lar','',NULL,NULL,'0.00'),(14530,NULL,'drug','DRx0014891','ENDURO 4%','Lar','',NULL,NULL,'0.00'),(14531,NULL,'drug','DRx0014892','ENTELAN 100 ML','Lar','',NULL,NULL,'0.00'),(14532,NULL,'drug','DRx0014893','EO GAS 2018','?','',NULL,NULL,'0.00'),(14533,NULL,'drug','DRx0014894','EOSIN ALKOHOL','Lar','',NULL,NULL,'0.00'),(14534,NULL,'drug','DRx0014895','EOSIN O MERCK 1.092530000','Lar','Merck',NULL,NULL,'0.00'),(14535,NULL,'drug','DRx0014896','ERGOTAMIN KOFEIN KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14536,NULL,'drug','DRx0014897','ERYTHROMYCIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14537,NULL,'drug','DRx0014898','ERPHAFILIN','Tab','Erlimpex',NULL,NULL,'0.00'),(14538,NULL,'drug','DRx0014899','ERYRA','Sir','Rama',NULL,NULL,'0.00'),(14539,NULL,'drug','DRx0014900','ERYTHROMYCIN KF','Sir','Kimia Farma',NULL,NULL,'0.00'),(14540,NULL,'drug','DRx0014901','ERYTHROMYCIN KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14541,NULL,'drug','DRx0014902','ERYTHROMYCIN KF','Kaps','Kimia Farma',NULL,NULL,'0.00'),(14542,NULL,'drug','DRx0014903','ERYTHROMYCIN SYRUP INFA','Sir','Info Farma',NULL,NULL,'0.00'),(14543,NULL,'drug','DRx0014904','ETCHING GEL (TUBE BESAR)','Tube','',NULL,NULL,'0.00'),(14544,NULL,'drug','DRx0014905','ETHAMBUTOL BERNOFARM','Tab','Kimia Farma',NULL,NULL,'0.00'),(14545,NULL,'drug','DRx0014906','ETHAMBUTOL RAMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14546,NULL,'drug','DRx0014907','ETHANOL 2,5 L','Lar','',NULL,NULL,'0.00'),(14547,NULL,'drug','DRx0014908','ETILKLORIDA SPRAY','Spray','',NULL,NULL,'0.00'),(14548,NULL,'drug','DRx0014909','ETOPOXIDE','Inj','',NULL,NULL,'0.00'),(14549,NULL,'drug','DRx0014910','ETOPUL','Vial','Novell Pharma',NULL,NULL,'0.00'),(14550,NULL,'drug','DRx0014911','EUGENOL GHIMAS','Botol','PT Barito Budi Pharmindo',NULL,NULL,'0.00'),(14551,NULL,'drug','DRx0014912','EXAFLEX INJECTION B/C 74 ML','Tube','',NULL,NULL,'0.00'),(14552,NULL,'drug','DRx0014913','EXTRAN MA 02 NEITRAL 2,5 L E MERCK','Lar','Merck',NULL,NULL,'0.00'),(14553,NULL,'drug','DRx0014914','E-Z GAS II','Bubuk Effervescen','',NULL,NULL,'0.00'),(14554,NULL,'drug','DRx0014915','FABIOLIN','Vial','',NULL,NULL,'0.00'),(14555,NULL,'drug','DRx0014916','FAMOTIDINE INDOFARMA','Tab','Indo Farma',NULL,NULL,'0.00'),(14556,NULL,'drug','DRx0014917','FARGOXIN','Amp','Fahrenheit',NULL,NULL,'0.00'),(14557,NULL,'drug','DRx0014918','FARMADOL','Inj','Fahrenheit',NULL,NULL,'0.00'),(14558,NULL,'drug','DRx0014919','FASORBID','Inj','Pratapa Nirmala (Fahrenheit)',NULL,NULL,'0.00'),(14559,NULL,'drug','DRx0014920','FEBOGREL','Tab','Otto Pharmaceutical Industries',NULL,NULL,'0.00'),(14560,NULL,'drug','DRx0014921','FENATIC','Tab','',NULL,NULL,'0.00'),(14561,NULL,'drug','DRx0014922','FENIDA','Tab','Hars',NULL,NULL,'0.00'),(14562,NULL,'drug','DRx0014923','FENITOINA NATRIUM','Kaps','',NULL,NULL,'0.00'),(14563,NULL,'drug','DRx0014924','FENOBARBITAL FADA','Amp','Fada',NULL,NULL,'0.00'),(14564,NULL,'drug','DRx0014925','FENOKSIMETIL PENISILIN PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(14565,NULL,'drug','DRx0014926','FENTANYL KF','Amp','Kimia Farma',NULL,NULL,'0.00'),(14566,NULL,'drug','DRx0014927','FERRIPROX FCT','Tab Salut Selaput','Quamed',NULL,NULL,'0.00'),(14567,NULL,'drug','DRx0014928','FIBRAMED','Capl','Promedrahardjo Industri Farmasi',NULL,NULL,'0.00'),(14568,NULL,'drug','DRx0014929','FITOMENADION','Amp','Phapros',NULL,NULL,'0.00'),(14569,NULL,'drug','DRx0014930','FITOMENADION','Tab','Phapros',NULL,NULL,'0.00'),(14570,NULL,'drug','DRx0014931','FLAMESON','Tab','Graha Farma',NULL,NULL,'0.00'),(14571,NULL,'drug','DRx0014932','FLASICOX','Tab','Ifars',NULL,NULL,'0.00'),(14572,NULL,'drug','DRx0014933','FLETCHER POWDER','Botol','',NULL,NULL,'0.00'),(14573,NULL,'drug','DRx0014934','FLUARIX','Inj','',NULL,NULL,'0.00'),(14574,NULL,'drug','DRx0014935','FLUCANOL','Lar Infus','Clar',NULL,NULL,'0.00'),(14575,NULL,'drug','DRx0014936','FLUCONAZOLE NOVELL','Inj','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14576,NULL,'drug','DRx0014937','FLUCONAZOLE LANDSON','Inj','Landson',NULL,NULL,'0.00'),(14577,NULL,'drug','DRx0014938','FLUFENAZIN','Tab','',NULL,NULL,'0.00'),(14578,NULL,'drug','DRx0014939','FLUFENAZIN INJ','Inj','',NULL,NULL,'0.00'),(14579,NULL,'drug','DRx0014940','FLUORESCEIN INJ','Vial','',NULL,NULL,'0.00'),(14580,NULL,'drug','DRx0014941','OCUFLAM','Eye Drops','Sanbe Farma',NULL,NULL,'0.00'),(14581,NULL,'drug','DRx0014942','FLUOROURACIL INJ 250 MG EBEWE','Vial','Ferron/Ebewe',NULL,NULL,'0.00'),(14582,NULL,'drug','DRx0014943','FLUOROURACIL INJ 500 MG EBEWE','Vial','Ferron/Ebewe',NULL,NULL,'0.00'),(14583,NULL,'drug','DRx0014944','FLUOROKORTOLON ACETONIDE','krim','',NULL,NULL,'0.00'),(14584,NULL,'drug','DRx0014945','FLUXUM INJ 0,6 ML','Vial','USV (Corvette)',NULL,NULL,'0.00'),(14585,NULL,'drug','DRx0014946','FLUXUM INJ 0.4','Vial','USV (Corvette)',NULL,NULL,'0.00'),(14586,NULL,'drug','DRx0014947','FOBAN OINTMENT','Salep','',NULL,NULL,'0.00'),(14587,NULL,'drug','DRx0014948','FORANSI','Kaps','Gracia Pharmindo',NULL,NULL,'0.00'),(14588,NULL,'drug','DRx0014949','FORDIAB','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14589,NULL,'drug','DRx0014950','FORMABES','Amp','Prat',NULL,NULL,'0.00'),(14590,NULL,'drug','DRx0014951','FORMALIN','Tab','',NULL,NULL,'0.00'),(14591,NULL,'drug','DRx0014952','FORMALIN 37%','Lar','',NULL,NULL,'0.00'),(14592,NULL,'drug','DRx0014953','FREEDOL','Tab','Hars',NULL,NULL,'0.00'),(14593,NULL,'drug','DRx0014954','FREEDOL','Tab','Hars',NULL,NULL,'0.00'),(14594,NULL,'drug','DRx0014955','FREGENOL','Lar','',NULL,NULL,'0.00'),(14595,NULL,'drug','DRx0014956','FRUSID','Amp','Clar',NULL,NULL,'0.00'),(14596,NULL,'drug','DRx0014957','FUCHSIN A 100 ML','Lar','',NULL,NULL,'0.00'),(14597,NULL,'drug','DRx0014958','FUROSEMID KF','Amp','Kimia Farma',NULL,NULL,'0.00'),(14598,NULL,'drug','DRx0014959','GARAM INGGRIS 1 KG','Bubuk','',NULL,NULL,'0.00'),(14599,NULL,'drug','DRx0014960','GASCON','Lar','',NULL,NULL,'0.00'),(14600,NULL,'drug','DRx0014961','GEMTAVIS','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14601,NULL,'drug','DRx0014962','GEMTAVIS','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14602,NULL,'drug','DRx0014963','GENTIAN VIOLET 1%','Lar','',NULL,NULL,'0.00'),(14603,NULL,'drug','DRx0014964','GIEMSA MERCK','Lar','Merck',NULL,NULL,'0.00'),(14604,NULL,'drug','DRx0014965','GIGAZYME','Lar','Schülke & Mayr',NULL,NULL,'0.00'),(14605,NULL,'drug','DRx0014966','GLAUSETA','Tab','Sanbe Farma',NULL,NULL,'0.00'),(14606,NULL,'drug','DRx0014967','GLIABETES','Tab','Sanbe Farma',NULL,NULL,'0.00'),(14607,NULL,'drug','DRx0014968','GLIBENCLAMIDE INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14608,NULL,'drug','DRx0014969','GLICERIN DOW','Lar','',NULL,NULL,'0.00'),(14609,NULL,'drug','DRx0014970','GLIDIAB','Tab','Soho',NULL,NULL,'0.00'),(14610,NULL,'drug','DRx0014971','GLISERIN MINUM RSCM','Lar','',NULL,NULL,'0.00'),(14611,NULL,'drug','DRx0014972','GLUCOSE 1 KG','Bubuk','',NULL,NULL,'0.00'),(14612,NULL,'drug','DRx0014973','GLUKOSAMIN MEDIKON','Tab','Medikon',NULL,NULL,'0.00'),(14613,NULL,'drug','DRx0014974','GLYBOTIC','Vial','Sanbe Farma',NULL,NULL,'0.00'),(14614,NULL,'drug','DRx0014975','GLYBOTIC','Vial','Sanbe Farma',NULL,NULL,'0.00'),(14615,NULL,'drug','DRx0014976','CENDO LUBRICEN','Eye Drops','Cendo Pharmaceutical Industries',NULL,NULL,'0.00'),(14616,NULL,'drug','DRx0014977','GLYCERIN LOKAL','Lar','',NULL,NULL,'0.00'),(14617,NULL,'drug','DRx0014978','GLYCOLIC ACID PEELING 20 % SOL 8502','Lar','',NULL,NULL,'0.00'),(14618,NULL,'drug','DRx0014979','GLYCOLIC ACID PEELING 35 % SOL 8503','Lar','',NULL,NULL,'0.00'),(14619,NULL,'drug','DRx0014980','GLYCOLIC ACID PEELING 50 % SOL 8504','Lar','',NULL,NULL,'0.00'),(14620,NULL,'drug','DRx0014981','GLYCOLIC ACID PEELING 50 % SOL 8505','Lar','',NULL,NULL,'0.00'),(14621,NULL,'drug','DRx0014982','GRAMASAL','Tab','Graha Farma',NULL,NULL,'0.00'),(14622,NULL,'drug','DRx0014983','GRISEOFULVIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14623,NULL,'drug','DRx0014984','GRISEOFULVIN PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(14624,NULL,'drug','DRx0014985','H2O2 35 %','Lar','',NULL,NULL,'0.00'),(14625,NULL,'drug','DRx0014986','H2O2 50%','Lar','',NULL,NULL,'0.00'),(14626,NULL,'drug','DRx0014987','HAEMOSTOP','Vial','Novell Pharma',NULL,NULL,'0.00'),(14627,NULL,'drug','DRx0014988','HAEMOSTOP','Vial','Novell Pharma',NULL,NULL,'0.00'),(14628,NULL,'drug','DRx0014989','HALOPERIDOL INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14629,NULL,'drug','DRx0014990','HALOPERIDOL INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14630,NULL,'drug','DRx0014991','HALOPERIDOL YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14631,NULL,'drug','DRx0014992','HALOPERIDOL YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14632,NULL,'drug','DRx0014993','HALOPERIDOL INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14633,NULL,'drug','DRx0014994','HALOPERIDOL INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14634,NULL,'drug','DRx0014995','HALOPERIDOL INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14635,NULL,'drug','DRx0014996','HARMIDA','Tab','Hars',NULL,NULL,'0.00'),(14636,NULL,'drug','DRx0014997','HARNAL OCAS','Kaps','Astellas',NULL,NULL,'0.00'),(14637,NULL,'drug','DRx0014998','HD CONC 5 % BIARDB','Lar','',NULL,NULL,'0.00'),(14638,NULL,'drug','DRx0014999','HD CONC ACIDIC','Lar','',NULL,NULL,'0.00'),(14639,NULL,'drug','DRx0015000','HEMOSOL BO 5L (109124)','Lar','',NULL,NULL,'0.00'),(14640,NULL,'drug','DRx0015001','HEMOSOL PART A','Lar','',NULL,NULL,'0.00'),(14641,NULL,'drug','DRx0015002','HESKOPAQ','Tab','Hars',NULL,NULL,'0.00'),(14642,NULL,'drug','DRx0015003','HESKOPAQ','Tab','Hars',NULL,NULL,'0.00'),(14643,NULL,'drug','DRx0015004','HESTAR','Lar Infus','Clar',NULL,NULL,'0.00'),(14644,NULL,'drug','DRx0015005','HESTAR-200','Lar Infus','Clar',NULL,NULL,'0.00'),(14645,NULL,'drug','DRx0015006','HEXAVASK','Tab','Kalbe Farma',NULL,NULL,'0.00'),(14646,NULL,'drug','DRx0015007','HIDROKORTISON HEXAPHARM','Krim','Hexapharm',NULL,NULL,'0.00'),(14647,NULL,'drug','DRx0015008','HIDROKORTISON IKAPHARMINDO','Krim','Ikapharmindo',NULL,NULL,'0.00'),(14648,NULL,'drug','DRx0015009','HIDROKORTISON INFA','Krim','Indo Farma',NULL,NULL,'0.00'),(14649,NULL,'drug','DRx0015010','HISTOACRYL INJ','Amp','',NULL,NULL,'0.00'),(14650,NULL,'drug','DRx0015011','HIVIRAL TAB 150 MG','Tab','Kimia Farma',NULL,NULL,'0.00'),(14651,NULL,'drug','DRx0015012','HP PRO CAPS','Kaps','',NULL,NULL,'0.00'),(14652,NULL,'drug','DRx0015013','HUMAN ALBUMIN BIOTEST','Lar Infus','Kimia Farma',NULL,NULL,'0.00'),(14653,NULL,'drug','DRx0015014','HUMULIN 70/30','Vial','Eli Lilly',NULL,NULL,'0.00'),(14654,NULL,'drug','DRx0015015','HUMULIN 70/30 CARTRIDGE','Cartridge','Eli Lilly',NULL,NULL,'0.00'),(14655,NULL,'drug','DRx0015016','HUMULIN R','Vial','Eli Lilly',NULL,NULL,'0.00'),(14656,NULL,'drug','DRx0015017','HUMULIN R CARTRIDGE','Cartridge','Eli Lilly',NULL,NULL,'0.00'),(14657,NULL,'drug','DRx0015018','HYDROGEN PEROXIDE','Lar','',NULL,NULL,'0.00'),(14658,NULL,'drug','DRx0015019','HYDROXYUREA MEDAC','Kaps','Dipa Pharmalab Intersains Indonesia',NULL,NULL,'0.00'),(14659,NULL,'drug','DRx0015020','HYPERIL','Tab','Ferron',NULL,NULL,'0.00'),(14660,NULL,'drug','DRx0015021','HYPOBHAC','Inj','Phapros, Tbk',NULL,NULL,'0.00'),(14661,NULL,'drug','DRx0015022','HYPOBHAC','Inj','Phapros, Tbk',NULL,NULL,'0.00'),(14662,NULL,'drug','DRx0015023','IBUPROFEN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14663,NULL,'drug','DRx0015024','IBUPROFEN PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(14664,NULL,'drug','DRx0015025','IBUPROFEN YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14665,NULL,'drug','DRx0015026','IBUPROFEN YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14666,NULL,'drug','DRx0015027','IBUPROFEN INDOFARMA','Sir','Indofarma Tbk',NULL,NULL,'0.00'),(14667,NULL,'drug','DRx0015028','IG VENA','Lar','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14668,NULL,'drug','DRx0015029','IKADRYL','Vial','Ikapharmindo',NULL,NULL,'0.00'),(14669,NULL,'drug','DRx0015030','ILIADIN','Spray','Merck',NULL,NULL,'0.00'),(14670,NULL,'drug','DRx0015031','INAMOX','Tab','Info Farma',NULL,NULL,'0.00'),(14671,NULL,'drug','DRx0015032','INCELIN','Tab','Interbat',NULL,NULL,'0.00'),(14672,NULL,'drug','DRx0015033','INCLOVIR','Kaps','Interbat',NULL,NULL,'0.00'),(14673,NULL,'drug','DRx0015034','INH KIMIA FARMA','Tab','Kimia Farma',NULL,NULL,'0.00'),(14674,NULL,'drug','DRx0015035','INHIPUMP','Vial','Pharos',NULL,NULL,'0.00'),(14675,NULL,'drug','DRx0015036','INSULATARD NOVOLET','Vial','Novo Nordisk',NULL,NULL,'0.00'),(14676,NULL,'drug','DRx0015037','INTEGRILIN','Vial','Schering-Plough',NULL,NULL,'0.00'),(14677,NULL,'drug','DRx0015038','IOPAMIRO 370 / 100','Vial','',NULL,NULL,'0.00'),(14678,NULL,'drug','DRx0015039','IOPAMIRO 370 / 50','Vial','',NULL,NULL,'0.00'),(14679,NULL,'drug','DRx0015040','IRBESARTAN LANDSON','Tab','Landson',NULL,NULL,'0.00'),(14680,NULL,'drug','DRx0015041','IRBESARTAN LANDSON','Tab','Landson',NULL,NULL,'0.00'),(14681,NULL,'drug','DRx0015042','IRBESARTAN INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14682,NULL,'drug','DRx0015043','ISOPRINOSINE','Tab','Medifarma/Pediatrica',NULL,NULL,'0.00'),(14683,NULL,'drug','DRx0015044','ISOSORBIDE DINITRATE INFA','Tab Sublingual','Info Farma',NULL,NULL,'0.00'),(14684,NULL,'drug','DRx0015045','ISOSORBIDE DINITRATE YARI','Tab Sublingual','Yarindo Farmatama',NULL,NULL,'0.00'),(14685,NULL,'drug','DRx0015046','ISOSORBIDE DINITRATE INDOFARMA','Tab Sublingual','',NULL,NULL,'0.00'),(14686,NULL,'drug','DRx0015047','KA-EN MG3','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14687,NULL,'drug','DRx0015048','KALETRA CAPS','Kaps','Abbot',NULL,NULL,'0.00'),(14688,NULL,'drug','DRx0015049','KALIUM IODIDA','Bubuk','',NULL,NULL,'0.00'),(14689,NULL,'drug','DRx0015050','KALMICETINE','Salep','Kalbe Farma',NULL,NULL,'0.00'),(14690,NULL,'drug','DRx0015051','KALMICETINE','Salep','Kalbe Farma',NULL,NULL,'0.00'),(14691,NULL,'drug','DRx0015052','KALSIUM KARBONAT','Bubuk','',NULL,NULL,'0.00'),(14692,NULL,'drug','DRx0015053','KALSIUM LAKTAT NUFA','Tab','Nufa',NULL,NULL,'0.00'),(14693,NULL,'drug','DRx0015054','KAPSUL KOSOSNG','Kaps','Aptk',NULL,NULL,'0.00'),(14694,NULL,'drug','DRx0015055','KARBOGLISERIN LOKAL','Tetes','Aptk',NULL,NULL,'0.00'),(14695,NULL,'drug','DRx0015056','KEMICETINE','Salep','Kalbe Farma',NULL,NULL,'0.00'),(14696,NULL,'drug','DRx0015057','KETOPROFEN BERNOFARM','Amp','Bernofarm',NULL,NULL,'0.00'),(14697,NULL,'drug','DRx0015058','KETOPROFEN NOVELL','Amp','Novell Pharma',NULL,NULL,'0.00'),(14698,NULL,'drug','DRx0015059','KETOPROFEN DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14699,NULL,'drug','DRx0015060','KETOPROFEN NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14700,NULL,'drug','DRx0015061','KETOROLAC BERNOFARM','Amp','Bernofarm',NULL,NULL,'0.00'),(14701,NULL,'drug','DRx0015062','KETOROLAC PHAPROS','Amp','Phapros',NULL,NULL,'0.00'),(14702,NULL,'drug','DRx0015063','KETOROLAC TROMETHAMINE','Amp','Novell Pharma',NULL,NULL,'0.00'),(14703,NULL,'drug','DRx0015064','KETOROLAC TROMETHAMINE','Amp','Novell Pharma',NULL,NULL,'0.00'),(14704,NULL,'drug','DRx0015065','KETROBAT','Amp','Interbat',NULL,NULL,'0.00'),(14705,NULL,'drug','DRx0015066','KETROBAT','Amp','Interbat',NULL,NULL,'0.00'),(14706,NULL,'drug','DRx0015067','KIFLUZOL CAPS ARV','Kaps','Kimia Farma',NULL,NULL,'0.00'),(14707,NULL,'drug','DRx0015068','KIFLUZOL CAPS ARV','Kaps','Kimia Farma',NULL,NULL,'0.00'),(14708,NULL,'drug','DRx0015069','CLINDAMYCIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14709,NULL,'drug','DRx0015070','CLINDAMYCIN NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14710,NULL,'drug','DRx0015071','CLINDAMYCIN NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14711,NULL,'drug','DRx0015072','CLONIDINE INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14712,NULL,'drug','DRx0015073','CHLORAMPHENICOL ( GENERIK )','Salep','',NULL,NULL,'0.00'),(14713,NULL,'drug','DRx0015074','CHLORAMPHENICOL ERLA','Salep','Erla',NULL,NULL,'0.00'),(14714,NULL,'drug','DRx0015075','CHLORAMPHENICOL KF','Salep','Kimia Farma',NULL,NULL,'0.00'),(14715,NULL,'drug','DRx0015076','CHLORAMPHENICOL KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14716,NULL,'drug','DRx0015077','CHLORAMPHENICOL RAMA','Tab','Rama',NULL,NULL,'0.00'),(14717,NULL,'drug','DRx0015078','CHLORPROMAZINE LOKAL','Tab','Aptk',NULL,NULL,'0.00'),(14718,NULL,'drug','DRx0015079','CHLORPROMAZINE MERSIFARMA','Tab','Mersifarma TM',NULL,NULL,'0.00'),(14719,NULL,'drug','DRx0015080','CHLORPROMAZINE YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14720,NULL,'drug','DRx0015081','CHLORPROMAZINE (GENERIK)','Vial','Aptk',NULL,NULL,'0.00'),(14721,NULL,'drug','DRx0015082','CHLORPROMAZINE (GENERIK)','Vial','Aptk',NULL,NULL,'0.00'),(14722,NULL,'drug','DRx0015083','KLORSEPT','Tab','',NULL,NULL,'0.00'),(14723,NULL,'drug','DRx0015084','KOATE DVI 540','Amp','Lucas djaja',NULL,NULL,'0.00'),(14724,NULL,'drug','DRx0015085','KOATE DVI 560','Amp','Lucas djaja',NULL,NULL,'0.00'),(14725,NULL,'drug','DRx0015086','KODEIN','Tab','',NULL,NULL,'0.00'),(14726,NULL,'drug','DRx0015087','KODEIN','Tab','',NULL,NULL,'0.00'),(14727,NULL,'drug','DRx0015088','KOLKATRIOL FORTE','Kaps','Phapros, Tbk',NULL,NULL,'0.00'),(14728,NULL,'drug','DRx0015089','KUININ','Lar Infus','Kimia Farma',NULL,NULL,'0.00'),(14729,NULL,'drug','DRx0015090','KUININ','Tab','Kimia Farma',NULL,NULL,'0.00'),(14730,NULL,'drug','DRx0015091','KY JELLY','Gel','',NULL,NULL,'0.00'),(14731,NULL,'drug','DRx0015092','LACTOR','Amp','Phapros',NULL,NULL,'0.00'),(14732,NULL,'drug','DRx0015093','LACTOSUM','Bubuk','',NULL,NULL,'0.00'),(14733,NULL,'drug','DRx0015094','LAMIVUDIN','Tab','',NULL,NULL,'0.00'),(14734,NULL,'drug','DRx0015095','LANMER','Vial','Landson',NULL,NULL,'0.00'),(14735,NULL,'drug','DRx0015096','LANSOPRAZOLE BERNOFARM','Tab','Bernopharm',NULL,NULL,'0.00'),(14736,NULL,'drug','DRx0015097','LANSOPRAZOLE NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14737,NULL,'drug','DRx0015098','LARUTAN LUGOL','Lar','Aptk',NULL,NULL,'0.00'),(14738,NULL,'drug','DRx0015099','LAVERIC','Tab','Hars',NULL,NULL,'0.00'),(14739,NULL,'drug','DRx0015100','LAXANA','Tab','Ifars',NULL,NULL,'0.00'),(14740,NULL,'drug','DRx0015101','LEPIGO','Tab','Eisa',NULL,NULL,'0.00'),(14741,NULL,'drug','DRx0015102','LEUCOGEN','Vial','Kalbe Farma',NULL,NULL,'0.00'),(14742,NULL,'drug','DRx0015103','LEUKOKINE','Vial','Novell Pharma',NULL,NULL,'0.00'),(14743,NULL,'drug','DRx0015104','LEUNASE KYOWA','Lar','Indra Sakti Pharma',NULL,NULL,'0.00'),(14744,NULL,'drug','DRx0015105','LEVEMIR NOVOLET FLEXPEN','Pre-filled','Novo Nordisk',NULL,NULL,'0.00'),(14745,NULL,'drug','DRx0015106','LEVOFLOXACINA DRIP DEXA','Lar Infus','Dexa Medica',NULL,NULL,'0.00'),(14746,NULL,'drug','DRx0015107','LEVOFLOXACIN SOHO','Tab','Soho Industri Pharmasi',NULL,NULL,'0.00'),(14747,NULL,'drug','DRx0015108','LEVOFLOXACIN NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14748,NULL,'drug','DRx0015109','LEVOFLOXACIN INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14749,NULL,'drug','DRx0015110','LEVOTHYROXINE ( GENERIK )','Tab','',NULL,NULL,'0.00'),(14750,NULL,'drug','DRx0015111','LEXA DRIP','Lar Infus','Landson',NULL,NULL,'0.00'),(14751,NULL,'drug','DRx0015112','LEXAGIN','Tab','Molex Ayus',NULL,NULL,'0.00'),(14752,NULL,'drug','DRx0015113','LEXATRANS','Caps','Molex Ayus',NULL,NULL,'0.00'),(14753,NULL,'drug','DRx0015114','LEXATRANS','Capl','Molex Ayus',NULL,NULL,'0.00'),(14754,NULL,'drug','DRx0015115','LEXAVON','Sir','Molex Ayus',NULL,NULL,'0.00'),(14755,NULL,'drug','DRx0015116','LEXIGO','Tab','Molex Ayus',NULL,NULL,'0.00'),(14756,NULL,'drug','DRx0015117','LINOGRA','Tab','Graha Farma',NULL,NULL,'0.00'),(14757,NULL,'drug','DRx0015118','LIQ URINALYSIS LEVEL 2','Tetes','',NULL,NULL,'0.00'),(14758,NULL,'drug','DRx0015119','LIQUID POLIBAR','Susp','EZ-EM',NULL,NULL,'0.00'),(14759,NULL,'drug','DRx0015120','LITORCOM','Tab','Combiphar',NULL,NULL,'0.00'),(14760,NULL,'drug','DRx0015121','LIVAMIN','Lar Infus','',NULL,NULL,'0.00'),(14761,NULL,'drug','DRx0015122','LIVCARBO 1-1','Botol','',NULL,NULL,'0.00'),(14762,NULL,'drug','DRx0015123','LMX 4% TOPICAL','Krim','',NULL,NULL,'0.00'),(14763,NULL,'drug','DRx0015124','LODEM','Tab','Dexa Medica',NULL,NULL,'0.00'),(14764,NULL,'drug','DRx0015125','LORATADINE NULAB','Tab','Nulab Pharmaceutical Indonesia (Divisi Ogb)',NULL,NULL,'0.00'),(14765,NULL,'drug','DRx0015126','LOREX','Tab','',NULL,NULL,'0.00'),(14766,NULL,'drug','DRx0015127','LOREX','Tab','',NULL,NULL,'0.00'),(14767,NULL,'drug','DRx0015128','LOTENAC','Tab','Gracia Pharmindo',NULL,NULL,'0.00'),(14768,NULL,'drug','DRx0015129','LUFTEN','Tab','Pharos',NULL,NULL,'0.00'),(14769,NULL,'drug','DRx0015130','LUFTEN','Tab','',NULL,NULL,'0.00'),(14770,NULL,'drug','DRx0015131','LUNEX','Vial','Mefa',NULL,NULL,'0.00'),(14771,NULL,'drug','DRx0015132','LUNEX','Vial','Mefa',NULL,NULL,'0.00'),(14772,NULL,'drug','DRx0015133','LYSOL','Spray','Lysol',NULL,NULL,'0.00'),(14773,NULL,'drug','DRx0015134','LYSINKU','Sir','Kalbe Farma',NULL,NULL,'0.00'),(14774,NULL,'drug','DRx0015135','MAGNESIUM KLORIDA 250 G MERCK PA','Bubuk','Merck',NULL,NULL,'0.00'),(14775,NULL,'drug','DRx0015136','MATROVIR','Tab','Konimex',NULL,NULL,'0.00'),(14776,NULL,'drug','DRx0015137','MAVELINE','Tab','Novell Pharma',NULL,NULL,'0.00'),(14777,NULL,'drug','DRx0015138','MAVELINE','Tab','Novell Pharma',NULL,NULL,'0.00'),(14778,NULL,'drug','DRx0015139','MAXILAN','Vial','Landson',NULL,NULL,'0.00'),(14779,NULL,'drug','DRx0015140','MEBENDAZOL','Sir','',NULL,NULL,'0.00'),(14780,NULL,'drug','DRx0015141','MEBENDAZOL','Tab','',NULL,NULL,'0.00'),(14781,NULL,'drug','DRx0015142','MECOBALAMIN (GENERIK)','Kaps','',NULL,NULL,'0.00'),(14782,NULL,'drug','DRx0015143','MECOBALAMIN NOVELL','Vial','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14783,NULL,'drug','DRx0015144','MELOKSIKAM KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14784,NULL,'drug','DRx0015145','MELOKSIKAM KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14785,NULL,'drug','DRx0015146','MELOKSIKAM MEDIKON','Tab','Medikon',NULL,NULL,'0.00'),(14786,NULL,'drug','DRx0015147','MELOXICAM BERNOFARM','Tab','Bernofarm',NULL,NULL,'0.00'),(14787,NULL,'drug','DRx0015148','MELOXICAM BERNOFARM','Tab','Bernofarm',NULL,NULL,'0.00'),(14788,NULL,'drug','DRx0015149','MELOXICAM NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14789,NULL,'drug','DRx0015150','MELOXICAM NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14790,NULL,'drug','DRx0015151','MERCAPTO','Tab','Merck',NULL,NULL,'0.00'),(14791,NULL,'drug','DRx0015152','MERCURY SDI','Botol','',NULL,NULL,'0.00'),(14792,NULL,'drug','DRx0015153','MEROPENEM','Vial','Hexpharm',NULL,NULL,'0.00'),(14793,NULL,'drug','DRx0015154','MEROPENEM','Vial','Dexa Medica',NULL,NULL,'0.00'),(14794,NULL,'drug','DRx0015155','MEROPEX','Vial','Bernofarm',NULL,NULL,'0.00'),(14795,NULL,'drug','DRx0015156','META ETCHANT','Tube','',NULL,NULL,'0.00'),(14796,NULL,'drug','DRx0015157','METFER','Inj','Ikapharmindo Putramas',NULL,NULL,'0.00'),(14797,NULL,'drug','DRx0015158','METHANOL ABSOLUT 2,5 L','Lar','',NULL,NULL,'0.00'),(14798,NULL,'drug','DRx0015159','METHYLPREDNISOLONE NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14799,NULL,'drug','DRx0015160','METHYLPREDNISOLONE NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14800,NULL,'drug','DRx0015161','METHYLPREDNISOLONE NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14801,NULL,'drug','DRx0015162','METHYLPREDNISOLONE NULAB','Tab','Nulab Pharmaceutical Indonesia (Divisi Ogb)',NULL,NULL,'0.00'),(14802,NULL,'drug','DRx0015163','METOKLOPRAMID PHAPROS','Tab','Phapros, Tbk',NULL,NULL,'0.00'),(14803,NULL,'drug','DRx0015164','METOLON','Inj','Bernofarm',NULL,NULL,'0.00'),(14804,NULL,'drug','DRx0015165','METRONIDAZOLE HEXAPHARM','Lar Infus','Hexpharm',NULL,NULL,'0.00'),(14805,NULL,'drug','DRx0015166','METRONIDAZOLE KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14806,NULL,'drug','DRx0015167','MGG MERCK','Lar','Merck',NULL,NULL,'0.00'),(14807,NULL,'drug','DRx0015168','MICROSHIELD 2%','Lar','',NULL,NULL,'0.00'),(14808,NULL,'drug','DRx0015169','MICROSHIELD 2%','Lar','',NULL,NULL,'0.00'),(14809,NULL,'drug','DRx0015170','MICROSHIELD 4%','Lar','',NULL,NULL,'0.00'),(14810,NULL,'drug','DRx0015171','MICROSHIELD 4%','Lar','',NULL,NULL,'0.00'),(14811,NULL,'drug','DRx0015172','MICROSHIELD HANDRUB 500 ML','Lar','',NULL,NULL,'0.00'),(14812,NULL,'drug','DRx0015173','MIDODRINE','Tab','Takeda - Nycomed (Pt Apex Pharma Indonesia)',NULL,NULL,'0.00'),(14813,NULL,'drug','DRx0015174','MIKROZID 5 L','Lar','Schulke',NULL,NULL,'0.00'),(14814,NULL,'drug','DRx0015175','MIKROZID AF','Lar','Schulke',NULL,NULL,'0.00'),(14815,NULL,'drug','DRx0015176','MINLAPSI','Tab','Mers',NULL,NULL,'0.00'),(14816,NULL,'drug','DRx0015177','MINOSEP','Lar','Minorock',NULL,NULL,'0.00'),(14817,NULL,'drug','DRx0015178','MINYAK EMERSI OIL','Lar','',NULL,NULL,'0.00'),(14818,NULL,'drug','DRx0015179','MIOSTAT INJ','Vial','',NULL,NULL,'0.00'),(14819,NULL,'drug','DRx0015180','MKASIN','Inj','Kalbe Farma',NULL,NULL,'0.00'),(14820,NULL,'drug','DRx0015181','MOLDANO BAYER','Gips','Bayer Schering Pharma',NULL,NULL,'0.00'),(14821,NULL,'drug','DRx0015182','MORNING MOISTURIZER','Salep','',NULL,NULL,'0.00'),(14822,NULL,'drug','DRx0015183','MUCOGARD','Tab','Soho',NULL,NULL,'0.00'),(14823,NULL,'drug','DRx0015184','MULTIVITAMIN UNTUK INFUS','Lar Infus','',NULL,NULL,'0.00'),(14824,NULL,'drug','DRx0015185','N2O KAP 15 KG','Tabung','',NULL,NULL,'0.00'),(14825,NULL,'drug','DRx0015186','N2O KAP 25 KG','Tabung','',NULL,NULL,'0.00'),(14826,NULL,'drug','DRx0015187','N5 OTSUKA','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14827,NULL,'drug','DRx0015188','NACL CAPS 500 MG\n','Kaps','',NULL,NULL,'0.00'),(14828,NULL,'drug','DRx0015189','NANOCIS KIT','Vial','',NULL,NULL,'0.00'),(14829,NULL,'drug','DRx0015190','','','',NULL,NULL,'0.00'),(14830,NULL,'drug','DRx0015191','','','',NULL,NULL,'0.00'),(14831,NULL,'drug','DRx0015192','NATRIUM BIKARBONAT','Bubuk','',NULL,NULL,'0.00'),(14832,NULL,'drug','DRx0015193','NATRIUM DIKLOFENAK KF','Tab','',NULL,NULL,'0.00'),(14833,NULL,'drug','DRx0015194','NATRIUM DIKLOFENAK PHAPROS','Tab','',NULL,NULL,'0.00'),(14834,NULL,'drug','DRx0015195','NATRIUM DIKLOFENAK NOVELL','Tab','',NULL,NULL,'0.00'),(14835,NULL,'drug','DRx0015196','NATRIUM IODIDA','Bubuk','',NULL,NULL,'0.00'),(14836,NULL,'drug','DRx0015197','NATRIUM KLORIDA ( NACL ) 0,9% ECOSOL','Lar Infus','Buminusantara Bestari Perkasa/B Braun',NULL,NULL,'0.00'),(14837,NULL,'drug','DRx0015198','NATRIUM KLORIDA ( NACL ) 0,9% EURO MED','Lar Infus','Euro Med',NULL,NULL,'0.00'),(14838,NULL,'drug','DRx0015199','NATRIUM KLORIDA 0.9% OGB','Lar Infus','Dexa Medica',NULL,NULL,'0.00'),(14839,NULL,'drug','DRx0015200','NATRIUM KLORIDA 0.9% SANBE','Lar Infus','Sanbe',NULL,NULL,'0.00'),(14840,NULL,'drug','DRx0015201','NATRIUM KLORIDA 3% OTSU','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14841,NULL,'drug','DRx0015202','NEGACEF','Vial','Doxa/Julphar',NULL,NULL,'0.00'),(14842,NULL,'drug','DRx0015203','','','',NULL,NULL,'0.00'),(14843,NULL,'drug','DRx0015204','','','',NULL,NULL,'0.00'),(14844,NULL,'drug','DRx0015205','NEOTIGASON TAB','Kaps','',NULL,NULL,'0.00'),(14845,NULL,'drug','DRx0015206','NEUROLIN TAB','Tab','',NULL,NULL,'0.00'),(14846,NULL,'drug','DRx0015207','NEUROLITE (HMPAO) KIT','Vial','',NULL,NULL,'0.00'),(14847,NULL,'drug','DRx0015208','NEUROMED','Tab','Promedrahardjo Industri Farmasi',NULL,NULL,'0.00'),(14848,NULL,'drug','DRx0015209','NEUTRA G SPREYAR','Lar','',NULL,NULL,'0.00'),(14849,NULL,'drug','DRx0015210','NEUTRALIZIER PEELING REFILL 8520','Lar','',NULL,NULL,'0.00'),(14850,NULL,'drug','DRx0015211','NEVILAST','Tab','',NULL,NULL,'0.00'),(14851,NULL,'drug','DRx0015212','NEVIRAL','Kaps','Kimia Farma',NULL,NULL,'0.00'),(14852,NULL,'drug','DRx0015213','NIBI KIT','Vial','',NULL,NULL,'0.00'),(14853,NULL,'drug','DRx0015214','NIFEDIPIN DEXA','Tab','Dexa medica',NULL,NULL,'0.00'),(14854,NULL,'drug','DRx0015215','NISTATIN PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(14855,NULL,'drug','DRx0015216','NITROGLISERIN','tab','',NULL,NULL,'0.00'),(14856,NULL,'drug','DRx0015217','NITROGLISERIN','inj','',NULL,NULL,'0.00'),(14857,NULL,'drug','DRx0015218','NK EEG PASTE ELEFIX','Salep','',NULL,NULL,'0.00'),(14858,NULL,'drug','DRx0015219','NO KAP 2 M3','?','',NULL,NULL,'0.00'),(14859,NULL,'drug','DRx0015220','NOBOR','Tab','Guardian Pharmatama',NULL,NULL,'0.00'),(14860,NULL,'drug','DRx0015221','NONAFACT','Vial','Satya Abadi Pharma',NULL,NULL,'0.00'),(14861,NULL,'drug','DRx0015222','NOORONAL','Tab','Hars',NULL,NULL,'0.00'),(14862,NULL,'drug','DRx0015223','NOPANTIN','Kaps','Combiphar',NULL,NULL,'0.00'),(14863,NULL,'drug','DRx0015224','NORESTIL','Tab','Guardian Pharmatama',NULL,NULL,'0.00'),(14864,NULL,'drug','DRx0015225','NORIT','Tab','',NULL,NULL,'0.00'),(14865,NULL,'drug','DRx0015226','NORIZEC','Tab','Darya - Varia/Dr Falk',NULL,NULL,'0.00'),(14866,NULL,'drug','DRx0015227','NOTROTAM','Amp','Kimia Farma',NULL,NULL,'0.00'),(14867,NULL,'drug','DRx0015228','NOTROTAM DRIP','Lar Infus','',NULL,NULL,'0.00'),(14868,NULL,'drug','DRx0015229','NOTROTAM INJECTION','Amp','Landson',NULL,NULL,'0.00'),(14869,NULL,'drug','DRx0015230','NOVAMET','Amp','Clar',NULL,NULL,'0.00'),(14870,NULL,'drug','DRx0015231','Novellmycin','Vial','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14871,NULL,'drug','DRx0015232','Novellmycin','Vial','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14872,NULL,'drug','DRx0015233','Noveron','Vial','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14873,NULL,'drug','DRx0015234','NOVOSEVEN','Vial','Novo Nordisk',NULL,NULL,'0.00'),(14874,NULL,'drug','DRx0015235','NUPREP','Salep','',NULL,NULL,'0.00'),(14875,NULL,'drug','DRx0015236','NUTRIENT SOLUTION','Lar Infus','',NULL,NULL,'0.00'),(14876,NULL,'drug','DRx0015237','NUTRIENT SOLUTION','Lar Infus','',NULL,NULL,'0.00'),(14877,NULL,'drug','DRx0015238','NUZIP','Tab','Guardian Pharmatama',NULL,NULL,'0.00'),(14878,NULL,'drug','DRx0015239','NYNDIA','Drops','',NULL,NULL,'0.00'),(14879,NULL,'drug','DRx0015240','NYTEX','Caps','',NULL,NULL,'0.00'),(14880,NULL,'drug','DRx0015241','OBH COMBI BATUK BERDAHAK','Sir','Combiphar',NULL,NULL,'0.00'),(14881,NULL,'drug','DRx0015242','OBH IKAP','Sir','Ikapharmindo',NULL,NULL,'0.00'),(14882,NULL,'drug','DRx0015243','OBH IKAP','Sir','Ikapharmindo',NULL,NULL,'0.00'),(14883,NULL,'drug','DRx0015244','OBH MUTI','Sir','Muti',NULL,NULL,'0.00'),(14884,NULL,'drug','DRx0015245','OBH NUFA','Sir','Nufarindo',NULL,NULL,'0.00'),(14885,NULL,'drug','DRx0015246','OCCULON HV VISCOELASTIC','Lar','',NULL,NULL,'0.00'),(14886,NULL,'drug','DRx0015247','OCO 15 ML','Lar (Kit)','',NULL,NULL,'0.00'),(14887,NULL,'drug','DRx0015248','OFLOXACIN INDOFARMA','Tab Salut Selaput','Indofarma Tbk',NULL,NULL,'0.00'),(14888,NULL,'drug','DRx0015249','OFLOXACIN INDOFARMA','Tab Salut Selaput','Indofarma Tbk',NULL,NULL,'0.00'),(14889,NULL,'drug','DRx0015250','OG6 PAPANICOLUS 500 ML','Lar','',NULL,NULL,'0.00'),(14890,NULL,'drug','DRx0015251','OIL IMERSI MERCK','Lar','Merck',NULL,NULL,'0.00'),(14891,NULL,'drug','DRx0015252','OKSIGEN KAP 140 M3 (VGL/PGS)','Lar','',NULL,NULL,'0.00'),(14892,NULL,'drug','DRx0015253','OKSIGEN MEDIS KAP 1 M3','Lar','',NULL,NULL,'0.00'),(14893,NULL,'drug','DRx0015254','OKSIGEN MEDIS KAP 2 M3','Lar','',NULL,NULL,'0.00'),(14894,NULL,'drug','DRx0015255','OKSIGEN MEDIS KAP 6 M3','Lar','',NULL,NULL,'0.00'),(14895,NULL,'drug','DRx0015256','OKSIGEN MEDIS KAP 7 M3','Lar','',NULL,NULL,'0.00'),(14896,NULL,'drug','DRx0015257','OLANDOZ','Tab','Sandoz Indonesia',NULL,NULL,'0.00'),(14897,NULL,'drug','DRx0015258','OLANDOZ','Tab','Sandoz Indonesia',NULL,NULL,'0.00'),(14898,NULL,'drug','DRx0015259','OLEUM COCOS BARCO OIL','Lar','',NULL,NULL,'0.00'),(14899,NULL,'drug','DRx0015260','OMEDRINAT','Tab','Muti',NULL,NULL,'0.00'),(14900,NULL,'drug','DRx0015261','OMEFULVIN','Tab','Muti',NULL,NULL,'0.00'),(14901,NULL,'drug','DRx0015262','OMEGLUPHAGE','Tab','Muti',NULL,NULL,'0.00'),(14902,NULL,'drug','DRx0015263','OMENIZOL','Tab','Muti',NULL,NULL,'0.00'),(14903,NULL,'drug','DRx0015264','OMEPRAZOLE DEXA','Inj','Dexa Medica',NULL,NULL,'0.00'),(14904,NULL,'drug','DRx0015265','','','',NULL,NULL,'0.00'),(14905,NULL,'drug','DRx0015266','OMETILSON','Tab','Muti',NULL,NULL,'0.00'),(14906,NULL,'drug','DRx0015267','OMEVOMID','Sir','Muti',NULL,NULL,'0.00'),(14907,NULL,'drug','DRx0015268','OMNIPAQUE','Lar','',NULL,NULL,'0.00'),(14908,NULL,'drug','DRx0015269','OMNIPAQUE','Lar','',NULL,NULL,'0.00'),(14909,NULL,'drug','DRx0015270','OMNISCAN','Vial','',NULL,NULL,'0.00'),(14910,NULL,'drug','DRx0015271','ONDANSETRON NOVELL','Tab','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14911,NULL,'drug','DRx0015272','ONDANSETRON SOHO','Tab','Soho Industri Pharmasi',NULL,NULL,'0.00'),(14912,NULL,'drug','DRx0015273','ONDANSETRON SOHO','Amp','Soho Industri Pharmasi',NULL,NULL,'0.00'),(14913,NULL,'drug','DRx0015274','OPSITE SURGICAL SPRAY','Lar Spray','',NULL,NULL,'0.00'),(14914,NULL,'drug','DRx0015275','OPTIRAY','Lar Infus','',NULL,NULL,'0.00'),(14915,NULL,'drug','DRx0015276','ORALIT INDOFARMA','Bubuk','Indofarma Tbk',NULL,NULL,'0.00'),(14916,NULL,'drug','DRx0015277','ORSADERM','Krim','Ifars',NULL,NULL,'0.00'),(14917,NULL,'drug','DRx0015278','OSELTAMIVIR','Tab','',NULL,NULL,'0.00'),(14918,NULL,'drug','DRx0015279','OSMIN','Tab','Hexapharm',NULL,NULL,'0.00'),(14919,NULL,'drug','DRx0015280','OTSU-D5 1/4 NS','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14920,NULL,'drug','DRx0015281','OTSU-MANITOL','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14921,NULL,'drug','DRx0015282','OTSU-MGSO4','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14922,NULL,'drug','DRx0015283','OTSU-MGSO4','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14923,NULL,'drug','DRx0015284','OTSUTRAN 70','Lar Infus','Otsuka',NULL,NULL,'0.00'),(14924,NULL,'drug','DRx0015285','Oxaliplatin Actavis','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14925,NULL,'drug','DRx0015286','Oxaliplatin Actavis','Inj','Actavis Indonesia (Oncology)',NULL,NULL,'0.00'),(14926,NULL,'drug','DRx0015287','Oxaliplatin Medac','Vial','Dipa Pharmalab Intersains Indonesia',NULL,NULL,'0.00'),(14927,NULL,'drug','DRx0015288','Oxaliplatin Medac','Vial','Dipa Pharmalab Intersains Indonesia',NULL,NULL,'0.00'),(14928,NULL,'drug','DRx0015289','OXYTETRACYCLINE KF','Krim','',NULL,NULL,'0.00'),(14929,NULL,'drug','DRx0015290','PANA SPRAY','Spray','',NULL,NULL,'0.00'),(14930,NULL,'drug','DRx0015291','PANADOL COLD & FLU TAB','Tab','',NULL,NULL,'0.00'),(14931,NULL,'drug','DRx0015292','PANTOCAIN 0,5% CENDO','Amp','Cendo',NULL,NULL,'0.00'),(14932,NULL,'drug','DRx0015293','PECTOCIL','Tab','Ethica',NULL,NULL,'0.00'),(14933,NULL,'drug','DRx0015294','PEHACAIN PHAPROS','Amp','Phapros',NULL,NULL,'0.00'),(14934,NULL,'drug','DRx0015295','PEPTAMEN','Bubuk','Nestle',NULL,NULL,'0.00'),(14935,NULL,'drug','DRx0015296','PEWANGI LEMON','Lar','',NULL,NULL,'0.00'),(14936,NULL,'drug','DRx0015297','PEWARNA RAPID 1500 ML','Lar','',NULL,NULL,'0.00'),(14937,NULL,'drug','DRx0015298','PHANEM INJ','Vial','Novell Pharma',NULL,NULL,'0.00'),(14938,NULL,'drug','DRx0015299','PHENOBARBITAL KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14939,NULL,'drug','DRx0015300','PHENYLBUTAZON ERLA','Kapl Salut Selaput','Erla',NULL,NULL,'0.00'),(14940,NULL,'drug','DRx0015301','PHENYLBUTAZON HARS','Kapl Salut Selaput','Hars',NULL,NULL,'0.00'),(14941,NULL,'drug','DRx0015302','PHENYLBUTAZON MOLA','Kapl Salut Selaput','Mola',NULL,NULL,'0.00'),(14942,NULL,'drug','DRx0015303','PHENOXYMETHYL PENICILLIN','tab','',NULL,NULL,'0.00'),(14943,NULL,'drug','DRx0015304','PHYTOMENADIONE PHAPROS','Tab','Phapros, Tbk',NULL,NULL,'0.00'),(14944,NULL,'drug','DRx0015305','PINOREC','Amp','Novell Pharma',NULL,NULL,'0.00'),(14945,NULL,'drug','DRx0015306','PIONIX','Tab','Kalbe Farma, Tbk',NULL,NULL,'0.00'),(14946,NULL,'drug','DRx0015307','PIONIX','Tab','Kalbe Farma, Tbk',NULL,NULL,'0.00'),(14947,NULL,'drug','DRx0015308','PIRACETAM NOVELL','Lar Infus','Novell Pharmaceutical Laboratories',NULL,NULL,'0.00'),(14948,NULL,'drug','DRx0015309','PIRANTEL PAMOAT','Tab','',NULL,NULL,'0.00'),(14949,NULL,'drug','DRx0015310','PIRANTEL PAMOAT YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14950,NULL,'drug','DRx0015311','PIRAZINAMIDA INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14951,NULL,'drug','DRx0015312','PIRAZINAMIDA YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14952,NULL,'drug','DRx0015313','PIRIMETAMIN + SULFADOKSIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(14953,NULL,'drug','DRx0015314','PIRIMETAMIN + SULFADOKSIN KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14954,NULL,'drug','DRx0015315','PIROXICAM INDOFARMA','Tab','Indofarma',NULL,NULL,'0.00'),(14955,NULL,'drug','DRx0015316','PIROXICAM INDOFARMA','Tab','Indofarma',NULL,NULL,'0.00'),(14956,NULL,'drug','DRx0015317','PIROXICAM GRAF','Tab','Graha Farma',NULL,NULL,'0.00'),(14957,NULL,'drug','DRx0015318','PIROXICAM GRAF','Tab','Graha Farma',NULL,NULL,'0.00'),(14958,NULL,'drug','DRx0015319','PIROXICAM NOVELL','Tab','Novell Pharma',NULL,NULL,'0.00'),(14959,NULL,'drug','DRx0015320','PIROXICAM YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14960,NULL,'drug','DRx0015321','PLAQUENIL','Tab','',NULL,NULL,'0.00'),(14961,NULL,'drug','DRx0015322','PLASMODIN','Kapl','Ifars',NULL,NULL,'0.00'),(14962,NULL,'drug','DRx0015323','PLATIDINE','Tab','',NULL,NULL,'0.00'),(14963,NULL,'drug','DRx0015324','POLIKRESULEN','Tab','Aptk',NULL,NULL,'0.00'),(14964,NULL,'drug','DRx0015325','POLYMYXIN B SULFATE','Tetes','',NULL,NULL,'0.00'),(14965,NULL,'drug','DRx0015326','POLYMYXIN B SULFATE','Tetes','',NULL,NULL,'0.00'),(14966,NULL,'drug','DRx0015327','POLYNEL','Tetes','Cendo Pharmaceutical Industries',NULL,NULL,'0.00'),(14967,NULL,'drug','DRx0015328','PPD 2 TU','Vial','',NULL,NULL,'0.00'),(14968,NULL,'drug','DRx0015329','PRADAXA','Tab','Boehringer Ingelheim',NULL,NULL,'0.00'),(14969,NULL,'drug','DRx0015330','PRAZOSIN HIDROKLORIDA','Tab','',NULL,NULL,'0.00'),(14970,NULL,'drug','DRx0015331','PRE PEEL CLEANSING PADS','Krim','',NULL,NULL,'0.00'),(14971,NULL,'drug','DRx0015332','PRECEDEX','Vial','Transfarma Medica Indah/Hospira',NULL,NULL,'0.00'),(14972,NULL,'drug','DRx0015333','PREDNISON NUFARINDO','Tab','Nufarindo',NULL,NULL,'0.00'),(14973,NULL,'drug','DRx0015334','PREDNISON SAKA','Tab','Saka Farma',NULL,NULL,'0.00'),(14974,NULL,'drug','DRx0015335','PREDNISON YARI','Tab','Yarindo Farmatama',NULL,NULL,'0.00'),(14975,NULL,'drug','DRx0015336','PRESEPT','Tab','Johnson&Johnson',NULL,NULL,'0.00'),(14976,NULL,'drug','DRx0015337','PRIMAQUIN','Tab','Aptk',NULL,NULL,'0.00'),(14977,NULL,'drug','DRx0015338','PRIMASEPT M','Lar','',NULL,NULL,'0.00'),(14978,NULL,'drug','DRx0015339','PRIMET','Tab','',NULL,NULL,'0.00'),(14979,NULL,'drug','DRx0015340','PRIMOCEF','Vial','Doxa /Julphar',NULL,NULL,'0.00'),(14980,NULL,'drug','DRx0015341','PRISMA M 100 PRE - DILUTION (103657)','Lar','',NULL,NULL,'0.00'),(14981,NULL,'drug','DRx0015342','PRO JOINT','Kaps','Plas',NULL,NULL,'0.00'),(14982,NULL,'drug','DRx0015343','PRO JOINT','Kaps','Plas',NULL,NULL,'0.00'),(14983,NULL,'drug','DRx0015344','PROCARBAZINE','Kaps','',NULL,NULL,'0.00'),(14984,NULL,'drug','DRx0015345','PROINFARK','Inj','Phapros',NULL,NULL,'0.00'),(14985,NULL,'drug','DRx0015346','PROMUXOL','Tetes','Gracia Pharmindo',NULL,NULL,'0.00'),(14986,NULL,'drug','DRx0015347','PROPILTIOURASIL INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14987,NULL,'drug','DRx0015348','PROPILTIOURASIL DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14988,NULL,'drug','DRx0015349','PROPRANOLOL DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14989,NULL,'drug','DRx0015350','PROSTIN VR','Lar Infus','',NULL,NULL,'0.00'),(14990,NULL,'drug','DRx0015351','PROSULF','Vial','',NULL,NULL,'0.00'),(14991,NULL,'drug','DRx0015352','PYRAMER','Tab','Combiphar',NULL,NULL,'0.00'),(14992,NULL,'drug','DRx0015353','PYRATIBI','Tab','Ifars',NULL,NULL,'0.00'),(14993,NULL,'drug','DRx0015354','PYRAZINAMIDA DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14994,NULL,'drug','DRx0015355','PYRAZINAMIDA KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(14995,NULL,'drug','DRx0015356','PYRAZINAMIDA INDOFARMA','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(14996,NULL,'drug','DRx0015357','PYREX','Lar Infus','Novell Pharma',NULL,NULL,'0.00'),(14997,NULL,'drug','DRx0015358','RANITIDINE BERNOPHARM','Tab','Bernoparm',NULL,NULL,'0.00'),(14998,NULL,'drug','DRx0015359','RANITIDINE DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(14999,NULL,'drug','DRx0015360','RAPIME','Vial','Fahrenheit',NULL,NULL,'0.00'),(15000,NULL,'drug','DRx0015361','RARIFAM','Tab','Kimia Farma',NULL,NULL,'0.00'),(15001,NULL,'drug','DRx0015362','RATAN','Amp','Ethica',NULL,NULL,'0.00'),(15002,NULL,'drug','DRx0015363','RATRIM FORTE','Tab','Kimia Farma',NULL,NULL,'0.00'),(15003,NULL,'drug','DRx0015364','REDOXON','Vial','Bayer Schering Pharma',NULL,NULL,'0.00'),(15004,NULL,'drug','DRx0015365','REMETIN','Amp','Clar',NULL,NULL,'0.00'),(15005,NULL,'drug','DRx0015366','REMITAL','Tab','Pharos',NULL,NULL,'0.00'),(15006,NULL,'drug','DRx0015367','REMITAL','Tab','Pharos',NULL,NULL,'0.00'),(15007,NULL,'drug','DRx0015368','RENALIN 100','Lar','',NULL,NULL,'0.00'),(15008,NULL,'drug','DRx0015369','RENAPAR','Tab Salut Selaput','Fahrenheit',NULL,NULL,'0.00'),(15009,NULL,'drug','DRx0015370','RENOSAN','Lar Infus','',NULL,NULL,'0.00'),(15010,NULL,'drug','DRx0015371','RESERPINA','tab','',NULL,NULL,'0.00'),(15011,NULL,'drug','DRx0015372','REVIRAL','Tab','Kimia Farma',NULL,NULL,'0.00'),(15012,NULL,'drug','DRx0015373','REXTA','Vial','Kalbe Farma',NULL,NULL,'0.00'),(15013,NULL,'drug','DRx0015374','RHINOS NEO','Tetes','Dexa Medica',NULL,NULL,'0.00'),(15014,NULL,'drug','DRx0015375','RHINOS NEO','Tetes','Dexa Medica',NULL,NULL,'0.00'),(15015,NULL,'drug','DRx0015376','RIFAMPICIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(15016,NULL,'drug','DRx0015377','RIFAMPICIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(15017,NULL,'drug','DRx0015378','RIFAMPICIN KF','Kapl','Kimia Farma',NULL,NULL,'0.00'),(15018,NULL,'drug','DRx0015379','RIFAMPICIN LANDSON','Tab','Landson',NULL,NULL,'0.00'),(15019,NULL,'drug','DRx0015380','RIFASTAR','Kaps','Indofarma',NULL,NULL,'0.00'),(15020,NULL,'drug','DRx0015381','RIFASTAR','Kaps','Indofarma',NULL,NULL,'0.00'),(15021,NULL,'drug','DRx0015382','RIKLONA','Tab','',NULL,NULL,'0.00'),(15022,NULL,'drug','DRx0015383','RIMACTAZID PAED','Tab Kunyah','Sandoz',NULL,NULL,'0.00'),(15023,NULL,'drug','DRx0015384','RIMCURE PAED','Tab Kunyah','Sandoz',NULL,NULL,'0.00'),(15024,NULL,'drug','DRx0015385','RIMCURE PAED','Tab Kunyah','Sandoz',NULL,NULL,'0.00'),(15025,NULL,'drug','DRx0015386','RINGER DEXTROSE OTSUKA','Lar Infus','Otsuka',NULL,NULL,'0.00'),(15026,NULL,'drug','DRx0015387','RINGER ASETAT','Lar Infus','Kalbe Farma',NULL,NULL,'0.00'),(15027,NULL,'drug','DRx0015388','RINGER LACTAT OTSU (RL)','Lar Infus','Otsuka',NULL,NULL,'0.00'),(15028,NULL,'drug','DRx0015389','RINGER LAKTAT ECOSOL','Lar Infus','Buminusantara Bestari Perkasa/B Braun',NULL,NULL,'0.00'),(15029,NULL,'drug','DRx0015390','RINGER LAKTAT SANBE','Lar Infus','Sanbe',NULL,NULL,'0.00'),(15030,NULL,'drug','DRx0015391','RINGER LAKTAT WIDA','Lar Infus','Widatra Bhakti',NULL,NULL,'0.00'),(15031,NULL,'drug','DRx0015392','RITALIN/RITALIN SR','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(15032,NULL,'drug','DRx0015393','RITALIN/RITALIN SR','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(15033,NULL,'drug','DRx0015394','RITALIN/RITALIN SR','Kaps','Novartis Indonesia',NULL,NULL,'0.00'),(15034,NULL,'drug','DRx0015395','RITALIN/RITALIN SR','Tab Lepas Lambat','Novartis Indonesia',NULL,NULL,'0.00'),(15035,NULL,'drug','DRx0015396','ROFACIN','Tab','Corssa',NULL,NULL,'0.00'),(15036,NULL,'drug','DRx0015397','SAKAPARA','Sir','Saka Farma',NULL,NULL,'0.00'),(15037,NULL,'drug','DRx0015398','SAKAPARA','Tab','Saka Farma',NULL,NULL,'0.00'),(15038,NULL,'drug','DRx0015399','SAKAPHENYL','Tab','',NULL,NULL,'0.00'),(15039,NULL,'drug','DRx0015400','SALBUTAMOL INDOFARMA','Tab','Phapros',NULL,NULL,'0.00'),(15040,NULL,'drug','DRx0015401','SALBUTAMOL INDOFARMA','Tab','Phapros',NULL,NULL,'0.00'),(15041,NULL,'drug','DRx0015402','SALBUTAMOL PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(15042,NULL,'drug','DRx0015403','SALBUTAMOL PHAPROS','Tab','Phapros',NULL,NULL,'0.00'),(15043,NULL,'drug','DRx0015404','SALISYL SALEP LOKAL','Salep','Aptk',NULL,NULL,'0.00'),(15044,NULL,'drug','DRx0015405','SANITEX','Lar','Sanitex',NULL,NULL,'0.00'),(15045,NULL,'drug','DRx0015406','SANSULIN N','Catridges','Sanbe Farma',NULL,NULL,'0.00'),(15046,NULL,'drug','DRx0015407','SANSULIN R','Catridges','Sanbe Farma',NULL,NULL,'0.00'),(15047,NULL,'drug','DRx0015408','SCANCEPTA SOL','Lar','Tempo Scan Pacific',NULL,NULL,'0.00'),(15048,NULL,'drug','DRx0015409','SCANDONEST 2 % SEPTODONT - FRANCE','Cartridge','',NULL,NULL,'0.00'),(15049,NULL,'drug','DRx0015410','SCANDONEST 2 % SPECIAL 1,8 ML','Cartridge','',NULL,NULL,'0.00'),(15050,NULL,'drug','DRx0015411','SCANDONEST 3 %','Cartridge','',NULL,NULL,'0.00'),(15051,NULL,'drug','DRx0015412','SCANDONEST 3 % NON ADRENALIN SEPTODONT - FRANCE','Cartridge','',NULL,NULL,'0.00'),(15052,NULL,'drug','DRx0015413','SEDACUM','Amp','Dexa Medica',NULL,NULL,'0.00'),(15053,NULL,'drug','DRx0015414','SEDACUM','Amp','Dexa Medica',NULL,NULL,'0.00'),(15054,NULL,'drug','DRx0015415','SERADOL','Tab','Hars',NULL,NULL,'0.00'),(15055,NULL,'drug','DRx0015416','SERUM ANTI BISA ULAR POL 5','Vial','Biofarma',NULL,NULL,'0.00'),(15056,NULL,'drug','DRx0015417','SERUM ANTI TETANUS (KUDA)','Vial','Biofarma',NULL,NULL,'0.00'),(15057,NULL,'drug','DRx0015418','SERUM ANTI TETANUS (KUDA)','Vial','Biofarma',NULL,NULL,'0.00'),(15058,NULL,'drug','DRx0015419','CETIRIZINE INDOFARMA','Drops','Indofarma Tbk',NULL,NULL,'0.00'),(15059,NULL,'drug','DRx0015420','SEZOLAM','Amp','Clar',NULL,NULL,'0.00'),(15060,NULL,'drug','DRx0015421','SEZOLAM','Amp','Clar',NULL,NULL,'0.00'),(15061,NULL,'drug','DRx0015422','SIBITAL','Tab','Mersifarma TM',NULL,NULL,'0.00'),(15062,NULL,'drug','DRx0015423','SILAX','Amp','Ethica',NULL,NULL,'0.00'),(15063,NULL,'drug','DRx0015424','SILICONE OIL 1300 10 ML','Vial','',NULL,NULL,'0.00'),(15064,NULL,'drug','DRx0015425','SINDAXEL','Inj','',NULL,NULL,'0.00'),(15065,NULL,'drug','DRx0015426','SINOCORD ORAL','Krim','Sanbe Farma',NULL,NULL,'0.00'),(15066,NULL,'drug','DRx0015427','SODALIME DURASORB','Lar','CMVI',NULL,NULL,'0.00'),(15067,NULL,'drug','DRx0015428','SOJOURN','Lar','Fahrenheit',NULL,NULL,'0.00'),(15068,NULL,'drug','DRx0015429','SPIRAMISIN INFA','Tab','Info Farma',NULL,NULL,'0.00'),(15069,NULL,'drug','DRx0015430','SPIRITUS BAKAR LOKAL','Lar','',NULL,NULL,'0.00'),(15070,NULL,'drug','DRx0015431','SPIRONOLACTON DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(15071,NULL,'drug','DRx0015432','SPIRONOLACTON DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(15072,NULL,'drug','DRx0015433','SPORAX','Kaps','Inmark Pharmaceutical',NULL,NULL,'0.00'),(15073,NULL,'drug','DRx0015434','SS FUNGIRIN SALEP','Salep','Saka Farma',NULL,NULL,'0.00'),(15074,NULL,'drug','DRx0015435','STABIMED B BRAUN','Lar','B Braun',NULL,NULL,'0.00'),(15075,NULL,'drug','DRx0015436','STARQUIN','Lar Infus','Dexa Medica',NULL,NULL,'0.00'),(15076,NULL,'drug','DRx0015437','STAVEX 40','Tab','Aurobindo Pharma',NULL,NULL,'0.00'),(15077,NULL,'drug','DRx0015438','STAVIRAL ','Tab','',NULL,NULL,'0.00'),(15078,NULL,'drug','DRx0015439','STERALD 30 GALON','Lar','',NULL,NULL,'0.00'),(15079,NULL,'drug','DRx0015440','STERANIOS 2%','Lar','',NULL,NULL,'0.00'),(15080,NULL,'drug','DRx0015441','STOMAHESIVE PASTA','Salep','',NULL,NULL,'0.00'),(15081,NULL,'drug','DRx0015442','STOMICA','Tab','Pharos',NULL,NULL,'0.00'),(15082,NULL,'drug','DRx0015443','STP AP-75','Lar','',NULL,NULL,'0.00'),(15083,NULL,'drug','DRx0015444','SUDAN BLACK MERCK','Lar','',NULL,NULL,'0.00'),(15084,NULL,'drug','DRx0015445','SUFENTA','Amp','Janssen-Cilag',NULL,NULL,'0.00'),(15085,NULL,'drug','DRx0015446','SULBACYLLIN','Amp','',NULL,NULL,'0.00'),(15086,NULL,'drug','DRx0015447','SUN BLOCK ERHA','Krim','',NULL,NULL,'0.00'),(15087,NULL,'drug','DRx0015448','SUNSCREEN GEL 30 G','Gel','',NULL,NULL,'0.00'),(15088,NULL,'drug','DRx0015449','SYRUP TIMI MAJEMUK','Sir','Aptk',NULL,NULL,'0.00'),(15089,NULL,'drug','DRx0015450','TAKELIN','Tab','Mersifarma TM',NULL,NULL,'0.00'),(15090,NULL,'drug','DRx0015451','TAKELIN','Tab','Mersifarma TM',NULL,NULL,'0.00'),(15091,NULL,'drug','DRx0015452','TALK HAICHEN 1KG','Bubuk','',NULL,NULL,'0.00'),(15092,NULL,'drug','DRx0015453','TAMIFLU','Kaps','',NULL,NULL,'0.00'),(15093,NULL,'drug','DRx0015454','TARCEVA','Tab','Roche Indonesia',NULL,NULL,'0.00'),(15094,NULL,'drug','DRx0015455','TARCEVA','Tab','Roche Indonesia',NULL,NULL,'0.00'),(15095,NULL,'drug','DRx0015456','TATIONIL','Amp','',NULL,NULL,'0.00'),(15096,NULL,'drug','DRx0015457','TCA 10 % SOL ERHA','Lar','',NULL,NULL,'0.00'),(15097,NULL,'drug','DRx0015458','TCA 15 % SOL ERHA','Lar','',NULL,NULL,'0.00'),(15098,NULL,'drug','DRx0015459','TEN 20','Salep','',NULL,NULL,'0.00'),(15099,NULL,'drug','DRx0015460','TENSINOP','Tab','Sanbe Farma',NULL,NULL,'0.00'),(15100,NULL,'drug','DRx0015461','TENSINOP','Tab','Sanbe Farma',NULL,NULL,'0.00'),(15101,NULL,'drug','DRx0015462','TERAZOCIN','Tab','Dexa Medica',NULL,NULL,'0.00'),(15102,NULL,'drug','DRx0015463','TERAZOCIN','Tab','Dexa Medica',NULL,NULL,'0.00'),(15103,NULL,'drug','DRx0015464','TERRALIN','Lar','',NULL,NULL,'0.00'),(15104,NULL,'drug','DRx0015465','Tetra Hes','Lar','Clar',NULL,NULL,'0.00'),(15105,NULL,'drug','DRx0015466','TETRACYLINE PHAPROS','Kaps','Phapros',NULL,NULL,'0.00'),(15106,NULL,'drug','DRx0015467','TETRACYLINE KF','Kaps','Kimia Farma',NULL,NULL,'0.00'),(15107,NULL,'drug','DRx0015468','THROMBOLES TAB','Tab','',NULL,NULL,'0.00'),(15108,NULL,'drug','DRx0015469','TIARYT','Inj','Fahrenheit',NULL,NULL,'0.00'),(15109,NULL,'drug','DRx0015470','TIDOL','Amp','Clar',NULL,NULL,'0.00'),(15110,NULL,'drug','DRx0015471','TIDOL','Amp','Clar',NULL,NULL,'0.00'),(15111,NULL,'drug','DRx0015472','TIMACT','Vial','Prat',NULL,NULL,'0.00'),(15112,NULL,'drug','DRx0015473','TIZACOM','Kapl','Combiphar',NULL,NULL,'0.00'),(15113,NULL,'drug','DRx0015474','CENDO TOBROSON','Tetes','Cendo Pharmaceutical Industries',NULL,NULL,'0.00'),(15114,NULL,'drug','DRx0015475','CENDO TONOR','Tetes','Cendo Pharmaceutical Industries',NULL,NULL,'0.00'),(15115,NULL,'drug','DRx0015476','CENDO TONOR','Tetes','Cendo Pharmaceutical Industries',NULL,NULL,'0.00'),(15116,NULL,'drug','DRx0015477','TRAMADOL BERNOFARM','Kaps','Bernofarm',NULL,NULL,'0.00'),(15117,NULL,'drug','DRx0015478','TRAMADOL DEXA','Tab','Dexa Medica',NULL,NULL,'0.00'),(15118,NULL,'drug','DRx0015479','TRANEC','Kapl','Gracia Pharmindo',NULL,NULL,'0.00'),(15119,NULL,'drug','DRx0015480','TRANSAMIN PPIN','Amp','Ppin',NULL,NULL,'0.00'),(15120,NULL,'drug','DRx0015481','TRASIDAN','Amp','Hars',NULL,NULL,'0.00'),(15121,NULL,'drug','DRx0015482','TRAZEP','Tube Rectal','Fahrenheit',NULL,NULL,'0.00'),(15122,NULL,'drug','DRx0015483','TRIDEX 27B','Lar Infus','Sanbe',NULL,NULL,'0.00'),(15123,NULL,'drug','DRx0015484','TRIHEKSIFENIDIL INFA','Tab','Info Farma',NULL,NULL,'0.00'),(15124,NULL,'drug','DRx0015485','TRIHEKSIFENIDIL INDO','Tab','Indofarma Tbk',NULL,NULL,'0.00'),(15125,NULL,'drug','DRx0015486','TRILAC','Vial','Novell Pharma',NULL,NULL,'0.00'),(15126,NULL,'drug','DRx0015487','TRIXON','Vial','Phapros',NULL,NULL,'0.00'),(15127,NULL,'drug','DRx0015488','TROVILON','Tab','Ifars',NULL,NULL,'0.00'),(15128,NULL,'drug','DRx0015489','TUPEPE CREAM','Krim','Medikon',NULL,NULL,'0.00'),(15129,NULL,'drug','DRx0015490','TYMOL M 8167','Lar','',NULL,NULL,'0.00'),(15130,NULL,'drug','DRx0015491','ULTRACET','Tab','Janssen-Cilag',NULL,NULL,'0.00'),(15131,NULL,'drug','DRx0015492','ULTRACLEAN','Lar','',NULL,NULL,'0.00'),(15132,NULL,'drug','DRx0015493','UNISTIN','Vial','Novell Pharma',NULL,NULL,'0.00'),(15133,NULL,'drug','DRx0015494','UNISTIN','Vial','Novell Pharma',NULL,NULL,'0.00'),(15134,NULL,'drug','DRx0015495','UROCARB','Lar','',NULL,NULL,'0.00'),(15135,NULL,'drug','DRx0015496','URSOLIC','Caps','Guardian Pharmatama',NULL,NULL,'0.00'),(15136,NULL,'drug','DRx0015497','USG JELLY ACOUSTIC PARKER (USA)','Gel','',NULL,NULL,'0.00'),(15137,NULL,'drug','DRx0015498','VACLO','Tab','Dexa Medica',NULL,NULL,'0.00'),(15138,NULL,'drug','DRx0015499','VAKSIN INFLUENZA FLUARIX','Amp','Aventis',NULL,NULL,'0.00'),(15139,NULL,'drug','DRx0015500','Vaksin Tetanus Difteri (Td)','Vial','Sagi Capri',NULL,NULL,'0.00'),(15140,NULL,'drug','DRx0015501','VAKSIN MMR','Vial','',NULL,NULL,'0.00'),(15141,NULL,'drug','DRx0015502','VAKSIN PPD 2 TU','Vial','',NULL,NULL,'0.00'),(15142,NULL,'drug','DRx0015503','VALANSIM 10','Tab','Landson',NULL,NULL,'0.00'),(15143,NULL,'drug','DRx0015504','VALEPTIK','Syr','Otto Pharmaceutical Industries',NULL,NULL,'0.00'),(15144,NULL,'drug','DRx0015505','VARILRIX','Vial','Glaxosmithkline',NULL,NULL,'0.00'),(15145,NULL,'drug','DRx0015506','VASELIN ALBUM 1 KG','Krim','',NULL,NULL,'0.00'),(15146,NULL,'drug','DRx0015507','VASELIN FLAVUM 1 KG','Krim','',NULL,NULL,'0.00'),(15147,NULL,'drug','DRx0015508','VASELIN HAND & BODY LOTION','Krim','',NULL,NULL,'0.00'),(15148,NULL,'drug','DRx0015509','VERPES','Tab','Bernofarm',NULL,NULL,'0.00'),(15149,NULL,'drug','DRx0015510','VERPES','Tab','Bernofarm',NULL,NULL,'0.00'),(15150,NULL,'drug','DRx0015511','VERUSA','Tab','Hars',NULL,NULL,'0.00'),(15151,NULL,'drug','DRx0015512','VICCILLIN-SX','Vial','Meiji',NULL,NULL,'0.00'),(15152,NULL,'drug','DRx0015513','VINBLASTINE RTUS','Vial','Combiphar',NULL,NULL,'0.00'),(15153,NULL,'drug','DRx0015514','VINCRISTINE RTUS','Vial','Combiphar',NULL,NULL,'0.00'),(15154,NULL,'drug','DRx0015515','VINCRISTINE RTUS','Vial','Combiphar',NULL,NULL,'0.00'),(15155,NULL,'drug','DRx0015516','VIOREX LIQUID SOAP','Lar','Shering-Plough Sentipharm',NULL,NULL,'0.00'),(15156,NULL,'drug','DRx0015517','VIOREX NO RINSE','Lar','',NULL,NULL,'0.00'),(15157,NULL,'drug','DRx0015518','VIREAD','Tab','',NULL,NULL,'0.00'),(15158,NULL,'drug','DRx0015519','VISION BLUE','Vial','',NULL,NULL,'0.00'),(15159,NULL,'drug','DRx0015520','VISIPAQUE','Lar','',NULL,NULL,'0.00'),(15160,NULL,'drug','DRx0015521','VISIPAQUE','Lar','',NULL,NULL,'0.00'),(15161,NULL,'drug','DRx0015522','VITAMIN B COMPLEX MUTI','Tab','Muti',NULL,NULL,'0.00'),(15162,NULL,'drug','DRx0015523','VITAMIN B1 KF','Tab','Kimia Farma',NULL,NULL,'0.00'),(15163,NULL,'drug','DRx0015524','VITKA INFANT','Inj','Phapros',NULL,NULL,'0.00'),(15164,NULL,'drug','DRx0015525','VITRAX II AMO','Amp','',NULL,NULL,'0.00'),(15165,NULL,'drug','DRx0015526','VOLTAREN EMULGEL','Gel','Novartis Indonesia',NULL,NULL,'0.00'),(15166,NULL,'drug','DRx0015527','VOMETRAZ','Amp','Dexa Medica',NULL,NULL,'0.00'),(15167,NULL,'drug','DRx0015528','VOMETRAZ','Amp','Dexa Medica',NULL,NULL,'0.00'),(15168,NULL,'drug','DRx0015529','VOSEA SIRUP','Sirup','Graha Farma',NULL,NULL,'0.00'),(15169,NULL,'drug','DRx0015530','','','',NULL,NULL,'0.00'),(15170,NULL,'drug','DRx0015531','WASH BENSIN','Lar','',NULL,NULL,'0.00'),(15171,NULL,'drug','DRx0015532','WATER FOR INJECTION 1000 ML OTSUKA','Lar','Otsuka',NULL,NULL,'0.00'),(15172,NULL,'drug','DRx0015533','WATER FOR INJECTION 1000 ML TWIST CUP WIDATRA','Lar','Widatra',NULL,NULL,'0.00'),(15173,NULL,'drug','DRx0015534','WRIGHT BUBUK MERCK','Bubuk','Merck',NULL,NULL,'0.00'),(15174,NULL,'drug','DRx0015535','XIMEX OPTIPLEX','Tetes','Konimex',NULL,NULL,'0.00'),(15175,NULL,'drug','DRx0015536','XYLOL','Lar','',NULL,NULL,'0.00'),(15176,NULL,'drug','DRx0015537','ZECAXON 0,5 MG','Tablet','First Medipharma',NULL,NULL,'0.00'),(15177,NULL,'drug','DRx0015538','ZECAXON 0,75 MG','Tablet','First Medipharma',NULL,NULL,'0.00'),(15178,NULL,'drug','DRx0015539','ZEGAVIT','Kapl','Kalbe Farma',NULL,NULL,'0.00'),(15179,NULL,'drug','DRx0015540','ZIDOLAM','Tab','Hetero',NULL,NULL,'0.00'),(15180,NULL,'drug','DRx0015541','ZIDIAR','Tab','Tempo Scan Pacific',NULL,NULL,'0.00'),(15181,NULL,'drug','DRx0015542','ZINCI OXYDUM (ZNO)','Bubuk','',NULL,NULL,'0.00'),(15182,NULL,'drug','DRx0015543','ZINC','Tab','Indofarma',NULL,NULL,'0.00'),(15183,NULL,'drug','DRx0015544','ZINKID','Tab','',NULL,NULL,'0.00');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ref_jobs`
--

LOCK TABLES `ref_jobs` WRITE;
/*!40000 ALTER TABLE `ref_jobs` DISABLE KEYS */;
INSERT INTO `ref_jobs` (`id`, `name`, `active`) VALUES (001,'Pegawai Negeri Sipil','yes'),(002,'TNI/ABRI/POLRI','yes'),(003,'Petani','yes'),(004,'Pedagang','yes'),(005,'Ibu Rumah Tangga','yes'),(006,'Pelajar','yes'),(008,'Pensiunan','yes'),(011,'Lain-lain','yes'),(012,'Karyawan','yes'),(013,'BUMN','yes'),(014,'Mahasiswa','yes'),(017,'Guru Swasta / Honor','yes'),(018,'Tidak/Belum Bekerja','yes');
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
INSERT INTO `ref_menu` (`id`, `parent_id`, `level`, `name`, `url`, `ordering`) VALUES (1,0,1,'RME Pasien','#',2),(2,1,2,'Input Data Pemeriksaan Pasien','admission/indoor',2),(5,0,0,'Laporan','#',12),(7,5,1,'Kunjungan','#',5),(8,0,0,'Manajemen Data','#',14),(10,72,2,'Jenis Pasien','admdata/payment',9),(11,8,1,'Profil','admdata/profile',12),(13,78,2,'Tindakan','admdata/treatment',10),(15,80,2,'Operator','admdata/user',15),(16,80,2,'Group','admdata/group',16),(17,8,1,'Menu','admdata/menu',28),(53,5,1,'Pasien','#',6),(57,53,2,'Berdasar Pekerjaan','report/patient_job',2),(58,53,2,'Berdasar Jenis Kelamin','report/patient_sex',3),(66,7,2,'Berdasar Jenis Pasien','report/visit_by_payment_type',3),(72,8,1,'Data Dasar','#',20),(74,72,2,'Pekerjaan','admdata/job',2),(78,8,1,'Data Medis','#',23),(80,8,1,'Pengguna','#',26),(86,0,0,'Keluar','login/logout',26),(87,0,1,'Dashboard','home/dashboard',1),(92,5,1,'10 Besar Penyakit','report/sepuluh_besar',8),(98,103,2,'Distribusi Farmasi','pharmacy/report_drug_in_out',2),(105,102,2,'Obat Masuk Keluar','apotek/report_drug_in_out',4),(107,102,2,'Obat Keluar','report/drug_out',1),(108,8,1,'Tools','#',29),(109,108,2,'Backup & Restore Database','tools/backup_database',1),(111,108,2,'Kosongkan Database','tools/empty_database',15),(112,0,1,'Petunjuk Manual','webroot/Manual_Book_cCare_Vers_1.1.pdf',27),(114,117,2,'Obat','admdata/drug',1),(117,8,1,'Data Obat','#',24),(118,117,2,'Supplier','admdata/supplier',12),(125,8,1,'Pasien','admdata/patient',18),(126,92,2,'10 Besar Penyakit Anak-Dewasa','report/sepuluh_besar_anak_dewasa',2),(127,92,2,'10 Besar Penyakit','report/sepuluh_besar',1),(138,78,3,'Kelompok Penyakit','admdata/group_icd',12),(139,103,3,'Posisi Stock','pharmacy/report_stock',3),(142,103,3,'Obat Kadaluwarsa','pharmacy/report_stock_expired',4),(143,1,2,'Surat Keterangan Sehat','admission/sks',5),(145,78,3,'Data ICD','admdata/icd',13),(146,103,3,'LPLPO','pharmacy/lplpo',5),(153,5,1,'Kunjungan Pasien','report/kunjungan_pasien_unik',2),(158,103,2,'Laporan 10 Besar Obat Keluar','pharmacy/sepuluh_besar_obat',6),(162,7,3,'Laporan Kunjungan Pasien Berdasarkan Usia','report/kunjungan_golusia',9),(166,7,3,'Lap. Kunjungan Berdasarkan JENKEL ','report/kunjungan_sex_patients',10),(168,0,1,'Video c-Care','webroot/ccare.avi',28),(169,5,2,'Sensus Pasien','report/visit_sensus',9),(170,0,1,'Billing','#',3),(171,170,1,'Antrian Billing','kasir/queue',1),(172,170,2,'Rekap Harian','kasir/harian',2),(173,170,2,'Rekap Tagihan Pasien','kasir/rekap_pasien',3),(174,5,1,'Kirim Laporan E-Claim','#',13),(175,174,3,'Lap. Rujukan','report/lap_rujukan',3),(176,174,3,'Laporan Jamkesmas','report/lap_jamkesmas',2),(177,174,3,'Laporan Morbiditas','report/lap_morbiditas',1),(179,5,2,'Laporan Morbiditas','report/print_morbiditas',10),(180,5,2,'Laporan Jamkesmas','report/print_jamkesmas',11),(181,5,2,'Laporan Rujukan','report/print_rujukan',12);
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
INSERT INTO `ref_profiles` (`code`, `spesialisasi`, `name`, `no_str`, `awal_berlaku_str`, `akhir_berlaku_str`, `no_sip`, `awal_berlaku_sip`, `akhir_berlaku_sip`, `address`, `phone`, `email`, `photo`, `screensaver`, `screensaver_delay`, `report_header_1`, `id_register`) VALUES (1,'Dokter Penyakit Dalam','dr. Paijo Dimejo Prawiro, Sp.OG, P.hd','34.1.1.100.1.06.054357','2012-01-01','2017-01-01','987654321 001','2017-01-04','0000-00-00','Samirono Baru 58, CCT, Depok, Sleman, DIY','081328xxxxx',NULL,'c_logo.gif','logosisfo.png',600000,'PRAKTEK DOKTER',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools_backup_database`
--

LOCK TABLES `tools_backup_database` WRITE;
/*!40000 ALTER TABLE `tools_backup_database` DISABLE KEYS */;
INSERT INTO `tools_backup_database` (`id`, `name`, `date`, `filename`, `filesize`) VALUES (3,'19 Maret 2013','2013-03-18 23:16:45','backup_2013-03-19_06-16-43.sql','1094144');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools_empty_database`
--

LOCK TABLES `tools_empty_database` WRITE;
/*!40000 ALTER TABLE `tools_empty_database` DISABLE KEYS */;
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
INSERT INTO `users` (`id`, `group_id`, `clinic_id`, `username`, `pwd`, `name`, `email`, `last_login`, `login_count`) VALUES (1,1,NULL,'admin','ac43724f16e9241d990427ab7c8f4228','dr. Harryvieri Sun, Sp.oG, P.hd','sunandarharry@gmail.com','2013-03-19 03:48:16',53);
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
  `drug` varchar(200),
  `code` varchar(10),
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
  `drug` varchar(200),
  `code` varchar(10),
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
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

-- Dump completed on 2013-03-18 23:30:10