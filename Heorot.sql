-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2016 at 04:33 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Heorot`
--
CREATE DATABASE IF NOT EXISTS `Heorot` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `Heorot`;

-- --------------------------------------------------------

--
-- Table structure for table `Beer`
--

CREATE TABLE `Beer` (
  `id` int(11) NOT NULL,
  `name` varchar(400) NOT NULL,
  `size` varchar(100) DEFAULT NULL,
  `ibu` int(10) unsigned DEFAULT NULL,
  `brewery_id` int(11) NOT NULL,
  `abv` double DEFAULT NULL,
  `description` text,
  `cost` double NOT NULL,
  `style` int(11) unsigned NOT NULL DEFAULT '1',
  `featured` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Brewery`
--

CREATE TABLE `Brewery` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `location` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Style`
--

CREATE TABLE `Style` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Style`
--

INSERT INTO `Style` (`id`, `name`) VALUES
(1, 'Unknown'),
(2, 'Other');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Beer`
--
ALTER TABLE `Beer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Brewery` (`brewery_id`),
  ADD KEY `fk_style` (`style`);

--
-- Indexes for table `Brewery`
--
ALTER TABLE `Brewery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Style`
--
ALTER TABLE `Style`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Beer`
--
ALTER TABLE `Beer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Brewery`
--
ALTER TABLE `Brewery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Style`
--
ALTER TABLE `Style`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Beer`
--
ALTER TABLE `Beer`
  ADD CONSTRAINT `fk_Brewery` FOREIGN KEY (`brewery_id`) REFERENCES `Brewery` (`id`),
  ADD CONSTRAINT `fk_style` FOREIGN KEY (`style`) REFERENCES `Style` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
