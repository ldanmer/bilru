<?php
$this->breadcrumbs=array(
	'Завершенные заказы',
);

?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти заказ', 'url'=>array('materialBuy/search')),
	        array('label'=>'Активные заказы', 'url'=>array('index')),
	        array('label'=>'Завершенные заказы', 'url'=>array('finished'), 'active' => true),
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_finish',
	'template' => '{items}{pager}'
)); ?>
