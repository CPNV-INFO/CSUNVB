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
INSERT INTO `batches` VALUES
(1,'F1us','used',1,1),
(2,'F1ne','new',1,1),
(3,'F1in','inuse',1,1),
(4,'M1us','used',2,1),
(5,'M1ne','new',2,1),
(6,'M1in','inuse',2,1),
(7,'T1us','used',3,1),
(8,'T1ne','new',3,1),
(9,'T1in','inuse',3,1),
(10,'F2us','used',1,2),
(11,'F2ne','new',1,2),
(12,'F2in','inuse',1,2),
(13,'M2us','used',2,2),
(14,'M2ne','new',2,2),
(15,'M2in','inuse',2,2),
(16,'T2us','used',3,2),
(17,'T2ne','new',3,2),
(18,'T2in','inuse',3,2),
(19,'F3us','used',1,3),
(20,'F3ne','new',1,3),
(21,'F3in','inuse',1,3),
(22,'M3us','used',2,3),
(23,'M3ne','new',2,3),
(24,'M3in','inuse',2,3),
(25,'T3us','used',3,3),
(26,'T3ne','new',3,3),
(27,'T3in','inuse',3,3),
(28,'F4us','used',1,4),
(29,'F4ne','new',1,4),
(30,'F4in','inuse',1,4),
(31,'M4us','used',2,4),
(32,'M4ne','new',2,4),
(33,'M4in','inuse',2,4),
(34,'T4us','used',3,4),
(35,'T4ne','new',3,4),
(36,'T4in','inuse',3,4),
(37,'F5us','used',1,5),
(38,'F5ne','new',1,5),
(39,'F5in','inuse',1,5),
(40,'M5us','used',2,5),
(41,'M5ne','new',2,5),
(42,'M5in','inuse',2,5),
(43,'T5us','used',3,5),
(44,'T5ne','new',3,5),
(45,'T5in','inuse',3,5);

