ALTER TABLE  shop ADD  deliveryhermesru INT( 1 ) DEFAULT  '0',
ADD INDEX (  deliveryhermesru );

CREATE TABLE cartdelivery (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  shop_id INT NOT NULL ,
  person_id INT NOT NULL ,
  hermes_id INT NOT NULL ,
  INDEX (shop_id, person_id, hermes_id)
);

ALTER TABLE  `order` ADD  hermes_id INT NULL ,
ADD INDEX (  hermes_id );
