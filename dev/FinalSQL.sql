-- FinalSQL.sql - Improved Database Structure for Muse Bookstore
-- Created: April 27, 2025
-- Author: GitHub Copilot

-- Drop database if it exists and create a new one with proper character set
DROP DATABASE IF EXISTS muse1;
CREATE DATABASE muse1 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE muse1;

-- Set SQL mode and time zone
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('parent','child','ambassador','admin') NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_address` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_photo` varchar(255) DEFAULT NULL,
  `user_otp` varchar(10) DEFAULT NULL,
  `user_otp_expires` datetime DEFAULT NULL,
  `user_is_verified` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_title` varchar(255) NOT NULL,
  `book_author` varchar(255) NOT NULL,
  `book_genre` varchar(255) NOT NULL,
  `book_condition` enum('new','used') NOT NULL,
  `book_price` decimal(10,2) DEFAULT NULL,
  `listing_type` enum('sell','swap') NOT NULL,
  `owner_id` int(11) NOT NULL,
  `book_status` enum('available','sold','swapped') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `book_publisher` varchar(100) DEFAULT NULL,
  `book_published_year` int(11) DEFAULT NULL,
  `book_ISBN` varchar(100) DEFAULT NULL,
  `book_image` varchar(255) DEFAULT NULL,
  `child_safe` enum('yes','no') DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `fk_book_owner` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `type` enum('sell','swap') NOT NULL,
  `status` enum('pending','approved','declined','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`transaction_id`),
  KEY `book_id` (`book_id`),
  KEY `requester_id` (`requester_id`),
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `fk_transaction_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_transaction_requester` FOREIGN KEY (`requester_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_transaction_owner` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `user_id` (`user_id`),
  KEY `transaction_id` (`transaction_id`),
  CONSTRAINT `fk_payment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_payment_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `requester_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`user_id`),
  KEY `transaction_id` (`transaction_id`),
  CONSTRAINT `fk_notification_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_notification_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `token_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token_count` int(11) DEFAULT 0,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`token_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `book_request`
--

CREATE TABLE `book_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`request_id`),
  KEY `child_id` (`child_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `fk_book_request_child` FOREIGN KEY (`child_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_book_request_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `book_favorites`
--

CREATE TABLE `book_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_book_unique` (`user_id`,`book_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `fk_favorites_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_favorites_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `book_comments`
--

CREATE TABLE `book_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_comments_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_articles_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `communityId` int(100) NOT NULL AUTO_INCREMENT,
  `communityName` varchar(255) NOT NULL,
  `communityDescription` text DEFAULT NULL,
  `communityImage` varchar(255) DEFAULT NULL,
  `membership_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `delete_status` enum('none','requested','approved','rejected') DEFAULT 'none',
  PRIMARY KEY (`communityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `delete_requests`
--

CREATE TABLE `delete_requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `request_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`request_id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `fk_delete_requests_community` FOREIGN KEY (`community_id`) REFERENCES `community` (`communityId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(100) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_place` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL DEFAULT '00:00:00',
  `community_id` int(100) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `fk_event_community` FOREIGN KEY (`community_id`) REFERENCES `community` (`communityId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `writinggroup`
--

CREATE TABLE `writinggroup` (
  `writingGroup_id` int(100) NOT NULL AUTO_INCREMENT,
  `writingGroup_name` varchar(255) NOT NULL,
  `writingGroup_description` text NOT NULL,
  `community_id` int(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`writingGroup_id`),
  KEY `community_id` (`community_id`),
  CONSTRAINT `fk_writinggroup_community` FOREIGN KEY (`community_id`) REFERENCES `community` (`communityId`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `community_member`
--

CREATE TABLE `community_member` (
  `community_member_id` int(100) NOT NULL AUTO_INCREMENT,
  `community_member_name` varchar(255) NOT NULL,
  `community_id` int(100) NOT NULL,
  `event_id` int(100) DEFAULT NULL,
  `user_id` int(100) NOT NULL,
  `writingGroup_id` int(100) DEFAULT NULL,
  PRIMARY KEY (`community_member_id`),
  KEY `community_id` (`community_id`),
  KEY `event_id` (`event_id`),
  KEY `user_id` (`user_id`),
  KEY `writingGroup_id` (`writingGroup_id`),
  CONSTRAINT `fk_community_member_community` FOREIGN KEY (`community_id`) REFERENCES `community` (`communityId`) ON DELETE CASCADE,
  CONSTRAINT `fk_community_member_event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`) ON DELETE SET NULL,
  CONSTRAINT `fk_community_member_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_community_member_writinggroup` FOREIGN KEY (`writingGroup_id`) REFERENCES `writinggroup` (`writingGroup_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_id` int(11) NOT NULL,
  `community_member_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `community_id` (`community_id`),
  KEY `community_member_id` (`community_member_id`),
  CONSTRAINT `fk_posts_community` FOREIGN KEY (`community_id`) REFERENCES `community` (`communityId`) ON DELETE CASCADE,
  CONSTRAINT `fk_posts_community_member` FOREIGN KEY (`community_member_id`) REFERENCES `community_member` (`community_member_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Table structure for table `writing_group_posts`
--

CREATE TABLE `writing_group_posts` (
  `writingGroup_post_id` int(11) NOT NULL AUTO_INCREMENT,
  `writingGroup_id` int(11) DEFAULT NULL,
  `community_member_id` int(11) DEFAULT NULL,
  `chapter_title` varchar(255) DEFAULT NULL,
  `chapter_content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`writingGroup_post_id`),
  KEY `writingGroup_id` (`writingGroup_id`),
  KEY `community_member_id` (`community_member_id`),
  CONSTRAINT `fk_writing_group_posts_writinggroup` FOREIGN KEY (`writingGroup_id`) REFERENCES `writinggroup` (`writingGroup_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_writing_group_posts_community_member` FOREIGN KEY (`community_member_id`) REFERENCES `community_member` (`community_member_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Add foreign key for parent_id in user table
-- This must be added after the user table is created
--

ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_parent` FOREIGN KEY (`parent_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL;

-- --------------------------------------------------------
--
-- Structure for view `v_books`
--

CREATE OR REPLACE VIEW `v_books` AS
SELECT 
  `book`.`book_id` AS `book_id`, 
  `user`.`user_id` AS `book_owner_id`, 
  `user`.`user_name` AS `book_owner_name`, 
  `book`.`book_title` AS `book_title`, 
  `book`.`book_author` AS `book_author`, 
  `book`.`book_genre` AS `book_genre`, 
  `book`.`book_price` AS `book_price`, 
  `book`.`listing_type` AS `listing_type`, 
  `book`.`book_condition` AS `book_condition`, 
  `book`.`book_publisher` AS `book_publisher`, 
  `book`.`book_published_year` AS `book_published_year`, 
  `book`.`book_ISBN` AS `book_ISBN`, 
  `book`.`book_image` AS `book_image` 
FROM (`book` JOIN `user` ON(`book`.`owner_id` = `user`.`user_id`)) 
ORDER BY `book`.`created_at` ASC;

-- --------------------------------------------------------
--
-- Insert comprehensive dummy data
--

-- User data
INSERT INTO `user` (`user_name`, `user_email`, `user_password`, `user_role`, `parent_id`, `user_phone`, `user_address`, `user_photo`, `user_is_verified`) VALUES
-- Admin accounts
('Admin User', 'admin@musebookstore.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'admin', NULL, '0712345678', 'Muse HQ, Nairobi', 'profile_admin.jpg', 1),
('System Admin', 'sysadmin@musebookstore.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'admin', NULL, '0712345679', 'Muse HQ, Nairobi', NULL, 1),

-- Parent accounts
('Sarah Johnson', 'sarah@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'parent', NULL, '0723456789', '123 Karen Road, Nairobi', 'profile_sarah.jpg', 1),
('Michael Ochieng', 'michael@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'parent', NULL, '0734567890', '456 Kileleshwa Ave, Nairobi', 'profile_michael.jpg', 1),
('Jane Wambui', 'jane@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'parent', NULL, '0745678901', '789 Westlands Blvd, Nairobi', NULL, 1),
('David Kamau', 'david@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'parent', NULL, '0756789012', '321 Lavington St, Nairobi', 'profile_david.jpg', 1),
('Lucy Muthoni', 'lucy@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'parent', NULL, '0767890123', '654 Parklands Rd, Nairobi', NULL, 1),

-- Child accounts
('Tim Johnson', 'tim@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'child', 3, NULL, NULL, 'profile_tim.jpg', 1),
('Emma Johnson', 'emma@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'child', 3, NULL, NULL, 'profile_emma.jpg', 1),
('Caleb Ochieng', 'caleb@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'child', 4, NULL, NULL, NULL, 1),
('Grace Wambui', 'grace@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'child', 5, NULL, NULL, 'profile_grace.jpg', 1),
('Daniel Kamau', 'daniel@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'child', 6, NULL, NULL, NULL, 1),
('Faith Muthoni', 'faith@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'child', 7, NULL, NULL, 'profile_faith.jpg', 1),

-- Ambassador accounts
('John Njenga', 'john@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'ambassador', NULL, '0778901234', '987 Kilimani Court, Nairobi', 'profile_john.jpg', 1),
('Esther Waithera', 'esther@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'ambassador', NULL, '0789012345', '654 Ngong Road, Nairobi', 'profile_esther.jpg', 1),
('Peter Mutua', 'peter@example.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'ambassador', NULL, '0790123456', '321 Langata Rd, Nairobi', NULL, 1);

-- Book data
INSERT INTO `book` (`book_title`, `book_author`, `book_genre`, `book_condition`, `book_price`, `listing_type`, `owner_id`, `book_status`, `book_publisher`, `book_published_year`, `book_ISBN`, `book_image`, `child_safe`) VALUES
-- Books listed by ambassadors (for selling)
('Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Fantasy', 'new', 2500.00, 'sell', 14, 'available', 'Bloomsbury', 1997, '9780747532699', 'harry_potter1.jpg', 'yes'),
('Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'Fantasy', 'used', 1800.00, 'sell', 14, 'available', 'Bloomsbury', 1998, '9780747538486', 'harry_potter2.jpg', 'yes'),
('Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 'Fantasy', 'new', 2500.00, 'sell', 14, 'available', 'Bloomsbury', 1999, '9780747542155', 'harry_potter3.jpg', 'yes'),
('Harry Potter and the Goblet of Fire', 'J.K. Rowling', 'Fantasy', 'used', 2000.00, 'sell', 14, 'available', 'Bloomsbury', 2000, '9780747550990', 'harry_potter4.jpg', 'yes'),
('Harry Potter and the Order of the Phoenix', 'J.K. Rowling', 'Fantasy', 'new', 2800.00, 'sell', 16, 'available', 'Bloomsbury', 2003, '9780747551003', 'harry_potter5.jpg', 'yes'),
('Harry Potter and the Half-Blood Prince', 'J.K. Rowling', 'Fantasy', 'used', 1900.00, 'sell', 16, 'available', 'Bloomsbury', 2005, '9780747581086', 'harry_potter6.jpg', 'yes'),
('Harry Potter and the Deathly Hallows', 'J.K. Rowling', 'Fantasy', 'new', 2500.00, 'sell', 16, 'available', 'Bloomsbury', 2007, '9780747591054', 'harry_potter7.jpg', 'yes'),

-- Non-fiction books (for selling)
('Becoming', 'Michelle Obama', 'Biography', 'new', 3500.00, 'sell', 15, 'available', 'Crown Publishing', 2018, '9781524763138', 'becoming.jpg', 'yes'),
('Educated', 'Tara Westover', 'Memoir', 'used', 2200.00, 'sell', 15, 'available', 'Random House', 2018, '9780399590504', 'educated.jpg', 'yes'),
('Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'History', 'new', 2800.00, 'sell', 15, 'available', 'Harper', 2015, '9780062316097', 'sapiens.jpg', 'yes'),
('Born a Crime', 'Trevor Noah', 'Autobiography', 'used', 1800.00, 'sell', 15, 'available', 'Spiegel & Grau', 2016, '9780399588174', 'born_a_crime.jpg', 'yes'),

-- Books listed for swapping
('The Lion, the Witch and the Wardrobe', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 3, 'available', 'Geoffrey Bles', 1950, '9780064471046', 'narnia1.jpg', 'yes'),
('Prince Caspian', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 3, 'available', 'Geoffrey Bles', 1951, '9780064471054', 'narnia2.jpg', 'yes'),
('The Voyage of the Dawn Treader', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 4, 'available', 'Geoffrey Bles', 1952, '9780064471077', 'narnia3.jpg', 'yes'),
('The Silver Chair', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 4, 'available', 'Geoffrey Bles', 1953, '9780064471084', 'narnia4.jpg', 'yes'),
('The Horse and His Boy', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 5, 'available', 'Geoffrey Bles', 1954, '9780064471060', 'narnia5.jpg', 'yes'),
('The Magician\'s Nephew', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 6, 'available', 'The Bodley Head', 1955, '9780064471107', 'narnia6.jpg', 'yes'),
('The Last Battle', 'C.S. Lewis', 'Fantasy', 'used', NULL, 'swap', 7, 'available', 'The Bodley Head', 1956, '9780064471084', 'narnia7.jpg', 'yes'),

-- Children's books
('Diary of a Wimpy Kid', 'Jeff Kinney', 'Children\'s Fiction', 'new', 1500.00, 'sell', 14, 'available', 'Amulet Books', 2007, '9780810993136', 'wimpy_kid.jpg', 'yes'),
('Matilda', 'Roald Dahl', 'Children\'s Fiction', 'used', 1200.00, 'sell', 15, 'available', 'Jonathan Cape', 1988, '9780141301068', 'matilda.jpg', 'yes'),
('Charlotte\'s Web', 'E.B. White', 'Children\'s Fiction', 'new', 1400.00, 'sell', 16, 'available', 'Harper & Brothers', 1952, '9780064410939', 'charlottes_web.jpg', 'yes'),
('The Gruffalo', 'Julia Donaldson', 'Children\'s Fiction', 'used', 1000.00, 'sell', 14, 'available', 'Macmillan', 1999, '9780333710937', 'gruffalo.jpg', 'yes'),
('Percy Jackson and the Lightning Thief', 'Rick Riordan', 'Fantasy', 'new', 1800.00, 'sell', 15, 'available', 'Hyperion Books', 2005, '9780786838653', 'percy_jackson1.jpg', 'yes'),
('Percy Jackson and the Sea of Monsters', 'Rick Riordan', 'Fantasy', 'used', 1500.00, 'sell', 15, 'available', 'Hyperion Books', 2006, '9781423103349', 'percy_jackson2.jpg', 'yes'),

-- Books with different statuses
('The Hunger Games', 'Suzanne Collins', 'Young Adult', 'used', 1600.00, 'sell', 3, 'sold', 'Scholastic Press', 2008, '9780439023481', 'hunger_games.jpg', 'yes'),
('Catching Fire', 'Suzanne Collins', 'Young Adult', 'used', 1600.00, 'sell', 3, 'available', 'Scholastic Press', 2009, '9780439023498', 'catching_fire.jpg', 'yes'),
('Mockingjay', 'Suzanne Collins', 'Young Adult', 'used', 1600.00, 'sell', 3, 'available', 'Scholastic Press', 2010, '9780439023511', 'mockingjay.jpg', 'yes'),
('The Fault in Our Stars', 'John Green', 'Young Adult', 'used', NULL, 'swap', 4, 'swapped', 'Dutton Books', 2012, '9780525478812', 'fault_in_stars.jpg', 'yes'),

-- Adult books marked not child safe
('Game of Thrones', 'George R.R. Martin', 'Fantasy', 'used', 2000.00, 'sell', 4, 'available', 'Bantam Spectra', 1996, '9780553103540', 'game_of_thrones.jpg', 'no'),
('The Shining', 'Stephen King', 'Horror', 'used', 1800.00, 'sell', 5, 'available', 'Doubleday', 1977, '9780385121675', 'the_shining.jpg', 'no'),
('Gone Girl', 'Gillian Flynn', 'Thriller', 'new', 2200.00, 'sell', 6, 'available', 'Crown Publishing', 2012, '9780307588364', 'gone_girl.jpg', 'no'),
('Fifty Shades of Grey', 'E.L. James', 'Romance', 'used', 1500.00, 'sell', 7, 'available', 'Vintage Books', 2011, '9781612130286', 'fifty_shades.jpg', 'no');

-- Transaction data
INSERT INTO `transaction` (`book_id`, `requester_id`, `owner_id`, `type`, `status`, `created_at`) VALUES
-- Completed sales transactions
(27, 8, 3, 'sell', 'completed', '2024-04-15 12:30:45'),
(30, 10, 4, 'swap', 'completed', '2024-04-16 15:20:33'),

-- Pending transactions
(1, 3, 14, 'sell', 'pending', '2024-04-24 08:15:22'),
(2, 4, 14, 'sell', 'pending', '2024-04-24 10:30:18'),
(12, 5, 3, 'swap', 'pending', '2024-04-25 14:45:35'),

-- Approved transactions
(3, 6, 14, 'sell', 'approved', '2024-04-22 09:10:12'),
(8, 7, 15, 'sell', 'approved', '2024-04-23 11:25:43'),

-- Declined transactions
(4, 5, 14, 'sell', 'declined', '2024-04-20 13:40:27'),
(13, 3, 3, 'swap', 'declined', '2024-04-21 16:55:38');

-- Payment data
INSERT INTO `payment` (`user_id`, `amount`, `transaction_id`, `created_at`, `order_id`, `currency`, `status`) VALUES
(8, 1600.00, 1, '2024-04-15 12:35:22', 10001, 'LKR', 'completed'),
(3, 2500.00, 3, '2024-04-22 09:20:45', 10002, 'LKR', 'pending'),
(6, 2500.00, 5, '2024-04-22 09:30:18', 10003, 'LKR', 'completed'),
(7, 3500.00, 6, '2024-04-23 11:35:27', 10004, 'LKR', 'completed');

-- Token data
INSERT INTO `token` (`user_id`, `token_count`, `amount_paid`, `purchase_date`) VALUES
(3, 20, 2000.00, '2024-04-10'),
(4, 15, 1500.00, '2024-04-12'),
(5, 10, 1000.00, '2024-04-14'),
(6, 25, 2500.00, '2024-04-16'),
(7, 5, 500.00, '2024-04-18');

-- Notification data
INSERT INTO `notification` (`user_id`, `message`, `transaction_id`, `created_at`, `requester_id`) VALUES
(3, 'Your purchase of "Harry Potter and the Philosopher\'s Stone" is pending approval', 3, '2024-04-24 08:15:22', '3'),
(14, 'Sarah Johnson wants to buy your book "Harry Potter and the Philosopher\'s Stone"', 3, '2024-04-24 08:15:22', '3'),
(4, 'Your purchase of "Harry Potter and the Chamber of Secrets" is pending approval', 4, '2024-04-24 10:30:18', '4'),
(14, 'Michael Ochieng wants to buy your book "Harry Potter and the Chamber of Secrets"', 4, '2024-04-24 10:30:18', '4'),
(5, 'Your request to swap "The Lion, the Witch and the Wardrobe" is pending approval', 5, '2024-04-25 14:45:35', '5'),
(3, 'Jane Wambui wants to swap for your book "The Lion, the Witch and the Wardrobe"', 5, '2024-04-25 14:45:35', '5'),
(6, 'Your purchase of "Harry Potter and the Prisoner of Azkaban" has been approved', 5, '2024-04-22 09:10:12', '6'),
(14, 'You approved David Kamau\'s purchase of "Harry Potter and the Prisoner of Azkaban"', 5, '2024-04-22 09:10:12', '6'),
(7, 'Your purchase of "Becoming" has been approved', 6, '2024-04-23 11:25:43', '7'),
(15, 'You approved Lucy Muthoni\'s purchase of "Becoming"', 6, '2024-04-23 11:25:43', '7'),
(5, 'Your purchase of "Harry Potter and the Goblet of Fire" has been declined', 7, '2024-04-20 13:40:27', '5'),
(14, 'You declined Jane Wambui\'s purchase of "Harry Potter and the Goblet of Fire"', 7, '2024-04-20 13:40:27', '5'),
(3, 'Your request to swap "Prince Caspian" has been declined', 8, '2024-04-21 16:55:38', '3'),
(3, 'You declined Sarah Johnson\'s request to swap "Prince Caspian"', 8, '2024-04-21 16:55:38', '3');

-- Book requests from children to parents
INSERT INTO `book_request` (`child_id`, `book_id`, `status`, `created_at`) VALUES
(8, 1, 'pending', '2024-04-24 09:20:15'),
(9, 2, 'approved', '2024-04-23 10:35:27'),
(10, 3, 'pending', '2024-04-25 11:45:38'),
(11, 8, 'denied', '2024-04-22 13:10:43'),
(12, 9, 'approved', '2024-04-21 14:25:55'),
(13, 10, 'pending', '2024-04-24 15:40:12');

-- Book favorites
INSERT INTO `book_favorites` (`user_id`, `book_id`, `created_at`) VALUES
(3, 1, '2024-04-20 09:15:22'),
(3, 8, '2024-04-20 09:16:45'),
(4, 2, '2024-04-21 10:25:33'),
(4, 9, '2024-04-21 10:26:18'),
(5, 3, '2024-04-22 11:35:44'),
(5, 10, '2024-04-22 11:36:27'),
(6, 4, '2024-04-23 12:45:55'),
(7, 5, '2024-04-24 13:55:11'),
(8, 1, '2024-04-20 14:05:22'),
(9, 2, '2024-04-21 15:15:33'),
(10, 3, '2024-04-22 16:25:44'),
(11, 21, '2024-04-23 17:35:55');

-- Book comments
INSERT INTO `book_comments` (`book_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 3, 'This is a fantastic book for children! My kids loved it.', '2024-04-20 10:15:22'),
(1, 4, 'The quality of this book is excellent. Highly recommended!', '2024-04-21 11:25:33'),
(2, 5, 'The second book in the series is even better than the first one.', '2024-04-22 12:35:44'),
(2, 6, 'Although used, the book is in great condition.', '2024-04-23 13:45:55'),
(3, 7, 'My favorite in the Harry Potter series!', '2024-04-24 14:55:11'),
(8, 3, 'Michelle Obama\'s story is truly inspiring. Great read!', '2024-04-20 15:05:22'),
(9, 4, 'This memoir is powerful and thought-provoking.', '2024-04-21 16:15:33'),
(10, 5, 'A fascinating look at human history.', '2024-04-22 17:25:44'),
(21, 6, 'My kids couldn\'t stop reading this book!', '2024-04-23 18:35:55'),
(22, 7, 'Roald Dahl at his best. A classic!', '2024-04-24 19:45:11');

-- Articles
INSERT INTO `articles` (`user_id`, `title`, `content`, `image_url`, `status`, `created_at`) VALUES
(14, 'The Importance of Reading for Children', 'Reading is one of the most important skills a child can learn. It helps develop their imagination, language skills, and understanding of the world around them. In this article, we explore the many benefits of reading and how parents can encourage their children to develop a love for books from an early age...', 'article1.jpg', 'published', '2024-04-10 10:15:22'),
(15, 'Choosing Age-Appropriate Books', 'Finding the right books for your child\'s age and development stage is crucial. This guide will help parents select books that are not only engaging but also suitable for their child\'s reading level and interests...', 'article2.jpg', 'published', '2024-04-12 11:25:33'),
(16, 'The Benefits of Book Swapping', 'Book swapping is not only economical but also environmentally friendly. Learn how book swapping can expand your child\'s reading horizons while building a sense of community...', 'article3.jpg', 'published', '2024-04-14 12:35:44'),
(14, 'Creating a Reading-Friendly Home Environment', 'Your home environment plays a significant role in fostering a love of reading. Here are some tips on creating spaces and routines that encourage reading...', 'article4.jpg', 'published', '2024-04-16 13:45:55'),
(15, 'Digital vs. Physical Books: What\'s Best for Children?', 'In today\'s digital age, many parents wonder whether e-books or traditional physical books are better for their children. This article examines the pros and cons of both formats...', 'article5.jpg', 'draft', '2024-04-18 14:55:11');

-- Communities
INSERT INTO `community` (`communityName`, `communityDescription`, `communityImage`, `membership_type`, `created_at`, `status`) VALUES
('Fantasy Book Lovers', 'A community for fans of fantasy literature to discuss their favorite books, authors, and series.', 'fantasy_community.jpg', 'open', '2024-04-05 10:15:22', 'approved'),
('Young Readers Club', 'A supportive environment for young readers to share their reading experiences and recommendations.', 'young_readers.jpg', 'open', '2024-04-07 11:25:33', 'approved'),
('Classic Literature Society', 'For those who appreciate the timeless beauty of classic literature.', 'classics.jpg', 'invitation', '2024-04-09 12:35:44', 'approved'),
('Science Fiction Explorers', 'A space for sci-fi enthusiasts to discuss futuristic worlds and technological possibilities.', 'scifi.jpg', 'open', '2024-04-11 13:45:55', 'approved'),
('Poetry Corner', 'A sanctuary for poetry lovers to share and discuss their favorite poems and poets.', 'poetry.jpg', 'open', '2024-04-13 14:55:11', 'approved'),
('Historical Fiction Fans', 'For readers who enjoy traveling back in time through the pages of historical fiction.', 'historical.jpg', 'invitation', '2024-04-15 15:05:22', 'pending');

-- Events
INSERT INTO `event` (`event_name`, `event_description`, `event_place`, `event_date`, `event_time`, `community_id`) VALUES
('Harry Potter Book Club Meeting', 'Join us for a discussion of J.K. Rowling\'s Harry Potter series. All fans are welcome!', 'Sarit Centre, Westlands', '2024-05-15', '14:00:00', 1),
('Story Reading Session for Kids', 'A fun-filled afternoon of storytelling and activities for children aged 5-10.', 'Junction Mall, Ngong Road', '2024-05-20', '10:00:00', 2),
('Shakespeare Appreciation Day', 'Celebrate the works of William Shakespeare with readings, discussions, and performances.', 'Alliance Française, Nairobi', '2024-05-25', '11:00:00', 3),
('Sci-Fi Movie and Book Discussion', 'Watch a science fiction movie adaptation and compare it to the original book.', 'Prestige Cinema, Ngong Road', '2024-06-01', '16:00:00', 4),
('Poetry Reading Night', 'An evening of poetry reading and appreciation. Bring your favorite poems to share!', 'Kengeles, Lavington', '2024-06-05', '18:00:00', 5);

-- Writing Groups
INSERT INTO `writinggroup` (`writingGroup_name`, `writingGroup_description`, `community_id`, `image_path`) VALUES
('Fantasy Writers Guild', 'A supportive group for aspiring fantasy authors to share their work and receive feedback.', 1, 'fantasy_writers.jpg'),
('Children\'s Story Authors', 'For writers who create stories that inspire and entertain young readers.', 2, 'childrens_authors.jpg'),
('Shakespeare Study Group', 'An in-depth exploration of Shakespeare\'s plays and sonnets for writers seeking to understand his techniques.', 3, 'shakespeare_study.jpg'),
('Science Fiction Workshop', 'A collaborative space for sci-fi writers to develop their ideas and world-building skills.', 4, 'scifi_workshop.jpg'),
('Poetry Workshop', 'For poets to share their work, receive critiques, and grow in their craft.', 5, 'poetry_workshop.jpg');

-- Community Members
INSERT INTO `community_member` (`community_member_name`, `community_id`, `event_id`, `user_id`, `writingGroup_id`) VALUES
('Sarah Johnson', 1, 1, 3, 1),
('Michael Ochieng', 1, 1, 4, 1),
('Jane Wambui', 2, 2, 5, 2),
('David Kamau', 2, 2, 6, 2),
('Lucy Muthoni', 3, 3, 7, 3),
('John Njenga', 3, 3, 14, 3),
('Esther Waithera', 4, 4, 15, 4),
('Peter Mutua', 4, 4, 16, 4),
('Tim Johnson', 1, 1, 8, 1),
('Emma Johnson', 2, 2, 9, 2),
('Caleb Ochieng', 3, 3, 10, 3),
('Grace Wambui', 4, 4, 11, 4),
('Daniel Kamau', 5, 5, 12, 5),
('Faith Muthoni', 5, 5, 13, 5);

-- Posts
INSERT INTO `posts` (`community_id`, `community_member_id`, `title`, `content`, `created_at`) VALUES
(1, 1, 'My Favorite Fantasy Series', 'Harry Potter has always been my favorite fantasy series, but I\'ve recently discovered the Mistborn trilogy by Brandon Sanderson and it\'s amazing! Has anyone else read it?', '2024-04-20 10:15:22'),
(1, 2, 'Fantasy Books for Teenagers', 'My teenage son is looking for new fantasy books to read. He\'s already read Harry Potter, Percy Jackson, and The Chronicles of Narnia. Any recommendations?', '2024-04-21 11:25:33'),
(2, 3, 'Best Books for 8-Year-Olds', 'My daughter is 8 and loves to read. She\'s particularly interested in adventure stories with female protagonists. Any suggestions?', '2024-04-22 12:35:44'),
(2, 4, 'Reading Challenges for Kids', 'I\'ve started a reading challenge with my children where they aim to read one book per week. It\'s been a great way to encourage them to read more. Anyone else tried something similar?', '2024-04-23 13:45:55'),
(3, 5, 'Discussing Pride and Prejudice', 'I\'ve just finished reading Jane Austen\'s Pride and Prejudice for the first time. I\'d love to discuss the character development of Elizabeth Bennet with fellow classic literature enthusiasts.', '2024-04-24 14:55:11');

-- Writing Group Posts
INSERT INTO `writing_group_posts` (`writingGroup_id`, `community_member_id`, `chapter_title`, `chapter_content`, `created_at`) VALUES
(1, 1, 'The Lost Kingdom - Chapter 1', 'The mist hung heavy over the ancient forest, obscuring the path that Elian knew he must follow. His hand rested on the hilt of his sword, a nervous habit he had developed during his years as a royal guard...', '2024-04-25 15:05:22'),
(1, 2, 'The Crystal Cave - Prologue', 'Legend spoke of a cave hidden deep within the Mistral Mountains, its walls embedded with crystals that glowed with an otherworldly light. It was said that those who found the cave would be granted visions of the future...', '2024-04-26 16:15:33'),
(2, 3, 'Lily\'s Adventure - Chapter 1', 'Lily woke up to the sound of birds chirping outside her window. Today was no ordinary day. Today was the day of the big adventure she had been planning all summer...', '2024-04-27 17:25:44'),
(3, 5, 'Reflections on Hamlet - Essay', 'Shakespeare\'s portrayal of Hamlet\'s inner conflict provides a fascinating study in human psychology. The character\'s famous soliloquies reveal a mind torn between action and inaction...', '2024-04-28 18:35:55'),
(4, 7, 'Beyond the Stars - Chapter 1', 'The colony ship Avalon drifted silently through the vast emptiness of space. Inside, five thousand colonists slept in cryogenic chambers, unaware of the malfunction that had sent the ship off course...', '2024-04-29 19:45:11');

-- Commit the transaction
COMMIT;