/*!40000 ALTER TABLE `batches` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Dumping data for table `novachecks`
--

LOCK TABLES `novachecks` WRITE;
/*!40000 ALTER TABLE `novachecks` DISABLE KEYS */;
INSERT INTO `novachecks` VALUES
(673,'2021-02-01 00:00:00',6,6,1,3,11,23),
(674,'2021-02-01 00:00:00',6,6,1,5,22,23),
(675,'2021-02-01 00:00:00',6,6,2,3,22,23),
(676,'2021-02-01 00:00:00',6,6,2,5,33,23),
(677,'2021-02-01 00:00:00',6,6,3,3,44,23),
(678,'2021-02-01 00:00:00',5,5,3,5,55,23),
(679,'2021-02-02 00:00:00',6,6,1,3,66,23),
(680,'2021-02-02 00:00:00',6,6,1,5,77,23),
(681,'2021-02-02 00:00:00',6,6,2,3,87,23),
(682,'2021-02-02 00:00:00',6,5,2,5,76,23),
(683,'2021-02-02 00:00:00',6,6,3,3,65,23),
(684,'2021-02-02 00:00:00',6,6,3,5,54,23),
(685,'2021-02-03 00:00:00',4,NULL,1,3,43,23),
(686,'2021-02-03 00:00:00',6,NULL,1,5,3,23),
(687,'2021-02-03 00:00:00',6,NULL,2,3,23,23),
(688,'2021-02-03 00:00:00',6,NULL,2,5,32,23),
(689,'2021-02-03 00:00:00',6,NULL,3,3,21,23),
(690,'2021-02-03 00:00:00',6,NULL,3,5,12,23);
/*!40000 ALTER TABLE `novachecks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pharmachecks`
--

LOCK TABLES `pharmachecks` WRITE;
/*!40000 ALTER TABLE `pharmachecks` DISABLE KEYS */;
INSERT INTO `pharmachecks` VALUES
(5150,'2021-02-01 00:00:00',12,11,4,4,23),
(5151,'2021-02-01 00:00:00',8,8,8,8,23),
(5152,'2021-02-01 00:00:00',6,4,13,13,23),
(5153,'2021-02-02 00:00:00',11,11,4,7,23),
(5154,'2021-02-02 00:00:00',8,7,8,8,23),
(5155,'2021-02-02 00:00:00',4,4,13,2,23),
(5156,'2021-02-03 00:00:00',11,NULL,4,7,23),
(5157,'2021-02-03 00:00:00',7,NULL,8,66,23),
(5158,'2021-02-03 00:00:00',4,NULL,13,4,23);
/*!40000 ALTER TABLE `pharmachecks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `restocks`
--

LOCK TABLES `restocks` WRITE;
/*!40000 ALTER TABLE `restocks` DISABLE KEYS */;
INSERT INTO `restocks` VALUES
(5,'2021-02-01 00:00:00',1,4,5,2),
(6,'2021-02-01 00:00:00',2,13,3,3);
/*!40000 ALTER TABLE `restocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsheet_use_batch`
--

LOCK TABLES `drugsheet_use_batch` WRITE;
/*!40000 ALTER TABLE `drugsheet_use_batch` DISABLE KEYS */;
INSERT INTO `drugsheet_use_batch` VALUES
(109,23,4),
(110,23,8),
(111,23,13);
/*!40000 ALTER TABLE `drugsheet_use_batch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsheet_use_nova`
--

LOCK TABLES `drugsheet_use_nova` WRITE;
/*!40000 ALTER TABLE `drugsheet_use_nova` DISABLE KEYS */;
INSERT INTO `drugsheet_use_nova` VALUES
(51,23,3),
(52,23,5);
/*!40000 ALTER TABLE `drugsheet_use_nova` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `drugsheets`
--

LOCK TABLES `drugsheets` WRITE;
/*!40000 ALTER TABLE `drugsheets` DISABLE KEYS */;
INSERT INTO `drugsheets` VALUES
(22,2105,2,1),
(23,2105,2,2),
(25,2105,2,3),
(26,2105,2,4),
(27,2105,2,5);
/*!40000 ALTER TABLE `drugsheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `todos`
--

LOCK TABLES `todos` WRITE;
/*!40000 ALTER TABLE `todos` DISABLE KEYS */;
-- Sheet 22
INSERT INTO `todos` VALUES
(80,24,22,1,NULL,NULL,1),
(1,29,22,1,NULL,NULL,1),
(2,32,22,1,NULL,NULL,1),
(3,39,22,1,NULL,NULL,1),
(4,34,22,1,NULL,NULL,2),
(5,22,22,1,NULL,NULL,2),
(6,28,22,1,NULL,NULL,2),
(7,22,22,1,NULL,NULL,2),
(8,21,22,1,NULL,NULL,2),
(9,36,22,1,NULL,NULL,2),
(10,31,22,1,NULL,NULL,2),
(11,35,22,1,NULL,NULL,2),
(12,38,22,1,NULL,NULL,2),
(13,24,22,1,NULL,NULL,2),
(14,29,22,1,NULL,NULL,2),
(15,32,22,1,NULL,NULL,2),
(16,39,22,1,NULL,NULL,2),
(17,34,22,1,NULL,NULL,3),
(18,22,22,1,NULL,NULL,3),
(19,28,22,1,NULL,NULL,3),
(20,22,22,1,NULL,NULL,3),
(21,21,22,1,NULL,NULL,3),
(22,36,22,1,NULL,NULL,3),
(23,31,22,1,NULL,NULL,3),
(24,35,22,1,NULL,NULL,3),
(25,38,22,1,NULL,NULL,3),
(26,24,22,1,NULL,NULL,3),
(27,29,22,1,NULL,NULL,3),
(28,32,22,1,NULL,NULL,3),
(29,39,22,1,NULL,NULL,3),
(30,34,22,NULL,NULL,NULL,4),
(31,22,22,NULL,NULL,NULL,4),
(32,28,22,NULL,NULL,NULL,4),
(33,22,22,NULL,NULL,NULL,4),
(34,21,22,NULL,NULL,NULL,4),
(35,36,22,NULL,NULL,NULL,4),
(36,31,22,NULL,NULL,NULL,4),
(37,35,22,NULL,NULL,NULL,4),
(38,38,22,NULL,NULL,NULL,4),
(39,24,22,NULL,NULL,NULL,4),
(40,29,22,NULL,NULL,NULL,4),
(41,32,22,NULL,NULL,NULL,4),
(42,39,22,NULL,NULL,NULL,4),
(43,34,22,NULL,NULL,NULL,5),
(44,22,22,NULL,NULL,NULL,5),
(45,28,22,NULL,NULL,NULL,5),
(46,22,22,NULL,NULL,NULL,5),
(47,21,22,NULL,NULL,NULL,5),
(48,36,22,NULL,NULL,NULL,5),
(49,31,22,NULL,NULL,NULL,5),
(50,35,22,NULL,NULL,NULL,5),
(51,38,22,NULL,NULL,NULL,5),
(52,24,22,NULL,NULL,NULL,5),
(53,29,22,NULL,NULL,NULL,5),
(54,32,22,NULL,NULL,NULL,5),
(55,39,22,NULL,NULL,NULL,5),
(56,34,22,NULL,NULL,NULL,6),
(57,22,22,NULL,NULL,NULL,6),
(58,28,22,NULL,NULL,NULL,6),
(59,22,22,NULL,NULL,NULL,6),
(60,21,22,NULL,NULL,NULL,6),
(61,36,22,NULL,NULL,NULL,6),
(62,31,22,NULL,NULL,NULL,6),
(63,35,22,NULL,NULL,NULL,6),
(64,38,22,NULL,NULL,NULL,6),
(65,24,22,NULL,NULL,NULL,6),
(66,29,22,NULL,NULL,NULL,6),
(67,32,22,NULL,NULL,NULL,6),
(68,39,22,NULL,NULL,NULL,6),
(69,34,22,NULL,NULL,NULL,7),
(70,22,22,NULL,NULL,NULL,7),
(71,28,22,NULL,NULL,NULL,7),
(72,22,22,NULL,NULL,NULL,7),
(73,21,22,NULL,NULL,NULL,7),
(74,36,22,NULL,NULL,NULL,7),
(75,31,22,NULL,NULL,NULL,7),
(76,35,22,NULL,NULL,NULL,7),
(77,38,22,NULL,NULL,NULL,7),
(78,24,22,NULL,NULL,NULL,7),
(79,29,22,NULL,NULL,NULL,7),
(81,39,22,NULL,NULL,NULL,7),
(82,30,22,1,NULL,NULL,2),
(83,30,22,1,NULL,NULL,3),
(84,30,22,NULL,NULL,NULL,4),
(85,25,22,NULL,NULL,NULL,4),
(86,37,22,NULL,NULL,NULL,5),
(87,27,22,NULL,NULL,NULL,5),
(88,33,22,NULL,NULL,NULL,7),
(89,26,22,NULL,NULL,NULL,7),
(91,34,22,1,NULL,NULL,1),
(92,22,22,1,NULL,NULL,1),
(93,28,22,1,NULL,NULL,1),
(94,22,22,1,NULL,NULL,1),
(95,21,22,1,NULL,NULL,1),
(96,36,22,1,NULL,NULL,1),
(97,31,22,1,NULL,NULL,1),
(98,35,22,1,NULL,NULL,1),
(99,38,22,1,NULL,NULL,1);

