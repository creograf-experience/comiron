<!--  option value="0"><?php echo $this->t('common', 'none') ?></option-->
<?php 
	if(isset($vars['groups'])){
		foreach ($vars['groups'] as $group) {
			echo "<option value=\"{$group['id']}\">{$group['name']}</option>";
			
			if(isset($group['subs'])){
				foreach($group['subs'] as $subgroup){
					echo "<option value=\"{$subgroup['id']}\">&nbsp;&nbsp;&nbsp;{$subgroup['name']}</option>";
				}
			}			
		}
	}      		
?>	 