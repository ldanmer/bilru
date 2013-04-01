<?php
/* @var $this ZakupkiController */
/* @var $model Zakupki */

$this->breadcrumbs=array(
	'Zakupkis'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Zakupki', 'url'=>array('index')),
	array('label'=>'Create Zakupki', 'url'=>array('create')),
	array('label'=>'View Zakupki', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Zakupki', 'url'=>array('admin')),
);
?>

<h1>Update Zakupki <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>