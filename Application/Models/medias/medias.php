<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

class mediasModel extends Model {
	protected $perpage="20";
	protected $table="media_items";
	
	/*protected $min_height=130;//110
	protected $max_height=215;
	protected $max_width=530;//565
	protected $width_between_images=4;*/
	protected $sizes=array(
			"comment"=>array(
					'min_height'=>90,
					'max_height'=>215,
					'max_width'=>530,
					'width_between_images'=>4,
			),
			"messages"=>array(
					'min_height'=>50,
					'max_height'=>130,
					'max_width'=>540,
					'width_between_images'=>4,
			),
			"news"=>array(
					'min_height'=>130,
					'max_height'=>215,
					'max_width'=>565,
					'width_between_images'=>4,
			),
			"default"=>array(
					'min_height'=>130,
					'max_height'=>215,
					'max_width'=>565,
					'width_between_images'=>4,
			),
	);
	
	// media_items table supproted fields;
	public $supported_fields = array('id','activity_id','album_id','owner_id','mime_type','file_size',
    'duration','created','last_updated','language','address_id','num_comments','num_views',
    'num_votes','rating','start_time','title','description','tagged_people','tags',
    'thumbnail_url','type','url','app_id',
	'thumbnail_url220', 'thumbnail_url600',
	'message_id',
	'comment_id','object_id','object_name', 'width', 'height');

  public function add_media($media) {
    global $db;
    foreach ($media as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        if (is_null($val)) {
          $adds[] = "`" . $db->addslashes($key) . "` = null";
        } else {
          $adds[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
        }
      }
    }
    if (count($adds)) {
      $query = "insert into media_items set " . implode(', ', $adds);
      $db->query($query);
      return $db->insert_id();
    }
  }
  
