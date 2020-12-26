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

<div class="header"><?php echo $this->t('shop','Thank you!'); ?></div>

<div class="body">		
<p><br><?php echo $this->t('shop','You order was send successfuly.'); ?></p>

</div>



  <div style="clear: both"></div>
</div>
<?php 	$this->template('/common/footer.php'); ?>