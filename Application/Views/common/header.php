<!DOCTYPE html><html id="inside">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=1000">


<link href="/css/slick.css" rel="stylesheet" type="text/css">

<link type="text/css" href="/css/ui/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script src="<?php echo PartuzaConfig::get('gadget_server')?>/gadgets/js/rpc.js?c=1"></script>
<script src="/gadgets/files/container/osapi.js"></script>

<script src="/js/jquery-1.7.2.min.js"></script>

<script src="/js/jquery.class.js"></script>
<script src="/js/jquery.json-1.3.js"></script>
<script src="/js/jquery-ui-1.8.21.custom.min.js"></script>
<script src="/js/container.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/jquery.checkbox.js"></script>
<script src="/js/jquery.scrollTo-1.4.3.1.js "></script>
<script src="/js/jquery.getimagesize.js "></script>
<!--script src="/js/reject/jquery.reject.js"></script-->
<script src="/js/jquery.nicescroll.js"></script>

<script src="/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5.css" media="screen" />

<script src="/js/jquery.uploadifive.min.js"></script>

		<link rel="stylesheet" type="text/css" href="/css/uploadifive.css">
		<link href="/uberuploadcropper/css/default.css" rel="stylesheet" type="text/css"/>
		<link href="/uberuploadcropper/scripts/jQuery-Impromptu/jquery-impromptu.css" rel="stylesheet" type="text/css" />
		
		<link href="/uberuploadcropper/scripts/Jcrop/css/jquery.Jcrop.css" rel="stylesheet" type="text/css"/>
		<script src="/uberuploadcropper/scripts/jquery.uploadify.v2.1.0.min.js"></script>
		<script src="/uberuploadcropper/scripts/jquery-impromptu.3.1.min.js"></script>
		<script src="/uberuploadcropper/scripts/Jcrop/js/jquery.Jcrop.js"></script>
		<script src="/uberuploadcropper/scripts/jquery-uberuploadcropper.js"></script>

<!--script type="text/javascript" src="/js/multiselect/plugins/scrollTo/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="/js/multiselect/ui.multiselect.js"></script-->
<script type="text/javascript" src="/js/jquery.multiselect.js"></script>
<script type="text/javascript" src="/js/jquery.multiselect.filter.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.multiselect.css">
<link rel="stylesheet" type="text/css" href="/css/jquery.multiselect.filter.css">

<script src="/js/websocket/websocket.js"></script>
<script src="/js/im.js"></script>
<link rel="stylesheet" href="/js/redactor/redactor.css" />
<script src="/js/redactor/redactor.js"></script>
<script src="/js/redactor/plugins/plaintext/plaintext.js"></script>
<?php 
if(isset($_SESSION['lang'])){ ?>
<script src="/js/redactor/lang/<?php echo $_SESSION['lang']?>.js"></script>
<?php }?>

<script src="/js/tinymce/tinymce.min.js"></script>
<script src="/js/tinymce/jquery.tinymce.min.js"></script>
<?php 
if(isset($_SESSION['lang'])){ ?>
<script src="/js/tinymce/langs/<?php echo $_SESSION['lang']?>.js"></script>
<?php }?>

<style type="text/css" media="all">
@import url(/highslide/highslide.css);
</style>
<script type="text/javascript" src="/highslide/highslide.js"></script>

<script src="/js/slick.min.js"></script>

<title>Comiron</title>
<!-- script src="/js/i18n/jquery-ui-i18n.js"></script-->
<!--  <?php echo $_SESSION['lang']?> -->
<?php 
if(isset($_SESSION['lang'])){ ?>
<script src="/js/i18n/<?php echo $_SESSION['lang']?>/main-ui.js"></script>
<script src="/js/i18n/<?php echo $_SESSION['lang']?>/jquery.ui.datepicker-<?php echo $_SESSION['lang']?>.js"></script>
<?php } ?>
<script src="/js/jquery.project.js"></script>
<link rel="openid2.provider openid.server" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/openid/auth">
<?php if($this instanceof profileController) { ?>
<meta http-equiv="X-XRDS-Location" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/openidxrds" >
<?php } else { ?>
<meta http-equiv="X-XRDS-Location" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/xrds">
<?php } ?>

	<!-- link rel="stylesheet/less" type="text/css" href="/bootstrap/less/bootstrap.less"-->
	<link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
	<!-- link rel="stylesheet/less" type="text/css" href="/css/style.less"-->
	<link rel="stylesheet" type="text/css" href="/css/style.css">
  <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
  <link href="/css/start.css" rel="stylesheet" type="text/css">

