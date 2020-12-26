<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php $this->template('profile/profile_info.php', $vars); ?>
</div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); 

if ($is_owner) {
?>
<div class="header"><?php echo $this->t('profile','Upload Photo'); ?></div>
<div class="body">
	    <input type="file" name="UploadPhoto" id="UploadPhoto" />
	    <br>
</div>	    
		<script type="text/javascript">
		var imgdata=[];
		$(document).ready(function(){
			$('#UploadPhoto').uploadify({
				'uploader'  : '/uberuploadcropper/scripts/uploadify.swf',
				'script'    : '/profile/photos_upload/<?php echo $albums['owner_id']?>/<?php echo $albums['id'];?>',//?name=<?php echo $_SESSION['id'] ?>',
				'cancelImg' : '/images/cancel.png',
				'multi'     : true,//true
				'auto'      : true,
				'folder'    : '/images/people',
				'fileExt': "*.jpg;*.jpeg;*.gif;*.png",
				'sizeLimit': 2000000,
				'displayData': 'percentage',
				'onComplete': function(event,queueId,fileObj,response,data){
					
					fileObj.name=response;//!COMIRON: файл переименован на сервере
					imgdata.push(fileObj);
					uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onAllComplete': function(){
						location.reload();
				},
			});
		});
		</script>
  
<?php
}
?>

   <div class="header"><?php echo $albums['title']; ?> (<?php echo $medias['found_rows'];?> <?php echo $this->t('profile','photos'); ?>) 
      <span class="link">
        <a href="/profile/photos/<?php echo $albums['owner_id'];?>"><?php echo $this->t('profile','back to albums'); ?></a>
      </span>
</div>
	<div class="body">

<?php 
if (isset($albums['description'])){ ?>
  	<p><?php echo $albums['description'];?></p>
	
<?php
}
?>    
    <div class="photos clearfix">
    
<?php
$i = 0;
unset($medias['found_rows']);
foreach ($medias as $media) {
   
  
  if (! isset($media['id'])) $media['id'] = 0;
  if (! isset($media['thumbnail_url'])) $media['thumbnail_url'] = $media['url'];
?>
      <div id="media_<?php echo $media['id'];?>" class="item photo">
<?php     
if ($vars['is_owner']) {
	    		echo "<div class=\"x\"><a href=\"#\" class=\"removephoto\" owner_id=\"{$media['owner_id']}\" id=\"{$media['id']}\"><img src=\"/images/i_close.png\"></a></div>";
?>	    		
	    		<div id="dialog" title="Delete media" style="display:none">
	    		<p><span id="dialogSpan" class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->t('profile','Are you sure you want to delete this media?'); ?></p>
	    		</div>
<?php	    		
}
?>			
          <a class="thumbnail" album_id="<?php echo $media['album_id']?>" owner_id="<?php echo $media['owner_id'];?>" id="<?php echo $media['id'];?>" href="/profile/photo_view/<?php echo $media['owner_id']?>/<?php echo $media['album_id']?>/<?php echo $media['id']?>" thumbnail600="<?php echo $media['thumbnail_url600'];?>" thumbnail="<?php echo $media['thumbnail_url'];?>">
          <div class="media_picture" style="background-image: url(<?php echo $media['thumbnail_url'];?>)"></div></a>
          <a href="/profile/photo_view/<?php echo $media['owner_id']?>/<?php echo $media['album_id']?>/<?php echo $media['id']?>"><span id="staticTitle_<?php echo $media['id']?>"><?php echo $media['title'];?></span></a>&nbsp;

<?php
if ($is_owner) {
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
}
?>
      </div>
<?php
}
?>


 
<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/profile/news/{$vars['person']['id']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
	echo "<div id=\"totalpages\">{$vars['totalpages']}</div>";
}
?>
</div>



    </div>
    </div>
    </div>
</div>
<div style="clear: both"></div>
<!-- script type="text/javascript" src="/js/photos.js"></script -->
<?php
$this->template('/common/footer.php');
?>
