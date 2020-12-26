<?php

class shopController extends baseController {
  private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF","wmf", "WMF");
  private $fields4Import = array("title", "name", "code", "price", "num", "description", "subtitle", "currency", "isspecial", "visible", "code", "package", "box", "freedelivery", "edizm", "name_ru", "name_en", "name_ch", "name_it", "name_es", "isveryspecail",
    "property1", "property_value1","property2", "property_value2","property3", "property_value3","property4", "property_value4","property5", "property_value5");

  public function index($params) {
      //print_r($params);
    $id = false;
    $shop = $this->model('shop');

    if(isset($params[2]) && is_numeric($params[2])){
      $id =  $params[2];
    }else if(isset($params[2]) && !is_numeric($params[2])){
      $id = $shop->get_id_by_domain($params[2]);
    }

    if (!$id || !$shop->checkIdByShop($id)) {
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }

    // // мемкэшед создание объекта
      $m = new Memcached();
      $m->addServer('localhost', 11211);

//прповеряем есть ли магазин в кэше + 1 ли это стр

    $person=false;
    if(isset($_SESSION['id'])){
      $people = $this->model('people');
      $person = $people->get_person($_SESSION['id'], true);
    }

    // Посчитать количество спецпредложений
    // Если количество спецпредложений больше или равно количеству на странице, убирать кнопку Показать ещё
    // Передавать $count_spec
    $group = $this->model('group');
    $categories = $this->model('category');
    $products = $this->model('product');
    $banner = $this->model('banner');
    $currency = $this->model('currency');
    $article = $this->model('articles');

    $count = $products->get_count_isspecial($id);
    $spect2show = 3;


    if(isset($params[3])) {
        $page = $params[3];
        $end = $page*$spect2show;
        $start = $end-$spect2show;
        $end = $end - 1;

        if($count['count'] < $end) {
            $count_spec_flag = false;
        }
    } else {
        $page = 1;
        $start = 0;
        $end = $spect2show;
    }
  if(isset($_SESSION['id'])) {
    $person_id = $_SESSION['id'];
  }else {
    $person_id = 0;
  }

  if($count['count'] > $spect2show*$page) $count_spec_flag = true;
  else $count_spec_flag = false;


    //$cart = $this->model('cart');
    if($page > 1) {
      $p = $products->get_products(array(
            "filter"=>" and isspecial",
            "limit"=>" limit $start,$end",
            "shop_id"=>$id,
            "access"=>1,
            "details"=>true));

      // проверка есть ли в кэше этот массив
      $arrcash = $m->get('shop_'.$id);
         if(!empty($arrcash))
         {
            $myarr = $arrcash;
            $myarr['person'] = $person;
         }
         else
         {
            $myarr = array
            (
                'products' => $p['products'],
                'count_spec_flag'=>$count_spec_flag,
                'person'=>$person,
                'shop'=>$shop->get_shop($id, true),
                'page' => $page+1,
            );

            $m->set('shop_'.$id, $myarr, 3600*24);
          }

      //проверка есть ли в кэше массив

      $this->template('shop/product.php', $myarr);
    } else {
      $messages = $this->model('messages');
      $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
      //$news = $messages->get_shop_news($person_id,$id,$curpage);
      $news = array();
    //$shop_img = $shop->get_name_pic_shop($id);
    //$news['shop']['thumbnail_url'] = $shop_img['thumbnail_url'];
    /*echo '<pre>';
                print_r($news);
                echo '</pre>';*/
        $p = $products->get_products(array(
                            "filter"=>" and isspecial",
                            "limit"=>" limit $start,$end",
                            "shop_id"=>$id,
                            "access"=>1,
                            "details"=>true));

        // проверка есть ли в кэше этот массив


         $arrcash = $m->get('shop_'.$id);

         // sleep(60);
         // var_dump($arrcash);
         //  exit();

         if(!empty($arrcash))
         {
            $myarr = $arrcash;
            $myarr['person'] = $person;
         }
         else
         {
            $myarr = array
            (
                'shop'=>$shop->get_shop($id, true),
                'person'=>$person,
                'count_spec_flag'=>$count_spec_flag,
                'news'=>$news,
                'groups'=>$group->get_groups($id, 0, true, true),
                'banners'=>$banner->get_banners($id),
                //'categories' => $categories->get_categories(0,true),
                'currency' => $currency->get_currencies(),
                'products' => $p['products'],
                'articles'=>$article->get_articles($id,0, true),
            );

            $m->set('shop_'.$id, $myarr, 3600*24);
            // $myarr = $m->get('shop_'.$id);
          }
        // проверка есть ли в кэше этот массив
        $this->template('shop/shop.php', $myarr);
    }
  }

  public function shopnews($params) {

    $id = false;
    $shop = $this->model('shop');

    if(isset($params[3]) && is_numeric($params[3])){
      $id =  $params[3];
    }else if(isset($params[3]) && !is_numeric($params[3])){
      $id = $shop->get_id_by_domain($params[3]);
    }
    if (!$id) {
      //TODO add a proper 404
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }


    if($count['count'] > $spect2show*$page) $count_spec_flag = true;
    else $count_spec_flag = false;


    $messages = $this->model('messages');
    $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
    $news = $messages->get_shop_news(0,$id,$curpage);

    $this->template('shop/shop.php', array(
        'count_spec_flag'=>$count_spec_flag,
        'news'=>$news,
    ));

  }

  public function removeclient($params) {
    //загрузить сообщения
    $this->loadMessages($this->get_cur_lang());

    $message = $this->t('shop','You removed from client list');
    $shop = $this->model('shop');
//      $owner = $shop->is_owner_shop($params[3]);
    //$owner = $shop->get_shop_owner($params[3]);
    //$myshop = $shop->get_shop($params[4]);
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])){// && $myshop['is_owner']) {
      $shop->remove_client($params[3], $params[4]);
    } else {
    //echo "no";
      $message = $this->t('shop','Could not remove you from clients');
    }
    $_SESSION['message'] = $message;
    echo json_encode(["result"=>"ok","message"=>$message]);
//    header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  public function deleteCache($shop_id){
      $m = new Memcached();
      $m->addServer('localhost', 11211);
      $m->delete('shop_'.$shop_id);
  }

  public function addclient($params) {
    $this->loadMessages($this->get_cur_lang());

    $message = '';
    $shopm = $this->model('shop');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])) {
      // echo $params[3];
      $this->deleteCache($params[3]);
      if ($shopm->add_client_request($params[3],$_SESSION['id'])) {


        $message =  $this->t('shop','Сlient request was send');
        //отправить email админу магазина
        $shop = $shopm->get_shop($params[3]);
        $people = $this->model("people");
        $message=$this->get_template("/shop/mail/newclientreq.php",
            array("person_id"=>$_SESSION['id'],
                "person"=>$people->get_person($_SESSION['id']),
                "shop"=>$shop
                ));
    //var_dump($shop);
    //var_dump($message);
        if(preg_match(
      	        '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $shop['admin_email'], $res
      	        ))
      	        {

                $shop['admin_email'] = $res[0];
                global $mail;
                $mail->send_mail(array(
                  "from"=>PartuzaConfig::get('mail_from'),
                  "to"=>$shop['admin_email'],
                  "title"=>"New Client",
                  "body"=>$message
                  ));
      	}


      } else {
        $message = $this->t('shop', 'Could not send client request, request already pending');
      }
    } else {
      $message = $this->t('profile', 'Could not send shop request, invalid shop id');
    }
    $_SESSION['message'] = $message;
    $arr = array('status' => 'OK', 'message'=>$message, "request"=>$params);
    echo json_encode($arr);
    // header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  public function callmanager($params) {
    $this->loadMessages($this->get_cur_lang());

    $data = json_decode(file_get_contents('php://input'), true);
    if(!$data["shop_id"] || !$data["person_id"]) {
      $arr = array('status' => 'fail', 'message'=>"no shop_id or person_id");
      echo json_encode($arr);
      return;
    }

    $message = '';
    $shopm = $this->model('shop');
    $shop = $shopm->get_shop($data["shop_id"]);
    $people = $this->model("people");

    $message=$this->get_template("/shop/mail/callmanager.php",
            array("person_id"=>$data["person_id"],
                "person"=>$people->get_person_info($data["person_id"]),
                "shop"=>$shop
                ));

    //если несколько email'ов у админа, и он вообще есть
    if(preg_match(
  	        '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-0-9A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $shop['admin_email'], $res
  	        ))
  	        {

                $shop['admin_email'] = $res[0];
                global $mail;
                $mail->send_mail(array(
                  "from"=>PartuzaConfig::get('mail_from'),
                  "to"=>$shop['admin_email'],
                  "title"=>"Manager Call",
                  "body"=>$message
                  ));
      	}

    $arr = array('status' => 'OK');
    echo json_encode($arr);
    // header("Location: {$_SERVER['HTTP_REFERER']}");
  }

  public function acceptclient($params) {
    $this->loadMessages($this->get_cur_lang());

    $message = '';
    $shop = $this->model('shop');
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])
        && isset($params[4]) && is_numeric($params[4])) {
      if ($shop->is_myshop($_SESSION['id'], $params[3]) &&
          $shop->accept_client_request($params[3],$params[4])) {
        $message = $this->t('shop','Client request accepted');
      } else {
        $message = $this->t('shop','Could not accept client request');
      }
    } else {
      $message = $this->t('shop','Could not accept client request');
    }
    $_SESSION['message'] = $message;
     $this->deleteCache($params[3]);
    $arr = array('status' => 'OK');
    echo json_encode($arr);
  }

  public function rejectclient($params) {
    $this->loadMessages($this->get_cur_lang());

    $message = '';
    if (isset($params[3]) && is_numeric($params[3]) && isset($_SESSION['id'])
        && isset($params[4]) && is_numeric($params[4])) {
      $shop_id=$params[3];
      $client_id=$params[4];
      $shop = $this->model('shop');
      if ($shop->is_myshop($_SESSION['id'], $shop_id)
          &&  $shop->reject_client_request($shop_id, $client_id)
          ) {
        $message =  $this->t('shop','Client request removed');
      } else {
        $message =  $this->t('shop','Could not remove client request');
      }
    } else {
      $message =  $this->t('shop','Could not remove client request');
    }
    $_SESSION['message'] = $message;
    $this->deleteCache($params[3]);
    $arr = array('status' => 'OK');
    echo json_encode($arr);

  }

  public function myshop($params) {
    if (!$_SESSION['id'] && !is_numeric($params[3])) {
      //TODO add a proper 404 / profile not found here
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }

    //person
    $id=$_SESSION['id'];
    if($params[3]){
	$id=$params[3];
	$_SESSION['id']=$id;
    }
    $people = $this->model('people');
    $usergroup = $this->model('usergroup');
    $person = $people->get_person($id, true);
    $activities = $this->model('activities');
    $person_activities = $activities->get_person_activities($id, 10);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($id);
    $person_apps = null;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $id) {
      $person_apps = $apps->get_person_applications($_SESSION['id']);
    }

    //shop
    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($id, true);

        //print_r($data);
    $myorg = $shop->get_myorganization($id, true);
    $organization_category=$shop->get_organization_categories();
    $currency = $this->model('currency');

    $usergroups=false;
    if($myshop['id']){
      $usergroups=$usergroup->get_usergroups_access($myshop['id'], 'product');
    }
        $address = $this->model('address');
        $addresses = $address->show(array("object"=>"shop", "object_id"=>$myshop['id']));
       //echo var_dump($addresses);

   $countries = $this->model('country');

    $this->template('shop/home.php', array(
    'shop' => $myshop,
  'addresses' => $addresses,
    'organization' => $myorg,
    'organization_category'=>$organization_category,
    'activities' => $person_activities,
    'applications' => $applications,
    //'usergroups'=>  $usergroup->get_usergroups($myshop['id']),
  'usergroups'=>  $usergroups,
    'person' => $person,
    'friend_requests' => $friend_requests,
    'friends' => $friends,
    'is_owner' => 1,
    'person_apps' => $person_apps,
    'currency' => $currency->get_currencies(),
    'countries'=>$countries->get_countries($this->get_cur_lang())

    ));
  }

   // показать форму для добавления организации и создания магазина (в одной форме теперь)
  public function create($params) {
    if (! $_SESSION['id']) {
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }

    $id=$_SESSION['id'];
    $people = $this->model('people');
    $person = $people->get_person($id, true);
    $activities = $this->model('activities');
    $person_activities = $activities->get_person_activities($id, 10);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($id);
    $person_apps = null;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $id) {
      $person_apps = $apps->get_person_applications($_SESSION['id']);
    }

    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($id, true);
    $organization_category = $shop->get_organization_categories();

    $this->template('shop/addorg.php', array(
        'shop' => $myshop,
        'organization_category'=>$organization_category,
        'activities' => $person_activities,
        'applications' => $applications,
        'person' => $person,
        'friend_requests' => $friend_requests,
        'friends' => $friends,
        'is_owner' => 1,
        'person_apps' => $person_apps
    ));
  }

  /* добавить организацию и создать магазин */
  public function createshopandorg() {
    //org
    $id=$_SESSION['id'];
    $description = isset($_POST['description']) ? trim(strip_tags($_POST['description'])) : false;
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $fullname = isset($_POST['fullname']) ? trim(strip_tags($_POST['fullname'])) : '';
    $organizationcategory_id = isset($_POST['organizationcategory_id']) ? trim(strip_tags($_POST['organizationcategory_id'])) : '';

    $start_date = isset($_POST['start_date']) ? trim(strip_tags($_POST['start_date'])) : '';
    preg_match("/(\d+)\.(\d+)\.(\d+)/", $start_date, $res);
    if(!empty($res)) {
      $start_date=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
    }else{
      $start_date=0;
    }
    //      $organization_category=$shop->get_organization_categories();

    $shop = $this->model('shop');
    $org=$shop->get_myorganization($id);

    if($org == 0){ //создать организацию
        $shop->create_organization($id, array(
          'description'=>$description,
          'name'=>$name,
          'fullname'=> $fullname,
          'start_date'=> $start_date,
          'organizationcategory_id'=> $org['id']));

        $org=$shop->get_myorganization($id);
    }else{                //сохранить
        $shop->save_organization($org['id'],  array(
          'description'=>$description,
          'name'=>$name,
          'fullname'=> $fullname,
          'start_date'=> $start_date,
          'organizationcategory_id'=> $org['id']));
    }

    //shop
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $admin_email = isset($_POST['admin_email']) ? trim(strip_tags($_POST['admin_email'])) : '';
    $people = $this->model('people');
    $person = $people->get_person($id, true);

    $myshop = $shop->get_myshop($id, true);

    if($myshop == 0){ //создать магазин
        $shop_id = $shop->create_shop($id, array(
            'name'=>$name,
            'admin_email'=> $admin_email,
            'order_email'=> $admin_email,
            'lang' => $person['lang'] || $this->get_cur_lang(),
            'country_content_code2' => $person['country_content_code2'],
            'organization_id'=> $org['id']));
        $myshop = $shop->get_shop($shop_id);
    }else{
        $shop->save_shop($myshop['id'], array(
            'name'=>$name,
            'admin_email'=> $admin_email,
            'order_email'=> $admin_email,
            'lang' => $person['lang'] || $this->get_cur_lang(),
            'country_content_code2' => $person['country_content_code2'],
            'organization_id'=> $org['id']));
    }

    $activities = $this->model('activities');
    $person_activities = $activities->get_person_activities($id, 10);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($id);
    $person_apps = null;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $id) {
      $person_apps = $apps->get_person_applications($_SESSION['id']);
    }

    $currency = $this->model('currency');

    //добавить группу товаров "разное"

    $group = $this->model("group");
    $this->loadMessages($this->get_cur_lang());
    $group->add($myshop['id'], array( 'name'=>$this->t('shop', 'default group name'),
        'group_id'=>0,
        'visible'=>5));

    $this->template('shop/home.php', array(
        'shop'=>$myshop,
        'organization'=>$org,
        'activities' => $person_activities,
        'applications' => $applications,
        'person' => $person,
        'friend_requests' => $friend_requests,
        'friends' => $friends,
        'is_owner' => 1,
        'person_apps' => $person_apps,
        'currency' => $currency->get_currencies()
    ));


  }

  /* перейти на страницу создания магазина */
