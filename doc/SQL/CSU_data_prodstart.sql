-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 26 jan. 2021 à 10:41
-- Version du serveur :  5.7.32-35-log
-- Version de PHP : 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `csunvb_csu`
--

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `firstname`, `lastname`, `initials`, `password`, `admin`, `firstconnect`, `email`, `mobileNumber`) VALUES
(1,'Admin','istrateur','ANN','$2y$10$QFeM.bl6VdZdGXJaPvSodeCKPRvFJZgmYeU/ZVnYt0p/LbZDNuvhy',1,1,NULL,NULL); -- Password initial = 'Pa$$w0rd'
INSERT INTO `users` (`id`, `firstname`, `lastname`, `initials`, `password`, `admin`, `firstconnect`, `email`, `mobileNumber`) VALUES
(2, 'Michelle', 'Dutoit', 'MDT', '$2y$10$i0cgyQlhtTl4Gp1eHX1GK.37umWwI9mqWsXHqTQLjFWIyt5e7J6nS', 0, 0, NULL, NULL),
(3, 'Antonio', 'Casaburi', 'ACI', '$2y$10$NtDXutN9baamLrMugoAdAODxW5ot9.ImKn9NomZNMZocELkymDFvC', 1, 0, 'antonio.casaburi@csu-nvb.ch', NULL),
(4, 'Xavier', 'Carrel', 'XCL', '$2y$10$QcssFUbiDCWC.1ggh3UYOukKcN2zqYF/LuraET75yLNMHU1kPNqfa', 1, 0, 'xavier.carrel@cpnv.ch', NULL),
(5, 'Thierry', 'Billieux', 'TBX', '$2y$10$KOto6XQdNqRZjoK.yXNNZ.29ycB311mHI.QM3DNJlVyoZRPFgNPbS', 1, 0, 'thierry.billieux@csu-nvb.ch', NULL),
(6, 'Michael', 'Gogniat', 'MGT', '$2y$10$6JjX6WpKdgRZ44PQj.5C2.9mO2CeAekcKngNmvRh9ttX9mSyO8LGu', 1, 0, 'michael.gogniat@cpnv.ch', NULL),
(7, 'Philippe', 'Michel', 'PML', '$2y$10$2VfVqMAibraMuJWzMLSiLeBDXOnM9Lig7uapBb2iToqiFhylytM2O', 0, 0, NULL, NULL),
(8, 'Laurent', 'Pedroli', 'LPI', '$2y$10$ARMvzj7acmGDIzoBBNRghObQLpSf3FUKm7nN4n8MpranEVlHOq.eq', 0, 0, NULL, NULL),
(9, 'Damaris', 'Bourgeois', 'DMS', '$2y$10$enagKYdNGrztWs1pHSLB/.QaupoFkHc9hOCa9LoyjwWZpGvlKtYZ6', 0, 1, NULL, NULL),
(10, 'Laurent', 'Scheurer', 'LSR', '$2y$10$yyM/oFu8x.3Sfqrl4WrJUuVuTHVO/QDWAsm/dvco715c8ph1qk1Om', 0, 0, NULL, NULL),
(11, 'Galien', 'Wolfer', 'GWR', '$2y$10$wPiLR73utWWTt1DajuAQTuG50lcJFkemE9IvEgez16Ykau0p3L3Ca', 0, 1, NULL, NULL),
(12, 'Damaris ', 'Bourgeois', 'DBS', '$2y$10$3Cdjk8G095JgQjPqjZP6l.uFrbkF0/SF65UHCRZ/BKwdStrCLOXlK', 0, 0, NULL, NULL),
(13, 'Théo', 'Gautier', 'TGR', '$2y$10$fd/bS2LnrXKOsy9S2h9y9Ok/7tMbV6Gi3gaugo7qrkPZ.pjuHvAqi', 0, 0, 'Theo.Gautier@cpnv.ch', NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Déchargement des données de la table `drugsheets`
--

INSERT INTO `drugsheets` (`id`, `week`, `status_id`, `base_id`) VALUES
(1, 2122, 3, 1),
(2, 2122, 3, 2),
(3, 2122, 3, 3),
(4, 2122, 3, 4),
(5, 2122, 3, 5);

--
-- Déchargement des données de la table `shiftmodels`
--

INSERT INTO `shiftmodels` (`id`, `name`, `suggested`) VALUES
(1, 'Initial', 1);

-- --------------------------------------------------------
--
-- Déchargement des données de la table `shiftmodel_has_shiftaction`
--

INSERT INTO `shiftmodel_has_shiftaction` (`shiftaction_id`, `shiftmodel_id`) SELECT id, 1 FROM `shiftactions`;

--
-- Déchargement des données de la table `shiftsheets`
--

INSERT INTO `shiftsheets` (`date`, `shiftmodel_id`, `base_id`, `status_id`, `closeBy`) VALUES
('2021-06-01 00:00:00', 1, 2, 3, NULL);

--
-- Déchargement des données de la table `todosheets`
--

INSERT INTO `todosheets` (`id`, `week`, `status_id`, `base_id`, `template_name`) VALUES
(1, 2122, 3, 2, NULL);

--
-- Déchargement des données de la table `todos`
--

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


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
