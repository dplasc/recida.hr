-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 10, 2025 at 07:25 AM
-- Server version: 5.7.24
-- PHP Version: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1.3atlas`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_types`
--

DROP TABLE IF EXISTS `custom_types`;
CREATE TABLE `custom_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custom_types`
--

INSERT INTO `custom_types` (`id`, `name`, `slug`, `status`, `sorting`, `logo`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Car', 'car', 1, 5, '1752132100_logo_MFLkZgbnfk.svg', '1752132100_image_iRKhp5gT49.jpg', NULL, '2025-07-10 01:21:40'),
(2, 'Hotel', 'hotel', 1, 1, '1752042726_logo_3jygp6cF0P.svg', '1752042552_image_s33K8Tmufw.jpg', NULL, '2025-07-10 01:14:54'),
(3, 'Beauty', 'beauty', 1, 4, '1752057464_logo_A4i3DKlqHb.svg', '1752057464_image_NpWcHdFiGt.jpg', NULL, '2025-07-10 01:14:54'),
(4, 'Restaurant', 'restaurant', 1, 3, '1752131989_logo_5fgSn6qbKl.svg', '1752131989_image_AAdh8Mm0ru.jpg', NULL, '2025-07-10 01:19:49'),
(5, 'Real-Estate', 'real-estate', 1, 2, '1752057375_logo_S2UdnQpTLA.svg', '1752057375_image_B91JNVKSS1.jpg', NULL, '2025-07-10 01:14:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_types`
--
ALTER TABLE `custom_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_types`
--
ALTER TABLE `custom_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
