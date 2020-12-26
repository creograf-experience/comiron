<?php
/**
 * car
 * @author sn
 *
 */

class profilephoneController extends baseController {
 	
  public function index($params) {
  }

  
  public function get($id){
  	$model = $this->model('profilephone');
  	$result=$model->show(array("id"=>$id));
  	
  	$this->template('/profile/profile_model_ajax.php', array('result' => $result));
  }
  
  public function save($params) {
  	$id=$params[3];
    //сохранить
    $profilephone = $this->model('profilephone');
  
    //$created = $_SERVER['REQUEST_TIME'];
    $person_id=$_SESSION['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : false;
 
    //создать
  	if(!($id) or !is_numeric($id)){
    		$profilephone->add(array(
          'person_id'=>$person_id,
          'name'=>$name,
      ));
  	} else {
    //сохранить
    	$profilephone->save($id, array(
    			'person_id'=>$person_id,
    			'name'=>$name,
    	));

    	//print $car_id;
    }
  }
  
  public function delete($params) {
  	$id=$params[3];
  	
  	$profilephone = $this->model('profilephone');
  	$profilephone->delete($id);
  
  	return $this->show(array());
  }
  
  public function can_delete($ownerd) {
  	if(in_array($_SESSION['id'], $ownerd)){
  		return true;
  	}  
  	return false;
  }
   
  public function show($params){
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	
  	if (! isset($params[3]) || ! is_numeric($params[3])) {
  		$person_id = $_SESSION['id'];  		
  	}else{
  		$person_id = $params[3];
  	}
  	 
  	$profilephone = $this->model('profilephone');
  	$profilephones= $profilephone->show(array("person_id"=>$person_id));
  	 
  	$this->template('/profile/profile_carlist.php', array('profilephone' => $profilephones));
  }
  
  
}