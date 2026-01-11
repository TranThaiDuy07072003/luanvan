-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 11, 2026 at 09:45 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nongsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_user_id_foreign` (`user_id`),
  KEY `cart_items_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(176, 5, 14, 1, '2025-12-14 01:04:02', '2025-12-14 01:04:02'),
(39, 2, 17, 2, '2025-11-20 06:37:00', '2025-11-20 06:37:00'),
(38, 2, 11, 2, '2025-11-20 06:36:29', '2025-11-20 07:39:13'),
(37, 2, 4, 4, '2025-11-20 06:35:35', '2025-11-20 06:35:35'),
(35, 2, 5, 2, '2025-11-20 05:12:52', '2025-11-21 00:01:57'),
(42, 2, 13, 13, '2025-11-21 08:12:57', '2025-11-22 01:40:45'),
(43, 2, 12, 3, '2025-11-21 08:13:20', '2025-11-22 01:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `created_at`, `updated_at`) VALUES
(8, 'Rau củ', 'rau-cu', 'Rau củ quả tươi ngon từ nông trại', 'uploads/categories/1765600660_693ced945545f.png', '2025-11-28 19:02:33', '2025-12-12 21:37:40'),
(3, 'Thịt', 'thit', 'Các loại thịt tươi ngon', 'uploads/categories/1765600786_693cee1280bc9.png', '2025-11-16 03:44:16', '2025-12-12 21:39:46'),
(4, 'Hải sản', 'ca', 'Các loại hải sản tươi ngon', 'uploads/categories/1765600877_693cee6dd4b3e.png', '2025-11-16 03:44:16', '2025-12-12 21:41:17'),
(5, 'Thực phẩm khác', 'thuc-pham-khac', 'Các loại thực phẩm bổ sung', 'uploads/categories/1765601259_693cefeb46569.png', '2025-11-16 03:44:16', '2025-12-12 21:47:39'),
(6, 'Gia vị', 'gia-vi', 'Gia vị không thể thiếu trong món ăn', 'uploads/categories/1765601010_693ceef2eccda.png', '2025-11-25 07:29:20', '2025-12-12 21:43:30'),
(10, 'Trái cây', 'trai-cay', 'Trái cây tươi ngon từ nhà vườn', 'uploads/categories/1765601057_693cef2156488.png', '2025-11-28 19:36:26', '2025-12-12 21:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_replied` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `full_name`, `phone_number`, `email`, `message`, `is_replied`, `created_at`, `updated_at`) VALUES
(1, 'Trần Thái Duy', '0999888666', 'cunglamcttduy@gmail.com', 'Xin chào , hi vọng rằng bạn luôn hạnh phúc', 1, '2025-12-02 06:28:02', '2025-12-06 17:33:17'),
(2, 'em Duy', '0123456789', 'cunglamcttduyaka@gmail.com', 'Xin chào admin, tôi muốn yêu cầu về vấn đề sản phẩm', 1, '2025-12-04 21:55:02', '2025-12-05 05:42:03'),
(3, 'Duy đây', '0932847323', 'cunglamcttduyaka@gmail.com', 'rất oke', 0, '2025-12-06 19:18:20', '2025-12-06 19:18:20'),
(4, 'Pepsi Tết đây', '0987654321', 'trandanonthemic@gmail.com', 'xin chào admin nha', 0, '2025-12-09 06:25:45', '2025-12-09 06:25:45'),
(5, 'adddddd', '0987654321', 'trandanhaimai@gmail.com', 'alo alo 1234', 0, '2025-12-10 19:32:39', '2025-12-10 19:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_08_31_014224_create_roles_table', 1),
(2, '2025_08_31_014623_create_permissions_table', 1),
(3, '2025_08_31_015759_create_role_permissions_table', 1),
(4, '2025_09_04_035951_create_users_table', 1),
(5, '2025_09_04_040023_create_categories_table', 1),
(6, '2025_09_04_040042_create_products_table', 1),
(7, '2025_09_04_040113_create_product_images_table', 1),
(8, '2025_09_04_040209_create_shipping_addresses_table', 1),
(9, '2025_09_04_040303_create_orders_table', 1),
(10, '2025_09_04_040328_create_order_items_table', 1),
(11, '2025_09_04_040425_create_payments_table', 1),
(12, '2025_09_04_040519_create_reviews_table', 1),
(13, '2025_09_04_040608_create_notifications_table', 1),
(14, '2025_09_04_040718_create_contacts_table', 1),
(15, '2025_09_04_040850_create_order_status_history_table', 1),
(16, '2025_09_04_040956_create_cart_items_table', 1),
(17, '2025_09_04_041135_create_password_reset_tokens_table', 1),
(18, '2025_10_30_024444_create_recipes_table', 1),
(19, '2025_10_30_025013_create_product_recipes_table', 1),
(20, '2025_11_11_144024_add_email_verified_at_to_users_table', 1),
(21, '2025_12_01_070451_add_soft_deletes_to_shipping_addresses_table', 2),
(22, '2025_09_04_040608_create_chat_messages_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `message`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 4, 'order', 'có đơn mới từ khách nè', '/orders', 1, '2025-12-04 05:51:01', '2025-12-07 21:38:30'),
(2, 4, 'contact', 'có liên hệ mới cũng của khách luôn', '/contact', 0, '2025-12-07 05:48:09', '2025-12-07 01:17:48'),
(3, 4, 'order', 'có đơn mới nhất luôn', '/orders', 0, '2025-12-06 05:50:29', '2025-12-07 01:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `shipping_address_id` bigint UNSIGNED NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_shipping_address_id_foreign` (`shipping_address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipping_address_id`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
(48, 4, 33, 95960.00, 'pending', '2025-12-20 22:11:13', '2025-12-20 22:11:13'),
(46, 4, 34, 337987.24, 'pending', '2025-12-20 07:02:13', '2025-12-20 07:02:13'),
(47, 4, 33, 41400.00, 'pending', '2025-12-20 22:10:08', '2025-12-20 22:10:08'),
(45, 4, 33, 85581.02, 'pending', '2025-12-20 06:49:16', '2025-12-20 06:49:16'),
(44, 4, 33, 40000.00, 'pending', '2025-12-20 04:27:51', '2025-12-20 04:27:51'),
(43, 5, 14, 243262.04, 'canceled', '2025-12-14 00:42:26', '2025-12-14 00:52:26'),
(42, 5, 23, 110681.02, 'pending', '2025-12-10 22:29:56', '2025-12-10 22:29:56'),
(41, 8, 25, 68200.00, 'completed', '2025-11-10 21:14:53', '2025-11-10 21:18:35'),
(39, 4, 24, 70581.02, 'completed', '2025-11-11 06:13:31', '2025-11-11 06:14:37'),
(40, 8, 25, 60074.25, 'completed', '2025-12-09 15:54:30', '2025-12-09 16:07:30'),
(38, 4, 10, 807130.22, 'completed', '2025-12-07 21:07:23', '2025-12-07 21:08:22'),
(37, 4, 24, 1348844.10, 'canceled', '2025-12-07 03:21:34', '2025-12-07 03:23:02'),
(36, 4, 24, 44000.00, 'completed', '2025-12-06 18:46:45', '2025-12-07 00:07:29'),
(35, 4, 24, 169872.40, 'completed', '2025-12-06 18:41:40', '2025-12-06 18:42:59'),
(34, 4, 24, 276366.36, 'pending', '2025-12-06 18:32:04', '2025-12-06 18:32:04'),
(31, 4, 24, 115000.00, 'completed', '2025-12-06 01:07:22', '2025-12-06 01:18:57'),
(32, 4, 24, 105000.00, 'canceled', '2025-12-06 01:20:32', '2025-12-06 01:24:25'),
(33, 4, 24, 124000.00, 'completed', '2025-12-06 17:38:20', '2025-12-06 17:40:49'),
(29, 4, 24, 46574.25, 'completed', '2025-12-06 00:55:00', '2025-12-06 00:59:21'),
(28, 4, 24, 61281.02, 'completed', '2025-12-05 23:31:19', '2025-12-06 00:47:40'),
(49, 4, 33, 80000.00, 'processing', '2025-12-28 03:40:13', '2025-12-28 21:51:59'),
(50, 4, 32, 842500.00, 'completed', '2025-12-29 01:39:41', '2025-12-29 23:35:16'),
(51, 4, 33, 752574.48, 'completed', '2026-01-06 01:12:18', '2026-01-06 01:18:26'),
(52, 4, 33, 85581.02, 'pending', '2026-01-06 15:11:52', '2026-01-06 15:11:52'),
(53, 4, 33, 58756.20, 'pending', '2026-01-11 02:21:22', '2026-01-11 02:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 11574.25, '2025-11-30 06:56:25', '2025-11-30 06:56:25'),
(2, 1, 15, 3, 13268.96, '2025-11-30 06:56:25', '2025-11-30 06:56:25'),
(3, 1, 18, 1, 10000.00, '2025-11-30 06:56:25', '2025-11-30 06:56:25'),
(4, 1, 19, 2, 20000.00, '2025-11-30 06:56:25', '2025-11-30 06:56:25'),
(5, 1, 20, 1, 40000.00, '2025-11-30 06:56:25', '2025-11-30 06:56:25'),
(6, 2, 13, 2, 15487.24, '2025-11-30 07:01:13', '2025-11-30 07:01:13'),
(7, 3, 19, 4, 20000.00, '2025-11-30 07:04:22', '2025-11-30 07:04:22'),
(8, 4, 13, 10, 15487.24, '2025-11-30 22:30:01', '2025-11-30 22:30:01'),
(9, 5, 20, 10, 40000.00, '2025-11-30 22:50:22', '2025-11-30 22:50:22'),
(10, 6, 21, 2, 40000.00, '2025-11-30 23:29:30', '2025-11-30 23:29:30'),
(11, 6, 6, 2, 20036.02, '2025-11-30 23:29:30', '2025-11-30 23:29:30'),
(12, 7, 30, 1, 100000.00, '2025-12-01 00:14:15', '2025-12-01 00:14:15'),
(13, 7, 19, 2, 20000.00, '2025-12-01 00:14:15', '2025-12-01 00:14:15'),
(14, 7, 14, 2, 113161.46, '2025-12-01 00:14:15', '2025-12-01 00:14:15'),
(15, 8, 1, 2, 11574.25, '2025-12-01 23:47:36', '2025-12-01 23:47:36'),
(16, 9, 33, 1, 10000.00, '2025-12-02 19:08:16', '2025-12-02 19:08:16'),
(17, 9, 27, 3, 25000.00, '2025-12-02 19:08:16', '2025-12-02 19:08:16'),
(18, 10, 3, 2, 25581.02, '2025-12-04 06:25:30', '2025-12-04 06:25:30'),
(19, 10, 23, 2, 10000.00, '2025-12-04 06:25:30', '2025-12-04 06:25:30'),
(20, 10, 30, 2, 100000.00, '2025-12-04 06:25:30', '2025-12-04 06:25:30'),
(21, 11, 14, 2, 113161.46, '2025-12-04 08:13:36', '2025-12-04 08:13:36'),
(22, 11, 13, 2, 15487.24, '2025-12-04 08:13:36', '2025-12-04 08:13:36'),
(23, 12, 1, 1, 11574.25, '2025-12-04 08:14:01', '2025-12-04 08:14:01'),
(24, 12, 19, 1, 20000.00, '2025-12-04 08:14:01', '2025-12-04 08:14:01'),
(25, 13, 6, 1, 20036.02, '2025-12-04 08:14:33', '2025-12-04 08:14:33'),
(26, 13, 3, 1, 25581.02, '2025-12-04 08:14:33', '2025-12-04 08:14:33'),
(27, 14, 24, 1, 9000.00, '2025-12-04 08:15:02', '2025-12-04 08:15:02'),
(28, 14, 28, 1, 29000.00, '2025-12-04 08:15:02', '2025-12-04 08:15:02'),
(29, 15, 30, 8, 100000.00, '2025-12-05 20:58:37', '2025-12-05 20:58:37'),
(30, 16, 13, 1, 15487.24, '2025-12-05 20:59:37', '2025-12-05 20:59:37'),
(31, 17, 13, 1, 15487.24, '2025-12-05 21:24:38', '2025-12-05 21:24:38'),
(32, 18, 13, 1, 15487.24, '2025-12-05 21:24:48', '2025-12-05 21:24:48'),
(33, 19, 13, 1, 15487.24, '2025-12-05 21:24:57', '2025-12-05 21:24:57'),
(34, 20, 13, 1, 15487.24, '2025-12-05 21:25:28', '2025-12-05 21:25:28'),
(35, 21, 13, 1, 15487.24, '2025-12-05 21:28:10', '2025-12-05 21:28:10'),
(36, 22, 13, 1, 15487.24, '2025-12-05 21:29:09', '2025-12-05 21:29:09'),
(37, 23, 13, 1, 15487.24, '2025-12-05 21:29:19', '2025-12-05 21:29:19'),
(38, 24, 13, 1, 15487.24, '2025-12-05 21:35:56', '2025-12-05 21:35:56'),
(39, 25, 19, 1, 20000.00, '2025-12-05 21:49:06', '2025-12-05 21:49:06'),
(40, 26, 1, 1, 11574.25, '2025-12-05 22:24:19', '2025-12-05 22:24:19'),
(41, 27, 15, 1, 13268.96, '2025-12-05 22:27:53', '2025-12-05 22:27:53'),
(42, 28, 23, 1, 10000.00, '2025-12-05 23:31:19', '2025-12-05 23:31:19'),
(43, 28, 4, 1, 36281.02, '2025-12-05 23:31:19', '2025-12-05 23:31:19'),
(44, 29, 19, 1, 20000.00, '2025-12-06 00:55:00', '2025-12-06 00:55:00'),
(45, 29, 1, 1, 11574.25, '2025-12-06 00:55:00', '2025-12-06 00:55:00'),
(46, 30, 20, 6, 40000.00, '2025-12-06 01:04:11', '2025-12-06 01:04:11'),
(47, 31, 32, 10, 10000.00, '2025-12-06 01:07:22', '2025-12-06 01:07:22'),
(48, 32, 24, 10, 9000.00, '2025-12-06 01:20:32', '2025-12-06 01:20:32'),
(49, 33, 26, 1, 109000.00, '2025-12-06 17:38:20', '2025-12-06 17:38:20'),
(50, 34, 16, 1, 148204.90, '2025-12-06 18:32:04', '2025-12-06 18:32:04'),
(51, 34, 14, 1, 113161.46, '2025-12-06 18:32:04', '2025-12-06 18:32:04'),
(52, 35, 13, 10, 15487.24, '2025-12-06 18:41:40', '2025-12-06 18:41:40'),
(53, 36, 28, 1, 29000.00, '2025-12-06 18:46:45', '2025-12-06 18:46:45'),
(54, 37, 16, 9, 148204.90, '2025-12-07 03:21:34', '2025-12-07 03:21:34'),
(55, 38, 14, 7, 113161.46, '2025-12-07 21:07:23', '2025-12-07 21:07:23'),
(56, 39, 11, 1, 55581.02, '2025-12-09 06:13:31', '2025-12-09 06:13:31'),
(57, 40, 39, 1, 4000.00, '2025-12-09 15:54:30', '2025-12-09 15:54:30'),
(58, 40, 38, 1, 9500.00, '2025-12-09 15:54:30', '2025-12-09 15:54:30'),
(59, 40, 19, 1, 20000.00, '2025-12-09 15:54:30', '2025-12-09 15:54:30'),
(60, 40, 1, 1, 11574.25, '2025-12-09 15:54:30', '2025-12-09 15:54:30'),
(61, 41, 40, 2, 26600.00, '2025-12-10 21:14:53', '2025-12-10 21:14:53'),
(62, 42, 38, 1, 9500.00, '2025-12-10 22:29:56', '2025-12-10 22:29:56'),
(63, 42, 39, 1, 4000.00, '2025-12-10 22:29:56', '2025-12-10 22:29:56'),
(64, 42, 11, 1, 55581.02, '2025-12-10 22:29:56', '2025-12-10 22:29:56'),
(65, 42, 40, 1, 26600.00, '2025-12-10 22:29:56', '2025-12-10 22:29:56'),
(66, 43, 39, 2, 4000.00, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(67, 43, 40, 1, 26600.00, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(68, 43, 64, 1, 4500.00, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(69, 43, 38, 2, 9500.00, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(70, 43, 53, 1, 49000.00, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(71, 43, 11, 2, 55581.02, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(72, 43, 42, 1, 10000.00, '2025-12-14 00:42:26', '2025-12-14 00:42:26'),
(73, 44, 42, 1, 10000.00, '2025-12-20 04:27:51', '2025-12-20 04:27:51'),
(74, 45, 11, 1, 55581.02, '2025-12-20 06:49:16', '2025-12-20 06:49:16'),
(75, 46, 13, 1, 15487.24, '2025-12-20 07:02:13', '2025-12-20 07:02:13'),
(76, 47, 64, 1, 4500.00, '2025-12-20 22:10:08', '2025-12-20 22:10:08'),
(77, 47, 70, 1, 6900.00, '2025-12-20 22:10:08', '2025-12-20 22:10:08'),
(78, 48, 47, 1, 39360.00, '2025-12-20 22:11:13', '2025-12-20 22:11:13'),
(79, 48, 40, 1, 26600.00, '2025-12-20 22:11:13', '2025-12-20 22:11:13'),
(80, 49, 75, 2, 25000.00, '2025-12-28 03:40:13', '2025-12-28 03:40:13'),
(81, 50, 75, 3, 45000.00, '2025-12-29 01:39:41', '2025-12-29 01:39:41'),
(82, 51, 40, 26, 26600.00, '2026-01-06 01:12:18', '2026-01-06 01:12:18'),
(83, 51, 13, 2, 15487.24, '2026-01-06 01:12:18', '2026-01-06 01:12:18'),
(84, 52, 11, 1, 55581.02, '2026-01-06 15:11:52', '2026-01-06 15:11:52'),
(85, 53, 13, 1, 15487.24, '2026-01-11 02:21:22', '2026-01-11 02:21:22'),
(86, 53, 15, 1, 13268.96, '2026-01-11 02:21:22', '2026-01-11 02:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `payment_method` enum('cash','paypal','vnpay') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `transaction_id`, `amount`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'cash', NULL, 167955.38, 'pending', NULL, '2025-11-30 06:56:25', '2025-11-30 06:56:25'),
(2, 2, 'cash', NULL, 45974.48, 'pending', NULL, '2025-11-30 07:01:13', '2025-11-30 07:01:13'),
(3, 3, 'cash', NULL, 95000.00, 'pending', NULL, '2025-11-30 07:04:22', '2025-11-30 07:04:22'),
(4, 4, 'cash', NULL, 169872.40, 'pending', NULL, '2025-11-30 22:30:01', '2025-11-30 22:30:01'),
(5, 5, 'cash', NULL, 415000.00, 'pending', NULL, '2025-11-30 22:50:22', '2025-11-30 22:50:22'),
(6, 6, 'cash', NULL, 135072.04, 'pending', NULL, '2025-11-30 23:29:30', '2025-11-30 23:29:30'),
(7, 7, 'cash', NULL, 381322.92, 'pending', NULL, '2025-12-01 00:14:15', '2025-12-01 00:14:15'),
(8, 8, 'cash', NULL, 38148.50, 'completed', NULL, '2025-12-01 23:47:36', '2025-12-01 23:47:36'),
(9, 9, 'cash', NULL, 100000.00, 'pending', NULL, '2025-12-02 19:08:16', '2025-12-02 19:08:16'),
(10, 10, 'cash', NULL, 286162.04, 'pending', NULL, '2025-12-04 06:25:30', '2025-12-04 06:25:30'),
(11, 11, 'cash', NULL, 272297.40, 'pending', NULL, '2025-12-04 08:13:36', '2025-12-04 08:13:36'),
(12, 12, 'cash', NULL, 46574.25, 'pending', NULL, '2025-12-04 08:14:01', '2025-12-04 08:14:01'),
(13, 13, 'cash', NULL, 60617.04, 'pending', NULL, '2025-12-04 08:14:33', '2025-12-04 08:14:33'),
(14, 14, 'cash', NULL, 53000.00, 'pending', NULL, '2025-12-04 08:15:02', '2025-12-04 08:15:02'),
(15, 15, 'cash', NULL, 815000.00, 'pending', NULL, '2025-12-05 20:58:37', '2025-12-05 20:58:37'),
(16, 24, 'vnpay', NULL, 30487.24, 'pending', NULL, '2025-12-05 21:35:56', '2025-12-05 21:35:56'),
(17, 25, 'vnpay', NULL, 35000.00, 'completed', '2025-12-05 21:50:10', '2025-12-05 21:49:06', '2025-12-05 21:50:10'),
(18, 26, 'vnpay', NULL, 26574.25, 'completed', '2025-12-05 22:25:26', '2025-12-05 22:24:19', '2025-12-05 22:25:26'),
(19, 27, 'cash', NULL, 28268.96, 'pending', NULL, '2025-12-05 22:27:53', '2025-12-05 22:27:53'),
(20, 28, 'vnpay', NULL, 61281.02, 'completed', '2025-12-05 23:32:02', '2025-12-05 23:31:19', '2025-12-05 23:32:02'),
(21, 29, 'vnpay', NULL, 46574.25, 'completed', '2025-12-06 00:56:26', '2025-12-06 00:55:00', '2025-12-06 00:56:26'),
(22, 30, 'vnpay', NULL, 255000.00, 'pending', NULL, '2025-12-06 01:04:11', '2025-12-06 01:04:11'),
(23, 31, 'vnpay', NULL, 115000.00, 'completed', '2025-12-06 01:08:52', '2025-12-06 01:07:22', '2025-12-06 01:08:52'),
(24, 32, 'cash', NULL, 105000.00, 'pending', NULL, '2025-12-06 01:20:32', '2025-12-06 01:20:32'),
(25, 33, 'cash', NULL, 124000.00, 'completed', '2025-12-06 17:40:49', '2025-12-06 17:38:20', '2025-12-06 17:40:49'),
(26, 34, 'cash', NULL, 276366.36, 'pending', NULL, '2025-12-06 18:32:04', '2025-12-06 18:32:04'),
(27, 35, 'cash', NULL, 169872.40, 'completed', '2025-12-06 18:42:59', '2025-12-06 18:41:40', '2025-12-06 18:42:59'),
(28, 36, 'vnpay', NULL, 44000.00, 'completed', '2025-12-06 18:47:41', '2025-12-06 18:46:45', '2025-12-06 18:47:41'),
(29, 37, 'cash', NULL, 1348844.10, 'pending', NULL, '2025-12-07 03:21:34', '2025-12-07 03:21:34'),
(30, 38, 'cash', NULL, 807130.22, 'completed', '2025-12-07 21:08:22', '2025-12-07 21:07:23', '2025-12-07 21:08:22'),
(31, 39, 'cash', NULL, 70581.02, 'completed', '2025-12-09 06:14:37', '2025-12-09 06:13:31', '2025-12-09 06:14:37'),
(32, 40, 'vnpay', NULL, 60074.25, 'completed', '2025-12-09 15:55:42', '2025-12-09 15:54:30', '2025-12-09 15:55:42'),
(33, 41, 'cash', NULL, 68200.00, 'completed', '2025-12-10 21:18:35', '2025-12-10 21:14:53', '2025-12-10 21:18:35'),
(34, 42, 'cash', NULL, 110681.02, 'pending', NULL, '2025-12-10 22:29:56', '2025-12-10 22:29:56'),
(35, 43, 'vnpay', NULL, 243262.04, 'completed', '2025-12-14 00:43:46', '2025-12-14 00:42:26', '2025-12-14 00:43:46'),
(36, 44, 'cash', NULL, 40000.00, 'pending', NULL, '2025-12-20 04:27:51', '2025-12-20 04:27:51'),
(37, 45, 'cash', NULL, 85581.02, 'pending', NULL, '2025-12-20 06:49:16', '2025-12-20 06:49:16'),
(38, 46, 'cash', NULL, 337987.24, 'pending', NULL, '2025-12-20 07:02:13', '2025-12-20 07:02:13'),
(39, 47, 'vnpay', NULL, 41400.00, 'pending', NULL, '2025-12-20 22:10:08', '2025-12-20 22:10:08'),
(40, 48, 'vnpay', NULL, 95960.00, 'completed', '2025-12-20 22:12:27', '2025-12-20 22:11:13', '2025-12-20 22:12:27'),
(41, 49, 'cash', NULL, 80000.00, 'pending', NULL, '2025-12-28 03:40:13', '2025-12-28 03:40:13'),
(42, 50, 'cash', NULL, 842500.00, 'completed', '2025-12-29 23:35:16', '2025-12-29 01:39:41', '2025-12-29 23:35:16'),
(43, 51, 'cash', NULL, 752574.48, 'completed', '2026-01-06 01:18:26', '2026-01-06 01:12:18', '2026-01-06 01:18:26'),
(44, 52, 'cash', NULL, 85581.02, 'pending', NULL, '2026-01-06 15:11:52', '2026-01-06 15:11:52'),
(45, 53, 'vnpay', NULL, 58756.20, 'completed', '2026-01-11 02:22:45', '2026-01-11 02:21:22', '2026-01-11 02:22:45');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'manager_users', '2025-11-23 07:11:56', '2025-11-23 07:11:56'),
(2, 'manager_products', '2025-11-23 07:11:56', '2025-11-23 07:11:56'),
(3, 'manager_orders', '2025-11-23 07:11:56', '2025-11-23 07:11:56'),
(4, 'manager_categories', '2025-11-23 07:11:56', '2025-11-23 07:11:56'),
(5, 'manager_contacts', '2025-11-23 07:11:56', '2025-11-23 07:11:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_stock',
  `unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_name_unique` (`name`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `category_id`, `description`, `price`, `expiry_date`, `stock`, `status`, `unit`, `created_at`, `updated_at`) VALUES
(13, 'Khoai lang', 'khoai-lang-791', 8, 'Khoai lang được trồng ở các vùng núi Tây Bác', 15487.24, NULL, 76, 'in_stock', 'kg', '2025-11-16 06:28:14', '2026-01-11 02:21:22'),
(12, 'Tỏi cô đơn', 'toi-ly-son-832', 5, 'Accusamus minima animi ducimus consequatur aut dolores sed magnam eos et et iste.', 11554.91, NULL, 35, 'out_of_stock', 'g', '2025-11-16 06:28:14', '2025-11-27 22:35:49'),
(40, 'Khoai mỡ', 'khoai-mo-1765422973', 8, 'Khoai mỡ dùng để nấu canh sẽ rất ngon và bổ dưỡng', 26600.00, NULL, 0, 'in_stock', 'g', '2025-12-10 20:16:13', '2026-01-06 01:12:18'),
(11, 'Tôm sú', 'tom-su-257', 4, 'Quibusdam odit at doloribus magnam dolorem a facere ad omnis possimus.', 55581.02, NULL, 47, 'in_stock', 'g', '2025-11-16 06:28:14', '2026-01-06 15:11:52'),
(10, 'Cam sành', 'cam-sanh-271', 10, 'Quaerat aut earum quo recusandae sunt est voluptatem impedit nihil iusto.', 46136.91, NULL, 10, 'out_of_stock', 'kg', '2025-11-16 06:28:14', '2025-11-29 01:26:18'),
(47, 'Đùi gà góc tư', 'dui-ga-goc-tu-1765602744', 3, 'dùng làm món gà chiên', 39360.00, NULL, 39, 'in_stock', 'g', '2025-12-12 22:12:24', '2025-12-20 22:11:13'),
(48, 'Thịt bò xay', 'thit-bo-xay-1765603525', 3, 'thịt bò xay tươi ngon trong ngày', 63900.00, NULL, 30, 'in_stock', 'g', '2025-12-12 22:25:25', '2025-12-12 22:25:25'),
(14, 'Gừng tươi', 'gung-tuoi-99', 8, 'Gừng ngon cam kết chất lượng', 113161.46, NULL, 40, 'in_stock', 'kg', '2025-11-16 06:28:14', '2025-12-07 21:07:23'),
(15, 'Cà chua bi', 'ca-chua-bi-391', 8, 'Cà chua bi ở Đà Lạt', 13268.96, NULL, 48, 'in_stock', 'kg', '2025-11-16 06:28:14', '2026-01-11 02:21:22'),
(16, 'Thịt heo ba rọi', 'thit-heo-ba-roi-825', 3, 'Magnam cum et aliquam labore aliquid earum quod accusantium nemo impedit.', 148204.90, NULL, 9, 'in_stock', 'kg', '2025-11-16 06:28:14', '2025-12-07 03:23:02'),
(19, 'Thịt heo xay', 'thit-heo-xay-1764310212', 3, 'Thịt heo CP ngon', 20000.00, NULL, 46, 'in_stock', 'g', '2025-11-27 23:10:12', '2025-12-09 15:54:30'),
(1, 'Bí đỏ hồ lô', 'bi-do-22', 8, 'thom ngon moi ban an nha', 11574.25, NULL, 5, 'in_stock', 'g', '2025-11-18 06:23:57', '2025-12-09 15:54:30'),
(2, 'Cá hồi cắt khúc', 'ca-hoi-phi-le-22', 4, 'thom ngon fghkhkhkfkfk', 123456.46, NULL, 16, 'in_stock', 'g', '2025-11-18 06:29:38', '2025-11-27 23:05:17'),
(3, 'Dưa hấu đỏ', 'dua-hau-63', 10, 'duahaukalacdjdjdnd', 25581.02, NULL, 33, 'in_stock', 'kg', '2025-11-18 06:37:28', '2025-12-04 08:14:33'),
(4, 'Táo Ninh Thuận', 'tao-xanh-14', 10, 'taoxanhdsdjsdskdksdnks', 36281.02, NULL, 49, 'in_stock', 'kg', '2025-11-18 06:37:28', '2025-12-05 23:31:19'),
(6, 'Cải bẹ xanh', 'cai-xanh-42', 8, 'caixanhdksjdskdsdsds', 20036.02, NULL, 50, 'in_stock', 'bó', '2025-11-18 06:37:28', '2025-12-04 08:14:33'),
(18, 'Khổ qua đèo', 'kho-qua-deo-1764242709', 8, 'rat ngon', 10000.00, NULL, 20, 'in_stock', 'kg', '2025-11-27 04:25:09', '2025-12-01 22:56:25'),
(20, 'Mít sấy Vinamit', 'mit-say-vinamit-1764310532', 5, 'Mít sấy tươi ngon hảo hạn', 40000.00, NULL, 30, 'in_stock', 'gói', '2025-11-27 23:15:32', '2025-12-06 01:04:11'),
(21, 'Bưởi da xanh', 'buoi-da-xanh-1764310770', 10, 'Bưởi da xanh thơm ngon mời bạn ăn nha', 40000.00, NULL, 28, 'in_stock', 'kg', '2025-11-27 23:19:30', '2025-12-01 23:45:31'),
(22, 'Dưa lưới tròn ruột cam', 'dua-luoi-tron-ruot-cam-1764310874', 10, 'Dualuoizmbzzxvzzxvz', 50000.00, NULL, 10, 'in_stock', 'kg', '2025-11-27 23:21:14', '2025-12-01 23:45:20'),
(23, 'Dừa xiêm tiện lợi', 'dua-xiem-tien-loi-1764310999', 10, 'Duaxiemasdasdasdasdsd', 10000.00, NULL, 17, 'in_stock', 'trái', '2025-11-27 23:23:19', '2025-12-05 23:31:19'),
(24, 'Thơm trái gọt sẵn', 'thom-trai-got-san-1764311138', 10, 'thơm traisassdádđsd', 9000.00, NULL, 30, 'in_stock', 'g', '2025-11-27 23:25:38', '2025-12-06 01:24:25'),
(46, 'Chân gà', 'chan-ga-1765602603', 3, 'làm nhiều món ngon', 28600.00, NULL, 20, 'in_stock', 'g', '2025-12-12 22:10:03', '2025-12-12 22:10:03'),
(26, 'Thịt ba chỉ bò Mỹ cuộn', 'thit-ba-chi-bo-my-cuon-1764311385', 3, 'Thịt ba chỉ bò Mỹ cuộnzzzzzzzzzzz', 109000.00, NULL, 39, 'in_stock', 'g', '2025-11-27 23:29:45', '2025-12-06 17:38:20'),
(27, 'Cánh tỏi gà', 'canh-toi-ga-1764311629', 3, 'Cánh tỏi gàzzzzzzzzz', 25000.00, NULL, 57, 'in_stock', 'g', '2025-11-27 23:33:49', '2025-12-02 19:08:16'),
(28, 'Cá basa cắt khúc', 'ca-basa-cat-khuc-1764312021', 4, 'Cá basa cắt khúc', 29000.00, NULL, 29, 'in_stock', 'g', '2025-11-27 23:40:21', '2025-12-06 18:46:45'),
(29, 'Coca Tết', 'coca-tet-1764312333', 6, 'Coca têtzzzzz', 100000.00, NULL, 40, 'in_stock', 'thùng', '2025-11-27 23:45:33', '2025-12-04 19:14:25'),
(30, 'Pepsi Tết', 'pepsi-tet-1764312398', 6, 'Pepsi têtzzzzzzzzzz', 100000.00, NULL, 40, 'in_stock', 'thùng', '2025-11-27 23:46:38', '2025-12-05 20:58:37'),
(32, 'Cà rốt', 'ca-rot-1764659638', 8, 'Cà rốt tươi ngon, màu cam tươi, vỏ trơn láng, có màu sáng', 10000.00, NULL, 20, 'in_stock', 'g', '2025-12-02 00:13:58', '2025-12-06 01:07:22'),
(33, 'pepsi không calo', 'pepsi-khong-calo-1764720397', 6, 'Pepsi têtzzzzzzzooo', 10000.00, NULL, 19, 'out_of_stock', 'thùng', '2025-12-02 17:06:37', '2025-12-04 19:14:53'),
(41, 'Rau tần ô', 'rau-tan-o-1765601490', 8, 'Dùng để nấu canh rất ngon', 24000.00, NULL, 30, 'in_stock', 'bo', '2025-12-12 21:51:30', '2025-12-12 21:51:30'),
(42, 'Bầu sao', 'bau-sao-1765601717', 8, 'Dùng để nấu canh', 10000.00, NULL, 39, 'in_stock', 'trai', '2025-12-12 21:55:17', '2025-12-20 04:27:51'),
(38, 'Hành lá', 'hanh-la-1765200785', 8, 'Hành lá, ngò rí được đóng gói cẩn thận, tươi đến cuối ngày.', 9500.00, NULL, 48, 'in_stock', 'g', '2025-12-08 06:33:05', '2025-12-14 00:52:26'),
(39, 'Ngò gai, rau om', 'ngo-gai-rau-om-1765201433', 8, 'Ngò gai rau om được đóng gói cẩn thận, tươi đến cuối ngày.', 4000.00, NULL, 28, 'in_stock', 'bo', '2025-12-08 06:43:53', '2025-12-14 00:52:26'),
(43, 'Xương heo có thịt', 'xuong-heo-co-thit-1765601939', 3, 'Dùng để nấu món mặn hoặc nấu canh', 26700.00, NULL, 40, 'in_stock', 'g', '2025-12-12 21:58:59', '2025-12-12 21:58:59'),
(44, 'Sườn non heo', 'suon-non-heo-1765602280', 3, 'dùng để nấu món mặn', 50575.00, NULL, 30, 'in_stock', 'g', '2025-12-12 22:04:40', '2025-12-12 22:04:40'),
(45, 'Cánh gà', 'canh-ga-1765602476', 3, 'làm gà chiên rất ngon', 47900.00, NULL, 40, 'in_stock', 'g', '2025-12-12 22:07:56', '2025-12-12 22:07:56'),
(49, 'Thịt vụn bò', 'thit-vun-bo-1765608024', 3, 'làm món ăn mỗi ngày', 50100.00, NULL, 30, 'in_stock', 'g', '2025-12-12 23:40:24', '2025-12-12 23:40:24'),
(50, 'Thịt nạm bò', 'thit-nam-bo-1765608184', 3, 'làm món bò kho rất ngon', 41200.00, NULL, 40, 'in_stock', 'g', '2025-12-12 23:43:04', '2025-12-12 23:43:04'),
(51, 'Cá diêu hồng', 'ca-dieu-hong-1765608381', 4, 'làm món canh', 38540.00, NULL, 30, 'in_stock', 'g', '2025-12-12 23:46:21', '2025-12-12 23:46:21'),
(52, 'Cá nục', 'ca-nuc-1765608513', 4, 'làm canh chua cũng sẽ rất hợp', 39000.00, NULL, 25, 'in_stock', 'g', '2025-12-12 23:48:33', '2025-12-12 23:48:33'),
(53, 'Tôm thẻ', 'tom-the-1765608675', 4, 'Nấu món mặn hoặc món canh đều được', 49000.00, NULL, 35, 'in_stock', 'g', '2025-12-12 23:51:15', '2025-12-14 00:52:26'),
(54, 'Râu mực nhập khẩu', 'rau-muc-nhap-khau-1765608916', 4, 'xuất xứ từ vùng biển Nha Trang, hạn sử dụng 2 tháng kể từ ngày đóng gói', 36000.00, NULL, 40, 'in_stock', 'g', '2025-12-12 23:55:16', '2025-12-12 23:55:16'),
(55, 'Hàu sữa gói', 'hau-sua-goi-1765609064', 4, 'Có thể dùng nấu chung với cháo , hoặc lẩu sẽ có hương vị thơm ngon', 81000.00, NULL, 20, 'in_stock', 'g', '2025-12-12 23:57:44', '2025-12-12 23:57:44'),
(56, 'Thịt hến làm sạch', 'thit-hen-lam-sach-1765609173', 4, 'Có thể dùng để nấu cháo hoặc làm canh để có được hương vị thơm ngon', 27800.00, NULL, 35, 'in_stock', 'g', '2025-12-12 23:59:33', '2025-12-12 23:59:33'),
(57, 'Thịt ốc bươu', 'thit-oc-buou-1765609322', 4, 'Có thể nấu cùng với bún riêu để có hương vị thơm ngon', 25800.00, NULL, 30, 'in_stock', 'g', '2025-12-13 00:02:02', '2025-12-13 00:02:02'),
(58, 'Bạc hà (dọc mùng)', 'bac-ha-doc-mung-1765609710', 8, 'Hương vị giòn xốp và mọng nước', 7500.00, NULL, 30, 'in_stock', 'g', '2025-12-13 00:08:30', '2025-12-13 00:08:30'),
(59, 'Me chua', 'me-chua-1765610041', 6, 'Dùng làm nước chấm hoặc nấu canh sẽ rất ngon', 5300.00, NULL, 25, 'in_stock', 'g', '2025-12-13 00:14:01', '2025-12-13 00:14:01'),
(60, 'Giá mầm sạch', 'gia-mam-sach-1765610174', 8, 'Dùng làm món xào hoặc làm món canh', 10500.00, NULL, 40, 'in_stock', 'g', '2025-12-13 00:16:14', '2025-12-13 00:16:14'),
(61, 'Đậu bắp', 'dau-bap-1765610325', 8, 'Dùng làm món canh hoặc món xào, chay mặn đều dùng được', 15000.00, NULL, 25, 'in_stock', 'g', '2025-12-13 00:18:45', '2025-12-13 00:18:45'),
(62, 'Cá lóc', 'ca-loc-1765610706', 4, 'Dùng làm món canh hoặc món mặn', 35350.00, NULL, 35, 'in_stock', 'g', '2025-12-13 00:25:06', '2025-12-13 00:25:06'),
(63, 'Cà chua', 'ca-chua-1765610978', 8, 'Làm món salad hoặc món canh đều hợp', 19500.00, NULL, 35, 'in_stock', 'g', '2025-12-13 00:29:38', '2025-12-13 00:29:38'),
(64, 'Ngò rí', 'ngo-ri-1765612353', 8, 'Dùng làm món ăn kèm để tăng hương vị, hoặc có thể làm món canh', 4500.00, NULL, 34, 'in_stock', 'g', '2025-12-13 00:52:33', '2025-12-20 22:10:08'),
(65, 'Bắp cải trắng', 'bap-cai-trang-1765613050', 8, 'Dùng làm món canh hoặc món xào', 17600.00, NULL, 30, 'in_stock', 'g', '2025-12-13 01:04:10', '2025-12-13 01:04:10'),
(66, 'Củ dền', 'cu-den-1765613731', 8, 'Dùng để nấu món canh', 7400.00, NULL, 25, 'in_stock', 'g', '2025-12-13 01:15:31', '2025-12-13 01:15:31'),
(67, 'Khoai tây', 'khoai-tay-1765613812', 8, 'Làm món mặn hoặc món canh', 6000.00, NULL, 40, 'in_stock', 'g', '2025-12-13 01:16:52', '2025-12-13 01:16:52'),
(68, 'Su su', 'su-su-1765613863', 8, 'Làm món hầm hoặc món canh', 7000.00, NULL, 30, 'in_stock', 'g', '2025-12-13 01:17:43', '2025-12-13 01:17:43'),
(69, 'Rau cần tàu (cần ta)', 'rau-can-tau-can-ta-1765614201', 8, 'Dùng kèm theo các món khác hoặc làm món canh', 6900.00, NULL, 30, 'in_stock', 'g', '2025-12-13 01:23:21', '2025-12-13 01:23:21'),
(70, 'Cải ngọt', 'cai-ngot-1765614469', 8, 'Dùng làm món xào hoặc món canh đều được', 6900.00, NULL, 29, 'in_stock', 'g', '2025-12-13 01:27:49', '2025-12-20 22:10:08'),
(71, 'Rau ngót', 'rau-ngot-1765615058', 8, 'Dùng làm món canh', 15000.00, '2026-01-10', 30, 'in_stock', 'bo', '2025-12-13 01:37:38', '2026-01-09 07:07:46'),
(75, 'test thử', 'test-thu-1766916634', 6, 'thử sản phẩm', 45000.00, '2026-01-09', 2, 'in_stock', 'thung', '2025-12-28 03:10:34', '2026-01-09 07:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=267 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 18, 'uploads/products/1764242709_69283515458cf.jpg', '2025-11-27 04:25:09', '2025-11-27 04:25:09'),
(2, 18, 'uploads/products/1764242709_692835157f361.jpg', '2025-11-27 04:25:09', '2025-11-27 04:25:09'),
(3, 18, 'uploads/products/1764242709_69283515a4029.jpg', '2025-11-27 04:25:09', '2025-11-27 04:25:09'),
(4, 18, 'uploads/products/1764242709_69283515c6a1a.jpg', '2025-11-27 04:25:09', '2025-11-27 04:25:09'),
(26, 14, 'uploads/products/1764304588_692926cc393ba.jpg', '2025-11-27 21:36:28', '2025-11-27 21:36:28'),
(25, 14, 'uploads/products/1764304588_692926cc18264.jpg', '2025-11-27 21:36:28', '2025-11-27 21:36:28'),
(24, 14, 'uploads/products/1764304587_692926cbee280.jpg', '2025-11-27 21:36:28', '2025-11-27 21:36:28'),
(23, 14, 'uploads/products/1764304587_692926cbc6e4d.jpg', '2025-11-27 21:36:27', '2025-11-27 21:36:27'),
(15, 16, 'uploads/products/1764300619_6929174b8038c.jpg', '2025-11-27 20:30:19', '2025-11-27 20:30:19'),
(16, 16, 'uploads/products/1764300619_6929174ba680a.jpg', '2025-11-27 20:30:19', '2025-11-27 20:30:19'),
(17, 16, 'uploads/products/1764300619_6929174bceaf9.jpg', '2025-11-27 20:30:19', '2025-11-27 20:30:19'),
(18, 16, 'uploads/products/1764300619_6929174bf2eaa.jpg', '2025-11-27 20:30:20', '2025-11-27 20:30:20'),
(19, 15, 'uploads/products/1764301294_692919eecabb7.jpg', '2025-11-27 20:41:35', '2025-11-27 20:41:35'),
(20, 15, 'uploads/products/1764301295_692919ef06f31.jpg', '2025-11-27 20:41:35', '2025-11-27 20:41:35'),
(21, 15, 'uploads/products/1764301295_692919ef30aa1.jpg', '2025-11-27 20:41:35', '2025-11-27 20:41:35'),
(22, 15, 'uploads/products/1764301295_692919ef59721.jpg', '2025-11-27 20:41:35', '2025-11-27 20:41:35'),
(27, 14, 'uploads/products/1764304588_692926cc5dc70.jpg', '2025-11-27 21:36:28', '2025-11-27 21:36:28'),
(28, 14, 'uploads/products/1764304588_692926cc7a333.jpg', '2025-11-27 21:36:28', '2025-11-27 21:36:28'),
(29, 13, 'uploads/products/1764307134_692930be17b5c.jpg', '2025-11-27 22:18:54', '2025-11-27 22:18:54'),
(30, 13, 'uploads/products/1764307134_692930be742a2.jpg', '2025-11-27 22:18:54', '2025-11-27 22:18:54'),
(31, 13, 'uploads/products/1764307134_692930bebfb08.jpg', '2025-11-27 22:18:55', '2025-11-27 22:18:55'),
(32, 13, 'uploads/products/1764307135_692930bf1e61b.jpg', '2025-11-27 22:18:55', '2025-11-27 22:18:55'),
(33, 6, 'uploads/products/1764307768_69293338a015b.jpg', '2025-11-27 22:29:28', '2025-11-27 22:29:28'),
(34, 6, 'uploads/products/1764307768_69293338ed419.jpg', '2025-11-27 22:29:29', '2025-11-27 22:29:29'),
(35, 6, 'uploads/products/1764307769_692933394223c.jpg', '2025-11-27 22:29:29', '2025-11-27 22:29:29'),
(36, 6, 'uploads/products/1764307769_692933398d6fd.jpg', '2025-11-27 22:29:29', '2025-11-27 22:29:29'),
(37, 12, 'uploads/products/1764308149_692934b5edeaf.jpg', '2025-11-27 22:35:50', '2025-11-27 22:35:50'),
(38, 12, 'uploads/products/1764308150_692934b647fcc.jpg', '2025-11-27 22:35:50', '2025-11-27 22:35:50'),
(39, 12, 'uploads/products/1764308150_692934b692f6f.jpg', '2025-11-27 22:35:50', '2025-11-27 22:35:50'),
(40, 12, 'uploads/products/1764308150_692934b6db3cc.jpg', '2025-11-27 22:35:51', '2025-11-27 22:35:51'),
(41, 11, 'uploads/products/1764308358_69293586a9574.jpg', '2025-11-27 22:39:19', '2025-11-27 22:39:19'),
(42, 11, 'uploads/products/1764308359_6929358703220.jpg', '2025-11-27 22:39:19', '2025-11-27 22:39:19'),
(43, 11, 'uploads/products/1764308359_692935874ec17.jpg', '2025-11-27 22:39:19', '2025-11-27 22:39:19'),
(44, 11, 'uploads/products/1764308359_692935879b950.jpg', '2025-11-27 22:39:19', '2025-11-27 22:39:19'),
(45, 10, 'uploads/products/1764309400_69293998282d4.jpg', '2025-11-27 22:56:40', '2025-11-27 22:56:40'),
(46, 10, 'uploads/products/1764309400_6929399878b73.jpg', '2025-11-27 22:56:40', '2025-11-27 22:56:40'),
(47, 10, 'uploads/products/1764309400_69293998c192a.jpg', '2025-11-27 22:56:41', '2025-11-27 22:56:41'),
(48, 10, 'uploads/products/1764309401_6929399919cb4.jpg', '2025-11-27 22:56:41', '2025-11-27 22:56:41'),
(49, 4, 'uploads/products/1764309633_69293a81d8be6.jpg', '2025-11-27 23:00:34', '2025-11-27 23:00:34'),
(50, 4, 'uploads/products/1764309634_69293a8201ce3.jpg', '2025-11-27 23:00:34', '2025-11-27 23:00:34'),
(51, 4, 'uploads/products/1764309634_69293a822b0d8.jpg', '2025-11-27 23:00:34', '2025-11-27 23:00:34'),
(52, 4, 'uploads/products/1764309634_69293a824f079.jpg', '2025-11-27 23:00:34', '2025-11-27 23:00:34'),
(53, 3, 'uploads/products/1764309787_69293b1b9cdd1.jpg', '2025-11-27 23:03:07', '2025-11-27 23:03:07'),
(54, 3, 'uploads/products/1764309787_69293b1bc07ac.jpg', '2025-11-27 23:03:07', '2025-11-27 23:03:07'),
(55, 3, 'uploads/products/1764309787_69293b1be72fb.jpg', '2025-11-27 23:03:08', '2025-11-27 23:03:08'),
(56, 3, 'uploads/products/1764309788_69293b1c119d8.jpg', '2025-11-27 23:03:08', '2025-11-27 23:03:08'),
(57, 2, 'uploads/products/1764309917_69293b9d84e61.jpg', '2025-11-27 23:05:17', '2025-11-27 23:05:17'),
(58, 2, 'uploads/products/1764309917_69293b9db017a.jpg', '2025-11-27 23:05:17', '2025-11-27 23:05:17'),
(59, 2, 'uploads/products/1764309917_69293b9de2f69.jpg', '2025-11-27 23:05:18', '2025-11-27 23:05:18'),
(60, 2, 'uploads/products/1764309918_69293b9e1a650.jpg', '2025-11-27 23:05:18', '2025-11-27 23:05:18'),
(61, 1, 'uploads/products/1764310037_69293c1565de6.jpg', '2025-11-27 23:07:17', '2025-11-27 23:07:17'),
(62, 1, 'uploads/products/1764310037_69293c158cefa.jpg', '2025-11-27 23:07:17', '2025-11-27 23:07:17'),
(63, 1, 'uploads/products/1764310037_69293c15b42e6.jpg', '2025-11-27 23:07:17', '2025-11-27 23:07:17'),
(64, 1, 'uploads/products/1764310037_69293c15dd09b.jpg', '2025-11-27 23:07:18', '2025-11-27 23:07:18'),
(65, 19, 'uploads/products/1764310212_69293cc4c99a2.jpg', '2025-11-27 23:10:12', '2025-11-27 23:10:12'),
(66, 19, 'uploads/products/1764310212_69293cc4ea8bb.jpg', '2025-11-27 23:10:13', '2025-11-27 23:10:13'),
(67, 19, 'uploads/products/1764310213_69293cc516ff0.jpg', '2025-11-27 23:10:13', '2025-11-27 23:10:13'),
(68, 19, 'uploads/products/1764310213_69293cc544c77.jpg', '2025-11-27 23:10:13', '2025-11-27 23:10:13'),
(69, 20, 'uploads/products/1764310532_69293e04b2b7d.jpg', '2025-11-27 23:15:32', '2025-11-27 23:15:32'),
(70, 20, 'uploads/products/1764310532_69293e04d5fbd.jpg', '2025-11-27 23:15:33', '2025-11-27 23:15:33'),
(71, 20, 'uploads/products/1764310533_69293e05057ba.jpg', '2025-11-27 23:15:33', '2025-11-27 23:15:33'),
(72, 21, 'uploads/products/1764310770_69293ef2a2d64.jpg', '2025-11-27 23:19:30', '2025-11-27 23:19:30'),
(73, 21, 'uploads/products/1764310770_69293ef2c143f.jpg', '2025-11-27 23:19:30', '2025-11-27 23:19:30'),
(74, 21, 'uploads/products/1764310770_69293ef2e3522.jpg', '2025-11-27 23:19:31', '2025-11-27 23:19:31'),
(75, 21, 'uploads/products/1764310771_69293ef316d07.jpg', '2025-11-27 23:19:31', '2025-11-27 23:19:31'),
(76, 22, 'uploads/products/1764310874_69293f5a7a2b8.jpg', '2025-11-27 23:21:14', '2025-11-27 23:21:14'),
(77, 22, 'uploads/products/1764310874_69293f5aa5e75.jpg', '2025-11-27 23:21:14', '2025-11-27 23:21:14'),
(78, 22, 'uploads/products/1764310874_69293f5ad0895.jpg', '2025-11-27 23:21:14', '2025-11-27 23:21:14'),
(79, 22, 'uploads/products/1764310874_69293f5af2879.jpg', '2025-11-27 23:21:15', '2025-11-27 23:21:15'),
(80, 23, 'uploads/products/1764310999_69293fd737b46.jpg', '2025-11-27 23:23:19', '2025-11-27 23:23:19'),
(81, 23, 'uploads/products/1764310999_69293fd75e750.jpg', '2025-11-27 23:23:19', '2025-11-27 23:23:19'),
(82, 23, 'uploads/products/1764310999_69293fd788685.jpg', '2025-11-27 23:23:19', '2025-11-27 23:23:19'),
(83, 23, 'uploads/products/1764310999_69293fd7acec6.jpg', '2025-11-27 23:23:19', '2025-11-27 23:23:19'),
(84, 24, 'uploads/products/1764311138_69294062dc6f8.jpg', '2025-11-27 23:25:39', '2025-11-27 23:25:39'),
(85, 24, 'uploads/products/1764311139_6929406307ce7.jpg', '2025-11-27 23:25:39', '2025-11-27 23:25:39'),
(86, 24, 'uploads/products/1764311139_69294063340d1.jpg', '2025-11-27 23:25:39', '2025-11-27 23:25:39'),
(87, 24, 'uploads/products/1764311139_692940635cec9.jpg', '2025-11-27 23:25:39', '2025-11-27 23:25:39'),
(110, 32, 'uploads/products/1764659641_692e91b936dbb.jpg', '2025-12-02 00:14:01', '2025-12-02 00:14:01'),
(109, 32, 'uploads/products/1764659641_692e91b91102f.jpg', '2025-12-02 00:14:01', '2025-12-02 00:14:01'),
(108, 32, 'uploads/products/1764659640_692e91b8e2308.jpg', '2025-12-02 00:14:01', '2025-12-02 00:14:01'),
(107, 32, 'uploads/products/1764659638_692e91b6d40b4.jpg', '2025-12-02 00:14:00', '2025-12-02 00:14:00'),
(92, 26, 'uploads/products/1764311385_69294159040bd.jpg', '2025-11-27 23:29:45', '2025-11-27 23:29:45'),
(93, 26, 'uploads/products/1764311385_6929415923e05.jpg', '2025-11-27 23:29:45', '2025-11-27 23:29:45'),
(94, 26, 'uploads/products/1764311385_6929415949639.jpg', '2025-11-27 23:29:45', '2025-11-27 23:29:45'),
(95, 26, 'uploads/products/1764311385_6929415973acf.jpg', '2025-11-27 23:29:45', '2025-11-27 23:29:45'),
(96, 27, 'uploads/products/1764311629_6929424d57856.jpg', '2025-11-27 23:33:49', '2025-11-27 23:33:49'),
(97, 27, 'uploads/products/1764311629_6929424d7f06f.png', '2025-11-27 23:33:49', '2025-11-27 23:33:49'),
(98, 27, 'uploads/products/1764311629_6929424dd0b3d.jpg', '2025-11-27 23:33:49', '2025-11-27 23:33:49'),
(99, 27, 'uploads/products/1764311629_6929424df3aa1.jpg', '2025-11-27 23:33:50', '2025-11-27 23:33:50'),
(100, 28, 'uploads/products/1764312021_692943d5c5130.jpg', '2025-11-27 23:40:21', '2025-11-27 23:40:21'),
(101, 28, 'uploads/products/1764312021_692943d5e932b.jpg', '2025-11-27 23:40:22', '2025-11-27 23:40:22'),
(102, 28, 'uploads/products/1764312022_692943d610358.jpg', '2025-11-27 23:40:22', '2025-11-27 23:40:22'),
(103, 28, 'uploads/products/1764312022_692943d62cb59.jpg', '2025-11-27 23:40:22', '2025-11-27 23:40:22'),
(104, 29, 'uploads/products/1764312333_6929450dd6fe7.jpg', '2025-11-27 23:45:34', '2025-11-27 23:45:34'),
(105, 30, 'uploads/products/1764312398_6929454edc9ab.jpg', '2025-11-27 23:46:39', '2025-11-27 23:46:39'),
(111, 33, 'uploads/products/1764720398_692f7f0e047c7.jpg', '2025-12-02 17:06:40', '2025-12-02 17:06:40'),
(139, 41, 'uploads/products/1765601490_693cf0d2b9baf.jpg', '2025-12-12 21:51:30', '2025-12-12 21:51:30'),
(117, 39, 'uploads/products/1765201433_6936d619d83ee.jpg', '2025-12-08 06:43:54', '2025-12-08 06:43:54'),
(116, 38, 'uploads/products/1765200785_6936d3917332f.jpg', '2025-12-08 06:33:07', '2025-12-08 06:33:07'),
(141, 41, 'uploads/products/1765601491_693cf0d319656.jpg', '2025-12-12 21:51:31', '2025-12-12 21:51:31'),
(140, 41, 'uploads/products/1765601490_693cf0d2eb84b.jpg', '2025-12-12 21:51:31', '2025-12-12 21:51:31'),
(138, 40, 'uploads/products/1765423322_693a38dacfdea.jpg', '2025-12-10 20:22:03', '2025-12-10 20:22:03'),
(137, 40, 'uploads/products/1765423322_693a38daa5e41.jpg', '2025-12-10 20:22:02', '2025-12-10 20:22:02'),
(136, 40, 'uploads/products/1765423322_693a38da7f276.jpg', '2025-12-10 20:22:02', '2025-12-10 20:22:02'),
(135, 40, 'uploads/products/1765423322_693a38da4be62.jpg', '2025-12-10 20:22:02', '2025-12-10 20:22:02'),
(142, 41, 'uploads/products/1765601491_693cf0d3364cc.jpg', '2025-12-12 21:51:31', '2025-12-12 21:51:31'),
(143, 42, 'uploads/products/1765601717_693cf1b5b8fc6.jpg', '2025-12-12 21:55:17', '2025-12-12 21:55:17'),
(144, 42, 'uploads/products/1765601717_693cf1b5dec1c.jpg', '2025-12-12 21:55:18', '2025-12-12 21:55:18'),
(145, 42, 'uploads/products/1765601718_693cf1b6149bf.jpg', '2025-12-12 21:55:18', '2025-12-12 21:55:18'),
(146, 42, 'uploads/products/1765601718_693cf1b641a9f.jpg', '2025-12-12 21:55:18', '2025-12-12 21:55:18'),
(147, 43, 'uploads/products/1765601939_693cf2930e504.jpg', '2025-12-12 21:58:59', '2025-12-12 21:58:59'),
(148, 43, 'uploads/products/1765601939_693cf293363be.jpg', '2025-12-12 21:58:59', '2025-12-12 21:58:59'),
(149, 43, 'uploads/products/1765601939_693cf2935cf87.jpg', '2025-12-12 21:58:59', '2025-12-12 21:58:59'),
(150, 43, 'uploads/products/1765601939_693cf29380e22.jpg', '2025-12-12 21:58:59', '2025-12-12 21:58:59'),
(151, 44, 'uploads/products/1765602280_693cf3e8552cb.jpg', '2025-12-12 22:04:40', '2025-12-12 22:04:40'),
(152, 44, 'uploads/products/1765602280_693cf3e87cc20.jpg', '2025-12-12 22:04:40', '2025-12-12 22:04:40'),
(153, 44, 'uploads/products/1765602280_693cf3e89d5b8.jpg', '2025-12-12 22:04:40', '2025-12-12 22:04:40'),
(154, 44, 'uploads/products/1765602280_693cf3e8c7b37.jpg', '2025-12-12 22:04:40', '2025-12-12 22:04:40'),
(155, 45, 'uploads/products/1765602476_693cf4ac44911.jpg', '2025-12-12 22:07:56', '2025-12-12 22:07:56'),
(156, 45, 'uploads/products/1765602476_693cf4ac6834f.jpg', '2025-12-12 22:07:56', '2025-12-12 22:07:56'),
(157, 45, 'uploads/products/1765602476_693cf4ac89e3c.jpg', '2025-12-12 22:07:56', '2025-12-12 22:07:56'),
(158, 45, 'uploads/products/1765602476_693cf4acc02b1.jpg', '2025-12-12 22:07:56', '2025-12-12 22:07:56'),
(159, 46, 'uploads/products/1765602603_693cf52b833c2.jpg', '2025-12-12 22:10:03', '2025-12-12 22:10:03'),
(160, 46, 'uploads/products/1765602603_693cf52bb7dcf.jpg', '2025-12-12 22:10:03', '2025-12-12 22:10:03'),
(161, 46, 'uploads/products/1765602603_693cf52bdf19b.jpg', '2025-12-12 22:10:04', '2025-12-12 22:10:04'),
(162, 46, 'uploads/products/1765602604_693cf52c110fb.jpg', '2025-12-12 22:10:04', '2025-12-12 22:10:04'),
(163, 47, 'uploads/products/1765602744_693cf5b8be053.jpg', '2025-12-12 22:12:24', '2025-12-12 22:12:24'),
(164, 47, 'uploads/products/1765602744_693cf5b8e4e27.jpg', '2025-12-12 22:12:25', '2025-12-12 22:12:25'),
(165, 47, 'uploads/products/1765602745_693cf5b91c15b.jpg', '2025-12-12 22:12:25', '2025-12-12 22:12:25'),
(166, 47, 'uploads/products/1765602745_693cf5b945861.jpg', '2025-12-12 22:12:25', '2025-12-12 22:12:25'),
(167, 48, 'uploads/products/1765603525_693cf8c506fc1.jpg', '2025-12-12 22:25:25', '2025-12-12 22:25:25'),
(168, 48, 'uploads/products/1765603525_693cf8c54893e.jpg', '2025-12-12 22:25:25', '2025-12-12 22:25:25'),
(169, 48, 'uploads/products/1765603525_693cf8c570067.jpg', '2025-12-12 22:25:25', '2025-12-12 22:25:25'),
(170, 48, 'uploads/products/1765603525_693cf8c598925.jpg', '2025-12-12 22:25:25', '2025-12-12 22:25:25'),
(171, 49, 'uploads/products/1765608024_693d0a583677c.jpg', '2025-12-12 23:40:24', '2025-12-12 23:40:24'),
(172, 49, 'uploads/products/1765608024_693d0a5867502.jpg', '2025-12-12 23:40:24', '2025-12-12 23:40:24'),
(173, 49, 'uploads/products/1765608024_693d0a5891c36.jpg', '2025-12-12 23:40:24', '2025-12-12 23:40:24'),
(174, 49, 'uploads/products/1765608024_693d0a58b13c0.jpg', '2025-12-12 23:40:24', '2025-12-12 23:40:24'),
(175, 50, 'uploads/products/1765608184_693d0af80387b.jpg', '2025-12-12 23:43:04', '2025-12-12 23:43:04'),
(176, 50, 'uploads/products/1765608184_693d0af839368.jpg', '2025-12-12 23:43:04', '2025-12-12 23:43:04'),
(177, 50, 'uploads/products/1765608184_693d0af86371c.jpg', '2025-12-12 23:43:04', '2025-12-12 23:43:04'),
(178, 50, 'uploads/products/1765608184_693d0af890128.jpg', '2025-12-12 23:43:04', '2025-12-12 23:43:04'),
(179, 51, 'uploads/products/1765608381_693d0bbd914ef.jpg', '2025-12-12 23:46:21', '2025-12-12 23:46:21'),
(180, 51, 'uploads/products/1765608381_693d0bbdc924c.jpg', '2025-12-12 23:46:22', '2025-12-12 23:46:22'),
(181, 51, 'uploads/products/1765608382_693d0bbe0d219.jpg', '2025-12-12 23:46:22', '2025-12-12 23:46:22'),
(182, 51, 'uploads/products/1765608382_693d0bbe2fc4b.jpg', '2025-12-12 23:46:22', '2025-12-12 23:46:22'),
(183, 52, 'uploads/products/1765608513_693d0c4182997.jpg', '2025-12-12 23:48:33', '2025-12-12 23:48:33'),
(184, 52, 'uploads/products/1765608513_693d0c41b6d49.jpg', '2025-12-12 23:48:33', '2025-12-12 23:48:33'),
(185, 52, 'uploads/products/1765608513_693d0c41db518.jpg', '2025-12-12 23:48:34', '2025-12-12 23:48:34'),
(186, 52, 'uploads/products/1765608514_693d0c420fb2d.jpg', '2025-12-12 23:48:34', '2025-12-12 23:48:34'),
(187, 53, 'uploads/products/1765608675_693d0ce30db43.jpg', '2025-12-12 23:51:15', '2025-12-12 23:51:15'),
(188, 53, 'uploads/products/1765608675_693d0ce3365ab.jpg', '2025-12-12 23:51:15', '2025-12-12 23:51:15'),
(189, 53, 'uploads/products/1765608675_693d0ce35e4db.jpg', '2025-12-12 23:51:15', '2025-12-12 23:51:15'),
(190, 53, 'uploads/products/1765608675_693d0ce393e24.jpg', '2025-12-12 23:51:15', '2025-12-12 23:51:15'),
(191, 54, 'uploads/products/1765608916_693d0dd435be6.jpg', '2025-12-12 23:55:16', '2025-12-12 23:55:16'),
(192, 54, 'uploads/products/1765608916_693d0dd45d44c.jpg', '2025-12-12 23:55:16', '2025-12-12 23:55:16'),
(193, 54, 'uploads/products/1765608916_693d0dd489986.jpg', '2025-12-12 23:55:16', '2025-12-12 23:55:16'),
(194, 54, 'uploads/products/1765608916_693d0dd4b2634.jpg', '2025-12-12 23:55:16', '2025-12-12 23:55:16'),
(195, 55, 'uploads/products/1765609064_693d0e6851e0d.jpg', '2025-12-12 23:57:44', '2025-12-12 23:57:44'),
(196, 55, 'uploads/products/1765609064_693d0e6878ed7.jpg', '2025-12-12 23:57:44', '2025-12-12 23:57:44'),
(197, 55, 'uploads/products/1765609064_693d0e689641a.jpg', '2025-12-12 23:57:44', '2025-12-12 23:57:44'),
(198, 55, 'uploads/products/1765609064_693d0e68b15fa.jpg', '2025-12-12 23:57:44', '2025-12-12 23:57:44'),
(199, 56, 'uploads/products/1765609173_693d0ed5a3813.jpg', '2025-12-12 23:59:33', '2025-12-12 23:59:33'),
(200, 56, 'uploads/products/1765609173_693d0ed5cadcb.jpg', '2025-12-12 23:59:33', '2025-12-12 23:59:33'),
(201, 56, 'uploads/products/1765609173_693d0ed5f1b46.jpg', '2025-12-12 23:59:34', '2025-12-12 23:59:34'),
(202, 56, 'uploads/products/1765609174_693d0ed61e6bb.jpg', '2025-12-12 23:59:34', '2025-12-12 23:59:34'),
(203, 57, 'uploads/products/1765609322_693d0f6a69292.jpg', '2025-12-13 00:02:02', '2025-12-13 00:02:02'),
(204, 57, 'uploads/products/1765609322_693d0f6a98bd1.jpg', '2025-12-13 00:02:02', '2025-12-13 00:02:02'),
(205, 57, 'uploads/products/1765609322_693d0f6ac788c.jpg', '2025-12-13 00:02:02', '2025-12-13 00:02:02'),
(206, 57, 'uploads/products/1765609322_693d0f6ae8486.jpg', '2025-12-13 00:02:03', '2025-12-13 00:02:03'),
(207, 58, 'uploads/products/1765609710_693d10ee180a6.jpg', '2025-12-13 00:08:30', '2025-12-13 00:08:30'),
(208, 58, 'uploads/products/1765609710_693d10ee4d5a9.jpg', '2025-12-13 00:08:30', '2025-12-13 00:08:30'),
(209, 58, 'uploads/products/1765609710_693d10ee6bd17.jpg', '2025-12-13 00:08:30', '2025-12-13 00:08:30'),
(210, 58, 'uploads/products/1765609710_693d10ee8a788.jpg', '2025-12-13 00:08:30', '2025-12-13 00:08:30'),
(211, 59, 'uploads/products/1765610041_693d123955731.jpg', '2025-12-13 00:14:01', '2025-12-13 00:14:01'),
(212, 59, 'uploads/products/1765610041_693d123974305.jpg', '2025-12-13 00:14:01', '2025-12-13 00:14:01'),
(213, 59, 'uploads/products/1765610041_693d12399cd78.jpg', '2025-12-13 00:14:01', '2025-12-13 00:14:01'),
(214, 59, 'uploads/products/1765610041_693d1239bf1ae.jpg', '2025-12-13 00:14:01', '2025-12-13 00:14:01'),
(215, 60, 'uploads/products/1765610174_693d12be3e4b7.jpg', '2025-12-13 00:16:14', '2025-12-13 00:16:14'),
(216, 60, 'uploads/products/1765610174_693d12be687e2.jpg', '2025-12-13 00:16:14', '2025-12-13 00:16:14'),
(217, 60, 'uploads/products/1765610174_693d12be8bfd7.jpg', '2025-12-13 00:16:14', '2025-12-13 00:16:14'),
(218, 61, 'uploads/products/1765610325_693d1355f37ea.jpg', '2025-12-13 00:18:46', '2025-12-13 00:18:46'),
(219, 61, 'uploads/products/1765610326_693d13562a703.jpg', '2025-12-13 00:18:46', '2025-12-13 00:18:46'),
(220, 61, 'uploads/products/1765610326_693d135657701.jpg', '2025-12-13 00:18:46', '2025-12-13 00:18:46'),
(221, 61, 'uploads/products/1765610326_693d13567a552.jpg', '2025-12-13 00:18:46', '2025-12-13 00:18:46'),
(222, 62, 'uploads/products/1765610706_693d14d28e702.jpg', '2025-12-13 00:25:06', '2025-12-13 00:25:06'),
(223, 62, 'uploads/products/1765610706_693d14d2bcc00.jpg', '2025-12-13 00:25:06', '2025-12-13 00:25:06'),
(224, 62, 'uploads/products/1765610706_693d14d2db466.jpg', '2025-12-13 00:25:07', '2025-12-13 00:25:07'),
(225, 62, 'uploads/products/1765610707_693d14d30e336.jpg', '2025-12-13 00:25:07', '2025-12-13 00:25:07'),
(226, 63, 'uploads/products/1765610978_693d15e23b832.jpg', '2025-12-13 00:29:38', '2025-12-13 00:29:38'),
(227, 63, 'uploads/products/1765610978_693d15e265ec6.jpg', '2025-12-13 00:29:38', '2025-12-13 00:29:38'),
(228, 63, 'uploads/products/1765610978_693d15e293e37.jpg', '2025-12-13 00:29:38', '2025-12-13 00:29:38'),
(229, 63, 'uploads/products/1765610978_693d15e2b1ffd.jpg', '2025-12-13 00:29:38', '2025-12-13 00:29:38'),
(230, 64, 'uploads/products/1765612353_693d1b4155daf.jpg', '2025-12-13 00:52:33', '2025-12-13 00:52:33'),
(231, 64, 'uploads/products/1765612353_693d1b4186f46.jpg', '2025-12-13 00:52:33', '2025-12-13 00:52:33'),
(232, 64, 'uploads/products/1765612353_693d1b41af916.jpg', '2025-12-13 00:52:33', '2025-12-13 00:52:33'),
(233, 64, 'uploads/products/1765612353_693d1b41dbb67.jpg', '2025-12-13 00:52:34', '2025-12-13 00:52:34'),
(234, 65, 'uploads/products/1765613050_693d1dfa814a9.jpg', '2025-12-13 01:04:10', '2025-12-13 01:04:10'),
(235, 65, 'uploads/products/1765613050_693d1dfaab36b.jpg', '2025-12-13 01:04:10', '2025-12-13 01:04:10'),
(236, 65, 'uploads/products/1765613050_693d1dfac83d4.jpg', '2025-12-13 01:04:10', '2025-12-13 01:04:10'),
(237, 65, 'uploads/products/1765613051_693d1dfb004ee.jpg', '2025-12-13 01:04:11', '2025-12-13 01:04:11'),
(238, 66, 'uploads/products/1765613731_693d20a38956e.jpg', '2025-12-13 01:15:31', '2025-12-13 01:15:31'),
(239, 66, 'uploads/products/1765613731_693d20a3bb0cd.jpg', '2025-12-13 01:15:31', '2025-12-13 01:15:31'),
(240, 66, 'uploads/products/1765613731_693d20a3e60bc.jpg', '2025-12-13 01:15:32', '2025-12-13 01:15:32'),
(241, 66, 'uploads/products/1765613732_693d20a427fd6.jpg', '2025-12-13 01:15:32', '2025-12-13 01:15:32'),
(242, 67, 'uploads/products/1765613812_693d20f41a684.jpg', '2025-12-13 01:16:52', '2025-12-13 01:16:52'),
(243, 67, 'uploads/products/1765613812_693d20f440ae4.jpg', '2025-12-13 01:16:52', '2025-12-13 01:16:52'),
(244, 67, 'uploads/products/1765613812_693d20f469158.jpg', '2025-12-13 01:16:52', '2025-12-13 01:16:52'),
(245, 67, 'uploads/products/1765613812_693d20f48fb4f.jpg', '2025-12-13 01:16:52', '2025-12-13 01:16:52'),
(246, 68, 'uploads/products/1765613863_693d212747a42.jpg', '2025-12-13 01:17:43', '2025-12-13 01:17:43'),
(247, 68, 'uploads/products/1765613863_693d21277321c.jpg', '2025-12-13 01:17:43', '2025-12-13 01:17:43'),
(248, 68, 'uploads/products/1765613863_693d21279e646.jpg', '2025-12-13 01:17:43', '2025-12-13 01:17:43'),
(249, 68, 'uploads/products/1765613863_693d2127cb511.jpg', '2025-12-13 01:17:44', '2025-12-13 01:17:44'),
(250, 69, 'uploads/products/1765614201_693d2279c82e5.jpg', '2025-12-13 01:23:21', '2025-12-13 01:23:21'),
(251, 69, 'uploads/products/1765614201_693d2279eec2e.jpg', '2025-12-13 01:23:22', '2025-12-13 01:23:22'),
(252, 69, 'uploads/products/1765614202_693d227a1fa44.jpg', '2025-12-13 01:23:22', '2025-12-13 01:23:22'),
(253, 69, 'uploads/products/1765614202_693d227a481f1.jpg', '2025-12-13 01:23:22', '2025-12-13 01:23:22'),
(254, 70, 'uploads/products/1765614469_693d2385e0470.jpg', '2025-12-13 01:27:50', '2025-12-13 01:27:50'),
(255, 70, 'uploads/products/1765614470_693d238618ec5.jpg', '2025-12-13 01:27:50', '2025-12-13 01:27:50'),
(256, 70, 'uploads/products/1765614470_693d23863afb6.jpg', '2025-12-13 01:27:50', '2025-12-13 01:27:50'),
(257, 70, 'uploads/products/1765614470_693d23865e561.jpg', '2025-12-13 01:27:50', '2025-12-13 01:27:50'),
(258, 71, 'uploads/products/1765615058_693d25d243f75.jpg', '2025-12-13 01:37:38', '2025-12-13 01:37:38'),
(259, 71, 'uploads/products/1765615058_693d25d26fec9.jpg', '2025-12-13 01:37:38', '2025-12-13 01:37:38'),
(260, 71, 'uploads/products/1765615058_693d25d29099d.jpg', '2025-12-13 01:37:38', '2025-12-13 01:37:38'),
(261, 71, 'uploads/products/1765615058_693d25d2b9f9d.jpg', '2025-12-13 01:37:38', '2025-12-13 01:37:38'),
(265, 75, 'uploads/products/1766916634_6951021a5e6b5.jpg', '2025-12-28 03:10:35', '2025-12-28 03:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_recipes`
--

DROP TABLE IF EXISTS `product_recipes`;
CREATE TABLE IF NOT EXISTS `product_recipes` (
  `recipe_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `product_recipes_recipe_id_foreign` (`recipe_id`),
  KEY `product_recipes_product_id_foreign` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_recipes`
--

INSERT INTO `product_recipes` (`recipe_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(8, 38, 1, NULL, NULL),
(8, 39, 1, NULL, NULL),
(8, 19, 1, NULL, NULL),
(8, 1, 1, NULL, NULL),
(9, 28, 1, NULL, NULL),
(9, 62, 1, NULL, NULL),
(9, 2, 1, NULL, NULL),
(9, 51, 1, NULL, NULL),
(9, 24, 1, NULL, NULL),
(9, 58, 1, NULL, NULL),
(9, 60, 1, NULL, NULL),
(9, 63, 1, NULL, NULL),
(7, 40, 1, NULL, NULL),
(7, 11, 1, NULL, NULL),
(7, 38, 1, NULL, NULL),
(7, 39, 1, NULL, NULL),
(9, 59, 1, NULL, NULL),
(9, 39, 1, NULL, NULL),
(10, 18, 1, NULL, NULL),
(10, 19, 1, NULL, NULL),
(10, 38, 1, NULL, NULL),
(10, 64, 1, NULL, NULL),
(11, 41, 1, NULL, NULL),
(11, 19, 1, NULL, NULL),
(11, 38, 1, NULL, NULL),
(12, 42, 1, NULL, NULL),
(12, 11, 1, NULL, NULL),
(12, 53, 1, NULL, NULL),
(12, 38, 1, NULL, NULL),
(12, 64, 1, NULL, NULL),
(13, 65, 1, NULL, NULL),
(13, 19, 1, NULL, NULL),
(13, 44, 1, NULL, NULL),
(13, 38, 1, NULL, NULL),
(13, 64, 1, NULL, NULL),
(13, 32, 1, NULL, NULL),
(19, 38, 1, NULL, NULL),
(19, 32, 1, NULL, NULL),
(19, 67, 1, NULL, NULL),
(19, 68, 1, NULL, NULL),
(19, 66, 1, NULL, NULL),
(19, 43, 1, NULL, NULL),
(19, 44, 1, NULL, NULL),
(15, 51, 1, NULL, NULL),
(15, 52, 1, NULL, NULL),
(15, 63, 1, NULL, NULL),
(15, 38, 1, NULL, NULL),
(15, 69, 1, NULL, NULL),
(16, 70, 1, NULL, NULL),
(16, 19, 1, NULL, NULL),
(16, 38, 1, NULL, NULL),
(17, 6, 1, NULL, NULL),
(17, 19, 1, NULL, NULL),
(17, 38, 1, NULL, NULL),
(18, 71, 1, NULL, NULL),
(18, 53, 1, NULL, NULL),
(18, 38, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE IF NOT EXISTS `recipes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `recipes_name_unique` (`name`),
  UNIQUE KEY `recipes_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `slug`, `description`, `image`) VALUES
(8, 'Canh bí đỏ thịt băm', 'canh-bi-do-thit-bam-1765599650', 'Rất ngon và dễ nấu', 'uploads/recipes/1765599650_693ce9a259f16.jpg'),
(9, 'Canh chua cá', 'canh-chua-ca-1765611180', 'Món canh ngon nhà nhà đều thích', 'uploads/recipes/1765611180_693d16ac8a0d4.jpg'),
(10, 'Canh khổ qua', 'canh-kho-qua-1765612457', 'Món canh không thể thiếu trong ngày tết', 'uploads/recipes/1765612457_693d1ba9800d0.jpg'),
(11, 'Canh rau tần ô thịt bằm', 'canh-rau-tan-o-thit-bam-1765612655', 'Món ăn giải nhiệt', 'uploads/recipes/1765612655_693d1c6f289e7.jpg'),
(7, 'Canh khoai mỡ', 'canh-khoai-mo-1765599413', 'Rất ngon mà lại còn dễ nấu', 'uploads/recipes/1765599413_693ce8b523ad1.jpg'),
(12, 'Canh bầu nấu tôm', 'canh-bau-nau-tom-1765612839', 'Món canh ngon ngọt dễ ăn', 'uploads/recipes/1765612839_693d1d270ad9f.jpg'),
(13, 'Canh bắp cải', 'canh-bap-cai-1765613181', 'Món canh giải nhiệt', 'uploads/recipes/1765613180_693d1e7cdf7e6.jpg'),
(19, 'Canh súp', 'canh-sup-1765615380', 'Món canh ngon không thể thiếu', 'uploads/recipes/1765615380_693d271459b40.jpg'),
(15, 'Canh cá nấu ngót', 'canh-ca-nau-ngot-1765614320', 'Món canh ngon dễ làm', 'uploads/recipes/1765614320_693d22f0cbe6a.jpg'),
(16, 'Canh cải ngọt thịt băm', 'canh-cai-ngot-thit-bam-1765614539', 'Món ngon dễ làm dễ ăn', 'uploads/recipes/1765614539_693d23cb82908.jpg'),
(17, 'Canh cải xanh thịt bằm', 'canh-cai-xanh-thit-bam-1765614693', 'Món canh ngon dễ ăn dễ nấu', 'uploads/recipes/1765614693_693d24658b8bf.jpg'),
(18, 'Canh tôm rau ngót', 'canh-tom-rau-ngot-1765615127', 'Món canh ngon dễ ăn', 'uploads/recipes/1765615127_693d2617a4d2b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 5, 18, 5, 'Sản phẩm rất tươi nói chung rất thích', '2025-12-01 06:28:20', '2025-12-01 06:28:20'),
(9, 8, 39, 4, 'sản phẩm rất tươi', '2025-12-09 16:08:13', '2025-12-09 16:08:13'),
(8, 4, 11, 5, 'a', '2025-12-09 06:14:52', '2025-12-09 06:14:52'),
(7, 4, 14, 5, 'Sản phẩm như mô tả', '2025-12-07 21:08:46', '2025-12-07 21:08:46'),
(10, 4, 40, 5, 'oke', '2026-01-06 01:18:57', '2026-01-06 01:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-11-23 11:19:31', '2025-11-23 11:19:31'),
(2, 'staff', '2025-11-23 11:19:31', '2025-11-23 11:19:31'),
(3, 'customer', '2025-11-23 11:19:31', '2025-11-23 11:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` bigint UNSIGNED NOT NULL,
  `permission_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `role_permissions_role_id_foreign` (`role_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(1, 3, NULL, NULL),
(1, 4, NULL, NULL),
(1, 5, NULL, NULL),
(2, 2, NULL, NULL),
(2, 5, NULL, NULL),
(2, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

DROP TABLE IF EXISTS `shipping_addresses`;
CREATE TABLE IF NOT EXISTS `shipping_addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_addresses_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `full_name`, `phone`, `address`, `city`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 5, 'Nhà má 6', '0888666999', '127 đường Mễ Cốc , phường 15 quận 8', 'Hồ Chí Minh', 0, '2025-11-30 23:01:28', '2025-12-02 19:07:22', NULL),
(10, 4, 'a', '0999888777', 'abcdef', 'Hồ Chí Minh', 0, '2025-11-19 19:00:38', '2025-12-20 00:43:02', '2025-12-20 00:43:02'),
(9, 2, 'ChillGuy', '0789456126', 'C7C Cao Lỗ', 'Thành Phố Hồ Chí Minh', 1, '2025-11-16 01:36:35', '2025-11-17 21:29:25', NULL),
(5, 2, 'a di đà phật', '0999888777', 'Tây phương cực lạc', 'Tây Phương Tịnh Độ', 0, '2025-11-15 23:57:26', '2025-11-17 21:29:25', NULL),
(8, 2, 'người lạ ơi', '0987654123', '120/20', 'Đà Lạt', 0, '2025-11-16 01:25:36', '2025-11-17 21:29:25', NULL),
(14, 5, 'aaaa', '0999888777', '193 Phạm Thế Hiển P.05, , Quận 8, Thành phố Hồ Chí Minh, Việt Nam.', 'Hồ Chí Minh', 0, '2025-11-30 01:01:08', '2025-12-02 19:07:22', NULL),
(21, 5, 'Nhà bà ngoại', '0123456789', '1230 Phạm Thế Hiển , Quận 8', 'Hồ Chí Minh', 0, '2025-11-30 23:28:14', '2025-12-01 00:15:18', '2025-12-01 00:15:18'),
(23, 5, 'Nhà má 2', '0123456789', 'cầu Tạ Quang Bửu', 'Hồ Chí Minh', 1, '2025-12-02 19:07:22', '2025-12-02 19:07:22', NULL),
(24, 4, 'Nhà má tư', '0741852963', 'qua cầu Tạ Quang Bửu', 'Hồ Chí Minh', 0, '2025-12-04 06:24:39', '2025-12-20 00:42:56', '2025-12-20 00:42:56'),
(25, 8, 'nhà Duy', '0932847323', 'Phường 15 Quận 8', 'Hồ Chí Minh', 1, '2025-12-09 15:53:34', '2025-12-09 15:53:56', NULL),
(26, 4, 'Trần Thái Duy', '0909090909', '120 QUang Trung, Gò Vấp', 'Hồ Chí Minh', 0, '2025-12-18 19:19:00', '2025-12-20 02:32:53', '2025-12-20 02:32:53'),
(27, 4, 'q', '1234567890', 'q, Thị trấn An Phú, Huyện An Phú', 'Tỉnh An Giang', 0, '2025-12-20 02:30:32', '2025-12-20 02:32:58', '2025-12-20 02:32:58'),
(28, 4, 'q', '1234567890', 'q, Thị trấn An Phú, Huyện An Phú', 'Tỉnh An Giang', 0, '2025-12-20 02:30:32', '2025-12-20 02:33:02', '2025-12-20 02:33:02'),
(29, 4, 'KhánhDuongCuong', '0987654321', '127, Phường 15, Quận 8', 'Thành phố Hồ Chí Minh', 0, '2025-12-20 02:31:36', '2025-12-20 03:29:43', '2025-12-20 03:29:43'),
(30, 4, 'Nguyễn Văn A', '0987654321', '127, Phường 10, Quận 8', 'Thành phố Hồ Chí Minh', 0, '2025-12-20 02:33:43', '2025-12-20 03:29:49', '2025-12-20 03:29:49'),
(32, 4, 'Khanh', '0325987456', '123, Phường Mỹ Xuyên, Thành phố Long Xuyên', 'Tỉnh An Giang', 0, '2025-12-20 03:17:47', '2025-12-20 03:30:29', NULL),
(31, 4, 'Địa chỉ mới', '0932888888', '127/A, Phường 1, Thành phố Cà Mau', 'Tỉnh Cà Mau', 0, '2025-12-20 02:41:41', '2025-12-20 03:29:36', '2025-12-20 03:29:36'),
(33, 4, 'Trần Thái Duy', '0987654321', '127/17A Mễ Cốc, Phường 15, Quận 8', 'Thành phố Hồ Chí Minh', 1, '2025-12-20 03:30:29', '2025-12-20 03:30:29', NULL),
(34, 4, 'Cuong', '0258741963', '127, Phường 8, Thành phố Bến Tre', 'Tỉnh Bến Tre', 0, '2025-12-20 03:53:59', '2025-12-20 03:53:59', NULL),
(35, 4, 'SOnDuong', '0124589746', '150, Phường Nghĩa Đô, Quận Cầu Giấy', 'Thành phố Hà Nội', 0, '2025-12-20 04:00:04', '2025-12-20 04:00:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','active','banned','delete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `role_id` bigint UNSIGNED NOT NULL,
  `activation_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `phone_number`, `avatar`, `address`, `role_id`, `activation_token`, `google_id`, `created_at`, `updated_at`) VALUES
(2, 'Trần Thái Duy aka', 'mcttduyyyy@gmail.com', '2025-11-11 08:00:51', '$2y$12$e.4bWkBMaWdOxFDY.6B.KeRKtfITcXaxLZDFnDIw.Dz6MnG7CYkk6', 'active', '0999888778', NULL, 'Thành Phố Hồ Chí Minh - Việt Nam', 2, NULL, NULL, '2025-11-11 07:57:14', '2025-12-02 16:11:07'),
(4, 'duytran', 'cunglamcttduyaka@gmail.com', '2025-11-14 20:13:06', '$2y$12$vazmgkTxKFVPIOsEjY364O5KsKyVLWp3j09CEVi8PfC9zGBmhWVEa', 'active', '0932847323', NULL, 'Việt Nam', 3, NULL, NULL, '2025-11-14 20:10:21', '2026-01-10 22:17:17'),
(5, 'khách guộc jetjet', 'mcttduy@gmail.com', '2025-11-21 20:06:18', '$2y$12$29DQWKTwHHxnuLI2Cm0CBO2qdw4ZDWGDguZw6UX1f7HzheeUYEaaK', 'active', '0888999666', NULL, 'Thành Phố Hồ Chí Minh - Việt Nam', 3, NULL, NULL, '2025-11-21 20:04:03', '2026-01-02 06:53:12'),
(6, 'Admin Duy', 'admin@example.com', NULL, '$2y$12$zsVkF.oP2oucIC.bbJiIoOoe/BIaYy2/1DV6WV.bf0JDDUjLXpu0a', 'active', '0999686868', 'uploads/users/1765075631_6934eaafb466d.jpg', 'Quận 8, TP.HCM, Vietnam', 1, NULL, NULL, '2025-11-23 04:37:22', '2025-12-06 19:47:11'),
(7, 'Staff User', 'staff@example.com', NULL, '$2y$12$rwTgQYN5RRveZrBovaJyfuJSx/y.Rvq5lFST6C/5dwaIyT1tb4qRK', 'active', '0888888888', 'uploads/users/1766888782_6950954ec0ef1.png', 'Da Nang, Vietnam', 2, NULL, NULL, '2025-11-23 04:37:22', '2025-12-27 19:26:23'),
(8, 'Duy làm luận văn', 'duytran07072003@gmail.com', '2025-12-09 01:13:42', '$2y$12$oUTvrkGhKwYW/dIAsCc46u45qcUErEM158k.V.ja5CEFxtu9eE6Yq', 'active', '0932847323', NULL, 'Thành Phố Hồ Chí Minh - Việt Nam', 3, NULL, NULL, '2025-12-09 01:13:06', '2025-12-11 21:21:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
