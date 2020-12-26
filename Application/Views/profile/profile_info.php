<?php
if($vars['person']['isonline']){
	//echo "<div class='toponline'>";
	$this->template('profile/online.php', $vars);
	//echo "</div>";
}
$thumb = $vars['person']['thumbnail_url_big'];
if (!$thumb) {
  $thumb = '/images/people/nophoto250.gif';
}
?><a class="avatar" href="/profile/<?php echo $vars['person']['id']?>" rel="me"><img id="avatar" src="<?php echo $thumb?>" /></a>

<?php
//свой профиль
if ($vars['is_owner']) {
	echo "<a href=\"/profile/edit#basic\" id=\"uploadnewphoto\">".$this->t("profile", "Upload new photo")."</a>";
}
?>

<?php
//чужой профиль
if (!$vars['is_owner']) { ?>
	<div class="actions clearfix">
	<?php if ((!isset($vars['is_friend']) || !$vars['is_friend']) && $vars['is_friendrequested']==0) {?>
	
		<a  class="button btn" href="/home/addfriend/<?php echo $vars['person']['id']?>"><?php echo $this->t('profile','Add as friend'); ?></a>

	<?php }
		  if(isset($vars['is_friendrequested']) && $vars['is_friendrequested']==1){
		  	echo "<div class='text-info'>".$this->t("profile", "Friend request sent to you")."</div>";
		  }
		  if(isset($vars['is_friendrequested']) && $vars['is_friendrequested']==2){
		  	echo "<div class='text-info'>".$this->t("profile", "You sent friend request")."</div>";
		  }
		  if (isset($vars['is_friend']) && $vars['is_friend']) {?>
		  
		<a href="#" class="button" id="sendButton"><?php echo $this->t('profile','Send a message'); ?></a>
<script>

$('#sendButton').bind('click', function() {
	$("#send_dialog").dialog({
		//title:"Send message to $vars['person']['first_name']",
		bgiframe: true,
		resizable: false,
		height:420,
		width:400,
		modal: true,
		closeOnEscape: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		open: function(){
            $(this).find("form").ajaxForm(function(){
	            	$("#send_dialog").empty();
	                $("<div><?php echo $this->t('profile','Message was send'); ?>.</div>").appendTo($("#send_dialog"));
            });
            $(this).find("#compose_cancel").click(function(e){
            	$("#send_dialog").dialog("close");
            	e.preventDefault();
            	return false;
            });
	    }
	});
});
</script>
<div id="send_dialog" title="SendMessage" style="display:none">
<form action="/profile/messages/send" method="post">
<?php 
  $vars['to']=$vars['person']['id'];
  $this->template('profile/profile_compose_message.php', $vars);
?>
</form>
</div>
		
<a href="#"  class="button" id="removeButton"><?php echo $this->t('profile','Remove from friends'); ?></a>
<script>
$('#removeButton').bind('click', function() {
	$("#delete_dialog").dialog({
		bgiframe: true,
		resizable: false,
		height:140,
		modal: true,
		closeOnEscape: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.5
		},
		buttons: {
			'Remove': function() {
				$(this).dialog('destroy');
				window.location = '/shop/removeclient/<?php echo $vars['shop']['id']?>';
			},
			'No': function() {
				$(this).dialog('destroy');
			}
		}
	});
});
</script>
	<div id="delete_dialog" title="Remove from your friend list?" style="display:none">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		<?php echo $this->t('profile', 'remove_friend_requst',array('{name}'=>$vars['person']['first_name'].' '.$vars['person']['last_name'])); ?>
		</p>
	</div>

	<?php } ?>
	
	</div>
<?php } ?>

<!-- div class="header"><?php echo $this->t('profile','Menu'); ?></div-->

	
<?php
if ($vars['is_owner']) {?>
	<div class="edit"><a href="/profile/edit"><?php echo $this->t('profile','Edit profile'); ?></a></div>
<ul class="profileMenu">

<?php 	
  echo "<li class=\"messages\"><table class=\"markup\"><tr><td><a href=\"/profile/messages\">".$this->t('profile','Messages')."</a></td><td class=\"dots\"></td><td>";
  if(isset($vars['person']['messages_num']) and $vars['person']['messages_num']['unread']>0){
  	echo "<span class=\"highlight\">".$vars['person']['messages_num']['unread']."</span>";
  }else if(isset($vars['person']['messages_num']) and $vars['person']['messages_num']['read']>0){
    	echo $vars['person']['messages_num']['read'];
  }
  echo "</td></tr></table></li>\n";
} else{

 echo "<ul class=\"profileMenu\">";
}

?>
<li class="friends"><table class="markup"><tr><td><a href="<?php echo PartuzaConfig::get("web_prefix")?>/profile/friends/<?php echo $vars['person']['id']?>">
<?php 
if($vars['is_owner']){
	echo $this->t('profile','my friends');
}else{
	echo $this->t('profile','person friends', array('{name}'=>$vars['person']['first_name']));
}
?>
</a></td><td class="dots"></td><td>
<?php 
	if(isset($vars['person']['friend_requests_num']) and $vars['person']['friend_requests_num']>0){
		echo "<span class=\"highlight\">".$vars['person']['friend_requests_num']."</span>";
	}else if(isset($vars['person']['friends_num']) and $vars['person']['friends_num']>0){
		echo "<span>".$vars['person']['friends_num']."</span>";
	}
