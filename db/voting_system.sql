-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 07, 2018 at 02:29 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `loginProcedure` (IN `user` VARCHAR(50), IN `pass` VARCHAR(255))  NO SQL
select * from vs_users where vs_users.username = user and vs_users.password = pass and role = 3$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vs_fingerprints`
--

CREATE TABLE `vs_fingerprints` (
  `id` int(10) NOT NULL,
  `voter_unique_id` varchar(25) NOT NULL,
  `left_1` varchar(500) DEFAULT NULL,
  `left_2` varchar(500) DEFAULT NULL,
  `left_3` varchar(500) DEFAULT NULL,
  `left_4` varchar(500) DEFAULT NULL,
  `left_thumb` varchar(500) DEFAULT NULL,
  `right_1` varchar(500) DEFAULT NULL,
  `right_2` varchar(500) DEFAULT NULL,
  `right_3` varchar(500) DEFAULT NULL,
  `right_4` varchar(500) DEFAULT NULL,
  `right_thumb` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vs_users`
--

CREATE TABLE `vs_users` (
  `id` int(10) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(500) NOT NULL,
  `status` int(2) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_users`
--

INSERT INTO `vs_users` (`id`, `username`, `password`, `status`, `role`) VALUES
(1, 'pre_admin', '123', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vs_voters`
--

CREATE TABLE `vs_voters` (
  `id` int(10) NOT NULL,
  `country_name` varchar(25) NOT NULL,
  `center_code` varchar(10) NOT NULL,
  `voter_name` varchar(50) NOT NULL,
  `voter_gender` varchar(10) NOT NULL,
  `voter_email` varchar(25) NOT NULL,
  `voter_contact_no` varchar(15) NOT NULL,
  `voter_address` varchar(500) NOT NULL,
  `voter_photo` varchar(255) DEFAULT NULL,
  `voter_unique_id` varchar(25) NOT NULL,
  `voter_barcode` varchar(255) DEFAULT NULL,
  `voter_verify_status` int(5) DEFAULT NULL COMMENT '1 = verified, 2 = updated',
  `voter_ballot_no` varchar(25) DEFAULT NULL,
  `voter_status` int(2) NOT NULL COMMENT 'active = 1 and Inactive = 0, Deleted = 2	',
  `voter_role` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vs_votes`
--

CREATE TABLE `vs_votes` (
  `id` int(10) NOT NULL,
  `voter_unique_id` varchar(25) NOT NULL,
  `valid_votes` int(50) NOT NULL,
  `invalid_votes` int(50) NOT NULL,
  `allowed_votes` int(50) NOT NULL,
  `roc_form` varchar(255) NOT NULL,
  `pow_form` varchar(255) NOT NULL,
  `pojip_form` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_fingerprints`
--
ALTER TABLE `vs_fingerprints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_users`
--
ALTER TABLE `vs_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_voters`
--
ALTER TABLE `vs_voters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_votes`
--
ALTER TABLE `vs_votes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_fingerprints`
--
ALTER TABLE `vs_fingerprints`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vs_users`
--
ALTER TABLE `vs_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vs_voters`
--
ALTER TABLE `vs_voters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vs_votes`
--
ALTER TABLE `vs_votes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
