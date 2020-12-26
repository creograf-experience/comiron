<div class="header">
<?php echo $this->t('profile','Photo albums'); ?> <!--span> (<?php echo $albums['found_rows']; ?>) </span--></div>


<?php
if ($is_owner) {
?>
<div class="action">
    <a href="#" class="funbutton" id="addalbum" person_id="<?php /*echo $person['id'];*/ echo $vars['person_id'];?>" ><?php echo $this->t('profile','Add Album');?></a>
</div>    
    <div id="addAlbumDiv" title="<?php echo $this->t('profile','Add Album'); ?>" style="margin:10px; padding:2px; zoom:1; display:none">
    <div class="form_entry">
      <div class="form_label"><label for="title_null"><?php echo $this->t('profile','title'); ?></label></div>
      <input type="text" name="title_null" id="title_null" value="<?php echo isset($album['title']) ? $album['title'] : ''?>" style="width:264px" />
    </div>
    <div class="form_entry">
      <div class="form_label"><label for="description_null"><?php echo $this->t('profile','description'); ?></label></div>
      <textarea name="description_null" id="description_null" style="width:264px;"><?php echo isset($album['description']) ? $album['description'] : ''?></textarea>
    </div>
  </div>
<?php
}
?>


<div class="albums">
<?php
unset($albums['found_rows']);
foreach ($albums as $album) {
  if (!isset($album['id'])) $album['id'] = '';
  if (!isset($album['title'])) $album['id'] = '';
  if (!isset($album['thumbnail_url'])) $album['thumbnail_url'] = '/images/albums/default/noalbum160.png';
?>
    <div class="item" id="album_<?php echo $album['id'];?>" >
<?php     
if ($vars['is_owner']) {
	    		echo "<div class=\"x\"><a href=\"#\" class=\"removealbum\" owner_id=\"{$album['owner_id']}\" id=\"{$album['id']}\"><img src=\"/images/i_close.png\"></a></div>";
}
?>			
    <table class="markup"><tr><td>
        <div class="photoalbum"><a href="/profile/photos_view/<?php echo $album['owner_id'];?>/<?php echo $album['id'];?>">
          <img alt="<?php echo $album['title'];?>" title="<?php echo $album['title'];?>" src="<?php echo $album['thumbnail_url'];?>">
        </a></div>
        
	</td><td>&nbsp;</td><td>        
    <div class="title" id="staticTitle_<?php echo $album['id'];?>">
   	 <a href="/profile/photos_view/<?php echo $album['owner_id'];?>/<?php echo $album['id'];?>"><?php echo $album['title'];?></a>
    
        <?php
if ($is_owner) {
?>
    <div class="icons">
	<a class="edit" href="#" onclick="saveAlbumDialog(<?php echo $album['owner_id'];?>, <?php echo $album['id'];?>, 'updateAlbumDiv_<?php echo $album['id'];?>');" ><?php echo $this->t('common','edit'); ?></a>
	</div>
    
	<div id="updateAlbumDiv_<?php echo $album['id'];?>" style="display:none">
	   	<div class="form_entry">
    	    <div class="form_label"><label for="title_<?php echo $album['id'];?>">title</label></div>
        	<input type="text" name="title_<?php echo $album['id'];?>" id="title_<?php echo $album['id'];?>" value="<?php echo isset($album['title']) ? $album['title'] : ''?>" style="width:264px" />
   		</div>
	   	<div class="form_entry">
    	    <div class="form_label"><label for="description_<?php echo $album['id'];?>">description</label></div>
        	<textarea name="description_<?php echo $album['id'];?>" id="description_<?php echo $album['id'];?>"><?php echo isset($album['description']) ? $album['description'] : ''?></textarea>
   		</div>
	</div>
<?php
}
?>
    
    </div>

    
    <p><?php echo $album['media_count'];?> <?php echo $this->t('profile','photos'); ?></p>
    <p id="staticDescription_<?php echo $album['id'];?>"><?php echo $album['description'];?></p>
      <span><?php echo $this->t('common','created'); ?>: <?php echo date('Y-m-d', $album['created']);?></span>
      <span><?php echo $this->t('common','lasted'); ?>: <?php echo date('Y-m-d', $album['modified']);?></span>
      
      <div class="icons">
      <a href="/profile/photos_view/<?php echo $album['owner_id'];?>/<?php echo $album['id'];?>"><?php echo $this->t('common','view'); ?></a>
      </div>
      
	</td></tr></table>
      
      </div>
<?php
}
?>
    </div>
  </div>
</div>

    <div id="dialog" title="<?php echo $this->t('profile','Delete album'); ?>" style="display:none">
   		<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->t('profile','Are you sure you want to delete this album?'); ?></p>
	</div>




