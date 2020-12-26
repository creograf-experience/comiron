<?php

class cart_szController extends baseController {
  public function index() {
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
      echo json_encode(['error' => 'Wrong request method']);
      return;
    }

    if (!$_SESSION['id']) {
      echo json_encode(['error' => 'Not Authorized']);
      return;
    }

    $cart_sz = $this->model('cart_sz');

    try {
      $carts = $cart_sz->get_all_small_cart($_SESSION['id']);
      echo json_encode(['carts' => $carts]);

    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  public function find_one() {
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
      echo json_encode(['error' => 'Wrong request method']);
      return;
    }

    if (!$_SESSION['id']) {
      echo json_encode(['error' => 'Not Authorized']);
      return;
    }

    if (!$_GET['shop_id'] || !$_GET['price_id']) {
      echo json_encode(['error' => 'provide price_id and shop_id']);
      return;
    }

    $cart_sz = $this->model('cart_sz');

    $shop_id = $_GET['shop_id'];
    $price_id = $_GET['price_id'];

    try {
      $cart = $cart_sz->get_cart($_SESSION['id'], $shop_id, $price_id);
      echo json_encode($cart);

    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  public function create_order() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      echo json_encode(['error' => 'Wrong request method']);
      return;
    }

    if (!$_SESSION['id']) {
      echo json_encode(['error' => 'Not Authorized']);
      return;
    }

    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body['shop_id'] || !$body['price_id']) {
      echo json_encode(['error' => 'provide price_id and shop_id']);
      return;
    }

    $cart_sz = $this->model('cart_sz');
    $order = $this->model('order');
    $people = $this->model('people');

    try {
      $carts = $cart_sz->get_cart($_SESSION['id'], $body['shop_id'], $body['price_id'])['cart'];
      $cart = $carts[0];

      $person = $people->get_person_info($cart['person_id']);

      $products = [];
      $cart_ids = [];
      $sum = 0;

      foreach ($carts as $c) {
        $sum += $c['sum'];
        $cart_ids[] = $c['id'];

        $products[] = [
          'product_id' => $c['product']['id'],
          'num' => $c['num'],
          'price' => $c['price'],
          'sum' => $c['sum'],
          'shop_id' => $c['shop_id'],
          'currency_id' => $c['currency_id'],
          'person_id' => $c['person_id'],
          'price_id' => $c['price_id'],
          'source' => $c['source'],
          'product_name' => $c['product']['name'],
          'photo_url' => $c['product']['photo_url']
        ];
      }

      $params = [
        'shop_id' => $cart['shop_id'],
        'person_id' => $cart['person_id'],
        'price_id' => $cart['price_id'],
        'currency_id' => $cart['currency_id'],
        'sum' => $sum,
        'is_sz' => 1,
        'orderstatus_id' => 1,
        'dataorder' => $_SERVER['REQUEST_TIME'],
        'phone' => $person['phone'],
        'contactname' => $person['first_name'].' '.$person['last_name'],
        'email' => $person['email'],
        'ispayed' => 0,
        'numpack' => 1
      ];

      $res = $order->create_sz_order($params, $products, $cart_ids);
      $result = [
        'cart' => $carts,
        'order_id' => $res['order_id'],
        'order_detail_ids' => $res['order_detail_ids']
      ];

      echo json_encode($result);
    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  // cron job every day at 00:05
  public function carts_to_order() {
    $cart = $this->model('cart_sz');
    $order = $this->model('order');
    $people = $this->model('people');

    try {
      $carts = $cart->find_finished_sz_carts();

      if (!$carts || count($carts) == 0) {
        echo json_encode(['message' => 'no carts found']);
        return;
      }

      foreach ($carts as $cart) {
        $person = $people->get_person_info($cart['person_id']);

        $params = [
          'shop_id' => $cart['shop_id'],
          'person_id' => $cart['person_id'],
          'price_id' => $cart['price_id'],
          'currency_id' => $cart['currency_id'],
          'sum' => $cart['sum'],
          'is_sz' => 1,
          'orderstatus_id' => 1,
          'dataorder' => $_SERVER['REQUEST_TIME'],
          'phone' => $person['phone'],
          'contactname' => $person['first_name'].' '.$person['last_name'],
          'email' => $person['email'],
          'ispayed' => 0,
          'numpack' => 1
        ];

        $res = $order->create_sz_order($params, $cart['products'], $cart['cart_ids']);
        $result[] = [
          'cart' => $cart,
          'order_id' => $res['order_id'],
          'order_detail_ids' => $res['order_detail_ids']
        ];
      }

      echo json_encode($result);

    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }
}
