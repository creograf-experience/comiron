<!-- 
<div class="header"><?php echo $this->t('common','Advertising'); ?></div>
<div class="advert">
	<div class="name">Galleon</div>
	<a href="http://galeontrade.ru/" target="_blank"><img src="/images/advert/galeon/1.png"></a>
	<div class="text">Galleon Trade Co., Ltd</div>
</div>

<div class="advert">
	<div class="name">Flying school</div>
	<a href="#"><img src="/images/advert/2/1.png" width="181" height="95" alt=""></a>
	<div class="text">We will teach you to fly!</div>
</div>

 -->
<?php
if (isset($vars['is_central'])) {
  $this->template("central/central_right.php", $vars); 
}else{
  $this->template("central/adv.php", $vars);
	
}  
?>