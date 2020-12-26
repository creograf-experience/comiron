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

class searchController extends baseController {

  public function index($params) {
    $error = false;
    $results = array();
    $friends = array();
    $people = $this->model('people');
    $shop = $this->model('shop');
    $apps = $this->model('applications');
    $person = $people->get_person($_SESSION['id'], true);
    $activities = $this->model('activities');
   	//$person_apps = $apps->get_person_applications($_SESSION['id']);
    //$messages = $this->model('messages');
   //	$messages_num=$messages->get_inbox_number($_SESSION['id']);

    $cart = $this->model('cart');
    //'messages_num'=>$messages_num,

    $curpage=(isset($_GET['curpage']) and is_numeric($_GET['curpage']) and $_GET['curpage']>0)?$_GET['curpage']:0;
    $ret=array();
    if (!empty($_GET['q']) and !empty($_GET['for'])) {
    	switch ($_GET['for']) {
        case 'people':
    			 //$friends = $people->get_friends($_SESSION['id']);//TODO: сначала поискать по друзьям
    			 $ret = $people->search($_GET['q'],$curpage);
    			 break;
        case 'shop':
       			 $ret = $shop->search($_GET['q'],$curpage,["isprice"=>true]);
       			 break;
        case 'shop_noprice':
            $ret = $shop->search($_GET['q'],$curpage);
            break;
        case 'news':
    			 $ret = $messages->news_search($_GET['q'],$curpage);
    			 break;
                case 'organization':
    			 $ret = $people->search($_GET['q'],$curpage);
    			 break;
    		case 'product':
    			 //$product = $this->model('product');
    			 //$ret = $product->search($_GET['q'],$curpage);
                 header("Location: /central/searchproduct?name=".$_GET['q']);
                 die;
    			 break;
    	}
    } else {
      //$error = 'no search phrase given';
    }
    if (isset($_SESSION['id']) and $_SESSION['id']) {
        $this->template('search/search.php', array(
    		'results' => isset($ret['results'])?$ret['results']:array(),
    		'nextpage' => isset($ret['nextpage'])?$ret['nextpage']:false,
    		'totalpages' => isset($ret['totalpages'])?$ret['totalpages']:false,
    		//'friends' => $friends,
     	    'error' => $error,
                'cart'=>$cart->get_all_small_cart($_SESSION['id']),
    		'applications' => $person_apps, 'person' => $person,
    		'messages_num'=>$messages_num,
    		'is_owner' => true, 'person_apps' => $person_apps));
    } else {

        $this->template('search/search.php', array(
    		'results' => isset($ret['results'])?$ret['results']:array(),
    		'nextpage' => isset($ret['nextpage'])?$ret['nextpage']:false,
    		'totalpages' => isset($ret['totalpages'])?$ret['totalpages']:false,
    		//'friends' => $friends,
     	    'error' => $error,
    		'applications' => $person_apps, 'person' => $person,
    		'messages_num'=>$messages_num,
    		'is_owner' => true, 'person_apps' => $person_apps));
    }
  }
}
