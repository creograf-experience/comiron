<input type="hidden" name="isvisible" value="1">
<input type="hidden" name="car_id" class="car_id" value="<?php echo $vars['car']['id'] ?>">
<table class="education">
  		<tr>
  		<td><div class="form_entry"><?php echo $this->t('profile','marka'); ?></div></td>
  		<td><div class="form_entry"><?php echo $this->t('profile','model'); ?></div></td>
  		<td><div class="form_entry"><?php echo $this->t('profile','year'); ?></div></td>
  		<td><div class="form_entry"><?php echo $this->t('profile','complect'); ?></div></td>
  		<td>&nbsp;&nbsp;&nbsp;</td>
  		</tr>
  		<tr>
  		<td><select id="marka_id" name="marka_id">
  			<option value=""><?php echo $this->t('profile','nothing selected'); ?></option>
  		<?php 
  			foreach ($vars['car_marka'] as $marka) {
				if($_SESSION['country_content_code2']!="RU" and $marka['isrussian']){
					continue;
				}
				echo "<option value=\"{$marka['id']}\"";
				if($marka['id']==$vars['car']['marka_id']){
					echo " selected ";
				}
				echo ">{$marka['name']}</option>";
			}
		?>
  		</select></td> 
  		<td><select id="model_id" name="model_id">
  		<?php 
  		
  			foreach ($vars['car_model'] as $model) {
				echo "<option value=\"{$model['id']}\"";
				if($model['id']==$vars['car']['model_id']){
					echo " selected ";
				}
				echo ">{$model['name']}</option>";
			}
			
		?>
  		</select></td> 
  		<td><input type="number" name="year" class="year" min="1900" max="2013" placeholder="<?php echo $this->t('profile','YYYY'); ?>" value="<?php echo $vars['car']['year']; ?>" /></td>
  		<td><input type="text" name="complect" class="complect" value="<?php echo $vars['car']['complect'] ?>" /></td>
  		<td></td>
  		</tr>
  		</table>
  		<table class="education">
  		<tr><td><div class="form_entry"><?php echo $this->t('profile','photo'); ?></div></td><td>
  		
  		<div id="queue-auto"></div>
  		<div id="photos_auto"></div>
<input id="UploadPhotoAutoedit" name="UploadPhotoAuto" type="file" multiple="true">		
<script>
var imgdatacaredit=[];
			$('#UploadPhotoAutoedit').uploadifive({
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
				'uploadScript'    : '/car/photo_upload/<?php echo $vars['car']['id'] ?>',//?name=<?php echo $_SESSION['id'] ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				/*'onUploadComplete' : function(file, data) { 
						file.name=data;//!COMIRON: файл переименован на сервере
						imgdatacaredit.push(file);
						//uploaddifyOnComplete(event,queueId,fileObj,response,data);
					},
				'onQueueComplete' : function(uploads) {
					//location.reload();
				},*/
				'onAddQueueItem' : function(file){
						$("#queue-auto").show();
				},
				'onUploadComplete' : function(file, data) { 
						file.name=data;//!COMIRON: файл переименован на сервере
						//alert(data);
						imgdatacaredit.push(file);
						//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
						//TODO показать картинки
						//location.reload();
						$("#photos_auto").load("/car/photos_inline/<?php echo $vars['car']['id']; ?>", readyfunction);
						$("#queue-auto").html("");
						$("#queue-auto").hide();
				},
				'onError': function (a, b, c, d) {
						//this.iserror=true;
						$('#UploadPhotoAutoedit').attr("iserror",1);
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
			$('#UploadPhotoAutoedit').uploadifive('debug');
</script>
  		</td><td>&nbsp;</td></tr>
  		<tr><td><div class="form_entry"><?php echo $this->t('profile','descr'); ?></div></td><td><textarea id="descr" class="descr" name="descr"><?php echo $vars['car']['descr'];?></textarea></td>
  		<td><button type="submit" class="btn"><img src="/images/i_save.png">&nbsp;&nbsp;<?php echo $this->t('common','save'); ?></button></td>
  		</tr>
  		</table>
