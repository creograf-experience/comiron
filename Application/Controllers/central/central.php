<?php

class centralController extends baseController {

  public function index($params) {

    $people = $this->model('people');
    $shops = $this->model('shop');
    $countries = $this->model('country');
    $categories = $this->model('category');
    $product = $this->model('product');
    $cart = $this->model('cart');
    $cart_unreg = $this->model('cart_unreg');
    $action = $this->model('action');
    $bannerstart = $this->model('bannerstart');

    if(!isset($_SESSION['cur'])){
        $lang2cur = array(
        "ru"=>2,
        "en"=>1,
        "ch"=>4,
        "it"=>3,
        "es"=>3
        );
        $_SESSION['cur'] = $lang2cur[$_SESSION['lang']];
    }

    $mycart = 0;
    if($_SESSION['id']){
      $mycart = $cart->get_all_small_cart($_SESSION['id']);
    } else {
      $mycart = $cart_unreg->get_all_small_cart($this->get_uid());
    }

    //print_r($countries->get_countries($this->get_cur_lang()));
    if (isset($_SESSION['id']) and $_SESSION['id']) {
      return $this->template('central/central.php', array(
        'person' => $people->get_person($_SESSION['id'], true),
        'malls' => $shops->get_malls(),
        'products' => $product->get_central_products("limit 0,100"),
        'actions' => $action->get(),
        'banners' => $bannerstart->get_banners(),
        'categories' => $categories->get_categories(0,true),
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        'cart'=>$mycart,
        'is_central'=>1
        ));
        }

    //seo
    return $this->template('central/central.php', array(
          //'person' => $people->get_person($_SESSION['id'], true),
        'malls' => $shops->get_malls(),
        'banners' => $bannerstart->get_banners(),
        'products' => $product->get_central_products("limit 0,20"),
        'categories' => $categories->get_categories(0,true),
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        //'cart'=>$cart->get_all_small_cart($_SESSION['id']),
        'cart'=>$mycart,
        'is_central'=>1
        ));
  }

  public function cart($params) {

    $cart = $this->model('cart');
    $cart_unreg = $this->model('cart_unreg');

    $mycart = 0;
    if($_SESSION['id']){
      $mycart = $cart->get_all_small_cart($_SESSION['id']);
    } else {
      $mycart = $cart_unreg->get_all_small_cart($this->get_uid());
    }

    return $this->template('central/central.php', array(
        'cart'=>$mycart,
        ));
  }

  public function categories($params) {
    $categories = $this->model('category');
    return $this->template('central/central.php', array(
        'categories' => $categories->get_categories(0,true),
        ));
  }

  public function products($params) {
    $product = $this->model('product');

    return $this->template('central/central.php', array(
        'products' => $product->get_central_products("limit 0,100"),
        ));
  }

  public function malls($params) {
    $shops = $this->model('shop');
    return $this->template('central/central.php', array(
        'malls' => $shops->get_malls(),
        ));
  }

  public function banners($params) {

    $bannerstart = $this->model('bannerstart');
    return $this->template('central/central.php', array(
        'banners' => $bannerstart->get_banners(),
        ));
  }

  public function centralapi($params) {

    $people = $this->model('people');
    $shops = $this->model('shop');
    $countries = $this->model('country');
    $categories = $this->model('category');
    $product = $this->model('product');
    $cart = $this->model('cart');
    $cart_unreg = $this->model('cart_unreg');
    $action = $this->model('action');
    $bannerstart = $this->model('bannerstart');

    if(!isset($_SESSION['cur'])){
        $lang2cur = array(
        "ru"=>2,
        "en"=>1,
        "ch"=>4,
        "it"=>3,
        "es"=>3
        );
        $_SESSION['cur'] = $lang2cur[$_SESSION['lang']];
    }


    //print_r($countries->get_countries($this->get_cur_lang()));
    if (isset($_SESSION['id']) and $_SESSION['id']) {
      return $this->template('central/central.php', array(
        'person' => $people->get_person($_SESSION['id'], true),
        'actions' => $action->get(),
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        'is_central'=>1
        ));
        }

    //seo
    return $this->template('central/central.php', array(
          //'person' => $people->get_person($_SESSION['id'], true),
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        //'cart'=>$cart->get_all_small_cart($_SESSION['id']),
        'is_central'=>1
        ));
  }

