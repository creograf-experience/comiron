<form method="post" id="group_add_form" enctype="multipart/form-data" action="/shop/group_edit/<?php echo $vars['group_id']; ?>">
<input type="hidden" name="shop_id" value="<?php echo $vars['shop_id'];?>">
<input type="hidden" name="id" id="group_id" value="<?php echo $vars['group_id'];?>">

<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Name')?></label></div>
      <input type="text" name="name" id="name" value="" style="width:364px;">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Parent Group')?></label></div>
      <select name="group_id" id="group_id" style="width:364px;">
      	<option value="0"><?php echo $this->t('common','none')?></option>
<?php 
	if(isset($vars['groups'])){ 
		foreach ($vars['groups'] as $group) {
			echo "<option value=\"{$group['id']}\">{$group['name']}</option>";
			
			if(isset($group['subs'])){
				foreach($group['subs'] as $subgroup){
					echo "<option value=\"{$subgroup['id']}\">&nbsp;&nbsp;&nbsp;{$subgroup['name']}</option>";
				}
                           // $this->get_subgroup_compose($group['subs']);
			}			
		}
	}      		
?>		
      </select>
  </div>
  
    <div class="form_entry  line">
      <div class="form_label"><label for="image"><?php echo $this->t('shop', 'Visible for users') ?></label></div>
      <select name="visible[]" id="options_product2" class="options_product" multiple="multiple">
       	<?php
    		$access=PartuzaConfig::get('shop_access_types');
    	?>
    	<!-- option value=""><?php echo $this->t('profile','Select one...'); ?></option-->
    	<option nocheck="nocheck" selected  value="5"><?php echo $this->t('shop',$access['5'])?></option>
    	<option nocheck="nocheck"  value="0"><?php echo $this->t('shop',$access['0'])?></option>
    	<option nocheck="nocheck"  value="1"><?php echo $this->t('shop',$access['1'])?></option>
    	<option nocheck="nocheck"  value="2"><?php echo $this->t('shop',$access['2'])?></option>
    	<option nocheck="nocheck"  value="3"><?php echo $this->t('shop',$access['3'])?></option>
    	<option nocheck="nocheck"  value="4"><?php echo $this->t('shop',$access['4'])?></option>    	
		<?php
  		foreach ($vars['usergroups'] as $group) {
  			echo "      <option value=\"g{$group['id']}\" data-icon=\"/images/people/nophoto.205x205.gif\"";
  			echo ">{$group['name']}</option>\n";
  		}
  		?>
  	</select>
    </div>
    
  <div class="form_entry">
      <div class="form_label"><label for="image"><?php echo $this->t('common','Image')?></label></div>
      <!-- input type="file" name="thumbnail"-->
      	<table><tr><td>
       	<img id="PhotoPrev2" src="/images/group/nophoto.gif" />
       	</td><td>&nbsp;</td><td>
    	<input type="file" name="UploadPhoto" id="UploadPhoto2" />	
		</td></tr></table>
    	<div id="queue2" style="display:none;"></div>
      
  </div>
  
  
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn submit" id="group_add"><?php echo $this->t('common','add')?></button></td></tr></table>
  </div>
</div>
</form>


<script>
$(document).ready(function() {

	readyfunction();
	
	$('#UploadPhoto2').uberuploadcropper({
		//---------------------------------------------------
		// uploadifive options..
		//---------------------------------------------------
		'displayData': 'percentage',
		'auto'      : true,
		'multi'     : false,
		'cancelImg' : '/images/cancel.png',
		'buttonText': "<?php  echo $this->t('shop','set photo'); ?>",
		'buttonClass'  : 'btn',
		//'buttonClass'  : 'uploadButton',
		//'checkScript'      : 'check-exists.php',
		'formData'  : {
									'folder'    : '/images/group',
									'id':<?php echo $vars['group_id']?>,
		              },
		'queueID'          : 'queue2',
		'uploadScript'    : '/shop/uploadgroupimg',
		'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
		'fileType'     : 'image',
//		'displayData': 'percentage',
		 onError: function (a, b, c, d) {
			//this.iserror=true;
			$('#UploadPhoto2').attr("iserror",1);
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
			
			/*
			if (d.status == 404)
				alert('Could not find upload script. Use a path relative to: '+'');
			else if (d.type === "HTTP")
				alert('error '+d.type+": "+d.status);
			else if (d.type ==="File Size")
				alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
			else
				alert('error '+d.type+": "+d.text);
			*/
		},
		//onSelect
		'onAddQueueItem':function(){
			$('#UploadPhoto2').attr("iserror",0);
		},
		'onProgress': function(file, e) {
	        if (e.lengthComputable) {
	           var percent = Math.round((e.loaded / e.total) * 100);
	        }
	        if(percent==100){
	        	$("#ajax-loader").show();
		    }else{
	        	$("#ajax-loader").hide();
			}
	        /*file.queueItem.find('.fileinfo').html(' - ' + percent + '%');
	        file.queueItem.find('.progress-bar').css('width', percent + '%');*/
	    },
		//---------------------------------------------------
		// cropper options..
		//---------------------------------------------------
		'aspectRatio': 1,//пропорции 
		'allowSelect': true,			//can reselect
		'allowResize' : true,			//can resize selection
		'setSelect': [ 0, 0, 200, 200 ],	//these are the dimensions of the crop box x1,y1,x2,y2
		'minSize': [ 100, 100 ],		//if you want to be able to resize, use these
		//'maxSize': [ 100, 100 ],
		'cropsource': true,

		//---------------------------------------------------
		//now the uber options..
		//---------------------------------------------------
		'zIndex': 111100,
		'iserror': false,
		'folder'    : '/images/group/',
		'id':<?php echo $vars['group_id']?>,
		'cropScript': '/shop/cropgroupimg',
		/*'onSelect': function(event,queueID,fileObj){
		   $('#opc_file_imagem').fileUploadSettings('scriptData', '&amp;name='+ queueID);
		   $('#opc_file_imagem').fileUploadStart(queueID);
		},*/
/*					onError: function(event,queueID,fileObj,errorObj){
			alert(errorObj[\"type\"]+\" - \"+errorObj[\"status\"]+\" - \"+errorObj[\"text\"]);
		},*/
		'onComplete': function(imgs,data){ 
			//$('#PhotoPrev').attr('src','/images/people/'+imgs[0].name +'?d='+ (new Date()).getTime()); 
			$('#PhotoPrev2').attr('src','/images/group/'+data +'?d='+ (new Date()).getTime());//COMIRON: data - то, что возвращает php
		}
	});

	
});
</script>