<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Найти подряд', 'url'=>array('/orders/search')),
        array('label'=>'Разместить заказ', 'url'=>array('/orders/create'), 'items'=>array(
                    array('label'=>'Проектирование', 'url'=>array('/orders/create')),
                    array('label'=>'Архитектура', 'url'=>array('/orders/create')),
                    array('label'=>'Дизайн', 'url'=>array('/orders/create')),
                    array('label'=>'Строительные компании', 'url'=>array('/orders/create')),
                )),
        array('label'=>'Нанять', 'url'=>'#', 'items'=>array(
                    array('label'=>'Бригаду', 'url'=>'#'),
                    array('label'=>'Рабочего', 'url'=>'#'),
                )),
        array('label'=>'Купить', 'url'=>array('/materialBuy/create'), 'items'=>array(
                    array('label'=>'Строительные материалы', 'url'=>array('/materialBuy/create')),
                    array('label'=>'Отделочные материалы', 'url'=>array('/materialBuy/create')),
                    array('label'=>'Инженерное оборудование','url'=>array('/materialBuy/create')),
                )),
        array('label'=>'Оборудование', 'url'=>'#', 'items'=>array(
                    array('label'=>'Купить', 'url'=>'#'),
                    array('label'=>'Продать', 'url'=>'#'),
                    array('label'=>'Арендовать', 'url'=>'#'),
                   	array('label'=>'Сдать в аренду', 'url'=>'#'),
                )),
        array('label'=>'Вопросы заказчиков', 'url'=>'#'),
        array('label'=>'Форум', 'url'=>'#'),
    ),
)); ?>