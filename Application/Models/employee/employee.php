<?php
/**
 * employeeModel
 */

class employeeModel extends Model { 
    public $supported_fields = array('id', 'person_id', 'shop_id', 'position');
    private $_perpage = 50;
    private $_table = 'employee';

    public function get_employee($id) {
        global $db;
        $id = $db->addslashes($id);

        $res = $db->query("SELECT e.*, p.first_name, p.last_name, p.phone FROM $this->_table as e
                            INNER JOIN persons as p ON p.id=e.person_id 
                            WHERE e.id=$id");

        return $res->fetch_array(MYSQLI_ASSOC);
    }

    public function get_list($shop_id, $page) {
        global $db;
        $shop_id = $db->addslashes($shop_id);
        $start = $page * $this->_perpage;
        $limit = "$start, ".$this->_perpage;

        $res = $db->query("SELECT e.*, p.first_name, p.last_name, p.phone FROM $this->_table as e 
                            INNER JOIN persons as p ON p.id=e.person_id 
                            WHERE e.shop_id=$shop_id LIMIT $limit");

        $rows = array();
        while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
            $rows[] = $row;
        }
    
        return $rows;
    }

    public function update($id, $position) {
        global $db;
        $id = $db->addslashes($id);
        $position = $db->addslashes($position);

        $res = $db->query("UPDATE $this->_table SET position='$position' WHERE id=$id");

        return $res;
    }

    public function delete($id) {
        global $db;
        $id = $db->addslashes($id);

        $res = $db->query("DELETE FROM $this->_table WHERE id=$id");

        return $res;
    }

    public function create($position, $person_id, $shop_id) {
        global $db;        
        $position = $db->addslashes($position);
        $person_id = $db->addslashes($person_id);
        $shop_id = $db->addslashes($shop_id);

        $res = $db->query("INSERT INTO $this->_table (position, person_id, shop_id) VALUES ('$position', $person_id, $shop_id)");

        return $res;
    }
}