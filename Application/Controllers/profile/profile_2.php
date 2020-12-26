<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

class profileController extends baseController {
	private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF");
//	private $fileTypes=array("DOC","doc","JPEG", "jpeg","png","PNG","gif","GIF");

  public function index($params) {
    $id = isset($params[2]) && is_numeric($params[2]) ? $params[2] : false;

    if (! isset($_SESSION['id'])) {
    	header("Location: /home.php");
    }
    
    if (! $id) {
      //TODO add a proper 404 / profile not found here
      header("Location: /");
      //die();
    }
    $people = $this->model('people');
    $person = $people->get_person($id, true);
    $activities = $this->model('activities');
    $is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $id ? true : $people->is_friend($id, $_SESSION['id'])) : false;

    
    $is_friendrequested = (isset($_SESSION['id']) && $_SESSION['id'] != $id) ? $people->is_friendrequested($id, $_SESSION['id']) : false;
    $person_activities = $activities->get_person_activities($id, 10);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($id);
    $person_apps = null;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $id) {
      $person_apps = $apps->get_person_applications($_SESSION['id']);
    }
    
    //последние собеседники
    $messages = $this->model('messages');
    $collocutors= isset($_SESSION['id']) && $_SESSION['id'] == $id ? $messages->get_collocutors($_SESSION['id']) : array();
    //новости
    if($is_friend == 0) {
        $news = $messages->get_news_only_profile($id);
    } else {
        $news= (isset($_SESSION['id']) && $_SESSION['id'] == $id) ? $messages->get_news($id, $this->get_fromid_for_news($id),0,10) : $messages->get_news($id, array($id),0,10);
    }
    $wall = $this->model('wall');
    
    //$messages = $this->model('messages');
    //$messages_num=$messages->get_inbox_number($_SESSION['id']);
    //'messages_num'=>$messages_num,
    /*
    $r = $wall->get_shares(array(
      		'person_id'=>$id,
      		'start'=>0,
      		'limit'=>10));
    
    print_r($r);
    */
   
    $this->template('profile/profile.php', array(
    		'activities' => $person_activities, 
    		'applications' => $applications, 
    		'person' => $person, 
    		'friend_requests' => $friend_requests, 
    		'friends' => $friends,
    		'collocutors'=>$collocutors,
    		'news'=>$news,
      //'messages_num'=>$messages_num,
      		'wall'=>$wall->get_shares(array(
      		'person_id'=>$id,
      		'start'=>0,
      		'limit'=>10)),
      		'is_friendrequested' => $is_friendrequested,
      		'is_friend' => $is_friend, 
    		'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false, 
    		'person_apps' => $person_apps));
  }

  public function shops($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = isset($_SESSION['id']) ? $people->get_person($params[3], true) : false;
    $shops = $people->get_info_shop_clients($params[3]);//, "$start, $count");
    $shops_count = $people->get_shops_num($params[3]);
    if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $shops_count) {
      $page = intval($_GET['page']);
    } else {
      $page = 1;
    }
    $start = ($page - 1) * 8;
    $count = 8;
    $pages = ceil($shops_count / 8);

    $this->template('profile/profile_showshops.php', array( 'page' => $page, 'pages' => $pages, 'shops_count' => $shops_count, 'shops' => $shops,
    	'person' => $person,
        'array_admin' => array(1,2,3,4),
        'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false));
  }
  
  public function friends($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = isset($_SESSION['id']) ? $people->get_person($params[3], true) : false;
    $friends_count = $people->get_friends_count($params[3]);
    if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $friends_count) {
      $page = intval($_GET['page']);
    } else {
      $page = 1;
    }
    $start = ($page - 1) * 8;
    $count = 8;
    $pages = ceil($friends_count / 8);
    
    $friends = $people->get_friends($params[3]);//, "$start, $count");
    //$friends = $people->get_friends($params[3], "$start, $count");
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($params[3]);
    $is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3] ? true : $people->is_friend($params[3], $_SESSION['id'])) : false;
    $messages = $this->model('messages');
    //$messages_num=$messages->get_inbox_number($_SESSION['id']);
    //'messages_num'=>$messages_num,
    $posible_friends = $people->get_posible_friends($params[3]);
   
    
    $this->template('profile/profile_showfriends.php', array('is_friend' => $is_friend, 'page' => $page, 'pages' => $pages, 'friends_count' => $friends_count, 'friends' => $friends, 'applications' => $applications,
    	//'messages_num'=>$messages_num,
        'person' => $person,
    	'posible_friends'=>$posible_friends, 
        'array_admin' => array(1,2,3,4),
    	'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false));
  }

  public function message_inbox($type) {
    $start = 0;
    $count = 20;
    if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
      $start = ($_GET['page'] - 1) * 20;
    }
    $messages = $this->model('messages');
    //$messages_num=$messages->get_inbox_number($_SESSION['id']);
    if ($type == 'inbox') {
      $messages = $messages->get_inbox($_SESSION['id'], $start, $count);
    } elseif ($type == 'sent') {
      $messages = $messages->get_sent($_SESSION['id'], $start, $count);
    } else {
      die("invalid type");
    }
    //'messages_num'=>$messages_num,
    
    $this->template('profile/profile_show_messages.php', array('messages' => $messages, 'type' => $type,
    		//'messages_num'=>$messages_num,
    		));
  }

  //диалог текущего пользователя с $idUser
  public function message_im($idUser, $idShop=false) {
     //$_SESSION['shop_id'] = $idShop;
      
  	$messages = $this->model('messages');
  	$curpage = (isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
  	$period = (isset($_GET['period']) ? $_GET['period']:0);
  	$pages = $messages->get_im_pages($_SESSION['id'], $idUser,$curpage);
  	//$messages = $messages->get_im($_SESSION['id'], $idUser, $curpage);
                
  	if($idShop == false) {
            $messages = $messages->get_im_period($_SESSION['id'], $idUser, $period);
            $myshop = false;
    } else {
            $shop = $this->model('shop');
            $master_shop = $shop->get_shop_owner($idShop);
            $myshop = $shop->get_myshop($idUser, true);
            $messages = $messages->get_im_period_shop($_SESSION['id'], $idUser, $idShop, $period);
            
    }
  	
  	if(isset($_GET['style']) && $_GET['style']=='ajax'){
  		$this->template(
  				'profile/messages_index.php', 
  				array('messages' => $messages,
  					  'to'=>$idUser,
  					  'is_owner' => true,
  					  'nextpage'=>$pages['nextpage'],
  					  'totalpages'=>$pages['totalpages']));
  		return;
  	}
  	$people = $this->model('people');
  	$apps = $this->model('applications');
  	$applications = $apps->get_person_applications($_SESSION['id']);
  	$person = $people->get_person($_SESSION['id'], true);
  	
  	$this->template(
  			'profile/profile_messages_im.php', 
  			array(
  			'messages' => $messages,
  			'person' => $person,
  			'applications' => $applications,
  			'to'=>$idUser,
            'shop' => $myshop,
  			'is_owner' => true,
  			'nextpage'=>$pages['nextpage'],
  			'totalpages'=>$pages['totalpages']));
  }
  
  public function message_photos_inline($params){
  	$id=$params[3];
  	$media = $this->model('medias');
  	 
  	$this->template('/profile/messages_photos_toadd.php', array(
  			'message_id' => $id,
  			'medias' => $media->get_medias(array("message_id" => $id ),"IMAGE", "messages"),
  			'object_name' => "messages",
  			'object_id' => $id,
  			'id' => $id));
  }
    
  //
  public function message_news($type) {
  	$start = 0;
  	$count = 20;
  	if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0) {
  		$start = ($_GET['page'] - 1) * 20;
  	}
  	$messages = $this->model('messages');
  	//$messages_num=$messages->get_inbox_number($_SESSION['id']);
  	if ($type == 'inbox') {
  		$messages = $messages->get_inbox($_SESSION['id'], $start, $count);
  	} elseif ($type == 'sent') {
  		$messages = $messages->get_sent($_SESSION['id'], $start, $count);
  	} else {
  		die("invalid type");
  	}
  	//'messages_num'=>$messages_num,
  
  	$this->template('profile/profile_show_messages.php', array('messages' => $messages, 'type' => $type,
  			//'messages_num'=>$messages_num,
  	));
  }
  
  public function message_composenews() {
  	$people = $this->model('people');
  	$friends = $people->get_friends($_SESSION['id']);
  	$this->template('/profile/profile_compose_message.php', array('friends' => $friends));
  }
  
  public function message_notifications() {
    die('Not implemented, at some point this will container friend requests and requestShareApp notifications');
  }

  public function message_delete($message_id) {
    $messages = $this->model('messages');
    $message = $messages->get_message($message_id);
    // silly special case if you send a message to your self
    if ($message['to'] == $_SESSION['id'] && $message['from'] == $_SESSION['id']) {
      $messages->delete_message($message_id, 'to');
      $messages->delete_message($message_id, 'from');
      return;
    }
    if ($message['to'] == $_SESSION['id']) {
      $type = 'to';
    } elseif ($message['from'] == $_SESSION['id']) {
      $type = 'from';
    } else {
      die('This is not the message your looking for');
      return;
    }
    $messages->delete_message($message_id, $type);
  }

  public function message_get() {
    $messageId = isset($_GET['messageId']) ? intval($_GET['messageId']) : false;
    $messageType = isset($_GET['messageType']) && ($_GET['messageType'] == 'inbox' || $_GET['messageType'] == 'sent') ? $_GET['messageType'] : false;
    if (!$messageId || !$messageType) {
      die('This is not the message your looking for');
    }
    $messages = $this->model('messages');
    $message = $messages->get_message($messageId);
    if (isset($message['status']) && $message['status'] == 'new') {
    	//TODO if (type=="news" || type="public_message") { пометить как прочитаное} 
      $messages->mark_read($messageId);
    }
    $this->template('/profile/profile_show_message.php', array('message' => $message, 'messageId' => $messageId, 'messageType' => $messageType));
  }

  //подготовиться добавлять новое сообщение
  public function message_compose($to=false) {
    $people = $this->model('people');
    $message = $this->model('messages');
    $friends = $people->get_friends($_SESSION['id']);
    
    //echo $_GET['type'];
    
    $id = $message->prepare_new_message($_SESSION['id'],
    			array('from'=>$_SESSION['id'],
    				  'status'=>'deleted',
    				  'to'=>$to
    			));
    	 
    if (!$id) {
    		die('Error preparing_new_message');
   	}
    
    $this->template('/profile/profile_compose_message.php', array(
    		    'friends' => $friends,
    			'message_id'=>$id,
    			'person' => $people->get_person($_SESSION['id'], false),
    			'object_name'=>$_GET['object_name'],
    			'object_id'=>$_GET['object_id'],
    			'id'=>$_GET['object_id']));    
  }

  //подготовиться добавлять новое сообщение в диалоге
  public function message_compose_inline($to=false) {
    
    $people = $this->model('people');
    $message = $this->model('messages');
    $friends = $people->get_friends($_SESSION['id']);
    $shop_id = isset($_GET['shop_id'])?$_GET['shop_id']:NULL;
    
    $id = $message->prepare_new_message($_SESSION['id'],
    			array('from'=>$_SESSION['id'],
    				  'status'=>'deleted',
    				  'to'=>$to
    			));
    	 
   if (!$id) {
    		die('Error preparing_new_message');
   	}
   # $shop_id = 16;
    $shop = $this->model("shop");
   	
   	$ismyshop = false;
   	if(isset($shop_id)){
	   	$myshop = $shop->get_myshop($_SESSION['id'], false);
   		if($shop_id == $myshop['id']){
   			$ismyshop = true;
   		}	
   	}
        
    $this->template('/profile/message_compose_inline.php', array(
    		    'friends' => $friends,
    			'message_id'=>$id,
    			'to'=>$to,
                'shop_id'=> ($ismyshop?$shop_id:false),
                'shop'=> ($ismyshop ?$shop->get_name_pic_shop($shop_id):false),
    			'person' => $people->get_person($_SESSION['id'], false),
    			'personto' => $people->get_person($to, false),
    			'object_name'=>"message",
    			'object_id'=>$id,
    			'id'=>$id));    
  }

  public function message_send_inline($id) {
    $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : 0;
    $to = isset($_POST['to']) ? $_POST['to'] : false;
    $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : false;
    //$body = isset($_POST['body']) ? trim(strip_tags($_POST['body'], '<b><strong><i><em><u><s><strike><sub><sup><p><br>')) : '';
    $body = isset($_POST['body']) ? trim($_POST['body']) : '';
    
    $messages = $this->model('messages');
    
    if(isset($id) and is_numeric($id)){
    	$created = $_SERVER['REQUEST_TIME'];
        if($shop_id == 0){
            $messages->save($id, array(
    			'from'=>$_SESSION['id'],
    			'to'=>$to,
    			'body'=>$body,
    			'created'=>$created,
    			'status'=>'unread'));
        } else {
            $messages->save($id, array(
    			'from'=>$_SESSION['id'],
    			'to'=>$to,
                        'shop_id'=>$shop_id,
    			'body'=>$body,
    			'created'=>$created,
    			'status'=>'unread'));
        }
    }else{
        if($shop_id == 0) {
            $id = $messages->send_message($_SESSION['id'], $to, $subject, $body);
        } else {
            $id = $messages->send_shop_message($_SESSION['id'], $to, $shop_id, $subject, $body);
        }
    }
    
    if($shop_id != 0) { 
        $results = $messages->get_shop_message($id, $shop_id);
    } else {
        $results = $messages->get_message($id);
    }
    
    $this->template('profile/message_index.php', $results );
  }

  public function message_send($id) {
  	$to = isset($_POST['to']) ? $_POST['to'] : array();
  	$subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : false;
  	//$body = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : (isset($_POST['body']) ? trim(strip_tags($_POST['body'])) : '');
        $body = isset($_POST['message']) ? trim($_POST['message']) : (isset($_POST['body']) ? trim($_POST['body']) : '');
    	
  	$messages = $this->model('messages');
  	
  	if(is_numeric($to)){ //to is one person
    	if(isset($id) and is_numeric($id)){
  			$created = $_SERVER['REQUEST_TIME'];
  			$messages->save($id, array(
  				'body'=>$body,
  				'to'=>$to,
  				'created'=>$created,
  				'status'=>'unread'));
  		}else{
  			$id = $messages->send_message($_SESSION['id'], $to, $subject, $body);
  		}
  	}else{
  		//multiply to
  		//save first
  		$to = array_pop($_POST['to']);
  		if(isset($id) and is_numeric($id)){
  			$created = $_SERVER['REQUEST_TIME'];
  			$messages->save($id, array(
  					'body'=>$body,
  					'to'=>$to,
  					'created'=>$created,
  					'status'=>'unread'));
  		}else{
  			$id = $messages->send_message($_SESSION['id'], $to, $subject, $body);
  		}
  		
  		//copy others
  		$source_id=$id;
  		foreach ($_POST['to'] as $to) {
  			$message_id=$messages->copy($id, $to);
  			$this->message_copy_files($source_id, $message_id);
  		}
  	}
  	
  	$results = $messages->get_message($id);
  	$this->template('profile/message_index.php', $results );
  }
  
  /* копирование файлов
   * $id -> $to
  * */
  public function message_copy_files($id, $message_id) {
  	//echo "1";
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	$people = $this->model('people');
  	//$person = $people->get_person_fields($_SESSION['id'], array('uploaded_size'));
  
  	$newdir=PartuzaConfig::get('site_root').'/images/messages/'.$message_id;
  	
  	 
  	if (!file_exists($newdir)) {
  		if (!@mkdir($newdir, 0777, true)) {
  			die ("error creating folder $newdir");
  		}
  	}
  	$this->_sync_folder(PartuzaConfig::get('site_root').'/images/messages/'.$id, $newdir);
  	
  	//echo "1";
  	$media=$this->model("medias");
  	$srcdir=$newdir;
  	if($curdir = opendir($srcdir)) {
  		while($file = readdir($curdir)) {
  			if($file != '.' && $file != '..') {
  				if (preg_match("/^(\d+)\.(\w+)$/", $file, $match)) {
  					$media_id=$match[0];
  					$media->copy($media_id, array("message_id" => $message_id));
  				}
  			}
  		}
  		closedir($curdir);
  	}
  	  	
  }
  
  public function message_markread($id) {
  	$messages = $this->model('messages');
        
        $user_from = $messages->get_user_from_message($id);
        
  	if(isset($id) and is_numeric($id) and ($user_from != $_SESSION['id'])){
  		$messages->save($id, array(
  				'status'=>'read'));
  	}
  }
  
  public function messages($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
        
    if (isset($params[3])) {
      switch ($params[3]) {
        case 'inbox':
          $this->message_inbox('inbox');
          break;
        case 'sent':
          $this->message_inbox('sent');
          break;
        case 'notifications':
          $this->message_notifications();
          break;
        case 'delete':
          $this->message_delete($params[4]);
          break;
        case 'get':
          $this->message_get();
          break;
        case 'compose':
            
          $this->message_compose($params[4]);
          break;
        case 'send':
          $this->message_send($params[4]);
          break;
        case 'im':
          if(isset($params[5])) $this->message_im($params[4], $params[5]);
          else $this->message_im($params[4]);
          break;
        case 'compose_inline':
          $this->message_compose_inline($params[4]);
          break;
        case 'send_inline':
          	$this->message_send_inline($params[4]);
          	break;
        case 'markread':
          	$this->message_markread($params[4]);
          	break;
      }
    } else {
      $people = $this->model('people');
      $apps = $this->model('applications');
      $applications = $apps->get_person_applications($_SESSION['id']);
      $person = $people->get_person($_SESSION['id'], true);
      
      $messages = $this->model('messages');
      $message_persons=$messages->get_message_persons($_SESSION['id']);
      /*echo '<pre>';
      print_r($message_persons);
      echo '</pre>';*/
      
      //$messages_num=$messages->get_inbox_number($_SESSION['id']);
      //'messages_num'=>$messages_num,
      $shop = $this->model('shop');
      $shop_id = $shop->get_shop_id($_SESSION['id']);
      
      $this->template('profile/profile_messages.php', array('person' => $person, 
      		//'messages_num'=>$messages_num,
            'shop_id_of_profile'=>$shop_id[0],
      		'applications' => $applications,
      		'message_persons' => $message_persons,
      		'is_owner' => true));
    }
  }

  public function photos($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = isset($params[3]) ? $people->get_person($params[3], true) : false;
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($params[3]);
    $is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3] ? true : $people->is_friend($params[3], $_SESSION['id'])) : false;
    //$messages = $this->model('messages');
    //$messages_num=$messages->get_inbox_number($_SESSION['id']);
    $this->template('profile/profile_photos.php', 
      array('is_friend' => $is_friend, 
            'applications' => $applications, 
            'person' => $person, 
      		//'messages_num'=>$messages_num,
            'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false));
  }


  /**
   * save an album item add or update.
   */
  public function photos_save($params) {
    if (! isset($_SESSION['id']) || $_SESSION['id'] != $params[3] || ! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $album = $this->model('albums');
    $album_item = array();
    if (isset($_POST['title'])) $album_item['title'] = $_POST['title'];
    if (isset($_POST['description'])) $album_item['description'] = $_POST['description'];
    $album_item['owner_id'] = $_SESSION['id'];
    $album_item['media_mime_type'] = 'image';
    $album_item['media_type'] = 'IMAGE';
    $album_item['app_id'] = 0;
    // if $params[4] have not set, it's add an album item.
    // if $params[4] set, it's update an album item.
    if (! isset($params[4]) || ! is_numeric($params[4])) {
      $album_item['created'] = time();
      $album_item['modified'] = time();
      $album_item['media_count'] = 0;
      $album_id = $album->add_album($album_item);
      die($album_id);
    } else {
      $album_item['modified'] = time();
      $album_id = $params[4];
      $album_id = $album->update_album($album_id, $album_item);
      die($album_id);
    }
  }

  /*
   * save an media item update.
   */
  public function photo_save($params) {
    if (! isset($_SESSION['id']) || $_SESSION['id'] != $params[3] || ! isset($params[3]) || 
      ! is_numeric($params[3]) || ! isset($params[4]) || ! is_numeric($params[4])) {
      header("Location: /");
      die();
    }
    $media = $this->model('medias');
    $media_item = array();
    // if thumbnial_url set, will update album table, set the media_id to album table.
    if (isset($_POST['thumbnail_url'])) {
      $media_items = $media->get_media($params[4]);
      $album_item = array();
      $album_item['thumbnail_url'] = isset($media_items['thumbnail_url']) ? $media_items['thumbnail_url'] : $media_items['url'];
      $album_item['media_id'] = $media_items['id'];
      $album = $this->model('albums');
      $album->update_album($media_items['album_id'], $album_item);
    }
    
    if (isset($_POST['title'])) $media_item['title'] = $_POST['title'];
    if (isset($_POST['description'])) $media_item['description'] = $_POST['description'];
    $media_item['app_id'] = 0;
    $media_item['last_updated'] = time();
    $media_id = $media->update_media($params[4], $media_item);
    die($media_id);
  }

  /*
   * when $_SESSION['id'] not set, display album albums have not 'edit' and 'delete' button. so $is_owner be used in this view.
   * $_GET['s'] is start index for album items;
   * $_GET['c'] is one page display num.
   */
  public function photos_list($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    if (isset($_GET['c']) && is_numeric($_GET['c'])) {
      $items_to_show = $_GET['c'];
    } else {
      $items_to_show = 10;
    }
    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
      $start_index = intval($_GET['s']);
      $start_index = floor($start_index/$items_to_show) * $items_to_show;
    } else {
      $start_index = 0;
    }
    if (isset($params[4]) && $params[4] == 'self') {
      $albums = $this->model('albums');
      try {
        $albums = $albums->get_albums($params[3], $start_index, $items_to_show);
      }
      catch (DBException $e) {
        $message = 'Error saving information (' . $e->getMessage() . ')';
        die($message);
      }
      $this->template('profile/profile_photos_list.php', 
        array('albums' => $albums,
              'person_id' => $params[3],
              'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false,
              'page' => array('start_index'=>$start_index, 'items_to_show'=>$items_to_show, 'items_count'=>$albums['found_rows'])));  
    }
    else {
      $albums = $this->model('albums');
      echo 'not implemented';
    }
  }
  /*
   * when $_SESSION['id'] not set, display album photos have not 'edit' and 'delete' button. so $is_owner be used in this view.
   * $_GET['s'] is start index for album items;
   * $_GET['c'] is one page display num.
   */
  public function photos_view($params) {
    if (! isset($params[3]) || ! is_numeric($params[3]) || ! isset($params[4]) || ! is_numeric($params[4])) {
      header("Location: /");
      die();
    }
    if (isset($_GET['c']) && is_numeric($_GET['c'])) {
      $items_to_show = $_GET['c'];
    } else {
      $items_to_show = 12;
    }
    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
      $start_index = intval($_GET['s']);
      $start_index = floor($start_index/$items_to_show) * $items_to_show;
    } else {
      $start_index = 0;
    }

    $curpage=isset($_GET['curpage'])?$_GET['curpage']:0;
    
    $people = $this->model('people');
    $person = isset($_SESSION['id']) ? $people->get_person($params[3], true) : false;
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($params[3]);
    $is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3] ? true : $people->is_friend($params[3], $_SESSION['id'])) : false;
    $album = $this->model('albums');
    $albums = $album->get_album($params[4]);
    if ($start_index > $albums['media_count']) $start_index = floor($albums['media_count']/$items_to_show)*$items_to_show;
    $media = $this->model('medias');
    
    //$medias = $media->get_medias($params[3], $params[4], $start_index, $items_to_show);
    //$owner_id, $album_id, $start = false, $count = false, $message_id
    $medias = $media->get_medias(array( "owner_id" => $params[3], 
    									"album_id" => $params[4], 
    									"curpage" => $curpage));
    $pages = $media->get_medias_pages(array( "owner_id" => $params[3], 
    									"album_id" => $params[4], 
    									"curpage" => $curpage));
    
    if (! isset($albums['id'])) $albums['id'] = '';
    if (! isset($albums['owner_id'])) $albums['owner_id'] = '';
    if (! isset($albums['title'])) $albums['title'] = '';
    if (! isset($albums['description'])) $albums['description'] = '';
    if (! isset($medias['found_rows'])) $medias['found_rows'] = 0;
    
    if(isset($_GET['style']) && $_GET['style']=='ajax'){
    	 $this->template('profile/photo_index.php', 
      		array('is_friend' => $is_friend, 
            'applications' => $applications, 
            'person' => $person, 
            'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false,
            'medias' => $medias,
            'albums' => $albums,
      		'nextpage'=>$pages['nextpage'],
      		'totalpages'=>$pages['totalpages'],
            'page' => array('start_index'=>$start_index, 'items_to_show'=>$items_to_show, 'items_count'=>$medias['found_rows'])));    
    }else{
	    $this->template('profile/profile_photos_view.php', 
    	  array('is_friend' => $is_friend, 
            'applications' => $applications, 
            'person' => $person, 
            'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false,
            'medias' => $medias,
            'albums' => $albums,
      		'nextpage'=>$pages['nextpage'],
      		'totalpages'=>$pages['totalpages'],
            'page' => array('start_index'=>$start_index, 'items_to_show'=>$items_to_show, 'items_count'=>$medias['found_rows'])));
    }
  }

  /*
   * $params[3] owner_id, $params[4] albums_id, $params[5] media_id.
   */
  public function photo_view($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])
      || !isset($params[4]) || ! is_numeric($params[4])
      || !isset($params[5]) || ! is_numeric($params[5])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = isset($_SESSION['id']) ? $people->get_person($params[3], true) : false;
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($params[3]);
    $is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3] ? true : $people->is_friend($params[3], $_SESSION['id'])) : false;
    $media = $this->model('medias');
    $medias = $media->get_media_has_order($params[4], $params[5]);
    $album = $this->model('albums');
    $albums = $album->get_album($params[4]);
    $item_order = $medias['item_order'];
    $item_count = $medias['found_rows'];
    if ($item_order == 1) {
      $current_media = $medias[0];
    } else {
      $current_media = $medias[1];
    }
    if (! isset($albums['id'])) $albums['id'] = '';
    if (! isset($albums['title'])) $albums['title'] = '';
    if (! isset($albums['description'])) $albums['description'] = '';
    if (! isset($albums['media_count'])) $albums['media_count'] = 0;
    if (! isset($current_media['title'])) $current_media['title'] = '';
    if (! isset($current_media['description'])) $current_media['description'] = '';
    if (! isset($current_media['item_order'])) $current_media['item_order'] = '';
    $tmp_pos = strrpos($current_media['url'], '.');
    $current_media['original_url'] = $current_media['url'];
    //$current_media['url'] = substr($current_media['url'], 0, $tmp_pos) . '.600x600' . substr($current_media['url'], $tmp_pos);
    unset($medias['item_order']);
    unset($medias['found_rows']);
    $this->template('profile/profile_photo_view.php', 
      array('is_friend' => $is_friend, 
            'applications' => $applications, 
            'person' => $person, 
            'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $params[3]) : false,
            'medias' => $medias,
            'albums' => $albums,
            'current_media' => $current_media,
            'item_order' => $item_order,
            'item_count' => $item_count));
  }

  public function photo_show($params) {
  	if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
  	$media = $this->model('medias');
  	$media_item = $media->get_media($params[3]);
  	$file_path = str_replace(PartuzaConfig::get('partuza_url'), PartuzaConfig::get('site_root').'/', $media_item['url']);
    die();
  }

  /*загрузка фото в альбом (старая, по одной картинке)*/
  public function photo_upload($params) {
    if (! isset($params[3]) || ! is_numeric($params[3]) || $_SESSION['id'] != $params[3]
      || !isset($params[4]) || ! is_numeric($params[4])) {
      header("Location: /");
      $this->template('profile/profile_photos_upload.php', array('result' => false));
      die();
    }
    $people = $this->model('people');
    $person = $people->get_person_fields($_SESSION['id'], array('uploaded_size'));

    // upload file info is empty
    if (! isset($_FILES['uploadPhoto']) || empty($_FILES['uploadPhoto']['name'])) {
      $this->template('profile/profile_photos_upload.php', array('result' => false));
      die();
    }
    
    // upload file size over quota.
    $file = $_FILES['uploadPhoto'];
//    if (PartuzaConfig::get('upload_quota') - $person['uploaded_size'] < $file['size']) {
//      $this->template('profile/profile_photos_upload.php', array('result' => false));
//      die();
//    }
    if (substr($file['type'], 0, strlen('image/')) != 'image/') {
      $this->template('profile/profile_photos_upload.php', array('result' => false));
      die();
    }
    $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
    // it's a file extention that we accept too (not that means anything really)
    $accepted = array('gif', 'jpg', 'jpeg', 'png');
    if (!in_array($ext, $accepted) || $file['size'] < 4) {
      $this->template('profile/profile_photos_upload.php', array('result' => false));
      die();
    }

    // it's upload file path.
    $album_id = $params[4];
    $tmp_dir = array('/images', '/albums', '/'.$album_id);
    $album_dir = '/images/albums/'.$album_id;
    $file_dir = PartuzaConfig::get('site_root');
    foreach($tmp_dir as $val) {
    	$file_dir .= $val;
      if (!file_exists($file_dir)) {
        if (!@mkdir($file_dir, 0777, true)) {
          $this->template('profile/profile_photos_upload.php', array('result' => false));
          die();
        }
      }
    }
    $title = (!empty($_POST['title'])) ? $_POST['title'] : substr($file['name'], 0, strrpos($file['name'], '.'));
    $media = $this->model('medias');
    $media_item = array(
      'album_id' => $album_id,
      'owner_id' => $_SESSION['id'],
      'object_name' =>"albums",
      'mime_type' => '',
      'title' => $title,
      'file_size' => $file['size'],
      'created' => time(),
      'last_updated' => time(),
      'type' => 'IMAGE',
      'url' => '',
      'app_id' => 0,
    );
    
    // if insert data failed, throw an error.
    try {
      $media_id = $media->add_media($media_item);
    } catch (DBException $e) {
      $this->template('profile/profile_photos_upload.php', array('result' => false));
      die();
    }

    $file_path = $file_dir . '/' . $media_id . '.' . $ext;
    if (! Image::createImage($file['tmp_name'], $file_path, null, null)) {
    	// if move file failed, need delete the item in media_item table.
      $media->delete_media($params[3], $media_id);
      $this->template('profile/profile_photos_upload.php', array('result' => false));
    //  die();
    } else {
    	// insert and upload file is success.
      $media_item = array();
      $media_item['url'] = $album_dir . '/' . $media_id . '.' . $ext;
      $media_item['thumbnail_url'] = Image::by_size($file_path, 220, 220);
      $size = GetImageSize($file_path);
      $media_item['width']=$size[0];
      $media_item['height']=$size[1];
      $media_id = $media->update_media($media_id, $media_item);
      
      $album = $this->model('albums');
      $album_record = $album->get_album($params[4]);
      $album_item = array();
      $album_item["media_count"] = $album_record["media_count"]  + 1;
      $album_item["modified"] = time();
      if (empty($album_record['media_id'])) {
        $album_item['media_id'] = $media_id;
        $album_item['thumbnail_url'] = $media_item['thumbnail_url'];
      }
      $album_id = $album->update_album($params[4], $album_item);
      $person = $people->literal_set_person_fields($params[3], array('uploaded_size' => "uploaded_size + {$file['size']}"));
      $media_item['thumbnail_url600']=Image::by_size($file_path, 600, 600);
      $media_id = $media->update_media($media_id, $media_item);
      
      $this->template('profile/profile_photos_upload.php', array('result' => true));
    //  die();
    }
  }
  
  /*загрузка фотографий 28.09.2012*/
  public function photos_upload($params) {
  	
  	if (! isset($params[3]) || ! is_numeric($params[3]) || $_SESSION['id'] != $params[3]
  			|| !isset($params[4]) || ! is_numeric($params[4])) {
  		header("Location: /");
  	}
  	$people = $this->model('people');
  	$person = $people->get_person_fields($_SESSION['id'], array('uploaded_size'));

  	// it's upload file path.
  	$album_id = $params[4];
  	$tmp_dir = array('/images', '/albums', '/'.$album_id);
  	$album_dir = '/images/albums/'.$album_id;
  	$file_dir = PartuzaConfig::get('site_root');
  	foreach($tmp_dir as $val) {
  		$file_dir .= $val;
  		if (!file_exists($file_dir)) {
  			if (!@mkdir($file_dir, 0777, true)) {
  				die;
  			}
  		}
  	}
  	 
  	$message = '';
  	$people = $this->model('people');
  	$filewebname="1";
  	
  	//сохранить картинку
  	if (!empty($_FILES)) {
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
		$fileParts  = pathinfo($_FILES['Filedata']['name']);
	
		if (in_array($fileParts['extension'],$this->imageTypes)) {
			$title = (!empty($_POST['title'])) ? $_POST['title'] : substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
			$media = $this->model('medias');
			$media_item = array(
					'album_id' => $album_id,
					'owner_id' => $_SESSION['id'],
					'object_name' =>"albums",						
					'mime_type' => '',
					'title' => $title,
					//'file_size' => $fileParts['size'],
					'created' => time(),
					'last_updated' => time(),
					'type' => 'IMAGE',
					'url' => '',
					'app_id' => 0,
			);
			try {
				$media_id = $media->add_media($media_item);
			} catch (DBException $e) {
				die();
			}
				
			$ext = strtolower($fileParts['extension']);
			$filename=PartuzaConfig::get('site_root') . $album_dir . '/' . $media_id . '.' . $ext;
			// it's a file extention that we accept too (not that means anything really)
			if (! move_uploaded_file($tempFile, $filename)) {
					die("no permission to images/people dir, or possible file upload attack, aborting");
			}
			
			//уменьшить до максимально допустимого размера
			$img=new SimpleImage();
			$img->load($filename);
			$img->save($filename);
			//$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
			$filename_thumbnail600=$album_dir . '/' . $media_id . '.600x600.' . $ext;
			$img->save(PartuzaConfig::get('site_root') . $filename_thumbnail600);
			//$img->resizeAdaptive(220, 220);
			$filename_thumbnail220=$album_dir . '/' . $media_id . '.220x220.' . $ext;
			$img->save(PartuzaConfig::get('site_root') . $filename_thumbnail220);
				
			echo $filename_thumbnail220;
			
			// if insert data failed, throw an error.
				// insert and upload file is success.
			$media_item = array();
			$media_item['url'] = $filewebname;
			$media_item['thumbnail_url'] = $filename_thumbnail220;
			
			$size = GetImageSize($filename);
			$media_item['width']=$size[0];
			$media_item['height']=$size[1];
				
			$media_id = $media->update_media($media_id, $media_item);
			
			$album = $this->model('albums');
			$album_record = $album->get_album($params[4]);
			$album_item = array();
			$album_item["media_count"] = $album_record["media_count"]  + 1;
			$album_item["modified"] = time();
			if (empty($album_record['media_id'])) {
				$album_item['media_id'] = $media_id;
				$album_item['thumbnail_url'] = $media_item['thumbnail_url'];
			}
			$album_id = $album->update_album($params[4], $album_item);
			//$person = $people->literal_set_person_fields($params[3], array('uploaded_size' => "uploaded_size + {$file['size']}"));
			$media_item['thumbnail_url600']=$filename_thumbnail600;
			$media_id = $media->update_media($media_id, $media_item);
				
		}
  	}
  
  }

  public function album_delete($params) {
    if (! isset($_SESSION['id']) || $_SESSION['id'] != $params[3] 
      || ! isset($params[3]) || ! is_numeric($params[3]) || ! isset($params[4]) || ! is_numeric($params[4])) {
      header("Location: /");
    }
    $album = $this->model('albums');
    $album->delete_album($params[3], $params[4]);
    die('success');
  }

  public function media_delete($params) {
    if (! isset($_SESSION['id']) || $_SESSION['id'] != $params[3] 
      || ! isset($params[3]) || ! is_numeric($params[3]) || ! isset($params[4]) || ! is_numeric($params[4])) {
      header("Location: /");
    }
    $media = $this->model('medias');
    $media_item = $media->get_media($params[4]);
    $albums = $this->model('albums');

    $people = $this->model('people');
    //$person = $people->literal_set_person_fields($params[3], array('uploaded_size' => "uploaded_size - {$media_item['file_size']}"));
    if (!empty($media_item['album_id'])) {
    	// delete one media item, update album item and person item.
      $album_item = $albums->get_album($media_item['album_id']);
      $album_record = array();
      if (($album_item['media_id'] == $media_item['id'])) {
      	// if the delete one is a cover picture.
        $media_tmp = $media->get_media_previous($media_item['album_id'], $media_item['id']);
        if (empty($media_tmp)) $media_tmp = $media->get_media_next($media_item['album_id'], $media_item['id']);
        if (empty($media_tmp)) {
          $album_record['thumbnail_url'] = null;
          $album_record['media_id'] = null;
        } else {
          $album_record = array();
          $album_record['thumbnail_url'] = empty($media_tmp['thumbnail_url']) ? $media_tmp['url'] : $media_tmp['thumbnail_url'];
          $album_record['media_id'] = $media_tmp['id'];
        }
      }
      if($album_item['media_count']>0){
      	$album_record['media_count'] = $album_item['media_count'] - 1;
      }else{
      	$album_record['media_count']=0;
      }
      $albums->update_album($album_item['id'], $album_record);
    }
    $media->delete_media($params[3], $params[4]);
    die('success');
  }

  //сохранить информацию в профиле
  public function edit($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    $message = '';
    $people = $this->model('people');
    if (count($_POST)) {
     /* if (! empty($_POST['date_of_birth_month']) && ! empty($_POST['date_of_birth_day']) && ! empty($_POST['date_of_birth_year']) && is_numeric($_POST['date_of_birth_month']) && is_numeric($_POST['date_of_birth_day']) && is_numeric($_POST['date_of_birth_year'])) {
        $_POST['date_of_birth'] = mktime(0, 0, 1, $_POST['date_of_birth_month'], $_POST['date_of_birth_day'], $_POST['date_of_birth_year']);
      }
      */
      $date_of_birth = isset($_POST['date_of_birth']) ? trim(strip_tags($_POST['date_of_birth'])) : '';
      preg_match("/(\d+)\.(\d+)\.(\d+)/", $date_of_birth, $res);
      
      if(isset($res[1]) and isset($res[2]) and isset($res[3])){
      	$_POST['date_of_birth']=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
      }
    	 
      try {
        $people->save_person($_SESSION['id'], $_POST);
        $message = 'Saved information';
      } catch (DBException $e) {
        $message = 'Error saving information (' . $e->getMessage() . ')';
      }
    }
    $oauth = $this->model('oauth');
    $oauth_consumer = $oauth->get_person_consumer($_SESSION['id']);
    $person = $people->get_person($_SESSION['id'], true);
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($_SESSION['id']);
    
    $messages = $this->model('messages');
    $messages_num=$messages->get_inbox_number($_SESSION['id']);
    //'messages_num'=>$messages_num,
    
    $edu = $this->model('education');
    $education['school'] = $edu->show(array("person_id"=>$_SESSION['id'], "type"=>"1school"));
    $education['college'] = $edu->show(array("person_id"=>$_SESSION['id'], "type"=>"2college"));
    $education['univer'] = $edu->show(array("person_id"=>$_SESSION['id'], "type"=>"3univer"));
    
    $model = $this->model('car_model');
    $models = $model->show(array());
    
    $marka = $this->model('car_marka');
    $marki = $marka->show(array());
    
    $car = $this->model('car');
    $cars = $car->show(array("person_id"=>$_SESSION['id']));
    
    $address = $this->model('address');
    $addresses = $address->show(array("object"=>"people", "object_id"=>$_SESSION['id']));
    
    $country = $this->model('country_content');
    
    $this->template('profile/profile_edit.php', array('message' => $message, 'applications' => $applications, 'person' => $person, 'oauth' => $oauth_consumer, 'is_owner' => true,'messages_num'=>$messages_num, 
    		'addresses'=>$addresses,
    		'education'=>$education,
    		'cars'=>$cars,
    		'car_model'=>$models,
    		'car_marka'=>$marki,
    		'countries'=>$country->get_countries($this->get_cur_lang())));
  }
  
  //залить картинку
  public function uploadprofileimg($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	$message = '';
  	$people = $this->model('people');
  	$filewebname="1";
  	//сохранить картинку
  	if (!empty($_FILES)) {
		$tempFile = $_FILES['Filedata']['tmp_name'];
		$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
		$fileParts  = pathinfo($_FILES['Filedata']['name']);
	
		if (in_array($fileParts['extension'],$this->imageTypes)) {
			//move_uploaded_file($tempFile,$targetFile);
			$ext = strtolower($fileParts['extension']);
			$filename=PartuzaConfig::get('site_root') . '/images/people/' . $_SESSION['id'] . '.' . $ext;
			$filewebname=$_SESSION['id'] . '.' . $ext;
			// it's a file extention that we accept too (not that means anything really)
			if (! move_uploaded_file($tempFile, $filename)) {
					die("no permission to images/people dir, or possible file upload attack, aborting");
			}
			
			//уменьшить до максимально допустимого размера
			$img=new SimpleImage();
			$img->load($filename);
			//$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
			$img->save($filename);
		}
  	}
  	echo $filewebname;
  }

  //залить preview картинку
  public function cropprofileimg($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	$message = '';
  	$people = $this->model('people');
  	$filewebname="1";
  	//сохранить картинку
  	foreach($_POST['imgcrop'] as $k => $v) {
		$targetPath = PartuzaConfig::get('site_root') . $v['folder'] . '/';
		$targetFile =  str_replace('//','/',$targetPath) . $v['name'];
		
		$ext=pathinfo($targetFile, PATHINFO_EXTENSION);
		
		//60x60
  		$filename=PartuzaConfig::get('site_root') .  $v['folder'] . '/' . $_SESSION['id'] . '.' . $ext;
  		$img=new SimpleImage();
		$img->load($filename);
 		$preview205=new SimpleImage();
 		
		if(is_numeric($v['x']) and is_numeric($v['y']) and $v['w']>0 and $v['h']>0){
			$dst_img=$img->crop($v['x'], $v['y'], $v['w'], $v['h']);
  			$preview205->createfromimage($dst_img);
  			// загрузка фото профиля thumbnail the image to 205x.. format (keeping the original)
  			/*
  			 //маленькие получаются слишком не качественные, поэтому они тоже будут 205
  			$preview60=new SimpleImage();
  			$preview60->createfromimage($dst_img);
  			$preview60->resizeAdaptive(60,60);
  			$preview60->save(PartuzaConfig::get('site_root') . '/images/people/' . $_SESSION['id'] . '.60x60.' . $ext);*/
  			//imagedestroy($dst_img);
  				
		}else{
			$preview205->load($filename);
		}

		$preview205->resizeToWidth(205);
		$fn='/images/people/' . $_SESSION['id'] . '.205x205.' . $ext;
  		$preview205->save(PartuzaConfig::get('site_root') . $fn);
		$people->set_profile_photo_big($_SESSION['id'], $fn);
  		$people->set_profile_photo($_SESSION['id'],  $fn);
	}
  	echo $_SESSION['id'] . '.205x205.' . $ext;
  		
  }
  
  public function preview($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $app_id = intval($params[3]);
    $people = $this->model('people');
    $person = isset($_SESSION['id']) ? $people->get_person($_SESSION['id'], true) : false;
    $apps = $this->model('applications');
    $application = $apps->get_application_by_id($app_id);
    $applications = isset($_SESSION['id']) ? $apps->get_person_applications($_SESSION['id']) : array();
    $messages = $this->model('messages');
   // $messages_num=$messages->get_inbox_number($_SESSION['id']);
    //'messages_num'=>$messages_num,
    
    $this->template('applications/application_preview.php', array('applications' => $applications, 'application' => $application, 'person' => $person, 'is_owner' => true,
    		//'messages_num'=>$messages_num
    ));
  }

  public function application($params) {
    $id = isset($params[3]) && is_numeric($params[3]) ? $params[3] : false;
    if (! $id || (! isset($params[4]) || ! is_numeric($params[4])) || (! isset($params[5]) || ! is_numeric($params[5]))) {
      header("Location: /");
      die();
    }
    $app_id = intval($params[4]);
    $mod_id = intval($params[5]);
    $people = $this->model('people');
    $person = $people->get_person($id, true);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $application = $apps->get_person_application($id, $app_id, $mod_id);
    //$messages = $this->model('messages');
    //$messages_num=$messages->get_inbox_number($_SESSION['id']);
    //'messages_num'=>$messages_num,
    $this->template('applications/application_canvas.php', array('application' => $application, 'person' => $person, 'friend_requests' => $friend_requests, 'friends' => $friends,
    //	'messages_num'=>$messages_num,
        'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false));
  }

  public function myapps($param) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    $id = $_SESSION['id'];
    $people = $this->model('people');
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($_SESSION['id']);
    $person = $people->get_person($id, true);
    //$messages = $this->model('messages');
    //$messages_num=$messages->get_inbox_number($_SESSION['id']);
    //'messages_num'=>$messages_num,
    $this->template('applications/applications_manage.php', array('person' => $person, 'is_owner' => true, 'applications' => $applications,
    		//'messages_num'=>$messages_num
    ));
  }

  public function appgallery($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    $id = $_SESSION['id'];
    $people = $this->model('people');
    $apps = $this->model('applications');
    $app_gallery = $apps->get_all_applications();
    $applications = $apps->get_person_applications($_SESSION['id']);
    $person = $people->get_person($id, true);
    $this->template('applications/applications_gallery.php', array('person' => $person, 'is_owner' => true, 'applications' => $applications, 'app_gallery' => $app_gallery));
  }

  public function addapp($params) {
    if (! isset($_SESSION['id']) || ! isset($_GET['appUrl'])) {
      header("Location: /");
    }
    $url = trim(urldecode($_GET['appUrl']));
    $apps = $this->model('applications');
    $ret = $apps->add_application($_SESSION['id'], $url);
    if ($ret['app_id'] && $ret['mod_id'] && ! $ret['error']) {
      // App added ok, goto app settings
      header("Location: " . PartuzaConfig::get("web_prefix") . "/profile/application/{$_SESSION['id']}/{$ret['app_id']}/{$ret['mod_id']}");
    } else {
      // Using the home controller to display the error on the person's home page
      include_once PartuzaConfig::get('controllers_root') . "/home/home.php";
      $homeController = new homeController();
      $message = "<b>Could not add application:</b><br/> {$ret['error']}";
      $homeController->index($params, $message);
    }
  }

  public function removefriend($params) {
    if (! isset($_SESSION['id']) || (! isset($params[3]) || ! is_numeric($params[3]))) {
      header("Location: /");
    }
    $friend_id = intval($params[3]);
    $people = $this->model('people');
    $people->remove_friend($_SESSION['id'], $friend_id);

  }

  public function removeapp($params) {
    if (! isset($_SESSION['id']) || (! isset($params[3]) || ! is_numeric($params[3])) || (! isset($params[4]) || ! is_numeric($params[4]))) {
      header("Location: /");
    }
    $app_id = intval($params[3]);
    $mod_id = intval($params[4]);
    $apps = $this->model('applications');
    if ($apps->remove_application($_SESSION['id'], $app_id, $mod_id)) {
      $message = 'Application removed';
    } else {
      $message = 'Could not remove application, invalid id';
    }
    header("Location: /profile/myapps");
  }

  public function appsettings($params) {
    if (! isset($_SESSION['id']) || (! isset($params[3]) || ! is_numeric($params[3])) || (! isset($params[4]) || ! is_numeric($params[4]))) {
      header("Location: /");
    }
    $app_id = intval($params[3]);
    $mod_id = intval($params[4]);
    $apps = $this->model('applications');
    $people = $this->model('people');
    $person = $people->get_person($_SESSION['id'], true);
    $friends = $people->get_friends($_SESSION['id']);
    $friend_requests = isset($_SESSION['id']) ? $people->get_friend_requests($_SESSION['id']) : array();
    $app = $apps->get_person_application($_SESSION['id'], $app_id, $mod_id);
    $applications = $apps->get_person_applications($_SESSION['id']);
    if (count($_POST)) {
      $settings = unserialize($app['settings']);
      if (is_object($settings)) {
        foreach ($_POST as $key => $value) {
          // only store if the gadget indeed knows this setting, otherwise it could be abuse..
          if (isset($settings->$key)) {
            $apps->set_application_pref($_SESSION['id'], $app_id, $key, $value);
          }
        }
      }
      header("Location: " . PartuzaConfig::get("web_prefix") . "/profile/application/{$_SESSION['id']}/$app_id/$mod_id");
      die();
    }
    $this->template('applications/application_settings.php', array('applications' => $applications, 'application' => $app, 'person' => $person, 'friend_requests' => $friend_requests, 'friends' => $friends, 'is_owner' => true));
  }
  
  public function news($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	if (isset($params[3]) and !is_numeric($params[3])) {
  		switch ($params[3]) {
  			case 'delete':
  				$this->news_delete($params[4]);
  				break;
  			case 'get':
  				$this->news_get($params[4]);
  				break;
  			case 'compose':
  				$this->news_compose();
  				break;
  			case 'send':
  				$this->news_send($params[4]);
  				break;  				
  			case 'save':
  				$this->news_save($params[4]);
  				break;  				
  			case 'remove_from':
  				$this->news_remove_from($params[4]);
  				break;  				
  		}
  	} else if(is_numeric($params[3])) {
  		$person_id=$_SESSION['id'];
  		$is_owner=0;
  		if(is_numeric($params[3])){
  			$person_id=$params[3];
  		}
  		if($_SESSION['id']==$person_id){
  			$is_owner=1;
  		}
  		
  		$people = $this->model('people');
  		$messages = $this->model('messages');                
  		$apps = $this->model('applications');
  		$applications = $apps->get_person_applications($person_id);
  		$person = $people->get_person($person_id, true);
  		
  		$friends_id=$this->get_fromid_for_news($person_id);
        $is_friendrequested = (isset($_SESSION['id']) && $_SESSION['id'] != $person_id) ? $people->is_friendrequested($person_id, $_SESSION['id']) : false;
  		$curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
  		$news = $messages->get_news($person_id,$friends_id,$curpage);
  		$pages=$messages->get_news_pages($person_id,$friends_id,$curpage);
  		
  		$is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $person_id ? true : $people->is_friend($person_id, $_SESSION['id'])) : false;
      
  		$this->template('profile/profile_news.php', array(
  				'person' => $person,
  				'applications' => $applications, 
  				'is_owner' => $is_owner,
  				'news'=>$news,
  				'is_friend' => $is_friend, 
                'is_friendrequested'=>$is_friendrequested,
  				'nextpage'=>$pages['nextpage'],
  				'totalpages'=>$pages['totalpages']));
  	}
  }
  
	//список друзей, чьи новости показавать
  protected function get_fromid_for_news($person_id){
  	$friends_id=array();
  	$friends_id[]=$person_id;
  	$people = $this->model('people');
  	 
	$friends=$people->get_friends($person_id);
  	foreach($friends as $friend){
  		$friends_id[]=$friend['id'];
  	}
  		//TODO скисок групп,магазинов,организаций...
  	return $friends_id;
  }
  
  /* добавить новость */
  public function news_send($id) {
  	
  	$anons = isset($_POST['anons']) ? $_POST['anons'] : false;
  	$title = isset($_POST['title']) ? $_POST['title'] : false;
  	//$body = isset($_POST['body']) ? trim(strip_tags($_POST['body'])) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
  	$photo = isset($_POST['photo']) ? $_POST['photo'] : '';
  	$messages = $this->model('messages');
  	
  	//id=$params[3]
  	if(isset($id) and is_numeric($id)){
  		$created = $_SERVER['REQUEST_TIME'];
  		$messages->save($id, array('title'=>$title, 'anons'=>$anons, 'body'=>$body, 'photo'=> $photo, 'from'=>$_SESSION['id'], 'status'=>'new', 'created'=>$created, 'updated'=>$created));
  	}else{
	  	$messages->send_news($_SESSION['id'], array('title'=>$title, 'anons'=>$anons, 'body'=>$body, 'photo'=> $photo));
  	}
  }

  /* save новость */
  public function news_save($id) {
  	$anons = isset($_POST['anons']) ? $_POST['anons'] : false;
  	$title = isset($_POST['title']) ? $_POST['title'] : false;
  	//$body = isset($_POST['body']) ? trim(strip_tags($_POST['body'])) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
  	$photo = isset($_POST['photo']) ? $_POST['photo'] : '';
  	$messages = $this->model('messages');
  	 
  	//id=$params[3]
  	if(isset($id) and is_numeric($id)){
  		$created = $_SERVER['REQUEST_TIME'];
  		$messages->save($id, array('title'=>$title, 'anons'=>$anons, 'body'=>$body, 'photo'=> $photo, 'from'=>$_SESSION['id'], 'status'=>'new', 'updated'=>$created));
  	}
  }
  
  /* удалить свою новость */
  public function news_remove_from($id) {
  	 
  	if(!isset($id) or !is_numeric($id) or !isset($_SESSION['id'])){
  		return 0;
  	}
  	
   	 $messages = $this->model('messages');
   	 $messages->delete_message($id);
  	 $this->template('/profile/news_deleted.php', array('news_id' => $id));
  }
  
  //создать сообщение, чтобы можно было прикреплять файлы
  public function prepare_new_message(){
  	$type= isset($_GET['type']) ? $_GET['type'] : false;
  	
  	if (! $_SESSION['id']) {
  		return 0;
  	}
  	
  	$messages = $this->model('messages');  	 
  	$id = $messages->prepare_new_message($_SESSION['id'], array('type'=>$type, 'from'=>$_SESSION['id'], 'status'=>'deleted'));
	if (!$id) {
		die('Error preparing_new_message');
	}
  		 
  	if($type=="news"){
		$this->template('/profile/news_compose.php', array('news_id' => $id,
			"object_id"=>$id,
			"object_name"=>"message"));
		return;
	}
  	if($type=="private_message"){
  		$people = $this->model("people");
		$this->template('/profile/message_compose.php', array('message_id' => $id,
			"friends"=>$people->get_friends($_SESSION['id']),
			"object_id"=>$id,
			"object_name"=>"message"));
		return;
	}
  }

  //подготовить к редактированию новость
  public function prepare_edit_message(){
  	$type = isset($_GET['type']) ? $_GET['type'] : false;
  	$id = isset($_GET['id']) ? $_GET['id'] : 0;
  	 
  	if (! $_SESSION['id'] and $id) {
  		return 0;
  	}
  	 
  	$messages = $this->model('messages');
  	$this->template('/profile/news_edit_dialog.php', array(
  			'news_id' => $id, 
  			'object_id' => $id, 
  			'object_name' => "messages", 
  			'news'=> $messages->show($id)));
  }
  
  public function message_file_upload($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	$person_id = $_SESSION['id'];
  	 
  	if (! isset($params[3]) || ! is_numeric($params[3])) {  		
  		header("Location: /");
  	}
  	
  	$people = $this->model('people');
  
  	// it's upload file path.
  	$message_id = $params[3];
  	$tmp_dir = array('/files', '/messages', '/'.$message_id);
  	$dir = '/files/messages/'.$message_id;
  	$file_dir = PartuzaConfig::get('site_root');
  	foreach($tmp_dir as $val) {
  		$file_dir .= $val;
  		if (!file_exists($file_dir)) {
  			if (!@mkdir($file_dir, 0777, true)) {
  				die;
  			}
  		}
  	}
  
  	$message = '';
  	$people = $this->model('people');
  	$filewebname="1";
  	
  	//сохранить файл
  	if (!empty($_FILES)) {
  		$tempFile = $_FILES['Filedata']['tmp_name'];
  		$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
  		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
  		$fileParts  = pathinfo($_FILES['Filedata']['name']);
  
//		if (in_array($fileParts['extension'],$this->fileTypes)) {
  			$title = (!empty($_POST['title'])) ? $_POST['title'] : substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
  			$media = $this->model('medias');
  			$media_item = array(
  					'message_id' => $message_id,
  					'owner_id' => $person_id,
  					'object_name' =>"messages",  						
  					'mime_type' => '',
  					'title' => $title,
  					//'file_size' => $fileParts['size'],
  					'created' => time(),
  					'last_updated' => time(),
  					'type' => 'FILE',
  					'url' => '',
  					'app_id' => 0,
  			);
  				
  			try {
  				$media_id = $media->add_media($media_item);
  				
  			} catch (DBException $e) {
  				echo "die";
  				die();
  			}
  
  			$ext = strtolower($fileParts['extension']);
  			$utils=new Utils();
  			$filewebname=$dir . '/' . $utils->rus2translit($title) . '.' . $ext;
  			$filename=PartuzaConfig::get('site_root') .$filewebname; 
  			
  			// it's a file extention that we accept too (not that means anything really)
  			if (! move_uploaded_file($tempFile, $filename)) {
  				die("no permission to images/people dir, or possible file upload attack, aborting");
  			}
  			
  			echo $filewebname;
  				
  			// if insert data failed, throw an error.
  			// insert and upload file is success.
  			$media_item = array();
  			
  			$size = GetImageSize($filename);
  			$media_item['width']=$size[0];
  			$media_item['height']=$size[1];
  				
  			$media_item['url'] = $filewebname;
  			$media_item['thumbnail_url'] = '';
  			$media_item['thumbnail_url600']='';
  			$media_id = $media->update_media($media_id, $media_item);
  			
// 		}//if
  	}
  }
  
  /*загрузка фотографий к сообщению/новости
   * $params[3] == message_id
   * */
  public function message_photo_upload($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	$person_id = $_SESSION['id'];
  	 
  	if (! isset($params[3]) || ! is_numeric($params[3])) {
  		header("Location: /");
  	}
  	$people = $this->model('people');
  	//$person = $people->get_person_fields($_SESSION['id'], array('uploaded_size'));
  
  	// it's upload file path.
  	$message_id = $params[3];
  	$tmp_dir = array('/images', '/messages', '/'.$message_id);
  	$dir = '/images/messages/'.$message_id;
  	$file_dir = PartuzaConfig::get('site_root');
  	foreach($tmp_dir as $val) {
  		$file_dir .= $val;
  		if (!file_exists($file_dir)) {
  			if (!@mkdir($file_dir, 0777, true)) {
  				die;
  			}
  		}
  	}
  
  	$message = '';
  	$people = $this->model('people');
  	$filewebname="1";
  	 
  	//сохранить картинку
  	if (!empty($_FILES)) {
  		$tempFile = $_FILES['Filedata']['tmp_name'];
  		$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
  		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
  		$fileParts  = pathinfo($_FILES['Filedata']['name']);
  
  		if (in_array($fileParts['extension'],$this->imageTypes)) {
  			$title = (!empty($_POST['title'])) ? $_POST['title'] : substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
  			$media = $this->model('medias');
  			$media_item = array(
  					'message_id' => $message_id,
  					'owner_id' => $person_id,
  					'object_name' =>"messages",  						
  					'mime_type' => '',
  					'title' => $title,
  					//'file_size' => $fileParts['size'],
  					'created' => time(),
  					'last_updated' => time(),
  					'type' => 'IMAGE',
  					'url' => '',
  					'app_id' => 0,
  			);
  			try {
  				$media_id = $media->add_media($media_item);
  			} catch (DBException $e) {
  				echo "die";
  				die();
  			}
  
  			$ext = strtolower($fileParts['extension']);
  			$filename=PartuzaConfig::get('site_root') . $dir . '/' . $media_id . '.' . $ext;
  			// it's a file extention that we accept too (not that means anything really)
  			if (! move_uploaded_file($tempFile, $filename)) {
  				die("no permission to images/people dir, or possible file upload attack, aborting");
  			}
  				
  			//уменьшить до максимально допустимого размера
  			$img=new SimpleImage();
  			$img->load($filename);
  			$img->save($filename);
  			//$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
  			$filename_thumbnail600=$dir . '/' . $media_id . '.600x600.' . $ext;
  			$img->save(PartuzaConfig::get('site_root') . $filename_thumbnail600);
  			//$img->resizeAdaptive(220, 220);
  			$filename_thumbnail220=$dir . '/' . $media_id . '.220x220.' . $ext;
  			$img->save(PartuzaConfig::get('site_root') . $filename_thumbnail220);
  
  			echo $filename_thumbnail220;
  				
  			// if insert data failed, throw an error.
  			// insert and upload file is success.
  			$media_item = array();
  			
  			$size = GetImageSize($filename);
  			$media_item['width']=$size[0];
  			$media_item['height']=$size[1];
  				
  			$media_item['url'] = $filewebname;
  			$media_item['thumbnail_url'] = $filename_thumbnail220;
  			$media_id = $media->update_media($media_id, $media_item);
  			
  			//$person = $people->literal_set_person_fields($params[3], array('uploaded_size' => "uploaded_size + {$file['size']}"));
  			$media_item['thumbnail_url600']=$filename_thumbnail600;
  			$media_id = $media->update_media($media_id, $media_item);
  			
  			//TODO: 1) отправить имя картинки 2)?залить несколько картинок
  			//echo $media_item['thumbnail_url600'];
  		}
  	}
  }
  
  /* показать новость подробно */
  public function news_get($id) {
  	if (! $_SESSION['id']) {
  		header("Location: " . PartuzaConfig::get('web_prefix') . "/");
  		die();
  	}
  	
  	if (!$id) {
  		die('This is not the news your looking for');
  	}

  	$messages = $this->model('messages');
  	$message = $messages->get_new($id,'news');
  	if (isset($messag['status']) && $message['status'] == 'new') {
  		$message->mark_read($messageId);
  		//TODO:для этого пользователя read
  	}
  	$person_id=$message['from'];
  	
  	$people = $this->model('people');
  	$person = $people->get_person($person_id, true);
  	$activities = $this->model('activities');
  	$friends = $people->get_friends($id);
  	$friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $person_id ? $people->get_friend_requests($person_id) : array();
    $is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $person_id ? true : $people->is_friend($person_id, $_SESSION['id'])) : false;
  	$apps = $this->model('applications');
  	$applications = $apps->get_person_applications($person_id);
  	$person_apps = null;
  	if (isset($_SESSION['id']) && $_SESSION['id'] != $person_id) {
  		$person_apps = $apps->get_person_applications($person_id);
  	}
  	
  	$this->template('/profile/profile_show_news.php', array('news' => $message, 'news_id' => $id, 'messageType' => "news",
  			//'activities' => $person_activities, 
  			'applications' => $applications, 'person' => $person, 'friend_requests' => $friend_requests, 'friends' => $friends,
      //'messages_num'=>$messages_num,
      		'is_friend' => $is_friend, 
      		'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $person_id) : false, 
  			'person_apps' => $person_apps));
  }

  /* поменять язык */
  public function lang($params) {
  	if ( !$params[3]) {
  		header("Location: /");
  		die();
  	}
  	$lang=$params[3];
  	if (in_array($lang,PartuzaConfig::get('languages'))){
	  	$_SESSION['lang']=$lang;
	  	
	  	if($_SESSION['id']){
  			$people = $this->model('people');
	  		$people->save_person($_SESSION['id'], array('lang'=>$lang));
	  	}
  	}
  	
  	if($_SERVER['HTTP_REFERER'] and !preg_match("search",$_SERVER['HTTP_REFERER'])){
    	header ("Location: ".$_SERVER['HTTP_REFERER']);
    	return;
    }
  	header("Location: /");
  }
  
  
  /* поменять валюту */
  public function cur($params) {
  	if ( !$params[3]) {
  		header("Location: /");
  		die();
  	}
  	$cur=$params[3];
  	if (in_array($cur,array(1,2,3,4))){
  		$_SESSION['cur']=$cur;
  
  		if($_SESSION['id']){
  			$people = $this->model('people');
  			$people->save_person($_SESSION['id'], array('currency_id'=>$cur));
  		}
  	}
    
    if($_SERVER['HTTP_REFERER']){
    	header ("Location: ".$_SERVER['HTTP_REFERER']);
    	return;
    }
  	header("Location: /");
  }

  /* подтверждение к электронного ящика */
  public function activate($params) {
  	if ( !$_GET['code']) {
  		header("Location: /");
  		die();
  	}
  	$activation_code=$_GET['code'];
  	$people = $this->model('people');
	$this->template('/profile/activated.php', array('is_activated' =>$people->activate($activation_code)));
  }
  

  /* забыл пароль */
  public function forgot($params) {
  	if(isset($_GET['email'])){
  		$is_send=0;
  		$people = $this->model('people');
  		$person_info=$people->forgot_email($_GET['email']);

  		//отправить email
  		if(isset($person_info['id']) and $person_info['id']>0){
  			$is_send=1;
  			global $mail;
  			$message=$this->get_template("/profile/mail/forgot.php",
  					array("person"=>$person_info));

  			$mail->send_mail(array(
  					"from"=>PartuzaConfig::get('mail_from'),
  					"to"=>$person_info['email'],
  					"title"=>$this->t("common", "Password restore"),
  					"body"=>$message
  			));
  		}
  		
  		$this->template('/profile/forgot.php', array("is_send"=>$is_send,
  													 "person"=>$person_info,
  													 "email"=>$_GET['email']));
  		return;
  	}

	$this->template('/profile/forgot.php');
  }


  /* забыл пароль AJAX */
  public function forgotAJAX($params) {
    

    if(isset($_POST['email'])){
      $is_send=0;
      $people = $this->model('people');
      $person_info=$people->forgot_email($_POST['email']);

//echo var_dump($person_info);
      //отправить email
      if(isset($person_info['id']) and $person_info['id']>0){
        $is_send=1;
        global $mail;
        $message=$this->get_template("/profile/mail/forgot.php",
            array("person"=>$person_info));

        $mail->send_mail(array(
            "from"=>PartuzaConfig::get('mail_from'),
            "to"=>$person_info['email'],
            "title"=>$this->t("common", "Password restore"),
            "body"=>$message
        ));
      }

     echo $is_send;
      return;
    }
  echo $is_send;
  return;
  }
  
  /* поменять пароль по коду */
  public function changepassword($params) {
  	if(isset($_GET['code'])){
  		$people = $this->model('people');
  		$person_info=$people->get_person_from_paswordcode($_GET['code']);    
  		$this->template('/profile/changepassword.php', array(
  				"person"=>$person_info,
  				"code"=>$_GET['code'],
  				));
  		return;
  	}
  }
  
  /* поменять пароль по коду */
  public function setnewpassword($params) {
  	$error="";
  	$is_error=0;
  	//загрузить сообщения об ошибках
  	$this->loadMessages($this->get_cur_lang());
  	 
    if (empty($_POST['register_password']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_password").'<br>';
    }
    if (empty($_POST['register_password2']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_password2").'<br>';
    }
    if ($_POST['register_password2']!=$_POST['register_password'] ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_password_dont_match").'<br>';
    }
    if(!isset($_POST['code'])){
    	$is_error=1;
    	$error .= $this->t("common","form_error_unknown").'<br>';
    }

    $people = $this->model('people');
    $person_info=$people->get_person_from_paswordcode($_POST['code']);
    
    $is_done=false;
    if(!$is_error){
		$is_done=$people->set_new_password(array("code"=>$_POST['code'],
  										"password"=>$_POST['register_password']));
		if(!$is_done){
			$error .=$this->t("common","form_error_unknown").'<br>';
		}
    }

    if($is_error or !$is_done){
    	$this->template('/profile/changepassword.php', array(
    			"person"=>$person_info,
    			"error"=>$error,
    			"code"=>$_POST['code'],
    			"is_error"=>1));
    	return;
    }
    
	$this->template('/profile/donepassword.php', array(
    			"person"=>$person_info,
    			"error"=>$error,
    			"is_error"=>1));
    	return;
  }
  

  /* выбрать текущую страну */
  public function country_content($params) {
  	if ( !$params[3]) {
  		header("Location: /");
  		die();
  	}
  	$code2=$params[3];
  	$country_content=$this->model('country_content');
  	$code2s=$country_content->get_code2s();
  	if (in_array($code2,$code2s)){
	  	$_SESSION['country_content_code2']=$code2;
	  	
	  	if($_SESSION['id']){
  			$people = $this->model('people');
	  		$people->save_person($_SESSION['id'], array('country_content_code2'=>$code2));
	  	}
  	}

  	header("Location: /");
  }


  /* add/edit/delete education */
  public function education($params) {
	if (! isset($_SESSION['id'])) {
		header("Location: /");
	}
	if (isset($params[3])) {
		switch ($params[3]) {
			case 'add':
				$this->education_add($params[4]);
				break;
			case 'edit':
				$this->education_edit($params[4]);
				break;
			case 'delete':
				$this->education_delete($params[4]);
				break;
			case 'get':
				if(isset($params[4])){
					$this->education_get($params[4]);
				}else{
					$this->education_get();
				}
				break;
			case 'get_addform':
				$this->education_get_addform($params[4]);
				break;	
		}
	}
  }


  /* добавить запись об образовании */
  public function education_add($id) {
  	if(!isset($id) or !is_numeric($id)){
  		return;
  	}
  		 
  	$edu = $this->model('education');
  	
	//$created = $_SERVER['REQUEST_TIME'];
	$name = isset($_POST['name']) ? $_POST['name'] : false;
	$from = isset($_POST['from']) ? $_POST['from'] : false;
	$to = isset($_POST['to']) ? $_POST['to'] : false;
	$type = isset($_POST['type']) ? $_POST['type'] : false;
	$country = isset($_POST['country']) ? $_POST['country'] : false;
	$city = isset($_POST['city']) ? $_POST['city'] : false;
	$class = isset($_POST['class']) ? $_POST['class'] : false;
	
	$id=$edu->add(array(
			'person_id'=>$id,
			'name'=>$name, 
			'type'=>$type, 
			'city'=>$city, 
			'country'=>$country,
			'class'=>$class,
			'from'=>$from,
			'to'=>$to,
			));
	print $id;
  }
  
  /* удалить свою запись об образовании */
  public function education_delete($id) {
  
  	if(!isset($id) or !is_numeric($id) or !isset($_SESSION['id'])){
  		return 0;
  	}
  	 
  	$edu = $this->model('education');
  	$edu->delete($id);

  	return $this->education_get($_SESSION['id']);
  	//$this->template('/profile/news_deleted.php', array('news_id' => $id));
  }

  public function education_get($id=null) {
  
  	if(!isset($id)){
  		$id=$_SESSION['id'];
  	}
  	if(!is_numeric($id) or !isset($_SESSION['id'])){
  		return 0;
  	}
  
    $edu = $this->model('education');
    $education['school'] = $edu->show(array("person_id"=>$id, "type"=>"1school"));
    $education['college'] = $edu->show(array("person_id"=>$id, "type"=>"2college"));
    $education['univer'] = $edu->show(array("person_id"=>$id, "type"=>"3univer"));
  	 
  	$this->template('/profile/profile_educationlist.php', array('education' => $education,
  			'is_owner'=>($_SESSION['id']==$id?1:0)));
  }
  
  /* save education */
  public function education_edit($id) {
  
  	if(!isset($id) or !is_numeric($id) or !isset($_SESSION['id'])){
  		return 0;
  	}
  
  	$edu = $this->model('education');
  	
  	$name = isset($_POST['name']) ? $_POST['name'] : false;
  	$from = isset($_POST['from']) ? $_POST['from'] : false;
  	$to = isset($_POST['to']) ? $_POST['to'] : false;
  	$type = isset($_POST['type']) ? $_POST['type'] : false;
  	$country = isset($_POST['country']) ? $_POST['country'] : false;
  	$city = isset($_POST['city']) ? $_POST['city'] : false;
  	$class = isset($_POST['class']) ? $_POST['class'] : false;
  	
  	$edu->save($id,array(
  			'name'=>$name,
  			'type'=>$type,
  			'city'=>$city,
  			'country'=>$country,
  			'class'=>$class,
  			'from'=>$from,
  			'to'=>$to,
	  	));
  
  	return $id;
  	//return $this->education_get($_SESSION['id']);
  }
  
  //показать форму для добавления образования
  public function education_get_addform($type){
  	if(!isset($_SESSION['id']) or !isset($type) or !$type ){
  		return 0;
  	}
  	
  	$this->template('/profile/profile_education_addform.php', array('type'=>$type));
  }
  
  /* заглушка для видео */
  public function video($params) {
  	if ( !$_SESSION['id'] or !isset($params[3])) {
  		header("Location: /");
  		die();
  	}

  	$id=$params[3];
  	$people = $this->model('people');
  	$person = $people->get_person($id, true);
  	$is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $id ? true : $people->is_friend($id, $_SESSION['id'])) : false;
  	 
  	$this->template('/profile/profile_video.php', array(
  			  			'person' => $person,
  						'is_friend' => $is_friend, 
  						'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false,
  				));
  }
  
  /* заглушка для календаря */
  public function calendar($params) {
  	if ( !$_SESSION['id'] or !isset($params[3])) {
  		header("Location: /");
  		die();
  	}
  
  	$id=$params[3];
  	$people = $this->model('people');
  	$person = $people->get_person($id, true);
  	$is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $id ? true : $people->is_friend($id, $_SESSION['id'])) : false;
  
  	$this->template('/profile/profile_calendar.php', array(
  			'person' => $person,
  			'is_friend' => $is_friend,
  			'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false,
  	));
  }


  /* заглушка для магазина */
  public function myshop($params) {
  	if ( !$_SESSION['id']) {
  		header("Location: /");
  		die();
  	}
  
  	$id=$_SESSION['id'];
  	$people = $this->model('people');
  	$person = $people->get_person($id, true);
  
  	$this->template('/profile/profile_myshop.php', array(
  			'person' => $person,
  			'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false,
  	));
  }

  /* заглушка для магазина */
  public function central($params) {
  	if ( !$_SESSION['id']) {
  		header("Location: /");
  		die();
  	}
  
  	$id=$_SESSION['id'];
  	$people = $this->model('people');
  	$person = $people->get_person($id, true);
  
  	$this->template('/profile/profile_central.php', array(
  			'person' => $person,
  			'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false,
  	));
  }

  /* скопировать папки */
  function _sync_folder($srcdir, $dstdir, $forced = false)
  {
  	$sizetotal = 0;
  	$num=0;
  	
  	if(!$srcdir or !$dstdir) return false;
  
  	/*$srcdir=PartuzaConfig::get('site_root').$srcdir;
  	$dstdir=PartuzaConfig::get('site_root').$dstdir;*/
  	
  	if(!is_dir($dstdir)) mkdir($dstdir);
  	if($curdir = opendir($srcdir)) {
  		while($file = readdir($curdir)) {
  			if($file != '.' && $file != '..') {
  				$srcfile = $srcdir . '/' . $file;
  				$dstfile = $dstdir . '/' . $file;
  
  				if(is_file($srcfile)) {
  
  					if(is_file($dstfile))
  						$ow = filemtime($srcfile) -
  						filemtime($dstfile);
  					else $ow = 1;
  
  					if($ow > 0 || $forced) {
  						//echo "Копирую '$srcfile' в '$dstfile'...";
  
  						if(copy($srcfile, $dstfile)) {

  							touch($dstfile, filemtime($srcfile)); $num++;
  
  							chmod($dstfile, 0777);
  							$sizetotal =($sizetotal + filesize($dstfile));
  						}
  						else {
  						/*echo "Ошибка: Не могу ".
  						"скопировать файл '$srcfile'! <br />\n";*/
            			}
  					}
  				}
  			}
  		}
  		closedir($curdir);
  	}
	return true;
  }
  
  public function orders($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  		die();
  	}
  	if (isset($params[3]) and !is_numeric($params[3])) {
  		/*if($_SESSION['id']!=$params[4]){
  			header("Location: /");
  			die();
  		}*/
  		switch ($params[3]) {
  			case 'archive':
  				$this->order_archive($params[4]);
  				$this->order_search();
  				break;
  			case 'unarchive':
  				$this->order_unarchive($params[4]);
  				$this->order_search();
  				break;
  			case 'deny':
  				$this->order_deny($params[4]);
  				$this->order_search();
  				break;
  			case 'get':
  				$this->order_get($params[4]);
  				break;
  			case 'pay':
  				$this->order_pay($params[4]);
  				break;
				case 'delivered':
					$this->order_delivered($params[4]);
					break;
  			
  			/*case 'save':
  				$this->order_save($params[4]);
  				break;*/
  		}
  	} else {
  		if(is_numeric($params[3]) and $_SESSION['id']!=$params[3]){
  			header("Location: /");
  			die();
  		}
  		if(!$params[3]){
  			$params[3] = $_SESSION['id'];
  		}
  		
  		//отметить оплату
  		if(isset($_REQUEST['sb_ok']) and is_numeric($_REQUEST['sb_ok'])){
  		    $order = $this->model('order');
  		    $order->save($_REQUEST['sb_ok'], array('ispayed' => 1));
  		    header("Location: /profile/orders/".$_SESSION['id']);	
  		}
  		$this->order_search($params[3]);
  		
  		
  	}
  }
  
	//заказ доставлен
  public function order_delivered($id) {
  	$person_id=$_SESSION['id'];
  	$order = $this->model('order');
  	if(isset($id) and is_numeric($id)){
  		$order->save($id, array(
  				'orderstatus_id'=>3,
  		));
  	}
  }

  //оплатить заказ
  public function order_pay($id) {
  	$person_id=$_SESSION['id'];
  	$order = $this->model('order');
  	if(isset($id) and is_numeric($id)){
	    $this->_order_pay_sb($id);
  	}
  }
  
  //отменить заказ
  public function order_deny($id) {
  	$person_id=$_SESSION['id'];
  	//$comment_person = isset($_POST['comment_person']) ? trim(strip_tags($_POST['comment_person'])) : '';
  	$order = $this->model('order');
  	if(isset($id) and is_numeric($id)){
  		//$created = $_SERVER['REQUEST_TIME'];
  		$order->save($id, array(
  				'orderstatus_id'=>5,
  				// 'comment_person'=> $comment_person
  		));
  	}
  }
  
  //заказ в архив
  public function order_archive($id) {
  	$person_id=$_SESSION['id'];
  	//$comment_person = isset($_POST['comment_person']) ? trim(strip_tags($_POST['comment_person'])) : '';
  	$order = $this->model('order');
  	if(isset($id) and is_numeric($id)){
  		//$created = $_SERVER['REQUEST_TIME'];
  		$order->save($id, array(
  				'isuserarchive'=>1,
  				// 'comment_person'=> $comment_person
  		));
  	}
  }
  
  
  //убрать заказ из архива
  public function order_unarchive($id) {
  	$person_id=$_SESSION['id'];
  	//$comment_person = isset($_POST['comment_person']) ? trim(strip_tags($_POST['comment_person'])) : '';
  	$order = $this->model('order');
  	if(isset($id) and is_numeric($id)){
  		//$created = $_SERVER['REQUEST_TIME'];
  		$order->save($id, array(
  				'isuserarchive'=>0,
  				// 'comment_person'=> $comment_person
  		));
  	}
  }
  
  /* список заказов */
  public function order_search($id=0) {
  	$person_id=$_SESSION['id'];
  	$is_owner=0;
  	if(is_numeric($id) and $id>0){
  		$person_id=$id;
  	}
  	if($_SESSION['id']==$person_id){
  		$is_owner=1;
  	}
  	
  	$people = $this->model('people');
  	$apps = $this->model('applications');
  	$applications = $apps->get_person_applications($person_id);
  	$person = $people->get_person($person_id, true);
  	
  	$order = $this->model('order');
  	
  	//фильтр
  	$curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
  	
  	$fromdate=null;
  	$todate=(isset($_REQUEST['todate']))?$_REQUEST['todate']:null;
  	
  	//$orderstatus_id=(isset($_REQUEST['orderstatus_id']))?$_REQUEST['orderstatus_id']:null;
  	$orderstatus_id=null;
  	if(isset($_REQUEST['orderstatus_id'])){
  		$orderstatus_id=(is_numeric($_REQUEST['orderstatus_id']))?$_REQUEST['orderstatus_id']:null;
  		preg_match("/(\d+)_(\d+)/", $_REQUEST['orderstatus_id'], $res);
 
  		if(isset($res[1]) and isset($res[2])){
  			$orderstatus_id=array($res[2], $res[1]);
  		}
  	}
  	
  	if(isset($_REQUEST['fromdate'])){
  		$fromdate = isset($_REQUEST['fromdate']) ? trim(strip_tags($_REQUEST['fromdate'])) : '';
  		preg_match("/(\d+)\.(\d+)\.(\d+)/", $fromdate, $res);
  	
  		if(isset($res[1]) and isset($res[2]) and isset($res[3])){
  			$fromdate=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
  			$_REQUEST['fromdate']=$fromdate;
  		}
  	}
  	
  	if(isset($_REQUEST['todate'])){
  		$todate = isset($_REQUEST['todate']) ? trim(strip_tags($_REQUEST['todate'])) : '';
  		preg_match("/(\d+)\.(\d+)\.(\d+)/", $todate, $res);
  	
  		if(isset($res[1]) and isset($res[2]) and isset($res[3])){
  			$todate=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
  			$_REQUEST['todate']=$todate;
  		}
  	}
  	
  	$shop_id=(isset($_REQUEST['shop_id']))?$_REQUEST['shop_id']:null;
  	 	
  	$filter=array(
  			'person_id'=>$person_id,
  			'shop_id'=>$shop_id,
  			'curpage'=>$curpage,
  			'fromdate'=>$fromdate,
  			'todate'=>$todate,
  			'orderstatus_id'=>$orderstatus_id,
  	);
  	
  	$orders = $order->get_orders($filter);
  	$pages=$order->get_order_pages($filter);
  	
  	$this->template('profile/profile_orders.php', array(
  			'person' => $person,
  			'sb_fail' => (isset($_REQUEST['sb_fail'])? true : false),
  			'applications' => $applications,
  			'orderstatuses' => $order->get_statuses(),
  			'shops' => $order->get_shops($person_id),
  			'searchorder'=>$_REQUEST,
  			'is_owner' => $is_owner,
  			'orders'=>$orders,
  			'nextpage'=>$pages['nextpage'],
  			'totalpages'=>$pages['totalpages']));
  }
  
  
  /* показать заказ подробно */
  public function order_get($id) {
  	if (!$_SESSION['id'] || !$id) {
  		header("Location: /");
  		die();
  	}
  	
  	$person_id = $_SESSION['id'];
  	 
  	$order = $this->model('order');
  	$my_order = $order->get_order($id,$person_id, null);
  	 
  	$people = $this->model('people');
  	//$person = $people->get_person($person_id, true);
  	
  	//$apps = $this->model('applications');
  	//$applications = $apps->get_person_applications($person_id);
  	 
  	 
  	$this->template('profile/profile_order_detail.php', 
  			array(
  				'person' => $person,
  		//		'applications' => $applications,
  				'is_owner' => true,
  				'order'=>$my_order,
  				'orders'=>array($my_order),
  			));
  }

