-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2013 at 03:10 PM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wraptoryx`
--

-- --------------------------------------------------------

--
-- Table structure for table `instances`
--

CREATE TABLE IF NOT EXISTS `instances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `port` int(11) NOT NULL DEFAULT '8000',
  `file` varchar(2048) NOT NULL,
  `name` varchar(2048) NOT NULL,
  `weights` varchar(2048) DEFAULT NULL,
  `status` varchar(2048) DEFAULT 'down',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `instances`
--

INSERT INTO `instances` (`id`, `uid`, `port`, `file`, `name`, `weights`, `status`) VALUES
(2, 2, 8000, '120613092505.csv', 'test', '1,1,1,1,1,1,1', 'down'),
(3, 2, 8001, '120613101504.csv', 'mine', '1,1,1,1,1,1,1', 'down'),
(4, 2, 8002, '120613110608.csv', 'myinstance', '1,1,1,1', 'down'),
(5, 2, 8002, '120613142451.csv', 'myinstance', '1,1,1,1', 'down');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2048) NOT NULL,
  `email` varchar(2048) NOT NULL,
  `username` varchar(2048) NOT NULL,
  `password` varchar(2048) NOT NULL,
  `confirmcode` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `confirmcode`) VALUES
(2, 'admin', 'wverayin@stratpoint.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
