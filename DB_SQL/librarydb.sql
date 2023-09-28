-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2023 at 02:15 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `user_id` int(11) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `type` varchar(45) NOT NULL DEFAULT 'STUDENT',
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`user_id`, `username`, `password`, `type`, `status`) VALUES
(190000, '190000', '123', 'ADMIN', 0),
(190001, '190002', '123', 'STUDENT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_collection`
--

CREATE TABLE `book_collection` (
  `ISBN` varchar(45) NOT NULL,
  `title` varchar(45) DEFAULT NULL,
  `author` varchar(45) DEFAULT NULL,
  `abstract` varchar(45) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `book_price` int(11) DEFAULT NULL,
  `year_published` year(4) DEFAULT NULL,
  `publisher` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_collection`
--

INSERT INTO `book_collection` (`ISBN`, `title`, `author`, `abstract`, `category`, `book_price`, `year_published`, `publisher`) VALUES
('0-0231424-7-2', '8086/8088, 80286, 80386, And 80486 Assembly L', 'Brey, Barry B.', '41', 'Autobiography', 300123, 1993, 'GLENCOE'),
('0-0240774-1-0', 'A Brief Course in Qbasic With an Introduction', 'Schneider, David I.', '34.8', 'Biography', 250, 1994, 'MERRILL'),
('0-0240800-1-2', 'A Beginner', 'Ramos, Emilio', '23', 'Biography', 220, 1993, 'MACMILLAN'),
('0-0280074-8-4', '101 Database Exercises', 'Cashman, Thomas J.', '11.16', 'Art/architecture', 220, 1992, 'DRYDEN'),
('0-0301301-8-2', 'A Beginner', 'Parker, Charles S.', '6.65', 'History', 300, 1987, 'HOLT RINEHART & WINSTON'),
('0-0307445-1-2', 'A Beginner', 'Martin, Sherry J.', '9.26', 'Business/economics', 250, 1991, 'DELLEN'),
('0-0700024-8-7', 'A Programmer haha', 'Brainerd, Walter S.', '37.9561', 'Bibliography', 123333, 1990, 'MCGRAW HILL TEXT'),
('0-0706461-5-5', 'A Practical Guide to Logical (Mobile legends)', 'Bertino, Elisa', '45', 'Business/economics', 120, 1993, 'MCGRAW HILL TEXT'),
('0-0770762-5-7', 'A Practical Course in Functional Programming ', 'Coombs, Jason', '25.01', 'History', 220, 1995, 'McGraw-Hill'),
('0-0770791-3-2', 'A First Course in Computer Programming Using ', 'Vickers, Paul', '25.01', 'Business/economics', 250, 1995, 'MCGRAW HILL TEXT'),
('0-0783104-8-2', 'A Computerized Audit Practice Case (Micro, In', 'Porter, Hayden', '24.15', 'Biography', 220, 1986, 'MCGRAW HILL');

-- --------------------------------------------------------

--
-- Table structure for table `book_image`
--

CREATE TABLE `book_image` (
  `ISBN` varchar(45) NOT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_image`
--

INSERT INTO `book_image` (`ISBN`, `status`) VALUES
('', 1),
('0-0231424-7-2', 0),
('0-0240774-1-0', 0),
('0-0240800-1-2', 0),
('0-0280074-8-4', 0),
('0-0301301-8-2', 0),
('0-0307445-1-2', 0),
('0-0700024-8-7', 0),
('0-0706461-5-5', 0),
('0-0770762-5-7', 0),
('0-0770791-3-2', 0),
('0-0783104-8-2', 0),
('123123123124333', 1),
('12312314314', 1),
('12344213541341324', 0),
('190347', 0),
('22220000222', 1),
('90284', 1),
('902841233', 1),
('902841233default', 1),
('902841233defaultasddd', 0),
('90284aawews', 1),
('90284asasd', 1),
('90284asd', 1),
('90284safdaf', 1),
('asdasdfsadf2131', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowtran`
--

CREATE TABLE `borrowtran` (
  `TransactionNo` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `IsBookReturned` int(11) NOT NULL DEFAULT 1,
  `Notes` varchar(45) DEFAULT NULL,
  `DateBorrowed` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowtran`
--

INSERT INTO `borrowtran` (`TransactionNo`, `user_id`, `ISBN`, `IsBookReturned`, `Notes`, `DateBorrowed`, `due_date`) VALUES
(62, 190001, '0-0231424-7-2', 1, NULL, '2023-09-27 13:40:28', '2023-09-28 13:40:28'),
(63, 190001, '0-0231424-7-2', 1, NULL, '2023-09-27 13:40:28', '2023-09-28 13:40:28');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `book_title` varchar(45) DEFAULT NULL,
  `reserve_date` datetime(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `ISBN`, `book_title`, `reserve_date`) VALUES
(52, 1, '0-0240774-1-0', 'A Brief Course in Qbasic With an Introduction', NULL),
(53, 1, '0-0231424-7-2', '8086/8088, 80286, 80386, And 80486 Assembly L', NULL),
(54, 1, '0-0301301-8-2', 'A Beginner', NULL),
(58, 190001, '0-0240774-1-0', 'A Brief Course in Qbasic With an Introduction', NULL),
(130, 190000, '0-0231424-7-2', '8086/8088, 80286, 80386, And 80486 Assembly L', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `user_id` int(11) NOT NULL,
  `DateJoined` varchar(45) DEFAULT NULL,
  `Validity` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`user_id`, `DateJoined`, `Validity`) VALUES
(1, '2021-10-06 10:23:45', NULL),
(190001, '2023-09-02 16:26:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profile_images`
--

CREATE TABLE `profile_images` (
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_images`
--

INSERT INTO `profile_images` (`user_id`, `status`) VALUES
(190000, 1),
(190001, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reserve_record`
--

CREATE TABLE `reserve_record` (
  `reserve_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `date_reserve` datetime DEFAULT NULL,
  `reserve_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returntran`
--

CREATE TABLE `returntran` (
  `user_id` int(11) DEFAULT NULL,
  `TransactionNo` int(11) NOT NULL,
  `DateReturned` datetime DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `BTransactionNo` int(11) DEFAULT NULL,
  `Overdue` int(11) DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `paidpenalties` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `returntran`
--

INSERT INTO `returntran` (`user_id`, `TransactionNo`, `DateReturned`, `ISBN`, `BTransactionNo`, `Overdue`, `Status`, `paidpenalties`) VALUES
(190001, 62, NULL, '0-0231424-7-2', 62, 0, 'UNRETURNED', 0),
(190001, 63, NULL, '0-0231424-7-2', 63, 0, 'UNRETURNED', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settledtrans`
--

CREATE TABLE `settledtrans` (
  `user_id` int(11) DEFAULT NULL,
  `TransactionNo` int(11) NOT NULL DEFAULT 0,
  `DateReturned` datetime DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `BTransactionNo` int(11) DEFAULT NULL,
  `Overdue` int(11) DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `paidpenalties` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settledtrans`
--

INSERT INTO `settledtrans` (`user_id`, `TransactionNo`, `DateReturned`, `ISBN`, `BTransactionNo`, `Overdue`, `Status`, `paidpenalties`) VALUES
(190001, 47, '2023-09-18 21:28:21', '0-0231424-7-2', 47, 1, 'OK', 1),
(190001, 48, '2023-09-20 09:18:59', '0-0280074-8-4', 48, 0, 'OK', 0),
(190001, 49, '2023-09-20 09:22:46', '0-0231424-7-2', 49, 0, 'OK', 0),
(190001, 50, '2023-09-20 09:33:25', '0-0231424-7-2', 50, 0, 'OK', 0),
(190001, 51, '2023-09-20 09:37:17', '0-0231424-7-2', 51, 0, 'OK', 0),
(190001, 52, '2023-09-20 09:38:01', '0-0231424-7-2', 52, 0, 'OK', 0),
(190001, 54, '2023-09-20 10:00:39', '0-0240774-1-0', 54, 0, 'OK', 0),
(190001, 55, '2023-09-20 10:00:39', '0-0231424-7-2', 55, 0, 'OK', 0),
(190001, 57, '2023-09-20 10:10:00', '0-0231424-7-2', 57, 0, 'OK', 0),
(190001, 53, '2023-09-20 10:30:28', '0-0231424-7-2', 53, 0, 'OK', 0),
(190001, 56, '2023-09-20 10:30:28', '0-0231424-7-2', 56, 0, 'OK', 0),
(190001, 58, '2023-09-20 10:30:28', '0-0231424-7-2', 58, 0, 'OK', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `ISBN` varchar(45) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `available` int(11) NOT NULL DEFAULT 0,
  `no_borrowed_books` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`ISBN`, `quantity`, `available`, `no_borrowed_books`) VALUES
('0-0231424-7-2', 20, 16, 4),
('0-0240774-1-0', 20, 19, 1),
('0-0240800-1-2', 30, 27, 3),
('0-0280074-8-4', 30, 30, 0),
('0-0301301-8-2', 20, 20, 0),
('0-0307445-1-2', 1, 1, 0),
('0-0700024-8-7', 30, 30, 0),
('0-0706461-5-5', 10, 10, 0),
('0-0770762-5-7', 30, 30, 0),
('0-0770791-3-2', 20, 20, 0),
('0-0783104-8-2', 30, 30, 0),
('123123123335655', 23, 23, 0),
('1234421321344', 23, 23, 0),
('1235442223', 4, 4, 0),
('90284123', 23, 23, 0),
('90284ad23', 23, 23, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `user_id` int(11) DEFAULT NULL,
  `TransactionNo` int(11) NOT NULL,
  `transactionDate` datetime DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `BTransactionNo` int(11) DEFAULT NULL,
  `TransactionType` varchar(45) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `admin_fullname` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`user_id`, `TransactionNo`, `transactionDate`, `ISBN`, `BTransactionNo`, `TransactionType`, `admin_id`, `status`, `admin_fullname`) VALUES
(190001, 1, '2023-09-18 21:28:21', '0-0231424-7-2', 47, 'Return Only', 190000, 'RETURN ONLY', 'admin 01'),
(190001, 2, '2023-09-18 21:29:13', '0-0231424-7-2', 47, 'Pay Only', 190000, 'OK', 'admin 01'),
(190001, 3, '2023-09-20 09:18:59', '0-0280074-8-4', 48, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 4, '2023-09-20 09:22:46', '0-0231424-7-2', 49, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 5, '2023-09-20 09:33:25', '0-0231424-7-2', 50, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 6, '2023-09-20 09:37:17', '0-0231424-7-2', 51, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 7, '2023-09-20 09:38:01', '0-0231424-7-2', 52, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 8, '2023-09-20 09:38:11', '-231433', 46, 'Return and Pay', 190000, 'OK', 'admin 01'),
(190001, 9, '2023-09-20 09:38:25', '-231433', 45, 'Return and Pay', 190000, 'OK', 'admin 01'),
(190001, 10, '2023-09-20 10:00:39', '0-0240774-1-0', 54, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 11, '2023-09-20 10:00:39', '0-0231424-7-2', 55, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 12, '2023-09-20 10:10:00', '0-0231424-7-2', 57, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 13, '2023-09-20 10:30:28', '0-0231424-7-2', 53, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 14, '2023-09-20 10:30:28', '0-0231424-7-2', 56, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 15, '2023-09-20 10:30:28', '0-0231424-7-2', 58, 'Return Only', 190000, 'OK', 'admin 01'),
(190001, 16, '2023-09-26 15:16:02', '-231433', 59, 'Return and Pay', 190000, 'OK', 'admin 01'),
(190001, 17, '2023-09-26 15:16:02', '-231433', 60, 'Return and Pay', 190000, 'OK', 'admin 01'),
(190001, 18, '2023-09-26 15:16:02', '-231433', 61, 'Return and Pay', 190000, 'OK', 'admin 01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `Fname` varchar(45) DEFAULT NULL,
  `Lname` varchar(45) DEFAULT NULL,
  `ResAdrs` varchar(45) DEFAULT NULL,
  `OfcAdrs` varchar(45) DEFAULT NULL,
  `LandlineNo` int(11) DEFAULT NULL,
  `MobileNo` int(11) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Gender` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `Fname`, `Lname`, `ResAdrs`, `OfcAdrs`, `LandlineNo`, `MobileNo`, `Email`, `Gender`) VALUES
(190000, 'admin', '01', '[value-4]', '[value-5]', 0, 0, '[value-8]', '[value-9]'),
(190001, 'ZEUS MIGUEL', 'ORILLA', 'asdfsa', 'adsf', 0, 2147483647, 'zeusorilla007@gmail.com', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `book_collection`
--
ALTER TABLE `book_collection`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `book_image`
--
ALTER TABLE `book_image`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `borrowtran`
--
ALTER TABLE `borrowtran`
  ADD PRIMARY KEY (`TransactionNo`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `profile_images`
--
ALTER TABLE `profile_images`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `reserve_record`
--
ALTER TABLE `reserve_record`
  ADD PRIMARY KEY (`reserve_id`);

--
-- Indexes for table `returntran`
--
ALTER TABLE `returntran`
  ADD PRIMARY KEY (`TransactionNo`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`TransactionNo`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrowtran`
--
ALTER TABLE `borrowtran`
  MODIFY `TransactionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `reserve_record`
--
ALTER TABLE `reserve_record`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `returntran`
--
ALTER TABLE `returntran`
  MODIFY `TransactionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `TransactionNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190002;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
