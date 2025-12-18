-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 09:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `game_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`user_id`, `username`, `password`) VALUES
(1, 'user', '$2y$10$ze13Oni5KYO9QytfVyFh8OuClqUbu5Yb65gPSGHZ6JpgVnonQmsIW'),
(2, 'jsmith89', '$2y$10$lKDha1xtu9TsOecL3uvLieo8CguPLE33sIhR6enCaY2ZpqStgnusa'),
(3, 'chloex', '$2y$10$xFGQgi/FLzqO48xIK7/P8..JrmG/hAJtqNppLwep4taCKEDVceaky'),
(4, 'alexR', '$2y$10$Lq7ThY8biy9JSJHHtgr.Q.e48.l6s08kyzsV6U0sREXuh.Q62Kkkq'),
(5, 'aminaK', '$2y$10$ErFew5OaRWbQvHwJ2T7MdOExJHFQcd.hwWirjF0CIPIvyZkR89Liy'),
(6, 'travelDan', '$2y$10$GDSzAFyFLgsne2Q.Kr9dDOue5lSOnDL.clGHOFzLNZrdtWpcd6b0C'),
(7, 'samwise', '$2y$10$X6fdthBBnVhLRYFUe9vQX.AAj7YNY5Tl465ijKBPq6QzeHgeQDeG2');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `name`) VALUES
(1, 'Tic-Tac-Toe'),
(2, 'Snake'),
(3, 'Neat Nine'),
(4, 'Matching'),
(5, 'Connect-4'),
(6, '2048'),
(7, 'Finance!'),
(8, 'Mine Sweeper'),
(9, 'Simon Says');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `score_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`score_id`, `user_id`, `game_id`, `score`, `created_at`) VALUES
(1, 2, 1, 9, '2025-12-18 06:27:47'),
(2, 2, 5, 7, '2025-12-18 06:28:01'),
(3, 2, 2, 90, '2025-12-18 06:28:32'),
(4, 2, 6, 1436, '2025-12-18 06:28:55'),
(5, 2, 9, 7, '2025-12-18 06:29:48'),
(6, 3, 4, 29, '2025-12-18 06:31:39'),
(7, 3, 3, 22, '2025-12-18 06:32:11'),
(8, 3, 8, 69, '2025-12-18 07:18:47'),
(9, 3, 7, 2300, '2025-12-18 07:20:13'),
(10, 3, 6, 2144, '2025-12-18 07:20:59'),
(11, 4, 1, 7, '2025-12-18 07:22:00'),
(12, 4, 5, 13, '2025-12-18 07:22:18'),
(13, 4, 3, 60, '2025-12-18 07:23:18'),
(14, 4, 9, 5, '2025-12-18 07:23:45'),
(15, 4, 2, 40, '2025-12-18 07:24:01'),
(16, 5, 4, 33, '2025-12-18 07:25:19'),
(17, 5, 7, 1250, '2025-12-18 07:26:42'),
(18, 5, 9, 3, '2025-12-18 07:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default.jpg',
  `full_name` varchar(100) NOT NULL,
  `gender` enum('male','female','prefer_not_to_say') NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `time_zone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `profile_picture`, `full_name`, `gender`, `date_of_birth`, `email`, `phone_number`, `time_zone`) VALUES
(1, 'default.jpg', 'Hafiz Farooq Ahmad', 'male', '1998-03-12', 'hfahmad@kfu.edu.sa', '013589-9228', 'UTC+3'),
(2, 'default.jpg', 'John Smith', 'male', '1989-05-15', 'john.smith@mailservice.com', '+44 7700 900123', 'UTC+0'),
(3, 'default.jpg', 'Chloe Chen', 'female', '1995-11-22', '', '+1 (555) 123-4567', 'UTC-5'),
(4, 'default.jpg', 'Alex Rodriguez', 'prefer_not_to_say', '2001-08-03', 'a.rodriguez@webmail.net', '', 'UTC-8'),
(5, 'default.jpg', 'Amina Khan', 'female', '1982-01-30', 'amina.k@business.org', '+971 50 123 4567', 'UTC+4'),
(6, 'default.jpg', 'Daniel Brown', 'male', '1976-07-14', 'dan.brown@fastmail.co', '+61 412 345 678', 'UTC+10'),
(7, 'default.jpg', 'Sam Wilson', 'prefer_not_to_say', '1999-12-10', 'sam.w@example.com', '+44 7911 112233', 'UTC+0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`score_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
