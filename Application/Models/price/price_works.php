<?php

class priceModel extends Model {
    private $table = "price";
    private $supported_fields = array('id', 'id_shop', 'date', 'name','descr',"tags_id", "enddate", "is_sz","send2all");


    // json update must match with these array
    private $_UPDATED_TABLE = [
        "id_products" => "price_products",
        "name"        => "price",
        "id_clients"  => "id_clients"
    ];

    private $_UPDATED_COLUMN = [
        "price_products" => "id_product",
        "price"          => "name",
        "id_clients"     => "id_person"
    ];


    private $query = "SELECT p.id_shop,p.id, p.date, p.name, p.descr,p.tags_id, p.enddate, p.is_sz, p.send2all,
                    GROUP_CONCAT(distinct c.id_person) as id_clients,
                    GROUP_CONCAT(distinct b.cost ORDER BY b.id_product asc SEPARATOR ',') as cost_products,
                    GROUP_CONCAT(distinct b.id_product ORDER BY b.id_product asc SEPARATOR ',') as id_products
                    FROM `price` p
                    LEFT JOIN `id_clients` c ON p.id=c.id_price
                    LEFT JOIN `price_products` b ON p.id=b.id_price
                    %s
                    GROUP BY p.id, p.id_shop
                    ";


    private function get_pagination($shop_id, $limit, $page){
        // terrible & dirty api pagination but it works... hopefully.

        $count_prices = $this->get_total_page_num($shop_id, $limit);
        $count_prices = $count_prices['count_prices'];
        $page = $page == 1 ? $page = 0 : $page;
        $pre_offset = $limit * $page;
        $offset = $pre_offset  === 0 ? $offset = 1 : $pre_offset;
        $get_offset = round($count_prices / $offset);
        $offset = $get_offset == $count_prices ? $offset = 0 : $get_offset;
        $offset = $offset == 1 ? $count_prices-$limit : $offset ;
        $query_limit_offset = " LIMIT $limit OFFSET $offset";

        return $query_limit_offset;
    }

    private function make_select_prices($shop_id, $limit, $page){
        $limit_offset = $this->get_pagination($shop_id, $limit, $page);
        $query = "SELECT id, id_shop, `date`, `name`, descr FROM `price`";
        $query_chunk = " WHERE id_shop=%d ";
        $format_qurey = sprintf($query_chunk,$shop_id);
        $select_price = $query.$format_qurey.$limit_offset;
        return $select_price;
    }

    private function make_select_price_detail($shop_id, $id_price){
        $limit = 1;
//        $query_chunk = " WHERE p.id_shop=%d and p.id=%d and c.id_price=%d and b.id_price=%d ";
        $query_chunk = " WHERE p.id_shop=%d and p.id=%d ";
        $format_query = sprintf($query_chunk,$shop_id,$id_price, $id_price, $id_price);
        $select_prices = sprintf($this->query,$format_query) . " limit $limit";
        return $select_prices;
    }



    private function fetch_select_price_detail($res, $db){
        $i = 0;
        while ($query_item = $db->fetch_array($res, MYSQLI_ASSOC)) {
            $items = array_map('intval', explode(',', $query_item['id_products']));
            $id_clients = array_map('intval', explode(',', $query_item['id_clients']));

	          $price_detail['name'] = $query_item['name'];
	          $price_detail['descr'] = $query_item['descr'];

            $price_detail['enddate'] = $query_item['enddate'];
            $price_detail['is_sz'] = $query_item['is_sz'];
            $price_detail['send2all'] = $query_item['send2all'];
            $price_detail['tags_id'] = json_decode($query_item['tags_id']);

            $price_detail['price_id'] = intval($query_item['id']);
            $price_detail['id_shop'] = intval($query_item['id_shop']);
            $price_detail['id_clients'] = $id_clients;
            $price_detail['id_products'] = $items;
            $price_detail['date'] = intval($query_item['date']);

            $data[$i] = $price_detail;
            $i++;
        }
        return $data;
    }


