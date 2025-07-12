-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2025 pada 15.33
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_medisya`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'EtlvF', '2019-08-26 10:52:54', '2019-08-26 10:52:54'),
(2, 'LItQO', '2019-08-26 11:40:50', '2019-08-26 11:40:50'),
(4, 'uMbxb', '2019-08-27 04:08:01', '2019-08-27 04:08:01'),
(8, 'oNgNI', '2019-08-27 12:37:44', '2019-08-27 12:37:44'),
(9, 'YFgri', '2019-08-27 13:06:54', '2019-08-27 13:06:54'),
(10, 'bLMbv', '2019-08-27 13:12:47', '2019-08-27 13:12:47'),
(12, 'shguO', '2025-04-29 23:31:19', '2025-04-29 23:31:19'),
(13, 'cBwUd', '2025-05-01 23:58:06', '2025-05-01 23:58:06'),
(14, '3', NULL, NULL),
(15, '2', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart_products`
--

CREATE TABLE `cart_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(250) DEFAULT NULL COMMENT 'last edited category name',
  `name` varchar(250) DEFAULT NULL COMMENT 'last edited product name',
  `description` text DEFAULT NULL COMMENT 'last edited product description',
  `price` float DEFAULT NULL COMMENT 'last edited price',
  `images` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `cart_products`
--

INSERT INTO `cart_products` (`id`, `cart_id`, `product_id`, `category_id`, `category_name`, `name`, `description`, `price`, `images`, `quantity`, `created_at`, `updated_at`) VALUES
(35, 14, 1, 1, '', 'Infrared Thermometer', '', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 2, '2025-05-03 22:56:47', NULL),
(36, 15, 1, 1, '', 'Infrared Thermometer', '', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 2, '2025-05-03 23:03:42', NULL),
(102, 4, 8, 3, NULL, 'Medical Face Mask', 'Masker medis sekali pakai', 32000, 'http://localhost/medisya/assets/products/medical-mask-2.jpg', 1, '2025-05-05 16:58:39', NULL),
(103, 4, 1, 1, NULL, 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-05 16:58:44', NULL),
(114, 3, 1, 1, NULL, 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-06 06:53:28', NULL),
(151, 2, 1, 2, NULL, 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 09:16:39', NULL),
(152, 2, 3, 4, NULL, 'Face Shield', 'Pelindung wajah dari kuman/cipratan', 25000, 'http://localhost/medisya/assets/products/face-shield-2.jpg', 1, '2025-05-07 09:16:43', NULL),
(156, 7, 1, 2, NULL, 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-07-12 11:41:44', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Diagnostic Tools', 'Alat-alat yang digunakan untuk pemantauan dan pemeriksaan kesehatan.', '2019-08-25 19:54:39', '2019-08-27 13:07:47'),
(3, 'Therapy & Rehabilitation', 'Alat-alat untuk mendukung terapi fisik dan pemulihan pasien.\r\n', '2019-08-25 19:54:51', '2019-08-25 19:54:51'),
(4, 'Personal Protective Equipment', 'Peralatan untuk melindungi tenaga medis dan pengguna.\r\n', '2019-08-26 05:55:44', '2019-08-26 05:55:44'),
(5, ' Home Health Essentials', 'Alat-alat untuk pemantauan kesehatan sehari-hari di rumah\r\n', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 7, 2, 5, 'sangat bermanfaat', '2025-05-05 11:53:49'),
(2, 2, 2, 3, 'bagus, mudah digunakan', '2025-05-05 20:13:04'),
(3, 8, 7, 5, 'sangat mudah digunakan', '2025-05-06 02:47:02'),
(4, 8, 6, 4, 'bagus, mungkin beli lagi', '2025-05-06 02:47:19'),
(5, 8, 4, 3, 'bau agak menyengat', '2025-05-06 02:47:32'),
(6, 8, 2, 5, 'sangat bermanfaat', '2025-05-06 19:12:57'),
(7, 8, 3, 5, 'melindungi dengan baik', '2025-05-06 19:13:09'),
(8, 8, 5, 5, 'kualitas bagus, teruskan', '2025-05-06 19:13:21'),
(9, 8, 1, 5, 'berfungsi dengan baik', '2025-05-06 19:21:24'),
(10, 9, 13, 4, 'berfungsi dengan baik', '2025-05-07 02:00:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(8) DEFAULT NULL,
  `address` text DEFAULT NULL COMMENT 'User Order Address',
  `total_price` float UNSIGNED DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `paypal_id` varchar(100) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Processing','Shipped','Completed','Canceled') DEFAULT 'Pending',
  `va` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address`, `total_price`, `order_date`, `phone`, `bank_name`, `paypal_id`, `payment_type`, `status`, `va`) VALUES
