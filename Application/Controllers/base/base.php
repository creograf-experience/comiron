<?php
use \Firebase\JWT\JWT;
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

class baseController extends Controller {

  public function __construct() {
    @session_start();
    // allow logins anywhere in the site
    if (! isset($_SESSION['id']) && ! empty($_POST['email']) && ! empty($_POST['password'])) {
      if ($this->authenticate($_POST['email'], $_POST['password'])) {
        // Redirect to self, but without post to prevent posting if the user refreshes the page
        // Login request to /openid/login page should not be redirected.
        if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/openid/login') {
          header("Location: {$_SERVER['REQUEST_URI']}");
          die();
        }
      }
    }
        
    //авторизация по токену
      $access_token = apache_request_headers()['access-token'];
      if(!$access_token) $access_token = apache_request_headers()['Access-token'];
      $refresh_token = apache_request_headers()['refresh-token'];
      if(!$refresh_token) $refresh_token = apache_request_headers()['Refresh-token'];
             
    if($access_token && $refresh_token){
        $update_tokens = $this->validate_tokens($access_token, $refresh_token);
    }
    else if (! isset($_SESSION['username']) && isset($_COOKIE['authenticated'])) {
      // user is not logged in yet, but we do have a authenticated cookie, see if it's valid
      // and if so setup the session
      $login = $this->model('login');
      if (($user = $login->get_authenticated($_COOKIE['authenticated'])) !== false) {
        $this->set_session($user);
      }
    }
  }

  public function authenticate($email, $password) {
    $login = $this->model('login');
    if (($user = $login->authenticate($email, $password)) !== false) {
      // setup the session
      $this->set_session($user);
      // and set a cookie and store the authenticated state in the authenticated table
      $hash = sha1($email . $password);
      $login->add_authenticated($user['id'], $hash);
      // remeber cookie for 30 days, after which we'd like the user to authenticate again

      setcookie("authenticated", $hash, $_SERVER['REQUEST_TIME'] + (30 * 24 * 60 * 60), "/", PartuzaConfig::get("cookie_domain"));

      //язык по-умолчанию
      $people = $this->model('people');
      $person=$people->get_person_info($user['id']);
      if(!isset($person['lang'])){
      	$person['lang']=PartuzaConfig::get('language');
      }
      if (in_array($person['lang'],PartuzaConfig::get('languages'))){
      	$_SESSION['lang']=$person['lang'];
      }else{
      	$_SESSION['lang']=PartuzaConfig::get('language');
      }

      //перенести корзину
      $cart = $this->model('cart');
      $cart->movemycart();

      return true;
    }
    return false;
  }

  public function get_uid(){
    if(isset($_SESSION['uid'])){
      return $_SESSION['uid'];
    }
    $_SESSION['uid'] = uniqid();
    return $_SESSION['uid'];
  }

  private function set_session($user) {
    $_SESSION['id'] = $user['id'];
    $_SESSION['username'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['lang'] = isset($user['lang']) ? $user['lang'] : PartuzaConfig::get('language');
    $_SESSION['country_content_code2'] = isset($user['country_content_code2']) ? $user['country_content_code2'] : "";
  }

  public function set_status_code($status,$code){
    $response_array['status'] = $status;
    $response_array['code'] = intval($code);
    return $response_array;
  }

  public function set_jwt_token($time_gap, $user_id){
    $key = "<>..index.php?db=gtoo&_SESSION=GTPress&lang=ru-utf-8";
    $jwt = '';
    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    $token = array(
      "iss" => "http://comiron.com",
      "aud" => "user",
      "sub" => "auth",
      "iat" => $timestamp,
      "exp" => $timestamp+$time_gap,
      "id" => $user_id
    );

    $jwt = JWT::encode($token, $key);

    $this->decode_jwt_token($jwt);

    return $jwt;
  }

  public function check_request_method($method){
    $status_code = $this->set_status_code("Method Not Allowed","405");
    $status_code['message'] = __FUNCTION__." return false... ";
    $status_code['state'] = false;

    if ($_SERVER['REQUEST_METHOD'] === $method){
      $status_code['message'] = "OK => ".__FUNCTION__." ";
      $status_code['state'] = true;
    } else{
      $status_code['message'] = "Wrong request method";
    }

    return $status_code;
  }

  public function decode_jwt_token($jwt){
    $key = "<>..index.php?db=gtoo&_SESSION=GTPress&lang=ru-utf-8";
    $response_array['state'] = false;
    $response_array['message'] = __FUNCTION__." return false... ";

    try{
      $decoded = JWT::decode($jwt, $key, array('HS256'));

      $response_array['decoded_jwt'] = $decoded;
      $response_array['state'] = true;
      $response_array['message'] = "OK => ".__FUNCTION__." ";

    } catch (Exception $ex) {
      $response_array['detail'] = " problem seems with decode";

    }
    return $response_array;
  }

  public function validate_tokens($access_token, $refresh_token) {
    // return refreshed both tokens or false
    // This pic explain how JWT with refresh works https://ibb.co/hZ7mhJ or dev_img/2018-06-29-11-51-04.jpg

    $message_OK = "OK => ".__FUNCTION__." ";
    $response_array['state'] = false;
    $response_array['message'] = __FUNCTION__." return false... ";

    $access_token_time_gap = 60*60;
    $refresh_token_time_gap = $access_token_time_gap*24*30;

    $decoded_access_token = $access_token ? $this->decode_jwt_token($access_token) : die(json_encode($response_array));
    $decoded_refresh_token = $refresh_token ? $this->decode_jwt_token($refresh_token) : die(json_encode($response_array));

//var_dump($decoded_access_token);
//var_dump($decoded_refresh_token);

    $user_id = $decoded_refresh_token['decoded_jwt']->id;

//var_dump($user_id);
    $jwt_model = $this->model('jwt');
    if($user_id){
/*    $check_refresh_jwt = $jwt_model->check_refresh_jwt(addslashes($refresh_token),$user_id,$refresh_token_time_gap);

var_dump($check_refresh_jwt);
    if($check_refresh_jwt['state']){
      $for_developer['log'] = $for_developer['log'].$check_refresh_jwt['message'];

      if($decoded_access_token['state'] and $decoded_refresh_token['state']) {
*/      
        $for_developer['log'] = $for_developer['log'].$decoded_access_token['message'];

        //$user_id = $decoded_access_token['decoded_jwt']->id;
        
        //set session
    //    var_dump($user_id);
        if($user_id){
          $login = $this->model('login');
          $user = $login->get_user($user_id);
          $this->set_session($user);
        }

        
        //$new_access_token = $this->set_jwt_token($access_token_time_gap, $user_id);

        $response_array['message'] = $message_OK;
        $response_array['state'] = true;
        $response_array['access_token'] = $access_token;
        $response_array['refresh_token'] = $refresh_token;

     /* } else{
        $for_developer['details'] = $decoded_access_token;

        if ($decoded_refresh_token['state']){
          $for_developer['log'] = $for_developer['log'].$decoded_refresh_token['message'];


            $new_access_token = $this->set_jwt_token($access_token_time_gap, $user_id);
            $new_refresh_token = $this->set_jwt_token($refresh_token_time_gap, $user_id);

            $updated_refresh = $jwt_model->update_refresh_jwt($new_refresh_token, $user_id, $refresh_token_time_gap);

            if($updated_refresh['state']){
              $for_developer['log'] = $for_developer['log'].$updated_refresh['message'];

              $response_array['state'] = true;
              $response_array['message'] = $message_OK;
              $response_array['access_token'] = $new_access_token;
              $response_array['refresh_token'] = $updated_refresh['refresh_token'];
            } else{
                $for_developer['details'] = $updated_refresh;
            }

        } else{
          $for_developer['details'] = $decoded_refresh_token;
        }*/
//      }
//    } else{
//      $for_developer['details'] = $check_refresh_jwt;
    }
    $response_array['for_developer'] = $for_developer;
    return $response_array;
  }


}
