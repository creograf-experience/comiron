<?php
$this->template('shop/news_detail_index.php', $vars); 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){

	?>
	</div>
	<?php
	$this->template('/common/footer.php');
}
?>