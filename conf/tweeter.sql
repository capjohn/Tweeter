-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 02 déc. 2020 à 22:02
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tweeter`
--

-- --------------------------------------------------------

--
-- Structure de la table `follow`
--

DROP TABLE IF EXISTS `follow`;
CREATE TABLE IF NOT EXISTS `follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower` int(11) NOT NULL,
  `followee` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `follow`
--

INSERT INTO `follow` (`id`, `follower`, `followee`) VALUES
(1, 10, 9),
(2, 10, 6),
(3, 10, 2),
(5, 8, 12),
(6, 12, 8),
(7, 5, 12),
(8, 12, 7),
(9, 14, 12),
(10, 15, 12),
(11, 15, 8),
(12, 12, 4);

-- --------------------------------------------------------

--
-- Structure de la table `like`
--

DROP TABLE IF EXISTS `like`;
CREATE TABLE IF NOT EXISTS `like` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `like`
--

INSERT INTO `like` (`id`, `user_id`, `tweet_id`) VALUES
(1, 10, 63),
(8, 12, 50),
(9, 12, 75),
(10, 15, 75),
(12, 12, 66);

-- --------------------------------------------------------

--
-- Structure de la table `tweet`
--

DROP TABLE IF EXISTS `tweet`;
CREATE TABLE IF NOT EXISTS `tweet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(256) NOT NULL,
  `author` int(11) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tweet`
--

INSERT INTO `tweet` (`id`, `text`, `author`, `score`, `created_at`, `updated_at`) VALUES
(49, 'Off to Waterloo. Wish me luck.', 7, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(50, 'Logic will get you from A to B. Imagination will take you everywhere.', 8, 1, '2020-11-19 17:39:40', '2020-11-19 16:39:40'),
(51, 'Man who jump off cliff, jump to conclusion!', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(52, ' have spoken w/ @GovAbbott of Texas and @LouisianaGov Edwards. Closely monitoring #HurricaneHarvey developments & here to assist as needed.', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(53, 'Man who not poop for many days must take care of back log.', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(54, 'All Tweeters are Created Equal', 4, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(55, 'He who drops watch in toilet has shitty time', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(56, 'Going to a Cabinet Meeting (tele-conference) at 11:00 A.M. on #Harvey. Even experts have said they\'ve never seen one like this!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(57, 'HISTORIC rainfall in Houston, and all over Texas. Floods are unprecedented, and more rain coming. Spirit of the people is incredible.Thanks!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(58, 'Be yourself; everyone else is already taken.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(59, 'To live is the rarest thing in the world. Most people exist, that is all.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(60, 'For those at the back who obviously can\'t hear me, I said that they may take out lives, but they\'ll never take our freedom', 5, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(61, 'With Mexico being one of the highest crime Nations in the world, we must have THE WALL. Mexico will pay for it through reimbursement/other.', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(62, 'Man who sneezes without tissue takes matters in own hands.', 2, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(63, 'I am so clever that sometimes I don\'t understand a single word of what I am saying.', 9, 1, '2017-10-08 12:07:37', '0000-00-00 00:00:00'),
(64, 'I am pleased to inform you that I have just granted a full Pardon to 85 year old American patriot Sheriff Joe Arpaio. He kept Arizona safe!', 1, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(65, 'Only two things are infinite, the universe and human stupidity, and I\'m not sure about the former.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(66, 'The true sign of intelligence is not knowledge but imagination.', 8, 1, '2020-12-02 21:31:27', '2020-12-02 20:31:27'),
(67, 'It is the supreme art of the teacher to awaken joy in creative expression and knowledge.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(68, 'Busted through that wall like it was paper #sorrynotsorry', 6, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(69, 'A person who never made a mistake never tried anything new.', 8, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(70, 'Always forgive your enemies; nothing annoys them so much.', 9, 0, '2017-08-31 07:59:35', '0000-00-00 00:00:00'),
(71, 'Hello world of tweeter #ImNewatThis', 10, 0, '2017-09-01 12:57:48', '0000-00-00 00:00:00'),
(72, 'Is there anybody out here ? #ImLonely', 10, 0, '2017-09-01 13:00:39', '0000-00-00 00:00:00'),
(73, 'Still nobody ??? #ImLonely', 10, 0, '2017-09-01 13:04:39', '0000-00-00 00:00:00'),
(74, 'This place sucks.', 10, 0, '2017-09-01 13:10:21', '0000-00-00 00:00:00'),
(75, 'voici mon test', 12, 2, '2020-11-28 14:55:41', '2020-11-28 13:55:41');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(512) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `level` int(11) NOT NULL,
  `followers` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `password`, `level`, `followers`) VALUES
(1, 'Donald J. Trump', 'donald', '', 100, 0),
(2, 'Conficius', 'conficius', '', 100, 1),
(3, 'Master Yoda', 'yoda', '', 100, 0),
(4, 'Martin Luther King', 'martin', '', 100, 1),
(5, 'William Wallace', 'will', '', 100, 0),
(6, 'Genghis Khan', 'mongoldude', '', 100, 1),
(7, 'Napoleon Bonaparte', 'napoleon', '', 100, 1),
(8, 'Albert Einstein', 'albert', '', 100, 2),
(9, 'Oscar Wilde', 'oscar', '', 100, 1),
(10, 'John Doe', 'johny', '$2y$10$9xy1A.dN0.eppTrLciPCn.hiMBHm2WAr1ykbgqcvaX6Uc66A7il8C', 100, 0),
(12, 'Jonathan Simon', 'Jonathan', '$2y$10$pz.V8iDmHG/sDU/wsjm59OyuTLjG1RqoGinF3A/JJIbgKumoIrylm', 100, 4),
(14, 'test', 'test', '$2y$10$qUlpgUawouq5TNYO7mZsPulZ7oUMFSWmGf9vE0MzZoFUpkMWU2GsO', 100, 0),
(15, 'admin', 'admin', '$2y$10$moNNEXEJ9UOsD6MuX6pqrONXKhw27LTjIHO.UpESuJ2ps6o31rcdS', 200, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
