<?php
/**
 */

class groupModel extends Model {
  public $table="`group`";
  //public $cachable = array('get_groups', 'get_groups_of_product', 'get_group');
  public $supported_fields = array('id', 'name', 'group_id', 'visible','ordr','shop_id', 'goodTypeAvito');//'thumbnail_url',

  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      $id = $this->add($shop_id, $_REQUEST);
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->get_group($id);
  }

  public function GET($id, $shop_id){
    return $this->get_group($id);
  }

  public function GETlist($shop_id){
    return $this->get_groups($shop_id, 0, true, false);
  }
  //подготовить список
  public function load_get_groups($shop_id=0, $group_id=0, $details=false, $access=false){
    global $db;

    $m = new Memcached();
    $m->addServer('localhost', 11211);

    $groupscash = $m->get('shop_groups_'.$shop_id);
    if(!empty($groupscash)){
      if($group_id == 0 and $details){
         return $groupscash;
      }else if($group_id>0){
	while (list($key, $g) = each($groupscash)) {
	  if($g["id"] == $group_id){
	    return $g["subs"];
	  }
	}             
      }
    }

    //права доступа
    $sql="";
    //$product=$this->get_model("product");
    $access = false; // временно отменить настройки
    $shop=$this->get_model("shop");
    $shopaccess=$shop->get_shop($shop_id);
    $isusergroups=false;
    if($access){
      list($sql, $isusergroups)=$this->get_groupaccess_sql($shop_id);
    }else{
      $sql.=" and visible>-1 ";
    }
//var_dump("get groups $group_id ".time());
  $query="select distinct `group`.* from `group`"
        .($isusergroups?", `product_access`":"")
        ." where 1"
        .(($sql)?" $sql ":"")
        ." and group.shop_id=$shop_id and group.group_id=$group_id order by group.ordr, group.id";
//var_dump($query);
    $res = $db->query($query);

    if (! $db->num_rows($res)) {
      return null;
    }
    //print_r($res->fetch_array(MYSQLI_ASSOC));
    $groups=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
//var_dump("next ".time());

      //убрал зацикливание подгрупп так как они не были нужны
      //$data['name']=$data['name_en'];
       if($details){
//         if($data['group_id'] > 0) $details = false;
         $data['subs']=$this->get_groups($shop_id, $data['id'], $details);
         $data['num_of_subs']=count($data['subs']);
       }
       if($data != null){
         $groups[]=$data;
       }
    }
    // $groups = [];
    if($group_id == 0 and $details and $groups){
      $m->set('shop_groups_'.$shop_id, $groups, 3600*24);
    }

    return $groups;
  }


  //подготовить группу
  public function load_get_group($id, $details=false){
    global $db;
    $res = $db->query("select * from `group` where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['name']=$data['name_en'];

      if($details){
        $data['subs']=$this->get_groups($data['shop_id'], $data['id'], $details);
      }
      return $data;
    }
  }

  //добавить группу
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);

    $keys[]="shop_id";
    $values[]=$shop_id;

