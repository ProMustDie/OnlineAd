-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2023 at 10:06 AM
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
(5, 'Test34', 'tettetet', 121, 2, 'Approved', '', NULL, 'Car', '2023-11-27 10:02:40', '2023-11-26', NULL, '2023-12-08'),
(6, 'testtt', 'teetetet', 121, 2, 'Approved', '', NULL, 'Land,House', '2023-11-28 16:48:38', '2023-12-01', NULL, '2023-12-08'),
(7, 'test', 'asdkjnasodi', NULL, 2, 'Rejected Request', 'img/classifiedIMG/4f65d2f1aed64b10f078f6fbe682f7ed.png', NULL, 'Car,House', '2023-12-04 10:19:07', '2023-12-03', '2023-12-07', NULL),
(8, '1', '1', NULL, 2, 'Approved', 'img/classifiedIMG/ab2a9f989ed08d2f09c8fd57dffbd45e.jpg', NULL, 'Car,House', '2023-12-14 09:15:47', '2023-12-14', NULL, '2023-12-14'),
(9, '2', '2', NULL, 2, 'Approved', 'img/classifiedIMG/fc4200f84c2c17c028e76865953e4949.jpg', NULL, 'Car,Job', '2023-12-14 09:15:57', '2023-12-14', NULL, '2023-12-14'),
(10, '3', '3', NULL, 2, 'Approved', 'img/classifiedIMG/41853dfed2ea97ab4c0c346f9a134344.jpg', NULL, 'Job', '2023-12-14 09:16:10', '2023-12-14', NULL, '2023-12-14'),
(11, '4', '4', NULL, 2, 'Approved', 'img/classifiedIMG/39e3a0bcc4d8fd47370fb00aa8e771fb.jpg', NULL, 'Job', '2023-12-14 09:16:18', '2023-12-14', NULL, '2023-12-14'),
(12, '5', '5', NULL, 2, 'Approved', 'img/classifiedIMG/f5d79c2c2b775fb76a04775ba231b96c.jpg', NULL, 'Job', '2023-12-14 09:16:27', '2023-12-14', NULL, '2023-12-14'),
(13, '6', '6', NULL, 2, 'Approved', 'img/classifiedIMG/045d50481bfaeddf22ce52ed90ea52d6.jpg', NULL, 'House', '2023-12-14 09:16:35', '2023-12-14', NULL, '2023-12-14'),
(14, '7', '7', NULL, 2, 'Approved', 'img/classifiedIMG/8e9170cd46dc809c3e5585824f36b555.jpg', NULL, 'Job,Land', '2023-12-14 09:16:50', '2023-12-14', NULL, '2023-12-14'),
(15, '8', '8', NULL, 2, 'Approved', 'img/classifiedIMG/b690fce3de2333848eea9ad9f0526777.jpg', NULL, 'House', '2023-12-14 09:16:59', '2023-12-14', NULL, '2023-12-14'),
(16, '9', '9', NULL, 2, 'Approved', 'img/classifiedIMG/e0d9671dc1e762ef4e3f2ff4e83b7deb.jpg', NULL, 'Land', '2023-12-14 09:17:08', '2023-12-14', NULL, '2023-12-14'),
(17, '10', '10', NULL, 2, 'Approved', 'img/classifiedIMG/958de73e20dcf1af8bed27dfb14c1a5a.jpg', NULL, 'Car,Land', '2023-12-14 09:17:21', '2023-12-14', NULL, '2023-12-14'),
(18, '11', '11', NULL, 2, 'Approved', 'img/classifiedIMG/3f687f041a43a4e81e0bb542278fd826.jpg', NULL, 'Job', '2023-12-14 09:17:31', '2023-12-14', NULL, '2023-12-14'),
(19, '12', '12', NULL, 2, 'Approved', 'img/classifiedIMG/093df5003460d6519059f7a42812c46f.jpg', NULL, 'Car,Job', '2023-12-14 09:17:39', '2023-12-14', NULL, '2023-12-14'),
(20, '13', '13', NULL, 2, 'Approved', 'img/classifiedIMG/31c8dc3fad9281f3480a1594308875cc.jpg', NULL, 'Car', '2023-12-14 09:17:48', '2023-12-14', NULL, '2023-12-14'),
(21, '14', '14', NULL, 2, 'Approved', 'img/classifiedIMG/ffe4487afdef19849f286e828ea7246a.jpg', NULL, 'Land', '2023-12-14 09:18:00', '2023-12-14', NULL, '2023-12-14'),
(22, '15', '15', 12629.69, 2, 'Approved', 'img/classifiedIMG/f9ead937fe77f95668d3b430b73286fb.jpg', NULL, 'Car,Land', '2023-12-14 09:18:10', '2023-12-14', NULL, '2023-12-14');

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
  MODIFY `AdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
