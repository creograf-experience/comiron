<?php
/**
 * shopModel
 */

class shopModel extends Model {
 public $cachable = array('get_organization_categories','is_myorganization', 'get_shop', 'get_shop_info', 'get_friends', 'get_friends_count', 'get_friend_requests', 'get_categories');
  // persons table supported fields.
  public $supported_fields = array('id', 'person_id', 'organization_id', 'shoptemplate_id', 'thumbnail_url', 'thumbnail_big_url', 'admin_email', 'order_email', 'name', 'currency_id', 'add2client', 'options_product', 'options_price', 'options_comment' ,'country_content_code2', 'bgstyle', 'bgimg', 'menustyle',
  'deliverycomp', 'deliverybalance', 'city', 'deliverydpdru', 'deliveryrupost', 'deliverycourier', 'deliverychina', 'paysimplepay', 'terminal', 'logistname', 'logistphone', 'deliverymanager', 'domain', "deliveryhermesru","hideproductnosklad","paysber","partners","paytax","ourshops", "delivery_cost", "delivery_order_cost_from", "delivery_order_cost_to", "delivery_free_cost", "delivery_china_cost", "delivery_china_order_cost_from", "delivery_china_order_cost_to", "delivery_china_free_cost",
  "cities_json","goXML","inputAvitoValueCity","inputAvitoValueRegion", "categoryAvitoValue", "priceApp",
  "deliverypointofissue", "proofpointofissue","delivery_poi_cost","delivery_poi_cost_from","delivery_poi_cost_to","delivery_poi_free_cost","isphonerequired", 'comment_description', 'hide_no_price_products', 'no_delivery_order',
  'enable_payment_from_bucket');
  public $supported_fields_org= array('id','address_id', 'description', 'end_date', 'start_date', 'person_id', 'thumbnail_url', 'thumbnail_big_url', 'fullname', 'organizationcategory_id', 'name');
  private $perpage = 20;

  //залить ODS на сервер
  public function POST($shop_id){
    $shop = $this->get_controller("shop");
    return $shop->doimportods();
    //$id = $this->add($shop_id, $_REQUEST);

    //return array("status"=>"OK");
  }

  public function load_get_id_by_domain($domain) {
    global $db;
    if(!isset($domain)){
      return 0;
    }
    $domain = $db->addslashes($domain);

    $res = $db->query("select id from shop where domain = '$domain'");
    $res = $res->fetch_array(MYSQLI_ASSOC);
    return $res['id'];
  }

  public function load_is_clientrequested($shop_id, $client_id) {
  	global $db;
    if(!isset($client_id)){
  		return 0;
  	}

  	$shop_id = $db->addslashes($shop_id);
  	$client_id = $db->addslashes($client_id);

 	  $res = $db->query("select * from shop_client_requests where (shop_id = $shop_id and client_id = $client_id)");
  	// return 0 instead of false, not to trip up the caching layer (who does a binary === false compare on data, so 0 == false but not === false)

    return $db->num_rows($res) != 0 ? true : 0;
  }

  public function get_name_pic_shop($shopId){
      global $db;
      $queryOrganization = "
                SELECT s.thumbnail_url, o.name FROM shop s
                INNER JOIN organizations o
                ON o.id = s.organization_id
                WHERE s.id = $shopId
                ";
        $resOrganization = $db->query($queryOrganization);
        return $db->fetch_array($resOrganization, MYSQLI_ASSOC);
  }


  public function load_is_client($shop_id, $client_id) {
  	global $db;
    if(!isset($client_id)){
  		return 0;
  	}

  	$this->add_dependency('shop', $shop_id);
  	$this->add_dependency('people', $client_id);
  	$shop_id = $db->addslashes($shop_id);
  	$client_id = $db->addslashes($client_id);

  	$res = $db->query("select shop_id from shop_clients where (shop_id = $shop_id and client_id = $client_id)");
  	// return 0 instead of false, not to trip up the caching layer (who does a binary === false compare on data, so 0 == false but not === false)
  	return $db->num_rows($res) != 0 ? true : 0;
  }

  public function remove_client($shop_id, $client_id) {
    global $db;
    if(!isset($client_id)){
    	return 0;
    }

    $this->invalidate_dependency('shop', $shop_id);
    $this->invalidate_dependency('people', $client_id);
    $shop_id = $db->addslashes($shop_id);
    $client_id = $db->addslashes($client_id);

    $res = $db->query("delete from shop_clients where shop_id = $shop_id and client_id = $client_id");
    return $db->affected_rows($res) != 0;
  }

  public function set_shop_photo($id, $url) {
    global $db;
    $this->invalidate_dependency('shop', $id);
    $id = $db->addslashes($id);
    $url = $db->addslashes($url);
    $db->query("update shop set thumbnail_url = '$url' where id = $id");
  }

