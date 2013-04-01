<?php
$this->breadcrumbs=array(
	'Material Buys'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List MaterialBuy','url'=>array('index')),
	array('label'=>'Create MaterialBuy','url'=>array('create')),
	array('label'=>'View MaterialBuy','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage MaterialBuy','url'=>array('admin')),
);
?>

<h1>Update MaterialBuy <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>