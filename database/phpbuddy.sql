-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 05 apr 2020 om 17:02
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
-- Tabelstructuur voor tabel `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL
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
  `chat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
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
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `buddy_status`, `fullname`, `email`, `password`, `profileImg`, `bio`, `location`, `games`, `music`, `films`, `books`, `study_pref`, `hobby`, `buddy_id`) VALUES
(4, 'mentor', 'Michael Van Lierde', 'r0469610@student.thomasmore.be', '$2y$10$JxIjM33SmEe/PdsI5gHFv.Ed.AGLi2vozIfVYDv/EwAxe2b2xjqTW', 'wizardmichael.png', 'Hello I\'m Michael!', 'Beigem', 'League of Legends', 'Rock', 'Lord of the Rings', '', 'design', 'Ice Skating', 6),
(6, '', 'tommy', 'tommay@student.thomasmore.be', '$2y$10$bw8mGxnQOD4WOQ6lnrSXM.ll5CXHQYfEPJqGQL19Do5biRmAoBcK2', '', '', '', '', '', '', '', '', '', 4),
(7, '', 'Jasper', 'jasper@student.thomasmore.be', '$2y$10$805ejZ/R6WxZXppviKsOgufcwGSznKzn13G4g2wcnE7SpMbLZt/vG', '', '', '', '', '', '', '', '', '', 8),
(8, '', 'Serafima', 'sera@student.thomasmore.be', '$2y$10$EG.32pWnLY2AKIzzPn91A.pojSJ.nxAnVltg1LiOVXpXOeaz3jII2', '', '', '', '', '', '', '', '', '', 7);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