  //копирует $media_id заменяя данные из $updates
  public function copy($media_id, $updates) {
  	global $db;
  	$media_id = intval($media_id);
  	$fields=$this->supported_fields;
  	unset($fields[0]); //убрать id
  	
  	
  	foreach ($updates as $key => $val) {
  		if (in_array($key, $this->supported_fields)) {
  			if (is_null($val)) {
  				$adds[] = "`" . $db->addslashes($key) . "` = null";
  			} else {
  				$adds[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
  			}
  		}
  	}
  	
  	$db->query("insert into ".$this->table."(`".implode("`, `", $fields)."`) select `".implode("`, `", $fields)."` from ".$this->table." where id=$media_id");
  	$newid=$db->insert_id();
  	$db->query("update ".$this->table." set " . implode(', ', $adds)." where id=$newid");
  	return $newid;
  }
  
  public function get_media($media_id) {
    global $db;
    $media_id = $db->addslashes($media_id);
    $query = "
      select
        media_items.id,    
        media_items.activity_id,
        media_items.album_id,
        media_items.owner_id,
        media_items.mime_type,
        media_items.file_size,
        media_items.duration,
        media_items.created,
        media_items.last_updated,
        media_items.language,
        media_items.address_id,
        media_items.num_comments,
        media_items.num_views,
        media_items.num_votes,
        media_items.rating,
        media_items.start_time,
        media_items.title,
        media_items.description,
        media_items.tagged_people,
        media_items.tags,
        media_items.thumbnail_url,
        media_items.thumbnail_url220,
        media_items.thumbnail_url600,
        media_items.type,
        media_items.url,
        media_items.app_id,
        media_items.message_id,
        media_items.object_id,
        media_items.object_name
      from
        media_items
      where
        media_items.id = '$media_id'";
    $res = $db->query($query);
    $ret = $db->fetch_array($res, MYSQLI_ASSOC);
    return $ret;
  }
  
  public function get_medias_pages($params) {
  	global $db;
    $owner_id = isset($params['owner_id']) ? $db->addslashes($params['owner_id']) : "";
    $album_id = isset($params['album_id']) ? $db->addslashes($params['album_id']) : "";
    $message_id = isset($params['message_id']) ? $db->addslashes($params['message_id']) : "";
    $comment_id = isset($params['comment_id']) ? $db->addslashes($params['comment_id']) : "";
    $object_id = isset($params['object_id']) ? $db->addslashes($params['object_id']) : "";
    $object_name = isset($params['object_name']) ? $db->addslashes($params['object_name']) : "";
    $curpage=isset($params['curpage']) ? $params['curpage'] : 0;
    
    $where = "1 ";
    $where .= is_numeric($album_id) ? " and media_items.album_id = '$album_id'" : "";
    $where .= is_numeric($message_id) ? " and media_items.message_id = '$message_id'" : "";
    $where .= is_numeric($comment_id) ? " and media_items.comment_id = '$comment_id'" : "";
    $where .= is_numeric($object_id) ? " and media_items.object_id = '$object_id'" : "";
    $where .= is_numeric($object_name) ? " and media_items.object_name = '$object_name'" : "";
    $where .= ((!is_numeric($album_id) or !is_numeric($message_id)) and is_numeric($owner_id)) ? " and media_items.owner_id = '$owner_id'" : "";
    
  	$query = "select count(id) as number_of_media from	".$this->table." where $where and media_items.type = 'IMAGE'";
  	$res = $db->query($query);
  	$num = $db->fetch_array($res, MYSQLI_ASSOC);
  		
  	$total = (int)( ( $num['number_of_media'] - 1 ) / $this->perpage ) + 1;
  	$next=false;
  	if($total>$curpage+1){
  	$next=$curpage+1;
  	}
  	return array("nextpage"=>$next,
  	"totalpages"=>$total);
  }
  
  //$owner_id, $album_id, $start = false, $count = false
  //+$message_id
  public function get_medias($params, $type="IMAGE", $object="default") {
    global $db;
    $owner_id = isset($params['owner_id']) ? $db->addslashes($params['owner_id']) : "";
    $album_id = isset($params['album_id']) ? $db->addslashes($params['album_id']) : "";
    $message_id = isset($params['message_id']) ? $db->addslashes($params['message_id']) : "";
    $comment_id = isset($params['comment_id']) ? $db->addslashes($params['comment_id']) : "";
    $object_id = isset($params['object_id']) ? $db->addslashes($params['object_id']) : "";
    $object_name = isset($params['object_name']) ? $db->addslashes($params['object_name']) : "";
    #$start = isset($params['start']) ? $db->addslashes($params['start']) : "";
    #$count = isset($params['count']) ? $db->addslashes($params['count']) : "";
    #if (! $start) $start = '0';
    #if (! $count) $count = $this->perpage;
    $curpage=isset($params['curpage']) ? $params['curpage'] : 0;
    $start = $curpage*$this->perpage;
    $limit = "$start, ".$this->perpage;
    
    $where = "1 ";
    $where .= is_numeric($album_id) ? " and media_items.album_id = '$album_id'" : "";
    $where .= is_numeric($message_id) ? " and media_items.message_id = '$message_id'" : "";
    $where .= is_numeric($comment_id) ? " and media_items.comment_id = '$comment_id'" : "";
    $where .= is_numeric($object_id) ? " and media_items.object_id = '$object_id'" : "";
    $where .= is_numeric($object_name) ? " and media_items.object_name = '$object_name'" : "";
    $where .= ((!is_numeric($album_id) or !is_numeric($message_id)) and is_numeric($owner_id)) ? " and media_items.owner_id = '$owner_id'" : "";
    
    $order = "media_items.id asc";
    global $db;
    $query = "
      select
        SQL_CALC_FOUND_ROWS
        media_items.id,    
        media_items.activity_id,
        media_items.album_id,
        media_items.owner_id,
        media_items.mime_type,
        media_items.file_size,
        media_items.duration,
        media_items.created,
        media_items.last_updated,
        media_items.language,
        media_items.address_id,
        media_items.num_comments,
        media_items.num_views,
        media_items.num_votes,
        media_items.rating,
        media_items.start_time,
        media_items.title,
        media_items.description,
        media_items.tagged_people,
        media_items.tags,
        media_items.thumbnail_url,
        media_items.thumbnail_url220,
        media_items.thumbnail_url600,
        media_items.type,
        media_items.url,
        media_items.app_id,
        media_items.message_id,
        media_items.object_id,
        media_items.object_name,
        media_items.width,
        media_items.height
        	from
        media_items
      where
        $where 
        and media_items.type = '".$type."'
      order by
        $order
      limit
        $limit";

    $res = $db->query($query);
    $cres = $db->query('SELECT FOUND_ROWS();');
    $ret = array();
    while ($media = $db->fetch_array($res, MYSQLI_ASSOC)) {
    	$media['awidth']=$media['width'];
    	$media['aheight']=$media['height'];
      	$ret[] = $media;
    }
    $sizes=$this->get_adaptivesizes($ret,$object);
    $ret=$sizes['medias'];
    $firstline=$sizes['firstline'];
    $rows = $db->fetch_array($cres, MYSQLI_NUM);
    $ret['found_rows'] = $rows[0];
    
    $firstline['found_rows']=count($firstline);
    $ret['firstline'] = $firstline;
    return $ret;
  }

  public function update_media($media_id, $media) {
    global $db;
    $media_id = $db->addslashes($media_id);
    foreach ($media as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        if (is_null($val)) {
          $updates[] = "`" . $db->addslashes($key) . "` = null";
        } else {
          $updates[] = "`" . $db->addslashes($key) . "` = '" . $db->addslashes($val) . "'";
        }
      }
    }
    if (count($updates)) {
      $query = "update media_items set " . implode(', ', $updates) . " where id = '$media_id'";
      $db->query($query);
      return $media_id;
    }
  }

