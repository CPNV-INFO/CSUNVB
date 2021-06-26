DROP DATABASE IF EXISTS `csunvb_csu`;
CREATE DATABASE  IF NOT EXISTS `csunvb_csu` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `csunvb_csu`;
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: csunvb_csu
-- ------------------------------------------------------
-- Server version	5.5.5-10.5.8-MariaDB

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
-- Table structure for table `apitokens`
--

DROP TABLE IF EXISTS `apitokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apitokens` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `token` varchar(60) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `FK_apitokens_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tokens utilisés par l''API';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bases`
--

DROP TABLE IF EXISTS `bases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL DEFAULT 'new',
  `drug_id` int(11) NOT NULL,
  `base_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`,`drug_id`),
  KEY `fk_batches_drugs_idx` (`drug_id`),
  KEY `fk_batches_bases1_idx` (`base_id`),
  CONSTRAINT `fk_batches_bases1` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_batches_drugs` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drugsheet_use_batch`
--

DROP TABLE IF EXISTS `drugsheet_use_batch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugsheet_use_batch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drugsheet_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_use` (`drugsheet_id`,`batch_id`),
  KEY `fk_drugsheet_use_batch_drugsheets1_idx` (`drugsheet_id`),
  KEY `fk_drugsheet_use_batch_batches1_idx` (`batch_id`),
  CONSTRAINT `fk_drugsheet_use_batch_batches1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `fk_drugsheet_use_batch_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drugsheet_use_nova`
--

DROP TABLE IF EXISTS `drugsheet_use_nova`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugsheet_use_nova` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drugsheet_id` int(11) NOT NULL,
  `nova_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_use` (`drugsheet_id`,`nova_id`),
  KEY `fk_drugsheet_use_nova_drugsheets1_idx` (`drugsheet_id`),
  KEY `fk_drugsheet_use_nova_novas1_idx` (`nova_id`),
  CONSTRAINT `fk_drugsheet_use_nova_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `fk_drugsheet_use_nova_novas1` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drugsheets`
--

DROP TABLE IF EXISTS `drugsheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugsheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `base_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `drugSHEETUNIQ` (`week`,`base_id`),
  KEY `fk_drugsheets_bases1_idx` (`base_id`),
  KEY `fk_drugsheets_status1` (`status_id`),
  CONSTRAINT `fk_drugsheets_bases1` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_drugsheets_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drugsignatures`
--

DROP TABLE IF EXISTS `drugsignatures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugsignatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `day` datetime NOT NULL,
  `drugsheet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `base` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `day_drugsheet_id` (`day`,`drugsheet_id`),
  KEY `fk_drugsignatures_drugsheets1_idx` (`drugsheet_id`),
  KEY `fk_drugsignatures_users1_idx` (`user_id`),
  KEY `fk_drugsignatures_bases1` (`base`),
  CONSTRAINT `fk_drugsignatures_bases1` FOREIGN KEY (`base`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_drugsignatures_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `fk_drugsignatures_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `report_type` enum('SHIFT','TODO','DRUG') NOT NULL,
  `report_id` int(11) NOT NULL COMMENT 'A foreign key without constraint, because it will point to different tables according to the report type',
  `info` varchar(200) DEFAULT NULL COMMENT 'decribe what is done',
  PRIMARY KEY (`id`),
  KEY `fkmadeby_idx` (`user_id`),
  CONSTRAINT `fkmadeby` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains all log entries for all reports';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novachecks`
--

DROP TABLE IF EXISTS `novachecks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novachecks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) DEFAULT NULL,
  `drug_id` int(11) NOT NULL,
  `nova_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `drugsheet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_novachecks` (`date`,`drug_id`,`nova_id`,`drugsheet_id`) USING BTREE,
  KEY `fk_novachecks_drugs1_idx` (`drug_id`),
  KEY `fk_novachecks_novas1_idx` (`nova_id`),
  KEY `fk_novachecks_users1_idx` (`user_id`),
  KEY `fk_novachecks_drugsheets1_idx` (`drugsheet_id`),
  CONSTRAINT `fk_novachecks_drugs1` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`),
  CONSTRAINT `fk_novachecks_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `fk_novachecks_novas1` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_novachecks_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novas`
--

DROP TABLE IF EXISTS `novas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `novaunavailabilites`
--

DROP TABLE IF EXISTS `novaunavailabilites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `novaunavailabilites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(45) DEFAULT NULL,
  `date` date NOT NULL,
  `day` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nova_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_novaunavailabilites` (`date`,`day`,`nova_id`) USING BTREE,
  KEY `fk_novaunavailabilites_user_id` (`user_id`),
  KEY `fk_novaunavailabilites_nova_id` (`nova_id`),
  CONSTRAINT `fk_novaunavailabilites_nova_id` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_novaunavailabilites_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pharmachecks`
