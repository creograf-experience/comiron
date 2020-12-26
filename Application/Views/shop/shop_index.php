<table class="markup shop_in_search">
<tr><td>
	<?php
	$thumb = $vars['shop']['thumbnail_big_url'];
	if (!$thumb) {
	  $thumb = '/images/shop/nophoto205.gif';
	}
	?><a class="avatar" href="/shop/<?php echo $vars['shop']['id']?>" rel="me"><img src="<?php echo $thumb?>" /></a>
</td><td>&nbsp;</td><td>
	<h2><?php echo $vars['shop']['name']; ?></h2>
	
	<div class="clearfix country">
	<?php
	
	
	if(isset($vars['person']) and $vars['shop']['country_content_code2'] and $vars['shop']['country_content_code2'] != $vars['person']['country_content_code2']){

		$country_content=$this->model('country_content');
   		$country=$country_content->get_country($vars['shop']['country_content_code2'], $this->get_cur_lang());
   		
		echo $this->t('shop','Original country').": <img src=\"/images/country/{$vars['shop']['country_content_code2']}.gif\"> ".$country['name'];
	}
	?>
	<div></div>
<?php if(isset($vars['shop']['shop_phone_numbers'])): ?>
<div class="ots">
<b><?php echo $this->t('shop','public phone numbers')?></b>: <br />
    <?php 
    $i=1;
    $count = count($vars['shop']['shop_phone_numbers']);
    foreach($vars['shop']['shop_phone_numbers'] as $phone) {
        if($count > $i) echo trim($phone['phone_number']).', ';
        else echo trim($phone['phone_number']);
        
        $i++;
    }
    ?>
</div>
<?php endif ?>
<?php if(isset($vars['shop']['shop_emails'])): ?>
<div class="ots">
<b><?php echo $this->t('shop','public emails')?></b>: <br />
    <?php 
    $i=1;
    $count = count($vars['shop']['shop_emails']);
    foreach($vars['shop']['shop_emails'] as $email) {
        if($count > $i) echo trim($email['email']).', ';
        else echo trim($email['email']);
        
        $i++;
    }
    ?>
</div>
<?php endif ?>
<?php if(isset($vars['shop']['shop_urls'])): ?>
<div class="ots">
<b><?php echo $this->t('shop','public urls')?></b>: <br />
    <?php 
    $i=1;
    $count = count($vars['shop']['shop_urls']);
    foreach($vars['shop']['shop_urls'] as $url) {
        if($count > $i) echo trim($url['url']).', ';
        else echo trim($url['url']);
        
        $i++;
    }
    ?>
</div>
<?php endif;

	echo "<a href=\"/shop/".$vars['shop']['id']."\" target=\"blank\">".$this->t("shop","show all products")."</a>";
?>
	

</td></tr></table>