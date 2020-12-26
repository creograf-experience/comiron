<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo" class="blue">
<?php
$this->template('profile/profile_info.php', $vars);
?>
</div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div class="header">
<?php 
if ($vars['is_owner']){
	echo  $this->t('profile','my friends');
}else{  
	echo  $this->t('profile','friends_title', array('{name}'=>$vars['person']['first_name'], '{count}'=>count($vars['friends'])));	
}?> 
</div>
		
<div class="friends clearfix"><div class="body">		
<?php
	foreach ($vars['friends'] as $friend) {
    	    echo "<div class=\"itemfriend\" id=\"{$friend['id']}\">";
			if ($vars['is_owner']) {	
                            if(!in_array($friend['id'], $vars['array_admin'])) echo "<div class=\"x\"><a href=\"#\" class=\"remove tip\" id=\"{$friend['id']}\" name=\"{$friend['first_name']}\" title=\"{$this->t("profile", "remove friend")}\"></a></div>";
			}
        	echo "<div class=\"photo\"><a href=\"/profile/{$friend['id']}\">";
        	if($friend['isonline']){
        		$this->template('profile/online.php', $vars);
        	}
        	 
    		if($friend['thumbnail_url']){
    			echo "<img class=\"middleavatar\" src=\"{$friend['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"middleavatar\" src=\"/images/people/nophoto.205x205.gif\">";
    		}
    		
			echo "</a></div>";
			echo "<div class=\"title\"><a href=\"/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
			echo "<div class=\"links\"><a href=\"/profile/messages/im/{$friend['id']}\">".$this->t("profile",'Compose message')."</a>".
			"<a href=\"/profile/friends/{$friend['id']}\">".$this->t("profile",'View friends')."</a></div>";
			echo "</div>";
	}
?>
</div></div>
    <script type="text/javascript">
    	$('.remove').bind('click', function() {
        	var id=$(this).attr("id");
        	var name=$(this).attr("name");
    		$("#dialog").dialog({
    			bgiframe: false,
    			resizable: false,
    			height:140,
    			modal: true,
    			closeOnEscape: true,
    			overlay: {
    				backgroundColor: '#000',
    				opacity: 0.5
    			},
    			buttons: [{ text: t('common', 'Remove'),
     				'class':'btn',
     				click: function() {
     					$(this).dialog('destroy');
    					window.location = '/profile/removefriend/'+id;
    					}
    				},	
    				{ text: t('common', 'Cancel'),
         				'class':'btn',
         				click: function() {
        					$(this).dialog('destroy');
    					}
    				}],
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html(t('profile','confirm_remove_friend', {'{name}':name}));
    				//alert(name);
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php echo $this->t('profile','Remove from your friend list?');?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
<script>
$('.item').bind('click', function(event) {
	if(event.target.nodeName!="A"){
		window.location = '/profile/'+ $(this).attr('id');
		return false;
	}
});</script>

<?php 
if ($vars['is_owner']){
?>    
<div class="header"><?php echo $this->t('profile', 'Posible friends'); ?></div>
<div class="friends clearfix"><div class="body">

<?php
/*echo '<pre>';
print_r($vars['posible_friends']);
echo '</pre>';*/
	foreach ($vars['posible_friends'] as $friend) {
            if(isset($friend['id'])) {
    	    echo "<div class=\"itemfriend\" id=\"{$friend['id']}\">";
			echo "<div class=\"photo\"><a href=\"/profile/{$friend['id']}\">";
    
    		if($friend['thumbnail_url']){
    			echo "<img class=\"middleavatar\" src=\"{$friend['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"middleavatar\" src=\"/images/people/nophoto.205x205.gif\">";
    		}
    		
			echo "</a></div>";
			echo "<div class=\"title\"><a href=\"/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}";
			if($friend['numberofcommonfriends']){
				echo " ({$friend['numberofcommonfriends']})";
			}
			echo "</a></div>";
			if($friend['isonline']){
				$this->template('profile/online.php', $vars);
			}	
			echo "</div>";
            }
	}
?>

</div></div>
<?php }?> 
   
    
  <div style="clear: both"></div>
</div>
<?php
	$this->template('/common/footer.php');
?>