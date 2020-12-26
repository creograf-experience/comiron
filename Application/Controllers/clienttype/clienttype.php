<?php
class clienttypeController extends baseController {
  public function index() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      $this->template($template, array('error' => 'invalid id'));
      return;
    }

    try {
      $clienttype = $this->model('clienttype');
      $res = $clienttype->findById($_GET['id']);

      $this->template($template, array(
        'success' => true,
        'data' => $res
      ));

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }

  public function check_if_admin() {
    if (!isset($_SESSION['id'])) {
      $this->template($template, array('error' => 'Not authorized'));
      return;
    }

    $clienttype = $this->model('clienttype');

    try {
      $res = $clienttype->find_admin($_SESSION['id']);

      $this->template($template, array(
        'success' => true,
        'data' => $res
      ));

    } catch (Exception $e) {
      $this->template($template, array('error' => $e->getMessage()));
    }
  }
}
