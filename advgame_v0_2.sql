-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2016 at 11:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `advgame_v0_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `start_cell` tinyint(5) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grid`
--

CREATE TABLE IF NOT EXISTS `grid` (
  `gridID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `path_north` mediumint(8) unsigned DEFAULT NULL,
  `path_south` mediumint(8) unsigned DEFAULT NULL,
  `path_west` mediumint(8) unsigned DEFAULT NULL,
  `path_east` mediumint(8) unsigned DEFAULT NULL,
  `path_blocked` varchar(5) DEFAULT NULL,
  `itemID_gain` varchar(16) DEFAULT NULL,
  `itemID_need` varchar(16) DEFAULT NULL,
  `text` varchar(140) NOT NULL,
  PRIMARY KEY (`gridID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `grid`
--

INSERT INTO `grid` (`gridID`, `name`, `path_north`, `path_south`, `path_west`, `path_east`, `path_blocked`, `itemID_gain`, `itemID_need`, `text`) VALUES
(1, 'beach', NULL, NULL, NULL, 2, NULL, 'brasskey', NULL, 'The beach stretches before you for miles and miles. Yeah, maybe one day you could afford to holiday here.'),
(2, 'beach', NULL, 5, 1, 3, NULL, NULL, NULL, 'Clearing the undergrowth of the forest you step onto an amazing beach with the clearest blue sea you''ve ever seen.'),
(3, 'beach', NULL, NULL, 2, NULL, NULL, 'redherring', NULL, 'It''s sand, sand, sand, everywhere you look. This is a mighty fine beach.'),
(5, 'forest', 2, NULL, NULL, 6, NULL, NULL, NULL, 'You''re in the middle of a dark and very expensive forest. You''re a little lost and quite frankly you''d like to get home to your mum.'),
(6, 'forest', NULL, 9, 5, NULL, 'south', NULL, 'redherring', 'You''re still in the forest. There''s nothing of any significance about this part of the forest. There''s wood, leaves and the ground.'),
(9, 'castle wall', 6, NULL, NULL, NULL, NULL, NULL, 'brasskey', 'You step out of the forest into a clearing, in the middle of which is a very, very big castle.');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `inventoryItemID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `playerID` mediumint(8) unsigned NOT NULL,
  `itemID` varchar(50) NOT NULL,
  PRIMARY KEY (`inventoryItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `itemID` varchar(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `text_gain` varchar(140) NOT NULL,
  `text_use` varchar(140) NOT NULL,
  `text_notfound` varchar(140) NOT NULL,
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `name`, `text_gain`, `text_use`, `text_notfound`) VALUES
('brasskey', 'A brass key to unlock the castle door', 'In the sand you spot a key. Wahey! This could be kind of useful. You put it in your backpack, for later.', 'There''s a door in the castle wall, but it''s locked. Hang on a minute... you picked up a key earlier on, that should work!', 'In the walls of the castle there''s a door, but it''s locked. It looks like it might need a key.'),
('redherring', 'redherring to give to the troll', 'Over on the ground you spot something that''s distracting but of no real purpose to anyone, so you pick it up.', 'A troll is blocking the path. He demands something of no purpose. You give him the red herring you found at the beach - he lets you pass.', 'There''s a troll blocking the path and he wants something that''s distracting but of no real purpose. You don''t have anything like this.');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `playerID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `telNumber` varchar(20) NOT NULL,
  `callID` varchar(36) NOT NULL,
  `gridID` mediumint(8) unsigned NOT NULL,
  `lastTimerAlert` smallint(3) unsigned NOT NULL,
  `startTimeCurrentPlay` time NOT NULL,
  `totalSecondsPlay` mediumint(8) unsigned NOT NULL,
  `totalMovesMade` mediumint(8) unsigned NOT NULL,
  `completedStory` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `lastUpdated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`playerID`),
  UNIQUE KEY `telNumber` (`telNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `queue_incoming`
--

CREATE TABLE IF NOT EXISTS `queue_incoming` (
  `tweet_id` bigint(20) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tweets_incoming`
--

CREATE TABLE IF NOT EXISTS `tweets_incoming` (
  `tweet_id` bigint(20) unsigned NOT NULL,
  `text` varchar(140) NOT NULL,
  `created_at` datetime NOT NULL,
  `author_id` bigint(20) unsigned NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `profile_image_url` varchar(150) NOT NULL,
  `timezone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tweets_json`
--

CREATE TABLE IF NOT EXISTS `tweets_json` (
  `tweet_id` bigint(20) unsigned NOT NULL,
  `json` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
