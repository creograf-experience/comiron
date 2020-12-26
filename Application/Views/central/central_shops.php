<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('central/central_info.php', $vars);
?>
</div>
<div id="profileRight">
<?php
$this->template('central/central_right.php', $vars);
?>
</div>
<div id="profileContent">
<?php $this->template('central/topheader.php', $vars); ?>

<div class="header">
<?php
	echo "Shop search";
?>
</div>
<div class="body clearfix">		
<?php 
if(isset($vars['shops'])){
	foreach($vars['shops'] as $shop){
		
		$this->template('central/index_shop.php', $shop);		
	}
}
?>
</div>



<?php $this->template('/common/footer.php', $vars); ?>