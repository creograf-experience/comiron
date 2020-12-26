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

/**
 * Function return language this user
 * 
 * @param string $default default language
 * @param array $langs array allowable languages
 * @return array 
 */

function getBestMatch($langs)
{
    
    $accept_language = array(); // array values of SERVER
    $accept_language_value = array(); // array, where value "q" = 1
    // Write in array value of global array SERVER
    if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
        if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
            $accept_language = array_combine($list[1], $list[2]);
            foreach ($accept_language as $n => $v)
                $accept_language[$n] = $v ? $v : 1;
            arsort($accept_language, SORT_NUMERIC); // Sorting desc value "q" 
        }
    }
    
    //print_r($accept_language);
    // select key of array $accept_language, where value = 1
    foreach ($accept_language as $l => $v) {
        $s = strtok($l, '-'); // remove something comes after a dash in the language of view "en-us, ru-ru"
        if ($v == 1) $accept_language_value[$s] = $v;
    }
    
    return $accept_language_value;

}
$langs = array('ru','en','it','ch');
// Call function definitions language of user
$lang = getBestMatch($langs);

$lang_default = 'en';

if(!empty($lang)) {
    $lang_this_browser = array_search(1, $lang);
    
    // if china language
    if($lang_this_browser=='zh') {
        $lang_default = 'ch';
        $_SESSION['lang'] = 'ch';
    } else {
        if(in_array($lang_this_browser, $langs)) { 
            $lang_default = $lang_this_browser;
            $_SESSION['lang'] = $lang_default;
        } else {
            $_SESSION['lang'] = $lang_default;
        }
    }
}


if(!isset($_SESSION['cur'])){
    $lang2cur = array(
		"ru"=>2,
		"en"=>1,
		"ch"=>4,
		"it"=>3,
		"es"=>3);
    $_SESSION['cur'] = $lang2cur[$_SESSION['lang']];
}

