<?php
$this->breadcrumbs=array(
	'By Offers',
);

$this->menu=array(
	array('label'=>'Create ByOffer','url'=>array('create')),
	array('label'=>'Manage ByOffer','url'=>array('admin')),
);
?>

<h1>By Offers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
