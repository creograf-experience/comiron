<?php
if ( count($vars['activities'])) {
?>
<div class="wall">
<div class="header"><?php echo $this->t('profile','wall'); ?></div>
<div id="activity"><div class="body">

<?php 
  $first = true;
  foreach ($vars['activities'] as $activity) {
    $add = $first ? ' first' : '';
    $first = false;
    echo "<div class=\"item\"><table class=\"markup\"><tr><td>\n
    <div class=\"photo\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$activity['person_id']}\">";
    
    if($activity['thumbnail_url']){
    	echo "<img src=\"{$activity['thumbnail_url']}\">";
    }else{
    	echo "<img src=\"/images/people/nophoto.gif\">";
    }
    
    echo	"</a></div></td><td>
    <div class=\"title\"><a href=\"" . PartuzaConfig::get('web_prefix') . "/profile/{$activity['person_id']}\">{$activity['person_name']}</a></div>";
    
    echo "<a href=\"/profile/{$activity['person_id']}\">{$activity['person_name']}</a> ";
    echo $activity['title'] . "<br />\n";
    if (count($activity['media_items'])) {
      echo "<div style=\"clear:both\">";
      foreach ($activity['media_items'] as $mediaItem) {
        if ($mediaItem['type'] == 'IMAGE') {
          echo "<div class=\" ui-corner-all\" style=\"float:left\"><img src=\"" . $mediaItem['url'] . "\" width=\"50\"></img></div>";
        }
      }
      echo "</div>";
    }
    echo "{$activity['body']}\n";
    echo "</td></tr></table></div>";
  }
  ?>  
  </div></div></div>
<?php   
}
?>