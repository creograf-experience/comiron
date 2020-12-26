<?php
$message['title'] = strip_tags($message['title']);
$message['body'] = strip_tags($message['body'], '<p><a><i><b><strong><br>');
//$created = strftime('%B %e, %Y at %H:%M', $message['created']);
$created=$this->formatdate($message['created']);

$userId = $messageType == 'inbox' ? $message['from'] : $message['to'];
if (empty($message['thumbnail'])) {
  $thumb = PartuzaConfig::get('site_root') . '/images/people/nophoto.gif';
} else {
  $thumb = PartuzaConfig::get('site_root'). $message['thumbnail'];
}
$thumb = Image::by_size($thumb, 50, 50);
$label = $messageType == 'inbox' ? $this->t('profile','From') : $this->t('profile','To');
$back =  $messageType == 'inbox' ? $this->t('profile','Inbox') : $this->t('profile','Sent Items');
$linkId = $messageType == 'inbox' ? $message['from'] : $message['to'];
//
echo "<div class=\"message_view\">".
     "<div class=\"message_view_from\"><img src=\"$thumb\" align=\"right\" /><b>$label</b>: <a href=\"/profile/$linkId\">{$message['name']}</a> at $created</div>".
     "<div class=\"message_view_subject\"><b>Subject</b>: {$message['title']}</div>".
     "<br />".
     "<div class=\"message_view_body\">{$message['body']}</div>".
     "</div>".
     "<br />".     
     "<input type=\"button\" class=\"button\" value=\"". $this->t('profile','Back to')." $back\" />";

$message['object_name']="messages";
$this->template('wall/share_inline.php', $message);


?>