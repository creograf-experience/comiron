<?php
/**
 */

class cartdeliveryModel extends Model {
  public $supported_fields = array('id', 'shop_id', 'person_id', 'hermes_id');
  public $table="`cartdelivery`";

  public function save($params){
    global $db;
    if(!isset($params{'person_id'}) or $params{'person_id'}<1 or
		!isset($params{'shop_id'}) or $params{'shop_id'}<1){
	 return;
    }

 
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
      
    if($params['id']){
        $query = "update ".$this->table." set " . implode(', ', $update) . " where id=".$params['id'];
        $db->query($query);
        return;
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

  public function cart_empty($person_id, $shop_id=0){
    global $db;
    if(!isset($person_id) or $person_id<1){ return; }

    $res = $db->query("delete from ".$this->table." where person_id=$person_id".
        ($shop_id?" and shop_id=$shop_id":""));
    return;
  }

  public function get_hermes_id($id){
    global $db;
    $res = $db->query("select hermes_id from ".$this->table." where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if($data = $res->fetch_array(MYSQLI_ASSOC)) {
      return $data['hermes_id'];
    }
    return null;
  }

  public function get($id){
    global $db;
    $res = $db->query("select * from ".$this->table." where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if($data = $res->fetch_array(MYSQLI_ASSOC)) {
      return $data;
    }
    return null;
  }
  
}
