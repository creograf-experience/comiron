<div id="delivery">
  <?php if($vars['shop']['deliverydpdru']){ ?>
    <div class="header"><?php echo $this->t('shop', 'Box size'); ?></div>
    <div class="boxsize">
      <input type="hidden" name="volume" id="volume" value="<?php echo $cart['volume']?>">
      <table class="markup">
        <tr>
          <td><?php echo $this->t('shop', 'Weight'); ?></td>
          <td><input type="text" name="weight" id="weight" value="<?php echo $cart['weight']?>"> <?php echo $this->t('shop', 'kg'); ?></td>
          <td><?php echo $this->t('shop', 'Width'); ?></td>
          <td><input type="text" name="w" id="w" value="<?php echo $cart['w']?>"> <?php echo $this->t('shop', 'cm'); ?></td>
          <td><?php echo $this->t('shop', 'Height'); ?></td>
          <td><input type="text" name="h" id="h" value="<?php echo $cart['h']?>"> <?php echo $this->t('shop', 'cm'); ?></td>
          <td><?php echo $this->t('shop', 'Depth'); ?></td>
          <td><input type="text" name="d" id="d" value="<?php echo $cart['d']?>"> <?php echo $this->t('shop', 'cm'); ?></td>
          <td><a href="#" class="update"></a></td>
        </td>
      </table>
    </div>
  <?php } ?>

  <div class="deliveryblock">
    <div class="header"><?php echo $this->t('shop', 'Delivery'); ?></div>
    <input type="hidden" name="pickup_address" value="<?php echo $vars['shop_addresses'][0]['id'] ?>">

    <?php
    if($_REQUEST['hermes_id']){
    ?>
    <p>Выбран способ доставки Hermes DPD, пункт выдачи номер <?php echo $_REQUEST['hermes_id'];?>.</p>
    <?php
    }
    ?>



    <input type="hidden" name="deliverycost" id="deliverycost" value="0">
    <!--p><?php echo $this->t("shop", "Choose delivery type"); ?></p-->

    <!--label for="myself"><input type="radio" name="delivery" value="myself" id="myself"><?php echo $this->t("shop", "delivery by myself") ?></label>
    <label for="comiron"><input type="radio" checked name="delivery" value="comiron" id="comiron"><?php echo $this->t("shop", "delivery by comiron") ?>: <a href="http://logistic.comiron.com/" target="_blank">logistic.comiron.com</a></label-->


    <?php if($vars['shop']['deliverydpdru'] == '1'){ ?>
        <label>
          <input type="radio" name="delivery" value="dpd">
          <img src="/images/del_dpd.png">
          <span><?php echo $this->t("shop", "DPD") ?></span>
        </label>
    <?php } ?>

    <?php if($vars['shop']['deliveryhermesru'] == '1'){ ?>
        <label>
          <input type="radio" name="delivery" value="hermes">
          <img src="/images/del_hermes.png">
          <span><?php echo $this->t("shop", "Hermes") ?></span>
        </label>
    <?php } ?>

    <?php
     if($vars['shop']['deliveryrupost'] == '1'){ ?>
      <label>
        <input type="radio" name="delivery" value="russiapost">
        <img src="/images/del_post.png">
        <span><?php echo $this->t("shop", "Russian post") ?></span>
      </label>
    <?php } ?>
    <!-- <label><input type="radio" checked name="delivery" value="chinapost"> <img src="/images/del_china.png"><span><?php echo $this->t("shop", "China post") ?></span></label>
    <label><input type="radio" checked name="delivery" value="hermes"> <img src="/images/del_hermes.png"><span><?php echo $this->t("shop", "Hermes") ?></span></label  -->
    <?php if($vars['shop']['deliverycourier'] == '1'){ ?>
      <label>
        <input type="radio" name="delivery" checked value="kurer">
        <img src="/images/del_kurer.png">
        <span><?php echo $this->t("shop", "Courier") ?></span>
      </label>
    <?php } ?>
    <?php if($vars['shop']['deliverymanager'] == '1'){ ?>
      <label>
        <input type="radio" name="delivery" checked value="manager">
        <img src="/images/del_manager.png">
        <span><?php echo $this->t("shop", "delivery_manager") ?></span>
      </label>
    <?php } ?>
  </div>
  <br><br>
  <div id="dpdcalc">
     <input type="text" name="q" class="dpdcity" placeholder="Введите название Вашего города" />
     <input type="hidden" name="cityid" class="cityid" value="">

     <div class="calcresult">
        <div class="toterm">
          <input type="radio" class="dpddeliverytype" name="dpddeliverytype" value="toterm" checked> Доставка до терминала:
           <span class="sum"></span> рублей</div>
        <div class="todoor">
          <input type="radio" class="dpddeliverytype" name="dpddeliverytype" value="todoor"> Доставка до двери:
          <span class="sum"></span> рублей</div>
        <div class="toterm2">
          <input type="radio" class="dpddeliverytype" name="dpddeliverytype" value="toterm2"> Доставка до терминала, тариф PARCEL:
           <span class="sum"></span> рублей</div>
        <div class="todoor2">
          <input type="radio" class="dpddeliverytype" name="dpddeliverytype" value="todoor2"> Доставка до двери, тариф PARCEL:
          <span class="sum"></span> рублей</div>
     </div>
  </div>

  <div id="hermesmap">
    <iframe src="http://pschooser.hermes-dpd.ru/?OrderId=<?php echo $vars['cartdelivery_id']; ?>&BUId=2767&McUrl=http%3A%2F%2Fcomiron.com%2Fshop%2Fcartdelivery%3FOrderId%3D%7BOrderId%7D%26PSId%3D%7BPSID%7D" style="width: 680px; height: 600px"></iframe>
  </div>
  <!--http://pschooser.hermes-dpd.ru/?OrderId=1&BUID=1000&mcurl=https%3A%2F%2Fwww.google.fr%2Fwebhp%3Fhl%3Dfr%23hl%3Dfr%26q%3Dhermes%2Bdpd%26psid%3D%7BPSID%7D%26orderId%3D%7BOrderId%7D%20 
   http://comiron.com/cartdelivery?OrderId=[номер заказа]&PSId=[номер пункта выдачи]-->

  <div id="delivery_address">
    <div class="header"><?php echo $this->t('shop', 'Delivery address'); ?></div>

    <a href="#"  class="addrCompose" object="people" object_id="<?php echo $vars['person']['id'];?>" id="<?php echo $vars['person']['id'];?>" title="<?php echo $this->t('common', 'Add address') ?>"><img src="/images/b_add.png" alt="<?php echo $this->t('common', 'Add address') ?>">&nbsp;<?php echo $this->t('common', 'Add address') ?></a>

      <table>
      <?php
      if(!empty($vars['addresses'])){
        foreach($vars['addresses'] as $adr){
    ?>
      <tr>
      <td>
        <input type="radio" checked name="address" class="address"
          data-zip="<?php echo $adr['postalcode'] ?>"
          data-city="<?php echo $adr['city']?>"
          value="<?php echo $adr['id']?>"
        >
        <?php echo $adr['addrstring']?>
      </td>
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
      <br><br>
    <div class="text">
    <p><?php echo $this->t("shop", "give us your contact phone"); ?></p>
    <input type="phone" required name="phone" value="<?php if(isset($vars['person']['phone'])) echo $vars['person']['phone']; ?>">
    </div>


  </div>

</div>



<script>
  var runningRequest;


  function setCost(cost) {
    console.log(cost);
    if(isNaN(cost)){  cost = 0; }
    //компенсация за доставку
    var comp = 0;
    <?php 
    if (isset($vars['shop']['deliverycomp']) && $vars['shop']['deliverycomp']>0 ){
      $vars['shop']['deliverycomp'] = str_replace(",",".",$vars['shop']['deliverycomp']);
      echo "comp = ".$vars['shop']['deliverycomp'].";";
    } 
    ?>

    cost = +cost || 0;
    var sum = +($("#sum_RUR").html());
    comp = sum * comp / 100;
    if(comp > cost){
      cost = 0;
    }else{
      cost -= comp;
    }
    console.log("Стоимость с учетом компенсации "+cost);
    console.log("Компенсация за доставку "+comp);
    
    sum += cost;
    //округлить
    cost = Math.round(cost*10)/10;
    sum = Math.round(sum*10)/10;

    $("#deliverycost").val(cost);
    $("span.delivery").html(cost);
    $("span.delivery_sum").html(sum);
  }

  function setCostDpd(cost) {
    setCost(cost);
    $(".toterm").show();
    console.log(cost);
    if(isNaN(cost)) { cost = "Невозможно рассчитать доставку"; }
    $(".toterm .sum").html(cost);
  }

  function setCostDpd2Door(cost) {
    
    setCost(cost);
    $(".todoor").show();
    console.log(cost);
    if(isNaN(cost)) { cost = "Невозможно рассчитать доставку"; }
    $(".todoor .sum").html(cost);
  }

  function setCostDpd2(cost) {
    setCost(cost);
    $(".toterm2").show();
    console.log(cost);
    if(isNaN(cost)) { cost = "Невозможно рассчитать доставку"; }
    $(".toterm2 .sum").html(cost);
  }

  function setCostDpd2Door2(cost) {
    
    setCost(cost);
    $(".todoor2").show();
    console.log(cost + " dpd2");
    if(isNaN(cost)) { cost = "Невозможно рассчитать доставку"; }
    $(".todoor2 .sum").html(cost);
  }
  
  function enableSpinner() {
    $("span.delivery")
      .html('<img id="imgcode" src="/images/loader.gif">');
  }

  function disableSpinner() {
    $("span.delivery").html('0');
  }

  function calcdpd(data, next) {
    $.ajax({
      url: "/dpdru/calc",
      method: "POST",
      data: data,
      success: setCostDpd,
      beforeSend: enableSpinner
    });

    $.ajax({
      url: "/dpdru/calc2door",
      method: "POST",
      data: data,
      success: setCostDpd2Door,
      beforeSend: enableSpinner
    });

    $.ajax({
      url: "/dpdru/calc2",
      method: "POST",
      data: data,
      success: setCostDpd2,
      beforeSend: enableSpinner
    });

    return $.ajax({
      url: "/dpdru/calc2door2",
      method: "POST",
      data: data,
      success: setCostDpd2Door2,
      beforeSend: enableSpinner,
      /*fail: function( jqXHR, textStatus, errorThrown){
        console.log(" fail "+textStatus);
      },*/
    });

  }

  function calcrupost(data, next) {
    return $.ajax({
      url: "/rupost/calc",
      method: "POST",
      data: data,
      success: setCost,
      beforeSend: enableSpinner
    });
  }

  var calcdelivery = function (e){

    var deliveryMethod = $("#delivery input[name=delivery]:checked").attr("value");

    if(!deliveryMethod) return;

    $(".toterm").hide();
    $(".todoor").hide();
    

    if(runningRequest) {
      runningRequest.abort();
      disableSpinner();
    }

    if(!"<?php echo $vars['shop']['city'] ?>") return; //город магазина

    var data = {
      'deliverycity' : $("input.address:checked").data("city"),
      'pickupcity' : "<?php echo $vars['shop']['city'] ?>",
      'deliveryzip': $("input.address:checked").data("zip"),
      'pickupzip': "<?php echo $vars['shop_addresses'][0]['postalcode'] ?>",
      'weight' : $("#weight").attr("value"),          // вес отправки
      'volume' : $("#volume").attr("value"),          // вес отправки
      'w' : $("#w").attr("value"),
      'h' : $("#h").attr("value"),
      'd' : $("#d").attr("value"),
      'declaredValue' : $(".sum .sum span").html(), //ценность
      'cityid': $(".cityid").attr("value"), //cityid для dpd
    };

    console.log(data);
    if (deliveryMethod != 'dpd'){
    	$(".dpdcity").hide();
    }
    if (deliveryMethod != 'hermes'){
      $("#hermesmap").hide();
    }

    if (deliveryMethod === 'dpd' && $(".cityid").attr("value")) {
      runningRequest = calcdpd(data);
    } else if (deliveryMethod === 'dpd' && !$(".cityid").attr("value")){
      $(".dpdcity").show();
    } else if (deliveryMethod === 'russiapost') {
      runningRequest = calcrupost(data);
    } else if (deliveryMethod === 'hermes'){
      $("#hermesmap").show();
    } else {
      setCost(0);
    }

  }

  $(document).ready(function(){
    //show/hide input for contact phone
    $("#myself").click(function(){
      if($("#myself").prop("checked")){
        $("#delivery .text").slideUp();
      }
    });

    $("#comiron").click(function(){
      if($("#comiron").prop("checked")){
        $("#delivery .text").slideDown();
      }
    });



  });
 // $(".boxsize input").bind("input", calcdelivery);
 // $(".boxsize input").bind("keyup", calcdelivery);
  $("#delivery input[name=delivery]").click(calcdelivery);
  $(".boxsize .update").click(calcdelivery);


</script>


<!-- autocomplit dpd -->
<script type="text/javascript" src="/js/jquery.autocomplete.min.js"></script>
<script>
$(document).ready(function(){

  //dpd выбор способа доставки до двери или до терминала
  $(".dpddeliverytype").change(function(){
    
    var dpdtype = $('input.dpddeliverytype:checked').val();  
    var deliveryprice = 0;
 
    // до терминала
    if (dpdtype == "toterm"){
      deliveryprice = $(".toterm .sum").text();
    }

    // до двери
    if (dpdtype == "todoor"){
      deliveryprice = $(".todoor .sum").text();
    }

    // до терминала2
    if (dpdtype == "toterm2"){
      deliveryprice = $(".toterm2 .sum").text();
    }

    // до двери2
    if (dpdtype == "todoor2"){
      deliveryprice = $(".todoor2 .sum").text();
    }
    setCost(deliveryprice);
  });

  // подсказка при вводе городов
  $('.dpdcity').autocomplete({
    serviceUrl: '/dpdru/citysearch', // Страница для обработки запросов автозаполнения
    minChars: 3, // Минимальная длина запроса для срабатывания автозаполнения
    delimiter: /(,|;| )\s*/, // Разделитель для нескольких запросов, символ или регулярное выражение
    maxHeight: 400, // Максимальная высота списка подсказок, в пикселях
    width: 500, // Ширина списка
    zIndex: 9999, // z-index списка
    deferRequestBy: 0, // Задержка запроса (мсек), на случай, если мы не хотим слать миллион запросов, пока пользователь печатает. Я обычно ставлю 300.
    //params: { country: 'Yes'}, // Дополнительные параметры
    /*transformResult: function(response, originalQuery) {
      return {
            suggestions: $.map(response.myData, function(dataItem) {
                return { value: dataItem.valueField, data: dataItem.dataField };
            })
        };
    },*/
    onSelect: function(data, value){ 
      //data = cityId
      //console.log(data.data);
      //рассчитать стоимость
      $(".cityid").attr("value", data.data);
      calcdelivery();


    }, // Callback функция, срабатывающая на выбор одного из предложенных вариантов,
    //lookup: ['Москва', 'Санкт-Петербург', 'Екатеринбург', "Челябинск"] // Список вариантов для локального автозаполнения
});

});
</script>