/*    $keys[]="visible";
    $values[]=1;*/

    if(!isset($params['ordr'])){
      $keys[]="ordr";
      $res=$db->query("select max(ordr) as max_ordr from `group` where shop_id=$shop_id" );
      $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
      $values[]=1+$max_ordr['max_ordr'];
    }

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

    $query = "insert into `group` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);

    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_groups_'.$shop_id);

    return $db->insert_id();
  }

  //сохранить группу
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
      $query = "update `group` set " . implode(', ', $update) . " where id=$id";
      $db->query($query);

      $m = new Memcached();
      $m->addServer('localhost', 11211);
      $m->delete('shop_groups_'.$params['shop_id']);

    }
  }

  public function set_thumbnail($id, $url) {
    global $db;
    $this->invalidate_dependency('group', $id);
    $id = $db->addslashes($id);
    $url = $db->addslashes($url);
    $db->query("update `group` set thumbnail_url = '$url' where id = $id");
  }

  //удалить группу
  public function delete($id){
    global $db;

    $res = $db->query("select shop_id from `group` where id=$id" );
    $data = $res->fetch_array(MYSQLI_ASSOC);

    $id = $db->addslashes($id);
    $res=$db->query("delete from `group` where id=$id" );
    $this->delete_by_group_id($id);

    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_groups_'.$data['shop_id']);

  }

  //удалить подгруппы
  public function delete_by_group_id($group_id){
    global $db;
    $group_id = $db->addslashes($group_id);

    $res=$db->query("select id from `group` where group_id=$group_id" );
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $this->delete($data['id']);
    }
  }

  public function load_get_groups_of_product($product_id){
    global $db;
    $product_id = $db->addslashes($product_id);

    $res=$db->query("select group_id from `group_product` where product_id=$product_id order by group_id" );
    $arr=array();
    //$data = $res->fetch_array(MYSQLI_ASSOC);
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        
        $group=$this->get_group($data['group_id']);
        $data['group_id']=$group['group_id'];
        if($group){
          $arr[]=$group;
        }
    }

    return $arr;
  }


  //права доступа к группе (вычисляется рекурсивно)
  public function get_groupaccess($group_id){
    global $db;
    $group_id = $db->addslashes($group_id);
    if(!$group_id){
      return array(0,5);
    }

    $res=$db->query("select visible, group_id from `group` where id=$group_id" );
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      if($data['visible']==5){
        if($data['group_id']>0){
          return $this->get_groupaccess($data['group_id']);
        }else{
          $data['visible'];
        }
      }else{
        return array($group_id, $data['visible']);
      }
    }
    return array(0, 5);
  }

  public function get_groupaccess_sql($shop_id){
    global $db;
    $shop_id = $db->addslashes($shop_id);

    $shop=$this->get_model("shop");
    $shopaccess=$shop->get_shop($shop_id);
    $atypes=PartuzaConfig::get('shop_access_types');

    $usergroup=$this->get_model("usergroup");
    $mygroups=false;
    $groupaccess=false;

    $isuser=(isset($_SESSION['id'])?true:false);
    $isclient=false;
    $isusergroups=false;

    $accessar=array(0);//ACCESS_ALL
    if($isuser){
      $accessar[]=1;//ACCESS_COMIRON
      $accessar[]=5;//ACCESS_DEFAULT, чтобы отфильтровать потом
      $isclient=$shop->is_client($shop_id, $_SESSION['id']);
      if($isclient){
                    $accessar[]=2;//ACCESS_CLIENT

                    $mygroups = $usergroup->get_usergroups_of_clientedit($shop_id, $_SESSION['id']);
                    if(!empty($mygroups)){
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
      $sql_visible=" ((group.visible in (".implode(', ', $accessar).")) or (group.visible=4 and group.id=product_access.product_id ".
      ((isset($groupaccess) && is_array($groupaccess))?" and product_access.shopusergroup_id in (".implode(', ', $groupaccess).")":"").
      "))";
    }else{
      $sql_visible=" group.visible in (".implode(', ', $accessar).")";
    }

    $productaccess=0;
    $groupaccess=0;

    $sql="";
    if($atypes[$shopaccess['options_product']]=='ACCESS_ALL'){//показать все товары в любом случае
      //ничего не делать?
      $sql=" (".$sql_visible." or (group.visible='5'))";

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
    return array(" and ".$sql, $isusergroups);
  }


  public function prepare_new($params) {
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
      $res=$db->query("select max(ordr) as max_ordr from ".$this->table." where shop_id=$shop_id" );
      $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
      $values[]=1+$max_ordr['max_ordr'];

      $query = "insert into ".$this->table." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
      $db->query($query);
      return $db->insert_id();
    }
  }

  //импортировать группу
  public function import_string($shop_id, $params){
    global $db;

    //должны быть заданы магазин и артикул
    if(!isset($shop_id) or !is_numeric($shop_id) or !isset($params['name']))
      return false;

    $params['shop_id'] = $db->addslashes($shop_id);
    $params['name'] = $db->addslashes($params['name']);

    $params['name'] = preg_replace('/\"/','', $params['name']);  //,->.
    $params['name'] = preg_replace('/\'/','', $params['name']);  //,->.
    $params['name'] = preg_replace('/\\\/','', $params['name']);  //,->.
    if(!$params['name']) return false;

    if(isset($params['group'])){
      $params['group_id'] = $this->import_string( $shop_id, array('name'=>$params['group']));
    }

    //видимость 0, если не задана
    if(!isset($params['visible'])){
      $params['visible'] = 0;
    }

    $fields = false;
    $values = false;

    //есть ли он в базе
    $res = $db->query("select id from ".$this->table." where shop_id=$shop_id and name='".$params['name']."'".
      ($params['group_id']?" and group_id=".$params['group_id']:"") );
    $res = $db->fetch_row($res);
    $group_id = (isset($res[0])?$res[0]:0);

    //если нет, то добавить
    if(!isset($group_id) or !is_numeric($group_id) or $group_id<1){
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
      $db->query($query);
      $group_id=$db->insert_id();
    }else{
      // есть есть, то обновить
      $this->save($group_id, $params);
    }
    $m = new Memcached();
    $m->addServer('localhost', 11211);
    $m->delete('shop_groups_'.$shop_id);

    return $group_id;
  }

  //вернуть иерархию групп, которая содержит группы из массива ids и путь к этим группам
  public function get_tree_for_groups($shop_id, $ids){
    global $db;

//top id
//    $sql = "select distinct id from ".$this->table." where (id in (".implode(', ',$ids).") and group_id=0) or ".
//        "(id in (select group_id from ".$this->table." where id in  (".implode(', ',$ids).") and group_id>0))";
    $sql = "select distinct id from ".$this->table." where (id in (".implode(', ',$ids).")) or ".
        "(id in (select group_id from ".$this->table." where id in  (".implode(', ',$ids).") and group_id>0))";
//var_dump($sql);
    $res=$db->query($sql);
    $all_ids=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        $all_ids[]=$data['id'];
    }
//var_dump($all_ids);
    if(!is_array($this->allgroups)){
      $this->allgroups = $this->get_groups($shop_id, 0, true, false);
    }
    $allgroups = $this->allgroups;
    
//var_dump($allgroups);
    
    foreach ($allgroups as $index => $group) {
      if(!in_array($group['id'], $all_ids)){
        unset($allgroups[$index]);
      }
      foreach($group["subs"] as $index2 => $sub){
        if(!in_array($sub['id'], $all_ids)){
          unset($allgroups[$index]["subs"][$index2]);
        }
      }
    }
//var_dump($allgroups);
    if(count($allgroups) == 1 and count($allgroups[0]["subs"])>0){
	     $allgroups = $allgroups[0]["subs"];
    }

    return $allgroups;
  }

}
