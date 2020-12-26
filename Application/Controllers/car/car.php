<?php
/**
 * car
 * @author sn
 *
 */

class carController extends baseController {
  private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF");
	
  public function index($params) {
  }

  public function models($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	if (isset($params[3])) {
  		switch ($params[3]) {
 			case 'add':
  				$this->add($params[4]);
  				break;
  			case 'save':
  				$this->save($params[4]);
  				break;
  						
  			case 'get_ajax':
  				$this->get_ajax($params[4]);
  				break;
  		}
  	}
  }
  
  public function get_ajax($marka_id){
  	$model = $this->model('car_model');
  	$models=$model->show(array("marka_id"=>$marka_id));
  	
  	$this->template('/profile/profile_model_ajax.php', array('car_models' => $models));
  }
  
  public function add($id) {
  	if(!isset($id) or !is_numeric($id)){
  		return;
  	}
  		
  	$car = $this->model('car');
  	 
  	//$created = $_SERVER['REQUEST_TIME'];
  	$person_id=$_SESSION['id'];
  	$year = isset($_POST['year']) ? $_POST['year'] : false;
  	$descr = isset($_POST['descr']) ? $_POST['descr'] : false;
  	$complect = isset($_POST['complect']) ? $_POST['complect'] : false;
  	$model_id = isset($_POST['model_id']) ? $_POST['model_id'] : false;
  	$marka_id = isset($_POST['marka_id']) ? $_POST['marka_id'] : false;
  	$isvisible = isset($_POST['isvisible']) ? $_POST['isvisible'] : false;
  
  	$id=$car->add(array(
  			'person_id'=>$id,
  			'year'=>$year,
  			'descr'=>$descr,
  			'complect'=>$complect,
  			'model_id'=>$model_id,
  			'marka_id'=>$marka_id,
  			'isvisible'=>$isvisible,
  	));
  	print $id;
  }

  public function save($params) {
  	$id=$params[3];
    //сохранить
    $car = $this->model('car');
  
    //$created = $_SERVER['REQUEST_TIME'];
    $person_id=$_SESSION['id'];
    $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : false;
    $year = isset($_POST['year']) ? $_POST['year'] : false;
    $descr = isset($_POST['descr']) ? $_POST['descr'] : false;
    $complect = isset($_POST['complect']) ? $_POST['complect'] : false;
    $model_id = isset($_POST['model_id']) ? $_POST['model_id'] : false;
    $marka_id = isset($_POST['marka_id']) ? $_POST['marka_id'] : false;
    $isvisible = isset($_POST['isvisible']) ? $_POST['isvisible'] : false;
 
    //создать
  	if(!($idЮ0) or !is_numeric($id)){
    		$car->add(array(
          'person_id'=>$person_id,
          'year'=>$year,
          'descr'=>$descr,
          'complect'=>$complect,
          'model_id'=>$model_id,
          'marka_id'=>$marka_id,
          'isvisible'=>$isvisible,
      ));
  	} else {
    //сохранить
    	$car->save($car_id, array(
    			'person_id'=>$person_id,
    			'year'=>$year,
    			'descr'=>$descr,
    			'complect'=>$complect,
    			'model_id'=>$model_id,
    			'marka_id'=>$marka_id,
    			'isvisible'=>$isvisible,
    	));

    	print $car_id;
    }
  }
  
  public function photos_inline($params){
  	$id=$params[3];
  	$media = $this->model('medias');
  	
  	$this->template('/profile/profile_car_photos_toadd.php', array(
  			'car_id' => $id,
  			'medias' => $media->get_medias(array("object_id" => $id, "object_name"=>"car" ))
  			));
  }

  public function delete($params) {
  	$id=$params[3];
  	
  	$car = $this->model('car');
  	$car->delete($id);
  
  	return $this->show(array());
  }
  
  public function can_delete($ownerd) {
  	if(in_array($_SESSION['id'], $ownerd)){
  		return true;
  	}  
  	return false;
  }
   
