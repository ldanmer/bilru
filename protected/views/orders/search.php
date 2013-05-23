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
	        array('label'=>'Найти подряд', 'url'=>array('orders/search')),
	        array('label'=>'Мои подряды', 'url'=>array('orderOffer/index')),
	        array('label'=>'Завершенные подряды', 'url'=>array('orderOffer/finished')),
	    ),
	)); ?>
</div>


<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'orders-grid',
	'dataProvider'=>$model->search(),
	'ajaxUpdate'=>true,
	'enablePagination' => true,
	'columns'=>array(
		array('name'=>'Тип', 'value' => '$data["object_id"] == 1 ? CHtml::image(Yii::app()->request->baseUrl."/img/eagle.png") : CHtml::image(Yii::app()->request->baseUrl."/img/bill.png")', 'type' => 'raw'),
		array('name' => 'Наименование заказа','type' => 'raw', 'value' => '$data["object_id"] == 1 ? 
					CHtml::link($data["title"], array("goszakaz/view", "id"=>$data["id"])) : 
					CHtml::link($data["title"], array("orders/view", "id"=>$data["id"]))'
					),
		array('name' => 'Начальная цена, руб', 'value' => '$data["price"] != 0 ? $data["price"] : "По договоренности"'),
		array('name' => 'Регион', 'value' => '$data["region_name"] ? $data["region_name"] : $data["contact"]'),
		array('name' => 'Окончание подачи заявок', 'value' => '$data["end_date"]',
      ),
	),
	'template' => '{items}{pager}',
));

 ?>
