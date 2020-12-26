<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo">
<?php
$this->template('shop/shop_info.php', $vars);
?>
</div>
<div id="profileRight">
<?php
$this->template('shop/shop_right.php', $vars);
?>
</div>
<div id="profileContent">
<?php $this->template('shop/topheader.php', $vars); ?>

<div class="header"><h1><?php  echo $vars['product']['name']; ?></h1></div>

<div class="body">		
<?php 
echo "<div class=\"productitem big\" id=\"{$product['id']}\">";
?>
<script src='/js/jquery.elevatezoom.js'></script>
<table class="product_descr"><tr><td>
    <div class="photo">

    <?php if($product['photo_url']): ?>
	    <!-- img id="zoom_01" src='<?php echo $product['thumbnail_url'] ?>' data-zoom-image="<?php echo $product['photo_url'] ?>"/-->
	    <a class="thumbnail"  href="<?php echo $product['photo_url'] ?>" thumbnail600="<?php echo $product['photo_url'] ?>" thumbnail="<?php echo $product['photo_url'] ?>">
		<img  src="<?php echo $product['thumbnail_url'] ?>" />
		</a>
    <?php else: ?>
	    <img src="/images/product/nophoto.gif" />
    <?php endif ?>

    </div>

    <ul id="thumblist" class="clearfix" >
    <?php if(0 && isset( $product['thumbnail_url'])) {?>
        <li>
            <!-- a href="#" data-image="<?php echo $product['thumbnail_url'] ?>" data-zoom-image1="<?php echo $product['photo_url'] ?>"-->
            <a class="thumbnail"  href="<?php echo $product['photo_url'] ?>" thumbnail600="<?php echo $product['photo_url']  ?>" thumbnail="<?php echo $product['photo_url']  ?>">
			
                <img id="img_01" src="<?php echo $product['thumbnail_url'] ?>" />
            </a>
        </li>
    <?php }
    foreach($vars['product_images'] as $item){
    	if(isset($item['thumbnail_url']) && $item['thumbnail_url']){ 
// echo var_dump($item);   		
    ?>
        <li>
       		 <a class="thumbnail"  href="<?php echo $item['photo_url'] ?>" thumbnail600="<?php echo $item['photo_url'] ?>" thumbnail="<?php echo $item['photo_url'] ?>">
				        <!-- div class="media_picture" style="background-image: url(/images/messages/2266/1075.220x220.jpg)"></div-->
				        <img id="img_<?php echo $item['id'] ?>" src="<?php echo $item['thumbnail_url'] ?>" class="media_in_feeds" style="height:186px !important;width:279px !important;">
			 </a>
            <!-- a href="#" data-image="<?php echo $item['thumbnail_url'] ?>" data-zoom-image="<?php echo $item['photo_url'] ?>"-->
                <!--img id="img_<?php echo $item['id'] ?>" src="<?php echo $item['thumbnail_url'] ?>" /-->
            <!-- /a-->
        </li>
    <?php 
    	}
    } 
    ?>
    </ul>
<script>
    $('#zoom_01').elevateZoom({
 	   zoomType: "window",
  	   cursor: "crosshair",
       zoomWindowFadeIn: 500,
       zoomWindowFadeOut: 750,
       gallery : "thumblist", 
       galleryActiveClass: "active",
       easing : true,
       zoomWindowWidth: 300,
       zoomWindowHeight: 300
   }); 
   //$('#thumblist a').removeClass('active').eq(currentValue-1).addClass('active');	
   var ez = $('#zoom_01').data('elevateZoom');	
  // ez.swaptheimage(smallImage, largeImage);
</script>  

<?php
if(isset($_SESSION['id'])){	
		?>
		<div class="icons">
		<?php 
		if((isset($product['commentisvisible']) && $product['commentisvisible']) || !isset($product['commentisvisible'])) {
			echo "<a href=\"#\" object_id=\"{$product['id']}\" object_name=\"product\" class=\"comment\">({$product['comment_num']})</a>";
		}
		echo "<a href=\"#\" object_id=\"{$product['id']}\" object_name=\"product\" class=\"like\">({$product['likes_num']})</a>";
		echo "<a href=\"#\" object_id=\"{$product['id']}\" object_name=\"product\" class=\"share\"></a>";
		echo "</div>";
	}
