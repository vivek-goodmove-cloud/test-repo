-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2022 at 06:47 AM
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
-- Table structure for table `init_appln`
--

DROP TABLE IF EXISTS `init_appln`;
CREATE TABLE IF NOT EXISTS `init_appln` (
  `Org_Website_URL` varchar(50) NOT NULL,
  `Appln_Email_ID` varchar(40) NOT NULL,
  `Appln_Phone_Code` smallint(3) NOT NULL,
  `Appln_Mobile_No` int(10) NOT NULL,
  `Date` date NOT NULL,
  `Appln_ID` int(10) DEFAULT NULL,
  `F_Name` varchar(20) DEFAULT NULL,
  `L_Name` varchar(20) DEFAULT NULL,
  `Org_Name` varchar(50) DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `IP Address` varchar(15) DEFAULT NULL,
  `Appln_status` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`Org_Website_URL`,`Appln_Email_ID`,`Appln_Phone_Code`,`Appln_Mobile_No`,`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This is initial level verification data';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
