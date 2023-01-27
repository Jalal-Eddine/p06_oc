-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 10:16 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tricks`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230126015313', '2023-01-26 02:53:21', 578);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(1, 'Les grabs'),
(2, 'Les rotations'),
(3, 'Les flips'),
(4, 'Les rotations désaxées'),
(5, 'Les slides'),
(6, 'Les one foot tricks'),
(7, 'Old school');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `trick_id_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `trick_id_id`, `name`) VALUES
(1, 1, '7e2e903504ea2d67681f1822e56316f8.webp'),
(2, 1, '1a1e82eb166673e451c601dea779096b.jpg'),
(3, 2, '08f17ac0de53bf002b2c9a972811d446.jpg'),
(4, 3, '75de5f1861b18791d58d2dc4e82217b9.jpg'),
(5, 3, '9ab8d75f3bebdc19f7038ea8e62bef5a.jpg'),
(6, 3, 'f0e2b276c57a2df72daf4ceef9d9b89e.jpg'),
(7, 3, '84ac5e49cdacfbdb4b20f52c406c0d9e.jpg'),
(8, 4, 'c1896e0ecfa19dd1cfdc83301fe091e6.jpg'),
(9, 4, '46285d8d630a6d1530d819aac294cbf5.jpg'),
(10, 4, 'd8cfdd4b506e33971504f21fe12e85d1.webp'),
(11, 5, '87640807d6523bef880ed2d6bab64cda.jpg'),
(12, 6, '65d1ad8476d919c8962e441126461b55.jpg'),
(13, 7, 'e3da67e73243d4c83d8fd478f7ea5910.jpg'),
(14, 8, 'cae130672ca2faa1d457577327bcec71.jpg'),
(15, 9, 'fba2fcece05e57387582f3362440803a.webp'),
(16, 10, '25f66a40302316f599740140e9d29507.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reset_password_request`
--

INSERT INTO `reset_password_request` (`id`, `user_id`, `selector`, `hashed_token`, `requested_at`, `expires_at`) VALUES
(2, 1, '7hv80oa1MZnArY246X7O', 'Qb/8DFSF5AzsdCkGmi6grcNGxzOIeZaKe5rxGU3BSb4=', '2023-01-26 22:14:53', '2023-01-26 23:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `tricks`
--

CREATE TABLE `tricks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tricks`
--

INSERT INTO `tricks` (`id`, `user_id`, `group_id`, `name`, `description`, `creation_date`, `modification_date`, `slug`) VALUES
(1, 1, 1, 'Muste Grabs', 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »\r\n\r\nIl existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l\'effectuer.\r\nmute : saisie de la carre frontside de la planche entre les deux pieds avec la main avant ;', '2023-01-26 23:19:14', '2023-01-26 23:36:33', 'muste-grabs'),
(2, 1, 1, 'Sad Grap', 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »\r\n\r\nIl existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l\'effectuer\r\n\r\nsad ou melancholie ou style week : saisie de la carre backside de la planche, entre les deux pieds, avec la main avant ;', '2023-01-26 23:49:56', NULL, 'sad-grap'),
(3, 1, 1, 'Indy Grap', 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »\r\n\r\nIl existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l\'effectuer, avec des difficultés variables :\r\nindy : saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière ;', '2023-01-27 08:25:59', NULL, 'indy-grap'),
(4, 1, 1, 'Stalefish Grap', 'stalefish : saisie de la carre backside de la planche entre les deux pieds avec la main arrière ;', '2023-01-27 08:30:42', NULL, 'stalefish-grap'),
(5, 1, 1, 'Tail grab', 'tail grab : saisie de la partie arrière de la planche, avec la main arrière ;', '2023-01-27 08:35:11', NULL, 'tail-grab'),
(6, 1, 2, '360 Rotation', 'On désigne par le mot « rotation » uniquement des rotations horizontales ; les rotations verticales sont des flips. Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal.\r\n360, trois six pour un tour complet ;', '2023-01-27 08:40:32', NULL, '360-rotation'),
(7, 1, 1, 'Front flips', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.', '2023-01-27 08:45:19', '2023-01-27 08:45:29', 'front-flips'),
(8, 1, 3, 'Back flips', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.', '2023-01-27 08:48:45', NULL, 'back-flips'),
(9, 1, 5, 'Tail slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.', '2023-01-27 08:51:08', NULL, 'tail-slide'),
(10, 1, 5, 'Board slide', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.\r\n\r\nOn peut slider avec la planche centrée par rapport à la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en nose slide, c\'est-à-dire l\'avant de la planche sur la barre, ou en tail slide, l\'arrière de la planche sur la barre.', '2023-01-27 08:53:17', NULL, 'board-slide');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `username`, `firstname`, `lastname`, `photo`) VALUES
(1, 'jalaleddine.elhabbazi@gmail.com', '[]', '$2y$13$2CsyfG.leNbdk0SwAEaa1./KdPTuglaS651tdcuZEZiU1rAQLu8n.', 'JalalEddine', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `trick_id_id` int(11) NOT NULL,
  `embed` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `trick_id_id`, `embed`) VALUES
(1, 1, 'https://youtu.be/M5NTCfdObfs'),
(2, 2, 'https://youtu.be/KEdFwJ4SWq4'),
(3, 3, 'https://youtu.be/6yA3XqjTh_w'),
(4, 4, 'https://youtu.be/f9FjhCt_w2U'),
(5, 5, 'https://youtu.be/YAElDqyD-3I'),
(6, 6, 'https://youtu.be/pi1nDmLxMcY'),
(7, 7, 'https://youtu.be/eGJ8keB1-JM'),
(8, 8, 'https://youtu.be/SlhGVnFPTDE'),
(9, 9, 'https://youtu.be/HRNXjMBakwM'),
(10, 10, 'https://youtu.be/12OHPNTeoRs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962AA76ED395` (`user_id`),
  ADD KEY `IDX_5F9E962AB281BE2E` (`trick_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E01FBE6AB46B9EE8` (`trick_id_id`);

--
-- Indexes for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Indexes for table `tricks`
--
ALTER TABLE `tricks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E1D902C15E237E06` (`name`),
  ADD KEY `IDX_E1D902C1A76ED395` (`user_id`),
  ADD KEY `IDX_E1D902C1FE54D947` (`group_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29AA6432B46B9EE8` (`trick_id_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tricks`
--
ALTER TABLE `tricks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5F9E962AB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `FK_E01FBE6AB46B9EE8` FOREIGN KEY (`trick_id_id`) REFERENCES `tricks` (`id`);

--
-- Constraints for table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `FK_E1D902C1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_E1D902C1FE54D947` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `FK_29AA6432B46B9EE8` FOREIGN KEY (`trick_id_id`) REFERENCES `tricks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
