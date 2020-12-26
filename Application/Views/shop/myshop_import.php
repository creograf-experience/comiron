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
<div id="profileContent">
<?php $this->template('shop/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('shop', 'Import Products')?></div>
		
		<div class="body import">		
			<!-- br><br><button class="btn uploadPhotos funbutton" id="<?php echo $vars['shop']['id'];?>"></button-->
			
			
			<?php 
			if(isset($vars['importdone'])){ 
				if(!isset($vars['error']) or !$vars['error']){
					echo "<div class=\"success\">".$this->t("shop", "import succesfull")."</div>";
				}else{
					echo "<div class=\"error\">".((count($vars['errorstrings'])>1)?$this->t("shop", "import errors"):$this->t("shop", "import error")).implode($vars['errorstrings'], ', ')."</div>";				
				}
			}	
			?>
			
			<p><?php echo $this->t("shop", "importdescription") ?></p>
			<br><br><br>
			<div class="header"><?php echo $this->t("shop", "importfile") ?></div>
			<div class="clearfix">
				<form id="import" action="/shop/doimport" method="POST" enctype="multipart/form-data">
					<input class="btn" type="file" name="importfile">
					<button type="submit" class="btn submit" id="<?php echo $vars['shop']['id'];?>"><?php echo $this->t('shop', 'Upload file')?></button>	
				</form>
			</div>
			<br><br><br>
			<div class="clearfix">
				<div class="header"><?php echo $this->t("shop", "importphotos") ?></div>
				<form id="importphotos" action="/shop/importphotos" method="POST" enctype="multipart/form-data">
					<input class="btn uploadPhotos" id="<?php echo $vars['shop']['id'];?>" id="file"  name="file_upload" type="file" multiple="true">	
					<!-- button type="submit" class="btn submit" id="<?php echo $vars['shop']['id'];?>"><?php echo $this->t('shop', 'Upload photos')?></button -->	
				</form>
				<div id="queue"></div>
			</div>		
			
			
			<div class="header"><?php echo $this->t("shop", "importfile ods") ?></div>
			<p><?php echo $this->t("shop", "importfile ods descr") ?></p>
			<div class="clearfix">
				<form id="import2" action="/shop/doimportods" method="POST" enctype="multipart/form-data">
					<input class="btn uploadOds" id="<?php echo $vars['shop']['id'];?>" id="file"  name="import" type="file" multiple="true">	
					
					<!--input class="btn" type="file" name="import">
					<button type="submit" class="btn submit" id="<?php echo $vars['shop']['id'];?>"><?php echo $this->t('shop', 'Upload file')?></button-->	
				</form>
				<div id="queue2"></div>
			</div>
			
			
	    	<div style="clear: both"></div>
    	</div>

  <div style="clear: both"></div>
</div>

<script>
$('input.uploadOds').uploadifive({
	'auto'      : true,
	'multi'     : false,
	//'cancelImg' : '/images/cancel.png',
	'buttonText' : "<?php  echo $this->t('shop','Upload file'); ?>",
	'buttonClass'  : 'uploadButton uploadFile',
	//'checkScript'      : 'check-exists.php',
	'formData'         : {
								//'folder'    : '/files/comment',
	                     },
	'queueID'          : 'queue2',
	'uploadScript'    : '/shop/doimportods',
	//'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
	'queueSizeLimit' : 10,
	'fileType'     : false,
	'onAddQueueItem' : function(file){
		$("#queue2").show();
	},
	'onUploadComplete' : function(file, data) {
		//alert(data);
		//file.name=data;//!COMIRON: файл переименован на сервере
		console.log(data);
		//filedata.push(file);
		//uploaddifyOnComplete(event,queueId,fileObj,response,data);
	},
	'onQueueComplete' : function(uploads) {
	}
});

$('input.uploadPhotos').uploadifive({
	'auto'      : true,
	'multi'     : true,
	//'cancelImg' : '/images/cancel.png',
	'buttonText' : "<?php  echo $this->t('common','add file'); ?>",
	'buttonClass'  : 'uploadButton uploadFile',
	//'checkScript'      : 'check-exists.php',
	'formData'         : {
								//'folder'    : '/files/comment',
	                     },
	'queueID'          : 'queue',
	'uploadScript'    : '/shop/importphotos',
	'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
	'queueSizeLimit' : 10,
	'fileType'     : false,
	'onAddQueueItem' : function(file){
		$("#queue").show();
	},
	'onUploadComplete' : function(file, data) {
		//alert(data);
		file.name=data;//!COMIRON: файл переименован на сервере
		window.location="/shop/myproducts/<?php echo $vars['shop']['id']; ?>";
		//filedata.push(file);
		//uploaddifyOnComplete(event,queueId,fileObj,response,data);
	},
	'onQueueComplete' : function(uploads) {
	}
});

</script>

<?php 	$this->template('/common/footer.php'); ?>