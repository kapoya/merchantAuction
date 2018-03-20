CREATE DATABASE migs_auction_house;-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2018 at 09:49 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `migs_auction_house`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `ID` int(11) NOT NULL,
  `item_ID` int(11) DEFAULT NULL,
  `date_started` datetime NOT NULL,
  `date_deadline` datetime NOT NULL,
  `number_of_biddings` int(11) NOT NULL,
  `highest_bid_ID` int(11) DEFAULT NULL,
  `starting_bid` float NOT NULL,
  `buyout` float NOT NULL,
  `status` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auction_item`
--

CREATE TABLE `auction_item` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_condition` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE `bid` (
  `ID` int(11) NOT NULL,
  `auction_ID` int(11) NOT NULL,
  `bidder_ID` int(11) NOT NULL,
  `date_of_bid` datetime NOT NULL,
  `amt` float NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WINNING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `fname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` bigint(11) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `trust_rating` tinyint(11) DEFAULT '5',
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `fname`, `lname`, `username`, `password`, `email_address`, `phone_number`, `type`, `trust_rating`, `profile_photo`) VALUES
(1, 'Simon', 'Tantuan', 'HybrdMonky', 'monocromatic', 'slandotski@gmail.com', 9954286065, 'admin', 5, 'images/eyy.png'),
(2, 'Miguel', 'Sarmiento', 'kapoya', 'bk201', 'rlbk201@gmail.com', 999999990, 'admin', 5, NULL),
(3, 'Warren', 'Garen', 'waga', '123qwe', 'waga@gmail.com', 92344567, 'customer', 5, NULL),
(26, 'qwe', 'qwe', 'qwe', 'qwe', 'qwe@gmail.com', 9954286065, 'customer', 5, 'images/Yuuki Asuna.gif'),
(27, 'pristine', 'pristine', 'pristine', '123qwe', 'pristine@gmail.com', 9324123124, 'customer', 5, 'images/eyy.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `it_id` (`item_ID`),
  ADD KEY `wb_id` (`highest_bid_ID`);

--
-- Indexes for table `auction_item`
--
ALTER TABLE `auction_item`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `seller_ID` (`seller_ID`);

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `bidder_ID` (`bidder_ID`),
  ADD KEY `auction_ID` (`auction_ID`),
  ADD KEY `bidder_ID_2` (`bidder_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `auction_item`
--
ALTER TABLE `auction_item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auction`
--
ALTER TABLE `auction`
  ADD CONSTRAINT `it_id` FOREIGN KEY (`item_ID`) REFERENCES `auction_item` (`ID`),
  ADD CONSTRAINT `wb_id` FOREIGN KEY (`highest_bid_ID`) REFERENCES `bid` (`ID`);

--
-- Constraints for table `auction_item`
--
ALTER TABLE `auction_item`
  ADD CONSTRAINT `se_id` FOREIGN KEY (`seller_ID`) REFERENCES `user` (`ID`);

--
-- Constraints for table `bid`
--
ALTER TABLE `bid`
  ADD CONSTRAINT `au_id` FOREIGN KEY (`auction_ID`) REFERENCES `auction` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bd_id` FOREIGN KEY (`bidder_ID`) REFERENCES `user` (`ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
