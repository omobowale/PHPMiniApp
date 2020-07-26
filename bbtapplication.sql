-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2020 at 08:40 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbtapplication`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesscodestable`
--

CREATE TABLE `accesscodestable` (
  `id` int(11) NOT NULL,
  `accesscode` varchar(64) NOT NULL,
  `registrationstatus` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accesscodestable`
--

INSERT INTO `accesscodestable` (`id`, `accesscode`, `registrationstatus`) VALUES
(1, '5b55bb7c3ca18d63e11b8a2ae01b66ae5c5351a257ed46ef0fd046205a3d3930', 0),
(2, 'cda5a14c597b566a6cfd85caf83079fcb956dfb31ad8d40d90e5be2a23d88d40', 0),
(3, '8cb3018c43ba24199a91ea383068878effbcec417e9f8fe9e31a38666ef16ffa', 0),
(4, '084c90dc1638bc4bf16f5e68b430dc061500ececb60bbc17b93267cb56e55101', 0),
(5, 'a19d14eb03105a20d85f7b97c3fe0c5d44188685aaaa1bfaf902078254723d51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `applicationdetails`
--

CREATE TABLE `applicationdetails` (
  `id` int(11) NOT NULL,
  `accesscode_id` varchar(64) NOT NULL,
  `firstname` varchar(40) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `address` text NOT NULL,
  `maritalstatus` varchar(8) NOT NULL,
  `edubg` text NOT NULL,
  `bestsubjects` text NOT NULL,
  `religion` varchar(12) NOT NULL,
  `stateoforigin` varchar(20) NOT NULL,
  `dateofbirth` date NOT NULL,
  `imageupload` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applicationdetails`
--

INSERT INTO `applicationdetails` (`id`, `accesscode_id`, `firstname`, `lastname`, `address`, `maritalstatus`, `edubg`, `bestsubjects`, `religion`, `stateoforigin`, `dateofbirth`, `imageupload`) VALUES
(1, '2b12e549723bb69347afed6b89f94b0bc9516c147aed9b6eeb9a8990f6bb92f6', 'asdfadsf', 'dfasdfadsf', 'dwfasdfqds', 'Single', 'asdfads', 'Mathematics', 'christianity', 'asdfads', '2020-07-15', '1595666622download.gif'),
(2, '44ad4c93ac307f9afdd118493322f4abbd63bbadb7b5b23f4341e48e2610fd81', 'asdfsd', 'fdasdf', 'dfasdf', 'Single', 'asdf', 'Mathematics', 'christianity', 'asdfadsf', '2020-07-06', '1595666749download.jpg'),
(3, '5b55bb7c3ca18d63e11b8a2ae01b66ae5c5351a257ed46ef0fd046205a3d3930', 'sdfasdfk', 'hdkjfhakjsdhf', 'kjdhfkjashdfkjasdf', 'Single', 'ajshdkfhakjsdh', 'Mathematics', 'christianity', 'asdfadsf', '2020-07-15', '1595688847download.gif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesscodestable`
--
ALTER TABLE `accesscodestable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicationdetails`
--
ALTER TABLE `applicationdetails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accesscode_id` (`accesscode_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesscodestable`
--
ALTER TABLE `accesscodestable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `applicationdetails`
--
ALTER TABLE `applicationdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
