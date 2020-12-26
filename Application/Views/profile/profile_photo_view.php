<?php
if(!isset($_GET["ajax"])){
$this->template('/common/header.php', $vars);
	?>
	<div id="profileInfo">
	<?php $this->template('profile/profile_info.php', $vars); ?>
	</div>
	<div id="profileContentWide">
	<?php $this->template('profile/topheader.php', $vars); 
	echo "<div class=\"header\">{$current_media['title']}</div>";
}	
?>
<div id="bigphoto">
<div class="photo_normal">
  	<div class="nav">
  	<table class="markup" style="width:100%"><tr><td>
  	<div class="icons">
      <a href="/profile/photos_view/<?php echo $albums['owner_id'];?>/<?php echo $albums['id'];?>"><?php echo $this->t('common','close'); ?></a>  
      <a href="<?php echo $current_media['original_url'];?>"><?php echo $this->t('profile','original size'); ?></a>
<?php     
if ($vars['is_owner']) {
?>	    		
      <a class="edit" href="#" onclick="saveMediaDialog(<?php echo $current_media['owner_id']?>, <?php echo $current_media['id'];?>, 'editMedia_<?php echo $current_media['id'];?>');"><?php echo $this->t('common','edit'); ?></a>
	    		<div id="dialog" title="<?php echo $this->t('profile','Delete media'); ?>" style="display:none">
	    		<p><span id="dialogSpan" class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><?php echo $this->t('common','Are you sure you want to delete this media?'); ?></p>
	    		</div>
<?php	    		
}
?>			
		</div>
    </td><td><center>
<?php
if ($item_order != 1) {
  echo '<a class="left" href="/profile/photo_view/'.$medias[0]['owner_id'].'/'.$medias[0]['album_id'].'/'.$medias[0]['id'].'" ><img id="
nav_left" style="cursor: pointer;" src="/images/b_left.gif" /></a>';
} else {
  echo '<img id="nav_left" style="cursor: default;" src="/images/b_left_disable.gif" /></a>';
}
if ($item_order != $item_count) {
  $next_order = ($item_order == 1) ? 1 : 2;
  echo '<a class="right" href="/profile/photo_view/'.$medias[$next_order]['owner_id'].'/'.$medias[$next_order]['album_id'].'/'.$medias[$next_order]['id'].'" ><img id="nav_left" style="cursor: pointer;" src="/images/b_right.gif" /></a>';
} else {
  echo '<img id="nav_right" style="cursor: default;" src="/images/b_right_disable.gif" />';
}
?>
    </center></td><td>
<?php
if ($item_count > 1) {
  echo $this->t('profile','viewing_picture', array('{item_order}'=>$item_order, '{item_count}'=>$item_count));
}
?>
    </td></tr></table>
  </div>
  <div class="bigphoto">
	  <div class="x"><a href="#" class="removephoto" owner_id="<?php echo $current_media['owner_id']?>" id="<?php echo $current_media['id']?>"><img src="/images/i_close.png"></a></div>
      <img style="cursor: default;" id="media_<?php echo $current_media['id'];?>" alt="<?php echo $current_media['title'];?>" src="<?php echo ($current_media['thumbnail_url600']?$current_media['thumbnail_url600']:$current_media['url']);?>" />
      <div class="descr">
      <span id="staticTitle_<?php echo $current_media['id']?>"><?php echo $current_media['title'];?></span><br/>
      <span id="staticDescription_<?php echo $current_media['id']?>"><?php echo $current_media['description'];?></span>
    	</div>
    	
  </div>
</div>

</div>
	<script src="/js/photos.js"></script>

<?php
if(!isset($_GET["ajax"])){
	echo "<script src=\"/js/photos.js\"></script>";
	$this->template('/common/footer.php');
}
?>
