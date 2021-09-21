-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2021 at 10:33 AM
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
  `PurchaseDate` date NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Quantity` float(7,2) NOT NULL DEFAULT 0.00,
  `Unit` enum('units','kilograms','boxes','liters','gallons') NOT NULL,
  `Category` enum('Meat/Seafood','Vegetables','Grocery/Condiments','Dairy','Grain','Fruit','Cutlery/Utensils','Major Equipment','Minor Equipment') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenditure`
--

INSERT INTO `expenditure` (`Item`, `PurchaseDate`, `Description`, `Quantity`, `Unit`, `Category`) VALUES
('Beef, ground', '2021-09-15', 'ground beef chuck', 3.00, 'kilograms', 'Meat/Seafood'),
('Cabbage', '2021-09-16', 'Cabbage CS/24 Heads Prpl', 24.00, 'units', 'Vegetables'),
('Canola Oil', '2021-09-11', NULL, 15.00, 'gallons', 'Grocery/Condiments'),
('Milk', '2021-09-16', 'Milk 2% 4/1 GA', 2.00, 'liters', 'Dairy'),
('Rice', '2021-09-15', 'organic white rice', 50.00, 'kilograms', 'Grain'),
('Salmon', '2021-09-16', 'Salmon Atlantic', 18.00, 'kilograms', 'Meat/Seafood'),
('ground beef chuck', '0000-00-00', 'ground beef chuck', 11.00, 'kilograms', 'Meat/Seafood'),
('ground beef chuck', '0000-00-00', 'ground beef chuck', 11.00, 'kilograms', 'Meat/Seafood'),
('ground beef chuck', '0000-00-00', 'ground beef chuck', 112.00, 'kilograms', 'Meat/Seafood');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `privelege` enum('admin','employee') NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `password`, `privelege`, `date`) VALUES
(4, 58545455461603679, 'Eugene ', 'eugene_cedric_reyes@dlsu.edu.ph', '123', 'employee', '2021-09-19 06:47:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
