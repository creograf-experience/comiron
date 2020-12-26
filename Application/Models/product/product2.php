<?php
/**
 */

class productModel extends Model {
  public $cachable = array('get_products', 'get_char');
  public $table = "`product`";      //public, чтобы в Model было доступно этой свойство
  private $perpage=50;
  private $supported_fields = array('id', 'name', 'code', 
      'price', 'currency_id',
      'visible','ordr','shop_id','isspecial', 'likes_num','comment_num','shares_num',
      'photo_url',
      'name_ru', 'name_en', 'name_it', 'name_ch','name_es', 'descr', 'package', 'box', 'freedelivery', 'edizm',
      'weight', 'volume', 'w', 'h', 'd', 'sklad',
      'discount', 
      'primarykey', //Ид из 1С и прочих внешних систем
      'kratnost',
      'razmerme',
      'ismerniy'
      );//'thumbnail_url',
  
  private $supported_fields_char = array('id', 'name', 'product_id', 'shop_id', 'price', 'sklad', 'barcode');
  
  public function POST($shop_id){
    $shop = $this->get_controller("shop");
    //создать товар, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      $id = $this->add($shop_id, $_REQUEST);
    }
    $shop->do_edit_product($id, $shop_id);
    return $this->get_product($id, true);
  }

  public function GET($id){
    return $this->get_product($id, true);
  }

  public function GETlist($shop_id){
    $products = $this->get_products(array("shop_id"=>$shop_id));
    return $products['products'];
  }

  //поиск
  //$shop_id=0, $category_id=0
  public function search($params){

    global $db;
    $shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
    $string=(isset($params['string'])?$params['string']:0);
#   $group_id=(isset($params['group_id'])?$params['group_id']:0);
    $category_id=(isset($params['category_id'])?$params['category_id']:0);
    $start=(isset($params['start'])?$params['start']:false);
    $limit=(isset($params['limit'])?$params['limit']:false);
    $access=(isset($params['access'])?$params['access']:false);
    $orderby=(isset($params['orderby'])?$params['orderby']:false);
    $minprice=(isset($params['minprice'])?$params['minprice']:false);
    $maxprice=(isset($params['maxprice'])?$params['maxprice']:false);
    $props=(isset($params['props'])?$params['props']:false);
    
    $limitpershop = 3;
    if($shop_id){
      $limitpershop = 100;
    }

    $group=$this->get_model("group");
    $shop=$this->get_model("shop");

    $usergroup=$this->get_model("usergroup");
    $currency=$this->get_model("currency");
    $category=$this->get_model("category");     
  
    //shop access
    $sql="";
    $isuser=(isset($_SESSION['id'])?true:false);
    $isclient=false;
    if($isuser and $shop_id){
      $isclient=$shop->is_client($shop_id, $_SESSION['id']);
    }    
    $isusergroups=false;
    $shopaccess=($shop_id)?$shop->get_shop($shop_id):false;
    if($access and isset($shop_id) and $shop_id>0){
      list($sql, $isusergroups)=$this->get_productaccess_sql($shop_id);
    }
    
    //поиск
    require_once PartuzaConfig::get('library_root').'/sphinxapi.php';
  //require_once('../Library/sphinxapi.php');

    $sphinx = new SphinxClient; 
    $sphinx->SetServer("127.0.0.1", 9312); 
    $sphinx->SetMatchMode( SPH_MATCH_EXTENDED );
    $sphinx->SetFieldWeights(array ( 
      'name' => 50, 
      'props' => 20,
      'descr' => 15, 
      'group' => '10'
    ));
        
    if($category_id){
      $sphinx->setFilter('category_id', array($category_id)); 
    }
    if($shop_id){
      $sphinx->setFilter('shop_id', array($shop_id)); 
    }
    /*$props = array('Зеленый');
    if($props){
      $sphinx->setFilter('props', array($props)); 
    }*/
    if($minprice>0.1 && $maxprice>0){
      $sphinx->setFilterFloatRange('price',$minprice,$maxprice);
    }
/*    if($group_id){
      $sphinx->setFilter('group_id', array($group_id)); 
    }*/
    $sphinx->SetLimits(0,100); 
//    $sphinx->SetLimits($start, $limit); //, 1000); 

    //$sphinx->setGroupBy('shop_id', SPH_GROUPBY_ATTR); 
    $result = $sphinx->Query($string, 'comiron_product');//$string
#    $result = $sphinx->query($string, 'comiron_product');//$string
    $shops = array();
    // Если есть результаты поиска, то

    if ($result && isset($result['matches']))
    {

    $ids = array_keys($result['matches']);
    //сгрупировать по магазинам
    $query="select shop_id, count(id) as count from `product`".
          " where id in (".implode($ids, ', ').") ".
        " group by shop_id ".
        " order by count desc";
    $res3 = $db->query($query);
    if (! $db->num_rows($res3)) {
        return array();
    }
    $product_ids = array();

    while ($found_shop = $res3->fetch_array(MYSQLI_ASSOC)) {   
      $shop_id=$found_shop['shop_id'];
      $query="select distinct `product`.* from `product`".
      //  ($isusergroups?", `product_access`":"").
          " where shop_id=".$shop_id." and id in (".implode($ids, ', ').") ".
          " limit $limitpershop"; 
      $res = $db->query($query);

      if (! $db->num_rows($res)) {
        return array();
      }
      $groups=array();
      while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        //$data['name']=$data['name_en'];
        //access доступ отключен
        if($access){
          $atypes=PartuzaConfig::get('shop_access_types');
          //права доступа группы
          $query="select group_id from group_product where product_id=".$data['id'];
          $res2 = $db->query($query);
          $res2=$res2->fetch_array(MYSQLI_ASSOC);
          $cur_group_id=$res2['group_id'];
          list($cur_group_id,$groupaccess)=$group->get_groupaccess($cur_group_id);
        
          if($atypes[$groupaccess]=='ACCESS_COMIRON'){//комирон
            if(!$isuser){
              continue;
            }
          }else if($atypes[$groupaccess]=='ACCESS_CLIENT'){//клиенты
            if(!$isclient){
              continue;
            }
          }else if($atypes[$groupaccess]=='ACCESS_NONE'){//никому
            continue;
          }else if($atypes[$groupaccess]=='ACCESS_GROUP'){//клиенты из групп
            //в каких группах пользователь
            //$client=$shop->get_clientdata($shop_id, $_SESSION_['id']);
            $shopgroups = $usergroup->get_usergroups2group_access($data['shop_id'], $cur_group_id);
            $visible=false;
          
            foreach ($shopgroups as $sg){
              foreach ($mygroups as $myg){
                if($myg['ismy'] && $sg['options_product'] && $myg['id']==$sg['id']){
                  $visible=true;
                  echo $myg['id'];
                }
              }
            }
            if(!$visible){
              continue;
            }
          }
          $product_ids[] = $data['id'];
      
          if($shopaccess){
            $data['shop']=$shopaccess;
          }else{
            $shopaccess=$shop->get_shop($data['shop_id']);
          }
        
        //price
          $showprice=false;
          $atypes=PartuzaConfig::get('shop_access_types');
          if($atypes[$shopaccess['options_price']]=='ACCESS_ALL'){
            $showprice=true;
          }else if($atypes[$shopaccess['options_price']]=='ACCESS_CLIENT'){
            if($shop->is_client($data['shop_id'], $_SESSION['id'])){
              $showprice=true;
            }
          }
          $data['priceisvisible']=$showprice; 
      
          //comment
          $showcomment=false;
          $atypes=PartuzaConfig::get('shop_access_types');
          if($atypes[$shopaccess['options_comment']]=='ACCESS_ALL'){
            $showcomment=true;
          }else if($atypes[$shopaccess['options_comment']]=='ACCESS_CLIENT'){
            if(isset($_SESSION['id']) and $shop->is_client($data['shop_id'], $_SESSION['id'])){
              $showcomment=true;
            }
          }
          $data['commentisvisible']=$showcomment;
        }
    
        $data['groups']=$group->get_groups_of_product($data['id']);
        $data['categories']=$category->get_categories_of_product($data['id']);
        //$data['chars']=$this->get_chars($data['id']);
        //$data['comment_num']=0;
        //$data['likes_num']=0;
        
        //скидка
        if(isset($data['discount']) and $data['discount']>0){
          $data['oldprice'] = $data['price'];
          $data['price'] = $data['price'] * (100 - $data['discount'])/100;
        }
    
        //пересчет валют
        if(isset($_SESSION['cur']) and ($_SESSION['cur'] != $data['currency_id'])){
          $data['original']['price']=$data['price'];
          $data['original']['currency_id']=$data['currency_id'];
          $data['original']['currency']=$currency->get_currency($data['currency_id']);
          
          $data['price'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['price']);
          if($data['oldprice']){
            $data['oldprice'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['oldprice']);
          }
          $data['currency_id'] = $_SESSION['cur'];
        }
        if($data['currency_id']){
          $data['currency']=$currency->get_currency($data['currency_id']);
        }else{
          $data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
        }
        $groups[]=$data;      
      }
      
      $shops[]=array("products"=>$groups,
          "shop"=>$shop->get_shop($shop_id));
      }
    }
    //свойства товаров для фильтра, мин. и макс. цена для фильтра
    $property = $this->get_model("property");
    $propfilter =  $property->get_filter($product_ids); //array("minprice"=> 99999999, "maxprice"=>0, "properties"=>array());
    return array("shops"=>$shops,
                 "filter"=>$propfilter); //$groups
  }
  
  public function get_count_isspecial($shop_id) {
      global $db;
      $res = $db->query("select count(id) as count from `product` where shop_id=$shop_id and isspecial = 1");
      return $db->fetch_array($res, MYSQLI_ASSOC);
  }
  
  //список избранных товаров для центрального Комирона (товары из избранных магазинов)
  public function get_central_products($limit){
    global $db;
    $limit=(isset($params['limit'])?$params['limit']:false);
    
    $res = $db->query("select id from `shop` where ismall");
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $shop_ids[]=$data['id'];
    }
  if (!$db->num_rows($res)) {
      return null;
    }
    $p = $this->get_products(array(
        "filter"=> " and visible>=0 and isveryspecial=1",
        "orderby"=> "isveryspecial desc, isspecial desc, ordr",
        "access"=>true
        ));
    $p = $p['products'];
    //пересортировать
    shuffle($p);
  
    $p2 = $this->get_products(array(
        "filter" => " and visible>=0 and (isspecial and shop_id in (".implode(', ', $shop_ids)."))",
        "orderby" => "isveryspecial desc, isspecial desc, ordr",
        "access" => true
        ));
    $p2 = $p2['products'];
    //проверка на NULL (чтобы работал array_merge)
    $p2 == NULL ? $p2 = []: $p2 = $p2;
    shuffle($p2);
    return array_merge($p, $p2);
  }
  
  //подготовить список 
  //$shop_id=0, $group_id=0, $details=false
  public function load_get_products($params){
    global $db;
    $shop_id=(isset($params['shop_id'])?$params['shop_id']:0);
    $group_id=(isset($params['group_id'])?$params['group_id']:0);
    $properties=(isset($params['properties'])?$params['properties']:false);
    $category_id=(isset($params['category_id'])?$params['category_id']:0);
    $details=(isset($params['details'])?$params['details']:false);
    $filter=(isset($params['filter'])?$params['filter']:false);
    $access=(isset($params['access'])?$params['access']:false);
    $orderby=(isset($params['orderby'])?$params['orderby']:false);
    $showsubgroups=(isset($params['showsubgroups'])?$params['showsubgroups']:false);

    $curpage=(isset($params['curpage'])?$params['curpage']:0);   
    $start = $curpage * $this->perpage;
    $limit = "limit $start, ".$this->perpage;

    //$limit=(isset($params['limit'])?$params['limit']:"limit 0, 100");
    //$limit=(isset($params['limit'])?$params['limit']:100);
    //$start=(isset($params['start'])?$params['start']:0);
  
    $group=$this->get_model("group");
    $shop=$this->get_model("shop");
    $usergroup=$this->get_model("usergroup");
    $currency=$this->get_model("currency");

    if($details){     
      $category=$this->get_model("category");     
    }

    $product_ids=array();   
    if($group_id){
      
      if($showsubgroups){
        $res = $db->query("select id from `group` where group_id=$group_id");
        while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
          $groups[]=$data['id'];
        }  
      }
      $groups[] = $group_id;

      $res = $db->query("select product_id from `group_product` where group_id in (".implode(', ', $groups).")");
      while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        $product_ids[]=$data['product_id'];
      }
    }
    
    if($category_id){
      $res = $db->query("select product_id from `category_product` where category_id=$category_id");
      while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        $product_ids[]=$data['product_id'];
      }
    }

    //свойства товаров для фильтра, мин. и макс. цена для фильтра - до фильтрации id по свойствам
    $property = $this->get_model("property");
    $prop_ids = array();
    foreach ($properties as $p) {
        $prop_ids[] = $p['property_id'];
    }
    $propfilter =  $property->get_filter($product_ids, $prop_ids); //array("minprice"=> 99999999, "maxprice"=>0, "properties"=>array());
    
    //фильтр по свойствам
    if($properties and $shop_id){
      $sql = "0 ";
      foreach ($properties as $p) {
        $sql .= " or (property_id = ".$p['property_id']." and value = '".$p['value']."')";
      }
      $res = $db->query("select product_id from `product_property` where $sql");
      if(count($product_ids)>0){ //фильтр по товарам из группы или категории, надо сделать пересечение с ранее выбранными товарами
        $arr = array();
        while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
          $arr[]=$data['product_id'];
        }
        $product_ids = array_uintersect($arr, $product_ids, "strcasecmp");
      }else{ //просто фильтр
        while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
          $product_ids[]=$data['product_id'];
        }
      }
    }
    
    //пустой раздел
    if(($category_id or $group_id) and count($product_ids)==0){
      return array();
    }
    
    //shop access
    $sql="";
    $isuser=(isset($_SESSION['id'])?true:false);
    $isclient=false;
    if($isuser and $shop_id){
      $isclient=$shop->is_client($shop_id, $_SESSION['id']);
    }    
    $isusergroups=false;
    $shopaccess=($shop_id)?$shop->get_shop($shop_id):false;
    if($access and isset($shop_id) and $shop_id>0){
      list($sql, $isusergroups)=$this->get_productaccess_sql($shop_id);
    }
    
     
    $query_pages = "select count(DISTINCT `product`.id) as number_of_products from `product`".
        ($isusergroups?", `product_access`":"")
        ." where 1"
        .(($sql)?" $sql ":"")
        .(($filter)?" $filter ":"")
        .(($shop_id)?" and product.shop_id=$shop_id ":"")
        .((isset($product_ids) and count($product_ids)>0 )?" and product.id in (".implode(', ', $product_ids).") ":"");        
    $res_pages = $db->query($query_pages);
    $num = $db->fetch_array($res_pages, MYSQLI_ASSOC);


    $total = (int)( ( $num['number_of_products'] - 1 ) / $this->perpage ) + 1;
    $next=false;
    if($total>$curpage+1){
      $next=$curpage+1;
    }
    //echo var_dump($num." - ".$next." - ".$total);
    
    $query="select distinct `product`.* from `product`".
        ($isusergroups?", `product_access`":"")
        ." where 1"
        .(($sql)?" $sql ":"")
        .(($filter)?" $filter ":"")
        .(($shop_id)?" and product.shop_id=$shop_id ":"")
        .((isset($product_ids) and count($product_ids)>0 )?" and product.id in (".implode(', ', $product_ids).") ":"")
        .(($orderby)?" order by $orderby, thumbnail_url DESC":" order by ordr, thumbnail_url DESC")
            ." $limit";
    $res = $db->query($query);
    if (! $db->num_rows($res)) {
      return array();
    }

    $product_ids = array(); //все ид товаров, чтобы вытащить их свойства

    $groups=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $product_ids[] = $data['id'];
      //$data['name']=$data['name_en'];
      //скидка
      if($data['name'] == NULL || $data['descr'] == NULL ){
        $data['checkedAvito'] = 0;
      }
      else
      $data['checkedAvito'] = 1;

      $data['realprice'] = $data['price'];
      if(isset($data['discount']) and $data['discount']>0){
        $data['oldprice'] = $data['price'];
        $data['price'] = $data['price'] * (100 - $data['discount'])/100;
      }
      //access
      if($access){
        $atypes=PartuzaConfig::get('shop_access_types');
        //права доступа группы
        $query="select group_id from group_product where product_id=".$data['id'];
        $res2 = $db->query($query);
        $res2=$res2->fetch_array(MYSQLI_ASSOC);
        $cur_group_id=$res2['group_id'];
        list($cur_group_id,$groupaccess)=$group->get_groupaccess($cur_group_id);
        
        if($atypes[$groupaccess]=='ACCESS_COMIRON'){//комирон
          if(!$isuser){
            continue;
          }
        }else if($atypes[$groupaccess]=='ACCESS_CLIENT'){//клиенты
          if(!$isclient){
            continue;
          }
        }else if($atypes[$groupaccess]=='ACCESS_NONE'){//никому
          continue;
        }else if($atypes[$groupaccess]=='ACCESS_GROUP'){//клиенты из групп
          //в каких группах пользователь
          //$client=$shop->get_clientdata($shop_id, $_SESSION_['id']);
          $shopgroups = $usergroup->get_usergroups2group_access($data['shop_id'], $cur_group_id);
          $visible=false;
            
          foreach ($shopgroups as $sg){
            foreach ($mygroups as $myg){
              if($myg['ismy'] && $sg['options_product'] && $myg['id']==$sg['id']){
                $visible=true;
                echo $myg['id'];
              }
            }
          }
          if(!$visible){
            continue;
          }
        }
        
        if($shopaccess){
          $data['shop']=$shopaccess;
        }else{
          $shopaccess=$shop->get_shop($data['shop_id']);
        }
        
        //price
        $showprice=false;
        $atypes=PartuzaConfig::get('shop_access_types');
        if($atypes[$shopaccess['options_price']]=='ACCESS_ALL'){
          $showprice=true;
        }else if($atypes[$shopaccess['options_price']]=='ACCESS_CLIENT'){
          if($shop->is_client($data['shop_id'], $_SESSION['id'])){
            $showprice=true;
          }
        }
        $data['priceisvisible']=$showprice; 
        

        //comment
        $showcomment=false;
        $atypes=PartuzaConfig::get('shop_access_types');
        if($atypes[$shopaccess['options_comment']]=='ACCESS_ALL'){
          $showcomment=true;
        }else if($atypes[$shopaccess['options_comment']]=='ACCESS_CLIENT'){
          if(isset($_SESSION['id']) and $shop->is_client($data['shop_id'], $_SESSION['id'])){
            $showcomment=true;
          }
        }
        $data['commentisvisible']=$showcomment;
      }
      
      if($details){
        $data['groups']=$group->get_groups_of_product($data['id']);
        $data['categories']=$category->get_categories_of_product($data['id']);
        //$data['comment_num']=0;
        //$data['likes_num']=0;
      }
      
         
      //пересчет валют
      if(isset($_SESSION['cur']) and ($_SESSION['cur'] != $data['currency_id'])){
        $data['original']['price']=$data['price'];
        $data['original']['currency_id']=$data['currency_id'];
        $data['original']['currency']=$currency->get_currency($data['currency_id']);
        
        $data['price'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['price']);
        if(isset($data['oldprice']) and $data['oldprice']>0){
          $data['oldprice'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['oldprice']);
        }
        $data['currency_id'] = $_SESSION['cur'];
      
      }
      if($data['currency_id']){
        $data['currency']=$currency->get_currency($data['currency_id']);
      }else{
        $data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
      }
      $groups[]=$data;      
    }
    
    return array("products"=>$groups, "filter"=>$propfilter, 
           "nextpage"=>$next,
           "totalpages"=>$total
           );
  }



  public function get_prev_product($id, $shop_id) {
    global $db;
    
    $res = $db->query("select id from `product` where id<$id and shop_id = $shop_id and name is not null and price>0 order by id desc");
    $result = $db->fetch_array($res, MYSQLI_ASSOC);
    if(empty($result['id'])) return array();

    $id_prev = $result['id'];

    $product = $this->get_product($id_prev, true);

    return $product;
    //array('info_product'=>$info_product, 'category'=>$category, 'group' => $group, 'props4edit'=> $product['props4edit']);
  }
  
  //подготовить продукт
  public function load_get_product($id, $details=false, $access=false){
    global $db;
    $res = $db->query("select * from `product` where id=$id");
    
    //$res = $db->query("select * from `product` where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['name']=$data['name_en'];
      $shop_id=$data['shop_id'];
      $data['realprice'] = $data['price'];
      //скидка
      if(isset($data['discount']) and $data['discount']>0){
        $data['oldprice'] = $data['price'];
        $data['price'] = $data['price'] * (100 - $data['discount'])/100;
      }
      
      if($access){
        $shop=$this->get_model("shop");
        $group=$this->get_model("group");
        $shopaccess=$shop->get_shop($shop_id);
        $atypes=PartuzaConfig::get('shop_access_types');
        //$data['shop']=$shopaccess;
        
        //доступ к продукту
        $sql=false;
        $isusergroups=false;
        $isuser=(isset($_SESSION['id'])?true:false);
        $isclient=false;
          if($isuser and isset($shop_id)){
          $isclient=$shop->is_client($shop_id, $_SESSION['id']);
        }    
        
        list($sql, $isusergroups)=$this->get_productaccess_sql($shop_id);
        $query="select distinct `product`.* from `product`".
            ($isusergroups?", `product_access`":"")
            ." where product.id=$id "
            .(($sql)?" $sql ":"");
        
        $res2 = $db->query($query);
          if (! $db->num_rows($res)) {
          return null;
        }
        
        //доступ к группе
        $query="select group_id from group_product where product_id=".$data['id'];
        $res2 = $db->query($query);
        $res2=$res2->fetch_array(MYSQLI_ASSOC);
        $cur_group_id=$res2['group_id'];
        list($cur_group_id,$groupaccess)=$group->get_groupaccess($cur_group_id);
          
        if($atypes[$groupaccess]=='ACCESS_COMIRON'){//комирон
          if(!$isuser){
            return null;
          }
        }else if($atypes[$groupaccess]=='ACCESS_CLIENT'){//клиенты
          if(!$isclient){
            return null;
          }
        }else if($atypes[$groupaccess]=='ACCESS_NONE'){//никому
          return null;
        }else if($atypes[$groupaccess]=='ACCESS_GROUP'){//клиенты из групп
          //в каких группах пользователь
          //$client=$shop->get_clientdata($shop_id, $_SESSION_['id']);
          $shopgroups = $usergroup->get_usergroups2group_access($shop_id, $cur_group_id);
          $visible=false;
            
          foreach ($shopgroups as $sg){
            foreach ($mygroups as $myg){
              if($myg['ismy'] && $sg['options_product'] && $myg['id']==$sg['id']){
                $visible=true;
                echo $myg['id'];
              }
            }
          }
          if(!$visible){
            return null;
          }
        }
                
        //price
        $showprice=false;
        $atypes=PartuzaConfig::get('shop_access_types');
        if($atypes[$shopaccess['options_price']]=='ACCESS_ALL'){
          $showprice=true;
        }else if(isset($_SESSION['id']) and $atypes[$shopaccess['options_price']]=='ACCESS_CLIENT'){
          if($shop->is_client($shop_id, $_SESSION['id'])){
            $showprice=true;
          }
        }
        $data['priceisvisible']=$showprice;
          
        //comment
        $showcomment=false;
        $atypes=PartuzaConfig::get('shop_access_types');
        if($atypes[$shopaccess['options_comment']]=='ACCESS_ALL'){
          $showcomment=true;
        }else if($atypes[$shopaccess['options_comment']]=='ACCESS_CLIENT'){
          if($shop->is_client($shop_id, $_SESSION['id'])){
            $showcomment=true;
          }
        }
        $data['commentisvisible']=$showcomment;
      }
      
      if($details){
      $currency=$this->get_model("currency");
      $group=$this->get_model("group");
      $property=$this->get_model("property");
      $category=$this->get_model("category");
    
          
        //пересчет валют
        if(isset($_SESSION['cur']) and ($_SESSION['cur'] != $data['currency_id'])){
          $data['original']['price']=$data['price'];
          $data['original']['currency_id']=$data['currency_id'];
          $data['original']['currency']=$currency->get_currency($data['currency_id']);
          
          $data['price'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['price']);
          if(isset($data['oldprice']) and $data['oldprice']){
            $data['oldprice'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['oldprice']);
          }
          $data['currency_id'] = $_SESSION['cur'];
          
        }
        if($data['currency_id']){
        $data['currency']=$currency->get_currency($data['currency_id']);
      }else{
        $data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
      }
        
        $data['groups']=$group->get_groups_of_product($data['id']);
        $data['categories']=$category->get_categories_of_product($data['id']);
        //$data['comment_num']=0;
        //$data['likes_num']=0;
        $data['chars']=$this->get_chars($data['id']);
        $data['props']=$property->get_props($data['id']);

        //достать из базы все варианты значений свойств товара для редактирования
        $data['props4edit']=$data['props'];
        $props = $property->get_properties($data['shop_id']);
        $i = 0;
        foreach($data['props4edit'] as $prop){ 
          $values = array();
          foreach($props as $p){
            if($p['id']==$prop['property_id']){
              $values = $p['values'];
            }
          } 
          $data['props4edit'][$i]['values'] = $values;
          $i++;
        }
        
      }
      
      return $data;
    }
  }
  
  //показать характеристику
  public function load_get_char($id){
    global $db;
  
    $res = $db->query("select * from `product_char` where id=$id");
  
    if (! $db->num_rows($res)) {
      return null;
    }
    
    
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $data['realprice'] = $data['price'];

      //товар
      $res = $db->query("select * from `product` where id=".$data['product_id']);
      $product = $res->fetch_array(MYSQLI_ASSOC);
      $data['currency_id'] = $product['currency_id'];
      $data['discount'] = $product['discount'];
      
      //скидка
      if(isset($data['discount']) and $data['discount']>0){
        $data['oldprice'] = $data['price'];
        $data['price'] = $data['price'] * (100 - $data['discount'])/100;
      }
      
      //пересчет валют
      if(isset($_SESSION['cur']) and ($_SESSION['cur'] != $data['currency_id'])){
        $data['original']['price']=$data['price'];
      $data['original']['currency_id']=$data['currency_id'];
      $data['original']['currency']=$currency->get_currency($data['currency_id']);
  
        $data['price'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['price']);
        if($data['oldprice']){
          $data['oldprice'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['oldprice']);
       }
       $data['currency_id'] = $_SESSION['cur'];
      }
    
    if($data['currency_id']){
        $data['currency']=$currency->get_currency($data['currency_id']);
      }else{
        $data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
      }
    }
  
    return $data;
  }
  
  //добавить
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);
    
    $keys[]="shop_id";
    $values[]=$shop_id;

