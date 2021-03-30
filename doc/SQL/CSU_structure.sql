-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           8.0.16 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour csunvb_csu
-- DROP DATABASE IF EXISTS `csunvb_csu`;
-- CREATE DATABASE IF NOT EXISTS `csunvb_csu` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `csunvb_csu`;

-- Listage de la structure de la table csunvb_csu. bases
DROP TABLE IF EXISTS `bases`;
CREATE TABLE IF NOT EXISTS `bases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. batches
DROP TABLE IF EXISTS `batches`;
CREATE TABLE IF NOT EXISTS `batches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL DEFAULT 'new',
  `drug_id` int(11) NOT NULL,
  `base_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`),
  KEY `fk_batches_drugs_idx` (`drug_id`),
  KEY `fk_batches_bases1_idx` (`base_id`),
  CONSTRAINT `fk_batches_bases1` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_batches_drugs` FOREIGN KEY (`drug_id`) REFERENCES `drugs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. drugs
DROP TABLE IF EXISTS `drugs`;
CREATE TABLE IF NOT EXISTS `drugs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. drugsheets
DROP TABLE IF EXISTS `drugsheets`;
CREATE TABLE IF NOT EXISTS `drugsheets` (
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. drugsheet_use_batch
DROP TABLE IF EXISTS `drugsheet_use_batch`;
CREATE TABLE IF NOT EXISTS `drugsheet_use_batch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drugsheet_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_use` (`drugsheet_id`,`batch_id`),
  KEY `fk_drugsheet_use_batch_drugsheets1_idx` (`drugsheet_id`),
  KEY `fk_drugsheet_use_batch_batches1_idx` (`batch_id`),
  CONSTRAINT `fk_drugsheet_use_batch_batches1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `fk_drugsheet_use_batch_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. drugsheet_use_nova
DROP TABLE IF EXISTS `drugsheet_use_nova`;
CREATE TABLE IF NOT EXISTS `drugsheet_use_nova` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `drugsheet_id` int(11) NOT NULL,
  `nova_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_use` (`drugsheet_id`,`nova_id`),
  KEY `fk_drugsheet_use_nova_drugsheets1_idx` (`drugsheet_id`),
  KEY `fk_drugsheet_use_nova_novas1_idx` (`nova_id`),
  CONSTRAINT `fk_drugsheet_use_nova_drugsheets1` FOREIGN KEY (`drugsheet_id`) REFERENCES `drugsheets` (`id`),
  CONSTRAINT `fk_drugsheet_use_nova_novas1` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. drugsignatures
DROP TABLE IF EXISTS `drugsignatures`;
CREATE TABLE IF NOT EXISTS `drugsignatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. logs
DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `report_type` enum('SHIFT','TODO','DRUG') NOT NULL,
  `report_id` int(11) NOT NULL COMMENT 'A foreign key without constraint, because it will point to different tables according to the report type',
  `info` varchar(200) DEFAULT NULL COMMENT 'decribe what is done',
  PRIMARY KEY (`id`),
  KEY `fkmadeby_idx` (`user_id`),
  CONSTRAINT `fkmadeby` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table contains all log entries for all reports';

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. novachecks
DROP TABLE IF EXISTS `novachecks`;
CREATE TABLE IF NOT EXISTS `novachecks` (
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
) ENGINE=InnoDB AUTO_INCREMENT=2251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. novas
DROP TABLE IF EXISTS `novas`;
CREATE TABLE IF NOT EXISTS `novas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number_UNIQUE` (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. pharmachecks
DROP TABLE IF EXISTS `pharmachecks`;
CREATE TABLE IF NOT EXISTS `pharmachecks` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5793 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. restocks
DROP TABLE IF EXISTS `restocks`;
CREATE TABLE IF NOT EXISTS `restocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `quantity` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `nova_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_restocks` (`date`,`batch_id`,`nova_id`) USING BTREE,
  KEY `fk_restocks_batches1_idx` (`batch_id`),
  KEY `fk_restocks_novas1_idx` (`nova_id`),
  KEY `fk_restocks_users1_idx` (`user_id`),
  CONSTRAINT `fk_restocks_batches1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`),
  CONSTRAINT `fk_restocks_novas1` FOREIGN KEY (`nova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_restocks_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftactions
DROP TABLE IF EXISTS `shiftactions`;
CREATE TABLE IF NOT EXISTS `shiftactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) NOT NULL,
  `shiftsection_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_shift_lines_shift_sections1_idx` (`shiftsection_id`),
  CONSTRAINT `fk_shift_lines_shift_sections1` FOREIGN KEY (`shiftsection_id`) REFERENCES `shiftsections` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftchecks
DROP TABLE IF EXISTS `shiftchecks`;
CREATE TABLE IF NOT EXISTS `shiftchecks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` tinyint(1) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftcomments
DROP TABLE IF EXISTS `shiftcomments`;
CREATE TABLE IF NOT EXISTS `shiftcomments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(200) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `carryOn` tinyint(1) NOT NULL DEFAULT '0',
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

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftmodels
DROP TABLE IF EXISTS `shiftmodels`;
CREATE TABLE IF NOT EXISTS `shiftmodels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `suggested` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idshiftmodels_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftmodel_has_shiftaction
DROP TABLE IF EXISTS `shiftmodel_has_shiftaction`;
CREATE TABLE IF NOT EXISTS `shiftmodel_has_shiftaction` (
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftsections
DROP TABLE IF EXISTS `shiftsections`;
CREATE TABLE IF NOT EXISTS `shiftsections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. shiftsheets
DROP TABLE IF EXISTS `shiftsheets`;
CREATE TABLE IF NOT EXISTS `shiftsheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `shiftmodel_id` int(11) NOT NULL,
  `base_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `dayboss_id` int(11) DEFAULT NULL,
  `nightboss_id` int(11) DEFAULT NULL,
  `dayteammate_id` int(11) DEFAULT NULL,
  `nightteammate_id` int(11) DEFAULT NULL,
  `closeBy` int(11) DEFAULT NULL,
  `daynova_id` int(11) DEFAULT NULL,
  `nightnova_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq` (`base_id`,`date`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_shiftsheets_bases1_idx` (`base_id`),
  KEY `fk_shiftSheets_status1_idx` (`status_id`),
  KEY `fk_shiftSheets_users1_idx` (`dayboss_id`),
  KEY `fk_shiftSheets_users2_idx` (`nightboss_id`),
  KEY `fk_shiftSheets_users3_idx` (`dayteammate_id`),
  KEY `fk_shiftSheets_users4_idx` (`nightteammate_id`),
  KEY `fk_shiftSheets_users5_idx` (`closeBy`),
  KEY `fk_shiftSheets_novas1_idx` (`daynova_id`),
  KEY `fk_shiftSheets_novas2_idx` (`nightnova_id`),
  KEY `fk_shiftsheets_shiftmodels1_idx` (`shiftmodel_id`),
  CONSTRAINT `fk_shiftSheets_novas1` FOREIGN KEY (`daynova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_shiftSheets_novas2` FOREIGN KEY (`nightnova_id`) REFERENCES `novas` (`id`),
  CONSTRAINT `fk_shiftSheets_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `fk_shiftSheets_users1` FOREIGN KEY (`dayboss_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftSheets_users2` FOREIGN KEY (`nightboss_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftSheets_users3` FOREIGN KEY (`dayteammate_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftSheets_users4` FOREIGN KEY (`nightteammate_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftSheets_users5` FOREIGN KEY (`closeBy`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_shiftsheets_bases1` FOREIGN KEY (`base_id`) REFERENCES `bases` (`id`),
  CONSTRAINT `fk_shiftsheets_shiftmodels1` FOREIGN KEY (`shiftmodel_id`) REFERENCES `shiftmodels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. status
DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(25) NOT NULL,
  `displayname` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. todos
DROP TABLE IF EXISTS `todos`;
CREATE TABLE IF NOT EXISTS `todos` (
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
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. todosheets
DROP TABLE IF EXISTS `todosheets`;
CREATE TABLE IF NOT EXISTS `todosheets` (
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. todothings
DROP TABLE IF EXISTS `todothings`;
CREATE TABLE IF NOT EXISTS `todothings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) NOT NULL,
  `daything` tinyint(4) NOT NULL DEFAULT '1',
  `type` enum('novas') DEFAULT NULL,
  `display_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `text_UNIQUE` (`description`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. tokens
DROP TABLE IF EXISTS `tokens`;
CREATE TABLE IF NOT EXISTS `tokens` (
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

-- Les données exportées n'étaient pas sélectionnées.
-- Listage de la structure de la table csunvb_csu. users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `initials` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `firstconnect` tinyint(4) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `mobileNumber` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `initials_UNIQUE` (`initials`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4;

-- Les données exportées n'étaient pas sélectionnées.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
