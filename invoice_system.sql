-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql213.infinityfree.com
-- Generation Time: May 21, 2024 at 05:57 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36453876_invoice_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `business_id` int(11) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tagline` varchar(255) NOT NULL,
  `services` varchar(500) NOT NULL,
  `gst_no` varchar(50) NOT NULL,
  `bankname` varchar(50) NOT NULL,
  `accno` varchar(50) NOT NULL,
  `ifsc` varchar(50) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`business_id`, `business_name`, `address`, `is_active`, `contact`, `email`, `tagline`, `services`, `gst_no`, `bankname`, `accno`, `ifsc`, `branch`, `created_date`) VALUES
(1, 'R.R. ENTERPRISE', 'Shree Hans Avenue Flat No 3 Lane No7D/ 10D4Tingre Nagar Pune- 411032', 1, '9765479112', 'r.renterprises1497@gmail.com', 'AUTHORISED DEALER , SALES & SERVICES, ', 'Electronic Items, Electrical, Tools Kits, Split AC, AMC, Computer Accessories, Hardware, CCTV Camera, UPS Batteries, 1 KVA to 50 KVA Uniform Item &Tailoring Services, Furniture, Fabrication, Civil work, Stationery, Paints & Printing, Packing Materials, D. J SOUND SYSTEM, All Types & Decorations, Gazebo Tent, Alarm Systems ', '27FZJPS0886K1ZH ', 'Canara Bank ', '0220201001058 ', 'CNRB0000220 ', 'Lohegaon Pune ', '2024-04-28'),
(3, 'bb', 'bb', 1, 'bb', '', '', '', 'bbb', '', '', '', '', '2024-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_business_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gst_no` varchar(20) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `business_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_business_name`, `address`, `gst_no`, `mobile`, `email`, `state`, `created_date`, `business_id`) VALUES
(9, 'sohaill', 'gang gand', 'pune', '', '', '', 'maharashtra', '2024-04-30', 1),
(10, 'joy', 'joo', 'jou', '', '', '', 'jegu', '2024-04-30', 1),
(11, 'aman', 'khan', 'aa', '', '', '', 'asddsa', '2024-04-30', 1),
(28, 'sohaill', 'gang gand', 'pune', '', '', '', 'maharashtra', '2024-05-04', 1),
(29, 'aman', 'khan', 'aa', '', '', '', 'asddsa', '2024-05-04', 1),
(30, 'coho', 'pu', 'add', '', '', '', 'maha', '2024-05-04', 1),
(31, 'sohaill', 'gang gang', 'pune', '', '', '', 'maharashtra', '2024-05-05', 1),
(32, 'sohaill', 'gang gand', 'pune', '', '', '', 'maharashtra', '2024-05-05', 1),
(33, 'sohaill', 'gang gand', 'pune', '', '', '', 'maharashtra', '2024-05-06', 1),
(34, 'sohaill', 'gang gang', 'pune', '', '', '', 'maharashtra', '2024-05-07', 1),
(35, 'sohaill', 'gang gand', 'pune', '', '', '', 'maharashtra', '2024-05-17', 1),
(36, 'aaaaa', 'khklh', 'nnjg', '', '', '', 'jgjgjg', '2024-05-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `business_id` int(11) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_name`, `username`, `password`, `email`, `business_id`, `created_date`) VALUES
(1, 'abdulla', 'abdulla', '$2y$10$kKGd/xAg/F0/o57Z8DjFtO2VpcBlOFHdzqmyEGn/iQCv57/3nZf3a', '', 1, '2024-04-28'),
(2, 'joy', 'joy', '$2y$10$DS/zFfYN.4raI9IeH30N3.t7FaypVIqol5EmMvEGc7E4jJ771CbJ.', 'joy@joy.om', 1, '2024-04-28'),
(4, 'bb', 'bb', '$2y$10$XKaQh2IvWnpRzvHItm66RuFLAwU6WP5Pia5uYScLFpD1E/cVb5QBC', 'bb', 1, '2024-04-28'),
(5, 'asdasd', 'asd', '$2y$10$FATJasDDQdxIgR/iz3HYIe5NPV5wtAODNS.IEtdmnKANczNKxVyKO', 'asd', 3, '2024-04-28'),
(7, 'aS', 'ASDAS', '$2y$10$CSbLAr0KTKtjq7EHyVP79e0dVfx17gSYpEGwBCP1NjcEgpxjQ9Q.q', 'ASDRRR', 3, '2024-04-28'),
(8, 'aa', 'aa', '$2y$10$LdNh1eGwLYt1H/vOXvjvcOTJdtOHaiEsXAH5J0dP.92oJSJ5iXI3.', 'aa', 1, '2024-04-29'),
(9, 'zz', 'zz', '$2y$10$DLr9lJz2VTYQ503ykwQSSeZq4T.HO1M.ZOlB9CAP1qT.NhiavDISK', 'zz', 1, '2024-05-05');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_name` varchar(255) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `gst` decimal(10,0) NOT NULL,
  `afterTax` decimal(10,0) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `destination` varchar(300) NOT NULL,
  `delivery_note` varchar(255) NOT NULL,
  `dispatcher_doc_no` varchar(255) NOT NULL,
  `terms` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL DEFAULT current_timestamp(),
  `customer_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `invoice_name`, `total_amount`, `gst`, `afterTax`, `payment_mode`, `destination`, `delivery_note`, `dispatcher_doc_no`, `terms`, `invoice_date`, `customer_id`, `business_id`, `employee_id`) VALUES
