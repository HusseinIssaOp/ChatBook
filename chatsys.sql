
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `createdOn` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `userID`, `comment`, `createdOn`) VALUES
(25, 6, 'This app is amazing', '2023-12-26 12:39:01'),
(30, 4, 'wow good work on this website', '2023-12-26 13:05:17'),
(31, 5, 'chatbook is the best', '2023-12-26 13:10:39'),
(32, 8, 'responsive and cool ', '2023-12-26 20:55:36'),
(33, 6, 'wow great app !!!', '2023-12-26 21:11:08');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `commentID` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `createdOn` datetime NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `commentID`, `comment`, `createdOn`, `userID`) VALUES
(20, 25, 'yup i agree!', '2023-12-26 13:03:07', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(30) NOT NULL,
  `userId` int(225) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_img` text NOT NULL,
  `active_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `userId`, `username`, `password`, `email`, `user_img`, `active_at`, `status`) VALUES
(4, 117454, 'huss', '$2y$10$Nn.a4UK81kjmcVJAdAWsfOvlI.WTzInwr0xZsUMOrojKUdz2D8wx6', 'huss@gmail.com', '73921.jpg', '2023-12-26 20:36:00', 'Off'),
(5, 200914, 'muss', '$2y$10$A.cauba3Z2FmZs1RtiaPuOlh2YSWWSS6CwDGHQdORzILLlJlp7IIG', 'muss@gmail.com', '54435.png', '2023-12-26 20:36:20', 'On'),
(6, 31758, 'luss', '$2y$10$iRMiNTpxrRdxEU3hMKtkyuZkvjZ/NvbuR2eM0qvo6HOxb8SHHgFru', 'luss@gmail.com', '151010.jpg', '2023-12-26 14:24:16', 'Off'),
(7, 290005, 'wuss', '$2y$10$Ogu788CoT81Urj/eH8IpQu79L23ARaz6VHlgeIj7ir0kdTI/TOzIy', 'wuss@gmail.com', '339493.jpg', '2023-12-24 10:37:32', 'Off'),
(8, 114323, 'tuss', '$2y$10$TAS8BOxqdjrN6WjGStSD8uOBJaiBaIXiemQtY4sXWL9GzcmP46b4S', 'tuss@gmail.com', '296264.png', '2023-12-26 18:56:44', 'Off');

-- --------------------------------------------------------

--
-- Table structure for table `user_msg`
--

CREATE TABLE `user_msg` (
  `id` int(30) NOT NULL,
  `incoming_id` int(255) NOT NULL,
  `outgoing_id` int(255) NOT NULL,
  `messages` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_msg`
--

INSERT INTO `user_msg` (`id`, `incoming_id`, `outgoing_id`, `messages`, `timestamp`) VALUES
(4, 117454, 200914, 'hello', '2023-12-24 10:09:33'),
(5, 200914, 117454, 'hello wassup', '2023-12-24 10:09:33'),
(6, 200914, 117454, 'good, what about you ?', '2023-12-24 10:09:33'),
(7, 117454, 200914, 'im good too', '2023-12-24 10:09:33'),
(8, 117454, 31758, 'hello huss !!', '2023-12-24 10:09:33'),
(9, 117454, 290005, 'hello how are you ?', '2023-12-24 10:09:33'),
(11, 117454, 200914, 'image', '2023-12-24 10:09:33'),
(12, 117454, 200914, 'hi', '2023-12-24 10:19:15'),
(13, 117454, 200914, 'sup ?', '2023-12-24 10:19:51'),
(14, 31758, 200914, 'hi', '2023-12-24 10:23:26'),
(15, 31758, 200914, 'hi', '2023-12-24 10:25:55'),
(16, 290005, 200914, 'hi', '2023-12-24 10:36:16'),
(17, 200914, 290005, 'yo', '2023-12-24 10:37:19'),
(18, 117454, 31758, 'hi', '2023-12-24 10:46:18'),
(19, 117454, 31758, 'hi', '2023-12-24 10:49:57'),
(20, 290005, 31758, 'hi wuss', '2023-12-24 11:06:20'),
(21, 290005, 31758, 'hey i just wanted to tell you that you are amazing', '2023-12-24 11:16:14'),
(22, 200914, 31758, 'hi', '2023-12-24 11:23:35'),
(23, 200914, 117454, 'hi', '2023-12-24 11:24:08'),
(24, 117454, 200914, 'i just wanted to say hiiii', '2023-12-24 13:14:04'),
(25, 31758, 200914, 'yo', '2023-12-24 14:15:03'),
(26, 117454, 200914, 'yoooo', '2023-12-25 12:40:14'),
(27, 31758, 200914, 'sup', '2023-12-26 11:20:03'),
(28, 114323, 117454, 'hi ', '2023-12-26 14:26:49'),
(31, 117454, 200914, '??', '2023-12-26 14:49:17'),
(32, 117454, 200914, 'yup ?', '2023-12-26 18:57:17'),
(33, 31758, 200914, 'hi', '2023-12-26 18:58:33'),
(34, 290005, 117454, 'im fine', '2023-12-26 19:02:10'),
(35, 117454, 200914, 'hhhhhh', '2023-12-26 19:09:41'),
(36, 31758, 200914, 'yo ma boy', '2023-12-26 19:10:11'),
(37, 117454, 200914, 'im good !', '2023-12-26 19:16:22'),
(38, 117454, 200914, 'goodbye', '2023-12-26 19:24:07'),
(39, 117454, 200914, 'welcome', '2023-12-26 19:33:30'),
(40, 117454, 200914, 'god bless you', '2023-12-26 19:33:38'),
(41, 117454, 200914, 'send me your number', '2023-12-26 19:33:46'),
(42, 117454, 200914, 'this msg is added to database', '2023-12-26 19:34:06'),
(43, 117454, 200914, '??', '2023-12-26 19:35:32'),
(44, 117454, 200914, '??', '2023-12-26 19:35:47'),
(45, 117454, 200914, 'yoooo?', '2023-12-26 19:41:32'),
(46, 31758, 117454, 'hi', '2023-12-26 19:55:18'),
(47, 290005, 117454, 'u ?', '2023-12-26 19:55:38'),
(48, 200914, 117454, 'yoo', '2023-12-26 20:17:52'),
(49, 200914, 117454, 'sup ma boyyy', '2023-12-26 20:29:07'),
(50, 117454, 200914, 'im goooooooooood', '2023-12-26 20:36:53'),
(51, 117454, 200914, 'you ??', '2023-12-26 20:38:43'),
(52, 117454, 200914, 'suppppppp', '2023-12-26 20:42:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commentID` (`commentID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_msg`
--
ALTER TABLE `user_msg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_msg`
--
ALTER TABLE `user_msg`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`commentID`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

