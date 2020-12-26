<?php
$date_month = date('n', $vars['order']['date_pickup']);
$date_day = date('j', $vars['order']['date_pickup']);
$date_year = date('Y', $vars['order']['date_pickup']);
?>

<form method="post" action="/shop/orders/save/<?php echo $vars['order_id']?>" id="<?php echo $vars['order_id']?>">
<div class="order_edit">
  <div class="form_entry">
      <div class="form_label"><label for="status"><?php echo $this->t('shop','status'); ?></label></div>
      <select id="orderstatus_id" name="orderstatus_id">
  		<?php 
  			foreach ($vars['orderstatuses'] as $status) {
				echo "<option value=\"{$status['id']}\"";
				if($status['id']==$vars['order']['orderstatus_id']){
					echo " selected ";
				}
				echo ">".$this->t('shop',$status['name'])."</option>";
			}
		?>
  		</select>
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="status"><?php echo $this->t('shop','payed_status'); ?></label></div>
      <select name="ispayed" id="ispayed">
    	<option value='0'
    		<?php echo $vars['order']['ispayed'] == '0' ? ' SELECTED' : ''?>><?php echo $this->t('shop','status_not_payed'); ?></option>
    	<option value='1'
    		<?php echo $vars['order']['ispayed'] == '1' ? ' SELECTED' : ''?>><?php echo $this->t('shop','status_payed'); ?></option>
      </select>
  </div>

  <div class="form_entry">
      <div class="form_label"><label for="body"><?php echo $this->t('shop','Comment'); ?></label></div>
      <textarea name="comment_shop" id="comment_shop" style="height:120px; width:344px"><?php echo $vars['order']['comment_shop']; ?></textarea>
  </div>
 

  <h3><?php $this->t("shop", "delivery parameters") ?></h3>
  <div class="form_entry">
      <div class="form_label"><label for="numpack"><?php echo $this->t('shop','numpack'); ?></label></div>
      <input type="text" name="numpack" id="numpack" style="width:344px" value="<?php echo $vars['order']['numpack']; ?>">
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="weight"><?php echo $this->t('shop','Weight'); ?></label></div>
      <input type="text" name="weight" id="weight" style="width:344px" value="<?php echo $vars['order']['weight']; ?>">&nbsp;<?php echo $this->t('shop', 'kg'); ?>
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="volume"><?php echo $this->t('shop','Volume'); ?></label></div>
      <input type="text" name="volume" id="volume" style="width:344px" value="<?php echo $vars['order']['volume']; ?>">&nbsp;<?php echo $this->t('shop', 'm3'); ?>
  </div>
  <div class="form_entry">
      <div class="form_label"><label for="category"><?php echo $this->t('shop','category'); ?></label></div>
      <input type="text" name="category" id="category" style="width:344px" value="<?php echo $vars['order']['category']; ?>">
  </div>

  <div class="form_entry">
      <div class="form_label"><label for="category"><?php echo $this->t('shop','date pickup'); ?></label></div>
      <input type="text" name="date_pickup" id="date_pickup" style="width:344px" value="<?php echo $vars['order']['date_pickup']; ?>">
  </div>

  <?php if($vars['order']['delivery'] == "dpd"){ ?>
      <div class="form_entry">
          <div class="form_label"><label for="status"><?php echo $this->t('shop','terminal'); ?></label></div>
          <select id="terminal" name="terminal">
          
         
          </select>
      </div>
      <div class="form_entry">
          <div class="form_label"><label for="status"><?php echo $this->t('shop','delivery'); ?></label></div>
          <?php 
          if($vars['order']['deliverytype'] == "todoor"){
              echo "до двери";
          }else if($vars['order']['deliverytype'] == "toterm"){
              echo "до терминала";
          }
          else if($vars['order']['deliverytype'] == "todoor2"){
              echo "до двери PARCEL";
          }else if($vars['order']['deliverytype'] == "toterm2"){
              echo "до терминала  PARCEL";
          }
          ?><br><br>
      </div>

<?php 
      if($vars['order']['deliverytype'] == "todoor" or $vars['order']['deliverytype'] == "todoor2"){
?>
 
      <div class="form_entry">
          <div class="form_label"><label><?php echo $this->t('shop','postalcode'); ?></label></div>
          <input type="text" name="index" id="index" required style="width:344px" value="<?php echo $vars['order']['postalcode']; ?>">
      </div>
      <div class="form_entry">
          <div class="form_label"><label><?php echo $this->t('shop','city'); ?></label></div>
          <input type="text" name="dpdcity" id="dpdcity" required style="width:344px" value="<?php echo $vars['order']['city']; ?>">
      </div>
      <div class="form_entry">
          <div class="form_label"><label><?php echo $this->t('shop','street'); ?></label></div>
          <select name="dpdstreetprefix" id="dpdstreetprefix">
              <option value="ул.">ул.</option>
              <option value="пр.">пр.</option>
              <option value="пл.">пл.</option>
              <option value="пер.">пер.</option>
              <option value="б.">б.</option>
              <option value="наб.">наб.</option>
              <option value="мкр.">мкр.</option>
              <option value="туп.">туп.</option>
          </select>
          <input type="text" name="dpdstreet" id="dpdstreet" required value="<?php echo $vars['order']['dpdstreet']; ?>">
      </div>
      <div class="form_entry">
          <div class="form_label"><label><?php echo $this->t('shop','house'); ?></label></div>
          <input type="text" name="dpdhouse" required id="dpdhouse" value="<?php echo $vars['order']['dpdhouse']; ?>" placeholder="<?php echo $this->t('shop','house'); ?>">
          <input type="text" name="dpdkorpus" id="dpdkorpus" value="<?php echo $vars['order']['dpdkorpus']; ?>" placeholder="<?php echo $this->t('shop','korpus'); ?>">
          <input type="text" name="dpdstroenie" id="dpdstroenie" value="<?php echo $vars['order']['dpdstroenie']; ?>" placeholder="<?php echo $this->t('shop','stroenie'); ?>">
          <input type="text" name="dpdvladenie" id="dpdvladenie" value="<?php echo $vars['order']['dpdvladenie']; ?>" placeholder="<?php echo $this->t('shop','vladenie'); ?>">
      </div>
       <div class="form_entry">
          <div class="form_label"><label><?php echo $this->t('shop','flat or office'); ?></label></div>
          <input type="text" name="dpdoffice" id="dpdoffice" value="<?php echo $vars['order']['dpdoffice']; ?>" placeholder="<?php echo $this->t('shop','flat'); ?>">
          <input type="text" name="dpdflat" id="dpdflat" value="<?php echo $vars['order']['dpdflat']; ?>" placeholder="<?php echo $this->t('shop','office'); ?>">
      </div>

<?php        
      }
?>      
      <div class="form_entry">
          <div class="form_label"><label for="status"><?php echo $this->t('shop','city'); ?></label></div>
          <?php 
          echo $vars['order']['dpdcity']; 
          ?><br><br>
      </div>

  <?php } ?>

 <div class="form_entry">
    <div class="form_label"></div>
    <button type="submit" id="order_save" class="btn submit"><?php echo $this->t('common','save'); ?></button>
    <button id="compose_cancel" id="cancel" class="btn btncancel"><?php echo $this->t('common','cancel'); ?></button>
  </div>

  
</div>
</form>

<?php if($vars['order']['delivery'] == "dpd"){ ?>
  
<script>
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
        if(v['terminalCode'] == "<?php echo $vars['order']['terminal'] ?>"){
          option += "  selected";
        }
        else if(v.address.cityName == "<?php echo $vars['order']['city'] ?>"){
          console.log(v.address.cityName);
          option += " selected";
        }
        option += ">"+v['terminalName']+"</option>";
        $("#terminal").append(option);
      });
    });
</script>
<?php } ?>

<script>
  <?php if($vars['order']['date_pickup']){ // если не задана дата отправки, то сегодня ?>
  var d="<?php echo $day_day.".".$date_month.".".$date_year ?>";
  dateParts = d.match(/(\d+)/g);
  realDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); 
  <?php } else { ?>
  realDate = new Date();
  <?php } ?>

  nowData = new Date();
  
  $("#date_pickup").datepicker().datepicker( "option", {
    "dateFormat": "dd.mm.yy",
    "changeYear":true,
    "changeMonth":true,
    "yearRange": nowData.getFullYear()+":2020" 
  }).datepicker( "setDate", new Date(realDate));
</script>


