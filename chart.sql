-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 16 nov. 2022 à 11:34
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chart`
--

-- --------------------------------------------------------

--
-- Structure de la table `grandeur`
--

CREATE TABLE `grandeur` (
  `id` int(11) NOT NULL,
  `temp` float NOT NULL,
  `press` float NOT NULL,
  `gaz` float NOT NULL,
  `alt` float NOT NULL,
  `heure` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `grandeur`
--

INSERT INTO `grandeur` (`id`, `temp`, `press`, `gaz`, `alt`, `heure`) VALUES
(1, 23.5, 101441, 1915, -9.4, '2022-11-16 09:55:45'),
(2, 23.5, 101441, 1915, -9.4, '2022-11-16 09:55:45'),
(3, 23.5, 101441, 1915, -9.4, '2022-11-16 09:55:45'),
(4, 23.5, 101441, 1915, -9.4, '2022-11-16 09:55:45'),
(5, 23.6, 101442, 1935, -9.57, '2022-11-16 09:55:54'),
(6, 23.6, 101442, 1935, -9.57, '2022-11-16 09:55:54'),
(7, 23.6, 101442, 1935, -9.57, '2022-11-16 09:55:54'),
(8, 23.6, 101442, 1935, -9.57, '2022-11-16 09:55:54');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `grandeur`
--
ALTER TABLE `grandeur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `grandeur`
--
ALTER TABLE `grandeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
