-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2026 at 07:18 AM
-- Server version: 8.0.46-0ubuntu0.22.04.3
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `university_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int UNSIGNED NOT NULL,
  `course_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int UNSIGNED NOT NULL,
  `credit` decimal(3,1) NOT NULL DEFAULT '3.0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_code`, `course_name`, `department_id`, `credit`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CSE101', 'Introduction to Programming', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(2, 'CSE102', 'Structured Programming Lab', 1, '1.5', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(3, 'CSE201', 'Data Structures', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(4, 'CSE202', 'Algorithms', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(5, 'CSE203', 'Object Oriented Programming', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(6, 'CSE301', 'Database Management Systems', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(7, 'CSE302', 'Computer Networks', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(8, 'CSE401', 'Software Engineering', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(9, 'CSE402', 'Artificial Intelligence', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(10, 'CSE403', 'Web Engineering', 1, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(11, 'EEE101', 'Basic Electrical Engineering', 2, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(12, 'EEE102', 'Electrical Circuits Lab', 2, '1.5', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(13, 'EEE201', 'Digital Electronics', 2, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(14, 'EEE202', 'Electronic Devices & Circuits', 2, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(15, 'EEE301', 'Microprocessors & Microcontrollers', 2, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(16, 'EEE302', 'Power Systems', 2, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(17, 'EEE401', 'Control Systems', 2, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(18, 'BBA101', 'Principles of Management', 3, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(19, 'BBA102', 'Principles of Marketing', 3, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(20, 'BBA201', 'Financial Accounting', 3, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(21, 'BBA202', 'Business Communication', 3, '2.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(22, 'BBA301', 'Human Resource Management', 3, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(23, 'BBA302', 'Business Statistics', 3, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(24, 'BBA401', 'Strategic Management', 3, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(25, 'ENG101', 'English Fundamentals', 4, '2.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(26, 'ENG102', 'English Composition', 4, '2.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(27, 'ENG201', 'Introduction to Linguistics', 4, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(28, 'ENG202', 'British Literature', 4, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(29, 'ENG301', 'American Literature', 4, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(30, 'CE101', 'Engineering Mechanics', 5, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(31, 'CE102', 'Surveying', 5, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(32, 'CE201', 'Structural Analysis', 5, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(33, 'CE202', 'Building Materials', 5, '2.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(34, 'CE301', 'Concrete Technology', 5, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44'),
(35, 'CE401', 'Geotechnical Engineering', 5, '3.0', 1, '2026-08-27 07:16:44', '2026-08-27 07:16:44');

-- --------------------------------------------------------

--
-- Table structure for table `course_registration`
--

CREATE TABLE `course_registration` (
  `id` int UNSIGNED NOT NULL,
  `student_id` int UNSIGNED NOT NULL,
  `course_id` int UNSIGNED NOT NULL,
  `semester_id` int UNSIGNED NOT NULL,
  `session_id` int UNSIGNED NOT NULL,
  `registration_date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_registration`
--

INSERT INTO `course_registration` (`id`, `student_id`, `course_id`, `semester_id`, `session_id`, `registration_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2021-01-20', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(2, 1, 2, 1, 1, '2021-01-20', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(3, 2, 1, 1, 1, '2021-01-20', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(4, 2, 3, 2, 1, '2021-07-15', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(5, 3, 5, 1, 2, '2022-01-25', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(6, 3, 6, 2, 2, '2022-07-18', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(7, 4, 7, 1, 2, '2022-01-25', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(8, 4, 8, 2, 2, '2022-07-18', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(9, 5, 2, 1, 3, '2023-01-15', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(10, 5, 4, 2, 3, '2023-07-10', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(11, 6, 10, 1, 3, '2023-01-15', 0, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(12, 7, 9, 1, 4, '2024-01-08', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(13, 8, 3, 3, 1, '2021-07-15', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(14, 9, 1, 1, 1, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(15, 9, 3, 1, 1, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(16, 10, 1, 1, 1, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(17, 10, 2, 1, 1, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(18, 11, 11, 1, 1, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(19, 12, 18, 1, 2, '2026-05-05', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(20, 13, 19, 1, 2, '2026-05-05', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(21, 14, 30, 1, 2, '2026-05-05', 0, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(22, 15, 25, 1, 3, '2026-09-10', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(23, 19, 3, 3, 2, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(24, 20, 2, 1, 3, '2026-09-10', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(25, 21, 12, 3, 2, '2026-05-05', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(26, 23, 20, 3, 1, '2026-01-20', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42'),
(27, 27, 31, 1, 3, '2026-09-10', 1, '2026-08-27 07:17:42', '2026-08-27 07:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int UNSIGNED NOT NULL,
  `department_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `department_name`, `department_code`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Computer Science & Engineering', 'CSE', 'computer-science-engineering', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(2, 'Electrical & Electronic Engineering', 'EEE', 'electrical-electronic-engineering', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(3, 'Business Administration', 'BBA', 'business-administration', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(4, 'English', 'ENG', 'english', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(5, 'Civil Engineering', 'CE', 'civil-engineering', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int UNSIGNED NOT NULL,
  `semester_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `semester_number` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester_name`, `semester_code`, `semester_number`, `status`, `created_at`, `updated_at`) VALUES
(1, '1st Semester', 'SEM01', 1, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(2, '2nd Semester', 'SEM02', 2, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(3, '3rd Semester', 'SEM03', 3, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(4, '4th Semester', 'SEM04', 4, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(5, '5th Semester', 'SEM05', 5, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(6, '6th Semester', 'SEM06', 6, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(7, '7th Semester', 'SEM07', 7, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(8, '8th Semester', 'SEM08', 8, 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int UNSIGNED NOT NULL,
  `session_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `session_name`, `session_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Spring 2026', 'SPR-2026', 1, '2026-08-27 07:11:19', '2026-08-27 07:11:19'),
(2, 'Summer 2026', 'SUM-2026', 1, '2026-08-27 07:11:19', '2026-08-27 07:11:19'),
(3, 'Fall 2026', 'FALL-2026', 1, '2026-08-27 07:11:19', '2026-08-27 07:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int UNSIGNED NOT NULL,
  `student_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int UNSIGNED NOT NULL,
  `session_id` int UNSIGNED NOT NULL,
  `admission_date` date DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Passout, 4=Dropout',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `student_name`, `student_email`, `student_phone`, `student_gender`, `department_id`, `session_id`, `admission_date`, `date_of_birth`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CSE-21-001', 'Md Rakibul Islam', 'rakibul.islam@example.com', '01711111111', 'Male', 1, 1, '2021-01-15', '2000-05-10', 'Mirpur, Dhaka', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(2, 'CSE-21-002', 'Fahmida Akter', 'fahmida.akter@example.com', '01711111112', 'Female', 1, 1, '2021-01-15', '2000-07-22', 'Dhanmondi, Dhaka', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(3, 'EEE-22-001', 'Tanvir Ahmed', 'tanvir.ahmed@example.com', '01711111113', 'Male', 2, 2, '2022-01-20', '2001-03-18', 'Uttara, Dhaka', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(4, 'BBA-22-001', 'Sumaiya Rahman', 'sumaiya.rahman@example.com', '01711111114', 'Female', 3, 2, '2022-01-20', '2001-09-05', 'Banani, Dhaka', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(5, 'CSE-23-001', 'Arifin Hasan', 'arifin.hasan@example.com', '01711111115', 'Male', 1, 3, '2023-01-10', '2002-11-30', 'Mohammadpur, Dhaka', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(6, 'CE-23-001', 'Nusrat Jahan', 'nusrat.jahan@example.com', '01711111116', 'Female', 5, 3, '2023-01-10', '2002-02-14', 'Badda, Dhaka', 2, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(7, 'ENG-24-001', 'Shakil Ahmed', 'shakil.ahmed@example.com', '01711111117', 'Male', 4, 4, '2024-01-05', '2003-06-25', 'Gulshan, Dhaka', 1, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(8, 'CSE-20-001', 'Jannatul Ferdous', 'jannatul.ferdous@example.com', '01711111118', 'Female', 1, 1, '2020-01-12', '1999-12-08', 'Farmgate, Dhaka', 3, '2026-08-27 07:10:54', '2026-08-27 07:10:54'),
(9, 'CSE-26-001', 'Md Rakibul Islam', 'rakibul.islam@example.com', '01711111111', 'Male', 1, 1, '2026-01-15', '2000-05-10', 'Mirpur, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(10, 'CSE-26-002', 'Fahmida Akter', 'fahmida.akter@example.com', '01711111112', 'Female', 1, 1, '2026-01-15', '2000-07-22', 'Dhanmondi, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(11, 'EEE-26-001', 'Tanvir Ahmed', 'tanvir.ahmed@example.com', '01711111113', 'Male', 2, 1, '2026-01-15', '2001-03-18', 'Uttara, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(12, 'BBA-26-001', 'Sumaiya Rahman', 'sumaiya.rahman@example.com', '01711111114', 'Female', 3, 2, '2026-05-01', '2001-09-05', 'Banani, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(13, 'BBA-26-002', 'Arifin Hasan', 'arifin.hasan@example.com', '01711111115', 'Male', 3, 2, '2026-05-01', '2002-11-30', 'Mohammadpur, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(14, 'CE-26-001', 'Nusrat Jahan', 'nusrat.jahan@example.com', '01711111116', 'Female', 5, 2, '2026-05-01', '2002-02-14', 'Badda, Dhaka', 2, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(15, 'ENG-26-001', 'Shakil Ahmed', 'shakil.ahmed@example.com', '01711111117', 'Male', 4, 3, '2026-09-01', '2003-06-25', 'Gulshan, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(16, 'CSE-25-001', 'Jannatul Ferdous', 'jannatul.ferdous@example.com', '01711111118', 'Female', 1, 3, '2025-09-01', '1999-12-08', 'Farmgate, Dhaka', 3, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(17, 'EEE-25-001', 'Rezaul Karim', 'rezaul.karim@example.com', '01711111119', 'Male', 2, 3, '2025-09-01', '2000-08-14', 'Mohakhali, Dhaka', 4, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(18, 'CE-26-002', 'Tasnim Akter', 'tasnim.akter@example.com', '01711111120', 'Female', 5, 1, '2026-01-15', '2001-04-27', 'Rampura, Dhaka', 1, '2026-08-27 07:14:07', '2026-08-27 07:14:07'),
(19, 'CSE-26-003', 'Imran Hossain', 'imran.hossain@example.com', '01711111121', 'Male', 1, 2, '2026-05-01', '2001-01-19', 'Bashundhara, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(20, 'CSE-26-004', 'Nadia Islam', 'nadia.islam@example.com', '01711111122', 'Female', 1, 3, '2026-09-01', '2002-03-11', 'Khilgaon, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(21, 'EEE-26-002', 'Shahriar Kabir', 'shahriar.kabir@example.com', '01711111123', 'Male', 2, 2, '2026-05-01', '2001-06-30', 'Malibagh, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(22, 'EEE-26-003', 'Farzana Yasmin', 'farzana.yasmin@example.com', '01711111124', 'Female', 2, 3, '2026-09-01', '2002-08-09', 'Shantinagar, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(23, 'BBA-26-003', 'Mahmudul Hasan', 'mahmudul.hasan@example.com', '01711111125', 'Male', 3, 1, '2026-01-15', '2000-12-05', 'Tejgaon, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(24, 'BBA-26-004', 'Ruma Akter', 'ruma.akter@example.com', '01711111126', 'Female', 3, 3, '2026-09-01', '2001-10-17', 'Lalbagh, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(25, 'ENG-26-002', 'Sohanur Rahman', 'sohanur.rahman@example.com', '01711111127', 'Male', 4, 1, '2026-01-15', '2002-02-28', 'Jatrabari, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(26, 'ENG-25-001', 'Taslima Begum', 'taslima.begum@example.com', '01711111128', 'Female', 4, 2, '2025-05-01', '1999-11-03', 'Wari, Dhaka', 3, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(27, 'CE-26-003', 'Abdullah Al Noman', 'abdullah.noman@example.com', '01711111129', 'Male', 5, 3, '2026-09-01', '2001-07-22', 'Motijheel, Dhaka', 1, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(28, 'CE-25-001', 'Sharmin Sultana', 'sharmin.sultana@example.com', '01711111130', 'Female', 5, 2, '2025-05-01', '2000-04-16', 'Paltan, Dhaka', 4, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(29, 'CSE-24-001', 'Zubayer Ahmed', 'zubayer.ahmed@example.com', '01711111131', 'Male', 1, 1, '2024-01-15', '1999-09-25', 'Kamalapur, Dhaka', 3, '2026-08-27 07:15:13', '2026-08-27 07:15:13'),
(30, 'EEE-24-001', 'Kamrul Hasan', 'kamrul.hasan@example.com', '01711111132', 'Male', 2, 1, '2024-01-15', '1998-05-12', 'Azimpur, Dhaka', 4, '2026-08-27 07:15:13', '2026-08-27 07:15:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_code` (`department_code`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `semester_code` (`semester_code`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_code` (`session_code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `course_registration`
--
ALTER TABLE `course_registration`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
