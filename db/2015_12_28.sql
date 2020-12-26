ALTER TABLE  shop ADD  deliverydpdru INT( 1 ) NOT NULL DEFAULT  0,
ADD INDEX (  deliverydpdru );
ALTER TABLE  shop ADD  paysimplepay INT( 1 ) NOT NULL DEFAULT  0,
ADD INDEX (  paysimplepay );
#ALTER TABLE  order CHANGE  delivery delivery ENUM(  'myself',  'comiron',  'dpd',  'hermes',  'kurer',  'chinapost',  'russiapost' ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE  order CHANGE  delivery  delivery VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE  `order` ADD  `deliverycost` DECIMAL( 10, 2 ) NULL ,
ADD  `deliverynum` VARCHAR( 255 ) NULL;
ALTER TABLE  `shop` ADD  `terminal` VARCHAR( 255 ) NULL;
