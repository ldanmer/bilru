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
	        array('label'=>'Мои заказы', 'url'=>array('orders/index'), 'active' => true),
	        array('label'=>'Создать заказ', 'url'=>array('orders/create')),
	        array('label'=>'Завершенные заказы', 'url'=>array('orders/finished')),
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
				<td class="header">Прием заявок:</td>
				<td>с <?php echo $zakaz->start_date; ?> по <?php echo $zakaz->end_date; ?></td>
			</tr>		
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($zakaz->object->title); ?></td>
			</tr>			
			<tr>
				<td class="header">Вид работ:</td>
				<td>
					<?php echo CHtml::encode($zakaz->workType->name); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Стоимость работ:</td>
				<td>
					<?php echo CHtml::encode($zakaz->price); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Сроки выполнение работ:</td>
				<td>
					<?php echo CHtml::encode($zakaz->duration); ?>
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
		array('name' => 'Название подрядчика', 'value' => 'CHtml::link($data->supplier->organizationData[0]->org_name, array("view", "id"=>$data->id))', 'type'=>'raw'),
		array('name'=>'Рейтинг', 'value'=>'CHtml::link(GetName::getRating($data->supplier_id)->averageRating, array("UserRating/view", "id"=>$data->supplier_id))', 'type'=>'raw'),
		array('name'=>'Отзывы', 'value'=>'CHtml::link(GetName::getRating($data->supplier_id)->count, array("UserRating/view", "id"=>$data->supplier_id))', 'type'=>'raw'),
		array('name'=>'Стоимость работ, руб', 'value'=>'CHtml::link($data->work_price, array("view", "id"=>$data->id))', 'type'=>'raw'),
		array('name'=>'Сроки выполнения работ', 'value'=>'CHtml::link($data->duration, array("view", "id"=>$data->id))', 'type'=>'raw'),
		array('name'=>'Готов начать', 'value'=>'CHtml::link($data->start_date, array("view", "id"=>$data->id))', 'type'=>'raw'),
	),
	'template' => '{items}{pager}',
));
 ?>