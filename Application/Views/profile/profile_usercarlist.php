<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('profile/profile_info.php', $vars);
?>
</div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<!--div style="z-index:1000; right: 9px; top: 1px;"><button id="messageCompose" class="btn"><?php echo $this->t('profile',"Compose");?></button></div-->
<div class="header"><?php echo $this->t('profile',"auto");?></div>

<?php

if ( count($vars['cars'])) {
  
?>
	<div class="body"><table class="markup" style="width:100%">


<style>
  .auto .img .catalogImages { display: block; position: relative; text-decoration: none; background: none; padding: 0; margin-bottom: 1px; }
  .auto .img .catalogImages span { display: block; position: absolute; background: url(http://c.rdrom.ru/skin/zoom2.png?update=1.0) left top no-repeat; width: 21px; height: 21px; right: 8px; bottom: 8px }
  .auto .img .catalogImages span { _background-image: none; _filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src="http://c.rdrom.ru/skin/zoom2.png?update=1.0", sizingMethod="crop") }
</style>

<script type="text/javascript" src="/js/auto/toolbox.expose.js"></script>
<script type="text/javascript" src="/js/auto/lightbox.js"></script>
<script type="text/javascript" src="/js/auto/js-1.1.js"></script>
<script type="text/javascript" src="/js/auto/jquery.lazyload.js"></script>

<?php
if(isset($vars['cars'])){   	
	  foreach ($vars['cars'] as $car) {
?>
<table class="auto">
  <tbody><tr>
    <td class="img">
<?php 
		if(isset($car['medias']) and $car['medias']['found_rows']>0){
			$this->template('profile/profile_car_photos_user.php', $car);
		}
?>

</td><td>&nbsp;&nbsp;&nbsp;</td><td class="adv-text">

<h3>
<?php 
	  	if(isset($car['marka_id']) and $car['marka_id']){
		    echo "<span id=\"marka_name{$car['id']}\">{$car['marka_name']}</span><span style=\"display:none;\" id=\"marka_id{$car['id']}\">{$car['marka_id']}</span>";
	  	}
	  	if(isset($car['model_id']) and $car['model_id']){
		    echo " <span id=\"model_name{$car['id']}\">{$car['model_name']}</span><span style=\"display:none;\" id=\"model_id{$car['id']}\">{$car['model_id']}</span>";
	  	}
	  	if(isset($car['year']) and $car['year']){
		 	echo " <span id=\"year{$car['id']}\">{$car['year']}</span> ". $this->t('profile','year');
		}
?>
</h3>
      <div class="clear">&nbsp;</div>
<?php       
	  	if(isset($car['complect']) and $car['complect']){
		 	echo "<p><span class=\"form_entry\">". $this->t('profile','complect').":&nbsp;</span><span id=\"complect{$car['id']}\">{$car['complect']}</span></p>";
		}
	  	if(isset($car['descr']) and $car['descr']){
		 	echo "<p><span class=\"form_entry\">". $this->t('profile','descr').":&nbsp;</span><span id=\"descr{$car['id']}\">{$car['descr']}</span></p>";
		}
?>      
 
    </td>
  </tr>


</tbody></table>
<?php 
}
}
}
?>


</div>
<div style="clear: both"></div>

<?php
$this->template('/common/footer.php');
?>