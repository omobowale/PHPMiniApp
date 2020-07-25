-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2020 at 07:53 PM
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicationdetails`
--
ALTER TABLE `applicationdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
