<?php
/**
 */

class action_shopModel extends Model {
	private $table="`action_shop`";
  	//public $cachable = array('get_banners');
  	public $supported_fields = array('id', 'name', 'descr', 'shops');


  //подготовить список
  public function load_get(){
  	global $db;

		$query="select * from ".$this->table." order by id desc";
  	$res = $db->query($query);

  	if (! $db->num_rows($res)) {
  		return null;
  	}

		$actions=array();
		$shop=$this->get_model("shop");

  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
			$shops = [];
			$data['shops'] = json_decode($data['shops'], true);

			foreach ($data['shops'] as $shop_id){
				$shop_data = $shop->get_shop_info($shop_id, false);
				$shops[] = $shop_data;
			}
			$data["shops"] = $shops;

  		$actions[]=$data;
  	}
  	return $actions;
  }


  public function load_get_action($id){
  	global $db;
  	$res = $db->query("select * from ".$this->table." where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	$shop=$this->get_model("shop");

  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
			$shops = [];
			$data['shops'] = json_decode($data['shops'], true);
//var_dump($data);

			foreach ($data['shops'] as $shop_id){
//			var_dump($shop_id);
				$shop_data = $shop->get_shop_info($shop_id, false);
				$shops[] = $shop_data;
			}
			$data["shops"] = $shops;

  		$action[]=$data;

  		return $data;
  	}
  }

}
