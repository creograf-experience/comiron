<?php

class PEK {
  private $_host = 'https://kabinet.pecom.ru/api/v1/';
  private $_login = 'dostavka11';
  private $_api_key = 'D2441467E21F2185EE680C7F0DC2BF0DC6CEB908';

  public function get_basic_status($cargo_codes) {
    return $this->_execute_request('/cargos/basicstatus', $cargo_codes);
  }

  private function _execute_request($url, $body = null) {
    $ch = curl_init();

    curl_setopt_array($ch, array(
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_POST => TRUE,
      CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
      CURLOPT_ENCODING => 'gzip',
      CURLOPT_USERPWD => $this->_login.':'.$this->_api_key,
      CURLOPT_URL => $this->_host.$url,
      CURLOPT_POSTFIELDS => json_encode($body),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json; charset=utf-8'	
      )
    ));

    $response = curl_exec($ch);
    if (curl_errno($ch)) return curl_error($ch);

    curl_close($ch);

    return json_decode($response, true);
  }
}
