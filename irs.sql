-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2015 at 02:35 PM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `irs`
--

-- --------------------------------------------------------

--
-- Table structure for table `CurrentIssuesWithSolvers`
--

CREATE TABLE IF NOT EXISTS `CurrentIssuesWithSolvers` (
  `tid_ciws` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `cur_issues` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid_ciws`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `CurrentIssuesWithSolvers`
--

INSERT INTO `CurrentIssuesWithSolvers` (`tid_ciws`, `user_id`, `cur_issues`) VALUES
(6, 'ST11', 1),
(7, 'ST12', 0),
(8, 'ST13', 0),
(9, 'ST21', 1),
(10, 'ST22', 0),
(11, 'ST23', 0),
(12, 'ST31', 1),
(13, 'ST32', 0),
(14, 'ST33', 0),
(15, 'Manager', 0);

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
  `issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `raisedTime` datetime NOT NULL,
  `subject` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `issue_status` int(1) NOT NULL,
  `currDelegTo_uid` varchar(30) NOT NULL,
  `prevDelegTo_uid` varchar(30) NOT NULL DEFAULT 'NEW',
  `prevComment` varchar(500) NOT NULL,
  `issueHist_TimeStamps` varchar(1000) NOT NULL,
  `issueHist_Statuses` varchar(500) NOT NULL,
  `issueHist_Delegatees` varchar(1000) NOT NULL,
  `issueHist_Comments` varchar(2000) NOT NULL,
  `solved_Time` datetime NOT NULL,
  `solvedBy_user_id` varchar(30) NOT NULL,
  PRIMARY KEY (`issue_id`),
  UNIQUE KEY `issues_id` (`issue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`issue_id`, `user_id`, `raisedTime`, `subject`, `type`, `description`, `issue_status`, `currDelegTo_uid`, `prevDelegTo_uid`, `prevComment`, `issueHist_TimeStamps`, `issueHist_Statuses`, `issueHist_Delegatees`, `issueHist_Comments`, `solved_Time`, `solvedBy_user_id`) VALUES
(37, 'Amit', '2015-11-26 12:23:55', 'Final_1223', 'Type-1', 'Finalzz 1223', 1, 'Solved', 'ST12', 'Solving Issue 37', '2015-11-26 12:23:55;2015-11-26 12:28:16;2015-11-26 12:29:14;', '0;0;1;', 'ST11;ST12;Solved;', 'ISSUE REGISTERED BY Amit;To ST12;Solving Issue 37;', '2015-11-26 12:29:14', 'ST12'),
(38, 'Nav', '2015-11-26 12:29:44', 'Final_1229', 'Type-1', 'Finalzzz 1229', 0, 'ST11', 'Manager', 'Type Assigned as Type-1', '2015-11-26 12:29:44;2015-11-26 14:25:30;', '0;0;', 'Manager;ST11;', 'ISSUE REGISTERED BY Nav;Type Assigned as Type-1;', '0000-00-00 00:00:00', ''),
(39, 'Nav', '2015-11-26 13:07:55', 'Final_107', 'Type-2', 'Finallzzzz', 0, 'ST21', 'NEW', 'NEW', '2015-11-26 13:07:55;', '0;', 'ST21;', 'ISSUE REGISTERED BY Nav;', '0000-00-00 00:00:00', ''),
(40, 'Amit', '2015-11-26 14:27:31', 'Final_227', 'Type-3', 'I donot know.', 0, 'ST31', 'Manager', 'Type Assigned as Type-3', '2015-11-26 14:27:31;2015-11-26 14:28:13;', '0;0;', 'Manager;ST31;', 'ISSUE REGISTERED BY Amit;Type Assigned as Type-3;', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `issue_transactions`
--

CREATE TABLE IF NOT EXISTS `issue_transactions` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_time` datetime NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `new_issue_status` int(11) NOT NULL,
  `new_issue_comments` varchar(300) NOT NULL,
  `delegatedTo` varchar(30) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `issue_transactions`
--

INSERT INTO `issue_transactions` (`trans_id`, `trans_time`, `user_id`, `trans_type`, `issue_id`, `new_issue_status`, `new_issue_comments`, `delegatedTo`) VALUES
(54, '2015-11-26 12:23:55', 'Amit', 1, 37, 0, 'NEW', 'ST11'),
(55, '2015-11-26 12:28:16', 'ST11', 4, 37, 0, 'To ST12', 'ST12'),
(56, '2015-11-26 12:29:14', 'ST12', 3, 37, 1, 'Solving Issue 37', 'Solved'),
(57, '2015-11-26 12:29:44', 'Nav', 1, 38, 0, 'NEW', 'Manager'),
(58, '2015-11-26 13:07:55', 'Nav', 1, 39, 0, 'NEW', 'ST21'),
(59, '2015-11-26 14:25:30', 'Manager', 9, 38, 0, 'Type Assigned as Type-1', 'ST11'),
(60, '2015-11-26 14:27:31', 'Amit', 1, 40, 0, 'NEW', 'Manager'),
(61, '2015-11-26 14:28:13', 'Manager', 9, 40, 0, 'Type Assigned as Type-3', 'ST31');

-- --------------------------------------------------------

--
-- Table structure for table `solvers`
--

CREATE TABLE IF NOT EXISTS `solvers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `solver_id` varchar(30) NOT NULL,
  `type_of_issue` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `solvers_issueTypes`
--

CREATE TABLE IF NOT EXISTS `solvers_issueTypes` (
  `tid_solvers` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`tid_solvers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `solvers_issueTypes`
--

INSERT INTO `solvers_issueTypes` (`tid_solvers`, `user_id`, `type`) VALUES
(7, 'ST11', 'Type-1'),
(8, 'ST12', 'Type-1'),
(9, 'ST13', 'Type-1'),
(10, 'ST21', 'Type-2'),
(11, 'ST22', 'Type-2'),
(12, 'ST23', 'Type-2'),
(13, 'ST31', 'Type-3'),
(14, 'ST32', 'Type-3'),
(15, 'ST33', 'Type-3');

-- --------------------------------------------------------

--
-- Table structure for table `solver_requests`
--

CREATE TABLE IF NOT EXISTS `solver_requests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `for_type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `full_name` varchar(50) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `acc_status` int(1) NOT NULL,
  `encrypt_url` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `phone_number` bigint(10) NOT NULL,
  `privileges` int(1) NOT NULL,
  `reset_status` int(11) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`full_name`, `user_id`, `password`, `acc_status`, `encrypt_url`, `email_id`, `phone_number`, `privileges`, `reset_status`) VALUES
('Amit', 'Amit', '76b1832478b510fa51d4b2ef52dfd59ca0400db1', 1, 'xyz', 'xyz@xyz4.com', 9444949, 0, 0),
('dotc', 'dotc', '4ff72bc03dba6fc0749bddf5e7c99b36e2e2524c', 1, '4ff72bc03dba6fc0749bddf5e7c99b36e2e2524c', 'ncherupally@gmail.com', 8125760968, 1, 0),
('Jas', 'Jas', '6201de23c7ceb366b024d639ec160438de89ccc1', 1, 'xyz', 'xyz@xyz2.com', 9898989898, 0, 0),
('Jaspreet', 'jaspreeth', '8ca59b3556a0ffdf4f9b64ac9122323d87abdd82', 1, '1e4cacecf92bae3c252ec315342569010058175f', '15305R005@iitb.ac.in', 9123456789, 0, 0),
('Manager', 'Manager', '1a8565a9dc72048ba03b4156be3e569f22771f23', 1, 'xyz', 'xyz@xyz.com', 9999999999, 2, 0),
('Nav', 'Nav', 'fea877d4f0f1699da0f936f6f27d8cea307ef5e1', 1, 'xyz', 'xyz@xyz3.com', 9494949, 0, 0),
('sachin', 'sachin', '6fa04ae60770216a92b9effc55224ebae22214d7', 1, '6fa04ae60770216a92b9effc55224ebae22214d7', 'naveendotc@cse.iitb.ac.in', 8125760968, 2, 0),
('ST11', 'ST11', '51e807f48c08665626e931e569b73b2451f86a9a', 1, 'xyz', 'xyz@xyz4.com', 999995, 1, 0),
('ST12', 'ST12', '7315166ae244ed6e380a876e9e2ff7557d4c5231', 1, 'xyz', 'xyz@xyz12.com', 9999912, 1, 0),
('ST13', 'ST13', 'a57e24bb45137856994f352395060648f5e86a7d', 1, 'xyz', 'xyz@xyz13.com', 9999913, 1, 0),
('ST21', 'ST21', 'b0d63bb824544fd38463acf51a81c50b05368403', 1, 'xyz', 'xyz@xyz21.com', 9999921, 1, 0),
('ST22', 'ST22', '8251d0b4565eff0b3358e112c43311542163ad8a', 1, 'xyz', 'xyz@xyz22.com', 9999922, 1, 0),
('ST23', 'ST23', '2d57487a167e60ea20e42082387a59d6549945fa', 1, 'xyz', 'xyz@xyz23.com', 9999923, 1, 0),
('ST31', 'ST31', '1a4fab79c10060ecc3c505a8bb7d349aa97b10df', 1, 'xyz', 'xyz@xyz31.com', 9999931, 1, 0),
('ST32', 'ST32', 'd64f5c85af4aa781d3a94bf48c974d472074b257', 1, 'xyz', 'xyz@xyz32.com', 9999932, 1, 0),
('ST33', 'ST33', 'df42f8d35e65f40592e1a25e6db58faadc631ccd', 1, 'xyz', 'xyz@xyz33.com', 9999933, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