?>

</td><td>&nbsp;</td><td>

<?php
echo "<div class=\"descr\">";
echo "<div>{$product['descr']}</div></div>";
if(isset($product['package'])){
	echo $this->t('shop','Package').": {$product['package']} ".(isset($product['edizm'])?$product['edizm']:"");
}
if(isset($product['weight']) and $product['weight']>0){
	echo "<div>".$this->t('shop','Weight').": {$product['weight']} </div>";
}
if(isset($product['volume']) and $product['volume']>0){
	echo "<div>".$this->t('shop','Volume').": {$product['volume']} </div>";
}
if(isset($product['w']) and $product['w']>0 and 
	isset($product['h']) and $product['h']>0 and
	isset($product['d']) and $product['d']>0){
	echo "<div>".$this->t('shop','W')." x ".$this->t('shop','H')." x ".$this->t('shop','D').": {$product['w']}x{$product['h']}x{$product['d']} </div>";
}
if(isset($product['sklad']) and $product['sklad']>0){
	echo "<div>".$this->t('shop','Sklad').": {$product['sklad']} </div>";
}

?>

<br><br>
<?php
//if(isset($vars['shop_client_data'])) {
/*echo '<pre>';
print_r($product);
echo '</pre>';*/
//}

    if(isset($product['props']) and count($product['props'])){
        echo "<div class='props'><span>".$this->t('shop','Properties').":&nbsp;</span>";
        echo "<table class='properties'>";
        foreach($vars['product']['props'] as $prop){ 
            echo "<tr><td id='char{$prop['id']}'>{$prop['name']}:</td><td>{$prop['value']}</td></tr>";
        }
        echo "</table></div>";
    }

	if($product['priceisvisible']){
			//характеристики
			if(isset($product['chars']) and count($product['chars'])){
				echo "<div class='chars'>".$this->t('shop','Characteristics').":&nbsp;";
				echo "<select name='char_id' id='char_id'>";
				echo "<option value=''>".$this->t("common", "Choose")."</option>";	
				foreach($vars['product']['chars'] as $char){ 
					echo "<option value='{$char['id']}' ".($char['sklad']>0 ? "" : " disabled='disabled'")." realprice='{$char['realprice']}' oldprice='{$char['oldprice']}' price='{$char['price']}'>{$char['name']}</option>";
				}
				echo "</select></div>";
			}


			//echo "<div class=\"price\">".$this->t('shop','Price').": <span class=\"price\">{$product['price']}</span>&nbsp;<span class=\"currency\">{$product['currency']['name']}";
                        //echo "</span></div>";
            if(isset($product['oldprice']) and $product['oldprice']>0){
             	echo $this->t('shop','OldPrice').": <span class=\"oldprice\">".number_format($product['oldprice'], 2, '.', '')."</span>&nbsp;";
            	if(isset($product['currency'])){
                                    echo "<span class=\"currency\">{$product['currency']['name']}";
                                    if(isset($product['edizm']) and !empty($product['edizm'])){
                                            echo "/ {$product['edizm']}";
                                    }
                                    echo "</span>";
                }
            }
                                        
			if(isset($vars['person']['shop_clients'])) {            
                            if(array_key_exists($product['shop_id'], $vars['person']['shop_clients']) and $vars['person']['shop_clients'][$product['shop_id']]['discount'] != 0) {

                                $skidka = $product['price'] - ($product['price'] * $vars['person']['shop_clients'][$product['shop_id']]['discount'] / 100);
                                echo "<div class=\"price\">";
								//.$this->t('shop','Price').": 
								echo "<span class=\"price\" style=\"text-decoration:line-through\">{$product['price']}</span>&nbsp;";
                                if(isset($product['currency'])){
                                    echo "<span class=\"currency\">{$product['currency']['name']}";
                                    if(isset($product['edizm']) and !empty($product['edizm'])){
                                            echo "/ {$product['edizm']}";
                                    }
                                    echo "</span>";
                                }
                                echo '<br >';
                                
                                echo $this->t('shop','OurPrice').": <span class=\"price\">".number_format($skidka, 2, '.', '')."</span>&nbsp;";
                                if(isset($product['currency'])){
                                    echo "<span class=\"currency\">{$product['currency']['name']}";
                                    if(isset($product['edizm']) and !empty($product['edizm'])){
                                            echo "/ {$product['edizm']}";
                                    }
                                    echo "</span>";
                                }
                            } else {
                                echo "<div class=\"price\">";
								//.$this->t('shop','Price').": 
								echo "<span class=\"price\">{$product['price']}</span>&nbsp;";
                                    if(isset($product['currency'])){
                                    echo "<span class=\"currency\">{$product['currency']['name']}";
                                    if(isset($product['edizm']) and !empty($product['edizm'])){
                                            echo "/ {$product['edizm']}";
                                    }
                                    echo "</span>";
                                }
                            }
                        } else {
                            echo "<div class=\"price\">";
							//.$this->t('shop','Price').": 
							echo "<span class=\"price\">{$product['price']}</span>&nbsp;";
                            if(isset($product['currency'])){
                                echo "<span class=\"currency\">{$product['currency']['name']}";
                                if(isset($product['edizm']) and !empty($product['edizm'])){
                                        echo "/ {$product['edizm']}";
                                }
                                echo "</span>";
                            }
                        }
                       
                        if(isset($product['original'])){
                        	echo "<div class=\"oprice\">".$this->t('shop','Original Price').": <span class=\"price\">{$product['original']['price']}</span>&nbsp;";
                        	if(isset($product['original']['currency'])){
                        		echo "<span class=\"currency\">{$product['original']['currency']['name']}";
                        		if(isset($product['edizm']) and !empty($product['edizm'])){
                        			echo "/ {$product['edizm']}";
                        		}
                        		echo "</span>";
                        	}
                        }
                        //echo "</div><div class=\"cart\"><!--".$this->t('shop','Buy').": -->";
			/*if(isset($product['edizm'])){
				echo "/ {$product['edizm']}";
			}*/
                       // echo "<div class=\"cart\">".$this->t('shop','Buy').": ";
                        ?>
                        
            </div>
			
			<form action="/shop/cart_add/<?php echo $product['id'] ?>" method="post" class="cart">
			<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $product['shop_id'];?>">
			<?php 
			if(isset($_GET['action_id'])){
			?>
				<input type="hidden" name="action_id" id="action_id" value="<?php echo $_GET['action_id'];?>">
			<?php
			}
			?>
			<?php if(isset($product['chars'])){ ?>
				<input type="hidden" name="charid" value="">
				<input type="hidden" name="charname" value="">
				<input type="hidden" name="charprice" value="">	
			<?php } ?>
			
			
			<table class="markup"><tr><td>
                                <?php if(isset($product['box']) and $product['box'] == 1): ?>
                                <input type="number" class="cartnum" name="num" min="<?php if(!empty($product['package']) and $product['package'] > 0) { echo $product['package'];} else {echo 1;} ?>" value="<?php if(!empty($product['package']) and $product['package'] > 0) { echo $product['package'];} else {echo 1;} ?>" step="<?php if(!empty($product['package']) and $product['package'] > 0) { echo $product['package'];} else {echo 1;} ?>">
                                <?php else: ?>
                                <input type="number" class="cartnum" name="num" min="1" value="1" step="1" />
                                <?php endif ?>
				</td><td>&nbsp;</td><td>
				<button type="submit" class="btn submit add2cart <?php if(!isset($_SESSION['id'])) echo "notAuth"; ?>"><span class="i_add2cart"></span> <?php echo $this->t('shop','Buy') ?></button>
			</td></tr></table>				
			</form>
			</div>
<?php 
	}
	
	
	

echo "</div>";
?>

</td></tr></table>
</div>
  

  <div style="clear: both"></div>
</div>
</div>


<?php $this->template('/common/footer.php', $vars); ?>