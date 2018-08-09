-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2018 at 02:35 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `addNewVoter` (IN `CName` VARCHAR(25), IN `CCode` VARCHAR(25), IN `VNAME` VARCHAR(50), IN `Gender` VARCHAR(50), IN `Age` VARCHAR(10), IN `Email` VARCHAR(50), IN `Contact` VARCHAR(15), IN `Address` VARCHAR(255), IN `Photo` VARCHAR(255), IN `UniqueID` VARCHAR(50), IN `Barcode` VARCHAR(25), IN `VVStatus` INT(5), IN `Vstatus` INT(5), IN `Vrole` INT(5), IN `Created_AT` TIME, IN `Updated_AT` TIME)  NO SQL
BEGIN
	INSERT INTO vs_voters(county_name, center_code, voter_name, voter_gender,voter_age, voter_email, voter_contactNO, voter_address, voter_photo, voter_uniqueID, voter_barcode, voter_verifyStatus, voter_status, voter_role, created_at, updated_at)
    VALUES (CName, CCode, VNAME, Gender,Age, Email, Contact, Address,Photo, UniqueID, Barcode, VVStatus, Vstatus, Vrole, Created_AT, Updated_AT);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getVoters` ()  BEGIN
	select * from vs_voters;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginProcedure` (IN `user` VARCHAR(50), IN `pass` VARCHAR(255))  NO SQL
select id,role  from vs_users where vs_users.username = user and vs_users.password = pass and role = 3 and status = 1$$

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
  `email` varchar(50) NOT NULL,
  `status` int(2) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_users`
--

INSERT INTO `vs_users` (`id`, `username`, `password`, `email`, `status`, `role`) VALUES
(1, 'pre_admin', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'pardeepprotolabz@gmail.com', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vs_voters`
--

CREATE TABLE `vs_voters` (
  `id` int(10) NOT NULL,
  `county_name` varchar(25) NOT NULL,
  `center_code` varchar(10) NOT NULL,
  `voter_name` varchar(50) NOT NULL,
  `voter_gender` varchar(10) NOT NULL,
  `voter_age` varchar(10) NOT NULL,
  `voter_email` varchar(25) NOT NULL,
  `voter_contactNO` varchar(15) NOT NULL,
  `voter_address` varchar(500) NOT NULL,
  `voter_photo` varchar(255) DEFAULT NULL,
  `voter_uniqueID` varchar(25) NOT NULL,
  `voter_barcode` varchar(255) DEFAULT NULL,
  `voter_verifyStatus` int(5) DEFAULT NULL COMMENT '0 = inserted once,1 = verified, 2 = updated',
  `voter_ballotNO` varchar(25) DEFAULT NULL,
  `voter_status` int(2) NOT NULL COMMENT 'active = 1 and Inactive = 0, Deleted = 2	',
  `voter_role` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_voters`
--

INSERT INTO `vs_voters` (`id`, `county_name`, `center_code`, `voter_name`, `voter_gender`, `voter_age`, `voter_email`, `voter_contactNO`, `voter_address`, `voter_photo`, `voter_uniqueID`, `voter_barcode`, `voter_verifyStatus`, `voter_ballotNO`, `voter_status`, `voter_role`, `created_at`, `updated_at`) VALUES
(1, 'australia', '101', 'Rebbica Snow', 'female', '20', 'rebicca@gmail.com', '987654321', 'aus 23 ahhtj jdfh f address', 'photo', '737542207', 'barcode', 0, NULL, 1, 0, '2018-08-08 04:01:41', '2018-08-09 09:19:20'),
(3, 'John', '1034', 'john kerrylon', 'male', '25', 'johnkerrylon@gmail.com', '987654322', 'sdqwwerwrt wesdfs', 'photo', '780971107', 'barcode', 0, NULL, 1, 0, '2018-08-08 05:51:13', '2018-08-08 11:23:41'),
(4, 'bong', '111', 'Jasi aloved', 'female', '23', 'jessy@yahoo.com', '987654323', 'qwerty addresss', 'photo', '744569287', 'barcode', 0, NULL, 0, 0, '2018-08-08 06:02:42', '2018-08-09 12:02:55'),
(5, 'dsf', '34', 'sssss', 'female', '45', 'sss@gmail.com', '987654324', 'asd', 'photo1', '711562107', 'barcode1', 0, NULL, 2, 0, '2018-08-08 06:04:34', '2018-08-09 12:02:52');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voter_uniqueID` (`voter_uniqueID`),
  ADD UNIQUE KEY `voter_email` (`voter_email`);

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vs_votes`
--
ALTER TABLE `vs_votes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
