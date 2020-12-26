<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){

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

	<div class="header"><?php  echo $vars['group']['name']; ?></div>


	<div class="body">		
	<?php 
	  if(isset($vars['group']) and isset($vars['group']['subs'])){
	    echo "<ul class=\"subgroups\">";
	    foreach ($vars['group']['subs'] as $g) {
	      echo "<li><a href=\"/shop/group/".$g['id']."\">".$g['name']."</a></li>";
	    }
	    echo "</ul>";
	  }
	?>
	<div id="productbody">
	<?php
} // if !ajax
	?>

<?php
if($vars['group']['id']){
		$vars['nextpageurl'] = "/shop/group/".$vars['group']['id'];
	  $this->template('shop/product.php', $vars); 
}

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){

	?>
</div>

	</div>
	</div>
	<div style="clear: both"></div>
	<?php 	$this->template('/common/footer.php'); 
} // if !ajax
?>