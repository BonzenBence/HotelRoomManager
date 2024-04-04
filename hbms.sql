-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 15, 2014 at 02:27 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hbms`
--
CREATE DATABASE IF NOT EXISTS `hbms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hbms`;

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE IF NOT EXISTS `Rooms` (
  `room_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(150) NOT NULL,
  `ward` varchar(150) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`room_id`, `type`, `ward`) VALUES
(1, 'Manual', 'Paediatric'),
(2, 'Semi-Electric', 'Accidents And Emergency'),
(3, 'Full-Electric', 'Psychiatric'),
(4, 'Bariatric', 'Orthopaedic'),
(5, 'Low room', 'Critical Care'),
(6, 'Manual', 'Postnatal'),
(7, 'Semi-Electric', 'Pregnancy');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `pat_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `age` int(11) NOT NULL,
  `meal_plan` varchar(150) NOT NULL,
  `nationality` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  PRIMARY KEY (`pat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`pat_id`, `name`, `age`, `meal_plan`, `nationality`, `phone`) VALUES
(1, 'John Smith', 21, 'Breakfast Included', 'United States', '08077424593'),
(2, 'Sophie Dubois', 22, 'Breakfast Included', 'France', '08077424593'),
(3, 'Luca Bianch', 33, 'Breakfast Included', 'Italy', '08077424593'),
(4, 'Yuki Takahashi', 29, 'Half Board', 'Japan', '08077424593'),
(5, 'Maria Fernández', 19, 'Breakfast Included', 'Spain', '08077424593'),
(6, 'Eva Müller', 46, 'Half Board', 'Germany', '08077424593'),
(7, 'Max Schneider', 12, 'Full Board', 'Germany', '08077424593');

-- --------------------------------------------------------

--
-- Table structure for table `pat_to_bed`
--

CREATE TABLE IF NOT EXISTS `pat_to_bed` (
  `pat_id` bigint(20) NOT NULL,
  `room_id` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pat_to_bed`
--

INSERT INTO `pat_to_bed` (`pat_id`, `room_id`) VALUES
(1, 'none'),
(2, '1'),
(3, 'none'),
(4, '0'),
(5, '2'),
(6, 'none'),
(7, '3'),
(8, '0'),
(10, 'none');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `uname` varchar(150) NOT NULL,
  `pword` varchar(150) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `uname`, `pword`) VALUES
(1, 'Obi Adaobi', 'ada', 'ada');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
