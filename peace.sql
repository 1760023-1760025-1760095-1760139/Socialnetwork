-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 23, 2019 lúc 10:57 AM
-- Phiên bản máy phục vụ: 10.4.6-MariaDB
-- Phiên bản PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `peace`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 2, 1, 'helllo', '2019-01-01 04:42:06', 0),
(2, 1, 2, 'how are you', '2019-01-01 04:42:45', 0),
(3, 2, 1, 'i am fine,thanks you', '2019-01-01 04:43:01', 0),
(4, 1, 2, 'hì hì', '2019-01-01 04:43:11', 0),
(5, 1, 16, 'con cho', '2019-01-02 05:13:29', 1),
(6, 1, 16, 'con chos nhata', '2019-01-02 05:14:15', 1),
(7, 1, 16, 'tests', '2019-01-02 05:14:32', 1),
(8, 1, 16, 'hello', '2019-01-02 05:14:52', 1),
(9, 16, 17, 'hello phuong', '2019-01-02 06:20:20', 0),
(10, 46, 45, 'alo ????', '2019-12-13 16:45:59', 0),
(11, 45, 46, 'oke', '2019-12-13 16:46:26', 0),
(12, 46, 45, 'tam duoc \n\n', '2019-12-13 16:46:40', 0),
(13, 46, 45, '????????????????\n\n\n\n', '2019-12-14 07:20:25', 1),
(14, 52, 51, 'aaaaaaaaaa', '2019-12-15 05:58:01', 0),
(15, 52, 51, '????????????', '2019-12-15 05:58:07', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `body`, `created_at`, `updated_at`) VALUES
(105, 16, 14, 'A little,but not very well', '2018-12-31 12:06:31', NULL),
(106, 16, 14, 'olala', '2018-12-31 12:34:55', NULL),
(104, 16, 14, 'calm down', '2018-12-30 11:14:20', NULL),
(103, 16, 14, 'there is a fire', '2018-12-30 11:03:37', NULL),
(102, 16, 14, 'there is a fire', '2018-12-30 11:03:01', NULL),
(101, 16, 14, 'hehe', '2018-12-29 15:00:39', NULL),
(100, 16, 14, 'I am student', '2018-12-29 14:51:48', NULL),
(107, 16, 14, 'cà phê', '2018-12-31 12:40:11', NULL),
(108, 16, 14, 'Con chó nhật', '2018-12-31 12:41:36', NULL),
(109, 16, 14, 'test comment', '2018-12-31 12:43:16', NULL),
(110, 16, 14, 'how', '2018-12-31 12:44:38', NULL),
(111, 16, 14, 'thế đéo nào comment ngon lành mà', '2018-12-31 12:49:12', NULL),
(112, 16, 14, 'Con chó nhật', '2018-12-31 19:26:02', NULL),
(113, 39, 60, 'hehe', '2019-01-02 09:42:43', NULL),
(114, 39, 61, 'hello', '2019-01-02 16:57:35', NULL),
(115, 39, 62, 'như này chứ gì', '2019-01-02 22:58:13', NULL),
(116, 45, 65, 'nhat\n', '2019-12-13 23:32:53', NULL),
(117, 45, 65, 'nhat\n', '2019-12-13 23:33:19', NULL),
(118, 45, 67, 'adada', '2019-12-13 23:57:17', NULL),
(119, 45, 68, 'dadad', '2019-12-14 00:09:01', NULL),
(120, 46, 69, 'hello', '2019-12-14 00:11:00', NULL),
(121, 45, 68, 'dadadad', '2019-12-14 00:11:24', NULL),
(122, 45, 68, 'dadadada', '2019-12-14 00:11:42', NULL),
(123, 45, 68, 'dadadada', '2019-12-14 00:11:45', NULL),
(124, 45, 68, 'dadadada', '2019-12-14 00:11:45', NULL),
(125, 52, 73, 'dddd', '2019-12-15 12:59:08', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 1, '2019-01-01 06:37:56', 'no'),
(2, 2, '2019-01-01 06:38:04', 'no'),
(3, 29, '2019-01-02 04:58:17', 'no'),
(4, 39, '2019-01-02 04:58:49', 'yes');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `privacy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`id`, `userId`, `content`, `createdAt`, `privacy`) VALUES
(60, 39, '23456iop', '2018-12-27 15:47:29', 1),
(61, 39, 'llaalal', '2019-01-02 10:29:18', 1),
(62, 39, 'hello', '2019-01-02 20:51:03', 1),
(63, 29, 'dog', '2019-01-02 23:07:18', 1),
(64, 45, 'dadad', '2019-12-13 23:32:39', 1),
(65, 45, 'addada', '2019-12-13 23:32:43', 1),
(66, 46, 'dâdâda', '2019-12-13 23:41:12', 1),
(67, 46, 'đâ', '2019-12-13 23:41:15', 1),
(68, 46, 'adâd', '2019-12-13 23:41:17', 1),
(69, 46, 'status only me ', '2019-12-13 23:49:27', 3),
(70, 45, 'status only nhi nguyen ', '2019-12-13 23:50:12', 3),
(71, 45, ';;;', '2019-12-14 00:12:52', 1),
(72, 51, 'vyugiu', '2019-12-15 12:51:18', 1),
(73, 51, 'bb', '2019-12-15 12:51:43', 2),
(74, 51, 'ppp', '2019-12-15 12:52:01', 3),
(75, 51, 'đại chó điên', '2019-12-15 13:08:07', 2),
(76, 51, 'mọi ngơời', '2019-12-15 13:12:07', 1),
(77, 51, 'ban bè', '2019-12-15 13:12:17', 2),
(78, 51, 'chi mình toi', '2019-12-15 13:12:35', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rating_info`
--

CREATE TABLE `rating_info` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating_action` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `rating_info`
--

INSERT INTO `rating_info` (`post_id`, `user_id`, `rating_action`) VALUES
(10, 1, 'dislike'),
(9, 1, 'like'),
(11, 1, 'like'),
(11, 16, 'like'),
(10, 16, 'dislike'),
(12, 16, 'like'),
(55, 39, 'dislike'),
(54, 39, 'like'),
(53, 39, 'like'),
(52, 39, 'like'),
(56, 39, 'like'),
(60, 39, 'like'),
(61, 39, 'like'),
(62, 39, 'dislike'),
(65, 45, 'like'),
(68, 45, 'like'),
(66, 45, 'like'),
(71, 45, 'like');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `relationship`
--

CREATE TABLE `relationship` (
  `user1Id` int(11) NOT NULL,
  `user2Id` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Đang đổ dữ liệu cho bảng `replies`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `resetpassword`
--

CREATE TABLE `resetpassword` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `used` int(11) NOT NULL,
  `createAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `verifyemail`
--

CREATE TABLE `verifyemail` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `secret` varchar(10) NOT NULL,
  `code` varchar(6) NOT NULL,
  `used` int(11) NOT NULL,
  `createAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `creator` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `collection_link` varchar(255) NOT NULL,
  `createAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Chỉ mục cho bảng `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rating_info`
--
ALTER TABLE `rating_info`
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`);

--
-- Chỉ mục cho bảng `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`user1Id`,`user2Id`);

--
-- Chỉ mục cho bảng `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `resetpassword`
--
ALTER TABLE `resetpassword`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `verifyemail`
--
ALTER TABLE `verifyemail`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT cho bảng `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `resetpassword`
--
ALTER TABLE `resetpassword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `verifyemail`
--
ALTER TABLE `verifyemail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
