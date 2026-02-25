-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2026 at 02:54 PM
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
-- Database: `ojt_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `colleges_programs`
--

CREATE TABLE `colleges_programs` (
  `id` int(11) NOT NULL,
  `college_department` varchar(200) NOT NULL,
  `program` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colleges_programs`
--

INSERT INTO `colleges_programs` (`id`, `college_department`, `program`) VALUES
(1, 'College of Agricultural Systems and Technology', 'Agriculture'),
(2, 'College of Agricultural Systems and Technology', 'Agro-Forestry'),
(3, 'College of Agricultural Systems and Technology', 'Fisheries'),
(4, 'College of Agricultural Systems and Technology', 'Forestry'),
(5, 'College of Agricultural Systems and Technology', 'Agricultural Business'),
(6, 'College of Agricultural Systems and Technology', 'Agricultural Economics'),
(7, 'College of Agricultural Systems and Technology', 'Development Communication'),
(8, 'College of Arts and Sciences', 'Biology'),
(9, 'College of Arts and Sciences', 'Mathematics'),
(10, 'College of Arts and Sciences', 'English Language Studies'),
(11, 'College of Arts and Sciences', 'Development Communication'),
(12, 'College of Business, Economics and Entrepreneurship', 'Agricultural Business'),
(13, 'College of Business, Economics and Entrepreneurship', 'Agricultural Economics'),
(14, 'College of Business, Economics and Entrepreneurship', 'Entrepreneurship'),
(15, 'College of Business, Economics and Entrepreneurship', 'Food Technology'),
(16, 'College of Business, Economics and Entrepreneurship', 'Hospitality Management'),
(17, 'College of Education', 'Elementary Education'),
(18, 'College of Education', 'Secondary Education'),
(19, 'College of Education', 'Physical Education'),
(20, 'College of Education', 'Technology and Livelihood Education'),
(21, 'College of Engineering and Computer Studies', 'Agricultural & Biosystems Engineering'),
(22, 'College of Engineering and Computer Studies', 'Civil Engineering'),
(23, 'College of Engineering and Computer Studies', 'Computer Engineering'),
(24, 'College of Engineering and Computer Studies', 'Information Technology'),
(25, 'College of Engineering and Computer Studies', 'Geodetic Engineering'),
(26, 'College of Veterinary Medicine', 'Veterinary Medicine'),
(27, 'College of Agricultural Systems and Technology', 'Agriculture'),
(28, 'College of Agricultural Systems and Technology', 'Agro-Forestry'),
(29, 'College of Agricultural Systems and Technology', 'Fisheries'),
(30, 'College of Agricultural Systems and Technology', 'Forestry'),
(31, 'College of Agricultural Systems and Technology', 'Agricultural Business'),
(32, 'College of Agricultural Systems and Technology', 'Agricultural Economics'),
(33, 'College of Agricultural Systems and Technology', 'Development Communication'),
(34, 'College of Arts and Sciences', 'Biology'),
(35, 'College of Arts and Sciences', 'Mathematics'),
(36, 'College of Arts and Sciences', 'English Language Studies'),
(37, 'College of Arts and Sciences', 'Development Communication'),
(38, 'College of Business, Economics and Entrepreneurship', 'Agricultural Business'),
(39, 'College of Business, Economics and Entrepreneurship', 'Agricultural Economics'),
(40, 'College of Business, Economics and Entrepreneurship', 'Entrepreneurship'),
(41, 'College of Business, Economics and Entrepreneurship', 'Food Technology'),
(42, 'College of Business, Economics and Entrepreneurship', 'Hospitality Management'),
(43, 'College of Education', 'Elementary Education'),
(44, 'College of Education', 'Secondary Education'),
(45, 'College of Education', 'Physical Education'),
(46, 'College of Education', 'Technology and Livelihood Education'),
(47, 'College of Engineering and Computer Studies', 'Agricultural & Biosystems Engineering'),
(48, 'College of Engineering and Computer Studies', 'Civil Engineering'),
(49, 'College of Engineering and Computer Studies', 'Computer Engineering'),
(50, 'College of Engineering and Computer Studies', 'Information Technology'),
(51, 'College of Engineering and Computer Studies', 'Geodetic Engineering'),
(52, 'College of Veterinary Medicine', 'Veterinary Medicine');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `college_department` varchar(150) NOT NULL,
  `program` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `college_program_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_number`, `password`, `first_name`, `last_name`, `college_department`, `program`, `email`, `contact_number`, `start_date`, `end_date`, `created_at`, `college_program_id`) VALUES
