<script type="text/javascript">
$(function()
{
    $('textarea').redactor({
        lang: 'ru',
        buttons: ['html', 'bold', 'italic', 'underline', 'deleted', 'formatting', 'image', 'link'],
        imageUpload: '/shop/uploadproductimg1/<?php echo $vars['product']['shop_id'];?>',
        minHeight: 250,
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
});
</script>
<form method="post" id="product_edit_form" enctype="multipart/form-data" action="/shop/product_edit/<?php echo $vars['product']['id']; ?>">
<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $vars['product']['shop_id'];?>">

<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name"><?php echo $this->t('shop', 'Name') ?></label></div>
      <input type="text" name="name" id="name" value="<?php echo $vars['product']['name']?>" style="width:364px;"> 
      <!--<span><a href="#"><img src="/images/what_is_this.png" /></a></span>
      <div>Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в домашних условиях.</div>-->
  </div>
  <div class="form_entry moreoptions_icon_ots">
      <div class="more_settings_left"><img src="/images/24x24settings.png" width="16" height="16" /></div>
      <div><a href="#" id="moreoptions_icon" class="icon" onclick="return false"><?php echo $this->t('shop','more options'); ?></a></div>
      <div class="clearboth"></div>
  </div> 
  <div class="moreoptions">
    <div class="form_entry">
        <div class="form_label"><label for="name" class="it"><?php echo $this->t('shop', 'Unit') ?></label></div>
        <input type="text" name="edizm" id="edizm" value="<?php echo $vars['product']['edizm']; ?>" style="width:364px;">
    </div>
    <div class="form_entry">
        <div class="item_left">
            <div class="form_label"><label for="name" class="it"><?php echo $this->t('shop', 'Package') ?></label></div>
            <input type="text" name="package" id="package" value="<?php echo $vars['product']['package']; ?>" style="width:64px;">
        </div>
        <div class="item_left">
            <div class="item_left" style="padding:0px; margin:0px;"><input type="checkbox" name="box" id="box" value="<?php echo $vars['product']['box']; ?>" <?php if($vars['product']['box'] == 1) echo "checked='checked'" ?> /></div>
            <div class="item_left"><label for="name" class="it"><?php echo $this->t('shop', 'Box') ?></label></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <?php if($vars['shop_lang']['lang'] != 'ru'): ?>
    <div class="form_entry">
      <div class="form_label"><label for="name" class="ru"><?php echo $this->t('shop', 'Name ru') ?></label></div>
      <input type="text" name="name_ru" id="name_ru" value="<?php echo $vars['product']['name_ru']; ?>" style="width:364px;">
 	 </div>
    <?php endif ?>
    <?php if($vars['shop_lang']['lang'] != 'en'): ?>
     <div class="form_entry">
      <div class="form_label"><label for="name" class="en"><?php echo $this->t('shop', 'Name en') ?></label></div>
      <input type="text" name="name_en" id="name_en" value="<?php echo $vars['product']['name_en']; ?>" style="width:364px;">
 	 </div>
    <?php endif ?>
    <?php if($vars['shop_lang']['lang'] != 'ch'): ?>
     <div class="form_entry">
      <div class="form_label"><label for="name" class="ch"><?php echo $this->t('shop', 'Name ch') ?></label></div>
      <input type="text" name="name_ch" id="name_ch" value="<?php echo $vars['product']['name_ch']; ?>" style="width:364px;">
 	 </div>
    <?php endif ?>
    <?php if($vars['shop_lang']['lang'] != 'it'): ?>
     <div class="form_entry">
      <div class="form_label"><label for="name" class="it"><?php echo $this->t('shop', 'Name it') ?></label></div>
      <input type="text" name="name_it" id="name_it" value="<?php echo $vars['product']['name_it']; ?>" style="width:364px;">
 	 </div>
    <?php endif ?>
  <div class="form_entry  line">
      <div class="form_label"><label for="image"><?php echo $this->t('shop', 'Visible for users') ?></label></div>
      <select name="visible[]" id="options_product2" multiple="multiple">
       	<?php
    		$access=PartuzaConfig::get('shop_access_types');
    	?>
    	<!-- option value=""><?php echo $this->t('profile','Select one...'); ?></option-->
    	<option nocheck="nocheck" <?php echo $vars['product']['visible'] == '5' ? ' selected' : ''?> value="5"><?php echo $this->t('shop',$access['5'])?></option>
    	<option nocheck="nocheck" <?php echo $vars['product']['visible'] == '0' ? ' selected' : ''?> value="0"><?php echo $this->t('shop',$access['0'])?></option>
    	<option nocheck="nocheck" <?php echo $vars['product']['visible'] == '1' ? ' selected' : ''?> value="1"><?php echo $this->t('shop',$access['1'])?></option>
    	<option nocheck="nocheck" <?php echo $vars['product']['visible'] == '2' ? ' selected' : ''?> value="2"><?php echo $this->t('shop',$access['2'])?></option>
    	<option nocheck="nocheck" <?php echo $vars['product']['visible'] == '3' ? ' selected' : ''?> value="3"><?php echo $this->t('shop',$access['3'])?></option>
    	<option nocheck="nocheck" <?php echo $vars['product']['visible'] == '4' ? ' selected' : ''?> value="4"><?php echo $this->t('shop',$access['4'])?></option>
    			<?php
  		foreach ($vars['usergroups'] as $group) {
  			echo "      <option value=\"g{$group['id']}\" data-icon=\"/images/people/nophoto.205x205.gif\"";
   			echo $group['visible'] ? ' selected' : '';
  			echo ">{$group['name']}</option>\n";
  		}
  		?>
  	</select>
    </div>
  
    </div>
  <div class="form_entry">
      <div class="form_label"><label for="price"><?php echo $this->t('shop', 'Price') ?></label></div>
      <input type="text" name="price" id="price" value="<?php echo $vars['product']['price']?>" style="width:364px;">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="currency_id"><?php echo $this->t('shop', 'Currency') ?></label></div>
      <select name="currency_id" id="currency_id" style="width:364px;">
<?php 
	if(isset($vars['currencies'])){
		foreach ($vars['currencies'] as $currency) {
			echo "<option value=\"{$currency['id']}\" ". (($currency['id']==$vars['product']['currency_id'])?" selected ":"").">{$currency['name']}</option>";
		}
	}      		
?>		
      </select>
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop', 'Product group in shop') ?></label></div>
      <table class="markup"><tr><td>
      <select name="group_id" id="product_group_id" style="width:364px;">
      	<option value="0"><?php echo $this->t('common', 'none') ?></option>
<?php 

	if(isset($vars['groups'])){
		foreach ($vars['groups'] as $group) {
			echo "<option value=\"{$group['id']}\" ";
			 
			 foreach($vars['product']['groups'] as $product_group){
			 	if($product_group['id']==$group['id']){
			 		echo " selected ";
			 	}
			 }
			 
			 echo ">{$group['name']}</option>";
			
			if(isset($group['subs'])){
			/*	foreach($group['subs'] as $subgroup){
					echo "<option value=\"{$subgroup['id']}\" ";
					
					foreach($vars['product']['groups'] as $product_group){
			 			if($product_group['id']==$subgroup['id']){
			 				echo " selected ";
			 			}
			 		}
					echo ">&nbsp;&nbsp;&nbsp;{$subgroup['name']}</option>";
				}*/
                            $this->get_subgroup_product_compose($group['subs'], $product_group['id']);
			}
                         
		}
	}      		
?>		
      </select>
      </td><td>
      	<a href="#"  class="groupCompose" id="<?php echo $vars['product']['shop_id'];?>" title="<?php echo $this->t('shop', 'Add group') ?>"><img src="/images/b_add.png" alt="<?php echo $this->t('shop', 'Add group') ?>"></a>
      </td><td class="groupedit">
      	<?php
      /*		if($vars['product']['group_id']){
	      		echo '<a href="#"  class="groupEdit editgroup" id="'+$vars['product']['group_id']+'" title="'+t('common', 'Edit group')+'"><img src="/images/b_edit.png" alt="'+t('common', 'Edit group')+'"></a>';
      		}*/
      	?>
      </td><td class="groupdelete">
      	<?php /*
      		if($vars['product']['group_id']){
				echo '<a href="#" name="'+name+'" shop_id="'+$vars['product']['shop_id']+'" class="groupDelete deletegroup" id="'+$vars['product']['group_id']+'" title="'+t('common', 'Delete group')+'"><img src="/images/b_delete.png" alt="'+t('common', 'Delete group')+'"></a>';
      		}*/
      	?>      
      </td></tr></table>
  </div>
  <div class="form_entry line">
   	  <div class="form_label"><label for="name_en"><?php echo $this->t('shop', 'Product category') ?>
      <div class="comment"><?php echo $this->t('common', 'max 3') ?></div>
      </label></div>
<?php 

			
				if(isset($vars['category'])){
?>
      <select name="category_id[]" multiple="multiple" id="category_ids_edit"  style="width:364px;">
      	<option value="0"><?php echo $this->t('common', 'none') ?></option>
<?php 					
					foreach ($vars['category'] as $category) {
						echo "<option value=\"{$category['id']}\"";
							//
							foreach($vars['product']['categories'] as $product_category){
								if($product_category['id']==$category['id']){
									echo " selected ";
								}
							}
						echo ">{$category['name']}</option>";
			
						if(isset($category['subs'])){
							foreach($category['subs'] as $subcategory){
								echo "<option value=\"{$subcategory['id']}\"";
								foreach($vars['product']['categories'] as $product_category){
									if($product_category['id']==$subcategory['id']){
										echo " selected ";
									}
								}
								echo ">&nbsp;&nbsp;&nbsp;{$subcategory['name']}</option>";
							}
						}
					}
?>
    	  </select>
	  </div>

<?php 								
				}	
?>		
  
  <div class="form_entry">
      <div class="form_label"><label for="image"><?php echo $this->t('shop', 'Is special offer?') ?></label></div>
      <select name="isspecial" style="width:364px;">
<option value="<?php echo $vars['product']['isspecial'] ?>"><?php if($vars['product']['isspecial']){ echo $this->t('common', 'yes'); } else { echo $this->t('common', 'no'); } ?>
<?php 
if($vars['product']['isspecial']){ 
	echo "<option value=\"0\">".$this->t('common', 'no');
}else{
	echo "<option value=\"1\">".$this->t('common', 'yes');
}
?>
</select>
  </div>
  
  
  
  
  <div class="form_entry moreoptions_icon_ots">
      <div class="form_label"><label for="image"><?php echo $this->t('common', 'Image') ?></label></div>
      <!-- input type="file" name="thumbnail"-->
      	<table><tr><td>
       	<img id="PhotoPrev_edit"  src="<?php echo isset($vars['product']['thumbnail_url']) ? $vars['product']['thumbnail_url'] : '/images/product/nophoto.gif'?>" />
       	</td><td>&nbsp;</td><td>
    	<input type="file" name="UploadPhoto" id="UploadPhoto_edit" />	
		</td></tr></table>
    	<div id="queue_edit"></div>
  </div>
    <div class="form_entry moreoptions_icon_ots">
      <div class="more_settings_left"><img src="/images/Image.png" width="16" height="16" /></div>
      <div><a href="#" id="moreimages_icon" class="icon" onclick="return false"><?php echo $this->t('shop','more images'); ?></a></div>
      <div class="clearboth"></div>
    </div>
    <div class="moreimages">
        <?php
        /*echo '<pre>';
        print_r($vars['product_images']);
        echo '</pre>';*/
        ?>
        <?php $j = 0; ?>
        <?php for($i = 1; $i<=10; $i++): ?>
        <div class="form_entry moreoptions_icon_ots">
            <div class="form_label"><label for="image"><?php echo $this->t('common', 'Image') ?> <?=$i?></label></div>
            <table>
                <tr><td>
                    <?php 
                        if(!empty($vars['product_images'])) {
                            if(array_key_exists($j, $vars['product_images'])) {
                                echo "<img id=\"PhotoPrev_edit".$i."\" class=\"PhotoPrevDop\" src=\"".$vars['product_images'][$j]['thumbnail_url']."\" />";
                            } else {
                                echo "<img id=\"PhotoPrev_edit".$i."\" class=\"PhotoPrevDop\" src=\"/images/product/nophoto.gif\" />";
                            }
                            
                        } else {
                            echo "<img id=\"PhotoPrev_edit".$i."\" class=\"PhotoPrevDop\" src=\"/images/product/nophoto.gif\" />";
                        } 
                    ?>
                </td>
                <td>&nbsp;</td>
                <td>
                    <input type="file" name="UploadPhoto<?=$i?>" id="UploadPhoto_edit<?=$i?>" />	
                </td></tr>
            </table>
            <div id="queue_edit<?=$i?>"></div>
        </div>
        <?php $j++ ?>
        <?php endfor; ?>
    </div>
 <div class="form_entry">
      <!--div class="form_label"><label for="name"><?php echo $this->t('shop','Text')?></label></div-->
      <textarea name="descr" id="descr_<?php echo $vars['product']['id'] ?>" style="width:100%; height:200px;"><?php echo $vars['product']['descr']; ?></textarea>
      
  </div>
  
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn" id="product_save"><?php echo $this->t('common', 'save') ?></button></td><td><!-- button id="compose_cancel">cancel</button--></td></tr></table>
  </div>
</div>
</form>

<script>
    
    $(document).ready(function(){
        $("input#box").change(function(){
            if($(this).val() == 0){
                $(this).attr('value',1);
                $(this).attr('checked','checked');
            } else {
                $(this).attr('value',0);
                $(this).removeAttr('checked');
            }
        });
    })
    
    
//$(document).ready(function(){
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        
	var dialog=$("#product_edit_form");
	
 	dialog.ajaxForm({
 	       		"success":function(){
 	        		dialog.dialog("close");
 	        	 	location.reload();
 	       		}});
/* 		 	function(){
 		dialog.dialog("close");
 	 	location.reload();
 	}*/
  	
 	dialog.find('#save').bind('click', function() {
 		//dialog.dialog("close");
		//setTimeout(location.reload(),1000);
	});
	
	dialog.find('#compose_cancel').bind('click', function() {
		dialog.dialog("close");
	});
        
	//tinymce
	/*tinymce.init({
            selector: "form#product_edit_form textarea",
            language : '<?php echo $_SESSION['lang']?>',
            //menu : 'undo redo cut copy paste selectall bold italic underline strikethrough subscript superscript removeformat formats alignleft aligncenter alignright alignjustify bullist numlist outdent indent link image',
            menubar : true,
	    //inline : true,
	    plugins: ["link image searchreplace wordcount anchor table",
	             // "advlist autolink lists  charmap print preview hr  pagebreak",
	             // " visualblocks visualchars code fullscreen",
	             // "insertdatetime media nonbreaking save table contextmenu directionality",
	             // "emoticons template paste textcolor colorpicker textpattern"
	          ],
	    image_advtab: true,
	    //cut copy paste |  
		//toolbar: "bold italic underline strikethrough | subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                toolbar: "bold italic underline strikethrough | link image | styleselect",
		statusbar: false,
	    //skin : "cirkuit",
		paste_auto_cleanup_on_paste : true,
		force_br_newlines : true,
		valid_elements: "b,strong,i,em,u,s,strike,sub,sup,p,br,img a ",
	});
        */
	$('#UploadPhoto_edit').uberuploadcropper({
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
										'folder'    : '/images/product',
										'id':<?php echo $vars['product']['id']?>,
			              },
			'queueID'         : 'queue_edit',
			'uploadScript'    : '/shop/uploadproductimg',
			'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
			'fileType'     : 'image',
//			'displayData': 'percentage',
			 onError: function (a, b, c, d) {
				//this.iserror=true;
				
				$('#UploadPhoto_edit').attr("iserror",1);
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
				$('#UploadPhoto_edit').attr("iserror",0);
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
		    },
			//---------------------------------------------------
			// cropper options..
			//---------------------------------------------------
			//'aspectRatio': 1,//пропорции 
			'allowSelect': true,			//can reselect 
			'allowResize' : true,			//can resize selection
			'setSelect': [ 0, 0, 200, 200 ],	//these are the dimensions of the crop box x1,y1,x2,y2
			'minSize': [ 100, 100 ],		//if you want to be able to resize, use these
			'cropsource': true,
			//'maxSize': [ 100, 100 ],

			//---------------------------------------------------
			//now the uber options..
			//---------------------------------------------------
			'zIndex': 111100,
			'iserror': false,
			'folder'    : '/images/product/',
			'id': <?php echo $vars['product']['id']?>,
			'cropScript': '/shop/cropproductimg',
			'onComplete': function(imgs,data){ 
				//$('#PhotoPrev').attr('src','/images/people/'+imgs[0].name +'?d='+ (new Date()).getTime()); 
				$('#PhotoPrev_edit').attr('src','/images/product/'+data +'?d='+ (new Date()).getTime());//COMIRON: data - то, что возвращает php
			}
			
	});
	
        <?php for($i = 1; $i <= 10; $i++): ?>
            $('#UploadPhoto_edit<?php echo $i ?>').uberuploadcropper({
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
                                                                            'folder'    : '/images/product',
                                                                            'id':<?php echo $vars['product']['id']?>,
                                                                            'dop':'<?php echo $i ?>dop',
                                  },
                    'queueID'         : 'queue_edit<?php echo $i ?>',
                    'uploadScript'    : '/shop/uploadproductimg',
                    'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
                    'fileType'     : 'image',
//			'displayData': 'percentage',
                     onError: function (a, b, c, d) {
                            //this.iserror=true;

                            $('#UploadPhoto_edit<?php echo $i ?>').attr("iserror",1);
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
                    },
                    //onSelect
                    'onAddQueueItem':function(){
                            $('#UploadPhoto_edit<?php echo $i ?>').attr("iserror",0);
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
                },
                //---------------------------------------------------
                // cropper options..
                //---------------------------------------------------
                //'aspectRatio': 1,//пропорции 
                'allowSelect': true,			//can reselect 
                'allowResize' : true,			//can resize selection
                'setSelect': [ 0, 0, 200, 200 ],	//these are the dimensions of the crop box x1,y1,x2,y2
                'minSize': [ 100, 100 ],		//if you want to be able to resize, use these
                'cropsource': true,
                //'maxSize': [ 100, 100 ],

                //---------------------------------------------------
                //now the uber options..
                //---------------------------------------------------
                'zIndex': 111100,
                'iserror': false,
                'folder'    : '/images/product/',
                'id': <?php echo $vars['product']['id']?>,
                'cropScript': '/shop/cropproductimg/<?php echo $i ?>dop',
                'onComplete': function(imgs,data){ 
                        //$('#PhotoPrev').attr('src','/images/people/'+imgs[0].name +'?d='+ (new Date()).getTime()); 
                        $('#PhotoPrev_edit<?php echo $i ?>').attr('src','/images/product/'+data +'?d='+ (new Date()).getTime());//COMIRON: data - то, что возвращает php
                }
			
            });
        <?php endfor ?>
            
	change_product_group();

	//свернуть/развернуть доп настройки
	$(".moreoptions").hide();
	//var $optionsvisible = false;
	var $optionsvisible = false;
	$("#moreoptions_icon").click(function(){
		if($optionsvisible){
			$(".moreoptions").slideUp();
			$optionsvisible = false;					
		}else{
			$(".moreoptions").slideDown();
			$optionsvisible = true;
		}
	});
	
        //свернуть/развернуть доп фотографии
	$(".moreimages").hide();
	//var $optionsvisible = false;
	var $imagesvisible = false;
	$("#moreimages_icon").click(function(){
		if($imagesvisible){
			$(".moreimages").slideUp();
			$imagesvisible = false;					
		}else{
			$(".moreimages").slideDown();
			$imagesvisible = true;
		}
	});
        
	readyfunction();
//});
</script>
