<table class="orderdetails">
<tr>
	<th><?php echo $this->t('shop', 'Photo'); ?></th>
	<th><?php echo $this->t('shop', 'Code'); ?></th>
	<th><?php echo $this->t('shop', 'Product Name'); ?></th>
	<th><?php echo $this->t('shop', 'Price'); ?></th>
	<th><?php echo $this->t('shop', 'Count'); ?></th>
	<th><?php echo $this->t('shop', 'Sum'); ?></th>	
</tr>
<?php
foreach ($vars['order']['details'] as $order) {
			echo "<tr><td>";
    		if($order['photo_url']){
    			echo "<img class=\"smallavatar\" src=\"{$order['photo_url']}\">";
    		}else{
    			echo "<img class=\"smallavatar\" src=\"/images/product/nophoto.gif\">";
    		}
    		echo "</td><td>".$order['code'];
			echo "</td><td>".$order['product_name'];
			echo "</td><td>".$order['price']." ".$order['currency']['name'];
			echo "</td><td>".$order['num'];
			echo "</td><td>".$order['sum'];
			echo "</td></tr>";
}
?>
 <tr><td colspan="6"  class="pages">
<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/profile/order/{$vars['person']['id']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
	echo "<div id=\"totalpages\">{$vars['totalpages']}</div>";
}
?>
</div>
</td></tr>

</table>
