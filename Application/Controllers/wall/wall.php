<?php
/**
 
 */

class wallController extends baseController {

  public function index($params) {
  }
  
  public function share($params) {
    $wall = $this->model('wall');
    
    if (!empty($_GET['object_name']) and !empty($_GET['object_id'])) {
    	$object = $this->model($_GET['object_name']);

      	$results = $wall->share(array(
      		'object_name'=>$_GET['object_name'],
      		'object_id'=>$_GET['object_id']));
      
      	$shares_num = $wall->get_shares_num(array(
      		'object_name'=>$_GET['object_name'],
      		'object_id'=>$_GET['object_id']));

      	$object = $this->model($_GET['object_name']);
      	$object->save($_GET['object_id'], array("shared_num"=>$shares_num));
      
      	$this->template('wall/wall_num.php', array('shared'=>$results,  
      			'shares_num'=>$shares_num,
      			'object_name'=>$_GET['object_name'], 
      			'object_id'=>$_GET['object_id'],
      			'is_small'=>$_GET['is_small']));
      	
    }
     
  }
  
  public function show($params) {
  	$wall = $this->model('wall');
  
	$results = $wall->get_shares(array('person_to_id'=>$_SESSION['id']));
  
	$shares_num = $wall->get_shares_num(array(
  				'object_name'=>$_GET['object_name'],
  				'object_id'=>$_GET['object_id']));
  
	$this->template('wall/wall.php', array('wall'=>$results,
  				'shares_num'=>$shares_num,
  				'object_name'=>$_GET['object_name'],
  				'object_id'=>$_GET['object_id'],
  				'is_small'=>$_GET['is_small']));
    }
}
