-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2025 at 06:34 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `categories_code` varchar(50) NOT NULL,
  `categories_name` varchar(100) NOT NULL,
  `categories_description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories_code`, `categories_name`, `categories_description`, `created_at`, `updated_at`) VALUES
(1, 'aothunnam', 'Áo thun', 'Áo nam cotton 100%', '2025-05-16 15:28:00', '2025-05-16 15:33:56'),
(3, 'quannam1', 'Quần nam', 'quần nam đẹp', '2025-05-16 15:55:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_description` text,
  `categories_code` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_code`, `product_name`, `product_image`, `product_price`, `product_description`, `categories_code`, `created_at`, `updated_at`) VALUES
(1, 'ATCM144', 'Áo thun nam Excool logo Coolmate', '1747443275_aothun.png', 100000.00, 'Áo thun mát lạnh', 'aothunnam', '2025-05-17 07:54:35', '2025-05-17 08:25:06'),
(2, 'QKK2025', 'Quần dài Hero ECC Pants', '1747445173_aothun.png', 600000.00, 'Quần sản phẩm lỗi Hero', 'quannam1', '2025-05-17 08:07:49', '2025-05-17 08:26:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','seller') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `avatar`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Lê Gia Nguyên', 'legianguyen288@gmail.com', '1747448184_cuong.jpg', '$2y$10$U/TsPEE/ntioGCzTPaQ6v.xICl96FCgDilOsM8cSmd3FcIIvKw5GK', 'admin', '2025-04-21 08:45:45', '2025-05-17 02:41:30'),
(16, 'NN', 'n@gmail.com', '1747387407_1747211052_Asia_Commercial_Bank_logo.svg.png', '$2y$10$3UZBWoTXFBnxY4/fd/LfweqdnEHaeEjvicPp8lepe2shuXF9ifd.q', 'seller', '2025-05-16 09:23:27', '2025-05-17 02:42:31'),
(17, 'Thừa', 'thua@gmail.com', '1747449801_binhfpt.jpg', '$2y$10$/MWf0Rm9./d4I.BbMxMwgeplNZFvCCa9mJ6VF7KZ.Q7eM/3l8S0tG', 'seller', '2025-05-17 02:08:54', '2025-05-17 02:43:21'),
(18, 'Minh VNG', 'minhvng@gmail.com', '1747450109_mingvng.png', '$2y$10$UAIQcwMm3Gt5APKWCDK.HOF3sIQPPVM0Tj58MhAUQ4cWiMrzcaYzm', 'seller', '2025-05-17 02:48:29', '2025-05-17 02:52:29'),
(19, 'BN', 'bn@gmail.com', '1747450130_cuong.jpg', '$2y$10$lO/gbgLvf8JlSz/e06APfuJ4NtgesxU304JW3oGHu6WvTpTcwbCB.', 'admin', '2025-05-17 02:48:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_code` (`categories_code`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_code` (`categories_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories_code` FOREIGN KEY (`categories_code`) REFERENCES `categories` (`categories_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
