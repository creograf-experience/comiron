<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('profile/profile_info.php', $vars);
?>
</div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('common',"Shop");?></div>

<br><br>
<center><?php echo $this->t('common',"page is under construction");?></center>



<div style="clear: both"></div>

<?php
$this->template('/common/footer.php');
?>