<?php
if(isset($_SESSION['id'])){
		//echo "<div class=\"icons\">";
		echo "<a href=\"#\" object_id=\"{$vars['object_id']}\" object_name=\"{$vars['object_name']}\" class=\"like\">";
		if(!$vars['is_small']){
//if($vars['liked']>0){
      //echo $this->t('common', 'unlike');
//}else if($vars['liked']<0){
    	  	echo $this->t('common', 'like');
//}	
		}
		echo " <span class=\"num\">{$vars['likes_num']}</span></a>";
}
?>