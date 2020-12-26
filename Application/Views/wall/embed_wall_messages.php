<?php
	//показывает сообщение или новость на стене
	$messages=$this->model($vars['object_name']);
	$message=$messages->show($vars['object_id'], true);
	
	if($message['type'] == "news"){
		$news=$message;
		$news['person_id']=$vars['person_id'];
		$created=$this->formatdate($news['created']);
	
        echo "<div class=\"item news_item news_item_inline\" id=\"news_{$news['id']}\">";
        if(empty($vars['shop'])) {
            echo "<div class=\"new_title_line\"><a class=\"newsopen\" href=\"/profile/news/get/{$news['id']}\">{$news['title']}</a>";
        } else {
            echo "<div class=\"new_title_line\"><a class=\"newsopen\" href=\"/shop/news/get/{$news['id']}\">{$news['title']}</a>";
        }
        echo "<span class=\"date\">{$created}</span>";
        echo "</div>";
        echo "<div class=\"body news_body\"><table class=\"markup\"><tr><td>";
        	/*echo "<div class=\"photo\"><a href=\"/profile/{$news['person_id']}\">";
    
    		if($news['thumbnail']){
    			echo "<img class=\"smallavatar\" src=\"{$news['thumbnail']}\">";
    		}else{
    			echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    		}
    		
			echo "</a></div>";
			if($news['person']['isonline']){
				$this->template('profile/online.php', $vars);
			}
			echo "</td><td>&nbsp;</td><td>";*/
			
			//анонс
			$anons_src=$news['body'];
			$anons_src=strip_tags($anons_src);
			$anons=substr($anons_src, 0, 250);
			if(strlen($anons_src) > strlen($anons)){
				$pos = strrpos($anons, " ");
				if($pos){
					$anons=substr($anons, 0, $pos);
				}
				$anons=$anons."...";
			}
			$anons=str_replace("\n","<br>\n",$anons);
			$anons=str_replace("  ","&nbsp;&nbsp;",$anons);
                        if(empty($vars['shop'])) {
                            echo "<div class=\"anons\"><p><a class=\"newsopen\" href=\"/profile/news/get/{$news['id']}\">{$anons}</a><!--div class=\"bg\"></div--></p></div>";
                        } else {
                            echo "<div class=\"anons\"><p><a class=\"newsopen\" href=\"/shop/news/get/{$news['id']}\">{$anons}</a><!--div class=\"bg\"></div--></p></div>";
                        }
			//echo "<p><a href=\"/profile/news/get/{$news['id']}\">{$news['anons']}</a></p>";

			$this->template('profile/files_index.php', $news);
				
		echo "</td></tr></table></div>";

			$news['news_photo_limit']=6;
			$this->template('profile/news_photos_index.php', $news);
			//echo "<div class=\"date\">{$created}</div>";
		
		echo "<div class=\"body1\">";
		
			$news['object_name']="messages";
			$this->template('like/like_newsinline.php', $news);
			
		echo "</div>";			
    	echo "</div>";
	}else{
		
	}
	//$this->
	
?>