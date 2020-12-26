<?php 
$this->template('/common/fheader.php', $vars);
?>

<div class="container-fluid">
<div id="firstDiv" class="isnotcentral">
<div class="row-fluid">
<div class="span7">
    
<?php if($_SESSION['lang'] == 'ru'): ?>
<img src="/images/table.png" class="s-table">
<?php elseif($_SESSION['lang'] == 'it'): ?>
<img src="/images/table.png" class="s-table">    
<?php elseif($_SESSION['lang'] == 'ch'): ?>
<img src="/images/table_china.png" class="s-table">
<?php else: ?>
<img src="/images/table.png" class="s-table">
<?php endif; ?>
</div>

<div class="span5 logincolumn">

<div class="first">
<div class="content1">
<div id="container-for-login">

<div id="login_dialog">
<form action="/login" method="post" autocomplete="on">
<div class="buttons clearfix">
<button type="submit"><?php echo $this->t('home','Login')?></button>
</div>
<div id="error"></div>
<label for="login_email"><?php echo $this->t('common','email')?></label>
<input type="email" autocomplete="on" name="login_email" id="login_email" <?php echo isset($_POST['login_email']) ? "value=\"".$_POST['login_email']."\"" : ''?>  />

<label for="login_password"><?php echo $this->t('common','password')?></label>
<input type="password" name="login_password" id="login_password" />
	
<a href="/profile/forgot" class="forgot"><?php echo $this->t('common','forgot_email')?></a>
<br><a href="#" id="reg"><?php echo $this->t('home','Register');?></a>
</form>
</div>

</div>


<div id="container-for-register">
<div id="register_dialog">
<form action="/register" method="post" id="register">

<div id="error_reg"></div>
<?php if (! empty($vars['error'])) { ?>
<div style="color: red"><?php echo $this->t('home','Error') . $vars['error']?></b><br /></div>
<?php } ?>

<table class="markup"><tr><td width="50%">

<div class="form_header"><?php echo $this->t('home','Account_information'); ?></div>

<label for="register_email"><?php echo $this->t('common','email'); ?></label>
<input type="email" name="register_email" id="register_email" required value="<?php echo isset($_POST['register_email']) ? $_POST['register_email'] : ''?>" />

<label for="register_password"><?php echo $this->t('common','password'); ?></label>
<input type="password" name="register_password" required id="register_password" />
<div id="password_status" class="password_status"></div>


<label for="register_password2"><?php echo $this->t('common','password again'); ?></label>
<input type="password" name="register_password2" required id="register_password2" />

<label for="ct_captcha"><?php echo $this->t('common','capcha'); ?></label>
<table><tr><td>

<img id="siimage" class="captcha" src="/capcha/securimage_show.php?sid=8f7f9f31fbff09df0c2b0c914fe6eed8" alt="CAPTCHA Image" align="left">

</td><td>
<object type="application/x-shockwave-flash" data="/capcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=/capcha/images/audio_icon.png&amp;audio_file=/capcha/securimage_play.php" height="24" width="24">
<param name="movie" value="/capcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=/capcha/images/audio_icon.png&amp;audio_file=/capcha/securimage_play.php" />
</object><br>

<a tabindex="-1" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '/capcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="/capcha/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0" width="24" height="24"></a><br />
</td></tr>
<tr><td><input type="text" name="ct_captcha" size="12" maxlength="8" style="width:225px" /></td></tr></table>

</td><td>&nbsp;&nbsp;&nbsp;</td><td width="50%">

<div class="form_header"><?php echo $this->t('home','Your information'); ?></div>

<label for="register_first_name"><?php echo $this->t('home','first_name'); ?></label>
<input type="text" name="register_first_name" id="register_first_name" required value="<?php echo isset($_POST['register_first_name']) ? $_POST['register_first_name'] : ''?>" />


<label for="register_last_name"><?php echo $this->t('home','last_name'); ?></label>
<input type="text" name="register_last_name" id="register_last_name" required value="<?php echo isset($_POST['register_last_name']) ? $_POST['register_last_name'] : ''?>" />

<label for="date_of_birth"><?php echo $this->t('home','birth'); ?></label>
<input type="text" name="date_of_birth" id="date_of_birth" style="width:100px" value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''?>" />

<label for="gender">пол</label>
<div class="select"><select name="gender" id="gender" style="width: auto">
	<option value="">-</option>
	<option value="FEMALE"><?php echo $this->t('home','Female'); ?></option>
	<option value="MALE"><?php echo $this->t('home','Male'); ?></option>
</select></div>

<label for="country"><?php echo $this->t('common','country'); ?></label>
<div class="select"><select name="country" id="country" style="width: auto">
<?php
foreach($vars['countries'] as $country){ 
	echo "<option value=\"{$country['code2']}\">{$country['name']}</option>";
}
?>
</select></div>


</td></tr></table>
	
<div class="buttons">
<button type="submit"><?php echo $this->t('home','toRegister'); ?></button>&nbsp;&nbsp;
<button class="close" id="cancel">&nbsp;<?php echo $this->t('home','Close'); ?>&nbsp;</button>
</div>
</form>

</div>
</div>

</div></div>
</div></div>



<div class="row-fluid second-line">
<div class="span7">

