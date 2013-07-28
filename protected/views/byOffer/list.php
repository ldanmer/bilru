<?php
$this->breadcrumbs=array(
	'Предложения поставщиков',
);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	    	array('label'=>'Купить', 'url'=>array('materialBuy/create')),
        array('label'=>'Активные покупки', 'url'=>array('materialBuy/index'), 'active' => true),
       	array('label'=>'Завершенные покупки', 'url'=>array('materialBuy/finished')), 
	    ),
	)); ?>
</div>

<?php 
	if($zakaz->object->photoes != "null")
	{
		$imgs = json_decode($zakaz->object->photoes);
	}
 ?>

<div class="order-title">
	Предложения поставщиков
</div>
<div class="order-view clearfix">
	<div class="span1">
		<p class="subtitle" align="center">Фото объекта</p>
		<?php if(!empty($imgs[0])): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$imgs[0]); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/order-image.png" />
	<?php endif; ?>
	</div>
	<div class="span6">
		<table class="table table-striped">	
			<tr class="alert alert-error">
				<td class="header">Срок поставки:</td>
				<td>с <?php echo $zakaz->start_date; ?> по <?php echo $zakaz->end_date; ?></td>
			</tr>			
			<tr>
				<td class="header">Покупка:</td>
				<td><?php echo CHtml::encode($zakaz->title); ?></td>
			</tr>
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($zakaz->object->title); ?></td>
			</tr>			
			<tr>
				<td class="header">Категория покупки:</td>
				<td>
					<?php echo CHtml::encode($zakaz->type->name); ?>
				</td>
			</tr>			
		</table>
	</div>
</div>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'material-grid',
	'dataProvider'=>$model->search($zakaz->id),
	'ajaxUpdate'=>true,
	'enablePagination' => true,
	'columns'=>array(		
		array('name' => 'Название поставщика', 'value' => 'CHtml::link($data->supplier->organizationData->org_name, array("view", "id"=>$data->id))', 'type'=>'raw'),
		array('name'=>'Рейтинг', 'value'=>'CHtml::link(GetName::getRating($data->supplier_id)->averageRating, array("UserRating/view", "id"=>$data->supplier_id))', 'type'=>'raw'),
		array('name'=>'Отзывы', 'value'=>'CHtml::link(GetName::getRating($data->supplier_id)->count, array("UserRating/view", "id"=>$data->supplier_id))', 'type'=>'raw'),
		array('name'=>'Стоимость, руб', 'value'=>'CHtml::link(number_format($data->total_price, 2, ",", " "), array("view", "id"=>$data->id))', 'type'=>'raw'),
		array('name'=>'Поставка, отгрузка', 'value'=>'CHtml::link($data->supply_date, array("view", "id"=>$data->id))', 'type'=>'raw'),
		array('name'=>'Доставка', 'value'=>'$data->delivery === null ? "Без доставки": $data->delivery." руб."', 'type'=>'raw'),
	),
	'template' => '{items}{pager}',
));
 ?>