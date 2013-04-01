<?php
$this->breadcrumbs=array(
	'Заказы'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Редактирование',
);
?>

<h1><?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form',array(
		'model'=>$model,
	)); ?>