-- Sheet 23
INSERT INTO `todos` VALUES
(191,34,23,1,NULL,NULL,1),
(192,22,23,1,NULL,NULL,1),
(193,28,23,1,NULL,NULL,1),
(194,23,23,1,NULL,NULL,1),
(195,21,23,1,NULL,NULL,1),
(196,36,23,1,NULL,NULL,1),
(197,31,23,1,NULL,NULL,1),
(198,35,23,1,NULL,NULL,1),
(199,38,23,1,NULL,NULL,1),
(100,24,23,1,NULL,NULL,1),
(101,29,23,1,NULL,NULL,1),
(102,32,23,1,NULL,NULL,1),
(103,39,23,1,NULL,NULL,1),
(104,34,23,1,NULL,NULL,2),
(105,22,23,1,NULL,NULL,2),
(106,28,23,1,NULL,NULL,2),
(107,23,23,1,NULL,NULL,2),
(108,21,23,1,NULL,NULL,2),
(109,36,23,1,NULL,NULL,2),
(110,31,23,1,NULL,NULL,2),
(111,35,23,1,NULL,NULL,2),
(112,38,23,1,NULL,NULL,2),
(113,24,23,1,NULL,NULL,2),
(114,29,23,1,NULL,NULL,2),
(115,32,23,1,NULL,NULL,2),
(116,39,23,1,NULL,NULL,2),
(117,34,23,1,NULL,NULL,3),
(118,22,23,1,NULL,NULL,3),
(119,28,23,1,NULL,NULL,3),
(120,23,23,1,NULL,NULL,3),
(121,21,23,1,NULL,NULL,3),
(122,36,23,1,NULL,NULL,3),
(123,31,23,1,NULL,NULL,3),
(124,35,23,1,NULL,NULL,3),
(125,38,23,1,NULL,NULL,3),
(126,24,23,1,NULL,NULL,3),
(127,29,23,1,NULL,NULL,3),
(128,32,23,1,NULL,NULL,3),
(129,39,23,1,NULL,NULL,3),
(130,34,23,NULL,NULL,NULL,4),
(131,22,23,NULL,NULL,NULL,4),
(132,28,23,NULL,NULL,NULL,4),
(133,23,23,NULL,NULL,NULL,4),
(134,21,23,NULL,NULL,NULL,4),
(135,36,23,NULL,NULL,NULL,4),
(136,31,23,NULL,NULL,NULL,4),
(137,35,23,NULL,NULL,NULL,4),
(138,38,23,NULL,NULL,NULL,4),
(139,24,23,NULL,NULL,NULL,4),
(140,29,23,NULL,NULL,NULL,4),
(141,32,23,NULL,NULL,NULL,4),
(142,39,23,NULL,NULL,NULL,4),
(143,34,23,NULL,NULL,NULL,5),
(144,22,23,NULL,NULL,NULL,5),
(145,28,23,NULL,NULL,NULL,5),
(146,23,23,NULL,NULL,NULL,5),
(147,21,23,NULL,NULL,NULL,5),
(148,36,23,NULL,NULL,NULL,5),
(149,31,23,NULL,NULL,NULL,5),
(150,35,23,NULL,NULL,NULL,5),
(151,38,23,NULL,NULL,NULL,5),
(152,24,23,NULL,NULL,NULL,5),
(153,29,23,NULL,NULL,NULL,5),
(154,32,23,NULL,NULL,NULL,5),
(155,39,23,NULL,NULL,NULL,5),
(156,34,23,NULL,NULL,NULL,6),
(157,22,23,NULL,NULL,NULL,6),
(158,28,23,NULL,NULL,NULL,6),
(159,23,23,NULL,NULL,NULL,6),
(160,21,23,NULL,NULL,NULL,6),
(161,36,23,NULL,NULL,NULL,6),
(162,31,23,NULL,NULL,NULL,6),
(163,35,23,NULL,NULL,NULL,6),
(164,38,23,NULL,NULL,NULL,6),
(165,24,23,NULL,NULL,NULL,6),
(166,29,23,NULL,NULL,NULL,6),
(167,32,23,NULL,NULL,NULL,6),
(168,39,23,NULL,NULL,NULL,6),
(169,34,23,NULL,NULL,NULL,7),
(170,22,23,NULL,NULL,NULL,7),
(171,28,23,NULL,NULL,NULL,7),
(172,23,23,NULL,NULL,NULL,7),
(173,21,23,NULL,NULL,NULL,7),
(174,36,23,NULL,NULL,NULL,7),
(175,31,23,NULL,NULL,NULL,7),
(176,35,23,NULL,NULL,NULL,7),
(177,38,23,NULL,NULL,NULL,7),
(178,24,23,NULL,NULL,NULL,7),
(179,29,23,NULL,NULL,NULL,7),
(181,39,23,NULL,NULL,NULL,7),
(182,30,23,1,NULL,NULL,2),
(183,30,23,1,NULL,NULL,3),
(184,30,23,NULL,NULL,NULL,4),
(185,25,23,NULL,NULL,NULL,4),
(186,37,23,NULL,NULL,NULL,5),
(187,27,23,NULL,NULL,NULL,5),
(188,33,23,NULL,NULL,NULL,7),
(189,26,23,NULL,NULL,NULL,7);

