DROP TABLE IF EXISTS cart_unreg;
CREATE TABLE IF NOT EXISTS cart_unreg (
  id int(11) NOT NULL AUTO_INCREMENT,
  shop_id int(11) NOT NULL,
  person_uid char(60) NOT NULL,
  product_id int(11) NOT NULL,
  num int(11) NOT NULL,
  price decimal(19,2) NOT NULL,
  sum decimal(19,2) NOT NULL,
  currency_id int(11) DEFAULT NULL,
  char_id int(11) DEFAULT 0,
  charname varchar(255) DEFAULT NULL,
  action_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY shop_id (shop_id,person_uid,product_id),
  KEY currency_id (currency_id),
  KEY char_id (char_id),
  KEY action_id (action_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;