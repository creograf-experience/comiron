	<div class="header"><?php echo $this->t('profile','Messages'); ?></div><div class="body clearfix">

<?php
	//последние собеседники
	foreach ($vars['collocutors'] as $collocutors) {
		if(!isset($collocutors['id']) || !is_numeric($collocutors['id'])){
			continue;	
		}
		
		echo "<div class=\"personicon\">";
		if(isset($collocutors['unread']) and $collocutors['unread']>0){
			echo "<span class=\"unread\">{$collocutors['unread']}</span>";
		}
		echo "<div class=\"photo\"><center><a href=\"/profile/messages/im/{$collocutors['id']}\">";
		if(isset($collocutors['thumbnail_url'])){
			echo "<img  class=\"smallavatar\" src=\"{$collocutors['thumbnail_url']}\">";
		}else{
    			echo "<img  class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
		}
		echo "</a></center></div>";
		
		echo "<div class=\"title\">";
		if($collocutors['isonline']){
			echo "<span class=\"online-inline\"></span>";
		}else{
			echo "<span class=\"offline-inline\"></span>";
		}		
		echo "<a href=\"/profile/messages/im/{$collocutors['id']}\">{$collocutors['first_name']}</a></div>";
		/*if($collocutors['isonline']){
			$this->template('profile/online.php', $vars);
		}*/
		echo "</div>";
	}
?>
	</div>