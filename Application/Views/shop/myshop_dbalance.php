<?php
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
<?php $this->template('shop/topheader.php', $vars); ?>

<div class="header"><?php echo $this->t('shop', 'delivery_balance')?></div>
		
	<div class="body usergroups">		
	
    <table class="orderdetails">
    <tr>
        <th>ID</th>
        <th><?php echo $this->t('common', 'date'); ?></th>
        <th><?php echo $this->t('shop', 'Operation'); ?></th>
        <th><?php echo $this->t('shop', 'moneyin'); ?></th>
        <th><?php echo $this->t('shop', 'moneyout'); ?></th>
        <th><?php echo $this->t('shop', 'balance'); ?></th> 
    </tr>
<?php
if(isset($vars['dbalance'])){
    foreach ($vars['dbalance'] as $balance) {
            echo "<tr><td>".$balance['id'];
            echo "</td><td>".$balance['date'];
            echo "</td><td>".$balance['txt'];
            echo "</td><td>".$balance['moneyin'];
            echo "</td><td>".$balance['moneyout'];
            echo "</td><td>".$balance['balance'];
            echo "</td></tr>";
    }
}
?>
    </table>
	</div>
    
	
  <div style="clear: both"></div>
</div>
<?php 	$this->template('/common/footer.php'); ?>