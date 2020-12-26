<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo"><?php $this->template('profile/profile_info.php', $vars); ?></div>

<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('shop','Create shop for free')?></div>
<div class="form clearfix1">
<form method="post" enctype="multipart/form-data" action="/shop/createshopandorg">

	<div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','Name')?></label></div>
    <input type="text" name="name" id="name"
    	value="<?php echo isset($vars['organization']['name']) ? $vars['organization']['name'] : ''?>" />
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="fullname"><?php echo $this->t('shop','Full name')?></label></div>
    <input type="text" name="fullname" id="fullname"
    	value="<?php echo isset($vars['organization']['fullname']) ? $vars['organization']['fullname'] : ''?>" />
    </div>

    <!-- div class="form_entry">
    <div class="form_label"><label for="start_date"><?php echo $this->t('shop','Creation date')?></label></div>
    <input type="text" name="start_date" id="start_date" class="datepicker"
    	value="<?php echo isset($vars['organization']['start_date']) ? $vars['organization']['start_date'] : ''?>" />
    </div-->

    <div class="form_entry">
    <div class="form_label"><label for="admin_email"><?php echo $this->t('shop','Administrator email')?></label></div>
    <input type="email" name="admin_email" id="admin_email"
    	value="<?php echo isset($vars['shop']['admin_email']) ? $vars['shop']['admin_email'] : ''?>" />
    </div>
    
    
    <div class="form_entry">
    <div class="form_label"><label for="organizationcategory_id"><?php echo $this->t('shop','Busness category')?></label></div>
    <select name="organizationcategory_id" id="organizationcategory_id">
    	<option value="0">-</option>
    	<?php 
    	foreach ($vars['organization_category'] as $c) {
    		echo "<option value=\"{$c['id']}\">".$c['name']."</option>\n";
    	    foreach ($c['subrecords'] as $sub) {
    			echo "<option value=\"{$sub['id']}\">&nbsp;&nbsp;&nbsp;".$sub['name']."</option>\n";
    		} 
    	} 
    	?>
    </select></div>


    <div class="form_entry">
    <div class="form_label"></div>
    <p class="agreement"><?php echo $this->t('shop','create_shop_agreement')?>
    </p>
    </div>

    <div class="form_entry">
    <div class="form_label"></div>
	<button type="submit" class="btn submit"><?php echo $this->t('shop','create shop')?></button>
	</div>
  </form>
  </div>
    
</div>

<?php
$this->template('/common/footer.php');
?>