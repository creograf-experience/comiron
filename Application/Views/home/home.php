<?php
if (isset($_SESSION['username'])) {
	
	// only add the openid login dialog if extension_loaded('bcmath') || extension_loaded('gmp') else it exceptions
	$this->template('/common/header.php', $vars);
?>
<div id="profileInfo" class="clearfix">
	<div class="header"><?php echo $this->t('home','enter'); ?></div>
	<div id="userMenuDiv"<?php echo ! isset($_SESSION['username'])? ' style="margin-right:12px"' : '' ?>>
		<?php
  
    echo "<a href=\"/home\">". $this->t('home','home')."</a> | ".
    	"<a href=\"/profile/{$_SESSION['id']}\">". $this->t('home','profile')."</a> | ".
    	"<a href=\"/logout\">". $this->t('home','logout')."</a>&nbsp;";
  ?>
   
 <p><a href="<?php PartuzaConfig::get('web_prefix') ?>/register" ><?php echo $this->t('home','register'); ?></a></p>
 <p><a href="/profile/forgot"><?php echo $this->t('home','forgot_email_or_password'); ?></a></p>     
    
	</div>
</div>

<div id="profileContentWide">
<div class="hello">
<img src="/images/comiron-home.png" align="left" />
<?php  echo $this->t('home','hello_big_text');?>
</div>


<?php $this->template('/register/register_small.php', $vars);?>

</div>

</div>

<?php $this->template('/common/footer.php');

}else{
	
	
	$this->template('/home/start.php', $vars);



}
?>
