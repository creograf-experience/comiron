<?php
/*
@access public

DPD_service - класс работы с DPD-сервисом

ВАЖНО!
1. Перед началом работы необходимо прописать свои значения в свойства класса $MY_NUMBER и $MY_KEY
2. Для переключения на рабочий хост DPD-сервиса нужно обнулить свойство класса $IS_TEST
3. Данный класс заточен на работу в кодировке windows-1251

ПРИМЕР РАБОТЫ:

// подключение класса (указать свой путь к классу)
require_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/dpd_service.class.php');
$DPD = new DPD_service;


// ЗАПРОС СПИСКА ГОРОДОВ ----------

$arCityList = $DPD->getCityList();

  формат $arCityList:
  Array
    0 => Array[6]
      cityId => "48951627"
      countryCode => "RU"
      countryName => "Россия"
      regionCode => "42"
      regionName => "Кемеровская обл."
      cityName => "Кемерово"
    ...


// ЗАПРОС СТОИМОСТИ ДОСТАВКИ ------

// массив входных данных: город доставки и вес отправки
// остальные параметры запроса к сервису прописаны в методе
$arData = array(
  'delivery' => array(      // город доставки
      'cityId' => 49172112,
      'cityName' => 'Пермь',
    ),
  'weight' => 5,          // вес отправки
);
$arCost = $DPD->getServiceCost($arData);

  формат $arCost:
  Array
    0 => Array[4]
      serviceCode => "TEN"
      serviceName => "DPD 10:00"
      cost => "1887.59"
      days => "1"
    ...
*/


class DPD
{
  public $arMSG = array();    // массив-сообщение ('str' => текст_сообщения, 'type' => тип_сообщения (по дефолту: 0 - ошибка)
  
  private $IS_ACTIVE  = 1;    // флаг активности сервиса (0 - отключен, 1 - включен)
  private $IS_TEST  = 0;    // флаг тестирования (0 - работа, 1 - тест)
  private $SOAP_CLIENT;     // SOAP-клиент

  private $MY_NUMBER  = '1021003012'; 
  private $MY_KEY   = '1E8C5E6EE6EF4C30BBDED1836CA0CA6C0D38F053'; 

  private $arDPD_HOST = array(
          0 => 'ws.dpd.ru/services/',         // рабочий хост
          1 => 'wstest.dpd.ru/services/',     // тестовый хост
      );

  private $arSERVICE = array(                 // сервисы: название => адрес
          'getCitiesCashPay'  => 'geography2',      // География DPD (города доставки)
          'getTerminalsSelfDelivery2' => 'geography2',  // список терминалов DPD (TODO)
          'getServiceCost2' => 'calculator2',   // Расчёт стоимости
          'createOrder'   => 'order2',      // Создать заказ на доставку (TODO)
          'getOrderStatus'  => 'order2',      // Получить статус создания заказа (TODO)
          'createLabelFile'   => 'label-print',                               // Получить наклейки
          'createAddress'   => 'order2', 
          'getCitiesCashPay2' => 'geography2',
          'getStatesByClientOrder' => 'tracing',
          'getInvoiceFile' => 'order2',
          'getStatesByClient' => 'tracing',
          'getStatesByDPDOrder' => 'tracing'
      );
  /**
  * Конструктор
  *
  * @access public
  * @return void
  */
  public function __construct()
  {
    $this->IS_TEST = $this->IS_TEST ? 1 : 0;
  }
  
  
  /**
  * Список городов доставки
  * 
  * @access public
  * @return 
  */
  public function getCityList()
  {
    $obj = $this->_getDpdData('getCitiesCashPay2');
    
    // конверт $obj --> $arr
    $res = $this->_parceObj2Arr($obj->return);
    
    return $res;
  }

  public function getStatesByClient($arData){
    $obj = $this->_getDpdData('getStatesByClient', $arData, 'request');
    $res = $this->_parceObj2Arr($obj->return, 0);
    
    return $res;
  }

  public function getStatesByDPDOrder($arData){
    $obj = $this->_getDpdData('getStatesByDPDOrder', $arData, 'request');
    $res = $this->_parceObj2Arr($obj->return, 0);

    return $res;
  }

