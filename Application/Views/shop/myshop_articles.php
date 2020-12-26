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

<div class="header"><?php echo $this->t('shop','Menu')?></div>
		
<div class="articles">		
	<div class="body">		
		<div class="action">
		    <a href="#" class="funbutton" id="articleCompose" ><?php echo $this->t('shop','Add menu item')?></a>
		</div>

<?php 		
		echo "<div id=\"article_compose_dialog\">";// style=\"display:none;\">";
		//	$this->template('shop/article_compose.php', $vars);
		echo "</div>";
?>		
		
<?php
	if(isset($vars['articles'])){
		foreach ($vars['articles'] as $article) {
        	echo "<div class=\"item\" id=\"{$article['id']}\">";
       		echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$article['id']}\" name=\"{$article['name']}\"><img src=\"/images/i_close.png\"></a></div>";
        	echo "<div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/shop/article/{$article['id']}\">{$article['name']}</a></div>";
			echo "<div class=\"icons\"><a class=\"edit editarticle\" id=\"{$article['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
    		echo "</div>";
    		
    		
    		if(isset($article['subs'])){
    			foreach($article['subs'] as $subarticle){
    				echo "<div class=\"item subitem\"  id=\"{$subarticle['id']}\">";
    				echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$subarticle['id']}\" name=\"{$subarticle['name']}\"><img src=\"/images/i_close.png\"></a></div>";
    				echo "<div class=\"title\"><a href=\"/group/{$subarticle['id']}\">{$subarticle['name']}</a></div>";
    				echo "<div class=\"icons\"><a class=\"edit editarticle\" id=\"{$subarticle['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
    				echo "</div>";
    			}
    		}
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

    			buttons: [{ text: t('common', 'Remove'),
     				'class':'btn',
     				click: function() {
    					$(this).dialog('destroy');
    					window.location = '/shop/article_delete/'+id;
    					}
    				},	
    				{ text: t('common', 'Cancel'),
         				'class':'btn',
         				click: function() {
        					$(this).dialog('destroy');
    					}
    				}]
    			,
    			open:function(){
    				$("#dialog").find(".question").css({"border":"1px solid red;"}).html(t('common',"Are you sure you want to remove menu item") + " "+name+"?");
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php echo $this->t('shop','Remove from article list?')?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
    <!--div id="dialog_edit_article"></div-->
	<script>
	$('.item').bind('click', function(event) {
		if(event.target.nodeName!="A"){
			window.location = '/shop/article/'+ $(this).attr('id');
			return false;
		}
	});
    	</script>
    <div style="clear: both"></div>
    </div>

  <div style="clear: both"></div>
</div>
</div>

<?php 	$this->template('/common/footer.php'); ?>