--

DROP TABLE IF EXISTS `pharmachecks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pharmachecks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `drugsheet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_pharmachecks` (`date`,`batch_id`,`drugsheet_id`) USING BTREE,
  KEY `fk_pharmachecks_batches1_idx` (`batch_id`),
  KEY `fk_pharmachecks_users1_idx` (`user_id`),
  KEY `fk_pharmachecks_drugsheets1_idx` (`drugsheet_id`),
  CONSTRAINT `fk_pharmachecks_batches1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `fk_pharmachecks_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `fk_pharmachecks_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `restocks`
--

DROP TABLE IF EXISTS `restocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `nova_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `drugsheet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_restocks` (`date`,`batch_id`,`nova_id`) USING BTREE,
  KEY `fk_restocks_batches1_idx` (`batch_id`),
  KEY `fk_restocks_novas1_idx` (`nova_id`),
  KEY `fk_restocks_users1_idx` (`user_id`),
  KEY `fk_restocks_drugsheet` (`drugsheet_id`),
  CONSTRAINT `fk_restocks_batches1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `fk_restocks_drugsheet` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `fk_restocks_novas1` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_restocks_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftactions`
--

DROP TABLE IF EXISTS `shiftactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) NOT NULL,
  `shiftsection_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_shift_lines_shift_sections1_idx` (`shiftsection_id`),
  CONSTRAINT `fk_shift_lines_shift_sections1` FOREIGN KEY (`shiftsection_id`) REFERENCES `shiftsections` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftchecks`
--

DROP TABLE IF EXISTS `shiftchecks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftchecks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` tinyint(1) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `shiftsheet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shiftaction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_shiftChecks_shiftSheets1_idx` (`shiftsheet_id`),
  KEY `fk_shiftChecks_users1_idx` (`user_id`),
  KEY `fk_shiftChecks_shiftActions1_idx` (`shiftaction_id`),
  CONSTRAINT `fk_shiftChecks_shiftActions1` FOREIGN KEY (`shiftaction_id`) REFERENCES `shiftactions` (`id`),
  CONSTRAINT `fk_shiftChecks_shiftSheets1` FOREIGN KEY (`shiftsheet_id`) REFERENCES `shiftsheets` (`id`),
  CONSTRAINT `fk_shiftChecks_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftcomments`
--

