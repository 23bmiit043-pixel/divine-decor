-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jan 29, 2026 at 03:54 PM
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
(1, 'keyurbbhuva@gmail.com', '1212', 0, 'Keyur', 'Bhuva', 'Male', 'Surat', 'Gujarat', '1234567899', '67e0dae8e831d.jpg'),
(2, 'akshay29andrapiya@gmail.com', 'Akshay-29', 0, 'Akshay', 'Andrapiya', 'Male', '85/1 diamond park society, Nikol gam, Ahmedabad 38', 'Gujarat', '9328426068', '');

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
(10, 'Wall Art and Paintings'),
(16, 'Gradennnnnn'),
(17, 'Kitchen & Dining Decor	');

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
(2, 'uday', 'dsa@gmail.com', 'aaas', 'kkkasldjljsdmfnsd', 1234567890, 'male', 123456),
(6, 'akshay', 'akshay@gmail.com', 'A2345678', '', 9876543217, '', 0),
(8, 'Keyur Bhuva', 'as@gmail.com', 'asasasA1', '', 9104991910, '', 0),
(10, 'pratik', 'pratik@gmail.com', 'Pratik@123', '', 1234567890, 'male', 0),
(12, 'Keyur Bhuva', 'keyurbbhuva@gmail.com', 'Keyur@123', 'a-401 ,gamgotri residency ,sudama chowk', 9104991910, '', 0),
(13, 'Pratik', 'pratiksalunke21654@gmail.com', 'dKgAWBSJYv', '', 9104991910, '', 0);

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
(1, 'aman', 3652412563, 'new@gmail.com', '8107-person_1.jpg', '8204-aadhar_061416050825.jpg', 'aman123');

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
(3, 10, 55, '2025-04-17', 'exellent quality and design.');

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
(1, 'New1000', '2025-03-01', '2025-04-28', 200, 'flat 200 diacount above shopping amount 1000', 1000);

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
(55, '1234567890', 10, 55, 1, '2025-03-24', 949.00, 'Cancelled', 'raj chowk ahmedabad', 22),
(56, '1234567890', 10, 54, 1, '2025-03-24', 479.00, 'Cancelled', 'raj chowk ahmedabad', 22),
(57, '1234567890', 10, 56, 2, '2025-03-24', 2498.00, 'Completed', 'sakghdh', 23),
(60, '9104991910', 12, 55, 3, '2025-03-24', 2847.00, 'Completed', 'a-401 ,gamgotri residency ,sudama chowk', 25),
(61, '9104991910', 12, 55, 4, '2025-03-24', 3796.00, 'Processing', 'a-401 ,gamgotri residency ,sudama chowk', 26),
(62, '9104991910', 12, 56, 5, '2025-03-24', 6245.00, 'Processing', 'a-401 ,gamgotri residency ,sudama chowk', 26),
(63, '9104991910', 12, 54, 1, '2025-03-30', 479.00, 'Pending', 'a-401 ,gamgotri residency ,sudama chowk', 27),
(64, '9104991910', 12, 55, 1, '2025-03-30', 949.00, 'Pending', 'a-401 ,gamgotri residency ,sudama chowk', 27),
(65, '1234567890', 2, 55, 1, '2025-04-14', 949.00, 'Pending', 'kkkasldjljsdmfnsd', 28),
(66, '1234567890', 2, 56, 1, '2025-04-14', 1249.00, 'Pending', 'kkkasldjljsdmfnsd', 28),
(67, '1234567890', 10, 53, 1, '2025-04-16', 299.00, 'Cancelled', 'a-401 ,gamgotri residency ,sudama chowk', 29),
(68, '1234567890', 10, 54, 1, '2025-04-16', 479.00, 'Pending', 'a-401 ,gamgotri residency ,sudama chowk', 29),
(69, '1234567890', 10, 55, 3, '2025-04-16', 2847.00, 'Pending', 'a-401 ,gamgotri residency ,sudama chowk', 30),
(70, '1234567890', 10, 53, 5, '2025-04-16', 1495.00, 'Cancelled', 'a-401 ,gamgotri residency ,sudama chowk', 31),
(71, '1234567890', 10, 53, 2, '2025-04-16', 598.00, 'Pending', 'a-401 ,gamgotri residency ,sudama chowk', 32),
(72, '1234567890', 10, 55, 1, '2025-04-16', 949.00, 'Pending', 'a-401 ,gamgotri residency ,sudama chowk', 33),
(73, '1234567890', 10, 57, 3, '2025-04-16', 2997.00, 'Cancelled', 'a-401 ,gamgotri residency ,sudama chowk', 34),
(74, '1234567890', 10, 53, 2, '2025-04-17', 598.00, 'Processing', 'Surat', 35),
(75, '1234567890', 10, 54, 3, '2025-04-17', 1437.00, 'Processing', 'Surat', 35),
(76, '1234567890', 10, 55, 4, '2025-04-17', 3796.00, 'Processing', 'Surat', 35),
(77, '9104991910', 12, 55, 1, '2025-04-17', 949.00, 'Processing', 'a-401 ,gamgotri residency ,sudama chow', 36),
(78, '9104991910', 12, 56, 10, '2025-04-17', 12490.00, 'Processing', 'a-401 ,gamgotri residency ,sudama chow', 36),
(79, '9104991910', 12, 58, 10, '2025-04-17', 11990.00, 'Processing', 'a-401 ,gamgotri residency ,sudama chow', 36);

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
(22, 1478, 2, '2025-03-24', 1),
(23, 2548, 2, '2025-03-24', 1),
(25, 2897, 3, '2025-03-24', 1),
(26, 10091, 9, '2025-03-24', 1),
(27, 1478, 2, '2025-03-30', 1),
(28, 2248, 2, '2025-04-14', NULL),
(29, 828, 2, '2025-04-16', NULL),
(30, 2847, 3, '2025-04-16', NULL),
(31, 1495, 5, '2025-04-16', NULL),
(32, 598, 2, '2025-04-16', NULL),
(33, 949, 1, '2025-04-16', NULL),
(34, 2997, 3, '2025-04-16', NULL),
(35, 5831, 9, '2025-04-17', 1),
(36, 25429, 21, '2025-04-17', 1);

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
(19, 55, 'TXN17427897237763', '2025-03-24', 'Paid', 'cod'),
(20, 56, 'TXN17427897234182', '2025-03-24', 'Paid', 'cod'),
(21, 57, 'TXN17427906498921', '2025-03-24', 'Paid', 'cod'),
(24, 60, 'TXN17427940089689', '2025-03-24', 'Paid', 'cod'),
(25, 61, 'TXN17428053945576', '2025-03-24', 'Pending', 'cod'),
(26, 62, 'TXN17428053948617', '2025-03-24', 'Pending', 'cod'),
(27, 63, 'TXN17433427429695', '2025-03-30', 'Pending', 'cod'),
(28, 64, 'TXN17433427421519', '2025-03-30', 'Pending', 'cod'),
(29, 65, 'pay_QInKj0UpsiiKPy', '2025-04-14', 'Completed', 'upi'),
(30, 66, 'pay_QInKj0UpsiiKPy', '2025-04-14', 'Completed', 'upi'),
(31, 67, 'TXN17447750282242', '2025-04-16', 'Pending', 'cod'),
(32, 68, 'TXN17447750283806', '2025-04-16', 'Pending', 'cod'),
(33, 69, 'TXN17447773653505', '2025-04-16', 'Pending', 'cod'),
(34, 70, 'TXN17447785173878', '2025-04-16', 'Pending', 'cod'),
(35, 71, 'TXN17447853413315', '2025-04-16', 'Pending', 'cod'),
(36, 72, 'TXN17447889841931', '2025-04-16', 'Pending', 'cod'),
(37, 73, 'TXN17447890123850', '2025-04-16', 'Pending', 'cod'),
(38, 74, 'TXN17448625551758', '2025-04-17', 'Pending', 'cod'),
(39, 75, 'TXN17448625551740', '2025-04-17', 'Pending', 'cod'),
(40, 76, 'TXN17448625558634', '2025-04-17', 'Pending', 'cod'),
(41, 77, 'TXN17448698825580', '2025-04-17', 'Pending', 'cod'),
(42, 78, 'TXN17448698822989', '2025-04-17', 'Pending', 'cod'),
(43, 79, 'TXN17448698821551', '2025-04-17', 'Pending', 'cod');

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
(53, 1, 1, 'Contemporary Metal Flower', 0, 299, 'Elegant golden metal flower vase with modern design, perfect for fresh or artificial flowers', '5852.jpg'),
(54, 1, 1, 'Minimalist Ceramic Vase', 3, 479, 'White ceramic decorative vase with clean lines and contemporary aesthetic, 6-inch height', '4409.jpg'),
(55, 1, 1, 'Mediterranean Blue Cerami', 0, 949, 'Handcrafted blue ceramic table vase with glazed finish, ideal for modern home decor', '2573.jpg'),
(56, 1, 1, 'Dual Animal Head Terracot', 0, 1249, 'Set of 2 artistic terracotta vases featuring unique animal head designs in black and yellow', '6805.jpg'),
(57, 1, 1, 'Artisan White Ceramic Flo', 7, 999, 'Handcrafted premium white ceramic vase with contemporary design and smooth matte finish', '7654.jpg'),
(58, 1, 1, 'Madhubani Art Terracotta ', 0, 1199, 'Traditional Madhubani art inspired terracotta vases, hand-painted set of 2 in black and orange', '7143.jpg'),
(59, 1, 1, 'Traditional Earthen Vase ', 10, 12249, 'Handcrafted multicolor metal-ceramic table vase duo with traditional Warli art motifs', '1499.jpg'),
(60, 2, 1, 'Warli Art Ceramic Vase Se', 10, 1649, 'Designer metal-ceramic vase set featuring authentic Warli tribal art patterns', '9816.jpg'),
(61, 2, 1, 'Deidra Teal Brass Collect', 10, 3349, 'Luxurious teal blue brass table vase with contemporary design and premium finish', '9160.jpg'),
(62, 2, 1, 'Warli Heritage Table Vase', 10, 4589, 'Artistic table vase with traditional Warli art, handcrafted by Aakriti Art Creations', '5545.jpg'),
(63, 2, 1, 'Madhubani Black Vase Duo', 10, 1499, 'Set of 2 black terracotta vases featuring intricate Madhubani art patterns', '7261.jpg'),
(64, 34, 1, 'Designer Serving Platter ', 10, 1399, 'Set of 4 decorative playing card themed serving platters, perfect for entertaining', '3246.jpg'),
(65, 34, 1, 'Pichwai Peacock Serving T', 10, 1289, 'Set of 2 elegant serving trays featuring traditional Pichwai peacock art in white', '7360.jpg'),
(66, 34, 1, 'ireka-homes-oval-acacia-w', 10, 899, 'ireka-homes-oval-acacia-wood-server-with-enamel-ireka-homes-oval-acacia-wood-server-with-enamel', '5083.jpg'),
(67, 34, 1, 'cdi-black-melamine-bottle', 10, 599, 'cdi-black-melamine-bottle-shaped-serving-set-of-4-cdi-black-melamine-bottle-shaped-serving-set-of-4', '8732.jpg'),
(68, 35, 1, 'Crystal Fruit Plate', 10, 877, 'Crystal (10 x 3 Inches ) Fruit Plate', '9725.jpg'),
(69, 35, 1, 'cdi-square-white-black-fl', 10, 3989, 'cdi-square-white-black-floral-melamine-double-coated-40-pcs-dinner-set-cdi-square-white-black-floral', '3924.jpg'),
(70, 35, 1, 'stainless-steel-bowl-vati', 10, 519, 'stainless-steel-bowl-vati---steel-bowl-set-for-kitchen---dinner-bowl-katori-serving-wati--200-ml', '9082.jpg'),
(71, 35, 1, 'stainless-steel-bowl-vati', 10, 829, 'stainless-steel-bowl-vati---steel-bowl-set-for-kitchen---dinner-bowl-katori-serving-wati--200-ml', '9681.jpg'),
(72, 36, 1, 'Premium Coffee Mug Collec', 10, 508, 'Set of 2 elegant white ceramic coffee mugs, 350ml capacity, perfect for daily use', '4430.jpg'),
(73, 36, 1, 'Classic White Ceramic Mug', 10, 877, 'Durable 350ml ceramic coffee mug duo with sleek design and comfortable handle', '5930.jpg'),
(74, 36, 1, 'Traditional Glass Serving', 10, 677, 'Set of 2 classic design glass milk serving vessels with traditional patra pela style', '1846.jpg'),
(75, 36, 1, 'Modern Matte Black Mug Se', 10, 369, 'Set of 6 contemporary black matte finish coffee mugs with elegant design', '2137.jpg'),
(76, 21, 1, 'Premium Buddha Water Foun', 10, 16249, 'Serene indoor water fountain featuring gold fiber glass Buddha statue with LED lighting', '6962.jpg'),
(77, 21, 1, 'Zen Bamboo Water Feature', 10, 8999, 'Contemporary bamboo-themed water fountain with multiple tiers, perfect for home or office', '8108.jpg'),
(78, 21, 1, 'Jade Green Cascade Founta', 10, 1999, 'Modern stacked pot water fountain in jade green, creates a peaceful ambiance with gentle water flow', '4883.jpg'),
(79, 21, 1, 'Luxury Slate Waterfall Fe', 10, 19999, 'Premium maroon slate waterfall with multi-tier design, perfect for indoor or outdoor spaces', '8519.jpg'),
(81, 22, 1, 'Enchanted Garden Tree Fig', 10, 599, 'Set of 3 charming resin tree figurines with welcoming design, perfect for garden decoration', '5331.jpg'),
(82, 22, 1, 'Whimsical Animal Garden S', 10, 849, 'Set of 5 adorable multicolor resin animal figurines for creative garden display', '2426.jpg'),
(83, 22, 1, 'Rustic Rabbit Garden Scul', 10, 1089, 'Charming ceramic rabbit figurine with basket, brings countryside charm to your garden', '3241.jpg'),
(84, 22, 1, 'Decorative Deer Garden Co', 10, 899, 'Set of 12 elegant plastic deer figurines, perfect for garden landscape decoration', '2221.jpg'),
(85, 23, 1, 'Premium Artificial Grass ', 10, 999, 'High-quality synthetic grass mat 20x20 inches, ideal for indoor and outdoor decoration', '1436.jpg'),
(86, 23, 1, 'Vertical Garden Wall Pane', 10, 1899, 'Luxurious PVC artificial green wall mat for creating stunning vertical gardens', '1114.jpg'),
(87, 23, 1, 'Classic Wall Mounted Gree', 10, 1199, 'Realistic artificial wall mat with dense foliage for easy installation and maintenance', '4809.jpg'),
(88, 23, 1, 'Premium Grade Artificial ', 10, 5599, 'High-density 35mm artificial grass, 6.5 x 9 feet, perfect for landscaping projects', '2684.jpg'),
(89, 24, 1, 'Divine Radha Krishna Wall', 10, 1599, 'Intricate multicolor iron wall art depicting Radha Krishna under a tree, traditional design', '7967.jpg'),
(90, 24, 1, 'Musical Heritage Wall Dec', 10, 999, 'Traditional iron wall art featuring musicians, hand-crafted in vibrant multicolor finish', '2806.jpg'),
(91, 24, 1, 'Contemporary Dancing Lady', 10, 459, 'Modern black MDF dancing lady silhouette wall plaque, elegant contemporary design', '8194.jpg'),
(92, 24, 1, 'Sculptural Metal Deer Wal', 4499, 4499, 'Designer metal deer head wall sculpture, sophisticated geometric patterns in metallic finish', '8370.jpg'),
(93, 24, 1, 'Nautical Boat Wall Sculpt', 10, 7649, 'Premium Neptune boat wall décor in weathered finish, perfect coastal-themed accent piece', '5884.jpg'),
(94, 25, 1, 'Inspirational Wall Panel ', 10, 899, 'Set of multicolor motivational wall panels with modern typography and designs', '6466.jpg'),
(95, 25, 1, 'Dhokra Art Wall Panels', 10, 1949, 'Traditional Dhokra brass and wood wall art duo, handcrafted tribal art pieces', '6310.jpg'),
(96, 25, 1, 'textured-paper-wood-frame', 10, 999, 'textured-paper-wood-framed-art-print-in-blue-by-chaque-decor-textured-paper-wood-framed-art-print', '9696.jpg'),
(97, 25, 1, 'the life of warli paintin', 10, 899, 'the-life-of-warli-painting---tribal-marriage--black-wood---metal--set-of-2--painting-by--aakriti-art', '5189.jpg'),
(98, 25, 1, 'iron-hand-painted-ganesha', 10, 899, 'iron-hand-painted-ganesha-metal-wall-art-by-jasolika-creations-iron-hand-painted-ganesha-metal-wall', '3308.jpg'),
(99, 26, 1, 'multicolour-ceramic-decor', 10, 899, 'multicolour-ceramic-decorative-wall-plate-by-the-decor-mart-multicolour-ceramic-decorative-wall-plat', '8969.jpg'),
(100, 26, 1, 'abstract-style-decortativ', 10, 578, 'abstract-style-decortative-wall-pates--set-of-7--by-quirk-india-abstract-style-decortative-wall-pate', '8099.jpg'),
(101, 26, 1, 'ceramic-wall-plates-with-', 10, 899, 'ceramic-wall-plates-with-rose-flowers-design-art-set-of-3-ceramic-wall-plates-with-rose-flowers-desi', '6590.jpg'),
(102, 26, 1, 'Elegant Leaf Pattern Cera', 10, 589, 'Decorative ceramic wall plate featuring intricate banana leaf design in multicolor finish', '6044.jpg'),
(103, 27, 1, 'Golden Buddha Face Wall D', 10, 5949, 'Luxurious fiber Buddha face wall hanging in golden finish with intricate detailing', '7539.jpg'),
(104, 27, 1, 'elephant-multicolour-mang', 10, 4949, 'elephant-multicolour-mango-wood-wall-mask-elephant-multicolour-mango-wood-wall-mask', '2304.jpg'),
(105, 27, 1, 'golden-radha-krishna-3d', 10, 4599, 'shna-3d-wall-mask-by-artociti-golden-radha-krishna-3d-wall-mask', '3238.jpg'),
(106, 27, 1, 'shamans-wall-decor-mask-b', 10, 599, 'shamans-wall-decor-mask-by-aakriti-art-creations-shamans-wall-decor-mask-by-aakriti-art-creations', '4751.jpg'),
(107, 27, 1, 'bronze-tirupati-balaji-fa', 10, 6999, 'bronze-tirupati-balaji-3d-face-wall-mask-by-artociti-bronze-tirupati-balaji-3d-face-wall-mask-by-art', '7248.jpg'),
(108, 28, 1, '3D World Map Wall Art - X', 10, 49999, 'Premium wooden world map wall decor, multi-layered 3D design in natural wood tones', '4534.jpg'),
(109, 28, 1, '3d-wooden-world-map-multi', 10, 44999, '3d-wooden-world-map-multicolour---xl-size-by-u-wood-love-it-3d-wooden-world-map-multicolour---xl-siz', '1812.jpg'),
(110, 28, 1, '3d-wooden-world-map-multi', 10, 50999, '3d-wooden-world-map-multicolour---m-size-by-u-wood-love-it-3d-wooden-world-map-multicolour---m-size', '4359.jpg'),
(111, 28, 1, 'Antique Globe World Map', 10, 21999, 'Classic decorative globe with detailed antique world map finish, perfect for study or office', '3677.jpg'),
(112, 29, 1, 'lgbt-gifts-motivational-q', 10, 199, 'lgbt-gifts-motivational-quote-multi-mouse-pad-8-5x7-inches---gifts-for-lgbtq--gifts-for-gay-men--gif', '2769.jpg'),
(113, 29, 1, 'multicolor-polycotton-cus', 10, 499, 'multicolor-polycotton-cushion-cover-with-filler-multicolor-polycotton-cushion-cover-with-filler', '7766.jpg'),
(114, 29, 1, 'multicolor-polycotton-cus', 10, 399, 'multicolor-polycotton-cushion-cover-with-filler-multicolor-polycotton-cushion-cover-with-filler', '7926.jpg'),
(115, 29, 1, 'designer-multicolour-engi', 10, 4588, 'designer-multicolour-engineered-wood-wall-hanging-quotes-designer-multicolour-engineered-wood-wall', '5333.jpg'),
(116, 3, 1, 'Decorative Storage Box Co', 2199, 2199, 'Handcrafted wooden jewelry boxes with intricate multicolor design and premium finish', '5962.jpg'),
(117, 3, 1, 'decorative-jewellery-mult', 10, 2199, 'decorative-jewellery-multicolour-wood-boxes-decorative-jewellery-multicolour-wood-boxes-julrwa', '4921.jpg'),
(118, 3, 1, 'kalesh-design-wood-and-cl', 10, 1999, 'kalesh-design-wood-and-clay-jewelry-box--by-aapno-rajasthan-kalesh-design-wood-and-clay-jewelry-box', '6635.jpg'),
(120, 3, 1, 'vritti-multicolour-porcel', 10, 299, 'vritti-multicolour-porcelain-decorative-box-vritti-multicolour-porcelain-decorative-box', '2292.jpg'),
(121, 4, 1, 'vritti-multicolour-porcel', 10, 2599, 'vritti-multicolour-porcelain-decorative-box-vritti-multicolour-porcelain-decorative-box', '6979.jpg'),
(122, 4, 1, 'Contemporary Kitchen Stor', 10, 8599, 'Modern black metal cabinet with oven space, perfect for organized kitchen storage', '2541.jpg'),
(123, 4, 1, 'plant-stand-plant-stand', 10, 1999, 'plant-stand-plant-stand', '5763.jpg'),
(124, 4, 1, 'denham-kitchen-metal-cabi', 10, 899, 'denham-kitchen-metal-cabinet-basic-without-oven-space-in-silver-colour-by-tunehome-denham-kitchen-me', '6098.jpg'),
(125, 4, 1, 'Ceramic Oil Dispenser', 10, 579, 'Stylish multicolor ceramic oil dispenser with 1-liter capacity and easy-pour spout', '2371.jpg'),
(126, 5, 1, 'Buddha Desk Organizer', 10, 599, 'Handcrafted copper-finish wrought iron desk organizer with Buddha motif', '5687.jpg'),
(127, 5, 1, 'Vintage Style Magazine Ra', 10, 889, 'Elegant floral pattern wooden magazine holder with white finish and traditional design', '2021.jpg'),
(128, 5, 1, 'Multipurpose Metal Storag', 10, 1349, 'Contemporary iron storage basket, versatile design for multiple storage solutions', '4881.jpg'),
(129, 5, 1, 'Modern C-Table with Stora', 10, 2999, 'Black metal C-shaped side table with integrated magazine rack, space-saving design', '9733.jpg'),
(131, 6, 1, 'Handcrafted Elephant Pen ', 10, 849, 'Artistically painted blue iron pen stand featuring traditional elephant design', '6782.jpg'),
(132, 6, 1, 'metal-antique-gold', 10, 589, 'metal-antique-gold-and-copper-figurines-by-malik-design-metal-antique-gold-and-copper-figurines', '6977.jpg'),
(133, 6, 1, 'craft-tree-metal-handpain', 10, 588, 'craft-tree-metal-handpainted-decorative-cycle-pen-stand-showpiece-with-clock-in-golden-finish-craft', '3132.jpg'),
(134, 6, 1, 'engineering-wood-decorati', 10, 399, 'engineering-wood-decorative-pen-stands-with-mobile-holder-engineering-wood-decorative-pen-stands-wit', '2744.jpg'),
(135, 7, 1, 'bicycle-black-iron-book-e', 10, 1049, 'bicycle-black-iron-book-ends-by-mint-furnish-bicycle-black-iron-book-ends-by-mint-furnish', '1579.jpg'),
(136, 7, 1, 'rhino-black-iron-book', 10, 1349, 'rhino-black-iron-book-ends-by-mint-furnish-rhino-black-iron-book-ends-by-mint-furnish', '7845.jpg'),
(137, 7, 1, 'vintage-style-decorative-', 10, 1299, 'vintage-style-decorative-bird-bookend-vintage-style-decorative-bird-bookend', '2169.jpg'),
(138, 7, 1, 'decorative-working-man-se', 10, 1599, 'decorative-working-man-set-of-2-silver-aluminium-bookends-decorative-working-man-set-of-2-silver', '7840.jpg'),
(139, 8, 1, 'watch-box-organizer---6-s', 10, 1899, 'watch-box-organizer---6-slot-watch-storage-holder-and-display-collection-box-with-transparent-glass', '8703.jpg'),
(140, 8, 1, 'chic-kitchen-space-saving', 10, 1662, 'chic-kitchen-space-saving-storage--wooden-kitchen-organizer--spice-rack---makeup---accessory-desk', '6024.jpg'),
(141, 8, 1, 'assorted-transparent-trav', 10, 1458, 'assorted-transparent-travel-jewelry-organizer-assorted-transparent-travel-jewelry-organizer', '6193.jpg'),
(142, 8, 1, 'drawer-organiser-tie-pock', 10, 999, 'drawer-organiser-tie-pocket-square-storage-organizer-trays-display-tray-for-ties-pocket-square-drawe', '6666.jpg'),
(143, 32, 1, 'white-into-the-wood-frame', 10, 28999, 'white-into-the-wood-framed-oil-on-canvas-original-hand-painting-by-art-gali-white-into-the-wood-fram', '6628.jpg'),
(145, 32, 1, 'abstract-architecture-ori', 10, 11999, 'abstract-architecture-original-handmade-framed-oil-painting-on-canvas-by-chaque-decor-abstract-archi', '1571.jpg'),
(146, 32, 1, 'blue-earth-s-crust-inspir', 10, 51999, 'blue-earth-s-crust-inspired-framed-canvas-painting-by-art-gali-blue-earth-s-crust-inspired-framed', '3413.jpg'),
(147, 32, 1, 'blue-landscape-abstract', 10, 45999, 'blue-landscape-abstract-framed-canvas-painting-by-art-gali-blue-landscape-abstract-framed-canvas-pai', '1258.jpg'),
(148, 33, 1, 'luxury-frame-metal-wall-a', 10, 39999, 'luxury-frame-metal-wall-art-for-living-room-luxury-frame-metal-wall-art-for-living-room', '1052.jpg'),
(149, 33, 1, 'multicolor-metal-wall-art', 10, 45889, 'multicolor-metal-wall-art-for-living-room-multicolor-metal-wall-art-for-living-room', '4926.jpg'),
(150, 33, 1, 'deer-metal-wall-art', 10, 5588, 'deer-metal-wall-art-deer-metal-wall-art', '4742.jpg'),
(151, 33, 1, 'multicolour-scenery-metal', 10, 4279, 'multicolour-scenery-metal-wall-art-for-living-room-multicolour-scenery-metal-wall-art-for-living', '9378.jpg'),
(152, 9, 1, 'multicolor-polyester-crot', 10, 4499, 'multicolor-polyester-croton-artificial-plant-by-fourwalls-multicolor-polyester-croton-artificial-pla', '1936.jpg'),
(153, 9, 1, 'arick-decor-21inch-artifi', 10, 849, 'arick-decor-21inch-artificial-real-touch-rubber-with-black-pot--home-decor-office-decor-perfect-deco', '4257.webp'),
(154, 9, 1, 'multicolour-polyester', 10, 599, 'multicolour-polyester-and-plastic-artificial-plants-by-foliyaj-multicolour-polyester-and-plastic-art', '1683.jpg'),
(156, 9, 1, 'pink-fabric---plastic-art', 10, 599, 'pink-fabric---plastic-artificial-plant-by-arick-d-cor-pink-fabric---plastic-artificial-plant-by-aric', '1698.jpg'),
(157, 10, 1, 'green-plastic-and-polyest', 10, 1269, 'green-plastic-and-polyester-artificial-3-head-bonsai-tree-with-thick-trunk-and-pine-leaves-by-foliya', '7861.jpg'),
(158, 10, 1, 'polyester-faux-artificial', 10, 699, 'polyester-faux-artificial-plant-with-pot-by-arick-decor-polyester-faux-artificial-plant-with-pot', '1162.jpg'),
(159, 10, 1, 'Premium Bird of Paradise ', 10, 6099, 'Realistic 47-inch artificial banana plant with dark pot, perfect for office and home decor', '9806.jpg'),
(160, 10, 1, 'Deluxe Artificial Ficus T', 10, 7859, 'Premium quality artificial potted plant with natural-looking green foliage, maintenance-free', '4275.jpg'),
(161, 18, 1, 'Modern Minimalist Plant S', 10, 519, 'Contemporary metal plant stand with clean lines, perfect for indoor planters', '5511.jpg'),
(162, 18, 1, 'Trio Metal Plant Stands', 10, 589, 'Set of 3 green metal plant stands with varying heights for tiered display', '7335.jpg'),
(163, 18, 1, 'Marmelos Planter Stand', 10, 999, 'White galvanized iron modern planter stand with geometric design', '8073.jpg'),
(164, 18, 1, 'Grandis Multi-Level Plant', 10, 1299, 'Set of 3 white galvanized iron planter stands, contemporary geometric design', '4042.jpg'),
(165, 19, 1, 'Rustic Wooden Plant Stand', 10, 10, 'Natural brown wood planter stand with classic design for indoor and outdoor use', '9197.jpg'),
(166, 19, 1, 'Modern Red Metal Plant St', 10, 1488, 'Contemporary red metal planter stand with sleek minimalist design', '9630.jpg'),
(167, 19, 1, 'Nordic Style Plant Stand', 10, 587, 'Minimalist white metal planter stand with clean lines and modern aesthetic', '6876.jpg'),
(168, 19, 1, 'Duo-Tone Designer Plant S', 10, 5899, 'Premium black and white metal planter stand with contemporary geometric pattern', '4080.webp'),
(177, 1, 0, 'rashi', 1, 0, 'rashi no otlo', '4920.jpg');

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
(37, 2, 'Storage + Accessories'),
(45, 16, 'assss');

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
  ADD KEY `sub_category_id` (`sub_category_id`);

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
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `delivery_person`
--
ALTER TABLE `delivery_person`
  MODIFY `delivery_person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`sub_category_id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
