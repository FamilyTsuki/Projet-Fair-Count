-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 11 déc. 2025 à 13:18
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fair count`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `type`) VALUES
(1, 'Transport'),
(2, 'Logement'),
(3, 'Nourriture'),
(4, 'Sorties'),
(5, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `paid_by_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_expense_payer` (`paid_by_id`),
  KEY `fk_expense_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `amount`, `date`, `created_at`, `paid_by_id`, `category_id`) VALUES
(1, 'Essence Allée', 60.00, '2025-12-11', '2025-12-11 10:33:04', 1, 1),
(2, 'Courses Supermarché', 90.00, '2025-12-11', '2025-12-11 10:33:04', 2, 3),
(3, 'Bières Bar', 20.00, '2025-12-11', '2025-12-11 10:33:04', 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `expense_participants`
--

DROP TABLE IF EXISTS `expense_participants`;
CREATE TABLE IF NOT EXISTS `expense_participants` (
  `expense_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`expense_id`,`user_id`),
  KEY `fk_participant_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `expense_participants`
--

INSERT INTO `expense_participants` (`expense_id`, `user_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(3, 2),
(1, 3),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `reimbursements`
--

DROP TABLE IF EXISTS `reimbursements`;
CREATE TABLE IF NOT EXISTS `reimbursements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `user_from_id` int NOT NULL,
  `user_to_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reimb_from` (`user_from_id`),
  KEY `fk_reimb_to` (`user_to_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reimbursements`
--

INSERT INTO `reimbursements` (`id`, `amount`, `date`, `user_from_id`, `user_to_id`) VALUES
(1, 15.50, '2025-12-10', 1, 2),
(2, 30.00, '2025-12-11', 2, 3),
(3, 5.75, '2025-12-11', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `created_at`) VALUES
(1, 'alice@gmail.com', 'password', 'Alice', '2025-12-11 10:33:04'),
(2, 'bob@hotmail.com', '1234', 'Bob', '2025-12-11 10:33:04'),
(3, 'charlie@gmail.com', 'abcdefg', 'Charlie', '2025-12-11 10:33:04');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `fk_expense_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_expense_payer` FOREIGN KEY (`paid_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `expense_participants`
--
ALTER TABLE `expense_participants`
  ADD CONSTRAINT `fk_participant_expense` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_participant_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reimbursements`
--
ALTER TABLE `reimbursements`
  ADD CONSTRAINT `fk_reimb_from` FOREIGN KEY (`user_from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reimb_to` FOREIGN KEY (`user_to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
