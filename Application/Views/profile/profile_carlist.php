<?php

if ( count($vars['cars'])) {
	
  if(isset($vars['cars'])){
?>
	<div class="header"><?php echo $this->t('profile','cars'); ?></div>
	<div class="body"><table class="markup" style="width:100%">
<?php   	
	  foreach ($vars['cars'] as $car) {
	  	echo "<tr><td>";
/*	  	if ($car['person_id'] == $_SESSION['id']) {
	  		echo "<div class=\"x\"><a href=\"#\" class=\"editcar\" title=\"{$this->t('profile','edit car')}\"  owner_id=\"{$car['person_id']}\" id=\"{$car['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a><a href=\"#\" class=\"removecar\"  title=\"{$this->t('profile','remove car')}\" owner_id=\"{$car['person_id']}\" id=\"{$car['id']}\"><img src=\"/images/i_close.png\"></a></div>";
	  	}
*/	  	
		echo "<table class=\"result\">";
	  	if(isset($car['marka_id'])){
		    echo "<tr><td>". $this->t('profile','marka').":</td><td width=\"100%\"><span id=\"marka_name{$car['id']}\">{$car['marka_name']}</span><span style=\"display:none;\" id=\"marka_id{$car['id']}\">{$car['marka_id']}</span></td></tr>";
	  	}
	  	if(isset($car['model_id'])){
		    echo "<tr><td>". $this->t('profile','model').":</td><td><span id=\"model_name{$car['id']}\">{$car['model_name']}</span><span style=\"display:none;\" id=\"model_id{$car['id']}\">{$car['model_id']}</span></td></tr>";
	  	}
	  	if(isset($car['year'])){
		 	echo "<tr><td>". $this->t('profile','Year').":</td><td><span id=\"year{$car['id']}\">{$car['year']}</span></td></tr>";
		}
	  	if(isset($car['complect'])){
		 	echo "<tr><td>". $this->t('profile','complect').":</td><td><span id=\"complect{$car['id']}\">{$car['complect']}</span></td></tr>";
		}
	  	if(isset($car['descr'])){
		 	echo "<tr><td>". $this->t('profile','descr').":</td><td><span id=\"descr{$car['id']}\">{$car['descr']}</span></td></tr>";
		}
		if(isset($car['medias']) and $car['medias']['found_rows']>0){
			echo "<tr><td>". $this->t('profile','photo').":</td><td>";
			$this->template('profile/profile_car_photos.php', $car);
			echo "</td></tr>";
		}
		if ($car['person_id'] == $_SESSION['id']) {
			echo "<tr><td colspan=\"3\"><a href=\"#\" class=\"btn editcar\" title=\"{$this->t('profile','edit car')}\"  owner_id=\"{$car['person_id']}\" id=\"{$car['id']}\"><img src=\"/images/i_edit.png\">&nbsp;&nbsp;{$this->t('common','edit')}</a>";
			echo "&nbsp;&nbsp;<a href=\"#\" class=\"btn removecar\"  title=\"{$this->t('profile','remove car')}\" owner_id=\"{$car['person_id']}\" id=\"{$car['id']}\"><img src=\"/images/i_close.png\">&nbsp;&nbsp;{$this->t('common','delete')}</a>";
			echo "</td></tr>";
		}
		
		echo "<tr><td>&nbsp;</td></tr></table></td></tr>";
	  }
	  echo "<tr><td>&nbsp;</td></tr></table></td></tr>";
  }
?>  
  </table></div>
<?php   
}
?>
<div id="dialog_car_remove" title="<?php $this->t('profile','confirm_remove_car_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>
