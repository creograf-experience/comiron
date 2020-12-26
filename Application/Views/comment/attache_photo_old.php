
<form method="post" id="<?php echo $vars['comment_id']?>">
<div class="attache_photo">
<div class="form_entry photoupload">
      <div class="form_label"><label for="photo"><?php echo $this->t('profile','Photo'); ?></label></div>
	    <input type="file" name="UploadPhoto" id="comment_photo_upload" />
</div>
</div>

<!--button type="button" id="comment_showphotos" comment_id="<?php echo $vars['comment_id']?>"><?php echo $this->t('common','done'); ?></button-->

</form>

<?php 
/*
 * TODO:
список фотографий
+ссылка показать все
*/
?>

<script>
	var imgdata=[];
	$('#comment_photo_upload').uploadify({
		'uploader'  : '/uberuploadcropper/scripts/uploadify.swf',
		'script'    : '/comment/photo_upload/<?php if(isset($vars['comment_id'])){ echo $vars['comment_id']; } ?>',
		'cancelImg' : '/images/cancel.png',
		'multi'     : true,
		'auto'      : true,
		'folder'    : '/images/comment',
		'fileExt': "*.jpg;*.jpeg;*.gif;*.png",
		'sizeLimit': 2000000,
		'displayData': 'percentage',
		'onComplete': function(event,queueId,fileObj,response,data){
			fileObj.name=response;//!COMIRON: файл переименован на сервере  TODO: можно показать прикрепленные картинки
			imgdata.push(fileObj);
			uploaddifyOnComplete(event,queueId,fileObj,response,data);
		},
		'onAllComplete': function(){
			//alert("done");
			//location.reload();
		}
	});
</script> 