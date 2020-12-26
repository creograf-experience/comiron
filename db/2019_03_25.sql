

CREATE TABLE IF NOT EXISTS `priceorder` (
  `id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `price_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `id_promo` int(20) DEFAULT NULL,
  `sum` decimal(19,2) NOT NULL DEFAULT '0.00',
  `ispayed` int(1) NOT NULL DEFAULT '0',
  `currency_id` int(11) DEFAULT NULL,
  `orderstatus_id` int(11) DEFAULT NULL,
  `dataorder` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `comment_person` text,
  `comment_shop` text,
  `comment_num` int(11) DEFAULT '0',
  `isuserarchive` int(1) DEFAULT '0',
  `delivery` enum('myself','comiron','dpd','hermes','kurer','chinapost','russiapost','manager') DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postalcode` varchar(10) DEFAULT NULL,
  `deliverycost` decimal(10,2) DEFAULT NULL,
  `deliverynum` varchar(255) DEFAULT NULL,
  `numpack` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `volume` decimal(10,2) DEFAULT NULL,
  `terminal` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `date_pickup` int(11) DEFAULT NULL,
  `deliverydate` varchar(255) DEFAULT NULL,
  `deliverystate` varchar(255) DEFAULT NULL,
  `rupost_pdf` varchar(255) DEFAULT NULL,
  `deliverytype` varchar(255) DEFAULT NULL,
  `dpdcityid` int(11) DEFAULT NULL,
  `dpdcity` varchar(255) DEFAULT NULL,
  `dpdstreetprefix` varchar(255) DEFAULT NULL,
  `dpdstreet` varchar(255) DEFAULT NULL,
  `dpdhouse` varchar(255) DEFAULT NULL,
  `dpdkorpus` varchar(255) DEFAULT NULL,
  `dpdstroenie` varchar(255) DEFAULT NULL,
  `dpdvladenie` varchar(255) DEFAULT NULL,
  `dpdoffice` varchar(255) DEFAULT NULL,
  `dpdflat` varchar(255) DEFAULT NULL,
  `hermes_id` int(11) DEFAULT NULL,
  `contactname` varchar(255) DEFAULT NULL,
  `track_number` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `order`
--
ALTER TABLE `priceorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`,`person_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `price_id` (`price_id`),
  ADD KEY `orderstatus_id` (`orderstatus_id`),
  ADD KEY `dataorder` (`dataorder`),
  ADD KEY `isuserarchive` (`isuserarchive`),
  ADD KEY `delivery` (`delivery`),
  ADD KEY `deliverytype` (`deliverytype`),
  ADD KEY `hermes_id` (`hermes_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `priceorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


CREATE TABLE `priceorderdetail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `price_id` int(11) NOT NULL,
  `priceitem_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `price` decimal(19,2) NOT NULL DEFAULT '0.00',
  `sum` decimal(19,2) NOT NULL DEFAULT '0.00',
  `shop_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `char_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orderdetail`
--
ALTER TABLE `priceorderdetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`,`product_id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `price_id` (`price_id`),
  ADD KEY `priceitem_id` (`priceitem_id`),
  ADD KEY `currency_id` (`currency_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `code` (`code`),
  ADD KEY `char_id` (`char_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orderdetail`
--
ALTER TABLE `priceorderdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
