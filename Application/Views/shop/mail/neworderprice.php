<pre>
<?php echo $this->t('shop','New price order in ').$vars['shop']['name']?>:
<?php
echo $this->t('shop','Product ID')."\t".$this->t('shop','Product Name')."\t".$this->t('shop','Price')."\t".$this->t('shop','Count')."\t".$this->t('shop','Sum')."\n";
	if(isset($vars['cart'])){
		foreach ($vars['cart']['cart'] as $cart) {
		  echo $cart['product']['id']."\t".$cart['product']['name']."\t".$cart['product']['price']."\t".$cart['num']."\t".$cart['sum']."\n";
		}
	}
?>

<?php
echo $this->t('shop','Total').":"; 
foreach($vars['small_cart'] as $small_cart){
	echo $small_cart['sum']." ".$small_cart['currency']['name'];	
}

echo "\n\n".$this->t('shop','Delivery').": ".$this->t('shop',"delivery by ".$vars['delivery']); 
if(isset($vars['phone'])){
	echo "\n".$this->t('profile','Phone').": ".$vars['phone'];
	
}
if(isset($vars['comment_person'])){
	echo "\n".$vars['comment_person'];
	
}


?>

Shop ID: <?php echo $vars['shop']['id']?> 
https://comiron.com/shop/<?php echo $vars['shop']['id']?>

Person ID: <?php echo $vars['person']['id']?> 
https://comiron.com/profile/<?php echo $vars['person']['id']?>
</pre>