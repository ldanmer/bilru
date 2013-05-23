<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Найти подрядчика', 'url'=>array('/orders/create'),'items'=>array(
                    array('label'=>'Проектирование', 'url'=>array('/orders/create')),
                    array('label'=>'Архитектура', 'url'=>array('/orders/create')),
                    array('label'=>'Дизайн', 'url'=>array('/orders/create')),
                    array('label'=>'Строительные компании', 'url'=>array('/orders/create')),
                    array('label'=>'Бригады', 'url'=>array('/orders/create')),
                    array('label'=>'Мастера', 'url'=>array('/orders/create')),
                )),
        array('label'=>'Купить', 'url'=>array('/materialBuy/create'), 'items'=>array(
                    array('label'=>'Строительные материалы', 'url'=>array('/materialBuy/create')),
                    array('label'=>'Отделочные материалы', 'url'=>array('/materialBuy/create')),
                    array('label'=>'Инженерное оборудование', 'url'=>array('/materialBuy/create')),
                )),
        /*
        array('label'=>'Оборудование', 'url'=>'#', 'items'=>array(
                    array('label'=>'Купить', 'url'=>'#'),
                    array('label'=>'Продать', 'url'=>'#'),
                    array('label'=>'Арендовать', 'url'=>'#'),
                   	array('label'=>'Сдать в аренду', 'url'=>'#'),
                )), */
        array('label'=>'Спросить специалиста', 'url'=>'#'),
        array('label'=>'Форум', 'url'=>'#'),
    ),
)); ?>