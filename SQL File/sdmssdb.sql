-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 08:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdmssdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `studentno` varchar(255) NOT NULL,
  `studentName` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contactno` int(10) DEFAULT NULL,
  `nextphone` int(10) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `village-house-no` varchar(255) DEFAULT NULL,
  `studentImage` varchar(255) DEFAULT NULL,
  `parentName` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `updationDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `studentno`, `studentName`, `age`, `gender`, `email`, `contactno`, `nextphone`, `province`, `city`, `barangay`, `village-house-no`, `studentImage`, `parentName`, `relation`, `occupation`, `postingDate`, `updationDate`) VALUES
(10, 'U0001', 'Betty Gloriaa', 15, 'Female', 'gloria@gmail.com', 770546590, 757537271, 'United States', 'Kenburg', 'United State', 'Andrea', 'face5.jpg', 'Ketty Perry4', 'Mother', 'Doctor', '2021-01-19 13:22:01', NULL),
(16, 'U0002', 'Harry Morgan', 16, 'Male', 'morgan@gmail.com', 770546590, 775456789, 'Chaina', 'Hongkong', 'Kongoh', 'Kongberry', 'face22.jpg', 'Agaba James', 'Father', 'Lecture', '2021-05-05 19:58:04', NULL),
(20, 'U0003', 'George Williams ', 20, 'Male', 'williams@gmail.com', 770546590, 770546598, 'Uganda', 'Kampala', 'Kampala', 'Muyenga', 'face3.jpg', 'Toney  Rushford', 'Father', 'Engineer', '2021-07-06 12:58:19', NULL),
(21, 'U004', 'Mickie Dorothy ', 17, 'Female', 'gerald@gmail.com', 770546590, 757537271, 'Uganda', 'Kampala', 'Kampala', 'Muyenga', 'face26.jpg', 'Arinaitwe Gerald', 'Father', 'Engineer', '2021-07-20 20:37:36', NULL),
(23, '123213', 'YANYAN', 43, 'Male', 'betlog@gmail.com', 0, 2147483647, 'Uganda', 'asdasr', 'awrwets', 'aedaetytr', '1233.jpg', 'qwe', 'Mother', 'Engineer', '2024-05-07 16:04:50', NULL),
(24, '12321311', 'YANYAN', 43, 'Male', '09354972842', 0, 2147483647, 'cavite', 'cavite city', 'sakjd', 'alkjdlasjk', 'chan ed kristopher.jpg', 'qwe', 'Father', 'Software developer', '2024-05-07 20:43:55', NULL),
(25, '789455', 'YANYAN', 43, 'Male', '09051948819', 50, 2147483647, 'cavite', 'cavite city', 'sakjd', 'aedaetytr', '328861007_854704185618197_3369280362466685826_n.jpg', 'qwe', 'Mother', 'Software developer', '2024-05-07 20:51:02', NULL),
(26, '12321311', 'YANYAN', 43, 'Male', '09354972842', 0, 2147483647, 'cavite', 'cavite city', 'sakjd', 'alkjdlasjk', 'chan ed kristopher.jpg', 'qwe', 'Father', 'Software developer', '2024-05-07 20:43:55', NULL),
(27, '789455', 'YANYAN', 43, 'Male', '09051948819', 50, 2147483647, 'cavite', 'cavite city', 'sakjd', 'aedaetytr', '328861007_854704185618197_3369280362466685826_n.jpg', 'qwe', 'Mother', 'Software developer', '2024-05-07 20:51:02', NULL),
(28, '12321311', 'YANYAN', 43, 'Male', '09354972842', 0, 2147483647, 'cavite', 'cavite city', 'sakjd', 'alkjdlasjk', 'chan ed kristopher.jpg', 'qwe', 'Father', 'Software developer', '2024-05-07 20:43:55', NULL),
(29, '789455', 'YANYAN', 43, 'Male', '09051948819', 50, 2147483647, 'cavite', 'cavite city', 'sakjd', 'aedaetytr', '328861007_854704185618197_3369280362466685826_n.jpg', 'qwe', 'Mother', 'Software developer', '2024-05-07 20:51:02', NULL),
(30, '12321311', 'YANYAN', 43, 'Male', '09354972842', 0, 2147483647, 'cavite', 'cavite city', 'sakjd', 'alkjdlasjk', 'chan ed kristopher.jpg', 'qwe', 'Father', 'Software developer', '2024-05-07 20:43:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` int(11) NOT NULL,
  `userimage` varchar(255) NOT NULL DEFAULT 'but.jpg',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `name`, `lastname`, `username`, `email`, `sex`, `permission`, `password`, `mobile`, `userimage`, `status`) VALUES
