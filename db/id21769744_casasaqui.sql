-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2024 at 08:06 PM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21769744_casasaqui`
--
CREATE Database `id21769744_casasaqui`;
-- --------------------------------------------------------
use `id21769744_casasaqui`;
--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
('BcjKNX58e4x7bIqIvxG7', 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `message` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `offer` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `furnished` varchar(50) NOT NULL,
  `bhk` varchar(10) NOT NULL,
  `deposite` varchar(10) NOT NULL,
  `bedroom` varchar(10) NOT NULL,
  `bathroom` varchar(10) NOT NULL,
  `age` varchar(2) NOT NULL,
  `total_floors` varchar(2) NOT NULL,
  `room_floor` varchar(2) NOT NULL,
  `loan` varchar(50) NOT NULL,
  `image_01` varchar(50) NOT NULL,
  `image_02` varchar(50) NOT NULL,
  `image_03` varchar(50) NOT NULL,
  `image_04` varchar(50) NOT NULL,
  `image_05` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `sender` varchar(20) NOT NULL,
  `receiver` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `id` varchar(20) NOT NULL,
  `property_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `number`, `email`, `password`) VALUES
('Q4LabA6pRv5X8K523APM', 'Gustavo Mendes Ventieri Mariano ', '101', 'gustavinhomariano1203@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
('Novm72ksYU1RpVTvc657', 'Gustavo Mendes', '101', 'gustavoventieri@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
