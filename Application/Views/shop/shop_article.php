<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('shop/shop_info.php', $vars);
?>
</div>
<div id="profileRight">
<?php
$this->template('shop/shop_right.php', $vars);
?>
</div>
<div id="profileContent">
<?php $this->template('shop/topheader.php', $vars); ?>

<div class="header"><?php  echo $vars['article']['name']; ?></div>

<div class="body txt">		
<?php 
echo $vars['article']['txt_html']
?>

  <div style="clear: both"></div>
</div>

</div>


<?php 	$this->template('/common/footer.php'); ?>