
<?php

	if(isset($vars['actions'])){
?>
<div class="finishtime"><?php 
$ar = getdate(mktime(23,59,59)-time());

echo $this->t("central", "Finish time");
echo "<span>${ar["hours"]} ".$this->t("central", "h")." ${ar["minutes"]} ".$this->t("central", "m")." ${ar["seconds"]} ".$this->t("central", "s")." </span>";
 ?> </div>

<h1 class="hot"><?php echo $this->t("central", "Hot actions") ?></h1>
<div class="top_actions">

<?php

		$i = 1;
		foreach ($vars['actions'] as $product) {
			if($i==2 or $i==6){
				echo "<div class=\"line\">";
			}
		
			echo "<div class=\"actionitem action{$i}\" id=\"{$product['id']}\">";
			echo "<div class=\"discount\">{$product['discount']}%</div>";
    		echo "<span class=\"price\">{$product['price']}&nbsp;";
            if(isset($product['currency'])){
            	echo "<span class=\"currency\">{$product['currency']['name']}";
            	if(isset($product['edizm']) and !empty($product['edizm'])){
            	    echo "/ {$product['edizm']}";
            	}
            	echo "</span>";
            }
            echo "</span>";
    		
    		if(isset($product['oldprice']) and $product['oldprice']>0){
             	echo "<span class=\"oldprice\">".number_format($product['oldprice'], 2, '.', '')."&nbsp;";
            	if(isset($product['currency'])){
                                    echo "<span class=\"currency\">{$product['currency']['name']}";
                                    if(isset($product['edizm']) and !empty($product['edizm'])){
                                            echo "/ {$product['edizm']}";
                                    }
                                    echo "</span>";
                }
                echo "</span>";
            }

        	echo "<div class=\"photo\"><a href=\"/shop/product/{$product['id']}/?action_id={$product['action_id']}\">";
                    	if($product['thumbnail_url']){
    						echo "<img valign=\"center\" align=\"center\" src=\"{$product['thumbnail_url']}\" border=0 style=\"border:none; overflow: inherit;\" alt=\"{$product['name']}\" title=\"{$product['name']}\"></a>";
			    		}else{
    						echo "<img src=\"/images/product/nophoto.gif\">";
    					}
    		echo "</a></div>";
    		
    		echo "<div class=\"title\"><a href=\"/shop/product/{$product['id']}/?action_id={$product['action_id']}\">{$product['name']}</a></div>";

    		
    		echo "</div>";
    		
    		if($i==4 or $i==7){
				echo "</div>";
			}
			
    		$i++;
    	}
	echo "</div>";
    }
?>