  public function getTerminalsSelfDelivery() {
        $obj = $this->_getDpdData('getTerminalsSelfDelivery2');
        $res = $this->_parceObj2Arr($obj->return, 0);
        return $res;
  }
  
  /**
  * Определение стоимости доставки
  * 
  * @access public
  * @param array  $arData   // массив входных параметров*
  * @return 
  */
  public function getServiceCost2($arData)
  {
    
    // третий параметр - флаг упаковки запроса в общее поле "request"
    $obj = $this->_getDpdData('getServiceCost2', $arData, "request");
    $res = $this->_parceObj2Arr($obj->return);
    //echo var_dump($res);
    return $res;
  }

/**
  * Отправка заказа
  * 
  * @access public
  * @param array  $arData   // массив входных параметров*
  * @return 
  */
  public function createOrder($arData) {
//      $client = new SoapClient("http://wstest.dpd.ru/services/order2?wsdl", array("trace" => 1, "exception" => 0));
        $obj = $this->_getDpdData('createOrder',  $arData, "orders");
        $res = $this->_parceObj2Arr($obj->return, 0);
        //$client = new SoapClient("http://".$this->arDPD_HOST[$this->IS_TEST]."order2?wsdl", array("trace" => 1, "exception" => 0));
        //$obj = $client->createOrder($arData);
        //echo var_dump($res);
        return $res;
  }

  public function getOrderStatus($arData) {
        $obj = $this->_getDpdData('getOrderStatus', $arData);
        $res = $this->_parceObj2Arr($obj->return, 0);
        return $res;
   }

  public function createLabelFile($arData) {
        $obj = $this->_getDpdData('createLabelFile', $arData, 'getLabelFile');
        $res = $this->_parceObj2Arr($obj->return, 0);
        return $res;
  }

  public function createAddress($arData) {
        $obj = $this->_getDpdData('createAddress', $arData, 'orders');
        $res = $this->_parceObj2Arr($obj->return, 0);
        return $res;
  }

  public function getStatesByClientOrder($arData) {
        $obj = $this->_getDpdData('getStatesByClientOrder', $arData, 'request');
        $res = $this->_parceObj2Arr($obj->return, 0);
        return $res;
  }

  public function getInvoiceFile($arData) {
        $obj = $this->_getDpdData('getInvoiceFile', $arData, 'request');
        $res = $this->_parceObj2Arr($obj->return, 0);
        return $res;
  }

// PRIVATE ------------------------

  /**
  * Коннект с соответствующим сервисом
  *
  * @access private
  * @param string $method_name  Запрашиваемый метод сервиса (см. ключ свойства класса $this->arSERVICE)
  * @return bool          Результат инициализации (если положительный - появится свойство $this->SOAP_CLIENT, иначе $this->arMSG)
  */
  private function _connect2Dpd($method_name)
  {
    if(!$this->IS_ACTIVE) return false;

    if(!$service = $this->arSERVICE[$method_name])
    {
      //$this->arMSG['str']  = 'В свойствах класса нет сервиса "'.$method_name.'"';
      echo 'В свойствах класса нет сервиса "'.$method_name.'"';
      return false;
    }
    
    $host = $this->arDPD_HOST[$this->IS_TEST].$service.'?WSDL';
    //try {
      // Soap-подключение к сервису
      $this->SOAP_CLIENT = new SoapClient('http://'.$host, array("trace" => 1, "exception" => 0));
      //$client = new SoapClient("http://wstest.dpd.ru/services/geography2?wsdl");
      //echo var_dump($this->SOAP_CLIENT); return;
    

      if(!$this->SOAP_CLIENT) { 
        echo "Не удалось подключиться к сервисам DPD $host"; 
        return false;
      }; 
    /*} catch (Exception $ex) {
        $this->arMSG['str'] = 'Не удалось подключиться к сервисам DPD '.$service;
        echo "Не удалось подключиться к сервисам DPD $host"; 
        return false;
    }*/

    return true;
  }

