<?php
/**
 */

class articlesModel extends Model {
  public $cachable = array('get_articles', 'get_article');
  public $supported_fields = array('id','name','article_id','visible','ordr','shop_id','txt');

  
  //подготовить список 
  public function load_get_articles($shop_id=0, $group_id=0, $details=false){
  	global $db;
  	$res = $db->query("select * from `article` where shop_id=$shop_id and article_id=$group_id and visible order by ordr");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	$groups=array();
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		if($details){
  			$data['subs']=$this->get_articles($shop_id, $data['id'], $details);
  		}
  		$groups[]=$data;  		
  	}
  	return $groups;
  }

  //подготовить группу
  public function load_get_article($id, $details=false){
  	global $db;
  	$res = $db->query("select * from `article` where id=$id");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
  	if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		//$data['name']=$data['name_en'];
  		$data['txt_html'] = preg_replace("/\s*\r?\n/", "<br />", $data['txt']);
  		
  		if($details){
  			$data['comment_num']=0;
  			$data['likes_num']=0;
  			$data['subs']=$this->get_articles($data['shop_id'], $data['id'], $details);
  		}
  		return $data;
  	}
  }
  
  //добавить группу
  public function add($shop_id, $params){
    global $db;
    $shop_id = $db->addslashes($shop_id);
    
    $keys[]="shop_id";
    $values[]=$shop_id;

    $keys[]="visible";
    $values[]=1;

    $keys[]="ordr";
    $res=$db->query("select max(ordr) as max_ordr from `article` where shop_id=$shop_id" );
    $max_ordr = $res->fetch_array(MYSQLI_ASSOC);
    $values[]=1+$max_ordr['max_ordr'];
    
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
    
    $query = "insert into `article` (" . implode(', ', $keys) . ") values(".implode(", ", $values).")";
    $db->query($query);
    return $db->insert_id();
  }
  
  //сохранить группу
  public function save($id, $params){
  	global $db;
  	$id = $db->addslashes($id);
  
  	foreach ($params as $key => $val) {
  		if (in_array($key, $this->supported_fields)) {
			if (is_null($val)) {
				$update[] = $db->addslashes($key)." = null";
  			} else {
  				$update[] = $db->addslashes($key)." = '" . $db->addslashes($val) . "'";
  			}
  		}
  	}
  	
  	if($update){
  		$query = "update `article` set " . implode(', ', $update) . " where id=$id";
  		$db->query($query);
  	}
  }
  
/*  
  public function set_thumbnail($id, $url) {
  	global $db;
  	$this->invalidate_dependency('group', $id);
  	$id = $db->addslashes($id);
  	$url = $db->addslashes($url);
  	$db->query("update `group` set thumbnail_url = '$url' where id = $id");
  }
*/
  //удалить группу
  public function delete($id){
  	global $db;
  	$id = $db->addslashes($id);
  	$res=$db->query("delete from `article` where id=$id" );
  	$this->delete_by_article_id($id);
  }

  //удалить подгруппы
  public function delete_by_article_id($group_id){
  	global $db;
  	$group_id = $db->addslashes($group_id);

  	$res=$db->query("select id from `article` where article_id=$group_id" );
  	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$this->delete($data['id']);
  	}  	  	
  }
}
