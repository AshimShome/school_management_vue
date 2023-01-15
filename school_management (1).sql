-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2023 at 06:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dark_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sidebar_bg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#232e3c',
  `navbar_bg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#fff',
  `sidebar_text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#232e3c',
  `navbar_text_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#232e3c',
  `layout` enum('full-width','boxed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full-width',
  `nav_position` enum('top','left','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `default_session_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `name`, `email`, `address`, `phone`, `favicon`, `logo`, `dark_logo`, `created_at`, `updated_at`, `sidebar_bg`, `navbar_bg`, `sidebar_text_color`, `navbar_text_color`, `layout`, `nav_position`, `default_session_id`) VALUES
(1, 'Schooling - School Management System', 'example@mail.com', 'Mohammadpur,  Dhaka-1207, Bangladesh', '1922296392', '/images/fav/favicon.png', '/images/logo/logo.png', '/images/logo/blue-logo.png', '2023-01-09 05:51:20', '2023-01-09 06:16:06', '#232e3c', '#fff', '#232e3c', '#232e3c', 'full-width', 'left', 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calendars`
--

CREATE TABLE `calendars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classses`
--

CREATE TABLE `classses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numeric` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classses`
--

INSERT INTO `classses` (`id`, `name`, `slug`, `numeric`, `created_at`, `updated_at`) VALUES
(1, 'One', 'one', 1, '2023-01-09 06:17:12', '2023-01-09 06:17:12'),
(2, 'Two', 'two', 2, '2023-01-10 06:10:27', '2023-01-10 06:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `class_rooms`
--

CREATE TABLE `class_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_no` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_rooms`
--

INSERT INTO `class_rooms` (`id`, `room_no`, `capacity`, `image`, `created_at`, `updated_at`) VALUES
(1, 101, 30, NULL, '2023-01-09 06:17:25', '2023-01-09 06:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `class_routines`
--

CREATE TABLE `class_routines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `class_room_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `weekday` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_section`
--

CREATE TABLE `class_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_section`
--

INSERT INTO `class_section` (`id`, `class_id`, `section_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'English', NULL, '2023-01-09 06:16:32', '2023-01-09 06:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `session_id`, `name`, `note`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mid-Term', 'Mid Exam', '2023-01-10', '2023-01-19', '2023-01-10 04:56:16', '2023-01-10 04:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `exam_marks`
--

CREATE TABLE `exam_marks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED DEFAULT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `roll_no` bigint(20) UNSIGNED NOT NULL,
  `mark` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_result_rules`
--

CREATE TABLE `exam_result_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gpa` double(8,2) NOT NULL DEFAULT 0.00,
  `min_mark` int(10) UNSIGNED NOT NULL,
  `max_mark` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_result_rules`
--

INSERT INTO `exam_result_rules` (`id`, `name`, `gpa`, `min_mark`, `max_mark`, `created_at`, `updated_at`) VALUES
(1, 'A+', 5.00, 80, 100, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(2, 'A', 4.00, 70, 79, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(3, 'A-', 3.50, 60, 69, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(4, 'B', 3.00, 50, 59, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(5, 'C', 2.00, 40, 49, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(6, 'D', 1.00, 33, 40, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(7, 'F', 0.00, 0, 32, '2023-01-09 05:51:34', '2023-01-09 05:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `exam_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_schedules`
--

INSERT INTO `exam_schedules` (`id`, `session_id`, `exam_id`, `room_id`, `class_id`, `subject_id`, `section_id`, `exam_date`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(6, 1, 1, 1, 1, 1, 1, '2023-01-19', '01:30:00', '02:30:00', '2023-01-10 23:03:56', '2023-01-10 23:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `exam_terms`
--

CREATE TABLE `exam_terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `due_date` date NOT NULL,
  `pay_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `type_id`, `session_id`, `class_id`, `section_id`, `student_id`, `parent_id`, `amount`, `due_date`, `pay_date`, `status`, `description`, `transaction_no`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 3220.00, '2023-01-17', '2023-01-10', 1, 'VVVVVVVVV', '63bd29700ad65', '2023-01-10 03:01:36', '2023-01-10 03:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `fee_types`
--

CREATE TABLE `fee_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fee_types`
--

INSERT INTO `fee_types` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Bulk', NULL, NULL, '2023-01-10 03:00:00', '2023-01-10 03:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `user_id`, `session_id`, `phone`, `gender`, `occupation`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '01829610248', 'male', NULL, '2023-01-09 06:21:34', '2023-01-09 06:21:34');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `messageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `messageable_id` bigint(20) UNSIGNED NOT NULL,
  `message_type` enum('email','sms') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_03_02_042234_create_permission_tables', 1),
(6, '2021_09_14_090137_create_admin_settings_table', 1),
(7, '2021_09_14_090138_alter_settings_table', 1),
(8, '2021_09_18_093719_create_sessions_table', 1),
(9, '2021_09_18_123926_create_departments_table', 1),
(10, '2021_09_19_054808_create_classses_table', 1),
(11, '2021_09_19_083559_create_sections_table', 1),
(12, '2021_09_19_090526_create_class_section', 1),
(13, '2021_09_20_052752_create_guardians_table', 1),
(14, '2021_09_20_052753_create_students_table', 1),
(15, '2021_09_20_083757_create_staff_table', 1),
(16, '2021_09_20_094944_create_class_rooms_table', 1),
(17, '2021_09_20_120312_create_subjects_table', 1),
(18, '2021_09_21_035835_create_exam_terms_table', 1),
(19, '2021_09_21_053518_create_exams_table', 1),
(20, '2021_09_21_091210_create_exam_schedules_table', 1),
(21, '2021_09_21_122705_create_syllabi_table', 1),
(22, '2021_09_22_062534_create_exam_marks_table', 1),
(23, '2021_09_23_040722_create_student_attendances_table', 1),
(24, '2021_09_23_063026_create_exam_result_rules_table', 1),
(25, '2021_09_25_035513_create_teacher_attendances_table', 1),
(26, '2021_09_25_065413_create_announcements_table', 1),
(27, '2021_09_26_124536_create_class_routines_table', 1),
(28, '2021_09_28_040213_create_messages_table', 1),
(29, '2021_09_28_054248_create_jobs_table', 1),
(30, '2021_09_29_083257_create_calendars_table', 1),
(31, '2021_12_28_044421_add_fields_to_admin_settings_table', 1),
(32, '2022_01_01_113022_create_notifications_table', 1),
(33, '2022_01_06_050934_create_student_homework_table', 1),
(34, '2022_01_06_084744_create_fee_types_table', 1),
(35, '2022_01_06_084744_create_fees_table', 1),
(36, '2022_01_06_094744_create_expense_types_table', 1),
(37, '2022_01_06_094745_create_expenses_table', 1),
(38, '2022_01_06_096100_create_transactions_table', 1),
(39, '2022_03_23_043404_create_timezones_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 2),
(5, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0d39f2cd-5403-49c5-8bea-e91e6a35f388', 'App\\Notifications\\MessageNotification', 'App\\Models\\User', 3, '{\"subject\":\"Notice\",\"sender\":{\"name\":\"mr account\",\"image\":\"http:\\/\\/127.0.0.1:8000\\/images\\/default.png\"},\"body\":\"NNNNNNNNNNNNN\"}', NULL, '2023-01-10 03:01:44', '2023-01-10 03:01:44'),
('3e366c30-9c87-4917-9e32-445faf14bff0', 'App\\Notifications\\FeePaidNotification', 'App\\Models\\User', 1, '{\"subject\":\"Fee Paid Notification\",\"sender\":{\"name\":\"al mahmud\",\"image\":\"http:\\/\\/127.0.0.1:8000\\/images\\/default.png\"},\"body\":\"al mahmud has paid the fee for 3220 of Bulk\"}', '2023-01-10 03:29:26', '2023-01-10 03:01:57', '2023-01-10 03:29:26'),
('4579a644-a457-414c-97af-2b3da2a837d8', 'App\\Notifications\\FeePaidNotification', 'App\\Models\\User', 5, '{\"subject\":\"Fee Paid Notification\",\"sender\":{\"name\":\"al mahmud\",\"image\":\"http:\\/\\/127.0.0.1:8000\\/images\\/default.png\"},\"body\":\"al mahmud has paid the fee for 3220 of Bulk\"}', NULL, '2023-01-10 03:02:01', '2023-01-10 03:02:01'),
('f5110bf6-e5b0-4069-a0b1-3be2f18864de', 'App\\Notifications\\MessageNotification', 'App\\Models\\User', 2, '{\"subject\":\"Notice\",\"sender\":{\"name\":\"mr account\",\"image\":\"http:\\/\\/127.0.0.1:8000\\/images\\/default.png\"},\"body\":\"NNNNNNNNNNNNN\"}', NULL, '2023-01-10 03:01:51', '2023-01-10 03:01:51');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'student-attendance-list', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(2, 'student-attendance-create', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(3, 'teacher-attendance-list', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(4, 'teacher-attendance-create', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(5, 'session-list', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(6, 'session-create', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(7, 'session-edit', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(8, 'session-delete', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(9, 'department-list', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(10, 'department-create', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(11, 'department-edit', 'api', '2023-01-09 05:51:07', '2023-01-09 05:51:07'),
(12, 'department-delete', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(13, 'routine-list', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(14, 'routine-create', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(15, 'routine-edit', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(16, 'routine-delete', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(17, 'class-room-list', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(18, 'class-room-create', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(19, 'class-room-edit', 'api', '2023-01-09 05:51:08', '2023-01-09 05:51:08'),
(20, 'class-room-delete', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(21, 'class-list', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(22, 'class-create', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(23, 'class-edit', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(24, 'class-delete', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(25, 'section-list', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(26, 'section-create', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(27, 'section-edit', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(28, 'section-delete', 'api', '2023-01-09 05:51:09', '2023-01-09 05:51:09'),
(29, 'subject-list', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(30, 'subject-create', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(31, 'subject-edit', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(32, 'subject-delete', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(33, 'syllabus-list', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(34, 'syllabus-create', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(35, 'syllabus-edit', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(36, 'syllabus-delete', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(37, 'homework-list', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(38, 'homework-create', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(39, 'homework-edit', 'api', '2023-01-09 05:51:10', '2023-01-09 05:51:10'),
(40, 'homework-delete', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(41, 'role-list', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(42, 'role-create', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(43, 'role-edit', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(44, 'role-delete', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(45, 'user-list', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(46, 'user-create', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(47, 'user-edit', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(48, 'user-delete', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(49, 'user-view', 'api', '2023-01-09 05:51:11', '2023-01-09 05:51:11'),
(50, 'student-list', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(51, 'student-create', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(52, 'student-edit', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(53, 'student-delete', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(54, 'student-view', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(55, 'parent-list', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(56, 'parent-create', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(57, 'parent-edit', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(58, 'parent-delete', 'api', '2023-01-09 05:51:12', '2023-01-09 05:51:12'),
(59, 'parent-view', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(60, 'teacher-list', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(61, 'teacher-create', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(62, 'teacher-edit', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(63, 'teacher-delete', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(64, 'teacher-view', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(65, 'accountant-list', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(66, 'accountant-create', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(67, 'accountant-edit', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(68, 'accountant-delete', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(69, 'accountant-view', 'api', '2023-01-09 05:51:13', '2023-01-09 05:51:13'),
(70, 'exam-list', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(71, 'exam-create', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(72, 'exam-edit', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(73, 'exam-delete', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(74, 'exam-schedule-list', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(75, 'exam-schedule-create', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(76, 'exam-schedule-edit', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(77, 'exam-schedule-delete', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(78, 'exam-mark-list', 'api', '2023-01-09 05:51:14', '2023-01-09 05:51:14'),
(79, 'exam-mark-distribution', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(80, 'exam-rule-list', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(81, 'exam-rule-create', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(82, 'exam-rule-edit', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(83, 'exam-rule-delete', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(84, 'exam-result-list', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(85, 'student-report', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(86, 'teacher-report', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(87, 'staff-report', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(88, 'class-report', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(89, 'class-routine-report', 'api', '2023-01-09 05:51:15', '2023-01-09 05:51:15'),
(90, 'student-attendance-report', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(91, 'teacher-attendance-report', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(92, 'exam-schedule-report', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(93, 'message-notification-send', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(94, 'calendar-list', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(95, 'calendar-create', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(96, 'calendar-edit', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(97, 'calendar-delete', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(98, 'promotion-list', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(99, 'promotion-student', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(100, 'fee-type-list', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(101, 'fee-type-create', 'api', '2023-01-09 05:51:16', '2023-01-09 05:51:16'),
(102, 'fee-type-edit', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(103, 'fee-type-delete', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(104, 'fee-list', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(105, 'fee-create', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(106, 'fee-edit', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(107, 'fee-delete', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(108, 'expense-type-list', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(109, 'expense-type-create', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(110, 'expense-type-edit', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(111, 'expense-type-delete', 'api', '2023-01-09 05:51:17', '2023-01-09 05:51:17'),
(112, 'expense-list', 'api', '2023-01-09 05:51:18', '2023-01-09 05:51:18'),
(113, 'expense-create', 'api', '2023-01-09 05:51:18', '2023-01-09 05:51:18'),
(114, 'expense-edit', 'api', '2023-01-09 05:51:18', '2023-01-09 05:51:18'),
(115, 'expense-delete', 'api', '2023-01-09 05:51:18', '2023-01-09 05:51:18'),
(116, 'setting-list', 'api', '2023-01-09 05:51:18', '2023-01-09 05:51:18'),
(117, 'setting-edit', 'api', '2023-01-09 05:51:18', '2023-01-09 05:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'api', '2023-01-09 05:51:06', '2023-01-09 05:51:06'),
(2, 'Teacher', 'api', '2023-01-09 05:51:06', '2023-01-09 05:51:06'),
(3, 'Accountant', 'api', '2023-01-09 05:51:06', '2023-01-09 05:51:06'),
(4, 'Guardian', 'api', '2023-01-09 05:51:06', '2023-01-09 05:51:06'),
(5, 'Student', 'api', '2023-01-09 05:51:06', '2023-01-09 05:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(13, 2),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(33, 2),
(34, 1),
(34, 2),
(35, 1),
(35, 2),
(36, 1),
(36, 2),
(37, 1),
(37, 2),
(38, 1),
(38, 2),
(39, 1),
(39, 2),
(40, 1),
(40, 2),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(70, 2),
(71, 1),
(71, 2),
(72, 1),
(72, 2),
(73, 1),
(73, 2),
(74, 1),
(74, 2),
(75, 1),
(75, 2),
(76, 1),
(76, 2),
(77, 1),
(77, 2),
(78, 1),
(78, 2),
(79, 1),
(79, 2),
(80, 1),
(80, 2),
(81, 1),
(81, 2),
(82, 1),
(82, 2),
(83, 1),
(83, 2),
(84, 1),
(84, 2),
(85, 1),
(85, 2),
(86, 1),
(86, 2),
(87, 1),
(87, 2),
(88, 1),
(88, 2),
(89, 1),
(89, 2),
(90, 1),
(90, 2),
(91, 1),
(92, 1),
(92, 2),
(93, 1),
(93, 2),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(98, 2),
(99, 1),
(100, 1),
(100, 3),
(101, 1),
(101, 3),
(102, 1),
(102, 3),
(103, 1),
(103, 3),
(104, 1),
(104, 3),
(105, 1),
(105, 3),
(106, 1),
(106, 3),
(107, 1),
(107, 3),
(108, 1),
(108, 3),
(109, 1),
(109, 3),
(110, 1),
(110, 3),
(111, 1),
(111, 3),
(112, 1),
(112, 3),
(113, 1),
(113, 3),
(114, 1),
(114, 3),
(115, 1),
(115, 3),
(116, 1),
(117, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `slug`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 'Day', 'day', 30, '2023-01-09 06:16:54', '2023-01-09 06:16:54');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `note`, `created_at`, `updated_at`) VALUES
(1, '2023', NULL, '2023-01-09 06:15:56', '2023-01-09 06:15:56');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `designation` enum('teacher','accountant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `joining_date` date NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` enum('muslim','hindu','buddha','christian') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_letter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `user_id`, `department_id`, `designation`, `joining_date`, `phone`, `gender`, `religion`, `bio`, `present_address`, `permanent_address`, `joining_letter`, `resume`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'teacher', '2023-01-18', '018296102477', 'male', NULL, NULL, NULL, NULL, 'joining_letters/FILE_63bc07674e15563bc0767.pdf', 'resumes/FILE_63bc07674face63bc0767.pdf', '2023-01-09 06:24:07', '2023-01-09 06:24:07'),
(2, 5, NULL, 'accountant', '2023-01-18', '012457567564', 'male', 'muslim', NULL, NULL, NULL, 'joining_letters/FILE_63bd25be6489e63bd25be.pdf', 'resumes/FILE_63bd25be8cb8a63bd25be.pdf', '2023-01-10 02:45:50', '2023-01-10 02:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `roll_no` int(10) UNSIGNED NOT NULL,
  `admission_date` date NOT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `blood_group` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `session_id`, `class_id`, `section_id`, `parent_id`, `roll_no`, `admission_date`, `present_address`, `permanent_address`, `gender`, `date_of_birth`, `blood_group`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, 1, 1, 12, '2023-01-11', NULL, NULL, 'male', NULL, NULL, '2023-01-09 06:22:21', '2023-01-09 06:22:21');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendances`
--

INSERT INTO `student_attendances` (`id`, `student_id`, `session_id`, `class_id`, `section_id`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2023-01-09', 1, '2023-01-09 06:25:50', '2023-01-09 06:25:50'),
(2, 1, 1, 1, 1, '2023-01-11', 0, '2023-01-10 23:12:05', '2023-01-10 23:12:05'),
(3, 1, 1, 1, 1, '2023-01-10', 1, '2023-01-10 23:12:18', '2023-01-10 23:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `student_homework`
--

CREATE TABLE `student_homework` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('theory','practical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'theory',
  `is_optional` tinyint(1) NOT NULL DEFAULT 0,
  `total_marks` int(11) NOT NULL DEFAULT 100,
  `pass_marks` int(11) NOT NULL DEFAULT 40,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `class_id`, `code`, `name`, `image`, `type`, `is_optional`, `total_marks`, `pass_marks`, `created_at`, `updated_at`) VALUES
(1, 1, 111, 'English', NULL, 'theory', 0, 100, 40, '2023-01-10 04:57:39', '2023-01-10 04:57:39'),
(2, 2, 222, 'Math', NULL, 'theory', 0, 100, 40, '2023-01-10 06:11:36', '2023-01-10 06:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `syllabi`
--

CREATE TABLE `syllabi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_attendances`
--

CREATE TABLE `teacher_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_attendances`
--

INSERT INTO `teacher_attendances` (`id`, `teacher_id`, `session_id`, `status`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2023-01-09', '2023-01-09 06:41:05', '2023-01-09 06:41:05'),
(2, 1, 1, 1, '2023-01-10', '2023-01-10 00:44:06', '2023-01-10 00:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `value`, `created_at`, `updated_at`) VALUES
(1, 'Africa/Abidjan', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(2, 'Africa/Accra', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(3, 'Africa/Addis_Ababa', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(4, 'Africa/Algiers', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(5, 'Africa/Asmara', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(6, 'Africa/Bamako', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(7, 'Africa/Bangui', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(8, 'Africa/Banjul', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(9, 'Africa/Bissau', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(10, 'Africa/Blantyre', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(11, 'Africa/Brazzaville', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(12, 'Africa/Bujumbura', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(13, 'Africa/Cairo', '2023-01-09 05:51:20', '2023-01-09 05:51:20'),
(14, 'Africa/Casablanca', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(15, 'Africa/Ceuta', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(16, 'Africa/Conakry', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(17, 'Africa/Dakar', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(18, 'Africa/Dar_es_Salaam', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(19, 'Africa/Djibouti', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(20, 'Africa/Douala', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(21, 'Africa/El_Aaiun', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(22, 'Africa/Freetown', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(23, 'Africa/Gaborone', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(24, 'Africa/Harare', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(25, 'Africa/Johannesburg', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(26, 'Africa/Juba', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(27, 'Africa/Kampala', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(28, 'Africa/Khartoum', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(29, 'Africa/Kigali', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(30, 'Africa/Kinshasa', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(31, 'Africa/Lagos', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(32, 'Africa/Libreville', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(33, 'Africa/Lome', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(34, 'Africa/Luanda', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(35, 'Africa/Lubumbashi', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(36, 'Africa/Lusaka', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(37, 'Africa/Malabo', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(38, 'Africa/Maputo', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(39, 'Africa/Maseru', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(40, 'Africa/Mbabane', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(41, 'Africa/Mogadishu', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(42, 'Africa/Monrovia', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(43, 'Africa/Nairobi', '2023-01-09 05:51:21', '2023-01-09 05:51:21'),
(44, 'Africa/Ndjamena', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(45, 'Africa/Niamey', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(46, 'Africa/Nouakchott', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(47, 'Africa/Ouagadougou', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(48, 'Africa/Porto-Novo', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(49, 'Africa/Sao_Tome', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(50, 'Africa/Tripoli', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(51, 'Africa/Tunis', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(52, 'Africa/Windhoek', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(53, 'America/Adak', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(54, 'America/Anchorage', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(55, 'America/Anguilla', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(56, 'America/Antigua', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(57, 'America/Araguaina', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(58, 'America/Argentina/Buenos_Aires', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(59, 'America/Argentina/Catamarca', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(60, 'America/Argentina/Cordoba', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(61, 'America/Argentina/Jujuy', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(62, 'America/Argentina/La_Rioja', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(63, 'America/Argentina/Mendoza', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(64, 'America/Argentina/Rio_Gallegos', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(65, 'America/Argentina/Salta', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(66, 'America/Argentina/San_Juan', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(67, 'America/Argentina/San_Luis', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(68, 'America/Argentina/Tucuman', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(69, 'America/Argentina/Ushuaia', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(70, 'America/Aruba', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(71, 'America/Asuncion', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(72, 'America/Atikokan', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(73, 'America/Bahia', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(74, 'America/Bahia_Banderas', '2023-01-09 05:51:22', '2023-01-09 05:51:22'),
(75, 'America/Barbados', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(76, 'America/Belem', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(77, 'America/Belize', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(78, 'America/Blanc-Sablon', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(79, 'America/Boa_Vista', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(80, 'America/Bogota', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(81, 'America/Boise', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(82, 'America/Cambridge_Bay', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(83, 'America/Campo_Grande', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(84, 'America/Cancun', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(85, 'America/Caracas', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(86, 'America/Cayenne', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(87, 'America/Cayman', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(88, 'America/Chicago', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(89, 'America/Chihuahua', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(90, 'America/Costa_Rica', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(91, 'America/Creston', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(92, 'America/Cuiaba', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(93, 'America/Curacao', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(94, 'America/Danmarkshavn', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(95, 'America/Dawson', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(96, 'America/Dawson_Creek', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(97, 'America/Denver', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(98, 'America/Detroit', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(99, 'America/Dominica', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(100, 'America/Edmonton', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(101, 'America/Eirunepe', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(102, 'America/El_Salvador', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(103, 'America/Fort_Nelson', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(104, 'America/Fortaleza', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(105, 'America/Glace_Bay', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(106, 'America/Goose_Bay', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(107, 'America/Grand_Turk', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(108, 'America/Grenada', '2023-01-09 05:51:23', '2023-01-09 05:51:23'),
(109, 'America/Guadeloupe', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(110, 'America/Guatemala', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(111, 'America/Guayaquil', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(112, 'America/Guyana', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(113, 'America/Halifax', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(114, 'America/Havana', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(115, 'America/Hermosillo', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(116, 'America/Indiana/Indianapolis', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(117, 'America/Indiana/Knox', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(118, 'America/Indiana/Marengo', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(119, 'America/Indiana/Petersburg', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(120, 'America/Indiana/Tell_City', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(121, 'America/Indiana/Vevay', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(122, 'America/Indiana/Vincennes', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(123, 'America/Indiana/Winamac', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(124, 'America/Inuvik', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(125, 'America/Iqaluit', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(126, 'America/Jamaica', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(127, 'America/Juneau', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(128, 'America/Kentucky/Louisville', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(129, 'America/Kentucky/Monticello', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(130, 'America/Kralendijk', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(131, 'America/La_Paz', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(132, 'America/Lima', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(133, 'America/Los_Angeles', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(134, 'America/Lower_Princes', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(135, 'America/Maceio', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(136, 'America/Managua', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(137, 'America/Manaus', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(138, 'America/Marigot', '2023-01-09 05:51:24', '2023-01-09 05:51:24'),
(139, 'America/Martinique', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(140, 'America/Matamoros', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(141, 'America/Mazatlan', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(142, 'America/Menominee', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(143, 'America/Merida', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(144, 'America/Metlakatla', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(145, 'America/Mexico_City', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(146, 'America/Miquelon', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(147, 'America/Moncton', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(148, 'America/Monterrey', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(149, 'America/Montevideo', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(150, 'America/Montserrat', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(151, 'America/Nassau', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(152, 'America/New_York', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(153, 'America/Nipigon', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(154, 'America/Nome', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(155, 'America/Noronha', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(156, 'America/North_Dakota/Beulah', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(157, 'America/North_Dakota/Center', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(158, 'America/North_Dakota/New_Salem', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(159, 'America/Nuuk', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(160, 'America/Ojinaga', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(161, 'America/Panama', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(162, 'America/Pangnirtung', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(163, 'America/Paramaribo', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(164, 'America/Phoenix', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(165, 'America/Port-au-Prince', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(166, 'America/Port_of_Spain', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(167, 'America/Porto_Velho', '2023-01-09 05:51:25', '2023-01-09 05:51:25'),
(168, 'America/Puerto_Rico', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(169, 'America/Punta_Arenas', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(170, 'America/Rainy_River', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(171, 'America/Rankin_Inlet', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(172, 'America/Recife', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(173, 'America/Regina', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(174, 'America/Resolute', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(175, 'America/Rio_Branco', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(176, 'America/Santarem', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(177, 'America/Santiago', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(178, 'America/Santo_Domingo', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(179, 'America/Sao_Paulo', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(180, 'America/Scoresbysund', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(181, 'America/Sitka', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(182, 'America/St_Barthelemy', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(183, 'America/St_Johns', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(184, 'America/St_Kitts', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(185, 'America/St_Lucia', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(186, 'America/St_Thomas', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(187, 'America/St_Vincent', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(188, 'America/Swift_Current', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(189, 'America/Tegucigalpa', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(190, 'America/Thule', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(191, 'America/Thunder_Bay', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(192, 'America/Tijuana', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(193, 'America/Toronto', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(194, 'America/Tortola', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(195, 'America/Vancouver', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(196, 'America/Whitehorse', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(197, 'America/Winnipeg', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(198, 'America/Yakutat', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(199, 'America/Yellowknife', '2023-01-09 05:51:26', '2023-01-09 05:51:26'),
(200, 'Antarctica/Casey', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(201, 'Antarctica/Davis', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(202, 'Antarctica/DumontDUrville', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(203, 'Antarctica/Macquarie', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(204, 'Antarctica/Mawson', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(205, 'Antarctica/McMurdo', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(206, 'Antarctica/Palmer', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(207, 'Antarctica/Rothera', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(208, 'Antarctica/Syowa', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(209, 'Antarctica/Troll', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(210, 'Antarctica/Vostok', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(211, 'Arctic/Longyearbyen', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(212, 'Asia/Aden', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(213, 'Asia/Almaty', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(214, 'Asia/Amman', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(215, 'Asia/Anadyr', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(216, 'Asia/Aqtau', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(217, 'Asia/Aqtobe', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(218, 'Asia/Ashgabat', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(219, 'Asia/Atyrau', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(220, 'Asia/Baghdad', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(221, 'Asia/Bahrain', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(222, 'Asia/Baku', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(223, 'Asia/Bangkok', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(224, 'Asia/Barnaul', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(225, 'Asia/Beirut', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(226, 'Asia/Bishkek', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(227, 'Asia/Brunei', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(228, 'Asia/Chita', '2023-01-09 05:51:27', '2023-01-09 05:51:27'),
(229, 'Asia/Choibalsan', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(230, 'Asia/Colombo', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(231, 'Asia/Damascus', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(232, 'Asia/Dhaka', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(233, 'Asia/Dili', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(234, 'Asia/Dubai', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(235, 'Asia/Dushanbe', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(236, 'Asia/Famagusta', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(237, 'Asia/Gaza', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(238, 'Asia/Hebron', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(239, 'Asia/Ho_Chi_Minh', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(240, 'Asia/Hong_Kong', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(241, 'Asia/Hovd', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(242, 'Asia/Irkutsk', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(243, 'Asia/Jakarta', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(244, 'Asia/Jayapura', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(245, 'Asia/Jerusalem', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(246, 'Asia/Kabul', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(247, 'Asia/Kamchatka', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(248, 'Asia/Karachi', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(249, 'Asia/Kathmandu', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(250, 'Asia/Khandyga', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(251, 'Asia/Kolkata', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(252, 'Asia/Krasnoyarsk', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(253, 'Asia/Kuala_Lumpur', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(254, 'Asia/Kuching', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(255, 'Asia/Kuwait', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(256, 'Asia/Macau', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(257, 'Asia/Magadan', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(258, 'Asia/Makassar', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(259, 'Asia/Manila', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(260, 'Asia/Muscat', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(261, 'Asia/Nicosia', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(262, 'Asia/Novokuznetsk', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(263, 'Asia/Novosibirsk', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(264, 'Asia/Omsk', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(265, 'Asia/Oral', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(266, 'Asia/Phnom_Penh', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(267, 'Asia/Pontianak', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(268, 'Asia/Pyongyang', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(269, 'Asia/Qatar', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(270, 'Asia/Qostanay', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(271, 'Asia/Qyzylorda', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(272, 'Asia/Riyadh', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(273, 'Asia/Sakhalin', '2023-01-09 05:51:28', '2023-01-09 05:51:28'),
(274, 'Asia/Samarkand', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(275, 'Asia/Seoul', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(276, 'Asia/Shanghai', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(277, 'Asia/Singapore', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(278, 'Asia/Srednekolymsk', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(279, 'Asia/Taipei', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(280, 'Asia/Tashkent', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(281, 'Asia/Tbilisi', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(282, 'Asia/Tehran', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(283, 'Asia/Thimphu', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(284, 'Asia/Tokyo', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(285, 'Asia/Tomsk', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(286, 'Asia/Ulaanbaatar', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(287, 'Asia/Urumqi', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(288, 'Asia/Ust-Nera', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(289, 'Asia/Vientiane', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(290, 'Asia/Vladivostok', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(291, 'Asia/Yakutsk', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(292, 'Asia/Yangon', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(293, 'Asia/Yekaterinburg', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(294, 'Asia/Yerevan', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(295, 'Atlantic/Azores', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(296, 'Atlantic/Bermuda', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(297, 'Atlantic/Canary', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(298, 'Atlantic/Cape_Verde', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(299, 'Atlantic/Faroe', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(300, 'Atlantic/Madeira', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(301, 'Atlantic/Reykjavik', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(302, 'Atlantic/South_Georgia', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(303, 'Atlantic/St_Helena', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(304, 'Atlantic/Stanley', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(305, 'Australia/Adelaide', '2023-01-09 05:51:29', '2023-01-09 05:51:29'),
(306, 'Australia/Brisbane', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(307, 'Australia/Broken_Hill', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(308, 'Australia/Darwin', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(309, 'Australia/Eucla', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(310, 'Australia/Hobart', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(311, 'Australia/Lindeman', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(312, 'Australia/Lord_Howe', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(313, 'Australia/Melbourne', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(314, 'Australia/Perth', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(315, 'Australia/Sydney', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(316, 'Europe/Amsterdam', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(317, 'Europe/Andorra', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(318, 'Europe/Astrakhan', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(319, 'Europe/Athens', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(320, 'Europe/Belgrade', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(321, 'Europe/Berlin', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(322, 'Europe/Bratislava', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(323, 'Europe/Brussels', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(324, 'Europe/Bucharest', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(325, 'Europe/Budapest', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(326, 'Europe/Busingen', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(327, 'Europe/Chisinau', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(328, 'Europe/Copenhagen', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(329, 'Europe/Dublin', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(330, 'Europe/Gibraltar', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(331, 'Europe/Guernsey', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(332, 'Europe/Helsinki', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(333, 'Europe/Isle_of_Man', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(334, 'Europe/Istanbul', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(335, 'Europe/Jersey', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(336, 'Europe/Kaliningrad', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(337, 'Europe/Kirov', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(338, 'Europe/Kyiv', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(339, 'Europe/Lisbon', '2023-01-09 05:51:30', '2023-01-09 05:51:30'),
(340, 'Europe/Ljubljana', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(341, 'Europe/London', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(342, 'Europe/Luxembourg', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(343, 'Europe/Madrid', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(344, 'Europe/Malta', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(345, 'Europe/Mariehamn', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(346, 'Europe/Minsk', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(347, 'Europe/Monaco', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(348, 'Europe/Moscow', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(349, 'Europe/Oslo', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(350, 'Europe/Paris', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(351, 'Europe/Podgorica', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(352, 'Europe/Prague', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(353, 'Europe/Riga', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(354, 'Europe/Rome', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(355, 'Europe/Samara', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(356, 'Europe/San_Marino', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(357, 'Europe/Sarajevo', '2023-01-09 05:51:31', '2023-01-09 05:51:31'),
(358, 'Europe/Saratov', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(359, 'Europe/Simferopol', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(360, 'Europe/Skopje', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(361, 'Europe/Sofia', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(362, 'Europe/Stockholm', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(363, 'Europe/Tallinn', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(364, 'Europe/Tirane', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(365, 'Europe/Ulyanovsk', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(366, 'Europe/Uzhgorod', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(367, 'Europe/Vaduz', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(368, 'Europe/Vatican', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(369, 'Europe/Vienna', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(370, 'Europe/Vilnius', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(371, 'Europe/Volgograd', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(372, 'Europe/Warsaw', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(373, 'Europe/Zagreb', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(374, 'Europe/Zaporozhye', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(375, 'Europe/Zurich', '2023-01-09 05:51:32', '2023-01-09 05:51:32'),
(376, 'Indian/Antananarivo', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(377, 'Indian/Chagos', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(378, 'Indian/Christmas', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(379, 'Indian/Cocos', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(380, 'Indian/Comoro', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(381, 'Indian/Kerguelen', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(382, 'Indian/Mahe', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(383, 'Indian/Maldives', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(384, 'Indian/Mauritius', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(385, 'Indian/Mayotte', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(386, 'Indian/Reunion', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(387, 'Pacific/Apia', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(388, 'Pacific/Auckland', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(389, 'Pacific/Bougainville', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(390, 'Pacific/Chatham', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(391, 'Pacific/Chuuk', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(392, 'Pacific/Easter', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(393, 'Pacific/Efate', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(394, 'Pacific/Fakaofo', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(395, 'Pacific/Fiji', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(396, 'Pacific/Funafuti', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(397, 'Pacific/Galapagos', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(398, 'Pacific/Gambier', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(399, 'Pacific/Guadalcanal', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(400, 'Pacific/Guam', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(401, 'Pacific/Honolulu', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(402, 'Pacific/Kanton', '2023-01-09 05:51:33', '2023-01-09 05:51:33'),
(403, 'Pacific/Kiritimati', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(404, 'Pacific/Kosrae', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(405, 'Pacific/Kwajalein', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(406, 'Pacific/Majuro', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(407, 'Pacific/Marquesas', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(408, 'Pacific/Midway', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(409, 'Pacific/Nauru', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(410, 'Pacific/Niue', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(411, 'Pacific/Norfolk', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(412, 'Pacific/Noumea', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(413, 'Pacific/Pago_Pago', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(414, 'Pacific/Palau', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(415, 'Pacific/Pitcairn', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(416, 'Pacific/Pohnpei', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(417, 'Pacific/Port_Moresby', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(418, 'Pacific/Rarotonga', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(419, 'Pacific/Saipan', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(420, 'Pacific/Tahiti', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(421, 'Pacific/Tarawa', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(422, 'Pacific/Tongatapu', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(423, 'Pacific/Wake', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(424, 'Pacific/Wallis', '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(425, 'UTC', '2023-01-09 05:51:34', '2023-01-09 05:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` bigint(20) UNSIGNED DEFAULT NULL,
  `student_id` bigint(20) UNSIGNED DEFAULT NULL,
  `income_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expense_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('income','expense') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_no`, `session_id`, `student_id`, `income_type`, `expense_type`, `payment_type`, `amount`, `type`, `created_at`, `updated_at`) VALUES
(1, '63bd29700ad65', 1, 1, 'Bulk', NULL, 'Cash on', '3220', 'income', '2023-01-10 03:02:01', '2023-01-10 03:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','staff','guardian','student') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@mail.com', '2023-01-09 05:51:34', '$2y$10$4T7KzMCZOuwBo2RktMxEfO3InqQ7vvdcFRmn1qkMhCyWI0IU1I8Hu', NULL, 'admin', NULL, '2023-01-09 05:51:34', '2023-01-09 05:51:34'),
(2, 'abdul malek', 'abdul@mail.com', NULL, '$2y$10$XI/slKY4iGcDSH86Kz6hiOibTpgnn5/Kjkm/VVWmkz4F9qBFsPmGu', NULL, 'guardian', NULL, '2023-01-09 06:21:34', '2023-01-09 06:21:34'),
(3, 'al mahmud', 'al@gmail.com', NULL, '$2y$10$THpJhokbkV3J6pc5dMIwc.luZjU35ryb/1FqsddtqzD54r7PBVzoG', NULL, 'student', NULL, '2023-01-09 06:22:20', '2023-01-09 06:22:20'),
(4, 'atiik sir', 'atik@gmail.com', NULL, '$2y$10$Swyg.Ziog5i4VHy0PZKcIu6re0GVvVVxNHjqzHwwnT6KB4ufxyjuO', NULL, 'staff', NULL, '2023-01-09 06:24:06', '2023-01-09 06:24:06'),
(5, 'mr account', 'accountant@gmail.com', NULL, '$2y$10$ppBXc9wS1Wm4rxu5vgP8NuEqosr9Mmu.rrUi7ye7cE3n710tQyVfm', NULL, 'staff', NULL, '2023-01-10 02:45:50', '2023-01-10 02:45:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_settings_default_session_id_foreign` (`default_session_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcements_title_unique` (`title`),
  ADD UNIQUE KEY `announcements_slug_unique` (`slug`);

--
-- Indexes for table `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calendars_session_id_foreign` (`session_id`);

--
-- Indexes for table `classses`
--
ALTER TABLE `classses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_rooms`
--
ALTER TABLE `class_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_routines`
--
ALTER TABLE `class_routines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_routines_session_id_foreign` (`session_id`),
  ADD KEY `class_routines_class_id_foreign` (`class_id`),
  ADD KEY `class_routines_section_id_foreign` (`section_id`),
  ADD KEY `class_routines_class_room_id_foreign` (`class_room_id`),
  ADD KEY `class_routines_teacher_id_foreign` (`teacher_id`),
  ADD KEY `class_routines_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `class_section`
--
ALTER TABLE `class_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_section_class_id_foreign` (`class_id`),
  ADD KEY `class_section_section_id_foreign` (`section_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_session_id_foreign` (`session_id`);

--
-- Indexes for table `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_marks_session_id_foreign` (`session_id`),
  ADD KEY `exam_marks_exam_id_foreign` (`exam_id`),
  ADD KEY `exam_marks_class_id_foreign` (`class_id`),
  ADD KEY `exam_marks_section_id_foreign` (`section_id`),
  ADD KEY `exam_marks_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `exam_result_rules`
--
ALTER TABLE `exam_result_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_schedules_session_id_foreign` (`session_id`),
  ADD KEY `exam_schedules_exam_id_foreign` (`exam_id`),
  ADD KEY `exam_schedules_room_id_foreign` (`room_id`),
  ADD KEY `exam_schedules_class_id_foreign` (`class_id`),
  ADD KEY `exam_schedules_subject_id_foreign` (`subject_id`),
  ADD KEY `exam_schedules_section_id_foreign` (`section_id`);

--
-- Indexes for table `exam_terms`
--
ALTER TABLE `exam_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_type_id_foreign` (`type_id`),
  ADD KEY `expenses_session_id_foreign` (`session_id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fees_type_id_foreign` (`type_id`),
  ADD KEY `fees_session_id_foreign` (`session_id`),
  ADD KEY `fees_class_id_foreign` (`class_id`),
  ADD KEY `fees_section_id_foreign` (`section_id`),
  ADD KEY `fees_student_id_foreign` (`student_id`),
  ADD KEY `fees_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `fee_types`
--
ALTER TABLE `fee_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guardians_user_id_foreign` (`user_id`),
  ADD KEY `guardians_session_id_foreign` (`session_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_messageable_type_messageable_id_index` (`messageable_type`,`messageable_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_user_id_foreign` (`user_id`),
  ADD KEY `staff_department_id_foreign` (`department_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_session_id_foreign` (`session_id`),
  ADD KEY `students_class_id_foreign` (`class_id`),
  ADD KEY `students_section_id_foreign` (`section_id`),
  ADD KEY `students_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_attendances_student_id_foreign` (`student_id`),
  ADD KEY `student_attendances_session_id_foreign` (`session_id`),
  ADD KEY `student_attendances_class_id_foreign` (`class_id`),
  ADD KEY `student_attendances_section_id_foreign` (`section_id`);

--
-- Indexes for table `student_homework`
--
ALTER TABLE `student_homework`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_homework_teacher_id_foreign` (`teacher_id`),
  ADD KEY `student_homework_session_id_foreign` (`session_id`),
  ADD KEY `student_homework_class_id_foreign` (`class_id`),
  ADD KEY `student_homework_section_id_foreign` (`section_id`),
  ADD KEY `student_homework_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_class_id_foreign` (`class_id`);

--
-- Indexes for table `syllabi`
--
ALTER TABLE `syllabi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `syllabi_session_id_foreign` (`session_id`),
  ADD KEY `syllabi_exam_id_foreign` (`exam_id`),
  ADD KEY `syllabi_class_id_foreign` (`class_id`),
  ADD KEY `syllabi_subject_id_foreign` (`subject_id`);

--
-- Indexes for table `teacher_attendances`
--
ALTER TABLE `teacher_attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_attendances_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_attendances_session_id_foreign` (`session_id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_session_id_foreign` (`session_id`),
  ADD KEY `transactions_student_id_foreign` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classses`
--
ALTER TABLE `classses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `class_rooms`
--
ALTER TABLE `class_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `class_routines`
--
ALTER TABLE `class_routines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_section`
--
ALTER TABLE `class_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `exam_marks`
--
ALTER TABLE `exam_marks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_result_rules`
--
ALTER TABLE `exam_result_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `exam_terms`
--
ALTER TABLE `exam_terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `fee_types`
--
ALTER TABLE `fee_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_homework`
--
ALTER TABLE `student_homework`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `syllabi`
--
ALTER TABLE `syllabi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_attendances`
--
ALTER TABLE `teacher_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD CONSTRAINT `admin_settings_default_session_id_foreign` FOREIGN KEY (`default_session_id`) REFERENCES `sessions` (`id`);

--
-- Constraints for table `calendars`
--
ALTER TABLE `calendars`
  ADD CONSTRAINT `calendars_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_routines`
--
ALTER TABLE `class_routines`
  ADD CONSTRAINT `class_routines_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`),
  ADD CONSTRAINT `class_routines_class_room_id_foreign` FOREIGN KEY (`class_room_id`) REFERENCES `class_rooms` (`id`),
  ADD CONSTRAINT `class_routines_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `class_routines_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`),
  ADD CONSTRAINT `class_routines_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `class_routines_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `staff` (`id`);

--
-- Constraints for table `class_section`
--
ALTER TABLE `class_section`
  ADD CONSTRAINT `class_section_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_section_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`);

--
-- Constraints for table `exam_marks`
--
ALTER TABLE `exam_marks`
  ADD CONSTRAINT `exam_marks_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`),
  ADD CONSTRAINT `exam_marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `exam_marks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `exam_marks_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`),
  ADD CONSTRAINT `exam_marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD CONSTRAINT `exam_schedules_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`),
  ADD CONSTRAINT `exam_schedules_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`),
  ADD CONSTRAINT `exam_schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `class_rooms` (`id`),
  ADD CONSTRAINT `exam_schedules_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`),
  ADD CONSTRAINT `exam_schedules_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`),
  ADD CONSTRAINT `exam_schedules_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `expense_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fees`
--
ALTER TABLE `fees`
  ADD CONSTRAINT `fees_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `guardians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fees_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `fee_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guardians`
--
ALTER TABLE `guardians`
  ADD CONSTRAINT `guardians_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guardians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `staff_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `guardians` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD CONSTRAINT `student_attendances_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendances_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_homework`
--
ALTER TABLE `student_homework`
  ADD CONSTRAINT `student_homework_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_homework_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_homework_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_homework_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_homework_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `syllabi`
--
ALTER TABLE `syllabi`
  ADD CONSTRAINT `syllabi_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `syllabi_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `syllabi_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `syllabi_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_attendances`
--
ALTER TABLE `teacher_attendances`
  ADD CONSTRAINT `teacher_attendances_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_attendances_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
