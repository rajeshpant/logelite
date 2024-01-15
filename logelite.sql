-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 05:34 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logelite`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0 => Inactive, 1=> Active',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'Admin', 1, '2024-01-13 22:36:00', '2024-01-14 11:05:13'),
(2, 'Manager', 1, '2024-01-13 23:18:15', '2024-01-13 23:18:15'),
(3, 'Employee', 1, '2024-01-14 10:50:47', '2024-01-14 10:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` tinyint(2) UNSIGNED NOT NULL COMMENT '1 => High, 2 => Normal, 3 => Low',
  `due_date` date NOT NULL,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0=> Pending, 1 => Complete, 2=> In Progress,3 => Hold,  4 => Closed  ',
  `comment` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `priority`, `due_date`, `status`, `comment`, `file`, `created`, `modified`) VALUES
(1, 'Test', 'This is test task', 1, '2024-02-12', 1, NULL, NULL, '2024-01-14 16:44:58', '2024-01-15 08:38:44'),
(2, 'Test', 'This is test task', 1, '2024-02-12', 1, NULL, NULL, '2024-01-14 16:46:10', '2024-01-15 08:39:13'),
(3, 'Test', 'This is test task', 1, '2024-02-12', 1, 'sdasd asd asd asd asd asd asd', '20240115051635_2022-12-04 (1).png', '2024-01-14 16:48:36', '2024-01-15 09:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '0 => Inactive, 1=> Active	',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `status`, `created`, `modified`) VALUES
(1, 'Test', 1, '2024-01-14 15:13:46', '2024-01-14 18:17:28'),
(3, 'Team 1', 1, '2024-01-14 16:40:52', '2024-01-14 16:40:52'),
(4, 'Team 2', 1, '2024-01-14 16:40:57', '2024-01-14 16:40:57'),
(5, 'dasdasda', 1, '2024-01-14 18:13:55', '2024-01-14 18:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `user_id`, `team_id`) VALUES
(1, 2, 5),
(2, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `team_tasks`
--

CREATE TABLE `team_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_tasks`
--

INSERT INTO `team_tasks` (`id`, `team_id`, `task_id`) VALUES
(1, 1, 3),
(7, 4, 3),
(8, 4, 2),
(9, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` tinyint(1) UNSIGNED NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '0 => Inactive, 1=> Active	',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `gender`, `password`, `role_id`, `status`, `created`, `modified`) VALUES
(1, 'admin', 'admin@admin.com', 'Male', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, '2024-01-14 12:16:40', '2024-01-14 12:48:36'),
(2, 'manager', 'manager@manager.com', 'Female', 'e10adc3949ba59abbe56e057f20f883e', 2, 1, '2024-01-14 12:46:40', '2024-01-14 12:56:00'),
(5, 'dasda', 'dsasd@gggg.com', 'Male', 'e10adc3949ba59abbe56e057f20f883e', 3, 1, '2024-01-14 18:09:56', '2024-01-14 18:09:56'),
(6, 'sdfsdfsd', 'sdsadas@jjj.com', 'Female', 'e10adc3949ba59abbe56e057f20f883e', 3, 1, '2024-01-14 18:10:16', '2024-01-14 18:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_role_access`
--

CREATE TABLE `user_role_access` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` tinyint(2) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `is_access` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => No , 1=> Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role_access`
--

INSERT INTO `user_role_access` (`id`, `role_id`, `action`, `is_access`) VALUES
(1, 1, 'user_list', 1),
(2, 1, 'user_add', 1),
(3, 1, 'edit_user', 1),
(4, 1, 'User_status', 1),
(5, 1, 'user_delete', 1),
(6, 1, 'add_team', 1),
(7, 1, 'team_list', 1),
(8, 1, 'team_edit', 1),
(9, 1, 'delete_team', 1),
(10, 1, 'add_task', 1),
(11, 1, 'task_list', 1),
(12, 1, 'task_edit', 1),
(13, 1, 'delete_task', 1),
(14, 1, 'assign_user_team', 1),
(15, 1, 'remove_user_team', 1),
(16, 1, 'assign_team_task', 1),
(17, 1, 'remove_team_task', 1),
(18, 2, 'user_list', 1),
(19, 2, 'team_list', 0),
(20, 2, 'add_task', 0),
(21, 2, 'task_list', 0),
(22, 2, 'assign_user_team', 0),
(23, 2, 'remove_team_task', 0),
(24, 3, 'user_list', 0),
(25, 3, 'user_add', 0),
(26, 3, 'edit_user', 0),
(27, 3, 'User_status', 0),
(28, 3, 'user_delete', 0),
(29, 3, 'add_team', 0),
(30, 3, 'team_list', 0),
(31, 3, 'team_edit', 0),
(32, 3, 'delete_team', 0),
(33, 3, 'add_task', 0),
(34, 3, 'task_list', 1),
(35, 3, 'task_edit', 0),
(36, 3, 'delete_task', 0),
(37, 3, 'assign_user_team', 0),
(38, 3, 'remove_user_team', 0),
(39, 3, 'assign_team_task', 0),
(40, 3, 'remove_team_task', 0),
(41, 3, 'user_list', 0),
(42, 3, 'user_add', 0),
(43, 3, 'edit_user', 0),
(44, 3, 'User_status', 0),
(45, 3, 'user_delete', 0),
(46, 3, 'add_team', 0),
(47, 3, 'team_list', 0),
(48, 3, 'team_edit', 0),
(49, 3, 'delete_team', 0),
(50, 3, 'add_task', 0),
(51, 3, 'task_list', 1),
(52, 3, 'task_edit', 0),
(53, 3, 'delete_task', 0),
(54, 3, 'assign_user_team', 0),
(55, 3, 'remove_user_team', 0),
(56, 3, 'assign_team_task', 0),
(57, 3, 'remove_team_task', 0),
(58, 2, 'user_list', 0),
(59, 2, 'user_add', 0),
(60, 2, 'edit_user', 0),
(61, 2, 'User_status', 0),
(62, 2, 'user_delete', 0),
(63, 2, 'add_team', 1),
(64, 2, 'team_list', 0),
(65, 2, 'team_edit', 1),
(66, 2, 'delete_team', 0),
(67, 2, 'add_task', 0),
(68, 2, 'task_list', 0),
(69, 2, 'task_edit', 1),
(70, 2, 'delete_task', 0),
(71, 2, 'assign_user_team', 0),
(72, 2, 'remove_user_team', 1),
(73, 2, 'assign_team_task', 1),
(74, 2, 'remove_team_task', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `team_tasks`
--
ALTER TABLE `team_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_role_access`
--
ALTER TABLE `user_role_access`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `team_tasks`
--
ALTER TABLE `team_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role_access`
--
ALTER TABLE `user_role_access`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
