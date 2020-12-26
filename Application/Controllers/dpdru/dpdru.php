<?php
/**
 
 */

class dpdruController extends baseController {
  private $DPDprocent=10;
    //$DPDprocent=(isset() && is_numeric(PartuzaConfig::get("DPDprocent"))?PartuzaConfig::get("DPDprocent"):0;
 
  public function index($params) {
  }
  
  //подсказки для городов
  public function citysearch($params) {
    if (!isset($_SESSION['id']) or !isset($_REQUEST['query'])) { echo json_encode(array('query' => $q, 'suggestions' => "")); return; }
    $q = $_REQUEST['query'];
    
    $dpdcity = $this->model("dpdcity");
    $data = $dpdcity->search($q);

    if(count(data)<1){ echo json_encode(array('query' => $q, 'suggestions' => "")); return; }

    foreach ($data as $i => $city) {
      $seg[] = array(
            "data" =>  $data[$i]['id'],
            "value" =>
             $data[$i]['abbr'] . " " . $data[$i]['name'] .
            (($data[$i]['region'])? ", " . $data[$i]['region'] :"") .
            (($data[$i]['rayon'])? ", " . $data[$i]['rayon'] . " район" :"") .
            (($data[$i]['minindex'] and $data[$i]['maxindex'])? ", " . $data[$i]['minindex'] . " - " . $data[$i]['maxindex']:"")
          );
    }
    echo json_encode(array('query' => $q, 'suggestions' => $seg));

  }

  public function calc($params){
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    //добавлять свой процент

    require_once PartuzaConfig::get('library_root').'/DPD.php';


    $DPD = new DPD;

    //расчет объема
    $volume = 0;
    if(isset($_REQUEST['volume'])){
      $volume = $_REQUEST['volume'] / 100;
    }
    if(isset($_REQUEST['w']) && isset($_REQUEST['d']) && isset($_REQUEST['w']) && $_REQUEST['w']>0 && $_REQUEST['d']>0 && $_REQUEST['h']>0){
      $volume = ($_REQUEST['w'] / 100) * ($_REQUEST['d'] / 100) * ($_REQUEST['h'] / 100);
    }
    
    // массив входных данных: город доставки и вес отправки
    // остальные параметры запроса к сервису прописаны в методе
    $arData = array(
      'serviceCode' => "ECN",
      'selfPickup' => true,
      'selfDelivery' => true,
      'delivery' => array(      // город доставки
          'cityId' => $_REQUEST['cityid'],
          //'terminalCode'  => $shop['terminal'], 
          //'cityName' => $_REQUEST['deliverycity'],
          //'index' => $_REQUEST['deliveryzip'],
          //'regionCode' => 
      ),
      'pickup' => array(      // город отправки
          //'cityId' => $_REQUEST['cityid'],
          //'cityId' => 49172112,
          'cityName' => $_REQUEST['pickupcity'],
          //'index' => $_REQUEST['pickupzip'],
          //'regionCode' => 
      ),
      'weight' => $_REQUEST['weight'],          // вес отправки
      'volume' => $volume, //объем
    );
    
    $arCost = $DPD->getServiceCost2($arData);
    $arCost['cost'] = $arCost['cost'] + $arCost['cost']*$this->DPDprocent/100;

    echo $arCost['cost'];
  }

  public function calc2door($params){
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    
    require_once PartuzaConfig::get('library_root').'/DPD.php';
    $DPD = new DPD;

    //расчет объема
    $volume = 0;
    if(isset($_REQUEST['volume'])){
      $volume = $_REQUEST['volume'] / 100;
    }
    if(isset($_REQUEST['w']) && isset($_REQUEST['d']) && isset($_REQUEST['h']) && $_REQUEST['w']>0 && $_REQUEST['d']>0 && $_REQUEST['h']>0){
      $volume = ($_REQUEST['w'] / 100) * ($_REQUEST['d'] / 100) * ($_REQUEST['h'] / 100);
    }
    
    // массив входных данных: город доставки и вес отправки
    // остальные параметры запроса к сервису прописаны в методе
    $arData = array(
      'serviceCode' => "ECN",
      'selfPickup' => true,
      'selfDelivery' => false,
      'delivery' => array(      // город доставки
          'cityId' => $_REQUEST['cityid'],
          //'terminalCode'  => $shop['terminal'], 
          //'cityName' => $_REQUEST['deliverycity'],
          //'index' => $_REQUEST['deliveryzip'],
          //'regionCode' => 
      ),
      'pickup' => array(      // город отправки
          //'cityId' => $_REQUEST['cityid'],
          //'cityId' => 49172112,
          'cityName' => $_REQUEST['pickupcity'],
          //'index' => $_REQUEST['pickupzip'],
          //'regionCode' => 
      ),
      'weight' => $_REQUEST['weight'],          // вес отправки
      'volume' => $volume, //объем
    );
    
    $arCost = $DPD->getServiceCost2($arData);
    $arCost['cost'] = $arCost['cost'] + $arCost['cost']*$this->DPDprocent/100;

    echo $arCost['cost'];
  }

