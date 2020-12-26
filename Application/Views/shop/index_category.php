<?php 
        echo "<div class=\"category_item\">";
        	echo "<div class=\"photo\"><a href=\"/central/category/{$vars['id']}\">";
    
    		if($vars['thumbnail_url']){
    			echo "<img src=\"{$vars['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/category/nophoto.gif\">";
    		}

    		echo "</a></div>";
			echo "<div class=\"title\"><a href=\"/central/category/{$vars['id']}\">{$vars['name']}</a></div>";
		
			
    	echo "</div>";
?> 