<table class="ft">
<tr>
<td class="f1_icon">
<center></center><img src="/images/f_social.png" alt="<?php echo $this->t('home','social comiron'); ?>" width="54" height="54"></center>
<div class="dep"><?php echo $this->t('home','social comiron'); ?></div>
</td>
<td style="vertical-align:middle;">
<div class="left"><img src="/images/f_socail1.png"  name="f_socail1" class="f_icon f_social" alt="<?php echo $this->t('home','social_1'); ?>" width="67" height="67"></div>
</td>
<td style="vertical-align:middle;">
<center><img src="/images/f_socail2.png" name="f_socail2" class="f_icon f_social" alt="<?php echo $this->t('home','social_2'); ?>" width="67" height="67"></center>
</td>
<td style="vertical-align:middle;">
<div class="right"><img src="/images/f_socail3.png"  name="f_socail3" class="f_icon f_social" alt="<?php echo $this->t('home','social_3'); ?>" width="67" height="67"></div>
</td>
</tr>
<tr><td></td><td colspan="3">
<div class="comment1"><?php echo $this->t('home','social_1'); ?></div>
</td></tr>

<tr><td><br></td></tr>

<tr>
<td class="f1_icon">
<center></center><img src="/images/f_shop.png" alt="<?php echo $this->t('home','business comiron'); ?>" width="54" height="54"></center>
<div class="dep"><?php echo $this->t('home','business comiron'); ?></div>
</td>
<td style="vertical-align:middle;">
<div class="left"><img src="/images/f_shop1.png" name="f_shop1" class="f_icon f_shop" alt="<?php echo $this->t('home','business_1'); ?>" width="67" height="67"></div>
</td>
<td style="vertical-align:middle;">
<center><img src="/images/f_shop2.png"  name="f_shop2" class="f_icon f_shop" alt="<?php echo $this->t('home','business_2'); ?>" width="67" height="67"></center>
</td>
<td style="vertical-align:middle;">
<div class="right"><img src="/images/f_shop3.png" name="f_shop3" class="f_icon f_shop" alt="<?php echo $this->t('home','business_3'); ?>" width="67" height="67"></div>
</td>
</tr>
<tr><tr><td></td><td colspan="3">
<div class="comment2"><?php echo $this->t('home','business_1'); ?></div>
</td></tr>

</table>

</div>
<div class="span5">
	<div id="login_comment">
	<?php echo $this->t('home','login_comment'); ?>
	</div>
</div>
</div>


<script>
	$.datepicker.setDefaults($.datepicker.regional['ru']);
	
	$("#date_of_birth").datepicker().datepicker( "option", {
		"dateFormat": "dd.mm.yy",
		"changeYear":true,
		"changeMonth":true,
		"yearRange": "1925:2010" 
		});

	 $('form#register').validate({
           			// debug: true,
		             focusInvalid: true,
		             focusCleanup: false,
		             onkeyup: false,
		             errorClass: "invalid",
		             validClass: "success",
		             //errorElement: "em",
		             //wrapper: "li",
		             rules: {
		                 register_email: {
		                     required: true,
		                     email: true
/*		                     remote: {
		                         url: "/",
		                         //						type: "post",
		                         data: {
		                             messKlient_ajaxValidateReg_login: 1,
		 							 style: "ajax"
		                         }
		                     }*/
		                 },


		                 register_first_name: {
		                     required: true,
		                     minlength: 1
		                 },
		                 register_last_name: {
		                     required: true,
		                     minlength: 1
		                 },
		                 date_of_birth:{
		                     required: true,
                                     //date: true,
                                     /*
		                     isdate: function(){
		                     	var vDT="(([012]?[1-9])|10|20|30|31)[/](([0]?[1-9])|10|11|12)[/](19|20)?[0-9]{2}";
		                 	 	var regex = new RegExp(vDT);
		                 	 	return (regex.test($("#date_of_birth").val()));
		                     }*/

						 },
				register_password: {
		                     required: true,
		                     minlength: 6,
		                     maxlength: 255
		                 },
		                 register_password2: {
		                     equalTo: "#register_password"
		                 },
		                 gender: {
		                     required: true
		                 },
		                 ct_captcha: {
		                     required: true,
		                     rangelength: [6, 6]/*,
		                     remote: {
		                         url: "/",
		                         //						type: "post",
		                         data: {
		                             messKlient_ajaxAntiRobotValidate: 1,
		 							style: "ajax"
		                         }
		                     }*/
		                 }
		             },
		             messages: {
		                
		            	 register_email: {
		                     required: t("common","register_email_required"),
		                     email: t("common","register_email_email")
		                 },
		                 register_first_name: {
		                     required: t("common","register_first_name_required"),
		                     minlength: t("common","register_first_name_length")
		                 },
		                 register_last_name: {
		                     required: t("common","register_last_name_required"),
		                     minlength: t("common","register_last_name_length")
		                 },
		                 date_of_birth: {
		                     required: t("common","date_of_birth_required"),
                                     is_date: t("common","date_of_birth_required_date")
		                 },
		                 register_password: {
		                     required: t("common","register_password_required"),
		                     minlength: t("common","register_password_minlength"),
		                     maxlength: t("common","register_password_maxlength")
		                 },
		                 register_password2: {
		                     equalTo: t("common","register_password2_equalTo")
		                 },
		                 gender: {
		                     required: t("common","gender_required")
		                 },
		                 ct_captcha: {
		                     required: t("common","ct_captcha_required"),
		                     rangelength: t("common","ct_captcha_rangelength")
		                 }
		             }
		             /*errorPlacement: function(error, element){
		              error=$(error).text();
		              element.siblings("em").html(error);
		              }*/
		         });
		         
</script>
</div>

</div>

<?php
 
$this->template('/common/footer.php');
?>
 