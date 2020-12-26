ALTER TABLE `shop`
  ADD `deliveryrupost` INT(1) DEFAULT 0;
ALTER TABLE `shop`
  ADD `deliverycourier` INT(1) DEFAULT 0;
ALTER TABLE `order`
  ADD `rupost_pdf` varchar(255);