  //использует класс dpd2
  public function calc2($params){
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    
    require_once PartuzaConfig::get('library_root').'/DPD.php';
    $DPD = new DPD2;

    //расчет объема
    $volume = 0;
    if(isset($_REQUEST['volume'])){
      $volume = $_REQUEST['volume'] / 100;
    }
    if(isset($_REQUEST['w']) && isset($_REQUEST['d']) && isset($_REQUEST['w']) && $_REQUEST['w']>0 && $_REQUEST['d']>0 && $_REQUEST['h']>0){
      $volume = ($_REQUEST['w'] / 100) * ($_REQUEST['d'] / 100) * ($_REQUEST['h'] / 100);
    }
    
    // массив входных данных: город доставки и вес отправки
    // остальные параметры запроса к сервису прописаны в методе
    $arData = array(
      'serviceCode' => "PCL",
      'selfPickup' => true,
      'selfDelivery' => true,
      'delivery' => array(      // город доставки
          'cityId' => $_REQUEST['cityid'],
          //'terminalCode'  => $shop['terminal'], 
          //'cityName' => $_REQUEST['deliverycity'],
          //'index' => $_REQUEST['deliveryzip'],
          //'regionCode' => 
      ),
      'pickup' => array(      // город отправки
          //'cityId' => $_REQUEST['cityid'],
          //'cityId' => 49172112,
          'cityName' => $_REQUEST['pickupcity'],
          //'index' => $_REQUEST['pickupzip'],
          //'regionCode' => 
      ),
      'weight' => $_REQUEST['weight'],          // вес отправки
      'volume' => $volume, //объем
    );
    
    $arCost = $DPD->getServiceCost2($arData);
    $arCost['cost'] = $arCost['cost'] + $arCost['cost']*$this->DPDprocent/100;

    echo $arCost['cost'];

  }

  //использует класс dpd2
  public function calc2door2($params){
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    
    require_once PartuzaConfig::get('library_root').'/DPD.php';
    $DPD = new DPD2;

    //расчет объема
    $volume = 0;
    if(isset($_REQUEST['volume'])){
      $volume = $_REQUEST['volume'] / 100;
    }
    if(isset($_REQUEST['w']) && isset($_REQUEST['d']) && isset($_REQUEST['w']) && $_REQUEST['w']>0 && $_REQUEST['d']>0 && $_REQUEST['h']>0){
      $volume = ($_REQUEST['w'] / 100) * ($_REQUEST['d'] / 100) * ($_REQUEST['h'] / 100);
    }
    
    // массив входных данных: город доставки и вес отправки
    // остальные параметры запроса к сервису прописаны в методе
    $arData = array(
      'serviceCode' => "PCL",
      'selfPickup' => true,
      'selfDelivery' => false,
      'delivery' => array(      // город доставки
          'cityId' => $_REQUEST['cityid'],
          //'terminalCode'  => $shop['terminal'], 
          //'cityName' => $_REQUEST['deliverycity'],
          //'index' => $_REQUEST['deliveryzip'],
          //'regionCode' => 
      ),
      'pickup' => array(      // город отправки
          //'cityId' => $_REQUEST['cityid'],
          //'cityId' => 49172112,
          'cityName' => $_REQUEST['pickupcity'],
          //'index' => $_REQUEST['pickupzip'],
          //'regionCode' => 
      ),
      'weight' => $_REQUEST['weight'],          // вес отправки
      'volume' => $volume, //объем
    );
    
    $arCost = $DPD->getServiceCost2($arData);
    $arCost['cost'] = $arCost['cost'] + $arCost['cost']*$this->DPDprocent/100;

    echo $arCost['cost'];
  }

  public function sendorder($params){
    //$client = new SoapClient("http://wstest.dpd.ru/services/order2?wsdl", array("trace" => 1, "exception" => 0));
    
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }
    
    $this->loadMessages($this->get_cur_lang());
    
    require_once PartuzaConfig::get('library_root').'/DPD.php';
    $DPD = 0;
    if($order['deliverytype'] == "todoor" or $order['deliverytype'] == "toterm"){
      $DPD = new DPD;
    }else{
      $DPD = new DPD2;
    }

    $order_id = intval($_REQUEST['order_id']);
    $orderm = $this->model("order");
    $order = $orderm->get_order($order_id, null, $_REQUEST['shop_id']);
    $shop = $this->model("shop");
    $shop = $shop->get_shop($_REQUEST['shop_id']);
    $people = $this->model("people");
    $person = $people->get_person($order['person_id']);

