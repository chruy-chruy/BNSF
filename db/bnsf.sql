-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 07:14 AM
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
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` varchar(100) NOT NULL,
  `section_id` varchar(100) NOT NULL,
  `grade_level` varchar(100) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `quarter` varchar(100) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `grade` varchar(100) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `section_id`, `grade_level`, `semester`, `quarter`, `subject_id`, `grade`, `remarks`, `created_at`, `updated_at`) VALUES
(6, '15', '3', '11', '1', '1', '4', '75', 'Passed', '2025-02-17 16:19:48', '2025-03-07 08:31:33'),
(7, '15', '3', '11', '1', '2', '4', '87', 'Passed', '2025-02-17 16:19:53', '2025-02-17 16:19:53'),
(8, '14', '3', '11', '1', '1', '4', '100', 'Passed', '2025-03-07 15:57:51', '2025-03-07 15:57:51'),
(9, '14', '3', '11', '1', '2', '4', '99', 'Passed', '2025-03-07 16:04:30', '2025-03-07 16:04:30'),
(10, '14', '3', '11', '1', '1', '1', '89', 'Passed', '2025-03-07 16:17:50', '2025-03-07 16:17:50'),
(11, '14', '3', '11', '1', '2', '1', '95', 'Passed', '2025-03-07 16:17:55', '2025-03-07 16:17:55');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `quarter` varchar(100) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `grade_level` varchar(100) NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `monday` varchar(255) DEFAULT NULL,
  `tuesday` varchar(255) DEFAULT NULL,
  `wednesday` varchar(255) DEFAULT NULL,
  `thursday` varchar(255) DEFAULT NULL,
  `friday` varchar(255) DEFAULT NULL,
  `school_year` varchar(100) NOT NULL,
  `adviser` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `section`, `quarter`, `semester`, `grade_level`, `time_from`, `time_to`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `school_year`, `adviser`, `created_at`) VALUES
(33, '3', '', '2', '12', '11:16:00', '00:16:00', '7', '7', '7', '7', '7', '2025-2026', '2', '2025-02-17 14:16:47'),
(34, '3', '', '1', '11', '07:30:00', '08:30:00', '1', '1', '1', '1', '1', '2025-2026', '1', '2025-03-04 16:28:09'),
(35, '3', '', '1', '11', '15:00:00', '16:00:00', '4', '4', '4', '4', '4', '2025-2026', '1', '2025-03-07 07:50:54'),
(37, '3', '', '1', '11', '23:50:00', '00:50:00', 'Break', 'Break', 'Break', 'Break', 'Break', '2025-2026', '1', '2025-03-07 15:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_section`
--

CREATE TABLE `schedule_section` (
  `id` int(11) NOT NULL,
  `adviser` varchar(100) NOT NULL,
  `school_year` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_subject`
--

CREATE TABLE `schedule_subject` (
  `id` int(11) NOT NULL,
  `section` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `school_year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_subject`
--

INSERT INTO `schedule_subject` (`id`, `section`, `subject`, `type`, `semester`, `school_year`) VALUES
(2, '3', '1', 'Core', '1', '2025-2026'),
(3, '3', '4', 'Specialized', '1', '2025-2026'),
(4, '3', '1', 'Core', '2', '2025-2026');

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
(3, 'TVL', '', 'AGA', 'Agriculture Arts', '', 'active'),
(5, 'Academic', 'ABM-1', 'ABM', 'Accountancy, Business, and Management', '', 'active'),
(6, 'TVL', '', ' HE Cookery', 'HE (Home Economics) Cookery\r\n', '', 'active'),
(7, 'TVL', '', 'HE Food Processing', 'HE (Home Economics) Food Processing\r\n', '', 'active'),
(8, 'TVL', '', 'ICT', 'Information and Communication Technology', '', 'active'),
(9, 'TVL', '', 'FA', 'Fishery Arts\r\n', '', 'active');

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
  `grade_11` varchar(100) NOT NULL,
  `grade_12` varchar(100) NOT NULL,
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

INSERT INTO `student` (`id`, `lrn`, `first_name`, `middle_name`, `last_name`, `gender`, `age`, `nationality`, `birthday`, `address`, `contact`, `email`, `mothers_name`, `mothers_occupation`, `fathers_name`, `fathers_occupation`, `strand`, `grade_11`, `grade_12`, `grade_level`, `username`, `password`, `del_status`, `created_at`, `updated_at`) VALUES
(4, '1231232131231', 'Troy', '', 'Garidos', 'Male', '20', 'filipino', '2004-12-12', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'test32@gmail.com', 'Mama', 'House Wife', 'Tedmer Garidos', 'Mechanic', '', '3', '5', '12', 'test32@gmail.com', '1231232131231', 'active', '2024-12-07 14:45:53', '2025-03-09 06:13:15'),
(12, '1231231232131', 'Onyok', '', 'Dela Cruz', 'Male', '17', 'filipino', '2007-03-22', 'Lagao General Santos City', '09269883740', 'onyok@gmail.com', 'Mama', 'House Wife', 'Papa', 'Driver', '', '', '3', '12', 'onyok@gmail.com', '1231231232131', 'active', '2025-02-09 12:29:34', '2025-03-09 06:12:27'),
(14, '1231231222222', 'May', '', 'Cruz', 'Female', '18', 'filipino', '2007-02-01', 'Lagao General Santos City', '09269883740', 'cruz@gmail.com', 'Mama', '', 'Papa', '', '', '3', '', '11', 'cruz@gmail.com', '1231231222222', 'active', '2025-02-13 12:55:05', '2025-02-13 12:57:21'),
(15, '0239283451123', 'Myka Claire', '', 'Lugan', 'Male', '18', 'filipino', '2006-11-11', 'Purok 15 Zone 4 Lagao. General Santos City', '132131', 'myka@gmail.com', 'Mama', '', 'Papa', '', '', '3', '', '11', 'myka@gmail.com', '0239283451123', 'active', '2025-02-17 13:26:03', '2025-03-09 06:10:30');

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
  `grade_level` varchar(100) NOT NULL,
  `del_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `code`, `name`, `details`, `teacher_id`, `grade_level`, `del_status`) VALUES
(1, 'Fil 101', '', 'Filipino', '2', '11', 'active'),
(2, '23', '123', '21', '1', '12', 'deleted'),
(3, 'Fil101', 'Filipino', 'Filipino', '1', '11', 'deleted'),
(4, 'Eng 101', '', 'English in the modern world', '1', '11', 'active'),
(5, 'Fil 102', 'Filipino', 'Filipino', '2', '12', 'active'),
(6, 'His 101', 'History ', 'History ', '2', '12', 'active'),
(7, 'test 12', '', '123', '1', '12', 'active');

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
(1, '1231231', 'Dela Cruz', 'Fernando', 'Juan', 'Male', '21', 'filipino', '2003-11-11', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'juan@gmail.com', 'juan@gmail.com', '1231231', 'active', '2024-10-24 15:52:31'),
(2, '1231232', 'Dalisay', 'Fernandez', 'Cardo', 'Male', '', '', '1989-02-11', 'Purok 15 Zone 4 Lagao. General Santos City', '09269883740', 'cardo@gmail.com', 'cardo@gmail.com', '1231232', 'active', '2024-11-18 11:47:34');

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
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_section`
--
ALTER TABLE `schedule_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_subject`
--
ALTER TABLE `schedule_subject`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `schedule_section`
--
ALTER TABLE `schedule_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule_subject`
--
ALTER TABLE `schedule_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `strand`
--
ALTER TABLE `strand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