  //прикрепить картинку
  public function photo_upload($params) {
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	$person_id = $_SESSION['id'];
  	if (! isset($params[3]) || ! is_numeric($params[3])) {
  		header("Location: /");
  	}
  	$people = $this->model('people');
  	//$person = $people->get_person_fields($_SESSION['id'], array('uploaded_size'));
  
  	// it's upload file path.
  	$id = $params[3];
  	$tmp_dir = array('/images', '/car', '/'.$id);
  	$dir = '/images/car/'.$id;
  	$file_dir = PartuzaConfig::get('site_root');
  	foreach($tmp_dir as $val) {
  		$file_dir .= $val;
  		if (!file_exists($file_dir)) {
  			if (!@mkdir($file_dir, 0777, true)) {
  				die;
  			}
  		}
  	}
  	$car = $this->model('car');
	$auto = $car->get_car($id);
  	$message = '';
  	$filewebname="1";
  	
  	//сохранить картинку
  	if (!empty($_FILES) and isset($_FILES['Filedata'])) {
  		$tempFile = $_FILES['Filedata']['tmp_name'];
  		$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
  		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
  		$fileParts  = pathinfo($_FILES['Filedata']['name']);
  
  		if (in_array($fileParts['extension'],$this->imageTypes)) {
  			$title = (!empty($_POST['title'])) ? $_POST['title'] : substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
  			$media = $this->model('medias');
  			$media_item = array(
  					//'car_id' => $id,
  					'object_id' => $id,
  					'object_name' =>'car',
  					'owner_id' => $person_id,
  					'mime_type' => '',
  					'title' => $title,
  					//'file_size' => $fileParts['size'],
  					'created' => time(),
  					'last_updated' => time(),
  					'type' => 'IMAGE',
  					'url' => '',
  					'app_id' => 0,
  			);
  			try {
  				$media_id = $media->add_media($media_item);
  			} catch (DBException $e) {
  				echo "die";
  				die();
  			}
  
  			$ext = strtolower($fileParts['extension']);
  			$filename=PartuzaConfig::get('site_root') . $dir . '/' . $media_id . '.' . $ext;
  			// it's a file extention that we accept too (not that means anything really)
  			if (! move_uploaded_file($tempFile, $filename)) {
  				die("no permission to images/people dir, or possible file upload attack, aborting");
  			}
  
  			//уменьшить до максимально допустимого размера
  			$img=new SimpleImage();
  			$img->load($filename);
  			$img->save($filename);
  			$img->resizeAdaptive(PartuzaConfig::get('imageMaxWidth'), PartuzaConfig::get('imageMaxHeight'));
  			$filename_thumbnail600=$dir . '/' . $media_id . '.600x600.' . $ext;
  			$img->save(PartuzaConfig::get('site_root') . $filename_thumbnail600);
  			$img->resizeAdaptive(220, 220);
  			$filename_thumbnail220=$dir . '/' . $media_id . '.220x220.' . $ext;
  			$img->save(PartuzaConfig::get('site_root') . $filename_thumbnail220);
  
  			echo $filename_thumbnail220; //отправить в js имя аватарки 
  
  			// if insert data failed, throw an error.
  			// insert and upload file is success.
  			$media_item = array();
  			
  			$size = GetImageSize($filename);
  			$media_item['width']=$size[0];
  			$media_item['height']=$size[1];
  				
  			$media_item['url'] = $filewebname;
  			$media_item['thumbnail_url'] = $filename_thumbnail220;
  			$media_id = $media->update_media($media_id, $media_item);
  				
  			//$person = $people->literal_set_person_fields($params[3], array('uploaded_size' => "uploaded_size + {$file['size']}"));
  			$media_item['thumbnail_url600']=$filename_thumbnail600;
  			$media_id = $media->update_media($media_id, $media_item);
  		}
  	}
  }

  public function show($params){
  	if (! isset($_SESSION['id'])) {
  		header("Location: /");
  	}
  	
  	if (! isset($params[3]) || ! is_numeric($params[3])) {
  		$person_id = $_SESSION['id'];  		
  	}else{
  		$person_id = $params[3];
  	}
  	 
  	$car = $this->model('car');
  	$cars= $car->show(array("person_id"=>$person_id));
  	 
  	$this->template('/profile/profile_carlist.php', array('cars' => $cars));
  }
  
  //показать форму для добавления авто
  public function get_addform(){
  	if(!isset($_SESSION['id'])){
  		return 0;
  	}
  	
  	$model = $this->model('car_model');
  	$models = $model->show(array());
  	
  	$marka = $this->model('car_marka');
  	$marki = $marka->show(array());
  	 
  	$this->template('/profile/profile_addcar.php', array(
  			'car_model'=>$models,
    		'car_marka'=>$marki));
  }

  
  //показать форму для редактирования авто
  public function get_editform($params){
  	$id=$params[3];
  	if(!isset($_SESSION['id']) or !isset($id)){
  		return 0;
  	}
  	 

  	$car = $this->model('car');
  	$mycar=$car->get_car($id);
  	
  	$model = $this->model('car_model');
  	$models = $model->show(array("marka_id"=>$mycar['marka_id']));
  	 
  	$marka = $this->model('car_marka');
  	$marki = $marka->show(array());
  
  	$this->template('/profile/profile_editcar.php', array(
  			'car'=>$mycar,
  			'car_model'=>$models,
  			'car_marka'=>$marki));
  }

  public function showcars($params) {
  	if (! isset($_SESSION['id']) or !isset($params[3])) {
  		header("Location: /");
  	}
  	$id=$params[3];

  	$car = $this->model('car');
  	$cars= $car->show(array("person_id"=>$id));
  	
  	$people = $this->model('people');
  	$person = $people->get_person($id, true);
  	$activities = $this->model('activities');
  	$is_friend = isset($_SESSION['id']) ? ($_SESSION['id'] == $id ? true : $people->is_friend($id, $_SESSION['id'])) : false;
  	$person_activities = $activities->get_person_activities($id, 10);
  	$friends = $people->get_friends($id);
  	$friend_requests = isset($_SESSION['id']) && $_SESSION['id'] == $id ? $people->get_friend_requests($_SESSION['id']) : array();
  	$apps = $this->model('applications');
  	$applications = $apps->get_person_applications($id);
  	$person_apps = null;
  	if (isset($_SESSION['id']) && $_SESSION['id'] != $id) {
  		$person_apps = $apps->get_person_applications($_SESSION['id']);
  	}
  	
  	$this->template('/profile/profile_usercarlist.php', array('cars' => $cars,
  			'activities' => $person_activities,
  			'applications' => $applications,
  			'person' => $person,
  			'friend_requests' => $friend_requests,
  			'friends' => $friends,
  			'is_friend' => $is_friend, 'is_owner' => isset($_SESSION['id']) ? ($_SESSION['id'] == $id) : false, 
  			'person_apps' => $person_apps  				
  			));
  	 
  }
  
}