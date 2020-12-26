<div class="news"><div class="body">
<?php
foreach ($vars['results'] as $news) {
	    //$created = strftime('%m/%d/%y '.$this->t('common','in').' %H:%M', $news['created']);
		$created=$this->formatdate($news['created']);
	
        echo "<div class=\"item\">";
        echo "<table class=\"markup\"><tr><td>";
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$news['person_id']}\">";
    
    		if($news['thumbnail']){
    			echo "<img src=\"{$news['thumbnail']}\">";
    		}else{
    			echo "<img src=\"/images/people/nophoto.gif\">";
    		}
    		
			echo "</a></div>";
			echo "</td><td>";
			echo "<div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$news['person_id']}\">{$news['first_name']} {$news['last_name']}</a></div>";
			echo "<p><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/news/get/{$news['id']}\">{$news['anons']}</a></p>";
			echo "<div class=\"date\">{$created}</div>";
			
			$news['object_name']="messages";
			$this->template('like/like_inline.php', $news);

		echo "</td></tr></table>";			
    	echo "</div>";
}
?>
 
<div class="pages">
<span class="p">
<?php
 
if($vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/search?q=".$_GET['q']."&for=".$_GET['for']."&curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if($vars['totalpages']>0){
	echo "<div id=\"totalpages\">{$vars['totalpages']}</div>";
}
?>
</div>



</div>
</div> 