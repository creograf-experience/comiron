<?php
/**
 * @author sn
 *
 */

class pageController extends baseController {
	
  public function index($params) {
  }

  public function get($params) {
  	
  	if (!isset($params[3])) {
  		header("Location: /");
		return;
  	}
	$this->template("/page/".$params[3].".php");//,array('person' => $person));
  }
  
}