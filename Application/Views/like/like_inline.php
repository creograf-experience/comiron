<?php 
if(isset($_SESSION['id'])){
			echo "<div class=\"icons\">";
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"comment\">".
			$this->t('common','to comment')
			."</a></span><div class=\"right\">";
			
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"like\">".
			$this->t('common','like')
			." ({$vars['likes_num']})</a></span>";
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"share\">".
			$this->t('common','share')
			." ({$vars['shared_num']})</a></span></div>";
	if(!isset($vars['hide_comments_link']) or !$vars['hide_comments_link']){			
			echo "<span><a href=\"#\" object_id=\"{$vars['id']}\" object_name=\"{$vars['object_name']}\" class=\"comments\">".
			$this->t('common','all comments')
			." ({$vars['comment_num']})</a></span>";
	}
?>			
			</div>
<br><br>
	<div id="<?php echo "comments_".$vars['object_name']."_".$vars['id']; ?>" >
	<!-- begin  -->
	<?php 
		$this->template('comment/comment.php', $vars);
	?>
	<!--  end -->
	</div>
<?php 
}
?>