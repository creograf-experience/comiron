<?php

class peopleModel extends Model {
// public $cachable = array('has_shop','has_organization','is_friend', 'get_person', 'get_person_info', 'get_friends', 'get_friends_count', 'get_friend_requests');
  // persons table supported fields.
  private $perpage=10;
  public $supported_fields = array('id','email','password','about_me','age','children','date_of_birth','drinker',
    'ethnicity','fashion','gender','happiest_when','humor','job_interests','living_arrangement','looking_for',
    'nickname','pets','political_views','profile_song','profile_url','profile_video','relationship_status',
    'religion','romance','scared_of','sexual_orientation','smoker','status','thumbnail_url','time_zone',
    'first_name','last_name','uploaded_size','activity','lang','country_content_code2','job','city','status', 'country_code2', 'street', 'last_online', 'currency_id', 'phone',
    "doing", "interest", "music", "books", "tv", "quote", "about","pushtoken","partrizan_uid", "clienttype_id","standartcomments");// 'phone');
  private $table="persons";

  public function activate($activation_code) {
  	global $db;
  	$activation_code = $db->addslashes($activation_code);
  	$db->query("update ".$this->table." set is_activated=1 where activation_code = '$activation_code'");
  	$res = $db->query("select is_activated from ".$this->table." where activation_code = '$activation_code'");
  	$data = $db->fetch_array($res, MYSQLI_ASSOC);

  	return $data['is_activated'];
  }

  public function load_has_shop($person_id) {
  	global $db;
  	$this->add_dependency('people', $person_id);
  	$person_id = $db->addslashes($person_id);
  	$res = $db->query("select id from shop where person_id = $person_id");
  	// return 0 instead of false, not to trip up the caching layer (who does a binary === false compare on data, so 0 == false but not === false)
  	return $db->num_rows($res) != 0 ? true : 0;
  }

  public function get_info_shop_clients($person_id) {
  	global $db;
	      $person_id = $db->addslashes($person_id);
        $sql = "select sc.shop_id, s.name, s.thumbnail_url
                from shop_clients sc
                inner join shop s
                on s.id = sc.shop_id
                where sc.client_id = $person_id";
	      $result = $db->query($sql);
        $res = $db->fetch_all_assos($result, MYSQLI_ASSOC);

        //сортировать по количеству прайсов
        $array = array();
        foreach($res as $shop){
          $sql = "select count(id_price) as num from id_clients where id_person = $person_id and id_shop=".$shop["shop_id"];
  	      $result = $db->query($sql);
          $r = $db->fetch_array($result, MYSQLI_ASSOC);

          $shop["pricenum"] = $r["num"];
          $array[] = $shop;
        }

        function cmp($a, $b) {
            if ($a["pricenum"] == $b["pricenum"]) {
                return 0;
            }
            return ($a["pricenum"] > $b["pricenum"]) ? -1 : 1;
        }
        usort($array, 'cmp');

        return $array;
  }

  public function shop_clients($person_id) {
  	global $db;
	$person_id = $db->addslashes($person_id);
	$result = $db->query("select shop_id as shop_id, discount, discounthidden from `shop_clients` where client_id = $person_id");
	//return $db->fetch_all_assos($result, MYSQLI_ASSOC);
        $res = $db->fetch_all_assos($result, MYSQLI_ASSOC);
        $array = array();
        foreach($res as $item) {
            $array[$item['shop_id']] = $item;
        }
        return $array;
  }

  public function load_has_organization($person_id) {
    global $db;
    $this->add_dependency('people', $person_id);
    $person_id = $db->addslashes($person_id);
    $res = $db->query("select organization_id from person_organization where person_id = $person_id");
    // return 0 instead of false, not to trip up the caching layer (who does a binary === false compare on data, so 0 == false but not === false)
    return $db->num_rows($res) != 0 ? true : 0;
  }

  public function load_is_friend($person_id, $friend_id) {
  	global $db;
  	$this->add_dependency('people', $person_id);
  	$this->add_dependency('people', $friend_id);
  	$person_id = $db->addslashes($person_id);
  	$friend_id = $db->addslashes($friend_id);
  	$res = $db->query("select * from friends where (person_id = $person_id and friend_id = $friend_id) or (person_id = $friend_id and friend_id = $person_id)");
  	// return 0 instead of false, not to trip up the caching layer (who does a binary === false compare on data, so 0 == false but not === false)
  	return $db->num_rows($res) != 0 ? true : 0;
  }

