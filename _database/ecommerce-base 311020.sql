-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2020 at 07:51 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce-base`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(32) NOT NULL DEFAULT 'UNREAD'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `sender_id`, `receiver_id`, `content`, `time`, `status`) VALUES
(1, 1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2020-05-02 23:21:42', 'READ'),
(2, 1, 2, 'Hello, kok ga dibales?', '2020-05-02 23:21:42', 'READ'),
(3, 1, 2, 'P', '2020-05-02 23:21:42', 'READ'),
(5, 2, 1, 'Maaf, saya ketiduran', '2020-05-02 23:21:42', 'READ'),
(18, 1, 1, 'cek second attempt', '2020-05-02 23:21:42', 'READ'),
(17, 2, 1, 'Jadi gimana?', '2020-05-02 23:21:42', 'READ'),
(16, 1, 2, 'Oke sekarang oke', '2020-05-02 23:21:42', 'READ'),
(22, 1, 2, 'Kamu tau ga apa yang oke?', '2020-05-02 23:21:42', 'READ'),
(23, 2, 1, 'Apa itu bos?', '2020-05-02 23:21:42', 'READ'),
(24, 1, 2, 'Rahasia dong', '2020-05-02 23:21:42', 'READ'),
(25, 1, 2, 'Lagi apa?', '2020-05-02 23:21:42', 'READ'),
(26, 1, 2, 'Halo kok ga bels?', '2020-05-02 23:21:42', 'READ'),
(27, 1, 2, 'Ini kok bisa ya?', '2020-05-02 23:21:42', 'READ'),
(28, 2, 1, 'Apanya bos?', '2020-05-02 23:21:42', 'READ'),
(29, 2, 1, 'Hallo bos aman?', '2020-05-02 23:21:42', 'READ'),
(30, 2, 1, 'Kok ga bales bos?', '2020-05-02 23:21:42', 'READ'),
(31, 1, 2, 'sabar', '2020-05-02 23:21:42', 'READ'),
(32, 1, 2, 'Cek', '2020-05-02 23:21:42', 'READ'),
(33, 1, 2, 'Halo bagaimana kabarnya?', '2020-05-02 23:21:42', 'READ'),
(34, 1, 2, 'COba cek algi ya', '2020-05-02 23:21:42', 'READ'),
(35, 1, 2, 'Maaf saya typo', '2020-05-02 23:21:42', 'READ'),
(36, 1, 2, 'Bentar ya', '2020-05-02 23:21:42', 'READ'),
(37, 1, 2, 'Halo ', '2020-05-02 23:21:42', 'READ'),
(38, 1, 2, 'Oi', '2020-05-02 23:21:42', 'READ'),
(39, 1, 2, 'Oi', '2020-05-02 23:21:42', 'READ'),
(40, 1, 2, 'Halo ndan?', '2020-05-02 23:21:42', 'READ'),
(41, 1, 2, 'Ini saya chat lho', '2020-05-02 23:21:42', 'READ'),
(42, 1, 2, 'Bales dong', '2020-05-02 23:21:42', 'READ'),
(43, 2, 1, 'Iya ada apa bos?', '2020-05-02 23:21:42', 'READ'),
(44, 2, 1, 'Halo bos aman?', '2020-05-02 23:21:42', 'READ'),
(45, 1, 2, 'Sorry gimana', '2020-05-02 23:21:42', 'READ'),
(46, 2, 1, 'apa', '2020-05-02 23:21:42', 'READ'),
(47, 2, 1, 'hoi', '2020-05-02 23:21:42', 'READ'),
(48, 2, 1, 'test', '2020-05-02 23:21:42', 'READ'),
(49, 1, 2, 'bacot', '2020-05-02 23:21:42', 'READ'),
(50, 1, 2, 'Apa kabs?', '2020-05-02 23:22:42', 'READ'),
(51, 2, 1, 'Baik bos', '2020-05-04 11:54:35', 'READ'),
(52, 1, 2, 'turut senang', '2020-05-04 12:27:32', 'UNREAD');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `color_code` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `color_code`) VALUES
(1, 'bg-gray', '#d2d6de'),
(2, 'bg-red', '#dd4b39'),
(3, 'bg-yellow', '#f39c12'),
(4, 'bg-aqua', '#00c0ef'),
(5, 'bg-blue', '#0073b7'),
(6, 'bg-light-blue', '#3c8dbc'),
(7, 'bg-green', '#00a65a'),
(8, 'bg-navy', '#001F3F'),
(10, 'bg-teal', '#39CCCC'),
(11, 'bg-olive', '#3D9970'),
(12, 'bg-lime', '#01FF70'),
(13, 'bg-orange', '#FF851B'),
(14, 'bg-fuchsia', '#F012BE'),
(15, 'bg-purple', '#605ca8'),
(16, 'bg-maroon', '#D81B60');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comment` longtext NOT NULL,
  `is_hide` tinyint(1) NOT NULL,
  `is_reply` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comment_replys`
--

CREATE TABLE `comment_replys` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comment_reply` longtext NOT NULL,
  `is_hide` tinyint(1) NOT NULL,
  `is_reply` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(11) NOT NULL,
  `company_name` varchar(64) NOT NULL,
  `business_email` varchar(128) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `address` text NOT NULL,
  `about` longtext NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `company_name`, `business_email`, `phone`, `address`, `about`, `image`) VALUES
(1, 'Sandang Store', '111201408226@mhs.dinus.ac.id', '089654789124', 'Jl. Yudistira No.5, Pendrikan Kidul, Kec. Semarang Tengah, Kota Semarang, Jawa Tengah 50131', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '7f0b2fe113b35e17c1375638ee779aae.png');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_address`
--

CREATE TABLE `company_profile_address` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `province` varchar(32) NOT NULL,
  `city_id` int(11) NOT NULL,
  `city_name` varchar(32) NOT NULL,
  `street_name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile_address`
--

INSERT INTO `company_profile_address` (`id`, `company_profile_id`, `province_id`, `province`, `city_id`, `city_name`, `street_name`) VALUES
(9, 1, 10, 'Jawa Tengah', 399, 'Semarang (Kota)', 'Jl. Yudistira No.5, Pendrikan Kidul, Kec. Semarang Tengah');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_banks`
--

CREATE TABLE `company_profile_banks` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `bank_name` varchar(32) NOT NULL,
  `account` varchar(32) NOT NULL,
  `account_holder_name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile_banks`
--

INSERT INTO `company_profile_banks` (`id`, `company_profile_id`, `bank_name`, `account`, `account_holder_name`) VALUES
(7, 1, 'BCA', '998435667', 'Rizky Rahmadianto'),
(8, 1, 'BNI', '677322671', 'Darth Vader');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_charge_value`
--

CREATE TABLE `company_profile_charge_value` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `service_charge_value` int(11) NOT NULL,
  `vat_charge_value` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile_charge_value`
--

