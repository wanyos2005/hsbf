-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2014 at 09:06 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smartcou_smartcounty`
--

-- --------------------------------------------------------

--
-- Table structure for table `bpt_bill`
--

CREATE TABLE IF NOT EXISTS `bpt_bill` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_business_id` int(11) NOT NULL,
  `bill_status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=207 ;

--
-- Dumping data for table `bpt_bill`
--

INSERT INTO `bpt_bill` (`bill_id`, `bill_business_id`, `bill_status`, `created_at`, `updated_at`) VALUES
(199, 14, 0, '2014-03-19 23:42:36', '0000-00-00 00:00:00'),
(200, 15, 0, '2014-03-20 00:03:59', '0000-00-00 00:00:00'),
(201, 16, 0, '2014-03-20 00:06:07', '0000-00-00 00:00:00'),
(202, 17, 0, '2014-03-20 00:09:10', '0000-00-00 00:00:00'),
(203, 18, 0, '2014-04-01 07:19:29', '0000-00-00 00:00:00'),
(204, 19, 0, '2014-04-02 09:38:11', '0000-00-00 00:00:00'),
(205, 20, 0, '2014-04-02 09:39:24', '0000-00-00 00:00:00'),
(206, 21, 0, '2014-04-01 23:37:08', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_bill_item`
--