    private function insert_price_products($db, $id_price, $shop_id, $products_instanse, $timestamp){
//	global $db;
        $mold_insert_price_products = "INSERT INTO price_products
                                    (id_product, id_price, id_shop, `date`, `cost`, `currency`, `measure_unit`,`tobuy`)
                                    ";
        foreach ($products_instanse as $v) {
            $id_product = intval($v['id']);
            $msg_err = " false insert $id_product in price_products... ";

            $query_mold = $mold_insert_price_products;

            $cost = floatval($v['cost']);
            $tobuy = floatval($v['tobuy'])? floatval($v['tobuy']) : 0 ;
        
            
            $currency = $v['currency'] || 'null';
            $measure_unit = $v['edizm'];
            $query_chunk = "VALUES ($id_product, $id_price,$shop_id, $timestamp, $cost, $currency, '$measure_unit',$tobuy)";
            $release_query = $query_mold.$query_chunk;
            $res = $db->query($release_query);
//            $response_array['id'] = $db->mysql_insert_id();

            $res ? '' : $response_array['error'] = $response_array['error'].$msg_err;
        }

        $response_array['error'] ? '' : $response_array['state'] = true;
        return $response_array;
    }


    private function insert_id_clients($db, $id_price,$shop_id, $id_clients, $timestamp){
        $response_array['state'] = false;
        $query_mold = "INSERT INTO id_clients (id_price, id_person, id_shop, `date`)
                        ";
        foreach ($id_clients as $id_person) {
            $msg_err = " false insert $id_person in id_clients... ";
            $query_chunk = "VALUES ($id_price, $id_person, $shop_id, $timestamp)";
            $release_query = $query_mold.$query_chunk;
            $res = $db->query($release_query);

            // add error for `else` statement
            $res ? '' : $response_array['error'] = $response_array['error'].$msg_err;
        }

        $response_array['error'] ? '' : $response_array['state'] = true;
        return $response_array;
    }


    private function insert_price_table($db, $params){
        // insert into price table and return its id
        $id_shop = $params['id_shop'];
        $date = $params['date'];
        $enddate = ($params['enddate']?$params['enddate']:0);
        $is_sz = ($params['is_sz']?$params['is_sz']:0);
        $send2all = ($params['send2all']?$params['send2all']:0);
        $name = $db->addslashes($params['name']);
        $tags_id = $db->addslashes(json_encode($params['tags_id']));
        $descr = $db->addslashes($params['descr']);

        $msg_err = "didn't insert $name in price table";
        $response_array['state'] = false;
        $query_mold = "INSERT INTO price (id_shop, `date`, `name`, descr, is_sz, enddate, tags_id,send2all)
                        ";

        $query_chunk = "VALUES ($id_shop, $date, '$name', '$descr',$is_sz,$enddate,'$tags_id', $send2all)";
        $release_query = $query_mold.$query_chunk;
        $res = $db->query($release_query);

        $res ? '' : $response_array['error'] = $response_array['error'].$msg_err;
        $response_array['error'] ? '' : $response_array['state'] = true;

        $select_query = "SELECT id FROM price WHERE id_shop=$id_shop and `date`=$date and `name`='$name' ORDER BY ID DESC LIMIT 1";

        $execute_query = $db->query($select_query);

        $get_price_id = $db->fetch_array($execute_query, MYSQLI_ASSOC);
        $response_array['price_id'] = $get_price_id['id'];

        return $response_array;
    }


    private function insert_price($db, $data, $id_clients, $products_instanse){
        // One price contains 3 tables (`price_products`, `id_clients`, `price`)
        // Therefore we need to insert into these tables

        $response_array['state'] = false;

        $insert_price_table = $this->insert_price_table($db, $data);
        $id_price = $insert_price_table['price_id'];

        $insert_price_products = $this->insert_price_products($db, $id_price, $data['id_shop'], $products_instanse, $data['date']);
        $insert_id_clients = $this->insert_id_clients($db, $id_price, $data['id_shop'], $id_clients, $data['date']);

	$response_array['price_id'] = $id_price;
        if($insert_price_products['state'] and $insert_id_clients['state'] and $insert_price_table['state']){
            $response_array['state'] = true;
        } else{
            $i = 0;
            $response_array['for_developer'][$i++] = $insert_id_clients;
            $response_array['for_developer'][$i++] = $insert_price_table;
            $response_array['for_developer'][$i++] = $insert_price_products;
        }
        return $response_array;
    }

