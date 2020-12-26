
<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);

?>

<div id="profileInfo">
<?php
$this->template('shop/myshop_info.php', $vars);
?>
</div>
<div id="profileRight">
<?php
$this->template('shop/myshop_right.php', $vars);
?>
</div>
<div id="profileContentWide">

<?php 	$this->template('shop/shop_center.php', $vars); ?>
<div class="header"><?php echo $this->t('shop', 'Products')?></div>
<div class="products">

		<div class="body">		
		<a class="funbutton productCompose" id="<?php echo $vars['shop']['id']?>"><?php echo $this->t('shop', 'Add product')?></a>
		<div class="links">
		<a href="/shop/mygroups/<?php echo $vars['shop']['id']; ?>"><?php echo $this->t('shop', 'Manage groups')?></a>
		<a href="/shop/import/<?php echo $vars['shop']['id']; ?>"><?php echo $this->t('shop', 'Import Products')?></a>
		<a class="right" href="javascript:if (confirm('Удалить?')){ window.location='/shop/removeallproducts/<?php echo $vars['shop']['id']; ?>';}"><?php echo $this->t('shop', 'Remove Products and Groups')?></a>	
		</div>

<!--div class="filter">		
<form id="searchproduct" action="/shop/searchmyproduct/" method="get">
			<input type="hidden" name="shop_id" value="<?php echo $vars['shop']['id']; ?>">

<table class="markup"><tr><td>
<input type="text" id="product_name" placeholder="<?php echo $this->t('shop', 'Product search'); ?>" name="name" value="<?php if(isset($vars['searchproduct']['name'])) echo $vars['searchproduct']['name']; ?>">
</td><td>
<select name="group_id" id="group_id">
      	<option value="0"><?php echo $this->t('common', 'all') ?></option>
<?php 
	if(isset($vars['groups'])){
		foreach ($vars['groups'] as $group) {
			echo "<option ".((isset($vars['searchproduct']['group_id']) and $group['id']==$vars['searchproduct']['group_id'])?" selected ":"")." value=\"{$group['id']}\">{$group['name']}</option>";
			
			if(isset($group['subs'])){
				foreach($group['subs'] as $subgroup){
					echo "<option ".((isset($vars['searchproduct']['group_id']) and $group['id']==$vars['searchproduct']['group_id'])?" selected ":"")." value=\"{$subgroup['id']}\">&nbsp;&nbsp;&nbsp;{$subgroup['name']}</option>";
				}
			}			
		}
	}      		
?>		
</select>
</td><td>
<button type="submit" class="btn search" id="search_small"><?php echo $this->t('common', 'find'); ?></button>
</td></tr></table>
</form>
</div-->
		
		
<?php 		

	/*	echo "<div id=\"product_compose_dialog\" style=\"display:none;\">";
		$this->template('shop/product_compose.php', $vars);
		echo "</div>";*/
?>		
<form id="productform" action="/shop/product_deleteselected/<?php echo $vars['shop']['id']; ?>" method="post">

<div class="deleteall">
<input type="checkbox" name="selectall" id="selectall"><label><?php echo $this->t("common", "select all") ?></label>
<button type="submit" class="btn submit disabled" id="delete_selected"><?php echo $this->t('common', 'delete selected') ?></button>
<button type="button" class="btn submit disabled multiedit" id="<?php echo $vars['shop']['id']; ?>"><?php echo $this->t('common', 'edit selected') ?></button>
</div>
		
<?php
}// if !ajax

	if(isset($vars['products'])){
		foreach ($vars['products'] as $product) {
        	echo "<div class=\"item product\" id=\"{$product['id']}\">";
       		echo "<div class=\"x\"><a href=\"#\" class=\"remove\" id=\"{$product['id']}\" name=\"{$product['name']}\"><img src=\"/images/i_close.png\"></a></div>";
        	echo "<table class=\"markup\"><tr><td><input type=\"checkbox\" class=\"s\" name=\"todel[]\" value=\"{$product['id']}\" id=\"ch-{$product['id']}\"></td><td class=\"photo\"><div class=\"photo\"><a href=\"/shop/product/{$product['id']}\">";
    
    		if($product['thumbnail_url']){
    			echo "<img src=\"{$product['thumbnail_url']}\">";
    		}else{
    			echo "<img src=\"/images/product/nophoto.gif\">";
    		}
    		
			echo "</a></div></td><td>";
			echo "<div class=\"title\"><a href=\"/shop/product/{$product['id']}\">{$product['name']}</a></div>";
			
			echo "<div>".$this->t('shop', 'Price').": <span class=\"price\">{$product['realprice']}</span> {$product['currency']['name']}";
			if(isset($product['discount']) and $product['discount']>0){
				echo ", -".$product['discount']."%";
			}
			echo "</div>";
			if(isset($product['groups']) and count($product['groups'])){
				echo "<div>".$this->t('shop', 'Groups').": ";
				foreach ($product['groups'] as $group) {
					echo "<span class=\"group\"><a href=\"/shop/group/{$group['id']}\">{$group['name']}</a></span> ";
				}
				echo "</div>";
			}
			if(isset($product['categories']) and count($product['categories'])){
				echo "<div>".$this->t('shop', 'Categories').": ";
				foreach ($product['categories'] as $category) {
					echo "<span class=\"group\"><a href=\"/central/category/{$category['id']}\">{$category['name']}</a></span>&nbsp;";
				}
				echo "</div>";
			}
			echo "<div class=\"icons\"><a class=\"edit editproduct\" id=\"{$product['id']}\" href=\"#\">".$this->t('common', 'edit')."</a></div>";
    		echo "</td></tr></table></div>";
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
	echo "<a class=\"load\" href=\"/shop/myproducts/{$vars['shop']['id']}?curpage={$vars['nextpage']}\" rel=\"noindex\" class=\"p\" id=\"next\"><span class=\"down\"></span>Показать еще</a>";
}
?>
</span>
<?php
if(isset($vars['totalpages']) and $vars['totalpages']>0){
	echo "<div id=\"totalpages\" content-id=\"productform\">{$vars['totalpages']}</div>";
}
?>
</div>

    <script>
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
    					window.location = "/shop/product_delete/"+id;
    				},
    				Cancel: function() {
    					$(this).dialog('destroy');
    				}
    			},
    			open:function(){
    				$("#dialog").find(".question").html("<?php echo $this->t('shop','remove_product_request');?>");
        		}
    		});
    		return false;
    	});
    </script>
    <div id="dialog" title="Remove product?" style="display:none">
    	<p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
    </div>
    <div id="dialog_edit_product"></div>
    <div style="clear: both"></div>
    </div>

  <div style="clear: both"></div>
</div>
</div>
</div>

</form>

<?php

	$this->template('/common/footer.php'); 
} // if !ajax
?>