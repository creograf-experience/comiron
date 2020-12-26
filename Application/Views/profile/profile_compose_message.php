<div class="message_compose">
<?php if(isset($friends) and !isset($to)){ ?>
  	<div class="form_entry">
	<div class="form_label"><label for="to"><?php echo $this->t('profile','To'); ?></label></div>    
    <select name="to" id="to" style="width:364px">
    <option value=""><?php echo $this->t('profile','Select one...'); ?></option>	
<?php
  foreach ($friends as $friend) {
    echo "      <option value=\"{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</option>\n";
  }
?>
  	</select>
  	</div>
<?php }else if($to){ ?>
	<input type="hidden" name="to" value="<?php echo $to ?>">
<?php } ?>  	

  <div class="form_entry">
      <div class="form_label"><label for="subject"><?php echo $this->t('profile','Subject'); ?></label></div>
      <input type="text" name="subject" id="subject" value="" style="width:364px" />
    </div>
  <div class="form_entry">
      <div class="form_label"><label for="subject"><?php echo $this->t('profile','Message'); ?></label></div>
      <textarea name="message" id="message" style="height:220px; width:364px"></textarea>
  </div>
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" class="btn" id="compose_send"><?php echo $this->t('profile','send'); ?></button></td><td><button id="compose_cancel" class="btn"><?php echo $this->t('profile','cancel'); ?></button></td></tr></table>
  </div>
</div>