  public function set_shop_photo_big($id, $url) {
  	global $db;
  	$this->invalidate_dependency('shop', $id);
  	$id = $db->addslashes($id);
  	$url = $db->addslashes($url);
  	$db->query("update shop set thumbnail_big_url = '$url' where id = $id");
  }

  public function save_shop($id, $shop) {
    global $db;
    $this->invalidate_dependency('shop', $id);
    $id = $db->addslashes($id);
    foreach ($shop as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        if ($val == '-') {
          $updates[] = "`" . $db->addslashes($key) . "` = null";
        }
        else if ($val == 'null') {
           $updates[] = "`" . $db->addslashes($key) . "` = null";
        }
        else {
          $updates[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
        }
      }
    }

    if (count($updates)) {
      $query = "update shop set " . implode(', ', $updates) . " where id = $id";
      $db->query($query);
    }
    //сохранить данные в связанных таблицах
    $re = '/\r\n|\r|\n/u';

    //emails
    if(isset($shop['emails']) and $shop['emails']){
    	$db->query("delete from shop_emails where shop_id = $id");
    	$emails=explode("\n", $shop['emails']);
    	foreach($emails as $email){
    		$email = $db->addslashes($email);
    		$email=preg_replace($re, '', $email);
    		if($email){
    			$db->query("insert into shop_emails (shop_id, email) values ($id, '$email')");
    		}
    	}
    }
    //addresses TODO
    //if($shop['addresses']){}

    //phone_numbers
    if(isset($shop['phone_numbers'])  and $shop['phone_numbers']){
    	$db->query("delete from shop_phone_numbers where shop_id = $id");
    	$phone_numbers=explode("\n", $shop['phone_numbers']);
    	foreach($phone_numbers as $phone_number){
    		$phone_number = $db->addslashes($phone_number);
    		$phone_number=preg_replace($re, '', $phone_number);
    		if($phone_number){
    			$db->query("insert into shop_phone_numbers (shop_id, phone_number) values ($id, '$phone_number')");
    		}
    	}
    }

    //url
    if(isset($shop['urls']) and $shop['urls']){
    	$db->query("delete from shop_urls where shop_id = $id");
    	$urls=explode("\n", $shop['urls']);
    	foreach($urls as $url){
    		$url = $db->addslashes($url);
    		$url = preg_replace($re, '', $url);
    		if($url){
    			$db->query("insert into shop_urls (shop_id, url) values ($id, '$url')");
    		}
    	}
    }

    $res = $db->query("select organization_id from shop where id = $id");
    $org_id = $res->fetch_array(MYSQLI_ASSOC);
    $this->save_organization($org_id["organization_id"], $_POST);
  }

