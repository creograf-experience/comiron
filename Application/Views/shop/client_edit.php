<form method="post" id="group_edit_form" enctype="multipart/form-data" action="/shop/client_edit/<?php echo $vars['shop_id']."/".$vars['person']['id']; ?>">
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Client')?></label></div>
      <input type="text" name="name" readonly id="name" value="<?php echo $vars['person']['last_name']." ".$vars['person']['first_name'] ?>" style="width:364px;">
  </div>

  <!--div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Discount visible')?></label></div>
      <input type="text" name="discount" id="discount" value="<?php echo $vars['client']['discount'] ?>" style="width:364px;">%
  </div-->
  
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Discount')?></label></div>
      <input type="text" name="discounthidden" id="discounthidden" value="<?php echo $vars['client']['discounthidden'] ?>" style="width:364px;">%
  </div>

   <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','User Groups')?></label></div>
        <table>
      <?php 
      
      	if(isset($vars['groups'])){
			foreach ($vars['groups'] as $group) {
				echo "<tr><td><input type=\"checkbox\" name=\"group-{$group['id']}\" ".($group['ismy']?" checked ":"").">{$group['name']}</td></tr>";
			}
      	}
		?>
	</table>
        
   </div>
    <div class="clear"></div>
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','hidden client')?></label></div>
      <input type="checkbox" name="hiddenclient" id="hiddenclient" <?php if($vars['client']['hiddenclient']): ?>value="<?php echo $vars['client']['hiddenclient']?>"<?php endif ?> <?php if($vars['client']['hiddenclient'] == 1): ?> checked='checked'<?php endif ?> />
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
