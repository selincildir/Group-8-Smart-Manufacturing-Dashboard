-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 13, 2024 at 04:09 PM
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
-- Database: `smd_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `factory_logs`
--

CREATE TABLE `factory_logs` (
  `log_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `machine_name` varchar(100) DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `pressure` float DEFAULT NULL,
  `vibration` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `power_consumption` float DEFAULT NULL,
  `operational_status` enum('active','maintenance','offline') DEFAULT NULL,
  `error_code` varchar(50) DEFAULT NULL,
  `production_count` int(11) DEFAULT NULL,
  `maintenance_log` text DEFAULT NULL,
  `speed` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `factory_logs`
--

INSERT INTO `factory_logs` (`log_id`, `timestamp`, `machine_name`, `temperature`, `pressure`, `vibration`, `humidity`, `power_consumption`, `operational_status`, `error_code`, `production_count`, `maintenance_log`, `speed`) VALUES
(1, '2024-04-01 00:00:00', 'CNC Machine', 45.47, 7.69, 1.86, 33.17, 270.22, 'active', NULL, 66, NULL, 4.27),
(2, '2024-04-01 00:00:00', '3D Printer', 71.18, 3.16, 0.24, 36.76, 330.36, 'active', NULL, 96, NULL, 3.35),
(3, '2024-04-01 00:00:00', 'Industrial Robot', 61.09, 6.81, 4.83, 62.59, 460.07, 'maintenance', 'E303', 73, 'Part Replacement', 3.41),
(4, '2024-04-02 00:00:00', 'CNC Machine', 72.44, 7.79, 4, 47.77, 420.9, 'active', NULL, NULL, NULL, 0.68),
(5, '2024-03-20 00:00:00', '3D Printer', 61.39, 3.07, 3.03, 34.4, 411.98, 'maintenance', 'E202', 25, 'Replace part', 3.22),
(6, '2024-04-19 00:00:00', 'Industrial Robot', 71.73, 4.01, 1.07, 67.15, 418.37, 'active', NULL, 3, NULL, 0.88),
(7, '2024-03-26 00:00:00', 'Automated Guided Vehicle (AGV)', 42.57, 6.75, 1.72, 60.24, 488.55, 'active', NULL, 47, NULL, NULL),
(8, '2024-07-04 00:00:00', 'Quality Control Scanner', 74.66, 3.22, 4.27, 67.8, 139.24, 'maintenance', 'E303', NULL, NULL, NULL),
(9, '2024-10-04 00:00:00', 'Energy Management System', 50.62, 6.21, 2.32, 34.8, 330.92, 'active', NULL, NULL, NULL, NULL),
(10, '2024-10-01 00:00:00', 'Energy Management System', 21.07, 5.4, 0.88, 49.23, 126.01, 'active', NULL, 80, NULL, NULL),
(18, '2024-10-13 21:52:47', 'Automated Guided Vehicle (AGV)', 45.47, 7.69, 1.86, 33.17, 270.22, 'maintenance', 'E303', NULL, NULL, 88),
(19, '2024-10-13 21:56:39', 'Automated Guided Vehicle (AGV)', 46, 3.56, 4.34, 38, 137, 'active', NULL, NULL, NULL, 45),
(20, '2024-10-13 22:09:41', 'Energy Management System', 56, 5.6, 4.8, 69, 168, 'active', NULL, NULL, NULL, 67);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` int(11) NOT NULL,
  `machine_name` varchar(100) DEFAULT NULL,
  `job_description` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `assigned_operator` varchar(100) DEFAULT NULL,
  `job_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_machine_id` int(100) UNSIGNED NOT NULL,
  `assigned_operator_id` int(100) UNSIGNED NOT NULL,
  `job_status` enum('pending','in_progress','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `machine_name`, `job_description`, `status`, `deadline`, `assigned_operator`, `job_name`, `description`, `assigned_machine_id`, `assigned_operator_id`, `job_status`) VALUES
(1, 'CNC Machine', NULL, 'active', NULL, NULL, 'Job 101', 'Cutting metal sheets using CNC Machine', 1, 3, 'pending'),
(2, '3D Printer', NULL, 'maintenance', NULL, NULL, 'Job 102', 'Printing custom parts with 3D Printer', 2, 1, 'completed'),
(3, 'Industrial Robot', NULL, 'maintenance', NULL, NULL, 'Job 103', 'Assembly of parts using Industrial Robot', 3, 2, 'in_progress'),
(6, NULL, NULL, 'active', NULL, NULL, 'Job 104', 'Software update of Quality Control Scanner', 4, 4, 'in_progress'),
(8, NULL, NULL, 'maintenance', NULL, NULL, 'Job 105', 'Repair IoT Sensor Hub', 2, 4, 'pending'),
(10, NULL, NULL, NULL, NULL, NULL, 'Job 106', 'Deploy Automated Guided Vehicle (AGV)', 1, 1, 'in_progress'),
(16, NULL, NULL, 'maintenance', NULL, NULL, 'Job 107', 'Remove parts from Smart Conveyor System', 2, 4, 'pending'),
(19, NULL, NULL, 'maintenance', NULL, NULL, 'Job 109', 'Update software for 3D Scanner', 1, 3, 'completed'),
(20, NULL, NULL, NULL, NULL, NULL, 'Job 108', 'Predictive Maintenance System upgrade', 3, 2, 'pending'),
(25, NULL, NULL, NULL, NULL, NULL, 'Job 111', 'Predictive Maintenance System upgrade', 2, 2, 'in_progress'),
(26, NULL, NULL, NULL, NULL, NULL, 'Job 112', 'Update software for Industrial Robot', 3, 2, 'pending'),
(32, NULL, NULL, NULL, NULL, NULL, 'Job 113', 'Replace part for CNC Machine', 58, 2, 'pending'),
(34, NULL, NULL, NULL, NULL, NULL, 'Job 114', 'Remove parts from Industrial Robot', 58, 1, 'pending'),
(36, NULL, NULL, NULL, NULL, NULL, 'Job 115', 'Test software for 3D Scanner', 2, 2, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `machine_id` int(11) NOT NULL,
  `machine_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `operational_status` enum('active','maintenance','idle') NOT NULL,
  `last_maintenance` date DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `pressure` float DEFAULT NULL,
  `vibration` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `power_consumption` float DEFAULT NULL,
  `error_code` varchar(50) DEFAULT NULL,
  `production_count` int(11) DEFAULT NULL,
  `maintenance_log` text DEFAULT NULL,
  `speed` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`machine_id`, `machine_name`, `description`, `operational_status`, `last_maintenance`, `temperature`, `pressure`, `vibration`, `humidity`, `power_consumption`, `error_code`, `production_count`, `maintenance_log`, `speed`) VALUES
