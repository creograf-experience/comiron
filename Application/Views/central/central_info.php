<div class="body clearfix">

<!-- div class="header2"><?php echo $this->t('central','All Categories'); ?></div-->
<ul class="categorylist">
<?php
//echo var_dump($vars['categories']);
	foreach ($vars['categories'] as $category) {
		
		
		echo "<dl class=\"cl-item\" data-role=\"first-menu\" ><dt class=\"cate-name\">";
		echo "<li><table class=\"markup\"><tr><td class=\"icon\">";
		echo "<a href=\"/central/category/{$category['id']}\" style=\"background-image:url(";
		if(isset($category['thumbnail_url'])){
			echo "{$category['thumbnail_url']}";
		}else{
			echo "/images/category/nophoto.gif";
		}
		echo ")\"></a></td><td>";
		echo "<span><a href=\"/central/category/{$category['id']}\">{$category['name']}</a></span></td></tr></table></li></dt>";

		if(isset($category['subs'])){
			?>
			<dd class="sub-cate" data-role="first-menu-main">
				<div class="sub-cate-main">
					<div class="sub-cate-content" style="display:inline-block">
					
		<?php
					foreach ($category['subs'] as $sub) {
				//echo var_dump($sub);
						echo	"<div class=\"sub-cate-row\">";
						echo	"<dl class=\"sub-cate-items\" data-role=\"two-menu\">";
						echo "<div class=\"subs\"><dt><a href=\"/central/category/{$sub['id']}\">{$sub['name']}</a></dt>";
						echo "<dd>";
							foreach ($sub['subs'] as $sub2) {
								echo "<a href=\"/central/category/{$sub2['id']}\">{$sub2['name']}</a>";
							}
						echo "</dd></div>";
						echo "</dl>";
						echo "</div>";
					}
						?>
				</div>
			</div>
		</dd>

		<?php
	  }
		echo "</dl>";	
	}
?>
</ul>
<br><br>

<form action="/central/searchorg" method="post" id="searchorg">
<div class="header"><?php echo $this->t('central','Company Search'); ?></div>

<ul>
<li><label for="name">
<?php echo $this->t('central','Name'); ?>:</label>
<input type="text" name="name" id="name" <?php if(isset($vars['searchorg']['name'])){ echo "value=\"{$vars['searchorg']['name']}\""; }?>>
</li>
<li><label for="country_id">
<?php echo $this->t('central','Country'); ?>:</label>
<select name="country_id" id="country_id">
<option value=""><?php echo $this->t('central','all'); ?></option>
<?php
foreach ($vars['countries'] as $country) {
	echo "<option ".((isset($vars['searchorg']['country_id']) and $country['id']==$vars['searchorg']['country_id'])?" selected ":"")." value=\"{$country['id']}\">{$country['name']}</option>";	
} 
?>
</select>
</li>
<!--<li><label for="region_id">
<?php //echo $this->t('central','Region'); ?>:</label>
<select name="region_id" id="region_id">
<option value=""><?php //echo $this->t('central','all'); ?></option>
<?php
/*if(isset($vars['regions']) and is_array($vars['regions'])){
	foreach ($vars['regions'] as $region) {
		echo "<option ".((isset($vars['searchorg']['region_id']) and $region['id']==$vars['searchorg']['country_id'])?" selected ":"")." value=\"{$region['id']}\">{$region['name']}</option>";	
	}
} */
?>
</select>
</li>-->
<li>
<table class="markup"><tr><td>
<span class="niceCheck"><input type="checkbox" name="delivery" id="delivery" value="0" <?php if(isset($vars['searchorg']['name']) and $vars['searchorg']['name']){ echo " checked"; }?>></span>
</td><td>
<label for="delivery">
<?php echo $this->t('central','delivery to region'); ?></label>
</td></tr></table> 
</li>
<li>
<button class="btn smallsubmit" type="submit"><?php echo $this->t('central','Search'); ?></button>
</li>
</ul>
</form>
<script>
	$(document).ready(function(){
		$("#country_id").change(function(){
			var country_id=$("#country_id").attr("value");
			$("#region_id").load("/central/region_select/"+country_id);
		});
	});
</script>
<br><br>

</div>	