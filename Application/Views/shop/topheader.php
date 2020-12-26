<div class="topheader">
<?php
echo $vars['shop']['name'];
if ($vars['shop']['is_owner']) {
echo "<div style=\"margin-right:0px; float:right; margin-top: -2px;\"><a class=\"btn editshop btn-small\" href=\"/shop/myshop\" title=\"".$this->t('shop','Edit your shop')."\"><!--span class=\"ui-icon ui-icon-pencil\"></span-->".$this->t("shop", "Edit your shop")."</a></div>";
}
?>
</div>
 