-- Manage Communities Table and Example Data

CREATE TABLE IF NOT EXISTS `community` (
  `communityId` int(100) NOT NULL AUTO_INCREMENT,
  `communityName` varchar(255) NOT NULL,
  `communityDescription` text,
  `communityImage` varchar(255),
  `membership_type` enum('open','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `delete_status` enum('none','requested','approved','rejected') DEFAULT 'none',
  PRIMARY KEY (`communityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dummy data for communities
INSERT INTO `community` (`communityName`, `communityDescription`, `communityImage`, `membership_type`, `status`, `delete_status`, `created_at`) VALUES
('Writers United', 'A community for aspiring writers to share and critique work.', 'public/img/community/sample.jpg', 'open', 'pending', 'none', '2025-04-01 10:00:00'),
('Book Lovers', 'A place for book enthusiasts.', 'public/img/community/sample2.jpg', 'closed', 'approved', 'none', '2025-04-10 15:30:00'),
('Tech Geeks', 'A hub for technology discussions and meetups.', 'public/img/community/sample3.jpg', 'open', 'approved', 'none', '2025-04-15 09:00:00'),
('Nature Club', 'Connecting people who love nature and outdoor activities.', 'public/img/community/sample4.jpg', 'open', 'pending', 'requested', '2025-04-20 12:00:00');
