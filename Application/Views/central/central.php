<?php
$this->template('/common/header.php', $vars);
?>

<?php $this->template('central/action.php', $vars); ?>

<div id="profileInfo">
<?php
$this->template('central/central_info.php', $vars);
?>
</div>
<div id="profileRight">
<?php
	$this->template('central/central_right.php', $vars);
?>
</div>
<div id="profileContentRWide">
<?php $this->template('central/banners.php', $vars); ?>
<div class="header"><?php echo $this->t('common','central'); ?></div>
<?php $this->template('central/topheader.php', $vars); ?>

<!--div class="header"><?php echo $this->t('central','The most popular categories'); ?></div>
		<div class="body clearfix"-->		
<?php
/*
	if($vars['categories']){
		foreach ($vars['categories'] as $category) {
			if(!$category['ispopular'])  continue;
			$this->template('shop/index_category.php', $category);
		
			foreach ($category['subs'] as $subcategory) {
				if(!$subcategory['ispopular'])  continue;
				$this->template('shop/index_category.php', $subcategory);
			}
		}
	}
	*/
?>
	<!--/div-->

<div class="header"><?php echo $this->t('central','Shopping Malls'); ?></div>
	<div class="body clearfix popular_shops">
<?php
if(isset($vars['malls']) && is_array($vars['malls'])){
	foreach ($vars['malls'] as $shop) {
        echo "<div class=\"category_item\">";
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/shop/{$shop['id']}\">";
    
    		if($shop['thumbnail_url']){
    			echo "<img src=\"{$shop['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/shop/nophoto.gif\">";
    		}

    		echo "</a></div>";
			echo "<div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/shop/{$shop['id']}\">{$shop['name']}</a></div>";
			
    	echo "</div>";
	}
}	
?>			
	</div>
	
	

<div class="header"><?php echo $this->t('central','Comiron bestselling'); ?></div>
<div class="body clearfix"  id="productbody">
	<?php 

	$this->template('shop/product.php', $vars); ?>
</div>

</div>
</div>

<?php $this->template('/common/footer.php', $vars); ?>