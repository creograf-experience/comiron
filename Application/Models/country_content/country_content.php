<?php
/**
 */

class country_contentModel extends Model {
 public $cachable = array('get_countries');
//  public $supported_fields = array('id', ...);
  private $table="country_content";

  
  //подготовить список стран
  public function load_get_countries($lang){//="en"
  	global $db;
  	//$db->query("select * from ".$this->table." order by ordr");
  	$lang=(isset($lang))?$lang:"en";
  	
  	$res = $db->query("select * from ".$this->table." order by ordr");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	$countries=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//текущая выбранная страна
  		if(isset($_SESSION['country_content_code2']) and $_SESSION['country_content_code2']==$data['code2']){
  			$data['is_current']=true;
  		}else{
  			$data['is_current']=false;
  		}
  		$data['name']=$data['name_'.$lang];
  		$countries[]=$data;
  	}
  	return $countries;
  }
  
  
  //подготовить массив двухсимвольных кодов стран
  public function load_get_code2s(){
  	global $db;
  	//$db->query("select * from ".$this->table." order by ordr");
  	 
  	$res = $db->query("select code2 from ".$this->table." order by ordr");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	$countries=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$countries[]=$data['code2'];
  	}
  	return $countries;
  }
  
  //дать страну по коду
  public function load_get_country($code,$lang){//="en"
  	global $db;
  	//$db->query("select * from ".$this->table." order by ordr");
  	$lang=(isset($lang))?$lang:"en";
  
  	$res = $db->query("select * from ".$this->table." where code2='".$code."'");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	$data = $res->fetch_array(MYSQLI_ASSOC);
  	$data['name']=$data['name_'.$lang];
  	return $data;
  }
}
