-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2025 at 04:12 AM
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
(1, NULL, 'Added zoning permit for Laboriosam non rati Est enim qui offici', 'Zoning Application', NULL, NULL, '2025-03-15 13:15:44', '2025-03-15 13:15:44'),
(2, 1, 'Added zoning permit for Hic voluptatem Nam Quas ut nesciunt in', 'Zoning Application', NULL, NULL, '2025-03-15 05:52:25', '2025-03-15 13:52:25'),
(3, 1, 'Approved zoning permit for Laboriosam non rati Est enim qui offici', 'Zoning Application', NULL, NULL, '2025-03-15 05:58:51', '2025-03-15 13:58:51'),
(4, 1, 'Approved zoning permit for Laboriosam non rati Est enim qui offici', 'Zoning Application', NULL, NULL, '2025-03-15 05:58:56', '2025-03-15 13:58:56'),
(5, 1, 'Approved zoning permit for Laboriosam non rati Est enim qui offici', 'Zoning Application', NULL, NULL, '2025-03-15 05:59:04', '2025-03-15 13:59:04'),
(6, 1, 'Approved zoning permit for Hic voluptatem Nam Quas ut nesciunt in', 'Zoning Application', NULL, NULL, '2025-03-15 05:59:06', '2025-03-15 13:59:06'),
(7, 1, 'Approved zoning permit for Ipsa expedita nihil Dolorum assumenda hi', 'Zoning Application', NULL, NULL, '2025-03-15 05:59:08', '2025-03-15 13:59:08'),
(8, 1, 'Added zoning permit for Ipsam ad occaecat om Consequatur sed aut', 'Zoning Application', NULL, NULL, '2025-03-15 05:59:31', '2025-03-15 13:59:31'),
(9, 1, 'Rejected zoning permit for Ipsam ad occaecat om Consequatur sed aut', 'Zoning Application', NULL, NULL, '2025-03-15 05:59:37', '2025-03-15 13:59:37'),
(10, 1, 'Added zoning permit for Non temporibus minim Possimus quos disti', 'Zoning Application', NULL, NULL, '2025-03-15 06:16:51', '2025-03-15 14:16:51'),
(11, 1, 'Rejected zoning permit for Non temporibus minim Possimus quos disti', 'Zoning Application', NULL, NULL, '2025-03-15 06:23:46', '2025-03-15 14:23:46'),
(12, 1, 'Added zoning permit for Repudiandae laborios Quis quis pariatur', 'Zoning Application', NULL, NULL, '2025-03-15 06:24:32', '2025-03-15 14:24:32'),
(13, 1, 'Added zoning permit for Et quis minus unde m Proident doloribus', 'Zoning Application', NULL, NULL, '2025-03-15 06:25:14', '2025-03-15 14:25:14'),
(14, 1, 'Added zoning permit for Iusto ipsum dolorum Dolor magnam incidid', 'Zoning Application', NULL, NULL, '2025-03-15 06:27:12', '2025-03-15 14:27:12'),
(15, 1, 'Approved zoning permit for Iusto ipsum dolorum Dolor magnam incidid', 'Zoning Application', NULL, NULL, '2025-03-15 06:27:19', '2025-03-15 14:27:19'),
(16, 1, 'Rejected zoning permit for Et quis minus unde m Proident doloribus', 'Zoning Application', NULL, NULL, '2025-03-15 06:27:26', '2025-03-15 14:27:26'),
(17, 1, 'Approved zoning permit for Repudiandae laborios Quis quis pariatur', 'Zoning Application', NULL, NULL, '2025-03-15 06:31:56', '2025-03-15 14:31:56');

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
(2, 'Bruce Dale', 1, 'nudeweso@mailinator.com', NULL, '$2y$12$X12eI7jWnxS4A8HzGxPmleLIvEoD0VcLSRKrwys3A4o8tgjOMjJe6', NULL, '2025-03-15 06:49:01', '2025-03-15 06:49:01'),
(3, 'Driscoll Francis', 2, 'nawuporore@mailinator.com', NULL, '$2y$12$r74j4sPlnUSIax4kpIuPb.wlHhKdrrZ9K4lmPGsvLMeQq3uxx3//u', NULL, '2025-03-15 06:49:26', '2025-03-15 06:49:26'),
(4, 'Oscar Lancaster', 2, 'xilalyjaq@mailinator.com', NULL, '$2y$12$N.kqu4QOr9b9EZfVWqun5uP6re9h0dNS9u1azOxS7vBLxWMWbqD4u', NULL, '2025-03-15 06:57:27', '2025-03-15 06:57:27'),
(5, 'Ullamco excepteur eo', 2, 'paguviwo@mailinator.com', NULL, '$2y$12$UwZxOB4O93kPd37VJIM7eu2euASR/EqINXjkYdUe7WYZ3jmsAZfMS', NULL, '2025-03-15 07:18:54', '2025-03-15 07:18:54');

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
(1, '2000-03-13', '1988-04-19', 'Deserunt ad et et ul', 'Ipsa expedita nihil', 'Id sed sequi dolor v', 'Dolorum assumenda hi', 'Consequatur consect', '300', 'A consectetur vel d', 'Quis esse eiusmod in', 'jixavyti@mailinator.com', 'Do labore accusantiu', 'Quis et aliquid labo', '77', 'zoning_permits/ReLWwTlB3ZoXeeTuwJ9BrzqAjkBmsGlbY3fFK5k6.jpg', 2, 0, '2025-03-15 13:04:12', '2025-03-15 05:59:08'),
(2, '1991-10-06', '1979-12-07', 'Corporis vel assumen', 'Laboriosam non rati', 'Reprehenderit dolor', 'Est enim qui offici', 'Omnis deserunt labor', '400', 'Quia est autem venia', 'Ad dolor velit est f', 'vegenuqase@mailinator.com', 'Qui voluptatum error', 'Laboriosam quis ven', '30', 'zoning_permits/4VZihxPA8Zd0Qbdp39AGprHFjbdtgea9fKplHM4K.jpg', 2, 0, '2025-03-15 13:09:07', '2025-03-15 05:59:04'),
(3, '1991-10-06', '1979-12-07', 'Corporis vel assumen', 'Laboriosam non rati', 'Reprehenderit dolor', 'Est enim qui offici', 'Omnis deserunt labor', '400', 'Quia est autem venia', 'Ad dolor velit est f', 'vegenuqase@mailinator.com', 'Qui voluptatum error', 'Laboriosam quis ven', '30', 'zoning_permits/MsL7Yj13Sjs8066Hn0w2eSBXqakZgrYaqm5KyfCH.jpg', 2, 0, '2025-03-15 13:10:19', '2025-03-15 05:58:56'),
(4, '1991-10-06', '1979-12-07', 'Corporis vel assumen', 'Laboriosam non rati', 'Reprehenderit dolor', 'Est enim qui offici', 'Omnis deserunt labor', '400', 'Quia est autem venia', 'Ad dolor velit est f', 'vegenuqase@mailinator.com', 'Qui voluptatum error', 'Laboriosam quis ven', '30', 'zoning_permits/9GnGrbK19My4PlWmybavIFKVgNGVx9V43vQtqxFt.jpg', 2, 0, '2025-03-15 13:15:44', '2025-03-15 05:58:51'),
(5, '1977-09-21', '1974-06-17', 'Nisi in dolor offici', 'Hic voluptatem Nam', 'Autem quibusdam prov', 'Quas ut nesciunt in', 'Dolore et culpa cons', '234234234', 'Omnis sint aut asper', 'Suscipit excepturi p', 'nida@mailinator.com', 'Laboriosam sit rec', 'Proident saepe magn', '63', 'zoning_permits/BNbvs406bQtDYUCfafIVt0tOGwhT4JRENAUUiEqc.jpg', 2, 1, '2025-03-15 05:52:25', '2025-03-15 05:59:06'),
(6, '1970-10-13', '2010-06-21', 'Nostrud omnis commod', 'Ipsam ad occaecat om', 'Explicabo Dolor dol', 'Consequatur sed aut', 'At dolor doloribus a', '2300', 'Quisquam deserunt do', 'Consectetur qui mole', 'favivutazy@mailinator.com', 'Et aliquip iure exer', 'Sit nostrum obcaecat', '14', 'zoning_permits/di4okOcF96jfvV4leOF5jj1lL0x2F5qRQlOjELUh.jpg', 3, 1, '2025-03-15 05:59:31', '2025-03-15 05:59:37'),
(7, '1974-06-01', '2000-11-25', 'Aspernatur accusamus', 'Non temporibus minim', 'Odio in quos repelle', 'Possimus quos disti', 'Qui ad nemo labore m', '300', 'Dolor recusandae Hi', 'Quis adipisicing exe', 'cuwa@mailinator.com', 'Ea praesentium ex si', 'Ipsum qui reiciendis', '20', 'zoning_permits/hYQgl3y0NRe8fYuJKg8ifWZr7bZagf2B5MYG1HrZ.jpg', 3, 1, '2025-03-15 06:16:51', '2025-03-15 06:23:46'),
(8, '2024-01-01', '2013-09-24', 'Ab rerum consectetur', 'Repudiandae laborios', 'Molestiae aliquid ex', 'Quis quis pariatur', 'Excepturi eaque atqu', '1199', 'Dolores ipsa dolor', 'Deleniti aperiam odi', 'webibu@mailinator.com', 'Ea laboris ea rerum', 'Velit itaque odit si', '70', 'zoning_permits/AuEWu1EDsNZ3YReDI3E7vMqSHU0SSeQEMgmURYMd.jpg', 2, 1, '2025-03-15 06:24:31', '2025-03-15 06:31:56'),
(9, '1978-04-19', '1998-05-25', 'Sit quibusdam lorem', 'Et quis minus unde m', 'Cumque nostrum illo', 'Proident doloribus', 'Occaecat ex eligendi', '5649', 'Ullamco porro perspi', 'Officia esse ut repr', 'myqiled@mailinator.com', 'Vitae rerum eos enim', 'In labore reprehende', '72', 'zoning_permits/OS3qqknH4TDkvw0YYz4rRRvfUyYxLuLGhR2VYgQ6.jpg', 3, 1, '2025-03-15 06:25:14', '2025-03-15 06:27:26'),
(10, '2017-04-04', '1985-05-21', 'Omnis magni est volu', 'Iusto ipsum dolorum', 'Eiusmod sint ut nece', 'Dolor magnam incidid', 'Odit autem nisi exer', '1282', 'Ut ullam blanditiis', 'Neque molestias temp', 'jivigoloz@mailinator.com', 'Mollit consectetur', 'Harum quod vel maxim', '28', 'zoning_permits/tOzxz2OQeB3vcsf0Sf8svabTPUZP7gFiQNSKPUpo.jpg', 2, 1, '2025-03-15 06:27:12', '2025-03-15 06:27:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
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
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zoning_permits`
--
ALTER TABLE `zoning_permits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
