<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php $this->template('profile/profile_info.php', $vars); ?>
</div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div id="photos">

<div class="header">
    <?php echo $albums['title']; ?> - <?php echo $medias['found_rows'];?> <?php echo $this->t('profile','photos'); ?> 
</div>

<?php
if ($is_owner) {
?>
<div class="action">		

<input id="UploadPhoto" name="UploadPhoto" type="file" multiple="true">
<div id="queue"></div>		
<script>
var imgdata=[];
			$('#UploadPhoto').uploadifive({
				'auto'      : true,
				'multi'     : true,
				'height'        : 18,
				//'cancelImg' : '/images/cancel.png',
				'buttonText': "<?php  echo $this->t('common','browse'); ?>",
				'buttonClass'  : 'funbutton',
				//'checkScript'      : 'check-exists.php',
				'formData'  : {
											'folder'    : '/images/comment',
				              },
			                     
				'queueID'          : 'queue',
				'uploadScript'    : '/profile/photos_upload/<?php echo $albums['owner_id']?>/<?php echo $albums['id'];?>',//?name=<?php echo $_SESSION['id'] ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				'onUploadComplete' : function(file, data) { 
						file.name=data;//!COMIRON: файл переименован на сервере
						imgdata.push(file);
						//uploaddifyOnComplete(event,queueId,fileObj,response,data);
					},
				'onQueueComplete' : function(uploads) {
					location.reload();
				},
				'onError': function (a, b, c, d) {
						//this.iserror=true;
						$('#UploadPhoto').attr("iserror",1);
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
			$('#UploadPhoto').uploadifive('debug');
</script>
</div>	  
<?php
}
?>


<div class="body">
<span class="link">
        <a href="/profile/photos/<?php echo $albums['owner_id'];?>"><?php echo $this->t('profile','back to albums'); ?></a>
</span>
<?php 
if (isset($albums['description'])){ ?>
  	<p><?php echo $albums['description'];?></p>
	
<?php
}
?>    
    <div id="photos-in-album" class="photos clearfix">
<?php
$this->template('/profile/photo_index.php', $vars);
?>


 
<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/profile/photos_view/{$vars['person']['id']}/{$albums['id']}/?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
	echo "<div id=\"totalpages\" content-id=\"photos-in-album\">{$vars['totalpages']}</div>";
}
?>
</div>



    </div>
    </div>
    </div>
</div>
<div style="clear: both"></div>
</div>
<!-- script type="text/javascript" src="/js/photos.js"></script -->
<?php
$this->template('/common/footer.php');
?>
