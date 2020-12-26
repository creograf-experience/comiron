<?php
/**
 * likes
 * @author sn
 *
 */

class likeModel extends Model {
  //public $cachable = array('get_cart','get_small_cart');
  public $supported_fields = array('id', 'person_id', 'time', 'object_id', 'object_name');
  public $supported_objects = array('news','message','item','photo','shop');
  

  public function like($params){
  	global $db;
  	$person_id = $_SESSION['id'];
  	$object_id = $params['object_id'];
  	$object_name = $db->addslashes($params['object_name']);
  	$time = $_SERVER['REQUEST_TIME'];
  	
  	$res = $db->query("select id from likes where person_id=$person_id".  			
  			" and object_name='".$object_name."' and object_id=".$object_id);
  	if (! $db->num_rows($res)) {
  		//like
  		$db->query("insert into likes (person_id,object_name,object_id,time ) values(".$person_id.
  				", '".$object_name."', ".$object_id.",".$time.")");
  		
  		return 1;
  	}
  
  	if($data = $db->fetch_array($res,MYSQLI_ASSOC)) {
  		//unlike;
  		$id=$data['id'];
  		$db->query("delete from likes where id=".$id);
  		
  		return -1;
  	}
  	
  	return 0;
  }
  
  public function isliked($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  	
  	//проверить есть ли like у этого объекта от этого пользователя
  	$res=$db->query("select id from `likes` where person_id=".$params['person_id']." and object_id=".$params['object_id']." and object_name='".$params['object_name']."'");
  	$id=0;
    if ($db->num_rows($res)) {
    	if($data = $db->fetch_array($res,MYSQLI_ASSOC)) {  	
    		return $data['id'];
   		}
    }
	return 0;  	
  }
    
  //кому нравиться объект
  public function get_likes($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  	
  	$res = $db->query("select person_id from likes where object_id=".$params['object_id']." and object_name='".$params['object_name']."'");
  	
  	if (! $db->num_rows($res)) {
  		return 0;
  	}
  	if($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		return $data['person_id'];
  	}
  	return 0;
  }

  //кому нравиться объект
  public function get_likes_num($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  
  	$res = $db->query("select count(person_id) as num from likes where object_id=".$params['object_id']." and object_name='".$params['object_name']."'");
  
  	if (! $db->num_rows($res)) {
  		return 0;
  	}
  	if($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		return $data['num'];
  	}
  	return 0;
  }
  
  //вызывается при удалении объекта, чтобы удалить его лайки 
  public function delete_object($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  	$res = $db->query("delete from likes where object_id=".$params['object_id']." and object_name=".$params['object_name']);
  	return null;
  }

  
}
