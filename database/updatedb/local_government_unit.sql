-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 02:22 PM
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
-- Database: `local_government_unit`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay_census`
--

CREATE TABLE `barangay_census` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `population` int(11) NOT NULL,
  `households` int(11) NOT NULL,
  `male` int(11) NOT NULL,
  `female` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_census`
--

INSERT INTO `barangay_census` (`id`, `year`, `population`, `households`, `male`, `female`, `created_at`, `updated_at`) VALUES
(3, 2022, 1124, 344, 435, 345, '2025-03-17 04:47:49', '2025-03-17 04:47:49'),
(4, 2023, 1260, 500, 200, 560, '2025-03-17 04:48:19', '2025-03-17 04:48:19'),
(5, 2024, 1476, 230, 679, 567, '2025-03-17 04:48:31', '2025-03-17 04:48:31'),
(7, 2025, 70, 39, 12, 19, '2025-03-18 08:08:50', '2025-03-18 08:13:48');

-- --------------------------------------------------------

--
-- Table structure for table `landmarks`
--

CREATE TABLE `landmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `building_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `landmarks`
--

INSERT INTO `landmarks` (`id`, `name`, `building_type`, `description`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'San Agustin Barangay Hall', 'Government', 'Main barangay hall', '14.6463', '121.0432', '2025-03-18 23:33:17', '2025-03-18 23:33:17'),
(2, 'San Agustin Elementary School', 'School', 'Public elementary school', '14.6457', '121.0451', '2025-03-18 23:33:17', '2025-03-18 23:33:17'),
(3, 'San Agustin Covered Court', 'Sports Facility', 'Covered basketball court', '14.6461', '121.0435', '2025-03-18 23:33:17', '2025-03-18 23:33:17'),
(4, 'Barangay Health Center (San Agustin)', 'Health Center', 'Local health center', '14.6462', '121.0433', '2025-03-18 23:33:17', '2025-03-18 23:33:17'),
(5, 'Public Market (Near San Agustin)', 'Market', 'Public market near barangay', '14.6459', '121.0438', '2025-03-18 23:33:17', '2025-03-18 23:33:17'),
(6, 'BCP', 'Market', 'No description available', '13473731.48', '1657718.51', '2025-03-18 23:33:17', '2025-03-19 09:34:20'),
(7, 'Amaia Series Village', 'Residential', 'Housing subdivision', '13473893.34', '1659107.29', '2025-03-18 23:33:17', '2025-03-18 23:33:17'),
(8, 'Novaliches Highschool', 'School', 'High school in the area', '13473292.65', '1657743.05', '2025-03-18 23:33:17', '2025-03-18 23:33:17');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `module`, `ip_address`, `details`, `created_at`, `updated_at`) VALUES
(1, 1, 'Added zoning permit for Hernan Canciller', 'Zoning Application', NULL, NULL, '2025-03-18 08:27:32', '2025-03-18 16:27:32'),
(2, 1, 'Approved zoning permit for Hernan Canciller', 'Zoning Application', NULL, NULL, '2025-03-18 08:27:39', '2025-03-18 16:27:39'),
(3, 1, 'Approved zoning permit for Hernan Canciller', 'Zoning Application', NULL, NULL, '2025-03-18 08:27:48', '2025-03-18 16:27:48'),
(4, 1, 'Approved zoning permit for Hernan Canciller', 'Zoning Application', NULL, NULL, '2025-03-18 08:28:24', '2025-03-18 16:28:24'),
(5, 1, 'Added zoning permit for Nisi corrupti sed q Fugiat nostrum elit', 'Zoning Application', NULL, NULL, '2025-03-18 08:32:54', '2025-03-18 16:32:54'),
(6, 1, 'Approved zoning permit for Nisi corrupti sed q Fugiat nostrum elit', 'Zoning Application', NULL, NULL, '2025-03-18 08:32:58', '2025-03-18 16:32:58'),
(7, 1, 'Approved zoning permit for Nisi corrupti sed q Fugiat nostrum elit', 'Zoning Application', NULL, NULL, '2025-03-18 08:33:15', '2025-03-18 16:33:15'),
(8, 1, 'Added zoning permit for Ab cum perspiciatis Dicta pariatur Aliq', 'Zoning Application', NULL, NULL, '2025-03-18 08:34:06', '2025-03-18 16:34:06'),
(9, 1, 'Approved zoning permit for Ab cum perspiciatis Dicta pariatur Aliq', 'Zoning Application', NULL, NULL, '2025-03-18 08:34:10', '2025-03-18 16:34:10'),
(10, 1, 'Added zoning permit for Reprehenderit non e Sit recusandae Eos', 'Zoning Application', NULL, NULL, '2025-03-19 01:39:07', '2025-03-19 09:39:07'),
(11, 1, 'Rejected zoning permit for Reprehenderit non e Sit recusandae Eos', 'Zoning Application', NULL, NULL, '2025-03-19 01:41:06', '2025-03-19 09:41:06'),
(12, 1, 'Added zoning permit for Expedita beatae quis Omnis aliquid quo co', 'Zoning Application', NULL, NULL, '2025-03-19 01:42:49', '2025-03-19 09:42:49'),
(13, 1, 'Added zoning permit for Distinctio Id magna Harum magna dolorum', 'Zoning Application', NULL, NULL, '2025-03-19 02:25:22', '2025-03-19 10:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registerlanding`
--

CREATE TABLE `registerlanding` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Hernan John Canciller', 1, 'greygreygrey35@gmail.com', NULL, '$2y$12$i5rzyoRK3x7IKP7SsJdymuF1B1vWBm0M2u8wV0PynTB0VgiIEM64W', NULL, '2025-03-13 03:07:21', '2025-03-13 03:07:21'),
(8, 'Recusandae Velit r', 3, 'kejej@mailinator.com', NULL, '$2y$12$tm8D6XwEV9X8EyypfgZlaeB7Crz7gxfF5brZFKgggspo47nbwhfTW', NULL, '2025-03-18 07:49:11', '2025-03-18 07:49:11'),
(9, 'Suscipit aut tempori', 2, 'tyqe@mailinator.com', NULL, '$2y$12$hn1QNXKlAPeTgwKN8lr1tuAoT6L7lth0phfCEM0a.uOwgR1AfByfa', NULL, '2025-03-18 07:52:27', '2025-03-18 07:52:27'),
(10, 'Sed do officia quia', 2, 'nymu@mailinator.com', NULL, '$2y$12$KjJYJYqKC2Zu0CDmLxJiXuNeucoBon2LGUK40b4m8HyaiQlNLyNju', NULL, '2025-03-18 07:53:06', '2025-03-18 07:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `zoning_permits`
--

CREATE TABLE `zoning_permits` (
  `id` int(11) NOT NULL,
  `date_of_application` date NOT NULL,
  `or_date` date DEFAULT NULL,
  `official_receipt_no` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `owner_name` varchar(150) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `location_of_lot` varchar(255) NOT NULL,
  `right_over_land` tinyint(4) DEFAULT NULL,
  `lot_area` varchar(50) DEFAULT NULL,
  `proposed_use` tinyint(4) DEFAULT NULL,
  `zoning_district` tinyint(4) DEFAULT NULL,
  `existing_structures` int(11) DEFAULT NULL,
  `setback_compliance` tinyint(1) DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `inputted_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zoning_permits`
--

INSERT INTO `zoning_permits` (`id`, `date_of_application`, `or_date`, `official_receipt_no`, `first_name`, `middle_name`, `last_name`, `address`, `zip`, `owner_name`, `contact_number`, `email`, `location_of_lot`, `right_over_land`, `lot_area`, `proposed_use`, `zoning_district`, `existing_structures`, `setback_compliance`, `uploaded_file`, `status_id`, `inputted_by`, `created_at`, `updated_at`) VALUES
(1, '2025-01-15', '2025-01-20', '992345', 'Alex', 'C.', 'Johnson', '456 Neutral Ave', '2002', 'Alex Johnson', '09234567890', 'alex.johnson@example.com', 'Lot X', 1, '2500.00', 5, 2, 2, 1, 'file_pending.pdf', 3, 0, '2025-03-20 13:14:29', '2025-03-20 05:15:45'),
(2, '2025-03-15', '2025-03-16', '100123', 'John', 'Michael', 'Doe', '123 Main St', '1000', 'John Doe', '09171234567', 'johndoe@example.com', 'Lot 15, Block 8, City Subdivision', 0, '5000', 0, 0, 0, 1, 'zoning_application.pdf', 3, 0, '2025-03-20 13:16:46', '2025-03-20 05:16:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay_census`
--
ALTER TABLE `barangay_census`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landmarks`
--
ALTER TABLE `landmarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `zoning_permits`
--
ALTER TABLE `zoning_permits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay_census`
--
ALTER TABLE `barangay_census`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `landmarks`
--
ALTER TABLE `landmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zoning_permits`
--
ALTER TABLE `zoning_permits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
