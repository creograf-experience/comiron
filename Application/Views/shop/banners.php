<?php if(isset($vars['banners'])){ ?>

<div class="banners">
<div class="slider">
	<?php 
		foreach ($vars['banners'] as $banner) {
        	
            if($banner['isvisible'] and $banner['img'] and $banner['link']){ 
    ?>      
		       <div class="slide slick-slide slick-active" index="0" style="width: 500px;">
					<a data-lightbox="banner" href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['img']; ?>" alt=""></a>
				</div>    
	<?php
			}
		}
	?>
</div>
</div>
<style>
.slick-dots{
    margin-top:-25px;
}
</style>
<?php } ?>