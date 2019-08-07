-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 07, 2019 at 05:21 PM
-- Server version: 10.3.13-MariaDB
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_db`
--
CREATE DATABASE IF NOT EXISTS `booking_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `booking_db`;

-- --------------------------------------------------------

--
-- Table structure for table `pre_booking`
--

CREATE TABLE `pre_booking` (
  `booking_id` int(10) NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL,
  `duration` time NOT NULL,
  `time` time NOT NULL,
  `day` date NOT NULL,
  `table_id` int(10) NOT NULL,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_week_id` int(10) NOT NULL,
  `schedule_week_name` varchar(20) NOT NULL,
  `schedule_start` time NOT NULL DEFAULT '09:00:00',
  `schedule_end` time NOT NULL DEFAULT '22:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_week_id`, `schedule_week_name`, `schedule_start`, `schedule_end`) VALUES
(1, 'Понедельник', '10:00:00', '00:00:00'),
(2, 'Вторник', '15:30:00', '23:00:00'),
(3, 'Среда', '10:30:00', '23:00:00'),
(4, 'Четверг', '09:00:00', '23:00:00'),
(5, 'Пятница', '08:30:00', '18:30:00'),
(6, 'Суббота', '08:30:00', '23:00:00'),
(7, 'Воскресенье', '08:30:00', '20:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `special`
--

CREATE TABLE `special` (
  `special_id` int(11) NOT NULL,
  `special_date` date NOT NULL,
  `special_start` time NOT NULL,
  `special_end` time NOT NULL,
  `is_weekend` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `special`
--

INSERT INTO `special` (`special_id`, `special_date`, `special_start`, `special_end`, `is_weekend`) VALUES
(94, '2019-08-24', '00:00:00', '00:00:00', 1),
(95, '2019-08-08', '00:00:00', '00:00:00', 1),
(97, '2019-07-04', '00:00:00', '00:00:00', 1),
(98, '2019-08-22', '13:30:00', '22:30:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL DEFAULT 0,
  `table_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_number`, `table_type_id`) VALUES
(6, 2, 1),
(28, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `table_type`
--

CREATE TABLE `table_type` (
  `table_type_id` int(11) NOT NULL,
  `table_name` varchar(20) NOT NULL,
  `table_size` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_type`
--

INSERT INTO `table_type` (`table_type_id`, `table_name`, `table_size`) VALUES
(1, 'Маленький', 2),
(2, 'Средний', 4),
(3, 'Большой', 8),
(4, 'Пати-тайм', 16);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_login` varchar(30) NOT NULL,
  `user_password` varchar(32) NOT NULL,
  `user_hash` varchar(32) NOT NULL DEFAULT '',
  `user_ip` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_hash`, `user_ip`) VALUES
(1, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', '554697b62ab8d1bd9f0f1afc19e9a660', 2130706433);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pre_booking`
--
ALTER TABLE `pre_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `special`
--
ALTER TABLE `special`
  ADD PRIMARY KEY (`special_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`),
  ADD UNIQUE KEY `table_number` (`table_number`);

--
-- Indexes for table `table_type`
--
ALTER TABLE `table_type`
  ADD PRIMARY KEY (`table_type_id`),
  ADD KEY `table_type_id` (`table_type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pre_booking`
--
ALTER TABLE `pre_booking`
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `special`
--
ALTER TABLE `special`
  MODIFY `special_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `table_type`
--
ALTER TABLE `table_type`
  MODIFY `table_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
