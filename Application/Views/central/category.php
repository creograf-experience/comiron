<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){

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

	<?php $this->template('central/searchproduct.php', $vars); ?>

	<div class="header">
	<?php
		echo $vars['category']['name'];
	?>
	</div>
	<div class="body clearfix">		
	<?php 
	if(isset($vars['category']['subs'])){
		foreach($vars['category']['subs'] as $category){
			
			$this->template('shop/index_category.php', $category);		
		}
	}
	?>
	</div>

	<div class="body clearfix" id="productbody">		
	<?php 
} //if !ajax

	$vars['nextpageurl'] = "/central/category/".$vars['category']['id'];
	$this->template('shop/product.php', $vars); 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){

	?>
	</div>


	<?php 	$this->template('/common/footer.php'); 
} // if !ajax
?>