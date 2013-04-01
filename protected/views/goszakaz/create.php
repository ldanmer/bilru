<?php
$this->breadcrumbs=array(
	'Goszakazs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Goszakaz','url'=>array('index')),
	array('label'=>'Manage Goszakaz','url'=>array('admin')),
);
?>

<h1>Create Goszakaz</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>