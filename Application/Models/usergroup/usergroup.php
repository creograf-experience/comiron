<?php
/**
 */

class usergroupModel extends Model {
  public $cachable = array('get_usergroups', 'get_usergroups_of_user', 'get_usergroup');
  public $supported_fields = array('id', 'name', 'shop_id');
  public $table="`shop_usergroup`";


  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      $id = $this->add($shop_id, $_REQUEST);
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->get_usergroup($id);
  }

  public function GET($id){
    return $this->get_usergroup($id);
  }

  public function GETlist($shop_id){
    return $this->get_usergroups($shop_id);
  }
  
  //подготовить список 
  public function load_get_usergroups($shop_id=0){
  	global $db;
  	$res = $db->query("select * from ".$this->table." where shop_id=$shop_id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	$groups=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		$groups[]=$data;  		
  	}
  	return $groups;
  }

  //подготовить группу
  public function load_get_usergroup($id){
  	global $db;
  	if(!isset($id)){
  		return null;
  	}
  	$res = $db->query("select * from ".$this->table." where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		return $data;
  	}
  }
  
  //добавить группу
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);
    
    $keys[]="shop_id";
    $values[]=$shop_id;
/*
    $keys[]="visible";
    $values[]=1;
    
    $keys[]="ordr";
    $res=$db->query("select max(ordr) as max_ordr from `group` where shop_id=$shop_id" );
    $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
    $values[]=1+$max_ordr['max_ordr'];
*/    
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
  
  public function set_thumbnail($id, $url) {
  	global $db;
  	$this->invalidate_dependency('group', $id);
  	$id = $db->addslashes($id);
  	$url = $db->addslashes($url);
  	$db->query("update ".$this->table." set thumbnail_url = '$url' where id = $id");
  }

  //удалить группу
  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
  	$res=$db->query("delete from ".$this->table." where id=$id" );
  	//$this->delete_by_group_id($id);
  }

  //удалить подгруппы
/*  public function delete_by_group_id($group_id){
  	global $db;
  	$group_id = $db->addslashes($group_id);

  	$res=$db->query("select id from `group` where group_id=$group_id" );
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$this->delete($data['id']);
  	}  	  	
  }
*/
  
  public function load_get_usergroups_of_client($shop_id, $client_id){
  	global $db;
  	$client_id = $db->addslashes($client_id);
  	$shop_id = $db->addslashes($shop_id);
  	 
  	$res=$db->query("select usergroup_id from `shop_usergroup_client` where shop_id=$shop_id and client_id=$client_id" );
  	$arr=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$arr[]=$this->get_usergroup($data['usergroup_id']);
  	}  	
  	return $arr;
  }

  public function load_get_usergroups_of_clientedit($shop_id, $client_id){
  	global $db;
  	$client_id = $db->addslashes($client_id);
  	$shop_id = $db->addslashes($shop_id);

  	global $db;
  	$res = $db->query("select * from ".$this->table." where shop_id=$shop_id order by id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	$groups=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$res2=$db->query("select id from `shop_usergroup_client` where usergroup_id=".$data['id']." and client_id=$client_id" );
  		$data['ismy']=false;
  		if ($db->num_rows($res2)) {
			$data['ismy']=true;  			
  		}
  		$groups[]=$data;
  	}
  	return $groups;
  }

  public function save_usergroups_of_client($shop_id, $client_id, $data){
  	global $db;
  	$client_id = $db->addslashes($client_id);
  	$shop_id = $db->addslashes($shop_id);
  
  	$db->query("delete from `shop_usergroup_client` where shop_id=$shop_id and client_id=$client_id" );
  	$groups=$this->get_usergroups($shop_id);
  	foreach($groups as $g){
  		if(isset($data["group-".$g['id']])){
  			//echo $g['id']."!";
  			$db->query("insert into `shop_usergroup_client` (shop_id, client_id,usergroup_id) values ($shop_id,$client_id,".$g[id].")");
  		}
  	}	
  }
  
  //доступ к магазину по группам пользователей

  public function save_shop_access($shop_id, $usergroups, $type){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$type = $db->addslashes($type);
  	 
  	$db->query("delete from `shop_access` where shop_id=$shop_id and access_type='$type'" );
  	foreach($usergroups as $g){
  		$db->query("insert into `shop_access` (shop_id, shopusergroup_id, access_type, access) values ($shop_id,$g,'$type',1)");
  	}
  }
  
  //подготовить список
  //сейчас $type='product', на случай если будут другие варианты
  public function load_get_usergroups_access($shop_id=0, $type){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$type = $db->addslashes($type);
  	 
  	$res = $db->query("select * from ".$this->table." where shop_id=$shop_id order by id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}

  	$groups=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		$res2=$db->query("select access from `shop_access` where shop_id=$shop_id and shopusergroup_id=".$data['id']." and  access_type='$type'");
  		$data['options_'.$type]=0;
  		if ($db->num_rows($res2)) {  		
  			$data['options_'.$type]=1;
  		}
  		$groups[]=$data;
  	}
  	return $groups;
  }
  
  public function save_product_access($shop_id, $usergroups, $product_id){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$product_id = $db->addslashes($product_id);
  	  
  	$db->query("delete from `product_access` where shop_id=$shop_id and product_id=$product_id" );
  	foreach($usergroups as $g){
  		$db->query("insert into `product_access` (shop_id, shopusergroup_id, product_id, access) values ($shop_id,$g,$product_id,1)");
  	}
  }
  
  //подготовить список групп, которые могут видеть товар
  public function load_get_usergroups2products_access($shop_id=0, $product_id){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$product_id = $db->addslashes($product_id);
  	 
  	$res = $db->query("select * from ".$this->table." where shop_id=$shop_id order by id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  
  	$groups=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		$res2=$db->query("select access from `product_access` where shopusergroup_id=".$data['id']." and product_id='$product_id' and shop_id='$shop_id'");
  		$data['visible']=0;
  		if ($db->num_rows($res2)) {
  			$data['visible']=1;
  		}
  		$groups[]=$data;
  	}
  	return $groups;
  }
  
  //подготовить список групп, которые могут видеть группу
  public function load_get_usergroups2group_access($shop_id=0, $group_id){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$group_id = $db->addslashes($group_id);
  
  	$res = $db->query("select * from ".$this->table." where shop_id=$shop_id order by id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  
  	$groups=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		$res2=$db->query("select access from `group_access` where shopusergroup_id=".$data['id']." and group_id='$group_id' and shop_id='$shop_id'");
  		$data['visible']=0;
  		if ($db->num_rows($res2)) {
  			$data['visible']=1;
  		}
  		$groups[]=$data;
  	}
  	return $groups;
  }
  
  
  public function save_group_access($shop_id, $usergroups, $group_id){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$group_id = $db->addslashes($group_id);
  		
  	$db->query("delete from `group_access` where shop_id=$shop_id and group_id=$group_id" );
  	foreach($usergroups as $g){
  		$db->query("insert into `group_access` (shop_id, shopusergroup_id, group_id, access) values ($shop_id,$g,$group_id,1)");
  	}
  }
  
}
