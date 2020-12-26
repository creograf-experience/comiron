<?php
//создать невидимый "черновик" новости, к которому можно будет прикреплять картинки
	//$news_id=$this->prepare_new_message('news');
	//echo $news_id;
	 
?>
<script>
    $('textarea1').redactor({
        <?php 
    if(isset($_SESSION['lang'])){
        echo "lang: '".$_SESSION['lang']."',";
    }
    ?>
        //pastePlainText: true,
        cleanOnPaste: true,
    	allowedTags: ['p'],
    	removeDataAttr: true,
    	plugins: ['pasteasplaintext'],
        buttons: ['html', 'bold', 'italic', 'underline', 'deleted', 'formatting', 'image', 'link','pasteasplaintext'], 
        formatting: ['p'],
        formattingAdd: [
            {
                tag: 'span',
                title: 'Font Size 8px',
                style: 'font-size: 8px;',
                class: 'font-size-8'
            },
            {
                tag: 'span',
                title: 'Font Size 9px',
                style: 'font-size: 9px;',
                class: 'font-size-9'
            },
            {
                tag: 'span',
                title: 'Font Size 10px',
                style: 'font-size: 10px;',
                class: 'font-size-10'
            },
            {
                tag: 'span',
                title: 'Font Size 11px',
                style: 'font-size: 11px;',
                class: 'font-size-11'
            },
            {
                tag: 'span',
                title: 'Font Size 12px',
                style: 'font-size: 12px;',
                class: 'font-size-12'
            },
            {
                tag: 'span',
                title: 'Font Size 13px',
                style: 'font-size: 13px;',
                class: 'font-size-13'
            },
            {
                tag: 'span',
                title: 'Font Size 14px',
                style: 'font-size: 14px;',
                class: 'font-size-14'
            },
            {
                tag: 'span',
                title: 'Font Size 15px',
                style: 'font-size: 15px;',
                class: 'font-size-15'
            },
            {
                tag: 'span',
                title: 'Font Size 16px',
                style: 'font-size: 16px;',
                class: 'font-size-16'
            },
            {
                tag: 'span',
                title: 'Font Size 17px',
                style: 'font-size: 17px;',
                class: 'font-size-17'
            },
            {
                tag: 'span',
                title: 'Font Size 18px',
                style: 'font-size: 18px;',
                class: 'font-size-18'
            },
        ],
    });
    
    $(".redactor-editor").focus(function(){
        $(".redactor-toolbar").css("display","block");
    });
    $(document).click( function(event){
        if( $(event.target).closest("div.redactor-box").length ) 
            return;
        $(".redactor-toolbar").css("display","none");
        event.stopPropagation();
    });
</script>

<form method="post" action="/profile/messages/send/<?php echo $vars['message_id']?>" id="<?php echo $vars['message_id']?>">
<div class="news_compose">
   <div class="form_entry">
      <div class="form_label"><label for="title"><?php echo $this->t('profile','To'); ?></label></div>
      <select name="to[]" id="toMulti" multiple="multiple" style="width:364px">
    	<!-- option value=""><?php echo $this->t('profile','Select one...'); ?></option-->	
		<?php
  		foreach ($vars['friends'] as $friend) {
  			echo "      <option value=\"{$friend['id']}\" data-icon=\"";
  			if($friend['thumbnail_url']){
    			echo $friend['thumbnail_url'];
    		}else{
    			echo "/images/people/nophoto.205x205.gif";
    		}
  			echo "\">{$friend['first_name']} {$friend['last_name']}</option>\n";
  		}
  		?>
  	</select>
      
    </div>
	<!-- div class="form_entry">
      <div class="form_label"><label for="anons"><?php echo $this->t('profile','Announcement'); ?></label></div>
      <textarea name="anons" id="anons" value="" style="width:364px; height:110px;" ></textarea>
    </div-->
  <br>
  <div class="form_entry">
      <div class="form_label"><label for="body"><?php echo $this->t('profile','Text'); ?></label></div>
      
      <textarea name="body" id="body" style="height:220px; width:344px"></textarea>
  </div>
  <!-- div class="form_entry">
      <div class="form_label"><label for="photo"><?php echo $this->t('profile','Photo'); ?></label></div>
      <input type="file" name="photo">
  </div-->
  <!-- div class="form_entry photoupload">
      <div class="form_label"><label for="photo"><?php echo $this->t('profile','Photo'); ?></label></div>
	    <input type="file" name="UploadPhoto" id="message_photo_upload" />
   </div-->

  
   <input type="hidden" name="shop_id" value="<?php echo $vars['shop_id']; ?>" />
      	
   <div class="form_entry photoupload">
	    <div id="queue2"></div>
        <div id="queue"></div>
	    <div id="photos"></div>
   </div>
   <div class="form_entry" style="margin-top:12px">
    <table class="markup"><tr>
    	<td><input id="message_file_upload" name="UploadFile" type="file" multiple="true">
    		<br><input id="message_photo_upload" name="UploadPhoto" type="file" multiple="true"></td>
    	<td width="150">&nbsp;</td>
    	<td><button type="submit" class="btn submit" id="news_send"><?php echo $this->t('profile','send'); ?></button>
    	
    		<!-- button id="compose_cancel" class="btn btncancel"><?php echo $this->t('common','cancel'); ?></button --></td>
    </tr></table>
   </div>
      
    