    /*if(!isset($order['address'])){
      echo "delivery address is not defined";
      return;
    } */
    if(!$order['date_pickup']){
      echo "pickup date is not defined";
      return;
    } 
    if(!isset($order['terminal'])){
      echo "client terminal is not defined";
      return;
    } 
    if(!isset($shop['terminal'])){
      echo "shop terminal is not defined";
      return;
    } 
    if(!isset($order['volume'])){
      $order['volume'] = 0.05;
    } 

    //узнать адреса терминалов
    $terminal = $DPD->getTerminalsSelfDelivery();
    $receiverAddress = array();

    /*foreach ($terminal['terminal'] as $i => $t) {
      if($t['terminalCode'] == $order['terminal']){
        $receiverAddress = $t['address'];
      }
    }*/
    $datepickup = $order['date_pickup'];
    $datepickup = date('Y-m-d', $datepickup);


    if($order['deliverytype'] == "todoor" or $order['deliverytype'] == "todoor2"){
      $arOrder_DPD = array(
          'header' => array(
            'datePickup'  => $datepickup, 
            'senderAddress' => //$senderAddress,
            array(
                'name'=> $shop['name'],
                'terminalCode'  => $shop['terminal'], 
                 "contactFio"=>$shop['logistname'],
                 "contactPhone"=>$shop['logistphone'],
            ),
          ),
          'order' => array(
              'orderNumberInternal' => $order_id,
              'serviceCode' => 'ECN',
              'serviceVariant' => 'ТД',
              'cargoNumPack' => $order['numpack'],
              'cargoWeight' => $order['weight'],
              'cargoVolume' => $order['volume'],
              'cargoRegistered' => false,
              'cargoCategory' => $order['category'],
              'receiverAddress' => //$receiverAddress,
              array(
                  //'code' => $address_code,
                  'name' => $order['name'],
                  //'terminalCode'     => $order['terminal'],
                   "contactFio"=>$person['first_name'],
                   "contactPhone"=>$order['phone'],
              
                 //"countryCode" => "RU",
                 "countryName" => "Россия",
                // "regionCode" => "74",
                // "regionName" => $order["city"],
                // "region" => $order["city"],
                 "cityCode" => $order["dpdcityid"],
                 "city" => $order["city"],
                 "index" => $order["postalcode"],
                 "street" => $order["dpdstreet"],
                 "streetAbbr" => $order["dpdstreetprefix"],
                 "house" => $order["dpdhouse"],
                 "houseKorpus" => $order["dpdkorpus"],
                 "st" => $order["dpdstroenie"],
                 "vlad" => $order["dpdvladenie"],
                 "office" => $order["office"],
                 "flat" => $order["flat"],
              ),
          ),
  //      ),
      );
    }else {
      
      $arOrder_DPD = array(
  //      'orders'=>array(
  //        'auth' => array(
  //          'clientNumber'  => '1021003012',
  //          'clientKey'   => '1E8C5E6EE6EF4C30BBDED1836CA0CA6C0D38F053',
  //        ),
          'header' => array(
            'datePickup'  => $datepickup, 
            'senderAddress' => //$senderAddress,
            array(
                'name'=> $shop['name'],
                'terminalCode'  => $shop['terminal'], 
                 "contactFio"=>$shop['logistname'],
                 "contactPhone"=>$shop['logistphone'],
          
          /*       "countryCode" => $senderAddress["countryCode"],
                 "regionCode" => $senderAddress["regionCode"],
                 "regionName" => $senderAddress["regionName"],
                 "cityCode" => $senderAddress["cityCode"],
                 "cityName" => $senderAddress["cityName"],
                 "index" => $senderAddress["index"],
                 "street" => $senderAddress["street"],
                 "streetAbbr" => $senderAddress["streetAbbr"],
                 "houseNo" => $senderAddress["houseNo"],
            */
            ),
          ),
          'order' => array(
              'orderNumberInternal' => $order_id,
              'serviceCode' => 'ECN',
              'serviceVariant' => 'ТТ',
              'cargoNumPack' => $order['numpack'],
              'cargoWeight' => $order['weight'],
              'cargoVolume' => $order['volume'],
              'cargoRegistered' => false,
              'cargoCategory' => $order['category'],
              'receiverAddress' => //$receiverAddress,
              array(
                  //'code' => $address_code,
                  'name' => $order['name'],
                  'terminalCode'     => $order['terminal'],
                   "contactFio"=>$person['first_name'],
                   "contactPhone"=>$order['phone'],
              /*
                 "countryCode" => $receiverAddress["countryCode"],
                 "regionCode" => $receiverAddress["regionCode"],
                 "regionName" => $receiverAddress["regionName"],
                 "cityCode" => $receiverAddress["cityCode"],
                 "cityName" => $receiverAddress["cityName"],
                 "index" => $receiverAddress["index"],
                 "street" => $receiverAddress["street"],
                 "streetAbbr" => $receiverAddress["streetAbbr"],
                 "houseNo" => $receiverAddress["houseNo"],
           */
              ),
          ),
  //      ),
      );
    }
    //echo var_dump($arOrder_DPD);
    
