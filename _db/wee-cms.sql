-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2021 at 05:50 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wee-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `uICxZ0_users`
--

CREATE TABLE `uICxZ0_users` (
  `user_id` int(11) UNSIGNED NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(254) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `user_access_level` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'user''s access level (between 0 and 255, 255 = administrator)',
  `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attemps',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_registration_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_registration_ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Dumping data for table `uICxZ0_users`
--

INSERT INTO `uICxZ0_users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `user_access_level`, `user_active`, `user_activation_hash`, `user_password_reset_hash`, `user_password_reset_timestamp`, `user_failed_logins`, `user_last_failed_login`, `user_registration_datetime`, `user_registration_ip`) VALUES
(1, 'WeeCMSAdmin', '$2y$10$kYk2D9RRmnUK9og1Ru6VSuIlGg38iRdQ9UOVm.9/9bFLUrueB18EK', 'admin@weeCMS.wayoutofline.net', 9, 1, NULL, NULL, NULL, 0, NULL, '2017-05-10 16:45:59', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `uICxZ0_user_connections`
--

CREATE TABLE `uICxZ0_user_connections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_rememberme_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_last_visit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_last_visit_agent` text COLLATE utf8_unicode_ci,
  `user_login_ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `user_login_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_login_agent` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='authenticated user data';

-- --------------------------------------------------------

--
-- Table structure for table `uICxZ0_WeeCMS_pages`
--

CREATE TABLE `uICxZ0_WeeCMS_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_de` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `content_de` text NOT NULL,
  `access_level` tinyint(4) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `description_de` text NOT NULL,
  `keywords` text NOT NULL,
  `keywords_de` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uICxZ0_WeeCMS_pages`
--

INSERT INTO `uICxZ0_WeeCMS_pages` (`id`, `title`, `title_de`, `content`, `content_de`, `access_level`, `description`, `description_de`, `keywords`, `keywords_de`) VALUES
(1, 'Start', 'Start', '<div>Welcome to weeCMS :)</div><div><br></div><img src="img/weeCMS-logo-L.png" alt="WeeCMS Logo" align="none"><div><br></div>', '<div>Willkommen zu weeCMS :)</div><div><br></div><img src="img/weeCMS-logo-L.png" alt="WeeCMS Logo" align="none"><br>', 0, 'weeCMS - a wee Content \r\nManagement System for site \r\nadmins, web developers and \r\neditors', 'weeCMS - Ein winziges \r\nContent-Management-System fuer Site-Admins, \r\nWeb-Developer und \r\nEditoren', 'CMS, wee', 'CMS, winzig'),
(2, 'About', '', '<div><b style="color: inherit; font-size: 1.9375rem;"><font size="6" face="impact">Y E A H !</font></b><br></div><div><font face="courier new"><b><br><br>weeCMS</b>&nbsp;<br>a wee Content Management System for site admins, web developers and editors. <br></font></div>', '<div><b style="color: inherit; font-size: 1.9375rem;"><font size="6" face="impact">Y E A H !</font></b><br></div><div><font face="courier new"><b><br><br>weeCMS</b>&nbsp;<br>ein winziges Content-Management-System für Site-Admins, Web-Entwickler und Editoren. <br></font></div>', 9, '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `uICxZ0_users`
--
ALTER TABLE `uICxZ0_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `uICxZ0_user_connections`
--
ALTER TABLE `uICxZ0_user_connections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uICxZ0_WeeCMS_pages`
--
ALTER TABLE `uICxZ0_WeeCMS_pages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uICxZ0_users`
--
ALTER TABLE `uICxZ0_users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `uICxZ0_user_connections`
--
ALTER TABLE `uICxZ0_user_connections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `uICxZ0_WeeCMS_pages`
--
ALTER TABLE `uICxZ0_WeeCMS_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
