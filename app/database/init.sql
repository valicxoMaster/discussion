-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               5.7.38 - MySQL Community Server (GPL)
-- Server Betriebssystem:        Linux
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Exportiere Struktur von Tabelle comdata.articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle comdata.articles: ~0 rows (ungefähr)
INSERT INTO `articles` (`id`, `title`, `content`) VALUES
	(1, 'Article A1', 'Lorem ipsum dolor sit amet, admodum senserit et duo, ut duo dicant causae. Est solum inani adolescens an. Debet aliquip cum te, dolores menandri eu nec. Ut has tantas argumentum consequuntur. Vis soluta cetero delectus ex, modus dicat noluisse ea sed, amet illud moderatius mel et.'),
	(2, 'Article B2', 'Lorem ipsum dolor sit amet, admodum senserit et duo, ut duo dicant causae. Est solum inani adolescens an. Debet aliquip cum te, dolores menandri eu nec. Ut has tantas argumentum consequuntur. Vis soluta cetero delectus ex, modus dicat noluisse ea sed, amet illud moderatius mel et.'),
	(3, 'Article B3', 'Lorem ipsum dolor sit amet, admodum senserit et duo, ut duo dicant causae. Est solum inani adolescens an. Debet aliquip cum te, dolores menandri eu nec. Ut has tantas argumentum consequuntur. Vis soluta cetero delectus ex, modus dicat noluisse ea sed, amet illud moderatius mel et.');

-- Exportiere Struktur von Tabelle comdata.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `content` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comments_articles` (`article_id`),
  KEY `FK_comments_users` (`user_id`),
  CONSTRAINT `FK_comments_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle comdata.comments: ~0 rows (ungefähr)

-- Exportiere Struktur von Tabelle comdata.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle comdata.users: ~0 rows (ungefähr)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
