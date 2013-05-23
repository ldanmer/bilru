<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Найти заказ', 'url'=>array('/materialBuy/search'), 'items'=>array(
                    array('label'=>'Строительные материалы', 'url'=>array('/materialBuy/search')),
                    array('label'=>'Отделочные материалы', 'url'=>array('/materialBuy/search')),
                    array('label'=>'Инженерное оборудование', 'url'=>array('/materialBuy/search')),
                )),
        array('label'=>'Купить', 'url'=>array('/materialBuy/create'), 'items'=>array(
                    array('label'=>'Строительные материалы', 'url'=>array('/materialBuy/create')),
                    array('label'=>'Отделочные материалы', 'url'=>array('/materialBuy/create')),
                    array('label'=>'Инженерное оборудование', 'url'=>array('/materialBuy/create')),
                )), /*
        array('label'=>'Оборудование', 'url'=>'#', 'items'=>array(
                    array('label'=>'Купить', 'url'=>'#'),
                    array('label'=>'Продать', 'url'=>'#'),
                    array('label'=>'Арендовать', 'url'=>'#'),
                   	array('label'=>'Сдать в аренду', 'url'=>'#'),
                )), */
        array('label'=>'Вопросы заказчиков', 'url'=>'#'),
        array('label'=>'Форум', 'url'=>'#'),
    ),
)); ?>