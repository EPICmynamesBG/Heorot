-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Oct 24, 2016 at 07:06 PM
-- Server version: 5.5.42
-- PHP Version: 7.0.8

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
  `featured` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Beer`
--

INSERT INTO `Beer` (`id`, `name`, `size`, `ibu`, `brewery_id`, `abv`, `description`, `cost`, `style`, `featured`) VALUES
(3, 'Death By Coconut', '12 oz.', 25, 1, 6, 'Irish porter with cocoa and coconut.', 4.75, 3, '2016-10-24 16:34:21');

-- --------------------------------------------------------

--
-- Table structure for table `Brewery`
--

CREATE TABLE `Brewery` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `location` varchar(500) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Brewery`
--

INSERT INTO `Brewery` (`id`, `name`, `location`) VALUES
(1, 'Oskar Blues Brewing', 'Longmont, CO');

-- --------------------------------------------------------

--
-- Table structure for table `Style`
--

CREATE TABLE `Style` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Style`
--

INSERT INTO `Style` (`id`, `name`) VALUES
(1, 'Unknown'),
(2, 'Other'),
(3, 'Irish Porter');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Brewery`
--
ALTER TABLE `Brewery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Style`
--
ALTER TABLE `Style`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
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
