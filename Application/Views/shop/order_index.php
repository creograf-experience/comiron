<div class="orders">
<?php

foreach ($vars['orders'] as $order) {
	    //$created = strftime('%m/%d/%y '.$this->t('common','in').' %H:%M', $news['created']);
	    $created=$this->formatdate($order['dataorder']);

        echo "<div class=\"item order_item\" id=\"order_{$order['id']}\">";
        echo "<div class=\"order_title_line\">";

        echo "<strong>".$this->t('shop', 'Order')." ".$this->t('common', '#')." {$order['id']}</strong> <a href=\"/shop/{$order['person_id']}\">{$order['name']}</a>";
        echo "<span class=\"date\">{$created}</span>";
        echo "</div>";
        echo "<div class=\"body \"><table class=\"markup order\"><tr><td>";
        	echo "<div class=\"photo\"><a href=\"/shop/{$order['shop_id']}\">";

    		if($order['thumbnail_url']){
    			echo "<img class=\"smallavatar\" src=\"{$order['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    		}
			echo "</a></div>";
			echo "</td><td>&nbsp;&nbsp;</td><td>";

			echo "<div class=\"price\">".$this->t('shop','Sum').": <span class=\"price\">{$order['sum']}</span>&nbsp;";
			if(isset($order['currency'])){
				echo "<span class=\"currency\">{$order['currency']['name']}</span>";
			}
			echo "</div>";

	    echo "<div class=\"price\">".$this->t('shop','Delivery').": <span class=\"price\">{$order['deliverycost']}</span>&nbsp;";
      if(isset($order['currency'])){
        echo "<span class=\"currency\">{$order['currency']['name']}</span>&nbsp; ";
      }
      echo $this->t('shop', $order['delivery'])." </div>";

  		echo "<div class=\"price\">".$this->t('shop', 'Count').": <span class=\"price\">{$order['num']}</span></div>";

			if(isset($order['address'])){
				echo "<div class=\"delivery\">".$this->t('shop', 'Delivery address').": {$order['address']}</div>";
			}

			echo "  <button class=\"btn editorder\" id=".$order['id'].">".$this->t("shop", "edit order")."</button>";

/*			if(!isset($vars['order']['details'])){
				echo "<div class=\"icons\"><span><a href=\"/shop/orders/get/{$order['id']}\" class=\"showdetails\">".$this->t('shop', 'show order details')."</a></span></div>";
			}
*/
/*			if ($order['person_id'] == $_SESSION['id']) {
				echo "<div class=\"x\">";
				if($order['created'] + PartuzaConfig::get('news_edit_time') > $_SERVER['REQUEST_TIME']){
					echo "<a href=\"#\" class=\"editnews\" title=\"{$this->t('profile','edit news')}\"  owner_id=\"{$news['person_id']}\" id=\"{$news['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a>";
				}
				echo "<a href=\"#\" class=\"removenewsfrom\" title=\"{$this->t('common','remove news')}\" from=\"{$news['from']}\" id=\"{$news['id']}\"><img src=\"/images/i_close.png\"></a></div>";
			}
*/

			if(!isset($var['orders']['details'])){
				echo "<br><div class=\"icons\"><span><a href=\"/shop/orders/get/{$order['id']}\" class=\"showdetails\">".$this->t('shop', 'show order details')."</a></span></div>";
				echo "<div class=\"products\">";
				foreach ($order['details'] as $detail) {
					if($detail['photo_url']){
   		 				echo "<div><a class=\"showdetails\" href=\"/shop/orders/get/{$order['id']}\"><img class=\"smallavatar\" src=\"{$detail['photo_url']}\"></a></div>";
   		 			}else{
    					echo "<div><a class=\"showdetails\" href=\"/shop/orders/get/{$order['id']}\"><img class=\"smallavatar\" src=\"/images/product/nophoto.gif\"></a></div>";
    				}
				}
				echo "</div>";
			}

			echo "</td><td>";
			echo "<div class=\"order_statuses\">";
			echo "<div class=\"order_status {$order['status']}\">".$this->t('shop',$order['status'])."</div>";
			echo "<div class=\"payed_status ".(($order['ispayed'])?"status_payed":"status_not_payed")."\">".(($order['ispayed'])?$this->t('shop','status_payed'):$this->t('shop','status_not_payed'))."</div>";

      if($order['delivery']=="dpd" and $order['terminal'] and $order['date_pickup'] and $order['city'] and !$order['deliverynum'] and $order['orderstatus_id']<3){
        echo "<div><a href=\"#\" class=\"send2dpd\" shop_id=\"{$order['shop_id']}\" id=\"{$order['id']}\">".$this->t('shop',"send2dpd")."</a></div>";
      }
      if($order['delivery']=="dpd" and $order['deliverynum'] and $order['orderstatus_id']==6){
        echo "<div><a href=\"/dpdru/sticker?id={$order['id']}&shop_id={$order['shop_id']}\" target=\"_blank\">".$this->t('shop',"download sticker")."</a></div>";
      }
      if($order['delivery']=="russiapost" and $order['rupost_pdf']){
        echo "<div><a href=\"{$order['rupost_pdf']}\" target=\"_blank\">".$this->t('shop',"rupost_pdf")."</a></div>";
      }

			echo "</div>";
			echo "</td></tr><tr><td colspan=\"4\">";
			echo "<div class=\"comment\">".$order['comment_person']."</div>";
			echo "<div class=\"comment\">".$order['comment_shop']."</div>";

			echo "</td></tr><tr><td colspan=\"4\">";
			echo "<div class=\"body\">";

			$order['object_name']="order";
			$this->template('like/comment_inline.php', $order);

			echo "</td></tr></table></div>";
			echo "</div>";
}
?>

<div class="pages">
<span class="p">
<?php
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/shop/order/{$vars['person']['id']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
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
