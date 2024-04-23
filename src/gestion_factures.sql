-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3307
-- Généré le : dim. 10 mars 2024 à 13:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_factures`
--

-- --------------------------------------------------------

--
-- Structure de la table `annual_consumption`
--

CREATE TABLE `annual_consumption` (
  `annual_consumption_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `year` year(4) NOT NULL,
  `total_consumption` decimal(10,2) NOT NULL,
  `Entry_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `annual_consumption`
--

INSERT INTO `annual_consumption` (`annual_consumption_id`, `customer_id`, `year`, `total_consumption`, `Entry_Date`) VALUES
(136, 1, '2023', 360.00, '2023-12-30'),
(137, 2, '2023', 260.00, '2023-12-30'),
(138, 45, '2023', 370.00, '2023-12-30');

-- --------------------------------------------------------

--
-- Structure de la table `consumption`
--

CREATE TABLE `consumption` (
  `consumption_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `monthly_consumption` decimal(10,2) NOT NULL,
  `photo_url` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount_ht` decimal(10,2) DEFAULT NULL,
  `amount_ttc` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `consumption_counter` int(11) DEFAULT NULL,
  `IsValid` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consumption`
--

INSERT INTO `consumption` (`consumption_id`, `customer_id`, `monthly_consumption`, `photo_url`, `date`, `amount_ht`, `amount_ttc`, `status`, `consumption_counter`, `IsValid`) VALUES
(85, 1, 120.00, 'uploads/conteur1.jpg', '2023-11-28', 108.00, 123.12, 'paid', 120, 'Valide'),
(86, 1, 120.00, 'uploads/conteur2.jpg', '2023-12-28', 108.00, 123.12, 'paid', 220, 'Valide'),
(90, 2, 170.00, 'uploads/conteur1.jpg', '2023-11-28', 153.00, 174.42, 'paid', 170, 'Valide'),
(91, 2, 50.00, 'uploads/conteur2.jpg', '2023-12-28', 40.00, 45.60, 'paid', 220, 'Valide'),
(109, 45, 145.00, 'uploads/conteur1.jpg', '2023-11-28', 130.50, 148.77, 'paid', 145, 'Valide'),
(110, 45, 135.00, 'uploads/conteur2.jpg', '2023-12-28', 121.50, 138.51, 'paid', 280, 'Valide'),
(111, 46, 100.00, 'uploads/conteur2.jpg', '2023-11-28', 80.00, 91.20, 'unpaid', 100, 'Valide');

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`, `first_name`, `last_name`, `address`, `phone`) VALUES
(1, 2, 'Abdelhaq', 'Attar', 'Martil', '5555-1235555'),
(2, 3, 'Ilyass', 'Attar', 'Tetouan', '5554-567800'),
(45, 51, 'azeddine', 'allouch', 'martil', '0654789632'),
(46, 52, 'mohamed', 'ahmed', 'hjgfqsd', '065478');

-- --------------------------------------------------------

--
-- Structure de la table `rates`
--

CREATE TABLE `rates` (
  `rate_id` int(11) NOT NULL,
  `consumption_from` int(11) NOT NULL,
  `consumption_to` int(11) NOT NULL,
  `price_per_kwh` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rates`
--

INSERT INTO `rates` (`rate_id`, `consumption_from`, `consumption_to`, `price_per_kwh`) VALUES
(1, 0, 100, 0.80),
(2, 101, 200, 0.90),
(3, 201, 8000, 1.00);

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

CREATE TABLE `reclamations` (
  `reclamation_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `status` varchar(20) DEFAULT 'En attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reclamations`
--

INSERT INTO `reclamations` (`reclamation_id`, `customer_id`, `type`, `description`, `date`, `status`) VALUES
(53, 2, 'ùmlk,nbs,dklmfùvb', 'mùlkJSNDCKJlmù\r\nazdfk,lvnjk,l;sVK?;cqdvk, w', '2024-03-07', 'traiter'),
(54, 45, 'jkhgv', 'bndjnd', '2024-03-10', 'traiter'),
(55, 1, 'Facture', 'llkoiuhygftdgh', '2024-03-10', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'customer');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role_id`) VALUES
(1, 'admin@example.com', '123123', 1),
(2, 'abdelhaq@elattar.com', 'abdelhaq', 2),
(3, 'ilyass@el.com', 'ilyass', 2),
(51, 'azedin@allouch.com', 'azedin', 2),
(52, 'mohamed@md.com', 'ololol', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annual_consumption`
--
ALTER TABLE `annual_consumption`
  ADD PRIMARY KEY (`annual_consumption_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Index pour la table `consumption`
--
ALTER TABLE `consumption`
  ADD PRIMARY KEY (`consumption_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`rate_id`);

--
-- Index pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD PRIMARY KEY (`reclamation_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annual_consumption`
--
ALTER TABLE `annual_consumption`
  MODIFY `annual_consumption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT pour la table `consumption`
--
ALTER TABLE `consumption`
  MODIFY `consumption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `rates`
--
ALTER TABLE `rates`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reclamations`
--
ALTER TABLE `reclamations`
  MODIFY `reclamation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annual_consumption`
--
ALTER TABLE `annual_consumption`
  ADD CONSTRAINT `annual_consumption_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `consumption`
--
ALTER TABLE `consumption`
  ADD CONSTRAINT `consumption_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD CONSTRAINT `reclamations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
