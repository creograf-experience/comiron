<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('shop/shop_info.php', $vars);
?>
</div>
<div id="profileContentWide">
<?php $this->template('shop/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('shop', 'Checkout'); ?></div>

<div class="body cart">		
<?php $this->template('shop/product_in_cart.php', $vars); ?>
</div>

  <div style="clear: both"></div>
</div>


<?php $this->template('/common/footer.php', $vars); ?>