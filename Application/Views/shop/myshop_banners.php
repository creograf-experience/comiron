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

<div class="header"><?php echo $this->t('shop', 'Banners')?></div>
		
		<div class="body groups">		
		<button class="btn addBanner funbutton" id="<?php echo $vars['shop']['id'];?>"><?php echo $this->t('shop', 'Add banner')?></button>
<?php 		
		

	if(isset($vars['banners'])){
		foreach ($vars['banners'] as $banner) {
        	echo "<div class=\"item\" id=\"{$banner['id']}\">";
       		echo "<div class=\"x\"><a href=\"#\" class=\"deletebanner\" id=\"{$banner['id']}\"\"><img src=\"/images/i_close.png\"></a></div>";
        	echo "<table class=\"markup\"><tr><td><div class=\"photo\">";
    
    		if($banner['img']){
    			echo "<img src=\"{$banner['img']}\">";
    		}else{
    			echo "<img src=\"/images/banners/nophoto.gif\">";
    		}
    		
			echo "</a></div></td><td>&nbsp;</td><td>";
			echo "<div class=\"title\">{$banner['link']}</a></div>";
			if($banner['isvisible']){
    			echo "<div class=\"title\">".$this->t('shop', 'visible')."</a></div>";
    		}
			echo "<div class=\"icons\"><a class=\"edit editbanner\" id=\"{$banner['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
    		echo "</td></tr></table></div>";
                  
		}
	}
?>
	</div>
    <script type="text/javascript">
    	/*$('.remove').bind('click', function() {
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
    					window.location = '/shop/group_delete/'+id;
    				},
    				Cancel: function() {
    					$(this).dialog('destroy');
    				}
    			},
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html("Are you sure you want to remove group "+name+"?");
        		}
    		});
    		return false;
    	});*/
    </script>
    <div id="dialog" title="Remove from your friend list?" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
    <div id="dialog_edit_group"></div>
	<div style="clear: both"></div>
    </div>

  <div style="clear: both"></div>
</div>
<?php 	$this->template('/common/footer.php'); ?>