-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 02 mai 2022 à 13:43
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_histoire_arjo_pellegrin`
--
CREATE DATABASE IF NOT EXISTS `projet_histoire_arjo_pellegrin` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `projet_histoire_arjo_pellegrin`;

-- --------------------------------------------------------

--
-- Structure de la table `choix`
--

CREATE TABLE `choix` (
  `id_page` varchar(11) NOT NULL,
  `id_page_cible` varchar(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `contenu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `choix`
--

INSERT INTO `choix` (`id_page`, `id_page_cible`, `id_hist`, `contenu`) VALUES
('0', 'A1', 13, 'h1'),
('0', 'A2', 13, 'ch2'),
('0', 'A3', 13, 'ch3'),
('A1', 'A1B1', 13, 'chx1'),
('A1', 'A1B2', 13, 'chx2'),
('A1', 'A1B3', 13, 'FIN'),
('A1B1', 'A1B1C1', 13, 'kjdhzqkjdq'),
('A1B1', 'A1B1C2', 13, 'FIN'),
('A1B1', 'A1B1C3', 13, 'jsfhsjf'),
('A1B2', 'A1B2C1', 13, 'FIN'),
('A1B2', 'A1B2C2', 13, 'ch2'),
('A1B2', 'A1B2C3', 13, 'ch3'),
('A2', 'A2B1', 13, 'hjbesdb'),
('A2', 'A2B2', 13, 'hejhdsd'),
('A2', 'A2B3', 13, 'FIN'),
('A3', 'A3B1', 13, 'FIN'),
('A3', 'A3B2', 13, 'fejkjfsf'),
('A3', 'A3B3', 13, 'uizdskjd');

-- --------------------------------------------------------

--
-- Structure de la table `histoire`
--

CREATE TABLE `histoire` (
  `id_hist` int(11) NOT NULL,
  `nom_hist` varchar(70) NOT NULL,
  `illustration` varchar(50) NOT NULL,
  `synopsis` varchar(300) NOT NULL,
  `id_createur` int(11) NOT NULL,
  `nb_fois_jouee` int(11) DEFAULT 0,
  `nb_reussites` int(11) DEFAULT 0,
  `nb_morts` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `histoire`
--

INSERT INTO `histoire` (`id_hist`, `nom_hist`, `illustration`, `synopsis`, `id_createur`, `nb_fois_jouee`, `nb_reussites`, `nb_morts`) VALUES
(1, 'Une première histoire', 'histoire1.jpg', 'Un premier test d\'histoire à afficher qui va conditionner la suite de notre site ...', 1, 0, 0, 0),
(13, 'Deuxieme test', 'image_accueil_deuxieme test.jpg', 'feizofjzeklkzlef                                        ', 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `hist_jouee`
--

CREATE TABLE `hist_jouee` (
  `id_hist` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `choix_eff` varchar(20) NOT NULL,
  `nb_pts_vie` int(11) NOT NULL,
  `type_fin` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `page_hist`
--

CREATE TABLE `page_hist` (
  `id_page` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `id_hist` int(11) NOT NULL,
  `para_1` varchar(600) COLLATE utf8_unicode_ci NOT NULL,
  `para_2` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `para_3` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `para_4` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `para_5` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_1` varchar(600) COLLATE utf8_unicode_ci NOT NULL,
  `img_2` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_3` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_4` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_5` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `page_hist`
--

INSERT INTO `page_hist` (`id_page`, `id_hist`, `para_1`, `para_2`, `para_3`, `para_4`, `para_5`, `img_1`, `img_2`, `img_3`, `img_4`, `img_5`) VALUES
('0', 13, 'hbdkjqldjkjdd', '', '', '', '', 'img_13_0_1.jpg', '', '', '', ''),
('A1', 13, 'jsjfksfkls', '', '', '', '', '', '', '', '', ''),
('A1B1', 13, '   ', '', '', '', '', 'img_13_a1b1_1.jpg', '', '', '', ''),
('A1B2', 13, 'kjhdzmldklq', '', '', '', '', '', '', '', '', ''),
('A2', 13, 'jhbdsfbsdjd', '', '', '', '', 'img_13_a2_1.jpg', '', '', '', ''),
('A3', 13, 'djsdkjsd;,n', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(50) NOT NULL,
  `est_admin` tinyint(1) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `est_admin`, `pseudo`, `mdp`) VALUES
(1, 1, 'correcteur_admin', 'mdp_correcteur_1234'),
(2, 0, 'correcteur', 'mdp_correcteur_1234');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `choix`
--
ALTER TABLE `choix`
  ADD PRIMARY KEY (`id_page`,`id_page_cible`,`id_hist`) USING BTREE;

--
-- Index pour la table `histoire`
--
ALTER TABLE `histoire`
  ADD PRIMARY KEY (`id_hist`);

--
-- Index pour la table `hist_jouee`
--
ALTER TABLE `hist_jouee`
  ADD PRIMARY KEY (`id_user`,`id_hist`);

--
-- Index pour la table `page_hist`
--
ALTER TABLE `page_hist`
  ADD PRIMARY KEY (`id_page`,`id_hist`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `histoire`
--
ALTER TABLE `histoire`
  MODIFY `id_hist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
