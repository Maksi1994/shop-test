-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.20 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных shop
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shop`;

-- Дамп структуры для таблица shop.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.categories: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`id`, `name`) VALUES
	(1, 'clothes');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price` decimal(19,4) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `ts_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `count` int(11) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.orders: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(4,2) NOT NULL,
  `count` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
REPLACE INTO `products` (`id`, `name`, `photo`, `description`, `ts`, `price`, `count`, `category_id`) VALUES
	(9, 'Kids short', '1528050927ikks-brian-boys-shorts-pic-SS_IKKS_027_R_300.jpg', 'Small short', '2018-06-03 21:35:27', 22.50, 100, 1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products_promotions
CREATE TABLE IF NOT EXISTS `products_promotions` (
  `promotion_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  KEY `promotion_id` (`promotion_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `products_promotions_ibfk_1` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`),
  CONSTRAINT `products_promotions_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products_promotions: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `products_promotions` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_promotions` ENABLE KEYS */;

-- Дамп структуры для таблица shop.promotions
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` decimal(4,2) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.promotions: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
REPLACE INTO `promotions` (`id`, `percent`, `name`, `description`) VALUES
	(1, 25.00, 'Happy Summer', 'minus twenty five percent to buy');
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;

-- Дамп структуры для таблица shop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.users: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `login`, `password`) VALUES
	(1, 'admin', '123123123');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
