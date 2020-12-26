<?php 
if(isset($_SESSION['id'])){
	echo "<div class=\"icons\">";
	
	if((isset($vars['commentisvisible']) && $vars['commentisvisible']) || !isset($vars['commentisvisible'])) { 
		echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" small=\"1\" class=\"comment\"> {$vars['comment_num']}</a></span>";
	}
	echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" small=\"1\" class=\"like\"> ".$this->t("common", "like")." {$vars['likes_num']} </a></span>";
	echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" small=\"1\" class=\"share\"> {$vars['shares_num']}</a></span>";
?>			
	</div>
<?php 
	echo "<div class=\"place_for_comment_compose\" id=\"{$vars['object_name']}_{$vars['id']}\"></div>";

}
?>