<?php
class Controller {

  // Input and output filtering to prevent SQL injection and XSS where required
  public function filter_output($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
  }

  public function filter_input($string) {
    global $db;
    return $db->addslashes($string);
  }

  // These functions wrap the nasty (but fast) global variables and objects
  public function set_modified($timestamp) {
    global $dispatcher;
    $dispatcher->last_modified = max($dispatcher->last_modified, $timestamp);
    
    #online
    $person=$this->model("people");
    $person->i_am_online();
  }

  public function set_content_type($content_type) {
    global $dispatcher;
    $dispatcher->content_type = $content_type;
  }

  public function set_charset($charset) {
    global $dispatcher;
    $dispatcher->charset = $charset;
  }

  public function model($model) {
    include_once PartuzaConfig::get('models_root') . "/$model/$model.php";
    $model = "{$model}Model";
    return new $model();
  }

  public function template($template, $vars = array()) {
    // scope the $vars into local name space
    foreach ($vars as $key => $val) {
      $$key = $val;
    }

    //language
    $this->loadMessages($this->get_cur_lang());
    
    // We also poke the modified time to when this template was changed, so that even
    // for 'static content' the last-modified time is always correct
    if(!PartuzaConfig::get("server_as_api")){
      $this->set_modified(filemtime(PartuzaConfig::get('views_root') . "/$template"));    
      include PartuzaConfig::get('views_root') . "/$template";
    }else{
      echo json_encode($vars);
      return;
      //format json
    }
  }
  
  
  public function get_template($template, $vars = array()) {
  	// scope the $vars into local name space
  	foreach ($vars as $key => $val) {
  		$$key = $val;
  	}
  	
  	//language
  	$this->loadMessages($this->get_cur_lang());
  	 
  	// We also poke the modified time to when this template was changed, so that even
  	// for 'static content' the last-modified time is always correct
  	$this->set_modified(filemtime(PartuzaConfig::get('views_root') . "/$template"));
  	ob_start();
  	include PartuzaConfig::get('views_root') . "/$template";
  	$text=ob_get_contents();
  	ob_end_clean();
  	return $text;
  }
  
  public function get_cur_lang(){
  	if(isset($_SESSION['lang']) and in_array($_SESSION['lang'],PartuzaConfig::get('languages'))){
  		//$_SESSION['lang']=$person['lang'];
  		return $_SESSION['lang'];
  	}
  	$_SESSION['lang']=PartuzaConfig::get('language');
  	//echo $_SESSION['lang'];
  	return $_SESSION['lang']; 
  }
  
  public function get_cur(){  	
  	return $_SESSION['cur']; 
  }
  
  //перевести текст для интерфейса на текущий язык
  static function t($category, $message, $params=null){
 		global $lang_message;
 		
    if(!isset($lang_message[$category][$message]) and isset($this)){ //в лендинге нет $this
  	$this->loadMessages($this->get_cur_lang());
    }

 		//TODO: params
 		if(isset($lang_message[$category][$message])){
 			$text=$lang_message[$category][$message];
 			
 			//apply parameters
 			if(isset($params)){
 				foreach ($params as $param => $value) {
 					$text=preg_replace("/$param/", $value, $text);
 				}
 			}
 			
			return $text;
 		}
 		return "<font color=red>!!!NO TRANSLATION for $message in $category!!!</font>";//TODO:заменить на "" после отладки
  }
  
  public function loadMessages($lang){  	
  	$lang=(!isset($lang) or empty($lang) or $lang=="") ? PartuzaConfig::get('language') : $lang;
        if($lang == 'CN') $lang = 'CH';
        if($lang == 'US') $lang = 'EN';
  	require_once PartuzaConfig::get('i18n_root') . "/" . $lang . "/" . "main-ui.php";
  }
  
  // формат даты: «х часов назад», «х минут назад», «вчера», 
  // если больше суток то дата без времени
  public function formatdate($data){
	$now=time();
	$today=localtime($now);
	$today=$now-$today[0]-$today[1]*60-$today[2]*60*60;
	
	$yestoday=$now-$today[0]-$today[1]*60-$today[2]*60*60 - 24*60*60;
	
	if($data<$yestoday){
		//return strftime('%m/%d/%y '.$this->t('common','in').' %H:%M', $data);
		return strftime('%d.%m.%y', $data);
	}
	$hours=round( ($now-$data)/(60*60) );
	
  	if($data < $today){
		return $this->t('common','yesterday');
	}
	if($hours>=5){
		return $hours." ".$this->t('common','5hours ago');
	}
	if($hours>=2){
		return $hours." ". $this->t('common','2-4hours ago');
	}
	if($hours>=1){
		return $this->t('common','hour ago');
	}
	if($hours<1 and ($now-$data)>60){
		$min = round(($now-$data)/60);
		return $min . " " . $this->t('common','min. ago');
	}
	if(($now-$data)<60){
		return $this->t('common','now');
	}
  }
}