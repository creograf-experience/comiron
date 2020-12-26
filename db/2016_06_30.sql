CREATE TABLE  `comiron`.`dpdcity` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`country` VARCHAR( 255 ) NOT NULL ,
`region` VARCHAR( 255 ) NOT NULL ,
`name` VARCHAR( 255 ) NOT NULL ,
`abbr` VARCHAR( 255 ) NOT NULL ,
`minindex` INT( 11 ) NOT NULL
) ENGINE = INNODB;
ALTER TABLE  `dpdcity` ADD  `maxindex` INT( 11 ) NULL;

ALTER TABLE  `dpdcity` CHANGE  `country`  `country` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE  `region`  `region` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE  `abbr`  `abbr` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE  `minindex`  `minindex` INT( 11 ) NULL;

ALTER TABLE  `dpdcity` ADD INDEX (  `minindex` );

ALTER TABLE  `dpdcity` ADD INDEX (  `maxindex` );

ALTER TABLE  `dpdcity` ADD  `uid` VARCHAR( 250 ) NULL DEFAULT NULL ,
ADD  `kladr` VARCHAR( 250 ) NULL ,
ADD  `rayon` VARCHAR( 255 ) NULL ,
ADD INDEX (  `uid` ,  `kladr` );

ALTER TABLE  `dpdcity` CHANGE  `id`  `id` VARCHAR( 11 ) NOT NULL;

ALTER TABLE  `dpdcity` CHANGE  `uid`  `uid` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE  `kladr`  `kladr` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE  `rayon`  `rayon` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;


ALTER TABLE  `order` ADD  `deliverytype` VARCHAR( 255 ) NULL ,
ADD  `dpdcityid` INT NULL ,
ADD INDEX (  `deliverytype` );


ALTER TABLE  `shop` ADD  `deliverymanager` INT( 1 ) NOT NULL DEFAULT  '0';

ALTER TABLE  `order` CHANGE  `delivery`  `delivery` ENUM(  'myself',  'comiron',  'dpd',  'hermes',  'kurer',  'chinapost',  'russiapost',  'manager' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;





