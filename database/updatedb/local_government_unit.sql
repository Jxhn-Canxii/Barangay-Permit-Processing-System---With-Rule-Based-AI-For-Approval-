-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 04:03 AM
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
(13, 1, 'Added zoning permit for Distinctio Id magna Harum magna dolorum', 'Zoning Application', NULL, NULL, '2025-03-19 02:25:22', '2025-03-19 10:25:22'),
(14, 1, 'Added zoning permit for In neque non eaque e Rerum corporis quia', 'Zoning Application', NULL, NULL, '2025-03-20 16:58:16', '2025-03-21 00:58:16'),
(15, 1, 'Added zoning permit for Fugiat non quasi co Neque odio commodi n', 'Zoning Application', NULL, NULL, '2025-03-20 22:42:27', '2025-03-21 06:42:27'),
(16, 1, 'Added zoning permit for Voluptatem accusanti Tempore deserunt ni', 'Zoning Application', NULL, NULL, '2025-03-20 23:11:07', '2025-03-21 07:11:07'),
(17, 1, 'Added zoning permit for Dolor omnis itaque n Unde sapiente ea omn', 'Zoning Application', NULL, NULL, '2025-03-20 23:26:21', '2025-03-21 07:26:21'),
(18, 1, 'Added zoning permit for Consequuntur esse do Dolorum pariatur Qu', 'Zoning Application', NULL, NULL, '2025-03-20 23:29:11', '2025-03-21 07:29:11'),
(19, 1, 'Added zoning permit for Voluptatibus ipsum i Exercitationem tempo', 'Zoning Application', NULL, NULL, '2025-03-20 23:33:26', '2025-03-21 07:33:26'),
(20, 1, 'Added zoning permit for Consequuntur sed sed Nisi id ut do aut e', 'Zoning Application', NULL, NULL, '2025-03-20 23:51:35', '2025-03-21 07:51:35'),
(21, 1, 'Added zoning permit for Id est sit occaecat Optio ipsam ut temp', 'Zoning Application', NULL, NULL, '2025-03-20 23:52:37', '2025-03-21 07:52:37'),
(22, 1, 'Added zoning permit for Quam labore ad aperi Ratione reiciendis q', 'Zoning Application', NULL, NULL, '2025-03-21 00:36:56', '2025-03-21 08:36:56');

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
-- Table structure for table `rules`
--

CREATE TABLE `rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `zoning_district` int(11) NOT NULL,
  `required_area` int(11) DEFAULT 500,
  `minimum_lot_area` int(11) DEFAULT 100,
  `acceptable_land_rights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '[1, 3]' CHECK (json_valid(`acceptable_land_rights`)),
  `setback_compliance_required` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `name`, `zoning_district`, `required_area`, `minimum_lot_area`, `acceptable_land_rights`, `setback_compliance_required`, `created_at`, `updated_at`) VALUES
(1, 'Industrial', 3, 78, 58, '[1]', 1, '2025-03-21 18:44:32', '2025-03-21 18:44:32');

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
  `existing_structures` tinyint(1) DEFAULT NULL,
  `setback_compliance` tinyint(1) DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `rejection_reason` longtext NOT NULL DEFAULT 'None',
  `status_id` int(11) NOT NULL,
  `inputted_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zoning_permits`
--

