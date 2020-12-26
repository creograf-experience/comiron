<form method="post" id="group_add_form" enctype="multipart/form-data" action="/shop/usergroup_add/<?php echo $vars['shop']['id']; ?>">
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="name_en"><?php echo $this->t('shop','Name')?></label></div>
      <input type="text" name="name" id="name" value="" style="width:364px;">
  </div>
  <div class="form_entry">
    <table class="markup"><tr><td><button type="submit" class="btn submit" id="group_add"><?php echo $this->t('common','add')?></button></td><td><button class="btn btncancel" id="compose_cancel"><?php echo $this->t('common','cancel')?></button></td></tr></table>
  </div>
</div>
</form>