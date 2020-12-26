<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php');
	?>
	<div id="profileInfo" class="blue">
	<?php
  	$this->template('profile/profile_info.php', $vars);
	?>
	</div>
        <div id="profileRight">
            <div id="small_cart">
                <?php
                /*echo '<pre>';
                print_r($vars);
                echo '</pre>';*/
                ?>
                <?php $this->template('central/small_cart.php', $vars);?>
            </div>
        </div>
	<div id="profileContentWide">
	<div class="topheader"><?php echo $this->t("common", "Search"); ?></div>
<?php
}

if ($vars['error']) {
  echo "<b>{$vars['error']}</b>";
} else {
	echo "<div class=\"body\">";
	switch($_GET['for']){
		case "news":
			$this->template('profile/news_search_index.php', $vars);
			break;

		case "product":
			$this->template('shop/product_search_index.php', $vars);
			break;
					
		case "organization":
			$this->template('shop/org_search_index.php', $vars);
			break;
					
		case "people":
			
			echo '<div class="friends clearfix">';
			foreach ($vars['results'] as $friend) {
		           	
		    	
		    	echo "<div class=\"itemfriend\" id=\"{$friend['id']}\">";
	        	echo "<div class=\"photo\"><a href=\"/profile/{$friend['id']}\">";
    		    if($friend['isonline']){
        			$this->template('profile/online.php', $vars);
        		}
        	 
	    		if($friend['thumbnail_url']){
    				echo "<img class=\"middleavatar\" src=\"{$friend['thumbnail_url']}\">";
    			}else{
    				echo "<img class=\"middleavatar\" src=\"/images/people/nophoto.205x205.gif\">";
    			}
    		
				echo "</a></div>";
				echo "<div class=\"title\"><a href=\"/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
				echo "</div>";

  			}
  			echo "</div>";
  			break;
	}
    	echo "</div>";
}

?>

		    		<script>
		    		$('.itemfriend').bind('click', function(event) {
		    			if(event.target.nodeName!="A"){
		    				window.location = '/profile/'+ $(this).attr('id');
		    				return false;
		    			}
		    		});
		    		</script>

<?php 
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
    echo "</div></div>";
	$this->template('/common/footer.php');
}
?>

		    	
