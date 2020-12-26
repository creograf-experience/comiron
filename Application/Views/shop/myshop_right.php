<?php
if(isset($vars['person'])){
	 if((!isset($vars['person']['has_shop']) or !$vars['person']['has_shop']) and (isset($vars['person']['has_organization']) or $vars['person']['has_organization'])){ ?>	
	<div class="header"><?php echo $this->t('central', 'Create e-shop') ?></div>
	<div class="clearfix"><div class="content">
	<p><?php echo $this->t('central', 'create_shop_text') ?></p>
		<a  class="btn" href="/shop/create/">
		<?php echo $this->t('central', 'Create') ?></a>
	</div></div>
<?php }  ?>

<?php  if(isset($vars['person']['has_shop']) and $vars['person']['has_shop']){ ?>	
	<div class="header">Statistics</div>
	<div class="clearfix"><div class="content">
	<p>Shop stat will be here</p>
	</div></div>
<?php } 
}
?>
