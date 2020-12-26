<?php
/**
 */

class currencyModel extends Model {
  public $cachable = array('get_currencies');
  public $supported_fields = array('id', 'name_en', 'koef');//'thumbnail_url',

  
  //подготовить список 
  public function load_get_currencies($shop_id = null){
  	global $db;
  	$res = $db->query("select * from `currency` order by ordr");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	$groups=array();
	
	$currency_id=0;
	
	if($shop_id){
		$shops = $this->get_model('shop');
		$shop = $shops->get_shop($shop_id, false);
		$currency_id=$shop['currency_id'];
	}
	
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$data['name']=$data['name_en'];
  		$data['isdefault'] = false;
  		if($currency_id==$data['id']){
  			$data['isdefault'] = true;
  		}
  		$groups[]=$data;  		
  	}
  	return $groups;
  }

  //показать валюту
  public function load_get_currency($id){
  	global $db;
	if(!isset($id)){
	  $id=1;
	}
  	$res = $db->query("select * from `currency` where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$data['name']=$data['name_en'];
  		return $data;
  	}
  }
  
  //показать валюту
  public function convert($from, $to, $price){
  	global $db;
  	if( !isset($from) or !isset($to) or ($to==$from)){
  		return $price;
  	}
  	$res = $db->query("select koef from `currencyconv` where `from`=$from and `to`=$to");
  	if (! $db->num_rows($res)) {
  		return $price;
  	}
  	$data = $res->fetch_array(MYSQLI_ASSOC);
  	//echo $data['koef']." * ".$price;
  	$price = $data['koef'] * $price;
  	//echo "=".$price."\n<br>";
  	return round($price,2);
  }
  
  
/*  
  //добавить группу
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);
    
    $keys[]="shop_id";
    $values[]=$shop_id;

    $keys[]="visible";
    $values[]=1;
    
    $keys[]="ordr";
    $res=$db->query("select max(ordr) as max_ordr from `group` where shop_id=$shop_id" );
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

    $query = "insert into `group` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
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
  		$query = "update `group` set " . implode(', ', $update) . " where id=$id";
  		$db->query($query);
  	}
  }
  
  public function set_thumbnail($id, $url) {
  	global $db;
  	$this->invalidate_dependency('group', $id);
  	$id = $db->addslashes($id);
  	$url = $db->addslashes($url);
  	$db->query("update `group` set thumbnail_url = '$url' where id = $id");
  }

  //удалить группу
  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
  	$res=$db->query("delete from `group` where id=$id" );
  	$this->delete_by_group_id($id);
  }

  //удалить подгруппы
  public function delete_by_group_id($group_id){
  	global $db;
  	$group_id = $db->addslashes($group_id);

  	$res=$db->query("select id from `group` where group_id=$group_id" );
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$this->delete($data['id']);
  	}  	  	
  }
*/   
}
