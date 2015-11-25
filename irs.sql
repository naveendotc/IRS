-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 24, 2015 at 09:56 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `CurrentIssuesWithSolvers`
--

INSERT INTO `CurrentIssuesWithSolvers` (`tid_ciws`, `user_id`, `cur_issues`) VALUES
(1, 'dotc', 1),
(2, 'SolverTwo', 2),
(3, 'newType1Solver', 7),
(4, 'newType2Solver', 4),
(5, '3_typ1_solver', 6);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`issue_id`, `user_id`, `raisedTime`, `subject`, `type`, `description`, `issue_status`, `currDelegTo_uid`, `prevDelegTo_uid`, `prevComment`, `issueHist_TimeStamps`, `issueHist_Statuses`, `issueHist_Delegatees`, `issueHist_Comments`, `solved_Time`, `solvedBy_user_id`) VALUES
(3, 'jaspreeth', '0000-00-00 00:00:00', 'NewIssue', 'Type-1', 'Check', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(4, 'jaspreeth', '0000-00-00 00:00:00', 'NewIssue', 'Type-1', 'Check', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(5, 'jaspreeth', '0000-00-00 00:00:00', 'Check Issue Transactions', 'Type-1', 'Check', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(6, 'jaspreeth', '0000-00-00 00:00:00', 'CheckIssueId', 'Type-3', 'Check', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(7, 'jaspreeth', '0000-00-00 00:00:00', 'CheckAgainIssueId', 'Type-1', 'Blah', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(8, 'jaspreeth', '0000-00-00 00:00:00', 'HelloWorld', 'Type-3', 'qwfqfw', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(9, 'jaspreeth', '0000-00-00 00:00:00', 'Nov12_730pm', 'Type-2', 'Checking at Nov12_730pm', 0, 'XYZ', '', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(10, 'jaspreeth', '0000-00-00 00:00:00', '12_Nov_7_36_pm', '', 'check', 0, 'newType1Solver', 'dotc', 'Delegating just like that', '', '', '', '', '0000-00-00 00:00:00', ''),
(11, 'jaspreeth', '0000-00-00 00:00:00', '12_Nov_7_38', '', 'chekc', 1, 'Solved', 'dotc', 'Solved Forever', '', '', '', '', '2015-11-13 20:06:25', 'dotc'),
(12, 'jaspreeth', '0000-00-00 00:00:00', '12_Nov_7_40', '', 'csasc', 0, 'SolverTwo', 'dotc', 'Delegating', '', '', '', '', '0000-00-00 00:00:00', ''),
(13, 'jaspreeth', '0000-00-00 00:00:00', '7_40_Again', 'Type-1', 'qwcqwc', 0, 'SolverTwo', 'dotc', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(14, 'jaspreeth', '0000-00-00 00:00:00', '12_nov_7_56', '', 'Submitting now', 1, 'Solved', 'SolverTwo', 'S 14', '', '', '', '', '2015-11-13 03:12:46', 'SolverTwo'),
(15, 'jaspreeth', '2015-11-12 20:11:37', '12_Nov_8_11', 'Type-1', 'check', 1, 'Solved', 'SolverTwo', 'S 15', '', '', '', '', '2015-11-13 03:12:52', 'SolverTwo'),
(16, 'jaspreeth', '2015-11-13 01:58:10', 'Nov_13_1_57_am', 'Type-1', 'qfqf', 1, 'Solved', 'dotc', '16Solved', '', '', '', '', '2015-11-13 02:49:04', 'dotc'),
(17, 'jaspreeth', '2015-11-13 01:59:39', '13_Nov_1_59am', 'Type-1', 'afa', 1, 'Solved', 'dotc', 'Solving 17 Now', '', '', '', '', '2015-11-13 02:46:08', 'dotc'),
(18, 'jaspreeth', '2015-11-13 02:02:21', 'qwdqwd', 'Type-1', 'qwdqwd', 1, 'Solved', 'dotc', 'Solved 18', '', '', '', '', '2015-11-13 02:42:21', 'dotc'),
(19, 'jaspreeth', '2015-11-13 02:03:12', 'advdav', 'Type-1', 'asvasv', 1, 'Solved', 'dotc', '???', '', '', '', '', '2015-11-13 02:33:47', 'dotc'),
(20, 'jaspreeth', '2015-11-13 02:03:55', 'qwcqc', 'Type-1', 'qcwqc', 0, '$uid', 'dotc', 'efqqf', '', '', '', '', '0000-00-00 00:00:00', ''),
(21, 'jaspreeth', '2015-11-13 02:06:07', 'qwcqwc', 'Type-1', 'qwcqwc', 0, '3_typ1_solver', 'dotc', 'delegating 21', '', '', '', '', '0000-00-00 00:00:00', ''),
(22, 'jaspreeth', '2015-11-13 16:29:32', 'Nov_13_4_29_pm', 'Type-1', 'check', 0, 'newaags', 'dotc', 'qwfqf', '', '', '', '', '0000-00-00 00:00:00', ''),
(23, 'jaspreeth', '2015-11-13 17:04:58', 'Nov_13_5_03_pm', 'Type-1', 'Does it go to newType1Solver ??', 0, 'newType1Solver', 'NEW', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(24, 'jaspreeth', '2015-11-13 20:04:01', 'qefqf', 'Type-1', 'qwfqwf', 0, '3_typ1_solver', 'NEW', '', '', '', '', '', '0000-00-00 00:00:00', ''),
(25, 'jaspreeth', '2015-11-14 02:16:36', 'Nov_14_2_16am', 'Type-1', 'posting now', 0, 'newType1Solver', 'dotc', 'Delg 25', '', '', '', '', '0000-00-00 00:00:00', ''),
(26, 'jaspreeth', '2015-11-14 02:16:58', 'Nov_14_2_17 am', 'Type-1', 'posting again\r\n', 0, 'dotc', 'NEW', '', '', '', '', '', '0000-00-00 00:00:00', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `issue_transactions`
--

INSERT INTO `issue_transactions` (`trans_id`, `trans_time`, `user_id`, `trans_type`, `issue_id`, `new_issue_status`, `new_issue_comments`, `delegatedTo`) VALUES
(1, '0000-00-00 00:00:00', 'jaspreeth', 1, 0, 0, 'NEW', 'XYZ'),
(2, '0000-00-00 00:00:00', 'jaspreeth', 1, 0, 0, 'NEW', 'XYZ'),
(3, '0000-00-00 00:00:00', 'jaspreeth', 1, 0, 0, 'NEW', 'XYZ'),
(4, '0000-00-00 00:00:00', 'jaspreeth', 1, 8, 0, 'NEW', 'XYZ'),
(5, '0000-00-00 00:00:00', 'jaspreeth', 1, 9, 0, 'NEW', 'XYZ'),
(6, '0000-00-00 00:00:00', 'jaspreeth', 1, 10, 0, 'NEW', 'dotc'),
(7, '0000-00-00 00:00:00', 'jaspreeth', 1, 11, 0, 'NEW', 'dotc'),
(8, '0000-00-00 00:00:00', 'jaspreeth', 1, 12, 0, 'NEW', 'dotc'),
(9, '0000-00-00 00:00:00', 'jaspreeth', 1, 13, 0, 'NEW', 'dotc'),
(10, '0000-00-00 00:00:00', 'jaspreeth', 1, 14, 0, 'NEW', 'dotc'),
(11, '2015-11-12 20:11:37', 'jaspreeth', 1, 15, 0, 'NEW', 'dotc'),
(12, '2015-11-13 01:58:10', 'jaspreeth', 1, 16, 0, 'NEW', 'dotc'),
(13, '2015-11-13 01:59:39', 'jaspreeth', 1, 17, 0, 'NEW', 'dotc'),
(14, '2015-11-13 02:02:21', 'jaspreeth', 1, 18, 0, 'NEW', 'dotc'),
(15, '2015-11-13 02:03:12', 'jaspreeth', 1, 19, 0, 'NEW', 'dotc'),
(16, '2015-11-13 02:03:55', 'jaspreeth', 1, 20, 0, 'NEW', 'dotc'),
(17, '2015-11-13 02:06:07', 'jaspreeth', 1, 21, 0, 'NEW', 'dotc'),
(18, '2015-11-13 02:42:21', 'dotc', 3, 18, 1, 'Solved 18', 'Solved'),
(19, '2015-11-13 02:46:08', 'dotc', 3, 17, 1, 'Solving 17 Now', 'Solved'),
(20, '2015-11-13 02:49:04', 'dotc', 3, 16, 1, '16Solved', 'Solved'),
(21, '2015-11-13 03:11:17', 'dotc', 4, 14, 0, 'Del 14 To SolverTwo', 'SolverTwo'),
(22, '2015-11-13 03:12:46', 'SolverTwo', 3, 14, 1, 'S 14', 'Solved'),
(23, '2015-11-13 03:12:52', 'SolverTwo', 3, 15, 1, 'S 15', 'Solved'),
(24, '2015-11-13 16:29:32', 'jaspreeth', 1, 22, 0, 'NEW', 'dotc'),
(25, '2015-11-13 17:04:58', 'jaspreeth', 1, 23, 0, 'NEW', 'newType1Solver'),
(26, '2015-11-13 20:04:01', 'jaspreeth', 1, 24, 0, 'NEW', '3_typ1_solver'),
(27, '2015-11-13 20:06:09', 'dotc', 4, 10, 0, 'Delegating just like that', 'newType1Solver'),
(28, '2015-11-13 20:06:25', 'dotc', 3, 11, 1, 'Solved Forever', 'Solved'),
(29, '2015-11-14 01:52:13', 'dotc', 4, 12, 0, 'Delegating', 'SolverTwo'),
(30, '2015-11-14 01:57:12', 'dotc', 4, 13, 0, '', 'SolverTwo'),
(31, '2015-11-14 02:07:29', 'dotc', 4, 20, 0, 'efqqf', '$uid'),
(32, '2015-11-14 02:13:13', 'dotc', 4, 21, 0, 'delegating 21', '3_typ1_solver'),
(33, '2015-11-14 02:13:31', 'dotc', 4, 22, 0, 'qwfqf', 'newaags'),
(34, '2015-11-14 02:16:36', 'jaspreeth', 1, 25, 0, 'NEW', 'dotc'),
(35, '2015-11-14 02:16:58', 'jaspreeth', 1, 26, 0, 'NEW', 'dotc'),
(36, '2015-11-14 02:27:00', 'dotc', 4, 25, 0, 'Delg 25', 'newType1Solver');

-- --------------------------------------------------------

--
-- Table structure for table `raised_issues`
--

CREATE TABLE IF NOT EXISTS `raised_issues` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `raised_issues`
--

INSERT INTO `raised_issues` (`id`, `user_id`, `subject`, `type`, `description`, `status`) VALUES
(3, 'jaspreeth', 'a', 'Type-1', 'a', 1),
(4, 'sachin', 'ads', 'Type-1', 'awcw', 1),
(5, 'dotc', 'Sandeep kakruthi', 'Type-1', 'Kakruthi fellow of IITB', 1),
(6, 'dotc', 'a', 'Type-1', 'ccqw', 1),
(7, 'dotc', 'a', 'Type-1', 'a', 1),
(8, 'dotc', 'b', 'Type-1', 'b', 1),
(9, 'dotc', 'a', 'Type-1', 'a', 1),
(10, 'dotc', 'b', 'Type-1', 'b', 1),
(11, 'jaspreeth', '', '', 'a', 0),
(12, 'jaspreeth', '', '', 'a', 0),
(13, 'jaspreeth', '', '', 'k', 0),
(14, 'jaspreeth', 's', 'Type-1', 'c', 0),
(15, 'jaspreeth', 'das', 'type-2', 'qdsq', 0),
(16, 'jaspreeth', 'ads', 'type-2', 'dws', 0),
(17, 'dotc', 'sxt,thj,d', 'type-2', 'sgmydku', 0);

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

--
-- Dumping data for table `solvers`
--

INSERT INTO `solvers` (`id`, `solver_id`, `type_of_issue`) VALUES
(1, 'dotc', 'Type-1');

-- --------------------------------------------------------

--
-- Table structure for table `solvers_issueTypes`
--

CREATE TABLE IF NOT EXISTS `solvers_issueTypes` (
  `tid_solvers` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`tid_solvers`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `solvers_issueTypes`
--

INSERT INTO `solvers_issueTypes` (`tid_solvers`, `user_id`, `type`) VALUES
(2, 'dotc', 'Type-1'),
(3, 'SolverTwo', 'Type-2'),
(4, 'newType1Solver', 'Type-1'),
(5, 'newType2Solver', 'Type-2'),
(6, '3_typ1_solver', 'Type-1');

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

--
-- Dumping data for table `solver_requests`
--

INSERT INTO `solver_requests` (`id`, `user_id`, `for_type`) VALUES
(1, 'jaspreeth', 'Type-1');

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
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`full_name`, `user_id`, `password`, `acc_status`, `encrypt_url`, `email_id`, `phone_number`, `privileges`) VALUES
('Naveen Cherupally', 'dotc', 'dotc', 1, 'vbiewrofb23p', 'ncherupally@gmail.com', 8125760968, 1),
('Jaspreeth', 'jaspreeth', 'jaspreeth', 1, 'fbewivbew9', 'jasbatra2811@gmail.com', 9364838351, 0),
('Tendulkar', 'sachin', 'sachin', 1, 'fweifcb', 'sachin@gmail.com', 9472648910, 2),
('Solver Two', 'SolverTwo', 's2s2', 1, 'blah', 'blah@blah.blah', 22, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
