<?php
$this->breadcrumbs=array(
	'Deletes',
);

$this->menu=array(
	array('label'=>'Create Delete','url'=>array('create')),
	array('label'=>'Manage Delete','url'=>array('admin')),
);
?>

<h1>Deletes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
