
<!-- bull_photos -->

<script>
  $(function() {
    $("img.lazy").lazyload({ threshold : 400 });
    $('.toggle_photo_mode').bind('click', function() {
      $('#big_photos<?php echo $vars['id']; ?>').toggle();
      $('#usual_photos<?php echo $vars['id']; ?>').toggle();
      if ($('#usual_photos<?php echo $vars['id']; ?>').is(':visible')) {
        $.scrollTo($("#usual_photos<?php echo $vars['id']; ?>"), 500);
        var url = '?set_photos_mode=old&ajax=1';
      } else {
        var url = '?set_photos_mode=new&ajax=1';
      }
      $.ajax({
        url: url,
        success: function (data) { }
      });
      $.each ($('img[srctemp]'), function (i, img) {      
        $(img).attr('src', $(img).attr('srctemp')).removeProp('srctemp');
        if ($(img).hasClass('lazy'))
          $(img).lazyload({ threshold : 400 });
      });
      return false;
    });
  });
</script>

<div id="big_photos<?php echo $vars['id']; ?>" style="display: none;">
<?php
unset($vars['medias']['found_rows']);
unset($vars['medias']["firstline"]);
foreach ($vars['medias'] as $media) {
	if (! isset($media['id'])) $media['id'] = 0;
	if (! isset($media['thumbnail_url'])) $media['thumbnail_url'] = $media['url'];
	?>
	<a target="_blank" href="<?php echo $media['thumbnail_url'];?>" class="catalogImages bigImage one-px-margin-bottom"><img srctemp="<?php echo $media['thumbnail_url'];?>" src="<?php echo $media['thumbnail_url'];?>"><span>&nbsp;</span></a>
	
<?php } ?>


<!-- div class="expandFoto open"><a class="toggle_photo_mode" href="#">Свернуть фотографии</a></div -->
</div>
<div id="usual_photos<?php echo $vars['id']; ?>" style="display: block;">

<a class="bigImage one-px-margin-bottom" id="bigImage" href="<?php echo $vars['medias'][0]['thumbnail_url'];?>"><img  src="<?php echo $vars['medias'][0]['thumbnail_url'];?>"></a>
<div class="cf">
<?php
$i=0; 
foreach ($vars['medias'] as $media) {
	if (! isset($media['id'])) $media['id'] = 0;
	if (! isset($media['thumbnail_url'])) $media['thumbnail_url'] = $media['url'];
//	if($i>0){
	?>
	<a target="_blank" href="<?php echo $media['thumbnail_url'];?>" img="<?php echo $media['thumbnail_url'];?>" rel="nofollow"><img src="<?php echo $media['thumbnail_url'];?>"></a>
<?php 
//    }
    $i++;
} ?>

</div><!-- div class="expandFoto"><a class="toggle_photo_mode" href="#">Развернуть все фотографии</a></div -->

    <!-- candies -->
    <table>
      <tbody><tr>
        <td colspan="2">
<div style="display:none; text-align: left" id="candy_437"></div>

        </td>
      </tr>
      <tr>
        <td colspan="2">
          <table>
            <tbody><tr>
              <td>
                <div style="float: left; width: 50%;"><div style="display:none; text-align: left" id="candy_534"></div>
</div>
                <div style="float: left; width: 50%;"><div style="display:none; text-align: left" id="candy_541"></div>
</div>
              </td>
            </tr>
          </tbody></table>
        </td>
      </tr>
    </tbody></table>
    <!-- /candies --></div>
<!-- /bull_photos -->