  public function save_organization($id, $org) {
  	global $db;
  	if(!$id or !$org) return;
  	#$this->invalidate_dependency('shop', $id);
  	$id = $db->addslashes($id);
  	$updates=array();
  	foreach ($org as $key => $val) {
  		if (in_array($key, $this->supported_fields_org)) {
  			if ($val == '-') {
  				$updates[] = "`" . $db->addslashes($key) . "` = null";
  			} else {
  				$updates[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
  			}
  		}
  	}
  	if (count($updates)) {
  		$query = "update organizations set " . implode(', ', $updates) . " where id = $id";
  		$db->query($query);
  	}
  }

  public function load_get_myshop($id, $details=false) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$id = $db->addslashes($id);

  	if(!isset($id) or !is_numeric($id))
  		return 0;

  	$res = $db->query("select id from shop where person_id = $id");
  	if (! $db->num_rows($res)) {
  		return 0;
  	}
  	$shops=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$shops[] = $data;
  		//$shops[$data] = $this->get_shop_info($data);
  			if(!isset($data["id"]) and !is_numeric($data["id"]))
  				return 0;

  			if($details){
  				return $this->get_shop($data["id"]);
  			}
  			return $this->get_shop_info($data["id"]);
  	}
  	//return $shops;
  	return 0;
  }

  public function load_get_organization_categories($id=0){
  	global $db;
	if(!isset($id) or !is_numeric($id)){ return array();}

  	$id = $db->addslashes($id);
  	$res = $db->query("select id, name_en, name_ru, organizationcategory_id from organization_category where organizationcategory_id=$id");
  	$ret=array();
  	while ($org = $res->fetch_array(MYSQLI_ASSOC)) {
  		$org['name']=$org['name_ru'];
  		$org['subrecords']=$this->get_organization_categories($org['id']);
  		$ret[] = $org;
  	}
  	return $ret;
  }

  public function load_get_organization_category($id=0){
  	global $db;
  	if(!isset($id) or !is_numeric($id)){ return array();}

  	$id = $db->addslashes($id);
  	$res = $db->query("select id, name_en, organizationcategory_id from organization_category where id=$id");
  	$res= $db->fetch_array($res, MYSQLI_ASSOC);
  	$res['name']=$res['name_en'];
  	return $res;
  }

  // if extended = true, it also queries all child tables
  // defaults to false since its a hell of a presure on the database.
  // remove once we add some proper caching
  public function load_get_shop($id, $extended = false) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$id = $db->addslashes($id);

  	if(!isset($id) or !is_numeric($id))
  		return 0;

  	$res = $db->query("select * from shop where id = $id");
  	if (! $db->num_rows($res)) {
  		return;
  		throw new Exception("Invalid shop");
  	}

  	$shop = $db->fetch_array($res, MYSQLI_ASSOC);

   	$shop['clients_num'] = $this->get_clients_count($id);
   	$shop['is_client']=false;
   	$shop['is_clientrequested']=false;

    //валюта
    $currency=$this->get_model("currency");
    $shop['currency']=$currency->get_currency($shop['currency_id']);

   	if(isset($_SESSION['id'])){
   		$shop['is_clientrequested']=$this->is_clientrequested($id, $_SESSION['id']);
   		$shop['is_client']=$this->is_client($id, $_SESSION['id']);
   	}
   	$messages=$this->get_model("messages");
  	if(isset($_SESSION['id']) and $this->is_myshop($_SESSION['id'], $shop['id'])){
  		$shop['is_owner']=1;
  		$shop['orders_num']=$this->get_orders_num($id);
                $shop['messages_num']=$messages->get_inbox_number($_SESSION['id'], true);
                $shop['news_num']=$this->get_news_num($id);
	  	//показать для себя
  		$shop['client_requests_num'] = $this->get_client_requests_count($id);
//  		$shop['messages_num']=$this->get_inbox_num($_SESSION['id']);
  		$shop['clients']=$this->get_clients($id);

  		$shop['usergroups_num'] = $this->get_usergroups_num($id);
/*  		$friends_id[]=$id;
  		foreach($shop['friends'] as $friend){
  			$friends_id[]=$friend['id'];
  		}*/
// 		$shop['news_num']=$this->get_news_num($shop['id'],$friends_id);
  		$shop['groups_num']=$this->get_groups_num($shop['id']);
  		$shop['products_num']=$this->get_products_num($shop['id']);
  		$shop['articles_num']=$this->get_articles_num($shop['id']);

  	}else{
	  	//показать 10 друзей чужого магазина
  		//$shop['clients']=$this->get_clients($id, 10);

        $shop['clients']=$this->get_clients_visible($id, 10);

  		if(isset($_SESSION['id'])){
  			$shop['news_num']=$this->get_mynews_num($_SESSION['id']);
  		}

  		$shop['is_owner']=0;

  	}

  	if(isset($_SESSION['id'])){
  		$cart=$this->get_model('cart');
		  $shop['cart']=$cart->get_small_cart($_SESSION['id'], $id);
  	}

  	//количество фотографий
  	//$person['photo_num']=$this->get_photo_num($id);

  	//TODO missing : person_languages_spoken, need to add table with ISO 639-1 codes
  	$tables_addresses = array('shop_addresses');//, 'person_current_location');
  	$tables = array('shop_emails', 'shop_phone_numbers', 'shop_tags', 'shop_urls');
  	foreach ($tables as $table) {
  		$shop[$table] = array();
  		$res = $db->query("select * from $table where shop_id = $id");
  		while ($data = $db->fetch_array($res, MYSQLI_ASSOC)) {
  			$shop[$table][] = $data;
  		}
  	}
  	foreach ($tables_addresses as $table) {
  		$res = $db->query("select addresses.* from addresses, $table where $table.shop_id = $id and addresses.id = $table.address_id");
  		while ($data = $db->fetch_array($res)) {
  			$shop[$table][] = $data;
  		}
  	}

  	return $shop;
  }

  //TODO
  public function load_get_shop_info($id) {
    global $db;

    if(!is_numeric($id)) return null;

    #$this->add_dependency('shop', $id);
    $id = $db->addslashes($id);
    $res = $db->query("select * from shop where id = $id");
    if (! $db->num_rows($res)) {
    //  throw new Exception("Invalid shop");
    }
    return $db->fetch_array($res, MYSQLI_ASSOC);
  }

  public function load_get_organization_info($id) {
  	global $db;
  	$this->add_dependency('organization', $id);
  	$id = $db->addslashes($id);
  	$res = $db->query("select * from organizations where id = $id");
  	if (! $db->num_rows($res)) {
  		throw new Exception("Invalid organization");
  	}
  	$res= $db->fetch_array($res, MYSQLI_ASSOC);

  	$res['organizationcategory']=$this->get_organization_category($res['organizationcategory_id']);
  	return $res;
  }

  public function load_get_photo_num($id) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$ret = array();
  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from media_items where owner_id = $shop_id");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  //TODO для магазина
  public function load_get_mynews_num($id) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$ret = array();
  	$person_id = $db->addslashes($id);
  	$query = "
  	select messages.status
  	from
  	messages, persons
  	where
  	messages.`from` = $id and
  	persons.id = messages.`from` and
  	to_deleted = 'no'";
  	$res = $db->query($query);
  	$ret = array();
  	$read=0;
  	$unread=0;
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
  	if($message['status'] == 'read'){
  	$read++;
  	}else{
  	$unread++;
  };
  }
  $ret["read"]=$read;
  $ret["unread"]=$unread;
  	return $ret;
  }

  //TODO?
  public function load_get_news_num($id) {
  	global $db;

  	$ret = array();

  	$query = "
  	select messages.status
  	from
  	messages, persons
  	where messages.shop_id=".$id." and to_deleted = 'no'
  	and type='news'
  	and persons.id=messages.`from`";

  	$res = $db->query($query);
  	$ret = array();
  	$read=0;
  	$unread=0;
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
  	if($message['status'] == 'read'){
  	$read++;
  	}else{
  	$unread++;
  };
  }
  $ret["read"]=$read;
  $ret["unread"]=$unread;
  	//  	$res = $db->query("select count(id) from messages where messages.to = $person_id");
  	//  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_clients($id, $limit = false) {
    global $db;
    $this->add_dependency('shop', $id);
    $ret = array();
    $limit = $limit ? ' limit ' . $db->addslashes($limit) : '';
    $shop_id = $db->addslashes($id);
    $res = $db->query("select * from shop_clients where shop_id = $shop_id $limit");
    $people=$this->get_model("people");
    $tag=$this->get_model("tag");
    $clienttype = $this->get_model("clienttype");
    //while (list($data) = $db->fetch_row($res)) {
    while ($data = $db->fetch_array($res, MYSQLI_ASSOC)) {
      $person = $people->get_person_info($data['client_id']);
      $data['clienttype'] = $clienttype->findById($person['clienttype_id']);
      $data['tags'] = $tag->getperson_tagschecked($shop_id, $data['client_id']);
      $ret[$data['client_id']] = array_merge( $person, $data);
    }

    return $ret;
  }

  public function load_get_clients_visible($id, $limit = false) {
    global $db;
    $this->add_dependency('shop', $id);
    $ret = array();
    $limit = $limit ? ' limit ' . $db->addslashes($limit) : '';
    $shop_id = $db->addslashes($id);
    $res = $db->query("select distinct client_id from shop_clients where hiddenclient = 0 and shop_id = $shop_id $limit");
    $people=$this->get_model("people");
    while (list($client_id) = $db->fetch_row($res)) {
      $ret[$client_id] = $people->get_person_info($client_id);
    }

    return $ret;
  }

  public function load_get_clients_filter($params) {
  	global $db;

  	$shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
        $usergroup_id=(isset($params['usergroup_id'])?$params['usergroup_id']:0);
        $tag=(isset($params['tag'])?$params['tag']:false);
  	$details=(isset($params['details'])?$params['details']:false);
  	$filter=(isset($params['filter'])?$params['filter']:false);

  	$this->add_dependency('shop', $shop_id);
  	$ret = array();
  	//$limit = $limit ? ' limit ' . $db->addslashes($limit) : '';
  	$shop_id = $db->addslashes($shop_id);

  	$client_ids=array();
  	if($usergroup_id){
  		$res = $db->query("select client_id from `shop_usergroup_client` where usergroup_id=$usergroup_id");
  		while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  			$client_ids[]=$data['client_id'];
  		}
  		//чтобы не показывал все
  		if(count($client_ids)==0){
  			$client_ids[]=-1;
  		}
  	}

    if($tag){
  		$res = $db->query("select client_id from `person_tag` where tag='$tag' and shop_id=$shop_id");
  		while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  			$client_ids[]=$data['client_id'];
  		}
  		//чтобы не показывал все
  		if(count($client_ids)==0){
  			$client_ids[]=-1;
  		}
  	}

  	$query="select client_id from shop_clients where shop_id = $shop_id " .
  			((isset($client_ids) and count($client_ids)>0 )?" and client_id in (".implode(', ', $client_ids).") ":"");

  	$res = $db->query($query);
  	$people=$this->get_model("people");

  	while (list($client_id) = $db->fetch_row($res)) {
  		if($filter){
  			$res2=$db->query("select distinct id from persons where id=$client_id $filter");
  			if(list($id) = $db->fetch_row($res2)){
  				$ret[$client_id] = $people->get_person_info($client_id);
  			}
  		}else{
  			$ret[$client_id] = $people->get_person_info($client_id);
  		}
  	}

  	return $ret;
  }

  public function load_get_clients_count($id) {
    global $db;
    $this->add_dependency('shop', $id);
    $ret = array();
    $shop_id = $db->addslashes($id);
    $res = $db->query("select count(client_id) from shop_clients where shop_id = $shop_id");
    list($ret) = $db->fetch_row($res);
    return $ret;
  }

  public function add_client_request($id, $client_id) {
    global $db;
    try {
      $shop_id = $db->addslashes($id);
      $client_id = $db->addslashes($client_id);

      $res = $db->query("select add2client from shop where id = $shop_id");
      $res = $db->fetch_row($res, MYSQLI_ASSOC);

      //добавлять через запрос или автоматически
      if($res[0]=="options_add_2_friend_req"){
      	$this->invalidate_dependency('clientrequest', $id);
      	$this->invalidate_dependency('clientrequest', $friend_id);
      	$db->query("insert into shop_client_requests (client_id, shop_id) values ($client_id, $shop_id)");
      }else{
      	$db->query("insert into shop_clients (client_id, shop_id) values ($client_id, $shop_id)");
      }
    } catch (DBException $e) {
      return false;
    }
    return true;
  }

  public function accept_client_request($id, $client_id) {
    global $db;
    $shop_id = $db->addslashes($id);
    $client_id = $db->addslashes($client_id);

    // double check if a friend request actually exists (reversed friend/person since the request came from the other party)
      $db->query("delete from shop_client_requests where shop_id = $shop_id and client_id = $client_id");
      // -1 = sql error, 0 = no request was made, so can't accept it since the other party never gave permission
      if ($db->affected_rows() < 1) {
        die("couldnt delete client request, means there was none?");
        return false;
      }
      // make sure there's not already a connection between the two the other way around
      $res = $db->query("select client_id from shop_clients where shop_id = $shop_id and client_id = $client_id");
      if ($db->num_rows($res)) {
        die("the relation already exists the other way around,bailing");
        return false;
      }
      $db->query("insert into shop_clients (shop_id, client_id) values ($shop_id, $client_id)");

    return true;
  }

  public function reject_client_request($id, $client_id) {
    global $db;
    $shop_id = $db->addslashes($id);
    $client_id = $db->addslashes($client_id);
    try {
      $db->query("delete from shop_client_requests where shop_id = $shop_id and client_id = $client_id");
    } catch (DBException $e) {
      return false;
    }
    return true;
  }

  public function load_get_client_requests($id) {
  	global $db;
  	$this->add_dependency('shop_clientrequest', $id);
  	$requests = array();
  	$shop_id = $db->addslashes($id);
  	$people=$this->get_model("people");
  	$res = $db->query("select client_id from shop_client_requests where shop_id = $shop_id");
  	while (list($friend_id) = $db->fetch_row($res)) {
  		$requests[$friend_id] = $people->get_person($friend_id, false);
  	}
  	return $requests;
  }

  public function load_get_client_requests_count($id) {
  	global $db;
  	$this->add_dependency('shop_clientrequest', $id);
  	$requests = array();
  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(shop_id) from shop_client_requests where shop_id = $shop_id");
  	list($ret) = $db->fetch_row($res);
    return $ret;
  }

  public function load_get_clientdata($shop_id, $client_id) {
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$client_id = $db->addslashes($client_id);
  	$res = $db->query("select * from shop_clients where shop_id = $shop_id and client_id=$client_id");
  	//return $res->fetch_row();
  	return $db->fetch_array($res, MYSQLI_ASSOC);
  }

  public function load_save_clientdata($shop_id, $client_id, $data) {
  	global $db;
  	$shop_id = $db->addslashes($shop_id);
  	$client_id = $db->addslashes($client_id);

    $discount = $data['discount']?$db->addslashes($data['discount']):0;
  	$discounthidden = $data['discounthidden']?$db->addslashes($data['discounthidden']):0;

        if($data['hiddenclient'] == 'on') {
            $hiddenclient = 1;
        } else {
            $hiddenclient = 0;
        }
    $res = $db->query("update shop_clients set discount=$discount, discounthidden=$discounthidden, hiddenclient=$hiddenclient  where shop_id = $shop_id and client_id=$client_id");
  	//return $res->fetch_row();
  	return $db->fetch_array($res, MYSQLI_ASSOC);
  }

  public function is_client($shop_id, $client_id) {
  	global $db;
  	if(!isset($client_id) or !isset($shop_id) or !$client_id or !$shop_id){
  		return 0;
  	}

  	$shop_id = $db->addslashes($shop_id);
  	$client_id = $db->addslashes($client_id);

  	$res = $db->query("select 1 from shop_clients where shop_id = $shop_id and client_id=$client_id");
  	list($ret) = $db->fetch_row($res);
    return $ret;
  }

