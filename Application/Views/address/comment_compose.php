<div id="comment_compose" class="markup"><table class="markup"><tr><td>
<a name="a_comment_<?php echo $vars['object_name']."_".$vars['id']?>"></a>
<div>
        <table class="markup"><tr><td width="70">
<?php         
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$vars['person']['id']}\">";
    
    		if($vars['person']['thumbnail_url']){
    			echo "<img class=\"smallavatar\" src=\"{$vars['person']['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    		}
?>    		
			</a></div>
		</td><td>

<form method="post" action="/comment/send/<?php echo $vars['comment_id']?>" id="form<?php echo $vars['comment_id']?>" class="comment_post" object_id="<?php echo $vars['id']?>" object_name="<?php echo $vars['object_name']?>">
		
  <div class="form_entry">
      <textarea name="text" id="text"></textarea>
  </div>
  <table class="markup"><tr><td>
  <div id="photos_<?php echo $vars['comment_id']?>"></div>
	<!--  /td><td-->

	<div class="body"><div class="icons"><br>
<?php 
	echo "<div><span><a href=\"#\" class=\"photo\"><input id=\"img_{$vars['comment_id']}\" object_id=\"{$vars['object_id']}\" object_name=\"{$vars['object_name']}\"  name=\"file_upload\" type=\"file\" multiple=\"true\"></a></span></div>";
	echo "<div><span><a href=\"#\" class=\"file\"><input id=\"file_{$vars['comment_id']}\" object_id=\"{$vars['object_id']}\" object_name=\"{$vars['object_name']}\"  name=\"file_upload2\" type=\"file\" multiple=\"true\"></a></span></div>";
?>			
	</div></div>		

	</td><td>	
	<div class="buttons">
		<input type="hidden" name="object_name" value="<?php echo $vars['object_name'];?>">
		<input type="hidden" name="object_id" value="<?php echo $vars['object_id'];?>">
		<input type="hidden" name="replyto_id" value="0">
		<button type="submit" class="btn submit" id="comment_send" ><?php echo $this->t('common','send'); ?></button>
 	</div>
 	
 	</td></tr><tr><td colspan="2">
		<div id="queue<?php echo $vars['comment_id']; ?>"></div>	
	</td></tr></table>
		
</form>
 	
 	
 	
  
  </td></tr></table>
  

  
</div>

</td></tr></table></div>


<?php 
/*
 * TODO:
список фотографий
+ссылка показать все
*/
?>
	<script>
			var imgdata=[];
			$('input#img_<?php echo $vars['comment_id']; ?>').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				'buttonText' : "<?php  echo $this->t('common','add photo'); ?>",
				'buttonClass'  : 'uploadButton uploadPhoto',
				//'checkScript'      : 'check-exists.php',
				'formData'         : {
											'folder'    : '/images/comment',
				                     },
				'queueID'          : 'queue<?php echo $vars['comment_id']; ?>',
				'uploadScript'    : '/comment/photo_upload/<?php if(isset($vars['comment_id'])){ echo $vars['comment_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				'onAddQueueItem' : function(file){
					$("#queue<?php echo $vars['comment_id']; ?>").show();
				},
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					imgdata.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
					//TODO показать картинки
					//location.reload();
				/*	comment_showphotos({"id":<?php echo $vars['comment_id']; ?>,
							"object_id":<?php echo $vars['object_id']; ?>,
							"object_name":<?php echo $vars['object_name']; ?>});*/
					$("#photos_<?php echo $vars['comment_id']; ?>").load("/comment/photos_inline/<?php echo $vars['comment_id']; ?>?object_name=<?php echo $vars['object_name']; ?>&object_id=<?php echo $vars['object_id']; ?>",
							readyfunction);
					$("#queue<?php echo $vars['comment_id']; ?>").html("");
					$("#queue<?php echo $vars['comment_id']; ?>").hide();
				},
				'onError': function (a, b, c, d) {
					//this.iserror=true;
					$('input#img_<?php echo $vars['comment_id']; ?>').attr("iserror",1);
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
			//$('input#<?php echo $vars['comment_id']; ?>').uploadifive('debug');
			
			
			var filedata=[];
			$('input#file_<?php echo $vars['comment_id']; ?>').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				'buttonText' : "<?php  echo $this->t('common','add file'); ?>",
				'buttonClass'  : 'uploadButton uploadFile',
				//'checkScript'      : 'check-exists.php',
				'formData'         : {
											'folder'    : '/files/comment',
				                     },
				'queueID'          : 'queue<?php echo $vars['comment_id']; ?>',
				'uploadScript'    : '/comment/file_upload/<?php if(isset($vars['comment_id'])){ echo $vars['comment_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : false,
				'onAddQueueItem' : function(file){
					$("#queue<?php echo $vars['comment_id']; ?>").show();
				},
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					imgdata.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
				}
			});
	</script>