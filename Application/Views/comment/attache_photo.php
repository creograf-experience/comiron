

<!-- form method="post" id="<?php echo $vars['comment_id']?>">
<div class="attache_photo">
<div class="form_entry photoupload">
      <div class="form_label"><label for="photo"><?php echo $this->t('profile','Photo'); ?></label></div>
	  
      
	    <input type="file" name="UploadPhoto" id="comment_photo_upload" />
</div>
</div>

</form-->

<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
		<!-- a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a-->
	</form>

<?php 
/*
 * TODO:
список фотографий
+ссылка показать все
*/
?>

	<script>
			$('#file_upload').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				 'buttonText' : "<?php  echo $this->t('common','browse'); ?>",
				//'checkScript'      : 'check-exists.php',
				'formData'         : {
											'folder'    : '/images/comment',
				                     },
			                     
				'queueID'          : 'queue',
				'uploadScript'    : '/comment/photo_upload/<?php if(isset($vars['comment_id'])){ echo $vars['comment_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					imgdata.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
					//location.reload();
				},
				'onError': function (a, b, c, d) {
					//this.iserror=true;
					$('#file_upload').attr("iserror",1);
					if(a=="FILE_SIZE_LIMIT_EXCEEDED"){
						alert("<?php  echo $this->t('common','FILE_SIZE_LIMIT_EXCEEDED'); ?>");
					}
					if(a=="QUEUE_LIMIT_EXCEEDED"){
						alert("<?php  echo $this->t('common','QUEUE_LIMIT_EXCEEDED'); ?>");
					}
					
					if(a=="UPLOAD_LIMIT_EXCEEDED"){
						alert("<?php  echo $this->t('common','UPLOAD_LIMIT_EXCEEDED'); ?>");
					}
					
					if(a=="FORBIDDEN_FILE_TYPE"){
						alert("<?php  echo $this->t('common','FORBIDDEN_FILE_TYPE'); ?>");
					}
					
					if(a=="404_FILE_NOT_FOUND"){
						alert("<?php  echo $this->t('common','404_FILE_NOT_FOUND'); ?>");
					}
			 }
			});
			$('#file_upload').uploadifive('debug');
	</script>
<!-- script>
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
</script--> 