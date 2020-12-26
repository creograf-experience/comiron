-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 07 2014 г., 16:18
-- Версия сервера: 5.5.8
-- Версия PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `comiron`
--

-- --------------------------------------------------------

--
-- Структура таблицы `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `body` mediumtext NOT NULL,
  `created` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `activity_stream_id` (`person_id`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `activities`
--

INSERT INTO `activities` (`id`, `person_id`, `app_id`, `title`, `body`, `created`) VALUES
(5, 13, 0, 'and <a href="/profile/14" rel="friend">Антон Миронов</a> are now friends.', '', 1363150447),
(6, 14, 0, 'and <a href="/profile/13" rel="friend">Михаил Николаев</a> are now friends.', '', 1363150447),
(7, 14, 0, 'and <a href="/profile/12" rel="friend">Anastasiya Deeva</a> are now friends.', '', 1364008975),
(8, 12, 0, 'and <a href="/profile/14" rel="friend">Korben Dallas</a> are now friends.', '', 1364008975),
(9, 14, 0, 'and <a href="/profile/16" rel="friend">Sergey Pavlov</a> are now friends.', '', 1364133372),
(10, 16, 0, 'and <a href="/profile/14" rel="friend">Korben Dallas</a> are now friends.', '', 1364133372),
(11, 13, 0, 'and <a href="/profile/16" rel="friend">Sergey Pavlov</a> are now friends.', '', 1364136841),
(12, 16, 0, 'and <a href="/profile/13" rel="friend">Михаил Николаев</a> are now friends.', '', 1364136841),
(13, 14, 0, 'and <a href="/profile/19" rel="friend">Елена Григорьевна</a> are now friends.', '', 1364622225),
(14, 19, 0, 'and <a href="/profile/14" rel="friend">Korben Dallas</a> are now friends.', '', 1364622225),
(15, 14, 0, 'and <a href="/profile/20" rel="friend">Ksenia Mironova</a> are now friends.', '', 1365122401),
(16, 20, 0, 'and <a href="/profile/14" rel="friend">Korben Dallas</a> are now friends.', '', 1365122401),
(17, 21, 0, 'and <a href="/profile/14" rel="friend">Korben Dallas</a> are now friends.', '', 1365256014),
(18, 14, 0, 'and <a href="/profile/21" rel="friend">Вячеслав Миронов</a> are now friends.', '', 1365256014),
(19, 12, 0, 'and <a href="/profile/22" rel="friend">Vitaliy Deev</a> are now friends.', '', 1367492460),
(20, 22, 0, 'and <a href="/profile/12" rel="friend">Anastasiya Deeva</a> are now friends.', '', 1367492460),
(21, 15, 0, 'and <a href="/profile/12" rel="friend">Anastasiya Deeva</a> are now friends.', '', 1367603773),
(22, 12, 0, 'and <a href="/profile/15" rel="friend">Анастасия Деева</a> are now friends.', '', 1367603773),
(23, 14, 0, 'and <a href="/profile/23" rel="friend">Андрей Силаев</a> are now friends.', '', 1368206056),
(24, 23, 0, 'and <a href="/profile/14" rel="friend">Korben Dallas</a> are now friends.', '', 1368206056),
(25, 20, 0, 'and <a href="/profile/12" rel="friend">Anastasiya Deeva</a> are now friends.', '', 1368851593),
(26, 12, 0, 'and <a href="/profile/20" rel="friend">Ksenia Mironova</a> are now friends.', '', 1368851593),
(27, 13, 0, 'and <a href="/profile/23" rel="friend">Андрей Силаев</a> are now friends.', '', 1368851850),
(28, 23, 0, 'and <a href="/profile/13" rel="friend">Михаил Николаев</a> are now friends.', '', 1368851850),
(29, 12, 0, 'and <a href="/profile/25" rel="friend">123123 123123</a> are now friends.', '', 1380222075),
(30, 25, 0, 'and <a href="/profile/12" rel="friend">Anastasiya Deeva</a> are now friends.', '', 1380222075);

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `extended_address` char(128) DEFAULT NULL,
  `latitude` int(11) DEFAULT NULL,
  `locality` varchar(128) DEFAULT NULL,
  `longitude` int(11) DEFAULT NULL,
  `po_box` char(32) DEFAULT NULL,
  `postal_code` char(32) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `street_address` char(128) DEFAULT NULL,
  `address_type` char(128) DEFAULT NULL,
  `unstructured_address` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `addresses`
--


-- --------------------------------------------------------

--
-- Структура таблицы `albums`
--

DROP TABLE IF EXISTS `albums`;
CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) DEFAULT NULL,
  `description` text,
  `address_id` int(11) DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `media_mime_type` char(64) DEFAULT NULL,
  `media_type` enum('AUDIO','IMAGE','VIDEO') NOT NULL,
  `thumbnail_url` char(128) DEFAULT NULL,
  `app_id` int(11) DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  `modified` int(11) DEFAULT NULL,
  `media_count` int(11) DEFAULT '0',
  `media_id` int(11) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `albums`
--

INSERT INTO `albums` (`id`, `title`, `description`, `address_id`, `owner_id`, `media_mime_type`, `media_type`, `thumbnail_url`, `app_id`, `created`, `modified`, `media_count`, `media_id`) VALUES
(6, 'Фотки', '', NULL, 13, 'image', 'IMAGE', '/images/albums/6/177.220x220.jpg', 0, 1363147462, 1363324087, 1, 177),
(9, 'Korben Dallas', '', NULL, 14, 'image', 'IMAGE', '/images/albums/9/161.220x220.jpg', 0, 1363321596, 1363580545, 12, 161),
(8, 'nmbmnb', 'nbkjhjk', NULL, 12, 'image', 'IMAGE', '/images/albums/8/159.220x220.png', 0, 1363152284, 1380265479, 6, 159),
(10, 'Ралли', 'Город Челябинск, поворот на вахрушево', NULL, 14, 'image', 'IMAGE', '/images/albums/10/184.220x220.jpg', 0, 1363596176, 1363596206, 7, 184),
(11, 'Кантегир 2013', '', NULL, 13, 'image', 'IMAGE', '/images/albums/11/235.220x220.jpg', 0, 1364056869, 1364057095, 29, 235),
(12, 'Китай Весна 2013', '', NULL, 21, 'image', 'IMAGE', NULL, 0, 1365170960, 1365170960, 0, NULL),
(13, '', '', NULL, 24, 'image', 'IMAGE', NULL, 0, 1368650678, 1368650678, 0, NULL),
(14, '1', '', NULL, 30, 'image', 'IMAGE', '/images/albums/14/487.220x220.png', 0, 1388451534, 1396037324, 4, 487);

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` char(128) NOT NULL,
  `title` char(128) DEFAULT NULL,
  `directory_title` varchar(128) DEFAULT NULL,
  `screenshot` char(128) DEFAULT NULL,
  `thumbnail` char(128) DEFAULT NULL,
  `author` char(128) DEFAULT NULL,
  `author_email` char(128) DEFAULT NULL,
  `description` mediumtext,
  `settings` mediumtext,
  `views` mediumtext,
  `version` varchar(64) NOT NULL,
  `height` int(11) NOT NULL DEFAULT '0',
  `scrolling` int(11) NOT NULL DEFAULT '0',
  `approved` enum('Y','N') DEFAULT 'N',
  `modified` int(11) NOT NULL,
  UNIQUE KEY `url` (`url`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `applications`
--


-- --------------------------------------------------------

--
-- Структура таблицы `application_settings`
--

DROP TABLE IF EXISTS `application_settings`;
CREATE TABLE IF NOT EXISTS `application_settings` (
  `application_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `name` char(128) NOT NULL,
  `value` char(255) NOT NULL,
  UNIQUE KEY `application_id` (`application_id`,`person_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `application_settings`
--


-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `txt` text,
  `shop_id` int(11) DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  `ordr` int(11) NOT NULL DEFAULT '0',
  `article_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `visible` (`visible`),
  KEY `ordr` (`ordr`),
  KEY `shop_id` (`shop_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `article`
--

INSERT INTO `article` (`id`, `name`, `txt`, `shop_id`, `visible`, `ordr`, `article_id`) VALUES
(15, 'Контакты', 'г. Челябинск, автодорога Меридиан\r\nТК Галеон\r\n8 (351) 2002135\r\n8 (351) 2002125', 13, 1, 1, 0),
(16, 'О Компании', 'квп куыр вапрт ыа купр ваыр е\r\nкувнр кер ыве\r\n кер екар', 13, 1, 2, 0),
(17, 'статья', 'ффывфыв фыв', 14, 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `authenticated`
--

DROP TABLE IF EXISTS `authenticated`;
CREATE TABLE IF NOT EXISTS `authenticated` (
  `person_id` int(11) NOT NULL,
  `hash` varchar(41) NOT NULL,
  PRIMARY KEY (`hash`),
  UNIQUE KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authenticated`
--

INSERT INTO `authenticated` (`person_id`, `hash`) VALUES
(4, '1cc30923fc36a2d1ebdd145212e67c89064b4ae0'),
(5, 'a1a4f91dc5b5886cb7102af1af8b816a8f409032'),
(6, 'c60683252f992852e173e652cea5c9e014386564'),
(11, '901aa76efd669130621606d6f8886fd0d1658ab2'),
(13, 'a2d6062b35fbcfbcff38ebbc216a8f55e714da67'),
(14, 'f098fe4a1df6753ae4281164aafba3eec02d8f77'),
(16, '8eee3fa79b3a49480c981733b06c6aee7639da5f'),
(17, '5b0df24c522bcf51541ee1d5e4e942e27b55c464'),
(18, '45105479efec29d0c5e874a70094313592c64bda'),
(19, '023717c4c6ff096501750c258f5d44de4513c9fe'),
(20, '1afa579a792a14fc19e68d84fa4a81d74edfb803'),
(21, '09e9eda7b89c9391b3f02cbaf17ec88a4315b9af'),
(22, '519de7c3a8b588911bbf5dab1851154fe25a962f'),
(23, '2edec020e86d8e0b2f9b3a5ef029e702af87158f'),
(24, '4f81633b71b1ea6c6b1428d45a1ff84f2b170f0c'),
(1, '2ff8e0549b414f4c9655ce0f0e0eab84c67ed600'),
(2, 'eb8f1e5719f4d1abf233387b82b33a8a0633c45a'),
(3, '042759655be44155bfb2240a160da55c3f011f1a'),
(25, '84185c47f0b4ab90da5935d19e467c4d909f56ba'),
(26, '8afdb4afa81c4b93ad7d0f380bc4c9fbbd4d7b27'),
(27, '33c2e239dd623c7c521a434add15f3e2424fea03'),
(28, '8fe528bd7eccb3130f5b5c84b5695c4a4cd8e41c'),
(29, '34dfd47028152cdff945300953c63aebcfca5414'),
(30, '97aeb48fd3e75a377f8d0a02cae6a40e490bd00e'),
(31, 'f9d9172af48cba6a037a30c0bf50a820014cee04'),
(32, 'c96699719833e632cf3f5f7b181ac23ed7a13637'),
(33, 'af4fa40f8af1211435aeecde9e53110fd3399e67');

-- --------------------------------------------------------

--
-- Структура таблицы `car`
--

DROP TABLE IF EXISTS `car`;
CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marka_id` int(11) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `descr` text,
  `complect` char(250) DEFAULT NULL,
  `isvisible` int(1) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `model_id` (`model_id`),
  KEY `year` (`year`),
  KEY `complect` (`complect`),
  KEY `marka_id` (`marka_id`),
  KEY `isvisible` (`isvisible`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=323 ;

--
-- Дамп данных таблицы `car`
--

INSERT INTO `car` (`id`, `marka_id`, `model_id`, `person_id`, `year`, `descr`, `complect`, `isvisible`, `created`) VALUES
(171, 17, 183, 12, 2000, '', 'compl', 1, 1375301080),
(170, 89, 0, 12, 2012, '123123', '', 1, 1375272529),
(322, NULL, NULL, 33, NULL, NULL, NULL, 0, 1401187619),
(321, NULL, NULL, 31, NULL, NULL, NULL, 0, 1401186612);

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` decimal(19,2) NOT NULL,
  `sum` decimal(19,2) NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`,`person_id`,`product_id`),
  KEY `currency_id` (`currency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `shop_id`, `person_id`, `product_id`, `num`, `price`, `sum`, `currency_id`) VALUES
(45, 14, 30, 45, 4, 123.12, 492.48, 2),
(44, 14, 30, 17, 1, 12.00, 12.00, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `car_marka`
--

DROP TABLE IF EXISTS `car_marka`;
CREATE TABLE IF NOT EXISTS `car_marka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isrussian` int(1) DEFAULT '0',
  `name` char(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `isrussia` (`isrussian`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=130 ;

--
-- Дамп данных таблицы `car_marka`
--

INSERT INTO `car_marka` (`id`, `isrussian`, `name`) VALUES
(2, 1, 'АСТРО'),
(3, 1, 'ВАЗ'),
(4, 1, 'ГАЗ'),
(5, 1, 'ЗАЗ'),
(6, 1, 'ЗИЛ'),
(7, 1, 'ИЖ'),
(8, 1, 'КАМАЗ'),
(9, 1, 'ЛУАЗ'),
(10, 1, 'МОСКВИЧ (АЗЛК)'),
(11, 1, 'СЕАЗ'),
(12, 1, 'СМЗ'),
(13, 1, 'ТАГАЗ'),
(14, 1, 'УАЗ'),
(15, 1, 'ЭКСКЛЮЗИВ'),
(16, 0, 'AC'),
(17, 0, 'ACURA'),
(18, 0, 'ALFA ROMEO'),
(19, 0, 'ARO'),
(20, 0, 'ASIA'),
(21, 0, 'ASTON MARTIN'),
(22, 0, 'AUDI'),
(23, 0, 'BENTLEY'),
(24, 0, 'BMW'),
(25, 0, 'BMW ALPINA'),
(26, 0, 'BRILLIANCE'),
(27, 0, 'BUFORI'),
(28, 0, 'BUGATTI'),
(29, 0, 'BUICK'),
(30, 0, 'BYD'),
(31, 0, 'CADILLAC'),
(32, 0, 'CHERY'),
(33, 0, 'CHEVROLET'),
(34, 0, 'CHRYSLER'),
(35, 0, 'CITROEN'),
(36, 0, 'DACIA'),
(37, 0, 'DADI'),
(38, 0, 'DAEWOO'),
(39, 0, 'DAIHATSU'),
(40, 0, 'DAIMLER'),
(41, 0, 'DE LOREAN'),
(42, 0, 'DERWAYS'),
(43, 0, 'DODGE'),
(44, 0, 'DONINVEST'),
(45, 0, 'EAGLE'),
(46, 0, 'FAW'),
(47, 0, 'FERRARI'),
(48, 0, 'FIAT'),
(49, 0, 'FISKER'),
(50, 0, 'FORD'),
(51, 0, 'GEELY'),
(52, 0, 'GEO'),
(53, 0, 'GMC'),
(54, 0, 'GREAT WALL'),
(55, 0, 'HAFEI'),
(56, 0, 'HAIMA'),
(57, 0, 'HONDA'),
(58, 0, 'HUANGHAI'),
(59, 0, 'HUMMER'),
(60, 0, 'HYUNDAI'),
(61, 0, 'INFINITI'),
(62, 0, 'IRAN KHODRO'),
(63, 0, 'ISUZU'),
(64, 0, 'JAC'),
(65, 0, 'JAGUAR'),
(66, 0, 'JEEP'),
(67, 0, 'JMC'),
(68, 0, 'KIA'),
(69, 0, 'KOENIGSEGG'),
(70, 0, 'LAMBORGHINI'),
(71, 0, 'LANCIA'),
(72, 0, 'LAND ROVER'),
(73, 0, 'LEXUS'),
(74, 0, 'LIFAN'),
(75, 0, 'LINCOLN'),
(76, 0, 'LOTUS'),
(77, 0, 'MAHINDRA'),
(78, 0, 'MASERATI'),
(79, 0, 'MAYBACH'),
(80, 0, 'MAZDA'),
(81, 0, 'MERCEDES-BENZ'),
(82, 0, 'MERCURY'),
(83, 0, 'METROCAB'),
(84, 0, 'MG'),
(85, 0, 'MINI'),
(86, 0, 'MITSUBISHI'),
(87, 0, 'MITSUOKA'),
(88, 0, 'MORGAN'),
(89, 0, 'NISSAN'),
(90, 0, 'OLDSMOBILE'),
(91, 0, 'OPEL'),
(92, 0, 'PAGANI'),
(93, 0, 'PEUGEOT'),
(94, 0, 'PLYMOUTH'),
(95, 0, 'PONTIAC'),
(96, 0, 'PORSCHE'),
(97, 0, 'PROTON'),
(98, 0, 'PUCH'),
(99, 0, 'RENAULT'),
(100, 0, 'ROLLS-ROYCE'),
(101, 0, 'ROVER'),
(102, 0, 'SAAB'),
(103, 0, 'SALEEN'),
(104, 0, 'SATURN'),
(105, 0, 'SCION'),
(106, 0, 'SEAT'),
(107, 0, 'SHUANGHUAN'),
(108, 0, 'SKODA'),
(109, 0, 'SMA'),
(110, 0, 'SMART'),
(111, 0, 'SPYKER'),
(112, 0, 'SSANG YONG'),
(113, 0, 'SUBARU'),
(114, 0, 'SUZUKI'),
(115, 0, 'TATA'),
(116, 0, 'TIANMA'),
(117, 0, 'TIANYE'),
(118, 0, 'Tesla'),
(119, 0, 'TOYOTA'),
(120, 0, 'TRABANT'),
(121, 0, 'VAUXHALL'),
(122, 0, 'VOLKSWAGEN'),
(123, 0, 'VOLVO'),
(124, 0, 'VORTEX'),
(125, 0, 'WARTBURG'),
(126, 0, 'WIESMANN'),
(127, 0, 'XIN KAI'),
(128, 0, 'ZASTAVA'),
(129, 0, 'ZX');

-- --------------------------------------------------------

--
-- Структура таблицы `car_model`
--

DROP TABLE IF EXISTS `car_model`;
CREATE TABLE IF NOT EXISTS `car_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marka_id` int(11) DEFAULT NULL,
  `name` char(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `marka_id` (`marka_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1817 ;

--
-- Дамп данных таблицы `car_model`
--

INSERT INTO `car_model` (`id`, `marka_id`, `name`) VALUES
(2, 3, '1111&nbsp;Ока'),
(3, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1111'),
(4, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11113'),
(5, 3, '2101'),
(6, 3, '2102'),
(7, 3, '2103'),
(8, 3, '2104'),
(9, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2104'),
(10, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21043'),
(11, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21045'),
(12, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21047'),
(13, 3, '2105'),
(14, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2105'),
(15, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21053'),
(16, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21054'),
(17, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21058'),
(18, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21059'),
(19, 3, '2106'),
(20, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2106'),
(21, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21061'),
(22, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21063'),
(23, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21065'),
(24, 3, '2107'),
(25, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2107'),
(26, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21071'),
(27, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21072'),
(28, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21073'),
(29, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21074'),
(30, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21079'),
(31, 3, '2108'),
(32, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2108'),
(33, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21081'),
(34, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21083'),
(35, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21086'),
(36, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2108I'),
(37, 3, '2109'),
(38, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2109'),
(39, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21091'),
(40, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21093'),
(41, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21096'),
(42, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21099'),
(43, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21099I'),
(44, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2109I'),
(45, 3, '2110'),
(46, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2110'),
(47, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21101'),
(48, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21102'),
(49, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21103'),
(50, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21104'),
(51, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21106'),
(52, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21108'),
(53, 3, 'Богдан'),
(54, 3, '2111'),
(55, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2111'),
(56, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21111'),
(57, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21112'),
(58, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21113'),
(59, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21114'),
(60, 3, 'Богдан'),
(61, 3, '2112'),
(62, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2112'),
(63, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21121'),
(64, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21122'),
(65, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21123'),
(66, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21124'),
(67, 3, '2113'),
(68, 3, '2114'),
(69, 3, '2115'),
(70, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2115'),
(71, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2115&nbsp;WANKEL'),
(72, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2115I'),
(73, 3, '2120&nbsp;Надежда'),
(74, 3, '2121&nbsp;4X4'),
(75, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2121'),
(76, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21213'),
(77, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21214'),
(78, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21217'),
(79, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21218'),
(80, 3, '2123'),
(81, 3, '2129'),
(82, 3, '2131'),
(83, 3, '2329'),
(84, 3, 'GRANTA'),
(85, 3, 'KALINA'),
(86, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1117&nbsp;KALINA&nbsp;Универсал'),
(87, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1118&nbsp;KALINA&nbsp;Седан'),
(88, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1119&nbsp;KALINA&nbsp;SPORT'),
(89, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1119&nbsp;KALINA&nbsp;Хатчбек'),
(90, 3, 'LARGUS'),
(91, 3, 'PRIORA'),
(92, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2170&nbsp;PRIORA&nbsp;Седан'),
(93, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21708'),
(94, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2171&nbsp;PRIORA&nbsp;Универсал'),
(95, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2172&nbsp;PRIORA&nbsp;Хатчбэк'),
(96, 3, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;21728&nbsp;PRIORA&nbsp;COUPE'),
(97, 4, '13'),
(98, 4, '14'),
(99, 4, '20'),
(100, 4, '21'),
(101, 4, '22'),
(102, 4, '2330'),
(103, 4, '24'),
(104, 4, '31'),
(105, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3102'),
(106, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;310221'),
(107, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;31029'),
(108, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3102I'),
(109, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3105'),
(110, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3110'),
(111, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;31105'),
(112, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;311055'),
(113, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3110I'),
(114, 4, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3111'),
(115, 4, '69'),
(116, 4, 'SIBER'),
(117, 4, 'М1'),
(118, 5, '1102'),
(119, 5, '1103&nbsp;SLAVUTA'),
(120, 5, '1105'),
(121, 5, '1125'),
(122, 5, '1140'),
(123, 5, '965'),
(124, 5, '966'),
(125, 5, '968'),
(126, 5, 'CHANCE'),
(127, 5, 'SENS'),
(128, 5, 'VIDA'),
(129, 6, '114'),
(130, 6, '4104'),
(131, 7, '2125'),
(132, 7, '2126'),
(133, 7, '21261'),
(134, 7, '2717'),
(135, 7, '412'),
(136, 8, 'ОКА'),
(137, 9, '967'),
(138, 9, '969'),
(139, 10, '2137&nbsp;KOMBI'),
(140, 10, '2138'),
(141, 10, '2140'),
(142, 10, '2141'),
(143, 10, '400'),
(144, 10, '401'),
(145, 10, '402'),
(146, 10, '403'),
(147, 10, '407'),
(148, 10, '408'),
(149, 10, '412'),
(150, 10, '423&nbsp;KOMBI'),
(151, 10, 'Калита'),
(152, 10, 'Князь&nbsp;Владимир'),
(153, 10, 'Святогор'),
(154, 10, 'Юрий&nbsp;Долгорукий'),
(155, 11, '1111'),
(156, 11, '11116'),
(157, 12, 'Мотокаляска'),
(158, 13, 'C-10'),
(159, 13, 'C-190'),
(160, 13, 'ESTINA'),
(161, 13, 'ROAD&nbsp;PARTNER'),
(162, 13, 'SONATA'),
(163, 13, 'TAGER'),
(164, 13, 'TIGGO'),
(165, 13, 'VEGA'),
(166, 14, '2317'),
(167, 14, '2363&nbsp;PICKUP'),
(168, 14, '3151'),
(169, 14, '315108&nbsp;HUNTER'),
(170, 14, '31512'),
(171, 14, '31514'),
(172, 14, '31517'),
(173, 14, '31519'),
(174, 14, '315195&nbsp;HUNTER'),
(175, 14, '3153'),
(176, 14, '3159'),
(177, 14, '3160'),
(178, 14, '3162'),
(179, 14, '3163&nbsp;PATRIOT'),
(180, 14, '3164'),
(181, 14, '469'),
(182, 17, 'CSX'),
(183, 17, 'EL'),
(184, 17, 'INTEGRA'),
(185, 17, 'LEGEND'),
(186, 17, 'MDX'),
(187, 17, 'RDX'),
(188, 17, 'RL'),
(189, 17, 'RSX'),
(190, 17, 'TL'),
(191, 17, 'TSX'),
(192, 17, 'ZDX'),
(193, 18, '145'),
(194, 18, '146'),
(195, 18, '147'),
(196, 18, '155'),
(197, 18, '156'),
(198, 18, '159'),
(199, 18, '164'),
(200, 18, '166'),
(201, 18, '33'),
(202, 18, '75'),
(203, 18, '8C'),
(204, 18, 'BRERA'),
(205, 18, 'GT'),
(206, 18, 'GTV'),
(207, 18, 'MITO'),
(208, 18, 'SPIDER'),
(209, 20, 'AURORA'),
(210, 20, 'COWBOY'),
(211, 20, 'PLUTUS'),
(212, 20, 'SHUTTLE'),
(213, 21, 'DB7'),
(214, 21, 'DB9'),
(215, 21, 'DBS'),
(216, 21, 'RAPIDE'),
(217, 21, 'V12&nbsp;VANQUISH'),
(218, 21, 'V8'),
(219, 21, 'VANTAGE'),
(220, 22, '100'),
(221, 22, '200'),
(222, 22, '80'),
(223, 22, '90'),
(224, 22, 'A1'),
(225, 22, 'A2'),
(226, 22, 'A3'),
(227, 22, 'A4'),
(228, 22, 'A5'),
(229, 22, 'A6'),
(230, 22, 'A7'),
(231, 22, 'A8'),
(232, 22, 'ALLROAD'),
(233, 22, 'COUPE'),
(234, 22, 'Q3'),
(235, 22, 'Q5'),
(236, 22, 'Q7'),
(237, 22, 'QUATTRO'),
(238, 22, 'R8'),
(239, 22, 'RS2'),
(240, 22, 'RS4'),
(241, 22, 'RS5'),
(242, 22, 'RS6'),
(243, 22, 'S2'),
(244, 22, 'S3'),
(245, 22, 'S4'),
(246, 22, 'S5'),
(247, 22, 'S6'),
(248, 22, 'S8'),
(249, 22, 'TT'),
(250, 22, 'V8&nbsp;(D11)'),
(251, 23, 'ARNAGE'),
(252, 23, 'AZURE'),
(253, 23, 'BROOKLANDS'),
(254, 23, 'CONTINENTAL'),
(255, 23, 'CONTINENTAL&nbsp;FLYING&nbsp;SPUR'),
(256, 23, 'CONTINENTAL&nbsp;GT'),
(257, 23, 'CONTINENTAL&nbsp;GTC'),
(258, 23, 'CONTINENTAL&nbsp;SUPERSPORTS'),
(259, 23, 'MULSANNE'),
(260, 23, 'TURBO&nbsp;R'),
(261, 24, '1ER'),
(262, 24, '116'),
(263, 24, '118'),
(264, 24, '120'),
(265, 24, '123'),
(266, 24, '125'),
(267, 24, '130'),
(268, 24, '135'),
(269, 24, '3ER'),
(270, 24, '315'),
(271, 24, '316'),
(272, 24, '318'),
(273, 24, '320'),
(274, 24, '323'),
(275, 24, '324'),
(276, 24, '325'),
(277, 24, '328'),
(278, 24, '330'),
(279, 24, '335'),
(280, 24, '5ER'),
(281, 24, '518'),
(282, 24, '520'),
(283, 24, '523'),
(284, 24, '524'),
(285, 24, '525'),
(286, 24, '528'),
(287, 24, '530'),
(288, 24, '535'),
(289, 24, '540'),
(290, 24, '545'),
(291, 24, '550'),
(292, 24, '6ER'),
(293, 24, '630'),
(294, 24, '635'),
(295, 24, '640'),
(296, 24, '645'),
(297, 24, '650'),
(298, 24, '7ER'),
(299, 24, '725'),
(300, 24, '728'),
(301, 24, '730'),
(302, 24, '732'),
(303, 24, '735'),
(304, 24, '740'),
(305, 24, '745'),
(306, 24, '750'),
(307, 24, '760'),
(308, 24, '8ER'),
(309, 24, 'GRAN&nbsp;TURISMO'),
(310, 24, 'M'),
(311, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M1'),
(312, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M3'),
(313, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M5'),
(314, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M6'),
(315, 24, 'X'),
(316, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X1'),
(317, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X3'),
(318, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X5'),
(319, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X5&nbsp;M'),
(320, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X6'),
(321, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X6&nbsp;M'),
(322, 24, 'Z'),
(323, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z1'),
(324, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z3'),
(325, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z3&nbsp;M'),
(326, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z4'),
(327, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z4&nbsp;M'),
(328, 24, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Z8'),
(329, 25, 'B10'),
(330, 25, 'B11'),
(331, 25, 'B12'),
(332, 25, 'B3'),
(333, 25, 'B5'),
(334, 25, 'B6'),
(335, 25, 'B7'),
(336, 25, 'B8'),
(337, 25, 'C1'),
(338, 25, 'D3'),
(339, 26, 'FRV'),
(340, 26, 'M1'),
(341, 26, 'M2'),
(342, 28, 'EB&nbsp;16.4'),
(343, 29, 'ELECTRA'),
(344, 29, 'ENCLAVE'),
(345, 29, 'LE&nbsp;SABRE'),
(346, 29, 'PARK&nbsp;AVENUE'),
(347, 29, 'REGAL'),
(348, 29, 'RENDEZVOUS'),
(349, 29, 'RIVIERA'),
(350, 29, 'ROADMASTER'),
(351, 29, 'SKYLARK'),
(352, 30, 'F0'),
(353, 30, 'F3'),
(354, 30, 'FLYER&nbsp;II'),
(355, 31, 'BLS'),
(356, 31, 'CATERA'),
(357, 31, 'CTS'),
(358, 31, 'DE&nbsp;VILLE'),
(359, 31, 'DTS'),
(360, 31, 'ELDORADO'),
(361, 31, 'ESCALADE'),
(362, 31, 'FLEETWOOD'),
(363, 31, 'SEVILLE'),
(364, 31, 'SRX'),
(365, 31, 'STS'),
(366, 32, 'AMULET'),
(367, 32, 'BONUS&nbsp;(A13)'),
(368, 32, 'CROSSEASTAR'),
(369, 32, 'FORA'),
(370, 32, 'INDIS&nbsp;(S18D)'),
(371, 32, 'KIMO&nbsp;(A1)'),
(372, 32, 'M11'),
(373, 32, 'ORIENTAL&nbsp;SON'),
(374, 32, 'QQ6&nbsp;(S21)'),
(375, 32, 'SWEET&nbsp;(QQ)'),
(376, 32, 'TIGGO'),
(377, 32, 'VERY'),
(378, 33, 'ALERO'),
(379, 33, 'ASTRO'),
(380, 33, 'AVALANCHE'),
(381, 33, 'AVEO'),
(382, 33, 'BEL&nbsp;AIR'),
(383, 33, 'BERETTA'),
(384, 33, 'BLAZER'),
(385, 33, 'C-10'),
(386, 33, 'CAMARO'),
(387, 33, 'CAPRICE'),
(388, 33, 'CAPTIVA'),
(389, 33, 'CAVALIER'),
(390, 33, 'CELEBRITY'),
(391, 33, 'COBALT'),
(392, 33, 'COLORADO'),
(393, 33, 'CORSICA'),
(394, 33, 'CORVETTE'),
(395, 33, 'CRUZE'),
(396, 33, 'EPICA'),
(397, 33, 'EQUINOX'),
(398, 33, 'EVANDA'),
(399, 33, 'EXPRESS'),
(400, 33, 'HHR'),
(401, 33, 'IMPALA'),
(402, 33, 'KALOS'),
(403, 33, 'LACETTI'),
(404, 33, 'LANOS'),
(405, 33, 'LUMINA'),
(406, 33, 'MALIBU'),
(407, 33, 'METRO'),
(408, 33, 'MONTE&nbsp;CARLO'),
(409, 33, 'NIVA'),
(410, 33, 'NUBIRA'),
(411, 33, 'ORLANDO'),
(412, 33, 'PRIZM'),
(413, 33, 'REZZO'),
(414, 33, 'SPARK'),
(415, 33, 'SSR'),
(416, 33, 'STARCRAFT'),
(417, 33, 'SUBURBAN'),
(418, 33, 'TAHOE'),
(419, 33, 'TRACKER'),
(420, 33, 'TRAILBLAZER'),
(421, 33, 'TRANS&nbsp;SPORT'),
(422, 33, 'UPLANDER'),
(423, 33, 'VAN'),
(424, 33, 'VENTURE'),
(425, 33, 'VIVA'),
(426, 33, 'ZAFIRA'),
(427, 34, '200'),
(428, 34, '300C'),
(429, 34, '300M'),
(430, 34, 'ASPEN'),
(431, 34, 'CIRRUS'),
(432, 34, 'CONCORDE'),
(433, 34, 'CROSSFIRE'),
(434, 34, 'DAYTONA&nbsp;SHELBY'),
(435, 34, 'FIFTH&nbsp;AVENUE'),
(436, 34, 'GRAND&nbsp;VOYAGER'),
(437, 34, 'INTREPID'),
(438, 34, 'LE&nbsp;BARON'),
(439, 34, 'LHS'),
(440, 34, 'NEON'),
(441, 34, 'NEW&nbsp;YORKER'),
(442, 34, 'PACIFICA'),
(443, 34, 'PT&nbsp;CRUISER'),
(444, 34, 'SARATOGA'),
(445, 34, 'SEBRING'),
(446, 34, 'STRATUS'),
(447, 34, 'TOWN&nbsp;&&nbsp;COUNTRY'),
(448, 34, 'VISION'),
(449, 34, 'VOYAGER'),
(450, 35, 'AX'),
(451, 35, 'BERLINGO'),
(452, 35, 'BX'),
(453, 35, 'C-CROSSER'),
(454, 35, 'C1'),
(455, 35, 'C2'),
(456, 35, 'C3'),
(457, 35, 'C4'),
(458, 35, 'C4'),
(459, 35, 'C4&nbsp;AIRCROSS'),
(460, 35, 'C4&nbsp;PICASSO'),
(461, 35, 'C5'),
(462, 35, 'C6'),
(463, 35, 'C8'),
(464, 35, 'CX'),
(465, 35, 'DS3'),
(466, 35, 'DS4'),
(467, 35, 'EVASION'),
(468, 35, 'SAXO'),
(469, 35, 'XANTIA'),
(470, 35, 'XM'),
(471, 35, 'XSARA'),
(472, 35, 'XSARA'),
(473, 35, 'XSARA&nbsp;PICASSO'),
(474, 35, 'ZX'),
(475, 36, 'LOGAN'),
(476, 36, 'SANDERO'),
(477, 37, 'CITY&nbsp;LEADING'),
(478, 37, 'SHUTTLE'),
(479, 37, 'SMOOTHING'),
(480, 38, 'DAMAS'),
(481, 38, 'ESPERO'),
(482, 38, 'EVANDA'),
(483, 38, 'GENTRA'),
(484, 38, 'KALOS'),
(485, 38, 'LACETTI'),
(486, 38, 'LANOS&nbsp;(SENS)'),
(487, 38, 'LEGANZA'),
(488, 38, 'MAGNUS'),
(489, 38, 'MATIZ'),
(490, 38, 'NEXIA'),
(491, 38, 'NUBIRA'),
(492, 38, 'PRINCE'),
(493, 38, 'RACER'),
(494, 38, 'REZZO'),
(495, 38, 'TACUMA'),
(496, 38, 'TICO'),
(497, 38, 'TOSCA'),
(498, 38, 'WINSTORM'),
(499, 39, 'APPLAUSE'),
(500, 39, 'ATRAI/EXTOL'),
(501, 39, 'BOON'),
(502, 39, 'CHARADE'),
(503, 39, 'CHARMANT'),
(504, 39, 'COPEN'),
(505, 39, 'CUORE'),
(506, 39, 'ESSE'),
(507, 39, 'FEROZA'),
(508, 39, 'MATERIA'),
(509, 39, 'MIRA'),
(510, 39, 'MIRA&nbsp;GINO'),
(511, 39, 'MOVE'),
(512, 39, 'PYZAR'),
(513, 39, 'ROCKY'),
(514, 39, 'SIRION'),
(515, 39, 'SONICA'),
(516, 39, 'STORIA'),
(517, 39, 'TANTO'),
(518, 39, 'TERIOS'),
(519, 39, 'TREVIS'),
(520, 39, 'YRV'),
(521, 40, 'DAIMLER'),
(522, 40, 'LIMOUSINE'),
(523, 40, 'SUPER&nbsp;EIGHT'),
(524, 41, 'DMC-12'),
(525, 42, 'ANTELOPE'),
(526, 42, 'AURORA'),
(527, 42, 'COWBOY'),
(528, 42, 'PLUTUS'),
(529, 42, 'SHUTTLE'),
(530, 43, 'AVENGER'),
(531, 43, 'CALIBER'),
(532, 43, 'CARAVAN'),
(533, 43, 'GRAND&nbsp;CARAVAN'),
(534, 43, 'CHALLENGER'),
(535, 43, 'CHARGER'),
(536, 43, 'DAKOTA'),
(537, 43, 'DAYTONA'),
(538, 43, 'DURANGO'),
(539, 43, 'DYNASTY'),
(540, 43, 'INTREPID'),
(541, 43, 'JOURNEY'),
(542, 43, 'MAGNUM'),
(543, 43, 'NEON'),
(544, 43, 'NITRO'),
(545, 43, 'RAM'),
(546, 43, 'SHADOW'),
(547, 43, 'SPIRIT'),
(548, 43, 'STEALTH'),
(549, 43, 'STRATUS'),
(550, 43, 'VIPER'),
(551, 44, 'ASSOL'),
(552, 44, 'KONDOR'),
(553, 44, 'ORION'),
(554, 45, 'TALON'),
(555, 45, 'VISION'),
(556, 46, 'JINN'),
(557, 46, 'VITA'),
(558, 47, '348'),
(559, 47, '360'),
(560, 47, '430'),
(561, 47, '456'),
(562, 47, '458&nbsp;ITALIA'),
(563, 47, '599'),
(564, 47, '612&nbsp;SCAGLIETTI'),
(565, 47, 'CALIFORNIA'),
(566, 47, 'FF'),
(567, 47, 'MARANELLO'),
(568, 48, '124'),
(569, 48, '126'),
(570, 48, '500'),
(571, 48, 'ALBEA'),
(572, 48, 'ARGENTA'),
(573, 48, 'BARCHETTA'),
(574, 48, 'BRAVA'),
(575, 48, 'BRAVO'),
(576, 48, 'COUPE'),
(577, 48, 'CROMA'),
(578, 48, 'DOBLO'),
(579, 48, 'FIORINO'),
(580, 48, 'IDEA'),
(581, 48, 'LINEA'),
(582, 48, 'MAREA'),
(583, 48, 'MULTIPLA'),
(584, 48, 'NEW&nbsp;500'),
(585, 48, 'PALIO'),
(586, 48, 'PANDA'),
(587, 48, 'PUNTO'),
(588, 48, 'QUBO'),
(589, 48, 'RITMO'),
(590, 48, 'SEDICI'),
(591, 48, 'SIENA'),
(592, 48, 'STILO'),
(593, 48, 'TEMPRA'),
(594, 48, 'TIPO'),
(595, 48, 'ULYSSE'),
(596, 48, 'UNO'),
(597, 49, 'KARMA'),
(598, 50, 'AEROSTAR'),
(599, 50, 'ASPIRE'),
(600, 50, 'BRONCO'),
(601, 50, 'C-MAX'),
(602, 50, 'CAPRI'),
(603, 50, 'CONTOUR'),
(604, 50, 'COUGAR'),
(605, 50, 'CROWN&nbsp;VICTORIA'),
(606, 50, 'ECONOLINE'),
(607, 50, 'EDGE'),
(608, 50, 'ESCAPE'),
(609, 50, 'ESCORT'),
(610, 50, 'EXCURSION'),
(611, 50, 'EXPEDITION'),
(612, 50, 'EXPLORER'),
(613, 50, 'F-SERIES'),
(614, 50, 'FESTIVA'),
(615, 50, 'FIESTA'),
(616, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FIESTA'),
(617, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ST'),
(618, 50, '&nbsp;'),
(619, 50, 'FOCUS'),
(620, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FOCUS'),
(621, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RS'),
(622, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ST'),
(623, 50, 'FREESTAR'),
(624, 50, 'FREESTYLE'),
(625, 50, 'FUSION'),
(626, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FUSION'),
(627, 50, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FUSION&nbsp;(USA)'),
(628, 50, 'GALAXY'),
(629, 50, 'GRANADA'),
(630, 50, 'GRANADA&nbsp;(USA)'),
(631, 50, 'GT'),
(632, 50, 'KA'),
(633, 50, 'KUGA'),
(634, 50, 'LASER'),
(635, 50, 'MAVERICK'),
(636, 50, 'MONDEO'),
(637, 50, '&nbsp;'),
(638, 50, 'MUSTANG'),
(639, 50, 'ORION'),
(640, 50, 'PROBE'),
(641, 50, 'PUMA'),
(642, 50, 'RANGER'),
(643, 50, 'S-MAX'),
(644, 50, 'SCORPIO'),
(645, 50, 'SHELBY'),
(646, 50, 'SIERRA'),
(647, 50, 'SPORT&nbsp;TRAC'),
(648, 50, 'TAUNUS'),
(649, 50, 'TAURUS'),
(650, 50, 'TEMPO'),
(651, 50, 'THUNDERBIRD'),
(652, 50, 'TOURNEO&nbsp;CONNECT'),
(653, 50, 'WINDSTAR'),
(654, 51, 'EMGRAND'),
(655, 51, 'HAOQING'),
(656, 51, 'MK'),
(657, 51, 'MK&nbsp;CROSS'),
(658, 51, 'OTAKA'),
(659, 51, 'VISION'),
(660, 52, 'PRIZM'),
(661, 52, 'TRACKER'),
(662, 53, 'ACADIA'),
(663, 53, 'ENVOY'),
(664, 53, 'JIMMY'),
(665, 53, 'SAFARI'),
(666, 53, 'SAVANA'),
(667, 53, 'SIERRA'),
(668, 53, 'SUBURBAN'),
(669, 53, 'TERRAIN'),
(670, 53, 'TYPHOON'),
(671, 53, 'VANDURA'),
(672, 53, 'YUKON'),
(673, 54, 'COOL&nbsp;BEAR'),
(674, 54, 'DEER'),
(675, 54, 'FLORID'),
(676, 54, 'HOVER'),
(677, 54, 'PEGASUS'),
(678, 54, 'PERI'),
(679, 54, 'SAFE'),
(680, 54, 'SAILOR'),
(681, 54, 'SING&nbsp;RUV'),
(682, 54, 'SOCOOL'),
(683, 54, 'SUV'),
(684, 54, 'WINGLE'),
(685, 55, 'BRIO'),
(686, 55, 'PRINCIP'),
(687, 55, 'SIMBO'),
(688, 56, '3'),
(689, 57, 'ACCORD'),
(690, 57, 'AIRWAVE'),
(691, 57, 'ASCOT'),
(692, 57, 'AVANCIER'),
(693, 57, 'CAPA'),
(694, 57, 'CITY'),
(695, 57, 'CIVIC'),
(696, 57, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CIVIC'),
(697, 57, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FERIO'),
(698, 57, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HYBRID'),
(699, 57, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SHUTTLE'),
(700, 57, 'CONCERTO'),
(701, 57, 'CR-V'),
(702, 57, 'CR-Z'),
(703, 57, 'CROSSTOUR'),
(704, 57, 'CRX'),
(705, 57, 'DOMANI'),
(706, 57, 'EDIX'),
(707, 57, 'ELEMENT'),
(708, 57, 'ELYSION'),
(709, 57, 'FIT'),
(710, 57, 'FIT&nbsp;ARIA'),
(711, 57, 'FR-V'),
(712, 57, 'FREED'),
(713, 57, 'HR-V'),
(714, 57, 'INSIGHT'),
(715, 57, 'INSPIRE'),
(716, 57, 'INTEGRA'),
(717, 57, 'JAZZ'),
(718, 57, 'LEGEND'),
(719, 57, 'LIFE'),
(720, 57, 'LOGO'),
(721, 57, 'MOBILIO'),
(722, 57, 'NSX'),
(723, 57, 'ODYSSEY'),
(724, 57, 'ORTHIA'),
(725, 57, 'PARTNER'),
(726, 57, 'PASSPORT'),
(727, 57, 'PILOT'),
(728, 57, 'PRELUDE'),
(729, 57, 'RAFAGA'),
(730, 57, 'RIDGELINE'),
(731, 57, 'S2000'),
(732, 57, 'SABER'),
(733, 57, 'SHUTTLE'),
(734, 57, 'SM-X'),
(735, 57, 'STEPWGN'),
(736, 57, 'STREAM'),
(737, 57, 'THAT&nbsp;S'),
(738, 57, 'TORNEO'),
(739, 57, 'VAMOS'),
(740, 57, 'VIGOR'),
(741, 57, 'Z'),
(742, 57, 'ZEST'),
(743, 58, 'ANTELOPE'),
(744, 59, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HUMMER&nbsp;H1'),
(745, 59, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HUMMER&nbsp;H2'),
(746, 59, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HUMMER&nbsp;H3'),
(747, 60, 'ACCENT'),
(748, 60, 'ATOS'),
(749, 60, 'AVANTE'),
(750, 60, 'COUPE'),
(751, 60, 'ELANTRA'),
(752, 60, 'EQUUS'),
(753, 60, 'EXCEL'),
(754, 60, 'GALLOPER'),
(755, 60, 'GENESIS'),
(756, 60, 'GETZ'),
(757, 60, 'GRANDEUR&nbsp;(AZERA)'),
(758, 60, 'I10'),
(759, 60, 'I20'),
(760, 60, 'I30'),
(761, 60, 'I40'),
(762, 60, 'IX35'),
(763, 60, 'IX55'),
(764, 60, 'LANTRA'),
(765, 60, 'LAVITA'),
(766, 60, 'MATRIX'),
(767, 60, 'NF'),
(768, 60, 'PONY'),
(769, 60, 'S-COUPE'),
(770, 60, 'SANTA&nbsp;FE'),
(771, 60, 'SANTAMO'),
(772, 60, 'SOLARIS'),
(773, 60, 'SONATA'),
(774, 60, 'STAREX'),
(775, 60, 'TERRACAN'),
(776, 60, 'TIBURON'),
(777, 60, 'TRAJET'),
(778, 60, 'TUCSON'),
(779, 60, 'TUSCANI'),
(780, 60, 'VELOSTER'),
(781, 60, 'VERACRUZ&nbsp;(IX55)'),
(782, 60, 'VERNA'),
(783, 60, 'XG'),
(784, 61, 'EX'),
(785, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EX25'),
(786, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EX35'),
(787, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EX37'),
(788, 61, 'FX'),
(789, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FX30'),
(790, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FX35'),
(791, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FX37'),
(792, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FX45'),
(793, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FX50'),
(794, 61, 'G'),
(795, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G20'),
(796, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G25'),
(797, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G35'),
(798, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G37'),
(799, 61, 'I'),
(800, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I30'),
(801, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I35'),
(802, 61, 'J'),
(803, 61, 'JX'),
(804, 61, 'M'),
(805, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M25'),
(806, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M35'),
(807, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M37'),
(808, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M45'),
(809, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M56'),
(810, 61, 'Q'),
(811, 61, 'QX'),
(812, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QX4'),
(813, 61, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QX56'),
(814, 62, 'SAMAND'),
(815, 63, 'ASKA'),
(816, 63, 'AXIOM'),
(817, 63, 'BIGHORN'),
(818, 63, 'CAMPO'),
(819, 63, 'MU&nbsp;(AMIGO)'),
(820, 63, 'RODEO'),
(821, 63, 'TROOPER'),
(822, 63, 'VEHICROSS'),
(823, 64, 'REFINE'),
(824, 64, 'REIN'),
(825, 65, 'E-TYPE'),
(826, 65, 'S-TYPE'),
(827, 65, 'X-TYPE'),
(828, 65, 'XF'),
(829, 65, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;XF'),
(830, 65, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;XFR'),
(831, 65, 'XJ'),
(832, 65, 'XJR'),
(833, 65, 'XK&nbsp;8'),
(834, 65, 'XKR'),
(835, 66, 'CHEROKEE'),
(836, 66, 'COMMANDER'),
(837, 66, 'COMPASS'),
(838, 66, 'GRAND&nbsp;CHEROKEE'),
(839, 66, 'GRAND&nbsp;WAGONEER'),
(840, 66, 'LIBERTY'),
(841, 66, 'PATRIOT'),
(842, 66, 'WRANGLER'),
(843, 67, 'BAODIAN'),
(844, 68, 'AVELLA'),
(845, 68, 'CADENZA&nbsp;(K7)'),
(846, 68, 'CARENS'),
(847, 68, 'CARNIVAL'),
(848, 68, 'CEE''D'),
(849, 68, 'CERATO&nbsp;(FORTE)'),
(850, 68, 'CLARUS'),
(851, 68, 'JOICE'),
(852, 68, 'MAGENTIS'),
(853, 68, 'MOHAVE&nbsp;(BORREGO)'),
(854, 68, 'OPIRUS'),
(855, 68, 'OPTIMA'),
(856, 68, 'PICANTO'),
(857, 68, 'PRIDE'),
(858, 68, 'RETONA'),
(859, 68, 'RIO&nbsp;(PRIDE)'),
(860, 68, 'SEPHIA'),
(861, 68, 'SHUMA'),
(862, 68, 'SORENTO'),
(863, 68, 'SOUL'),
(864, 68, 'SPECTRA'),
(865, 68, 'SPORTAGE'),
(866, 68, 'VENGA'),
(867, 69, 'KOENIGSEGG'),
(868, 70, 'AVENTADOR'),
(869, 70, 'GALLARDO'),
(870, 70, 'LM-002'),
(871, 70, 'MURCIELAGO'),
(872, 70, 'REVENTON'),
(873, 71, 'BETA'),
(874, 71, 'DEDRA'),
(875, 71, 'DELTA'),
(876, 71, 'KAPPA'),
(877, 71, 'LYBRA'),
(878, 71, 'THEMA'),
(879, 71, 'THESIS'),
(880, 71, 'Y'),
(881, 71, 'ZETA'),
(882, 72, 'DEFENDER'),
(883, 72, 'DISCOVERY'),
(884, 72, 'FREELANDER'),
(885, 72, 'RANGE&nbsp;ROVER'),
(886, 72, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RANGE&nbsp;ROVER'),
(887, 72, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RANGE&nbsp;ROVER&nbsp;SPORT'),
(888, 72, 'RANGE&nbsp;ROVER&nbsp;EVOQUE'),
(889, 72, 'SERIES&nbsp;III'),
(890, 73, 'CT'),
(891, 73, 'ES'),
(892, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ES&nbsp;250'),
(893, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ES&nbsp;300'),
(894, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ES&nbsp;330'),
(895, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ES&nbsp;350'),
(896, 73, 'GS'),
(897, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;250'),
(898, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;300'),
(899, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;350'),
(900, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;400'),
(901, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;430'),
(902, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;450H'),
(903, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GS&nbsp;460'),
(904, 73, 'GX'),
(905, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GX&nbsp;460'),
(906, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GX&nbsp;470'),
(907, 73, 'HS'),
(908, 73, 'IS'),
(909, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS&nbsp;200'),
(910, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS&nbsp;220'),
(911, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS&nbsp;250'),
(912, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS&nbsp;250C'),
(913, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS&nbsp;300'),
(914, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS&nbsp;350'),
(915, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IS-F'),
(916, 73, 'LS'),
(917, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LS&nbsp;400'),
(918, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LS&nbsp;430'),
(919, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LS&nbsp;460'),
(920, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LS&nbsp;600'),
(921, 73, 'LX'),
(922, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LX&nbsp;450'),
(923, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LX&nbsp;470'),
(924, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LX&nbsp;570'),
(925, 73, 'RX'),
(926, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RX&nbsp;270'),
(927, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RX&nbsp;300'),
(928, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RX&nbsp;330'),
(929, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RX&nbsp;350'),
(930, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RX&nbsp;400H'),
(931, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RX&nbsp;450H'),
(932, 73, 'SC'),
(933, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SC&nbsp;300'),
(934, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SC&nbsp;400'),
(935, 73, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SC&nbsp;430'),
(936, 74, '320'),
(937, 74, 'BREEZ&nbsp;(520)'),
(938, 74, 'SOLANO&nbsp;(620)'),
(939, 75, 'AVIATOR'),
(940, 75, 'CONTINENTAL'),
(941, 75, 'LS'),
(942, 75, 'MARK'),
(943, 75, 'MARK&nbsp;LT'),
(944, 75, 'MKS'),
(945, 75, 'MKT'),
(946, 75, 'MKX'),
(947, 75, 'NAVIGATOR'),
(948, 75, 'TOWN&nbsp;CAR'),
(949, 76, 'ELISE'),
(950, 76, 'EUROPA'),
(951, 76, 'EXIGE'),
(952, 78, '3200&nbsp;GT'),
(953, 78, '4300&nbsp;GT&nbsp;COUPE'),
(954, 78, 'BITURBO'),
(955, 78, 'COUPE'),
(956, 78, 'GHIBLI'),
(957, 78, 'GRANSPORT'),
(958, 78, 'GRANTURISMO'),
(959, 78, 'MC12'),
(960, 78, 'QUATTROPORTE'),
(961, 78, 'SPYDER'),
(962, 79, 'MAYBACH&nbsp;57&nbsp;S&nbsp;?&nbsp;MAYBACH&nbsp;62&nbsp;S'),
(963, 79, 'MAYBACH&nbsp;57&nbsp;?&nbsp;MAYBACH&nbsp;62'),
(964, 80, '121'),
(965, 80, '323'),
(966, 80, '626'),
(967, 80, '929'),
(968, 80, 'ATENZA'),
(969, 80, 'AXELA'),
(970, 80, 'B-SERIES'),
(971, 80, 'BIANTE'),
(972, 80, 'BONGO'),
(973, 80, 'BT-50'),
(974, 80, 'CAPELLA'),
(975, 80, 'CRONOS'),
(976, 80, 'CX-5'),
(977, 80, 'CX-7'),
(978, 80, 'CX-9'),
(979, 80, 'DEMIO'),
(980, 80, 'EFINI&nbsp;MS-8'),
(981, 80, 'EFINI&nbsp;MS-9'),
(982, 80, 'FAMILIA'),
(983, 80, 'LANTIS'),
(984, 80, 'LAPUTA'),
(985, 80, 'LEVANTE'),
(986, 80, 'LUCE'),
(987, 80, 'MAZDA&nbsp;2'),
(988, 80, 'MAZDA&nbsp;3'),
(989, 80, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAZDA&nbsp;3'),
(990, 80, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MPS'),
(991, 80, 'MAZDA&nbsp;5'),
(992, 80, 'MILLENIA'),
(993, 80, 'MPV'),
(994, 80, 'MX-3'),
(995, 80, 'MX-5'),
(996, 80, 'MX-6'),
(997, 80, 'M?ZDA&nbsp;6'),
(998, 80, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAZDA&nbsp;6'),
(999, 80, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MPS'),
(1000, 80, 'PREMACY'),
(1001, 80, 'PROCEED'),
(1002, 80, 'PROTEGE'),
(1003, 80, 'RX&nbsp;7'),
(1004, 80, 'RX-8'),
(1005, 80, 'SENTIA'),
(1006, 80, 'TRIBUTE'),
(1007, 80, 'VERISA'),
(1008, 80, 'XEDOS&nbsp;6'),
(1009, 80, 'XEDOS&nbsp;9'),
(1010, 81, '/8'),
(1011, 81, '190'),
(1012, 81, '200'),
(1013, 81, '220'),
(1014, 81, '230'),
(1015, 81, '240'),
(1016, 81, '250'),
(1017, 81, '260'),
(1018, 81, '280'),
(1019, 81, '300'),
(1020, 81, '320'),
(1021, 81, '500'),
(1022, 81, 'A-KLASSE'),
(1023, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;140'),
(1024, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;150'),
(1025, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;160'),
(1026, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;170'),
(1027, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;180'),
(1028, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;190'),
(1029, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;200'),
(1030, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&nbsp;210'),
(1031, 81, 'B-KLASSE'),
(1032, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;150'),
(1033, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;170'),
(1034, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;180'),
(1035, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B&nbsp;200'),
(1036, 81, 'C-KLASSE'),
(1037, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;180'),
(1038, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;200'),
(1039, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;220'),
(1040, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;230'),
(1041, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;240'),
(1042, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;250'),
(1043, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;270'),
(1044, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;280'),
(1045, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;300'),
(1046, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;32&nbsp;AMG'),
(1047, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;320'),
(1048, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;350'),
(1049, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;36&nbsp;AMG'),
(1050, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;43&nbsp;AMG'),
(1051, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;55&nbsp;AMG'),
(1052, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C&nbsp;63&nbsp;AMG'),
(1053, 81, 'CABRIO'),
(1054, 81, 'CL-KLASSE'),
(1055, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;420'),
(1056, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;500'),
(1057, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;55&nbsp;AMG'),
(1058, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;550'),
(1059, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;600'),
(1060, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;63&nbsp;AMG'),
(1061, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CL&nbsp;65&nbsp;AMG'),
(1062, 81, 'CLC-KLASSE'),
(1063, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLC&nbsp;180&nbsp;KOMPRESSOR'),
(1064, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLC&nbsp;200&nbsp;KOMPRESSOR'),
(1065, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLC&nbsp;230'),
(1066, 81, 'CLK-KLASSE'),
(1067, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;200'),
(1068, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;220'),
(1069, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;230'),
(1070, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;240'),
(1071, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;270'),
(1072, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;280'),
(1073, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;320'),
(1074, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;350'),
(1075, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;430'),
(1076, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;500'),
(1077, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;55&nbsp;AMG'),
(1078, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLK&nbsp;63&nbsp;AMG'),
(1079, 81, '&nbsp;'),
(1080, 81, 'CLS-KLASSE'),
(1081, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;280'),
(1082, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;320'),
(1083, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;350'),
(1084, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;500'),
(1085, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;55&nbsp;AMG'),
(1086, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;550'),
(1087, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLS&nbsp;63&nbsp;AMG'),
(1088, 81, 'COUPE'),
(1089, 81, 'E-KLASSE'),
(1090, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;200'),
(1091, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;220'),
(1092, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;230'),
(1093, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;240'),
(1094, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;250'),
(1095, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;270'),
(1096, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;280'),
(1097, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;290'),
(1098, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;300'),
(1099, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;320'),
(1100, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;350'),
(1101, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;400'),
(1102, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;420'),
(1103, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;430'),
(1104, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;50&nbsp;AMG'),
(1105, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;500'),
(1106, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;55&nbsp;AMG'),
(1107, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;550'),
(1108, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;60&nbsp;AMG'),
(1109, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;63&nbsp;AMG'),
(1110, 81, 'G-KLASSE'),
(1111, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;230'),
(1112, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;240'),
(1113, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;270'),
(1114, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;280'),
(1115, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;290'),
(1116, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;300'),
(1117, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;320'),
(1118, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;350'),
(1119, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;36&nbsp;AMG'),
(1120, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;400'),
(1121, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;500'),
(1122, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;55&nbsp;AMG'),
(1123, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G&nbsp;63&nbsp;AMG'),
(1124, 81, 'GL-KLASSE'),
(1125, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;320'),
(1126, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;350'),
(1127, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;420'),
(1128, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;450'),
(1129, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;500'),
(1130, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;550'),
(1131, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GL&nbsp;63&nbsp;AMG'),
(1132, 81, 'GLK-KLASSE'),
(1133, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GLK&nbsp;220'),
(1134, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GLK&nbsp;280'),
(1135, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GLK&nbsp;300'),
(1136, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GLK&nbsp;320'),
(1137, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GLK&nbsp;350'),
(1138, 81, 'M-KLASSE'),
(1139, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;230'),
(1140, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;250'),
(1141, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;270'),
(1142, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;280'),
(1143, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;300'),
(1144, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;320'),
(1145, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;350'),
(1146, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;400'),
(1147, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;420'),
(1148, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;430'),
(1149, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;500'),
(1150, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;55&nbsp;AMG'),
(1151, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ML&nbsp;63&nbsp;AMG'),
(1152, 81, '&nbsp;'),
(1153, 81, 'PULLMANN'),
(1154, 81, 'R-KLASSE'),
(1155, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;280'),
(1156, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;300'),
(1157, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;320'),
(1158, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;350'),
(1159, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;500'),
(1160, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;R&nbsp;63&nbsp;AMG'),
(1161, 81, 'S-KLASSE'),
(1162, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;260'),
(1163, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;280'),
(1164, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;300'),
(1165, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;320'),
(1166, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;350'),
(1167, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;380'),
(1168, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;400'),
(1169, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;420'),
(1170, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;430'),
(1171, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;450'),
(1172, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;500'),
(1173, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;55&nbsp;AMG'),
(1174, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;550'),
(1175, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;560'),
(1176, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;600'),
(1177, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;63&nbsp;AMG'),
(1178, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S&nbsp;65&nbsp;AMG'),
(1179, 81, 'SL-KLASSE'),
(1180, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;280'),
(1181, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;300'),
(1182, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;320'),
(1183, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;350'),
(1184, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;380'),
(1185, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;500'),
(1186, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;55&nbsp;AMG'),
(1187, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;550'),
(1188, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;600'),
(1189, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;63&nbsp;AMG'),
(1190, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SL&nbsp;65&nbsp;AMG'),
(1191, 81, 'SLK-KLASSE'),
(1192, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;200'),
(1193, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;230'),
(1194, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;280'),
(1195, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;32&nbsp;AMG'),
(1196, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;320'),
(1197, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;350'),
(1198, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SLK&nbsp;55&nbsp;AMG'),
(1199, 81, 'SLR&nbsp;MCLAREN'),
(1200, 81, 'SLS-KLASSE'),
(1201, 81, 'T-MOD.'),
(1202, 81, 'V-KLASSE'),
(1203, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V&nbsp;200'),
(1204, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V&nbsp;220'),
(1205, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V&nbsp;230'),
(1206, 81, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;V&nbsp;280'),
(1207, 81, 'VANEO'),
(1208, 81, 'VIANO'),
(1209, 82, 'COUGAR'),
(1210, 82, 'GRAND&nbsp;MARQUIS'),
(1211, 82, 'MARINER'),
(1212, 82, 'MARQUIS'),
(1213, 82, 'MONTEREY'),
(1214, 82, 'MYSTIQUE'),
(1215, 82, 'SABLE'),
(1216, 82, 'TRACER'),
(1217, 82, 'VILLAGER'),
(1218, 83, 'TAXI&nbsp;(II&nbsp;-SERIES)'),
(1219, 84, 'MG&nbsp;F'),
(1220, 84, 'MG&nbsp;TF'),
(1221, 84, 'ZR'),
(1222, 84, 'ZS'),
(1223, 84, 'ZT'),
(1224, 85, 'CLUBMAN'),
(1225, 85, 'COOPER'),
(1226, 85, 'COUNTRYMAN'),
(1227, 85, 'ONE'),
(1228, 86, '3000&nbsp;GT'),
(1229, 86, 'AIRTREK'),
(1230, 86, 'ASPIRE'),
(1231, 86, 'ASX'),
(1232, 86, 'CARISMA'),
(1233, 86, 'CHALLENGER'),
(1234, 86, 'CHARIOT'),
(1235, 86, 'COLT'),
(1236, 86, 'DELICA'),
(1237, 86, 'DIAMANTE'),
(1238, 86, 'DINGO'),
(1239, 86, 'DION'),
(1240, 86, 'ECLIPSE'),
(1241, 86, 'EK&nbsp;WAGON'),
(1242, 86, 'EMERAUDE'),
(1243, 86, 'ENDEAVOR'),
(1244, 86, 'ETERNA'),
(1245, 86, 'FTO'),
(1246, 86, 'GALANT'),
(1247, 86, 'GRANDIS'),
(1248, 86, 'GTO'),
(1249, 86, 'I'),
(1250, 86, 'JEEP'),
(1251, 86, 'L&nbsp;200'),
(1252, 86, 'LANCER'),
(1253, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EVOLUTION'),
(1254, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LANCER'),
(1255, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LANCER&nbsp;CEDIA'),
(1256, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SPORTBACK'),
(1257, 86, 'LEGNUM'),
(1258, 86, 'LIBERO'),
(1259, 86, 'MINICA'),
(1260, 86, 'MIRAGE'),
(1261, 86, 'MONTERO'),
(1262, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MONTERO'),
(1263, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SPORT'),
(1264, 86, 'OUTLANDER'),
(1265, 86, 'PAJERO'),
(1266, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PAJERO'),
(1267, 86, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SPORT'),
(1268, 86, 'RVR'),
(1269, 86, 'SIGMA'),
(1270, 86, 'SPACE&nbsp;GEAR'),
(1271, 86, 'SPACE&nbsp;RUNNER'),
(1272, 86, 'SPACE&nbsp;STAR'),
(1273, 86, 'SPACE&nbsp;WAGON'),
(1274, 86, 'STARION'),
(1275, 86, 'TOPPO'),
(1276, 87, 'MICRO&nbsp;CAR'),
(1277, 87, 'VIEWT'),
(1278, 88, '4/4'),
(1279, 88, 'AERO&nbsp;8'),
(1280, 89, '100&nbsp;NX'),
(1281, 89, '180&nbsp;SX'),
(1282, 89, '200&nbsp;SX'),
(1283, 89, '300&nbsp;ZX'),
(1284, 89, '350Z'),
(1285, 89, '370Z'),
(1286, 89, 'AD'),
(1287, 89, 'ALMERA'),
(1288, 89, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALMERA'),
(1289, 89, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALMERA&nbsp;CLASSIC'),
(1290, 89, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ALMERA&nbsp;TINO'),
(1291, 89, 'ALTIMA'),
(1292, 89, 'ARMADA'),
(1293, 89, 'AVENIR'),
(1294, 89, 'BASSARA'),
(1295, 89, 'BLUEBIRD'),
(1296, 89, 'CEDRIC'),
(1297, 89, 'CEFIRO'),
(1298, 89, 'CIMA'),
(1299, 89, 'CUBE'),
(1300, 89, 'DATSUN'),
(1301, 89, 'ELGRAND'),
(1302, 89, 'EXPERT'),
(1303, 89, 'FAIRLADY&nbsp;Z'),
(1304, 89, 'FRONTIER'),
(1305, 89, 'FUGA'),
(1306, 89, 'GLORIA'),
(1307, 89, 'GT-R'),
(1308, 89, 'JUKE'),
(1309, 89, 'KING&nbsp;CAB'),
(1310, 89, 'LAFESTA'),
(1311, 89, 'LANGLEY'),
(1312, 89, 'LARGO'),
(1313, 89, 'LAUREL'),
(1314, 89, 'LEOPARD'),
(1315, 89, 'LIBERTY'),
(1316, 89, 'LUCINO'),
(1317, 89, 'MARCH'),
(1318, 89, 'MAXIMA'),
(1319, 89, 'MICRA'),
(1320, 89, 'MISTRAL'),
(1321, 89, 'MOCO'),
(1322, 89, 'MURANO'),
(1323, 89, 'NAVARA'),
(1324, 89, 'NOTE'),
(1325, 89, 'NP&nbsp;300&nbsp;PICK&nbsp;UP'),
(1326, 89, 'OTTI'),
(1327, 89, 'PATHFINDER'),
(1328, 89, 'PATROL'),
(1329, 89, 'PICK&nbsp;UP'),
(1330, 89, 'PIXO'),
(1331, 89, 'PRAIRIE'),
(1332, 89, 'PRESAGE'),
(1333, 89, 'PRESEA'),
(1334, 89, 'PRESIDENT'),
(1335, 90, 'ACHIEVA'),
(1336, 90, 'ALERO'),
(1337, 90, 'AURORA'),
(1338, 90, 'CUTLASS'),
(1339, 90, 'EIGHTY-EIGHT'),
(1340, 90, 'OMEGA'),
(1341, 90, 'SILHOUETTE'),
(1342, 91, 'AGILA'),
(1343, 91, 'ANTARA'),
(1344, 91, 'ASCONA'),
(1345, 91, 'ASTRA'),
(1346, 91, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASTRA'),
(1347, 91, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OPC'),
(1348, 91, 'CALIBRA'),
(1349, 91, 'CAMPO'),
(1350, 91, 'COMBO'),
(1351, 91, 'COMMODORE'),
(1352, 91, 'CORSA'),
(1353, 91, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CORSA'),
(1354, 91, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OPC'),
(1355, 91, 'FRONTERA'),
(1356, 91, 'GT'),
(1357, 91, 'INSIGNIA'),
(1358, 91, 'KADETT'),
(1359, 91, 'MERIVA'),
(1360, 91, 'MONTEREY'),
(1361, 91, 'MONZA'),
(1362, 91, 'OMEGA'),
(1363, 91, 'REKORD'),
(1364, 91, 'SENATOR'),
(1365, 91, 'SIGNUM'),
(1366, 91, 'SINTRA'),
(1367, 91, 'SPEEDSTER'),
(1368, 91, 'TIGRA'),
(1369, 91, 'VECTRA'),
(1370, 91, 'VITA'),
(1371, 91, 'ZAFIRA'),
(1372, 91, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OPC'),
(1373, 91, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ZAFIRA'),
(1374, 92, 'ZONDA'),
(1375, 93, '1007'),
(1376, 93, '106'),
(1377, 93, '107'),
(1378, 93, '205'),
(1379, 93, '206'),
(1380, 93, '207'),
(1381, 93, '3008'),
(1382, 93, '305'),
(1383, 93, '306'),
(1384, 93, '307'),
(1385, 93, '308'),
(1386, 93, '309'),
(1387, 93, '4007'),
(1388, 93, '4008'),
(1389, 93, '405'),
(1390, 93, '406'),
(1391, 93, '407'),
(1392, 93, '505'),
(1393, 93, '508'),
(1394, 93, '605'),
(1395, 93, '607'),
(1396, 93, '806'),
(1397, 93, '807'),
(1398, 93, 'PARTNER'),
(1399, 93, 'RCZ'),
(1400, 94, 'BREEZE'),
(1401, 94, 'GRAND&nbsp;VOYAGER'),
(1402, 94, 'LASER'),
(1403, 94, 'NEON'),
(1404, 94, 'PROWLER'),
(1405, 94, 'VOYAGER'),
(1406, 95, 'BONNEVILLE'),
(1407, 95, 'FIERO'),
(1408, 95, 'FIREBIRD'),
(1409, 95, 'G5'),
(1410, 95, 'G6'),
(1411, 95, 'GRAND&nbsp;AM'),
(1412, 95, 'GRAND&nbsp;PRIX'),
(1413, 95, 'GTO'),
(1414, 95, 'PARISIENNE'),
(1415, 95, 'PHOENIX'),
(1416, 95, 'SOLSTICE'),
(1417, 95, 'SUNBIRD'),
(1418, 95, 'TRANS&nbsp;SPORT'),
(1419, 95, 'VIBE'),
(1420, 96, '911'),
(1421, 96, '924'),
(1422, 96, '928'),
(1423, 96, '944'),
(1424, 96, 'BOXSTER'),
(1425, 96, 'CARRERA&nbsp;GT'),
(1426, 96, 'CAYENNE'),
(1427, 96, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAYENNE'),
(1428, 96, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAYENNE&nbsp;GTS'),
(1429, 96, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAYENNE&nbsp;S'),
(1430, 96, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAYENNE&nbsp;S&nbsp;HYBRID'),
(1431, 96, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAYENNE&nbsp;TURBO'),
(1432, 96, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAYENNE&nbsp;TURBO&nbsp;S'),
(1433, 96, 'CAYMAN'),
(1434, 96, 'PANAMERA'),
(1435, 97, 'PERSONA&nbsp;300&nbsp;COMPACT'),
(1436, 97, 'PERSONA&nbsp;400'),
(1437, 98, 'G-MODELL'),
(1438, 98, 'PINZGAUER'),
(1439, 99, '11'),
(1440, 99, '19'),
(1441, 99, '21'),
(1442, 99, '25'),
(1443, 99, '5'),
(1444, 99, '9'),
(1445, 99, 'AVANTIME'),
(1446, 99, 'CLIO'),
(1447, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLIO'),
(1448, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLIO&nbsp;SYMBOL'),
(1449, 99, 'DUSTER'),
(1450, 99, '&nbsp;'),
(1451, 99, 'ESPACE'),
(1452, 99, 'FLUENCE'),
(1453, 99, 'KANGOO'),
(1454, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXPRESS'),
(1455, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PASSENGER'),
(1456, 99, 'KOLEOS'),
(1457, 99, 'LAGUNA'),
(1458, 99, 'LATITUDE'),
(1459, 99, 'LOGAN'),
(1460, 99, 'MEGANE'),
(1461, 99, 'MODUS'),
(1462, 99, 'RAPID'),
(1463, 99, '&nbsp;'),
(1464, 99, 'SAFRANE'),
(1465, 99, 'SANDERO'),
(1466, 99, 'SCENIC'),
(1467, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GRAND&nbsp;SCENIC'),
(1468, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SCENIC'),
(1469, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SCENIC&nbsp;II'),
(1470, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SCENIC&nbsp;III'),
(1471, 99, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SCENIC&nbsp;RX'),
(1472, 99, 'SUPER&nbsp;5'),
(1473, 99, 'SYMBOL&nbsp;(THALIA)'),
(1474, 99, 'TWINGO'),
(1475, 99, 'VEL&nbsp;SATIS'),
(1476, 100, 'CORNICHE&nbsp;CABRIO'),
(1477, 100, 'GHOST'),
(1478, 100, 'PHANTOM'),
(1479, 100, 'PHANTOM&nbsp;COUPE'),
(1480, 100, 'PHANTOM&nbsp;DROPHEAD&nbsp;COUPE'),
(1481, 100, 'SILVER&nbsp;SERAPH'),
(1482, 100, 'SILVER&nbsp;SPUR'),
(1483, 101, '200'),
(1484, 101, '25'),
(1485, 101, '400'),
(1486, 101, '45'),
(1487, 101, '600'),
(1488, 101, '75'),
(1489, 101, '800'),
(1490, 101, 'MG'),
(1491, 101, 'MINI&nbsp;MK'),
(1492, 101, 'STREETWISE'),
(1493, 102, '9-3'),
(1494, 102, '9-4X'),
(1495, 102, '9-5'),
(1496, 102, '9-7X'),
(1497, 102, '900'),
(1498, 102, '9000'),
(1499, 102, '96'),
(1500, 102, '99'),
(1501, 103, 'SALEEN'),
(1502, 104, 'SC'),
(1503, 104, 'SKY'),
(1504, 104, 'SL'),
(1505, 104, 'VUE'),
(1506, 105, 'TC'),
(1507, 105, 'XA'),
(1508, 105, 'XB'),
(1509, 105, 'XD'),
(1510, 106, 'ALHAMBRA'),
(1511, 106, 'ALTEA'),
(1512, 106, 'AROSA'),
(1513, 106, 'CORDOBA'),
(1514, 106, 'IBIZA'),
(1515, 106, 'LEON'),
(1516, 106, 'MARBELLA'),
(1517, 106, 'RONDA'),
(1518, 106, 'TOLEDO'),
(1519, 107, 'SCEO'),
(1520, 108, '105,120'),
(1521, 108, 'FABIA'),
(1522, 108, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FABIA'),
(1523, 108, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RS'),
(1524, 108, 'FAVORIT'),
(1525, 108, 'FELICIA'),
(1526, 108, 'OCTAVIA'),
(1527, 108, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OCTAVIA'),
(1528, 108, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RS'),
(1529, 108, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SCOUT'),
(1530, 108, 'ROOMSTER'),
(1531, 108, 'SUPERB'),
(1532, 108, 'YETI'),
(1533, 109, 'C52'),
(1534, 110, 'FORFOUR'),
(1535, 110, 'FORTWO'),
(1536, 110, 'ROADSTER'),
(1537, 111, 'C8'),
(1538, 112, 'ACTYON'),
(1539, 112, 'CHAIRMAN'),
(1540, 112, 'FAMILY'),
(1541, 112, 'KORANDO'),
(1542, 112, 'KYRON'),
(1543, 112, 'MUSSO'),
(1544, 112, 'REXTON'),
(1545, 112, 'RODIUS'),
(1546, 112, 'TAGER'),
(1547, 113, 'BAJA'),
(1548, 113, 'DOMINGO'),
(1549, 113, 'EXIGA'),
(1550, 113, 'FORESTER'),
(1551, 113, 'IMPREZA'),
(1552, 113, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IMPREZA'),
(1553, 113, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IMPREZA&nbsp;WRX'),
(1554, 113, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IMPREZA&nbsp;WRX&nbsp;STI'),
(1555, 113, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IMPREZA&nbsp;XV'),
(1556, 113, 'JUSTY'),
(1557, 113, 'LEGACY'),
(1558, 113, 'LEONE'),
(1559, 113, 'LIBERO'),
(1560, 113, 'OUTBACK'),
(1561, 113, 'PLEO'),
(1562, 113, 'R2'),
(1563, 113, 'STELLA'),
(1564, 113, 'SVX'),
(1565, 113, 'TRIBECA'),
(1566, 113, 'VIVIO'),
(1567, 113, 'XT'),
(1568, 113, 'XV'),
(1569, 114, 'AERIO'),
(1570, 114, 'ALTO'),
(1571, 114, 'BALENO'),
(1572, 114, 'CERVO'),
(1573, 114, 'CULTUS&nbsp;WAGON'),
(1574, 114, 'ESCUDO'),
(1575, 114, 'EVERY'),
(1576, 114, 'FORENZA'),
(1577, 114, 'GRAND&nbsp;VITARA'),
(1578, 114, 'IGNIS'),
(1579, 114, 'JIMNY'),
(1580, 114, 'KEI'),
(1581, 114, 'KIZASHI'),
(1582, 114, 'LIANA'),
(1583, 114, 'MR&nbsp;WAGON'),
(1584, 114, 'SAMURAI'),
(1585, 114, 'SIDEKICK'),
(1586, 114, 'SPLASH'),
(1587, 114, 'SWIFT'),
(1588, 114, 'SX4'),
(1589, 114, 'VERONA'),
(1590, 114, 'VITARA'),
(1591, 114, 'WAGON&nbsp;R'),
(1592, 114, 'WAGON&nbsp;R&nbsp;PLUS'),
(1593, 114, 'WAGON&nbsp;R&nbsp;SOLIO'),
(1594, 114, 'X-90'),
(1595, 114, 'XL7'),
(1596, 115, 'INDICA'),
(1597, 115, 'INDIGO'),
(1598, 116, 'CENTURY'),
(1599, 117, 'ADMIRAL'),
(1600, 118, 'ROADSTER'),
(1601, 119, '4RUNNER'),
(1602, 119, 'ALLEX'),
(1603, 119, 'ALLION'),
(1604, 119, 'ALPHARD'),
(1605, 119, 'ALTEZZA'),
(1606, 119, 'ARISTO'),
(1607, 119, 'AURIS'),
(1608, 119, 'AVALON'),
(1609, 119, 'AVENSIS'),
(1610, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AVENSIS'),
(1611, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AVENSIS&nbsp;VERSO'),
(1612, 119, 'AYGO'),
(1613, 119, 'BB'),
(1614, 119, 'BELTA'),
(1615, 119, 'BLADE'),
(1616, 119, 'BLIZZARD'),
(1617, 119, 'BREVIS'),
(1618, 119, 'CALDINA'),
(1619, 119, 'CAMI'),
(1620, 119, 'CAMRY'),
(1621, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAMRY'),
(1622, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GRACIA'),
(1623, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SOLARA'),
(1624, 119, 'CARIB'),
(1625, 119, 'CARINA'),
(1626, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CARINA'),
(1627, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CARINA&nbsp;E'),
(1628, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CARINA&nbsp;ED'),
(1629, 119, 'CAVALIER'),
(1630, 119, 'CELICA'),
(1631, 119, 'CELSIOR'),
(1632, 119, 'CENTURY'),
(1633, 119, 'CHASER'),
(1634, 119, 'COROLLA'),
(1635, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AXIO'),
(1636, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CERES'),
(1637, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COROLLA'),
(1638, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FIELDER'),
(1639, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LEVIN'),
(1640, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RUNX'),
(1641, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SPACIO'),
(1642, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VERSO'),
(1643, 119, 'COROLLA&nbsp;RUMION'),
(1644, 119, 'CORONA'),
(1645, 119, 'CORSA'),
(1646, 119, 'CRESSIDA'),
(1647, 119, 'CRESTA'),
(1648, 119, 'CROWN'),
(1649, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMFORT'),
(1650, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CROWN'),
(1651, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAJESTA'),
(1652, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WAGON'),
(1653, 119, 'CURREN'),
(1654, 119, 'CYNOS'),
(1655, 119, 'DUET'),
(1656, 119, 'ECHO'),
(1657, 119, 'ESTIMA'),
(1658, 119, 'FJ&nbsp;CRUISER'),
(1659, 119, 'FORTUNER'),
(1660, 119, 'FUNCARGO'),
(1661, 119, 'GAIA'),
(1662, 119, 'GRAND&nbsp;HIACE'),
(1663, 119, 'GRANVIA'),
(1664, 119, 'HARRIER'),
(1665, 119, 'HIACE'),
(1666, 119, 'HIGHLANDER'),
(1667, 119, 'HILUX'),
(1668, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PICK&nbsp;UP'),
(1669, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SURF'),
(1670, 119, 'IPSUM'),
(1671, 119, 'IQ'),
(1672, 119, 'ISIS'),
(1673, 119, 'IST'),
(1674, 119, 'KLUGER'),
(1675, 119, 'LAND&nbsp;CRUISER'),
(1676, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;100'),
(1677, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;105'),
(1678, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;200'),
(1679, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;40'),
(1680, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;60'),
(1681, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;70'),
(1682, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;80'),
(1683, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CYGNUS'),
(1684, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRADO&nbsp;120'),
(1685, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRADO&nbsp;150'),
(1686, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRADO&nbsp;70'),
(1687, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRADO&nbsp;90'),
(1688, 119, 'LITE&nbsp;ACE'),
(1689, 119, 'MARK&nbsp;II'),
(1690, 119, 'MARK&nbsp;X'),
(1691, 119, 'MASTERACE'),
(1692, 119, 'MATRIX'),
(1693, 119, 'MR&nbsp;2'),
(1694, 119, 'MR-S'),
(1695, 119, 'NADIA'),
(1696, 119, 'NOAH'),
(1697, 119, 'OPA'),
(1698, 119, 'ORIGIN'),
(1699, 119, 'PASEO'),
(1700, 119, 'PASSO'),
(1701, 119, 'PICNIC'),
(1702, 119, 'PLATZ'),
(1703, 119, 'PORTE');
INSERT INTO `car_model` (`id`, `marka_id`, `name`) VALUES
(1704, 119, 'PREMIO'),
(1705, 119, 'PREVIA'),
(1706, 119, 'PRIUS'),
(1707, 119, 'PROBOX'),
(1708, 119, 'PROGRES'),
(1709, 119, 'PRONARD'),
(1710, 119, 'RACTIS'),
(1711, 119, 'RAUM'),
(1712, 119, 'RAV&nbsp;4'),
(1713, 119, 'REGIUS'),
(1714, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ACE'),
(1715, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REGIUS'),
(1716, 119, 'RUSH'),
(1717, 119, 'SEQUOIA'),
(1718, 119, 'SERA'),
(1719, 119, 'SIENNA'),
(1720, 119, 'SIENTA'),
(1721, 119, 'SOARER'),
(1722, 119, 'SPARKY'),
(1723, 119, 'SPRINTER'),
(1724, 119, 'STARLET'),
(1725, 119, 'SUCCEED'),
(1726, 119, 'SUPRA'),
(1727, 119, 'TACOMA'),
(1728, 119, 'TERCEL'),
(1729, 119, 'TOWN&nbsp;ACE'),
(1730, 119, 'TUNDRA'),
(1731, 119, 'URBAN&nbsp;CRUISER'),
(1732, 119, 'VELLFIRE'),
(1733, 119, 'VENZA'),
(1734, 119, 'VEROSSA'),
(1735, 119, 'VERSO'),
(1736, 119, 'VIOS'),
(1737, 119, 'VISTA'),
(1738, 119, 'VITZ'),
(1739, 119, 'VOLTZ'),
(1740, 119, 'VOXY'),
(1741, 119, 'WILL'),
(1742, 119, 'WINDOM'),
(1743, 119, 'WISH'),
(1744, 119, 'YARIS'),
(1745, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VERSO'),
(1746, 119, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;YARIS'),
(1747, 120, 'P&nbsp;601'),
(1748, 121, 'CHEVETTE'),
(1749, 122, '1500,1600'),
(1750, 122, 'BEETLE'),
(1751, 122, 'BORA'),
(1752, 122, 'CADDY'),
(1753, 122, 'CORRADO'),
(1754, 122, 'DERBY'),
(1755, 122, 'EOS'),
(1756, 122, 'FOX'),
(1757, 122, 'GOLF'),
(1758, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CROSSGOLF'),
(1759, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GOLF'),
(1760, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GOLF&nbsp;PLUS'),
(1761, 122, 'JETTA'),
(1762, 122, 'KAEFER'),
(1763, 122, 'LUPO'),
(1764, 122, 'MULTIVAN'),
(1765, 122, 'PASSAT'),
(1766, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CC'),
(1767, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HATCHBACK'),
(1768, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEDAN'),
(1769, 122, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VARIANT'),
(1770, 122, 'PHAETON'),
(1771, 122, 'POINTER'),
(1772, 122, 'POLO'),
(1773, 122, 'ROUTAN'),
(1774, 122, 'SANTANA'),
(1775, 122, 'SCIROCCO'),
(1776, 122, 'SHARAN'),
(1777, 122, 'TARO'),
(1778, 122, 'TIGUAN'),
(1779, 122, 'TOUAREG'),
(1780, 122, 'TOURAN'),
(1781, 122, 'VENTO'),
(1782, 123, '240'),
(1783, 123, '340-360'),
(1784, 123, '440&nbsp;K'),
(1785, 123, '460'),
(1786, 123, '740'),
(1787, 123, '760'),
(1788, 123, '850'),
(1789, 123, '940'),
(1790, 123, '960'),
(1791, 123, 'C30'),
(1792, 123, 'C70'),
(1793, 123, 'LAPLANDER'),
(1794, 123, 'S40'),
(1795, 123, 'S60'),
(1796, 123, 'S70'),
(1797, 123, 'S80'),
(1798, 123, 'S90'),
(1799, 123, 'V40&nbsp;KOMBI'),
(1800, 123, 'V50'),
(1801, 123, 'V60'),
(1802, 123, 'V70'),
(1803, 123, 'XC60'),
(1804, 123, 'XC70'),
(1805, 123, 'XC90'),
(1806, 124, 'CORDA'),
(1807, 124, 'ESTINA'),
(1808, 124, 'TINGO'),
(1809, 125, '353'),
(1810, 126, 'ROADSTER'),
(1811, 127, 'PICKUP&nbsp;X3'),
(1812, 127, 'SR-V&nbsp;X3'),
(1813, 127, 'SUV&nbsp;X3'),
(1814, 128, 'YUGO'),
(1815, 129, 'GRANDTIGER'),
(1816, 129, 'LANDMARK');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(250) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `ordr` int(11) NOT NULL DEFAULT '0',
  `thumbnail_url` varchar(250) DEFAULT NULL,
  `ispopular` int(1) NOT NULL DEFAULT '0',
  `name_ch` varchar(250) DEFAULT NULL,
  `name_ru` varchar(250) DEFAULT NULL,
  `name_it` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `visible` (`visible`),
  KEY `ordr` (`ordr`),
  KEY `ispopular` (`ispopular`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name_en`, `category_id`, `visible`, `ordr`, `thumbnail_url`, `ispopular`, `name_ch`, `name_ru`, `name_it`) VALUES
(1, 'Home and Outdoors', 0, 1, 1, '/images/category/1.png', 1, NULL, NULL, NULL),
(2, 'Fashion', 0, 1, 2, '/images/category/2.png', 0, NULL, NULL, NULL),
(3, 'Women', 2, 1, 3, '/images/category/2.png', 0, NULL, NULL, NULL),
(4, 'Men', 2, 1, 4, '/images/category/2.png', 1, NULL, NULL, NULL),
(5, 'Crockery', 0, 1, 5, '/images/category/5.png', 0, NULL, NULL, NULL),
(6, 'Electronics', 0, 1, 6, '/images/category/6.png', 1, NULL, NULL, NULL),
(7, 'Construction and  building', 0, 1, 7, '/images/category/7.png', 1, NULL, NULL, NULL),
(8, 'Health & Beauty', 0, 1, 8, '/images/category/8.png', 1, NULL, NULL, NULL),
(9, 'Cars, Vehicles and  Parts ', 0, 1, 9, '/images/category/9.png', 1, NULL, NULL, NULL),
(10, 'Food ', 0, 1, 10, '/images/category/10.png', 1, NULL, NULL, NULL),
(11, 'Gifts and flowers', 0, 1, 11, '/images/category/11.png', 1, NULL, NULL, NULL),
(12, 'Facilities ', 0, 1, 12, '/images/category/12.png', 1, NULL, NULL, NULL),
(13, 'Home Decor & Accents', 1, 1, 13, '/images/category/1.png', 0, NULL, NULL, NULL),
(14, 'Yard, Garden & Outdoor Living', 1, 1, 14, '/images/category/1.png', 0, NULL, NULL, NULL),
(15, 'Kitchen, Dining & Bar', 1, 1, 15, '/images/category/1.png', 0, NULL, NULL, NULL),
(16, 'Bedding', 1, 1, 16, '/images/category/1.png', 0, NULL, NULL, NULL),
(17, 'Home Improvement', 1, 1, 17, '/images/category/1.png', 0, NULL, NULL, NULL),
(18, 'Holidays, Cards & Party Supply', 1, 1, 18, '/images/category/1.png', 0, NULL, NULL, NULL),
(19, 'Tools', 1, 1, 19, '/images/category/1.png', 0, NULL, NULL, NULL),
(20, 'Lamps, Lighting & Ceiling Fans', 1, 1, 20, '/images/category/1.png', 0, NULL, NULL, NULL),
(21, 'Furniture', 1, 1, 20, '/images/category/1.png', 0, NULL, NULL, NULL),
(22, 'Wedding Supplies', 1, 1, 22, '/images/category/1.png', 0, NULL, NULL, NULL),
(23, 'Rugs & Carpets', 1, 1, 23, '/images/category/1.png', 0, NULL, NULL, NULL),
(24, 'Food & Wine', 1, 1, 24, '/images/category/1.png', 0, NULL, NULL, NULL),
(25, 'Housekeeping & Organization', 1, 1, 25, '/images/category/1.png', 0, NULL, NULL, NULL),
(26, 'Bath', 1, 1, 26, '/images/category/1.png', 0, NULL, NULL, NULL),
(27, 'Window Treatments & Hardware', 1, 27, 27, '/images/category/1.png', 0, NULL, NULL, NULL),
(28, 'Wall Decor', 13, 1, 28, '/images/category/1.png', 0, NULL, NULL, NULL),
(29, 'Kids', 2, 1, 29, '/images/category/2.png', 0, NULL, NULL, NULL),
(30, 'Baby', 2, 1, 30, '/images/category/2.png', 0, NULL, NULL, NULL),
(31, 'Vintage', 2, 1, 31, '/images/category/2.png', 0, NULL, NULL, NULL),
(32, 'Jewelry & Watches', 2, 1, 32, '/images/category/2.png', 0, NULL, NULL, NULL),
(33, 'Popular Brands', 2, 1, 33, '/images/category/2.png', 0, NULL, NULL, NULL),
(34, 'Parts & Accessories', 9, 1, 34, '/images/category/9.png', 0, NULL, NULL, NULL),
(35, 'Cars', 9, 1, 35, '/images/category/9.png', 0, NULL, NULL, NULL),
(36, 'Trucks', 9, 1, 36, '/images/category/9.png', 0, NULL, NULL, NULL),
(37, 'Motorcycles', 9, 4, 37, '/images/category/9.png', 0, NULL, NULL, NULL),
(38, 'Powersports & More', 9, 1, 38, '/images/category/9.png', 0, NULL, NULL, NULL),
(39, 'Tires', 9, 1, 39, '/images/category/9.png', 0, NULL, NULL, NULL),
(40, 'Wheels', 9, 1, 40, '/images/category/9.png', 0, NULL, NULL, NULL),
(41, 'Light', 9, 1, 41, '/images/category/9.png', 0, NULL, NULL, NULL),
(42, 'Insurance', 9, 1, 42, '/images/category/9.png', 0, NULL, NULL, NULL),
(43, 'Cereals', 10, 1, 43, '/images/category/10.png', 0, NULL, NULL, NULL),
(44, 'Potatoes and Starches', 10, 1, 44, '/images/category/10.png', 0, NULL, NULL, NULL),
(45, 'Sugars and Sweeteners', 10, 1, 45, '/images/category/10.png', 0, NULL, NULL, NULL),
(46, 'Pulses', 10, 1, 46, '/images/category/10.png', 0, NULL, NULL, NULL),
(47, 'Nuts and Seeds', 10, 1, 47, '/images/category/10.png', 0, NULL, NULL, NULL),
(48, 'Vegetables', 10, 1, 48, '/images/category/10.png', 0, NULL, NULL, NULL),
(49, 'Fruits', 10, 1, 49, '/images/category/10.png', 0, NULL, NULL, NULL),
(50, 'Mushrooms', 10, 1, 50, '/images/category/10.png', 0, NULL, NULL, NULL),
(51, 'Algae', 10, 1, 51, '/images/category/10.png', 0, NULL, NULL, NULL),
(52, 'Fishes and Shellfishes', 10, 1, 52, '/images/category/10.png', 0, NULL, NULL, NULL),
(53, 'Meats', 10, 1, 53, '/images/category/10.png', 0, NULL, NULL, NULL),
(54, 'Eggs', 10, 1, 54, '/images/category/10.png', 0, NULL, NULL, NULL),
(55, 'Milks', 10, 1, 55, '/images/category/10.png', 0, NULL, NULL, NULL),
(56, 'Fats and Oils', 10, 1, 56, '/images/category/10.png', 0, NULL, NULL, NULL),
(57, 'Confectioneries', 10, 1, 57, '/images/category/10.png', 0, NULL, NULL, NULL),
(58, 'Beverages', 10, 1, 58, '/images/category/10.png', 0, NULL, NULL, NULL),
(59, 'Seasonings and Spices', 10, 1, 59, '/images/category/10.png', 0, NULL, NULL, NULL),
(60, 'Repared Foods', 10, 1, 60, '/images/category/10.png', 0, NULL, NULL, NULL),
(61, 'Building Materials & Supplies', 7, 1, 61, '/images/category/7.png', 0, NULL, NULL, NULL),
(62, 'Buildings, Modular & Pre-Fab', 7, 1, 62, '/images/category/7.png', 0, NULL, NULL, NULL),
(63, 'Heavy Equipment & Trailers', 7, 1, 63, '/images/category/7.png', 0, NULL, NULL, NULL),
(64, 'Heavy Equipment Parts & Manuals', 7, 1, 64, '/images/category/7.png', 0, NULL, NULL, NULL),
(65, 'Levels & Surveying Equipment', 7, 1, 65, '/images/category/7.png', 0, NULL, NULL, NULL),
(66, 'Mining Equipment', 7, 1, 66, '/images/category/7.png', 0, NULL, NULL, NULL),
(67, 'Protective Gear', 7, 1, 67, '/images/category/7.png', 0, NULL, NULL, NULL),
(68, 'Tools & Light Equipment', 7, 1, 68, '/images/category/7.png', 0, NULL, NULL, NULL),
(69, 'Makeup', 8, 1, 69, '/images/category/8.png', 0, NULL, NULL, NULL),
(70, 'Fragrances', 8, 1, 70, '/images/category/8.png', 0, NULL, NULL, NULL),
(71, 'Skin Care', 8, 1, 71, '/images/category/8.png', 0, NULL, NULL, NULL),
(72, 'Nail Care & Polish', 8, 1, 72, '/images/category/8.png', 0, NULL, NULL, NULL),
(73, 'Hair Care & Salon', 8, 1, 73, '/images/category/8.png', 0, NULL, NULL, NULL),
(74, 'Dietary Supplements, Nutrition', 8, 1, 74, '/images/category/8.png', 0, NULL, NULL, NULL),
(75, 'Bath & Body', 8, 1, 75, '/images/category/8.png', 0, NULL, NULL, NULL),
(76, 'Medical, Mobility & Disability', 8, 1, 76, '/images/category/8.png', 0, NULL, NULL, NULL),
(77, 'Vision Care', 8, 1, 77, '/images/category/8.png', 0, NULL, NULL, NULL),
(78, 'Health Care', 8, 1, 78, '/images/category/8.png', 0, NULL, NULL, NULL),
(79, 'Natural & Homeopathic Remedies', 8, 1, 79, '/images/category/8.png', 0, NULL, NULL, NULL),
(80, 'Tattoos & Body Art', 8, 1, 80, '/images/category/8.png', 0, NULL, NULL, NULL),
(81, 'Shaving & Hair Removal', 8, 1, 81, '/images/category/8.png', 0, NULL, NULL, NULL),
(82, 'Massage', 8, 1, 82, '/images/category/8.png', 0, NULL, NULL, NULL),
(83, 'Other', 8, 1, 83, '/images/category/8.png', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `category_product`
--

DROP TABLE IF EXISTS `category_product`;
CREATE TABLE IF NOT EXISTS `category_product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category_product`
--

INSERT INTO `category_product` (`product_id`, `category_id`) VALUES
(20, 15),
(17, 14),
(20, 14),
(20, 13),
(17, 13),
(17, 1),
(45, 1),
(45, 13),
(16, 14),
(16, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `object_name` varchar(80) NOT NULL,
  `text` text NOT NULL,
  `replyto_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `status` enum('new','deleted') DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`,`object_name`),
  KEY `status` (`status`),
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=219 ;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `object_id`, `object_name`, `text`, `replyto_id`, `time`, `status`, `person_id`) VALUES
(108, 120, 'messages', '', 0, 0, 'deleted', 13),
(109, 120, 'messages', '', 0, 0, 'deleted', 13),
(110, 122, 'messages', 'АгА', 0, 1363150694, 'new', 13),
(111, 122, 'messages', 'Агась', 0, 1363151505, 'new', 14),
(112, 122, 'messages', '', 0, 0, 'deleted', 14),
(113, 124, 'messages', 'jhgjhfj', 0, 1363152076, 'new', 12),
(114, 124, 'messages', 'kjhjkhk', 0, 1363152080, 'new', 12),
(115, 124, 'messages', 'kjhjkjhkj', 0, 1363152091, 'new', 12),
(116, 124, 'messages', 'kljhjkhkj', 0, 1363152095, 'new', 12),
(117, 124, 'messages', '', 0, 0, 'deleted', 12),
(118, 122, 'messages', 'Слет пенгвинов', 0, 1363192151, 'new', 14),
(119, 122, 'messages', '', 0, 0, 'deleted', 14),
(120, 124, 'messages', '', 0, 0, 'deleted', 12),
(121, 122, 'messages', 'Вот это я понимаю Нихао', 0, 1363321701, 'new', 14),
(122, 127, 'messages', 'А также там был и другой вид транспорта!', 0, 1363322332, 'new', 14),
(123, 127, 'messages', 'Или так', 0, 1363322458, 'new', 14),
(124, 127, 'messages', '', 0, 0, 'deleted', 13),
(125, 125, 'messages', '6846435497654163', 0, 1363325270, 'new', 14),
(126, 125, 'messages', '53412.1684', 0, 1363325280, 'new', 14),
(127, 125, 'messages', '68612321.0.', 0, 1363325290, 'new', 14),
(128, 121, 'messages', 'uoihkjjklguyjh', 0, 1363325298, 'new', 14),
(129, 121, 'messages', 'hfyrdghfcnbkuuy', 0, 1363325304, 'new', 14),
(130, 121, 'messages', 'bhgukyfrytxo;iily', 0, 1363325311, 'new', 14),
(131, 127, 'messages', '', 0, 0, 'deleted', 14),
(132, 127, 'messages', '', 0, 0, 'deleted', 14),
(133, 132, 'messages', 'Поломалось прикрепление фото во время комментирования новости! в Crome точно а в других не знаю!\nГлянешь?', 0, 1364053601, 'new', 14),
(134, 132, 'messages', 'Вот сейчас отображение новости приобретает отличный вид, еще пару штрихов у можно любым инвесторам показывать!', 0, 1364053663, 'new', 14),
(135, 135, 'messages', 'Шикарно подобранные фото, просто шикарно!\nГлянул и опять захотелось туда!\nЗря завтра не едешь - тоже красиво будет!\n', 0, 1364057282, 'new', 14),
(136, 134, 'messages', 'это пробная чтоли?', 0, 1364057344, 'new', 14),
(137, 135, 'messages', 'да я бы с радостью... ты же знаешь. но...', 0, 1364057453, 'new', 13),
(138, 134, 'messages', 'вот её не могу удалить', 0, 1364057527, 'new', 13),
(139, 129, 'messages', '', 0, 0, 'deleted', 12),
(140, 134, 'messages', '', 0, 0, 'deleted', 13),
(141, 132, 'messages', 'да, я переделываю прикрепление файлов к комментариям по другому', 0, 1364064063, 'new', 12),
(142, 130, 'messages', 'test', 0, 1364068405, 'new', 12),
(153, 138, 'messages', 'Сборы, перед выходом!', 0, 1367213073, 'new', 14),
(152, 176, 'messages', '', 0, 0, 'deleted', 14),
(145, 138, 'messages', 'Фотки прикольные получились...\r\n', 0, 1364132047, 'new', 16),
(146, 138, 'messages', '', 0, 0, 'deleted', 14),
(147, 138, 'messages', '', 0, 0, 'deleted', 13),
(148, 138, 'messages', '', 0, 0, 'deleted', 13),
(149, 138, 'messages', 'Согласен, они как то более красивее то место выставляют!', 0, 1364142570, 'new', 14),
(150, 135, 'messages', '', 0, 0, 'deleted', 14),
(151, 138, 'messages', '', 0, 0, 'deleted', 12),
(154, 333, 'messages', 'Неее фигня, там цивилизации нету!\r\n\r\nВот на моей фотке видно Небоскрёбы и всё остальное!', 0, 1367557654, 'new', 14),
(155, 339, 'messages', 'А это че за дыра, Дома маленькие, отделка беспантовая', 0, 1367557714, 'new', 14),
(156, 333, 'messages', 'A ну даа, ну даа!!! =D', 0, 1367557802, 'new', 20),
(157, 570, 'messages', 'Пробный комент.', 0, 1367986607, 'new', 14),
(158, 570, 'messages', '', 0, 0, 'deleted', 23),
(159, 127, 'messages', 'Оо коментить можно стало))', 0, 1368529164, 'new', 23),
(160, 127, 'messages', 'на Копендгагене яб не поехал...', 0, 1368529276, 'new', 23),
(161, 343, 'messages', '', 0, 0, 'deleted', 14),
(162, 127, 'messages', '', 0, 0, 'deleted', 23),
(163, 570, 'messages', '123123', 0, 1373879907, 'new', 12),
(164, 570, 'messages', '', 0, 0, 'deleted', 12),
(165, 570, 'messages', '', 0, 0, 'deleted', 12),
(166, 631, 'messages', '', 0, 0, 'deleted', 12),
(167, 636, 'messages', '123123', 0, 1375443057, 'new', 12),
(168, 636, 'messages', '', 0, 0, 'deleted', 12),
(169, 636, 'messages', 'епвапвапвап', 0, 1375556519, 'new', 12),
(170, 631, 'messages', '', 0, 0, 'deleted', 12),
(171, 648, 'messages', 'qweqwe', 0, 1378369588, 'new', 26),
(172, 636, 'messages', '123123123', 0, 1378790667, 'new', 12),
(173, 636, 'messages', '123123', 0, 1378790712, 'new', 12),
(174, 631, 'messages', '', 0, 0, 'deleted', 12),
(175, 636, 'messages', '123', 0, 1378790754, 'new', 12),
(176, 631, 'messages', '345345', 0, 1378790782, 'new', 12),
(177, 636, 'messages', '345345', 0, 1378790794, 'new', 12),
(178, 631, 'messages', '', 0, 0, 'deleted', 12),
(179, 669, 'messages', '', 0, 0, 'deleted', 12),
(180, 631, 'messages', '', 0, 0, 'deleted', 12),
(181, 669, 'messages', '', 0, 0, 'deleted', 12),
(182, 669, 'messages', '', 0, 0, 'deleted', 12),
(183, 669, 'messages', '', 0, 0, 'deleted', 12),
(184, 669, 'messages', '', 0, 0, 'deleted', 12),
(185, 669, 'messages', '', 0, 0, 'deleted', 12),
(186, 669, 'messages', '', 0, 0, 'deleted', 12),
(187, 669, 'messages', '', 0, 0, 'deleted', 12),
(188, 669, 'messages', '', 0, 0, 'deleted', 12),
(189, 669, 'messages', 'вапвапвап', 0, 1378971923, 'new', 12),
(190, 669, 'messages', 'ке апв пвыа павп вап', 0, 1378972132, 'new', 12),
(191, 668, 'messages', '123123', 0, 1378975011, 'new', 12),
(192, 669, 'messages', '3434', 0, 1378975022, 'new', 12),
(193, 669, 'messages', '12312323', 0, 1378975053, 'new', 12),
(194, 669, 'messages', '234234234', 0, 1378975343, 'new', 12),
(195, 669, 'messages', '', 0, 0, 'deleted', 12),
(196, 669, 'messages', 'кекеукеуке', 0, 1378975737, 'new', 12),
(197, 0, 'undefined', '', 0, 0, 'deleted', 12),
(198, 0, 'undefined', '', 0, 0, 'deleted', 12),
(199, 0, 'undefined', '', 0, 0, 'deleted', 12),
(200, 0, 'undefined', '', 0, 0, 'deleted', 12),
(201, 0, 'undefined', '', 0, 0, 'deleted', 12),
(202, 636, 'messages', 'укеукеуке', 0, 1378976864, 'new', 12),
(203, 343, 'messages', '', 0, 0, 'deleted', 12),
(204, 343, 'messages', '', 0, 0, 'deleted', 12),
(205, 343, 'messages', '', 0, 0, 'deleted', 12),
(206, 761, 'messages', 'dfsadfsdfsdf', 0, 1380281108, 'new', 12),
(207, 806, 'messages', '', 0, 0, 'deleted', 12),
(208, 807, 'messages', '1231231 3123', 0, 1380531788, 'new', 12),
(209, 845, 'messages', 'мываыва', 0, 1382731894, 'new', 12),
(211, 869, 'messages', 'ываываыва', 0, 1382732134, 'new', 12),
(212, 871, 'messages', '123123', 0, 1386874407, 'new', 12),
(213, 871, 'messages', 'ertertert', 0, 1386874434, 'new', 12),
(214, 871, 'messages', '', 0, 0, 'deleted', 12),
(215, 871, 'messages', '123123123', 0, 1386874976, 'new', 12),
(216, 12, 'product', '23123123', 0, 1389986244, 'new', 30),
(217, 15, 'product', 'вапвап', 0, 1392156548, 'new', 30),
(218, 1, 'order', 'ertert', 0, 1404466172, 'new', 30);

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) NOT NULL,
  `code2` varchar(2) DEFAULT NULL,
  `code3` varchar(3) DEFAULT NULL,
  `partofworld` varchar(12) DEFAULT NULL,
  `name_ru` varchar(255) DEFAULT NULL,
  `iso` int(11) NOT NULL DEFAULT '0',
  `ordr` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`),
  KEY `code2` (`code2`,`code3`,`partofworld`),
  KEY `name_ru` (`name_ru`),
  KEY `iso` (`iso`),
  KEY `ordr` (`ordr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=252 ;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `name_en`, `code2`, `code3`, `partofworld`, `name_ru`, `iso`, `ordr`) VALUES
(1, 'Abkhazia', 'AB', 'ABH', 'Азия', 'Республика Абхазия', 895, 10),
(2, 'Australia', 'AU', 'AUS', 'Океания', '', 36, 10),
(3, 'Austria', 'AT', 'AUT', 'Европа', 'Австрийская Республика', 40, 10),
(4, 'Azerbaijan', 'AZ', 'AZE', 'Азия', 'Республика Азербайджан', 31, 10),
(5, 'Albania', 'AL', 'ALB', 'Европа', 'Республика Албания', 8, 10),
(6, 'Algeria', 'DZ', 'DZA', 'Африка', 'Алжирская Народная Демократическая Республика', 12, 10),
(7, 'American Samoa', 'AS', 'ASM', 'Океания', '', 16, 10),
(8, 'Anguilla', 'AI', 'AIA', 'Америка', '', 660, 10),
(9, 'Angola', 'AO', 'AGO', 'Африка', 'Республика Ангола', 24, 10),
(10, 'Andorra', 'AD', 'AND', 'Европа', 'Княжество Андорра', 20, 10),
(11, 'Antarctica', 'AQ', 'ATA', 'Антарктика', '', 10, 10),
(12, 'Antigua and Barbuda', 'AG', 'ATG', 'Америка', '', 28, 10),
(13, 'Argentina', 'AR', 'ARG', 'Америка', 'Аргентинская Республика', 32, 10),
(14, 'Armenia', 'AM', 'ARM', 'Азия', 'Республика Армения', 51, 10),
(15, 'Aruba', 'AW', 'ABW', 'Америка', '', 533, 10),
(16, 'Afghanistan', 'AF', 'AFG', 'Азия', 'Переходное Исламское Государство Афганистан', 4, 10),
(17, 'Bahamas', 'BS', 'BHS', 'Америка', 'Содружество Багамы', 44, 10),
(18, 'Bangladesh', 'BD', 'BGD', 'Азия', 'Народная Республика Бангладеш', 50, 10),
(19, 'Barbados', 'BB', 'BRB', 'Америка', '', 52, 10),
(20, 'Bahrain', 'BH', 'BHR', 'Азия', 'Королевство Бахрейн', 48, 10),
(21, 'Belarus', 'BY', 'BLR', 'Европа', 'Республика Беларусь', 112, 10),
(22, 'Belize', 'BZ', 'BLZ', 'Америка', '', 84, 10),
(23, 'Belgium', 'BE', 'BEL', 'Европа', 'Королевство Бельгии', 56, 10),
(24, 'Benin', 'BJ', 'BEN', 'Африка', 'Республика Бенин', 204, 10),
(25, 'Bermuda', 'BM', 'BMU', 'Америка', '', 60, 10),
(26, 'Bulgaria', 'BG', 'BGR', 'Европа', 'Республика Болгария', 100, 10),
(27, 'Bolivia, plurinational state of', 'BO', 'BOL', 'Америка', 'Многонациональное Государство Боливия', 68, 10),
(28, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', 'Америка', '', 535, 10),
(29, 'Bosnia and Herzegovina', 'BA', 'BIH', 'Европа', '', 70, 10),
(30, 'Botswana', 'BW', 'BWA', 'Африка', 'Республика Ботсвана', 72, 10),
(31, 'Brazil', 'BR', 'BRA', 'Америка', 'Федеративная Республика Бразилия', 76, 10),
(32, 'British Indian Ocean Territory', 'IO', 'IOT', 'Океания', '', 86, 10),
(33, 'Brunei Darussalam', 'BN', 'BRN', 'Азия', '', 96, 10),
(34, 'Burkina Faso', 'BF', 'BFA', 'Африка', '', 854, 10),
(35, 'Burundi', 'BI', 'BDI', 'Африка', 'Республика Бурунди', 108, 10),
(36, 'Bhutan', 'BT', 'BTN', 'Азия', 'Королевство Бутан', 64, 10),
(37, 'Vanuatu', 'VU', 'VUT', 'Океания', 'Республика Вануату', 548, 10),
(38, 'Hungary', 'HU', 'HUN', 'Европа', 'Венгерская Республика', 348, 10),
(39, 'Venezuela', 'VE', 'VEN', 'Америка', 'Боливарийская Республика Венесуэла', 862, 10),
(40, 'Virgin Islands, British', 'VG', 'VGB', 'Америка', 'Британские Виргинские острова', 92, 10),
(41, 'Virgin Islands, U.S.', 'VI', 'VIR', 'Америка', 'Виргинские острова Соединенных Штатов', 850, 10),
(42, 'Vietnam', 'VN', 'VNM', 'Азия', 'Социалистическая Республика Вьетнам', 704, 10),
(43, 'Gabon', 'GA', 'GAB', 'Африка', 'Габонская Республика', 266, 10),
(44, 'Haiti', 'HT', 'HTI', 'Америка', 'Республика Гаити', 332, 10),
(45, 'Guyana', 'GY', 'GUY', 'Америка', 'Республика Гайана', 328, 10),
(46, 'Gambia', 'GM', 'GMB', 'Африка', 'Республика Гамбия', 270, 10),
(47, 'Ghana', 'GH', 'GHA', 'Африка', 'Республика Гана', 288, 10),
(48, 'Guadeloupe', 'GP', 'GLP', 'Америка', '', 312, 10),
(49, 'Guatemala', 'GT', 'GTM', 'Америка', 'Республика Гватемала', 320, 10),
(50, 'Guinea', 'GN', 'GIN', 'Африка', 'Гвинейская Республика', 324, 10),
(51, 'Guinea-Bissau', 'GW', 'GNB', 'Африка', 'Республика Гвинея-Бисау', 624, 10),
(52, 'Germany', 'DE', 'DEU', 'Европа', 'Федеративная Республика Германия', 276, 10),
(53, 'Guernsey', 'GG', 'GGY', 'Европа', '', 831, 10),
(54, 'Gibraltar', 'GI', 'GIB', 'Европа', '', 292, 10),
(55, 'Honduras', 'HN', 'HND', 'Америка', 'Республика Гондурас', 340, 10),
(56, 'Hong Kong', 'HK', 'HKG', 'Азия', 'Специальный  административный  регион Китая Гонконг', 344, 10),
(57, 'Grenada', 'GD', 'GRD', 'Америка', '', 308, 10),
(58, 'Greenland', 'GL', 'GRL', 'Америка', '', 304, 10),
(59, 'Greece', 'GR', 'GRC', 'Европа', 'Греческая Республика', 300, 10),
(60, 'Georgia', 'GE', 'GEO', 'Азия', '', 268, 10),
(61, 'Guam', 'GU', 'GUM', 'Океания', '', 316, 10),
(62, 'Denmark', 'DK', 'DNK', 'Европа', 'Королевство Дания', 208, 10),
(63, 'Jersey', 'JE', 'JEY', 'Европа', '', 832, 10),
(64, 'Djibouti', 'DJ', 'DJI', 'Африка', 'Республика Джибути', 262, 10),
(65, 'Dominica', 'DM', 'DMA', 'Америка', 'Содружество Доминики', 212, 10),
(66, 'Dominican Republic', 'DO', 'DOM', 'Америка', '', 214, 10),
(67, 'Egypt', 'EG', 'EGY', 'Африка', 'Арабская Республика Египет', 818, 10),
(68, 'Zambia', 'ZM', 'ZMB', 'Африка', 'Республика Замбия', 894, 10),
(69, 'Western Sahara', 'EH', 'ESH', 'Африка', '', 732, 10),
(70, 'Zimbabwe', 'ZW', 'ZWE', 'Африка', 'Республика Зимбабве', 716, 10),
(71, 'Israel', 'IL', 'ISR', 'Азия', 'Государство Израиль', 376, 10),
(72, 'India', 'IN', 'IND', 'Азия', 'Республика Индия', 356, 10),
(73, 'Indonesia', 'ID', 'IDN', 'Азия', 'Республика Индонезия', 360, 10),
(74, 'Jordan', 'JO', 'JOR', 'Азия', 'Иорданское Хашимитское Королевство', 400, 10),
(75, 'Iraq', 'IQ', 'IRQ', 'Азия', 'Республика Ирак', 368, 10),
(76, 'Iran, Islamic Republic of', 'IR', 'IRN', 'Азия', 'Исламская Республика Иран', 364, 10),
(77, 'Ireland', 'IE', 'IRL', 'Европа', '', 372, 10),
(78, 'Iceland', 'IS', 'ISL', 'Европа', 'Республика Исландия', 352, 10),
(79, 'Spain', 'ES', 'ESP', 'Европа', 'Королевство Испания', 724, 10),
(80, 'Italy', 'IT', 'ITA', 'Европа', 'Итальянская Республика', 380, 10),
(81, 'Yemen', 'YE', 'YEM', 'Азия', 'Йеменская Республика', 887, 10),
(82, 'Cape Verde', 'CV', 'CPV', 'Африка', 'Республика Кабо-Верде', 132, 10),
(83, 'Kazakhstan', 'KZ', 'KAZ', 'Азия', 'Республика Казахстан', 398, 10),
(84, 'Cambodia', 'KH', 'KHM', 'Азия', 'Королевство Камбоджа', 116, 10),
(85, 'Cameroon', 'CM', 'CMR', 'Африка', 'Республика Камерун', 120, 10),
(86, 'Canada', 'CA', 'CAN', 'Америка', '', 124, 10),
(87, 'Qatar', 'QA', 'QAT', 'Азия', 'Государство Катар', 634, 10),
(88, 'Kenya', 'KE', 'KEN', 'Африка', 'Республика Кения', 404, 10),
(89, 'Cyprus', 'CY', 'CYP', 'Азия', 'Республика Кипр', 196, 10),
(90, 'Kyrgyzstan', 'KG', 'KGZ', 'Азия', 'Киргизская Республика', 417, 10),
(91, 'Kiribati', 'KI', 'KIR', 'Океания', 'Республика Кирибати', 296, 10),
(92, 'China', 'CN', 'CHN', 'Азия', 'Китайская Народная Республика', 156, 10),
(93, 'Cocos (Keeling) Islands', 'CC', 'CCK', 'Океания', '', 166, 10),
(94, 'Colombia', 'CO', 'COL', 'Америка', 'Республика Колумбия', 170, 10),
(95, 'Comoros', 'KM', 'COM', 'Африка', 'Союз Коморы', 174, 10),
(96, 'Congo', 'CG', 'COG', 'Африка', 'Республика Конго', 178, 10),
(97, 'Congo, Democratic Republic of the', 'CD', 'COD', 'Африка', 'Демократическая Республика Конго', 180, 10),
(98, 'Korea, Democratic People''s republic of', 'KP', 'PRK', 'Азия', 'Корейская Народно-Демократическая Республика', 408, 10),
(99, 'Korea, Republic of', 'KR', 'KOR', 'Азия', 'Республика Корея', 410, 10),
(100, 'Costa Rica', 'CR', 'CRI', 'Америка', 'Республика Коста-Рика', 188, 10),
(101, 'Cote d''Ivoire', 'CI', 'CIV', 'Африка', 'Республика Кот д''Ивуар', 384, 10),
(102, 'Cuba', 'CU', 'CUB', 'Америка', 'Республика Куба', 192, 10),
(103, 'Kuwait', 'KW', 'KWT', 'Азия', 'Государство Кувейт', 414, 10),
(104, 'Curaçao', 'CW', 'CUW', 'Америка', '', 531, 10),
(105, 'Lao People''s Democratic Republic', 'LA', 'LAO', 'Азия', 'Лаосская Народно-Демократическая Республика', 418, 10),
(106, 'Latvia', 'LV', 'LVA', 'Европа', 'Латвийская Республика', 428, 10),
(107, 'Lesotho', 'LS', 'LSO', 'Африка', 'Королевство Лесото', 426, 10),
(108, 'Lebanon', 'LB', 'LBN', 'Азия', 'Ливанская Республика', 422, 10),
(109, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 'Африка', 'Социалистическая Народная Ливийская Арабская Джамахирия', 434, 10),
(110, 'Liberia', 'LR', 'LBR', 'Африка', 'Республика Либерия', 430, 10),
(111, 'Liechtenstein', 'LI', 'LIE', 'Европа', 'Княжество Лихтенштейн', 438, 10),
(112, 'Lithuania', 'LT', 'LTU', 'Европа', 'Литовская Республика', 440, 10),
(113, 'Luxembourg', 'LU', 'LUX', 'Европа', 'Великое Герцогство Люксембург', 442, 10),
(114, 'Mauritius', 'MU', 'MUS', 'Африка', 'Республика Маврикий', 480, 10),
(115, 'Mauritania', 'MR', 'MRT', 'Африка', 'Исламская Республика Мавритания', 478, 10),
(116, 'Madagascar', 'MG', 'MDG', 'Африка', 'Республика Мадагаскар', 450, 10),
(117, 'Mayotte', 'YT', 'MYT', 'Африка', '', 175, 10),
(118, 'Macao', 'MO', 'MAC', 'Азия', 'Специальный административный регион Китая Макао', 446, 10),
(119, 'Malawi', 'MW', 'MWI', 'Африка', 'Республика Малави', 454, 10),
(120, 'Malaysia', 'MY', 'MYS', 'Азия', '', 458, 10),
(121, 'Mali', 'ML', 'MLI', 'Африка', 'Республика Мали', 466, 10),
(122, 'United States Minor Outlying Islands', 'UM', 'UMI', 'Океания', '', 581, 10),
(123, 'Maldives', 'MV', 'MDV', 'Азия', 'Мальдивская Республика', 462, 10),
(124, 'Malta', 'MT', 'MLT', 'Европа', 'Республика Мальта', 470, 10),
(125, 'Morocco', 'MA', 'MAR', 'Африка', 'Королевство Марокко', 504, 10),
(126, 'Martinique', 'MQ', 'MTQ', 'Америка', '', 474, 10),
(127, 'Marshall Islands', 'MH', 'MHL', 'Океания', 'Республика Маршалловы острова', 584, 10),
(128, 'Mexico', 'MX', 'MEX', 'Америка', 'Мексиканские Соединенные Штаты', 484, 10),
(129, 'Micronesia, Federated States of', 'FM', 'FSM', 'Океания', 'Федеративные штаты Микронезии', 583, 10),
(130, 'Mozambique', 'MZ', 'MOZ', 'Африка', 'Республика Мозамбик', 508, 10),
(131, 'Moldova', 'MD', 'MDA', 'Европа', 'Республика Молдова', 498, 10),
(132, 'Monaco', 'MC', 'MCO', 'Европа', 'Княжество Монако', 492, 10),
(133, 'Mongolia', 'MN', 'MNG', 'Азия', '', 496, 10),
(134, 'Montserrat', 'MS', 'MSR', 'Америка', '', 500, 10),
(135, 'Burma', 'MM', 'MMR', 'Азия', 'Союз Мьянма', 104, 10),
(136, 'Namibia', 'NA', 'NAM', 'Африка', 'Республика Намибия', 516, 10),
(137, 'Nauru', 'NR', 'NRU', 'Океания', 'Республика Науру', 520, 10),
(138, 'Nepal', 'NP', 'NPL', 'Азия', 'Королевство Непал', 524, 10),
(139, 'Niger', 'NE', 'NER', 'Африка', 'Республика Нигер', 562, 10),
(140, 'Nigeria', 'NG', 'NGA', 'Африка', 'Федеративная Республика Нигерия', 566, 10),
(141, 'Netherlands', 'NL', 'NLD', 'Европа', 'Королевство Нидерландов', 528, 10),
(142, 'Nicaragua', 'NI', 'NIC', 'Америка', 'Республика Никарагуа', 558, 10),
(143, 'Niue', 'NU', 'NIU', 'Океания', 'Республика Ниуэ', 570, 10),
(144, 'New Zealand', 'NZ', 'NZL', 'Океания', '', 554, 10),
(145, 'New Caledonia', 'NC', 'NCL', 'Океания', '', 540, 10),
(146, 'Norway', 'NO', 'NOR', 'Европа', 'Королевство Норвегия', 578, 10),
(147, 'United Arab Emirates', 'AE', 'ARE', 'Азия', '', 784, 10),
(148, 'Oman', 'OM', 'OMN', 'Азия', 'Султанат Оман', 512, 10),
(149, 'Bouvet Island', 'BV', 'BVT', '', '', 74, 10),
(150, 'Isle of Man', 'IM', 'IMN', 'Европа', '', 833, 10),
(151, 'Norfolk Island', 'NF', 'NFK', 'Океания', '', 574, 10),
(152, 'Christmas Island', 'CX', 'CXR', 'Азия', '', 162, 10),
(153, 'Heard Island and McDonald Islands', 'HM', 'HMD', '', '', 334, 10),
(154, 'Cayman Islands', 'KY', 'CYM', 'Америка', '', 136, 10),
(155, 'Cook Islands', 'CK', 'COK', 'Океания', '', 184, 10),
(156, 'Turks and Caicos Islands', 'TC', 'TCA', 'Америка', '', 796, 10),
(157, 'Pakistan', 'PK', 'PAK', 'Азия', 'Исламская Республика Пакистан', 586, 10),
(158, 'Palau', 'PW', 'PLW', 'Океания', 'Республика Палау', 585, 10),
(159, 'Palestinian Territory, Occupied', 'PS', 'PSE', 'Азия', 'Оккупированная Палестинская территория', 275, 10),
(160, 'Panama', 'PA', 'PAN', 'Америка', 'Республика Панама', 591, 10),
(161, 'Holy See (Vatican City State)', 'VA', 'VAT', 'Европа', '', 336, 10),
(162, 'Papua New Guinea', 'PG', 'PNG', 'Океания', '', 598, 10),
(163, 'Paraguay', 'PY', 'PRY', 'Америка', 'Республика Парагвай', 600, 10),
(164, 'Peru', 'PE', 'PER', 'Америка', 'Республика Перу', 604, 10),
(165, 'Pitcairn', 'PN', 'PCN', 'Океания', '', 612, 10),
(166, 'Poland', 'PL', 'POL', 'Европа', 'Республика Польша', 616, 10),
(167, 'Portugal', 'PT', 'PRT', 'Европа', 'Португальская Республика', 620, 10),
(168, 'Puerto Rico', 'PR', 'PRI', 'Америка', '', 630, 10),
(169, 'Macedonia, The Former Yugoslab Republic Of', 'MK', 'MKD', 'Европа', '', 807, 10),
(170, 'Reunion', 'RE', 'REU', 'Африка', '', 638, 10),
(171, 'Russian Federation', 'RU', 'RUS', 'Европа', 'Российская Федерация', 643, 10),
(172, 'Rwanda', 'RW', 'RWA', 'Африка', 'Руандийская Республика', 646, 10),
(173, 'Romania', 'RO', 'ROU', 'Европа', '', 642, 10),
(174, 'Samoa', 'WS', 'WSM', 'Океания', 'Независимое Государство Самоа', 882, 10),
(175, 'San Marino', 'SM', 'SMR', 'Европа', 'Республика Сан-Марино', 674, 10),
(176, 'Sao Tome and Principe', 'ST', 'STP', 'Африка', 'Демократическая Республика Сан-Томе и Принсипи', 678, 10),
(177, 'Saudi Arabia', 'SA', 'SAU', 'Азия', 'Королевство Саудовская Аравия', 682, 10),
(178, 'Swaziland', 'SZ', 'SWZ', 'Африка', 'Королевство Свазиленд', 748, 10),
(179, 'Saint Helena, Ascension And Tristan Da Cunha', 'SH', 'SHN', 'Африка', '', 654, 10),
(180, 'Northern Mariana Islands', 'MP', 'MNP', 'Океания', 'Содружество Северных Марианских островов', 580, 10),
(181, 'Saint Barthélemy', 'BL', 'BLM', 'Америка', '', 652, 10),
(182, 'Saint Martin (French Part)', 'MF', 'MAF', 'Америка', '', 663, 10),
(183, 'Senegal', 'SN', 'SEN', 'Африка', 'Республика Сенегал', 686, 10),
(184, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 'Америка', '', 670, 10),
(185, 'Saint Kitts and Nevis', 'KN', 'KNA', 'Америка', '', 659, 10),
(186, 'Saint Lucia', 'LC', 'LCA', 'Америка', '', 662, 10),
(187, 'Saint Pierre and Miquelon', 'PM', 'SPM', 'Америка', '', 666, 10),
(188, 'Serbia', 'RS', 'SRB', 'Европа', 'Республика Сербия', 688, 10),
(189, 'Seychelles', 'SC', 'SYC', 'Африка', 'Республика Сейшелы', 690, 10),
(190, 'Singapore', 'SG', 'SGP', 'Азия', 'Республика Сингапур', 702, 10),
(191, 'Sint Maarten', 'SX', 'SXM', 'Америка', '', 534, 10),
(192, 'Syrian Arab Republic', 'SY', 'SYR', 'Азия', '', 760, 10),
(193, 'Slovakia', 'SK', 'SVK', 'Европа', 'Словацкая Республика', 703, 10),
(194, 'Slovenia', 'SI', 'SVN', 'Европа', 'Республика Словения', 705, 10),
(195, 'United Kingdom', 'GB', 'GBR', 'Европа', 'Соединенное Королевство Великобритании и Северной Ирландии', 826, 10),
(196, 'United States', 'US', 'USA', 'Америка', 'Соединенные Штаты Америки', 840, 10),
(197, 'Solomon Islands', 'SB', 'SLB', 'Океания', '', 90, 10),
(198, 'Somalia', 'SO', 'SOM', 'Африка', 'Сомалийская Республика', 706, 10),
(199, 'Sudan', 'SD', 'SDN', 'Африка', 'Республика Судан', 736, 10),
(200, 'Suriname', 'SR', 'SUR', 'Америка', 'Республика Суринам', 740, 10),
(201, 'Sierra Leone', 'SL', 'SLE', 'Африка', 'Республика Сьерра-Леоне', 694, 10),
(202, 'Tajikistan', 'TJ', 'TJK', 'Азия', 'Республика Таджикистан', 762, 10),
(203, 'Thailand', 'TH', 'THA', 'Азия', 'Королевство Таиланд', 764, 10),
(204, 'Taiwan, Province of China', 'TW', 'TWN', 'Азия', '', 158, 10),
(205, 'Tanzania, United Republic Of', 'TZ', 'TZA', 'Африка', 'Объединенная Республика Танзания', 834, 10),
(206, 'Timor-Leste', 'TL', 'TLS', 'Азия', 'Демократическая Республика Тимор-Лесте', 626, 10),
(207, 'Togo', 'TG', 'TGO', 'Африка', 'Тоголезская Республика', 768, 10),
(208, 'Tokelau', 'TK', 'TKL', 'Океания', '', 772, 10),
(209, 'Tonga', 'TO', 'TON', 'Океания', 'Королевство Тонга', 776, 10),
(210, 'Trinidad and Tobago', 'TT', 'TTO', 'Америка', 'Республика Тринидад и Тобаго', 780, 10),
(211, 'Tuvalu', 'TV', 'TUV', 'Океания', '', 798, 10),
(212, 'Tunisia', 'TN', 'TUN', 'Африка', 'Тунисская Республика', 788, 10),
(213, 'Turkmenistan', 'TM', 'TKM', 'Азия', 'Туркменистан', 795, 10),
(214, 'Turkey', 'TR', 'TUR', 'Азия', 'Турецкая Республика', 792, 10),
(215, 'Uganda', 'UG', 'UGA', 'Африка', 'Республика Уганда', 800, 10),
(216, 'Uzbekistan', 'UZ', 'UZB', 'Азия', 'Республика Узбекистан', 860, 10),
(217, 'Ukraine', 'UA', 'UKR', 'Европа', '', 804, 10),
(218, 'Wallis and Futuna', 'WF', 'WLF', 'Океания', '', 876, 10),
(219, 'Uruguay', 'UY', 'URY', 'Америка', 'Восточная Республика Уругвай', 858, 10),
(220, 'Faroe Islands', 'FO', 'FRO', 'Европа', '', 234, 10),
(221, 'Fiji', 'FJ', 'FJI', 'Океания', 'Республика островов Фиджи', 242, 10),
(222, 'Philippines', 'PH', 'PHL', 'Азия', 'Республика Филиппины', 608, 10),
(223, 'Finland', 'FI', 'FIN', 'Европа', 'Финляндская Республика', 246, 10),
(224, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 'Америка', '', 238, 10),
(225, 'France', 'FR', 'FRA', 'Европа', 'Французская Республика', 250, 10),
(226, 'French Guiana', 'GF', 'GUF', 'Америка', '', 254, 10),
(227, 'French Polynesia', 'PF', 'PYF', 'Океания', '', 258, 10),
(228, 'French Southern Territories', 'TF', 'ATF', '', '', 260, 10),
(229, 'Croatia', 'HR', 'HRV', 'Европа', 'Республика Хорватия', 191, 10),
(230, 'Central African Republic', 'CF', 'CAF', 'Африка', '', 140, 10),
(231, 'Chad', 'TD', 'TCD', 'Африка', 'Республика Чад', 148, 10),
(232, 'Montenegro', 'ME', 'MNE', 'Европа', 'Республика Черногория', 499, 10),
(233, 'Czech Republic', 'CZ', 'CZE', 'Европа', '', 203, 10),
(234, 'Chile', 'CL', 'CHL', 'Америка', 'Республика Чили', 152, 10),
(235, 'Switzerland', 'CH', 'CHE', 'Европа', 'Швейцарская Конфедерация', 756, 10),
(236, 'Sweden', 'SE', 'SWE', 'Европа', 'Королевство Швеция', 752, 10),
(237, 'Svalbard and Jan Mayen', 'SJ', 'SJM', 'Европа', '', 744, 10),
(238, 'Sri Lanka', 'LK', 'LKA', 'Азия', 'Демократическая Социалистическая Республика Шри-Ланка', 144, 10),
(239, 'Ecuador', 'EC', 'ECU', 'Америка', 'Республика Эквадор', 218, 10),
(240, 'Equatorial Guinea', 'GQ', 'GNQ', 'Африка', 'Республика Экваториальная Гвинея', 226, 10),
(241, 'Åland Islands', 'AX', 'ALA', 'Европа', '', 248, 10),
(242, 'El Salvador', 'SV', 'SLV', 'Америка', 'Республика Эль-Сальвадор', 222, 10),
(243, 'Eritrea', 'ER', 'ERI', 'Африка', '', 232, 10),
(244, 'Estonia', 'EE', 'EST', 'Европа', 'Эстонская Республика', 233, 10),
(245, 'Ethiopia', 'ET', 'ETH', 'Африка', 'Федеративная Демократическая Республика Эфиопия', 231, 10),
(246, 'South Africa', 'ZA', 'ZAF', 'Африка', 'Южно-Африканская Республика', 710, 10),
(247, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '', '', 239, 10),
(248, 'South Ossetia', 'OS', 'OST', 'Азия', 'Республика Южная Осетия', 896, 10),
(249, 'South Sudan', 'SS', 'SSD', 'Африка', '', 728, 10),
(250, 'Jamaica', 'JM', 'JAM', 'Америка', '', 388, 10),
(251, 'Japan', 'JP', 'JPN', 'Азия', '', 392, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `country_content`
--

DROP TABLE IF EXISTS `country_content`;
CREATE TABLE IF NOT EXISTS `country_content` (
  `code2` varchar(2) NOT NULL DEFAULT '',
  `code3` varchar(3) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `name_ch` varchar(255) DEFAULT NULL,
  `name_it` varchar(255) DEFAULT NULL,
  `name_ru` varchar(255) DEFAULT NULL,
  `iso` int(11) NOT NULL DEFAULT '0',
  `ordr` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`code2`),
  KEY `code3` (`code3`),
  KEY `name_ru` (`name_ru`),
  KEY `name_en` (`name_en`),
  KEY `name_ch` (`name_ch`),
  KEY `name_it` (`name_it`),
  KEY `iso` (`iso`),
  KEY `ordr` (`ordr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `country_content`
--

INSERT INTO `country_content` (`code2`, `code3`, `name_en`, `name_ch`, `name_it`, `name_ru`, `iso`, `ordr`) VALUES
('CN', 'CHN', 'China', 'China', 'China', 'Китай', 156, 2),
('IT', 'ITA', 'Italy', 'Italy', 'Italy', 'Италия', 380, 4),
('RU', 'RUS', 'Russian Federation', 'Russian Federation', 'Russian Federation', 'Российская Федерация', 643, 1),
('US', 'USA', 'United States', 'United States', 'United States', 'Соединенные Штаты Америки', 840, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

DROP TABLE IF EXISTS `currency`;
CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(10) DEFAULT NULL,
  `koef` float DEFAULT NULL,
  `trumbnail_url` varchar(255) DEFAULT NULL,
  `ordr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordr` (`ordr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name_en`, `koef`, `trumbnail_url`, `ordr`) VALUES
(1, 'USD', 1, '/images/currency/usd.png', 1),
(2, 'руб.', 34, '/images/currency/rur.png', 2),
(3, 'eur', 0.8, '/images/currency/eur.png', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

DROP TABLE IF EXISTS `friends`;
CREATE TABLE IF NOT EXISTS `friends` (
  `person_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  UNIQUE KEY `person_id` (`person_id`,`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`person_id`, `friend_id`) VALUES
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 22),
(12, 25),
(13, 14),
(13, 16),
(13, 23),
(14, 12),
(14, 16),
(14, 19),
(14, 20),
(14, 23),
(15, 12),
(20, 12),
(21, 14),
(33, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
CREATE TABLE IF NOT EXISTS `friend_requests` (
  `person_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  UNIQUE KEY `person_id` (`person_id`,`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `friend_requests`
--

INSERT INTO `friend_requests` (`person_id`, `friend_id`) VALUES
(12, 5),
(12, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `group_id` int(11) DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  `ordr` int(11) NOT NULL DEFAULT '0',
  `thumbnail_url` varchar(250) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`visible`,`ordr`),
  KEY `shop_id` (`shop_id`),
  KEY `visible` (`visible`),
  KEY `ordr` (`ordr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- Дамп данных таблицы `group`
--

INSERT INTO `group` (`id`, `name`, `group_id`, `visible`, `ordr`, `thumbnail_url`, `shop_id`) VALUES
(25, 'Модульный Дом', 0, 1, 1, '/images/group/25.60x60.jpg', 13),
(26, '123', 0, 0, 1, NULL, 14),
(27, 'группа', 0, 0, 2, NULL, 14),
(28, 'фвафывфыв1', 66, 5, 3, '/images/group/28.60x60.jpeg', 14),
(66, 'новая группа', 26, 5, 25, '/images/group/66.205x205.png', 14),
(40, NULL, 0, -1, 10, NULL, 14),
(73, NULL, 0, -1, 32, NULL, 14),
(41, NULL, 0, -1, 11, NULL, 14),
(42, NULL, 0, -1, 12, NULL, 14),
(43, NULL, 0, -1, 13, NULL, 14),
(44, NULL, 0, -1, 14, NULL, 14),
(45, NULL, 0, -1, 15, NULL, 14),
(46, NULL, 0, -1, 16, NULL, 14),
(47, NULL, 0, -1, 17, NULL, 14),
(48, NULL, 0, -1, 18, NULL, 14),
(49, NULL, 0, -1, 19, NULL, 14),
(50, NULL, 0, -1, 20, NULL, 14),
(51, NULL, 0, -1, 21, NULL, 14),
(52, NULL, 0, -1, 22, NULL, 14),
(53, NULL, 0, -1, 23, '/images/group/53.205x205.png', 14),
(54, NULL, 0, -1, 24, NULL, 14),
(74, NULL, 0, -1, 33, NULL, 14),
(67, '234345', 0, 5, 26, '/images/group/67.205x205.png', 14),
(68, NULL, 0, -1, 27, NULL, 14),
(69, NULL, 0, -1, 28, NULL, 14),
(70, NULL, 0, -1, 29, NULL, 14),
(71, NULL, 0, -1, 30, NULL, 14),
(72, NULL, 0, -1, 31, NULL, 14),
(75, NULL, 0, -1, 34, NULL, 14);

-- --------------------------------------------------------

--
-- Структура таблицы `group_access`
--

DROP TABLE IF EXISTS `group_access`;
CREATE TABLE IF NOT EXISTS `group_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `shopusergroup_id` int(11) NOT NULL,
  `access` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `group_access`
--

INSERT INTO `group_access` (`id`, `shop_id`, `group_id`, `shopusergroup_id`, `access`) VALUES
(9, 14, 27, 4, 1),
(10, 14, 27, 5, 1),
(11, 14, 26, 4, 1),
(12, 14, 26, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `group_product`
--

DROP TABLE IF EXISTS `group_product`;
CREATE TABLE IF NOT EXISTS `group_product` (
  `product_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group_product`
--

INSERT INTO `group_product` (`product_id`, `group_id`) VALUES
(12, 25),
(13, 25),
(27, 28),
(27, 27),
(15, 27),
(20, 27),
(45, 26);

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(4) DEFAULT NULL,
  `name` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `languages`
--


-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `object_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `object_id` (`object_id`,`object_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`id`, `person_id`, `time`, `object_id`, `object_name`) VALUES
(47, 13, 1363147764, 120, 'messages'),
(48, 13, 1363150585, 122, 'messages'),
(49, 13, 1363150586, 121, 'messages'),
(50, 14, 1363151979, 122, 'messages'),
(51, 14, 1364057204, 135, 'messages'),
(52, 13, 1364057887, 135, 'messages'),
(53, 12, 1382731919, 845, 'messages'),
(56, 30, 1395870794, 45, 'product'),
(57, 30, 1398057062, 1057, 'messages'),
(58, 30, 1398057152, 1056, 'messages');

-- --------------------------------------------------------

--
-- Структура таблицы `media_items`
--

DROP TABLE IF EXISTS `media_items`;
CREATE TABLE IF NOT EXISTS `media_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `mime_type` char(64) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `last_updated` int(11) DEFAULT NULL,
  `language` char(64) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `num_comments` int(11) DEFAULT NULL,
  `num_views` int(11) DEFAULT NULL,
  `num_votes` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `start_time` char(64) DEFAULT NULL,
  `title` char(255) DEFAULT NULL,
  `description` text,
  `tagged_people` text,
  `tags` text,
  `thumbnail_url` char(128) DEFAULT NULL,
  `type` enum('AUDIO','IMAGE','VIDEO','FILE') NOT NULL,
  `url` char(128) NOT NULL,
  `app_id` int(11) DEFAULT '0',
  `thumbnail_url220` varchar(255) DEFAULT NULL,
  `thumbnail_url600` varchar(255) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `object_name` varchar(250) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  KEY `id` (`id`),
  KEY `activity_id` (`activity_id`),
  KEY `album_id` (`album_id`),
  KEY `message_id` (`message_id`),
  KEY `comment_id` (`comment_id`,`object_name`,`object_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=497 ;

--
-- Дамп данных таблицы `media_items`
--

INSERT INTO `media_items` (`id`, `activity_id`, `album_id`, `owner_id`, `mime_type`, `file_size`, `duration`, `created`, `last_updated`, `language`, `address_id`, `num_comments`, `num_views`, `num_votes`, `rating`, `start_time`, `title`, `description`, `tagged_people`, `tags`, `thumbnail_url`, `type`, `url`, `app_id`, `thumbnail_url220`, `thumbnail_url600`, `message_id`, `comment_id`, `object_name`, `object_id`, `width`, `height`) VALUES
(160, NULL, 8, 12, '', NULL, NULL, 1363318986, 1363318986, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2_login2', NULL, NULL, NULL, '/images/albums/8/160.220x220.png', 'IMAGE', '1', 0, NULL, '/images/albums/8/160.600x600.png', NULL, NULL, NULL, NULL, NULL, NULL),
(159, NULL, 8, 12, '', NULL, NULL, 1363203641, 1363203641, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'vk2', NULL, NULL, NULL, '/images/albums/8/159.220x220.png', 'IMAGE', '1', 0, NULL, '/images/albums/8/159.600x600.png', NULL, NULL, NULL, NULL, NULL, NULL),
(161, NULL, 9, 14, '', NULL, NULL, 1363321610, 1363321610, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1e56c358-57af-4afa-8222-10a2ff8debae', NULL, NULL, NULL, '/images/albums/9/161.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/161.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(162, NULL, 9, 14, '', NULL, NULL, 1363321612, 1363321612, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5-element', NULL, NULL, NULL, '/images/albums/9/162.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/162.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(163, NULL, 9, 14, '', NULL, NULL, 1363321613, 1363321613, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '57681241', NULL, NULL, NULL, '/images/albums/9/163.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/163.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(164, NULL, 9, 14, '', NULL, NULL, 1363321614, 1363321614, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1305883736', NULL, NULL, NULL, '/images/albums/9/164.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/164.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(165, NULL, 9, 14, '', NULL, NULL, 1363321616, 1363321616, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dallas', NULL, NULL, NULL, '/images/albums/9/165.220x220.gif', 'IMAGE', '1', 0, NULL, '/images/albums/9/165.600x600.gif', NULL, NULL, NULL, NULL, NULL, NULL),
(166, NULL, 9, 14, '', NULL, NULL, 1363321617, 1363321617, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fifth_element_2', NULL, NULL, NULL, '/images/albums/9/166.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/166.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(167, NULL, 9, 14, '', NULL, NULL, 1363321618, 1363321618, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'korben', NULL, NULL, NULL, '/images/albums/9/167.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/167.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(168, NULL, NULL, 14, '', NULL, NULL, 1363321668, 1363321668, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2011-aston-martin-vantage-gt4-02', NULL, NULL, NULL, '/images/comment/121/168.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/121/168.600x600.jpg', NULL, 121, 'messages', 122, NULL, NULL),
(203, NULL, NULL, 13, '', NULL, NULL, 1364056385, 1364056385, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5328', NULL, NULL, NULL, '/images/messages/135/203.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/135/203.600x600.jpg', 135, NULL, NULL, NULL, NULL, NULL),
(202, NULL, NULL, 13, '', NULL, NULL, 1364056385, 1364056385, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMGP2285', NULL, NULL, NULL, '/images/messages/135/202.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/135/202.600x600.jpg', 135, NULL, NULL, NULL, NULL, NULL),
(201, NULL, NULL, 13, '', NULL, NULL, 1364056384, 1364056384, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMGP2214', NULL, NULL, NULL, '/images/messages/135/201.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/135/201.600x600.jpg', 135, NULL, NULL, NULL, NULL, NULL),
(172, NULL, NULL, 14, '', NULL, NULL, 1363322317, 1363322317, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0076', NULL, NULL, NULL, '/images/comment/122/172.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/122/172.600x600.jpg', NULL, 122, 'messages', 127, NULL, NULL),
(173, NULL, NULL, 14, '', NULL, NULL, 1363322324, 1363322324, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0156', NULL, NULL, NULL, '/images/comment/122/173.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/122/173.600x600.jpg', NULL, 122, 'messages', 127, NULL, NULL),
(174, NULL, NULL, 14, '', NULL, NULL, 1363322443, 1363322443, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0025', NULL, NULL, NULL, '/images/comment/123/174.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/123/174.600x600.jpg', NULL, 123, 'messages', 127, NULL, NULL),
(175, NULL, NULL, 14, '', NULL, NULL, 1363322452, 1363322452, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0031', NULL, NULL, NULL, '/images/comment/123/175.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/123/175.600x600.jpg', NULL, 123, 'messages', 127, NULL, NULL),
(176, NULL, 9, 14, '', NULL, NULL, 1363323535, 1363323535, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0133', NULL, NULL, NULL, '/images/albums/9/176.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/176.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(177, NULL, 6, 13, '', NULL, NULL, 1363324086, 1363324086, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00000707', NULL, NULL, NULL, '/images/albums/6/177.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/6/177.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(178, NULL, NULL, 12, '', NULL, NULL, 1363325146, 1363325146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '234234', NULL, NULL, NULL, '/images/messages/102/178.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/102/178.600x600.png', 102, NULL, NULL, NULL, NULL, NULL),
(180, NULL, 9, 14, '', NULL, NULL, 1363580541, 1363580589, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0180', NULL, NULL, NULL, '/images/albums/9/180.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/180.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(181, NULL, 9, 14, '', NULL, NULL, 1363580542, 1363580542, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0156', NULL, NULL, NULL, '/images/albums/9/181.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/181.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(182, NULL, 9, 14, '', NULL, NULL, 1363580542, 1363580542, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0133', NULL, NULL, NULL, '/images/albums/9/182.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/182.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(183, NULL, 9, 14, '', NULL, NULL, 1363580544, 1363580544, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0181', NULL, NULL, NULL, '/images/albums/9/183.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/9/183.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(184, NULL, 10, 14, '', NULL, NULL, 1363596196, 1363596196, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0025', NULL, NULL, NULL, '/images/albums/10/184.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/184.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(185, NULL, 10, 14, '', NULL, NULL, 1363596196, 1363596196, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0180', NULL, NULL, NULL, '/images/albums/10/185.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/185.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(186, NULL, 10, 14, '', NULL, NULL, 1363596196, 1363596196, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0156', NULL, NULL, NULL, '/images/albums/10/186.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/186.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(187, NULL, 10, 14, '', NULL, NULL, 1363596197, 1363596197, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0076', NULL, NULL, NULL, '/images/albums/10/187.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/187.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(188, NULL, 10, 14, '', NULL, NULL, 1363596197, 1363596197, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0133', NULL, NULL, NULL, '/images/albums/10/188.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/188.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(189, NULL, 10, 14, '', NULL, NULL, 1363596197, 1363596197, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0031', NULL, NULL, NULL, '/images/albums/10/189.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/189.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(190, NULL, 10, 14, '', NULL, NULL, 1363596205, 1363596205, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0181', NULL, NULL, NULL, '/images/albums/10/190.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/190.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(191, NULL, NULL, 12, '', NULL, NULL, 1364007814, 1364007814, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aBMv2cU7_uQ', NULL, NULL, NULL, '/images/messages/129/191.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/129/191.600x600.jpg', 129, NULL, NULL, NULL, NULL, NULL),
(198, NULL, NULL, 14, '', NULL, NULL, 1364053338, 1364053338, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_6215', NULL, NULL, NULL, '/images/messages/132/198.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/132/198.600x600.jpg', 132, NULL, NULL, NULL, NULL, NULL),
(193, NULL, NULL, 12, '', NULL, NULL, 1364007816, 1364007816, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yaq7RNDrdQk', NULL, NULL, NULL, '/images/messages/129/193.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/129/193.600x600.jpg', 129, NULL, NULL, NULL, NULL, NULL),
(194, NULL, NULL, 12, '', NULL, NULL, 1364007817, 1364007817, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'дуров', NULL, NULL, NULL, '/images/messages/129/194.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/129/194.600x600.jpg', 129, NULL, NULL, NULL, NULL, NULL),
(195, NULL, NULL, 12, '', NULL, NULL, 1364007867, 1364007867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6057_original', NULL, NULL, NULL, '/images/messages/130/195.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/130/195.600x600.png', 130, NULL, NULL, NULL, NULL, NULL),
(196, NULL, NULL, 12, '', NULL, NULL, 1364007868, 1364007868, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '02846001', NULL, NULL, NULL, '/images/messages/130/196.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/130/196.600x600.jpg', 130, NULL, NULL, NULL, NULL, NULL),
(197, NULL, NULL, 12, '', NULL, NULL, 1364007870, 1364007870, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '52145784', NULL, NULL, NULL, '/images/messages/130/197.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/130/197.600x600.png', 130, NULL, NULL, NULL, NULL, NULL),
(199, NULL, NULL, 14, '', NULL, NULL, 1364053338, 1364053338, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_6216', NULL, NULL, NULL, '/images/messages/132/199.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/132/199.600x600.jpg', 132, NULL, NULL, NULL, NULL, NULL),
(200, NULL, NULL, 14, '', NULL, NULL, 1364053339, 1364053339, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_6217', NULL, NULL, NULL, '/images/messages/132/200.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/132/200.600x600.jpg', 132, NULL, NULL, NULL, NULL, NULL),
(204, NULL, NULL, 13, '', NULL, NULL, 1364056767, 1364056767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5281', NULL, NULL, NULL, '/images/messages/135/204.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/135/204.600x600.jpg', 135, NULL, NULL, NULL, NULL, NULL),
(205, NULL, NULL, 13, '', NULL, NULL, 1364056768, 1364056768, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5016', NULL, NULL, NULL, '/images/messages/135/205.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/135/205.600x600.jpg', 135, NULL, NULL, NULL, NULL, NULL),
(236, NULL, NULL, 12, '', NULL, NULL, 1364068398, 1364068398, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '27NnQV0ZxEM', NULL, NULL, NULL, '/images/comment/142/236.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/142/236.600x600.jpg', NULL, 142, 'messages', 130, NULL, NULL),
(207, NULL, 11, 13, '', NULL, NULL, 1364057010, 1364057010, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4704-1', NULL, NULL, NULL, '/images/albums/11/207.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/207.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(208, NULL, 11, 13, '', NULL, NULL, 1364057012, 1364057012, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4835', NULL, NULL, NULL, '/images/albums/11/208.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/208.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(209, NULL, 11, 13, '', NULL, NULL, 1364057012, 1364057012, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4796', NULL, NULL, NULL, '/images/albums/11/209.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/209.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(210, NULL, 11, 13, '', NULL, NULL, 1364057013, 1364057013, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4919', NULL, NULL, NULL, '/images/albums/11/210.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/210.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(211, NULL, 11, 13, '', NULL, NULL, 1364057013, 1364057013, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4715', NULL, NULL, NULL, '/images/albums/11/211.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/211.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(212, NULL, 11, 13, '', NULL, NULL, 1364057013, 1364057013, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4710', NULL, NULL, NULL, '/images/albums/11/212.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/212.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(213, NULL, 11, 13, '', NULL, NULL, 1364057014, 1364057014, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4959', NULL, NULL, NULL, '/images/albums/11/213.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/213.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(214, NULL, 11, 13, '', NULL, NULL, 1364057050, 1364057050, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5028', NULL, NULL, NULL, '/images/albums/11/214.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/214.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(215, NULL, 11, 13, '', NULL, NULL, 1364057051, 1364057051, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5277', NULL, NULL, NULL, '/images/albums/11/215.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/215.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(216, NULL, 11, 13, '', NULL, NULL, 1364057052, 1364057052, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5281', NULL, NULL, NULL, '/images/albums/11/216.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/216.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(217, NULL, 11, 13, '', NULL, NULL, 1364057053, 1364057053, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5276', NULL, NULL, NULL, '/images/albums/11/217.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/217.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(218, NULL, 11, 13, '', NULL, NULL, 1364057053, 1364057053, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4973', NULL, NULL, NULL, '/images/albums/11/218.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/218.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(219, NULL, 11, 13, '', NULL, NULL, 1364057054, 1364057054, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5016', NULL, NULL, NULL, '/images/albums/11/219.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/219.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(220, NULL, 11, 13, '', NULL, NULL, 1364057054, 1364057054, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5023', NULL, NULL, NULL, '/images/albums/11/220.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/220.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(221, NULL, 11, 13, '', NULL, NULL, 1364057079, 1364057079, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5288', NULL, NULL, NULL, '/images/albums/11/221.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/221.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(222, NULL, 11, 13, '', NULL, NULL, 1364057079, 1364057079, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5306', NULL, NULL, NULL, '/images/albums/11/222.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/222.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(223, NULL, 11, 13, '', NULL, NULL, 1364057080, 1364057080, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5290', NULL, NULL, NULL, '/images/albums/11/223.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/223.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(224, NULL, 11, 13, '', NULL, NULL, 1364057080, 1364057080, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5295', NULL, NULL, NULL, '/images/albums/11/224.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/224.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(225, NULL, 11, 13, '', NULL, NULL, 1364057082, 1364057082, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5321', NULL, NULL, NULL, '/images/albums/11/225.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/225.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(226, NULL, 11, 13, '', NULL, NULL, 1364057083, 1364057083, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5328', NULL, NULL, NULL, '/images/albums/11/226.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/226.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(227, NULL, 11, 13, '', NULL, NULL, 1364057083, 1364057083, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5293', NULL, NULL, NULL, '/images/albums/11/227.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/227.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(228, NULL, 11, 13, '', NULL, NULL, 1364057084, 1364057084, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5291', NULL, NULL, NULL, '/images/albums/11/228.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/228.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(229, NULL, 11, 13, '', NULL, NULL, 1364057090, 1364057090, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5574', NULL, NULL, NULL, '/images/albums/11/229.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/229.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(230, NULL, 11, 13, '', NULL, NULL, 1364057091, 1364057091, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5570', NULL, NULL, NULL, '/images/albums/11/230.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/230.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(231, NULL, 11, 13, '', NULL, NULL, 1364057092, 1364057092, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5694', NULL, NULL, NULL, '/images/albums/11/231.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/231.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(232, NULL, 11, 13, '', NULL, NULL, 1364057092, 1364057092, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5527', NULL, NULL, NULL, '/images/albums/11/232.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/232.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(233, NULL, 11, 13, '', NULL, NULL, 1364057092, 1364057092, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5340', NULL, NULL, NULL, '/images/albums/11/233.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/233.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(234, NULL, 11, 13, '', NULL, NULL, 1364057093, 1364057093, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5438', NULL, NULL, NULL, '/images/albums/11/234.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/234.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(235, NULL, 11, 13, '', NULL, NULL, 1364057095, 1364057095, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_5338', NULL, NULL, NULL, '/images/albums/11/235.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/11/235.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(237, NULL, NULL, 12, '', NULL, NULL, 1364068398, 1364068398, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6057_original', NULL, NULL, NULL, '/images/comment/142/237.220x220.png', 'IMAGE', '1', 0, NULL, '/images/comment/142/237.600x600.png', NULL, 142, 'messages', 130, NULL, NULL),
(238, NULL, NULL, 12, '', NULL, NULL, 1364068399, 1364068399, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '02846001', NULL, NULL, NULL, '/images/comment/142/238.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/142/238.600x600.jpg', NULL, 142, 'messages', 130, NULL, NULL),
(239, NULL, NULL, 14, '', NULL, NULL, 1364127785, 1364127785, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Мохня какая то', NULL, NULL, NULL, '/images/messages/138/239.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/239.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(240, NULL, NULL, 14, '', NULL, NULL, 1364127786, 1364127786, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Забор под выским напряжением', NULL, NULL, NULL, '/images/messages/138/240.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/240.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(241, NULL, NULL, 14, '', NULL, NULL, 1364127787, 1364127787, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Озеро Платинка', NULL, NULL, NULL, '/images/messages/138/241.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/241.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(242, NULL, NULL, 14, '', NULL, NULL, 1364127787, 1364127787, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Забор под высоким разрешением', NULL, NULL, NULL, '/images/messages/138/242.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/242.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(243, NULL, NULL, 14, '', NULL, NULL, 1364127788, 1364127788, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Конь 2', NULL, NULL, NULL, '/images/messages/138/243.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/243.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(244, NULL, NULL, 14, '', NULL, NULL, 1364127788, 1364127788, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Забурились в ЛЕС', NULL, NULL, NULL, '/images/messages/138/244.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/244.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(245, NULL, NULL, 14, '', NULL, NULL, 1364127789, 1364127789, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Конь', NULL, NULL, NULL, '/images/messages/138/245.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/138/245.600x600.jpg', 138, NULL, NULL, NULL, NULL, NULL),
(246, NULL, NULL, 14, '', NULL, NULL, 1364127891, 1364127891, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Река АЙ', NULL, NULL, NULL, '/images/comment/143/246.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/246.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(247, NULL, NULL, 14, '', NULL, NULL, 1364127891, 1364127891, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Серёха 2', NULL, NULL, NULL, '/images/comment/143/247.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/247.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(248, NULL, NULL, 14, '', NULL, NULL, 1364127892, 1364127892, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Перед спуском на реку', NULL, NULL, NULL, '/images/comment/143/248.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/248.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(249, NULL, NULL, 14, '', NULL, NULL, 1364127893, 1364127893, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Село Платинка 1', NULL, NULL, NULL, '/images/comment/143/249.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/249.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(250, NULL, NULL, 14, '', NULL, NULL, 1364127893, 1364127893, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'СерёХА', NULL, NULL, NULL, '/images/comment/143/250.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/250.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(251, NULL, NULL, 14, '', NULL, NULL, 1364127894, 1364127894, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Село Платинка 2', NULL, NULL, NULL, '/images/comment/143/251.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/251.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(252, NULL, NULL, 14, '', NULL, NULL, 1364127894, 1364127894, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Реклама', NULL, NULL, NULL, '/images/comment/143/252.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/143/252.600x600.jpg', NULL, 143, 'messages', 138, NULL, NULL),
(253, NULL, NULL, 14, '', NULL, NULL, 1364127915, 1364127915, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Уезжаем из Платинка', NULL, NULL, NULL, '/images/comment/144/253.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/144/253.600x600.jpg', NULL, 144, 'messages', 138, NULL, NULL),
(254, NULL, NULL, 14, '', NULL, NULL, 1364127915, 1364127915, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Тропа к реке ай 2', NULL, NULL, NULL, '/images/comment/144/254.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/144/254.600x600.jpg', NULL, 144, 'messages', 138, NULL, NULL),
(255, NULL, NULL, 14, '', NULL, NULL, 1364127916, 1364127916, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Хребет Уреньга', NULL, NULL, NULL, '/images/comment/144/255.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/144/255.600x600.jpg', NULL, 144, 'messages', 138, NULL, NULL),
(256, NULL, NULL, 14, '', NULL, NULL, 1364127916, 1364127916, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Тропа к реке АЙ', NULL, NULL, NULL, '/images/comment/144/256.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/144/256.600x600.jpg', NULL, 144, 'messages', 138, NULL, NULL),
(257, NULL, NULL, 14, '', NULL, NULL, 1364133492, 1364133492, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Забор под высоким разрешением', NULL, NULL, NULL, '/images/messages/139/257.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/257.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(258, NULL, NULL, 14, '', NULL, NULL, 1364133492, 1364133492, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Забурились в ЛЕС', NULL, NULL, NULL, '/images/messages/139/258.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/258.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(259, NULL, NULL, 14, '', NULL, NULL, 1364133494, 1364133494, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'СерёХА', NULL, NULL, NULL, '/images/messages/139/259.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/259.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(260, NULL, NULL, 14, '', NULL, NULL, 1364133495, 1364133495, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Конь', NULL, NULL, NULL, '/images/messages/139/260.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/260.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(261, NULL, NULL, 14, '', NULL, NULL, 1364133495, 1364133495, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Уезжаем из Платинка', NULL, NULL, NULL, '/images/messages/139/261.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/261.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(262, NULL, NULL, 14, '', NULL, NULL, 1364133496, 1364133496, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Серёха 2', NULL, NULL, NULL, '/images/messages/139/262.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/262.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(263, NULL, NULL, 14, '', NULL, NULL, 1364133496, 1364133496, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Перед спуском на реку', NULL, NULL, NULL, '/images/messages/139/263.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/263.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(264, NULL, NULL, 14, '', NULL, NULL, 1364133497, 1364133497, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Озеро Платинка', NULL, NULL, NULL, '/images/messages/139/264.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/139/264.600x600.jpg', 139, NULL, NULL, NULL, NULL, NULL),
(265, NULL, NULL, 12, '', NULL, NULL, 1364754038, 1364754038, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'left1', NULL, NULL, NULL, '/images/messages/144/265.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/144/265.600x600.png', 144, NULL, NULL, NULL, NULL, NULL),
(266, NULL, NULL, 14, '', NULL, NULL, 1364789259, 1364789259, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4293', NULL, NULL, NULL, '/images/messages/157/266.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/157/266.600x600.jpg', 157, NULL, NULL, NULL, NULL, NULL),
(267, NULL, NULL, 14, '', NULL, NULL, 1364881273, 1364881273, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3065-2', NULL, NULL, NULL, '/images/messages/169/267.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/169/267.600x600.jpg', 169, NULL, NULL, NULL, NULL, NULL),
(268, NULL, NULL, 14, '', NULL, NULL, 1365067803, 1365067803, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_2425', NULL, NULL, NULL, '/images/messages/173/268.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/173/268.600x600.jpg', 173, NULL, NULL, NULL, NULL, NULL),
(269, NULL, NULL, 20, '', NULL, NULL, 1365083352, 1365083352, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5IMG_0364', NULL, NULL, NULL, '/images/messages/174/269.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/174/269.600x600.jpg', 174, NULL, NULL, NULL, NULL, NULL),
(270, NULL, NULL, 20, '', NULL, NULL, 1365083430, 1365083430, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5IMG_0364', NULL, NULL, NULL, '/images/messages/175/270.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/175/270.600x600.jpg', 175, NULL, NULL, NULL, NULL, NULL),
(271, NULL, NULL, 14, '', NULL, NULL, 1365170355, 1365170355, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_6984', NULL, NULL, NULL, '/images/messages/176/271.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/176/271.600x600.jpg', 176, NULL, NULL, NULL, NULL, NULL),
(272, NULL, NULL, 14, '', NULL, NULL, 1365170418, 1365170418, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_7017', NULL, NULL, NULL, '/images/messages/176/272.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/176/272.600x600.jpg', 176, NULL, NULL, NULL, NULL, NULL),
(273, NULL, NULL, 14, '', NULL, NULL, 1365170426, 1365170426, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_7013', NULL, NULL, NULL, '/images/messages/176/273.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/176/273.600x600.jpg', 176, NULL, NULL, NULL, NULL, NULL),
(274, NULL, NULL, 14, '', NULL, NULL, 1365170450, 1365170450, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_7027', NULL, NULL, NULL, '/images/messages/176/274.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/176/274.600x600.jpg', 176, NULL, NULL, NULL, NULL, NULL),
(275, NULL, NULL, 14, '', NULL, NULL, 1365235097, 1365235097, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3065-3', NULL, NULL, NULL, '/images/messages/177/275.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/177/275.600x600.jpg', 177, NULL, NULL, NULL, NULL, NULL),
(276, NULL, NULL, 14, '', NULL, NULL, 1365235098, 1365235098, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3065-2', NULL, NULL, NULL, '/images/messages/177/276.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/177/276.600x600.jpg', 177, NULL, NULL, NULL, NULL, NULL),
(277, NULL, NULL, 14, '', NULL, NULL, 1365235101, 1365235101, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3065-1', NULL, NULL, NULL, '/images/messages/177/277.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/177/277.600x600.jpg', 177, NULL, NULL, NULL, NULL, NULL),
(278, NULL, NULL, 14, '', NULL, NULL, 1365235104, 1365235104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3139-2', NULL, NULL, NULL, '/images/messages/177/278.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/177/278.600x600.jpg', 177, NULL, NULL, NULL, NULL, NULL),
(279, NULL, NULL, 14, '', NULL, NULL, 1365235109, 1365235109, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3139-6', NULL, NULL, NULL, '/images/messages/177/279.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/177/279.600x600.jpg', 177, NULL, NULL, NULL, NULL, NULL),
(280, NULL, NULL, 12, '', NULL, NULL, 1365236129, 1365236129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '257032', NULL, NULL, NULL, '/images/messages/183/280.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/183/280.600x600.jpg', 183, NULL, NULL, NULL, NULL, NULL),
(281, NULL, NULL, 14, '', NULL, NULL, 1365416173, 1365416173, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0080', NULL, NULL, NULL, NULL, 'IMAGE', '', 0, NULL, NULL, 195, NULL, NULL, NULL, NULL, NULL),
(282, NULL, NULL, 14, '', NULL, NULL, 1365416183, 1365416183, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0080', NULL, NULL, NULL, '/images/messages/195/282.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/195/282.600x600.jpg', 195, NULL, NULL, NULL, NULL, NULL),
(283, NULL, NULL, 14, '', NULL, NULL, 1366350039, 1366350039, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00_title', NULL, NULL, NULL, '/images/messages/214/283.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/214/283.600x600.jpg', 214, NULL, NULL, NULL, NULL, NULL),
(284, NULL, NULL, 14, '', NULL, NULL, 1366357170, 1366357170, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00_title', NULL, NULL, NULL, '/images/messages/217/284.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/217/284.600x600.jpg', 217, NULL, NULL, NULL, NULL, NULL),
(285, NULL, NULL, 14, '', NULL, NULL, 1366357177, 1366357177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4314', NULL, NULL, NULL, '/images/messages/217/285.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/217/285.600x600.jpg', 217, NULL, NULL, NULL, NULL, NULL),
(286, NULL, NULL, 14, '', NULL, NULL, 1366357178, 1366357178, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4293', NULL, NULL, NULL, '/images/messages/217/286.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/217/286.600x600.jpg', 217, NULL, NULL, NULL, NULL, NULL),
(287, NULL, NULL, 12, '', NULL, NULL, 1366536123, 1366536123, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2. Джоан К. Роулинг - Гарри Поттер и Тайная Комната', NULL, NULL, NULL, NULL, 'FILE', '', 0, NULL, NULL, 222, NULL, NULL, NULL, NULL, NULL),
(288, NULL, NULL, 12, '', NULL, NULL, 1366536148, 1366536148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Довлатов, Сергей. Чемодан', NULL, NULL, NULL, NULL, 'FILE', '', 0, NULL, NULL, 224, NULL, NULL, NULL, NULL, NULL),
(290, NULL, NULL, 12, '', NULL, NULL, 1366536985, 1366536985, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Довлатов, Сергей. Чемодан', NULL, NULL, NULL, '', 'FILE', '/files/messages/115/Dovlatov, Sergey. Chemodan.txt', 0, NULL, '', 115, NULL, NULL, NULL, NULL, NULL),
(291, NULL, NULL, 12, '', NULL, NULL, 1366537053, 1366537053, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Довлатов, Сергей. Чемодан', NULL, NULL, NULL, '', 'FILE', '/files/messages/231/Dovlatov, Sergey. Chemodan.txt', 0, NULL, '', 231, NULL, NULL, NULL, NULL, NULL),
(292, NULL, NULL, 14, '', NULL, NULL, 1367209632, 1367209632, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4306', NULL, NULL, NULL, '/images/messages/234/292.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/234/292.600x600.jpg', 234, NULL, NULL, NULL, NULL, NULL),
(293, NULL, NULL, 14, '', NULL, NULL, 1367209633, 1367209633, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4309', NULL, NULL, NULL, '/images/messages/234/293.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/234/293.600x600.jpg', 234, NULL, NULL, NULL, NULL, NULL),
(294, NULL, NULL, 14, '', NULL, NULL, 1367209679, 1367209679, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4306', NULL, NULL, NULL, '', 'FILE', '/files/messages/234/DSCF4306.jpg', 0, NULL, '', 234, NULL, NULL, NULL, NULL, NULL),
(295, NULL, NULL, 14, '', NULL, NULL, 1367213058, 1367213058, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4314', NULL, NULL, NULL, '/images/comment/153/295.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/153/295.600x600.jpg', NULL, 153, 'messages', 138, NULL, NULL),
(296, NULL, NULL, 20, '', NULL, NULL, 1367557228, 1367557228, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'NJQc9sNla_w', NULL, NULL, NULL, '/images/messages/333/296.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/333/296.600x600.jpg', 333, NULL, NULL, NULL, NULL, NULL),
(297, NULL, NULL, 20, '', NULL, NULL, 1367557243, 1367557243, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6q_D7bcSRxU', NULL, NULL, NULL, '/images/messages/333/297.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/333/297.600x600.jpg', 333, NULL, NULL, NULL, NULL, NULL),
(298, NULL, NULL, 14, '', NULL, NULL, 1367557361, 1367557361, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'korben', NULL, NULL, NULL, '/images/messages/335/298.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/335/298.600x600.jpg', 335, NULL, NULL, NULL, NULL, NULL),
(299, NULL, NULL, 14, '', NULL, NULL, 1367557361, 1367557361, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fifth_element_2', NULL, NULL, NULL, '/images/messages/335/299.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/335/299.600x600.jpg', 335, NULL, NULL, NULL, NULL, NULL),
(300, NULL, NULL, 20, '', NULL, NULL, 1367557408, 1367557408, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PqlFEuHAwOs', NULL, NULL, NULL, '/images/messages/338/300.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/338/300.600x600.jpg', 338, NULL, NULL, NULL, NULL, NULL),
(301, NULL, NULL, 20, '', NULL, NULL, 1367557471, 1367557471, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PqlFEuHAwOs', NULL, NULL, NULL, '/images/messages/339/301.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/339/301.600x600.jpg', 339, NULL, NULL, NULL, NULL, NULL),
(302, NULL, NULL, 14, '', NULL, NULL, 1367557632, 1367557632, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4700', NULL, NULL, NULL, '/images/comment/154/302.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/154/302.600x600.jpg', NULL, 154, 'messages', 333, NULL, NULL),
(303, NULL, NULL, 14, '', NULL, NULL, 1367557711, 1367557711, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSCF4289', NULL, NULL, NULL, '/images/comment/155/303.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/155/303.600x600.jpg', NULL, 155, 'messages', 339, NULL, NULL),
(304, NULL, NULL, 20, '', NULL, NULL, 1367557712, 1367557712, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'D7UWNQ17U3c', NULL, NULL, NULL, '/images/messages/343/304.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/343/304.600x600.jpg', 343, NULL, NULL, NULL, NULL, NULL),
(305, NULL, NULL, 20, '', NULL, NULL, 1367557720, 1367557720, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'rR3o4Ct7X-0', NULL, NULL, NULL, '/images/messages/343/305.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/343/305.600x600.jpg', 343, NULL, NULL, NULL, NULL, NULL),
(306, NULL, NULL, 14, '', NULL, NULL, 1367986493, 1367986493, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4778', NULL, NULL, NULL, '/images/messages/570/306.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/570/306.600x600.jpg', 570, NULL, NULL, NULL, NULL, NULL),
(307, NULL, NULL, 14, '', NULL, NULL, 1367986493, 1367986493, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4737', NULL, NULL, NULL, '/images/messages/570/307.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/570/307.600x600.jpg', 570, NULL, NULL, NULL, NULL, NULL),
(308, NULL, NULL, 14, '', NULL, NULL, 1367986493, 1367986493, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4754', NULL, NULL, NULL, '/images/messages/570/308.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/570/308.600x600.jpg', 570, NULL, NULL, NULL, NULL, NULL),
(309, NULL, NULL, 14, '', NULL, NULL, 1367986494, 1367986494, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4757', NULL, NULL, NULL, '/images/messages/570/309.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/570/309.600x600.jpg', 570, NULL, NULL, NULL, NULL, NULL),
(310, NULL, NULL, 14, '', NULL, NULL, 1367986496, 1367986496, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4765', NULL, NULL, NULL, '/images/messages/570/310.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/570/310.600x600.jpg', 570, NULL, NULL, NULL, NULL, NULL),
(311, NULL, NULL, 14, '', NULL, NULL, 1367986496, 1367986496, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_4766', NULL, NULL, NULL, '/images/messages/570/311.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/570/311.600x600.jpg', 570, NULL, NULL, NULL, NULL, NULL),
(312, NULL, NULL, 12, '', NULL, NULL, 1368874787, 1368874787, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '(6) Гарри Поттер и Принц-полукровка', NULL, NULL, NULL, '', 'FILE', '/files/messages/586/(6) Garri Potter i Princ-polukrovka.txt', 0, NULL, '', 586, NULL, NULL, NULL, NULL, NULL),
(313, NULL, 10, 14, '', NULL, NULL, 1372936377, 1372936377, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '107156-2560x1920', NULL, NULL, NULL, '/images/albums/10/313.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/10/313.600x600.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(314, NULL, NULL, 14, '', NULL, NULL, 1373886160, 1373886160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0778', NULL, NULL, NULL, '/images/messages/609/314.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/609/314.600x600.jpg', 609, NULL, NULL, NULL, NULL, NULL),
(315, NULL, NULL, 14, '', NULL, NULL, 1373886215, 1373886215, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0777', NULL, NULL, NULL, '/images/messages/609/315.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/609/315.600x600.jpg', 609, NULL, NULL, NULL, NULL, NULL),
(316, NULL, NULL, 14, '', NULL, NULL, 1373886370, 1373886370, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0777', NULL, NULL, NULL, '/images/messages/613/316.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/613/316.600x600.jpg', 613, NULL, NULL, NULL, NULL, NULL),
(317, NULL, NULL, 14, '', NULL, NULL, 1373886379, 1373886379, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0778', NULL, NULL, NULL, '/images/messages/613/317.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/613/317.600x600.jpg', 613, NULL, NULL, NULL, NULL, NULL),
(318, NULL, NULL, 14, '', NULL, NULL, 1373886637, 1373886637, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0180', NULL, NULL, NULL, '/images/car/8/318.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/8/318.600x600.jpg', NULL, NULL, 'car', 8, NULL, NULL),
(319, NULL, NULL, 14, '', NULL, NULL, 1373886638, 1373886638, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0133', NULL, NULL, NULL, '/images/car/8/319.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/8/319.600x600.jpg', NULL, NULL, 'car', 8, NULL, NULL),
(320, NULL, NULL, 14, '', NULL, NULL, 1373886641, 1373886641, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0181', NULL, NULL, NULL, '/images/car/8/320.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/8/320.600x600.jpg', NULL, NULL, 'car', 8, NULL, NULL),
(334, NULL, NULL, 14, '', NULL, NULL, 1375429444, 1375429444, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0085', NULL, NULL, NULL, '/images/car/9/334.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/9/334.600x600.jpg', NULL, NULL, 'car', 9, NULL, NULL),
(330, NULL, NULL, 14, '', NULL, NULL, 1375343699, 1375343699, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0180', NULL, NULL, NULL, '/images/car/9/330.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/9/330.600x600.jpg', NULL, NULL, 'car', 9, NULL, NULL),
(331, NULL, NULL, 14, '', NULL, NULL, 1375343701, 1375343701, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0133', NULL, NULL, NULL, '/images/car/9/331.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/9/331.600x600.jpg', NULL, NULL, 'car', 9, NULL, NULL),
(324, NULL, NULL, 14, '', NULL, NULL, 1373887374, 1373887374, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0076', NULL, NULL, NULL, '/images/comment/168/324.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/168/324.600x600.jpg', NULL, 168, 'messages', 613, NULL, NULL),
(325, NULL, NULL, 14, '', NULL, NULL, 1373887375, 1373887375, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0031', NULL, NULL, NULL, '/images/comment/168/325.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/168/325.600x600.jpg', NULL, 168, 'messages', 613, NULL, NULL),
(326, NULL, NULL, 14, '', NULL, NULL, 1373959083, 1373959083, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '284299-1920x1080', NULL, NULL, NULL, '/images/comment/171/326.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/171/326.600x600.jpg', NULL, 171, 'messages', 613, NULL, NULL),
(327, NULL, NULL, 14, '', NULL, NULL, 1373959083, 1373959083, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '121814-2048x1536', NULL, NULL, NULL, '/images/comment/171/327.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/171/327.600x600.jpg', NULL, 171, 'messages', 613, NULL, NULL),
(333, NULL, NULL, 14, '', NULL, NULL, 1375429235, 1375429235, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0025', NULL, NULL, NULL, '/images/car/9/333.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/9/333.600x600.jpg', NULL, NULL, 'car', 9, NULL, NULL),
(332, NULL, NULL, 14, '', NULL, NULL, 1375343703, 1375343703, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0181', NULL, NULL, NULL, '/images/car/9/332.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/9/332.600x600.jpg', NULL, NULL, 'car', 9, NULL, NULL),
(335, NULL, NULL, 14, '', NULL, NULL, 1375429444, 1375429444, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0084', NULL, NULL, NULL, '/images/car/9/335.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/9/335.600x600.jpg', NULL, NULL, 'car', 9, NULL, NULL),
(336, NULL, NULL, 14, '', NULL, NULL, 1375430321, 1375430321, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0084', NULL, NULL, NULL, '/images/messages/624/336.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/624/336.600x600.jpg', 624, NULL, NULL, NULL, NULL, NULL),
(337, NULL, NULL, 14, '', NULL, NULL, 1375430322, 1375430322, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DPP_0085', NULL, NULL, NULL, '/images/messages/624/337.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/624/337.600x600.jpg', 624, NULL, NULL, NULL, NULL, NULL),
(338, NULL, NULL, 14, '', NULL, NULL, 1375430447, 1375430447, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Шрифты', NULL, NULL, NULL, '', 'FILE', '/files/messages/625/Shrifty.docx', 0, NULL, '', 625, NULL, NULL, NULL, NULL, NULL),
(339, NULL, NULL, 14, '', NULL, NULL, 1375430469, 1375430469, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '121814-2048x1536', NULL, NULL, NULL, '/images/messages/625/339.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/625/339.600x600.jpg', 625, NULL, NULL, NULL, NULL, NULL),
(340, NULL, NULL, 14, '', NULL, NULL, 1375430475, 1375430475, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '116924-1920x1200', NULL, NULL, NULL, '/images/messages/625/340.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/625/340.600x600.jpg', 625, NULL, NULL, NULL, NULL, NULL),
(341, NULL, NULL, 12, '', NULL, NULL, 1378788002, 1378788002, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/car/57/341.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/car/57/341.600x600.jpeg', NULL, NULL, 'car', 57, NULL, NULL),
(342, NULL, NULL, 12, '', NULL, NULL, 1378788154, 1378788154, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/car/57/342.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/57/342.600x600.jpg', NULL, NULL, 'car', 57, NULL, NULL),
(343, NULL, NULL, 12, '', NULL, NULL, 1378788155, 1378788155, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/car/57/343.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/57/343.600x600.jpg', NULL, NULL, 'car', 57, NULL, NULL),
(344, NULL, NULL, 12, '', NULL, NULL, 1378788156, 1378788156, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/car/57/344.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/car/57/344.600x600.jpeg', NULL, NULL, 'car', 57, NULL, NULL),
(345, NULL, NULL, 12, '', NULL, NULL, 1378788156, 1378788156, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/car/57/345.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/car/57/345.600x600.jpeg', NULL, NULL, 'car', 57, NULL, NULL),
(346, NULL, NULL, 13, '', NULL, NULL, 1379337842, 1379337842, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ac7e6d116f89e9aa6152ea4f3f5c', NULL, NULL, NULL, '/images/messages/646/346.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/646/346.600x600.jpg', 646, NULL, NULL, NULL, NULL, NULL),
(347, NULL, NULL, 13, '', NULL, NULL, 1379337842, 1379337842, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cfe5f1273502565ff131687afbe5', NULL, NULL, NULL, '/images/messages/646/347.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/646/347.600x600.jpg', 646, NULL, NULL, NULL, NULL, NULL),
(348, NULL, NULL, 13, '', NULL, NULL, 1379340114, 1379340114, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'velik', NULL, NULL, NULL, '/images/car/64/348.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/car/64/348.600x600.jpg', NULL, NULL, 'car', 64, NULL, NULL),
(349, NULL, NULL, 14, '', NULL, NULL, 1379401459, 1379401459, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0089', NULL, NULL, NULL, '/images/messages/673/349.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/673/349.600x600.jpg', 673, NULL, NULL, NULL, NULL, NULL),
(350, NULL, NULL, 14, '', NULL, NULL, 1379401460, 1379401460, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0095', NULL, NULL, NULL, '/images/messages/673/350.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/673/350.600x600.jpg', 673, NULL, NULL, NULL, NULL, NULL),
(351, NULL, NULL, 14, '', NULL, NULL, 1379401460, 1379401460, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0094', NULL, NULL, NULL, '/images/messages/673/351.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/673/351.600x600.jpg', 673, NULL, NULL, NULL, NULL, NULL),
(352, NULL, NULL, 14, '', NULL, NULL, 1379401461, 1379401461, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'IMG_0091', NULL, NULL, NULL, '/images/messages/673/352.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/673/352.600x600.jpg', 673, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `media_items` (`id`, `activity_id`, `album_id`, `owner_id`, `mime_type`, `file_size`, `duration`, `created`, `last_updated`, `language`, `address_id`, `num_comments`, `num_views`, `num_votes`, `rating`, `start_time`, `title`, `description`, `tagged_people`, `tags`, `thumbnail_url`, `type`, `url`, `app_id`, `thumbnail_url220`, `thumbnail_url600`, `message_id`, `comment_id`, `object_name`, `object_id`, `width`, `height`) VALUES
(353, NULL, NULL, 14, '', NULL, NULL, 1379478511, 1379478511, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202740', NULL, NULL, NULL, '/images/messages/678/353.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/353.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(354, NULL, NULL, 14, '', NULL, NULL, 1379478512, 1379478512, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202746', NULL, NULL, NULL, '/images/messages/678/354.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/354.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(355, NULL, NULL, 14, '', NULL, NULL, 1379478512, 1379478512, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202742', NULL, NULL, NULL, '/images/messages/678/355.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/355.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(356, NULL, NULL, 14, '', NULL, NULL, 1379478512, 1379478512, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202750', NULL, NULL, NULL, '/images/messages/678/356.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/356.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(357, NULL, NULL, 14, '', NULL, NULL, 1379478512, 1379478512, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202748', NULL, NULL, NULL, '/images/messages/678/357.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/357.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(358, NULL, NULL, 14, '', NULL, NULL, 1379478513, 1379478513, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202744', NULL, NULL, NULL, '/images/messages/678/358.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/358.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(359, NULL, NULL, 14, '', NULL, NULL, 1379478514, 1379478514, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202754', NULL, NULL, NULL, '/images/messages/678/359.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/359.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(360, NULL, NULL, 14, '', NULL, NULL, 1379478514, 1379478514, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202756', NULL, NULL, NULL, '/images/messages/678/360.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/360.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(361, NULL, NULL, 14, '', NULL, NULL, 1379478514, 1379478514, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202758', NULL, NULL, NULL, '/images/messages/678/361.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/361.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(362, NULL, NULL, 14, '', NULL, NULL, 1379478516, 1379478516, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202752', NULL, NULL, NULL, '/images/messages/678/362.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/678/362.600x600.jpg', 678, NULL, NULL, NULL, NULL, NULL),
(363, NULL, NULL, 14, '', NULL, NULL, 1379478636, 1379478636, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202764', NULL, NULL, NULL, '/images/comment/189/363.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/363.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(364, NULL, NULL, 14, '', NULL, NULL, 1379478636, 1379478636, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202766', NULL, NULL, NULL, '/images/comment/189/364.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/364.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(365, NULL, NULL, 14, '', NULL, NULL, 1379478637, 1379478637, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202760', NULL, NULL, NULL, '/images/comment/189/365.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/365.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(366, NULL, NULL, 14, '', NULL, NULL, 1379478637, 1379478637, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202768', NULL, NULL, NULL, '/images/comment/189/366.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/366.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(367, NULL, NULL, 14, '', NULL, NULL, 1379478637, 1379478637, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202770', NULL, NULL, NULL, '/images/comment/189/367.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/367.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(368, NULL, NULL, 14, '', NULL, NULL, 1379478638, 1379478638, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202762', NULL, NULL, NULL, '/images/comment/189/368.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/368.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(369, NULL, NULL, 14, '', NULL, NULL, 1379478638, 1379478638, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202774', NULL, NULL, NULL, '/images/comment/189/369.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/369.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(370, NULL, NULL, 14, '', NULL, NULL, 1379478638, 1379478638, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202772', NULL, NULL, NULL, '/images/comment/189/370.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/189/370.600x600.jpg', NULL, 189, 'messages', 678, NULL, NULL),
(371, NULL, NULL, 14, '', NULL, NULL, 1379478987, 1379478987, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202764', NULL, NULL, NULL, '/images/messages/679/371.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/679/371.600x600.jpg', 679, NULL, NULL, NULL, NULL, NULL),
(372, NULL, NULL, 14, '', NULL, NULL, 1379478987, 1379478987, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202758', NULL, NULL, NULL, '/images/messages/679/372.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/679/372.600x600.jpg', 679, NULL, NULL, NULL, NULL, NULL),
(373, NULL, NULL, 14, '', NULL, NULL, 1379478988, 1379478988, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202766', NULL, NULL, NULL, '/images/messages/679/373.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/679/373.600x600.jpg', 679, NULL, NULL, NULL, NULL, NULL),
(374, NULL, NULL, 14, '', NULL, NULL, 1379478988, 1379478988, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202774', NULL, NULL, NULL, '/images/messages/679/374.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/679/374.600x600.jpg', 679, NULL, NULL, NULL, NULL, NULL),
(375, NULL, NULL, 14, '', NULL, NULL, 1379478988, 1379478988, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1202772', NULL, NULL, NULL, '/images/messages/679/375.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/679/375.600x600.jpg', 679, NULL, NULL, NULL, NULL, NULL),
(376, NULL, NULL, 14, '', NULL, NULL, 1379595643, 1379595643, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/685/376.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/685/376.600x600.jpg', 685, NULL, NULL, NULL, NULL, NULL),
(377, NULL, NULL, 14, '', NULL, NULL, 1379595675, 1379595675, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/685/377.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/685/377.600x600.jpg', 685, NULL, NULL, NULL, NULL, NULL),
(378, NULL, NULL, 14, '', NULL, NULL, 1379595858, 1379595858, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/685/378.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/685/378.600x600.jpg', 685, NULL, NULL, NULL, NULL, NULL),
(379, NULL, NULL, 14, '', NULL, NULL, 1379595899, 1379595899, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, NULL, 'IMAGE', '', 0, NULL, NULL, 685, NULL, NULL, NULL, NULL, NULL),
(380, NULL, NULL, 14, '', NULL, NULL, 1379595921, 1379595921, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, NULL, 'IMAGE', '', 0, NULL, NULL, 685, NULL, NULL, NULL, NULL, NULL),
(381, NULL, NULL, 14, '', NULL, NULL, 1379596038, 1379596038, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/685/381.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/685/381.600x600.jpg', 685, NULL, NULL, NULL, NULL, NULL),
(382, NULL, NULL, 14, '', NULL, NULL, 1379596078, 1379596078, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/685/382.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/685/382.600x600.jpg', 685, NULL, NULL, NULL, NULL, NULL),
(383, NULL, NULL, 13, '', NULL, NULL, 1379596837, 1379596837, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/686/383.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/686/383.600x600.jpg', 686, NULL, NULL, NULL, NULL, NULL),
(384, NULL, NULL, 14, '', NULL, NULL, 1379597002, 1379597002, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/689/384.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/689/384.600x600.jpg', 689, NULL, NULL, NULL, NULL, NULL),
(385, NULL, NULL, 13, '', NULL, NULL, 1379610915, 1379610915, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/696/385.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/696/385.600x600.jpg', 696, NULL, NULL, NULL, NULL, NULL),
(388, NULL, NULL, 14, '', NULL, NULL, 1379926537, 1379926537, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/702/388.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/702/388.600x600.jpg', 702, NULL, NULL, NULL, NULL, NULL),
(387, NULL, NULL, 13, '', NULL, NULL, 1379611923, 1379611923, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/697/387.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/697/387.600x600.jpg', 697, NULL, NULL, NULL, NULL, NULL),
(390, NULL, NULL, 14, '', NULL, NULL, 1380002784, 1380002784, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/708/390.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/708/390.600x600.jpg', 708, NULL, NULL, NULL, NULL, NULL),
(391, NULL, NULL, 14, '', NULL, NULL, 1380175183, 1380175183, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/391.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/391.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(392, NULL, NULL, 14, '', NULL, NULL, 1380175190, 1380175190, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/392.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/392.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(393, NULL, NULL, 14, '', NULL, NULL, 1380175191, 1380175191, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/393.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/393.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(394, NULL, NULL, 14, '', NULL, NULL, 1380175192, 1380175192, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/394.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/394.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(395, NULL, NULL, 14, '', NULL, NULL, 1380175193, 1380175193, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/395.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/395.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(396, NULL, NULL, 14, '', NULL, NULL, 1380175195, 1380175195, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/396.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/396.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(397, NULL, NULL, 14, '', NULL, NULL, 1380175195, 1380175195, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/397.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/397.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(398, NULL, NULL, 14, '', NULL, NULL, 1380175198, 1380175198, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/398.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/398.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(399, NULL, NULL, 14, '', NULL, NULL, 1380175200, 1380175200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'image', NULL, NULL, NULL, '/images/messages/712/399.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/712/399.600x600.jpg', 712, NULL, NULL, NULL, NULL, NULL),
(400, NULL, NULL, 14, '', NULL, NULL, 1380179335, 1380179335, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'photo (6)', NULL, NULL, NULL, '/images/messages/713/400.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/713/400.600x600.jpg', 713, NULL, NULL, NULL, NULL, NULL),
(401, NULL, NULL, 14, '', NULL, NULL, 1380179335, 1380179335, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'photo', NULL, NULL, NULL, '/images/messages/713/401.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/713/401.600x600.jpg', 713, NULL, NULL, NULL, NULL, NULL),
(402, NULL, 8, 12, '', NULL, NULL, 1380265471, 1380265471, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/albums/8/402.220x220.png', 'IMAGE', '1', 0, NULL, '/images/albums/8/402.600x600.png', NULL, NULL, NULL, NULL, NULL, NULL),
(403, NULL, 8, 12, '', NULL, NULL, 1380265479, 1380265479, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/albums/8/403.220x220.png', 'IMAGE', '1', 0, NULL, '/images/albums/8/403.600x600.png', NULL, NULL, NULL, NULL, 460, 494),
(404, NULL, NULL, 12, '', NULL, NULL, 1380265913, 1380265913, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/757/404.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/757/404.600x600.png', 757, NULL, NULL, NULL, 460, 494),
(405, NULL, NULL, 12, '', NULL, NULL, 1380265913, 1380265913, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/messages/757/405.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/757/405.600x600.jpg', 757, NULL, NULL, NULL, 1280, 852),
(406, NULL, NULL, 12, '', NULL, NULL, 1380265915, 1380265915, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/757/406.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/757/406.600x600.jpg', 757, NULL, NULL, NULL, 3264, 4928),
(407, NULL, NULL, 12, '', NULL, NULL, 1380265923, 1380265923, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/messages/757/407.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/757/407.600x600.jpeg', 757, NULL, NULL, NULL, 2093, 1570),
(408, NULL, NULL, 12, '', NULL, NULL, 1380274845, 1380274845, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/759/408.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/759/408.600x600.png', 759, NULL, NULL, NULL, 460, 494),
(409, NULL, NULL, 12, '', NULL, NULL, 1380274845, 1380274845, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/759/409.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/759/409.600x600.jpg', 759, NULL, NULL, NULL, 2048, 1536),
(410, NULL, NULL, 12, '', NULL, NULL, 1380274848, 1380274848, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/messages/759/410.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/759/410.600x600.jpg', 759, NULL, NULL, NULL, 1280, 852),
(411, NULL, NULL, 12, '', NULL, NULL, 1380274849, 1380274849, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/messages/759/411.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/759/411.600x600.jpeg', 759, NULL, NULL, NULL, 2093, 1570),
(412, NULL, NULL, 12, '', NULL, NULL, 1380274851, 1380274851, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/messages/759/412.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/759/412.600x600.jpeg', 759, NULL, NULL, NULL, 2204, 1653),
(413, NULL, NULL, 12, '', NULL, NULL, 1380274854, 1380274854, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/759/413.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/759/413.600x600.jpg', 759, NULL, NULL, NULL, 3264, 4928),
(414, NULL, NULL, 12, '', NULL, NULL, 1380274862, 1380274862, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/messages/759/414.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/759/414.600x600.jpeg', 759, NULL, NULL, NULL, 2093, 1570),
(415, NULL, NULL, 12, '', NULL, NULL, 1380280277, 1380280277, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/messages/759/415.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/759/415.600x600.jpg', 759, NULL, NULL, NULL, 1280, 852),
(416, NULL, NULL, 12, '', NULL, NULL, 1380280279, 1380280279, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/759/416.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/759/416.600x600.jpg', 759, NULL, NULL, NULL, 2048, 1536),
(417, NULL, NULL, 12, '', NULL, NULL, 1380280281, 1380280281, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/759/417.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/759/417.600x600.png', 759, NULL, NULL, NULL, 460, 494),
(418, NULL, NULL, 12, '', NULL, NULL, 1380280281, 1380280281, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/759/418.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/759/418.600x600.jpg', 759, NULL, NULL, NULL, 3264, 4928),
(419, NULL, NULL, 12, '', NULL, NULL, 1380280288, 1380280288, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/messages/759/419.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/759/419.600x600.jpeg', 759, NULL, NULL, NULL, 2204, 1653),
(420, NULL, NULL, 12, '', NULL, NULL, 1380280291, 1380280291, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/messages/759/420.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/759/420.600x600.jpeg', 759, NULL, NULL, NULL, 2093, 1570),
(421, NULL, NULL, 12, '', NULL, NULL, 1380280293, 1380280293, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/messages/759/421.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/759/421.600x600.jpeg', 759, NULL, NULL, NULL, 2093, 1570),
(422, NULL, NULL, 12, '', NULL, NULL, 1380280462, 1380280462, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/761/422.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/761/422.600x600.png', 761, NULL, NULL, NULL, 460, 494),
(423, NULL, NULL, 12, '', NULL, NULL, 1380280633, 1380280633, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/762/423.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/762/423.600x600.png', 762, NULL, NULL, NULL, 460, 494),
(424, NULL, NULL, 12, '', NULL, NULL, 1380280634, 1380280634, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/messages/762/424.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/762/424.600x600.jpg', 762, NULL, NULL, NULL, 1280, 852),
(425, NULL, NULL, 12, '', NULL, NULL, 1380280635, 1380280635, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/762/425.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/762/425.600x600.jpg', 762, NULL, NULL, NULL, 2048, 1536),
(426, NULL, NULL, 12, '', NULL, NULL, 1380280637, 1380280637, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/messages/762/426.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/762/426.600x600.jpeg', 762, NULL, NULL, NULL, 2204, 1653),
(427, NULL, NULL, 12, '', NULL, NULL, 1380280639, 1380280639, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/messages/762/427.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/762/427.600x600.jpeg', 762, NULL, NULL, NULL, 2093, 1570),
(428, NULL, NULL, 12, '', NULL, NULL, 1380280642, 1380280642, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/762/428.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/762/428.600x600.jpg', 762, NULL, NULL, NULL, 3264, 4928),
(429, NULL, NULL, 12, '', NULL, NULL, 1380280649, 1380280649, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/messages/762/429.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/762/429.600x600.jpeg', 762, NULL, NULL, NULL, 2093, 1570),
(430, NULL, NULL, 12, '', NULL, NULL, 1380281075, 1380281075, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/comment/206/430.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/206/430.600x600.jpg', NULL, 206, 'messages', 761, 1280, 852),
(431, NULL, NULL, 12, '', NULL, NULL, 1380281076, 1380281076, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/comment/206/431.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/comment/206/431.600x600.jpeg', NULL, 206, 'messages', 761, 2204, 1653),
(432, NULL, NULL, 12, '', NULL, NULL, 1380281079, 1380281079, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/comment/206/432.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/206/432.600x600.jpg', NULL, 206, 'messages', 761, 2048, 1536),
(433, NULL, NULL, 12, '', NULL, NULL, 1380281081, 1380281081, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/comment/206/433.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/comment/206/433.600x600.jpeg', NULL, 206, 'messages', 761, 2093, 1570),
(434, NULL, NULL, 12, '', NULL, NULL, 1380281084, 1380281084, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/comment/206/434.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/206/434.600x600.jpg', NULL, 206, 'messages', 761, 3264, 4928),
(435, NULL, NULL, 12, '', NULL, NULL, 1380281091, 1380281091, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/comment/206/435.220x220.png', 'IMAGE', '1', 0, NULL, '/images/comment/206/435.600x600.png', NULL, 206, 'messages', 761, 460, 494),
(436, NULL, NULL, 12, '', NULL, NULL, 1380281091, 1380281091, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/comment/206/436.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/comment/206/436.600x600.jpeg', NULL, 206, 'messages', 761, 2093, 1570),
(437, NULL, NULL, 12, '', NULL, NULL, 1380529982, 1380529982, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/791/437.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/791/437.600x600.png', 791, NULL, NULL, NULL, 460, 494),
(438, NULL, NULL, 12, '', NULL, NULL, 1380529984, 1380529984, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/791/438.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/791/438.600x600.jpg', 791, NULL, NULL, NULL, 3264, 4928),
(439, NULL, NULL, 12, '', NULL, NULL, 1380530491, 1380530491, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/798/439.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/798/439.600x600.png', 798, NULL, 'messages', NULL, 460, 494),
(440, NULL, NULL, 12, '', NULL, NULL, 1380530492, 1380530492, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/798/440.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/798/440.600x600.jpg', 798, NULL, 'messages', NULL, 2048, 1536),
(441, NULL, NULL, 12, '', NULL, NULL, 1380530543, 1380530543, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/799/441.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/799/441.600x600.png', 799, NULL, 'messages', NULL, 460, 494),
(442, NULL, NULL, 12, '', NULL, NULL, 1380530543, 1380530543, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/messages/799/442.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/799/442.600x600.jpg', 799, NULL, 'messages', NULL, 1280, 852),
(443, NULL, NULL, 12, '', NULL, NULL, 1380530544, 1380530544, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/799/443.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/799/443.600x600.jpg', 799, NULL, 'messages', NULL, 2048, 1536),
(444, NULL, NULL, 12, '', NULL, NULL, 1380530546, 1380530546, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/messages/799/444.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/799/444.600x600.jpeg', 799, NULL, 'messages', NULL, 2093, 1570),
(445, NULL, NULL, 12, '', NULL, NULL, 1380530549, 1380530549, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/messages/799/445.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/799/445.600x600.jpeg', 799, NULL, 'messages', NULL, 2204, 1653),
(446, NULL, NULL, 12, '', NULL, NULL, 1380530551, 1380530551, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/799/446.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/799/446.600x600.jpg', 799, NULL, 'messages', NULL, 3264, 4928),
(447, NULL, NULL, 12, '', NULL, NULL, 1380530559, 1380530559, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/messages/799/447.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/799/447.600x600.jpeg', 799, NULL, 'messages', NULL, 2093, 1570),
(448, NULL, NULL, 12, '', NULL, NULL, 1380531112, 1380531112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/806/448.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/806/448.600x600.png', 806, NULL, 'messages', NULL, 460, 494),
(449, NULL, NULL, 12, '', NULL, NULL, 1380531112, 1380531112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/806/449.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/806/449.600x600.jpg', 806, NULL, 'messages', NULL, 2048, 1536),
(450, NULL, NULL, 12, '', NULL, NULL, 1380531115, 1380531115, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/806/450.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/806/450.600x600.jpg', 806, NULL, 'messages', NULL, 3264, 4928),
(451, NULL, NULL, 12, '', NULL, NULL, 1380531142, 1380531142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/messages/807/451.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/807/451.600x600.jpg', 807, NULL, 'messages', NULL, 1280, 852),
(452, NULL, NULL, 12, '', NULL, NULL, 1380531143, 1380531143, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/807/452.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/807/452.600x600.jpg', 807, NULL, 'messages', NULL, 2048, 1536),
(453, NULL, NULL, 12, '', NULL, NULL, 1380531146, 1380531146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/807/453.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/807/453.600x600.png', 807, NULL, 'messages', NULL, 460, 494),
(454, NULL, NULL, 12, '', NULL, NULL, 1380531146, 1380531146, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/messages/807/454.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/807/454.600x600.jpeg', 807, NULL, 'messages', NULL, 2093, 1570),
(455, NULL, NULL, 12, '', NULL, NULL, 1380531148, 1380531148, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/messages/807/455.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/807/455.600x600.jpeg', 807, NULL, 'messages', NULL, 2204, 1653),
(456, NULL, NULL, 12, '', NULL, NULL, 1380531151, 1380531151, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/807/456.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/807/456.600x600.jpg', 807, NULL, 'messages', NULL, 3264, 4928),
(457, NULL, NULL, 12, '', NULL, NULL, 1380531158, 1380531158, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/messages/807/457.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/messages/807/457.600x600.jpeg', 807, NULL, 'messages', NULL, 2093, 1570),
(458, NULL, NULL, 12, '', NULL, NULL, 1380531767, 1380531767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/comment/208/458.220x220.png', 'IMAGE', '1', 0, NULL, '/images/comment/208/458.600x600.png', NULL, 208, 'messages', 807, 460, 494),
(459, NULL, NULL, 12, '', NULL, NULL, 1380531768, 1380531768, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/comment/208/459.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/208/459.600x600.jpg', NULL, 208, 'messages', 807, 2048, 1536),
(460, NULL, NULL, 12, '', NULL, NULL, 1380531770, 1380531770, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'nissan_x_trail_geneva_9', NULL, NULL, NULL, '/images/comment/208/460.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/208/460.600x600.jpg', NULL, 208, 'messages', 807, 1280, 852),
(461, NULL, NULL, 12, '', NULL, NULL, 1380531771, 1380531771, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail', NULL, NULL, NULL, '/images/comment/208/461.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/comment/208/461.600x600.jpeg', NULL, 208, 'messages', 807, 2093, 1570),
(462, NULL, NULL, 12, '', NULL, NULL, 1380531773, 1380531773, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail2', NULL, NULL, NULL, '/images/comment/208/462.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/comment/208/462.600x600.jpeg', NULL, 208, 'messages', 807, 2204, 1653),
(463, NULL, NULL, 12, '', NULL, NULL, 1380531776, 1380531776, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/comment/208/463.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/comment/208/463.600x600.jpg', NULL, 208, 'messages', 807, 3264, 4928),
(464, NULL, NULL, 12, '', NULL, NULL, 1380531783, 1380531783, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'xtrail3', NULL, NULL, NULL, '/images/comment/208/464.220x220.jpeg', 'IMAGE', '1', 0, NULL, '/images/comment/208/464.600x600.jpeg', NULL, 208, 'messages', 807, 2093, 1570),
(465, NULL, NULL, 12, '', NULL, NULL, 1382501039, 1382501039, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0_oA30', NULL, NULL, NULL, '', 'FILE', '/files/messages/844/0_oA30.png', 0, NULL, '', 844, NULL, 'messages', NULL, 520, 366),
(466, NULL, NULL, 12, '', NULL, NULL, 1382501049, 1382501049, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0_oA30', NULL, NULL, NULL, '/images/messages/844/466.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/844/466.600x600.png', 844, NULL, 'messages', NULL, 520, 366),
(467, NULL, NULL, 12, '', NULL, NULL, 1382501050, 1382501050, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0DF3tO', NULL, NULL, NULL, '/images/messages/844/467.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/844/467.600x600.png', 844, NULL, 'messages', NULL, 520, 353),
(468, NULL, NULL, 12, '', NULL, NULL, 1382513975, 1382513975, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0_oA30', NULL, NULL, NULL, '/images/messages/845/468.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/845/468.600x600.png', 845, NULL, 'messages', NULL, 520, 366),
(469, NULL, NULL, 12, '', NULL, NULL, 1382513976, 1382513976, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0DF3tO', NULL, NULL, NULL, '/images/messages/845/469.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/845/469.600x600.png', 845, NULL, 'messages', NULL, 520, 353),
(470, NULL, NULL, 12, '', NULL, NULL, 1382514274, 1382514274, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0Nv1h8', NULL, NULL, NULL, '/images/messages/845/470.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/845/470.600x600.png', 845, NULL, 'messages', NULL, 520, 353),
(471, NULL, NULL, 12, '', NULL, NULL, 1386874323, 1386874323, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'avaadmin', NULL, NULL, NULL, '/images/comment/212/471.220x220.png', 'IMAGE', '1', 0, NULL, '/images/comment/212/471.600x600.png', NULL, 212, 'messages', 871, 200, 486),
(472, NULL, NULL, 12, '', NULL, NULL, 1386875070, 1386875070, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'shop3', NULL, NULL, NULL, '/images/messages/990/472.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/990/472.600x600.jpg', 990, NULL, 'messages', NULL, 972, 582),
(473, NULL, NULL, 12, '', NULL, NULL, 1386875092, 1386875092, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'shop3', NULL, NULL, NULL, '/images/messages/991/473.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/991/473.600x600.jpg', 991, NULL, 'messages', NULL, 972, 582),
(474, NULL, NULL, 12, '', NULL, NULL, 1387400163, 1387400163, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2915', NULL, NULL, NULL, '/images/messages/1000/474.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1000/474.600x600.jpg', 1000, NULL, 'messages', NULL, 600, 669),
(475, NULL, NULL, 12, '', NULL, NULL, 1387400394, 1387400394, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1007/475.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1007/475.600x600.jpg', 1007, NULL, 'messages', NULL, 1210, 804),
(476, NULL, NULL, 12, '', NULL, NULL, 1387400476, 1387400476, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1013/476.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1013/476.600x600.jpg', 1013, NULL, 'messages', NULL, 1210, 804),
(477, NULL, NULL, 12, '', NULL, NULL, 1387400697, 1387400697, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1016/477.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1016/477.600x600.jpg', 1016, NULL, 'messages', NULL, 1210, 804),
(478, NULL, NULL, 12, '', NULL, NULL, 1387400748, 1387400748, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1019/478.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1019/478.600x600.jpg', 1019, NULL, 'messages', NULL, 1210, 804),
(479, NULL, NULL, 12, '', NULL, NULL, 1387401299, 1387401299, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1023/479.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1023/479.600x600.jpg', 1023, NULL, 'messages', NULL, 1210, 804),
(480, NULL, NULL, 12, '', NULL, NULL, 1387401363, 1387401363, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1027/480.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1027/480.600x600.jpg', 1027, NULL, 'messages', NULL, 1210, 804),
(481, NULL, NULL, 12, '', NULL, NULL, 1387401488, 1387401488, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1033/481.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1033/481.600x600.jpg', 1033, NULL, 'messages', NULL, 1210, 804),
(482, NULL, NULL, 12, '', NULL, NULL, 1387401586, 1387401586, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1039/482.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1039/482.600x600.jpg', 1039, NULL, 'messages', NULL, 1210, 804),
(483, NULL, NULL, 12, '', NULL, NULL, 1387401634, 1387401634, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1042/483.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1042/483.600x600.jpg', 1042, NULL, 'messages', NULL, 1210, 804),
(484, NULL, NULL, 12, '', NULL, NULL, 1387401634, 1387401634, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1042/483.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1042/483.600x600.jpg', 1043, NULL, 'messages', NULL, 1210, 804),
(485, NULL, NULL, 12, '', NULL, NULL, 1387401634, 1387401634, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1042/483.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1042/483.600x600.jpg', 1044, NULL, 'messages', NULL, 1210, 804),
(486, NULL, NULL, 12, '', NULL, NULL, 1387401634, 1387401634, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0001', NULL, NULL, NULL, '/images/messages/1042/483.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1042/483.600x600.jpg', 1045, NULL, 'messages', NULL, 1210, 804),
(487, NULL, 14, 30, '', NULL, NULL, 1396037307, 1396037307, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/albums/14/487.220x220.png', 'IMAGE', '1', 0, NULL, '/images/albums/14/487.600x600.png', NULL, NULL, 'albums', NULL, 460, 494),
(488, NULL, 14, 30, '', NULL, NULL, 1396037313, 1396037313, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/albums/14/488.220x220.png', 'IMAGE', '1', 0, NULL, '/images/albums/14/488.600x600.png', NULL, NULL, 'albums', NULL, 460, 494),
(489, NULL, 14, 30, '', NULL, NULL, 1396037313, 1396037313, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/albums/14/489.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/14/489.600x600.jpg', NULL, NULL, 'albums', NULL, 2048, 1536),
(490, NULL, 14, 30, '', NULL, NULL, 1396037316, 1396037316, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/albums/14/490.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/albums/14/490.600x600.jpg', NULL, NULL, 'albums', NULL, 3264, 4928),
(491, NULL, NULL, 30, '', NULL, NULL, 1396037371, 1396037371, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '', 'FILE', '/files/messages/1056/angry1.png', 0, NULL, '', 1056, NULL, 'messages', NULL, 460, 494),
(492, NULL, NULL, 30, '', NULL, NULL, 1396037371, 1396037371, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '', 'FILE', '/files/messages/1056/autowp.ru_nissan_x-trail_ii_32.jpg', 0, NULL, '', 1056, NULL, 'messages', NULL, 2048, 1536),
(493, NULL, NULL, 30, '', NULL, NULL, 1396037371, 1396037371, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '', 'FILE', '/files/messages/1056/DSC_0008.jpg', 0, NULL, '', 1056, NULL, 'messages', NULL, 3264, 4928),
(494, NULL, NULL, 30, '', NULL, NULL, 1396037389, 1396037389, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'autowp.ru_nissan_x-trail_ii_32', NULL, NULL, NULL, '/images/messages/1057/494.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1057/494.600x600.jpg', 1057, NULL, 'messages', NULL, 2048, 1536),
(495, NULL, NULL, 30, '', NULL, NULL, 1396037391, 1396037391, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'angry1', NULL, NULL, NULL, '/images/messages/1057/495.220x220.png', 'IMAGE', '1', 0, NULL, '/images/messages/1057/495.600x600.png', 1057, NULL, 'messages', NULL, 460, 494),
(496, NULL, NULL, 30, '', NULL, NULL, 1396037391, 1396037391, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'DSC_0008', NULL, NULL, NULL, '/images/messages/1057/496.220x220.jpg', 'IMAGE', '1', 0, NULL, '/images/messages/1057/496.600x600.jpg', 1057, NULL, 'messages', NULL, 3264, 4928);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `title` char(255) NOT NULL,
  `body` mediumtext,
  `app_id` int(11) NOT NULL,
  `body_id` char(32) DEFAULT NULL,
  `title_id` char(32) DEFAULT NULL,
  `in_reply_to` int(11) DEFAULT NULL,
  `replies` mediumtext,
  `status` enum('new','read','deleted','unread') DEFAULT 'new',
  `type` enum('email','notification','private_message','public_message','news') DEFAULT 'private_message',
  `recipients` mediumtext,
  `collection_ids` mediumtext,
  `urls` mediumtext,
  `updated` int(11) NOT NULL,
  `to_deleted` enum('yes','no') DEFAULT 'no',
  `from_deleted` enum('yes','no') DEFAULT 'no',
  `created` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `likes_num` int(11) DEFAULT '0',
  `shared_num` int(11) DEFAULT '0',
  `anons` text,
  `comment_num` int(11) DEFAULT '0',
  KEY `id` (`id`),
  KEY `to` (`to`,`created`),
  KEY `from` (`from`,`created`),
  KEY `shop_id` (`shop_id`),
  KEY `likes_num` (`likes_num`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1067 ;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `from`, `to`, `title`, `body`, `app_id`, `body_id`, `title_id`, `in_reply_to`, `replies`, `status`, `type`, `recipients`, `collection_ids`, `urls`, `updated`, `to_deleted`, `from_deleted`, `created`, `shop_id`, `likes_num`, `shared_num`, `anons`, `comment_num`) VALUES
(751, 25, 12, '', '<p>dfgdfgdfg</p>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228589, NULL, 0, 0, NULL, 0),
(750, 12, 25, '', '<p>2222</p>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228505, NULL, 0, 0, NULL, 0),
(749, 12, 25, '', '<p>123123 123 123</p>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228491, NULL, 0, 0, NULL, 0),
(748, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(746, 12, 3, '', '123123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228355, NULL, 0, 0, NULL, 0),
(747, 12, 25, '', '1111111111111111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228368, NULL, 0, 0, NULL, 0),
(126, 14, 13, 'Tudupidu pu', 'Tudupidu pu', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1363253072, 'no', 'no', 1363253072, NULL, 0, 0, NULL, 0),
(127, 14, 0, '', 'Замерзшее озеро, 15 экипажей, много снега и адреналина!\r\n\r\nВсё что требуется для того чтоб спустить пар!', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1363322175, 'no', 'no', 1363322175, NULL, 0, 0, 'РАЛЛИ ДЛЯ ЛЮБИТЕЛЕЙ', 4),
(128, 12, 0, '', 'qweqweqweqwe', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1363836243, 'no', 'no', 1363836243, NULL, 0, 0, 'qweqwe', 0),
(129, 12, 0, '', 'текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст текст', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364007827, 'no', 'no', 1364007827, NULL, 0, 0, 'картинки разного размера', 0),
(130, 12, 0, '', '', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364007876, 'no', 'no', 1364007876, NULL, 0, 0, 'еще', 1),
(131, 14, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(132, 14, 0, 'Китайский автопром догоняет', 'Все более широкий вид техники, котурую китайцы научились делать! И цена в разы ниже чем предлагают другие европейские компании!\r\n Скоро что то вообще сами придумают, какой нибудь новый вид техники!', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364053479, 'no', 'no', 1364053479, NULL, 0, 0, '', 3),
(133, 14, 12, 'Неполучилось удалить свой коментарий к новости', 'Неполучилось удалить свой коментарий к новости и фото в нем! Вот не помню - можно ли это делать по задумке или нельзя', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1364054082, 'no', 'no', 1364054082, NULL, 0, 0, NULL, 0),
(134, 13, 0, '', '', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364056352, 'no', 'yes', 1364056352, NULL, 0, 0, '', 2),
(135, 13, 0, 'Тайга 2013', 'Кантеги́р — сибирская река в Туве и Хакасии, левый приток Енисея. Впадает в Саяно-Шушенское водохранилище.', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364056774, 'no', 'no', 1364056774, NULL, 2, 2, 'Долина Кантегира на всем протяжении стиснута горами до 100—200 м', 2),
(136, 13, 14, 'новость не удаляется.', 'новость не удаляется. Написано удалено а потом обновляешь а она опять ...', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1364057348, 'no', 'no', 1364057348, NULL, 0, 0, NULL, 0),
(137, 13, 14, 'фото', 'фото в новости открывает в этом же окне. Лучше бы в новом открывал....\nфото в фотоальбоме когда нажимаешь он увеличивает но срезает... полностью не показывает. \nи не масштабирует. (если экран шире хочется чтобы не по три фотки в ряд а в зависимости от экрана делал больше по 5-6 в ряд', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1364057870, 'no', 'no', 1364057870, NULL, 0, 0, NULL, 0),
(138, 14, 0, 'Разведка села Платинка и окресностей', 'Дорога туда хорошая только до села Весёловка, после до Платинки 15 км. но таких плохих что максимум 30 КМЧ, и еще не разъехаться двум автомобилям! Точнее без лопаты не разъехаться!\r\n По дороге всё изрезанно снегоходами, видимо мы не первые! Вдоль реки АЙ 2 года назад горел лес - поетому пеёзажи не очень!\r\n Снега в лесу выше калена, но проехать можно, пройти не реально.\r\n В следующий раз поднимемся выше еще на 15 км, должно быть красиво так как пожар туда не дошел! И как сказали местные много тишей где рыба стоит!', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364127846, 'no', 'yes', 1364127846, NULL, 0, 1, '', 3),
(139, 14, 0, 'Разведка села Платинка', 'Дорога туда хорошая только до села Весёловка, после до Платинки 15 км. но таких плохих что максимум 30 КМЧ, и еще не разъехаться двум автомобилям! Точнее без лопаты не разъехаться! По дороге всё изрезанно снегоходами, видимо мы не первые! Вдоль реки АЙ 2 года назад горел лес - поетому пеёзажи не очень! Снега в лесу выше калена, но проехать можно, пройти не реально. В следующий раз поднимемся выше еще на 15 км, должно быть красиво так как пожар туда не дошел! И как сказали местные много тишей где рыба стоит!', 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 1364133501, 'no', 'yes', 1364133501, NULL, 0, 0, '', 0),
(140, 14, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(141, 14, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(142, 18, 0, '', '', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1364459838, 'no', 'no', 1364459838, NULL, 0, 1, '', 0),
(143, 12, 14, '', 'test', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(144, 12, 14, '', 'test + img', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(145, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(146, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(147, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(148, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(149, 12, 14, '', 'test data fix', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(150, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(151, 12, 14, '', 'test data fix\r\n2', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(152, 12, 14, '', 'test3', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1364754908, NULL, 0, 0, NULL, 0),
(153, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(154, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(155, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(156, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(157, 14, 13, '', 'И поэтому всё так ПРОИЗОШЛО!', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1364789262, NULL, 0, 0, NULL, 0),
(158, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(159, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(160, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(161, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(162, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(163, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(164, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(165, 12, 14, '', '123123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1364803483, NULL, 0, 0, NULL, 0),
(166, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(167, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(168, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(169, 14, 13, '', 'Просто пробное сообщение', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1364881287, NULL, 0, 0, NULL, 0),
(170, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(171, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(172, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(173, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(174, 20, 0, '', 'Think up the dreams! ;)', 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 1365083324, 'no', 'yes', 1365083324, NULL, 0, 0, '', 0),
(175, 20, 0, '', 'Think up the dreams ;)', 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 1365083380, 'no', 'yes', 1365083380, NULL, 0, 0, '', 0),
(176, 14, 0, 'Еще Кантегир', 'Все равно есть ощущение что это было не с нами!\r\nКак то странно!\r\nВроде мы а вроде не мы!\r\n\r\nТак що ты это _ заходи если шо!', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1365170455, 'no', 'no', 1365170455, NULL, 0, 0, '', 0),
(177, 14, 13, '', 'Это пробное сообщение опять!', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1365235119, NULL, 0, 0, NULL, 0),
(178, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(179, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(180, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(181, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(182, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(183, 12, 0, 'тест', 'тест', 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 1365236169, 'no', 'yes', 1365236169, NULL, 0, 0, 'тест', 0),
(184, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(185, 12, 14, '', '123123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1365254424, NULL, 0, 0, NULL, 0),
(186, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(187, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(188, 12, 14, '', '234234', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1365254434, NULL, 0, 0, NULL, 0),
(189, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(190, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(191, 12, 14, 'werwer', 'werwer', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1365254461, 'no', 'no', 1365254461, NULL, 0, 0, NULL, 0),
(192, 12, 14, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1365254496, NULL, 0, 0, NULL, 0),
(193, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(194, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(195, 14, 13, '', 'Шоколадные батончики', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1365416208, NULL, 0, 0, NULL, 0),
(196, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(197, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(198, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(199, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(200, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(201, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(202, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(203, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(204, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(205, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(206, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(207, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(208, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(209, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(210, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(211, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(212, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(213, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(214, 14, 13, '', 'Как тебе домик из четырех контейнеров!\r\nЗа неделю такой собрать вообще красота!', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1366350082, NULL, 0, 0, NULL, 0),
(215, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(216, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(217, 14, 13, '', 'Проверяю как отображается фото разного размера!', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1366357196, NULL, 0, 0, NULL, 0),
(218, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(219, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(220, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(221, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(222, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(223, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(224, 12, 14, '', 'тест файл', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1366536597, NULL, 0, 0, NULL, 0),
(225, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(226, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(227, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(228, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(229, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(230, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(231, 12, 14, '', 'test2', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1366537061, NULL, 0, 0, NULL, 0),
(232, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(233, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(234, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(235, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(236, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(237, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(238, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(239, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(240, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(241, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(242, 14, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(243, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(244, 12, 14, '', 'test', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367487911, NULL, 0, 0, NULL, 0),
(245, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(246, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(247, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(248, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(249, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(250, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(251, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(252, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(253, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(254, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(255, 12, 14, '', 'test123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367489188, NULL, 0, 0, NULL, 0),
(256, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(257, 12, 14, '', 'test', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367489224, NULL, 0, 0, NULL, 0),
(258, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(259, 12, 14, '', 'test', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367490412, NULL, 0, 0, NULL, 0),
(260, 12, 14, '', 'test2', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367490418, NULL, 0, 0, NULL, 0),
(261, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(262, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(263, 12, 14, '', 'test', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367490687, NULL, 0, 0, NULL, 0),
(264, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(265, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(266, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(267, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(268, 12, 22, 'gfhg', 'kjhkj', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1367492488, 'no', 'no', 1367492488, NULL, 0, 0, NULL, 0),
(269, 22, 12, '', 'Qwe', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492521, NULL, 0, 0, NULL, 0),
(270, 12, 22, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492513, NULL, 0, 0, NULL, 0),
(271, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(272, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(273, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(274, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(275, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(276, 12, 22, '', '1112', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492669, NULL, 0, 0, NULL, 0),
(277, 12, 22, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492717, NULL, 0, 0, NULL, 0),
(278, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(279, 12, 22, '', '222', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492724, NULL, 0, 0, NULL, 0),
(280, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(281, 22, 12, '', 'Qwe', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492754, NULL, 0, 0, NULL, 0),
(282, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(283, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(284, 22, 12, '', 'Qwe', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492949, NULL, 0, 0, NULL, 0),
(285, 22, 12, '', '', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492951, NULL, 0, 0, NULL, 0),
(286, 22, 12, '', 'Df', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367492977, NULL, 0, 0, NULL, 0),
(287, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(288, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(289, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(290, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(291, 22, 12, '', 'Qaaa', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493044, NULL, 0, 0, NULL, 0),
(292, 12, 22, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493032, NULL, 0, 0, NULL, 0),
(293, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(294, 22, 12, '', 'Qqq', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493193, NULL, 0, 0, NULL, 0),
(295, 12, 22, '', '222', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493197, NULL, 0, 0, NULL, 0),
(296, 22, 12, '', 'Wswa', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493209, NULL, 0, 0, NULL, 0),
(297, 12, 22, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493217, NULL, 0, 0, NULL, 0),
(298, 22, 12, '', 'Qqqq', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493338, NULL, 0, 0, NULL, 0),
(299, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(300, 12, 22, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493288, NULL, 0, 0, NULL, 0),
(301, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(302, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(303, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(304, 12, 22, '', 'test', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493360, NULL, 0, 0, NULL, 0),
(305, 22, 12, '', 'Test', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493365, NULL, 0, 0, NULL, 0),
(306, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(307, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(308, 12, 22, '', '234', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493452, NULL, 0, 0, NULL, 0),
(309, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(310, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493462, NULL, 0, 0, NULL, 0),
(311, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(312, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493520, NULL, 0, 0, NULL, 0),
(313, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(314, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493613, NULL, 0, 0, NULL, 0),
(315, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(316, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367493787, NULL, 0, 0, NULL, 0),
(317, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(318, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367495883, NULL, 0, 0, NULL, 0),
(319, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(320, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(321, 12, 22, '', 'werwer', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367502086, NULL, 0, 0, NULL, 0),
(322, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(323, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367502352, NULL, 0, 0, NULL, 0),
(324, 12, 22, '', '', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367502383, NULL, 0, 0, NULL, 0),
(325, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(326, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367502388, NULL, 0, 0, NULL, 0),
(327, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(328, 12, 22, '', '1', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367502438, NULL, 0, 0, NULL, 0),
(329, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(330, 12, 22, '', '1', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367502483, NULL, 0, 0, NULL, 0),
(331, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(332, 20, 14, '', 'Привет Братюньь!!!!', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1367557121, 'no', 'no', 1367557121, NULL, 0, 0, NULL, 0),
(333, 20, 0, '', 'So now i can say that i was in a Times square!!)))) \r\n\r\namazing place for spending money =D', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1367557305, 'no', 'no', 1367557305, NULL, 0, 0, '', 2),
(334, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(335, 14, 20, '', 'Дарова!', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367557364, NULL, 0, 0, NULL, 0),
(336, 20, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(337, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(338, 20, 0, '', 'One more pic of HongKong!!!', 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 1367557412, 'no', 'yes', 1367557412, NULL, 0, 0, '', 0),
(339, 20, 0, 'HongKong', 'One more pic of Hong Kong!!!', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1367557504, 'no', 'no', 1367557504, NULL, 0, 0, '', 1),
(340, 20, 14, '', '卡卡是卡！！！  =D', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367557572, NULL, 0, 0, NULL, 0),
(341, 20, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(342, 20, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(343, 20, 0, 'China', 'Just back from China!\r\nim gonna miss you !!!', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1367557723, 'no', 'no', 1367557723, NULL, 0, 0, '', 0),
(344, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(345, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(346, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(347, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(348, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(349, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603246, NULL, 0, 0, NULL, 0),
(350, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(351, 12, 22, '', '123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603342, NULL, 0, 0, NULL, 0),
(352, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(353, 15, 12, '123123', '123123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1367603793, 'no', 'no', 1367603793, NULL, 0, 0, NULL, 0),
(354, 15, 12, '', '123123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603803, NULL, 0, 0, NULL, 0),
(355, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(356, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(357, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603891, NULL, 0, 0, NULL, 0),
(358, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(359, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(360, 15, 12, '', '324', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603965, NULL, 0, 0, NULL, 0),
(361, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603989, NULL, 0, 0, NULL, 0),
(362, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367603977, NULL, 0, 0, NULL, 0),
(363, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(364, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(365, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604001, NULL, 0, 0, NULL, 0),
(366, 15, 12, '', '234234', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604011, NULL, 0, 0, NULL, 0),
(367, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(368, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604470, NULL, 0, 0, NULL, 0),
(369, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(370, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604584, NULL, 0, 0, NULL, 0),
(371, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604603, NULL, 0, 0, NULL, 0),
(372, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(373, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604730, NULL, 0, 0, NULL, 0),
(374, 15, 12, '', '11', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604743, NULL, 0, 0, NULL, 0),
(375, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(376, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604815, NULL, 0, 0, NULL, 0),
(377, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(378, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604827, NULL, 0, 0, NULL, 0),
(379, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(380, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604844, NULL, 0, 0, NULL, 0),
(381, 12, 15, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604855, NULL, 0, 0, NULL, 0),
(382, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(383, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604860, NULL, 0, 0, NULL, 0),
(384, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(385, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604972, NULL, 0, 0, NULL, 0),
(386, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604990, NULL, 0, 0, NULL, 0),
(387, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367604981, NULL, 0, 0, NULL, 0),
(388, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(389, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(390, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605031, NULL, 0, 0, NULL, 0),
(391, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(392, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605043, NULL, 0, 0, NULL, 0),
(393, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(394, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605193, NULL, 0, 0, NULL, 0),
(395, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(396, 12, 15, '', '123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605270, NULL, 0, 0, NULL, 0),
(397, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(398, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605310, NULL, 0, 0, NULL, 0),
(399, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(400, 12, 15, '', '1', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605400, NULL, 0, 0, NULL, 0),
(401, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(402, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605489, NULL, 0, 0, NULL, 0),
(403, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(404, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605523, NULL, 0, 0, NULL, 0),
(405, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(406, 15, 12, '', '1212', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605554, NULL, 0, 0, NULL, 0),
(407, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605573, NULL, 0, 0, NULL, 0),
(408, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605561, NULL, 0, 0, NULL, 0),
(409, 12, 15, '', '1', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605583, NULL, 0, 0, NULL, 0),
(410, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(411, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(412, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605635, NULL, 0, 0, NULL, 0),
(413, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(414, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605642, NULL, 0, 0, NULL, 0),
(415, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(416, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605694, NULL, 0, 0, NULL, 0),
(417, 12, 15, '', '222', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605713, NULL, 0, 0, NULL, 0),
(418, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605706, NULL, 0, 0, NULL, 0),
(419, 15, 12, '', '333', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605731, NULL, 0, 0, NULL, 0),
(420, 12, 15, '', '333', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605722, NULL, 0, 0, NULL, 0),
(421, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(422, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(423, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605762, NULL, 0, 0, NULL, 0),
(424, 12, 15, '', '444', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605778, NULL, 0, 0, NULL, 0),
(425, 15, 12, '', '22', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605771, NULL, 0, 0, NULL, 0),
(426, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(427, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(428, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605838, NULL, 0, 0, NULL, 0),
(429, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(430, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605913, NULL, 0, 0, NULL, 0),
(431, 12, 15, '', '3434', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605930, NULL, 0, 0, NULL, 0),
(432, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367605922, NULL, 0, 0, NULL, 0),
(433, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(434, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(435, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606001, NULL, 0, 0, NULL, 0),
(436, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0);
INSERT INTO `messages` (`id`, `from`, `to`, `title`, `body`, `app_id`, `body_id`, `title_id`, `in_reply_to`, `replies`, `status`, `type`, `recipients`, `collection_ids`, `urls`, `updated`, `to_deleted`, `from_deleted`, `created`, `shop_id`, `likes_num`, `shared_num`, `anons`, `comment_num`) VALUES
(437, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(438, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606019, NULL, 0, 0, NULL, 0),
(439, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606036, NULL, 0, 0, NULL, 0),
(440, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606029, NULL, 0, 0, NULL, 0),
(441, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(442, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(443, 12, 15, '', '11', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606086, NULL, 0, 0, NULL, 0),
(444, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(445, 15, 12, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606103, NULL, 0, 0, NULL, 0),
(446, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(447, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606173, NULL, 0, 0, NULL, 0),
(448, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606196, NULL, 0, 0, NULL, 0),
(449, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606181, NULL, 0, 0, NULL, 0),
(450, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(451, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(452, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(453, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606578, NULL, 0, 0, NULL, 0),
(454, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(455, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606613, NULL, 0, 0, NULL, 0),
(456, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(457, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(458, 15, 12, '', '4545', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606671, NULL, 0, 0, NULL, 0),
(459, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606691, NULL, 0, 0, NULL, 0),
(460, 12, 15, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606683, NULL, 0, 0, NULL, 0),
(461, 12, 15, '', '`1', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606696, NULL, 0, 0, NULL, 0),
(462, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(463, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(464, 15, 12, '', '345', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606712, NULL, 0, 0, NULL, 0),
(465, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606726, NULL, 0, 0, NULL, 0),
(466, 12, 15, '', '456', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606722, NULL, 0, 0, NULL, 0),
(467, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(468, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(469, 15, 12, '', '2222', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606757, NULL, 0, 0, NULL, 0),
(470, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606749, NULL, 0, 0, NULL, 0),
(471, 12, 15, '', '22', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606760, NULL, 0, 0, NULL, 0),
(472, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(473, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606776, NULL, 0, 0, NULL, 0),
(474, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(475, 15, 12, '', '22', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606826, NULL, 0, 0, NULL, 0),
(476, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606838, NULL, 0, 0, NULL, 0),
(477, 12, 15, '', '11', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606834, NULL, 0, 0, NULL, 0),
(478, 12, 15, '', '22', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606855, NULL, 0, 0, NULL, 0),
(479, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(480, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(481, 12, 15, '', '22', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606861, NULL, 0, 0, NULL, 0),
(482, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(483, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606879, NULL, 0, 0, NULL, 0),
(484, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606894, NULL, 0, 0, NULL, 0),
(485, 15, 12, '', '343', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606891, NULL, 0, 0, NULL, 0),
(486, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606897, NULL, 0, 0, NULL, 0),
(487, 12, 15, '', '4545', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606931, NULL, 0, 0, NULL, 0),
(488, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606923, NULL, 0, 0, NULL, 0),
(489, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(490, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606937, NULL, 0, 0, NULL, 0),
(491, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(492, 12, 15, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606945, NULL, 0, 0, NULL, 0),
(493, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606956, NULL, 0, 0, NULL, 0),
(494, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606952, NULL, 0, 0, NULL, 0),
(495, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(496, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(497, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606967, NULL, 0, 0, NULL, 0),
(498, 12, 15, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606964, NULL, 0, 0, NULL, 0),
(499, 12, 15, '', '2332', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606970, NULL, 0, 0, NULL, 0),
(500, 15, 12, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606972, NULL, 0, 0, NULL, 0),
(501, 12, 15, '', '3434', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606989, NULL, 0, 0, NULL, 0),
(502, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367606981, NULL, 0, 0, NULL, 0),
(503, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(504, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(505, 15, 12, '', '222', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607076, NULL, 0, 0, NULL, 0),
(506, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607070, NULL, 0, 0, NULL, 0),
(507, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607081, NULL, 0, 0, NULL, 0),
(508, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607094, NULL, 0, 0, NULL, 0),
(509, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(510, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(511, 12, 15, '', '345345', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607132, NULL, 0, 0, NULL, 0),
(512, 12, 15, '', '23', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607144, NULL, 0, 0, NULL, 0),
(513, 15, 12, '', '345', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607141, NULL, 0, 0, NULL, 0),
(514, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(515, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(516, 15, 12, '', '222', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607162, NULL, 0, 0, NULL, 0),
(517, 12, 15, '', '111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607159, NULL, 0, 0, NULL, 0),
(518, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(519, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(520, 12, 15, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607202, NULL, 0, 0, NULL, 0),
(521, 12, 15, '', '11', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607212, NULL, 0, 0, NULL, 0),
(522, 15, 12, '', '3434', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607210, NULL, 0, 0, NULL, 0),
(523, 15, 12, '', '444', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367607219, NULL, 0, 0, NULL, 0),
(524, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(525, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(526, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645123, NULL, 0, 0, NULL, 0),
(527, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(528, 15, 12, '', '123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645158, NULL, 0, 0, NULL, 0),
(529, 15, 12, '', '2323', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645166, NULL, 0, 0, NULL, 0),
(530, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(531, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(532, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(533, 15, 12, '', '11', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645238, NULL, 0, 0, NULL, 0),
(534, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(535, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(536, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(537, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(538, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(539, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(540, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645493, NULL, 0, 0, NULL, 0),
(541, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(542, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(543, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(544, 12, 22, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645548, NULL, 0, 0, NULL, 0),
(545, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(546, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(547, 12, 15, '', '111111', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645590, NULL, 0, 0, NULL, 0),
(548, 12, 15, '', '45354345', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645700, NULL, 0, 0, NULL, 0),
(549, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(550, 15, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(551, 12, 15, '', '345345', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645710, NULL, 0, 0, NULL, 0),
(552, 12, 15, '', '345345', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645714, NULL, 0, 0, NULL, 0),
(553, 12, 15, '', '123123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367645746, NULL, 0, 0, NULL, 0),
(554, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(555, 22, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(556, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(557, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(558, 13, 14, '', 'Пробное сообщение', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367832641, NULL, 0, 0, NULL, 0),
(559, 13, 14, '', 'проверка', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367832725, NULL, 0, 0, NULL, 0),
(560, 13, 14, '', 'сообщения', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1367832732, NULL, 0, 0, NULL, 0),
(561, 13, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(562, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(563, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(564, 14, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(565, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(566, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(567, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(568, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(569, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(570, 14, 0, 'Пишу отчет о путешествии!', 'Пишу отчет о путешествии, вроде получается, но так как наш ресурс еще не раскручен, то буду выгружать на Drom.ru. \r\n\r\nВот некоторые фото которые будут прикреплены к отчету. Особенно ДЕД МЕГАФОН', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1367986554, 'no', 'no', 1367986554, NULL, 0, 0, '', 2),
(571, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(572, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(573, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(574, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(575, 12, 22, '', '<p>dasdasdasd</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1368772445, NULL, 0, 0, NULL, 0),
(576, 12, 22, '', '<p>dasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasddasdasdasd</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'yes', 1368772459, NULL, 0, 0, NULL, 0),
(577, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(578, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(579, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(580, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(581, 14, 20, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(582, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(583, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(584, 14, 13, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(585, 14, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(586, 12, 22, '', '<p>sdfsdfsdf</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'yes', 1368874789, NULL, 0, 0, NULL, 0),
(587, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(588, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(589, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(590, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(591, 23, 14, 'Интересные вещи', 'http://2074.ru/sale/detail/109519.php\nновенький моноблок\nhttp://2074.ru/sale/detail/109546.php\nновенький комплект HP', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1370087714, 'no', 'no', 1370087714, NULL, 0, 0, NULL, 0),
(592, 12, 14, '', '<p>123123123</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1372680177, NULL, 0, 0, NULL, 0),
(593, 12, 14, '', '<p>123123</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1372680184, NULL, 0, 0, NULL, 0),
(594, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(595, 12, 0, 'йцуйцу', 'йцуйцуйцу', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1372680262, 'no', 'no', 1372680262, NULL, 0, 0, '', 0),
(596, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(597, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(598, 12, 15, '', '', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1372766411, NULL, 0, 0, NULL, 0),
(599, 12, 15, '', '<p>уекуке</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1372766417, NULL, 0, 0, NULL, 0),
(600, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(601, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(602, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(603, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(604, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(605, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(606, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(607, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(608, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(609, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(610, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(611, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(612, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(613, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(614, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(615, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(616, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(617, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(618, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(619, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(620, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(621, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(622, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(623, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(624, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(625, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(626, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(627, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(628, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(629, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(630, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(631, 12, 0, '23423 23 4234 23', '231231231234234234234', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378897298, 'no', 'no', 1378897298, NULL, 0, 1, '', 1),
(632, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(633, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(634, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(635, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(636, 12, 0, 'выап ваап вапва п1', 'ertertertert 123123 каывапыва пвпрапр11', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378891561, 'no', 'no', 1378891561, NULL, 0, 0, '', 7),
(637, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(638, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(639, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(640, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(641, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(642, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(643, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(644, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(645, 1, 25, '<font color=red>!!!NO TRANSLATION for Message title for new user in profile!!!</font>', '<font color=red>!!!NO TRANSLATION for Message text for new user in profile!!!</font>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1378365165, 'no', 'no', 1378365165, NULL, 0, 0, NULL, 0),
(646, 25, 0, '', '<font color=red>!!!NO TRANSLATION for News text for new user in profile!!!</font>', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378365165, 'no', 'no', 1378365165, NULL, 0, 0, '<font color=red>!!!NO TRANSLATION for News anons for new user in profile!!!</font>', 0),
(647, 1, 26, '<font color=red>!!!NO TRANSLATION for Message title for new user in profile!!!</font>', '<font color=red>!!!NO TRANSLATION for Message text for new user in profile!!!</font>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1378365573, 'no', 'no', 1378365573, NULL, 0, 0, NULL, 0),
(648, 26, 0, '', '<font color=red>!!!NO TRANSLATION for News text for new user in profile!!!</font>', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378365573, 'no', 'no', 1378365573, NULL, 0, 0, '<font color=red>!!!NO TRANSLATION for News anons for new user in profile!!!</font>', 1),
(649, 26, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(650, 1, 27, '<font color=red>!!!NO TRANSLATION for Message title for new user in profile!!!</font>', '<font color=red>!!!NO TRANSLATION for Message text for new user in profile!!!</font>', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1378369306, 'no', 'no', 1378369306, NULL, 0, 0, NULL, 0),
(651, 27, 0, '', '<font color=red>!!!NO TRANSLATION for News text for new user in profile!!!</font>', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378369306, 'no', 'no', 1378369306, NULL, 0, 0, '<font color=red>!!!NO TRANSLATION for News anons for new user in profile!!!</font>', 0),
(652, 1, 28, 'Добро пожаловать в Comiron!', 'Добро пожаловать в Comiron! ...', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1378369854, 'no', 'no', 1378369854, NULL, 0, 0, NULL, 0),
(653, 28, 0, '', 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378369854, 'no', 'no', 1378369854, NULL, 0, 0, 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0),
(654, 28, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(655, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(656, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(657, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(658, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(659, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(660, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(661, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(662, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(663, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(664, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(665, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(666, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(667, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(668, 12, 0, '', 'ыфвфывфыв', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378900134, 'no', 'no', 1378900134, NULL, 0, 1, '', 1),
(669, 12, 0, 'asd asdasd', 'asdasdasd&nbsp;', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1378965514, 'no', 'no', 1378965514, NULL, 0, 1, '', 6),
(670, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(671, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(672, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(673, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(674, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(675, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(676, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(677, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(678, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(679, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(680, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(681, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(682, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(683, 12, 0, 'заголовок', '123123 123 123\r\nываы ваыв пвапв ар првапр вапрвап\r\n&nbsp; &nbsp; ыдвлаоыдвал оыдвал подвпловда пр', 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 1379058486, 'no', 'yes', 1379058486, NULL, 0, 1, '', 0),
(684, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(685, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(686, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(687, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(688, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(689, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(690, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(691, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(692, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(693, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(694, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(695, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(696, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(697, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(698, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(699, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(700, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(701, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(702, 12, 15, '', '<p>впвап</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380064959, NULL, 0, 0, NULL, 0),
(703, 12, 15, '', '<p>поапр</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380064972, NULL, 0, 0, NULL, 0),
(704, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(705, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(706, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(707, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(708, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(709, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(710, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(711, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(712, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(713, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(714, 12, 15, '', '<p>укцук</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380065753, NULL, 0, 0, NULL, 0),
(715, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(716, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(717, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(718, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(719, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(720, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(721, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(722, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(723, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(724, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(725, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(726, 12, 25, '123123', '123123123', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1380222095, 'no', 'no', 1380222095, NULL, 0, 0, NULL, 0),
(739, 12, 0, '', '', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228123, NULL, 0, 0, NULL, 0),
(740, 12, 25, '', '', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228222, NULL, 0, 0, NULL, 0),
(741, 12, 3, '', '', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228230, NULL, 0, 0, NULL, 0),
(742, 12, 25, '', '', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228238, NULL, 0, 0, NULL, 0),
(743, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(744, 12, 15, '', '', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228254, NULL, 0, 0, NULL, 0),
(745, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(752, 25, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(753, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(754, 12, 25, '', '<p>324234</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380228618, NULL, 0, 0, NULL, 0),
(755, 25, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(756, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(757, 12, 0, 'цукцукцук', '', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1380265942, 'no', 'no', 1380265942, NULL, 0, 0, '', 0),
(758, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(759, 12, 0, '345345', '', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1380274885, 'no', 'no', 1380274885, NULL, 0, 0, '', 0),
(760, 12, 0, 'фывфыв', 'фывфыв', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1380280451, 'no', 'no', 1380280451, NULL, 0, 0, '', 0),
(761, 12, 0, '', 'ываываыва', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1380280463, 'no', 'no', 1380280463, NULL, 0, 0, '', 1),
(762, 12, 25, '', '<p>4кцва ываы ваыва вапв</p>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380280655, NULL, 0, 0, NULL, 0),
(763, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(764, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(765, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(766, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(767, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(768, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(769, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(770, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(771, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(772, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(773, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(774, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(775, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(776, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(777, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(778, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(779, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(780, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(781, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(782, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(783, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(784, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(785, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(786, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(787, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(788, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(789, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(790, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(791, 12, 14, '', '<p>3424234234</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380529994, NULL, 0, 0, NULL, 0),
(792, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(793, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(794, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0);
INSERT INTO `messages` (`id`, `from`, `to`, `title`, `body`, `app_id`, `body_id`, `title_id`, `in_reply_to`, `replies`, `status`, `type`, `recipients`, `collection_ids`, `urls`, `updated`, `to_deleted`, `from_deleted`, `created`, `shop_id`, `likes_num`, `shared_num`, `anons`, `comment_num`) VALUES
(795, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(796, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(797, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(798, 12, 14, '', '<p>fgsdfsdf sdf s</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380530501, NULL, 0, 0, NULL, 0),
(799, 12, 14, '', '<p>sdfsdf</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1380530568, NULL, 0, 0, NULL, 0),
(800, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(801, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(802, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(803, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(804, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(805, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(806, 12, 0, '123123123123', '123123123', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1380531124, 'no', 'no', 1380531124, NULL, 0, 0, '', 0),
(807, 12, 0, '123123 12312', '3123 123 123123', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1380531163, 'no', 'no', 1380531163, NULL, 0, 0, '', 1),
(808, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(809, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(810, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(811, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(812, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(813, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(814, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(815, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(816, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(817, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(818, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(819, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(820, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(821, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(822, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(823, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(824, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(825, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(826, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(827, 25, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(828, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(829, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(830, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(831, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(832, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(833, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(834, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(835, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(836, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(837, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(838, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(839, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(840, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(841, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(842, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(843, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(844, 12, 0, '123123123', '123123123', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1382513925, 'no', 'no', 1382513925, NULL, 0, 0, '', 0),
(845, 12, 0, 'ываываыва', 'ываываы', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1382514287, 'no', 'no', 1382514287, NULL, 1, 1, '', 1),
(846, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(847, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(848, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(849, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(850, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(851, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(852, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(853, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(854, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(855, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(856, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(857, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(858, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(859, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(860, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(861, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(862, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(863, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(864, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(865, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(866, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(867, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(868, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(869, 12, 0, 'ываываыва', 'ывываываыва', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1382516711, 'no', 'no', 1382516711, NULL, 0, 0, '', 1),
(870, 12, 0, '', 'ываыаыываываыва', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1382516806, 'no', 'no', 1382516806, NULL, 0, 0, '', 0),
(871, 12, 0, '123123123', 'ываываываывава', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1382566475, 'no', 'no', 1382566475, NULL, 0, 0, '', 3),
(872, 26, 0, '', 'sdfsdfsdf', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385667255, NULL, 0, 0, NULL, 0),
(873, 26, 1, '', '<p>dasfsdfsdfsdf</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385667265, NULL, 0, 0, NULL, 0),
(874, 26, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(875, 26, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(876, 26, 1, '', '<p>567567</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385667576, NULL, 0, 0, NULL, 0),
(877, 26, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(878, 26, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(879, 12, 25, '', '<p>qweqwe</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385669122, NULL, 0, 0, NULL, 0),
(880, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(881, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(882, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(883, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(884, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(885, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(886, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(887, 12, 25, '', '<p>123123123</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385678888, NULL, 0, 0, NULL, 0),
(888, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(889, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(890, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(891, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(892, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(893, 12, 25, '', '<p>345345</p>\r\n<p></p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679630, NULL, 0, 0, NULL, 0),
(894, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(895, 12, 25, '', '<p>345345345</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679651, NULL, 0, 0, NULL, 0),
(896, 12, 25, '', '<p>34345</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679666, NULL, 0, 0, NULL, 0),
(897, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(898, 12, 25, '', '345345345', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679855, NULL, 0, 0, NULL, 0),
(899, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(900, 12, 25, '', '<p>123123</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679889, NULL, 0, 0, NULL, 0),
(901, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(902, 12, 25, '', '<p>123123</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679929, NULL, 0, 0, NULL, 0),
(903, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(904, 12, 25, '', '<p>345345345</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385679955, NULL, 0, 0, NULL, 0),
(905, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(906, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(907, 12, 25, '', '<p>34234</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680011, NULL, 0, 0, NULL, 0),
(908, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(909, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(910, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(911, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(912, 12, 25, '', '<p>234234</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680106, NULL, 0, 0, NULL, 0),
(913, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(914, 12, 25, '', '<p>345345</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680214, NULL, 0, 0, NULL, 0),
(915, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(916, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(917, 12, 15, '', '<p>234234234</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680360, NULL, 0, 0, NULL, 0),
(918, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(919, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(920, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(921, 12, 12, '', '<p>123123</p>', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680412, NULL, 0, 0, NULL, 0),
(922, 12, 22, '', '<p>232323</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680726, NULL, 0, 0, NULL, 0),
(923, 12, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(924, 12, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(925, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(926, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(927, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(928, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(929, 12, 22, '', '<p>456456456</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680858, NULL, 0, 0, NULL, 0),
(930, 12, 22, '', '<p>456456</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385680861, NULL, 0, 0, NULL, 0),
(931, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(932, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(933, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(934, 12, 22, '', '<p>234234234</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385758135, NULL, 0, 0, NULL, 0),
(935, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(936, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(937, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(938, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(939, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(940, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(941, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(942, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(943, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(944, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(945, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(946, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(947, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(948, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(949, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(950, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(951, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(952, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(953, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(954, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(955, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(956, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(957, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(958, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(959, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(960, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(961, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(962, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(963, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(964, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(965, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(966, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(967, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(968, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(969, 12, 22, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(970, 12, 14, '', '<p>123123</p>', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1385761572, NULL, 0, 0, NULL, 0),
(971, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(972, 12, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(973, 12, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(974, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(975, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(976, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(977, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(978, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(979, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(980, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(981, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(982, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(983, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(984, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(985, 12, 25, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(986, 12, 12, '', '123123', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1386874295, NULL, 0, 0, NULL, 0),
(987, 12, 12, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(988, 12, 14, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1386874307, NULL, 0, 0, NULL, 0),
(989, 12, 25, '', '123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1386874307, NULL, 0, 0, NULL, 0),
(990, 12, 0, '123123', '123123123', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1386875080, 'no', 'no', 1386875080, NULL, 0, 0, '', 0),
(991, 12, 0, '', '', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1386875095, 'no', 'no', 1386875095, NULL, 0, 0, '', 0),
(992, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(993, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(994, 12, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(995, 12, 0, '', 'ewerwer', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1386875597, 'no', 'no', 1386875597, NULL, 0, 0, '', 0),
(996, 1, 29, 'Добро пожаловать в Comiron!', 'Добро пожаловать в Comiron! ...', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1386881997, 'no', 'no', 1386881997, NULL, 0, 0, NULL, 0),
(997, 29, 0, '', 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1386881997, 'no', 'no', 1386881997, NULL, 0, 0, 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0),
(998, 12, 14, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(999, 12, 15, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1000, 12, 4, '', '123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400171, NULL, 0, 0, NULL, 0),
(1001, 12, 1, '', '123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400171, NULL, 0, 0, NULL, 0),
(1002, 12, 2, '', '123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400171, NULL, 0, 0, NULL, 0),
(1003, 12, 3, '', '123123', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400171, NULL, 0, 0, NULL, 0),
(1004, 12, 4, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1005, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1006, 12, 2, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1007, 12, 4, '', '1', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400398, NULL, 0, 0, NULL, 0),
(1008, 12, 1, '', '1', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400398, NULL, 0, 0, NULL, 0),
(1009, 12, 2, '', '1', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400398, NULL, 0, 0, NULL, 0),
(1010, 12, 3, '', '1', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400398, NULL, 0, 0, NULL, 0),
(1011, 12, 4, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1012, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1013, 12, 2, '', '2', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400483, NULL, 0, 0, NULL, 0),
(1014, 12, 1, '', '2', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400483, NULL, 0, 0, NULL, 0),
(1015, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1016, 12, 2, '', '23', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400700, NULL, 0, 0, NULL, 0),
(1017, 12, 2, '', '23', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400700, NULL, 0, 0, NULL, 0),
(1018, 12, 2, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1019, 12, 3, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400750, NULL, 0, 0, NULL, 0),
(1020, 12, 1, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400750, NULL, 0, 0, NULL, 0),
(1021, 12, 2, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387400750, NULL, 0, 0, NULL, 0),
(1022, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1023, 12, 3, '', '999', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401301, NULL, 0, 0, NULL, 0),
(1024, 12, 1, '', '999', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401301, NULL, 0, 0, NULL, 0),
(1025, 12, 3, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1026, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1027, 12, 4, '', '988', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401366, NULL, 0, 0, NULL, 0),
(1028, 12, 1, '', '988', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401366, NULL, 0, 0, NULL, 0),
(1029, 12, 2, '', '988', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401366, NULL, 0, 0, NULL, 0),
(1030, 12, 3, '', '988', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401366, NULL, 0, 0, NULL, 0),
(1031, 12, 4, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1032, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1033, 12, 4, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401490, NULL, 0, 0, NULL, 0),
(1034, 12, 1, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401490, NULL, 0, 0, NULL, 0),
(1035, 12, 2, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401490, NULL, 0, 0, NULL, 0),
(1036, 12, 3, '', '111', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401490, NULL, 0, 0, NULL, 0),
(1037, 12, 4, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1038, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1039, 12, 4, '', '2', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401589, NULL, 0, 0, NULL, 0),
(1040, 12, 1, '', '2', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401589, NULL, 0, 0, NULL, 0),
(1041, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1042, 12, 4, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401635, NULL, 0, 0, NULL, 0),
(1043, 12, 1, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401635, NULL, 0, 0, NULL, 0),
(1044, 12, 2, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401635, NULL, 0, 0, NULL, 0),
(1045, 12, 3, '', '3', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1387401635, NULL, 0, 0, NULL, 0),
(1046, 12, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1047, 12, 3, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1048, 12, 14, 'кууке', 'укеуке', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1387542808, 'no', 'no', 1387542808, NULL, 0, 0, NULL, 0),
(1049, 1, 30, 'Добро пожаловать в Comiron!', 'Добро пожаловать в Comiron! ...', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1387568374, 'no', 'no', 1387568374, NULL, 0, 0, NULL, 0),
(1050, 30, 0, '', 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1387568374, 'no', 'no', 1387568374, NULL, 0, 0, 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0),
(1051, 30, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1052, 30, 1, '', 'вапвапвап', 0, NULL, NULL, NULL, NULL, 'unread', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 1389902058, NULL, 0, 0, NULL, 0),
(1053, 30, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1054, 30, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1055, 30, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1056, 30, 0, '123123', '123123', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1396037375, 'no', 'no', 1396037375, NULL, 1, 0, '', 0),
(1057, 30, 0, 'dasdasasd', 'asdas', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1396037406, 'no', 'no', 1396037406, NULL, 1, 0, '', 0),
(1058, 30, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1059, 1, 31, 'Добро пожаловать в Comiron!', 'Добро пожаловать в Comiron! ...', 0, NULL, NULL, NULL, NULL, 'read', 'private_message', NULL, NULL, NULL, 1401186608, 'no', 'no', 1401186608, NULL, 0, 0, NULL, 0),
(1060, 31, 0, '', 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1401186608, 'no', 'no', 1401186608, NULL, 0, 0, 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0),
(1061, 31, 1, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'private_message', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1062, 1, 33, 'Добро пожаловать в Comiron!', 'Добро пожаловать в Comiron! ...', 0, NULL, NULL, NULL, NULL, 'new', 'private_message', NULL, NULL, NULL, 1401187618, 'no', 'no', 1401187618, NULL, 0, 0, NULL, 0),
(1063, 33, 0, '', 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0, NULL, NULL, NULL, NULL, 'new', 'news', NULL, NULL, NULL, 1401187618, 'no', 'no', 1401187618, NULL, 0, 0, 'Всем привет! Я зарегистрировался на сайте comiron.com ...', 0),
(1064, 30, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1065, 30, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0),
(1066, 30, 0, '', NULL, 0, NULL, NULL, NULL, NULL, 'deleted', 'news', NULL, NULL, NULL, 0, 'no', 'no', 0, NULL, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `message_collections`
--

DROP TABLE IF EXISTS `message_collections`;
CREATE TABLE IF NOT EXISTS `message_collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `title` char(255) NOT NULL,
  `updated` int(11) NOT NULL,
  `urls` mediumtext,
  `created` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `message_collections`
--


-- --------------------------------------------------------

--
-- Структура таблицы `message_groups`
--

DROP TABLE IF EXISTS `message_groups`;
CREATE TABLE IF NOT EXISTS `message_groups` (
  `message_id` int(11) NOT NULL,
  `message_collection_id` int(11) NOT NULL,
  UNIQUE KEY `message_id` (`message_id`,`message_collection_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message_groups`
--


-- --------------------------------------------------------

--
-- Структура таблицы `oauth_consumer`
--

DROP TABLE IF EXISTS `oauth_consumer`;
CREATE TABLE IF NOT EXISTS `oauth_consumer` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `app_id` int(11) NOT NULL DEFAULT '0',
  `consumer_key` char(64) NOT NULL,
  `consumer_secret` char(64) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `app_id` (`app_id`),
  KEY `consumer_key` (`consumer_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oauth_consumer`
--

INSERT INTO `oauth_consumer` (`user_id`, `app_id`, `consumer_key`, `consumer_secret`) VALUES
(4, 0, 'e2f3ffcb-efe6-cac2-b9fa-e5f7c7ccc2c4', 'c2df0abaf42d9b449b4df93e270a93f4'),
(5, 0, 'c8facbc5-fbd1-cddb-a8ef-c4e8c1c3c7d7', 'f97c060fc1f57729b4d92edfbc430b2f'),
(6, 0, 'dde7ffcb-ece3-cec9-96ca-d3dcc7ebf8f8', '071bd92eb537438ce63f64bb4c8dbf98'),
(7, 0, 'e5ebf8c2-caf8-cfee-b0f3-ebdcdedbe2da', '42bca13d2b14458941b4fa17f8f98d44'),
(8, 0, 'dae6f8e7-faf4-c8eb-99fd-fbf7c7cefdce', 'f3b29ae8f35c8347170c8bc054f2de78'),
(9, 0, 'edd2fdf6-deee-c6d5-9ef8-c3fad2cfcbf6', 'e977b2ca48408b3d651c05fd2efa4527'),
(10, 0, 'f0d1cbc1-d5c7-c7fc-b5de-e4c9f4ebd6c8', '8b77eb02cc04c276cedbb48e6e5c248c'),
(11, 0, 'c1c7f3e2-c2f0-cfef-87de-e7c9c4f2dfea', '60e79920fe541c55b708d4e430c5c8e7'),
(12, 0, 'cbfcebe5-e6e1-c7d5-afd3-e6f9c3edf5f8', '0ebe7c2eb75e04c95250b5823a949978'),
(13, 0, 'f9e6cbd3-dff5-c5fc-9be8-e8c5f7edffc3', '6679770039107c78f513c868a430ddda'),
(14, 0, 'edcef0ff-efeb-c4e7-8ee4-fbc7c0eee2d9', 'bb3b64ec43425f94acf71ea0d467c123'),
(15, 0, 'd1e5cac7-d1d1-c4dd-a6c1-fccfd4f3fff2', '824c94a77456a497f5ae576d586145c7'),
(16, 0, 'f4e2dbd9-c5e3-c1c9-96d3-cedce6dacfcf', '78a7007e6c7afbd197a337dc6ab4a99d'),
(17, 0, 'ced7e3e6-e9e5-cdfc-90d3-fccbe4e5dac8', '97aecffee8897f240d0408db7c48303a'),
(18, 0, 'ddc0e2f2-c5e8-c8dd-abd5-f6ccd4fcf8f4', 'd55670418be416647d63e739d239d43b'),
(19, 0, 'ede2c7ec-dff4-c6c8-b1e4-fbfce3d9c7ef', '421796dd6424782247d22b64e9aa30be'),
(20, 0, 'd6c5e0ff-c4c7-c5c9-9ce0-efd1f8fdc5fd', 'aa18968714d586b7d7048d8fd24edcbe'),
(21, 0, 'c1d1d0e2-c3f2-ced2-89f9-e2daf1eaffd3', '3f677167888b3c78314547b5eb9f13ed'),
(22, 0, 'eafcfbd3-e6e9-cbea-80de-d2e0facfffd6', 'c567a03e1865d8b0599a5798419a1bb5'),
(23, 0, 'e2f4d1d9-d1dd-c9ef-b9f7-e9f2e0f2d2cf', 'e9cc253f492f4d18447eff593a343f6e'),
(24, 0, 'f8d9d2cd-d8e7-c9f9-82c9-c1edeedfe7e8', '5f5a4910baa10f3fa8124282a962e263'),
(1, 0, 'f4cef2e5-dfc5-ccd4-85d1-eed4e0cbdffd', 'b1bc6e0a67d8acc0f6ced2cdb668b552'),
(2, 0, 'f0ebfddd-cdf5-c4cb-bdcd-ebc2f9cad9db', '13d2b98b1c46553112cc4bfaa279acc3'),
(3, 0, 'eaedc9ce-fdd1-c1d7-87d6-fcdec1d5f2fa', '230366fef7d9c0de43faf39546f32f75'),
(25, 0, 'dbc8e7ea-e9f3-c9ee-85de-d5fec6c1d2d1', 'bf1633d6bf60e5571d98cf771f7e92fb'),
(26, 0, 'c7e4c9f4-e3dc-c2db-87c6-eecfeafaf6e8', 'da96a413407f67f51de76ac50aee9242'),
(27, 0, 'e0fdd7d7-e4cb-c5dc-92c5-d9f8c1e2d9e4', '79a019528eedbbab198251241c150a59'),
(28, 0, 'dde8cfe1-cfcc-cbec-8bfc-ecefe8efcbe1', 'c0ca998903638f427af3326b5cb914ce'),
(29, 0, 'e5d6eed6-dbd3-c3c8-96e8-faddefccdbce', '1aa387c3a51a1019e82d7560557566c6'),
(30, 0, 'd2f5f1d6-e5d9-c9df-afde-e4e6e9dddac2', '90bed0d06c47e9942ce8578fb3456960'),
(31, 0, 'c6d6d0c1-e5fb-c9d9-b7cc-c2dbf5e4c3de', 'cfafeaf0337045f58483385a6e79a8dc'),
(33, 0, 'e1d0c7db-cbc2-cfd8-88e8-c5f5edfae0ea', '9b62042bc73e3683cb8a6642481e42b1');

-- --------------------------------------------------------

--
-- Структура таблицы `oauth_nonce`
--

DROP TABLE IF EXISTS `oauth_nonce`;
CREATE TABLE IF NOT EXISTS `oauth_nonce` (
  `nonce` char(64) NOT NULL,
  `nonce_timestamp` int(11) NOT NULL,
  PRIMARY KEY (`nonce`),
  KEY `nonce_timestamp` (`nonce_timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oauth_nonce`
--


-- --------------------------------------------------------

--
-- Структура таблицы `oauth_token`
--

DROP TABLE IF EXISTS `oauth_token`;
CREATE TABLE IF NOT EXISTS `oauth_token` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `consumer_key` char(64) NOT NULL,
  `type` char(7) NOT NULL,
  `token_key` char(64) NOT NULL,
  `token_secret` char(64) NOT NULL,
  `authorized` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`token_key`),
  UNIQUE KEY `token_key` (`token_key`),
  KEY `token_key_2` (`token_key`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oauth_token`
--


-- --------------------------------------------------------

--
-- Структура таблицы `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `sum` decimal(19,2) NOT NULL DEFAULT '0.00',
  `ispayed` int(1) NOT NULL DEFAULT '0',
  `currency_id` int(11) DEFAULT NULL,
  `orderstatus_id` int(11) DEFAULT NULL,
  `dataorder` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `comment_person` text,
  `comment_shop` text,
  `comment_num` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`,`person_id`),
  KEY `currency_id` (`currency_id`),
  KEY `orderstatus_id` (`orderstatus_id`),
  KEY `dataorder` (`dataorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `shop_id`, `person_id`, `sum`, `ispayed`, `currency_id`, `orderstatus_id`, `dataorder`, `num`, `comment_person`, `comment_shop`, `comment_num`) VALUES
(1, 14, 30, 0.00, 1, NULL, 1, NULL, NULL, NULL, '1123123', 1),
(2, 14, 30, 0.00, 0, NULL, 2, NULL, 23, NULL, '0', 0),
(3, 14, 30, 0.00, 0, NULL, 2, NULL, NULL, NULL, '234', 0),
(4, 14, 30, 0.00, 0, NULL, 4, NULL, NULL, NULL, '0', 0),
(5, 14, 30, 12.00, 0, NULL, 1, NULL, NULL, NULL, '0', 0),
(6, 14, 30, 24.00, 0, 0, 2, NULL, NULL, NULL, '0', 0),
(7, 14, 30, 12.00, 0, 2, 3, NULL, NULL, NULL, '0', 0),
(10, 14, 33, 0.00, 0, 0, 1, 1401351874, NULL, NULL, NULL, 0),
(11, 14, 12, 123.00, 0, 1, 1, 1402386627, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `orderdetail`
--

DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE IF NOT EXISTS `orderdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` decimal(19,2) NOT NULL DEFAULT '0.00',
  `sum` decimal(19,2) NOT NULL DEFAULT '0.00',
  `shop_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`),
  KEY `shop_id` (`shop_id`),
  KEY `currency_id` (`currency_id`),
  KEY `person_id` (`person_id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Дамп данных таблицы `orderdetail`
--

INSERT INTO `orderdetail` (`id`, `order_id`, `product_id`, `num`, `price`, `sum`, `shop_id`, `product_name`, `currency_id`, `person_id`, `code`, `photo_url`) VALUES
(38, 3, 15, 1, 123.00, 123.00, 14, NULL, 1, 30, NULL, NULL),
(39, 3, 20, 2, 0.00, 0.00, 14, NULL, 2, 30, NULL, NULL),
(40, 4, 17, 1, 12.00, 12.00, 14, 'цвфы вфыв фыв', 2, 30, NULL, NULL),
(41, 5, 17, 1, 12.00, 12.00, 14, 'цвфы вфыв фыв', 2, 30, NULL, NULL),
(42, 6, 17, 2, 12.00, 24.00, 14, 'цвфы вфыв фыв', 2, 30, NULL, NULL),
(43, 7, 17, 1, 12.00, 12.00, 14, 'цвфы вфыв фыв', 2, 30, NULL, NULL),
(30, 9, 12, 2, 750000.00, 1500000.00, 13, 'Модульный дом ДВА этажа - 4 секции', NULL, 30, NULL, NULL),
(31, 9, 13, 1, 500000.00, 500000.00, 13, 'Дом супер', NULL, 30, NULL, NULL),
(46, 11, 15, 1, 123.00, 123.00, 14, 'dfgdfgs dfgdsf gdfg', 1, 12, NULL, '/images/product/15.png');

-- --------------------------------------------------------

--
-- Структура таблицы `orderstatus`
--

DROP TABLE IF EXISTS `orderstatus`;
CREATE TABLE IF NOT EXISTS `orderstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordr` int(11) DEFAULT NULL,
  `name` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordr` (`ordr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `orderstatus`
--

INSERT INTO `orderstatus` (`id`, `ordr`, `name`) VALUES
(1, 1, 'order_status_new'),
(2, 2, 'order_status_inprocess'),
(3, 3, 'order_status_done'),
(4, 4, 'order_status_denied');

-- --------------------------------------------------------

--
-- Структура таблицы `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address_id` int(11) DEFAULT NULL,
  `description` mediumtext,
  `end_date` int(11) DEFAULT NULL,
  `start_date` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  `thumbnail_big_url` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `organizationcategory_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `organizationcategory_id` (`organizationcategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Дамп данных таблицы `organizations`
--

INSERT INTO `organizations` (`id`, `address_id`, `description`, `end_date`, `start_date`, `person_id`, `thumbnail_url`, `thumbnail_big_url`, `fullname`, `organizationcategory_id`, `name`) VALUES
(21, NULL, '', NULL, -2147483648, 13, NULL, NULL, 'CYCLAND', 0, 'CYCLAND'),
(22, NULL, '', NULL, 1356984001, 14, NULL, NULL, 'ооо ', 0, 'Модульный Дом'),
(23, NULL, '', NULL, 1386025201, 30, NULL, NULL, 'shop name', 1, 'shop'),
(24, NULL, '', NULL, 1392663601, 12, NULL, NULL, 'Компания', 1, 'Компания');

-- --------------------------------------------------------

--
-- Структура таблицы `organization_address`
--

DROP TABLE IF EXISTS `organization_address`;
CREATE TABLE IF NOT EXISTS `organization_address` (
  `organization_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  KEY `organization_id` (`organization_id`,`address_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `organization_address`
--


-- --------------------------------------------------------

--
-- Структура таблицы `organization_category`
--

DROP TABLE IF EXISTS `organization_category`;
CREATE TABLE IF NOT EXISTS `organization_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) NOT NULL,
  `organizationcategory_id` int(11) DEFAULT NULL,
  `name_ch` varchar(250) DEFAULT NULL,
  `name_ru` varchar(250) DEFAULT NULL,
  `name_it` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organizationcategory_id` (`organizationcategory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `organization_category`
--

INSERT INTO `organization_category` (`id`, `name_en`, `organizationcategory_id`, `name_ch`, `name_ru`, `name_it`) VALUES
(1, 'Busness category1', 0, 'Busness category1', 'Busness category1', 'Busness category1'),
(2, 'Busness category2', 0, 'Busness category2', 'Busness category2', 'Busness category2');

-- --------------------------------------------------------

--
-- Структура таблицы `persons`
--

DROP TABLE IF EXISTS `persons`;
CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` char(128) NOT NULL,
  `about_me` mediumtext,
  `age` int(11) DEFAULT NULL,
  `children` mediumtext,
  `date_of_birth` int(11) DEFAULT NULL,
  `gender` enum('MALE','FEMALE') DEFAULT NULL,
  `job_interests` mediumtext,
  `living_arrangement` mediumtext,
  `looking_for` mediumtext,
  `nickname` char(128) DEFAULT NULL,
  `pets` mediumtext,
  `political_views` mediumtext,
  `profile_song` char(128) DEFAULT NULL,
  `profile_url` char(128) DEFAULT NULL,
  `profile_video` char(128) DEFAULT NULL,
  `relationship_status` char(128) DEFAULT NULL,
  `smoker` enum('HEAVILY','NO','OCCASIONALLY','QUIT','QUITTING','REGULARLY','SOCIALLY','YES') DEFAULT NULL,
  `status` char(250) DEFAULT NULL,
  `thumbnail_url` char(128) DEFAULT NULL,
  `time_zone` int(11) DEFAULT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `uploaded_size` int(11) DEFAULT '0',
  `thumbnail_url_big` varchar(255) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `lang` varchar(3) DEFAULT NULL,
  `is_activated` int(11) NOT NULL DEFAULT '0',
  `activation_code` varchar(32) DEFAULT NULL,
  `country_content_code2` varchar(2) DEFAULT NULL,
  `password_code` varchar(32) DEFAULT NULL,
  `job` varchar(250) DEFAULT NULL,
  `drinker` enum('HEAVILY','NO','OCCASIONALLY','QUIT','QUITTING','REGULARLY','SOCIALLY','YES') DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `country_code2` varchar(2) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `last_online` int(11) DEFAULT NULL,
  `isoffline` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`),
  KEY `email` (`email`),
  KEY `activity` (`activity`),
  KEY `lang` (`lang`),
  KEY `is_activated` (`is_activated`,`activation_code`,`country_content_code2`),
  KEY `password_code` (`password_code`),
  KEY `city` (`city`),
  KEY `country_code2` (`country_code2`,`street`),
  KEY `last_online` (`last_online`),
  KEY `isoffline` (`isoffline`),
  KEY `phone` (`phone`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `persons`
--

INSERT INTO `persons` (`id`, `email`, `password`, `about_me`, `age`, `children`, `date_of_birth`, `gender`, `job_interests`, `living_arrangement`, `looking_for`, `nickname`, `pets`, `political_views`, `profile_song`, `profile_url`, `profile_video`, `relationship_status`, `smoker`, `status`, `thumbnail_url`, `time_zone`, `first_name`, `last_name`, `uploaded_size`, `thumbnail_url_big`, `activity`, `lang`, `is_activated`, `activation_code`, `country_content_code2`, `password_code`, `job`, `drinker`, `city`, `country_code2`, `street`, `last_online`, `isoffline`, `phone`) VALUES
(5, 'sveta.galleon@gmail.com', '*B201625302CDBA97C12F8854D71B8A28167524C6', NULL, NULL, NULL, 573771601, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Светлана', 'Миронова', 0, NULL, NULL, NULL, 1, 'comiron513dd1125dc15513dd1125dc1', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'anton.galleon@gmail.com', '*8F5ACA32B98EE88607D17772C1B9E2383D710901', '', NULL, NULL, 581112001, 'MALE', '', NULL, NULL, '', '', '', NULL, NULL, NULL, 'Married', NULL, NULL, '/images/people/14.205x205.gif', NULL, 'Korben', 'Dallas', 0, '/images/people/14.205x205.gif', '', 'ru', 1, '5b3304f59546c5a81fb9c04b6f85230c', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'cycland@mail.ru', '*5FDCF0F2FF83DF088353DB1E0AEC2155ED103754', '', NULL, NULL, 525038401, 'MALE', '', NULL, NULL, '', '', '', NULL, NULL, NULL, 'Married', 'NO', NULL, '/images/people/13.205x205.jpg', NULL, 'Михаил', 'Николаев', 0, '/images/people/13.205x205.jpg', '', NULL, 1, '675c5e5ca9487e2fdf168ceeaeb187a6', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'support@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', '', NULL, '2', 1391295601, 'FEMALE', '', NULL, NULL, '', '', '', NULL, NULL, NULL, 'Married', 'NO', 'статус', '/images/people/12.205x205.png', NULL, 'Anastasiya', 'Deeva', 0, '/images/people/12.205x205.png', '', 'ru', 1, 'bd8b28404b5e2f5257589fa571c45b2e', 'RU', '', 'креограф', 'OCCASIONALLY', 'Челябинск', 'RU', 'Солнечная 12а', 1402386664, 1, NULL),
(15, 'nastya@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 434667601, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Анастасия', 'Деева', 0, NULL, NULL, NULL, 1, '6f65b1b9d1fbbbaf01227740b5f29221', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1402386697, 1, NULL),
(16, 'spavlov.gt@gmail.com', '*E1B158A79811EF2608BCF607CA6D1D4B7749837E', NULL, NULL, NULL, 412894801, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sergey', 'Pavlov', 0, NULL, NULL, NULL, 1, '9f22f8a93e218efd6c279e62d966f7cc', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'babichev.e@gmail.com', '*8C989DAFBCEF1A662E0E25BB7DAAEECEB16FF095', NULL, NULL, NULL, 490996801, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Евгений', 'Бабичев', 0, NULL, NULL, NULL, 0, 'a8556eae89036b793e9c32be518fa6b4', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'ichabanenko@yandex.ru', '*CFFBB2309C5457AA251A5EE459F12E4A01D54CA2', '', NULL, NULL, 936820801, 'FEMALE', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ирина', 'Чабаненко', 0, NULL, '', NULL, 1, '522d4a23174f3cdecf21d113049c657a', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'zakup.elena@gmail.com', '*1F12D631ADD6F0F2C8E54A552DB9C0F445BD0B8D', '', NULL, NULL, 942181201, 'FEMALE', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ел.', 'Гр.', 0, NULL, '', NULL, 0, 'd98b7bcb3d4fb45cd9f8b79eefdc2af0', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'kesainiya@gmail.com', '*AE977E21C9C20F7F0EDBD80CBFD8C0298BA24F80', '', NULL, NULL, 716493601, 'FEMALE', '', NULL, NULL, 'Kesainiya', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '/images/people/20.205x205.jpg', NULL, 'Ksenia', 'Mironova', 0, '/images/people/20.205x205.jpg', '', NULL, 1, '7204587abd970f9e09cbf51cb201cdd0', 'RU', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'galeontrade@gmail.com', '*79CD53076F022A04BBAB0C59CAEC7D1E77E7B22E', NULL, NULL, NULL, -113713199, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Вячеслав', 'Миронов', 0, NULL, NULL, NULL, 1, 'f219ad4925b02568428ad26dcd520278', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'forester2008@ya.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 163364401, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vitaliy', 'Deev', 0, NULL, NULL, NULL, 0, '69827d2e128d6ebcc9d1e3b06bd36a96', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'zeropatriot@mail.ru', '*6964151931D3CC09DB945558273EBFC000276032', NULL, NULL, NULL, 510008401, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Андрей', 'Силаев', 0, NULL, NULL, NULL, 0, 'c096152f54712aa8a5e80e4644aa6712', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'oleggaleon@gmail.com', '*39A7B5ADAFB175501154A7D7E0C27633E4A6DCE5', NULL, NULL, NULL, 1369512001, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Олег', 'Буталов', 0, NULL, NULL, NULL, 1, '4627a4d36d91b639880c698dacb30ea2', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'support.ru@comiron.com', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', 'Пресс центр', 20, NULL, 943916401, NULL, '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, '', '/images/people/1.205x205.png', NULL, 'Пресс-центр', '', 0, '/images/people/1.205x205.png', NULL, NULL, 1, NULL, 'RU', NULL, NULL, NULL, '', 'RU', '', 1378360766, 1, NULL),
(2, 'support.en@comiron.com', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', 'technical support', NULL, NULL, -3599, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '/images/people/2.205x205.png', NULL, 'Press center', '', 0, '/images/people/2.205x205.png', NULL, NULL, 1, NULL, 'US', NULL, NULL, NULL, '', 'US', '', 1386878130, 1, NULL),
(3, 'support.ch@comiron.com', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', 'China support', NULL, NULL, -3599, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '/images/people/3.205x205.png', NULL, 'Press center', '', 0, '/images/people/3.205x205.png', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '', 'CN', '', 1378269472, 1, NULL),
(4, 'support.it@comiron.com', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', 'Italian support', NULL, NULL, -3599, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '/images/people/4.205x205.png', NULL, 'Press center', '', 0, '/images/people/4.205x205.png', NULL, NULL, 1, NULL, 'IT', NULL, NULL, NULL, '', 'IT', '', 1378269502, 1, NULL),
(25, 'lera@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, -1114822799, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123123', '123123', 0, NULL, NULL, NULL, 0, '60bd19a405ab9b27af1ec0e9e968471f', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1380712414, 0, NULL),
(26, 'lera2@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 1378850401, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123123', '123123123', 0, NULL, NULL, NULL, 0, '7a5f204b57effcf20bda29fe0c9b460d', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1385668016, 1, NULL),
(27, 'ler3@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 1378159201, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Qweqwe', 'Qweqwe', 0, NULL, NULL, NULL, 0, '37709c0c4aa11a9c79f0be3a012f814c', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1378369357, 1, NULL),
(28, 'lera6@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 1378159201, 'MALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123123', '123123', 0, NULL, NULL, NULL, 0, 'fa7007cc4f7879981936bc46f8baaee5', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1378369943, 1, NULL),
(29, 'anton.galleo2n@gmail.com', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 1386025201, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123123', '123123', 0, NULL, NULL, NULL, 0, '6d4d3afea2d5bb7d8429656c77a7e652', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1387361519, 1, NULL),
(30, 'office@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 434660401, 'FEMALE', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '/images/people/30.205x205.jpg', NULL, 'Анастасия', 'Деева', 0, '/images/people/30.205x205.jpg', NULL, 'ru', 1, 'fcb78fc73d880018b85b74f5a3ca067b', 'RU', NULL, NULL, NULL, '', 'RU', '', 1404727956, 0, NULL),
(31, 'support123@creograf.ru', '*8DCDD69CE7D121DE8013062AEAEB2A148910D50E', NULL, NULL, NULL, -871534799, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Name', 'Test', 0, NULL, NULL, NULL, 0, 'f7f7c8c6f88a6baaa6c987339f8c0fe0', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1401187513, 1, NULL),
(32, 'support1234@creograf.ru', '*050376F3855A67F5E2C6514FD3130B31006C1276', NULL, NULL, NULL, -1030078799, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Weqwe', 'Qweqwe', 0, NULL, NULL, NULL, 0, '8d146fcb47ca6578b3cb7665c6d5ec90', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1401187596, 1, NULL),
(33, 'support1235@creograf.ru', '*A350F41CBC02FA953288C4BDE7CD10AE69DF6D4A', NULL, NULL, NULL, 1398880801, 'FEMALE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', '123', 0, NULL, NULL, NULL, 0, 'da2e6902930242168bc4cf09c1959581', 'RU', NULL, NULL, NULL, NULL, NULL, NULL, 1402379005, 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `person_activities`
--

DROP TABLE IF EXISTS `person_activities`;
CREATE TABLE IF NOT EXISTS `person_activities` (
  `person_id` int(11) NOT NULL,
  `activity` char(128) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_activities`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_addresses`
--

DROP TABLE IF EXISTS `person_addresses`;
CREATE TABLE IF NOT EXISTS `person_addresses` (
  `person_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_addresses`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_applications`
--

DROP TABLE IF EXISTS `person_applications`;
CREATE TABLE IF NOT EXISTS `person_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `application_id` (`application_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `person_applications`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_body_type`
--

DROP TABLE IF EXISTS `person_body_type`;
CREATE TABLE IF NOT EXISTS `person_body_type` (
  `person_id` int(11) NOT NULL,
  `build` char(64) DEFAULT NULL,
  `eye_color` char(64) DEFAULT NULL,
  `hair_color` char(64) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_body_type`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_books`
--

DROP TABLE IF EXISTS `person_books`;
CREATE TABLE IF NOT EXISTS `person_books` (
  `person_id` int(11) NOT NULL,
  `book` char(128) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_books`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_cars`
--

DROP TABLE IF EXISTS `person_cars`;
CREATE TABLE IF NOT EXISTS `person_cars` (
  `person_id` int(11) NOT NULL,
  `car` char(128) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_cars`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_current_location`
--

DROP TABLE IF EXISTS `person_current_location`;
CREATE TABLE IF NOT EXISTS `person_current_location` (
  `person_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_current_location`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_education`
--

DROP TABLE IF EXISTS `person_education`;
CREATE TABLE IF NOT EXISTS `person_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `city` char(250) DEFAULT NULL,
  `country` char(250) DEFAULT NULL,
  `name` char(250) DEFAULT NULL,
  `class` char(250) DEFAULT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `type` enum('1school','2college','3univer') DEFAULT NULL,
  KEY `id` (`id`),
  KEY `person_id` (`person_id`),
  KEY `to` (`to`),
  KEY `name` (`name`),
  KEY `class` (`class`),
  KEY `country` (`country`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `person_education`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_emails`
--

DROP TABLE IF EXISTS `person_emails`;
CREATE TABLE IF NOT EXISTS `person_emails` (
  `person_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  KEY `person_id` (`person_id`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_emails`
--

INSERT INTO `person_emails` (`person_id`, `email`) VALUES
(14, 'anton.galleon@gmail.com\r'),
(12, 'nastya@creograf.ru\r');

-- --------------------------------------------------------

--
-- Структура таблицы `person_food`
--

DROP TABLE IF EXISTS `person_food`;
CREATE TABLE IF NOT EXISTS `person_food` (
  `person_id` int(11) NOT NULL,
  `food` char(128) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_food`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_heroes`
--

DROP TABLE IF EXISTS `person_heroes`;
CREATE TABLE IF NOT EXISTS `person_heroes` (
  `person_id` int(11) NOT NULL,
  `hero` char(128) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_heroes`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_interests`
--

DROP TABLE IF EXISTS `person_interests`;
CREATE TABLE IF NOT EXISTS `person_interests` (
  `person_id` int(11) NOT NULL,
  `intrest` char(128) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_interests`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_jobs`
--

DROP TABLE IF EXISTS `person_jobs`;
CREATE TABLE IF NOT EXISTS `person_jobs` (
  `person_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  KEY `person_id` (`person_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_jobs`
--

INSERT INTO `person_jobs` (`person_id`, `organization_id`, `name`) VALUES
(12, 0, 'Креограф');

-- --------------------------------------------------------

--
-- Структура таблицы `person_languages_spoken`
--

DROP TABLE IF EXISTS `person_languages_spoken`;
CREATE TABLE IF NOT EXISTS `person_languages_spoken` (
  `person_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_languages_spoken`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_movies`
--

DROP TABLE IF EXISTS `person_movies`;
CREATE TABLE IF NOT EXISTS `person_movies` (
  `person_id` int(11) NOT NULL,
  `movie` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_movies`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_music`
--

DROP TABLE IF EXISTS `person_music`;
CREATE TABLE IF NOT EXISTS `person_music` (
  `person_id` int(11) NOT NULL,
  `music` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_music`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_organization`
--

DROP TABLE IF EXISTS `person_organization`;
CREATE TABLE IF NOT EXISTS `person_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `job` varchar(255) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`,`organization_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `person_organization`
--

INSERT INTO `person_organization` (`id`, `person_id`, `organization_id`, `job`, `shop_id`) VALUES
(6, 13, 21, '', NULL),
(7, 14, 22, '', 13),
(8, 30, 23, '', 14),
(9, 12, 24, '', 15);

-- --------------------------------------------------------

--
-- Структура таблицы `person_phone_numbers`
--

DROP TABLE IF EXISTS `person_phone_numbers`;
CREATE TABLE IF NOT EXISTS `person_phone_numbers` (
  `person_id` int(11) NOT NULL,
  `phone_number` char(64) DEFAULT NULL,
  `number_type` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_phone_numbers`
--

INSERT INTO `person_phone_numbers` (`person_id`, `phone_number`, `number_type`) VALUES
(14, '8-909-088-74-50\r', NULL),
(12, '123123 123123', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `person_quotes`
--

DROP TABLE IF EXISTS `person_quotes`;
CREATE TABLE IF NOT EXISTS `person_quotes` (
  `person_id` int(11) NOT NULL,
  `quote` mediumtext,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_quotes`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_schools`
--

DROP TABLE IF EXISTS `person_schools`;
CREATE TABLE IF NOT EXISTS `person_schools` (
  `person_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_schools`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_sports`
--

DROP TABLE IF EXISTS `person_sports`;
CREATE TABLE IF NOT EXISTS `person_sports` (
  `person_id` int(11) NOT NULL,
  `sport` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_sports`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_tags`
--

DROP TABLE IF EXISTS `person_tags`;
CREATE TABLE IF NOT EXISTS `person_tags` (
  `person_id` int(11) NOT NULL,
  `tag` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_tags`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_turn_offs`
--

DROP TABLE IF EXISTS `person_turn_offs`;
CREATE TABLE IF NOT EXISTS `person_turn_offs` (
  `person_id` int(11) NOT NULL,
  `turn_off` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_turn_offs`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_turn_ons`
--

DROP TABLE IF EXISTS `person_turn_ons`;
CREATE TABLE IF NOT EXISTS `person_turn_ons` (
  `person_id` int(11) NOT NULL,
  `turn_on` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_turn_ons`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_tv_shows`
--

DROP TABLE IF EXISTS `person_tv_shows`;
CREATE TABLE IF NOT EXISTS `person_tv_shows` (
  `person_id` int(11) NOT NULL,
  `tv_show` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_tv_shows`
--


-- --------------------------------------------------------

--
-- Структура таблицы `person_urls`
--

DROP TABLE IF EXISTS `person_urls`;
CREATE TABLE IF NOT EXISTS `person_urls` (
  `person_id` int(11) NOT NULL,
  `url` char(128) DEFAULT NULL,
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `person_urls`
--


-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `price` decimal(19,2) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `thumbnail_url` varchar(250) DEFAULT NULL,
  `ordr` int(11) DEFAULT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  `isspecial` int(11) NOT NULL DEFAULT '0',
  `likes_num` int(11) NOT NULL DEFAULT '0',
  `comment_num` int(11) NOT NULL DEFAULT '0',
  `shares_num` int(11) NOT NULL DEFAULT '0',
  `photo_url` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`,`currency_id`),
  KEY `ordr` (`ordr`,`visible`),
  KEY `isspecial` (`isspecial`),
  KEY `likes_num` (`likes_num`),
  KEY `comment_num` (`comment_num`,`shares_num`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=148 ;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `shop_id`, `name`, `price`, `currency_id`, `thumbnail_url`, `ordr`, `visible`, `isspecial`, `likes_num`, `comment_num`, `shares_num`, `photo_url`, `code`) VALUES
(12, 13, 'Модульный дом ДВА этажа - 4 секции', 750000.00, NULL, NULL, 1, 1, 0, 0, 1, 0, NULL, NULL),
(13, 13, 'Дом супер', 500000.00, NULL, NULL, 2, 1, 0, 0, 0, 0, NULL, NULL),
(15, 14, 'dfgdfgs dfgdsf gdfg', 123.00, 1, '/images/product/15.205x205.png', 1, 5, 1, 0, 1, 0, '/images/product/15.png', NULL),
(16, 14, 'футболка', 500.00, 2, '/images/product/16.205x205.png', 2, 2, 1, 0, 0, 0, '/images/product/16.png', NULL),
(17, 14, 'цвфы вфыв фыв', 12.00, 2, '/images/product/17.205x205.png', 3, 0, 0, 0, 0, 0, '/images/product/17.png', NULL),
(20, 14, 'fd', 0.00, 2, '/images/product/20.205x205.png', 6, 5, 0, 0, 0, 0, '/images/product/20.png', NULL),
(21, 14, 'ыва', 123.00, 2, '/images/product/21.205x205.png', 7, 5, 1, 0, 0, 0, '/images/product/21.png', NULL),
(47, 14, NULL, NULL, NULL, NULL, 11, -1, 0, 0, 0, 0, NULL, NULL),
(46, 14, NULL, NULL, NULL, NULL, 10, -1, 0, 0, 0, 0, NULL, NULL),
(44, 14, NULL, NULL, NULL, NULL, 8, -1, 0, 0, 0, 0, NULL, NULL),
(45, 14, 'название', 123.12, 2, '/images/product/45.205x205.png', 9, 5, 0, 1, 0, 0, '/images/product/45.png', NULL),
(48, 14, NULL, NULL, NULL, NULL, 12, -1, 0, 0, 0, 0, NULL, NULL),
(49, 14, NULL, NULL, NULL, NULL, 13, -1, 0, 0, 0, 0, NULL, NULL),
(50, 14, NULL, NULL, NULL, NULL, 14, -1, 0, 0, 0, 0, NULL, NULL),
(51, 14, NULL, NULL, NULL, NULL, 15, -1, 0, 0, 0, 0, NULL, NULL),
(52, 14, NULL, NULL, NULL, NULL, 16, -1, 0, 0, 0, 0, NULL, NULL),
(53, 14, NULL, NULL, NULL, NULL, 17, -1, 0, 0, 0, 0, NULL, NULL),
(54, 14, NULL, NULL, NULL, NULL, 18, -1, 0, 0, 0, 0, NULL, NULL),
(55, 14, NULL, NULL, NULL, NULL, 19, -1, 0, 0, 0, 0, NULL, NULL),
(56, 14, NULL, NULL, NULL, NULL, 20, -1, 0, 0, 0, 0, NULL, NULL),
(57, 14, NULL, NULL, NULL, NULL, 21, -1, 0, 0, 0, 0, NULL, NULL),
(58, 14, NULL, NULL, NULL, NULL, 22, -1, 0, 0, 0, 0, NULL, NULL),
(59, 14, NULL, NULL, NULL, NULL, 23, -1, 0, 0, 0, 0, NULL, NULL),
(60, 14, NULL, NULL, NULL, NULL, 24, -1, 0, 0, 0, 0, NULL, NULL),
(61, 14, NULL, NULL, NULL, NULL, 25, -1, 0, 0, 0, 0, NULL, NULL),
(62, 14, NULL, NULL, NULL, NULL, 26, -1, 0, 0, 0, 0, NULL, NULL),
(63, 14, NULL, NULL, NULL, NULL, 27, -1, 0, 0, 0, 0, NULL, NULL),
(64, 14, NULL, NULL, NULL, NULL, 28, -1, 0, 0, 0, 0, NULL, NULL),
(65, 14, NULL, NULL, NULL, NULL, 29, -1, 0, 0, 0, 0, NULL, NULL),
(66, 14, NULL, NULL, NULL, NULL, 30, -1, 0, 0, 0, 0, NULL, NULL),
(67, 14, NULL, NULL, NULL, NULL, 31, -1, 0, 0, 0, 0, NULL, NULL),
(68, 14, NULL, NULL, NULL, NULL, 32, -1, 0, 0, 0, 0, NULL, NULL),
(69, 14, NULL, NULL, NULL, NULL, 33, -1, 0, 0, 0, 0, NULL, NULL),
(70, 14, NULL, NULL, NULL, NULL, 34, -1, 0, 0, 0, 0, NULL, NULL),
(71, 14, NULL, NULL, NULL, NULL, 35, -1, 0, 0, 0, 0, NULL, NULL),
(72, 14, NULL, NULL, NULL, NULL, 36, -1, 0, 0, 0, 0, NULL, NULL),
(73, 14, NULL, NULL, NULL, NULL, 37, -1, 0, 0, 0, 0, NULL, NULL),
(74, 14, NULL, NULL, NULL, NULL, 38, -1, 0, 0, 0, 0, NULL, NULL),
(75, 14, NULL, NULL, NULL, NULL, 39, -1, 0, 0, 0, 0, NULL, NULL),
(76, 14, NULL, NULL, NULL, NULL, 40, -1, 0, 0, 0, 0, NULL, NULL),
(77, 14, NULL, NULL, NULL, NULL, 41, -1, 0, 0, 0, 0, NULL, NULL),
(78, 14, NULL, NULL, NULL, NULL, 42, -1, 0, 0, 0, 0, NULL, NULL),
(79, 14, NULL, NULL, NULL, NULL, 43, -1, 0, 0, 0, 0, NULL, NULL),
(80, 14, NULL, NULL, NULL, NULL, 44, -1, 0, 0, 0, 0, NULL, NULL),
(81, 14, NULL, NULL, NULL, NULL, 45, -1, 0, 0, 0, 0, NULL, NULL),
(82, 14, NULL, NULL, NULL, '/images/product/82.205x205.png', 46, -1, 0, 0, 0, 0, '/images/product/82.png', NULL),
(83, 14, NULL, NULL, NULL, '/images/product/83.205x205.png', 47, -1, 0, 0, 0, 0, '/images/product/83.png', NULL),
(84, 14, NULL, NULL, NULL, NULL, 48, -1, 0, 0, 0, 0, NULL, NULL),
(85, 14, NULL, NULL, NULL, NULL, 49, -1, 0, 0, 0, 0, NULL, NULL),
(86, 14, NULL, NULL, NULL, NULL, 50, -1, 0, 0, 0, 0, NULL, NULL),
(87, 14, NULL, NULL, NULL, NULL, 51, -1, 0, 0, 0, 0, NULL, NULL),
(88, 14, NULL, NULL, NULL, NULL, 52, -1, 0, 0, 0, 0, NULL, NULL),
(89, 14, NULL, NULL, NULL, NULL, 53, -1, 0, 0, 0, 0, NULL, NULL),
(90, 14, NULL, NULL, NULL, NULL, 54, -1, 0, 0, 0, 0, NULL, NULL),
(91, 14, NULL, NULL, NULL, NULL, 55, -1, 0, 0, 0, 0, NULL, NULL),
(92, 14, NULL, NULL, NULL, NULL, 56, -1, 0, 0, 0, 0, NULL, NULL),
(93, 14, NULL, NULL, NULL, NULL, 57, -1, 0, 0, 0, 0, NULL, NULL),
(94, 14, NULL, NULL, NULL, NULL, 58, -1, 0, 0, 0, 0, NULL, NULL),
(95, 14, NULL, NULL, NULL, NULL, 59, -1, 0, 0, 0, 0, NULL, NULL),
(96, 14, NULL, NULL, NULL, NULL, 60, -1, 0, 0, 0, 0, NULL, NULL),
(97, 14, NULL, NULL, NULL, NULL, 61, -1, 0, 0, 0, 0, NULL, NULL),
(98, 14, NULL, NULL, NULL, NULL, 62, -1, 0, 0, 0, 0, NULL, NULL),
(99, 14, NULL, NULL, NULL, NULL, 63, -1, 0, 0, 0, 0, NULL, NULL),
(100, 14, NULL, NULL, NULL, NULL, 64, -1, 0, 0, 0, 0, NULL, NULL),
(101, 14, NULL, NULL, NULL, NULL, 65, -1, 0, 0, 0, 0, NULL, NULL),
(102, 14, NULL, NULL, NULL, NULL, 66, -1, 0, 0, 0, 0, NULL, NULL),
(103, 14, NULL, NULL, NULL, NULL, 67, -1, 0, 0, 0, 0, NULL, NULL),
(104, 14, NULL, NULL, NULL, NULL, 68, -1, 0, 0, 0, 0, NULL, NULL),
(105, 14, NULL, NULL, NULL, NULL, 69, -1, 0, 0, 0, 0, NULL, NULL),
(106, 14, NULL, NULL, NULL, NULL, 70, -1, 0, 0, 0, 0, NULL, NULL),
(107, 14, NULL, NULL, NULL, NULL, 71, -1, 0, 0, 0, 0, NULL, NULL),
(108, 14, NULL, NULL, NULL, NULL, 72, -1, 0, 0, 0, 0, NULL, NULL),
(109, 14, NULL, NULL, NULL, NULL, 73, -1, 0, 0, 0, 0, NULL, NULL),
(110, 14, NULL, NULL, NULL, NULL, 74, -1, 0, 0, 0, 0, NULL, NULL),
(111, 14, NULL, NULL, NULL, NULL, 75, -1, 0, 0, 0, 0, NULL, NULL),
(112, 14, NULL, NULL, NULL, NULL, 76, -1, 0, 0, 0, 0, NULL, NULL),
(113, 14, NULL, NULL, NULL, NULL, 77, -1, 0, 0, 0, 0, NULL, NULL),
(114, 14, NULL, NULL, NULL, NULL, 78, -1, 0, 0, 0, 0, NULL, NULL),
(115, 14, NULL, NULL, NULL, NULL, 79, -1, 0, 0, 0, 0, NULL, NULL),
(116, 14, NULL, NULL, NULL, NULL, 80, -1, 0, 0, 0, 0, NULL, NULL),
(117, 14, NULL, NULL, NULL, NULL, 81, -1, 0, 0, 0, 0, NULL, NULL),
(118, 14, NULL, NULL, NULL, NULL, 82, -1, 0, 0, 0, 0, NULL, NULL),
(119, 14, NULL, NULL, NULL, NULL, 83, -1, 0, 0, 0, 0, NULL, NULL),
(120, 14, NULL, NULL, NULL, NULL, 84, -1, 0, 0, 0, 0, NULL, NULL),
(121, 14, NULL, NULL, NULL, NULL, 85, -1, 0, 0, 0, 0, NULL, NULL),
(122, 14, NULL, NULL, NULL, NULL, 86, -1, 0, 0, 0, 0, NULL, NULL),
(123, 14, NULL, NULL, NULL, NULL, 87, -1, 0, 0, 0, 0, NULL, NULL),
(124, 14, NULL, NULL, NULL, NULL, 88, -1, 0, 0, 0, 0, NULL, NULL),
(125, 14, NULL, NULL, NULL, NULL, 89, -1, 0, 0, 0, 0, NULL, NULL),
(126, 14, NULL, NULL, NULL, NULL, 90, -1, 0, 0, 0, 0, NULL, NULL),
(127, 14, NULL, NULL, NULL, NULL, 91, -1, 0, 0, 0, 0, NULL, NULL),
(128, 14, NULL, NULL, NULL, NULL, 92, -1, 0, 0, 0, 0, NULL, NULL),
(129, 14, NULL, NULL, NULL, NULL, 93, -1, 0, 0, 0, 0, NULL, NULL),
(130, 14, NULL, NULL, NULL, NULL, 94, -1, 0, 0, 0, 0, NULL, NULL),
(131, 14, NULL, NULL, NULL, NULL, 95, -1, 0, 0, 0, 0, NULL, NULL),
(132, 14, NULL, NULL, NULL, NULL, 96, -1, 0, 0, 0, 0, NULL, NULL),
(133, 14, NULL, NULL, NULL, NULL, 97, -1, 0, 0, 0, 0, NULL, NULL),
(134, 14, NULL, NULL, NULL, NULL, 98, -1, 0, 0, 0, 0, NULL, NULL),
(135, 14, NULL, NULL, NULL, NULL, 99, -1, 0, 0, 0, 0, NULL, NULL),
(136, 14, NULL, NULL, NULL, NULL, 100, -1, 0, 0, 0, 0, NULL, NULL),
(137, 14, NULL, NULL, NULL, NULL, 101, -1, 0, 0, 0, 0, NULL, NULL),
(138, 14, NULL, NULL, NULL, NULL, 102, -1, 0, 0, 0, 0, NULL, NULL),
(139, 14, NULL, NULL, NULL, NULL, 103, -1, 0, 0, 0, 0, NULL, NULL),
(140, 14, NULL, NULL, NULL, NULL, 104, -1, 0, 0, 0, 0, NULL, NULL),
(141, 14, NULL, NULL, NULL, NULL, 105, -1, 0, 0, 0, 0, NULL, NULL),
(142, 14, NULL, NULL, NULL, NULL, 106, -1, 0, 0, 0, 0, NULL, NULL),
(143, 14, NULL, NULL, NULL, NULL, 107, -1, 0, 0, 0, 0, NULL, NULL),
(144, 14, NULL, NULL, NULL, NULL, 108, -1, 0, 0, 0, 0, NULL, NULL),
(145, 14, '', 0.00, 2, NULL, 109, 5, 0, 0, 0, 0, NULL, NULL),
(146, 14, NULL, NULL, NULL, NULL, 110, -1, 0, 0, 0, 0, NULL, NULL),
(147, 14, NULL, NULL, NULL, NULL, 111, -1, 0, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `product_access`
--

DROP TABLE IF EXISTS `product_access`;
CREATE TABLE IF NOT EXISTS `product_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shopusergroup_id` int(11) NOT NULL,
  `access` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

--
-- Дамп данных таблицы `product_access`
--

INSERT INTO `product_access` (`id`, `shop_id`, `product_id`, `shopusergroup_id`, `access`) VALUES
(55, 14, 15, 4, 1),
(56, 14, 15, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) DEFAULT NULL,
  `name_ru` varchar(255) DEFAULT NULL,
  `country_id` int(11) NOT NULL,
  `ordr` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`,`ordr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `region`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shares`
--

DROP TABLE IF EXISTS `shares`;
CREATE TABLE IF NOT EXISTS `shares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `object_name` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `object_id` (`object_id`,`object_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `shares`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop`
--

DROP TABLE IF EXISTS `shop`;
CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `organization_id` int(11) DEFAULT NULL,
  `shoptemplate_id` int(11) DEFAULT NULL,
  `thumbnail_url` varchar(250) DEFAULT NULL,
  `thumbnail_big_url` varchar(250) DEFAULT NULL,
  `admin_email` varchar(250) DEFAULT NULL,
  `order_email` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `ismall` int(11) NOT NULL DEFAULT '0',
  `add2client` varchar(50) DEFAULT 'options_add_2_friend_auto',
  `options_product` int(6) NOT NULL DEFAULT '0',
  `options_price` int(6) NOT NULL DEFAULT '0',
  `options_comment` int(6) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `organization_id` (`organization_id`,`shoptemplate_id`),
  KEY `ismall` (`ismall`),
  KEY `add2client` (`add2client`),
  KEY `add2client_2` (`add2client`),
  KEY `options_product` (`options_product`,`options_price`,`options_comment`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `shop`
--

INSERT INTO `shop` (`id`, `person_id`, `organization_id`, `shoptemplate_id`, `thumbnail_url`, `thumbnail_big_url`, `admin_email`, `order_email`, `name`, `currency_id`, `ismall`, `add2client`, `options_product`, `options_price`, `options_comment`) VALUES
(13, 14, 22, NULL, NULL, NULL, 'anton.galleon@gmail.com', 'anton.galleon@gmail.com', 'Модульный Дом', NULL, 0, 'options_add_2_friend_req', 0, 0, 2),
(14, 30, 23, NULL, '/images/shop/14.205x205.jpg', '/images/shop/14.205x205.jpg', 'support@creograf.ru', 'support@creograf.ru', 'shop', 2, 0, 'options_add_2_friend_req', 0, 0, 3),
(15, 12, 24, NULL, '/images/product/15.205x205.png', '/images/product/15.205x205.png', 'support@creograf.ru', 'support@creograf.ru', 'Магазин', NULL, 0, 'options_add_2_friend_auto', 0, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_access`
--

DROP TABLE IF EXISTS `shop_access`;
CREATE TABLE IF NOT EXISTS `shop_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `shopusergroup_id` int(11) NOT NULL,
  `access_type` enum('price','product') DEFAULT NULL,
  `access` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `shop_access`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_addresses`
--

DROP TABLE IF EXISTS `shop_addresses`;
CREATE TABLE IF NOT EXISTS `shop_addresses` (
  `shop_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_addresses`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_clients`
--

DROP TABLE IF EXISTS `shop_clients`;
CREATE TABLE IF NOT EXISTS `shop_clients` (
  `shop_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `issuperclient` int(1) NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0',
  `isnew` int(11) NOT NULL DEFAULT '0',
  `discounthidden` float NOT NULL DEFAULT '0',
  `sum` float DEFAULT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `last` int(11) DEFAULT NULL,
  KEY `shop_id` (`shop_id`,`client_id`),
  KEY `client_id` (`client_id`),
  KEY `isnew` (`isnew`),
  KEY `sum` (`sum`,`num`,`last`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_clients`
--

INSERT INTO `shop_clients` (`shop_id`, `client_id`, `issuperclient`, `discount`, `isnew`, `discounthidden`, `sum`, `num`, `last`) VALUES
(14, 30, 0, 30, 0, 5, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_client_requests`
--

DROP TABLE IF EXISTS `shop_client_requests`;
CREATE TABLE IF NOT EXISTS `shop_client_requests` (
  `shop_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  KEY `shop_id` (`shop_id`,`client_id`),
  KEY `shop_id_2` (`shop_id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_client_requests`
--

INSERT INTO `shop_client_requests` (`shop_id`, `client_id`) VALUES
(13, 30);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_emails`
--

DROP TABLE IF EXISTS `shop_emails`;
CREATE TABLE IF NOT EXISTS `shop_emails` (
  `shop_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  KEY `shop_id` (`shop_id`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_emails`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_page`
--

DROP TABLE IF EXISTS `shop_page`;
CREATE TABLE IF NOT EXISTS `shop_page` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  `ordr` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`,`visible`,`ordr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_page`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_phone_numbers`
--

DROP TABLE IF EXISTS `shop_phone_numbers`;
CREATE TABLE IF NOT EXISTS `shop_phone_numbers` (
  `shop_id` int(11) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `number_type` varchar(255) DEFAULT NULL,
  KEY `shop_id` (`shop_id`,`phone_number`),
  KEY `number_type` (`number_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_phone_numbers`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_tags`
--

DROP TABLE IF EXISTS `shop_tags`;
CREATE TABLE IF NOT EXISTS `shop_tags` (
  `shop_id` int(11) NOT NULL,
  `tag` char(128) DEFAULT NULL,
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_tags`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_templates`
--

DROP TABLE IF EXISTS `shop_templates`;
CREATE TABLE IF NOT EXISTS `shop_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cssfile` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `thumbnail_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `shop_templates`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_urls`
--

DROP TABLE IF EXISTS `shop_urls`;
CREATE TABLE IF NOT EXISTS `shop_urls` (
  `shop_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `shop_urls`
--


-- --------------------------------------------------------

--
-- Структура таблицы `shop_usergroup`
--

DROP TABLE IF EXISTS `shop_usergroup`;
CREATE TABLE IF NOT EXISTS `shop_usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `shop_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `shop_usergroup`
--

INSERT INTO `shop_usergroup` (`id`, `name`, `shop_id`) VALUES
(4, 'группа 1', 14),
(5, 'группа 2', 14),
(6, 'группа 3', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `shop_usergroup_client`
--

DROP TABLE IF EXISTS `shop_usergroup_client`;
CREATE TABLE IF NOT EXISTS `shop_usergroup_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `usergroup_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_id` (`shop_id`),
  KEY `usergroup_id` (`usergroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `shop_usergroup_client`
--

INSERT INTO `shop_usergroup_client` (`id`, `shop_id`, `usergroup_id`, `client_id`) VALUES
(3, 14, 4, 30),
(4, 14, 6, 30);

-- --------------------------------------------------------

--
-- Структура таблицы `wall`
--

DROP TABLE IF EXISTS `wall`;
CREATE TABLE IF NOT EXISTS `wall` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) NOT NULL,
  `object_name` varchar(80) NOT NULL,
  `time` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `person_to_id` int(11) NOT NULL,
  `status` enum('new','deleted') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_id` (`object_id`,`object_name`),
  KEY `person_id` (`person_id`),
  KEY `person_to_id` (`person_to_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

--
-- Дамп данных таблицы `wall`
--

INSERT INTO `wall` (`id`, `object_id`, `object_name`, `time`, `person_id`, `person_to_id`, `status`) VALUES
(32, 120, 'messages', 1363147766, 13, 13, 'new'),
(33, 122, 'messages', 1363150606, 13, 13, 'new'),
(34, 122, 'messages', 1363150606, 13, 14, 'new'),
(35, 135, 'messages', 1364057199, 14, 14, 'new'),
(36, 135, 'messages', 1364057199, 14, 13, 'new'),
(37, 135, 'messages', 1364057199, 14, 12, 'new'),
(38, 142, 'messages', 1364459907, 18, 18, 'new'),
(39, 138, 'messages', 1364622780, 14, 14, 'new'),
(40, 138, 'messages', 1364622780, 14, 13, 'new'),
(41, 138, 'messages', 1364622780, 14, 12, 'new'),
(42, 138, 'messages', 1364622780, 14, 16, 'new'),
(43, 138, 'messages', 1364622780, 14, 19, 'new'),
(44, 135, 'messages', 1379050326, 12, 12, 'new'),
(45, 135, 'messages', 1379050326, 12, 1, 'new'),
(46, 135, 'messages', 1379050326, 12, 2, 'new'),
(47, 135, 'messages', 1379050326, 12, 3, 'new'),
(48, 135, 'messages', 1379050326, 12, 4, 'new'),
(49, 135, 'messages', 1379050326, 12, 22, 'new'),
(50, 135, 'messages', 1379050326, 12, 14, 'new'),
(51, 135, 'messages', 1379050326, 12, 15, 'new'),
(52, 135, 'messages', 1379050326, 12, 20, 'new'),
(53, 669, 'messages', 1379050339, 12, 12, 'new'),
(54, 669, 'messages', 1379050339, 12, 1, 'new'),
(55, 669, 'messages', 1379050339, 12, 2, 'new'),
(56, 669, 'messages', 1379050339, 12, 3, 'new'),
(57, 669, 'messages', 1379050339, 12, 4, 'new'),
(58, 669, 'messages', 1379050339, 12, 22, 'new'),
(59, 669, 'messages', 1379050339, 12, 14, 'new'),
(60, 669, 'messages', 1379050339, 12, 15, 'new'),
(61, 669, 'messages', 1379050339, 12, 20, 'new'),
(62, 668, 'messages', 1379050733, 12, 12, 'new'),
(63, 668, 'messages', 1379050733, 12, 1, 'new'),
(64, 668, 'messages', 1379050733, 12, 2, 'new'),
(65, 668, 'messages', 1379050733, 12, 3, 'new'),
(66, 668, 'messages', 1379050733, 12, 4, 'new'),
(67, 668, 'messages', 1379050733, 12, 22, 'new'),
(68, 668, 'messages', 1379050733, 12, 14, 'new'),
(69, 668, 'messages', 1379050733, 12, 15, 'new'),
(70, 668, 'messages', 1379050733, 12, 20, 'new'),
(71, 631, 'messages', 1379050800, 12, 12, 'new'),
(72, 631, 'messages', 1379050800, 12, 1, 'new'),
(73, 631, 'messages', 1379050800, 12, 2, 'new'),
(74, 631, 'messages', 1379050800, 12, 3, 'new'),
(75, 631, 'messages', 1379050800, 12, 4, 'new'),
(76, 631, 'messages', 1379050800, 12, 22, 'new'),
(77, 631, 'messages', 1379050800, 12, 14, 'new'),
(78, 631, 'messages', 1379050800, 12, 15, 'new'),
(79, 631, 'messages', 1379050800, 12, 20, 'new'),
(80, 683, 'messages', 1379067176, 12, 12, 'new'),
(81, 683, 'messages', 1379067176, 12, 1, 'new'),
(82, 683, 'messages', 1379067176, 12, 2, 'new'),
(83, 683, 'messages', 1379067176, 12, 3, 'new'),
(84, 683, 'messages', 1379067176, 12, 4, 'new'),
(85, 683, 'messages', 1379067176, 12, 22, 'new'),
(86, 683, 'messages', 1379067176, 12, 14, 'new'),
(87, 683, 'messages', 1379067176, 12, 15, 'new'),
(88, 683, 'messages', 1379067176, 12, 20, 'new'),
(89, 845, 'messages', 1382731921, 12, 12, 'new'),
(90, 845, 'messages', 1382731921, 12, 1, 'new'),
(91, 845, 'messages', 1382731921, 12, 2, 'new'),
(92, 845, 'messages', 1382731921, 12, 3, 'new'),
(93, 845, 'messages', 1382731921, 12, 4, 'new'),
(94, 845, 'messages', 1382731921, 12, 22, 'new'),
(95, 845, 'messages', 1382731921, 12, 25, 'new'),
(96, 845, 'messages', 1382731921, 12, 14, 'new'),
(97, 845, 'messages', 1382731921, 12, 15, 'new'),
(98, 845, 'messages', 1382731921, 12, 20, 'new'),
(99, 12, 'product', 1389986305, 30, 30, 'new'),
(100, 45, 'product', 1395870795, 30, 30, 'new');
