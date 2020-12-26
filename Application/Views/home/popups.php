 <div id="popup" class="popup" style="display:none">
    <div class="close"><i class="fa fa-close"></i></div>
    <div class="title"><?php echo $this->t('home','Account_information'); ?></div>
    <form action="" class="ajax_form">
      <div class="column">
        <input type="text" name="register_email" id="register_email" placeholder="<?php echo $this->t('common','email')?>" <?php echo isset($_POST['register_email']) ? "value=\"".$_POST['register_email']."\"" : ''?> required>
        <input type="password" name="register_password" id="register_password" placeholder="<?php echo $this->t('common','password')?>" required>
        <input type="password" name="register_password2" id="register_password2" placeholder="<?php echo $this->t('common','password again')?>" required>
        <!--div class="captcha">
          <img id="siimage" class="capt_img" src="/capcha/securimage_show.php?sid=8f7f9f31fbff09df0c2b0c914fe6eed8" alt="CAPTCHA Image" align="left">
          <div class="right">
            <object type="application/x-shockwave-flash" data="/capcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=/capcha/images/audio_icon.png&amp;audio_file=/capcha/securimage_play.php" height="24" width="24">
            <param name="movie" value="/capcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=/capcha/images/audio_icon.png&amp;audio_file=/capcha/securimage_play.php" />
            </object><br>
            <a tabindex="-1" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '/capcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="/capcha/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0" width="24" height="24"></a>
          </div>
          <div class="clear"></div>
        </div>
        <input type="text" name="ct_captcha" size="12" maxlength="8" placeholder="<?php echo $this->t('common','capcha')?>"-->
      </div>
      <div class="column last">
        <input type="text" name="register_first_name" id="register_first_name" placeholder="<?php echo $this->t('home','first_name')?>">
        <input type="text" name="register_last_name" id="register_last_name" placeholder="<?php echo $this->t('home','last_name')?>">
        <!--input type="date" name="date_of_birth" id="date_of_birth" placeholder="<?php echo $this->t('home','birth')?>">
        <select name="gender" id="gender" placeholder="<?php echo $this->t('home','gender')?>">
          <option value=""><?php echo $this->t('profile','gender')?></option>
          <option value="FEMALE"><?php echo $this->t('home','Female')?></option>
          <option value="MALE"><?php echo $this->t('home','Male')?></option>
        </select>
        

        <select name="country" id="country" placeholder="<?php echo $this->t('home','Country')?>">
          <?php foreach($vars['countries'] as $country){ 
              if($_SESSION['lang']){
                echo "<option value=\"{$country['code2']}\">{$country['name_'.$_SESSION['lang']]}</option>";
              } else {
                echo "<option value=\"{$country['code2']}\">{$country['name']}</option>";
              }
            } ?>
        </select-->
      </div>
      <input class="button" type="submit" value="<?php echo $this->t('home','toRegister')?>">
    </form>
  </div>

  <div id="login" class="popup" style="display:none">
    <div class="close"><i class="fa fa-close"></i></div>
    <div class="title"><?php echo $this->t('home','Login')?></div>
    <form action="/login" class="ajax_form">
      <input type="text" name="login_email" id="login_email" placeholder="<?php echo $this->t('common','email')?>" <?php echo isset($_POST['login_email']) ? "value=\"".$_POST['login_email']."\"" : ''?> required>
      <input type="password" name="login_password" id="login_password" placeholder="<?php echo $this->t('common','password')?>" required>
      <span class="forget white underline"><?php echo $this->t('common','forgot_email')?></span>
      <input class="button" type="submit" value="<?php echo $this->t('home','Login')?>">
    </form>
  </div>

  <div id="forget" class="popup" style="display:none">
    <div class="close"><i class="fa fa-close"></i></div>
    <div class="title"><?php echo $this->t('common','Password restore')?></div>
    <form action="/profile/forgot" class="ajax_form">
      <input type="text" name="email" placeholder="<?php echo $this->t('common','email')?>" required>
      <input class="button" type="submit" value="<?php echo $this->t('common','send')?>">
    </form>
  </div>

  <div id="msg_popup" class="popup" style="display:none">
    <div class="close"><i class="fa fa-close"></i></div>
    <div class="title"><?php echo $this->t('home','Error')?></div>
    <div class="content"></div>
  </div>