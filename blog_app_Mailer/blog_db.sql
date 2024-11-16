-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2023 at 07:34 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_content` text NOT NULL,
  `article_img` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `user_id`, `article_title`, `article_content`, `article_img`, `date_created`, `date_modified`) VALUES
(5, 3, 'lorem Ipsum', 'New author', '1689117188article02.jpg', '2023-07-11 23:13:08', '2023-07-11 23:13:08'),
(6, 2, 'Just thinking about it', 'I did it!', '1689117819article04.jpg', '2023-07-11 23:23:39', '2023-07-11 23:23:39'),
(7, 6, 'Keep our books and journals covering', 'Keep up to date with health and medical developments to stimulate research and improve patient care. Search our books and journals covering education, reference information, decision support and more.', '1689238719article07.jpg', '2023-07-13 08:56:19', '2023-07-13 08:58:39'),
(9, 3, 'Russia-Ukraine War', 'Elsevier has partnered with leading science organizations and Economist Impact for a global collaboration to understand the impact of the pandemic on confidence in research &mdash; and to identify are', '1689239851article06.jpg', '2023-07-13 09:17:31', '2023-07-13 09:17:31'),
(10, 9, 'lorem Ipsum', 'Explore scientific, technical, and medical research on ScienceDirect', '1689242547article05.jpg', '2023-07-13 10:02:27', '2023-07-13 10:02:27'),
(11, 2, 'lorem Ipsum', 'We are presenting on wb', '1689244996article05.jpg', '2023-07-13 10:39:41', '2023-07-13 10:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `Fname`, `Lname`, `username`, `email`, `password`, `role`, `date_created`) VALUES
(1, 'Mike', 'Kituku', 'Mike', 'mike@gmail.com', 'b4b147bc522828731f1a016bfa72c073', 'user', '2023-07-13 06:14:10'),
(2, 'Ian', 'Njihia', 'Njihia', 'njihia@yahoo.com', 'a925edfbabf68a58134920a0d305c067', 'author', '2023-07-13 06:15:57'),
(3, 'Victor', 'Kiptoo', 'Victor', 'vkiptoo@gmail.com', '182be0c5cdcd5072bb1864cdee4d3d6e', 'author', '2023-07-13 06:17:20'),
(6, 'Lynn', 'Githinji', 'Lynn', 'lynn@gmail.com', '4a7d1ed414474e4033ac29ccb8653d9b', 'author', '2023-07-13 08:51:08'),
(8, 'Paul', 'Boss', 'PB8', 'pb@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', '2023-07-13 09:49:28'),
(9, 'Job', 'Paka', 'JPaka', 'jp@gmail.com', '934b535800b1cba8f96a5d72f72f1611', 'author', '2023-07-13 09:53:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
