<?php
/**
 */

class pointofissueModel extends Model {
  public $table="`pointofissue`";
  //public $cachable = array('get_groups', 'get_groups_of_product', 'get_group');
  public $supported_fields = array('id', 'address', 'city', 'shop_id', 'coordx','coordy','ordr','comment');//'thumbnail_url',

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
  public function load_get_list($shop_id=0){
    global $db;

    $query="select * from ".$this->table." where shop_id=$shop_id order by id";
    $res = $db->query($query);

    if (! $db->num_rows($res)) {
      return null;
    }
    //print_r($res->fetch_array(MYSQLI_ASSOC));
    $pointofissue=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {

      $pointofissue[]=$data;
    }
    return $pointofissue;
  }


  //подготовить группу
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

  //добавить группу
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);

    $keys[]="shop_id";
    $values[]=$shop_id;

/*    $keys[]="visible";
    $values[]=1;*/

    if(!isset($params['ordr'])){
      $keys[]="ordr";
      $res=$db->query("select max(ordr) as max_ordr from ".$this->table." where shop_id=$shop_id" );
      $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
      $values[]=1+$max_ordr['max_ordr'];
    }

    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields) and $key != "shop_id") {
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

  //сохранить группу
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

  //удалить группу
  public function delete($id){
    global $db;
    $id = $db->addslashes($id);
    $res=$db->query("delete from ".$this->table." where id=$id" );
  }

}
