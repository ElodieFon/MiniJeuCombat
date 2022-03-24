-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 24 mars 2022 à 12:56
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `minijeucombat`
--

-- --------------------------------------------------------

--
-- Structure de la table `personnages`
--

DROP TABLE IF EXISTS `personnages`;
CREATE TABLE IF NOT EXISTS `personnages` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `degats` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `dodo` int(4) UNSIGNED DEFAULT '0',
  `type` varchar(100) NOT NULL,
  `atout` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `lvl` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `exp` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `nbCoup` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `dateCoup` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personnages`
--

INSERT INTO `personnages` (`id`, `nom`, `degats`, `dodo`, `type`, `atout`, `lvl`, `exp`, `nbCoup`, `dateCoup`) VALUES
(34, 'clis', 0, NULL, 'magicien', 1, 1, 0, 0, NULL),
(33, 'chasseur', 60, 0, 'chasseur', 0, 1, 0, 0, NULL),
(32, 'guerrier', 91, 0, 'guerrier', 4, 1, 0, 0, NULL),
(30, 'magicien', 65, 1647531725, 'magicien', 0, 1, 0, 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
