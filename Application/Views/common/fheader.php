<!DOCTYPE html>
<html>
<head>
<title>Comiron</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/container.css" rel="stylesheet" type="text/css">
<link href="/css/style.css" rel="stylesheet" type="text/css">
<!--link type="text/css" href="/css/jquery.css?v=5" rel="stylesheet" /-->
<link type="text/css" href="/css/ui/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
<script src="<?php echo PartuzaConfig::get('gadget_server')?>/gadgets/js/rpc.js?c=1"></script>
<script src="/gadgets/files/container/osapi.js"></script>
<!--  the below was concated and compressed with yuicompressor using: java -jar {$path}/yuicompressor-2.3.5.jar -o {$file}-min.js {$file}.js -->
<!--  script type="text/javascript" src="/js/jquery-1.3.js"></script-->
<!--  script src="/js/jquery.ui.all.js"></script-->
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/js/jquery.class.js"></script>
<script src="/js/jquery.json-1.3.js"></script>
<script src="/js/jquery-ui-1.8.21.custom.min.js"></script>
<script src="/js/container.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/jquery.checkbox.js"></script>
<script src="/js/scrollto.js"></script>
<script src="/js/reject/jquery.reject.js"></script> 
<script src="/js/jquery.nicescroll.js"></script>
<script src="/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<script src="/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/uploadifive.css">

		<link href="/uberuploadcropper/css/default.css" rel="stylesheet" type="text/css"/>
		<link href="/uberuploadcropper/css/uploadify.css" rel="stylesheet" type="text/css"/>
		<link href="/uberuploadcropper/scripts/Jcrop/css/jquery.Jcrop.css" rel="stylesheet" type="text/css"/>
		<script src="/uberuploadcropper/scripts/swfobject.js"></script>
		<script src="/uberuploadcropper/scripts/jquery.uploadify.v2.1.0.min.js"></script>
		<script src="/uberuploadcropper/scripts/jquery-impromptu.3.1.min.js"></script>
		<script src="/uberuploadcropper/scripts/Jcrop/js/jquery.Jcrop.min.js"></script>
		<script src="/uberuploadcropper/scripts/jquery-uberuploadcropper.js"></script>
		
 
<script src="/js/i18n/ru/main-ui.js"></script>
<script src="/js/i18n/ru/jquery.ui.datepicker-ru.js"></script>
<!-- script src="/js/i18n/jquery-ui-i18n.js"></script-->
<script src="/js/jquery.project.js"></script>
<link rel="openid2.provider openid.server" href="<?php echo PartuzaConfig::get('gadget_server')?>/openid/auth">
<meta http-equiv="X-XRDS-Location" content="<?php echo PartuzaConfig::get('gadget_server')?>/xrds" />

<link type="text/css" href="/css/start.css" rel="stylesheet" />

<?php 
if(isset($_SESSION['lang'])){ ?>
<script src="/js/i18n/<?php echo $_SESSION['lang']?>/main-ui.js"></script>
<?php } ?>
<script src="/js/jquery.project.js"></script>
<link rel="openid2.provider openid.server" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/openid/auth">
<?php if($this instanceof profileController) { ?>
<meta http-equiv="X-XRDS-Location" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/openidxrds" />
<?php } else { ?>
<meta http-equiv="X-XRDS-Location" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/xrds" />
<?php } ?>

</head>
<body id="first">

<div class="row-fluid"><div class="span12">

<div id="headerDiv">
<table class="markup w100"><tr>
<td class="logo"><span id="headerLogo"><a href="/home"><img src="/images/comiron_logo.png" alt="Comiron"></a> </span></td>
<?php
if (!isset($_SESSION['id'])) {
?>
	<td width="593"><div class="headernav">
		<a class="central menu<?php if (isset($vars['is_central'])) { echo " on"; }?>" temphref="/profile/central" href="/central"><img src="/images/i_central<?php  if (isset($vars['is_central']))  { echo "_on"; }?>.png" alt="<?php echo $this->t('common','central'); ?>" title="<?php echo $this->t('common','central'); ?>" ></a>
	</div></td>
	
<?php 
}
?>
<td class="register"><a href="#" class="green-button" id="reg"><?php echo $this->t('home','Register');?></a></td>
</tr></table></div>

</div></div>