<?php
{
# $login = "1c";
# $password = "letmego";
  $login = "nastya@creograf.ru";
  $password = "qweqwe123";

  #GET --------------------------

  #auth failed
  #echo var_dump(runREST("/product/?id=33", "GET" ));

  #товар
  #echo var_dump(runREST("/product/", "GET", array("id"=>2525, "login"=>$login, "password"=>$password) ));
  
  #список товаров
  #echo var_dump(runREST("/product/", "GET", array("list"=>1, "login"=>$login, "password"=>$password) ));

  #группа
  #echo var_dump(runREST("/group/", "GET", array("id"=>25, "login"=>$login, "password"=>$password) ));

  #список групп
  #echo var_dump(runREST("/group/", "GET", array("list"=>1, "login"=>$login, "password"=>$password) ));

  #список новых закзаов (статус заказа "новый")
  #echo var_dump(runREST("/order/", "GET", array("list"=>1, "login"=>$login, "password"=>$password) ));

  #данные заказа
  echo var_dump(runREST("/order/", "GET", array("id"=>143, "login"=>$login, "password"=>$password) ));
  #ошибка, заказ из чужого магазина
  #echo var_dump(runREST("/order/", "GET", array("id"=>144, "login"=>$login, "password"=>$password) ));

  #DELETE -----------------------
  #echo var_dump(runREST("/product/", "DELETE", array("id"=>"2560", "login"=>$login, "password"=>$password) ));
  #ошибка, товар из чужого магазина
  #echo var_dump(runREST("/product/", "DELETE", array("id"=>"2578", "login"=>$login, "password"=>$password) ));

  #POST -------------------------

  #обновить товар (добавить или изменить - POST)
  #+thumbnail - файл с фото
  /*
  echo var_dump(runREST("/product/", "POST", array(
    "id"=>"2556",
    "name"=>"Термос для продуктов 2 предмета 17х14 см / S9-2PCS/S21-2PCS /уп.48/",
    "price"=>11080,
    "discount"=>"10",
    "currency_id"=>"2",
    "ordr"=>null,
    "visible"=>"0",
    "isspecial"=>"0",
    "code"=>"577203",
    "package"=>"0",
    "box"=>"0",
    "edizm"=>"шт",
    "name_ru"=>"Термос для продуктов 2 предмета 17х14 см / S9-2PCS/S21-2PCS /уп.48/",
    "name_en"=>"Термос для продуктов 2 предмета 17х14 см / S9-2PCS/S21-2PCS /уп.48/",
    "name_ch"=>"",
    "name_it"=>"",
    "descr"=>"описание",
    "name_es"=>"",
    "isveryspecial"=>"0",
    "weight"=>"1",
    "volume"=>"2",
    "w"=>"5",
    "h"=>"5",
    "d"=>"5",
    "sklad"=>"2",

    #id группы магазина
    "group_id"=>834,

    #Категории Comiron.com
    "category_id[]"=>15,
    "category_id[]"=>14,
    "category_id[]"=>13,

    #характиристки
    "charname.1"=>"Термос 3л",
    "charprice.1"=>123,
    "charsklad.1"=>12,
    "charbarcode.1"=>123132,

    "charname.2"=>"Термос 5л",
    "charprice.2"=>125,
    "charsklad.2"=>12,
    "charbarcode.2"=>123132,

    "login"=>$login, "password"=>$password) ));
  */

  // добавить товар
  /*
  echo var_dump(runREST("/product/", "POST", array(
    "name"=>"Термос для продуктов 2 предмета 17х14 см / S9-2PCS/S21-2PCS /уп.48/",
    "price"=>11080,
    "discount"=>"10",
    "currency_id"=>"2",
    "ordr"=>null,
    "visible"=>"0",
    "isspecial"=>"0",
    "code"=>"577203",
    "package"=>"0",
    "box"=>"0",
    "edizm"=>"шт",
    "name_ru"=>"Термос для продуктов 2 предмета 17х14 см / S9-2PCS/S21-2PCS /уп.48/",
    "name_en"=>"Термос для продуктов 2 предмета 17х14 см / S9-2PCS/S21-2PCS /уп.48/",
    "name_ch"=>"",
    "name_it"=>"",
    "descr"=>"описание",
    "name_es"=>"",
    "isveryspecial"=>"0",
    "weight"=>"1",
    "volume"=>"2",
    "w"=>"5",
    "h"=>"5",
    "d"=>"5",
    "sklad"=>"2",

    #id группы магазина
    "group_id"=>834,

    #Категории Comiron.com
    "category_id[]"=>15,
    "category_id[]"=>14,
    "category_id[]"=>13,

    #характиристки
    "charname.1"=>"Термос 3л",
    "charprice.1"=>123,
    "charsklad.1"=>12,
    "charbarcode.1"=>123132,

    "charname.2"=>"Термос 5л",
    "charprice.2"=>125,
    "charsklad.2"=>12,
    "charbarcode.2"=>123132,

    "login"=>$login, "password"=>$password) ));
    */
  
  #редактировать группу магазина  
  #echo var_dump(runREST("/group/", "POST", array("id"=>836, 'name'=>"Группа", 'group_id'=>0, 'visible'=>5,'ordr'=>4, "login"=>$login, "password"=>$password) ));

  #добавить группу магазина  
  #echo var_dump(runREST("/group/", "POST", array('name'=>"Группа2", 'group_id'=>0, 'visible'=>5,'ordr'=>4, "login"=>$login, "password"=>$password) ));

  #редактировать группу пользователей 
  #echo var_dump(runREST("/usergroup/", "POST", array("id"=>7, 'name'=>"Физлица",  "login"=>$login, "password"=>$password) ));

  #добавить группу пользователей 
  #echo var_dump(runREST("/usergroup/", "POST", array('name'=>"Новая группа клиентов", "login"=>$login, "password"=>$password) ));


  #обновить заказ (создавать новые заказы по api нельзя)
  echo var_dump(runREST("/order/", "POST", array("id"=>1, "orderstatus_id"=>"2", ispayed=>"1", "login"=>$login, "password"=>$password) ));

}


function runREST($url, $method, $params = null){  
  $domain = "http://127.0.0.1:1131/api/rest";
  $c = curl_init();
  curl_setopt($c,CURLOPT_CONNECTTIMEOUT,20);
    #   curl_setopt($c,CURLOPT_HEADER,true);
    #    curl_setopt($c,CURLOPT_NOBODY,true);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
  switch( $method ){
    case 'GET': {
      curl_setopt($c, CURLOPT_HTTPGET, true); 
      if (!is_null($params)) {
        $query_string = "?" . http_build_query($params,'','&');
      }
      curl_setopt($c,CURLOPT_URL,  $domain . $url . $query_string);
      break;
    }
    case 'POST': {
      curl_setopt($c, CURLOPT_POST, true);
      curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($c,CURLOPT_URL, $domain . $url);  
      break;
    }
    case 'PUT': {
      curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
#     curl_setopt($ch, CURLOPT_PUT, true);
      curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($c, CURLOPT_URL, $domain . $url); 
      break;
    }
    case 'DELETE': {
      curl_setopt($c, CURLOPT_CUSTOMREQUEST, "DELETE");
#     curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
#     curl_setopt($c,CURLOPT_URL, $domain . $url);  
      if (!is_null($params)) {
        $query_string = "?" . http_build_query($params,'','&');
      }
      curl_setopt($c,CURLOPT_URL,  $domain . $url . $query_string);

      break;
    }
  }

  $response = curl_exec($c);
  curl_close($c);
  return $response;
}
    
?>