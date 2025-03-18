-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 06:56 PM
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
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(9, 1, 'Approved zoning permit for Ab cum perspiciatis Dicta pariatur Aliq', 'Zoning Application', NULL, NULL, '2025-03-18 08:34:10', '2025-03-18 16:34:10');

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
  `right_over_land` varchar(100) DEFAULT NULL,
  `lot_area` varchar(50) DEFAULT NULL,
  `uploaded_file` varchar(255) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `inputted_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zoning_permits`
--

INSERT INTO `zoning_permits` (`id`, `date_of_application`, `or_date`, `official_receipt_no`, `first_name`, `middle_name`, `last_name`, `address`, `zip`, `owner_name`, `contact_number`, `email`, `location_of_lot`, `right_over_land`, `lot_area`, `uploaded_file`, `status_id`, `inputted_by`, `created_at`, `updated_at`) VALUES
(1, '1985-08-25', '2008-09-26', 'Aliquid aliqua Eum', 'Hernan', 'John', 'Canciller', 'Bulkan Mayon,Alpha Chupapi Munyanyo,Block 69 Kilid sa Kamunggayan.', '6014', 'Iusto qui aliquam co', '09561741499', 'greygreygrey35@gmail.com', 'Sit est minima adi', 'Philippines', '88', 'zoning_permits/ZnQOm6i1K57er3QFgRKMFUMSxIz1hA44uFB2fnsO.pdf', 2, 1, '2025-03-18 08:27:32', '2025-03-18 08:28:24'),
(2, '2009-02-10', '2000-05-28', 'Commodi ex sit ipsu', 'Nisi corrupti sed q', 'Consequatur et dolo', 'Fugiat nostrum elit', 'Ut amet eos quia e', '9259', 'Consequat Possimus', 'Et exercitationem et', 'zykiwynot@mailinator.com', 'Mollitia architecto', 'Fugiat voluptate ali', '31', 'zoning_permits/VvYqexAXxOJMlXcZjuZZmBMrKScPSbGZQBYavs8o.jpg', 2, 1, '2025-03-18 08:32:54', '2025-03-18 08:33:15'),
(3, '2019-05-14', '1982-03-04', 'Aute ut veritatis fu', 'Ab cum perspiciatis', 'Fuga Commodo sit ma', 'Dicta pariatur Aliq', 'Minim voluptas sed a', '2876', 'Neque odio itaque al', 'Deserunt in maxime e', 'ximokajaw@mailinator.com', 'Iusto et deleniti si', 'Quia fugiat officii', '96', 'zoning_permits/TviDchYVI2xdbyvdAsFV00Gf53RVzR2fSU3ZNS3s.jpg', 2, 1, '2025-03-18 08:34:05', '2025-03-18 08:34:10');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
