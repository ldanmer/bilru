<?php
$this->breadcrumbs=array(
	'Покупка материалов'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Редактирование',
);
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>