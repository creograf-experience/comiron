<?php echo $this->t('home','validate_email_test', array(
		"{first_name}"=>$vars['first_name'],
		"{last_name}"=>$vars['last_name']));

		if($vars['password']){
    	echo  "Password: ".$vars['password'];
		}
		
	  echo PartuzaConfig::get("partuza_url")."profile/activate?code=".$vars['activation_code'];
?>
