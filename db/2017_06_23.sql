ALTER TABLE `order` ADD `contactname` VARCHAR(255) NULL DEFAULT NULL AFTER `hermes_id`;


CREATE TABLE IF NOT EXISTS `profilefio` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `name` char(255) DEFAULT NULL
 
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `profilephone` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `name` char(255) DEFAULT NULL
 
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `profilefio` ADD PRIMARY KEY(`id`);
ALTER TABLE `profilefio` ADD INDEX(`person_id`);

ALTER TABLE `profilephone` ADD PRIMARY KEY(`id`);
ALTER TABLE `profilephone` ADD INDEX(`person_id`);

ALTER TABLE `profilefio` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `profilephone` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;