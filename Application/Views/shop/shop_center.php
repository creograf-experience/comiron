<?php $this->template('shop/topheader.php', $vars); ?>

<?php $this->template('shop/banners.php', $vars); ?>



<div class="topinfo">
<form id="searchproduct" class="filter" action="/central/searchproduct/" method="post">
<input type="hidden" name="shop_id" value="<?php echo $vars['shop']['id']; ?>">

<table class="markup"><tr><td>
<input type="text" id="product_name" name="name" placeholder="<?php echo $this->t('shop', 'search for product')?>"
value="<?php if(isset($vars['searchproduct']['name'])) echo $vars['searchproduct']['name']; ?>">
</td><td>
<select id="category_id" name="category_id">
<option value=""><?php echo $this->t('common', 'all'); ?></option>
<?php

if(isset($vars['categories']) and is_array($vars['categories'])){
	foreach ($vars['categories'] as $category) {
		echo "<option ".((isset($vars['searchproduct']['category_id']) and $category['id']==$vars['searchproduct']['category_id'])?" selected ":"")." value=\"{$category['id']}\">{$category['name']}</option>";
		foreach ($category['subs'] as $subcategory) {
			echo "<option ".((isset($vars['searchproduct']['category_id']) and $subcategory['id']==$vars['searchproduct']['category_id'])?" selected ":"")." value=\"{$subcategory['id']}\">&nbsp;&nbsp;&nbsp;{$subcategory['name']}</option>";		
		}
	} 
}
?>
</select>
</td><td>
<button type="submit" class="btn submit search" id="search_small"><?php echo $this->t('common', 'find'); ?></button>
</td></tr></table>
</form>

</div>  