$config = array(
// Language to use, used for gettext / setenv LC_ALL
'language' => $lang_default,//'en_US',
'languages' => array('ru','en','it','ch', 'es'),//'en_US',
'file_upload_size_limit'=>'10MB',
'presscenters'=>array(
		"RU"=>1,
		"EN"=>2,
		"CH"=>3,
                "CN"=>3,
		"IT"=>4
		),//country=>person_id

// prefix of where partuza lives, empty means it's /
'web_prefix' => '',

// Container (formaly known as syndicator) to pass in the iframe (defaults to 'default')
// Note: your shindig config/container.js needs to match this key, so if you changed this to 'partuza'
// you need to edit container.js and change the container key there like:
// {"gadgets.container" : ["partuza"],
'container' => 'default',

// gadget server url
'gadget_server' => 'http://api.comiron.com',

// The url of this partuza instalation, including the (optional) web_prefix
'partuza_url' => 'http://comiron.com/',

// Max age of a security token, defaults to one hour
'st_max_age' => 60 * 60,

// Allow plain text tokens, disable this on live systems
'allow_plaintext_token' => true,

// Security token keys, this is a shared secret between shindig and partuza so make sure you set them to the same value in both
'token_cipher_key' => 'INSECURE_DEFAULT_KEY',
'token_hmac_key' => 'INSECURE_DEFAULT_KEY',

// MySql server settings
'db_host' => 'localhost',
'db_user' => 'root',
'db_passwd' => 'z1ayWnCp6g',
'db_database' => 'comiron',
'db_port' => '3306',

'data_cache' => 'CacheStorageFile',
// If you use CacheStorageMemcache as caching backend, change these to the memcache server settings
'cache_host' => 'localhost',
'cache_port' => 11211,
'cache_time' => 0,//24 * 60 * 60,

// If you use CacheStorageFile as caching backend, this is the directory where it stores the temporary files
// Right now you should set this to the same directory as shindig, else the cache invalidations won't
// apply to both shindig and partuza
'cache_root' => realpath(dirname(__FILE__)).'/../tmp/shindig',

// How many bytes each user can upload to partuza. It contains the files uploaded via the content uploading api
// and the partuza native upload  mechanism. Content uploading is disabled if it's removed or set to 0.
'upload_quota' => 50 * 1024 * 1024,

/* No need to edit the settings below in general, unless you modified the directory layout.
 * Note: On production systems it's faster to put absolute paths here instead of using these dynamicly generated ones
*/
'site_root' => realpath("/var/www/user/data/www/comiron.com/html"),
'library_root' => realpath(dirname(__FILE__) . "/../Library"),
'application_root' => realpath(dirname(__FILE__) . "/../Application"),
'views_root' => realpath(dirname(__FILE__) . "/../Application/Views"),
'models_root' => realpath(dirname(__FILE__) . "/../Application/Models"),
'controllers_root' => realpath(dirname(__FILE__) . "/../Application/Controllers"),
'i18n_root' => realpath(dirname(__FILE__) . "/../Application/i18n"),

'mail_from'=>"no-reply@comiron.com",
'mail_password'=>"ksX95tkv",
'imageMaxWidth'=>"1200",
'imageMaxHeight'=>'550',
'news_edit_time'=>3*60*60,//редактировать новость только первые 3 часа
'online_time'=>15*60*60, //пользователь онлайн 15 минут после загрузки последней страницы
'currency'=>1, //id валюты по-умолчанию
'shop_access_types'=>array(
		'0'=>'ACCESS_ALL',
		'1'=>'ACCESS_COMIRON',
		'2'=>'ACCESS_CLIENT',
		'3'=>'ACCESS_NONE',
		'4'=>'ACCESS_GROUP',
		'5'=>'ACCESS_DEFAULT',
		),
"comiron delivery mail"=>"anton.galleon@gmail.com",
"counters"=>"
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'wAHmCcfIAk';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        
          ga('create', 'UA-20533230-9', 'auto');
            ga('send', 'pageview');
            
            </script>
<!-- Yandex.Metrika counter -->
<script type=\"text/javascript\">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter27349502 = new Ya.Metrika({
                    id:27349502,
                    clickmap:true,
                    trackLinks:true,
            	    accurateTrackBounce:true,
                    webvisor:true
    		});
            } catch(e) { }
    });
                                                                                                                                                                                
                                                                                                                                                                                        var n = d.getElementsByTagName(\"script\")[0],
                                                                                                                                                                                                    s = d.createElement(\"script\"),
                                                                                                                                                                                                                f = function () { n.parentNode.insertBefore(s, n); };
                                                                                                                                                                                                                        s.type = \"text/javascript\";
                                                                                                                                                                                                                                s.async = true;
                                                                                                                                                                                                                                        s.src = \"https://mc.yandex.ru/metrika/watch.js\";
                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                if (w.opera == \"[object Opera]\") {
                                                                                                                                                                                                                                                            d.addEventListener(\"DOMContentLoaded\", f, false);
                                                                                                                                                                                                                                                                    } else { f(); }
                                                                                                                                                                                                                                                                        })(document, window, \"yandex_metrika_callbacks\");
                                                                                                                                                                                                                                                                        </script>
                                                                                                                                                                                                                                                                        <noscript><div><img src=\"https://mc.yandex.ru/watch/27349502\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript>
                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                        <!-- /Yandex.Metrika counter -->


",

"sb_login"=>"comiron_express-api",
"sb_password"=>"032829Ta",
"sb_pay"=>"https://securepayments.sberbank.ru/payment/merchants/comiron/payment_ru.html",	
"sb_error"=>"https://securepayments.sberbank.ru/payment/merchants/comiron/errors_ru.html",	
"sb_register"=>"https://securepayments.sberbank.ru/payment/rest/register.do",
"server_as_api" => 1,
"DPDprocent"=>10,
"cookie_domain"=>".comiron.com",
"RUPOSTprocent"=>2.5,
'site_root_avito' => realpath("/var/www/user/data/www/comiron.com/html/Avito"),
"testmail"=>"creograf@gmail.com",
);
