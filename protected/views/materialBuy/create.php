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
	    	array('label'=>'Купить', 'url'=>array('materialBuy/create')),
        array('label'=>'Активные покупки', 'url'=>array('materialBuy/index'), 'visible'=>!Yii::app()->user->isGuest),
        array('label'=>'Завершенные покупки', 'url'=>array('materialBuy/finished'), 'visible'=>!Yii::app()->user->isGuest),
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model, 
	'objects' => $objects,
)); ?>