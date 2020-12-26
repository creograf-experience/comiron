
<div id="reg">
<table class="maket">
<tr><td>
<div class="gadgets-gadget-chrome">
<div class="gadgets-gadget-title-bar"><?php echo $this->t('home','Register'); ?></div>
<div style="padding: 12px">
<?php if (! empty($vars['error'])) { ?>
<div style="color: red"><?php echo $this->t('home','Error') . $vars['error']?></b><br /></div>
<?php } ?>
		
<form action="/register" method="post" id="register">
<div class="form_header"><?php echo $this->t('home','Account_information'); ?></div>

<div class="form_entry">
<div class="form_label"><label for="register_email"><?php echo $this->t('common','email'); ?></label></div>
<input type="email" name="register_email" id="register_email" required
	value="<?php echo isset($_POST['register_email']) ? $_POST['register_email'] : ''?>" />
</div>

<div class="form_entry">
<div class="form_label"><label for="register_password"><?php echo $this->t('common','password'); ?></label></div>
<input type="password" name="register_password" required id="register_password" />
<div id="password_status" class="password_status"></div>
</div>

<div class="form_entry">
<div class="form_label"><label for="register_password2"><?php echo $this->t('common','password again'); ?></label></div>
<input type="password" name="register_password2" required id="register_password2" />
</div>

<div class="form_header"><?php echo $this->t('home','Your information'); ?></div>

<div class="form_entry">
<div class="form_label"><label for="register_first_name"><?php echo $this->t('home','first_name'); ?></label></div>
<input type="text" name="register_first_name" id="register_first_name" required
	value="<?php echo isset($_POST['register_first_name']) ? $_POST['register_first_name'] : ''?>" />
</div>

<div class="form_entry">
<div class="form_label"><label for="register_last_name"><?php echo $this->t('home','last_name'); ?></label></div>
<input type="text" name="register_last_name" id="register_last_name" required
	value="<?php echo isset($_POST['register_last_name']) ? $_POST['register_last_name'] : ''?>" />
</div>

<div class="form_entry">
<div class="form_label"><label for="date_of_birth"><?php echo $this->t('home','date of birth'); ?></label></div>
    <input type="text" name="date_of_birth" id="date_of_birth" style="width:100px"
    	value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''?>" />
</div>

<div class="form_entry">
<div class="form_label"><label for="gender"><?php echo $this->t('home','gender'); ?></label></div>
<select name="gender" id="gender" style="width: auto">
	<option value="-">-</option>
	<option value="FEMALE"><?php echo $this->t('home','Female'); ?></option>
	<option value="MALE"><?php echo $this->t('home','Male'); ?></option>
</select></div>

<div class="form_entry">
<div class="form_label"><label for="gender"><?php echo $this->t('common','country'); ?></label></div>
<select name="country" id="country" style="width: auto">
<?php
foreach($vars['countries'] as $country){ 
	echo "<option value=\"{$country['code2']}\">{$country['name']}</option>";
}
?>
</select></div>
<div class="form_entry">
<div class="form_label"><label for="ct_captcha"><?php echo $this->t('common','capcha'); ?></label></div>
<table><tr><td>

    <img id="siimage" class="captcha" src="/capcha/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
 
    </td><td>
    <object type="application/x-shockwave-flash" data="/capcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=/capcha/images/audio_icon.png&amp;audio_file=/capcha/securimage_play.php" height="24" width="24">
    <param name="movie" value="/capcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=/capcha/images/audio_icon.png&amp;audio_file=/capcha/securimage_play.php" />
    </object><br>

    <a tabindex="-1" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '/capcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="/capcha/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0" width="24" height="24"></a><br />
</td></tr>
<tr><td><input type="text" name="ct_captcha" size="12" maxlength="8" style="width:225px" /></td></tr></table>
</div>

<div><input class="submit" type="submit" value="<?php echo $this->t('home','toRegister'); ?>" /></div>

</td><td>
<div class="gadgets-gadget-chrome">
<div class="gadgets-gadget-title-bar"><?php echo $this->t('common','privacy'); ?></div>

<textarea class="confident" readonly="readonly">
<?php echo $this->t('home','licence_text'); ?>
</textarea>

<div class="agree">
<span class="niceCheck"><input type="checkbox" id="agree" name="agree" value="1"></span><label for="agree">&nbsp;<?php echo $this->t('home','I_agree'); ?></label>
</div>

</div>
</td></tr>


</table>
</form>
</div>
</div>

<script>
	$("#date_of_birth").datepicker().datepicker( "option", {
		"dateFormat": "dd.mm.yy",
		"changeYear":true,
		"changeMonth":true,
		"yearRange": "1925:2010" 
		});
</script>