<?php
/**

 */

class actionController extends baseController {
 // private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF");

  public function index($params) {
    return $this->get_list();
/*
    $action_id = $params[2];
    if(!$action_id){
    }
    return $this->get($action_id);
*/

  }

	//список всех акций
	public function get_list($params){
		$action_shop = $this->model("action_shop");
		$actions = $action_shop->get();

		echo json_encode(["actions" => $actions]);
	}

	//показать акцию
	public function get($params){
	        $id = $params[3];
		$action_shop = $this->model("action_shop");
		$action = $action_shop->get_action($id);

		echo json_encode(["action" => $action]);
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
