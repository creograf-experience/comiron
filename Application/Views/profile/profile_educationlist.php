<?php
if ( count($vars['education'])) {

  if(isset($vars['education']['school'])){
?>
	<div class="header"><?php echo $this->t('profile','school'); ?></div>
	<div class="body">
<?php   	
	  foreach ($vars['education']['school'] as $edu) {
		echo "<table class=\"result\">";

	  	if(isset($edu['name'])){
		 echo "<tr><td>". $this->t('profile','number').":</td><td width=\"100%\"><span id=\"name{$edu['id']}\">{$edu['name']}</span>";
	  	 if ($vars['is_owner']) {
		 	echo "<div class=\"x\"><a href=\"#\" class=\"editeducation\" type=\"{$edu['type']}\" title=\"{$this->t('profile','edit education')}\"  owner_id=\"{$edu['person_id']}\" id=\"{$edu['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a><a href=\"#\" class=\"removeeducation\"  title=\"{$this->t('profile','remove education')}\" owner_id=\"{$edu['person_id']}\" id=\"{$edu['id']}\"><img src=\"/images/i_close.png\"></a></div>";
		 }
		 if(isset($edu['from']) and isset($edu['to'])){
		 	echo "<br>". $this->t('profile','from')." <span id=\"from{$edu['id']}\">".$edu['from']."</span> ".$this->t('profile','to')." <span id=\"to{$edu['id']}\">{$edu['to']}</span>";
		 	if(isset($edu['class']) and $edu['class']){
		 	echo "<br>". $this->t('profile','class')." <span id=\"class{$edu['id']}\">{$edu['class']}</span>";
		 	}
		 	
		 }
		 echo "</td></tr>";
		 if(isset($edu['country']) and $edu['country']){
		 	echo "<tr><td>". $this->t('central','Country').":</td><td><span id=\"country{$edu['id']}\">{$edu['country']}</span></td></tr>";
		 }
		 if(isset($edu['city']) and $edu['city']){
		 	echo "<tr><td>". $this->t('profile','city').":</td><td><span id=\"city{$edu['id']}\">{$edu['city']}</span></td></tr>";
		 }
		 	
	  	}
		echo "<tr><td>&nbsp;</td></tr></table>";
  	  }
  	  echo "</div>";
  }
  ?>  
  
<?php   
if(isset($vars['education']['college'])){
	?>
	<div class="header"><?php echo $this->t('profile','college'); ?></div>
	<div class="body">
<?php   	
	  foreach ($vars['education']['college'] as $edu) {
		echo "<table class=\"result\">";

	  	if(isset($edu['name'])){
		 echo "<tr class=\"item\"><td>".$this->t('profile','title').":</td><td width=\"100%\"><span id=\"name{$edu['id']}\">{$edu['name']}</span>";
		 if ($vars['is_owner']) {
		 	echo "<div class=\"x\"><a href=\"#\" class=\"editeducation\" type=\"{$edu['type']}\" title=\"{$this->t('profile','edit education')}\"  owner_id=\"{$edu['person_id']}\" id=\"{$edu['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a><a href=\"#\" class=\"removeeducation\" owner_id=\"{$edu['person_id']}\" id=\"{$edu['id']}\"><img src=\"/images/i_close.png\"></a></div>";
		 }
		 		
		 if(isset($edu['from']) and isset($edu['to'])){
		 	echo "<br>". $this->t('profile','from')." <span id=\"from{$edu['id']}\">{$edu['from']}</span> ".$this->t('profile','to')." <span id=\"to{$edu['id']}\">{$edu['to']}</span>";
		 	if(isset($edu['group']) and $edu['group']){
		 	echo "<br>". $this->t('profile','group')." <span id=\"class{$edu['id']}\">{$edu['class']}</span>";
		 	}
		 	
		 }
		 echo "</td></tr>";
		}
		if(isset($edu['country']) and $edu['country']){
			echo "<tr><td>". $this->t('central','Country').":</td><td><span id=\"country{$edu['id']}\">{$edu['country']}</span></td></tr>";
		}
		if(isset($edu['city']) and $edu['city']){
			echo "<tr><td>". $this->t('profile','city').":</td><td><span id=\"city{$edu['id']}\">{$edu['city']}</span></td></tr>";
		}
		
		echo "<tr><td>&nbsp;</td></tr></table>";
  	  }
  	  ?>
  	    </div>
  	  <?php   
  }

if(isset($vars['education']['univer'])){
	?>
	<div class="header"><?php echo $this->t('profile','univer'); ?></div>
	<div class="body">
<?php   	
	  foreach ($vars['education']['univer'] as $edu) {
		echo "<table class=\"result\">";

	  	if(isset($edu['name'])){
		  echo "<tr class=\"item\"><td>".$this->t('profile','title').":</td><td width=\"100%\"><span id=\"name{$edu['id']}\">{$edu['name']}</span>";
		  if ($vars['is_owner']) {
				echo "<div class=\"x\"><a href=\"#\" class=\"editeducation\" type=\"{$edu['type']}\" title=\"{$this->t('profile','edit education')}\"  owner_id=\"{$edu['person_id']}\" id=\"{$edu['id']}\"><span class=\"ui-icon ui-icon-pencil\"></span></a><a href=\"#\" class=\"removeeducation\" owner_id=\"{$edu['person_id']}\" id=\"{$edu['id']}\"><img src=\"/images/i_close.png\"></a></div>";
		  }
		  if(isset($edu['from']) and isset($edu['to'])){
		 	echo "<br>". $this->t('profile','from')." <span id=\"from{$edu['id']}\">{$edu['from']}</span> ".$this->t('profile','to')." <span id=\"to{$edu['id']}\">{$edu['to']}</span>";
		 	if(isset($edu['group']) and $edu['group']){
		 	echo "<br>". $this->t('profile','group')." <span id=\"name{$edu['class']}\">{$edu['class']}</span>";
		 	}
		 }
		 echo "</td></tr>";
		}
		if(isset($edu['country']) and $edu['country']){
			echo "<tr><td>". $this->t('central','Country').":</td><td><span id=\"country{$edu['id']}\">{$edu['country']}</span></td></tr>";
		}
	  	if(isset($edu['city']) and $edu['city']){
		 echo "<tr><td>". $this->t('profile','city').":</td><td><span id=\"city{$edu['id']}\">{$edu['city']}</span></td></tr>";
		}
		echo "<tr><td>&nbsp;</td></tr></table>";
  	  }
  	  echo "</div>";
  }
  ?>  
   <div id="dialog_edu_remove" title="<?php $this->t('profile','confirm_remove_edu_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>
<?php   
}
?>

