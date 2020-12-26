<?php
/**
 * likes
 * @author sn
 *
 */

class wallModel extends dataModel {
  //public $cachable = array('get_cart','get_small_cart');
  public $supported_fields = array('id', 'person_id', 'person_to_id', 'time', 'object_id', 'object_name', 'status');
  public $supported_objects = array('news','message','item','photo','shop');
  protected $table="`wall`";

  public function share($params){
  	global $db;
  	$object_id = $params['object_id'];
  	$object_name = $db->addslashes($params['object_name']);
  	$time = $_SERVER['REQUEST_TIME'];
  	$person_id = $_SESSION['id'];
  	
        // get id user which this news (находим ид пользоваля чьей новостью поделились)
        $resultIdUser = $db->query("select `from`, `shop_id` from messages where id = ".$object_id);
        $resIdUser = $db->fetch_array($resultIdUser, MYSQLI_ASSOC);
        
        $person_to_id = $resIdUser['from'];
        if(!empty($resIdUser['shop_id'])) $shop_id = $resIdUser['shop_id'];
        else $shop_id = NULL;
        
  	$res = $db->query("select id from ".$this->table." where person_id=$person_id".  			
  			" and object_name='".$object_name."' and object_id=".$object_id);
  	
  	if (! $db->num_rows($res)) {
 		$people=$this->get_model("people");
		$friends=$people->get_friends($person_id);
	
		//себе
                if($shop_id != NULL) {
                    $db->query("insert into ".$this->table." (person_id,object_name,object_id,time,status, person_to_id, shop_id) values(".$person_id.
				", '".$object_name."', ".$object_id.",".$time.", 'new', ".$person_to_id.", ".$shop_id.")");
                } else {
                    $db->query("insert into ".$this->table." (person_id,object_name,object_id,time,status, person_to_id) values(".$person_id.
				", '".$object_name."', ".$object_id.",".$time.", 'new', ".$person_to_id.")");
                }
		//друзьям
  		/*foreach ($friends as $key => $val) {
			$person_to_id=$val['id'];
			$db->query("insert into ".$this->table." (person_id,object_name,object_id,time,status, person_to_id) values(".$person_id.
  					", '".$object_name."', ".$object_id.",".$time.", 'new', ".$person_to_id.")");
		}*/
		return 1;
  	}
  	
  	return 0;
  }
  
  public function isshare($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  	
  	//проверить есть ли share у этого объекта от этого пользователя
  	$res=$db->query("select id from ".$this->table." where person_id=".$params['person_id']." and object_id=".$params['object_id']." and object_name='".$params['object_name']."'");
  	$id=0;
    if ($db->num_rows($res)) {
    	if($data = $db->fetch_array($res,MYSQLI_ASSOC)) {  	
    		return $data['id'];
   		}
    }
	return 0;  	
  }
    
  //кто поделился объектом
  public function get_share_persons($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  	
  	$res = $db->query("select person_id from ".$this->table." where object_id=".$params['object_id']." and object_name='".$params['object_name']."' ". 
  			" and status<>'deleted' and person_id=person_to_id");
  	
  	if (! $db->num_rows($res)) {
  		return 0;
  	}
  	if($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		return $data['person_id'];
  	}
  	return 0;
  }

  //сколько поделений у объекта
  public function get_shares_num($params){
  	global $db;
  	$params['object_name'] = $db->addslashes($params['object_name']);
  
  	$res = $db->query("select count(person_id) as num from ".$this->table." where object_id=".$params['object_id']." and object_name='".$params['object_name']."' and status<>'deleted' and person_id=person_to_id");
  
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
  	$res = $db->query("delete from ".$this->table." where object_id=".$params['object_id']." and object_name=".$params['object_name']);
  	return null;
  }
  
  //подготовить список
  public function load_get_shares($params){
  	global $db;
  	//$details=(isset($params['details'])?$params['details']:false);

  	$filter=(isset($params['filter'])?$params['filter']:false);
  	$limit=(isset($params['limit'])?$params['limit']:1);
  	$start=(isset($params['start'])?$params['start']:0);
  	$person_id=(isset($params['person_id'])?$params['person_id']:0);
  
  	$res = $db->query("select * from ".$this->table." where status<>'deleted' "
  			.(($filter)?" $filter ":"")
  			." and person_id=".$person_id
  			." order by time desc limit $start, $limit");
  
  	if (! $db->num_rows($res)) {
  		return null;
  	}
        $shares = array();
  	$people=$this->get_model("people");
        
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['id']=$data['object_id'];
                if(empty($data['shop_id'])) $data['person']=$people->get_person_info($data['person_to_id']);
                else {
                    $resShop = $db->query("select id, name, thumbnail_url from shop where id = ".$data['shop_id']);
                    $dataShop = $db->fetch_array($resShop, MYSQLI_ASSOC);
                    $data['shop'] = $dataShop;
                }
  		$data['owner_wall'] = $people->get_person_info($person_id);
  		//TODO: showobject
  		$object=$this->get_model($data['object_name']);
  		//$object_data=$object->show($data['object_id']);
  		//$data['object']=$object_data;
  		
  		//есть ли права на удаление?
  		if($data['person_to_id']==$_SESSION['id']){
  			$data['can_delete']=1;
  		}
  		$shares[]=$data;
  	}
  	return $shares;
  }
  
}
