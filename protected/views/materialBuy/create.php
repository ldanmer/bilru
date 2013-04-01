<?php
$this->breadcrumbs=array(
	'Покупки'=>array('index'),
	'Создание заказа',
);
?>


<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	    	array('label'=>'Купить', 'url'=>'create', 'active' => true),
        array('label'=>'Активные покупки', 'url'=>'index'),
        array('label'=>'Завершенные покупки', 'url'=>'finished'),
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'objects' => $objects,
)); ?>