?>
</td></tr></table></li>
<li class="news"><table class="markup"><tr><td><a href="<?php echo PartuzaConfig::get("web_prefix")?>/profile/news/<?php echo $vars['person']['id']?>"><?php echo $this->t('common','News'); ?></a></td><td class="dots"></td><td>
<?php 

if($vars['is_owner']){
  if(isset($vars['person']['messages_num']) and $vars['person']['news_num']['unread']>0){
  	echo "<span class=\"highlight\">".$vars['person']['news_num']['unread']."</span>";
  }else if(isset($vars['person']['news_num']) and $vars['person']['news_num']['read']>0 and !$vars['is_owner']){
   	echo "<span>".$vars['person']['news_num']['read']."</span>";
  }
}
?>

</td></tr></table></li>

<?php if ($vars['is_owner']) {?>
<li class="orders"><table class="markup"><tr><td><a href="/profile/shops/<?php echo $vars['person']['id']?>"><?php echo $this->t('shop','MyShops'); ?></a></td><td class="dots"></td><td><?php echo "<span>".$vars['person']['myshops_num']."</span>";?></td></tr></table></li>
<li class="orders"><table class="markup"><tr><td><a href="/profile/orders/<?php echo $vars['person']['id']?>"><?php echo $this->t('shop','Orders'); ?></a></td><td class="dots"></td><td><?php echo "<span>".$vars['person']['orders_num']."</span>";?></td></tr></table></li>
<?php }?>

<li class="photos"><table class="markup"><tr><td><a href="/profile/photos/<?php echo $vars['person']['id']?>"><?php echo $this->t('profile','Photos'); ?></a></td><td class="dots"></td><td><?php echo "<span>".$vars['person']['photo_num']."</span>";?></td></tr></table></li>
<?php if(isset($vars['person']['car_num']) and $vars['person']['car_num']>0){ ?>
<li class="cars"><table class="markup"><tr><td><a href="/car/showcars/<?php echo $vars['person']['id']?>"><?php echo $this->t('profile','auto'); ?></a></td><td class="dots"></td><td><?php echo "<span>".$vars['person']['car_num']."</span>";?></td></tr></table></li>
<?php }?>
<li class="video"><table class="markup"><tr><td><span class="notworking" href="<?php echo PartuzaConfig::get("web_prefix")?>/profile/video/<?php echo $vars['person']['id']?>">
<?php echo $this->t('profile','Video'); ?></span></td><td class="dots"></td><td>&nbsp;</td></tr></table></li>
<li class="calendar"><table class="markup"><tr><td><span class="notworking" href="<?php echo PartuzaConfig::get("web_prefix")?>/profile/calendar/<?php echo $vars['person']['id']?>">
<?php echo $this->t('profile','Calendar'); ?></span></td><td class="dots"></td><td>&nbsp;</td></tr></table></li>
</ul>

<?php
//список друзей 
if (!$vars['is_owner']) {
	echo "<div class=\"header\">".$this->t('common','Friends')."</div><div class=\"body clearfix\">";
	foreach($vars['person']['friends'] as $friend){
		echo "<div class=\"itemphoto\">";
		echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">";
		/*if($friend['isonline']){ $this->template('profile/online.php', $vars);}*/
		
	    if($friend['thumbnail_url']){
    		echo "<img class=\"smallavatar\" src=\"{$friend['thumbnail_url']}\">";
    	}else{
	    	echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
	    }
		echo "</a></div>";
		echo "<div class=\"title\">";
		if($friend['isonline']){
			echo "<span class=\"online-inline\"></span>";
		}else{
			//echo "<span class=\"offline-inline\"></span>";
		}
		
		echo "<a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
		echo "</div>";
	}
	echo "</div>";
} 
?>
	
<!--div class="header">
<?php
echo $this->t('profile','Applications');
if ($vars['is_owner']) {
    echo "<div class=\"gadgets-gadget-title-button-bar\" style=\"margin-right:10px; margin-top: -2px;\"><a href=\"" . PartuzaConfig::get("web_prefix") . "/profile/myapps\" title=\"".$this->t('profile','Edit your applications')."\"><span class=\"ui-icon ui-icon-pencil\"></span></a></div>";
  }
?>
</div>
<ul class="profileMenu">
<?php
if (isset($vars['applications']) && count($vars['applications'])) {
  foreach ($vars['applications'] as $app) {
    $title = (! empty($app['directory_title']) ? $app['directory_title'] : $app['title']);
    $full_title = $title;
    if (strlen($title) > 21) {
      $full_title = $title;
      $title = substr($title, 0, 19)."..";
    }
    echo "<li><a title=\"$full_title\" href=\"" . PartuzaConfig::get('web_prefix') . "/profile/application/{$vars['person']['id']}/{$app['id']}/{$app['mod_id']}\">" . $title . "</a></li>";
  }
} elseif ($vars['is_owner']) {
  echo "<li><a href=\"" . PartuzaConfig::get("web_prefix") . "/profile/myapps\" title=\"Add applications\">".$this->t('profile','Add applications')."</a></li>";
}
?></ul-->
