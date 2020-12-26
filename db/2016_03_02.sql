
DROP TABLE IF EXISTS property;
CREATE TABLE IF NOT EXISTS property (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(250) DEFAULT NULL,
  visible int(11) NOT NULL DEFAULT '0',
  ordr int(11) NOT NULL DEFAULT '0',
  shop_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY group_id (visible,ordr),
  KEY shop_id (shop_id),
  KEY visible (visible),
  KEY ordr (ordr)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS product_property;
CREATE TABLE IF NOT EXISTS product_property (
  id int(11) NOT NULL AUTO_INCREMENT,
  value varchar(250) DEFAULT NULL,
  shop_id int(11) DEFAULT NULL,
  property_id int(11) DEFAULT NULL,
  product_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY product_id (product_id),
  KEY shop_id (shop_id),
  KEY property_id (property_id)
) DEFAULT CHARSET=utf8;

ALTER TABLE  `product` ADD  `primarykey` VARCHAR( 255 ) NULL DEFAULT NULL ,
ADD INDEX (  `primarykey` );