<?php
$this->breadcrumbs=array(
	'By Offers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ByOffer','url'=>array('index')),
	array('label'=>'Manage ByOffer','url'=>array('admin')),
);
?>

<h1>Create ByOffer</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>