INSERT INTO `company_profile_charge_value` (`id`, `company_profile_id`, `service_charge_value`, `vat_charge_value`) VALUES
(2, 1, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_detail`
--

CREATE TABLE `company_profile_detail` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile_detail`
--

INSERT INTO `company_profile_detail` (`id`, `company_profile_id`, `link_id`, `url`) VALUES
(9, 1, 3, 'https://twitter.com/RR_Rizky'),
(8, 1, 1, 'https://www.facebook.com/rizky.rahmadianto');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile_email`
--

CREATE TABLE `company_profile_email` (
  `id` int(11) NOT NULL,
  `company_profile_id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_profile_email`
--

INSERT INTO `company_profile_email` (`id`, `company_profile_id`, `email`, `password`) VALUES
(1, 1, '111201408226@mhs.dinus.ac.id', 'yourpassword');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id_customer` varchar(128) NOT NULL,
  `customer_name` varchar(128) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_phone` varchar(16) NOT NULL,
  `customer_birth_date` date DEFAULT NULL,
  `gender_id` int(8) NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_image` varchar(255) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `is_online` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id_customer`, `customer_name`, `customer_address`, `customer_phone`, `customer_birth_date`, `gender_id`, `customer_email`, `customer_password`, `customer_image`, `is_active`, `created_at`, `is_online`) VALUES
('CUST-0820-11111', 'Rizky', 'Jalan Customer Agan 005/006 No. 3', '089123456789', '2001-02-13', 2, 'rizkyrahmadianto18@gmail.com', '$2y$10$E3wQdGaPbynvhwKtHZwRLOTPOkKY5fWII7jq09ycRQFZFAAMKUn/S', 'default.png', 1, '2020-08-09 16:09:18', 1),
('CUST-0820-143617', 'Rizky Rahmadianto', '', '089123645879', '1996-10-03', 2, 'rahmadianto018@gmail.com', '$2y$10$KHfYi4rc1xB36hZF21lk4O89jZxqnPOvOh2qgp7sm9HSlVbHi/PEy', 'bef1de5098093e7bcb089bfb9bf67f86.png', 1, '2020-08-11 14:36:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `province_id` varchar(64) NOT NULL,
  `province` varchar(32) NOT NULL,
  `city_id` varchar(64) NOT NULL,
  `city_name` varchar(32) NOT NULL,
  `street_name` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`id`, `email`, `province_id`, `province`, `city_id`, `city_name`, `street_name`) VALUES
(7, 'rizkyrahmadianto18@gmail.com', '6', 'DKI Jakarta', '153', 'Jakarta Selatan (Kota)', 'Is simply dummy text of the printing and typesetting industry'),
(8, 'rahmadianto018@gmail.com', '11', 'Jawa Timur', '256', 'Malang (Kota)', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry');

-- --------------------------------------------------------

--
-- Table structure for table `customer_carts`
--

CREATE TABLE `customer_carts` (
  `id` varchar(128) NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `product_id` varchar(128) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_comments`
--

CREATE TABLE `customer_comments` (
  `id` varchar(32) NOT NULL,
  `product_id` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `rating` int(16) NOT NULL,
  `message` longtext NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_update_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_comments`
--

INSERT INTO `customer_comments` (`id`, `product_id`, `email`, `rating`, `message`, `comment_date`, `comment_update_date`) VALUES
('0920-CMNT-140651', 'PRDCT-0820-003451', 'rizkyrahmadianto18@gmail.com', 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2020-09-18 14:07:04', '2020-10-20 22:12:25'),
('0920-CMNT-135726', 'PRDCT-0820-003722', 'rahmadianto018@gmail.com', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2020-09-05 13:58:45', NULL),
('0920-CMNT-140527', 'PRDCT-0820-003058', 'rizkyrahmadianto18@gmail.com', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2020-09-18 14:06:23', '2020-10-20 22:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `customer_comment_details`
--

CREATE TABLE `customer_comment_details` (
  `id` int(11) NOT NULL,
  `comment_id` varchar(32) NOT NULL,
  `image` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_comment_details`
--

INSERT INTO `customer_comment_details` (`id`, `comment_id`, `image`, `info`, `token`) VALUES
(174, '0920-CMNT-135726', '22e9c66653b15bbe6fbf7f5a26f3cd28.png', '153187', '0.7550073758281453'),
(170, '0920-CMNT-135726', 'a566b975d1a1957948e693d9c7a12515.png', '209715', '0.5203233933727047'),
(171, '0920-CMNT-135726', 'd63ac9cc8b7fcee602126ac54ae418f3.png', '185477', '0.6789252855581398'),
(172, '0920-CMNT-135726', '381769662a04af8544eb70ab65a06856.png', '166634', '0.2648594836512028'),
(173, '0920-CMNT-135726', '4f66fe0e7b3e028f0d45f33f84ca64b5.png', '178211', '0.23459726960584337'),
(216, '0920-CMNT-140527', 'b40868e817d08966ac1dba9f5fe2979f.jpg', '32622', '0.8058910419521248'),
(219, '0920-CMNT-140527', 'aaf78bca4ca85f7f0f5cc9cf51145cd3.jpg', '70418', '0.9727497988695619');

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_orders`
--

CREATE TABLE `customer_purchase_orders` (
  `id` varchar(32) NOT NULL,
  `invoice_order` varchar(32) NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `purchase_order_date` int(11) NOT NULL,
  `gross_amount` int(11) NOT NULL,
  `ship_amount` int(11) NOT NULL,
  `vat_charge_rate` int(11) NOT NULL,
  `vat_charge_val` int(11) NOT NULL,
  `vat_charge` int(11) NOT NULL,
  `coupon_charge_rate` int(11) NOT NULL,
  `coupon_charge` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `status_order_id` int(11) NOT NULL,
  `reminder_payment` smallint(1) NOT NULL,
  `reminder_cancel` smallint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_purchase_orders`
--

INSERT INTO `customer_purchase_orders` (`id`, `invoice_order`, `customer_email`, `purchase_order_date`, `gross_amount`, `ship_amount`, `vat_charge_rate`, `vat_charge_val`, `vat_charge`, `coupon_charge_rate`, `coupon_charge`, `net_amount`, `created_date`, `updated_date`, `status_order_id`, `reminder_payment`, `reminder_cancel`) VALUES
('O-002748', '311020-OP-002748', 'rizkyrahmadianto18@gmail.com', 1604078868, 395000, 14000, 10, 39500, 448500, 0, 0, 448500, '2020-10-31 00:27:48', '0000-00-00 00:00:00', 1, 1, 1),
('O-163257', '301020-OP-163257', 'rahmadianto018@gmail.com', 1604050377, 1445000, 16000, 10, 144500, 1605500, 0, 0, 1605500, '2020-10-30 16:32:57', '0000-00-00 00:00:00', 2, 1, 0),
('O-123742', '291020-OP-123742', 'rahmadianto018@gmail.com', 1603949862, 1195000, 16000, 10, 119500, 1330500, 0, 0, 1330500, '2020-10-29 12:37:42', '0000-00-00 00:00:00', 4, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_order_approves`
--

CREATE TABLE `customer_purchase_order_approves` (
  `id` int(11) NOT NULL,
  `purchase_order_id` varchar(64) NOT NULL,
  `approve_date` datetime NOT NULL,
  `image` varchar(255) NOT NULL,
  `responsible_admin` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_purchase_order_approves`
--

INSERT INTO `customer_purchase_order_approves` (`id`, `purchase_order_id`, `approve_date`, `image`, `responsible_admin`) VALUES
(9, 'O-123742', '2020-10-29 14:22:08', 'c4d594df591a545b09745868b89c9786.jpg', 'admin@adminstore.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_order_details`
--

CREATE TABLE `customer_purchase_order_details` (
  `id` int(11) NOT NULL,
  `purchase_order_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `weight` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `status_order_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_purchase_order_details`
--

INSERT INTO `customer_purchase_order_details` (`id`, `purchase_order_id`, `product_id`, `weight`, `qty`, `unit_price`, `amount`, `status_order_id`) VALUES
(18, 'O-163257', 'PRDCT-0820-003058', 200, 2, 500000, 1000000, 2),
(17, 'O-163257', 'PRDCT-0820-001521', 200, 1, 445000, 445000, 2),
(16, 'O-123742', 'PRDCT-0820-003451', 200, 1, 345000, 345000, 2),
(15, 'O-123742', 'PRDCT-0820-001900', 200, 1, 850000, 850000, 2),
(19, 'O-002748', 'PRDCT-0820-001626', 200, 1, 395000, 395000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_order_shipping`
--

CREATE TABLE `customer_purchase_order_shipping` (
  `id` int(11) NOT NULL,
  `purchase_order_id` varchar(64) NOT NULL,
  `courier` varchar(64) NOT NULL,
  `service` varchar(64) NOT NULL,
  `etd` varchar(16) NOT NULL,
  `delivery_receipt_number` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_purchase_order_shipping`
--

INSERT INTO `customer_purchase_order_shipping` (`id`, `purchase_order_id`, `courier`, `service`, `etd`, `delivery_receipt_number`) VALUES
(10, 'O-123742', 'jne', 'Layanan Reguler (REG)', '1-2', '1242353464579'),
(11, 'O-163257', 'jne', 'Layanan Reguler (REG)', '1-2', NULL),
(12, 'O-002748', 'pos', 'Paket Kilat Khusus (Paket Kilat Khusus)', '1-2 HARI', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_returns`
--

CREATE TABLE `customer_purchase_returns` (
  `id` varchar(32) NOT NULL,
  `invoice_return` varchar(32) NOT NULL,
  `purchase_order_id` varchar(32) NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `purchase_return_date` datetime NOT NULL,
  `gross_amount` int(11) NOT NULL,
  `ship_amount` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `information` text NOT NULL,
  `status_order_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_purchase_returns`
--

INSERT INTO `customer_purchase_returns` (`id`, `invoice_return`, `purchase_order_id`, `customer_email`, `purchase_return_date`, `gross_amount`, `ship_amount`, `net_amount`, `information`, `status_order_id`, `created_date`, `updated_date`) VALUES
('R-103744', '021020-OR-103744', 'O-103744', 'customer@adminstore.com', '2020-10-02 20:43:21', 445000, 0, 445000, 'Rusak', 2, '2020-10-02 20:43:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_return_details`
--

CREATE TABLE `customer_purchase_return_details` (
  `id` int(11) NOT NULL,
  `purchase_return_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `weight` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `information` text NOT NULL,
  `status_order_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_purchase_return_details`
--

INSERT INTO `customer_purchase_return_details` (`id`, `purchase_return_id`, `product_id`, `weight`, `qty`, `unit_price`, `amount`, `information`, `status_order_id`) VALUES
(1, 'R-103744', 'PRDCT-0820-003722', 0, 1, 445000, 445000, 'Rusak', 2);

-- --------------------------------------------------------

--
-- Table structure for table `customer_purchase_return_shipping`
--

CREATE TABLE `customer_purchase_return_shipping` (
  `id` int(11) NOT NULL,
  `purchase_return_id` varchar(32) NOT NULL,
  `courier` varchar(32) NOT NULL,
  `service` varchar(32) NOT NULL,
  `etd` varchar(16) NOT NULL,
  `delivery_receipt_number` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_token`
--

CREATE TABLE `customer_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_wishlists`
--

CREATE TABLE `customer_wishlists` (
  `id` int(11) NOT NULL,
  `customer_email` varchar(128) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_wishlists`
--

INSERT INTO `customer_wishlists` (`id`, `customer_email`, `product_id`, `created_at`) VALUES
(34, 'rahmadianto018@gmail.com', 'PRDCT-0820-003802', '2020-08-18 13:44:52'),
(28, 'rahmadianto018@gmail.com', 'PRDCT-0820-003415', '2020-08-18 00:35:32'),
(29, 'rahmadianto018@gmail.com', 'PRDCT-0820-003451', '2020-08-18 00:35:54'),
(30, 'rahmadianto018@gmail.com', 'PRDCT-0420-085449', '2020-08-18 00:36:05'),
(31, 'rahmadianto018@gmail.com', 'PRDCT-0820-001521', '2020-08-18 13:32:12'),
(125, 'customer@adminstore.com', 'PRDCT-0820-000131', '2020-09-16 23:55:59'),
(123, 'customer@adminstore.com', 'PRDCT-0820-000321', '2020-09-16 23:50:55'),
(124, 'customer@adminstore.com', 'PRDCT-0820-000504', '2020-09-16 23:53:21'),
(117, 'customer@adminstore.com', 'PRDCT-0820-003722', '2020-09-16 23:34:11'),
(82, 'customer@adminstore.com', 'PRDCT-0820-003802', '2020-09-16 20:55:27'),
(126, 'customer@adminstore.com', 'PRDCT-0820-001521', '2020-10-21 15:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `dashboards`
--

CREATE TABLE `dashboards` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `class_id_number` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dashboards`
--

INSERT INTO `dashboards` (`id`, `title`, `url`, `class_id_number`) VALUES
(1, 'Net Sales', NULL, 'net-sales'),
(2, 'Net Purchase', NULL, 'net-purchase'),
(3, 'Goods Available for Sale', NULL, 'goods-available-for-sale'),
(4, 'Cost of Goods Sold', NULL, 'cost-of-goods-sold'),
(5, 'User Count', NULL, 'user-count'),
(6, 'User Online', NULL, 'user-online'),
(7, 'Total Product', NULL, 'total-product'),
(8, 'Total Product Sold', NULL, 'total-product-sold'),
(9, 'Total Product Return', NULL, 'total-product-return');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_details`
--

CREATE TABLE `dashboard_details` (
  `id` int(11) NOT NULL,
  `detail_dash_id` int(11) NOT NULL,
  `icon_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dashboard_details`
--

INSERT INTO `dashboard_details` (`id`, `detail_dash_id`, `icon_id`, `color_id`) VALUES
(17, 1, 208, 11),
(14, 2, 581, 10),
(15, 3, 194, 7),
(16, 4, 726, 3),
(18, 5, 735, 8),
(19, 6, 241, 12),
(27, 7, 194, 16);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `color` varchar(32) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `color`, `start_date`, `end_date`, `description`) VALUES
(49, '5', '#008000', '2020-05-05 12:00:00', '2020-05-06 12:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(50, '12', '#008000', '2020-05-14 12:00:00', '2020-05-15 12:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(51, '19', '#FF0000', '2020-05-19 12:00:00', '2020-05-20 12:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(52, '26', '#FF0000', '2020-05-26 12:00:00', '2020-05-27 12:00:00', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

-- --------------------------------------------------------

--
-- Table structure for table `fontawesomes`
--

CREATE TABLE `fontawesomes` (
  `id` int(1) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `value` varchar(64) DEFAULT NULL,
  `unicode` varchar(16) DEFAULT NULL,
  `unicodename` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fontawesomes`
--

INSERT INTO `fontawesomes` (`id`, `name`, `value`, `unicode`, `unicodename`) VALUES
(1, 'fa-500px', 'fa fa-500px', '&#xf26e;', '&#xf26e; fa-500px'),
(2, 'fa-address-book', 'fa fa-address-book', '&#xf2b9;', '&#xf2b9; fa-address-book'),
(3, 'fa-address-book-o', 'fa fa-address-book-o', '&#xf2ba;', '&#xf2ba; fa-address-book-o'),
(4, 'fa-address-card', 'fa fa-address-card', '&#xf2bb;', '&#xf2bb; fa-address-card'),
(5, 'fa-address-card-o', 'fa fa-address-card-o', '&#xf2bc;', '&#xf2bc; fa-address-card-o'),
(6, 'fa-adjust', 'fa fa-adjust', '&#xf042;', '&#xf042; fa-adjust'),
(7, 'fa-adn', 'fa fa-adn', '&#xf170;', '&#xf170; fa-adn'),
(8, 'fa-align-center', 'fa fa-align-center', '&#xf037;', '&#xf037; fa-align-center'),
(9, 'fa-align-justify', 'fa fa-align-justify', '&#xf039;', '&#xf039; fa-align-justify'),
(10, 'fa-align-left', 'fa fa-align-left', '&#xf036;', '&#xf036; fa-align-left'),
(11, 'fa-align-right', 'fa fa-align-right', '&#xf038;', '&#xf038; fa-align-right'),
(12, 'fa-amazon', 'fa fa-amazon', '&#xf270;', '&#xf270; fa-amazon'),
(13, 'fa-ambulance', 'fa fa-ambulance', '&#xf0f9;', '&#xf0f9; fa-ambulance'),
(14, 'fa-american-sign-language-interpreting', 'fa fa-american-sign-language-interpreting', '&#xf2a3;', '&#xf2a3; fa-american-sign-language-interpreting'),
(15, 'fa-anchor', 'fa fa-anchor', '&#xf13d;', '&#xf13d; fa-anchor'),
(16, 'fa-android', 'fa fa-android', '&#xf17b;', '&#xf17b; fa-android'),
(17, 'fa-angellist', 'fa fa-angellist', '&#xf209;', '&#xf209; fa-angellist'),
(18, 'fa-angle-double-down', 'fa fa-angle-double-down', '&#xf103;', '&#xf103; fa-angle-double-down'),
(19, 'fa-angle-double-left', 'fa fa-angle-double-left', '&#xf100;', '&#xf100; fa-angle-double-left'),
(20, 'fa-angle-double-right', 'fa fa-angle-double-right', '&#xf101;', '&#xf101; fa-angle-double-right'),
(21, 'fa-angle-double-up', 'fa fa-angle-double-up', '&#xf102;', '&#xf102; fa-angle-double-up'),
(22, 'fa-angle-down', 'fa fa-angle-down', '&#xf107;', '&#xf107; fa-angle-down'),
(23, 'fa-angle-left', 'fa fa-angle-left', '&#xf104;', '&#xf104; fa-angle-left'),
(24, 'fa-angle-right', 'fa fa-angle-right', '&#xf105;', '&#xf105; fa-angle-right'),
(25, 'fa-angle-up', 'fa fa-angle-up', '&#xf106;', '&#xf106; fa-angle-up'),
(26, 'fa-apple', 'fa fa-apple', '&#xf179;', '&#xf179; fa-apple'),
(27, 'fa-archive', 'fa fa-archive', '&#xf187;', '&#xf187; fa-archive'),
(28, 'fa-area-chart', 'fa fa-area-chart', '&#xf1fe;', '&#xf1fe; fa-area-chart'),
(29, 'fa-arrow-circle-down', 'fa fa-arrow-circle-down', '&#xf0ab;', '&#xf0ab; fa-arrow-circle-down'),
(30, 'fa-arrow-circle-left', 'fa fa-arrow-circle-left', '&#xf0a8;', '&#xf0a8; fa-arrow-circle-left'),
(31, 'fa-arrow-circle-o-down', 'fa fa-arrow-circle-o-down', '&#xf01a;', '&#xf01a; fa-arrow-circle-o-down'),
(32, 'fa-arrow-circle-o-left', 'fa fa-arrow-circle-o-left', '&#xf190;', '&#xf190; fa-arrow-circle-o-left'),
(33, 'fa-arrow-circle-o-right', 'fa fa-arrow-circle-o-right', '&#xf18e;', '&#xf18e; fa-arrow-circle-o-right'),
(34, 'fa-arrow-circle-o-up', 'fa fa-arrow-circle-o-up', '&#xf01b;', '&#xf01b; fa-arrow-circle-o-up'),
(35, 'fa-arrow-circle-right', 'fa fa-arrow-circle-right', '&#xf0a9;', '&#xf0a9; fa-arrow-circle-right'),
(36, 'fa-arrow-circle-up', 'fa fa-arrow-circle-up', '&#xf0aa;', '&#xf0aa; fa-arrow-circle-up'),
(37, 'fa-arrow-down', 'fa fa-arrow-down', '&#xf063;', '&#xf063; fa-arrow-down'),
(38, 'fa-arrow-left', 'fa fa-arrow-left', '&#xf060;', '&#xf060; fa-arrow-left'),
(39, 'fa-arrow-right', 'fa fa-arrow-right', '&#xf061;', '&#xf061; fa-arrow-right'),
(40, 'fa-arrow-up', 'fa fa-arrow-up', '&#xf062;', '&#xf062; fa-arrow-up'),
(41, 'fa-arrows', 'fa fa-arrows', '&#xf047;', '&#xf047; fa-arrows'),
(42, 'fa-arrows-alt', 'fa fa-arrows-alt', '&#xf0b2;', '&#xf0b2; fa-arrows-alt'),
(43, 'fa-arrows-h', 'fa fa-arrows-h', '&#xf07e;', '&#xf07e; fa-arrows-h'),
(44, 'fa-arrows-v', 'fa fa-arrows-v', '&#xf07d;', '&#xf07d; fa-arrows-v'),
(45, 'fa-asl-interpreting', 'fa fa-asl-interpreting', '&#xf2a3;', '&#xf2a3; fa-asl-interpreting'),
(46, 'fa-assistive-listening-systems', 'fa fa-assistive-listening-systems', '&#xf2a2;', '&#xf2a2; fa-assistive-listening-systems'),
(47, 'fa-asterisk', 'fa fa-asterisk', '&#xf069;', '&#xf069; fa-asterisk'),
(48, 'fa-at', 'fa fa-at', '&#xf1fa;', '&#xf1fa; fa-at'),
(49, 'fa-audio-description', 'fa fa-audio-description', '&#xf29e;', '&#xf29e; fa-audio-description'),
(50, 'fa-automobile', 'fa fa-automobile', '&#xf1b9;', '&#xf1b9; fa-automobile'),
(51, 'fa-backward', 'fa fa-backward', '&#xf04a;', '&#xf04a; fa-backward'),
(52, 'fa-balance-scale', 'fa fa-balance-scale', '&#xf24e;', '&#xf24e; fa-balance-scale'),
(53, 'fa-ban', 'fa fa-ban', '&#xf05e;', '&#xf05e; fa-ban'),
(54, 'fa-bandcamp', 'fa fa-bandcamp', '&#xf2d5;', '&#xf2d5; fa-bandcamp'),
(55, 'fa-bank', 'fa fa-bank', '&#xf19c;', '&#xf19c; fa-bank'),
(56, 'fa-bar-chart', 'fa fa-bar-chart', '&#xf080;', '&#xf080; fa-bar-chart'),
(57, 'fa-bar-chart-o', 'fa fa-bar-chart-o', '&#xf080;', '&#xf080; fa-bar-chart-o'),
(58, 'fa-barcode', 'fa fa-barcode', '&#xf02a;', '&#xf02a; fa-barcode'),
(59, 'fa-bars', 'fa fa-bars', '&#xf0c9;', '&#xf0c9; fa-bars'),
(60, 'fa-bath', 'fa fa-bath', '&#xf2cd;', '&#xf2cd; fa-bath'),
(61, 'fa-bathtub', 'fa fa-bathtub', '&#xf2cd;', '&#xf2cd; fa-bathtub'),
(62, 'fa-battery', 'fa fa-battery', '&#xf240;', '&#xf240; fa-battery'),
(63, 'fa-battery-0', 'fa fa-battery-0', '&#xf244;', '&#xf244; fa-battery-0'),
(64, 'fa-battery-1', 'fa fa-battery-1', '&#xf243;', '&#xf243; fa-battery-1'),
(65, 'fa-battery-2', 'fa fa-battery-2', '&#xf242;', '&#xf242; fa-battery-2'),
(66, 'fa-battery-3', 'fa fa-battery-3', '&#xf241;', '&#xf241; fa-battery-3'),
(67, 'fa-battery-4', 'fa fa-battery-4', '&#xf240;', '&#xf240; fa-battery-4'),
(68, 'fa-battery-empty', 'fa fa-battery-empty', '&#xf244;', '&#xf244; fa-battery-empty'),
(69, 'fa-battery-full', 'fa fa-battery-full', '&#xf240;', '&#xf240; fa-battery-full'),
(70, 'fa-battery-half', 'fa fa-battery-half', '&#xf242;', '&#xf242; fa-battery-half'),
(71, 'fa-battery-quarter', 'fa fa-battery-quarter', '&#xf243;', '&#xf243; fa-battery-quarter'),
(72, 'fa-battery-three-quarters', 'fa fa-battery-three-quarters', '&#xf241;', '&#xf241; fa-battery-three-quarters'),
(73, 'fa-bed', 'fa fa-bed', '&#xf236;', '&#xf236; fa-bed'),
(74, 'fa-beer', 'fa fa-beer', '&#xf0fc;', '&#xf0fc; fa-beer'),
(75, 'fa-behance', 'fa fa-behance', '&#xf1b4;', '&#xf1b4; fa-behance'),
(76, 'fa-behance-square', 'fa fa-behance-square', '&#xf1b5;', '&#xf1b5; fa-behance-square'),
(77, 'fa-bell', 'fa fa-bell', '&#xf0f3;', '&#xf0f3; fa-bell'),
(78, 'fa-bell-o', 'fa fa-bell-o', '&#xf0a2;', '&#xf0a2; fa-bell-o'),
(79, 'fa-bell-slash', 'fa fa-bell-slash', '&#xf1f6;', '&#xf1f6; fa-bell-slash'),
(80, 'fa-bell-slash-o', 'fa fa-bell-slash-o', '&#xf1f7;', '&#xf1f7; fa-bell-slash-o'),
(81, 'fa-bicycle', 'fa fa-bicycle', '&#xf206;', '&#xf206; fa-bicycle'),
(82, 'fa-binoculars', 'fa fa-binoculars', '&#xf1e5;', '&#xf1e5; fa-binoculars'),
(83, 'fa-birthday-cake', 'fa fa-birthday-cake', '&#xf1fd;', '&#xf1fd; fa-birthday-cake'),
(84, 'fa-bitbucket', 'fa fa-bitbucket', '&#xf171;', '&#xf171; fa-bitbucket'),
(85, 'fa-bitbucket-square', 'fa fa-bitbucket-square', '&#xf172;', '&#xf172; fa-bitbucket-square'),
(86, 'fa-bitcoin', 'fa fa-bitcoin', '&#xf15a;', '&#xf15a; fa-bitcoin'),
(87, 'fa-black-tie', 'fa fa-black-tie', '&#xf27e;', '&#xf27e; fa-black-tie'),
(88, 'fa-blind', 'fa fa-blind', '&#xf29d;', '&#xf29d; fa-blind'),
(89, 'fa-bluetooth', 'fa fa-bluetooth', '&#xf293;', '&#xf293; fa-bluetooth'),
(90, 'fa-bluetooth-b', 'fa fa-bluetooth-b', '&#xf294;', '&#xf294; fa-bluetooth-b'),
(91, 'fa-bold', 'fa fa-bold', '&#xf032;', '&#xf032; fa-bold'),
(92, 'fa-bolt', 'fa fa-bolt', '&#xf0e7;', '&#xf0e7; fa-bolt'),
(93, 'fa-bomb', 'fa fa-bomb', '&#xf1e2;', '&#xf1e2; fa-bomb'),
(94, 'fa-book', 'fa fa-book', '&#xf02d;', '&#xf02d; fa-book'),
(95, 'fa-bookmark', 'fa fa-bookmark', '&#xf02e;', '&#xf02e; fa-bookmark'),
(96, 'fa-bookmark-o', 'fa fa-bookmark-o', '&#xf097;', '&#xf097; fa-bookmark-o'),
(97, 'fa-braille', 'fa fa-braille', '&#xf2a1;', '&#xf2a1; fa-braille'),
(98, 'fa-briefcase', 'fa fa-briefcase', '&#xf0b1;', '&#xf0b1; fa-briefcase'),
(99, 'fa-btc', 'fa fa-btc', '&#xf15a;', '&#xf15a; fa-btc'),
(100, 'fa-bug', 'fa fa-bug', '&#xf188;', '&#xf188; fa-bug'),
(101, 'fa-building', 'fa fa-building', '&#xf1ad;', '&#xf1ad; fa-building'),
(102, 'fa-building-o', 'fa fa-building-o', '&#xf0f7;', '&#xf0f7; fa-building-o'),
(103, 'fa-bullhorn', 'fa fa-bullhorn', '&#xf0a1;', '&#xf0a1; fa-bullhorn'),
(104, 'fa-bullseye', 'fa fa-bullseye', '&#xf140;', '&#xf140; fa-bullseye'),
(105, 'fa-bus', 'fa fa-bus', '&#xf207;', '&#xf207; fa-bus'),
(106, 'fa-buysellads', 'fa fa-buysellads', '&#xf20d;', '&#xf20d; fa-buysellads'),
(107, 'fa-cab', 'fa fa-cab', '&#xf1ba;', '&#xf1ba; fa-cab'),
(108, 'fa-calculator', 'fa fa-calculator', '&#xf1ec;', '&#xf1ec; fa-calculator'),
(109, 'fa-calendar', 'fa fa-calendar', '&#xf073;', '&#xf073; fa-calendar'),
(110, 'fa-calendar-check-o', 'fa fa-calendar-check-o', '&#xf274;', '&#xf274; fa-calendar-check-o'),
(111, 'fa-calendar-minus-o', 'fa fa-calendar-minus-o', '&#xf272;', '&#xf272; fa-calendar-minus-o'),
(112, 'fa-calendar-o', 'fa fa-calendar-o', '&#xf133;', '&#xf133; fa-calendar-o'),
(113, 'fa-calendar-plus-o', 'fa fa-calendar-plus-o', '&#xf271;', '&#xf271; fa-calendar-plus-o'),
(114, 'fa-calendar-times-o', 'fa fa-calendar-times-o', '&#xf273;', '&#xf273; fa-calendar-times-o'),
(115, 'fa-camera', 'fa fa-camera', '&#xf030;', '&#xf030; fa-camera'),
(116, 'fa-camera-retro', 'fa fa-camera-retro', '&#xf083;', '&#xf083; fa-camera-retro'),
(117, 'fa-car', 'fa fa-car', '&#xf1b9;', '&#xf1b9; fa-car'),
(118, 'fa-caret-down', 'fa fa-caret-down', '&#xf0d7;', '&#xf0d7; fa-caret-down'),
(119, 'fa-caret-left', 'fa fa-caret-left', '&#xf0d9;', '&#xf0d9; fa-caret-left'),
(120, 'fa-caret-right', 'fa fa-caret-right', '&#xf0da;', '&#xf0da; fa-caret-right'),
(121, 'fa-caret-square-o-down', 'fa fa-caret-square-o-down', '&#xf150;', '&#xf150; fa-caret-square-o-down'),
(122, 'fa-caret-square-o-left', 'fa fa-caret-square-o-left', '&#xf191;', '&#xf191; fa-caret-square-o-left'),
(123, 'fa-caret-square-o-right', 'fa fa-caret-square-o-right', '&#xf152;', '&#xf152; fa-caret-square-o-right'),
(124, 'fa-caret-square-o-up', 'fa fa-caret-square-o-up', '&#xf151;', '&#xf151; fa-caret-square-o-up'),
(125, 'fa-caret-up', 'fa fa-caret-up', '&#xf0d8;', '&#xf0d8; fa-caret-up'),
(126, 'fa-cart-arrow-down', 'fa fa-cart-arrow-down', '&#xf218;', '&#xf218; fa-cart-arrow-down'),
(127, 'fa-cart-plus', 'fa fa-cart-plus', '&#xf217;', '&#xf217; fa-cart-plus'),
(128, 'fa-cc', 'fa fa-cc', '&#xf20a;', '&#xf20a; fa-cc'),
(129, 'fa-cc-amex', 'fa fa-cc-amex', '&#xf1f3;', '&#xf1f3; fa-cc-amex'),
(130, 'fa-cc-diners-club', 'fa fa-cc-diners-club', '&#xf24c;', '&#xf24c; fa-cc-diners-club'),
(131, 'fa-cc-discover', 'fa fa-cc-discover', '&#xf1f2;', '&#xf1f2; fa-cc-discover'),
(132, 'fa-cc-jcb', 'fa fa-cc-jcb', '&#xf24b;', '&#xf24b; fa-cc-jcb'),
(133, 'fa-cc-mastercard', 'fa fa-cc-mastercard', '&#xf1f1;', '&#xf1f1; fa-cc-mastercard'),
(134, 'fa-cc-paypal', 'fa fa-cc-paypal', '&#xf1f4;', '&#xf1f4; fa-cc-paypal'),
(135, 'fa-cc-stripe', 'fa fa-cc-stripe', '&#xf1f5;', '&#xf1f5; fa-cc-stripe'),
(136, 'fa-cc-visa', 'fa fa-cc-visa', '&#xf1f0;', '&#xf1f0; fa-cc-visa'),
(137, 'fa-certificate', 'fa fa-certificate', '&#xf0a3;', '&#xf0a3; fa-certificate'),
(138, 'fa-chain', 'fa fa-chain', '&#xf0c1;', '&#xf0c1; fa-chain'),
(139, 'fa-chain-broken', 'fa fa-chain-broken', '&#xf127;', '&#xf127; fa-chain-broken'),
(140, 'fa-check', 'fa fa-check', '&#xf00c;', '&#xf00c; fa-check'),
(141, 'fa-check-circle', 'fa fa-check-circle', '&#xf058;', '&#xf058; fa-check-circle'),
(142, 'fa-check-circle-o', 'fa fa-check-circle-o', '&#xf05d;', '&#xf05d; fa-check-circle-o'),
(143, 'fa-check-square', 'fa fa-check-square', '&#xf14a;', '&#xf14a; fa-check-square'),
(144, 'fa-check-square-o', 'fa fa-check-square-o', '&#xf046;', '&#xf046; fa-check-square-o'),
(145, 'fa-chevron-circle-down', 'fa fa-chevron-circle-down', '&#xf13a;', '&#xf13a; fa-chevron-circle-down'),
(146, 'fa-chevron-circle-left', 'fa fa-chevron-circle-left', '&#xf137;', '&#xf137; fa-chevron-circle-left'),
(147, 'fa-chevron-circle-right', 'fa fa-chevron-circle-right', '&#xf138;', '&#xf138; fa-chevron-circle-right'),
(148, 'fa-chevron-circle-up', 'fa fa-chevron-circle-up', '&#xf139;', '&#xf139; fa-chevron-circle-up'),
(149, 'fa-chevron-down', 'fa fa-chevron-down', '&#xf078;', '&#xf078; fa-chevron-down'),
(150, 'fa-chevron-left', 'fa fa-chevron-left', '&#xf053;', '&#xf053; fa-chevron-left'),
(151, 'fa-chevron-right', 'fa fa-chevron-right', '&#xf054;', '&#xf054; fa-chevron-right'),
(152, 'fa-chevron-up', 'fa fa-chevron-up', '&#xf077;', '&#xf077; fa-chevron-up'),
(153, 'fa-child', 'fa fa-child', '&#xf1ae;', '&#xf1ae; fa-child'),
(154, 'fa-chrome', 'fa fa-chrome', '&#xf268;', '&#xf268; fa-chrome'),
(155, 'fa-circle', 'fa fa-circle', '&#xf111;', '&#xf111; fa-circle'),
(156, 'fa-circle-o', 'fa fa-circle-o', '&#xf10c;', '&#xf10c; fa-circle-o'),
(157, 'fa-circle-o-notch', 'fa fa-circle-o-notch', '&#xf1ce;', '&#xf1ce; fa-circle-o-notch'),
(158, 'fa-circle-thin', 'fa fa-circle-thin', '&#xf1db;', '&#xf1db; fa-circle-thin'),
(159, 'fa-clipboard', 'fa fa-clipboard', '&#xf0ea;', '&#xf0ea; fa-clipboard'),
(160, 'fa-clock-o', 'fa fa-clock-o', '&#xf017;', '&#xf017; fa-clock-o'),
(161, 'fa-clone', 'fa fa-clone', '&#xf24d;', '&#xf24d; fa-clone'),
(162, 'fa-close', 'fa fa-close', '&#xf00d;', '&#xf00d; fa-close'),
(163, 'fa-cloud', 'fa fa-cloud', '&#xf0c2;', '&#xf0c2; fa-cloud'),
(164, 'fa-cloud-download', 'fa fa-cloud-download', '&#xf0ed;', '&#xf0ed; fa-cloud-download'),
(165, 'fa-cloud-upload', 'fa fa-cloud-upload', '&#xf0ee;', '&#xf0ee; fa-cloud-upload'),
(166, 'fa-cny', 'fa fa-cny', '&#xf157;', '&#xf157; fa-cny'),
(167, 'fa-code', 'fa fa-code', '&#xf121;', '&#xf121; fa-code'),
(168, 'fa-code-fork', 'fa fa-code-fork', '&#xf126;', '&#xf126; fa-code-fork'),
(169, 'fa-codepen', 'fa fa-codepen', '&#xf1cb;', '&#xf1cb; fa-codepen'),
(170, 'fa-codiepie', 'fa fa-codiepie', '&#xf284;', '&#xf284; fa-codiepie'),
(171, 'fa-coffee', 'fa fa-coffee', '&#xf0f4;', '&#xf0f4; fa-coffee'),
(172, 'fa-cog', 'fa fa-cog', '&#xf013;', '&#xf013; fa-cog'),
(173, 'fa-cogs', 'fa fa-cogs', '&#xf085;', '&#xf085; fa-cogs'),
(174, 'fa-columns', 'fa fa-columns', '&#xf0db;', '&#xf0db; fa-columns'),
(175, 'fa-comment', 'fa fa-comment', '&#xf075;', '&#xf075; fa-comment'),
(176, 'fa-comment-o', 'fa fa-comment-o', '&#xf0e5;', '&#xf0e5; fa-comment-o'),
(177, 'fa-commenting', 'fa fa-commenting', '&#xf27a;', '&#xf27a; fa-commenting'),
(178, 'fa-commenting-o', 'fa fa-commenting-o', '&#xf27b;', '&#xf27b; fa-commenting-o'),
(179, 'fa-comments', 'fa fa-comments', '&#xf086;', '&#xf086; fa-comments'),
(180, 'fa-comments-o', 'fa fa-comments-o', '&#xf0e6;', '&#xf0e6; fa-comments-o'),
(181, 'fa-compass', 'fa fa-compass', '&#xf14e;', '&#xf14e; fa-compass'),
(182, 'fa-compress', 'fa fa-compress', '&#xf066;', '&#xf066; fa-compress'),
(183, 'fa-connectdevelop', 'fa fa-connectdevelop', '&#xf20e;', '&#xf20e; fa-connectdevelop'),
(184, 'fa-contao', 'fa fa-contao', '&#xf26d;', '&#xf26d; fa-contao'),
(185, 'fa-copy', 'fa fa-copy', '&#xf0c5;', '&#xf0c5; fa-copy'),
(186, 'fa-copyright', 'fa fa-copyright', '&#xf1f9;', '&#xf1f9; fa-copyright'),
(187, 'fa-creative-commons', 'fa fa-creative-commons', '&#xf25e;', '&#xf25e; fa-creative-commons'),
(188, 'fa-credit-card', 'fa fa-credit-card', '&#xf09d;', '&#xf09d; fa-credit-card'),
(189, 'fa-credit-card-alt', 'fa fa-credit-card-alt', '&#xf283;', '&#xf283; fa-credit-card-alt'),
(190, 'fa-crop', 'fa fa-crop', '&#xf125;', '&#xf125; fa-crop'),
(191, 'fa-crosshairs', 'fa fa-crosshairs', '&#xf05b;', '&#xf05b; fa-crosshairs'),
(192, 'fa-css3', 'fa fa-css3', '&#xf13c;', '&#xf13c; fa-css3'),
(193, 'fa-cube', 'fa fa-cube', '&#xf1b2;', '&#xf1b2; fa-cube'),
(194, 'fa-cubes', 'fa fa-cubes', '&#xf1b3;', '&#xf1b3; fa-cubes'),
(195, 'fa-cut', 'fa fa-cut', '&#xf0c4;', '&#xf0c4; fa-cut'),
(196, 'fa-cutlery', 'fa fa-cutlery', '&#xf0f5;', '&#xf0f5; fa-cutlery'),
(197, 'fa-dashboard', 'fa fa-dashboard', '&#xf0e4;', '&#xf0e4; fa-dashboard'),
(198, 'fa-dashcube', 'fa fa-dashcube', '&#xf210;', '&#xf210; fa-dashcube'),
(199, 'fa-database', 'fa fa-database', '&#xf1c0;', '&#xf1c0; fa-database'),
(200, 'fa-deaf', 'fa fa-deaf', '&#xf2a4;', '&#xf2a4; fa-deaf'),
(201, 'fa-deafness', 'fa fa-deafness', '&#xf2a4;', '&#xf2a4; fa-deafness'),
(202, 'fa-dedent', 'fa fa-dedent', '&#xf03b;', '&#xf03b; fa-dedent'),
(203, 'fa-delicious', 'fa fa-delicious', '&#xf1a5;', '&#xf1a5; fa-delicious'),
(204, 'fa-desktop', 'fa fa-desktop', '&#xf108;', '&#xf108; fa-desktop'),
(205, 'fa-deviantart', 'fa fa-deviantart', '&#xf1bd;', '&#xf1bd; fa-deviantart'),
(206, 'fa-diamond', 'fa fa-diamond', '&#xf219;', '&#xf219; fa-diamond'),
(207, 'fa-digg', 'fa fa-digg', '&#xf1a6;', '&#xf1a6; fa-digg'),
(208, 'fa-dollar', 'fa fa-dollar', '&#xf155;', '&#xf155; fa-dollar'),
(209, 'fa-dot-circle-o', 'fa fa-dot-circle-o', '&#xf192;', '&#xf192; fa-dot-circle-o'),
(210, 'fa-download', 'fa fa-download', '&#xf019;', '&#xf019; fa-download'),
(211, 'fa-dribbble', 'fa fa-dribbble', '&#xf17d;', '&#xf17d; fa-dribbble'),
(212, 'fa-drivers-license', 'fa fa-drivers-license', '&#xf2c2;', '&#xf2c2; fa-drivers-license'),
(213, 'fa-drivers-license-o', 'fa fa-drivers-license-o', '&#xf2c3;', '&#xf2c3; fa-drivers-license-o'),
(214, 'fa-dropbox', 'fa fa-dropbox', '&#xf16b;', '&#xf16b; fa-dropbox'),
(215, 'fa-drupal', 'fa fa-drupal', '&#xf1a9;', '&#xf1a9; fa-drupal'),
(216, 'fa-edge', 'fa fa-edge', '&#xf282;', '&#xf282; fa-edge'),
(217, 'fa-edit', 'fa fa-edit', '&#xf044;', '&#xf044; fa-edit'),
(218, 'fa-eercast', 'fa fa-eercast', '&#xf2da;', '&#xf2da; fa-eercast'),
(219, 'fa-eject', 'fa fa-eject', '&#xf052;', '&#xf052; fa-eject'),
(220, 'fa-ellipsis-h', 'fa fa-ellipsis-h', '&#xf141;', '&#xf141; fa-ellipsis-h'),
(221, 'fa-ellipsis-v', 'fa fa-ellipsis-v', '&#xf142;', '&#xf142; fa-ellipsis-v'),
(222, 'fa-empire', 'fa fa-empire', '&#xf1d1;', '&#xf1d1; fa-empire'),
(223, 'fa-envelope', 'fa fa-envelope', '&#xf0e0;', '&#xf0e0; fa-envelope'),
(224, 'fa-envelope-o', 'fa fa-envelope-o', '&#xf003;', '&#xf003; fa-envelope-o'),
(225, 'fa-envelope-open', 'fa fa-envelope-open', '&#xf2b6;', '&#xf2b6; fa-envelope-open'),
(226, 'fa-envelope-open-o', 'fa fa-envelope-open-o', '&#xf2b7;', '&#xf2b7; fa-envelope-open-o'),
(227, 'fa-envelope-square', 'fa fa-envelope-square', '&#xf199;', '&#xf199; fa-envelope-square'),
(228, 'fa-envira', 'fa fa-envira', '&#xf299;', '&#xf299; fa-envira'),
(229, 'fa-eraser', 'fa fa-eraser', '&#xf12d;', '&#xf12d; fa-eraser'),
(230, 'fa-etsy', 'fa fa-etsy', '&#xf2d7;', '&#xf2d7; fa-etsy'),
(231, 'fa-eur', 'fa fa-eur', '&#xf153;', '&#xf153; fa-eur'),
(232, 'fa-euro', 'fa fa-euro', '&#xf153;', '&#xf153; fa-euro'),
(233, 'fa-exchange', 'fa fa-exchange', '&#xf0ec;', '&#xf0ec; fa-exchange'),
(234, 'fa-exclamation', 'fa fa-exclamation', '&#xf12a;', '&#xf12a; fa-exclamation'),
(235, 'fa-exclamation-circle', 'fa fa-exclamation-circle', '&#xf06a;', '&#xf06a; fa-exclamation-circle'),
(236, 'fa-exclamation-triangle', 'fa fa-exclamation-triangle', '&#xf071;', '&#xf071; fa-exclamation-triangle'),
(237, 'fa-expand', 'fa fa-expand', '&#xf065;', '&#xf065; fa-expand'),
(238, 'fa-expeditedssl', 'fa fa-expeditedssl', '&#xf23e;', '&#xf23e; fa-expeditedssl'),
(239, 'fa-external-link', 'fa fa-external-link', '&#xf08e;', '&#xf08e; fa-external-link'),
(240, 'fa-external-link-square', 'fa fa-external-link-square', '&#xf14c;', '&#xf14c; fa-external-link-square'),
(241, 'fa-eye', 'fa fa-eye', '&#xf06e;', '&#xf06e; fa-eye'),
(242, 'fa-eye-slash', 'fa fa-eye-slash', '&#xf070;', '&#xf070; fa-eye-slash'),
(243, 'fa-eyedropper', 'fa fa-eyedropper', '&#xf1fb;', '&#xf1fb; fa-eyedropper'),
(244, 'fa-fa', 'fa fa-fa', '&#xf2b4;', '&#xf2b4; fa-fa'),
(245, 'fa-facebook', 'fa fa-facebook', '&#xf09a;', '&#xf09a; fa-facebook'),
(246, 'fa-facebook-f', 'fa fa-facebook-f', '&#xf09a;', '&#xf09a; fa-facebook-f'),
(247, 'fa-facebook-official', 'fa fa-facebook-official', '&#xf230;', '&#xf230; fa-facebook-official'),
(248, 'fa-facebook-square', 'fa fa-facebook-square', '&#xf082;', '&#xf082; fa-facebook-square'),
(249, 'fa-fast-backward', 'fa fa-fast-backward', '&#xf049;', '&#xf049; fa-fast-backward'),
(250, 'fa-fast-forward', 'fa fa-fast-forward', '&#xf050;', '&#xf050; fa-fast-forward'),
(251, 'fa-fax', 'fa fa-fax', '&#xf1ac;', '&#xf1ac; fa-fax'),
(252, 'fa-feed', 'fa fa-feed', '&#xf09e;', '&#xf09e; fa-feed'),
(253, 'fa-female', 'fa fa-female', '&#xf182;', '&#xf182; fa-female'),
(254, 'fa-fighter-jet', 'fa fa-fighter-jet', '&#xf0fb;', '&#xf0fb; fa-fighter-jet'),
(255, 'fa-file', 'fa fa-file', '&#xf15b;', '&#xf15b; fa-file'),
(256, 'fa-file-archive-o', 'fa fa-file-archive-o', '&#xf1c6;', '&#xf1c6; fa-file-archive-o'),
(257, 'fa-file-audio-o', 'fa fa-file-audio-o', '&#xf1c7;', '&#xf1c7; fa-file-audio-o'),
(258, 'fa-file-code-o', 'fa fa-file-code-o', '&#xf1c9;', '&#xf1c9; fa-file-code-o'),
(259, 'fa-file-excel-o', 'fa fa-file-excel-o', '&#xf1c3;', '&#xf1c3; fa-file-excel-o'),
(260, 'fa-file-image-o', 'fa fa-file-image-o', '&#xf1c5;', '&#xf1c5; fa-file-image-o'),
(261, 'fa-file-movie-o', 'fa fa-file-movie-o', '&#xf1c8;', '&#xf1c8; fa-file-movie-o'),
(262, 'fa-file-o', 'fa fa-file-o', '&#xf016;', '&#xf016; fa-file-o'),
(263, 'fa-file-pdf-o', 'fa fa-file-pdf-o', '&#xf1c1;', '&#xf1c1; fa-file-pdf-o'),
(264, 'fa-file-photo-o', 'fa fa-file-photo-o', '&#xf1c5;', '&#xf1c5; fa-file-photo-o'),
(265, 'fa-file-picture-o', 'fa fa-file-picture-o', '&#xf1c5;', '&#xf1c5; fa-file-picture-o'),
(266, 'fa-file-powerpoint-o', 'fa fa-file-powerpoint-o', '&#xf1c4;', '&#xf1c4; fa-file-powerpoint-o'),
(267, 'fa-file-sound-o', 'fa fa-file-sound-o', '&#xf1c7;', '&#xf1c7; fa-file-sound-o'),
(268, 'fa-file-text', 'fa fa-file-text', '&#xf15c;', '&#xf15c; fa-file-text'),
(269, 'fa-file-text-o', 'fa fa-file-text-o', '&#xf0f6;', '&#xf0f6; fa-file-text-o'),
(270, 'fa-file-video-o', 'fa fa-file-video-o', '&#xf1c8;', '&#xf1c8; fa-file-video-o'),
(271, 'fa-file-word-o', 'fa fa-file-word-o', '&#xf1c2;', '&#xf1c2; fa-file-word-o'),
(272, 'fa-file-zip-o', 'fa fa-file-zip-o', '&#xf1c6;', '&#xf1c6; fa-file-zip-o'),
(273, 'fa-files-o', 'fa fa-files-o', '&#xf0c5;', '&#xf0c5; fa-files-o'),
(274, 'fa-film', 'fa fa-film', '&#xf008;', '&#xf008; fa-film'),
(275, 'fa-filter', 'fa fa-filter', '&#xf0b0;', '&#xf0b0; fa-filter'),
(276, 'fa-fire', 'fa fa-fire', '&#xf06d;', '&#xf06d; fa-fire'),
(277, 'fa-fire-extinguisher', 'fa fa-fire-extinguisher', '&#xf134;', '&#xf134; fa-fire-extinguisher'),
(278, 'fa-firefox', 'fa fa-firefox', '&#xf269;', '&#xf269; fa-firefox'),
(279, 'fa-first-order', 'fa fa-first-order', '&#xf2b0;', '&#xf2b0; fa-first-order'),
(280, 'fa-flag', 'fa fa-flag', '&#xf024;', '&#xf024; fa-flag'),
(281, 'fa-flag-checkered', 'fa fa-flag-checkered', '&#xf11e;', '&#xf11e; fa-flag-checkered'),
(282, 'fa-flag-o', 'fa fa-flag-o', '&#xf11d;', '&#xf11d; fa-flag-o'),
(283, 'fa-flash', 'fa fa-flash', '&#xf0e7;', '&#xf0e7; fa-flash'),
(284, 'fa-flask', 'fa fa-flask', '&#xf0c3;', '&#xf0c3; fa-flask'),
(285, 'fa-flickr', 'fa fa-flickr', '&#xf16e;', '&#xf16e; fa-flickr'),
(286, 'fa-floppy-o', 'fa fa-floppy-o', '&#xf0c7;', '&#xf0c7; fa-floppy-o'),
(287, 'fa-folder', 'fa fa-folder', '&#xf07b;', '&#xf07b; fa-folder'),
(288, 'fa-folder-o', 'fa fa-folder-o', '&#xf114;', '&#xf114; fa-folder-o'),
(289, 'fa-folder-open', 'fa fa-folder-open', '&#xf07c;', '&#xf07c; fa-folder-open'),
(290, 'fa-folder-open-o', 'fa fa-folder-open-o', '&#xf115;', '&#xf115; fa-folder-open-o'),
(291, 'fa-font', 'fa fa-font', '&#xf031;', '&#xf031; fa-font'),
(292, 'fa-font-awesome', 'fa fa-font-awesome', '&#xf2b4;', '&#xf2b4; fa-font-awesome'),
(293, 'fa-fonticons', 'fa fa-fonticons', '&#xf280;', '&#xf280; fa-fonticons'),
(294, 'fa-fort-awesome', 'fa fa-fort-awesome', '&#xf286;', '&#xf286; fa-fort-awesome'),
(295, 'fa-forumbee', 'fa fa-forumbee', '&#xf211;', '&#xf211; fa-forumbee'),
(296, 'fa-forward', 'fa fa-forward', '&#xf04e;', '&#xf04e; fa-forward'),
(297, 'fa-foursquare', 'fa fa-foursquare', '&#xf180;', '&#xf180; fa-foursquare'),
(298, 'fa-free-code-camp', 'fa fa-free-code-camp', '&#xf2c5;', '&#xf2c5; fa-free-code-camp'),
(299, 'fa-frown-o', 'fa fa-frown-o', '&#xf119;', '&#xf119; fa-frown-o'),
(300, 'fa-futbol-o', 'fa fa-futbol-o', '&#xf1e3;', '&#xf1e3; fa-futbol-o'),
(301, 'fa-gamepad', 'fa fa-gamepad', '&#xf11b;', '&#xf11b; fa-gamepad'),
(302, 'fa-gavel', 'fa fa-gavel', '&#xf0e3;', '&#xf0e3; fa-gavel'),
(303, 'fa-gbp', 'fa fa-gbp', '&#xf154;', '&#xf154; fa-gbp'),
(304, 'fa-ge', 'fa fa-ge', '&#xf1d1;', '&#xf1d1; fa-ge'),
(305, 'fa-gear', 'fa fa-gear', '&#xf013;', '&#xf013; fa-gear'),
(306, 'fa-gears', 'fa fa-gears', '&#xf085;', '&#xf085; fa-gears'),
(307, 'fa-genderless', 'fa fa-genderless', '&#xf22d;', '&#xf22d; fa-genderless'),
(308, 'fa-get-pocket', 'fa fa-get-pocket', '&#xf265;', '&#xf265; fa-get-pocket'),
(309, 'fa-gg', 'fa fa-gg', '&#xf260;', '&#xf260; fa-gg'),
(310, 'fa-gg-circle', 'fa fa-gg-circle', '&#xf261;', '&#xf261; fa-gg-circle'),
(311, 'fa-gift', 'fa fa-gift', '&#xf06b;', '&#xf06b; fa-gift'),
(312, 'fa-git', 'fa fa-git', '&#xf1d3;', '&#xf1d3; fa-git'),
(313, 'fa-git-square', 'fa fa-git-square', '&#xf1d2;', '&#xf1d2; fa-git-square'),
(314, 'fa-github', 'fa fa-github', '&#xf09b;', '&#xf09b; fa-github'),
(315, 'fa-github-alt', 'fa fa-github-alt', '&#xf113;', '&#xf113; fa-github-alt'),
(316, 'fa-github-square', 'fa fa-github-square', '&#xf092;', '&#xf092; fa-github-square'),
(317, 'fa-gitlab', 'fa fa-gitlab', '&#xf296;', '&#xf296; fa-gitlab'),
(318, 'fa-gittip', 'fa fa-gittip', '&#xf184;', '&#xf184; fa-gittip'),
(319, 'fa-glass', 'fa fa-glass', '&#xf000;', '&#xf000; fa-glass'),
(320, 'fa-glide', 'fa fa-glide', '&#xf2a5;', '&#xf2a5; fa-glide'),
(321, 'fa-glide-g', 'fa fa-glide-g', '&#xf2a6;', '&#xf2a6; fa-glide-g'),
(322, 'fa-globe', 'fa fa-globe', '&#xf0ac;', '&#xf0ac; fa-globe'),
(323, 'fa-google', 'fa fa-google', '&#xf1a0;', '&#xf1a0; fa-google'),
(324, 'fa-google-plus', 'fa fa-google-plus', '&#xf0d5;', '&#xf0d5; fa-google-plus'),
(325, 'fa-google-plus-circle', 'fa fa-google-plus-circle', '&#xf2b3;', '&#xf2b3; fa-google-plus-circle'),
(326, 'fa-google-plus-official', 'fa fa-google-plus-official', '&#xf2b3;', '&#xf2b3; fa-google-plus-official'),
(327, 'fa-google-plus-square', 'fa fa-google-plus-square', '&#xf0d4;', '&#xf0d4; fa-google-plus-square'),
(328, 'fa-google-wallet', 'fa fa-google-wallet', '&#xf1ee;', '&#xf1ee; fa-google-wallet'),
(329, 'fa-graduation-cap', 'fa fa-graduation-cap', '&#xf19d;', '&#xf19d; fa-graduation-cap'),
(330, 'fa-gratipay', 'fa fa-gratipay', '&#xf184;', '&#xf184; fa-gratipay'),
(331, 'fa-grav', 'fa fa-grav', '&#xf2d6;', '&#xf2d6; fa-grav'),
(332, 'fa-group', 'fa fa-group', '&#xf0c0;', '&#xf0c0; fa-group'),
(333, 'fa-h-square', 'fa fa-h-square', '&#xf0fd;', '&#xf0fd; fa-h-square'),
(334, 'fa-hacker-news', 'fa fa-hacker-news', '&#xf1d4;', '&#xf1d4; fa-hacker-news'),
(335, 'fa-hand-grab-o', 'fa fa-hand-grab-o', '&#xf255;', '&#xf255; fa-hand-grab-o'),
(336, 'fa-hand-lizard-o', 'fa fa-hand-lizard-o', '&#xf258;', '&#xf258; fa-hand-lizard-o'),
(337, 'fa-hand-o-down', 'fa fa-hand-o-down', '&#xf0a7;', '&#xf0a7; fa-hand-o-down'),
(338, 'fa-hand-o-left', 'fa fa-hand-o-left', '&#xf0a5;', '&#xf0a5; fa-hand-o-left'),
(339, 'fa-hand-o-right', 'fa fa-hand-o-right', '&#xf0a4;', '&#xf0a4; fa-hand-o-right'),
(340, 'fa-hand-o-up', 'fa fa-hand-o-up', '&#xf0a6;', '&#xf0a6; fa-hand-o-up'),
(341, 'fa-hand-paper-o', 'fa fa-hand-paper-o', '&#xf256;', '&#xf256; fa-hand-paper-o'),
(342, 'fa-hand-peace-o', 'fa fa-hand-peace-o', '&#xf25b;', '&#xf25b; fa-hand-peace-o'),
(343, 'fa-hand-pointer-o', 'fa fa-hand-pointer-o', '&#xf25a;', '&#xf25a; fa-hand-pointer-o'),
(344, 'fa-hand-rock-o', 'fa fa-hand-rock-o', '&#xf255;', '&#xf255; fa-hand-rock-o'),
(345, 'fa-hand-scissors-o', 'fa fa-hand-scissors-o', '&#xf257;', '&#xf257; fa-hand-scissors-o'),
(346, 'fa-hand-spock-o', 'fa fa-hand-spock-o', '&#xf259;', '&#xf259; fa-hand-spock-o'),
(347, 'fa-hand-stop-o', 'fa fa-hand-stop-o', '&#xf256;', '&#xf256; fa-hand-stop-o'),
(348, 'fa-handshake-o', 'fa fa-handshake-o', '&#xf2b5;', '&#xf2b5; fa-handshake-o'),
(349, 'fa-hard-of-hearing', 'fa fa-hard-of-hearing', '&#xf2a4;', '&#xf2a4; fa-hard-of-hearing'),
(350, 'fa-hashtag', 'fa fa-hashtag', '&#xf292;', '&#xf292; fa-hashtag'),
(351, 'fa-hdd-o', 'fa fa-hdd-o', '&#xf0a0;', '&#xf0a0; fa-hdd-o'),
(352, 'fa-header', 'fa fa-header', '&#xf1dc;', '&#xf1dc; fa-header'),
(353, 'fa-headphones', 'fa fa-headphones', '&#xf025;', '&#xf025; fa-headphones'),
(354, 'fa-heart', 'fa fa-heart', '&#xf004;', '&#xf004; fa-heart'),
(355, 'fa-heart-o', 'fa fa-heart-o', '&#xf08a;', '&#xf08a; fa-heart-o'),
(356, 'fa-heartbeat', 'fa fa-heartbeat', '&#xf21e;', '&#xf21e; fa-heartbeat'),
(357, 'fa-history', 'fa fa-history', '&#xf1da;', '&#xf1da; fa-history'),
(358, 'fa-home', 'fa fa-home', '&#xf015;', '&#xf015; fa-home'),
(359, 'fa-hospital-o', 'fa fa-hospital-o', '&#xf0f8;', '&#xf0f8; fa-hospital-o'),
(360, 'fa-hotel', 'fa fa-hotel', '&#xf236;', '&#xf236; fa-hotel'),
(361, 'fa-hourglass', 'fa fa-hourglass', '&#xf254;', '&#xf254; fa-hourglass'),
(362, 'fa-hourglass-1', 'fa fa-hourglass-1', '&#xf251;', '&#xf251; fa-hourglass-1'),
(363, 'fa-hourglass-2', 'fa fa-hourglass-2', '&#xf252;', '&#xf252; fa-hourglass-2'),
(364, 'fa-hourglass-3', 'fa fa-hourglass-3', '&#xf253;', '&#xf253; fa-hourglass-3'),
(365, 'fa-hourglass-end', 'fa fa-hourglass-end', '&#xf253;', '&#xf253; fa-hourglass-end'),
(366, 'fa-hourglass-half', 'fa fa-hourglass-half', '&#xf252;', '&#xf252; fa-hourglass-half'),
(367, 'fa-hourglass-o', 'fa fa-hourglass-o', '&#xf250;', '&#xf250; fa-hourglass-o'),
(368, 'fa-hourglass-start', 'fa fa-hourglass-start', '&#xf251;', '&#xf251; fa-hourglass-start'),
(369, 'fa-houzz', 'fa fa-houzz', '&#xf27c;', '&#xf27c; fa-houzz'),
(370, 'fa-html5', 'fa fa-html5', '&#xf13b;', '&#xf13b; fa-html5'),
(371, 'fa-i-cursor', 'fa fa-i-cursor', '&#xf246;', '&#xf246; fa-i-cursor'),
(372, 'fa-id-badge', 'fa fa-id-badge', '&#xf2c1;', '&#xf2c1; fa-id-badge'),
(373, 'fa-id-card', 'fa fa-id-card', '&#xf2c2;', '&#xf2c2; fa-id-card'),
(374, 'fa-id-card-o', 'fa fa-id-card-o', '&#xf2c3;', '&#xf2c3; fa-id-card-o'),
(375, 'fa-ils', 'fa fa-ils', '&#xf20b;', '&#xf20b; fa-ils'),
(376, 'fa-image', 'fa fa-image', '&#xf03e;', '&#xf03e; fa-image'),
(377, 'fa-imdb', 'fa fa-imdb', '&#xf2d8;', '&#xf2d8; fa-imdb'),
(378, 'fa-inbox', 'fa fa-inbox', '&#xf01c;', '&#xf01c; fa-inbox'),
(379, 'fa-indent', 'fa fa-indent', '&#xf03c;', '&#xf03c; fa-indent'),
(380, 'fa-industry', 'fa fa-industry', '&#xf275;', '&#xf275; fa-industry'),
(381, 'fa-info', 'fa fa-info', '&#xf129;', '&#xf129; fa-info'),
(382, 'fa-info-circle', 'fa fa-info-circle', '&#xf05a;', '&#xf05a; fa-info-circle'),
(383, 'fa-inr', 'fa fa-inr', '&#xf156;', '&#xf156; fa-inr'),
(384, 'fa-instagram', 'fa fa-instagram', '&#xf16d;', '&#xf16d; fa-instagram'),
(385, 'fa-institution', 'fa fa-institution', '&#xf19c;', '&#xf19c; fa-institution'),
(386, 'fa-internet-explorer', 'fa fa-internet-explorer', '&#xf26b;', '&#xf26b; fa-internet-explorer'),
(387, 'fa-intersex', 'fa fa-intersex', '&#xf224;', '&#xf224; fa-intersex'),
(388, 'fa-ioxhost', 'fa fa-ioxhost', '&#xf208;', '&#xf208; fa-ioxhost'),
(389, 'fa-italic', 'fa fa-italic', '&#xf033;', '&#xf033; fa-italic'),
(390, 'fa-joomla', 'fa fa-joomla', '&#xf1aa;', '&#xf1aa; fa-joomla'),
(391, 'fa-jpy', 'fa fa-jpy', '&#xf157;', '&#xf157; fa-jpy'),
(392, 'fa-jsfiddle', 'fa fa-jsfiddle', '&#xf1cc;', '&#xf1cc; fa-jsfiddle'),
(393, 'fa-key', 'fa fa-key', '&#xf084;', '&#xf084; fa-key'),
(394, 'fa-keyboard-o', 'fa fa-keyboard-o', '&#xf11c;', '&#xf11c; fa-keyboard-o'),
(395, 'fa-krw', 'fa fa-krw', '&#xf159;', '&#xf159; fa-krw'),
(396, 'fa-language', 'fa fa-language', '&#xf1ab;', '&#xf1ab; fa-language'),
(397, 'fa-laptop', 'fa fa-laptop', '&#xf109;', '&#xf109; fa-laptop'),
(398, 'fa-lastfm', 'fa fa-lastfm', '&#xf202;', '&#xf202; fa-lastfm'),
(399, 'fa-lastfm-square', 'fa fa-lastfm-square', '&#xf203;', '&#xf203; fa-lastfm-square'),
(400, 'fa-leaf', 'fa fa-leaf', '&#xf06c;', '&#xf06c; fa-leaf'),
(401, 'fa-leanpub', 'fa fa-leanpub', '&#xf212;', '&#xf212; fa-leanpub'),
(402, 'fa-legal', 'fa fa-legal', '&#xf0e3;', '&#xf0e3; fa-legal'),
(403, 'fa-lemon-o', 'fa fa-lemon-o', '&#xf094;', '&#xf094; fa-lemon-o'),
(404, 'fa-level-down', 'fa fa-level-down', '&#xf149;', '&#xf149; fa-level-down'),
(405, 'fa-level-up', 'fa fa-level-up', '&#xf148;', '&#xf148; fa-level-up'),
(406, 'fa-life-bouy', 'fa fa-life-bouy', '&#xf1cd;', '&#xf1cd; fa-life-bouy'),
(407, 'fa-life-buoy', 'fa fa-life-buoy', '&#xf1cd;', '&#xf1cd; fa-life-buoy'),
(408, 'fa-life-ring', 'fa fa-life-ring', '&#xf1cd;', '&#xf1cd; fa-life-ring'),
(409, 'fa-life-saver', 'fa fa-life-saver', '&#xf1cd;', '&#xf1cd; fa-life-saver'),
(410, 'fa-lightbulb-o', 'fa fa-lightbulb-o', '&#xf0eb;', '&#xf0eb; fa-lightbulb-o'),
(411, 'fa-line-chart', 'fa fa-line-chart', '&#xf201;', '&#xf201; fa-line-chart'),
(412, 'fa-link', 'fa fa-link', '&#xf0c1;', '&#xf0c1; fa-link'),
(413, 'fa-linkedin', 'fa fa-linkedin', '&#xf0e1;', '&#xf0e1; fa-linkedin'),
(414, 'fa-linkedin-square', 'fa fa-linkedin-square', '&#xf08c;', '&#xf08c; fa-linkedin-square'),
(415, 'fa-linode', 'fa fa-linode', '&#xf2b8;', '&#xf2b8; fa-linode'),
(416, 'fa-linux', 'fa fa-linux', '&#xf17c;', '&#xf17c; fa-linux'),
(417, 'fa-list', 'fa fa-list', '&#xf03a;', '&#xf03a; fa-list'),
(418, 'fa-list-alt', 'fa fa-list-alt', '&#xf022;', '&#xf022; fa-list-alt'),
(419, 'fa-list-ol', 'fa fa-list-ol', '&#xf0cb;', '&#xf0cb; fa-list-ol'),
(420, 'fa-list-ul', 'fa fa-list-ul', '&#xf0ca;', '&#xf0ca; fa-list-ul'),
(421, 'fa-location-arrow', 'fa fa-location-arrow', '&#xf124;', '&#xf124; fa-location-arrow'),
(422, 'fa-lock', 'fa fa-lock', '&#xf023;', '&#xf023; fa-lock'),
(423, 'fa-long-arrow-down', 'fa fa-long-arrow-down', '&#xf175;', '&#xf175; fa-long-arrow-down'),
(424, 'fa-long-arrow-left', 'fa fa-long-arrow-left', '&#xf177;', '&#xf177; fa-long-arrow-left'),
(425, 'fa-long-arrow-right', 'fa fa-long-arrow-right', '&#xf178;', '&#xf178; fa-long-arrow-right'),
(426, 'fa-long-arrow-up', 'fa fa-long-arrow-up', '&#xf176;', '&#xf176; fa-long-arrow-up'),
(427, 'fa-low-vision', 'fa fa-low-vision', '&#xf2a8;', '&#xf2a8; fa-low-vision'),
(428, 'fa-magic', 'fa fa-magic', '&#xf0d0;', '&#xf0d0; fa-magic'),
(429, 'fa-magnet', 'fa fa-magnet', '&#xf076;', '&#xf076; fa-magnet'),
(430, 'fa-mail-forward', 'fa fa-mail-forward', '&#xf064;', '&#xf064; fa-mail-forward'),
(431, 'fa-mail-reply', 'fa fa-mail-reply', '&#xf112;', '&#xf112; fa-mail-reply'),
(432, 'fa-mail-reply-all', 'fa fa-mail-reply-all', '&#xf122;', '&#xf122; fa-mail-reply-all'),
(433, 'fa-male', 'fa fa-male', '&#xf183;', '&#xf183; fa-male'),
(434, 'fa-map', 'fa fa-map', '&#xf279;', '&#xf279; fa-map'),
(435, 'fa-map-marker', 'fa fa-map-marker', '&#xf041;', '&#xf041; fa-map-marker'),
(436, 'fa-map-o', 'fa fa-map-o', '&#xf278;', '&#xf278; fa-map-o'),
(437, 'fa-map-pin', 'fa fa-map-pin', '&#xf276;', '&#xf276; fa-map-pin'),
(438, 'fa-map-signs', 'fa fa-map-signs', '&#xf277;', '&#xf277; fa-map-signs'),
(439, 'fa-mars', 'fa fa-mars', '&#xf222;', '&#xf222; fa-mars'),
(440, 'fa-mars-double', 'fa fa-mars-double', '&#xf227;', '&#xf227; fa-mars-double'),
(441, 'fa-mars-stroke', 'fa fa-mars-stroke', '&#xf229;', '&#xf229; fa-mars-stroke'),
(442, 'fa-mars-stroke-h', 'fa fa-mars-stroke-h', '&#xf22b;', '&#xf22b; fa-mars-stroke-h'),
(443, 'fa-mars-stroke-v', 'fa fa-mars-stroke-v', '&#xf22a;', '&#xf22a; fa-mars-stroke-v'),
(444, 'fa-maxcdn', 'fa fa-maxcdn', '&#xf136;', '&#xf136; fa-maxcdn'),
(445, 'fa-meanpath', 'fa fa-meanpath', '&#xf20c;', '&#xf20c; fa-meanpath'),
(446, 'fa-medium', 'fa fa-medium', '&#xf23a;', '&#xf23a; fa-medium'),
(447, 'fa-medkit', 'fa fa-medkit', '&#xf0fa;', '&#xf0fa; fa-medkit'),
(448, 'fa-meetup', 'fa fa-meetup', '&#xf2e0;', '&#xf2e0; fa-meetup'),
(449, 'fa-meh-o', 'fa fa-meh-o', '&#xf11a;', '&#xf11a; fa-meh-o'),
(450, 'fa-mercury', 'fa fa-mercury', '&#xf223;', '&#xf223; fa-mercury'),
(451, 'fa-microchip', 'fa fa-microchip', '&#xf2db;', '&#xf2db; fa-microchip'),
(452, 'fa-microphone', 'fa fa-microphone', '&#xf130;', '&#xf130; fa-microphone'),
(453, 'fa-microphone-slash', 'fa fa-microphone-slash', '&#xf131;', '&#xf131; fa-microphone-slash'),
(454, 'fa-minus', 'fa fa-minus', '&#xf068;', '&#xf068; fa-minus'),
(455, 'fa-minus-circle', 'fa fa-minus-circle', '&#xf056;', '&#xf056; fa-minus-circle'),
(456, 'fa-minus-square', 'fa fa-minus-square', '&#xf146;', '&#xf146; fa-minus-square'),
(457, 'fa-minus-square-o', 'fa fa-minus-square-o', '&#xf147;', '&#xf147; fa-minus-square-o'),
(458, 'fa-mixcloud', 'fa fa-mixcloud', '&#xf289;', '&#xf289; fa-mixcloud'),
(459, 'fa-mobile', 'fa fa-mobile', '&#xf10b;', '&#xf10b; fa-mobile'),
(460, 'fa-mobile-phone', 'fa fa-mobile-phone', '&#xf10b;', '&#xf10b; fa-mobile-phone'),
(461, 'fa-modx', 'fa fa-modx', '&#xf285;', '&#xf285; fa-modx'),
(462, 'fa-money', 'fa fa-money', '&#xf0d6;', '&#xf0d6; fa-money'),
(463, 'fa-moon-o', 'fa fa-moon-o', '&#xf186;', '&#xf186; fa-moon-o'),
(464, 'fa-mortar-board', 'fa fa-mortar-board', '&#xf19d;', '&#xf19d; fa-mortar-board'),
(465, 'fa-motorcycle', 'fa fa-motorcycle', '&#xf21c;', '&#xf21c; fa-motorcycle'),
(466, 'fa-mouse-pointer', 'fa fa-mouse-pointer', '&#xf245;', '&#xf245; fa-mouse-pointer'),
(467, 'fa-music', 'fa fa-music', '&#xf001;', '&#xf001; fa-music'),
(468, 'fa-navicon', 'fa fa-navicon', '&#xf0c9;', '&#xf0c9; fa-navicon'),
(469, 'fa-neuter', 'fa fa-neuter', '&#xf22c;', '&#xf22c; fa-neuter'),
(470, 'fa-newspaper-o', 'fa fa-newspaper-o', '&#xf1ea;', '&#xf1ea; fa-newspaper-o'),
(471, 'fa-object-group', 'fa fa-object-group', '&#xf247;', '&#xf247; fa-object-group'),
(472, 'fa-object-ungroup', 'fa fa-object-ungroup', '&#xf248;', '&#xf248; fa-object-ungroup'),
(473, 'fa-odnoklassniki', 'fa fa-odnoklassniki', '&#xf263;', '&#xf263; fa-odnoklassniki'),
(474, 'fa-odnoklassniki-square', 'fa fa-odnoklassniki-square', '&#xf264;', '&#xf264; fa-odnoklassniki-square'),
(475, 'fa-opencart', 'fa fa-opencart', '&#xf23d;', '&#xf23d; fa-opencart'),
(476, 'fa-openid', 'fa fa-openid', '&#xf19b;', '&#xf19b; fa-openid'),
(477, 'fa-opera', 'fa fa-opera', '&#xf26a;', '&#xf26a; fa-opera'),
(478, 'fa-optin-monster', 'fa fa-optin-monster', '&#xf23c;', '&#xf23c; fa-optin-monster'),
(479, 'fa-outdent', 'fa fa-outdent', '&#xf03b;', '&#xf03b; fa-outdent'),
(480, 'fa-pagelines', 'fa fa-pagelines', '&#xf18c;', '&#xf18c; fa-pagelines'),
(481, 'fa-paint-brush', 'fa fa-paint-brush', '&#xf1fc;', '&#xf1fc; fa-paint-brush'),
(482, 'fa-paper-plane', 'fa fa-paper-plane', '&#xf1d8;', '&#xf1d8; fa-paper-plane'),
(483, 'fa-paper-plane-o', 'fa fa-paper-plane-o', '&#xf1d9;', '&#xf1d9; fa-paper-plane-o'),
(484, 'fa-paperclip', 'fa fa-paperclip', '&#xf0c6;', '&#xf0c6; fa-paperclip'),
(485, 'fa-paragraph', 'fa fa-paragraph', '&#xf1dd;', '&#xf1dd; fa-paragraph'),
(486, 'fa-paste', 'fa fa-paste', '&#xf0ea;', '&#xf0ea; fa-paste'),
(487, 'fa-pause', 'fa fa-pause', '&#xf04c;', '&#xf04c; fa-pause'),
(488, 'fa-pause-circle', 'fa fa-pause-circle', '&#xf28b;', '&#xf28b; fa-pause-circle'),
(489, 'fa-pause-circle-o', 'fa fa-pause-circle-o', '&#xf28c;', '&#xf28c; fa-pause-circle-o'),
(490, 'fa-paw', 'fa fa-paw', '&#xf1b0;', '&#xf1b0; fa-paw'),
(491, 'fa-paypal', 'fa fa-paypal', '&#xf1ed;', '&#xf1ed; fa-paypal'),
(492, 'fa-pencil', 'fa fa-pencil', '&#xf040;', '&#xf040; fa-pencil'),
(493, 'fa-pencil-square', 'fa fa-pencil-square', '&#xf14b;', '&#xf14b; fa-pencil-square'),
(494, 'fa-pencil-square-o', 'fa fa-pencil-square-o', '&#xf044;', '&#xf044; fa-pencil-square-o'),
(495, 'fa-percent', 'fa fa-percent', '&#xf295;', '&#xf295; fa-percent'),
(496, 'fa-phone', 'fa fa-phone', '&#xf095;', '&#xf095; fa-phone'),
(497, 'fa-phone-square', 'fa fa-phone-square', '&#xf098;', '&#xf098; fa-phone-square'),
(498, 'fa-photo', 'fa fa-photo', '&#xf03e;', '&#xf03e; fa-photo'),
(499, 'fa-picture-o', 'fa fa-picture-o', '&#xf03e;', '&#xf03e; fa-picture-o'),
(500, 'fa-pie-chart', 'fa fa-pie-chart', '&#xf200;', '&#xf200; fa-pie-chart'),
(501, 'fa-pied-piper', 'fa fa-pied-piper', '&#xf2ae;', '&#xf2ae; fa-pied-piper'),
(502, 'fa-pied-piper-alt', 'fa fa-pied-piper-alt', '&#xf1a8;', '&#xf1a8; fa-pied-piper-alt'),
(503, 'fa-pied-piper-pp', 'fa fa-pied-piper-pp', '&#xf1a7;', '&#xf1a7; fa-pied-piper-pp'),
(504, 'fa-pinterest', 'fa fa-pinterest', '&#xf0d2;', '&#xf0d2; fa-pinterest'),
(505, 'fa-pinterest-p', 'fa fa-pinterest-p', '&#xf231;', '&#xf231; fa-pinterest-p'),
(506, 'fa-pinterest-square', 'fa fa-pinterest-square', '&#xf0d3;', '&#xf0d3; fa-pinterest-square'),
(507, 'fa-plane', 'fa fa-plane', '&#xf072;', '&#xf072; fa-plane'),
(508, 'fa-play', 'fa fa-play', '&#xf04b;', '&#xf04b; fa-play'),
(509, 'fa-play-circle', 'fa fa-play-circle', '&#xf144;', '&#xf144; fa-play-circle'),
(510, 'fa-play-circle-o', 'fa fa-play-circle-o', '&#xf01d;', '&#xf01d; fa-play-circle-o'),
(511, 'fa-plug', 'fa fa-plug', '&#xf1e6;', '&#xf1e6; fa-plug'),
(512, 'fa-plus', 'fa fa-plus', '&#xf067;', '&#xf067; fa-plus'),
(513, 'fa-plus-circle', 'fa fa-plus-circle', '&#xf055;', '&#xf055; fa-plus-circle'),
(514, 'fa-plus-square', 'fa fa-plus-square', '&#xf0fe;', '&#xf0fe; fa-plus-square'),
(515, 'fa-plus-square-o', 'fa fa-plus-square-o', '&#xf196;', '&#xf196; fa-plus-square-o'),
(516, 'fa-podcast', 'fa fa-podcast', '&#xf2ce;', '&#xf2ce; fa-podcast'),
(517, 'fa-power-off', 'fa fa-power-off', '&#xf011;', '&#xf011; fa-power-off'),
(518, 'fa-print', 'fa fa-print', '&#xf02f;', '&#xf02f; fa-print'),
(519, 'fa-product-hunt', 'fa fa-product-hunt', '&#xf288;', '&#xf288; fa-product-hunt'),
(520, 'fa-puzzle-piece', 'fa fa-puzzle-piece', '&#xf12e;', '&#xf12e; fa-puzzle-piece'),
(521, 'fa-qq', 'fa fa-qq', '&#xf1d6;', '&#xf1d6; fa-qq'),
(522, 'fa-qrcode', 'fa fa-qrcode', '&#xf029;', '&#xf029; fa-qrcode'),
(523, 'fa-question', 'fa fa-question', '&#xf128;', '&#xf128; fa-question'),
(524, 'fa-question-circle', 'fa fa-question-circle', '&#xf059;', '&#xf059; fa-question-circle'),
(525, 'fa-question-circle-o', 'fa fa-question-circle-o', '&#xf29c;', '&#xf29c; fa-question-circle-o'),
(526, 'fa-quora', 'fa fa-quora', '&#xf2c4;', '&#xf2c4; fa-quora'),
(527, 'fa-quote-left', 'fa fa-quote-left', '&#xf10d;', '&#xf10d; fa-quote-left'),
(528, 'fa-quote-right', 'fa fa-quote-right', '&#xf10e;', '&#xf10e; fa-quote-right'),
(529, 'fa-ra', 'fa fa-ra', '&#xf1d0;', '&#xf1d0; fa-ra'),
(530, 'fa-random', 'fa fa-random', '&#xf074;', '&#xf074; fa-random'),
(531, 'fa-ravelry', 'fa fa-ravelry', '&#xf2d9;', '&#xf2d9; fa-ravelry'),
(532, 'fa-rebel', 'fa fa-rebel', '&#xf1d0;', '&#xf1d0; fa-rebel'),
(533, 'fa-recycle', 'fa fa-recycle', '&#xf1b8;', '&#xf1b8; fa-recycle'),
(534, 'fa-reddit', 'fa fa-reddit', '&#xf1a1;', '&#xf1a1; fa-reddit'),
(535, 'fa-reddit-alien', 'fa fa-reddit-alien', '&#xf281;', '&#xf281; fa-reddit-alien'),
(536, 'fa-reddit-square', 'fa fa-reddit-square', '&#xf1a2;', '&#xf1a2; fa-reddit-square'),
(537, 'fa-refresh', 'fa fa-refresh', '&#xf021;', '&#xf021; fa-refresh'),
(538, 'fa-registered', 'fa fa-registered', '&#xf25d;', '&#xf25d; fa-registered'),
(539, 'fa-remove', 'fa fa-remove', '&#xf00d;', '&#xf00d; fa-remove'),
(540, 'fa-renren', 'fa fa-renren', '&#xf18b;', '&#xf18b; fa-renren'),
(541, 'fa-reorder', 'fa fa-reorder', '&#xf0c9;', '&#xf0c9; fa-reorder'),
(542, 'fa-repeat', 'fa fa-repeat', '&#xf01e;', '&#xf01e; fa-repeat'),
(543, 'fa-reply', 'fa fa-reply', '&#xf112;', '&#xf112; fa-reply'),
(544, 'fa-reply-all', 'fa fa-reply-all', '&#xf122;', '&#xf122; fa-reply-all'),
(545, 'fa-resistance', 'fa fa-resistance', '&#xf1d0;', '&#xf1d0; fa-resistance'),
(546, 'fa-retweet', 'fa fa-retweet', '&#xf079;', '&#xf079; fa-retweet'),
(547, 'fa-rmb', 'fa fa-rmb', '&#xf157;', '&#xf157; fa-rmb'),
(548, 'fa-road', 'fa fa-road', '&#xf018;', '&#xf018; fa-road'),
(549, 'fa-rocket', 'fa fa-rocket', '&#xf135;', '&#xf135; fa-rocket'),
(550, 'fa-rotate-left', 'fa fa-rotate-left', '&#xf0e2;', '&#xf0e2; fa-rotate-left'),
(551, 'fa-rotate-right', 'fa fa-rotate-right', '&#xf01e;', '&#xf01e; fa-rotate-right'),
(552, 'fa-rouble', 'fa fa-rouble', '&#xf158;', '&#xf158; fa-rouble'),
(553, 'fa-rss', 'fa fa-rss', '&#xf09e;', '&#xf09e; fa-rss'),
(554, 'fa-rss-square', 'fa fa-rss-square', '&#xf143;', '&#xf143; fa-rss-square'),
(555, 'fa-rub', 'fa fa-rub', '&#xf158;', '&#xf158; fa-rub'),
(556, 'fa-ruble', 'fa fa-ruble', '&#xf158;', '&#xf158; fa-ruble'),
(557, 'fa-rupee', 'fa fa-rupee', '&#xf156;', '&#xf156; fa-rupee'),
(558, 'fa-s15', 'fa fa-s15', '&#xf2cd;', '&#xf2cd; fa-s15'),
(559, 'fa-safari', 'fa fa-safari', '&#xf267;', '&#xf267; fa-safari'),
(560, 'fa-save', 'fa fa-save', '&#xf0c7;', '&#xf0c7; fa-save'),
(561, 'fa-scissors', 'fa fa-scissors', '&#xf0c4;', '&#xf0c4; fa-scissors'),
(562, 'fa-scribd', 'fa fa-scribd', '&#xf28a;', '&#xf28a; fa-scribd'),
(563, 'fa-search', 'fa fa-search', '&#xf002;', '&#xf002; fa-search'),
(564, 'fa-search-minus', 'fa fa-search-minus', '&#xf010;', '&#xf010; fa-search-minus'),
(565, 'fa-search-plus', 'fa fa-search-plus', '&#xf00e;', '&#xf00e; fa-search-plus'),
(566, 'fa-sellsy', 'fa fa-sellsy', '&#xf213;', '&#xf213; fa-sellsy'),
(567, 'fa-send', 'fa fa-send', '&#xf1d8;', '&#xf1d8; fa-send'),
(568, 'fa-send-o', 'fa fa-send-o', '&#xf1d9;', '&#xf1d9; fa-send-o'),
(569, 'fa-server', 'fa fa-server', '&#xf233;', '&#xf233; fa-server'),
(570, 'fa-share', 'fa fa-share', '&#xf064;', '&#xf064; fa-share'),
(571, 'fa-share-alt', 'fa fa-share-alt', '&#xf1e0;', '&#xf1e0; fa-share-alt'),
(572, 'fa-share-alt-square', 'fa fa-share-alt-square', '&#xf1e1;', '&#xf1e1; fa-share-alt-square'),
(573, 'fa-share-square', 'fa fa-share-square', '&#xf14d;', '&#xf14d; fa-share-square'),
(574, 'fa-share-square-o', 'fa fa-share-square-o', '&#xf045;', '&#xf045; fa-share-square-o'),
(575, 'fa-shekel', 'fa fa-shekel', '&#xf20b;', '&#xf20b; fa-shekel'),
(576, 'fa-sheqel', 'fa fa-sheqel', '&#xf20b;', '&#xf20b; fa-sheqel'),
(577, 'fa-shield', 'fa fa-shield', '&#xf132;', '&#xf132; fa-shield'),
(578, 'fa-ship', 'fa fa-ship', '&#xf21a;', '&#xf21a; fa-ship'),
(579, 'fa-shirtsinbulk', 'fa fa-shirtsinbulk', '&#xf214;', '&#xf214; fa-shirtsinbulk'),
(580, 'fa-shopping-bag', 'fa fa-shopping-bag', '&#xf290;', '&#xf290; fa-shopping-bag'),
(581, 'fa-shopping-basket', 'fa fa-shopping-basket', '&#xf291;', '&#xf291; fa-shopping-basket'),
(582, 'fa-shopping-cart', 'fa fa-shopping-cart', '&#xf07a;', '&#xf07a; fa-shopping-cart'),
(583, 'fa-shower', 'fa fa-shower', '&#xf2cc;', '&#xf2cc; fa-shower'),
(584, 'fa-sign-in', 'fa fa-sign-in', '&#xf090;', '&#xf090; fa-sign-in'),
(585, 'fa-sign-language', 'fa fa-sign-language', '&#xf2a7;', '&#xf2a7; fa-sign-language'),
(586, 'fa-sign-out', 'fa fa-sign-out', '&#xf08b;', '&#xf08b; fa-sign-out'),
(587, 'fa-signal', 'fa fa-signal', '&#xf012;', '&#xf012; fa-signal'),
(588, 'fa-signing', 'fa fa-signing', '&#xf2a7;', '&#xf2a7; fa-signing'),
(589, 'fa-simplybuilt', 'fa fa-simplybuilt', '&#xf215;', '&#xf215; fa-simplybuilt'),
(590, 'fa-sitemap', 'fa fa-sitemap', '&#xf0e8;', '&#xf0e8; fa-sitemap'),
(591, 'fa-skyatlas', 'fa fa-skyatlas', '&#xf216;', '&#xf216; fa-skyatlas'),
(592, 'fa-skype', 'fa fa-skype', '&#xf17e;', '&#xf17e; fa-skype'),
(593, 'fa-slack', 'fa fa-slack', '&#xf198;', '&#xf198; fa-slack'),
(594, 'fa-sliders', 'fa fa-sliders', '&#xf1de;', '&#xf1de; fa-sliders'),
(595, 'fa-slideshare', 'fa fa-slideshare', '&#xf1e7;', '&#xf1e7; fa-slideshare'),
(596, 'fa-smile-o', 'fa fa-smile-o', '&#xf118;', '&#xf118; fa-smile-o'),
(597, 'fa-snapchat', 'fa fa-snapchat', '&#xf2ab;', '&#xf2ab; fa-snapchat'),
(598, 'fa-snapchat-ghost', 'fa fa-snapchat-ghost', '&#xf2ac;', '&#xf2ac; fa-snapchat-ghost'),
(599, 'fa-snapchat-square', 'fa fa-snapchat-square', '&#xf2ad;', '&#xf2ad; fa-snapchat-square'),
(600, 'fa-snowflake-o', 'fa fa-snowflake-o', '&#xf2dc;', '&#xf2dc; fa-snowflake-o'),
(601, 'fa-soccer-ball-o', 'fa fa-soccer-ball-o', '&#xf1e3;', '&#xf1e3; fa-soccer-ball-o'),
(602, 'fa-sort', 'fa fa-sort', '&#xf0dc;', '&#xf0dc; fa-sort'),
(603, 'fa-sort-alpha-asc', 'fa fa-sort-alpha-asc', '&#xf15d;', '&#xf15d; fa-sort-alpha-asc'),
(604, 'fa-sort-alpha-desc', 'fa fa-sort-alpha-desc', '&#xf15e;', '&#xf15e; fa-sort-alpha-desc'),
(605, 'fa-sort-amount-asc', 'fa fa-sort-amount-asc', '&#xf160;', '&#xf160; fa-sort-amount-asc'),
(606, 'fa-sort-amount-desc', 'fa fa-sort-amount-desc', '&#xf161;', '&#xf161; fa-sort-amount-desc'),
(607, 'fa-sort-asc', 'fa fa-sort-asc', '&#xf0de;', '&#xf0de; fa-sort-asc'),
(608, 'fa-sort-desc', 'fa fa-sort-desc', '&#xf0dd;', '&#xf0dd; fa-sort-desc'),
(609, 'fa-sort-down', 'fa fa-sort-down', '&#xf0dd;', '&#xf0dd; fa-sort-down'),
(610, 'fa-sort-numeric-asc', 'fa fa-sort-numeric-asc', '&#xf162;', '&#xf162; fa-sort-numeric-asc'),
(611, 'fa-sort-numeric-desc', 'fa fa-sort-numeric-desc', '&#xf163;', '&#xf163; fa-sort-numeric-desc'),
(612, 'fa-sort-up', 'fa fa-sort-up', '&#xf0de;', '&#xf0de; fa-sort-up'),
(613, 'fa-soundcloud', 'fa fa-soundcloud', '&#xf1be;', '&#xf1be; fa-soundcloud'),
(614, 'fa-space-shuttle', 'fa fa-space-shuttle', '&#xf197;', '&#xf197; fa-space-shuttle'),
(615, 'fa-spinner', 'fa fa-spinner', '&#xf110;', '&#xf110; fa-spinner'),
(616, 'fa-spoon', 'fa fa-spoon', '&#xf1b1;', '&#xf1b1; fa-spoon'),
(617, 'fa-spotify', 'fa fa-spotify', '&#xf1bc;', '&#xf1bc; fa-spotify'),
(618, 'fa-square', 'fa fa-square', '&#xf0c8;', '&#xf0c8; fa-square'),
(619, 'fa-square-o', 'fa fa-square-o', '&#xf096;', '&#xf096; fa-square-o'),
(620, 'fa-stack-exchange', 'fa fa-stack-exchange', '&#xf18d;', '&#xf18d; fa-stack-exchange'),
(621, 'fa-stack-overflow', 'fa fa-stack-overflow', '&#xf16c;', '&#xf16c; fa-stack-overflow'),
(622, 'fa-star', 'fa fa-star', '&#xf005;', '&#xf005; fa-star'),
(623, 'fa-star-half', 'fa fa-star-half', '&#xf089;', '&#xf089; fa-star-half'),
(624, 'fa-star-half-empty', 'fa fa-star-half-empty', '&#xf123;', '&#xf123; fa-star-half-empty'),
(625, 'fa-star-half-full', 'fa fa-star-half-full', '&#xf123;', '&#xf123; fa-star-half-full'),
(626, 'fa-star-half-o', 'fa fa-star-half-o', '&#xf123;', '&#xf123; fa-star-half-o'),
(627, 'fa-star-o', 'fa fa-star-o', '&#xf006;', '&#xf006; fa-star-o'),
(628, 'fa-steam', 'fa fa-steam', '&#xf1b6;', '&#xf1b6; fa-steam'),
(629, 'fa-steam-square', 'fa fa-steam-square', '&#xf1b7;', '&#xf1b7; fa-steam-square'),
(630, 'fa-step-backward', 'fa fa-step-backward', '&#xf048;', '&#xf048; fa-step-backward'),
(631, 'fa-step-forward', 'fa fa-step-forward', '&#xf051;', '&#xf051; fa-step-forward'),
(632, 'fa-stethoscope', 'fa fa-stethoscope', '&#xf0f1;', '&#xf0f1; fa-stethoscope'),
(633, 'fa-sticky-note', 'fa fa-sticky-note', '&#xf249;', '&#xf249; fa-sticky-note'),
(634, 'fa-sticky-note-o', 'fa fa-sticky-note-o', '&#xf24a;', '&#xf24a; fa-sticky-note-o'),
(635, 'fa-stop', 'fa fa-stop', '&#xf04d;', '&#xf04d; fa-stop'),
(636, 'fa-stop-circle', 'fa fa-stop-circle', '&#xf28d;', '&#xf28d; fa-stop-circle'),
(637, 'fa-stop-circle-o', 'fa fa-stop-circle-o', '&#xf28e;', '&#xf28e; fa-stop-circle-o'),
(638, 'fa-street-view', 'fa fa-street-view', '&#xf21d;', '&#xf21d; fa-street-view'),
(639, 'fa-strikethrough', 'fa fa-strikethrough', '&#xf0cc;', '&#xf0cc; fa-strikethrough'),
(640, 'fa-stumbleupon', 'fa fa-stumbleupon', '&#xf1a4;', '&#xf1a4; fa-stumbleupon'),
(641, 'fa-stumbleupon-circle', 'fa fa-stumbleupon-circle', '&#xf1a3;', '&#xf1a3; fa-stumbleupon-circle'),
(642, 'fa-subscript', 'fa fa-subscript', '&#xf12c;', '&#xf12c; fa-subscript'),
(643, 'fa-subway', 'fa fa-subway', '&#xf239;', '&#xf239; fa-subway'),
(644, 'fa-suitcase', 'fa fa-suitcase', '&#xf0f2;', '&#xf0f2; fa-suitcase');
INSERT INTO `fontawesomes` (`id`, `name`, `value`, `unicode`, `unicodename`) VALUES
(645, 'fa-sun-o', 'fa fa-sun-o', '&#xf185;', '&#xf185; fa-sun-o'),
(646, 'fa-superpowers', 'fa fa-superpowers', '&#xf2dd;', '&#xf2dd; fa-superpowers'),
(647, 'fa-superscript', 'fa fa-superscript', '&#xf12b;', '&#xf12b; fa-superscript'),
(648, 'fa-support', 'fa fa-support', '&#xf1cd;', '&#xf1cd; fa-support'),
(649, 'fa-table', 'fa fa-table', '&#xf0ce;', '&#xf0ce; fa-table'),
(650, 'fa-tablet', 'fa fa-tablet', '&#xf10a;', '&#xf10a; fa-tablet'),
(651, 'fa-tachometer', 'fa fa-tachometer', '&#xf0e4;', '&#xf0e4; fa-tachometer'),
(652, 'fa-tag', 'fa fa-tag', '&#xf02b;', '&#xf02b; fa-tag'),
(653, 'fa-tags', 'fa fa-tags', '&#xf02c;', '&#xf02c; fa-tags'),
(654, 'fa-tasks', 'fa fa-tasks', '&#xf0ae;', '&#xf0ae; fa-tasks'),
(655, 'fa-taxi', 'fa fa-taxi', '&#xf1ba;', '&#xf1ba; fa-taxi'),
(656, 'fa-telegram', 'fa fa-telegram', '&#xf2c6;', '&#xf2c6; fa-telegram'),
(657, 'fa-television', 'fa fa-television', '&#xf26c;', '&#xf26c; fa-television'),
(658, 'fa-tencent-weibo', 'fa fa-tencent-weibo', '&#xf1d5;', '&#xf1d5; fa-tencent-weibo'),
(659, 'fa-terminal', 'fa fa-terminal', '&#xf120;', '&#xf120; fa-terminal'),
(660, 'fa-text-height', 'fa fa-text-height', '&#xf034;', '&#xf034; fa-text-height'),
(661, 'fa-text-width', 'fa fa-text-width', '&#xf035;', '&#xf035; fa-text-width'),
(662, 'fa-th', 'fa fa-th', '&#xf00a;', '&#xf00a; fa-th'),
(663, 'fa-th-large', 'fa fa-th-large', '&#xf009;', '&#xf009; fa-th-large'),
(664, 'fa-th-list', 'fa fa-th-list', '&#xf00b;', '&#xf00b; fa-th-list'),
(665, 'fa-themeisle', 'fa fa-themeisle', '&#xf2b2;', '&#xf2b2; fa-themeisle'),
(666, 'fa-thermometer', 'fa fa-thermometer', '&#xf2c7;', '&#xf2c7; fa-thermometer'),
(667, 'fa-thermometer-0', 'fa fa-thermometer-0', '&#xf2cb;', '&#xf2cb; fa-thermometer-0'),
(668, 'fa-thermometer-1', 'fa fa-thermometer-1', '&#xf2ca;', '&#xf2ca; fa-thermometer-1'),
(669, 'fa-thermometer-2', 'fa fa-thermometer-2', '&#xf2c9;', '&#xf2c9; fa-thermometer-2'),
(670, 'fa-thermometer-3', 'fa fa-thermometer-3', '&#xf2c8;', '&#xf2c8; fa-thermometer-3'),
(671, 'fa-thermometer-4', 'fa fa-thermometer-4', '&#xf2c7;', '&#xf2c7; fa-thermometer-4'),
(672, 'fa-thermometer-empty', 'fa fa-thermometer-empty', '&#xf2cb;', '&#xf2cb; fa-thermometer-empty'),
(673, 'fa-thermometer-full', 'fa fa-thermometer-full', '&#xf2c7;', '&#xf2c7; fa-thermometer-full'),
(674, 'fa-thermometer-half', 'fa fa-thermometer-half', '&#xf2c9;', '&#xf2c9; fa-thermometer-half'),
(675, 'fa-thermometer-quarter', 'fa fa-thermometer-quarter', '&#xf2ca;', '&#xf2ca; fa-thermometer-quarter'),
(676, 'fa-thermometer-three-quarters', 'fa fa-thermometer-three-quarters', '&#xf2c8;', '&#xf2c8; fa-thermometer-three-quarters'),
(677, 'fa-thumb-tack', 'fa fa-thumb-tack', '&#xf08d;', '&#xf08d; fa-thumb-tack'),
(678, 'fa-thumbs-down', 'fa fa-thumbs-down', '&#xf165;', '&#xf165; fa-thumbs-down'),
(679, 'fa-thumbs-o-down', 'fa fa-thumbs-o-down', '&#xf088;', '&#xf088; fa-thumbs-o-down'),
(680, 'fa-thumbs-o-up', 'fa fa-thumbs-o-up', '&#xf087;', '&#xf087; fa-thumbs-o-up'),
(681, 'fa-thumbs-up', 'fa fa-thumbs-up', '&#xf164;', '&#xf164; fa-thumbs-up'),
(682, 'fa-ticket', 'fa fa-ticket', '&#xf145;', '&#xf145; fa-ticket'),
(683, 'fa-times', 'fa fa-times', '&#xf00d;', '&#xf00d; fa-times'),
(684, 'fa-times-circle', 'fa fa-times-circle', '&#xf057;', '&#xf057; fa-times-circle'),
(685, 'fa-times-circle-o', 'fa fa-times-circle-o', '&#xf05c;', '&#xf05c; fa-times-circle-o'),
(686, 'fa-times-rectangle', 'fa fa-times-rectangle', '&#xf2d3;', '&#xf2d3; fa-times-rectangle'),
(687, 'fa-times-rectangle-o', 'fa fa-times-rectangle-o', '&#xf2d4;', '&#xf2d4; fa-times-rectangle-o'),
(688, 'fa-tint', 'fa fa-tint', '&#xf043;', '&#xf043; fa-tint'),
(689, 'fa-toggle-down', 'fa fa-toggle-down', '&#xf150;', '&#xf150; fa-toggle-down'),
(690, 'fa-toggle-left', 'fa fa-toggle-left', '&#xf191;', '&#xf191; fa-toggle-left'),
(691, 'fa-toggle-off', 'fa fa-toggle-off', '&#xf204;', '&#xf204; fa-toggle-off'),
(692, 'fa-toggle-on', 'fa fa-toggle-on', '&#xf205;', '&#xf205; fa-toggle-on'),
(693, 'fa-toggle-right', 'fa fa-toggle-right', '&#xf152;', '&#xf152; fa-toggle-right'),
(694, 'fa-toggle-up', 'fa fa-toggle-up', '&#xf151;', '&#xf151; fa-toggle-up'),
(695, 'fa-trademark', 'fa fa-trademark', '&#xf25c;', '&#xf25c; fa-trademark'),
(696, 'fa-train', 'fa fa-train', '&#xf238;', '&#xf238; fa-train'),
(697, 'fa-transgender', 'fa fa-transgender', '&#xf224;', '&#xf224; fa-transgender'),
(698, 'fa-transgender-alt', 'fa fa-transgender-alt', '&#xf225;', '&#xf225; fa-transgender-alt'),
(699, 'fa-trash', 'fa fa-trash', '&#xf1f8;', '&#xf1f8; fa-trash'),
(700, 'fa-trash-o', 'fa fa-trash-o', '&#xf014;', '&#xf014; fa-trash-o'),
(701, 'fa-tree', 'fa fa-tree', '&#xf1bb;', '&#xf1bb; fa-tree'),
(702, 'fa-trello', 'fa fa-trello', '&#xf181;', '&#xf181; fa-trello'),
(703, 'fa-tripadvisor', 'fa fa-tripadvisor', '&#xf262;', '&#xf262; fa-tripadvisor'),
(704, 'fa-trophy', 'fa fa-trophy', '&#xf091;', '&#xf091; fa-trophy'),
(705, 'fa-truck', 'fa fa-truck', '&#xf0d1;', '&#xf0d1; fa-truck'),
(706, 'fa-try', 'fa fa-try', '&#xf195;', '&#xf195; fa-try'),
(707, 'fa-tty', 'fa fa-tty', '&#xf1e4;', '&#xf1e4; fa-tty'),
(708, 'fa-tumblr', 'fa fa-tumblr', '&#xf173;', '&#xf173; fa-tumblr'),
(709, 'fa-tumblr-square', 'fa fa-tumblr-square', '&#xf174;', '&#xf174; fa-tumblr-square'),
(710, 'fa-turkish-lira', 'fa fa-turkish-lira', '&#xf195;', '&#xf195; fa-turkish-lira'),
(711, 'fa-tv', 'fa fa-tv', '&#xf26c;', '&#xf26c; fa-tv'),
(712, 'fa-twitch', 'fa fa-twitch', '&#xf1e8;', '&#xf1e8; fa-twitch'),
(713, 'fa-twitter', 'fa fa-twitter', '&#xf099;', '&#xf099; fa-twitter'),
(714, 'fa-twitter-square', 'fa fa-twitter-square', '&#xf081;', '&#xf081; fa-twitter-square'),
(715, 'fa-umbrella', 'fa fa-umbrella', '&#xf0e9;', '&#xf0e9; fa-umbrella'),
(716, 'fa-underline', 'fa fa-underline', '&#xf0cd;', '&#xf0cd; fa-underline'),
(717, 'fa-undo', 'fa fa-undo', '&#xf0e2;', '&#xf0e2; fa-undo'),
(718, 'fa-universal-access', 'fa fa-universal-access', '&#xf29a;', '&#xf29a; fa-universal-access'),
(719, 'fa-university', 'fa fa-university', '&#xf19c;', '&#xf19c; fa-university'),
(720, 'fa-unlink', 'fa fa-unlink', '&#xf127;', '&#xf127; fa-unlink'),
(721, 'fa-unlock', 'fa fa-unlock', '&#xf09c;', '&#xf09c; fa-unlock'),
(722, 'fa-unlock-alt', 'fa fa-unlock-alt', '&#xf13e;', '&#xf13e; fa-unlock-alt'),
(723, 'fa-unsorted', 'fa fa-unsorted', '&#xf0dc;', '&#xf0dc; fa-unsorted'),
(724, 'fa-upload', 'fa fa-upload', '&#xf093;', '&#xf093; fa-upload'),
(725, 'fa-usb', 'fa fa-usb', '&#xf287;', '&#xf287; fa-usb'),
(726, 'fa-usd', 'fa fa-usd', '&#xf155;', '&#xf155; fa-usd'),
(727, 'fa-user', 'fa fa-user', '&#xf007;', '&#xf007; fa-user'),
(728, 'fa-user-circle', 'fa fa-user-circle', '&#xf2bd;', '&#xf2bd; fa-user-circle'),
(729, 'fa-user-circle-o', 'fa fa-user-circle-o', '&#xf2be;', '&#xf2be; fa-user-circle-o'),
(730, 'fa-user-md', 'fa fa-user-md', '&#xf0f0;', '&#xf0f0; fa-user-md'),
(731, 'fa-user-o', 'fa fa-user-o', '&#xf2c0;', '&#xf2c0; fa-user-o'),
(732, 'fa-user-plus', 'fa fa-user-plus', '&#xf234;', '&#xf234; fa-user-plus'),
(733, 'fa-user-secret', 'fa fa-user-secret', '&#xf21b;', '&#xf21b; fa-user-secret'),
(734, 'fa-user-times', 'fa fa-user-times', '&#xf235;', '&#xf235; fa-user-times'),
(735, 'fa-users', 'fa fa-users', '&#xf0c0;', '&#xf0c0; fa-users'),
(736, 'fa-vcard', 'fa fa-vcard', '&#xf2bb;', '&#xf2bb; fa-vcard'),
(737, 'fa-vcard-o', 'fa fa-vcard-o', '&#xf2bc;', '&#xf2bc; fa-vcard-o'),
(738, 'fa-venus', 'fa fa-venus', '&#xf221;', '&#xf221; fa-venus'),
(739, 'fa-venus-double', 'fa fa-venus-double', '&#xf226;', '&#xf226; fa-venus-double'),
(740, 'fa-venus-mars', 'fa fa-venus-mars', '&#xf228;', '&#xf228; fa-venus-mars'),
(741, 'fa-viacoin', 'fa fa-viacoin', '&#xf237;', '&#xf237; fa-viacoin'),
(742, 'fa-viadeo', 'fa fa-viadeo', '&#xf2a9;', '&#xf2a9; fa-viadeo'),
(743, 'fa-viadeo-square', 'fa fa-viadeo-square', '&#xf2aa;', '&#xf2aa; fa-viadeo-square'),
(744, 'fa-video-camera', 'fa fa-video-camera', '&#xf03d;', '&#xf03d; fa-video-camera'),
(745, 'fa-vimeo', 'fa fa-vimeo', '&#xf27d;', '&#xf27d; fa-vimeo'),
(746, 'fa-vimeo-square', 'fa fa-vimeo-square', '&#xf194;', '&#xf194; fa-vimeo-square'),
(747, 'fa-vine', 'fa fa-vine', '&#xf1ca;', '&#xf1ca; fa-vine'),
(748, 'fa-vk', 'fa fa-vk', '&#xf189;', '&#xf189; fa-vk'),
(749, 'fa-volume-control-phone', 'fa fa-volume-control-phone', '&#xf2a0;', '&#xf2a0; fa-volume-control-phone'),
(750, 'fa-volume-down', 'fa fa-volume-down', '&#xf027;', '&#xf027; fa-volume-down'),
(751, 'fa-volume-off', 'fa fa-volume-off', '&#xf026;', '&#xf026; fa-volume-off'),
(752, 'fa-volume-up', 'fa fa-volume-up', '&#xf028;', '&#xf028; fa-volume-up'),
(753, 'fa-warning', 'fa fa-warning', '&#xf071;', '&#xf071; fa-warning'),
(754, 'fa-wechat', 'fa fa-wechat', '&#xf1d7;', '&#xf1d7; fa-wechat'),
(755, 'fa-weibo', 'fa fa-weibo', '&#xf18a;', '&#xf18a; fa-weibo'),
(756, 'fa-weixin', 'fa fa-weixin', '&#xf1d7;', '&#xf1d7; fa-weixin'),
(757, 'fa-whatsapp', 'fa fa-whatsapp', '&#xf232;', '&#xf232; fa-whatsapp'),
(758, 'fa-wheelchair', 'fa fa-wheelchair', '&#xf193;', '&#xf193; fa-wheelchair'),
(759, 'fa-wheelchair-alt', 'fa fa-wheelchair-alt', '&#xf29b;', '&#xf29b; fa-wheelchair-alt'),
(760, 'fa-wifi', 'fa fa-wifi', '&#xf1eb;', '&#xf1eb; fa-wifi'),
(761, 'fa-wikipedia-w', 'fa fa-wikipedia-w', '&#xf266;', '&#xf266; fa-wikipedia-w'),
(762, 'fa-window-close', 'fa fa-window-close', '&#xf2d3;', '&#xf2d3; fa-window-close'),
(763, 'fa-window-close-o', 'fa fa-window-close-o', '&#xf2d4;', '&#xf2d4; fa-window-close-o'),
(764, 'fa-window-maximize', 'fa fa-window-maximize', '&#xf2d0;', '&#xf2d0; fa-window-maximize'),
(765, 'fa-window-minimize', 'fa fa-window-minimize', '&#xf2d1;', '&#xf2d1; fa-window-minimize'),
(766, 'fa-window-restore', 'fa fa-window-restore', '&#xf2d2;', '&#xf2d2; fa-window-restore'),
(767, 'fa-windows', 'fa fa-windows', '&#xf17a;', '&#xf17a; fa-windows'),
(768, 'fa-won', 'fa fa-won', '&#xf159;', '&#xf159; fa-won'),
(769, 'fa-wordpress', 'fa fa-wordpress', '&#xf19a;', '&#xf19a; fa-wordpress'),
(770, 'fa-wpbeginner', 'fa fa-wpbeginner', '&#xf297;', '&#xf297; fa-wpbeginner'),
(771, 'fa-wpexplorer', 'fa fa-wpexplorer', '&#xf2de;', '&#xf2de; fa-wpexplorer'),
(772, 'fa-wpforms', 'fa fa-wpforms', '&#xf298;', '&#xf298; fa-wpforms'),
(773, 'fa-wrench', 'fa fa-wrench', '&#xf0ad;', '&#xf0ad; fa-wrench'),
(774, 'fa-xing', 'fa fa-xing', '&#xf168;', '&#xf168; fa-xing'),
(775, 'fa-xing-square', 'fa fa-xing-square', '&#xf169;', '&#xf169; fa-xing-square'),
(776, 'fa-y-combinator', 'fa fa-y-combinator', '&#xf23b;', '&#xf23b; fa-y-combinator'),
(777, 'fa-y-combinator-square', 'fa fa-y-combinator-square', '&#xf1d4;', '&#xf1d4; fa-y-combinator-square'),
(778, 'fa-yahoo', 'fa fa-yahoo', '&#xf19e;', '&#xf19e; fa-yahoo'),
(779, 'fa-yc', 'fa fa-yc', '&#xf23b;', '&#xf23b; fa-yc'),
(780, 'fa-yc-square', 'fa fa-yc-square', '&#xf1d4;', '&#xf1d4; fa-yc-square'),
(781, 'fa-yelp', 'fa fa-yelp', '&#xf1e9;', '&#xf1e9; fa-yelp'),
(782, 'fa-yen', 'fa fa-yen', '&#xf157;', '&#xf157; fa-yen'),
(783, 'fa-yoast', 'fa fa-yoast', '&#xf2b1;', '&#xf2b1; fa-yoast'),
(784, 'fa-youtube', 'fa fa-youtube', '&#xf167;', '&#xf167; fa-youtube'),
(785, 'fa-youtube-play', 'fa fa-youtube-play', '&#xf16a;', '&#xf16a; fa-youtube-play'),
(786, 'fa-youtube-square', 'fa fa-youtube-square', '&#xf166;', '&#xf166; fa-youtube-square');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image`, `info`, `token`) VALUES
(36, '20200210_130231.jpg', '1963570', '0.4216578668099298'),
(34, '20200210_130212.jpg', '1768101', '0.5285961615331278'),
(35, '20200210_130159.jpg', '1801827', '0.6192822473819066'),
(33, '20200210_121859.jpg', '1304083', '0.6131653774891355'),
(32, '20200210_121839.jpg', '2049385', '0.8805301038638089'),
(30, '20200210_121828.jpg', '1532797', '0.5009655559472379');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(11) NOT NULL,
  `gender_name` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `gender_name`) VALUES
(1, 'Female'),
(2, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `link_name` varchar(64) NOT NULL,
  `link_icon` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `link_name`, `link_icon`) VALUES
(1, 'facebook', 'fa fa-facebook'),
(2, 'instagram', 'fa fa-instagram'),
(3, 'twitter', 'fa fa-twitter'),
(4, 'youtube', 'fa fa-youtube-play'),
(5, 'github', 'fa fa-github'),
(6, 'linkedin', 'fa fa-linkedin-square'),
(7, 'tumblr', 'fa fa-tumblr');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(32) NOT NULL,
  `customer_name` varchar(64) NOT NULL,
  `customer_phone` varchar(16) NOT NULL,
  `bank_name` varchar(16) DEFAULT NULL,
  `no_rek` varchar(32) DEFAULT NULL,
  `customer_address` text NOT NULL,
  `order_date` date NOT NULL,
  `gross_amount` int(11) NOT NULL,
  `ship_amount` int(11) NOT NULL,
  `service_charge_rate` int(11) NOT NULL,
  `service_charge` int(11) NOT NULL,
  `vat_charge_rate` int(11) NOT NULL,
  `vat_charge` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `after_discount` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `paid_status` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_create` varchar(32) NOT NULL,
  `user_update` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_phone`, `bank_name`, `no_rek`, `customer_address`, `order_date`, `gross_amount`, `ship_amount`, `service_charge_rate`, `service_charge`, `vat_charge_rate`, `vat_charge`, `discount`, `after_discount`, `net_amount`, `paid_status`, `created_at`, `updated_at`, `user_create`, `user_update`) VALUES
('ORDER0002', 'Kuntul Aji', '089098765432', 'BCA', '112233445566', 'Jalan qwe qwe qwe q we qw e qw', '2020-04-08', 59000, 0, 5, 2950, 10, 5900, 0, 0, 56050, 'Lunas', '2020-04-08 20:44:21', '0000-00-00 00:00:00', 'admin@adminprinting.com', ''),
('ORDER0001', 'Heru Jos', '081234567890', 'BCA', '112233445566', 'Jalan asd asd as da sd as da sd', '2020-04-08', 278000, 0, 5, 13900, 10, 27800, 5, 0, 228715, 'Lunas', '2020-04-08 20:36:28', '0000-00-00 00:00:00', 'admin@adminprinting.com', ''),
('ORDER0003', 'Gerrard Pique', '081234567890', 'BCA', '112233445566', 'Jalan zxc zxcz xc zxa sd q', '2020-04-08', 440000, 0, 5, 22000, 10, 44000, 0, 0, 506000, 'Belum Lunas', '2020-04-08 20:45:26', '0000-00-00 00:00:00', 'admin@adminprinting.com', ''),
('ORDER0004', 'Bagus Mangsoi', '081234567890', 'BCA', '112233445566', 'Jalanasd qwe qw e qw e qw eq  asd a s', '2020-04-08', 65000, 0, 5, 3250, 10, 6500, 0, 0, 74750, 'Belum Lunas', '2020-04-08 20:46:37', '0000-00-00 00:00:00', 'admin@adminprinting.com', ''),
('ORDER0005', 'Janur W', '089111222333', 'BNI', '7766554433', 'zsdf asdfasdf asd fasdfsdf', '2020-05-30', 11800, 0, 5, 590, 10, 1180, 0, 0, 13570, 'Lunas', '2020-05-30 22:55:33', '0000-00-00 00:00:00', 'admin@adminprinting.com', ''),
('ORDER0006', 'Joni A', '08912312312', 'asdasd', '123123123', 'asdasd asd asd ad', '2020-06-03', 300000, 0, 5, 15000, 10, 30000, 5, 17250, 327750, 'Lunas', '2020-06-03 23:24:50', '0000-00-00 00:00:00', 'admin@adminprinting.com', ''),
('ORDER0007', 'Wakaw', '1231231231', 'asdasd', '123123123', 'asdasdasdasd', '2020-06-04', 75000, 18000, 5, 3750, 10, 7500, 5, 5213, 99038, 'Lunas', '2020-06-04 00:43:19', '0000-00-00 00:00:00', 'admin@adminprinting.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `qty`, `unit_price`, `amount`) VALUES
(12, 'ORDER0001', 'PRDCT-0420-085050', 10, 12800, 128000),
(13, 'ORDER0002', 'PRDCT-0420-084902', 4, 11800, 47200),
(11, 'ORDER0001', 'PRDCT-0420-085449', 10, 7500, 75000),
(14, 'ORDER0003', 'PRDCT-0320-164257', 5, 60000, 300000),
(15, 'ORDER0003', 'PRDCT-0320-153504', 2, 70000, 140000),
(16, 'ORDER0004', 'PRDCT-0420-084545', 5, 2500, 12500),
(17, 'ORDER0004', 'PRDCT-0420-085344', 5, 10500, 52500),
(18, 'ORDER0005', 'PRDCT-0420-084902', 1, 11800, 11800),
(20, 'ORDER0006', 'PRDCT-0320-164257', 5, 60000, 300000),
(21, 'ORDER0007', 'PRDCT-0420-085449', 10, 7500, 75000);

-- --------------------------------------------------------

--
-- Table structure for table `order_piutang`
--

CREATE TABLE `order_piutang` (
  `id` int(11) NOT NULL,
  `piutang_id` varchar(32) NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `piutang_paid_history` date NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `remaining_paid` int(11) NOT NULL,
  `user_create` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_piutang`
--

INSERT INTO `order_piutang` (`id`, `piutang_id`, `order_id`, `piutang_paid_history`, `amount_paid`, `remaining_paid`, `user_create`) VALUES
(14, 'PIUTANG-2045260420', 'ORDER0003', '2020-04-08', 350000, 156000, 'admin@adminprinting.com'),
(15, 'PIUTANG-2046200420', 'ORDER0004', '0000-00-00', 50000, 24750, 'admin@adminprinting.com'),
(16, 'PIUTANG-2046370420', 'ORDER0004', '2020-04-08', 50000, 24750, 'admin@adminprinting.com'),
(17, 'PIUTANG-1958520420', 'ORDER0005', '0000-00-00', 0, 80500, 'admin@adminprinting.com');

-- --------------------------------------------------------

--
-- Table structure for table `order_returns`
--

CREATE TABLE `order_returns` (
  `id` varchar(32) NOT NULL,
  `retur_date` date NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `gross_amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(64) DEFAULT NULL,
  `user_create` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_returns`
--

INSERT INTO `order_returns` (`id`, `retur_date`, `order_id`, `gross_amount`, `discount`, `net_amount`, `keterangan`, `status`, `user_create`) VALUES
('RO080420-0001', '2020-04-08', 'ORDER0001', 75000, 0, 75000, NULL, NULL, 'admin@adminprinting.com'),
('RO080420-0002', '2020-04-08', 'ORDER0002', 11800, 0, 11800, NULL, NULL, 'admin@adminprinting.com');

-- --------------------------------------------------------

--
-- Table structure for table `order_return_details`
--

CREATE TABLE `order_return_details` (
  `retur_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `description` text DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_return_details`
--

INSERT INTO `order_return_details` (`retur_id`, `product_id`, `description`, `qty`, `unit_price`, `amount`) VALUES
('RO080420-0001', 'PRDCT-0420-085449', 'Kurang manis', 10, 7500, 75000),
('RO080420-0002', 'PRDCT-0420-084902', 'Warnanya ungu', 1, 11800, 11800);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(32) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `category_id` varchar(32) NOT NULL,
  `supplier_id` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `slug`, `category_id`, `supplier_id`, `description`, `qty`, `price`, `weight`, `availability`, `created_at`, `updated_at`) VALUES
('PRDCT-0420-084545', 'Indomie Goreng', 'indomie-goreng', '2', 'SPL0003', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 15, 3500, 200, 0, '2020-07-04 13:47:48', '2020-07-31 15:31:10'),
('PRDCT-0320-164257', 'Kaos Catton Combed 20s', 'kaos-catton-combed-20s', '6', 'SPL0004', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 20, 66500, 200, 0, '2020-03-19 22:44:26', '2020-09-14 19:49:38'),
('PRDCT-0320-153504', 'Celana Jeans Aja', 'celana-jeans-aja', '6', 'SPL0004', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 19, 251100, 200, 0, '2020-03-21 21:35:41', '2020-07-31 15:28:28'),
('PRDCT-0420-084902', 'Pepsi Blue', 'pepsi-blue', '3', 'SPL0003', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 25, 11210, 200, 0, '2020-04-07 13:50:14', '2020-07-31 15:31:16'),
('PRDCT-0420-085050', 'Energen', 'energen', '3', 'SPL0005', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 50, 7000, 200, 0, '2020-04-07 13:52:43', '2020-07-31 15:31:22'),
('PRDCT-0420-085344', 'Slai Olai', 'slai-olai', '2', 'SPL0005', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 45, 6000, 200, 0, '2020-04-07 13:54:20', '2020-07-31 15:31:28'),
('PRDCT-0420-085449', 'TOP Coffee', 'top-coffee', '3', 'SPL0002', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 80, 7125, 200, 0, '2020-04-07 13:55:58', '2020-09-14 19:51:26'),
('PRDCT-0420-085606', 'Pulpy Orange', 'pulpy-orange', '3', 'SPL0003', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 20, 3800, 200, 0, '2020-04-07 13:57:40', '2020-07-31 15:31:39'),
('PRDCT-0620-162750', 'Coca Cola', 'coca-cola', '3', 'SPL0003', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 100, 10000, 200, 0, '2020-06-11 21:29:20', '2020-07-31 15:31:45'),
('PRDCT-0720-135500', 'Cleone Baju Atasan Wanita Blus Casual Tangan Balon', 'cleone-baju-atasan-wanita-blus-casual-tangan-balon', '7', 'SPL0004', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 20, 98000, 200, 0, '2020-07-21 13:55:16', '0000-00-00 00:00:00'),
('PRDCT-0820-235857', 'Vans Authentic Full Black', 'vans-authentic-full-black', '8', 'SPL0006', 'The Authentic, Vans original and now iconic style, is a simple low top, lace-up with durable canvas upper, metal eyelets, Vans flag label and Vans original Waffle Outsole.', 50, 500000, 200, 0, '2020-08-07 00:00:10', '0000-00-00 00:00:00'),
('PRDCT-0820-000021', 'Vans Authentic Black White', 'vans-authentic-black-white', '8', 'SPL0006', 'The Authentic, Vans original and now iconic style, is a simple low top, lace-up with durable canvas upper, metal eyelets, Vans flag label and Vans original Waffle Outsole.', 48, 500000, 200, 0, '2020-08-07 00:01:22', '0000-00-00 00:00:00'),
('PRDCT-0820-000131', 'Vans Pig suede Authentic', 'vans-pig-suede-authentic', '8', 'SPL0006', 'The Pig Suede Authentic combines the original and now iconic Vans low top style with sturdy suede uppers, metal eyelets, and signature rubber waffle outsoles.', 50, 600000, 200, 0, '2020-08-07 00:02:57', '0000-00-00 00:00:00'),
('PRDCT-0820-000321', 'Vans Prism Suede Authentic', 'vans-prism-suede-authentic', '8', 'SPL0006', 'The Prism Suede Authentic combines the original and now iconic Vans low top style with metallic suede uppers, metal eyelets, and signature rubber waffle outsoles.', 49, 600000, 200, 0, '2020-08-07 00:04:16', '0000-00-00 00:00:00'),
('PRDCT-0820-000504', 'Vans Gum Authentic', 'vans-gum-authentic', '8', 'SPL0006', 'The Gum Authentic combines the original and now iconic Vans low top style with sturdy canvas uppers, metal eyelets, gum-colored sidewalls, and signature rubber waffle', 50, 500000, 200, 0, '2020-08-07 00:05:37', '0000-00-00 00:00:00'),
('PRDCT-0820-000712', 'Vans Off The Wall Classic Circle V Tee', 'vans-off-the-wall-classic-circle-v-tee', '6', 'SPL0006', 'Everyone needs a T-shirt they can rely on. The Off The Wall Classic Circle V Short Sleeve T-Shirt will end your search for the perfect tee so you can focus on the more important things. Featuring an interior waffle print that pulls moisture away from the skin, this new tee keeps you comfortable and dry while sturdy-spun yarn provides durability and minimizes shrinking. With high-density Circle V screen prints, a bound rib collar and reinforced shoulder seams, premium Vans trims, and a checkerboard hanger loop, the Off The Wall™ tee will be the last T-shirt you\'ll ever need. Fit type: classic. Model is 6 feet tall and wearing a size Medium.', 47, 345000, 200, 0, '2020-08-07 00:08:03', '2020-08-07 00:13:14'),
('PRDCT-0820-000953', 'Vans Off The Wall Classic Tee', 'vans-off-the-wall-classic-tee', '6', 'SPL0006', 'Everyone needs a T-shirt they can rely on. The Off The Wall Classic Circle V Short Sleeve T-Shirt will end your search for the perfect tee so you can focus on the more important things. Featuring an interior waffle print that pulls moisture away from the skin, this new tee keeps you comfortable and dry while sturdy-spun yarn provides durability and minimizes shrinking. With high-density Circle V screen prints, a bound rib collar and reinforced shoulder seams, premium Vans trims, and a checkerboard hanger loop, the Off The Wall™ tee will be the last T-shirt you\'ll ever need. Fit type: classic. Model is 6 feet tall and wearing a size Medium.', 48, 345000, 200, 0, '2020-08-07 00:13:04', '0000-00-00 00:00:00'),
('PRDCT-0820-001318', 'Vans Off The Wall Classic Graphic Long Sleeve Tee', 'vans-off-the-wall-classic-graphic-long-sleeve-tee', '6', 'SPL0006', 'Everyone needs a T-shirt they can rely on. The Off The Wall Classic Graphic Long Sleeve T-Shirt will end your search for the perfect tee so you can focus on the more important things. Featuring an interior waffle print that pulls moisture away from the skin, this new tee keeps you comfortable and dry while sturdy-spun yarn provides durability and minimizes shrinking. With high-density screen prints, a bound rib collar and reinforced shoulder seams, premium Vans trims, and a checkerboard hanger loop, the Off The Wall™ tee will be the last T-shirt you\'ll ever need. Fit type: classic. Model is 6 feet tall and wearing a size Medium.', 47, 395000, 200, 0, '2020-08-07 00:14:46', '0000-00-00 00:00:00'),
('PRDCT-0820-001521', 'Vans Off The Wall Classic Stripe Long Sleeve Tee', 'vans-off-the-wall-classic-stripe-long-sleeve-tee', '6', 'SPL0006', 'Everyone needs a T-shirt they can rely on. The Off The Wall Classic Stripe Long Sleeve T-Shirt will end your search for the perfect tee so you can focus on the more important things. Featuring an interior waffle print that pulls moisture away from the skin, this new tee keeps you comfortable and dry while sturdy-spun yarn provides durability and minimizes shrinking. With allover stripes, a bound rib collar and reinforced shoulder seams, premium Vans trims, and a checkerboard hanger loop, the Off The Wall™ tee will be the last T-shirt you\'ll ever need. Fit type: classic. Model is 6 feet tall and wearing a size Medium.', 44, 445000, 200, 0, '2020-08-07 00:16:06', '0000-00-00 00:00:00'),
('PRDCT-0820-001626', 'Vans Off The Wall Classic Long Sleeve Tee', 'vans-off-the-wall-classic-long-sleeve-tee', '6', 'SPL0006', 'Everyone needs a T-shirt they can rely on. The Off The Wall Classic Long Sleeve T-Shirt will end your search for the perfect tee so you can focus on the more important things. Featuring an interior waffle print that pulls moisture away from the skin, this new tee keeps you comfortable and dry while sturdy-spun yarn provides durability and minimizes shrinking. With a bound rib collar and reinforced shoulder seams, premium Vans trims, an embroidered chest patch, and a checkerboard hanger loop, the Off The Wall™ tee will be the last T-shirt you\'ll ever need. Fit type: classic. Model is 6 feet tall and wearing a size Medium.', 47, 395000, 200, 0, '2020-08-07 00:17:33', '0000-00-00 00:00:00'),
('PRDCT-0820-001900', 'Converse Seasonal Color Chuck 70', 'converse-seasonal-color-chuck-70', '8', 'SPL0007', 'The Chuck 70 mixes the best details from the ’70s-era Chuck with impeccable craftsmanship and premium materials. An elevated style icon, it features more cushioning to keep you looking—and feeling—good all day. The Chuck 70 holds its own on fashion week runways and city streets, making it the go-to sneaker for those looking to enhance and express their style. This edition goes old school with a palette of trendy throwback colors.', 47, 850000, 200, 0, '2020-08-07 00:20:29', '0000-00-00 00:00:00'),
('PRDCT-0820-002347', 'Converse Women\'s Chuck Taylor All Star Move High Top', 'converse-women-s-chuck-taylor-all-star-move-high-top', '8', 'SPL0007', 'LIGHT AND LIFTED. Up the height and the attitude in the new Chuck Taylor All Star Move. A bold, projectile platform brings an unexpected edge, without the bulky weight. Subtle changes like a jungle-cloth construction, houndstooth accents, printed lace tips and transparent patches put a fresh spin on your everyday Chucks.', 48, 700000, 200, 0, '2020-08-07 00:24:31', '0000-00-00 00:00:00'),
('PRDCT-0820-002517', 'Converse Seasonal Color Chuck Taylor All Star', 'converse-seasonal-color-chuck-taylor-all-star', '8', 'SPL0007', 'We could tell you that it’s the OG basketball shoe, created over 100 years ago. Or that the design has largely stayed the same, because why mess with a good thing. Or how it became the unofficial sneaker of all your favorite artists and musicians, who each made it their own. Yeah, we could share a lot of stories, but the one that matters most isn’t ours—it’s yours. It’s how and where you take your Chucks. The legacy is long, but what comes next is up to you. We just make the shoe. You make the stories.', 49, 550000, 200, 0, '2020-08-07 00:26:30', '0000-00-00 00:00:00'),
('PRDCT-0820-002811', 'Converse Chuck Taylor All Star By You', 'converse-chuck-taylor-all-star-by-you', '8', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 49, 1000000, 200, 0, '2020-08-07 00:30:53', '0000-00-00 00:00:00'),
('PRDCT-0820-003058', 'Converse Chuck Taylor All Star', 'converse-chuck-taylor-all-star', '8', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 43, 500000, 200, 0, '2020-08-07 00:31:41', '0000-00-00 00:00:00'),
('PRDCT-0820-003415', 'Converse Wordmark Long Sleeve Black', 'converse-wordmark-long-sleeve-black', '6', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 50, 345000, 200, 0, '2020-08-07 00:34:45', '0000-00-00 00:00:00'),
('PRDCT-0820-003451', 'Converse Wordmark Long Sleeve White', 'converse-wordmark-long-sleeve-white', '6', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 49, 345000, 200, 0, '2020-08-07 00:35:28', '0000-00-00 00:00:00'),
('PRDCT-0820-003633', 'Converse Chuck Taylor Patch Tee', 'converse-chuck-taylor-patch-tee', '6', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 46, 345000, 200, 0, '2020-08-07 00:36:59', '0000-00-00 00:00:00'),
('PRDCT-0820-003722', 'Converse Carpenter Crew', 'converse-carpenter-crew', '9', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 39, 356000, 200, 0, '2020-08-07 00:37:43', '2020-09-10 13:35:51'),
('PRDCT-0820-003802', 'Converse Removeable Hooded Crew', 'converse-removeable-hooded-crew', '9', 'SPL0007', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 42, 500000, 200, 0, '2020-08-07 00:38:25', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE `product_brands` (
  `id` varchar(32) NOT NULL,
  `brand_name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_name`) VALUES
(2, 'Makanan'),
(3, 'Minuman'),
(4, 'Perkakas'),
(6, 'Pakaian'),
(7, 'Atasan Wanita'),
(8, 'Sneakers'),
(9, 'Jaket & Sweater'),
(10, 'Pants');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `image` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `image`, `info`, `token`) VALUES
(54, 'PRDCT-0320-153504', '20200210_125351.jpg', '1472492', '0.35816880202794077'),
(55, 'PRDCT-0320-153504', '20200210_125532.jpg', '1935201', '0.5990858355443964'),
(49, 'PRDCT-0320-153504', 'quicksquarenew_2020222145411981.jpg', '1153644', '0.6562101162368696'),
(50, 'PRDCT-0320-153504', 'quicksquarenew_2020222145341416.jpg', '705214', '0.1976554755138824'),
(48, 'PRDCT-0320-153504', 'quicksquarenew_202022214538589.jpg', '642171', '0.22063373275792553'),
(271, 'PRDCT-0320-164257', '7789298d69a05f71be076594a7360c69.jpg', '1801827', '0.34234362686667685'),
(270, 'PRDCT-0320-164257', '7af150d442eb38312f4576b50a9463e5.jpg', '1963570', '0.23992640773448137'),
(269, 'PRDCT-0320-164257', 'bcd085c1bfb255be9d8e0a343467dfe5.jpg', '1447920', '0.2764077184788649'),
(63, 'PRDCT-0420-084545', 'indomie_2.jpg', '45761', '0.17410627672707624'),
(64, 'PRDCT-0420-084545', 'indomie_1.jpg', '45761', '0.6358790363001641'),
(65, 'PRDCT-0420-084545', 'indomie_3.jpg', '45761', '0.5527271046977111'),
(66, 'PRDCT-0420-084545', 'indomie_4.jpg', '45761', '0.10886534778448165'),
(67, 'PRDCT-0420-084902', 'pepsi_1.jpg', '119725', '0.9488297918681423'),
(68, 'PRDCT-0420-084902', 'pepsi_3.jpg', '119725', '0.6099229595835272'),
(69, 'PRDCT-0420-084902', 'pepsi_4.jpg', '119725', '0.2812584810179337'),
(70, 'PRDCT-0420-084902', 'pepsi_2.jpg', '119725', '0.9413411348309104'),
(71, 'PRDCT-0420-085050', 'energen_1.jpg', '80557', '0.911449467706708'),
(72, 'PRDCT-0420-085050', 'energen_3.jpg', '80557', '0.955554529256567'),
(73, 'PRDCT-0420-085050', 'energen_2.jpg', '80557', '0.26395239388566116'),
(74, 'PRDCT-0420-085050', 'energen_4.jpg', '80557', '0.5287389980338815'),
(75, 'PRDCT-0420-085344', 'slaiolai_1.jpg', '57936', '0.8205451224480165'),
(76, 'PRDCT-0420-085344', 'slaiolai_2.jpg', '57936', '0.825646369525574'),
(77, 'PRDCT-0420-085344', 'slaiolai_4.jpg', '57936', '0.9846936436950675'),
(78, 'PRDCT-0420-085344', 'slaiolai_3.jpg', '57936', '0.83335123398172'),
(275, 'PRDCT-0420-085449', 'd9745860b9a85b6cb8e31ca621d68a78.jpg', '37633', '0.5074674953355063'),
(276, 'PRDCT-0420-085449', '673c9ee6506b22f10d68a179da3dbf0d.jpg', '81919', '0.33906288168367826'),
(83, 'PRDCT-0420-085606', 'pulpy_3.jpg', '28556', '0.9993633687417762'),
(84, 'PRDCT-0420-085606', 'pulpy_2.jpg', '28556', '0.34776784292780416'),
(85, 'PRDCT-0420-085606', 'pulpy_4.jpg', '28556', '0.94326726703857'),
(86, 'PRDCT-0420-085606', 'pulpy_1.jpg', '28556', '0.16444895713549723'),
(92, 'PRDCT-0620-162750', '3294f5f13311244364b0e8de5542bb56.jpg', '284774', '0.419039513414013'),
(91, 'PRDCT-0620-162750', '71b5ff2f388ed8d89fbdd827294aa64b.jpg', '284774', '0.44719832915583946'),
(93, 'PRDCT-0620-162750', '94370806ec7aa627f8c4b0f261f2e92f.jpg', '284774', '0.28841010523416855'),
(96, 'PRDCT-0620-162750', '022a0215e638a96f48fa86cd4a0196d0.jpg', '284774', '0.21401067678230268'),
(104, 'PRDCT-0720-135500', 'ef87fc81534edeb01a47ff5556967dc8.jpg', '81919', '0.5204736950074054'),
(103, 'PRDCT-0720-135500', '76335d328ff6def804392ff4bbabd72e.jpg', '81919', '0.4651121717298694'),
(102, 'PRDCT-0720-135500', '9ee5c29d73b3b0bbddfe0b611243dddb.jpg', '81919', '0.24637458017285008'),
(101, 'PRDCT-0720-135500', 'a27d16ea2635f5fe8431c329bc01eeb6.jpg', '81919', '0.054178442779362124'),
(105, 'PRDCT-0820-235857', '43dece7da5368a8a58c334631d79e874.png', '153187', '0.5885831054841573'),
(106, 'PRDCT-0820-235857', '548eebbc1382754507e47304c009e1c8.png', '153187', '0.10972242373085828'),
(108, 'PRDCT-0820-235857', '639ab89f091b0762b710941cc9e5aa75.png', '153187', '0.36004820547066196'),
(109, 'PRDCT-0820-235857', '03e9532afc6202afa41af857f799dcec.png', '153187', '0.14678992525892887'),
(110, 'PRDCT-0820-000021', 'a953be4881f8e5348b530e06c2b377d3.png', '185477', '0.7217583559414906'),
(111, 'PRDCT-0820-000021', 'c057081141e12128f4bc80bda3f6994a.png', '185477', '0.15918423736093756'),
(112, 'PRDCT-0820-000021', '6d0050e58b27eae5e404d4c8045fc845.png', '185477', '0.481267350586952'),
(113, 'PRDCT-0820-000021', '5985317e31aa04c883e919f7be3b9055.png', '185477', '0.644543236915998'),
(114, 'PRDCT-0820-000021', 'e344dab49c1b993fdf5b434c9b3205df.png', '185477', '0.5642275812353692'),
(115, 'PRDCT-0820-000131', '05503d96aaf45e04e57d33249d15b048.png', '209715', '0.48658772488128843'),
(116, 'PRDCT-0820-000131', 'ec0c42a53ad41adb51a5e3379612f8b2.png', '209715', '0.11744742480530124'),
(117, 'PRDCT-0820-000131', '79c0d97d56479145ef61b86790ed592d.png', '209715', '0.3105942344435295'),
(118, 'PRDCT-0820-000131', 'd0d997cd51b9bb0f030ab5d3aa5438f5.png', '209715', '0.4558630939577244'),
(119, 'PRDCT-0820-000131', 'dfe0d98f7aaf83d0f5e32994dd1e8edb.png', '209715', '0.6509112244416344'),
(120, 'PRDCT-0820-000321', '3566c45f3e9df206d597f1df6e0e1113.png', '178211', '0.18121534813167828'),
(121, 'PRDCT-0820-000321', '7020d718673dc320b254b652f9c26ff6.png', '178211', '0.7284586582771282'),
(122, 'PRDCT-0820-000321', 'a2176bf5a71b84fe6617e9a7b4c66e9e.png', '178211', '0.7665830301106207'),
(123, 'PRDCT-0820-000321', '7ee06863655508bf6ba4037e168900a7.png', '178211', '0.7586770900469761'),
(124, 'PRDCT-0820-000321', '7fd96317d7b8b305f794fa0c9d0732f8.png', '178211', '0.3461956619191422'),
(125, 'PRDCT-0820-000504', '7c0bb5cd0bed29f852435a8157d96b3c.png', '166634', '0.24617400511617404'),
(126, 'PRDCT-0820-000504', '181b8c99e5805a24268043020e00ee81.png', '166634', '0.8804071928703994'),
(127, 'PRDCT-0820-000504', '75d5ed82f12744b01e62871cfa04a7f8.png', '166634', '0.5640431244363124'),
(128, 'PRDCT-0820-000504', 'cb434df1a89dfb6c1746dadf9daaa86b.png', '166634', '0.4521466330039987'),
(129, 'PRDCT-0820-000504', 'f7b3e5de3d03c5bb9131bd1292651368.png', '166634', '0.25233395549415394'),
(130, 'PRDCT-0820-000712', '9558fd97cbcf599049dd0b95e3f6b1f4.png', '141415', '0.24877332104887673'),
(131, 'PRDCT-0820-000712', '38ae7e47aa949a9ae0f39e12d9d2169b.png', '141415', '0.04777059835548325'),
(132, 'PRDCT-0820-000712', '1c44a2bc381fb48c0fbc4538f038ff14.png', '141415', '0.5654951428869635'),
(133, 'PRDCT-0820-000712', 'ceb1c5df6d9055a3c73d67ea14835065.png', '141415', '0.30536277464583406'),
(134, 'PRDCT-0820-000712', '7187aefc1952294adb4ca0db71d5a7f8.png', '141415', '0.9241868780977076'),
(135, 'PRDCT-0820-000953', '5a66c0204368820d63ad11297edc5bbd.png', '120773', '0.02797642897383512'),
(136, 'PRDCT-0820-000953', '42d6172c77c7db062c7c3a6077e1a492.png', '120773', '0.5679107756431068'),
(137, 'PRDCT-0820-000953', 'c6589ac569ca610883605374a32414a7.png', '120773', '0.23924516249954975'),
(138, 'PRDCT-0820-000953', '924eaab694a95bc1f15a3e458e1d70d8.png', '120773', '0.3048311067234821'),
(139, 'PRDCT-0820-000953', '6daffce4bf36ced8450f29dd2ec6297e.png', '120773', '0.4628395398743157'),
(140, 'PRDCT-0820-001318', '4c845528053140c803c7213e683233b4.png', '181529', '0.11877056874325076'),
(141, 'PRDCT-0820-001318', '58ea8fcf4d1f6c735c7bf633be2aac95.png', '181529', '0.06264050579321356'),
(142, 'PRDCT-0820-001318', 'd060a6e2f938679b18e3879ce52ed3be.png', '181529', '0.1248929582478775'),
(143, 'PRDCT-0820-001318', 'c9a519f46b7e893fa668f53f5a2c89b2.png', '181529', '0.7933531724429421'),
(144, 'PRDCT-0820-001318', '99e7911faefe703de296091f4be0716e.png', '181529', '0.22618424008864357'),
(145, 'PRDCT-0820-001521', '138a88d30168e5693c27a7253db0fcf1.png', '317064', '0.05338569534938564'),
(146, 'PRDCT-0820-001521', '0197da34fd08f84d26f6542139a7b80f.png', '317064', '0.6455157167677974'),
(147, 'PRDCT-0820-001521', '5ea8945ad77dd4f689b656ee1dd75971.png', '317064', '0.9009315571431584'),
(148, 'PRDCT-0820-001521', '72124031d0c6f538f896dc8c8e79077b.png', '317064', '0.25301029144830434'),
(149, 'PRDCT-0820-001521', '1906feed5d5d56ab0143913316501e18.png', '317064', '0.9117412872394586'),
(150, 'PRDCT-0820-001626', 'f58f91f0ddb1f6f09511bb67a390f893.png', '112616', '0.21968565153656017'),
(151, 'PRDCT-0820-001626', 'e79c1bd1cccdddacb19541ea5af3a0e5.png', '112616', '0.23350279609531754'),
(152, 'PRDCT-0820-001626', '791f77b065410111284e18eb03a47d78.png', '112616', '0.3860099111105819'),
(153, 'PRDCT-0820-001626', '9f08ab16717cd3ba80749c4f32da87cc.png', '112616', '0.29452400636227716'),
(154, 'PRDCT-0820-001626', 'e8ae92ec01b74f0c8e22a6da169004f1.png', '112616', '0.11235907961855651'),
(155, 'PRDCT-0820-001900', 'da875bb5413f94b6b42963138635c584.jpg', '76956', '0.38968699052497047'),
(156, 'PRDCT-0820-001900', '48e400966f2403836c0ac49838d310d0.jpg', '76956', '0.6344858727353735'),
(157, 'PRDCT-0820-001900', 'd36beed7f784b3f7b195d356518c6bcf.jpg', '76956', '0.5102749691013022'),
(158, 'PRDCT-0820-001900', '730264429bb5f6be6f8240d2abc124f6.jpg', '76956', '0.6929309760442066'),
(159, 'PRDCT-0820-001900', '6feab17b8d8558f1592df2f57e8d91aa.jpg', '76956', '0.5258557378886115'),
(160, 'PRDCT-0820-002347', '73b15d00ee2bc3ae895c9eba07021c91.jpg', '62381', '0.2861652668439991'),
(161, 'PRDCT-0820-002347', '5a46068748c680495feee5661ccc58b8.jpg', '62381', '0.2147404678040441'),
(162, 'PRDCT-0820-002347', '2d38cc7f6ac4a62af376b5885c111da6.jpg', '62381', '0.8929291220042237'),
(163, 'PRDCT-0820-002347', '575144e14a1842df25377100ec17d645.jpg', '62381', '0.7340173534090355'),
(164, 'PRDCT-0820-002347', '021d38d1f0c27a1277114743ce620501.jpg', '62381', '0.8028388316355328'),
(165, 'PRDCT-0820-002517', 'd71d9106392012a78c0f52886ea4122d.jpg', '79449', '0.6308405830501556'),
(166, 'PRDCT-0820-002517', 'dccdb815661f0ea58488108e962add8e.jpg', '79449', '0.9319678115298711'),
(167, 'PRDCT-0820-002517', '78dd17a6396bfff14f2a4b3890258f44.jpg', '79449', '0.40697314206947843'),
(168, 'PRDCT-0820-002517', '64134560dbef85130c7f182d25af1d62.jpg', '79449', '0.9231351926553981'),
(170, 'PRDCT-0820-002811', '0f7f8d649d3e591fda897f9d744df9be.png', '235003', '0.20105249351219134'),
(171, 'PRDCT-0820-002811', 'f432306f14f576f8c3be10dc87581b58.png', '235003', '0.0774331774505459'),
(172, 'PRDCT-0820-002811', '89ade11a183118c60fce379f29dfad8e.png', '235003', '0.4043974299259465'),
(173, 'PRDCT-0820-002811', '7f120eab51e5781f93ad4a4c9f51cb9d.png', '235003', '0.18675106539827313'),
(174, 'PRDCT-0820-002811', 'f20e6fdb97538a8092fab460c6b2caef.png', '235003', '0.6816292641625015'),
(175, 'PRDCT-0820-003058', '1d21746a608ae478c97a890bdc65c56a.jpg', '65303', '0.618375780793363'),
(176, 'PRDCT-0820-003058', '0f0fde1f15debf8cac3100a36129854f.jpg', '65303', '0.8724070786521225'),
(177, 'PRDCT-0820-003058', 'e9341479385068cadb8127ce0805a070.jpg', '65303', '0.9754277040279051'),
(178, 'PRDCT-0820-003058', 'bc0478ec7140f5c89de503eb0b518ce8.jpg', '65303', '0.2677165728140465'),
(179, 'PRDCT-0820-003058', 'a465fc54d27ef00cbab031c53ef34654.jpg', '65303', '0.6526812900892867'),
(180, 'PRDCT-0820-003415', '94eee366e1d736d5ce193ab23da9661f.jpg', '29197', '0.9200221093481629'),
(181, 'PRDCT-0820-003415', '81ee4ac783499f39ea5e8df79d30fc04.jpg', '29197', '0.23447062605531355'),
(182, 'PRDCT-0820-003415', '8eb9f45bd06c7d43d45fda5c0b5cee6c.jpg', '29197', '0.9946518135861766'),
(183, 'PRDCT-0820-003415', '21a44de615d3341594c43b1ebaacf81b.jpg', '29197', '0.9878387640414197'),
(184, 'PRDCT-0820-003415', 'b3c7d310c4ce92181f26c5ba5d4373a3.jpg', '29197', '0.769442238593026'),
(185, 'PRDCT-0820-003451', '84e37d0da26719f4d186406afc8211d5.jpg', '21890', '0.13261491173391948'),
(186, 'PRDCT-0820-003451', '3cbf5df34a6a53eefe31af4dba02d1e6.jpg', '21890', '0.0890790120844096'),
(187, 'PRDCT-0820-003451', 'd62e810994bfcfbaf722a30fb2d45556.jpg', '21890', '0.0475353109677219'),
(188, 'PRDCT-0820-003451', 'aa27c8671db3248cf89cc0a30fc196f0.jpg', '21890', '0.22987723998047715'),
(189, 'PRDCT-0820-003451', '42c562388c96fb762c2a303e63e3f141.jpg', '21890', '0.959128113221672'),
(190, 'PRDCT-0820-003633', '61a6600ba5a8cce36b3adaca7c01de18.jpg', '37633', '0.5385900122005705'),
(191, 'PRDCT-0820-003633', '022dc38bb941a4edd5c715585d867c50.jpg', '37633', '0.6821624235706443'),
(192, 'PRDCT-0820-003633', '66b75cff57ae74ab9220e4556ffeabcd.jpg', '37633', '0.7918713981371266'),
(193, 'PRDCT-0820-003633', 'e153b443ed9da84797f85fe2f7f55a58.jpg', '37633', '0.36541832853217215'),
(208, 'PRDCT-0820-003722', '2fb77a9e65eb92be841cd1a16eb0273a.jpg', '29197', '0.2930326030202284'),
(207, 'PRDCT-0820-003722', '87d13c0572351b963596fe87ce14d1c1.jpg', '24454', '0.05657575376712387'),
(206, 'PRDCT-0820-003722', '0248e103e64e48d4a3d11168b3ce1471.jpg', '46499', '0.48321175794911264'),
(205, 'PRDCT-0820-003722', '11bd2e1a2a2b2a84721f704bfae216ed.jpg', '21890', '0.718206870454813'),
(200, 'PRDCT-0820-003802', 'fec9f4690e84ea7cf3421066032fbcf2.jpg', '46499', '0.6536563990637665'),
(201, 'PRDCT-0820-003802', '87c0f7223babcc589026850a8348b46d.jpg', '46499', '0.8652911157292242'),
(202, 'PRDCT-0820-003802', '0d9c8d2ba3075645dc941872b1a2f7e9.jpg', '46499', '0.48340566171558663'),
(203, 'PRDCT-0820-003802', 'd1fd744d5300bce62e813059a4205b2b.jpg', '46499', '0.21367852368381102'),
(204, 'PRDCT-0820-003802', 'df966456ebabc4b16192261d27f2352d.jpg', '46499', '0.07412344871362642'),
(209, 'PRDCT-0820-003722', '2291317b40755f3b8dde75bfcdd3cc8f.jpg', '37633', '0.37318648875480487'),
(210, 'PRDCT-0920-122722', '73aad873b9077fb260f165fbc274c976.png', '181529', '0.3144397809967012'),
(211, 'PRDCT-0920-122722', 'aa11067b17ef6f87b1127db1acde6d15.png', '317064', '0.25778752635216273'),
(212, 'PRDCT-0920-122722', '0a45ca3226cf95705c35d9576f03087c.png', '141415', '0.09196355847649618'),
(213, 'PRDCT-0920-122722', '4d17928d22b7b0500be514b607d78ebf.png', '120773', '0.4765558729393795'),
(214, 'PRDCT-0920-123202', '5a1ffc9fd2df19335bbdc638c5af3f2f.png', '120773', '0.8410674349856608'),
(215, 'PRDCT-0920-123202', '51a59c4c212033eeeb5f56c73e65caaa.png', '317064', '0.2292984601133723'),
(216, 'PRDCT-0920-123202', '7ccaa8f617b3e107c969282924f1b5f5.png', '181529', '0.932070369211706'),
(217, 'PRDCT-0920-123202', '981a4f00c0cdf6718230b9eedb8706d5.png', '141415', '0.43723181920799137'),
(218, 'PRDCT-0920-123541', 'a7993fb805a11caf260edda14adb0c99.png', '317064', '0.730547246435387'),
(219, 'PRDCT-0920-123541', 'b9d37cceeea298887d7d647818f31cb4.png', '141415', '0.6608023075469214'),
(220, 'PRDCT-0920-123541', '87ebae9245c8256946858896bbf0ff21.png', '120773', '0.3500881885038609'),
(221, 'PRDCT-0920-123541', '2f11801df1a8792c7b4d3321eff932e1.png', '181529', '0.46364826539640713'),
(229, 'PRDCT-0920-124754', '090525eb9cd91eb24df51120344d6470.jpg', '62381', '0.5411237365486037'),
(228, 'PRDCT-0920-124754', '2632056c454ba222e9f755095d3347c9.jpg', '76956', '0.8111248112766807'),
(227, 'PRDCT-0920-124754', '1b723460bde6275da3ae6bc14d81a887.jpg', '29197', '0.6363930567575766'),
(226, 'PRDCT-0920-124754', '260c2e9feeb8ffcdae9a6c37f3f51a44.jpg', '21890', '0.4764863975597584'),
(274, 'PRDCT-0420-085449', '61073c6b2479669c5af5d666b9b6b4e6.png', '185477', '0.9776588733068159'),
(268, 'PRDCT-0320-164257', '77ffda687ae721fee167c383b11c1e49.jpg', '1768101', '0.9335390091655691'),
(273, 'PRDCT-0420-085449', 'b544d4d0f0d15bfdab9d1e826572b726.png', '209715', '0.45491042291626127'),
(272, 'PRDCT-0420-085449', '288496bfd5ca7b1aaf2e9a1ee48092c9.jpg', '65303', '0.7215356543166229'),
(243, 'PRDCT-0920-221144', 'f0e1d14ef7ab7100397af70d15e1aa26.png', '317064', '0.4169321960371217'),
(244, 'PRDCT-0920-221144', 'db1532ee56186f475978cb8013475e17.png', '112616', '0.486192018201524'),
(245, 'PRDCT-0920-221754', '38bd3dc4c3fd85e0dc4c36e6b7ee5594.png', '112616', '0.7972614118038479'),
(246, 'PRDCT-0920-221754', '99b0a6dea2e5e18c54ae4a0cef908b1e.png', '317064', '0.1339124053207803'),
(277, 'PRDCT-1020-213806', '18111f8c9fbb3385df0c9b375807856e.jpg', '70418', '0.38500220973219035'),
(278, 'PRDCT-1020-213806', '8cfe3cc14802bbd3cdc7b6cbcc7064e8.jpg', '70418', '0.8572029638730367'),
(279, 'PRDCT-1020-213806', 'e55782533c56c090556f79f88a17fc1f.jpg', '70418', '0.3401743094069847'),
(280, 'PRDCT-1020-213806', 'a56ea6761f9c09100f794ffbaf917f00.jpg', '70418', '0.09890963732339042');

-- --------------------------------------------------------

--
-- Table structure for table `product_discounts`
--

CREATE TABLE `product_discounts` (
  `id` int(11) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `before_discount` int(11) NOT NULL,
  `discount_charge_rate` int(11) NOT NULL,
  `discount_charge` int(11) NOT NULL,
  `after_discount` int(11) NOT NULL,
  `start_time_discount` date NOT NULL,
  `end_time_discount` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_discounts`
--

INSERT INTO `product_discounts` (`id`, `product_id`, `before_discount`, `discount_charge_rate`, `discount_charge`, `after_discount`, `start_time_discount`, `end_time_discount`) VALUES
(26, 'PRDCT-0320-153504', 279000, 10, 27900, 251100, '2020-07-16', '2020-07-17'),
(27, 'PRDCT-0320-164257', 70000, 5, 3500, 66500, '2020-07-16', '2020-07-23'),
(28, 'PRDCT-0420-084902', 11800, 5, 590, 11210, '2020-07-16', '2020-07-17'),
(29, 'PRDCT-0420-085449', 7500, 5, 375, 7125, '2020-07-18', '2020-07-19'),
(30, 'PRDCT-0820-003722', 445000, 20, 89000, 356000, '2020-10-12', '2020-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `gallery_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `gallery_id`) VALUES
(67, 'PRDCT-0320-164257', 34),
(66, 'PRDCT-0320-164257', 35),
(65, 'PRDCT-0320-164257', 36),
(64, 'PRDCT-0320-164257', 37);

-- --------------------------------------------------------

--
-- Table structure for table `product_slugs`
--

CREATE TABLE `product_slugs` (
  `id` int(11) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `slug` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_slugs`
--

INSERT INTO `product_slugs` (`id`, `product_id`, `slug`) VALUES
(5, 'PRDCT-0720-135500', 'cleone-baju-atasan-wanita-blus-casual-tangan-balon');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` varchar(32) NOT NULL,
  `supplier_id` varchar(32) NOT NULL,
  `purchase_date` date NOT NULL,
  `no_ref` varchar(64) DEFAULT NULL,
  `gross_amount` int(11) NOT NULL,
  `ship_amount` int(11) NOT NULL,
  `tax_amount` int(11) NOT NULL,
  `tax_amount_charge` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `after_discount` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `paid_status` varchar(16) NOT NULL,
  `user_create` varchar(32) NOT NULL,
  `user_update` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `supplier_id`, `purchase_date`, `no_ref`, `gross_amount`, `ship_amount`, `tax_amount`, `tax_amount_charge`, `discount`, `after_discount`, `net_amount`, `paid_status`, `user_create`, `user_update`, `created_at`) VALUES
('PO070420-0002', 'SPL0005', '2020-04-07', '', 256000, 18000, 10, 0, 0, 0, 301400, 'Lunas', 'admin@adminprinting.com', '', '2020-04-07 21:18:30'),
('PO070420-0001', 'SPL0003', '2020-04-07', '', 429000, 36000, 10, 0, 5, 0, 460925, 'Lunas', 'admin@adminprinting.com', '', '2020-04-07 21:17:03'),
('PO070420-0003', 'SPL0005', '2020-04-07', '', 909000, 36000, 10, 0, 0, 0, 1039500, 'Lunas', 'admin@adminprinting.com', '', '2020-04-07 21:19:14'),
('PO070420-0004', 'SPL0004', '2020-04-07', '', 3200000, 36000, 0, 0, 0, 0, 3236000, 'Belum Lunas', 'admin@adminprinting.com', '', '2020-04-07 21:20:25'),
('PO070420-0005', 'SPL0003', '2020-04-07', '', 76000, 0, 0, 0, 0, 0, 76000, 'Lunas', 'admin@adminprinting.com', '', '2020-04-07 21:21:07'),
('PO070420-0006', 'SPL0002', '2020-04-07', '', 750000, 36000, 10, 0, 0, 0, 864600, 'Belum Lunas', 'admin@adminprinting.com', '', '2020-04-07 21:21:37'),
('PO030620-0009', 'SPL0004', '2020-06-03', '', 140000, 18000, 10, 15800, 5, 7900, 165110, 'Lunas', 'admin@adminprinting.com', '', '2020-06-03 23:22:34'),
('PO310520-0008', 'SPL0005', '2020-05-31', '', 128000, 15000, 5, 0, 0, 0, 150150, 'Belum Lunas', 'admin@adminprinting.com', '', '2020-05-31 14:46:23');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `purchase_id` varchar(32) NOT NULL,
  `product_id` varchar(64) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`purchase_id`, `product_id`, `unit_price`, `qty`, `amount`) VALUES
('PO070420-0001', 'PRDCT-0420-084545', 2500, 20, 50000),
('PO070420-0001', 'PRDCT-0420-084902', 11800, 30, 354000),
('PO070420-0002', 'PRDCT-0420-085050', 12800, 20, 256000),
('PO070420-0003', 'PRDCT-0420-085050', 12800, 30, 384000),
('PO070420-0003', 'PRDCT-0420-085344', 10500, 50, 525000),
('PO070420-0004', 'PRDCT-0320-164257', 60000, 30, 1800000),
('PO070420-0004', 'PRDCT-0320-153504', 70000, 20, 1400000),
('PO070420-0005', 'PRDCT-0420-085606', 3800, 20, 76000),
('PO070420-0006', 'PRDCT-0420-085449', 7500, 100, 750000),
('PO030620-0009', 'PRDCT-0320-153504', 70000, 2, 140000),
('PO310520-0008', 'PRDCT-0420-085050', 12800, 10, 128000);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_hutang`
--

CREATE TABLE `purchase_hutang` (
  `id` int(11) NOT NULL,
  `hutang_id` varchar(32) NOT NULL,
  `purchase_id` varchar(32) NOT NULL,
  `hutang_paid_history` date NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `remaining_paid` int(11) NOT NULL,
  `user_create` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_hutang`
--

INSERT INTO `purchase_hutang` (`id`, `hutang_id`, `purchase_id`, `hutang_paid_history`, `amount_paid`, `remaining_paid`, `user_create`) VALUES
(11, 'DEBT310520-0003', 'PO310520-0008', '2020-05-31', 150000, 150, 'admin@adminprinting.com'),
(10, 'DEBT070420-0002', 'PO070420-0006', '2020-04-07', 800000, 64600, 'admin@adminprinting.com'),
(9, 'DEBT070420-0001', 'PO070420-0004', '2020-04-07', 2000000, 1236000, 'admin@adminprinting.com');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` varchar(32) NOT NULL,
  `retur_date` date NOT NULL,
  `purchase_id` varchar(32) NOT NULL,
  `gross_amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `net_amount` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `status` varchar(64) DEFAULT NULL,
  `user_create` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `retur_date`, `purchase_id`, `gross_amount`, `discount`, `net_amount`, `keterangan`, `status`, `user_create`) VALUES
('RP070420-0001', '2020-04-07', 'PO070420-0001', 12500, 0, 12500, '', NULL, 'admin@adminprinting.com'),
('RP070420-0002', '2020-04-07', 'PO070420-0001', 12500, 0, 12500, '', NULL, 'admin@adminprinting.com');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `retur_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`retur_id`, `product_id`, `description`, `qty`, `unit_price`, `amount`) VALUES
('RP070420-0001', 'PRDCT-0420-084545', 'Sobek / berlubang', 5, 2500, 12500),
('RP070420-0002', 'PRDCT-0420-084545', 'Salah font pada product', 5, 2500, 12500);

-- --------------------------------------------------------

--
-- Table structure for table `status_orders`
--

CREATE TABLE `status_orders` (
  `id` int(11) NOT NULL,
  `status_name` varchar(32) NOT NULL,
  `status_color` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_orders`
--

INSERT INTO `status_orders` (`id`, `status_name`, `status_color`) VALUES
(1, 'Cancel', 'danger'),
(2, 'Pending', 'info'),
(3, 'On Process', 'warning'),
(4, 'Success', 'success'),
(5, 'Pending Return', 'info'),
(6, 'Return On Process', 'warning'),
(7, 'Return Success', 'success'),
(8, 'Paid', 'success'),
(9, 'Unpaid', 'danger'),
(10, 'Refund', 'primary');

-- --------------------------------------------------------

--
-- Table structure for table `store_banner`
--

CREATE TABLE `store_banner` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `button_link_title` varchar(32) DEFAULT NULL,
  `button_link_url` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store_banner`
--

INSERT INTO `store_banner` (`id`, `title`, `sub_title`, `image`, `button_link_title`, `button_link_url`) VALUES
(16, 'Women Collections', '', '5b75ee62eb741463a64dbc8414b24795.jpg', 'Facebook', 'https://www.facebook.com/rizky.rahmadianto/'),
(15, 'August Collections', 'SPECIAL COVID 19% OFF', 'b02d7ed5ae607cc2b9bf2f124da871b9.jpg', 'Twitter', 'https://twitter.com/RR_Rizky');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` varchar(32) NOT NULL,
  `supplier_name` varchar(128) NOT NULL,
  `supplier_phone` varchar(16) NOT NULL,
  `supplier_address` text NOT NULL,
  `credit_card_type` varchar(32) NOT NULL,
  `credit_card_number` int(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_phone`, `supplier_address`, `credit_card_type`, `credit_card_number`, `created_at`, `updated_at`) VALUES
('SPL0003', 'PT. Indofood', '081234567890', 'Jalan  qwe qw eqw e a sd asd', 'BCA', 441286222, '2020-02-07 10:58:21', '2020-04-07 13:53:26'),
('SPL0002', 'PT Wingsfood', '082123345567', '123123 ad sd', 'asdasd', 123123123, '2020-02-07 10:56:13', '2020-04-07 13:53:33'),
('SPL0004', 'PT. Garment', '089113322876', 'Jalan Perintis Kemerdekaan 12a', 'Mandiri', 2147483647, '2020-03-12 21:10:40', '0000-00-00 00:00:00'),
('SPL0005', 'PT. Mayora', '0247626804', 'Ngaliyan, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50181', 'BCA', 1122334455, '2020-04-07 13:08:36', '0000-00-00 00:00:00'),
('SPL0006', 'Crooz Shop House', '085693212345', 'asdasdasda', 'asd', 123123123, '2020-08-06 23:54:31', '0000-00-00 00:00:00'),
('SPL0007', 'Converse Grand Indonesia', '02123581176', 'Grand Indonesia Shopping Town West Mall 3rd Floor SB2-11&11A, Jl. M.H. Thamrin No.1, RT.1/RW.5, Kebon Melati, Tanahabang, Central Jakarta City, Jakarta 10310', 'asd', 123123123, '2020-08-06 23:55:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` int(11) NOT NULL,
  `online` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `created_at`, `online`) VALUES
(4, 'Admin Store', 'admin@adminstore.com', 'eae6c88740a17833e7234b692b1a27e3.png', '$2y$10$ojVg/Mvr9wpLnHNd.9AxXOlpSEWuivT9dQDbnoZx5Hw9MLaCFjmWK', 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 1, 20190323, 1),
(5, 'Member Store', 'member@memberstore.com', 'eaccc525f943d900dd94e4362d65f9ca.png', '$2y$10$kYvHiIKzCULCqUOVQgcz8.QowPLxheDav5B2VLYc.CPYkFYsqoi.m', 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 1, 20190323, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` varchar(128) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 1),
(2, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 2),
(3, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 3),
(4, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 4),
(5, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 5),
(6, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 2),
(7, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 3),
(8, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 4),
(9, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 5),
(10, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 6),
(11, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 1),
(12, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 7),
(13, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 8),
(14, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 7),
(15, 'PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 8),
(16, 'tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(32) NOT NULL,
  `icon` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `icon`) VALUES
(1, 'Admin', 'fa fa-tachometer'),
(2, 'Master', 'fa fa-plus'),
(3, 'Report', 'fa fa-print'),
(4, 'Purchase', 'fa fa-shopping-basket'),
(5, 'Order', 'fa fa-usd'),
(6, 'Control Access', 'fa fa-user-secret'),
(8, 'Messages', 'fa fa-envelope-o'),
(10, 'Store Settings', 'fa fa-cogs');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` varchar(128) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
('tOBawuCPBAhAZzmyT10F1UbCIc7I42OwLBRmnRhS8e8=', 'Admin'),
('PvWl8PYIxPqycZOszmC3c6HgqS1u6xQKbzwHZXAehrU=', 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `level` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `is_active`, `level`) VALUES
(1, 1, 'Dashboard', 'admin', 1, 'admin'),
(2, 6, 'Role', 'role', 1, 'role'),
(3, 6, 'User Control', 'usercontrol', 1, 'usercontrol'),
(4, 6, 'Manage Company', 'company', 1, 'company'),
(5, 2, 'Supplier', 'supplier', 1, 'supplier'),
(6, 2, 'Category', 'category', 1, 'category'),
(7, 2, 'Product', 'product', 1, 'product'),
(8, 5, 'Order In', 'order', 1, 'order'),
(9, 5, 'Piutang', 'piutang', 1, 'piutang'),
(10, 4, 'Purchase', 'purchase', 1, 'purchase'),
(11, 4, 'Hutang', 'hutang', 1, 'hutang'),
(12, 5, 'Retur Order', 'order_retur', 1, 'order_retur'),
(13, 4, 'Retur Purchase', 'purchase_retur', 1, 'purchase_retur'),
(14, 2, 'Gallery', 'gallery', 0, 'gallery'),
(15, 3, 'Report Hutang', 'report_hutang', 1, 'report_hutang'),
(16, 3, 'Report Purchase', 'report_purchase', 1, 'report_purchase'),
(17, 3, 'Report Retur Purchase', 'report_retur_purchase', 1, 'report_retur_purchase'),
(18, 3, 'Report Order', 'report_order', 1, 'report_order'),
(19, 3, 'Report Piutang', 'report_piutang', 1, 'report_piutang'),
(20, 3, 'Report Retur Order', 'report_retur_order', 1, 'report_retur_order'),
(25, 8, 'Comment', 'comment', 1, 'comment'),
(23, 8, 'Chat', 'chat', 1, 'chat'),
(27, 10, 'Store Banner', 'store_banner', 1, 'store_banner');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile_address`
--
ALTER TABLE `company_profile_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_profile_id` (`company_profile_id`,`province_id`,`city_id`);

--
-- Indexes for table `company_profile_banks`
--
ALTER TABLE `company_profile_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile_charge_value`
--
ALTER TABLE `company_profile_charge_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_profile_detail`
--
ALTER TABLE `company_profile_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_profile_id` (`company_profile_id`);

--
-- Indexes for table `company_profile_email`
--
ALTER TABLE `company_profile_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customer`),
  ADD KEY `name` (`customer_name`),
  ADD KEY `email` (`customer_email`),
  ADD KEY `password` (`customer_password`(250)),
  ADD KEY `phone` (`customer_phone`),
  ADD KEY `image` (`customer_image`(250)),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provinsi_id` (`province_id`),
  ADD KEY `kabupaten_id` (`city_id`);

--
-- Indexes for table `customer_carts`
--
ALTER TABLE `customer_carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `customer_comments`
--
ALTER TABLE `customer_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `customer_comment_details`
--
ALTER TABLE `customer_comment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `customer_purchase_orders`
--
ALTER TABLE `customer_purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_email` (`customer_email`,`status_order_id`);

--
-- Indexes for table `customer_purchase_order_approves`
--
ALTER TABLE `customer_purchase_order_approves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_purchase_order_details`
--
ALTER TABLE `customer_purchase_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`,`product_id`,`status_order_id`);

--
-- Indexes for table `customer_purchase_order_shipping`
--
ALTER TABLE `customer_purchase_order_shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_purchase_returns`
--
ALTER TABLE `customer_purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`,`customer_email`,`status_order_id`);

--
-- Indexes for table `customer_purchase_return_details`
--
ALTER TABLE `customer_purchase_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_id` (`purchase_return_id`,`product_id`,`status_order_id`);

--
-- Indexes for table `customer_purchase_return_shipping`
--
ALTER TABLE `customer_purchase_return_shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_token`
--
ALTER TABLE `customer_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_wishlists`
--
ALTER TABLE `customer_wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dashboard_details`
--
ALTER TABLE `dashboard_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fontawesomes`
--
ALTER TABLE `fontawesomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`customer_name`,`customer_phone`,`order_date`,`net_amount`,`paid_status`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`,`product_id`,`amount`);

--
-- Indexes for table `order_piutang`
--
ALTER TABLE `order_piutang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`piutang_id`,`order_id`,`piutang_paid_history`,`amount_paid`,`remaining_paid`);

--
-- Indexes for table `order_returns`
--
ALTER TABLE `order_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `status` (`status`),
  ADD KEY `retur_id` (`id`);

--
-- Indexes for table `order_return_details`
--
ALTER TABLE `order_return_details`
  ADD KEY `retur_id` (`retur_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`id`),
  ADD KEY `product_name` (`product_name`),
  ADD KEY `price` (`price`),
  ADD KEY `qty` (`qty`),
  ADD KEY `availability` (`availability`);

--
-- Indexes for table `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_name` (`brand_name`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_name` (`category_name`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_discounts`
--
ALTER TABLE `product_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `after_discount` (`after_discount`),
  ADD KEY `discount_charge_rate` (`discount_charge_rate`),
  ADD KEY `start_time_discount` (`start_time_discount`),
  ADD KEY `end_time_discount` (`end_time_discount`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image` (`gallery_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_slugs`
--
ALTER TABLE `product_slugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`supplier_id`,`purchase_date`,`net_amount`,`paid_status`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD KEY `pengeluaran_detail_id` (`purchase_id`,`product_id`);

--
-- Indexes for table `purchase_hutang`
--
ALTER TABLE `purchase_hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_orders`
--
ALTER TABLE `status_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_banner`
--
ALTER TABLE `store_banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_name` (`supplier_name`),
  ADD KEY `supplier_phone` (`supplier_phone`),
  ADD KEY `supplier_address` (`supplier_address`(250));

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_profile_address`
--
ALTER TABLE `company_profile_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company_profile_banks`
--
ALTER TABLE `company_profile_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `company_profile_charge_value`
--
ALTER TABLE `company_profile_charge_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_profile_detail`
--
ALTER TABLE `company_profile_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `company_profile_email`
--
ALTER TABLE `company_profile_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_comment_details`
--
ALTER TABLE `customer_comment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `customer_purchase_order_approves`
--
ALTER TABLE `customer_purchase_order_approves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer_purchase_order_details`
--
ALTER TABLE `customer_purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `customer_purchase_order_shipping`
--
ALTER TABLE `customer_purchase_order_shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer_purchase_return_details`
--
ALTER TABLE `customer_purchase_return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_purchase_return_shipping`
--
ALTER TABLE `customer_purchase_return_shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_token`
--
ALTER TABLE `customer_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_wishlists`
--
ALTER TABLE `customer_wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `dashboards`
--
ALTER TABLE `dashboards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dashboard_details`
--
ALTER TABLE `dashboard_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `fontawesomes`
--
ALTER TABLE `fontawesomes`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=787;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_piutang`
--
ALTER TABLE `order_piutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=325;

--
-- AUTO_INCREMENT for table `product_discounts`
--
ALTER TABLE `product_discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `product_slugs`
--
ALTER TABLE `product_slugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_hutang`
--
ALTER TABLE `purchase_hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `status_orders`
--
ALTER TABLE `status_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `store_banner`
--
ALTER TABLE `store_banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
