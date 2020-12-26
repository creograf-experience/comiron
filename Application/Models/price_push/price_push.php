<?php

class price_pushModel extends Model {
    private $table = "price_push";
    private $supported_fields = array('price_id', "person_id");

    public function get_persons($price_id){
      global $db;
      $res = $db->query("select person_id from ".$this->table." where price_id=$price_id");

      //$res = $db->query("select * from `product` where id=$id");
      if (! $db->num_rows($res)) {
        return [];
      }

      $person_ids=[];
      if ($data = $res->fetch_array(MYSQLI_ASSOC)) {
        //$data['name']=$data['name_en'];
        $person_ids[] = $data['person_id'];
      }
      return $person_ids;
    }

    public function add_persons($shop_id, $price_id, $person_ids){
    	global $db;
      $shop_id = $db->addslashes($shop_id);
      $price_id = $db->addslashes($price_id);

      if(!count($person_ids)) return;

      $query = "INSERT INTO price_push (shop_id, price_id, person_id) values ";

      foreach ($person_ids as $person_id) {
        $query .= "($shop_id, $price_id, $person_id),";
      }
      $query = mb_substr($query, 0, -1); //удалить последнюю запятую
//var_dump($query);

      $db->query($query);
      return;
    }

}
