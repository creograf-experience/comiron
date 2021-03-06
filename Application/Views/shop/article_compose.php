<?php
	$rn = rand (0, 10000000);
?>
<script>
/*
    $('textarea#txt_add').redactor({
 <?php 
    if(isset($_SESSION['lang'])){
        echo "lang: '".$_SESSION['lang']."',";
    }
    ?>
    //  pastePlainText: true,
        cleanOnPaste: true,
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
*/       
</script>    

<form method="post" id="article_add_form" enctype="multipart/form-data" action="/shop/article_add/<?php echo $vars['shop']['id']; ?>">

<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name"><?php echo $this->t('shop','Title')?></label></div>
      <input type="text" name="name" id="name" value="" style="width:364px;">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="name"><?php echo $this->t('shop','Text')?></label></div>
      <textarea name="txt" id="txt_add<?php echo $rn;?>" style="width:364px;height:250px;"></textarea>
  </div>
  <br />
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Parent article in menu')?></label></div>
      <select name="article_id" id="article_id" style="width:364px;">
      	<option value="0"><?php echo $this->t('shop','none')?></option>
<?php 
	if(isset($vars['articles'])){
		foreach ($vars['articles'] as $article) {
			echo "<option value=\"{$article['id']}\">{$article['name']}</option>";
			
			if(isset($article['subs'])){
				foreach($article['subs'] as $subarticle){
					echo "<option value=\"{$subarticle['id']}\">&nbsp;&nbsp;&nbsp;{$subarticle['name']}</option>";
				}
			}			
		}
	}      		
?>		
      </select>
  </div>
  
 
  <div class="form_entry">
    <div class="form_label"></div>
    <button type="submit" class="btn submit" id="article_add"><?php echo $this->t('common','add')?></button>
  </div>
</div>
</form>

<script>
    tinymce.init({
    	selector: "#txt_add<?php echo $rn;?>",
        language : '<?php echo $_SESSION['lang']?>',
		menubar : false,
		//inline : true,
		plugins: ["paste link image searchreplace wordcount anchor table",
		             // "advlist autolink lists  charmap print preview hr  pagebreak",
		             // " visualblocks visualchars code fullscreen",
		             // "insertdatetime media nonbreaking save table contextmenu directionality",
		             // "emoticons template paste textcolor colorpicker textpattern"
		          ],
		//image_advtab: true,
		//cut copy paste | 
		toolbar: " bold italic underline strikethrough | subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",// | link image
		statusbar: false,
		//skin : "cirkuit",
		aste_auto_cleanup_on_paste : true,
		paste_as_text: true,
		force_br_newlines : true,
		valid_elements: "b,span, strong,i,em,u,s,strike,sub,sup,p,br, a, table", //img,
		paste_word_valid_elements: "b,strong,i,em,h1,h2"
    });
   //tinymce.get("textarea#txt_add").getDoc().designMode = 'On';
   
    /*
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
            'fileType'     : 'image',
            'height':20,
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
                    $("#photos").load("/profile/message_photos_inline/<?php if(isset($vars['news_id'])){ echo $vars['news_id']; } ?>?object_name=<?php  if(isset($vars['object_name'])){ echo $vars['object_name']; } ?>&object_id=<?php  if(isset($vars['object_id'])){ echo $vars['object_id']; } ?>",
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
            'fileType'     : false,
            'height':20,				
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

    $('body,html').animate({scrollTop: 0});
    */
   
</script>
