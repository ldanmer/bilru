<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	'Создание',
);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Мои заказы', 'url'=>array('orders/index')),
	        array('label'=>'Создать заказ', 'url'=>array('orders/create'), 'active' => true),
	        array('label'=>'Завершенные заказы', 'url'=>array('orders/finished')),
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'objects' => $objects,
)); ?>
