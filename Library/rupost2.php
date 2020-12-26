<?php
require_once PartuzaConfig::get('library_root').'/REST.php';

function rupost_calc($data) {
  $API_URL = "http://russianpostcalc.ru/api_v1.php";
  $API_KEY = "a5ebbb0e1ca6da48bd3b83dd67ea5f30";//"697a065362c3753c5947dca869080e43";//

  $params = array(
    'apikey' => $API_KEY,
    'method' => 'calc',
    'from_index' => $data['pickupzip'],
    'to_index' => $data['deliveryzip'],
    'weight' => $data['weight'],
    'ob_cennost_rub' => $data['declaredValue']
  );

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $API_URL);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($curl);

  if($data) {
    $res = json_decode($data, $assoc=true);

    if ($res['calc'] && $res['calc'][1]) {
      $total = $res['calc'][1]['cost'];
    } else {
      $total = var_dump($res);
    }
  } else {
    //$total = 0;
    echo 'Ошибка curl: ' . curl_error($ch);
  }

  curl_close($curl);

  return $total;
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
