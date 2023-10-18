-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 05:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesun`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `AdID` int(11) NOT NULL,
  `AdName` varchar(255) NOT NULL,
  `AdDescription` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `AdAuthorID` int(11) NOT NULL,
  `AdStatus` varchar(255) NOT NULL,
  `AdPicture` longtext NOT NULL,
  `AdCategory` varchar(255) NOT NULL,
  `AdPostedDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`AdID`, `AdName`, `AdDescription`, `price`, `AdAuthorID`, `AdStatus`, `AdPicture`, `AdCategory`, `AdPostedDateTime`) VALUES
(1, 'Testing 1', 'No clue but testing', 0, 7, 'Approved', 'img/logo.png', 'morning', '2023-10-16 10:00:00'),
(2, 'Testing 2', 'Idk but another test', 0, 7, 'Approved', 'img/TheSun.jpeg', 'morning afternoon evening night', '2023-10-14 14:00:00'),
(5, 'Testing 3', 'I am giving up', 0, 7, 'Pending Payment', 'img/logo.png', 'afternoon', '2023-10-15 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `UserType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserEmail`, `UserName`, `UserPassword`, `UserType`) VALUES
(7, 'ausca33@gmail.com', 'AuscaLaiSuperLongAssNameTOTEst', '$2y$10$RdnEuO1rK0mZ.8YhompxzeAC.8ZlIIbA3aapbyzSypfmUJNJe8ju6', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`AdID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `AdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
