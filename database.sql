-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 28 avr. 2023 à 11:28
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sebblog`
--
CREATE DATABASE IF NOT EXISTS `sebblog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sebblog`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `idArticle` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `creationDate` date NOT NULL,
  `updateDate` date NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `idArticleStatus` int(11) NOT NULL,
  `idMember` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `articlestatus`
--

CREATE TABLE `articlestatus` (
  `idArticleStatus` int(11) NOT NULL,
  `name` enum('Published','Hidden') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `articlestatus`
--

INSERT INTO `articlestatus` (`idArticleStatus`, `name`) VALUES
(1, 'Published'),
(2, 'Hidden');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `idComment` int(11) NOT NULL,
  `content` text NOT NULL,
  `creationDate` date NOT NULL,
  `idMember` int(11) NOT NULL,
  `idCommentStatus` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `commentstatus`
--

CREATE TABLE `commentstatus` (
  `idCommentStatus` int(11) NOT NULL,
  `name` enum('Validated','Invalidated','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `commentstatus`
--

INSERT INTO `commentstatus` (`idCommentStatus`, `name`) VALUES
(1, 'Validated'),
(2, 'Invalidated'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Structure de la table `hash`
--

CREATE TABLE `hash` (
  `idHash` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `idMember` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `logincredentials`
--

CREATE TABLE `logincredentials` (
  `idLoginCredentials` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idMember` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `idMember` int(11) NOT NULL,
  `registrationDate` date NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `idRole` int(11) NOT NULL,
  `idLoginCredentials` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `name` enum('Administrator','Member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`idRole`, `name`) VALUES
(1, 'Administrator'),
(2, 'Member');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`idArticle`),
  ADD KEY `Article_ArticleStatus0_FK` (`idArticleStatus`),
  ADD KEY `Article_Member1_FK` (`idMember`);

--
-- Index pour la table `articlestatus`
--
ALTER TABLE `articlestatus`
  ADD PRIMARY KEY (`idArticleStatus`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `Comment_Member0_FK` (`idMember`),
  ADD KEY `Comment_CommentStatus1_FK` (`idCommentStatus`),
  ADD KEY `Comment_Article2_FK` (`idArticle`);

--
-- Index pour la table `commentstatus`
--
ALTER TABLE `commentstatus`
  ADD PRIMARY KEY (`idCommentStatus`);

--
-- Index pour la table `hash`
--
ALTER TABLE `hash`
  ADD PRIMARY KEY (`idHash`),
  ADD KEY `Hash_Member0_FK` (`idMember`);

--
-- Index pour la table `logincredentials`
--
ALTER TABLE `logincredentials`
  ADD PRIMARY KEY (`idLoginCredentials`),
  ADD UNIQUE KEY `LoginCredentials_Member0_AK` (`idMember`);

--
-- Index pour la table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`idMember`),
  ADD UNIQUE KEY `Member_LoginCredentials0_AK` (`idLoginCredentials`),
  ADD KEY `Member_Role0_FK` (`idRole`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `idArticle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `articlestatus`
--
ALTER TABLE `articlestatus`
  MODIFY `idArticleStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentstatus`
--
ALTER TABLE `commentstatus`
  MODIFY `idCommentStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `hash`
--
ALTER TABLE `hash`
  MODIFY `idHash` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `logincredentials`
--
ALTER TABLE `logincredentials`
  MODIFY `idLoginCredentials` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `idMember` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `Article_ArticleStatus0_FK` FOREIGN KEY (`idArticleStatus`) REFERENCES `articlestatus` (`idArticleStatus`),
  ADD CONSTRAINT `Article_Member1_FK` FOREIGN KEY (`idMember`) REFERENCES `member` (`idMember`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `Comment_Article2_FK` FOREIGN KEY (`idArticle`) REFERENCES `article` (`idArticle`),
  ADD CONSTRAINT `Comment_CommentStatus1_FK` FOREIGN KEY (`idCommentStatus`) REFERENCES `commentstatus` (`idCommentStatus`),
  ADD CONSTRAINT `Comment_Member0_FK` FOREIGN KEY (`idMember`) REFERENCES `member` (`idMember`);

--
-- Contraintes pour la table `hash`
--
ALTER TABLE `hash`
  ADD CONSTRAINT `Hash_Member0_FK` FOREIGN KEY (`idMember`) REFERENCES `member` (`idMember`);

--
-- Contraintes pour la table `logincredentials`
--
ALTER TABLE `logincredentials`
  ADD CONSTRAINT `LoginCredentials_Member0_FK` FOREIGN KEY (`idMember`) REFERENCES `member` (`idMember`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `Member_LoginCredentials1_FK` FOREIGN KEY (`idLoginCredentials`) REFERENCES `logincredentials` (`idLoginCredentials`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Member_Role0_FK` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
