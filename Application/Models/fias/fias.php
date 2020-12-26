<?php
/**
 */

class fiasModel extends Model {
  //public $cachable = array('get_cart','get_small_cart');
  private $table_addr = "d_fias_addrobj";
  private $table_house = "d_fias_house";

  private $addr_fields = array('aoid', 'parentguid', 'aolevel', 'postalcode', 'shortname', 'formalname');
  private $house_fields = array('aoguid', 'houseid',  'postalcode', 'housenum', 'buildnum', 'structnum');


  public function get_kids($aoguid){
  	global $db;
	
	if(!isset($aoguid)) return;

	$postalcode = $_GET['postalcode'];
	$postalcode = $db->addslashes($postalcode);
	$aoguid = $db->addslashes($aoguid);
  	
  	$res = $db->query("select * from ".$this->table_addr." where parentguid like \"$aoguid\"".
		($postalcode?" and postalcode like $postalcode":"").
		" order by formalname");
  	
	if (! $db->num_rows($res)) {
		//посмотреть дома
 /* 		$res = $db->query("select * from ".$this->table_house." where aoguid=$aoid");
  		if (! $db->num_rows($res)) {
			return; //нет ни улиц, ни домов
		}
  */	}
  
  	$result=array();
  	while($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//TODO транслитерация?
  		$result[]=$data;
  	}
  	return $result;
  }


  public function get_houses($aoguid){
  	global $db;
	
	if(!isset($aoguid)) return;

	$postalcode = $_GET['postalcode'];
	$postalcode = $db->addslashes($postalcode);
	$aoguid = $db->addslashes($aoguid);
  	
//  	echo "select * from ".$this->table_house." where aoguid like \"$aoguid\"".
//		($postalcode?" and postalcode like $postalcode":"").
//		" order by housenum";
  	$res = $db->query("select * from ".$this->table_house." where aoguid like \"$aoguid\"".
		($postalcode?" and postalcode like $postalcode":"").
		" order by housenum");
  	
	if (! $db->num_rows($res)) {
		//посмотреть дома
 /* 		$res = $db->query("select * from ".$this->table_house." where aoguid=$aoid");
  		if (! $db->num_rows($res)) {
			return; //нет ни улиц, ни домов
		}
  */	}
  
  	$result=array();
  	while($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//TODO транслитерация?
  		$result[]=$data;
  	}
  	return $result;
  }




  public function get_string($aoid){
  	global $db;
	$string = "";
	
	if(!isset($aoid)) return;

	$postalcode = $_GET['postalcode'];
	$postalcode = $db->addslashes($postalcode);
  	
  	$res = $db->query("select shortname, formalname, parentgiud from ".$this->table_addr." where aoid=$aoid");
  	
	if (! $db->num_rows($res)) {
			return; 
		
  	}
  
  	$data = $res->fetch_array(MYSQLI_ASSOC);

	if($data['parentguid']){
  		$prestring = $this->get_string($data['parentguid']);
	} 
  	
	$string = $presting.$data['shortname']." ".$data['formalname']. " ".$string;
	
	return $string;
  }
  
  public function get_top(){
  	global $db;
  	$res = $db->query("select * from ".$this->table_addr." where aolevel=1 order by formalname");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	
	$result=array();
  	while($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//TODO транслитерация?
  		
  		$result[]=$data;
  	}
  	return $result;
  }
  
  
}
