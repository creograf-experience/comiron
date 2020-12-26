<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta id="viewport" name="viewport" content="width=1020">
	<title>Comiron - <?php echo $this->t('home','Meta_title')?></title>
	<link rel="icon" href="css/images/favicon.ico" type="image/x-icon" />
	<style>@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700&subset=cyrillic,latin);</style>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.slick/1.3.7/slick.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
	
	<link rel="stylesheet" href="/css/start.css">
</head>
<body class="start">
	<header>
		<div class="container">
		  <div class="logo"><?php echo $this->t('home','Meta_title')?></div>
		  <!--a href="/central" class="button open_popup1"><?php echo $this->t('home','to products'); ?></a-->
		  <nav>
		  	<ul>
		  		<li><a href="#" class="open_login button"><i class="fa fa-sign-in"></i> <?php echo $this->t('home','Login')?></a></li>
		  		<li><a href="#" class="open_popup button"><i class="fa fa-check-square"></i> <?php echo $this->t('home','Register')?></a></li>
		  		<li><a href="/page/get/contacts" class="button"><i class="fa fa-comment-o"></i> <?php echo $this->t('home','Contact_us')?><!--div class="contacts"><i class="fa fa-phone"></i> 8(495)134-222-0<br><i class="fa fa-skype"></i> comiron.com</a></div--></a></li>
		  	</ul>
		  </nav>		  
		</div>
	</header>

	<div class="slide image2">
			<div class="block">
				<h2><?php echo $this->t('home','Slogan2')?>
					<br><a href="#" class="open_popup button"><i class="fa fa-check-square"></i> <?php echo $this->t('home','Register'); ?></a>
				</h2>
				<h2><?php echo $this->t('home','Slogan22')?>
					<br><a href="#" class="open_popup button"><i class="fa fa-check-square"></i> <?php echo $this->t('home','Open_shop'); ?></a>
				</h2>
				<h2><?php echo $this->t('home','Slogan23')?>
					<br><a href="http://comiron.com" class="button"><i class="fa fa-check-square"></i> <?php echo $this->t('home','to products'); ?></a>
				</h2>
			</div>
	</div>

	<!--div id="slider">
		<div class="slide image1">
			<h2><?php echo $this->t('home','Slogan')?></h2>
		</div>
		<div class="slide image2">
			<h2><?php echo $this->t('home','Slogan2')?></h2>
		</div>
		<div class="slide image3">
			<h2><?php echo $this->t('home','Slogan3')?></h2>
		</div>
		<div class="slide image4">
			<h2><?php echo $this->t('home','Slogan4')?></h2>
		</div>
		<div class="slide image5">
			<h2><?php echo $this->t('home','Slogan5')?></h2>
		</div>
		<div class="slide image6">
			<h2><?php echo $this->t('home','Slogan6')?></h2>
		</div>
	</div-->

	<div id="start">
		<div class="container">
			<h2><?php echo $this->t('home','Promo_text')?></h2>
			<div class="button open_popup"><?php echo $this->t('home','Right_now')?></div>
		</div>
	</div>

	<div id="description">
		<div class="container">
			<div class="block social">
				<h3><?php echo $this->t('home','Social_network_title')?></h3>
				<p><?php echo $this->t('home','Social_network_text')?></p>
				<div class="button open_popup"><?php echo $this->t('home','Social_network_follow')?></div>
			</div>
			<div class="block shop">
				<h3><?php echo $this->t('home','Create_shop_title')?></h3>
				<p><?php echo $this->t('home','Create_shop_text')?></p>
				<div class="button open_popup"><?php echo $this->t('home','Create_internet_shop')?></div>
			</div>
			<div class="block buys">
				<h3><?php echo $this->t('home','World_buys_title')?></h3>
				<p><?php echo $this->t('home','World_buys_text')?></p>
				<div class="button open_popup"><?php echo $this->t('home','toRegister')?></div>
			</div>
		</div>
	</div>

	<div id="products">
		<div class="container">
			<h2><?php echo $this->t('home','Factory_sales')?></h2>
			<div class="slider">
				<div class="slide"><img src="/images/product1.jpg" alt="" height="200" width="200"></div>
				<div class="slide"><img src="/images/product2.jpg" alt="" height="200" width="200"></div>
				<div class="slide"><img src="/images/product3.jpg" alt="" height="200" width="200"></div>
				<div class="slide"><img src="/images/product4.jpg" alt="" height="200" width="200"></div>
				<div class="slide"><img src="/images/product1.jpg" alt="" height="200" width="200"></div>
				<div class="slide"><img src="/images/product2.jpg" alt="" height="200" width="200"></div>
			</div>
			<h4><?php echo $this->t('home','Thousends_of_products')?></h4>
			<h2><?php echo $this->t('home','Gurantee_of_delivery')?></h2>
			<img class="car" src="/images/car.jpg" height="454" width="767" alt="">
			<h4><?php echo $this->t('home','By_flash_To_factory')?></h4>
		</div>
	</div>

	<div id="shops">
		<h2><?php echo $this->t('home','Shops_on_comiron')?></h2>
		<div class="images">
			<img src="/images/shop1.jpg" alt="" height="200" width="200">
			<img src="/images/shop2.jpg" alt="" height="200" width="200">
			<img src="/images/shop3.jpg" alt="" height="200" width="200">
			<img src="/images/shop4.jpg" alt="" height="200" width="200">
			<img src="/images/shop5.jpg" alt="" height="200" width="200">
			<img src="/images/shop6.jpg" alt="" height="200" width="200">
			<img src="/images/shop7.jpg" alt="" height="200" width="200">
			<img src="/images/shop8.jpg" alt="" height="200" width="200">
			<img src="/images/shop9.jpg" alt="" height="200" width="200">
			<img src="/images/shop1.jpg" alt="" height="200" width="200">
			<img src="/images/shop10.jpg" alt="" height="200" width="200">
			<img src="/images/shop11.jpg" alt="" height="200" width="200">
			<img src="/images/shop12.jpg" alt="" height="200" width="200">
			<img src="/images/shop13.jpg" alt="" height="200" width="200">
			<img src="/images/shop14.jpg" alt="" height="200" width="200">
			<img src="/images/shop15.jpg" alt="" height="200" width="200">
			<img src="/images/shop16.jpg" alt="" height="200" width="200">
			<img src="/images/shop17.jpg" alt="" height="200" width="200">
			<img src="/images/shop18.jpg" alt="" height="200" width="200">
			<img src="/images/shop10.jpg" alt="" height="200" width="200">
		</div>
		<div class="images hidden">
			<img src="/images/shop1.jpg" alt="" height="200" width="200">
			<img src="/images/shop2.jpg" alt="" height="200" width="200">
			<img src="/images/shop3.jpg" alt="" height="200" width="200">
			<img src="/images/shop4.jpg" alt="" height="200" width="200">
			<img src="/images/shop5.jpg" alt="" height="200" width="200">
			<img src="/images/shop6.jpg" alt="" height="200" width="200">
			<img src="/images/shop7.jpg" alt="" height="200" width="200">
			<img src="/images/shop8.jpg" alt="" height="200" width="200">
			<img src="/images/shop9.jpg" alt="" height="200" width="200">
			<img src="/images/shop1.jpg" alt="" height="200" width="200">
			<img src="/images/shop10.jpg" alt="" height="200" width="200">
			<img src="/images/shop11.jpg" alt="" height="200" width="200">
			<img src="/images/shop12.jpg" alt="" height="200" width="200">
			<img src="/images/shop13.jpg" alt="" height="200" width="200">
			<img src="/images/shop14.jpg" alt="" height="200" width="200">
			<img src="/images/shop15.jpg" alt="" height="200" width="200">
			<img src="/images/shop16.jpg" alt="" height="200" width="200">
			<img src="/images/shop17.jpg" alt="" height="200" width="200">
			<img src="/images/shop18.jpg" alt="" height="200" width="200">
			<img src="/images/shop10.jpg" alt="" height="200" width="200">
		</div>
		<div class="images hidden">
			<img src="/images/shop1.jpg" alt="" height="200" width="200">
			<img src="/images/shop2.jpg" alt="" height="200" width="200">
			<img src="/images/shop3.jpg" alt="" height="200" width="200">
			<img src="/images/shop4.jpg" alt="" height="200" width="200">
			<img src="/images/shop5.jpg" alt="" height="200" width="200">
			<img src="/images/shop6.jpg" alt="" height="200" width="200">
			<img src="/images/shop7.jpg" alt="" height="200" width="200">
			<img src="/images/shop8.jpg" alt="" height="200" width="200">
			<img src="/images/shop9.jpg" alt="" height="200" width="200">
			<img src="/images/shop1.jpg" alt="" height="200" width="200">
			<img src="/images/shop10.jpg" alt="" height="200" width="200">
			<img src="/images/shop11.jpg" alt="" height="200" width="200">
			<img src="/images/shop12.jpg" alt="" height="200" width="200">
			<img src="/images/shop13.jpg" alt="" height="200" width="200">
			<img src="/images/shop14.jpg" alt="" height="200" width="200">
			<img src="/images/shop15.jpg" alt="" height="200" width="200">
			<img src="/images/shop16.jpg" alt="" height="200" width="200">
			<img src="/images/shop17.jpg" alt="" height="200" width="200">
			<img src="/images/shop18.jpg" alt="" height="200" width="200">
			<img src="/images/shop10.jpg" alt="" height="200" width="200">
		</div>
		<div class="clear"></div>
		<div class="show_more button"><?php echo $this->t('home','Show_more')?></div>
	</div>

	<footer>
		<div class="container">
			<ul>
				<li><b>Comiron. © 2012-<?php echo date('Y'); ?>.</b></li>
				<li><a href="#" class="gray underline"><?php echo $this->t('common','terms')?></a></li>
				<li><a href="#" class="gray underline"><?php echo $this->t('common','advertising')?></a></li>
				<li><a href="#" class="gray underline"><?php echo $this->t('common','privacy')?></a></li>
				<li>
					<div class="choose choose1" style="display:none">
						<span class="gray"><?php echo $this->t('common','Uilanguage')?>:</span>
					   <a class="gray underline" href="/profile/lang/en" title="<?php echo $this->t('common','set_EN'); ?>"><?php echo $this->t('common','set_EN'); ?></a><br>
					   <a class="gray underline" href="/profile/lang/ru" title="<?php echo $this->t('common','set_RU'); ?>"><?php echo $this->t('common','set_RU'); ?></a><br>
					   <a class="gray underline" href="/profile/lang/ch" title="<?php echo $this->t('common','set_CH'); ?>"><?php echo $this->t('common','set_CH'); ?></a><br>
					   <a class="gray underline" href="/profile/lang/it" title="<?php echo $this->t('common','set_IT'); ?>"><?php echo $this->t('common','set_IT'); ?></a>
					</div>
					<span class="gray"><?php echo $this->t('common','Uilanguage')?>: <a href="#" class="gray underline choose1_open"><?php echo $this->get_cur_lang(); ?></a></span>
				</li>
				<li>
					<div class="choose choose2" style="display:none">
					<span class="gray"><?php echo $this->t('common','country_content')?>:</span>
		   		   <?php $current = 'USA'; $country_content=$this->model('country_content');
			   			$countries=$country_content->get_countries($this->get_cur_lang());
							foreach($countries as $country){
								echo "<a class=\"gray underline\" href=\"/profile/country_content/{$country['code2']}\" title=\"{$country['name']}\" ";
								if($country['is_current']){
									echo "class=\"is_current\"";
									$current = $country['name'];
								}
								echo " >{$country['name']}</a><br>\n";
							}
						 ?>
					</div>
					<span class="gray"><?php echo $this->t('common','country_content')?>: <a href="#" class="gray underline choose2_open"><?php echo $current; ?></a></span>
				</li>
			</ul>
		</div>
	</footer>

	<div id="splash" style="display:none"></div>
		
	<?php $this->template('home/popups.php', $vars); ?>

	<div style="display:none;"><?php $this->template('common/counter.php', $vars); ?></div>