  /*
   * update media table using literal word, so do not need to escape update code.
   * for example update media_items set num_media = num_media + 1;
   */
  public function literal_update_media($media_id, $media) {
    global $db;
    $media_id = $db->addslashes($media_id);
    foreach ($media as $key => $val) {
      if (in_array($key, $this->supported_fields)) {
        $updates[] = "`" . $db->addslashes($key) . "` = $val";
      }
    }
    if (count($updates)) {
      $query = "update media_items set " . implode(', ', $updates) . " where id = '$media_id'";
      $db->query($query);
      return $media_id;
    }
  }

  public function delete_media($owner_id, $media_id) {
    global $db;
    $query = "delete from media_items where owner_id = '" . $db->addslashes($owner_id) . 
      "' and id = '" . $db->addslashes($media_id) ."'";
    
    //TODO: удалить файлы с сервера
    
    $db->query($query);
  }

  /**
   * get media in album before $media_id ;
   */
  public function get_media_previous($album_id, $media_id) {
    global $db;
    $query = "select * from media_items where album_id = '" . $db->addslashes($album_id) . 
      "' and id > '" . $db->addslashes($media_id) . "' order by id desc limit 1";
    $res = $db->query($query);
    $ret = $db->fetch_array($res, MYSQLI_ASSOC);
    return $ret;
  }

  /**
   * get media in album next to $media_id ;
   */
  public function get_media_next($album_id, $media_id) {
    global $db;
    $query = "select * from media_items where album_id = '" . $db->addslashes($album_id) . 
      "' and id < '" . $db->addslashes($media_id) . "' order by id desc limit 1";
    $res = $db->query($query);
    $ret = $db->fetch_array($res, MYSQLI_ASSOC);
    return $ret;
  }
  
  /**
   * get media in album, results are previous one, current one and next one. 
   */
  public function get_media_has_order($album_id, $media_id) {
    global $db;
    $ret = array();
    // get previous one, whose id is less than current one
    $query = "select SQL_CALC_FOUND_ROWS * from media_items where album_id = '" . $db->addslashes($album_id) .
      "' and id < '" . $db->addslashes($media_id) . "' order by id desc limit 1";
    $res = $db->query($query);
    $row = $db->fetch_array($res, MYSQLI_ASSOC);
    if (!empty($row)) {
      $ret[] = $row;
    }
    $cres = $db->query('SELECT FOUND_ROWS();');
    $rows = $db->fetch_array($cres, MYSQLI_NUM);
    $found_rows = $rows[0];
    
    // get current and next one
    $query = "select SQL_CALC_FOUND_ROWS * from media_items where album_id = '" . $db->addslashes($album_id) .
      "' and id >= '" . $db->addslashes($media_id) . "' order by id asc limit 2";
    $res = $db->query($query);
    $cres = $db->query('SELECT FOUND_ROWS();');
    while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {
      $ret[] = $row;
    }
    $rows = $db->fetch_array($cres, MYSQLI_NUM);
    $ret['found_rows'] = $rows[0] + $found_rows;
    $ret['item_order'] = 1 + $found_rows;
    return $ret;
  }
  
