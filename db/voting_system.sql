-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 14, 2018 at 02:04 PM
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `addNewVoter` (IN `c_id` INT(25), IN `d_id` INT(25), IN `p_id` INT(25), IN `pol_id` INT(25), IN `VNAME` VARCHAR(50), IN `Gender` VARCHAR(50), IN `Age` VARCHAR(10), IN `Email` VARCHAR(50), IN `Contact` VARCHAR(15), IN `Address` VARCHAR(255), IN `Photo` VARCHAR(255), IN `UniqueID` VARCHAR(50), IN `Barcode` VARCHAR(25), IN `VVStatus` INT(5), IN `Vstatus` INT(5), IN `Vrole` INT(5), IN `Created_AT` TIME, IN `Updated_AT` TIME)  NO SQL
BEGIN
	INSERT INTO vs_voters(county_id,district_id,precinct_id,polling_placeID, voter_name, voter_gender,voter_age, voter_email, voter_contactNO, voter_address, voter_photo, voter_uniqueID, voter_barcode, voter_verifyStatus, voter_status, voter_role, created_at, updated_at)
    VALUES (c_id,d_id,p_id,pol_id, VNAME, Gender,Age, Email, Contact, Address,Photo, UniqueID, Barcode, VVStatus, Vstatus, Vrole, Created_AT, Updated_AT);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getVoters` ()  BEGIN
	select * from vs_voters;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginProcedure` (IN `user` VARCHAR(50), IN `pass` VARCHAR(255))  NO SQL