  public function load_is_friendrequested($person_id, $friend_id) {
  	global $db;
  	$this->add_dependency('people', $person_id);
  	$this->add_dependency('people', $friend_id);
  	$person_id = $db->addslashes($person_id);
  	$friend_id = $db->addslashes($friend_id);
  	$res = $db->query("select 1 from friend_requests where (person_id = $person_id and friend_id = $friend_id)");
  	if($db->num_rows($res) != 0){
  		return 1;
  	}
   	$res = $db->query("select 2 from friend_requests where (person_id = $friend_id and friend_id = $person_id)");
  	if($db->num_rows($res) != 0){
  		return 2;
  	}
  }



  public function remove_friend($person_id, $friend_id) {
    global $db;
    $this->invalidate_dependency('people', $person_id);
    $this->invalidate_dependency('people', $friend_id);
    $person_id = $db->addslashes($person_id);
    $friend_id = $db->addslashes($friend_id);
    $res = $db->query("delete from friends where (person_id = $person_id and friend_id = $friend_id) or (person_id = $friend_id and friend_id = $person_id)");
    return $db->affected_rows($res) != 0;
  }

  public function remove_client($person_id, $shop_id) {
    global $db;
    $this->invalidate_dependency('people', $person_id);
    $this->invalidate_dependency('people', $shop_id);
    $person_id = $db->addslashes($person_id);
    $shop_id = $db->addslashes($shop_id);
    $res = $db->query("delete from shop_clients where client_id = $person_id and shop_id = $shop_id");
    return $db->affected_rows($res) != 0;
  }

  public function set_profile_photo($id, $url) {
    global $db;
    $this->invalidate_dependency('people', $id);
    $id = $db->addslashes($id);
    $url = $db->addslashes($url);
    $db->query("update persons set thumbnail_url = '$url' where id = $id");
  }

  public function set_profile_photo_big($id, $url) {
  	global $db;
  	$this->invalidate_dependency('people', $id);
  	$id = $db->addslashes($id);
  	$url = $db->addslashes($url);
  	$db->query("update persons set thumbnail_url_big = '$url' where id = $id");
  }

  public function save_person($id, $person) {
    global $db;
    $this->invalidate_dependency('people', $id);
    $id = $db->addslashes($id);
    foreach ($person as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        if ($val == '-') {
          $updates[] = "`" . $db->addslashes($key) . "` = null";
        } else {
          $updates[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
        }
      }
    }
    if (count($updates)) {
      $query = "update persons set " . implode(', ', $updates) . " where id = $id";
      $db->query($query);
    }
    //сохранить данные в связанных таблицах
    $re = '/\r\n|\r|\n/u';

    //emails
    if(isset($person['emails'])){
    	$db->query("delete from person_emails where person_id = $id");
    	$emails=explode("\n", $person['emails']);
    	foreach($emails as $email){
    		$email = $db->addslashes($email);
    		$email=preg_replace($re, '', $email);
    		if($email){
    			$db->query("insert into person_emails (person_id, email) values ($id, '$email')");
    		}
    	}
    }

    //urls
    if(isset($person['urls'])){
    	$db->query("delete from person_urls where person_id = $id");
    	$urls=explode("\n", $person['urls']);
    	foreach($urls as $url){
    		$url = $db->addslashes($url);
    		$url=preg_replace($re, '', $url);
    		if($url){
    			$db->query("insert into person_urls (person_id, url) values ($id, '$url')");
    		}
    	}
    }
    //addresses TODO
    //if($person['addresses']){}

    //phone_numbers
    if(isset($person['phone_numbers'])){
    	$db->query("delete from person_phone_numbers where person_id = $id");
    	$phone_numbers=explode("\n", $person['phone_numbers']);
    	foreach($phone_numbers as $phone_number){
    		$phone_number = $db->addslashes($phone_number);
    		$phone_number=preg_replace($re, '', $phone_number);
    		if($phone_number){
    			$db->query("insert into person_phone_numbers (person_id, phone_number) values ($id, '$phone_number')");
    		}
    	}
    }

    //cars
    if(isset($person['cars'])){
    	$db->query("delete from person_cars where person_id = $id");
    	$cars=explode("\n", $person['cars']);
    	foreach($cars as $car){
    		$car = $db->addslashes($car);
    		$car = preg_replace($re, '', $car);
    		if($car){
    			$db->query("insert into person_cars (person_id, car) values ($id, '$car')");
    		}
    	}
    }

    //person_jobs
    if(isset($person['person_jobs'])){
    	$db->query("delete from person_jobs where person_id = $id and organization_id=0");//TODO: удалять ли?
   		$job = $db->addslashes($person['person_jobs']);
   		$job=preg_replace($re, '', $job);
   		if($job){
    			$db->query("insert into person_jobs (person_id, name) values ($id, '$job')");
    	}
    }

    //интеграция с партизаном
    if(isset($person['phone'])){
      require_once PartuzaConfig::get('library_root').'/REST.php';
      $res = runREST("http://partizan.comiron.com/api/integration/comiron/".$person['phone'], "GET");
      $res = json_decode ($res, true);
      //var_dump($res);
      if($res{'success'} && $res{'id'} ){
        $db->query("update persons set partizan_uid='".$res{'id'}."' where id = $id");
      }
    }

  }

