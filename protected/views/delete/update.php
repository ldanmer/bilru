<?php
$this->breadcrumbs=array(
	'Deletes'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Delete','url'=>array('index')),
	array('label'=>'Create Delete','url'=>array('create')),
	array('label'=>'View Delete','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Delete','url'=>array('admin')),
);
?>

<h1>Update Delete <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>