/*    $keys[]="visible";
    $values[]=1;*/
    
    $keys[]="ordr";
    $res=$db->query("select max(ordr) as max_ordr from `product` where shop_id=$shop_id" );
    $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
    $values[]=1+$max_ordr['max_ordr'];
    
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields) and $key != "shop_id") {
        $keys[]=$db->addslashes($key);
        if (is_null($val)) {
          $values[] = "null";
        } else {
          $values[] = "'" . $db->addslashes($val) . "'";
        }
      }
    }

    $query = "insert into `product` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);
    $id=$db->insert_id();
        
    return $id;
  }
  
  //сохранить
  public function save($id, $params){
    global $db;
    $id = $db->addslashes($id);
        
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
      if (is_null($val)) {
        $update[] = $db->addslashes($key)." = null";
        } else {
          $update[] = $db->addslashes($key)." = '" . $db->addslashes($val) . "'";
        }
      }
    }
    
    if($update){
      $query = "update `product` set " . implode(', ', $update) . " where id=$id";
      
      $db->query($query);
    }
    return $id;
  }
  
  public function set_dop_thumbnail_photo($id, $thumbnail_url, $photo_url, $sort, $shop_id = 0) {
    global $db;
    $id = $db->addslashes($id);
    $thumbnail_url = $db->addslashes($thumbnail_url);
    $photo_url = $db->addslashes($photo_url);
    $sort = $db->addslashes($sort);
    $shop_id = $db->addslashes($shop_id);
    
    $query = "insert into `product_images` (product_id, thumbnail_url, photo_url, sort, shop_id) values(".$id.",'".$thumbnail_url."','".$photo_url."',".$sort.", ".$shop_id.")";
    $db->query($query);
    $id=$db->insert_id();
  
    return $id;
  }
  
  public function delete_dop_thumbnail_photo($id) {
    global $db;
    $query = "delete from `product_images` where id=".$id;
    $db->query($query);
  
    return 1;
  }
  
  public function set_thumbnail($id, $url) {
    global $db;
    $this->invalidate_dependency('group', $id);
    $id = $db->addslashes($id);
    $url = $db->addslashes($url);
    $db->query("update ".$this->table." set thumbnail_url = '$url' where id = $id");
  }

  public function set_photo($id, $url) {
    global $db;
    $this->invalidate_dependency('group', $id);
    $id = $db->addslashes($id);
    $url = $db->addslashes($url);
    $db->query("update ".$this->table." set photo_url = '$url' where id = $id");
  }
  
  public function get_dop_thumbnail_photo($id) {
        global $db;
        $res=$db->query("select * from `product_images` where product_id=$id ORDER BY sort" );
        return $db->fetch_all($res);
  }
  
  public function get_product_by_photo_id($id) {
    global $db;
    $res=$db->query("select product_id from `product_images` where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    $ret = $db->fetch_all($res);
    return $ret[0]['product_id'];
  }
  
  //добавить группу
  public function add_group($product_id, $group_id, $shop_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $group_id = $db->addslashes($group_id);
    
    $query = "insert into `group_product` (product_id, group_id, shop_id) values($product_id, $group_id, $shop_id)";
    $db->query($query);
    
    return;
  }

  //добавить категорию TODO: shop_id
  public function add_category($product_id, $category_id, $shop_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $category_id = $db->addslashes($category_id);
    $shop_id = $db->addslashes($shop_id);
  
    $query = "insert into `category_product` (product_id, category_id, shop_id) values($product_id, $category_id, $shop_id)";
    $db->query($query);
  
    return;
  }
  
  
  //добавить характеристику
  public function add_char($product_id, $params){
    global $db;
    $product_id = $db->addslashes($product_id);
    
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields_char)) {
        $keys[]=$db->addslashes($key);
        if (is_null($val)) {
          $values[] = "null";
        } else {
          $values[] = "'" . $db->addslashes($val) . "'";
        }
      }
    }
    
    $query = "insert into `product_char` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);
    $id=$db->insert_id();
    
    return;
  }
  

  //удалить
  public function delete($id){
    global $db;
    $id = $db->addslashes($id);
    $res=$db->query("delete from `product` where id=$id" );
    $this->delete_group_product_by_product_id($id);
    $this->delete_category_product_by_product_id($id);
    $this->delete_access_product_by_product_id($id);
    $this->delete_images_product_by_product_id($id);
    $this->delete_chars_product_by_product_id($id);
    $this->delete_property_product_by_product_id($id);

  }
  
  //удалить характеристики
  public function delete_chars_product_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $res=$db->query("delete from `product_char` where product_id=$product_id" );
  }
  
  //удалить свойства
  public function delete_property_product_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $res=$db->query("delete from `product_property` where product_id=$product_id" );
  }
  
  //удалить связь с группами
  public function delete_group_product_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $res=$db->query("delete from `group_product` where product_id=$product_id" );
  } 

  //удалить связь с категориями
  public function delete_category_product_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $res=$db->query("delete from `category_product` where product_id=$product_id" );
  }
  
   //удалить права доступа к товары
  public function delete_access_product_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $res=$db->query("delete from `product_access` where product_id=$product_id" );
  } 
  
   //дополнительные фото
  public function delete_images_product_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);
    $res=$db->query("delete from `product_images` where product_id=$product_id" );
  } 
  
  public function get_productaccess_sql($shop_id){
    global $db;
    $shop_id = $db->addslashes($shop_id);
    
    $shop=$this->get_model("shop");
    $shopaccess=$shop->get_shop($shop_id);
    $atypes=PartuzaConfig::get('shop_access_types');
//echo var_dump($shopaccess);

    $usergroup=$this->get_model("usergroup");
    $mygroups=false;
    $groupaccess=false;
    
    $isuser=(isset($_SESSION['id'])?true:false);
    $isclient=false;
    $isusergroups=false;
    $sql_nosklad = "";
    //прятать товары, которых нет на складе
    if($shopaccess['hideproductnosklad']){
        $sql_nosklad = "(product.sklad > 0)";
    }
    
    $accessar=array();
    $accessar[]=0; //ACCESS_ALL
    if($isuser){
      $accessar[]=1;//ACCESS_COMIRON
      $accessar[]=5;//ACCESS_DEFAULT, чтобы отфильтровать потом
      $isclient=$shop->is_client($shop_id, $_SESSION['id']);
      if($isclient){
        $accessar[]=2;//ACCESS_CLIENT
    
        $mygroups = $usergroup->get_usergroups_of_clientedit($shop_id, $_SESSION['id']);
                        if(!empty($mygroups)) {
                            foreach ($mygroups as $myg){
                                    $isusergroups=true;
                                    if($myg['ismy']){
                                            $groupaccess[]=$myg['id'];
                                    }
                            }
                        }
      }
    }
    if($isusergroups){
      $sql_visible=($sql_nosklad? $sql_nosklad." and ":"")." ((product.visible in (".implode(', ', $accessar).")) or (product.visible=4 and product.id=product_access.product_id ". 
          ((isset($groupaccess) && is_array($groupaccess))?" and product_access.shopusergroup_id in (".implode(', ', $groupaccess).")":"").
          "))";
    }else{
      $sql_visible=($sql_nosklad? $sql_nosklad." and ":"")." product.visible in (".implode(', ', $accessar).")";
    }
    
    $productaccess=0;
    $groupaccess=0;
    
    $sql="";
    if($atypes[$shopaccess['options_product']]=='ACCESS_ALL'){//показать все товары в любом случае
      //ничего не делать?
       
      $sql=" (".$sql_visible." or (product.visible='5'))";
    }else if($atypes[$shopaccess['options_product']]=='ACCESS_COMIRON'){//комирон
      if(isset($_SESSION['id'])){
        $sql=$sql_visible;
      }else{
        $sql=" 0";
        // TODO показывать только то, что настроено, что можно показывать
      }
    }else if($atypes[$shopaccess['options_product']]=='ACCESS_CLIENT'){//клиенты
      if($isclient){
        $sql=$sql_visible;
      }else{
        $sql=" 0";
      }
    }else if($atypes[$shopaccess['options_product']]=='ACCESS_NONE'){//никому
      $sql=" 0";
    }else if($atypes[$shopaccess['options_product']]=='ACCESS_GROUP'){//клиенты из групп
      //в каких группах пользователь
      //$client=$shop->get_clientdata($shop_id, $_SESSION_['id']);
      $shopgroups = $usergroup->get_usergroups_access($shop_id, 'product');
      $visible=false;
        
      foreach ($shopgroups as $sg){
        foreach ($mygroups as $myg){
          if($myg['ismy'] && $sg['options_product'] && $myg['id']==$sg['id']){
            $visible=true;
            echo $myg['id'];
          }
        }
      }
      if($visible){
        $sql=$sql_visible;
      }else{
        $sql=" 0";
      }
    }
    if($sql){
      $sql=" and ".$sql;
    }
    return array($sql, $isusergroups);
  }
  
  
  public function prepare_new_product($params) {
    global $db;
    $fields=false;
    $values=false;
     
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        $fields[] = $key;
        if (is_null($val)) {
          $values[] = 'null';
        } else {
          $values[] = "'" . $db->addslashes($val) . "'";
        }
      }
    }
  
    if($values){
      $fields[]="ordr";
      $shop_id=$params['shop_id'];
      $res=$db->query("select max(ordr) as max_ordr from `product` where shop_id=$shop_id" );
      $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
      $values[]=1+$max_ordr['max_ordr'];
      
      $query = "insert into ".$this->table." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
      $db->query($query);
      return $db->insert_id();
    }
  }
  
  //импортировать товар
  public function import_string($shop_id, $params, $lang = "ru"){
    global $db;
    
    //должны быть заданы магазин и артикул
    if(!isset($shop_id) or !is_numeric($shop_id) or !isset($params['code']))
      return false;
  
    $params['shop_id'] = $db->addslashes($shop_id);
    $params['code'] = $db->addslashes($params['code']);
    $params['primarykey'] = $db->addslashes($params['primarykey']);
    
    if($params['num']){
	$params['sklad']=$params['num'];
    }
    $fields = false;
    $values = false;
    
    //группа
    $group = 0;
    $subgroup_id = 0;
    if(isset($params['group'])){
      $group=$this->get_model("group");
      
      $group_id = $group->import_string($shop_id, array("name" => $params['group']));
      $param['group_id'] = $group_id;
      if(isset($params['subgroup']) && $params['subgroup']){
        $group_id = $group->import_string($shop_id, array("group" => $params['group'], "name" => $params['subgroup'], "group_id"=>$group_id));
        $param['group_id'] = $group_id;
      }       
    }
    
    //артикул может быть в cid, а может быть в code
    if(!isset($data['code']) and isset($data['cid']))
      $params['code'] = $params['cid'];
    
    //валюта
    if(isset($params['currency'])){
      $res = $db->query("select id from `currency` where code='".$params['currency']."'" );
      $res = $db->fetch_array($res);    
      
      if(isset($res['id'])){
        $params['currency_id'] = $res['id'];  
      } 
    }
    
    //цена должна быть числом
    $price = $params['price'];
    //$price = preg_replace('/ /','', $price);   //" "->""
    $price = preg_replace('/,/','.', $price);  //,->.
    $price = preg_replace('/[^0-9\.]/','', $price);  //все кроме цифр и точки
    $price = preg_replace('/\.$/','', $price);  //руб. - убирает точку в конце
    $params['price'] = $price; 
    //echo "price - $price - ".$params['price']." <br>";
      
    if(isset($params['price']) and !is_numeric($params['price'])){
      //echo "wrong price - ".$params['price']." <br>";
      return false;
    }
    
    //добавить subtitle к описанию (китайский файл)
    if(isset($params['subtitle'])){
      $params['description'] = $params['subtitle']."<br>".$params['description'];
    }
    //description->descr
    if(isset($params['description'])){
      $params['descr'] = $params['description'];
    }
    //title->name
    if(isset($params['title'])){
      $params['name'] = $params['title'];
    }
    if(!isset($params['name'])){
      $lang = 
      $params['name'] = $params['name_'.$lang];
    }
    $params['name'] = preg_replace('/\"/','', $params['name']);  //,->.
    $params['name'] = preg_replace('/\'/','', $params['name']);  //,->.
    $params['name'] = preg_replace('/\\\/','', $params['name']);  //,->.
    
    //видимость 0, если не задана
    if(!isset($params['visible']) or !is_numeric($params['package'])){
      $params['visible'] = 0;
    }
    if(!isset($params['package']) or !is_numeric($params['package'])){
      $params['package'] = 0;
    }
    if(!isset($params['w']) or !is_numeric($params['w'])){
      $params['w'] = 0;
    }
    if(!isset($params['h']) or !is_numeric($params['h'])){
      $params['h'] = 0;
    }
    if(!isset($params['d']) or !is_numeric($params['d'])){
      $params['d'] = 0;
    }
    if(!isset($params['volume']) or !is_numeric($params['volume'])){
      $params['volume'] = 0;
    }
    if(!isset($params['weight']) or !is_numeric($params['weight'])){
      $params['weight'] = 0;
    }
    if(!$params['name']) return false;
    
    //есть ли он в базе
    $res = $db->query("select id from `product` where shop_id=$shop_id and primarykey='".$params['primarykey']."'" );
    //echo "select id from `product` where shop_id=$shop_id and code='".$params['code']."'";

    $res = $db->fetch_row($res);
    $product_id = (isset($res[0])?$res[0]:0);
    //echo "product_id: ".$product_id."\n<br>";

    //если нет, то добавить
    if(!$params['primarykey'] or !isset($product_id) or !is_numeric($product_id) or $product_id<1){ 
      foreach ($params as $key => $val) {
        if (in_array($key, $this->supported_fields)) {
          $fields[] = $key;
          if (is_null($val)) {
            $values[] = 'null';
          } else {
            $values[] = "'" . $db->addslashes($val) . "'";
          }
        }
      }
      $query = "insert into ".$this->table." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
      //echo "insert into ".$this->table." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
      $db->query($query);
      $product_id=$db->insert_id();
    }else{
      // есть есть, то обновить
      $this->save($product_id, $params);
    }
    
    
    //связать группу с товаром
    if(isset($product_id) and is_numeric($product_id) and $product_id>0 and
       isset($group_id) and is_numeric($group_id) and $group_id>0){
      $query = "select product_id from group_product where product_id=$product_id and group_id=$group_id and shop_id=$shop_id";
      $res = $db->query($query);
      $res = $db->fetch_array($res); 
      $exist_id = (isset($res[0])?$res[0]:0);

      if($exist_id==0){
        //echo $exist_id;
        $query = "insert into group_product (product_id, group_id, shop_id) values ($product_id, $group_id, $shop_id)";
        $db->query($query); 
      }  
    }
    
    //заполнить свойства
    if(isset($product_id) and is_numeric($product_id) and $product_id>0 and isset($params['property1'])){
      $this->delete_property_product_by_product_id($product_id);

      $property=$this->get_model("property");
      
      $i = 1;
      while(isset($params['property'.$i])){
        $property->import_string($shop_id, array( "name" => $params['property'.$i],
                                                  "value" => $params['property_value'.$i],
                                                  "product_id" => $product_id));
        $i++;
      }
 /*
      $query = "select product_id from group_product where product_id=$product_id and group_id=$group_id and shop_id=$shop_id";
      $res = $db->query($query);
      $res = $db->fetch_array($res); 
      $exist_id = (isset($res[0])?$res[0]:0);

      if($exist_id==0){
        //echo $exist_id;
        $query = "insert into group_product (product_id, group_id, shop_id) values ($product_id, $group_id, $shop_id)";
        $db->query($query); 
      }  */
    }

    return $product_id;   
  }
  
  //id товара по артикулу и shop_id
  function get_product_from_code($shop_id,$code){
    global $db;
  
  $res = $db->query("select id from `product` where shop_id=$shop_id and code='".$code."'" );
    $row = $db->fetch_array($res, MYSQLI_ASSOC);
  
  return $row['id'];
  }

  //характеристики товара
  function get_chars($product_id){
    global $db;
    
    $currency=$this->get_model("currency");
    
    //товар
    $res = $db->query("select * from `product` where id=".$product_id);
    $product = $res->fetch_array(MYSQLI_ASSOC);
    //хар-ки
    $res = $db->query("select * from `product_char` where product_id=$product_id" );
    
    $r = array();
    while($data = $db->fetch_array($res, MYSQLI_ASSOC)){
      $data['realprice'] = $data['price'];
      $data['currency_id'] = $product['currency_id'];
      $data['discount'] = $product['discount'];
      
      //скидка
      if(isset($data['discount']) and $data['discount']>0){
        $data['oldprice'] = $data['price'];
        $data['price'] = $data['price'] * (100 - $data['discount'])/100;
      }
      
      //пересчет валют
      if(isset($_SESSION['cur']) and ($_SESSION['cur'] != $data['currency_id'])){
        $data['original']['price']=$data['price'];
        $data['original']['currency_id']=$data['currency_id'];
        $data['original']['currency']=$currency->get_currency($data['currency_id']);
      
        $data['price'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['price']);
        if($data['oldprice']){
          $data['oldprice'] = $currency->convert($data['currency_id'], $_SESSION['cur'], $data['oldprice']);
        }
        $data['currency_id'] = $_SESSION['cur'];
      }
      
      if($data['currency_id']){
        $data['currency']=$currency->get_currency($data['currency_id']);
      }else{
        $data['currency']=$currency->get_currency(PartuzaConfig::get('currency'));
      }
      
      $r[]=$data;
    }
    
    return $r;
  }
  
  
}