    private function get_product_instances($db, $shop_id, $id_products){
        //  Get assoc array from `product` table by id_products(array).
        //  Contains id, cost, edizm, count and currency.

        $currency=$this->get_model("currency");

        $response_array['state'] = false;

        // если скрывать товары, которых нет на складе
        $sql = "";
        $shop = $this->get_model("shop");
        $thisshop = $shop->get_shop_info($shop_id);
        if($thisshop['hideproductnosklad']){
          $sql = " and sklad>0";
        }


        $query_mold = "SELECT `id`, `price` as cost, `edizm`, `sklad` as count, `currency_id` as currency_id FROM `product` WHERE shop_id=$shop_id ".$sql;
        $i=0;
        foreach ($id_products as $key => $value) {
            if(!$value){ continue; }

            $query = $query_mold;
            $query = $query . " and id=$value";
            $res = $db->query($query);
            $fetch_data = $db->fetch_array($res, MYSQLI_ASSOC);
            $fetch_data['currency']=$currency->get_currency($fetch_data['currency_id']);
            $response_array['data'][$i++] = $fetch_data;
        }
        $errors = "didn't match product_id ".$error." and shop_id '$shop_id'";
        $error ? $response_array['message'] = $errors : $response_array['state'] = true;
        return $response_array;
    }


    private function select_total_page_num($shop_id){
        $query_mold = "SELECT COUNT(id) as `id` FROM `price`";
        $query_chunk = "WHERE id_shop=$shop_id";
        return $query_mold.$query_chunk;
    }


    public function update_price($updated_data){
    	global $db;
      $id = $db->addslashes($updated_data['id']);
      $shop_id = $db->addslashes($updated_data['shop_id']);
      $updated_data['tags_id'] = $db->addslashes(json_encode($updated_data['tags_id']));
      $timestamp = $db->addslashes($updated_data['date']);
      $updated_data['id_shop']=$updated_data['shop_id'];
    	$update=false;

    	foreach ($updated_data as $key => $val) {
    		if (in_array($key, $this->supported_fields)) {
    			if (is_null($val)) {
    				$update[] = $db->addslashes($key)." = null";
    			} else {
    				$update[] = "`".$db->addslashes($key)."` = '" . $db->addslashes($val) . "'";
    			}
    		}
    	}
    	if($update){
    		$query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
//var_dump($query);
    		$db->query($query);
    	}
      //обновить товары
      //вытащить tobuy и цены из продуктов
      $query = "select * from price_products where id_price=".$id;
      $res = $db->query($query);
      $products_update = array();
      while ($data = $db->fetch_array($res, MYSQLI_ASSOC)) {
        $p["tobuy"] = $data["tobuy"];
        $p["cost"] = $data["cost"];
        $products_update[$data["id_product"]] = $p;
      }
    //var_dump($products_update);

      $res = $db->query("delete from price_products where id_price=".$id);
      if($updated_data['id_products']){
        $products_instanse = $this->get_product_instances($db, $shop_id, $updated_data['id_products']);

        foreach($products_instanse['data'] as $k => $v){
        //var_dump($products_instanse['data'][$k]);
        //var_dump($products_update[$products_instanse['data'][$k]["id"]]);
          if($products_update[$products_instanse['data'][$k]["id"]]){
            $products_instanse['data'][$k]["tobuy"] = $products_update[$products_instanse['data'][$k]["id"]]["tobuy"];
            $products_instanse['data'][$k]["cost"] = $products_update[$products_instanse['data'][$k]["id"]]["cost"];
          }
        }
        $insert_price_products = $this->insert_price_products($db, $id, $shop_id, $products_instanse['data'], $timestamp);
      }

      //обновить пользователей
      $res = $db->query("delete from id_clients where id_price=".$id);
      if($updated_data['id_clients']){
        $insert_id_clients = $this->insert_id_clients($db, $id, $shop_id, $updated_data['id_clients'], $timestamp);
      }

      $response_array['state'] = true;
      return $response_array;
    }

