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
<div id="profileContent">
<?php $this->template('shop/topheader.php', $vars); ?>

	<div class="gadgets-gadget-chrome">
		<div class="gadgets-gadget-title-bar"><span class="gadgets-gadget-title"><?php echo $vars['shop']['name']."'s"?> friends (<?php echo $vars['friends_count']?>)</span></div>
		
		<div class="body">		
<?php
	foreach ($vars['friends'] as $friend) {
        echo "<div class=\"item\">";
			if ($vars['is_owner']) {
	    		echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$friend['id']}\" name=\"{$friend['first_name']}\"><img src=\"/images/i_close.png\"></a></div>";
			}
			echo "<table class=\"markup\"><tr><td>";
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">";
    
    		if($friend['thumbnail_url']){
    			echo "<img src=\"{$friend['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/people/nophoto.gif\">";
    		}
    		
			echo "</a></div></td><td>";
			echo "<div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
			echo "<p>{$friend['activity']}</p>";
			echo "</td></tr></table>";
			
    	echo "</div>";
	}
?>
	</div>
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
    					window.location = '/shop/removefriend/'+id;
    					}
    				},	
    				{ text: t('common', 'Cancel'),
         				'class':'btn',
         				click: function() {
        					$(this).dialog('destroy');
    					}
    				}],
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html($this->t('profile','remove_friend_requst', array('{name}'=>name)));
    				alert(name);
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php echo $this->t('profile', 'Remove from your friend list?')?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
<script>
$('.friendEntry').bind('click', function() {
	window.location = '/profile/'+ ($(this).attr('id').replace('friendEntry', '') * 1);
	return false;
});
</script>
    <div style="clear: both"></div>
    </div>

  <div style="clear: both"></div>
</div>
<?php 	$this->template('/common/footer.php'); ?>