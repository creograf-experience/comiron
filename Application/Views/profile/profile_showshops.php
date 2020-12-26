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
	echo  $this->t('shop','MyShops');
}?> 
</div>
		
<div class="friends clearfix"><div class="body">		
<?php
	foreach ($vars['shops'] as $shop) {
    	    echo "<div class=\"itemfriend\" id=\"{$shop['shop_id']}\">";
			if ($vars['is_owner']) {
                            if(!in_array($shop['shop_id'], $vars['array_admin'])) echo "<div class=\"x\"><a href=\"#\" class=\"removeShop\" id=\"{$shop['shop_id']}\" name=\"{$shop['name']}\"><img src=\"/images/i_close.png\"></a></div>";
			}
        	echo "<div class=\"photo\"><a href=\"/shop/{$shop['shop_id']}\">";
                
    		if($shop['thumbnail_url']){
    			echo "<img class=\"middleavatar\" src=\"{$shop['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"middleavatar\" src=\"/images/shop/nophoto.205x205.gif\">";
    		}
    		
			echo "</a></div>";
			echo "<div class=\"title\"><a href=\"/shop/{$shop['shop_id']}\">{$shop['name']}</a></div>";
			echo "</div>";
	}
?>
</div></div>
    <script type="text/javascript">
    	$('.removeShop').bind('click', function() {
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
    			buttons: {
    				'Remove': function() {
    					$(this).dialog('destroy');
    					window.location = '<?php echo PartuzaConfig::get('web_prefix');?>/home/removeshop/'+id;
    				},
    				Cancel: function() {
    					$(this).dialog('destroy');
    				}
    			},
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html("<?php echo $this->t('shop','Remove from your client list?');?>");
                                //alert(name);
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php echo $this->t('profile','Remove from your client list?');?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
<script>
$('.item').bind('click', function(event) {
	if(event.target.nodeName!="A"){
		window.location = '/profile/'+ $(this).attr('id');
		return false;
	}
});</script>   
    
  <div style="clear: both"></div>
</div>
<?php
	$this->template('/common/footer.php');
?>