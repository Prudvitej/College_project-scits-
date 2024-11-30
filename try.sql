-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 06:02 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `try`
--

-- --------------------------------------------------------

--
-- Table structure for table `reg`
--

CREATE TABLE `reg` (
  `hallTicketNumber` varchar(11) DEFAULT NULL,
  `subject_Name` varchar(100) DEFAULT NULL,
  `submission_time` varchar(11) NOT NULL,
  `YEAR` int(2) NOT NULL,
  `SEM` int(2) NOT NULL,
  `regulation` varchar(5) NOT NULL,
  `SEM_TYPE` varchar(20) NOT NULL,
  `AMOUNT` int(50) NOT NULL,
  `FINE` varchar(50) NOT NULL,
  `TOTAL_AMOUNT` int(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `subapp` varchar(10) NOT NULL,
  `lab_count` varchar(10) NOT NULL,
  `REG_FORM_NUMBER` varchar(100) NOT NULL,
  `MOB_NO` varchar(11) NOT NULL,
  `Lab_Names` varchar(100) NOT NULL,
  `program` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `Name` varchar(100) NOT NULL,
  `User_name` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Mob_no` varchar(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`Name`, `User_name`, `Password`, `Mob_no`, `status`) VALUES
('Prudvi Teja', 'Bunny', 'Bunny@1158', '9182520644', 'approved'),
('SCITS', 'Scit', 'Scit@2024', '9876543210', 'approved');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
