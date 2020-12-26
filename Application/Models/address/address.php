<?php
/**
 */

class addressModel extends Model {
  //public $cachable = array('load_shop','load_get');
  private $table = "address";
  private $supported_fields = array('id', 'postalcode', 'object', 'object_id', 'addrstring', 'postalcode', 'houseid', 'aoid', 'country_code', 'country_id', 'additional', 'aoidpath', 'city');


  public function load_get($id){
  	global $db;
	
	if(!$id) return null;

  	$res = $db->query("select * from ".$this->table." where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  
  	if($data = $res->fetch_array(MYSQLI_ASSOC)) {
	    return $data;
  	}
  }
  
  //подготовить список
  public function load_show($params){
  	global $db;
  	$object_id=(isset($params['object_id'])?$params['object_id']:0);
  	$object=(isset($params['object'])?$params['object']:0);
  	$filter=(isset($params['filter'])?$params['filter']:false);
  	
 	$res = $db->query("select * from ".$this->table." where 1 "
  			.(($filter)?" $filter ":"")
  			." and object_id=$object_id "
  			." and object='$object' "
 			." order by id "
 			//.((!$allpages)?" limit $start, $limit":"")
	);
    
  	if (! $db->num_rows($res)) {
  		return null;
  	}

  	$ar=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) { 		
  		//транслитерация?
		$ar[]=$data;
  	}
  	
  	return $ar;
  }
  
  //добавить
  public function add($params){
  	global $db;
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
  	$id=$db->insert_id();
  
  	return $id;
  }
  
  //сохранить
  public function save($id, $params){
  	global $db;
  	$id = $db->addslashes($id);
  	$update=false;
  
  	foreach ($params as $key => $val) {
  		if (in_array($key, $this->supported_fields)) {
  			if (is_null($val)) {
  				$update[] = $db->addslashes($key)." = null";
  			} else {
  				$update[] = "`".$db->addslashes($key)."` = '" . $db->addslashes($val) . "'";
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

  	//проверка прав на удаление
  	/*$data=$this->get_address($id);
  	if(!isset($data['object_id']) || !isset($data['object'])){
  		return;
  	}
  	
  	$object=$this->get_model($data['object']);  	 
  	$owners=$object->get_owners($data['object_id']);
  	if(!$this->can_delete(array($data['person_id'], $owners))) return;
  	*/

  	$res = $db->query("delete from ".$this->table." where id=".$id);
  	return null;
  }


}
