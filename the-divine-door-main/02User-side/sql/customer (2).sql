-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 23, 2025 at 08:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Registration` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Gender` varchar(7) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `State` varchar(20) NOT NULL,
  `Cellno` varchar(20) NOT NULL,
  `adminProfile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `Email`, `Password`, `Registration`, `FirstName`, `LastName`, `Gender`, `Address`, `State`, `Cellno`, `adminProfile`) VALUES
(1, 'keyur@gmail.com', '1212', 0, '', '', '', '', '', '', 'pranav.jpg'),
(5, 'keyurbbhuva@gmail.com', 'asaas', 123, 'as', 'kjhadsf', 'male', 'asssas', 'Gujarat', '1234567890', 'Screenshot 2024-08-07 175207.png');

-- --------------------------------------------------------

--
-- Table structure for table `admin005`
--

CREATE TABLE `admin005` (
  `Admin_id` varchar(5) NOT NULL,
  `Admin_name` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Contact_no` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(2, 'Kitchen & Dining Decor'),
(3, 'Outdoor Oasis'),
(4, 'Wall Decor'),
(5, 'Gardening'),
(6, 'Vases'),
(7, 'Table Decor'),
(8, 'Artificial Plants & Flowe'),
(9, 'Pots and Planters'),
(10, 'Wall Art and Paintings');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cid` int(11) NOT NULL,
  `C_name` varchar(25) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Contact_no` bigint(20) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Area_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cid`, `C_name`, `Email`, `Password`, `Address`, `Contact_no`, `Gender`, `Area_id`) VALUES
(1, 'jenish', 'kk@a.com', '1234', 'kklklkkklklkkl', 1234567890, 'male', 123456),
(2, 'uhusjds', 'dsa@gmail.com', 'asas', 'kkkasldjljsdmfnsd', 1234567890, 'male', 123456),
(3, 'kambu', 'dsaa@gmail.com', 'yourass', 'llalalalalalllaaaaalalala', 1234567890, 'male', 225123),
(4, 'pratik', 'pratik@gmail.com', '74b87337454200d4d33f80c4663dc5', '', 1234567890, '', 0),
(5, 'Keyur Bhuva', 'keyurbbhuva@gmail.com', 'wFJCODzvp4', '', 9104991910, '', 0),
(6, 'akshay', 'akshay@gmail.com', 'A2345678', '', 9876543217, '', 0),
(7, 'sp', 'sp@gmail.com', 'A1234567', '', 9104991910, '', 0),
(8, 'Keyur Bhuva', 'as@gmail.com', 'asasasA1', '', 9104991910, '', 0),
(9, '123', 'ASASAS@a.com', 'Ksks1234', '', 1234567890, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_person`
--

