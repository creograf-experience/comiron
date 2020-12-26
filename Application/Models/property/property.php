<?php
/**
 * свойства товаров и их значения
 */

class propertyModel extends Model {
  public $table="`property`";
  public $supported_fields = array('id', 'name', 'visible','ordr','shop_id');//'thumbnail_url',
  public $values_supported_fields = array('id', 'value', 'property_id', 'product_id','ordr','shop_id');//'thumbnail_url',
  public $table_value="`product_property`";

  public function POST($shop_id){
    //создать, если не задан id
    $id = $_REQUEST['id'];
    if(!isset($_REQUEST['id'])){
      $id = $this->add($shop_id, $_REQUEST);
    }else{
      $this->save($id, $_REQUEST);
    }
    return $this->get_property($id);
  }

  public function GET($id){
    return $this->get_property($id);
  }

  public function GETlist($shop_id){
    return $this->get_properties($shop_id);
  }

  //подготовить список свойств
  public function load_get_filter($product_ids=array(), $prop_ids=array()){
    global $db;
    if(!is_array($product_ids) or !count($product_ids)){ return array();}

    //min max цена
    $minprice = 0.01;
    $maxprice = 0;
    $query="select min(price) as minprice, max(price) as maxprice from product where id in (".implode(',', $product_ids).")";
    $res = $db->query($query);
    if (! $db->num_rows($res)) {
      return null;
    }
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $minprice = $data['minprice'];
      $maxprice = $data['maxprice'];
    }
    //$minprice=0;  $minprice = sprintf( "%d", $minprice);# $minprice =~s/,/./;
    //$maxprice||=0; $maxprice = sprintf( "%d", $maxprice+1);#  $maxprice =~s/,/./;

    //свойства

    $query="select DISTINCT property_id from ".$this->table_value." where product_id in (".implode(',', $product_ids).")";
    $res = $db->query($query);

    $props=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      if(!$data['property_id']) continue;

      //название
      $query="select name from ".$this->table." where id = ".$data['property_id'];
      $res2 = $db->query($query);
      $data2 = $res2->fetch_array(MYSQLI_ASSOC);
      $data['name'] = $data2['name'];

      //свойства товаров из списка
      $query="select DISTINCT value from ".$this->table_value." where property_id=".$data['property_id']." and product_id in (".implode(',', $product_ids).")";
      $res2 = $db->query($query);
      $data['values'] = array();
      while ($data2 = $res2->fetch_array(MYSQLI_ASSOC)) {
        $ischecked = 0;
        if(in_array($data['property_id'], $prop_ids)){
          $ischecked = 1;
        }
        $data['values'][] = array("value" => $data2['value'],
                                  "ischecked" => $ischecked);
      }

