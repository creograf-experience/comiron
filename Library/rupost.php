<?php
require_once PartuzaConfig::get('library_root').'/REST.php';

function rupost_calc($data) {
  /*
  object тариф
  4020 посылка нестандартная с обьявленной ценностью
  47020 посылка 1 класса с объявленной ценностью
  23020 посылка онлайн с объявленной ценностью

  from индекс
  to индекс
  pack 10 типа упаковки
  weight
  sumoc сумма объявленной ценности
  sumnp сумма наложенного платежа
  data - сейчас
   27020 -
  */
  $API_URL = "https://tariff.pochta.ru/tariff/v1/calculate?json&";
  //$API_URL = "http://russianpostcalc.ru/api_v1.php";
  //$API_KEY = "a5ebbb0e1ca6da48bd3b83dd67ea5f30";//"697a065362c3753c5947dca869080e43";//

  $tariffs = array(4020, 47020, 23020);

//&object=27020&weight=1000&pack=10&sumoc=10000&date=20190423

  $dateStr = date("Ymd");
  $mintotal = 1000000;
  
  foreach ($tariffs as $tariff){
      $pars = array(
        'object' => $tariff,
        'from' => $data['pickupzip'],
        'to' => $data['deliveryzip'],
        'weight' => round($data['weight']*1000),
        'sumoc' => round(($data['declaredValue'])*100),
        'data' => $dateStr
      );

      $params = '';
      foreach($pars as $key=>$value)
        $params .= $key.'='.$value.'&';
      $params = trim($params, '&');

      $curl = curl_init();
//var_dump($API_URL.$params);  
      curl_setopt($curl, CURLOPT_URL, $API_URL.$params);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $data_curl = curl_exec($curl);

      if($data_curl) {
//var_dump($data);
        $res = json_decode($data_curl, $assoc=true);

        if ($res['paynds']) {
          $total = round( $res['paynds'] / 100 );
          if($total < $mintotal){
//            echo $mintotal." < ".$total." ";
            $mintotal = $total;
          }
          
        } 

    }
  }
    
  curl_close($curl);

  if($mintotal < 1000000)
    return $mintotal;
  else return 0;
}

function rupost_generate_pdf($data) {
  $API_URL = "http://russianpostcalc.ru/api_v1.php";
  $API_KEY = "a5ebbb0e1ca6da48bd3b83dd67ea5f30";
  $API_PASSWORD = 'abram123';

  $data = array(
    'from_country' => 'Россия',
    'to_country' => 'Россия',
    'from_fio' => $data['from_fio'],
    'from_index' => $data['from_index'],
    'from_addr' => $data['from_addr'],
    'to_fio' => $data['to_fio'],
    'to_index' => $data['to_index'],
    'to_addr' => $data['to_addr'],
    'ob_cennost_rub' => $data['ob_cennost_rub']
  );

  $params = array(
    'apikey' => $API_KEY,
    'method' => 'print_f116',
    'f116_onepage' => 1,
    'print0' => 0,
    'list' => json_encode(array($data))
  );

  $all_to_md5 = $params;
  $all_to_md5[] = $API_PASSWORD;
  $hash = md5(implode("|", $all_to_md5));
  $params['hash'] = $hash;

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $API_URL);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($curl);

  if($data) {
    $res = json_decode($data, $assoc=true);

    if ($res['link']) {
      $link = $res['link'];
    } else {
      $link = $res;
    }
  } else {
    $link = null;
  }

  curl_close($curl);

  return $link;
}

?>
