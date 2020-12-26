
CREATE TABLE IF NOT EXISTS `price2parse` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` text CHARACTER SET utf8,
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `date` int(11) DEFAULT NULL
);

ALTER TABLE `price2parse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`);

ALTER TABLE `price2parse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
