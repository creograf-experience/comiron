<?php

class dataModel extends Model {
	public $supported_fields = array('id', 'person_id');
	protected $table="";

	//возвращает список владельцев объекта
	public function get_owners($id) {
		global $db;
		$res = $db->query("select person_id from ".$this->table." where id=$id");
		$ret = $db->fetch_array($res, MYSQLI_ASSOC);
		return array($ret['person_id']);
	}
}
