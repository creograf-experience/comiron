<?php
if(isset($vars['shop']['cart'])){
	echo "<div class=\"header\">".$this->t('central','Shopping cart')."</div>";
	foreach($vars['shop']['cart'] as $cart){
		if(isset($cart['sum']) and $cart['sum']>0){
?>
<div class="cart">
	<table class="markup">
	<tr><td><div><?php echo $this->t('shop','items'); ?>: </td><td><span><?php echo $cart['items']?></span></div></td></tr>
	<tr><td><div><?php echo $this->t('shop','sum'); ?>: </td><td><span><?php echo $cart['sum']." ". $cart['currency']['name']?></span></div></td></tr>
	</table>	
</div>	
<?php
		}
	} 	
	
?>
	<center><a class="btn" href="/shop/cart/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop','Proceed to checkout'); ?></a></center>
<?php 	
}
?>
 