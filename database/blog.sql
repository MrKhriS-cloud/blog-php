-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 04 mars 2025 à 11:55
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(2, 'test1', 'pldjfhgfhfhghghfg', 'uploads/rediger-un-article.jpg', '2025-03-04 00:35:15'),
(3, 'test2', 'vchbfdfjgdgfhghghf', 'uploads/rediger-un-article.jpg', '2025-03-04 01:15:46'),
(4, 'test3', 'blablablabladegfhghghg', 'uploads/rediger-un-article.jpg', '2025-03-04 01:23:08'),
(5, 'test4', 'nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn', 'uploads/rediger-un-article.jpg', '2025-03-04 01:23:35'),
(6, 'test5', 'gfhgfhgjjjjjjjjjjjjjjjjjjtqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq', 'uploads/rediger-un-article.jpg', '2025-03-04 01:24:37'),
(7, 'test6', 'qppqpqoqiohshsblablablabla', 'uploads/rediger-un-article.jpg', '2025-03-04 01:25:11'),
(9, 'test7', 'pdzfkspfkdsfdfdfdf\r\nzerfdggfgfgf\r\nghgththjtghjg\r\n\r\nertyrhytuyujytutyt', 'uploads/rediger-un-article.jpg', '2025-03-04 08:35:03'),
(12, 'test8', 'dddddddddccccccccccccccccccddddddddddd', 'uploads/rediger-un-article.jpg', '2025-03-04 10:25:21'),
(13, 'test9', 'ma tofzzdz*\r\n\r\nsdfsfs', 'uploads/img cv.jpg', '2025-03-04 10:28:22');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `reset_token`, `reset_token_expires`) VALUES
(5, 'admin', 'a71257905@gmail.com', '$2y$10$SlWzvys8lOVawBhpoGiGPeCwI4rZLjlvaoPXYVJrcmr5ixDGEw8V.', '2025-03-03 22:49:03', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
