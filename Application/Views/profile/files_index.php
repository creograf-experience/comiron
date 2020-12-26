			
<?php if($vars['files']['found_rows']>0){ ?>			
			<div class="files clearfix">
<?php
			unset($vars['files']['found_rows']);
			unset($vars['files']["firstline"]);
			foreach ($vars['files'] as $file) {				
				if (! isset($file['id'])) $file['id'] = 0;
				if (! isset($file['thumbnail_url'])) $file['thumbnail_url'] = $file['url'];
?>
				        <div class="file" id="media_<?php echo $file['id'];?>">
<?php     
						if ($vars['person_id'] == $_SESSION['id']) {
					    	echo "<div class=\"x\"><a href=\"#\" class=\"removephoto\" owner_id=\"{$file['owner_id']}\" id=\"{$file['id']}\"><img src=\"/images/i_close.png\"></a></div>";
?>	    		
					    		<div id="dialog" title="Delete media" style="display:none">
					    		<p><span id="dialogSpan" class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->t('profile','Are you sure you want to delete this media?'); ?></p>
					    		</div>
<?php	    		
						}
?>			
						<?php echo $file['title'];?>
			            <a class="file" target="_blank" message_id="<?php echo $file['message_id']?>" owner_id="<?php echo $file['owner_id'];?>" id="<?php echo $file['id'];?>" href="<?php echo $file['url']?>">
				        <?php echo $this->t('common','download');?>
				        </a>&nbsp;&nbsp;
<?php 				
				echo "</div>";
			}
		echo "</div>";
	}
				
?>
	