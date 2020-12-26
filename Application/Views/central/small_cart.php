
<?php
if(isset($vars['cart'])){
	echo "<div class=\"header\">".$this->t('central','Shopping cart')."</div>";
	foreach($vars['cart'] as $cart){
		if(isset($cart['sum']) and $cart['sum']>0){
?>
<div class="cart">
	<table class="markup">
	<tr><td colspan="2"><strong><?php echo $cart['shop']['name']?></strong></td></tr>
	<tr><td><div><?php echo $this->t('central','items'); ?>: </td><td><span><?php echo $cart['items']?></span></div></td></tr>
	<tr><td><div><?php echo $this->t('central','sum'); ?>: </td><td><span><?php echo $cart['sum']." ". $cart['currency']['name']?></span></div></td></tr>
	</table>	
</div>	
	<center><a class="btn" href="/shop/cart/<?php echo $cart['shop']['id']?>"><?php echo $this->t('central','Proceed to checkout'); ?></a></center>
<br>	
<?php
		}
	} 	
	
?>

<?php 	
}
?>
 