<?php $this->template('/common/header.php', $vars);

if ($vars['error']) {
	echo "<div class=\"ui-state-error\" style=\"margin-bottom:20px;margin-top:10px;margin-right:14px;padding:20px;\">{$vars['error']}</div>";
}
?>

<div class="topheader"><center>
<?php echo $this->t('common', 'new_password_done');?>
</center></div>
<div class="body">

<br><br>
<?php echo $this->t('common', 'new_password_done_text');?>
<br><br><br><br><br><br><br><br>
</div>
<?php $this->template('/common/footer.php', $vars); ?>
