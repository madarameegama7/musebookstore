-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 27, 2025 at 02:15 PM
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
-- Database: `muse1`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `user_id`, `title`, `content`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'My First Article', 'Hello', '', 'published', '2025-04-24 17:16:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `book_id` int(11) NOT NULL,
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
  `child_safe` enum('yes','no') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`book_id`, `book_title`, `book_author`, `book_genre`, `book_condition`, `book_price`, `listing_type`, `owner_id`, `book_status`, `created_at`, `book_publisher`, `book_published_year`, `book_ISBN`, `book_image`, `child_safe`) VALUES
(20, 'Atomic Habits', 'James Clear', 'Productivity', 'new', 3600.00, 'sell', 5, 'available', '2025-04-20 13:59:05', 'Avery (an imprint of Penguin Random House)', 2018, 'ISBN-10: 0735211299', '1745157545_67476f974f7ef_atomicbooks.jpg', NULL),
(21, 'Harry Potter and the Cursed Child', 'J.K. Rowling', 'Fiction', 'used', 2600.00, 'swap', 5, 'available', '2025-04-20 14:01:11', 'Arthur A. Levine Books​', 2016, 'ISBN-13: 978-1338216660​', '1745157671_67477c84c8eae_Harry Potter And The Cursed Child.jpg', NULL),
(22, 'Iron Flame', 'Rebecca Yarros', 'Fiction', 'used', 2600.00, 'swap', 5, 'swapped', '2025-04-20 14:03:08', 'Red Tower Books​', 2023, 'ISBN-13: 978-1649374172', '1745157788_67477cc0c289a_iron flame.jpg', NULL),
(23, 'Spare', 'Prince Harry, Duke of Sussex', 'Biography / Memoir', 'new', 2300.00, 'swap', 5, 'swapped', '2025-04-20 14:05:48', 'Penguin Random House', 2023, 'ISBN-13: 978-0593593806', '1745157948_67477d4d5f850_Spare.jpg', NULL),
(24, 'It Ends with Us', 'Colleen Hoover', 'Fiction', 'used', 2500.00, 'swap', 5, 'swapped', '2025-04-20 14:10:33', 'Atria Books', 2016, '978-1501110368', '1745158233_67477d06efb77_itendswithus.jpg', NULL),
(25, 'Unsinkable: A Memoir', 'Debbie Reynolds and Dorian Hannaway', 'Biography / Memoir', 'new', 2300.00, 'swap', 23, 'available', '2025-04-21 07:27:36', 'William Morrow', 2013, '978-0062213655', '1745220456_67477eb590f45_unsinkable.jpg', NULL),
(26, 'Moon and Stars', 'Jenna Warren', 'Entertainment', 'new', 2500.00, 'swap', 5, 'swapped', '2025-04-24 17:09:52', 'Google Books', 2016, '7556565945', '1745514592_67477e7cbc3da_The moon and stars.jpg', NULL),
(28, 'The Women', 'Yaros Rebecaa', 'Communication', 'used', 4200.00, 'swap', 5, 'swapped', '2025-04-27 09:52:12', 'Kristin Hannah', 2024, '74125890', '1745747532_The women.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `book_comments`
--

CREATE TABLE `book_comments` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_favorites`
--

CREATE TABLE `book_favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_favorites`
--

INSERT INTO `book_favorites` (`id`, `user_id`, `book_id`, `created_at`) VALUES
(1, 5, 25, '2025-04-23 16:00:38');

-- --------------------------------------------------------

--
-- Table structure for table `book_request`
--

CREATE TABLE `book_request` (
  `request_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_request`
--

INSERT INTO `book_request` (`request_id`, `child_id`, `book_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 25, 'pending', '2025-04-23 16:00:41', NULL),
(2, 5, 26, 'pending', '2025-04-24 17:15:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `community`
--

CREATE TABLE `community` (
  `communityId` int(100) NOT NULL,
  `communityName` varchar(255) NOT NULL,
  `communityDescription` text DEFAULT NULL,
  `communityImage` varchar(255) DEFAULT NULL,
  `membership_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `delete_status` enum('none','requested','approved','rejected') DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community`
--

INSERT INTO `community` (`communityId`, `communityName`, `communityDescription`, `communityImage`, `membership_type`, `created_at`, `status`, `delete_status`) VALUES
(1, 'BookMark & Brevity', 'Welcome to BookMark & Brevity, a community designed for passionate readers, writers, and storytellers who appreciate the art of concise yet impactful writing. In a world overwhelmed by information, this group aims to celebrate the power of brevity — creating content that speaks volumes in just a few words. Whether you\'re an avid reader looking to explore short stories, or a writer trying to hone your skills in crafting tight, engaging narratives, this is the space for you!\n\nHere, we believe that sometimes less is more. Short stories, flash fiction, poems, and even thought-provoking one-liners can leave a lasting impression. In this community, you will:\n\nConnect with Like-minded Writers and Readers: Share your work, explore others’ writings, and engage in discussions about the beauty of brevity and storytelling.\n\nParticipate in Writing Challenges: Join weekly and monthly writing prompts designed to help you sharpen your ability to convey powerful messages in a few sentences or paragraphs.\n\nGet Feedback: Receive constructive critiques and support from fellow writers to improve your craft.\n\nDiscover New Writers: Explore fresh voices in the world of short and succinct writing. Find inspiration in the art of telling a story with less.', 'public/img/community/1.jpg', 'Private', '2025-04-06 14:22:26', 'approved', 'none'),
(2, 'Chapter Chat', 'Chapter Chat is a vibrant book community where readers connect, share reviews, discuss favorite reads, and discover new titles together. Whether you&#39;re into fiction, non-fiction, or niche genres, Chapter Chat brings book lovers together to spark meaningful conversations—one chapter at a time.', 'public/img/community/2.jpg', 'private', '2025-04-07 07:02:17', 'approved', 'none'),
(3, 'Chapter Chat', 'Chapter Chat is a vibrant book community where readers connect, share reviews, discuss favorite reads, and discover new titles together. Whether you&#39;re into fiction, non-fiction, or niche genres, Chapter Chat brings book lovers together to spark meaningful conversations—one chapter at a time.', 'public/img/community/2.jpg', 'private', '2025-04-07 08:46:37', 'approved', 'none'),
(4, 'Booked Beyond Imagination', 'Beyond Imagination is an inspiring and thought-provoking book that explores the limitless potential of the human mind and creativity. Through powerful stories, insights, and reflections, it encourages readers to break free from conventional thinking, dream bigger, and unlock their true potential. Perfect for anyone seeking motivation and a fresh perspective on life.', 'public/img/community/3.jpg', 'private', '2025-04-07 08:48:24', 'approved', 'none'),
(5, 'The Boundless Bookworms.', 'The Boundless Bookworms is a vibrant book community where readers connect, share reviews, discuss favorite reads, and discover new titles together. Whether you&#39;re into fiction, non-fiction, or niche genres, The Boundless Bookworms brings book lovers together to spark meaningful conversations—one chapter at a time', 'public/img/community/4.jpg', 'private', '2025-04-07 14:59:22', 'approved', 'none'),
(6, 'Between the Lines', 'Welcome to Between the Lines, a community where writers and readers come together to explore the untold, the hidden meanings, and the subtle nuances that lie just beneath the surface of storytelling. Here, we celebrate the power of the spaces between the words — those unspoken elements that give depth to the story. Whether you\'re a writer seeking to refine your craft or a reader who loves to analyze the deeper layers of a narrative, Between the Lines is the perfect place to dive deeper into the art of storytelling.\n\nIn this community, we believe that every piece of writing holds secrets, emotions, and themes waiting to be uncovered. The true essence of a story often lies between the lines, where characters’ motivations, hidden desires, and unspoken truths are revealed. Here, you can:\n\nEngage in Thoughtful Discussions: Join in conversations that explore the layers of meaning in the books you love, from symbolism to subtext, and discover new perspectives on familiar works.\n\nSharpen Your Writing: Share your stories, poems, and essays, and receive insightful feedback focused on how to add depth and hidden meaning to your writing.\n\nExplore Hidden Themes and Subtext: Take part in writing exercises and discussions that focus on subtle storytelling techniques, such as foreshadowing, symbolism, and the power of unsaid emotions.\n\nRead Between the Lines: Delve into thought-provoking discussions that encourage critical thinking about what’s left unsaid in literature and the role of implication in good writing.', 'public/img/community/Untitled design (2).png', 'private', '2025-04-23 10:46:05', 'pending', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `community_member`
--

CREATE TABLE `community_member` (
  `community_member_id` int(100) NOT NULL,
  `community_member_name` varchar(255) NOT NULL,
  `community_id` int(100) NOT NULL,
  `event_id` int(100) DEFAULT NULL,
  `user_id` int(100) NOT NULL,
  `writingGroup_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_member`
--

INSERT INTO `community_member` (`community_member_id`, `community_member_name`, `community_id`, `event_id`, `user_id`, `writingGroup_id`) VALUES
(1, 'Amasha', 1, NULL, 17, NULL),
(2, 'Amasha', 1, NULL, 17, NULL),
(3, 'Amasha', 1, NULL, 17, NULL),
(4, 'Amasha Miyuru', 1, NULL, 20, NULL),
(5, 'Madara', 1, NULL, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delete_requests`
--

CREATE TABLE `delete_requests` (
  `request_id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `request_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delete_requests`
--

INSERT INTO `delete_requests` (`request_id`, `community_id`, `reason`, `request_status`, `created_at`) VALUES
(8, 3, 'The community has repeatedly violated our guidelines, despite multiple warnings. Continued non-compliance has made it impossible to maintain the community.', 'pending', '2025-04-23 16:02:13'),
(9, 5, 'The community has repeatedly violated our guidelines, despite multiple warnings. Continued non-compliance has made it impossible to maintain the community.', 'pending', '2025-04-23 16:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(100) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_place` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL DEFAULT '00:00:00',
  `community_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_name`, `event_description`, `event_place`, `event_date`, `event_time`, `community_id`) VALUES
(3, 'Writing Workshop for Beginners', 'Join us for a comprehensive Writing Workshop for Beginners, where we’ll help you hone your writing skills. Whether you\'re a budding novelist, short story writer, or simply enjoy expressing yourself through words, this workshop is the perfect starting point. We’ll cover everything from crafting compelling characters to structuring your first draft, as well as tips on how to overcome writer’s block. Attendees will have the opportunity to participate in interactive writing exercises, share their work, and receive constructive feedback in a supportive, encouraging environment.\n\nWho Can Join:\nThis event is open to anyone with an interest in writing, from those who have never written a word to those who are looking to improve their skills. No prior experience is necessary—just bring your creativity and willingness to learn!\n\nBenefits:\n\nGain practical writing tips and techniques.\n\nParticipate in writing exercises designed to boost creativity.\n\nReceive constructive feedback from experienced writers.\n\nConnect with fellow aspiring writers for future collaborations.\n\nGet inspired and motivated to start your writing journey or take it to the next level.', 'galle', '2025-04-30', '15:00:00', 1),
(4, 'Community Gardening Day', 'Come together with your neighbors for Community Gardening Day, a hands-on event where we will work as a team to beautify our community garden. Whether you’re an experienced gardener or a complete novice, we encourage everyone to join in! We’ll plant flowers, vegetables, and herbs, as well as engage in some light landscaping to make the space more welcoming and sustainable. This event is not only a way to contribute to the environment but also a wonderful opportunity to meet new people and learn about sustainable gardening practices.\n\nWho Can Join:\nThis event is open to all ages and skill levels. Families, individuals, and groups are all welcome. Children are encouraged to join in and participate in kid-friendly gardening activities.\n\nBenefits:\n\nLearn about gardening and sustainable practices.\n\nContribute to the beautification of the local community.\n\nSpend time outdoors in a positive, collaborative setting.\n\nMeet like-minded individuals and foster a sense of community.\n\nCreate lasting memories with family and friends while helping the environment.\n\nEvent 3: Virtual Book Club Meetup', 'Colombo', '2025-05-23', '15:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `requester_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `user_id`, `message`, `transaction_id`, `created_at`, `requester_id`) VALUES
(10, 23, 'Madara Meegama has requested to swap the book titled \'\' with you.', 11, '2025-04-21 14:41:52', NULL),
(11, 5, 'Damithri has requested to swap the book titled \'It Ends with Us\' with you.', 12, '2025-04-22 01:58:15', NULL),
(12, 5, 'Dinu Meegama has requested to swap the book titled \'It Ends with Us\' with you.', 13, '2025-04-22 02:12:11', NULL),
(13, 5, 'Damithri has requested to swap the book titled \'Spare\' with you.', 16, '2025-04-24 02:18:25', '23'),
(16, 5, 'Dinu Meegama has requested to swap the book titled \'Moon and Stars\' with you.', 19, '2025-04-24 17:10:29', '20'),
(18, 5, 'Damithri has requested to swap the book titled \'The Women\' with you.', 21, '2025-04-27 09:54:25', '23');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `community_member_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `community_id`, `community_member_id`, `title`, `content`, `created_at`) VALUES
(1, 1, 1, 'Weekly Writing Prompt: “The Forgotten Letter”', 'As writers, we often find ourselves drawn to the unknown, the unexplained, and the mysterious. It’s that feeling of not knowing what lies just beyond our reach, lurking in the shadows of our imaginations, that often drives us to create our most compelling stories. This week, we invite you to explore the thrilling world of suspense and intrigue with a writing prompt that focuses on the eerie, the unexplained, and the deeply unsettling.\n\nPicture this: You’re walking down a quiet, dimly lit hallway. The air feels heavy, as if it’s waiting for something to happen. You take a few steps, your footsteps echoing softly in the silence. But then—there it is. A faint sound. A soft, rhythmic tapping on the floor. It’s subtle, almost imperceptible, but it’s there. Footsteps. But there’s no one around. No one in sight. No one within earshot. Yet, the sound persists, growing closer, or maybe just moving alongside you. You stop and listen, straining your ears for any hint of a presence. But there’s nothing. No explanation. No reason for it.\n\nNow, ask yourself: Who—or what—is leaving those invisible marks on the floor? What’s the source of the sound that you can’t seem to escape? Is it something natural, perhaps the house settling, or the wind shifting through an old crack? Or is it something far more sinister, an entity from another world, trying to communicate through subtle, ghostly means? Could it be someone you know, someone you haven’t seen in years, walking in the same place but hidden in the folds of time and space?\n\nThis prompt gives you the freedom to dive deep into the world of mystery and suspense. Whether you choose to write a chilling ghost story, a psychological thriller, or a psychological journey that explores the unknown depths of the human mind, the goal is to tap into that primal fear we all share—the fear of the unknown. What’s out there? What’s around the corner? And more importantly—what’s following you?\n\n', '2025-04-23 00:34:21'),
(6, 1, 4, 'Writing Tip Tuesday: “Show, Don’t Tell” – But When?', '\"Show, Don’t Tell\" is one of the most frequently shared pieces of writing advice, and for good reason. It’s a powerful technique that can transform a flat narrative into something vibrant and immersive. However, like any tool, it’s important to know when to use it. The goal isn’t to follow this rule blindly but to understand its strengths and when it serves your story best.\n\nIn this week’s Writing Tip Tuesday, we’ll dive into the nuances of “Show, Don’t Tell,” unpacking both when it’s most effective and when it might actually be more beneficial to tell rather than show. It’s all about balance and understanding how your choice of showing versus telling can influence the mood, pacing, and emotional depth of your story.\n\nWhat Does “Show, Don’t Tell” Really Mean?\n\nTo start, let’s break down the concept:\n\nShowing refers to describing actions, feelings, and events in a way that lets the reader experience them through sensory details, dialogue, and actions. Showing brings the reader into the moment and allows them to infer emotions or events for themselves.\n\nExample of Showing:\nHer hands trembled as she reached for the phone, the screen slipping through her fingers like water. Her breath caught in her throat, and the words on the screen blurred.\n\nTelling, on the other hand, involves directly stating what is happening, the feelings of a character, or the traits of something. It’s more straightforward and can be useful for moving the plot along efficiently.\n\nExample of Telling:\nShe was nervous when she picked up the phone.\n\nBoth techniques are important. The key is knowing when to use each approach.\n\nWhen to Use “Show”\n1. To Evoke Emotions in Readers:\n\nOne of the most powerful uses of “showing” is to create an emotional connection between the reader and the characters. Instead of simply telling the reader that a character is sad, angry, or in love, showing these emotions through their actions, thoughts, and reactions allows readers to feel alongside them. It immerses the reader in the character’s experience.\n\nExample:\n\nInstead of telling the reader that \"John was furious,\" you might show him slamming his fist on the table, his face turning red, and his voice cracking as he tries to hold back tears. The action lets the reader feel his anger in a visceral way.\n\n2. To Create Atmosphere and Worldbuilding:\n\nShowing is crucial when you want to immerse your readers in the setting or build the world of your story. Describing a setting with sensory details—what it smells like, what the air feels like, what sounds echo through the space—can transport the reader into the world you’ve created. This is especially important in genres like fantasy, horror, or historical fiction.\n\nExample:\n\nRather than telling the reader, \"The forest was spooky,\" show them the eerie nature of the forest: \"The trees creaked under the weight of the wind, their gnarled branches like twisted hands reaching out to snare any passerby. The air was thick, heavy with the scent of damp earth and decaying leaves.\"', '2025-04-23 22:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `token_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_count` int(11) DEFAULT 0,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`token_id`, `user_id`, `token_count`, `amount_paid`, `purchase_date`, `updated_at`) VALUES
(1, 5, 3, 200.00, '2025-04-01', '2025-04-27 09:55:11'),
(2, 23, 3, 200.00, '2025-04-02', '2025-04-27 09:55:11'),
(3, 20, 4, 200.00, '2025-04-06', '2025-04-24 17:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `type` enum('sell','swap') NOT NULL,
  `status` enum('pending','approved','declined','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `book_id`, `requester_id`, `owner_id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(11, 25, 5, 23, 'swap', 'pending', '2025-04-21 14:41:52', '2025-04-21 14:41:52'),
(12, 24, 23, 5, 'swap', 'declined', '2025-04-22 01:58:15', '2025-04-24 00:58:27'),
(13, 24, 20, 5, 'swap', 'approved', '2025-04-22 02:12:10', '2025-04-24 00:58:27'),
(14, 25, 20, 23, 'swap', 'pending', '2025-04-24 01:55:33', '2025-04-24 01:55:33'),
(15, 25, 23, 23, 'swap', 'pending', '2025-04-24 01:56:01', '2025-04-24 01:56:01'),
(16, 23, 23, 5, 'swap', 'approved', '2025-04-24 02:18:25', '2025-04-24 06:48:21'),
(17, 22, 5, 5, 'swap', 'declined', '2025-04-24 16:49:48', '2025-04-24 16:52:02'),
(18, 22, 20, 5, 'swap', 'approved', '2025-04-24 16:51:02', '2025-04-24 16:52:02'),
(19, 26, 20, 5, 'swap', 'approved', '2025-04-24 17:10:29', '2025-04-24 17:10:45'),
(21, 28, 23, 5, 'swap', 'approved', '2025-04-27 09:54:25', '2025-04-27 09:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
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
  `user_is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`, `parent_id`, `user_phone`, `user_address`, `created_at`, `user_photo`, `user_otp`, `user_otp_expires`, `user_is_verified`) VALUES
(5, 'Madara Meegama', 'madarameegama7@gmail.com', '$2y$10$xLs7VmMM/./XlPzZGtGdmeGnSboxafT3N/2tW5FJ3adi/Oc04Kgmu', 'ambassador', NULL, '0719589692', 'Homagama', '2025-02-20 13:03:57', '1745071507_photo.png', NULL, NULL, 1),
(7, 'Shehan De Alwis', 'shehan12@gmail.com', '$2y$10$Xo9yihOP5LmA1/xU0CjDl.PSlAEp93Cbg4UEGtjacTSMBVJdW9IUC', 'ambassador', NULL, '0723295295', 'Kottawa', '2025-02-23 02:17:28', NULL, NULL, NULL, 0),
(17, 'Amasha Miyuru', 'bashiniskam@gmail.com', '$2y$10$VWcNHT3Qk4SnXey4IdGxlOPErfZE9fgZ1T9ktWrk2tZIm.WS90n8m', 'parent', NULL, '0719589787', 'Galle', '2025-02-27 10:07:15', NULL, NULL, NULL, 0),
(20, 'Dinu Meegama', 'dinumeegama97@gmail.com', '$2y$10$.49XzL2siTqoAzS7mhdqfOq6e0/Fdb.y4yc5xO1pomKl8b09GKNhS', 'parent', NULL, '0719589692', 'Ja Ela', '2025-03-05 18:16:51', NULL, NULL, NULL, 0),
(23, 'Damithri', 'damithrimeegama2002@gmail.com', '$2y$10$drPjC8ec8UlKi8i259HO0ewOfxxxLe6ZiwQWS09GM6Nzd1wv2oJsO', 'parent', NULL, '0719589693', 'Colombo', '2025-04-19 14:30:51', '1745073051_photo.png', NULL, NULL, 1),
(24, 'hana', 'hana@gamil.com', '$2y$10$RbjDfXgU1tlX9okU4kkvKugr9f3RBrG2TLXhJsrgR6jW3K6O3OZfK', 'child', 5, NULL, NULL, '2025-04-23 17:00:11', NULL, NULL, NULL, 0),
(25, 'Madara', '2022is060@stu.ucsc.cmb.ac.lk', '$2y$10$nSRAy6Ui29paqrHMvTteNOLFDHHXTtspFiVLWBcHzcINA3hqGQoAu', 'parent', NULL, '0719589692', 'Homagama', '2025-04-27 11:31:31', '1745753491_propic.jpg', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_books`
-- (See below for the actual view)
--
CREATE TABLE `v_books` (
`book_id` int(11)
,`book_owner_id` int(11)
,`book_owner_name` varchar(100)
,`book_title` varchar(255)
,`book_author` varchar(255)
,`book_genre` varchar(255)
,`book_price` decimal(10,2)
,`listing_type` enum('sell','swap')
,`book_condition` enum('new','used')
,`book_publisher` varchar(100)
,`book_published_year` int(11)
,`book_ISBN` varchar(100)
,`book_image` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `writinggroup`
--

CREATE TABLE `writinggroup` (
  `writingGroup_id` int(100) NOT NULL,
  `writingGroup_name` varchar(255) NOT NULL,
  `writingGroup_description` text NOT NULL,
  `community_id` int(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `writinggroup`
--

INSERT INTO `writinggroup` (`writingGroup_id`, `writingGroup_name`, `writingGroup_description`, `community_id`, `image_path`) VALUES
(1, 'The Ink Circle', 'The Ink Circle is a close-knit community of passionate fiction writers who meet weekly to share stories, brainstorm ideas, and refine their craft. Whether you\'re working on a novel, a short story, or a piece of flash fiction, this group provides structured feedback and encouragement. Members benefit from regular prompts, peer reviews, and occasional guest workshops that help sharpen writing skills and spark creativity.', 1, 'public/img/community/writing_group1.jpg'),
(3, 'Plot Twisters', 'Plot Twisters is perfect for writers who love surprises, suspense, and stories with a twist. This group explores the elements of plot development, character arcs, and narrative tension. Members participate in themed writing challenges, receive detailed critiques, and have the opportunity to co-create collaborative stories. Joining this group will help you think outside the box and keep your readers guessing. Joining this group will help you think outside the box.\r\n                                                                               ', 1, 'public/img/community/writing_group2.jpg'),
(4, 'The Rhyme Room', 'The Rhyme Room is a creative collective for poets who want to express themselves through verse, whether it’s traditional or freeform. Weekly sessions focus on writing prompts, form experimentation, and personal expression. Members enjoy live readings, poetry slams, and feedback circles. The group nurtures confidence, emotional clarity, and poetic voice.\r\nJoining this group will help you think outside the box and keep your readers guessing. ', 1, 'public/img/community/writing_group3.jpg'),
(5, 'Verse & Vibe', 'Verse & Vibe brings together poets, lyricists, and spoken word artists in a lively and inclusive space. With a focus on rhythm, emotion, and authenticity, the group offers open mic nights, collaborative projects, and feedback sessions. Writers benefit from real-time performance practice, inspiration from diverse voices, and a sense of creative belonging.Joining this group will help you think outside the box and keep your readers guessing. ', 1, 'public/img/community/writing_group3.jpg'),
(6, 'The Edit Room', 'The Edit Room is where clarity meets polish. This group focuses on academic and professional writing—resumes, essays, cover letters, and reports. Members benefit from hands-on editing workshops, grammar clinics, and feedback exchanges. Whether you&#39;re preparing a job application or refining your college essay, you&#39;ll gain skills that enhance your writing&#39;s impact and professionalism.', 1, 'public/img/community/writing_group3.jpg'),
(7, 'Verse & Vibe', 'Verse & Vibe brings together poets, lyricists, and spoken word artists in a lively and inclusive space. With a focus on rhythm, emotion, and authenticity, the group offers open mic nights, collaborative projects, and feedback sessions. Writers benefit from real-time performance practice, inspiration from diverse voices, and a sense of creative belonging.Joining this group will help you think outside the box and keep your readers guessing. \r\n', 1, 'public/img/community/1745428115_writing_group4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `writing_group_posts`
--

CREATE TABLE `writing_group_posts` (
  `writingGroup_post_id` int(11) NOT NULL,
  `writingGroup_id` int(11) DEFAULT NULL,
  `community_member_id` int(11) DEFAULT NULL,
  `chapter_title` varchar(255) DEFAULT NULL,
  `chapter_content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `writing_group_posts`
--

INSERT INTO `writing_group_posts` (`writingGroup_post_id`, `writingGroup_id`, `community_member_id`, `chapter_title`, `chapter_content`, `created_at`) VALUES
(2, 1, 4, 'The Stranger at the Door', 'The storm had been relentless, battering the town with sheets of rain and howling winds that sent the trees swaying like frantic dancers. From the comfort of her small, dimly lit living room, Lena watched the storm rage outside, her attention drifting between the crackling fire in the hearth and the weathered pages of the book in her hands. The rhythmic sound of raindrops against the window lulled her into a sense of peaceful isolation. It was just the way she liked it—alone with her thoughts, tucked away from the rest of the world.\n\nThe world, after all, was a place that never quite understood Lena. She had lived in the small town her entire life, but there were parts of it that always felt like they were meant for someone else—someone who belonged. Her parents, well-known historians in the town, had passed away years ago under circumstances that still left her with more questions than answers. Since then, Lena had learned to keep to herself. No close friends, no attachments—just quiet days that slipped by in the haze of routine.\n\nAs she turned another page of her book, the flickering light of the fire cast long shadows across the room. The storm outside seemed to grow louder, its intensity increasing with each passing minute. But then, amid the howling wind and the crashing rain, there came a sound—a knock at the door.\n\nLena stiffened, her heart jumping in her chest. Who would be out in this storm, knocking on her door? The town was small, and people didn’t come by unannounced. In fact, the idea of someone visiting her at all seemed almost absurd. Reluctantly, she placed her book aside, wondering if maybe the storm had made her imagination run wild. But no, the knock came again—this time more insistent.\n\nShe stood up, the floorboards creaking beneath her feet, and walked toward the door. With each step, her pulse quickened. No one ever came. Not here, not now. As she reached for the door handle, an odd mixture of curiosity and unease flooded her. What could this person want? And why now?\n\nLena opened the door.\n\nStanding in the doorway was a man—a stranger.\n\nHe was soaked to the bone, his dark clothes clinging to his lean frame. His face was partially obscured by the hood of his jacket, but his eyes—dark, intense, and somehow familiar—met hers with an almost magnetic pull. Despite the rain, he stood there calmly, as if the storm didn’t faze him at all. There was something about him, something in his gaze, that unsettled her, yet she couldn\'t look away.\n\n“Good evening,” the man said, his voice low and steady, though there was a faint tremor beneath his words. “I’m sorry to disturb you, but I’m in need of shelter for the night. I’ve been traveling for hours, and I was told your house is the only place that might offer refuge.”\n\nLena hesitated, her mind racing. She couldn’t remember ever meeting this man, and yet something about his presence stirred a deep, unsettling feeling within her. She was certain no one had mentioned her house to him, especially in a town as small as theirs, where everyone knew everyone’s business.\n\nFor a moment, she almost closed the door, just a crack—just enough to escape the overwhelming sense of unease he had brought with him. But the rain was pouring so heavily, and the storm’s fury seemed to force its way into the room through the small crack in the door. She caught a glimpse of his eyes again—intense and searching—and something in her told her that the storm wasn’t the only thing that had brought him to her doorstep.\n\n“I don’t usually take in strangers,” Lena said, her voice wavering slightly. But she found herself stepping aside, motioning for him to come in.\n\nThe man gave her a small, almost imperceptible nod. He entered quickly, shaking off the rain from his coat. As he stepped into her home, the warmth from the fire seemed to create a stark contrast to the chill of the storm outside, but the air inside the house felt thick with tension, as if the walls themselves were holding their breath.\n\nLena closed the door behind him and turned to face him, her mind still racing. The man gave a grateful sigh as he sat down in the chair she had gestured toward.\n\n“Thank you,” he said again, his eyes scanning the room for a moment before meeting hers. “I didn’t mean to intrude, but it’s… important that I speak with you.”\n\nLena frowned, uneasy. “About what?”\n\nHis eyes darkened, and for a fleeting moment, she thought she saw a hint of something—fear?—beneath his calm exterior. “It’s about the town. About something that’s been hidden here for a very long time. Something you might not know, but that you need to.”\n\nLena’s heart skipped a beat. The words felt heavy, almost too significant for a chance encounter in the middle of a storm. She had heard whispers about the town’s past, dark rumors that seemed to follow the residents like a shadow—disappearances, strange events, things that no one spoke about openly. But she had never given much thought to them. After all, people loved to tell stories in small towns, and Lena had learned long ago to keep her distance from such tales.\n\n“Who are you?” Lena asked, her voice barely above a whisper.\n\nThe man looked at her for a long moment, as if weighing his answer. Finally, he spoke, his voice low and steady. “My name is Ethan. And I’m looking for something. Something that’s connected to you, whether you realize it or not.”\n\nLena felt a chill run down her spine. His words hung in the air, heavy with meaning she couldn’t yet comprehend. Something connected to her? She was about to ask him what he meant, but before she could speak, he added quickly:\n\n“I don’t want to alarm you, but I believe your family might have known more than they ever let on. Something dark, something that’s been hidden in this town for generations. I’ve been tracking it for months, and you—your name—is on a list. A list of people who might have the answers.”\n\nLena felt her pulse quicken. The air between them thickened, the quiet of the room now heavy with the weight of his words. She opened her mouth to respond, but before she could, Ethan stood up, his gaze fixed on her with an intensity that made her stomach churn.\n\n“Please,” he said, his voice firm now. “I need your help. The storm won’t let me leave, and I’m certain that what I’m looking for—what we’re both looking for—is here. In this town. And it’s tied to your family.”\n\nLena’s mind was racing. She should tell him to leave. She should turn him away. But something about his presence—his urgency, his conviction—kept her rooted to the spot.\n\n“Please,” he repeated, almost pleading now. “I don’t have much time.”\n\nWith the rain lashing against the windows and the storm swirling outside, Lena couldn’t shake the feeling that this encounter, this moment, was not a coincidence. Ethan’s arrival—his cryptic words—had ignited something deep within her. A part of her, the part she had buried for years, wondered if the mystery that had been haunting her family was finally about to be uncovered.\n\nAs she looked at him, the storm raging outside mirrored the storm brewing inside her. What had she just agreed to?', '2025-04-22 19:04:09'),
(3, 1, 4, 'The Secret in the Walls', 'Lena couldn’t shake the feeling that she had made a mistake. She hadn’t meant to invite Ethan in, but there was something about him—something both unsettling and magnetic—that had drawn her in. As the rain continued its relentless pounding on the windows, Lena sat across from him, her mind racing with questions. Why was her name on his list? What was this “dark secret” he spoke of? And why did he believe it was tied to her family?\n\nEthan had been quiet since his confession, his gaze fixed on the fire as if he were trying to will it into action, his expression unreadable. Lena, on the other hand, could hardly sit still. The questions swirling in her mind were like a storm of their own, each one more urgent than the last. Finally, she broke the silence.\n\n“You said it’s tied to my family,” she said, her voice trembling slightly. “What do you mean?”\n\nEthan turned his eyes to her, and for the first time, she saw a flicker of emotion—something close to regret. “I wish I could explain everything now, but we don’t have the luxury of time. What I can tell you is that your family’s history here is more complicated than you realize. There’s a reason people avoid this town, Lena. And it’s not just because it’s small.”\n\nLena’s heart skipped a beat. She had always felt that there was something more to her family’s legacy than what she had been told, but this was too much to absorb in one sitting.\n\n“Why are you here, Ethan?” she asked, her voice steadier than she felt. “What is it that you’re looking for?”\n\nEthan hesitated before answering, his voice low. “There’s an old house in the woods—a place that’s been abandoned for decades. The people in town don’t speak of it, but they all know about it. It’s where the answers lie. And I need to get inside.”\n\nLena’s pulse quickened. She had heard rumors of the house, but she had always assumed they were just ghost stories. Now, they seemed far too real.\n\n“I’ve been tracking it for months,” Ethan continued. “Your family has always been linked to it. I believe your parents knew something about the house—something that’s hidden behind its walls. But now, I need your help to uncover the truth.”\n\nLena’s mind reeled. She had never been one to believe in myths or superstitions, but there was something about Ethan’s desperation that made her doubt her own certainty.\n\n“What’s in that house, Ethan? What are we really looking for?”\n\nEthan looked her in the eye, and for the first time, she saw the weight of the burden he carried. “I don’t know. But I believe it’s something that has the power to change everything. For you, for me… for this town.”\n\nLena didn’t know what to say. She could feel the weight of the decision before her, the pull of curiosity and fear warring in her chest. The storm outside raged on, and the only thing that seemed certain in that moment was that her life would never be the same.\n\n', '2025-04-22 19:04:21'),
(4, 1, 4, 'Into the Woods', 'The next morning, after a sleepless night spent debating whether to trust Ethan, Lena found herself standing on the edge of the woods. The sky had cleared, but the remnants of the storm lingered in the form of muddy trails and slick leaves beneath her feet. Ethan had insisted they leave at first light, but Lena had been reluctant. Despite her instincts telling her to stay far away from whatever dark secret lay hidden in the forest, she couldn’t help but feel drawn to it. The mystery was too powerful to resist.\n\nEthan led the way, his movements purposeful, almost as if he had walked this path a thousand times before. He didn’t seem to mind the dampness of the ground, his boots crunching on the fallen leaves with each step. Lena, however, had to concentrate to keep her footing, her heart pounding in her chest. She couldn’t remember the last time she had ventured this far into the woods, but something about the air here felt different—thicker, heavier, as if the trees themselves were watching her.\n\nAs they walked deeper into the forest, the sounds of the town faded, replaced by the quiet rustle of leaves and the occasional bird call. The deeper they went, the more the trees seemed to close in around them, their branches interlocking like fingers holding tight to a secret.\n\n“This place…” Lena began, her voice barely more than a whisper. “It feels… wrong.”\n\nEthan glanced back at her, his expression unreadable. “It’s not wrong. It’s just forgotten. Most people in town are too afraid to remember what’s here.”\n\nLena’s curiosity gnawed at her. “What is it, Ethan? What’s so important about this house?”\n\nHe didn’t answer right away, but after a long pause, he spoke, his voice low and full of gravity. “The house is the key. To everything. It holds the answers that have been hidden for generations. And your family’s connection to it is more than you realize.”\n\nLena couldn’t help but feel a sense of unease wash over her. Her parents had never spoken about the house, nor had anyone in town. Yet, now that she was here, the air seemed to thrum with some unspoken truth, as if the very earth beneath her feet knew something she didn’t.\n\nAfter what seemed like hours of walking, they finally reached a clearing. And there, nestled among the trees, stood the house.\n\nThe once grand structure had fallen into decay. The wood was rotting, the windows boarded up, and vines twisted up the walls, obscuring the architecture. The house seemed to breathe with an eerie energy, as though it were waiting for something—or someone.\n\nEthan stopped in front of the house, turning to face Lena. His eyes were dark, intense, and full of a mixture of fear and determination.\n\n“We’re here,” he said. “The truth is inside.”', '2025-04-23 10:10:43'),
(5, 1, 4, 'Secrets Behind the Walls', 'Lena stared at the house in front of her, her heart hammering in her chest. The air around the house seemed to hum with a strange energy, as if it were alive. She could feel her breath catch in her throat, her legs frozen in place.\n\nEthan seemed to sense her hesitation, and he turned to her with a look of quiet urgency. “We have to go inside, Lena. We don’t have much time.”\n\nLena swallowed hard, her mind still reeling from everything she had learned. A house that had been abandoned for decades, her parents’ mysterious connection to it, and now, Ethan, who seemed to know more about her family than she did. It all felt like a dream—a nightmare, really—but one she couldn’t escape.\n\n“I don’t know if I can do this,” she said, her voice barely above a whisper. “What if this is a mistake? What if we’re not supposed to be here?”\n\nEthan stepped closer, placing a reassuring hand on her shoulder. “I understand your fear. But the only way to uncover the truth is to face it. And you’ve already come this far. You can’t turn back now.”\n\nWith a deep breath, Lena nodded. The storm had passed, but the storm inside her chest continued to rage. She had to see this through. For herself. For her parents. For the town that had been hiding something—something dark—for far too long.\n\nTogether, they stepped toward the house. The door was old and weathered, but surprisingly, it opened with ease. The hinges creaked as the door swung inward, revealing a dark, dusty interior. The air inside was thick with the scent of decay, and the floorboards groaned under their weight as they stepped inside.\n\nThe house was vast, its rooms stretching out in all directions. There were signs of a once-beautiful home—intricate woodwork on the walls, faded wallpaper, and the remains of furniture, now covered in layers of dust. But there was something else. The walls seemed to pulse with an unseen energy, as if they were holding a secret that had been waiting for the right moment to be revealed.\n\nAs they made their way through the rooms, Lena couldn’t shake the feeling that they were being watched. Every creak of the floor, every rustle of the wind outside seemed amplified in the silence of the house. The deeper they went, the more the atmosphere felt heavy, oppressive. And then, they came to a door at the end of a long hallway.\n\nEthan’s eyes narrowed as he approached the door. “This is it,” he said quietly. “The answers are behind here.”\n\nWith a trembling hand, he reached for the doorknob and turned it.', '2025-04-23 10:12:59'),
(6, 1, 4, 'The Hidden Room', 'The door opened with a faint groan, revealing a narrow, dimly lit room. The air inside was thick with dust and the scent of something old—something forgotten. As they stepped inside, Lena’s eyes were drawn to the far wall, where an ornate wooden cabinet stood, its doors closed but seemingly beckoning them forward.\n\nEthan moved toward it without hesitation, his face a mixture of determination and anticipation. “This is where it all began,” he muttered under his breath.\n\nLena followed him, her heart racing as they approached the cabinet. She could feel the weight of the room pressing in on her, the silence so thick that it felt suffocating.\n\nWith a swift motion, Ethan opened the cabinet doors. Inside, there was nothing but a stack of old books and papers. But as Lena peered closer, she noticed something odd—beneath the books, a piece of the floor seemed to be slightly raised, as though something was hidden underneath.\n\nEthan’s eyes lit up. “This is it.”\n\nHe crouched down and gently lifted the floorboard, revealing a hidden compartment. Inside, there was an old journal, its leather cover cracked with age. Ethan carefully picked it up, his hands trembling.\n\n“This journal belonged to your father,” he said, his voice reverberating with awe. “It holds the key to everything.”\n\nLena’s breath caught in her throat. The journal. Her father’s journal.\n\nWith trembling hands, she reached for it, and as she held it in her hands, she realized that this was only the beginning of a far darker and more complicated mystery than she could have ever imagined.\n\nThe secrets of the town. The secrets of her family. And the answers she had been searching for all her life—were now within her grasp.\n\n', '2025-04-23 10:29:37');

-- --------------------------------------------------------

--
-- Structure for view `v_books`
--
DROP TABLE IF EXISTS `v_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_books`  AS SELECT `book`.`book_id` AS `book_id`, `user`.`user_id` AS `book_owner_id`, `user`.`user_name` AS `book_owner_name`, `book`.`book_title` AS `book_title`, `book`.`book_author` AS `book_author`, `book`.`book_genre` AS `book_genre`, `book`.`book_price` AS `book_price`, `book`.`listing_type` AS `listing_type`, `book`.`book_condition` AS `book_condition`, `book`.`book_publisher` AS `book_publisher`, `book`.`book_published_year` AS `book_published_year`, `book`.`book_ISBN` AS `book_ISBN`, `book`.`book_image` AS `book_image` FROM (`book` join `user` on(`book`.`owner_id` = `user`.`user_id`)) ORDER BY `book`.`created_at` ASC ;

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
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `fk_book_owner` (`owner_id`);

--
-- Indexes for table `book_comments`
--
ALTER TABLE `book_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `book_favorites`
--
ALTER TABLE `book_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_book_unique` (`user_id`,`book_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `book_request`
--
ALTER TABLE `book_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `child_id` (`child_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `community`
--
ALTER TABLE `community`
  ADD PRIMARY KEY (`communityId`);

--
-- Indexes for table `community_member`
--
ALTER TABLE `community_member`
  ADD PRIMARY KEY (`community_member_id`),
  ADD KEY `foreign_key6` (`event_id`),
  ADD KEY `fk_8` (`community_id`),
  ADD KEY `fk_9` (`writingGroup_id`);

--
-- Indexes for table `delete_requests`
--
ALTER TABLE `delete_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `community_id` (`community_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `foreign_key1` (`community_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_payment_transaction` (`transaction_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `community_id` (`community_id`),
  ADD KEY `community_member_id` (`community_member_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`token_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `fk_transaction_buyer` (`requester_id`),
  ADD KEY `fk_transaction_seller` (`owner_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `writinggroup`
--
ALTER TABLE `writinggroup`
  ADD PRIMARY KEY (`writingGroup_id`),
  ADD KEY `foreign_key3` (`community_id`);

--
-- Indexes for table `writing_group_posts`
--
ALTER TABLE `writing_group_posts`
  ADD PRIMARY KEY (`writingGroup_post_id`),
  ADD KEY `writingGroup_id` (`writingGroup_id`),
  ADD KEY `community_member_id` (`community_member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `book_comments`
--
ALTER TABLE `book_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_favorites`
--
ALTER TABLE `book_favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_request`
--
ALTER TABLE `book_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `community`
--
ALTER TABLE `community`
  MODIFY `communityId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `community_member`
--
ALTER TABLE `community_member`
  MODIFY `community_member_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delete_requests`
--
ALTER TABLE `delete_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `writinggroup`
--
ALTER TABLE `writinggroup`
  MODIFY `writingGroup_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `writing_group_posts`
--
ALTER TABLE `writing_group_posts`
  MODIFY `writingGroup_post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_book_owner` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `book_comments`
--
ALTER TABLE `book_comments`
  ADD CONSTRAINT `book_comments_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `book_request`
--
ALTER TABLE `book_request`
  ADD CONSTRAINT `book_request_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_request_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `notification_id` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`),
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_transaction_buyer` FOREIGN KEY (`requester_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_transaction_seller` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`requester_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_id` FOREIGN KEY (`book_id`) REFERENCES `book` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `writing_group_posts`
--
ALTER TABLE `writing_group_posts`
  ADD CONSTRAINT `writing_group_posts_ibfk_1` FOREIGN KEY (`writingGroup_id`) REFERENCES `writinggroup` (`writingGroup_id`),
  ADD CONSTRAINT `writing_group_posts_ibfk_2` FOREIGN KEY (`community_member_id`) REFERENCES `community_member` (`community_member_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
