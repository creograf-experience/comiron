<?php
	unset($vars['medias']["firstline"]);
	if($vars['medias']['found_rows']){
			echo "<div class=\"photos clearfix\"><div><a name=\"photos\"></a>";

			unset($vars['medias']['found_rows']);
			$i=0;
			$extra_photos=false;
			foreach ($vars['medias'] as $media) {
				if(isset($vars['news_photo_limit']) and is_numeric($vars['news_photo_limit']) and $vars['news_photo_limit']>0 and $vars['news_photo_limit']<=$i){
					$extra_photos=true;
					continue;					
				}
				$i++;				
				
				if (! isset($media['id'])) $media['id'] = 0;
				if (! isset($media['thumbnail_url'])) $media['thumbnail_url'] = $media['url'];
?>
				        <div id="media_<?php echo $media['id'];?>" class="photo">
<?php     
						if (isset($vars['person_id']) and $vars['person_id'] == $_SESSION['id']) {
					    	echo "<div class=\"x\"><a href=\"#\" class=\"removephoto\" owner_id=\"{$media['owner_id']}\" id=\"{$media['id']}\"><img src=\"/images/i_close.png\"></a></div>";
?>	    		
					    		<div id="dialog" title="Delete media" style="display:none">
					    		<p><span id="dialogSpan" class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->t('profile','Are you sure you want to delete this media?'); ?></p>
					    		</div>
<?php	    		
						}
?>			
			            <a class="thumbnail" message_id="<?php echo $media['message_id']?>" owner_id="<?php echo $media['owner_id'];?>" id="<?php echo $media['id'];?>" href="<?php echo $media['thumbnail_url600']?>" thumbnail600="<?php echo $media['thumbnail_url600'];?>" thumbnail="<?php echo $media['thumbnail_url'];?>">
				        <!-- div class="media_picture" style="background-image: url(<?php echo $media['thumbnail_url'];?>)"></div-->
				        <img src="<?php echo $media['thumbnail_url600'];?>" class="media_in_feeds"  
				        
				        <?php if($media['aheight'] && $media['awidth']){ ?> 
				        	style="height:<?php echo $media['aheight']?>px !important;width:<?php echo $media['awidth']?>px !important;"
				        <?php }?>
					
						>
				        </a>
				        <!--a href="<?php echo $media['thumbnail_url600']?>"><span id="staticTitle_<?php echo $media['id']?>"><?php echo $media['title'];?></span></a-->
				
				<?php
/*				if ($is_owner) {
				?>
				        <div id="updateMediaDiv_<?php echo $media['id'];?>" class="icons">
					    <div class="icons">
							<a class="edit" href="#" onclick="saveMediaDialog(<?php echo $media['owner_id']?>, <?php echo $media['id'];?>, 'editMedia_<?php echo $media['id'];?>');">edit</a>
						</div>
				          
				          <div id="editMedia_<?php echo $media['id'];?>" title="Edit Media" style="display:none">
				            <div class="form_entry">
				              <div class="form_label_photo"><label for="title_<?php echo $media['id'];?>">title</label></div>
				              <input style="width:140px;" type="text" name="title_<?php echo $media['id'];?>" id="title_<?php echo $media['id'];?>" value="<?php echo $media['title'];?>">
				            </div>
				            <div class="form_entry">
				              <div class="form_label_photo"><label for="thumbnail_url_<?php echo $media['id'];?>">set cover</label></div>
				              <input style="width:10px;" type="checkbox" name="thumbnail_url_<?php echo $media['id'];?>" id="thumbnail_url_<?php echo $media['id'];?>" value="true"/>
				            </div>
				            <!--
				            <div class="form_entry" style="margin-top:12px">
				              <div class="form_label"></div>
				              <input type="button" id="save" onclick="saveMedia(<?php echo $media['owner_id']?>, <?php echo $media['id']?>, 'title|title_<?php echo $media['id']?>', 'thumbnail_url|thumbnail_url_<?php echo $media['id'];?>|checkbox');" value="save" style="width:auto" class="button" />
				              <input type="button" id="cancel" onclick="hideDiv('editMedia_<?php echo $media['id']?>');" value="cancel" style="width:auto" class="button" />
				            </div>
				            -->
				          </div>
				        </div>
				<?php
				}*/
				echo "</div>";
			}

if($extra_photos){
	echo "<a href=\"/profile/news/get/{$vars['id']}\" class=\"more_photos\">".$this->t('profile','show_all_photos')."</a>";
}

echo "</div>";
echo "</div>";

}

