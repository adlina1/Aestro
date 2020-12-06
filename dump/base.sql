-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u1
-- https://www.phpmyadmin.net/
--
-- Host: mysql.info.unicaen.fr:3306
-- Generation Time: Dec 06, 2020 at 08:30 PM
-- Server version: 10.1.44-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-0+deb9u10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `21809174_9`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `species` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `owner` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `species`, `age`, `owner`) VALUES
(1, 'Médor', 'chien', 4, 'Pascal Vanier'),
(2, 'Félix', 'chat', 0, 'Pascal Vanier'),
(3, 'Denver', 'dinosaure', 65000000, 'Jean-Marc Lecarpentier'),
(4, 'Adrien', 'HomoSapiens', 23, 'Adrien Linares'),
(59, 'Roro', 'mammifère', 3, 'Kasenga');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `path` varchar(256) DEFAULT NULL,
  `owner` varchar(256) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(250) DEFAULT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `path`, `owner`, `title`, `author`, `description`) VALUES
(12, '../upload/1606151258.png', 'Adrien Linares', 'La Planète Rouge', 'NASA', 'perspective sur les sommets martiens !\r\n'),
(13, '../upload/1606152797.jpg', 'Adrien Linares', 'CrewDragon Basse Atmosphère', 'SpaceX', 'Crew dragon pour docking vers ISS'),
(30, '../upload/1606197161.jpg', 'Kasenga', 'planétologie', 'wikipédia', 'Représentation partielle du Système solaire (échelles non respectées).'),
(51, '../upload/1607211484.jpg', 'Adrien Linares', 'Astrocliché', 'Adri', 'petit test'),
(52, '../upload/3214422968.jpg', 'Adrien Linares', 'SkyWow', 'Adri', 'milky ways stars landscape');

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `endroit` varchar(255) NOT NULL,
  `latitude` int(11) DEFAULT NULL,
  `longitude` int(11) DEFAULT NULL,
  `owner` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`id`, `nom`, `endroit`, `latitude`, `longitude`, `owner`) VALUES
(4, 'Désert d\'Atacama', 'Chile', 24, 69, 'Pascal Vanier'),
(6, 'Mont Blanc', 'France, Chamonix', 46, 7, 'Adrien Linares'),
(10, 'Mont Kilimandjaro', 'Tanzanie', -3, 37, 'Kasenga');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `statut` varchar(20) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `statut`, `created_at`) VALUES
(1, 'Pascal Vanier', 'vanier', '$2y$10$rROvblsBJjKio4lLupUCWeU4dDXhxCwAvgKXOFLyAtA23kokcYaSW', 'admin', '2020-11-18 14:55:42'),
(2, 'Jean-Marc Lecarpentier', 'lecarpentier', '$2y$10$GkcJ.i/P6uQoZkEFfXo3W.lUAyTu/DfNO06MzQE3L2Goe1IYNAtXK', 'admin', '2020-11-18 14:56:36'),
(4, 'Kasenga', 'Deb', '$2y$10$qm2c41AOodTd3L.VUyZJCupmUjR/fYjT7xWqV8C0YWrLrGMYli2hi', 'user', '2020-11-18 15:53:32'),
(20, '', '', '$2y$10$Aws2I6/ZmFlCZu3JaQPSpu6F99kgagk0rUnvAAFcZAHx4su74p4My', 'user', '2020-11-23 21:53:46'),
(21, 'Adrien Linares', 'adlina', '$2y$10$6PL..wmBFWlTCH733Vx2u.8leJIBIomVIhfW/9EnWsiyHK3ftgqJi', 'user', '2020-11-25 02:50:14'),
(22, '', '', '$2y$10$/EUZpI0uBfgzrwwVrZAJ3.FiMTwSClcxJos07ym8V7eo3hW4ntOx.', 'user', '2020-11-28 20:47:24'),
(23, '', '', '$2y$10$12.ASB6fbFkwYBOvCNo2NeEJ.qTHTrESf.DUmdyHsx4lKftz5KUd2', 'user', '2020-11-28 20:47:28'),
(25, '', '', '$2y$10$ASOX88nqRWT99cs1v3u3Xu.x4QXBal9HqCIT.foRZ1V0un3PC2Ii6', 'user', '2020-12-06 09:34:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
