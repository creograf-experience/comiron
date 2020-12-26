<?php 
	if(isset($vars['level']) and !empty($vars['level'])){ 
?>
      	<option value="0"><?php echo $this->t('common','none')?></option>
<?php		foreach ($vars['level'] as $l) {
			echo "<option postalcode=\"{$l['postalcode']}\" aolevel=\"{$l['aolevel']}\" value=\"{$l['aoguid']}\">{$l['formalname']} {$l['shortname']}</option>";
		}
	}      		
?>		

<?php 
	if(isset($vars['house']) and !empty($vars['house'])){ 
?>
    		<option value="0"><?php echo $this->t('common','none')?></option>
<?php		foreach ($vars['house'] as $l) {
			echo "<option postalcode=\"{$l['postalcode']}\" value=\"{$l['houseguid']}\">{$l['housenum']} {$l['buildnum']} </option>"; //{$l['strucnum']}
		}
	}      		
?>		