CREATE TABLE IF NOT EXISTS `bpt_bill_item` (
  `bill_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_item_ref` int(11) NOT NULL,
  `bill_item_amount` double NOT NULL DEFAULT '2000',
  `bill_item` varchar(50) NOT NULL DEFAULT 'Business Permit Fee',
  `bill_item_description` varchar(100) NOT NULL DEFAULT 'Payment for a business permit',
  `bill_item_created_at` datetime NOT NULL,
  `bill_item_updated_at` datetime NOT NULL,
  PRIMARY KEY (`bill_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `bpt_bill_item`
--

INSERT INTO `bpt_bill_item` (`bill_item_id`, `bill_item_ref`, `bill_item_amount`, `bill_item`, `bill_item_description`, `bill_item_created_at`, `bill_item_updated_at`) VALUES
(4, 199, 2000, 'Test 1', 'Test Description', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 200, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 201, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 202, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 203, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 204, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 205, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 206, 2000, 'Business Permit Fee', 'Payment for a business permit', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_business`
--

CREATE TABLE IF NOT EXISTS `bpt_business` (
  `business_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `doc_type` int(11) NOT NULL,
  `doc_no` int(11) NOT NULL,
  `pin_no` varchar(50) NOT NULL,
  `vat_no` int(11) NOT NULL,
  `bs_box_no` int(11) NOT NULL,
  `bs_postal_code` int(11) NOT NULL,
  `bs_tel_no1` int(11) NOT NULL,
  `bs_tel_no2` int(11) NOT NULL,
  `bs_fax_no` int(11) NOT NULL,
  `bs_email` varchar(50) NOT NULL,
  `physical_address` varchar(100) NOT NULL,
  `plot_no` varchar(10) NOT NULL,
  `ct_name` varchar(50) NOT NULL,
  `ct_designation` varchar(50) NOT NULL,
  `ct_box_no` int(11) NOT NULL,
  `ct_postal_code` int(11) NOT NULL,
  `ct_town` varchar(50) NOT NULL,
  `ct_tel_no1` int(11) NOT NULL,
  `ct_tel_no2` int(11) NOT NULL,
  `ct_fax_no` int(11) NOT NULL,
  `activity_desc` varchar(50) NOT NULL,
  `area` int(11) NOT NULL,
  `other_details` int(11) NOT NULL,
  `employees` int(11) NOT NULL,
  `activity_code` int(11) NOT NULL,
  `activity_name` varchar(50) NOT NULL,
  `fee_schedule` int(11) NOT NULL DEFAULT '1',
  `zone` int(11) NOT NULL,
  `ward` int(11) NOT NULL,
  `longitude` varchar(80) NOT NULL,
  `latitude` varchar(80) NOT NULL,
  `near` varchar(80) NOT NULL,
  `relative_size` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `bs_town` varchar(50) NOT NULL,
  PRIMARY KEY (`business_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `bpt_business`
--

INSERT INTO `bpt_business` (`business_id`, `user_id`, `business_name`, `doc_type`, `doc_no`, `pin_no`, `vat_no`, `bs_box_no`, `bs_postal_code`, `bs_tel_no1`, `bs_tel_no2`, `bs_fax_no`, `bs_email`, `physical_address`, `plot_no`, `ct_name`, `ct_designation`, `ct_box_no`, `ct_postal_code`, `ct_town`, `ct_tel_no1`, `ct_tel_no2`, `ct_fax_no`, `activity_desc`, `area`, `other_details`, `employees`, `activity_code`, `activity_name`, `fee_schedule`, `zone`, `ward`, `longitude`, `latitude`, `near`, `relative_size`, `created_at`, `updated_at`, `bs_town`) VALUES
(19, 0, 'test', 0, 0, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, '', 1, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(20, 0, 'test', 0, 0, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, '', 1, 0, 0, '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', ''),
(21, 0, 'test', 0, 0, '', 0, 0, 0, 0, 0, 0, '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, 0, 0, '', 1, 0, 0, '150.501177734375', '-34.36526546210242', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

--
-- Triggers `bpt_business`
--
DROP TRIGGER IF EXISTS `create_bill`;
DELIMITER //
CREATE TRIGGER `create_bill` AFTER INSERT ON `bpt_business`
 FOR EACH ROW BEGIN
      INSERT INTO bpt_bill(bill_business_id) VALUES (NEW.business_id);
      SET @bill_id=LAST_INSERT_ID();      
      INSERT INTO bpt_bill_item(bill_item_ref)VALUES(@bill_id);	
      INSERT INTO global_invoices(invoice_no) VALUES (CONCAT('BPT-',@bill_id));
      UPDATE bpt_bill_item SET bill_item_amount=(SELECT sbp_fee FROM bpt_fee_schedule WHERE schedule_id=NEW.fee_schedule) WHERE bill_item_id=LAST_INSERT_ID();
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bpt_council_schedule`
--

CREATE TABLE IF NOT EXISTS `bpt_council_schedule` (
  `cl_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `schedule_no` int(11) NOT NULL,
  `minute_date` date NOT NULL,
  `minute_no` date NOT NULL,
  `gazette_date` date NOT NULL,
  `gazette_no` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`cl_schedule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `bpt_council_schedule`
--

INSERT INTO `bpt_council_schedule` (`cl_schedule_id`, `user_id`, `schedule_no`, `minute_date`, `minute_no`, `gazette_date`, `gazette_no`, `created_at`, `updated_at`) VALUES
(1, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 0, 1, '0000-00-00', '0000-00-00', '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_fee_schedule`
--

CREATE TABLE IF NOT EXISTS `bpt_fee_schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `brims_code` int(11) NOT NULL,
  `schedule_name` varchar(50) NOT NULL,
  `schedule_description` varchar(50) NOT NULL,
  `sbp_fee` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `bpt_fee_schedule`
--

INSERT INTO `bpt_fee_schedule` (`schedule_id`, `brims_code`, `schedule_name`, `schedule_description`, `sbp_fee`, `status`, `created_at`, `updated_at`) VALUES
(1, 201, 'schedule 1', 'schedule 1 description', 2000, 0, '2014-03-08 14:56:08', '2014-03-14 14:56:13'),
(2, 292, 'schedule 2', 'schedule 2 description', 2300, 0, '2014-03-08 14:56:42', '2014-03-14 14:56:46'),
(10, 0, 'test', 'test', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 0, '122', 'test', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 0, 'test', 'test', 200, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_payment`
--

CREATE TABLE IF NOT EXISTS `bpt_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `payment_bill_reference` int(11) NOT NULL,
  `payment_amount` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bpt_payment`
--

INSERT INTO `bpt_payment` (`payment_id`, `user_id`, `payment_bill_reference`, `payment_amount`, `created_at`, `updated_at`) VALUES
(1, 0, 201, 2000, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Triggers `bpt_payment`
--
DROP TRIGGER IF EXISTS `pay_bill`;
DELIMITER //
CREATE TRIGGER `pay_bill` AFTER INSERT ON `bpt_payment`
 FOR EACH ROW BEGIN
      UPDATE bpt_bill SET bill_status=1 WHERE bill_business_id=NEW.payment_bill_reference;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bpt_penalty_rate`
--

CREATE TABLE IF NOT EXISTS `bpt_penalty_rate` (
  `penalty_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `ref_date` date NOT NULL,
  `ref_no` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`penalty_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bpt_penalty_rate`
--

INSERT INTO `bpt_penalty_rate` (`penalty_id`, `user_id`, `rate`, `ref_date`, `ref_no`, `created_at`, `updated_at`) VALUES
(1, 0, 1233, '0000-00-00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_schedule_category`
--

CREATE TABLE IF NOT EXISTS `bpt_schedule_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_code` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_description` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bpt_schedule_category`
--

INSERT INTO `bpt_schedule_category` (`category_id`, `category_code`, `category_name`, `category_description`, `created_at`, `updated_at`) VALUES
(1, 200, 'test', 'test', '2014-04-01 22:17:29', '0000-00-00 00:00:00'),
(2, 300, 'test 2', 'test 2', '2014-04-01 22:18:01', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_ward`
--

CREATE TABLE IF NOT EXISTS `bpt_ward` (
  `ward_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ward_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`ward_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bpt_ward`
--

INSERT INTO `bpt_ward` (`ward_id`, `user_id`, `ward_name`, `created_at`, `updated_at`) VALUES
(1, 0, 'test', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bpt_zone`
--

CREATE TABLE IF NOT EXISTS `bpt_zone` (
  `zone_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `zone_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bpt_zone`
--

INSERT INTO `bpt_zone` (`zone_id`, `user_id`, `zone_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'kenya', '2014-03-04 12:02:50', '2014-03-04 12:02:53'),
(2, 2, 'Kenyaaaa', '2014-03-04 12:07:52', '2014-03-11 12:07:55'),
(3, 0, 'testsss', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `citizen`
--

CREATE TABLE IF NOT EXISTS `citizen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned NOT NULL,
  `national_id_no` varchar(30) DEFAULT NULL,
  `passport_no` varchar(30) DEFAULT NULL,
  `kra_pin` varchar(30) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `citizen`
--


-- --------------------------------------------------------

--
-- Table structure for table `console_tasks`
--

CREATE TABLE IF NOT EXISTS `console_tasks` (
  `id` varchar(30) NOT NULL,
  `last_run` timestamp NULL DEFAULT NULL,
  `execution_type` varchar(20) NOT NULL DEFAULT 'continuous',
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `threads` int(11) NOT NULL DEFAULT '0',
  `max_threads` int(11) NOT NULL DEFAULT '100',
  `sleep` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `console_tasks`
--

INSERT INTO `console_tasks` (`id`, `last_run`, `execution_type`, `status`, `threads`, `max_threads`, `sleep`) VALUES
('cleanUp', NULL, 'default', 'Active', 0, 0, 0),
('sendEmail', NULL, 'continuous', 'Active', 0, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `console_task_queue`
--

CREATE TABLE IF NOT EXISTS `console_task_queue` (
  `id` varchar(128) NOT NULL,
  `params` longtext NOT NULL,
  `task` varchar(30) NOT NULL,
  `progress_message` text,
  `progress_status` varchar(20) NOT NULL DEFAULT 'Progress',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `max_attempts` tinyint(2) NOT NULL DEFAULT '3',
  `attempts` int(11) NOT NULL DEFAULT '0',
  `pop_key` varchar(128) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `task` (`task`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `console_task_queue`
--


-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE IF NOT EXISTS `dept` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `telephone1` varchar(15) DEFAULT NULL,
  `telephone2` varchar(15) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_person_id` int(11) unsigned DEFAULT NULL,
  `status` enum('Open','Closed') NOT NULL DEFAULT 'Open',
  `country_id` int(11) unsigned DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  `last_modified_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `contact_person_id` (`contact_person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`id`, `name`, `telephone1`, `telephone2`, `email`, `address`, `contact_person_id`, `status`, `country_id`, `location`, `latitude`, `longitude`, `date_created`, `created_by`, `last_modified`, `last_modified_by`) VALUES
(1, 'Sample Department in Kiambu County', '', '', '', '', 8, 'Open', 1, '', '', '', '2014-02-10 08:30:22', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dept_user`
--

CREATE TABLE IF NOT EXISTS `dept_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned NOT NULL,
  `dept_id` int(11) unsigned NOT NULL,
  `has_left` tinyint(1) NOT NULL DEFAULT '0',
  `reason_for_leaving` varchar(255) DEFAULT NULL,
  `date_left` timestamp NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  `last_modified_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `store_id` (`dept_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `dept_user`
--

INSERT INTO `dept_user` (`id`, `person_id`, `dept_id`, `has_left`, `reason_for_leaving`, `date_left`, `date_created`, `created_by`, `last_modified`, `last_modified_by`) VALUES
(1, 8, 1, 0, NULL, NULL, '2014-02-10 08:31:58', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned NOT NULL,
  `level_id` smallint(6) unsigned NOT NULL,
  `id_no` varchar(30) DEFAULT NULL,
  `staff_no` varchar(30) NOT NULL,
  `passport_no` varchar(30) DEFAULT NULL,
  `dept_id` int(11) unsigned DEFAULT NULL,
  `employment_date` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `level_id` (`level_id`),
  KEY `dept_id` (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `employee`
--


-- --------------------------------------------------------

--
-- Table structure for table `employee_level`
--

CREATE TABLE IF NOT EXISTS `employee_level` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `retired` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `employee_level`
--


-- --------------------------------------------------------

--
-- Table structure for table `global_invoices`
--

CREATE TABLE IF NOT EXISTS `global_invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `global_invoices`
--

INSERT INTO `global_invoices` (`invoice_id`, `invoice_no`, `created_at`) VALUES
(1, 'BPT-200', '2014-03-20 00:03:59'),
(2, 'BPT-201', '2014-03-20 00:06:07'),
(3, 'BPT-202', '2014-03-20 00:09:10'),
(4, 'BPT-203', '2014-04-01 07:19:29'),
(5, 'BPT-204', '2014-04-02 09:38:11'),
(6, 'BPT-205', '2014-04-02 09:39:24'),
(7, 'BPT-206', '2014-04-01 23:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `modules_enabled`
--

CREATE TABLE IF NOT EXISTS `modules_enabled` (
  `id` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Enabled',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules_enabled`
--

INSERT INTO `modules_enabled` (`id`, `name`, `description`, `status`, `date_created`, `created_by`) VALUES
('bizpermit', 'Business Permit Module', NULL, 'Enabled', '2014-02-10 08:22:21', 1),
('cess', 'Cess Module', '', 'Enabled', '2014-02-10 08:23:53', 1),
('dept', 'Department Module', '', 'Enabled', '2014-02-10 08:19:15', 1),
('landrates', 'Land Rates Module', '', 'Enabled', '2014-02-10 08:22:45', 1),
('marketfees', 'Market Fees Module', '', 'Enabled', '2014-02-10 08:23:05', 1),
('parking', 'Parking Module', '', 'Enabled', '2014-02-10 08:20:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `msg_email_outbox`
--

CREATE TABLE IF NOT EXISTS `msg_email_outbox` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sent_by` int(11) DEFAULT NULL,
  `from_name` varchar(64) DEFAULT NULL,
  `from_email` varchar(128) NOT NULL,
  `to_email` varchar(128) NOT NULL,
  `to_name` varchar(60) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_queued` timestamp NULL DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `to_email` (`to_email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `msg_email_outbox`
--


-- --------------------------------------------------------

--
-- Table structure for table `parking_clumped`
--

CREATE TABLE IF NOT EXISTS `parking_clumped` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) unsigned NOT NULL,
  `street_id` int(11) unsigned DEFAULT NULL,
  `county_id` int(11) unsigned NOT NULL,
  `clumping_reason` varchar(500) NOT NULL,
  `exact_location` varchar(255) NOT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `time_clumped` datetime NOT NULL,
  `clumping_status` enum('Clumped','Unclumped') NOT NULL DEFAULT 'Clumped',
  `clumped_by` int(11) unsigned NOT NULL,
  `time_unclumped` datetime DEFAULT NULL,
  `unclumped_by` int(11) unsigned DEFAULT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `street_id` (`street_id`),
  KEY `county_id` (`county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `parking_clumped`
--


-- --------------------------------------------------------

--
-- Table structure for table `parking_fees`
--

CREATE TABLE IF NOT EXISTS `parking_fees` (
  `id` varchar(60) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(500) NOT NULL,
  `retired` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_fees`
--


-- --------------------------------------------------------

--
-- Table structure for table `parking_fee_matrix`
--

CREATE TABLE IF NOT EXISTS `parking_fee_matrix` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `street_id` int(11) unsigned NOT NULL,
  `county_id` int(11) unsigned NOT NULL,
  `parking_fee_id` varchar(60) NOT NULL,
  `parking_package_id` varchar(30) NOT NULL,
  `amount` decimal(10,0) NOT NULL DEFAULT '0',
  `description` varchar(500) DEFAULT NULL,
  `retired` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `county_id` (`county_id`),
  KEY `street_id` (`street_id`),
  KEY `parking_fee_id` (`parking_fee_id`),
  KEY `parking_package_id` (`parking_package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `parking_fee_matrix`
--


-- --------------------------------------------------------

--
-- Table structure for table `parking_parkage`
--

CREATE TABLE IF NOT EXISTS `parking_parkage` (
  `id` varchar(30) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parking_parkage`
--


-- --------------------------------------------------------

--
-- Table structure for table `parking_payments`
--

CREATE TABLE IF NOT EXISTS `parking_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) unsigned NOT NULL,
  `street_id` int(11) unsigned DEFAULT NULL,
  `county_id` int(11) unsigned NOT NULL,
  `parking_fee_matrix_id` int(11) unsigned DEFAULT NULL,
  `payment_datetime` datetime NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_status` enum('Completed','Pending') NOT NULL DEFAULT 'Completed',
  `payment_method` varchar(30) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `county_id` (`county_id`),
  KEY `street_id` (`street_id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `parking_fee_matrix_id` (`parking_fee_matrix_id`),
  KEY `payment_method` (`payment_method`),
  KEY `payment_status` (`payment_status`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `parking_payments`
--


-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthdate_estimated` tinyint(1) NOT NULL DEFAULT '0',
  `country_id` int(11) unsigned DEFAULT NULL,
  `profile_image` varchar(128) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(10) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `birthdate`, `birthdate_estimated`, `country_id`, `profile_image`, `date_created`, `created_by`, `last_modified`) VALUES
(1, 'Fredrick', 'Onyango', 'Ochola', 'Male', NULL, 0, NULL, NULL, '2014-02-06 05:13:23', NULL, '2014-02-06 05:13:23'),
(3, 'Felix', NULL, 'Aduol', 'Male', NULL, 0, NULL, NULL, '2014-02-07 06:12:33', 1, NULL),
(4, 'Beatrice', NULL, 'Onyango', 'Female', NULL, 0, NULL, 'daaa8a6f513dc906163d8f8eb32f534d.jpg', '2014-02-07 06:14:14', 1, '2014-02-07 06:15:35'),
(5, 'Bahati', NULL, 'Abdala', 'Male', NULL, 0, NULL, NULL, '2014-02-08 12:47:43', 1, NULL),
(7, 'Fredrick', NULL, 'Ochola', '', NULL, 0, NULL, '82bbbe9d1c48ec37be5dbf5cf0573ee7.jpg', '2014-02-10 02:34:43', NULL, '2014-02-10 03:02:41'),
(8, 'Fredrick', NULL, 'Onyango', 'Male', NULL, 0, NULL, '2b685c04ca8f849845c424ec3936ed73.jpg', '2014-02-10 08:31:58', 1, NULL),
(9, 'Martin', NULL, 'Muriithi', 'Male', '1994-01-01', 0, NULL, NULL, '2014-02-27 09:16:12', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `person_address`
--

CREATE TABLE IF NOT EXISTS `person_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `person_id` int(11) unsigned NOT NULL,
  `phone1` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `residence` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `person_address`
--

INSERT INTO `person_address` (`id`, `person_id`, `phone1`, `phone2`, `email`, `address`, `residence`, `date_created`, `created_by`, `last_modified`) VALUES
(2, 7, '', '', NULL, '', '', '2014-02-10 03:02:54', 7, NULL),
(3, 9, '254725830529', '', NULL, '', '', '2014-03-01 03:43:26', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `region_country`
--

CREATE TABLE IF NOT EXISTS `region_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the county (system generated)',
  `name` varchar(128) NOT NULL COMMENT 'Country name',
  `country_code` varchar(4) DEFAULT NULL COMMENT 'Country code e.g 254 for Kenya',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=247 ;

--
-- Dumping data for table `region_country`
--

INSERT INTO `region_country` (`id`, `name`, `country_code`, `date_created`) VALUES
(1, 'Kenya', '254', '2012-12-28 06:07:56'),
(3, 'Andorra', NULL, '2013-01-30 01:56:12'),
(4, 'United Arab Emirates', NULL, '2013-01-30 01:56:12'),
(5, 'Afghanistan', NULL, '2013-01-30 01:56:12'),
(6, 'Antigua and Barbuda', NULL, '2013-01-30 01:56:12'),
(7, 'Anguilla', NULL, '2013-01-30 01:56:12'),
(8, 'Albania', NULL, '2013-01-30 01:56:12'),
(9, 'Armenia', NULL, '2013-01-30 01:56:12'),
(10, 'Netherlands Antilles', NULL, '2013-01-30 01:56:12'),
(11, 'Angola', NULL, '2013-01-30 01:56:12'),
(12, 'Antarctica', NULL, '2013-01-30 01:56:12'),
(13, 'Argentina', NULL, '2013-01-30 01:56:12'),
(14, 'American Samoa', NULL, '2013-01-30 01:56:12'),
(15, 'Austria', NULL, '2013-01-30 01:56:12'),
(16, 'Australia', NULL, '2013-01-30 01:56:12'),
(17, 'Aruba', NULL, '2013-01-30 01:56:12'),
(18, 'Aland Islands', NULL, '2013-01-30 01:56:12'),
(19, 'Azerbaijan', NULL, '2013-01-30 01:56:12'),
(20, 'Bosnia and Herzegovina', NULL, '2013-01-30 01:56:12'),
(21, 'Barbados', NULL, '2013-01-30 01:56:12'),
(22, 'Bangladesh', NULL, '2013-01-30 01:56:12'),
(23, 'Belgium', NULL, '2013-01-30 01:56:12'),
(24, 'Burkina Faso', NULL, '2013-01-30 01:56:12'),
(25, 'Bulgaria', NULL, '2013-01-30 01:56:12'),
(26, 'Bahrain', NULL, '2013-01-30 01:56:12'),
(27, 'Burundi', NULL, '2013-01-30 01:56:12'),
(28, 'Benin', NULL, '2013-01-30 01:56:12'),
(29, 'Bermuda', NULL, '2013-01-30 01:56:12'),
(30, 'Brunei Darussalam', NULL, '2013-01-30 01:56:12'),
(31, 'Bolivia', NULL, '2013-01-30 01:56:12'),
(32, 'Brazil', NULL, '2013-01-30 01:56:12'),
(33, 'Bahamas', NULL, '2013-01-30 01:56:12'),
(34, 'Bhutan', NULL, '2013-01-30 01:56:12'),
(35, 'Bouvet Island', NULL, '2013-01-30 01:56:12'),
(36, 'Botswana', NULL, '2013-01-30 01:56:12'),
(37, 'Belarus', NULL, '2013-01-30 01:56:12'),
(38, 'Belize', NULL, '2013-01-30 01:56:12'),
(39, 'Canada', NULL, '2013-01-30 01:56:12'),
(40, 'Caribbean Nations', NULL, '2013-01-30 01:56:12'),
(41, 'Cocos (Keeling) Islands', NULL, '2013-01-30 01:56:12'),
(42, 'Democratic Republic of the Congo', NULL, '2013-01-30 01:56:12'),
(43, 'Central African Republic', NULL, '2013-01-30 01:56:12'),
(44, 'Congo', NULL, '2013-01-30 01:56:12'),
(45, 'Switzerland', NULL, '2013-01-30 01:56:12'),
(46, 'Cote D''Ivoire', NULL, '2013-01-30 01:56:12'),
(47, 'Cook Islands', NULL, '2013-01-30 01:56:12'),
(48, 'Chile', NULL, '2013-01-30 01:56:12'),
(49, 'Cameroon', NULL, '2013-01-30 01:56:12'),
(50, 'China', NULL, '2013-01-30 01:56:12'),
(51, 'Colombia', NULL, '2013-01-30 01:56:12'),
(52, 'Costa Rica', NULL, '2013-01-30 01:56:12'),
(53, 'Serbia and Montenegro', NULL, '2013-01-30 01:56:12'),
(54, 'Cuba', NULL, '2013-01-30 01:56:12'),
(55, 'Cape Verde', NULL, '2013-01-30 01:56:12'),
(56, 'Christmas Island', NULL, '2013-01-30 01:56:12'),
(57, 'Cyprus', NULL, '2013-01-30 01:56:12'),
(58, 'Czech Republic', NULL, '2013-01-30 01:56:12'),
(59, 'Germany', NULL, '2013-01-30 01:56:12'),
(60, 'Djibouti', NULL, '2013-01-30 01:56:12'),
(61, 'Denmark', NULL, '2013-01-30 01:56:12'),
(62, 'Dominica', NULL, '2013-01-30 01:56:12'),
(63, 'Dominican Republic', NULL, '2013-01-30 01:56:12'),
(64, 'Algeria', NULL, '2013-01-30 01:56:12'),
(65, 'Ecuador', NULL, '2013-01-30 01:56:12'),
(66, 'Estonia', NULL, '2013-01-30 01:56:12'),
(67, 'Egypt', NULL, '2013-01-30 01:56:12'),
(68, 'Western Sahara', NULL, '2013-01-30 01:56:12'),
(69, 'Eritrea', NULL, '2013-01-30 01:56:12'),
(70, 'Spain', NULL, '2013-01-30 01:56:12'),
(71, 'Ethiopia', NULL, '2013-01-30 01:56:12'),
(72, 'Finland', NULL, '2013-01-30 01:56:12'),
(73, 'Fiji', NULL, '2013-01-30 01:56:12'),
(74, 'Falkland Islands (Malvinas)', NULL, '2013-01-30 01:56:12'),
(75, 'Federated States of Micronesia', NULL, '2013-01-30 01:56:12'),
(76, 'Faroe Islands', NULL, '2013-01-30 01:56:12'),
(77, 'France', NULL, '2013-01-30 01:56:12'),
(78, 'France, Metropolitan', NULL, '2013-01-30 01:56:12'),
(79, 'Gabon', NULL, '2013-01-30 01:56:12'),
(80, 'United Kingdom', NULL, '2013-01-30 01:56:12'),
(81, 'Grenada', NULL, '2013-01-30 01:56:12'),
(82, 'Georgia', NULL, '2013-01-30 01:56:12'),
(83, 'French Guiana', NULL, '2013-01-30 01:56:12'),
(84, 'Ghana', NULL, '2013-01-30 01:56:12'),
(85, 'Gibraltar', NULL, '2013-01-30 01:56:12'),
(86, 'Greenland', NULL, '2013-01-30 01:56:12'),
(87, 'Gambia', NULL, '2013-01-30 01:56:12'),
(88, 'Guinea', NULL, '2013-01-30 01:56:12'),
(89, 'Guadeloupe', NULL, '2013-01-30 01:56:12'),
(90, 'Equatorial Guinea', NULL, '2013-01-30 01:56:12'),
(91, 'Greece', NULL, '2013-01-30 01:56:12'),
(92, 'S. Georgia and S. Sandwich Islands', NULL, '2013-01-30 01:56:12'),
(93, 'Guatemala', NULL, '2013-01-30 01:56:12'),
(94, 'Guam', NULL, '2013-01-30 01:56:12'),
(95, 'Guinea-Bissau', NULL, '2013-01-30 01:56:12'),
(96, 'Guyana', NULL, '2013-01-30 01:56:12'),
(97, 'Hong Kong', NULL, '2013-01-30 01:56:12'),
(98, 'Heard Island and McDonald Islands', NULL, '2013-01-30 01:56:12'),
(99, 'Honduras', NULL, '2013-01-30 01:56:12'),
(100, 'Croatia', NULL, '2013-01-30 01:56:12'),
(101, 'Haiti', NULL, '2013-01-30 01:56:12'),
(102, 'Hungary', NULL, '2013-01-30 01:56:12'),
(103, 'Indonesia', NULL, '2013-01-30 01:56:12'),
(104, 'Ireland', NULL, '2013-01-30 01:56:12'),
(105, 'Israel', NULL, '2013-01-30 01:56:12'),
(106, 'India', NULL, '2013-01-30 01:56:12'),
(107, 'British Indian Ocean Territory', NULL, '2013-01-30 01:56:12'),
(108, 'Iraq', NULL, '2013-01-30 01:56:12'),
(109, 'Iran', NULL, '2013-01-30 01:56:12'),
(110, 'Iceland', NULL, '2013-01-30 01:56:12'),
(111, 'Italy', NULL, '2013-01-30 01:56:12'),
(112, 'Jamaica', NULL, '2013-01-30 01:56:12'),
(113, 'Jordan', NULL, '2013-01-30 01:56:12'),
(114, 'Japan', NULL, '2013-01-30 01:56:12'),
(115, 'Kenya', NULL, '2013-01-30 01:56:12'),
(116, 'Kyrgyzstan', NULL, '2013-01-30 01:56:12'),
(117, 'Cambodia', NULL, '2013-01-30 01:56:12'),
(118, 'Kiribati', NULL, '2013-01-30 01:56:12'),
(119, 'Comoros', NULL, '2013-01-30 01:56:12'),
(120, 'Saint Kitts and Nevis', NULL, '2013-01-30 01:56:12'),
(121, 'Korea (North)', NULL, '2013-01-30 01:56:12'),
(122, 'Korea', NULL, '2013-01-30 01:56:12'),
(123, 'Kuwait', NULL, '2013-01-30 01:56:12'),
(124, 'Cayman Islands', NULL, '2013-01-30 01:56:12'),
(125, 'Kazakhstan', NULL, '2013-01-30 01:56:12'),
(126, 'Laos', NULL, '2013-01-30 01:56:12'),
(127, 'Lebanon', NULL, '2013-01-30 01:56:12'),
(128, 'Saint Lucia', NULL, '2013-01-30 01:56:12'),
(129, 'Liechtenstein', NULL, '2013-01-30 01:56:12'),
(130, 'Sri Lanka', NULL, '2013-01-30 01:56:12'),
(131, 'Liberia', NULL, '2013-01-30 01:56:12'),
(132, 'Lesotho', NULL, '2013-01-30 01:56:12'),
(133, 'Lithuania', NULL, '2013-01-30 01:56:12'),
(134, 'Luxembourg', NULL, '2013-01-30 01:56:12'),
(135, 'Latvia', NULL, '2013-01-30 01:56:12'),
(136, 'Libya', NULL, '2013-01-30 01:56:12'),
(137, 'Morocco', NULL, '2013-01-30 01:56:12'),
(138, 'Monaco', NULL, '2013-01-30 01:56:12'),
(139, 'Moldova', NULL, '2013-01-30 01:56:12'),
(140, 'Madagascar', NULL, '2013-01-30 01:56:12'),
(141, 'Marshall Islands', NULL, '2013-01-30 01:56:12'),
(142, 'Macedonia', NULL, '2013-01-30 01:56:12'),
(143, 'Mali', NULL, '2013-01-30 01:56:12'),
(144, 'Myanmar', NULL, '2013-01-30 01:56:12'),
(145, 'Mongolia', NULL, '2013-01-30 01:56:12'),
(146, 'Macao', NULL, '2013-01-30 01:56:12'),
(147, 'Northern Mariana Islands', NULL, '2013-01-30 01:56:12'),
(148, 'Martinique', NULL, '2013-01-30 01:56:12'),
(149, 'Mauritania', NULL, '2013-01-30 01:56:12'),
(150, 'Montserrat', NULL, '2013-01-30 01:56:12'),
(151, 'Malta', NULL, '2013-01-30 01:56:12'),
(152, 'Mauritius', NULL, '2013-01-30 01:56:12'),
(153, 'Maldives', NULL, '2013-01-30 01:56:12'),
(154, 'Malawi', NULL, '2013-01-30 01:56:12'),
(155, 'Mexico', NULL, '2013-01-30 01:56:12'),
(156, 'Malaysia', NULL, '2013-01-30 01:56:12'),
(157, 'Mozambique', NULL, '2013-01-30 01:56:12'),
(158, 'Namibia', NULL, '2013-01-30 01:56:12'),
(159, 'New Caledonia', NULL, '2013-01-30 01:56:12'),
(160, 'Niger', NULL, '2013-01-30 01:56:12'),
(161, 'Norfolk Island', NULL, '2013-01-30 01:56:12'),
(162, 'Nigeria', NULL, '2013-01-30 01:56:12'),
(163, 'Nicaragua', NULL, '2013-01-30 01:56:12'),
(164, 'Netherlands', NULL, '2013-01-30 01:56:12'),
(165, 'Norway', NULL, '2013-01-30 01:56:12'),
(166, 'Nepal', NULL, '2013-01-30 01:56:12'),
(167, 'Nauru', NULL, '2013-01-30 01:56:12'),
(168, 'Niue', NULL, '2013-01-30 01:56:12'),
(169, 'New Zealand', NULL, '2013-01-30 01:56:12'),
(170, 'Sultanate of Oman', NULL, '2013-01-30 01:56:12'),
(171, 'Other', NULL, '2013-01-30 01:56:12'),
(172, 'Panama', NULL, '2013-01-30 01:56:12'),
(173, 'Peru', NULL, '2013-01-30 01:56:12'),
(174, 'French Polynesia', NULL, '2013-01-30 01:56:12'),
(175, 'Papua New Guinea', NULL, '2013-01-30 01:56:12'),
(176, 'Philippines', NULL, '2013-01-30 01:56:12'),
(177, 'Pakistan', NULL, '2013-01-30 01:56:12'),
(178, 'Poland', NULL, '2013-01-30 01:56:12'),
(179, 'Saint Pierre and Miquelon', NULL, '2013-01-30 01:56:12'),
(180, 'Pitcairn', NULL, '2013-01-30 01:56:12'),
(181, 'Puerto Rico', NULL, '2013-01-30 01:56:12'),
(182, 'Palestinian Territory', NULL, '2013-01-30 01:56:12'),
(183, 'Portugal', NULL, '2013-01-30 01:56:12'),
(184, 'Palau', NULL, '2013-01-30 01:56:12'),
(185, 'Paraguay', NULL, '2013-01-30 01:56:12'),
(186, 'Qatar', NULL, '2013-01-30 01:56:12'),
(187, 'Reunion', NULL, '2013-01-30 01:56:12'),
(188, 'Romania', NULL, '2013-01-30 01:56:12'),
(189, 'Russian Federation', NULL, '2013-01-30 01:56:12'),
(190, 'Rwanda', NULL, '2013-01-30 01:56:12'),
(191, 'Saudi Arabia', NULL, '2013-01-30 01:56:12'),
(192, 'Solomon Islands', NULL, '2013-01-30 01:56:12'),
(193, 'Seychelles', NULL, '2013-01-30 01:56:12'),
(194, 'Sudan', NULL, '2013-01-30 01:56:12'),
(195, 'Sweden', NULL, '2013-01-30 01:56:12'),
(196, 'Singapore', NULL, '2013-01-30 01:56:12'),
(197, 'Saint Helena', NULL, '2013-01-30 01:56:12'),
(198, 'Slovenia', NULL, '2013-01-30 01:56:12'),
(199, 'Svalbard and Jan Mayen', NULL, '2013-01-30 01:56:12'),
(200, 'Slovak Republic', NULL, '2013-01-30 01:56:12'),
(201, 'Sierra Leone', NULL, '2013-01-30 01:56:12'),
(202, 'San Marino', NULL, '2013-01-30 01:56:12'),
(203, 'Senegal', NULL, '2013-01-30 01:56:12'),
(204, 'Somalia', NULL, '2013-01-30 01:56:12'),
(205, 'Suriname', NULL, '2013-01-30 01:56:12'),
(206, 'Sao Tome and Principe', NULL, '2013-01-30 01:56:12'),
(207, 'El Salvador', NULL, '2013-01-30 01:56:12'),
(208, 'Syria', NULL, '2013-01-30 01:56:12'),
(209, 'Swaziland', NULL, '2013-01-30 01:56:12'),
(210, 'Turks and Caicos Islands', NULL, '2013-01-30 01:56:12'),
(211, 'Chad', NULL, '2013-01-30 01:56:12'),
(212, 'French Southern Territories', NULL, '2013-01-30 01:56:12'),
(213, 'Togo', NULL, '2013-01-30 01:56:12'),
(214, 'Thailand', NULL, '2013-01-30 01:56:12'),
(215, 'Tajikistan', NULL, '2013-01-30 01:56:12'),
(216, 'Tokelau', NULL, '2013-01-30 01:56:12'),
(217, 'Timor-Leste', NULL, '2013-01-30 01:56:12'),
(218, 'Turkmenistan', NULL, '2013-01-30 01:56:12'),
(219, 'Tunisia', NULL, '2013-01-30 01:56:12'),
(220, 'Tonga', NULL, '2013-01-30 01:56:12'),
(221, 'East Timor', NULL, '2013-01-30 01:56:12'),
(222, 'Turkey', NULL, '2013-01-30 01:56:12'),
(223, 'Trinidad and Tobago', NULL, '2013-01-30 01:56:12'),
(224, 'Tuvalu', NULL, '2013-01-30 01:56:12'),
(225, 'Taiwan', NULL, '2013-01-30 01:56:12'),
(226, 'Tanzania', NULL, '2013-01-30 01:56:12'),
(227, 'Ukraine', NULL, '2013-01-30 01:56:12'),
(228, 'Uganda', NULL, '2013-01-30 01:56:12'),
(229, 'United States', NULL, '2013-01-30 01:56:12'),
(230, 'Uruguay', NULL, '2013-01-30 01:56:12'),
(231, 'Uzbekistan', NULL, '2013-01-30 01:56:12'),
(232, 'Vatican City State (Holy See)', NULL, '2013-01-30 01:56:12'),
(233, 'Saint Vincent and the Grenadines', NULL, '2013-01-30 01:56:12'),
(234, 'Venezuela', NULL, '2013-01-30 01:56:12'),
(235, 'Virgin Islands (British)', NULL, '2013-01-30 01:56:12'),
(236, 'Virgin Islands (U.S.)', NULL, '2013-01-30 01:56:12'),
(237, 'Viet Nam', NULL, '2013-01-30 01:56:12'),
(238, 'Vanuatu', NULL, '2013-01-30 01:56:12'),
(239, 'Wallis and Futuna', NULL, '2013-01-30 01:56:12'),
(240, 'Samoa', NULL, '2013-01-30 01:56:12'),
(241, 'Yemen', NULL, '2013-01-30 01:56:12'),
(242, 'Mayotte', NULL, '2013-01-30 01:56:12'),
(243, 'Yugoslavia', NULL, '2013-01-30 01:56:12'),
(244, 'South Africa', NULL, '2013-01-30 01:56:12'),
(245, 'Zambia', NULL, '2013-01-30 01:56:12'),
(246, 'Zimbabwe', NULL, '2013-01-30 01:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `region_county`
--

CREATE TABLE IF NOT EXISTS `region_county` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `country_id` int(11) unsigned DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `region_county`
--


-- --------------------------------------------------------

--
-- Table structure for table `region_streets`
--

CREATE TABLE IF NOT EXISTS `region_streets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `county_id` int(11) unsigned NOT NULL,
  `sub_county_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_county_id` (`sub_county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `region_streets`
--


-- --------------------------------------------------------

--
-- Table structure for table `region_sub_county`
--

CREATE TABLE IF NOT EXISTS `region_sub_county` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `county_id` int(11) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `county_id` (`county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `region_sub_county`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL DEFAULT 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_key` (`category`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `category`, `key`, `value`) VALUES
(1, 'general', 'currency', 's:3:"KES";'),
(2, 'general', 'pagination', 's:2:"30";'),
(3, 'general', 'default_timezone', 's:14:"Africa/Nairobi";'),
(4, 'email', 'email_mailer', 's:4:"smtp";'),
(5, 'email', 'email_sendmail_command', 's:0:"";'),
(6, 'email', 'email_host', 's:22:"mail.smartcounty.co.ke";'),
(7, 'email', 'email_port', 's:3:"465";'),
(8, 'email', 'email_username', 's:25:"noreply@smartcounty.co.ke";'),
(9, 'email', 'email_password', 's:0:"";'),
(10, 'email', 'email_security', 's:3:"ssl";'),
(11, 'email', 'email_master_theme', 's:22:"<p>\r\n	 {content}\r\n</p>";');

-- --------------------------------------------------------

--
-- Table structure for table `settings_country`
--

CREATE TABLE IF NOT EXISTS `settings_country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the county (system generated)',
  `name` varchar(128) NOT NULL COMMENT 'Country name',
  `country_code` varchar(4) DEFAULT NULL COMMENT 'Country code e.g 254 for Kenya',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=247 ;

--
-- Dumping data for table `settings_country`
--

INSERT INTO `settings_country` (`id`, `name`, `country_code`, `date_created`) VALUES
(1, 'Kenya', '254', '2012-12-28 06:07:56'),
(3, 'Andorra', NULL, '2013-01-30 01:56:12'),
(4, 'United Arab Emirates', NULL, '2013-01-30 01:56:12'),
(5, 'Afghanistan', NULL, '2013-01-30 01:56:12'),
(6, 'Antigua and Barbuda', NULL, '2013-01-30 01:56:12'),
(7, 'Anguilla', NULL, '2013-01-30 01:56:12'),
(8, 'Albania', NULL, '2013-01-30 01:56:12'),
(9, 'Armenia', NULL, '2013-01-30 01:56:12'),
(10, 'Netherlands Antilles', NULL, '2013-01-30 01:56:12'),
(11, 'Angola', NULL, '2013-01-30 01:56:12'),
(12, 'Antarctica', NULL, '2013-01-30 01:56:12'),
(13, 'Argentina', NULL, '2013-01-30 01:56:12'),
(14, 'American Samoa', NULL, '2013-01-30 01:56:12'),
(15, 'Austria', NULL, '2013-01-30 01:56:12'),
(16, 'Australia', NULL, '2013-01-30 01:56:12'),
(17, 'Aruba', NULL, '2013-01-30 01:56:12'),
(18, 'Aland Islands', NULL, '2013-01-30 01:56:12'),
(19, 'Azerbaijan', NULL, '2013-01-30 01:56:12'),
(20, 'Bosnia and Herzegovina', NULL, '2013-01-30 01:56:12'),
(21, 'Barbados', NULL, '2013-01-30 01:56:12'),
(22, 'Bangladesh', NULL, '2013-01-30 01:56:12'),
(23, 'Belgium', NULL, '2013-01-30 01:56:12'),
(24, 'Burkina Faso', NULL, '2013-01-30 01:56:12'),
(25, 'Bulgaria', NULL, '2013-01-30 01:56:12'),
(26, 'Bahrain', NULL, '2013-01-30 01:56:12'),
(27, 'Burundi', NULL, '2013-01-30 01:56:12'),
(28, 'Benin', NULL, '2013-01-30 01:56:12'),
(29, 'Bermuda', NULL, '2013-01-30 01:56:12'),
(30, 'Brunei Darussalam', NULL, '2013-01-30 01:56:12'),
(31, 'Bolivia', NULL, '2013-01-30 01:56:12'),
(32, 'Brazil', NULL, '2013-01-30 01:56:12'),
(33, 'Bahamas', NULL, '2013-01-30 01:56:12'),
(34, 'Bhutan', NULL, '2013-01-30 01:56:12'),
(35, 'Bouvet Island', NULL, '2013-01-30 01:56:12'),
(36, 'Botswana', NULL, '2013-01-30 01:56:12'),
(37, 'Belarus', NULL, '2013-01-30 01:56:12'),
(38, 'Belize', NULL, '2013-01-30 01:56:12'),
(39, 'Canada', NULL, '2013-01-30 01:56:12'),
(40, 'Caribbean Nations', NULL, '2013-01-30 01:56:12'),
(41, 'Cocos (Keeling) Islands', NULL, '2013-01-30 01:56:12'),
(42, 'Democratic Republic of the Congo', NULL, '2013-01-30 01:56:12'),
(43, 'Central African Republic', NULL, '2013-01-30 01:56:12'),
(44, 'Congo', NULL, '2013-01-30 01:56:12'),
(45, 'Switzerland', NULL, '2013-01-30 01:56:12'),
(46, 'Cote D''Ivoire', NULL, '2013-01-30 01:56:12'),
(47, 'Cook Islands', NULL, '2013-01-30 01:56:12'),
(48, 'Chile', NULL, '2013-01-30 01:56:12'),
(49, 'Cameroon', NULL, '2013-01-30 01:56:12'),
(50, 'China', NULL, '2013-01-30 01:56:12'),
(51, 'Colombia', NULL, '2013-01-30 01:56:12'),
(52, 'Costa Rica', NULL, '2013-01-30 01:56:12'),
(53, 'Serbia and Montenegro', NULL, '2013-01-30 01:56:12'),
(54, 'Cuba', NULL, '2013-01-30 01:56:12'),
(55, 'Cape Verde', NULL, '2013-01-30 01:56:12'),
(56, 'Christmas Island', NULL, '2013-01-30 01:56:12'),
(57, 'Cyprus', NULL, '2013-01-30 01:56:12'),
(58, 'Czech Republic', NULL, '2013-01-30 01:56:12'),
(59, 'Germany', NULL, '2013-01-30 01:56:12'),
(60, 'Djibouti', NULL, '2013-01-30 01:56:12'),
(61, 'Denmark', NULL, '2013-01-30 01:56:12'),
(62, 'Dominica', NULL, '2013-01-30 01:56:12'),
(63, 'Dominican Republic', NULL, '2013-01-30 01:56:12'),
(64, 'Algeria', NULL, '2013-01-30 01:56:12'),
(65, 'Ecuador', NULL, '2013-01-30 01:56:12'),
(66, 'Estonia', NULL, '2013-01-30 01:56:12'),
(67, 'Egypt', NULL, '2013-01-30 01:56:12'),
(68, 'Western Sahara', NULL, '2013-01-30 01:56:12'),
(69, 'Eritrea', NULL, '2013-01-30 01:56:12'),
(70, 'Spain', NULL, '2013-01-30 01:56:12'),
(71, 'Ethiopia', NULL, '2013-01-30 01:56:12'),
(72, 'Finland', NULL, '2013-01-30 01:56:12'),
(73, 'Fiji', NULL, '2013-01-30 01:56:12'),
(74, 'Falkland Islands (Malvinas)', NULL, '2013-01-30 01:56:12'),
(75, 'Federated States of Micronesia', NULL, '2013-01-30 01:56:12'),
(76, 'Faroe Islands', NULL, '2013-01-30 01:56:12'),
(77, 'France', NULL, '2013-01-30 01:56:12'),
(78, 'France, Metropolitan', NULL, '2013-01-30 01:56:12'),
(79, 'Gabon', NULL, '2013-01-30 01:56:12'),
(80, 'United Kingdom', NULL, '2013-01-30 01:56:12'),
(81, 'Grenada', NULL, '2013-01-30 01:56:12'),
(82, 'Georgia', NULL, '2013-01-30 01:56:12'),
(83, 'French Guiana', NULL, '2013-01-30 01:56:12'),
(84, 'Ghana', NULL, '2013-01-30 01:56:12'),
(85, 'Gibraltar', NULL, '2013-01-30 01:56:12'),
(86, 'Greenland', NULL, '2013-01-30 01:56:12'),
(87, 'Gambia', NULL, '2013-01-30 01:56:12'),
(88, 'Guinea', NULL, '2013-01-30 01:56:12'),
(89, 'Guadeloupe', NULL, '2013-01-30 01:56:12'),
(90, 'Equatorial Guinea', NULL, '2013-01-30 01:56:12'),
(91, 'Greece', NULL, '2013-01-30 01:56:12'),
(92, 'S. Georgia and S. Sandwich Islands', NULL, '2013-01-30 01:56:12'),
(93, 'Guatemala', NULL, '2013-01-30 01:56:12'),
(94, 'Guam', NULL, '2013-01-30 01:56:12'),
(95, 'Guinea-Bissau', NULL, '2013-01-30 01:56:12'),
(96, 'Guyana', NULL, '2013-01-30 01:56:12'),
(97, 'Hong Kong', NULL, '2013-01-30 01:56:12'),
(98, 'Heard Island and McDonald Islands', NULL, '2013-01-30 01:56:12'),
(99, 'Honduras', NULL, '2013-01-30 01:56:12'),
(100, 'Croatia', NULL, '2013-01-30 01:56:12'),
(101, 'Haiti', NULL, '2013-01-30 01:56:12'),
(102, 'Hungary', NULL, '2013-01-30 01:56:12'),
(103, 'Indonesia', NULL, '2013-01-30 01:56:12'),
(104, 'Ireland', NULL, '2013-01-30 01:56:12'),
(105, 'Israel', NULL, '2013-01-30 01:56:12'),
(106, 'India', NULL, '2013-01-30 01:56:12'),
(107, 'British Indian Ocean Territory', NULL, '2013-01-30 01:56:12'),
(108, 'Iraq', NULL, '2013-01-30 01:56:12'),
(109, 'Iran', NULL, '2013-01-30 01:56:12'),
(110, 'Iceland', NULL, '2013-01-30 01:56:12'),
(111, 'Italy', NULL, '2013-01-30 01:56:12'),
(112, 'Jamaica', NULL, '2013-01-30 01:56:12'),
(113, 'Jordan', NULL, '2013-01-30 01:56:12'),
(114, 'Japan', NULL, '2013-01-30 01:56:12'),
(115, 'Kenya', NULL, '2013-01-30 01:56:12'),
(116, 'Kyrgyzstan', NULL, '2013-01-30 01:56:12'),
(117, 'Cambodia', NULL, '2013-01-30 01:56:12'),
(118, 'Kiribati', NULL, '2013-01-30 01:56:12'),
(119, 'Comoros', NULL, '2013-01-30 01:56:12'),
(120, 'Saint Kitts and Nevis', NULL, '2013-01-30 01:56:12'),
(121, 'Korea (North)', NULL, '2013-01-30 01:56:12'),
(122, 'Korea', NULL, '2013-01-30 01:56:12'),
(123, 'Kuwait', NULL, '2013-01-30 01:56:12'),
(124, 'Cayman Islands', NULL, '2013-01-30 01:56:12'),
(125, 'Kazakhstan', NULL, '2013-01-30 01:56:12'),
(126, 'Laos', NULL, '2013-01-30 01:56:12'),
(127, 'Lebanon', NULL, '2013-01-30 01:56:12'),
(128, 'Saint Lucia', NULL, '2013-01-30 01:56:12'),
(129, 'Liechtenstein', NULL, '2013-01-30 01:56:12'),
(130, 'Sri Lanka', NULL, '2013-01-30 01:56:12'),
(131, 'Liberia', NULL, '2013-01-30 01:56:12'),
(132, 'Lesotho', NULL, '2013-01-30 01:56:12'),
(133, 'Lithuania', NULL, '2013-01-30 01:56:12'),
(134, 'Luxembourg', NULL, '2013-01-30 01:56:12'),
(135, 'Latvia', NULL, '2013-01-30 01:56:12'),
(136, 'Libya', NULL, '2013-01-30 01:56:12'),
(137, 'Morocco', NULL, '2013-01-30 01:56:12'),
(138, 'Monaco', NULL, '2013-01-30 01:56:12'),
(139, 'Moldova', NULL, '2013-01-30 01:56:12'),
(140, 'Madagascar', NULL, '2013-01-30 01:56:12'),
(141, 'Marshall Islands', NULL, '2013-01-30 01:56:12'),
(142, 'Macedonia', NULL, '2013-01-30 01:56:12'),
(143, 'Mali', NULL, '2013-01-30 01:56:12'),
(144, 'Myanmar', NULL, '2013-01-30 01:56:12'),
(145, 'Mongolia', NULL, '2013-01-30 01:56:12'),
(146, 'Macao', NULL, '2013-01-30 01:56:12'),
(147, 'Northern Mariana Islands', NULL, '2013-01-30 01:56:12'),
(148, 'Martinique', NULL, '2013-01-30 01:56:12'),
(149, 'Mauritania', NULL, '2013-01-30 01:56:12'),
(150, 'Montserrat', NULL, '2013-01-30 01:56:12'),
(151, 'Malta', NULL, '2013-01-30 01:56:12'),
(152, 'Mauritius', NULL, '2013-01-30 01:56:12'),
(153, 'Maldives', NULL, '2013-01-30 01:56:12'),
(154, 'Malawi', NULL, '2013-01-30 01:56:12'),
(155, 'Mexico', NULL, '2013-01-30 01:56:12'),
(156, 'Malaysia', NULL, '2013-01-30 01:56:12'),
(157, 'Mozambique', NULL, '2013-01-30 01:56:12'),
(158, 'Namibia', NULL, '2013-01-30 01:56:12'),
(159, 'New Caledonia', NULL, '2013-01-30 01:56:12'),
(160, 'Niger', NULL, '2013-01-30 01:56:12'),
(161, 'Norfolk Island', NULL, '2013-01-30 01:56:12'),
(162, 'Nigeria', NULL, '2013-01-30 01:56:12'),
(163, 'Nicaragua', NULL, '2013-01-30 01:56:12'),
(164, 'Netherlands', NULL, '2013-01-30 01:56:12'),
(165, 'Norway', NULL, '2013-01-30 01:56:12'),
(166, 'Nepal', NULL, '2013-01-30 01:56:12'),
(167, 'Nauru', NULL, '2013-01-30 01:56:12'),
(168, 'Niue', NULL, '2013-01-30 01:56:12'),
(169, 'New Zealand', NULL, '2013-01-30 01:56:12'),
(170, 'Sultanate of Oman', NULL, '2013-01-30 01:56:12'),
(171, 'Other', NULL, '2013-01-30 01:56:12'),
(172, 'Panama', NULL, '2013-01-30 01:56:12'),
(173, 'Peru', NULL, '2013-01-30 01:56:12'),
(174, 'French Polynesia', NULL, '2013-01-30 01:56:12'),
(175, 'Papua New Guinea', NULL, '2013-01-30 01:56:12'),
(176, 'Philippines', NULL, '2013-01-30 01:56:12'),
(177, 'Pakistan', NULL, '2013-01-30 01:56:12'),
(178, 'Poland', NULL, '2013-01-30 01:56:12'),
(179, 'Saint Pierre and Miquelon', NULL, '2013-01-30 01:56:12'),
(180, 'Pitcairn', NULL, '2013-01-30 01:56:12'),
(181, 'Puerto Rico', NULL, '2013-01-30 01:56:12'),
(182, 'Palestinian Territory', NULL, '2013-01-30 01:56:12'),
(183, 'Portugal', NULL, '2013-01-30 01:56:12'),
(184, 'Palau', NULL, '2013-01-30 01:56:12'),
(185, 'Paraguay', NULL, '2013-01-30 01:56:12'),
(186, 'Qatar', NULL, '2013-01-30 01:56:12'),
(187, 'Reunion', NULL, '2013-01-30 01:56:12'),
(188, 'Romania', NULL, '2013-01-30 01:56:12'),
(189, 'Russian Federation', NULL, '2013-01-30 01:56:12'),
(190, 'Rwanda', NULL, '2013-01-30 01:56:12'),
(191, 'Saudi Arabia', NULL, '2013-01-30 01:56:12'),
(192, 'Solomon Islands', NULL, '2013-01-30 01:56:12'),
(193, 'Seychelles', NULL, '2013-01-30 01:56:12'),
(194, 'Sudan', NULL, '2013-01-30 01:56:12'),
(195, 'Sweden', NULL, '2013-01-30 01:56:12'),
(196, 'Singapore', NULL, '2013-01-30 01:56:12'),
(197, 'Saint Helena', NULL, '2013-01-30 01:56:12'),
(198, 'Slovenia', NULL, '2013-01-30 01:56:12'),
(199, 'Svalbard and Jan Mayen', NULL, '2013-01-30 01:56:12'),
(200, 'Slovak Republic', NULL, '2013-01-30 01:56:12'),
(201, 'Sierra Leone', NULL, '2013-01-30 01:56:12'),
(202, 'San Marino', NULL, '2013-01-30 01:56:12'),
(203, 'Senegal', NULL, '2013-01-30 01:56:12'),
(204, 'Somalia', NULL, '2013-01-30 01:56:12'),
(205, 'Suriname', NULL, '2013-01-30 01:56:12'),
(206, 'Sao Tome and Principe', NULL, '2013-01-30 01:56:12'),
(207, 'El Salvador', NULL, '2013-01-30 01:56:12'),
(208, 'Syria', NULL, '2013-01-30 01:56:12'),
(209, 'Swaziland', NULL, '2013-01-30 01:56:12'),
(210, 'Turks and Caicos Islands', NULL, '2013-01-30 01:56:12'),
(211, 'Chad', NULL, '2013-01-30 01:56:12'),
(212, 'French Southern Territories', NULL, '2013-01-30 01:56:12'),
(213, 'Togo', NULL, '2013-01-30 01:56:12'),
(214, 'Thailand', NULL, '2013-01-30 01:56:12'),
(215, 'Tajikistan', NULL, '2013-01-30 01:56:12'),
(216, 'Tokelau', NULL, '2013-01-30 01:56:12'),
(217, 'Timor-Leste', NULL, '2013-01-30 01:56:12'),
(218, 'Turkmenistan', NULL, '2013-01-30 01:56:12'),
(219, 'Tunisia', NULL, '2013-01-30 01:56:12'),
(220, 'Tonga', NULL, '2013-01-30 01:56:12'),
(221, 'East Timor', NULL, '2013-01-30 01:56:12'),
(222, 'Turkey', NULL, '2013-01-30 01:56:12'),
(223, 'Trinidad and Tobago', NULL, '2013-01-30 01:56:12'),
(224, 'Tuvalu', NULL, '2013-01-30 01:56:12'),
(225, 'Taiwan', NULL, '2013-01-30 01:56:12'),
(226, 'Tanzania', NULL, '2013-01-30 01:56:12'),
(227, 'Ukraine', NULL, '2013-01-30 01:56:12'),
(228, 'Uganda', NULL, '2013-01-30 01:56:12'),
(229, 'United States', NULL, '2013-01-30 01:56:12'),
(230, 'Uruguay', NULL, '2013-01-30 01:56:12'),
(231, 'Uzbekistan', NULL, '2013-01-30 01:56:12'),
(232, 'Vatican City State (Holy See)', NULL, '2013-01-30 01:56:12'),
(233, 'Saint Vincent and the Grenadines', NULL, '2013-01-30 01:56:12'),
(234, 'Venezuela', NULL, '2013-01-30 01:56:12'),
(235, 'Virgin Islands (British)', NULL, '2013-01-30 01:56:12'),
(236, 'Virgin Islands (U.S.)', NULL, '2013-01-30 01:56:12'),
(237, 'Viet Nam', NULL, '2013-01-30 01:56:12'),
(238, 'Vanuatu', NULL, '2013-01-30 01:56:12'),
(239, 'Wallis and Futuna', NULL, '2013-01-30 01:56:12'),
(240, 'Samoa', NULL, '2013-01-30 01:56:12'),
(241, 'Yemen', NULL, '2013-01-30 01:56:12'),
(242, 'Mayotte', NULL, '2013-01-30 01:56:12'),
(243, 'Yugoslavia', NULL, '2013-01-30 01:56:12'),
(244, 'South Africa', NULL, '2013-01-30 01:56:12'),
(245, 'Zambia', NULL, '2013-01-30 01:56:12'),
(246, 'Zimbabwe', NULL, '2013-01-30 01:56:12');

-- --------------------------------------------------------

--
-- Table structure for table `settings_currency`
--

CREATE TABLE IF NOT EXISTS `settings_currency` (
  `id` varchar(60) NOT NULL,
  `symbol` varchar(30) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  UNIQUE KEY `name` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings_currency`
--

INSERT INTO `settings_currency` (`id`, `symbol`, `date_created`, `created_by`) VALUES
('KES', 'KSh. ', '2013-10-11 04:07:05', NULL),
('USD', '''&dollar;''', '2014-01-21 14:43:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings_email_template`
--

CREATE TABLE IF NOT EXISTS `settings_email_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `description` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `from` varchar(255) NOT NULL,
  `comments` text,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `settings_email_template`
--

INSERT INTO `settings_email_template` (`id`, `key`, `description`, `subject`, `body`, `from`, `comments`, `date_created`, `created_by`) VALUES
(2, 'admin_reset_password', 'Email sent to a user when the admin resets the user''s password', 'New Password', 'Hi {name}, You Password has been reset by the web master.Here are your new login details\r\n<ul>\r\n	<li>Username: <strong>{username}</strong> or <strong>{email}</strong></li>\r\n	<li>Password: <strong>{password}</strong></li>\r\n</ul>\r\n       To login now please <a target="_blank" rel="nofollow" href="http://{link}">click here</a> or copy and paste this link to your browser: {link} <br>\r\n <br>\r\n<p>\r\n	      Smart County Team.\r\n</p>', 'noreply@toamaoni.co.ke', 'Placeholders: {name}=> The Admin full name, {username}=>admin username, {email}=>admin email,{password} => The new password, {link}=> Login link ', '2013-09-27 16:43:30', 2),
(3, 'forgot_password', 'Email sent to a user who forgot his/her password to asssist in password recovery', 'Password Recovery', '<p>\r\n	  Hello {name},\r\n</p>\r\n  Please <a target="_blank" rel="nofollow" href="http://{link}">click here</a> or copy and paste this link: {link} to your browser to change your password.<br>\r\n<p>\r\n	    If you never initiated this password recovery process, please just ignore this email.\r\n</p>\r\n<p>\r\n	  Smart County Team\r\n</p>', 'noreply@toamaoni.co.ke', 'Placehoders: {name}=>The name of the user, {link}=>link for reseting password', '2013-09-27 16:43:48', 2),
(5, 'new_user', 'Email sent to a new user when informing the user of his/her new account.', 'Login Details', '<p>\r\n	     Hi {name},\r\n</p>\r\n<p>\r\n	     Your account for {site_name} has been created. These are your login details:\r\n</p>\r\n<ul>\r\n	<li>Username :<strong>{username}</strong> or <strong>{email}</strong></li>\r\n	<li>Password:<strong>{password}</strong></li>\r\n</ul>\r\n      To login now please  <a target="_blank" rel="nofollow" href="http://{link}">click here</a>\r\n<p>\r\n	  or copy and paste this link to your browser: {link}\r\n</p>\r\n<p>\r\n	Smart County Team\r\n</p>', 'noreply@toamaoni.co.ke', NULL, '2013-12-17 03:58:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings_timezone`
--

CREATE TABLE IF NOT EXISTS `settings_timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=462 ;

--
-- Dumping data for table `settings_timezone`
--

INSERT INTO `settings_timezone` (`id`, `name`) VALUES
(2, 'Africa/Abidjan'),
(3, 'Africa/Accra'),
(4, 'Africa/Addis_Ababa'),
(5, 'Africa/Algiers'),
(6, 'Africa/Asmara'),
(7, 'Africa/Asmera'),
(8, 'Africa/Bamako'),
(9, 'Africa/Bangui'),
(10, 'Africa/Banjul'),
(11, 'Africa/Bissau'),
(12, 'Africa/Blantyre'),
(13, 'Africa/Brazzaville'),
(14, 'Africa/Bujumbura'),
(15, 'Africa/Cairo'),
(16, 'Africa/Casablanca'),
(17, 'Africa/Ceuta'),
(18, 'Africa/Conakry'),
(19, 'Africa/Dakar'),
(20, 'Africa/Dar_es_Salaam'),
(21, 'Africa/Djibouti'),
(22, 'Africa/Douala'),
(23, 'Africa/El_Aaiun'),
(24, 'Africa/Freetown'),
(25, 'Africa/Gaborone'),
(26, 'Africa/Harare'),
(27, 'Africa/Johannesburg'),
(28, 'Africa/Kampala'),
(29, 'Africa/Khartoum'),
(30, 'Africa/Kigali'),
(31, 'Africa/Kinshasa'),
(32, 'Africa/Lagos'),
(33, 'Africa/Libreville'),
(34, 'Africa/Lome'),
(35, 'Africa/Luanda'),
(36, 'Africa/Lubumbashi'),
(37, 'Africa/Lusaka'),
(38, 'Africa/Malabo'),
(39, 'Africa/Maputo'),
(40, 'Africa/Maseru'),
(41, 'Africa/Mbabane'),
(42, 'Africa/Mogadishu'),
(43, 'Africa/Monrovia'),
(44, 'Africa/Nairobi'),
(45, 'Africa/Ndjamena'),
(46, 'Africa/Niamey'),
(47, 'Africa/Nouakchott'),
(48, 'Africa/Ouagadougou'),
(49, 'Africa/Porto-Novo'),
(50, 'Africa/Sao_Tome'),
(51, 'Africa/Timbuktu'),
(52, 'Africa/Tripoli'),
(53, 'Africa/Tunis'),
(54, 'Africa/Windhoek'),
(55, 'America/Adak'),
(56, 'America/Anchorage'),
(57, 'America/Anguilla'),
(58, 'America/Antigua'),
(59, 'America/Araguaina'),
(60, 'America/Argentina/Buenos_Aires'),
(61, 'America/Argentina/Catamarca'),
(62, 'America/Argentina/ComodRivadavia'),
(63, 'America/Argentina/Cordoba'),
(64, 'America/Argentina/Jujuy'),
(65, 'America/Argentina/La_Rioja'),
(66, 'America/Argentina/Mendoza'),
(67, 'America/Argentina/Rio_Gallegos'),
(68, 'America/Argentina/Salta'),
(69, 'America/Argentina/San_Juan'),
(70, 'America/Argentina/San_Luis'),
(71, 'America/Argentina/Tucuman'),
(72, 'America/Argentina/Ushuaia'),
(73, 'America/Aruba'),
(74, 'America/Asuncion'),
(75, 'America/Atikokan'),
(76, 'America/Atka'),
(77, 'America/Bahia'),
(78, 'America/Bahia_Banderas'),
(79, 'America/Barbados'),
(80, 'America/Belem'),
(81, 'America/Belize'),
(82, 'America/Blanc-Sablon'),
(83, 'America/Boa_Vista'),
(84, 'America/Bogota'),
(85, 'America/Boise'),
(86, 'America/Buenos_Aires'),
(87, 'America/Cambridge_Bay'),
(88, 'America/Campo_Grande'),
(89, 'America/Cancun'),
(90, 'America/Caracas'),
(91, 'America/Catamarca'),
(92, 'America/Cayenne'),
(93, 'America/Cayman'),
(94, 'America/Chicago'),
(95, 'America/Chihuahua'),
(96, 'America/Coral_Harbour'),
(97, 'America/Cordoba'),
(98, 'America/Costa_Rica'),
(99, 'America/Cuiaba'),
(100, 'America/Curacao'),
(101, 'America/Danmarkshavn'),
(102, 'America/Dawson'),
(103, 'America/Dawson_Creek'),
(104, 'America/Denver'),
(105, 'America/Detroit'),
(106, 'America/Dominica'),
(107, 'America/Edmonton'),
(108, 'America/Eirunepe'),
(109, 'America/El_Salvador'),
(110, 'America/Ensenada'),
(111, 'America/Fortaleza'),
(112, 'America/Fort_Wayne'),
(113, 'America/Glace_Bay'),
(114, 'America/Godthab'),
(115, 'America/Goose_Bay'),
(116, 'America/Grand_Turk'),
(117, 'America/Grenada'),
(118, 'America/Guadeloupe'),
(119, 'America/Guatemala'),
(120, 'America/Guayaquil'),
(121, 'America/Guyana'),
(122, 'America/Halifax'),
(123, 'America/Havana'),
(124, 'America/Hermosillo'),
(125, 'America/Indiana/Indianapolis'),
(126, 'America/Indiana/Knox'),
(127, 'America/Indiana/Marengo'),
(128, 'America/Indiana/Petersburg'),
(129, 'America/Indianapolis'),
(130, 'America/Indiana/Tell_City'),
(131, 'America/Indiana/Vevay'),
(132, 'America/Indiana/Vincennes'),
(133, 'America/Indiana/Winamac'),
(134, 'America/Inuvik'),
(135, 'America/Iqaluit'),
(136, 'America/Jamaica'),
(137, 'America/Jujuy'),
(138, 'America/Juneau'),
(139, 'America/Kentucky/Louisville'),
(140, 'America/Kentucky/Monticello'),
(141, 'America/Knox_IN'),
(142, 'America/La_Paz'),
(143, 'America/Lima'),
(144, 'America/Los_Angeles'),
(145, 'America/Louisville'),
(146, 'America/Maceio'),
(147, 'America/Managua'),
(148, 'America/Manaus'),
(149, 'America/Marigot'),
(150, 'America/Martinique'),
(151, 'America/Matamoros'),
(152, 'America/Mazatlan'),
(153, 'America/Mendoza'),
(154, 'America/Menominee'),
(155, 'America/Merida'),
(156, 'America/Metlakatla'),
(157, 'America/Mexico_City'),
(158, 'America/Miquelon'),
(159, 'America/Moncton'),
(160, 'America/Monterrey'),
(161, 'America/Montevideo'),
(162, 'America/Montreal'),
(163, 'America/Montserrat'),
(164, 'America/Nassau'),
(165, 'America/New_York'),
(166, 'America/Nipigon'),
(167, 'America/Nome'),
(168, 'America/Noronha'),
(169, 'America/North_Dakota/Beulah'),
(170, 'America/North_Dakota/Center'),
(171, 'America/North_Dakota/New_Salem'),
(172, 'America/Ojinaga'),
(173, 'America/Panama'),
(174, 'America/Pangnirtung'),
(175, 'America/Paramaribo'),
(176, 'America/Phoenix'),
(177, 'America/Port-au-Prince'),
(178, 'America/Porto_Acre'),
(179, 'America/Port_of_Spain'),
(180, 'America/Porto_Velho'),
(181, 'America/Puerto_Rico'),
(182, 'America/Rainy_River'),
(183, 'America/Rankin_Inlet'),
(184, 'America/Recife'),
(185, 'America/Regina'),
(186, 'America/Resolute'),
(187, 'America/Rio_Branco'),
(188, 'America/Rosario'),
(189, 'America/Santa_Isabel'),
(190, 'America/Santarem'),
(191, 'America/Santiago'),
(192, 'America/Santo_Domingo'),
(193, 'America/Sao_Paulo'),
(194, 'America/Scoresbysund'),
(195, 'America/Shiprock'),
(196, 'America/Sitka'),
(197, 'America/St_Barthelemy'),
(198, 'America/St_Johns'),
(199, 'America/St_Kitts'),
(200, 'America/St_Lucia'),
(201, 'America/St_Thomas'),
(202, 'America/St_Vincent'),
(203, 'America/Swift_Current'),
(204, 'America/Tegucigalpa'),
(205, 'America/Thule'),
(206, 'America/Thunder_Bay'),
(207, 'America/Tijuana'),
(208, 'America/Toronto'),
(209, 'America/Tortola'),
(210, 'America/Vancouver'),
(211, 'America/Virgin'),
(212, 'America/Whitehorse'),
(213, 'America/Winnipeg'),
(214, 'America/Yakutat'),
(215, 'America/Yellowknife'),
(216, 'Antarctica/Casey'),
(217, 'Antarctica/Davis'),
(218, 'Antarctica/DumontDUrville'),
(219, 'Antarctica/Macquarie'),
(220, 'Antarctica/Mawson'),
(221, 'Antarctica/McMurdo'),
(222, 'Antarctica/Palmer'),
(223, 'Antarctica/Rothera'),
(224, 'Antarctica/South_Pole'),
(225, 'Antarctica/Syowa'),
(226, 'Antarctica/Vostok'),
(227, 'Arctic/Longyearbyen'),
(228, 'Asia/Aden'),
(229, 'Asia/Almaty'),
(230, 'Asia/Amman'),
(231, 'Asia/Anadyr'),
(232, 'Asia/Aqtau'),
(233, 'Asia/Aqtobe'),
(234, 'Asia/Ashgabat'),
(235, 'Asia/Ashkhabad'),
(236, 'Asia/Baghdad'),
(237, 'Asia/Bahrain'),
(238, 'Asia/Baku'),
(239, 'Asia/Bangkok'),
(240, 'Asia/Beirut'),
(241, 'Asia/Bishkek'),
(242, 'Asia/Brunei'),
(243, 'Asia/Calcutta'),
(244, 'Asia/Choibalsan'),
(245, 'Asia/Chongqing'),
(246, 'Asia/Chungking'),
(247, 'Asia/Colombo'),
(248, 'Asia/Dacca'),
(249, 'Asia/Damascus'),
(250, 'Asia/Dhaka'),
(251, 'Asia/Dili'),
(252, 'Asia/Dubai'),
(253, 'Asia/Dushanbe'),
(254, 'Asia/Gaza'),
(255, 'Asia/Harbin'),
(256, 'Asia/Ho_Chi_Minh'),
(257, 'Asia/Hong_Kong'),
(258, 'Asia/Hovd'),
(259, 'Asia/Irkutsk'),
(260, 'Asia/Istanbul'),
(261, 'Asia/Jakarta'),
(262, 'Asia/Jayapura'),
(263, 'Asia/Jerusalem'),
(264, 'Asia/Kabul'),
(265, 'Asia/Kamchatka'),
(266, 'Asia/Karachi'),
(267, 'Asia/Kashgar'),
(268, 'Asia/Kathmandu'),
(269, 'Asia/Katmandu'),
(270, 'Asia/Kolkata'),
(271, 'Asia/Krasnoyarsk'),
(272, 'Asia/Kuala_Lumpur'),
(273, 'Asia/Kuching'),
(274, 'Asia/Kuwait'),
(275, 'Asia/Macao'),
(276, 'Asia/Macau'),
(277, 'Asia/Magadan'),
(278, 'Asia/Makassar'),
(279, 'Asia/Manila'),
(280, 'Asia/Muscat'),
(281, 'Asia/Nicosia'),
(282, 'Asia/Novokuznetsk'),
(283, 'Asia/Novosibirsk'),
(284, 'Asia/Omsk'),
(285, 'Asia/Oral'),
(286, 'Asia/Phnom_Penh'),
(287, 'Asia/Pontianak'),
(288, 'Asia/Pyongyang'),
(289, 'Asia/Qatar'),
(290, 'Asia/Qyzylorda'),
(291, 'Asia/Rangoon'),
(292, 'Asia/Riyadh'),
(293, 'Asia/Saigon'),
(294, 'Asia/Sakhalin'),
(295, 'Asia/Samarkand'),
(296, 'Asia/Seoul'),
(297, 'Asia/Shanghai'),
(298, 'Asia/Singapore'),
(299, 'Asia/Taipei'),
(300, 'Asia/Tashkent'),
(301, 'Asia/Tbilisi'),
(302, 'Asia/Tehran'),
(303, 'Asia/Tel_Aviv'),
(304, 'Asia/Thimbu'),
(305, 'Asia/Thimphu'),
(306, 'Asia/Tokyo'),
(307, 'Asia/Ujung_Pandang'),
(308, 'Asia/Ulaanbaatar'),
(309, 'Asia/Ulan_Bator'),
(310, 'Asia/Urumqi'),
(311, 'Asia/Vientiane'),
(312, 'Asia/Vladivostok'),
(313, 'Asia/Yakutsk'),
(314, 'Asia/Yekaterinburg'),
(315, 'Asia/Yerevan'),
(316, 'Atlantic/Azores'),
(317, 'Atlantic/Bermuda'),
(318, 'Atlantic/Canary'),
(319, 'Atlantic/Cape_Verde'),
(320, 'Atlantic/Faeroe'),
(321, 'Atlantic/Faroe'),
(322, 'Atlantic/Jan_Mayen'),
(323, 'Atlantic/Madeira'),
(324, 'Atlantic/Reykjavik'),
(325, 'Atlantic/South_Georgia'),
(326, 'Atlantic/Stanley'),
(327, 'Atlantic/St_Helena'),
(328, 'Australia/ACT'),
(329, 'Australia/Adelaide'),
(330, 'Australia/Brisbane'),
(331, 'Australia/Broken_Hill'),
(332, 'Australia/Canberra'),
(333, 'Australia/Currie'),
(334, 'Australia/Darwin'),
(335, 'Australia/Eucla'),
(336, 'Australia/Hobart'),
(337, 'Australia/LHI'),
(338, 'Australia/Lindeman'),
(339, 'Australia/Lord_Howe'),
(340, 'Australia/Melbourne'),
(341, 'Australia/North'),
(342, 'Australia/NSW'),
(343, 'Australia/Perth'),
(344, 'Australia/Queensland'),
(345, 'Australia/South'),
(346, 'Australia/Sydney'),
(347, 'Australia/Tasmania'),
(348, 'Australia/Victoria'),
(349, 'Australia/West'),
(350, 'Australia/Yancowinna'),
(351, 'Europe/Amsterdam'),
(352, 'Europe/Andorra'),
(353, 'Europe/Athens'),
(354, 'Europe/Belfast'),
(355, 'Europe/Belgrade'),
(356, 'Europe/Berlin'),
(357, 'Europe/Bratislava'),
(358, 'Europe/Brussels'),
(359, 'Europe/Bucharest'),
(360, 'Europe/Budapest'),
(361, 'Europe/Chisinau'),
(362, 'Europe/Copenhagen'),
(363, 'Europe/Dublin'),
(364, 'Europe/Gibraltar'),
(365, 'Europe/Guernsey'),
(366, 'Europe/Helsinki'),
(367, 'Europe/Isle_of_Man'),
(368, 'Europe/Istanbul'),
(369, 'Europe/Jersey'),
(370, 'Europe/Kaliningrad'),
(371, 'Europe/Kiev'),
(372, 'Europe/Lisbon'),
(373, 'Europe/Ljubljana'),
(374, 'Europe/London'),
(375, 'Europe/Luxembourg'),
(376, 'Europe/Madrid'),
(377, 'Europe/Malta'),
(378, 'Europe/Mariehamn'),
(379, 'Europe/Minsk'),
(380, 'Europe/Monaco'),
(381, 'Europe/Moscow'),
(382, 'Europe/Nicosia'),
(383, 'Europe/Oslo'),
(384, 'Europe/Paris'),
(385, 'Europe/Podgorica'),
(386, 'Europe/Prague'),
(387, 'Europe/Riga'),
(388, 'Europe/Rome'),
(389, 'Europe/Samara'),
(390, 'Europe/San_Marino'),
(391, 'Europe/Sarajevo'),
(392, 'Europe/Simferopol'),
(393, 'Europe/Skopje'),
(394, 'Europe/Sofia'),
(395, 'Europe/Stockholm'),
(396, 'Europe/Tallinn'),
(397, 'Europe/Tirane'),
(398, 'Europe/Tiraspol'),
(399, 'Europe/Uzhgorod'),
(400, 'Europe/Vaduz'),
(401, 'Europe/Vatican'),
(402, 'Europe/Vienna'),
(403, 'Europe/Vilnius'),
(404, 'Europe/Volgograd'),
(405, 'Europe/Warsaw'),
(406, 'Europe/Zagreb'),
(407, 'Europe/Zaporozhye'),
(408, 'Europe/Zurich'),
(409, 'Indian/Antananarivo'),
(410, 'Indian/Chagos'),
(411, 'Indian/Christmas'),
(412, 'Indian/Cocos'),
(413, 'Indian/Comoro'),
(414, 'Indian/Kerguelen'),
(415, 'Indian/Mahe'),
(416, 'Indian/Maldives'),
(417, 'Indian/Mauritius'),
(418, 'Indian/Mayotte'),
(419, 'Indian/Reunion'),
(420, 'Pacific/Apia'),
(421, 'Pacific/Auckland'),
(422, 'Pacific/Chatham'),
(423, 'Pacific/Chuuk'),
(424, 'Pacific/Easter'),
(425, 'Pacific/Efate'),
(426, 'Pacific/Enderbury'),
(427, 'Pacific/Fakaofo'),
(428, 'Pacific/Fiji'),
(429, 'Pacific/Funafuti'),
(430, 'Pacific/Galapagos'),
(431, 'Pacific/Gambier'),
(432, 'Pacific/Guadalcanal'),
(433, 'Pacific/Guam'),
(434, 'Pacific/Honolulu'),
(435, 'Pacific/Johnston'),
(436, 'Pacific/Kiritimati'),
(437, 'Pacific/Kosrae'),
(438, 'Pacific/Kwajalein'),
(439, 'Pacific/Majuro'),
(440, 'Pacific/Marquesas'),
(441, 'Pacific/Midway'),
(442, 'Pacific/Nauru'),
(443, 'Pacific/Niue'),
(444, 'Pacific/Norfolk'),
(445, 'Pacific/Noumea'),
(446, 'Pacific/Pago_Pago'),
(447, 'Pacific/Palau'),
(448, 'Pacific/Pitcairn'),
(449, 'Pacific/Pohnpei'),
(450, 'Pacific/Ponape'),
(451, 'Pacific/Port_Moresby'),
(452, 'Pacific/Rarotonga'),
(453, 'Pacific/Saipan'),
(454, 'Pacific/Samoa'),
(455, 'Pacific/Tahiti'),
(456, 'Pacific/Tarawa'),
(457, 'Pacific/Tongatapu'),
(458, 'Pacific/Truk'),
(459, 'Pacific/Wake'),
(460, 'Pacific/Wallis'),
(461, 'Pacific/Yap');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(128) NOT NULL,
  `status` enum('Pending','Active','Blocked') NOT NULL DEFAULT 'Pending',
  `timezone` varchar(60) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `password_reset_code` varchar(128) DEFAULT NULL,
  `password_reset_date` timestamp NULL DEFAULT NULL,
  `password_reset_request_date` timestamp NULL DEFAULT NULL,
  `activation_code` varchar(128) DEFAULT NULL,
  `user_level` varchar(30) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  `last_modified_by` int(11) unsigned DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `user_level` (`user_level`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `status`, `timezone`, `password`, `salt`, `password_reset_code`, `password_reset_date`, `password_reset_request_date`, `activation_code`, `user_level`, `role_id`, `date_created`, `created_by`, `last_modified`, `last_modified_by`, `last_login`) VALUES
(1, 'mconyango', 'mconyango@gmail.com', 'Active', 'Africa/Nairobi', 'werwsa453dsss5648bd8a859690b9e779633714ee5ff072', 'werwsa453dsss56', NULL, '2014-02-09 02:49:14', '2014-02-09 02:48:16', NULL, 'ENGINEER', NULL, '2014-02-05 13:56:19', NULL, '2014-02-09 02:49:14', NULL, '2014-02-27 09:13:17'),
(3, 'felix', 'felixaduol@gmail.com', 'Active', 'Africa/Nairobi', 'd7a0af2f6273d550b0da5760ff0a64052c44ad431a00ace027a2b6aff900bc61', 'd7a0af2f6273d550b0da5760ff0a6405', NULL, NULL, NULL, NULL, 'ENGINEER', NULL, '2014-02-07 06:12:33', 1, NULL, NULL, NULL),
(4, 'beatrice', 'beatrice.agness@gmail.com', 'Active', 'Africa/Nairobi', '476da4f349243ed7b13f9676b1950fdd4b5eca934fff80a76f8725a5025a0dd2', '476da4f349243ed7b13f9676b1950fdd', NULL, NULL, NULL, NULL, 'SUPERADMIN', NULL, '2014-02-07 06:14:14', 1, NULL, NULL, NULL),
(5, 'bahati', 'bahati@gmail.com', 'Active', 'Africa/Nairobi', '6a430609a32f29f64ec1aba62de26f1b690dfe6e43fe7595d9027e19b582e731', '6a430609a32f29f64ec1aba62de26f1b', NULL, NULL, NULL, NULL, 'ADMIN', 1, '2014-02-08 12:47:43', 1, '2014-02-08 15:10:51', 1, NULL),
(7, 'Fredrick', 'fred@btimillman.com', 'Active', 'Africa/Nairobi', '1a87f18e382a75fe662b366a28443c9d48bd8a859690b9e779633714ee5ff072', '1a87f18e382a75fe662b366a28443c9d', NULL, NULL, NULL, NULL, 'MEMBER', NULL, '2014-02-10 02:34:43', NULL, '2014-02-10 03:01:05', 7, '2014-02-10 03:00:05'),
(8, 'Fredrick2', 'fred2@btimillman.com', 'Active', 'Africa/Nairobi', 'a18f67824427eecafca5cf633bbe91e8adaae7db1cf8f96865f6f49944e595e8', 'a18f67824427eecafca5cf633bbe91e8', NULL, NULL, NULL, NULL, 'SUPERADMIN', NULL, '2014-02-10 08:31:58', 1, NULL, NULL, NULL),
(9, 'martin', 'martin@webskenyaa.co.ke', 'Active', 'Africa/Nairobi', '79b4d98e9155ac2b9f7c7d80e4b8bfdf7133a1473bbd9f77f6325118f5e9294b', '79b4d98e9155ac2b9f7c7d80e4b8bfdf', NULL, NULL, NULL, NULL, 'ENGINEER', NULL, '2014-02-27 09:16:11', 1, NULL, NULL, '2014-04-29 02:03:38');

-- --------------------------------------------------------

--
-- Stand-in structure for view `users_view`
--
CREATE TABLE IF NOT EXISTS `users_view` (
`id` int(11) unsigned
,`username` varchar(30)
,`email` varchar(128)
,`status` enum('Pending','Active','Blocked')
,`timezone` varchar(60)
,`password` varchar(128)
,`salt` varchar(128)
,`password_reset_code` varchar(128)
,`password_reset_date` timestamp
,`password_reset_request_date` timestamp
,`activation_code` varchar(128)
,`user_level` varchar(30)
,`role_id` int(11)
,`date_created` timestamp
,`created_by` int(11)
,`last_modified` timestamp
,`last_modified_by` int(11) unsigned
,`name` varchar(61)
,`gender` enum('Male','Female')
,`dept_id` int(11) unsigned
);
-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `type` enum('login','create','update','delete') NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(30) DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `type`, `description`, `ip_address`, `datetime`) VALUES
(1, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-08 04:12:48'),
(2, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-08 04:33:11'),
(3, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-08 04:37:34'),
(4, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-08 10:58:42'),
(5, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-08 15:23:33'),
(6, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-09 02:48:06'),
(7, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-09 02:49:23'),
(8, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-10 00:58:21'),
(9, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-10 02:16:10'),
(10, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-10 02:27:42'),
(11, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-10 02:33:58'),
(12, 7, 'login', 'Fredrick signed in successfully', '127.0.0.1', '2014-02-10 02:35:19'),
(13, 7, 'login', 'Fredrick signed in successfully', '127.0.0.1', '2014-02-10 02:35:53'),
(14, 7, 'login', 'Fredrick signed in successfully', '127.0.0.1', '2014-02-10 02:50:09'),
(15, 7, 'login', 'Fredrick signed in successfully', '127.0.0.1', '2014-02-10 03:00:05'),
(16, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-10 08:11:52'),
(17, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-10 08:53:01'),
(18, 1, 'login', 'mconyango signed in successfully', '127.0.0.1', '2014-02-27 09:13:18'),
(19, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-02-27 09:44:00'),
(20, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-02-28 07:39:11'),
(21, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-02-28 08:42:11'),
(22, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-01 03:23:19'),
(23, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-01 03:42:29'),
(24, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-01 04:16:31'),
(25, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-01 10:56:05'),
(26, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-01 21:07:04'),
(27, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-03 11:41:55'),
(28, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-03 12:56:54'),
(29, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-03 13:30:35'),
(30, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-03 14:02:06'),
(31, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-04 08:29:17'),
(32, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-04 10:59:08'),
(33, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-04 20:51:36'),
(34, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-05 11:01:05'),
(35, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 00:52:14'),
(36, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 07:40:37'),
(37, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 10:29:21'),
(38, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 12:10:02'),
(39, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 12:50:11'),
(40, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 13:08:18'),
(41, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 13:55:24'),
(42, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 14:59:56'),
(43, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 15:14:22'),
(44, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-06 20:13:15'),
(45, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-08 15:06:49'),
(46, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-08 19:21:41'),
(47, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-10 00:02:59'),
(48, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-10 01:11:27'),
(49, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-10 18:03:38'),
(50, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-10 22:58:13'),
(51, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-11 06:09:15'),
(52, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-11 14:08:11'),
(53, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-11 16:31:25'),
(54, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-11 22:03:59'),
(55, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-12 06:24:36'),
(56, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-13 18:16:06'),
(57, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-13 19:53:12'),
(58, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-13 20:25:06'),
(59, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-13 22:58:23'),
(60, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-18 18:34:41'),
(61, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-19 19:10:07'),
(62, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-19 19:57:40'),
(63, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-19 21:12:06'),
(64, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-20 00:09:36'),
(65, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-20 18:20:22'),
(66, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-23 14:50:04'),
(67, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-03-25 15:15:12'),
(68, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-01 06:57:31'),
(69, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-01 18:04:19'),
(70, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-01 21:52:19'),
(71, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-02 09:30:45'),
(72, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-02 03:40:39'),
(73, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-08 07:36:44'),
(74, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-22 01:55:35'),
(75, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-24 08:36:57'),
(76, 9, 'login', 'martin signed in successfully', '127.0.0.1', '2014-04-29 02:03:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE IF NOT EXISTS `user_levels` (
  `id` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `banned_resources` text,
  `banned_resources_inheritance` varchar(30) DEFAULT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='user types (non-functional requirement)';

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `description`, `banned_resources`, `banned_resources_inheritance`, `rank`) VALUES
('ADMIN', 'Admin', 'USER_ACTIVITY,USER_ADMIN,USER_SUPERADMIN', 'SUPERADMIN', 3),
('ENGINEER', 'System Engineer', NULL, NULL, 1),
('MEMBER', 'Members', 'HELP_DOCUMENTATION,SETTINGS_EMAIL,SETTINGS_GENERAL,SETTINGS_PAGE,SETTINGS_RUNTIME,SETTINGS_STATIC_SECTIONS,USER_ACTIVITY,USER_DEFAULT', 'ADMIN', 4),
('SUPERADMIN', 'Super Admin', 'MODULES_ENABLED,USER_ENGINEER,USER_LEVELS,USER_RESOURCES', 'ENGINEER', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_resources`
--

CREATE TABLE IF NOT EXISTS `user_resources` (
  `id` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `viewable` int(11) NOT NULL DEFAULT '1',
  `createable` int(11) NOT NULL DEFAULT '1',
  `updateable` int(11) NOT NULL DEFAULT '1',
  `deleteable` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='system resources-(non-functional requirement)';

--
-- Dumping data for table `user_resources`
--

INSERT INTO `user_resources` (`id`, `description`, `viewable`, `createable`, `updateable`, `deleteable`) VALUES
('BUSINESS_PERMIT', 'Business Permits', 1, 1, 1, 1),
('CESS', 'Cess', 1, 1, 1, 1),
('DEPT', 'Departments', 1, 1, 1, 1),
('HELP_DOCUMENTATION', 'Documentation', 1, 1, 1, 1),
('LAND_RATES', 'Land rates', 1, 1, 1, 1),
('MARKET_FEES', 'Market Fees', 1, 1, 1, 1),
('MESSAGE', 'Messages', 1, 1, 1, 1),
('MODULES_ENABLED', 'Modules Enabled', 1, 1, 1, 0),
('PARKING', 'Parking Fees', 1, 1, 1, 1),
('SETTINGS_CRON', 'Cron Jobs Settings', 1, 1, 1, 0),
('SETTINGS_EMAIL', 'Email settings', 1, 1, 1, 1),
('SETTINGS_GENERAL', 'General settings', 1, 1, 1, 1),
('SETTINGS_RUNTIME', 'System error logs', 1, 1, 1, 1),
('SETTINGS_TAXES', 'Tax Settings', 1, 1, 1, 1),
('SETTINGS_TOWN', 'Towns/Cities', 1, 1, 1, 1),
('USER_ACTIVITY', 'Uses activity log', 1, 0, 0, 1),
('USER_ADMIN', 'System admins', 1, 1, 1, 1),
('USER_DEFAULT', 'Members', 1, 1, 1, 1),
('USER_ENGINEER', 'System Engineer', 1, 1, 1, 1),
('USER_LEVELS', 'User Levels', 1, 1, 1, 1),
('USER_RESOURCES', 'System resources', 1, 1, 1, 1),
('USER_ROLES', 'System Roles', 1, 1, 1, 1),
('USER_SUPERADMIN', 'Super Admin', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `readonly` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='System roles for admin users' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`, `description`, `readonly`, `date_created`, `created_by`) VALUES
(1, 'Default Role', 'Default system admin role ', 1, '2013-09-28 14:39:40', 1),
(2, 'Another Role', 'Another Role Description', 0, '2013-10-17 07:38:57', 1),
(4, 'Sample Role3', 'Sample Role3', 0, '2013-10-17 07:58:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles_on_resources`
--

CREATE TABLE IF NOT EXISTS `user_roles_on_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` varchar(128) NOT NULL,
  `view` int(11) NOT NULL DEFAULT '1',
  `create` int(11) NOT NULL DEFAULT '0',
  `update` int(11) NOT NULL DEFAULT '0',
  `delete` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='roles on resources (non-functional requirement)' AUTO_INCREMENT=96 ;

--
-- Dumping data for table `user_roles_on_resources`
--

INSERT INTO `user_roles_on_resources` (`id`, `role_id`, `resource_id`, `view`, `create`, `update`, `delete`) VALUES
(1, 1, 'SETTINGS_EMAIL', 1, 1, 1, 1),
(2, 1, 'SETTINGS_GENERAL', 1, 1, 1, 1),
(11, 1, 'USER_ROLES', 1, 1, 1, 1),
(12, 1, 'SETTINGS_RUNTIME', 1, 1, 1, 1),
(18, 1, 'USER_ACTIVITY', 0, 0, 0, 0),
(19, 1, 'USER_ADMIN', 0, 0, 0, 0),
(20, 1, 'USER_DEFAULT', 1, 1, 1, 1),
(21, 2, 'HELP_DOCUMENTATION', 1, 1, 1, 1),
(22, 2, 'SETTINGS_EMAIL', 1, 1, 1, 1),
(23, 2, 'SETTINGS_GENERAL', 1, 1, 1, 1),
(32, 2, 'USER_ROLES', 1, 1, 1, 1),
(33, 2, 'SETTINGS_RUNTIME', 1, 1, 1, 1),
(40, 2, 'USER_ACTIVITY', 1, 0, 0, 1),
(41, 2, 'USER_DEFAULT', 1, 1, 1, 1),
(42, 4, 'HELP_DOCUMENTATION', 1, 1, 1, 1),
(43, 4, 'SETTINGS_EMAIL', 1, 1, 1, 1),
(44, 4, 'SETTINGS_GENERAL', 1, 1, 1, 1),
(53, 4, 'USER_ROLES', 1, 1, 1, 1),
(54, 4, 'SETTINGS_RUNTIME', 1, 1, 1, 1),
(61, 4, 'USER_ACTIVITY', 1, 0, 0, 1),
(62, 4, 'USER_DEFAULT', 1, 1, 1, 1),
(63, 2, 'USER_LEVELS', 0, 0, 0, 0),
(64, 2, 'USER_RESOURCES', 0, 0, 0, 0),
(65, 4, 'MESSAGE', 0, 0, 0, 0),
(66, 4, 'SETTINGS_TOWN', 0, 0, 0, 0),
(67, 2, 'MESSAGE', 1, 1, 1, 1),
(68, 2, 'SETTINGS_TOWN', 1, 1, 1, 1),
(78, 1, 'HELP_DOCUMENTATION', 1, 1, 1, 1),
(92, 1, 'MESSAGE', 1, 1, 1, 1),
(93, 1, 'SETTINGS_CRON', 1, 1, 1, 0),
(94, 1, 'SETTINGS_TAXES', 1, 1, 1, 1),
(95, 1, 'SETTINGS_TOWN', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE IF NOT EXISTS `vehicle` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(20) NOT NULL,
  `vehicle_type` varchar(30) NOT NULL,
  `model` varchar(60) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `driver_name` varchar(60) DEFAULT NULL,
  `owner_id` int(11) unsigned DEFAULT NULL,
  `owned_by_staff` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reg_no` (`reg_no`),
  KEY `vehicle_type_id` (`vehicle_type`),
  KEY `owner_id` (`owner_id`),
  KEY `vehicle_type_id_2` (`vehicle_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `vehicle`
--


-- --------------------------------------------------------

--
-- Table structure for table `vehicle_type`
--

CREATE TABLE IF NOT EXISTS `vehicle_type` (
  `id` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle_type`
--


-- --------------------------------------------------------

--
-- Structure for view `users_view`
--
DROP TABLE IF EXISTS `users_view`;

CREATE ALGORITHM=MERGE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `users_view` AS select `a`.`id` AS `id`,`a`.`username` AS `username`,`a`.`email` AS `email`,`a`.`status` AS `status`,`a`.`timezone` AS `timezone`,`a`.`password` AS `password`,`a`.`salt` AS `salt`,`a`.`password_reset_code` AS `password_reset_code`,`a`.`password_reset_date` AS `password_reset_date`,`a`.`password_reset_request_date` AS `password_reset_request_date`,`a`.`activation_code` AS `activation_code`,`a`.`user_level` AS `user_level`,`a`.`role_id` AS `role_id`,`a`.`date_created` AS `date_created`,`a`.`created_by` AS `created_by`,`a`.`last_modified` AS `last_modified`,`a`.`last_modified_by` AS `last_modified_by`,concat(`b`.`first_name`,' ',`b`.`last_name`) AS `name`,`b`.`gender` AS `gender`,`c`.`dept_id` AS `dept_id` from ((`users` `a` join `person` `b` on((`a`.`id` = `b`.`id`))) left join `dept_user` `c` on(((`b`.`id` = `c`.`person_id`) and (`c`.`has_left` = 0))));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citizen`
--
ALTER TABLE `citizen`
  ADD CONSTRAINT `citizen_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `console_task_queue`
--
ALTER TABLE `console_task_queue`
  ADD CONSTRAINT `console_task_queue_ibfk_1` FOREIGN KEY (`task`) REFERENCES `console_tasks` (`id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`level_id`) REFERENCES `employee_level` (`id`),
  ADD CONSTRAINT `employee_ibfk_3` FOREIGN KEY (`dept_id`) REFERENCES `dept` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `parking_clumped`
--
ALTER TABLE `parking_clumped`
  ADD CONSTRAINT `parking_clumped_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parking_clumped_ibfk_2` FOREIGN KEY (`street_id`) REFERENCES `region_streets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parking_clumped_ibfk_3` FOREIGN KEY (`county_id`) REFERENCES `region_county` (`id`);

--
-- Constraints for table `parking_fee_matrix`
--
ALTER TABLE `parking_fee_matrix`
  ADD CONSTRAINT `parking_fee_matrix_ibfk_1` FOREIGN KEY (`street_id`) REFERENCES `region_streets` (`id`),
  ADD CONSTRAINT `parking_fee_matrix_ibfk_2` FOREIGN KEY (`county_id`) REFERENCES `region_county` (`id`),
  ADD CONSTRAINT `parking_fee_matrix_ibfk_3` FOREIGN KEY (`parking_package_id`) REFERENCES `parking_parkage` (`id`),
  ADD CONSTRAINT `parking_fee_matrix_ibfk_4` FOREIGN KEY (`parking_fee_id`) REFERENCES `parking_fees` (`id`);

--
-- Constraints for table `parking_payments`
--
ALTER TABLE `parking_payments`
  ADD CONSTRAINT `parking_payments_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`),
  ADD CONSTRAINT `parking_payments_ibfk_2` FOREIGN KEY (`street_id`) REFERENCES `region_streets` (`id`),
  ADD CONSTRAINT `parking_payments_ibfk_3` FOREIGN KEY (`county_id`) REFERENCES `region_county` (`id`),
  ADD CONSTRAINT `parking_payments_ibfk_4` FOREIGN KEY (`parking_fee_matrix_id`) REFERENCES `parking_fee_matrix` (`id`);

--
-- Constraints for table `person_address`
--
ALTER TABLE `person_address`
  ADD CONSTRAINT `person_address_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `region_streets`
--
ALTER TABLE `region_streets`
  ADD CONSTRAINT `region_streets_ibfk_1` FOREIGN KEY (`sub_county_id`) REFERENCES `region_sub_county` (`id`);

--
-- Constraints for table `region_sub_county`
--
ALTER TABLE `region_sub_county`
  ADD CONSTRAINT `region_sub_county_ibfk_1` FOREIGN KEY (`county_id`) REFERENCES `region_county` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `level_of_user` FOREIGN KEY (`user_level`) REFERENCES `user_levels` (`id`),
  ADD CONSTRAINT `role_of_user` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`);

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles_on_resources`
--
ALTER TABLE `user_roles_on_resources`
  ADD CONSTRAINT `user_roles_on_resources_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roles_on_resources_ibfk_2` FOREIGN KEY (`resource_id`) REFERENCES `user_resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `person` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicle_ibfk_2` FOREIGN KEY (`vehicle_type`) REFERENCES `vehicle_type` (`id`);
