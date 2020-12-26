<?php
/**
 * education
 * @author sn
 *
 */

class educationModel extends Model {
//  public $cachable = array('get');
  public $supported_fields = array('id', 'person_id', 'name', 'city', 'from', 'to', 'type', 'country', 'class');
//  public $supported_objects = array('news','message','item','photo','shop');
  private $table="`person_education`";
  
  //добавить
  public function add($params){
  	global $db;
  	if(!isset($params['person_id'])){
  		$params['person_id'] = $_SESSION['id'];
  	}

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
  
  	$query = "insert into ".$this->table." (`" . implode('`, `', $keys) . "`) values(".implode(", ", $values).")";
  	#return "insert into ".$this->table." (`" . implode('`, `', $keys) . "`) values(".implode(", ", $values).")";
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
  				$update[] =  "`".$db->addslashes($key)."` = null";
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
  
  //подготовить список
  public function show($params){
  	global $db;
  	$person_id=(isset($params['person_id'])?$params['person_id']:0);
  	$type=(isset($params['type'])?$params['type']:0);
  	
 	$res = $db->query("select * from ".$this->table." where 1 "
  			.(isset($params['person_id'])?" and person_id=".$params['person_id']:"")
 			.(isset($params['type'])?" and type='". $db->addslashes($params['type'])."'":"")
 			." order by `type`,`to` ");
  
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['id']=$data['object_id'];
  		//$data['person'] = $people->get_person_info($data['person_id']);
  		
  		//есть ли права на удаление?
  		$data['can_delete']=$this->can_delete(array($data['person_id']));
  		
  		$edu[]=$data;
  	}
  	return $edu;
  }
  
  //показать
  public function load_get_edu($id, $details=false){
  	global $db;
  	$res = $db->query("select * from ".$this->table." where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		if($details){
//  			...
  		}
  		return $data;
  	}
  }
  
 
  public function delete($id){
  	global $db;

  	//проверка прав на удаление
  	$data=$this->get_edu($id);
  	
  	if(!$this->can_delete(array($data['person_id']))) return;
  	
  	$res = $db->query("delete from ".$this->table." where id=".$id);
  	return null;
  }

  
  public function can_delete($ownerd) {
  	if(in_array($_SESSION['id'], $ownerd)){
  		return true;
  	}
  	return false;
  }
  
}
