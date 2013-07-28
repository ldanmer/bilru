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
	        array('label'=>'Мои заказы', 'url'=>array('orders/index'), 'visible'=>!Yii::app()->user->isGuest),
	        array('label'=>'Создать заказ', 'url'=>array('orders/create')),
	        array('label'=>'Завершенные заказы', 'url'=>array('orders/finished'), 'visible'=>!Yii::app()->user->isGuest),
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'objects' => $objects,
)); ?>
