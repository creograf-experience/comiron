<?php
/**
 */

class actionModel extends Model {
	private $table="`action`";
  	//public $cachable = array('get_banners');
  	public $supported_fields = array('id', 'product_id', 'discount');

  
  //подготовить список 
  public function load_get(){
  	global $db;

	$query="select * from ".$this->table." order by ordr";
  	$res = $db->query($query);

  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	
	$action=array();
	$product=$this->get_model("product");
	
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$p = $product->get_product($data['product_id'], true);
  		$p['product_id'] = $data['product_id'];
  		$p['action_id'] = $data['id'];
  		$p['discount'] = $data['discount'];
  		
  		$p['oldprice'] = $p['price'];
  		$p['price'] = round($p['price'] * (100 - $p['discount']))/100;
  		
  		$action[]=$p;  		
  	}
  	return $action;
  }
  

  public function load_get_action($id){
  	global $db;
  	$res = $db->query("select * from ".$this->table." where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	$product=$this->get_model("product");
	
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$p = $product->get_product($data['product_id'], true, true);
  		$p['discount'] = $data['discount'];
  		
  		$p['oldprice'] = $p['price'];
  		$p['price'] = round($p['price'] * (100 - $p['discount']))/100;
  		 
  		return $p;
  	}
  }
  
}
