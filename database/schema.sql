-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2026 at 03:30 AM
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
-- Database: `law_firm_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `assigned_user_id` int(10) UNSIGNED NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` enum('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `client_id`, `assigned_user_id`, `appointment_date`, `appointment_time`, `title`, `type`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 7, '2026-09-09', '10:30:00', 'مقابلة مع عميل', 'متابعة', 'cancelled', 'اول مقابلة', '2026-09-02 21:32:43', '2026-09-04 13:13:38'),
(2, 1, 3, '2026-09-10', '19:00:00', 'مقابلة مع العميل', 'استشارة', 'scheduled', 'تعديل اول موعد', '2026-09-02 21:35:48', '2026-09-02 22:42:02'),
(3, NULL, 7, '2026-09-09', '10:00:00', 'اجتماع', 'متابعة', 'completed', 'اجتماع مجلس الادارة', '2026-09-02 21:37:24', '2026-09-06 00:47:36'),
(4, 3, 1, '2026-09-08', '23:00:00', 'مقابلة مع العميل', 'مقابلة', 'scheduled', '', '2026-09-02 21:42:00', '2026-09-02 21:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(10) UNSIGNED NOT NULL,
  `case_number` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `assigned_lawyer_id` int(10) UNSIGNED NOT NULL,
  `case_type_id` int(10) UNSIGNED NOT NULL,
  `court_name` varchar(255) NOT NULL,
  `court_number` varchar(100) DEFAULT NULL,
  `status` enum('pending','active','on_hold','closed','cancelled') NOT NULL DEFAULT 'pending',
  `description` text DEFAULT NULL,
  `filing_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `case_number`, `title`, `client_id`, `assigned_lawyer_id`, `case_type_id`, `court_name`, `court_number`, `status`, `description`, `filing_date`, `created_at`, `updated_at`) VALUES
(3, '2026/001', 'دعوى مطالبة مالية', 1, 1, 1, 'محكمة القاهرة', '101', 'pending', 'دعوى مطالبة بمستحقات مالية.', '2026-08-01', '2026-08-30 00:10:09', '2026-09-05 20:26:52'),
(4, '2026/002', 'قضية جنائية', 2, 1, 2, 'محكمة جنوب القاهرة', '205', 'on_hold', 'قضية جنائية قيد المتابعة   .', '2026-08-05', '2026-08-30 00:10:09', '2026-09-05 20:44:43'),
(5, '2026/003', 'دعوى أحوال شخصية', 3, 3, 3, 'محكمة الأسرة', '12', 'active', 'دعوى متعلقة بالأحوال الشخصية.', '2026-08-10', '2026-08-30 00:10:09', '2026-08-30 00:10:09'),
(6, '2026/004', 'نزاع تجاري', 1, 3, 4, 'المحكمة الاقتصادية', '45', 'on_hold', 'نزاع تجاري بين طرفين.', '2026-08-12', '2026-08-30 00:10:09', '2026-08-30 00:10:09'),
(7, '2026/005', 'دعوى إدارية', 2, 2, 5, 'مجلس الدولة', '77', 'closed', 'دعوى إدارية تم الانتهاء منها.', '2026-08-15', '2026-08-30 00:10:09', '2026-08-30 00:10:09'),
(9, '2026/098', 'Test Case', 1, 2, 1, 'Cairo Court', '101', 'pending', 'Test case description', '2026-08-30', '2026-08-30 00:16:56', '2026-08-30 00:16:56'),
(10, '2026/446', 'دعوى مطالبة مالية', 1, 3, 1, 'محكمة القاهرة', '5', 'on_hold', 'اي وصف 2', '2026-02-06', '2026-09-01 19:16:53', '2026-09-02 00:57:06'),
(11, '2026/006', 'دعوى تعويض عن أضرار', 3, 2, 1, 'محكمة الجيزة', '118', 'pending', 'دعوى للمطالبة بتعويض عن أضرار مادية.', '2026-08-18', '2026-09-04 18:45:26', '2026-09-04 18:45:26'),
(12, '2026/007', 'نزاع حول عقد إيجار', 1, 3, 2, 'محكمة شمال القاهرة', '324', 'active', 'نزاع قانوني متعلق بعقد إيجار.', '2026-08-20', '2026-09-04 18:45:26', '2026-09-04 18:45:26'),
(13, '2026/008', 'دعوى نفقة', 2, 2, 3, 'محكمة الأسرة بالقاهرة', '56', 'active', 'دعوى للمطالبة بالنفقة.', '2026-08-22', '2026-09-04 18:45:26', '2026-09-04 18:45:26'),
(14, '2026/009', 'خلاف بشأن شراكة تجارية', 3, 3, 4, 'المحكمة الاقتصادية', '91', 'on_hold', 'نزاع بين شركاء حول حقوق والتزامات الشراكة.', '2026-08-25', '2026-09-04 18:45:26', '2026-09-04 18:45:26'),
(15, '2026/010', 'طعن على قرار إداري', 1, 2, 5, 'مجلس الدولة', '143', 'closed', 'طعن على قرار صادر من جهة إدارية.', '2026-08-28', '2026-09-04 18:45:26', '2026-09-04 18:45:26'),
(16, '2026/011', 'دعوى فسخ عقد', 2, 3, 1, 'محكمة مصر الجديدة', '209', 'pending', 'دعوى للمطالبة بفسخ عقد لعدم الالتزام بالشروط.', '2026-08-30', '2026-09-04 18:45:26', '2026-09-04 18:45:26'),
(17, '2026/012', 'دعوى مطالبة بمستحقات عمالية', 1, 2, 2, 'محكمة عمال القاهرة', '315', 'pending', 'دعوى للمطالبة بمستحقات مالية عمالية.', '2026-09-01', '2026-09-04 18:45:26', '2026-09-05 20:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `case_status_history`
--

CREATE TABLE `case_status_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `case_id` int(10) UNSIGNED NOT NULL,
  `old_status` enum('pending','active','on_hold','closed','cancelled') DEFAULT NULL,
  `new_status` enum('pending','active','on_hold','closed','cancelled') NOT NULL,
  `changed_by` int(10) UNSIGNED NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_status_history`
--

INSERT INTO `case_status_history` (`id`, `case_id`, `old_status`, `new_status`, `changed_by`, `changed_at`) VALUES
(1, 10, NULL, 'pending', 1, '2026-09-01 19:16:53'),
(2, 10, 'pending', 'active', 1, '2026-09-02 00:12:36'),
(3, 10, 'active', 'on_hold', 1, '2026-09-02 00:57:06'),
(4, 17, 'active', 'pending', 1, '2026-09-05 20:09:46'),
(5, 4, 'active', 'on_hold', 1, '2026-09-05 20:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `case_types`
--

CREATE TABLE `case_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `case_types`
--

INSERT INTO `case_types` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'مدني', 'active', '2026-08-29 20:42:41', '2026-08-30 00:08:57'),
(2, 'جنائي', 'active', '2026-08-29 20:43:40', '2026-08-30 00:09:01'),
(3, 'أسرة', 'active', '2026-08-29 20:44:12', '2026-08-30 00:09:04'),
(4, 'تجاري', 'active', '2026-08-29 20:44:24', '2026-08-30 00:09:07'),
(5, 'إداري', 'active', '2026-08-29 20:44:34', '2026-08-30 00:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `national_id`, `phone`, `email`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ahmed Mohamed Updated', '12345678901234', '01111111111', 'ahmed.updated@example.com', 'Giza, Egypt ,padrahsen', 'active', '2026-08-29 15:06:44', '2026-09-05 21:26:24'),
(2, 'mohamed assad', '12345678910123', '01234567869', 'client@lawfirm.com', 'cairo', 'active', '2026-08-29 17:05:35', '2026-08-30 00:02:27'),
(3, 'mohamed alaa', '12345678910', '01234567891', 'admin2@medical.com', NULL, 'active', '2026-08-29 16:42:06', '2026-08-29 20:23:24');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(10) UNSIGNED NOT NULL,
  `case_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_size` int(10) UNSIGNED NOT NULL,
  `uploaded_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `case_id`, `title`, `file_name`, `file_path`, `file_type`, `file_size`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 3, 'صورة', 'photo_2024-11-27_19-00-32.jpg', 'storage/documents/fdf95e93f2265db79e7ca7255b3b1b3d.jpg', 'image/jpeg', 70771, 1, '2026-09-03 17:15:07', '2026-09-03 23:21:13');

-- --------------------------------------------------------

--
-- Table structure for table `hearings`
--

CREATE TABLE `hearings` (
  `id` int(10) UNSIGNED NOT NULL,
  `case_id` int(10) UNSIGNED NOT NULL,
  `hearing_date` date NOT NULL,
  `hearing_time` time NOT NULL,
  `court_name` varchar(255) NOT NULL,
  `court_number` varchar(100) DEFAULT NULL,
  `hearing_type` varchar(100) NOT NULL,
  `status` enum('scheduled','completed','postponed','cancelled') NOT NULL DEFAULT 'scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hearings`
--

INSERT INTO `hearings` (`id`, `case_id`, `hearing_date`, `hearing_time`, `court_name`, `court_number`, `hearing_type`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-09-15', '10:30:00', 'محكمة القاهرة', '5', 'مرافعة', 'scheduled', 'أول جلسة للقضية', '2026-09-02 01:15:34', '2026-09-02 01:15:34'),
(3, 3, '2026-10-25', '09:00:00', 'محكمة شمال القاهرة', '102', 'مرافعة', 'scheduled', 'تعديل الجلسة الثانية', '2026-09-02 14:03:03', '2026-09-02 15:50:02'),
(4, 6, '2027-04-09', '10:00:00', 'المحكمة الاقتصادية', '45', 'مرافعة', 'scheduled', 'الجلسة الاولى', '2026-09-02 15:53:12', '2026-09-02 15:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','lawyer','staff') NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abdelrahman Karam', 'admin@lawfirm.test', '$2y$10$H2KxHABq9x0P13riVqsQ0.PTlQS5qoA673Uq7iMzu6gjnRrp7OQlS', 'admin', 'active', '2026-08-27 23:09:44', '2026-09-05 21:18:26'),
(2, 'Lawyer Abdelrahman Karam', 'Lawyer@lawfirm.test', '$2y$10$MmaGI8v6ctElzjz80aW1TuutLtQd4VMqXzseGnlL5BkADeRMuXYQu', 'lawyer', 'active', '2026-08-28 19:59:51', '2026-08-28 19:59:51'),
(3, 'Ahmed Lawyer', 'ahmed@lawfirm.test', '$2y$10$i5rsJgOImKQLZI0hWmRVPue4k9.KMonaVEJaevYG0Y/iAImD7cPNW', 'lawyer', 'active', '2026-08-29 10:10:08', '2026-08-29 10:10:08'),
(4, 'Lawyer Mohamed', 'abdokaram678@gmail.com', '$2y$10$a6anRwI26LkM1txIVy3aUONiqaKozAZwl6.f3LZ9.mKTyFTLde6GC', 'lawyer', 'active', '2026-08-29 10:15:38', '2026-09-05 12:46:39'),
(5, 'mohamed', 'mohamed@lawfirm.test', '$2y$10$M5RJphmvXDume3FnAkRevePTkanyIW4R89qKnzw7e39Pdd3odktJm', 'staff', 'active', '2026-08-29 11:39:26', '2026-08-29 11:39:26'),
(6, 'staff', 'staff@gmail.com', '$2y$10$PAO3NtIzCVRoiQ474nrY2.ZvfSP3v9iIWpW8Cgt3jmGLrDc0gJDcG', 'staff', 'inactive', '2026-08-29 12:17:44', '2026-08-29 13:19:08'),
(7, 'Abdelrahman Karam', 'admin@test.com', '$2y$10$tJ.XZEJDsM6hfAxzOJJ54uSPhAkPfrK0dRsCw7/aRSK7BUPRx.Ktu', 'lawyer', 'active', '2026-08-29 12:21:34', '2026-08-29 13:47:33'),
(8, 'staff', 'staff2@gmail.com', '$2y$10$22/rd3UBsF/WoSvtz6RNh.mHIYqPOR8S6HfMuMXfyxHeM4kb4JMVe', 'staff', 'inactive', '2026-08-29 14:38:02', '2026-08-29 14:38:02'),
(9, 'staff', 'staff5@gmail.com', '$2y$10$F0fEfYdzcjdZfqo6F6Mn3uuBcqTQA4u9HqWKQyCEP8TlklVtHomHC', 'staff', 'active', '2026-08-29 14:40:11', '2026-09-05 22:49:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_appointments_client` (`client_id`),
  ADD KEY `fk_appointments_assigned_user` (`assigned_user_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `case_number` (`case_number`),
  ADD KEY `fk_cases_client` (`client_id`),
  ADD KEY `fk_cases_lawyer` (`assigned_lawyer_id`),
  ADD KEY `fk_cases_type` (`case_type_id`);

--
-- Indexes for table `case_status_history`
--
ALTER TABLE `case_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_status_history_case` (`case_id`),
  ADD KEY `fk_status_history_user` (`changed_by`);

--
-- Indexes for table `case_types`
--
ALTER TABLE `case_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `national_id` (`national_id`),
  ADD UNIQUE KEY `clients_email_unique` (`email`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_documents_case` (`case_id`),
  ADD KEY `fk_documents_user` (`uploaded_by`);

--
-- Indexes for table `hearings`
--
ALTER TABLE `hearings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hearings_case` (`case_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `case_status_history`
--
ALTER TABLE `case_status_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `case_types`
--
ALTER TABLE `case_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hearings`
--
ALTER TABLE `hearings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointments_assigned_user` FOREIGN KEY (`assigned_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_appointments_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `fk_cases_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cases_lawyer` FOREIGN KEY (`assigned_lawyer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cases_type` FOREIGN KEY (`case_type_id`) REFERENCES `case_types` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `case_status_history`
--
ALTER TABLE `case_status_history`
  ADD CONSTRAINT `fk_status_history_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `fk_documents_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_documents_user` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `hearings`
--
ALTER TABLE `hearings`
  ADD CONSTRAINT `fk_hearings_case` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
