<?php
/* @var $this ZakupkiController */
/* @var $model Zakupki */

$this->breadcrumbs=array(
	'Zakupkis'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Zakupki', 'url'=>array('index')),
	array('label'=>'Manage Zakupki', 'url'=>array('admin')),
);
?>

<h1>Create Zakupki</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>