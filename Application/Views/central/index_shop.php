<?php 
        echo "<div class=\"item shop_item\">";
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/shop/{$vars['id']}\">";
    
    		if($vars['thumbnail_url']){
    			echo "<img src=\"{$vars['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/shop/nophoto.gif\">";
    		}
    		echo "</a></div>";
			echo "<div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/shop/{$vars['id']}\">{$vars['name']}</a></div>";
    	echo "</div>";
?> 