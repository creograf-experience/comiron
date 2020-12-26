<script type="text/javascript">
$(function()
{
	/*
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
        imageUpload: '/shop/uploadproductimg1/<?php echo $vars['shop_id'];?>',
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
    */
});
</script>

<form method="post" id="product_edit_form" enctype="multipart/form-data" action="/shop/product_multiedit/">
<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $vars['shop_id'];?>">
<?php
foreach ($vars['ids'] as $product_id) {
    echo "<input type=\"hidden\" name=\"product_id[]\" id=\"products_id\" value=\"{$product_id}\">";
}
?>

<div class="news_compose">
  <div class="moreoptions">
   	<div class="form_entry">
      <div class="form_label"><label for="name" class="it"><?php echo $this->t('shop', 'Discount') ?></label></div>
      <input type="text" name="discount" id="discount" value="" style="width:364px;">
 	 </div>
 	 
    <div class="form_entry">
        <div class="form_label"><label for="name" class="it"><?php echo $this->t('shop', 'Unit') ?></label></div>
        <input type="text" name="edizm" id="edizm" value="" style="width:364px;">
    </div>
      
<div class="form_entry">
      <div class="form_label"><label for="weight" class="it"><?php echo $this->t('shop', 'Weight') ?></label></div>
      <input type="text" name="weight" id="weight" value="" style="width:364px;">&nbsp;<?php echo $this->t('shop', 'kg') ?>
 	 </div>
  
<div class="form_entry">
      <div class="form_label"><label for="volume" class="it"><?php echo $this->t('shop', 'Volume') ?></label></div>
      <input type="text" name="volume" id="volume" value="" style="width:364px;">&nbsp;<?php echo $this->t('shop', 'm3') ?>
 	 </div>
  
<div class="form_entry">
      <div class="form_label"><label for="w" class="it"><?php echo $this->t('shop', 'W') ?> x <?php echo $this->t('shop', 'H') ?> x <?php echo $this->t('shop', 'D') ?></label></div>
      <input type="text" name="w" id="w" value="" style="width:110px;"> x
      <input type="text" name="h" id="h" value="" style="width:112px;"> x
       <input type="text" name="d" id="d" value="" style="width:112px;">&nbsp;<?php echo $this->t('shop', 'cm') ?>
 	 </div>
  
  
<div class="form_entry">
      <div class="form_label"><label for="sklad" class="it"><?php echo $this->t('shop', 'Sklad') ?></label></div>
      <input type="text" name="sklad" id="sklad" value="" style="width:364px;">
 	 </div>
  
    
    <div class="form_entry">
        <div class="item_left">
            <div class="form_label"><label for="name" class="it"><?php echo $this->t('shop', 'Package') ?></label></div>
            <input type="text" name="package" id="package" value="" style="width:64px;">
        
            <span><input type="checkbox" name="box" id="box" value="" />
            <?php echo $this->t('shop', 'Box') ?></span>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
  <div class="form_entry  line">
      <div class="form_label"><label for="image"><?php echo $this->t('shop', 'Visible for users') ?></label></div>
      <select name="visible[]" id="options_product2" multiple="multiple">
       	<?php
    		$access=PartuzaConfig::get('shop_access_types');
    	?>
    	<option nocheck="nocheck" selected  value="5"><?php echo $this->t('shop',$access['5'])?></option>
    	<option nocheck="nocheck"  value="0"><?php echo $this->t('shop',$access['0'])?></option>
    	<option nocheck="nocheck"  value="1"><?php echo $this->t('shop',$access['1'])?></option>
    	<option nocheck="nocheck"  value="2"><?php echo $this->t('shop',$access['2'])?></option>
    	<option nocheck="nocheck"  value="3"><?php echo $this->t('shop',$access['3'])?></option>
    	<option nocheck="nocheck"  value="4"><?php echo $this->t('shop',$access['4'])?></option>
        
		<?php
		if(is_array($vars['usergroups'])){
  			foreach ($vars['usergroups'] as $group) {
  				echo "      <option value=\"g{$group['id']}\" data-icon=\"/images/people/nophoto.205x205.gif\"";
  				echo ">{$group['name']}</option>\n";
  			}
		}
  		?>
  	</select>
    </div>
  
    </div>
    
  <div class="form_entry">
      <div class="form_label"><label for="price"><?php echo $this->t('shop', 'Price') ?></label></div>
      <input type="text" name="price" id="price" value="" style="width:364px;">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="currency_id"><?php echo $this->t('shop', 'Currency') ?></label></div>
      <select name="currency_id" id="currency_id" style="width:364px;">
      	<option value=""></option>
<?php 
	if(isset($vars['currencies'])){
		foreach ($vars['currencies'] as $currency) {
			echo "<option value=\"{$currency['id']}\" ";
		/*	if (
			(!isset($vars['product']['original']) and ($currency['id']==$vars['product']['currency_id']))
			 or (isset($vars['product']['original']) and ($currency['id']==$vars['product']['original']['currency_id']))){
			    echo " selected ";
			}*/
			echo ">{$currency['name']}</option>";
		}
	}      		
?>		
      </select>
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="image"><?php echo $this->t('shop', 'Is special offer?') ?></label></div>
      <select name="isspecial" style="width:364px;">
<?php
	echo "<option value=\"\">";
	echo "<option value=\"0\">".$this->t('common', 'no');
	echo "<option value=\"1\">".$this->t('common', 'yes');
?>
</select>
  </div>
  
  
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn submit" id="product_save"><?php echo $this->t('common', 'save') ?></button></td><td><!-- button id="compose_cancel">cancel</button--></td></tr></table>
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

            
	change_product_group();

	//свернуть/развернуть доп настройки
	//$(".moreoptions").hide();
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
