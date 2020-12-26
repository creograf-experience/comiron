<?php $this->template('/common/header.php', $vars); ?>
<br><br><br><br><br>
<div class="topheader"><center>
<?php if($vars['is_activated']){
	echo $this->t('common', 'activated_ok');
}else{
	echo $this->t('common', 'activated_fail');	
} ?>
</center></div>
<br><br><br><br><br>
<?php $this->template('/common/footer.php', $vars); ?>
