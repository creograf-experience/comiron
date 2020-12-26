<?php
    $this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php

if(isset($vars['shop']['id'])){	
	$this->template('shop/shop_info.php', $vars);
}else{
	$this->template('central/central_info.php', $vars);
}
?>
</div>
<div id="profileRight">
<?php
if(isset($vars['shop']['id'])){
	$this->template('shop/shop_right.php', $vars);
}else{
	$this->template('central/central_right.php', $vars);	
}
?>
</div>
<div id="profileContent">
<?php 
if(isset($vars['shop']['id'])){
	$this->template('shop/shop_center.php', $vars);
}else{
	$this->template('central/topheader.php', $vars);
}?>

<div class="header"><?php echo $this->t('central','Search result'); ?></div>


<?php    foreach ($vars['products'] as $shop) { 
	echo "<div class=\"body clearfix\">";
	if(!isset($vars['shop']['id'])){
		$this->template('shop/shop_index.php', $shop); 
	}
	if(isset($shop['products'])){
		$shop['person'] = $vars['person'];
		$this->template('shop/product.php', $shop); 
	} else{
		echo $this->t("shop", "products are hidden");
	}
	echo "</div>";
 } ?>
  
  <div style="clear: both"></div>
</div>
<?php 	$this->template('/common/footer.php'); ?> 