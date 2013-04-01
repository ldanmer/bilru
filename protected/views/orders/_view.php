<?php 
	// Тип подрядчика
	$contractors = GetName::jsonToString($data->user_role_id, $data->contractorTypes);
	// Вид работ
	$works = Orders::getWorkTypes($data->work_type_id);
	// Список документов

	if($data->documents != "null")
	{
		$docs = GetName::getDocsList($data->documents);
		$img = $docs->img;
	}

 ?>

<div class="order-title">
	<?php echo CHtml::encode($data->title); ?>
</div>

<div class="order-view">

	<div class="span1">
		<p class="subtitle" align="center">Фото объекта</p>
		<?php if(!empty($img)): ?>
			<?php  echo CHtml::image($img); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/order-image.png" />
	<?php endif; ?>
	</div>
	<div class="span6">
		<table class="table table-striped">
			<?php if(strtotime($data->end_date) > time()): ?>
			<tr class="alert alert-error">
				<td class="header">Прием заявок:</td>
				<td>с <?php echo $data->start_date; ?> по <?php echo $data->end_date; ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="header">Статус:</td>
				<td><?php echo $data->statusArray[CHtml::encode($data->status)]; ?></td>
			</tr>
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($data->object->title); ?></td>
			</tr>
			<tr>
				<td class="header">Подрядчик:</td>
				<td>Неопределен</td>
			</tr>
			<tr>
				<td class="header">Стоимость работ:</td>
				<td>
					<?php 
					if($data->price != 0)
						echo CHtml::encode($data->price) . ' руб.'; 
					else
						echo "По договоренности"; 
						?>
				</td>
			</tr>
			<tr>
				<td class="header">Срок выполнения работ:</td>
				<td>
					<?php 
					if($data->duration != 0)
						echo CHtml::encode($data->duration) . " дней"; 
					else
						echo "По договоренности"; 
						?>
				</td>
			</tr>
			<tr class="hidden">
				<td class="header">Тип подрядчика:</td>
				<td>
					<?php 					
						echo $contractors; 
						?>
				</td>
			</tr>
			<tr class="hidden">
				<td class="header">Вид работ:</td>
				<td>
					<?php 					
						echo $works; 
						?>
				</td>
			</tr>
			<tr class="hidden">
				<td class="header">Материалы на объект:</td>
				<td>
					<?php 					
						echo $data->materialType[CHtml::encode($data->material)];
						?>
				</td>
			</tr>
		</table>
		<div class="hidden">
			<h4 class="subtitle">Документы</h4>
			<ol class="doc-list"><?php echo $docs->list ?></ol>	
		</div>

	</div>	
	<div align="right">


	<?php echo CHtml::link("Редактировать",array('update','id'=>$data->id), array('class'=>'btn btn-primary hidden pull-right')); ?>
	<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-primary show')); ?>
	</div>


</div>