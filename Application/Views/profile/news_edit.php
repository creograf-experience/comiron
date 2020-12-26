<form method="post" action="/profile/news/send">
<div class="news_compose">
  <div class="form_entry">
      <div class="form_label"><label for="anons"><?php echo $this->t('profile','Announcement'); ?></label></div>
      <textarea name="anons" id="anons" value="" style="width:364px; height:110px;" ></textarea>
    </div>
  <div class="form_entry">
      <div class="form_label"><label for="body"><?php echo $this->t('profile','Text'); ?></label></div>
      <textarea name="body" id="body" style="height:220px; width:364px"></textarea>
  </div>
  <!-- div class="form_entry">
      <div class="form_label"><label for="photo"><?php echo $this->t('profile','Photo'); ?></label></div>
      <input type="file" name="photo">
  </div-->
  <div class="form_entry" style="margin-top:12px">
    <div class="form_label"></div>
    <table class="markup"><tr><td><button type="submit" id="news_send"><?php echo $this->t('profile','send'); ?></button></td><td><button id="compose_cancel"><?php echo $this->t('common','cancel'); ?></button></td></tr></table>
  </div>
</div>
</form>