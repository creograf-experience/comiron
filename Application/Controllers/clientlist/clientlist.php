<?php
class clientlistController extends baseController {
  public function index() {
    if (!isset($_GET['clienttype_id']) || !is_numeric($_GET['clienttype_id'])) {
      $this->template($template, array('error' => 'No clienttype_id'));
      return;
    }

    try {
      $clientlist = $this->model('clientlist');
      $res = $clientlist->find_by('clienttype_id', $_GET['clienttype_id']);

      $this->template($template, array(
        'success' => true,
        'data' => $res
      ));

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }

  public function add_client() {
    if (
      !isset($_POST['first_name']) ||
      !isset($_POST['last_name']) ||
      !isset($_POST['card']) ||
      !is_numeric($_POST['card']) ||
      !isset($_POST['clienttype_id']) ||
      !is_numeric($_POST['clienttype_id'])
    ) {
      $this->template($template, array('error' => 'Invalid data'));
      return;
    }

    $clientlist = $this->model('clientlist');

    try {
      $client = $clientlist->find_by('card', $_POST['card']);

      if ($client && $client[0]) {
        $this->template($template, array('error' => 'Клиент с такой картой уже существует'));
        return;
      }

      $data = array_merge(
        ['person_id' => 0],
        ['is_reg' => 0],
        $_POST
      );

      $clientlist->add($data);

      $this->template($template, array(
        'success' => true,
        'message' => 'Пользователь добавлен в список клиентов',
        'data' => $data
      ));

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }

  public function delete_by_id() {
    if (
      !isset($_POST['id']) ||
      !is_numeric($_POST['id'])
    ) {
      $this->template($template, array('error' => 'Invalid data'));
      return;
    }

    $clientlist = $this->model('clientlist');
    $people = $this->model('people');

    try {
      $existing_client = $clientlist->find_by('id', $_POST['id']);
      if (!$existing_client) {
        $this->template($template, array('error' => 'Клиента не существует'));
        return;
      }

      $existing_client = $existing_client[0];

      if ($existing_client['person_id'] !== '0') {
        $existing_person = $people->load_get_person_info($existing_client['person_id']);
        $clientlist->delete($_POST['id']);
        $people->update_clienttype($existing_client['person_id'], 'NULL');

        $this->template($template, array(
          'success' => true,
          'message' => 'Клиент удален'
        ));
        return;
      }

      $clientlist->delete($_POST['id']);
      $this->template($template, array(
        'success' => true,
        'message' => 'Клиент удален'
      ));

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }

  public function update() {
    if (
      !isset($_POST['id']) ||
      !is_numeric($_POST['id']) ||
      !isset($_POST['card']) ||
      !is_numeric($_POST['card']) ||
      !isset($_POST['first_name']) ||
      !isset($_POST['last_name']) ||
      strlen($_POST['card']) != 4
    ) {
      $this->template($template, array('error' => 'Invalid data'));
      return;
    }

    $clientlist = $this->model('clientlist');

    try {
      $existing_client = $clientlist->find_by('id', $_POST['id'])[0];
      if (!$existing_client) {
        $this->template($template, array('error' => 'Клиента не существует'));
        return;
      }

      $data = [
        'card' => $_POST['card'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name']
      ];

      $clientlist->update($_POST['id'], $data);
      $updated_client = $clientlist->find_by('id', $_POST['id'])[0];

      $this->template($template, array(
        'success' => true,
        'message' => 'Клиент обновлен',
        'data' => $updated_client
      ));

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }

  public function import_clients() {
    $file = $_FILES['Filedata'];
    $clienttype_id = $_POST['clienttype_id'];

    $clientlist = $this->model('clientlist');

    try {
      $data = $this->_parse_excel($file['tmp_name'], $clienttype_id);
      $skip_count = 0;

      foreach ($data as $client) {
        $existing_client = $clientlist->find_by('card', $client['card']);
        if ($existing_client && $existing_client[0]) {
          $skip_count += 1;
          continue;
        }

        $clientlist->add($client);
      }

      echo json_encode([
        'success' => true,
        'create_client_count' => count($data),
        'skipped' => $skip_count
      ]);

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }

  private function _parse_excel($file, $clienttype_id) {
    require_once PartuzaConfig::get('library_root').'/Spreadsheet/SpreadsheetReader_XLSX.php';
    $parser = new SpreadsheetReader_XLSX($file);

    $result = [];

    foreach ($parser as $row) {
      $new_client = [
        'last_name' => trim($row[0]),
        'first_name' => trim($row[1]),
        'card' => trim($row[3]),
        'clienttype_id' => $clienttype_id,
        'is_reg' => 0,
        'person_id' => 0
      ];

      $result[] = $new_client;
    }

    return $result;
  }
}
