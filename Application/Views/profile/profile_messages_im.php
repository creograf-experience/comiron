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

<div class="header"><?php echo $this->t('profile',"Messages");?></div>


<div id="im_content">

<?php 
$this->template('profile/messages_index.php', $vars); ?>
<div class="newmessages messageslist"></div>
</div>


<script type="text/javascript" src="/js/photos.js"></script>
<div id="dialog_news_remove" title="<?php $this->t('common','confirm_remove_news_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>

<div class="messages_nav">
	<a href="/profile/messages/im/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>?period=today" id="m_today"><?php echo $this->t('common',"today");?></a>
	<a href="/profile/messages/im/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>?period=yestoday" id="m_yesterday"><?php echo $this->t('common',"yesterday");?></a>
	<a href="/profile/messages/im/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>?period=week" id="m_week"><?php echo $this->t('common',"week");?></a>
	<a href="/profile/messages/im/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>?period=month" id="m_month"><?php echo $this->t('common',"month");?></a>
	<a href="/profile/messages/im/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>?period=3month" id="m_3month"><?php echo $this->t('common',"3month");?></a>
</div>

<div id="message_compose_inline"></div>


</div>
<div style="clear: both"></div>

<script>
$(document).ready(function(){
	console.log("/profile/messages/compose_inline/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>/<?php if(isset($vars['shop']) and isset($vars['shop']['id'])) {echo "?shop_id=".$vars['shop']['id'];} ?>");
   	$("#message_compose_inline").load("/profile/messages/compose_inline/<?php if(isset($vars['to'])){ echo $vars['to']; } ?>/<?php if(isset($vars['shop']) and isset($vars['shop']['id'])) {echo "?shop_id=".$vars['shop']['id'];} ?>", readyfunction);
	wSocket.createSocket("<?php echo $_SESSION['id']?>");

	////wSocket.setMyId("<?php echo $_SESSION['id']?>");
});
</script>

<?php
$this->template('/common/footer.php');
?>