(1, 'CNC Machine', 'Precision machining for parts manufacturing', 'idle', '2024-04-02', 45.47, 7.69, 1.86, 33.17, 270.22, 'E202', NULL, 'Catastrophic failure', NULL),
(2, '3D Printer', 'Additive manufacturing for small-scale production', 'maintenance', '2024-03-20', 23, 3.6, 4.9, 42, 146, '', NULL, 'Software Update', NULL),
(3, 'Industrial Robot', 'Automated assembly line robot', 'maintenance', '2024-04-19', 25, 3.9, 6.5, 68, 125, '', NULL, 'Routine Check', NULL),
(4, 'Automated Guided Vehicle (AGV)', 'Material transport within factory', 'active', '2024-03-26', 45, 4.23, 5.6, 76, 143, 'E404', NULL, 'Part Replacement', NULL),
(56, 'Quality Control Scanner', 'High performance scanner', 'active', '2024-07-04', 37.2, 3.28, 7.34, 42, 139.2, '', NULL, 'Routine Check', NULL),
(58, 'Energy Management System', 'Efficient energy manager', 'active', '2024-10-04', 75.81, 5.64, 4.37, 41.48, 489.45, '', NULL, '', NULL),
(61, '3D Printer', 'Fast and efficient printer system', 'maintenance', '2024-10-09', 45, 4.23, 4.9, 68, 143, '', NULL, '', NULL),
(63, 'CNC Machine', 'Parts manufacturing machine', 'maintenance', '2024-07-01', 46, 3.28, 4.37, 76, 489.45, 'E303', NULL, 'Part Replacement', NULL),
(65, 'Quality Control Scanner', 'High quality scanner', 'idle', '2024-07-05', 46, 3.9, 4.9, 42, 143, 'E303', NULL, 'Part Replacement', NULL),
(68, 'Energy Management System', 'Efficient energy manager', 'maintenance', '2024-09-02', 25, 3.9, 7.34, 42, 143, 'E202', NULL, '', NULL),
(69, 'Energy Management System', 'Efficient energy manager', 'maintenance', '2024-09-02', 25, 3.9, 7.34, 42, 143, 'E202', NULL, 'Software Update', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `machine_performance`
--

CREATE TABLE `machine_performance` (
  `performance_id` int(11) NOT NULL,
  `machine_name` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `temperature` float DEFAULT NULL,
  `pressure` float DEFAULT NULL,
  `vibration` float DEFAULT NULL,
  `humidity` float DEFAULT NULL,
  `power_consumption` float DEFAULT NULL,
  `average_power_consumption` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `machine_performance`
--

INSERT INTO `machine_performance` (`performance_id`, `machine_name`, `date`, `temperature`, `pressure`, `vibration`, `humidity`, `power_consumption`, `average_power_consumption`) VALUES
(1, 'CNC Machine', '2024-04-02', 45.47, 7.69, 1.86, 33.17, 270.22, 200.1),
(3, 'Industrial Robot', '2024-04-19', 25, 3.9, 6.5, 68, 125, 130),
(6, 'CNC Machine', '2024-04-03', 46, 7.7, 1.9, 34, 272, 198),
(8, 'Industrial Robot', '2024-04-20', 26, 4, 6.6, 69, 127, 113);

-- --------------------------------------------------------

--
-- Table structure for table `role_assignments`
--

CREATE TABLE `role_assignments` (
  `assignment_id` int(11) NOT NULL,
  `assigned_machine_id` int(11) DEFAULT NULL,
  `machine_name` varchar(100) DEFAULT NULL,
  `operator_id` int(11) NOT NULL,
  `machine_id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_assignments`
--

INSERT INTO `role_assignments` (`assignment_id`, `assigned_machine_id`, `machine_name`, `operator_id`, `machine_id`, `job_id`) VALUES
(1, 1, 'CNC Machine', 3, 1, 1),
(2, 2, '3D Printer', 3, 2, 2),
(3, NULL, NULL, 3, 1, NULL),
(4, NULL, NULL, 1, 2, NULL),
(5, NULL, NULL, 3, 1, NULL),
(8, NULL, NULL, 4, 4, NULL),
(9, NULL, NULL, 4, 2, NULL),
(10, NULL, NULL, 1, 3, NULL),
(13, NULL, NULL, 2, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `summary_reports`
--

CREATE TABLE `summary_reports` (
  `report_id` int(11) NOT NULL,
  `machine_name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_logs` int(11) DEFAULT NULL,
  `average_temperature` float DEFAULT NULL,
  `average_pressure` float DEFAULT NULL,
  `average_vibration` float DEFAULT NULL,
  `average_humidity` float DEFAULT NULL,
  `average_power_consumption` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `summary_reports`
--

INSERT INTO `summary_reports` (`report_id`, `machine_name`, `start_date`, `end_date`, `total_logs`, `average_temperature`, `average_pressure`, `average_vibration`, `average_humidity`, `average_power_consumption`) VALUES
(1, '3D Printer', '2024-03-01', '2024-10-04', 2, 71.18, 3.16, 0.24, 36.76, 330.36),
(2, 'Automated Guided Vehicle (AGV)', '2024-03-01', '2024-10-04', 1, NULL, NULL, NULL, NULL, NULL),
(3, 'CNC Machine', '2024-03-01', '2024-10-04', 2, 45.47, 7.69, 1.86, 33.17, 270.22),
(4, 'Energy Management System', '2024-03-01', '2024-10-04', 2, NULL, NULL, NULL, NULL, NULL),
(5, 'Industrial Robot', '2024-03-01', '2024-10-04', 2, 61.09, 6.81, 4.83, 62.59, 460.07),
(6, 'Quality Control Scanner', '2024-03-01', '2024-10-04', 1, NULL, NULL, NULL, NULL, NULL),
(7, 'Energy Management System', '2024-10-01', '2024-10-04', 2, NULL, NULL, NULL, NULL, NULL),
(8, 'Energy Management System', '2024-09-04', '2024-10-09', 2, NULL, NULL, NULL, NULL, NULL),
(9, 'Energy Management System', '2024-05-01', '2024-10-09', 2, NULL, NULL, NULL, NULL, NULL),
(10, 'Quality Control Scanner', '2024-05-01', '2024-10-09', 1, NULL, NULL, NULL, NULL, NULL),
(11, '3D Printer', '2024-02-07', '2024-10-09', 2, 71.18, 3.16, 0.24, 36.76, 330.36),
(12, 'Automated Guided Vehicle (AGV)', '2024-02-07', '2024-10-09', 1, NULL, NULL, NULL, NULL, NULL),
(13, 'CNC Machine', '2024-02-07', '2024-10-09', 2, 45.47, 7.69, 1.86, 33.17, 270.22),
(14, 'Energy Management System', '2024-02-07', '2024-10-09', 2, NULL, NULL, NULL, NULL, NULL),
(15, 'Industrial Robot', '2024-02-07', '2024-10-09', 2, 61.09, 6.81, 4.83, 62.59, 460.07),
(16, 'Quality Control Scanner', '2024-02-07', '2024-10-09', 1, NULL, NULL, NULL, NULL, NULL),
(17, 'Energy Management System', '2024-05-31', '2024-10-09', 2, NULL, NULL, NULL, NULL, NULL),
(18, 'Quality Control Scanner', '2024-05-31', '2024-10-09', 1, NULL, NULL, NULL, NULL, NULL),
(19, 'CNC Machine', '2024-04-02', '2024-10-12', 1, 72.44, 7.79, 4, 47.77, 420.9),
(20, 'Energy Management System', '2024-04-02', '2024-10-12', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(21, 'Industrial Robot', '2024-04-02', '2024-10-12', 1, 71.73, 4.01, 1.07, 67.15, 418.37),
(22, 'Quality Control Scanner', '2024-04-02', '2024-10-12', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(23, 'CNC Machine', '2024-04-02', '2024-10-12', 1, 72.44, 7.79, 4, 47.77, 420.9),
(24, 'Energy Management System', '2024-04-02', '2024-10-12', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(25, 'Industrial Robot', '2024-04-02', '2024-10-12', 1, 71.73, 4.01, 1.07, 67.15, 418.37),
(26, 'Quality Control Scanner', '2024-04-02', '2024-10-12', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(27, 'CNC Machine', '2024-04-02', '2024-10-12', 1, 72.44, 7.79, 4, 47.77, 420.9),
(28, 'Energy Management System', '2024-04-02', '2024-10-12', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(29, 'Industrial Robot', '2024-04-02', '2024-10-12', 1, 71.73, 4.01, 1.07, 67.15, 418.37),
(30, 'Quality Control Scanner', '2024-04-02', '2024-10-12', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(31, '3D Printer', '2023-11-29', '2024-10-11', 2, 66.285, 3.115, 1.635, 35.58, 371.17),
(32, 'Automated Guided Vehicle (AGV)', '2023-11-29', '2024-10-11', 1, 42.57, 6.75, 1.72, 60.24, 488.55),
(33, 'CNC Machine', '2023-11-29', '2024-10-11', 2, 58.955, 7.74, 2.93, 40.47, 345.56),
(34, 'Energy Management System', '2023-11-29', '2024-10-11', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(35, 'Industrial Robot', '2023-11-29', '2024-10-11', 2, 66.41, 5.41, 2.95, 64.87, 439.22),
(36, 'Quality Control Scanner', '2023-11-29', '2024-10-11', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(37, 'Energy Management System', '2024-04-04', '2024-10-12', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(38, 'Industrial Robot', '2024-04-04', '2024-10-12', 1, 71.73, 4.01, 1.07, 67.15, 418.37),
(39, 'Quality Control Scanner', '2024-04-04', '2024-10-12', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(40, 'Energy Management System', '2024-06-05', '2024-10-12', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(41, 'Quality Control Scanner', '2024-06-05', '2024-10-12', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(42, 'Energy Management System', '2024-05-01', '2024-10-12', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(43, 'Quality Control Scanner', '2024-05-01', '2024-10-12', 1, 74.66, 3.22, 4.27, 67.8, 139.24),
(44, 'Energy Management System', '2024-05-31', '2024-10-13', 2, 35.845, 5.805, 1.6, 42.015, 228.465),
(45, 'Quality Control Scanner', '2024-05-31', '2024-10-13', 1, 74.66, 3.22, 4.27, 67.8, 139.24);

-- --------------------------------------------------------

--
-- Table structure for table `task_notes`
--

CREATE TABLE `task_notes` (
  `note_id` int(11) NOT NULL,
  `machine_id` int(11) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `note_content` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `job_id` int(11) NOT NULL,
  `operator_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_notes`
--

INSERT INTO `task_notes` (`note_id`, `machine_id`, `operator`, `note`, `timestamp`, `created_by`, `assigned_to`, `note_content`, `created_at`, `job_id`, `operator_id`) VALUES
(1, NULL, NULL, NULL, '2024-10-04 00:56:23', 3, 2, 'Found unusual vibration in CNC Machine during operation.', '2024-10-03 20:45:03', 0, 0),
(2, NULL, NULL, NULL, '2024-10-04 00:56:23', 3, 2, 'AGV speed seems slower today, needs inspection.', '2024-10-03 20:45:03', 0, 0),
(3, NULL, NULL, 'The work has progressed.', '2024-10-06 11:13:11', NULL, NULL, NULL, '2024-10-06 21:43:11', 1, 3),
(4, NULL, NULL, 'The work is pending.', '2024-10-06 11:13:29', NULL, NULL, NULL, '2024-10-06 21:43:29', 1, 3),
(5, NULL, NULL, 'The work has progressed.', '2024-10-06 11:15:49', NULL, NULL, NULL, '2024-10-06 21:45:49', 1, 3),
(6, NULL, NULL, 'The work is pending.', '2024-10-06 11:18:07', NULL, NULL, NULL, '2024-10-06 21:48:07', 1, 3),
(7, NULL, NULL, 'progressing well', '2024-10-10 08:02:49', NULL, NULL, NULL, '2024-10-10 18:32:49', 1, 3),
(8, NULL, NULL, 'waiting some parts', '2024-10-10 08:27:34', NULL, NULL, NULL, '2024-10-10 18:57:34', 1, 3),
(9, NULL, NULL, 'Work in progress', '2024-10-13 10:18:30', NULL, NULL, NULL, '2024-10-13 20:48:30', 1, 3),
(10, NULL, NULL, 'Job completed successfully.', '2024-10-13 11:53:29', NULL, NULL, NULL, '2024-10-13 22:23:29', 19, 3),
(11, NULL, NULL, 'Work is pending', '2024-10-13 13:31:31', NULL, NULL, NULL, '2024-10-14 00:01:31', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('Administrator','Factory Manager','Production Operator','Auditor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin_user', 'admin_password_hash', 'Administrator'),
(2, 'manager_user', 'manager_password_hash', 'Factory Manager'),
(3, 'operator_user', 'operator_password_hash', 'Production Operator'),
(4, 'auditor_user', 'auditor_password_hash', 'Auditor'),
(7, 'admin_user2', '$2y$10$cBsd/94wvMG5AYEULWD7X.4K1e7O0mid8NXqK9SJx8PPeW4cgamyq', 'Administrator'),
(8, 'admin_user3', '$2y$10$2yM4bGNLMe82ZT9DilV1beDiOUVVDavpPbwVxOlTQUoRXH.dI2S/2', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `factory_logs`
--
ALTER TABLE `factory_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `assigned_machine_id` (`assigned_machine_id`),
  ADD KEY `assigned_operator_id` (`assigned_operator_id`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `machine_name` (`machine_name`);

--
-- Indexes for table `machine_performance`
--
ALTER TABLE `machine_performance`
  ADD PRIMARY KEY (`performance_id`),
  ADD KEY `fk_machine_name` (`machine_name`);

--
-- Indexes for table `role_assignments`
--
ALTER TABLE `role_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `machine_id` (`machine_id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `fk_assigned_machine_id` (`assigned_machine_id`),
  ADD KEY `operator_id` (`operator_id`);

--
-- Indexes for table `summary_reports`
--
ALTER TABLE `summary_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `fk_machine` (`machine_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `factory_logs`
--
ALTER TABLE `factory_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `machine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `machine_performance`
--
ALTER TABLE `machine_performance`
  MODIFY `performance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_assignments`
--
ALTER TABLE `role_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `summary_reports`
--
ALTER TABLE `summary_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `task_notes`
--
ALTER TABLE `task_notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `machine_performance`
--
ALTER TABLE `machine_performance`
  ADD CONSTRAINT `fk_machine_name` FOREIGN KEY (`machine_name`) REFERENCES `machines` (`machine_name`) ON DELETE CASCADE;

--
-- Constraints for table `role_assignments`
--
ALTER TABLE `role_assignments`
  ADD CONSTRAINT `fk_assigned_machine_id` FOREIGN KEY (`assigned_machine_id`) REFERENCES `machines` (`machine_id`),
  ADD CONSTRAINT `role_assignments_ibfk_1` FOREIGN KEY (`operator_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `role_assignments_ibfk_2` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`machine_id`),
  ADD CONSTRAINT `role_assignments_ibfk_3` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`job_id`);

--
-- Constraints for table `task_notes`
--
ALTER TABLE `task_notes`
  ADD CONSTRAINT `fk_machine` FOREIGN KEY (`machine_id`) REFERENCES `machines` (`machine_id`),
  ADD CONSTRAINT `task_notes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `task_notes_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
