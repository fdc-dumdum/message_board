-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2020 at 11:24 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `messenger`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL COMMENT 'auto',
  `to_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created_ip` varchar(20) NOT NULL,
  `modified_ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `to_id`, `from_id`, `content`, `created`, `modified`, `created_ip`, `modified_ip`) VALUES
(1, 2, 1, '1', '2020-01-16 07:25:23', '2020-01-16 07:25:23', '::1', '::1'),
(2, 1, 2, '2', '2020-01-16 07:25:58', '2020-01-16 07:25:58', '::1', '::1'),
(3, 2, 1, '3', '2020-01-16 07:27:23', '2020-01-16 07:27:23', '::1', '::1'),
(4, 1, 2, '4', '2020-01-16 07:27:26', '2020-01-16 07:27:26', '::1', '::1'),
(5, 2, 1, '5', '2020-01-16 07:27:29', '2020-01-16 07:27:29', '::1', '::1'),
(6, 1, 2, '6', '2020-01-16 07:27:32', '2020-01-16 07:27:32', '::1', '::1'),
(7, 2, 1, '7', '2020-01-16 08:51:22', '2020-01-16 08:51:22', '::1', '::1'),
(8, 2, 1, '8', '2020-01-16 08:51:26', '2020-01-16 08:51:26', '::1', '::1'),
(9, 1, 2, '9', '2020-01-16 08:51:43', '2020-01-16 08:51:43', '::1', '::1'),
(10, 2, 1, '10', '2020-01-16 08:57:24', '2020-01-16 08:57:24', '::1', '::1'),
(11, 1, 2, '11', '2020-01-16 08:57:31', '2020-01-16 08:57:31', '::1', '::1'),
(12, 2, 1, '12', '2020-01-16 08:58:41', '2020-01-16 08:58:41', '::1', '::1'),
(13, 1, 2, '13', '2020-01-16 08:58:44', '2020-01-16 08:58:44', '::1', '::1'),
(14, 2, 1, '14', '2020-01-16 08:59:23', '2020-01-16 08:59:23', '::1', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'auto',
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT 'unique',
  `password` varchar(255) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL COMMENT '1=male, 2=female, null=not specified',
  `birthdate` date DEFAULT NULL,
  `hubby` text DEFAULT NULL,
  `last_login_time` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created_ip` varchar(20) NOT NULL COMMENT 'user ip address',
  `modified_ip` varchar(20) NOT NULL COMMENT 'user ip address'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `gender`, `birthdate`, `hubby`, `last_login_time`, `created`, `modified`, `created_ip`, `modified_ip`) VALUES
(1, 'Fritz Gerald Dumdum', 'jiezzing@gmail.com', '7195987468d32a40287330feb32059503f0d4560', 'Chiaki_Hanazono.png', '1', '2020-01-17', 'Happy creating or making  bugs and errors', '2020-01-17 17:42:03', '2020-01-17 04:01:14', '2020-01-17 18:13:38', '::1', '::1'),
(2, 'Relisa Mongas', 'relisa@gmail.com', '7195987468d32a40287330feb32059503f0d4560', NULL, NULL, NULL, NULL, '2020-01-17 17:40:30', '2020-01-17 13:34:08', '2020-01-17 17:40:30', '::1', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
