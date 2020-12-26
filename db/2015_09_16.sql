DROP TABLE IF EXISTS shop_banners;

CREATE TABLE IF NOT EXISTS shop_banners (
 id int(11) NOT NULL AUTO_INCREMENT,
 shop_id int(11) NOT NULL,
 link char(255), 
 img char(255),
 isvisible int(1) NOT NULL DEFAULT 0,
 clicked int(11) NOT NULL DEFAULT 0,
 shown int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (id),
 index (shop_id),
 index (isvisible)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                 
ALTER TABLE  shop_banners ADD  ordr INT NOT NULL DEFAULT  0,
ADD INDEX (  ordr );