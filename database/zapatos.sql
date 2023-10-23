-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 06:05 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zapatos`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role_id` varchar(200) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_verified` tinyint(4) NOT NULL DEFAULT 0,
  `date_joined` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_id`, `fullname`, `username`, `email`, `password`, `role_id`, `is_active`, `is_verified`, `date_joined`) VALUES
(1, '1cdae304-6674-11ee-ae30-3a685d99e8bf', 'Zapatos', 'ZapatosAdmin', 'zapatos@rrdev.online', '$2y$10$.iUK6yHzxJelntYzUaDwcejiLK7TCCwhTOiLCBXqvvxbESNYtRmx6', '23799f1d-6198-11ee-adae-a6ab66fec5e3', 1, 1, '2023-10-09 09:17:49'),
(2, '48e33b25-809c-4d34-aa27-dba2fff85293', 'Raymond Reblando', 'Raymond', 'reblandoraymond6@gmail.com', '', '2379acad-6198-11ee-adae-a6ab66fec5e3', 1, 1, '2023-10-10 14:32:36'),
(4, '8efe58b0-1514-40b6-a183-ddeb16163c53', 'Tom Holland', '', 'raymondreblando1219@gmail.com', '$2y$10$PWc7ZxzzykIopxRL43np4uwnqiUIaIyeEM8YuC34hENcQS4XpMGmC', '2379acad-6198-11ee-adae-a6ab66fec5e3', 1, 1, '2023-10-11 13:28:08'),
(5, 'ad0c5424-ea93-44f6-a50d-62f4251b3d4f', 'Sarah Wagner', '', 'polagreen.polangui@gmail.com', '$2y$10$91UiIDhKTRVU0.wfaedsfeHD.KwnMFsElECG7UUB.2Z3O6E20BUPm', '2379acad-6198-11ee-adae-a6ab66fec5e3', 1, 0, '2023-10-23 11:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_id` varchar(200) NOT NULL,
  `brand_name` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_id`, `brand_name`, `date_created`) VALUES
(2, '2df613d0-1b83-47c0-b69e-3e620e127e98', 'Nike', '2023-09-23 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cart_id` varchar(200) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `color_id` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_id` varchar(200) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_id`, `category_name`, `date_created`) VALUES
(1, '1cc5d44c-2df2-4992-be7d-e54a1a766934', 'Lifestyle', '2023-09-23 14:30:00'),
(2, 'bbb26ef5-90f0-4d8c-adb5-36cd22a1a5ea', 'Basketball', '2023-09-23 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `color_id` varchar(200) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `color_hex` varchar(20) NOT NULL,
  `color_status` varchar(20) NOT NULL DEFAULT 'Available',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `color_id`, `shoe_id`, `color_hex`, `color_status`, `date_created`) VALUES
