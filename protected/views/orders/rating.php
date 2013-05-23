<?php
$this->breadcrumbs=array(
	'Рейтинг'=>array('index'),
	'Создание',
);
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Отзывы', 'url'=>array('UserRating/view', 'id'=>$model->supplier_id), 'active' => true),
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_rating', array('model'=>$model, 'rating'=>$rating)); ?>