<?php
$thumb = $vars['shop']['thumbnail_big_url'];
if (!$thumb) {
  $thumb = '/images/shop/nophoto205.gif';
}
?><a class="avatar" href="/shop/<?php echo $vars['shop']['id']?>" rel="me"><img src="<?php echo $thumb?>" /></a>

<div class="look_shop"><a href="/shop/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop','Look shop') ?></a></div>

<?php if($vars['shop']['is_owner']){ ?>
<div class="header"><?php echo $this->t('shop', 'Shop')?></div>
<ul class="profileMenu">
<li><table class="markup"><tr><td><a href="/shop/myshop"><?php echo $this->t('shop', 'Edit shop info')?></a></td><td class="dots"></td><td></td></tr></table></li>

<li class="articles"><table class="markup"><tr><td><a href="/shop/myarticles/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Menu')?></a></td><td class="dots"></td><td>
<?php echo $vars['shop']['articles_num'] ?>
</td></tr></table></li>

<li class="banners"><table class="markup"><tr><td><a href="/shop/mybanners/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Banners')?></a></td><td class="dots"></td><td>

</td></tr></table></li>

<!-- li class="groups"><table class="markup"><tr><td><a href="/shop/mygroups/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Groups')?></a></td><td class="dots"></td><td>
<?php echo $vars['shop']['groups_num'] ?>
</td></tr></table></li-->

<li class="products"><table class="markup"><tr><td><a href="/shop/myproducts/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Products')?></a></td><td class="dots"></td><td>
<?php echo $vars['shop']['products_num'] ?>
</td></tr></table></li>

<li class="orders"><table class="markup"><tr><td><a href="/shop/orders/<?php echo $vars['shop']['id']?>?orderstatus_id=1"><?php echo $this->t('shop','Orders'); ?></a></td><td class="dots"></td><td>

<?php
  if(isset($vars['shop']['orders_num']) and $vars['shop']['orders_num']['new']>0){
  	echo "<span class=\"highlight\">".$vars['shop']['orders_num']['new']."</span>";
  }else if(isset($vars['shop']['orders_num']) and $vars['shop']['orders_num']['total']>0){
   	echo $vars['shop']['orders_num']['total'];
  }
?>
</td></tr></table></li>


<li class="news"><table class="markup"><tr><td><a href="<?php echo PartuzaConfig::get("web_prefix")?>/shop/news/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'News')?></a></td><td class="dots"></td><td>

<?php 
  if(isset($vars['shop']['messages_num']) and $vars['shop']['news_num']['unread']>0){
  	echo "<span class=\"highlight\">".$vars['shop']['news_num']['unread']."</span>";
  }else if(isset($vars['shop']['news_num']) and $vars['shop']['news_num']['read']>0 and !$vars['shop']['is_owner']){
   	echo $vars['shop']['news_num']['read'];
  }
?>

</td></tr></table></li>

<li class="news"><table class="markup"><tr><td><a href="/shop/myusergroups/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'User Groups')?></a></td><td class="dots"></td><td>
<?php if(isset($vars['shop']['usergroups_num'])) { echo $vars['shop']['usergroups_num']; } ?>
</td></tr></table></li>

<li class="news"><table class="markup"><tr><td><a href="/shop/mydeliverybalance/"><?php echo $this->t('shop', 'delivery_balance')?></a></td><td class="dots"></td><td>
</td></tr></table></li>


<li class="friends"><table class="markup"><tr><td><a href="<?php echo PartuzaConfig::get("web_prefix")?>/shop/clients/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Clients')?></a></td><td class="dots"></td><td>
<?php 
	if(isset($vars['shop']['client_requests_num']) and $vars['shop']['client_requests_num']>0){
		echo "<span class=\"highlight\">".$vars['shop']['client_requests_num']."</span>";
	}else if(isset($vars['shop']['client_num']) and $vars['shop']['client_num']>0){
		echo $vars['shop']['client_num'];
	}
?>
</td></tr></table></li>
<?php
} 
?>

<div class="header"><?php echo $this->t('shop', 'Organization')?></div>

<li class="friends"><table class="markup"><tr><td><span class="notworking" href="/shop/workers"><?php echo $this->t('shop', 'Workers')?></span></td><td class="dots"></td><td>
</td></tr></table></li>

<?php
if ($vars['shop']['is_owner']) {
  echo "<li class=\"messages\"><table class=\"markup\"><tr><td><a href=\"" . PartuzaConfig::get("web_prefix") . "/shop/messages\">".$this->t('shop', 'Messages')."</a></td><td class=\"dots\"></td><td>";
  if(isset($vars['shop']['messages_num']) and $vars['shop']['messages_num']['unread']>0){
  	echo "<span class=\"highlight\">".$vars['shop']['messages_num']['unread']."</span>";
  }else if(isset($vars['shop']['messages_num']) and $vars['shop']['messages_num']['read']>0){
    	echo $vars['shop']['messages_num']['read'];
  }
  echo "</td></tr></table></li>\n";
}
?>
<li class="calendar"><table class="markup"><tr><td><span class="notworking" href="<?php echo PartuzaConfig::get("web_prefix")?>/profile/calendar/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Calendar')?></span></td><td class="dots"></td><td>&nbsp;</td></tr></table></li>
</ul>

<?php
//список друзей 
if (!$vars['shop']['is_owner']) {
	echo "<div class=\"header\">".$this->t('shop', 'Friends')."</div><div class=\"body clearfix\">";
	foreach($vars['shop']['friends'] as $friend){
		echo "<div class=\"itemphoto\">";
		echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">";
	    if($friend['thumbnail_url']){
    		echo "<img src=\"{$friend['thumbnail_url']}\">";
    	}else{
	    	echo "<img src=\"/images/people/nophoto.gif\">";
	    }
		echo "</a></div><div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
		echo "</div>";
	}
	echo "</div>";
} 
?>
