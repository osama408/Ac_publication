-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2024 at 05:01 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `publish_an_essay`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int NOT NULL,
  `about` text NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `about`, `phone_number`, `email`, `address`) VALUES
(3, '<p><strong>&nbsp;I have to say something about myself. Sometimes it is hard to introduce yourself because you know yourself so well that you do not know where to start with. Let me give a try to see what kind of image you have about me through my self-description.</strong></p>', '', '', ''),
(5, '<p><strong>Boldly claiming a space where people with disabilities tell the stories of their own lives&mdash;not other&rsquo;s stories about them</strong></p>\\r\\n<p><strong><em>About Us</em>&nbsp;captures the voices of a community that has for too long been stereotyped and misrepresented. Speaking </strong></p>\\r\\n<p><strong>not only to people with disabilities and their support networks, but to all of us, the authors in <em>About Us</em> </strong></p>\\r\\n<p><strong>offer intimate stories of how they navigate a world not built for them. Echoing the refrain of the disability rights movement,&nbsp;</strong></p>', '842271881', 'omar@gmail.com', 'pattani'),
(6, '<p><strong>Boldly claiming a space where people with disabilities tell the stories of their own lives&mdash;not other&rsquo;s stories about them</strong></p>\\r\\n<p><strong><em>About Us</em>&nbsp;captures the voices of a community that has for too long been stereotyped and misrepresented. Speaking </strong></p>\\r\\n<p><strong>not only to people with disabilities and their support networks, but to all of us, the authors in <em>About Us</em> </strong></p>\\r\\n<p><strong>offer intimate stories of how they navigate a world not built for them. Echoing the refrain of the disability rights movement,&nbsp;</strong></p>', '842271881', 'omar@gmail.com', 'pattani');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `username`, `role`, `password`) VALUES
(1, 'osamagomaa', 'admin', ''),
(2, 'omar', 'admin', ''),
(3, 'unkonwman', 'admin', ''),
(4, 'publisher', 'admin', ''),
(5, 'newpublisher', 'admin', ''),
(6, 'newpublishers', 'admin', '$2y$10$cgkA.HwQSx7Vu75.bjpFIOWhVGbsU1kIRg/cPBkV9UlBKPMy59f96');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `author_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `cat_name`) VALUES
(6, 'Research Paper'),
(7, 'Essays'),
(8, 'Reports'),
(10, 'Politics Report');

-- --------------------------------------------------------

--
-- Table structure for table `essays`
--

CREATE TABLE `essays` (
  `essay_id` int NOT NULL,
  `author_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `author_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `file_name` text NOT NULL,
  `essay_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `essays`
--

INSERT INTO `essays` (`essay_id`, `author_name`, `title`, `content`, `category`, `author_id`, `created_at`, `file_name`, `essay_status`) VALUES
(59, 'Omar Gomaa', 'example', '<p>essay, an analytic, interpretative, or critical literary composition usually much shorter and less systematic and formal than a dissertation or thesis and usually dealing with its subject from a limited and often personal point of view</p>\r\n<p><strong>essay, an analytic, interpretative, or critical literary composition usually much shorter and less systematic and formal than a dissertation or thesis and usually dealing with its subject from a limited and often personal point of view</strong></p>\r\n<p><em><strong>essay, an analytic, interpretative, or critical literary composition usually much shorter and less systematic and formal than a dissertation or thesis and usually dealing with its subject from a limited and often personal point of view</strong></em></p>\r\n<p>&nbsp;</p>', 'Essays', 1, '2024-12-11 00:00:00', 'curling .pdf', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `profile_information`
--

CREATE TABLE `profile_information` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `profile_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `profile_information`
--

INSERT INTO `profile_information` (`id`, `username`, `major`, `facebook`, `twitter`, `linkedin`, `profile_image`) VALUES
(1, 'Omar Gomaa ', 'Political Researcher', 'https://www.facebook.com/', 'https://www.x.com/', 'https://www.linkedin.com/', '../../assets/profile_images/Screenshot (206).png'),
(2, 'administratorsss', 'Political Researcher sss', 'https://www.facebook.com/', 'https://www.xaads.com/d', 'http://www.linkedin.com/', 'download.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `essays`
--
ALTER TABLE `essays`
  ADD PRIMARY KEY (`essay_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `profile_information`
--
ALTER TABLE `profile_information`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `essays`
--
ALTER TABLE `essays`
  MODIFY `essay_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `profile_information`
--
ALTER TABLE `profile_information`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);

--
-- Constraints for table `essays`
--
ALTER TABLE `essays`
  ADD CONSTRAINT `essays_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
