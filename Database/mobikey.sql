-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2023 at 07:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobikey`
--

-- --------------------------------------------------------

--
-- Table structure for table `leavedays`
--

CREATE TABLE `leavedays` (
  `employeeID` int(11) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `leaveType` varchar(255) NOT NULL,
  `startDate` varchar(255) DEFAULT NULL,
  `endDate` varchar(255) DEFAULT NULL,
  `numDays` decimal(10,1) DEFAULT NULL,
  `filePath` longtext DEFAULT NULL,
  `directControl` varchar(255) DEFAULT 'Pending',
  `humanResource` varchar(255) DEFAULT 'Pending',
  `generalManager` varchar(255) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavedays`
--

INSERT INTO `leavedays` (`employeeID`, `fname`, `lname`, `department`, `leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`) VALUES
(12, 'Human', 'Resource', 'Admin', 'Normal', '2023-07-03', '2023-07-11', 7.5, 'NULL', 'Approved', 'Approved', 'Pending'),
(12, 'Human', 'Resource', 'Admin', 'Normal', '2023-12-24', '2023-12-30', 4.5, 'NULL', 'Approved', 'Approved', 'Pending'),
(12, 'Human', 'Resource', 'Admin', 'Normal', '2023-07-11', '2023-07-15', 4.5, 'NULL', 'Approved', 'Approved', 'Pending'),
(6, 'Lourdes', 'Wairimu', 'Workshop', 'Normal', '2023-12-12', '2023-12-30', 12.5, 'NULL', 'Approved', 'Pending', 'Pending'),
(6, 'Lourdes', 'Wairimu', 'Workshop', 'Normal', '2023-07-12', '2023-07-20', 7.5, 'NULL', 'Approved', 'Pending', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) DEFAULT NULL,
  `tokens` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `employeeID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `startDate` varchar(255) DEFAULT NULL,
  `section` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL DEFAULT 'Department',
  `position` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`employeeID`, `fname`, `lname`, `userName`, `email`, `phone`, `startDate`, `section`, `department`, `position`, `role`, `password`) VALUES
(4, 'Samuel', 'Muigai', 'smuigai', 'muigaisam65@gmail.com', 'NULL', '2023-02-12\r\n', 'Mobikey', 'Workshop', 'Workshop Assistant', 'User', 'A@k_+XUx'),
(6, 'Lourdes', 'Wairimu', 'lwairimu', 'lwairimu@gmail.com', 'NULL', '2023-02-12\r\n', 'Mobikey', 'Workshop', 'Workshop Manager', 'HOD', 'G=5or+R1'),
(8, 'Susan', 'Kinyua', 'skinyua', 'jbjbs@kinyua.con', 'NULL', '2022-10-09', 'Mobikey', 'Logistics', 'Logistics Assistant', 'HR', 'w1;yxhVO'),
(9, 'Jose', 'Garcia', 'jgarcia', 'jgarc@gmail.com', 'NULL', '2021-04-02', 'JAP', 'Admin', 'Administrator', 'Admin', 'S14,r0NI'),
(12, 'Human', 'Resource', 'hresource', 'hr@mobikey.co.ke', 'NULL', '2019-12-09', 'Mobikey', 'Admin', 'Human Resource Manager', 'HR', ';umD6^eM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leavedays`
--
ALTER TABLE `leavedays`
  ADD KEY `employeeID` (`employeeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`employeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leavedays`
--
ALTER TABLE `leavedays`
  ADD CONSTRAINT `leavedays_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `users` (`employeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
