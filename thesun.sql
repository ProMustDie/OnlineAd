-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 10:09 AM
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
(1, 'Testing 1', 'No clue but testing', 0, 7, 'Approved', 'img/logo.png', 'morning, afternoon, night, bottom, jeans, random, word, test', '2023-10-16 10:00:00'),
(2, 'Testing 2', 'Idk but another test', 0, 7, 'Pending Review', 'img/TheSun.jpeg', 'morning, afternoon, evening, night', '2023-10-14 14:00:00'),
(5, 'Testing 3', 'I am giving up', 0, 7, 'Pending Payment', 'img/logo.png', 'afternoon', '2023-10-15 16:00:00'),
(7, 'Testing 4', 'Idk Im starting to get tired', 0, 7, 'Rejected Payment', 'img/logo.png', 'afternoon', '2023-10-18 10:57:14'),
(8, 'Testing 5', 'Im close to passing out', 0, 7, 'Rejected Request', 'img/logo.png', 'evening, night', '2023-10-18 11:12:38'),
(9, 'Testing 6', 'passed out', 0, 7, 'Cancelled', 'img/logo.png', 'night', '2023-10-18 11:12:38'),
(10, 'Testing 7', 'ded', 0, 7, 'Expired', 'img/logo.png', 'afternoon', '2023-10-18 11:12:38'),
(11, 'testing 8', 'dead', 0, 7, 'Approved', 'img/logo.png', 'afternoon, evening, morning, night', '2023-10-23 05:09:52');

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
(7, 'ausca33@gmail.com', 'AuscaLaiSuperLongAssNameTOTEst', '$2y$10$RdnEuO1rK0mZ.8YhompxzeAC.8ZlIIbA3aapbyzSypfmUJNJe8ju6', 'User'),
(9, 'tester2@gmail.com', 'Tester2', '$2y$10$mND3uqU68xoTDa2UBcTyYe11fa5fG83.IrkXcOidCiO275rJjqGvK', 'User'),
(10, 'admin@admin.com', 'Admin', '$2y$10$gXf6xfEDdzn/gQEKO4kGYeV5LsZDrV52TwAAkdB4a3j1oRRvU.t9q', 'Admin');

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
  MODIFY `AdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
