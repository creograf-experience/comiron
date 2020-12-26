<?php

class priceController extends baseController {


    private function check_required_keys($_REQUIRED_KEYS, $_SUPPORTED_TYPES, $data){
        // check json request has all required keys and values contain certain type

        foreach ($data as $key => $value) {
            if (array_search($key, $_REQUIRED_KEYS)) {
                unset($_REQUIRED_KEYS[$key]);
                if(!in_array(gettype($value), $_SUPPORTED_TYPES)){
                    $invalid_type = "the value $value has unsupported type" ;
                }
            } else{
                $invalid_key = $invalid_key . "Invalid key '$key', ";
            }
        }
        $required_keys_as_str = implode("', '",array_keys($_REQUIRED_KEYS));
        $message_missing_keys = " missing '$required_keys_as_str' field(s)";
        $result = $_REQUIRED_KEYS ? $message_missing_keys : "";

        $response_array['invalid_key'] = $invalid_key;
        $response_array['invalid_type'] = $invalid_type;
        $response_array['result'] = $result;

        return $response_array;
    }


    private  function validate_create_json($data){
        /// validation for all fields. All the fields must match in REQUIRED_KEYS and have a supported type

        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";

        $_REQUIRED_KEYS = ['name' => 'name', 'id_shop' => 'id_shop', 'id_products' => 'id_products', 'id_clients' => 'id_clients', 'date'=> 'date'];
        $_SUPPORTED_TYPES = ['array', 'integer', 'string'];

        $check_required_keys = $this->check_required_keys($_REQUIRED_KEYS, $_SUPPORTED_TYPES, $data);

        $invalid_key = $check_required_keys['invalid_key'];
        $invalid_type = $check_required_keys['invalid_type'];
        $result = $check_required_keys['result'];

        if($invalid_key or $invalid_type or $result){
            $response_array['message'] = $response_array['message'] . $invalid_key . $invalid_type . $result;
        } else{
            $response_array['state'] = true;
            $response_array['message'] = "OK => ".__FUNCTION__." ";
        }

        return $response_array;
    }


    private function validate_update_json($data){
        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";

        $_REQUIRED_KEYS = ['id'=>'id','shop_id' => 'shop_id', 'date' => 'date', 'name' => 'name', 'id_products' => 'id_products', 'id_clients' => 'id_clients'];
        $_SUPPORTED_TYPES = ['array', 'integer', 'string'];

        $check_required_keys = $this->check_required_keys($_REQUIRED_KEYS, $_SUPPORTED_TYPES, $data);


        $invalid_key = $check_required_keys['invalid_key'];
        $invalid_type = $check_required_keys['invalid_type'];

        if($invalid_key or $invalid_type){
            $response_array['message'] = $response_array['message'] . $invalid_key . $invalid_type;
        } else{
            $response_array['state'] = true;
            $response_array['message'] = "OK => ".__FUNCTION__." ";
        }

        return $response_array;


    }

    public function create($params){
        //  Creating a price
        $status_code = $this->set_status_code("Internal Server Error","500");
        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $method_POST = $this->check_request_method("POST");

	      $price_id = "";
        if($method_POST['state']){
            $for_developer['log'] = $method_POST['message'];
            // $update_tokens = $this->validate_tokens($access_token, $refresh_token);
            // $for_developer['log'] = $for_developer['log'] . $update_tokens['message'];

                $data = json_decode(file_get_contents('php://input'), true);

                //$valid_request_json = $this->validate_create_json($data);
                //$vaildate_message = $valid_request_json['message'];

                //if($valid_request_json['state']){
                //    $for_developer['log'] = $for_developer['log'] . $vaildate_message;

                    $price_model = $this->model('price');
                    $tag_model = $this->model('tag');

                    //добавить id_clients по тегам
                    if(count($data['tags_id'])){
                      $person_id = $tag_model->get_users_by_tags($data['id_shop'], $data['tags_id']);
                      $data['id_clients'] = array_unique(array_merge($person_id, $data['id_clients']));
                    }

                    $result = $price_model->create_price($data);

                    $price_id = $result['price_id'];

                    $ok_status = $this->set_status_code("OK","200");
                    $result['state'] ? $status_code = $ok_status : $for_developer['details'] = $result;
                    $for_developer['log'] = $for_developer['log'] . $result['message'];

                    //send push to all users in price
                    if($price_id and ($data['id_clients'] or $data['send2all'])){
                      $shop_model = $this->model('shop');
                      $people = $this->model('people');

                      $shop = $shop_model->get_shop_info($data['id_shop']);

                      $msg = ['price_id'=>$price_id,
                       'name'=>$data['name'],
                       'shop_id'=>$data['id_shop'],
                       'shop_name'=>$shop['name'],
                       'type'=>'price'];
                      $title = "Новый прайс ".$data['name']." от ".$shop['name'];
                      $notification = ['title' => $title,'body' => $title, 'data'=> $msg];
//                      require_once '../vendor/autoload.php';
//                      require_once PartuzaConfig::get('library_root') . "Expo/Expo.php";
                      //$expo = \ExponentPhpSDK\Expo::normalSetup();
                      require_once PartuzaConfig::get('library_root').'/REST.php';

                      $notclients = [];
                      if($data['send2all']){
                        $clients = $this->get_clients($id);
                        $data['id_clients'] = array_keys($clients);
                      }
                      foreach($data['id_clients'] as $person_id){
                        // не подписан
                        if(!in_array($person_id, $result['clients'])){
                          $notclients[] = $person_id;
                          continue;
                        }

                        $userId = $person_id;
                        $person = $people->get_person_info($userId);
                        $key = $person['pushtoken'];

                        if(!$key) continue;

                        $notification["to"]=$key; //json_encode($to);
			//var_dump($notification);
                        $status = runREST("https://exp.host/--/api/v2/push/send", "POST_JSON", $notification);
			//echo $status;

                    /*    try{
                        https://exp.host/--/api/v2/push/send
                              $expo->notify($userId,$notification);
                              $status = 'success';
                        }catch(Exception $e){
                                //if there is an exception Most probably cause the userid is unsubscribed
                                $expo->subscribe($userId, $key); //$userId from database
                                $expo->notify($userId,$notification);
                                $status = 'new subscription';
                        }*/
                        //echo $status;
                      }

                    }

                //} else{
                //    $for_developer['details'] = $vaildate_message;
                //    $status_code = $this->set_status_code("Validation return false","409");
                //}


        } else{
            $for_developer['details'] = $method_POST;
            $status_code = $method_POST;
        }

	      $json_response['price_id'] = $price_id;
        $json_response['notclients'] = $notclients;
        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }


