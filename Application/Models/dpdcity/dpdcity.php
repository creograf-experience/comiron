<?php
/**
 */

class dpdcityModel extends Model {
  //public $cachable = array('get_cart','get_small_cart');
  private $table = "dpdcity";
  
  private $fields = array('id', 'country', 'region','name', 'abbr', 'minindex','maxindex', 'uid', 'kladr', 'rayon');
  
  public function search($name){
  	global $db;
	  
  	if(!isset($name) and strlen($name)>3) return;
 
    $res = $db->query("select * from ".$this->table." where name like \"%$name%\" ".
  		" order by name");//or rayon like \"$name\"
    	
  	if (! $db->num_rows($res)) {
  			return; 
  	}

  	$result=array();
  	while($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//echo var_dump($data);
      $result[]=$data;
  	}
  	return $result;

  }

  public function get($id){
    global $db;
    
    if(!isset($name) and strlen($name)>3) return;
 
    $res = $db->query("select * from ".$this->table." where id=$id ");

    if (! $db->num_rows($res)) {
      return; 
    }

    if($data = $res->fetch_array(MYSQLI_ASSOC)) {
      return $data;
    }
    
  }

  
}