    public function get_total_page_num($shop_id, $limit){
        $response_array['state'] = false;
        global $db;

        $query = $this->select_total_page_num($shop_id);
        $res = $db->query($query);
        $query_item = $db->fetch_array($res, MYSQLI_ASSOC);
        $total = $query_item['id'];
        $pages = $total / $limit;

        $response_array['pages'] = intval($pages) + 1;
        $response_array['count_prices'] = $total;

        $response_array['state'] = true;

        return $response_array;
    }


    public function create_price($data){
        global $db;
        $msg_ok = "OK => ".__FUNCTION__." ";
        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";

        $shop_id = $data['id_shop'];
        $id_products = $data['id_products'];
        $id_clients = $data['id_clients'];
        $name = $data['name'];
        $descr = $data['descr'];
        $date = $data['date'];
//var_dump($data);

        $get_product_instances = $this->get_product_instances($db, $shop_id, $id_products);

        if ($get_product_instances['state']){
            $products_instanse = $get_product_instances['data'];

            $inserted = $this->insert_price($db, $data, $id_clients, $products_instanse);

	    $persons_id = [];
            //id_clients подписанных
            if(count($id_clients)>0){
              $sql = "select client_id from shop_clients
                    where shop_id=$shop_id and client_id in (".implode(',',$id_clients).")";
    	      $result = $db->query($sql);
              $persons_id = $db->fetch_array($result);
	    }

            if($inserted['state']){
        	      $response_array = $inserted;
                $response_array['state'] = true;
                $response_array['message'] = $msg_ok;
                $response_array['clients'] = $persons_id;
//var_dump($response_array);
            }

        } else{
            $response_array['details'] = $get_product_instances['message'];
        }

        return $response_array;
    }

    //
    public function get_shop_pri($price_id){
        global $db;
        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";

        $query = $this->make_select_prices($price_id);
        $res = $db->query($query);

        $i = 0;
        if ($db->num_rows($res)) {
            $data = $this->fetch_select_price_detail($res, $db);

            $response_array['state'] = true;
            $response_array['message'] = " OK =>  ".__FUNCTION__;
            $response_array['price'] = $data;
        } else{
            $for_developer['details'] = "select_price query return nothing";
            $response_array['for_developer'] = $for_developer;
        }
        return $response_array;
    }


    public function get_prices($shop_id, $page){
        global $db;

        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";
        $limit = 20;

        $query = $this->make_select_prices($shop_id, $limit, $page);
        $res = $db->query($query);
        if($res->num_rows){
            $response_array['state'] = true;
            $response_array['message'] = " OK =>  ".__FUNCTION__." ";

	          $ar=array();
            while($data = $res->fetch_array(MYSQLI_ASSOC)){
              $data["tags_id"] = json_decode($data["tags_id"]);
              $ar[]=$data;
            }

            $response_array['data'] = $ar;
        } else{
            $response_array['detail'] = "We made select in db but it return nothing";
        }

        return $response_array;
    }

