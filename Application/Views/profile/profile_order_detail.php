<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);
?>

<div id="profileInfo" class="blue">
<?php $this->template('profile/profile_info.php', $vars); ?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('common/right.php', $vars);?>
</div>

<div id="profileContentWide">

	<?php $this->template('profile/topheader.php', $vars); ?>
	<div class="header"><?php echo $this->t('shop','Orders'); ?></div>

	<?php
}
?>
<div class="icons"><span><a class="back" href="/profile/orders/<?php echo $_SESSION['id']?>"><?php echo $this->t('shop','back to order list'); ?></a></span></div>

<?php 
$this->template('profile/order_index.php', $vars);
$this->template('profile/order_detail_index.php', $vars);
?>

</div>

<?php 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/footer.php'); 
}?>