<form method="post" id="address_add_form" enctype="multipart/form-data" action="/address/send">
	<input type="hidden" name="country_code" value="RU">
	<input type="hidden" name="city" id="city" value="">
	<input type="hidden" name="object" value="<?php echo $vars['object'];?>">
	<input type="hidden" name="object_id" value="<?php echo $vars['object_id'];?>">
			
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('common','Postalcode')?></label></div>
      <input type="text" name="postalcode" required id="postalcode" value="" style="width:364px;">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('common','Region')?></label></div>
      <select name="top_aoid" level="0" id="top_aoid" style="width:364px;">
      	<option value="0"><?php echo $this->t('common','none')?></option>
<?php 
	if(isset($vars['tops'])){ 
		foreach ($vars['tops'] as $tops) {
			echo "<option aolevel=\"{$tops['aolevel']}\" value=\"{$tops['aoguid']}\">{$tops['formalname']} {$tops['shortname']}</option>";
		}
	}      		
?>		
      </select>
  </div>

  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('common','address details')?></label></div>
	<input type="text" required class="more" name="more" value="">
  </div>
 
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn submit" id="address_add"><?php echo $this->t('common','add')?></button></td></tr></table>
  </div>
</div>
</form>