</div>

	<!-- Scripts -->
	<script src="/js/jquery-2.1.1.min.js"></script>
	<script src="/js/jquery-ui.min.js"></script>
	<script src="/js/jquery.inputmask.js"></script>
	<script src="/js/jquery.activity.min.js"></script>
	<script src="/js/referer.js"></script>
	<script src="/js/slick.min.js"></script>
	<script src="/js/photos.js"></script>
	<script src="/js/jquery.validate.min.js"></script>
	<script>
	/*	$.datepicker.setDefaults($.datepicker.regional['ru']);
		
		$("#date_of_birth").datepicker().datepicker( "option", {
			"dateFormat": "dd.mm.yy",
			"changeYear":true,
			"changeMonth":true,
			"yearRange": "1925:2010" 
			});*/

	</script>
	<?php 
if(isset($_SESSION['lang'])){ ?>
<script src="/js/i18n/<?php echo $_SESSION['lang']?>/main-ui.js"></script>
<script src="/js/i18n/<?php echo $_SESSION['lang']?>/jquery.ui.datepicker-<?php echo $_SESSION['lang']?>.js"></script>
<?php } ?>

	<script src="/js/home_scripts.js"></script>

	<!-- Counters -->

	<!-- Yandex.Metrika counter -->
	
	<!-- /Yandex.Metrika counter -->
	
	<script>
		/*$('body').activity({
			'achieveTime':60
			,'testPeriod':10
			,useMultiMode: 1
			,callBack: function (e) {
				yaCounter26912364.reachGoal('60_sec');
			}
		});*/
	</script>
<a href="http://creograf.ru"></a>
</body>
</html>