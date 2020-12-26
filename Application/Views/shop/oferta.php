<form>
<textarea class="oferta" style="width:100%">
  <?php echo $this->t('shop', $_REQUEST['ofertaname'].'_oferta'); ?>
</textarea>
<div style="text-align:center">
<button id="ok" class="btn"><?php echo $this->t('common', 'agree'); ?></button> <button id="cancel"  class="btn"><?php echo $this->t('common', 'no'); ?></button>
</div>
</form>