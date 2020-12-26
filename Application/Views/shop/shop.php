<?php $this->template('/common/header.php', $vars); ?>
<div id="profileInfo">
<?php $this->template('shop/shop_info.php', $vars);?>
</div>
<div id="profileRight">
<?php $this->template('shop/shop_right.php', $vars);?>
</div>

<div id="profileContent">
<?php $this->template('shop/shop_center.php', $vars);?>

<div class="header"><?php echo $this->t('shop','Special offers'); ?></div>
<div class="body clearfix" style="float:left;">	
<?php $this->template('shop/product.php', $vars);?>
</div>

<div class="header"><?php echo $this->t('shop','News'); ?></div>
	<?php
$this->template('shop/news_index.php', $vars);
?>

<?php
if (! empty($_SESSION['message'])) {
  echo "<b>{$_SESSION['message']}</b><br /><br />";
  unset($_SESSION['message']);
}

?>

</div>
<?php
$this->template('/common/footer.php');
?>