</div>
</form>
<script>
    
			//tinymce
/*			tinymce.init({
	    		selector: "form textarea#body",
 				language : '<?php echo $_SESSION['lang']?>',
    			//menu : 'undo redo cut copy paste selectall bold italic underline strikethrough subscript superscript removeformat formats',
    			menubar : false,
			    //inline : true,
    			toolbar: "cut copy paste |  bold italic underline strikethrough | subscript superscript",
    			statusbar: false,
			    //skin : "cirkuit",
				paste_auto_cleanup_on_paste : true,
				force_br_newlines : true,
    			valid_elements: "b,strong,i,em,u,s,strike,sub,sup,p,br",	    
			});
*/			 
			var imgdata=[];
			$('#message_photo_upload').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				'buttonText': "<?php  echo $this->t('common','browse'); ?>",
				'buttonClass'  : 'uploadButton btn',
				'height':20,
				//'checkScript'      : 'check-exists.php',
				'formData'  : {
											'folder'    : '/images/messages',
				              },
			                     
				'queueID'          : 'queue',
				'uploadScript'    : '/profile/message_photo_upload/<?php if(isset($vars['message_id'])){ echo $vars['message_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				'onAddQueueItem' : function(file){
					$("#queue").show();
				},
				'onUploadComplete' : function(file, data) { 
						file.name=data;//!COMIRON: файл переименован на сервере
						imgdata.push(file);
						//uploaddifyOnComplete(event,queueId,fileObj,response,data);
					},
				'onQueueComplete' : function(uploads) {
					//location.reload();
					$("#photos").load("/profile/message_photos_inline/<?php if(isset($vars['message_id'])){ echo $vars['message_id']; } ?>?object_name=<?php  if(isset($vars['object_name'])){ echo $vars['object_name']; } ?>&object_id=<?php  if(isset($vars['object_id'])){ echo $vars['object_id']; } ?>",
							readyfunction);
					$("#queue").html("");
					$("#queue").hide();
				},
				'onError': function (a, b, c, d) {
					//this.iserror=true;
					$('#message_file_upload').attr("iserror",1);
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

			var filedata=[];
			$('#message_file_upload').uploadifive({
				'auto'      : true,
				'multi'     : true,
				'buttonText': "<?php  echo $this->t('common','browse file'); ?>",
				'buttonClass'  : 'uploadButton btn',
				'height':20,
				//'checkScript'      : 'check-exists.php',
				'formData'  : {
											'folder'    : '/files/messages',
				              },
			                     
				'queueID'          : 'queue2',
				'uploadScript'    : '/profile/message_file_upload/<?php if(isset($vars['message_id'])){ echo $vars['message_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : false,
				'onAddQueueItem' : function(file){
					$("#queue2").show();
				},
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					filedata.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
					//location.reload();
				},
				'onError': function (a, b, c, d) {
					//this.iserror=true;
					$('#message_file_upload').attr("iserror",1);
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
			//$('#message_photo_upload').uploadifive('debug');
</script>

<!--script>
	var imgdata=[];
	$('#message_photo_upload').uploadify({
		'uploader'  : '/uberuploadcropper/scripts/uploadify.swf',
		'script'    : '/profile/message_photo_upload/<?php if(isset($vars['message_id'])){ echo $vars['message_id']; } ?>',
		'cancelImg' : '/images/cancel.png',
		'multi'     : true,
		'auto'      : true,
		'folder'    : '/images/messages',
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