<?php
//создать невидимый "черновик" авто, к которому можно будет прикреплять картинки
	$car = $this->model('car');
	$vars['car_id'] = $car->prepare_new_car(array('isvisilbe'=>'0', 'person_id'=>$_SESSION['id']));
?>

<input type="hidden" name="isvisible" value="1">
<input type="hidden" name="car_id" class="car_id" value="<?php echo $vars['car_id'] ?>">

<div class="row-fluid">
	<div class="span6">
		<div class="form_entry"><?php echo $this->t('profile','marka'); ?></div>
		<select id="marka_id" name="marka_id">
  			<option value=""><?php echo $this->t('profile','nothing selected'); ?></option>
  		<?php 
  			foreach ($vars['car_marka'] as $marka) {
				if($_SESSION['country_content_code2']!="RU" and $marka['isrussian']){
					continue;
				}
				echo "<option value=\"{$marka['id']}\">{$marka['name']}</option>";
			}
		?>
  		</select>  		
	</div>
	<div class="span6">
		<div class="form_entry"><?php echo $this->t('profile','model'); ?></div>
		<select id="model_id" name="model_id">
  		<?php 
  		/*
  			foreach ($vars['car_model'] as $model) {
				echo "<option value=\"{$model['id']}\">{$model['name']}</option>";
			}
			*/
		?>
  		</select>
	</div>
</div>


<div class="row-fluid">
	<div class="span6">
		<div class="form_entry"><?php echo $this->t('profile','year'); ?></div>
		<input type="number" name="year" class="year" min="1900" max="2013" placeholder="<?php echo $this->t('profile','YYYY'); ?>" />		
	</div>
	<div class="span6">
		<div class="form_entry"><?php echo $this->t('profile','complect'); ?></div>
		<input type="text" name="complect" class="complect" />
	</div>
</div>


<div class="row-fluid">
	<div class="span6">
		<div class="form_entry"><?php echo $this->t('profile','descr'); ?></div>
		<textarea id="descr" class="descr" name="descr"></textarea>
	</div>
	<div class="span6">
		<div class="form_entry"><?php echo $this->t('profile','photo'); ?></div>
		
  		
  		<div id="queue-auto"></div>
  		<div id="photos_auto"></div>
		<input id="UploadPhotoAuto" name="UploadPhotoAuto" type="file" multiple="true">		
<script>
var imgdatacar=[];
			$('#UploadPhotoAuto').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				'buttonText': "<?php  echo $this->t('common','upload'); ?>",
				'buttonClass'  : 'btn',
				//'checkScript'      : 'check-exists.php',
				'formData'  : {
											'folder'    : '/images/car',
				              },
				'queueID'          : 'queue-auto',
				'uploadScript'    : '/car/photo_upload/<?php echo $vars['car_id'] ?>',//?name=<?php echo $_SESSION['id'] ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				'onAddQueueItem' : function(file){
					$("#queue-auto").show();
				},
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					//alert(data);
					imgdatacar.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
					//TODO показать картинки
					//location.reload();
					$("#photos_auto").load("/car/photos_inline/<?php echo $vars['car_id']; ?>", readyfunction);
					$("#queue-auto").html("");
					$("#queue-auto").hide();
				},
				'onError': function (a, b, c, d) {
					//this.iserror=true;
					$('#UploadPhotoAuto').attr("iserror",1);
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
			$('#UploadPhotoAuto').uploadifive('debug');
</script>
	</div>
</div>
  
  	<button type="submit" class="btn submit">&nbsp;&nbsp;<?php echo $this->t('common','add'); ?></button>
