
<div id="editTabs">
  <ul>
  	<li><a href="#basic"><?php echo $this->t('shop','Basic')?></a></li>
  	<li><a href="#contact"><?php echo $this->t('shop','Contact')?></a></li>
  	<li><a href="#picture"><?php echo $this->t('shop','Picture')?></a></li>
  	<li><a href="#adv"><?php echo $this->t('shop','Advanced')?></a></li>
  	<li><a href="#view"><?php echo $this->t('shop','View')?></a></li>
  </ul>
  <form method="post" enctype="multipart/form-data" action="/shop/edit/<?php echo $vars['shop']['id']?>">

  <div id="basic">
    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','Name')?></label></div>
    <input type="text" name="name" id="name"
    	value="<?php echo isset($vars['shop']['name']) ? $vars['shop']['name'] : ''?>" />
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','Domain')?></label></div>
    <input type="text" name="domain" id="domain" value="<?php echo isset($vars['shop']['domain']) ? $vars['shop']['domain'] : ''?>" />.comiron.com
    </div>

    
    <div class="form_entry">
    	<div class="form_label"><label for="fullname"><?php echo $this->t('shop','Full name')?></label></div>
    	<input type="text" name="fullname" id="fullname"
    		value="<?php echo isset($vars['organization']['fullname']) ? $vars['organization']['fullname'] : ''?>" >
    </div>

    <div class="form_entry">
    	<div class="form_label"><label for="admin_email"><?php echo $this->t('shop','Admin email')?></label></div>
    	<input type="text" name="admin_email" id="admin_email"
    		value="<?php echo isset($vars['shop']['admin_email']) ? $vars['shop']['admin_email'] : ''?>" >
    </div>

    <div class="form_entry">
   	 	<div class="form_label"><label for="order_email"><?php echo $this->t('shop','Order email')?></label></div>
   		 <input type="text" name="order_email" id="order_email"
    		value="<?php echo isset($vars['shop']['order_email']) ? $vars['shop']['order_email'] : ''?>" />
    </div>

    <div class="form_entry">
    	<div class="form_label"><label for="nickname"><?php echo $this->t('shop','Default currency')?></label></div>
    	<select name="currency_id" id="currency_id">
   		<?php
    		foreach ($vars['currency'] as $c) {
    		echo "<option value=\"{$c['id']}\"";
    		if($c['id']==$vars['shop']['currency_id']){
    			echo " selected ";
    		}
    		echo ">".$c['name']."</option>\n";
    	}
    	?>
	    </select>
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="organizationcategory_id"><?php echo $this->t('shop','Busness category')?></label></div>
    <select name="organizationcategory_id" id="organizationcategory_id">
    	<?php
    	foreach ($vars['organization_category'] as $c) {
    		echo "<option ".($vars['organization']['organizationcategory_id']==$c['id']?" selected ":"")." value=\"{$c['id']}\">".$c['name']."</option>\n";
    	    foreach ($c['subrecords'] as $sub) {
    			echo "<option ".($vars['organization']['organizationcategory_id']==$c['id']?" selected ":"")." value=\"{$sub['id']}\">&nbsp;&nbsp;&nbsp;".$sub['name']."</option>\n";
    		}
    	}
    	?>
    </select></div>

    <?php
    $country_content=$this->model('country_content');
    $countries=$country_content->get_countries($this->get_cur_lang());
	?>

   	<div class="form_entry">
    	<div class="form_label"><label for="nickname"><?php echo $this->t('central','Country')?></label></div>
    	<select name="country_content_code2" id="country_content_code2">
   			<?php
   			foreach($countries as $country){
				echo "<option value=\"{$country['code2']}\" ";
				if($country['code2'] == $vars['shop']['country_content_code2']){
					echo "selected ";
				}
				echo ">{$country['name']}</option>\n";
   			}
   			?>
	    </select>
    </div>


    <a href="#"  class="addrCompose" object="shop" object_id="<?php echo $vars['shop']['id'];?>" id="<?php echo $vars['shop']['id'];?>" title="<?php echo $this->t('common', 'Add address') ?>"><img src="/images/b_add.png" alt="<?php echo $this->t('common', 'Add address') ?>">&nbsp;<?php echo $this->t('common', 'Add address') ?></a>

    <table>
    <?php
        if(!empty($vars['addresses'])){
		foreach($vars['addresses'] as $adr){
	?>
    <tr>
    <td><?php echo $adr['addrstring']?></td>
    <td>
      	<?php
          		echo '<a href="#"  class="addressEdit editaddress" id="'.$adr['id'].'" title="'.$this->t('common', 'Edit address').'"><img src="/images/b_edit.png" alt="'.$this->t('common', 'Edit address').'"></a>';
      	?>
    </td><td>
      	<?php
      			echo '<a href="#" name="'.$adr['addrstring'].'" object="people" object_id="'.$vars['person']['id'].'" class="addressDelete deleteaddress" id="'.$adr['id'].'" title="'.$this->t('common', 'Delete address').'"><img src="/images/b_delete.png" alt="'.$this->t('common', 'Delete address').'"></a>';
     	?>
      </td></tr>
    <?php
		}
		}
    ?>
    </table>


    </div>

  <div id="contact">
  	<div class="form_entry">
    <div class="form_label"><label for="emails"><?php echo $this->t('shop','public emails')?></label></div>
    	<textarea name="emails" id="emails"><?php
    	foreach ($vars['shop']['shop_emails'] as $email) {
    		echo $email['email']."\n";
    	}
    	?></textarea>
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="urls"><?php echo $this->t('shop','public urls')?></label></div>
    	<textarea name="urls" id="urls"><?php
    	foreach ($vars['shop']['shop_urls'] as $url) {
    		echo $url['url']."\n";
    	}
    	?></textarea>
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="phone_numbers"><?php echo $this->t('shop','public phone numbers')?></label></div>
    	<textarea name="phone_numbers" id="phone_numbers"><?php
    	foreach ($vars['shop']['shop_phone_numbers'] as $phone_number) {
    		echo $phone_number['phone_number']."\n";
    	}
    	?></textarea>
    </div>

  </div>

  <div id="picture">

    <div class="form_entry">
	<div class="form_label"><label><?php echo $this->t('shop','Select a new photo to upload')?></div>
    	<div class="thumb">
    	<table class="markup"><tr><td>
  		  	<img id="PhotoPrev" src="<?php echo isset($vars['shop']['thumbnail_url']) ? $vars['shop']['thumbnail_url'] : '/images/shop/nophoto.gif'?>" />

    	<div id="queue" style="display:none;"></div>
    	</td><td>&nbsp;</td><td>
    	    <input type="file" name="UploadPhoto" id="UploadPhoto" />

		</td></tr></table>
    	</div>
    </div>
  </div>

  <div id="adv">
  	<div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','options_add_2_friend')?></label></div>
    <select name="add2client" id="add2client">
    	<option <?php echo $vars['shop']['add2client'] == 'options_add_2_friend_auto' ? ' selected' : ''?> value="options_add_2_friend_auto"><?php echo $this->t('shop','options_add_2_friend_auto')?></option>
       	<option <?php echo $vars['shop']['add2client'] == 'options_add_2_friend_req' ? ' selected' : ''?> value="options_add_2_friend_req"><?php echo $this->t('shop','options_add_2_friend_req')?></option>
    </select>
    </div>

    <div class="form_entry line">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','options_product')?></label></div>
    <select name="options_product[]" id="options_product" multiple="multiple">
        <?php
        $access=PartuzaConfig::get('shop_access_types');
      ?>
      <!-- option value=""><?php echo $this->t('profile','Select one...'); ?></option-->
      <option nocheck="nocheck" <?php echo $vars['shop']['options_product'] == '0' ? ' selected' : ''?> value="0"><?php echo $this->t('shop',$access['0'])?></option>
      <option nocheck="nocheck" <?php echo $vars['shop']['options_product'] == '1' ? ' selected' : ''?> value="1"><?php echo $this->t('shop',$access['1'])?></option>
      <option nocheck="nocheck" <?php echo $vars['shop']['options_product'] == '2' ? ' selected' : ''?> value="2"><?php echo $this->t('shop',$access['2'])?></option>
      <option nocheck="nocheck" <?php echo $vars['shop']['options_product'] == '3' ? ' selected' : ''?> value="3"><?php echo $this->t('shop',$access['3'])?></option>
      <option nocheck="nocheck" <?php echo $vars['shop']['options_product'] == '4' ? ' selected' : ''?> value="4"><?php echo $this->t('shop',$access['4'])?></option>
    <?php
    if(isset($vars['usergroups'])){
        foreach ($vars['usergroups'] as $group) {
          echo "      <option value=\"g{$group['id']}\" data-icon=\"/images/people/nophoto.205x205.gif\"";
          echo $group['options_product'] ? ' selected' : '';
          echo ">{$group['name']}</option>\n";
        }
      }
      ?>
    </select>
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','options_product_nosklad')?></label></div>
    <div class="form">  <label class="checkbox">
          <input type="checkbox" id="hideproductnosklad" name="hideproductnosklad"
            <?php echo $vars['shop']['hideproductnosklad'] == '1' ? ' checked' : ''?>><?php echo $this->t('shop','Hidden')?>
        </label>
    </div>
    </div><br>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','options_price')?></label></div>
    <select name="options_price" id="options_price">
    	<option <?php echo $vars['shop']['options_price'] == '0' ? ' selected' : ''?> value="0"><?php echo $this->t('shop',$access['0'])?></option>
    	<option <?php echo $vars['shop']['options_price'] == '2' ? ' selected' : ''?> value="2"><?php echo $this->t('shop',$access['2'])?></option>
    	<option <?php echo $vars['shop']['options_price'] == '3' ? ' selected' : ''?> value="3"><?php echo $this->t('shop',$access['3'])?></option>
    </select>
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','options_comment')?></label></div>
    <select name="options_comment" id="options_comment">
      <option <?php echo $vars['shop']['options_comment'] == '3' ? ' selected' : ''?> value="3"><?php echo $this->t('shop',$access['3'])?></option>
      <option <?php echo $vars['shop']['options_comment'] == '2' ? ' selected' : ''?> value="2"><?php echo $this->t('shop',$access['2'])?></option>
      <option <?php echo $vars['shop']['options_comment'] == '0' ? ' selected' : ''?> value="0"><?php echo $this->t('shop',$access['0'])?></option>
    </select>
    </div>

    <div class="form_entry">
      <div class="form_label"><label for="name"><?php echo $this->t('shop','Payment')?></label></div>
      <div class="form">
        <label class="checkbox">
          <input type="checkbox" id="paysimplepay" name="paysimplepay"
            <?php echo $vars['shop']['paysimplepay'] == '1' ? ' checked' : ''?>
          class="oferta" ofertaname="simplepay">
          <?php echo $this->t('shop','paysimplepay')?>
        </label>
        <label class="checkbox">
          <input type="checkbox" id="paysber" name="paysber"
            <?php echo $vars['shop']['paysber'] == '1' ? ' checked' : ''?>
          class="oferta" ofertaname="sber">
          <?php echo $this->t('shop','paysber')?>
        </label>
      </div>
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','delivery_compensation')?></label></div>
      <input type="number" name="deliverycomp" id="deliverycomp" value="<?php echo $vars['shop']['deliverycomp']; ?>">&nbsp;%
    </div>

    <div class="form_entry">
      <div class="form_label"><label for="name"><?php echo $this->t('shop','Delivery')?></label></div>
      <div class="form">
        <label class="checkbox">
          <input type="checkbox" id="deliveryhermesru" name="deliveryhermesru"
            <?php echo $vars['shop']['deliveryhermesru'] == '1' ? ' checked' : ''?>
          class="oferta" ofertaname="hermesru">
          HermesDPD
        </label>
        <label class="checkbox">
          <input type="checkbox" id="deliverydpdru" name="deliverydpdru"
            <?php echo $vars['shop']['deliverydpdru'] == '1' ? ' checked' : ''?>
          class="oferta"  ofertaname="dpdru">
          DPD
        </label>
        <label class="checkbox">
          <input type="checkbox" id="deliveryrupost" name="deliveryrupost"
            <?php echo $vars['shop']['deliveryrupost'] == '1' ? ' checked' : ''?>
          class="oferta"  ofertaname="rupost">
          <?php echo $this->t('shop', 'delivery_rupost')?>
        </label class="checkbox">
        <label>
          <input type="checkbox" id="deliverycourier" name="deliverycourier"
            <?php echo $vars['shop']['deliverycourier'] == '1' ? ' checked' : ''?>
          >
          <?php echo $this->t('shop', 'delivery_courier')?>
        </label>
        <label>
          <input type="checkbox" id="deliverymanager" name="deliverymanager"
            <?php echo $vars['shop']['deliverymanager'] == '1' ? ' checked' : ''?>
          >
          <?php echo $this->t('shop', 'delivery_manager')?>
        </label>
      </div>

       <div class="form_label"><label for="name"><?php echo $this->t('shop','Pickup address')?></label></div>
         <table>
      <?php
          if(!empty($vars['addresses'])){
      foreach($vars['addresses'] as $adr){
    ?>
      <tr>
      <td><input type="radio" <?php if($vars['shop']['city'] == $adr['city']){ echo " checked "; } ?> name="city" class="address" value="<?php echo $adr['city']?>"> <?php echo $adr['addrstring']?></td>
      </tr>
      <?php
      }
      }
      ?>
      </table>
    </div>

    <div class="form_entry">
        <div class="form_label"><label for="status"><?php echo $this->t('shop','terminalsource'); ?></label></div>
        <select id="terminal" name="terminal">
        </select>
    </div>


    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','logistname')?></label></div>
      <input type="text" name="logistname" id="logistname" value="<?php echo $vars['shop']['logistname'];
      if(!isset($vars['shop']['logistname'])){
          echo $vars['person']['first_name'];
        }
      ?>">
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','logistphone');?></label></div>
      <input type="text" name="logistphone" id="logistphone" value="<?php echo $vars['shop']['logistphone'];
        if(!isset($vars['shop']['logistphone'])){
          echo $vars['person']['phone'];
        }
       ?>">
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="name"><?php echo $this->t('shop','delivery_balance')?></label></div>
      <?php echo $vars['shop']['deliverybalance']; ?>
    </div>

  </div>

  <div id="view">
  	<div class="block clearfix">
  	<h2><?php echo $this->t('shop','Menu view')?></h2>
  	<a class="funbutton" href="/shop/edit/<?php echo $vars['shop']['id']; ?>?menustyle=menu0"><?php echo $this->t('shop','Rollback design')?></a>

  	<div class="menuitem">
  	<?php
		if($vars['shop']['menustyle'] == 'menu1'){
			echo "<div class=\"check checked\" id=\"menu1\"></div>";
		}else{
			echo "<div class=\"check unchecked\" id=\"menu1\"></div>";
		}
	?>
		<div class="menu menu1">
  			<ul class="articlesMenu">
				<li><a href="#"><?php echo $this->t('shop','about')?></a></li>
				<li class="hover"><a href="#"><?php echo $this->t('shop','discount system')?></a></li>
				<li><a href="#"><?php echo $this->t('shop','big sale')?></a></li>
			</ul>
  		</div>
  	</div>

 	<div class="menuitem">
  	<?php
		if($vars['shop']['menustyle'] == 'menu2'){
			echo "<div class=\"check checked\" id=\"menu2\"></div>";
		}else{
			echo "<div class=\"check unchecked\" id=\"menu2\"></div>";
		}
	?>
		<div class="menu menu2">
  			<ul class="articlesMenu">
				<li><a href="#"><?php echo $this->t('shop','about')?></a></li>
				<li class="hover"><a href="#"><?php echo $this->t('shop','discount system')?></a></li>
				<li><a href="#"><?php echo $this->t('shop','big sale')?></a></li>
			</ul>
  		</div>
  	</div>

 	<div class="menuitem">
  	<?php
		if($vars['shop']['menustyle'] == 'menu3'){
			echo "<div class=\"check checked\" id=\"menu3\"></div>";
		}else{
			echo "<div class=\"check unchecked\" id=\"menu3\"></div>";
		}
	?>
		<div class="menu menu3">
  			<ul class="articlesMenu">
				<li><a href="#"><?php echo $this->t('shop','about')?></a></li>
				<li class="hover"><a href="#"><?php echo $this->t('shop','discount system')?></a></li>
				<li><a href="#"><?php echo $this->t('shop','big sale')?></a></li>
			</ul>
  		</div>
	</div>

 	<div class="menuitem">
  	<?php
		if($vars['shop']['menustyle'] == 'menu4'){
			echo "<div class=\"check checked\" id=\"menu4\"></div>";
		}else{
			echo "<div class=\"check unchecked\" id=\"menu4\"></div>";
		}
	?>
		<div class="menu menu4">
  			<ul class="articlesMenu">
				<li><a href="#"><?php echo $this->t('shop','about')?></a></li>
				<li class="hover"><a href="#"><?php echo $this->t('shop','discount system')?></a></li>
				<li><a href="#"><?php echo $this->t('shop','big sale')?></a></li>
			</ul>
  		</div>
  	</div>

  	</div>


  	<div class="block clearfix">
  	<h2><?php echo $this->t('shop','Background')?></h2>
  	<a class="funbutton" href="/shop/edit/<?php echo $vars['shop']['id']; ?>?bgstyle=bg0"><?php echo $this->t('shop','Rollback design')?></a>

  	<div id="bg1" class="bg bg1 <?php if($vars['shop']['bgstyle'] == 'bg1'){	echo " checked"; }?>"></div>
  	<div id="bg2" class="bg bg2 <?php if($vars['shop']['bgstyle'] == 'bg2'){	echo " checked"; }?>"></div>
  	<div id="bg3" class="bg bg3 <?php if($vars['shop']['bgstyle'] == 'bg3'){	echo " checked"; }?>"></div>
  	<div id="bg4" class="bg bg4 <?php if($vars['shop']['bgstyle'] == 'bg4'){	echo " checked"; }?>"></div>
  	<div id="bg5" class="bg bg5 <?php if($vars['shop']['bgstyle'] == 'bg5'){	echo " checked"; }?>"></div>
  	<div id="bg6" class="bg bg6 <?php if($vars['shop']['bgstyle'] == 'bg6'){	echo " checked"; }?>"></div>
  	<div id="bg7" class="bg bg7 <?php if($vars['shop']['bgstyle'] == 'bg7'){	echo " checked"; }?>"></div>
  	<div id="bg8" class="bg bg8 <?php if($vars['shop']['bgstyle'] == 'bg8'){	echo " checked"; }?>"></div>
  	<div id="bg9" class="bg bg9 <?php if($vars['shop']['bgstyle'] == 'bg9'){	echo " checked"; }?>"></div>
  	<div id="bg10" class="bg bg10 <?php if($vars['shop']['bgstyle'] == 'bg10'){	echo " checked"; }?>"></div>
  	<div id="bg11" class="bg bg11 <?php if($vars['shop']['bgstyle'] == 'bg11'){	echo " checked"; }?>"></div>
  	<div id="bg12" class="bg bg12 <?php if($vars['shop']['bgstyle'] == 'bg12'){	echo " checked"; }?>"></div>
  	<div id="bg13" class="bg bg13 <?php if($vars['shop']['bgstyle'] == 'bg13'){	echo " checked"; }?>"></div>
  	<div id="bg14" class="bg bg14 <?php if($vars['shop']['bgstyle'] == 'bg14'){	echo " checked"; }?>"></div>
  	<div id="bg15" class="bg bg15 <?php if($vars['shop']['bgstyle'] == 'bg15'){	echo " checked"; }?>"></div>
  	<?php
  		echo "<div class=\"bg mybg ".(($vars['shop']['bgimg'] and !$vars['shop']['bgstyle'])?" checked":"")."\" ";
		if($vars['shop']['bgimg']){
			echo "style=\"background-image: url({$vars['shop']['bgimg']})\"";
		}
		echo "></div>";
	?>

	 <input type="file" name="UploadBG" id="UploadBG" />



  	</div>


  </div>



  <br />
  <div style="margin-left:12px;"><input type="submit" class="btn submit" value="<?php echo $this->t('common','save')?>" /></div>
  </form>
