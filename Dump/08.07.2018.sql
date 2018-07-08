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
  `parent_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.categories: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`id`, `name`, `parent_id`, `photo`) VALUES
	(21, 'Men', 0, '1530380190clothes.svg'),
	(24, 'Wonem', 0, '1531058986dress.jpg');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `ts_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
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
  `price` float(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` varchar(2) DEFAULT 'e',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products: ~11 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
REPLACE INTO `products` (`id`, `name`, `photo`, `description`, `ts`, `price`, `category_id`, `status`) VALUES
	(9, 'Shorts', '1528050927ikks-brian-boys-shorts-pic-SS_IKKS_027_R_300.jpg', 'Small short', '2018-06-03 21:35:27', 82.02, 21, 'e'),
	(10, 'Dress', '1531058399dress.jpg', 'Some description', '2018-07-08 16:59:59', 150.00, 24, 'e'),
	(11, 'Hat', '1531059620hat.jpg', 'Some hat.', '2018-07-08 17:20:20', 25.00, 21, 'e'),
	(13, 'Sneakers', '1531059768crossfit.jpg', 'Some sneakers;', '2018-07-08 17:22:48', 150.00, 21, 'e'),
	(15, 'Orange T-Shirt', '1531059845t-shirt-orange.jpg', 'Some Description', '2018-07-08 17:24:05', 100.00, 21, 'e'),
	(16, 'Couple of jeans', '1531059938ME003N-2846-1.jpg', 'Some Description', '2018-07-08 17:25:38', 120.00, 21, 'e'),
	(17, 'Boots', '153106311710061024-HERO.jpg', 'Some description', '2018-07-08 18:18:37', 150.00, 21, 'e'),
	(24, 'Sneakers', '1531063874images.jpg', 'qwdwd', '2018-07-08 18:31:14', 150.00, 21, 'e'),
	(25, 'Sneakers', '1531063886images.jpg', 'qwdwd', '2018-07-08 18:31:26', 150.00, 21, 'e'),
	(26, 'Pullover', '1531063930pullover.jpg', 'Some pullover.', '2018-07-08 18:32:10', 200.00, 21, 'e'),
	(27, 'Wonem Boots', '1531063955images (3).jpg', '45', '2018-07-08 18:32:35', 150.01, 24, 'e');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products_orders
CREATE TABLE IF NOT EXISTS `products_orders` (
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price_for_one` float(10,2) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `products_orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `proructs` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `products_orders_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products_orders: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `products_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_orders` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products_promotions
CREATE TABLE IF NOT EXISTS `products_promotions` (
  `promotion_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  KEY `promotion_id` (`promotion_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `products_promotions_ibfk_5` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_promotions_ibfk_6` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products_promotions: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `products_promotions` DISABLE KEYS */;
REPLACE INTO `products_promotions` (`promotion_id`, `product_id`) VALUES
	(1, 9),
	(2, 9);
/*!40000 ALTER TABLE `products_promotions` ENABLE KEYS */;

-- Дамп структуры для таблица shop.promotions
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` float(4,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.promotions: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
REPLACE INTO `promotions` (`id`, `percent`, `name`, `description`) VALUES
	(1, 25.00, 'Happy Summer', 'Minus twenty five percent to buy'),
	(2, 10.00, 'Promotion For Young', 'Promotions for guys 10% for all clothes!'),
	(6, 25.00, 'dasfdsf', 'ewfewf');
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
