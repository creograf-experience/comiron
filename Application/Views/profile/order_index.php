<div class="orders">
<?php

foreach ($vars['orders'] as $order) {
	    //$created = strftime('%m/%d/%y '.$this->t('common','in').' %H:%M', $news['created']);
	    $created=$this->formatdate($order['dataorder']);

        echo "<div class=\"item order_item\" id=\"order_{$order['id']}\">";
        echo "<div class=\"order_title_line\">";
       		echo "<strong>".$this->t('shop', 'Order')." ".$this->t('common', '#')." {$order['id']}</strong>&nbsp;";
        	echo "<a href=\"/shop/{$order['shop_id']}\">{$order['shop_name']}</a>";
 	        echo "<span class=\"date\">{$created}</span>";
        echo "</div>";
        echo "<div class=\"body \"><table class=\"markup order\"><tr><td>";
        	echo "<div class=\"photo\"><a href=\"/shop/{$order['shop_id']}\">";
    
    		if($order['thumbnail_url']){
    			echo "<img class=\"shopavatar\" src=\"{$order['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"shopavatar\" src=\"/images/shop/nophoto.gif\">";
    		}
			echo "</a></div>";
			echo "</td><td>&nbsp;&nbsp;</td><td>";
			
			echo "<div class=\"price\">".$this->t('shop','Sum').": <span class=\"price\">{$order['sum']}</span>&nbsp;";
			if(isset($order['currency'])){
				echo "<span class=\"currency\">{$order['currency']['name']}</span>";
			}
			echo "</div>";
			
			echo "<div class=\"price\">".$this->t('shop', 'Count').": <span class=\"price\">{$order['num']}</span></div>";
			
			if(!isset($var['orders']['details'])){
				echo "<br><div class=\"icons\"><span><a href=\"/profile/orders/get/{$order['id']}\" class=\"showdetails\">".$this->t('shop', 'show order details')."</a></span></div>";
				echo "<div class=\"products\">";			
				foreach ($order['details'] as $detail) {
					if($detail['photo_url']){
   		 				echo "<div><a class=\"showdetails\" href=\"/profile/orders/get/{$order['id']}\"><img class=\"smallavatar\" src=\"{$detail['photo_url']}\"></a></div>";
   		 			}else{
    					echo "<div><a class=\"showdetails\" href=\"/profile/orders/get/{$order['id']}\"><img class=\"smallavatar\" src=\"/images/product/nophoto.gif\"></a></div>";
    				}
				}
				echo "</div>";
			}
			
			echo "</td><td>";
			echo "<div class=\"order_statuses\">";
			if(isset($order['status']) && $order['status']){
				echo "<div class=\"order_status {$order['status']}\">".$this->t('shop',$order['status'])."</div>";
			}
			echo "<div class=\"payed_status ".(($order['ispayed'])?"status_payed":"status_not_payed")."\">".(($order['ispayed'])?$this->t('shop','status_payed'):$this->t('shop','status_not_payed'))."</div>";
			//pay
			if(!$order['ispayed']){
			    echo "<a class=\"btn\" href=\"/profile/orders/pay/{$order['id']}\">".$this->t("shop", "pay")."</a><br>";
			}
			
			if(isset($order['isuserarchive']) && $order['isuserarchive']==="1"){
				echo "<a class=\"archive\" href=\"/profile/orders/unarchive/{$order['id']}\">".$this->t('shop', 'to unarchive')."</a>";
			}else{
				echo "<a class=\"archive\" href=\"/profile/orders/archive/{$order['id']}\">".$this->t('shop', 'to archive')."</a>";
			}

			if(!isset($order['orderstatus_id']) || $order['orderstatus_id']!=5){
				echo "<a class=\"btn orderdeny\" href=\"/profile/orders/deny/{$order['id']}\">".$this->t('shop', 'deny order')."</a>";
			}
			
			echo "</div>";
			echo "</td></tr><tr><td colspan=\"4\">";
			echo "<div class=\"comment\">".$order['comment_person']."</div>";
			echo "<div class=\"comment\">".$order['comment_shop']."</div>";
								
			echo "</td></tr><tr><td colspan=\"4\">";
			echo "<div class=\"body\">";
		
			$order['object_name']="order";
			$this->template('like/comment_inline.php', $order);
			echo "</div>";		
		echo "</td></tr></table></div>";
    	echo "</div>";
}
?>
 
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

</div>
