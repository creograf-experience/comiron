<div class="mpersons">
<?php

unset($vars['message_persons']['found_rows']);
foreach ($vars['message_persons'] as $mperson) {  
  	    //$created = strftime('%d/%m/%y '.$this->t('common','in').' %H:%M', $mperson['created']);
    //if(isset($mperson['master'])){ 
        /*if($mperson['shop_id'] == $vars['shop_id_of_profile'] and $mperson['from'] == $_SESSION['id'] and $mperson['fromshop'] != $vars['shop_id_of_profile']) {
            continue;
        }
        else {*/
			$created=$this->formatdate($mperson['created']);
            if(isset($mperson['unread']) and $mperson['unread']>0) {
                echo "<div class=\"item message_item {$mperson['direction']}_noopen new\" id=\"mperson_{$mperson['id']}\" >";
            } else {
                echo "<div class=\"item message_item {$mperson['direction']}_noopen {$mperson['status']}\" id=\"mperson_{$mperson['id']}\" >";
            }
            echo "<div class=\"body\"><table class=\"markup\"><tr><td>";
        	echo "<div class=\"photo\">";
                if(empty($mperson['shop_id'])){
                    echo "<a href=\"/profile/messages/im/{$mperson['person']['id']}\">";
                } else {
                    echo "<a href=\"/profile/messages/im/{$mperson['person']['id']}/{$mperson['shop_id']}\">";
                }
                
                if(!empty($mperson['shop_id'])){
                    if($mperson['shop']['thumbnail_url']){
                            echo "<img class=\"smallavatar\" src=\"{$mperson['shop']['thumbnail_url']}\">";
                    }else{
                            echo "<img class=\"smallavatar\" src=\"/images/shop/nophoto.gif\">";
                    }
                } else{
                    if($mperson['person']['thumbnail_url']){
                            echo "<img class=\"smallavatar\" src=\"{$mperson['person']['thumbnail_url']}\">";
                    }else{
                            echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
                    }
                }
    		
			echo "</a></div>";
			if($mperson['person']['isonline']){
				$this->template('profile/online.php', $vars);
			}
				
			echo "</td><td class=\"messagebody\">";
			if(isset($mperson['unread']) and $mperson['unread']>0){
				echo "<span class=\"unreadtext\">{$mperson['unread']}&nbsp;";
				if($mperson['unread']==1){
					echo $this->t('common',"unread message");
				}else{
					echo $this->t('common',"unread messages");						
				}
				echo "</span>";
			}
					
			echo "<div class=\"title\">";
                        if(empty($mperson['shop_id']))
                            echo "<a href=\"/profile/messages/im/{$mperson['person']['id']}\">";
                        else 
                            echo "<a href=\"/profile/messages/im/{$mperson['person']['id']}/{$mperson['shop_id']}\">";
                            
                        if(!empty($mperson['shop_id'])){
                            echo "{$mperson['shop']['name']}</a></div>";
                        } else {
                            echo "{$mperson['person']['first_name']} {$mperson['person']['last_name']}</a></div>";
                        }
				
			echo "<p>";
                        if(empty($mperson['shop_id']))
                            echo "<a href=\"/profile/messages/im/{$mperson['person']['id']}\">";
                        else 
                            echo "<a href=\"/profile/messages/im/{$mperson['person']['id']}/{$mperson['shop_id']}\">";
                        
                        echo "<pre>{$mperson['body']}</pre></a></p>";

			echo "<div class=\"date\">{$created}</div>";
				
		echo "</td></tr></table></div>";
            echo "</div>";
        //}
    //}
}
?>
 
<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/profile/news/{$vars['person']['id']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
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
<div id="dialog_news_remove" title="<?php $this->t('common','confirm_remove_news_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>
