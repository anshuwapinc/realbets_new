-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2020 at 01:12 PM
-- Server version: 8.0.21
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exchange`
--

-- --------------------------------------------------------

--
-- Table structure for table `betting`
--

CREATE TABLE IF NOT EXISTS `betting` (
  `betting_id` int NOT NULL,
  `match_id` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `selection_id` int DEFAULT NULL,
  `is_back` int DEFAULT NULL,
  `place_name` varchar(150) DEFAULT NULL,
  `stake` decimal(15,2) DEFAULT NULL,
  `price_val` decimal(15,2) DEFAULT NULL,
  `p_l` decimal(15,2) DEFAULT NULL,
  `profit` decimal(15,2) DEFAULT NULL,
  `loss` decimal(15,2) DEFAULT NULL,
  `exposure_1` float NOT NULL,
  `exposure_2` int NOT NULL,
  `market_id` varchar(50) DEFAULT NULL,
  `betting_type` varchar(50) DEFAULT NULL,
  `status` enum('Open','Settled') DEFAULT 'Open',
  `market_type` int DEFAULT NULL,
  `is_fancy` int DEFAULT NULL,
  `ip_address` varchar(150) DEFAULT NULL,
  `bet_result` enum('Plus','Minus') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `betting`
--

INSERT INTO `betting` (`betting_id`, `match_id`, `user_id`, `selection_id`, `is_back`, `place_name`, `stake`, `price_val`, `p_l`, `profit`, `loss`, `exposure_1`, `exposure_2`, `market_id`, `betting_type`, `status`, `market_type`, `is_fancy`, `ip_address`, `bet_result`, `created_at`, `updated_at`) VALUES
(1, '30041249', 96, 7461, 0, 'Pakistan', '1000.00', '1.12', '120.00', '1000.00', '120.00', -120, 1000, '1.173642821', 'Match', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 10:07:47', NULL),
(2, '30041249', 96, 7461, 1, 'Pakistan', '1000.00', '1.11', '110.00', '110.00', '1000.00', -10, 0, '1.173642821', 'Match', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 10:07:54', NULL),
(3, '30041249', 96, 7461, 0, 'Pakistan', '1000.00', '1.12', '120.00', '1000.00', '120.00', -130, 1000, '1.173642821', 'Match', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 10:07:58', NULL),
(4, '28127348', 96, 16212, 1, 'Total runs by KL Rahul in IPL', '100.00', '660.00', '65900.00', '90.00', '100.00', 90, -100, '1.168634253', 'Fancy', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 10:56:36', NULL),
(5, '30069146', 96, 24684, 1, '1st Inn 11 to 20 overs Total 2 runs RCB adv', '100.00', '6.00', '500.00', '100.00', '100.00', 100, -100, '1.174343967', 'Fancy', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 10:58:29', NULL),
(6, '30069146', 96, 24684, 0, '1st Inn 11 to 20 overs Total 2 runs RCB adv', '100.00', '7.00', '600.00', '100.00', '100.00', 100, -100, '1.174343967', 'Fancy', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 10:58:37', NULL),
(7, '30069146', 96, 4164048, 0, 'Royal Challengers Bangalore', '1000.00', '1.65', '650.00', '1000.00', '650.00', -650, 1000, '1.174343967', 'Match', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 03:25:59', NULL),
(8, '30069146', 96, 24654, 1, 'A Finch Boundaries(RCB vs CSK)adv', '1000.00', '3.00', '2000.00', '1000.00', '1000.00', 1000, -1000, '1.174343967', 'Fancy', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 03:28:30', NULL),
(9, '30069148', 96, 2954281, 0, 'Mumbai Indians', '1000.00', '1.83', '830.00', '1000.00', '830.00', 1000, -830, '1.174344791', 'Match', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 07:41:22', NULL),
(10, '30069148', 96, 2954281, 0, 'Mumbai Indians', '500.00', '1.24', '120.00', '500.00', '120.00', 11496, -3349, '1.174344791', 'Match', 'Open', NULL, NULL, NULL, NULL, '2020-10-25 09:18:52', NULL),
(11, '30074801', 96, 22121561, 0, 'Delhi Capitals', '100.00', '32.00', '3100.00', '100.00', '3100.00', 100, -3100, '1.174450848', 'Match', 'Open', NULL, NULL, '157.', NULL, '2020-10-27 09:53:10', NULL),
(12, '30074804', 96, 2954281, 0, 'Mumbai Indians', '100.00', '1.84', '84.00', '100.00', '84.00', -84, 100, '1.174451023', 'Match', 'Open', NULL, NULL, '157.37.135.119', NULL, '2020-10-27 10:33:19', NULL),
(13, '30041249', 96, 7461, 1, 'Pakistan', '1000.00', '1.08', '80.00', '80.00', '1000.00', -50, -1, '1.173642821', 'Match', 'Open', NULL, NULL, '157.47.228.208', NULL, '2020-10-30 11:14:11', NULL),
(14, '30041249', 96, 7461, 1, 'Pakistan', '1000.00', '1.08', '80.00', '80.00', '1000.00', 30, -1001, '1.173642821', 'Match', 'Open', NULL, NULL, '157.47.228.208', NULL, '2020-10-30 11:14:46', NULL),
(15, '30074809', 96, 2954262, 1, 'Kings XI Punjab', '100.00', '1.99', '99.00', '99.00', '100.00', 99, -100, '1.174451616', 'Match', 'Open', NULL, NULL, '157.47.228.208', NULL, '2020-10-30 11:16:34', NULL),
(16, '30074809', 96, 2954262, 1, 'Kings XI Punjab', '10.00', '1.85', '8.50', '9.00', '10.00', 42509, -50010, '1.174451454', 'Match', 'Open', NULL, NULL, '157.47.228.208', NULL, '2020-10-30 11:17:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `block_markets`
--

CREATE TABLE IF NOT EXISTS `block_markets` (
  `block_market_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `event_id` varchar(50) DEFAULT NULL,
  `market_id` varchar(50) DEFAULT NULL,
  `event_type_id` int DEFAULT NULL,
  `type` enum('Sport','Match') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chips`
--

CREATE TABLE IF NOT EXISTS `chips` (
  `chip_id` int NOT NULL,
  `chip_name` varchar(150) DEFAULT NULL,
  `chip_value` varchar(150) DEFAULT NULL,
  `is_active` enum('Yes','No') DEFAULT 'Yes',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chips`
--

