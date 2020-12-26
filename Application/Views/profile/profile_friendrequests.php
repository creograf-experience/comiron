<?php
if (count($vars['friend_requests'])) {
?>
<div class="header"><?php echo $this->t('profile','Friend requests'); ?></div>

<?php 
  //TODO style and link to a page where u can view / accept them
  echo "<div id=\"friendRequests\"><div class=\"body\"><b>";
  echo $this->t('profile', 'friends_number', array('{number}'=>count($vars['friend_requests'])));
  echo "</b><br>";
 
  foreach ($vars['friend_requests'] as $request) {
    echo "<div class=\"item\">
    		<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$request['id']}\">";
    
    if($request['thumbnail_url']){
    	echo "<img  class=\"smallavatar\" src=\"{$request['thumbnail_url']}\">";
    }else{
    	echo "<img  class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    }
    		
	echo	"</a></div>
    		<div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$request['id']}\">{$request['first_name']} {$request['last_name']}</a></div>
			<a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$request['id']}\">{$request['first_name']} {$request['last_name']}</a> requests to be your friend.<br />
			
			<div class=\"icons\">
			<a class=\"adduser\" href=\"" . PartuzaConfig::get('web_prefix') . "/home/acceptfriend/{$request['id']}\">".
			$this->t('common', 'accept').
			"</a> 
			<a class=\"reject\" href=\"" . PartuzaConfig::get('web_prefix') . "/home/rejectfriend/{$request['id']}\">".
			$this->t('common', 'reject')."</a>
			</div>
    	</div>";
  }
  echo "</div></div>";  
}
?>
