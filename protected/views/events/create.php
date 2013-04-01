<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'События'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'List Events', 'url'=>array('index')),
	array('label'=>'Manage Events', 'url'=>array('admin')),
);
?>

<h2>Создать событие</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>