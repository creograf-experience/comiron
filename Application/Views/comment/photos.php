<div class="photos clearfix">
<?php
unset($vars['medias']['found_rows']);
unset($vars['medias']["firstline"]);

foreach ($vars['medias'] as $media) {

	if (! isset($media['id'])) $media['id'] = 0;
	if (! isset($media['thumbnail_url'])) $media['thumbnail_url'] = $media['url'];
	?>
				        <div id="media_<?php echo $media['id'];?>" class="photo">
			            <a class="thumbnail" message_id="<?php echo $media['message_id']?>" owner_id="<?php echo $media['owner_id'];?>" id="<?php echo $media['id'];?>" href="<?php echo $media['thumbnail_url600']?>" thumbnail600="<?php echo $media['thumbnail_url600'];?>" thumbnail="<?php echo $media['thumbnail_url'];?>">
				        <!--div class="media_picture" style="background-image: url(<?php echo $media['thumbnail_url'];?>)"></div-->
				        <img src="<?php echo $media['thumbnail_url600'];?>" class="media_in_feeds"
				         <?php if($media['aheight'] && $media['awidth']){ ?> 
				        	style="max-height:none !important; height:<?php echo $media['aheight']?>px !important;width:<?php echo $media['awidth']?>px !important;"
				        <?php }?>
				        >
				        </a>
				        <!--a href="<?php echo $media['thumbnail_url600']?>"><span id="staticTitle_<?php echo $media['id']?>"><?php echo $media['title'];?></span></a-->
				
				<?php
				echo "</div>";
			}
			
			echo "</div>";
?>
</div>
