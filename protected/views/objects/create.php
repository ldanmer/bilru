<?php
$this->breadcrumbs=array(
	'Objects'=>array('index'),
	'Create',
);

?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Мои заказы', 'url'=>'index'),
	        array('label'=>'Создать заказ', 'url'=>'create', 'active' => true),
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	
	)); ?>