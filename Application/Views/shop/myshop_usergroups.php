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
<?php $this->template('shop/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('shop', 'User Groups')?></div>
		
		<div class="body usergroups">		
		<a class="funbutton" id="groupCompose"><?php echo $this->t('shop', 'Add Group')?></a>
<?php 		
		echo "<div id=\"group_compose_dialog\" style=\"display:none;\">";
		$this->template('shop/usergroup_compose.php', $vars);
		echo "</div>";
?>		
		
<?php
	if(isset($vars['usergroups'])){
		foreach ($vars['usergroups'] as $group) {
        	echo "<div class=\"item\" id=\"{$group['id']}\">";
       		echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$group['id']}\" name=\"{$group['name']}\"><img src=\"/images/i_close.png\"></a></div>";
        	echo "<table class=\"markup\"><tr><td>";
			echo "<div class=\"title\"><a href=\"/shop/usergroup/{$group['id']}\">{$group['name']}</a></div>";
			echo "<span class=\"icons\"><a class=\"edit editusergroup\" id=\"{$group['id']}\" href=\"#\">".$this->t("shop","edit")."</a></span>";
    		echo "</td></tr></table></div>";
		}
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
    			buttons: [{
    				text : t("common","Remove"), 
    	    		click:function() {
    					$(this).dialog('destroy');
    					window.location = '/shop/usergroup_delete/'+id;
    				}},
    				{
    					text : t("common","Cancel"),
    					click: function() {
    						$(this).dialog('destroy');
    					}
    				}
    			],
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html("<?php echo $this->t('shop', 'remove_usergroup_requst')?>");
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php $this->t("shop", "Remove from your usergroup list?"); ?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
    <div id="dialog_edit_usergroup"></div>
	
    <div style="clear: both"></div>
    </div>

  <div style="clear: both"></div>
</div>
<?php 	$this->template('/common/footer.php'); ?>