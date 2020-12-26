<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);
	?>
<div id="profileInfo">
<?php
	if(isset($vars['shop']['is_owner']) or $vars['shop']['is_client']){ 
		$this->template('shop/myshop_info.php', $vars);
	}else{
		//$this->template('profile/profile_info.php', $vars);
	}
?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('common/right.php', $vars);?>
</div>

<div id="profileContentWide">
	<?php $this->template('shop/topheader.php', $vars); ?>
	<div class="header"><?php echo $this->t('common','News'); ?></div>
<?php
if ($vars['is_owner']) {
	echo "<div class=\"news shopnews\"><div class=\"action\"><a href=\"#\" class=\"funbutton\" id=\"shop_news_compose\" title=\"{$this->t('common','Post news')}\">{$this->t('profile','Post news')}</a></div>";
	echo "<div id=\"shop_news_compose_dialog\"  style=\"display:none;\">";
        $this->template('shop/news_compose.php', $vars);
	echo "</div></div>";
}

}

$this->template('shop/news_index.php', $vars);
?>
</div>

<?php 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/footer.php'); 
}?>