public function _order_pay_sb($order_id) {
	//echo $order_id." !";
	//проверка 1
	if (! $_SESSION['id']) {
		return;
	}

	// проверка - мой ли заказ
	$order = $this->model('order');
	$myorder = $order->show($order_id, false);
	//echo var_dump($myorder);
	if ($_SESSION['id'] != $myorder['person_id']) {
		return;
	}

	//проверка валюты - только рубли
	if($myorder['currency_id'] != 2){
		return;
	}
	//echo var_dump($myorder);
	        function get_amount($orderBundle,$myorder){
                $itemPrice = 0;
                foreach($orderBundle as $order){
                        foreach($order as $keys){
                                foreach($keys as $key){
                                        $itemPrice += $key["itemPrice"]*$key['quantity']['value'];
                                }
                        }
                }
                return intval($itemPrice);
        }
	// оплата
	function pay($order, $myorder, $order_id, $num){
		require_once PartuzaConfig::get('library_root').'/REST.php';
		$res = runREST(PartuzaConfig::get("sb_register"), "POST", array(
			"userName"=>PartuzaConfig::get("sb_login"),
			"password"=>PartuzaConfig::get("sb_password"),
			"orderNumber"=>$order,
			"amount"      => get_amount($orderBundle,$myorder),
			"returnUrl" => "http://comiron.com/profile/orders/".$_SESSION['id']."?sb_ok=$order_id",
			"failUrl" =>  "http://comiron.com/profile/orders/".$_SESSION['id']."?sb_fail=1",
			"description" => "Оплата на сайте comiron.com Server.comiron.com",
		) );
		$res = json_decode ($res, true);
		
		if($res['errorCode'] == 1){
			$num++;
			return pay($order_id."_".$num, $myorder, $order_id, $num);
		}
		return $res;
	}
	
	$res = pay($order_id, $myorder, $order_id,1);
	
	//echo "php: " .var_dump($res);
	if($res['formUrl']){
		//$order->save($order_id, array('ispayed'=>1)); // отметить оплату
		header("Location: ".$res['formUrl']);
		exit();
	}
}

}
