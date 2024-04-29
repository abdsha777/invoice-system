-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 02:12 PM
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
-- Database: `invoice_system`
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
  `gst_no` varchar(50) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`business_id`, `business_name`, `address`, `is_active`, `contact`, `gst_no`, `created_date`) VALUES
(1, 'R&R ENTERPRISE', 'pune', 1, '83992929', 'asdasd122d2dasad', '2024-04-28'),
(3, 'bb', 'bb', 1, 'bb', 'bbb', '2024-04-28');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_name`, `username`, `password`, `email`, `business_id`, `created_date`) VALUES
(1, 'abdulla', 'abdulla', '$2y$10$kKGd/xAg/F0/o57Z8DjFtO2VpcBlOFHdzqmyEGn/iQCv57/3nZf3a', '', 1, '2024-04-28'),
(2, 'joy', 'joy', '$2y$10$DS/zFfYN.4raI9IeH30N3.t7FaypVIqol5EmMvEGc7E4jJ771CbJ.', 'joy@joy.om', 1, '2024-04-28'),
(4, 'bb', 'bb', '$2y$10$XKaQh2IvWnpRzvHItm66RuFLAwU6WP5Pia5uYScLFpD1E/cVb5QBC', 'bb', 1, '2024-04-28'),
(5, 'asdasd', 'asd', '$2y$10$FATJasDDQdxIgR/iz3HYIe5NPV5wtAODNS.IEtdmnKANczNKxVyKO', 'asd', 3, '2024-04-28'),
(7, 'aS', 'ASDAS', '$2y$10$CSbLAr0KTKtjq7EHyVP79e0dVfx17gSYpEGwBCP1NjcEgpxjQ9Q.q', 'ASDRRR', 3, '2024-04-28'),
(8, 'aa', 'aa', '$2y$10$LdNh1eGwLYt1H/vOXvjvcOTJdtOHaiEsXAH5J0dP.92oJSJ5iXI3.', 'aa', 1, '2024-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `invoice_name` varchar(255) NOT NULL,
  `total_amount` decimal(10,0) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `destination` varchar(300) NOT NULL,
  `delivery_note` varchar(255) NOT NULL,
  `dispatcher_doc_no` varchar(255) NOT NULL,
  `terms` varchar(255) NOT NULL,
  `cutomer_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `hns_sac` varchar(40) NOT NULL,
  `gst` decimal(20,0) NOT NULL,
  `rate` decimal(10,0) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `business_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `hns_sac`, `gst`, `rate`, `quantity`, `created_date`, `business_id`, `employee_id`) VALUES
(1, 'apple', 'asdasd', 8, 22, 12, '2024-04-28', 1, 1),
(2, 'banana', 'asdasd', 18, 33, 15, '2024-04-28', 1, 1),
(3, 'Chocolate', 'yto', 28, 777, 1, '2024-04-29', 1, 1),
(4, 'orange', 'or666', 2, 20, 6, '2024-04-29', 1, 4);

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `invoice_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
