<?php
/**
 * API для 1С
 */

class apiController extends baseController {
  private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF");
  private $fields4Import = array("title", "name", "code", "price", "num", "description", "subtitle", "currency", "isspecial", "visible", "code", "package", "box", "edizm", "name_ru", "name_en", "name_ch", "name_it", "name_es", "isveryspecail");

  public function index($params) {
      //TODO: показать документацию?

  }

  public function getparam($params) {
    echo json_encode(array(
            value => PartuzaConfig::get($_REQUEST['param']), 
          ));
  }

  public function rest($params) {
    //аутенитификация по логину/паролю
    $error = '';
    if (count($_REQUEST)) {
      if (! empty($_REQUEST['login']) && ! empty($_REQUEST['password'])) {
        // registration went ok, set up the session (and cookie)
        if ($this->authenticate($_REQUEST['login'], $_REQUEST['password'])) {
          //$this->redirect();
        } else {
          $error = 'Invalid email / password combination.';
        }
      } else if(!empty($_REQUEST['me']) and $_SESSION['id']){
        // ok, аутентификация прошла
            
      } else {
        $error = 'Please fill in your email and password.';
      }
    }
    if($error){
        echo stripslashes(json_encode(array(
            status => “fail”, 
            error => $error
          )));
        return;
    }

    // магазин
    $shop = $this->model('shop');
    $myshop = $shop->get_myshop($_SESSION['id'], true);
    if(!$myshop['id']){
        echo stripslashes(json_encode(array(
            status => “fail”, 
            error => "user doesn't have shop",
          )));
        return;        
    }
    $shop_id = $myshop['id'];

    $method = $_SERVER['REQUEST_METHOD'];

    $modelname = $params[3];
    $model = $this->model($modelname);
    $data = $model->api($method, $shop_id);
    echo (json_encode($data));#, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT
   
  }
  
}