-- Sheet 24
INSERT INTO `todos` VALUES
(291,34,24,1,NULL,NULL,1),
(292,22,24,1,NULL,NULL,1),
(293,28,24,1,NULL,NULL,1),
(294,22,24,1,NULL,NULL,1),
(295,21,24,1,NULL,NULL,1),
(296,36,24,1,NULL,NULL,1),
(297,31,24,1,NULL,NULL,1),
(298,35,24,1,NULL,NULL,1),
(299,38,24,1,NULL,NULL,1),
(200,24,24,1,NULL,NULL,1),
(201,29,24,1,NULL,NULL,1),
(202,32,24,1,NULL,NULL,1),
(203,39,24,1,NULL,NULL,1),
(204,34,24,1,NULL,NULL,2),
(205,22,24,1,NULL,NULL,2),
(206,28,24,1,NULL,NULL,2),
(207,22,24,1,NULL,NULL,2),
(208,21,24,1,NULL,NULL,2),
(209,36,24,1,NULL,NULL,2),
(210,31,24,1,NULL,NULL,2),
(211,35,24,1,NULL,NULL,2),
(212,38,24,1,NULL,NULL,2),
(213,24,24,1,NULL,NULL,2),
(214,29,24,1,NULL,NULL,2),
(215,32,24,1,NULL,NULL,2),
(216,39,24,1,NULL,NULL,2),
(217,34,24,1,NULL,NULL,3),
(218,22,24,1,NULL,NULL,3),
(219,28,24,1,NULL,NULL,3),
(220,22,24,1,NULL,NULL,3),
(221,21,24,1,NULL,NULL,3),
(222,36,24,1,NULL,NULL,3),
(223,31,24,1,NULL,NULL,3),
(224,35,24,1,NULL,NULL,3),
(225,38,24,1,NULL,NULL,3),
(226,24,24,1,NULL,NULL,3),
(227,29,24,1,NULL,NULL,3),
(228,32,24,1,NULL,NULL,3),
(229,39,24,1,NULL,NULL,3),
(230,34,24,NULL,NULL,NULL,4),
(231,22,24,NULL,NULL,NULL,4),
(232,28,24,NULL,NULL,NULL,4),
(233,22,24,NULL,NULL,NULL,4),
(234,21,24,NULL,NULL,NULL,4),
(235,36,24,NULL,NULL,NULL,4),
(236,31,24,NULL,NULL,NULL,4),
(237,35,24,NULL,NULL,NULL,4),
(238,38,24,NULL,NULL,NULL,4),
(239,24,24,NULL,NULL,NULL,4),
(240,29,24,NULL,NULL,NULL,4),
(241,32,24,NULL,NULL,NULL,4),
(242,39,24,NULL,NULL,NULL,4),
(243,34,24,NULL,NULL,NULL,5),
(244,22,24,NULL,NULL,NULL,5),
(245,28,24,NULL,NULL,NULL,5),
(246,22,24,NULL,NULL,NULL,5),
(247,21,24,NULL,NULL,NULL,5),
(248,36,24,NULL,NULL,NULL,5),
(249,31,24,NULL,NULL,NULL,5),
(250,35,24,NULL,NULL,NULL,5),
(251,38,24,NULL,NULL,NULL,5),
(252,24,24,NULL,NULL,NULL,5),
(253,29,24,NULL,NULL,NULL,5),
(254,32,24,NULL,NULL,NULL,5),
(255,39,24,NULL,NULL,NULL,5),
(256,34,24,NULL,NULL,NULL,6),
(257,22,24,NULL,NULL,NULL,6),
(258,28,24,NULL,NULL,NULL,6),
(259,22,24,NULL,NULL,NULL,6),
(260,21,24,NULL,NULL,NULL,6),
(261,36,24,NULL,NULL,NULL,6),
(262,31,24,NULL,NULL,NULL,6),
(263,35,24,NULL,NULL,NULL,6),
(264,38,24,NULL,NULL,NULL,6),
(265,24,24,NULL,NULL,NULL,6),
(266,29,24,NULL,NULL,NULL,6),
(267,32,24,NULL,NULL,NULL,6),
(268,39,24,NULL,NULL,NULL,6),
(269,34,24,NULL,NULL,NULL,7),
(270,22,24,NULL,NULL,NULL,7),
(271,28,24,NULL,NULL,NULL,7),
(272,22,24,NULL,NULL,NULL,7),
(273,21,24,NULL,NULL,NULL,7),
(274,36,24,NULL,NULL,NULL,7),
(275,31,24,NULL,NULL,NULL,7),
(276,35,24,NULL,NULL,NULL,7),
(277,38,24,NULL,NULL,NULL,7),
(278,24,24,NULL,NULL,NULL,7),
(279,29,24,NULL,NULL,NULL,7),
(281,39,24,NULL,NULL,NULL,7),
(282,30,24,1,NULL,NULL,2),
(283,30,24,1,NULL,NULL,3),
(284,30,24,NULL,NULL,NULL,4),
(285,25,24,NULL,NULL,NULL,4),
(286,37,24,NULL,NULL,NULL,5),
(287,27,24,NULL,NULL,NULL,5),
(288,33,24,NULL,NULL,NULL,7),
(289,26,24,NULL,NULL,NULL,7);

