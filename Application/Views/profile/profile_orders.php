<?php
if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/header.php', $vars);
?>

<div id="profileInfo" class="blue">
<?php $this->template('profile/profile_info.php', $vars); ?>
</div>
<div id="profileRight" class="blue">
<?php $this->template('common/right.php', $vars);?>
</div>

<div id="profileContentWide">

	<?php $this->template('profile/topheader.php', $vars); ?>
	<div class="header"><?php echo $this->t('shop','Orders'); ?></div>

	<?php
    if(isset($_GET['sb_fail'])){
	echo "<div class=\"error\">".$this->t('shop', 'sb_fail')."</div>";
    }
}
?>

<div class="topinfo">
<form id="searchorder"  class="filter" action="/profile/orders/<?php echo $vars['person']['id']; ?>" method="post">


<table class="markup"><tbody>
<tr><td><span class="filter2"><?php echo $this->t('common', 'datefilter'); ?></span></td></tr>
<tr>
<td>
<label><?php echo $this->t('common', 'fromdate'); ?></label>
&nbsp;
<input type="text" name="fromdate" id="fromdate" style="width:100px" >
&nbsp;
<label><?php echo $this->t('common', 'todate'); ?></label>
&nbsp;
<input type="text" name="todate" id="todate" style="width:100px" >
</td>
</tr><tr>
<td>
<select id="shop_id" name="shop_id">
<option value=""><?php echo $this->t('shop', 'all shops'); ?></option>
<?php
foreach ($vars['shops'] as $shop) {
echo "<option value=\"{$shop['id']}\"";
if(isset($vars['searchorder']['shop_id']) and $shop['id']==$vars['searchorder']['shop_id']){
echo " selected ";
}
echo ">{$shop['name']}</option>";
}
?>

</select>
</td><td>&nbsp;</td><td>
<select id="orderstatus_id" name="orderstatus_id">
<option value=""><?php echo $this->t('shop', 'all statuses'); ?></option>
<option value="1_2" <?php 
if(isset($vars['searchorder']['orderstatus_id']) and "1_2"==$vars['searchorder']['orderstatus_id']){
	echo " selected ";
	}
	
?>><?php echo $this->t('shop', 'order_status_new_inprocess'); ?></option>
<?php
foreach ($vars['orderstatuses'] as $status) {
echo "<option value=\"{$status['id']}\"";
if(isset($vars['searchorder']['orderstatus_id']) and $status['id']==$vars['searchorder']['orderstatus_id']){
echo " selected ";
}
echo ">".$this->t('shop',$status['name'])."</option>";
}
?>
<option value="isuserarchive"><?php echo $this->t('shop', 'Archive'); ?></option>

</select>

</td><td>
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
$this->template('profile/order_index.php', $vars);
?>
</div>




<?php 

if(!(isset($_GET['style']) and $_GET['style']=='ajax')){
	$this->template('/common/footer.php'); 
}?>