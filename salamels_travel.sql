-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2021 at 11:40 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salamels_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `id` int(11) NOT NULL,
  `airline_name` varchar(255) NOT NULL,
  `enable` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`id`, `airline_name`, `enable`) VALUES
(1, 'PIA', 1),
(2, 'AirSial', 1),
(3, 'Air Blue', 1),
(4, 'Serena Air', 1),
(5, 'Qatar Airways', 1),
(8, 'Saudi Arabian Airlines', 1),
(9, 'Turkish Airlines', 1),
(10, 'Turkish Airways', 0),
(11, 'Gulf Air', 1),
(12, 'Pegasus', 1),
(13, 'China Southern', 1),
(14, 'Thai Airways', 1),
(15, 'Air China', 1),
(16, 'Siri Lankan', 1),
(17, 'Emirates', 1),
(18, 'Air Arabia', 1),
(19, 'Fly Dubai', 1),
(20, 'British Airways', 1),
(21, 'Virgin Atlantic', 1),
(22, 'Etihad', 1),
(23, 'Saudi Gulf', 1),
(24, 'Oman Air', 1),
(25, 'Kuwait Airways', 1),
(26, 'Royal Dutch', 1),
(27, 'Kam Air', 1),
(28, 'Others', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `enable` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `bank_name`, `enable`) VALUES
(1, 'HBL', 0),
(2, 'Askari', 0),
(3, 'National', 0),
(4, 'Silk', 0),
(5, 'UBL-PK31UNIL0109000252924433', 1),
(6, 'ABL-PK50ABPA0010076274930014', 1),
(7, 'BANK ALFALAH-01491007198051', 0),
(8, 'BANK ALFALAH-PK40ALFH0149001007198051', 1),
(9, 'BANK AL HABIB-PK76BAHL0089008100589401', 1),
(10, 'BANK AL BARAKA-PK55AIIN0000105526370010', 1),
(11, 'MEEZAN BANK-PK65MEZN0020010101758180', 1),
(12, 'SUMMIT BANK-PK06SUMB0407027140109508', 1),
(13, 'EASY PAISA-03455495875', 1),
(14, 'U PAISA-03455495875', 1),
(15, 'JAZZ CASH-03455495875', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `booking_source` varchar(255) NOT NULL,
  `enable` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_source`, `enable`) VALUES
(1, 'SomeOne', 0),
(4, 'check', 0),
(5, 'Salam Web Portal', 1),
(6, 'PIA-HITIT ID', 1),
(7, 'AIRSIAL-WEB', 1),
(8, 'SABRE- PCC-092K', 1),
(9, 'GALILEO- PCC- 03R2', 1),
(10, 'AIRBLUE - ID', 1),
(11, 'SERENE AIR-WEB', 1),
(12, 'AIR ARABIA-G9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ledger_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visiting_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '3',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `contact`, `email`, `phone`, `agency_name`, `mobile`, `ledger_link`, `password`, `visiting_card`, `agency_picture`, `status`, `created_at`, `updated_at`) VALUES
(25, 'SULTAN BAHU TRAVELS', 'sakhisultanbahu786@gmail.com', '03334744948', 'SULTAN BAHU TRAVELS', '03438873833', 'https://docs.google.com/spreadsheets/d/1zIyofGKhNZD1vfsZaYKwtxcVPF3S0tDklhQRdXyGJPg/edit?usp=sharing', '12345678', 'c6b5TvPZNvSULTAN BAHU TRAVELS.jpg', 'JBmR333EepSULTAN BAHU TRAVELS.jpg', '2', '2021-09-21 10:29:44', '2021-11-25 14:29:49'),
(26, 'ESHAL TRAVELS', 'multiplex.edun@yahoo.com', '03165185335', 'ESHAL TRAVELS', '0512607386', 'https://docs.google.com/spreadsheets/d/1aywdQ9EvFYOO7-peY41QO_ni4uJNubQQlfeb-FiMLBM/edit?usp=sharing', '12345678', 'NLVbQ9y7jFESHAL TRAVEL.jpg', 'SkIYwfqlzHESHAL TRAVEL.jpg', '2', '2021-09-21 10:45:48', '2021-11-25 14:56:21'),
(27, 'HOORAIN TRAVELS', 'zaheer.fdm@gmail.com', '03219525354', 'HOORAIN TRAVELS', '0513757162', 'https://docs.google.com/spreadsheets/d/1EfDE0xs-13Rndm2xPpWP-4L1Q0eBp52WDdnQ1Jfdfr4/edit', '12345678', 'Mfe5JJsbZoHORRAIN CARD.pdf', 'VhMm7CqCVBHORRAIN CARD.pdf', '2', '2021-09-21 11:16:23', '2021-11-25 14:56:23'),
(28, 'AHMM GKN TRAVELS', 'arasheedgjk.ahmmtravel@gmail.com', '03100571710', 'AHMM TRAVELS', '0513757157', 'https://docs.google.com/spreadsheets/d/1RUiwuqGjyib4KMEAesWI6VROZf4ulIoit_MHttFHq74/edit?usp=sharing', '12345678', 'EFfGe5PVrWWhatsApp Image 2021-09-21 at 10.49.29 AM.jpeg', 'HSKJVG290WWhatsApp Image 2021-09-21 at 10.49.29 AM.jpeg', '2', '2021-09-21 11:24:18', '2021-11-25 14:56:23'),
(29, 'TURKHAM TRAVELS', 'turkhame4027@gmail.com', '03005743362', 'TUR KHAM TRAVELS', '03446043362', 'https://docs.google.com/spreadsheets/d/1STtRmRUhke7HECobXGRX6-oBLmvqFbDqc3C73Twm2vE/edit?usp=sharing', '12345678', 'qPrib20ViDturkham travel.jpeg', 'QYQUDQkhZ1turkham travel.jpeg', '2', '2021-09-21 11:53:30', '2021-11-25 14:56:24'),
(30, 'RANJHA TRAVELS', 'ranjhatravel@hotmail.com', '03426640021', 'RANJHA TRAVELS', '03426640021', 'https://docs.google.com/spreadsheets/d/1Z-jxLv8LK420BxBTADxDxEwSNNzsUgImXbBw1EDX6DU/edit#gid=468652638', '12345678', 'sfEVBKXJoV85b1ca32-cd8b-483a-a3ff-ba7783e92c17.jpg', 'lIQL1FRHKg85b1ca32-cd8b-483a-a3ff-ba7783e92c17.jpg', '2', '2021-10-10 14:00:17', '2021-11-25 13:42:22'),
(34, 'CFD TRAVELS', 'cfdtravel1@gmail.com', '+92573641351', 'CFD Travel & Tour SMC Private Limite', '+923451702221', 'https://docs.google.com/spreadsheets/d/1OLQJu-15M4IkaEuTFCYaINGY2w6Dm7zaInOawnfFPk4/edit', 'tw5875', 'nxXg8bjmNcWhatsApp Image 2021-03-30 at 21.45.12.jpeg', 'XhfuEE3JHMcfd logo.jpg', '2', '2021-10-25 12:38:06', '2021-11-25 13:41:35'),
(35, 'Adeel Us Salam', 'Kingadeel07@gmail.com', '+925123444543', 'Super', '+9231456452652', 'https://agents.salamtravels.com.pk/admin/addNewCustomer', 'Salam6874', 'F5MVXZQDD6Rectangle 39.png', 'QjBHfQ6yyUninja-vission-1-FILEminimizer.png', '2', '2021-10-26 19:52:45', '2021-11-25 14:20:40'),
(36, 'HANANA TRAVELS', 'hananatravels@gmail.com', '0483780419', 'HANANA TRAVELS', '+923452950436', 'https://docs.google.com/spreadsheets/d/1TkjYnNV2LuMKDIKdWKVyn27QjiLvzyLPBV20F-Ui1DI/edit#gid=1527547808', '12345678', '3rMymnlTBOHANANA.jpg', 'AlT3TiWMDGHANANA.jpg', '2', '2021-11-13 15:53:39', '2021-11-25 13:41:11'),
(37, 'HADI TRAVELS', 'THEHADITRAVELS@HOTMAIL.COM', '0514950826', 'HADI TRAVELS', '03008503654', 'https://docs.google.com/spreadsheets/d/1XLqV2cZrhIBezDNx-Uim8IG8gSkJTlVGz7Z1vdK1BEM/edit#gid=468652638', '12345678', 'tG2NVVuVJLIMG_7112.PNG', 'SZFFKCyfwRIMG_7112.PNG', '2', '2021-11-18 02:00:55', '2021-11-25 13:40:53'),
(39, 'SALAM TRAVELS', 'salamtravelspk@gmail.com', '03455495875', 'SALAM TRAVELS', '03455495875', 'https://docs.google.com/spreadsheets/d/124qVlNoECaAi9wkYUQh4QAFcF85FzsxBupxLiih25cQ/edit#gid=468652638', '12345678', 'MhtuZYEwtcWhatsApp Image 2021-11-23 at 3.55.16 PM.jpeg', 'aswa0aPKz3WhatsApp Image 2021-11-23 at 3.55.16 PM.jpeg', '2', '2021-11-25 13:38:07', '2021-11-25 13:38:19'),
(40, 'ABU WAQAR TRAVELS', 'abwaqartravels@gmail.com', '03005701354', 'ABU WAQAR TRAVELS', '0937861446', 'https://docs.google.com/spreadsheets/d/124qVlNoECaAi9wkYUQh4QAFcF85FzsxBupxLiih25cQ/edit#gid=468652638', '12345678', 'kmAYmeBqCgWhatsApp Image 2021-11-25 at 12.47.49 PM.jpeg', 'YjuWRB8ZPiWhatsApp Image 2021-11-25 at 12.47.49 PM.jpeg', '2', '2021-11-25 14:09:49', '2021-11-25 14:10:04');

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
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_resets_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2021_09_08_125002_create_tab_info', 1),
(11, '2021_09_08_125940_create_tab_type', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('uneebmalik99@gmail.com', 'uIl6KqEuxXS6mvTpVToFWorI9xhrcLZjOd6auduncVviiuyIpvbHTcw4kF7zM4HZ', '2021-10-26 18:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `admin_remarks` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT '5',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `amount`, `bank`, `payment_date`, `payment_proof`, `remarks`, `admin_remarks`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(24, '1000000', '5', '2021-11-18', NULL, 'cash given', NULL, 5, 9, '2021-11-18 17:57:45', '2021-11-18 17:57:45'),
(25, '1000000', '15', '2021-11-26', 'pCbHS___ Airblue ___ - View Reservation (1).pdf', NULL, NULL, 7, 20, '2021-11-26 14:11:55', '2021-11-26 14:12:58');

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
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Processing'),
(2, 'Approved'),
(3, 'Pending'),
(4, 'Rejected'),
(5, 'submitted'),
(6, 'posted'),
(7, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `tabinfo`
--

CREATE TABLE `tabinfo` (
  `id` int(10) UNSIGNED NOT NULL,
  `airline_id` bigint(20) UNSIGNED NOT NULL,
  `pnr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_source_id` bigint(20) UNSIGNED NOT NULL,
  `sector` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passenger_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL DEFAULT '5',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tabtype_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabinfo`
--

INSERT INTO `tabinfo` (`id`, `airline_id`, `pnr`, `booking_source_id`, `sector`, `date`, `passenger_name`, `remarks`, `admin_remarks`, `status_id`, `user_id`, `tabtype_id`, `created_at`, `updated_at`) VALUES
(27, 1, 'ggbgg', 1, 'hbi-kjh', '2021-09-30', 'irfan', NULL, 'tes', 6, 4, 1, '2021-09-18 19:33:30', '2021-09-18 19:39:41'),
(28, 5, 'asdfsd', 1, 'dsffdsf', '2021-09-16', 'dsfd dfd', 'dfg fdf gf', NULL, 5, 4, 1, '2021-09-20 11:01:09', '2021-09-20 11:01:09'),
(29, 4, '23343565', 1, 'asdf d', '2021-09-22', 'Usman', 'df  asdf', NULL, 5, 10, 1, '2021-09-20 11:20:44', '2021-09-20 11:20:44'),
(30, 13, '23343565', 1, 'asdf d', '2021-09-24', 'Usman', 'sd sdf sdf d', 'Test Case', 4, 10, 3, '2021-09-20 11:25:01', '2021-11-25 13:19:26'),
(31, 14, '23343565', 1, 'asdf d', '2021-09-17', 'Usman', 'sdf sd fd', 'Test Case', 4, 10, 3, '2021-09-20 11:26:25', '2021-11-25 13:18:59'),
(32, 9, '23343565', 1, 'asdf d', '2021-09-23', 'Usman', 'sdf sdf df', 'Test Case', 4, 10, 3, '2021-09-20 11:28:21', '2021-11-25 13:18:53'),
(33, 11, '23343565', 1, 'asdf d', '2021-09-23', 'Usman', 'sd s fdsf', 'Test Case', 4, 10, 3, '2021-09-20 11:38:27', '2021-11-25 13:18:45'),
(34, 8, 'abcxyz', 5, 'dxb-jed', '2021-10-19', 'nisar ahmed', 'plz call me befor issueance', 'test case', 4, 11, 1, '2021-10-10 14:07:19', '2021-10-25 11:20:26'),
(35, 28, 'abvcfre', 5, 'isb-khi', '2021-10-28', 'naeem', 'test case', 'test case', 4, 11, 1, '2021-10-14 11:53:36', '2021-10-25 11:20:19'),
(36, 4, 'asa', 5, 'abvrgt', '2021-10-30', 'sdds', 'plz call me fg', 'test case', 4, 9, 1, '2021-10-20 20:05:21', '2021-10-20 20:29:38'),
(37, 1, '7UGMC0', 6, 'ISB-MCT', '2021-11-04', 'KHURRAM SHAHZAD', NULL, 'ON WHATSAPP GROUP ISHUED AGAINST GDS PNR 0FGH7H PKR 89680/2\nCORRECT SECTOR KHI/MCT', 6, 13, 1, '2021-10-25 12:06:09', '2021-10-25 12:26:29'),
(38, 4, 'abc123', 5, 'khi-isb', '2021-11-06', 'hamid mumtaz', NULL, NULL, 5, 11, 1, '2021-10-26 17:07:44', '2021-10-26 17:07:44'),
(39, 8, '0k8jbk', 5, 'dxb-giz', '2021-11-28', 'imtiaz hussain', 'test case already issed ticket', 'already issued on call', 4, 17, 1, '2021-11-13 15:56:23', '2021-11-25 13:17:34'),
(40, 3, 'nqzpzv', 10, 'isb-rkt', '2021-11-23', 'm zain', 'issued but not posted', 'ALREADY POSTED', 4, 18, 1, '2021-11-18 02:03:33', '2021-11-25 13:17:32'),
(41, 22, '0lbsck', 5, 'khi-zvj', '2021-12-02', 'mr ishtiaq ahmed', 'already issued test case', 'test case', 6, 13, 1, '2021-11-18 17:25:27', '2021-11-25 13:18:04'),
(42, 17, 'OLVYYL', 5, 'DXB-SKT', '2021-11-24', 'RANA MUHAMMAD ARSHAD', 'ISSUE KR DE', 'TRAVEL DATE 25 NOV', 6, 17, 1, '2021-11-21 13:49:57', '2021-11-22 10:51:15'),
(44, 5, 'cmv20x', 5, 'fru-mux', '2022-04-29', 'Mr. GHAZANFAR ALI', 'please call before issuance', NULL, 5, 20, 1, '2021-11-25 13:59:36', '2021-11-25 13:59:36'),
(45, 19, 'cmv20x', 5, 'fru-mux', '2022-04-29', 'mr ghazanfar ali', 'please call before issuance', NULL, 5, 20, 1, '2021-11-25 14:15:24', '2021-11-25 14:15:24'),
(46, 21, '0P7V1K', 5, 'isb-man', '2022-01-25', 'nadeem adeel', NULL, NULL, 5, 20, 1, '2021-12-03 19:39:53', '2021-12-03 19:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `tabtype`
--

CREATE TABLE `tabtype` (
  `id` int(10) UNSIGNED NOT NULL,
  `tab_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tabtype`
--

INSERT INTO `tabtype` (`id`, `tab_name`, `created_at`, `updated_at`) VALUES
(0, 'Payment', '2021-09-11 18:22:47', '2021-09-11 18:22:47'),
(1, 'Ticketing', '2021-09-08 13:51:43', '2021-09-08 13:51:43'),
(2, 'Refund', '2021-09-08 13:51:43', '2021-09-08 13:51:43'),
(3, 'Void', '2021-09-08 13:52:17', '2021-09-08 13:52:17'),
(4, 'Date Change', '2021-09-08 13:52:17', '2021-09-08 13:52:17');

-- --------------------------------------------------------

--
-- Table structure for table `tabtypelink`
--

CREATE TABLE `tabtypelink` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `tabtype_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tabtypelink`
--

INSERT INTO `tabtypelink` (`id`, `status_id`, `link`, `tabtype_id`) VALUES
(1, 5, 'admin/ticketingStatusSubmitted', 1),
(2, 1, 'admin/ticketingStatusProcessing', 1),
(3, 7, 'admin/ticketingStatusCompleted', 1),
(4, 4, 'admin/ticketingStatusRejected', 1),
(5, 6, 'admin/ticketingStatusPosted', 1),
(6, 5, 'admin/refundStatusSubmitted', 2),
(7, 1, 'admin/refundStatusProcessing', 2),
(8, 7, 'admin/refundStatusCompleted', 2),
(9, 4, 'admin/refundStatusRejected', 2),
(10, 6, 'admin/refundStatusPosted', 2),
(11, 5, 'admin/voidStatusSubmitted', 3),
(12, 1, 'admin/voidStatusProcessing', 3),
(13, 7, 'admin/voidStatusCompleted', 3),
(14, 4, 'admin/voidStatusRejected', 3),
(15, 6, 'admin/voidStatusPosted', 3),
(16, 5, 'admin/dateChangeStatusSubmitted', 4),
(17, 1, 'admin/dateChangeStatusProcessing', 4),
(18, 7, 'admin/dateChangeStatusCompleted', 4),
(19, 4, 'admin/dateChangeStatusRejected', 4),
(20, 6, 'admin/dateChangeStatusPosted', 4),
(21, 5, 'admin/paymentStatusSubmitted', 5),
(22, 1, 'admin/paymentStatusProcessing', 5),
(23, 7, 'admin/paymentStatusCompleted', 5),
(24, 4, 'admin/paymentStatusRejected', 5),
(25, 6, 'admin/paymentStatusPosted', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 'Uneeb', 'uneebmalik99@gmail.com', 1, NULL, '$2y$10$Dcmaj8raH8ZOrNUADDnTaOXpvNWvWHCKahqKUv4Gy7/PZKNSl7rBy', NULL, 0, '2021-09-13 17:40:02', '2021-09-14 08:34:19'),
(9, 'TURKHAM TRAVELS', 'turkhame4027@gmail.com', 0, NULL, '$2y$10$NSFFNWLGPBa8VxAtbL4IqujQ3YRhD2kWr6tutchkTS5ml4Bk94V4y', NULL, 0, '2021-11-25 14:56:24', '2021-11-25 14:56:24'),
(10, 'SULTAN BAHU TRAVELS', 'sakhisultanbahu786@gmail.com', 0, NULL, '$2y$10$TWveQFXzij2ODESM7ZUuKe3.kufAM1VSeXHaMmXmQMYIrc70pt9Du', NULL, 0, '2021-11-25 14:29:49', '2021-11-25 14:29:49'),
(11, 'KHARRAM SHAHZAD', 'ranjhatravel@hotmail.com', 0, NULL, '$2y$10$3ebpUlTeWkB.LJjshUqzVOgBEbdiHZQjgjt2pynL53VXBMKJhPtFO', NULL, 0, '2021-10-10 14:04:51', '2021-10-10 14:04:51'),
(13, 'CH Naeem Langrail', 'cfdtravel1@gmail.com', 0, NULL, '$2y$10$H4TYrFILZnrdnqJqZKSOOOazbTi0GTDhTN/XiFKRSz9W23QJZMuRi', NULL, 0, '2021-10-25 12:38:46', '2021-10-25 14:10:37'),
(16, 'Adeel Us Salam', 'Kingadeel07@gmail.com', 1, NULL, '$2y$10$lpcrEH2Hs8E2wwAON7U6bOu2iRd89M0SmKxGaHzJhOKVOgJ8VIzl2', NULL, 0, '2021-10-26 19:53:04', '2021-11-25 14:20:40'),
(17, 'SIKANDAR HAYAT', 'hananatravels@gmail.com', 0, NULL, '$2y$10$XEi/XsQsHt8qTWDvbPyuFuBBkLX41k3jlTRh4D3fkEMoE25N8HvhG', NULL, 0, '2021-11-13 15:53:50', '2021-11-13 15:53:50'),
(18, 'MUHAMMAD LUQMAN', 'THEHADITRAVELS@HOTMAIL.COM', 0, NULL, '$2y$10$nwn6nWGVAZDzMUiX525bkONBYJMpZjhfTrXJCL2/jtHa8bN957/BW', NULL, 0, '2021-11-18 02:01:38', '2021-11-18 02:01:38'),
(20, 'SALAM TRAVELS', 'salamtravelspk@gmail.com', 0, NULL, '$2y$10$5cYU7zpuZUAHnNqoBvs5P.1vk3RmCA4oF3za2KDTMzp7RJqdidycG', NULL, 0, '2021-11-25 13:38:19', '2021-11-25 13:38:19'),
(21, 'ABU WAQAR TRAVELS', 'abwaqartravels@gmail.com', 0, NULL, '$2y$10$oUhu20.e9.gR2hCyymeJf.nm0CD51GliBIhk5UPzzROw3a4afgjRa', NULL, 0, '2021-11-25 14:10:04', '2021-11-25 14:10:04'),
(23, 'ESHAL TRAVELS', 'multiplex.edun@yahoo.com', 0, NULL, '$2y$10$aED7S/2QRfB1ALExrrucTOuqTAoy.R8CUW3yXloyJ2/vYYcBWMLny', NULL, 0, '2021-11-25 14:56:21', '2021-11-25 14:56:21'),
(24, 'HOORAIN TRAVELS', 'zaheer.fdm@gmail.com', 0, NULL, '$2y$10$QZBkP5DRJEk2q5ob8xg9..vhUUCsZJESD1ydCMSkhBFfvCk20Bpvm', NULL, 0, '2021-11-25 14:56:23', '2021-11-25 14:56:23'),
(25, 'AHMM GKN TRAVELS', 'arasheedgjk.ahmmtravel@gmail.com', 0, NULL, '$2y$10$E6aYL2jf5t.rNE5Rwm4S2.4oT2zTxpg0l4HohRwNYnFRl.8kmxoLe', NULL, 0, '2021-11-25 14:56:23', '2021-11-25 14:56:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`(191));

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`(191),`tokenable_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabinfo`
--
ALTER TABLE `tabinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabtype`
--
ALTER TABLE `tabtype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tabtypelink`
--
ALTER TABLE `tabtypelink`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `airline`
--
ALTER TABLE `airline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabinfo`
--
ALTER TABLE `tabinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tabtypelink`
--
ALTER TABLE `tabtypelink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
