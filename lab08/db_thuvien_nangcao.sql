-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 03:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_thuvien_nangcao`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL CHECK (`price` > 0),
  `published_year` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0 CHECK (`stock` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `category_id`, `publisher_id`, `price`, `published_year`, `stock`) VALUES
(1, 'Lập trình PHP cơ bản', 1, 1, 150000.00, 2020, 50),
(2, 'MySQL Nâng cao', 1, 1, 200000.00, 2021, 30),
(3, 'Kinh tế vi mô', 2, 2, 120000.00, 2019, 100),
(4, 'Harry Potter 1', 3, 3, 250000.00, 2018, 20),
(5, 'Toeic Preparation', 4, 2, 180000.00, 2022, 60),
(6, 'Đắc nhân tâm', 5, 1, 90000.00, 2015, 200),
(7, 'Cấu trúc dữ liệu và giải thuật', 1, 2, 110000.00, 2020, 15),
(8, 'Marketing căn bản', 2, 1, 130000.00, 2021, 45),
(9, 'Dế mèn phiêu lưu ký', 3, 3, 50000.00, 2010, 80),
(10, 'IELTS Reading', 4, 1, 160000.00, 2023, 25),
(11, 'Nhà giả kim', 5, 3, 85000.00, 2017, 120),
(12, 'Mạng máy tính', 1, 2, 140000.00, 2019, 40),
(13, 'Quản trị học', 2, 2, 125000.00, 2020, 55),
(14, 'Số đỏ', 3, 1, 70000.00, 2000, 30),
(15, 'Sách chưa ai mượn', 1, 3, 300000.00, 2024, 10);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Công nghệ thông tin'),
(2, 'Kinh tế'),
(5, 'Kỹ năng sống'),
(4, 'Ngoại ngữ'),
(3, 'Văn học');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('BORROWED','RETURNED','OVERDUE') DEFAULT 'BORROWED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loan_id`, `member_id`, `loan_date`, `due_date`, `status`) VALUES
(1, 1, '2023-10-01', '2023-10-15', 'RETURNED'),
(2, 1, '2023-11-01', '2023-11-15', 'RETURNED'),
(3, 2, '2023-10-05', '2023-10-20', 'BORROWED'),
(4, 3, '2026-01-11', '2026-01-26', 'BORROWED'),
(5, 3, '2026-01-14', '2026-01-28', 'BORROWED'),
(6, 3, '2026-01-15', '2026-01-30', 'BORROWED'),
(7, 4, '2023-09-01', '2023-09-15', 'OVERDUE'),
(8, 5, '2023-10-20', '2023-11-04', 'RETURNED'),
(9, 6, '2023-11-10', '2023-11-25', 'BORROWED'),
(10, 7, '2023-08-01', '2023-08-15', 'OVERDUE'),
(11, 1, '2026-01-06', '2026-01-21', 'BORROWED'),
(12, 2, '2023-11-05', '2023-11-20', 'RETURNED');

-- --------------------------------------------------------

--
-- Table structure for table `loan_items`
--

CREATE TABLE `loan_items` (
  `loan_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL CHECK (`qty` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_items`
--

INSERT INTO `loan_items` (`loan_id`, `book_id`, `qty`) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 3, 1),
(2, 5, 1),
(3, 2, 1),
(3, 4, 1),
(4, 1, 1),
(4, 3, 1),
(4, 6, 2),
(5, 4, 1),
(5, 7, 1),
(6, 5, 1),
(6, 8, 1),
(6, 9, 1),
(7, 2, 3),
(7, 10, 1),
(8, 11, 1),
(9, 12, 1),
(9, 13, 2),
(10, 5, 1),
(10, 14, 1),
(11, 1, 1),
(11, 3, 1),
(12, 6, 1),
(12, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `full_name`, `phone`, `created_at`) VALUES
(1, 'Nguyễn Văn A', '0901234567', '2023-01-10 00:00:00'),
(2, 'Trần Thị B', '0901234568', '2023-02-15 00:00:00'),
(3, 'Lê Văn C', '0901234569', '2023-03-20 00:00:00'),
(4, 'Phạm Thị D', '0901234570', '2023-04-05 00:00:00'),
(5, 'Hoàng Văn E', '0901234571', '2023-05-12 00:00:00'),
(6, 'Đỗ Thị F', '0901234572', '2023-06-18 00:00:00'),
(7, 'Vũ Văn G', '0901234573', '2023-07-25 00:00:00'),
(8, 'Ngô Thị H', '0901234574', '2023-08-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `publisher_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`publisher_id`, `name`) VALUES
(2, 'NXB Giáo Dục'),
(3, 'NXB Kim Đồng'),
(1, 'NXB Trẻ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`loan_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`publisher_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`publisher_id`) ON DELETE SET NULL;

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD CONSTRAINT `loan_items_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`loan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loan_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
