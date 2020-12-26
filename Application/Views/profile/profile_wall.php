<?php
if ( count($vars['wall'])) {
?>

<!--div class="header"><?php echo $this->t('profile','wall'); ?></div -->
<div class="body">
<?php 
/*echo '<pre>';
print_r($vars['wall']);
echo '</pre>';*/
  $first = true;
  foreach ($vars['wall'] as $wall) {
    // Переделать в моделе
    //if($wall['person_id'] == $_SESSION['id']) {
        $add = $first ? ' first' : '';
        $first = false;
        echo "<div class=\"item\"><table class=\"markup\"><tr><td>\n
        <div class=\"photo\"><a href=\"/profile/{$wall['owner_wall']['id']}\">";

        if($wall['owner_wall']['thumbnail_url']){
            echo "<img class=\"smallavatar\" src=\"{$wall['owner_wall']['thumbnail_url']}\">";
        }else{
            echo "<img class=\"smallavatar\" src=\"/images/people/nophoto.gif\">";
        }

        echo	"</a></div></td><td>&nbsp;</td><td>
        <div class=\"title\"><a href=\"/profile/{$wall['owner_wall']['id']}\">{$wall['owner_wall']['first_name']} {$wall['owner_wall']['last_name']}</a></div>";
        if(empty($wall['shop_id'])) {
            echo "<div class=\"title subtitle\"><a href=\"/profile/{$wall['person']['id']}\">{$wall['person']['first_name']} {$wall['person']['last_name']}</a></div>";
        } else {
            echo "<div class=\"title subtitle\"><a href=\"/shop/{$wall['shop']['id']}\">{$wall['shop']['name']}</a></div>";
        }

        if($wall['object_name']){
            $this->template('wall/embed_wall_'.$wall['object_name'].'.php', $wall);
        }

    //    echo $wall['title'] . "<br />\n";
    /*    if (count($wall['media_items'])) {
          echo "<div style=\"clear:both\">";
          foreach ($wall['media_items'] as $mediaItem) {
            if ($mediaItem['type'] == 'IMAGE') {
              echo "<div class=\" ui-corner-all\" style=\"float:left\"><img src=\"" . $mediaItem['url'] . "\" width=\"50\"></img></div>";
            }
          }
          echo "</div>";
        }
        echo "{$wall['body']}\n";
    */    
        echo "</td></tr></table></div>";
    //}
  }
  ?>  
  </div>
<?php   
}
?>