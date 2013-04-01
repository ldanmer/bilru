<?php
$this->breadcrumbs=array(
	'Goszakazs',
);

$this->menu=array(
	array('label'=>'Create Goszakaz','url'=>array('create')),
	array('label'=>'Manage Goszakaz','url'=>array('admin')),
);
?>

<h1>Goszakazs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
