<?php
class messagesModel extends dataModel {
	public $supported_fields = array('id', 'from', 'to', 'title', 'body', 'app_id', 'body_id', 'title_id', 'in_reply_to', 'replies', 'status', 'type','recipients','collection_ids','urls','updated','to_deleted','from_deleted','created','shop_id','fromshop','likes_num','shared_num','anons','comment_num');//'thumbnail_url',
	protected $table="messages";
	protected $perpage="5";
	

	public function get_im_pages($userId1, $userId2, $curpage=0) {
		global $db;
		$userId1 = $db->addslashes($userId1);
		$userId2 = $db->addslashes($userId2);
		
		if(!is_numeric($userId2) or !is_numeric($userId2)){
			return array("nextpage"=>0,	"totalpages"=>0);
		}
			
			
		$query = "select count(messages.id) as number_of_messages from	messages where 
				((`to` = $userId1 and `from` = $userId2 and to_deleted = 'no') 
				or (`to` = $userId2 and `from` = $userId1 and from_deleted = 'no')) 
				and status<>'deleted' and shop_id is null";
		 
		$res = $db->query($query);
		$num = $db->fetch_array($res, MYSQLI_ASSOC);
		 
		$total = (int)( ( $num['number_of_messages'] - 1 ) / $this->perpage ) + 1;
		$next=false;
		if($total>$curpage+1){
			$next=$curpage+1;
		}
		return array("nextpage"=>$next,
				"totalpages"=>$total);
	}
        