  public function region_select($params) {
    /*if (! $_SESSION['id']) {
      //TODO add a proper 404 / profile not found here
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }*/

    $region = $this->model('region');
    $regions = $region->get_regions($params[3]);

    $this->template('central/region_select.php', array(
        'regions' => $regions,
    ));
  }

  public function category($params) {
    $people = $this->model('people');
    $shops = $this->model('shop');
    $countries = $this->model('country');
    $categories = $this->model('category');
    $product = $this->model('product');
    $cart = $this->model('cart');

    $category_id=$params[3];

    $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;

    $products = $product->get_products(array(
            "category_id"=>$category_id,
            "details"=>false,
            "access"=>true,
            "curpage"=>$curpage));

    if (!isset($_SESSION['id'])) {
    return $this->template('central/central_category.php', array(
          //'person' => $people->get_person($_SESSION['id'], true),
        'categories' => $categories->get_categories(0,true),
        'category' => $categories->get_category($category_id, true),
        'products' => $products['products'],
        'nextpage'=>$products['nextpage'],
        'totalpages'=> $products['totalpages'],
        //'filter' => $products['filter'],
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        //'cart'=>$cart->get_all_small_cart($_SESSION['id']),
        'is_central'=>1
      ));
    }

/*    $curpage=(isset($_GET['curpage']) && is_numeric($_GET['curpage']))?$_GET['curpage']:0;

    $products = $product->get_products(array(
            "category_id"=>$category_id,
            "details"=>false,
            "access"=>true,
            "curpage" => $curpage,
            ));
*/
    $this->template('central/central_category.php', array(
          'person' => $people->get_person($_SESSION['id'], true),
        'categories' => $categories->get_categories(0,true),
        'category' => $categories->get_category($category_id, true),
        'products' => $products['products'],
        'nextpage'=>$products['nextpage'],
        'totalpages'=> $products['totalpages'],
        'filter' => $products['filter'],
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        'cart'=>$cart->get_all_small_cart($_SESSION['id']),
        'is_central'=>1
      ));

  }


  //поиск по магазинам
  public function searchorg($params) {
    if (! $_SESSION['id']) {
      //TODO add a proper 404 / profile not found here
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }

    $people = $this->model('people');
    $shops = $this->model('shop');
    $countries = $this->model('country');
    $categories = $this->model('category');
    $cart = $this->model('cart');

    $shop=$shops->search(array(
        "name"=>$_POST['name'],
                        "country_id"=>$_POST['country_id'],
        ));

    $this->template('central/central_shops.php', array(
        'person' => $people->get_person($_SESSION['id'], true),
        'categories' => $categories->get_categories(0,true),
        //        'products' => $product->get_all($category_id),
        'countries'=>$countries->get_countries($this->get_cur_lang()),
        'shops'=>$shop,
        'searchorg'=>$_POST,
        'cart'=>$cart->get_all_small_cart($_SESSION['id']),
        'is_central'=>1
    ));
  }


