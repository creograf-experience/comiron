<?php
/*echo '<pre>';
print_r($vars['results']);
echo '</pre>';*/
123
    foreach ($vars['results'] as $shop) {


      	foreach ($shop['products'] as $product) {
      	echo var_dump($product);
            echo "<div class=\"productitem\" id=\"{$product['id']}\">";
            echo "<div class=\"title\"><a href=\"/shop/product/{$product['id']}\">{$product['name']}</a></div>";
	    echo "<div class=\"photo\"><a href=\"/shop/product/{$product['id']}\">";

        if($product['thumbnail_url']){
                echo "<img src=\"{$product['thumbnail_url']}\">";
        }else{
                echo "<img src=\"/images/product/nophoto.gif\">";
        }

                echo "</a></div>";

                //check rights to see price
//echo var_dump($product);
/*echo '<pre>';
print_r($product);
echo '</pre>';*/
                //if(isset($product['priceisvisible']) and $product['priceisvisible']){
                        if(isset($vars['person']['shop_clients']) /*and isset($product['shop'])*/) {       
                                    
                            if(array_key_exists($product['shop_id'], $vars['person']['shop_clients']) and $vars['person']['shop_clients'][$product['shop_id']]['discount'] != 0) {

                                $skidka = $product['price'] - ($product['price'] * $vars['person']['shop_clients'][$product['shop_id']]['discount'] / 100);
                                echo "<div class=\"price\">".$this->t('shop','Price').": <span class=\"price\" style=\"text-decoration:line-through\">{$product['price']}</span>&nbsp;";
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
                                echo "<div class=\"price\">".$this->t('shop','Price').": <span class=\"price\">{$product['price']}</span>&nbsp;";
                                    if(isset($product['currency'])){
                                    echo "<span class=\"currency\">{$product['currency']['name']}";
                                    if(isset($product['edizm']) and !empty($product['edizm'])){
                                            echo "/ {$product['edizm']}";
                                    }
                                    echo "</span>";
                                }
                            }
                        } else {
                            echo "<div class=\"price\">".$this->t('shop','Price').": <span class=\"price\">{$product['price']}</span>&nbsp;";
                            if(isset($product['currency'])){
                                echo "<span class=\"currency\">{$product['currency']['name']}";
                                if(isset($product['edizm']) and !empty($product['edizm'])){
                                        echo "/ {$product['edizm']}";
                                }
                                echo "</span>";
                            }
                        }
                        echo "</div><div class=\"cart\"><!--".$this->t('shop','Buy').": -->";
?>

                <form action="/shop/cart_add/<?php echo $product['id'] ?>" method="post" class="cart">
                <input type="hidden" name="shop_id" id="shop_id" value="<?php echo $product['shop_id'];?>">
                <table class="markup"><tr><td>
                        <?php if(isset($product['box']) and $product['box'] == 1): ?>
                        <input type="number" class="cartnum" name="num" min="<?php if(!empty($product['package']) and $product['package'] > 0) { echo $product['package'];} else {echo 1;} ?>" value="<?php if(!empty($product['package']) and $product['package'] > 0) { echo $product['package'];} else {echo 1;} ?>" step="<?php if(!empty($product['package']) and $product['package'] > 0) { echo $product['package'];} else {echo 1;} ?>">
                        <?php else: ?>
                        <input type="number" class="cartnum" name="num" min="1" value="1" step="1" />
                        <?php endif ?>
                        </td><td>&nbsp;</td><td>
                        <button type="submit" class="btn btn-success add2cart <?php if(!isset($_SESSION['id'])) echo "notAuth"; ?>"><span class="i_add2cart"></span> <?php echo $this->t('shop','Buy') ?></button>
                </td></tr></table>				
                </form>
                </div>
<?php 			
                //}
                $product['object_name']="product";
                $this->template('like/like_smallinline.php', $product);


                echo "</div>";
        }
   }
?>
<div class="clear" id="before_block"></div>
<?php if(isset($count_spec_flag) and $count_spec_flag) : ?>
<div class="more_btn"><a href="#" class="submit btn" id="showSpec" page="2">Показать ещё</a></div>
<?php endif ?>
<!--script>
	$('.productitem').bind('click', function(event) {
		if(event.target.nodeName!="A"){
			window.location = '/shop/product/'+ $(this).attr('id');
			return false;
		}
	});
	</script-->        
         
<div class="pages">
<span class="p">
<?php
 
if($vars['nextpage']>0){
	echo "<a class=\"load\" href=\"/search?q=".$_GET['q']."&for=".$_GET['for']."&curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if($vars['totalpages']>0){
	echo "<div id=\"totalpages\">{$vars['totalpages']}</div>";
}
?>
</div>

