<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>'Найти заказ', 'url'=>'#'),
        array('label'=>'Купить', 'url'=>'#', 'items'=>array(
                    array('label'=>'Строительные материалы', 'url'=>'#'),
                    array('label'=>'Отделочные материалы', 'url'=>'#'),
                    array('label'=>'Инженерное оборудование', 'url'=>'#'),
                )),/*
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