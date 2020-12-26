<?php
/**
 */

class pushModel extends Model {
  public $table="`push`";
  //public $cachable = array('get_groups', 'get_groups_of_product', 'get_group');
  public $supported_fields = array('id', 'date', 'shop_id', 'order_id','person_id','token','title','message');//'thumbnail_url',
  private $perpage = 50;

  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      $id = $this->add($shop_id, $_REQUEST);
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->get($id);
  }

  public function GET($id){
    return $this->get($id);
  }

  public function GETlist($shop_id){
    return $this->get_list($shop_id);
  }
  //подготовить список
  public function load_get_list($person_id=0, $params){
    global $db;
    $curpage=(isset($params['curpage'])?$params['curpage']:0);
    $start = $curpage * $this->perpage;
    $limit = "limit $start, ".$this->perpage;

    $query="select * from ".$this->table." where person_id=$person_id order by id desc $limit";
    $res = $db->query($query);

    if (! $db->num_rows($res)) {
      return null;
    }
    $shop = $this->get_model('shop');
    $order = $this->get_model('order');
    //print_r($res->fetch_array(MYSQLI_ASSOC));
    $list=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $data['shop'] = $shop->get_shop($data['shop_id']);
      if ($data['order_id']) {
        $data['order'] = $order->get_order($data['order_id'], null, $data['shop_id']);
      }
      $list[]=$data;
    }
    return $list;
  }


  //подготовить
  public function load_get($id){
    global $db;
    $res = $db->query("select * from ".$this->table." where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      return $data;
    }
  }

  //добавить
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);

    $keys[]="shop_id";
    $values[]=$shop_id;

/*    $keys[]="visible";
    $values[]=1;*/

    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields) and $key != "shop_id") {
        $keys[]=$db->addslashes($key);
        if (is_null($val)) {
          $values[] = "null";
        }
        if(is_numeric($val)){
          $values[] = $val;
        } else {
          $values[] = "'" . $db->addslashes($val) . "'";
        }
      }
    }

    $query = "insert into ".$this->table." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);
    return $db->insert_id();
  }

  //сохранить
  public function save($id, $params){
    global $db;
    $id = $db->addslashes($id);

    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        if (is_null($val)) {
          $update[] = $db->addslashes($key)." = null";
        } else if(is_numeric($val)){
          $update[] = $db->addslashes($key)." = ".$val;
        } else {
          $update[] = $db->addslashes($key)." = '" . $db->addslashes($val) . "'";
        }
      }
    }

    if($update){
      $query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
      $db->query($query);
    }
  }

  //удалить
  public function delete($id){
    global $db;
    $id = $db->addslashes($id);
    $res=$db->query("delete from ".$this->table." where id=$id" );
  }

}