DROP TABLE IF EXISTS `shiftcomments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `carryOn` tinyint(1) NOT NULL DEFAULT 0,
  `endOfCarryOn` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `shiftsheet_id` int(11) NOT NULL,
  `shiftaction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comments_users1_idx` (`user_id`),
  KEY `fk_comments_shiftSheets1_idx` (`shiftsheet_id`),
  KEY `fk_comments_shiftActions1_idx` (`shiftaction_id`),
  CONSTRAINT `fk_comments_shiftActions1` FOREIGN KEY (`shiftaction_id`) REFERENCES `shiftactions` (`id`),
  CONSTRAINT `fk_comments_shiftSheets1` FOREIGN KEY (`shiftsheet_id`) REFERENCES `shiftsheets` (`id`),
  CONSTRAINT `fk_comments_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftmodel_has_shiftaction`
--

DROP TABLE IF EXISTS `shiftmodel_has_shiftaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftmodel_has_shiftaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shiftaction_id` int(11) NOT NULL,
  `shiftmodel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shiftmodelscol_has_shiftactions_UNIQUE` (`id`),
  UNIQUE KEY `uniqueactionpermodel` (`shiftaction_id`,`shiftmodel_id`),
  KEY `fk_shiftactions_has_shiftmodels_shiftmodels1_idx` (`shiftmodel_id`),
  KEY `fk_shiftactions_has_shiftmodels_shiftactions1_idx` (`shiftaction_id`),
  CONSTRAINT `fk_shiftactions_has_shiftmodels_shiftactions1` FOREIGN KEY (`shiftaction_id`) REFERENCES `shiftactions` (`id`),
  CONSTRAINT `fk_shiftactions_has_shiftmodels_shiftmodels1` FOREIGN KEY (`shiftmodel_id`) REFERENCES `shiftmodels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftmodels`
--

DROP TABLE IF EXISTS `shiftmodels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftmodels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `nbTeamD` int(11) NOT NULL DEFAULT 1,
  `nbTeamN` int(11) NOT NULL DEFAULT 1,
  `suggested` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idshiftmodels_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftsections`
--

DROP TABLE IF EXISTS `shiftsections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftsections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftsheets`
--

DROP TABLE IF EXISTS `shiftsheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftsheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `shiftmodel_id` int(11) NOT NULL,
  `base_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `closeBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq` (`base_id`,`date`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_shiftsheets_bases1_idx` (`base_id`),
  KEY `fk_shiftSheets_status1_idx` (`status_id`),
  KEY `fk_shiftSheets_users5_idx` (`closeBy`),
  KEY `fk_shiftsheets_shiftmodels1_idx` (`shiftmodel_id`),
  CONSTRAINT `fk_shiftSheets_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_shiftSheets_users5` FOREIGN KEY (`closeBy`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftsheets_bases1` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_shiftsheets_shiftmodels1` FOREIGN KEY (`shiftmodel_id`) REFERENCES `shiftmodels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shiftteams`
--

DROP TABLE IF EXISTS `shiftteams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shiftteams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shiftsheet_id` int(11) NOT NULL,
  `boss_id` int(11) DEFAULT NULL,
  `teammate_id` int(11) DEFAULT NULL,
  `nova_id` int(11) DEFAULT NULL,
  `day` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_shiftteams_shiftsheet` (`shiftsheet_id`),
  KEY `fk_shiftteams_boss` (`boss_id`),
  KEY `fk_shiftteams_teammate` (`teammate_id`),
  KEY `fk_shiftteams_nova` (`nova_id`),
  CONSTRAINT `fk_shiftteams_boss` FOREIGN KEY (`boss_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftteams_nova` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_shiftteams_shiftsheet` FOREIGN KEY (`shiftsheet_id`) REFERENCES `shiftsheets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_shiftteams_teammate` FOREIGN KEY (`teammate_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `specialdrugout`
--

DROP TABLE IF EXISTS `specialdrugout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialdrugout` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `execution_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `batch_id` int(11) NOT NULL,
  `drugsheet_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `notified_admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_batch_id-batches` (`batch_id`),
  KEY `FK_drugsheet_id-drugsheet` (`drugsheet_id`),
  KEY `FK_notified_admin_id-users` (`notified_admin_id`),
  KEY `UK_user_id-users` (`user_id`),
  CONSTRAINT `FK_batch_id-batches` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `FK_drugsheet_id-drugsheet` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `FK_notified_admin_id-users` FOREIGN KEY (`notified_admin_id`) REFERENCES `users` (`id`),
  CONSTRAINT `UK_user_id-users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(25) NOT NULL,
  `displayname` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `todos`
--

DROP TABLE IF EXISTS `todos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `todothing_id` int(11) NOT NULL,
  `todosheet_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  `done_at` datetime DEFAULT NULL,
  `day_of_week` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_todoitems_todotexts1_idx` (`todothing_id`),
  KEY `fk_todoitems_todosheets1_idx` (`todosheet_id`),
  KEY `fk_todoitems_users1_idx` (`user_id`),
  CONSTRAINT `fk_todoitems_todosheets1` FOREIGN KEY (`todosheet_id`) REFERENCES `todosheets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_todoitems_todotexts1` FOREIGN KEY (`todothing_id`) REFERENCES `todothings` (`id`),
  CONSTRAINT `fk_todoitems_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `todosheets`
--

DROP TABLE IF EXISTS `todosheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todosheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `week` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `base_id` int(11) NOT NULL,
  `closeBy` int(11) DEFAULT NULL,
  `template_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `model_name_UNIQUE` (`template_name`),
  KEY `fk_todosheets_bases1_idx` (`base_id`),
  KEY `fk_todosheets_status1` (`status_id`),
  KEY `fk_todosheets_user1` (`closeBy`),
  CONSTRAINT `fk_todosheets_bases1` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_todosheets_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_todosheets_user1` FOREIGN KEY (`closeBy`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `todothings`
--

DROP TABLE IF EXISTS `todothings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todothings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `daything` tinyint(4) NOT NULL DEFAULT 1,
  `type` enum('novas') DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `text_UNIQUE` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) NOT NULL,
  `validity` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`value`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_table1_users1_idx` (`user_id`),
  CONSTRAINT `fk_table1_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `initials` varchar(45) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL,
  `firstconnect` tinyint(4) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `mobileNumber` varchar(20) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `initials_UNIQUE` (`initials`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workplannings`
--

DROP TABLE IF EXISTS `workplannings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workplannings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worktime_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_worktime_id` (`worktime_id`),
  KEY `fk_user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_worktime_id` FOREIGN KEY (`worktime_id`) REFERENCES `worktimes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `worktimes`
--

DROP TABLE IF EXISTS `worktimes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worktimes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `day` tinyint(1) DEFAULT NULL,
  `base_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_base_id` (`base_id`),
  CONSTRAINT `fk_base_id` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-26  9:57:26
