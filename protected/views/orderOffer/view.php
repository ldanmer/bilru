<?php
$this->breadcrumbs=array(
	'Предложения подрядчиков'
);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Мои заказы', 'url'=>array('orders/index')),
	        array('label'=>'Создать заказ', 'url'=>array('orders/create')),
	        array('label'=>'Завершенные заказы', 'url'=>array('orders/finished')),
	    ),
	)); ?>
</div>

<?php 
	if($model->order->object->photoes != "null")
		$objImg = json_decode($model->order->object->photoes);

	if($data->doc_list != "null")
	{
		$docs = GetName::getDocsList($model->doc_list);
	}
 ?>

<div class="order-title">
	Предложение подрядчика
</div>
<div class="order-view clearfix">
	<div class="span1">
		<p class="subtitle" align="center">Фото объекта</p>
		<?php if(!empty($objImg[0])): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$objImg[0]); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/order-image.png" />
	<?php endif; ?>
	</div>
	<div class="span6">
		<table class="table table-striped">	
			<tr class="alert alert-error">
				<td class="header">Прием заявок:</td>
				<td>с <?php echo $model->order->start_date; ?> по <?php echo $model->order->end_date; ?></td>
			</tr>	
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($model->order->object->title); ?></td>
			</tr>			
			<tr>
				<td class="header">Вид работ:</td>
				<td>
					<?php echo Orders::getWorkTypes($model->order->work_type_id); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Стоимость работ:</td>
				<td>
					<?php echo empty($model->order->price) ? "По договоренности" : number_format($model->order->price, 2, ',', ' '); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Сроки выполнение работ:</td>
				<td>
					<?php echo CHtml::encode($model->order->duration); ?>
				</td>
			</tr>				
		</table>
	</div>
</div>

<div class="order-title">
	<?php echo CHtml::encode($model->supplier->organizationData->org_name); ?>
</div>
<div class="order-view clearfix">
	<div class="span1">		
		<?php if(!empty($model->supplier->settings->avatar)): 
		$avatar = json_decode($model->supplier->settings->avatar);
		?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$avatar[0]); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/avatar_placeholder.png" />
	<?php endif; ?>
	Рейтинг: <span class="rating">
		<?php echo CHtml::link(GetName::getRating($model->supplier->id)->averageRating, array('userRating/view', 'id'=>$model->supplier->id)); ?>
		</span> 
		Отзывы: <span class="reviews">
			<?php echo CHtml::link(GetName::getRating($model->supplier->id)->count, array('userRating/view', 'id'=>$model->supplier->id)); ?>
		</span>
	</div>
	<div class="span6" style="margin-bottom:10px">
		<table class="table table-striped">		
			<tr>
				<td class="header">Стоимость работ:</td>
				<td><?php echo number_format($model->work_price, 2, ',', ' ') ?> руб.</td>
			</tr>	
			<tr>
				<td class="header">Стоимость материалов:</td>
				<td><?php echo number_format($model->material_price, 2, ',', ' ') ?> руб.</td>
			</tr>		
			<tr>
				<td class="header">Срок выполнения работ:</td>
				<td><?php echo $model->duration; ?></td>
			</tr>	
			<tr>
				<td class="header">Готов начать:</td>
				<td><?php echo $model->start_date; ?></td>
			</tr>		
			<tr>
				<td class="header">Документы:</td>
				<td>
					<ol class="doc-list">
						<?php echo $docs->list ?>
					</ol>
				</td>
			</tr>	
		</table>
		<?php echo CHtml::link("Посмотреть профиль поставщика",array('user/profile', 'id'=>$model->supplier_id), array('class'=>'btn btn-block light-blue-border')); ?>
	</div>

<?php if(!empty($model->comment)): ?>
<div class="comment clearfix" style="margin-bottom:10px">
	<?php echo $model->comment; ?>
</div>
<?php endif; ?>


<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Принять предложение',
		    'type'=>'primary',
		    'url'=>$this->createUrl($model->id, array('accept' => $model->order_id)),
		    'htmlOptions'=>array(
		        'class' => 'pull-right',
		    ),
		));
 ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться к предложениям',
		    'url'=>$this->createUrl('list', array('id'=>$model->order_id)),
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-left',
		    ),
		));
 ?>
</div>