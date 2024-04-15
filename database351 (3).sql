-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2024 at 12:49 AM
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
-- Database: `database351`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `AccountID` int(11) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `EventID` int(11) NOT NULL,
  `Location` varchar(45) DEFAULT NULL,
  `EventName` varchar(45) NOT NULL,
  `EventDate` date NOT NULL,
  `EventDescription` varchar(45) DEFAULT NULL,
  `LOCATION_LocationID` int(11) NOT NULL,
  `ACCOUNT_AccountID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `user_id` int(20) NOT NULL,
  `friend_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`user_id`, `friend_id`) VALUES
(147571, 355334949);

-- --------------------------------------------------------

--
-- Table structure for table `job_listings`
--

CREATE TABLE `job_listings` (
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_listings`
--

INSERT INTO `job_listings` (`job_id`, `job_title`, `company`, `description`, `contact_email`, `date_posted`) VALUES
(1, 'test', 'test', 'test', 'test@test.test', '2024-04-08 04:18:39'),
(2, 'test', 'test', 'test', 'test@test.test', '2024-04-08 04:23:42'),
(3, 'hi', 'hi', 'hi', 'hi@test.com', '2024-04-15 16:15:04'),
(4, 'womp', 'womp', 'womp womp', 'womp@womp.com', '2024-04-15 16:31:54');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LocationID` int(11) NOT NULL,
  `LocationName` varchar(45) NOT NULL,
  `LocationAddress` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LocationID`, `LocationName`, `LocationAddress`) VALUES
(1, 'Luter', ''),
(2, 'Forbes', ''),
(3, 'McMurran', ''),
(4, 'Torggler', ''),
(5, 'Trible Library', ''),
(6, 'DSU', ''),
(7, 'David Student Union', ''),
(8, 'Ferguson', '');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `FrienderID` int(11) NOT NULL,
  `Friendee` int(11) NOT NULL,
  `Message DATE/TIME` date NOT NULL,
  `Message Sender` varchar(45) DEFAULT NULL,
  `Message Reciever` varchar(45) DEFAULT NULL,
  `ACCOUNT_AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network`
--

CREATE TABLE `network` (
  `FrienderID` int(11) NOT NULL,
  `FriendeeID` int(11) NOT NULL,
  `NetworkName` varchar(45) NOT NULL,
  `NetworkDescription` varchar(45) NOT NULL,
  `ACCOUNT_AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `NewsletterID` int(11) NOT NULL,
  `Account` int(11) NOT NULL,
  `NewsletterName` varchar(45) NOT NULL,
  `NewsletterDescription` varchar(200) NOT NULL,
  `ACCOUNT_AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` int(11) NOT NULL,
  `Post_Title` varchar(45) NOT NULL,
  `Post_Content` varchar(45) NOT NULL,
  `Date_Posted` date NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `Image_Path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `Post_Title`, `Post_Content`, `Date_Posted`, `user_id`, `Image_Path`) VALUES
(10, 'hi', 'hi', '2024-04-15', 147571, ''),
(11, 'hel', 'hel', '2024-04-15', 147571, ''),
(12, 'Pain', 'Pain', '2024-04-15', 147571, ''),
(13, 'ahsd', 'ahsd', '2024-04-15', 147571, ''),
(14, 'hello', 'hello', '2024-04-15', 147571, '');

-- --------------------------------------------------------

--
-- Table structure for table `preference form`
--

CREATE TABLE `preference form` (
  `FormID` int(11) NOT NULL,
  `Account` varchar(45) NOT NULL,
  `FormName` varchar(45) NOT NULL,
  `Form Description` varchar(45) NOT NULL,
  `ACCOUNT_AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social media`
--

CREATE TABLE `social media` (
  `Social Media ID` int(11) NOT NULL,
  `Account` varchar(45) NOT NULL,
  `SocialMediaName` varchar(45) NOT NULL,
  `SocialMediaURL` varchar(45) NOT NULL,
  `ACCOUNT_AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user role`
--

CREATE TABLE `user role` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(45) NOT NULL,
  `RoleDescription` varchar(250) NOT NULL,
  `ACCOUNT_AccountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `graduation_year` int(4) NOT NULL,
  `major` varchar(20) NOT NULL,
  `minor` varchar(20) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`, `email`, `date`, `graduation_year`, `major`, `minor`, `profile_picture`) VALUES
(1, 147571, 'Luke', '123', 'luke.elliott.21@cnu.edu', '2024-03-18 23:57:02', 2025, 'Information Science', 'null', ''),
(2, 355334949, 'Josh', '123', '123.email@gmail.com', '2024-03-19 01:40:43', 2024, 'Accounting', 'African-American Stu', ''),
(4, 6294728, 'luke3', '123', 'luke.elliott285@gmail.com', '2024-03-19 13:54:46', 2023, 'Art History', 'Film Studies', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`AccountID`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`EventID`),
  ADD KEY `LOCATION_LocationID` (`LOCATION_LocationID`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`user_id`,`friend_id`);

--
-- Indexes for table `job_listings`
--
ALTER TABLE `job_listings`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LocationID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`FrienderID`,`Friendee`,`Message DATE/TIME`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `network`
--
ALTER TABLE `network`
  ADD PRIMARY KEY (`FrienderID`,`FriendeeID`,`ACCOUNT_AccountID`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`NewsletterID`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`);

--
-- Indexes for table `preference form`
--
ALTER TABLE `preference form`
  ADD PRIMARY KEY (`FormID`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `social media`
--
ALTER TABLE `social media`
  ADD PRIMARY KEY (`Social Media ID`,`ACCOUNT_AccountID`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `user role`
--
ALTER TABLE `user role`
  ADD PRIMARY KEY (`RoleID`),
  ADD KEY `ACCOUNT_AccountID` (`ACCOUNT_AccountID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `job_listings`
--
ALTER TABLE `job_listings`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LocationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`LOCATION_LocationID`) REFERENCES `location` (`LocationID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `network`
--
ALTER TABLE `network`
  ADD CONSTRAINT `network_ibfk_1` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `newsletter_ibfk_1` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `preference form`
--
ALTER TABLE `preference form`
  ADD CONSTRAINT `preference form_ibfk_1` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `social media`
--
ALTER TABLE `social media`
  ADD CONSTRAINT `social media_ibfk_1` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user role`
--
ALTER TABLE `user role`
  ADD CONSTRAINT `user role_ibfk_1` FOREIGN KEY (`ACCOUNT_AccountID`) REFERENCES `account` (`AccountID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
