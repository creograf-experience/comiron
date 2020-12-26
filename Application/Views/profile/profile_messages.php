<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('profile/profile_info.php', $vars);
?>
</div>
<div id="profileContentWide">
<div class="chat">
<?php $this->template('profile/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('profile',"Messages");?></div>
<button id="messageCompose" class="funbutton"><?php echo $this->t('profile',"Compose message");?></button>
<?php
/*echo '<pre>';
print_r($vars);
echo '</pre>';*/
?>
<?php $this->template('profile/mperson_index.php', $vars); ?>

  
</div>
</div>

<div style="clear: both"></div>
<!-- script type="text/javascript" src="<?php echo PartuzaConfig::get('web_prefix')?>/js/messages.js"></script-->


<?php
$this->template('/common/footer.php');
?>