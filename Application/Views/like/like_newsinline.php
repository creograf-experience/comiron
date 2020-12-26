<?php
$qwtitle=stripslashes($vars['title']);
if(isset($_SESSION['id'])){
			echo "<div class=\"icons\">";
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"comment\">".
			$this->t('common','to comment')
			."</a></span>";
			echo "<span class=\"right\">";
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"like\">".
			$this->t('common','like')
			." <span class=\"num\">{$vars['likes_num']}</span></a></span>";
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"share\">".
			$this->t('common','share')
			." <span class=\"num\">{$vars['shared_num']}</span></a></span>";
/*			echo "<span><a href=\"/profile/news/get/{$vars['id']}\"  title=\"{$qwtitle}\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"newsopen n_comments\">".
			$this->t('common','all comments')
			." <span class=\"num\">{$vars['comment_num']}</span></a></span></span>";						
*/
?>			
</div>

	<div id="<?php echo "comments_".$vars['object_name']."_".$vars['id']; ?>">
	<!-- begin  -->
	<?php 
		$this->template('comment/comment_news.php', $vars);
	?>
	<!--  end -->
	</div>
<?php 
}
?>