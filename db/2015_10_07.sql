
DROP TABLE IF EXISTS product_char;
CREATE TABLE IF NOT EXISTS product_char (
  id int(11) NOT NULL AUTO_INCREMENT,
  shop_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  name varchar(250) DEFAULT NULL,
  price decimal(19,2) DEFAULT NULL,
  sklad int(11),
  barcode int(11),
  primary key(id),
  index(shop_id, product_id)
);
ALTER TABLE  cart ADD  char_id INT( 11 ) NULL DEFAULT  0,
ADD  charname VARCHAR( 255 ) NULL DEFAULT NULL ,
ADD INDEX (  char_id );

ALTER TABLE  orderdetail ADD  char_id INT( 11 ) NULL ,
ADD INDEX (  char_id );