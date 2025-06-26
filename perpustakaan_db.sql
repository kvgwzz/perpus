-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 26, 2025 at 12:42 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int NOT NULL,
  `book_title` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `author` varchar(50) NOT NULL,
  `book_copies` int NOT NULL,
  `publisher_name` varchar(100) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `copyright_year` int NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `book_title`, `category`, `author`, `book_copies`, `publisher_name`, `isbn`, `copyright_year`, `status`) VALUES
(1, 'Database dan ERD', 'Teknologi', 'Fajar Agung', 4, 'Unpam Press', '1232123432123', 2021, '1'),
(2, 'Matematika Diskrit', 'Pendidikan', 'Saptono', 3, 'Erlangga', '1234243463455', 2021, '1'),
(3, 'Database Relational', 'Teknologi', 'Fajar Agung', 4, 'Unpam Press', '1232123432123', 2022, '1'),
(4, 'Logika Matematika', 'Pendidikan', 'Saptono', 2, 'Erlangga', '1234243463455', 2021, '1'),
(5, 'Database Fundamental', 'Teknologi', 'Fajar Agung', 4, 'Unpam Press', '1232123456454', 2024, '1'),
(6, 'Database Intermediate', 'Teknologi', 'Fajar Agung', 4, 'Unpam Press', '1232178978895', 2021, '1'),
(7, 'Database', 'Teknologi', 'Fajar Agung', 4, 'Unpam Press', '1232123424244', 2000, '1'),
(8, 'Pengantar teknologi', 'Pendidikan', 'Saptono', 2, 'Erlangga', '1234243789634', 2011, '1'),
(9, 'Data Mining', 'Teknologi', 'Fajar Agung', 4, 'Unpam Press', '1232123434533', 2011, '1');

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `borrow_id` int NOT NULL,
  `member_id` int NOT NULL,
  `date_borrow` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `status` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `member_id`, `date_borrow`, `due_date`, `status`) VALUES
(1, 4, '2025-06-20', '2025-06-27', 1),
(2, 5, '2025-06-20', '2025-06-27', 1),
(3, 6, '2025-06-20', '2025-06-27', 1),
(4, 6, '2025-06-20', '2025-06-27', 1),
(5, 4, '2025-06-20', '2025-06-27', 0),
(6, 7, '2025-06-26', '2025-06-26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowdetails`
--

CREATE TABLE `borrowdetails` (
  `borrow_details_id` int NOT NULL,
  `book_id` int NOT NULL,
  `borrow_id` int NOT NULL,
  `borrow_status` int DEFAULT '1',
  `date_return` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrowdetails`
--

INSERT INTO `borrowdetails` (`borrow_details_id`, `book_id`, `borrow_id`, `borrow_status`, `date_return`) VALUES
(1, 5, 1, 1, '2025-06-20'),
(2, 6, 1, 1, '2025-06-20'),
(3, 3, 1, 1, '2025-06-20'),
(4, 7, 2, 1, '2025-06-20'),
(5, 5, 2, 1, '2025-06-20'),
(6, 3, 2, 1, '2025-06-20'),
(7, 4, 2, 1, '2025-06-20'),
(8, 8, 2, 1, '2025-06-20'),
(9, 5, 3, 1, '2025-06-20'),
(10, 6, 3, 1, '2025-06-20'),
(11, 2, 3, 1, '2025-06-20'),
(12, 1, 4, 1, '2025-06-20'),
(13, 3, 4, 1, '2025-06-20'),
(14, 9, 5, 0, NULL),
(15, 7, 5, 0, NULL),
(16, 2, 6, 2, '2025-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `firstname`, `lastname`, `username`, `email`, `password`, `gender`, `address`, `contact`, `type`, `status`) VALUES
(4, 'Fajar', 'A', NULL, 'fajar@gmail.com', NULL, 'L', 'depok', '09821392', 'Guru', 1),
(5, 'Sarah', 'Azhari', NULL, 'sarah@gmail.co', NULL, 'P', 'depok', '09821392', 'Siswa', 1),
(6, 'Valentino', 'Ronald', NULL, 'Ronald@gmail.com', NULL, 'L', 'Depok', '09821392', 'Siswa', 1),
(7, 'tester', 'akun', 'tester', 'tester1@mail.com', '$2y$10$mHHviyyui1X7Ti4pwOe8XOj3RMwMKjwad8WShEBJyRtxMWcO0t1Lq', 'L', 'jakarta', '0800', 'siswa', 1),
(12, 'Darma', 'Wijaya', 'darmawijaya', 'darma@mail.com', '$2y$10$NUMa3kAEHYvS/7WcOMY.9OPccLOcnKQkYLKvfnGGsPqnBCjowEAem', 'L', 'Indonesia', '08000', 'siswa', 1),
(13, 'Jibril', 'Al-Kahfi', 'jibril', 'jibril@mail.com', '$2y$10$4eCaiX17O5TmnRTvdZB2/.gUMrk7etMCTDo6TmWIq0hGPbIlzF4Gu', 'L', 'Jalan Siliwangi, Pamulang', '0800000', 'Siswa', 1),
(14, 'Mark', 'Feng', 'mark', 'mark@mail.cz', '$2y$10$PuF3xPwtx46PSLk4PEcYk.LC7q7PvH1L0RqMKc0VMeUOhM5SK4g66', 'L', 'Jalan Swadaya', '09000', 'siswa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin', '$2y$10$LF.OSu192DukatY/Fm755ek2YZaoOiTn/b9E5iODMG4OAx5ZRSGoy', 'super', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`) USING BTREE;

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`borrow_id`) USING BTREE,
  ADD KEY `fk123` (`member_id`) USING BTREE;

--
-- Indexes for table `borrowdetails`
--
ALTER TABLE `borrowdetails`
  ADD PRIMARY KEY (`borrow_details_id`) USING BTREE,
  ADD KEY `book_id` (`book_id`) USING BTREE,
  ADD KEY `borrow_id` (`borrow_id`) USING BTREE;

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `borrow_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `borrowdetails`
--
ALTER TABLE `borrowdetails`
  MODIFY `borrow_details_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `fk123` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `borrowdetails`
--
ALTER TABLE `borrowdetails`
  ADD CONSTRAINT `borrowdetails_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`),
  ADD CONSTRAINT `borrowdetails_ibfk_2` FOREIGN KEY (`borrow_id`) REFERENCES `borrow` (`borrow_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
