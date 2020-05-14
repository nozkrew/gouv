-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 14 mai 2020 à 13:58
-- Version du serveur :  5.7.28
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `renta_immo`
--

-- --------------------------------------------------------

--
-- Structure de la table `regions`
--

DROP TABLE IF EXISTS `regions`;
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `regions_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `regions`
--

INSERT INTO `regions` (`id`, `code`, `name`, `slug`) VALUES
(1, '01', 'Guadeloupe', 'guadeloupe'),
(2, '02', 'Martinique', 'martinique'),
(3, '03', 'Guyane', 'guyane'),
(4, '04', 'La Réunion', 'la reunion'),
(5, '06', 'Mayotte', 'mayotte'),
(6, '11', 'Île-de-France', 'ile de france'),
(7, '24', 'Centre-Val de Loire', 'centre val de loire'),
(8, '27', 'Bourgogne-Franche-Comté', 'bourgogne franche comte'),
(9, '28', 'Normandie', 'normandie'),
(10, '32', 'Hauts-de-France', 'hauts de france'),
(11, '44', 'Grand Est', 'grand est'),
(12, '52', 'Pays de la Loire', 'pays de la loire'),
(13, '53', 'Bretagne', 'bretagne'),
(14, '75', 'Nouvelle-Aquitaine', 'nouvelle aquitaine'),
(15, '76', 'Occitanie', 'occitanie'),
(16, '84', 'Auvergne-Rhône-Alpes', 'auvergne rhone alpes'),
(17, '93', 'Provence-Alpes-Côte d\'Azur', 'provence alpes cote dazur'),
(18, '94', 'Corse', 'corse'),
(19, 'COM', 'Collectivités d\'Outre-Mer', 'collectivites doutre mer');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
