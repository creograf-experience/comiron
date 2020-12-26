<div id="small_cart">
<?php $this->template('central/small_cart.php', $vars);?>
</div>

<?php $this->template('central/adv.php', $vars);?>

<?php

if((!isset($vars['person']['has_shop']) or !$vars['person']['has_shop']) and (!isset($vars['is_owner']) or $vars['is_owner'] != 1)){ ?>	
	<div class="header"><?php echo $this->t('central','Create e-shop'); ?></div>
	<div class="clearfix"><div class="content">
	<p>
	<?php echo $this->t('central','create_shop_text'); ?>
	</p>
		<a  class="btn" href="/shop/create/"><?php echo $this->t('central','Create'); ?></a>
	</div></div>
<?php 
}

  ?>


