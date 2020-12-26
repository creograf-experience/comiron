<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);
?>

<div id="profileInfo" class="blue">
<?php $this->template('shop/myshop_info.php', $vars); ?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('shop/myshop_right.php', $vars);?>
</div>

<div id="profileContentWide">

	<?php $this->template('shop/topheader.php', $vars); ?>
	<div class="header"><?php echo $this->t('shop','Orders'); ?></div>

	<?php
}
?>

<div class="topinfo">
<form id="searchorder" class="filter" action="/shop/orders/<?php echo $vars['shop']['id']; ?>" method="post">


<table class="markup"><tbody><tr><td>
	<label><?php echo $this->t('common', 'fromdate'); ?></label>
</td><td>
	<input type="text" name="fromdate" id="fromdate" style="width:100px" >
</td><td>
	<label><?php echo $this->t('common', 'todate'); ?></label>
</td><td>
	<input type="text" name="todate" id="todate" style="width:100px" >
</td><td>&nbsp;</td><td>
    <select id="orderstatus_id" name="orderstatus_id">
    	<option value=""><?php echo $this->t('common', 'all'); ?></option>
  		<?php 
  			foreach ($vars['orderstatuses'] as $status) {
				echo "<option value=\"{$status['id']}\"";
				if(isset($vars['searchorder']['orderstatus_id']) and $status['id']==$vars['searchorder']['orderstatus_id']){
					echo " selected ";
				}
				echo ">".$this->t('shop',$status['name'])."</option>";
			}
		?>
  	</select>
</td><td>&nbsp;</td><td>
	<button type="submit" class="btn submit search" id="search_small"><?php echo $this->t('common', 'find'); ?></button>
</td></tr></tbody></table>
</form>

<script>
$(document).ready(function() {

	$("#fromdate").datepicker().datepicker( "option", {
		"dateFormat": "dd.mm.yy",
		"changeYear":true,
		"changeMonth":true
	//,"yearRange": "2014:2010" 
	});
	<?php
	if(isset($vars['searchorder']['fromdate']) and is_numeric($vars['searchorder']['fromdate'])){
		$fromdate_month = date('n', $vars['searchorder']['fromdate']);
		$fromdate_day = date('j', $vars['searchorder']['fromdate']);
		$fromdate_year = date('Y', $vars['searchorder']['fromdate']);
		?>
		var d="<?php echo $fromdate_day.".".$fromdate_month.".".$fromdate_year ?>";
		dateParts = d.match(/(\d+)/g);
		realDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
		$("#fromdate").datepicker( "setDate", new Date(realDate)); 
	<?php
	} 
	?>


	$("#todate").datepicker().datepicker( "option", {
		"dateFormat": "dd.mm.yy",
		"changeYear":true,
		"changeMonth":true
	//,"yearRange": "2014:2010" 
	});
	<?php
	if(isset($vars['searchorder']['todate']) and is_numeric($vars['searchorder']['todate'])){
		$todate_month = date('n', $vars['searchorder']['todate']);
		$todate_day = date('j', $vars['searchorder']['todate']);
		$todate_year = date('Y', $vars['searchorder']['todate']);
		?>
		var d="<?php echo $todate_day.".".$todate_month.".".$todate_year ?>";
		dateParts = d.match(/(\d+)/g);
		realDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
		$("#todate").datepicker( "setDate", new Date(realDate)); 
	<?php
	} 
	?>
		
});
</script>

</div>


<?php 
$this->template('shop/order_index.php', $vars);
?>
</div>

<?php 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/footer.php'); 
}?>