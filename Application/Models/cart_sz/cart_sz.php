<?php
/**
 */

class cart_szModel extends Model {
  public $supported_fields = array(
    'id',
    'shop_id',
    'person_id',
    'product_id',
    'num',
    'price',
    'sum',
    'currency_id',
    'charname',
    'char_id',
    'action_id',
    'price_id',
    'source',
    'enddate'
  );

  public function get_all_small_cart($person_id){
    global $db;

    $person_id = $db->addslashes($person_id);

    $res = $db->query("
      SELECT
        count(id) AS items,
        sum(`sum`) AS cart_sum,
        shop_id,
        price_id,
	product_id
      FROM
        cart_sz
      WHERE
        person_id = $person_id
      GROUP BY
        shop_id, price_id
    ");

    if (!$db->num_rows($res)) return [];

    $shop = $this->get_model('shop');
    $currency = $this->get_model('currency');
    $product_model = $this->get_model('product');

    $result = [];
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $cart = [];
      $product = $product_model->get_product($data['product_id'], false);

      $cart['items'] = $data['items'];
      $cart['price_id'] = $data['price_id'];
      $cart['sum'] = $data['cart_sum'];
      $cart['shop'] = $shop->get_shop_info($data['shop_id']);
      $cart['currency'] = $currency->get_currency($product['currency_id']);

      $result[] = $cart;
    }

    return $result;
  }

