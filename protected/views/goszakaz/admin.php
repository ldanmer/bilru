<?php
$this->breadcrumbs=array(
	'Goszakazs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Goszakaz','url'=>array('index')),
	array('label'=>'Create Goszakaz','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('goszakaz-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Goszakazs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'goszakaz-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'start_date',
		'end_date',
		'work_type',
		'object',
		/*
		'object_address',
		'customer',
		'placement',
		'status',
		'material',
		'duration',
		'contact',
		'phone',
		'email',
		'persona',
		'docs',
		'link',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
