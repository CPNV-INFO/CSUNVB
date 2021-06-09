-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           10.5.8-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

use csunvb_csu;

-- Listage des données de la table csunvb_csu.bases : ~5 rows (environ)
/*!40000 ALTER TABLE `bases` DISABLE KEYS */;
INSERT INTO `bases` (`id`, `name`) VALUES
	(5, 'La Vallée-de-Joux'),
	(4, 'Payerne'),
	(3, 'Saint-Loup'),
	(2, 'Ste-Croix'),
	(1, 'Yverdon');
/*!40000 ALTER TABLE `bases` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.drugs : ~3 rows (environ)
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
INSERT INTO `drugs` (`id`, `name`) VALUES
	(1, 'Fentanyl'),
	(2, 'Morphine'),
	(3, 'Temesta');
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.drugsheets : ~5 rows (environ)
/*!40000 ALTER TABLE `drugsheets` DISABLE KEYS */;
INSERT INTO `drugsheets` (`week`, `status_id`, `base_id`) VALUES (2122, 3, 2);
/*!40000 ALTER TABLE `drugsheets` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.novas : ~11 rows (environ)
/*!40000 ALTER TABLE `novas` DISABLE KEYS */;
INSERT INTO `novas` (`number`) VALUES (31),(32),(33),(34),(35),(36),(57),(58),(75),(76),(77);
/*!40000 ALTER TABLE `novas` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.shiftactions : ~19 rows (environ)
/*!40000 ALTER TABLE `shiftactions` DISABLE KEYS */;
INSERT INTO `shiftactions` (`id`, `text`, `shiftsection_id`) VALUES
	(1, 'Radios', 1),
	(2, 'Détecteurs CO', 1),
	(3, 'Téléphones', 1),
	(4, 'Gt info avisé', 1),
	(5, 'Annonce 144', 1),
	(6, 'Plein essence', 2),
	(7, 'Opérationnel', 2),
	(8, 'Rdv garage', 2),
	(9, 'Gt vhc avisé', 2),
	(10, '50chf présents', 2),
	(11, 'Problèmes d\'interventions hors véhicules', 2),
	(12, 'Info trafic consulté', 3),
	(13, 'Report des infos trafic sur plan de secteur', 3),
	(14, 'Accueil étudiant ou stagiaire', 3),
	(15, 'Lecture journal de bord ', 3),
	(16, 'Problème et responsable Gt avisé', 3),
	(17, 'Centrale propre', 4),
	(18, 'Tâches du jour effectuées', 4),
	(19, 'Dimanche ', 4);
/*!40000 ALTER TABLE `shiftactions` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.shiftmodels : ~5 rows (environ)
/*!40000 ALTER TABLE `shiftmodels` DISABLE KEYS */;
INSERT INTO `shiftmodels` (`id`, `name`, `nbTeamD`, `nbTeamN`, `suggested`) VALUES
	(1, 'Initial', 1, 1, 1);
/*!40000 ALTER TABLE `shiftmodels` ENABLE KEYS */;

INSERT INTO `shiftmodel_has_shiftaction` (`shiftaction_id`, `shiftmodel_id`) SELECT id, 1 FROM `shiftactions`;

-- Listage des données de la table csunvb_csu.shiftsections : ~4 rows (environ)
/*!40000 ALTER TABLE `shiftsections` DISABLE KEYS */;
INSERT INTO `shiftsections` (`id`, `title`) VALUES
	(1, 'Centrale & Tâches'),
	(2, 'Ecrans de communication & Trafic'),
	(3, 'Matériel & Télécom'),
	(4, 'Véhicules & Interventions');
/*!40000 ALTER TABLE `shiftsections` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.shiftsheets : ~75 rows (environ)
/*!40000 ALTER TABLE `shiftsheets` DISABLE KEYS */;
INSERT INTO `shiftsheets` (`date`, `shiftmodel_id`, `base_id`, `status_id`) VALUES
	('2021-06-01', 1, 1, 3),
	('2021-06-01', 1, 2, 3),
	('2021-06-01', 1, 3, 3),
	('2021-06-01', 1, 4, 3),
	('2021-06-01', 1, 5, 3);
/*!40000 ALTER TABLE `shiftsheets` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.status : ~5 rows (environ)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `slug`, `displayname`) VALUES
	(1, 'blank', 'En préparation'),
	(2, 'open', 'Actif'),
	(3, 'close', 'Clôturé'),
	(4, 'reopen', 'En correction'),
	(5, 'archive', 'Archivé');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.todosheets : ~25 rows (environ)
/*!40000 ALTER TABLE `todosheets` DISABLE KEYS */;
INSERT INTO `todosheets` (`week`, `status_id`, `base_id`, `closeBy`, `template_name`) VALUES (2122, 3, 2, NULL, NULL);
/*!40000 ALTER TABLE `todosheets` ENABLE KEYS */;


