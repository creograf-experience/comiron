<?php
/**
 */

class categoryModel extends Model {
 public $cachable = array('get_categories','get_category','get_categories_of_product');
//  public $supported_fields = array('id', ...);

  
  //подготовить список 
  public function load_get_categories($category_id=0, $details=false){
  	global $db;
  	
  	$lang=$this->get_cur_lang();
  	$lang=(isset($lang))?$lang:"en";
//echo "select category_parent.id from category_parent, category where category_parent.category_id=$category_id and category.id=category_parent.category_id order by category.name_".$lang;

  	$res = $db->query("select category_parent.id  as id, category.name_$lang from category_parent, category where category_parent.category_id=$category_id and category.id=category_parent.id and category.visible order by id"); //category.name_".$lang);
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	  $categories=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		$data=$this->get_category($data['id'], $details);
  		/*if($details){
  			$data['subs']=$this->get_categories($data['id'], $details);
  		}*/
  		$categories[]=$data;
  	}
  	return $categories;
  }

  //подготовить список
  public function load_get_category($id, $details=false){
  	global $db;
  	$res = $db->query("select * from category where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	
  	$lang=$this->get_cur_lang();
  	$lang=(isset($lang))?$lang:"en";
  	//echo $lang;
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$data['name']=$data['name_'.$lang];
  		if($details){
  			$data['subs']=$this->get_categories($data['id'], $details);
  		}
  		
  		return $data;
  	}
  }
  
  //for product 
  public function load_get_categories_of_product($product_id){
  	global $db;
  	$product_id = $db->addslashes($product_id);
  
  	$res=$db->query("select category_id from `category_product` where product_id=$product_id" );
  	$arr=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$arr[]=$this->get_category($data['category_id']);
  	}
  	return $arr;
  }
}