CREATE TABLE `delivery_person` (
  `delivery_person_id` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Contact_no` bigint(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Photo` varchar(30) NOT NULL,
  `Id-proof` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_person`
--

INSERT INTO `delivery_person` (`delivery_person_id`, `Name`, `Contact_no`, `Email`, `Photo`, `Id-proof`, `password`) VALUES
(1, 'kj', 3652412563, 'l@gmail.com', '5030-pexels-sonny-30024538.jpg', '5249-pexels-pixabay-276528.jpg', 'nammm'),
(2, 'naman', 1234567890, 'naman@gmail.com', '', '', 'naman@123');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `feedback_date` date NOT NULL,
  `feedback_details` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `cid`, `pid`, `feedback_date`, `feedback_details`) VALUES
(1, 2, 34, '2025-03-09', 'nice product'),
(2, 4, 34, '2025-03-10', 'ajsldjalkjsdkjasjdlkjio');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `gallery_img_path` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offer_id` int(11) NOT NULL,
  `coupone_code` varchar(15) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_amt` float NOT NULL,
  `Offer_discription` varchar(100) NOT NULL,
  `min_ant` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`offer_id`, `coupone_code`, `start_date`, `end_date`, `discount_amt`, `Offer_discription`, `min_ant`) VALUES
(1, '0', '2025-02-03', '2025-02-28', 200, 'flat 200 diacount above shopping amount 1000', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ooo`
--

CREATE TABLE `ooo` (
  `order_id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `delivery_person_id` int(11) NOT NULL,
  `Contact_no` bigint(20) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `order_status` varchar(45) NOT NULL,
  `address` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `Contact_no` varchar(15) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` varchar(20) DEFAULT NULL,
  `address` varchar(60) NOT NULL,
  `order_details_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `Contact_no`, `cid`, `pid`, `quantity`, `order_date`, `order_amount`, `order_status`, `address`, `order_details_id`) VALUES
(39, '1234567890', 1, 34, 1, '2025-03-09', 200.00, 'Completed', 'kklklkkklklkkl', 12),
(40, '1234567890', 1, 40, 1, '2025-03-09', 44.00, 'Completed', 'kklklkkklklkkl', 12),
(41, '1234567890', 1, 34, 1, '2025-03-09', 200.00, 'Completed', 'kklklkkklklkkl', 13),
(42, '1234567890', 1, 40, 1, '2025-03-09', 44.00, 'Completed', 'kklklkkklklkkl', 13),
(43, '1234567890', 1, 34, 1, '2025-03-09', 200.00, 'Cancelled', 'kklklkkklklkkl', 14),
(44, '1234567890', 1, 40, 1, '2025-03-09', 44.00, 'Cancelled', 'kklklkkklklkkl', 14),
(45, '1234567890', 2, 50, 1, '2025-03-10', 58844.00, 'Completed', 'kkkasldjljsdmfnsd', 15),
(46, '1234567890', 2, 49, 1, '2025-03-10', 15.00, 'Completed', 'kkkasldjljsdmfnsd', 15),
(47, '1234567890', 4, 34, 1, '2025-03-10', 200.00, 'Completed', 'a-401 ,gamgotri residency ,sudama chowk', 16),
(49, '1234567890', 4, 40, 4, '2025-03-10', 176.00, 'Completed', 'a-401 ,gamgotri residency ,sudama chowk', 16),
(50, '1234567890', 2, 34, 1, '2025-03-10', 200.00, 'Pending', 'kkkasldjljsdmfnsd', 17),
(51, '1234567890', 2, 34, 1, '2025-03-10', 200.00, 'Completed', 'kkkasldjljsdmfnsd', 18),
(52, '9104991910', 7, 34, 1, '2025-03-11', 200.00, 'Pending', 'avhavdwd', 19),
(53, '1234567890', 2, 34, 1, '2025-03-11', 200.00, 'Pending', 'kkkasldjljsdmfnsd', 20),
(54, '1234567890', 2, 34, 1, '2025-03-16', 200.00, 'Pending', 'kkkasldjljsdmfnsd', 21);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(11) NOT NULL,
  `p_price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `delivery_person_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `p_price`, `quantity`, `order_date`, `delivery_person_id`) VALUES
(12, 294, 2, '2025-03-09', NULL),
(13, 294, 2, '2025-03-09', NULL),
(14, 294, 2, '2025-03-09', NULL),
(15, 58909, 2, '2025-03-10', 1),
(16, 6426, 8, '2025-03-10', 1),
(17, 250, 1, '2025-03-10', 2),
(18, 250, 1, '2025-03-10', 1),
(19, 250, 1, '2025-03-11', 1),
(20, 250, 1, '2025-03-11', NULL),
(21, 250, 1, '2025-03-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `transaction_id` varchar(40) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `transaction_mode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `transaction_id`, `payment_date`, `payment_status`, `transaction_mode`) VALUES
(3, 39, 'TXN17415232111195', '2025-03-09', 'Pending', 'cod'),
(4, 40, 'TXN17415232116107', '2025-03-09', 'Pending', 'cod'),
(5, 41, 'TXN17415243078195', '2025-03-09', 'Pending', 'cod'),
(6, 42, 'TXN17415243074585', '2025-03-09', 'Pending', 'cod'),
(7, 43, 'TXN17415376301938', '2025-03-09', 'Pending', 'cod'),
(8, 44, 'TXN17415376304041', '2025-03-09', 'Pending', 'cod'),
(9, 45, 'TXN17415806591290', '2025-03-10', 'Paid', 'cod'),
(10, 46, 'TXN17415806596573', '2025-03-10', 'Paid', 'cod'),
(11, 47, 'TXN17415818714461', '2025-03-10', 'Paid', 'cod'),
(13, 49, 'TXN17415818718396', '2025-03-10', 'Paid', 'cod'),
(14, 50, 'TXN17416026723072', '2025-03-10', 'Pending', 'cod'),
(15, 51, 'TXN17416027686347', '2025-03-10', 'Paid', 'cod'),
(16, 52, 'TXN17416706905632', '2025-03-11', 'Pending', 'cod'),
(17, 53, 'TXN17416743341890', '2025-03-11', 'Pending', 'cod'),
(18, 54, 'TXN17420986153412', '2025-03-16', 'Pending', 'cod');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `p_name` varchar(25) NOT NULL,
  `quantity` int(11) NOT NULL,
  `p_price` float NOT NULL,
  `p_description` varchar(100) NOT NULL,
  `p_image` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pid`, `sub_category_id`, `offer_id`, `p_name`, `quantity`, `p_price`, `p_description`, `p_image`) VALUES
(34, 6, 1, 'sofa', 50, 200, 'kkkk.', '2075.pexels-pixabay-276528.jpg'),
(40, 1, 1, 'ke', 50, 44, 'dds', '6544.download.jpeg'),
(47, 3, 1, 'zxzx', 55, 5000, 'zxzx', '3330.'),
(48, 3, 1, 'zxzx', 55, 5000, 'zxzx', '6673.'),
(49, 3, 1, 'as`', 12, 15, 'mn', '4084.jpeg'),
(50, 3, 1, 'assas', 477, 58844, 'kldfihjdfh', '4171.png'),
(51, 2, 1, 'floor vase000', 50, 1200, 'BLACK WASE', '9418.png');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_category_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_category_id`, `category_id`, `sub_category_name`) VALUES
(1, 6, 'Table Vases '),
(2, 6, 'Floor Vases'),
(3, 7, 'Decorative Boxes'),
(4, 7, 'Desk Organizers'),
(5, 7, 'Magazine Racks'),
(6, 7, 'Pen Stands'),
(7, 7, 'Bookends'),
(8, 7, 'Accessory Holders'),
(9, 8, 'Artificial Plants'),
(10, 8, 'Artificial Flowers'),
(11, 5, 'Natural Plants'),
(12, 5, 'Seeds'),
(13, 5, 'Gardening Tools'),
(14, 5, 'Planter Stands'),
(15, 5, 'Plant Care'),
(16, 9, 'Desk Pots'),
(17, 9, 'Wall Planters'),
(18, 9, 'Floor Planters'),
(19, 9, 'Hanging Planters'),
(20, 9, 'Railing Planters'),
(21, 3, 'Fountains'),
(22, 3, 'Garden Figurines'),
(23, 3, 'Artificial Grass'),
(24, 4, 'Metal Wall Art'),
(25, 4, 'Wooden Wall Art'),
(26, 4, 'Wall Plates & Tiles'),
(27, 4, 'Wall Masks'),
(28, 4, 'World Map'),
(29, 4, 'Quotes'),
(30, 10, 'Art Prints'),
(31, 10, 'Art Panels'),
(32, 10, 'Hand Paintings'),
(33, 10, 'Ethnic Art'),
(34, 2, 'Serveware'),
(35, 2, 'Dinnerware'),
(36, 2, 'Teaware'),
(37, 2, 'Storage + Accessories');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `admin005`
--
ALTER TABLE `admin005`
  ADD PRIMARY KEY (`Admin_id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cid`);

--
-- Indexes for table `delivery_person`
--
ALTER TABLE `delivery_person`
  ADD PRIMARY KEY (`delivery_person_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `ooo`
--
ALTER TABLE `ooo`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `pid` (`pid`),
  ADD KEY `cid` (`cid`),
  ADD KEY `delivery_person_id` (`delivery_person_id`) USING BTREE;

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cid` (`cid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `order_ibfk_4` (`order_details_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `p_price` (`p_price`),
  ADD KEY `delivery_person_id` (`delivery_person_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `sub_category_id` (`sub_category_id`),
  ADD KEY `offer_id` (`offer_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `Category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `delivery_person`
--
ALTER TABLE `delivery_person`
  MODIFY `delivery_person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ooo`
--
ALTER TABLE `ooo`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customer` (`Cid`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`);

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`);

--
-- Constraints for table `ooo`
--
ALTER TABLE `ooo`
  ADD CONSTRAINT `ooo_ibfk_1` FOREIGN KEY (`delivery_person_id`) REFERENCES `delivery_person` (`delivery_person_id`),
  ADD CONSTRAINT `ooo_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `customer` (`Cid`),
  ADD CONSTRAINT `ooo_ibfk_3` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `customer` (`Cid`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`pid`) REFERENCES `product` (`pid`),
  ADD CONSTRAINT `order_ibfk_4` FOREIGN KEY (`order_details_id`) REFERENCES `order_details` (`order_details_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`delivery_person_id`) REFERENCES `delivery_person` (`delivery_person_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`sub_category_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`offer_id`) REFERENCES `offer` (`offer_id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
