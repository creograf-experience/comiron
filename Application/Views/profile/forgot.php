<?php $this->template('/common/header.php', $vars); ?>

<?php if(!isset($_GET['email'])){ ?>
<div class="topheader"><center>
<?php echo $this->t('common', 'forgot_email');?>
</center></div>
<div class="body">
<?php echo $this->t('common', 'forgot_email_text');?>
<br><br>
<center><form action="/profile/forgot">
<table class="form"><tr><td>
<label><?php echo $this->t('common', 'email');?>:</label>
</td><td>&nbsp;&nbsp;</td><td>
<input type="email" name="email">
</td><td>&nbsp;&nbsp;</td><td>
<button type="submit" class="btn"><?php echo $this->t('common', 'send');?></button>
</td></tr></table>
</form></center>
</div>

<?php } else {

	if($vars['is_send']){
		?>
		<div class="topheader"><center><?php echo $this->t('common', 'hello') . $vars['person']['first_name'] . "!" ?></center></div>
		<div class="body"><p><?php echo $this->t('common', 'email_was_send', array("{email}"=>$vars['person']['email']));  ?></p></div>
		<?php 
	}else{
		?>
		<div class="topheader"><center><?php echo $this->t('common', 'forgot_email');?></center></div>
		<div class="body"><p><?php echo $this->t('common', 'email_was_not_send', array("{email}"=>$vars['person']['email']));  ?></p></div>
		<?php 
	}

} ?>

<br><br><br><br><br><br><br><br>
<?php $this->template('/common/footer.php', $vars); ?>