    public function price($params){

        $status_code = $this->set_status_code("Internal Server Error","500");

        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $method_GET = $this->check_request_method("GET");

        if($method_GET['state']){
            $for_developer['log'] = $method_GET['message'];

            $update_tokens = $this->validate_tokens($access_token, $refresh_token);
            $for_developer['log'] = $for_developer['log'] . $update_tokens['message'];


            if ($update_tokens['state']){
                $price_model = $this->model('price');
                $data = $price_model->get_price_detail($params[3]);
                $for_developer['log'] = $for_developer['log'] . $data['message'];
                if ($data['state']){
                //var_dump($data);
                    $json_response['data'] = $data['price'];

                    $json_response['access_token'] = $update_tokens['access_token'];
                    $json_response['refresh_token'] = $update_tokens['refresh_token'];

                    $status_code = $this->set_status_code("OK","200");
                } else{
                    $status_code = $this->set_status_code("Can't find","400");
                    $for_developer['details'] = $update_tokens;
                }
            }else{
                $for_developer['details'] = $update_tokens;
                $status_code = $this->set_status_code("Expired tokens","401");
            }

        } else{
            $for_developer['details'] = $method_GET;
            $status_code = $method_GET;
        }

        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);

    }

    public function update($params){
        $status_code = $this->set_status_code("Internal Server Error","500");
        $method_POST = $this->check_request_method("POST");

        if($method_POST['state']){
            $for_developer['log'] = $for_developer['log'].$method_POST['message'];

            $data = json_decode(file_get_contents('php://input'), true);

//            $validate_update_json = $this->validate_update_json($data);
//            $for_developer['log'] = $for_developer['log'].$validate_update_json['message'];

//            if($validate_update_json['state']){
                $price_model = $this->model('price');
                $tag_model = $this->model('tag');

                //добавить id_clients по тегам
                if(count($data['tags_id'])){
                  $person_id = $tag_model->get_users_by_tags($data['shop_id'], $data['tags_id']);
                  $data['id_clients'] = array_unique(array_merge($person_id, $data['id_clients']));
                }

//var_dump($data);
                $update_price = $price_model->update_price($data);
		            $status_code = $this->set_status_code("OK","200");
//            } else{
//                $for_developer['details'] = $validate_update_json;
//                $status_code = $this->set_status_code("Validation return false","409");
//            }

        } else{
            $status_code = $method_POST;
        }

        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }

    //prices from shop
    public function prices($params){
        $status_code = $this->set_status_code("Internal Server Error","500");

        $method_GET = $this->check_request_method("GET");

        if($method_GET['state']){
            $for_developer['log'] = $method_GET['message'];
            $price_model = $this->model('price');

            $page = $_REQUEST['page'];
            $shop_id = intval($_REQUEST['shop']) or die(json_encode("can't intval shop"));
            $page = intval($page) ? $page : die(json_encode("page not int"));

            $prices = $price_model->get_prices($shop_id, $page);

            $for_developer['log'] = $for_developer['log'].$prices['message'];

            $total_pages_and_count = $price_model->get_total_page_num($shop_id, 20);

            if($prices['state']){
                $json_response['pages'] = $total_pages_and_count['pages'];
                $json_response['count_prices'] = $total_pages_and_count['count_prices'];
                $json_response['prices'] = $prices['data'];
                $status_code = $this->set_status_code("OK", "200");
            }else{
                $for_developer['details'] = $prices;
                $status_code = $this->set_status_code("Prices for this shop not found", "404");
            }

        } else{
            $status_code = $method_GET;
        }

        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }

    //prices for user
    public function userprices($params){
        $status_code = $this->set_status_code("Internal Server Error","500");

        $method_GET = $this->check_request_method("GET");

        if($method_GET['state']){
            $for_developer['log'] = $method_GET['message'];
            $price_model = $this->model('price');

            $page = $_REQUEST['page'];
            $user_id = intval($_REQUEST['user_id']) or die(json_encode("can't intval user_id"));
            $shop_id = $_REQUEST['shop_id'];
            $page = intval($page) ? $page : die(json_encode("page not int"));

            $is_sz = $_REQUEST['is_sz'];
            $is_sz = intval($is_sz) ? $is_sz : 0;

            $prices = $price_model->get_userprices(["user_id"=>$user_id,
                                                    "shop_id"=>$shop_id,
                                                    "page"=>$page,
                                                  "is_sz" => $is_sz]);

            $for_developer['log'] = $for_developer['log'].$prices['message'];

        //    $total_pages_and_count ;

            if($prices['state']){
                $json_response['pages'] = $prices['pages'];
                $json_response['count_prices'] = $prices['count_prices'];
                $json_response['prices'] = $prices['data'];
                $status_code = $this->set_status_code("OK", "200");
            }else{
                $for_developer['details'] = $prices;
                $status_code = $this->set_status_code("Prices for this user not found", "404");
            }

        } else{
            $status_code = $method_GET;
        }

        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }


    public function pricedetail($params){
        $status_code = $this->set_status_code("Internal Server Error","500");

        // $access_token = apache_request_headers()['access_token'];
        // $refresh_token = apache_request_headers()['refresh_token'];

        $method_GET = $this->check_request_method("GET");

        if($method_GET['state']){
            $for_developer['log'] = $method_GET['message'];

            // $validate_tokens = $this->validate_tokens($access_token, $refresh_token);
            // $for_developer['log'] = $for_developer['log'] . $update_tokens['message'];


            // if ($validate_tokens['state']){
                $price_model = $this->model('price');

                $shop_id = $_REQUEST['shop'];
                $price_id = $_REQUEST['price'];
                $user_id = $_REQUEST['user_id'];
                $group_id = $_REQUEST['group_id'];
                $property = $_REQUEST['property'];
                $data = $price_model->get_price_detail($shop_id, $price_id,$user_id,$group_id,$property);
                $for_developer['log'] = $for_developer['log'] . $data['message'];

                if ($data['state']){
                    $json_response['data'] = $data['prices'];
                    $status_code = $this->set_status_code("OK","200");
                } else{
                    $status_code = $this->set_status_code("Can't find","404");
                    $for_developer['details'] = $data;
                }
            // }else{
            //     $for_developer['details'] = $validate_tokens;
            //     $status_code = $this->set_status_code("Expired tokens","401");
            // }
        }else{
            $status_code = $method_GET;
        }
        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }

    public function delete($params){
        $price_model = $this->model('price');
        $id = $params[3];

        $data = $price_model->delete($id);

        $status_code = $this->set_status_code("OK","200");
        $json_response['data']="";
        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        echo json_encode($json_response);
    }

    // person_id
    // shop_id
    // price_id
    // products = [id, num]
    // sum
    public function send_order($params){
      $status_code = $this->set_status_code("Internal Server Error","500");
      $access_token = apache_request_headers()['access_token'];
      $refresh_token = apache_request_headers()['refresh_token'];

      $method_POST = $this->check_request_method("POST");
      $order_id = null;

      if($method_POST['state']){
          $for_developer['log'] = $method_POST['message'];
          // $update_tokens = $this->validate_tokens($access_token, $refresh_token);
          // $for_developer['log'] = $for_developer['log'] . $update_tokens['message'];
              $data = json_decode(file_get_contents('php://input'), true);

//var_dump($data);

	      if($data["person_id"]){
              //$valid_request_json = $this->validate_create_json($data);
              //$vaildate_message = $valid_request_json['message'];

              //if($valid_request_json['state']){
                  $for_developer['log'] = $for_developer['log'] . $vaildate_message;

                  $price = $this->model('price');
                  $people = $this->model('people');
                  $shops = $this->model('shop');
                  $priceorder = $this->model('orderprice');

                  $sum = $data['sum'];

                  //$cart = $data['products'];
                  $shop_id = $data['shop_id'];
                  $price_id = $data['price_id'];

                  $shop=$shops->get_shop($shop_id);

                  $cart = $this->get_cartorder($data['products'], $price_id);

                  $person_id = $data['person_id'];
                  $person = $people->get_person_info($person_id);

                  $order_id=$priceorder->add($shop_id, array(
                            "person_id"=>$person_id,
                            "price_id"=>$price_id,
                            "ispayed"=>0,
                            "is_sz"=>$data['is_sz'],
                            "num"=>$num,
                            "sum"=>$sum,
                            "currency_id"=>(isset($small_cart[0]['currency_id'])?$small_cart[0]['currency_id']:0),
                            "orderstatus_id"=>1,
                            "dataorder"=>$_SERVER['REQUEST_TIME'],
                            //"delivery"=>$_REQUEST['delivery'],
                            //"address"=>(isset($delivery_address['addrstring'])?$delivery_address['addrstring']:""),
                            //"postalcode"=>(isset($delivery_address['postalcode'])?$delivery_address['postalcode']:0),
                            //"city"=>(isset($delivery_address['city'])?$delivery_address['city']:""),
                            "phone"=>$person['phone'],
                            //"currency_id"=>.. TODO: пересчитывать сумму в одну валюту
                            //"deliverycost"=>$_REQUEST['deliverycost'],
                            "numpack"=>1,
                            //"weight"=>$_REQUEST["weight"],
                            //"volume"=>$_REQUEST["volume"],
                            //"category"=>$category,
                            //"rupost_pdf"=>$link,
                            //"dpdcityid"=>$_REQUEST["cityid"],
                            //"deliverytype"=>$_REQUEST["dpddeliverytype"],
                            //"hermes_id"=>$hermes_id,
                            "contactname"=>$person["first_name"]." ".$person["last_name"],
                          ), $cart['cart']);


                  //заказ добавлен
                  if($order_id){

                    $status_code = $this->set_status_code("OK","200");
                    $for_developer['log'] = $for_developer['log'] . $result['message'];

                    $res = $priceorder->getXML($order_id);
                    $path = PartuzaConfig::get('site_root')."/priceorders/".$order_id.".xml";
                    $file = file_put_contents($path, $res);

                    //отправить на почту
                    //создать файл excel
                    require_once PartuzaConfig::get('library_root').'/PHPExcel.php';
                    require_once PartuzaConfig::get('library_root').'/PHPExcel/Writer/Excel5.php';

                    $xls = new PHPExcel();
                    $xls->setActiveSheetIndex(0);
                    $sheet = $xls->getActiveSheet();

                    //Для всех ячеек выравнивание текста по центру
                    $xls->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    //Авторазмер ячеек
                    for($col = 'A'; $col !== 'H'; $col++)
                      $sheet->getColumnDimension($col)->setAutoSize(true);


                    $sheet->setCellValueByColumnAndRow( 0, 1, "ID заказа");
                    $sheet->setCellValueByColumnAndRow( 1, 1, $order_id);

                    $sheet->setCellValueByColumnAndRow( 0, 2, "ID магазина");
                    $sheet->setCellValueByColumnAndRow( 1, 2, $shop_id);

                    $sheet->setCellValueByColumnAndRow( 0, 3, "ID покупателя");
                    $sheet->setCellValueByColumnAndRow( 1, 3, $person_id);

                    $sheet->setCellValueByColumnAndRow( 0, 4, "Сумма итого");
                    $sheet->setCellValueByColumnAndRow( 1, 4, $sum);

                    $sheet->getStyleByColumnAndRow(0,5)->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow( 0, 5, "Стоимость доставки");
                    $sheet->getStyleByColumnAndRow(1,5)->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow( 1, 5, "0");

                    $sheet->getStyleByColumnAndRow(0,6)->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow( 0, 6, "Сумма за товар");
                    $sheet->getStyleByColumnAndRow(1,6)->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow( 1, 6, $sum);

                    $sheet->setCellValueByColumnAndRow( 0, 7, "Доставка");
                    $sheet->setCellValueByColumnAndRow( 1, 7, "");

                    $sheet->setCellValueByColumnAndRow( 0, 8, "Телефон");
                    $sheet->setCellValueByColumnAndRow( 1, 8, $person['phone']);

                    $sheet->getStyleByColumnAndRow(0,9)->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow( 0, 9, "Email");
                    $sheet->getStyleByColumnAndRow(1,9)->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow( 1, 9, $person['email']);

                    $sheet->getStyleByColumnAndRow(0,10)->getFont()->setBold(true)->setItalic(true);
                    $sheet->setCellValueByColumnAndRow( 0, 10, "ФИО клиента");
                    $sheet->getStyleByColumnAndRow(1,10)->getFont()->setBold(true)->setItalic(true);
                    $sheet->setCellValueByColumnAndRow( 1, 10, $person["first_name"]." ".$person["last_name"]);

                    $sheet->getStyleByColumnAndRow(0,11)->getFont()->setBold(true)->setItalic(true);
                    $sheet->setCellValueByColumnAndRow( 0, 11, "Адрес доставки");
                    $sheet->getStyleByColumnAndRow(1,11)->getFont()->setBold(true)->setItalic(true);
                    $sheet->setCellValueByColumnAndRow( 1, 11, "");

                    $sheet->setCellValueByColumnAndRow( 0, 12, "ID товара");
                    $sheet->getStyleByColumnAndRow(1,12)->getFont()->setBold(true)->setItalic(true);
                    $sheet->setCellValueByColumnAndRow( 1, 12, "ID товара из 1С");
                    $sheet->setCellValueByColumnAndRow( 2, 12, "Код товара");
                    $sheet->setCellValueByColumnAndRow( 3, 12, "Количество");
                    $sheet->setCellValueByColumnAndRow( 4, 12, "Цена");
                    $sheet->setCellValueByColumnAndRow( 5, 12, "Сумма");
                    $sheet->setCellValueByColumnAndRow( 6, 12, "Наименование");

                    //Заполняем товары
                    $string = 13;
                    $startRowProducts = 12;
                    foreach ($cart['cart'] as $key => $product) {
                      $sheet->setCellValueByColumnAndRow( 0, $string, $product['product']['id']);
                      $sheet->setCellValueByColumnAndRow( 1, $string, $product['product']['primarykey']);
                      $sheet->setCellValueByColumnAndRow( 2, $string, $product['product']['code']);
                      $sheet->setCellValueByColumnAndRow( 3, $string, $product['num']);
                      $sheet->setCellValueByColumnAndRow( 4, $string, $product['price']." ".$product['currency']['code']);
                      $sheet->setCellValueByColumnAndRow( 5, $string, $product['sum']." ".$product['currency']['code']);
                      $sheet->setCellValueByColumnAndRow( 6, $string, $product['product']['name']." ".$product['product']['charname']);
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
                    $sheet->getStyle("C".$startRowProducts.":G".$string)->applyFromArray($borderStyle);

                /*        $sheet->getStyleByColumnAndRow($i - 2, $j)->getAlignment()->
                        setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
                    $objWriter = new PHPExcel_Writer_Excel5($xls);
                    $file2 = PartuzaConfig::get('site_root').'/priceorders/'.$order_id.".xls";
                    $objWriter->save($file2);

                    //send mail
                    $message=$this->get_template("/shop/mail/neworderprice.php",
                        array("cart"=>$cart,
                          "order_id"=>$order_id,
                          "person_id"=>$person_id,
                          "person"=>$people->get_person_info($person_id),
                          "shop"=>$shop,
                          "small_cart"=>$small_cart,
                          "delivery"=>"",
                          "phone"=>$person['phone']
                            ));
                    global $mail;
                    $mail->send_mail(array(
                        "from"=>PartuzaConfig::get('mail_from'),
                        "to"=>$shop['order_email'],
                        "title"=>"New Price Order",
                        "body"=>$message,
                        "filepath"=>$file2,
                        "filename"=>$order_id.".xls",
                        "filepath2"=>$path,
                        "filename2"=>$order_id.".xml",
                        ));

                    // заказ Антону
                    $mail->send_mail(array(
                        "from"=>PartuzaConfig::get('mail_from'),
                        "to"=>PartuzaConfig::get('mail_anton'),
                        "title"=>"New Price Order",
                        "body"=>$message,
                        "filepath"=>$file2,
                        "filename"=>$order_id.".xls",
                        "filepath2"=>$path,
                        "filename2"=>$order_id.".xml",
                        ));

                    //var_dump($path);
                    $priceorder->save($order_id, ["status"=>1]);
                  }

              } else{
                    $for_developer['details'] = $vaildate_message;
                  $status_code = $this->set_status_code("Validation return false","409");
              }


      } else{
          $for_developer['details'] = $method_POST;
          $status_code = $method_POST;
      }

      $json_response['data']['order_id'] = $order_id;

      $json_response['status'] = $status_code['status'];
      $json_response['code'] = $status_code['code'];

      $json_response['for_developer'] = $for_developer;

      echo json_encode($json_response);

    }


    private function get_cartorder($products,$price_id){
      global $db;
      $num=0;
      $category = 0;
      $products_id = array();
      $nums = array();

      foreach  ($products as $p) {
         $products_id[] = $p['id'];
         $nums[$p['id']] = $p['num'];
         $num++;
      }

      if(count($products_id)==0){
        return null;
      }

      $sql = "select * from product where id in (".implode(', ',$products_id).")";
      $res = $db->query($sql);
      if (! $db->num_rows($res)) {
        return null;
      }
      $cart=array();
      $product=$this->model("product");
      $price=$this->model("price");
      $currency=$this->model("currency");
      $action=$this->model("action");

      $w = 0; $h = 0; $d = 0; $volume = 0; $weight = 0;
      while($data = $res->fetch_array(MYSQLI_ASSOC)) {

      /*if($data['action_id']){
        $product=$action->get_action($data['action_id']);
        if($product['product_id']==$data['product_id']){
          $data['product']=$product;
        }
      }
      if(!isset($data['product'])){
      */
        $pricedata = $price->get_product($data['id'], $price_id);
        $data['product_id']=$data['id'];
        $data['num'] = $nums[$data['id']]; // количество
        $data['sum']=$pricedata['cost']*$data['num'];

        $data['priceitem_id']=$pricedata['id'];
        $data['price_id']=$price_id;
        $data['shop_id']=$pricedata['id_shop'];
        $data['price'] = $pricedata['cost'];

        $data['product']=$product->get_product($data['id'], true);
        //}
        $data['product']['name'].=" ".$data['charname'];
        $data['currency']=$currency->get_currency($data['currency_id']);
        $data['product_name']=$data['product']['name'];
        $data['photo_url']=$data['product']['photo_url'];

        $w += $data['product']['w'] * $data['product']['num'];
        $h += $data['product']['h'] * $data['product']['num'];
        $d += $data['product']['d'] * $data['product']['num'];
        if(isset($data['product']['volume'])){
          $volume += $data['product']['volume'] * $data['product']['num'];
        }else if(isset($data['product']['w']) && isset($data['product']['h']) && isset($data['product']['d'])){
          $volume += $data['product']['w'] * $data['product']['h'] * $data['product']['d']  * $data['product']['num'];
        }
        $weight += isset($data['product']['weight']) ? $data['product']['weight'] * $data['product']['num']:0;
        $cart[]=$data;
      }

      return array(
          'cart'=>$cart,
          'w' => $w,
          'h' => $h,
          'd' => $d,
          'volume' => $volume,
          'weight' => $weight,
        );
    }

    //orders from shop
    public function orders($params){
      $shop_id=$params[3];

      //$shops = $this->model('shop');
      //$shop = $shops->get_shop($shop_id, true);
      //$people = $this->model('people');
      //$person = $people->get_person($_SESSION['id']);

      $order = $this->model('orderprice');

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

      //xml-файлы с заказом
      for($i=0; $i<count($orders); $i++){
        $orders[$i]['xml'] = "https://comiron.com/priceorders/".$orders[$i][id].".xml";
      }

      $pages=$order->get_order_pages($filter);

      echo json_encode( array(
          //'orderstatuses' => $order->get_statuses(),
          'searchorder'=>$_REQUEST,
          'orders'=>$orders,
          'nextpage'=>$pages['nextpage'],
          'totalpages'=>$pages['totalpages']));
    }

    public function order_save($id) {
      $id = $id[3];

//      $data = file_get_contents('php://input');
//var_dump($data);
      $data = json_decode(file_get_contents('php://input'), true);
//var_dump($data);
      $ispayed = isset($data['ispayed']) ? $data['ispayed'] : 0;
      $price_id = isset($data['price_id']) ? $data['price_id'] : 0;
      $orderstatus_id = isset($data['orderstatus_id']) ? $data['orderstatus_id'] : 0;
      $comment_shop = isset($data['comment_shop']) ? trim(strip_tags($data['comment_shop'])) : '';
      //$comment_person = isset($_POST['comment_person']) ? trim(strip_tags($_POST['comment_person'])) : '';

      $data['ispayed'] = $ispayed;
      $data['orderstatus_id'] = $orderstatus_id;
      $data['comment_shop'] = $comment_shop;

      $date_pickup= isset($data['date_pickup']) ? trim(strip_tags($data['date_pickup'])) : '';
      preg_match("/(\d+)\.(\d+)\.(\d+)/", $date_pickup, $res);
      if(isset($res[1]) and isset($res[2]) and isset($res[3])){
        $data['date_pickup']=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
      }

      $order = $this->model('orderprice');

      //id=$params[3]
      if(isset($id) and is_numeric($id)){
        //$created = $_SERVER['REQUEST_TIME'];
        $order->save($id, $data);
        if($data['products']){
          $cart = $this->get_cartorder($data['products'], $price_id);
          //var_dump($cart["cart"]);
          $order->updateproducts($id, $cart["cart"]);
        }

        echo '{"status":"OK"}';
        return;
      }
      echo '{"status":"fail"}';
    }


    public function updatecost($params){
        //  Creating a price
        $status_code = $this->set_status_code("Internal Server Error","500");
        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $method_POST = $this->check_request_method("POST");
        $price_id = $params[3];

        if($method_POST['state']){
                $data = json_decode(file_get_contents('php://input'), true);

                $price_model = $this->model('price');
                $result = $price_model->updatecost($price_id, $data['prices']);

                echo '{"status":"OK"}';
                return;
        }
        echo '{"status":"fail"}';
    }

    public function updatetobuy($params){
        //  Creating a price
        $status_code = $this->set_status_code("Internal Server Error","500");
        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $method_POST = $this->check_request_method("POST");
        $price_id = $params[3];

        if($method_POST['state']){
                $data = json_decode(file_get_contents('php://input'), true);

                $price_model = $this->model('price');
                $result = $price_model->updatetobuy($price_id, $data['tobuy']);

                echo '{"status":"OK"}';
                return;
        }
        echo '{"status":"fail"}';
    }

    public function sz_generate_xls($params){
      $status_code = $this->set_status_code("OK","200"); // $this->set_status_code("Internal Server Error","500");

      $order_id = null;
      $price = $this->model('price');
      $people = $this->model('people');
      $shops = $this->model('shop');
      $priceorder = $this->model('orderprice');

      $price_ids = $price->get_opensz();

      foreach($price_ids as $price_id){
        $pricedata = $price->get_price($price_id);
        $shop = $shops->get_shop_info($pricedata["id_shop"]);

        $sumdetails = $priceorder->get_sumdetailsforprice($price_id);
        $orders = $priceorder->get_orders(["curpage"=>-1, "price_id"=>$price_id]);
        $file = $this->save_order_xls_sz($price_id, $sumdetails, $orders);

        //send mail
        $message=$this->get_template("/shop/mail/neworderpricesz.php",
            array(
              "shop"=>$shop,
                ));
        global $mail;
        $mail->send_mail(array(
            "from"=>PartuzaConfig::get('mail_from'),
            "to"=>$shop['order_email'],
            "title"=>"New Price SZ Order",
            "body"=>$message,
            "filepath"=>$file,
            "filename"=>$price_id.".xls",
            ));

        //заказ Антону
        $mail->send_mail(array(
            "from"=>PartuzaConfig::get('mail_from'),
            "to"=>PartuzaConfig::get('mail_anton'),
            "title"=>"New Price SZ Order",
            "body"=>$message,
            "filepath"=>$file,
            "filename"=>$price_id.".xls",
            ));

        //var_dump($path);

        //закрыть закупку
        $price->update_price(["id"=>$price_id, "shop_id"=>$pricedata["id_shop"], "status"=>"1"]);
      }




              //} else{
              //      $for_developer['details'] = $vaildate_message;
            //      $status_code = $this->set_status_code("Validation return false","409");
             // }


      //$json_response['data']['order_id'] = $order_id;

      $json_response['status'] = $status_code['status'];
      $json_response['code'] = $status_code['code'];

      $json_response['for_developer'] = $for_developer;

      echo json_encode($json_response);

    }

    private function save_order_xls_sz($price_id, $sumdetails, $orders){
            //создать файл excel
            require_once PartuzaConfig::get('library_root').'/PHPExcel.php';
            require_once PartuzaConfig::get('library_root').'/PHPExcel/Writer/Excel5.php';

            $xls = new PHPExcel();

            //данные о закупке
            $price = $this->model('price');
            $pricedata = $price->get_price($price_id);
            $pricedata['enddate']=round($pricedata['enddate']/1000);
            $pricedata['enddatetext'] = date("d.m.Y",$pricedata['enddate']);

            //общий заказ для поставщика
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();

            //Для всех ячеек выравнивание текста по центру
            $xls->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //Авторазмер ячеек
            for($col = 'A'; $col !== 'H'; $col++)
              $sheet->getColumnDimension($col)->setAutoSize(true);


            $sheet->setCellValueByColumnAndRow( 0, 1, "ID прайса");
            $sheet->setCellValueByColumnAndRow( 1, 1, $price_id);

            $sheet->setCellValueByColumnAndRow( 0, 1, "Название закупки");
            $sheet->setCellValueByColumnAndRow( 1, 1, $pricedata['name']);

            $sheet->setCellValueByColumnAndRow( 0, 2, "ID магазина");
            $sheet->setCellValueByColumnAndRow( 1, 2, $pricedata['id_shop']);

            $sheet->setCellValueByColumnAndRow( 0, 3, "Дата закрытия");
            $sheet->setCellValueByColumnAndRow( 1, 3, $pricedata['enddatetext']);

            $sheet->setCellValueByColumnAndRow( 0, 5, "ID товара price");
            $sheet->getStyleByColumnAndRow(1,12)->getFont()->setBold(true)->setItalic(true);
            $sheet->setCellValueByColumnAndRow( 1, 5, "ID товара из 1С");
            $sheet->setCellValueByColumnAndRow( 2, 5, "Код товара");
            $sheet->setCellValueByColumnAndRow( 3, 5, "Количество");
            $sheet->setCellValueByColumnAndRow( 3, 5, "Надо было выкупить");
            $sheet->setCellValueByColumnAndRow( 4, 5, "Цена");
            $sheet->setCellValueByColumnAndRow( 5, 5, "Сумма");
            $sheet->setCellValueByColumnAndRow( 6, 5, "Наименование");

            //Заполняем товары
            $string = 6;
            $startRowProducts = 5;
            $sum = 0;

            foreach ($sumdetails as $product) {
              $sheet->setCellValueByColumnAndRow( 0, $string, $product['product_id']);
              $sheet->setCellValueByColumnAndRow( 1, $string, $product['primarykey']);
              $sheet->setCellValueByColumnAndRow( 2, $string, $product['code']);
              $sheet->setCellValueByColumnAndRow( 3, $string, $product['num']);
              $sheet->setCellValueByColumnAndRow( 3, $string, $product['tobuy']);
              $sheet->setCellValueByColumnAndRow( 4, $string, $product['price']);
              $sheet->setCellValueByColumnAndRow( 5, $string, $product['sum']);
              $sheet->setCellValueByColumnAndRow( 6, $string, $product['name']); //." ".$product['charname']);

              $sum += $product['sum'];

              $string++;
            }
            $string--;
            //Устанавливаем выравнивание по левому краю для столбца с наименованием товаров
            $sheet->getStyle('G1:G'.$string)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

            $sheet->setCellValueByColumnAndRow( 5, $string+1, $sum);


            $borderStyle = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            //Рисуем бордер для заполенных ячеек
            $sheet->getStyle("A1:B".$string)->applyFromArray($borderStyle);
            $sheet->getStyle("C".$startRowProducts.":G".$string)->applyFromArray($borderStyle);


            //заполняем заказы по получателям
            $xls->createSheet();
            $xls->setActiveSheetIndex(1);
            $sheet = $xls->getActiveSheet();
            for($col = 'A'; $col !== 'H'; $col++)
              $sheet->getColumnDimension($col)->setAutoSize(true);

            $string = 1;
            foreach ($orders as $order) {
                $sheet->setCellValueByColumnAndRow( 0, $string, "ID заказа");
                $sheet->setCellValueByColumnAndRow( 1, $string, $order['id']);

                $sheet->setCellValueByColumnAndRow( 0, ++$string, "ФИО");
                $sheet->setCellValueByColumnAndRow( 1, $string, $order['contactname']);

                $sheet->setCellValueByColumnAndRow( 0, ++$string, "Email");
                $sheet->setCellValueByColumnAndRow( 1, $string, $order['person']['email']);

                $sheet->setCellValueByColumnAndRow( 0, ++$string, "Телефон");
                $sheet->setCellValueByColumnAndRow( 1, $string, $order['person']['phone']);

                $sheet->setCellValueByColumnAndRow( 0, ++$string, "Сумма");
                $sheet->setCellValueByColumnAndRow( 1, $string, $order['sum']);

                $sheet->setCellValueByColumnAndRow( 0, ++$string, "ID товара price");
                //$sheet->getStyleByColumnAndRow(1,12)->getFont()->setBold(true)->setItalic(true);
                $sheet->setCellValueByColumnAndRow( 1, $string, "ID товара из 1С");
                $sheet->setCellValueByColumnAndRow( 2, $string, "Код товара");
                $sheet->setCellValueByColumnAndRow( 3, $string, "Количество");
                $sheet->setCellValueByColumnAndRow( 3, $string, "Надо было выкупить");
                $sheet->setCellValueByColumnAndRow( 4, $string, "Цена");
                $sheet->setCellValueByColumnAndRow( 5, $string, "Сумма");
                $sheet->setCellValueByColumnAndRow( 6, $string, "Наименование");


                //Заполняем товары

                $startRowProducts = $string;
                $string++;
                $sum = 0;

                foreach ($order['details'] as $product) {
                  $sheet->setCellValueByColumnAndRow( 0, $string, $product['id']);
                  $sheet->setCellValueByColumnAndRow( 1, $string, $product['primarykey']);
                  $sheet->setCellValueByColumnAndRow( 2, $string, $product['code']);
                  $sheet->setCellValueByColumnAndRow( 3, $string, $product['num']);
                  $sheet->setCellValueByColumnAndRow( 4, $string, $product['price']);
                  $sheet->setCellValueByColumnAndRow( 5, $string, $product['sum']);
                  $sheet->setCellValueByColumnAndRow( 6, $string, $product['name']); //." ".$product['charname']);

                  $sum += $product['sum'];

                  $string++;
                }
                $string--;
                //Устанавливаем выравнивание по левому краю для столбца с наименованием товаров
                $sheet->getStyle('G1:G'.$string)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $string++;
                $sheet->setCellValueByColumnAndRow( 5, $string, $sum);

                $borderStyle = array(
                  'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                  )
                );

                //Рисуем бордер для заполенных ячеек
                $sheet->getStyle("A1:B".$string)->applyFromArray($borderStyle);
                $sheet->getStyle("C".$startRowProducts.":G".$string)->applyFromArray($borderStyle);

                $string++;
            }


            $objWriter = new PHPExcel_Writer_Excel5($xls);
            $file2 = PartuzaConfig::get('site_root').'/priceorders_sz/'.$price_id.".xls";
            $objWriter->save($file2);
            return $file2;
    }

    public function updatesaw($params){
        //  Creating a price
        $status_code = $this->set_status_code("Internal Server Error","500");
        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $method_POST = $this->check_request_method("POST");
        $price_id = $params[3];

        if($method_POST['state']){
                $data = json_decode(file_get_contents('php://input'), true);

                $price_model = $this->model('price');
                $result = $price_model->updatesaw($price_id, $data['person_id']);

                echo '{"status":"OK"}';
                return;
        }
        echo '{"status":"fail"}';
    }

    public function get_stat($params){
        $price_id = $params[3];
        $price_model = $this->model('price');
        $pricedata = $price_model->get_price($price_id);
        $pricedata["stat"] = $price_model->get_stat($price_id);

        echo json_encode($pricedata);
    }


    public function deleteold($params){
        $price_model = $this->model('price');

        $data = $price_model->deleteold();

        $status_code = $this->set_status_code("OK","200");
        $json_response['data']="";
        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        echo json_encode($json_response);
    }

    public function delete21($params){
        $price_model = $this->model('price');

        $data = $price_model->delete21();

        $status_code = $this->set_status_code("OK","200");
        $json_response['data']="";
        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        echo json_encode($json_response);
    }

    public function create_opt($params){
        //  Creating a price
        $status_code = $this->set_status_code("Internal Server Error","500");
        $access_token = apache_request_headers()['access_token'];
        $refresh_token = apache_request_headers()['refresh_token'];

        $method_POST = $this->check_request_method("POST");

        $price_id = "";
        if($method_POST['state']){
            $for_developer['log'] = $method_POST['message'];
            // $update_tokens = $this->validate_tokens($access_token, $refresh_token);
            // $for_developer['log'] = $for_developer['log'] . $update_tokens['message'];

                    $data = json_decode(file_get_contents('php://input'), true);

                    $price_model = $this->model('price');
                    $tag_model = $this->model('tag');

                    //добавить id_clients по тегам
                    if(count($data['tags_id'])){
                      $person_id = $tag_model->get_users_by_tags($data['id_shop'], $data['tags_id']);
                      $data['id_clients'] = array_unique(array_merge($person_id, $data['id_clients']));
                    }

                    $data['id_products'] = array_splice($data['id_products'], 0, 100);

                    $result = $price_model->create_price($data);

                    $price_id = $result['price_id'];

                    $ok_status = $this->set_status_code("OK","200");
                    $result['state'] ? $status_code = $ok_status : $for_developer['details'] = $result;
                    $for_developer['log'] = $for_developer['log'] . $result['message'];

                    //send push to all users in price
                    if($price_id and ($data['id_clients'] or $data['send2all'])){
                      $shop_model = $this->model('shop');
                      $people = $this->model('people');

                      $shop = $shop_model->get_shop_info($data['id_shop']);

                      $msg = ['price_id'=>$price_id,
                       'name'=>$data['name'],
                       'shop_id'=>$data['id_shop'],
                       'shop_name'=>$shop['name'],
                       'type'=>'price'];
                      $title = "Новый прайс ".$data['name']." от ".$shop['name'];
                      $notification = ['title' => $title,'body' => $title, 'data'=> $msg];
    //                      require_once '../vendor/autoload.php';
    //                      require_once PartuzaConfig::get('library_root') . "Expo/Expo.php";
                      //$expo = \ExponentPhpSDK\Expo::normalSetup();
                      require_once PartuzaConfig::get('library_root').'/REST.php';

                      $notclients = [];
                      if($data['send2all']){
                        $clients = $this->get_clients($id);
                        $data['id_clients'] = array_keys($clients);
                      }
                      foreach($data['id_clients'] as $person_id){
                        // не подписан
                        if(!in_array($person_id, $result['clients'])){
                          $notclients[] = $person_id;
                          continue;
                        }

                        $userId = $person_id;
                        $person = $people->get_person_info($userId);
                        $key = $person['pushtoken'];

                        if(!$key) continue;

                        $notification["to"]=$key; //json_encode($to);

                        $status = runREST("https://exp.host/--/api/v2/push/send", "POST_JSON", $notification);

                      }

                    }

        } else{
            $for_developer['details'] = $method_POST;
            $status_code = $method_POST;
        }

        $json_response['price_id'] = $price_id;
        $json_response['notclients'] = $notclients;
        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }

    public function addproducts($params){
        $status_code = $this->set_status_code("Internal Server Error","500");
        $method_POST = $this->check_request_method("POST");

        if($method_POST['state']){
            $for_developer['log'] = $for_developer['log'].$method_POST['message'];

            $data = json_decode(file_get_contents('php://input'), true);
                $price_model = $this->model('price');

                $data['id_products'] = array_splice($data['id_products'], 0, 100);
                $update_price = $price_model->addproducts($data);

		            $status_code = $this->set_status_code("OK","200");

        } else{
            $status_code = $method_POST;
        }

        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];

        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);
    }

}
