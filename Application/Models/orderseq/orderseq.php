<?php
/**
 */

class orderseqModel extends Model {
  public $table = "`orderseq`";
  public $supported_fields = array('id',
  		'shop_id',
  		'person_id',
      'order_id',
      'json',
      'status'
  		);


  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      return array("status"=> "fail", "error"=>"no id for order");
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->show($id, null);
  }

  public function GET($id){
    return $this->show($id, null);
  }

  public function GETlist($shop_id){
    return $this->getlist( array("shop_id"=>$shop_id, "status"=>0) ) ;
  }

  //показать по id
  public function show($id, $details=false){
  	global $db;
  	$id = $db->addslashes(intval($id));
  	$res = $db->query("select * from ".$this->table." where id = " . $id);
  	$ret = $db->fetch_array($res, MYSQLI_ASSOC);

  	$comment=$this->get_model("comment");
  	$data['comments']=$comment->get_comments(array("object_name"=>"order", "object_id"=>$id, "orderby"=>"time desc"));
  	$currency=$this->get_model("currency");
  	if($data['currency_id']){
  		$data['currency']=$currency->get_currency($data['currency_id']);
  	}else{
  		$data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
  	}

  	$ret['status'] = $this->get_status($data['orderstatus_id']);
  	if($details){
		$ret['details'] = $this->get_details(array("order_id"=>$data['id']));
  	}

  	return $ret;
  }

  //добавить
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);

    $keys[]="shop_id";
    $values[]=$shop_id;

    foreach ($params as $key => $val) {
    	if (in_array($key, $this->supported_fields)) {
    		$keys[]=$db->addslashes($key);
        if (is_null($val)) {
          $values[] = "null";
        } else {
          if($key == "dpdcityid"){
            $values[] = 0;
          }else{
            $values[] = "'" . $db->addslashes($val) . "'";
          }
        }
      }
    }

    $query = "insert into ".$this->table." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
//echo $query;
    $db->query($query);
    $id=$db->insert_id();

    if(!$id){
    	return false;
    }

    return $id;
  }

  //удалить
  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
  	$res=$db->query("delete from ".$this->table." where id=$id" );
  }

  //сохранить
  public function save($id, $params){
  	global $db;
  	$id = $db->addslashes($id);
  	$update=false;

  	foreach ($params as $key => $val) {
  		if (in_array($key, $this->supported_fields)) {
  			if (is_null($val)) {
  				$update[] = $db->addslashes($key)." = null";
  			} else {
  				$update[] = "`".$db->addslashes($key)."` = '" . $db->addslashes($val) . "'";
  			}
  		}
  	}

  	if($update){
  		$query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
  		$db->query($query);
  	}
  }

  public function get_list($params) {
  	global $db;
  	$shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
    $order_id=(isset($params['order_id'])?$params['order_id']:0);
    $person_id=(isset($params['person_id'])?$params['person_id']:0);
  	$status=(isset($params['status'])?$params['status']:null);
    $limit = 100;

  	if($shop_id){
  		$query = "select ".$this->table.".*,
	  	concat(persons.first_name, ' ' , persons.last_name) as name,
	  	persons.thumbnail_url as thumbnail_url
	  	from ".$this->table.", persons
  		where 1 and ".$this->table.".shop_id=$shop_id
	  			and ".$this->table.".person_id=persons.id "
	  			.((is_numeric($status))?" and ".$this->table.".orderstatus_id=$status ":"")
  				."limit $limit";

  	}else{
	  	$query = "select ".$this->table.".*,
	  		shop.name as shop_name,
	  		shop.thumbnail_url as thumbnail_url
	  		from ".$this->table.", shop
  			where 1
	  			and shop.id=".$this->table.".shop_id "
	  			.(($shop_id)?" and ".$this->table.".shop_id<=$shop_id ":"")
	  			.((is_numeric($status))?" and ".$this->table.".status=$status ":"")
	  			.(($person_id)?" and ".$this->table.".person_id=".$person_id:"")
  				."limit $limit";
  	}
  	$res = $db->query($query);

  	$ret = array();
  	while ($order = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$ret[] = $order;
  	}
  	return $ret;
  }
}