    //$user_id, $shop_id, $page, is_sz
    public function get_userprices($params){
        global $db;

        $user_id = $db->addslashes($params['user_id']);
        $shop_id = $db->addslashes($params['shop_id']);
        $page = intval($params['page']);
        $is_sz = intval($params['is_sz']);

        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";
        $limit = 20;

        //список прайсов
        $query = "select distinct id_price from id_clients where id_person=".$user_id. (($shop_id>0)?" and id_shop=".$shop_id:"");
            //." and id_shop in (select shop_id from shop_clients where client_id=$user_id)";  //проверка подписки
        //var_dump($query);
        $res = $db->query($query);
        if (! $db->num_rows($res)) {
      		return $response_array;
      	}
      	$price_ids = array();
        while($id = $res->fetch_array()){
    	    $price_ids[]=$id[0];
        };


        //отфильтровать совместные закупки
        $query = "select distinct id from ".$this->table." where id in (".implode(',', $price_ids).") "
        ." or (send2all=1 and id_shop in (select shop_id from `shop_clients` where client_id=".$user_id."))"
        //.(($is_sz)?" and is_sz=1 ":" and is_sz=0")
        ." order by date desc ".$query_limit_offset;
//var_dump($query);
        $res = $db->query($query);
        if (! $db->num_rows($res)) {
      		return $response_array;
      	}
      	$price_ids = [];
        while($id = $res->fetch_array()){
    	    $price_ids[]=$id[0];
        };

        //пагинация
        $count_prices = count($price_ids);
        $response_array['count_prices'] = $count_prices;
        $response_array['pages'] = 1+floor($count_prices/$limit);

        //$page = $page == 1 ? $page = 0 : $page;
        $pre_offset = $limit * $page;
        $offset = $pre_offset  === 0 ? $offset = 1 : $pre_offset;
        $get_offset = round($count_prices / $offset);
        $offset = $get_offset == $count_prices ? $offset = 0 : $get_offset;
        $offset = $offset == 1 ? $count_prices-$limit : $offset ;
        $offset =($page-1) * $limit;
        $query_limit_offset = " LIMIT $offset, $limit";

        $query = "select * from ".$this->table." where id in (".implode(',', $price_ids).") order by date desc ".$query_limit_offset;
//var_dump($query);
        $res = $db->query($query);

        if($res->num_rows){
            $response_array['state'] = true;
            $response_array['message'] = " OK =>  ".__FUNCTION__." ";

	          $shop = $this->get_model("shop");
	          $ar=array();
            while($data = $res->fetch_array(MYSQLI_ASSOC)){
              $data['shop']=$shop->get_shop_info($data['id_shop']);
              $data["tags_id"] = json_decode($data["tags_id"]);

              //количество заказов на пользователя
              $data[num_orders]=0;
              $query = "select count(id) as res from priceorder where price_id=".$data['id']." and person_id=".$user_id;
              $r = $db->query($query);
              if($r->num_rows){
                $r = $r->fetch_array(MYSQLI_ASSOC);
                if($r['res'] > 0){
                  $data[num_orders] = $r['res'];
                }
              }

              $ar[]=$data;
            }

            $response_array['data'] = $ar;
        } else{
            $response_array['detail'] = "We made select in db but it return nothing";
        }

        return $response_array;
    }

    //$user_id, $shop_id, $page, is_sz
    //возвращает открытые закупки, которые надо закрыть
    public function get_opensz($params){
        global $db;

        //список прайсов
        $now = time();
        $query = "select id from ".$this->table." where enddate<$now and is_sz=1 and status=0";
        //var_dump($query);
        $res = $db->query($query);
        if (! $db->num_rows($res)) {
      		return $response_array;
      	}
      	$price_ids = array();
        while($id = $res->fetch_array()){
    	    $price_ids[]=$id[0];
        };

        return $price_ids;
    }


