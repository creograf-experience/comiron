<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('shop/myshop_info.php', $vars);
?>
</div>
<div id="profileRight">
<?php
$this->template('shop/myshop_right.php', $vars);
?>
</div>
<div id="profileContentWide">
<?php $this->template('shop/topheader.php', $vars);  ?>

<?php
if($vars['shop']['client_requests_num']>0){
?>

	<div class="header"><?php echo $this->t("shop","Client requests"); ?> <!--(<strong><?php echo $vars['shop']['client_requests_num']?></strong>)--></span></div>
	<div class="friends clearfix1"><div class="body1">
	<?php 
	foreach ($vars['client_requests'] as $friend) {
		echo "<div class=\"itemfriend\" id=\"{$friend['id']}\">";
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
		if ($vars['shop']['is_owner']) {
      echo "<div class=\"bigx\">";
      echo "<a href=\"/shop/acceptclient/{$vars['shop']['id']}/{$friend['id']}\" class=\"accept btn btn-small editshop\">".$this->t("common", "yes")."</a>";
      echo "<a href=\"/shop/rejectclient/{$vars['shop']['id']}/{$friend['id']}\" class=\"reject btn btn-small editshop\" id=\"{$friend['id']}\" name=\"{$friend['first_name']}\">".$this->t("common", "no")."</a>";
      echo "</div>";        
    }
    

    echo "</div>";
	}
	?>	
	</div></div>
<?php 
}
?>	

<div class="friends clearfix">
<div class="header"><?php echo $this->t("shop","Clients"); ?> <!--(<?php echo $vars['clients_count']?>)--></span></div>
	
<div class="topinfo clearfix">

<form id="searchclient" class="filter" action="/shop/searchclient/" method="post">
<input type="hidden" name="shop_id" value="<?php echo $vars['shop']['id']; ?>">
<table class="markup"><tr><td>
<input type="text" id="client_name" name="name" value="<?php if(isset($vars['searchclient']['name'])) echo $vars['searchclient']['name']; ?>">
</td><td>&nbsp;</td><td>
<select id="usergroup_id" name="usergroup_id">
<option value=""><?php echo $this->t('common', 'all'); ?></option>
<?php
foreach ($vars['usergroups'] as $group) {
	echo "<option ".((isset($vars['searchclient']['usergroup_id']) and $group['id']==$vars['searchclient']['usergroup_id'])?" selected ":"")." value=\"{$group['id']}\">{$group['name']}</option>";
} 
?>
</select>
</td><td>
<button type="submit" class="btn search" id="search_small"><?php echo $this->t('common', 'find'); ?></button>
</td></tr></table>
</form>

</div>  

	
	<div class="body">
	<?php
	foreach ($vars['clients'] as $friend) {
		echo "<div class=\"itemfriend\" id=\"{$friend['id']}\">";
		if ($vars['shop']['is_owner']) {
			echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$friend['id']}\" data-shop-id=\"{$vars['shop']['id']}\" name=\"{$friend['first_name']}\"><img src=\"/images/i_close.png\"></a></div>";
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
		echo "<span class=\"icons\"><a class=\"edit edituser\" id=\"{$friend['id']}\" shop_id=\"{$vars['shop']['id']}\" href=\"#\">".$this->t("shop","edit")."</a></span>";		
		echo "</div>";
	}
?>
	</div></div>
    <script type="text/javascript">
    	$('.remove').bind('click', function() {
        	var id=$(this).attr("id");
                var shop_id = $(this).attr("data-shop-id");
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
    					window.location = '/shop/removeclient/'+shop_id+'/'+id;
    					}
    				},	
    				{ text: t('common', 'Cancel'),
         				'class':'btn',
         				click: function() {
        					$(this).dialog('destroy');
    					}
    				}],
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html("<?php echo $this->t('shop','remove_client_requst') ?>");
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php echo $this->t('profile', 'Remove from your client list?')?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
    <div style="clear: both"></div>
    </div>

  <div style="clear: both"></div>
</div>
<div id="dialog_edit_user"></div>
<?php 	$this->template('/common/footer.php'); ?>