    //$orderDPD = $client->createOrder($arOrder_DPD);
    $orderDPD = $DPD->createOrder($arOrder_DPD);
    //echo var_dump($orderDPD);
    if($orderDPD['status'] == "OrderError"){
      echo $orderDPD['errorMessage'];
    }else{ 
      //обновить статус заказа заказ
      $orderm->save($order['id'], array("orderstatus_id"=>6));

      //присвоен номер заказа 
      if(isset($orderDPD['orderNum'])){
          $orderm->save($order['id'], array(
              'deliverynum' => $orderDPD['orderNum']
          ));
      }
      
      //$this->loadMessages($this->get_cur_lang());
      //echo $this->t("shop", "delivery in process");
      echo $orderDPD['orderNum'];
      if(!$orderDPD['orderNum']){
        echo var_dump($orderDPD);
      }
      
    }
  }

  //список терминалов
  public function terminals($params){
    
    require_once PartuzaConfig::get('library_root').'/DPD.php';
    $DPD = new DPD;

    $data = $DPD->getTerminalsSelfDelivery();
    echo (json_encode($data));
    
  }

  //обновить заказы
  public function updateorders($params){
    require_once PartuzaConfig::get('library_root').'/DPD.php';
    $DPD = new DPD;

    //список заказов на доставке в dpd
    $orderm = $this->model("order");
    $orders = $orderm->get_orders(array("delivery"=>"dpd", "orderstatus_id"=>"6"));
 
    $comment = $this->model("comment");
    $shops = $this->model("shop");

    $this->loadMessages($this->get_cur_lang());
   
    foreach ($orders as $i => $order) {
      echo $order['id'];
      try{
        $data = $DPD->getStatesByClientOrder(array("clientOrderNr"=>$order['id']));
      }catch(Exception $e){
        continue;
      }
      
      if(count($data['states']) < 1) continue;

      //данные из последнего статуса
      $last = $data['states'][count($data['states']) - 1];
      echo var_dump($last);
      $cost = ((int)($last['orderCost'] * 118)) / 100; // НДС и округление до копеек

      if($order['deliverynum'] != $last['dpdOrderNr'] or
          $order['deliverystate'] != $last['newState'] or
          $order['deliverydate'] != $last['planDeliveryDate'] or
          $order['deliverycost'] != $cost 
        ){

          //посылка доставлена, статус заказа - выполнен
          if($last['newState'] == "Delivered"){
            $orderm->save($order['id'], array(
                "orderstatus_id"=>3
              ));
          }

          //сохранить новые значения
          $orderm->save($order['id'], array(
              'deliverynum' => $last['dpdOrderNr'],
              'deliverystate' => $last['newState'],
              'deliverydate' => $last['planDeliveryDate'],
              'deliverycost' => $cost 
          ));

          //добавить комментарий
          $shop = $shops->get_shop($order['shop_id']);
          $comment->add(array(
              "object_name"=>"order",
              "object_id" => $order['id'],
              "text" => "Автоматическое обновление информации по доставке<br>Стоимость: $cost<br>Планируемая дата доставки: ".$last['planDeliveryDate']."<br>Состояние: ".$this->t("shop", "dpd_".$last['newState'])."<br>Номер заказа в службе доставки: ".$last['dpdOrderNr'],
              "person_id"=>$shop['person_id'], //владелец магазина, от имени которого добавится комментарий
            ));
      }
      
    }

    echo "done";
    //echo (json_encode($data));
  }

  
  //печать наклеек
  public function sticker($params){
    $order_id = intval($_REQUEST['id']);
    if (!$order_id) {
      return;
    }
    $orderm = $this->model("order");
    $order = $orderm->get_order($order_id, null, $_REQUEST['shop_id']);
    if(!$order['deliverynum']){
      return;
    }

    require_once PartuzaConfig::get('library_root').'/DPD.php';
 //   $DPD = new DPD;
    $DPD = 0;
    if($order['deliverytype'] == "todoor" or $order['deliverytype'] == "toterm"){
      $DPD = new DPD;
    }else{
      $DPD = new DPD2;
    }


    $data = $DPD->getInvoiceFile(array("orderNum"=>$order['deliverynum']));
    
    header("Content-type:application/pdf");
    header("Content-Disposition:attachment;filename='dpd_".$order_id.".pdf'");
    echo $data[file];
    
  }
    
}