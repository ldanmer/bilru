<?php
$this->breadcrumbs=array(
	'Objects'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Objects','url'=>array('index')),
	array('label'=>'Create Objects','url'=>array('create')),
	array('label'=>'View Objects','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Objects','url'=>array('admin')),
);
?>

<h1>Update Objects <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>