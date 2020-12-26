<?php
/**
 
 */

class addressController extends baseController {
 // private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF");
	
  public function index($params) {
    if (!isset($_SESSION["id"])) {
      echo json_encode(["error" => "Not Authorized"]);
      return;
		}

		$object = $_GET["object"];

    if (!isset($object) || !strlen($object) > 0) {
      echo json_encode(["error" => "Invalid data"]);
      return;
    }
  
		$address = $this->model("address");
		$addresses = $address->show([
			"object" => $object,
			"object_id" => $_SESSION["id"]
		]);

		echo json_encode(["data" => $addresses]);
  }

  public function compose() {
  	$people = $this->model('people');
  	$address = $this->model('address');
  	$fias = $this->model('fias');
  	
	$tops = $fias->get_top();	

  	$this->template('/address/address_compose.php', array(
  			'person' => $people->get_person($_SESSION['id'], false),
  			'tops' => $tops,
			'object'=>$_GET['object'], 
  			'object_id'=>$_GET['object_id'],
  			'id'=>$_GET['object_id']));
  }
  
  
  public function get_kids() {
  	$people = $this->model('people');
  	$address = $this->model('address');
	  $fias = $this->model('fias');
	  
	$level = $fias->get_kids($_REQUEST['aoguid']);
	$house = array();
	if(empty($level)){
	    $house = $fias->get_houses($_REQUEST['aoguid']);
	}
  	$this->template('/address/level.php', array(
  			'house' => $house,
  			'level' => $level));
  }
  

  public function send($params) {
  	if (empty($_POST['object']) or empty($_POST['object_id'])) return;
  	
  	$address = $this->model('address');
        $object = $this->model($_POST['object']);
    
    //$_POST['country_code'] = "RU"; //адреса только в России
    $aoid = "";
    $houseid = "";
    $maxi = ""; $mini = "11111111";
    while (list($entry, $value) = each($_POST)) {
    	if(preg_match("/^address.([0-9]+)/", $entry, $found)){
    	    if(strlen($found[0])>strlen($maxi)){
    		$maxi=$found[0];
    	    }
    	    if(strlen($found[0])<strlen($mini)){
    		$mini=$found[0];
    	    }
    	}
    }
    $top_aoid = $_REQUEST[$mini]; //первый select в форме
    $houseid = $_REQUEST[$maxi]; //последний select в форме
    $aoid = $_REQUEST[ mb_strcut($maxi, 0, strlen($maxi)-1) ]; //предпоследний select в форме
    
    $id=$params[3];
    if(isset($id) and is_numeric($id)){
    	$address->save($id, array(
    			'object'=>$_POST['object'],
    			'object_id'=>$_POST['object_id'],
    			'country_code'=>$_POST['country_code'],
    			'postalcode'=>$_POST['postalcode'],
    			'object'=>$_POST['object'],
    			'additional'=>$_POST['more'],
    			'city'=>$_POST['city'],
    			'aoid'=>$aoid,
    			'houseid'=>$houseid,
    			'addrstring'=>$_POST['addstring'],
    			'aoidpath'=>$_POST['addpath']));
    }else{
    	$results = $address->add(array(
    			'object'=>$_POST['object'],
    			'object_id'=>$_POST['object_id'],
    			'country_code'=>$_POST['country_code'],
    			'postalcode'=>$_POST['postalcode'],
    			'object'=>$_POST['object'],
    			'additional'=>$_POST['more'],
    			'city'=>$_POST['city'],
    			'aoid'=>$aoid,
    			'houseid'=>$houseid,
    			'addrstring'=>$_POST['addstring'],
    			'aoidpath'=>$_POST['addpath']));
    }
    //сохранить город в object
    if($_POST['object'] == "shop"){
//    echo var_dump($_POST);
      $object->save_shop($_POST['object_id'], array("city"=>$_POST['city']));
    }
    if($_POST['object'] == "people"){
      $object->save_person($_POST['object_id'], array("city"=>$_POST['city']));
    }
          
	if(isset($_SERVER["HTTP_REFERER"])){
	  $tmp = $_SERVER["HTTP_REFERER"];
	}else{
	  $tmp = '/';
	}
	header('Location: '.$tmp);
  	
//  return $this->show($params);
  }
  

  public function foredit($params) {
  	$_GET['id']=(isset($_GET['id'])?$_GET['id']:0);
  	
  	$address = $this->model('address');
  	$fias = $this->model('fias');
  	$addr = $address->get($_GET['id']);
  	
  	$addr['aoidpaths'] = preg_split('/ /', $addr['aoidpath']);
	//улицы и тд
  	$addr['levels'] = array();
  	$levelindex = 0;
  	for($levelindex = 1; $levelindex < count($addr['aoidpaths'])-2; $levelindex++){
		$id = $addr['aoidpaths'][$levelindex-1];//id с предыдущего уровня
		$level = $fias->get_kids($id);
  	 	$addr['levels'][$levelindex]['level'] = $level;  	
  	}
  	
  	//дома
  	$level = $fias->get_houses($addr['aoidpaths'][count($addr['aoidpaths'])-3]);
	$addr['houses']['level'] = $level;  	
	//регионы
  	$tops = $fias->get_top();
  	$addr['tops'] = $tops;  	

  	$this->template('/address/address_edit.php', 
			$addr);
  }

  public function delete($params) {
  	$id=$params[3];
  	
  	$address = $this->model('address');
  	$address->delete($id);
	
	if(isset($_SERVER["HTTP_REFERER"])){
	  $tmp = $_SERVER["HTTP_REFERER"];
	}else{
	  $tmp = '/';
	}
	header('Location: '.$tmp);
//  	return $this->show($_GET);
  }
  
  public function can_delete($ownerd) {
  	if(in_array($_SESSION['id'], $ownerd)){
  		return true;
  	}  
  	return false;
  }
  
}