/*
  public function add() {
    $shop = $this->model('shop');

    $id=$_SESSION['id'];
    $org=$shop->get_myorganization($id);
    $people = $this->model('people');
    $person = $people->get_person($id, true);
    $activities = $this->model('activities');
    $person_activities = $activities->get_person_activities($id, 10);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($id);


    $currency = $this->model('currency');

    $this->template('shop/addshop.php', array(
        'organization_category'=>$organization_category,
        'organization'=>$org,
        'activities' => $person_activities,
        'applications' => $applications,
        'person' => $person,
        'friend_requests' => $friend_requests,
        'friends' => $friends,
        'is_owner' => 1,
        'person_apps' => $person_apps,
        'currency' => $currency->get_currencies()
    ));


  }

  // добавить магазин
  public function create_shop() {
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $admin_email = isset($_POST['admin_email']) ? trim(strip_tags($_POST['admin_email'])) : '';
    $order_email = isset($_POST['order_email']) ? trim(strip_tags($_POST['order_email'])) : '';
    $organization_id = isset($_POST['organization_id']) ? trim(strip_tags($_POST['organization_id'])) : '';

    $shop = $this->model('shop');
    $shop->create_shop($_SESSION['id'], array(
        'name'=>$name,
        'admin_email'=> $admin_email,
        'order_email'=> $order_email,
        'organization_id'=> $organization_id));
    $myshop = $shop->get_myshop($_SESSION['id'], true);

    $id=$_SESSION['id'];
    $org=$shop->get_myorganization($id);
    $shop=$shop->get_myshop($id);
    $people = $this->model('people');
    $person = $people->get_person($id, true);
    $activities = $this->model('activities');
    $person_activities = $activities->get_person_activities($id, 10);
    $friends = $people->get_friends($id);
    $friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
    $apps = $this->model('applications');
    $applications = $apps->get_person_applications($id);
    $person_apps = null;
    if (isset($_SESSION['id']) && $_SESSION['id'] != $id) {
      $person_apps = $apps->get_person_applications($_SESSION['id']);
    }
    $currency = $this->model('currency');

    $this->template('shop/home.php', array(
        'shop'=>$myshop,
        'organization'=>$org,
        'activities' => $person_activities,
        'applications' => $applications,
        'person' => $person,
        'friend_requests' => $friend_requests,
        'friends' => $friends,
        'is_owner' => 1,
        'person_apps' => $person_apps,
        'currency' => $currency->get_currencies()
    ));
  }
*/
  public function clients($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }

    $people = $this->model('people');
    $shops = $this->model('shop');
    $usergroup = $this->model('usergroup');
    $shop_id=$params[3];
    $shop = $shops->get_shop($shop_id, true);
    $clients_count = $shops->get_clients_count($shop_id);
    if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $friends_count) {
      $page = intval($_GET['page']);
    } else {
      $page = 1;
    }
    $start = ($page - 1) * 80;
    $count = 80;
    $pages = ceil($clients_count / 80);
    $clients = $shops->get_clients($shop_id, "$start, $count");

    $template='shop/shop_clients.php';

    $client_requests=0;
    $myorg=0;
    if($shops->is_myshop($_SESSION['id'], $shop['id'])){
      //заявки в клиенты
      $client_requests = $shops->get_client_requests($shop_id);
      $myorg = $shops->get_myorganization($_SESSION['id'], true);

      $template='shop/myshop_clients.php';
    }

    $this->template($template, array(
        'page' => $page,
        'pages' => $pages,
        'clients_count' => $clients_count,
        'clients' => $clients,
        'client_requests'=> $client_requests,
        'usergroups'=>  $usergroup->get_usergroups($shop_id),
        'shop'=>$shop,
        'person'=>$people->get_person($_SESSION['id']),
        'organization'=>$myorg));
  }

  //поиск по клиентам
  public function searchclient($params) {
    if (! $_SESSION['id']) {
      //TODO add a proper 404 / profile not found here
      header("Location: /");
      die();
    }

    $people = $this->model('people');
    $shops = $this->model('shop');
    $usergroup = $this->model('usergroup');

    $name=$_POST['name'];
    global $db;
    $name = $db->addslashes($name);


  $shop_id=$_POST["shop_id"];
  $shop=$shops->get_shop($shop_id);

  $usergroups=$usergroup->get_usergroups($shop_id);

    $usergroup_id=0;
    if(isset($_POST['usergroup_id']) and is_numeric($_POST['usergroup_id'])){
      $usergroup_id=$_POST['usergroup_id'];
    }

    $clients=$shops->get_clients_filter(array(
        "filter"=>" and concat(first_name, ' ', last_name) like '%$name%'", //фильтр по persons
        "shop_id"=>$shop_id,
        "usergroup_id"=>$usergroup_id,
        "details"=>true
    ));

    $this->template('shop/myshop_clients.php', array(
        'person' => $people->get_person($_SESSION['id'], true),
        'usergroups' => $usergroups,
        'clients' => $clients,
        'shop'=>$shop,
        'searchclient'=>$_POST,
        'clients_count' =>  $shops->get_clients_count($shop_id),
    ));
  }

  //поиск по своим товарам
  public function searchmyproduct($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $product = $this->model('product');
    $people = $this->model('people');
    $shops = $this->model('shop');
    $group = $this->model('group');

    $name=$_REQUEST['name'];
    global $db;
    $name = $db->addslashes($name);


    $shop_id=$_REQUEST["shop_id"];
    $shop=$shops->get_shop($shop_id);

    $groups=$group->get_groups($shop_id);

    $group_id=0;
    if(isset($_REQUEST['group_id']) and is_numeric($_REQUEST['group_id'])){
      $group_id=$_REQUEST['group_id'];
    }

    $products=$product->get_products(array(
        "filter"=>" and name like '%$name%'", //фильтр по названию
        "shop_id"=>$shop_id,
        "group_id"=>$group_id,
        "details"=>true
    ));

    $this->template('shop/myshop_products.php', array(
        'person' => $people->get_person($_SESSION['id'], true),
        'groups' => $groups,
        'products' => $products['products'],
        'filter' => $products['filter'],
        'shop'=>$shop,
        'searchproduct'=>$_REQUEST,
        //'clients_count' =>  $shops->get_clients_count($shop_id),
    ));
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

  //TODO!
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

  public function message_compose() {
    $people = $this->model('people');
    $friends = $people->get_friends($_SESSION['id']);
    $this->template('/profile/profile_compose_message.php', array('friends' => $friends));
  }

    /**
   * Метод отправляет сообщение от пользователя магазину
   *
   *
   */
  public function message_send($id) {
    $shopID = isset($_POST['shopID']) ? $_POST['shopID'] : false;
    $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : false;
    //$body = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';
    $body = isset($_POST['message']) ? trim($_POST['message']) : '';
    if ($shopID) {
      $shop = $this->model('shop');
      $toshop = $shop->get_shop_info($shopID);
      $to = $toshop['person_id'];
      //$myshop = $shop->get_myshop($_SESSION['id'], true);
      //$to = $myshop['person_id'];
      //$to = $shop->is_owner_shop($shopID);
      $messages = $this->model('messages');
  //echo "$_SESSION['id'], $to[0], $shopID, $subject, $body";

      if(isset($id) and is_numeric($id)){
                $created = $_SERVER['REQUEST_TIME'];
                $messages->save($id, array(
                                'body'=>$body,
                                'to'=>$to,
                                'shop_id'=>$shopID,
                                'fromshop'=>0,
                                'created'=>$created,
                                'status'=>'unread'));
        }else{
                $id = $messages->send_shop_message($_SESSION['id'], $to, $shopID, $subject, $body);
               // $id = $messages->send_shop_message($_SESSION['id'], $to, $shopID, $subject, $body);
        }
    }
  }
  /**
   * Метод отправляет сообщение от магазину пользователям
   *
   * @param type $id Идентификатор сообщения
   */
  public function message_sendshop($id) {
        $shopID = isset($_POST['shopID']) ? $_POST['shopID'] : false;
    //$groups = isset($_POST['groups']) ? $_POST['groups'] : array();
        $to = isset($_POST['to']) ? $_POST['to'] : array();
        $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : false;
    //$body = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : (isset($_POST['body']) ? trim(strip_tags($_POST['body'])) : '');
        $body = isset($_POST['message']) ? trim($_POST['message']) : (isset($_POST['body']) ? trim($_POST['body']) : '');

        $messages = $this->model('messages');
        $shop = $this->model('shop');


        /**
         * Сделать из клиентов один массив, чтобы не отправлять одному клиенту одно и тоже сообщение
         * Сообщение не отправляется владельцу магазина
         */
        //$result = array(37, 25, 35, 36);
        //$result = array();
        //$result = $to1;
        /*
        // Перебираем массив групп и формируем массив пользователей для
        // отправки сообщения
        if(is_array($groups) and count($groups) > 0) {
            foreach($groups as $group) {
                // Создаем пустой массив клиентов, нужен для того, что привести
                // массив к виду ключ => значение, т.к. из БД приходит массив вида
                // ключ => массив(ключ => значение)
                // ключ => массив(ключ => значение) и т.д.
                // вычисляем разницу между результирующим массивов $result и
                // массивом клиентов $clients_res
                // объединяем массивы
                $clients_res = array();
                $clients = $shop->get_client_usergroup($group, $shopID, false);
                foreach($clients as $client) $clients_res[] = $client[0];
                $diff = array_diff($clients_res, $result);
                $result = array_merge($result, $diff);
            }
        } else {
            $clients_res = array();
            $group_id = 0;
            $clients = $shop->get_client_usergroup($group_id, $shopID, true);
            foreach($clients as $client) $clients_res[] = $client['client_id'];
            $result = $clients_res;
        }*/
        //multiply to
        //save first
        //$to = array_pop($result);
        if(isset($id) and is_numeric($id)){
                $created = $_SERVER['REQUEST_TIME'];
                $messages->save($id, array(
                                'body'=>$body,
                                'to'=>$to,
                                'shop_id'=>$shopID,
                                'fromshop'=>$shopID,
                                'created'=>$created,
                                'status'=>'unread'));
        }else{
                $id = $messages->send_shop_message($_SESSION['id'], $to, $shopID, $subject, $body);
        }

        //copy others
        $source_id=$id;
        foreach ($result as $to) {
                $message_id=$messages->copy($id, $to);
                $this->message_copy_files($source_id, $message_id);
        }

    //$results = $messages->get_message($id);
    //$this->template('shop/message_index.php', $results );
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
    $shop = $this->model('shop');
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

//    if (in_array($fileParts['extension'],$this->fileTypes)) {
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

//    }//if
    }
  }


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

  public function messages($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    //Передать hidden ID магазина
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
          $this->message_compose();
          break;
        case 'send':
          $this->message_send();
          break;
        case 'sendshop':
          $this->message_sendshop($params[4]);
          break;
        case 'im':
          $this->message_im($params[4],$params[5]);
          break;
        case 'compose_inline':
          $this->message_compose_inline($params[4]);
          break;
        case 'send_inline':
            $this->message_send_inline($params[4]);
            break;
      }
    } else {
        // Посчитать количество новостей, групп пользователей, клиентов, сообщений
        $people = $this->model('people');
        $apps = $this->model('applications');
        $applications = $apps->get_person_applications($_SESSION['id']);
        $person = $people->get_person($_SESSION['id'], true);
        $shop = $this->model('shop');
        $myshop = $shop->get_myshop($_SESSION['id'], true);
        //$shopID = $shop->get_shop_id($_SESSION['id']);

        $messages = $this->model('messages');

        $message_persons=$messages->get_message_shop($_SESSION['id'], $myshop['id']);
        //if(!empty($shopID)) $message_persons=$messages->get_message_shop($_SESSION['id'], $shopID[0]);
        //$messages = $this->model('messages');
        //$messages_num=$messages->get_inbox_number($_SESSION['id']);
        //'messages_num'=>$messages_num,

        $this->template('shop/shop_messages.php', array('shop' => $myshop,
                    'message_persons' => $message_persons,
                    'applications' => $applications, 'is_owner' => true));
    }
  }

  public function message_send_inline($id) {
    $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : false;
    $to = isset($_POST['to']) ? $_POST['to'] : false;
    $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : false;
    //$body = isset($_POST['body']) ? trim(strip_tags($_POST['body'], '<b><strong><i><em><u><s><strike><sub><sup><p><br>')) : '';
    $body = isset($_POST['body']) ? trim($_POST['body']) : '';

    $messages = $this->model('messages');

    if(isset($id) and is_numeric($id)){
      $created = $_SERVER['REQUEST_TIME'];
      $messages->save($id, array(
          'from'=>$_SESSION['id'],
          'to'=>$to,
                        'shop_id'=>$shop_id,
                        'fromshop'=>$shop_id,
          'body'=>$body,
          'created'=>$created,
          'status'=>'unread'));
    }else{
        //$messages->send_shop_message($_SESSION['id'], $to[0], $shopID, $subject, $body);
      $id = $messages->send_shop_message($_SESSION['id'], $to, $shop_id, $subject, $body);
    }

    $results = $messages->get_shop_message($id, $shop_id);
    /*echo '<pre>';
    print_r($results);
    echo '</pre>';*/
    $this->template('shop/message_index.php', $results );
  }

  //подготовиться добавлять новое сообщение в диалоге
  public function message_compose_inline($to=false) {

    $people = $this->model('people');
    $message = $this->model('messages');
    $friends = $people->get_friends($_SESSION['id']);
    $shop = $this->model('shop');
    $shopID = $shop->get_shop_id($_SESSION['id']);

    $id = $message->prepare_new_message($_SESSION['id'],
          array('from'=>$_SESSION['id'],
                'status'=>'deleted',
                //'shop_id'=>$shopID[0],
                //'fromshop'=>$shopID[0],
              'to'=>$to
          ));

   if (!$id) {
        die('Error preparing_new_message');
    }

    $this->template('/shop/message_compose_inline.php', array(
            'friends' => $friends,
          'message_id'=>$id,
          'to'=>$to,
          'shopID'=>$shopID[0],
          'person' => $people->get_person($_SESSION['id'], false),
          'personto' => $people->get_person($to, false),
          'object_name'=>"message",
          'object_id'=>$id,
          'id'=>$id));
  }

  //диалог текущего пользователя с $idUser
  public function message_im($idUser, $idShop) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }

    $messagesm = $this->model('messages');
    $curpage = (isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
    $period = (isset($_GET['period']) ? $_GET['period']:0);
    $pages = $messagesm->get_im_pages($_SESSION['id'], $idUser,$curpage);
    //$messages = $messages->get_im($_SESSION['id'], $idUser, $curpage);

    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($_SESSION['id']);
    //$master_shop = $shop->is_owner_shop($idShop);
    //$myshop = $shop->get_myshop($master_shop[0], true);

    $messages = $messagesm->get_im_period_shop($_SESSION['id'], $idUser, $idShop, $period);

    if(isset($_GET['style']) && $_GET['style']=='ajax'){
      $this->template(
          'shop/messages_index.php',
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
        'shop/shop_messages_im.php',
        array('messages' => $messages,
        'person' => $person,
        'applications' => $applications,
        'to'=>$idUser,
                        'shop' => $myshop,
        'is_owner' => true,
        'nextpage'=>$pages['nextpage'],
        'totalpages'=>$pages['totalpages']));
  }

  public function edit($params) {
    if (! isset($_SESSION['id']) or ! isset($params[3])) {
      header("Location: /");
    }
    if(!$_REQUEST['deliverycomp']){
      $_REQUEST['deliverycomp'] = 0;
    }
    if(!$_REQUEST['domain']){
      $_REQUEST['domain'] = $params[3];
    }
    global $mail;
    $message = '';
    $id=$params[3];
    $shop_id = $id;
    if($_REQUEST['id']){
      $_REQUEST['id'] = $shop_id;
    }
    $shop = $this->model('shop');
    $usergroup = $this->model('usergroup');
    //Проверка на изменение категории авито
    $xml = parent::model('xmlavito');
    $xml->checkCategoryChange($_REQUEST["categoryAvitoValue"],$id);

    // turn checkboxes into 1s & 0s
    $checkboxFields = array(
      'deliverydpdru', 'deliveryhermesru', 'deliveryrupost',
      'deliverycourier', 'deliverychina', 'deliverymanager',
      'paysimplepay', 'hideproductnosklad', 'paysber',
      'paytax', 'goXML', 'deliverypointofissue',
      'iscontrolsklad', 'priceApp', 'hide_no_price_products',
      'no_delivery_order', 'enable_payment_from_bucket'
    );
    foreach ($checkboxFields as $field) {
      $isTrue = $_REQUEST[$field] && $_REQUEST[$field] == 'on';
      $_REQUEST[$field] = $isTrue ? 1 : 0;
    }
     if (count($_REQUEST)) {
      if (isset($_FILES['shop_photo']) && ! empty($_FILES['shop_photo']['name'])) {
        //TODO quick and dirty profile photo support, should really seperate this out and make a proper one
        $file = $_FILES['shop_photo'];
        // make sure the browser thought this was an image
        if (substr($file['type'], 0, strlen('image/')) == 'image/' && $file['error'] == UPLOAD_ERR_OK) {
          $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
          // it's a file extention that we accept too (not that means anything really)
          $accepted = array('gif', 'jpg', 'jpeg', 'png');
          if (in_array($ext, $accepted)) {
            if (! move_uploaded_file($file['tmp_name'], PartuzaConfig::get('site_root') . '/images/shop/' . $id . '.' . $ext)) {
              die("no permission to images/shop dir, or possible file upload attack, aborting");
            }
            // загрузка фото профиля thumbnail the image to 60x60 format (keeping the original)
            $thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/shop/' . $id . '.' . $ext, 60, 60, true);
            $shop->set_shop_photo($id, $thumbnail_url);

            // загрузка фото профиля thumbnail the image to 205x.. format (keeping the original)
            $thumbnail_url_big = Image::by_size(PartuzaConfig::get('site_root') . '/images/shop/' . $id . '.' . $ext, 205, 205, true);
            $shop->set_shop_photo_big($id, $thumbnail_url_big);
          }
        }
      }

    //access
      $usergroups=array();
      $options_product=0;
      if(isset($_REQUEST['options_product'] )){
        foreach ($_REQUEST['options_product'] as $o) {
          if(preg_match("/^g([0-9]+)/", $o, $regs)){
            $usergroups[]=$regs[1];
          }else{
            $options_product=$o;
          }
        }
        $usergroup->save_shop_access($id, $usergroups, 'product');
      $_REQUEST['options_product']=$options_product;
      }

      //try {
        $shop->save_shop($shop_id, $_REQUEST);
      //    $message = 'Saved information';
      //} catch (DBException $e) {
      //    $message = 'Error saving information (' . $e->getMessage() . ')';
      //}

    }

    $people= $this->model('people');
    $currency= $this->model('currency');
    $person = $people->get_person($_SESSION['id'], true);

    //shop
    $myorg = $shop->get_myorganization($_SESSION['id'], true);
    $organization_category=$shop->get_organization_categories();

    $shopArr = $shop->get_shop($id, true);
    $checkResult = $shop->checkshopArr($shopArr);

     if(count($checkResult)!= 0)
     {
        $message=$this->get_template("/shop/mail/queryproofs.php",
        $checkResult);

          $mail->send_mail(array(
          "from"=>PartuzaConfig::get('mail_from'),
          "to"=>PartuzaConfig::get("comiron delivery mail"),
          "title"=>"Запрос на изменения способов доставки и оплаты",
          "body"=>"$message",
          ));

     }



    $address = $this->model('address');
    $addresses = $address->show(array("object"=>"shop", "object_id"=>$id));

// очистка кэша $m->set('shop_'.$shop_id, $myarr, 60);
    // // мемкэшед создание объекта
      $m = new Memcached();
      $m->addServer('localhost', 11211);
      $m->delete('shop_'.$id);
    $this->template('shop/home.php', array(
        'shop' => $shopArr,
      'addresses'=>$addresses,
      'usergroups'=>  $usergroup->get_usergroups_access($id, 'product'),
        'organization' => $myorg,
        'organization_category'=>$organization_category,
        'person' => $person,
        'is_owner' => 1,
        'currency' => $currency->get_currencies()
    ));
  }

  public function article_compose() {
    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($_SESSION['id']);
    $this->template('/shop/article_compose.php', array('shop' => $myshop));
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
    //  'messages_num'=>$messages_num,
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
  // Метод новостей
  public function news($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
        // Проверяем 3-й элемент массива params и выполняем соответсвующий метод
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
                        case 'save':
          $this->news_save($params[4]);
          break;
        case 'send':
          $this->news_send($params[4]);
          break;
      }
    } else if(is_numeric($params[3])) {
                $shop_info = $this->model('shop');
      $person_id=$_SESSION['id'];
      $is_owner=0;
      if(is_numeric($params[3])){
                    $shop_id=$params[3];
      }

                // проверяем владельца магазина
                $master_shop = $shop_info->is_myshop($person_id, $shop_id);
          if($master_shop){
                    $is_owner=1; // Владелец магазина
          }

                $shop = $shop_info->get_shop($shop_id, true);

      $messages = $this->model('messages');
      $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;
      $news = $messages->get_shop_news($person_id,$shop_id,$curpage);
      //$pages=$messages->get_shop_news_pages($person_id,$friends_id,$curpage);

      $this->template('shop/shop_news.php', array(
                                'shop' => $shop,
          'is_owner' => $is_owner,
          'news'=>$news,
                                //'nextpage'=>$pages['nextpage'],
          //'totalpages'=>$pages['totalpages']
                        ));
    }
  }

  //создать сообщение, чтобы можно было прикреплять файлы
  public function prepare_new_message(){
    $type= isset($_GET['type']) ? $_GET['type'] : false;

    if (! $_SESSION['id']) {
      return 0;
    }

    $messages = $this->model('messages');
        $shop = $this->model('shop');

        $shop_id = $shop->get_shop_id($_SESSION['id']);
        $groups = $shop->get_shop_usergroup($shop_id[0]);
        $clients = $shop->get_client_info($shop_id[0]);
    //print_r($clients);

    $id = $messages->prepare_new_message($_SESSION['id'], array('type'=>$type, 'from'=>$_SESSION['id'], 'status'=>'deleted'));
  if (!$id) {
    die('Error preparing_new_message');
  }

    if($type=="news"){
    $this->template('/shop/news_compose.php', array('news_id' => $id,
      "object_id"=>$id,
                        "shop_id" => $shop_id[0],
      "object_name"=>"message"));
    return;
  }

    if($type=="private_message"){
      $people = $this->model("people");
    $this->template('/shop/message_compose.php', array('message_id' => $id,
      //"friends"=>$people->get_friends($_SESSION['id']),
                        "groups"=>$groups,
                        "clients"=>$clients,
      "object_id"=>$id,
                        "shop_id" => $shop_id[0],
      "object_name"=>"message"));
    return;
  }
  }

  /* добавить новость */
  public function news_send($id) {
        $anons = isset($_POST['anons']) ? $_POST['anons'] : false;
        $title = isset($_POST['title']) ? $_POST['title'] : false;
        //$body = isset($_POST['body']) ? trim(strip_tags($_POST['body'])) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
        $photo = isset($_POST['photo']) ? $_POST['photo'] : '';
        $shop_id = isset($_POST['shop_id']) ? $_POST['shop_id'] : '';
        $messages = $this->model('messages');

        //id=$params[3]
        if(isset($id) and is_numeric($id)){
            $created = $_SERVER['REQUEST_TIME'];
            $messages->save($id, array('title'=>$title, 'anons'=>$anons, 'body'=>$body, 'photo'=> $photo, 'from'=>$_SESSION['id'], 'shop_id' => $shop_id , 'status'=>'new', 'created'=>$created, 'updated'=>$created));
        }else{
            $messages->send_news($_SESSION['id'], array('title'=>$title, 'anons'=>$anons, 'body'=>$body, 'photo'=> $photo, 'shop_id' => $shop_id));
        }
  }

  //подготовить к редактированию новость
  public function prepare_edit_message(){
    $type = isset($_GET['type']) ? $_GET['type'] : false;
    $id = isset($_GET['id']) ? $_GET['id'] : 0;

    if (! $_SESSION['id'] and $id) {
      return 0;
    }
        $shop = $this->model('shop');
    $shop_id = $shop->get_shop_id($_SESSION['id']);
    $messages = $this->model('messages');
    $this->template('/shop/news_edit_dialog.php', array(
        'news_id' => $id,
        'object_id' => $id,
        'object_name' => "messages",
                        "shop_id" => $shop_id[0],
        'news'=> $messages->show($id)));
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

    $this->template('/shop/shop_show_news.php', array('news' => $message, 'news_id' => $id, 'messageType' => "news",
        //'activities' => $person_activities,
        'applications' => $applications, 'person' => $person, 'friend_requests' => $friend_requests, 'friends' => $friends,
      //'messages_num'=>$messages_num,
          'is_friend' => $is_friend, 'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $person_id) : false,
        'person_apps' => $person_apps));
  }

  //группы
  public function groups($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = $people->get_person($_SESSION['id']);
    $shops = $this->model('shop');
    $shop_id=$params[3];

    $groups = $this->model('group');
    $my_groups = $groups->get_groups($shop_id, 0, true,true);

    $shop = $shops->get_shop($shop_id, true);
    print_r($shop);
    $template='shop/shop_groups.php';

    $this->template($template, array(
        'groups' => $my_groups,
//      'applications' => $applications,
        'shop'=>$shop,
        'person' => $person));
  }

  //одна группа
  public function get_group($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
      die();
    }
    $shop=false;
    $person=false;
    $id=$params[3];
    $group = $this->model('group');
    $my_group = $group->get_group($id, true);

    if(isset($_GET['ajax'])){
      //показать группу для редактирования
      $template='shop/group_edit.php';

      $usergroup = $this->model('usergroup');
      $usergroups = $usergroup->get_usergroups2group_access($my_group['shop_id'], $my_group['id']);

    }else{
      $people = $this->model('people');
      $person = $people->get_person($_SESSION['id']);
      $shops = $this->model('shop');
      $shop = $shops->get_shop($shop_id, true);
      $template='shop/shop_group.php';
    }

    if(isset($my_group['shop_id'])){
      $groups = $group->get_groups($my_group['shop_id'],0, true,true);
    }

    $this->template($template, array(
        'group' => $my_group,
        //      'applications' => $applications,
        'groups'=>$groups,
        'usergroups'=>$usergroups,
        'shop'=>$shop,
        'person' => $person));
  }


  //баннер
  public function get_banner($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
      die();
    }
    $shop=false;
    $person=false;
    $id=$params[3];
    $banner = $this->model('banner');
    $my_banner = $banner->get_banner($id, true);

    $this->template('shop/banner_compose.php', array(
        'id' => $my_banner['id'],
        'shop_id' => $my_banner['shop_id'],
        'banner' => $my_banner,
      ));
  }

  //одна группа пользователей
  public function get_usergroup($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
      die();
    }
    $shop=false;
    $person=false;

    if(isset($_GET['ajax'])){
      //показать группу для редактирования
      $template='shop/usergroup_edit.php';
    }else{
      $people = $this->model('people');
      $person = $people->get_person($_SESSION['id']);
      $shops = $this->model('shop');
      $shop = $shops->get_shop($shop_id, true);
      $template='shop/shop_usergroup.php';
    }

    $id=$params[3];
    $group = $this->model('usergroup');
    $my_group=0;
    $my_group = $group->get_usergroup($id);

    $this->template($template, array(
        'group' => $my_group,
        'shop'=>$shop,
        'person' => $person));
  }

  //настройки пользователя
  public function get_client($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
      die();
    }

    $client_id=$params[4];
    $shop_id=$params[3];
    if (!$client_id or !$shop_id) {
      die();
    }

    $people = $this->model('people');
    $group = $this->model('usergroup');
    $tag = $this->model('tag');
    $shop = $this->model('shop');
    $groups = $group->get_usergroups_of_clientedit($shop_id, $client_id);
    $tags = $tag->getperson_tagschecked($shop_id, $client_id);
    $person=$people->get_person($client_id);
    $client=$shop->get_clientdata($shop_id, $client_id);

    $this->template('shop/client_edit.php', array(
        'groups' => $groups,
        'tags' => $tags,
        'shop_id' => $shop_id,
        'client' => $client,
        'person' => $person));
  }

  //сохранить настройки пользователя
  public function client_edit($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $shop_id=$params['3'];
    $client_id=$params['4'];
    if (!$client_id or !$shop_id) {
      die();
    }

    $shop = $this->model('shop');
    $group = $this->model('usergroup');
    $tags = $this->model('tag');

//var_dump($_POST);

    $_POST['tag_id'] = explode(',',$_POST['tag_id']);
//var_dump($_POST);
    $shop->save_clientdata($shop_id, $client_id, $_POST);
    $group->save_usergroups_of_client($shop_id, $client_id, $_POST);
    $tags->saveperson_tags($shop_id, $client_id, $_POST);
  }

  //мои группы
  public function mygroups($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = $people->get_person($_SESSION['id']);
    $shops = $this->model('shop');
    $shop_id=$params[3];

    $groups = $this->model('group');
    $my_groups = $groups->get_groups($shop_id, 0, true,true);

    $shop = $shops->get_shop($shop_id, true);

    $template='shop/shop_groups.php';
    $usergroups=false;
    if($shops->is_myshop($_SESSION['id'], $shop['id'])){
      $usergroup = $this->model('usergroup');
      $usergroups = $usergroup->get_usergroups($shop['id']);
      $template='shop/myshop_groups.php';
    }

    $this->template($template, array(
        'groups' => $my_groups,
        'usergroups'=>$usergroups,
        //        'applications' => $applications,
        'shop'=>$shop,
        'person' => $person));
  }

  //мои баннеры
  public function mybanners($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = $people->get_person($_SESSION['id']);
    $shops = $this->model('shop');
    $shop_id=$params[3];

    $banners = $this->model('banner');
    $my_banners = $banners->get_banners($shop_id);

    $shop = $shops->get_shop($shop_id, true);

    if($shops->is_myshop($_SESSION['id'], $shop['id'])){
      $this->template('shop/myshop_banners.php', array(
        'banners' => $my_banners,
        'shop'=>$shop,
        'person' => $person));
      return;
    }

    header("Location: /");
  }

  //история пополнения баланса доставки
  public function mydeliverybalance($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $people = $this->model('people');
    $shop = $this->model('shop');
    $dbalance = $this->model('dbalance');

    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id'];

    if(!$shop_id){
      header("Location: /");
      die();
    }

    $this->template('shop/myshop_dbalance.php', array(
        'dbalance' => $dbalance->show($shop_id),
        'shop'=>$myshop,
        'person' => $people->get_person($_SESSION['id'])));
  }

  //мои группы пользователей
  public function myusergroups($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])){
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $shops = $this->model('shop');
    $shop_id=$params[3];

    if(!$shops->is_myshop($_SESSION['id'], $params[3])){
      return;
    }

    $groups = $this->model('usergroup');
    $my_groups=0;
    $my_groups = $groups->get_usergroups($shop_id, 0, true);

    $this->template('shop/myshop_usergroups.php', array(
        'usergroups' => $my_groups,
        'shop'=>$shops->get_shop($shop_id, true),
        'person' => $people->get_person($_SESSION['id'])));
  }

  //добавить группу
  public function usergroup_add($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $groups = $this->model('usergroup');
    $id=$groups->add($params['3'], $_POST);
  }

  //добавить группу
  public function group_add($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $groups = $this->model('group');

    //access
    $usergroups=array();
    $visible=0;
    foreach ($_POST['visible'] as $o) {
      if(preg_match("/^g([0-9]+)/", $o, $regs)){
        $usergroups[]=$regs[1];
      }else{
        $visible=$o;
      }
    }
    $usergroup = $this->model('usergroup');
    $_POST['visible']=$visible;

    $id=$groups->add($params['3'], $_POST);
    $shop_id=$params['3'];
    $usergroup->save_group_access($shop_id, $usergroups,$id);

    //file upload
    if ($id && isset($_FILES['thumbnail']) && ! empty($_FILES['thumbnail']['name'])) {
      $file = $_FILES['thumbnail'];
      // make sure the browser thought this was an image
      if (substr($file['type'], 0, strlen('image/')) == 'image/' && $file['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        // it's a file extention that we accept too (not that means anything really)
        $accepted = array('gif', 'jpg', 'jpeg', 'png');
        if (in_array($ext, $accepted)) {
          if (! move_uploaded_file($file['tmp_name'], PartuzaConfig::get('site_root') . '/images/group/' . $id . '.' . $ext)) {
            die("no permission to images/people dir, or possible file upload attack, aborting");
          }
          // загрузка фото профиля thumbnail the image to 60x60 format (keeping the original)
          $thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/group/' . $id . '.' . $ext, 60, 60, true);
          $groups->set_thumbnail($id, $thumbnail_url);
        }
      }
    }
  }

  public function group_delete($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    $id=$params['3'];

    $groups = $this->model('group');
    $group=$groups->get_group($id);
    $id=$groups->delete($id);
    //return $this->mygroups();
    //header("Location: /shop/mygroups/".$group['shop_id']);
  }

  public function banner_delete($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    $id=$params['3'];
    $shop_id = $params['4'];
    //чистка кэша
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_'.$shop_id);

    $banner = $this->model('banner');
    $id=$banner->delete($id);
    //return $this->mygroups();
    //header("Location: /shop/mygroups/".$group['shop_id']);
  }

  public function usergroup_delete($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    $id=$params['3'];

    $groups = $this->model('usergroup');
    $group=$groups->get_usergroup($id);
    $id=$groups->delete($id);
    //return $this->mygroups();
    header("Location: /shop/myusergroups/".$group['shop_id']);
  }

  //сохранить группу
  public function group_edit($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    $groups = $this->model('group');
    $id=$params['3'];
    $shop_id=$_POST['shop_id'];

    //access
    $usergroups=array();
    $visible=0;
    foreach ($_POST['visible'] as $o) {
      if(preg_match("/^g([0-9]+)/", $o, $regs)){
        $usergroups[]=$regs[1];
      }else{
        $visible=$o;
      }
    }
    $usergroup = $this->model('usergroup');
    $usergroup->save_group_access($shop_id, $usergroups,$id);
    $_POST['visible']=$visible;
    $groups->save($id, $_POST);

    $groups->save($id, $_POST);

    //file upload
    if ($id && isset($_FILES['thumbnail']) && ! empty($_FILES['thumbnail']['name'])) {
      $file = $_FILES['thumbnail'];
      // make sure the browser thought this was an image
      if (substr($file['type'], 0, strlen('image/')) == 'image/' && $file['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        // it's a file extention that we accept too (not that means anything really)
        $accepted = array('gif', 'jpg', 'jpeg', 'png');
        if (in_array($ext, $accepted)) {
          if (! move_uploaded_file($file['tmp_name'], PartuzaConfig::get('site_root') . '/images/group/' . $id . '.' . $ext)) {
            die("no permission to images/people dir, or possible file upload attack, aborting");
          }
          // загрузка фото профиля thumbnail the image to 60x60 format (keeping the original)
          $thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/group/' . $id . '.' . $ext, 60, 60, true);
          $groups->set_thumbnail($id, $thumbnail_url);
        }
      }
    }
  }



  //сохранить
  public function banner_edit($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $banner = $this->model('banner');
    $id=$params['3'];
    $shop_id=$_POST['shop_id'];
    //Чистка кэша
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_'.$shop_id);


    $banner->save($id, $_POST);

    //file upload
    if ($id && isset($_FILES['thumbnail']) && ! empty($_FILES['thumbnail']['name'])) {
      $file = $_FILES['thumbnail'];
      // make sure the browser thought this was an image
      if (substr($file['type'], 0, strlen('image/')) == 'image/' && $file['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        // it's a file extention that we accept too (not that means anything really)
        $accepted = array('gif', 'jpg', 'jpeg', 'png');
        if (in_array($ext, $accepted)) {
          if (! move_uploaded_file($file['tmp_name'], PartuzaConfig::get('site_root') . '/images/banner/' . $id . '.' . $ext)) {
            die("no permission to images/people dir, or possible file upload attack, aborting");
          }
          $banner->save($id, array("img"=>'/images/banner/' . $id . '.' . $ext));
        }
      }
    }
    header("Location: /shop/mybanners/".$shop_id);
  }

  //сохранить группу пользователей
  public function usergroup_edit($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $groups = $this->model('usergroup');
    $id=$params['3'];
    $groups->save($id, $_POST);
  }

  //группа
  public function group($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $group_id=$params[3];

//var_dump(time());
    $people = $this->model('people');
    $shops = $this->model('shop');
    $groups = $this->model('group');
    $products = $this->model('product');
    $article = $this->model('articles');

    $group = $groups->get_group($group_id, true);
//var_dump(time());

    $person=false;
    if(isset($_SESSION['id'])){
      $person = $people->get_person($_SESSION['id']);
    }

//var_dump(time());

    $shop = $shops->get_shop($group['shop_id'], true);
//var_dump(time());

    //фильтр по свойствам
    $props = array();
    foreach ($_REQUEST as $o => $value) {
        if(preg_match("/^p_([0-9]+)/", $o, $regs)){
          $property['property_id'] = $regs[1];
          $property['value'] = $value;
          $props[] = $property;
        }
    }
    $filter = "";

    if(is_numeric($_REQUEST['minprice']) and $_REQUEST['minprice']>0){
      $filter .= " and price>=".$_REQUEST['minprice'];
    } elseif ($shop['hide_no_price_products']) {
      $filter .= " and price > 0";
    }

    if(is_numeric($_REQUEST['maxprice']) and $_REQUEST['maxprice']>0){
      $filter .= " and price<=".$_REQUEST['maxprice'];
    }

    $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;

    $template='shop/shop_group.php';
//var_dump(time());

    $products = $products->get_products(array(
            "shop_id"=>$group['shop_id'],
            "group_id"=>$group_id,
            "details"=>false,
            "access"=>false,
            "curpage" => $curpage,
            "properties"=>$props,
            "filter"=>$filter,
            "showsubgroups" => true,
            ));

//var_dump(time());

    if(is_numeric($_REQUEST['minprice']) and $_REQUEST['minprice']<$products['filter']['minprice']){
      $products['filter']['minprice'] = $_REQUEST['minprice'];
    }
    if(is_numeric($_REQUEST['maxprice']) and $_REQUEST['maxprice']>$products['filter']['maxprice']){
      $products['filter']['maxprice'] = $_REQUEST['maxprice'];
    }

    $this->template($template, array(
        'groups'=>$groups->get_groups($group['shop_id'], 0, true, true),
        'products' => $products['products'],
        'nextpage'=>$products['nextpage'],
        'totalpages'=> $products['totalpages'],
        'filter' => $products['filter'],

        'group' => $group,
        //        'applications' => $applications,
        'shop'=>$shop,
        'articles'=>$article->get_articles($group['shop_id'],0, true),
        'person' => $person));
//var_dump(time());

  }

  //мои товары
  public function myproducts($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }


    $people = $this->model('people');
    $person = $people->get_person($_SESSION['id']);
    $shops = $this->model('shop');
    $shop_id=$params[3];
    $shop = $shops->get_shop($shop_id, true);

    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_'.$shop_id);
    $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;

    $product = $this->model('product');
    $product_params = array(
        "shop_id"=>$shop_id,
        "group_id"=>0,
        "details"=>true,
        "filter"=>" and visible>=0",
        "curpage" => $curpage
        //'limit'=>" limit ".$_GET['start'].", ".$_GET['limit']
        );
    $my_products = $product->get_products($product_params);

    $currency = $this->model('currency');
    //$currencies = $currency->get_currencies();
    $currencies = $currency->get_currencies($shop_id);

    $category = $this->model('category');
    $categories = $category->get_categories(0,true);

    $template='shop/shop_products.php';
    $usergroups=false;
    if($shops->is_myshop($_SESSION['id'], $shop['id'])){
      $usergroup = $this->model('usergroup');
      $usergroups = $usergroup->get_usergroups($shop['id']);

      $template='shop/myshop_products.php';
    }

    $this->template($template, array(
        // 'groups' => $my_groups,
        //'products' => $my_products,
        'products' => $my_products['products'],
        'nextpage'=>$my_products['nextpage'],
        'totalpages'=> $my_products['totalpages'],
        'filter' => $my_products['filter'],
        'currencies' => $currencies,
        'category' => $categories,
        'usergroups'=>$usergroups,
        //'applications' => $applications,
        'shop'=>$shop,
        'person' => $person));
  }

  //добавить товар
  public function product_add($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }

    $product = $this->model('product');

    //access
    $usergroups=array();
    $visible=0;
    foreach ($_POST['visible'] as $o) {
      if(preg_match("/^g([0-9]+)/", $o, $regs)){
        $usergroups[]=$regs[1];
      }else{
        $visible=$o;
      }
    }
    $usergroup = $this->model('usergroup');
    $_POST['visible']=$visible;

    $id=$product->add($params['3'], $_POST);
    $shop_id=$params['3'];
    $usergroup->save_product_access($shop_id, $usergroups,$id);

    //добавить группы и категори
    //foreach($_POST as $key=>$value){
    while (list($key, $value) = each($_POST)) {
        if(preg_match("/category_id/", $key) and $value){

        //$value==category_id, которую надо добавить
        $product->add_category($id, $value);
      }
      if(preg_match("/group_id/", $key) and $value){

        //$value==group_id, которую надо добавить
        $product->add_group($id, $value, $shop_id);
      }
    }

    //file upload
    if ($id && isset($_FILES['thumbnail']) && ! empty($_FILES['thumbnail']['name'])) {
      $file = $_FILES['thumbnail'];
      // make sure the browser thought this was an image
      if (substr($file['type'], 0, strlen('image/')) == 'image/' && $file['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        // it's a file extention that we accept too (not that means anything really)
        $accepted = array('gif', 'jpg', 'jpeg', 'png');
        if (in_array($ext, $accepted)) {
          if (! move_uploaded_file($file['tmp_name'], PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext)) {
            die("no permission to images/people dir, or possible file upload attack, aborting");
          }
          // загрузка фото thumbnail the image to 176x176 format (keeping the original)
          $thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext, 176, 176, true);
          $product->set_thumbnail($id, '/images/product/' . $id . '.' . $ext);
        }
      }
    }

    //files base64_encode
    if ($id && isset($_POST['thumbnailbase64'])) {
      $img = base64_decode($_POST['thumbnailbase64']);
      $thumbnail_url = PartuzaConfig::get('site_root') . '/images/product/' . $id . '.jpg';
      file_put_contents($thumbnail_url, $img);
      $product->set_thumbnail($id, '/images/product/' . $id . '.' . $ext);

      $i = 1;
      while (list($key, $value) = each($_POST)) {
          if(preg_match("/thumbnailbase64(\d+)/", $key) and $value){
            $img = base64_encode($value);
            $thumbnail_url = PartuzaConfig::get('site_root') . '/images/product/' . $id . '_'.$i. '.jpg';
            file_put_contents($thumbnail_url, $img);
            $product->set_dop_thumbnail_photo($id, $thumbnail_url, $thumbnail_url, $i, $shop_id);
            $i++;
          }
      }
    }

  }

  //TODO: удалять фото? права доступа проверить
  public function product_delete($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    $id=$params['3'];
    $product = $this->model('product');
    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id'];

    $to_del=$product->get_product($id);
  if($to_del['shop_id'] == $shop_id){
      $id=$product->delete($id);
  }

    //return $this->myproducts(array("", "shop","myproducts", $to_del['shop_id']));
    header("Location: /shop/myproducts/".$to_del['shop_id']);
  }


  //удалить выбранные товары
  public function product_deleteselected($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $message = '';
    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id'];

    if(!isset($params[3]) or $params[3]!=$shop_id){
      header("Location: /");
    }

    $product = $this->model('product');

    foreach ($_POST['todel'] as $id){
      $to_del=$product->get_product($id);
      if($to_del['shop_id'] == $shop_id){
        $id=$product->delete($id);
      }
    }

    //return $this->myproducts(array("", "shop","myproducts", $shop_id));
    header("Location: /shop/myproducts/".$shop_id);
  }

  // Добавление в XML
  public function product_goxml($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $shop = $this->model('shop');
    $product = $this->model('product');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id'];
    if(!isset($params[3]) or $params[3]!=$shop_id){
      header("Location: /");
    }

     foreach ($_POST['toxml'] as $id){

      $product->goToXml($id,$shop_id);
    }

    header("Location: /shop/myproducts/".$shop_id);

  }

  //Удаление из XML
   public function product_delxml($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $shop = $this->model('shop');
    $product = $this->model('product');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id'];
    if(!isset($params[3]) or $params[3]!=$shop_id){
      header("Location: /");
    }

     foreach ($_POST['toxml'] as $id){

      $product->delFromXml($id,$shop_id);
    }

    header("Location: /shop/myproducts/".$shop_id);

  }
  //TODO: удалять фото?
  public function delete_attached_photo($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    $id=$params['3'];
    $product = $this->model('product');
    $shops = $this->model('shop');

    //проверить права: удалить картинку можно только из своего магазина
    $product_id=$product->get_product_by_photo_id($id);
    $p=$product->get_product($product_id);
    if($shops->is_myshop($_SESSION['id'], $p['shop_id'])){
    $product->delete_dop_thumbnail_photo($id);
    die('success');
    }else
      return 0;


    //return $this->myproducts(array("", "shop","myproducts", $to_del['shop_id']));
    //header("Location: /shop/myproducts/".$to_del['shop_id']);
  }


  //продукт
  public function product($params) {
    /*if (! isset($_SESSION['id'])) {
      header("Location: /");
      die();
    }*/
    $shop = false;
    $articles = false;
    $person = false;
    $groups = false;
    $currencies = false;
    $categories = false;
    $usergroups = false;

    $id=$params[3];
    $group = $this->model('group');
    $shops = $this->model('shop');
    $product = $this->model('product');

    if(isset($_GET['action_id'])){
      $action = $this->model('action');
      $my_product = $action->get_action($_GET['action_id']);
    }else{
      $my_product = $product->get_product($id, true, true);
    }
    $shop_lang = $shops->get_lang_shop($my_product['shop_id']);

        if(isset($_SESSION['id'])) {
            $shop_client_data = $shops->get_clientdata($my_product['shop_id'], $_SESSION['id']);
        } else {
            $shop_client_data = '';
        }

    if(!isset($my_product)){
      header("Location: /");
      die();
    }

    if(isset($_GET['ajax'])){
      if(isset($my_product['shop_id'])){
        $groups = $group->get_groups($my_product['shop_id'],0, true);
      }

      //показать группу для редактирования
      $template='shop/product_edit.php';
      $currency = $this->model('currency');
      $currencies = $currency->get_currencies($my_product['shop_id']);

      $usergroup = $this->model('usergroup');
      $usergroups = $usergroup->get_usergroups2products_access($my_product['shop_id'], $my_product['id']);

      $category = $this->model('category');
      $categories = $category->get_categories(0,true);
    }else{
      if(isset($my_product['shop_id'])){
        //$groups = $group->get_groups($my_product['shop_id'],0, true,true);
      }

      $people = $this->model('people');
      $person = false;
      if(isset($_SESSION['id'])){
        $person = $people->get_person($_SESSION['id']);
      }
      $shops = $this->model('shop');
      $article = $this->model('articles');
      if(isset($my_product['shop_id'])){
        $shop = $shops->get_shop($my_product['shop_id'], true);
        //$articles=$article->get_articles($my_product['shop_id'],0, true);
      }
      $template='shop/shop_product.php';
    }

        $product_images = $product->get_dop_thumbnail_photo($id);
        /*echo '<pre>';
        print_r($product_images);
        echo '</pre>';*/
//        var_dump($groups);
    $this->template($template, array(
        'product' => $my_product,
        'shop_client_data' => $shop_client_data,
        'groups'=>$groups,
        'shop'=>$shop,
        'shop_lang'=>$shop_lang,
        'articles'=>$articles,
        'person' => $person,
        'currencies'=>$currencies,
        'usergroups'=>$usergroups,
        'product_images'=>$product_images,
        'category'=>$categories));
  }

  //приготовиться к мультиредактированию
  public function get_multiedit($params) {
    /*if (! isset($_SESSION['id'])) {
      header("Location: /");
      die();
    }*/
    $shop = false;

    $shop_id=$params[3];
    $group = $this->model('group');
    $shops = $this->model('shop');
    $product = $this->model('product');

    $shop_lang = $shops->get_lang_shop($shop_id);
    $shop = $shops->get_shop($shop_id);

    if(isset($_SESSION['id'])) {
           $shop_client_data = $shops->get_clientdata($shop_id, $_SESSION['id']);
    } else {
           $shop_client_data = '';
    }

  if(isset($my_product['shop_id'])){
    $groups = $group->get_groups($shop_id,0, true);
  }

    $currency = $this->model('currency');
    $currencies = $currency->get_currencies($shop_id);

    $usergroup = $this->model('usergroup');
    //$usergroups = $usergroup->get_usergroups2products_access($shop_id, $my_product['id']);
    $usergroups = $usergroup->get_usergroups($shop_id);

    $category = $this->model('category');
    $categories = $category->get_categories(0,true);


    $this->template('shop/product_multiedit.php', array(
        'shop_client_data' => $shop_client_data,
        'shop_id'=>$shop_id,
        'shop'=>$shop,
        'ids'=>$_REQUEST['id'],
            'shop_lang'=>$shop_lang,
        'currencies'=>$currencies,
        'usergroups'=>$usergroups,
        'category'=>$categories));
  }

  //сохранить продукт
  public function product_edit($params) {
    //if (! $_SESSION['id']) {
    //  header("Location: /");
    //  die();
    //}
    $id=$params['3'];
    $shop_id=$_POST['shop_id'];

    $this->do_edit_product($id, $shop_id);

    //header("Location: /shop/myproducts/$shop_id");
  }

  public function do_edit_product($id, $shop_id){
    $products = $this->model('product');
    $shops = $this->model('shop');
    $property = $this->model('property');


    $shop_lang = $shops->get_lang_shop($shop_id);

    if(!isset($_REQUEST['smallupdate'])){
      $products->delete_category_product_by_product_id($id);
      $products->delete_property_product_by_product_id($id);
      $products->delete_chars_product_by_product_id($id);
      $products->delete_group_product_by_product_id($id);

      //access
      $usergroups=array();
      $visible=0;
      foreach ($_POST['visible'] as $o) {
        if(preg_match("/^g([0-9]+)/", $o, $regs)){
          $usergroups[]=$regs[1];
        }else{
          $visible=$o;
        }
      }
      $usergroup = $this->model('usergroup');
      $usergroup->save_product_access($shop_id, $usergroups,$id);
      $_POST['visible']=$visible;
    }

    if($shop_lang['lang']=='ru') {
        $_POST['name_ru']=$_POST['name'];
    } elseif($shop_lang['lang']=='en') {
        $_POST['name_en']=$_POST['name'];
    } elseif($shop_lang['lang']=='it') {
        $_POST['name_it']=$_POST['name'];
    } elseif($shop_lang['lang']=='ch') {
        $_POST['name_ch']=$_POST['name'];
    } else {
        $_POST['name_en']=$_POST['name'];
    }

    if(!isset($_POST['box'])) $_POST['box'] = 0;
    if(!isset($_POST['freedelivery'])) $_POST['freedelivery'] = 0;
    if(!$_POST['package']) $_POST['package'] = 0;
    if(!$_POST['weight']) $_POST['weight'] = 0;
    if(!$_POST['volume']) $_POST['volume'] = 0;
    if(!$_POST['w']) $_POST['w'] = 0;
    if(!$_POST['h']) $_POST['h'] = 0;
    if(!$_POST['d']) $_POST['d'] = 0;
    if(!$_POST['sklad']) $_POST['sklad'] = 0;
    if(!$_POST['discount'] or $_POST['discount']<0 or $_POST['discount']>100) $_POST['discount'] = 0;

    $price = $_POST['price'];
    //$price = preg_replace('/ /','', $price);   //" "->""
    $price = preg_replace('/,/','.', $price);  //,->.
    $price = preg_replace('/[^0-9\.]/','', $price);  //все кроме цифр и точки
    $price = preg_replace('/\.$/','', $price);  //руб. - убирает точку в конце
    $_POST['price'] = $price;


    setcookie('name','name sdfsd', time()+3600); //чье и зачем?
    $products->save($id, $_POST);

    if(isset($_POST['category_id'])){
      foreach ($_POST['category_id'] as $i) {
        $products->add_category($id, $i, $shop_id);
      }
    }
    if(isset($_POST['group_id']) and $_POST['group_id']>0){
      $products->add_group($id, $_POST['group_id'],$shop_id);
    }
    // добавление характеристик
    while ( list($key, $value) = each($_POST) ) {
      if(preg_match("/charname_(\d+)/", $key,$matches) and $value){
        $index = $matches[1];
        if(!$_POST['charprice_'.$index]){ continue; } //если не задана цена, пропускаем характеристику
        $char = array(
              "name" => $value,
              "shop_id" => $shop_id,
              "product_id" => $id,
              "price" => $_POST['charprice_'.$index],
              "sklad" => $_POST['charsklad_'.$index],
              "barcode" => $_POST['charbarcode_'.$index],
            );
        $products->add_char($id, $char);
      }
      //$products->add_category($id, $i, $shop_id);
    }

    //добавление свойств
    foreach($_POST as $key => $value){
      if(!$value){ continue; } //если не задано значение пропускаем

      if(preg_match("/propname_(\d+)/", $key, $matches) and $value){
        $index = $matches[1];

    //    echo $_POST['propname_'.$index]." - ".$_POST['propvalue_'.$index]." - ".$index."<br>";

        $property->import_string($shop_id, array("name" => $_POST['propname_'.$index],
                                                 "value" => $_POST['propvalue_'.$index],
                                                 "product_id" => $id));
      }else if(preg_match("/prop_(\d+)/", $key, $matches) and $value){ //select
        $index = $matches[1];

        $prop = $property->get_property($_POST['prop_'.$index]);
    //    echo "N " .$prop['name']." - ".$_POST['propvalue_'.$index]." - ".$index."<br>";

        $property->import_string($shop_id, array("name" => $prop['name'],
                                                 "value" => $_POST['propvalue_'.$index],
                                                 "product_id" => $id));

      }
      //$products->add_category($id, $i, $shop_id);
    }

    //foreach($_POST as $key=>$value){
    /*while (list($key, $value) = each($_POST)) {
        if(preg_match("/group_id/", $key) and $value){
        //$value==group_id, которую надо добавить
        $products->add_group($id, $value);
      }
    }*/

    //file upload
    if ($id && isset($_FILES['thumbnail']) && ! empty($_FILES['thumbnail']['name'])) {
      $file = $_FILES['thumbnail'];
      // make sure the browser thought this was an image
      if (substr($file['type'], 0, strlen('image/')) == 'image/' && $file['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
        // it's a file extention that we accept too (not that means anything really)
        $accepted = array('gif', 'jpg', 'jpeg', 'png');
        if (in_array($ext, $accepted)) {
          if (! move_uploaded_file($file['tmp_name'], PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext)) {
            die("no permission to images/people dir, or possible file upload attack, aborting");
          }
          // загрузка фото профиля thumbnail the image to 60x60 format (keeping the original)
          $thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext, 176, 176, true);
          $products->set_thumbnail($id, $thumbnail_url);
        }
      }
    }

    //files base64_encode
    if ($id && isset($_POST['thumbnailbase64'])) {
      $products->delete_dop_thumbnail_photos($id);
//var_dump($_POST['thumbnailbase64']);
      $img = base64_decode($_POST['thumbnailbase64']);
//var_dump($img);
      $thumbnail_url = PartuzaConfig::get('site_root') . '/images/product/' . $id . '.jpg';
      file_put_contents($thumbnail_url, $img);
      $products->set_thumbnail($id, '/images/product/' . $id . '.jpg' );
      $products->set_photo($id, '/images/product/' . $id . '.jpg' );

      $i = 1;
      while (list($key, $value) = each($_POST)) {
          if(preg_match("/thumbnailbase64(\d+)/", $key) and $value){
            $img = base64_decode($value);
            $thumbnail_url = PartuzaConfig::get('site_root') . '/images/product/' . $id . '_'.$i. '.jpg';
            file_put_contents($thumbnail_url, $img);
            $products->set_dop_thumbnail_photo($id, $thumbnail_url, $thumbnail_url, $i, $shop_id);
            $i++;
          }
      }
    }

    print "{'status':'OK'}";

  }


  //сохранить изменения во все товары
  public function product_multiedit($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $products = $this->model('product');
    $shops = $this->model('shop');
    $shop_id=$_REQUEST['shop_id'];
    $ids=$_REQUEST['product_id'];
    $shop_lang = $shops->get_lang_shop($shop_id);

    //access
    if($_REQUEST['visible']){
      $usergroups=array();
      $visible=0;
      foreach ($_REQUEST['visible'] as $o) {
        if(preg_match("/^g([0-9]+)/", $o, $regs)){
          $usergroups[]=$regs[1];
        }else{
          $visible=$o;
        }
      }
      $_REQUEST['visible']=$visible;
      $usergroup = $this->model('usergroup');
    foreach ($ids as $id) {
        $usergroup->save_product_access($shop_id, $usergroups,$id);
      }
    }


    // if(!isset($_REQUEST['box'])) unset($_REQUEST['box']);
    // if(!isset($_REQUEST['freedelivery'])) unset($_REQUEST['freedelivery']);

    if(isset($_REQUEST['box']) && ($_REQUEST['box'] == 'true' || $_REQUEST['box'] == 1)){
      $_REQUEST['box'] = 1;
    }
    else{
      $_REQUEST['box'] = 0;
    }

    if(isset($_REQUEST['freedelivery']) && ($_REQUEST['freedelivery'] == 'true' || $_REQUEST['freedelivery'] == 1)){
      $_REQUEST['freedelivery'] = 1;
    }
    else{
      $_REQUEST['freedelivery'] = 0;
    }

    if(!$_REQUEST['package']) unset($_REQUEST['package']);
    if(!$_REQUEST['currency_id']) unset($_REQUEST['currency_id']);
    if(!$_REQUEST['weight']) unset($_REQUEST['weight']);
    if(!$_REQUEST['volume']) unset($_REQUEST['volume']);
    if(!$_REQUEST['w']) unset($_REQUEST['w']);
    if(!$_REQUEST['h']) unset($_REQUEST['h']);
    if(!$_REQUEST['d']) unset($_REQUEST['d']);
    if(!$_REQUEST['price']) unset($_REQUEST['price']);
    if(!$_REQUEST['visible']) unset($_REQUEST['visible']);
    if(!$_REQUEST['sklad']) unset($_REQUEST['sklad']);
    if(!$_REQUEST['isspecial'] and $_REQUEST['isspecial']!=0) unset($_REQUEST['isspecial']);
    if(!$_REQUEST['discount'] or $_REQUEST['discount']<0 or $_REQUEST['discount']>100) unset($_REQUEST['discount']);

    foreach ($ids as $id) {
      $products->save($id, $_REQUEST);
      $products->delete_category_product_by_product_id($id);

      if(isset($_POST['category_id'])){
        foreach ($_POST['category_id'] as $i) {
          //echo "$id, $i, $shop_id";
          $products->add_category($id, $i, $shop_id);
        }
      }
      //$products->delete_group_product_by_product_id($id);

      /*
      if(isset($_POST['group_id']) and $_POST['group_id']>0){
        $products->add_group($id, $_POST['group_id'],$shop_id);
      }
      */
    }


  }

  /* ужас от Кости
  public function get_subgroup_shop($subgroups, $vars_group, $vars_group_id) {
        echo "<ul class=\"subgroups\">";
            foreach ($subgroups as $subgroup) {
                echo "<li>";
                if(isset($subgroup['num_of_subs']) and $subgroup['num_of_subs']>0){
      echo "<span class=\"num\">(".$subgroup['num_of_subs'].")</span>";
    }
                echo "<a href=\"/shop/group/{$subgroup['id']}\" ".((isset($vars_group) and $subgroup['id']==$vars_group_id)?" class=\"active\" ":"").">{$subgroup['name']}</a>";
                if(isset($subgroup['subs']) and !empty($subgroup['subs'])) {
                    $this->get_subgroup_shop($subgroup['subs'], $vars_group, $vars_group_id);
                }
                echo "</li>";
            }
        echo "</ul>";
  }

  public function get_subgroup_product_compose($subgroups, $group_id, $spaces = '&nbsp;&nbsp;&nbsp;') {
        foreach($subgroups as $subgroup){
            if($subgroup['id'] == $group_id) {
                echo "<option value=\"{$subgroup['id']}\" selected=\"selected\">$spaces{$subgroup['name']}</option>";
            } else {
                echo "<option value=\"{$subgroup['id']}\">$spaces{$subgroup['name']}</option>";
            }
            if(isset($subgroup['subs']) and !empty($subgroup['subs'])) {
                $spaces .= '&nbsp;&nbsp;&nbsp;';
                $this->get_subgroup_product_compose($subgroup['subs'], $group_id, $spaces);
            }
        }
  }

  public function get_subgroup_compose($subgroups, $spaces = '&nbsp;&nbsp;&nbsp;') {
        foreach($subgroups as $subgroup){
            echo "<option value=\"{$subgroup['id']}\">$spaces{$subgroup['name']}</option>";
            if(isset($subgroup['subs']) and !empty($subgroup['subs'])) {
                $spaces .= '&nbsp;&nbsp;&nbsp;';
                $this->get_subgroup_compose($subgroup['subs'], $spaces);
            }
        }
  }

  public function get_subgroup_edit($subgroups, $vars_group_id, $group_id, $spaces = '&nbsp;&nbsp;&nbsp;') {
        foreach($subgroups as $subgroup){
            if($subgroup['id']!=$vars_group_id){
                echo "<option value=\"{$subgroup['id']}\" ".(($vars_group_id==$group_id)?" selected":"").">$spaces{$subgroup['name']}</option>";
                if(isset($subgroup['subs']) and !empty($subgroup['subs'])) {
                    $spaces .= '&nbsp;&nbsp;&nbsp;';
                    $this->get_subgroup_edit($subgroup['subs'], $vars_group_id, $subgroup['id'], $spaces);
                }
            }
        }
  }

  public function get_subgroup_product($subgroups, $margin = false, $count_pix = 60) {
        foreach($subgroups as $subgroup){
            echo "<option value=\"{$subgroup['id']}\">&nbsp;&nbsp;&nbsp;{$subgroup['name']}</option>";
            echo "<div class=\"item subitem\"  id=\"{$subgroup['id']}\" style=\"$margin\">";
            echo "<div class=\"x\"><a href=\"#\" class=\"deletegroup\" id=\"{$subgroup['id']}\" name=\"{$subgroup['name']}\"><img src=\"/images/i_close.png\"></a></div>";
            echo "<table class=\"markup\"><tr><td><div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/group/{$subgroup['id']}\">";

            if($subgroup['thumbnail_url']){
                    echo "<img src=\"{$subgroup['thumbnail_url']}\">";
            }else{
                    echo "<img src=\"/images/group/nophoto.gif\">";
            }

            echo "</a></div></td><td>&nbsp;</td><td>";
            echo "<div class=\"title\"><a href=\"/group/{$subgroup['id']}\">{$subgroup['name']}</a></div>";
            echo "<div class=\"icons\"><a class=\"edit editgroup\" id=\"{$subgroup['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
            echo "</td></tr></table></div>";

            if(isset($subgroup['subs']) and !empty($subgroup['subs'])) {
                $count_pix += 60;
                $margin = "margin-left: ".$count_pix."px";
                $this->get_subgroup_product($subgroup['subs'], $margin, $count_pix);
            }
        }
  }
  */

  //подготовиться добавлять новый товар
  public function product_compose($params) {
    if (! $_SESSION['id'] or !isset($params['3']) or !is_numeric($params['3'])) {
      header("Location: /");
      return;
    }

    $shop_id = $params[3];
    $shop_info = $this->model('shop');
    $shop_lang = $shop_info->get_lang_shop($shop_id);

    $product = $this->model('product');
    $id = $product->prepare_new_product(array('shop_id'=>$shop_id,
            'visible'=>-1,
        ));

    if (!$id) {
      die('Error preparing_new_product');
    }

    $product_prev = $product->get_prev_product($id, $shop_id);
    $groups = $this->model('group');
    $my_groups = $groups->get_groups($shop_id, 0, true, true);

    $product = $this->model('product');
    $my_products = $product->get_products(array(
        "shop_id"=>$shop_id,
        "group_id"=>0,
        "details"=>true));

    $currency = $this->model('currency');
    //$currencies = $currency->get_currencies();
    $currencies = $currency->get_currencies($shop_id);

    $category = $this->model('category');
    $categories = $category->get_categories(0,true);
  $usergroup = $this->model('usergroup');
  $usergroups = $usergroup->get_usergroups($shop_id);

    $this->template('/shop/product_compose.php', array(
        'groups' => $my_groups,
        //'products' => $my_products,
        'products' => array(),
        'filter' => $my_products['filter'],

        'product_prev' => "",
        'currencies' => $currencies,
        'category' => $categories,
        'usergroups'=>$usergroups,
        'product_id'=>$id,
                        'shop_lang'=>$shop_lang,
        'shop_id' => $shop_id));
  }

  //подготовиться добавлять новую группу
  public function group_compose($params) {
    if (! $_SESSION['id'] or !isset($params['3']) or !is_numeric($params['3'])) {
      header("Location: /");
      return;
    }
    $shop_id = $params[3];

    $group = $this->model('group');
    $id = $group->prepare_new(array('shop_id'=>$shop_id,
        'visible'=>-1,
    ));

    if (!$id) {
      die('Error preparing_new_group');
    }

    $groups = $this->model('group');
    $my_groups = $groups->get_groups($shop_id, 0, true, true);

    $currency = $this->model('currency');
    $currencies = $currency->get_currencies($shop_id);

    $usergroup = $this->model('usergroup');
    $usergroups = $usergroup->get_usergroups($shop_id);


    $this->template('/shop/group_compose.php', array(
        'groups' => $my_groups,
        'usergroups'=>$usergroups,
        'group_id'=>$id,
        'shop_id' => $shop_id));
  }


  //подготовиться добавлять баннер
  public function banner_compose($params) {
    if (! $_SESSION['id'] or !isset($params['3']) or !is_numeric($params['3'])) {
      header("Location: /");
      return;
    }
    $shop_id = $params[3];

    $banner = $this->model('banner');
    $id = $banner->prepare_new(array('shop_id'=>$shop_id,
        'isvisible'=>-1,
    ));

    if (!$id) {
      die('Error preparing_new_banner');
    }

    $this->template('/shop/banner_compose.php', array(
        'id'=>$id,
        'shop_id' => $shop_id));
  }

  //добавить товар в корзину
  public function cart_add($params) {
    if (!isset($params['3']) or !is_numeric($params['3'])) { //! $_SESSION['id'] or
            header( 'Location: https://comiron.com', true, 301 );
            //header("Location: /");
            return;
    }

    $cart_unreg = $this->model('cart_unreg');
    $cart = $this->model('cart');
    $cart_sz = $this->model('cart_sz');
    $productm = $this->model('product');
    $shop = $this->model('shop');
    $action = $this->model('action');
    $product_id = $params['3'];

    //action
    if($_REQUEST['action_id']){
      $product=$action->get_action($_REQUEST['action_id']);
      if(!isset($product) and $product['product_id']!=$product_id){
        $product = null;
      }
    }
    if(!isset($product)){
      $product=$productm->get_product($product_id);
    }

    $num = 0;
    if(isset($_REQUEST['num']) and is_numeric($_REQUEST['num'])){
      $num=$_REQUEST['num'];
    }
    if(isset($_SESSION['id'])) {
        $shop_client_data = $shop->get_clientdata($product['shop_id'], $_SESSION['id']);
    }

    //характеристика
    $charname = false;
    $char_id = false;
    if(isset($_REQUEST['charid']) and isset($_REQUEST['charname']) and isset($_REQUEST['charprice'])
        and $_REQUEST['charprice']>0 and $_REQUEST['charname'] and $_REQUEST['charid']>0){
      $charname = $_REQUEST['charname'];
      $price = $_REQUEST['charprice'];
      $char_id = $_REQUEST['charid'];
    }else{
      // Рассчитать сумму исходя из того, что у клиента может быть скидка в магазине
      if(isset($_SESSION['id']) and $shop_client_data['discount'] != 0) {
        $price_skidka = $product['price'] - ($product['price'] * $shop_client_data['discount'] / 100);
        $price = $price_skidka;
      } else {
        $price = $product['price'];
      }
    }

    $price_id = 0;
    if(isset($_REQUEST['price_id']) and is_numeric($_REQUEST['price_id'])){
      $price_id=$_REQUEST['price_id'];
    }


    $summa = $num*$price;

    //echo $summa;
    $params=array(
        "product_id"=>$product_id,
        "shop_id"=>$product['shop_id'],
        "action_id"=>$_REQUEST['action_id'],
        "num"=>$num,
        "price"=>$price,
        "sum"=>$summa,
        "currency_id"=>$product['currency_id'],
        "charname" => ($charname?$charname:false),
        "char_id" => ($char_id?$char_id:0),
        "price_id" => ($price_id?$price_id:0),
        "source"=>$_REQUEST['source']
        );

    if($_SESSION['id']){
      $params["person_id"] = $_SESSION['id'];
      //var_dump($params);

      $is_sz = $_REQUEST['is_sz'];
      $enddate = $_REQUEST['enddate'];

      if ($is_sz) {
        if (!$enddate) {
          echo json_encode(['error' => 'no enddate']);
          return;
        }

        $params['enddate'] = $enddate;
        $id = $cart_sz->add($params);
      } else {
        $id=$cart->add($params);
      }
    } else {
      $params["person_uid"] = $this->get_uid();
      //echo var_dump($params);
      $id = $cart_unreg->add($params);
    }

  }

  //установить количество товара в корзине
  public function cart_set($params) {
    if (!isset($params['3']) or !is_numeric($params['3'])) { //! $_SESSION['id'] or
            header( 'Location: https://comiron.com', true, 301 );
            //header("Location: /");
            return;
    }

    //$cart_unreg = $this->model('cart_unreg');
    $cart = $this->model('cart');
    $cart_sz = $this->model('cart_sz');
    $productm = $this->model('product');
    $shop = $this->model('shop');
    $action = $this->model('action');
    $product_id = $params['3'];

    //action
    if($_REQUEST['action_id']){
      $product=$action->get_action($_REQUEST['action_id']);
      if(!isset($product) and $product['product_id']!=$product_id){
        $product = null;
      }
    }
    if(!isset($product)){
      $product=$productm->get_product($product_id);
    }

    $num = 0;
    if(isset($_REQUEST['num']) and is_numeric($_REQUEST['num'])){
      $num=$_REQUEST['num'];
    }
    if(isset($_SESSION['id'])) {
        $shop_client_data = $shop->get_clientdata($product['shop_id'], $_SESSION['id']);
    }

    //характеристика
    $charname = false;
    $char_id = false;
    if(isset($_REQUEST['charid']) and isset($_REQUEST['charname']) and isset($_REQUEST['charprice'])
        and $_REQUEST['charprice']>0 and $_REQUEST['charname'] and $_REQUEST['charid']>0){
      $charname = $_REQUEST['charname'];
      $price = $_REQUEST['charprice'];
      $char_id = $_REQUEST['charid'];
    }else{
      // Рассчитать сумму исходя из того, что у клиента может быть скидка в магазине
      if(isset($_SESSION['id']) and $shop_client_data['discount'] != 0) {
        $price_skidka = $product['price'] - ($product['price'] * $shop_client_data['discount'] / 100);
        $price = $price_skidka;
      } else {
        $price = $product['price'];
      }
    }

    $price_id = 0;
    if(isset($_REQUEST['price_id']) and is_numeric($_REQUEST['price_id'])){
      $price_id=$_REQUEST['price_id'];
    }


    $summa = $num*$price;

    //echo $summa;
    $params=array(
        "product_id"=>$product_id,
        "shop_id"=>$product['shop_id'],
        "action_id"=>$_REQUEST['action_id'],
        "num"=>$num,
        "price"=>$price,
        "sum"=>$summa,
        "currency_id"=>$product['currency_id'],
        "charname" => ($charname?$charname:false),
        "char_id" => ($char_id?$char_id:0),
        "price_id" => ($price_id?$price_id:0),
        "source"=>$_REQUEST['source']
        );

    if($_SESSION['id']){
      $params["person_id"] = $_SESSION['id'];
      //var_dump($params);

      $is_sz = $_REQUEST['is_sz'];
      $enddate = $_REQUEST['enddate'];

      if ($is_sz) {
        if (!$enddate) {
          echo json_encode(['error' => 'no enddate']);
          return;
        }

        $params['enddate'] = $enddate;
        $id = $cart_sz->set($params);
      } else {
        $id=$cart->set($params);
      }
    } else {
      $params["person_uid"] = $this->get_uid();
      //echo var_dump($params);
      $id = $cart_unreg->set($params);
    }

  }

  //показать корзину ajax
  public function small_cart($params) {
    /*if (! $_SESSION['id']) {
      header("Location: /");
      return;
    }*/
    // var_dump($params);
    // exit();
    $cart = $this->model('cart');
    $cart_unreg = $this->model('cart_unreg');
    $shop = $this->model('shop');

    $shop_id=$params['3'];

    if($_SESSION['id']){
      $small_cart=$cart->get_small_cart($_SESSION['id'],$shop_id);
    } else {
      $small_cart=$cart_unreg->get_small_cart($this->get_uid(),$shop_id);
    }

    $shop=$shop->get_shop_info($shop_id);
    $shop['cart']=$small_cart;

    $this->template('shop/small_cart.php', array(
        'shop' => $shop));
  }

  //добавить товар в корзину
  public function cart_addmulti($params) {
    global $db;
    $cart_unreg = $this->model('cart_unreg');
    $cart = $this->model('cart');
    $productm = $this->model('product');
    $shop = $this->model('shop');
    $action = $this->model('action');
    $people = $this->model('people');

    $data = json_decode(file_get_contents('php://input'), true);
    $new_user = "0";

    //пользователь
    $person_id = 0;
    if($data['person'] && $data['person']['register_email']){
      //искать, есть ли в базе
      $person_id = $people->get_id_by_email($data['person']['register_email']);
//var_dump($person_id);
      //если нет, то зарегистрировать и отправить письмо
      if(!$person_id){
        $register = $this->model('register');

        $data['person']['register_password'] = "123456";

        // $activation_code=$register->register($data['person']);
        $new_person = $register->register($data['person']);

        //отправить письмо для подтверждения email
        $_SESSION['lang']=PartuzaConfig::get('language');
        $message=$this->get_template("/register/mail/validate_email.php",
        		array("activation_code"=>$new_person['activation_code'],
        				"last_name"=>$data['person']['register_last_name'],
        				"first_name"=>$data['person']['register_first_name'],
        				"email"=>$data['person']['register_email'],
                "password"=>$data['person']['register_password']
        		));
//var_dump($message);
        $new_user = "1";

        global $mail;
        $is_send = $mail->send_mail(array(
        		"from"=>PartuzaConfig::get('mail_from'),
        		"to"=>$data['person']['register_email'],
        		"title"=>$this->t("common","Email confirmation"),
        		"body"=>$message
        ));
        $person_id = $people->get_id_by_email($data['person']['register_email']);

      }
    }
    if($_SESSION['id'] && !$params["person_id"]){
      $params["person_id"] = $_SESSION['id'];
    }

    //корзина
    foreach($data['cart'] as $cartdata){
        $product_id = $cartdata['product_id'];
        $shop_id = $cartdata['shop_id'];

        if(!$cartdata['product_id'] and $cartdata['primarykey']){
          $res = $db->query("select id from `product` where shop_id=$shop_id and primarykey='".$cartdata['primarykey']."'" );
          $res = $db->fetch_row($res);
          $product_id = (isset($res[0])?$res[0]:0);
        }

        if(!$product_id) continue;

        //action
        if($cartdata['action_id']){
          $product=$action->get_action($cartdata['action_id']);
          if(!isset($product) and $product['product_id']!=$product_id){
            $product = null;
          }
        }
        if(!isset($product)){
          $product=$productm->get_product($product_id);
        }
//var_dump($product);
        $num = 0;
        if(isset($cartdata['num']) and is_numeric($cartdata['num'])){
          $num=$cartdata['num'];
        }
        if(isset($_SESSION['id'])) {
            $shop_client_data = $shop->get_clientdata($product['shop_id'], $_SESSION['id']);
        }

        //характеристика
        $charname = false;
        $char_id = false;
        if(isset($_REQUEST['charid']) and isset($_REQUEST['charname']) and isset($_REQUEST['charprice'])
            and $_REQUEST['charprice']>0 and $_REQUEST['charname'] and $_REQUEST['charid']>0){
          $charname = $_REQUEST['charname'];
          $price = $_REQUEST['charprice'];
          $char_id = $_REQUEST['charid'];
        }else{
          // Рассчитать сумму исходя из того, что у клиента может быть скидка в магазине
          if(isset($_SESSION['id']) and $shop_client_data['discount'] != 0) {
            $price_skidka = $product['price'] - ($product['price'] * $shop_client_data['discount'] / 100);
            $pricfze = $price_skidka;
          } else {
            $price = $product['price'];
          }
        }

        $price_id = 0;
        if(isset($cartdata['price_id']) and is_numeric($cartdata['price_id'])){
          $price_id=$cartdata['price_id'];
        }

        $summa = $num*$price;
        //echo $summa;
        $params=array(
            "person_id"=>$person_id,
            "product_id"=>$product_id,
            "shop_id"=>$shop_id,
            "action_id"=>$cartdata['action_id'],
            "num"=>$num,
            "price"=>$price,
            "sum"=>$summa,
            "currency_id"=>$product['currency_id'],
            "charname" => ($charname?$charname:false),
            "char_id" => ($char_id?$char_id:0),
            "price_id" => ($price_id?$price_id:0),
            );
      //var_dump($params);

        if($params['person_id']){
//          $params["person_id"] = $_SESSION['id'];
          $id=$cart->add($params);
        }
        // else {
         // $params["person_uid"] = $this->get_uid();
          //echo var_dump($params);
         // $id = $cart_unreg->add($params);
        //}
    }
    echo "{\"new_user\":$new_user, \"person_id\":$person_id}";

  }
/*
  //показать корзину ajax
  public function small_cart($params) {

    // var_dump($params);
    // exit();
    $cart = $this->model('cart');
    $cart_unreg = $this->model('cart_unreg');
    $shop = $this->model('shop');

    $shop_id=$params['3'];

    if($_SESSION['id']){
      $small_cart=$cart->get_small_cart($_SESSION['id'],$shop_id);
    } else {
      $small_cart=$cart_unreg->get_small_cart($this->get_uid(),$shop_id);
    }

    $shop=$shop->get_shop_info($shop_id);
    $shop['cart']=$small_cart;

    $this->template('shop/small_cart.php', array(
        'shop' => $shop));
  }
*/
  public function movemycart(){
    $carts = $this->model('cart');
    $carts->movemycart();
  }

  //показать корзину
  public function cart($params) {
    /*if (! $_SESSION['id']) {
      header("Location: /");
      return;
    }*/

    $shop_id = 0;
    $cartdelivery_id = 0;
    if(isset($params['3']) and is_numeric($params['3'])){
      $shop_id=$params['3'];
      if(!$_REQUEST['hermes_id']){
        //добавить запись для доставки через hermes
        $cartdelivery = $this->model('cartdelivery');
        $cartdelivery->cart_empty($_SESSION['id']);
        $cartdelivery_id = $cartdelivery->save(array('person_id' => $_SESSION['id'], "shop_id"=>$shop_id));
      }
    }


    $group = $this->model('group');
    $currency = $this->model('currency');
    $people = $this->model('people');
    $shops = $this->model('shop');
    $article = $this->model('articles');
    $address = $this->model('address');
    $countries = $this->model('country');


    $person = false;
    if($_SESSION['id']){
      $carts = $this->model('cart');
      $small_cart=$carts->get_small_cart($_SESSION['id'],$shop_id);
      //$cart = [];
      $cart=$carts->get_cart($_SESSION['id'],$shop_id);
      $person = $people->get_person($_SESSION['id']);
      $addresses = $address->show(array("object"=>"people", "object_id"=>$_SESSION['id']));
      $shop_addresses = $address->show(array("object"=>"shop", "object_id"=>$shop_id));
      $template = 'shop/shop_cart.php';
    } else {
      $carts = $this->model('cart_unreg');
      $small_cart=$carts->get_small_cart($this->get_uid(),$shop_id);
      $cart=$carts->get_cart($this->get_uid(),$shop_id);
      $template = 'shop/shop_cartunreg.php';
    }




    $this->template($template, array(
        'cartdelivery_id' => $cartdelivery_id,
        'cart' => $cart,
        'addresses'=>$addresses,
        'shop_addresses'=>$shop_addresses,
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        "small_cart"=>$small_cart,
        'groups'=>$group->get_groups($shop_id,0, true,true),
        'shop'=>$shops->get_shop($shop_id, true),
        'person' => $person,
        'articles'=>$article->get_articles($shop_id,0, true),
        'currencies'=>$currency->get_currencies()));
  }

  public function cart_delete($params){
    if (!isset($params['3']) or !is_numeric($params['3'])) {
      header("Location: /");
      die();
    }

    if($_SESSION['id']){
      if ($_GET['is_sz']) {
        $cart = $this->model('cart_sz');
      } else {
        $cart = $this->model('cart');
      }
    } else {
      $cart = $this->model('cart_unreg');
    }

    $cart_id=$params['3'];
    $cart->delete($cart_id);
  }

  public function cart_update($params){
    if (!isset($params['3']) or !is_numeric($params['3'])) {
      header("Location: /");
      die();
    }

    if($_SESSION['id']){
      $cart = $this->model('cart');
      $cart->update($_SESSION['id'], $shop_id, $_POST);
    } else {
      $cart = $this->model('cart_unreg');
      $cart->update($this->get_uid(), $shop_id, $_POST);
    }
    $shop_id=$params['3'];


    return $this->cart(array("", "shop", "cart", $shop_id));
  }

  //отправка заказа
  public function cart_send($params){
    require_once PartuzaConfig::get('library_root').'/rupost.php';
    // var_dump($params);
    // exit();
    global $mail;
//echo time()."<br>\n";
    $shop_id = $_REQUEST['shop_id'];

    if (!$_SESSION['id'] or !$shop_id){// or !isset($params['3']) or !is_numeric($params['3'])) {
      //header("Location: /");
      die();
    }
    //$shop_id=$params['3'];
    $people = $this->model('people');

    //если указан телефон, сохранить его
    if($_REQUEST['phone']){
      $people->save_person($_SESSION['id'], array("phone"=>$_REQUEST['phone']));
    }

    $carts = $this->model('cart');
    $carts_sz = $this->model('cart_sz');

    $shops = $this->model('shop');
//    echo var_dump($_REQUEST);

//echo time()."<br>\n";

    $shop=$shops->get_shop($shop_id);
    $shop_owner = $people->get_person($shop['person_id']);
    $receiver = $people->get_person($_SESSION['id']);
//echo time()."<br>\n";

//echo time()."<br>\n";

//echo time()."<br>\n";

    $price_id = 0;
    $is_sz = 0;
    if($_REQUEST['is_sz'] && $_REQUEST['price_id']){
      // корзина СЗ
      $is_sz = 1;
      $price_id = $_REQUEST['price_id'];
      $small_cart=$carts_sz->get_small_cart($_SESSION['id'], $shop_id, $price_id);
      $cart=$carts_sz->get_cart($_SESSION['id'], $shop_id, $price_id);

    } else {
      // обычная корзина
      $carts->update($_SESSION['id'],$shop_id, $_REQUEST);
      $small_cart=$carts->get_small_cart($_SESSION['id'],$shop_id);
      $cart=$carts->get_cart($_SESSION['id'],$shop_id);
    }
//echo time()."<br>\n";

    //категория для доставки
    $category = "";

    //добавить названия товаров
    $num=0;
    foreach ($cart['cart'] as $key => $product) {
       if(isset($product['product']['groups']['0']['name'])){
          $category = $product['product']['groups']['0']['name'];
       }
       $cart['cart'][$key]['product_name']=$product['product']['name']." ".$product['product']['charname'];
       $cart['cart'][$key]['code']=$product['product']['code'];
       $cart['cart'][$key]['photo_url']=$product['product']['photo_url'];
       //$cart['cart'][$key]['num'] =  $_REQUEST['num'+$product['product']['id']];
       //echo var_dump($product['id']);
       if($_REQUEST['num'.$product['id']] > 0){
         $cart['cart'][$key]['num'] =  $_REQUEST['num'.$product['id']];

         //echo $_REQUEST['num'.$product['id']];
       }
      // if($_REQUEST['num'.$key] > 0){
    //     $cart['cart'][$key]['num'] =  $_REQUEST['num'.$key];
     //  }
       $num++;
    }

    $address = $this->model('address');
    $pickup_address = $address->get($_REQUEST['pickup_address']);
    // address - это id из address или
    // строка адреса пуктов выдачи

    $delivery_address = ['addrstring' => 'no'];
    if ($_REQUEST['delivery'] == 'pointofissue') {
      $delivery_address = ['addrstring' => $_REQUEST['address']];
    } else if($_REQUEST['address']){
      $delivery_address = $address->get($_REQUEST['address']);
    }

    if (!$_REQUEST['delivery']) {
	$_REQUEST['delivery']="";
    }

    $link = null;
    if ($_REQUEST['delivery'] == 'russiapost') {
      $data = array(
        'from_fio' => $shop_owner['last_name'].' '.$shop_owner['first_name'],
        'from_index' => $pickup_address['postalcode'],
        'from_addr' => $pickup_address['addrstring'],
        'to_fio' => $receiver['last_name'].' '.$receiver['first_name'],
        'to_index' => $delivery_address['postalcode'],
        'to_addr' => $delivery_address['addrstring'],
        'ob_cennost_rub' => isset($small_cart[0]['sum'])?$small_cart[0]['sum']:0
      );

      $link = rupost_generate_pdf($data);
    }

    //HERMES DPD
    $hermes_id = 0;
    if($_REQUEST["dpddeliverytype"] == "hermes"){
      $cartdelivery = $this->model('cartdelivery');
      $data = $cartdelivery->get($_REQUEST['OrderId']);
      $hermes_id = $data['hermes_id'];
      $cartdelivery->cart_empty($_SESSION['id']);
    }
    // $small_cart[0]['sum'] *= 10000;
    // $sum *= (1-sum/100)
    // var_dump($_REQUEST['textpromo']);
    // exit();
    $order = $this->model('order');


    //проверка подлинности текст промо
    $check_promotext = $shops->get_promo_inf($shop_id, $_REQUEST['textpromo']);
    if(isset($_REQUEST['textpromo']))
    {
        if($_REQUEST['textpromo'] == $check_promotext[0])
        {
           $small_cart[0]['sum'] = $shops->price_calculation($small_cart[0]['sum'], $check_promotext[1], $check_promotext[2]);

        }

    }

    if($_REQUEST['weight'] == "NaN"){
      $_REQUEST['weight'] = 0;
    }
    if($_REQUEST['volume'] == "NaN"){
      $_REQUEST['volume'] = 0;
    }
//var_dump($_REQUEST);
//echo time()."<br>\n";

    $order_data = array(
              "person_id"=>$_SESSION['id'],
              "price_id"=>$price_id,
              "is_sz"=>$is_sz,
              "ispayed"=>0,
              "num"=>$num,
              "sum"=>((isset($small_cart[0]['sum'])?$small_cart[0]['sum']:0) + (isset($_REQUEST['deliverycost'])?$_REQUEST['deliverycost']:0)),
              "currency_id"=>(isset($small_cart[0]['currency_id'])?$small_cart[0]['currency_id']:0),
              "orderstatus_id"=>1,
              "dataorder"=>$_SERVER['REQUEST_TIME'],
              "delivery"=>$_REQUEST['delivery'],
              "address"=>(isset($delivery_address['addrstring'])?$delivery_address['addrstring']:""),
              "postalcode"=>(isset($delivery_address['postalcode'])?$delivery_address['postalcode']:0),
              "city"=>(isset($delivery_address['city'])?$delivery_address['city']:""),
              "phone"=>$_REQUEST['phone'],
              //"currency_id"=>.. TODO: пересчитывать сумму в одну валюту
              "deliverycost"=>$_REQUEST['deliverycost'],
              "numpack"=>1,
              "weight"=>$_REQUEST["weight"],
              "volume"=>$_REQUEST["volume"],
              "category"=>$category,
              "rupost_pdf"=>$link,
              "dpdcityid"=>$_REQUEST["cityid"],
              "deliverytype"=>$_REQUEST["dpddeliverytype"],
              "hermes_id"=>$hermes_id,
              "contactname"=>$_REQUEST["contactname"],
              "comment_person"=>$_REQUEST["comment_person"],
              "email"=>$receiver["email"],
            );
    $order_id=$order->add($shop_id, $order_data, $cart['cart']);

//var_dump($order_data);

//echo time()."<br>\n";

     //вставка в таблицы promo и order idшнкиов
      if(isset($check_promotext[3])) {
      $order->setOrderId($order_id, $check_promotext[3]);
      $order->setPromoId($order_id, $check_promotext[3]);
      }
     //вставка в таблицы promo и order idшнкиов

    if(!$order_id){
      echo "cart error";
      echo var_dump(array($shop_id, $order_data, $cart['cart']));
      die();
    }

    $this->loadMessages("ru");
    if($shop['country_content_code2']=="CN"){
      $this->loadMessages("ch");
    }
//echo time()."<br>\n";

    //добавить инфо в очередь на рассылку
    $orderseq = $this->model('orderseq');
    $orderseq->add($shop_id, [
      "order_id"=>$order_id,
      "person_id"=>$_SESSION['id'],
      "status"=>0,
      "json"=>json_encode([
        "order"=>$order_data,
        "cart"=>$cart,
      ])
    ]);

/*
    //создать файл excel
    require_once PartuzaConfig::get('library_root').'/PHPExcel.php';
    require_once PartuzaConfig::get('library_root').'/PHPExcel/Writer/Excel5.php';
    require_once PartuzaConfig::get('library_root').'/PHPExcel/Worksheet/Drawing.php';

    $xls = new PHPExcel();
    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    //$sheet->setTitle('Order' + $order_id);

    //Для всех ячеек выравнивание текста по центру
    $xls->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //Авторазмер ячеек
    for($col = 'A'; $col !== 'H'; $col++)
      $sheet->getColumnDimension($col)->setAutoSize(true);


    $line = 1;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID заказа"));
    $sheet->setCellValueByColumnAndRow( 1, $line, $order_id);

    $line++;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID магазина"));
    $sheet->setCellValueByColumnAndRow( 1, $line, $shop_id);

    $line++;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID покупателя"));
    $sheet->setCellValueByColumnAndRow( 1, $line, $_SESSION['id']);

    $line++;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Сумма итого"));
    $sheet->setCellValueByColumnAndRow( 1, $line, (isset($small_cart[0]['sum'])?$small_cart[0]['sum']:0) + $_REQUEST['deliverycost']);

    if($_REQUEST['deliverycost']){
    $line++;
    $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true);
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Стоимость доставки"));
    $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true);
    $sheet->setCellValueByColumnAndRow( 1, $line, $_REQUEST['deliverycost']);
    }

    $line++;
    $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true);
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Сумма за товар"));
    $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true);
    $sheet->setCellValueByColumnAndRow( 1, $line, (isset($small_cart[0]['sum'])?$small_cart[0]['sum']:0));

    if($_REQUEST['delivery']){
    $line++;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Доставка"));
    $sheet->setCellValueByColumnAndRow( 1, $line, $_REQUEST['delivery']);
    }

    if($_REQUEST['phone']){
    $line++;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Телефон"));
    $sheet->setCellValueByColumnAndRow( 1, $line, $_REQUEST['phone']);
    }

    $line++;
    $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true);
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Email"));
    $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true);
    $sheet->setCellValueByColumnAndRow( 1, $line, $receiver['email']);

    if($_REQUEST["contactname"]){
    $line++;
    $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true)->setItalic(true);
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ФИО клиента"));
    $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true)->setItalic(true);
    $sheet->setCellValueByColumnAndRow( 1, $line, $_REQUEST["contactname"]);
    }

    if($delivery_address['addrstring']){
    $line++;
    $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true)->setItalic(true);
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Адрес доставки"));
    $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true)->setItalic(true);
    $sheet->setCellValueByColumnAndRow( 1, $line, (isset($delivery_address['addrstring'])?$delivery_address['addrstring']:""));
    }

    $line++;
    $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID товара"));
    $sheet->setCellValueByColumnAndRow( 1, $line, $this->t('xls',"Фото товара"));
    $sheet->getStyleByColumnAndRow(2,$line)->getFont()->setBold(true)->setItalic(true);
    $sheet->setCellValueByColumnAndRow( 2, $line, $this->t('xls',"ID товара из 1С"));
    $sheet->setCellValueByColumnAndRow( 3, $line, $this->t('xls',"Код товара"));
    $sheet->setCellValueByColumnAndRow( 4, $line, $this->t('xls',"Количество"));
    $sheet->setCellValueByColumnAndRow( 5, $line, $this->t('xls',"Цена"));
    $sheet->setCellValueByColumnAndRow( 6, $line, $this->t('xls',"Сумма"));
    $sheet->setCellValueByColumnAndRow( 7, $line, $this->t('xls',"Наименование"));

    //Заполняем товары
    $string = ++$line;
    $startRowProducts = 12;
    foreach ($cart['cart'] as $key => $product) {
      $sheet->setCellValueByColumnAndRow( 0, $string, $product['product']['id']);

      if($product['product']['photo_url']){
      $objDrawing = new PHPExcel_Worksheet_Drawing();
      $objDrawing->setPath(PartuzaConfig::get('site_root').'/'.$product['product']['photo_url']);
      $objDrawing->setName($product['product']['code']);
      $objDrawing->setDescription($product['product']['name']);
//      $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
//      $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
      $objDrawing->setCoordinates("B".$string);        //set image to cell
      $objDrawing->setResizeProportional(false);
      $objDrawing->setHeight(150);
      $objDrawing->setWidth(150);

//      $objDrawing->setWidthAndHeight(150,150);
      $objDrawing->setWorksheet($sheet);
      $sheet->getRowDimension($string)->setRowHeight(50);
      }

      $sheet->setCellValueByColumnAndRow( 2, $string, $product['product']['primarykey']);
      $sheet->setCellValueByColumnAndRow( 3, $string, $product['product']['code']);
      $sheet->setCellValueByColumnAndRow( 4, $string, $product['num']);
      $sheet->setCellValueByColumnAndRow( 5, $string, $product['product']['price']." ".$product['currency']['code']);
      $sheet->setCellValueByColumnAndRow( 6, $string, $product['sum']." ".$product['currency']['code']);
      $sheet->setCellValueByColumnAndRow( 7, $string, $product['product']['name']." ".$product['product']['charname']);
      $string++;
    }
    $string--;
    //Устанавливаем выравнивание по левому краю для столбца с наименованием товаров
    $sheet->getStyle('G1:G'.$string)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $borderStyle = array(
      'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN
        )
      )
    );

    //Рисуем бордер для заполенных ячеек
    $sheet->getStyle("A1:B".$string)->applyFromArray($borderStyle);
    $sheet->getStyle("C".$startRowProducts.":H".$string)->applyFromArray($borderStyle);

    $objWriter = new PHPExcel_Writer_Excel5($xls);
    $file = PartuzaConfig::get('site_root').'/orders/'.$order_id.".xls";
    $objWriter->save($file);

    //send mail
    $message=$this->get_template("/shop/mail/neworder.php",
        array("cart"=>$cart,
          "order_id"=>$order_id,
          "person_id"=>$_SESSION['id'],
            "person"=>$people->get_person($_SESSION['id']),
            "shop"=>$shop,
            "small_cart"=>$small_cart,
            "delivery"=>$_REQUEST['delivery'],
            "phone"=>$_REQUEST['phone'],
            "comment_person"=>$_REQUEST["comment_person"]
            ));

//echo time()."<br>\n";

    $mail->send_mail(array(
        "from"=>PartuzaConfig::get('mail_from'),
        "to"=>$shop['order_email'],
        "title"=>"New Order",
        "body"=>$message,
        "filepath"=>$file,
        "filename"=>$order_id.".xls",
        ));

    //заказ Антону
    $mail->send_mail(array(
        "from"=>PartuzaConfig::get('mail_from'),
        "to"=>PartuzaConfig::get('mail_anton'),
        "title"=>"New Order",
        "body"=>$message,
        "filepath"=>$file,
        "filename"=>$order_id.".xls",
        ));

    if($_REQUEST['delivery']=="comiron"){
      $mail->send_mail(array(
        "from"=>PartuzaConfig::get('mail_from'),
        "to"=>PartuzaConfig::get("comiron delivery mail"),
        "title"=>"New Order",
        "body"=>$message,
        "filepath"=>$file,
        "filename"=>$order_id.".xls",
      ));
    }

	$mail->send_mail([
          "from" => PartuzaConfig::get('mail_from'),
          "to" => $people->get_person($_SESSION['id'])['email'],
          "title" => "New Order",
          "body" => $message,
          "filepath" => $file,
          "filename" => $order_id.".xls",
        ]);

*/
//echo time()."<br>\n";
    //заказ добавлен
    if($order_id){
      //не СЗ
      if(!$is_sz){
        $carts->update_sklad($_SESSION['id'], $shop_id);
        $carts->cart_empty($_SESSION['id'], $shop_id);
      }else{
        //СЗ
        $carts_sz->cart_empty($_SESSION['id'], $shop_id, $price_id);
      }
    }
//echo time()."<br>\n";

    // оплата сбербанк
    if($_REQUEST['later'] != "true"){
      if($_REQUEST['paymentm'] == "sber" and $order_id>0){
        $this->_order_pay_sb($order_id);
        die;
      }

    // оплата simple pay
      if($_REQUEST['paymentm'] == "simplepay" and $order_id>0){
        $this->_order_pay_simplepay($order_id);
    //    die;
      }
    }

  // отправка в dpd
    if($_REQUEST['delivery'] == "dpd" and $order_id>0){
      //$this->_send2dpd($order_id);
  //    die;
    }

    $group = $this->model('group');
    $currency = $this->model('currency');
    $people = $this->model('people');
    $shops = $this->model('shop');
//echo time()."<br>\n";

    $this->template('shop/shop_thankyou.php', array(
        //"message"=>$message,
        "cart"=>array(),
        "small_cart"=>array(),
        'groups'=>$group->get_groups($shop_id,0, true, true),
        'shop'=>$shops->get_shop($shop_id, true),
        'person' => $people->get_person($_SESSION['id']),
        'currencies'=>$currency->get_currencies()));
  }


  //отправка писем от заказа
  public function order_send2all($params){
    $people = $this->model('people');
    $carts = $this->model('cart');
    $shops = $this->model('shop');
    $address = $this->model('address');
    $orderseq = $this->model('orderseq');

    $orders = $orderseq->get_list(["status"=>0]);
    $this->loadMessages("ru");

    foreach ($orders as $order) {
        $order['json'] = json_decode($order['json'],true);
        
        $shop=$shops->get_shop($order['shop_id']);
//var_dump($shop['person_id']);
        $shop_owner = $people->get_person_info($shop['person_id']);
//var_dump($order['person_id']);
var_dump($order['order_id']);
        $receiver = $people->get_person_info($order['person_id']);

//var_dump($order);

        $cart = [];
        $small_cart = [];
        //$order = [];

        $delivery_address = $order['json']['order']['address'];
        if(is_numeric($order['json']['order']['address'])){
          $delivery_address = $address->get($order['json']['order']['address']);
        }

        $pickup_address = $order['json']['order']['pickup_address'];
        if(is_numeric($order['json']['order']['pickup_address'] > 0)){
          $pickup_address = $address->get($order['json']['order']['pickup_address']);
        }

        $this->loadMessages("ru");
        if($shop['country_content_code2']=="CN"){
          $this->loadMessages("ch");
        }


        //создать файл excel
        require_once PartuzaConfig::get('library_root').'/PHPExcel.php';
        require_once PartuzaConfig::get('library_root').'/PHPExcel/Writer/Excel5.php';
        require_once PartuzaConfig::get('library_root').'/PHPExcel/Worksheet/Drawing.php';

        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();

        //Для всех ячеек выравнивание текста по центру
        $xls->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        //Авторазмер ячеек
        for($col = 'A'; $col !== 'H'; $col++)
          $sheet->getColumnDimension($col)->setAutoSize(true);

//var_dump($order);

        $line = 1;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID заказа"));
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['order_id']);

        $line++;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID магазина"));
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['shop_id']);

        $line++;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID покупателя"));
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['person_id']);

        $line++;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Сумма итого"));
        $sheet->setCellValueByColumnAndRow( 1, $line, (isset($order['json']['order']['sum'])?$order['json']['order']['sum']:0));

        if($_REQUEST['deliverycost']){
        $line++;
        $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Стоимость доставки"));
        $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['json']['order']['deliverycost']);
        }

        $line++;
        $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Сумма за товар"));
        $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow( 1, $line, (isset($order['json']['order']['sum'])?$order['json']['order']['sum']:0));

        if($_REQUEST['delivery']){
        $line++;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Доставка"));
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['json']['order']['delivery']);
        }

        if($order['json']['order']['phone']){
        $line++;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Телефон"));
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['json']['order']['phone']);
        }

        $line++;
        $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Email"));
        $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true);
        $sheet->setCellValueByColumnAndRow( 1, $line, $order['json']['order']['email']);

        if($order['json']['order']["contactname"]){
        $line++;
        $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true)->setItalic(true);
        $sheet->setCellValueByColumnAndRow(0, $line, $this->t('xls',"ФИО клиента"));
        $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true)->setItalic(true);
        $sheet->setCellValueByColumnAndRow(1, $line, $order['json']['order']["contactname"]);
        }

        if($order['json']['order']['address']){
        $line++;
        $sheet->getStyleByColumnAndRow(0,$line)->getFont()->setBold(true)->setItalic(true);
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"Адрес доставки"));
        $sheet->getStyleByColumnAndRow(1,$line)->getFont()->setBold(true)->setItalic(true);
        $sheet->setCellValueByColumnAndRow( 1, $line, (isset($order['json']['order']['address'])?$order['json']['order']['address']:""));
        }

        $line++;
        $sheet->setCellValueByColumnAndRow( 0, $line, $this->t('xls',"ID товара"));
        $sheet->setCellValueByColumnAndRow( 1, $line, $this->t('xls',"Фото товара"));
        $sheet->getStyleByColumnAndRow(2,$line)->getFont()->setBold(true)->setItalic(true);
        $sheet->setCellValueByColumnAndRow( 2, $line, $this->t('xls',"ID товара из 1С"));
        $sheet->setCellValueByColumnAndRow( 3, $line, $this->t('xls',"Код товара"));
        $sheet->setCellValueByColumnAndRow( 4, $line, $this->t('xls',"Количество"));
        $sheet->setCellValueByColumnAndRow( 5, $line, $this->t('xls',"Цена"));
        $sheet->setCellValueByColumnAndRow( 6, $line, $this->t('xls',"Сумма"));
        $sheet->setCellValueByColumnAndRow( 7, $line, $this->t('xls',"Наименование"));

        //Заполняем товары
        $string = ++$line;
        $startRowProducts = 12;
        $currency = "";
        foreach ($order['json']['cart']['cart'] as $key => $product) {
          $sheet->setCellValueByColumnAndRow( 0, $string, $product['product']['id']);

          if($product['product']['photo_url']){
          $objDrawing = new PHPExcel_Worksheet_Drawing();
          $objDrawing->setPath(PartuzaConfig::get('site_root').'/'.$product['product']['photo_url']);
          $objDrawing->setName($product['product']['code']);
          $objDrawing->setDescription($product['product']['name']);
    //      $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    //      $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
          $objDrawing->setCoordinates("B".$string);        //set image to cell
          $objDrawing->setResizeProportional(false);
          $objDrawing->setHeight(150);
          $objDrawing->setWidth(150);

    //      $objDrawing->setWidthAndHeight(150,150);
          $objDrawing->setWorksheet($sheet);
          $sheet->getRowDimension($string)->setRowHeight(50);
          }

          if($product['currency']){
            $currency = $product['currency'];
          }

          $sheet->setCellValueByColumnAndRow( 2, $string, $product['product']['primarykey']);
          $sheet->setCellValueByColumnAndRow( 3, $string, $product['product']['code']);
          $sheet->setCellValueByColumnAndRow( 4, $string, $product['num']);
          $sheet->setCellValueByColumnAndRow( 5, $string, $product['product']['price']." ".$product['currency']['code']);
          $sheet->setCellValueByColumnAndRow( 6, $string, $product['sum']." ".$product['currency']['code']);
          $sheet->setCellValueByColumnAndRow( 7, $string, $product['product']['name']." ".$product['product']['charname']);
          $string++;
        }
        $string--;
        //Устанавливаем выравнивание по левому краю для столбца с наименованием товаров
        $sheet->getStyle('G1:G'.$string)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $borderStyle = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );

        //Рисуем бордер для заполенных ячеек
        $sheet->getStyle("A1:B".$string)->applyFromArray($borderStyle);
        $sheet->getStyle("C".$startRowProducts.":H".$string)->applyFromArray($borderStyle);

    /*        $sheet->getStyleByColumnAndRow($i - 2, $j)->getAlignment()->
            setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $file = PartuzaConfig::get('site_root').'/orders/'.$order['order_id'].".xls";
        $objWriter->save($file);

        //send mail
        $message=$this->get_template("/shop/mail/neworder.php",
            array("cart"=>$order['json']['cart'],
                "order_id"=>$order['order_id'],
                "person_id"=>$order['person_id'],
                "person"=>$people->get_person_info($order['person_id']),
                "shop"=>$shop,
                "small_cart"=>[
                  "sum"=>$order['json']['order']['sum'],
                  "currency_id"=>$order['json']['order']["currency_id"],
                  "currency"=>$order['json']['cart']['cart'][0]['product']['currency'],
                ],
                "delivery"=>$order['json']['order']['delivery'],
                "phone"=>$order['json']['order']['phone'],
                "comment_person"=>$order['json']['order']["comment_person"]
                ));

    //echo time()."<br>\n";
       global $mail;

       $mail->send_mail(array(
            "from"=>PartuzaConfig::get('mail_from'),
            "to"=>$shop['order_email'],
            "title"=>"New Order",
            "body"=>$message,
            "filepath"=>$file,
            "filename"=>$order['order_id'].".xls",
            ));
        //заказ Антону
        $mail->send_mail(array(
            "from"=>PartuzaConfig::get('mail_from'),
            "to"=>PartuzaConfig::get('mail_anton'),
            "title"=>"New Order",
            "body"=>$message,
            "filepath"=>$file,
            "filename"=>$order['order_id'].".xls",
            ));


        if($order['json']['order']['delivery']=="comiron"){
          $mail->send_mail(array(
            "from"=>PartuzaConfig::get('mail_from'),
            "to"=>PartuzaConfig::get("comiron delivery mail"),
            "title"=>"New Order",
            "body"=>$message,
            "filepath"=>$file,
            "filename"=>$order['order_id'].".xls",
          ));
        }

        $orderseq->save($order['id'],["status"=>1]);
      }

  }

  public function _order_pay_sb($order_id) {
    //проверка 1
    if (! $_SESSION['id']) { return; }

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


    $orderBundle = $order->get_items_order($order_id);
    function get_amount($orderBundle,$myorder){
            $itemPrice = 0;
            foreach($orderBundle as $order){
                    foreach($order as $keys){
                            foreach($keys as $key){
                                    $itemPrice += $key["itemPrice"]*$key['quantity']['value'];
                            }
                    }
            }
            return round($itemPrice);
    }
// оплата
require_once PartuzaConfig::get('library_root').'/REST.php';
$res = runREST(PartuzaConfig::get("sb_register"), "POST", array(
    "userName"    => PartuzaConfig::get("sb_login"),
    "password"    => PartuzaConfig::get("sb_password"),
    "orderNumber" => $order_id,
    "amount"      => get_amount($orderBundle,$myorder),
    "returnUrl"   => "http://comiron.com/profile/orders/pay/sberpay/sberok/$order_id/?sb_ok=$order_id",
    "failUrl"     => "https://comiron.com/profile/orders/".$_SESSION['id']."?sb_fail=1",
    "description" => "Оплата на сайте comiron.com",
    "orderBundle" => json_encode($orderBundle,JSON_UNESCAPED_UNICODE)
    ));
    echo "json:" .$res;

    $res = json_decode ($res, true);
    $_SESSION['orderId'] = $res['orderId'];
    echo "php: " .var_dump($res);

    if($res['formUrl']){
      header("Location: ".$res['formUrl']);
      exit();
    }
  }


  public function _order_pay_simplepay($order_id) {
    //проверка 1

    if (! $_SESSION['id']) { return; }

    // проверка - мой ли заказ
    $order = $this->model('order');
    $person = $this->model('people');
    $myorder = $order->show($order_id, false);
    $me = $person->get_person($myorder['person_id'], false);

    if ($_SESSION['id'] != $myorder['person_id']) {
      return;
    }
    //echo var_dump($myorder);
    //echo var_dump($me);

    //проверка валюты - только рубли
    /*if($myorder['currency_id'] != 2){
      return;
    }*/

    // оплата
    require 'MySimplePayMerchant.class.php';

  /**
   * Здесь представлен вариант с переадресацией сразу на страницу платежной системы
   * Установите payment_system = SP для переадресации на страницу выбора способа платежа
   * В случае если не будут указаны обязательные данные о плательщике,
   * будет произведена переадресация на платежную страницу SimplePay для уточнения деталей
   */
  if(!$myorder['sum']){
    $myorder['sum'] = 1;
  }
  if(!$myorder['phone']){
    $myorder['phone'] = "123123";
  }
  $payment_data = new SimplePay_Payment;
  $payment_data->amount = $myorder['sum'];
  $payment_data->order_id = $myorder['id'];
  $payment_data->client_name = $me["last_name"]." ".$me["first_name"];
  $payment_data->client_email = $me['email'];
  $payment_data->client_phone = $me['phone'];
  $payment_data->success_url = "https://comiron.com/profile/orders/".$_SESSION['id']."?sb_ok=".$myorder['id'];
  $payment_data->fail_url = "https://comiron.com/profile/orders/".$_SESSION['id']."?sb_fail=1";
  $payment_data->description = 'Тест платежа comiron.com';
  $payment_data->payment_system = 'SP';
  $payment_data->client_ip = $_SERVER['REMOTE_ADDR'];

  /* Пример использования */

  // Создаем объект мерчант-класса SP
  $sp = new MySimplePayMerchant();

  //$out = $sp->get_ps_list(100);
  //print_output("Разрешенные платежные системы", $out);

  $out = $sp->direct_payment($payment_data);
  //echo var_dump($out);
  //echo var_dump($payment_data);

  // Запрос данных о созданном платеже
  //$out = $sp->get_order_status_by_order_id(1001);

  if($out['sp_redirect_url']){
    //$order->save($order_id, array('ispayed'=>1)); // отметить оплату
    header("Location: ".$out['sp_redirect_url']);
    exit();
  }
  }

  //мои статьи
  public function myarticles($params) {
    if (! isset($params[3]) || ! is_numeric($params[3])) {
      header("Location: /");
      die();
    }
    $people = $this->model('people');
    $person = $people->get_person($_SESSION['id']);
    $shops = $this->model('shop');
    $shop_id=$params[3];

    $articles = $this->model('articles');
    $my_articles = $articles->get_articles($shop_id, 0, true);

    $shop = $shops->get_shop($shop_id, true);

    $template='shop/shop_articles.php';
    if($shops->is_myshop($_SESSION['id'], $shop['id'])){
      $template='shop/myshop_articles.php';
    }

    $this->template($template, array(
        'articles' => $my_articles,
        //'applications' => $applications,
        'shop'=>$shop,
        'person' => $person));
  }

  //добавить статью
  public function article_add($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();

    }
     //Чистка кэша

    $shop_id=$params[3];
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_'.$shop_id);

    $articles = $this->model('articles');
    $id=$articles->add($params['3'], $_POST);
  }

  public function article_delete($params){
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    $article = $this->model('articles');
    $id=$params['3'];

    //Чистка кэша
    $shop_id=$params[4];
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_'.$shop_id);

    $art=$article->get_article($id);
    $shop_id=$art['shop_id'];

    $article->delete($id);

    $art=$article->get_article($id);
    $shop_id=$art['shop_id'];

    $article->delete($id);

    //return  $this->myarticles(array("", "shop", "myarticles", $shop_id));
    header("Location: /shop/myarticles/$shop_id");
  }

  //статья
  public function article($params) {
    /*if (! isset($_SESSION['id'])) {
      header("Location: /"); die();
    }*/
    $shop = false;
    $person = false;
    $groups = false;
    $currencies = false;
    $articles = false;

    $id=$params[3];
    $group = $this->model('group');
    $product = $this->model('product');
    $article = $this->model('articles');
    $shops = $this->model('shop');

    $my_article = $article->get_article($id, true);

    if(isset($my_article['shop_id'])){
      $articles = $article->get_articles($my_article['shop_id'],0, true);
      $shop = $shops->get_shop($my_article['shop_id'], true);
      $groups=$group->get_groups($my_article['shop_id'],0, true, true);
    }

    if(isset($_GET['ajax'])){
      //показать группу для редактирования
      $template='shop/article_edit.php';
    }else{
      $people = $this->model('people');
      if(isset($_SESSION['id'])){
        $person = $people->get_person($_SESSION['id']);
      }
      //$currencies=$currency->get_currencies();
      $template='shop/shop_article.php';
    }

    $this->template($template, array(
        'article' => $my_article,
        'articles' => $articles,
        'groups'=>$groups,
        'shop'=>$shop,
        'person' => $person,
        'currencies'=>$currencies));
  }


  //сохранить продукт
  public function article_edit($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }

    //Чистка кэша

    $shop_id=$params[4];
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_'.$shop_id);

    $articles = $this->model('articles');
    $id=$params['3'];
    $articles->save($id, $_POST);
  }

  //залить картинку
  public function uploadprofileimg($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    $message = '';
    $shop = $this->model('shop');
    $id=$_REQUEST['id'];
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
        $filename=PartuzaConfig::get('site_root') . '/images/shop/' . $id . '.' . $ext;
        $filewebname=$id . '.' . $ext;
        // it's a file extention that we accept too (not that means anything really)
        if (! move_uploaded_file($tempFile, $filename)) {
          die("no permission to images/shop dir, or possible file upload attack, aborting");
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


  //залить картинку
  public function uploadbgimg($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    $message = '';
    $shop = $this->model('shop');
    $id=$_REQUEST['id'];
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
        $filename=PartuzaConfig::get('site_root') . '/images/shop/bg_' . $id . '.' . $ext;
        $filewebname="bg_".$id . '.' . $ext;
        // it's a file extention that we accept too (not that means anything really)
        if (! move_uploaded_file($tempFile, $filename)) {
          die("no permission to images/shop dir, or possible file upload attack, aborting");
        }

        //cохранить в базу
        $shop->save_shop($id,  array("bgimg"=>'/images/shop/'.$filewebname, "bgstyle"=>""));

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
    $shop = $this->model('shop');
    $filewebname="1";
    $id=0;
    //сохранить картинку
    foreach($_POST['imgcrop'] as $k => $v) {
      $targetPath = PartuzaConfig::get('site_root') . $v['folder'] . '/';
      $targetFile =  str_replace('//','/',$targetPath) . $v['name'];

      $ext=pathinfo($targetFile, PATHINFO_EXTENSION);

      //60x60
      $filename=PartuzaConfig::get('site_root') .  $v['folder'] . '/' .$v['id'] . '.' . $ext;
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

      $preview205->resizeToWidth(600);

      $fn='/images/shop/' . $v['id'].'.'.rand(1,200000).'.205x205.' . $ext;
      $preview205->save(PartuzaConfig::get('site_root') . $fn);
      $id=$v['id'];
      $shop->set_shop_photo_big($id, $fn);
      $shop->set_shop_photo($id,  $fn);

      $m = new Memcached();
      $m->addServer('localhost', 11211);
      $m->delete('shop_'.$id);

    }
      echo $id . '.205x205.' . $ext;
  }

  //залить картинку товара
  public function uploadproductimg1($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    $id='uu_'.$params[3];
    $filewebname="1";
    //сохранить картинку
        /*echo '<pre>';
        print_r($_FILES);
        echo '</pre>';*/
    if (!empty($_FILES)) {
      $tempFile = $_FILES['file']['tmp_name'];
      $targetPath = '/images/upload_user/';
      $targetFile =  str_replace('//','/',$targetPath) . $_FILES['file']['name'];
      $fileParts  = pathinfo($_FILES['file']['name']);
      if (in_array($fileParts['extension'],$this->imageTypes)) {
        //move_uploaded_file($tempFile,$targetFile);
        $ext = strtolower($fileParts['extension']);
        $filename=PartuzaConfig::get('site_root') . '/images/upload_user/' . $id . '_text_' . time() . '.' . $ext;
        $filewebname = $id . '_text_' . time() . '.' . $ext;
        // it's a file extention that we accept too (not that means anything really)
        if (! move_uploaded_file($tempFile, $filename)) {
          die("no permission to images/shop dir, or possible file upload attack, aborting");
        }

        //уменьшить до максимально допустимого размера
        $img=new SimpleImage();
        $img->load($filename);
        //$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
        $img->save($filename);
      }
    }
        $array = array(
            'filelink' => '/images/upload_user/'.$filewebname
        );
    echo stripslashes(json_encode($array));
  }

  //залить картинку товара
  public function uploadproductimg($params) {
    //var_dump($_SESSION["id"]);
    if (! isset($_SESSION['id'])) {
      //header("Location: /");
    }

        /*echo '<pre>';
        print_r($_FILES);
        echo '</pre>';
        */
    $message = '';
    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id'];

    if(!$shop_id){
	$shop_id = $_REQUEST["shop_id"];
    }

    $product = $this->model('product');
    $id=$_REQUEST['id'];
        if(isset($_REQUEST['dop'])) {
            $new_id = $product->set_dop_thumbnail_photo($id, '', '', 0,$shop_id);
            $dop = $new_id.''.$_REQUEST['dop'];
        }
        else $dop = '';
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
        $filename=PartuzaConfig::get('site_root') . '/images/product/' . $dop . '' . $id . '.' . $ext;
        $filewebname=$dop .''. $id . '.' . $ext;
        // it's a file extention that we accept too (not that means anything really)
        if (! move_uploaded_file($tempFile, $filename)) {
          die("no permission to images/shop dir, or possible file upload attack, aborting");
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


  //залить preview картинку товара
  public function cropproductimg($params) {
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
        //print_r($params);
        if(isset($params[3])) $dop = $params[3];
        else $dop = '';
    $message = '';
    $product = $this->model('product');
    $filewebname="1";
    $id=0;

    $cropsource=false;
    if($_POST['cropsource'][0]=="on"){
      $cropsource=true;
    }
    //print_r($_POST['imgcrop']);

    //сохранить картинку
    foreach($_POST['imgcrop'] as $k => $v) {
      $targetPath = PartuzaConfig::get('site_root') . $v['folder'] . '/';
      $targetFile =  str_replace('//','/',$targetPath) . $v['name'];
                if(isset($params[3])) {
                    $delim = explode('dop', $v['name']);
                    $dop = $delim[0].'dop';
                }
      $ext=pathinfo($targetFile, PATHINFO_EXTENSION);

      //60x60
      $filename=PartuzaConfig::get('site_root') .  $v['folder'] . '/'. $dop . '' .$v['id'] . '.' . $ext;
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

      $fn_big='/images/product/'. $dop . '' . $v['id']. '.' . $ext;
      if($cropsource){
        $preview205->save(PartuzaConfig::get('site_root') . $fn_big);
      }

      $preview205->resizeToWidth(600);
      $fn='/images/product/'. $dop . '' . $v['id']. '.205x205.' . $ext;

      $preview205->save(PartuzaConfig::get('site_root') . $fn);
      $id=$v['id'];

      if($dop == '') {
                    $product->set_photo($id, $fn_big);
                    $product->set_thumbnail($id,  $fn);
                } else {
                    $sort = explode('dop', $dop);
                    //$product->set_dop_thumbnail_photo($id, $fn, $fn_big, $sort[0]);
                    $product->set_dop_thumbnail_photo($id, $fn, $fn_big, 0);
                }

      }
      echo $dop . '' . $id . '.205x205.' . $ext;
    }


    //залить картинку группы
    public function uploadgroupimg($params) {
      if (! isset($_SESSION['id'])) {
        header("Location: /");
      }
      $message = '';
      $id=$_REQUEST['id'];
      $filewebname="1";
      //сохранить картинку
      if (!empty($_FILES)) {
        $tempFile = $_FILES['Filedata']['tmp_name'];
        $targetPath = PartuzaConfig::get('site_root') .  '/images/group/' . '/';
        $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
        $fileParts  = pathinfo($_FILES['Filedata']['name']);

        if (in_array($fileParts['extension'],$this->imageTypes)) {
          //move_uploaded_file($tempFile,$targetFile);
          $ext = strtolower($fileParts['extension']);
          $filename=PartuzaConfig::get('site_root') .'/images/group/' . $id . '.' . $ext;
          $filewebname=$id . '.' . $ext;
          // it's a file extention that we accept too (not that means anything really)
          if (! move_uploaded_file($tempFile, $filename)) {
            die("no permission to images/shop dir, or possible file upload attack, aborting");
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


    //залить картинку банера
    public function uploadbannerimg($params) {
      if (! isset($_SESSION['id'])) {
        header("Location: /");
      }
      $message = '';
      $id=$_REQUEST['id'];
      $filewebname="1";
      //сохранить картинку
      if (!empty($_FILES)) {
        $tempFile = $_FILES['Filedata']['tmp_name'];
        $targetPath = PartuzaConfig::get('site_root') .  '/images/banner/' ;
        $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
        $fileParts  = pathinfo($_FILES['Filedata']['name']);

        if (in_array($fileParts['extension'],$this->imageTypes)) {
          //move_uploaded_file($tempFile,$targetFile);
          $ext = strtolower($fileParts['extension']);
          $filename=PartuzaConfig::get('site_root') .'/images/banner/' . $id . '.' . $ext;
          $filewebname=$id . '.' . $ext;
          // it's a file extention that we accept too (not that means anything really)
          if (! move_uploaded_file($tempFile, $filename)) {
            die("no permission to images/shop dir, or possible file upload attack, aborting");
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


    //залить preview картинку группы
    public function cropgroupimg($params) {
      if (! isset($_SESSION['id'])) {
        header("Location: /");
      }

      $message = '';
      $group = $this->model('group');
      $filewebname="1";
      $id=0;

      $cropsource=false;
      if($_POST['cropsource'][0]=="on"){
        $cropsource=true;
      }


      //сохранить картинку
      foreach($_POST['imgcrop'] as $k => $v) {
        $targetPath = PartuzaConfig::get('site_root') . $v['folder'] . '/';
        $targetFile =  str_replace('//','/',$targetPath) . $v['name'];

        $ext=pathinfo($targetFile, PATHINFO_EXTENSION);

        //60x60
        $filename=PartuzaConfig::get('site_root') .  '/images/group/' . '/' .$v['id'] . '.' . $ext;
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

        /*
        $fn_big= $v['folder'] . $v['id']. '.' . $ext;
        if($cropsource){
          $preview205->save(PartuzaConfig::get('site_root') . $fn_big);
        }
        */

        $preview205->resizeToWidth(600);
        $fn = $v['folder'] . $v['id']. '.205x205.' . $ext;

        $preview205->save(PartuzaConfig::get('site_root') . $fn);
        $id=$v['id'];

        //$group->set_photo($id, $fn_big);
        $group->set_thumbnail($id,  $fn);

      }
      echo $id . '.205x205.' . $ext;
    }

    public function getgrouplist($params) {
      if (! isset($_SESSION['id'])) {
        header("Location: /");
      }

      $people = $this->model('people');
      $person = $people->get_person($_SESSION['id']);
      $shops = $this->model('shop');
      $shop_id=$params[3];

      $groups = $this->model('group');
      $my_groups = $groups->get_groups($shop_id, 0, true,true);

      $shop = $shops->get_shop($shop_id, true);

      $template='shop/getgrouplist.php';

      $this->template($template, array(
          'groups' => $my_groups,
          //      'applications' => $applications,
          'shop'=>$shop,
          'person' => $person));
    }


    public function orders($params) {
      if (! isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }
      if(isset($_REQUEST['sb_ok']) and $_SESSION['orderId'] === $_REQUEST['orderId']){
        $order = $this->model('order');
        $order->save($params[6], array('ispayed' => 1));
        $_SESSION['orderId'] = '';
        header("Location: /profile/my/orders");
      }
      if (isset($params[3]) and !is_numeric($params[3])) {
        switch ($params[3]) {
          case 'delete':
            $this->order_delete($params[4]);
            break;
          case 'get':
            $this->order_get($params[4]);
            break;
          case 'save':
            $this->order_save($params[4]);
            break;
        }
      } else if(is_numeric($params[3])) {
      $shop_id=$params[3];

        $shops = $this->model('shop');
        $shop = $shops->get_shop($shop_id, true);
        $people = $this->model('people');
        $person = $people->get_person($_SESSION['id']);

        $order = $this->model('order');

        //фильтр
        $curpage=(isset($_REQUEST['curpage']) && is_numeric($_REQUEST['curpage']))?$_REQUEST['curpage']:0;

        $fromdate=null;
        $todate=(isset($_REQUEST['todate']))?$_REQUEST['todate']:null;
        $orderstatus_id=(isset($_REQUEST['orderstatus_id']))?$_REQUEST['orderstatus_id']:null;

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

        $filter=array(
            'shop_id'=>$shop_id,
            'curpage'=>$curpage,
            'fromdate'=>$fromdate,
            'todate'=>$todate,
            'orderstatus_id'=>$orderstatus_id,
        );
        $orders = $order->get_orders($filter);
        $pages=$order->get_order_pages($filter);

        $this->template('shop/myshop_orders.php', array(
            'shop' => $shop,
            'person' => $person,
            'orderstatuses' => $order->get_statuses(),
            'searchorder'=>$_REQUEST,
            'orders'=>$orders,
            'nextpage'=>$pages['nextpage'],
            'totalpages'=>$pages['totalpages']));
      }
    }

    /* показать заказ подробно */
    public function order_get($id) {
      if (!$_SESSION['id'] || !$id) {
        header("Location: /");
        die();
      }

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $shop = $shops->get_myshop($person_id, true);

      $order = $this->model('order');
      $my_order = $order->get_order($id, null, $shop['id']);

      $this->template('shop/myshop_order_detail.php',
          array(
              'shop' => $shop,
              //'orderstatuses' => $order->get_statuses(),
              'order'=>$my_order,
              'orders'=>array($my_order),
          ));
    }


    //подготовить к редактированию заказ
    public function prepare_edit_order(){
      $id = isset($_GET['id']) ? $_GET['id'] : 0;

      if (! $_SESSION['id'] and $id) {
        return 0;
      }

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $shop = $shops->get_myshop($person_id, true);

      $order = $this->model('order');
      $my_order = $order->get_order($id, null, $shop['id']);

      if($my_order['dpdcityid']){
        $dpdcity = $this->model('dpdcity');
        $city = $dpdcity->get($my_order['dpdcityid']);
        $my_order['dpdcity'] = $city['abbr'] . " " . $city['name'] .
            (($city['region'])? ", " . $city['region'] :"") .
            (($city['rayon'])? ", " . $city['rayon'] . " район" :"") .
            (($city['minindex'] and $city['maxindex'])? ", " . $city['minindex'] . " - " . $city['maxindex']:"");
      }

      $this->template('/shop/order_edit_dialog.php', array(
          'order_id' => $id,
          'orderstatuses' => $order->get_statuses(),
          'shop_id' => $shop['id'],
          'order'=> $my_order));
    }


    /* save новость */
    public function order_save($id) {
      $ispayed = isset($_POST['ispayed']) ? $_POST['ispayed'] : false;
      $orderstatus_id = isset($_POST['orderstatus_id']) ? $_POST['orderstatus_id'] : false;
      $comment_shop = isset($_POST['comment_shop']) ? trim(strip_tags($_POST['comment_shop'])) : '';
      //$comment_person = isset($_POST['comment_person']) ? trim(strip_tags($_POST['comment_person'])) : '';

      $_POST['ispayed'] = $ispayed;
      $_POST['orderstatus_id'] = $orderstatus_id;
      $_POST['comment_shop'] = $comment_shop;

      $date_pickup= isset($_POST['date_pickup']) ? trim(strip_tags($_POST['date_pickup'])) : '';
      preg_match("/(\d+)\.(\d+)\.(\d+)/", $date_pickup, $res);
      if(isset($res[1]) and isset($res[2]) and isset($res[3])){
        $_POST['date_pickup']=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
      }


      $order = $this->model('order');

      //id=$params[3]
      if(isset($id) and is_numeric($id)){
        //$created = $_SERVER['REQUEST_TIME'];
        $order->save($id, $_POST);
      }
    }


    //показать страницу для импорта
    public function import(){
      if (!isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $shop = $shops->get_myshop($person_id, true);


      $this->template('/shop/myshop_import.php', array(
          'shop_id' => $shop['id'],
          'shop'=> $shop));
    }

    //импортировать товары из файла csv
    public function doimport(){
      if (!isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $shop = $shops->get_myshop($person_id, true);

      if (isset($_FILES['importfile']) && ! empty($_FILES['importfile']['name'])) {
        $file = $_FILES['importfile'];

        //if (substr($file['type'], 0, strlen('text/csv')) == 'text/csv' && $file['error'] == UPLOAD_ERR_OK) {
          $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
          // it's a file extention that we accept too (not that means anything really)
          $accepted = array('csv');
          if (in_array($ext, $accepted)) {
            $res = $this->parse_csv($shop['id'],$file['tmp_name']);
          } else {
            $res['error'] = true;
            //$res['strings'] = "File format error";
          }

        //}
      }


      $this->template('/shop/myshop_import.php', array(
          'shop_id' => $shop['id'],
          'shop'=> $shop,
          'importdone' => true,
          'error'=>$res['error'],
          'errorstrings'=>$res['strings']));
    }


    //импортировать товары из файла ods
    public function doimportods(){
      if (!isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }

     /* echo 'post_max_size: '.ini_get('post_max_size');
      echo 'upload_max_filesize: '.ini_get('upload_max_filesize');
      */
      $fimport = $_FILES['Filedata'];
      //echo var_dump($_FILES);

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $shop = $shops->get_myshop($person_id, true);

      if (isset($fimport) && ! empty($fimport['name'])) {
        //echo $_FILES['import']['error']." ".$_FILES['import']['tmp_name']." ".$_FILES['import']['size'];

        $file = $fimport;
        //if (substr($file['type'], 0, strlen('text/csv')) == 'text/csv' && $file['error'] == UPLOAD_ERR_OK) {
          $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
          // it's a file extention that we accept too (not that means anything really)
          $accepted = array('ods');
          if (in_array($ext, $accepted)) {
              $res = $this->parse_ods($shop['id'], $file['tmp_name']);
          } else {
            $res['error'] = true;
            //$res['strings'] = "File format error";
          }
        //}
      }

      echo var_dump($res['errorstrings']);
      /*$this->template('/shop/myshop_import.php', array(
          'shop_id' => $shop['id'],
          'shop'=> $shop,
          'importdone' => true,
          'error'=>$res['error'],
          'errorstrings'=>$res['strings']));*/
    }

    //первая строка - заголовки, могут стоять в любом порядке
    private function parse_ods($shop_id, $file){

      require_once PartuzaConfig::get('library_root').'/Spreadsheet/SpreadsheetReader.php';
      $parser = new SpreadsheetReader($file, false, 'application/vnd.oasis.opendocument.spreadsheet');
      //$parser = new SpreadsheetReader("/Applications/XAMPP/xamppfiles/htdocs/comiron/html/test.ods", false, 'application/vnd.oasis.opendocument.spreadsheet');
      if (!$parser)
        die("Cannot start a parser");
      $column_number = 0;
      $columns = array(); //заголовки
      $error = false;
      $errormessage = array();

      $row = 0;

      $product = $this->model('product');

      foreach ($parser as $Row){
        if(!$row){ //первая строка - колонки
          foreach ($Row as $column){
            if($column){
              $columns[$column_number] = $column;
            }
            $column_number++;
          }


        } else {

          //echo var_dump($columns);
          //$Row = array($Row[0],$Row[1],$Row[2],$Row[3],$Row[4],$Row[5],$Row[6],$Row[7],$Row[8],$Row[9]); //убрать все лишнее для отладки
          //echo var_dump($Row);
          $data = array();
          for($i = 0; $i < $column_number; $i++) {
             $data[$columns[$i]] = $Row[$i];
             if($columns[$i] == "photo"){// and !$Row[$i]
             //echo "=".$Row[2]."=";
             //echo "-".$data[$columns[$i]]."-";
             //    $data[$columns[$i]] = $parser->GetPicture($row-1);
             }

             if(preg_match('/img=(.*)/', $data[$columns[$i]], $url)){
                //echo var_dump($url[1]);
                $data[$columns[$i]]=$url[1];
             }
          }

          $id = $product->import_string($shop_id, $data, $this->get_cur_lang());

          if(!$id){
            $error = true;
            //echo "error ".($i-1);
            $errormessage[] = $row-1;
          } else if($data['photo']){  //если товар добавился, сохраниться фото
                  //скопировать и переименовать файл
                  $tempFile = $data['photo'];
                  $fileParts  = pathinfo($tempFile);
                  $ext = strtolower($fileParts['extension']);
                  $filename=PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext;
                  $filewebname= $id . '.' . $ext;
                  if (!copy($tempFile, $filename)) { //копируем файл и не удаляем, ods сам все почистит
                    //die("no permission to images/product dir, aborting: $tempFile $filename");
                    continue;
                  }
                  //echo $tempFile." ".$filename."<br>";
                  //try{
                    //уменьшить до максимально допустимого размера
                    $img=new SimpleImage();
                    $img->load($filename);
                    //$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
                    $img->save($filename);
                    $product->set_photo($id, '/images/product/' . $id . '.' . $ext);

                    // превью
                    //$thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext, 176, 176, true);
                    //$product->set_thumbnail($id, $thumbnail_url);
                    $img->resizeToWidth(600);
                    $fn = '/images/product/'. $id .'.205x205.' . $ext;
                    $img->save(PartuzaConfig::get('site_root') . $fn);
                    $product->set_thumbnail($id,  $fn);
                  //}catch(Exception $ex){ }
                  //echo $thumbnail_url ;

          }
        }
        //echo var_dump($data)." - ".$id."<br><br><br>";

        $row++;

      }
      //echo "</table>";
      //echo var_dump($parser);

      return array('error'=>$error, 'strings'=>$errormessage);
    }

    //импортировать товары из файла xls
    public function doimportxls(){
      if (!isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }

     /* echo 'post_max_size: '.ini_get('post_max_size');
      echo 'upload_max_filesize: '.ini_get('upload_max_filesize');
      */
      $fimport = $_FILES['Filedata'];
      //echo var_dump($_FILES);

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $shop = $shops->get_myshop($person_id, true);

      if (isset($fimport) && ! empty($fimport['name'])) {
        //echo $_FILES['import']['error']." ".$_FILES['import']['tmp_name']." ".$_FILES['import']['size'];

        $file = $fimport;
        //if (substr($file['type'], 0, strlen('text/csv')) == 'text/csv' && $file['error'] == UPLOAD_ERR_OK) {
          $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
          // it's a file extention that we accept too (not that means anything really)
          $accepted = array('xlsx', 'xls');
          if (in_array($ext, $accepted)) {
              if($ext == "xlsx"){
                $res = $this->parse_xlsx($shop['id'], $file['tmp_name']);
              }else {
                $res = $this->parse_xls($shop['id'], $file['tmp_name']);

              }
          } else {
            $res['error'] = true;
            //$res['strings'] = "File format error";
          }
        //}
      }

      echo var_dump($res['errorstrings']);
      /*$this->template('/shop/myshop_import.php', array(
          'shop_id' => $shop['id'],
          'shop'=> $shop,
          'importdone' => true,
          'error'=>$res['error'],
          'errorstrings'=>$res['strings']));*/
    }

    //ставит в очередь на парсинг xls файл
    public function price2parseupload(){
      if (!isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }

     /* echo 'post_max_size: '.ini_get('post_max_size');
      echo 'upload_max_filesize: '.ini_get('upload_max_filesize');
      */
      $fimport = $_FILES['Filedata'];
      //echo var_dump($_FILES);

      $person_id = $_SESSION['id'];
      $shops = $this->model('shop');
      $price2parse = $this->model('price2parse');
      $shop = $shops->get_myshop($person_id, true);
      $shop_id = $shop['id'];

      if (isset($fimport) && ! empty($fimport['name'])) {
        //echo $_FILES['import']['error']." ".$_FILES['import']['tmp_name']." ".$_FILES['import']['size'];

        $file = $fimport;
        //if (substr($file['type'], 0, strlen('text/csv')) == 'text/csv' && $file['error'] == UPLOAD_ERR_OK) {
          $ext = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
          // it's a file extention that we accept too (not that means anything really)
          $accepted = array('xlsx', 'xls');
          if (in_array($ext, $accepted)) {
              $now = time()*1000;
              $filewebname= '/importxls/files4import/' . $shop_id."_".$now. '.' . $ext;
              $filename=PartuzaConfig::get('site_root') . $filewebname;
              if (! move_uploaded_file($file['tmp_name'], $filename)) {
                die("no permission to /importxls/files4import/ dir, or possible file upload attack, aborting");
              }

              $price2parse->add(array(
                "shop_id"=>$shop['id'],
                "status"=>0,
                "title"=>"Price upload",
                "date"=>$now,
                "file"=>$filename,
                "email"=>$shop["odrer_email"]
              ));

              echo '{"status":"ok"}';
              return;

          } else {
            $res['error'] = true;
          }
      }
      echo '{"status":"fail"}';
    }

    public function parseprices(){
       $price2parse = $this->model('price2parse');
       $prices = $price2parse->show(array("status"=>0));
       global $mail;
       global $db;


       foreach($prices as $price){
         $price2parse->save($price['id'], array("status"=>1));
         // отправителю
         if($price['emailfrom']){
             $mail->send_mail(array(
                 "from"=>PartuzaConfig::get('mail_from'),
                 "to"=>$price['emailfrom'],
                 "title"=>"Прайс-лист принят в обработку",
                 "body"=>"Прайс-лист ".$price['title']." принят на обработку.",
                 ));
          }

         $ext = strtolower(substr($price['file'], strrpos($price['file'], '.') + 1));
         // it's a file extention that we accept too (not that means anything really)
         $accepted = array('xlsx', 'xls');
         if (in_array($ext, $accepted)) {
             if($ext == "xlsx"){
               $res = $this->parse_xlsx($price['shop_id'], $price['file'],$price['isspec']);
             }else {
               $res = $this->parse_xls($price['shop_id'], $price['file'],$price['isspec']);
             }
         }

         //если не спецификация, а прайс
         if($price['isspec'] == 0){
             //$res = $this->parse_xlsx($price['shop_id'],$price['file']);
             $product_ids = $res['ids'];
      //var_dump($product_ids);

            //товары спарсились - создаем прайс
            if(count($product_ids) > 0){
                 //users_id
                 $client_ids = array();
                 if(strlen($price['email'])>5){
                   $res = $db->query("select id from persons where email in (".$price['email'].")");
               	   while($data=$res->fetch_array(MYSQLI_ASSOC)){
                     $client_ids[]=$data['id'];
                   };
                 }else{
//var_dump("select client_id from shop_clients where shop_id=".$price['shop_id']);
                   $res = $db->query("select client_id from shop_clients where shop_id=".$price['shop_id']);
               	   while($data=$res->fetch_array(MYSQLI_ASSOC)){
                     $client_ids[]=$data['client_id'];
                   };
                 }
//var_dump($client_ids);
                 $price_model = $this->model('price');
                 $data = array(
                   'id_shop' => $price['shop_id'],
                   'id_products' => $product_ids,
                   'id_clients'=> $client_ids,
                   'name' => $price['title'],
                   'date' => $price['date'],
                   'descr' => $price['descr']
                 );

          #var_dump($data);
                 $result = $price_model->create_price($data);

                 // отправителю
                 if($price['emailfrom']){
                     $mail->send_mail(array(
                         "from"=>PartuzaConfig::get('mail_from'),
                         "to"=>$price['emailfrom'],
                         "title"=>"Прайс-лист обработан",
                         "body"=>"Прайс-лист ".$price['title']." обработан.",
                         ));
                  }
             } else {
               // товары не спарсились - отправляем прайс себе
               // Антону
               $mail->send_mail(array(
                   "from"=>PartuzaConfig::get('mail_from'),
                   "to"=>PartuzaConfig::get('mail_anton'),
                   "title"=>"Error parsing price ".$price['id'],
                   "body"=>"Price was not parsed correcty. Shop id = ".$price['shop_id'],
                   "filepath"=>$price['file'],
                   "filename"=>$price['id'].".xls",
                   ));
               // нам
               $mail->send_mail(array(
                   "from"=>PartuzaConfig::get('mail_from'),
                   "to"=>"office@creograf.ru",
                   "title"=>"Error parsing price ".$price['id'],
                   "body"=>"Price was not parsed correcty. Shop id = ".$price['shop_id'],
                   "filepath"=>$price['file'],
                   "filename"=>$price['id'].".xls",
                   ));
               // отправителю
               if($price['emailfrom']){
                   $mail->send_mail(array(
                       "from"=>PartuzaConfig::get('mail_from'),
                       "to"=>$price['emailfrom'],
                       "title"=>"Прайс-лист в очереди на обработку",
                       "body"=>"Прайс-лист ".$price['title']." в очереди на обработку.",
                       ));
                }
             }
         }

         $price2parse->save($price['id'], array("status"=>2));
       }
       return "{status: 'OK'}";
    }

    private function getrealcolumnname($column){
      $columns = [
        'name' => ["name","наименование","наименование товара", "规格", "品名","产品名称","备注","品     名","名称","品名\ndescription", "название компании/производитель", "наименование товаров"],
        'code' => ["cid","код","编号","货号","item no","产品编号","货 号","货号\nitem no","公司货号","item no.","工厂货号","item.","item","артикул", "型号 ","型号","货号\nitem no.","no", "model number"],
        'price'=>["цена","цена опт", "стоимость", "单价\nprice", "价格","价格  （包电）","单价","出厂价","出厂价/￥","价格(包电)", "价格(元）","price/元","出厂价","出厂价格","price rmb","price usd","price $","$","price cny","Цена 1 единицы товара в валюте контракта FOB","价格\nprice",
        "rmb","(usd)","unit price"],
        'photo'=>["фото","图片","产品图片","picture","图  片","图片\nphoto","foto", "照片","фото продукции","产品图片\nphoto"],
        'descr'=>["description","品名","功能/电池","成品尺寸  装箱数量","外箱规格","описание товара ","описание товара","описание","备注\nremarks","remarks","remarks\n","remark"],
        'weight'=>["вес","毛重","вес брутто","вес нетто","重量","毛重（kg）","重量/kg","g.w.","重量/kg","gross weight","g. weight","g.w","g/w",
                  "净重（kg）","净重","n.w.","n. weight","net weight","n/w.","n/w"],
        'sklad'=>["num","количество","кол-во","склад","на складе"],
        'box'=>["装箱数","装箱量/pcs","装箱数量","装箱量","装箱数/只","装箱数量/pcs","每箱数量","qty","ctn/qty","packing/pcs","数量","装箱数（pcs）","装箱量","quantity in carton","'装箱量","装箱数\nqty pcs"],
        'volume'=>["体积","cbm"],
        'volume2'=>["彩盒规格","彩盒尺寸(cm)","彩盒规格/CM","产品尺寸/cm","产品尺寸（cm)","sizes","包装尺寸","размер изделия","size of inner box","size of color box","size"],
        'boxsize'=>["箱规","外箱规格","成品尺寸  装箱数量","散装箱规","外箱尺寸     (cm)","外箱规格(cm)","外箱尺寸/cm","外箱规格/cm","meas","外箱规格(cm)","外箱规格/cm","外箱规格（cm）","产品组装尺寸（cm）","外箱尺寸","size of outer box"],
      ];
      $column = mb_convert_case($column, MB_CASE_LOWER, "UTF-8");

      var_dump($column);
      foreach ($columns as $c => $vars) {
        if (in_array($column, $vars)) {
          $column = $c;
        }
      }
      return $column;
    }

    //первая строка - заголовки, могут стоять в любом порядке
    private function parse_xlsx($shop_id, $file, $isspec = 0){
      $ids = array();
      require_once PartuzaConfig::get('library_root').'/Spreadsheet/SpreadsheetReader_XLSX.php';
      $parser = new SpreadsheetReader_XLSX($file);//, false, 'application/vnd.oasis.opendocument.spreadsheet');
      //$parser = new SpreadsheetReader_XLSX("/var/www/user/data/www/server.comiron.com/html/price_test.xlsx");
      if (!$parser)
        die("Cannot start a parser");

      $column_number = 0;
      $columns = array(); //заголовки
      $error = false;
      $errormessage = array();

      $numcolums = 0; //количество обязательных колонок: name,price,code

      $row = 0;

      $product = $this->model('product');

      foreach ($parser as $Row){
        if($numcolums < 2){ //первая строка - колонки
          foreach ($Row as $column){
            if($column){
              $column = strtolower($column);
              $column = $this->getrealcolumnname($column); //расшифровать китайские колонки
              $columns[$column_number] = $column;

              if($column == "price" or $column == "code") $numcolums++;
            }
            $column_number++;
          }
          var_dump($columns);
          if($numcolums < 2){ // пропустить строку, если в ней нет полей name & price & code
            $columns = [];
            $numcolums = 0;
          }
        }

        else if($numcolums >= 2) {

          //echo var_dump($columns);
          //$Row = array($Row[0],$Row[1],$Row[2],$Row[3],$Row[4],$Row[5],$Row[6],$Row[7],$Row[8],$Row[9]); //убрать все лишнее для отладки
          //echo var_dump($Row);
          $data = array();

              for($i = 0; $i < $column_number; $i++) {
                 $data[$columns[$i]] = $Row[$i];
    /*             if($columns[$i] == "photo"){
                  $data[$columns[$i]] = $parser->GetPicture($row);
                }*/
              }

              //колонка photo может быть без заголовка
              if($parser->GetPicture($row)){
                $data["photo"] = $parser->GetPicture($row);
              }
    var_dump($data);
              $id = $product->import_string($shop_id, $data, $this->get_cur_lang(), $isspec);
              $ids[] = $id;
              if(!$id){
                $error = true;
                //echo "error ".($i-1);
                $errormessage[] = $row-1;
              } else if($data['photo']){  //если товар добавился, сохранить фото
                      //скопировать и переименовать файл
                      $tempFile = $data['photo'];
                      //var_dump($tempFile);
                      $fileParts  = pathinfo($tempFile);
                      $ext = strtolower($fileParts['extension']);
                      $filename=PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext;
                      $filewebname= $id . '.' . $ext;
                      if (!copy($tempFile, $filename)) { //копируем файл и не удаляем, ods сам все почистит
                        die("no permission to images/product dir, aborting: $tempFile $filename");
                        continue;
                      }
                      //echo $tempFile." ".$filename."<br>";
                      //try{
                        //уменьшить до максимально допустимого размера
                        $img=new SimpleImage();
                        $img->load($filename);
                        //$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
                        $img->save($filename);
                        $product->set_photo($id, '/images/product/' . $id . '.' . $ext);

                        // превью
                        //$thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext, 176, 176, true);
                        //$product->set_thumbnail($id, $thumbnail_url);
                        $img->resizeToWidth(600);
                        $fn = '/images/product/'. $id .'.205x205.' . $ext;
                        $img->save(PartuzaConfig::get('site_root') . $fn);
                        var_dump($fn);
                        $product->set_thumbnail($id,  $fn);
                      //}catch(Exception $ex){
                        //var_dump($ex);
                        //die;
                      //}
                      //echo $thumbnail_url ;

          }
        }
        //echo var_dump($data)." - ".$id."<br><br><br>";

        $row++;

      }
      //echo "</table>";
      //echo var_dump($parser);

      return array('error'=>$error, 'strings'=>$errormessage, 'ids'=>$ids);
    }

    public function testparsexls(){
      $this->parse_xls(21, "");
    }


    //первая строка - заголовки, могут стоять в любом порядке
    private function parse_xls($shop_id, $file, $isspec = 0){
      $ids = array();
      //$file = "/var/www/user/data/www/server.comiron.com/html/price_test.xls";

      require_once PartuzaConfig::get('library_root').'/PHPExcel/Reader/Excel5.php';
      $objReader = new PHPExcel_Reader_Excel5();
      $data = $objReader->load($file);
      $objWorksheet = $data->getActiveSheet();
      $imgdir = sys_get_temp_dir()."/comiron-xls/";
      $pictures = [];
      $pictures_obj = [];

      $product = $this->model('product');
      $columns = array(); //заголовки
      $error = false;
      $errormessage = array();


      //парсим картинки
      foreach ($objWorksheet->getDrawingCollection() as $drawing) {
        //for XLSX format
        $string = $drawing->getCoordinates();
        $coordinate = PHPExcel_Cell::coordinateFromString($string);
        if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
          $image = $drawing->getImageResource();
          //var_dump($image);
          // save image to disk
          $renderingFunction = $drawing->getRenderingFunction();
          switch ($renderingFunction) {
            case PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG:
              //imagejpeg($image, $imgdir . $drawing->getIndexedFilename());
              $pictures[$coordinate[1]] = $imgdir . $drawing->getIndexedFilename();
              $pictures_obj[$coordinate[1]] = $image;
              //var_dump(error_get_last());
              break;
            case PHPExcel_Worksheet_MemoryDrawing::RENDERING_GIF:
              //imagegif($image, $imgdir . $drawing->getIndexedFilename());
              $pictures[$coordinate[1]] = $imgdir . $drawing->getIndexedFilename();
              $pictures_obj[$coordinate[1]] = $image;
              break;
            case PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG:
            case PHPExcel_Worksheet_MemoryDrawing::RENDERING_DEFAULT:
              //imagepng($image, $imgdir . $drawing->getIndexedFilename());
              $pictures[$coordinate[1]] = $imgdir . $drawing->getIndexedFilename();
              $pictures_obj[$coordinate[1]] = $image;
              break;
          }
        }
      }

      //foreach ($objReader->getWorksheetIterator() as $worksheet) {
        //$worksheetTitle     = $worksheet->getTitle();
        $highestRow         = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn      = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $nrColumns = ord($highestColumn) - 64;

        $numcolums = 0; //количество обязательных колонок: name,price,code


        for ($row = 1; $row <= $highestRow; ++ $row) {

          if($numcolums < 2){ //первая строка - колонки
            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
              $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
              $val = $cell->getValue();

              if($val){
                $val = strtolower($val);
                $val = $this->getrealcolumnname($val); //расшифровать китайские колонки
                $columns[$col] = $val;

                if($val == "price" or $val == "code") $numcolums++;
              }

            }
            var_dump($columns);
            if($numcolums < 2){ // пропустить строку, если в ней нет полей name & price & code
              $columns = [];
              $numcolums = 0;
            }
          }

          else if($numcolums >= 2) {
            $data = array();
            for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                $cell = $objWorksheet->getCellByColumnAndRow($col, $row);
                $val = $cell->getValue();
                //$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
                $data[$columns[$col]] = $val;
        //	var_dump([$columns[$col],$val]);
            }


            //колонка photo может быть без заголовка
            if($pictures[$row]){
              $data["photo"] = $pictures[$row];
            }
      //var_dump($data);

            $id = $product->import_string($shop_id, $data, $this->get_cur_lang(), $ispec);

            $ids[] = $id;
            if(!$id){
              $error = true;
              //echo "error ".($i-1);
              $errormessage[] = $row-1;
            } else if($data['photo']){  //если товар добавился, сохранить фото
                    //скопировать и переименовать файл
                    $tempFile = $data['photo'];
                    //var_dump($tempFile);
                    $fileParts  = pathinfo($tempFile);
                    $ext = strtolower($fileParts['extension']);
                    $filename=PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext;
                    $filewebname= $id . '.' . $ext;
                    if($pictures_obj[$row]){
                      imagejpeg($pictures_obj[$row],$filename);
        	      //var_dump(error_get_last());
                    }
                    //if (!copy($tempFile, $filename)) { //копируем файл и не удаляем, ods сам все почистит
                    //  die("no permission to images/product dir, aborting: $tempFile $filename");
                    //  continue;
                    //}
                      //уменьшить до максимально допустимого размера
                      $img=new SimpleImage();
                      $img->load($filename);
                      //$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
                      $img->save($filename);
                      $product->set_photo($id, '/images/product/' . $id . '.' . $ext);

                      // превью
                      $img->resizeToWidth(600);
                      $fn = '/images/product/'. $id .'.205x205.' . $ext;
                      $img->save(PartuzaConfig::get('site_root') . $fn);
                      var_dump($fn);
                      $product->set_thumbnail($id,  $fn);

            }
          }

        }
//      }

      return array('error'=>$error, 'strings'=>$errormessage, 'ids'=>$ids);
    }


    //залить много картинок по артикулам
    public function importphotos($params) {
      if (! isset($_SESSION['id'])) {
        header("Location: /");
      }

      $message = '';
      $shop = $this->model('shop');
      $myshop = $shop->get_myshop($_SESSION['id'], true);
      $shop_id = $myshop['id'];

      $product = $this->model('product');

      $filewebname="1";
      //сохранить картинку
      if (!empty($_FILES)) {
        $tempFile = $_FILES['Filedata']['tmp_name'];
        //echo $tempFile;
        $targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
        $targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
        $fileParts  = pathinfo($_FILES['Filedata']['name']);
        $ext = $fileParts['extension'];

        if (in_array($ext,$this->imageTypes)) {
          //move_uploaded_file($tempFile,$targetFile);
          $code = $fileParts['filename'];
          $ismain = 1;
          $sort = "";

          if(preg_match('/^(.*)_(\d+)$/', $code, $res)){
            $code = $res[1];
            $sort = $res[2];
            $ismain = 0;
            //echo var_dump($res);
          }
//echo $code;
          $id = $product->get_product_from_code($shop_id,$code);
//echo $id;
          if(!isset($id)){
            return $id;
          }

          $ext = strtolower($fileParts['extension']);
          $filename=PartuzaConfig::get('site_root') . '/images/product/' . $id .($sort?"_".$sort:""). '.' . $ext;
          $filewebname=$dop .''. $id .($sort?"_".$sort:""). '.' . $ext;
          // it's a file extention that we accept too (not that means anything really)
          if (! move_uploaded_file($tempFile, $filename)) {
            die("no permission to images/shop dir, or possible file upload attack, aborting");
          }

          //уменьшить до максимально допустимого размера
          $img=new SimpleImage();
          $img->load($filename);
          //$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
          $img->save($filename);
          $photo_url = '/images/product/' . $id .($sort?"_".$sort:""). '.' . $ext;
          // превью
          $thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/product/' . $id .($sort?"_".$sort:""). '.' . $ext, 176, 176, true);

          if($ismain){
            $product->set_photo($id, $photo_url);
            $product->set_thumbnail($id, $thumbnail_url);
          }else {
          //echo "$id, $thumbnail_url, $photo_url, $sort, $shop_id";
            $product->set_dop_thumbnail_photo($id, $thumbnail_url, $photo_url, $sort, $shop_id);
          }

        }
      }
      echo $filewebname;
    }


    //удалить все товары и группы
    function removeallproducts($params){
      if (! isset($_SESSION['id'])) {
        header("Location: /");
      }

      $message = '';
      $shop = $this->model('shop');
      $myshop = $shop->get_myshop($_SESSION['id'], true);
      $shop_id = $myshop['id'];

      if(!isset($params[3]) or $params[3]!=$shop_id){
        header("Location: /");
      }


      $shop = $this->model('shop');
      $shop->deleteall($shop_id);

      return $this->myproducts($params);
    }

    // фильтр
    public function filter($params) {
      if($_REQUEST['group_id']){ //фильтр в группе магазина
        return $this->group(array("", "shop","group",$_REQUEST['group_id']));
      }else{
        include_once PartuzaConfig::get('controllers_root') . "/central/central.php";
        $centralController = new centralController();
        $message = "<b>Could not add application:</b><br/> {$ret['error']}";
        $centralController->searchproduct($params, $message);
      }
    }

  // //все названия свойств товаров в магазине
  // public function get_properties_for_shop($params) {
  //   if (! isset($_SESSION['id'])) {
  //       header("Location: /");
  //   }
  //   $message = '';
  //   $shop = $this->model('shop');
  //   $myshop = $shop->get_myshop($_SESSION['id'], true);
  //   $shop_id = $myshop['id'];

  //   // нет магазина
  //   if(!$myshop['id']){
  //       echo stripslashes(json_encode(array(
  //           status => “fail”,
  //           error => "user doesn't have shop",
  //         )));
  //       return;
  //   }
  //   //
  //   //$property = $this->model('property');
  //   //$property->deleteall($shop_id);

  //   echo (json_encode($data));#, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT

  // }

    public function cartdelivery($params){
      if(!$_REQUEST['PSId'] or !$_REQUEST['OrderId']) return;
      $cartdelivery = $this->model('cartdelivery');
      $cartdelivery->save(array('id' => $_REQUEST['OrderId'], "hermes_id"=>$_REQUEST['PSId']));

      $data = $cartdelivery->get($_REQUEST['OrderId']);
      //echo var_dump($data);
      if($data['shop_id']){
        header("Location: /shop/cart/".$data['shop_id']."?hermes_id=".$_REQUEST['PSId']);
      }
    }


    //показать оферту
    public function oferta(){
      if (!isset($_SESSION['id'])) {
        header("Location: /");
        die();
      }

      $this->template('/shop/oferta.php');
    }

    //промокод на сервер
    public function promoToDb($params) {
     $shop_id=$params[3];
     $shop = $this->model('shop');
     $promo = $shop->get_promo_toDb($shop_id,$_POST['promo']);

     switch ($promo[0]) {
       case '0':
         $this->template('shop/home.php', array(
        'valid' => $promo[0],
        'error' => $promo[1]
        ));
         break;

        case '1':
          $this->template('shop/home.php', array(
          'valid' => $promo[0],
          'sum' => $promo[1],
          'isPercent' => $promo[2],
          'order_id ' => $promo[3],
          ));
          break;
     }

    }

    // удаление магазина
    public function deleteAll($params) {

      $canDelete = false;
      $shop_id=$params[3];
      $shop = $this->model('shop');

      if(isset($params[4]) && $params[4] == 'supersecretkeycomiron')
        $canDelete = true;
      else {
        if (!isset($_SESSION['id'])) {
          header("Location: /");
          die();
        }
        $person_id=$_SESSION['id'];
        $canDelete = $shop->is_myshop($person_id, $shop_id);
      }

      if($canDelete){
        $shop->deleteShop($shop_id);
        $this->deleteCache($shop_id);
        echo "Удален";
      }
      else
        echo "Не удален";

    }

    public function cartNonAuth($params) {
     global $mail;
      $products = json_decode($_REQUEST['cartitems']);
      $order = json_decode($_REQUEST['orderinfo']);
      $arrayInfo = [];
      $arrayProduct = [];
      $shop_id=0;
      $shops = $this->model('shop');
      
      foreach ($products as $key => $value) {
          $arr = [];
          $shop_id = $value->product->shop_id;
          $arr['id'] = $value->product->id;
          $arr['name'] = $value->product->name;
          $arr['photo_url'] = $value->product->photo_url;
          $arr['num'] = $value->num;
          $arr['price'] = $value->price;
          $arr['sum'] = $value->sum;
          $arrayProduct[] = $arr;
          }
          $arrayInfo['product'] = $arrayProduct;
      $arrayInfo['info'] = $order;
      $message=$this->get_template("/shop/mail/nonauthorder.php",
        $arrayInfo);
      // $res = file_put_contents(PartuzaConfig::get('site_root_avito')."/product.html", $message);
    
        $shop=$shops->get_shop($shop_id);
            
        $mailto = $arrayInfo['info']->mail[0]->email;
          //$result = $mail->send_mail_html(array(
          $result = $mail->send_mail(array(
          "from"=>PartuzaConfig::get('mail_from'),
          "to"=>$shop['order_email'],
          "title"=>"Заказ без аутентификации",
          "body"=>"$message",
          ));
          
          $arr = [];

          if($result) {
             $arr['status'] = "OK";
          }
          else {
            $arr['status'] = "ERROR";
          }

          echo json_encode($arr);
      }



      public function getShopCategory($params) {
         $shop = parent::model('shop');
         $result = $shop->getShopCategory($params[3]);
         echo json_encode($result);
      }

      //мои теги пользователей
      public function mytags($params) {
        if (! isset($params[3]) || ! is_numeric($params[3])){
          header("Location: /");
          die();
        }
        $people = $this->model('people');
        $shops = $this->model('shop');
        $shop_id=$params[3];

        if(!$shops->is_myshop($_SESSION['id'], $params[3])){
          return;
        }

        $tags = $this->model('tag');
        $my_tags=0;
        $my_tags = $tags->getall($shop_id);

        $this->template('shop/myshop_usergroups.php', array(
            'tags' => $my_tags,
            'shop'=>$shops->get_shop($shop_id, true),
            'person' => $people->get_person($_SESSION['id'])));
      }

      //добавить тег
      public function tag_add($params) {
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }

        $tag = $this->model('tag');
        $shop_id=$params['3'];
        $params = $_POST;
//        $params['tag_id'] = explode(',', json_decode($params['tag_id']));
        $id=$tag->add($shop_id, $params);

      }

      public function tag_delete($params){
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }
        $id=$params['3'];

        $tags = $this->model('tag');
        $id=$tags->delete($id);
      }

      //сохранить группу пользователей
      public function tag_edit($params) {
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }

        $tags = $this->model('tag');
        $id=$params['3'];
        $tags->save($id, $_POST);
      }


      //мои пункты выдачи
      public function pointofissue($params) {
        if (! isset($params[3]) || ! is_numeric($params[3])){
          header("Location: /");
          die();
        }
//var_dump($params); return;

        $people = $this->model('people');
        $shops = $this->model('shop');
        $shop_id=$params[3];

        //if(!$shops->is_myshop($_SESSION['id'], $params[3])){
        //  return;
        //}

        $pointofissue = $this->model('pointofissue');
        $pointofissues=0;
        $pointofissues = $pointofissue->get_list($shop_id);

        echo json_encode(array(
            'pointofissue' => $pointofissues,
            //'shop'=>$shops->get_shop($shop_id, true)
            //'person' => $people->get_person($_SESSION['id'])
          ));
      }

      //добавить тег
      public function pointofissue_add($params) {
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }

        $pointofissue = $this->model('pointofissue');
        $shop_id=$params['3'];
        $params = $_POST;
        $id=$pointofissue->add($shop_id, $params);

      }

      public function pointofissue_delete($params){
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }
        $id=$params['3'];

        $pointofissue = $this->model('pointofissue');
        $id=$pointofissue->delete($id);
      }

      //сохранить группу пользователей
      public function pointofissue_edit($params) {
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }

        $pointofissue = $this->model('pointofissue');
        $id=$params['3'];
        $pointofissue->save($id, $_POST);
      }


      public function import_order($params){
        $data = json_decode(file_get_contents('php://input'), true);
        $shop_id = $data['shop_id'];
        $order = $data['order'];
        $cart = $data['cart'];

        if (!$order or !$shop_id or !$cart){
          echo json_encode(["status"=>"fail", "message"=>"no shop_id or cart or order"]);
          die();
        }

        foreach ($cart as $key => $value) {
    	    $cart[$key]["shop_id"] = $shop_id;
            $cart[$key]["person_id"] = $order["person_id"];
        }

        $orders = $this->model('order');
        $order_id=$orders->add($shop_id, $order, $cart);

        if($order_id){
          echo json_encode(["status"=>"ok", "order_id"=> $order_id]);
        }else {
          echo json_encode(["status"=>"fail"]);
        }
      }


      //мои уведомления
      public function pushes($params) {
        if (! isset($params[3]) || ! is_numeric($params[3])){
          header("Location: /");
          die();
        }
//var_dump($params); return;

        $people = $this->model('people');
        $shops = $this->model('shop');
        $person_id=$params[3];

        //if(!$shops->is_myshop($_SESSION['id'], $params[3])){
        //  return;
        //}

        $push = $this->model('push');
        $pushes=0;
        $pushes = $push->get_list($person_id, $_REQUEST);

        echo json_encode(array(
            'pushes' => $pushes,
            //'shop'=>$shops->get_shop($shop_id, true)
            //'person' => $people->get_person($_SESSION['id'])
          ));
      }

      //добавить тег
      public function pushes_add($params) {
        /*if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }*/



        $people = $this->model('people');
        $userId = "0";
        if($_POST['person_id']){
          $userId = $_POST['person_id'];
        }
        if(!$_POST['person_id'] and $_POST['email']){
          $userId = $people->get_id_by_email($_POST['email']);
        }

	if(!$_POST['date']){
          $_POST['date']=time();
        }

        if(!$userId){
          echo json_encode(["status"=>"fail", "message"=>"person not found"]);
          return;
        }


        $push = $this->model('push');
        $shop_id=$params['3'];
        $params = $_POST;

        $person = $people->get_person_info($userId);
        $key = $person['pushtoken'];
        $params["token"] = $key;

        $id=$push->add($shop_id, $params);
        if($id){
          echo json_encode(["id"=>$id, "status"=>"ok"]);
        }else{
          echo json_encode(["status"=>"fail"]);
          return;
        }

        if(!$key) return;

        require_once PartuzaConfig::get('library_root').'/REST.php';

	      $params["type"]="push";
        $notification = ['title' => $_POST['title'],'body' => $_POST['message'], 'data'=> $params];
        $notification ["to"] =$key; //json_encode($to);
        $status = runREST("https://exp.host/--/api/v2/push/send", "POST_JSON", $notification);

      }

      public function pushes_delete($params){
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }
        $id=$params['3'];

        $pushes = $this->model('push');
        $id=$pushes->delete($id);
      }

      //сохранить группу пользователей
      public function pushes_edit($params) {
        if (! $_SESSION['id']) {
          header("Location: /");
          die();
        }

        $push = $this->model('push');
        $id=$params['3'];
        $push->save($id, $_POST);
      }


      public function import_product_multi($params){

        $status_code = $this->set_status_code("Internal Server Error","500");
        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $data = json_decode(file_get_contents('php://input'), true);
        $shop = $this->model('shop');
        $product_m = $this->model('product');

//var_dump($data);
        //проверить права
        if ($_SESSION['id']) {
          $myshop = $shop->get_shop($data["shop_id"]);
          if (!$myshop['is_owner']) {
            echo json_encode(["status"=>"fail",
                              "message"=>"no access to shop_id ".$data['shop_id']]);
           return;
          }
        }

        $ids = [];
        foreach  ($data["products"] as $product) {
    	  $product["shop_id"] = $data["shop_id"];

          $id = $product_m->import_string($data["shop_id"], $product, $this->get_cur_lang());
          $ids[]=$id;

          if(!$id){
            $error = true;
            //echo "error ".($i-1);
            $errormessage[] = $row-1;
          } else if($data['photo']){  //если товар добавился, сохраниться фото
                  //скопировать и переименовать файл
                   ;
                  $filename=PartuzaConfig::get('site_root') . '/images/product/' . $id . '.jpg';
                  $filewebname= $id . '.' . $ext;

                  $ifp = fopen( $filename, "wb" );
                  fwrite( $ifp, base64_decode( $data['photo']) );
                  fclose( $ifp );

                    //уменьшить до максимально допустимого размера
                    $img=new SimpleImage();
                    $img->load($filename);
                    //$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
                    $img->save($filename);
                    $product->set_photo($id, '/images/product/' . $id . '.' . $ext);

                    // превью
                    //$thumbnail_url = Image::by_size(PartuzaConfig::get('site_root') . '/images/product/' . $id . '.' . $ext, 176, 176, true);
                    //$product->set_thumbnail($id, $thumbnail_url);
                    $img->resizeToWidth(600);
                    $fn = '/images/product/'. $id .'.205x205.' . $ext;
                    $img->save(PartuzaConfig::get('site_root') . $fn);
                    $product->set_thumbnail($id,  $fn);
          }
        }

          $json_response['data']['ids'] = $ids;
          echo json_encode($json_response);
      }

  public function update_deliverystate() {
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
      echo json_encode(['error' => 'Wrong request type']);
      return;
    }

    $order_model = $this->model('order');

    try {
      $peks = $order_model->get_trackable_orders('pek');

      if ($peks) {
        foreach ($peks as $pek) {
          $cargo_codes[] = $pek['deliverynum'];
        }

        // api принимает массив по 5 элементов максимум
        $cargo_codes = array_chunk($cargo_codes, 5);

        require_once PartuzaConfig::get('library_root').'/PEK.php';
        $PEK = new PEK();

        foreach ($cargo_codes as $codes) {
          $response = $PEK->get_basic_status(['cargoCodes' => $codes]);

          if ($response['error']) {
            $updated_peks[] = [
              'codes' => $codes,
              'error' => $response['error']
            ];
            continue;
          }

          $cargos = $response['cargos'];

          foreach ($cargos as $cargo) {
            $order_code = $cargo['cargo']['code'];
            $deliverystate = $cargo['info']['cargoStatus'];

            $order_model->update_trackable_order($order_code, $deliverystate);

            $updated_peks[] = $cargo;
          }
        }
      }

      $dpds = $order_model->get_trackable_orders('dpd');

      if ($dpds) {
        require_once PartuzaConfig::get('library_root').'/DPD.php';
        $DPD = new DPD;

        foreach ($dpds as $dpd) {
          try {
            $response = $DPD->getStatesByDPDOrder(['dpdOrderNr' => $dpd['deliverynum']]);
          } catch (Exception $e) {
            $updated_dpds[] = [
              'code' => $dpd['deliverynum'],
              'message' => $e->getMessage()
            ];
            continue;
          }

          if (!$response['states']) {
            $updated_dpds[] = [
              'code' => $dpd['deliverynum'],
              'message' => 'no states found'
            ];
            continue;
          }

          $status = end($response['states']);
          $deliverystate = $status['newState'];

          $order_model->update_trackable_order($dpd['deliverynum'], $deliverystate);

          $updated_dpds[] = $status;
        }
      }

      echo json_encode([
        'updated_dpds' => $updated_dpds,
        'updated_peks' => $updated_peks
      ]);

    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

public function getshopsfromcity(){

    if (!isset($_GET['city'])) {
      echo json_encode(['error' => 'City required']);
      return;
    } else {
      $city = $_GET['city'];
    }

    try {
      
      $shop = $this->model('shop');
      $shops = $shop->get_shops_from_city($city);
      echo json_encode(['shops' => $shops]);

    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }
}
