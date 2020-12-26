<div class="news">
<?php
//$created = strftime('%B %e, %Y at %H:%M', $news['created']);
		$created=$this->formatdate($news['created']);

        echo "<div class=\"news_item news_item_detailed\"  id=\"news_{$news['id']}\">";
        echo "<div class=\"body\">";
        echo "<table class=\"markup\" width=\"100%\"><tr><td width=\"60\">";
        
        	echo "<div class=\"photo\"><a href=\"/profile/{$news['person_id']}\">";
    
    		if($news['thumbnail']){
    			echo "<img class=\"smallavatar\" src=\"{$news['thumbnail']}\">";
    		}else{
    			echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    		}
    		
			echo "</a></div>";

			echo "</td><td>&nbsp;</td><td>";
			
			echo "<div class=\"new_title_line\">";
 		    $qwtitle=stripslashes($news['title']);
   			if(!empty($news['shop_id'])) {
            	echo "<a href=\"/shop/{$news['shop_id']}\">{$news['shop_name']}</a> | <a class=\"newsopen\" title=\"{$qwtitle}\" href=\"/shop/news/get/{$news['id']}\">{$news['title']}</a>";
        	} else {
            	echo "<a href=\"/profile/{$news['person_id']}\">{$news['first_name']} {$news['last_name']}</a> | <a class=\"newsopen\" title=\"{$qwtitle}\" href=\"/profile/news/get/{$news['id']}\">{$news['title']}</a>";
        	}
        	echo "</div>";
        	
			if ($news['person_id'] == $_SESSION['id'] and !((isset($_GET['style']) and $_GET['style']=='ajax'))) {
				echo "<div class=\"x\"><a href=\"#\" class=\"editnews\" title=\"{$this->t('profile','edit news')}\"  owner_id=\"{$news['person_id']}\" id=\"{$news['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a><a href=\"#\" class=\"removenewsfrom\" title=\"{$this->t('common','remove news')}\" from=\"{$news['from']}\" id=\"{$news['id']}\"><img src=\"/images/i_close.png\"></a></div>";
			}
					
			//echo "<div class=\"title\"><a href=\"/profile/news/get/{$news['id']}\">{$news['title']}</a></div>";
			
			$news['anons']=str_replace("\n","<br>\n",$news['anons']);
			$news['body']=str_replace("\n","<br>\n",$news['body']);
				
			//echo "<p>{$news['anons']}</p><br/>";
			
			echo "<p>{$news['body']}</p>";
			
			$this->template('profile/files_index.php', $news);
				
		echo "</td></tr></table>";
		echo "</div>";
		
			$this->template('profile/news_photos_index.php', $news);
		/*	echo "<div class=\"date\">{$created}</div>";
			
		echo "<a name=\"comments\"></a><div class=\"body\">";
			$news['object_name']="messages";
			$news['hide_comments_link']="1";
			$this->template('like/like_inline.php', $news);
		echo "</div>";
		*/
		
		echo "<div class=\"body1\">";
		echo "<span class=\"date\">{$created}</span>";
		
			$news['object_name']="messages";
			$news['hide_comments_link']="1";
			$news['qwtitle']=$qwtitle;
			$this->template('like/like_inline.php', $news);
			
		echo "</div>";			
				
				
    	echo "</div>";
?>
</div>
 