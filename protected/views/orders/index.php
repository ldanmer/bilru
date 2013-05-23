<?php
$this->breadcrumbs=array(
	'Заказы',
);
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Мои заказы', 'url'=>array('orders/index'), 'active' => true),
	        array('label'=>'Создать заказ', 'url'=>array('orders/create')),
	        array('label'=>'Завершенные заказы', 'url'=>array('orders/finished')),
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
 	'template' => '{items}{pager}'
)); ?>
