<?php
$thumb = $vars['shop']['thumbnail_big_url'];
if (!$thumb) {
  $thumb = '/images/shop/nophoto205.gif';
}
?><a class="avatar" href="/shop/<?php echo $vars['shop']['id']?>" rel="me"><img src="<?php echo $thumb?>" /></a>


	<div class="clearfix1 country">
	<?php
	
	if($vars['shop']['country_content_code2'] and $vars['shop']['country_content_code2'] != $vars['person']['country_content_code2']){

		$country_content=$this->model('country_content');
   		$country=$country_content->get_country($vars['shop']['country_content_code2'], $this->get_cur_lang());
   		
		echo $this->t('shop','Original country').": <img src=\"/images/country/{$vars['shop']['country_content_code2']}.gif\"> ".$country['name'];
	}
	?>
	<div>
	</div>
	<?php
	//if(!isset($vars['shop']['is_owner']) or !$vars['shop']['is_owner']){
		 if (isset($_SESSION['id']) and (!isset($vars['shop']['is_client']) || !$vars['shop']['is_client']) && $vars['shop']['is_clientrequested']==0) {?>
	
		<a  class="button btn" href="/shop/addclient/<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop','Add as client'); ?></a>

	<?php }
		  if(isset($vars['shop']['is_clientrequested']) && $vars['shop']['is_clientrequested']){
		  	echo "<div class='text-info'>".$this->t("shop", "You sent client request")."</div>";
		  }
		  if (isset($vars['shop']['is_client']) && $vars['shop']['is_client']) {?>
		<a class="button btn" href="#" id="sendButton"><?php echo $this->t('shop','Send a message'); ?></a>
<script>

$('#sendButton').bind('click', function() {
	$("#send_dialog").dialog({
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
<form action="/shop/messages/send" method="post">
<?php 
  $vars['to']=$vars['shop']['id'];
  $this->template('shop/shop_compose_message.php', $vars);
?>
</form>
</div>
		
<!--<a class="button btn" href="#" id="removeButton"><?php echo $this->t('shop','Remove from clients'); ?></a>-->
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
		buttons: [{
			text : t("common","Remove"), 
			click : function() {
				$(this).dialog('destroy');
				window.location = '<?php echo PartuzaConfig::get('web_prefix');?>/shop/removeclient/<?php echo $vars['shop']['id']?>';
			}},
			{
			text: t("common", "No"),
			click : function() {
				$(this).dialog('destroy');
			}}]
		}
	);
});
</script>
	<div id="delete_dialog" title="<?php echo $this->t('shop', 'Remove from your client list?')?>" style="display:none">
		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		<?php echo $this->t('shop', 'remove_client_requst',array('{name}'=>$vars['shop']['name'])); ?>
		</p>
	</div>

	<?php }
	//} //не владелец магазина
	?>
	
	</div>


<!-- div class="header"><?php echo $this->t('shop', 'Menu') ?></div-->
<div class="<?php  if($vars['shop']['menustyle']){ echo $vars['shop']['menustyle'];} ?>">

<ul class="articlesMenu">
<?php
if(isset($vars['articles'])){
	foreach ($vars['articles'] as $article) {
 		echo "<li><a href=\"/shop/article/{$article['id']}\" ".((isset($vars['article']) and $article['id']==$vars['article']['id'])?" class=\"active\" ":"").">{$article['name']}</a></li>";
 		if(isset($article['subs'])){
 			echo "<ul class=\"subarticles\">";
 			foreach ($article['subs'] as $subarticle) {
 				echo "<li><a href=\"/shop/article/{$subarticle['id']}\" ".((isset($vars['article']) and $article['id']==$vars['article']['id'])?" class=\"active\" ":"").">{$subarticle['name']}</a></li>";
 			}
 			echo "</ul>";
 		}
	}
}
?>
</ul>
</div>

<div class="header"><?php echo $this->t('shop', 'Categories') ?></div>

<div class="<?php  if($vars['shop']['menustyle']){ echo $vars['shop']['menustyle'];} ?>">
<ul class="groupMenu">
<?php
if(isset($vars['groups'])){
	foreach ($vars['groups'] as $group) {
 		echo "<li>";
 		if(isset($group['num_of_subs']) and $group['num_of_subs']>0){
 			echo "<span class=\"num\">".$group['num_of_subs']."</span>";
 		}
 		echo "<a href=\"/shop/group/{$group['id']}\" ".((isset($vars['group']) and $group['id']==$vars['group']['id'])?" class=\"active\" ":"").">{$group['name']}</a></li>";
 		if(isset($group['subs'])){
 			echo "<ul class=\"subgroups\">";
 			foreach ($group['subs'] as $subgroup) {
 				echo "<li><a href=\"/shop/group/{$subgroup['id']}\" ".((isset($vars['group']) and $group['id']==$vars['group']['id'])?" class=\"active\" ":"").">{$subgroup['name']}</a></li>";
 			}
 			echo "</ul>";
             /*       if(isset($vars['group'])) {
                        $this->get_subgroup_shop($group['subs'], $vars['group'], $vars['group']['id']);
                    } else {
                        $this->get_subgroup_shop($group['subs'], false, false);
                    }
			*/
 		}
	}
}
?>
</ul>
</div>

<div class="header"><?php echo $this->t('shop', 'Contact') ?></div>
<?php if(isset($vars['shop']['shop_phone_numbers'])): ?>
<div class="ots">
<b><?php echo $this->t('shop','public phone numbers')?></b>: <br />
    <?php 
    $i=1;
    $count = count($vars['shop']['shop_phone_numbers']);
    foreach($vars['shop']['shop_phone_numbers'] as $phone) {
        if($count > $i) echo trim($phone['phone_number']).', ';
        else echo trim($phone['phone_number']);
        
        $i++;
    }
    ?>
</div>
<?php endif ?>
<?php if(isset($vars['shop']['shop_emails'])): ?>
<div class="ots">
<b><?php echo $this->t('shop','public emails')?></b>: <br />
    <?php 
    $i=1;
    $count = count($vars['shop']['shop_emails']);
    foreach($vars['shop']['shop_emails'] as $email) {
        if($count > $i) echo trim($email['email']).', ';
        else echo trim($email['email']);
        
        $i++;
    }
    ?>
</div>
<?php endif ?>
<?php if(isset($vars['shop']['shop_urls'])): ?>
<div class="ots">
<b><?php echo $this->t('shop','public urls')?></b>: <br />
    <?php 
    $i=1;
    $count = count($vars['shop']['shop_urls']);
    foreach($vars['shop']['shop_urls'] as $url) {
        if($count > $i) echo trim($url['url']).', ';
        else echo trim($url['url']);
        
        $i++;
    }
    ?>
</div>
<?php endif ?>
	
<?php
//список друзей 
if (!isset($vars['shop']['is_owner']) and is_array($vars['shop']['clients'])) {
	echo "<div class=\"header\">".$this->t('shop','Clients')."</div><div class=\"body clearfix\">";
	foreach($vars['shop']['clients'] as $friend){
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
<div>
<?php   $this->template('/shop/filter.php', $vars); ?>
</div>