-- Listage des données de la table csunvb_csu.todothings : ~20 rows (environ)
/*!40000 ALTER TABLE `todothings` DISABLE KEYS */;
INSERT INTO `todothings` (`id`, `description`, `daything`, `type`, `display_order`) VALUES
	(21, 'Changer Bac chariot de nettoyage', 1, NULL, 5),
	(22, 'Check Ambulance et Communication', 1, NULL, 2),
	(23, 'Check bibliothèque', 1, NULL, 4),
	(24, 'Check de nuit ', 0, NULL, 21),
	(25, 'Commande mat et commande pharma.', 1, NULL, 6),
	(26, 'Commande O2', 0, NULL, 25),
	(27, 'Contrôle niveau véhicule', 1, NULL, 8),
	(28, 'Contrôle stupéfiants + Date perf. Chaudes', 1, NULL, 3),
	(29, 'Contrôle stupéfiants Nova .... (Morphine X4, Fentanyl X6)', 0, 'novas', 22),
	(30, 'Désinfection + Inventaire hebdo Nova ....', 1, 'novas', 11),
	(31, 'Tâches spécifiques de jour', 1, NULL, 13),
	(32, 'Tâches spécifiques de nuit', 0, NULL, 23),
	(33, 'Envoi rapport STUP hebdo à gt pharmacie', 1, NULL, 9),
	(34, 'Fax 144 Transmission', 1, NULL, 1),
	(35, 'Formation', 1, NULL, 14),
	(36, 'Nettoyage centrale et garage', 1, NULL, 10),
	(37, 'Rangement mat', 1, NULL, 7),
	(38, 'Remise locaux ambulances ', 1, NULL, 15),
	(39, 'Remise locaux Transmission', 0, NULL, 24),
	(40, 'Tâches selon nécessité', 1, NULL, 12);
/*!40000 ALTER TABLE `todothings` ENABLE KEYS */;

/*!40000 ALTER TABLE `todos` DISABLE KEYS */;
INSERT INTO `todos` (`todothing_id`, `todosheet_id`, `user_id`, `value`, `done_at`, `day_of_week`) VALUES
(34, 1, NULL, NULL, NULL, 1),
(22, 1, NULL, NULL, NULL, 1),
(28, 1, NULL, NULL, NULL, 1),
(23, 1, NULL, NULL, NULL, 1),
(21, 1, NULL, NULL, NULL, 1),
(36, 1, NULL, NULL, NULL, 1),
(31, 1, NULL, NULL, NULL, 1),
(35, 1, NULL, NULL, NULL, 1),
(38, 1, NULL, NULL, NULL, 1),
(24, 1, NULL, NULL, NULL, 1),
(29, 1, NULL, NULL, NULL, 1),
(32, 1, NULL, NULL, NULL, 1),
(39, 1, NULL, NULL, NULL, 1),
(34, 1, NULL, NULL, NULL, 2),
(22, 1, NULL, NULL, NULL, 2),
(28, 1, NULL, NULL, NULL, 2),
(23, 1, NULL, NULL, NULL, 2),
(21, 1, NULL, NULL, NULL, 2),
(36, 1, NULL, NULL, NULL, 2),
(31, 1, NULL, NULL, NULL, 2),
(35, 1, NULL, NULL, NULL, 2),
(38, 1, NULL, NULL, NULL, 2),
(24, 1, NULL, NULL, NULL, 2),
(29, 1, NULL, NULL, NULL, 2),
(32, 1, NULL, NULL, NULL, 2),
(39, 1, NULL, NULL, NULL, 2),
(34, 1, NULL, NULL, NULL, 3),
(22, 1, NULL, NULL, NULL, 3),
(28, 1, NULL, NULL, NULL, 3),
(23, 1, NULL, NULL, NULL, 3),
(21, 1, NULL, NULL, NULL, 3),
(36, 1, NULL, NULL, NULL, 3),
(31, 1, NULL, NULL, NULL, 3),
(35, 1, NULL, NULL, NULL, 3),
(38, 1, NULL, NULL, NULL, 3),
(24, 1, NULL, NULL, NULL, 3),
(29, 1, NULL, NULL, NULL, 3),
(32, 1, NULL, NULL, NULL, 3),
(39, 1, NULL, NULL, NULL, 3),
(34, 1, NULL, NULL, NULL, 4),
(22, 1, NULL, NULL, NULL, 4),
(28, 1, NULL, NULL, NULL, 4),
(23, 1, NULL, NULL, NULL, 4),
(21, 1, NULL, NULL, NULL, 4),
(36, 1, NULL, NULL, NULL, 4),
(31, 1, NULL, NULL, NULL, 4),
(35, 1, NULL, NULL, NULL, 4),
(38, 1, NULL, NULL, NULL, 4),
(24, 1, NULL, NULL, NULL, 4),
(29, 1, NULL, NULL, NULL, 4),
(32, 1, NULL, NULL, NULL, 4),
(39, 1, NULL, NULL, NULL, 4),
(34, 1, NULL, NULL, NULL, 5),
(22, 1, NULL, NULL, NULL, 5),
(28, 1, NULL, NULL, NULL, 5),
(23, 1, NULL, NULL, NULL, 5),
(21, 1, NULL, NULL, NULL, 5),
(36, 1, NULL, NULL, NULL, 5),
(31, 1, NULL, NULL, NULL, 5),
(35, 1, NULL, NULL, NULL, 5),
(38, 1, NULL, NULL, NULL, 5),
(24, 1, NULL, NULL, NULL, 5),
(29, 1, NULL, NULL, NULL, 5),
(32, 1, NULL, NULL, NULL, 5),
(39, 1, NULL, NULL, NULL, 5),
(34, 1, NULL, NULL, NULL, 6),
(22, 1, NULL, NULL, NULL, 6),
(28, 1, NULL, NULL, NULL, 6),
(23, 1, NULL, NULL, NULL, 6),
(21, 1, NULL, NULL, NULL, 6),
(36, 1, NULL, NULL, NULL, 6),
(31, 1, NULL, NULL, NULL, 6),
(35, 1, NULL, NULL, NULL, 6),
(38, 1, NULL, NULL, NULL, 6),
(24, 1, NULL, NULL, NULL, 6),
(29, 1, NULL, NULL, NULL, 6),
(32, 1, NULL, NULL, NULL, 6),
(39, 1, NULL, NULL, NULL, 6),
(34, 1, NULL, NULL, NULL, 7),
(22, 1, NULL, NULL, NULL, 7),
(28, 1, NULL, NULL, NULL, 7),
(23, 1, NULL, NULL, NULL, 7),
(21, 1, NULL, NULL, NULL, 7),
(36, 1, NULL, NULL, NULL, 7),
(31, 1, NULL, NULL, NULL, 7),
(35, 1, NULL, NULL, NULL, 7),
(38, 1, NULL, NULL, NULL, 7),
(24, 1, NULL, NULL, NULL, 7),
(29, 1, NULL, NULL, NULL, 7),
(39, 1, NULL, NULL, NULL, 7),
(30, 1, NULL, NULL, NULL, 2),
(30, 1, NULL, NULL, NULL, 3),
(30, 1, NULL, NULL, NULL, 4),
(25, 1, NULL, NULL, NULL, 4),
(37, 1, NULL, NULL, NULL, 5),
(27, 1, NULL, NULL, NULL, 5),
(33, 1, NULL, NULL, NULL, 7),
(26, 1, NULL, NULL, NULL, 7);
/*!40000 ALTER TABLE `todos` ENABLE KEYS */;

