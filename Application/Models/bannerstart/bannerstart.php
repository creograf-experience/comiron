<?php
/**
 */

class bannerstartModel extends Model {
	private $table="`banner`";
  	//public $cachable = array('get_banners');
  	public $supported_fields = array('id', 'link', 'isbig','isvisible','ordr','shown', 'clicked', 'img');

  
  //подготовить список 
  public function load_get_banners(){
  	global $db;

	//показаны
	$query="update ".$this->table." set shown = shown + 1 where isvisible>=0";
  	$res = $db->query($query);
  	
	$query="select * from ".$this->table." where isvisible>=0 order by ordr";
  	$res = $db->query($query);

  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	
	$banners=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$banners[]=$data;  		
  	}
  	return $banners;
  }
  

  public function load_get_banner($id){
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
  public function add($params){
    global $db;
    $shop_id = $db->addslashes($shop_id);
    

/*    $keys[]="visible";
    $values[]=1;*/
    
    $keys[]="ordr";
    $res=$db->query("select max(ordr) as max_ordr from ".$this->table );
    $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
    $values[]=1+$max_ordr['max_ordr'];
    
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


  public function prepare_new($params) {
  	global $db;
  	$fields=false;
  	$values=false;
  
  	foreach ($params as $key => $val) {
  		if (in_array($key, $this->supported_fields)) {
  			$fields[] = $key;
  			if (is_null($val)) {
  				$values[] = 'null';
  			} else {
  				$values[] = "'" . $db->addslashes($val) . "'";
  			}
  		}
  	}
  
  	if($values){
  		$fields[]="ordr";
  		$res=$db->query("select max(ordr) as max_ordr from ".$this->table." where" );
  		$max_ordr = $res->fetch_array(MYSQLI_ASSOC);
  		$values[]=1+$max_ordr['max_ordr'];
  
  		$query = "insert into ".$this->table." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
  		$db->query($query);
  		return $db->insert_id();
  	}
  }
  
}
