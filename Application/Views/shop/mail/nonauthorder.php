<html>

<head>
</head>
<body>
    <div style=" 
                justify-content:center;
                background-color: #fff;">
        <div style="
                    
                    border-radius: 4px;
                    border: 1px solid black;
    padding: 12px;                
                    ">
            <div style="background-color: #fafbfc; display:flex; flex-flow:row;justify-content: space-between;">
                <div>
                    <h3 style="margin-right: 15px;">
                        <?php echo $vars['info']->firstname."\n";  echo $vars['info']->lastname."\n"; ?>
                        </h1>
                </div>
                <br>
                <div style="margin-left:auto">
                    <span><?php 


// Первым шагов устанавливаем требуемый нам язык локализации.
setlocale(LC_TIME, 'ru_RU.UTF-8');
// Создаем объект класса DateTime с заданной датой.
$date_ = new DateTime($date);
// Изменяем формат даты на unixtime
$date_formated  = $date_->format('U');
// Выводим отформатированную дату на нужном языке
echo strftime('%H:%M %d\%m\%Y ', $date_formated);
                    ?></span>
                </div>
            </div>
            <br>
            <div style="display:flex; flex-flow:row; font-size: 20px;">
                <div style="font-weight: bold;margin-right: 15px;font-weight: bold;">Сумма:</div>
                <?php echo $vars['info']->sum."\n"; ?>
            </div>
            <div style="display:flex; flex-flow:row;">
                <div style="font-weight: bold;margin-right: 15px;font-weight: bold;">Контактное лицо:</div>
                <?php echo $vars['info']->firstname."\n";  echo $vars['info']->lastname."\n"; ?>
            </div>
            <div style="display:flex; flex-flow:row;">
                <div style="font-weight: bold;margin-right: 15px;font-weight: bold;">Контактный телефон:</div>
                <?php echo $vars['info']->phone."\n"; ?>
            </div>
            <div style="display:flex; flex-flow:row;">
                <div style="font-weight: bold;margin-right: 15px;font-weight: bold;">Адрес доставки: </div>
                <?php echo $vars['info']->adress."\n"; ?>
            </div>

            <div style="display:flex; flex-flow:row;">
                <div style="font-weight: bold;margin-right: 15px;font-weight: bold;">Контактное лицо:</div>
                <?php echo $vars['info']->firstname."\n"; ?>
            </div>
        </div>
        <br>


        <div style="  background-color: #fff; ">
            <div style="display:flex; flex-flow:row; margin-bottom:30px;border-bottom:1px solid #eee;     height: 50px;
    line-height: 50px;">
                <div style="margin-right: 10px; width: 150px;font-weight: bold">
                    Фото с ссылкой
                </div>
                <div style="margin-right: 10px;width: 150px;font-weight: bold">
                    Наименование
                </div>
                <div style="margin-right: 10px;width: 150px;font-weight: bold">
                    Количество
                </div>
                <div style="margin-right: 10px;width: 150px;font-weight: bold">
                    Цена
                </div>
                <div style="margin-right: 10px;width: 150px;font-weight: bold">
                    Сумма
                </div>
            </div>

            <br>
            <?php foreach ($vars['product'] as $value):?>


            <div style="display: flex;
                        flex-flow: row; margin-bottom: 15px; background-color: #fff; border-bottom:1px solid #eee">
                <div style="margin-right: 10px;width: 150px;
    overflow: hidden;
    height: 100px;
    line-height: 100px;">
                    <a href="https://comiron.com/shop/product/<?php  echo $value['id']." \n ";?>">
                        <img style="max-height: 100px;
                            max-width: 100px;" src="http://comiron.com<?php  echo $value['photo_url']." \n ";?>">
                    </a>
                </div>

                <div style="margin-right: 10px;width: 150px;
    overflow: hidden;
    height: 100px;
    line-height: 100px;">
                    <?php  echo $value['name']."\n";?>
                </div>
                <!-- <div style="margin-right: 10px;"> </div> -->
                <div style="margin-right: 10px;width: 150px;
    overflow: hidden;
    height: 100px;
    line-height: 100px;">
                    <?php  echo $value['num']."\n";?>
                </div>
                <div style="margin-right: 10px;width: 150px;
    overflow: hidden;
    height: 100px;
    line-height: 100px;">
                    <?php  echo $value['price']."\n";?>
                </div>
                <div style="margin-right: 10px;width: 150px;
    overflow: hidden;
    height: 100px;
    line-height: 100px;">
                    <?php  echo $value['sum']."\n";?>
                </div>
            </div>
            <br>
            <?php endforeach; ?>

        </div>
    </div>

</body>

</html>