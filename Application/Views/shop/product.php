
<?php

	if(isset($vars['products'])){
		foreach ($vars['products'] as $product) {
			echo "<div class=\"productitem\" id=\"{$product['id']}\">";
        	echo "<div class=\"photo3\">";
                    //echo "<div class=\"lupa\"><span><img src=\"/images/lupa.png\" /></span></div>";
                    if($product['photo_url']) {
                    	echo "<a title=\"{$product['name']}\" href=\"{$product['photo_url']}\" class=\"highslide\" onclick=\"return hs.expand(this)\">";
                    	
                    	//echo "<img valign=\"center\" align=\"center\" src=\"{$product['thumbnail_url']}\" border=0 style=\"border:none; overflow: inherit;\" alt=\"{$product['name']}\" title=\"{$product['name']}\"></a>";
                    	
                   /* echo "<div class=\"increase_parent lupa\"><span><img src=\"/images/lupa.png\" /></span>";
                        echo "<div class=\"increase_photo\" data-id=\"{$product['id']}\">";
                            echo "<div class=\"header_photo\">{$product['name']}<div class=\"close_photo\"></div></div>";
                            echo "<img src=\"{$product['photo_url']}\" />";
                        echo "</div>";
                    echo "</div>";*/
                    }
                    //echo "<a href=\"/shop/product/{$product['id']}\">";
    
    		if($product['thumbnail_url']){
    			//echo "<img src=\"{$product['thumbnail_url']}\">";
    			echo "<img valign=\"center\" align=\"center\" src=\"{$product['thumbnail_url']}\" border=0 style=\"border:none; overflow: inherit;\" alt=\"{$product['name']}\" title=\"{$product['name']}\"></a>";
    			
    		}else{
    			echo "<img src=\"/images/product/nophoto.gif\">";
    		}
    		
			echo "</a></div>";
                        /*if($product['photo_url']) {
			echo "<div class=\"increase_parent\"><span>".$this->t('shop','Increase photo')."</span>";
                            echo "<div class=\"increase_photo\" data-id=\"{$product['id']}\">";
                                echo "<div class=\"header_photo\">{$product['name']}<div class=\"close_photo\"></div></div>";
                                echo "<img src=\"{$product['photo_url']}\" />";
                            echo "</div>";
                        echo "</div>";
                        }*/
			//check rights to see price
//echo var_dump($product);

			echo "<div class=\"title\"><a href=\"/shop/product/{$product['id']}\">{$product['name']}</a></div>";


			if(isset($product['priceisvisible']) and $product['priceisvisible']){
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
                                if(isset($vars['person']['shop_clients']) and isset($product['shop'])) {       
                                    
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
                                  	echo "</div>";
                                }
				echo "</div><div class=\"cart\"><!--".$this->t('shop','Buy').": -->";
?>
			
        	<form action="/shop/cart_add/<?php echo $product['id'] ?>" method="post" class="cart">
        
 			<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $product['shop_id'];?>">
			
			<?php 
			if(isset($_SESSION['action_id'])){
			?>
				<input type="hidden" name="action_id" id="action_id" value="<?php echo $_SESSION['action_id'];?>">
			<?php
			}
			?>
			
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
			$product['object_name']="product";
			$this->template('like/like_smallinline.php', $product);
			
			
			echo "</div>";
		}
	}
?>


<?php 
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
?>


<div class="pages">
<span class="p">
<?php 
if(isset($vars['nextpage']) and $vars['nextpage']>0){
    echo "<a class=\"load\" href=\"{$vars['nextpageurl']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
    echo "<div id=\"totalpages\" content-id=\"productbody\">{$vars['totalpages']}</div>";
}
?>
</div>

<?php if(isset($vars['count_spec_flag']) and $vars['count_spec_flag']) : ?>
<div class="clear" id="before_block"></div>
<div class="more_btn"><a href="#" class="submit btn" id="showSpec" page="<?php if(isset($vars['page'])){ echo $vars['page']; }else{ echo "2"; } ?>"><?php echo $this->t("common",'Show more'); ?></a></div>
<?php endif ?>
<div id="insert_js"><script type="text/javascript" src="/js/increase_photo.js"></script></div>
<script type="text/javascript" src="/js/number_format.js"></script>
<script type="text/javascript">
    $(".notAuth").click(function(){
        //alert('<?php echo $this->t('common','notauth')?>');
    })
    $('#showSpec').unbind('click');
    $('#showSpec').bind('click', function() {
        var page=parseInt($(this).attr("page"));
        $(this).attr('page',page+1);
		$(".more_btn").hide();
       $.ajax({
            type: "POST",
            data: {page: page},
            url: "/shop/<?php echo $vars['shop']['id'] ?>/"+page,
            success: function(data)
            {
                $("#before_block").before(data);
                
            },
        });
        return false;
    	});
    </script>
                        
<!--script>
	$('.productitem').bind('click', function(event) {
		if(event.target.nodeName!="A"){
			window.location = '/shop/product/'+ $(this).attr('id');
			return false;
		}
	});
	</script-->
<?php
} // if !ajax
?>