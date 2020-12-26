<?php 

class xmlavitoModel extends Model {
	// Добавление поля proofXML 
  public function goToXml($id,$shop_id) {
    global $db;
    $query = "UPDATE `product` SET proofXML = 1 WHERE shop_id = $shop_id AND id = $id";
    $db->query($query);
  }

  //Удаление proofXML
  public function delFromXml($id,$shop_id) {
    global $db;
    $query = "UPDATE `product` SET proofXML = 0 WHERE shop_id = $shop_id AND id = $id";
    $db->query($query);


  }

  public function avitoXMLKidsBuilder($shop) {
        global $db;
        $queryProduct = ("SELECT p.id, p.name, p.descr, g.goodTypeAvito, p.price, p.photo_url
          FROM `product` AS p
          JOIN group_product as g_p
          ON g_p.product_id=p.id
          JOIN `group` AS g
          ON g.id= g_p.group_id
          WHERE p.shop_id =$shop[id]
          AND p.proofXML = 1
          AND p.descr !=''");
        $resProduct  = $db->query($queryProduct);
        $head = '<Ads formatVersion="3" target="Avito.ru">'; 
        $footer = '</Ads>';
        $template = 
         "<Ad>
        <Id>%ID%</Id>
        <Region>%REGION%</Region>
        <City>%CITY%</City>
        <Category>".$shop['categoryAvitoValue']."</Category>
        <GoodsType>%GOODSTYPE%</GoodsType>
        <Title>%TITLE%</Title>
        <Description>%DESCRIPTION%</Description>
        <Price>%PRICE%</Price>
        <Images>
        <Image url='https://comiron.com%IMG%'/>
        </Images>
        </Ad>";
        $xml = "";

        $arrProduct = $db->fetch_all($resProduct,MYSQLI_ASSOC);
        foreach ($arrProduct as $product) {
          $offerTemplate = str_replace("%ID%", $product['id'], $template);

          if($product['name'] == NULL)
            continue;
          $offerTemplate = str_replace("%TITLE%", $product['name'], $offerTemplate);

          if($shop['inputAvitoValueCity'] == NULL)
            continue;
          $offerTemplate = str_replace("%CITY%", $shop['inputAvitoValueCity'], $offerTemplate);

          if($shop['inputAvitoValueRegion'] == NULL)
            continue;
          $offerTemplate = str_replace("%REGION%", $shop['inputAvitoValueRegion'], $offerTemplate);

           if($product['goodTypeAvito'] == NULL)
            $offerTemplate = str_replace("%GOODSTYPE%", "Игрушки", $offerTemplate);
          $offerTemplate = str_replace("%GOODSTYPE%", $product['goodTypeAvito'], $offerTemplate);

          if($product['descr'] == NULL)
            continue;
          $product['descr'] = strip_tags($product['descr']);
          $offerTemplate = str_replace("%DESCRIPTION%", $product['descr'], $offerTemplate);

          if($product['price'] == NULL)
            continue;
          $product['price'] = strip_tags($product['price']);
          $offerTemplate = str_replace("%PRICE%", (int)$product['price'], $offerTemplate);

          if($product['photo_url'] == NULL)
            continue;
          $product['photo_url'] = strip_tags($product['photo_url']);
          $offerTemplate = str_replace("%IMG%", $product['photo_url'], $offerTemplate);

          $xml .= $offerTemplate;
        }
        $xml .= $footer;
        $head .= $xml;
        $result = $head;
        $puth = PartuzaConfig::get('site_root_avito').'/'.$shop['id'].".xml";
        $file = file_put_contents($puth, $result);
  }   


  public function avitoXMLSportBuilder($shop) {
        global $db;
        $queryProduct = ("SELECT p.id, p.name, p.descr, g.goodTypeAvito, p.price, p.photo_url
          FROM `product` AS p
          JOIN group_product as g_p
          ON g_p.product_id=p.id
          JOIN `group` AS g
          ON g.id= g_p.group_id
          WHERE p.shop_id =$shop[id]
          AND p.proofXML = 1
          AND p.descr !=''");     
        $resProduct  = $db->query($queryProduct);

        $head = '<Ads formatVersion="3" target="Avito.ru">'; 
        $footer = '</Ads>';
        $template = 
         "<Ad>
        <Id>%ID%</Id>
        <Region>%REGION%</Region>
        <City>%CITY%</City>
        <Category>".$shop['categoryAvitoValue']."</Category>
        <GoodsType>%GOODSTYPE%</GoodsType>
        <AdType>Товар приобретен на продажу</AdType>
        <Title>%TITLE%</Title>
        <Description>%DESCRIPTION%</Description>
        <Price>%PRICE%</Price>
        <Images>
        <Image url='https://comiron.com%IMG%'/>
        </Images>
        </Ad>";
        $xml = "";

        $arrProduct = $db->fetch_all($resProduct,MYSQLI_ASSOC);

        foreach ($arrProduct as $product) {
          $offerTemplate = str_replace("%ID%", $product['id'], $template);

          if($product['name'] == NULL)
            continue;
          $offerTemplate = str_replace("%TITLE%", $product['name'], $offerTemplate);

          if($shop['inputAvitoValueCity'] == NULL)
            continue;
          $offerTemplate = str_replace("%CITY%", $shop['inputAvitoValueCity'], $offerTemplate);

          if($shop['inputAvitoValueRegion'] == NULL)
            continue;
          $offerTemplate = str_replace("%REGION%", $shop['inputAvitoValueRegion'], $offerTemplate);

          if($product['goodTypeAvito'] == NULL)
            $offerTemplate = str_replace("%GOODSTYPE%", "Другое", $offerTemplate);
          $offerTemplate = str_replace("%GOODSTYPE%", $product['goodTypeAvito'], $offerTemplate);

          if($product['descr'] == NULL)
            continue;
          $product['descr'] = strip_tags($product['descr']);
          $offerTemplate = str_replace("%DESCRIPTION%", $product['descr'], $offerTemplate);

          if($product['price'] == NULL)
            continue;
          $product['price'] = strip_tags($product['price']);
          $offerTemplate = str_replace("%PRICE%", (int)$product['price'], $offerTemplate);

          if($product['photo_url'] == NULL)
            continue;
          $product['photo_url'] = strip_tags($product['photo_url']);
          $offerTemplate = str_replace("%IMG%", $product['photo_url'], $offerTemplate);
         

          $xml .= $offerTemplate;
        }
        $xml .= $footer;
        $head .= $xml;
        $result = $head;
        $puth = PartuzaConfig::get('site_root_avito').'/'.$shop['id'].".xml";
        $file = file_put_contents($puth, $result);
  }

  public function avitoXMLVeloBuilder($shop) {
        global $db;
        $queryProduct = ("SELECT p.id, p.name, p.descr, g.goodTypeAvito, p.price, p.photo_url
          FROM `product` AS p
          JOIN group_product as g_p
          ON g_p.product_id=p.id
          JOIN `group` AS g
          ON g.id= g_p.group_id
          WHERE p.shop_id =$shop[id]
          AND p.proofXML = 1
          AND p.descr !=''");     
        $resProduct  = $db->query($queryProduct);

        $head = '<Ads formatVersion="3" target="Avito.ru">'; 
        $footer = '</Ads>';
        $template = 
         "<Ad>
        <Id>%ID%</Id>
        <Region>%REGION%</Region>
        <City>%CITY%</City>
        <Category>".$shop['categoryAvitoValue']."</Category>
        <VehicleType>%VehicleType%</VehicleType>
        <AdType>Товар приобретен на продажу</AdType>
        <Title>%TITLE%</Title>
        <Description>%DESCRIPTION%</Description>
        <Price>%PRICE%</Price>
        <Images>
        <Image url='https://comiron.com%IMG%'/>
        </Images>
        </Ad>";
        $xml = "";

        $arrProduct = $db->fetch_all($resProduct,MYSQLI_ASSOC);

        foreach ($arrProduct as $product) {
          $offerTemplate = str_replace("%ID%", $product['id'], $template);

          if($product['name'] == NULL)
            continue;
          $offerTemplate = str_replace("%TITLE%", $product['name'], $offerTemplate);

          if($shop['inputAvitoValueCity'] == NULL)
            continue;
          $offerTemplate = str_replace("%CITY%", $shop['inputAvitoValueCity'], $offerTemplate);

          if($shop['inputAvitoValueRegion'] == NULL)
            continue;
          $offerTemplate = str_replace("%REGION%", $shop['inputAvitoValueRegion'], $offerTemplate);

          if($product['goodTypeAvito'] == NULL)
            $offerTemplate = str_replace("%VehicleType%", "Другое", $offerTemplate);
          $offerTemplate = str_replace("%VehicleType%", $product['goodTypeAvito'], $offerTemplate);

          if($product['descr'] == NULL)
            continue;
          $product['descr'] = strip_tags($product['descr']);
          $offerTemplate = str_replace("%DESCRIPTION%", $product['descr'], $offerTemplate);

          if($product['price'] == NULL)
            continue;
          $product['price'] = strip_tags($product['price']);
          $offerTemplate = str_replace("%PRICE%", (int)$product['price'], $offerTemplate);

          if($product['photo_url'] == NULL)
            continue;
          $product['photo_url'] = strip_tags($product['photo_url']);
          $offerTemplate = str_replace("%IMG%", $product['photo_url'], $offerTemplate);
          

          $xml .= $offerTemplate;
        }
        $xml .= $footer;
        $head .= $xml;
        $result = $head;
        $puth = PartuzaConfig::get('site_root_avito').'/'.$shop['id'].".xml";
        $file = file_put_contents($puth, $result);
  }

  //Генерация XML

  public function buildXML($id=null) {
      global $db;
      if ($id) {
        $queryShop = ("SELECT id, inputAvitoValueCity, inputAvitoValueRegion, categoryAvitoValue FROM `shop` WHERE id = $id");
        $shop = $db->query($queryShop);
        $shop = $db->fetch_array($shop);
        switch ($shop['categoryAvitoValue']) {
                case 'Товары для детей и игрушки':
                  $this->avitoXMLKidsBuilder($shop);
                  break;
                
                case 'Спорт и отдых':
                  $this->avitoXMLSportBuilder($shop);
                  break;

                case 'Велосипеды':
                  $this->avitoXMLVeloBuilder($shop);
                  break;
                    
                default:
                  # code...
                  break;
              }

      }
      else {
        $queryShop = ("SELECT id, inputAvitoValueCity, inputAvitoValueRegion, categoryAvitoValue FROM `shop` WHERE goXml = 1");
        $resShop = $db->query($queryShop);
        $arrShop = $db->fetch_all($resShop,MYSQLI_ASSOC);
        foreach ($arrShop as $shop) {
              switch ($shop['categoryAvitoValue']) {
                case 'Товары для детей и игрушки':
                  $this->avitoXMLKidsBuilder($shop);
                  break;
                
                case 'Спорт и отдых':
                  $this->avitoXMLSportBuilder($shop);
                  break;

                case 'Велосипеды':
                  $this->avitoXMLVeloBuilder($shop);
                  break;
                   
                default:
                  # code...
                  break;
              }
              
          }
        
    }
    return true;
  }	

  public function getCategory(){
    global $db;
    $category = [];
    $query = "SELECT name FROM `category_avito`";
    $res = $db->query($query);
    while ($data = $db->fetch_array($res)) {
        $category[] = $data['name'];
      }
    return $category;
  }

  public function getGoodsType($category) {
    global $db;
    $goodsType = [];
    $query = "SELECT g.name 
              FROM goods_type_avito as g
              JOIN category_avito as c
              ON c.name = \"$category\"
              JOIN category_goods_avito as c_g_a
              ON c_g_a.id_category = c.id
              WHERE c_g_a.id_goods = g.id";
    $res = $db->query($query);
    while ($data = $db->fetch_array($res)) {
        $goodsType[] = $data['name'];
      }
    return $goodsType;

  }

  public function checkCategoryChange($category, $id) {
    global $db;
    $query = "SELECT categoryAvitoValue 
              FROM shop
              WHERE id=$id";
    $res = $db->query($query);
    $result = $db->fetch_row($res);
    if ($category != $result[0]) {
      $query = "UPDATE `group` 
                SET goodTypeAvito = NULL
                WHERE shop_id=$id";
      $db->query($query);          
    }
    return;
  }
}