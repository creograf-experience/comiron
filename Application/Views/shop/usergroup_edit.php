<form method="post" id="group_edit_form" enctype="multipart/form-data" action="/shop/usergroup_edit/<?php echo $vars['group']['id']; ?>">
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Name')?></label></div>
      <input type="text" name="name" id="name" value="<?php echo $vars['group']['name'] ?>" style="width:364px;">
  </div>
  
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn submit" id="save"><?php echo $this->t('common','save')?></button></td><td><!-- button id="compose_cancel">cancel</button--></td></tr></table>
  </div>
</div>
</form>

<script>
//$(document).ready(function(){
	var dialog=$("#dialog_edit_usergroup");
	
 	$("#group_edit_form").ajaxForm({
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
 
//});
</script>
