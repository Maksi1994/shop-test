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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.categories: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `parent_id`, `photo`) VALUES
	(21, 'Mens Clothes', 0, 'icons8-мужчина-пользователь-50.png'),
	(24, 'Wonem Clothes', 25, 'icons8-женщина-80.png'),
	(25, 'Gadgets', 0, 'icons8-смартфон-_-планшет-64.png'),
	(27, 'Sneakers', 0, 'icons8-кросовки-50.png'),
	(28, 'Shorts', 0, 'icons8-шорты-filled-50.png');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица shop.options
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.options: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` (`id`, `name`) VALUES
	(1, 'size');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;

-- Дамп структуры для таблица shop.options_values
CREATE TABLE IF NOT EXISTS `options_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `option_id` (`option_id`),
  CONSTRAINT `options_values_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.options_values: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `options_values` DISABLE KEYS */;
INSERT INTO `options_values` (`id`, `name`, `option_id`) VALUES
	(5, 'middle', 1),
	(9, 'small', 1),
	(10, 'l', 1);
/*!40000 ALTER TABLE `options_values` ENABLE KEYS */;

-- Дамп структуры для таблица shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `ts_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.orders: ~31 rows (приблизительно)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `ts_create`, `status`) VALUES
	(56, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:07', '1'),
	(57, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:07', '1'),
	(58, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:08', '1'),
	(59, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:09', '1'),
	(60, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:09', '1'),
	(61, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:09', '1'),
	(62, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:10', '1'),
	(63, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:10', '1'),
	(64, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:11', '1'),
	(65, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:11', '1'),
	(66, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:12', '1'),
	(67, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:12', '1'),
	(68, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:13', '1'),
	(69, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:13', '1'),
	(70, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:14', '1'),
	(71, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:14', '1'),
	(72, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:15', '1'),
	(73, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:15', '1'),
	(74, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:15', '1'),
	(75, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:16', '1'),
	(76, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:16', '1'),
	(78, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:17', '1'),
	(79, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:18', '1'),
	(80, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:18', '1'),
	(81, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:18', '1'),
	(82, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:19', '1'),
	(83, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:19', '1'),
	(84, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:19', '1'),
	(85, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:20', 'd'),
	(86, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:20', 'd'),
	(87, ' Maxim', 'mak55755@gmail.com', '2018-08-05 02:00:20', 'd');
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products: ~19 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `photo`, `description`, `ts`, `price`, `category_id`, `status`) VALUES
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
	(27, 'Wonem Boots', '1531063955images (3).jpg', '45', '2018-07-08 18:32:35', 150.01, 24, 'e'),
	(28, 'efwef', '15356689354a533a0972a3477cac414e1789b6a451.jpg', 'ewfewf', '2018-08-31 01:42:15', 120.20, 21, 'e'),
	(29, 'efwef', '15356691434a533a0972a3477cac414e1789b6a451.jpg', 'ewfewf', '2018-08-31 01:45:43', 120.20, 21, 'd'),
	(30, 'efwef', '15356691534a533a0972a3477cac414e1789b6a451.jpg', 'ewfewf', '2018-08-31 01:45:53', 120.20, 21, 'd'),
	(31, 'SOME PRODUCT', '15356692144a533a0972a3477cac414e1789b6a451.jpg', 'ewfewf', '2018-08-31 01:46:54', 120.20, 21, 'e'),
	(32, 'asdasd', '15356693224a533a0972a3477cac414e1789b6a451.jpg', 'wefewf', '2018-08-31 01:48:42', 10.00, 21, 'e'),
	(33, 'asdasd', '15356693454a533a0972a3477cac414e1789b6a451.jpg', 'wefewf', '2018-08-31 01:49:05', 10.00, 21, 'e'),
	(34, 'asdasd', '15356693624a533a0972a3477cac414e1789b6a451.jpg', 'wefewf', '2018-08-31 01:49:22', 10.00, 21, 'e'),
	(35, 'asdasd', '15356693804a533a0972a3477cac414e1789b6a451.jpg', 'wefewfsd', '2018-08-31 01:49:40', 10.00, 27, 'e');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products_options
CREATE TABLE IF NOT EXISTS `products_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `option_value` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `products_options_ibfk_1` (`product_id`),
  KEY `products_options_ibfk_2` (`option_id`),
  KEY `products_options_ibfk_3` (`option_value`),
  CONSTRAINT `products_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_options_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_options_ibfk_3` FOREIGN KEY (`option_value`) REFERENCES `options_values` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products_options: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `products_options` DISABLE KEYS */;
INSERT INTO `products_options` (`id`, `product_id`, `option_id`, `option_value`, `count`) VALUES
	(1, 34, 1, 5, 0),
	(2, 35, 1, 5, 0);
/*!40000 ALTER TABLE `products_options` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products_orders
CREATE TABLE IF NOT EXISTS `products_orders` (
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `price_for_one` float(10,2) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `fk_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `products_orders_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products_orders: ~31 rows (приблизительно)
/*!40000 ALTER TABLE `products_orders` DISABLE KEYS */;
INSERT INTO `products_orders` (`product_id`, `order_id`, `count`, `price_for_one`) VALUES
	(9, 56, 2, 82.02),
	(9, 57, 2, 82.02),
	(9, 58, 2, 82.02),
	(9, 59, 2, 82.02),
	(9, 60, 2, 82.02),
	(9, 61, 2, 82.02),
	(9, 62, 2, 82.02),
	(9, 63, 2, 82.02),
	(9, 64, 2, 82.02),
	(9, 65, 2, 82.02),
	(9, 66, 2, 82.02),
	(9, 67, 2, 82.02),
	(9, 68, 2, 82.02),
	(9, 69, 2, 82.02),
	(9, 70, 2, 82.02),
	(9, 71, 2, 82.02),
	(9, 72, 2, 82.02),
	(9, 73, 2, 82.02),
	(9, 74, 2, 82.02),
	(9, 75, 2, 82.02),
	(9, 76, 2, 82.02),
	(9, 78, 2, 82.02),
	(9, 79, 2, 82.02),
	(9, 80, 2, 82.02),
	(9, 81, 2, 82.02),
	(9, 82, 2, 82.02),
	(9, 83, 2, 82.02),
	(9, 84, 2, 82.02),
	(9, 86, 2, 82.02),
	(9, 87, 2, 82.02),
	(9, 85, 2, 82.02);
/*!40000 ALTER TABLE `products_orders` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products_promotions
CREATE TABLE IF NOT EXISTS `products_promotions` (
  `promotion_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `promotion_id` (`promotion_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `products_promotions_ibfk_5` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_promotions_ibfk_6` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products_promotions: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `products_promotions` DISABLE KEYS */;
INSERT INTO `products_promotions` (`promotion_id`, `product_id`, `id`) VALUES
	(1, 9, 1),
	(2, 9, 2),
	(2, 35, 3),
	(1, 35, 4);
/*!40000 ALTER TABLE `products_promotions` ENABLE KEYS */;

-- Дамп структуры для таблица shop.promotions
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` float(4,2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.promotions: ~25 rows (приблизительно)
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
INSERT INTO `promotions` (`id`, `percent`, `name`, `description`) VALUES
	(1, 25.00, 'Happy Summer', 'Minus twenty five percent to buy'),
	(2, 10.00, 'Promotion For Young', 'Promotions for guys 10% for all clothes!'),
	(7, 20.00, 'Crazy Autumn', 'Promotions for all women clothes.'),
	(8, 20.00, 'Some New', 'Some description'),
	(9, 20.00, 'Some New', 'Some description'),
	(10, 20.00, 'Some New', 'Some description'),
	(11, 20.00, 'Some New', 'Some description'),
	(12, 20.00, 'Some New', 'Some description'),
	(13, 20.00, 'Some New', 'Some description'),
	(14, 20.00, 'Some New', 'Some description'),
	(15, 20.00, 'Some New', 'Some description'),
	(16, 20.00, 'Some New', 'Some description'),
	(17, 20.00, 'Some New', 'Some description'),
	(18, 20.00, 'Some New', 'Some description'),
	(19, 20.00, 'Some New', 'Some description'),
	(20, 20.00, 'Some New', 'Some description'),
	(21, 20.00, 'Some New', 'Some description'),
	(22, 20.00, 'Some New', 'Some description'),
	(23, 20.00, 'Some New', 'Some description'),
	(24, 20.00, 'Some New', 'Some description'),
	(25, 20.00, 'Some New', 'Some description'),
	(26, 20.00, 'Some New', 'Some description'),
	(27, 20.00, 'Some New', 'Some description'),
	(28, 20.00, 'Some New', 'Some description'),
	(29, 20.00, 'Some New', 'Some description');
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;

-- Дамп структуры для таблица shop.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idrolers_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.roles: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Дамп структуры для таблица shop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.users: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `login`, `password`, `role`) VALUES
	(1, 'admin', '123123123', 'admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
