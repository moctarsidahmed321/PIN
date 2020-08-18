-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  lun. 10 août 2020 à 21:27
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
-- Base de données :  `pin`
--
CREATE DATABASE IF NOT EXISTS `pin` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pin`;

-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

DROP TABLE IF EXISTS `intervenant`;
CREATE TABLE IF NOT EXISTS `intervenant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_passage` datetime NOT NULL,
  `sujet` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `biographie` longtext COLLATE utf8mb4_unicode_ci,
  `heure_fin` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervenant`
--

INSERT INTO `intervenant` (`id`, `date_passage`, `sujet`, `nickname`, `contenu`, `biographie`, `heure_fin`) VALUES
(1, '2020-09-01 08:00:00', 'Investigation Numérique', 'Nicolas Dupont', 'L\'investigation numérique ou l\'informatique légale (ou computer forensics en anglais) prend de plus en plus de place dans les enquêtes de police ou judiciaires mais aussi dans des affaires privées. Elle trouve ses sources à la fin des années 70 lorsque les premiers crimes impliquant des ordinateurs apparaissent. Elle évolue dans les années 80 et 90 pour se transformer en industrie dans les années 2000.', 'Chef d\'un laboratoire d\'investigation numérique', '2020-09-01 10:00:00'),
(2, '2020-09-01 11:00:00', 'Jurisprudence', 'Olivier Paul', 'La jurisprudence est donc un instrument indispensable pour le bon fonctionnement de la justice. En effet, elle permet l\'évolution cohérente du droit positif.', 'Juge dans le parquet de Paris', '2020-09-01 13:00:00'),
(3, '2020-09-03 10:00:00', 'Fouilles de données', 'Michel Sala', 'A la frontière entre les statistiques, l’intelligence artificielle et l’informatique, le Data Mining – ou fouille de données – est une discipline qui vise à extraire les informations pertinentes d’un grand ensemble de données.', 'Professeur à la faculté de Montpellier', '2020-09-03 12:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `intervenant_programme`
--

DROP TABLE IF EXISTS `intervenant_programme`;
CREATE TABLE IF NOT EXISTS `intervenant_programme` (
  `intervenant_id` int(11) NOT NULL,
  `programme_id` int(11) NOT NULL,
  PRIMARY KEY (`intervenant_id`,`programme_id`),
  KEY `IDX_F9D9D1F3AB9A1716` (`intervenant_id`),
  KEY `IDX_F9D9D1F362BB7AEE` (`programme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervenant_programme`
--

INSERT INTO `intervenant_programme` (`intervenant_id`, `programme_id`) VALUES
(1, 1),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200810172825', '2020-08-10 17:29:46');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `nouvelles` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_140AB620A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `page`
--

INSERT INTO `page` (`id`, `user_id`, `nouvelles`, `date_creation`, `type`) VALUES
(1, 1, 'Le PIN (Printemps de l’Investigation Numérique) est une association  1901 dont l’objectif est de promouvoir l\'investigation numérique dans les domaines de la justice, de l\'expertise, de l\'enseignement ou tous autres organismes intéressés et organiser ou soutenir des actions de formation auprès de ses adhérents, des experts de Justice, des services de police, de la gendarmerie nationale, des services de la justice, de l\'enseignement ou tous autres organismes intéressés par l\'investigation numérique.  Chaque année, le PIN organise une série de conférences lors d’un congrès.', '2020-08-10 20:25:27', 'presentation'),
(2, 1, 'Le programme général est disponible dans la rubrique programme.', '2020-08-10 20:26:17', 'nouvelle');

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_heure_debut` datetime NOT NULL,
  `date_heure_fin` datetime NOT NULL,
  `nom_programme` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `programme`
--

INSERT INTO `programme` (`id`, `date_heure_debut`, `date_heure_fin`, `nom_programme`) VALUES
(1, '2020-09-01 08:00:00', '2020-09-01 13:00:00', 'Programme 1'),
(2, '2020-09-03 10:00:00', '2020-09-03 12:00:00', 'Programme 2');

-- --------------------------------------------------------

--
-- Structure de la table `programme_user`
--

DROP TABLE IF EXISTS `programme_user`;
CREATE TABLE IF NOT EXISTS `programme_user` (
  `programme_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`programme_id`,`user_id`),
  KEY `IDX_94D3E42462BB7AEE` (`programme_id`),
  KEY `IDX_94D3E424A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `programme_user`
--

INSERT INTO `programme_user` (`programme_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
(1, 'moctarsidahmed321@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$/49ilFb5ZNWF9jTC3.Gn4uvuo6yCllgi/1Li.YZA79SFGleY1Tbte', 'Sid\'ahmed', 'Moctar'),
(2, 'thomasmaurice@gmail.com', '[\"ROLE_USER\"]', '$2y$13$kZrLbMY0JA6eYiZhGjjbfOqiXjpUmqedTv5IuZPa/z6Pz/dtmDPKW', 'Thomas', 'Maurice');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `intervenant_programme`
--
ALTER TABLE `intervenant_programme`
  ADD CONSTRAINT `FK_F9D9D1F362BB7AEE` FOREIGN KEY (`programme_id`) REFERENCES `programme` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F9D9D1F3AB9A1716` FOREIGN KEY (`intervenant_id`) REFERENCES `intervenant` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `FK_140AB620A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `programme_user`
--
ALTER TABLE `programme_user`
  ADD CONSTRAINT `FK_94D3E42462BB7AEE` FOREIGN KEY (`programme_id`) REFERENCES `programme` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_94D3E424A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
