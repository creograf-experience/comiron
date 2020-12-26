<div id="small_cart">
<?php $this->template('shop/small_cart.php', $vars);?>
</div>

<?php $this->template('central/adv.php', $vars);?>

<?php
//список друзей
/* 
if (!$vars['shop']['is_owner']) {
	echo "<div class=\"header\">".$this->t('shop','Clients')."</div><div class=\"body clearfix\">";
	foreach($vars['shop']['clients'] as $friend){
		echo "<div class=\"itemphoto\">";
		echo "<div class=\"photo\"><a href=\"/profile/{$friend['id']}\">";
	    if($friend['thumbnail_url']){
    		echo "<img src=\"{$friend['thumbnail_url']}\">";
            }else{
                    echo "<img src=\"/images/people/nophoto.gif\">";
                }
                    echo "</a></div><div class=\"title\"><a href=\"/profile/{$friend['id']}\">{$friend['first_name']} {$friend['last_name']}</a></div>";
                    echo "</div>";
            }
	echo "</div>";
} 
*/
?> 