</head>

<body <?php if(isset($vars['shop']['bgstyle']) and $vars['shop']['bgstyle']){ 
		echo "class=\"{$vars['shop']['bgstyle']}\"";
	}else if(isset($vars['shop']['bgimg']) and $vars['shop']['bgimg']){
		echo "style=\"background-image: url('{$vars['shop']['bgimg']}')\"";
	} ?>>
<?php if(isset($_SESSION['id']) and isset($vars['person']['id']) and  $_SESSION['id']==$vars['person']['id'] and isset($vars['person']['is_activated']) and $vars['person']['is_activated']==0){
	echo "<div class=\"supernotification\">{$this->t('common','is_not_activated')}</div>";
} ?>

<div id="headerDiv">

<div class="center">
<table class="markup"><tr><td class="logo">
<span id="headerLogo"><a href="/home"><img src="/css/images/comiron_logo.png" alt="Comiron"></a> </span>
</td>
<?php
if (!isset($_SESSION['id'])) {
?>
	<td width="593"><div class="headernav">
		<a class="central menu<?php if (isset($vars['is_central'])) { echo " on"; }?>" href="http://comiron.com"><?php echo $this->t('common','products and shops'); ?></a>
	</div></td>
	
<?php 
  echo '<td class="register"><a href="#" class="green-button open_popup" id="reg">'.$this->t('home','Register').'</a></td>';
  echo '<td class="register"><a href="#" class="green-button open_login" id="reg">'.$this->t('home','Login').'</a></td>';
}
if (isset($_SESSION['username'])) {
?>
<td class="headernav"><div class="headernav">
	<a class="myprofile menu<?php if (isset($vars['is_owner']) and !isset($vars['shop']['is_owner'])) { echo " on"; }?>" href="/home"  alt="<?php echo $this->t('common','my_profile'); ?>" title="<?php echo $this->t('common','my_profile'); ?>" ><?php echo $this->t('common','my_profile'); ?></a>
	<a class="myoffice menu<?php if (isset($vars['shop']['is_owner']) and !isset($vars['is_central'])) { echo " on"; }?>" temphref="/profile/myshop" href="/shop/myshop"><?php echo $this->t('common','my_office'); ?></a>
	<a class="central menu<?php if (isset($vars['is_central'])) { echo " on"; }?>" temphref="/profile/central" href="http://comiron.com"><?php echo $this->t('common','products and shops'); ?></a>
</div></td>
<!--td class="more" style="width:100px;">
<div class="btn-group">

    <button class="btn dropdown-toggle" data-toggle="dropdown">
      
      <?php echo $this->t('common','More'); ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
      ...
    </ul>
  </div>
</td-->  
<td class="search">
<div id="searchDiv">
<form method="get" id="searchform" action="/search">
<div class="input-append">
  <input type="hidden" name="for" id="for">
  <input type="text" id="search_q" name="q" placeholder="<?php echo $this->t('common','search'); ?>">
  <div class="btn-group">
    <button class="btn dropdown-toggle"   data-toggle="dropdown">
		<?php echo $this->t('common','to_search'); ?>
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" id="search_for">
    	<li><a href="#" id="people" value="people"><?php echo $this->t('common','people'); ?></a></li>
		<li><a href="#" id="organization" value="organization"><?php echo $this->t('common','organizations'); ?></a></li>
		<li><a href="#" id="product" value="product"><?php echo $this->t('common','products'); ?></a></li>
		<li><a href="#" id="news" value="news"><?php echo $this->t('common','news'); ?></a></li>
    </ul>
  </div>
</div>
</form>
</div>
</td>
<td class="logout">
	<a href="/logout"><?php echo $this->t('common','logout'); ?></a>
</td>

</tr></table></td>
<?php
}
?>
</tr></table></div></div>
<div id="contentDiv" <?php if (isset($vars['is_central'])){ echo " class=\"iscentral\"";}else{ echo " class=\"isnotcentral\"";} ?>>
