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
	        array('label'=>'Мои заказы', 'url'=>'index', 'active' => true),
	        array('label'=>'Создать заказ', 'url'=>'create'),
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
 	'template' => '{items}{pager}'
)); ?>
