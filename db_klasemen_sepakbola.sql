-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2022 at 02:14 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_klasemen_sepakbola`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_klasemen`
--

CREATE TABLE `data_klasemen` (
  `id` int(11) NOT NULL,
  `nama_team` varchar(255) NOT NULL,
  `logo_team` text NOT NULL,
  `main` int(11) NOT NULL,
  `menang` int(11) NOT NULL,
  `seri` int(11) NOT NULL,
  `kalah` int(11) NOT NULL,
  `goal` int(11) NOT NULL,
  `kebobolan` int(11) NOT NULL,
  `performa` varchar(20) DEFAULT NULL COMMENT '1 = menang, 2 = seri, 3 = kalah',
  `score` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_klasemen`
--

INSERT INTO `data_klasemen` (`id`, `nama_team`, `logo_team`, `main`, `menang`, `seri`, `kalah`, `goal`, `kebobolan`, `performa`, `score`) VALUES
(3, 'toroo', '62c1c801d7735.jpeg', 1, 1, 0, 0, 5, 1, '1', '5-1'),
(8, 'ashyou', '62c1c7b28e5b3.jpeg', 3, 2, 1, 1, 12, 10, '1,3,2,1', '5-3|2-4|1-1|4-2');

-- --------------------------------------------------------

--
-- Table structure for table `data_users`
--

CREATE TABLE `data_users` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(255) NOT NULL,
  `nama_belakang` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_users`
--

INSERT INTO `data_users` (`id`, `nama_depan`, `nama_belakang`, `username`, `email`, `password`) VALUES
(5, 'riska', 'zata', 'tata', 'tata@gmail.com', '$2y$10$Tvro5VuXr/9RPwMt7.xBJeGOT.iZtwMc2BUR3kiBA9czcDaYBE7/W');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_klasemen`
--
ALTER TABLE `data_klasemen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_users`
--
ALTER TABLE `data_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_klasemen`
--
ALTER TABLE `data_klasemen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_users`
--
ALTER TABLE `data_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