  // if extended = true, it also queries all child tables
  // defaults to false since its a hell of a presure on the database.
  // remove once we add some proper caching
  public function load_get_person($id, $extended = false) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$id = $db->addslashes($id);
    if(!$id) return false;

  	$res = $db->query("select * from persons where id = $id");
  	if (! $db->num_rows($res)) {
  		throw new Exception("Invalid person");
  	}
  	$person = $db->fetch_array($res, MYSQLI_ASSOC);
  	$person['friends_num'] = $this->get_friends_count($id);

  	$messages=$this->get_model("messages");
  	$car=$this->get_model("car");

  	if($id == $_SESSION['id'] and $id>0){
	  	//показать для себя
  		$person['friend_requests_num'] = $this->get_friend_requests_count($id);
  		$person['messages_num']=$messages->get_inbox_number($_SESSION['id']);
  		$person['friends']=$this->get_friends($id);

  		$friends_id[]=$id;
  		foreach($person['friends'] as $friend){
  			$friends_id[]=$friend['id'];
  		}
  		$person['shop_clients']=$this->shop_clients($_SESSION['id']);
                $person['news_num']=$this->get_news_num($_SESSION['id'],$friends_id);
  		$person['has_shop']=$this->has_shop($_SESSION['id']);
  		$person['has_organization']=$this->has_organization($_SESSION['id']);
  		$person['myshops_num']=$this->get_shops_num($id);
                $person['orders_num']=$this->get_orders_num($id);


  	}else{
	  	//показать 10 друзей другого пользователя
  		$person['friends']=$this->get_friends($id, 10);

  		$person['news_num']=$this->get_mynews_num($_SESSION['id']);
  	}

  	$person['isonline']=0;
    if(( time()-$person['last_online'] < PartuzaConfig::get("online_time")) and !$person['isoffline']){
    	$person['isonline']=1;
    }

  	//количество фотографий
  	$person['photo_num']=$this->get_photo_num($id);
  	$person['car_num']=$car->get_cars_num($id);

