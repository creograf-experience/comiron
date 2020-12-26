<?php
//регистрация пользователя

/*
 * TODO
 * - field validation
 * - add more fields such as name pre/suffix, etc
 * - link to 'did you forget your password'
 * - Accompanying text to explain what this is, that email/passwd will be your login, etc
 * - bonus: quick ajax check on email once it has been filled in & life feedback
 * - bonus: password strength meter
 */

class registerController extends baseController {

  public function index($params) {
    $error = '';
    if (isset($_SESSION['id'])) {
      header('Location: /');
      die();
    }
    if (count($_POST)) {
      $this->loadMessages($this->get_cur_lang());
      
      // check to see if all required fields are filled in
      //TODO сделать нормальную проверку полей
      $is_error=0;
      $error="";
      if (empty($_POST['register_email']) || empty($_POST['register_password']) || empty($_POST['register_first_name']) || empty($_POST['register_last_name']) || empty($_POST['gender']) || empty($_POST['date_of_birth'])) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_allfields").'<br>';
      }

      if (empty($_POST['register_email']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_email").'<br>';
      }

      if (empty($_POST['register_password']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_password").'<br>';
      }

      if (empty($_POST['register_password2']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_password2").'<br>';
      }

      if ($_POST['register_password2']!=$_POST['register_password'] ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_password_dont_match").'<br>';
      }
      
      if (empty($_POST['register_first_name']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_first_name").'<br>';
      }

      if (empty($_POST['register_last_name']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_last_name").'<br>';
      }

      if (empty($_POST['gender']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_gender").'<br>';
      }

      if (empty($_POST['date_of_birth']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_date_of_birth").'<br>';
      }
      
      $utils=new Utils();
      if (!$utils->is_email($_POST['register_email']) ) {
      	$is_error=1;
      	$error .= $this->t("common","form_error_email_is_no_valid").'<br>';
      }
      
      $captcha=$_POST['ct_captcha'];
      // For ajax captcha check
      if($captcha != md5('captcha_precomplite')) {
        require_once PartuzaConfig::get('site_root') . '/capcha/securimage.php';
        $securimage = new Securimage();
        if ($securimage->check($captcha) == false) {
        	$is_error=1;
        	$error .= $this->t("common","form_error_capcha_is_wrong").'<br>';
        }
      }
      
      if (!$is_error) {
        // check availability of the email addr used
        $register = $this->model('register');
        
        
        $date_of_birth = isset($_POST['date_of_birth']) ? trim(strip_tags($_POST['date_of_birth'])) : '';
        preg_match("/(\d+)\.(\d+)\.(\d+)/", $date_of_birth, $res);
        if(preg_match("/(\d+)\.(\d+)\.(\d+)/", $date_of_birth, $res)) {
            $_POST['date_of_birth']=mktime(0, 0, 1, $res[2], $res[1], $res[3]);
        }
        //$_POST['date_of_birth'] = mktime(0, 0, 1, $_POST['date_of_birth_month'], $_POST['date_of_birth_day'], $_POST['date_of_birth_year']);
        
        try {
          // attempt to register this person, any error in registration will cause an exception
          // $activation_code=$register->register($_POST);
          $new_person = $register->register($_POST);
          
          // registration went ok, set up the session (and cookie)
          $this->authenticate($_POST['register_email'], $_POST['register_password']);
          //$_SESSION['lang']=$_POST['country'];
          $_SESSION['lang']=PartuzaConfig::get('language');
          
          
          
          //отправить письмо для подтверждения email
          $message=$this->get_template("/register/mail/validate_email.php",
          		array("activation_code"=>$new_person['activation_code'],
          				"last_name"=>$_POST['register_last_name'],
          				"first_name"=>$_POST['register_first_name'],
          				"email"=>$_POST['register_email'],
          		));
          
          global $mail;
          $is_send = $mail->send_mail(array(
          		"from"=>PartuzaConfig::get('mail_from'),
          		"to"=>$_POST['register_email'],
          		"title"=>$this->t("common","Email confirmation"),
          		"body"=>$message
          ));
          
          if(!$is_send){echo "error: ".var_dump($is_send);}
          $this->adddefaultdata($_SESSION['id']);
          
          // and finally, redirect the user to his profile edit page
          header("Location: /profile/edit");
          
          // don't continue output, all we want is a redirection
          //die();
        } catch (Exception $e) {
          // something went wrong with the registration
          $error = $e->getMessage();
        }
        
      }
    }

    
    //список стран, к которым может относиться контент
    $country_content = $this->model('country_content');
    
    if(!$error){
    	$error="OK";
    }
    $this->template('register/result.php', array('error' => $error));
    /*$this->template('register/register.php', 
    		array('error' => $error,
    			  'countries'=>$country_content->get_countries($this->get_cur_lang())
    		));*/
  }
  
  //добавить информацию по-умолчанию для нового пользователя
  public function adddefaultdata($person_id){
  	$people = $this->model('people');
  	$person=$people->get_person($person_id,true);
        
  	//$country = $person['country_content_code2'];
        $country = $person['lang'];
  	$presscenters=PartuzaConfig::get('presscenters');
  	//$presscenter_id=$presscenters[$country];
        if(array_key_exists($country, $presscenters))
            $presscenter_id=$presscenters[$country];
        else
            $presscenter_id=2;
  	//echo "|".$presscenter_id;
  	
  	//1. add press center as a friend
  	$people->add_friend($person_id,$presscenter_id);
  	  
  	//2. add message from press center
  	$this->loadMessages($country);
  	 
  	$messages = $this->model('messages');
  	$body=$this->t("profile", 'Message text for new user');
  	$subject=$this->t("profile", 'Message title for new user');
  	$messages->send_message($presscenter_id, $person_id, $subject, $body);
  	
  	//3. add news from
  	$news=$this->t("profile", 'News text for new user');
  	$anons=$this->t("profile", 'News anons for new user');
  	$messages->send_news($person_id, array('body'=>$news, 'anons'=>$anons));
  	
  }
}