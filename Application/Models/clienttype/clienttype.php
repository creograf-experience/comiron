<?php

class clienttypeModel extends Model {
  private $table = 'clienttype';
  private $supported_fields = array('id', 'name', 'person_id');

  public function findById($id) {
    global $db;

    if (!$id) return null;

    $clienttype_id = $db->addslashes(trim($id));

    $res = $db->query("SELECT * FROM clienttype WHERE id = $clienttype_id");
    if (!$db->num_rows($res)) {
      return null;
    }

    return $db->fetch_array($res, MYSQLI_ASSOC);
  }

  public function find_admin($id) {
    global $db;

    $id = $db->addslashes(trim($id));

    $res = $db->query("SELECT * FROM clienttype WHERE person_id = $id");
    if (!$db->num_rows($res)) {
      return null;
    }

    return $db->fetch_array($res, MYSQLI_ASSOC);
  }
}
