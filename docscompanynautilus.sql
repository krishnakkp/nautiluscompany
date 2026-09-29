-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 29, 2026
-- Server version: 8.0.46-0ubuntu0.24.04.4
-- PHP Version: 8.2.21
--
-- Updated for unified quarterly feedback form (single table).
-- Replaces the previous 4 theme-split tables
-- (feedback_operations / communication / commercial / relationship).

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `docscompanynautilus`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback_submissions`
--

CREATE TABLE `feedback_submissions` (
  `id` int UNSIGNED NOT NULL,
  `ticket_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `survey_period` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overall_satisfaction` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_quality` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `communication` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confidence` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `positive_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `issues_concerns` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `operations_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `communication_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `commercial_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `relationship_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_comments` text COLLATE utf8mb4_unicode_ci,
  `extra_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback_submissions`
--
ALTER TABLE `feedback_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ticket` (`ticket_id`),
  ADD KEY `idx_survey_period` (`survey_period`),
  ADD KEY `idx_submitted` (`submitted_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback_submissions`
--
ALTER TABLE `feedback_submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
