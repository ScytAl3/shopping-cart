-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 juil. 2020 à 09:47
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_gestion_panier`
--

-- --------------------------------------------------------

--
-- Structure de la table `lignes_commande`
--

DROP TABLE IF EXISTS `lignes_commande`;
CREATE TABLE IF NOT EXISTS `lignes_commande` (
  `ligneCmdId` int(11) NOT NULL AUTO_INCREMENT,
  `paniersId` int(11) NOT NULL,
  `produitsId` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prixTotal` decimal(5,2) NOT NULL,
  PRIMARY KEY (`ligneCmdId`),
  KEY `paniersId` (`paniersId`),
  KEY `produitsId` (`produitsId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `paniers`
--

DROP TABLE IF EXISTS `paniers`;
CREATE TABLE IF NOT EXISTS `paniers` (
  `paniersId` int(11) NOT NULL AUTO_INCREMENT,
  `panierUserTemp` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`paniersId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `picturesId` int(11) NOT NULL AUTO_INCREMENT,
  `produitsId` int(11) NOT NULL,
  `pictureFilename` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`picturesId`),
  KEY `produitsId` (`produitsId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `pictures`
--

INSERT INTO `pictures` (`picturesId`, `produitsId`, `pictureFilename`) VALUES
(1, 1, 'affligem.png'),
(2, 2, 'asahi.png'),
(3, 3, 'budweiser.png'),
(4, 4, 'fosters.png'),
(5, 5, 'guinness.png'),
(6, 6, 'heineken.png'),
(7, 7, 'pelforth.png');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `produitsId` int(11) NOT NULL AUTO_INCREMENT,
  `produitsName` varchar(255) NOT NULL,
  `produitsDescription` varchar(255) NOT NULL,
  `produitsQuantite` int(11) NOT NULL,
  `produitsPrix` decimal(5,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `produitavailable` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`produitsId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`produitsId`, `produitsName`, `produitsDescription`, `produitsQuantite`, `produitsPrix`, `created_at`, `produitavailable`) VALUES
(1, 'Produit 01', 'Est at possimus et deserunt. Dicta sed amet ipsum dolorem quam adipisci pariatur.', 99, '87.55', '2020-02-18 13:29:09', 1),
(2, 'Produit 02', 'Qui modi nam consectetur eius quia possimus omnis adipisci. Cupiditate sed sed aut.', 99, '55.25', '2020-02-19 17:59:20', 1),
(3, 'Produit 03', 'Sit dolores maiores voluptates sint.', 99, '25.85', '2020-02-19 18:19:34', 1),
(4, 'Produit 04', 'Maiores similique sit voluptas.', 99, '75.65', '2020-02-20 08:29:18', 1),
(5, 'Produit 05', 'Quasi ipsa est unde illo.', 99, '45.55', '2020-02-20 13:59:58', 1),
(6, 'Produit 06', 'Possimus reprehenderit odit et error.', 99, '48.95', '2020-02-24 15:19:08', 1),
(7, 'Produit 07', 'Excepturi laborum ut voluptates consequuntur adipisci dolores sit iusto.', 99, '84.25', '2020-02-25 11:54:48', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userLastName` varchar(75) NOT NULL,
  `userFirstName` varchar(75) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userSalt` varchar(255) NOT NULL,
  `accountCreated_at` datetime NOT NULL,
  `userRole` varchar(20) NOT NULL DEFAULT 'Member',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `unique_email` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`userId`, `userLastName`, `userFirstName`, `userEmail`, `userPassword`, `userSalt`, `accountCreated_at`, `userRole`) VALUES
(1, 'Doe', 'John', 'j.doe@cci.fr', '54e4feb636204d1e5fcf49fb202946db', 'b7c8cb5b20beb2733470a65bb59722de', '2020-02-20 13:29:09', 'Admin'),
(2, 'Jobs', 'Steve', 'amazing@rip.com', '1f1c153c6717024f825a862901f9c3bc', '476e62fcde5fcaa1e7fc2629da120ce9', '2020-02-20 15:29:09', 'Admin'),
(3, 'Tuttle', 'Archibald', 'harry.tuttle@br.com', '78169d67d449272b6bad1438b75bf4fe', '1641b4d0b9a50afbadb3cedf983c9cd1', '2020-02-21 16:25:49', 'Member'),
(4, 'Bismuth', 'Paul', 'ns-2017@lr.fr', 'b4f56e6dca3905a5b3f4e73058ba2ab2', '5e406044172b4831cf110e63b51f0b47', '2020-02-22 19:15:25', 'Member'),
(5, 'Balkany', 'Patrick', 'la-sante@gouv.fr', '4fcf95ce8284291469466c0b2aecaed8', '61a722aee2cc2e539778622bc7ee7c4d', '2020-02-22 21:09:27', 'Member'),
(6, 'Abagnale', 'Frank', 'catch.me@noop.fr', 'a87f2462177f71232e05bd00f68675ef', '5d969f98d53259fe94d0245eb8d3ac26', '2020-02-22 12:04:49', 'Member');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `lignes_commande`
--
ALTER TABLE `lignes_commande`
  ADD CONSTRAINT `lignes_commande_ibfk_1` FOREIGN KEY (`paniersId`) REFERENCES `paniers` (`paniersId`),
  ADD CONSTRAINT `lignes_commande_ibfk_2` FOREIGN KEY (`produitsId`) REFERENCES `produits` (`produitsId`);

--
-- Contraintes pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`produitsId`) REFERENCES `produits` (`produitsId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
