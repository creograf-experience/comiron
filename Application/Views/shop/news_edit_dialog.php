<form method="post" action="/shop/news/save/<?php echo $vars['news_id']?>" id="<?php echo $vars['news_id']?>">
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="title"><?php echo $this->t('profile','Title'); ?></label></div>
      <input type="text" name="title" id="title" value="<?php echo $news['title']; ?>"  style="width:364px;"/>
    </div>
	<!-- div class="form_entry">
      <div class="form_label"><label for="anons"><?php echo $this->t('profile','Announcement'); ?></label></div>
      <textarea name="anons" id="anons" value="" style="width:364px; height:110px;" ></textarea>
    </div-->
  <div class="form_entry">
      <div class="form_label"><label for="body"><?php echo $this->t('profile','Text'); ?></label></div>
      <a href="#" id="edit"><?php //echo $this->t('profile','Edit'); ?></a>
      <a href="#" id="hideedit"><?php //echo $this->t('profile','Edit hide'); ?></a>
      <textarea name="body" id="body" style="margin: 0px 0px 9px; width: 363px;"><?php
      $news['body']=str_replace("\n","<br>\n",$news['body']);
      echo $news['body']; ?></textarea>
  </div>
      
  </div>
  <div class="form_entry photoupload">
	    <div id="queue2"></div>
        <div id="queue"></div>
	    <div id="photos"></div>
  </div>
  <div class="form_entry" style="margin-top:12px">
    <input type="hidden" name="shop_id" value="<?php echo $vars['shop_id']; ?>" />
    <table class="markup"><tr><td>
   <div class="body"><div class="icons"><br>
      	<input type="hidden" name="shop_id" value="<?php echo $vars['shop_id']; ?>" />
      	
  	<?php
  	echo "<div><span><a href=\"#\" class=\"photo\"><input id=\"message_file_upload\" name=\"UploadFile\" type=\"file\" multiple=\"true\"></a></span></div>";
	echo "<div><span><a href=\"#\" class=\"file\"><input id=\"message_photo_upload\" name=\"UploadPhoto\" name=\"file_upload2\" type=\"file\" multiple=\"true\"></a></span></div>";
    ?>	
    </div></div>		

	</td><td><div class="buttons">	
    	<button type="submit" class="btn submit" id="news_send"><?php echo $this->t('profile','send'); ?></button>
    	<!--button id="compose_cancel" class="btn btncancel"><?php echo $this->t('common','cancel'); ?></button-->
    </div></td></tr></table>
    
    
  </div>
  
</div>
</form>
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
        minHeight: 150,
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
    /*
    //tinymce
    tinymce.init({
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
            //'checkScript'      : 'check-exists.php',
            'formData'  : {
                                                                    'folder'    : '/images/messages',
                          },
            'queueID'          : 'queue',
            'uploadScript'    : '/profile/message_photo_upload/<?php if(isset($vars['news_id'])){ echo $vars['news_id']; } ?>',
            'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
            'queueSizeLimit' : 10,
            'height':20,
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
                    $("#photos").load("/profile/message_photos_inline/<?php echo $vars['news_id']; ?>?object_name=<?php echo $vars['object_name']; ?>&object_id=<?php echo $vars['object_id']; ?>",
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
            //'checkScript'      : 'check-exists.php',
            'formData'  : {
                                                                    'folder'    : '/files/messages',
                          },

            'queueID'          : 'queue2',
            'uploadScript'    : '/profile/message_file_upload/<?php if(isset($vars['news_id'])){ echo $vars['news_id']; } ?>',
            'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
            'queueSizeLimit' : 10,
            'height':20,
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