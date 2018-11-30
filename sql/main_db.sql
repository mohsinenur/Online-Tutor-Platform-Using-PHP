-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2018 at 01:39 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `email`, `password`) VALUES
(1, 'Aminul', 'admin@tutor.com', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `applied_post`
--

CREATE TABLE `applied_post` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post_by` int(11) NOT NULL,
  `applied_by` int(11) NOT NULL,
  `applied_to` int(11) NOT NULL,
  `applied_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `student_ck` varchar(3) NOT NULL DEFAULT 'no',
  `tutor_ck` varchar(3) NOT NULL DEFAULT 'no',
  `tutor_cf` tinyint(4) NOT NULL DEFAULT '0',
  `tution_cf` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `applied_post`
--

INSERT INTO `applied_post` (`id`, `post_id`, `post_by`, `applied_by`, `applied_to`, `applied_time`, `student_ck`, `tutor_ck`, `tutor_cf`, `tution_cf`) VALUES
(8, 0, 0, 1, 2, '2018-01-09 17:23:26', 'yes', 'yes', 0, 0),
(9, 2, 1, 2, 0, '2018-01-09 17:26:05', 'yes', 'yes', 0, 1),
(10, 0, 0, 1, 5, '2018-01-11 05:17:50', 'yes', 'yes', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `postby_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `class` text NOT NULL,
  `medium` varchar(20) NOT NULL,
  `salary` varchar(50) NOT NULL,
  `location` text NOT NULL,
  `p_university` text NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deadline` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `postby_id`, `subject`, `class`, `medium`, `salary`, `location`, `p_university`, `post_time`, `deadline`) VALUES
(2, 1, 'ICT,Computer Science', 'College/University', 'English', 'None', 'Khilkhet,Banani,Uttara, BD', 'Southeast University', '2018-01-09 11:11:44', '01/17/2018'),
(3, 1, 'English,Religion,ICT,Physics,Higher Math,Statistics', 'Eleven-Twelve,College/University', 'Bangla', '10000-15000', 'Banani,Dhaka,Bangladesh', 'Southeast University', '2018-01-09 17:36:07', '01/07/2018'),
(4, 1, 'Bangla,ICT,Computer Science', 'Six-Seven,Eleven-Twelve', 'Bangla', '2000-5000', 'banani', 'Southeast University', '2018-01-10 04:28:42', '01/17/2018'),
(5, 1, 'Bangla', 'One-Three', 'Bangla', '1000-2000', 'nikunjo', 'Southeast University', '2018-01-11 05:17:25', '01/19/2018'),
(6, 1, 'Bangla', 'One-Three', 'Bangla', 'None', 'Khilkhet,Banani,Uttara, BD', 'None', '2018-01-10 05:24:41', '02/14/2018'),
(7, 1, 'Bangla', 'One-Three', 'Bangla', '10000-15000', 'khilkhet', 'Southeast University', '2018-06-28 10:23:31', '06/30/2018');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `nidpic` text NOT NULL,
  `inst_name` varchar(150) NOT NULL,
  `prefer_sub` text NOT NULL,
  `class` text NOT NULL,
  `medium` text NOT NULL,
  `prefer_location` text NOT NULL,
  `salary` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`id`, `t_id`, `nidpic`, `inst_name`, `prefer_sub`, `class`, `medium`, `prefer_location`, `salary`) VALUES
(5, 2, '', 'Southeast University', 'Bangla,Math,ICT,Computer Science', 'One-Three,Nine-Ten,Eleven-Twelve,College/University', 'Bangla,Any', 'Khilkhet', '1000-2000'),
(9, 5, '', 'Southeast University', 'Bangla,Math,General Science,Religion,ICT,Physics,Higher Math,Computer Science', 'Nine-Ten,Eleven-Twelve,College/University', 'Bangla', 'Farmgate', '1000-2000'),
(11, 6, '', 'Southeast University', 'Bangla,English,Religion,ICT,Physics,Sociology,Economics,Civics,Computer Science', 'Six-Seven,Nine-Ten,Eleven-Twelve', 'Bangla', 'banani,gulsan', '2000-5000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(200) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `confirmcode` varchar(7) NOT NULL,
  `activation` varchar(3) NOT NULL,
  `type` varchar(10) NOT NULL,
  `user_pic` text NOT NULL,
  `last_logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `online` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `gender`, `email`, `phone`, `address`, `pass`, `confirmcode`, `activation`, `type`, `user_pic`, `last_logout`, `online`) VALUES
(1, 'Student', 'male', 'student@gmail.com', '017729306712', 'Khilkhet, Dhaka, Bangladesh', '202cb962ac59075b964b07152d234b70', '356789', '', 'student', '1515505493.jpg', '2018-06-30 12:22:09', 'yes'),
(2, 'Teacher', 'male', 'teacher@gmail.com', '01729306712', 'Banani, Dhaka, Bangladesh', '202cb962ac59075b964b07152d234b70', '901358', '', 'teacher', '1515505450.jpg', '2018-06-30 12:21:59', 'no'),
(5, 'Teacher_1', 'female', 'teacher_1@gmail.com', '01729306712', '1,2 pacific home,Farmgate', '86e7b703317121aee6c1543d0f5aad72', '495196', '', 'teacher', '', '2018-01-11 05:18:42', 'no'),
(6, 'Teacher_2', 'male', 'teacher_2@gmail.com', '01729306712', 'Badda', '3e415aa796501ed473326101bb8dc5f1', '292470', '', 'teacher', '1515558340.jpeg', '2018-01-10 04:27:32', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applied_post`
--
ALTER TABLE `applied_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applied_post`
--
ALTER TABLE `applied_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tutor`
--
ALTER TABLE `tutor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
