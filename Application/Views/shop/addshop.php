<?php
/* не нужна больше, все в addorg */
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo"><?php $this->template('profile/profile_info.php', $vars); ?></div>

<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('shop','Create shop for free')?></div>
<div class="form clearfix">
<form method="post" enctype="multipart/form-data" action="/shop/create_shop">
	<div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','Name')?></label></div>
    <input type="text" name="name" id="name"
    	value="<?php echo isset($vars['shop']['name']) ? $vars['shop']['name'] : ''?>" />
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="admin_email"><?php echo $this->t('shop','Administrator email')?></label></div>
    <input type="email" name="admin_email" id="admin_email"
    	value="<?php echo isset($vars['shop']['admin_email']) ? $vars['shop']['admin_email'] : ''?>" />
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="order_email"><?php echo $this->t('shop','Order email')?></label></div>
    <input type="email" name="order_email" id="order_email"
    	value="<?php echo isset($vars['shop']['order_email']) ? $vars['shop']['order_email'] : ''?>" />
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="organization_id"><?php echo $this->t('shop','Organization')?></label></div>
    <select name="organization_id" id="organization_id">
    	<?php 
    	if($vars['organization']['id']){
    		echo "<option value=\"{$vars['organization']['id']}\">".$vars['organization']['name']."</option>\n";
    	}
    	foreach ($vars['myorganizations'] as $c) {
    		echo "<option value=\"{$c['id']}\">".$c['name']."</option>\n";
    	} 
    	?>
    </select></div>

    <div class="form_entry">
    <div class="form_label"></div>
    <?php echo $this->t('shop','create_shop_agreement')?>
    
    </div>

    <div class="form_entry">
    <div class="form_label"></div>
	<button type="submit" class="btn"><?php echo $this->t('shop','create shop')?></button>
    </div>
  </form>
  </div>
    
</div>

<?php
$this->template('/common/footer.php');
?>