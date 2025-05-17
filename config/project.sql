-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2025 at 04:40 PM
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
(3, 'quannam1', 'Quần nam', 'quần nam đẹp', '2025-05-16 15:55:36', NULL),
(5, 'aopolo2025', 'Áo Polo', 'áo polo đẹp', '2025-05-17 14:05:32', NULL),
(6, 'aosomi392', 'Áo sơ mi', 'áo sơ mi tốt', '2025-05-17 14:05:58', NULL),
(7, 'qshorts', 'Quần Shorts', 'quần short mát lạnh', '2025-05-17 14:10:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total_amount` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('cho_xac_nhan','dang_van_chuyen','thanh_toan_thanh_cong','da_nhan_hang') NOT NULL DEFAULT 'cho_xac_nhan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `phone`, `email`, `address`, `payment_method`, `total_amount`, `created_at`, `updated_at`, `status`) VALUES
(1, NULL, 'Guest_Nguyên Lê Giai', '0898943547', 'admian@deptrai.com', '1/20 Trần Quang Khải', 'COD', 517000, '2025-05-17 20:58:56', '2025-05-17 14:37:15', 'da_nhan_hang'),
(2, NULL, 'Guest_Gia Nguyên', '0898943547', 'legianguyen288@gmail.com', '1 Nguyễn Huệ', 'COD', 638000, '2025-05-17 23:28:28', '2025-05-17 16:29:26', 'da_nhan_hang'),
(3, NULL, 'Guest_Trần Quang Thừa', '0123456789', 'thua@gmail.com', '70 Nguyễn Huệ', 'COD', 529000, '2025-05-17 23:32:11', '2025-05-17 16:33:23', 'da_nhan_hang');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_code` varchar(100) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_code`, `product_name`, `product_price`, `quantity`) VALUES
(1, 1, '', 'Áo Polo Nam Thể Thao', 209000, 2),
(2, 1, '', 'Quần Shorts mặc nhà Kẻ sọc', 99000, 1),
(3, 2, '', 'Áo sơ mi dài tay Modal', 429000, 1),
(4, 2, '', 'Áo Polo Nam Thể Thao', 209000, 1),
(5, 3, '', 'Áo thun nam Excool logo', 100000, 1),
(6, 3, '', 'Áo sơ mi dài tay Modal', 429000, 1);

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
(1, 'ATCM144', 'Áo thun nam Excool logo', '1747443275_aothun.png', 100000.00, 'Áo thun mát lạnh', 'aothunnam', '2025-05-17 07:54:35', '2025-05-17 14:11:59'),
(4, 'apls1', 'Áo Polo Nam Thể Thao', '1747465670_ao-polo-nam-the-thao-promax-s1-Be_Xam_1.webp', 209000.00, 'Áo Polo đậm chất nam giới', 'aopolo2025', '2025-05-17 14:07:50', '2025-05-17 14:11:32'),
(5, 'asmmodal11', 'Áo sơ mi dài tay Modal', '1747465770_24CMCW.SM007_-_Xam_3.webp', 429000.00, 'áo đẹp', 'aosomi392', '2025-05-17 14:09:30', '2025-05-17 14:11:40'),
(6, 'qskesoc193', 'Quần Shorts mặc nhà Kẻ sọc', '1747465867_quan-shorts-mac-nha-ke-soc-mau-ngau-nhien-4.webp', 99000.00, 'mặc vào là mê', 'qshorts', '2025-05-17 14:11:07', NULL);

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
  `role` enum('admin','seller','customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
(19, 'BN', 'bn@gmail.com', '1747450130_cuong.jpg', '$2y$10$lO/gbgLvf8JlSz/e06APfuJ4NtgesxU304JW3oGHu6WvTpTcwbCB.', 'admin', '2025-05-17 02:48:50', NULL),
(20, 'aw@gmail.com', 'aw@gmail.com', NULL, '$2y$10$bO6zob8lIJIsv4/1gFxzP.KzkpHO4Z5n6Jz.rBD.gjSx6Wtt2JL5q', NULL, '2025-05-17 16:01:25', NULL);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories_code` FOREIGN KEY (`categories_code`) REFERENCES `categories` (`categories_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
