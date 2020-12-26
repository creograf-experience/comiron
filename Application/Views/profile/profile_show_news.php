
<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);
?>
	<div id="profileInfo" class="blue">
	<?php $this->template('profile/profile_info.php', $vars); ?>
	</div>
	<div id="profileRight" class="blue">
	<?php $this->template('common/right.php', $vars);?>
	</div>
	<div id="profileContent">
	<?php

	$vars['subtitle']=$this->t('common',"News");
	$this->template('profile/topheader.php', $vars); ?>

	<div class="header"><?php echo $news['title']; ?>
	</div>

	<?php 
}

$this->template('profile/news_detail_index.php', $vars); 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){

	?>
	</div>
	<?php
	$this->template('/common/footer.php');
}
?>