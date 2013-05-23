<?php
$this->breadcrumbs=array(
	'Активные заказы',
);

?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти заказ', 'url'=>array('materialBuy/search')),
	        array('label'=>'Активные заказы', 'url'=>array('index'), 'active' => true),
	        array('label'=>'Завершенные заказы', 'url'=>array('finished')),
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template' => '{items}{pager}'
)); ?>
