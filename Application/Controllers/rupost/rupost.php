<?php

class rupostController extends baseController {

  private $procent = 15;

  public function index($params) {
  }

  public function calc(){
    if (! isset($_SESSION['id'])) {
      header("Location: /");
    }

    require_once PartuzaConfig::get('library_root').'/rupost.php';
  
    if((isset($_REQUEST['weight']) && $_REQUEST['weight'] >= 20)){
      echo -1;
      die();
    }

    if((isset($_REQUEST['volume']) && $_REQUEST['volume'] == 0) || (isset($_REQUEST['weight']) && $_REQUEST['weight'] == 0)){
      echo 0;
      die();
    }

    
    $total = rupost_calc($_REQUEST);

    $total = $total + $total*$this->procent/100;

    if($_REQUEST['taxcash'] == 1){
        $total += $total*PartuzaConfig::get('RUPOSTprocent')/100;
          
        }

     echo $total;

    // //расчет объема
    // $volume = 0;
    // if(isset($_REQUEST['volume'])){
    //   $volume = $_REQUEST['volume'] / 100;
    // }
    // if(isset($_REQUEST['w']) && isset($_REQUEST['d']) && isset($_REQUEST['w'])){
    //   $volume = ($_REQUEST['w'] / 100) * ($_REQUEST['d'] / 100) * ($_REQUEST['h'] / 100);
    // }

    // // массив входных данных: город доставки и вес отправки
    // // остальные параметры запроса к сервису прописаны в методе
    // $arData = array(
    //   'serviceCode' => "ECN",
    //   'selfPickup' => true,
    //   'selfDelivery' => true,
    //   'delivery' => array(      // город доставки
    //       //'cityId' => 49172112,
    //       'cityName' => $_REQUEST['deliverycity'],
    //   ),
    //   'pickup' => array(      // город доставки
    //       //'cityId' => 49172112,
    //       'cityName' => $_REQUEST['pickupcity'],
    //   ),
    //   'weight' => $_REQUEST['weight'],          // вес отправки
    //   'volume' => $volume, //объем
    // );

    // $arCost = ;

    // echo $arCost['cost'];
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
    $DPD = new DPD;

    $data = $DPD->getInvoiceFile(array("orderNum"=>$order['deliverynum']));

    header("Content-type:application/pdf");
    header("Content-Disposition:attachment;filename='dpd_".$order_id.".pdf'");
    echo $data[file];

  }

}