<?php
/**
 */

class dbalanceModel extends Model {
	private $table="`dbalance`";
  	//public $cachable = array('get_banners');
  	public $supported_fields = array('id', 'shop_id','date','txt','in', 'out', 'balance');

  
  //подготовить список 
  public function load_show($shop_id=0){
  	global $db;

	  
	  $query="select * from ".$this->table." where shop_id=$shop_id order by date desc";
  	$res = $db->query($query);

  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	
	  $result=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$result[]=$data;  		
  	}
  	return $result;
  }
  
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
  
  //сохранить 
  public function save($id, $params){
  	global $db;
  	$id = $db->addslashes($id);
  
  	foreach ($params as $key => $val) {
  		if (in_array($key, $this->supported_fields)) {
			if (is_null($val)) {
				$update[] = $db->addslashes($key)." = null";
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
  

  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
  	$res=$db->query("delete from ".$this->table." where id=$id" );
  }
  
}
