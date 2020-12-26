CREATE TABLE IF NOT EXISTS action (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_id int(11) NOT NULL,
  discount int(11) DEFAULT 0,
  KEY id (id),
  KEY product_id (product_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE  action ADD ordr INT( 11 ) NULL DEFAULT NULL ,
ADD INDEX (ordr);

ALTER TABLE cart ADD action_id INT( 11 ) NULL ,
ADD INDEX (action_id);
