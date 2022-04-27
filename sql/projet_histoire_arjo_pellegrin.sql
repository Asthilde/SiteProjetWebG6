-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 27 avr. 2022 à 10:18
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

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

-- --------------------------------------------------------

--
-- Structure de la table `choix`
--

CREATE TABLE `choix` (
  `id_page` int(11) NOT NULL,
  `id_page_cible` int(11) NOT NULL,
  `contenu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `nb_fois_jouee` int(11) DEFAULT NULL,
  `nb_reussites` int(11) DEFAULT NULL,
  `nb_morts` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `histoire`
--

INSERT INTO `histoire` (`id_hist`, `nom_hist`, `illustration`, `synopsis`, `id_createur`, `nb_fois_jouee`, `nb_reussites`, `nb_morts`) VALUES
(2, 'Zoubi dans la forêt', '', 'Bienvenue sur la planète Ziblub. A des années lumières du système solaire, ce monde abrite une civilisation pacifiste et bienveillante de grenouilles extraterrestres, vivant en parfaite harmonie avec l’écosystème environnant. Le rêve quoi. Ou presque.\r\n', 1, NULL, NULL, NULL);

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
-- Structure de la table `page`
--

CREATE TABLE `page` (
  `id_page` int(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `para_1` varchar(600) NOT NULL,
  `para_2` varchar(600) DEFAULT NULL,
  `para_3` varchar(600) DEFAULT NULL,
  `para_4` varchar(600) DEFAULT NULL,
  `para_5` varchar(600) DEFAULT NULL,
  `img_1` varchar(600) NOT NULL,
  `img_2` varchar(600) DEFAULT NULL,
  `img_3` varchar(600) DEFAULT NULL,
  `img_4` varchar(600) DEFAULT NULL,
  `img_5` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id_page`, `id_hist`, `para_1`, `para_2`, `para_3`, `para_4`, `para_5`, `img_1`, `img_2`, `img_3`, `img_4`, `img_5`) VALUES
(1, 2, 'paragraphe 0', NULL, NULL, NULL, NULL, 'aboutyou12.jpg', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `page_hist`
--

CREATE TABLE `page_hist` (
  `id_page` int(11) NOT NULL,
  `id_hist` int(11) NOT NULL,
  `para_1` varchar(500) NOT NULL,
  `para_2` varchar(500) DEFAULT NULL,
  `para_3` varchar(500) DEFAULT NULL,
  `para_4` varchar(500) DEFAULT NULL,
  `para_5` varchar(500) DEFAULT NULL,
  `img_1` varchar(100) NOT NULL,
  `img_2` varchar(100) DEFAULT NULL,
  `img_3` varchar(100) DEFAULT NULL,
  `img_4` varchar(100) DEFAULT NULL,
  `img_5` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `page_hist`
--

INSERT INTO `page_hist` (`id_page`, `id_hist`, `para_1`, `para_2`, `para_3`, `para_4`, `para_5`, `img_1`, `img_2`, `img_3`, `img_4`, `img_5`) VALUES
(2, 2, 'paragraphe début 0', NULL, NULL, NULL, NULL, 'aboutyou12.jpg', NULL, NULL, NULL, NULL);

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
(2, 0, 'correcteur', 'mdp_correcteur_1234'),
(5, 0, 'juju', 'bubuffalo');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `choix`
--
ALTER TABLE `choix`
  ADD PRIMARY KEY (`id_page`,`id_page_cible`);

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
-- Index pour la table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id_page`);

--
-- Index pour la table `page_hist`
--
ALTER TABLE `page_hist`
  ADD PRIMARY KEY (`id_page`);

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
  MODIFY `id_hist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `page_hist`
--
ALTER TABLE `page_hist`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
