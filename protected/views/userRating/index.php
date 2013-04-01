<?php
$this->breadcrumbs=array(
	'User Ratings',
);

$this->menu=array(
	array('label'=>'Create UserRating','url'=>array('create')),
	array('label'=>'Manage UserRating','url'=>array('admin')),
);
?>

<h1>User Ratings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
