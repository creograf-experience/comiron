<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo" class="blue">
<?php $this->template('profile/profile_info.php', $vars); ?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('common/right.php', $vars);?>
</div>

<div id="profileContentWide">
<?php
if (! empty($_SESSION['message'])) {
  echo "
     <div class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0 .7em;\">
       <p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>
	   <strong>{$_SESSION['message']}</strong></p>
     </div><br />\n";
  unset($_SESSION['message']);
}

?>
<div class="topheader">
<?php
echo $vars['person']['first_name'] . " " . $vars['person']['last_name'];

if($vars['person']['isonline']){
	echo "<div class='toponline'>Online</div>";
}?>
</div>

<?php $this->template('profile/profile_info_center.php', $vars);?>
<?php
  //$this->template('profile/profile_activities.php', $vars);
?>

<?php
  $this->template('profile/profile_content.php', $vars);
?>

<?php
  $this->template('profile/profile_news_firstpage.php', $vars);

  if ($vars['is_owner']) {
//		$this->template('profile/profile_messages_firstpage.php', $vars);
//  	$this->template('profile/profile_friends.php', $vars);
  }
  
  
  
?>

<div style="clear: both"></div>
</div>
<?php
  $this->template('/common/footer.php');
?>