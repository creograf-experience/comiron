<?php

class testController extends baseController {

    public function test($params) {
        echo "Hooray! Controller is working!";
        print_r($params);
    }
}
