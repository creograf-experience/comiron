
<?php echo $this->t('shop',"Manager call")." ".$vars['shop']['name']?>:

<?php echo $vars['person']['first_name']." ".$vars['person']['last_name']."\n";
      echo $vars['person']['email']."\n";
      echo $vars['person']['phone'];?>

Shop ID: <?php echo $vars['shop']['id']?>
https://comiron.com/shop/<?php echo $vars['shop']['id']?>

Person ID: <?php echo $vars['person']['id']?>
https://comiron.com/profile/<?php echo $vars['person']['id']?>
