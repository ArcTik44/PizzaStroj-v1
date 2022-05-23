-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `street` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `city` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `number` int NOT NULL,
  `postal_code` int NOT NULL,
  `customer_id` int NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `address` (`address_id`, `street`, `city`, `number`, `postal_code`, `customer_id`) VALUES
(1,	'Fialová',	'Pardubice',	185,	53002,	0),
(2,	'',	'',	0,	0,	0),
(3,	'',	'',	0,	0,	0),
(4,	'',	'',	0,	0,	0),
(5,	'',	'',	0,	0,	0),
(6,	'',	'',	0,	0,	0),
(7,	'',	'',	0,	0,	0);

DROP TABLE IF EXISTS `beverage`;
CREATE TABLE `beverage` (
  `beverage_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(70) COLLATE utf8mb4_czech_ci NOT NULL,
  `description` text COLLATE utf8mb4_czech_ci NOT NULL,
  `volume` double NOT NULL,
  `alcohol_volume` double DEFAULT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`beverage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `beverage` (`beverage_id`, `name`, `description`, `volume`, `alcohol_volume`, `price`) VALUES
(1,	'Braník',	'Pivo vyráběné smíchovským pivovarem Staropramen',	500,	4,	65);

DROP TABLE IF EXISTS `contained`;
CREATE TABLE `contained` (
  `contained_id` int NOT NULL AUTO_INCREMENT,
  `pizza_id` int NOT NULL,
  `material_id` int NOT NULL,
  PRIMARY KEY (`contained_id`),
  KEY `material_id` (`material_id`),
  KEY `pizza_id` (`pizza_id`),
  CONSTRAINT `contained_ibfk_4` FOREIGN KEY (`material_id`) REFERENCES `material` (`material_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `contained_ibfk_5` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`pizza_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `contained` (`contained_id`, `pizza_id`, `material_id`) VALUES
(1,	1,	1),
(2,	1,	2),
(3,	1,	7),
(4,	1,	5),
(5,	1,	8),
(6,	1,	6);

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `surname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `order_id` int DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `customer` (`customer_id`, `name`, `surname`, `email`, `password`, `order_id`) VALUES
(1,	'John',	'Doe',	'johndoe@gmail.com',	'$2y$10$GolQ9WUKOIV5y/LF61g/se9w0u9bK6Iq5l8drR0v8hI9AGSZ4OauW',	2);

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_czech_ci NOT NULL,
  `surname` varchar(40) COLLATE utf8mb4_czech_ci NOT NULL,
  `role` varchar(40) COLLATE utf8mb4_czech_ci NOT NULL,
  `contract_expiration` date NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `employee` (`employee_id`, `name`, `surname`, `role`, `contract_expiration`) VALUES
(1,	'Mark',	'Zuckerberg',	'manager',	'2024-01-30'),
(2,	'Steve',	'Jobs',	'cook',	'2023-09-07'),
(3,	'Elon',	'Musk',	'cook',	'2023-04-12'),
(4,	'Jeff',	'Bezouš',	'cook',	'2023-03-06'),
(5,	'Bill',	'Gates',	'driver',	'2023-04-09'),
(6,	'John',	'McAfee',	'driver',	'2021-06-23'),
(7,	'Jaroslav',	'Beck',	'driver',	'2023-06-28');

DROP TABLE IF EXISTS `material`;
CREATE TABLE `material` (
  `material_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `material` (`material_id`, `name`, `description`, `price`) VALUES
(1,	'Těsto',	'Kynuté těsto',	30),
(2,	'Rajčatový základ',	'Rajčatový základ',	25),
(3,	'Smetanový základ',	'Smetanový základ',	30),
(4,	'Šunkový salám',	'Šunkový salám',	20),
(5,	'Sýr mozzarella',	'Italský sýr mozzarella',	20),
(6,	'Sýr parmezán',	'Italský sýr parmezán',	25),
(7,	'Sýr Gorgonzola',	'Italský sýr Gorgonzola',	20),
(8,	'Sýr Niva',	'Plísňový sýr niva',	15);

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci,
  `price` float NOT NULL,
  `order_time` datetime NOT NULL,
  `delivery_time` datetime NOT NULL,
  `beverage_id` int NOT NULL,
  `pizza_id` int NOT NULL,
  `address_id` int NOT NULL,
  `employee_id` int NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `beverage_id` (`beverage_id`),
  KEY `pizza_id` (`pizza_id`),
  KEY `address_id` (`address_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `order_ibfk_2` FOREIGN KEY (`beverage_id`) REFERENCES `beverage` (`beverage_id`),
  CONSTRAINT `order_ibfk_4` FOREIGN KEY (`pizza_id`) REFERENCES `pizza` (`pizza_id`),
  CONSTRAINT `order_ibfk_5` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`),
  CONSTRAINT `order_ibfk_6` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `order` (`order_id`, `info`, `price`, `order_time`, `delivery_time`, `beverage_id`, `pizza_id`, `address_id`, `employee_id`) VALUES
(2,	'Dám dýško vyšší, pokud bude Braník vychlazenej',	195,	'2022-05-19 13:23:53',	'0000-00-00 00:00:00',	1,	1,	1,	2);

DROP TABLE IF EXISTS `pizza`;
CREATE TABLE `pizza` (
  `pizza_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `diameter` double NOT NULL,
  PRIMARY KEY (`pizza_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

INSERT INTO `pizza` (`pizza_id`, `name`, `description`, `diameter`) VALUES
(1,	'Pizza Quattro Formaggi',	'Oblíbená italská pizza se 4 druhy sýra',	80);

-- 2022-05-23 06:15:34

