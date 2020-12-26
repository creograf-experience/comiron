ALTER TABLE  `group_product` ADD  `shop_id` INT( 11 ),
ADD INDEX (  `shop_id` );

ALTER TABLE  `product_images` ADD  `shop_id` INT NULL ,
ADD INDEX (  `shop_id` );

