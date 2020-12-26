
<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/profile/messages/im/{$vars['to']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
	echo "<div id=\"totalpages\">{$vars['totalpages']}</div>";
}
?>
</div>

<div class="messageslist">

<?php
unset($vars['messages']['found_rows']);
//показать в порядке сверху вниз
$im=array_reverse($vars['messages']['im']);
/*echo '<pre>';
print_r($vars);
echo '</pre>';*/
foreach ($im as $message) {
		$message['thumbnail_url'] = $vars['messages']['persons'][$message['from']]['thumbnail_url'];
		$message['name'] = $vars['messages']['persons'][$message['from']]['first_name']." ".$vars['messages']['persons'][$message['from']]['last_name'];
                $message['shop'] = $vars['shop'];
                
	    $this->template('profile/message_index.php', $message);
}
?>
</div>
 
<div id="dialog_message_remove" title="<?php $this->t('common','confirm_remove_message_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>
 