-- Listage des données de la table csunvb_csu.users : ~13 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`firstname`, `lastname`, `initials`, `password`, `admin`, `firstconnect`, `email`, `mobileNumber`, `number`) VALUES
	('Michelle', 'Dutoit', 'MDT', '$2y$10$i0cgyQlhtTl4Gp1eHX1GK.37umWwI9mqWsXHqTQLjFWIyt5e7J6nS', 0, 0, NULL, NULL, NULL),
	('Antonio', 'Casaburi', 'ACI', '$2y$10$NtDXutN9baamLrMugoAdAODxW5ot9.ImKn9NomZNMZocELkymDFvC', 1, 0, NULL, NULL, NULL),
	('Xavier', 'Carrel', 'XCL', '$2y$10$QcssFUbiDCWC.1ggh3UYOukKcN2zqYF/LuraET75yLNMHU1kPNqfa', 1, 0, NULL, NULL, NULL),
	('Thierry', 'Billieux', 'TBX', '$2y$10$KOto6XQdNqRZjoK.yXNNZ.29ycB311mHI.QM3DNJlVyoZRPFgNPbS', 1, 0, NULL, NULL, NULL),
	('Philippe', 'Michel', 'PML', '$2y$10$2VfVqMAibraMuJWzMLSiLeBDXOnM9Lig7uapBb2iToqiFhylytM2O', 0, 0, NULL, NULL, NULL),
	('Laurent', 'Pedroli', 'LPI', '$2y$10$ARMvzj7acmGDIzoBBNRghObQLpSf3FUKm7nN4n8MpranEVlHOq.eq', 0, 0, NULL, NULL, NULL),
	('Damaris', 'Bourgeois', 'DMS', '$2y$10$enagKYdNGrztWs1pHSLB/.QaupoFkHc9hOCa9LoyjwWZpGvlKtYZ6', 0, 1, NULL, NULL, NULL),
	('Laurent', 'Scheurer', 'LSR', '$2y$10$yyM/oFu8x.3Sfqrl4WrJUuVuTHVO/QDWAsm/dvco715c8ph1qk1Om', 0, 0, NULL, NULL, NULL),
	('Galien', 'Wolfer', 'GWR', '$2y$10$wPiLR73utWWTt1DajuAQTuG50lcJFkemE9IvEgez16Ykau0p3L3Ca', 0, 1, NULL, NULL, NULL),
	('Damaris ', 'Bourgeois', 'DBS', '$2y$10$3Cdjk8G095JgQjPqjZP6l.uFrbkF0/SF65UHCRZ/BKwdStrCLOXlK', 0, 0, NULL, NULL, NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