(7, 'sohaill', '777', '8', '839', 'cash', 'pune', 'sdas', '22', 'YES', '2024-04-30', 9, 1, 1),
(14, 'joy', '4662', '0', '4662', 'cash', 'd', 'asd', '2113', 'sadsadsa', '2024-05-01', 10, 1, 1),
(32, 'sohaill', '664', '18', '784', 'cash', 'sadasd', 'asdasd', '123213', 'asdasd', '2024-05-04', 28, 1, 1),
(33, 'aman', '4664', '0', '4664', 'cash', '123', '3', '213123', 'asd', '2024-05-04', 29, 1, 1),
(34, 'coho', '400', '0', '400', 'credit_card', 'd21', '223', '222', 'yet', '2024-05-04', 30, 1, 1),
(35, 'sohaill', '400', '0', '400', 'cash', 'asddasda', 'asd', '', 'asd', '2024-05-05', 31, 1, 1),
(36, 'sohaill', '0', '2', '0', 'cash', 'R', 'R', '', '', '2024-05-05', 32, 1, 9),
(37, 'sohaill', '450', '9', '491', 'cash', 'Vf', 'Mh', '5889', '', '2024-05-06', 33, 1, 9),
(38, 'sohaill', '264', '0', '264', 'cash', 'asd', 'asd', '213', 'asd', '2024-05-07', 34, 1, 9),
(39, 'sohaill', '10501', '0', '10501', 'cash', 'H5h', 'Thy', '286', 'Thfr', '2024-05-17', 35, 1, 9),
(40, 'aaaaa', '827', '0', '827', 'cash', 'vvhv', 'jhjhk', '7686', 'jhgjhghj', '2024-05-21', 36, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `invoice_item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,0) NOT NULL,
  `rate` decimal(10,0) NOT NULL,
  `gst` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`invoice_item_id`, `invoice_id`, `product_id`, `quantity`, `rate`, `gst`, `total`) VALUES
(4, 8, 3, '4', '777', '0', '3108'),
(5, 8, 2, '15', '32', '0', '480'),
(6, 9, 1, '12', '22', '0', '264'),
(7, 9, 3, '23', '774', '0', '17802'),
(25, 7, 3, '1', '777', '0', '777'),
(27, 11, 3, '1', '777', '0', '777'),
(28, 12, 3, '12', '777', '0', '9324'),
(29, 13, 3, '1', '777', '0', '777'),
(30, 14, 0, '6', '777', '0', '4662'),
(54, 32, 1, '12', '22', '0', '264'),
(55, 32, 6, '20', '20', '0', '400'),
(56, 33, 3, '6', '777', '0', '4662'),
(57, 33, 7, '1', '2', '0', '2'),
(58, 34, 6, '20', '20', '0', '400'),
(59, 35, 6, '20', '20', '0', '400'),
(61, 37, 6, '20', '20', '0', '400'),
(62, 37, 8, '1', '50', '0', '50'),
(63, 38, 1, '12', '22', '0', '264'),
(64, 39, 3, '13', '777', '0', '10101'),
(65, 39, 6, '20', '20', '0', '400'),
(66, 40, 3, '1', '777', '0', '777'),
(67, 40, 8, '1', '50', '0', '50');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `hsn_sac` varchar(40) NOT NULL,
  `gst` decimal(20,0) NOT NULL,
  `rate` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `business_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `hsn_sac`, `gst`, `rate`, `quantity`, `created_date`, `business_id`, `employee_id`) VALUES
(1, 'apple', 'asdasd', '8', '22', 12, '2024-04-28', 1, 1),
(2, 'banana', 'asdasd', '18', '33', 15, '2024-04-28', 1, 1),
(3, 'Chocolate', 'yto', '28', '777', 1, '2024-04-29', 1, 1),
(4, 'orange', 'or666', '2', '20', 6, '2024-04-29', 1, 4),
(6, 'water', 'hahah', '0', '20', 20, '2024-05-04', 1, 1),
(7, 'wdsd', 'asd', '0', '2', 1, '2024-05-04', 1, 1),
(8, 'Pani ouri', 'Hsr', '0', '50', 1, '2024-05-06', 1, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`business_id`),
  ADD UNIQUE KEY `business_name` (`business_name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`invoice_item_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
