<!-- div class="topheader">
<?php
echo $vars['person']['first_name'] . " " . $vars['person']['last_name'];

if($vars['person']['isonline']){
	echo "<div class='toponline'>Online</div>";
}

echo "<div class=\"subheader\">";

if(!isset($vars['subtitle'])){
	echo $vars['person']['city'];
}else{
	echo $vars['subtitle'];
}
?>
</div>
</div-->
 