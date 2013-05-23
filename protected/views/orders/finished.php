<?php
$this->breadcrumbs=array(
	'Список заказов',
);
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Мои заказы', 'url'=>array('orders/index')),
	        array('label'=>'Создать заказ', 'url'=>array('orders/create')),
	        array('label'=>'Завершенные заказы', 'url'=>array('orders/finished'), 'active' => true),
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_finish',
	'template' => '{items}{pager}'
)); ?>
