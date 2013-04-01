<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,    
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        /* array('name'=>'id', 'header'=>'#'),*/
        array('name'=>'placement', 'header'=>'Способ размещения'),
        array('name'=>'name', 'header'=>'Наименование'),
        array('name'=>'price', 'header'=>'Начальная цена контракта'),
        array('name'=>'status', 'header'=>'Этап/статус размещения'),
        array('name'=>'start_date', 'header'=>'Начало подачи заявок'),
        array('name'=>'stop_date', 'header'=>'Окончание подачи заявок'),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>
