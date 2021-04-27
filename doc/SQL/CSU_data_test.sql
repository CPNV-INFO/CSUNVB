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


set @todoweek = 2116;

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


delimiter #
create procedure load_todo_sheets()
begin

	declare maxweeks int unsigned default 5;
	declare weekoffset int;

	declare baseid int default 1;
    
    while baseid <= 5 do
		set weekoffset = 0;
		start transaction;
		while weekoffset < maxweeks do
			INSERT INTO `todosheets` VALUES (maxweeks*(baseid-1)+weekoffset+1,@todoweek+weekoffset,3,baseid,NULL,NULL);
			set weekoffset=weekoffset+1;
		end while;
		commit;
        set baseid = baseid+1;
	end while;
    
end #

delimiter ;

call load_todo_sheets();
drop procedure load_todo_sheets;



delimiter #
create procedure load_todo_things()
begin

	DECLARE id INTEGER DEFAULT 1;
	while id <= 25 do
		INSERT INTO `todos` (todothing_id, todosheet_id, day_of_week) VALUES
			(24,id,1),
			(29,id,1),
			(32,id,1),
			(39,id,1),
			(34,id,2),
			(22,id,2),
			(28,id,2),
			(22,id,2),
			(21,id,2),
			(36,id,2),
			(31,id,2),
			(35,id,2),
			(38,id,2),
			(24,id,2),
			(29,id,2),
			(32,id,2),
			(39,id,2),
			(34,id,3),
			(22,id,3),
			(28,id,3),
			(22,id,3),
			(21,id,3),
			(36,id,3),
			(31,id,3),
			(35,id,3),
			(38,id,3),
			(24,id,3),
			(29,id,3),
			(32,id,3),
			(39,id,3),
			(34,id,4),
			(22,id,4),
			(28,id,4),
			(22,id,4),
			(21,id,4),
			(36,id,4),
			(31,id,4),
			(35,id,4),
			(38,id,4),
			(24,id,4),
			(29,id,4),
			(32,id,4),
			(39,id,4),
			(34,id,5),
			(22,id,5),
			(28,id,5),
			(22,id,5),
			(21,id,5),
			(36,id,5),
			(31,id,5),
			(35,id,5),
			(38,id,5),
			(24,id,5),
			(29,id,5),
			(32,id,5),
			(39,id,5),
			(34,id,6),
			(22,id,6),
			(28,id,6),
			(22,id,6),
			(21,id,6),
			(36,id,6),
			(31,id,6),
			(35,id,6),
			(38,id,6),
			(24,id,6),
			(29,id,6),
			(32,id,6),
			(39,id,6),
			(34,id,7),
			(22,id,7),
			(28,id,7),
			(22,id,7),
			(21,id,7),
			(36,id,7),
			(31,id,7),
			(35,id,7),
			(38,id,7),
			(24,id,7),
			(29,id,7),
			(39,id,7),
			(30,id,2),
			(30,id,3),
			(30,id,4),
			(25,id,4),
			(37,id,5),
			(27,id,5),
			(33,id,7),
			(26,id,7),
			(34,id,1),
			(22,id,1),
			(28,id,1),
			(22,id,1),
			(21,id,1),
			(36,id,1),
			(31,id,1),
			(35,id,1),
			(38,id,1);
		set id=id+1;
	end while;

end #

delimiter ;

call load_todo_things();
drop procedure load_todo_things;

/*!40000 ALTER TABLE `todos` ENABLE KEYS */;
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
