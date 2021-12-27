-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2021 at 10:57 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boozt`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `shortname` varchar(45) DEFAULT NULL,
  `lat` float(10,6) DEFAULT NULL,
  `lng` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `shortname`, `lat`, `lng`) VALUES
(1, 'Sweden', 'SE', 60.128162, 18.643501),
(2, 'Denmark', 'DK', 56.263920, 9.501785);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varbinary(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `last_name`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Ali', 'Shoaib', 0x73686f616962636f6d7369616e406f75746c6f6f6b2e636f6d, '2021-11-01 12:42:47', '2021-11-01 12:42:47'),
(2, 'Majid', 'Ali', 0x6d616a406578616d706c652e636f6d, '2021-11-04 12:43:05', '2021-11-04 12:43:05'),
(3, 'M', 'Jon', 0x6b6b406f75746c6f6f6b2e636f6d, '2021-11-15 12:42:47', '2021-11-15 12:42:47'),
(4, 'L', 'C', 0x4c43406578616d706c652e636f6d, '2021-11-15 12:43:05', '2021-11-15 12:43:05'),
(5, 'Muhammad', 'Umair', 0x756d616972343334406f75746c6f6f6b2e636f6d, '2021-11-30 12:42:47', '2021-11-30 12:42:47'),
(6, 'M', 'Qasim', 0x716173696d406578616d706c652e636f6d, '2021-12-01 12:43:05', '2021-12-01 12:43:05'),
(7, 'Noor', 'Ali', 0x6e6f6f72616c69406f75746c6f6f6b2e636f6d, '2021-12-15 12:42:47', '2021-12-17 12:42:47'),
(8, 'Jhon', '', 0x6a6a3039406f75746c6f6f6b2e636f6d, '2021-12-13 12:42:47', '2021-12-13 12:42:47'),
(9, 'Erdal', '', 0x65643536406f75746c6f6f6b2e636f6d, '2021-12-28 12:42:47', '2021-12-28 12:42:47'),
(10, 'sajid', 'Khan', 0x73616a69646b406f75746c6f6f6b2e636f6d, '2021-12-23 12:42:47', '2021-12-21 12:42:47');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `total_amount` decimal(15,4) DEFAULT '0.0000',
  `country_id` int(11) NOT NULL,
  `device` varchar(100) DEFAULT NULL,
  `purchase_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_customer` (`customer_id`),
  KEY `order_date` (`purchase_date`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `total_amount`, `country_id`, `device`, `purchase_date`) VALUES
(1, 1, '300.0000', 1, 'web', '2021-11-01 14:32:39'),
(2, 1, '1000.0000', 1, 'android', '2021-11-03 14:32:39'),
(3, 1, '300.0000', 1, 'web', '2021-11-03 14:32:39'),
(4, 2, '200.0000', 1, 'android', '2021-11-04 14:32:39'),
(5, 2, '100.0000', 1, 'android', '2021-11-10 14:32:39'),
(6, 2, '1000.0000', 1, 'web', '2021-11-12 14:32:39'),
(7, 2, '500.0000', 1, 'android', '2021-11-12 14:32:39'),
(8, 2, '800.0000', 1, 'android', '2021-11-12 14:32:39'),
(9, 1, '100.0000', 1, 'android', '2021-11-01 14:32:39'),
(10, 1, '200.0000', 1, 'web', '2021-11-02 14:32:39'),
(11, 1, '100.0000', 1, 'web', '2021-11-06 14:32:39'),
(12, 1, '1000.0000', 1, 'android', '2021-11-08 14:32:39'),
(13, 1, '200.0000', 1, 'web', '2021-11-08 14:32:39'),
(14, 1, '100.0000', 1, 'web', '2021-11-11 14:32:39'),
(15, 1, '50.0000', 1, 'android', '2021-11-13 14:32:39'),
(16, 3, '350.0000', 1, 'web', '2021-11-15 14:32:39'),
(17, 4, '240.0000', 1, 'web', '2021-11-20 14:32:39'),
(18, 6, '200.0000', 1, 'android', '2021-12-03 14:32:39'),
(19, 6, '100.0000', 1, 'web', '2021-12-03 14:32:39'),
(20, 7, '600.0000', 1, 'android', '2021-12-07 14:32:39'),
(21, 7, '500.0000', 1, 'web', '2021-12-07 14:32:39'),
(22, 7, '300.0000', 1, 'android', '2021-12-10 14:32:39'),
(23, 7, '200.0000', 1, 'web', '2021-12-10 14:32:39'),
(24, 7, '900.0000', 1, 'ios', '2021-12-15 14:32:39'),
(25, 7, '800.0000', 1, 'web', '2021-12-15 14:32:39'),
(26, 7, '200.0000', 1, 'ios', '2021-12-15 14:32:39'),
(27, 7, '100.0000', 1, 'web', '2021-12-20 14:32:39'),
(28, 7, '700.0000', 1, 'web', '2021-12-20 14:32:39'),
(29, 8, '100.0000', 1, 'android', '2021-12-30 14:32:39'),
(30, 8, '200.0000', 1, 'android', '2021-12-30 14:32:39'),
(31, 9, '100.0000', 1, 'web', '2021-12-30 14:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `ean` varchar(15) DEFAULT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `ean`, `quantity`, `price`) VALUES
(1, 1, 'XXXXXXXXXXXXX', 1, '300.0000'),
(2, 2, 'XXXXXXXXXXXXX', 1, '1000.0000'),
(3, 3, 'XXXXXXXXXXXXX', 1, '300.0000'),
(4, 4, 'XXXXXXXXXXXXX', 1, '200.0000'),
(5, 5, 'XXXXXXXXXXXXX', 1, '100.0000'),
(6, 6, 'XXXXXXXXXXXXX', 1, '1000.0000'),
(7, 7, 'XXXXXXXXXXXXX', 1, '500.0000'),
(8, 8, 'XXXXXXXXXXXXX', 1, '800.0000'),
(9, 9, 'XXXXXXXXXXXXX', 1, '100.0000'),
(10, 10, 'XXXXXXXXXXXXX', 1, '200.0000'),
(11, 11, 'XXXXXXXXXXXXX', 1, '100.0000'),
(12, 12, 'XXXXXXXXXXXXX', 1, '1000.0000'),
(13, 13, 'XXXXXXXXXXXXX', 1, '200.0000'),
(14, 14, 'XXXXXXXXXXXXX', 1, '100.0000'),
(15, 15, 'XXXXXXXXXXXXX', 1, '50.0000'),
(16, 16, 'XXXXXXXXXXXXX', 1, '350.0000'),
(17, 17, 'XXXXXXXXXXXXX', 1, '240.0000'),
(18, 18, 'XXXXXXXXXXXXX', 1, '200.0000'),
(19, 19, 'XXXXXXXXXXXXX', 1, '100.0000'),
(20, 20, 'XXXXXXXXXXXXX', 1, '600.0000'),
(21, 21, 'XXXXXXXXXXXXX', 1, '500.0000'),
(22, 22, 'XXXXXXXXXXXXX', 1, '300.0000'),
(23, 23, 'XXXXXXXXXXXXX', 1, '200.0000'),
(24, 24, 'XXXXXXXXXXXXX', 1, '900.0000'),
(25, 25, 'XXXXXXXXXXXXX', 1, '800.0000'),
(26, 26, 'XXXXXXXXXXXXX', 1, '200.0000'),
(27, 27, 'XXXXXXXXXXXXX', 1, '100.0000'),
(28, 28, 'XXXXXXXXXXXXX', 1, '700.0000'),
(29, 29, 'XXXXXXXXXXXXX', 1, '100.0000'),
(30, 30, 'XXXXXXXXXXXXX', 1, '200.0000'),
(31, 31, 'XXXXXXXXXXXXX', 1, '100.0000');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
