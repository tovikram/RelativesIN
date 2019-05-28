-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2019 at 04:54 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `familyin`
--

-- --------------------------------------------------------

--
-- Table structure for table `indian_calendar_2019_events`
--

CREATE TABLE IF NOT EXISTS `indian_calendar_2019_events` (
  `event_no` int(30) NOT NULL AUTO_INCREMENT,
  `event_date` varchar(30) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  PRIMARY KEY (`event_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `indian_calendar_2019_events`
--

INSERT INTO `indian_calendar_2019_events` (`event_no`, `event_date`, `event_name`) VALUES
(1, '2019-01-01', 'New Year`s Day'),
(2, '2019-01-14', 'Makar Sankranti / Pongal'),
(3, '2019-01-26', 'Republic Day'),
(4, '2019-03-04', 'Maha Shivaratri'),
(5, '2019-03-21', 'Holi'),
(6, '2019-04-06', 'Ugadi / Gudi Padwa'),
(7, '2019-04-13', 'Ram Navami'),
(8, '2019-04-17', 'Mahavir Jayanti'),
(9, '2019-04-19', 'Good Friday'),
(10, '2019-05-01', 'Labor Day'),
(11, '2019-05-18', 'Budhha Purnima'),
(12, '2019-06-05', 'Eid-ul-Fitar'),
(13, '2019-07-04', 'Rath Yatra'),
(14, '2019-08-12', 'Bakri Id / Eid ul-Adha'),
(15, '2019-08-15', 'Raksha Bandhan'),
(16, '2019-08-15', 'Independence Day'),
(17, '2019-08-24', 'Janmashtami'),
(18, '2019-09-02', 'Vinayaka Chaturthi'),
(19, '2019-09-10', 'Muharram'),
(20, '2019-09-11', 'Onam'),
(21, '2019-10-02', 'Mathatma Gandhi Jayanti'),
(22, '2019-10-08', 'Dussehra / Dasara'),
(23, '2019-10-27', 'Diwali / Deepavali'),
(24, '2019-11-10', 'Milad un Nabi'),
(25, '2019-11-12', 'Guru Nanak`s Birthday'),
(26, '2019-12-25', 'Christmas');

-- --------------------------------------------------------

--
-- Table structure for table `message_details`
--

CREATE TABLE IF NOT EXISTS `message_details` (
  `message_id` int(255) NOT NULL AUTO_INCREMENT,
  `from_id` int(255) NOT NULL,
  `to_id` int(255) NOT NULL,
  `message_text` mediumtext NOT NULL,
  `message_datetime` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `more_details`
--

CREATE TABLE IF NOT EXISTS `more_details` (
  `familyinID` int(100) NOT NULL,
  `profile_image` varchar(100) DEFAULT NULL,
  `userGender` varchar(10) DEFAULT NULL,
  `userDOB` date DEFAULT NULL,
  `onlineStatus` datetime DEFAULT NULL,
  `membersID` text,
  `iAmMemberOf` text,
  `myStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `otp_details`
--

CREATE TABLE IF NOT EXISTS `otp_details` (
  `otpID` int(100) NOT NULL AUTO_INCREMENT,
  `familyinID` int(100) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userContact` varchar(100) DEFAULT NULL,
  `otpType` varchar(100) NOT NULL,
  `otpCode` varchar(100) NOT NULL,
  `otpDateTime` datetime NOT NULL,
  PRIMARY KEY (`otpID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_details`
--

CREATE TABLE IF NOT EXISTS `post_details` (
  `post_id` int(100) NOT NULL AUTO_INCREMENT,
  `member_id` int(100) NOT NULL,
  `post_date_time` datetime NOT NULL,
  `post_msg` varchar(500) DEFAULT NULL,
  `post_img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE IF NOT EXISTS `relations` (
  `relationNumber` int(100) NOT NULL AUTO_INCREMENT,
  `relationEnglish` varchar(50) DEFAULT NULL,
  `relationHindi` varchar(50) DEFAULT NULL,
  `relationFor` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`relationNumber`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `relations`
--

INSERT INTO `relations` (`relationNumber`, `relationEnglish`, `relationHindi`, `relationFor`) VALUES
(1, 'maternal grandfather', 'nana', NULL),
(2, 'Maternal Grandmother', 'Nani', NULL),
(3, 'Elder Brother', 'Bhaiyaa', NULL),
(4, 'Younger Brother', 'Chota Bhai', NULL),
(5, 'Husband''s sister', 'Nanad', 'F'),
(6, 'Sister''s husband', 'Jija', 'F'),
(7, 'Sister''s husband', 'bahanoii', 'M'),
(8, 'Elder Sister', 'Didi', NULL),
(9, 'Younger Sister', 'chhotee bahan', NULL),
(10, 'Husband''s elder brother', 'Jeth', 'F'),
(11, 'Husband''s younger brother', 'Devar', 'F'),
(12, 'Elder brother''s wife', 'Bhabhi', NULL),
(13, 'Younger brother''s wife', 'Bhayo', NULL),
(14, 'Father', 'Papa', NULL),
(15, 'Mother', 'Maa', NULL),
(16, 'Brother', 'Bhai', NULL),
(17, 'Sister', 'Bahan', NULL),
(18, 'Grandfather', 'Dada', NULL),
(19, 'Grandmother', 'Dadi', NULL),
(20, 'Son', 'Beta', 'M'),
(21, 'Son', 'Beta', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `relationsdetails`
--

CREATE TABLE IF NOT EXISTS `relationsdetails` (
  `relationRowID` int(100) NOT NULL AUTO_INCREMENT,
  `familyinID` int(100) NOT NULL,
  `relation` varchar(100) NOT NULL,
  `memberID` int(100) NOT NULL,
  `addDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`relationRowID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `signup_family_in`
--

CREATE TABLE IF NOT EXISTS `signup_family_in` (
  `familyinID` int(100) NOT NULL AUTO_INCREMENT,
  `userFirstName` varchar(100) NOT NULL,
  `userLastName` varchar(100) NOT NULL,
  `userContact` varchar(100) DEFAULT NULL,
  `userEmail` varchar(100) NOT NULL,
  `familyinPassword` varchar(100) NOT NULL,
  PRIMARY KEY (`familyinID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_new_user`
--

CREATE TABLE IF NOT EXISTS `temp_new_user` (
  `tempId` int(100) NOT NULL AUTO_INCREMENT,
  `tempFname` varchar(100) NOT NULL,
  `tempLname` varchar(100) NOT NULL,
  `tempContact` varchar(100) DEFAULT NULL,
  `tempEmail` varchar(100) NOT NULL,
  `tempPass` varchar(100) NOT NULL,
  `accountStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`tempId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
