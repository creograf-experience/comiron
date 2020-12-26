<?php
/**
 * comments
 * @author sn
 *
 */

class commentModel extends Model {
//  public $cachable = array('get_comments');
  public $supported_fields = array('id', 'person_id', 'time', 'object_id', 'object_name', 'replyto_id','text','status');
  public $supported_objects = array('news','message','item','photo','shop');
  private $table="`comment`";
  
  //добавить пустой комментарий, чтобы к нему можно было прикреплять картинки
  public function prepare_new_comment($id, $params) {
    global $db;
    $id = $db->addslashes($id); //?убрать
    $fields=false;
    $values=false;
     
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        $fields[] = $key;
        if (is_null($val)) {
          $values[] = 'null';
        } else {
          $values[] = "'" . $db->addslashes($val) . "'";
        }
      }
    }
  
    if($values){
      $query = "insert into ".$this->table."(`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
      $db->query($query);
      return $db->insert_id();
    }
  }
  
  //добавить
  public function add($params){
    global $db;
    if(!isset($params['person_id'])){
      $params['person_id'] = $_SESSION['id'];
    }
    $params['status'] = 'new';
    $params['time'] = $_SERVER['REQUEST_TIME'];
    
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        $keys[]=$db->addslashes($key);
        if (is_null($val)) {
          $values[] = "null";
        } else {
          $values[] = "'" . $db->addslashes($val) . "'";
        }
      }
    }
  
    $query = "insert into ".$this->table." (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);
    $id=$db->insert_id();
  
    return $id;
  }
  
  //сохранить
  public function save($id, $params){
    global $db;
    $id = $db->addslashes($id);
    $update=false;
  
    foreach ($params as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        if (is_null($val)) {
          $update[] = $db->addslashes($key)." = null";
        } else {
          $update[] = "`".$db->addslashes($key)."` = '" . $db->addslashes($val) . "'";
        }
      }
    }
  
    if($update){
      $query = "update ".$this->table." set " . implode(', ', $update) . " where id=$id";
      $db->query($query);
    }
  }
  
  //подготовить список
  public function load_get_comments($params){
    global $db;
    $object_id=(isset($params['object_id'])?$params['object_id']:0);
    $object_name=(isset($params['object_name'])?$params['object_name']:0);
    //$details=(isset($params['details'])?$params['details']:false);
    $filter=(isset($params['filter'])?$params['filter']:false);
    $limit=(isset($params['limit'])?$params['limit']:1);
    $start=(isset($params['start'])?$params['start']:0);
    $allpages=(isset($params['allpages'])?$params['allpages']:0);
    $orderby=(isset($params['orderby'])?$params['orderby']:"time");
    
  $res = $db->query("select * from ".$this->table." where status<>'deleted' "
        .(($filter)?" $filter ":"")
        ." and object_id=$object_id "
        ." and object_name='$object_name' "
      ." order by ".$orderby
      .((!$allpages)?" limit $start, $limit":""));
    
    if (! $db->num_rows($res)) {
      return null;
    }

    $people=$this->get_model("people");
    $media=$this->get_model("medias");
    $object=$this->get_model($object_name);
  $owners=$object->get_owners($object_id);
    $comments=array();
    
    while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['id']=$data['object_id'];
      $data['person'] = $people->get_person_info($data['person_id']);
      $data['medias'] = $media->get_medias(array("comment_id" => $data['id']), "IMAGE", "comment");
      $data['files'] = $media->get_medias(array("comment_id" => $data['id']), "FILE");
      
      //есть ли права на удаление?
      $data['can_delete']=$this->can_delete(array($data['person_id'], $owners));
      
      $comments[]=$data;
    }
    
    return $comments;
  }
  
  //показать
  public function load_get_comment($id, $details=false){
    global $db;
    $res = $db->query("select * from ".$this->table." where id=$id");
    if (! $db->num_rows($res)) {
      return null;
    }
    if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
      //$data['name']=$data['name_en'];
  
      if($details){
//        ...
        $data['medias'] = $media->get_medias(array("comment_id" => $data['id']), "IMAGE", "comment");
        $data['files'] = $media->get_medias(array("comment_id" => $data['id']), "FILE");          
      }
      return $data;
    }
  }
  
  
  //кол-во
  public function get_comment_num($params){
    global $db;
    $params['object_name'] = $db->addslashes($params['object_name']);
  
    $res = $db->query("select count(id) as num from ".$this->table." where object_id=".$params['object_id']." and object_name='".$params['object_name']."' and status<>'deleted'");
  
    if (! $db->num_rows($res)) {
      return 0;
    }
    if($data = $res->fetch_array(MYSQLI_ASSOC)) {     
      return $data['num'];
    }
    return 0;
  }
 
  public function delete($id){
    global $db;

    //проверка прав на удаление
    $data=$this->get_comment($id);
    if(!isset($data['object_id']) || !isset($data['object_name'])){
      return;
    }
    
    $object=$this->get_model($data['object_name']);    
    $owners=$object->get_owners($data['object_id']);
    if(!$this->can_delete(array($data['person_id'], $owners))) return;
    
    $res = $db->query("delete from ".$this->table." where id=".$id);
    return null;
  }

  
  public function can_delete($ownerd) {
    if(in_array($_SESSION['id'], $ownerd)){
      return true;
    }
    return false;
  }
  
  //вызывается при удалении объекта, чтобы удалить его лайки
  public function delete_object($params){
    global $db;
    $params['object_name'] = $db->addslashes($params['object_name']);
    $res = $db->query("delete from likes where object_id=".$params['object_id']." and object_name=".$params['object_name']);
    return null;
  }
  
  
}
