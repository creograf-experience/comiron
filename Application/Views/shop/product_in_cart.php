<form action="/shop/cart_send/<?php echo $vars['shop']['id'] ?>" id="cart" method="get">
<input type="hidden" id="shop_id" name="shop_id" value="<?php echo $vars['shop']['id']?>">
<?php
	if(!isset($vars['cart']['cart'])){
 		echo $this->t('shop', 'Cart is empty');
	}

	if(isset($vars['cart']['cart'])){
?>
<table class="orderdetails">
<tr>
	<th><?php echo $this->t('shop', 'Photo'); ?></th>
	<th><?php echo $this->t('shop', 'Code'); ?></th>
	<th><?php echo $this->t('shop', 'Product Name'); ?></th>
	<th><?php echo $this->t('shop', 'Price'); ?></th>
	<th><?php echo $this->t('shop', 'Count'); ?></th>
	<th><?php echo $this->t('shop', 'Sum'); ?></th>
	<th><?php echo $this->t('shop', 'Delete'); ?></th>
</tr>

<?php
		foreach ($vars['cart']['cart'] as $cart) {
?>
	<tr class="<?php echo $cart['id'] ?>">
		<td>
			<div class="photo"><a href="/shop/product/<?php echo $cart['product']['id']?>">
			<?php
    		if($cart['product']['thumbnail_url']){
    			echo "<img src=\"{$cart['product']['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/product/nophoto.gif\">";
    		}
			?>
			</a></div>
		</td>
		<td><?php echo $cart['product']['code'];?></td>
		<td>
        	<div class="item cartitem cart_<?php echo $cart['id']?>" id="<?php echo $cart['product_id']?>">
        	<div class="title"><a href="/shop/product/<?php echo $cart['id']?>"><?php echo $cart['product']['name']?></a></div>
        	</div>
		</td>
		<td>
			<span class="price"  id="price-<?php echo $cart['id']?>">
                                   <?php
                                    if($cart['sum']/$cart['num'] < $cart['product']['price']) {
                                        echo "<span style='text-decoration:line-through'>".$cart['product']['price']."</span><br />";
                                        echo number_format($cart['sum']/$cart['num'], 2, '.', '');
                                    } else {
                                        echo $cart['product']['price'];
                                    }
                                    ?>
            </span><span class="currency"><?php echo $cart['currency']['name']?></span>
		</td>
		<td>

                                <span class="price">
                                    <?php if(isset($cart['product']['box']) and $cart['product']['box'] == 1): ?>
                                    <input type="number" class="count" name="num<?php echo $cart['id']?>" id="count-<?php echo $cart['id']?>" min="<?php if(!empty($cart['product']['package']) and $cart['product']['package'] > 0) { echo $cart['product']['package'];} else {echo 1;} ?>" value="<?php if(!empty($cart['product']['package']) and $cart['product']['package'] > 0) { echo $cart['product']['package'];} else {echo 1;} ?>" step="<?php if(!empty($cart['product']['package']) and $cart['product']['package'] > 0) { echo $cart['product']['package'];} else {echo 1;} ?>">
                                    <?php else: ?>
                                    <input type="number" min="1" class="count" name="num<?php echo $cart['id']?>" id="count-<?php echo $cart['id']?>" value="<?php echo $cart['num'];?>">
                                    <?php endif ?>
                                </span>

        </td>
		<td class="price">
			<span class="price">
        <input type="text" class="sum" currency="<?php echo $cart['currency']['code']?>" id="sum-<?php echo $cart['id']?>" readonly value="<?php echo $cart['sum'];?>">
        <span class="currency"><?php echo $cart['currency']['name']?></span>
      </span>
		</td>
		<td>
		   	<div class="x"><a href="#" class="remove" id="<?php echo $cart['id']?>" name="<?php echo $cart['product']['name']?>"><img src="/images/i_close.png"></a></div>
		</td>
		</tr>

<?php
		}
	}


