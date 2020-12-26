<?php

require "config.php";
require "/var/www/user/data/www/comiron.com/Library/PartuzaConfig.php";

require_once("/var/www/user/data/www/comiron.com/Library/exchangeratescbrf.php");
require_once("/var/www/user/data/www/comiron.com/Library/Database.php");

$db = new DB(PartuzaConfig::get('db_host'), PartuzaConfig::get('db_port'), PartuzaConfig::get('db_user'), PartuzaConfig::get('db_passwd'), PartuzaConfig::get('db_database'), false);


#echo date("Y-m-d");
$rates = new ExchangeRatesCBRF(date("Y-m-d"));
echo var_dump($rates->GetRates());

	//список валют
	$res = $db->query("select id, code from `currency`");
  	if (! $db->num_rows($res)) {
  		return null;
  	}
	while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
  		$curs[]=$data;  		
  	}
  	  	
  	//курсы
  	foreach($curs as $cur1){
  		foreach($curs as $cur2){
  			if($cur1['code'] == "RUR" and $cur2['code'] == "RUR"){
  				$rate=1;
  			}else if($cur1['code'] == "RUR"){
  				$rate = $rates->GetRate($cur2['code']);
  			}else if($cur2['code'] == "RUR"){
  				$rate = 1 / $rates->GetRate($cur1['code']);
  			}else{
  				$rate = $rates->GetCrossRate($cur1['code'], $cur2['code']);
  			}
  			$rate = 1/$rate;
  			$rate*=1.01;
  			
  				//print $cur1['id']." -> ".$cur2['id']." = ".$rate."\n";
  			print $cur1['code']." -> ".$cur2['code']." = ".$rate."\n";
  			$db->query("replace `currencyconv` (`from`, `to`, `koef`) values (".$cur1['id'].", ".$cur2['id'].", ".$rate.")");
  		}
  	}
  	
?>