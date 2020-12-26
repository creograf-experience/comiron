<script>
    $('textarea').redactor({
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
<div id="message_compose"><div class="body">
        <table class="markup"><tr><td width="40">
<?php 
        	echo "<div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$vars['personto']['id']}\">";
        	if($vars['personto']['isonline']){
        		$this->template('profile/online.php', $vars);
        	}
        	 
    		if($vars['personto']['thumbnail_url']){
    			echo "<img class=\"smallavatar\" src=\"{$vars['personto']['thumbnail_url']}\">";
    		}else{
    			echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
    		}

			echo "</a></div>";
?>			
		</td><td>&nbsp;</td><td>
  		<div id="queue<?php echo $vars['message_id']; ?>"></div>		
  		<div id="photos_<?php echo $vars['message_id']?>"></div>
	
<?php
/*echo '<pre>';
print_r($vars);
echo '</pre>';*/
?>
<form method="post" action="/shop/messages/send_inline/<?php echo $vars['message_id']?>" id="form<?php echo $vars['message_id']?>" to="<?php echo $vars['to'] ?>" class="message_post_shop">

<div class="form_entry">
  <textarea name="body" id="text"></textarea>
  </div>
  <table class="markup"><tr><td>
	<!--  /td><td-->
	
	<div class="buttons">
		<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $vars['shopID'];?>">
                <input type="hidden" name="to" id="to" value="<?php echo $vars['to'];?>">
		<input type="hidden" name="from" id="from" value="<?php echo $_SESSION['id'];?>">
		<table class="markup"><tr><td>
				<?php 
		echo "<div style=\"font-size:8px;\"><span><span class=\"photo\"><input id=\"img_{$vars['message_id']}\" object_id=\"{$vars['message_id']}\" object_name=\"message\"  name=\"file_upload\" type=\"file\" multiple=\"true\"></span></span></div>";
		echo "</td><td>";			
		echo "<div style=\"width:160px;\"><span><span class=\"file\"><input id=\"file_{$vars['message_id']}\" object_id=\"{$vars['message_id']}\" object_name=\"message\"  name=\"file_upload2\" type=\"file\" multiple=\"true\"></span></span></div>";
		?>
		
		</td><td>&nbsp;</td><td width="50%">
		<div style="text-align:right;">
				<button type="submit" class="btn" id="comment_send" ><?php echo $this->t('common','send'); ?></button>
		</div>
		</td></tr></table>
 	</div>

 	  <!-- div class="icons">
<?php 
/*
			echo "<span><a href=\"#\" id=\"{$vars['comment_id']}\" object_id=\"{$vars['object_id']}\" object_name=\"{$vars['object_name']}\" class=\"photo attachphoto\">".
			$this->t('common','add photo')
			."</a></span>";
*/
	echo "<div><span><span class=\"photo\"><input id=\"img_{$vars['message_id']}\" object_id=\"{$vars['message_id']}\" object_name=\"message\"  name=\"file_upload\" type=\"file\" multiple=\"true\"></span></span></div>";			
	echo "<div><span><span class=\"file\"><input id=\"file_{$vars['message_id']}\" object_id=\"{$vars['message_id']}\" object_name=\"message\"  name=\"file_upload2\" type=\"file\" multiple=\"true\"></span></span></div>";
	
?>			
		
	</div-->		

	
	</form>
 	
 	
 	</td></tr></table>


</td></tr></table>

</div>
</div>

<?php 
/*
 * TODO:
список фотографий
+ссылка показать все
*/
?>
	<script>

/*		//tinymce
			tinymce.init({
			    selector: "#form<?php echo $vars['message_id']?> textarea",
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
			//fileupload 
			var imgdata=[];
			$('input#img_<?php echo $vars['message_id']; ?>').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				'buttonText' : "<?php  echo $this->t('common','add photo'); ?>",
				'buttonClass'  : 'btn',//attachphoto 
				'height':20,
				//'checkScript'      : 'check-exists.php',
				'formData'         : {
											'folder'    : '/images/messages',
				                     },
			                     
				'queueID'          : 'queue<?php echo $vars['message_id']; ?>',
				'uploadScript'    : '/profile/message_photo_upload/<?php if(isset($vars['message_id'])){ echo $vars['message_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : 'image',
				'onAddQueueItem' : function(file){
					$("#queue<?php echo $vars['message_id']; ?>").show();
				},
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					imgdata.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
					//TODO показать картинки
					//location.reload();
				/*	comment_showphotos({"id":<?php echo $vars['message_id']; ?>,
							"object_id":<?php echo $vars['object_id']; ?>,
							"object_name":<?php echo $vars['object_name']; ?>});*/
					$("#photos_<?php echo $vars['message_id']; ?>").load("/profile/message_photos_inline/<?php echo $vars['message_id']; ?>?object_name=<?php echo $vars['object_name']; ?>&object_id=<?php echo $vars['object_id']; ?>",
							readyfunction);
					$("#queue<?php echo $vars['message_id']; ?>").html("");
					$("#queue<?php echo $vars['message_id']; ?>").hide();
				},
				'onError': function (a, b, c, d) {
					//this.iserror=true;
					$('input#img_<?php echo $vars['message_id']; ?>').attr("iserror",1);
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
			//$('input#<?php echo $vars['message_id']; ?>').uploadifive('debug');
			
			
			var filedata=[];
			$('input#file_<?php echo $vars['message_id']; ?>').uploadifive({
				'auto'      : true,
				'multi'     : true,
				//'cancelImg' : '/images/cancel.png',
				'buttonText' : "<?php  echo $this->t('common','add file'); ?>",
				'buttonClass'  : 'btn',//attachphoto 
				'height':20,
				//'checkScript'      : 'check-exists.php',
				'formData'         : {
											'folder'    : '/files/messages',
				                     },
			                     
				'queueID'          : 'queue<?php echo $vars['message_id']; ?>',
				'uploadScript'    : '/profile/message_file_upload/<?php if(isset($vars['message_id'])){ echo $vars['message_id']; } ?>',
				'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
				'queueSizeLimit' : 10,
				'fileType'     : false, //'image',
				'onAddQueueItem' : function(file){
					$("#queue<?php echo $vars['message_id']; ?>").show();
				},
				'onUploadComplete' : function(file, data) { 
					file.name=data;//!COMIRON: файл переименован на сервере
					filedata.push(file);
					//uploaddifyOnComplete(event,queueId,fileObj,response,data);
				},
				'onQueueComplete' : function(uploads) {
				}
			});


            //подвинуть input file, чтобы курсок показывался ссылкой
/*            $(".icons .uploadifive-button").mousemove(function(e) {
                    var offL, offR, inpStart
                    offL = $(this).offset().left;
                    offT = $(this).offset().top;
                    aaa= $(this).find("input").width();
                    $(this).find("input").css({
                        left:e.pageX-aaa-30,
                        top:e.pageY-offT-10
                    })
            }); 
            $("div.uploadifive-button").click(function (e) {
                //alert($(this).find("input:eq(1)").length);
               	e.preventDefault();
               	e.stopPropagation();
                $(this).find("input:last-child ").trigger('click');
                return false;
            });*/

	</script>