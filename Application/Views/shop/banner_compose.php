<form method="post" id="banner_add_form" enctype="multipart/form-data" action="/shop/banner_edit/<?php echo $vars['id']; ?>">
<input type="hidden" name="shop_id" value="<?php echo $vars['shop_id'];?>">

<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="link"><?php echo $this->t('shop','Link')?></label></div>
      <input type="text" name="link" id="link" value="<?php echo isset($vars['banner']['link'])?  $vars['banner']['link']:""; ?>" style="width:364px;">
  </div>
  
    <div class="form_entry  line">
      <div class="form_label"><label for="image"><?php echo $this->t('shop', 'Visible for users') ?></label></div>
      <select name="isvisible">
        <option nocheck="nocheck" <?php echo (!isset($vars['banner']['isvisible']) or !$vars['banner']['isvisible']) ? ' selected' : ''?>  value="0"><?php echo $this->t('common','no')?></option>
    	<option nocheck="nocheck" <?php echo (isset($vars['banner']['isvisible']) and $vars['banner']['isvisible']) ? ' selected' : ''?>  value="1"><?php echo $this->t('common','yes')?></option>
   	  </select>
    </div>
    
  <div class="form_entry">
      <div class="form_label"><label for="image"><?php echo $this->t('common','Image')?></label></div>
     
      	<table><tr><td>
      	<?php
  	    if(isset($vars['banner']['img'])){
  	    	echo "<img id=\"PhotoPrev2\" src=\"{$vars['banner']['img']}\">";
  	    } else {
  	    ?>
       		<img id="PhotoPrev2" src="/images/group/nophoto.gif" />
       	<?php
		}
		?>
       	</td><td>&nbsp;</td><td>
    	<!--  input type="file" name="UploadPhoto" id="UploadPhoto2" /-->	
    	 <input type="file" name="thumbnail">
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
	/*
	$('#UploadPhoto2').uploadifive({
        'auto'      : true,
        'multi'     : false,
        //'cancelImg' : '/images/cancel.png',
        'buttonText': "<?php  echo $this->t('common','upload'); ?>",
        'buttonClass'  : 'uploadButton',
        //'checkScript'      : 'check-exists.php',
        'formData'  : {
                            'folder'    : '/images/banners',
                            'id':<?php echo $vars['id']?>,
                      },

        'queueID'          : 'queue',
        'uploadScript'    : '/shop/uploadbannerimg',
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
                        data = '/images/shop/'+data;
                        $('#UploadPrev2').attr("src", data);
                        console.log(data);
       					
                        //uploaddifyOnComplete(event,queueId,fileObj,response,data);
                },
        'onQueueComplete' : function(uploads) {
                //location.reload();
               
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

	*/
});
</script>