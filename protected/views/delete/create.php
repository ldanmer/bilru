<?php
$this->breadcrumbs=array(
	'Deletes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Delete','url'=>array('index')),
	array('label'=>'Manage Delete','url'=>array('admin')),
);
?>

<h1>Create Delete</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>