<div class="gadgets-gadget-chrome">
<div class="header">
<?php echo $this->t('profile','friends_title', array('{name}'=>$vars['person']['first_name'], '{count}'=>count($vars['friends']))); ?>
<a href="/profile/friends/<?php echo $vars['person']['id']?>" title="<?php echo $this->t('common','View all..') ?>"></a>
</span>
</div>
<div class="friends"><div class="body">
<?php
foreach ($vars['friends'] as $friend) {
        echo "<div class=\"item itemfriend\"  id=\"{$friend['id']}\"><table class=\"markup\"><tr><td>";
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">";
//        	if($friend['isonline']){ $this->template('profile/online.php', $vars); }
    		if($friend['thumbnail_url']){
    			echo "<img src=\"{$friend['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/people/nophoto.205x205.gif\">";
    		}
    		
			echo "</a></div></td><td>";
			echo "<div class=\"title\">";
			if($friend['isonline']){
        		echo "<span class=\"online-inline\"></span>";
        	}else{
        		echo "<span class=\"offline-inline\"></span>";        	 
        	}
        	echo "<a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
			echo "<p>{$friend['activity']}</p>";
			
			
    	echo "</td></tr></table></div>";
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
</div>
</div>
</div>
