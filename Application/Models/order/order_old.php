<?php
/**
 */

class orderModel extends Model {
  public $cachable = array('get_myorders');
  public $table = "`order`";
  private $orderdetail = "`orderdetail`";
  private $orderstatus = "`orderstatus`";
  private $perpage = 20;
  public $supported_fields = array('id',
  		'shop_id',
  		'person_id',
  		'sum',
  		'currency_id',
  		'orderstatus_id',
  		'ispayed',
  		'dataorder',
		  'currency_id',
  		'comment_person',
  		'comment_shop',
  		'comment_num',
  		'isuserarchive',
  		'delivery',
  		'phone',
      'address',
      'postalcode',
      'category',
      'numpack',
      'weight',
      'volume',
      'city',
      'terminal',
      'date_pickup',
      'deliverydate',
      'deliverystate',
      'deliverynum',
      'deliverycost',
      'pickupzip',
      'rupost_pdf',
      'dpdcityid',
      'deliverytype',

      //адрес доставки до двери дпд
      'dpdcity',
      'dpdstreetprefix',
      'dpdstreet',
      'dpdhouse',
      'dpdkorpus',
      'dpdstroenie',
      'dpdvladenie',
      'dpdoffice',
      'dpdflat',

      //hermes
      'hermes_id',
      'contactname',
	  'track_number'
  		);
  public $supported_fields_od = array('id',
  		'order_id',
  		'shop_id',
  		'person_id',
  		'product_id',
  		'product_name',
  		'code',
  		'photo_url',
  		'num',
  		'price',
  		'sum',
  		'currency_id',
  		'char_id'
  );


  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      return array("status"=> "fail", "error"=>"no id for order");
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->get_order($id, null, $shop_id);
  }

  public function GET($id, $shop_id){
    return $this->get_order($id, null, $shop_id);
  }

  public function GETlist($shop_id){
    return $this->get_orders( array("shop_id"=>$shop_id, "orderstatus_id"=>1) ) ;
  }

  public function get_order($id, $person_id, $shop_id){
  	global $db;

  	if($shop_id){
  		$query = "select ".$this->table.".*,
  			concat(persons.first_name, ' ' , persons.last_name) as name,
	  		persons.thumbnail_url as thumbnail_url
  			from ".$this->table.", persons
  			where ".$this->table.".id=$id and
  			".$this->table.".shop_id=$shop_id and
			persons.id=".$this->table.".person_id";


  	}else
  	if($person_id){
  		$query = "select ".$this->table.".*,
  			shop.name as shop_name,
	  		shop.thumbnail_url as thumbnail_url
	  		from ".$this->table.", shop
  			where ".$this->table.".id=$id and
  				".$this->table.".person_id=$person_id and
	  			shop.id=".$this->table.".shop_id";
  	}
  	$res = $db->query($query);

  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	$comment=$this->get_model("comment");
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
			$data['status'] = $this->get_status($data['orderstatus_id']);
			$data['details'] = $this->get_details(array("order_id"=>$data['id']));
			$data['comments']=$comment->get_comments(array("object_name"=>"order", "object_id"=>$data['id'], "orderby"=>"time desc"));


			$currency=$this->get_model("currency");
  			if($data['currency_id']){
  				$data['currency']=$currency->get_currency($data['currency_id']);
  			}else{
  				$data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
  			}
  		return $data;
  	}
  }

  //показать по id (wall и т.д.)
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

  //для комментариев
  public function get_owners($id) {
  	global $db;
  	$res = $db->query("select `person_id` from ".$this->table." where id=$id");
  	$ret = $db->fetch_array($res, MYSQLI_ASSOC);
  	//?добавить владельца и сотрудников магазина
  	return array($ret['person_id']);
  }



  //добавить
  public function add($shop_id, $params, $products){
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
    //echo $query ;
    $db->query($query);
    $order_id=$db->insert_id();

    if(!$order_id){
    	return false;
    }

    //echo var_dump($products);

    //товары
    if(is_array($products)){
	    foreach ($products as $p) {
	    	$keys = array();
    		$values = array();

 		   	/*$keys[]="shop_id";
   		 	$values[]=$shop_id;*/

	    	$keys[]="order_id";
	    	$values[]=$order_id;

 		   	foreach ($p as $key => $val) {
 		   		if($key == "id") continue;

    			if (in_array($key, $this->supported_fields_od)) {
    				$keys[]=$db->addslashes($key);

            if (is_null($val)) {
    					$values[] = "null";
    				} else {
    					$values[] = "'" . $db->addslashes($val) . "'";
    				}
            //echo $key." ".$val;
    			}
    		}
    		$query = "insert into ".$this->orderdetail." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    		$db->query($query);
    		$id=$db->insert_id();
	    }
    }

    return $order_id;
  }

  //удалить
  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
  	$res=$db->query("delete from ".$this->table." where id=$id" );
  }

  /* показать заказы */
  public function get_orders($params) {
  	global $db;
  	$shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
  	$person_id=(isset($params['person_id'])?$params['person_id']:0);
  	$curpage=(isset($params['curpage'])?$params['curpage']:0);
    $delivery=(isset($params['delivery'])?$db->addslashes($params['delivery']):0);
    $fromdate=(isset($params['fromdate'])?$params['fromdate']:0);
  	$todate=(isset($params['todate'])?$params['todate']:0);
  	$orderstatus_id=(isset($params['orderstatus_id'])?$params['orderstatus_id']:null);
  	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;

  	if($shop_id){
  		$query = "select ".$this->table.".*,
	  	concat(persons.first_name, ' ' , persons.last_name) as name,
	  	persons.thumbnail_url as thumbnail_url
	  	from ".$this->table.", persons
  		where 1 and ".$this->table.".shop_id=$shop_id
	  			and ".$this->table.".person_id=persons.id "
	  			.(($fromdate)?" and ".$this->table.".dataorder>=$fromdate ":"")
	  			.(($todate)?" and ".$this->table.".dataorder<=$todate ":"")
	  			.((is_numeric($orderstatus_id))?" and ".$this->table.".orderstatus_id=$orderstatus_id ":"")
          .((is_array($orderstatus_id))?" and ".$this->table.".orderstatus_id in (".implode(', ', $orderstatus_id)." )":"")
          .(($delivery)?" and ".$this->table.".delivery='$delivery' ":"")
          ." order by ".$this->table.".dataorder desc
  				limit $limit";

  	}else{
	  	$query = "select ".$this->table.".*,
	  		shop.name as shop_name,
	  		shop.thumbnail_url as thumbnail_url
	  		from ".$this->table.", shop
  			where 1
	  			and shop.id=".$this->table.".shop_id "
	  			.(($fromdate)?" and ".$this->table.".dataorder>=$fromdate ":"")
	  			.(($todate)?" and ".$this->table.".dataorder<=$todate ":"")
	  			.(($shop_id)?" and ".$this->table.".shop_id<=$shop_id ":"")
	  			.(($delivery)?" and ".$this->table.".delivery='$delivery' ":"")
          .((is_numeric($orderstatus_id))?" and ".$this->table.".orderstatus_id=$orderstatus_id ":"")
	  			.((is_array($orderstatus_id))?" and ".$this->table.".orderstatus_id in (".implode(', ', $orderstatus_id)." )":"")
	  			.(($person_id)?" and ".$this->table.".person_id=".$person_id:"").
  				" order by ".$this->table.".dataorder desc
  				limit $limit";
  	}
  	$res = $db->query($query);

  	$ret = array();
  	$currency=$this->get_model("currency");
  	$comment=$this->get_model("comment");
  	while ($order = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$order['comments']=$comment->get_comments(array("object_name"=>"order", "object_id"=>$order['id'], "orderby"=>"time desc"));
  		$order['currency'] = $currency->get_currency($order['currency_id']);
  		$order['status'] = $this->get_status($order['orderstatus_id']);
  		$order['num'] = $this->get_num($order['id']);
  		//5 товаров из заказа
  		$order['details'] = $this->get_details(array("order_id"=>$order['id'], 'start'=>0, 'limit'=>5));
  		$ret[] = $order;
  	}
  	return $ret;
  }

  public function get_order_pages($params) {
  	global $db;
  	$shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
  	$person_id=(isset($params['person_id'])?$params['person_id']:0);
  	$curpage=(isset($params['curpage'])?$params['curpage']:0);
  	$fromdate=(isset($params['fromdate'])?$params['fromdate']:0);
  	$todate=(isset($params['todate'])?$params['todate']:0);
  	$status=(isset($params['status'])?$params['status']:0);
  	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;

  	$query = "";

  	if($shop_id){
  		$query = "select count(".$this->table.".id) as number_of_orders	from ".$this->table."
  			where 1
  				and ".$this->table.".person_id=".$person_id;

  	}else
  	if($person_id){
  		$query = "select count(".$this->table.".id) as number_of_orders from ".$this->table."
  			where 1
	  			and ".$this->table.".person_id=".$person_id;
  	}
  	$res = $db->query($query);
  	$num = $db->fetch_array($res, MYSQLI_ASSOC);

  	$total = (int)( ( $num['number_of_orders'] - 1 ) / $this->perpage ) + 1;
  	$next=false;
  	if($total>$curpage+1){
  		$next=$curpage+1;
  	}
  	return array("nextpage"=>$next,
  			"totalpages"=>$total);
  }

  public function get_status($status_id) {
  	global $db;

  	if(!$status_id>0)
  		return "";

  	$query = "select name from ".$this->orderstatus." where id=".$status_id;

  	$res = $db->query($query);
  	$name = $db->fetch_array($res, MYSQLI_ASSOC);

  	return $name['name'];
  }

  // количество позиций в заказе
  public function get_num($order_id) {
  	global $db;

  	if(!$order_id>0)
  		return "";

  	$query = "select count(id) as num from ".$this->orderdetail." where order_id=".$order_id;

  	$res = $db->query($query);
  	$count = $db->fetch_array($res, MYSQLI_ASSOC);

  	return $count['num'];
  }

  /* показать детали заказа */
  public function get_details($params) {
  	global $db;
  	$order_id=(isset($params['order_id'])?$params['order_id']:0);
  	$curpage=(isset($params['curpage'])?$params['curpage']:0);
  	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;
  	$start=(isset($params['start'])?$params['start']:$start);
  	$limit=(isset($params['limit'])?$params['limit']:$limit);


  	$query = "select ".$this->orderdetail.".*
	  	from ".$this->orderdetail."
  		where ".$this->orderdetail.".order_id=$order_id
 			  order by id desc
    				limit $limit";

  	$res = $db->query($query);

  	$ret = array();
  	$currency=$this->get_model("currency");

  	while ($order = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$order['currency'] = $currency->get_currency($order['currency_id']);
  		$ret[] = $order;
  	}
  	return $ret;
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

  /* список статусов */
  public function get_statuses() {
  	global $db;

  	$query = "select ".$this->orderstatus.".* from ".$this->orderstatus;
  	$res = $db->query($query);
  	$ret = array();

  	while ($status = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$ret[] = $status;
  	}
  	return $ret;
  }


  /* список магазинов в которых покупал person_id */
  public function get_shops($person_id) {
  	global $db;

  	$person_id = $db->addslashes($person_id);

  	$query = "select distinct shop_id from ".$this->table." where person_id=".$person_id;
  	$res = $db->query($query);
  	$ret = array();
  	$shop=$this->get_model("shop");


  	while ($shop_id = $db->fetch_array($res, MYSQLI_ASSOC)) {

  		$ret[] = $shop->get_shop_info($shop_id['shop_id']);
  	}
  	return $ret;
  }

  public function setOrderId($order_id, $id_promo) {
    global $db;
    $query = "UPDATE `promo`
              SET order_id=$order_id
              WHERE id_promo=$id_promo";
    $db->query($query);

  }

  public function setPromoId($order_id, $id_promo) {
    global $db;
    $query = "UPDATE `order`
              SET id_promo=$id_promo
              WHERE id=$order_id";
    $db->query($query);

  }



}