</div>


<script>
$(document).ready(function() {
	$('#editTabs').tabs();

  //оферты
  $(".oferta").change(function(){
    var ch = $(this);
    var ofertaname = $(this).attr("ofertaname");

    if(ch.prop("checked")){
        url="/shop/oferta?ofertaname="+ofertaname;
        var dialog=$("<div id=\"oferta\"></div>");
        dialog.dialog({
        title: t("common","Confirmation"),
                modal: true,
                width: 635,
                resizable: true,
    //          autoOpen: false,
                open: function(){
                    dialog.empty();
                      $("<div>").load(url, function(responseText, textStatus, XMLHttpRequest){
                            $("#oferta").find('#cancel').bind('click', function(e) {
                              e.preventDefault();
                              e.stopPropagation();

                              ch.prop("checked", false);
                              $("#oferta").dialog("close");
                              dialog.remove();
                           
                              return false;
                            });
                            $("#oferta").find('#ok').bind('click', function(e) {
                              e.preventDefault();
                              e.stopPropagation();

                              ch.prop("checked", true);
                              $("#oferta").dialog("close");
                              dialog.remove();
                              
                              return false;
                            });
                      }).appendTo(dialog);
                    uifix();
                  }
            });
          return false; 
      }
  });

  //терминалы dpd
  $.getJSON( "/dpdru/terminals",
    function(data){
      console.log(data);
      //сортировка по алфавиту
      term = new Array();
      data['terminal'].sort(function(a, b) {
         var compA = a['terminalName'];
         var compB = b['terminalName']
         return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
      })
      $.each(data['terminal'], function(idx, itm) { term.push(itm); });


      term.forEach( function(v){
        //console.log(v);
        var option = "<option value='"+v['terminalCode']+"'";
        if(v['terminalCode'] == "<?php echo $vars['shop']['terminal'] ?>"){
          option += "  selected";
        }
        else if(v.address.cityName == "<?php echo $vars['shop']['city'] ?>"){
          console.log(v.address.cityName);
          option += " selected";
        }
        option += ">"+v['terminalName']+"</option>";
        $("#terminal").append(option);
      });
    });

	//меню
	$(".check").click(function(){
		if($(this).hasClass("checked")) return;

		$(this).removeClass("unchecked");

		$(".menuitem .checked").each(function(){
			$(this).removeClass("checked");
			$(this).addClass("unchecked");
		});

		$(this).addClass("checked");

		var menustyle = $(this).attr("id");

		$("<div>").load("/shop/edit/<?php echo $vars['shop']['id']; ?>?menustyle="+menustyle, function( response, status, xhr ) {
			  if ( status != "error" ) {
				  //...
			  }
		});

	})

	//фон
	$(".bg").click(function(){
		if($(this).hasClass("checked")) return;

		$(".bg.checked").each(function(){
			$(this).removeClass("checked");
		});

		$(this).addClass("checked");

		var bgstyle = $(this).attr("id");

		if($(this).hasClass("mybg")){
			$("<div>").load("/shop/edit/<?php echo $vars['shop']['id']; ?>?bgstyle=&bgimg=<?php echo $vars['shop']['bgimg']; ?>", function( response, status, xhr ) {
				 $("body").attr("class","");
				 $("body").attr("style", "background:url(<?php echo $vars['shop']['bgimg']; ?>)");
				});
		}else{
			$("<div>").load("/shop/edit/<?php echo $vars['shop']['id']; ?>?bgstyle="+bgstyle, function( response, status, xhr ) {
			  $("body").attr("class", bgstyle);
			  $("body").attr("style","");
			});
		}
	});

	var imgdata=[];
	$('#UploadBG').uploadifive({
        'auto'      : true,
        'multi'     : false,
        //'cancelImg' : '/images/cancel.png',
        'buttonText': "<?php  echo $this->t('shop','upload background'); ?>",
        'buttonClass'  : 'uploadButton',
        //'checkScript'      : 'check-exists.php',
        'formData'  : {
                            'folder'    : '/images/shop',
                            'id':<?php echo $vars['shop']['id']?>,
                      },
        'queueID'          : 'queue',
        'uploadScript'    : '/shop/uploadbgimg',
        'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
        'queueSizeLimit' : 10,
        'fileType'     : 'image',
        'height':20,
        'onAddQueueItem' : function(file){
                $("#queue").show();
        },
        'onUploadComplete' : function(file, data) {
                        file.name=data;//!COMIRON: файл переименован на сервере
                        imgdata.push(file);
                        data = '/images/shop/'+data;

                        $('.mybg').attr("style", 'background-image: url(' +data +')');
                        $(".bg.checked").each(function(){
                			$(this).removeClass("checked");
                		});

                		$(".mybg").addClass("checked");

                        $("<div>").load("/shop/edit/<?php echo $vars['shop']['id']; ?>?bgstyle=&bgimg="+data, function( response, status, xhr ) {
       						 $("body").attr("class","");
       						 $("body").attr("style", "background:url(" + data + ")");
       					});

                        //uploaddifyOnComplete(event,queueId,fileObj,response,data);
                },
        'onQueueComplete' : function(uploads) {
                //location.reload();

                $("#queue").html("");
                $("#queue").hide();
        },
        'onError': function (a, b, c, d) {
                //this.iserror=true;
                $('#message_file_upload').attr("iserror",1);
                if(a=="FILE_SIZE_LIMIT_EXCEEDED"){
                        alert("<?php  echo $this->t('common','FILE_SIZE_LIMIT_EXCEEDED'); ?>");
                }
                if(a=="QUEUE_LIMIT_EXCEEDED"){
                        alert("<?php  echo $this->t('common','QUEUE_LIMIT_EXCEEDED'); ?>");
                }

                if(a=="UPLOAD_LIMIT_EXCEEDED"){
                        alert("<?php  echo $this->t('common','UPLOAD_LIMIT_EXCEEDED'); ?>");
                }

                if(a=="FORBIDDEN_FILE_TYPE"){
                        alert("<?php  echo $this->t('common','FORBIDDEN_FILE_TYPE'); ?>");
                }

                if(a=="404_FILE_NOT_FOUND"){
                        alert("<?php  echo $this->t('common','404_FILE_NOT_FOUND'); ?>");
                }
        }
    });


	$('#UploadPhoto').uberuploadcropper({
		//---------------------------------------------------
		// uploadifive options..
		//---------------------------------------------------
		'displayData': 'percentage',
		'auto'      : true,
		'multi'     : false,
		'cancelImg' : '/images/cancel.png',
		'buttonText': "<?php  echo $this->t('profile','set new profile photo'); ?>",
		//'buttonClass'  : 'btn',
		'buttonClass'  : 'uploadButton',
		//'checkScript'      : 'check-exists.php',
		'formData'  : {
									'folder'    : '/images/shop',
									'id':<?php echo $vars['shop']['id']?>,
		              },
		'queueID'          : 'queue',
		'uploadScript'    : '/shop/uploadprofileimg',
		'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
		'fileType'     : 'image',
//		'displayData': 'percentage',
		 onError: function (a, b, c, d) {
			//this.iserror=true;
			$('#UploadPhoto').attr("iserror",1);
			if(a=="FILE_SIZE_LIMIT_EXCEEDED"){
				alert("<?php  echo $this->t('common','FILE_SIZE_LIMIT_EXCEEDED'); ?>");
			}
			if(a=="QUEUE_LIMIT_EXCEEDED"){
				alert("<?php  echo $this->t('common','QUEUE_LIMIT_EXCEEDED'); ?>");
			}

			if(a=="UPLOAD_LIMIT_EXCEEDED"){
				alert("<?php  echo $this->t('common','UPLOAD_LIMIT_EXCEEDED'); ?>");
			}

			if(a=="FORBIDDEN_FILE_TYPE"){
				alert("<?php  echo $this->t('common','FORBIDDEN_FILE_TYPE'); ?>");
			}

			if(a=="404_FILE_NOT_FOUND"){
				alert("<?php  echo $this->t('common','404_FILE_NOT_FOUND'); ?>");
			}

			/*
			if (d.status == 404)
				alert('Could not find upload script. Use a path relative to: '+'');
			else if (d.type === "HTTP")
				alert('error '+d.type+": "+d.status);
			else if (d.type ==="File Size")
				alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
			else
				alert('error '+d.type+": "+d.text);
			*/
		},
		//onSelect
		'onAddQueueItem':function(){
			$('#UploadPhoto').attr("iserror",0);
		},
		'onProgress': function(file, e) {
	        if (e.lengthComputable) {
	           var percent = Math.round((e.loaded / e.total) * 100);
	        }
	        if(percent==100){
	        	$("#ajax-loader").show();
		    }else{
	        	$("#ajax-loader").hide();
			}
	        /*file.queueItem.find('.fileinfo').html(' - ' + percent + '%');
	        file.queueItem.find('.progress-bar').css('width', percent + '%');*/
	    },
		//---------------------------------------------------
		// cropper options..
		//---------------------------------------------------
		'aspectRatio': 1,//пропорции
		'allowSelect': true,			//can reselect
		'allowResize' : true,			//can resize selection
		'setSelect': [ 0, 0, 200, 200 ],	//these are the dimensions of the crop box x1,y1,x2,y2
		'minSize': [ 100, 100 ],		//if you want to be able to resize, use these
		//'maxSize': [ 100, 100 ],
		//'top':"5%",

		//---------------------------------------------------
		//now the uber options..
		//---------------------------------------------------
		'iserror': false,
		'folder'    : '/images/shop/',
		'id':<?php echo $vars['shop']['id']?>,
		'cropScript': '/shop/cropprofileimg',
		/*'onSelect': function(event,queueID,fileObj){
		   $('#opc_file_imagem').fileUploadSettings('scriptData', '&amp;name='+ queueID);
		   $('#opc_file_imagem').fileUploadStart(queueID);
		},*/
/*					onError: function(event,queueID,fileObj,errorObj){
			alert(errorObj[\"type\"]+\" - \"+errorObj[\"status\"]+\" - \"+errorObj[\"text\"]);
		},*/
		'onComplete': function(imgs,data){
			//$('#PhotoPrev').attr('src','/images/people/'+imgs[0].name +'?d='+ (new Date()).getTime());
			$('#PhotoPrev').attr('src','/images/shop/'+data +'?d='+ (new Date()).getTime());//COMIRON: data - то, что возвращает php
			$('#avatar').attr('src','/images/shop/'+data +'?d='+ (new Date()).getTime());
		}
	});


});
</script>
<div style="clear: both"></div>
