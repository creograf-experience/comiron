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

<div class="header"><?php echo $this->t('shop', 'Groups')?></div>
		
		<div class="body groups">		
		<button class="btn groupCompose funbutton" id="<?php echo $vars['shop']['id'];?>"><?php echo $this->t('shop', 'Add group')?></button>
<?php 		
		//echo "<div id=\"group_compose_dialog\" style=\"display:none;\">";
		//$this->template('shop/group_compose.php', $vars);
		//echo "</div>";

	if(isset($vars['groups'])){
		foreach ($vars['groups'] as $group) {
        	echo "<div class=\"item\" id=\"{$group['id']}\">";
       		echo "<div class=\"x\"><a href=\"#\" class=\"deletegroup\" id=\"{$group['id']}\" name=\"{$group['name']}\"><img src=\"/images/i_close.png\"></a></div>";
        	echo "<table class=\"markup\"><tr><td><div class=\"photo\"><a href=\"/shop/group/{$group['id']}\">";
    
    		if($group['thumbnail_url']){
    			echo "<img src=\"{$group['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/group/nophoto.gif\">";
    		}
    		
			echo "</a></div></td><td>";
			echo "<div class=\"title\"><a href=\"/shop/group/{$group['id']}\">{$group['name']}</a></div>";
			echo "<div class=\"icons\"><a class=\"edit editgroup\" id=\"{$group['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
    		echo "</td></tr></table></div>";
    		
    		/*echo '<pre>';
                print_r($group['subs']);
                echo '</pre>';*/
            if(isset($group['subs'])){
    			foreach($group['subs'] as $subgroup){
    			    echo "<div class=\"item subitem\"  id=\"{$subgroup['id']}\">"; //style=\"$margin\"
     		        echo "<div class=\"x\"><a href=\"#\" class=\"deletegroup\" id=\"{$subgroup['id']}\" name=\"{$subgroup['name']}\"><img src=\"/images/i_close.png\"></a></div>";
            		echo "<table class=\"markup\"><tr><td><div class=\"photo\"><a href=\"/shop/group/{$subgroup['id']}\">";

            		if($subgroup['thumbnail_url']){
                    	echo "<img src=\"{$subgroup['thumbnail_url']}\">";
            		}else{
                    	echo "<img src=\"/images/group/nophoto.gif\">";
            		}

            		echo "</a></div></td><td>";
           			echo "<div class=\"title\"><a href=\"/shop/group/{$subgroup['id']}\">{$subgroup['name']}</a></div>";
            		echo "<div class=\"icons\"><a class=\"edit editgroup\" id=\"{$subgroup['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
            		echo "</td></tr></table></div>";
            
            		/*
					// Костино
					if(isset($subgroup['subs']) and !empty($subgroup['subs'])) { 
              			  $count_pix += 60;
              			  $margin = "margin-left: ".$count_pix."px";
                		$this->get_subgroup_product($subgroup['subs'], $margin, $count_pix);
            		}
      				*/
    			}
            }   
                   
                   /*if(isset($group['subs'])){ 
                        echo $this->get_subgroup_product($group['subs']);  
                    }*/
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