if(isset($vars['cart'])){
	?>
	<tr class="itogo">
		<th colspan="2"><button class="smallsubmit btn" type="button"><?php echo $this->t('shop', 'Recalc') ?></button></th>
		<th colspan="5">
			<table class="markup">
			<tr><td>
				<span class="price"><?php echo $this->t('shop', 'Total') ?>:</span>
			</td><td>
				<span class="sum">
				<?php
				foreach($vars['small_cart'] as $small_cart){

					echo "<span class=\"price sum\"><span id=\"sum_". $small_cart['currency']['code']."\">".$small_cart['sum']."</span> ".$small_cart['currency']['name']."</span>";
				}
				?></span>
			</td></tr>
			<tr><td>
				<span class="price"><?php echo $this->t('shop', 'Delivery') ?>:</span>
			</td><td>
				<span class="delivery">0</span>
			</td></tr>
			<tr><td>
				<span class="price"><?php echo $this->t('shop', 'Total with delivery') ?>:</span>
			</td><td>
				<span class="delivery_sum">0</span>
			</td></tr>
			</table>
		</th></tr>
</table>
<div class="btn-block right">

</div>

  <?php
  if($_SESSION[id]){ // зарегистрированный пользователь
    $this->template("shop/delivery_form.php", $vars);

    	//if($_SESSION['lang'] == "ru"){
    	if($small_cart['currency']['code'] == "RUR"){
     		$this->template("shop/payment_form.php", $vars);
    	}
  ?>

  <div class="btn-block right">
  <!-- button class="update btn" type="button"><?php echo $this->t('shop', 'Recalc') ?></button -->
  <button type="submit" class="checkout btn btn-success btn-large"><?php echo $this->t('shop', 'Send Order') ?></button>
  </div>

  <?php
  } else { // незарегистрированный пользователь
  ?>

  <div class="btn-block right">
  <!-- button class="update btn" type="button"><?php echo $this->t('shop', 'Recalc') ?></button -->
  <button type="button" class="btn open_popup btn-success btn-large"><?php echo $this->t('shop', 'Send Order') ?></button>
  </div>

  <?php
  }
}
?>

</form>

    <script type="text/javascript">
    	$('.remove').bind('click', function() {
        	var id=$(this).attr("id");
        	var name=$(this).attr("name");
    		$("#dialog").dialog({
    			bgiframe: false,
    			resizable: false,
    			height:140,
    			modal: true,
    			closeOnEscape: true,
    			overlay: {
    				backgroundColor: '#000',
    				opacity: 0.5
    			},
    			buttons: {
    				'Remove': function() {
    					$(this).dialog('destroy');
    					//window.location = '/shop/cart_delete/'+id;

    					var $divid=$(".cart_"+id);
    					$divid.removeClass("item");
    					$divid.load("/shop/cart_delete/"+id,
    			    				function(responseText, textStatus, XMLHttpRequest){
    							//readyfunction();
    							var tr = $("tr."+id);
    							var shop_id = $("#shop_id").attr("value");
    							if(tr.parent().children().length < 4){
    							    window.location = '/shop/cart/'+shop_id;
    							}
    							tr.remove();
    						});
    				},
    				Cancel: function() {
    					$(this).dialog('destroy');
    				}
    			},
    			open:function(){
    				$("#dialog").find(".question").html("<?php echo $this->t('shop', 'remove_from_cart_request'); ?>");
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="<?php echo $this->t('shop', 'Remove from cart?'); ?>" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
<script>

	$('button.update').click(function(){
		var id=$("input#shop_id").attr("value");
		$("form#cart").attr("action", "/shop/cart_update/"+id);
		$("form#cart").submit();
	});

	$('#cart submit').click(function(){
	    $(".checkout").attr("disabled", "disabled");
	});


	$(".count").change(function(e){
		var regex = /count-(\d+)/;
		var id=regex.exec($(this).attr("id"));
		var count=$(this).val();
		id=id[1];
		var price=$("#price-"+id).text();
		$("#sum-"+id).val(price*count);

		var sum = {};
		//пересчет с учетом валют
		$("input.sum").each(function(e){
			var cur = $(this).attr("currency");
			console.log(cur);
			if(!sum.hasOwnProperty(cur)){ sum[cur] = 0; }
			console.log(parseInt($(this).val()));

			sum[cur] = sum[cur] + parseInt($(this).val());
			console.log(sum[cur]);
		});

		for(var cur in sum){
			$("#sum_"+cur).html(sum[cur]);
		}

	});


</script>
