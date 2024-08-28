-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 28, 2024 at 05:14 PM
-- Server version: 8.0.39-0ubuntu0.20.04.1
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kv`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int NOT NULL,
  `user_id` int NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frizers`
--

CREATE TABLE `frizers` (
  `frizer_id` int NOT NULL,
  `salon_id` int NOT NULL,
  `frizer_name` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `frizers`
--

INSERT INTO `frizers` (`frizer_id`, `salon_id`, `frizer_name`) VALUES
(1, 1, 'Vajer'),
(2, 2, 'Balint'),
(3, 3, 'Tajti'),
(4, 4, 'Pari'),
(5, 5, 'Pal'),
(6, 6, 'Giric');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int NOT NULL,
  `store_id` int NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int NOT NULL,
  `frizer_id` int NOT NULL,
  `treatment_id` int NOT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `cancelled` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salon_admin`
--

CREATE TABLE `salon_admin` (
  `admin_id` int NOT NULL,
  `admin_name` text COLLATE utf8mb3_bin NOT NULL,
  `password` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `salon_admin`
--

INSERT INTO `salon_admin` (`admin_id`, `admin_name`, `password`) VALUES
(1, 'Tamas', '$2y$10$AeQGb8efmoaZP6/49M80b.3CNGhtdgDs60hPsi4xZG7OlTSwp8yhi'),
(2, 'Vajer', '$2y$10$RIRq5tx52Yr/pm1uoO1TZ.2nkgRyIIbvWMDHH0zrxFs/3vCAXDHG6');

-- --------------------------------------------------------

--
-- Table structure for table `salon_owner`
--

CREATE TABLE `salon_owner` (
  `owner_id` int NOT NULL,
  `owner_name` text COLLATE utf8mb3_bin NOT NULL,
  `salon_owner_id` int NOT NULL,
  `password` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `salon_owner`
--

INSERT INTO `salon_owner` (`owner_id`, `owner_name`, `salon_owner_id`, `password`) VALUES
(1, 'Tamas', 1, '$2y$10$h70epl66GZxoFcTmwFcu.OVQfL2RSpkXMQoSJ5SY5ZqJCZWLirsl2'),
(2, 'Vajer', 2, '$2y$10$XRAIi1pg38.p22spqlUo0OdIFQmxP.uKPWCCVYm1PIL71MEdeLk6G'),
(7, 'Giric', 3, '$2y$10$R0XE9yEl.ioNQoaZBNfiaeLJV3KQE6QQQFZRj/aOgBUdDtDEEZgta'),
(8, 'Gircso', 3, '$2y$10$MYh.AeFsCYyOrcXp4ZOupu.1Ywk7ShaziU1s1uUvLh/mXvgX2zJ6.'),
(10, 'Tomi', 1, '$2y$10$XV5BscPP8HEcumbgoHEtFOmvsEcS5af7AlxZaEoeFguyCeHQRGcGu');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `treatment_id` int NOT NULL,
  `salon_id` int NOT NULL,
  `treatment_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `treatment_price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatment_id`, `salon_id`, `treatment_name`, `treatment_price`) VALUES
