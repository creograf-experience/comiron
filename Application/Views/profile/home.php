<?php
//этот шаблон не показывается
$this->template('/common/header.php', $vars); ?>
<div id="profileInfo" class="blue">
<?php $this->template('profile/profile_info.php', $vars);?>
</div>

<!-- div id="profileRight" class="blue">
<?php $this->template('common/right.php', $vars);?>
</div-->


<div id="profileContentWide">
<?php $this->template('profile/profile_info_center.php', $vars);?>


<?php
if ($vars['error_message']) {
	echo "<div class=\"ui-state-error\" style=\"margin-bottom:20px;margin-top:10px;margin-right:14px;padding:20px;\">{$vars['error_message']}</div>";
}
if ($vars['error']) {
	echo "<div class=\"ui-state-error\" style=\"margin-bottom:20px;margin-top:10px;margin-right:14px;padding:20px;\">{$vars['error']}</div>";
}
?>

<?php
$this->template('profile/profile_friendrequests.php', $vars);
?>

<?php
$this->template('profile/profile_activities.php', $vars);
?>

<?php
if (! empty($_SESSION['message'])) {
  echo "<b>{$_SESSION['message']}</b><br /><br />";
  unset($_SESSION['message']);
}
foreach ($vars['applications'] as $gadget) {
  $width = 488;
  $view = 'home';
  $this->template('/gadget/gadget.php', array('width' => $width, 'gadget' => $gadget,
      'person' => $vars['person'], 'view' => $view));
}
?>
<?php
$this->template('profile/profile_friends.php', $vars);
?>

</div>
</div>
<?php
$this->template('/common/footer.php');
?>