?>

<?php 

unset($vars['comment_medias']["found_rows"]);
unset($vars['comment_medias']["firstline"]);
if(isset($vars['comment_medias']) and count($vars['comment_medias'])>0){

	echo "<div class=\"header\">".$this->t('common','user photos')."</div>";
	echo "<div class=\"photos clearfix\">";
	unset($vars['comment_medias']['found_rows']);
	foreach ($vars['comment_medias'] as $media) {

		if (! isset($media['id'])) $media['id'] = 0;
		if (! isset($media['thumbnail_url'])) $media['thumbnail_url'] = $media['url'];
?>
				        <div id="media_<?php echo $media['id'];?>" class="photo">
<?php     
						if ($vars['person_id'] == $_SESSION['id']) {
					    	echo "<div class=\"x\"><a href=\"#\" class=\"removephoto\" owner_id=\"{$media['owner_id']}\" id=\"{$media['id']}\"><img src=\"/images/i_close.png\"></a></div>";
?>	    		
					    		<div id="dialog" title="Delete media" style="display:none">
					    		<p><span id="dialogSpan" class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->t('profile','Are you sure you want to delete this media?'); ?></p>
					    		</div>
<?php	    		
						}
?>			
			            <a class="thumbnail" message_id="<?php echo $media['message_id']?>" owner_id="<?php echo $media['owner_id'];?>" id="<?php echo $media['id'];?>" href="<?php echo $media['thumbnail_url600']?>" thumbnail600="<?php echo $media['thumbnail_url600'];?>" thumbnail="<?php echo $media['thumbnail_url'];?>">
				        <img src="<?php echo $media['thumbnail_url600'];?>" class="media_in_feeds"  style="height:<?php echo $media['aheight']?>px !important;width:<?php echo $media['awidth']?>px !important;">
				        <!-- div class="media_picture" style="background-image: url(<?php echo $media['thumbnail_url'];?>)"></div-->
				        </a>
				        <!--a href="<?php echo $media['thumbnail_url600']?>"><span id="staticTitle_<?php echo $media['id']?>"><?php echo $media['title'];?></span></a-->
				
				<?php
/*				if ($is_owner) {
				?>
				        <div id="updateMediaDiv_<?php echo $media['id'];?>" class="icons">
					    <div class="icons">
							<a class="edit" href="#" onclick="saveMediaDialog(<?php echo $media['owner_id']?>, <?php echo $media['id'];?>, 'editMedia_<?php echo $media['id'];?>');">edit</a>
						</div>
				          
				          <div id="editMedia_<?php echo $media['id'];?>" title="Edit Media" style="display:none">
				            <div class="form_entry">
				              <div class="form_label_photo"><label for="title_<?php echo $media['id'];?>">title</label></div>
				              <input style="width:140px;" type="text" name="title_<?php echo $media['id'];?>" id="title_<?php echo $media['id'];?>" value="<?php echo $media['title'];?>">
				            </div>
				            <div class="form_entry">
				              <div class="form_label_photo"><label for="thumbnail_url_<?php echo $media['id'];?>">set cover</label></div>
				              <input style="width:10px;" type="checkbox" name="thumbnail_url_<?php echo $media['id'];?>" id="thumbnail_url_<?php echo $media['id'];?>" value="true"/>
				            </div>
				            <!--
				            <div class="form_entry" style="margin-top:12px">
				              <div class="form_label"></div>
				              <input type="button" id="save" onclick="saveMedia(<?php echo $media['owner_id']?>, <?php echo $media['id']?>, 'title|title_<?php echo $media['id']?>', 'thumbnail_url|thumbnail_url_<?php echo $media['id'];?>|checkbox');" value="save" style="width:auto" class="button" />
				              <input type="button" id="cancel" onclick="hideDiv('editMedia_<?php echo $media['id']?>');" value="cancel" style="width:auto" class="button" />
				            </div>
				            -->
				          </div>
				        </div>
				<?php
				}*/
				echo "</div>";
	}
	echo "</div>";	
}


?>
