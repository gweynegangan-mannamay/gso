-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 03:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vehicle_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `fuel_records`
--

CREATE TABLE `fuel_records` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `issued_from_stock` decimal(10,2) DEFAULT NULL,
  `additional_purchase` decimal(10,2) DEFAULT NULL,
  `balance_end` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fuel_records`
--

INSERT INTO `fuel_records` (`id`, `trip_id`, `issued_from_stock`, `additional_purchase`, `balance_end`) VALUES
(1, 2, 100.00, 100.00, 500.00),
(2, 3, 100.00, 100.00, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `trip_distance`
--

CREATE TABLE `trip_distance` (
  `id` int(11) NOT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `start_reading` decimal(10,2) DEFAULT NULL,
  `end_reading` decimal(10,2) DEFAULT NULL,
  `distance_travelled` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip_distance`
--

INSERT INTO `trip_distance` (`id`, `trip_id`, `start_reading`, `end_reading`, `distance_travelled`) VALUES
(1, 2, 10.00, 10.00, 10.00),
(2, 3, 10.00, 10.00, 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `trip_tickets`
--

CREATE TABLE `trip_tickets` (
  `id` int(11) NOT NULL,
  `ticket_date` date DEFAULT NULL,
  `driver_name` varchar(100) DEFAULT NULL,
  `authorized_passengers` text DEFAULT NULL,
  `vehicle_plate` varchar(50) DEFAULT NULL,
  `destination` varchar(150) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `authorized_by` varchar(100) DEFAULT NULL,
  `authorized_position` varchar(100) DEFAULT NULL,
  `departure_datetime` datetime DEFAULT NULL,
  `arrival_datetime` datetime DEFAULT NULL,
  `return_datetime` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trip_tickets`
--

INSERT INTO `trip_tickets` (`id`, `ticket_date`, `driver_name`, `authorized_passengers`, `vehicle_plate`, `destination`, `purpose`, `authorized_by`, `authorized_position`, `departure_datetime`, `arrival_datetime`, `return_datetime`, `remarks`, `created_at`) VALUES
(1, NULL, 'earl', NULL, NULL, 'manil', 'seminar', NULL, NULL, '1111-01-11 22:00:00', '1111-01-11 05:00:00', NULL, 'wow', '2026-04-11 23:05:18'),
(2, NULL, 'earl', NULL, NULL, 'manil', 'seminar', NULL, NULL, '1111-01-11 22:00:00', '1111-01-11 05:00:00', NULL, 'wow', '2026-04-11 23:08:29'),
(3, NULL, 'earl', NULL, NULL, 'manil', 'seminar', NULL, NULL, '2006-10-01 10:00:00', '2006-10-01 17:00:00', NULL, 'EXCELENT', '2026-04-11 23:12:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`) VALUES
(882, 'gweyne', '#gwen123'),
(84353, 'earl', '123'),
(828791, 'eeeee', 'earl123'),
(2147483647, 'earls', '123456789');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fuel_records`
--
ALTER TABLE `fuel_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `trip_distance`
--
ALTER TABLE `trip_distance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `trip_tickets`
--
ALTER TABLE `trip_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fuel_records`
--
ALTER TABLE `fuel_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trip_distance`
--
ALTER TABLE `trip_distance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trip_tickets`
--
ALTER TABLE `trip_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fuel_records`
--
ALTER TABLE `fuel_records`
  ADD CONSTRAINT `fuel_records_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trip_tickets` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trip_distance`
--
ALTER TABLE `trip_distance`
  ADD CONSTRAINT `trip_distance_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `trip_tickets` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
