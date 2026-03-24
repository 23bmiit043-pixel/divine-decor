-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 16, 2025 at 10:02 AM
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
(1, 'keyurbbhuva@gmail.com', '1212', 0, 'Keyur', 'Bhuva', 'Male', 'Surat', 'Gujarat', '1234567899', '67e0dae8e831d.jpg');

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
(2, 'uday', 'dsa@gmail.com', 'aaas', 'kkkasldjljsdmfnsd', 1234567890, 'male', 123456),
(6, 'akshay', 'akshay@gmail.com', 'A2345678', '', 9876543217, '', 0),
(8, 'Keyur Bhuva', 'as@gmail.com', 'asasasA1', '', 9104991910, '', 0),
(10, 'pratik', 'pratik@gmail.com', 'Pratik@123', '', 1234567890, 'male', 0),
(12, 'Keyur Bhuva', 'keyurbbhuva@gmail.com', 'H4LMB8bfNn', 'a-401 ,gamgotri residency ,sudama chowk', 9104991910, '', 0);

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
(1, 2, 34, '2025-03-09', 'nice product');

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
(55, '1234567890', 10, 55, 1, '2025-03-24', 949.00, 'Completed', 'raj chowk ahmedabad', 22),
(56, '1234567890', 10, 54, 1, '2025-03-24', 479.00, 'Completed', 'raj chowk ahmedabad', 22),
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
(73, '1234567890', 10, 57, 3, '2025-04-16', 2997.00, 'Cancelled', 'a-401 ,gamgotri residency ,sudama chowk', 34);

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
(34, 2997, 3, '2025-04-16', NULL);

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
(37, 73, 'TXN17447890123850', '2025-04-16', 'Pending', 'cod');

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
(53, 1, 1, 'Gold Metal Flower vase', 2, 299, 'gold-metal-flower-vase-by-urban-born-gold-metal-flower-vase-by-urban-born-xr3lnt', '5852.jpg'),
(54, 1, 1, 'decorative-viso', 6, 479, 'decorative-viso-6-inch-white-ceramic-vase-decorative-viso-6-inch-white-ceramic-vase-79dhnu', '4409.jpg'),
(55, 1, 1, 'blue-ceramic-table-vase', 5, 949, 'blue-ceramic-table-vases-by-purezento-blue-ceramic-table-vases-by-purezento-4no5u9', '2573.jpg'),
(56, 1, 1, 'animal-heads--set-of-2--b', 10, 1249, 'animal-heads--set-of-2--black---yellow-terracotta-table-vase-animal-heads--set-of-2--black---yellow-', '6805.jpg'),
(57, 1, 1, 'handcrafted-white-ceramic', 7, 999, 'handcrafted-white-ceramic-flower-vase-by-tayhaa-handcrafted-white-ceramic-flower-vase-by-tayhaa-c0tv', '7654.jpg'),
(58, 1, 1, 'madhubani-tattoo-art--set', 10, 1199, 'madhubani-tattoo-art--set-of-2--black---orange-terracotta-table-vase-madhubani-tattoo-art--set-of-2-', '7143.jpg'),
(59, 1, 1, 'madhubani-tattoo-art--set', 10, 12249, 'madhubani-tattoo-art--set-of-2--black---orange-terracotta-table-vase-madhubani-tattoo-art--set-of-2-', '1499.jpg'),
(60, 2, 1, 'warli-earthen--set-of-2--', 10, 1649, 'warli-earthen--set-of-2--multicolour-metal-ceramic-table-vase-warli-earthen--set-of-2--multicolour-m', '9816.jpg'),
(61, 2, 1, 'deidra-teal-blue-brass', 10, 3349, 'deidra-teal-blue-brass-table-vase-by-ds_gurgaon_air-deidra-teal-blue-brass-table-vase-by-ds_gurgaon_', '9160.jpg'),
(62, 2, 1, 'warli-earthen', 10, 4589, 'warli-earthen-table-vase-by-aakriti-art-creations-warli-earthen-table-vase-by-aakriti-art-creations-', '5545.jpg'),
(63, 2, 1, 'madhubani-earthen--set-of', 10, 1499, 'madhubani-earthen--set-of-2--black-terracotta-table-vase-madhubani-earthen--set-of-2--black-terracot', '7261.jpg'),
(64, 34, 1, 'playing-cards-platter-set', 10, 1399, 'playing-cards-platter-set-of-4-playing-cards-platter-set', '3246.jpg'),
(65, 34, 1, 'white-peacock-pichwai-tra', 10, 1289, 'white-peacock-pichwai-tray-set-of-2-white-peacock-pichwai-tray-set-of-2', '7360.jpg'),
(66, 34, 1, 'ireka-homes-oval-acacia-w', 10, 899, 'ireka-homes-oval-acacia-wood-server-with-enamel-ireka-homes-oval-acacia-wood-server-with-enamel', '5083.jpg'),
(67, 34, 1, 'cdi-black-melamine-bottle', 10, 599, 'cdi-black-melamine-bottle-shaped-serving-set-of-4-cdi-black-melamine-bottle-shaped-serving-set-of-4', '8732.jpg'),
(68, 35, 1, 'Crystal Fruit Plate', 10, 877, 'Crystal (10 x 3 Inches ) Fruit Plate', '9725.jpg'),
(69, 35, 1, 'cdi-square-white-black-fl', 10, 3989, 'cdi-square-white-black-floral-melamine-double-coated-40-pcs-dinner-set-cdi-square-white-black-floral', '3924.jpg'),
(70, 35, 1, 'stainless-steel-bowl-vati', 10, 519, 'stainless-steel-bowl-vati---steel-bowl-set-for-kitchen---dinner-bowl-katori-serving-wati--200-ml', '9082.jpg'),
(71, 35, 1, 'stainless-steel-bowl-vati', 10, 829, 'stainless-steel-bowl-vati---steel-bowl-set-for-kitchen---dinner-bowl-katori-serving-wati--200-ml', '9681.jpg'),
(72, 36, 1, 'White Ceramic Coffee Mug', 10, 508, '350Ml White Ceramic (Set Of 2 ) Coffee Mug', '4430.jpg'),
(73, 36, 1, 'White Ceramic (Set Of 2 )', 10, 877, '350Ml White Ceramic (Set Of 2 ) Coffee Mug', '5930.jpg'),
(74, 36, 1, 'asses-large-traditional-d', 10, 677, 'asses-large-traditional-design-coffee-milk-serving-glass-patra-pela-set-of-2', '1846.jpg'),
(75, 36, 1, 'finish-coffee-mugs---set-', 10, 369, 'finish-coffee-mugs---set-of-6--cdi-black-matt-finish-coffee-mugs---set-of-6', '2137.jpg'),
(76, 21, 1, 'nk-statue-indoor-water-fo', 10, 16249, 'nk-statue-indoor-water-fountain-by-expleasia-gold-fiber-glass-buddha-monk', '6962.jpg'),
(77, 21, 1, 'bamboo-buddha-water-fount', 10, 8999, 'bamboo-buddha-water-fountain-for-home-and-office-decor-bamboo-buddha-water-fountain-for-home-and-off', '8108.jpg'),
(78, 21, 1, 'stacked-pot-jade-green', 10, 1999, 'stacked-pot-jade-green-fiber-glass-indoor-fountain-by-expleasia-stacked-pot-jade-green-fiber-glass-i', '4883.jpg'),
(79, 21, 1, 'maroon-slate-water-fall-w', 10, 19999, 'maroon-slate-water-fall-water-fountain-by-expleasia-maroon-slate-water-fall-water-fountain-by-explea', '8519.jpg'),
(81, 22, 1, 'brown-resin-trio-welcomin', 10, 599, 'brown-resin-trio-welcoming-trees-garden-figurines--set-of-3-by-aapno-rajasthan-brown-resin-trio-welc', '5331.jpg'),
(82, 22, 1, 'multicolour-resin-animals', 10, 849, 'multicolour-resin-animals-hanging-together-miniature-garden-figurines--set-of-5-by-aapno-rajasthan', '2426.jpg'),
(83, 22, 1, 'brown-ceramic-cute-rabbit', 10, 1089, 'brown-ceramic-cute-rabbit-holding-basket-garden-figurine-by-gaia-brown-ceramic-cute-rabbit-holding-b', '3241.jpg'),
(84, 22, 1, 'yellow-plastic-deer-garde', 10, 899, 'yellow-plastic-deer-garden-figurines--set-of-12-by-aapno-rajasthan-yellow-plastic-deer-garden-figuri', '2221.jpg'),
(85, 23, 1, 'green-nylon-decorative-ar', 10, 999, 'green-nylon-decorative-20x20-inches-artificial-grass-by-outdoor-greenz-green-nylon-decorative-20x20-', '1436.jpg'),
(86, 23, 1, 'green-pvc-vertical-artifi', 10, 1899, 'green-pvc-vertical-artificial-wall-mat-by-eturf-green-pvc-vertical-artificial-wall-mat-by-eturf', '1114.jpg'),
(87, 23, 1, 'green-pvc-vertical-artifi', 10, 1199, 'green-pvc-vertical-artificial-wall-mat-by-eturf-green-pvc-vertical-artificial-wall-mat-by-eturf', '4809.jpg'),
(88, 23, 1, 'green-polypropylene-high-', 10, 5599, 'green-polypropylene-35-mm-high-density-6-5-x-9-feet-artificial-grass-by-eturf-green-polypropylene', '2684.jpg'),
(89, 24, 1, 'radha-krishna-tree-multic', 10, 1599, 'radha-krishna-tree-multicolour-iron-wall-art-radha-krishna-tree-multicolour-iron-wall-art', '7967.jpg'),
(90, 24, 1, 'iron-traditional-musician', 10, 999, 'iron-traditional-musician-ship-wall-art-in-multicolor-by-craftowl-iron-traditional-musician-ship-wal', '2806.jpg'),
(91, 24, 1, 'black-dancing-lady-mdf-wa', 10, 459, 'black-dancing-lady-mdf-wall-plaque-for-wooden-wall-decor-by-art-street-black-dancing-lady-mdf-wall', '8194.jpg'),
(92, 24, 1, 'designer-deer-metal-wall-', 4499, 4499, 'designer-deer-metal-wall-decor-designer-deer-metal-wall-decor', '8370.jpg'),
(93, 24, 1, 'neptune-boat-wall', 10, 7649, 'neptune-boat-wall-d-cor-neptune-boat-wall-d-cor', '5884.jpg'),
(94, 25, 1, 'inspiration-wall-panels-i', 10, 899, 'inspiration-wall-panels-in-multicolour-by-wen-inspiration-wall-panels-in-multicolour-by-wen', '6466.jpg'),
(95, 25, 1, 'dhokra-black-brass---wood', 10, 1949, 'dhokra-black-brass---wood--set-of-2--painting-by--aakriti-art-creations-dhokra-black-brass---wood', '6310.jpg'),
(96, 25, 1, 'textured-paper-wood-frame', 10, 999, 'textured-paper-wood-framed-art-print-in-blue-by-chaque-decor-textured-paper-wood-framed-art-print', '9696.jpg'),
(97, 25, 1, 'the life of warli paintin', 10, 899, 'the-life-of-warli-painting---tribal-marriage--black-wood---metal--set-of-2--painting-by--aakriti-art', '5189.jpg'),
(98, 25, 1, 'iron-hand-painted-ganesha', 10, 899, 'iron-hand-painted-ganesha-metal-wall-art-by-jasolika-creations-iron-hand-painted-ganesha-metal-wall', '3308.jpg'),
(99, 26, 1, 'multicolour-ceramic-decor', 10, 899, 'multicolour-ceramic-decorative-wall-plate-by-the-decor-mart-multicolour-ceramic-decorative-wall-plat', '8969.jpg'),
(100, 26, 1, 'abstract-style-decortativ', 10, 578, 'abstract-style-decortative-wall-pates--set-of-7--by-quirk-india-abstract-style-decortative-wall-pate', '8099.jpg'),
(101, 26, 1, 'ceramic-wall-plates-with-', 10, 899, 'ceramic-wall-plates-with-rose-flowers-design-art-set-of-3-ceramic-wall-plates-with-rose-flowers-desi', '6590.jpg'),
(102, 26, 1, 'multicolour-ceramic-banan', 10, 589, 'multicolour-ceramic-banana-leaves-decorative-wall-plate-by-quirk-india-multicolour-ceramic-banana', '6044.jpg'),
(103, 27, 1, 'fibre-buddha-face-wall-ha', 10, 5949, 'fibre-buddha-face-wall-hanging-mural-golden-by-artociti-fibre-buddha-face-wall-hanging-mural-golden', '7539.jpg'),
(104, 27, 1, 'elephant-multicolour-mang', 10, 4949, 'elephant-multicolour-mango-wood-wall-mask-elephant-multicolour-mango-wood-wall-mask', '2304.jpg'),
(105, 27, 1, 'golden-radha-krishna-3d', 10, 4599, 'shna-3d-wall-mask-by-artociti-golden-radha-krishna-3d-wall-mask', '3238.jpg'),
(106, 27, 1, 'shamans-wall-decor-mask-b', 10, 599, 'shamans-wall-decor-mask-by-aakriti-art-creations-shamans-wall-decor-mask-by-aakriti-art-creations', '4751.jpg'),
(107, 27, 1, 'bronze-tirupati-balaji-fa', 10, 6999, 'bronze-tirupati-balaji-3d-face-wall-mask-by-artociti-bronze-tirupati-balaji-3d-face-wall-mask-by-art', '7248.jpg'),
(108, 28, 1, '3d-wooden-world-map-multi', 10, 49999, '3d-wooden-world-map-multicolour---xl-size-by-u-wood-love-it-3d-wooden-world-map-multicolour---xl', '4534.jpg'),
(109, 28, 1, '3d-wooden-world-map-multi', 10, 44999, '3d-wooden-world-map-multicolour---xl-size-by-u-wood-love-it-3d-wooden-world-map-multicolour---xl-siz', '1812.jpg'),
(110, 28, 1, '3d-wooden-world-map-multi', 10, 50999, '3d-wooden-world-map-multicolour---m-size-by-u-wood-love-it-3d-wooden-world-map-multicolour---m-size', '4359.jpg'),
(111, 28, 1, 'globe-antique-world-map-w', 10, 21999, 'globe-antique-world-map-with-countries---continent-globe-for-home-decor--gift-show-piece--decoration', '3677.jpg'),
(112, 29, 1, 'lgbt-gifts-motivational-q', 10, 199, 'lgbt-gifts-motivational-quote-multi-mouse-pad-8-5x7-inches---gifts-for-lgbtq--gifts-for-gay-men--gif', '2769.jpg'),
(113, 29, 1, 'multicolor-polycotton-cus', 10, 499, 'multicolor-polycotton-cushion-cover-with-filler-multicolor-polycotton-cushion-cover-with-filler', '7766.jpg'),
(114, 29, 1, 'multicolor-polycotton-cus', 10, 399, 'multicolor-polycotton-cushion-cover-with-filler-multicolor-polycotton-cushion-cover-with-filler', '7926.jpg'),
(115, 29, 1, 'designer-multicolour-engi', 10, 4588, 'designer-multicolour-engineered-wood-wall-hanging-quotes-designer-multicolour-engineered-wood-wall', '5333.jpg'),
(116, 3, 1, 'decorative-jewellery-mult', 2199, 2199, 'decorative-jewellery-multicolour-wood-boxes-decorative-jewellery-multicolour-wood-boxes', '5962.jpg'),
(117, 3, 1, 'decorative-jewellery-mult', 10, 2199, 'decorative-jewellery-multicolour-wood-boxes-decorative-jewellery-multicolour-wood-boxes-julrwa', '4921.jpg'),
(118, 3, 1, 'kalesh-design-wood-and-cl', 10, 1999, 'kalesh-design-wood-and-clay-jewelry-box--by-aapno-rajasthan-kalesh-design-wood-and-clay-jewelry-box', '6635.jpg'),
(120, 3, 1, 'vritti-multicolour-porcel', 10, 299, 'vritti-multicolour-porcelain-decorative-box-vritti-multicolour-porcelain-decorative-box', '2292.jpg'),
(121, 4, 1, 'vritti-multicolour-porcel', 10, 2599, 'vritti-multicolour-porcelain-decorative-box-vritti-multicolour-porcelain-decorative-box', '6979.jpg'),
(122, 4, 1, 'denham-kitchen-metal-cabi', 10, 8599, 'denham-kitchen-metal-cabinet-basic-with-oven-space-in-black-colour-by-tunehome-denham-kitchen-metal', '2541.jpg'),
(123, 4, 1, 'plant-stand-plant-stand', 10, 1999, 'plant-stand-plant-stand', '5763.jpg'),
(124, 4, 1, 'denham-kitchen-metal-cabi', 10, 899, 'denham-kitchen-metal-cabinet-basic-without-oven-space-in-silver-colour-by-tunehome-denham-kitchen-me', '6098.jpg'),
(125, 4, 1, 'multicolor-ceramic', 10, 579, 'multicolor-ceramic-1ltr-oil-dispencer-multicolor-ceramic-1ltr-oil-dispencer', '2371.jpg'),
(126, 5, 1, 'handcrafted-buddha-copper', 10, 599, 'handcrafted-buddha-copper-colour-wrought-iron-desk-organiser-by-golden-peacock-handcrafted-buddha', '5687.jpg'),
(127, 5, 1, 'wood-floral-white', 10, 889, 'sej-by-nisha-gupta-mdf-wood-floral-white-magazine-rack-sej-by-nisha-gupta-mdf-wood-floral-white-maga', '2021.jpg'),
(128, 5, 1, 'multipurpose-iron-storing', 10, 1349, 'multipurpose-iron-storing-basket-by-the-7th-dekor-multipurpose-iron-storing-basket-by-the-7th-dekor', '4881.jpg'),
(129, 5, 1, 'bogan-metal-c-shaped-tabl', 10, 2999, 'bogan-metal-c-shaped-table-in-black-colour-with-magazine-rack-bogan-metal-c-shaped-table-in-black', '9733.jpg'),
(131, 6, 1, 'handpainted-elephant-blue', 10, 849, 'handpainted-elephant-blue-iron-pen-stand-handpainted-elephant-blue-iron-pen-stand', '6782.jpg'),
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
(159, 10, 1, 'arick-decor-47inch-artifi', 10, 6099, 'arick-decor-47inch-artificial-bird-of-paradise-banana-plants-with-black-pot--home-decor-office-decor', '9806.jpg'),
(160, 10, 1, 'green-plastic-artificial-', 10, 7859, 'green-plastic-artificial-plant-with-pot-green-plastic-artificial-plant-with-pot', '4275.jpg'),
(161, 18, 1, 'plant-stand-plant-stand', 10, 519, 'plant-stand-plant-stand', '5511.jpg'),
(162, 18, 1, 'green-metal--set-of-3', 10, 589, 'green-metal--set-of-3--plant-stand-green-metal--set-of-3--plant-stand', '7335.jpg'),
(163, 18, 1, 'marmelos-white-galvanized', 10, 999, 'marmelos-white-galvanized-iron-planter-stand-by-meshable-marmelos-white-galvanized-iron-planter-stan', '8073.jpg'),
(164, 18, 1, 'grandis-white-galvanized-', 10, 1299, 'grandis-white-galvanized-iron-planter-stand--set-of-3--by-meshable-grandis-white-galvanized-iron-pla', '4042.jpg'),
(165, 19, 1, 'brown-wood', 10, 10, 'brown-wood-planter-stand-brown-wood-planter-stand', '9197.jpg'),
(166, 19, 1, 'red-metal--planter-stand', 10, 1488, 'red-metal--planter-stand-by-meshable-red-metal--planter-stand-by-meshable', '9630.jpg'),
(167, 19, 1, 'white-metal--planter-stan', 10, 587, 'white-metal--planter-stand-by-meshable-white-metal--planter-stand-by-meshable', '6876.jpg'),
(168, 19, 1, 'black-and-white-metal-pla', 10, 5899, 'black-and-white-metal-planter-stand-by-estand-black-and-white-metal-planter-stand-by-estand', '4080.webp');

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
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `delivery_person`
--
ALTER TABLE `delivery_person`
  MODIFY `delivery_person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
