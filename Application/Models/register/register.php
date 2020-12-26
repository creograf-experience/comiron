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

class registerModel extends Model {

  function register($params) {
    global $db;
    $email = $db->addslashes(trim($params['register_email']));
    $passwd = $db->addslashes(trim($params['register_password']));
    $first_name = $db->addslashes(ucwords(trim($params['register_first_name'])));
    $last_name = $db->addslashes(ucwords(trim($params['register_last_name'])));
    $date_of_birth = $db->addslashes($params['date_of_birth']);
    $gender = $db->addslashes($params['gender']);
    $country = $db->addslashes($params['country']);
    $clienttype_id = $params['clienttype_id'] ? $db->addslashes($params['clienttype_id']) : 'NULL';
    $lang = $db->addslashes($_SESSION['lang']);
    //$activation_code = $db->addslashes(uniqid('comiron').uniqid('', true));
    $activation_code = $db->addslashes(md5(uniqid(rand(),1)));
    
    
    // check to see if the email is already taken or not
    if ($db->num_rows($db->query("select id from persons where email = '$email'"))) {
      throw new Exception("email address is already in use");
    }
    
    //echo $activation_code;
    
    // ok email is free, create the persons record gender,date_of_birth, '$gender', '$date_of_birth',
    $res = $db->query("insert into persons (email, password, first_name, last_name,  
    		is_activated,activation_code, country_content_code2, lang, clienttype_id) values ('$email', PASSWORD('$passwd'), '$first_name', '$last_name', 0, '$activation_code', '$country', '$lang', {$clienttype_id})");
    $id = $db->insert_id($res);
    // and return the newly created persons record id
    //return $id;
    return [
      'activation_code' => $activation_code,
      'id' => $id
    ];
  }
}