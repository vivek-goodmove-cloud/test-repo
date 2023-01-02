-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 27, 2022 at 01:05 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcillp_project_3_job_search`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_users`
--

DROP TABLE IF EXISTS `api_users`;
CREATE TABLE IF NOT EXISTS `api_users` (
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `datecreated` datetime NOT NULL,
  PRIMARY KEY (`username`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This is api user data';

--
-- Dumping data for table `api_users`
--

INSERT INTO `api_users` (`username`, `password_hash`, `password`, `datecreated`) VALUES
('gopal', '827ccb0eea8a706c4c34a16891f84e7b', '12345', '2022-12-08 10:40:10'),
('pcillp_app_user', '827ccb0eea8a706c4c34a16891f84e7b', '12345', '2022-12-08 10:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `appln_screen_lvl_1`
--

DROP TABLE IF EXISTS `appln_screen_lvl_1`;
CREATE TABLE IF NOT EXISTS `appln_screen_lvl_1` (
  `Appln_ID` int(11) NOT NULL,
  `Status_website` smallint(1) DEFAULT NULL,
  `Status_Email` smallint(1) DEFAULT NULL,
  `Status_mobile` smallint(1) DEFAULT NULL,
  `Status_Level1` smallint(1) DEFAULT NULL,
  `Emp_ID_Level1` varchar(5) DEFAULT NULL,
  `DTTM_Level1` datetime DEFAULT NULL,
  `Status_Level2` smallint(1) DEFAULT NULL,
  `Emp_ID_Level2` varchar(5) DEFAULT NULL,
  `DTTM_Level2` datetime DEFAULT NULL,
  PRIMARY KEY (`Appln_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This is level1 verification data';

--
-- Dumping data for table `appln_screen_lvl_1`
--

INSERT INTO `appln_screen_lvl_1` (`Appln_ID`, `Status_website`, `Status_Email`, `Status_mobile`, `Status_Level1`, `Emp_ID_Level1`, `DTTM_Level1`, `Status_Level2`, `Emp_ID_Level2`, `DTTM_Level2`) VALUES
(1001, 0, 0, 0, 0, '0001', '2022-12-27 07:27:53', NULL, NULL, NULL),
(1002, 0, 0, 0, 0, '0001', '2022-12-27 07:15:52', NULL, NULL, NULL),
(1004, 0, 0, 0, 0, '0001', '2022-12-26 13:34:33', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cntry`
--

DROP TABLE IF EXISTS `cntry`;
CREATE TABLE IF NOT EXISTS `cntry` (
  `Cntry_Name` varchar(30) NOT NULL,
  `Cntry_Phone_Code` smallint(3) DEFAULT NULL,
  `Cntry_Mobile_length` smallint(2) DEFAULT NULL,
  `Cntry_Landline_length` smallint(2) DEFAULT NULL,
  `Cntry_Currency_Code` varchar(5) DEFAULT NULL,
  `Cntry_Currency_Symbol` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`Cntry_Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ref table';

--
-- Dumping data for table `cntry`
--

INSERT INTO `cntry` (`Cntry_Name`, `Cntry_Phone_Code`, `Cntry_Mobile_length`, `Cntry_Landline_length`, `Cntry_Currency_Code`, `Cntry_Currency_Symbol`) VALUES
('CANADA', 1, 10, 6, 'CAD', '$'),
('INDIA', 91, 10, 8, 'INR', 'R'),
('SHRILANKA', 94, 10, 8, 'SLR', 'R'),
('USA', 1, 10, 6, 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_name` varchar(50) DEFAULT NULL,
  `emp_status` varchar(50) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `emp_name`, `emp_status`, `datecreated`) VALUES
(101, 'tanuj', 'Active', '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `employee_role`
--

DROP TABLE IF EXISTS `employee_role`;
CREATE TABLE IF NOT EXISTS `employee_role` (
  `emp_id` int(11) NOT NULL,
  `emp_type` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`emp_id`,`emp_type`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_role`
--

INSERT INTO `employee_role` (`emp_id`, `emp_type`, `role_id`, `datecreated`) VALUES
(101, 'employee', 1, '2022-12-27'),
(101, 'employee', 2, '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `init_appln`
--

DROP TABLE IF EXISTS `init_appln`;
CREATE TABLE IF NOT EXISTS `init_appln` (
  `Org_Website_URL` varchar(50) NOT NULL,
  `Appln_Email_ID` varchar(40) NOT NULL,
  `Appln_Phone_Code` smallint(3) NOT NULL,
  `Appln_Mobile_No` bigint(10) NOT NULL,
  `Date` date NOT NULL,
  `Appln_ID` int(10) DEFAULT NULL,
  `F_Name` varchar(20) DEFAULT NULL,
  `L_Name` varchar(20) DEFAULT NULL,
  `Org_Name` varchar(50) DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `IP_Address` varchar(15) DEFAULT NULL,
  `Appln_status` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`Org_Website_URL`,`Appln_Email_ID`,`Appln_Phone_Code`,`Appln_Mobile_No`,`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This is initial level verification data';

--
-- Dumping data for table `init_appln`
--

INSERT INTO `init_appln` (`Org_Website_URL`, `Appln_Email_ID`, `Appln_Phone_Code`, `Appln_Mobile_No`, `Date`, `Appln_ID`, `F_Name`, `L_Name`, `Org_Name`, `Time`, `IP_Address`, `Appln_status`) VALUES
('www.goodmove.cloud', 'gopal@goodmove.cloud', 91, 8956231245, '2022-12-23', 1001, 'Gopal', 'Mankar', 'Goodmove System Inc', '838:59:59', '::1', 1),
('www.lokhnadecorp.com', 'akash@lokhnadecorp.com', 91, 8956451223, '2022-12-26', 1003, 'Akash', 'Lokande', 'Lokhande Corporation', '838:59:59', '::1', 0),
('www.pcillp.com', 'tanuj@pcillp.com', 91, 7845122356, '2022-12-23', 1002, 'Tanuj', 'Khadse', 'Perpetual System Pvt', '838:59:59', '::1', 1),
('www.XYZ.com', 'XYZ@XYZ.com', 91, 7845122356, '2022-12-26', 1004, 'ABC', 'XYZ', 'XYZ.com', '838:59:59', '::1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `org_employee`
--

DROP TABLE IF EXISTS `org_employee`;
CREATE TABLE IF NOT EXISTS `org_employee` (
  `org_emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_emp_name` varchar(50) DEFAULT NULL,
  `org_emp_status` varchar(50) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`org_emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `org_employee`
--

INSERT INTO `org_employee` (`org_emp_id`, `org_emp_name`, `org_emp_status`, `datecreated`) VALUES
(101, 'tanuj', 'active', '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `per_status` int(1) NOT NULL DEFAULT '1',
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`per_id`, `per_name`, `per_status`, `datecreated`) VALUES
(1, 'View Application Org List', 1, '2022-12-27'),
(2, 'Edit Application Org List', 1, '2022-12-27'),
(3, 'View Application', 1, '2022-12-27'),
(4, 'Assign Application Org', 1, '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `datecreated`) VALUES
(1, 'level_1', '2022-12-27'),
(2, 'level_2', '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `rp_role_id` int(11) NOT NULL,
  `rp_per_id` int(11) NOT NULL,
  `datecreated` date NOT NULL,
  PRIMARY KEY (`rp_role_id`,`rp_per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`rp_role_id`, `rp_per_id`, `datecreated`) VALUES
(1, 1, '2022-12-27'),
(1, 2, '2022-12-27'),
(1, 4, '2022-12-27'),
(2, 1, '2022-12-27'),
(2, 2, '2022-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `password_hash` varchar(50) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  PRIMARY KEY (`user_id`,`username`,`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `user_type`, `password`, `password_hash`, `datecreated`) VALUES
(101, 'tanuj', 'employee', '12345', '827ccb0eea8a706c4c34a16891f84e7b', '2022-12-27'),
(101, 'tanuj', 'org_employee', '12345', '827ccb0eea8a706c4c34a16891f84e7b', '2022-12-27');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