/*  public function search($params) {
    global $db;
    $name = $db->addslashes($params['name']);
    $country_id = $db->addslashes($params['country_id']);
    $ret = array();
    $res = $db->query("select id from shop where name like '%$name%'");
    while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {
      $ret[] = $this->get_shop_info($row['id']);
    }
    return $ret;
  }
*/
  /*
   * get person info, need set field which we need.
   */
  public function get_shop_fields($id, $fields) {
    global $db;
    $id = $db->addslashes($id);
    foreach ($fields as $val) {
      if (in_array($val, $this->supported_fields)) {
        $fields_adds[] = "`" . $db->addslashes($val) . "`";
      }
    }
    $res = $db->query("select " . implode(', ', $fields_adds) . " from shop where id = $id");
    if (! $db->num_rows($res)) {
      throw new Exception("Invalid shop");
    }
    return $db->fetch_array($res, MYSQLI_ASSOC);
  }

  /*
   * set person info, need set field which we need.
   */
  public function set_shop_fields($id, $fields) {
    global $db;
    $id = $db->addslashes($id);
    foreach ($fields as $key => $val) {
    	if (in_array($key, $this->supported_fields)) {
        if (is_null($val)) {
          $updates[] = "`" . $db->addslashes($key) . "` = null";
        } else {
          $updates[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
        }
      }
    }
    if (count($updates)) {
      $query = "update shop set " . implode(', ', $updates) . " where id = $id";
      $db->query($query);
      return $id;
    }
  }

  public function create_organization($id, $fields) {
  	global $db;
  	try {
  		$person_id = $db->addslashes($id);
  		$org_id=0;
    	foreach ($fields as $key => $val) {
    		$fields_name[] = "`" . $db->addslashes($key) . "`";
    		if (is_null($val)) {
    			$fields_val[]="null";
    		} else {
    			$fields_val[]="'" . $db->addslashes($val) . "'";
    		}
    	}
    	if (count($fields_name)) {
    		$db->query("insert into organizations (person_id, ".implode(', ', $fields_name).") values ($person_id, ".implode(', ', $fields_val).")");
    		$org_id = $db->insert_id();
    	}
    	$db->query("insert into person_organization (person_id, organization_id) values ($person_id, $org_id)");

  	} catch (DBException $e) {
  		return false;
  	}
  	return true;
  }

  public function create_shop($id, $fields) {
  	global $db;
//  	try {
  		$person_id = $db->addslashes($id);
  		$shop_id=0;
  		$org_id=$fields['organization_id'];
  		foreach ($fields as $key => $val) {
  			$fields_name[] = "`" . $db->addslashes($key) . "`";
  			if (is_null($val)) {
  				$fields_val[]="null";
  			} else {
  				$fields_val[]="'" . $db->addslashes($val) . "'";
  			}
  		}
  		if (count($fields_name)) {
  			$db->query("insert into shop (person_id, ".implode(', ', $fields_name).") values ($person_id, ".implode(', ', $fields_val).")");
    		$shop_id = $db->insert_id();
  		}
  		$db->query("update person_organization set shop_id=$shop_id where person_id=$person_id");// and organization_id=$org_id

//		} catch (DBException $e) {
//  		return false;
//  	}
  	return $shop_id;
  }

  public function load_get_myorganization($id){
  	global $db;
  	$this->add_dependency('shop', $id);
  	$id = $db->addslashes($id);
  	$res = $db->query("select id from organizations where person_id = $id");
  	if (! $db->num_rows($res)) {
  		return 0;
  	}else{
  		//$shops=array();
  		while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$shops[] = $data;
  		//$shops[$data] = $this->get_shop_info($data);
  			return $this->get_organization_info($data["id"]);
  		}
  	//return $shops;
  	}
  	return 0;
  }

  //TODO: переделать, для нескольких сотрудников
  public function is_myshop($person_id, $shop_id){
  	global $db;
  	//$this->add_dependency('shop', $id);
  	if(!isset($person_id)){
  		return false;
  	}
  	$person_id = $db->addslashes($person_id);
  	$shop_id = $db->addslashes($shop_id);

  	$res = $db->query("select count(id) as num from shop where id=$shop_id and person_id = $person_id");
  	$res=$res->fetch_array();
  	if ($res['num'] > 0) return true;
  	return false;
  }

  public function load_get_malls(){
  	global $db;
  	$res = $db->query("select id from shop where ismall");
  	if (! $db->num_rows($res)) {
  		return 0;
  	}else{
  		$shops=array();
  		while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  			$shops[] = $this->get_shop_info($data["id"]);
		}
		return $shops;
  	}
  	return 0;
  }

  public function load_get_groups_num($id) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$ret = array();
  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from `group` where shop_id = $shop_id");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_usergroups_num($id) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$ret = array();
  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from `shop_usergroup` where shop_id = $shop_id");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_products_num($id) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$ret = array();
  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from `product` where shop_id = $shop_id and visible >= 0");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_articles_num($id) {
  	global $db;
  	$this->add_dependency('shop', $id);
  	$ret = array();
  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from `article` where shop_id = $shop_id");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }


  public function load_get_orders_num($id) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$total = array();
  	$new = array();

  	$shop_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from `order` where shop_id = $shop_id");
  	list($total) = $db->fetch_row($res);

  	$res = $db->query("select count(id) from `order` where shop_id = $shop_id and orderstatus_id=1");
  	list($new) = $db->fetch_row($res);

  	return array("total" => $total,
  				 "new" => $new);
  }

  public function get_shop_id($user_id) {
        global $db;
        $user_id = $db->addslashes($user_id);
  		$result = $db->query("select id from `shop` where person_id = $user_id");
        return $db->fetch_row($result);
  }

  public function get_shop_owner($shop_id) {
        global $db;
        $shop_id = $db->addslashes($shop_id);
  		$result = $db->query("select person_id from `shop` where id = $shop_id");
        $person_id = $db->fetch_row($result);
        return $person_id[0];
  }
  public function get_shop_usergroup($shop_id) {
        global $db;
        $shop_id = $db->addslashes($shop_id);
        $result = $db->query("select id, name from `shop_usergroup` where shop_id = $shop_id");
        return $db->fetch_all($result);
  }
  public function get_client_usergroup($group_id, $shop_id, $all = false) {
        global $db;

        $shop_id = $db->addslashes($shop_id);
        if($all == false){
            $group_id = $db->addslashes($group_id);
            $result = $db->query("select client_id from `shop_usergroup_client` where shop_id = $shop_id and usergroup_id = $group_id");
        } else {
            $result = $db->query("select client_id from `shop_clients` where shop_id = $shop_id");
        }
        return $db->fetch_all($result);
  }

  public function get_client_info($shop_id) {
        global $db;

        $shop_id = $db->addslashes($shop_id);
        $result = $db->query("select client_id from `shop_clients` where shop_id = $shop_id");
        $res = $db->fetch_all($result);
        $clients = array();
        foreach($res as $item) {
            $resPerson = $db->query("select thumbnail_url, id, first_name, last_name from `persons` where id = ".$item['client_id']);
            $resultPerson = $db->fetch_array($resPerson);
            $clients[] = $resultPerson;
        }

        return $clients;
  }

  public function get_lang_shop($shop_id) {
        global $db;
        $shop_id = $db->addslashes($shop_id);

  		$result = $db->query("select person_id, lang, country_content_code2 from `shop` where id = $shop_id");
        $res = $db->fetch_array($result, MYSQLI_ASSOC);
        if(!empty($res['lang']) or !empty($res['country_content_code2'])) {
            return $res;
        }else {
            $result_person = $db->query("select lang, country_content_code2 from `persons` where id = ".$res['person_id']);
            $res_person = $db->fetch_array($result_person, MYSQLI_ASSOC);
            return $res_person;
        }
  }

  public function get_promo_toDb($shop_id,$promo) {
    global $db;
    // $promo = $_POST['promo'];
    $test = $db->query(" SELECT code FROM `promo` WHERE shops_id LIKE '%$shop_id;%'");
    $test = $db->fetch_all($test, MYSQLI_ASSOC);

    $arrPromo = array();
    foreach ($test as $t) {
      $arrPromo = array_merge($arrPromo, array_values($t));
    }
    if(!in_array($promo, $arrPromo)) {
      $res[0] = 0;
      $res[1] = "Неверный промокод";
      return $res;
    }

    $res = $db->query(" SELECT sum, ispersent, order_id FROM `promo` WHERE shops_id LIKE '%$shop_id;%' AND code='$promo' ");
    $res = $db->fetch_row($res, MYSQLI_ASSOC);
    if($res[2]==NULL) {
       $valid = 1;
       array_unshift($res, $valid);
       return $res;
    }

    $res[0] = 0;
    $res[1] = "Неверный промокод";
    return $res;

  }

  public function get_promo_inf($shop_id, $promo) {
      global $db;
      $code = $db->query(" SELECT code, sum, ispersent, id_promo FROM `promo` WHERE shops_id LIKE '%$shop_id;%' AND code='$promo'");
      $code = $db->fetch_row($code, MYSQLI_ASSOC);
      return $code;
  }

  public function price_calculation($sum, $discount_sum, $ispersent) {
    if($ispersent == 0) {
      $sum -= $discount_sum;
    }
    else if($ispersent == 1) {
      $sum *= (1-$discount_sum/100);
    }
      if($sum >=0 ) {
      return $sum;
      }
      else if( $sum < 0 )
      return 0;
  }



  //

  public function checkshopArr($array) {

    $queryProof = [];
    if($array['deliveryrupost'] ==1 && ($array['proofRUPOST'] == 0 || $array['proofRUPOST'] == null))
     array_push($queryProof, "запрос на доставку почтой России из магазина №".$array['id']);
    if($array['deliverychina'] ==1 && ($array['proofCHINA'] == 0 || $array['proofCHINA'] == null))
      array_push($queryProof, "запрос на доставку из Китая из магазина №".$array['id']);
    if($array['deliverydpdru'] ==1 && ($array['proofDPD'] == 0 || $array['proofDPD'] == null))
      array_push($queryProof, "запрос на доставку DPD из магазина №".$array['id']);
    if($array['deliverycourier'] ==1 && ($array['proofCOURIER'] == 0 || $array['proofCOURIER'] == null))
      array_push($queryProof, "запрос на доставку курьером из магазина №".$array['id']);
    if($array['deliveryhermesru'] ==1 && ($array['proofHERMESRU'] == 0 || $array['proofHERMESRU'] == null))
     array_push($queryProof, "запрос на доставку Hermes из магазина №".$array['id']);
    if($array['deliverymanager'] ==1 && ($array['proofMANAGER'] == 0 || $array['proofMANAGER'] == null))
      array_push($queryProof, "запрос на связаться с менеджером из магазина №".$array['id']);
    if($array['paysimplepay'] ==1 && ($array['proofSimplePay'] == 0 || $array['proofSimplePay'] == null))
      array_push($queryProof, "запрос на оплату SimplePay из магазина №".$array['id']);
    if($array['paysber'] ==1 && ($array['proofSBER'] == 0 || $array['proofSBER'] == null))
      array_push($queryProof, "запрос на оплату Сбербанком из магазина №".$array['id']);
    if($array['paytax'] ==1 && ($array['proofTax'] == 0 || $array['proofTax'] == null))
      array_push($queryProof, "запрос на наложный платеж из магазина №".$array['id']);

    return $queryProof;

  }


  //проверка на существование id магазина

  public function checkIdByShop($shop_id) {
    global $db;
    $query = "SELECT id FROM `shop` WHERE id = $shop_id";
    $res = $db->query($query);
    $res = $db->fetch_row($res, MYSQLI_ASSOC);
    return $res;
  }


  //удалить все товары и все их данные по shop_id
  function deleteall($id){
  	global $db;

  	$db->query("delete from `product` where shop_id=".$id);
  	$db->query("delete from `product_images` where shop_id=".$id);
  	$db->query("delete from `product_access` where shop_id=".$id);
  	$db->query("delete from `product_char` where shop_id=".$id);
  	$db->query("delete from `group` where shop_id=".$id);
  	$db->query("delete from `group_access` where shop_id=".$id);
  	$db->query("delete from `group_product` where shop_id=".$id);

	return $row['id'];
  }

  //удалить весь магаизн полностью!!!
  public function deleteShop($shop_id) {
    global $db;
    $result = $db->query("CALL proc_for_dell_shop($shop_id)");
  }

  public function getShopCategory($shop_id) {
    global $db;
    $query = "SELECT categoryAvitoValue FROM `shop` WHERE id=$shop_id";
    $res = $db->query($query);
    $category = $res->fetch_array(MYSQLI_ASSOC);
    return $category;
  }

  public function search($name, $curpage, $params) {
    global $db;
    $name = $db->addslashes($name);
    $isprice = $params['isprice'];
    $ret = array();

    $start = $curpage*$this->perpage;
    $limit = "$start, ".$this->perpage;


    //TODO: translit
    //Translit.php;
    //my $tr = new Lingua::Translit("GOST 7.79 RUS");#ISO 9
    //$name_tr = $tr->translit($name);
    $where = "name like '%$name%' or city like '%$name%'".(($isprice)?" and id in (select distinct id_shop from price)":"");

    $res = $db->query("select id from `shop` where  ".$where." limit $limit");
    while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {
        $ret[] = $this->get_shop($row['id']);
    }

    $res = $db->query("select count(id) as total from `shop` where ".$where);
    $row = $db->fetch_array($res, MYSQLI_ASSOC);

    $total = (int)( ( $row['total'] - 1 ) / $this->perpage ) + 1;
    $next=false;
    if($total>$curpage+1){
    	$next=$curpage+1;
    }

    return array("nextpage"=>$next,
    		"totalpages"=>$total,
    		"results"=>$ret);
  }

  public function get_shops_from_city($city) {
    global $db;
    if(!isset($city)){
      return 0;
    }
    $city = $db->addslashes($city);

    $res = $db->query("SELECT * FROM shop WHERE city LIKE '%$city%'");
    $rows = array();
    while($row = $res->fetch_array(MYSQLI_ASSOC)) {
      $rows[] = $row;
    }
    
    return $rows;
  }

}