(1, '8e03a63a-d085-48fb-a2d6-9e057ad65a21', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '#d4cac0', 'Available', '2023-09-23 14:30:00'),
(2, 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '673ded53-c97e-4102-9ade-7fac90070b08', '#4bd947', 'Available', '2023-09-23 14:30:00'),
(3, '0b6dba2c-1a3b-43a3-a277-0d365e835992', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '#dadad8', 'Available', '2023-09-23 14:30:00'),
(4, '7b0c4610-0255-48e3-9a0a-d42308589660', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '#f92d3e', 'Available', '2023-09-23 14:30:00'),
(5, 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '#004297', 'Available', '2023-09-23 14:30:00'),
(6, 'e9e86611-225a-4794-96f6-82b26d0b5b80', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '#cfe202', 'Available', '2023-09-23 14:30:00'),
(7, '6b03778f-9968-4f1d-838b-5b6fa129db38', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '#121212', 'Available', '2023-09-23 14:30:00'),
(8, '5db5e818-0e12-4cc0-922c-0140720d4a34', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '#808d88', 'Available', '2023-09-23 14:30:00'),
(15, 'cf5265dc-893a-46e0-941b-6fb060907850', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '#fc903a', 'Available', '2023-09-23 14:30:00'),
(16, '2a6800db-2ef3-493b-a0be-53322387a05f', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '#0097c0', 'Available', '2023-09-23 14:30:00'),
(17, '53749807-e3c3-4738-922c-7473dc048e0f', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '#0a1114', 'Available', '2023-09-23 14:30:00'),
(18, '238e4529-cbaf-44d8-834d-1f56c3994688', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '#a91213', 'Available', '2023-09-23 14:30:00'),
(19, '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '#e2928e', 'Available', '2023-09-23 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `email_verify`
--

CREATE TABLE `email_verify` (
  `id` int(11) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verify`
--

INSERT INTO `email_verify` (`id`, `account_id`, `token`, `timestamp`, `date_created`) VALUES
(2, '8efe58b0-1514-40b6-a183-ddeb16163c53', '75965b6440a1f89aa674ec56c19396e2e562ba26e6a9fc5e6c2fc2c2de48f213', 1697002088, '2023-10-11 13:28:08'),
(3, 'ad0c5424-ea93-44f6-a50d-62f4251b3d4f', '309aaa7cf500b54a1f3527ce28478a597d72fcda837e5434a2cad50b9c2844cb', 1698030028, '2023-10-23 11:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification_id` varchar(200) NOT NULL,
  `reference_id` varchar(200) NOT NULL,
  `notification_type` varchar(50) NOT NULL,
  `notification_status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification_id`, `reference_id`, `notification_type`, `notification_status`, `date_created`) VALUES
(1, '46a8785f-cce0-4af0-afe8-45cc522d674c', 'cae60db5-6efd-439b-bd4b-403dd68b54b0', 'Order', 1, '2023-10-18 12:12:34'),
(2, '4e530394-3d7c-4c07-b8f9-7e40173f5187', '7e3208b3-c336-4385-a7b7-fe53a6bea974', 'Order', 0, '2023-10-21 10:42:23'),
(3, '45cb3cb2-7b81-4d52-a6b9-28ffacfbc596', '315342a4-ad7a-41ff-ae03-b469d4f56c45', 'Order', 0, '2023-10-23 11:02:36'),
(4, '88c03c73-b96a-4e56-9387-45dcffc5b770', '5f762190-2735-4728-b288-6dcca081fb20', 'Order', 0, '2023-10-23 11:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `orderred_items`
--

CREATE TABLE `orderred_items` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `color_id` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderred_items`
--

INSERT INTO `orderred_items` (`id`, `order_id`, `shoe_id`, `size_id`, `color_id`, `quantity`, `date_added`) VALUES
(3, 'cae60db5-6efd-439b-bd4b-403dd68b54b0', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', 'a19eecbb-6008-49e6-8314-5987dce8d2d1', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', 1, '2023-10-18 12:12:34'),
(4, 'cae60db5-6efd-439b-bd4b-403dd68b54b0', '53091e99-f5f8-4ff4-a83a-27223ef39d50', 'ca67b265-8c2c-493a-a688-28360b2b43c9', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', 1, '2023-10-18 12:12:34'),
(5, 'cae60db5-6efd-439b-bd4b-403dd68b54b0', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '478a2842-a0c2-405d-8849-dcee0623de8e', '53749807-e3c3-4738-922c-7473dc048e0f', 1, '2023-10-18 12:12:34'),
(6, '7e3208b3-c336-4385-a7b7-fe53a6bea974', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '478a2842-a0c2-405d-8849-dcee0623de8e', '53749807-e3c3-4738-922c-7473dc048e0f', 1, '2023-10-21 10:42:23'),
(7, '315342a4-ad7a-41ff-ae03-b469d4f56c45', '53091e99-f5f8-4ff4-a83a-27223ef39d50', 'ca67b265-8c2c-493a-a688-28360b2b43c9', '0b6dba2c-1a3b-43a3-a277-0d365e835992', 1, '2023-10-23 11:02:36'),
(8, '5f762190-2735-4728-b288-6dcca081fb20', '673ded53-c97e-4102-9ade-7fac90070b08', '2a2db259-3edd-45b7-8edb-364386f319f0', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', 1, '2023-10-23 11:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `order_no` varchar(50) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `order_amount` decimal(10,2) NOT NULL,
  `order_mop` varchar(30) NOT NULL,
  `order_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `order_no`, `account_id`, `order_amount`, `order_mop`, `order_status`, `date_added`) VALUES
(2, 'cae60db5-6efd-439b-bd4b-403dd68b54b0', 'Z1593422892', '8efe58b0-1514-40b6-a183-ddeb16163c53', '18385.00', 'COD', 'Delivered', '2023-10-18 12:12:34'),
(3, '7e3208b3-c336-4385-a7b7-fe53a6bea974', 'Z1674227762', '48e33b25-809c-4d34-aa27-dba2fff85293', '3845.00', 'COD', 'Delivered', '2023-10-21 10:42:23'),
(4, '315342a4-ad7a-41ff-ae03-b469d4f56c45', 'Z1292529154', 'ad0c5424-ea93-44f6-a50d-62f4251b3d4f', '6895.00', 'COD', 'Delivered', '2023-10-23 11:02:36'),
(5, '5f762190-2735-4728-b288-6dcca081fb20', 'Z1136942332', '8efe58b0-1514-40b6-a183-ddeb16163c53', '6895.00', 'COD', 'Delivered', '2023-10-23 11:08:36');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `report_id` varchar(200) NOT NULL,
  `report_type` varchar(50) NOT NULL,
  `report_start_date` date NOT NULL,
  `report_end_date` date NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_id`, `report_type`, `report_start_date`, `report_end_date`, `date_created`) VALUES
(1, '13801dfd-1693-4b25-b814-d236ea0a71ce', 'Sales', '2023-10-01', '2023-10-31', '2023-10-18 17:53:11'),
(2, 'b84a9ee2-a4b7-4f0d-bd30-69f24c78bc30', 'Inventory', '2023-10-01', '2023-10-31', '2023-10-19 10:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `review_id` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `rating` int(11) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review_id`, `account_id`, `order_id`, `shoe_id`, `rating`, `content`, `date_created`) VALUES
(2, '89ae67ef-6258-4736-b7a1-b19430e5f7fc', '8efe58b0-1514-40b6-a183-ddeb16163c53', 'cae60db5-6efd-439b-bd4b-403dd68b54b0', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', 5, 'I couldn\'t be happier with my recent purchase from Zapatos. The shoes arrived faster than I expected, and they were exactly as pictured on the website. The whole shopping experience was smooth, and I appreciate the attention to detail in the packaging. I\'ll definitely shop here again!', '2023-10-21 11:16:16'),
(3, '1cb3d25b-d944-45e9-89e8-0601177c126b', '48e33b25-809c-4d34-aa27-dba2fff85293', '7e3208b3-c336-4385-a7b7-fe53a6bea974', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', 5, 'I\'m a shoe enthusiast, and I\'ve shopped from countless online stores, but Zapatos is a cut above the rest! The quality of the shoes I received exceeded my expectations, and the fit was perfect. The customer service team was incredibly helpful, too. I\'m a loyal customer now!', '2023-10-23 10:56:50'),
(4, '796804c5-23d6-4e44-a001-d090846e71ca', 'ad0c5424-ea93-44f6-a50d-62f4251b3d4f', '315342a4-ad7a-41ff-ae03-b469d4f56c45', '53091e99-f5f8-4ff4-a83a-27223ef39d50', 5, 'I recently bought a pair of boots from Zapatos, and I\'m in love with them! The quality is outstanding, and they are so comfortable. What truly impressed me was the easy return process. I had to exchange for a different size, and it was hassle-free. Thank you for such a pleasant shopping experience!', '2023-10-23 11:03:16'),
(5, 'd0135743-dc72-425d-b502-6c8fbfeeedad', '8efe58b0-1514-40b6-a183-ddeb16163c53', '5f762190-2735-4728-b288-6dcca081fb20', '673ded53-c97e-4102-9ade-7fac90070b08', 5, 'I recently ordered a pair of heels from Zapatos, and I couldn\'t be happier. The attention to detail in the design and the comfort level exceeded my expectations. When I decided to return and get a different style, the process was straightforward. Thanks for the great shopping experience!', '2023-10-23 11:09:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_id` varchar(200) NOT NULL,
  `role_name` varchar(30) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_id`, `role_name`, `date_created`) VALUES
(1, '23799f1d-6198-11ee-adae-a6ab66fec5e3', 'Admin', '2023-10-03 04:53:52'),
(2, '2379acad-6198-11ee-adae-a6ab66fec5e3', 'Customer', '2023-10-03 04:53:52');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `facebook` varchar(500) NOT NULL,
  `instagram` varchar(500) NOT NULL,
  `whatsapp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `address`, `email`, `contact_number`, `facebook`, `instagram`, `whatsapp`) VALUES
