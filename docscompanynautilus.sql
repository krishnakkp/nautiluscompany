-- phpMyAdmin SQL Dump
-- Database: `docscompanynautilus`
-- Unified quarterly feedback form (single table only).

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Drop legacy theme-split tables (no longer used)
DROP TABLE IF EXISTS `feedback_operations`;
DROP TABLE IF EXISTS `feedback_communication`;
DROP TABLE IF EXISTS `feedback_commercial`;
DROP TABLE IF EXISTS `feedback_relationship`;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `feedback_submissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `survey_period` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overall_satisfaction` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_quality` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `communication` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confidence` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `positive_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `issues_concerns` text COLLATE utf8mb4_unicode_ci,
  `operations_feedback` text COLLATE utf8mb4_unicode_ci,
  `communication_feedback` text COLLATE utf8mb4_unicode_ci,
  `commercial_feedback` text COLLATE utf8mb4_unicode_ci,
  `relationship_feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `other_comments` text COLLATE utf8mb4_unicode_ci,
  `extra_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ticket` (`ticket_id`),
  KEY `idx_survey_period` (`survey_period`),
  KEY `idx_submitted` (`submitted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
