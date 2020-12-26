<?php
/**
 * car
 * @author sn
 *
 */

class carModel extends Model {
//  public $cachable = array('get');
  public $supported_fields = array('id', 'person_id', 'year', 'descr', 'complect', 'model_id', 'marka_id', 'isvisible', 'created');
//  public $supported_objects = array('news','message','item','photo','shop');
  private $table="`car`";
  
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
  	
 	$res = $db->query("select * from ".$this->table." where isvisible "
  			.(isset($params['person_id'])?" and person_id=".$params['person_id']:"")
 			." order by `year` ");
  
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	
  	$model=$this->get_model("car_model");
  	$marka=$this->get_model("car_marka");
  	$media=$this->get_model("medias");
  	 
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		
  		//есть ли права на удаление?
  		$data['can_delete']=$this->can_delete(array($data['person_id']));
  		$carmodel=$model->get($data['model_id']);
  		$data['model_name']=$carmodel['name'];
  		$data['model_name']=preg_replace ("/&nbsp;/", "" , $data['model_name'] );
  		
  		$carmarka=$marka->get($data['marka_id']);
  		
  		$data['marka_name']=$carmarka['name'];
  		
  		$data['medias'] = $media->get_medias(array("object_name" => "car", "object_id"=> $data['id']));
  		
  		
  		$edu[]=$data;
  	}
  	return $edu;
  }
  
  //показать
  public function load_get_car($id, $details=false){
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
  	$data=$this->get_car($id);
  	
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
  
  public function prepare_new_car($params) {
  	global $db;
  	$fields=false;
  	$values=false;
  	
  	$this->delete_old_empty_cars();
  	
  	$params['created']=$_SERVER['REQUEST_TIME'];
  
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
  		$query = "insert into ".$this->table." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
  		$db->query($query);
  		return $db->insert_id();
  	}
  }
  
  public function delete_old_empty_cars() {
  	global $db;
  	$created=$db->addslashes($_SERVER['REQUEST_TIME']-24*60*60);
  
  	$query = "delete from ".$this->table." where isvisible=0 and created<".$created;
  	$db->query($query);
  }

  //кол-во авто у пользователя
  public function load_get_cars_num($person_id){
  	global $db;
  	$res = $db->query("select count(id) as cars_num from ".$this->table." where isvisible and person_id=$person_id");
  	if (! $db->num_rows($res)) {
  		return 0;
  	}
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		return $data['cars_num'];
  	}
  	return 0;
  }
  
}