-- Sheet 25
INSERT INTO `todos` VALUES
(391,34,25,1,NULL,NULL,1),
(392,22,25,1,NULL,NULL,1),
(393,28,25,1,NULL,NULL,1),
(394,22,25,1,NULL,NULL,1),
(395,21,25,1,NULL,NULL,1),
(396,36,25,1,NULL,NULL,1),
(397,31,25,1,NULL,NULL,1),
(398,35,25,1,NULL,NULL,1),
(399,38,25,1,NULL,NULL,1),
(300,24,25,1,NULL,NULL,1),
(301,29,25,1,NULL,NULL,1),
(302,32,25,1,NULL,NULL,1),
(303,39,25,1,NULL,NULL,1),
(304,34,25,1,NULL,NULL,2),
(305,22,25,1,NULL,NULL,2),
(306,28,25,1,NULL,NULL,2),
(307,22,25,1,NULL,NULL,2),
(308,21,25,1,NULL,NULL,2),
(309,36,25,1,NULL,NULL,2),
(310,31,25,1,NULL,NULL,2),
(311,35,25,1,NULL,NULL,2),
(312,38,25,1,NULL,NULL,2),
(313,24,25,1,NULL,NULL,2),
(314,29,25,1,NULL,NULL,2),
(315,32,25,1,NULL,NULL,2),
(316,39,25,1,NULL,NULL,2),
(317,34,25,1,NULL,NULL,3),
(318,22,25,1,NULL,NULL,3),
(319,28,25,1,NULL,NULL,3),
(320,22,25,1,NULL,NULL,3),
(321,21,25,1,NULL,NULL,3),
(322,36,25,1,NULL,NULL,3),
(323,31,25,1,NULL,NULL,3),
(324,35,25,1,NULL,NULL,3),
(325,38,25,1,NULL,NULL,3),
(326,24,25,1,NULL,NULL,3),
(327,29,25,1,NULL,NULL,3),
(328,32,25,1,NULL,NULL,3),
(329,39,25,1,NULL,NULL,3),
(330,34,25,NULL,NULL,NULL,4),
(331,22,25,NULL,NULL,NULL,4),
(332,28,25,NULL,NULL,NULL,4),
(333,22,25,NULL,NULL,NULL,4),
(334,21,25,NULL,NULL,NULL,4),
(335,36,25,NULL,NULL,NULL,4),
(336,31,25,NULL,NULL,NULL,4),
(337,35,25,NULL,NULL,NULL,4),
(338,38,25,NULL,NULL,NULL,4),
(339,24,25,NULL,NULL,NULL,4),
(340,29,25,NULL,NULL,NULL,4),
(341,32,25,NULL,NULL,NULL,4),
(342,39,25,NULL,NULL,NULL,4),
(343,34,25,NULL,NULL,NULL,5),
(344,22,25,NULL,NULL,NULL,5),
(345,28,25,NULL,NULL,NULL,5),
(346,22,25,NULL,NULL,NULL,5),
(347,21,25,NULL,NULL,NULL,5),
(348,36,25,NULL,NULL,NULL,5),
(349,31,25,NULL,NULL,NULL,5),
(350,35,25,NULL,NULL,NULL,5),
(351,38,25,NULL,NULL,NULL,5),
(352,24,25,NULL,NULL,NULL,5),
(353,29,25,NULL,NULL,NULL,5),
(354,32,25,NULL,NULL,NULL,5),
(355,39,25,NULL,NULL,NULL,5),
(356,34,25,NULL,NULL,NULL,6),
(357,22,25,NULL,NULL,NULL,6),
(358,28,25,NULL,NULL,NULL,6),
(359,22,25,NULL,NULL,NULL,6),
(360,21,25,NULL,NULL,NULL,6),
(361,36,25,NULL,NULL,NULL,6),
(362,31,25,NULL,NULL,NULL,6),
(363,35,25,NULL,NULL,NULL,6),
(364,38,25,NULL,NULL,NULL,6),
(365,24,25,NULL,NULL,NULL,6),
(366,29,25,NULL,NULL,NULL,6),
(367,32,25,NULL,NULL,NULL,6),
(368,39,25,NULL,NULL,NULL,6),
(369,34,25,NULL,NULL,NULL,7),
(370,22,25,NULL,NULL,NULL,7),
(371,28,25,NULL,NULL,NULL,7),
(372,22,25,NULL,NULL,NULL,7),
(373,21,25,NULL,NULL,NULL,7),
(374,36,25,NULL,NULL,NULL,7),
(375,31,25,NULL,NULL,NULL,7),
(376,35,25,NULL,NULL,NULL,7),
(377,38,25,NULL,NULL,NULL,7),
(378,24,25,NULL,NULL,NULL,7),
(379,29,25,NULL,NULL,NULL,7),
(381,39,25,NULL,NULL,NULL,7),
(382,30,25,1,NULL,NULL,2),
(383,30,25,1,NULL,NULL,3),
(384,30,25,NULL,NULL,NULL,4),
(385,25,25,NULL,NULL,NULL,4),
(386,37,25,NULL,NULL,NULL,5),
(387,27,25,NULL,NULL,NULL,5),
(388,33,25,NULL,NULL,NULL,7),
(389,26,25,NULL,NULL,NULL,7);

