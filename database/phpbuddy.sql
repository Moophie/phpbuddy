-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 08, 2020 at 05:24 PM
-- Server version: 5.6.34-log
-- PHP Version: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpbuddy`
--

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int(30) NOT NULL,
  `room_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `building`, `floor`, `room_number`) VALUES
(1, 'Z3.04', 'De Ham', 3, 4),
(2, 'G0.22', 'Kruidtuin', 0, 22),
(3, 'Z3.09', 'De Ham', 3, 9),
(4, 'Z0.10', 'De Ham', 0, 10),
(5, 'G1.26', 'Kruidtuin', 1, 26),
(6, 'G1.25', 'Kruidtuin', 1, 25),
(7, 'G1.22', 'Kruidtuin', 1, 22),
(8, 'G1.23', 'Kruidtuin', 1, 23),
(9, 'G1.24', 'Kruidtuin', 1, 24),
(12, 'Z2.01', 'De Ham', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max` int(11) NOT NULL,
  `creator` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `reaction` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  `message_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `op` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faq` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL,
  `upvotes` int(11) NOT NULL,
  `edited` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `op`, `timestamp`, `content`, `faq`, `parent`, `upvotes`, `edited`) VALUES
(2, 'Serafima Yavarouskaya', '2020-05-07 11:56:48', '', 1, 0, 1, '2020-05-07 11:57:05'),
(3, 'Serafima Yavarouskaya', '2020-05-07 11:56:53', 'hey', 0, 2, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `upvotes`
--

CREATE TABLE `upvotes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upvotes`
--

INSERT INTO `upvotes` (`id`, `user_id`, `post_id`) VALUES
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `validation_string` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buddy_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_img` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `games` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `music` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `films` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `books` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `study_pref` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hobby` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buddy_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `active`, `validation_string`, `buddy_status`, `fullname`, `email`, `password`, `profile_img`, `bio`, `location`, `games`, `music`, `films`, `books`, `study_pref`, `hobby`, `buddy_id`) VALUES
(1, 1, '', 'firstyear', 'Michael Van Lierde', 'michael@student.thomasmore.be', '$2y$10$Fb4BKktLG/oZFiPVQi2RWuHitbfbTJrsYWvSd6z/yBiNXdHZJGngG', 'DSC_0009.JPG', 'Hallo, ik ben Michael!', 'Beigem', 'League of Legends', 'Rap', 'lol', 'World War Z', 'Development', 'Skating', 0),
(2, 1, '', 'firstyear', 'Jasper Peeters', 'jasper@student.thomasmore.be', '$2y$10$WCT4XCccfLANWuUWYz/dd.w/k.IDMp6F8oKWUfc47UFxt5SSvR1tm', 'koencrucke.jpg', 'Hey ik ben een Jasper!', 'Antwerpen', 'Call Of Duty', 'Pop', 'Harry Potter', 'Narnia', 'Design', 'Soccer', 5),
(3, 1, '', 'mentor', 'Serafima Yavarouskaya', 'serafima@student.thomasmore.be', '$2y$10$HM1aT7b8lpINWOv0MWf/N.k39CcGca66XpqJbfEC8iZ121PeHYVR6', 'dve poloski.jpg', 'Hey ik ben Serafima!', 'Beigem', 'League of Legends', 'Rap', 'World War Z', 'Narnia', 'Development', 'Skating', 0),
(4, 1, '', 'mentor', 'Tommy Den Hollander', 'tommy@student.thomasmore.be', '$2y$10$ELiDd4DP7AD8GzwCigvEJOWbFEowSNgEXmBnw1npzBO9XUPml1UP2', 'elonmusk.jpg', 'Hey ik ben tommy', 'Londerzeel', 'Call Of Duty', 'Pop', 'Wolf Of Wall Street', 'Ender\'s Game', 'Undecided', 'Fitness', 0),
(5, 1, '', 'firstyear', 'Tareq Tahtah', 'tareq@student.thomasmore.be', '$2y$10$6.3OP57jKbGbb.2IGBjkmu5c7hfXpBzR/PHGmdr3opLbV2q1AZjVa', 'robertdowneyjr.jpg', 'Hey ik Tareq', 'Gent', 'Tetris', 'Rock', 'Lord Of The Rings', 'Grote Vriendelijke Reus', 'Design', 'Soccer', 2),
(6, 1, '', 'mentor', 'Timothy Koenig', 'timothy@student.thomasmore.be', '$2y$10$n7fdwdDHjbejf0HUR3D.Tu8YBpqiLhvubsDCPd01XuT4h9ff5gJJe', 'chrisevans.jpg', 'Hallo ik ben Timothy', 'Gent', 'League of Legends', 'Rock', 'Wolf Of Wall Street', 'The Witcher', 'Design', 'Piano', 0),
(7, 1, '', 'firstyear', 'Luka Culibrk', 'luka@student.thomasmore.be', '$2y$10$R4hKf3WezhSdSHRs0fzSQuO3W2QvqNjiWgv4QHohxVWHiYNcPVsAG', 'chrishemsworth.jpg', 'Hallo ik ben Luka', 'Aalst', 'Fortnite', 'Jazz', 'Harry Potter', 'Harry Potter', 'Development', 'Soccer', 0),
(8, 1, '', 'firstyear', 'Lieselotte Philips', 'lieselotte@student.thomasmore.be', '$2y$10$mgdsalkNV3n4oqYUIgjacOUMOCFVdafidrWU83QyXf0x7bNSpXYx6', 'scarlettjohansson.jpg', 'Hi, I\'m Lieselotte', 'Brugge', 'Fortnite', 'Techno', 'Inception', 'The Witcher', 'Undecided', 'Volleyball', 0),
(9, 1, '', 'firstyear', 'Sam Verdaet', 'sam@student.thomasmore.be', '$2y$10$tcjLC.a9UPzexBbg/R3E6.SAuzJGwlW/OgXpuRE/g0m9c38gVNMfO', 'keiraknightley.jpg', 'Hey, met Sam hier', 'Antwerpen', 'Tetris', 'House', 'Harry Potter', 'Harry Potter', 'Undecided', 'Soccer', 0),
(10, 1, '', 'mentor', 'Leander Nelissen', 'leander@student.thomasmore.be', '$2y$10$0.Hj8ePbGNY28UntxpdqVuwPYLUUA4zcs0P.xM609qjBskT1SbXPa', 'pewdiepie.jpg', 'Welkom op Leander zijn profiel boys and girls!', 'Hasselt', 'Call Of Duty', 'House', 'Lord Of The Rings', 'The Wheel Of Time', 'Design', 'Fitness', 0),
(14, 0, '16218dd2837cd562d09a4fe29c8abd220f85f34e', '', 'Test McTesterson', 'test@student.thomasmore.be', '$2y$10$Swws8MvAGUSV2Qkz6RWFT.o2TecDB.LqJn6mu.cLOSRVmPLxPy.Ay', '', '', '', '', '', '', '', '', '', 0),
(18, 1, '284a4ea543b815fe7c1de996a80dd5ba16f18f9b', '', 'Michael Student', 'r0469612@student.thomasmore.be', '$2y$10$T98xHv.b8OrTmZALM/4QJeo1r5v3JLE/iY/JXnFoLZy3upR2Y1BK6', '', '', '', '', '', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_events`
--

CREATE TABLE `users_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upvotes`
--
ALTER TABLE `upvotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_events`
--
ALTER TABLE `users_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `upvotes`
--
ALTER TABLE `upvotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users_events`
--
ALTER TABLE `users_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
