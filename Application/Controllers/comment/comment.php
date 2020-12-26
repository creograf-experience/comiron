<?php
/**
 
 */

class commentController extends baseController {
  private $imageTypes=array("JPG","jpg", "JPEG", "jpeg","png","PNG","gif","GIF");
	
  public function index($params) {
  }

  //удалить фотографию
  public function delete_attached_photo($params){
  	$id = $params[3];
  	
  	if(!isset($id) or !is_numeric($id) or !isset($_SESSION['id'])){
  		return;
  	}
  		 
  	$owner_id = $_SESSION['id'];
  	$media = $this->model('medias');
  	$media->delete_media($owner_id, $id);
  	echo "success";  	
  }
  
  public function photos_inline($params){
  	$id=$params[3];
  	$media = $this->model('medias');
  	
  	$this->template('/comment/photos_toadd.php', array(
  			'comment_id' => $id,
  			'medias' => $media->get_medias(array("comment_id" => $id ), "IMAGE", "comment"),
  			'object_name' => $_GET['object_name'],
  			'object_id' => $_GET['object_id'],
  			'id' => $_GET['object_id']));
  }
  
  //показать диалог для добавления фото к комментарию
  public function prepare_attache_photo($params){
  	$id=$params[3];
  	$people = $this->model('people');
  	$comment = $this->model('comment');
  	$this->template('/comment/attache_photo.php', array(
  			'comment_id'=>$id,
  			'person' => $people->get_person($_SESSION['id'], false),
  			'object_name'=>$_GET['object_name'],
  			'object_id'=>$_GET['object_id'],
  			'id'=>$_GET['object_id']));
  }
  
  public function compose() {
  	$people = $this->model('people');
  	$comment = $this->model('comment');
  	
  	$id = $comment->prepare_new_comment($_SESSION['id'], 
  			array('person_id'=>$_SESSION['id'],
  						'status'=>'deleted',
  			  			'object_name'=>$_GET['object_name'], 
  						'object_id'=>$_GET['object_id']
  					));
  	
  	if (!$id) {
  		die('Error preparing_new_comment');
  	}
  		
  	$this->template('/comment/comment_compose.php', array(
  			'comment_id'=>$id,
  			'person' => $people->get_person($_SESSION['id'], false),
  			'object_name'=>$_GET['object_name'], 
  			'object_id'=>$_GET['object_id'],
  			'id'=>$_GET['object_id']));
  }
  
  public function send($params) {
  	if (empty($_POST['object_name']) or empty($_POST['object_id']) or empty($_POST['text'])) return;
  	
  	$comment = $this->model('comment');
    $object = $this->model($_POST['object_name']);
    
    $id=$params[3];
    if(isset($id) and is_numeric($id)){
    	$created = $_SERVER['REQUEST_TIME'];
    	$comment->save($id, array(
    			'object_name'=>$_POST['object_name'],
    			'object_id'=>$_POST['object_id'],
    			'text'=>$_POST['text'],
    			'replyto_id'=>$_POST['replyto_id'],
    			'time'=>$created,
    			'status'=>'new'));
    }else{
    	$results = $comment->add(array(
      		'object_name'=>$_POST['object_name'],
      		'object_id'=>$_POST['object_id'],
      		'text'=>$_POST['text'],
      		'replyto_id'=>$_POST['replyto_id']));
    }
      
    $comment_num = $comment->get_comment_num(array(
      		'object_name'=>$_POST['object_name'],
      		'object_id'=>$_POST['object_id']));

    $object = $this->model($_POST['object_name']);
    $object->save($_POST['object_id'], array("comment_num"=>$comment_num));

    $_GET=$_POST;
  	$_GET['start']=0;
  	$_GET['limit']=100;
  	
    return $this->show($params);
  }
  
  public function show($params) {
  	$_GET['start']=(isset($_GET['start'])?$_GET['start']:0);
  	$_GET['limit']=(isset($_GET['limit'])?$_GET['limit']:10);
  	
  	$comment = $this->model('comment');
  	$results = $comment->get_comments(array(
  			'object_name'=>$_GET['object_name'],
  			'object_id'=>$_GET['object_id'],
  			'limit'=>$_GET['limit'],
  			'start'=>$_GET['start']));
  	
  	$comment_num = $comment->get_comment_num(array(
  			'object_name'=>$_GET['object_name'],
  			'object_id'=>$_GET['object_id']));
  	
  	$this->template('/comment/comment.php', array(
  			'object_name'=>$_GET['object_name'],
  			'object_id'=>$_GET['object_id'],
  			'id'=>$_GET['object_id'],
  			'comment_num'=>$comment_num,
  			'comments'=>$results));
  }