(1, 1, 'Styling', 35),
(2, 1, 'Styling + Color', 65),
(3, 1, 'Styling + Tint', 65),
(4, 1, 'Semi-permanent wave', 65),
(5, 1, 'Cut + Styling', 63),
(6, 1, 'Cut + Styling + Color', 100),
(7, 1, 'Cut + Styling + Tint', 100),
(8, 1, 'Cut', 25),
(9, 1, 'Shave', 65),
(10, 1, 'Beard trim', 65),
(11, 1, 'Cut + beard trim', 65),
(12, 1, 'Cut + shave', 63),
(13, 1, 'Clean up', 100),
(16, 3, 'Treatment', 3),
(17, 4, 'Treatment', 4),
(18, 5, 'Treatment', 5),
(19, 6, 'Treatment', 6),
(20, 1, 'Special treat', 44),
(21, 1, 'Special treat 2', 55),
(22, 2, 'Styling', 66),
(23, 2, 'Cut + Styling', 54),
(26, 1, 'Special treat 3', 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(30) COLLATE utf8mb3_bin NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb3_bin NOT NULL,
  `first_name` varchar(30) COLLATE utf8mb3_bin NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb3_bin NOT NULL,
  `email` varchar(60) COLLATE utf8mb3_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  `pic_name` text COLLATE utf8mb3_bin,
  `pw_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb3_bin NOT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `last_name`, `first_name`, `mobile`, `email`, `password`, `pic_name`, `pw_token`, `active`, `token`, `is_blocked`) VALUES
(90, 'Zsolti', 'asd', 'asd', '32', 'vajerzsolt02@gmail.com', '$2y$10$CupLx0L9jk3Db7HbzhoRse0VJJ.y2Qu5bvtmMloj3l36gPvCucTf6', NULL, NULL, 1, 'e721f561ba4e7a519a4921726f859f132b4ba5b9e74b53d1c6eca63f0ee5f9a6', 0),
(91, 'btomi1234', 'Tamás', 'Bálint', '0601557330', 'balinttamas23@gmail.com', '$2y$10$d2DPETnRCxpUgkIj9tz8Y.8MKqvt2anbj1FuLABvDyyNwYYASYPpC', NULL, NULL, 1, '94a956d0b4265241adfd87df1b20a66ff9aa392e3854dde769526880268b2ba4', 0),
(92, 'mobilproba', 'Balint', 'Tamas', '62621661616', 'balinttamas31@gmail.com', 'mobilproba', NULL, NULL, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `device` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `os` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `browser` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `ip`, `device`, `os`, `browser`, `date`, `username`) VALUES
(1, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 10:00:03', 'Zsolti'),
(2, '147.91.199.133', 'Mobile', 'Mac OS X', 'Unknown', '2024-08-27 12:02:13', 'Zsolti'),
(3, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 18:13:52', 'Zsolti'),
(4, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 18:16:06', 'Zsolti'),
(5, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 18:36:03', 'Geza'),
(6, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 18:50:45', 'Zsolti'),
(7, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 19:55:09', 'Tomi'),
(8, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:11:30', 'Tomi'),
(9, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:14:23', 'Zsolti'),
(10, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:14:54', 'Tomi'),
(11, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:17:39', 'Zsolti'),
(12, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:39:55', 'Tomi'),
(13, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:40:32', 'Zsolti'),
(14, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:42:04', 'Zsolti'),
(15, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:42:55', 'Tomi'),
(16, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:45:04', 'Zsolti'),
(17, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:46:23', 'Tomi'),
(18, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:46:59', 'Zsolti'),
(19, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 22:50:06', 'Tomi'),
(20, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 23:00:55', 'Zsolti'),
(21, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 23:04:38', 'Zsolt'),
(22, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 23:21:27', 'Tomi'),
(23, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 23:21:54', 'Zsolti'),
(24, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 23:47:38', 'Tomi'),
(25, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-27 23:52:18', 'Zsolti'),
(26, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:09:53', 'Tomi'),
(27, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:10:56', 'Zsolti'),
(28, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:11:32', 'Tomi'),
(29, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:12:43', 'Zsolti'),
(30, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:25:03', 'Tomi'),
(31, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:43:19', 'Zsolti'),
(32, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:44:31', 'Zsolti'),
(33, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:47:01', 'Tomi'),
(34, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:51:12', 'Zsolti'),
(35, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 00:51:57', 'Tomi'),
(36, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:13:55', 'Zsolti'),
(37, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:25:32', 'Tomi'),
(38, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:29:39', 'Tomi'),
(39, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:38:14', 'Zsolti'),
(40, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:38:56', 'Tomi'),
(41, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:46:01', 'Zsolti'),
(42, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:51:06', 'Tamas'),
(43, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:55:28', 'Zsolti'),
(44, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:56:11', 'Tomi'),
(45, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 01:59:08', 'Zsolti'),
(46, '147.91.199.133', 'Desktop', 'Windows 10', 'Chrome', '2024-08-28 17:35:10', 'btomi1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `frizers`
--
ALTER TABLE `frizers`
  ADD PRIMARY KEY (`frizer_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `salon_admin`
--
ALTER TABLE `salon_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `salon_owner`
--
ALTER TABLE `salon_owner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`treatment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frizers`
--
ALTER TABLE `frizers`
  MODIFY `frizer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salon_admin`
--
ALTER TABLE `salon_admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salon_owner`
--
ALTER TABLE `salon_owner`
  MODIFY `owner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `treatment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
