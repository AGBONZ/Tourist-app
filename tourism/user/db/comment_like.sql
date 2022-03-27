-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2022 at 12:52 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment_like`
--

CREATE TABLE `comment_like` (
  `id` int(11) NOT NULL,
  `user_ip` varchar(255) DEFAULT NULL,
  `story_id` int(11) NOT NULL DEFAULT 0,
  `like_count` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_like`
--

INSERT INTO `comment_like` (`id`, `user_ip`, `story_id`, `like_count`, `created`) VALUES
(1, NULL, 3, 1, '2022-03-09 17:33:36'),
(2, NULL, 3, 1, '2022-03-09 17:33:36'),
(3, NULL, 3, 1, '2022-03-09 17:35:18'),
(4, NULL, 3, 1, '2022-03-09 17:35:18'),
(5, NULL, 3, 1, '2022-03-09 17:37:22'),
(6, NULL, 3, 1, '2022-03-09 17:37:22'),
(7, NULL, 4, 1, '2022-03-09 17:37:35'),
(8, NULL, 4, 1, '2022-03-09 17:37:35'),
(9, '192.168.43.116', 3, 1, '2022-03-10 11:51:30'),
(10, '192.168.43.116', 4, 1, '2022-03-10 11:51:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment_like`
--
ALTER TABLE `comment_like`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment_like`
--
ALTER TABLE `comment_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
