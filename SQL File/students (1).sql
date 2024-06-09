-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 06:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srmis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `studentno` varchar(255) NOT NULL,
  `last-name` varchar(255) DEFAULT NULL,
  `first-name` varchar(255) DEFAULT NULL,
  `middle-name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` int(15) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `village-house-no` varchar(255) DEFAULT NULL,
  `studentImage` varchar(255) DEFAULT NULL,
  `postingDate` timestamp NULL DEFAULT current_timestamp(),
  `parent_id` int(50) DEFAULT NULL,
  `last_school` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `studentno`, `last-name`, `first-name`, `middle-name`, `suffix`, `age`, `gender`, `email`, `phone`, `province`, `city`, `barangay`, `village-house-no`, `studentImage`, `postingDate`, `parent_id`, `last_school`) VALUES
(71, '2024909897', 'Chan', 'Ed Kristopher', 'Sundo', '', 1, 'Male', 'chanedkristopher@gmail.com', 2147483647, '0712', '071218', '071218015', 'asdasdsa', 'download.jpg', '2024-06-01 05:19:20', 39, 'askhjhsa'),
(140, '2024196836', 'Macalawa', 'Mark Jayson', 'Cuenca', '', 22, 'Male', 'macalawamarkjayson@gmail.com', 91645783, '0421', '042108', '042108012', '111233', 'download (1).jpg', '2024-06-03 15:42:16', 108, 'pascam national high school'),
(146, '2024782152', 'Lovino', 'Ryniel', 'Mark', '', 22, 'Male', 'lovinorynielmark@gmail.com', 2147483647, '0421', '042115', '0421', 'blk53 lot12 bella vista subd', '', '2024-06-09 06:11:26', 114, 'pascam national high school'),
(147, '2024434357', 'Lovino', 'Ryniel', 'Mark', '', 22, 'Female', 'lovinorynielmark@gmail.com', 2147483647, '0421', '042117', '0421', 'asdas', '', '2024-06-09 06:15:06', 115, 'pascam national high school'),
(149, '2024772417', 'Lovino', 'Ryniel', 'Mark', '', 22, 'Male', 'lovinorynielmark@gmail.com', 2147483647, '0421', '042117', '0421', 'asd', '', '2024-06-09 10:56:45', 117, 'pascam national high school'),
(150, '2024562570', 'Gutierrez', 'Ivan Elijah', 'Lovino', '', 18, 'Male', '', 0, '0712', '071215', '0712', 'blk53 lot12 bella vista subd', '', '2024-06-09 12:18:53', 118, 'pascam national high school');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentno` (`studentno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
