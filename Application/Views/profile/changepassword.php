<?php $this->template('/common/header.php', $vars);

if (isset($vars['error'])) {
	echo "<div class=\"ui-state-error\" style=\"margin-bottom:20px;margin-top:10px;margin-right:14px;padding:20px;\">{$vars['error']}</div>";
}
?>


<?php if(isset($vars['code'])){ ?>
<div class="topheader"><center>
<?php echo $this->t('common', 'set_new_password');?>
</center></div>
<div class="body">

<br><br>
<center><form action="/profile/setnewpassword" method="POST">
<input type="hidden" name="code" value="<?php echo $vars['code']?>">

<div class="form_entry">
<div class="form_label"><label for="register_password"><?php echo $this->t('common','email'); ?></label></div>
<input type="email" readonly name="email" required id="email" value="<?php echo $vars['person']['email']; ?>" />
</div>

<div class="form_entry">
<div class="form_label"><label for="register_password"><?php echo $this->t('common','password'); ?></label></div>
<input type="password" name="register_password" required id="register_password" />
<div id="password_status" class="password_status"></div>
</div>

<div class="form_entry">
<div class="form_label"><label for="register_password2"><?php echo $this->t('common','password again'); ?></label></div>
<input type="password" name="register_password2" required id="register_password2" />
</div>

<div style="width:400px;float:left"><input class="submit" type="submit" value="<?php echo $this->t('common','save'); ?>" /></div>


</form></center>
</div>

<?php } ?>

<br><br><br><br><br><br><br><br>
<?php $this->template('/common/footer.php', $vars); ?>
