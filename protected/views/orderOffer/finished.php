<?php
$this->breadcrumbs=array(
	'Мои подряды',
); 
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти подряд', 'url'=>array('orders/search')),
	        array('label'=>'Мои подряды', 'url'=>array('orderOffer/index')),
	        array('label'=>'Завершенные подряды', 'url'=>array('orderOffer/finished')),
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_finish',
	'template' => '{items}{pager}'
)); ?>