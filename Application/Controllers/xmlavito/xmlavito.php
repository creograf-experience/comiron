<?php 
// класс для импорта в АвитоXML
class xmlavitoController extends baseController {

	// Добавление в XML
	
	public function product_goxml($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    
    $shop = $this->model('shop');
    $xmlavito = $this->model('xmlavito');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id']; 
    if(!isset($params[3]) or $params[3]!=$shop_id){
      header("Location: /");
    } 

     foreach ($_POST['toxml'] as $id){

      $xmlavito->goToXml($id,$shop_id);
    } 
    
    header("Location: /shop/myproducts/".$shop_id);

  }

  //Удаление из XML
  public function product_delxml($params) {
    if (! $_SESSION['id']) {
      header("Location: /");
      die();
    }
    
    $shop = $this->model('shop');
    $xmlavito = $this->model('xmlavito');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    $shop_id = $myshop['id']; 
    if(!isset($params[3]) or $params[3]!=$shop_id){
      header("Location: /");
    } 

     foreach ($_POST['toxml'] as $id){

      $xmlavito->delFromXml($id,$shop_id);
    } 
    
    header("Location: /shop/myproducts/".$shop_id);

  }

  public function getCategoryAvito() {
     

    $xml = parent::model('xmlavito');
    $category = $xml->getCategory();
    echo json_encode($category);

  }

  public function getGoodsTypeAvito() {
    $xml = parent::model('xmlavito');
    $subCategory = $xml->getGoodsType(($_REQUEST['sub']));
    echo json_encode($subCategory);
  }

  public function genericXml($params) {

      $xml = $this->model('xmlavito');
      $xml->buildXml();
    }

  public function parseAvito($params) {
     $filename = "xml.json";
     $res = file_get_contents("http://autoload.avito.ru/format/Locations.xml");
     $xml = simplexml_load_string($res);
     $json = json_encode($xml);
     file_put_contents( PartuzaConfig::get('site_root_avito').'/'.$filename, $json);
      
    }

  public function goOneXml($params) {
        $shop = parent::model('shop');
        $xml = parent::model('xmlavito');
        $shop_id=$params[3];
        $xml->checkCategoryChange($_REQUEST["categoryAvitoValue"],$shop_id);
        $shop->save_shop($shop_id, $_REQUEST);
        $result = $xml->buildXML($shop_id);
        $arr = [];
          if($result) {
             $arr['status'] = "OK";
          }
          else {
            $arr['status'] = "ERROR";
          }
          echo json_encode($arr);
      }
 
}