<?php

class clientlistModel extends Model {
  private $supported_fields = array(
    'id',
    'clienttype_id',
    'person_id',
    'card'
  );

  public function find_by($field, $value) {
    global $db;

    $field = $db->addslashes($field);
    $value = $db->addslashes($value);

    $res = $db->query("SELECT * FROM clientlist WHERE $field = $value");

    while ($row = $db->fetch_array($res, MYSQLI_ASSOC)) {
      $result[] = $row;
    }

    return $result;
  }

  public function add($params) {
    global $db;

    $person_id = $db->addslashes($params['person_id']);
    $clienttype_id = $db->addslashes($params['clienttype_id']);
    $first_name = $db->addslashes($params['first_name']);
    $last_name = $db->addslashes($params['last_name']);
    $card = $db->addslashes($params['card']);
    $is_reg = $db->addslashes($params['is_reg']);

    $res = $db->query("
      INSERT INTO clientlist (
        clienttype_id,
        person_id,
        first_name,
        last_name,
        card,
        is_reg
      )
      VALUES (
        '$clienttype_id',
        '$person_id',
        '$first_name',
        '$last_name',
        '$card',
        '$is_reg'
      )
    ");

    $id = $db->insert_id($res);

    return $id;
  }

  public function delete($id) {
    global $db;

    $id = $db->addslashes($id);
    $db->query("DELETE FROM clientlist WHERE id = $id");
  }

  public function update($id, $fields) {
    global $db;

    $id = $db->addslashes($id);

    $query_fields = [];
    foreach ($fields as $key => $value) {
      $field = $db->addslashes($key);
      $value = $db->addslashes($value);

      array_push($query_fields, "$field = '$value'");
    }

    $db->query("UPDATE clientlist SET ". implode(',', $query_fields) ." WHERE id = $id");
  }
}