  //поиск по товарам
  public function searchproduct($params) {
    /*if (! $_SESSION['id']) {
      //TODO add a proper 404 / profile not found here
      header("Location: " . PartuzaConfig::get('web_prefix') . "/");
      die();
    }*/

    $curpage=(isset($_REQUEST['curpage']) and is_numeric($_REQUEST['curpage']) and $_REQUEST['curpage']>0)?$_REQUEST['curpage']:0;

    $people = $this->model('people');
    $shops = $this->model('shop');
    $countries = $this->model('country');
    $categories = $this->model('category');
    $product = $this->model('product');
    $cart = $this->model('cart');
    $article = $this->model('articles');

    $name=$_REQUEST['name'];
    global $db;
    $name = $db->addslashes($name);

    $shop=null;
    $groups=null;
    $shop_id=false;
    $articles=null;

    if(isset($_REQUEST["shop_id"]) and is_numeric($_REQUEST["shop_id"])){
      $shop_id=$_REQUEST["shop_id"];
      $shop=$shops->get_shop($shop_id);

      $group = $this->model('group');
      $groups=$group->get_groups($shop_id, 0, true);
      $articles=$article->get_articles($shop_id,0, true);
    }

    $price_id = 0;
    if(isset($_REQUEST['price_id']) and is_numeric($_REQUEST['price_id'])){
      $price_id=$_POST['price_id'];
    }

    $category_id = 0;
    if(isset($_REQUEST['category_id']) and is_numeric($_REQUEST['category_id'])){
      $category_id=$_POST['category_id'];
    }

    $group_id = 0;
    if(isset($_REQUEST['group_id']) and is_numeric($_REQUEST['group_id'])){
      $group_id=$_REQUEST['group_id'];
    }

    $productpropery_id = 0;
    if(isset($_REQUEST['productpropery_id']) and is_numeric($_REQUEST['productpropery_id'])){
      $productpropery_id=$_REQUEST['productpropery_id'];
    }

    $minprice = false;
    if(isset($_REQUEST['minprice']) and is_numeric($_REQUEST['minprice'])){
      $minprice=$_REQUEST['minprice'];
    }

    $maxprice = false;
    if(isset($_REQUEST['maxprice']) and is_numeric($_REQUEST['maxprice'])){
      $maxprice=$_REQUEST['maxprice'];
    }

    $props = array();
    foreach ($_REQUEST as $o => $value) {
        if(preg_match("/^p_([0-9]+)/", $o, $regs)){
          $property['property_id'] = $regs[1];
          $property['value'] = $value;
          //$props[] = $property;
          if(preg_match("/ /", $value, $regs2)){
            preg_replace("/ /", " \& ", $value);
            $value = "(".$value.")";
          }
          $props[] = $value;
        }
    }

    if($props){
      $name=$name. " & (".implode(' | ', $props).")";
    }
    //echo $name;

    $products=$product->search(array(
        "string"=>$name,
        "property"=>$_REQUEST["property"],
        "shop_id"=>$shop_id,
        "category_id"=>$category_id,
        "productpropery_id"=>$productpropery_id,
        "group_id"=>$group_id,
        "price_id"=>$price_id,
        "minprice"=>$minprice,
        "maxprice"=>$maxprice,
        //"props"=>$props,
        "details"=>true,
        "access"=>true,
        "curpage"=>$curpage
    ));

/*
    $products=$product->get_products(array(
        "filter"=>" and name like '123123123123123%$name%'",
        "shop_id"=>$shop_id,
        "category_id"=>$category_id,
        "details"=>true,
        "access"=>true
    ));
    */

    if(isset($_SESSION['id'])) {
        $this->template('central/central_searchproduct.php', array(
                        'person' => $people->get_person($_SESSION['id'], true),
                        'categories' => $categories->get_categories(0,true),
                        'products' => $products['shops'],
                        'filter' => $products['filter'],
                        'nextpage' => $products['nextpage'],
                        'totalpages' => $products['totalpages'],
                        "productproperties" => $products["productproperties"],
                        'countries'=>$countries->get_countries($this->get_cur_lang()),
                        'shop'=>$shop,
                        'articles'=>$articles,
                        'searchproduct'=>$_REQUEST,
                        'cart'=>$cart->get_all_small_cart($_SESSION['id']),
                        'groups'=>$groups,
                        'is_central'=>1
        ));

    } else {
        $this->template('central/central_searchproduct.php', array(
                        'categories' => $categories->get_categories(0,true),
                        'products' => $products['shops'],
                        'nextpage' => $products['nextpage'],
                        'totalpages' => $products['totalpages'],
                        "productproperties" => $products["productproperties"],                        
                        'filter' => $products['filter'],
                        'countries'=>$countries->get_countries($this->get_cur_lang()),
                        'shop'=>$shop,
                        'articles'=>$articles,
                        'searchproduct'=>$_REQUEST,
                        'groups'=>$groups,
                        'is_central'=>1
        ));
    }

  }


  //показать корзину ajax
  public function small_cart($params) {
    /*if (! $_SESSION['id']) {
      header("Location: /");
      return;
    }*/

    if ($_SESSION['id']) {
      $cart = $this->model('cart');
      $small_cart=$cart->get_all_small_cart($_SESSION['id']);
    } else {
      $cart = $this->model('cart_unreg');
      $small_cart=$cart->get_all_small_cart($this->get_uid());
    }

    $this->template('central/small_cart.php', array(
        'cart' => $small_cart));
  }
}
