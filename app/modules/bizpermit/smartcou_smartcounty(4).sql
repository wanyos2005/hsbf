-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2014 at 11:05 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bpt_payment`
--


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