  protected function get_adaptivesizes($medias=array(), $object) {
  	$images=array();
  	foreach($medias as $i=>$m){
  		if($m['type']=="IMAGE" and $m['aheight']>0){
  			$images[]=$m;
  		}
  	}
  	if(empty($images)){
  		return array('medias'=>$medias, 'firstline'=>array());
  	}
  	
 	 
  	$medias=$images;
  	$medias=$this->resize2min($medias, $object);
  	
  	$sumwidth=0;
  	$num=count($medias);
  	$i=0;
  	$indexes=array();
  	$isfirstline=true;//для новостей надо показывать только первую полосу
  	$firstline=array();
  	while($i<$num){
  		if($sumwidth+$medias[$i]['awidth'] > $this->sizes[$object]["max_width"]){
  			$medias=$this->resize2fitwidth($medias, $indexes, ($sumwidth - $this->sizes[$object]["width_between_images"]),$object);
  			if($isfirstline){
  				foreach($indexes as $index){
  					$firstline[]=$medias[$index];
  				}
  			}
  			$indexes=array();
  			$sumwidth=$medias[$i]['awidth']+$this->sizes[$object]["width_between_images"];
  			$indexes[]=$i;
  			$i++;
  			$isfirstline=false;
  		}else{
  			$sumwidth+=$medias[$i]['awidth']+$this->sizes[$object]["width_between_images"];
  			$indexes[]=$i;
  			$i++;
  		}
  	}
  	if(!empty($indexes)){
  		$medias=$this->resize2fitwidth($medias, $indexes, ($sumwidth - $this->sizes[$object]["width_between_images"]),$object);
  		if($isfirstline){
  			foreach($indexes as $index){
  				$firstline[]=$medias[$index];
  			}
  		}  		
  	}
  	//$medias["firstline"]=$firstline;
  	return array("medias"=>$medias, "firstline"=>$firstline);
  }

  protected function resize2min($medias,$object) {
  	if(empty($medias)) return array();
  	foreach($medias as $i=>$m){
  		$w=$m['awidth'];
  		$h=$m['aheight'];
  		$newh=$this->sizes[$object]["min_height"];
  		$neww=round($w*$this->sizes[$object]["min_height"]/$h);
  		if($neww>$this->sizes[$object]["max_width"]){
  			$neww=$this->sizes[$object]["max_width"];
  		}
  		$medias[$i]['awidth']=$neww;
  		$medias[$i]['aheight']=$newh;
  	}
  	return $medias;
  }
  
  //растянуть картинки на ширину
  protected function resize2fitwidth($medias, $indexes, $sumwidth, $object) {
  	if(empty($medias)) return array();
  	if(empty($indexes)) return array();
  	if(!$sumwidth) return array();
  	
  	
  	$spaces=(count($indexes)-1)*$this->sizes[$object]["width_between_images"];
  	$procent2scale=($this->sizes[$object]["max_width"]-$spaces) / ($sumwidth-$spaces);//
  	//высота общая для всех
  	$height=floor($procent2scale*$medias[$indexes[0]]['aheight']);
  	if($height>$this->sizes[$object]["max_height"]){
  		$procent2scale=$this->sizes[$object]["max_height"] / $medias[$indexes[0]]['aheight'];
  		$height=$this->sizes[$object]["max_height"];
  	}
  	
  	foreach($indexes as $i=>$index){
  		$medias[$index]['awidth']=round($procent2scale*$medias[$index]['awidth']);
  		$medias[$index]['aheight']=$height;
  	}
  	return $medias;
  }
}
