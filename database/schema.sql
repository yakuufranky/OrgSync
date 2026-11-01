-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2026 at 06:23 PM
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
-- Database: `orgsync_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `org_code` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` enum('Academic','Non-Academic') NOT NULL DEFAULT 'Academic',
  `school_name` varchar(150) NOT NULL DEFAULT 'Quezon City University',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `org_code`, `name`, `type`, `school_name`, `created_at`) VALUES
(1, 'QCU-IT-2026', 'Society of Information Technology Students', 'Academic', 'Quezon City University', '2026-10-18 12:52:00'),
(2, 'ORG-8104D733', 'Association of Computing Scholars', 'Academic', 'Quezon City University', '2026-10-18 12:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `course` varchar(100) NOT NULL,
  `department_committee` varchar(100) DEFAULT NULL,
  `role` enum('President','Officer','Member') NOT NULL DEFAULT 'Member',
  `position` varchar(100) NOT NULL,
  `status` enum('Active','Inactive','Pending') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `organization_id`, `full_name`, `email`, `password_hash`, `course`, `department_committee`, `role`, `position`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juan Dela Cruz', 'president@qcu.edu.ph', '$2y$10$g9rV67TwPFRiENwXLwCqe.dO9lTdq7McWHy2TNJ400LhoS18xiT0u', 'Bachelor of Science in Information Technology', 'Executive Board', 'President', 'President', 'Active', '2026-10-18 12:52:00', '2026-10-18 12:52:00'),
(2, 2, 'Alice Santos', 'alice@qcu.edu.ph', '$2y$10$I0t8Xox7ShRe/Uuo/3y6s.Nzsa/qqX7kGfXL63PtvZu6rNFz9YLgi', 'BS Computer Science', 'Executive Committee', 'President', 'President', 'Active', '2026-10-18 12:52:46', '2026-10-18 12:52:46'),
(3, 2, 'Bob Cruz', 'bob@qcu.edu.ph', '$2y$10$0BXMdpJzU0.1vpTw5n9JduJ9F/LCZUXqZJcuF3ITzo8esebrs.fFa', 'BS Computer Science', 'Academics & Training', 'Officer', 'Vice President', 'Active', '2026-10-18 12:52:46', '2026-10-18 12:52:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `org_code` (`org_code`),
  ADD KEY `idx_org_code` (`org_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_organization` (`organization_id`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_organization` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
