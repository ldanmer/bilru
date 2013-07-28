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
		array('name' => 'Начальная цена, руб', 'value' => '$data["price"] != 0 ? number_format($data["price"], 2, ",", " ")  : "По договоренности"'),
		array('name' => 'Регион', 'value' => '$data["region_name"] ? $data["region_name"] : $data["object"]'),
		array('name' => 'Окончание подачи заявок', 'value' => 'date("d.m.Y",$data["end_date"])',
      ),
	),
	'template' => '{items}{pager}',
));

 ?>