<?php
/**
 */

class tagModel extends Model {
  public $cachable = array('getall', 'getperson_tags', 'get', 'getpersons');
  public $supported_fields = array('id', 'tag', 'shop_id');
  public $table="`shop_tags`";
  public $supported_fields_client = array('tag', 'person_id',"shop_id","tag_id");
  public $table_client="`person_tags`";


  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      $id = $this->add($shop_id, $_REQUEST);
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->get($id);
  }

  public function GET($id){
    return $this->get($id);
  }

  public function GETlist($shop_id){
    return $this->getall($shop_id);
  }

  //подготовить список
  public function load_getall($shop_id=0){
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

  //подготовить 1 запись
  public function load_get($id){
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

  //добавить
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

  //удалить
  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
    $res=$db->query("delete from ".$this->table." where id=$id" );
    $res=$db->query("delete from ".$this->table_client." where tag_id=$id" );
  	//$this->delete_by_group_id($id);
  }

  public function load_get_usertags($shop_id, $client_id){
  	global $db;
  	$client_id = $db->addslashes($client_id);
  	$shop_id = $db->addslashes($shop_id);

  	$res=$db->query("select tag from ".$this->table_client." where shop_id=$shop_id and person_id=$client_id" );
  	$arr=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$arr[]=$data['tag'];
  	}
  	return $arr;
  }

  public function load_get_users_by_tags($shop_id, $tags_id){
  	global $db;
  	$shop_id = $db->addslashes($shop_id);

    if(!count($tags_id)) return [];

  	$res=$db->query("select person_id from ".$this->table_client." where shop_id=$shop_id and tag_id in (".implode(', ', $tags_id).")" );
  	$arr=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$arr[]=$data['person_id'];
  	}
  	return $arr;
  }

  public function load_getperson_tagschecked($shop_id, $client_id){
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
  		$res2=$db->query("select tag from ".$this->table_client." where tag_id=".$data['id']." and shop_id=$shop_id and person_id=$client_id" );
  		$data['ismy']=false;
  		if ($db->num_rows($res2)) {
			$data['ismy']=true;
  		}
  		$groups[]=$data;
  	}
  	return $groups;
  }

  public function saveperson_tags($shop_id, $client_id, $data){
  	global $db;
  	$client_id = $db->addslashes($client_id);
  	$shop_id = $db->addslashes($shop_id);
//var_dump($data);
  	$db->query("delete from ".$this->table_client." where shop_id=$shop_id and person_id=$client_id" );
  	$tags=$this->getall($shop_id);
  	foreach($tags as $t){
  		if(in_array($t["id"], $data["tag_id"])){
  			//echo $g['id']."!";
  			$db->query("insert into ".$this->table_client." (shop_id, person_id,tag,tag_id) values ($shop_id,$client_id,'".$t["tag"]."',".$t['id'].")");
  		}
  	}
  }



}
