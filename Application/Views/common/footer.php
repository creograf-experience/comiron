<div style="clear:both;"></div>
</div>
<div id="toTop">&uarr;</div>
 <div id="footerDiv"><div class="center">
  <div id="footerup"></div>
  <div id="footerdown"></div>
   <ul>
   <li class="comiron">Comiron, &copy; 2012-<?php echo date('Y') ?></li>
   <li><a href="#"><?php echo $this->t('common','terms'); ?></a></li>
   <li><a href="#"><?php echo $this->t('common','advertising'); ?></a></li>
   <li><a href="#"><?php echo $this->t('common','privacy'); ?></a></li>
      <li>   <?php echo $this->t('common','uilanguage').":"; ?>
    </li><li class="value">
   		<div class="choose">
   <?php if($_SESSION['lang']){
   		 echo  "<a href=\"/profile/lang/".$_SESSION['lang']."\" title=\"".$this->t('common','set_'.mb_strtoupper($_SESSION['lang']))."\">". $this->t('common','set_'.mb_strtoupper($_SESSION['lang']))."</a><br>";
    } ?>
   <?php if($_SESSION['lang'] != "en"){?>		
   <a href="/profile/lang/en" title="<?php echo $this->t('common','set_EN'); ?>"><?php echo $this->t('common','set_EN'); ?></a><br>
   <?php }if($_SESSION['lang'] != "ru"){?>
   <a href="/profile/lang/ru" title="<?php echo $this->t('common','set_RU'); ?>"><?php echo $this->t('common','set_RU'); ?></a><br>
   <?php }if($_SESSION['lang'] != "ch"){?>
   <a href="/profile/lang/ch" title="<?php echo $this->t('common','set_CH'); ?>"><?php echo $this->t('common','set_CH'); ?></a><br>
   <?php }if($_SESSION['lang'] != "it"){?>
   <a href="/profile/lang/it" title="<?php echo $this->t('common','set_IT'); ?>"><?php echo $this->t('common','set_IT'); ?></a><br>
   <?php }if($_SESSION['lang'] != "es"){?>
   <a href="/profile/lang/es" title="<?php echo $this->t('common','set_ES'); ?>"><?php echo $this->t('common','set_ES'); ?></a>
   <?php }?>
   </div>
   </li>
   <li><?php    echo $this->t('common','country_content').":"; ?></li>
      <li class="value">
   		<div class="choose">
   		   <?php 
   $country_content=$this->model('country_content');
   $countries=$country_content->get_countries($this->get_cur_lang());

   foreach($countries as $country){
	echo "<a href=\"/profile/country_content/{$country['code2']}\" title=\"{$country['name']}\" ";
	if($country['is_current']){
		echo "class=\"is_current\"";
	}
	echo " >{$country['name']}</a><br>\n";
   }
   ?>
   		
		</div>
   </li>
     <li><?php    echo $this->t('common','currency').":"; ?></li>
   <li class="value">
   		<div class="choose">
   		
   <?php
   if($_SESSION['cur']){
   		echo   "<a href=\"/profile/cur/".$_SESSION['cur']."\" title=\"". $this->t('common','set_'.$_SESSION['cur'])."\">". $this->t('common','set_'.$_SESSION['cur'])."</a><br>";
   }if($_SESSION['cur'] != 1){?>
   <a href="/profile/cur/1" title="<?php echo $this->t('common','set_1'); ?>"><?php echo $this->t('common','set_1'); ?></a><br>
   <?php }if($_SESSION['cur'] != 2){?>
   <a href="/profile/cur/2" title="<?php echo $this->t('common','set_2'); ?>"><?php echo $this->t('common','set_2'); ?></a><br>
   <?php }if($_SESSION['cur'] != 3){?>
   <a href="/profile/cur/3" title="<?php echo $this->t('common','set_3'); ?>"><?php echo $this->t('common','set_3'); ?></a><br>
   <?php }if($_SESSION['cur'] != 4){?>
   <a href="/profile/cur/4" title="<?php echo $this->t('common','set_4'); ?>"><?php echo $this->t('common','set_4'); ?></a>
   <?php }?>
   </div>
   </li>
   </ul>
  </div></div>
</div>
<!--div id="bigphoto"></div-->
<div id="ajax-loader"></div>
<div id="message_compose_dialog"></div>
<div id="dialog_news"></div>
<div id="dialog_comment_remove" title="<?php $this->t('common','Remove your comment?')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>
<div id="dialog_attachphoto" title="<?php $this->t('common','attachphoto_title')?>" style="display:none"></div>
<div id="comment_compose_dialog" style="display:none;"></div>
<div id="dialog_news_remove" title="<?php $this->t('common','confirm_remove_news_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>
<div id="dialog_message_remove" title="<?php $this->t('common','confirm_remove_message_title')?>" style="display:none"><p class="question"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p></div>

<div id="toTop2">&uarr;</div>

<script type="text/javascript" src="/js/photos.js"></script>
<div style="display:none;"><?php echo PartuzaConfig::get('counters'); /* $this->template('common/counter.php', $vars);*/ ?></div>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/js/less.min.js" type="text/javascript"></script>

<?php if(!$_SESSION['id']){ ?>
<?php $this->template('home/popups.php', $vars); ?>
<script src="/js/jquery.inputmask.js"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/home_scripts.js"></script>
<?php  } ?>

</body>
</html>
