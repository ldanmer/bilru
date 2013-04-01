<?php
$this->breadcrumbs=array(
	'Подряд'=>array('index'),
	'Поиск',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.filter-form').toggle();
		$(this).text('Показать');
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('orders-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти заказ', 'url'=>'search', 'active' => true),
	        array('label'=>'Мои заказы','url'=>'search'),
	    ),
	)); ?>
</div>

<?php $this->renderPartial('_search',array(
	'model'=>$model,
));  ?>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'material-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate'=>true,
	'enablePagination' => true,
	'columns'=>array(
		array('name'=>'Вид', 'value' => 'CHtml::image(Yii::app()->request->baseUrl.MaterialBuy::categoryImg($data->category))', 'type' => 'raw'),
		array('name' => 'Наименование покупки', 'value' => 'CHtml::link($data->title, array("materialBuy/view", "id"=>$data->id))', 'type' => 'raw'),
		array('name' => 'Доставка', 'value' => '$data->supply == 1 ? CHtml::image(Yii::app()->request->baseUrl."/img/delivery.png") : ""', 'type' => 'raw'),
		array('name' => 'Регион', 'value' => '$data->object->region->region_name'),
		array('name' => 'Срок поставки', 'value' => '$data->start_date ." - ". $data->end_date',
      ),
	),
	'template' => '{items}{pager}',
));

 ?>