select id,role,polling_placeID  from vs_users where vs_users.username = user and vs_users.password = pass and role = 3 and status = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginProcedureForAdmin` (IN `user` VARCHAR(50), IN `hash_pass` VARCHAR(255))  BEGIN
select id,role  from vs_users 
where vs_users.username = user and vs_users.password = hash_pass and 
role = 1 and status = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_procedure` ()  BEGIN
select * from vs_voters;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vs_county`
--

CREATE TABLE `vs_county` (
  `id` int(10) NOT NULL,
  `county_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_county`
--

INSERT INTO `vs_county` (`id`, `county_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bomi', 1, '2018-08-11 11:06:51', '2018-08-13 04:43:48'),
(2, 'Bong', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(3, 'Grand Bassa', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(4, 'Grand Cape Mount', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(5, 'Grand Gedeh', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(6, 'Grand Kru', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(7, 'Lofa', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(8, 'Margibi', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(9, 'Maryland', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(10, 'Montserrado', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(11, 'Nimba', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(12, 'Rivercess', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(13, 'Sinoe', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(14, 'River Gee', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(15, 'Gbarpolu', 1, '2018-08-11 11:06:51', '0000-00-00 00:00:00'),
(16, 'test_county', 1, '2018-08-11 11:55:41', '2018-08-11 11:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `vs_district`
--

CREATE TABLE `vs_district` (
  `id` int(10) NOT NULL,
  `district_name` varchar(500) NOT NULL,
  `precincts` int(20) NOT NULL,
  `polling_places` int(20) NOT NULL,
  `county_id` int(10) NOT NULL,
  `status` int(2) NOT NULL,
  `magisterial_area` varchar(522) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_district`
--

INSERT INTO `vs_district` (`id`, `district_name`, `precincts`, `polling_places`, `county_id`, `status`, `magisterial_area`, `created_at`, `updated_at`) VALUES
(1, 'demo1', 1, 2, 2, 1, 'Bong (Lower)', '2018-08-11 10:20:34', '2018-08-14 07:59:28'),
(2, 'demo3', 12, 23, 7, 1, 'aaasa', '2018-08-13 06:46:54', '2018-08-14 07:59:39'),
(3, 'demo four', 12, 10, 2, 1, 'asdfghj', '2018-08-13 08:11:58', '2018-08-14 08:01:13');

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
-- Table structure for table `vs_polling`
--

CREATE TABLE `vs_polling` (
  `id` int(10) NOT NULL,
  `county_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `precinct_id` int(10) NOT NULL,
  `polling_placeName` varchar(50) NOT NULL,
  `polling_placeAddress` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_polling`
--

INSERT INTO `vs_polling` (`id`, `county_id`, `district_id`, `precinct_id`, `polling_placeName`, `polling_placeAddress`, `status`, `created_at`, `updated_at`) VALUES
(1, 16, 1, 1, 'naanana', 'ad', 1, '2018-08-13 06:37:32', '2018-08-13 07:21:49'),
(2, 1, 2, 1, 'adb', 'zzz', 0, '2018-08-13 06:56:30', '2018-08-13 07:05:33'),
(3, 7, 2, 15, 'my_polling_plcae', 'address', 1, '2018-08-14 08:08:35', '2018-08-14 08:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `vs_precincts`
--

CREATE TABLE `vs_precincts` (
  `id` int(11) NOT NULL,
  `precinct_name` varchar(255) NOT NULL,
  `precinct_address` varchar(1000) NOT NULL,
  `status` int(2) NOT NULL,
  `county_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_precincts`
--

INSERT INTO `vs_precincts` (`id`, `precinct_name`, `precinct_address`, `status`, `county_id`, `district_id`, `created_at`, `updated_at`) VALUES
(1, 'abc', 'address', 1, 1, 0, '2018-08-11 11:51:54', '2018-08-13 05:50:44'),
(2, 'new', 'qweryy', 1, 7, 0, '2018-08-13 07:47:12', '2018-08-13 07:47:12'),
(3, 'new', 'qweryy', 1, 7, 0, '2018-08-13 07:47:15', '2018-08-13 07:47:15'),
(4, 'you', 'addres you', 1, 7, 0, '2018-08-13 07:48:44', '2018-08-13 07:48:44'),
(5, 'aa', 'aa', 1, 0, 0, '2018-08-13 08:04:12', '2018-08-13 08:04:12'),
(6, 'aa', 'aa', 1, 0, 0, '2018-08-13 08:04:13', '2018-08-13 08:04:13'),
(7, 'aa', 'aa', 1, 0, 0, '2018-08-13 08:04:16', '2018-08-13 08:04:16'),
(8, 'assa', 'asas', 1, 0, 0, '2018-08-13 08:04:28', '2018-08-13 08:04:28'),
(9, 'assa', 'asas', 1, 2, 0, '2018-08-13 08:04:49', '2018-08-13 08:04:49'),
(10, 'asd', 'dsa', 1, 2, 0, '2018-08-13 08:10:02', '2018-08-13 08:10:02'),
(11, 'aaaa', 'bbbb', 1, 2, 0, '2018-08-14 07:34:53', '2018-08-14 07:34:53'),
(12, 'aaaa', 'bbbb', 1, 2, 0, '2018-08-14 07:34:54', '2018-08-14 07:34:54'),
(13, 'aaaa', 'bbbb', 1, 2, 0, '2018-08-14 07:35:05', '2018-08-14 07:35:05'),
(14, 'aaa', 'bbb', 1, 2, 0, '2018-08-14 07:35:30', '2018-08-14 07:35:30'),
(15, 'pre_name', 'address', 1, 7, 2, '2018-08-14 08:00:15', '2018-08-14 08:00:15');

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
  `polling_placeID` int(10) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vs_users`
--

INSERT INTO `vs_users` (`id`, `username`, `password`, `email`, `status`, `polling_placeID`, `role`) VALUES
(1, 'pre_admin', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'pardeepprotolabz@gmail.com', 1, 3, 3),
(2, 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'pardeep889@hotmail.com', 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vs_voters`
--

CREATE TABLE `vs_voters` (
  `id` int(10) NOT NULL,
  `county_id` int(10) NOT NULL,
  `district_id` int(10) NOT NULL,
  `precinct_id` int(10) NOT NULL,
  `polling_placeID` int(10) NOT NULL,
  `center_code` varchar(10) DEFAULT NULL,
  `center_address` varchar(500) DEFAULT NULL,
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

INSERT INTO `vs_voters` (`id`, `county_id`, `district_id`, `precinct_id`, `polling_placeID`, `center_code`, `center_address`, `voter_name`, `voter_gender`, `voter_age`, `voter_email`, `voter_contactNO`, `voter_address`, `voter_photo`, `voter_uniqueID`, `voter_barcode`, `voter_verifyStatus`, `voter_ballotNO`, `voter_status`, `voter_role`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, '101', '', 'Rebbica Snow', 'female', '20', 'rebicca@gmail.com', '987654321', 'aus 23 ahhtj jdfh f address', 'photo', '737542207', 'barcode', 0, NULL, 1, 0, '2018-08-08 04:01:41', '2018-08-09 09:19:20'),
(3, 0, 0, 0, 0, '1034', '', 'john kerrylon', 'male', '25', 'johnkerrylon@gmail.com', '987654322', 'sdqwwerwrt wesdfs', 'photo', '780971107', 'barcode', 0, NULL, 1, 0, '2018-08-08 05:51:13', '2018-08-08 11:23:41'),
(4, 0, 0, 0, 0, '111', '', 'Jasi aloved', 'female', '23', 'jessy@yahoo.com', '987654323', 'qwerty addresss', 'photo', '744569287', 'barcode', 0, NULL, 0, 0, '2018-08-08 06:02:42', '2018-08-09 12:02:55'),
(5, 0, 0, 0, 0, '34', '', 'sssss', 'female', '45', 'sss@gmail.com', '987654324', 'asd', 'photo1', '711562107', 'barcode1', 0, NULL, 2, 0, '2018-08-08 06:04:34', '2018-08-09 12:02:52'),
(6, 7, 2, 15, 3, NULL, NULL, 'robert alderson', 'male', '25', 'robert.alderson@gmail.com', '987654321', 'winterhell', 'haini', '797727957', 'qwertyui', 0, NULL, 1, 0, '2018-08-14 06:36:29', '2018-08-14 06:36:29');

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
-- Indexes for table `vs_county`
--
ALTER TABLE `vs_county`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_district`
--
ALTER TABLE `vs_district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_fingerprints`
--
ALTER TABLE `vs_fingerprints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_polling`
--
ALTER TABLE `vs_polling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vs_precincts`
--
ALTER TABLE `vs_precincts`
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
-- AUTO_INCREMENT for table `vs_county`
--
ALTER TABLE `vs_county`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vs_district`
--
ALTER TABLE `vs_district`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vs_fingerprints`
--
ALTER TABLE `vs_fingerprints`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vs_polling`
--
ALTER TABLE `vs_polling`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vs_precincts`
--
ALTER TABLE `vs_precincts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vs_users`
--
ALTER TABLE `vs_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vs_voters`
--
ALTER TABLE `vs_voters`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vs_votes`
--
ALTER TABLE `vs_votes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
