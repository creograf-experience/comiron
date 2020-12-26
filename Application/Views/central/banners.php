<div class="banners">
<div class="small">

	<?php
		if(isset($vars['banners']) && is_array($vars['banners'])){
			foreach ($vars['banners'] as $banner) {
				if(!$banner['isbig']){
					echo "<a href=\"".$banner['link']."\"><img src=\"/images/advert/".$banner['img']."\"></a>";
				}
			}
		}
	?>
</div>
<div class="slider">
	<!--div class="slick-list draggable" tabindex="0">
		<div class="slick-track" style="opacity: 1; width: 500px; transform: translate3d(0px, 0px, 0px);"-->
				<?php
					if(isset($vars['banners']) && is_array($vars['banners'])){
						foreach ($vars['banners'] as $banner) {
							if($banner['isbig']){
								echo "<div class=\"slide slick-slide slick-active\" index=\"0\" style=\"width: 500px;\">"
									."<a data-lightbox=\"banner\" href=\"".$banner['link']."\"><img src=\"/images/advert/".$banner['img']."\" ></a>"
									."</div>";	
							}
						}
					}
				?>
			
		<!--/div>
	</div-->
</div>
</div>
<style>
.slick-dots{
    margin-top:-25px;
}
</style>