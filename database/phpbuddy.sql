-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 26, 2020 at 03:43 PM
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
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `building` varchar(300) NOT NULL,
  `floor` int(30) NOT NULL,
  `room_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `name`, `building`, `floor`, `room_number`) VALUES
(1, 'Z3.04', 'De Ham', 3, 4),
(2, 'G0.22', 'Kruidtuin', 0, 22),
(3, 'Z3.09', 'De Ham', 3, 9),
(4, 'Z0.10', 'De Ham', 0, 10),
(5, 'G1.26', 'Kruidtuin', 1, 26),
(6, 'G1.25', 'Kruidtuin', 1, 25);

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

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user_1`, `user_2`, `active`) VALUES
(9, 3, 1, 1),
(10, 2, 9, 0);

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

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `conversation_id`, `reaction`, `timestamp`, `message_read`) VALUES
(22, 3, 1, 'hey\r\n', 9, 'Like', '2020-04-24 12:03:51', 0),
(23, 1, 3, 'hallo!', 9, 'HaHa', '2020-04-24 12:04:16', 0),
(24, 1, 3, 'hallo!', 9, 'Like', '2020-04-24 12:21:16', 0),
(25, 1, 3, 'hallo serafima!', 9, 'Love', '2020-04-24 12:28:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `buddy_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profileImg` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `users` (`id`, `buddy_status`, `fullname`, `email`, `password`, `profileImg`, `bio`, `location`, `games`, `music`, `films`, `books`, `study_pref`, `hobby`, `buddy_id`) VALUES
(1, 'mentor', 'Michael Van Lierde', 'michael@student.thomasmore.be', '$2y$10$Fb4BKktLG/oZFiPVQi2RWuHitbfbTJrsYWvSd6z/yBiNXdHZJGngG', 'channing.jpg', 'Hallo, ik ben Michael!', 'Beigem', 'League of Legends', 'Rap', 'Harry Potter', 'World War Z', 'Development', 'Skating', 3),
(2, 'firstyear', 'Jasper Peeters', 'jasper@student.thomasmore.be', '$2y$10$WCT4XCccfLANWuUWYz/dd.w/k.IDMp6F8oKWUfc47UFxt5SSvR1tm', 'koencrucke.jpg', 'Hey ik ben een Jasper!', 'Antwerpen', 'Call Of Duty', 'Pop', 'Harry Potter', 'Narnia', 'Design', 'Soccer', 0),
(3, 'mentor', 'Serafima Yavarouskaya', 'serafima@student.thomasmore.be', '$2y$10$HM1aT7b8lpINWOv0MWf/N.k39CcGca66XpqJbfEC8iZ121PeHYVR6', 'katewinslet.jpg', 'Hey ik ben Serafima!', 'Beigem', 'League of Legends', 'Rap', 'World War Z', 'Narnia', 'Development', 'Skating', 1),
(4, 'mentor', 'Tommy Den Hollander', 'tommy@student.thomasmore.be', '$2y$10$ELiDd4DP7AD8GzwCigvEJOWbFEowSNgEXmBnw1npzBO9XUPml1UP2', 'elonmusk.jpg', 'Hey ik ben tommy', 'Londerzeel', 'Call Of Duty', 'Pop', 'Wolf Of Wall Street', 'Ender\'s Game', 'Undecided', 'Fitness', 10),
(5, 'firstyear', 'Tareq Tahtah', 'tareq@student.thomasmore.be', '$2y$10$6.3OP57jKbGbb.2IGBjkmu5c7hfXpBzR/PHGmdr3opLbV2q1AZjVa', 'robertdowneyjr.jpg', 'Hey ik Tareq', 'Gent', 'Tetris', 'Rock', 'Lord Of The Rings', 'Grote Vriendelijke Reus', 'Design', 'Soccer', 0),
(6, 'mentor', 'Timothy Koenig', 'timothy@student.thomasmore.be', '$2y$10$n7fdwdDHjbejf0HUR3D.Tu8YBpqiLhvubsDCPd01XuT4h9ff5gJJe', 'chrisevans.jpg', 'Hallo ik ben Timothy', 'Gent', 'League of Legends', 'Rock', 'Wolf Of Wall Street', 'The Witcher', 'Design', 'Piano', 0),
(7, 'firstyear', 'Luka Culibrk', 'luka@student.thomasmore.be', '$2y$10$R4hKf3WezhSdSHRs0fzSQuO3W2QvqNjiWgv4QHohxVWHiYNcPVsAG', 'chrishemsworth.jpg', 'Hallo ik ben Luka', 'Aalst', 'Fortnite', 'Jazz', 'Harry Potter', 'Harry Potter', 'Development', 'Soccer', 0),
(8, 'firstyear', 'Lieselotte Philips', 'lieselotte@student.thomasmore.be', '$2y$10$mgdsalkNV3n4oqYUIgjacOUMOCFVdafidrWU83QyXf0x7bNSpXYx6', 'scarlettjohansson.jpg', 'Hi, I\'m Lieselotte', 'Brugge', 'Fortnite', 'Techno', 'Inception', 'The Witcher', 'Undecided', 'Volleyball', 0),
(9, 'firstyear', 'Sam Verdaet', 'sam@student.thomasmore.be', '$2y$10$tcjLC.a9UPzexBbg/R3E6.SAuzJGwlW/OgXpuRE/g0m9c38gVNMfO', 'keiraknightley.jpg', 'Hey, met Sam hier', 'Antwerpen', 'Tetris', 'House', 'Harry Potter', 'Harry Potter', 'Undecided', 'Soccer', 0),
(10, 'mentor', 'Leander Nelissen', 'leander@student.thomasmore.be', '$2y$10$0.Hj8ePbGNY28UntxpdqVuwPYLUUA4zcs0P.xM609qjBskT1SbXPa', 'pewdiepie.jpg', 'Welkom op Leander zijn profiel boys and girls!', 'Hasselt', 'Call Of Duty', 'House', 'Lord Of The Rings', 'The Wheel Of Time', 'Design', 'Fitness', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