  public function get_cart($person_id, $shop_id, $price_id){
    global $db;

    $person_id = $db->addslashes($person_id);
    $shop_id = $db->addslashes($shop_id);
    $price_id = $db->addslashes($price_id);

    $res = $db->query("
      SELECT *
      FROM
        cart_sz
      WHERE
        person_id = $person_id AND
        shop_id = $shop_id AND
        price_id = $price_id
    ");

    if (!$db->num_rows($res)) {
      return ['cart' => null];
    }

    $product = $this->get_model('product');
    $currency = $this->get_model('currency');

    $cart = [];
    $w = 0; $h = 0; $d = 0; $volume = 0; $weight = 0;

    while($data = $res->fetch_array(MYSQLI_ASSOC)) {
	 $price_product_query = $db->query("
        SELECT
          tobuy
        FROM
          `price_products`
        WHERE
          id_product = {$data['product_id']} AND
          id_price = $price_id
      ");
      $price_product = $price_product_query->fetch_array(MYSQLI_ASSOC);
      $data['product'] = $product->get_product($data['product_id'], false);

	$data['product']['tobuy'] = $price_product['tobuy'];
      $data['product']['num_orders_sz'] = $this->get_orders_sz_count($data['product_id']);
      $data['product']['name'] .= " ".$data['charname'];
      $data['product']['currency'] = $currency->get_currency($data['currency_id']);
      $data['currency'] = $data['product']['currency'];

      $w += $data['product']['w'] * $data['num'];
      $h += $data['product']['h'];// * $data['num'];
      $d += $data['product']['d'];// * $data['num'];

      if(isset($data['product']['volume'])){
        $volume += $data['product']['volume'] * $data['num'];
      }else if(isset($data['product']['w']) && isset($data['product']['h']) && isset($data['product']['d'])){
        $volume += $data['product']['w'] * $data['product']['h'] * $data['product']['d']  * $data['num'];
      }

      $weight += isset($data['product']['weight']) ? $data['product']['weight'] * $data['num']:0;
      $cart[] = $data;
    }

    return array(
      'cart' => $cart,
      'w' => $w,
      'h' => $h,
      'd' => $d,
      'volume' => $volume,
      'weight' => $weight,
    );
  }

  public function add($params){
    global $db;

    //проверить есть ли этот товар в корзине этого пользователя
    $res=$db->query("select id, charname from `cart_sz` where person_id=".$params['person_id']." and product_id=".$params['product_id'].
        ((isset($params['charid']) and $params['charid']>0)?" and char_id=".$params['charid']:""));
    $id=0;
    if ($db->num_rows($res)) {
      if($data = $db->fetch_all($res,MYSQLI_ASSOC)) {
        foreach ($data as $k => $v) {
          if($v['charname'] == $params['charname'])
            $id = $v['id'];
        }
      }
    }

    if($id){
      foreach ($params as $key => $val) {
        if (in_array($key, $this->supported_fields)) {
          if (is_null($val)) {
            $update[] = $db->addslashes($key)." = null";
          } else {
            if($key == "num"){
              $update['num']="num=num+".$db->addslashes($val);
            }else{
              $update[] = $db->addslashes($key)." = '" . $db->addslashes($val) . "'";
            }
          }
        }
      }

      if($update){
        $query = "update `cart_sz` set " . implode(', ', $update) . " where id=$id";
        $db->query($query);
        $db->query("update `cart_sz` set sum=num*price where id=$id");
        return;
      }
    }else{
      foreach ($params as $key => $val) {
        if (in_array($key, $this->supported_fields)) {
          $keys[]=$db->addslashes($key);
          if (is_null($val)) {
            $values[] = "null";
          } else {
            $values[] = "'" . $db->addslashes($val) . "'";
          }
        }
      }

      $query = "insert into `cart_sz` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";

      $db->query($query);
      return $db->insert_id();
    }
  }

  public function set($params){
    global $db;

    //проверить есть ли этот товар в корзине этого пользователя
    $res=$db->query("select id, charname from `cart_sz` where person_id=".$params['person_id']." and product_id=".$params['product_id'].
        ((isset($params['charid']) and $params['charid']>0)?" and char_id=".$params['charid']:""));
    $id=0;
    if ($db->num_rows($res)) {
      if($data = $db->fetch_all($res,MYSQLI_ASSOC)) {
        foreach ($data as $k => $v) {
          //var_dump($v);
          if($v['charname'] == $params['charname'])
            $id = $v['id'];
        }
      }
    }

    if($id){
      foreach ($params as $key => $val) {
        if (in_array($key, $this->supported_fields)) {
          if (is_null($val)) {
            $update[] = $db->addslashes($key)." = null";
          } else {
            if($key == "num"){
              $update['num']="num=".$db->addslashes($val);
            }else{
              $update[] = $db->addslashes($key)." = '" . $db->addslashes($val) . "'";
            }
          }
        }
      }

      if($update){
        $query = "update `cart_sz` set " . implode(', ', $update) . " where id=$id";
        $db->query($query);
        $db->query("update `cart_sz` set sum=num*price where id=$id");
        return;
      }
    }else{
      foreach ($params as $key => $val) {
        if (in_array($key, $this->supported_fields)) {
          $keys[]=$db->addslashes($key);
          if (is_null($val)) {
            $values[] = "null";
          } else {
            $values[] = "'" . $db->addslashes($val) . "'";
          }
        }
      }

      $query = "insert into `cart_sz` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";

      $db->query($query);
      return $db->insert_id();
    }
  }

  public function delete($cart_id){
    global $db;

    $res = $db->query("
      DELETE FROM
        cart_sz
      WHERE
        id = $cart_id
    ");

    return null;
  }

  public function find_finished_sz_carts() {
    global $db;

    $todays_date_ms = round(microtime(true) * 1000);

    $res = $db->query("
      SELECT
        c.*, p.name as product_name, p.photo_url
      FROM
        cart_sz c
      LEFT JOIN
        product p
      ON
        c.product_id = p.id
      WHERE
        $todays_date_ms > enddate
    ");

    while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
      $carts[] = $row;
    }

    $grouped_carts = $this->_group_carts($carts);
    $carts = $this->_normalize_carts($grouped_carts);

    return $carts;
  }

  private function _group_carts($carts) {
    $result = [];
    $carts_copy = $carts;

    foreach ($carts as $filter) {
      $match = [];
      $not_match = [];

      foreach ($carts_copy as $cart) {
        if (
          $cart['person_id'] == $filter['person_id'] &&
          $cart['price_id'] == $filter['price_id'] &&
          $cart['shop_id'] == $filter['shop_id']
        ) {
          $match[] = $cart;
        } else {
          $not_match[] = $cart;
        }
      }

      if (count($match)) {
        $result[] = $match;
      }

      $carts_copy = $not_match;
    }

    return $result;
  }

  private function _normalize_carts($grouped_carts) {
    $carts = [];

    foreach ($grouped_carts as $groups) {
      $arr = [
        'shop_id' => $groups[0]['shop_id'],
        'person_id' => $groups[0]['person_id'],
        'price_id' => $groups[0]['price_id'],
        'currency_id' => $groups[0]['currency_id'],
        'sum' => 0,
        'cart_ids' => [],
        'products' => []
      ];

      foreach ($groups as $group) {
        $arr = array_merge($arr, [
          'sum' => $arr['sum'] + $group['sum'],
        ]);

        $arr['cart_ids'][] = $group['id'];

        $arr['products'][] = [
          'product_id' => $group['product_id'],
          'num' => $group['num'],
          'price' => $group['price'],
          'sum' => $group['sum'],
          'shop_id' => $group['shop_id'],
          'currency_id' => $group['currency_id'],
          'person_id' => $group['person_id'],
          'price_id' => $group['price_id'],
          'source' => $group['source'],
          'product_name' => $group['product_name'],
          'photo_url' => $group['photo_url']
        ];
      }

      $carts[] = $arr;
    }

    return $carts;
  }

  // сколько единиц товара выкуплено в совместной закупке
  public function get_orders_sz_count($product_id) {
    global $db;

    $count = 0;

    // количество в корзине
    $res = $db->query("
      SELECT
        SUM(cart_sz.num) AS cart_order_num
      FROM
        cart_sz
      WHERE
        cart_sz.product_id = $product_id
    ");

    if ($res->num_rows) {
      $res = $res->fetch_array(MYSQLI_ASSOC);
      if ($res['cart_order_num'] > 0) {
        $count += $res['cart_order_num'];
      }
    }

    // количество в заказах
    $res = $db->query("
      SELECT
        SUM(orderdetail.num) AS orders_num
      FROM
        orderdetail, `order`
      WHERE
        orderdetail.order_id = `order`.id AND
        `order`.is_sz = 1 AND
        orderdetail.product_id = $product_id
    ");

    if ($res->num_rows) {
      $res = $res->fetch_array(MYSQLI_ASSOC);
      if ($res['orders_num'] > 0) {
        $count += $res['orders_num'];
      }
    }

    return $count;
  }

  //очистить корзину
  public function cart_empty($person_id, $shop_id=0, $price_id = 0){
    global $db;
    $res = $db->query("delete from cart_sz where person_id=$person_id".
      ($shop_id?" and shop_id=$shop_id":"").
      ($price_id?" and price_id=$price_id":""));
    return;
  }


    public function get_small_cart($person_id, $shop_id=0, $price_id=0){
      global $db;
      $res = $db->query("select count(id) as items, sum(`sum`) as cart_sum, currency_id, shop_id from cart_sz where person_id=$person_id".
        (($shop_id>0)?" and shop_id=$shop_id":"").
        " and price_id=$price_id".
          " group by currency_id");
      if (! $db->num_rows($res)) {
        return null;
      }

      $currency=$this->get_model("currency");

      $result=array();
      while($data = $res->fetch_array(MYSQLI_ASSOC)) {
        $cart=array();

        $cart['items']=$data['items'];
        $cart['sum']=$data['cart_sum'];
        $cart['currency_id']=$data['currency_id'];
        $cart['currency']=$currency->get_currency($data['currency_id']);
        $result[]=$cart;
      }
      return $result;
    }

    public function delete_finished_sz_carts() {
      global $db;

      //7 дней назад
      $end_date_ms = round(microtime(true) * 1000) - 7*24*60*60*1000;

      $res = $db->query("delete FROM cart_sz WHERE price_id in (
           select id from price where enddate < $end_date_ms
          )");

      return;
    }

}