    public function get_price_detail($shop_id, $id_price, $user_id,$group_id = 0, $properties = 0) {
        global $db;

        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";

	//$db->query("SET @@global.group_concat_max_len = 1000000");
        $db->query("SET GLOBAL group_concat_max_len = 1000000");

        $query = $this->make_select_price_detail($shop_id, $id_price, $group_id);
//echo $query;
//	$query = "SET SESSION group_concat_max_len = 12000000; ".$query;
        $res = $db->query($query);
        $result = $this->fetch_select_price_detail($res, $db);

        // result don't have products. only its ids
        $result = $result[0];
//var_dump($result['id_products']);

        //фильтр по свойствам
        $property = $this->get_model("property");
        if($properties && count($result['id_products'])>0){
          if(!is_array($properties)){
            $properties = array($properties);
          }

          $sql_filter = "(0";
          foreach($properties as $prop){
            $ar = explode('_',$prop);
            $sql_filter .= " or (shop_id=$shop_id and property_id=$ar[0] and value=\"".$ar[1]."\") ";
          }
          $sql_filter .=")";

          //выбрать товары с данными свойствами
          $query = "select product_id from product_property where $sql_filter and ".
            " product_id in (".implode(', ', $result['id_products']).")";
          //var_dump($query);
          $res = $db->query($query);
          $product_ids = [];
          while ($product_id = $db->fetch_array($res, MYSQLI_ASSOC)) {
              $product_ids[] = $product_id["product_id"];
          }
          $result['id_products'] = $product_ids;
        }

        //фильтруем по группам
        $group = $this->get_model("group");
        if($group_id && count($result['id_products'])>0){
          $groups_id = [];
          if(is_numeric($group_id)){
            $groups_id[] = $group_id;
          }else if(is_array($group_id)){
            $groups_id = $group_id;
          }

          foreach ($groups_id as $group_id) {
            //выбрать подгруппы
            $groups = $group->get_groups($shop_id, $group_id);
            foreach ($groups as $key => $value) {
              $groups_id[] = $value['id'];
            }
          }

          //выбрать товары в группах и подгруппах
          $query = "select product_id from group_product where group_id in (".implode(', ', $groups_id).") and ".
            " product_id in (".implode(', ', $result['id_products']).")";
          //var_dump($query);
          $res = $db->query($query);
          $product_ids = [];
          while ($product_id = $db->fetch_array($res, MYSQLI_ASSOC)) {
	            $product_ids[] = $product_id["product_id"];
        	}
          $result['id_products'] = $product_ids;
        }
//var_dump($result['id_products']);
        $products_instanse = $this->get_product_instances($db, $shop_id, $result['id_products']);
        $productM = $this->get_model("product");
        $group = $this->get_model("group");

        $allgroups_ids = [];
        $allprops_ids = [];
        foreach($products_instanse['data'] as $key => $data){
        //var_dump($data);
         // цена
          $query = "select cost, tobuy from price_products where id_price=$id_price  and id_product=".$data['id'];
//var_dump($query);
          $r = $db->query($query);
          if($r->num_rows){
            $r = $r->fetch_array(MYSQLI_ASSOC);
            if($r['cost'] > 0){
              $data['cost'] = $r['cost'];
            }
            //if($r['tobuy']>0){
            //var_dump($r['tobuy']);
        	  $data['tobuy'] = $r['tobuy'];
            //}
          }

          //количество заказов на всех для совместных закупок
          $data['num_orders_sz']="0";
          $query = "select sum(priceorderdetail.num) as res from priceorderdetail, priceorder
               where priceorderdetail.order_id = priceorder.id
                and priceorderdetail.product_id=".$data['id'];
            //var_dump($query);
          $r = $db->query($query);
          if($r->num_rows){
            $r = $r->fetch_array(MYSQLI_ASSOC);
            if($r['res'] > 0){
              $data['num_orders_sz'] = $r['res'];
            }
          }

          //количество заказов на пользователя
          $data["num_orders"]="0";
          $query = "select sum(priceorderdetail.num) as res from priceorderdetail, priceorder
             where priceorderdetail.order_id = priceorder.id and priceorder.person_id=".$user_id."
              and priceorderdetail.product_id=".$data['id'];
//var_dump($query);
          $r = $db->query($query);
          if($r->num_rows){
            $r = $r->fetch_array(MYSQLI_ASSOC);
            if($r['res'] > 0){
              $data["num_orders"] = $r['res'];
            }
          }
         // $data[num_orders]=0;
          $data["product"] = $productM->get_product($data['id'], true);

          //свойства
          foreach($data["product"]['props'] as $prop){
      	     $allprops_ids[]=$prop['id']; //id родительской группы товара
      	  }

          //группы
          //$data['groups']=$group->get_groups_of_product($data['id']);
          if($data["product"]['groups'][0]['id']){
      	     $allgroups_ids[]=$data["product"]['groups'][0]['id']; //id родительской группы товара
      	  }

          $data["product"]["price"] = $data["cost"];
          $data["product"]["tobuy"] = $data["tobuy"];
          $products_instanse['data'][$key] = $data;
        }
//var_dump($allgroups_ids);
        $result['products'] = $products_instanse['data'];
        $result["groups"] = (count($allgroups_ids)>0 ? $group->get_tree_for_groups($shop_id, $allgroups_ids) : [] );
        $result["productproperies"] = (count($allprops_ids)>0 ?$property->get_properties_distinct($allprops_ids) : []);

	//if ($result['products']){
        $response_array['state'] = true;
        $response_array['message'] = " OK =>  ".__FUNCTION__." ";
        $response_array['prices'] = $result;
        //}  else{
	//    $for_developer['details'] = " query return nothing";
        //    $response_array['for_developer'] = $for_developer;
        //}
        return $response_array;
    }

