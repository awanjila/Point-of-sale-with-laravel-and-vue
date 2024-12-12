-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2023 at 06:45 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos-inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `advanced_salaries`
--

CREATE TABLE `advanced_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `advance_salary` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advanced_salaries`
--

INSERT INTO `advanced_salaries` (`id`, `employee_id`, `month`, `year`, `advance_salary`, `created_at`, `updated_at`) VALUES
(1, 1, 'April', '2023', '40000', '2023-04-20 11:45:02', '2023-04-20 11:45:02'),
(2, 3, 'April', '2023', NULL, '2023-04-02 02:24:39', '2023-04-02 02:24:39'),
(3, 2, 'April', '2023', NULL, '2023-04-02 11:27:23', NULL),
(4, 1, 'February\"', '2023', '80000', '2023-04-02 13:17:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `attend_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `date`, `attend_status`, `created_at`, `updated_at`) VALUES
(5, 1, '1970-01-01', 'present', '2023-04-04 12:51:31', '2023-04-04 12:51:31'),
(6, 2, '1970-01-01', 'present', '2023-04-04 12:51:31', '2023-04-04 12:51:31'),
(7, 3, '1970-01-01', 'present', '2023-04-04 12:51:31', '2023-04-04 12:51:31'),
(8, 4, '1970-01-01', 'present', '2023-04-04 12:51:31', '2023-04-04 12:51:31'),
(13, 1, '2023-04-04', 'Leave', '2023-04-04 12:52:00', '2023-04-04 12:52:00'),
(14, 2, '2023-04-04', 'Leave', '2023-04-04 12:52:00', '2023-04-04 12:52:00'),
(15, 3, '2023-04-04', 'Leave', '2023-04-04 12:52:00', '2023-04-04 12:52:00'),
(16, 4, '2023-04-04', 'Leave', '2023-04-04 12:52:00', '2023-04-04 12:52:00'),
(21, 1, '2023-04-05', 'present', '2023-04-05 14:22:55', '2023-04-05 14:22:55'),
(22, 2, '2023-04-05', 'Leave', '2023-04-05 14:22:55', '2023-04-05 14:22:55'),
(23, 3, '2023-04-05', 'Leave', '2023-04-05 14:22:55', '2023-04-05 14:22:55'),
(24, 4, '2023-04-05', 'present', '2023-04-05 14:22:55', '2023-04-05 14:22:55'),
(29, 1, '2023-04-06', 'present', '2023-04-05 14:33:22', '2023-04-05 14:33:22'),
(30, 2, '2023-04-06', 'present', '2023-04-05 14:33:22', '2023-04-05 14:33:22'),
(31, 3, '2023-04-06', 'present', '2023-04-05 14:33:22', '2023-04-05 14:33:22'),
(32, 4, '2023-04-06', 'Absent', '2023-04-05 14:33:22', '2023-04-05 14:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(4, 'Pain Killers', '2023-05-07 11:09:34', NULL),
(5, 'Anti Histamine', '2023-05-07 11:23:53', NULL),
(6, 'Anti Biotic Cyrup', '2023-05-07 11:24:41', '2023-05-07 11:24:41'),
(7, 'Anti Biotic Tabs', '2023-05-07 11:25:00', NULL),
(8, 'Cough Syrup', '2023-05-07 11:32:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `photo`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Wanjila Muchika', 'email@yourcompany.com', '0781312070', 'Umoja Area', 'upload/customer/1763607455138928.jpg', NULL, '2023-04-19 09:25:35', NULL),
(2, 'Joyce', 'joycenjish14@gmail.com', '0745218453', 'Umoja Area', 'upload/customer/1763753362852650.jpg', NULL, '2023-04-21 00:04:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `vacation` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone`, `address`, `experience`, `photo`, `salary`, `vacation`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Muchika', 'abemuchikan@gmail.com', '0781312070', 'Umoja Area', '4 year', 'upload/employee/1762040449779959.png', '150000', 'Yes', 'Nairobi', '2023-04-02 02:18:42', NULL),
(2, 'Liam Kadui', 'kadui@gmail.com', '0781312070', 'Umoja Area', '3 year', 'upload/employee/1762040577663605.png', '75000', 'Yes', 'Nairobi', '2023-04-02 02:20:43', NULL),
(3, 'Joyce Chau', 'tracy@gmail.com', '0745218453', 'Umoja Area', '3 year', 'upload/employee/1762040628354356.png', '100000', 'Yes', 'Nairobi', '2023-04-02 02:21:31', NULL),
(4, 'Kim', 'kim@kim.com', '0781312070', 'Roasters', '4 year', 'upload/employee/1762167608072475.png', '150000', 'Yes', 'Nairobi', '2023-04-03 11:59:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `details` text NOT NULL,
  `amount` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `details`, `amount`, `month`, `year`, `date`, `created_at`, `updated_at`) VALUES
(1, 'dcdc', '100', 'April', '2023', '14-04-2023', '2023-04-14 16:38:06', NULL),
(2, 'fvfv', '1500', 'April', '2023', '14-04-2023', '2023-04-14 16:40:02', '2023-04-14 17:24:29'),
(3, 'dcdc', '700', 'April', '2023', '14-04-2023', '2023-04-14 17:07:37', '2023-04-14 17:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_03_27_115447_create_employees_table', 1),
(6, '2023_03_28_120234_create_customers_table', 1),
(7, '2023_03_29_133721_create_suppliers_table', 1),
(8, '2023_03_31_023204_create_advanced_salaries_table', 1),
(9, '2023_04_01_032301_create_pay_salaries_table', 1),
(10, '2023_04_03_072115_create_attendances_table', 2),
(11, '2023_04_06_033314_create_categories_table', 3),
(12, '2023_04_08_000803_create_products_table', 4),
(13, '2023_04_14_173310_create_expenses_table', 5),
(14, '2018_12_23_120000_create_shoppingcart_table', 6),
(16, '2023_04_20_050332_create_order_details_table', 6),
(17, '2023_04_20_045401_create_orders_table', 7),
(18, '2023_04_28_084455_create_permission_tables', 8);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(7, 'App\\Models\\User', 3),
(7, 'App\\Models\\User', 12),
(7, 'App\\Models\\User', 14),
(7, 'App\\Models\\User', 15);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `vat` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `pay` varchar(255) DEFAULT NULL,
  `due` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `order_status`, `total_products`, `sub_total`, `invoice_no`, `total`, `vat`, `payment_status`, `pay`, `due`, `created_at`, `updated_at`) VALUES
(16, 2, '08-May-2023', 'complete', '1', '10', 'EPOS12669806', '10', '0', NULL, '10', '0', '2023-05-08 00:37:03', '2023-05-12 15:02:31'),
(17, 2, '08-May-2023', 'complete', '4', '339', 'EPOS40256158', '339', '0', NULL, '339', '0', '2023-05-08 12:51:38', '2023-05-08 12:51:59'),
(18, 1, '10-May-2023', 'complete', '3', '403', 'EPOS71818086', '403', '0', 'Mpesa', '403', '0', '2023-05-10 11:54:42', '2023-05-10 11:55:07'),
(19, 1, '12-May-2023', 'complete', '12', '1913', 'EPOS16017345', '1913', '0', 'HandCash', '1913', '0', '2023-05-12 01:24:48', '2023-05-12 01:27:55'),
(20, 2, '12-May-2023', 'complete', '10', '1745', 'EPOS85952098', '1745', '0', 'HandCash', '1745', '0', '2023-05-12 01:30:33', '2023-05-12 15:01:17'),
(21, 1, '12-May-2023', 'complete', '4', '561', 'EPOS14581596', '561', '0', 'HandCash', '561', '0', '2023-05-12 04:31:08', '2023-05-12 14:10:27'),
(22, 1, '12-May-2023', 'complete', '4', '336', 'EPOS47629182', '336', '0', 'HandCash', '336', '0', '2023-05-12 04:35:19', '2023-05-12 04:36:41'),
(23, 1, '12-May-2023', 'complete', '11', '924', 'EPOS22530599', '924', '0', 'Mpesa', '924', '0', '2023-05-12 06:36:03', '2023-05-12 06:36:52'),
(24, 2, '12-May-2023', 'complete', '4', '1012', 'EPOS87936570', '1012', '0', 'Mpesa', '1012', '0', '2023-05-12 14:15:46', '2023-05-12 14:27:20'),
(25, 2, '12-May-2023', 'complete', '8', '1348', 'EPOS55982166', '1348', '0', 'Mpesa', '1348', '0', '2023-05-12 15:03:06', '2023-05-12 15:07:19'),
(26, 2, '13-May-2023', 'complete', '8', '1200', 'EPOS45698098', '1200', '0', 'HandCash', '1200', '0', '2023-05-13 06:35:31', '2023-05-13 06:37:05'),
(27, 2, '13-May-2023', 'complete', '0', '0', 'EPOS32761606', '0', '0', NULL, '0', '0', '2023-05-13 08:49:29', '2023-05-13 11:37:11'),
(28, 2, '13-May-2023', 'complete', '1', '84', 'EPOS55440378', '84', '0', 'Mpesa', '84', '0', '2023-05-13 10:57:35', '2023-05-13 11:36:58'),
(29, 2, '13-May-2023', 'pending', '1', '84', 'EPOS16150545', '84', '0', 'Mpesa', '84', '0', '2023-05-13 11:49:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `unit_cost` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `unit_cost`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, '7', '1', '270', '313', '2023-04-20 08:19:07', NULL),
(2, 1, '8', '1', '540', '626', '2023-04-20 08:19:07', NULL),
(3, 1, '9', '1', '675', '783', '2023-04-20 08:19:07', NULL),
(4, 2, '7', '1', '270', '313', '2023-04-20 08:20:35', NULL),
(5, 2, '8', '1', '540', '626', '2023-04-20 08:20:35', NULL),
(6, 2, '9', '1', '675', '783', '2023-04-20 08:20:35', NULL),
(7, 3, '7', '1', '270', '313', '2023-04-20 08:28:45', NULL),
(8, 3, '8', '55', '540', '34452', '2023-04-20 08:28:45', NULL),
(9, 3, '9', '1', '675', '783', '2023-04-20 08:28:45', NULL),
(10, 4, '7', '4', '270', '1253', '2023-04-20 11:46:30', NULL),
(11, 5, '7', '4', '270', '1253', '2023-04-21 00:05:40', NULL),
(12, 5, '8', '1', '540', '626', '2023-04-21 00:05:40', NULL),
(13, 6, '9', '1', '675', '783', '2023-04-26 08:12:05', NULL),
(14, 7, '9', '3', '675', '2349', '2023-04-26 08:42:47', NULL),
(15, 8, '7', '1', '270', '313', '2023-05-06 17:52:52', NULL),
(16, 8, '8', '1', '540', '626', '2023-05-06 17:52:52', NULL),
(17, 8, '9', '1', '675', '783', '2023-05-06 17:52:52', NULL),
(18, 9, '7', '1', '270', '313', '2023-05-06 17:58:45', NULL),
(19, 9, '8', '1', '540', '626', '2023-05-06 17:58:45', NULL),
(20, 9, '9', '3', '675', '2349', '2023-05-06 17:58:45', NULL),
(21, 10, '7', '14', '270', '4385', '2023-05-06 18:05:09', NULL),
(22, 10, '8', '1', '540', '626', '2023-05-06 18:05:09', NULL),
(23, 10, '9', '3', '675', '2349', '2023-05-06 18:05:09', NULL),
(24, 11, '7', '6', '270', '1879', '2023-05-07 06:39:32', NULL),
(25, 11, '8', '4', '540', '2506', '2023-05-07 06:39:32', NULL),
(26, 11, '9', '4', '675', '3132', '2023-05-07 06:39:32', NULL),
(27, 12, '11', '3', '9.99', '35', '2023-05-07 11:57:42', NULL),
(28, 12, '13', '10', '72.8', '844', '2023-05-07 11:57:42', NULL),
(29, 12, '12', '1', '165.2', '191', '2023-05-07 11:57:42', NULL),
(30, 13, '14', '1', '309.4', '358', '2023-05-07 12:00:42', NULL),
(31, 13, '13', '1', '72.8', '85', '2023-05-07 12:00:42', NULL),
(32, 13, '11', '1', '9.99', '12', '2023-05-07 12:00:42', NULL),
(33, 14, '14', '10', '309.4', '3589', '2023-05-07 12:08:43', NULL),
(34, 14, '13', '1', '72.8', '85', '2023-05-07 12:08:43', NULL),
(35, 14, '11', '1', '9.99', '12', '2023-05-07 12:08:43', NULL),
(36, 15, '15', '100', '10', '1000', '2023-05-07 12:40:13', NULL),
(37, 16, '15', '1', '10', '10', '2023-05-08 00:37:03', NULL),
(38, 17, '16', '1', '309.4', '309', '2023-05-08 12:51:38', NULL),
(39, 17, '15', '3', '10', '30', '2023-05-08 12:51:38', NULL),
(40, 18, '17', '1', '84', '84', '2023-05-10 11:54:42', NULL),
(41, 18, '16', '1', '309.4', '309', '2023-05-10 11:54:42', NULL),
(42, 18, '15', '1', '10', '10', '2023-05-10 11:54:42', NULL),
(43, 19, '17', '4', '84', '336', '2023-05-12 01:24:48', NULL),
(44, 19, '16', '5', '309.4', '1547', '2023-05-12 01:24:48', NULL),
(45, 19, '15', '3', '10', '30', '2023-05-12 01:24:48', NULL),
(46, 20, '17', '2', '84', '168', '2023-05-12 01:30:33', NULL),
(47, 20, '16', '5', '309.4', '1547', '2023-05-12 01:30:33', NULL),
(48, 20, '15', '3', '10', '30', '2023-05-12 01:30:33', NULL),
(49, 21, '17', '3', '84', '252', '2023-05-12 04:31:08', NULL),
(50, 21, '16', '1', '309.4', '309', '2023-05-12 04:31:08', NULL),
(51, 22, '17', '4', '84', '336', '2023-05-12 04:35:19', NULL),
(52, 23, '17', '11', '84', '924', '2023-05-12 06:36:03', NULL),
(53, 24, '17', '1', '84', '84', '2023-05-12 14:15:46', NULL),
(54, 24, '16', '3', '309.4', '928', '2023-05-12 14:15:46', NULL),
(55, 25, '17', '5', '84', '420', '2023-05-12 15:03:06', NULL),
(56, 25, '16', '3', '309.4', '928', '2023-05-12 15:03:06', NULL),
(57, 26, '17', '3', '84', '252', '2023-05-13 06:35:31', NULL),
(58, 26, '16', '3', '309.4', '928', '2023-05-13 06:35:31', NULL),
(59, 26, '15', '2', '10', '20', '2023-05-13 06:35:31', NULL),
(60, 28, '17', '1', '84', '84', '2023-05-13 10:57:35', NULL),
(61, 29, '17', '1', '84', '84', '2023-05-13 11:49:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('abemuchikan@gmail.com', '$2y$10$wHxNvUCusbog0m0myj6fPulfKcUTlOKnb9vFo1A9N6zLjM8q5voQW', '2023-05-07 17:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `pay_salaries`
--

CREATE TABLE `pay_salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `salary_month` varchar(255) DEFAULT NULL,
  `paid_amount` varchar(255) DEFAULT NULL,
  `advance_salary` text DEFAULT NULL,
  `due_salary` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pay_salaries`
--

INSERT INTO `pay_salaries` (`id`, `employee_id`, `salary_month`, `paid_amount`, `advance_salary`, `due_salary`, `created_at`, `updated_at`) VALUES
(1, 3, 'March', '100000', NULL, '100000', '2023-04-02 14:18:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `group_name`, `created_at`, `updated_at`) VALUES
(4, 'employee.menu', 'web', 'employee', '2023-04-30 11:47:12', '2023-04-30 11:47:12'),
(5, 'employee.all', 'web', 'employee', '2023-04-30 11:47:38', '2023-04-30 11:47:38'),
(6, 'employee.add', 'web', 'employee', '2023-04-30 11:48:08', '2023-04-30 11:48:08'),
(7, 'employee.delete', 'web', 'employee', '2023-04-30 11:48:41', '2023-04-30 11:48:41'),
(8, 'employee.edit', 'web', 'employee', '2023-04-30 11:49:33', '2023-04-30 11:49:33'),
(9, 'customer.menu', 'web', 'customer', '2023-04-30 11:52:55', '2023-04-30 11:52:55'),
(10, 'customer.all', 'web', 'customer', '2023-04-30 11:53:18', '2023-04-30 11:53:18'),
(11, 'customer.add', 'web', 'customer', '2023-04-30 11:53:49', '2023-04-30 11:53:49'),
(12, 'customer.delete', 'web', 'customer', '2023-04-30 11:54:14', '2023-04-30 11:54:14'),
(13, 'customer.edit', 'web', 'customer', '2023-04-30 11:55:45', '2023-04-30 11:55:45'),
(14, 'supplier.menu', 'web', 'supplier', '2023-04-30 11:56:37', '2023-04-30 11:56:37'),
(15, 'supplier.all', 'web', 'supplier', '2023-04-30 11:57:24', '2023-04-30 11:57:24'),
(16, 'supplier.add', 'web', 'supplier', '2023-04-30 11:57:41', '2023-04-30 11:57:41'),
(17, 'supplier.delete', 'web', 'supplier', '2023-04-30 11:58:08', '2023-04-30 11:58:08'),
(18, 'supplier.edit', 'web', 'supplier', '2023-04-30 11:58:26', '2023-04-30 11:58:26'),
(19, 'salary.menu', 'web', 'salary', '2023-04-30 11:58:52', '2023-04-30 11:58:52'),
(20, 'salary.all', 'web', 'salary', '2023-04-30 11:59:14', '2023-04-30 11:59:14'),
(21, 'salary.add', 'web', 'salary', '2023-04-30 11:59:37', '2023-04-30 11:59:37'),
(22, 'salary.delete', 'web', 'salary', '2023-04-30 11:59:51', '2023-04-30 11:59:51'),
(23, 'salary.edit', 'web', 'salary', '2023-04-30 12:00:10', '2023-04-30 12:00:10'),
(24, 'attendance.menu', 'web', 'attendance', '2023-04-30 12:00:48', '2023-04-30 12:00:48'),
(25, 'attendance.all', 'web', 'attendance', '2023-04-30 12:01:04', '2023-04-30 12:01:04'),
(26, 'attendance.add', 'web', 'attendance', '2023-04-30 12:02:10', '2023-04-30 12:02:10'),
(27, 'attendance.delete', 'web', 'attendance', '2023-04-30 12:02:26', '2023-04-30 12:02:26'),
(28, 'attendance.edit', 'web', 'attendance', '2023-04-30 12:02:45', '2023-04-30 12:02:45'),
(29, 'product.menu', 'web', 'product', '2023-04-30 12:04:15', '2023-04-30 12:04:15'),
(30, 'product.all', 'web', 'product', '2023-04-30 12:04:49', '2023-04-30 12:04:49'),
(31, 'product.add', 'web', 'product', '2023-04-30 12:18:13', '2023-04-30 12:18:13'),
(32, 'product.delete', 'web', 'product', '2023-04-30 12:24:04', '2023-04-30 12:24:04'),
(33, 'product.edit', 'web', 'product', '2023-04-30 12:24:18', '2023-04-30 12:24:18'),
(34, 'expense.menu', 'web', 'expense', '2023-04-30 12:26:50', '2023-04-30 12:26:50'),
(35, 'expense.all', 'web', 'expense', '2023-04-30 12:27:16', '2023-04-30 12:27:16'),
(36, 'expense.add', 'web', 'expense', '2023-04-30 12:33:21', '2023-04-30 12:33:21'),
(37, 'expense.delete', 'web', 'expense', '2023-04-30 12:33:41', '2023-04-30 12:33:41'),
(38, 'expense.edit', 'web', 'expense', '2023-04-30 12:34:04', '2023-04-30 12:34:04'),
(39, 'order.menu', 'web', 'orders', '2023-04-30 12:34:54', '2023-04-30 12:34:54'),
(40, 'pending.order', 'web', 'orders', '2023-05-04 16:45:13', '2023-05-04 16:45:14'),
(41, 'order.add', 'web', 'orders', '2023-04-30 12:35:56', '2023-04-30 12:35:56'),
(42, 'order.delete', 'web', 'orders', '2023-04-30 12:36:21', '2023-04-30 12:36:21'),
(43, 'order.edit', 'web', 'orders', '2023-04-30 12:36:45', '2023-04-30 12:36:45'),
(45, 'role.menu', 'web', 'roles', '2023-04-30 12:40:07', '2023-04-30 12:40:07'),
(46, 'role.all', 'web', 'roles', '2023-04-30 12:40:33', '2023-04-30 12:40:33'),
(47, 'role.add', 'web', 'roles', '2023-04-30 12:41:09', '2023-04-30 12:41:09'),
(48, 'role.delete', 'web', 'roles', '2023-04-30 12:41:46', '2023-04-30 12:41:46'),
(49, 'role.edit', 'web', 'roles', '2023-04-30 12:42:37', '2023-04-30 12:42:37'),
(51, 'stock.menu', 'web', 'stock', '2023-05-01 12:34:19', '2023-05-01 12:34:19'),
(52, 'pay.salary', 'web', 'salary', '2023-05-04 16:16:51', '2023-05-04 16:16:51'),
(54, 'last.month.salary', 'web', 'salary', '2023-05-04 16:19:05', '2023-05-04 16:19:05'),
(55, 'pos.menu', 'web', 'pos', '2023-05-04 16:24:59', '2023-05-04 16:24:59'),
(56, 'import.product', 'web', 'product', '2023-05-04 16:38:44', '2023-05-04 16:38:44'),
(57, 'complete.order', 'web', 'orders', '2023-05-04 16:45:45', '2023-05-04 16:45:45'),
(58, 'add.roles.permissions', 'web', 'roles', '2023-05-04 17:06:05', '2023-05-04 17:06:05'),
(59, 'all.roles.permissions', 'web', 'roles', '2023-05-04 17:06:21', '2023-05-04 17:06:21'),
(60, 'all.permission', 'web', 'roles', '2023-05-04 17:15:08', '2023-05-04 17:15:08'),
(61, 'admin.menu', 'web', 'admin', '2023-05-04 17:26:03', '2023-05-04 17:26:03'),
(62, 'add.admin', 'web', 'admin', '2023-05-04 17:29:24', '2023-05-04 17:29:24'),
(63, 'all.admin', 'web', 'admin', '2023-05-04 17:29:40', '2023-05-04 17:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_store` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `buying_date` varchar(255) DEFAULT NULL,
  `expire_date` varchar(255) DEFAULT NULL,
  `buying_price` varchar(255) DEFAULT NULL,
  `selling_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `category_id`, `supplier_id`, `product_image`, `product_store`, `product_code`, `buying_date`, `expire_date`, `buying_price`, `selling_price`, `created_at`, `updated_at`) VALUES
(15, 'Panadol Extra', 4, 2, 'upload/product/1765250279012292.png', '287', 'MED01', '2023-05-07', '2024-12-07', '6', '10', '2023-05-08 00:00:29', '2023-05-13 06:37:05'),
(16, 'ARvs', 8, 2, 'image', '-12', 'MED02', '2023-05-31', '2023-06-01', '221', '309.4', '2023-05-08 10:46:06', '2023-05-13 06:37:05'),
(17, 'Loperamide', 7, 2, 'image', '215', 'MED03', '2023-05-10', '2024-05-10', '60', '84', '2023-05-12 06:37:37', '2023-05-13 11:36:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(7, 'SuperAdmin', 'web', '2023-05-01 12:39:36', '2023-05-01 12:39:36'),
(8, 'Admin', 'web', '2023-05-01 12:39:43', '2023-05-01 12:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 7),
(5, 7),
(6, 7),
(7, 7),
(8, 7),
(9, 7),
(9, 8),
(10, 7),
(10, 8),
(11, 7),
(11, 8),
(12, 7),
(12, 8),
(13, 7),
(13, 8),
(14, 7),
(15, 7),
(16, 7),
(17, 7),
(18, 7),
(19, 7),
(20, 7),
(21, 7),
(22, 7),
(23, 7),
(24, 7),
(24, 8),
(25, 7),
(25, 8),
(26, 7),
(26, 8),
(27, 7),
(27, 8),
(28, 7),
(28, 8),
(29, 7),
(30, 7),
(31, 7),
(32, 7),
(33, 7),
(34, 7),
(35, 7),
(36, 7),
(37, 7),
(38, 7),
(39, 7),
(40, 7),
(41, 7),
(42, 7),
(43, 7),
(45, 7),
(46, 7),
(47, 7),
(48, 7),
(49, 7),
(51, 7),
(52, 7),
(54, 7),
(55, 7),
(55, 8),
(56, 7),
(57, 7),
(58, 7),
(59, 7),
(60, 7),
(61, 7),
(62, 7),
(63, 7);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(255) NOT NULL,
  `instance` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` text DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `photo`, `company`, `location`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Wanjila Muchika', 'email@yourcompany.com', '0781312070', 'Umoja Area', 'upload/supplier/1762710459097555.jpeg', 'Wabe Creative', 'Umoja Area', 'Whole Seller', '2023-04-09 11:48:13', NULL),
(2, 'BELMONT PHARMACEUTICALS LTD', 'belmontpharmaceutical@gmail.com', '0714454908', 'hurlingham nairobi', 'upload/supplier/1765247182930428.png', 'BELMONT PHARMACEUTICALS LTD', 'hurlingham nairob', 'Whole Seller', '2023-05-07 11:48:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `photo`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Abraham', '0781312070', NULL, 'yemakhakha@gmail.com', NULL, '$2y$10$ly9MFIK/QQizK9iRJlje7.7lkrP.zbuZIAZ9oZFJnfaDGAUp8cswK', 'mca5vszpZ43nvBuXrYMKt04p4lNjvYdy2aR31RCvghd4BRkpPgxnWgCCWOGp', '2023-05-01 14:57:51', '2023-05-04 11:19:37'),
(12, 'Wanjila1', '+254781312070', NULL, 'yemakhakhajm@gmail.com', NULL, '$2y$10$yY2O4KEn7vzA5Gay.44rn.9tQpu.4wgNDccrT8Uc1YMsovBDEkb5W', NULL, '2023-05-04 06:50:58', '2023-05-04 11:18:53'),
(14, 'Abraham the Goon', '0710909198', NULL, 'abemuchikan@gmail.com', NULL, '$2y$10$y32G4uFjRMKoxIOr0HR10u0nb9S3uC7dGmoIg5M4SkjnZUofSqcau', 'FMD26jIWTY03gmIOnuxeRY9zF1srgDmwEzKBo4pljcvYqV9vBIPHxZRrkRdX', '2023-05-04 11:56:42', '2023-05-04 11:56:42'),
(15, 'Hellen', '0727314538', NULL, 'hellenborundo@gmail.com', NULL, '$2y$10$QtyPxVEcLfkmGVOTKvXILepsvw.ZSLw8TynDOTHZ8YEe.0cw0XSVe', 'ZZKWuBnM0V7Z4LzyClf7rtGeJAJ4b4jbZk9GbQB5u11KoPxy46oKIUoNZnQJ', '2023-05-07 11:17:07', '2023-05-07 11:18:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advanced_salaries`
--
ALTER TABLE `advanced_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pay_salaries`
--
ALTER TABLE `pay_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advanced_salaries`
--
ALTER TABLE `advanced_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pay_salaries`
--
ALTER TABLE `pay_salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
