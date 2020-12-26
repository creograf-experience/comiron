CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL,
  `img` char(255) DEFAULT NULL,
  `ordr` int(11) DEFAULT NULL,
  `isbig` int(1) DEFAULT 0  
) DEFAULT CHARSET=utf8;

ALTER TABLE `banner` ADD INDEX(`isbig`);
ALTER TABLE `banner` ADD INDEX(`ordr`);

ALTER TABLE `banner` ADD `isvisible` INT(1) NOT NULL DEFAULT '0' AFTER `isbig`, ADD `shown` INT(11) NOT NULL DEFAULT '0' AFTER `isvisible`, ADD `clicked` INT(11) NOT NULL DEFAULT '0' AFTER `shown`, ADD INDEX (`isvisible`);
ALTER TABLE `banner` ADD `link` VARCHAR(255) NULL AFTER `clicked`;
ALTER TABLE `banner` ADD PRIMARY KEY(`id`);
ALTER TABLE `banner` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `comiron`.`banner` ( `img`, `ordr`, `isbig`, `isvisible`, `shown`, `clicked`, `link`) VALUES ( 's_bags3.jpg', NULL, '0', '0', '0', '0', '/shop/113'), ( 's_bags4.jpg', NULL, '0', '0', '0', '0', '/shop/107');