INSERT INTO `zoning_permits` (`id`, `date_of_application`, `or_date`, `official_receipt_no`, `first_name`, `middle_name`, `last_name`, `address`, `zip`, `owner_name`, `contact_number`, `email`, `location_of_lot`, `right_over_land`, `lot_area`, `proposed_use`, `zoning_district`, `existing_structures`, `setback_compliance`, `uploaded_file`, `rejection_reason`, `status_id`, `inputted_by`, `created_at`, `updated_at`) VALUES
(1, '1989-10-15', '1991-07-03', 'Quia vel omnis ea te', 'Fugiat non quasi co', 'Animi eos maxime co', 'Neque odio commodi n', 'Aut dolorem lorem co', '4422', 'Fugiat id ut sequi', 'Consectetur fugiat a', 'fyjytavo@mailinator.com', 'Quisquam anim id su', 1, '35', 5, 2, 0, 0, 'zoning_permits/XcaBezooZ3caXd7LEEZxyjeHwHV7R0qECDotQ2XF.png', 'Zoning district not found in the rules table', 3, 1, '2025-03-20 22:42:27', '2025-03-21 18:59:31'),
(2, '1990-11-02', '2025-08-07', 'Voluptatibus ut sunt', 'Voluptatem accusanti', 'Dolorem distinctio', 'Tempore deserunt ni', 'Ad tempore alias au', '2560', 'Nam omnis est ration', 'Aute quis esse eius', 'gyjyjinu@mailinator.com', 'Anim consectetur el', 2, '90', 4, 2, 1, 1, 'zoning_permits/8UJ23jGERAyK7eh9rMRtbKzLjLAXn9vpCbFtbaWw.png', 'Denied: Invalid land right, Lot area too small, Zoning district does not allow proposed use', 3, 1, '2025-03-20 23:11:07', '2025-03-21 17:02:43'),
(3, '2009-06-27', '2016-07-28', 'Alias impedit ipsam', 'Dolor omnis itaque n', 'Nisi facere itaque r', 'Unde sapiente ea omn', 'Numquam velit aperia', '9819', 'Quia et animi exerc', 'Et mollitia qui at i', 'syxuhabu@mailinator.com', 'Qui ut nulla culpa q', 3, '57', 2, 1, 1, 1, 'zoning_permits/C1qOZeXk1GjYqTgYzJNIfMwd5p63NCLmMVReyfk0.png', 'Denied: Lot area too small, Zoning district does not allow proposed use', 3, 1, '2025-03-20 23:26:21', '2025-03-21 17:01:08'),
(4, '2013-12-04', '1991-12-23', 'Incidunt et excepte', 'Consequuntur esse do', 'Explicabo Rerum qua', 'Dolorum pariatur Qu', 'Sint numquam ipsa c', '4138', 'Earum mollitia dolor', 'Quas rerum blanditii', 'roxogyho@mailinator.com', 'Eu nemo amet facili', 2, '23', 4, 1, 1, 1, 'zoning_permits/qGxWOUKFnUUuQzLCjCvUTcB0FqlGKos2siuyHule.png', '', 3, 1, '2025-03-20 23:29:11', '2025-03-21 00:16:22'),
(5, '1974-03-17', '2010-07-28', 'Sed unde repudiandae', 'Voluptatibus ipsum i', 'Quaerat eos qui et o', 'Exercitationem tempo', 'Qui quia nisi culpa', '1036', 'Distinctio Labore o', 'Excepturi rerum corp', 'miwuq@mailinator.com', 'Esse porro pariatur', 1, '82', 3, 2, 0, 0, 'zoning_permits/jHI9s2dZZCWfetjnxjFufnbr11zvNjWgGyjuFCF9.png', '', 3, 1, '2025-03-20 23:33:26', '2025-03-21 00:16:31'),
(6, '1990-01-11', '2024-02-10', 'Rerum et dolore qui', 'Consequuntur sed sed', 'Ipsam pariatur Dolo', 'Nisi id ut do aut e', 'Odio in debitis et c', '6063', 'Consequuntur deserun', 'Est non ut veniam', 'gahiz@mailinator.com', 'Aliquid in iste eius', 3, '94', 1, 3, 1, 0, 'zoning_permits/wndGzNUXo1Tg8qgG6rUhb4hRiDTdiXBzNSyxqYe5.png', '', 3, 1, '2025-03-20 23:51:35', '2025-03-21 00:16:14'),
(7, '2022-10-13', '1993-11-27', 'In est quo consequat', 'Id est sit occaecat', 'Aliquam consectetur', 'Optio ipsam ut temp', 'Nihil vel natus enim', '9957', 'Vel quia nihil eu el', 'Totam voluptatem vol', 'nedu@mailinator.com', 'Quia et consequat S', 1, '40', 5, 3, 1, 1, 'zoning_permits/gY6QwIn1LdLm49LomLVEwDEiEmplhGBtL0L24uB6.png', '', 3, 1, '2025-03-20 23:52:37', '2025-03-21 00:12:56'),
(8, '1988-02-26', '2025-08-21', 'Non voluptates incid', 'Quam labore ad aperi', 'Optio sunt cumque', 'Ratione reiciendis q', 'Eum corporis Nam sed', '6636', 'Voluptate in veniam', 'Sunt soluta quia am', 'jeneli@mailinator.com', 'Ex nostrud aspernatu', 3, '67', 2, 3, 1, 0, 'zoning_permits/8jIfghj2caXqDK48dHI1TMlEsqrff6FytagUqQzl.png', 'Denied: Lot area too small, Zoning district does not allow proposed use, Setback non-compliant', 3, 1, '2025-03-21 00:36:56', '2025-03-21 16:57:45');

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
-- Indexes for table `rules`
--
ALTER TABLE `rules`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rules`
--
ALTER TABLE `rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zoning_permits`
--
ALTER TABLE `zoning_permits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
