<?php
/**
 */

class countryModel extends Model {
 public $cachable = array('get_countries');
//  public $supported_fields = array('id', ...);

  
  //подготовить список стран
  public function load_get_countries($lang){
  	$lang=(isset($lang))?$lang:"en";
  	global $db;
  	$res = $db->query("select * from country where id in (171, 92, 80) order by ordr");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
        
	$countries=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$data['name']=$data['name_en'];
  		//$data['name']=$data['name_'.$lang];
                //$data['name']=$data['name_en'];
  		$countries[]=$data;
  	}
        //print_r($countries);
  	return $countries;
  }

  
}