-- Sheet 26
INSERT INTO `todos` VALUES
(491,34,26,1,NULL,NULL,1),
(492,22,26,1,NULL,NULL,1),
(493,28,26,1,NULL,NULL,1),
(494,22,26,1,NULL,NULL,1),
(495,21,26,1,NULL,NULL,1),
(496,36,26,1,NULL,NULL,1),
(497,31,26,1,NULL,NULL,1),
(498,35,26,1,NULL,NULL,1),
(499,38,26,1,NULL,NULL,1),
(400,24,26,1,NULL,NULL,1),
(401,29,26,1,NULL,NULL,1),
(402,32,26,1,NULL,NULL,1),
(403,39,26,1,NULL,NULL,1),
(404,34,26,1,NULL,NULL,2),
(405,22,26,1,NULL,NULL,2),
(406,28,26,1,NULL,NULL,2),
(407,22,26,1,NULL,NULL,2),
(408,21,26,1,NULL,NULL,2),
(409,36,26,1,NULL,NULL,2),
(410,31,26,1,NULL,NULL,2),
(411,35,26,1,NULL,NULL,2),
(412,38,26,1,NULL,NULL,2),
(413,24,26,1,NULL,NULL,2),
(414,29,26,1,NULL,NULL,2),
(415,32,26,1,NULL,NULL,2),
(416,39,26,1,NULL,NULL,2),
(417,34,26,1,NULL,NULL,3),
(418,22,26,1,NULL,NULL,3),
(419,28,26,1,NULL,NULL,3),
(420,22,26,1,NULL,NULL,3),
(421,21,26,1,NULL,NULL,3),
(422,36,26,1,NULL,NULL,3),
(423,31,26,1,NULL,NULL,3),
(424,35,26,1,NULL,NULL,3),
(425,38,26,1,NULL,NULL,3),
(426,24,26,1,NULL,NULL,3),
(427,29,26,1,NULL,NULL,3),
(428,32,26,1,NULL,NULL,3),
(429,39,26,1,NULL,NULL,3),
(430,34,26,NULL,NULL,NULL,4),
(431,22,26,NULL,NULL,NULL,4),
(432,28,26,NULL,NULL,NULL,4),
(433,22,26,NULL,NULL,NULL,4),
(434,21,26,NULL,NULL,NULL,4),
(435,36,26,NULL,NULL,NULL,4),
(436,31,26,NULL,NULL,NULL,4),
(437,35,26,NULL,NULL,NULL,4),
(438,38,26,NULL,NULL,NULL,4),
(439,24,26,NULL,NULL,NULL,4),
(440,29,26,NULL,NULL,NULL,4),
(441,32,26,NULL,NULL,NULL,4),
(442,39,26,NULL,NULL,NULL,4),
(443,34,26,NULL,NULL,NULL,5),
(444,22,26,NULL,NULL,NULL,5),
(445,28,26,NULL,NULL,NULL,5),
(446,22,26,NULL,NULL,NULL,5),
(447,21,26,NULL,NULL,NULL,5),
(448,36,26,NULL,NULL,NULL,5),
(449,31,26,NULL,NULL,NULL,5),
(450,35,26,NULL,NULL,NULL,5),
(451,38,26,NULL,NULL,NULL,5),
(452,24,26,NULL,NULL,NULL,5),
(453,29,26,NULL,NULL,NULL,5),
(454,32,26,NULL,NULL,NULL,5),
(455,39,26,NULL,NULL,NULL,5),
(456,34,26,NULL,NULL,NULL,6),
(457,22,26,NULL,NULL,NULL,6),
(458,28,26,NULL,NULL,NULL,6),
(459,22,26,NULL,NULL,NULL,6),
(460,21,26,NULL,NULL,NULL,6),
(461,36,26,NULL,NULL,NULL,6),
(462,31,26,NULL,NULL,NULL,6),
(463,35,26,NULL,NULL,NULL,6),
(464,38,26,NULL,NULL,NULL,6),
(465,24,26,NULL,NULL,NULL,6),
(466,29,26,NULL,NULL,NULL,6),
(467,32,26,NULL,NULL,NULL,6),
(468,39,26,NULL,NULL,NULL,6),
(469,34,26,NULL,NULL,NULL,7),
(470,22,26,NULL,NULL,NULL,7),
(471,28,26,NULL,NULL,NULL,7),
(472,22,26,NULL,NULL,NULL,7),
(473,21,26,NULL,NULL,NULL,7),
(474,36,26,NULL,NULL,NULL,7),
(475,31,26,NULL,NULL,NULL,7),
(476,35,26,NULL,NULL,NULL,7),
(477,38,26,NULL,NULL,NULL,7),
(478,24,26,NULL,NULL,NULL,7),
(479,29,26,NULL,NULL,NULL,7),
(481,39,26,NULL,NULL,NULL,7),
(482,30,26,1,NULL,NULL,2),
(483,30,26,1,NULL,NULL,3),
(484,30,26,NULL,NULL,NULL,4),
(485,25,26,NULL,NULL,NULL,4),
(486,37,26,NULL,NULL,NULL,5),
(487,27,26,NULL,NULL,NULL,5),
(488,33,26,NULL,NULL,NULL,7),
(489,26,26,NULL,NULL,NULL,7);
/*!40000 ALTER TABLE `todos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `todosheets`
--

LOCK TABLES `todosheets` WRITE;
/*!40000 ALTER TABLE `todosheets` DISABLE KEYS */;
INSERT INTO `todosheets` VALUES
(22,2105,3,1,NULL,NULL),
(23,2105,3,2,NULL,NULL),
(24,2105,3,3,NULL,NULL),
(25,2105,3,4,NULL,NULL),
(26,2105,3,5,NULL,NULL);
/*!40000 ALTER TABLE `todosheets` ENABLE KEYS */;
UNLOCK TABLES;

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
(1,'2021-02-01',2,1,3,103,104,115,116,null,1,2),
(2,'2021-02-01',2,2,3,103,104,115,116,null,3,4),
(3,'2021-02-01',2,3,3,103,104,115,116,null,5,8),
(4,'2021-02-01',2,4,3,103,104,115,116,null,6,8),
(5,'2021-02-01',2,5,3,103,104,115,116,null,7,10);
