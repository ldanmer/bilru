<?php
/* @var $this ZakupkiController */
/* @var $model Zakupki */

$this->breadcrumbs=array(
	'Zakupkis'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Zakupki', 'url'=>array('index')),
	array('label'=>'Create Zakupki', 'url'=>array('create')),
	array('label'=>'Update Zakupki', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Zakupki', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Zakupki', 'url'=>array('admin')),
);
?>

<h1>View Zakupki #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'organization',
		'placement',
		'price',
		'status',
		'start_date',
		'stop_date',
	),
)); ?>