	public function get_im($userId1,$userId2, $curpage=0) {
		global $db;
		$userId1 = $db->addslashes($userId1);
		$userId2 = $db->addslashes($userId2);
	
		$start = $curpage*$this->perpage;
		$limit = "$start, ".$this->perpage;
		$result = array();
	
		$media=$this->get_model("medias");
		$people = $this->get_model('people');
		$result['persons'][$userId1] = $people->get_person_info($userId1);
		$result['persons'][$userId2] = $people->get_person_info($userId2);
	
		$query = "select id, `from`, `to`, title, body, created, status from ".$this->table." where
		((`to` = $userId1 and `from` = $userId2 and to_deleted = 'no')
		or (`to` = $userId2 and `from` = $userId1 and from_deleted = 'no'))
		and status<>'deleted'
                and shop_id is null
		order by id desc
		limit $limit";
		
		$res = $db->query($query);
		$ret = array();
		while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
			$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "messages");
			$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
			$ret[] = $message;
		}
		$result['im']=$ret;
	
		return $result;
	}

	public function get_im_period($userId1,$userId2, $period=false) {
		global $db;
		$userId1 = $db->addslashes($userId1);
		$userId2 = $db->addslashes($userId2);
		$result = array();
	
		$media=$this->get_model("medias");
		$people = $this->get_model('people');
		$result['persons'][$userId1] = $people->get_person_info($userId1);
		$result['persons'][$userId2] = $people->get_person_info($userId2);
		
		// [tm_sec] => 17 [tm_min] => 17 [tm_hour] => 1 [tm_mday] => 30 [tm_mon] => 10 [tm_year] => 113 [tm_wday] => 6 [tm_yday] => 333 [tm_isdst] => 0
                
		$now=time();
		$i_period=localtime($now);
		$i_period=$now-$i_period[0]-$i_period[1]*60-$i_period[2]*60*60;
		if($period=="yesterday"){
			$i_period=$i_period - 24*60*60;
                        $created_where = " and created > $i_period";
		}
		else if($period=="week"){
			$i_period=$i_period - 7*24*60*60;
                        $created_where = " and created > $i_period";
		}
		else if($period=="month"){
			$i_period=$i_period - 30*24*60*60;
                        $created_where = " and created > $i_period";
		}
		else if($period=="3month"){
			$i_period=$i_period - 91*24*60*60;
                        $created_where = " and created > $i_period";
		}
                
                if($period != 0) {
                    $query = "select id, `from`, `to`, fromshop, title, body, created, status from ".$this->table." where
                    ((`to` = $userId1 and `from` = $userId2 and to_deleted = 'no' and shop_id is null)
                    or (`to` = $userId2 and `from` = $userId1 and from_deleted = 'no' and shop_id is null))
                    and status<>'deleted'
                    ".$created_where."
                    order by id desc";
                } else  {
                    $query = "select id, `from`, `to`, fromshop, title, body, created, status from ".$this->table." where
                    ((`to` = $userId1 and `from` = $userId2 and to_deleted = 'no' and shop_id is null)
                    or (`to` = $userId2 and `from` = $userId1 and from_deleted = 'no' and shop_id is null))
                    and status<>'deleted'
                    order by id desc";
                }

		$res = $db->query($query);
		$ret = array();
		while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
			$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "messages");
			$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
			$ret[] = $message;
		}
		$result['im']=$ret;
	
		return $result;
	}
        
        public function get_im_period_shop($userId1,$userId2,$shop_id,$period=false) {
		global $db;
		$userId1 = $db->addslashes($userId1);
		$userId2 = $db->addslashes($userId2);
		$result = array();
	
		$media=$this->get_model("medias");
		$people = $this->get_model('people');
                $shop = $this->get_model("shop");
                $shop_info = $shop->get_name_pic_shop($shop_id);
                //print_r($shop_info);
		$result['persons'][$userId1] = $people->get_person_info($userId1);
		$result['persons'][$userId2] = $people->get_person_info($userId2);
		
                
		// [tm_sec] => 17 [tm_min] => 17 [tm_hour] => 1 [tm_mday] => 30 [tm_mon] => 10 [tm_year] => 113 [tm_wday] => 6 [tm_yday] => 333 [tm_isdst] => 0
                
		$now=time();
		$i_period=localtime($now);
		$i_period=$now-$i_period[0]-$i_period[1]*60-$i_period[2]*60*60;
		if($period=="yesterday"){
			$i_period=$i_period - 24*60*60;
                        $created_where = " and created > $i_period";
		}
		else if($period=="week"){
			$i_period=$i_period - 7*24*60*60;
                        $created_where = " and created > $i_period";
		}
		else if($period=="month"){
			$i_period=$i_period - 30*24*60*60;
                        $created_where = " and created > $i_period";
		}
		else if($period=="3month"){
			$i_period=$i_period - 91*24*60*60;
                        $created_where = " and created > $i_period";
		}
                
                if($period != 0) {
                    $query = "select id, `from`, `to`, fromshop, title, body, created, status from ".$this->table." where
                    ((`to` = $userId1 and `from` = $userId2 and to_deleted = 'no' and shop_id = ".$shop_id.")
                    or (`to` = $userId2 and `from` = $userId1 and from_deleted = 'no' and shop_id = ".$shop_id."))
                    and status<>'deleted'
                    ".$created_where."
                    order by id desc";
                } else  {
                    $query = "select id, `from`, `to`, fromshop, title, body, created, status from ".$this->table." where
                    ((`to` = $userId1 and `from` = $userId2 and to_deleted = 'no' and shop_id = ".$shop_id.")
                    or (`to` = $userId2 and `from` = $userId1 and from_deleted = 'no' and shop_id = ".$shop_id."))
                    and status<>'deleted'
                    order by id desc";
                }

		$res = $db->query($query);
		$ret = array();
		while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
			$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "messages");
			$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
			$ret[] = $message;
		}
		$result['im']=$ret;
                
		return $result;
	}
        
        /*
	public function get_message_persons($userId, $start = false, $count = false) {
		global $db;
		$userId = $db->addslashes($userId);
		$start = $db->addslashes($start);
		$count = $db->addslashes($count);
		if (! $start) $start = '0';
		if (! $count) $count = 20;
		$limit = "$start, $count";
		
		$query = "select distinct `from`, `to` from ".$this->table." where
				status<>'deleted' and type='private_message' and shop_id is null and (`from`=".$userId." or `to`=".$userId.")
				order by created desc limit $limit";
		 
		$res = $db->query($query);
		$persons = array();
		$people = $this->get_model('people');
		$visited = array();		
		
		while ($ar = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$person_id = ($ar['to']==$userId) ? $ar['from'] : $ar['to'];
				
			if(isset($visited[$person_id]) && $visited[$person_id]){
				continue;
			}
			$visited[$person_id]=1;
			
			$query = "select id, `from`, `to`, title, body, created, status from ".$this->table." where (`to`=".$ar['to']." and `from`=".$ar['from']." and shop_id IS NULL) or (`to`=".$ar['from']." and `from`=".$ar['to']." and shop_id IS NULL) order by created desc limit 1";
			$mres = $db->query($query);
			$message = $db->fetch_array($mres, MYSQLI_ASSOC);
			$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
			
			$message['direction']="from";
			if($_SESSION['id']==$message['to']){
				$message['direction']="to";
			}

			//кол-во непрочитанных 
			$collocutor_id=($ar['to']==$userId) ? $ar['to'] : $ar['from'];
			$message['unread']=$this->get_num_unread($person_id,$collocutor_id);
			
			$message['person'] = $people->get_person_info($person_id);
			
			$persons[] = $message;					
		}		
                
		$persons['found_rows']=$count;
		return $persons;
	}
	*/
        
    public function get_message_shop($userId, $shop_id, $start = false, $count = false) {
		global $db;
		$userId = $db->addslashes($userId);
		$start = $db->addslashes($start);
		$count = $db->addslashes($count);
		if (! $start) $start = '0';
		if (! $count) $count = 20;
		$limit = "$start, $count";
		
		$query = "select distinct `from`, `to` from ".$this->table." where
				status<>'deleted' and type='private_message' and ((`from`=".$userId." or `to`=".$userId.") and shop_id = ".$shop_id.")
				order by created desc limit $limit";
		
		$res = $db->query($query);
		$persons = array();
		$people = $this->get_model('people');
		$visited = array();		
		
		while ($ar = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$person_id = ($ar['to']==$userId) ? $ar['from'] : $ar['to'];
				
			if(isset($visited[$person_id]) && $visited[$person_id]){
				continue;
			}
			$visited[$person_id]=1;
			
			$query = "select id, `from`, `to`, shop_id, fromshop, title, body, created, status from ".$this->table." where (`to`=".$ar['to']." and `from`=".$ar['from']." and shop_id = ".$shop_id.") or (`to`=".$ar['from']." and `from`=".$ar['to']." and shop_id = ".$shop_id.") order by created desc limit 1";
			
			$mres = $db->query($query);
			$message = $db->fetch_array($mres, MYSQLI_ASSOC);
                        //print_r($message);
                        
			$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
			
			$message['direction']="from";
                        /*
			if($_SESSION['id']==$message['to']){
				$message['direction']="to";
			}*/

			//кол-во непрочитанных 
			$collocutor_id=($ar['to']==$userId) ? $ar['to'] : $ar['from'];
                        if($ar['to'] != $ar['from']) {
                            $message['unread']=$this->get_num_unread_shop($person_id,$collocutor_id, $shop_id);
                        } elseif(($ar['to'] == $ar['from']) and $message['fromshop'] == 0) {
                            $message['unread']=$this->get_num_unread_shop($person_id,$collocutor_id, $shop_id);
                        } else {
                            $message['unread']=0;
                        }
			$message['person'] = $people->get_person_info($person_id);
			
			$persons[] = $message;		
                        //print_r($persons);
		}		
                
		$persons['found_rows']=$count;
		return $persons;
	}
        
    /**
    * Метод возвращает массив сообщений от пользователей и магазинов
    * для текущего пользователя и объединяет его в один
    * 
    * @global type $db
    * @param int $userId
    * @param type $start
    * @param type $count
    */
    public function get_message_persons($userId, $start = false, $count = false) {
		global $db;
		$userId = $db->addslashes($userId);
		$start = $db->addslashes($start);
		$count = $db->addslashes($count);
		if (! $start) $start = '0';
		if (! $count) $count = 20;
		$limit = "$start, $count";
		
                $persons = array();
                // Получаем массив сообщений только от пользователей
                $person_arr = $this->query_message_persons($userId, $limit);
                // Получаем массив сообщений только от магазинов
                $shop_arr = $this->query_message_persons($userId, $limit, true);
                // Объединяем 2 массив
                $persons = array_merge($person_arr, $shop_arr);
                // Сортируем по полю created
                usort
                ( 
                    $persons,
                    create_function
                    (   
                        '$a,$b', 
                        'return -($a["created"] - $b["created"]);' 
                    )
                );
                
		$persons['found_rows']=$count;
                
                return $persons;
	}
	
	/**
         * Метод возвращает массив сообщений для текущего пользователя
         * 
         * @global type $db
         * @param integer $userId Идентификатор пользователя
         * @param bool $shop Флаг, который обозначает между кем идет переписка
         * Если флаг установлен в TRUE, то это переписка между пользователем и 
         * магазином. Иначе между пользователями.
         * @return массив сообщений
         */
    public function query_message_persons($userId, $limit, $shop_flag = false) {
            global $db;
            
            if($shop_flag == false) $shop_where = "and shop_id is null";
            else $shop_where = "and shop_id > 0";
            
            $query = "select distinct `from`, `to` from ".$this->table." where
				status<>'deleted' and type='private_message' ".$shop_where." and (`from`=".$userId." or `to`=".$userId.")
				order by created desc limit $limit";
		 
            $res = $db->query($query);
            $persons = array();
            $people = $this->get_model('people');
            $shop_info = $this->get_model('shop');
            $visited = array();		
            $master_shop = false;
            
            while ($ar = $db->fetch_array($res, MYSQLI_ASSOC)) {
                $person_id = ($ar['to']==$userId) ? $ar['from'] : $ar['to'];
                
                if(isset($visited[$person_id]) && $visited[$person_id]){
                    continue;
                }
                $visited[$person_id]=1;

                $query = "select id, `from`, `to`, shop_id, fromshop, title, body, created, status from ".$this->table." where status<>'deleted' and to_deleted='no' and from_deleted='no' and ((`to`=".$ar['to']." and `from`=".$ar['from']." ".$shop_where.") or (`to`=".$ar['from']." and `from`=".$ar['to']." ".$shop_where.")) order by created desc limit 1";
                $mres = $db->query($query);
                $message = $db->fetch_array($mres, MYSQLI_ASSOC);
                //echo $message['status']."! ";

                if($message['shop_id']){
                    //$shop = $shop_info->get_name_pic_shop($message['shop_id']);
                	  $shop = $shop_info->get_shop_info($message['shop_id']);
                    $message['shop'] = $shop;
                    $message['master'] = $shop_info->get_shop_owner($message['shop_id']);     
                    //$message['master'] = $shop_info->is_myshop($_SESSION['id'], $message['shop_id']);
                } else {
                    $message['master'] = false;
                }
                
                //if(!empty($message['shop_id'])) $master_shop = $shop_info->is_myshop($message['to'], $message['shop_id']);
                
                //if($master_shop == false){
                    $message['read'] = $message['status'] == 'read' ? 'yes' : 'no';

                    $message['direction']="from";
                    if($_SESSION['id']==$message['to']){
                        $message['direction']="to";
                    }

                    //кол-во непрочитанных 
                    $collocutor_id=($ar['to']==$userId) ? $ar['to'] : $ar['from'];
                    
                    if(!$shop_flag) {
                        $message['unread']=$this->get_num_unread($person_id,$collocutor_id);
                    } else {
                        if($ar['to'] != $ar['from']) {
                            $message['unread']=$this->get_num_unread_shop($person_id,$collocutor_id, $message['shop_id']);
                        } elseif(($ar['to'] == $ar['from']) and ($message['fromshop'] > 0)) {
                            $message['unread']=$this->get_num_unread_shop($person_id,$collocutor_id, $message['shop_id']);
                        } else {
                            $message['unread']=0;
                        }
                        //$message['unread']=$this->get_num_unread_shop($person_id,$collocutor_id, $message['shop_id']);
                    }

                    $message['person'] = $people->get_person_info($person_id);
                    if($_SESSION['id'] == $message['master']) {
                        if($message['to'] != $message['master'] and ($message['fromshop'] == 0)) {
                            $persons[] = $message;		
                        } elseif(($message['to'] == $message['master']) and ($message['fromshop'] > 0)) {
                            $persons[] = $message;		
                        } elseif(($message['to'] == $message['master']) and ($message['from'] == $message['master']) and ($message['fromshop'] == 0)) {
                            $persons[] = $message;		
                        }
                    } else {
                        $persons[] = $message;		
                    }
                //}
            }		

//echo var_dump($persons);
            return $persons;
        }
        
	//поиск по новостям
	public function news_search($q, $curpage=0) {
		global $db;
 		
		$res=$this->get_search_result($q, $curpage);
		$total = (int)( ( $res['total'] - 1 ) / $this->perpage ) + 1;
		$next=false;
		if($total>$curpage+1){
			$next=$curpage+1;
		}
		return array("nextpage"=>$next,
			 		 "totalpages"=>$total,
					 "results"=>$this->news_fillarray($res['ids']));
	}
	
	protected function get_search_result($q, $curpage){
		global $db;
		$q = $db->addslashes($q);
		
		$start = $curpage*$this->perpage;
		$limit = "$start, ".$this->perpage;
		
		$ret = array();
		$res = $db->query("select id from ".$this->table." where concat(title, ' ', anons, ' ', body) like '%$q%' limit $limit");
		while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$ret[] = $row['id'];
		}
		
		$res = $db->query("select count(id) as total from ".$this->table." where concat(title, ' ', anons, ' ', body) like '%$q%'");
		$row = $db->fetch_array($res, MYSQLI_ASSOC);
		
		
		return array('ids'=>$ret, 'total'=>$row['total']);
	}
	
	//показать новости по списку id
	public function news_fillarray($ids) {
		global $db;
		//$start = $curpage*$this->perpage;
		//$limit = "$start, ".$this->perpage;
				
		$where_sql="and 0";
		if(is_array($ids) and count($ids)>0){
			$where_sql=" and messages.`id` in (". implode(',', $ids).")";
		}
		
		$ret = array();
		$res = $db->query("select
		  	messages.id,
		  	messages.`from`,
		  	messages.`to`,
		  	messages.title,
		  	messages.anons,
		  	messages.body,
		  	messages.likes_num,
		  	messages.comment_num,
			messages.shared_num,
		  	messages.created,
  		  	messages.status,
  		  	concat(persons.first_name, ' ' , persons.last_name) as name,
  		  	persons.first_name as first_name, 
  		  	persons.last_name as last_name,
  		  	persons.thumbnail_url as thumbnail,
  		  	persons.id as person_id
  		  	from
  		  	messages, persons
  		  	where 1 ".$where_sql." and persons.id=messages.`from` order by created desc");// limit $limit");
		
		$comment=$this->get_model("comment");
		$people=$this->get_model("people");
		while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$row['comments']=$comment->get_comments(array("object_name"=>"messages", "object_id"=>$row['id']));
			$row['person'] = $people->get_person_info($person_id);
			$ret[] = $row;
		}
		return $ret;
	}
	
	
	//показать последних собеседников
	public function get_collocutors($id){
		global $db;
		$anons = intval($id);
		$res = $db->query("select DISTINCT `from`, `to` from ".$this->table." where type='private_message' and shop_id is null and (`to`=$id or `from`=$id) and (to_deleted='no' and from_deleted='no') order by created limit 0,8");
		
		$distinct=array();
		$ret=array();
		$people = $this->get_model('people');
		
		while ($collocutors = $db->fetch_array($res, MYSQLI_ASSOC)) {
			$col_id=$collocutors['from']==$id?$collocutors['to']:$collocutors['from'];
			
			if(!in_array($col_id, $distinct) and $col_id!=$id){
				$distinct[]=$col_id;
				$person=$people->get_person_info($col_id);
				$person['unread']=$this->get_num_unread($col_id,$id);
				$ret[] = $person;
			}
		}
		return $ret;
	}
		
	//количество непрочитанных сообщений
	public function get_num_unread($idfrom, $idto) {
		global $db;
		$res = $db->query("select count(id) as number_of_unread from ".$this->table." where (status='new' or status='unread') and shop_id is null and `from`=$idfrom and `to` =$idto and type='private_message' and to_deleted='no'");
		$ret = $db->fetch_array($res, MYSQLI_ASSOC);
		return $ret['number_of_unread'];
	}
	
	//количество непрочитанных сообщений
	public function get_num_unread_shop($idfrom, $idto, $shop_id) {
		global $db;
		$res = $db->query("select count(id) as number_of_unread from ".$this->table." where (status='new' or status='unread') and shop_id = $shop_id and `from`=$idfrom and `to` =$idto and type='private_message' and to_deleted='no'");
		$ret = $db->fetch_array($res, MYSQLI_ASSOC);
		return $ret['number_of_unread'];
	}
	
        //количество непрочитанных сообщений
	public function get_num_unread_in_shop($idfrom, $idto, $shop_id) {
		global $db;
		$res = $db->query("select count(id) as number_of_unread from ".$this->table." where (status='new' or status='unread') and shop_id = ".$shop_id." and `from`=$idfrom and `to` =$idto and type='private_message' and to_deleted='no'");
		$ret = $db->fetch_array($res, MYSQLI_ASSOC);
		return $ret['number_of_unread'];
	}
        
	public function get_owners($id) {
		global $db;
		$res = $db->query("select `from` from ".$this->table." where id=$id");
		$ret = $db->fetch_array($res, MYSQLI_ASSOC);
		return array($ret['from']);
	}
	
  public function send_news($from,$params) {
		global $db;
		$from = intval($from);
		$anons = $db->addslashes($params['anons']);
		$body = $db->addslashes($params['body']);
		$created = $_SERVER['REQUEST_TIME'];
		$db->query("insert into messages (`from`, anons, body, app_id, updated, created, type) values ($from, '$anons', '$body', 0, $created, $created,'news')");
  }

  public function get_id_shop_of_client($userId) {
        global $db;
        $queryClient = "SELECT shop_id FROM shop_clients WHERE client_id = $userId";
        $resultClient = $db->query($queryClient);
        $ret = $db->fetch_all($resultClient);
        return $this->get_el_array($ret);
    }

    /**
     * Получить id новостей магазина (свои, друзей и магазина)
     * @param type $from
     */
    public function get_id_news_from($from, $userId) {
        global $db;
        // Проверяем массив $from и получаем id записей, которые удовлетворяют
        // элементам массива $from
        if(is_array($from)){
            $from_sql=" and messages.`from` in (". implode(',', $from).")";  		
  	}
        // Подготовили массив id из $from        
        $array_from = $this->get_result_query_from_shop($from_sql);

        // Получаем массив магазинов, где текущий пользователь клиент
        $id_shop_array = $this->get_id_shop_of_client($userId);
        //Получаем массив id по массиву $id_shop_array
        if(is_array($id_shop_array)){
            $shop_sql=" and messages.`shop_id` in (". implode(',', $id_shop_array).")";  		
  	}
        // Подготовили массив id из $id_shop_array        
        $array_shop = $this->get_result_query_from_shop($shop_sql);
        
        $result = array_merge($array_from, $array_shop);
        return $result;
    }
  
    public function get_result_query_from_shop($where_sql){
        global $db;
        $query = "select id
                  FROM messages
                  WHERE 1"
                  .$where_sql.
                  " AND to_deleted = 'no'
                  AND messages.status<>'deleted'
                  AND type='news'";
  	$res = $db->query($query);
        $ret = $db->fetch_all($res);
        return $this->get_el_array($ret);
    }
    
    public function get_el_array($array){
        $result = array();
        
        if(!empty($array)){
            foreach($array as $item) {
                if(array_key_exists('id', $item)) { 
                    $result[] = $item['id'];
                } elseif(array_key_exists('shop_id', $item)) { 
                    $result[] = $item['shop_id'];
                } else {
                    $result[] = $item[0];
                }
            }
        }
        return $result;
    }
    
  /* показать новости */
  /*
   * Собрать id, по которым вывести новости
   */
  public function get_news($userId, $from, $curpage=0) {
  	global $db;
  	$userId = $db->addslashes($userId);
	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;
  	
        $id_shop_of_clients = $this->get_id_shop_of_client($userId);
        
        //друзей
        if(count($id_shop_of_clients) == 0) { // изменить
            if(is_array($from)){
                $from = array_filter(
                    $from,
                    function($el){ return !empty($el);}
                );
                $from_sql=" and messages.`from` in (". implode(',', $from).")";  		
                $from_sql .= " and messages.shop_id is null";
            }
        }
        else {        
            $result_array = $this->get_id_news_from($from, $userId);
            if(is_array($result_array) and count($result_array)>0){
              $from_sql=" and messages.`id` in (". implode(',', $result_array).")";
            }
        }
        
        // ВЫТАЩИТЬ СООБЩЕНИЯ ПО ID с учетом того, что пользователь должен
        // видеть свои новости, друзей и магазина, где он клиент
  	$query = "select
  	messages.id,
    messages.`from`,
    messages.shop_id,
  	messages.`to`,
  	messages.title,
  	messages.anons,
  	messages.body,
  	messages.likes_num,
  	messages.comment_num,
  	messages.shared_num,
  	messages.created,
  	messages.status,
        messages.shop_id,
  	concat(persons.first_name, ' ' , persons.last_name) as name,
  	persons.first_name as first_name, 
  	persons.last_name as last_name,
  	persons.thumbnail_url as thumbnail,
  	persons.id as person_id
  	from
  	messages, persons
  	where 1"  	
	.$from_sql.
  	" and to_deleted = 'no'
  	and messages.status<>'deleted'
  	and type='news'
  	and persons.id=messages.`from`
  	order by
  	created desc
  	limit   	$limit";
  	$res = $db->query($query);
  	
  	$ret = array();
  	$comment=$this->get_model("comment");
  	$media=$this->get_model("medias");
    $shop=$this->get_model("shop");
    $people=$this->get_model("people");
  	 
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
      if($message['shop_id']){
          $message['shop'] = $shop->get_shop_info($message["shop_id"]);
          $message['thumbnail'] = $message['shop']['thumbnail_url'];
          $message['shop_name'] = $message['shop']['name'];
          $message['name'] = $message['shop']['name'];
      }

  		$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
  		$message['comments']=$comment->get_comments(array("object_name" => "messages",
  														  "object_id" => $message['id']));
  		$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "news");
  		$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
  		$message['person'] = $people->get_person_info($message['person_id']);
      $ret[] = $message;
  	}
        
  return $ret;
  }
  
  public function get_news_only_profile($userId, $curpage=0) {
  	global $db;
  	$userId = $db->addslashes($userId);
	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;
  	
        $from_sql=" and messages.`from` = $userId";  		
        $from_sql .= " and messages.shop_id is null";
        
        
        // ВЫТАЩИТЬ СООБЩЕНИЯ ПО ID с учетом того, что пользователь должен
        // видеть свои новости, друзей и магазина, где он клиент
  	$query = "select
  	messages.id,
  	messages.`from`,
  	messages.`to`,
  	messages.title,
  	messages.anons,
  	messages.body,
  	messages.likes_num,
  	messages.comment_num,
  	messages.shared_num,
  	messages.created,
  	messages.status,
        messages.shop_id,
  	concat(persons.first_name, ' ' , persons.last_name) as name,
  	persons.first_name as first_name, 
  	persons.last_name as last_name,
  	persons.thumbnail_url as thumbnail,
  	persons.id as person_id
  	from
  	messages, persons
  	where 1"  	
	.$from_sql.
  	" and to_deleted = 'no'
  	and messages.status<>'deleted'
  	and type='news'
  	and persons.id=messages.`from`
  	order by
  	created desc
  	limit   	$limit";
  	$res = $db->query($query);
  	
  	$ret = array();
  	$comment=$this->get_model("comment");
  	$media=$this->get_model("medias");
  	$people=$this->get_model("people");
  	 
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
  		$message['comments']=$comment->get_comments(array("object_name" => "messages",
  														  "object_id" => $message['id']));
  		$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "news");
  		$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
  		$message['person'] = $people->get_person_info($message['person_id']);
                if(!empty($message['shop_id'])) {
                    $shop_organization = $this->get_name_pic_shop($message['shop_id']);
                    $message['shop_name'] = $shop_organization['name'];
                    $message['shop_thumbnail_url'] = $shop_organization['thumbnail_url'];
                }
  		$ret[] = $message;
  	}
        
  return $ret;
  }
  
  public function get_name_pic_shop($shopId){
      global $db;
      $queryOrganization = "
                SELECT s.thumbnail_url, o.name FROM shop s
                INNER JOIN organizations o
                ON o.id = s.organization_id
                WHERE s.id = $shopId
                ";
        $resOrganization = $db->query($queryOrganization);
        return $db->fetch_array($resOrganization, MYSQLI_ASSOC);
  }
  
  /* показать новости */
  /** Старый метод, выше переписанный */
  /*
  public function get_news($userId, $from, $curpage=0) {
  	global $db;
  	$userId = $db->addslashes($userId);
	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;
  	
  	//друзей
  	if(is_array($from)){
		$from = array_filter(
			 $from,
			 function($el){ return !empty($el);}
		);
  		$from_sql=" and messages.`from` in (". implode(',', $from).")";  		
  	}
  	
        //Получаем id магазинов, где текущий пользователь является клиентом
        $id_shop_of_clients = $this->get_id_shop_of_client($userId);
        if(!empty($id_shop_of_clients)) {
            $i = 1;
            $id = '';
            foreach($id_shop_of_clients as $item) {
                if(count($id_shop_of_clients) > $i) $id .= $item[0].',';
                else $id .= $item[0];
                $i++;
            }
            $client = " or messages.shop_id IN ($id)";
        }
        else {
            $client = " and messages.shop_id is null";
        }       
        
        // ВЫТАЩИТЬ СООБЩЕНИЯ ПО ID с учетом того, что пользователь должен
        // видеть свои новости, друзей и магазина, где он клиент
  	$query = "select
  	messages.id,
  	messages.`from`,
  	messages.`to`,
  	messages.title,
  	messages.anons,
  	messages.body,
  	messages.likes_num,
  	messages.comment_num,
  	messages.shared_num,
  	messages.created,
  	messages.status,
  	concat(persons.first_name, ' ' , persons.last_name) as name,
  	persons.first_name as first_name, 
  	persons.last_name as last_name,
  	persons.thumbnail_url as thumbnail,
  	persons.id as person_id
  	from
  	messages, persons
  	where 1"  	
	.($from_sql?$from_sql:"").
  	" and to_deleted = 'no'
  	and messages.status<>'deleted'
        $client
  	and type='news'
  	and persons.id=messages.`from`
  	order by
  	created desc
  	limit   	$limit";
  	$res = $db->query($query);
  	
  	$ret = array();
  	$comment=$this->get_model("comment");
  	$media=$this->get_model("medias");
  	$people=$this->get_model("people");
  	 
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
  		$message['comments']=$comment->get_comments(array("object_name" => "messages",
  														  "object_id" => $message['id']));
  		$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "news");
  		$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
  		$message['person'] = $people->get_person_info($message['person_id']);
  		
  		$ret[] = $message;
  	}
  return $ret;
  }*/
  
  public function get_news_pages($userId, $from, $curpage=0) {
  	global $db;
  	$userId = $db->addslashes($userId);
  	 
  	//друзей
  	if(is_array($from)){
  		$from_sql=" and messages.`from` in (". implode(',', $from).")";
  	}
  	 
  	$query = "select count(messages.id) as number_of_news from	messages where 1"
  			.($from_sql?$from_sql:""). " and to_deleted = 'no' and type='news'";
  	$res = $db->query($query);
  	$num = $db->fetch_array($res, MYSQLI_ASSOC);
  	
  	$total = (int)( ( $num['number_of_news'] - 1 ) / $this->perpage ) + 1;
  	$next=false;
  	if($total>$curpage+1){
  		$next=$curpage+1;
  	}
  	return array("nextpage"=>$next,
  				 "totalpages"=>$total);  	
  }
	
  public function send_message($from, $to, $subject, $body) {
    global $db;
    $from = intval($from);
    $to = intval($to);
    $subject = $db->addslashes($subject);
    $body = $db->addslashes($body);
    $created = $_SERVER['REQUEST_TIME'];

    $db->query("insert into messages (`from`, `to`, title, body, app_id, updated, created, status) values ($from, $to, '$subject', '$body', 0, $created, $created, 'new')");
    
    return $db->insert_id();
  }
  
  public function send_shop_message($from, $to, $shop_id, $subject, $body) {
    global $db;
    $from = intval($from);
    $to = intval($to);
    $shop_id = intval($shop_id);
    $subject = $db->addslashes($subject);
    $body = $db->addslashes($body);
    $created = $_SERVER['REQUEST_TIME'];

//echo "insert into messages (`from`, `to`, shop_id, fromshop, title, body, app_id, updated, created, status) values ($from, $to, $shop_id, $shop_id, '$subject', '$body', 0, $created, $created, 'new')";

    $db->query("insert into messages (`from`, `to`, shop_id, fromshop, title, body, app_id, updated, created, status) values ($from, $to, $shop_id, $shop_id, '$subject', '$body', 0, $created, $created, 'new')");
    
    return $db->insert_id();
  }
  
  //копирует сообщение $message_id для нового получателя $new_to==person_id
  public function copy($message_id, $new_to) {
  	global $db;
  	$message_id = intval($message_id);
  	$new_to = intval($new_to);
 	$fields=$this->supported_fields;
 	unset($fields[0]); //убрать id
 	$db->query("insert into ".$this->table."(`".implode("`, `", $fields)."`) select `".implode("`, `", $fields)."` from ".$this->table." where id=$message_id");
 	$newid=$db->insert_id();
 	$db->query("update ".$this->table." set `to`=$new_to where id=$newid");
 	return $newid;
  }
  
  public function delete_message($message_id, $to_or_from="") {
    global $db;
    $message_id = intval($message_id);
    
    if($to_or_from){
	    if ($to_or_from == 'to') {
	      $field = 'to_deleted';
	    } elseif ($to_or_from == 'from') {
	      $field = 'from_deleted';
	    }
	    $query = "update messages set $field = 'yes' where id = $message_id";
	    $db->query($query);
    }else{
    	$query = "update messages set from_deleted = 'yes', status='deleted' where id = $message_id";
    	$db->query($query);
    }
    
  }
  
  public function get_message($message_id, $type = 'inbox') {
  	global $db;
  	
  	$media=$this->get_model("medias");
  	 
  	/*
  	if ($type != 'inbox' && $type != 'sent') {
  		die('eeek!');
  	}
  	$type = $type == 'inbox' ? 'to' : 'from';
  	
  	//persons.id = messages.`$type` and
  	*/
  	  	
  	$res = $db->query("select messages.*, concat(persons.first_name, ' ' , persons.last_name) as name, persons.thumbnail_url as thumbnail_url from messages, persons where messages.from=persons.id and  messages.id = " . $db->addslashes(intval($message_id)));
  	$ret = $db->fetch_array($res, MYSQLI_ASSOC);
  	$ret['medias']=$media->get_medias(array("message_id" => $ret['id'] ),"IMAGE", "messages");
  	$ret['files']=$media->get_medias(array("message_id" => $ret['id'] ), "FILE");
  	
  	return $ret;
  }
  
  public function get_shop_message($message_id, $shop_id, $type = 'inbox') {
  	global $db;
  	
  	$media=$this->get_model("medias");
  	 
  	/*
  	if ($type != 'inbox' && $type != 'sent') {
  		die('eeek!');
  	}
  	$type = $type == 'inbox' ? 'to' : 'from';
  	
  	//persons.id = messages.`$type` and
  	*/
        $shop_info = $this->get_model("shop");
  	$shop = $shop_info->get_shop($shop_id, true);  	
        
  	$res = $db->query("select messages.*, concat(persons.first_name, ' ' , persons.last_name) as name, persons.thumbnail_url as thumbnail_url from messages, persons where messages.from=persons.id and  messages.id = " . $db->addslashes(intval($message_id)));
  	$ret = $db->fetch_array($res, MYSQLI_ASSOC);
  	$ret['medias']=$media->get_medias(array("message_id" => $ret['id'] ),"IMAGE", "messages");
  	$ret['files']=$media->get_medias(array("message_id" => $ret['id'] ), "FILE");
  	$ret['shop'] = $shop;
        
        //print_r($ret);
        
  	return $ret;
  }
  
  public function get_new($message_id) {
  	global $db;
  	$res = $db->query("select messages.*, persons.first_name as first_name, persons.last_name as last_name, persons.id as person_id, persons.thumbnail_url as thumbnail from messages, persons where persons.id = messages.`from` and messages.id = " . $db->addslashes(intval($message_id)));
  	$ret = $db->fetch_array($res, MYSQLI_ASSOC);
  	
  	$media=$this->get_model("medias");
  	$ret['medias']=$media->get_medias(array("message_id" => $ret['id'] ), "IMAGE", "news");
  	$ret['files']=$media->get_medias(array("message_id" => $ret['id'] ), "FILE");
  	 
  	//фото из комментариев пользователей
  	$ret['comment_medias']=$media->get_medias(array("object_name" => "messages",
  			"object_id"=> $ret['id'] ), "IMAGE", "news");

  	$comment=$this->get_model("comment");
  	$ret['read'] = $ret['status'] == 'read' ? 'yes' : 'no';
  	
        /* Проверяем значение shop_id, если не пустое, то получаем 
           название и аватар магазина
         */
        if(!empty($ret['shop_id'])) {
            $shop_organization = $this->get_name_pic_shop($ret['shop_id']);
            $ret['shop_name'] = $shop_organization['name'];
            $ret['shop_thumbnail_url'] = $shop_organization['thumbnail_url'];
        }
  	$ret['comments']=$comment->get_comments(array("object_name" => "messages", "object_id" => $ret['id'], "allpages"=>true));
  	
  	 
  	return $ret;
  }
  
  public function mark_read($message_id) {
    global $db;
    $message_id = intval($message_id);
    $db->query("update messages set `status` = 'read' where id = $message_id");
  }

  public function get_inbox($userId, $start = false, $count = false) {
    global $db;
    $userId = $db->addslashes($userId);
    $start = $db->addslashes($start);
    $count = $db->addslashes($count);
    if (! $start) $start = '0';
    if (! $count) $count = 20;
    $limit = "$start, $count";
    $query = "
    	select
    		messages.id,
    		messages.`from`,
    		messages.`to`,
    		messages.title,
    		messages.body,
    		messages.created,
    		messages.status,
    		concat(persons.first_name, ' ' , persons.last_name) as name,
    		persons.thumbnail_url as thumbnail
    	from
    		messages, persons
        where
            messages.`to` = $userId and
            persons.id = messages.`from` and
            to_deleted = 'no'
		order by
			created desc
		limit
			$limit";
    $res = $db->query($query);
    $ret = array();
    while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
      $message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
      #$message['person'] = $people->get_person_info($message['person_id']);
      
      $ret[] = $message;
    }
    return $ret;
  }

  public function get_inbox_number($userId, $shop = false) {
  	global $db;
  	$userId = $db->addslashes($userId);
  	 
  	$query = "
  	select `from`, `to`, shop_id, `fromshop`, `status`
  	from
  	`messages`
  	where
  	`to` = $userId and
  	`to_deleted` = 'no'
  	and (`status`='unread' or `status`='new')";
  	$res = $db->query($query);
  	$ret = array();
  	$read=0;
  	$unread=0;
        $shop_info = $this->get_model('shop');
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
		if(!empty($message['shop_id'])) {
			$person_id_master = $shop_info->get_shop_owner($message['shop_id']);
		}
        
		if($shop) {
                        if($message['shop_id'] > 0 and $message['fromshop'] == 0) {
                                if($message['status'] == 'read'){
                                        $read++;
                                }else{
                                        $unread++;
                                };		
                        }
		} else {
			if(isset($person_id_master[0]) and $person_id_master[0] == $userId and $message['shop_id'] > 0 ) {
				if($message['to'] != $person_id_master[0]) {
					if($message['status'] == 'read'){
						$read++;
					}else{
						$unread++;
					};	
				} elseif(($message['to'] == $person_id_master[0]) and ($message['fromshop'] > 0)) {
					if($message['status'] == 'read'){
						$read++;
					}else{
						$unread++;
					};		
				}
				
			} else {
				if($message['status'] == 'read'){
					$read++;
				}else{
					$unread++;
				};
			}
			
		}
  	}

  	$ret["read"]=$read;
  	$ret["unread"]=$unread;
  	return $ret;
  }
  
  public function get_sent($userId, $start = false, $count = false) {
    global $db;
    $userId = $db->addslashes($userId);
    $start = $db->addslashes($start);
    $count = $db->addslashes($count);
    if (! $start) $start = '0';
    if (! $count) $count = 20;
    $limit = "$start, $count";
    $query = "
    	select
    		messages.id,
    		messages.`from`,
    		messages.`to`,
    		messages.title,
    		messages.body,
    		messages.created,
    		concat(persons.first_name, ' ' , persons.last_name) as name,
    		persons.thumbnail_url as thumbnail
    	from
    		messages, persons
        where
            messages.`from` = $userId and
            persons.id = messages.`to` and
            from_deleted = 'no'
		order by
			created desc
		limit
			$limit";
    $res = $db->query($query);
    $ret = array();
    while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
      $ret[] = $message;
    }
    return $ret;
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
  
  
  //показать по id (wall и т.д.)
  public function show($id, $details=false){
  	global $db;
  	$id = $db->addslashes(intval($id));
  	$res = $db->query("select * from ".$this->table." where id = " . $id);
  	$ret = $db->fetch_array($res, MYSQLI_ASSOC);

  	$comment=$this->get_model("comment");
	$ret['comments']=$comment->get_comments(array("object_name"=>"messages", "object_id"=>$id));
	
	if($details){
		$media=$this->get_model("medias");
		$ret['medias']=$media->get_medias(array("message_id" => $ret['id'] ), "IMAGE", "news");
		$ret['files']=$media->get_medias(array("message_id" => $ret['id'] ), "FILE");
	}
  	 
  	return $ret;  	 
  }

  public function prepare_new_message($id, $params) {
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
  		$query = "insert into `messages` (`" . implode("`, `", $fields) . "`) values (". implode(', ', $values) .")";
  		$db->query($query);
  		return $db->insert_id();
  	}
  }
  
  /* показать новости магазина */
  public function get_shop_news($userId, $shopId, $curpage=0) {
  	global $db;
  	$userId = $db->addslashes($userId);
    $shopId = $db->addslashes($shopId);
	$start = $curpage*$this->perpage;
  	$limit = "$start, ".$this->perpage;
  	
  	//сотрудники
        /*
  	if(is_array($from)){
		$from = array_filter(
			 $from,
			 function($el){ return !empty($el);}
		);
  		$from_sql=" and messages.`from` in (". implode(',', $from).")";  		
  	}*/
  	
  	$query = "select
  	messages.id,
  	messages.`from`,
  	messages.`to`,
  	messages.title,
  	messages.anons,
  	messages.body,
  	messages.likes_num,
  	messages.comment_num,
  	messages.shared_num,
  	messages.created,
  	messages.status,
    messages.shop_id,
  	shop.name as shop_name, 
  	shop.thumbnail_url as thumbnail
  	from
  	messages, shop
  	where messages.shop_id = ".$shopId."
    and shop.id=messages.shop_id
    and messages.to_deleted = 'no'
  	and messages.status<>'deleted' 
  	and type='news'
  	order by
  	created desc
  	limit   	$limit";
  	//and persons.id=messages.`from`
  	
  	$res = $db->query($query);
  	
  	$ret = array();
  	$comment=$this->get_model("comment");
  	$media=$this->get_model("medias");
  	$people=$this->get_model("people");
  	$shop=$this->get_model("shop");
  	
  	while ($message = $db->fetch_array($res, MYSQLI_ASSOC)) {
  		$message['read'] = $message['status'] == 'read' ? 'yes' : 'no';
  		$message['comments']=$comment->get_comments(array("object_name" => "messages",
  														  "object_id" => $message['id']));
  		$message['medias']=$media->get_medias(array("message_id" => $message['id'] ), "IMAGE", "news");
  		$message['files']=$media->get_medias(array("message_id" => $message['id'] ), "FILE");
  		//$message['person'] = $people->get_person_info($message['person_id']);
  		$message['shop'] = $shop->get_shop_info($message['shop_id']);
  		
  		$ret[] = $message;
  	}
  return $ret;
  }
  
  public function get_shop_news_pages($shopId, $from, $curpage=0) {
  	global $db;
  	$shopId = $db->addslashes($shopId);
  	 
  	//друзей
  	if(is_array($from)){
  		$from_sql=" and messages.`from` in (". implode(',', $from).")";
  	}
  	 
  	$query = "select count(messages.id) as number_of_news from	messages where 1"
  			.($from_sql?$from_sql:""). " and to_deleted = 'no' and type='news'";
  	$res = $db->query($query);
  	$num = $db->fetch_array($res, MYSQLI_ASSOC);
  	
  	$total = (int)( ( $num['number_of_news'] - 1 ) / $this->perpage ) + 1;
  	$next=false;
  	if($total>$curpage+1){
  		$next=$curpage+1;
  	}
  	return array("nextpage"=>$next,
  				 "totalpages"=>$total);  	
  }
    
    public function get_user_from_message($id) {
        global $db;
        
        $query = "SELECT `from` FROM messages WHERE id=$id";
  	$res = $db->query($query);
  	return $db->fetch_array($res, MYSQLI_ASSOC);
        
    }
    
}
