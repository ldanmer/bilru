<?php
$this->breadcrumbs=array(
	'By Offers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ByOffer','url'=>array('index')),
	array('label'=>'Create ByOffer','url'=>array('create')),
	array('label'=>'View ByOffer','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ByOffer','url'=>array('admin')),
);
?>

<h1>Update ByOffer <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>