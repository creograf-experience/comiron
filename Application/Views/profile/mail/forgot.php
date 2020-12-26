<?php echo $this->t('common','Password restore')?>:

<?php
echo $this->t('common','password_restore_instruction');
echo "https://comiron.com/profile/changepassword?code=".$vars['person']['password_code'];
?> 