      $props[]=$data;
    }

  /*my @records;
  foreach my $p(@vals){
    my %prop;
    $prop{code} = $p;
    $prop{name} = GetScalarSQL("select name from ".$self->{prefix}."Property where code=?",$prop{code});

    my @props = GetArrayColSQL("select DISTINCT value from ".$self->{Table}." where codeProperty=? and codeTovar in ('".join("', '", @codesTovar)."') order by value ", $prop{code});
    my @rec = map{ {value=>$_} } @props;
    $prop{values} = \@rec;

    push @records, \%prop;
  }
  return [ undef, {"records"=>\@records,
      "minprice" => $minprice,
      "maxprice" => $maxprice}, "ok" ]; */

    return array("minprice"=>$minprice,
                 "maxprice"=>$maxprice,
                 "properties"=> $props);
  }

  //подготовить список свойств
  public function load_get_properties($shop_id=0){
    global $db;

    if(!$shop_id or $shop_id==0){
	return null;
    }
    //echo "shop_id:".$shop_id;
    //права доступа
    $sql="";
    $product=$this->get_model("product");
    $shop=$this->get_model("shop");

    $query="select * from ".$this->table." where shop_id=$shop_id order by ordr";
    $res = $db->query($query);

    if (! $db->num_rows($res)) {
      return null;
    }

    $props=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['name']=$data['name_en'];
      $data['values']=$this->get_values($shop_id, $data['id']);
      $props[]=$data;
    }
    return $props;
  }

  //подготовить список значений
  public function load_get_values($shop_id=0, $property_id){
    global $db;

    if(!$shop_id or !$property_id){
	return array();
    }
    //права доступа
    $sql="";
    $product=$this->get_model("product");
    $shop=$this->get_model("shop");

    $query="select * from ".$this->table_value." where shop_id=$shop_id and property_id=$property_id order by value";

    $res = $db->query($query);

    if (! $db->num_rows($res)) {
      return null;
    }

    $props=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['name']=$data['name_en'];
      $props[]=$data;
    }
    return $props;
  }

  //подготовить
  public function load_get_property($id){
    global $db;
    if(!$id>0) return array();

    $res = $db->query("select * from ".$this->table." where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['name']=$data['name_en'];

      if($details){
        $data['values']=$this->get_values($data['shop_id'], $data['id']);
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

/*  $keys[]="visible";
    $values[]=1;*/

    if(!isset($params['ordr'])){
      $keys[]="ordr";
      $res=$db->query("select max(ordr) as max_ordr from ".$this->table." where shop_id=$shop_id" );
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

    $query = "insert into ".$this->table." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);
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
      $query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
      $db->query($query);
    }
  }

  //удалить
  public function delete($id){
    global $db;
    $id = $db->addslashes($id);
    $res=$db->query("delete from ".$this->table." where id=$id" );

    //удалить свойства
    $this->delete_values_by_property_id($id);
  }

  //удалить свойства магазина
  public function delete_by_shop_id($shop_id){
    global $db;
    $shop_id = $db->addslashes($shop_id);

    $res=$db->query("select id from ".$this->table." where shop_id=$shop_id" );
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $this->delete($data['id']);
    }
  }


  //удалить свойства магазина
  public function delete_by_product_id($product_id){
    global $db;
    $product_id = $db->addslashes($shop_id);

    $res=$db->query("select id from ".$this->table." where product_id=$product_id" );
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $this->delete($data['id']);
    }
  }

  //удалить значения свойства
  public function delete_values_by_property_id($property_id){
    global $db;
    $property_id = $db->addslashes($property_id);

    $res=$db->query("select id from `product_property` where property_id=$property_id" );
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $this->delete($data['id']);
    }
  }

  public function load_get_props_of_product($product_id){
    global $db;
    if(!$product_id>0) return array();

    $product_id = $db->addslashes($product_id);

    $res=$db->query("select property_id from `product_property` where product_id=$product_id" );
    $arr=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      $arr[]=$this->get_property($data['property_id']);

    }
    return $arr;
  }

  //импортировать свойство и значение
  public function import_string($shop_id, $params){
    global $db;

    //должны быть заданы магазин и имя свойства
    if(!isset($shop_id) or !is_numeric($shop_id) or !isset($params['name']))
      return false;

    $params['shop_id'] = $db->addslashes($shop_id);
    $params['name'] = $db->addslashes($params['name']);

    $params['name'] = preg_replace('/\"/','', $params['name']);  //,->.
    $params['name'] = preg_replace('/\'/','', $params['name']);  //,->.
    $params['name'] = preg_replace('/\\\/','', $params['name']);  //,->.
    if(!$params['name']) return false;

    //видимость 0, если не задана
    if(!isset($params['visible'])){
      $params['visible'] = 1;
    }

    $fields = false;
    $values = false;

    //есть ли он в базе
    $res = $db->query("select id from ".$this->table." where shop_id=$shop_id and name='".$params['name']."'" );
    $res = $db->fetch_row($res);
    $id = (isset($res[0])?$res[0]:0);

    //если нет, то добавить
    if(!isset($id) or !is_numeric($id) or $id<1){
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
      $id=$db->insert_id();
    }else{
      // есть есть, то обновить
      $this->save($id, $params);
    }


    // значение
    $params['property_id'] = $id;
    $fields = false;
    $values = false;
    //есть ли он в базе
    $res = $db->query("select id from ".$this->table_value." where shop_id=$shop_id and property_id=$id and product_id=".$params['product_id'] );
    $res = $db->fetch_row($res);
    $value_id = (isset($res[0])?$res[0]:0);

    //если нет, то добавить
    if(!isset($value_id) or !is_numeric($value_id) or $value_id<1){
      foreach ($params as $key => $val) {
        if (in_array($key, $this->values_supported_fields)) {
          $fields[] = $key;
          if (is_null($val)) {
            $values[] = 'null';
          } else {
            $values[] = "'" . $db->addslashes($val) . "'";
          }
        }
      }

      $query = "insert into ".$this->table_value." (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
      $db->query($query);
      $value_id=$db->insert_id();

    }else{
      // есть есть, то обновить
      $this->save($value_id, $params);
    }

    return $value_id;
  }



  //показать свойства товаров
  public function load_get_props($product_id){
    global $db;
    if(!$product_id>0) return array();

    $res = $db->query("select * from ".$this->table_value." where product_id=$product_id");

    if (! $db->num_rows($res)) {
      return null;
    }

    $arr = array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      if(!$data['property_id']>0) continue;
      $res2 = $db->query("select name from ".$this->table." where id=".$data['property_id'] );
      $res2 = $db->fetch_row($res2);
      $data['name'] = (isset($res2[0])?$res2[0]:0);
      $arr[] = $data;
    }

    return $arr;
  }

  //подготовить список свойств
  public function get_properties_distinct($props_id){
    global $db;

    if(!$props_id or !is_array($props_id)){
	     return null;
    }
    $sql="";
    $product=$this->get_model("product");
    $shop=$this->get_model("shop");

    $query="select DISTINCT property_id, shop_id from ".$this->table_value." where id in (".implode(',',$props_id).")";
//    $query="select * from ".$this->table_value." where value in (select value from ".$this->table_value." where id in (".implode(',',$props_id).")".
//         " group by value having count(value)=1)";

//var_dump($query);
    $res = $db->query($query);

    if (! $db->num_rows($res)) {
      return null;
    }

    $props=array();
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //название свойства
      $query="select * from ".$this->table." where id=".$data['property_id'];
      $res2 = $db->query($query);
      if (! $db->num_rows($res)) {
        continue;
      }
      $data2 = $res2->fetch_array(MYSQLI_ASSOC);
      $data["property_name"] = $data2["name"];

      //значения свойств
      $query="select distinct value, min(id) as id from ".$this->table_value." where property_id=".$data['property_id']." group by value";
      $res2 = $db->query($query);
      $filtered = [];
      while ($data2 = $res2->fetch_array(MYSQLI_ASSOC)) {
         $p["value"]=$data2["value"];
         $p["id"]=$data2["id"];
	 $p["property_id"]=$data["property_id"];
         $filtered[]=$p;
      }
      $data['values']=$filtered;

      if(count($filtered)>0){
        $props[]=$data;
      }
    }
    return $props;
  }

}
