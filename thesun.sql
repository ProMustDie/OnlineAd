-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2023 at 06:41 AM
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
  `Price` double DEFAULT NULL,
  `AdAuthorID` int(11) NOT NULL,
  `AdStatus` varchar(255) NOT NULL,
  `AdPicture` longtext NOT NULL,
  `AdPaymentPicture` varchar(255) DEFAULT NULL,
  `AdCategory` longtext NOT NULL,
  `AdPostedDateTime` datetime NOT NULL,
  `AdRequestedDate` date NOT NULL,
  `AdRejectedDate` date DEFAULT NULL,
  `AdApprovedDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`AdID`, `AdName`, `AdDescription`, `Price`, `AdAuthorID`, `AdStatus`, `AdPicture`, `AdPaymentPicture`, `AdCategory`, `AdPostedDateTime`, `AdRequestedDate`, `AdRejectedDate`, `AdApprovedDate`) VALUES
(1, 'Category Initializer', 'DO NOT DELETE INTIALIZER', NULL, 1, 'Expired', '', NULL, 'Job,House,Land,Car', '2023-10-27 05:01:18', '2023-10-26', NULL, NULL),
(5, 'Test34', 'tettetet', 121, 2, 'Approved', '', NULL, 'Car', '2023-11-27 10:02:40', '2023-11-26', NULL, NULL),
(6, 'testtt', 'teetetet', 121, 2, 'Approved', '', NULL, 'Land', '2023-11-28 16:48:38', '2023-12-27', NULL, NULL),
(7, 'test', 'asdkjnasodi', NULL, 2, 'Rejected Request', 'img/classifiedIMG/4f65d2f1aed64b10f078f6fbe682f7ed.png', NULL, 'Car', '2023-12-04 10:19:07', '2023-12-03', '2023-12-07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` varchar(255) NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `UserType` varchar(255) NOT NULL,
  `RegDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserEmail`, `UserName`, `UserPassword`, `UserType`, `RegDate`) VALUES
(1, 'admin@a.com', 'Admin', '$2y$10$4bZ3s4hlAxYeHPlg8OzJvOy5pTUorVtrosmE1y30wRXlYXcf/UwRe', 'Admin', '2023-12-06'),
(2, 'ausca33@gmail.com', 'Ausca Lai', '$2y$10$32Bk9Qwlb8ICUZGopuGSR.PnnZlvwWs/wcj8TghU7eNy50x0vjKym', 'User', '2023-12-05'),
(4, 'sjdfh@gmail.com', 'tet', '$2y$10$VU7tVZZ3QeL4ycvL.6VffOj22H7wZMj3c9/LiPyonYFonoqNgX/we', 'User', '2023-12-05'),
(5, 'ad@a.nm', 'asjdn', '$2y$10$psMb.zAYWa5l7rVIX5hSH.C03Per8IvzfkIei4TiiGtdTqrm3jZDq', 'User', '2023-11-19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`AdID`);

--
-- Indexes for table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`),
  ADD KEY `pwdResetEmail` (`pwdResetEmail`);

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
  MODIFY `AdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
