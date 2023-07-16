-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql110.byetcluster.com
-- Generation Time: Jul 16, 2023 at 09:58 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lblog_34402694_mobikey`
--

-- --------------------------------------------------------

--
-- Table structure for table `leavedays`
--

CREATE TABLE `leavedays` (
  `employeeID` int(11) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `section` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `leaveType` varchar(255) NOT NULL,
  `startDate` varchar(255) DEFAULT NULL,
  `endDate` varchar(255) DEFAULT NULL,
  `numDays` decimal(10,1) DEFAULT NULL,
  `filePath` longtext DEFAULT NULL,
  `directControl` varchar(255) DEFAULT 'Pending',
  `humanResource` varchar(255) DEFAULT 'Pending',
  `generalManager` varchar(255) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leavedays`
--

INSERT INTO `leavedays` (`employeeID`, `fname`, `lname`, `section`, `department`, `leaveType`, `startDate`, `endDate`, `numDays`, `filePath`, `directControl`, `humanResource`, `generalManager`) VALUES
(50, 'Simon', 'Ndungu', 'Mobikey', 'Logistics', 'Normal', '2023-07-18', '2023-07-25', '6.5', 'NULL', 'Pending', 'Pending', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`) VALUES
('muigaisam65@gmail.com', 'be92574b8b26091b7ab57e39297b3f'),
('muigaisam65@gmail.com', '5a962478417ebff06e787bdee3d9a9'),
('muigaisam65@gmail.com', '721aea1128323942a1651388ee353e');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `employeeID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `startDate` varchar(255) DEFAULT NULL,
  `section` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL DEFAULT 'Department',
  `position` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `isDeleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`employeeID`, `fname`, `mname`, `lname`, `userName`, `email`, `startDate`, `section`, `department`, `position`, `role`, `password`, `isDeleted`) VALUES
(36, 'Lourdes', 'Wairimu', 'Nganga', 'lnganga ', 'lourdeswairimu@gmail.com', '2023-07-14', 'Mobikey', 'Logistics', 'Test', 'HOD', 'c74b344b647fa17625eb510adcf9b3b8', 0),
(37, 'Human', 'Resource', 'Manager', 'hmanager ', 'muigaisam65@gmail.com', '2023-07-14', 'Mobikey', 'Finance', 'HR Manager', 'HR', '8e073d13fe09d03c927c52a05a509c9e', 0),
(50, 'Simon', 'Kamau', 'Ndungu', 'sndungu', 'ndungu.muigai01@gmail.com', '2023-12-10', 'Mobikey', 'Logistics', 'Test', 'User', '936730cba6a4bcef3f9e16d3a0b4f9c0', 0),
(51, 'Samuel', 'Kamau', 'Kiuna', 'skiuna', 'samuel.muigai@strathmore.edu', '2023-10-17', 'Mobikey', 'Admin', 'GM', 'General Manager', 'a126c34ba3f7931d82467b76b9d8282d', 0);

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
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
