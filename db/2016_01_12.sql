ALTER TABLE  `order` ADD  `numpack` INT( 11 ) NULL ,
ADD  `category` VARCHAR( 255 ) NULL ,
ADD  `weight` DECIMAL( 10, 2 ) NULL ,
ADD  `volume` DECIMAL( 10, 2 ) NULL;
ALTER TABLE  `order` ADD  `terminal` VARCHAR( 255 ) NULL;
ALTER TABLE  `order` ADD  `city` VARCHAR( 255 ) NULL;
ALTER TABLE  `order` ADD  `date_pickup` INT(11) NULL;
ALTER TABLE  `shop` ADD  `logistname` VARCHAR( 255 ) NULL;
ALTER TABLE  `shop` ADD  `logistphone` VARCHAR( 255 ) NULL;
ALTER TABLE  `persons` CHANGE  `phone`  `phone` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE  `order` CHANGE  `phone`  `phone` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

DROP TABLE IF EXISTS `orderstatus`;
CREATE TABLE IF NOT EXISTS `orderstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordr` int(11) DEFAULT NULL,
  `name` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordr` (`ordr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `orderstatus` (`id`, `ordr`, `name`) VALUES
(1, 1, 'order_status_new'),
(2, 2, 'order_status_inprocess'),
(3, 4, 'order_status_done'),
(4, 5, 'order_status_denied'),
(5, 6, 'order_status_user_denied'),
(6, 3, 'order_status_delivery');

ALTER TABLE  `order` ADD  `deliverydate` VARCHAR( 255 ) NULL ,
ADD  `deliverystate` VARCHAR( 255 ) NULL;