(37, '3', 'Rungkut, Surabaya', 368500, '2025-05-04 13:52:51', '086357538', 'BCA', '2', 'prepaid', 'Completed', ''),
(39, '2', 'Wonorejo, Rungkut, Surabaya', 675400, '2025-05-04 14:54:35', '0838632818', 'BCA', '2', 'prepaid', 'Completed', ''),
(40, '2', 'Wonorejo, Rungkut, Surabaya', 132000, '2025-05-04 14:57:52', '0838632818', 'BCA', '2', 'prepaid', 'Canceled', ''),
(41, '7', 'Pondok Gede, Bekasi', 172700, '2025-05-04 15:03:15', '0838632818', 'BCA', '', 'prepaid', 'Shipped', ''),
(42, '7', 'Pondok Gede, Bekasi', 214500, '2025-05-04 15:52:58', '0320476345734', 'BCA', '1', 'prepaid', 'Canceled', ''),
(43, '7', 'Pondok Gede, Bekasi', 368500, '2025-05-04 15:53:32', '0873865484390', 'BCA', '1', 'prepaid', 'Completed', ''),
(44, '2', 'Wonorejo, Rungkut, Surabaya', 367000, '2025-05-05 13:39:43', '0873865484390', 'BCA', '1', 'E-Wallet', 'Pending', ''),
(45, '7', 'Pondok Gede, Bekasi', 110000, '2025-05-05 15:57:38', '0873865484390', 'BCA', '1', 'Transfer Bank', 'Completed', ''),
(46, '7', 'Pondok Gede, Bekasi', 0, '2025-05-05 15:58:30', '0873865484390', 'BCA', '1', 'Transfer Bank', 'Pending', ''),
(47, '2', 'Wonorejo, Rungkut, Surabaya', 60000, '2025-05-05 15:59:13', '0873865484390', 'BCA', '1', 'Transfer Bank', 'Shipped', ''),
(48, '2', 'Wonorejo, Rungkut, Surabaya', 231000, '2025-05-05 16:05:33', '0873865484390', 'BCA', '1', 'prepaid', 'Canceled', ''),
(49, '7', 'Pondok Gede, Bekasi', 709500, '2025-05-05 18:24:41', '0873865484390', 'BCA', '1', 'prepaid', 'Canceled', ''),
(50, '4', 'Depok, Jakarta Pusat', 27500, '2025-05-05 18:41:22', '083863281878', 'BNI', '2', 'prepaid', 'Canceled', ''),
(51, '2', 'Wonorejo, Rungkut, Surabaya', 110000, '2025-05-06 03:11:31', '083863281878', 'BNI', '2', 'prepaid', 'Completed', ''),
(52, '3', 'Rungkut, Surabaya', 148500, '2025-05-06 04:04:13', '0838632818', 'BCA', '1', 'prepaid', 'Pending', ''),
(53, '3', 'Rungkut, Surabaya', 0, '2025-05-06 04:16:40', '0838632818', 'BCA', '1', 'prepaid', 'Pending', ''),
(54, '3', 'Rungkut, Surabaya', 0, '2025-05-06 04:17:28', '0838632818', 'BCA', '1', 'prepaid', 'Pending', ''),
(55, '2', 'Wonorejo, Rungkut, Surabaya', 27500, '2025-05-06 04:31:27', '083863281878', 'BNI', '123', 'prepaid', 'Pending', ''),
(56, '2', 'Wonorejo, Rungkut, Surabaya', 66000, '2025-05-06 04:48:56', '083863281878', 'BCA', '1234', 'prepaid', 'Pending', ''),
(57, '8', 'surabaya', 66000, '2025-05-06 05:13:55', '018781', 'BCA', '123', 'prepaid', 'Pending', ''),
(58, '8', 'surabaya', 348700, '2025-05-06 05:31:55', '08926135623426', 'BNI', '2', 'prepaid', 'Completed', ''),
(59, '8', 'surabaya', 0, '2025-05-06 05:36:15', '08926135623426', 'BNI', '2', 'prepaid', 'Canceled', ''),
(60, '8', 'surabaya', 148500, '2025-05-06 05:36:46', '0838632818', 'BCA', '1234', 'prepaid', 'Completed', ''),
(61, '8', 'surabaya', 181500, '2025-05-06 09:45:08', '0873865484390', 'BCA', '1', 'prepaid', 'Completed', ''),
(62, '8', 'surabaya', 508200, '2025-05-06 19:49:25', '087654631435', '', '1', 'prepaid', 'Canceled', ''),
(63, '8', 'Wonorejo, Rungkut, Surabaya', 425000, '2025-05-07 02:10:06', '085704123017', 'BCA', '1', 'prepaid', 'Completed', ''),
(64, '8', 'Wonorejo, Rungkut, Surabaya', 135000, '2025-05-07 02:14:02', '085704123017', '', '12', 'postpaid', 'Completed', ''),
(65, '8', 'Wonorejo, Rungkut, Surabaya', 107000, '2025-05-07 02:22:15', '085704123017', 'BCA', '12', 'prepaid', 'Canceled', ''),
(66, '8', 'Wonorejo, Rungkut, Surabaya', 135000, '2025-05-07 02:25:07', '085704123017', 'BNI', '', 'prepaid', 'Completed', ''),
(67, '8', 'Wonorejo, Rungkut, Surabaya', 0, '2025-05-07 02:26:59', '085704123017', 'BNI', '', 'prepaid', 'Pending', ''),
(68, '8', 'Wonorejo, Rungkut, Surabaya', 135000, '2025-05-07 02:39:48', '0873865484390', 'BCA', '', 'prepaid', 'Canceled', ''),
(69, '8', 'Wonorejo, Rungkut, Surabaya', 40000, '2025-05-07 02:40:21', '0873865484390', '', '', 'postpaid', 'Completed', ''),
(70, '8', 'Wonorejo, Rungkut, Surabaya', 60000, '2025-05-07 02:41:55', '085704123017', 'BCA', '', 'prepaid', 'Completed', ''),
(71, '8', 'Wonorejo, Rungkut, Surabaya', 0, '2025-05-07 02:42:12', '085704123017', 'BCA', '', 'postpaid', 'Pending', ''),
(72, '9', 'Rungkut, Surabaya', 67000, '2025-05-07 08:57:21', '085704123017', '', '', 'postpaid', 'Pending', ''),
(73, '9', 'Rungkut, Surabaya', 0, '2025-05-07 08:57:57', '085704123017', 'Shopeepay', '', 'prepaid', 'Canceled', ''),
(74, '9', 'Rungkut, Surabaya', 134000, '2025-05-07 08:59:32', '08154671712', 'Mandiri', '', 'prepaid', 'Completed', ''),
(75, '9', 'Rungkut, Surabaya', 67000, '2025-05-07 09:05:31', '085704123017', '', '', 'postpaid', 'Completed', ''),
(76, '9', 'Rungkut, Surabaya', 120000, '2025-05-07 09:11:56', '085704123017', '', '', 'postpaid', 'Completed', ''),
(77, '8', 'Wonorejo, Rungkut, Surabaya', 60000, '2025-05-07 09:14:05', '085704123017', '', '', 'postpaid', 'Completed', ''),
(78, '9', 'Rungkut, Surabaya', 40000, '2025-05-07 09:20:54', '085704123017', 'Shopeepay', '', 'prepaid', 'Completed', ''),
(79, '11', 'Rungkut', 385000, '2025-05-07 09:36:30', '0873865484390', 'BCA', '', 'prepaid', 'Pending', ''),
(80, '11', 'Rungkut', 445000, '2025-05-07 09:39:26', '0873865484390', 'BCA', NULL, 'prepaid', 'Completed', ''),
(81, '11', 'Rungkut', 335000, '2025-05-07 09:45:06', '085704873099', 'BCA', NULL, 'prepaid', 'Shipped', ''),
(82, '11', 'Rungkut', 60000, '2025-05-07 10:12:39', '0873865484390', 'BCA', NULL, 'prepaid', 'Pending', ''),
(83, '11', 'Rungkut', 0, '2025-05-07 10:14:01', '0873865484390', 'BCA', NULL, 'prepaid', 'Pending', ''),
(84, '11', 'Rungkut', 0, '2025-05-07 10:14:07', '0873865484390', 'BCA', NULL, 'prepaid', 'Pending', ''),
(85, '11', 'Rungkut', 0, '2025-05-07 10:21:37', '0873865484334', 'BCA', NULL, 'prepaid', 'Pending', ''),
(86, '11', 'Rungkut', 0, '2025-05-07 10:24:02', '0873865484334', 'BCA', NULL, 'prepaid', 'Pending', ''),
(87, '11', 'Rungkut', 0, '2025-05-07 10:26:24', '0867345476', 'BCA', NULL, 'prepaid', 'Pending', ''),
(88, '11', 'Rungkut', 0, '2025-05-07 10:28:39', '0867345476', 'BCA', NULL, 'prepaid', 'Pending', ''),
(89, '11', 'Rungkut', 135000, '2025-05-07 10:29:09', '0873865484334', 'BCA', NULL, 'prepaid', 'Pending', ''),
(90, '11', 'Rungkut', 60000, '2025-05-07 10:48:04', '0873865484334', 'bni', NULL, 'prepaid', 'Pending', ''),
(91, '11', 'Rungkut', 0, '2025-05-07 10:50:23', '0873865484334', 'bni', NULL, 'prepaid', 'Pending', ''),
(92, '11', 'Rungkut', 0, '2025-05-07 10:51:44', '0873865484334', 'bni', NULL, 'prepaid', 'Pending', ''),
(93, '11', 'Rungkut', 0, '2025-05-07 10:52:39', '0873865484334', 'bni', NULL, 'prepaid', 'Pending', ''),
(94, '11', 'Rungkut', 0, '2025-05-07 11:00:24', '0873865484334', 'bni', NULL, 'prepaid', 'Pending', '87567456'),
(95, '2', 'Wonorejo, Rungkut, Surabaya', 40000, '2025-05-07 11:14:01', '0873865484334', 'BCA', NULL, 'prepaid', 'Pending', '87567456'),
(96, '11', 'Rungkut', 100000, '2025-05-07 11:35:18', '085704873099', 'BCA', NULL, 'prepaid', 'Pending', '074264684'),
(97, '11', 'Rungkut', 0, '2025-05-07 11:43:13', '085704873099', 'BCA', NULL, 'postpaid', 'Pending', ''),
(98, '11', 'Rungkut', 0, '2025-05-07 11:45:58', '085704873099', 'BCA', NULL, 'prepaid', 'Pending', ''),
(99, '11', 'Rungkut', 0, '2025-05-07 11:46:09', '085704873099', 'BCA', NULL, 'prepaid', 'Pending', ''),
(100, '11', 'Rungkut', 0, '2025-05-07 11:46:21', '085704873099', 'BCA', NULL, 'postpaid', 'Pending', ''),
(101, '11', 'Rungkut', 0, '2025-05-07 11:48:32', '085704873099', 'BCA', NULL, 'prepaid', 'Pending', ''),
(102, '11', 'Rungkut', 0, '2025-05-07 11:53:03', '085704873099', 'BCA', NULL, 'postpaid', 'Pending', ''),
(103, '11', 'Rungkut', 135000, '2025-05-07 11:54:42', '085704873099', '', NULL, 'postpaid', 'Pending', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_products`
--

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(250) DEFAULT NULL COMMENT 'last edited category name',
  `name` varchar(250) DEFAULT NULL COMMENT 'last edited product name',
  `description` text DEFAULT NULL COMMENT 'last edited product description',
  `price` float DEFAULT NULL COMMENT 'last edited price',
  `images` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data untuk tabel `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `category_id`, `category_name`, `name`, `description`, `price`, `images`, `quantity`, `created_at`, `updated_at`) VALUES
