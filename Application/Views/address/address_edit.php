<form method="post" id="address_add_form" enctype="multipart/form-data" action="/address/send/<?php echo $vars['id']; ?>">
	<input type="hidden" name="country_code" value="RU">
	<input type="hidden" name="city" id="city" value="<?php echo $vars['city'];?>">
	<input type="hidden" name="object" value="<?php echo $vars['object'];?>">
	<input type="hidden" name="object_id" value="<?php echo $vars['object_id'];?>">
			
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('common','Postalcode')?></label></div>
      <input type="text" name="postalcode" required id="postalcode" value="<?php echo $vars['postalcode']; ?>" style="width:364px;">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('common','Region')?></label></div>
      <select name="top_aoid" level="0" id="top_aoid" style="width:364px;">
      	<option value="0"><?php echo $this->t('common','none')?></option>
<?php 
	if(isset($vars['tops'])){ 
		foreach ($vars['tops'] as $tops) {
			echo "<option ";
			if($tops['aoguid'] == $vars['aoidpaths'][0]){
			    echo "selected";
			}
			echo " aolevel=\"{$tops['aolevel']}\" value=\"{$tops['aoguid']}\">{$tops['formalname']} {$tops['shortname']}</option>";
		}
	}      		
	echo "</select>";
	$level_index = 1; 
	$level_str = "";
	foreach ($vars['levels'] as $level) {
		$level_str .= 1;
		if(isset($level['level']) and !empty($level['level'])){ 
		//echo $vars['aoidpaths'][$level_index];
        	echo "<select class=\"level\" name=\"address.0{$level_str}\" level=\"{$level_index}\" style=\"width:364px;\">";
			echo "<option value=\"0\">". $this->t('common','none')."</option>";
			echo $vars['aoidpaths'][$level_index] ."-index";
			foreach ($level['level'] as $l) {
			    echo "<option ";
			    
			    if($l['aoguid'] == $vars['aoidpaths'][$level_index]){
				echo "selected";
			    }
		    	    echo " aolevel=\"{$l['aolevel']}\" postalcode=\"{$l['postalcode']}\" value=\"{$l['aoguid']}\">{$l['formalname']} {$l['shortname']}</option>";
			}
		echo "</select>";		        			    
		}      	
		$level_index++;	
	}
		$level = $vars['houses'];
		$level_str .= 1;
		if(isset($level['level']) and !empty($level['level'])){ 
        	echo "<select class=\"level\" name=\"address.0{$level_str}\" level=\"{$level_index}\" style=\"width:364px;\">";
			echo "<option value=\"0\">". $this->t('common','none')."</option>";
			echo $vars['aoidpaths'][$level_index] ."-index";
			foreach ($level['level'] as $l) {
			    echo "<option ";
			    
			    if($l['houseguid'] == $vars['aoidpaths'][$level_index]){
				echo "selected";
			    }
			    echo "  postalcode=\"{$l['postalcode']}\" value=\"{$l['houseguid']}\">{$l['housenum']} {$l['buildnum']} {$l['strucnum']}</option>";
	    		    	    
		    	    //echo " value=\"{$l['aoguid']}\">{$l['formalname']} {$l['shortname']}</option>";
			}
		echo "</select>";		        			    
		}      		

?>		
  </div>

  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('common','address details')?></label></div>
	<input type="text" required class="more" name="more" value="<?php echo $vars['additional'] ?>">
  </div>
 
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn submit" id="address_add"><?php echo $this->t('common','save')?></button></td></tr></table>
  </div>
</div>
</form>

