<?php
	foreach ($vars['comments'] as $comment) {
		//$created = strftime('%B %e, %Y at %H:%M', $comment['time']);
		$created=$this->formatdate($comment['time']);
		
        echo "<div class=\"item";
        if($comment['person_id'] == $_SESSION['id']){
        	echo " mycomment";
        }
        echo "\">";
        echo "<table class=\"markup\"><tr><td>";
        echo "<div class=\"photo";
        	
        echo "\"><a href=\"/profile/{$comment['person_id']}\">";
    
    	if($comment['person']['thumbnail_url']){
    		echo "<img class=\"smallavatar\" src=\"{$comment['person']['thumbnail_url']}\">";
    	}else{
    		echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    	}
    		
		echo "</a></div>";
		echo "</td><td>&nbsp;</td><td>";
		echo "<span class=\"date\">{$created}</span>";
			
			
		echo "<div class=\"title\"><a href=\"/profile/{$comment['person_id']}\">{$comment['person']['first_name']} {$comment['person']['last_name']}</a>";
		echo "</div>";
		echo "<p><pre>";
		if($comment['can_delete']){			
			echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$comment['id']}\" object_id=\"{$comment['object_id']}\" object_name=\"{$comment['object_name']}\"><img src=\"/images/i_close.png\"></a></div>";
		}
	
		echo "{$comment['text']}</pre></p>";
		$this->template('profile/files_index.php', $comment);
				
			//if($comment['answers']){
			//	$this->template('like/like_inline.php', $comment['answers']);
			//}
		
		echo "</td></tr><tr><td colspan=\"3\">";
		$this->template('comment/photos.php', $comment);
		echo "</td></tr></table>";			
    	echo "</div>";
	}
?>
