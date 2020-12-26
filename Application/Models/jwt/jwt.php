<?php


class jwtModel extends Model {


    public function check_refresh_jwt($jwt,$user_id,$time_gap){
        // Check expired refresh in db and return false or it
        global $db;
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        $expires_in = $timestamp + $time_gap;

        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";
        
        if(!$user_id) return $response_array;
 
        $select_refresh_token = "SELECT refresh_token FROM jwt_token 
                                WHERE id_person=$user_id and expires_in <= $expires_in and refresh_token='$jwt'";

        // var_dump($select_refresh_token);
        // die();
        $res = $db->query($select_refresh_token);
        $refresh_token = $db->fetch_array($res, MYSQLI_ASSOC);

        if ($db->num_rows($res)) {
            $response_array['message'] = "OK =>".__FUNCTION__." ";
            $response_array['state'] = true;
            $response_array['refresh_token'] = $refresh_token;
        } else{
            $for_developer['detail'] = "select_refresh_token query return nothing. Seems not match your jwt";
            $response_array['for_developer'] = $for_developer;
        }
        
          return $response_array;

    }


    public function update_refresh_jwt($jwt,$user_id,$time_gap){
        global $db;

        $response_array['state'] = false;
        $response_array['message'] = __FUNCTION__." return false... ";

        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        $expires_in = $timestamp + $time_gap;
        
        $insert_on_update = "INSERT INTO jwt_token (id_person, refresh_token, expires_in) 
                            VALUES ($user_id, '$jwt', $expires_in) 
                            ON DUPLICATE KEY UPDATE 
                            refresh_token=VALUES(refresh_token), expires_in=VALUES(expires_in)";

        $res = $db->query($insert_on_update);

        if($res){
            $response_array['refresh_token'] = $jwt;
            $response_array['message'] = "OK =>".__FUNCTION__." ";
            $response_array['state'] = true;

        } else{
            $response_array['details'] = $check_refresh_jwt;
        }

        
        return $response_array;
    }
}