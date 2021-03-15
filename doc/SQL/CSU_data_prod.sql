-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: csunvb_csu
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Dumping data for table `batches`
--

LOCK TABLES `batches` WRITE;
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
INSERT INTO `batches` VALUES (1,'123123','used',1,2),(2,'654654','new',1,2),(3,'545654','new',1,2),(4,'231654','inuse',1,2),(5,'879645','inuse',1,3),(6,'231288','used',2,3),(7,'231355','used',2,3),(8,'213546','inuse',2,4),(9,'465465','new',2,4),(10,'222222','new',2,2),(11,'555555','used',3,2),(13,'213215','inuse',3,2),(14,'789555','new',3,2);
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `novachecks`
--

LOCK TABLES `novachecks` WRITE;
/*!40000 ALTER TABLE `novachecks` DISABLE KEYS */;
INSERT INTO `novachecks` VALUES
(673,'2020-10-26 00:00:00',6,6,1,3,101,23),
(674,'2020-10-26 00:00:00',6,6,1,5,102,23),
(675,'2020-10-26 00:00:00',6,6,2,3,102,23),
(676,'2020-10-26 00:00:00',6,6,2,5,103,23),
(677,'2020-10-26 00:00:00',6,6,3,3,104,23),
(678,'2020-10-26 00:00:00',5,5,3,5,115,23),
(679,'2020-10-27 00:00:00',6,6,1,3,116,23),
(680,'2020-10-27 00:00:00',6,6,1,5,117,23),
(681,'2020-10-27 00:00:00',6,6,2,3,117,23),
(682,'2020-10-27 00:00:00',6,5,2,5,116,23),
(683,'2020-10-27 00:00:00',6,6,3,3,115,23),
(684,'2020-10-27 00:00:00',6,6,3,5,114,23),
(685,'2020-10-28 00:00:00',4,NULL,1,3,113,23),
(686,'2020-10-28 00:00:00',6,NULL,1,5,114,23),
(687,'2020-10-28 00:00:00',6,NULL,2,3,113,23),
(688,'2020-10-28 00:00:00',6,NULL,2,5,112,23),
(689,'2020-10-28 00:00:00',6,NULL,3,3,114,23),
(690,'2020-10-28 00:00:00',6,NULL,3,5,112,23);
/*!40000 ALTER TABLE `novachecks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pharmachecks`
--

LOCK TABLES `pharmachecks` WRITE;
/*!40000 ALTER TABLE `pharmachecks` DISABLE KEYS */;
INSERT INTO `pharmachecks` VALUES
(5150,'2020-10-26 00:00:00',12,11,4,114,23),
(5151,'2020-10-26 00:00:00',8,8,8,116,23),
(5152,'2020-10-26 00:00:00',6,4,13,113,23),
(5153,'2020-10-27 00:00:00',11,11,4,117,23),
(5154,'2020-10-27 00:00:00',8,7,8,116,23),
(5155,'2020-10-27 00:00:00',4,4,13,112,23),
(5156,'2020-10-28 00:00:00',11,NULL,4,117,23),
(5157,'2020-10-28 00:00:00',7,NULL,8,102,23),
(5158,'2020-10-28 00:00:00',4,NULL,13,104,23);
/*!40000 ALTER TABLE `pharmachecks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `restocks`
--

LOCK TABLES `restocks` WRITE;
/*!40000 ALTER TABLE `restocks` DISABLE KEYS */;
INSERT INTO `restocks` VALUES
(5,'2020-10-26 00:00:00',1,4,5,2),
(6,'2020-10-26 00:00:00',2,13,3,3);
/*!40000 ALTER TABLE `restocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsheet_use_batch`
--

LOCK TABLES `drugsheet_use_batch` WRITE;
/*!40000 ALTER TABLE `drugsheet_use_batch` DISABLE KEYS */;
INSERT INTO `drugsheet_use_batch` VALUES (109,23,4),(110,23,8),(111,23,13);
/*!40000 ALTER TABLE `drugsheet_use_batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsheet_use_nova`
--

LOCK TABLES `drugsheet_use_nova` WRITE;
/*!40000 ALTER TABLE `drugsheet_use_nova` DISABLE KEYS */;
INSERT INTO `drugsheet_use_nova` VALUES (51,23,3),(52,23,5);
/*!40000 ALTER TABLE `drugsheet_use_nova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsheets`
--

LOCK TABLES `drugsheets` WRITE;
/*!40000 ALTER TABLE `drugsheets` DISABLE KEYS */;
INSERT INTO `drugsheets` VALUES (23,2101,2,2);
/*!40000 ALTER TABLE `drugsheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsignatures`
--

LOCK TABLES `drugsignatures` WRITE;
/*!40000 ALTER TABLE `drugsignatures` DISABLE KEYS */;
/*!40000 ALTER TABLE `drugsignatures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `todos`
--

LOCK TABLES `todos` WRITE;
/*!40000 ALTER TABLE `todos` DISABLE KEYS */;
INSERT INTO `todos` VALUES (91,34,23,22,NULL,NULL,1),(92,22,23,33,NULL,NULL,1),(93,28,23,22,NULL,NULL,1),(94,23,23,33,NULL,NULL,1),(95,21,23,22,NULL,NULL,1),(96,36,23,33,NULL,NULL,1),(97,31,23,33,NULL,NULL,1),(98,35,23,44,NULL,NULL,1),(99,38,23,33,NULL,NULL,1),(100,24,23,44,NULL,NULL,1),(101,29,23,33,'12',NULL,1),(102,32,23,44,NULL,NULL,1),(103,39,23,33,NULL,NULL,1),(104,34,23,44,NULL,NULL,2),(105,22,23,32,NULL,NULL,2),(106,28,23,32,NULL,NULL,2),(107,23,23,32,NULL,NULL,2),(108,21,23,32,NULL,NULL,2),(109,36,23,32,NULL,NULL,2),(110,31,23,34,NULL,NULL,2),(111,35,23,34,NULL,NULL,2),(112,38,23,34,NULL,NULL,2),(113,24,23,34,NULL,NULL,2),(114,29,23,45,'32',NULL,2),(115,32,23,45,NULL,NULL,2),(116,39,23,45,NULL,NULL,2),(117,34,23,56,NULL,NULL,3),(118,22,23,56,NULL,NULL,3),(119,28,23,56,NULL,NULL,3),(120,23,23,56,NULL,NULL,3),(121,21,23,55,NULL,NULL,3),(122,36,23,33,NULL,NULL,3),(123,31,23,3,NULL,NULL,3),(124,35,23,3,NULL,NULL,3),(125,38,23,3,NULL,NULL,3),(126,24,23,3,NULL,NULL,3),(127,29,23,34,NULL,NULL,3),(128,32,23,4,NULL,NULL,3),(129,39,23,4,NULL,NULL,3),(130,34,23,NULL,NULL,NULL,4),(131,22,23,NULL,NULL,NULL,4),(132,28,23,NULL,NULL,NULL,4),(133,23,23,NULL,NULL,NULL,4),(134,21,23,NULL,NULL,NULL,4),(135,36,23,NULL,NULL,NULL,4),(136,31,23,NULL,NULL,NULL,4),(137,35,23,NULL,NULL,NULL,4),(138,38,23,NULL,NULL,NULL,4),(139,24,23,NULL,NULL,NULL,4),(140,29,23,NULL,NULL,NULL,4),(141,32,23,NULL,NULL,NULL,4),(142,39,23,NULL,NULL,NULL,4),(143,34,23,NULL,NULL,NULL,5),(144,22,23,NULL,NULL,NULL,5),(145,28,23,NULL,NULL,NULL,5),(146,23,23,NULL,NULL,NULL,5),(147,21,23,NULL,NULL,NULL,5),(148,36,23,NULL,NULL,NULL,5),(149,31,23,NULL,NULL,NULL,5),(150,35,23,NULL,NULL,NULL,5),(151,38,23,NULL,NULL,NULL,5),(152,24,23,NULL,NULL,NULL,5),(153,29,23,NULL,NULL,NULL,5),(154,32,23,NULL,NULL,NULL,5),(155,39,23,NULL,NULL,NULL,5),(156,34,23,NULL,NULL,NULL,6),(157,22,23,NULL,NULL,NULL,6),(158,28,23,NULL,NULL,NULL,6),(159,23,23,NULL,NULL,NULL,6),(160,21,23,NULL,NULL,NULL,6),(161,36,23,NULL,NULL,NULL,6),(162,31,23,NULL,NULL,NULL,6),(163,35,23,NULL,NULL,NULL,6),(164,38,23,NULL,NULL,NULL,6),(165,24,23,NULL,NULL,NULL,6),(166,29,23,NULL,NULL,NULL,6),(167,32,23,NULL,NULL,NULL,6),(168,39,23,NULL,NULL,NULL,6),(169,34,23,NULL,NULL,NULL,7),(170,22,23,NULL,NULL,NULL,7),(171,28,23,NULL,NULL,NULL,7),(172,23,23,NULL,NULL,NULL,7),(173,21,23,NULL,NULL,NULL,7),(174,36,23,NULL,NULL,NULL,7),(175,31,23,NULL,NULL,NULL,7),(176,35,23,NULL,NULL,NULL,7),(177,38,23,NULL,NULL,NULL,7),(178,24,23,NULL,NULL,NULL,7),(179,29,23,NULL,NULL,NULL,7),(181,39,23,NULL,NULL,NULL,7),(182,30,23,66,'12',NULL,2),(183,30,23,55,'12',NULL,3),(184,30,23,NULL,NULL,NULL,4),(185,25,23,NULL,NULL,NULL,4),(186,37,23,NULL,NULL,NULL,5),(187,27,23,NULL,NULL,NULL,5),(188,33,23,NULL,NULL,NULL,7),(189,26,23,NULL,NULL,NULL,7);
/*!40000 ALTER TABLE `todos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `todosheets`
--

LOCK TABLES `todosheets` WRITE;
/*!40000 ALTER TABLE `todosheets` DISABLE KEYS */;
INSERT INTO `todosheets` VALUES (23,2044,3,2,NULL,NULL);

