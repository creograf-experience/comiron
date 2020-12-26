<?php 	    
/*echo '<pre>';
print_r($vars);
echo '</pre>';*/
//  	    $created = strftime('%m/%d/%y '.$this->t('common','in').' %H:%M', $vars['created']);
		$created=$this->formatdate($vars['created']);

  	    $status=$vars['status'];
  	    if(($vars['to'] == $_SESSION['id']) and ($vars['from'] == $_SESSION['id']) and $vars['fromshop'] == 0) {
                $status="to_open ".$status;
            } elseif($vars['from'] == $_SESSION['id'] and $vars['fromshop'] == 0) {
                $status="to_open ".$status;
            } else {
                $status="to ".$status;
            }
        
        echo "<div class=\"message_item {$status}\" id=\"message_{$vars['id']}\">";
        
        echo "<div class=\"body\"><table class=\"markup\"><tr><td>";
        	echo "<div class=\"photo\">";
                if(isset($vars['shop']['person_id'])) {
                    if($vars['fromshop'] > 0) {
                        echo "<a href=\"/shop/{$vars['shop']['id']}\">";
                    } else {
                        echo "<a href=\"/profile/{$vars['from']}\">";
                    }
                } else {
                    echo "<a href=\"/profile/{$vars['from']}\">";
                }
                if(isset($vars['shop']['person_id'])) {
                    if($vars['fromshop'] > 0) {
                        if($vars['shop']['thumbnail_url']){
                                echo "<img class=\"smallavatar2\" src=\"{$vars['shop']['thumbnail_url']}\">";
                        }else{
                                echo "<img class=\"smallavatar2\" src=\"/images/shop/nophoto.gif\">";
                        }
                    } else {
                        if($vars['thumbnail_url']){
                                echo "<img class=\"smallavatar2\" src=\"{$vars['thumbnail_url']}\">";
                        }else{
                                echo "<img class=\"smallavatar2\" src=\"/images/people/nophoto.gif\">";
                        }
                    }
                } else {
                    if($vars['thumbnail_url']){
                                echo "<img class=\"smallavatar2\" src=\"{$vars['thumbnail_url']}\">";
                        }else{
                                echo "<img class=\"smallavatar2\" src=\"/images/people/nophoto.gif\">";
                        }
                }
    		
			echo "</a></div>";
			echo "</td><td class=\"messagebody\">";
			if ($vars['from'] == $_SESSION['id'] || $vars['to'] == $_SESSION['id']) {
				echo "<div class=\"x\"><a href=\"#\" class=\"removemessage\" title=\"{$this->t('common','remove message')}\" id=\"{$vars['id']}\"><img src=\"/images/i_close.png\"></a></div>";
			}
					
			echo "<div class=\"title\">";
                        if(isset($vars['shop']['person_id'])) {
                            if($vars['fromshop'] > 0) {
                                echo "<a href=\"/shop/{$vars['shop']['id']}\">{$vars['shop']['name']}</a></div>";
                            } else {
                                echo "<a href=\"/profile/{$vars['from']}\">{$vars['name']}</a></div>";
                            }
                        } else {
                                echo "<a href=\"/profile/{$vars['from']}\">{$vars['name']}</a></div>";
                        }
				
			echo "<p><pre>{$vars['body']}</pre></p>";
			$vars['person_id']=$vars['from'];
			$this->template('profile/files_index.php', $vars);
				
			echo "</td></tr></table>";
			
			$this->template('profile/messages_photos_index.php', $vars);
				
			echo "<div class=\"date\">{$created}</div>";
				
		echo "</div>";
    	echo "</div>";
?>
 