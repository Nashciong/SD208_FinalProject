-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2022 at 05:27 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskism`
--

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `Students_ID` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `confirmpassword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`Students_ID`, `firstname`, `lastname`, `birthday`, `phone`, `email`, `password`, `confirmpassword`) VALUES
(1, 'star', 'oculares', 'july 30,2020', '231231232', 'tarla@gmail.com', 'hahaha', 'hahaha'),
(4, 'star', 'sdds', 'hannah cagaanan', '09635294204', 'hannah cagaanan', '7f88bb68e14d386d89af3cf317f6f7af1d39246c', '7f88bb68e14d386d89af3cf317f6f7af1d39246c'),
(5, 'star', 'cagaana', 'hannah cagaanan', '09635294204', 'hannah cagaanan', 'c455582f41f589213a7d34ccb3954c67476077da', 'c455582f41f589213a7d34ccb3954c67476077da'),
(6, 'star', 'cagaana', 'hannah cagaanan', '09635294204', 'hannah cagaanan', 'c455582f41f589213a7d34ccb3954c67476077da', 'c455582f41f589213a7d34ccb3954c67476077da'),
(7, 'kayden', 'herrr', 'kaygengwapo', '12898', 'kaygengwapo', '7e240de74fb1ed08fa08d38063f6a6a91462a815', '7e240de74fb1ed08fa08d38063f6a6a91462a815'),
(8, 'star', 'cagaana', 'hannah cagaanan', '09635294204', 'hannah cagaanan', 'c455582f41f589213a7d34ccb3954c67476077da', 'c455582f41f589213a7d34ccb3954c67476077da'),
(9, 'star', 'cagaana', 'hannah cagaanan', '09635294204', 'hannah cagaanan', 'nnn', 'nnn'),
(10, 'star', 'cagaana', 'hannah cagaanan', '09635294204', 'hannah cagaanan', 'nnn', 'nnn'),
(11, 'aa', 'aa', 'aaaa', '1111', 'aaaa', 'ss', 'ss'),
(12, 'aa', 'aa', 'aaaa', '1111', 'aaaa', 'ss', 'ss');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`Students_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `Students_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