(3, 'C202202139', '', 'Michael Jay ', 'De Torres', 'CoECS - BS Information Technology', 'BS Information Technology', 'mjdetorres2139@iskwela.psau.edu.ph', '09678556789', '2026-02-12', '2026-04-13', '2026-02-12 02:12:08', NULL),
(8, 'C202202164', '$2y$10$VU0MRz6WrNWVdU9f62ArGe2zqq8zHhUSnspyre/2EciMhzvqh/8AG', 'Camille Phoebe ', 'Legaspi', 'CoECS - BS Information Technology', 'BS Information Technology', 'camillelegaspi@gmail.com', '09678556789', '2026-02-27', '2026-02-27', '2026-02-12 02:51:12', NULL),
(9, 'C202502145', '$2y$10$f5Uj5wxY3kiJsEvPRpHcWO/67hJRa/7q/mz9XyfFH5g1A2TY4NsT.', 'Renz', 'Reoliquio', 'CBEE - BS Hospitality Management', 'BS Hospitality Management', 'renzreo@gmail.com', '639678556789', '2026-02-14', '2026-02-20', '2026-02-12 06:26:24', NULL),
(10, 'C202202165', '$2y$10$vH5HvCGA7Zl13CcZyREuJOKKv1m7/Q3.BnZVCpytZn8btvXlTTtzS', 'Yesha', 'Guting', 'CoECS - BS Computer Engineering', 'BS Computer Engineering', 'yesha@email.com', '639764649267', '2026-02-10', '2026-10-13', '2026-02-16 01:28:06', NULL),
(11, 'C202502146', '$2y$10$.Od3iV3y5mzn4ZYM6i9CXe3AXcjUyYrGs7CbCeK3QHirrjC5eUpcG', 'Ivan', 'Miranda', 'CBEE - BS Food Technology', 'BS Food Technology', 'mmarcusivanmiranda@gmail.com', '09678556789', '2026-03-06', '2026-06-30', '2026-02-16 01:44:53', NULL),
(12, 'C202202201', '$2y$10$tn5wuFEkKVKxJD8R1EqZieq6EJoFboicnLd.kQTvYXCdxxAPOuKuu', 'DADDY', 'ROB', 'CAS - BS Biology', 'BS Biology', 'daddydiddy@gmail.com', '09123456789', '2026-02-03', '2026-10-22', '2026-02-16 02:46:46', NULL),
(13, 'C202502149', '$2y$10$CEkC1Q3AVu7Q7E5DiedhAOcGEp2aWN2tnC5vA2TyKrtGBF5h8C.QC', 'Leanna', 'Torres', 'COED - BEEd – Elementary Education', 'BEEd – Elementary Education', 'leanna@gmail.com', '09678556789', '2026-03-01', '2026-07-14', '2026-02-16 02:55:55', NULL),
(14, 'C202502150', '$2y$10$8uP/rt1/t/nQw6wqN4iODu/HQ.3cPh05b9cIu0ULymwKfJlL88gkq', 'Larry', 'Guarf', 'CAS - BA English Language Studies', 'BA English Language Studies', 'guarf@gmail.com', '639678556789', '2026-02-04', '2026-06-16', '2026-02-16 03:00:42', NULL),
(15, 'C202502147', '$2y$10$jpr259KdduIZG2iY1W3ywOMOqCbC.55vmQVBV7eKuOAPvgIb2N136', 'Mina', 'Chu', 'CVM - Doctor of Veterinary Medicine', 'Doctor of Veterinary Medicine', 'camillelegaspi@gmail.com', '09678556789', '2026-02-04', '2026-04-07', '2026-02-16 06:19:27', NULL),
(17, 'C202502157', '$2y$10$fBxhZXHo3LSiWPqibp1wuelBrPZjyr5YsSF7.ZtdBDpvV6us8FiMC', 'Aya', 'Mae', 'COED - BPED – Physical Education', 'BPED – Physical Education', 'camillelegaspi@gmail.com', '639678556789', '2026-03-12', '2026-03-14', '2026-02-16 06:29:46', NULL),
(18, 'C202502155', '$2y$10$oYz.z3irZ7ND9eoRyHqtoeHKzNclN7JtalS67JvqrShdbP4NNqoem', 'Michael Jay ', 'Legaspi', 'CBEE - BS Agricultural Business', 'BS Agricultural Business', 'camillelegaspi@gmail.com', '639678556789', '2026-03-03', '2026-03-07', '2026-02-16 06:38:49', NULL),
(19, 'C202502151', '$2y$10$qYtv2uGMT9jrUiEW1/IUMeBo7IvsNPEcCWuj8GUflwiJCxuqEfvw.', 'Joyce', 'Cayanan', 'CoECS - BS Information Technology', 'BS Information Technology', 'joyce@gmail.com', '09678556789', '2026-03-09', '2026-03-14', '2026-02-18 05:59:46', NULL),
(20, '202100919', '$2y$10$zFoZcpe7.RXBZkGmligMcePQC/MfRHCqFkxQnr0gzlT5HfNYQrZVC', 'Rotshchild Efprain', 'Salvador', 'CoECS - BS Information Technology', 'BS Information Technology', 'efprain@gmail.com', '09472361448', '2026-01-19', '0000-00-00', '2026-02-18 06:12:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `name`, `email`) VALUES
(1, 'Dr. Maria Santos', ''),
(2, 'Mr. John Reyes', ''),
(3, 'Ms. Ana Cruz', '');

-- --------------------------------------------------------

--
-- Table structure for table `time_records`
--

CREATE TABLE `time_records` (
  `id` int(11) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `student_name` varchar(150) NOT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL,
  `accomplishment` text DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `esig_requested` tinyint(1) DEFAULT 0,
  `supervisor_esig` varchar(150) DEFAULT NULL,
  `record_date` date NOT NULL,
  `period` varchar(5) NOT NULL DEFAULT 'AM',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_records`
--

INSERT INTO `time_records` (`id`, `student_number`, `student_name`, `total_hours`, `accomplishment`, `supervisor_id`, `esig_requested`, `supervisor_esig`, `record_date`, `period`, `created_at`) VALUES
(1, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'make coffee for you honeybuchsugarplum~~', NULL, 0, 'Dr. Reyes', '2026-02-12', 'AM', '2026-02-12 03:12:13'),
(2, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'adwadw', NULL, 0, 'Dr. Reyes', '2026-02-12', 'AM', '2026-02-12 03:18:09'),
(3, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'rtrrtdt', NULL, 0, 'Prof. Santos', '2026-02-12', 'AM', '2026-02-12 03:18:50'),
(4, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'sfsefsef', NULL, 0, 'Engr. Cruz', '2026-02-12', 'AM', '2026-02-12 03:21:16'),
(5, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'sfsefes', NULL, 0, 'Engr. Cruz', '2026-02-12', 'AM', '2026-02-12 03:33:15'),
(6, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'ad', NULL, 0, 'Dr. Reyes', '2026-02-12', 'AM', '2026-02-12 03:41:10'),
(7, 'C202202164', 'Camille Phoebe  Legaspi', NULL, 'sfs', NULL, 0, 'Dr. Reyes', '2026-02-12', 'AM', '2026-02-12 03:49:27'),
(8, 'C202202164', 'Camille Phoebe  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 03:59:53'),
(9, 'C202202164', 'Camille Phoebe  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 04:00:39'),
(10, 'C202202164', 'Camille Phoebe  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 04:02:17'),
(11, 'C202202164', 'Camille Phoebe  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 04:04:20'),
(12, 'C202502145', 'Renz Reoliquio', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 06:27:19'),
(13, 'C202502145', 'Renz Reoliquio', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 06:34:11'),
(14, 'C202202164', 'Camille Phoebe  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 06:39:16'),
(15, 'C202502145', 'Renz Reoliquio', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 06:47:52'),
(16, 'C202502145', 'Renz Reoliquio', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 07:06:31'),
(17, 'C202502145', 'Renz Reoliquio', NULL, NULL, NULL, 0, NULL, '2026-02-12', 'AM', '2026-02-12 07:20:33'),
(18, 'C202202164', 'Camille Phoebe  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 00:31:15'),
(20, 'C202202165', 'Yesha Guting', 0.00, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 01:28:40'),
(21, 'C202502146', 'Ivan Miranda', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 01:45:19'),
(22, 'C202202201', 'DADDY ROB', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 02:47:18'),
(23, 'C202502149', 'Leanna Torres', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 02:56:06'),
(26, 'C202202165', 'Yesha Guting', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'PM', '2026-02-16 05:58:50'),
(30, 'C202502147', 'Mina Chu', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 06:28:50'),
(31, 'C202502157', 'Aya Mae', NULL, NULL, NULL, 0, NULL, '2026-02-16', 'PM', '2026-02-16 06:30:02'),
(36, 'C202502155', 'Michael Jay  Legaspi', 0.00, NULL, NULL, 0, NULL, '2026-02-16', 'AM', '2026-02-16 07:30:21'),
(38, 'C202502145', 'Renz Reoliquio', 0.00, 'ahh daddy', 2, 1, NULL, '2026-02-16', 'AM', '2026-02-16 08:46:58'),
(39, 'C202502150', 'Larry Guarf', 0.00, 'coding', 2, 1, NULL, '2026-02-16', 'AM', '2026-02-16 08:53:06'),
(40, 'C202502145', 'Renz Reoliquio', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 01:30:06'),
(41, 'C202502150', 'Larry Guarf', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 01:32:31'),
(42, 'C202502155', 'Michael Jay  Legaspi', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 02:02:55'),
(43, 'C202202139', 'Michael Jay  De Torres', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 02:03:03'),
(44, 'C202202165', 'Yesha Guting', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 02:40:58'),
(45, 'C202502149', 'Leanna Torres', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 02:41:11'),
(46, 'C202502151', 'Joyce Cayanan', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 05:59:58'),
(47, '202100919', 'Rotshchild Efprain Salvador', NULL, NULL, NULL, 0, NULL, '2026-02-18', 'AM', '2026-02-18 06:12:31');

-- --------------------------------------------------------

--
-- Table structure for table `time_sessions`
--

CREATE TABLE `time_sessions` (
  `id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `period` enum('AM','PM') NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_sessions`
--

INSERT INTO `time_sessions` (`id`, `record_id`, `period`, `time_in`, `time_out`, `created_at`) VALUES
(1, 40, 'AM', '09:55:45', '09:55:53', '2026-02-18 01:55:45'),
(2, 40, 'AM', '09:56:02', '09:56:05', '2026-02-18 01:56:02'),
(3, 40, 'AM', '09:56:30', '09:56:36', '2026-02-18 01:56:30'),
(4, 40, 'AM', '09:56:45', '10:03:05', '2026-02-18 01:56:45'),
(5, 41, 'AM', '10:02:49', '10:27:20', '2026-02-18 02:02:49'),
(6, 42, 'AM', '10:02:55', NULL, '2026-02-18 02:02:55'),
(7, 43, 'AM', '10:03:03', '10:40:44', '2026-02-18 02:03:03'),
(8, 40, 'AM', '10:05:49', '10:05:52', '2026-02-18 02:05:49'),
(9, 40, 'AM', '10:06:00', '10:06:02', '2026-02-18 02:06:00'),
(10, 40, 'AM', '10:06:04', '10:06:06', '2026-02-18 02:06:04'),
(11, 40, 'AM', '10:06:07', '10:06:09', '2026-02-18 02:06:07'),
(12, 40, 'AM', '10:08:06', '10:08:08', '2026-02-18 02:08:06'),
(13, 40, 'AM', '10:08:08', '10:08:11', '2026-02-18 02:08:08'),
(14, 41, 'AM', '10:27:34', '10:27:47', '2026-02-18 02:27:34'),
(15, 41, 'AM', '10:28:45', '10:28:58', '2026-02-18 02:28:45'),
(16, 41, 'AM', '10:29:18', '10:30:28', '2026-02-18 02:29:18'),
(17, 40, 'AM', '10:32:55', '10:33:19', '2026-02-18 02:32:55'),
(18, 41, 'AM', '10:40:16', '10:40:30', '2026-02-18 02:40:16'),
(19, 44, 'AM', '10:40:58', NULL, '2026-02-18 02:40:58'),
(20, 45, 'AM', '10:41:11', NULL, '2026-02-18 02:41:11'),
(21, 40, 'AM', '10:43:36', '10:45:40', '2026-02-18 02:43:36'),
(22, 40, 'AM', '10:45:54', '10:47:38', '2026-02-18 02:45:54'),
(23, 40, 'AM', '10:47:52', '10:49:01', '2026-02-18 02:47:52'),
(24, 40, 'PM', '13:58:05', '13:58:30', '2026-02-18 05:58:05'),
(25, 46, 'PM', '13:59:58', NULL, '2026-02-18 05:59:58'),
(26, 47, 'PM', '14:12:31', NULL, '2026-02-18 06:12:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colleges_programs`
--
ALTER TABLE `colleges_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_number` (`student_number`),
  ADD UNIQUE KEY `student_number_2` (`student_number`),
  ADD KEY `fk_college_program` (`college_program_id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_records`
--
ALTER TABLE `time_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_sessions`
--
ALTER TABLE `time_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `record_id` (`record_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colleges_programs`
--
ALTER TABLE `colleges_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `time_records`
--
ALTER TABLE `time_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `time_sessions`
--
ALTER TABLE `time_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_college_program` FOREIGN KEY (`college_program_id`) REFERENCES `colleges_programs` (`id`);

--
-- Constraints for table `time_sessions`
--
ALTER TABLE `time_sessions`
  ADD CONSTRAINT `time_sessions_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `time_records` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
