<div id="newswalltab">

	<ul class="header-tab">
		<li><a href="#news"><?php echo $this->t('common','News'); ?></a></li>
		<li class="last-child"><a href="#wall"><?php echo $this->t('profile','wall'); ?></a></li>
	</ul>

	<div id="news" class="news">
		<?php
		if ($vars['is_owner']) {
			echo "<div class=\"action\"><a href=\"#\" class=\"funbutton\" id=\"news_compose\" title=\"{$this->t('common','Post news')}\">{$this->t('profile','Post news')}</a></div>";
			echo "<div id=\"news_compose_dialog\"  style=\"display:none;\">";
			$this->template('profile/news_compose.php', $vars);
			echo "</div>";
		}

 		$this->template('profile/news_index.php', $vars); ?>
	</div>

	<div id="wall">
		<?php $this->template('profile/profile_wall.php', $vars); ?>
	</div>

</div>

<script>
$(document).ready(function() {
	$('#newswalltab').tabs();
});
</script>