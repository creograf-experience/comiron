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

class employeeController extends baseController {

    static function checkId($id) { 
        $rex =  "/^[0-9]{0,11}\$/";      
        return preg_match($rex, $id);
    }

    static function checkPosition($position) {
        $rexSafety = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#\'\+\!]+/i";
        $len = strlen($position);
        return !preg_match($rexSafety, $position) && $len > 0 && $len < 256;
    }

    static function checkAuth() {
        if (!isset($_SESSION['id'])) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            die();
        }
    }

    function chechShop($shop_id) {
        $id = $_SESSION['id'];
        $shop = $this->model('shop');
        $shops = $shop->load_get_myshop($id);

        $isYoursShop = false;

        if ($shops) {
            foreach ($shops as $key => $value) {
                if (is_numeric($key)) {
                    if ($value['id'] === $shop_id) {
                        $isYoursShop = true;
                        return;
                    }
                } else if ($key === 'id' && $value === $shop_id) {
                    $isYoursShop = true;
                    return;
                }                    
            }
        } 
        
        if (!$isYoursShop) {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Not yours shop']);
            die();
        }    
    }

    static function getError($message, $code) {
        http_response_code($code);
        echo json_encode(['status' => 'error', 'message' => $message]);
        die();
    }

    public function readone() {
        self::checkAuth();

        if (!isset($_GET['id'])) {
            self::getError('id required', 400);
        } else {
            $id = $_GET['id'];
            if (!self::checkId($id)) {
                self::getError('id must be positive integer', 400);
            }
        }

        try {

            $employee = $this->model('employee');
            $empl = $employee->get_employee($id);

            if ($empl) {
                $this->chechShop($empl['shop_id']);

                echo json_encode(['status' => 'success', 'employee' => $empl, 'message' => '']);
                return;
            } else {
                self::getError('employee not found', 404);
            }           

        } catch (Exception $e) {
            self::getError($e->getMessage(), $e->getCode());
        }        
    }

    public function readlist() {
        self::checkAuth();

        if (!isset($_GET['shop_id'])) {
            self::getError('shop_id required', 400);
        } else {
            $shop_id = $_GET['shop_id'];
            if (!self::checkId($shop_id)) {
                self::getError('shop_id must be positive integer', 400);
            }

            $page = $_GET['page'] ? $_GET['page'] : '1';
            if (!self::checkId($page)) {
                self::getError('page must be positive integer', 400);
            }
        }

        try {

            $employee = $this->model('employee');

            $this->chechShop($shop_id);
            
            $employes = $employee->get_list($shop_id, $page - 1);

            echo json_encode(['status' => 'success', 'employes' => $employes, 'message' => '']);

        } catch (Exception $e) {
            self::getError($e->getMessage(), $e->getCode());
        }        
    }

    public function create() {
        self::checkAuth();

        $requiredFields = ['position', 'person_id', 'shop_id'];
        foreach ($requiredFields as $key) {
            if (!array_key_exists($key, $_POST)) {
                self::getError($key . ' required', 400);
            }
        }

        $position = $_POST['position'];
        if (!self::checkPosition($position)) {
            self::getError('position must be safety string less then 256 symbols', 400);
        }
        $person_id = $_POST['person_id'];
        if (!self::checkId($person_id)) {
            self::getError('person_id must be positive integer', 400);
        }
        $shop_id = $_POST['shop_id'];
        if (!self::checkId($shop_id)) {
            self::getError('shop_id must be positive integer', 400);
        }

        try {

            $employee = $this->model('employee');

            $this->chechShop($shop_id);
            
            $res = $employee->create($position, $person_id, $shop_id);

            if ($res) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'employee created cuccess']);
                return;
            } else {
                self::getError('Error creating employee', 400);
            }            

        } catch (Exception $e) {
            self::getError($e->getMessage(), $e->getCode());
        }  
    }

    public function update() {
        self::checkAuth();

        $requiredFields = ['position', 'id'];
        foreach ($requiredFields as $key) {
            if (!array_key_exists($key, $_POST)) {
                self::getError($key . ' required', 400);
            }
        }

        $position = $_POST['position'];
        if (!self::checkPosition($position)) {
            self::getError('position must be safety string less then 256 symbols', 400);
        }
        $id = $_POST['id'];
        if (!self::checkId($id)) {
            self::getError('id must be positive integer', 400);
        }

        try {

            $employee = $this->model('employee');

            $empl = $employee->get_employee($id);
            if (!$empl) {
                self::getError('employee not found', 404);
            }

            $this->chechShop($empl['shop_id']);

            $res = $employee->update($id, $position);
            if ($res) {
                echo json_encode(['status' => 'success', 'message' => 'employee updated success']);
                return;
            } else {
                self::getError('Error updating employee', 400);
            }                       

        } catch (Exception $e) {
            self::getError($e->getMessage(), $e->getCode());
        } 
    }

    public function delete() {
        self::checkAuth();

        if (!isset($_POST['id'])) {
            self::getError('id required', 400);
        } else {
            $id = $_POST['id'];
            if (!self::checkId($id)) {
                self::getError('id must be positive integer', 400);
            }           
        }

        try {

            $employee = $this->model('employee');
            $empl = $employee->get_employee($id);

            if (!$empl) {
                self::getError('employee not found', 404);
            }

            $this->chechShop($empl['shop_id']);

            $res = $employee->delete($id);
            if ($res) {
                http_response_code(204);
            } else {
                self::getError('Error deleting employee', 400);
            }             

        } catch (Exception $e) {
            self::getError($e->getMessage(), $e->getCode());
        } 
    }

}