<?php
// простая отправка запросов к API

function runREST($url, $method, $params = null){
	$domain = ""; //"http://galeon.creograf-dev.ru/api";
	$c = curl_init();
	curl_setopt($c,CURLOPT_CONNECTTIMEOUT,20);
//        curl_setopt($c,CURLOPT_HEADER,true);
        // curl_setopt($c,CURLOPT_NOBODY,true);
        curl_setopt($c,CURLOPT_RETURNTRANSFER,true);
	switch( $method ){
		case 'GET': {
			curl_setopt($c, CURLOPT_HTTPGET, true);
			if (!is_null($params)) {
				$query_string = "?" . http_build_query($params,'','&');
			}
			curl_setopt($c,CURLOPT_URL,  $domain . $url . $query_string);
			break;
		}
		case 'POST': {
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($c,CURLOPT_URL, $url);
			break;
		}
		case 'POST_JSON': {
			curl_setopt($c,CURLOPT_URL, $url);
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($params));
			curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			break;
		}
		case 'PUT': {
			curl_setopt($c, CURLOPT_CUSTOMREQUEST, "PUT");
#			curl_setopt($ch, CURLOPT_PUT, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
			curl_setopt($c, CURLOPT_URL, $domain . $url);
			break;
		}
		case 'DELETE': {
			curl_setopt($c, CURLOPT_CUSTOMREQUEST, "DELETE");
#			curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($params));
#			curl_setopt($c,CURLOPT_URL, $domain . $url);
			if (!is_null($params)) {
				$query_string = "?" . http_build_query($params,'','&');
			}
			curl_setopt($c,CURLOPT_URL,  $domain . $url . $query_string);

			break;
		}
	}

	$response = curl_exec($c);

	$data = $response ? $response : curl_error($c);
	curl_close($c);

	return $data;
}
?>
