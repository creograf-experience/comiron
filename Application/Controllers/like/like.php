<?php
/**
 
 */

class likeController extends baseController {

  public function index($params) {
  }
  
  public function like($params) {
    $error = false;
    $results = array();
    $friends = array();
    $like = $this->model('like');
    
    if (!empty($_GET['object_name']) and !empty($_GET['object_id'])) {
    	$object = $this->model($_GET['object_name']);
    	

      	$results = $like->like(array(
      		'object_name'=>$_GET['object_name'],
      		'object_id'=>$_GET['object_id']));
      
      	$likes_num = $like->get_likes_num(array(
      		'object_name'=>$_GET['object_name'],
      		'object_id'=>$_GET['object_id']));

      	$object = $this->model($_GET['object_name']);
      	$object->save($_GET['object_id'], array("likes_num"=>$likes_num));
      
      	$this->template('like/like.php', array('liked'=>$results,  'likes_num'=>$likes_num,
      			'object_name'=>$_GET['object_name'], 'object_id'=>$_GET['object_id'],
      			'is_small'=>$_GET['is_small']));
      	
    }
     
  }
}
