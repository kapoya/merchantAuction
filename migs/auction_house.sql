

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `auction` (
  `ID` int(11) NOT NULL,
  `item_ID` int(11) DEFAULT NULL,
  `date_started` datetime NOT NULL,
  `date_deadline` datetime NOT NULL,
  `number_of_biddings` int(11) NOT NULL,
  `winning_bid_ID` int(11) DEFAULT NULL,
  `buyout` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `auction` (`ID`, `item_ID`, `date_started`, `date_deadline`, `number_of_biddings`, `winning_bid_ID`, `buyout`) VALUES
(4, 1, '2018-03-06 05:48:32', '2018-03-10 00:00:00', 8, 1, 300),
(7, 2, '2018-03-04 00:00:00', '2018-03-10 00:00:00', 8, NULL, 8000),
(12, 22, '2018-03-06 00:00:00', '2018-03-10 00:00:00', 0, NULL, 1100),
(13, 23, '2018-03-06 00:00:00', '2018-03-29 20:09:00', 0, NULL, 150),
(14, 24, '2018-03-06 17:38:14', '2018-03-17 00:00:00', 0, NULL, 900);


CREATE TABLE `auction_item` (
  `ID` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `type` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_condition` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `auction_item` (`ID`, `name`, `seller_ID`, `type`, `item_condition`, `image`) VALUES
(1, 'Gillete Razor', 1, 'lol', 'brand new', NULL),
(2, 'USC ID Slings', 1, 'Accessory', 'brand new', NULL),
(22, 'Huawei Mobile Phone', 1, 'Electronic', 'brandnew', 'images/28383093_1834743913223216_1252641804_n.jpg'),
(23, 'Lolski', 1, 'Ambut', 'defective', 'images/kagura_5yrsolder.jpg'),
(24, 'Centrum Silver', 1, 'Medicine', 'brandnew', 'images/aGj1005_700b.jpg');



CREATE TABLE `bid` (
  `ID` int(11) NOT NULL,
  `auction_ID` int(11) NOT NULL,
  `bidder_ID` int(11) NOT NULL,
  `date_of_bid` datetime NOT NULL,
  `amt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `bid` (`ID`, `auction_ID`, `bidder_ID`, `date_of_bid`, `amt`) VALUES
(1, 4, 1, '2018-03-04 00:00:00', 230.5);



CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `fname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` int(11) NOT NULL,
  `wallet` float NOT NULL DEFAULT '0',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `trust_rating` int(11) NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `user` (`ID`, `fname`, `lname`, `username`, `password`, `email_address`, `phone_number`, `wallet`, `type`, `trust_rating`, `profile_photo`) VALUES
(1, 'Simon', 'Tantuan', 'HybrdMonky', 'monocromatic', 'slandotski@gmail.com', 954286065, 0, 'admin', 5, NULL);


ALTER TABLE `auction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `it_id` (`item_ID`),
  ADD KEY `wb_id` (`winning_bid_ID`);


ALTER TABLE `auction_item`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `seller_ID` (`seller_ID`);


ALTER TABLE `bid`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `bidder_ID` (`bidder_ID`),
  ADD KEY `auction_ID` (`auction_ID`),
  ADD KEY `bidder_ID_2` (`bidder_ID`);


ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `auction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `auction_item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;


ALTER TABLE `bid`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `auction`
  ADD CONSTRAINT `it_id` FOREIGN KEY (`item_ID`) REFERENCES `auction_item` (`ID`),
  ADD CONSTRAINT `wb_id` FOREIGN KEY (`winning_bid_ID`) REFERENCES `bid` (`ID`);


ALTER TABLE `auction_item`
  ADD CONSTRAINT `se_id` FOREIGN KEY (`seller_ID`) REFERENCES `user` (`ID`);


ALTER TABLE `bid`
  ADD CONSTRAINT `au_id` FOREIGN KEY (`auction_ID`) REFERENCES `auction` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `bd_id` FOREIGN KEY (`bidder_ID`) REFERENCES `user` (`ID`) ON UPDATE CASCADE;
COMMIT;

