<?php
/**
 */

class cart_unregModel extends Model {
  //public $cachable = array('get_cart','get_small_cart');
  public $supported_fields = array('id', 'shop_id', 'person_uid', 'product_id', 'num', 'price', 'sum', 'currency_id', 'charname', 'char_id', 'action_id');
  private $table = "cart_unreg";

  public function get_all_small_cart($person_id){
    global $db;
    $person_id = $db->addslashes($person_id);

    $res = $db->query("select count(id) as items, sum(`sum`) as cart_sum, shop_id from ".$this->table." where person_uid='$person_id'".
        " group by shop_id");
    if (! $db->num_rows($res)) {
      return null;
    }

    $shop=$this->get_model("shop");
    $currency=$this->get_model("currency");

    $result=array();
    while($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $cart=array();

      $cart['items']=$data['items'];
      $cart['sum']=$data['cart_sum'];
      $cart['shop']=$shop->get_shop_info($data['shop_id']);
      $cart['currency']=$currency->get_currency($cart['shop']['currency_id']);
      $result[]=$cart;
    }
    return $result;
  }

  public function get_small_cart($person_id, $shop_id=0){
    global $db;
    $person_id = $db->addslashes($person_id);

    $res = $db->query("select count(id) as items, sum(`sum`) as cart_sum, currency_id, shop_id from ".$this->table." where person_uid='$person_id'".
        (($shop_id>0)?" and shop_id=$shop_id":"").
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

  public function get_cart($person_id, $shop_id=0){
    global $db;
    $person_id = $db->addslashes($person_id);

    $res = $db->query("select * from ".$this->table." where person_uid='$person_id'".
        ($shop_id?" and shop_id=$shop_id":""));
    if (! $db->num_rows($res)) {
      return null;
    }
    $cart=array();
    $product=$this->get_model("product");
    $currency=$this->get_model("currency");
    $action=$this->get_model("action");

    $w = 0; $h = 0; $d = 0; $volume = 0; $weight = 0;
    while($data = $res->fetch_array(MYSQLI_ASSOC)) {

    /*if($data['action_id']){
      $product=$action->get_action($data['action_id']);
      if($product['product_id']==$data['product_id']){
        $data['product']=$product;
      }
    }
    if(!isset($data['product'])){
    */
      $data['product']=$product->get_product($data['product_id'], false);
      //}
      $data['product']['name'].=" ".$data['charname'];
      $data['currency']=$currency->get_currency($data['currency_id']);

      $w += $data['product']['w'];
      $h += $data['product']['h'];
      $d += $data['product']['d'];
      if(isset($data['product']['volume'])){
        $volume += $data['product']['volume'];
      }else if(isset($data['product']['w']) && isset($data['product']['h']) && isset($data['product']['d'])){
        $volume += $data['product']['w'] * $data['product']['h'] * $data['product']['d'];
      }
      $weight += isset($data['product']['weight']) ? $data['product']['weight']:0;
      $cart[]=$data;
    }

    return array(
        'cart'=>$cart,
        'w' => $w,
        'h' => $h,
        'd' => $d,
        'volume' => $volume,
        'weight' => $weight,
      );
  }

  public function add($params){
    global $db;
    $params['person_uid'] = $db->addslashes($params['person_uid']);


    //проверить есть ли этот товар в корзине этого пользователя
    $res=$db->query("select id from ".$this->table." where person_uid='".$params['person_uid']."' and product_id=".$params['product_id'].
        ((isset($params['charid']) and $params['charid']>0)?" and char_id=".$params['charid']:""));
    $id=0;
    if ($db->num_rows($res)) {
      if($data = $db->fetch_array($res,MYSQLI_ASSOC)) {
        $id=$data['id'];
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
        $query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
        $db->query($query);
        $db->query("update ".$this->table." set sum=num*price where id=$id");
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

      $query = "insert into ".$this->table." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";

      $db->query($query);
      return $db->insert_id();
    }
  }


  public function set($params){
    global $db;
    $params['person_uid'] = $db->addslashes($params['person_uid']);


    //проверить есть ли этот товар в корзине этого пользователя
    $res=$db->query("select id from ".$this->table." where person_uid='".$params['person_uid']."' and product_id=".$params['product_id'].
        ((isset($params['charid']) and $params['charid']>0)?" and char_id=".$params['charid']:""));
    $id=0;
    if ($db->num_rows($res)) {
      if($data = $db->fetch_array($res,MYSQLI_ASSOC)) {
        $id=$data['id'];
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
        $query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
        $db->query($query);
        $db->query("update ".$this->table." set sum=num*price where id=$id");
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

      $query = "insert into ".$this->table." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";

      $db->query($query);
      return $db->insert_id();
    }
  }

  public function  get_shop($cart_id){
    global $db;
    $res = $db->query("select shop_id from ".$this->table." where id=$cart_id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if($data = $res->fetch_array(MYSQLI_ASSOC)) {
      return $data['shop_id'];
    }
    return null;
  }

  public function delete($cart_id){
    global $db;
    $res = $db->query("delete from ".$this->table." where id=$cart_id");
    return null;
  }

  //обновить количество в корзине
  public function update($person_id, $shop_id, $params){
    global $db;

    $cart_items=$this->get_cart($person_id, $shop_id);
    if(isset($cart_items)){
    foreach ($cart_items as $cart) {
      if(isset($params['num'.$cart['id']])){
        $num=$params['num'.$cart['id']];
        $db->query("update ".$this->table." set num=$num where id=".$cart['id']);
        $db->query("update ".$this->table." set sum=$num*price where id=".$cart['id']);
      }
      }
    }
    return;
  }

  //уменьшить количество на складе для каждого товара из корзины
  public function update_sklad($person_id, $shop_id){
    global $db;

    $cart_items=$this->get_cart($person_id, $shop_id);
    if(isset($cart_items)){
    foreach ($cart_items as $cart) {
      if(isset($cart['num'])){
        if(!$cart["char_id"]){
          $db->query("update `product` set sklad=sklad-".$cart['num']." where id=".$cart['product_id']." and sklad>0");
        }else{
          $db->query("update `product_char` set sklad=sklad-".$cart['num']." where id=".$cart['char_id']." and sklad>0");
        }
      }
      }
    }
    return;
  }


  //очистить корзину
  public function cart_empty($person_id, $shop_id=0){
    global $db;
    $person_id = $db->addslashes($person_id);
    $res = $db->query("delete from ".$this->table." where person_uid='$person_id'".
        ($shop_id?" and shop_id=$shop_id":""));
    return;
  }

}
