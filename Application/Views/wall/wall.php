<?php
echo "<a href=\"#\" object_id=\"{$vars['object_id']}\" object_name=\"{$vars['object_name']}\" class=\"share\">";
	if(!$vars['is_small']){
//if($vars['liked']>0){
      //echo $this->t('common', 'unlike');
//}else if($vars['liked']<0){
      echo $this->t('common', 'share');
//}
	}
echo " <span class=\"num\">{$vars['shares_num']}</span></a>";
?>