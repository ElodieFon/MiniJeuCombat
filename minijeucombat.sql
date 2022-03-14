-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 04 mars 2022 à 16:53
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

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
  `type` enum('magicien','guerrier') NOT NULL,
  `atout` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `personnages`
--

INSERT INTO `personnages` (`id`, `nom`, `degats`, `dodo`, `type`, `atout`) VALUES
(16, 'nounours4', 3, 0, 'guerrier', 4),
(20, 'magicat', 5, 0, 'magicien', 4),
(18, 'nounours2', 2, 1646407085, 'guerrier', 4),
(21, 'calis', 0, NULL, 'magicien', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
