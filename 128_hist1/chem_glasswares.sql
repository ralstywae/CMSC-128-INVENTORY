-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2018 at 08:05 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chem_glasswares`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrower`
--

CREATE TABLE `borrower` (
  `Borrower_Id` int(11) NOT NULL,
  `First_Name` varchar(256) NOT NULL,
  `Last_Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrower`
--

INSERT INTO `borrower` (`Borrower_Id`, `First_Name`, `Last_Name`) VALUES
(1, 'Kiana Alessandra ', 'Villaera'),
(2, 'Ralston Mark', 'Chan'),
(3, 'Karl Vinzon', 'Mabutas'),
(4, 'Bernadette', 'Genove');

-- --------------------------------------------------------

--
-- Table structure for table `borrower_group`
--

CREATE TABLE `borrower_group` (
  `Borrower_Group_Id` int(11) NOT NULL,
  `Group_Id` int(11) NOT NULL,
  `Borrower_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrower_group`
--

INSERT INTO `borrower_group` (`Borrower_Group_Id`, `Group_Id`, `Borrower_Id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `chemicals`
--

CREATE TABLE `chemicals` (
  `Chemical_Id` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Quantity_Available_ml` float NOT NULL,
  `Quantity_Available_mg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chemicals`
--

INSERT INTO `chemicals` (`Chemical_Id`, `Name`, `Quantity_Available_ml`, `Quantity_Available_mg`) VALUES
(4, 'trulalu', 35, 0),
(6, 'Jalapeno Sauce', 100, 0),
(25, 'Good stuff', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `glasswares`
--

CREATE TABLE `glasswares` (
  `Glassware_Id` int(11) NOT NULL,
  `Name` varchar(256) NOT NULL,
  `Quantity_Available` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `glasswares`
--

INSERT INTO `glasswares` (`Glassware_Id`, `Name`, `Quantity_Available`) VALUES
(1, 'BONG BONG MARCOS', 6),
(2, 'Hammer', 3),
(3, 'Lofi Stereo', 2);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `Group_Id` int(11) NOT NULL,
  `Professor` varchar(256) NOT NULL,
  `Subject` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`Group_Id`, `Professor`, `Subject`) VALUES
(1, 'Sir Lee Javellana', 'Cmsc 128'),
(2, 'Ma''am Ash Balangcod', 'Cmsc 125');

-- --------------------------------------------------------

--
-- Table structure for table `page_permissions`
--

CREATE TABLE `page_permissions` (
  `User_Id` int(11) NOT NULL,
  `Page_Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_Id` int(11) NOT NULL,
  `First_Name` varchar(256) NOT NULL,
  `Last_Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_Id`, `First_Name`, `Last_Name`) VALUES
(1, 'Kiana Alessandra', 'V. Villaera');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Trans_Id` int(11) NOT NULL,
  `Glassware_Id` int(11) DEFAULT NULL,
  `Chemical_Id` int(11) DEFAULT NULL,
  `Group_Id` int(11) NOT NULL,
  `Qty_Borrowed_Glasswares` int(11) NOT NULL,
  `Qty_Borrowed_Chemicals_ml` float NOT NULL,
  `Qty_Borrowed_Chemicals_mg` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Trans_Id`, `Glassware_Id`, `Chemical_Id`, `Group_Id`, `Qty_Borrowed_Glasswares`, `Qty_Borrowed_Chemicals_ml`, `Qty_Borrowed_Chemicals_mg`) VALUES
(5, 1, NULL, 1, 1, 0, 0),
(6, NULL, 4, 2, 0, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `Trans_History_Id` int(11) NOT NULL,
  `Trans_Id` int(11) NOT NULL,
  `Date_Borrowed` date NOT NULL,
  `Date_Returned` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`Trans_History_Id`, `Trans_Id`, `Date_Borrowed`, `Date_Returned`) VALUES
(1, 5, '2018-04-09', '2018-04-10'),
(2, 6, '2018-04-08', '2018-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `User_Id` int(11) NOT NULL,
  `Staff_Id` int(11) NOT NULL,
  `Username` varchar(256) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`User_Id`, `Staff_Id`, `Username`, `Password`, `status`) VALUES
(1, 1, 'admin', '$2y$10$TXqiyhSKm/2zWJT843WsaurTzjpxrvQ5vNq/VCnLj8QLasfE.KWWu', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrower`
--
ALTER TABLE `borrower`
  ADD PRIMARY KEY (`Borrower_Id`);

--
-- Indexes for table `borrower_group`
--
ALTER TABLE `borrower_group`
  ADD PRIMARY KEY (`Borrower_Group_Id`),
  ADD KEY `Group_Id` (`Group_Id`),
  ADD KEY `Borrower_Id` (`Borrower_Id`);

--
-- Indexes for table `chemicals`
--
ALTER TABLE `chemicals`
  ADD PRIMARY KEY (`Chemical_Id`);

--
-- Indexes for table `glasswares`
--
ALTER TABLE `glasswares`
  ADD PRIMARY KEY (`Glassware_Id`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`Group_Id`);

--
-- Indexes for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `Page_Name` (`Page_Name`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_Id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Trans_Id`),
  ADD KEY `Glassware_Id` (`Glassware_Id`),
  ADD KEY `Chemical_Id` (`Chemical_Id`),
  ADD KEY `Group_Id` (`Group_Id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`Trans_History_Id`),
  ADD KEY `Trans_Id` (`Trans_Id`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`User_Id`),
  ADD KEY `Staff_Id` (`Staff_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower`
--
ALTER TABLE `borrower`
  MODIFY `Borrower_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `borrower_group`
--
ALTER TABLE `borrower_group`
  MODIFY `Borrower_Group_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `chemicals`
--
ALTER TABLE `chemicals`
  MODIFY `Chemical_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `glasswares`
--
ALTER TABLE `glasswares`
  MODIFY `Glassware_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `Group_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Trans_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `Trans_History_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_accounts`
--
ALTER TABLE `user_accounts`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrower_group`
--
ALTER TABLE `borrower_group`
  ADD CONSTRAINT `borrower_group_ibfk_1` FOREIGN KEY (`Group_Id`) REFERENCES `group` (`Group_Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `borrower_group_ibfk_2` FOREIGN KEY (`Borrower_Id`) REFERENCES `borrower` (`Borrower_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `page_permissions`
--
ALTER TABLE `page_permissions`
  ADD CONSTRAINT `page_permissions_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `user_accounts` (`User_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`Glassware_Id`) REFERENCES `glasswares` (`Glassware_Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`Chemical_Id`) REFERENCES `chemicals` (`Chemical_Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`Group_Id`) REFERENCES `group` (`Group_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`Trans_Id`) REFERENCES `transaction` (`Trans_Id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD CONSTRAINT `user_accounts_ibfk_1` FOREIGN KEY (`Staff_Id`) REFERENCES `staff` (`Staff_Id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