INSERT INTO `chips` (`chip_id`, `chip_name`, `chip_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1k', '1000', 'Yes', '2020-10-19 11:57:44', NULL),
(2, '2K', '2000', 'Yes', '2020-10-25 09:33:21', NULL),
(3, '5K', '5000', 'Yes', '2020-10-25 09:33:32', NULL),
(4, '10K', '10000', 'Yes', '2020-10-25 09:33:45', NULL),
(5, '50K', '50000', 'Yes', '2020-10-25 09:33:58', NULL),
(6, '100k', '100000', 'Yes', '2020-10-25 10:03:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `default_general_setting`
--

CREATE TABLE IF NOT EXISTS `default_general_setting` (
  `setting_id` int NOT NULL,
  `type` enum('Sport','Extra') DEFAULT NULL,
  `sport_id` int DEFAULT NULL,
  `sport_name` varchar(150) DEFAULT NULL,
  `min_stake` decimal(15,2) DEFAULT NULL,
  `max_stake` decimal(15,2) DEFAULT NULL,
  `max_profit` decimal(15,2) DEFAULT NULL,
  `max_loss` decimal(15,2) DEFAULT NULL,
  `bet_delay` float DEFAULT NULL,
  `pre_inplay_profit` decimal(15,2) DEFAULT NULL,
  `pre_inplay_stake` decimal(15,2) DEFAULT NULL,
  `min_odds` decimal(15,2) DEFAULT NULL,
  `max_odds` decimal(15,2) DEFAULT NULL,
  `unmatch_bet` enum('Yes','No') DEFAULT 'Yes',
  `lock_bet` enum('Yes','No') DEFAULT 'No',
  `is_unmatch_allowed` enum('Yes','No') DEFAULT 'No',
  `is_odds_allowed` enum('Yes','No') DEFAULT 'No',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `default_general_setting`
--

INSERT INTO `default_general_setting` (`setting_id`, `type`, `sport_id`, `sport_name`, `min_stake`, `max_stake`, `max_profit`, `max_loss`, `bet_delay`, `pre_inplay_profit`, `pre_inplay_stake`, `min_odds`, `max_odds`, `unmatch_bet`, `lock_bet`, `is_unmatch_allowed`, `is_odds_allowed`, `created_at`, `updated_at`) VALUES
(1, 'Sport', 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', 'Yes', 'Yes', '2020-09-19 17:29:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `e_id` int NOT NULL,
  `event_id` int NOT NULL,
  `sport_id` int DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `time_status` varchar(50) DEFAULT NULL,
  `league` varchar(150) DEFAULT NULL,
  `home` varchar(150) DEFAULT NULL,
  `home_back_1` decimal(15,2) DEFAULT NULL,
  `home_back_2` decimal(15,2) DEFAULT NULL,
  `home_back_3` decimal(15,2) DEFAULT NULL,
  `home_lay_1` decimal(15,2) DEFAULT NULL,
  `home_lay_2` decimal(15,2) DEFAULT NULL,
  `home_lay_3` decimal(15,2) DEFAULT NULL,
  `away` varchar(150) DEFAULT NULL,
  `away_back_1` decimal(15,2) DEFAULT NULL,
  `away_back_2` decimal(15,2) DEFAULT NULL,
  `away_back_3` decimal(15,2) DEFAULT NULL,
  `away_lay_1` decimal(15,2) DEFAULT NULL,
  `away_lay_2` decimal(15,2) DEFAULT NULL,
  `away_lay_3` decimal(15,2) DEFAULT NULL,
  `is_active` enum('Yes','No') DEFAULT 'Yes',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_exchange_entrys`
--

CREATE TABLE IF NOT EXISTS `event_exchange_entrys` (
  `exchange_event_entry_id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `exchange_response` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE IF NOT EXISTS `event_types` (
  `event_type_id` int NOT NULL,
  `event_type` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `market_count` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`event_type_id`, `event_type`, `name`, `market_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'Soccer', 2492, '2020-10-23 06:21:22', '2020-11-01 06:30:01'),
(2, 2, 'Tennis', 5578, '2020-10-23 06:21:22', '2020-11-01 06:30:01'),
(3, 4, 'Cricket', 22, '2020-10-23 06:21:22', '2020-11-01 06:30:01'),
(4, 7, 'Horse Racing', 831, '2020-10-23 06:21:22', '2020-11-01 06:30:01'),
(5, 4339, 'Greyhound Racing', 298, '2020-10-23 06:21:22', '2020-11-01 06:30:01');

-- --------------------------------------------------------

--
-- Table structure for table `fancyEntrys`
--

CREATE TABLE IF NOT EXISTS `fancyEntrys` (
  `fancy_id` int NOT NULL,
  `b1` decimal(10,2) DEFAULT NULL,
  `booklink` int DEFAULT NULL,
  `bs1` decimal(10,2) DEFAULT NULL,
  `divRules` int DEFAULT NULL,
  `gameStatus` varchar(150) DEFAULT NULL,
  `gameType` varchar(50) DEFAULT NULL,
  `gameValid` int DEFAULT NULL,
  `l1` decimal(10,2) DEFAULT NULL,
  `ls1` decimal(10,2) DEFAULT NULL,
  `marketId` varchar(150) DEFAULT NULL,
  `maxbet` decimal(10,2) DEFAULT NULL,
  `minBet` decimal(10,2) DEFAULT NULL,
  `nation` text,
  `profileview` int DEFAULT NULL,
  `remarks` text,
  `sectionId` int DEFAULT NULL,
  `spin` int DEFAULT NULL,
  `srNo` int DEFAULT NULL,
  `updateTime` varchar(50) DEFAULT NULL,
  `viewbook` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fancy_data`
--

CREATE TABLE IF NOT EXISTS `fancy_data` (
  `fancy_id` int NOT NULL,
  `market_id` varchar(150) DEFAULT NULL,
  `response` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `favorite_events`
--

CREATE TABLE IF NOT EXISTS `favorite_events` (
  `favourite_event_id` int NOT NULL,
  `event_id` varchar(150) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `favorite_events`
--

INSERT INTO `favorite_events` (`favourite_event_id`, `event_id`, `user_id`, `created_at`, `updated_at`) VALUES
(6, '30074806', 95, '2020-10-29 07:49:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE IF NOT EXISTS `ledger` (
  `ledger_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `betting_id` int NOT NULL,
  `selection_id` varchar(50) NOT NULL,
  `remarks` text,
  `transaction_type` enum('Credit','Debit','Hold','Refund') DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `type` enum('Free Chip','Betting','Profit Loss','Settlement') DEFAULT 'Free Chip',
  `is_delete` enum('Yes','No') NOT NULL DEFAULT 'No',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`ledger_id`, `user_id`, `betting_id`, `selection_id`, `remarks`, `transaction_type`, `amount`, `balance`, `type`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 30, 0, '', 'Opening Balance 500000', 'Credit', '50000.00', '50000.00', 'Free Chip', 'No', NULL, NULL),
(197, 92, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '500.00', '500.00', 'Free Chip', 'No', '2020-10-25 09:37:27', NULL),
(198, 30, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '500.00', '49500.00', 'Free Chip', 'No', '2020-10-25 09:37:27', NULL),
(199, 92, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '500.00', '1000.00', 'Free Chip', 'No', '2020-10-25 09:37:52', NULL),
(200, 30, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '500.00', '49000.00', 'Free Chip', 'No', '2020-10-25 09:37:52', NULL),
(201, 92, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '40000.00', '41000.00', 'Free Chip', 'No', '2020-10-25 10:04:53', NULL),
(202, 30, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '40000.00', '9000.00', 'Free Chip', 'No', '2020-10-25 10:04:53', NULL),
(203, 93, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '40000.00', '40000.00', 'Free Chip', 'No', '2020-10-25 10:05:09', NULL),
(204, 92, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '40000.00', '1000.00', 'Free Chip', 'No', '2020-10-25 10:05:09', NULL),
(205, 94, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '40000.00', '40000.00', 'Free Chip', 'No', '2020-10-25 10:05:24', NULL),
(206, 93, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '40000.00', '0.00', 'Free Chip', 'No', '2020-10-25 10:05:24', NULL),
(207, 95, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '40000.00', '40000.00', 'Free Chip', 'No', '2020-10-25 10:05:45', NULL),
(208, 94, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '40000.00', '0.00', 'Free Chip', 'No', '2020-10-25 10:05:45', NULL),
(209, 96, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '10000.00', '10000.00', 'Free Chip', 'No', '2020-10-25 10:06:06', NULL),
(210, 95, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '10000.00', '30000.00', 'Free Chip', 'No', '2020-10-25 10:06:06', NULL),
(211, 96, 0, '', 'Pakistan Khai', 'Hold', '1000.00', '8880.00', 'Betting', 'No', '2020-10-25 10:07:47', NULL),
(212, 96, 0, '', 'Pakistan Lagai', 'Hold', '1000.00', '8990.00', 'Betting', 'No', '2020-10-25 10:07:54', NULL),
(213, 96, 0, '', 'Pakistan Khai', 'Hold', '1000.00', '8870.00', 'Betting', 'No', '2020-10-25 10:07:58', NULL),
(214, 96, 0, '', 'Total runs by KL Rahul in IPL Lagai', 'Hold', '100.00', '9670.00', 'Betting', 'No', '2020-10-25 10:56:36', NULL),
(215, 96, 0, '', '1st Inn 11 to 20 overs Total 2 runs RCB adv Lagai', 'Hold', '100.00', '9570.00', 'Betting', 'No', '2020-10-25 10:58:29', NULL),
(216, 96, 0, '', '1st Inn 11 to 20 overs Total 2 runs RCB adv Khai', 'Hold', '100.00', '9470.00', 'Betting', 'No', '2020-10-25 10:58:37', NULL),
(217, 96, 0, '', 'Royal Challengers Bangalore Khai', 'Hold', '1000.00', '7920.00', 'Betting', 'No', '2020-10-25 03:25:59', NULL),
(218, 96, 0, '', 'A Finch Boundaries(RCB vs CSK)adv Lagai', 'Hold', '1000.00', '6920.00', 'Betting', 'No', '2020-10-25 03:28:30', NULL),
(219, 96, 0, '', 'Mumbai Indians Khai', 'Hold', '1000.00', '6090.00', 'Betting', 'No', '2020-10-25 07:41:22', NULL),
(220, 92, 0, '', 'Free Chip Withdrawl By Super admin', 'Debit', '500.00', '500.00', 'Free Chip', 'No', '2020-10-25 07:43:03', NULL),
(221, 30, 0, '', 'Free Chip Withdrawl From Super admin', 'Credit', '500.00', '9500.00', 'Free Chip', 'No', '2020-10-25 07:43:03', NULL),
(222, 92, 0, '', 'Free Chip Withdrawl By Super admin', 'Debit', '500.00', '0.00', 'Free Chip', 'No', '2020-10-25 07:43:04', NULL),
(223, 30, 0, '', 'Free Chip Withdrawl From Super admin', 'Credit', '500.00', '10000.00', 'Free Chip', 'No', '2020-10-25 07:43:04', NULL),
(224, 92, 0, '', 'Free Chip Deposit By Super admin', 'Credit', '1000.00', '1000.00', 'Free Chip', 'No', '2020-10-25 07:44:01', NULL),
(225, 30, 0, '', 'Free Chip Deposit To Super admin', 'Debit', '1000.00', '9000.00', 'Free Chip', 'No', '2020-10-25 07:44:01', NULL),
(226, 96, 0, '', 'Mumbai Indians Khai', 'Hold', '500.00', '4071.00', 'Betting', 'No', '2020-10-25 09:18:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `list_competitions`
--

CREATE TABLE IF NOT EXISTS `list_competitions` (
  `list_competition_id` int NOT NULL,
  `event_type` int NOT NULL,
  `competition_id` int NOT NULL,
  `competition_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `market_count` int NOT NULL,
  `competition_region` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `list_competitions`
--

INSERT INTO `list_competitions` (`list_competition_id`, `event_type`, `competition_id`, `competition_name`, `market_count`, `competition_region`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 194215, 'Turkish Super League', 41, 'TUR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(2, 1, 105, 'Scottish Premiership', 2, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(3, 1, 12801, 'Spanish Copa del Rey', 1, 'ESP', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(4, 1, 2608550, 'Specials', 1, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(5, 1, 12206708, 'Scottish FA Cup', 1, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(6, 1, 81, 'Italian Serie A', 3, 'ITA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(7, 1, 2005, 'UEFA Europa League', 10, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(8, 1, 23, 'Danish Superliga', 1, 'DNK', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(9, 1, 9404054, 'Dutch Eredivisie', 1, 'NLD', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(10, 1, 30558, 'English FA Cup', 1, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(11, 1, 35, 'English League 1', 4, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(12, 1, 99, 'Portuguese Primeira Liga', 1, 'PRT', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(13, 1, 228, 'UEFA Champions League', 7, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(14, 1, 37, 'English League 2', 4, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(15, 1, 12214429, 'Italian Cup', 3, 'ITA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(16, 1, 12147472, 'CONMEBOL Copa America', 1, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(17, 1, 12147796, 'CONMEBOL Copa Libertadores', 1, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(18, 1, 7129730, 'English Championship', 6, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(19, 1, 11458113, 'German Cup', 1, 'DEU', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(20, 1, 801976, 'Egyptian Premier', 200, 'EGY', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(21, 1, 117, 'Spanish La Liga', 3, 'ESP', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(22, 1, 55, 'French Ligue 1', 1, 'FRA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(23, 1, 11997262, 'FIFA World Cup 2022', 1, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(24, 1, 59, 'German Bundesliga', 2, 'DEU', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(25, 1, 10932509, 'English Premier League', 17, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(26, 1, 11997260, 'UEFA Euro 2020', 1, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(27, 1, 129, 'Swedish Allsvenskan', 1, 'SWE', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(28, 1, 12202373, 'Swedish Superettan', 5, 'SWE', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(29, 1, 61, 'German Bundesliga 2', 242, 'DEU', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(30, 1, 12216175, 'Estonian Premier League', 50, 'EST', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(31, 1, 25, 'Danish 1st Division', 2, 'DNK', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(32, 1, 17, 'Croatian 1 HNL', 10, 'HRV', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(33, 1, 101, 'Russian Premier League', 2, 'RUS', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(34, 1, 97, 'Polish Ekstraklasa', 220, 'POL', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(35, 1, 10479956, 'Austrian Bundesliga', 12, 'AUT', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(36, 1, 4905, 'Romanian Liga I', 1, 'ROU', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(37, 1, 15, 'Bulgarian A League', 2, 'BGR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(38, 1, 9, 'Austrian Erste Liga', 16, 'AUT', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(39, 1, 12204313, 'Spanish Segunda Division', 9, 'ESP', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(40, 1, 11068551, 'Norwegian Eliteserien', 6, 'NOR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(41, 1, 12199689, 'Italian Serie B', 2, 'ITA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(42, 1, 133, 'Swiss Super League', 5, 'CHE', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(43, 1, 135, 'Swiss Challenge League', 79, 'CHE', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(44, 1, 141, 'US Major League Soccer', 7, 'USA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(45, 1, 89, 'Japanese J League', 288, 'JPN', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(46, 1, 862579, 'Romanian Liga II', 29, 'ROU', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(47, 1, 879931, 'Chinese Super League', 25, 'CHN', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(48, 1, 12209546, 'Norwegian 1st Division', 216, 'NOR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(49, 1, 12203971, 'Irish Premier Division', 102, 'IRL', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(50, 1, 13, 'Brazilian Serie A', 105, 'BRA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(51, 1, 321319, 'Brazilian Serie B', 224, 'BRA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(52, 1, 89979, 'Belgian First Division A', 72, 'BEL', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(53, 1, 11, 'Dutch Eerste Divisie', 4, 'NLD', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(54, 1, 2134, 'English Football League Cup', 4, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(55, 1, 11984200, 'UEFA Nations League', 4, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(56, 1, 9513, 'Portuguese Segunda Liga', 100, 'PRT', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(57, 1, 744098, 'Chilean Primera Division', 25, 'CHL', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(58, 1, 856134, 'Colombian Primera B', 150, 'COL', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(59, 1, 844197, 'Colombian Primera A', 65, 'COL', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(60, 2, 12271175, 'Olympics 2020', 2, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(61, 2, 12283156, 'Australian Open 2021', 2, 'AUS', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(62, 2, 12290431, 'Wimbledon 2021', 2, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(63, 2, 12297913, 'Roland Garros 2020', 2752, 'FRA', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(64, 2, 12301860, 'Hamburg Challenger 2020', 720, 'DEU', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(65, 2, 12301840, 'Marbella Challenger 2020', 591, 'ESP', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(66, 2, 12301880, 'ATP Vienna 2020', 817, 'AUT', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(67, 2, 12301967, 'ATP Nur-Sultan 2020', 646, 'KAZ', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(68, 4, 10693181, 'Pakistan Super League', 43, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(69, 4, 12252709, 'ICC World Test Championship', 1, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(70, 4, 11678489, 'ICC World Twenty20', 1, 'AUS', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(71, 4, 9962116, 'One Day Internationals', 28, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(72, 4, 9992899, 'International Twenty20 Matches', 17, 'Internatio', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(73, 4, 101480, 'Indian Premier League', 52, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(74, 4, 10529093, 'WBBL', 1, 'AUS', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(75, 4, 11569227, 'Sheffield Shield', 3, 'AUS', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(76, 4, 10328858, 'Twenty20 Big Bash', 1, 'AUS', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(77, 4, 12301543, 'Womens IPL', 3, 'GBR', 'Yes', '2020-10-29 10:57:26', '2020-11-01 06:30:01'),
(78, 1, 11086347, 'English National League', 1, 'GBR', 'Yes', '2020-10-31 06:30:02', '2020-11-01 06:30:01'),
(79, 1, 103, 'Serbian Super League', 16, 'SRB', 'Yes', '2020-10-31 06:30:02', '2020-11-01 06:30:01'),
(80, 1, 57, 'French Ligue 2', 10, 'FRA', 'Yes', '2020-10-31 06:30:02', '2020-11-01 06:30:01');

-- --------------------------------------------------------

--
-- Table structure for table `list_events`
--

CREATE TABLE IF NOT EXISTS `list_events` (
  `list_event_id` int NOT NULL,
  `competition_id` int NOT NULL,
  `event_type` int NOT NULL,
  `event_id` int NOT NULL,
  `event_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `winner_selection_id` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `winner_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `open_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `market_count` int NOT NULL,
  `scoreboard_id` int NOT NULL,
  `selections` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `liability_type` int NOT NULL,
  `undeclared_markets` int NOT NULL,
  `status` enum('Open','Closed') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Open',
  `is_active` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `list_events`
--

INSERT INTO `list_events` (`list_event_id`, `competition_id`, `event_type`, `event_id`, `event_name`, `country_code`, `winner_selection_id`, `winner_name`, `timezone`, `open_date`, `market_count`, `scoreboard_id`, `selections`, `liability_type`, `undeclared_markets`, `status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2005, 1, 30051332, 'Crvena Zvezda v Slovan Liberec', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 58, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(2, 2005, 1, 30081434, 'Lille v Celtic', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(3, 2005, 1, 30081439, 'Feyenoord v Wolfsberger AC', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 68, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(4, 2005, 1, 30081437, 'Zorya v Braga', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(5, 2005, 1, 30051092, 'AC Milan v Sparta Prague', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 58, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(6, 2005, 1, 30081450, 'AEK Athens v Leicester', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(7, 2005, 1, 30081442, 'Sivasspor v Maccabi Tel Aviv', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(8, 2005, 1, 30081441, 'Antwerp v Tottenham', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(9, 2005, 1, 30081440, 'Qarabag FK v Villarreal', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(10, 2005, 1, 30081447, 'CSKA Moscow v Dinamo Zagreb', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(11, 2005, 1, 30081446, 'Lask Linz v Ludogorets', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 68, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(12, 2005, 1, 30081445, 'Gent v Hoffenheim', '', NULL, NULL, 'GMT', '2020-10-29T17:55:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(13, 2005, 1, 30081435, 'Az Alkmaar v Rijeka', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(14, 2005, 1, 30081433, 'Granada v PAOK', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(15, 2005, 1, 30081438, 'Nice v Hapoel Beer Sheva', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(16, 2005, 1, 30081436, 'CFR Cluj v Young Boys', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 68, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(17, 2005, 1, 30050967, 'Rangers v Lech Poznan', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 58, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(18, 2005, 1, 30081451, 'Roma v CSKA Sofia', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(19, 2005, 1, 30081449, 'Arsenal v Dundalk', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(20, 2005, 1, 30081448, 'Omonia v PSV', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(21, 2005, 1, 30081452, 'Sociedad v Napoli', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(22, 2005, 1, 30081443, 'Benfica v Standard', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(23, 2005, 1, 30081444, 'Molde v Rapid Vienna', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(24, 2005, 1, 30050929, 'Slavia Prague v Leverkusen', '', NULL, NULL, 'GMT', '2020-10-29T20:00:00.000Z', 58, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(25, 7129730, 1, 30086678, 'Coventry v Reading', 'GB', NULL, NULL, 'GMT', '2020-10-30T19:45:00.000Z', 57, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-31 06:30:02'),
(26, 801976, 1, 30092254, 'Aswan FC v Al Ittihad (EGY)', 'EG', NULL, NULL, 'GMT', '2020-10-29T15:30:00.000Z', 15, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(27, 801976, 1, 30092258, 'El Entag El Harby v Misr El Makasa', 'EG', NULL, NULL, 'GMT', '2020-10-29T18:00:00.000Z', 15, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(28, 12204313, 1, 30085437, 'Alcorcon v Sporting Gijon', 'ES', NULL, NULL, 'GMT', '2020-10-29T15:30:00.000Z', 30, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(29, 12204313, 1, 30085344, 'Tenerife v Lugo', 'ES', NULL, NULL, 'GMT', '2020-10-29T18:00:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(30, 12204313, 1, 30085287, 'Mirandes v Zaragoza', 'ES', NULL, NULL, 'GMT', '2020-10-29T18:00:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(31, 12204313, 1, 30085301, 'Mallorca v Malaga', 'ES', NULL, NULL, 'GMT', '2020-10-29T18:00:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(32, 12204313, 1, 30085337, 'Rayo Vallecano v Fuenlabrada', 'ES', NULL, NULL, 'GMT', '2020-10-29T20:30:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(33, 12204313, 1, 30089971, 'Sabadell v Leganes', 'ES', NULL, NULL, 'GMT', '2020-10-29T20:30:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(34, 12301880, 2, 30091994, 'Garin v Thiem', 'AT', NULL, NULL, 'UTC', '2020-10-29T16:30:00.000Z', 10, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(35, 12301880, 2, 30093675, 'Tsitsipas v Dimitrov', 'AT', NULL, NULL, 'UTC', '2020-10-29T18:30:00.000Z', 10, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(36, 12301967, 2, 30092803, 'Gerasimov v Tiafoe', 'KZ', NULL, NULL, 'UTC', '2020-10-30T04:00:00.000Z', 10, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(37, 12301967, 2, 30092798, 'Paul v Millman', 'KZ', NULL, NULL, 'UTC', '2020-10-30T04:00:00.000Z', 10, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:02'),
(38, 9962116, 4, 30041249, 'Pakistan v Zimbabwe', 'GB', NULL, NULL, 'GMT', '2020-10-30T05:00:00.000Z', 27, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:03'),
(39, 101480, 4, 30074806, 'Chennai Super Kings v Kolkata Knight Riders', 'GB', NULL, NULL, 'GMT', '2020-10-29T14:00:00.000Z', 26, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '0000-00-00 00:00:00'),
(40, 101480, 4, 28127348, 'Indian Premier League', 'GB', NULL, NULL, 'GMT', '2018-04-09T10:23:45.000Z', 5, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-31 06:30:02'),
(41, 101480, 4, 30074809, 'Kings XI Punjab v Rajasthan Royals', 'GB', NULL, NULL, 'GMT', '2020-10-30T14:00:00.000Z', 26, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-30 06:30:03'),
(42, 101480, 4, 30082203, 'Delhi Capitals v Mumbai Indians', 'GB', NULL, NULL, 'GMT', '2020-10-31T10:00:00.000Z', 26, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-29 10:59:20', '2020-10-31 06:30:02'),
(43, 99, 1, 30088804, 'Pacos Ferreira v Porto', 'PT', NULL, NULL, 'GMT', '2020-10-30T20:30:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(44, 117, 1, 30072239, 'Eibar v Cadiz', 'ES', NULL, NULL, 'GMT', '2020-10-30T20:00:00.000Z', 63, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(45, 59, 1, 30073998, 'Schalke 04 v Stuttgart', 'DE', NULL, NULL, 'GMT', '2020-10-30T19:30:00.000Z', 69, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(46, 10932509, 1, 30072813, 'Wolves v Crystal Palace', 'GB', NULL, NULL, 'GMT', '2020-10-30T20:00:00.000Z', 69, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(47, 25, 1, 30088357, 'Esbjerg v Fredericia', 'DK', NULL, NULL, 'GMT', '2020-10-31T12:00:00.000Z', 24, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(48, 879931, 1, 30088844, 'Tianjin Teda v Dalian Yifang', 'CN', NULL, NULL, 'GMT', '2020-10-31T07:30:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(49, 89979, 1, 30089400, 'Genk v Eupen', 'BE', NULL, NULL, 'GMT', '2020-10-30T19:45:00.000Z', 30, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(50, 12301880, 2, 30096111, 'Dimitrov v Evans', 'AT', NULL, NULL, 'UTC', '2020-10-30T18:30:00.000Z', 10, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(51, 101480, 4, 30082207, 'Royal Challengers Bangalore v Sunrisers Hyderabad', 'GB', NULL, NULL, 'GMT', '2020-10-31T14:00:00.000Z', 26, 0, NULL, 0, 2, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(52, 10529093, 4, 30089989, 'Sydney Thunder WBBL v Adelaide Strikers WBBL', 'AU', NULL, NULL, 'GMT', '2020-10-31T01:15:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(53, 10529093, 4, 30089990, 'Melbourne Renegades WBBL v Perth Scorchers WBBL', 'AU', NULL, NULL, 'GMT', '2020-10-31T03:30:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(54, 10529093, 4, 30089993, 'Brisbane Heat WBBL v Hobart Hurricanes WBBL', 'AU', NULL, NULL, 'GMT', '2020-10-31T04:40:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(55, 10529093, 4, 30089995, 'Sydney Sixers WBBL v Melbourne Stars WBBL', 'AU', NULL, NULL, 'GMT', '2020-10-31T08:05:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-10-31 06:30:02', '0000-00-00 00:00:00'),
(56, 81, 1, 30077232, 'Bologna v Cagliari', 'IT', NULL, NULL, 'GMT', '2020-10-31T19:45:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(57, 9404054, 1, 30074908, 'FC Groningen v VVV Venlo', 'NL', NULL, NULL, 'GMT', '2020-10-31T19:00:00.000Z', 49, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(58, 9404054, 1, 30074901, 'Ajax v Fortuna Sittard', 'NL', NULL, NULL, 'GMT', '2020-10-31T19:00:00.000Z', 49, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(59, 99, 1, 30088842, 'Maritimo v CD Nacional Funchal', 'PT', NULL, NULL, 'GMT', '2020-10-31T20:30:00.000Z', 30, 0, NULL, 0, 3, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(60, 117, 1, 30072246, 'Alaves v Barcelona', 'ES', NULL, NULL, 'GMT', '2020-10-31T20:00:00.000Z', 69, 0, NULL, 0, 3, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(61, 55, 1, 30078958, 'Nantes v Paris St-G', 'FR', NULL, NULL, 'GMT', '2020-10-31T20:00:00.000Z', 49, 0, NULL, 0, 3, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(62, 4905, 1, 30087361, 'Hermannstadt v Universitatea Craiova', 'RO', NULL, NULL, 'GMT', '2020-10-31T19:45:00.000Z', 30, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:01', '0000-00-00 00:00:00'),
(63, 101480, 4, 30082209, 'Chennai Super Kings v Kings XI Punjab', 'GB', NULL, NULL, 'GMT', '2020-11-01T10:00:00.000Z', 26, 0, NULL, 0, 2, 'Open', 'Yes', '2020-11-01 06:30:02', '0000-00-00 00:00:00'),
(64, 101480, 4, 30082210, 'Kolkata Knight Riders v Rajasthan Royals', 'GB', NULL, NULL, 'GMT', '2020-11-01T14:00:00.000Z', 26, 0, NULL, 0, 2, 'Open', 'Yes', '2020-11-01 06:30:02', '0000-00-00 00:00:00'),
(65, 10529093, 4, 30092046, 'Adelaide Strikers WBBL v Perth Scorchers WBBL', 'AU', NULL, NULL, 'GMT', '2020-10-31T22:30:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:02', '0000-00-00 00:00:00'),
(66, 10529093, 4, 30092052, 'Sydney Thunder WBBL v Brisbane Heat WBBL', 'AU', NULL, NULL, 'GMT', '2020-10-31T23:20:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:02', '0000-00-00 00:00:00'),
(67, 10529093, 4, 30092053, 'Melbourne Renegades WBBL v Sydney Sixers WBBL', 'AU', NULL, NULL, 'GMT', '2020-11-01T02:45:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:02', '0000-00-00 00:00:00'),
(68, 10529093, 4, 30092054, 'Hobart Hurricanes WBBL v Melbourne Stars WBBL', 'AU', NULL, NULL, 'GMT', '2020-11-01T03:30:00.000Z', 18, 0, NULL, 0, 1, 'Open', 'Yes', '2020-11-01 06:30:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `market_book_odds`
--

CREATE TABLE IF NOT EXISTS `market_book_odds` (
  `market_book_odd_id` int NOT NULL,
  `market_id` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_market_data_delayed` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bet_delay` int NOT NULL,
  `bsp_reconciled` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `complete` int NOT NULL,
  `inplay` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number_of_winners` int NOT NULL,
  `number_of_runners` int NOT NULL,
  `number_of_active_runners` int NOT NULL,
  `last_match_time` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `total_matched` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `total_available` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cross_matching` int NOT NULL,
  `runners_voidable` int NOT NULL,
  `version` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `market_book_odds`
--

INSERT INTO `market_book_odds` (`market_book_odd_id`, `market_id`, `is_market_data_delayed`, `status`, `bet_delay`, `bsp_reconciled`, `complete`, `inplay`, `number_of_winners`, `number_of_runners`, `number_of_active_runners`, `last_match_time`, `total_matched`, `total_available`, `cross_matching`, `runners_voidable`, `version`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1.168634253', '0', 'OPEN', 0, '0', 0, '0', 1, 8, 7, '2020-11-01T13:11:36.041Z', '938100.6', '76385.66', 0, 0, '3443791959', 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(2, '1.174677254', '0', 'OPEN', 5, '0', 1, '1', 1, 2, 2, '2020-11-01T13:12:14.366Z', '36057434.52', '1047861.87', 1, 0, '3445596011', 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(3, '1.174677622', '0', 'OPEN', 0, '0', 1, '0', 1, 2, 2, '2020-11-01T13:12:13.084Z', '72625.67', '427245.2', 1, 0, '3431595588', 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(4, '1.174677784', '0', 'OPEN', 0, '0', 1, '0', 1, 2, 2, '2020-11-01T13:12:11.678Z', '3512.07', '9989.36', 1, 0, '3438703411', 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `market_book_odds_fancy`
--

CREATE TABLE IF NOT EXISTS `market_book_odds_fancy` (
  `id` int NOT NULL,
  `match_id` int NOT NULL,
  `selection_id` int DEFAULT NULL,
  `runner_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lay_price1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `lay_size1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_price1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `back_size1` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `game_status` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mark_status` int DEFAULT NULL,
  `result` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1034 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `market_book_odds_fancy`
--

INSERT INTO `market_book_odds_fancy` (`id`, `match_id`, `selection_id`, `runner_name`, `lay_price1`, `lay_size1`, `back_price1`, `back_size1`, `game_status`, `mark_status`, `result`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 28127348, 15637, 'Total  1st 6 over run in Abu Dhabi', '880', '100', '883', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(2, 28127348, 16196, 'Total 1st wkt partnership by SRH in IPL', '639', '110', '639', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(3, 28127348, 16198, 'Total runs by D Warner in IPL', '492', '100', '492', '80', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(4, 28127348, 16237, 'Total Extras by KKR in IPL', '96', '100', '97', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(5, 28127348, 16238, 'Total Wides by KKR in IPL', '55', '100', '56', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(6, 28127348, 16216, 'Total wickets by M Shami in IPL', '21', '100', '22', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(7, 28127348, 16219, 'Total 6 over run of RR in IPL', '654', '100', '656', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(8, 28127348, 15613, 'Total match 1st over run of Sharjah', '67', '100', '69', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(9, 28127348, 16177, 'Total 6''s by RCB in IPL', '73', '100', '75', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(10, 28127348, 15628, 'Total 6''s in Abu Dhabi', '203', '100', '205', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(11, 28127348, 16160, 'Total match 1st over run of CSK in IPL', '46', '100', '47', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(12, 28127348, 15644, 'Total Wides in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(13, 28127348, 16148, 'Total 6 over run of MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(14, 28127348, 16182, 'Total runs by V Kohli in IPL', '488', '110', '488', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(15, 28127348, 15640, 'Total 4''s in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(16, 28127348, 16222, 'Total Wicket lost by RR in IPL', '87', '100', '88', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(17, 28127348, 15589, 'Total 4''s in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(18, 28127348, 15593, 'Total Wickets in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(19, 28127348, 16201, 'Total wickets by Rashid Khan in IPL', '20', '100', '21', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(20, 28127348, 16185, 'Total wickets by Y Chahal in IPL', '21', '100', '22', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(21, 28127348, 15587, 'Highest run scorer in IPL(Orange cap)', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(22, 28127348, 15596, 'Total Caught out in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(23, 28127348, 15626, 'Total match 1st over run of Abu Dhabi', '123', '100', '125', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(24, 28127348, 16195, 'Total Caught out of SRH in IPL', '53', '100', '54', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(25, 28127348, 16235, 'Total 6''s by KKR in IPL', '79', '100', '80', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(26, 28127348, 15617, 'Total Extras in Sharjah', '191', '100', '193', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(27, 28127348, 15595, 'Total Extras in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(28, 28127348, 16204, 'Total 6 over run of KXIP in IPL', '669', '100', '671', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(29, 28127348, 15621, 'Total Caught out in Sharjah', '93', '100', '95', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(30, 28127348, 15591, 'Total 50''s in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(31, 28127348, 15615, 'Total 6''s in Sharjah', '238', '100', '240', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(32, 28127348, 16167, 'Total Caught out of CSK in IPL', '44', '100', '45', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(33, 28127348, 16149, 'Total 4''s by MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(34, 28127348, 15618, 'Total Wides in Sharjah', '113', '100', '115', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(35, 28127348, 15649, 'Total LBW in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(36, 28127348, 16176, 'Total 4''s by RCB in IPL', '172', '100', '174', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(37, 28127348, 16189, 'Total 6 over run of SRH in IPL', '688', '100', '691', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(38, 28127348, 15648, 'Total Bowled in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(39, 28127348, 16162, 'Total 4''s by CSK in IPL', '189', '100', '190', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(40, 28127348, 16161, 'Total 6 over run of CSK in IPL', '586', '100', '588', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(41, 28127348, 16146, 'Total 4''s in Abu Dhabi.', '568', '100', '570', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(42, 28127348, 16154, 'Total Caught out of MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(43, 28127348, 16150, 'Total 6''s by MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(44, 28127348, 16230, 'Total wickets by J Archer in IPL', '21', '125', '21', '75', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(45, 28127348, 16194, 'Total Wides by SRH in IPL', '72', '100', '73', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(46, 28127348, 15647, 'Total Caught out in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(47, 28127348, 16175, 'Total 6 over run of RCB in IPL', '668', '100', '671', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(48, 28127348, 15632, 'Total 50''s in Abu Dhabi', '35', '100', '36', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(49, 28127348, 16158, 'Total wickets by J Bumrah in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(50, 28127348, 16147, 'Total match 1st over run of MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(51, 28127348, 16164, 'Total Wicket lost by CSK in IPL', '72', '100', '73', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(52, 28127348, 16153, 'Total Wides by MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(53, 28127348, 16211, 'Total 1st wkt partnership by KXIP in IPL', '734', '110', '734', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(54, 28127348, 16234, 'Total 4''s by KKR in IPL', '194', '100', '195', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(55, 28127348, 16218, 'Total match 1st over run of RR in IPL', '102', '100', '103', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(56, 28127348, 16210, 'Total Caught out of KXIP in IPL', '44', '100', '45', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(57, 28127348, 15616, 'Total Wickets in Sharjah', '134', '100', '136', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(58, 28127348, 16168, 'Total 1st wkt partnership by CSK in IPL', '460', '110', '460', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(59, 28127348, 16236, 'Total Wicket lost by KKR in IPL', '95', '100', '96', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(60, 28127348, 15598, 'Total LBW in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(61, 28127348, 15580, 'Total match 1st over run in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(62, 28127348, 15650, 'Total  1st 6 over run in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(63, 28127348, 16220, 'Total 4''s by RR in IPL', '173', '100', '174', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(64, 28127348, 15639, 'Total match 1st over run of Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(65, 28127348, 15624, 'Total  1st 6 over run in Sharjah', '585', '100', '589', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(66, 28127348, 15631, 'Total Wides in Abu Dhabi', '148', '100', '150', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(67, 28127348, 16191, 'Total 6''s by SRH in IPL', '75', '100', '77', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(68, 28127348, 16172, 'Total wickets by D Chahar in IPL', '13', '100', '14', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(69, 28127348, 16405, 'Total Wickets in Dubai.', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(70, 28127348, 16225, 'Total Caught out of RR in IPL', '63', '100', '64', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(71, 28127348, 16226, 'Total 1st wkt partnership by RR in IPL', '336', '110', '336', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(72, 28127348, 15588, 'Highest wicket in  IPL(PURPLE CAP)', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(73, 28127348, 15590, 'Total 6''s in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(74, 28127348, 15635, 'Total Bowled in Abu Dhabi', '33', '100', '34', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(75, 28127348, 16206, 'Total 6''s by KXIP in IPL', '99', '100', '100', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(76, 28127348, 15619, 'Total 50''s in Sharjah', '25', '100', '26', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(77, 28127348, 16165, 'Total Extras by CSK in IPL', '89', '100', '90', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(78, 28127348, 15634, 'Total Caught out in Abu Dhabi', '151', '100', '153', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(79, 28127348, 16203, 'Total match 1st over run of KXIP in IPL', '78', '100', '79', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(80, 28127348, 15643, 'Total Extras in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(81, 28127348, 16178, 'Total Wicket lost by RCB in IPL', '69', '100', '70', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(82, 28127348, 15594, 'Total Wides in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(83, 28127348, 16163, 'Total 6''s by CSK in IPL', '77', '100', '78', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(84, 28127348, 16240, 'Total 1st wkt partnership by KKR in IPL', '295', '110', '295', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:18'),
(85, 28127348, 15597, 'Total bowled in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(86, 28127348, 16207, 'Total Wicket lost by KXIP in IPL', '71', '100', '72', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(87, 28127348, 15622, 'Total Bowled in Sharjah', '25', '100', '26', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(88, 28127348, 16151, 'Total Wicket lost by MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(89, 28127348, 16208, 'Total Extras by KXIP in IPL', '98', '100', '99', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(90, 28127348, 16205, 'Total 4''s by KXIP in IPL', '181', '100', '182', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(91, 28127348, 15641, 'Total 6''s in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(92, 28127348, 15645, 'Total 50''s in Dubai', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(93, 28127348, 16152, 'Total Extras by MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(94, 28127348, 16166, 'Total Wides by CSK in IPL', '63', '100', '64', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(95, 28127348, 16174, 'Total match 1st over run of RCB in IPL', '76', '100', '77', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(96, 28127348, 16209, 'Total Wides by KXIP in IPL', '60', '100', '61', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(97, 28127348, 15614, 'Total 4''s in Sharjah', '290', '100', '292', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(98, 28127348, 15629, 'Total Wickets in Abu Dhabi', '214', '100', '216', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(99, 28127348, 16155, 'Total 1st wkt partnership by MI in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(100, 28127348, 16181, 'Total Caught out of RCB in IPL', '45', '100', '46', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(101, 28127348, 16180, 'Total Wides by RCB in IPL', '74', '100', '75', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(102, 28127348, 16609, 'Total 1st wkt partnership by RCB in IPL', '555', '105', '555', '85', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(103, 28127348, 15581, 'Total 1st 6 over run in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(104, 28127348, 15623, 'Total LBW in Sharjah', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(105, 28127348, 16221, 'Total 6''s by RR in IPL', '107', '100', '108', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(106, 28127348, 16192, 'Total Wicket lost by SRH in IPL', '80', '100', '82', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(107, 28127348, 16190, 'Total 4''s by SRH in IPL', '191', '100', '193', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(108, 28127348, 16224, 'Total Wides by RR in IPL', '51', '100', '52', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(109, 28127348, 16223, 'Total Extras by RR in IPL', '93', '100', '94', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(110, 28127348, 16188, 'Total match 1st over run of SRH in IPL', '88', '100', '90', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(111, 28127348, 16232, 'Total match 1st over run of KKR in IPL', '79', '100', '80', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(112, 28127348, 15636, 'Total LBW in Abu Dhabi', '13', '100', '14', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(113, 28127348, 16239, 'Total Caught out of KKR in IPL', '65', '100', '66', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(114, 28127348, 16233, 'Total 6 over run of KKR in IPL', '587', '100', '589', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(115, 28127348, 15592, 'Total 100''s in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(116, 28127348, 18168, 'Total Extras in Abu Dhabi.', '262', '100', '264', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(117, 28127348, 16179, 'Total Extras by RCB in IPL', '116', '100', '118', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(118, 28127348, 16193, 'Total Extras by SRH in IPL', '119', '100', '121', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(119, 28127348, 16157, 'Total runs by Q de Kock in IPL', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(120, 30082209, 26455, 'R Gaikwad run(CSK vs KXIP)adv', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:30:21'),
(121, 30082209, 26459, 'R Gaikwad Boundaries(CSK vs KXIP)adv', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:30:18'),
(122, 30082209, 26736, '15 over run CSK', '121', '100', '122', '100', '', 1, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(123, 30082209, 26728, 'R Gaikwad runs bhav', '35', '20', '35', '10', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:36:18'),
(124, 30082209, 26738, 'Only 13 over run CSK', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:31:50'),
(125, 30082210, 26785, 'L Ferguson 4 over Runs Session adv', '33', '100', '35', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(126, 30082210, 26775, 'Multiplication of Total Wkts KKR and RR adv', '30', '100', '37', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(127, 30082210, 26809, '1st Inn 11 to 20 overs Total 2 runs KKR adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(128, 30082210, 26784, 'L Ferguson 2 over Runs Session adv', '15', '100', '17', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(129, 30082210, 26749, 'Fall of 1st wkt RR(KKR vs RR)adv', '23', '110', '23', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(130, 30082210, 26771, 'Top batsman runs in match(KKR vs RR)adv', '66', '100', '68', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(131, 30082210, 26810, '1st Inn 11 to 20 overs Total Fours KKR adv', '6', '100', '7', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(132, 30082210, 26773, 'Multiplication of Total Fours KKR and RR adv', '150', '100', '157', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(133, 30082210, 26755, 'N Rana Boundaries(KKR vs RR)adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(134, 30082210, 26808, '1st Inn 11 to 20 overs Total 1 runs KKR adv', '27', '100', '29', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(135, 30082210, 26805, '1st Inn 11 to 20 overs Total Wkts KKR adv', '4', '100', '5', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(136, 30082210, 26828, '1st Inn 11 to 20 overs Total Dot balls RR adv', '13', '100', '15', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(137, 30082210, 26825, '1st Inn 0 to 10 overs Total Sixes RR adv', '2', '100', '3', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(138, 30082210, 26820, '1st Inn 0 to 10 overs Total Extras RR adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(139, 30082210, 26796, 'R Tewatia 2 over Runs Session adv', '14', '100', '16', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(140, 30082210, 26823, '1st Inn 0 to 10 overs Total 2 runs RR adv', '4', '100', '5', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(141, 30082210, 26788, 'J Archer 2 over Runs Session adv', '11', '100', '13', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(142, 30082210, 26798, '1st Inn 0 to 10 overs Total Wkts KKR adv', '2', '100', '3', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(143, 30082210, 26782, 'S Narine 2 over Runs Session adv', '12', '100', '14', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(144, 30082210, 26793, 'K Tyagi 4 over Runs Session adv', '33', '100', '35', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(145, 30082210, 26839, '1st Inn 0 to 20 overs Total Sixes RR adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(146, 30082210, 26811, '1st Inn 11 to 20 overs Total Sixes KKR adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(147, 30082210, 26815, '1st Inn 0 to 20 overs Total 1 runs KKR adv', '48', '100', '50', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(148, 30082210, 26754, 'S Gill Boundaries(KKR vs RR)adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(149, 30082210, 26818, '1st Inn 0 to 20 overs Total Sixes KKR adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(150, 30082210, 26768, 'Total match LBW(KKR vs RR)adv', '1', '120', '1', '70', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(151, 30082210, 26803, '1st Inn 0 to 10 overs Total Fours KKR adv', '7', '100', '8', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(152, 30082210, 26772, '3 wkt or more by bowler in match(KKR vs RR)adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(153, 30082210, 26800, '1st Inn 0 to 10 overs Total Dot balls KKR adv', '22', '100', '24', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(154, 30082210, 26789, 'J Archer 4 over Runs Session adv', '29', '100', '31', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(155, 30082210, 26750, 'S Gill run(KKR vs RR)adv', '26', '110', '26', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(156, 30082210, 26757, 'R Uthappa Boundaries(KKR vs RR)adv', '3', '115', '3', '85', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(157, 30082210, 26812, '1st Inn 0 to 20 overs Total Wkts KKR adv', '6', '100', '7', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(158, 30082210, 26792, 'K Tyagi 2 over Runs Session adv', '14', '100', '16', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(159, 30082210, 26829, '1st Inn 11 to 20 overs Total 1 runs RR adv', '27', '100', '29', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(160, 30082210, 26787, 'K Nagarkoti 4 over Runs Session adv', '34', '100', '36', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(161, 30082210, 26756, 'B Stokes Boundaries(KKR vs RR)adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(162, 30082210, 26838, '1st Inn 0 to 20 overs Total Fours RR adv', '13', '100', '14', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(163, 30082210, 26743, '6 over runs RR(KKR vs RR)adv', '45', '100', '47', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(164, 30082210, 26752, 'B Stokes run(KKR vs RR)adv', '24', '110', '24', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(165, 30082210, 26761, 'Total match Sixes(KKR vs RR)adv', '11', '120', '11', '80', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(166, 30082210, 26807, '1st Inn 11 to 20 overs Total Dot balls KKR adv', '13', '100', '15', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(167, 30082210, 26765, 'Total match Extras(KKR vs RR)adv', '14', '100', '16', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(168, 30082210, 26776, 'Multiplication of Total Wides KKR and RR adv', '16', '100', '21', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(169, 30082210, 26836, '1st Inn 0 to 20 overs Total 1 runs RR adv', '48', '100', '50', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(170, 30082210, 26816, '1st Inn 0 to 20 overs Total 2 runs KKR adv', '9', '100', '10', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(171, 30082210, 26748, 'Fall of 1st wkt KKR(KKR vs RR)adv', '25', '110', '25', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(172, 30082210, 26783, 'S Narine 4 over Runs Session adv', '28', '100', '30', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(173, 30082210, 26742, '6 over runs KKR(KKR vs RR)adv', '44', '100', '46', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(174, 30082210, 26780, 'V Chakravarthy 2 over Runs Session adv', '13', '100', '15', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(175, 30082210, 26802, '1st Inn 0 to 10 overs Total 2 runs KKR adv', '4', '100', '5', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(176, 30082210, 26746, '20 over runs KKR(KKR vs RR)adv', '162', '100', '164', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(177, 30082210, 26762, 'Total match Boundaries(KKR vs RR)adv', '36', '100', '38', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(178, 30082210, 26790, 'V Aaron 2 over Runs Session adv', '15', '100', '17', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(179, 30082210, 26835, '1st Inn 0 to 20 overs Total Dot balls RR adv', '35', '100', '37', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(180, 30082210, 26767, 'Total match Bowled(KKR vs RR)adv', '2', '100', '3', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(181, 30082210, 26774, 'Multiplication of Total Sixes KKR and RR adv', '25', '100', '31', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(182, 30082210, 26769, 'Total match Fifties(KKR vs RR)adv', '2', '100', '3', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(183, 30082210, 26781, 'V Chakravarthy 4 over Runs Session adv', '29', '100', '31', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(184, 30082210, 26759, 'How many balls for 50 runs RR(KKR vs RR)adv', '39', '100', '41', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(185, 30082210, 26813, '1st Inn 0 to 20 overs Total Extras KKR adv', '7', '100', '8', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(186, 30082210, 26758, 'How many balls for 50 runs KKR(KKR vs RR)adv', '40', '100', '42', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(187, 30082210, 26753, 'R Uthappa run(KKR vs RR)adv', '19', '120', '19', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(188, 30082210, 26804, '1st Inn 0 to 10 overs Total Sixes KKR adv', '2', '100', '3', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(189, 30082210, 26797, 'R Tewatia 4 over Runs Session adv', '32', '100', '34', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(190, 30082210, 26760, 'Total match Fours(KKR vs RR)adv', '25', '100', '27', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(191, 30082210, 26745, '10 over runs RR(KKR vs RR)adv', '73', '100', '75', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(192, 30082210, 26791, 'V Aaron 4 over Runs Session adv', '34', '100', '36', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(193, 30082210, 26827, '1st Inn 11 to 20 overs Total Extras RR adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(194, 30082210, 26806, '1st Inn 11 to 20 overs Total Extras KKR adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(195, 30082210, 26799, '1st Inn 0 to 10 overs Total Extras KKR adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(196, 30082210, 26741, 'Match 1st over run(KKR vs RR)adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(197, 30082210, 26834, '1st Inn 0 to 20 overs Total Extras RR adv', '7', '100', '8', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(198, 30082210, 26837, '1st Inn 0 to 20 overs Total 2 runs RR adv', '9', '100', '10', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(199, 30082210, 26821, '1st Inn 0 to 10 overs Total Dot balls RR adv', '22', '100', '24', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(200, 30082210, 26770, 'Highest Scoring over in match(KKR vs RR)adv', '20', '115', '20', '85', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(201, 30082210, 26764, 'Total match Wides(KKR vs RR)adv', '8', '100', '9', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(202, 30082210, 26833, '1st Inn 0 to 20 overs Total Wkts RR adv', '6', '100', '7', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(203, 30082210, 26763, 'Total match Wkts(KKR vs RR)adv', '12', '100', '13', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(204, 30082210, 26831, '1st Inn 11 to 20 overs Total Fours RR adv', '6', '100', '7', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(205, 30082210, 26779, 'P Cummins 4 over Runs Session adv', '33', '100', '35', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(206, 30082210, 26766, 'Total match Caught Outs(KKR vs RR)adv', '8', '100', '9', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(207, 30082210, 26817, '1st Inn 0 to 20 overs Total Fours KKR adv', '13', '100', '14', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(208, 30082210, 26830, '1st Inn 11 to 20 overs Total 2 runs RR adv', '5', '100', '6', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(209, 30082210, 26795, 'B Stokes 4 over Runs Session adv', '33', '100', '35', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(210, 30082210, 26751, 'N Rana run(KKR vs RR)adv', '23', '110', '23', '90', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(211, 30082210, 26794, 'B Stokes 2 over Runs Session adv', '15', '100', '17', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(212, 30082210, 26824, '1st Inn 0 to 10 overs Total Fours RR adv', '7', '100', '8', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(213, 30082210, 26801, '1st Inn 0 to 10 overs Total 1 runs KKR adv', '21', '100', '23', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(214, 30082210, 26819, '1st Inn 0 to 10 overs Total Wkts RR adv', '2', '100', '3', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(215, 30082210, 26786, 'K Nagarkoti 2 over Runs Session adv', '15', '100', '17', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(216, 30082210, 26744, '10 over runs KKR(KKR vs RR)adv', '73', '100', '75', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(217, 30082210, 26747, '20 over runs RR(KKR vs RR)adv', '162', '100', '164', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(218, 30082210, 26822, '1st Inn 0 to 10 overs Total 1 runs RR adv', '21', '100', '23', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(219, 30082210, 26777, 'Multiplication of Total Extras KKR and RR adv', '45', '100', '50', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(220, 30082210, 26826, '1st Inn 11 to 20 overs Total Wkts RR adv', '4', '100', '5', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(221, 30082210, 26832, '1st Inn 11 to 20 overs Total Sixes RR adv', '3', '100', '4', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(222, 30082210, 26778, 'P Cummins 2 over Runs Session adv', '14', '100', '16', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(223, 30082210, 26814, '1st Inn 0 to 20 overs Total Dot balls KKR adv', '35', '100', '37', '100', '', 0, NULL, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(224, 30082209, 26841, '155 runs bhav CSK', 'Ball', 'Running', 'Ball', 'Running', 'Ball Running', 0, NULL, 'Yes', '2020-11-01 06:31:17', '2020-11-01 06:31:59'),
(225, 30082209, 26840, 'Only 14 over run CSK', '-', 'SUSPENDED', '-', 'SUSPENDED', 'SUSPENDED', 0, NULL, 'Yes', '2020-11-01 06:31:31', '2020-11-01 06:35:19'),
(226, 30082209, 26740, 'Only 15 over run CSK', '8', '100', '9', '100', '', 0, NULL, 'Yes', '2020-11-01 06:33:21', '2020-11-01 06:36:18'),
(227, 30082209, 26843, 'Only 17 over run CSK', 'Ball', 'Running', 'Ball', 'Running', 'Ball Running', 0, NULL, 'Yes', '2020-11-01 06:41:09', '2020-11-01 06:41:27'),
(228, 30082209, 26842, 'Only 16 over run CSK', '9', '125', '9', '95', '', 0, NULL, 'Yes', '2020-11-01 06:41:30', '2020-11-01 06:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `market_book_odds_runner`
--

CREATE TABLE IF NOT EXISTS `market_book_odds_runner` (
  `id` int NOT NULL,
  `market_book_odd_id` int NOT NULL,
  `market_id` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `event_id` int NOT NULL,
  `selection_id` int NOT NULL,
  `handicap` int NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_price_traded` float DEFAULT NULL,
  `total_matched` float DEFAULT NULL,
  `back_1_price` float NOT NULL,
  `back_2_price` float NOT NULL,
  `back_3_price` float NOT NULL,
  `back_1_size` float NOT NULL,
  `back_2_size` float NOT NULL,
  `back_3_size` float NOT NULL,
  `lay_1_price` float NOT NULL,
  `lay_2_price` float NOT NULL,
  `lay_3_price` float NOT NULL,
  `lay_1_size` float NOT NULL,
  `lay_2_size` float NOT NULL,
  `lay_3_size` float NOT NULL,
  `is_active` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=356 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `market_book_odds_runner`
--

INSERT INTO `market_book_odds_runner` (`id`, `market_book_odd_id`, `market_id`, `event_id`, `selection_id`, `handicap`, `status`, `last_price_traded`, `total_matched`, `back_1_price`, `back_2_price`, `back_3_price`, `back_1_size`, `back_2_size`, `back_3_size`, `lay_1_price`, `lay_2_price`, `lay_3_price`, `lay_1_size`, `lay_2_size`, `lay_3_size`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '1.168634253', 28127348, 2954260, 0, 'ACTIVE', 24, 116678, 21, 20, 18.5, 31.06, 4.25, 124.25, 25, 27, 28, 12.11, 4.55, 4.44, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(2, 1, '1.168634253', 28127348, 2954263, 0, 'LOSER', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(3, 1, '1.174677254', 30082209, 2954263, 0, 'ACTIVE', 1.07, 28053800, 1.06, 1.05, 1.04, 90759.7, 103339, 96058.6, 1.07, 1.08, 1.09, 130252, 19308.4, 10200, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(4, 1, '1.174677254', 30082209, 2954262, 0, 'ACTIVE', 15.5, 8003610, 15.5, 15, 13.5, 193.49, 9101.45, 1533.51, 16, 17, 17.5, 440.54, 20.11, 235.7, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(5, 1, '1.174677622', 30082210, 2954260, 0, 'ACTIVE', 2.08, 25025.4, 2.06, 2.04, 2.02, 1518.36, 1113.27, 258.33, 2.08, 2.1, 2.12, 566.95, 4665.67, 878.28, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(6, 1, '1.174677622', 30082210, 2954266, 0, 'ACTIVE', 1.92, 47600.2, 1.92, 1.91, 1.9, 740.34, 4958.2, 924.24, 1.93, 1.94, 1.95, 156.99, 1118.37, 550.84, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(7, 1, '1.174677784', 30082210, 2954260, 0, 'ACTIVE', 2, 1836.5, 1.99, 1.98, 1.88, 1998.37, 455.76, 55.44, 2.02, 2.04, 110, 2325.39, 161.43, 0.02, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(8, 1, '1.174677784', 30082210, 2954266, 0, 'ACTIVE', 1.99, 1675.57, 1.99, 1.98, 1.01, 2075.89, 452.32, 2.22, 2.02, 2.04, 2.14, 2252.4, 161.43, 48.7, 'Yes', '2020-11-01 06:29:47', '2020-11-01 06:42:17'),
(9, 1, '1.168634253', 28127348, 2954281, 0, 'ACTIVE', 2.38, 191802, 2.36, 2.34, 2.32, 2.22, 819.78, 330.42, 2.38, 2.4, 2.56, 233.23, 134.32, 22.18, 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:42:17'),
(10, 1, '1.168634253', 28127348, 4164048, 0, 'ACTIVE', 5.2, 173140, 5, 4.9, 4.8, 2.76, 39.58, 22.18, 5.2, 5.3, 5.5, 94.54, 106.99, 20.91, 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:42:17'),
(11, 1, '1.168634253', 28127348, 22121561, 0, 'ACTIVE', 5.5, 142732, 5.2, 5, 4.9, 17.74, 244.97, 22.18, 5.5, 5.6, 6, 95.77, 10.46, 20.91, 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:42:17'),
(12, 1, '1.168634253', 28127348, 2954262, 0, 'ACTIVE', 55, 152101, 60, 55, 32, 0.83, 30.28, 3.33, 100, 290, 300, 0.73, 6.63, 194.04, 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:42:17'),
(13, 1, '1.168634253', 28127348, 7671295, 0, 'ACTIVE', 16, 78616.9, 15.5, 15, 14, 23.91, 369.23, 321.32, 16, 16.5, 17, 15.01, 22.2, 257.15, 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:42:17'),
(14, 1, '1.168634253', 28127348, 2954266, 0, 'ACTIVE', 17, 83031.5, 17, 16, 11.5, 32.27, 28.83, 4.44, 18.5, 19, 34, 2.76, 40.45, 149.69, 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:42:17');

-- --------------------------------------------------------

--
-- Table structure for table `market_types`
--

CREATE TABLE IF NOT EXISTS `market_types` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `market_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `market_id` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `market_start_time` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `total_matched` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `runner_1_selection_id` int NOT NULL,
  `runner_1_runner_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `runner_1_handicap` int NOT NULL,
  `runner_1_sort_priority` int NOT NULL,
  `runner_2_selection_id` int NOT NULL,
  `runner_2_runner_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `runner_2_handicap` int NOT NULL,
  `runner_2_sort_priority` int NOT NULL,
  `winner_selection_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` enum('Yes','No') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `market_types`
--

INSERT INTO `market_types` (`id`, `event_id`, `market_name`, `market_id`, `market_start_time`, `total_matched`, `runner_1_selection_id`, `runner_1_runner_name`, `runner_1_handicap`, `runner_1_sort_priority`, `runner_2_selection_id`, `runner_2_runner_name`, `runner_2_handicap`, `runner_2_sort_priority`, `winner_selection_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 28127348, 'Winner', '1.168634253', '2020-09-19T13:59:00.000Z', '818612', 2954281, 'Mumbai Indians', 0, 1, 4164048, 'Royal Challengers Bangalore', 0, 2, '', 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:36:25'),
(2, 30082209, 'Match Odds', '1.174677254', '2020-11-01T10:00:00.000Z', '85.95', 2954263, 'Chennai Super Kings', 0, 1, 2954262, 'Kings XI Punjab', 0, 2, '', 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:36:25'),
(3, 30082210, 'Match Odds', '1.174677622', '2020-11-01T14:00:00.000Z', '43.9', 2954260, 'Kolkata Knight Riders', 0, 1, 2954266, 'Rajasthan Royals', 0, 2, '', 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:36:25'),
(4, 30082210, 'To Win the Toss', '1.174677784', '2020-11-01T14:00:00.000Z', '206.34', 2954260, 'Kolkata Knight Riders', 0, 1, 2954266, 'Rajasthan Royals', 0, 2, '', 'Yes', '2020-11-01 06:30:01', '2020-11-01 06:36:25');

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE IF NOT EXISTS `registered_users` (
  `user_id` int NOT NULL,
  `master_id` int DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `user_name` varchar(150) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `user_type` enum('Super Admin','Admin','Hyper Super Master','Super Master','Master','User','Operator') DEFAULT 'User',
  `is_closed` enum('Yes','No') DEFAULT 'No',
  `is_betting_open` enum('Yes','No') DEFAULT 'Yes',
  `is_locked` enum('Yes','No') DEFAULT 'No',
  `sessional_commision` decimal(3,2) unsigned DEFAULT NULL,
  `casino_partnership` float DEFAULT NULL,
  `partnership` float DEFAULT NULL,
  `teenpati_partnership` float DEFAULT NULL,
  `master_commision` decimal(3,2) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registered_users`
--

INSERT INTO `registered_users` (`user_id`, `master_id`, `name`, `user_name`, `password`, `website`, `user_type`, `is_closed`, `is_betting_open`, `is_locked`, `sessional_commision`, `casino_partnership`, `partnership`, `teenpati_partnership`, `master_commision`, `registration_date`, `created_at`, `updated_at`) VALUES
(30, 0, 'Super admin', 'superadmin', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'Super Admin', 'No', 'Yes', 'No', NULL, 100, 100, 100, '0.00', '2020-09-27', '2020-09-27 07:00:00', '2020-09-28 03:19:34'),
(31, 0, 'Entry Operaotor', 'operator', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'Operator', 'No', 'Yes', 'No', NULL, 100, 100, 100, '0.00', '2020-09-27', '2020-09-27 07:00:00', '2020-09-28 03:19:34'),
(92, 30, 'admin', 'admin', '325a2cc052914ceeb8c19016c091d2ac', NULL, 'Admin', 'No', 'Yes', 'No', NULL, 80, 84, 80, '5.00', '2020-10-25', '2020-10-25 09:35:18', '2020-10-25 07:45:58'),
(93, 92, 'Hyper super', 'hsmaster', '325a2cc052914ceeb8c19016c091d2ac', NULL, 'Hyper Super Master', 'No', 'Yes', 'No', NULL, 80, 84, 80, '0.00', '2020-10-25', '2020-10-25 09:58:28', NULL),
(94, 93, 'Super master', 'Smaster', '325a2cc052914ceeb8c19016c091d2ac', NULL, 'Super Master', 'No', 'Yes', 'No', NULL, 80, 84, 80, '0.00', '2020-10-25', '2020-10-25 09:59:01', NULL),
(95, 94, 'Master', 'Master', '325a2cc052914ceeb8c19016c091d2ac', NULL, 'Master', 'No', 'Yes', 'No', NULL, 70, 80, 70, '0.00', '2020-10-25', '2020-10-25 09:59:26', NULL),
(96, 95, 'User', 'User1', '325a2cc052914ceeb8c19016c091d2ac', NULL, 'User', 'No', 'Yes', 'No', NULL, 0, 0, 0, '0.00', '2020-10-25', '2020-10-25 09:59:48', '2020-10-25 10:00:34'),
(97, 95, 'User', 'User2', '325a2cc052914ceeb8c19016c091d2ac', NULL, 'User', 'Yes', 'Yes', 'No', NULL, 0, 0, 0, '0.00', '2020-10-25', '2020-10-25 10:06:38', '2020-10-25 10:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE IF NOT EXISTS `sports` (
  `sport_id` int NOT NULL,
  `master_sport_id` int DEFAULT NULL,
  `sport_name` varchar(150) DEFAULT NULL,
  `is_allowed` enum('Yes','No') DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_chips`
--

CREATE TABLE IF NOT EXISTS `users_chips` (
  `user_chip_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `chip_id` int DEFAULT NULL,
  `chip_name` varchar(150) DEFAULT NULL,
  `chip_value` varchar(15) DEFAULT NULL,
  `is_active` enum('Yes','No') DEFAULT 'Yes',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_chips`
--

INSERT INTO `users_chips` (`user_chip_id`, `user_id`, `chip_id`, `chip_name`, `chip_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 88, 1, '1k', '1000', 'Yes', '2020-10-20 09:32:50', NULL),
(2, 89, 1, '1k', '1000', 'Yes', '2020-10-20 10:02:33', NULL),
(3, 90, 1, '1k', '1000', 'Yes', '2020-10-23 08:33:26', NULL),
(4, 91, 1, '1k', '1000', 'Yes', '2020-10-23 08:38:56', NULL),
(5, 92, 1, '1k', '1000', 'Yes', '2020-10-25 09:35:18', NULL),
(6, 92, 2, '2K', '2000', 'Yes', '2020-10-25 09:35:18', NULL),
(7, 92, 3, '5K', '5000', 'Yes', '2020-10-25 09:35:18', NULL),
(8, 92, 4, '10K', '10000', 'Yes', '2020-10-25 09:35:18', NULL),
(9, 92, 5, '50K', '50000', 'Yes', '2020-10-25 09:35:18', NULL),
(10, 93, 1, '1k', '1000', 'Yes', '2020-10-25 09:58:28', NULL),
(11, 93, 2, '2K', '2000', 'Yes', '2020-10-25 09:58:28', NULL),
(12, 93, 3, '5K', '5000', 'Yes', '2020-10-25 09:58:28', NULL),
(13, 93, 4, '10K', '10000', 'Yes', '2020-10-25 09:58:28', NULL),
(14, 93, 5, '50K', '50000', 'Yes', '2020-10-25 09:58:28', NULL),
(15, 94, 1, '1k', '1000', 'Yes', '2020-10-25 09:59:01', NULL),
(16, 94, 2, '2K', '2000', 'Yes', '2020-10-25 09:59:01', NULL),
(17, 94, 3, '5K', '5000', 'Yes', '2020-10-25 09:59:02', NULL),
(18, 94, 4, '10K', '10000', 'Yes', '2020-10-25 09:59:02', NULL),
(19, 94, 5, '50K', '50000', 'Yes', '2020-10-25 09:59:02', NULL),
(20, 95, 1, '1k', '1000', 'Yes', '2020-10-25 09:59:26', NULL),
(21, 95, 2, '2K', '2000', 'Yes', '2020-10-25 09:59:26', NULL),
(22, 95, 3, '5K', '5000', 'Yes', '2020-10-25 09:59:26', NULL),
(23, 95, 4, '10K', '10000', 'Yes', '2020-10-25 09:59:26', NULL),
(24, 95, 5, '50K', '50000', 'Yes', '2020-10-25 09:59:26', NULL),
(25, 96, 1, '1k', '1000', 'Yes', '2020-10-25 09:59:48', NULL),
(26, 96, 2, '2K', '2000', 'Yes', '2020-10-25 09:59:48', NULL),
(27, 96, 3, '5K', '5000', 'Yes', '2020-10-25 09:59:48', NULL),
(28, 96, 4, '10K', '10000', 'Yes', '2020-10-25 09:59:48', NULL),
(29, 96, 5, '50K', '50000', 'Yes', '2020-10-25 09:59:48', NULL),
(30, 97, 1, '1k', '1000', 'Yes', '2020-10-25 10:06:38', NULL),
(31, 97, 2, '2K', '2000', 'Yes', '2020-10-25 10:06:38', NULL),
(32, 97, 3, '5K', '5000', 'Yes', '2020-10-25 10:06:38', NULL),
(33, 97, 4, '10K', '10000', 'Yes', '2020-10-25 10:06:38', NULL),
(34, 97, 5, '50K', '50000', 'Yes', '2020-10-25 10:06:38', NULL),
(35, 97, 6, '100k', '100000', 'Yes', '2020-10-25 10:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `info_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `sport_id` int DEFAULT NULL,
  `sport_name` varchar(150) DEFAULT NULL,
  `min_stake` decimal(15,2) DEFAULT NULL,
  `max_stake` decimal(15,2) DEFAULT NULL,
  `max_profit` decimal(15,2) DEFAULT NULL,
  `max_loss` decimal(15,2) DEFAULT NULL,
  `bet_delay` float DEFAULT NULL,
  `pre_inplay_profit` decimal(15,2) DEFAULT NULL,
  `pre_inplay_stake` decimal(15,2) DEFAULT NULL,
  `min_odds` decimal(15,2) DEFAULT NULL,
  `max_odds` decimal(15,2) DEFAULT NULL,
  `unmatch_bet` enum('Yes','No') DEFAULT 'Yes',
  `lock_bet` enum('Yes','No') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`info_id`, `user_id`, `sport_id`, `sport_name`, `min_stake`, `max_stake`, `max_profit`, `max_loss`, `bet_delay`, `pre_inplay_profit`, `pre_inplay_stake`, `min_odds`, `max_odds`, `unmatch_bet`, `lock_bet`, `created_at`, `updated_at`) VALUES
(1, 79, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 12:01:54', NULL),
(2, 80, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 12:04:12', NULL),
(3, 81, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 12:04:48', NULL),
(4, 82, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 12:05:32', '2020-10-11 11:43:04'),
(5, 83, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 12:05:59', NULL),
(6, 84, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 1, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 08:12:17', '2020-10-19 11:38:29'),
(7, 85, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 08:12:40', NULL),
(8, 86, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 11:38:58', NULL),
(9, 87, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-11 11:42:26', '2020-10-11 11:46:39'),
(10, 88, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-20 09:32:50', NULL),
(11, 89, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-20 10:02:33', NULL),
(12, 90, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-23 08:33:26', NULL),
(13, 91, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-23 08:38:56', NULL),
(14, 92, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-25 09:35:18', NULL),
(15, 93, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-25 09:58:28', NULL),
(16, 94, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-25 09:59:02', NULL),
(17, 95, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-25 09:59:26', NULL),
(18, 96, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-25 09:59:48', NULL),
(19, 97, 1, 'Cricket', '10.00', '1000000.00', '5000000.00', '2000000.00', 4, '500000.00', '500000.00', '1.01', '100.00', 'Yes', 'No', '2020-10-25 10:06:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int NOT NULL,
  `username` varchar(80) NOT NULL,
  `token` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `username`, `token`, `created_at`, `updated_at`) VALUES
(1, 'operator', 'KHMbhT7LEtCa3iI', '2020-10-30 05:54:57', '2020-10-30 11:24:57'),
(2, 'superadmin', 'iq74PwDWjXMlIrI', '2020-10-30 05:56:39', '2020-10-30 11:26:39'),
(3, 'hsmaster', 'VA42LFWBzM2Zrrv', '2020-10-25 04:35:40', '2020-10-25 10:05:40'),
(4, 'admin', 'bdCW9fMTsGTXLft', '2020-10-25 04:34:58', '2020-10-25 10:04:58'),
(5, 'User', 'jlFPMUnGM7qpSMK', '2020-10-11 07:07:06', '2020-10-11 12:37:06'),
(6, 'Master', '97tt1lqHg99Jwha', '2020-10-31 08:53:57', '2020-10-31 02:23:57'),
(7, 'User2', 'Cb3OauBi4sW9V1p', '2020-10-25 05:06:21', '2020-10-25 10:36:21'),
(8, 'smaster', 'ArNhDkdswSgyizb', '2020-10-20 04:33:32', '2020-10-20 10:03:32'),
(9, 'User1', 'oQslMOJGLyKyRIq', '2020-11-01 12:56:13', '2020-11-01 06:26:13'),
(10, 'Pkll', 'H74YyL2EeuCtXCL', '2020-10-16 09:01:20', NULL),
(11, 'master1', 'USjZXTqPYzPZpOm', '2020-10-20 04:15:58', '2020-10-20 09:45:58'),
(12, 'smdldemo', 'Tah8MhfQNPqbwY9', '2020-10-23 08:35:30', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `betting`
--
ALTER TABLE `betting`
  ADD PRIMARY KEY (`betting_id`);

--
-- Indexes for table `block_markets`
--
ALTER TABLE `block_markets`
  ADD PRIMARY KEY (`block_market_id`);

--
-- Indexes for table `chips`
--
ALTER TABLE `chips`
  ADD PRIMARY KEY (`chip_id`);

--
-- Indexes for table `default_general_setting`
--
ALTER TABLE `default_general_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`e_id`,`event_id`);

--
-- Indexes for table `event_exchange_entrys`
--
ALTER TABLE `event_exchange_entrys`
  ADD PRIMARY KEY (`exchange_event_entry_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`event_type_id`);

--
-- Indexes for table `fancyEntrys`
--
ALTER TABLE `fancyEntrys`
  ADD PRIMARY KEY (`fancy_id`);

--
-- Indexes for table `fancy_data`
--
ALTER TABLE `fancy_data`
  ADD PRIMARY KEY (`fancy_id`);

--
-- Indexes for table `favorite_events`
--
ALTER TABLE `favorite_events`
  ADD PRIMARY KEY (`favourite_event_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD PRIMARY KEY (`ledger_id`);

--
-- Indexes for table `list_competitions`
--
ALTER TABLE `list_competitions`
  ADD PRIMARY KEY (`list_competition_id`),
  ADD UNIQUE KEY `UNIQUE_COMPETITION_ID` (`competition_id`),
  ADD KEY `KEY_EVENT_TYPE` (`event_type`);

--
-- Indexes for table `list_events`
--
ALTER TABLE `list_events`
  ADD PRIMARY KEY (`list_event_id`),
  ADD UNIQUE KEY `UNIQUE_EVENT_ID` (`event_id`),
  ADD KEY `KEY_COMPETITION_ID` (`competition_id`);

--
-- Indexes for table `market_book_odds`
--
ALTER TABLE `market_book_odds`
  ADD PRIMARY KEY (`market_book_odd_id`),
  ADD UNIQUE KEY `UNIQUE_MARKET_ID` (`market_id`);

--
-- Indexes for table `market_book_odds_fancy`
--
ALTER TABLE `market_book_odds_fancy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_1_SELECTION_ID` (`selection_id`),
  ADD KEY `KEY_MATCH_ID` (`match_id`);

--
-- Indexes for table `market_book_odds_runner`
--
ALTER TABLE `market_book_odds_runner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BOOK_ODDS_KEYS` (`market_id`,`event_id`,`selection_id`);

--
-- Indexes for table `market_types`
--
ALTER TABLE `market_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_MARKET_ID` (`market_id`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`sport_id`);

--
-- Indexes for table `users_chips`
--
ALTER TABLE `users_chips`
  ADD PRIMARY KEY (`user_chip_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `betting`
--
ALTER TABLE `betting`
  MODIFY `betting_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `block_markets`
--
ALTER TABLE `block_markets`
  MODIFY `block_market_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `chips`
--
ALTER TABLE `chips`
  MODIFY `chip_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `default_general_setting`
--
ALTER TABLE `default_general_setting`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `e_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_exchange_entrys`
--
ALTER TABLE `event_exchange_entrys`
  MODIFY `exchange_event_entry_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `event_type_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fancyEntrys`
--
ALTER TABLE `fancyEntrys`
  MODIFY `fancy_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fancy_data`
--
ALTER TABLE `fancy_data`
  MODIFY `fancy_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `favorite_events`
--
ALTER TABLE `favorite_events`
  MODIFY `favourite_event_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
  MODIFY `ledger_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=227;
--
-- AUTO_INCREMENT for table `list_competitions`
--
ALTER TABLE `list_competitions`
  MODIFY `list_competition_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `list_events`
--
ALTER TABLE `list_events`
  MODIFY `list_event_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `market_book_odds`
--
ALTER TABLE `market_book_odds`
  MODIFY `market_book_odd_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `market_book_odds_fancy`
--
ALTER TABLE `market_book_odds_fancy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=229;
--
-- AUTO_INCREMENT for table `market_book_odds_runner`
--
ALTER TABLE `market_book_odds_runner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `market_types`
--
ALTER TABLE `market_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=98;
--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `sport_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_chips`
--
ALTER TABLE `users_chips`
  MODIFY `user_chip_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `info_id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
