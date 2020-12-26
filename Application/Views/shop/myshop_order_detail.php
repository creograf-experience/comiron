<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);
?>

<div id="profileInfo" class="blue">
<?php $this->template('shop/myshop_info.php', $vars); ?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('shop/myshop_right.php', $vars);?>
</div>

<div id="profileContentWide">

	<?php $this->template('shop/topheader.php', $vars); ?>
	<div class="header"><?php echo $this->t('shop','Orders'); ?></div>

	<?php
}
?>
<div class="icons"><span><a href="/shop/orders/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop','back to order list'); ?></a></span></div>

<?php 
$this->template('shop/order_index.php', $vars);

$this->template('shop/order_detail_index.php', $vars);

?>


<?php 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/footer.php'); 
}?>