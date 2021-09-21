-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2021 at 12:20 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE `expenditure` (
  `Item` varchar(100) NOT NULL,
  `PurchaseDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Description` varchar(255) DEFAULT NULL,
  `Quantity` float(7,2) NOT NULL DEFAULT 0.00,
  `Unit` enum('units','kilograms','boxes','liters','gallons') NOT NULL,
  `Category` enum('Meat/Seafood','Vegetables','Grocery/Condiments','Dairy','Grain','Fruit','Cutlery/Utensils','Major Equipment','Minor Equipment') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenditure`
--

INSERT INTO `expenditure` (`Item`, `PurchaseDate`, `Description`, `Quantity`, `Unit`, `Category`) VALUES
('Beef, ground', '2021-09-15 00:00:00', 'ground beef chuck', 3.00, 'kilograms', 'Meat/Seafood'),
('Cabbage', '2021-09-16 00:00:00', 'Cabbage CS/24 Heads Prpl', 24.00, 'units', 'Vegetables'),
('Canola Oil', '2021-09-11 00:00:00', NULL, 15.00, 'gallons', 'Grocery/Condiments'),
('Milk', '2021-09-16 00:00:00', 'Milk 2% 4/1 GA', 2.00, 'liters', 'Dairy'),
('Rice', '2021-09-15 00:00:00', 'organic white rice', 50.00, 'kilograms', 'Grain'),
('Salmon', '2021-09-16 00:00:00', 'Salmon Atlantic', 18.00, 'kilograms', 'Meat/Seafood'),
('ground beef chuck', '2021-09-21 00:00:00', 'ground beef chuck', 11.00, 'kilograms', 'Meat/Seafood'),
('ground beef chuck', '2021-09-21 00:00:00', 'ground beef chuck', 112.00, 'kilograms', 'Meat/Seafood'),
('ground beef chuck', '2021-09-21 00:00:00', 'ground beef chuck', 11.00, 'kilograms', 'Meat/Seafood'),
('All-purpose flour', '2021-09-21 18:15:07', 'whole wheat', 20.00, 'kilograms', 'Grain'),
('Cheese', '2021-09-21 18:17:50', 'cheddar', 11.33, 'kilograms', 'Dairy');

-- --------------------------------------------------------

--
-- Table structure for table `stockusage`
--

CREATE TABLE `stockusage` (
  `Item` varchar(100) NOT NULL,
  `Category` enum('Meat/Seafood','Vegetables','Grocery/Condiments','Dairy','Grain','Fruit','Cutlery/Utensils','Major Equipment','Minor Equipment') NOT NULL,
  `Date` date NOT NULL,
  `Checker` varchar(100) NOT NULL,
  `Unit` enum('units','kilograms','boxes','liters','gallons') NOT NULL,
  `Quantity` float(7,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stockusage`
--

INSERT INTO `stockusage` (`Item`, `Category`, `Date`, `Checker`, `Unit`, `Quantity`) VALUES
('Beef, ground', 'Meat/Seafood', '2021-09-16', 'John Smith', 'kilograms', 1.56),
('Cabbage', 'Vegetables', '2021-09-16', 'John Smith', 'units', 24.00),
('Canola Oil', 'Grocery/Condiments', '2021-09-16', 'John Smith', 'gallons', 10.50),
('Milk', 'Dairy', '2021-09-16', 'John Smith', 'liters', 2.00),
('Rice', 'Grain', '2021-09-16', 'John Smith', 'kilograms', 30.78),
('Salmon', 'Meat/Seafood', '2021-09-16', 'John Smith', 'kilograms', 18.00),
('Beef, ground', 'Meat/Seafood', '2021-09-17', 'Mary Williams', 'kilograms', 0.00),
('Cabbage', 'Vegetables', '2021-09-17', 'Mary Williams', 'units', 20.00),
('Canola Oil', 'Grocery/Condiments', '2021-09-17', 'Mary Williams', 'gallons', 9.70),
('Milk', 'Dairy', '2021-09-17', 'Mary Williams', 'liters', 1.60),
('Rice', 'Grain', '2021-09-17', 'Mary Williams', 'kilograms', 12.52),
('Salmon', 'Meat/Seafood', '2021-09-17', 'Mary Williams', 'kilograms', 14.70);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