(19, 21, 4, 3, 'Personal Protective Equipment', 'Hand Sanitizer', '', 40000, '[\"http://localhost/medisya/assets/products/hand-sanitizer-2.jpg\"]', 1, '2025-05-04 01:05:07', '2025-05-04 01:05:07'),
(20, 21, 5, 3, 'Personal Protective Equipment', 'Hazmat Suit / APD', '', 200000, '[\"http://localhost/medisya/assets/products/hazmat-suit-2.jpg\"]', 1, '2025-05-04 01:05:07', '2025-05-04 01:05:07'),
(21, 22, 7, 1, 'Diagnostics', 'Nebulizer', '', 75000, '[\"http://localhost/medisya/assets/products/nebulizer-0.jpg\"]', 1, '2025-05-04 01:06:55', '2025-05-04 01:06:55'),
(22, 22, 9, 2, 'Therapy', 'Wheelchair / Kursi Roda', '', 370000, '[\"http://localhost/medisya/assets/products/wheelchair-1.jpg\"]', 1, '2025-05-04 01:06:55', '2025-05-04 01:06:55'),
(23, 22, 3, 3, 'Personal Protective Equipment', 'Face Shield', '', 25000, '[\"http://localhost/medisya/assets/products/face-shield-2.jpg\"]', 1, '2025-05-04 01:06:55', '2025-05-04 01:06:55'),
(24, 23, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', '', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-04 01:56:08', '2025-05-04 01:56:08'),
(25, 23, 4, 3, 'Personal Protective Equipment', 'Hand Sanitizer', '', 40000, '[\"http://localhost/medisya/assets/products/hand-sanitizer-2.jpg\"]', 3, '2025-05-04 01:56:08', '2025-05-04 01:56:08'),
(26, 24, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', '', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-04 01:57:22', '2025-05-04 01:57:22'),
(27, 24, 9, 2, 'Therapy', 'Wheelchair / Kursi Roda', '', 370000, '[\"http://localhost/medisya/assets/products/wheelchair-1.jpg\"]', 1, '2025-05-04 01:57:22', '2025-05-04 01:57:22'),
(28, 25, 8, 3, 'Personal Protective Equipment', 'Medical Face Mask', '', 32000, '[\"http://localhost/medisya/assets/products/medical-mask-2.jpg\"]', 1, '2025-05-04 02:00:25', '2025-05-04 02:00:25'),
(29, 28, 1, 1, 'Diagnostics', 'Infrared Thermometer', '', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 02:03:34', '2025-05-04 02:03:34'),
(30, 30, 1, 1, 'Diagnostics', 'Infrared Thermometer', '', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 03:53:48', '2025-05-04 03:53:48'),
(31, 32, 1, 1, 'Diagnostics', 'Infrared Thermometer', '', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 03:56:49', '2025-05-04 03:56:49'),
(32, 32, 9, 2, 'Therapy', 'Wheelchair / Kursi Roda', '', 370000, '[\"http://localhost/medisya/assets/products/wheelchair-1.jpg\"]', 1, '2025-05-04 03:56:49', '2025-05-04 03:56:49'),
(33, 32, 3, 3, 'Personal Protective Equipment', 'Face Shield', '', 25000, '[\"http://localhost/medisya/assets/products/face-shield-2.jpg\"]', 1, '2025-05-04 03:56:49', '2025-05-04 03:56:49'),
(34, 34, 3, 3, 'Personal Protective Equipment', 'Face Shield', '', 25000, '[\"http://localhost/medisya/assets/products/face-shield-2.jpg\"]', 1, '2025-05-04 04:18:43', '2025-05-04 04:18:43'),
(35, 35, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', '', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-04 04:19:19', '2025-05-04 04:19:19'),
(36, 36, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', '', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-04 04:20:11', '2025-05-04 04:20:11'),
(37, 37, 1, 1, 'Diagnostics', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 11:52:51', '2025-05-04 11:52:51'),
(38, 37, 5, 3, 'Personal Protective Equipment', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, '[\"http://localhost/medisya/assets/products/hazmat-suit-2.jpg\"]', 1, '2025-05-04 11:52:51', '2025-05-04 11:52:51'),
(39, 38, 1, 1, 'Diagnostics', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 12:35:56', '2025-05-04 12:35:56'),
(40, 38, 9, 2, 'Therapy', 'Wheelchair / Kursi Roda', 'Kursi bantu jalan bagi yang sulit bergerak', 370000, '[\"http://localhost/medisya/assets/products/wheelchair-1.jpg\"]', 1, '2025-05-04 12:35:56', '2025-05-04 12:35:56'),
(41, 38, 8, 3, 'Personal Protective Equipment', 'Medical Face Mask', 'Masker medis sekali pakai', 32000, '[\"http://localhost/medisya/assets/products/medical-mask-2.jpg\"]', 2, '2025-05-04 12:35:56', '2025-05-04 12:35:56'),
(42, 39, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 3, '2025-05-04 12:54:35', '2025-05-04 12:54:35'),
(43, 39, 9, 2, 'Therapy', 'Wheelchair / Kursi Roda', 'Kursi bantu jalan bagi yang sulit bergerak', 370000, '[\"http://localhost/medisya/assets/products/wheelchair-1.jpg\"]', 1, '2025-05-04 12:54:35', '2025-05-04 12:54:35'),
(44, 39, 8, 3, 'Personal Protective Equipment', 'Medical Face Mask', 'Masker medis sekali pakai', 32000, '[\"http://localhost/medisya/assets/products/medical-mask-2.jpg\"]', 2, '2025-05-04 12:54:35', '2025-05-04 12:54:35'),
(45, 40, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 2, '2025-05-04 12:57:52', '2025-05-04 12:57:52'),
(46, 41, 7, 1, 'Diagnostics', 'Nebulizer', 'Ubah obat cair jadi uap untuk pernapasan', 75000, '[\"http://localhost/medisya/assets/products/nebulizer-0.jpg\"]', 1, '2025-05-04 13:03:15', '2025-05-04 13:03:15'),
(47, 41, 6, 2, 'Therapy', 'Hot / Cold Therapy Pack', 'Kompres panas atau dingin untuk nyeri', 50000, '[\"http://localhost/medisya/assets/products/hot-cold-therapy-pack-1.jpg\"]', 1, '2025-05-04 13:03:15', '2025-05-04 13:03:15'),
(48, 41, 8, 3, 'Personal Protective Equipment', 'Medical Face Mask', 'Masker medis sekali pakai', 32000, '[\"http://localhost/medisya/assets/products/medical-mask-2.jpg\"]', 1, '2025-05-04 13:03:15', '2025-05-04 13:03:15'),
(49, 42, 1, 1, 'Diagnostics', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 13:52:58', '2025-05-04 13:52:58'),
(50, 42, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-04 13:52:58', '2025-05-04 13:52:58'),
(51, 43, 1, 1, 'Diagnostics', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-04 13:53:32', '2025-05-04 13:53:32'),
(52, 43, 5, 3, 'Personal Protective Equipment', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, '[\"http://localhost/medisya/assets/products/hazmat-suit-2.jpg\"]', 1, '2025-05-04 13:53:32', '2025-05-04 13:53:32'),
(53, 44, 1, 1, 'Diagnostics', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-05 11:39:43', '2025-05-05 11:39:43'),
(54, 44, 5, 3, 'Personal Protective Equipment', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, '[\"http://localhost/medisya/assets/products/hazmat-suit-2.jpg\"]', 1, '2025-05-05 11:39:43', '2025-05-05 11:39:43'),
(55, 44, 8, 3, 'Personal Protective Equipment', 'Medical Face Mask', 'Masker medis sekali pakai', 32000, '[\"http://localhost/medisya/assets/products/medical-mask-2.jpg\"]', 1, '2025-05-05 11:39:43', '2025-05-05 11:39:43'),
(56, 45, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-05 13:57:38', '2025-05-05 13:57:38'),
(57, 45, 3, 3, 'Personal Protective Equipment', 'Face Shield', 'Pelindung wajah dari kuman/cipratan', 25000, '[\"http://localhost/medisya/assets/products/face-shield-2.jpg\"]', 2, '2025-05-05 13:57:38', '2025-05-05 13:57:38'),
(58, 47, 2, 1, 'Diagnostics', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, '[\"http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg\"]', 1, '2025-05-05 13:59:13', '2025-05-05 13:59:13'),
(59, 48, 1, 1, 'Diagnostics', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, '[\"http://localhost/medisya/assets/products/infrared-thermometer-0.jpg\"]', 1, '2025-05-05 14:05:33', '2025-05-05 14:05:33'),
(60, 48, 7, 1, 'Diagnostics', 'Nebulizer', 'Ubah obat cair jadi uap untuk pernapasan', 75000, '[\"http://localhost/medisya/assets/products/nebulizer-0.jpg\"]', 1, '2025-05-05 14:05:33', '2025-05-05 14:05:33'),
(61, 49, 5, 3, 'Therapy & Rehabilitation', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 1, '2025-05-05 16:24:41', '2025-05-05 16:24:41'),
(62, 49, 7, 1, 'Basic Laboratory Equipment', 'Nebulizer', 'Ubah obat cair jadi uap untuk pernapasan', 75000, 'http://localhost/medisya/assets/products/nebulizer-0.jpg', 1, '2025-05-05 16:24:41', '2025-05-05 16:24:41'),
(63, 49, 9, 2, 'Diagnostic Tools', 'Wheelchair / Kursi Roda', 'Kursi bantu jalan bagi yang sulit bergerak', 370000, 'http://localhost/medisya/assets/products/wheelchair-1.jpg', 1, '2025-05-05 16:24:41', '2025-05-05 16:24:41'),
(64, 50, 3, 3, 'Therapy & Rehabilitation', 'Face Shield', 'Pelindung wajah dari kuman/cipratan', 25000, 'http://localhost/medisya/assets/products/face-shield-2.jpg', 1, '2025-05-05 16:41:22', '2025-05-05 16:41:22'),
(65, 51, 2, 1, 'Basic Laboratory Equipment', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-06 01:11:31', '2025-05-06 01:11:31'),
(66, 51, 4, 3, 'Therapy & Rehabilitation', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-06 01:11:31', '2025-05-06 01:11:31'),
(67, 52, 1, 1, 'Basic Laboratory Equipment', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-06 02:04:13', '2025-05-06 02:04:13'),
(68, 55, 3, 3, 'Therapy & Rehabilitation', 'Face Shield', 'Pelindung wajah dari kuman/cipratan', 25000, 'http://localhost/medisya/assets/products/face-shield-2.jpg', 1, '2025-05-06 02:31:27', '2025-05-06 02:31:27'),
(69, 56, 2, 1, 'Basic Laboratory Equipment', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-06 02:48:56', '2025-05-06 02:48:56'),
(70, 57, 2, 1, 'Basic Laboratory Equipment', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-06 03:13:55', '2025-05-06 03:13:55'),
(71, 58, 13, 2, 'Diagnostic Tools', 'Medical Gloves', 'Sarung tangan medis sekali pakai', 67000, 'http://localhost/medisya/assets/products/medical-gloves-2.jpg', 1, '2025-05-06 03:31:55', '2025-05-06 03:31:55'),
(72, 58, 6, 2, 'Diagnostic Tools', 'Hot / Cold Therapy Pack', 'Kompres panas atau dingin untuk nyeri', 50000, 'http://localhost/medisya/assets/products/hot-cold-therapy-pack-1.jpg', 1, '2025-05-06 03:31:55', '2025-05-06 03:31:55'),
(73, 58, 5, 3, 'Therapy & Rehabilitation', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 1, '2025-05-06 03:31:55', '2025-05-06 03:31:55'),
(74, 60, 1, 1, 'Basic Laboratory Equipment', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-06 03:36:46', '2025-05-06 03:36:46'),
(75, 61, 7, 1, 'Basic Laboratory Equipment', 'Nebulizer', 'Ubah obat cair jadi uap untuk pernapasan', 75000, 'http://localhost/medisya/assets/products/nebulizer-0.jpg', 1, '2025-05-06 07:45:08', '2025-05-06 07:45:08'),
(76, 61, 6, 2, 'Diagnostic Tools', 'Hot / Cold Therapy Pack', 'Kompres panas atau dingin untuk nyeri', 50000, 'http://localhost/medisya/assets/products/hot-cold-therapy-pack-1.jpg', 1, '2025-05-06 07:45:08', '2025-05-06 07:45:08'),
(77, 61, 4, 3, 'Therapy & Rehabilitation', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-06 07:45:08', '2025-05-06 07:45:08'),
(78, 62, 1, 1, 'Basic Laboratory Equipment', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-06 17:49:25', '2025-05-06 17:49:25'),
(79, 62, 2, 1, 'Basic Laboratory Equipment', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-06 17:49:25', '2025-05-06 17:49:25'),
(80, 62, 13, 2, 'Diagnostic Tools', 'Medical Gloves', 'Sarung tangan medis sekali pakai', 67000, 'http://localhost/medisya/assets/products/medical-gloves-2.jpg', 1, '2025-05-06 17:49:25', '2025-05-06 17:49:25'),
(81, 62, 5, 3, 'Therapy & Rehabilitation', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 1, '2025-05-06 17:49:25', '2025-05-06 17:49:25'),
(82, 63, 2, 1, 'Basic Laboratory Equipment', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 00:10:06', '2025-05-07 00:10:06'),
(83, 63, 6, 2, 'Diagnostic Tools', 'Hot / Cold Therapy Pack', 'Kompres panas atau dingin untuk nyeri', 50000, 'http://localhost/medisya/assets/products/hot-cold-therapy-pack-1.jpg', 2, '2025-05-07 00:10:06', '2025-05-07 00:10:06'),
(84, 63, 3, 3, 'Therapy & Rehabilitation', 'Face Shield', 'Pelindung wajah dari kuman/cipratan', 25000, 'http://localhost/medisya/assets/products/face-shield-2.jpg', 1, '2025-05-07 00:10:06', '2025-05-07 00:10:06'),
(85, 63, 4, 3, 'Therapy & Rehabilitation', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-07 00:10:06', '2025-05-07 00:10:06'),
(86, 63, 5, 3, 'Therapy & Rehabilitation', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 1, '2025-05-07 00:10:06', '2025-05-07 00:10:06'),
(87, 64, 1, 1, 'Basic Laboratory Equipment', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 00:14:02', '2025-05-07 00:14:02'),
(88, 65, 13, 2, 'Diagnostic Tools', 'Medical Gloves', 'Sarung tangan medis sekali pakai', 67000, 'http://localhost/medisya/assets/products/medical-gloves-2.jpg', 1, '2025-05-07 00:22:15', '2025-05-07 00:22:15'),
(89, 65, 4, 3, 'Therapy & Rehabilitation', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-07 00:22:15', '2025-05-07 00:22:15'),
(90, 66, 1, 1, 'Basic Laboratory Equipment', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 00:25:07', '2025-05-07 00:25:07'),
(91, 68, 1, 1, 'Basic Laboratory Equipment', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 00:39:48', '2025-05-07 00:39:48'),
(92, 69, 4, 3, 'Therapy & Rehabilitation', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-07 00:40:21', '2025-05-07 00:40:21'),
(93, 70, 2, 1, 'Basic Laboratory Equipment', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 00:41:55', '2025-05-07 00:41:55'),
(94, 72, 13, 4, 'Personal Protective Equipment', 'Medical Gloves', 'Sarung tangan medis sekali pakai', 67000, 'http://localhost/medisya/assets/products/medical-gloves-2.jpg', 1, '2025-05-07 06:57:21', '2025-05-07 06:57:21'),
(95, 74, 13, 4, 'Personal Protective Equipment', 'Medical Gloves', 'Sarung tangan medis sekali pakai', 67000, 'http://localhost/medisya/assets/products/medical-gloves-2.jpg', 2, '2025-05-07 06:59:32', '2025-05-07 06:59:32'),
(96, 75, 13, 4, 'Personal Protective Equipment', 'Medical Gloves', 'Sarung tangan medis sekali pakai', 67000, 'http://localhost/medisya/assets/products/medical-gloves-2.jpg', 1, '2025-05-07 07:05:31', '2025-05-07 07:05:31'),
(97, 76, 2, 2, 'Diagnostic Tools', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 2, '2025-05-07 07:11:56', '2025-05-07 07:11:56'),
(98, 77, 2, 2, 'Diagnostic Tools', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 07:14:05', '2025-05-07 07:14:05'),
(99, 78, 4, 4, 'Personal Protective Equipment', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-07 07:20:54', '2025-05-07 07:20:54'),
(100, 80, 1, 2, 'Diagnostic Tools', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 07:39:26', '2025-05-07 07:39:26'),
(101, 80, 2, 2, 'Diagnostic Tools', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 07:39:26', '2025-05-07 07:39:26'),
(102, 80, 6, 3, 'Therapy & Rehabilitation', 'Hot / Cold Therapy Pack', 'Kompres panas atau dingin untuk nyeri', 50000, 'http://localhost/medisya/assets/products/hot-cold-therapy-pack-1.jpg', 1, '2025-05-07 07:39:26', '2025-05-07 07:39:26'),
(103, 80, 5, 4, 'Personal Protective Equipment', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 1, '2025-05-07 07:39:26', '2025-05-07 07:39:26'),
(104, 81, 1, 2, 'Diagnostic Tools', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 07:45:06', '2025-05-07 07:45:06'),
(105, 81, 5, 4, 'Personal Protective Equipment', 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 1, '2025-05-07 07:45:06', '2025-05-07 07:45:06'),
(106, 82, 2, 2, 'Diagnostic Tools', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 08:12:39', '2025-05-07 08:12:39'),
(107, 89, 1, 2, 'Diagnostic Tools', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 08:29:09', '2025-05-07 08:29:09'),
(108, 90, 2, 2, 'Diagnostic Tools', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 08:48:04', '2025-05-07 08:48:04'),
(109, 95, 4, 4, 'Personal Protective Equipment', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-07 09:14:01', '2025-05-07 09:14:01'),
(110, 96, 2, 2, 'Diagnostic Tools', 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 1, '2025-05-07 09:35:18', '2025-05-07 09:35:18'),
(111, 96, 4, 4, 'Personal Protective Equipment', 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 1, '2025-05-07 09:35:18', '2025-05-07 09:35:18'),
(112, 103, 1, 2, 'Diagnostic Tools', 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 1, '2025-05-07 09:54:42', '2025-05-07 09:54:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float DEFAULT NULL,
  `original_price` float DEFAULT NULL,
  `images` text DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `original_price`, `images`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 2, 'Infrared Thermometer', 'Termometer tanpa sentuh, ukur suhu lewat dahi', 135000, 150000, 'http://localhost/medisya/assets/products/infrared-thermometer-0.jpg', 50, '2019-08-23 04:55:56', '2019-08-27 04:15:27'),
(2, 2, 'Digital Blood Pressure Monitor', 'Alat ukur tekanan darah otomatis', 60000, 71000, 'http://localhost/medisya/assets/products/digital-blood-pressure-monitor-0.jpg', 17, '2019-08-23 04:57:22', '2019-08-27 04:12:18'),
(3, 4, 'Face Shield', 'Pelindung wajah dari kuman/cipratan', 25000, 26000, 'http://localhost/medisya/assets/products/face-shield-2.jpg', 10, '2019-08-25 19:59:41', '2019-08-27 04:12:29'),
(4, 4, 'Hand Sanitizer', 'Cairan pembersih tangan tanpa air', 40000, 27000, 'http://localhost/medisya/assets/products/hand-sanitizer-2.jpg', 9, '2019-08-25 20:07:18', '2019-08-27 04:12:07'),
(5, 4, 'Hazmat Suit / APD', 'Baju pelindung tubuh dari infeksi', 200000, 204500, 'http://localhost/medisya/assets/products/hazmat-suit-2.jpg', 12, '2019-08-26 06:04:30', '2019-08-27 04:12:57'),
(6, 3, 'Hot / Cold Therapy Pack', 'Kompres panas atau dingin untuk nyeri', 50000, 70000, 'http://localhost/medisya/assets/products/hot-cold-therapy-pack-1.jpg', 90, '2019-08-26 06:05:11', '2019-08-27 13:13:02'),
(7, 2, 'Nebulizer', 'Ubah obat cair jadi uap untuk pernapasan', 75000, 100000, 'http://localhost/medisya/assets/products/nebulizer-0.jpg', 5, '2019-08-26 06:05:34', '2019-08-27 04:11:42'),
(8, 3, 'Medical Face Mask', 'Masker medis sekali pakai', 32000, 54000, 'http://localhost/medisya/assets/products/medical-mask-2.jpg', 10, '2019-08-26 06:06:06', '2019-08-27 12:33:32'),
(9, 3, 'Wheelchair / Kursi Roda', 'Kursi bantu jalan bagi yang sulit bergerak', 370000, 430000, 'http://localhost/medisya/assets/products/wheelchair-1.jpg', 10, '2019-08-26 06:06:58', '2019-08-27 04:15:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `paypal_id` varchar(100) DEFAULT NULL,
  `role` enum('visitor','customer','admin') NOT NULL DEFAULT 'visitor',
  `user_level` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `date_of_birth`, `gender`, `address`, `city`, `phone`, `paypal_id`, `role`, `user_level`, `created_at`) VALUES
(6, 'admin', '$2y$10$x06OcAIf27FLiyyLY2UDXO1jv8YEzY6JaQrlWMpHRKSVhJg3UpqnC', 'admin@example.com', '1985-12-25', 'male', 'Jl. Kartika No. 1', 'Jakarta', '08123456789', '2', 'admin', 'super', '2025-05-04 06:13:44'),
(7, 'pus', '$2y$10$ECiE1R4rj1sa4y0zc5FSKO5ihlcpgvDhp22uTecqzvJyYNA.GTEB6', 'pus@example.com', '2025-05-04', 'female', 'Pondok Gede, Bekasi', 'Bekasi', '0873865484390', '', 'customer', 'basic', '2025-05-04 02:16:44'),
(8, 'hanim', '$2y$10$yFhsmC45DTbK8KixCMe7rufEMw6LOBXqR2p/D3swCgdtfIySs3oCq', 'hanimrachmanurhaliza@gmail.com', '2004-01-22', 'female', 'Wonorejo, Rungkut, Surabaya', 'Surabaya', '085704123017', '12', 'customer', 'basic', '2025-05-05 22:13:28'),
(9, 'kevi', '$2y$10$w832FfIcc9CDBkLqDU4Fiu1Hdenc.BXlN/nQV5vzeXKSDuesykrgG', 'kefiespecially@gmail.com', '2004-01-02', 'female', 'Rungkut, Surabaya', 'Surabaya', '085704123013', '453', 'customer', 'basic', '2025-05-07 01:54:46'),
(10, 'haliza', '$2y$10$VQqqyt05DbJFgLOFBwXTJOz3TOjcBk9ZSqun1PF9Wu7W6a3PpS.OO', 'hi.halizahanim@gmail.com', '2025-05-08', 'female', 'Surabaya', 'Surabaya', '0873865484334', '-', 'customer', 'basic', '2025-05-07 02:30:38'),
(11, 'hanim rachma', '$2y$10$t/dSnKefigZH7u.be3TKG.Xfunyjk5m0bdMY76Y2spoDhrolbi92W', '22082010010@student.upnjatim.ac.id', '2025-05-08', 'female', 'Rungkut', 'Surabaya', '0867345476', NULL, 'customer', 'basic', '2025-05-07 02:34:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indeks untuk tabel `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
