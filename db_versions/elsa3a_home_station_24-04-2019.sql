-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2019 at 12:54 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elsa3a_home_station`
--

-- --------------------------------------------------------

--
-- Table structure for table `additions_cart`
--

CREATE TABLE `additions_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL,
  `addition_id` int(10) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additions_cart`
--

INSERT INTO `additions_cart` (`id`, `cart_id`, `addition_id`, `count`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 3, NULL, '2019-04-08 08:06:34', '2019-04-08 08:06:34'),
(2, 1, 4, 3, NULL, '2019-04-08 08:06:34', '2019-04-08 08:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `additions_order_service`
--

CREATE TABLE `additions_order_service` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_service_id` int(10) UNSIGNED NOT NULL,
  `addition_service_id` int(10) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `price` double NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `additions_service`
--

CREATE TABLE `additions_service` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `additions_service`
--

INSERT INTO `additions_service` (`id`, `service_id`, `name`, `price`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 2, 'بطاطس محمرة', 30, NULL, '2019-04-04 08:26:12', '2019-04-04 09:33:16'),
(4, 2, 'كول سلو', 20, NULL, '2019-04-04 08:26:12', '2019-04-04 09:33:16'),
(7, 3, 'بطاطس محمرة', 30, NULL, '2019-04-07 07:53:49', '2019-04-07 07:54:28'),
(8, 3, 'كول سلو', 20, NULL, '2019-04-07 07:53:49', '2019-04-07 07:54:28'),
(9, 3, 'بطاطس فرسكس', 40, NULL, '2019-04-07 07:54:28', '2019-04-07 07:54:28'),
(10, 4, 'بطاطس محمرة', 15, NULL, '2019-04-08 07:55:39', '2019-04-08 07:55:39'),
(11, 4, 'كول سلو', 12, NULL, '2019-04-08 07:55:39', '2019-04-08 07:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `owner_account` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `logo_bank` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `bank_name`, `owner_account`, `account_number`, `logo_bank`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'بنك فيصل الإسلامي', 'عبدالله بن عرابي', '43543646634634', '', NULL, '2019-04-09 03:11:11', '2019-04-09 03:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `booking_orders`
--

CREATE TABLE `booking_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `provider_id`, `service_id`, `count`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 15, 12, 2, 3, NULL, '2019-04-08 08:06:34', '2019-04-08 08:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` enum('products','services') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'products',
  `priority` int(11) NOT NULL DEFAULT '1',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_ar`, `name_en`, `type`, `priority`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'المأكولات', 'Food', 'products', 1, '808529_1553417612.png', NULL, '2019-03-24 06:47:21', '2019-03-24 06:53:34'),
(2, 'المنتجات المنزلية', 'Household products', 'products', 1, '303530_1553417673.png', NULL, '2019-03-24 06:54:35', '2019-03-24 06:54:35'),
(3, 'الخدمات', 'Services', 'services', 1, '353369_1553417697.png', NULL, '2019-03-24 06:54:57', '2019-03-24 06:54:57'),
(4, 'صالونات منزلية', 'Home Salons', 'services', 1, '859098_1553417727.png', NULL, '2019-03-24 06:55:28', '2019-03-24 06:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `categories_providers`
--

CREATE TABLE `categories_providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories_providers`
--

INSERT INTO `categories_providers` (`id`, `user_id`, `category_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, '2019-03-26 06:35:55', '2019-03-26 06:35:55'),
(26, 12, 1, NULL, '2019-03-26 08:02:09', '2019-03-26 08:02:09'),
(27, 12, 2, NULL, '2019-03-26 08:02:09', '2019-03-26 08:02:09'),
(28, 12, 3, NULL, '2019-03-26 08:02:09', '2019-03-26 08:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name_ar`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 1, 'الرياض', 'Riyadh', '2019-03-20 11:13:36', '2019-03-20 11:13:36'),
(2, 1, 'مكة المكرمة', 'Mecca', '2019-03-20 11:14:10', '2019-03-20 11:14:10');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8mb4_unicode_ci,
  `seen` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `name`, `mobile`, `title`, `message`, `seen`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 15, 'Baher Hilal User', '9666554654654653', 'ياخي ما بدي اكل', 'ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل', '0', NULL, '2019-04-09 11:42:36', '2019-04-09 11:42:36'),
