ALTER TABLE  `group` ADD  primarykey VARCHAR( 250 ) NULL DEFAULT NULL ,
ADD INDEX (  primarykey );

ALTER TABLE  `property` ADD  `primarykey` VARCHAR( 250 ) NULL ,
ADD INDEX (  `primarykey` );