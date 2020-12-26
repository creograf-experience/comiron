  		<input type="hidden" name="type" value="<?php echo $vars['type'];?>">
  		
  		
  		<div class="form_entry">
    	<div class="form_label"><label for="city"><?php echo $this->t('profile','city'); ?></label></div>
    	<input type="text" name="city" id="city" value="<?php if(isset($vars['person']['city'])){ echo $vars['person']['city']; } ?>" />
	    </div>
 		
  		<div class="form_entry">
    	<div class="form_label"><label for="name"><?php if($vars['type']=="1school"){ echo $this->t('profile','number'); }else{ echo $this->t('profile','title'); } ?></label></div>
    	<input type="text" name="name" class="name" value="<?php if(isset($vars['person']['name'])){ echo $vars['person']['name']; } ?>">
	    </div>
	    
	     		
  		<div class="form_entry">
    	<div class="form_label"><label for="from"><?php echo $this->t('profile','from'); ?></label></div>
    	<input type="number" name="from" class="from" min="1920" max="2013" placeholder="<?php echo $this->t('profile','YYYY'); ?>" />
	    </div>
	     		
  		<div class="form_entry">
    	<div class="form_label"><label for="to"><?php echo $this->t('profile','to'); ?></label></div>
    	<input type="number" name="to" class="to" min="1920" max="2023" placeholder="<?php echo $this->t('profile','YYYY'); ?>" />
	    </div>
	    
	    <button type="submit" class="btn submit"><?php echo $this->t('profile','add education'); ?></button>
	    