    public function delete21($id){
    	global $db;
    	$id = $db->addslashes($id);
    	$res = $db->query("select id from price where id_shop=372");
        while($data = $res->fetch_array(MYSQLI_ASSOC)){
          $this->delete_by_price_id($data['id']);
    	  $res = $db->query("delete from price where id=$id");
        }
    }

    public function delete($id){
    	global $db;
    	$id = $db->addslashes($id);
    	$res = $db->query("delete from price where id=$id");
    	$this->delete_by_price_id($id);
    }

    //delect price details
    public function delete_by_price_id($id){
    	global $db;
    	$id = $db->addslashes($id);
    	$res = $db->query("delete from id_clients where id_price=$id");
    	$res = $db->query("delete from price_products where id_price=$id");
    //	$res = $db->query("delete from  where price_id=$id");
    //	$res = $db->query("delete from  where price_id=$id");
    }


    public function deleteold(){
    	global $db;

      $now = time() * 1000;
      $lastmonth = strtotime('last month')*1000;

      $query = "select id from ".$this->table." where (enddate <= $now and not (enddate is null or enddate='')) or ((enddate is null or enddate='') and date <= $lastmonth)";
#var_dump($query);
      $res = $db->query($query);
      while ($id = $db->fetch_array($res, MYSQLI_ASSOC)) {
          $id = $id["id"];
          echo "\n".$id;
          $this->delete_by_price_id($id);
          $res2 = $db->query("delete from price where id=$id");
      }
    }

    public function updatecost($price_id, $prices){
      global $db;
      $price_id = $db->addslashes($price_id);

      foreach ($prices as $product_id => $cost) {
        $product_id = $db->addslashes($product_id);
        $cost = $db->addslashes($cost);
        $query = "update price_products set cost=$cost where id_price=$price_id and id_product=$product_id";
        $db->query($query);
      }

    }


    public function updatetobuy($price_id, $tobuys){
      global $db;
      $price_id = $db->addslashes($price_id);

      foreach ($tobuys as $product_id => $tobuy) {
        $product_id = $db->addslashes($product_id);
        $tobuy = $db->addslashes($tobuy);
        $query = "update price_products set tobuy=$tobuy where id_price=$price_id and id_product=$product_id";
        $db->query($query);
      }

    }


    public function updatesaw($price_id, $person_id){
      global $db;
      $price_id = $db->addslashes($price_id);
      $person_id = $db->addslashes($person_id);

      $query = "update id_clients set saw=saw+1 where id_price=$price_id and id_person=$person_id";
      $db->query($query);

    }

    //подготовить продукт
    public function get($id){
      global $db;
      $res = $db->query("select * from price_products where id=$id");

      //$res = $db->query("select * from `product` where id=$id");
      if (! $db->num_rows($res)) {
        return null;
      }

      if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        //$data['name']=$data['name_en'];
        return $data;
      }
      return null;
    }

    //подготовить продукт
    public function get_product($product_id, $price_id){
      global $db;
      $res = $db->query("select * from price_products where id_product=$product_id and id_price=$price_id");

      //$res = $db->query("select * from `product` where id=$id");
      if (! $db->num_rows($res)) {
        return null;
      }

      if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        //$data['name']=$data['name_en'];
        return $data;
      }
      return null;
    }

    //минимальные данные прайса
    public function get_price($id) {
        global $db;

        $query = "select * from price where id=$id";
        $r = $db->query($query);
        if($r->num_rows){
          $r = $r->fetch_array(MYSQLI_ASSOC);
          return $r;
        }
        return null;
    }

    public function get_stat($id) {
        global $db;

        $query = "select * from id_clients where id_price=$id";
        $r = $db->query($query);
        if($r->num_rows){
          $stat = [];
          while($data = $r->fetch_array(MYSQLI_ASSOC)){
            $stat[]=$data;
          };
          return $stat;
        }
        return null;
    }

}
