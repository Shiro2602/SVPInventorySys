-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 10:49 AM
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
-- Database: `svpdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `technician_name` varchar(255) DEFAULT NULL,
  `tools` text DEFAULT NULL,
  `materials` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `price` decimal(13,2) NOT NULL,
  `action_date` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `action_type`, `technician_name`, `tools`, `materials`, `remarks`, `price`, `action_date`, `quantity`) VALUES
(62, 'Add Item', 'svproadmin', 'testtool113123', NULL, NULL, 300.00, '2024-08-22 13:45:36', 30),
(63, 'Delete Item', 'svproadmin', '0', '', '', 300.00, '2024-08-22 13:46:03', 30),
(64, 'Add Item', 'svproadmin', 'retq', NULL, NULL, 200.00, '2024-08-22 13:50:49', 20),
(65, 'Delete Item', 'svproadmin', '0', '', '', 200.00, '2024-08-22 13:51:00', 20),
(66, 'Add Item', 'svproadmin', 'retq', NULL, NULL, 200.00, '2024-08-22 13:51:29', 21),
(67, 'Delete Item', 'svproadmin', '0', '', '', 200.00, '2024-08-22 13:51:47', 21),
(68, 'Add Item', 'svproadmin', 'retq', NULL, NULL, 200.00, '2024-08-22 13:53:48', 20),
(69, 'Delete Item', 'svproadmin', 'retq', '', '', 200.00, '2024-08-22 13:54:07', 20),
(70, 'Withdrawal', 'svproadmin', 'Screwdriver Set: Quantity 1', 'Material C: Quantity 21', 'eqrqrqrq', 0.00, '2024-08-22 13:54:30', 0),
(71, 'Return', 'svproadmin', 'Screwdriver Set (Quantity: 1)', 'Material C (Quantity: 21)', 'eqrqrqrq', 0.00, '2024-08-22 13:54:50', 0),
(72, 'Withdrawal', 'svproadmin', 'Screwdriver Set: Quantity 1', '', '', 0.00, '2024-08-22 14:12:16', 0),
(73, 'Return', 'svproadmin', 'Screwdriver Set (Quantity: 1)', '', '', 0.00, '2024-08-22 14:12:19', 0),
(74, 'Withdrawal', 'svproadmin', 'Screwdriver Set Quantity 1', 'Material A Quantity 1', 'test', 0.00, '2024-08-22 14:17:01', 0),
(75, 'Return', 'svproadmin', 'Screwdriver Set (Quantity: 1)', 'Material A (Quantity: 1)', 'test', 0.00, '2024-08-22 14:17:05', 0),
(76, 'Withdrawal', 'svproadmin', 'Screwdriver Set (Quantity: 1)', '', '', 0.00, '2024-08-22 14:19:22', 0),
(77, 'Withdrawal', 'svproadmin', 'Screwdriver Set (Quantity: 1)', 'Material A (Quantity: 1)', 'rerere', 0.00, '2024-08-22 14:19:36', 0),
(78, 'Return', 'svproadmin', 'Screwdriver Set (Quantity: 1)', '', '', 0.00, '2024-08-22 14:20:09', 0),
(79, 'Return', 'svproadmin', 'Screwdriver Set (Quantity: 1)', 'Material A (Quantity: 1)', 'rerere', 0.00, '2024-08-22 14:20:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `quantity`, `date_added`, `price`) VALUES
(1, 'Material A', 12, '2024-08-04 03:14:02', 10.50),
(3, 'Material C', 157, '2024-08-04 03:14:02', 20.00),
(4, 'Material D', 75, '2024-08-04 03:14:02', 7.25);

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `in_use` int(11) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`id`, `name`, `quantity`, `in_use`, `price`, `date_added`) VALUES
(4, 'Screwdriver Set', 21, 12, 1000.00, '2024-08-08 03:40:36'),
(5, 'Tape Measure', 50, 20, 0.00, '2024-08-08 03:40:36'),
(6, 'Wrench Set', 10, 6, 0.00, '2024-08-08 03:40:36'),
(7, 'Electric Sander', 12, 4, 0.00, '2024-08-08 03:40:36'),
(8, 'Pliers', 20, 8, 0.00, '2024-08-08 03:40:36'),
(38, 'Cord Drill', 3, 0, 5780.00, '2024-08-08 03:40:36'),
(65, 'Hammer ', 4, 0, 300.00, '2024-08-21 05:57:31');

-- --------------------------------------------------------

--
-- Table structure for table `toolstatus`
--

CREATE TABLE `toolstatus` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_taken` datetime NOT NULL,
  `date_returned` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toolstatus`
--

INSERT INTO `toolstatus` (`id`, `username`, `remarks`, `date_taken`, `date_returned`) VALUES
(1, 'Chiitan', 'test', '2024-08-08 03:40:13', '2024-08-08 03:55:55'),
(2, 'Chiitan', 'Remark Test', '2024-08-08 04:08:23', '2024-08-08 04:11:05'),
(3, 'Chiitan', 'test', '2024-08-08 04:12:18', '2024-08-08 04:12:34'),
(4, 'Chiitan', 'test', '2024-08-08 04:13:17', '2024-08-08 04:13:20'),
(5, 'Chiitan', 'test', '2024-08-08 04:13:44', '2024-08-08 04:13:50'),
(26, 'svproadmin', '', '2024-08-15 07:32:11', '2024-08-15 07:32:24'),
(27, 'svproadmin', '', '2024-08-15 07:33:26', '2024-08-15 07:33:32'),
(54, 'svpro', '1', '2024-08-16 13:32:51', '2024-08-16 13:32:54'),
(55, 'svproadmin', 'Lorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem IpsumLorem Ipsum', '2024-08-16 13:50:33', '2024-08-16 13:50:44'),
(56, 'svproadmin', 'test', '2024-08-19 14:01:11', '2024-08-20 09:01:51'),
(57, 'svproadmin', 'test', '2024-08-20 09:02:46', '2024-08-20 09:03:00'),
(58, 'svproadmin', 'test', '2024-08-20 09:03:42', '2024-08-20 09:27:05'),
(59, 'svproadmin', 'test', '2024-08-20 10:04:32', '2024-08-20 10:04:37'),
(60, 'svproadmin', 'test', '2024-08-20 10:12:14', '2024-08-20 10:12:18'),
(61, 'svproadmin', '1', '2024-08-20 14:16:54', '2024-08-20 14:17:07'),
(62, 'svproadmin', 'Test', '2024-08-20 14:21:52', '2024-08-20 14:50:30'),
(63, 'svproadmin', 'adasdasdad', '2024-08-20 14:51:39', '2024-08-20 14:51:42'),
(64, 'svproadmin', 'qweqweqwewq', '2024-08-20 14:54:51', '2024-08-20 14:54:59'),
(65, 'svproadmin', 'qdwqdqwdqwd', '2024-08-20 14:55:17', '2024-08-20 15:49:05'),
(66, 'svproadmin', '1111', '2024-08-20 15:52:26', '2024-08-20 15:52:41'),
(67, 'svproadmin', '1', '2024-08-20 16:03:41', '2024-08-20 16:04:25'),
(68, 'svproadmin', '12', '2024-08-20 16:11:11', '2024-08-20 16:11:16'),
(69, 'svproadmin', '23123', '2024-08-20 16:11:28', '2024-08-20 16:11:30'),
(70, 'svproadmin', 'teasdasd', '2024-08-20 16:23:48', '2024-08-20 16:23:50'),
(71, 'svproadmin', 'trtrt', '2024-08-21 08:23:19', '2024-08-21 08:23:23'),
(72, 'svproadmin', '1121212', '2024-08-21 09:07:27', '2024-08-21 09:07:30'),
(73, 'svproadmin', 'test', '2024-08-21 09:36:59', '2024-08-21 09:37:02'),
(74, 'svproadmin', 'test', '2024-08-21 09:40:58', '2024-08-21 09:53:52'),
(75, 'svproadmin', 'tewedw', '2024-08-21 11:40:17', '2024-08-21 11:40:21'),
(76, 'svproadmin', '213134234', '2024-08-21 11:47:04', '2024-08-21 11:47:07'),
(80, 'svproadmin', 'test', '2024-08-21 14:39:55', '2024-08-21 14:40:32'),
(81, 'svproadmin', '123ljbklnml', '2024-08-21 14:42:34', '2024-08-21 14:56:53'),
(82, 'svproadmin', '312', '2024-08-21 14:57:40', '2024-08-21 15:05:15'),
(84, 'svproadmin', '', '2024-08-21 14:58:30', '2024-08-21 15:05:17'),
(86, 'svproadmin', 'test', '2024-08-21 15:04:20', '2024-08-21 15:05:18'),
(87, 'svproadmin', '314', '2024-08-21 15:04:41', '2024-08-21 15:05:20'),
(92, 'svproadmin', '', '2024-08-21 15:21:49', '2024-08-21 15:22:01'),
(93, 'svproadmin', 'test', '2024-08-21 15:22:08', '2024-08-21 15:24:32'),
(94, 'svproadmin', 'test', '2024-08-21 15:24:38', '2024-08-21 15:28:23'),
(96, 'svproadmin', '', '2024-08-21 15:28:55', '2024-08-22 08:31:36'),
(97, 'svproadmin', '', '2024-08-21 15:29:08', '2024-08-22 08:31:37'),
(98, 'svproadmin', '123123123', '2024-08-21 15:29:25', '2024-08-22 08:31:38'),
(99, 'svproadmin', 'test12312312312331313', '2024-08-22 08:30:56', '2024-08-22 08:31:38'),
(100, 'svproadmin', '', '2024-08-22 08:31:17', '2024-08-22 08:31:39'),
(101, 'svproadmin', 'test1231', '2024-08-22 08:31:54', '2024-08-22 08:32:02'),
(102, 'svproadmin', '1', '2024-08-22 10:34:31', '2024-08-22 10:35:07'),
(103, 'svproadmin', 'eqrqrqrq', '2024-08-22 13:54:30', '2024-08-22 13:54:50'),
(104, 'svproadmin', '', '2024-08-22 14:12:16', '2024-08-22 14:12:19'),
(105, 'svproadmin', 'test', '2024-08-22 14:17:01', '2024-08-22 14:17:05'),
(106, 'svproadmin', '', '2024-08-22 14:19:22', '2024-08-22 14:20:09'),
(107, 'svproadmin', 'rerere', '2024-08-22 14:19:36', '2024-08-22 14:20:11');

-- --------------------------------------------------------

--
-- Table structure for table `toolstatus_materials`
--

CREATE TABLE `toolstatus_materials` (
  `id` int(11) NOT NULL,
  `toolstatus_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toolstatus_materials`
--

INSERT INTO `toolstatus_materials` (`id`, `toolstatus_id`, `material_id`, `quantity`) VALUES
(14, 59, 1, 1),
(15, 60, 1, 0),
(16, 62, 1, 2),
(17, 69, 1, 1),
(18, 70, 1, 0),
(19, 81, 3, 12),
(20, 82, 3, 2),
(21, 98, 3, 2),
(22, 99, 3, 5),
(23, 100, 1, 1),
(24, 101, 3, 1),
(25, 103, 3, 21),
(26, 105, 1, 1),
(27, 107, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `toolstatus_tools`
--

CREATE TABLE `toolstatus_tools` (
  `id` int(11) NOT NULL,
  `toolstatus_id` int(11) NOT NULL,
  `tool_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `toolstatus_tools`
