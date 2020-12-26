<?php
/**
 * car
 * @author sn
 *
 */

class price2parseModel extends Model {
//  public $cachable = array('get');
  public $supported_fields = array('id', 'shop_id', 'file', 'title', 'email', 'status', 'date','isspec','descr');
//  public $supported_objects = array('news','message','item','photo','shop');
  private $table="`price2parse`";

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
    $shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
    $status=(isset($params['status'])?$params['status']:0);

  	$res = $db->query("select * from ".$this->table." where 1 "
      .(isset($params['shop_id'])?" and shop_id=".$params['shop_id']:"")
      .(isset($params['status'])?" and status=".$params['status']:"")
 			." order by `date` ");

  	if (! $db->num_rows($res)) {
  		return null;
  	}

  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$pr[]=$data;
  	}
  	return $pr;
  }

  //показать
  public function load_get_price($id, $details=false){
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
