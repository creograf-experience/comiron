<?php

$ch = curl_init();

curl_setopt_array($ch, array(
  CURLOPT_URL => 'https://comironserver.comiron.com/shop/update_deliverystate',
  CURLOPT_RETURNTRANSFER => true
));

$res = curl_exec($ch);

if (curl_errno($ch)) {
  print_r(curl_error($ch));
  curl_close($ch);
  return;
}

curl_close($ch);

$json = json_decode($res, true);
print_r($json);