--

INSERT INTO `toolstatus_tools` (`id`, `toolstatus_id`, `tool_id`, `quantity`) VALUES
(42, 54, 4, 0),
(43, 55, 4, 1),
(44, 56, 4, 1),
(45, 57, 4, 0),
(46, 58, 4, 1),
(47, 59, 4, 0),
(48, 60, 4, 0),
(49, 61, 4, 0),
(50, 62, 4, 1),
(51, 63, 4, 1),
(52, 64, 4, 1),
(53, 65, 4, 1),
(54, 66, 4, 1),
(55, 67, 4, 1),
(57, 69, 4, 1),
(58, 71, 4, 1),
(59, 72, 4, 1),
(60, 73, 4, 1),
(61, 74, 4, 1),
(62, 75, 4, 1),
(63, 76, 4, 1),
(67, 80, 4, 1),
(68, 81, 4, 1),
(69, 82, 4, 1),
(71, 84, 4, 1),
(73, 86, 4, 1),
(74, 87, 4, 0),
(78, 93, 4, 1),
(79, 94, 4, 1),
(81, 96, 4, 1),
(82, 97, 4, 1),
(83, 98, 4, 1),
(84, 100, 4, 1),
(85, 101, 4, 1),
(86, 102, 4, 1),
(87, 103, 4, 1),
(88, 104, 4, 1),
(89, 105, 4, 1),
(90, 106, 4, 1),
(91, 107, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `image`, `username`, `role`, `date_added`, `password`) VALUES
(6, 'uploads/svpimg.png', 'svproadmin', 'admin', '2024-08-06 03:16:13', '$2y$10$iVixKEqz1gDlUz4c0R0zh.zl92B3BK/.HnGYbv9XfxsfAwK7ZH/fO'),
(11, 'uploads/images.jfif', 'svproadmin2', 'admin', '2024-08-14 02:39:18', '$2y$10$TdzYEQWFL35wzlJbdx99Pei6TpJ6UURKBVre/kBOwSEBlAXk0oNE.'),
(13, 'uploads/66c2ab7c6eaed_svpimg.png', 'svpro', 'technician', '2024-08-19 02:18:36', '$2y$10$pibUbLvR.U15xpTVm7ALIe3yDa.I6QTBtGZaYqikQNkUY5Eu3WUwy'),
(14, 'uploads/66c2affd0c357_svpimg.png', 'svpro2', 'technician', '2024-08-19 02:37:49', '$2y$10$/UX/XOhDh5a6Tzgl8pCXRe9Z4nXQ0NN2aKyt61M9W3VseSY2iB5j6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toolstatus`
--
ALTER TABLE `toolstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toolstatus_materials`
--
ALTER TABLE `toolstatus_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toolstatus_id` (`toolstatus_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `toolstatus_tools`
--
ALTER TABLE `toolstatus_tools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toolstatus_id` (`toolstatus_id`),
  ADD KEY `tool_id` (`tool_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `toolstatus`
--
ALTER TABLE `toolstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `toolstatus_materials`
--
ALTER TABLE `toolstatus_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `toolstatus_tools`
--
ALTER TABLE `toolstatus_tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `toolstatus_materials`
--
ALTER TABLE `toolstatus_materials`
  ADD CONSTRAINT `toolstatus_materials_ibfk_1` FOREIGN KEY (`toolstatus_id`) REFERENCES `toolstatus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `toolstatus_materials_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `toolstatus_tools`
--
ALTER TABLE `toolstatus_tools`
  ADD CONSTRAINT `toolstatus_tools_ibfk_1` FOREIGN KEY (`toolstatus_id`) REFERENCES `toolstatus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `toolstatus_tools_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `tools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
