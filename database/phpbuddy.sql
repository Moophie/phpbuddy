-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 03 mei 2020 om 22:43
-- Serverversie: 10.4.11-MariaDB
-- PHP-versie: 7.4.2

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
-- Tabelstructuur voor tabel `classrooms`
--

CREATE TABLE `classrooms` (
  `id` int(11) NOT NULL,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `building` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` int(30) NOT NULL,
  `room_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `building`, `floor`, `room_number`) VALUES
(1, 'Z3.04', 'De Ham', 3, 4),
(2, 'G0.22', 'Kruidtuin', 0, 22),
(3, 'Z3.09', 'De Ham', 3, 9),
(4, 'Z0.10', 'De Ham', 0, 10),
(5, 'G1.26', 'Kruidtuin', 1, 26),
(6, 'G1.25', 'Kruidtuin', 1, 25);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `conversations`
--

INSERT INTO `conversations` (`id`, `user_1`, `user_2`, `active`) VALUES
(6, 2, 5, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `events`
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
-- Tabelstructuur voor tabel `messages`
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
-- Gegevens worden geëxporteerd voor tabel `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `conversation_id`, `reaction`, `timestamp`, `message_read`) VALUES
(12, 2, 5, 'Hallo', 6, '', '2020-05-03 22:42:39', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `op` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  `content` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faq` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL,
  `upvotes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `upvotes`
--

CREATE TABLE `upvotes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `validation_string` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `active`, `validation_string`, `buddy_status`, `fullname`, `email`, `password`, `profileImg`, `bio`, `location`, `games`, `music`, `films`, `books`, `study_pref`, `hobby`, `buddy_id`) VALUES
(1, 1, '', 'mentor', 'Michael Van Lierde', 'michael@student.thomasmore.be', '$2y$10$Fb4BKktLG/oZFiPVQi2RWuHitbfbTJrsYWvSd6z/yBiNXdHZJGngG', 'channing.jpg', 'Hallo, ik ben Michael!', 'Beigem', 'League of Legends', 'Rap', 'Harry Potter', 'World War Z', 'Development', 'Skating', 0),
(2, 1, '', 'firstyear', 'Jasper Peeters', 'jasper@student.thomasmore.be', '$2y$10$WCT4XCccfLANWuUWYz/dd.w/k.IDMp6F8oKWUfc47UFxt5SSvR1tm', 'koencrucke.jpg', 'Hey ik ben een Jasper!', 'Antwerpen', 'Call Of Duty', 'Pop', 'Harry Potter', 'Narnia', 'Design', 'Soccer', 5),
(3, 1, '', 'mentor', 'Serafima Yavarouskaya', 'serafima@student.thomasmore.be', '$2y$10$HM1aT7b8lpINWOv0MWf/N.k39CcGca66XpqJbfEC8iZ121PeHYVR6', 'katewinslet.jpg', 'Hey ik ben Serafima!', 'Beigem', 'League of Legends', 'Rap', 'World War Z', 'Narnia', 'Development', 'Skating', 0),
(4, 1, '', 'mentor', 'Tommy Den Hollander', 'tommy@student.thomasmore.be', '$2y$10$ELiDd4DP7AD8GzwCigvEJOWbFEowSNgEXmBnw1npzBO9XUPml1UP2', 'elonmusk.jpg', 'Hey ik ben tommy', 'Londerzeel', 'Call Of Duty', 'Pop', 'Wolf Of Wall Street', 'Ender\'s Game', 'Undecided', 'Fitness', 0),
(5, 1, '', 'firstyear', 'Tareq Tahtah', 'tareq@student.thomasmore.be', '$2y$10$6.3OP57jKbGbb.2IGBjkmu5c7hfXpBzR/PHGmdr3opLbV2q1AZjVa', 'robertdowneyjr.jpg', 'Hey ik Tareq', 'Gent', 'Tetris', 'Rock', 'Lord Of The Rings', 'Grote Vriendelijke Reus', 'Design', 'Soccer', 0),
(6, 1, '', 'mentor', 'Timothy Koenig', 'timothy@student.thomasmore.be', '$2y$10$n7fdwdDHjbejf0HUR3D.Tu8YBpqiLhvubsDCPd01XuT4h9ff5gJJe', 'chrisevans.jpg', 'Hallo ik ben Timothy', 'Gent', 'League of Legends', 'Rock', 'Wolf Of Wall Street', 'The Witcher', 'Design', 'Piano', 0),
(7, 1, '', 'firstyear', 'Luka Culibrk', 'luka@student.thomasmore.be', '$2y$10$R4hKf3WezhSdSHRs0fzSQuO3W2QvqNjiWgv4QHohxVWHiYNcPVsAG', 'chrishemsworth.jpg', 'Hallo ik ben Luka', 'Aalst', 'Fortnite', 'Jazz', 'Harry Potter', 'Harry Potter', 'Development', 'Soccer', 0),
(8, 1, '', 'firstyear', 'Lieselotte Philips', 'lieselotte@student.thomasmore.be', '$2y$10$mgdsalkNV3n4oqYUIgjacOUMOCFVdafidrWU83QyXf0x7bNSpXYx6', 'scarlettjohansson.jpg', 'Hi, I\'m Lieselotte', 'Brugge', 'Fortnite', 'Techno', 'Inception', 'The Witcher', 'Undecided', 'Volleyball', 0),
(9, 1, '', 'firstyear', 'Sam Verdaet', 'sam@student.thomasmore.be', '$2y$10$tcjLC.a9UPzexBbg/R3E6.SAuzJGwlW/OgXpuRE/g0m9c38gVNMfO', 'keiraknightley.jpg', 'Hey, met Sam hier', 'Antwerpen', 'Tetris', 'House', 'Harry Potter', 'Harry Potter', 'Undecided', 'Soccer', 0),
(10, 1, '', 'mentor', 'Leander Nelissen', 'leander@student.thomasmore.be', '$2y$10$0.Hj8ePbGNY28UntxpdqVuwPYLUUA4zcs0P.xM609qjBskT1SbXPa', 'pewdiepie.jpg', 'Welkom op Leander zijn profiel boys and girls!', 'Hasselt', 'Call Of Duty', 'House', 'Lord Of The Rings', 'The Wheel Of Time', 'Design', 'Fitness', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_events`
--

CREATE TABLE `users_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `upvotes`
--
ALTER TABLE `upvotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users_events`
--
ALTER TABLE `users_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `upvotes`
--
ALTER TABLE `upvotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users_events`
--
ALTER TABLE `users_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