(15, 'Ed Kristopher', 'Chan', 'admin', 'chanedkristopher@gmail.com', 'Male', 'Super User', '81dc9bdb52d04dc20036dbd8313ed055', 770546590, 'face19.jpg', 1),
(20, 'Rihanna', 'Gloria ', 'gloria', 'gloria@gmail.com', 'Female', 'Admin', '81dc9bdb52d04dc20036dbd8313ed055', 770546590, 'face23.jpg', 0),
(21, 'Ryniel', 'Lovino', 'rynielmark', 'lovinorynielmark@gmail.com', 'Male', 'Admin', 'a0668b4ee6180714a61c40a09144aec5', 912312312, 'e39430434d2b8207188f880ac66c6411.png', 1),
(22, 'Ryniel', 'Chan', 'rynielmark15', 'lovinorynielmark@gmail.com', 'Male', 'Admin', 'a0668b4ee6180714a61c40a09144aec5', 912312312, 'but.jpg', 1),
(23, 'IanYan', 'Tolentino', 'IanYan', 'chanedkristopher@gmail.com', 'Male', 'Super User', '81dc9bdb52d04dc20036dbd8313ed055', 912312312, 'but.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `userEmail` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `userip` binary(16) DEFAULT NULL,
  `loginTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `username`, `name`, `lastname`, `userEmail`, `userip`, `loginTime`, `logout`, `status`) VALUES
(204, 'admin', 'John', 'Smith', 'john@gmail.com', 0x3a3a3100000000000000000000000000, '2021-07-20 20:55:14', '20-07-2021 11:55:31 PM', 1),
(205, 'gloria', 'Potential Hacker', NULL, 'Not registered in system', 0x3a3a3100000000000000000000000000, '2021-07-20 20:55:45', NULL, 0),
(207, 'gloria', 'Rihanna', 'Gloria ', 'gloria@gmail.com', 0x3a3a3100000000000000000000000000, '2021-07-20 20:57:48', '20-07-2021 11:57:52 PM', 1),
(208, 'mike', 'Potential Hacker', NULL, 'Not registered in system', 0x3a3a3100000000000000000000000000, '2021-07-20 20:58:17', NULL, 0),
(209, 'admin', 'John', 'Smith', 'john@gmail.com', 0x3a3a3100000000000000000000000000, '2021-07-20 20:58:26', '20-07-2021 11:59:20 PM', 1),
(210, 'admin', 'John', 'Smith', 'john@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 16:03:06', '07-05-2024 08:06:57 PM', 1),
(211, 'rynielmark', 'Ryniel', 'Lovino', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 17:07:05', NULL, 1),
(212, 'rynielmark', 'Ryniel', 'Lovino', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 17:45:30', '07-05-2024 08:46:07 PM', 1),
(213, 'lovinorynielmark@gmail.com', 'Potential Hacker', NULL, 'Not registered in system', 0x3a3a3100000000000000000000000000, '2024-05-07 17:47:00', NULL, 0),
(214, 'rynielmark', 'Ryniel', 'Lovino', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 17:47:11', '07-05-2024 08:49:06 PM', 1),
(215, 'rynielmark', 'Ryniel', 'Lovino', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 17:49:13', '07-05-2024 08:49:20 PM', 1),
(216, 'rynielmark', 'Potential Hacker', NULL, 'Not registered in system', 0x3a3a3100000000000000000000000000, '2024-05-07 18:01:23', NULL, 0),
(217, 'rynielmark', 'Ryniel', 'Lovino', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 18:15:37', '07-05-2024 09:20:22 PM', 1),
(218, 'rynielmark', 'Ryniel', 'Chan', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 18:20:29', '07-05-2024 09:22:07 PM', 1),
(219, 'rynielmark15', 'Ryniel', 'Chan', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 18:22:19', '07-05-2024 09:23:45 PM', 1),
(220, 'rynielmark15', 'Ryniel', 'Chan', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 18:23:55', '07-05-2024 09:35:26 PM', 1),
(221, 'rynielmark', 'Potential Hacker', NULL, 'Not registered in system', 0x3a3a3100000000000000000000000000, '2024-05-07 18:37:35', NULL, 0),
(222, 'rynielmark', 'Ryniel', 'Lovino', 'lovinorynielmark@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 18:37:45', '08-05-2024 01:42:44 AM', 1),
(223, 'IanYan', 'IanYan', 'Tolentino', 'chanedkristopher@gmail.com', 0x3a3a3100000000000000000000000000, '2024-05-07 22:42:51', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
