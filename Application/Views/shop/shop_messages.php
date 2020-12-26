<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php

	if(isset($vars['shop']['is_owner'])){ 
		$this->template('shop/myshop_info.php', $vars);
	}else{
		//$this->template('profile/profile_info.php', $vars);
	}
?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('common/right.php', $vars);?>
</div>
<div id="profileContentWide">
<?php $this->template('shop/topheader.php', $vars); ?>
<div class="chat">
<div class="header"><?php echo $this->t('profile',"Messages");?></div>
<button id="messageComposeShop" class="funbutton"><?php echo $this->t('profile',"Compose message");?></button>


<?php $this->template('shop/mperson_index.php', $vars); ?>

  
</div>
<div style="clear: both"></div>
</div>
<?php
$this->template('/common/footer.php');
?>