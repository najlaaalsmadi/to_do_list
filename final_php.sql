-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 01, 2024 at 09:41 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `note_id` int NOT NULL AUTO_INCREMENT,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `task_id` int DEFAULT NULL,
  `task_name` varchar(255) NOT NULL,
  `completed` int NOT NULL,
  `activity_date` longtext NOT NULL,
  PRIMARY KEY (`note_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `task_id` (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `note`, `user_id`, `task_id`, `task_name`, `completed`, `activity_date`) VALUES
(5, 'Outgoing delivery of equipment', 10, NULL, '', 0, '12-4-2024'),
(42, 'work', 10, 16, '', 0, '2024-4-1'),
(16, 'Outgoing delivery of equipment(24)', 10, NULL, '', 0, '2024-04-04'),
(45, 'study ch3+ch4', 17, 42, '', 0, '2024-4-27'),
(19, 'study ch3+ch4', 10, 23, '', 0, ''),
(46, 'study ch3+ch4', 18, 43, '', 0, '2024-4-25'),
(23, 'Outgoing delivery of equipment', 10, NULL, '', 0, '2024-04-04'),
(24, 'Outgoing delivery of equipment (222)', 10, NULL, '', 0, '2024-04-03'),
(30, 'Personal Affairs2024', 10, NULL, '', 0, '2024-1-8'),
(43, 'Outgoing delivery of equipment', 10, 26, '', 0, '2024-3-30'),
(28, 'Personal Affairs', 10, NULL, '', 0, '2024-1-16'),
(29, 'Personal Affairs123', 10, NULL, '', 0, '2024-1-14');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `task_id` int NOT NULL AUTO_INCREMENT,
  `task_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `createdon` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(255) NOT NULL,
  `priority` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`task_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `createdon`, `description`, `priority`, `status`, `user_id`) VALUES
(21, 'work', '2024-03-31', 'Submit the final design\r\n', 0, '', 7),
(22, 'work', '2024-3-31', 'Job delivery', 0, '', 4),
(35, 'study', '2024-04-01', 'Study php+css', 0, '', 16),
(24, 'work', '2024-04-01', 'Job delivery', 0, '', 10),
(20, 'personal affairs', '2024-03-30', 'Cooking for Ramadan breakfast', 0, '', 7),
(18, 'work', '2024-3-30', 'Job delivery', 0, '', 12),
(19, 'work', '2024-3-30', 'Job delivery', 0, '', 7),
(16, 'Personal Affairs', '2024-03-31', 'Cook Ramadan breakfast', 0, '', 10),
(17, 'work', '2024-03-31', 'Job delivery code\r\n', 1, '', 10),
(14, 'study', '2024-2-29', 'bootstrap review study', 1, '', 10),
(12, 'work', '2024-03-30', 'Make an inventory', 1, '', 10),
(15, 'Personal Affairs', '2024-3-13', 'Work on arranging the rooms', 1, '', 10),
(13, 'work', '2024-3-27', 'Create a Notifications page', 1, '', 10),
(25, 'work', '2024-04-01', 'Job delivery php', 0, '', 10),
(26, 'study', '2024-04-01', 'Study php+mysql', 0, '', 10),
(27, 'study', '2024-04-01', 'Study php+mysql+bootstrap ', 1, '', 10),
(29, 'study', '2024-04-1', 'Study php+mysql+bootstrap', 0, '', 10),
(30, 'study', '2024-04-01', 'Study php+bootstrap', 0, '', 10),
(31, 'study', '2024-04-02', 'Study php+bootstrap', 0, '', 14),
(32, 'study', '2024-03-31', 'Study php', 0, '', 10),
(33, 'study', '2024-04-02', 'Study php+html', 0, '', 15),
(36, 'study', '2024-03-31', 'Study php+css+html', 0, '', 16),
(37, 'work', '2024-03-30', 'Study php+css+html', 0, '', 16),
(39, 'work', '2024-04-01', 'Study php+css+html', 0, '', 17),
(40, 'work', '2024-03-31', 'Job delivery', 0, '', 17),
(41, 'work', '2024-04-01', 'Outgoing delivery of equipment', 0, '', 17),
(42, 'study', '2024-03-31', 'Study php+css+html', 0, '', 17),
(43, 'study', '2024-04-01', 'Study php+css', 0, '', 18),
(44, 'work', '2024-03-31', 'Job delivery', 0, '', 18),
(45, 'Personal Affairs', '2024-03-31', 'Job delivery', 0, '', 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `md5_pass` varchar(32) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birthday` varchar(11) NOT NULL,
  `profile_picture` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `md5_pass`, `gender`, `birthday`, `profile_picture`) VALUES
(1, 'naser12', 'naser12@gmail.com', 'naser12', 'c8a7770428c81997d44c65cf5d7e089f', 'Male', '2004-12-21', ''),
(4, 'najlaa321', '22018086304@std.bau.edu.jo', '12312312321', 'aae77dd310a3d99c13ac36b042c934ee', 'Female', '2006-12-21', '65ff68ecea2ea3.85247128.png'),
(9, 'ali1999', 'ali1999@gmail.com', 'ali1999', '9e03e647eb00b5e19b01e6c99b953c1d', 'Male', '1999-4-18', 'imgmale.jpeg'),
(8, 'adam2005', 'adam2005@gmail.com', 'adam2005', '4510c441df3973b68c6b838d66f05474', 'Male', '2007-12-20', 'imgimg1.png'),
(7, 'najlaak399', 'najlaak399@gmail.com', 'najlaak399', '9f4f48bac1cb589bea377b362328428e', 'Female', '1998-6-9', '66086d945fde00.54002456.jpeg'),
(10, 'hani2005', 'hani2005@gmail.com', 'hani2005', 'b2c11e27a2cee50d9f2f30fb7dada539', 'Male', '2005-9-19', '660b20b48c0907.00765413.png'),
(11, 'aya2004', 'aya2004@gmail.com', 'aya2004', '61417034b326add28dec9217615ca9ba', 'Female', '2004-12-1', 'female.jpeg'),
(13, 'hani2007', 'hani2007@gmail.com', 'hani2007', '6d935199fe308d1399df41f6dab32d7e', 'Male', '2007-2-1', 'male.jpeg'),
(15, 'rana2000', 'rana2000@gmail.com', 'rana2000', '4917675325ab89f2e304b70b42e5fbb4', 'Female', '2000-6-9', 'female.jpeg'),
(16, 'Aya2000', 'Aya2000@gmail.com', 'Aya2000', '095212852b58b59eb8bc99994edb3d50', 'Female', '2000-6-9', 'female.jpeg'),
(17, 'najlaakk1998', 'najlaakk1998@gmail.com', 'najlaakk1998', '8b68e9ab28193fb58796dde0e61cc4d3', 'Female', '1998-6-9', 'female.jpeg'),
(18, 'hala123', 'hala123@gmail.com', 'hala123', '8a4a5bde22c54162d0e4c0b8e5f37c35', 'Female', '2004-9-16', '660b2824694d11.50499650.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
