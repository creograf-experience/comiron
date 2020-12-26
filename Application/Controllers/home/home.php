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

class homeController extends baseController {

  public function index($params, $message = false) {
      
    if (isset($_SESSION['id'])) {
      
/*    	
      $people = $this->model('people');
      $apps = $this->model('applications');
      $activities = $this->model('activities');
      $messages = $this->model('messages');
      $messages_num=$messages->get_inbox_number($_SESSION['id']);
      $person = $people->get_person($_SESSION['id'], true);
      $friends = $people->get_friends($_SESSION['id']);
      $friend_requests = $people->get_friend_requests($_SESSION['id']);
      $applications = $apps->get_person_applications($_SESSION['id']);
      $friend_activities = $activities->get_friend_activities($_SESSION['id'], 10);
      //TODO add activities here and parse in template..
      $this->template('profile/home.php', array(
          'activities' => $friend_activities, 'applications' => $applications,
          'person' => $person, 'friend_requests' => $friend_requests,
          'friends' => $friends, 'is_owner' => true, 'error_message' => $message,
      		'messages_num'=>$messages_num));
*/
    	//if (file_exists(PartuzaConfig::get('controllers_root') . "/profile/profile.php")) {
    	include_once PartuzaConfig::get('controllers_root') . "/profile/profile.php";
    	$profile = new profileController($params);
    	return $profile->index(array("","profile",$_SESSION['id']));
    	//}
    
    	//$controller->$params[2]($params);
    } else {
    	//список стран, к которым может относиться контент
    	$country_content = $this->model('country_content');
    	
    	$this->template('home/home.php',
    			array('countries'=>$country_content->get_countries($this->get_cur_lang())
    			));
    }
  }

  public function removefriend($params) {
  	//загрузить сообщения 
  	$this->loadMessages($this->get_cur_lang());
  	 
    $message = $this->t('profile','Friend removed');
    $people = $this->model('people');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])) {
      $people->remove_friend($_SESSION['id'], $params[3]);
    } else {
      $message = $this->t('profile','Could not remove friend request');
    }
    $_SESSION['message'] = $message;
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  public function removeshop($params) {
  	//загрузить сообщения 
  	$this->loadMessages($this->get_cur_lang());
  	 
    $message = $this->t('profile','Client removed');
    $people = $this->model('people');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])) {
      $people->remove_client($_SESSION['id'], $params[3]);
    } else {
      $message = $this->t('profile','Could not remove client request');
    }
    $_SESSION['message'] = $message;
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }
  
  public function addfriend($params) {
  	$this->loadMessages($this->get_cur_lang());
  	 
    $message = '';
    $people = $this->model('people');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])) {
      if ($people->add_friend_request($_SESSION['id'], $params[3])) {
        $info = $people->get_person_info($params[3]);
        
        $message =  $this->t('profile','Send friend request');
      } else {
        $message = $this->t('profile', 'Could not send friend request, request already pending');
      }
    } else {
      $message = $this->t('profile', 'Could not send friend request, invalid friend id');
    }
    $_SESSION['message'] = $message;
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  public function acceptfriend($params) {
  	$this->loadMessages($this->get_cur_lang());
  	 
    $message = '';
    $people = $this->model('people');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])) {
      $people = $this->model('people');
      if ($people->accept_friend_request($_SESSION['id'], $params[3])) {
        $message = $this->t('profile','Friend request accepted');
      } else {
        $message = $this->t('profile','Could not accept friend request');
      }
    } else {
      $message = $this->t('profile','Could not accept friend request');
    }
    $_SESSION['message'] = $message;
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  public function rejectfriend($params) {
  	$this->loadMessages($this->get_cur_lang());
  	 
    $message = '';
    $people = $this->model('people');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])) {
      $people = $this->model('people');
      if ($people->reject_friend_request($_SESSION['id'], $params[3])) {
        $message =  $this->t('profile','Friend request removed');
      } else {
        $message =  $this->t('profile','Could not remove friend request');
      }
    } else {
      $message =  $this->t('profile','Could not remove friend request');
    }
    $_SESSION['message'] = $message;
    header("Location: {$_SERVER['HTTP_REFERER']}");
  }
}