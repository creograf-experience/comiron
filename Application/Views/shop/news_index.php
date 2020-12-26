<div class="news">
<?php
foreach ($vars['news'] as $news) {
	    //$created = strftime('%m/%d/%y '.$this->t('common','in').' %H:%M', $news['created']);
	    $created=$this->formatdate($news['created']);
	
        echo "<div class=\"item news_item news_item_inline clearfix\" id=\"news_{$news['id']}\">";
        echo "<div class=\"body news_body\"><table class=\"markup\"><tr><td>";

            if(!empty($news['shop_id'])) {
                echo "<div class=\"photo\"><a href=\"/shop/{$news['shop_id']}\">";
    
    			if(isset($news['thumbnail'])){
    				echo "<img class=\"smallavatar\" src=\"{$news['thumbnail']}\">";
    			}else{
    				echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    		    }
            }else {
                
  		      	echo "<div class=\"photo\"><a href=\"/shop/{$news['person_id']}\">";
    	
    			if($news['thumbnail']){
    				echo "<img class=\"smallavatar\" src=\"{$news['thumbnail']}\">";
    			}else{
    				echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    			}
    	 
            }
			echo "</a></div>";
			/*if($vars['person']['isonline']){
				echo "<div class='online'>Online</div>";
			}*/
			echo "</td><td width=\"10px\">&nbsp;</td><td>";
		    
		    echo "<div class=\"new_title_line\">";
 		    $qwtitle=stripslashes($news['title']);
   			if(!empty($news['shop_id'])) {
            	echo "<a href=\"/shop/{$news['shop_id']}\">{$news['shop_name']}</a> | <a class=\"newsopen\" title=\"{$qwtitle}\" href=\"/shop/news/get/{$news['id']}\">{$news['title']}</a>";
        	} else {
            	echo "<a href=\"/profile/{$news['person_id']}\">{$news['first_name']} {$news['last_name']}</a> | <a class=\"newsopen\" title=\"{$qwtitle}\" href=\"/profile/news/get/{$news['id']}\">{$news['title']}</a>";
        	}
        	echo "</div>";
		
		  if (isset($news['from']) and $news['from'] == $_SESSION['id']) {
        echo "<div class=\"x\">";
        if($news['created'] + PartuzaConfig::get('news_edit_time') > $_SERVER['REQUEST_TIME']){
          echo "<a href=\"#\" class=\"tip editnews\" title=\"{$this->t('profile','edit news')}\"  owner_id=\"{$news['person_id']}\" id=\"{$news['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a>";
        }
        echo "<a href=\"#\" class=\"tip removenewsfrom\" title=\"{$this->t('common','remove news')}\" from=\"{$news['from']}\" id=\"{$news['id']}\"><img src=\"/images/i_close.png\"></a></div>";
      }
			
			echo "<!--div class=\"title\"><a href=\"/shop/news/get/{$news['id']}\" class=\"newsopen\" title=\"{$qwtitle}\">{$news['title']}</a></div-->";
			
			//анонс
			$anons_src=$news['body'];
			//$anons_src=strip_tags($anons_src);
                        $anons_src=$anons_src;
			$anons=substr($anons_src, 0, 600);
			if(strlen($anons_src) > strlen($anons)){
				$pos = strrpos($anons, " ");
				if($pos){
					$anons=substr($anons, 0, $pos);
				}
				$anons=$anons."...";
			}
			#$anons=str_replace("\n","<br>\n",$anons);
			$anons=str_replace("  ","&nbsp;&nbsp;",$anons);
			if(!empty($news['shop_id'])) {			
                echo "<div class=\"anons\"><p><a class=\"newsopen\" title=\"{$qwtitle}\" href=\"/shop/news/get/{$news['id']}\"><pre>{$anons}</pre></a>";
            }
            else {
                echo "<div class=\"anons\"><p><a class=\"newsopen\" title=\"{$qwtitle}\" href=\"/profile/news/get/{$news['id']}\"><pre>{$anons}</pre></a>";
            }
			if($news['medias']['found_rows']>count($news['medias']["firstline"])){
				echo "&nbsp;<span class=\"icons\"><a href=\"/shop/news/get/{$news['id']}#photos\">{$this->t('common','total photos')}&nbsp;({$news['medias']['found_rows']})</a></span>";
			}
			
			echo "</p></div>";
			//echo "<p><a href=\"/profile/news/get/{$news['id']}\">{$news['anons']}</a></p>";

			$this->template('profile/files_index.php', $news);
				
		echo "</td></tr></table></div>";

			//$news['news_photo_limit']=6;
			$news['medias']=$news['medias']['firstline'];
			$this->template('profile/news_photos_index.php', $news);
			//echo "<div class=\"date\">{$created}</div>";
		
		echo "<div class=\"newsicons clearfix\">";
		echo "<span class=\"date\">{$created}</span>";
		
			$news['object_name']="messages";
			$news['qwtitle']=$qwtitle;
			$this->template('like/like_newsinline.php', $news);
			
		echo "</div>";			
    	echo "</div>";
}
?>
 
<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/shop/news/{$vars['person']['id']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
	echo "<div id=\"totalpages\">{$vars['totalpages']}</div>";
}
?>
</div>

</div>

<script type="text/javascript" src="/js/photos.js"></script>