(2, NULL, 'Baher Hilal', '96656454681654', 'ياخي ما بدي اكل', 'ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل', '0', NULL, '2019-04-09 11:42:41', '2019-04-09 11:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8mb4_unicode_ci,
  `seen` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `name`, `mobile`, `title`, `message`, `seen`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Baher Hilal', '96656454681654', 'ياخي ما بدي اكل', 'ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل', '0', NULL, '2019-03-25 07:57:33', '2019-03-25 07:57:33'),
(2, NULL, 'Baher Hilal', '96656454681654', 'ياخي ما بدي اكل', 'ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل', '0', NULL, '2019-04-09 11:37:18', '2019-04-09 11:37:18'),
(3, 15, 'Baher Hilal User', '9666554654654653', 'ياخي ما بدي اكل', 'ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل ياخي ما بدي اكل', '0', NULL, '2019-04-09 11:38:13', '2019-04-09 11:38:13');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phonecode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `flag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `short_name`, `name_ar`, `name_en`, `phonecode`, `flag`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '', 'المملكة العربية السعودية', 'Kingdom of Saudi Arabia', '966', '', NULL, '2019-03-20 10:21:32', '2019-03-20 10:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `device_type` enum('android','ios') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'android',
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `user_id`, `device_type`, `device_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'android', '66666666666666222221455', NULL, '2019-03-26 06:35:55', '2019-03-26 06:35:55'),
(2, 12, 'ios', '66666666666666222221455', NULL, '2019-04-02 11:32:19', '2019-04-02 11:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `fav_services`
--

CREATE TABLE `fav_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fav_services`
--

INSERT INTO `fav_services` (`id`, `user_id`, `service_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 15, 3, NULL, '2019-04-09 08:57:02', '2019-04-09 08:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `images_service`
--

CREATE TABLE `images_service` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images_service`
--

INSERT INTO `images_service` (`id`, `service_id`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 2, '620974_1554373574.jpg', NULL, '2019-04-04 08:26:14', '2019-04-04 08:26:14'),
(5, 3, '198980_1554630829.png', NULL, '2019-04-07 07:53:51', '2019-04-07 07:53:51'),
(6, 4, '591293_1554717339.jpg', NULL, '2019-04-08 07:55:40', '2019-04-08 07:55:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_125031_create_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2018_04_23_235802_create_report_table', 1),
(5, '2018_04_29_100555_create_category_table', 1),
(6, '2018_04_29_114808_create_subcategories_table', 1),
(7, '2018_04_30_115052_create_subcategory_tags_table', 1),
(8, '2018_11_09_104110_create_countries_table', 1),
(9, '2018_11_09_104111_create_nationalities_table', 1),
(10, '2018_11_09_104120_create_cities_table', 1),
(11, '2018_12_10_102820_create_settings_table', 1),
(12, '2018_12_10_102950_create_devices_table', 1),
(13, '2018_12_10_103022_create_notifications_table', 1),
(14, '2018_12_10_112249_create_contacts_table', 1),
(15, '2019_01_15_142035_create_providers_table', 1),
(16, '2019_01_28_102739_create_categories_providers_table', 1),
(17, '2019_04_02_114014_create_services_table', 2),
(18, '2019_04_02_114359_create_additions_service_table', 2),
(19, '2019_04_02_130806_create_images_service_table', 2),
(20, '2019_04_08_094819_create_carts_table', 3),
(21, '2019_04_08_095058_create_additions_cart_table', 3),
(22, '2019_04_09_102511_create_fav_services_table', 4),
(23, '2019_04_09_133222_create_complaints_table', 5),
(24, '2019_04_09_134615_create_bank_accounts_table', 6),
(25, '2019_04_24_082503_create_orders_table', 7),
(26, '2019_04_24_090347_create_booking_orders_table', 7),
(27, '2019_04_24_090452_create_order_services_table', 7),
(28, '2019_04_24_090506_create_additions_order_service_table', 7),
(29, '2019_04_24_104618_add_delivery_price_column_in_providers_table', 8),
(30, '2019_04_24_104725_add_type_column_in_categories_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name_ar`, `name_en`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'سعودي', 'saudi', NULL, '2019-03-20 11:38:34', '2019-03-20 11:46:41'),
(2, 'مصري', 'Egyptian', NULL, '2019-03-20 11:47:08', '2019-03-20 11:47:08');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `key_id` int(11) NOT NULL DEFAULT '0',
  `msg_ar` text COLLATE utf8mb4_unicode_ci,
  `msg_en` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `delegate_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `order_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client_waiting',
  `delivery_price` double NOT NULL DEFAULT '0',
  `total_order_price` double NOT NULL DEFAULT '0',
  `app_precentage_from_provider` double NOT NULL DEFAULT '0',
  `book_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_services`
--

CREATE TABLE `order_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `price` double NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `nationality_id` int(11) NOT NULL DEFAULT '0',
  `store_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `minimum_charge` double NOT NULL DEFAULT '0',
  `delivery_price` double NOT NULL DEFAULT '0',
  `opening_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `closing_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rate_avg` double NOT NULL DEFAULT '0',
  `commercial_register_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`id`, `user_id`, `nationality_id`, `store_name`, `minimum_charge`, `delivery_price`, `opening_time`, `closing_time`, `rate_avg`, `commercial_register_number`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 3, 2, 'Test Store', 10, 10, '08:30', '18:30', 0, '154646546', NULL, '2019-03-26 06:35:55', '2019-03-26 06:35:55'),
(11, 12, 1, 'Orabi Store2', 10, 10, '08:30', '18:30', 0, '147852369963', NULL, '2019-03-26 08:02:09', '2019-04-01 07:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `key_id` int(11) NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(10) UNSIGNED NOT NULL,
  `event` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `role_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `plan` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_ar`, `role_en`, `plan`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'مستخدم', 'user', '', NULL, NULL, NULL),
(2, 'مدير عام', 'Super Admin', '*', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `category_provider_id` int(10) UNSIGNED NOT NULL,
  `subcategory_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `has_offer` enum('no','yes') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `offer_price` double NOT NULL DEFAULT '0',
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `far_enough` int(11) NOT NULL DEFAULT '0',
  `execution_time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `availability` enum('available','unavailable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `provider_id`, `category_id`, `category_provider_id`, `subcategory_id`, `name`, `price`, `has_offer`, `offer_price`, `lat`, `lng`, `far_enough`, `execution_time`, `availability`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 12, 1, 26, 1, 'كيلو كباب مشوي جديد', 150, 'yes', 10, '', '', 4, 'ساعة ونصف', 'available', 'كباب محمر وزي الفل يا كبير احلى من السمك مفيش', NULL, '2019-04-04 08:26:12', '2019-04-07 08:14:36'),
(3, 12, 1, 26, 1, 'كيلو كباب مشوي جديد', 150, 'no', 0, '', '', 4, 'ساعة ونصف', 'unavailable', 'كباب محمر وزي الفل يا كبير احلى من السمك مفيش', NULL, '2019-04-07 07:53:49', '2019-04-07 07:54:27'),
(4, 12, 1, 26, 1, 'نصف كيلو كباب مشوي', 150, 'no', 0, '', '', 3, 'ساعة ونصف', 'available', 'كباب محمر وزي الفل يا كبير احلى من السمك مفيش', NULL, '2019-04-08 07:55:39', '2019-04-08 07:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'app_lang', 'ar', NULL, NULL, NULL),
(2, 'mobile', '', NULL, NULL, NULL),
(3, 'email', '', NULL, NULL, NULL),
(4, 'facebook_url', '', NULL, NULL, NULL),
(5, 'twitter_url', '', NULL, NULL, NULL),
(6, 'youtube_url', '', NULL, NULL, NULL),
(7, 'instagram_url', '', NULL, NULL, NULL),
(8, 'whatsapp_phone', '', NULL, NULL, NULL),
(9, 'about_ar', 'عن التطبيق باللغة العربية', NULL, NULL, '2019-03-25 08:49:08'),
(10, 'about_en', 'عن التطبيق باللغة الإنجليزية *', NULL, NULL, '2019-03-25 08:49:08'),
(11, 'policy_terms_ar', 'الشروط والأحكام باللغة العربية *', NULL, NULL, '2019-03-25 08:49:08'),
(12, 'policy_terms_en', 'الشروط والأحكام باللغة الإنجليزية *', NULL, NULL, '2019-03-25 08:49:08'),
(13, 'num_of_search_km_for_provider', '', NULL, NULL, NULL),
(14, 'app_precentage_from_provider', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '1',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name_ar`, `name_en`, `priority`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'المشويات', 'Grills', 1, '293827_1553434579.jpeg', NULL, '2019-03-24 09:22:09', '2019-03-24 11:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory_tags`
--

CREATE TABLE `subcategory_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `subcategory_id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `type` enum('admin','user','provider','delegate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL DEFAULT '0',
  `nationality_id` int(11) NOT NULL DEFAULT '0',
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` enum('deactive','active_mobile','active') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `banned` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `ban_reason` text COLLATE utf8mb4_unicode_ci,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `lang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ar',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `type`, `username`, `fullname`, `mobile`, `email`, `email_verified_at`, `password`, `city_id`, `nationality_id`, `lat`, `lng`, `active`, `banned`, `ban_reason`, `avatar`, `code`, `lang`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'admin', 'abd.orabi94', '', '9669961023624205', 'abd.asaad1994@gmail.com', NULL, '$2y$10$tcEpIO3MOxeJZeekdxFQKe4YXrJ81.IACDZv/jyxxwMlKmWtzbEuS', 1, 0, '', '', 'active', '0', NULL, '735059_1553435152.png', '', 'ar', 'QY8CuQDGnTyaOUsbvqRlQvfnXcKornyrJnevKxPNKCWm1FNA0nKYZ5C4DXor', NULL, NULL, '2019-04-23 07:48:08'),
(3, 1, 'provider', 'Baher Hilal', '', '96665456445451', '', NULL, '$2y$10$8k.hZ3iwAhEBgY6OWU7f3.2FHjJWO6r1ftiT4mZjBE8lOIh2llxo.', 1, 2, '24.7323736', '46.7764813', 'deactive', '0', NULL, '883571_1553589353.png', '795332', 'ar', NULL, NULL, '2019-03-26 06:35:55', '2019-03-26 06:35:55'),
(12, 1, 'provider', 'Abdallah Orabi', '', '966123654789', 'orabi.test@gmail.com', NULL, '$2y$10$iDuTg6DOKurtXoIXtMR3GOKLPXYfzKjHgle4StJoyIITN1RQ3LD76', 1, 2, '24.7323736', '46.7764813', 'active', '0', NULL, '735948_1553590151.jpg', '', 'ar', NULL, NULL, '2019-03-26 08:02:09', '2019-04-01 07:51:02'),
(15, 1, 'user', 'Baher Hilal User', '', '9666554654654653', '', NULL, '$2y$10$qIQszFVLUa31I108GkhkaugVagtsHFj.Imndm7juMMNz8uDgo0Co6', 1, 0, '24.765895', '46.7613257', 'active', '0', NULL, '644978_1554114202.png', '', 'ar', NULL, NULL, '2019-04-01 07:59:43', '2019-04-01 08:27:17'),
(16, 1, 'delegate', 'Baher Hilal Delegate', '', '9666515455', '', NULL, '$2y$10$ukXHCCBvkfZaNv7nyOTyq.lOL6Phaia/DSm2.5TIQXHJrmzCZZScu', 1, 0, '24.765895', '46.7613257', 'active', '0', NULL, NULL, '', 'ar', NULL, NULL, '2019-04-23 06:24:15', '2019-04-23 07:12:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additions_cart`
--
ALTER TABLE `additions_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `additions_cart_cart_id_foreign` (`cart_id`),
  ADD KEY `additions_cart_addition_id_foreign` (`addition_id`);

--
-- Indexes for table `additions_order_service`
--
ALTER TABLE `additions_order_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `additions_order_service_order_service_id_foreign` (`order_service_id`),
  ADD KEY `additions_order_service_addition_service_id_foreign` (`addition_service_id`);

--
-- Indexes for table `additions_service`
--
ALTER TABLE `additions_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `additions_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_orders`
--
ALTER TABLE `booking_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_orders_order_id_foreign` (`order_id`),
  ADD KEY `booking_orders_service_id_foreign` (`service_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_provider_id_foreign` (`provider_id`),
  ADD KEY `carts_service_id_foreign` (`service_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_providers`
--
ALTER TABLE `categories_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_providers_user_id_foreign` (`user_id`),
  ADD KEY `categories_providers_category_id_foreign` (`category_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devices_user_id_foreign` (`user_id`);

--
-- Indexes for table `fav_services`
--
ALTER TABLE `fav_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fav_services_user_id_foreign` (`user_id`),
  ADD KEY `fav_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `images_service`
--
ALTER TABLE `images_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_service_service_id_foreign` (`service_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_provider_id_foreign` (`provider_id`),
  ADD KEY `orders_delegate_id_foreign` (`delegate_id`),
  ADD KEY `orders_category_id_foreign` (`category_id`);

--
-- Indexes for table `order_services`
--
ALTER TABLE `order_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_services_order_id_foreign` (`order_id`),
  ADD KEY `order_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `providers_user_id_foreign` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_provider_id_foreign` (`provider_id`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `services_category_provider_id_foreign` (`category_provider_id`),
  ADD KEY `services_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `subcategory_tags`
--
ALTER TABLE `subcategory_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategory_tags_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additions_cart`
--
ALTER TABLE `additions_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `additions_order_service`
--
ALTER TABLE `additions_order_service`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `additions_service`
--
ALTER TABLE `additions_service`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booking_orders`
--
ALTER TABLE `booking_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories_providers`
--
ALTER TABLE `categories_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fav_services`
--
ALTER TABLE `fav_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images_service`
--
ALTER TABLE `images_service`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_services`
--
ALTER TABLE `order_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategory_tags`
--
ALTER TABLE `subcategory_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additions_cart`
--
ALTER TABLE `additions_cart`
  ADD CONSTRAINT `additions_cart_addition_id_foreign` FOREIGN KEY (`addition_id`) REFERENCES `additions_service` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `additions_cart_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `additions_order_service`
--
ALTER TABLE `additions_order_service`
  ADD CONSTRAINT `additions_order_service_addition_service_id_foreign` FOREIGN KEY (`addition_service_id`) REFERENCES `additions_service` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `additions_order_service_order_service_id_foreign` FOREIGN KEY (`order_service_id`) REFERENCES `order_services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `additions_service`
--
ALTER TABLE `additions_service`
  ADD CONSTRAINT `additions_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_orders`
--
ALTER TABLE `booking_orders`
  ADD CONSTRAINT `booking_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories_providers`
--
ALTER TABLE `categories_providers`
  ADD CONSTRAINT `categories_providers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fav_services`
--
ALTER TABLE `fav_services`
  ADD CONSTRAINT `fav_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fav_services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `images_service`
--
ALTER TABLE `images_service`
  ADD CONSTRAINT `images_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_delegate_id_foreign` FOREIGN KEY (`delegate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_services`
--
ALTER TABLE `order_services`
  ADD CONSTRAINT `order_services_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `providers`
--
ALTER TABLE `providers`
  ADD CONSTRAINT `providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_category_provider_id_foreign` FOREIGN KEY (`category_provider_id`) REFERENCES `categories_providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategory_tags`
--
ALTER TABLE `subcategory_tags`
  ADD CONSTRAINT `subcategory_tags_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
