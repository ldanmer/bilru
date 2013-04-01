<?php
$this->breadcrumbs=array(
	'User Ratings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserRating','url'=>array('index')),
	array('label'=>'Create UserRating','url'=>array('create')),
	array('label'=>'View UserRating','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UserRating','url'=>array('admin')),
);
?>

<h1>Update UserRating <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>