  /**
  * Запрос данных в методе сервиса
  * 
  * @access private
  * @param string   $method_name  Название метода Dpd-сервиса (см. $arSERVICE) 
  * @param array    $arData     Массив параметров, передаваемых в метод
  * @param integer  $is_request   флаг упаковки запроса в поле 'request'
  * @return XZ_obj          Объект, полученный от сервиса
  */
  private function _getDpdData($method_name, $arData=array(), $is_request="")
  {
    
    // параметр запроса для аутентификации
    $arData['auth'] = array(
      'clientNumber'  => $this->MY_NUMBER,
      'clientKey'   => $this->MY_KEY,
    );
    // упаковка запроса в поле 'request'
    if($is_request) $arRequest[$is_request] = $arData;
    else  $arRequest = $arData;
    
    if(!$this->_connect2Dpd($method_name)){
       echo "can't connect to dpd";
       return false;
    }
  //die;
    //try {
    //  eval("\$obj = \$this->SOAP_CLIENT->\$method_name(\$arRequest);");
        $obj = $this->SOAP_CLIENT->$method_name($arRequest);
    //  if(!$obj) throw new Exception('Ошибка');
    /*} catch (Exception $ex) {
      $this->arMSG['str'] = 'Не удалось вызвать метод '.$method_name.' / '.$ex;
      echo 'Не удалось вызвать метод '.$method_name.' / '.$ex;
    }*/
    return $obj ? $obj : false;
  }
  
  /**
  * Парсер объекта в массив (рекурсия)
  * 
  * @access private
  * @param object   $obj    Объект
  * @param integer  $isUTF    Флаг необходимости конвертирования строк из UTF в WIN (0|1), по-дефолту "1" - конвертить
  * @param array    $arr    Внутренний cлужебный массив для обеспечения рекурсии
  * @return array
  */
  private function _parceObj2Arr($obj,$isUTF=1,$arr=array())
  {
    $isUTF = $isUTF ? 1 : 0;
    
    if(is_object($obj) || is_array($obj) )
    {
      $arr = array();
      for(reset($obj); list($k, $v) = each($obj);)
      {
        if($k === "GLOBALS") continue;
        $arr[$k] = $this->_parceObj2Arr($v, $isUTF, $arr);
      }
      return $arr;
    }
    elseif(gettype($obj) == 'boolean') 
    {
      return $obj ? 'true' : 'false'; 
    }
    else
    {
      // конверт строк: utf-8 --> windows-1251
      if($isUTF && gettype($obj)=='string') $obj = iconv('utf-8','windows-1251',$obj);
      return $obj;
    }
  }
}

//DPD2
class DPD2 extends DPD
{
  
  private $IS_ACTIVE  = 1;    // флаг активности сервиса (0 - отключен, 1 - включен)
  private $IS_TEST  = 0;    // флаг тестирования (0 - работа, 1 - тест)
  private $SOAP_CLIENT;     // SOAP-клиент


  private $MY_NUMBER  = '1021003428'; 
  private $MY_KEY   = 'AE5AE1332B2A545C7B4F1028B4F56F4879D08875'; 

  private $arDPD_HOST = array(
          0 => 'ws.dpd.ru/services/',         // рабочий хост
          1 => 'wstest.dpd.ru/services/',     // тестовый хост
      );

  private $arSERVICE = array(                 // сервисы: название => адрес
          'getCitiesCashPay'  => 'geography2',      // География DPD (города доставки)
          'getTerminalsSelfDelivery2' => 'geography2',  // список терминалов DPD (TODO)
          'getServiceCost2' => 'calculator2',   // Расчёт стоимости
          'createOrder'   => 'order2',      // Создать заказ на доставку (TODO)
          'getOrderStatus'  => 'order2',      // Получить статус создания заказа (TODO)
          'createLabelFile'   => 'label-print',                               // Получить наклейки
          'createAddress'   => 'order2', 
          'getCitiesCashPay2' => 'geography2',
          'getStatesByClientOrder' => 'tracing',
          'getInvoiceFile' => 'order2',
      );

}

?>