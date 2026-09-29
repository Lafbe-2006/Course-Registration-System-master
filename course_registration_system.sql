-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2026 at 10:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course_registration_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Password`) VALUES
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Enrollment_No` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `First_Name` varchar(100) DEFAULT NULL,
  `Last_Name` varchar(100) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `Semester` int(11) DEFAULT NULL,
  `Journal_Number` varchar(100) DEFAULT NULL,
  `SGPA` decimal(4,2) DEFAULT NULL,
  `CGPA` decimal(4,2) DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  `Fee_Amount` decimal(10,2) DEFAULT NULL,
  `Subject_1` varchar(50) DEFAULT NULL,
  `Subject_2` varchar(50) DEFAULT NULL,
  `Subject_3` varchar(50) DEFAULT NULL,
  `Subject_4` varchar(50) DEFAULT NULL,
  `Subject_5` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Enrollment_No`, `Password`, `First_Name`, `Last_Name`, `Department`, `Semester`, `Journal_Number`, `SGPA`, `CGPA`, `Category`, `Fee_Amount`, `Subject_1`, `Subject_2`, `Subject_3`, `Subject_4`, `Subject_5`) VALUES
('CRM123', 'GMI123', 'MUHAMMAD AIMAN BIN', 'MOHD AMIN ', 'COMPUTER & INFORMATION DEPARTMENT', 5, '-', 3.73, 3.95, '-', 22928.00, 'CRM Final Project', 'Web Programming with PHP', 'Mobile Application Development', 'Multimedia Project Management', '-'),
('CRM456', 'GMI456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `Department` varchar(100) NOT NULL,
  `Course_Code` varchar(50) NOT NULL,
  `Course_Title` varchar(255) NOT NULL,
  `Course_Credit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`Department`, `Course_Code`, `Course_Title`, `Course_Credit`) VALUES
('COMPUTER & INFORMATION DEPARTMENT', 'IEP 0734CRM', 'CRM Final Project', 4),
('COMPUTER & INFORMATION DEPARTMENT', 'IMT 2442', 'Digital Entrepreneurship', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Enrollment_No`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`Course_Code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