  	//TODO missing : person_languages_spoken, need to add table with ISO 639-1 codes
  	$tables_addresses = array('person_addresses', 'person_current_location');
  	$tables_organizations = array( 'person_schools');//'person_jobs',
  	$tables = array('person_activities', 'person_body_type', 'person_books', 'person_cars',
  			'person_emails', 'person_food', 'person_heroes', 'person_movies',
  			'person_interests', 'person_music', 'person_phone_numbers', 'person_quotes',
  			'person_sports', 'person_tags', 'person_turn_offs', 'person_turn_ons',
  			'person_tv_shows', 'person_urls','person_addresses','person_jobs');
  	foreach ($tables as $table) {
  		$person[$table] = array();
  		$res = $db->query("select * from $table where person_id = $id");
  		while ($data = $db->fetch_array($res, MYSQLI_ASSOC)) {
  			$person[$table][] = $data;
  		}
  	}
  	foreach ($tables_addresses as $table) {
  		$res = $db->query("select addresses.* from addresses, $table where $table.person_id = $id and addresses.id = $table.address_id");
  		while ($data = $db->fetch_array($res)) {
  			$person[$table][] = $data;
  		}
  	}
  	foreach ($tables_organizations as $table) {
  		$res = $db->query("select organizations.* from organizations, $table where $table.person_id = $id and organizations.id = $table.organization_id");
  		while ($data = $db->fetch_array($res)) {
  			$person[$table][] = $data;
  		}
  	}
  	return $person;
  }

  /*
   * doing a select * on a large table is way to IO and memory expensive to do
   * for all friends/people on a page. So this gets just the basic fields required
   * to build a person expression:
   * id, email, first_name, last_name, thumbnail_url and profile_url
   */
  public function load_get_person_info($id) {
    global $db;
    $this->add_dependency('people', $id);
    $id = $db->addslashes($id);
    $res = $db->query("select id, email, first_name, last_name, phone, thumbnail_url, thumbnail_url_big, profile_url, activity, lang, last_online, isoffline, currency_id, pushtoken, clienttype_id from persons where id = $id");
    if (! $db->num_rows($res)) {
      //throw new Exception("Invalid person");
      return;
    }

    $res= $db->fetch_array($res, MYSQLI_ASSOC);

    $res['isonline']=0;
    if(( time()-$res['last_online'] < PartuzaConfig::get("online_time")) and !$res['isoffline']){
    	$res['isonline']=1;
    }


	return $res;
  }

  public function load_get_photo_num($id) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$ret = array();
  	$person_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from media_items where  owner_id = $person_id and type='IMAGE' and album_id is not null");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_orders_num($id) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$ret = array();
  	$person_id = $db->addslashes($id);
  	$res = $db->query("select count(id) from `order` where person_id = $person_id");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_shops_num($id) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$ret = array();
  	$person_id = $db->addslashes($id);
  	$res = $db->query("select count(shop_id) from `shop_clients` where client_id = $person_id");
  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

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
  	//  	$res = $db->query("select count(id) from messages where messages.to = $person_id");
  	//  	list($ret) = $db->fetch_row($res);
  	return $ret;
  }

  public function load_get_news_num($id, $from) {
  	global $db;
  	$this->add_dependency('people', $id);
  	$ret = array();
  	$person_id = $db->addslashes($id);

  	//друзей
  	if(is_array($from)){
		//удалить пустые элементы
		//$from = array_diff($from, array('',0,null, false));
		$from = array_filter(
			 $from,
			 function($el){ return !empty($el);}
		);
  		$from_sql=" and messages.`from` in (". implode(',', $from).")";

  	}

  	$query = "
  	select messages.status
  	from
  	messages, persons
  	where 1"
	.($from_sql?$from_sql:"").
  	" and to_deleted = 'no'
  	and `type`='news'
	and messages.status<>'deleted'
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

  public function load_get_friends($id, $limit = false) {
    global $db;
    $this->add_dependency('people', $id);
    $ret = array();
    $limit = $limit ? ' limit ' . $db->addslashes($limit) : '';
    $person_id = $db->addslashes($id);
    $res = $db->query("select person_id, friend_id from friends where person_id = $person_id or friend_id = $person_id $limit");
    while (list($p1, $p2) = $db->fetch_row($res)) {
      // friend requests are made both ways, so find the 'friend' in the pair
      $friend = $p1 != $person_id ? $p1 : $p2;
      $ret[$friend] = $this->get_person_info($friend);
    }
    return $ret;
  }

  private function get_friends_id($id){
  	global $db;
  	$res = $db->query("select person_id, friend_id from friends where person_id = $id or friend_id = $id");
  	$friends_ids=array();
  	while (list($p1, $p2) = $db->fetch_row($res)) {
  		$friend = $p1 != $id ? $p1 : $p2;
  		$friends_ids[]=$friend;
  	}
  	return $friends_ids;
  }

  //friends of friends, order by number of common friends
  public function get_posible_friends($id, $limit = 12){
  	global $db;
  	$ret = array();
  	$person_id = $db->addslashes($id);

  	//id друзей
  	$friends_ids=$this->get_friends_id($id);

  	//id друзей друзей
  	$all_f_of_f=array();
  	foreach ($friends_ids as $f_id){
  		$f_of_f_ids=$this->get_friends_id($f_id);
  		$all_f_of_f = array_merge($all_f_of_f, $f_of_f_ids);
  	}

  	//посчитать общих друзей для всех друзей друзей
  	$res=array();
  	foreach ($all_f_of_f as $f_of_f_id){
  		$num_of_common_friends=0;

  		if($f_of_f_id==$person_id) continue;
  		if(in_array($f_of_f_id, $friends_ids)) continue;

  		foreach ($friends_ids as $f_id){
  			if($f_id==$f_of_f_id){
  				$num_of_common_friends++;
  			}
  		}
  		//$res['id']=$f_of_f_id;
  		//$res['numberofcommonfriends']=$num_of_common_friends;
  		$res[$f_of_f_id]=$num_of_common_friends;
  	}

  	//сортировать по количеству общих друзей
  	arsort($res);


  	//показать пользователей для первых $limit друзей друзей
  	$i=0;
  	$ret=array();
    foreach ($res as $id => $num_of_common_friends) {
    	//echo "$key = $val\n";
    	$friend=$this->get_person_info($id);
    	$friend['numberofcommonfriends']=$num_of_common_friends;
    	$ret[] = $friend;
    	if($i>=$limit) return $ret;
    }

  	return $ret;
  }

  public function load_get_friends_count($id) {
    global $db;
    $this->add_dependency('people', $id);
    $ret = array();
    $person_id = $db->addslashes($id);
    $res = $db->query("select count(person_id) from friends where person_id = $person_id or friend_id = $person_id");
    list($ret) = $db->fetch_row($res);
    return $ret;
  }

  //добавить друга без взаимного подтвержения (для служебного использования)
  public function add_friend($id, $friend_id) {
  	global $db;
  	//try {
  		$this->invalidate_dependency('friend', $id);
  		$this->invalidate_dependency('friend', $friend_id);
  		$person_id = $db->addslashes($id);
  		$friend_id = $db->addslashes($friend_id);
  		$db->query("insert into friends values ($person_id, $friend_id)");
  	/*} catch (DBException $e) {
  		return false;
  	}*/
  	return true;
  }

  public function add_friend_request($id, $friend_id) {
    global $db;
    try {
      $this->invalidate_dependency('friendrequest', $id);
      $this->invalidate_dependency('friendrequest', $friend_id);
      $person_id = $db->addslashes($id);
      $friend_id = $db->addslashes($friend_id);
      $db->query("insert into friend_requests values ($person_id, $friend_id)");
    } catch (DBException $e) {
      return false;
    }
    return true;
  }

  public function accept_friend_request($id, $friend_id) {
    global $db;
    $person_id = $db->addslashes($id);
    $friend_id = $db->addslashes($friend_id);
    try {
      // double check if a friend request actually exists (reversed friend/person since the request came from the other party)
      $db->query("delete from friend_requests where person_id = $friend_id and friend_id = $person_id");
      // -1 = sql error, 0 = no request was made, so can't accept it since the other party never gave permission
      if ($db->affected_rows() < 1) {
        die("couldnt delete friend request, means there was none?");
        return false;
      }
      // make sure there's not already a connection between the two the other way around
      $res = $db->query("select friend_id from friends where person_id = $friend_id and friend_id = $person_id");
      if ($db->num_rows($res)) {
        die("the relation already exists the other way around,bailing");
        return false;
      }
      $db->query("insert into friends values ($person_id, $friend_id)");

      //FIXME quick hack to put in befriending activities, move this to its own class/function soon
      // We want to create the friend activities on both people so we do this twice
      $time = $_SERVER['REQUEST_TIME'];
      foreach (array($friend_id => $person_id, $person_id => $friend_id) as $key => $val) {
        $res = $db->query("select concat(first_name, ' ', last_name) from persons where id = $key");
        list($name) = $db->fetch_row($res);
        $db->query("insert into activities (person_id, app_id, title, body, created) values ($val, 0, 'and <a href=\"/profile/$key\" rel=\"friend\">$name</a> are now friends.', '', $time)");
        $this->invalidate_dependency('activities', $key);
      }
    } catch (DBException $e) {
      die("sql error: " . $e->getMessage());
      return false;
    }
    $this->invalidate_dependency('friendrequest', $id);
    $this->invalidate_dependency('friendrequest', $friend_id);
    $this->invalidate_dependency('people', $id);
    $this->invalidate_dependency('people', $friend_id);
    return true;
  }

  public function reject_friend_request($id, $friend_id) {
    global $db;
    $this->invalidate_dependency('friendrequest', $id);
    $this->invalidate_dependency('friendrequest', $friend_id);
    $person_id = $db->addslashes($id);
    $friend_id = $db->addslashes($friend_id);
    try {
      $db->query("delete from friend_requests where person_id = $friend_id and friend_id = $person_id");
    } catch (DBException $e) {
      return false;
    }
    return true;
  }

  public function load_get_friend_requests($id) {
  	global $db;
  	$this->add_dependency('friendrequest', $id);
  	$requests = array();
  	$friend_id = $db->addslashes($id);
  	$res = $db->query("select person_id from friend_requests where friend_id = $friend_id");
  	while (list($friend_id) = $db->fetch_row($res)) {
  		$requests[$friend_id] = $this->get_person($friend_id, false);
  	}
  	return $requests;
  }

  public function load_get_friend_requests_count($id) {
  	global $db;
  	$this->add_dependency('friendrequest', $id);
  	$requests = array();
  	$friend_id = $db->addslashes($id);
  	$res = $db->query("select count(person_id) from friend_requests where friend_id = $friend_id");
  	list($ret) = $db->fetch_row($res);
    return $ret;
  }

  public function search($name, $curpage) {
    global $db;
    $name = $db->addslashes($name);
    $ret = array();

    //TODO: translit
    //Translit.php;
    //my $tr = new Lingua::Translit("GOST 7.79 RUS");#ISO 9
    //$name_tr = $tr->translit($name);
    $res = $db->query("select id, email, first_name, last_name, thumbnail_url, activity, last_online, isoffline from persons where concat(first_name, ' ', last_name) like '%$name%' or email like '%$name%'");
    while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {

  	  $person['isonline']=0;
      if(( time()-$person['last_online'] < PartuzaConfig::get("online_time")) and !$person['isoffline']){
    	$person['isonline']=1;
      }

      $ret[] = $row;

    }

    $res = $db->query("select count(id) as total from persons where concat(first_name, ' ', last_name) like '%$name%' or email like '%$name%'");
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

  /*
   * get person info, need set field which we need.
   */
  public function get_person_fields($id, $fields) {
    global $db;
    $id = $db->addslashes($id);
    foreach ($fields as $val) {
      if (in_array($val, $this->supported_fields)) {
        $fields_adds[] = "`" . $db->addslashes($val) . "`";
      }
    }
    $res = $db->query("select " . implode(', ', $fields_adds) . " from persons where id = $id");
    if (! $db->num_rows($res)) {
      throw new Exception("Invalid person");
    }
    return $db->fetch_array($res, MYSQLI_ASSOC);
  }

  /*
   * set person info, need set field which we need.
   */
  public function set_person_fields($id, $fields) {
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
      $query = "update persons set " . implode(', ', $updates) . " where id = $id";
      $db->query($query);
      return $id;
    }
  }

  /*
   * if we can promise our code is safe, we can do it.
   * update media table use literal word, so do not escape update code.
   * for example update albums set uploaded_size = uploaded_size+1000; it will be easy.
   */
  public function literal_set_person_fields($id, $fields) {
    global $db;
    $id = $db->addslashes($id);
    foreach ($fields as $key => $val) {
    	if (in_array($key, $this->supported_fields)) {
    		$updates[] = "`" . $db->addslashes($key) . "` = " . $val ;
    	}
    }

    if (count($updates)) {
      $query = "update persons set " . implode(', ', $updates) . " where id = $id";
      $db->query($query);
      return $id;
    }
  }

  /*
   * показать данные человека по email
  */
  public function forgot_email($email) {
  	global $db;
  	$email = $db->addslashes($email);
  	$res = $db->query("select id from ".$this->table." where email='$email'");
  	$res=$db->fetch_array($res, MYSQLI_ASSOC);
  	$id=$res['id'];

  	if($id){
  		$password_code = $db->addslashes(uniqid('passw'));
  		$db->query("update ".$this->table." set password_code='$password_code' where id='$id'");
  		$data=$this->get_person_info($id);
  		$data['password_code']=$password_code;
  		return $data;
  	}
  	return;
  }

  // получить данные человека по коду восстановления пароля
  public function get_person_from_paswordcode($code) {
  	global $db;
  	$code = $db->addslashes($code);
  	$res = $db->query("select id from ".$this->table." where password_code='$code'");
  	$res=$db->fetch_array($res, MYSQLI_ASSOC);
  	$id=$res['id'];

  	if($id){
  		$data=$this->get_person_info($id);
  		return $data;
  	}
  	return;
  }

  // получить данные человека по коду восстановления пароля
  public function changepassword($code) {
  	global $db;
  	$code = $db->addslashes($code);
  	$res = $db->query("select id from ".$this->table." where password_code='$code'");
  	$res=$db->fetch_array($res, MYSQLI_ASSOC);
  	$id=$res['id'];

  	if($id){
  		$data=$this->get_person_info($id);
  		return $data;
  	}
  	return;
  }

  // новый пароль
  public function set_new_password($pars) {
  	global $db;
  	$code = $db->addslashes($pars['code']);
  	$password = $db->addslashes($pars['password']);
  	$res = $db->query("select id from ".$this->table." where password_code='$code'");
  	$res=$db->fetch_array($res, MYSQLI_ASSOC);
  	$id=$res['id'];

  	if($id){
  		$db->query("update ".$this->table." set password=PASSWORD('$password'), password_code='' where password_code='$code'");
  		return true;
  	}
  	return false;
  }

  #online
  public function i_am_online(){
  	global $db;

  	if(!isset($_SESSION['id']) or !is_numeric($_SESSION['id']) ){
		return;
  	}
  	$id = $db->addslashes($_SESSION['id']);
  	$last_online=time();
  	$query = "update persons set last_online=".$last_online.", isoffline=0 where id = ".$id;
  	$db->query($query);
  }

  public function logout(){
  	global $db;

  	if(!isset($_SESSION['id']) or !is_numeric($_SESSION['id']) ){
		return;
  	}
  	$id = $db->addslashes($_SESSION['id']);
  	$last_online=time();
  	$query = "update persons set last_online=".$last_online.", isoffline=1 where id = ".$id;
  	$db->query($query);
  }

  public function isonline($person_id){
  	global $db;
  	$code = $db->addslashes($code);
  	$res = $db->query("select last_online, isoffline from ".$this->table." where id='$person_id'");
  	$person=$db->fetch_array($res, MYSQLI_ASSOC);

  	return 0;
  	if(((time()-$person['last_online']) < PartuzaConfig::get("online_time")) and !$person['isoffline']){
  		return 1;
  	}
  }

  public function get_id_by_email($email) {
    global $db;
    $email = $db->addslashes($email);
    if(!$email) return false;

    $res = $db->query("select id from ".$this->table." where email = '$email'");
  	$res=$db->fetch_array($res, MYSQLI_ASSOC);
  	return $res['id'];
  }

  public function get_id_by_phone($phone) {
    global $db;
    $phone = $db->addslashes($phone);
    if(!$phone) return false;

    $res = $db->query("select id from ".$this->table." where phone = '$phone'");
  	$res=$db->fetch_array($res, MYSQLI_ASSOC);
  	return $res['id'];
  }

  public function update_clienttype($person_id, $type) {
    global $db;

    $type = $db->addslashes($type);

    $db->query("update ".$this->table." set clienttype_id = $type where id = '$person_id'");
  }

  public function activate_param($paramName, $paramValue) {
    global $db;   

  	$db->query("update ".$this->table." set is_activated=1 where ".$paramName." = '".$paramValue."'");
  	$res = $db->query("select is_activated from ".$this->table." where ".$paramName." = '".$paramValue."'");
  	$data = $db->fetch_array($res, MYSQLI_ASSOC);

  	return $data['is_activated'];
  }
}
