<?php

use \Firebase\JWT\JWT;


class authController extends baseController {

    public function signin($params) {
        // This pic explain how JWT with refresh works https://ibb.co/hZ7mhJ or dev_img/2018-06-29-11-51-04.jpg

        // init_data
        $status_code = $this->set_status_code("Internal Server Error","500");
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];
        $pushtoken = $_POST['pushtoken'];

        // 1 hour to live access token & 30 days for refresh token
//        $access_token_time_gap = 60*60;
//        $refresh_token_time_gap = $access_token_time_gap*24*30;
        $access_token_time_gap = 60*60*24*31*12;
        $refresh_token_time_gap = $access_token_time_gap*24*31*12*5;
                
        $method_POST = $this->check_request_method("POST");

        if($method_POST['state']){
            $for_developer['log'] = $method_POST['message'];

            if (! empty($email) && ! empty($password)) {

                $login = $this->model('login');

                if (($user = $login->authenticate($email, $password)) !== false){
                    //save push token
                    if($pushtoken){
                      $people = $this->model('people');
                      $people->save_person($user['id'], array('pushtoken'=>$pushtoken));
                    }

                    // create access & refresh tokens

                    $jwt = $this->set_jwt_token($access_token_time_gap, $user['id']);
                    $jwt_refresh = $this->set_jwt_token($refresh_token_time_gap, $user['id']);


                    $jwt_model = $this->model('jwt');

                    $updated_jwt = $jwt_model->update_refresh_jwt($jwt_refresh,$user['id'],$refresh_token_time_gap);
                    $for_developer['log'] = $for_developer['log'].$updated_jwt['message'];

                    if($updated_jwt['state']){
                        $status_code = $this->set_status_code("OK","200");
                        $refresh_token = $updated_jwt['refresh_token'];
                    }else{
                        $for_developer['details'] = $updated_jwt;
                    }

                } else {
                    $status_code = $this->set_status_code("Wrong login or password","401");
                }
            } else {
                $status_code = $this->set_status_code("Empty one or more signin fields","400");
            }
        }else{
            $status_code = $method_POST;
        }


        $json_response['status'] = $status_code['status'];
        $json_response['code'] = $status_code['code'];
        $json_response['token'] = $jwt;
        $json_response['refreshToken'] = $refresh_token;
        $json_response['user'] = $user;
        $json_response['for_developer'] = $for_developer;

        echo json_encode($json_response);

    }
}
