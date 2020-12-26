<?php $this->template('/common/header.php', $vars); ?>
<div id="profileInfo">
<?php
	if(isset($vars['shop']['is_owner']) and $vars['shop']['is_owner']){ 
		$this->template('shop/myshop_info.php', $vars);
	}else{
		$this->template('profile/profile_info.php', $vars);
	}
?>
</div>
<div id="profileRight">
<?php $this->template('shop/myshop_right.php', $vars);?>
</div>

<div id="profileContentWide">
<?php
if (isset($vars['error_message']) and $vars['error_message']) {
	echo "<div class=\"ui-state-error\" style=\"margin-bottom:20px;margin-top:10px;margin-right:14px;padding:20px;\">{$vars['error_message']}</div>";
}
?>
<?php
if(isset($vars['shop']['is_owner']) and $vars['shop']['is_owner']){ 
	$this->template('shop/shop_center.php', $vars);
	$this->template('shop/edit.php', $vars);//TODO заменить на новости или стену
}
?>

</div>
<?php
$this->template('/common/footer.php');
?>