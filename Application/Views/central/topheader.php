<!--div class="topheader"><?php echo $this->t('common','Central Comiron'); ?></div-->
<div class="topinfo">
<form id="searchproduct" method="post" action="/central/searchproduct">
<?php
if(isset($vars['shop']['id'])){
	echo "<input type='hidden' name='shop_id' value='{$vars['shop']['id']}'>";
}
?>
<table class="markup"><tr><td>
<input type="text" id="product_name" name="name" placeholder="<?php echo $this->t('common','Search for products'); ?>" value="<?php if(isset($vars['searchproduct']['name'])) echo $vars['searchproduct']['name']?>">
</td><td>&nbsp;</td><td>
<select id="category_id" name="category_id">
<option value=""><?php echo $this->t('central','all'); ?></option>
<?php
if(isset($vars['categories']) and is_array($vars['categories'])){
	foreach ($vars['categories'] as $category) {
		echo "<option ".((isset($vars['searchproduct']['category_id']) and $category['id']==$vars['searchproduct']['category_id'])?" selected ":"")." value=\"{$category['id']}\">{$category['name']}</option>";
		if(isset($category['subs']) and is_array($category['subs'])){
			foreach ($category['subs'] as $subcategory) {
				echo "<option ".((isset($vars['searchproduct']['category_id']) and $subcategory['id']==$vars['searchproduct']['category_id'])?" selected ":"")." value=\"{$subcategory['id']}\">&nbsp;&nbsp;&nbsp;{$subcategory['name']}</option>";
			}	
		}	
	} 
}
?>
</select>
</td><td>&nbsp;</td><td>
<button type="submit" class="btn search" id="search_small"><?php echo $this->t('common','find'); ?></button>
</td></tr></table>
</form>
</div> 