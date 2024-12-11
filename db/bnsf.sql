-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 01:49 PM
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
-- Database: `bnsf`
--

-- --------------------------------------------------------

--
-- Table structure for table `strand`
--

CREATE TABLE `strand` (
  `id` int(11) NOT NULL,
  `track` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(100) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `del_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `strand`
--

INSERT INTO `strand` (`id`, `track`, `code`, `name`, `details`, `teacher_id`, `del_status`) VALUES
(2, 'TVL', 'HE', 'Home Economics', '21321312', '2', 'deleted'),
(3, 'TVL', 'AFA-1', 'AFA', 'Agri- Fishery Arts', '1', 'active'),
(5, 'Academic', 'ABM-1', 'ABM', 'Accountancy, Business, and Management', '2', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `lrn` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `age` varchar(11) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mothers_name` varchar(100) NOT NULL,
  `mothers_occupation` varchar(100) DEFAULT NULL,
  `fathers_name` varchar(100) NOT NULL,
  `fathers_occupation` varchar(100) DEFAULT NULL,
  `strand` varchar(100) NOT NULL,
  `grade_level` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `del_status` enum('active','deleted') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `lrn`, `first_name`, `middle_name`, `last_name`, `gender`, `age`, `nationality`, `birthday`, `address`, `contact`, `email`, `mothers_name`, `mothers_occupation`, `fathers_name`, `fathers_occupation`, `strand`, `grade_level`, `username`, `password`, `del_status`, `created_at`, `updated_at`) VALUES
(1, '1233211233', 'Onyok', '', 'Dela Cruz', 'Male', '17', 'filipino', '2007-03-22', 'Lagao General Santos City', '09269883740', 'onyok@gmail.com', 'Mama', 'House Wife', 'Papa', 'Driver', '3', '11', 'onyok@gmail.com', '1233211233', 'active', '2024-11-25 12:43:17', '2024-12-09 13:57:37'),
(2, '1232131231231', 'Asd', '', 'Ad', 'Male', '23', 'filipino', '2003-02-11', '1231231', '09269883740', 'newacc.troy@gmail.com', 'Mary', 'Sales Agent', 'Tedmer Garidos', 'Mechanic', '3', '12', 'newacc.troy@gmail.com', '1232131231231', 'active', '2024-12-07 14:41:11', '2024-12-09 12:40:23'),
(3, '1321321313123', 'Asd', '', 'Ad12321', 'Male', '0', 'filipino', '2024-12-07', '12', '132131', 'test2@gmail.com', 'Mama', 'House Wife', 'Papa', 'Driver', '5', '', 'test2@gmail.com', '1321321313123', 'active', '2024-12-07 14:43:46', '2024-12-09 12:44:50'),
(4, '1231232131231', 'Asd', 'Ancino', 'Ad131232132131', 'Male', '0', 'filipino', '0000-00-00', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'test32@gmail.com', 'Mama', 'House Wife', 'Tedmer Garidos', 'Mechanic', '5', '11', 'test32@gmail.com', '1231232131231', 'active', '2024-12-07 14:45:53', '2024-12-09 12:44:58'),
(5, '1232131313131', 'Troy Michael', 'Ancino', '12312', 'Male', '19', 'filipino', '2005-12-07', 'Purok Masagana', '09269883740', 'newacc.troy2@gmail.com', 'Mary', 'House Wife', 'Tedmer Garidos', 'Mechanic', '5', '12', 'newacc.troy2@gmail.com', '1232131313131', 'active', '2024-12-07 15:16:02', '2024-12-09 12:45:05'),
(6, '1322131231232', 'Asd', 'Ancino', 'Adtretretete', 'Male', '24', 'filipino', '2000-02-11', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'newacc22.troy@gmail.com', 'Mama', 'House Wife', 'Jose', 'Driver', '3', '12', 'newacc22.troy@gmail.com', '1322131231232', 'active', '2024-12-07 15:16:56', '2024-12-09 12:45:10'),
(7, '1232132131231', 'Troy Michael', 'Ancino', 'Test', 'Male', '20', 'filipino', '2004-02-11', 'Purok Masagana', '09269883740', 'garidos22222troymichael@gmail.com', 'Mary', 'House Wife', 'Tedmer Garidos', 'Driver', '3', '11', 'garidos22222troymichael@gmail.com', '1232132131231', 'active', '2024-12-09 13:05:53', '2024-12-09 13:57:42'),
(9, '1233211233123', 'Onyok', '', 'Dela Cruz', 'Male', '17', 'filipino', '2007-03-22', 'Lagao General Santos City', '09269883740', 'onyok@gmail.com', 'Mama', 'House Wife', 'Papa', 'Driver', '3', '12', 'onyok@gmail.com', '1233211233123', 'active', '2024-12-11 12:48:27', '2024-12-11 12:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(255) NOT NULL,
  `teacher_id` varchar(100) NOT NULL,
  `del_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `code`, `name`, `details`, `teacher_id`, `del_status`) VALUES
(1, 'Fil101', 'Filipino', 'Filipino', '2', 'active'),
(2, '23', '123', '21', '1', 'deleted'),
(3, 'Fil101', 'Filipino', 'Filipino', '1', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `age` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `del_status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`id`, `id_number`, `last_name`, `middle_name`, `first_name`, `gender`, `age`, `nationality`, `birthday`, `address`, `contact`, `email`, `username`, `password`, `del_status`, `created_at`) VALUES
(1, '123', 'Dela Cruz', 'Fernando', 'Juan', 'Male', '21', 'filipino', '2003-11-11', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'juan@gmail.com', 'juan@gmail.com', '123', 'active', '2024-10-24 15:52:31'),
(2, '123123', 'Dalisay', 'Fernandez', 'Cardo', 'Male', '', '', '1989-02-11', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'cardo@gmail.com', 'cardo@gmail.com', '123123', 'active', '2024-11-18 11:47:34');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `role`) VALUES
(1, 'Super Admin', 'admin', '123', 'Super Admin'),
(2, 'Jhon Doe', 'test123', '123', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `strand`
--
ALTER TABLE `strand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `strand`
--
ALTER TABLE `strand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