(1, 'Mabayawas, Zone 4, Camagong, Oas, Albay', 'zapatos@zapatos.online', '09322550100', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `contact_number` varchar(11) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `zone` varchar(30) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `zip_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `account_id`, `contact_number`, `email_address`, `street`, `zone`, `barangay`, `municipality`, `province`, `zip_code`) VALUES
(2, '48e33b25-809c-4d34-aa27-dba2fff85293', '09322550100', 'reblandoraymond6@gmail.com', 'Mabayawas', 'Zone 4', 'Camagong', 'Oas', 'Albay', '4505'),
(3, '8efe58b0-1514-40b6-a183-ddeb16163c53', '09322550100', 'raymondreblando6@gmail.com', 'Mabayawas', 'Zone 4', 'Camagong', 'Oas', 'Albay', '4505'),
(4, 'ad0c5424-ea93-44f6-a50d-62f4251b3d4f', '09652615261', 'polagreen.polangui@gmail.com', 'Realista', 'Zone 5', 'Obaliw', 'Oas', 'Albay', '4505');

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(11) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `shoe_name` varchar(200) NOT NULL,
  `shoe_price` decimal(10,2) NOT NULL,
  `shoe_stocks` int(11) NOT NULL,
  `shoe_categorize_as` varchar(50) NOT NULL,
  `brand_id` varchar(200) NOT NULL,
  `category_id` varchar(200) NOT NULL,
  `shoe_discount` varchar(11) NOT NULL,
  `shoe_description` varchar(1000) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoes`
--

INSERT INTO `shoes` (`id`, `shoe_id`, `shoe_name`, `shoe_price`, `shoe_stocks`, `shoe_categorize_as`, `brand_id`, `category_id`, `shoe_discount`, `shoe_description`, `date_created`) VALUES
(1, 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', 'Nike Air Max 270', '7645.00', 99, 'Unisex', '2df613d0-1b83-47c0-b69e-3e620e127e98', '1cc5d44c-2df2-4992-be7d-e54a1a766934', '0%', 'Nike\'s first lifestyle Air Max brings you style, comfort and big attitude in the Nike Air Max 270. The design draws inspiration from Air Max icons, showcasing Nike\'s greatest innovation with its large window and fresh array of colours.', '2023-09-23 14:30:00'),
(2, '673ded53-c97e-4102-9ade-7fac90070b08', 'Tatum 1 Home Team PF', '6895.00', 49, 'Men', '2df613d0-1b83-47c0-b69e-3e620e127e98', 'bbb26ef5-90f0-4d8c-adb5-36cd22a1a5ea', '0%', 'Your love for the game never fades. That\'s why the Tatum 1 was created with longevity in mind. Designed to carry you from the first to the fourth (and whatever OT comes up) as efficiently as possible, we stripped it down to the essentials—and made those essentials really, really good. The result is this season\'s lightest performance basketball shoe, with rubber only where it counts, a stress-tested foam midsole and an uncaged Nike Zoom Air unit for those explosive ups. Whatever stage of ball you\'re at, the Tatum 1 will keep you playing.', '2023-09-23 14:30:00'),
(3, '53091e99-f5f8-4ff4-a83a-27223ef39d50', 'Nike Free Metcon 5', '6895.00', 116, 'Men', '2df613d0-1b83-47c0-b69e-3e620e127e98', '1cc5d44c-2df2-4992-be7d-e54a1a766934', '0%', 'When your workouts wade into the nitty-gritty, the Nike Free Metcon 5 can meet you in the depths, help you dig deep to find that final ounce of force and come out of the other side on a high. It matches style with substance, forefoot flexibility with back-end stability, perfect for flying through a cardio day or enhancing your agility. A revamped upper offers easier entry with a collar made just for your ankle.', '2023-09-23 14:30:00'),
(4, 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', 'Luca 1', '3845.00', 97, 'Men', '2df613d0-1b83-47c0-b69e-3e620e127e98', 'bbb26ef5-90f0-4d8c-adb5-36cd22a1a5ea', '0%', 'Designed for No. 77 and made for every athlete craving speed and efficiency, Luka\'s debut delivers the goods. The first shoe with full-length Formula 23 foam, it has an ultra-supportive fit crafted with the step-back in mind. Meanwhile, strong and lightweight Flight Wire embroidery keeps you feeling contained on the court. This is the assist you\'ve been waiting for—get out there and make your shot.', '2023-09-23 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `shoe_image`
--

CREATE TABLE `shoe_image` (
  `id` int(11) NOT NULL,
  `shoe_image_id` varchar(200) NOT NULL,
  `color_id` varchar(200) NOT NULL,
  `extension` varchar(10) NOT NULL DEFAULT '.png',
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoe_image`
--

INSERT INTO `shoe_image` (`id`, `shoe_image_id`, `color_id`, `extension`, `date_created`) VALUES
(1, '86b426f5-26c5-4eab-8398-b2553db74b5f', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', '.png', '2023-09-23 14:30:00'),
(2, 'c299135e-d7c6-4bee-a901-7830d55a9e73', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', '.png', '2023-09-23 14:30:00'),
(3, 'f33c338b-bdb6-4b3e-a221-42e34f57812d', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', '.png', '2023-09-23 14:30:00'),
(4, 'ad668af5-e836-4889-9f36-5d0fd5d11898', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', '.png', '2023-09-23 14:30:00'),
(5, '7e456c96-d8f4-4a86-833e-dc76d11a668b', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', '.png', '2023-09-23 14:30:00'),
(6, '50861056-ca30-4b10-bea4-a2b58800cc38', '8e03a63a-d085-48fb-a2d6-9e057ad65a21', '.png', '2023-09-23 14:30:00'),
(7, '83e6b75c-72f5-40f9-a193-bbb635739d25', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '.png', '2023-09-23 14:30:00'),
(8, '7c299083-a895-4eb3-9c42-d1f2cd5deddb', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '.png', '2023-09-23 14:30:00'),
(9, '29de63c3-636c-41a7-9bb2-7cdf06155a06', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '.png', '2023-09-23 14:30:00'),
(10, 'f021b9e1-39b8-4a5c-a884-4807f56028d3', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '.png', '2023-09-23 14:30:00'),
(11, 'aba2bb14-b114-45e3-82a0-5b9c6ee087bf', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '.png', '2023-09-23 14:30:00'),
(12, 'aaea87e0-6025-4db5-8a1c-388257b1aaa5', 'eaf3dfcd-7ddf-44b0-b3fb-c218f5c90208', '.png', '2023-09-23 14:30:00'),
(13, 'aa0193dc-caf6-4080-a285-a74f4aa47936', '0b6dba2c-1a3b-43a3-a277-0d365e835992', '.png', '2023-09-23 14:30:00'),
(14, '2fc188fe-c36e-4871-8e0f-27da2794bce6', '0b6dba2c-1a3b-43a3-a277-0d365e835992', '.png', '2023-09-23 14:30:00'),
(15, '57db71c0-88cd-4e62-ab24-9c62b35cd510', '0b6dba2c-1a3b-43a3-a277-0d365e835992', '.png', '2023-09-23 14:30:00'),
(16, 'cc77d890-80a6-42ed-a72d-d99c1625ec7b', '0b6dba2c-1a3b-43a3-a277-0d365e835992', '.png', '2023-09-23 14:30:00'),
(17, '10d3cfda-152a-452c-87f9-d4f7394fc89b', '0b6dba2c-1a3b-43a3-a277-0d365e835992', '.png', '2023-09-23 14:30:00'),
(18, '5bfd5ad8-b08e-42a0-a116-79aa69689ddf', '0b6dba2c-1a3b-43a3-a277-0d365e835992', '.png', '2023-09-23 14:30:00'),
(19, '5a255908-3a2d-48c5-9435-8619f2dffca8', '7b0c4610-0255-48e3-9a0a-d42308589660', '.png', '2023-09-23 14:30:00'),
(20, '2bd2e98f-4200-467a-b9ba-5e5162be5b1d', '7b0c4610-0255-48e3-9a0a-d42308589660', '.png', '2023-09-23 14:30:00'),
(21, 'a5c76db1-03f2-4594-812e-e83e2c50082b', '7b0c4610-0255-48e3-9a0a-d42308589660', '.png', '2023-09-23 14:30:00'),
(22, '3b54703e-adc4-4659-88c1-7c34084f435c', '7b0c4610-0255-48e3-9a0a-d42308589660', '.png', '2023-09-23 14:30:00'),
(23, 'e0a7318c-5208-4459-b3f9-058a4b1547f0', '7b0c4610-0255-48e3-9a0a-d42308589660', '.png', '2023-09-23 14:30:00'),
(24, '056ada2c-dd4b-4c84-abd0-86b1e01e8032', '7b0c4610-0255-48e3-9a0a-d42308589660', '.png', '2023-09-23 14:30:00'),
(25, '3d53af3c-16ae-45e6-8901-7793862779e4', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '.png', '2023-09-23 14:30:00'),
(26, '9fa3f7db-a4fc-40d9-80bb-4c1635aa85c0', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '.png', '2023-09-23 14:30:00'),
(27, '7e20c5a4-5a7e-45dd-8fd7-3d3c553a12f8', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '.png', '2023-09-23 14:30:00'),
(28, 'f7a90ecc-ce39-48c7-8c0a-6f8d99c80112', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '.png', '2023-09-23 14:30:00'),
(29, '5d3db34c-1374-42fb-bed2-4d0644626b9e', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '.png', '2023-09-23 14:30:00'),
(30, 'ade372d1-a638-488b-a07b-055429b2945e', 'ceea5134-c913-49f1-ba10-62e0bc264fe9', '.png', '2023-09-23 14:30:00'),
(31, '1b183adb-c288-40de-b6cc-b53f3bca4867', 'e9e86611-225a-4794-96f6-82b26d0b5b80', '.png', '2023-09-23 14:30:00'),
(32, '72a0b23a-e83e-4c6f-ba46-9c70344d5ad6', 'e9e86611-225a-4794-96f6-82b26d0b5b80', '.png', '2023-09-23 14:30:00'),
(33, '376e5028-7dc2-4f38-a4f1-0c6842be47c1', 'e9e86611-225a-4794-96f6-82b26d0b5b80', '.png', '2023-09-23 14:30:00'),
(34, 'ad1a4fec-5d6f-4586-a9c2-d6c6d5b719cc', 'e9e86611-225a-4794-96f6-82b26d0b5b80', '.png', '2023-09-23 14:30:00'),
(35, '2fe21935-17c2-46a6-a408-d0373c2fb996', 'e9e86611-225a-4794-96f6-82b26d0b5b80', '.png', '2023-09-23 14:30:00'),
(36, '57249e9b-4437-44f9-8e9b-b7e2b2132d75', 'e9e86611-225a-4794-96f6-82b26d0b5b80', '.png', '2023-09-23 14:30:00'),
(37, 'bef2ef1f-afe4-433c-a1ca-ea5e162649b5', '6b03778f-9968-4f1d-838b-5b6fa129db38', '.png', '2023-09-23 14:30:00'),
(38, 'c8349e7a-6e34-4dbc-8d67-7a2ede5bd455', '6b03778f-9968-4f1d-838b-5b6fa129db38', '.png', '2023-09-23 14:30:00'),
(39, 'c6c2e824-5c5b-4ff1-83d4-0d763892b1b4', '6b03778f-9968-4f1d-838b-5b6fa129db38', '.png', '2023-09-23 14:30:00'),
(40, 'dde1cc0b-b991-4b5f-a3de-2cff53ccb4cf', '6b03778f-9968-4f1d-838b-5b6fa129db38', '.png', '2023-09-23 14:30:00'),
(41, '571d683f-8058-4efb-ae83-b5f7222f2fb8', '6b03778f-9968-4f1d-838b-5b6fa129db38', '.png', '2023-09-23 14:30:00'),
(42, '83b0621f-902a-4ab7-8f8e-201e0dfa0243', '6b03778f-9968-4f1d-838b-5b6fa129db38', '.png', '2023-09-23 14:30:00'),
(43, '8ae1fb3d-9373-486e-8621-3209ea3443be', '5db5e818-0e12-4cc0-922c-0140720d4a34', '.png', '2023-09-23 14:30:00'),
(44, 'b24e0a84-3802-4c2e-90a2-5d7223e7c7f9', '5db5e818-0e12-4cc0-922c-0140720d4a34', '.png', '2023-09-23 14:30:00'),
(45, '9609b9d0-a777-42d2-bd6d-2679771c6318', '5db5e818-0e12-4cc0-922c-0140720d4a34', '.png', '2023-09-23 14:30:00'),
(46, '842d160b-c85c-4bb2-9657-f8e0818feb21', '5db5e818-0e12-4cc0-922c-0140720d4a34', '.png', '2023-09-23 14:30:00'),
(47, '7f534007-a5a6-4c3e-a777-664588c0c163', '5db5e818-0e12-4cc0-922c-0140720d4a34', '.png', '2023-09-23 14:30:00'),
(48, 'aa73b990-31a0-4ce3-ba1d-13f8bd187b33', '5db5e818-0e12-4cc0-922c-0140720d4a34', '.png', '2023-09-23 14:30:00'),
(49, '5734dd85-9820-496f-b20e-3d2a2c02f4db', 'cf5265dc-893a-46e0-941b-6fb060907850', '.png', '2023-09-23 14:30:00'),
(50, '5751ad11-cbe8-45d5-a3e3-68a6d25de219', 'cf5265dc-893a-46e0-941b-6fb060907850', '.png', '2023-09-23 14:30:00'),
(51, 'cbaf58e4-a0fe-437e-b968-ad347e1ceaae', 'cf5265dc-893a-46e0-941b-6fb060907850', '.png', '2023-09-23 14:30:00'),
(52, 'eed591a6-729d-4ad8-b2cb-c4b5734003e9', 'cf5265dc-893a-46e0-941b-6fb060907850', '.png', '2023-09-23 14:30:00'),
(53, '1b89fa05-d722-484f-973a-a74ee86a9603', 'cf5265dc-893a-46e0-941b-6fb060907850', '.png', '2023-09-23 14:30:00'),
(54, '32aa2248-9d05-4ae8-a0cc-db235b29b299', 'cf5265dc-893a-46e0-941b-6fb060907850', '.png', '2023-09-23 14:30:00'),
(55, '5a01f07b-4af2-435e-afa2-8d42851074ea', '2a6800db-2ef3-493b-a0be-53322387a05f', '.png', '2023-09-23 14:30:00'),
(56, '567b48e9-8c02-485d-bc89-c7aa4a86a370', '2a6800db-2ef3-493b-a0be-53322387a05f', '.png', '2023-09-23 14:30:00'),
(57, '0986416d-c197-400f-b390-13cb6a2ec989', '2a6800db-2ef3-493b-a0be-53322387a05f', '.png', '2023-09-23 14:30:00'),
(58, 'ad5ac91b-1ba4-40f3-989c-7d2bd964d400', '2a6800db-2ef3-493b-a0be-53322387a05f', '.png', '2023-09-23 14:30:00'),
(59, 'd8493388-cf05-422d-a6da-6d29943134f8', '2a6800db-2ef3-493b-a0be-53322387a05f', '.png', '2023-09-23 14:30:00'),
(60, '8ce60bae-f2ab-439e-9b68-c65aa3620f36', '2a6800db-2ef3-493b-a0be-53322387a05f', '.png', '2023-09-23 14:30:00'),
(61, '1fe1d99a-96c3-4bbc-866a-44b817b7a08d', '53749807-e3c3-4738-922c-7473dc048e0f', '.png', '2023-09-23 14:30:00'),
(62, '35a53ecd-9e30-4aa2-97ca-dff41a6dea6c', '53749807-e3c3-4738-922c-7473dc048e0f', '.png', '2023-09-23 14:30:00'),
(63, 'b8bdf799-b1e5-4101-9045-029f53a0af02', '53749807-e3c3-4738-922c-7473dc048e0f', '.png', '2023-09-23 14:30:00'),
(64, '8bcd6295-722f-411c-9e24-974e0891f2ae', '53749807-e3c3-4738-922c-7473dc048e0f', '.png', '2023-09-23 14:30:00'),
(65, 'ee3521da-4a1f-4622-b31f-29e94aa1a61e', '53749807-e3c3-4738-922c-7473dc048e0f', '.png', '2023-09-23 14:30:00'),
(66, '133ba299-b50b-4aaf-a2e4-0c8128319d47', '53749807-e3c3-4738-922c-7473dc048e0f', '.png', '2023-09-23 14:30:00'),
(67, '92f2ceea-65de-48e9-aa90-47cd48ee2847', '238e4529-cbaf-44d8-834d-1f56c3994688', '.png', '2023-09-23 14:30:00'),
(68, '823d2deb-e378-473e-b94d-57db22f87599', '238e4529-cbaf-44d8-834d-1f56c3994688', '.png', '2023-09-23 14:30:00'),
(69, '65838311-0fb5-4692-9009-fa917dbaa66f', '238e4529-cbaf-44d8-834d-1f56c3994688', '.png', '2023-09-23 14:30:00'),
(70, '6b76ff1a-e6f6-4ce1-91c7-d55223602e48', '238e4529-cbaf-44d8-834d-1f56c3994688', '.png', '2023-09-23 14:30:00'),
(71, 'dc9f923a-1c61-467b-aba3-d4ade94310b6', '238e4529-cbaf-44d8-834d-1f56c3994688', '.png', '2023-09-23 14:30:00'),
(72, '36d2336c-e9cb-4897-a7a4-c514f39ace9f', '238e4529-cbaf-44d8-834d-1f56c3994688', '.png', '2023-09-23 14:30:00'),
(73, '326a98d5-e8fb-4686-a1f6-13663033cf81', '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', '.png', '2023-09-23 14:30:00'),
(74, 'd384f95c-0d6f-4a01-ba11-7c11dc221204', '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', '.png', '2023-09-23 14:30:00'),
(75, '43278364-8531-4eda-8e65-e290b1814f8e', '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', '.png', '2023-09-23 14:30:00'),
(76, '074110eb-b84d-4b01-9cf1-368f3039dae6', '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', '.png', '2023-09-23 14:30:00'),
(77, 'c07c0777-d751-41e1-98a8-0a13696feaae', '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', '.png', '2023-09-23 14:30:00'),
(78, '2d2cc4d5-94bf-4de7-8dcc-9c824724848e', '2e3a2ac2-4372-4dea-9a5b-ff282ab29aea', '.png', '2023-09-23 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `size` varchar(10) NOT NULL,
  `size_status` tinyint(4) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size_id`, `shoe_id`, `size`, `size_status`, `date_created`) VALUES
(1, '40413cca-5301-442a-93e0-9dfbd28983da', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '2', 1, '2023-09-23 14:30:00'),
(2, '32c5b3d7-5bf9-459f-a43e-4ea684916cb3', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '2.5', 1, '2023-09-23 14:30:00'),
(3, 'b6a0af5d-9fbb-467d-95ad-7c1d39efb15d', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '3', 1, '2023-09-23 14:30:00'),
(4, '8d8fda1b-eb9f-4fda-b8d8-42f4c0cce00a', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '3.5', 1, '2023-09-23 14:30:00'),
(5, '2a444683-ba74-4721-910f-5f2be9ee617c', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '4', 1, '2023-09-23 14:30:00'),
(6, 'bb9c7c1c-58e7-476f-9127-1a62505d4456', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '4.5', 1, '2023-09-23 14:30:00'),
(7, 'b60119c7-a5e4-4053-a938-89a8bdfc66b6', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '5', 1, '2023-09-23 14:30:00'),
(8, 'e262cc7b-1d9a-42af-a590-cf7abbd6ef7c', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '5.5', 1, '2023-09-23 14:30:00'),
(9, '73884ce3-260c-4454-a59f-8df0538f7268', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '6', 1, '2023-09-23 14:30:00'),
(10, '88b56faf-1216-4786-9e6f-c8bd295c972c', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '6.5', 1, '2023-09-23 14:30:00'),
(11, '16299d7a-22cc-48bd-8c81-12368d3475da', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '7', 1, '2023-09-23 14:30:00'),
(12, 'c829f276-4303-4c09-a6e7-5724a3ec8d98', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '7.5', 1, '2023-09-23 14:30:00'),
(13, 'a19eecbb-6008-49e6-8314-5987dce8d2d1', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '8', 1, '2023-09-23 14:30:00'),
(14, '2cc5692e-2485-457b-9a08-1c6a854d5e22', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '8.5', 1, '2023-09-23 14:30:00'),
(15, 'f7bf4124-bfe8-497a-a90c-ce1964b71b13', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '9', 1, '2023-09-23 14:30:00'),
(16, '6d395525-f287-41f9-90d9-2f8f365148f5', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '9.5', 1, '2023-09-23 14:30:00'),
(17, '6930b5a6-c4bb-4698-a7c6-0c5af311047b', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '10', 1, '2023-09-23 14:30:00'),
(18, '17f7078c-5d0a-45fb-a45e-2288d6a65287', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '10.5', 1, '2023-09-23 14:30:00'),
(19, '8c68ce29-76fe-4a09-89f8-96898ecc1935', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '11', 1, '2023-09-23 14:30:00'),
(20, 'bef751af-22ac-4e43-96d5-5e60694d933a', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '12', 1, '2023-09-23 14:30:00'),
(21, '8a826f19-fb31-4123-b279-4c8f82b35f3b', 'b0f05e2f-e3de-4005-ba1b-bf9c4d414405', '13', 1, '2023-09-23 14:30:00'),
(22, '867ff440-cbfd-4609-888a-fc13b6954502', '673ded53-c97e-4102-9ade-7fac90070b08', '2', 1, '2023-09-23 14:30:00'),
(23, '81a30ca3-fc89-4525-8b72-365d9571de17', '673ded53-c97e-4102-9ade-7fac90070b08', '2.5', 1, '2023-09-23 14:30:00'),
(24, '31d0fbc5-6255-473f-bd55-6efce311a0a2', '673ded53-c97e-4102-9ade-7fac90070b08', '3', 1, '2023-09-23 14:30:00'),
(25, '59f2a1cb-8095-4d33-9a89-b4775a91ecd5', '673ded53-c97e-4102-9ade-7fac90070b08', '3.5', 1, '2023-09-23 14:30:00'),
(26, 'd1103831-c2a3-421e-8ba8-23480e835e81', '673ded53-c97e-4102-9ade-7fac90070b08', '4', 1, '2023-09-23 14:30:00'),
(27, '277c3e66-51f6-49e5-8bfd-ebf0f374aeba', '673ded53-c97e-4102-9ade-7fac90070b08', '4.5', 1, '2023-09-23 14:30:00'),
(28, '81602049-b892-4702-bda2-572e977086d9', '673ded53-c97e-4102-9ade-7fac90070b08', '5', 1, '2023-09-23 14:30:00'),
(29, 'e560895a-258e-45f4-a5f3-a477252665df', '673ded53-c97e-4102-9ade-7fac90070b08', '5.5', 1, '2023-09-23 14:30:00'),
(30, '970843a0-d38e-4622-9bd9-b5f9826b05a9', '673ded53-c97e-4102-9ade-7fac90070b08', '6', 1, '2023-09-23 14:30:00'),
(31, '85a1fc8e-4382-4c58-a18a-c7c14ecb282a', '673ded53-c97e-4102-9ade-7fac90070b08', '6.5', 1, '2023-09-23 14:30:00'),
(32, 'ba7c115a-f44e-4aa7-acb5-7e369720a053', '673ded53-c97e-4102-9ade-7fac90070b08', '7', 1, '2023-09-23 14:30:00'),
(33, 'c117cdef-982c-4543-895a-6797ed8ca0ef', '673ded53-c97e-4102-9ade-7fac90070b08', '7.5', 1, '2023-09-23 14:30:00'),
(34, '2a2db259-3edd-45b7-8edb-364386f319f0', '673ded53-c97e-4102-9ade-7fac90070b08', '8', 1, '2023-09-23 14:30:00'),
(35, 'bcf0b5cf-4860-4be2-92ea-aafbd68cfbdd', '673ded53-c97e-4102-9ade-7fac90070b08', '8.5', 1, '2023-09-23 14:30:00'),
(36, 'c512d84b-4501-4792-9864-467f644acb9f', '673ded53-c97e-4102-9ade-7fac90070b08', '9', 1, '2023-09-23 14:30:00'),
(37, 'e33fd87c-3be9-4d7e-86a7-e7b60c1f4daf', '673ded53-c97e-4102-9ade-7fac90070b08', '9.5', 1, '2023-09-23 14:30:00'),
(38, 'd3e2f290-c009-4de2-a898-9f471283acfe', '673ded53-c97e-4102-9ade-7fac90070b08', '10', 1, '2023-09-23 14:30:00'),
(39, 'dcf9997e-9010-4b25-80e8-266dc3aca1f9', '673ded53-c97e-4102-9ade-7fac90070b08', '10.5', 1, '2023-09-23 14:30:00'),
(40, 'a7a4f75d-e0c0-4c2d-b90f-4c7cbc097f8b', '673ded53-c97e-4102-9ade-7fac90070b08', '11', 1, '2023-09-23 14:30:00'),
(41, 'd4a87e82-c34e-4a60-b326-26fc15ec1d3a', '673ded53-c97e-4102-9ade-7fac90070b08', '12', 1, '2023-09-23 14:30:00'),
(42, '71400559-f12f-4208-a479-ddcf93b6e32d', '673ded53-c97e-4102-9ade-7fac90070b08', '13', 1, '2023-09-23 14:30:00'),
(43, 'e624f1fe-9a50-4ff2-b5d1-3fd3ef138488', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '2', 1, '2023-09-23 14:30:00'),
(44, 'b944997a-084c-4add-9b8e-09f463b1126c', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '2.5', 1, '2023-09-23 14:30:00'),
(45, '4baf4574-c6f4-45d6-aa25-f2bda48787e7', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '3', 1, '2023-09-23 14:30:00'),
(46, 'fcbcc760-ded4-47d5-bddc-8d7597d8b992', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '3.5', 1, '2023-09-23 14:30:00'),
(47, 'dc27bc04-f714-4537-9857-c1ab8893fa7e', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '4', 1, '2023-09-23 14:30:00'),
(48, 'fe750765-9b9c-498a-bd6f-117d7c9660f6', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '4.5', 1, '2023-09-23 14:30:00'),
(49, '86490c8b-c55c-4ae5-86ad-a8186a2a1e87', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '5', 1, '2023-09-23 14:30:00'),
(50, '5b7a6cca-abdd-4d35-9e01-f886fcdda197', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '5.5', 1, '2023-09-23 14:30:00'),
(51, '582bcda0-f586-4c60-86ff-c4c5d9e7e07e', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '6', 1, '2023-09-23 14:30:00'),
(52, '6b5dd06a-9faf-495c-ae48-c2f42bd4d7d7', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '6.5', 1, '2023-09-23 14:30:00'),
(53, 'dfbd9241-f1fb-4d4a-a912-c656c6b2fb53', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '7', 1, '2023-09-23 14:30:00'),
(54, '1091b3ed-1728-49f5-af10-141c8016b606', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '7.5', 1, '2023-09-23 14:30:00'),
(55, 'ca67b265-8c2c-493a-a688-28360b2b43c9', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '8', 1, '2023-09-23 14:30:00'),
(56, '3838366e-e0d0-4366-9d93-e763feb001e8', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '8.5', 1, '2023-09-23 14:30:00'),
(57, 'b3b71206-bf9e-4fb2-8916-2680f34d2d5d', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '9', 1, '2023-09-23 14:30:00'),
(58, '68a9fcce-b51b-4fc5-8e36-6f2d039c4ff7', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '9.5', 1, '2023-09-23 14:30:00'),
(59, '3d338976-e86d-4c09-9c7e-40ee536aa39e', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '10', 1, '2023-09-23 14:30:00'),
(60, '00157fcd-8e12-4b05-8bde-07dc32910795', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '10.5', 1, '2023-09-23 14:30:00'),
(61, 'fb1d4058-c955-449b-abaf-797c2399b4e7', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '11', 1, '2023-09-23 14:30:00'),
(62, '62d91277-739a-4bc8-89e9-da2837a62876', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '12', 1, '2023-09-23 14:30:00'),
(63, '8c780f86-59cf-4c93-b03c-b2af0dd98e7f', '53091e99-f5f8-4ff4-a83a-27223ef39d50', '13', 1, '2023-09-23 14:30:00'),
(64, '258c1c25-66c1-47a6-81a6-423953830a21', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '2', 1, '2023-09-23 14:30:00'),
(65, '7371e9c3-1e2b-4568-a5a0-6d1d169eb339', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '2.5', 1, '2023-09-23 14:30:00'),
(66, '9beca587-7af3-48e6-b99c-d82937c3080a', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '3', 1, '2023-09-23 14:30:00'),
(67, '4a038b00-4792-45e7-921d-f90dd1918dc2', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '3.5', 1, '2023-09-23 14:30:00'),
(68, 'd0733a26-8ca8-44f7-bcd1-c8b342df7301', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '4', 1, '2023-09-23 14:30:00'),
(69, '9703df69-757e-4bca-b8b7-c1d2746ee059', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '4.5', 1, '2023-09-23 14:30:00'),
(70, 'aea2ae41-ff24-4179-bfd2-d12299476eaa', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '5', 1, '2023-09-23 14:30:00'),
(71, '3bcfb5e4-ff6f-49ea-a43c-18386adc31ca', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '5.5', 1, '2023-09-23 14:30:00'),
(72, '9b00b27e-4c9c-4cb1-a7f5-5efa9aca7c7e', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '6', 1, '2023-09-23 14:30:00'),
(73, 'c03d9b4d-e91f-4a15-a3a6-68ff3924c129', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '6.5', 1, '2023-09-23 14:30:00'),
(74, '8556e3e0-0520-4939-8983-05efac37dd5d', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '7', 1, '2023-09-23 14:30:00'),
(75, 'd8a721bb-cee3-4abd-923f-5e240766a7a3', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '7.5', 1, '2023-09-23 14:30:00'),
(76, '478a2842-a0c2-405d-8849-dcee0623de8e', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '8', 1, '2023-09-23 14:30:00'),
(77, '809d1333-59d1-4bb8-905e-4a1ced23bd2f', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '8.5', 1, '2023-09-23 14:30:00'),
(78, '8e83c22e-92ba-4d22-a5b5-05b9ccbb0825', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '9', 1, '2023-09-23 14:30:00'),
(79, '21778fea-9cd1-497e-81dc-fe1ab6e6af72', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '9.5', 1, '2023-09-23 14:30:00'),
(80, '0856c096-e280-4985-ab4c-b2eb41b0e837', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '10', 1, '2023-09-23 14:30:00'),
(81, '27fb2f01-8056-40d1-8725-d41e2bd8f2e8', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '10.5', 1, '2023-09-23 14:30:00'),
(82, '97d2bb41-adbe-4c89-9b7b-efb257c3f812', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '11', 1, '2023-09-23 14:30:00'),
(83, '6f31830a-7159-48e1-b2f4-877368988dbc', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '12', 1, '2023-09-23 14:30:00'),
(84, 'fc4e7578-572d-42d2-90ac-88b4d0e9e497', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '13', 1, '2023-09-23 14:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `date_created`) VALUES
(1, 'reblandoraymond6@gmail.com', '2023-10-21 10:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `wishlist_id` varchar(200) NOT NULL,
  `account_id` varchar(200) NOT NULL,
  `shoe_id` varchar(200) NOT NULL,
  `size_id` varchar(200) NOT NULL,
  `color_id` varchar(200) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `wishlist_id`, `account_id`, `shoe_id`, `size_id`, `color_id`, `date_added`) VALUES
(8, 'fbef6ad6-3505-442c-ac9f-08e10777a02e', '48e33b25-809c-4d34-aa27-dba2fff85293', 'd7e7cea3-8c97-4ce0-aea4-12508973eaf7', '478a2842-a0c2-405d-8849-dcee0623de8e', '2a6800db-2ef3-493b-a0be-53322387a05f', '2023-10-16 13:23:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_verify`
--
ALTER TABLE `email_verify`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderred_items`
--
ALTER TABLE `orderred_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shoe_image`
--
ALTER TABLE `shoe_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `email_verify`
--
ALTER TABLE `email_verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orderred_items`
--
ALTER TABLE `orderred_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shoe_image`
--
ALTER TABLE `shoe_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
