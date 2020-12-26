<?php
$this->template('/common/header.php', $vars);
?>
<div id="profileInfo" class="blue"><?php
    $this->template('profile/profile_info.php', $vars);
    $date_of_birth_month = date('n', $vars['person']['date_of_birth']);
    $date_of_birth_day = date('j', $vars['person']['date_of_birth']);
    $date_of_birth_year = date('Y', $vars['person']['date_of_birth']);
?></div>
<div id="profileContentWide">
<?php $this->template('profile/topheader.php', $vars); ?>

<div id="editTabs">
  <ul>
  	<li><a href="#basic"><?php echo $this->t('profile','Basic'); ?></a></li>
  	<li><a href="#personal"><?php echo $this->t('profile','Personal'); ?></a></li>
  	<li><a href="#education"><?php echo $this->t('profile','Education'); ?></a></li>
  	<li><a href="#interests"><?php echo $this->t('profile','Interests'); ?></a></li>
  	<li><a href="#work"><?php echo $this->t('profile','Work'); ?></a></li>
  	<li><a href="#cars"><?php echo $this->t('profile','Cars'); ?></a></li>
  	  	<!-- li><a href="#oauth">OAuth</a></li -->
  </ul>

  <div id="basic">
  	<form method="post" enctype="multipart/form-data">
    <div class="form_entry">
	<div class="form_label"><label><?php echo $this->t('profile','Current profile photo'); ?></label></div>
    	<div class="thumb">
    	<table class="markup"><tr><td>
    		<img id="PhotoPrev" src="<?php echo isset($vars['person']['thumbnail_url']) ? $vars['person']['thumbnail_url'] : '/images/people/nophoto.gif'?>" />
    		
    		<div id="queue" style="display:none;"></div>
    	</td><td>&nbsp;</td><td>
    	    <input type="file" name="UploadPhoto" id="UploadPhoto" />
			
		</td></tr></table>		
    	</div>
    		<script>
		$(document).ready(function(){
				
				$('#UploadPhoto').uberuploadcropper({
					//---------------------------------------------------
					// uploadify options..
					//---------------------------------------------------
					/*'uploader'  : '/uberuploadcropper/scripts/uploadify.swf',
					'script'    : '/profile/uploadprofileimg',//?name=<?php echo $_SESSION['id'] ?>',
					'cancelImg' : '/images/cancel.png',
					'multi'     : false,//true
					'auto'      : true,
					'folder'    : '/images/people',
					'fileExt': "*.jpg;*.jpeg;*.gif;*.png",
					'sizeLimit': 2000000,
					*/
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
												'folder'    : '/images/people',
					              },
					'queueID'          : 'queue',
					'uploadScript'    : '/profile/uploadprofileimg',
					'fileSizeLimit' : "<?php echo PartuzaConfig::get('file_upload_size_limit'); ?>",//"2MB",
					'fileType'     : 'image',
//					'displayData': 'percentage',
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

					//---------------------------------------------------
					//now the uber options..
					//---------------------------------------------------
					'iserror': false,
					'folder'    : '/images/people',
					'cropScript': '/profile/cropprofileimg',
					/*'onSelect': function(event,queueID,fileObj){
					   $('#opc_file_imagem').fileUploadSettings('scriptData', '&amp;name='+ queueID);
					   $('#opc_file_imagem').fileUploadStart(queueID);
					},*/
/*					onError: function(event,queueID,fileObj,errorObj){
						alert(errorObj[\"type\"]+\" - \"+errorObj[\"status\"]+\" - \"+errorObj[\"text\"]);
					},*/
					'onComplete': function(imgs,data){ 
						//$('#PhotoPrev').attr('src','/images/people/'+imgs[0].name +'?d='+ (new Date()).getTime()); 
						$('#PhotoPrev').attr('src','/images/people/'+data +'?d='+ (new Date()).getTime());//COMIRON: data - то, что возвращает php
						$('#avatar').attr('src','/images/people/'+data +'?d='+ (new Date()).getTime());
					}
				});
				
			});
		</script>
    </div>	
    
    
  
    <div class="form_entry">
    <div class="form_label"><label for="first_name"><?php echo $this->t('profile','first name'); ?></label></div>
    <input type="text" name="first_name" id="first_name"
    	value="<?php echo isset($vars['person']['first_name']) ? $vars['person']['first_name'] : ''?>" />
    </div>

    <div class="form_entry">
    <div class="form_label"><label for="last_name"><?php echo $this->t('profile','last name'); ?></label></div>
    <input type="text" name="last_name" id="last_name"
    	value="<?php echo isset($vars['person']['last_name']) ? $vars['person']['last_name'] : ''?>" />
    </div>


    <div class="form_entry">
    <div class="form_label"><label for="gender"><?php echo $this->t('profile','gender'); ?></label></div>
    <select name="gender" id="gender">
    	<option value="-">-</option>
    	<option value='FEMALE'
    		<?php echo $vars['person']['gender'] == 'FEMALE' ? ' SELECTED' : ''?>><?php echo $this->t('home','Female'); ?></option>
    	<option value='MALE'
    		<?php echo $vars['person']['gender'] == 'MALE' ? ' SELECTED' : ''?>><?php echo $this->t('home','Male'); ?></option>
    </select></div>

    <div class="form_entry">
    <div class="form_label"><label for="date_of_birth_month"><?php echo $this->t('profile','date of birth'); ?></label></div>
    <input type="text" name="date_of_birth" id="date_of_birth" style="width:100px" />
	</div>

  

  	<div class="form_entry">
    <div class="form_label"><label for="emails"><?php echo $this->t('profile','public emails'); ?></label></div>
    	<textarea name="emails" id="emails"><?php 
    	foreach ($vars['person']['person_emails'] as $email) {
    		echo $email['email']."\n";
    	} 
    	?></textarea>
    </div>
  
    <div class="form_entry">
    <div class="form_label"><label for="phone_numbers"><?php echo $this->t('profile','public phone numbers'); ?></label></div>
    	<textarea name="phone_numbers" id="phone_numbers"><?php 
    	foreach ($vars['person']['person_phone_numbers'] as $phone_number) {
    		echo $phone_number['phone_number']."\n";
    	} 
    	?></textarea>
    </div>
    
    <div class="form_entry">
    <div class="form_label"><label for="urls"><?php echo $this->t('profile','public urls'); ?></label></div>
    	<textarea name="urls" id="urls"><?php 
    	foreach ($vars['person']['person_urls'] as $url) {
    		echo $url['url']."\n";
    	} 
    	?></textarea>
    </div>
    
    <!-- div class="form_entry">
    <div class="form_label"><label for="job"><?php echo $this->t('profile','job'); ?></label></div>
    <input type="text" name="job" id="job"
    	value="<?php echo isset($vars['person']['job']) ? $vars['person']['job'] : ''?>" />
    </div-->

       
    <div class="form_entry">
    <div class="form_label"><label for="nickname"><?php echo $this->t('profile','nickname'); ?></label></div>
    <input type="text" name="nickname" id="nickname"
    	value="<?php echo isset($vars['person']['nickname']) ? $vars['person']['nickname'] : ''?>" />
    </div>
    

    <h3><?php echo $this->t('common','addresses'); ?></h3>
    
    <div class="form_entry">
    <div class="form_label"><label for="country"><?php echo $this->t('profile','Country'); ?></label></div>
    <select name="country_code2" id="country_code2">
	<?php
	foreach($vars['countries'] as $country){ 
		echo "<option value=\"{$country['code2']}\"";
		if($vars['person']['country_code2'] == $country['code2'] ){
			echo " selected ";
		}
		echo ">{$country['name']}</option>";
	}
	?>
	</select>
    </div>
    
    <a href="#"  class="addrCompose" object="people" object_id="<?php echo $vars['person']['id'];?>" id="<?php echo $vars['person']['id'];?>" title="<?php echo $this->t('common', 'Add address') ?>"><img src="/images/b_add.png" alt="<?php echo $this->t('common', 'Add address') ?>">&nbsp;<?php echo $this->t('common', 'Add address') ?></a>
    
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
    
    
   <!--  
    <div class="form_entry">
    <div class="form_label"><label for="city"><?php echo $this->t('profile','City'); ?></label></div>
    <input type="text" name="city" id="city"
    	value="<?php echo isset($vars['person']['city']) ? $vars['person']['city'] : ''?>" />
    </div>
    <div class="form_entry">
    <div class="form_label"><label for="street"><?php echo $this->t('profile','Street'); ?></label></div>
    <input type="text" name="street" id="street"
    	value="<?php echo isset($vars['person']['street']) ? $vars['person']['street'] : ''?>" />
    </div>
   -->
  <div><input type="submit" class="submit btn" value="<?php echo $this->t('profile','save settings'); ?>" /></div>
  </form>  
  
  </div>

  <div id="personal">
    <form method="post" enctype="multipart/form-data">
  
    <div class="form_entry">
    <div class="form_label"><label for="status"><?php echo $this->t('profile','status'); ?></label></div>
    <input type="text" name="status" id="status"
    	value="<?php echo isset($vars['person']['status']) ? $vars['person']['status'] : ''?>" />
    </div>
  
    <div class="form_entry">
    <div class="form_label"><label for="relationship_status"><?php echo $this->t('profile','relationship status'); ?></label></div>
    <select name="relationship_status" id="relationship_status">
    	<option value="-">-</option>
    	<option value="Single"
    		<?php echo $vars['person']['relationship_status'] == 'Single' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Single'); ?></option>
    	<option value="In a relationship"
    		<?php echo $vars['person']['relationship_status'] == 'In a relationship' ? ' SELECTED' : ''?>><?php echo $this->t('profile','In a relationship'); ?></option>
    	<option value="Engaged"
    		<?php echo $vars['person']['relationship_status'] == 'Engaged' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Engaged'); ?></option>
    	<option value="Married"
    		<?php echo $vars['person']['relationship_status'] == 'Married' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Married'); ?></option>
    	<option value="It's complicated"
    		<?php echo $vars['person']['relationship_status'] == 'It\'s complicated' ? ' SELECTED' : ''?>><?php echo $this->t('profile',"It's complicated"); ?></option>
    	<option value="In an open relationship"
    		<?php echo $vars['person']['relationship_status'] == 'In an open relationship' ? ' SELECTED' : ''?>><?php echo $this->t('profile','In an open relationship'); ?></option>
    </select></div>
    
    <div class="form_entry">
    <div class="form_label"><label for="children"><?php echo $this->t('profile','children'); ?></label></div>
    <select name="children" id="children">
    	<option value="-">-</option>
    	<option value="none"
    		<?php echo $vars['person']['children'] == 'none' ? ' SELECTED' : ''?>><?php echo $this->t('common','none'); ?></option>
    					<?php
        for ($children = 1; $children <= 4; $children ++) {
          $sel = $vars['person']['children'] == $children ? ' SELECTED' : '';
          echo "<option value=\"$children\"$sel>$children</option>\n";
        }
        ?>
    	<option value="<?php echo $this->t('profile','more then 4'); ?>"><?php echo $this->t('profile','more then 4'); ?></option>
    </select></div>
    
    <div class="form_entry">
    <div class="form_label"><label for="about_me"><?php echo $this->t('profile','about me'); ?></label></div>
    <textarea name="about_me" id="about_me"><?php echo isset($vars['person']['about_me']) ? $vars['person']['about_me'] : ''?></textarea>
    </div>
    
    <div class="form_entry">
    <div class="form_label"><label for="pets"><?php echo $this->t('profile','pets'); ?></label></div>
    <textarea name="pets" id="pets"><?php echo isset($vars['person']['pets']) ? $vars['person']['pets'] : ''?></textarea>
    </div>
    
    <div class="form_entry">
    <div class="form_label"><label for="job_interests"><?php echo $this->t('profile','job interests'); ?></label></div>
    <textarea name="job_interests" id="job_interests"><?php echo isset($vars['person']['job_interests']) ? $vars['person']['job_interests'] : ''?></textarea>
    </div>
    
    <div class="form_entry">
    <div class="form_label"><label for="political_views"><?php echo $this->t('profile','political views'); ?></label></div>
    <input type="text" name="political_views" id="political_views"
    	value="<?php echo isset($vars['person']['political_views']) ? $vars['person']['political_views'] : ''?>" />
    </div>
    
    <div class="form_entry">
    <div class="form_label"><label for="drinker"><?php echo $this->t('profile','drinker'); ?></label></div>
    <select name="drinker" id="drinker">
    	<option value="-">-</option>
    	<option value='HEAVILY'
    		<?php echo $vars['person']['drinker'] == 'HEAVILY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Heavily'); ?></option>
    	<option value='NO'
    		<?php echo $vars['person']['drinker'] == 'NO' ? ' SELECTED' : ''?>><?php echo $this->t('profile','No'); ?></option>
    	<option value='OCCASIONALLY'
    		<?php echo $vars['person']['drinker'] == 'OCCASIONALLY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Occasionally'); ?></option>
    	<option value='QUIT'
    		<?php echo $vars['person']['drinker'] == 'QUIT' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Quit'); ?></option>
    	<option value='QUITTING'
    		<?php echo $vars['person']['drinker'] == 'QUITTING' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Quitting'); ?></option>
    	<option value='REGULARLY'
    		<?php echo $vars['person']['drinker'] == 'REGULARLY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Regularly'); ?></option>
    	<option value='SOCIALLY'
    		<?php echo $vars['person']['drinker'] == 'SOCIALLY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Socially'); ?></option>
    	<option value='YES'
    		<?php echo $vars['person']['drinker'] == 'YES' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Yes'); ?></option>
    </select></div>

    <div class="form_entry">
    <div class="form_label"><label for="smoker"><?php echo $this->t('profile','smoker'); ?></label></div>
    <select name="smoker" id="smoker">
    	<option value="-">-</option>
    	<option value='HEAVILY'
    		<?php echo $vars['person']['smoker'] == 'HEAVILY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Heavily'); ?></option>
    	<option value='NO'
    		<?php echo $vars['person']['smoker'] == 'NO' ? ' SELECTED' : ''?>><?php echo $this->t('profile','No'); ?></option>
    	<option value='OCCASIONALLY'
    		<?php echo $vars['person']['smoker'] == 'OCCASIONALLY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Occasionally'); ?></option>
    	<option value='QUIT'
    		<?php echo $vars['person']['smoker'] == 'QUIT' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Quit'); ?></option>
    	<option value='QUITTING'
    		<?php echo $vars['person']['smoker'] == 'QUITTING' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Quitting'); ?></option>
    	<option value='REGULARLY'
    		<?php echo $vars['person']['smoker'] == 'REGULARLY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Regularly'); ?></option>
    	<option value='SOCIALLY'
    		<?php echo $vars['person']['smoker'] == 'SOCIALLY' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Socially'); ?></option>
    	<option value='YES'
    		<?php echo $vars['person']['smoker'] == 'YES' ? ' SELECTED' : ''?>><?php echo $this->t('profile','Yes'); ?></option>
    </select></div>
    
    
   <br />
   <div style="margin-left:12px;"><input type="submit" class="submit btn" value="<?php echo $this->t('profile','save settings'); ?>" /></div>
   <br /><br />  
   </form>  
  
    </div>

    
    <div id="work">
        <form method="post" enctype="multipart/form-data">
    
  		<div class="form_entry">
    	<div class="form_label"><label for="job"><?php echo $this->t('profile','job_company'); ?></label></div>
    	<input type="text" name="job" id="job"
	    	value="<?php echo $vars['person']['job']; ?>" />
	    </div>
  	
	  	<br />
    	<div style="margin-left:12px;"><input type="submit" class="submit btn" value="<?php echo $this->t('profile','save settings'); ?>" /></div>
    	<br /><br />  
   		</form>  
  	
  	</div>
    
 
    
    <div id="interests">
        <form method="post" enctype="multipart/form-data">
    
  		<div class="form_entry">
    	<div class="form_label"><label for="doing"><?php echo $this->t('profile','doing'); ?></label></div>
    	<textarea name="doing" id="doing"><?php echo $vars['person']['doing']; ?></textarea>
	    </div>
  	
   
  		<div class="form_entry">
    	<div class="form_label"><label for="interest"><?php echo $this->t('profile','interest'); ?></label></div>
    	<textarea name="interest" id="interest"><?php echo $vars['person']['interests']; ?></textarea>
	    </div>
  	
   
  		<div class="form_entry">
    	<div class="form_label"><label for="music"><?php echo $this->t('profile','music'); ?></label></div>
    	<textarea name="music" id="music"><?php echo $vars['person']['music']; ?></textarea>
	    </div>
  	
   
  		<div class="form_entry">
    	<div class="form_label"><label for="books"><?php echo $this->t('profile','books'); ?></label></div>
    	<textarea name="books" id="books"><?php echo $vars['person']['books']; ?></textarea>
	    </div>
  	
   
  		<div class="form_entry">
    	<div class="form_label"><label for="tv"><?php echo $this->t('profile','tv'); ?></label></div>
    	<textarea name="tv" id="tv"><?php echo $vars['person']['tv']; ?></textarea>
	    </div>
  	
   
  		<div class="form_entry">
    	<div class="form_label"><label for="quote"><?php echo $this->t('profile','quote'); ?></label></div>
    	<textarea name="quote" id="quote"><?php echo $vars['person']['quote']; ?></textarea>
	    </div>
  	
   
  		<div class="form_entry">
    	<div class="form_label"><label for="about"><?php echo $this->t('profile','about'); ?></label></div>
    	<textarea name="about" id="about"><?php echo $vars['person']['about']; ?></textarea>
	    </div>
  	
	  	<br />
    	<div style="margin-left:12px;"><input type="submit" class="submit btn" value="<?php echo $this->t('profile','save settings'); ?>" /></div>
    	<br /><br />  
   		</form>  
  	
  	</div>
  
  <div id="education">
  	<div id="education_list">
	  <?php $this->template('profile/profile_educationlist.php', $vars); ?>
  	</div>
  
    <h3><?php echo $this->t('profile','school'); ?></h3>
  	<form action="/profile/education/add/<?php echo $_SESSION['id'] ?>" method="post" class="education" id="1school">
  	  
	  <?php
	  $vars['type']="1school"; 
	  $this->template('profile/profile_education_addform.php', $vars); 
	  ?> 
  	</form>
  	
  	<h3><?php echo $this->t('profile','college'); ?></h3>
  	<form action="/profile/education/add/<?php echo $_SESSION['id'] ?>" method="post" class="education" id="2college">
  	  <?php
	  $vars['type']="2college"; 
	  $this->template('profile/profile_education_addform.php', $vars); 
	  ?> 
  	</form>
  	
  	<h3><?php echo $this->t('profile','univer'); ?></h3>
  	<form action="/profile/education/add/<?php echo $_SESSION['id'] ?>" method="post" class="education" id="3univer">
  	  <?php
	  $vars['type']="3univer"; 
	  $this->template('profile/profile_education_addform.php', $vars); 
	  ?>  		
  	</form>
  </div>

  
  

  
  <div id="cars">
    <div id="car_list">
	  <?php $this->template('profile/profile_carlist.php', $vars); ?>
  	</div>
  
    <!--div style="margin-left:12px;"><input type="button" id="add-car-button" class="submit btn" value="<?php echo $this->t('common','add'); ?>" /></div-->
  
  	
  	<div id="add-car">
    <!--div class="form_entry"><?php echo $this->t('profile','auto'); ?></div-->
  	<form action="/car/save/<?php echo $_SESSION['id'] ?>" method="post" class="car" id="car">
	  <?php
	  $this->template('profile/profile_addcar.php', $vars); 
	  ?> 
  	</form>
  	</div>
    
  </div>

 
  </div>
  
  </div>
</div>
<script>
$(document).ready(function() {
	$('#editTabs').tabs();

	var d="<?php echo $date_of_birth_day.".".$date_of_birth_month.".".$date_of_birth_year ?>";
	dateParts = d.match(/(\d+)/g);
	realDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); 
	
	$("#date_of_birth").datepicker().datepicker( "option", {
		"dateFormat": "dd.mm.yy",
		"changeYear":true,
		"changeMonth":true,
		"yearRange": "1925:2010" 
	}).datepicker( "setDate", new Date(realDate));
		
});
</script>
<div style="clear: both"></div>
<?php
$this->template('/common/footer.php');
?>