/*!40000 ALTER TABLE `todosheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `firstname`, `lastname`, `initials`, `password`, `admin`, `firstconnect`) VALUES
(100, 'Michelle', 'Dutoit', 'MDT', '$2y$10$i0cgyQlhtTl4Gp1eHX1GK.37umWwI9mqWsXHqTQLjFWIyt5e7J6nS', 0, 0),
(101, 'Antonio', 'Casaburi', 'ACI', '$2y$10$NtDXutN9baamLrMugoAdAODxW5ot9.ImKn9NomZNMZocELkymDFvC', 1, 0),
(102, 'Xavier', 'Carrel', 'XCL', '$2y$10$QcssFUbiDCWC.1ggh3UYOukKcN2zqYF/LuraET75yLNMHU1kPNqfa', 1, 0),
(103, 'Thierry', 'Billieux', 'TBX', '$2y$10$KOto6XQdNqRZjoK.yXNNZ.29ycB311mHI.QM3DNJlVyoZRPFgNPbS', 1, 0),
(104, 'Michaël', 'Gogniat', 'MGT', '$2y$10$6JjX6WpKdgRZ44PQj.5C2.9mO2CeAekcKngNmvRh9ttX9mSyO8LGu', 1, 0),
(112, 'Philippe', 'Michel', 'PML', '$2y$10$2VfVqMAibraMuJWzMLSiLeBDXOnM9Lig7uapBb2iToqiFhylytM2O', 0, 0),
(113, 'Laurent', 'Pedroli', 'LPI', '$2y$10$ARMvzj7acmGDIzoBBNRghObQLpSf3FUKm7nN4n8MpranEVlHOq.eq', 0, 0),
(114, 'Damaris', 'Bourgeois', 'DMS', '$2y$10$enagKYdNGrztWs1pHSLB/.QaupoFkHc9hOCa9LoyjwWZpGvlKtYZ6', 0, 1),
(115, 'Laurent', 'Scheurer', 'LSR', '$2y$10$yyM/oFu8x.3Sfqrl4WrJUuVuTHVO/QDWAsm/dvco715c8ph1qk1Om', 0, 0),
(116, 'Galien', 'Wolfer', 'GWR', '$2y$10$wPiLR73utWWTt1DajuAQTuG50lcJFkemE9IvEgez16Ykau0p3L3Ca', 0, 1),
(117, 'Damaris ', 'Bourgeois', 'DBS', '$2y$10$3Cdjk8G095JgQjPqjZP6l.uFrbkF0/SF65UHCRZ/BKwdStrCLOXlK', 0, 0);


/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-01  7:28:46

-- table shiftsheets
INSERT INTO `shiftsheets` VALUES

(1,'2020-10-26 00:00:00',2,2,3,100,112,111,116,NULL,1,2),
(2,'2020-10-27 00:00:00',2,2,3,101,100,102,103,NULL,3,4),
(3,'2020-10-28 00:00:00',2,2,2,100,101,102,103,NULL,5,6),
(4,'2020-10-29 00:00:00',2,2,1,null,null,null,null,null,null,null),
(5,'2020-10-30 00:00:00',2,2,1,null,null,null,null,null,null,NULL);


-- table shiftchecks
INSERT INTO `shiftchecks` (id,DAY,shiftsheet_id,user_id,shiftaction_id) VALUES
(1,1,1,104,6),
(2,1,1,104,5),
(3,0,1,103,5),
(4,1,1,102,6),
(5,0,1,104,6),
(6,1,1,102,7),
(7,0,1,102,7),
(8,1,2,104,9),
(9,1,3,104,9),
(10,0,3,114,9),
(11,1,3,114,11),
(12,0,1,114,12),
(13,1,3,114,13),
(14,1,2,115,14),
(15,0,2,113,14),
(16,1,1,115,15),
(17,0,1,113,15),
(18,1,2,116,16),
(19,0,2,104,16),
(20,0,3,104,17);