  public function delete($params) {
  	$id=$params[3];
  	
  	$comment = $this->model('comment');
  	$comment->delete($id);
  
  	$comment_num = $comment->get_comment_num(array(
  			'object_name'=>$_GET['object_name'],
  			'object_id'=>$_GET['object_id']));
  
  	$object = $this->model($_GET['object_name']);
  	$object->save($_GET['object_id'], array("comment_num"=>$comment_num));
  
  	//$_GET['start']=0;
  	//$_GET['limit']=100;
  	
  	return $this->show($_GET);
  }
  
  public function can_delete($ownerd) {
  	if(in_array($_SESSION['id'], $ownerd)){
  		return true;
  	}  
  	return false;
  }
  
  //прикрепить файл к комментарию
  public function file_upload($params) {
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
  	$tmp_dir = array('/files', '/comment', '/'.$id);
  	$dir = '/files/comment/'.$id;
  	$file_dir = PartuzaConfig::get('site_root');
  	foreach($tmp_dir as $val) {
  		$file_dir .= $val;
  		if (!file_exists($file_dir)) {
  			if (!@mkdir($file_dir, 0777, true)) {
  				die;
  			}
  		}
  	}
  
  	$comment = $this->model('comment');
  	$com = $comment->get_comment($id);
  
  
  	$message = '';
  	$filewebname="1";
  
  	//сохранить картинку
  			$media_item = array(
  					'comment_id' => $id,
  					'object_id' => $com['object_id'],
  					'object_name' =>$com['object_name'],
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
  	//сохранить картинку
  	if (!empty($_FILES)) {
  			$tempFile = $_FILES['Filedata']['tmp_name'];
  			$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
  			$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
  			$fileParts  = pathinfo($_FILES['Filedata']['name']);
  			
  			//		if (in_array($fileParts['extension'],$this->fileTypes)) {
  			$title = (!empty($_POST['title'])) ? $_POST['title'] : substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
  			$media = $this->model('medias');
  			$media_item = array(
  					'comment_id' => $id,
  					'object_id' => $com['object_id'],
  					'object_name' =>$com['object_name'],
  					'owner_id' => $person_id,
  					'mime_type' => '',
  					'title' => $title,
  					//'file_size' => $fileParts['size'],
  					'created' => time(),
  					'last_updated' => time(),
  					'type' => 'FILE',
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
  				$utils=new Utils();
  				$filewebname=$dir . '/' . $utils->rus2translit($title) . '.' . $ext;
  				$filename=PartuzaConfig::get('site_root') .$filewebname;
  					
  				// it's a file extention that we accept too (not that means anything really)
  				if (! move_uploaded_file($tempFile, $filename)) {
  					die("no permission to images/people dir, or possible file upload attack, aborting");
  				}
  					
  				echo $filewebname;
  			
  				// if insert data failed, throw an error.
  				// insert and upload file is success.
  				$media_item = array();
  				$media_item['url'] = $filewebname;
  				$media_item['thumbnail_url'] = '';
  				$media_item['thumbnail_url600']='';
  				$media_id = $media->update_media($media_id, $media_item);
  	}
  }
  
  //прикрепить картинку к комментарию
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
  	$tmp_dir = array('/images', '/comment', '/'.$id);
  	$dir = '/images/comment/'.$id;
  	$file_dir = PartuzaConfig::get('site_root');
  	foreach($tmp_dir as $val) {
  		$file_dir .= $val;
  		if (!file_exists($file_dir)) {
  			if (!@mkdir($file_dir, 0777, true)) {
  				die;
  			}
  		}
  	}
  
  	$comment = $this->model('comment');
  	$com = $comment->get_comment($id);
  	 
  	  	
  	$message = '';
  	$filewebname="1";
  
  	//сохранить картинку
  	if (!empty($_FILES)) {
  		$tempFile = $_FILES['Filedata']['tmp_name'];
  		$targetPath = PartuzaConfig::get('site_root') . $_REQUEST['folder'] . '/';
  		$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
  		$fileParts  = pathinfo($_FILES['Filedata']['name']);
  
  		if (in_array($fileParts['extension'],$this->imageTypes)) {
  			$title = (!empty($_POST['title'])) ? $_POST['title'] : substr($_FILES['Filedata']['name'], 0, strrpos($_FILES['Filedata']['name'], '.'));
  			$media = $this->model('medias');
  			$media_item = array(
  					'comment_id' => $id,
  					'object_id' => $com['object_id'],
  					'object_name' =>$com['object_name'],
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
}