-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.45 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных mysite
CREATE DATABASE IF NOT EXISTS `mysite` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mysite`;


-- Дамп структуры для таблица mysite.site_block
CREATE TABLE IF NOT EXISTS `site_block` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `block_side` varchar(15) NOT NULL,
  `block_text` varchar(10000) NOT NULL,
  `block_is_text` char(3) NOT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mysite.site_block: ~1 rows (приблизительно)
DELETE FROM `site_block`;
/*!40000 ALTER TABLE `site_block` DISABLE KEYS */;
INSERT INTO `site_block` (`block_id`, `block_side`, `block_text`, `block_is_text`) VALUES
	(1, 'center', '', 'Нет');
/*!40000 ALTER TABLE `site_block` ENABLE KEYS */;


-- Дамп структуры для таблица mysite.site_item
CREATE TABLE IF NOT EXISTS `site_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mysite.site_item: ~2 rows (приблизительно)
DELETE FROM `site_item`;
/*!40000 ALTER TABLE `site_item` DISABLE KEYS */;
INSERT INTO `site_item` (`item_id`) VALUES
	(1),
	(2);
/*!40000 ALTER TABLE `site_item` ENABLE KEYS */;


-- Дамп структуры для таблица mysite.site_page
CREATE TABLE IF NOT EXISTS `site_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_seo_title` varchar(250) NOT NULL,
  `page_seo_keywords` varchar(250) NOT NULL,
  `page_seo_description` varchar(250) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mysite.site_page: ~1 rows (приблизительно)
DELETE FROM `site_page`;
/*!40000 ALTER TABLE `site_page` DISABLE KEYS */;
INSERT INTO `site_page` (`page_id`, `page_seo_title`, `page_seo_keywords`, `page_seo_description`) VALUES
	(1, '', '', '');
/*!40000 ALTER TABLE `site_page` ENABLE KEYS */;


-- Дамп структуры для таблица mysite.site_tree
CREATE TABLE IF NOT EXISTS `site_tree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(150) NOT NULL DEFAULT '0',
  `link` char(150) NOT NULL,
  `name` char(150) NOT NULL,
  `type` char(50) NOT NULL DEFAULT '',
  `type_id` tinyint(4) NOT NULL DEFAULT '0',
  `left_key` int(11) NOT NULL DEFAULT '0',
  `right_key` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(4) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mysite.site_tree: ~4 rows (приблизительно)
DELETE FROM `site_tree`;
/*!40000 ALTER TABLE `site_tree` DISABLE KEYS */;
INSERT INTO `site_tree` (`id`, `title`, `link`, `name`, `type`, `type_id`, `left_key`, `right_key`, `level`, `pid`) VALUES
	(1, 'Русский', 'ru', 'lang', '', 0, 1, 62, 1, 0),
	(2, 'Страницы', 'ru/pages', 'pages', 'item', 2, 2, 51, 2, 1),
	(3, 'Главная', 'ru/pages/main', 'main', 'page', 1, 3, 36, 3, 2),
	(4, 'Главный блок', 'ru/pages/main/main', 'main', 'block', 1, 4, 17, 4, 3);
/*!40000 ALTER TABLE `site_tree` ENABLE KEYS */;


-- Дамп структуры для таблица mysite.site_types
CREATE TABLE IF NOT EXISTS `site_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `name` char(50) NOT NULL,
  `seo` tinyint(1) NOT NULL DEFAULT '0',
  `json` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mysite.site_types: ~3 rows (приблизительно)
DELETE FROM `site_types`;
/*!40000 ALTER TABLE `site_types` DISABLE KEYS */;
INSERT INTO `site_types` (`id`, `title`, `name`, `seo`, `json`) VALUES
	(3, 'HMVC Блок', 'block', 0, '[{"name":"side","title":"\\u0421\\u0442\\u043e\\u0440\\u043e\\u043d\\u0430","type":"select","variants":["header","left","center","right","footer"],"selects":"2","int":false},{"name":"text","title":"\\u0422\\u0435\\u043a\\u0441\\u0442","type":"textarea","variants":[],"selects":"0","int":false},{"name":"is_text","title":"\\u0418\\u0441\\u043f\\u043e\\u043b\\u044c\\u0437\\u043e\\u0432\\u0430\\u0442\\u044c \\u0442\\u0435\\u043a\\u0441\\u0442","type":"radio","variants":["\\u041d\\u0435\\u0442","\\u0414\\u0430"],"selects":"0","int":false}]'),
	(4, 'Пункт меню', 'item', 0, '[]'),
	(5, 'Страница', 'page', 1, '[]');
/*!40000 ALTER TABLE `site_types` ENABLE KEYS */;


-- Дамп структуры для таблица mysite.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` char(50) NOT NULL DEFAULT '0',
  `pass` char(50) NOT NULL DEFAULT '0',
  `role` char(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы mysite.users: ~1 rows (приблизительно)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `login`, `pass`, `role`) VALUES
	(2, 'root', '177ce9d22426c0159b1e2ca36e583e42', 'root');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
