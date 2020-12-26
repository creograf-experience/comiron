(function(){

	$(document).ready(function(){
		$('#model_id').append("<option value=\"\"><?php echo $this->t('profile','nothing selected'); ?></option>");

	<?php
	if(isset($vars['car_models'])){
		foreach ($vars['car_models'] as $models) {
//echo $models['id'];
			echo "$('#model_id').append(\"<option value='{$models['id']}'>{$models['name']}</option>\");";
		}
	} 
	?>
	});

})(jQuery);
