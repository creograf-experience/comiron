ALTER TABLE shop ADD deliverybalance DECIMAL( 10, 2 ) NOT NULL DEFAULT 0;

CREATE TABLE  comiron.dbalance (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  shop_id INT NOT NULL ,
  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  txt VARCHAR( 255 ) NULL ,
  moneyin DECIMAL( 10, 2 ) NOT NULL ,
  moneyout DECIMAL( 10, 2 ) NOT NULL ,
  balance DECIMAL( 10, 2 ) NOT NULL ,
  INDEX (shop_id)
);

ALTER TABLE  `shop` ADD  `city` VARCHAR( 255 ) NULL;

ALTER TABLE  `address` ADD  `city` VARCHAR( 255 ) NULL;

