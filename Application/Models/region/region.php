<?php
/**
 */

class regionModel extends Model {
 public $cachable = array('get_regions');
//  public $supported_fields = array('id', ...);

  
  //подготовить список регионов
  public function load_get_regions($country_id){
  	global $db;
  	$country_id = $db->addslashes($country_id);
  	$res = $db->query("select * from region where country_id=$country_id order by ordr");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	$region=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$data['name']=$data['name_en'];
  		$region[]=$data;
  	}
  	return $region;
  }
}
