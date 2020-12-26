<?php
// фильтр по товарам

if (isset($vars['filter']['properties']) and $vars['filter']['maxprice']>0) {
  echo "<div class=\"header\">".$this->t('shop','Filter')."</div><div class=\"body clearfix\">";
?>
<form action="/shop/filter" method="get" id="filterCheck">
<?php
  echo '<input type="hidden" name="shop_id" value="'.$vars['shop']['id'].'">';
  if(isset($vars['group']['id'])){
    echo '<input type="hidden" name="group_id" value="'.$vars['group']['id'].'">';
  }
  if(isset($vars['searchproduct']['name'])){
    echo '<input type="hidden" name="name" value="'.$vars['searchproduct']['name'].'">';
  }
  if(isset($vars['searchproduct']['category_id'])){
    echo '<input type="hidden" name="category_id" value="'.$vars['searchproduct']['category_id'].'">';
  }

?>
<?php
  foreach($vars['filter']['properties'] as $prop){
    echo '<div class="property-group"><div class="property-title">'.$prop['name'].'</div>';
    foreach($prop['values'] as $value){
      echo '  <input type="checkbox" class="filter" name="p.'.$prop['property_id'].'.'.$value['value'].'"';
      if($_REQUEST['p_'.$prop['property_id'].'_'.$value['value']]){
        echo ' checked ';
      }
      echo 'value="'.$value['value'].'">'.$value['value'].'<br>';
    }
    echo '</div>';
  }
?>


  <div class="property-title">Цена</div>
  <div class="price-range range-b">

                                            <span class="s-separate">от</span>

                                            <span class="cost1 s-inp">
                                                <input class="pole min-price" type="text" name="minprice" id="minprice" value="<?php echo $vars['filter']['minprice'];?>">
                                            </span>

                                            <span class="s-separate">до</span>

                                            <span class="cost2 s-inp">
                                                <input class="pole max-price" type="text" name="maxprice" id="maxprice" value="<?php echo $vars['filter']['maxprice'];?>">
                                            </span>
                      <br>
                                            <!--div class="range-wrap">
                                                <div id="price-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 100%;"></a></div>
                                            </div-->
                                        </div>

<!--
    <div class="property-title">Сортировка</div>
<div class="sort">
<select name="OrderBy" class="OrderBy" placeholder="сортировать по" id="sortSelect">
  <option  value="issklad desc, isphoto desc, name">Наименование товара</option>
  <option  value="issklad desc, isphoto desc, price">Цена по возрастанию</option>
  <option  value="issklad desc, isphoto desc, price desc">Цена по убыванию</option>
  <option  value="issklad desc,isphoto desc, code">Код по возрастанию</option>
  <option  value="issklad desc,isphoto desc, code desc">Код по убыванию</option>
  <option  value="issklad desc,isphoto desc, code desc">Последнее поступление</option>
  <option  value="issklad desc,isphoto desc, ispostavka desc, code desc">Сначала прямые поставки</option>
  <option  value="issklad desc,isphoto desc, ismarka desc, code desc">Сначала товары партнеров</option>
</select>
-->
  <button type="submit" name="update" id="buttonSubmitFilter" class="b_update"></button>

</form></div>

<?php
} 
?> 