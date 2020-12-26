
	<div class="comment">
<?php /* if(count($vars['comments'])>0){ ?>
	<div class="header"><?php echo $this->t('common','Comments'); ?></div>
<?php } */ ?>
	
<?php 
	if(isset($vars['hide_comments_link']) and $vars['hide_comments_link']){
		echo "<div class=\"header\">".$this->t('common','Comments')."</div>";
	}else
		//загрузить еще комментарии
		if(count($vars['comments']) < $vars['comment_num']){
			echo "<div class=\"comment_load\">";
			echo "<a href=\"#\" class=\"comment_load\" id=\"comment_load_{$vars['object_name']}_{$vars['id']}\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\"><span class=\"text\">".$this->t('common','Comments')." ({$vars['comment_num']})</span></a>";
			echo "<a href=\"#\" style=\"float:right;\" class=\"comment_load\" id=\"comment_load_{$vars['object_name']}_{$vars['id']}\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\"><span class=\"down\"></span><span class=\"text\">".$this->t('common','show')."</span></a>";
			echo "</div>";
		}else if(count($vars['comments']) == $vars['comment_num'] and count($vars['comments'])>1){
			echo "<div class=\"comment_unload\">";
//			echo "<a href=\"#\" class=\"comment_unload\" id=\"comment_unload_{$vars['object_name']}_{$vars['id']}\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\"><span class=\"up\"></span><span class=\"text\">".$this->t('common','Hide comments')." ({$vars['comment_num']})</span></a>";
			echo "<a href=\"#\" class=\"comment_unload\" id=\"comment_unload_{$vars['object_name']}_{$vars['id']}\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\"><span class=\"text\">".$this->t('common','Comments')." ({$vars['comment_num']})</span></a>";
			echo "<a href=\"#\" style=\"float:right;\" class=\"comment_unload\" id=\"comment_unload_{$vars['object_name']}_{$vars['id']}\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\"><span class=\"up\"></span><span class=\"text\">".$this->t('common','hide')."</span></a>";
			
			echo "</div>";
		}
?>
	<div class="body1">
<?php 
	//показать последние комментарии
	if(isset($vars['comments'])){
		$this->template('comment/comment_index.php', $vars);
	}
?>
	</div></div>

<?php
//	место для формы добавления комментария 
	echo "<div class=\"place_for_comment_compose\" id=\"{$vars['object_name']}_{$vars['id']}\"></div>";
?>
