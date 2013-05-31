<?php 
	// Тип подрядчика
	$contractors = GetName::jsonToString($data->user_role_id, $data->contractorTypes);
	// Вид работ
	$works = Orders::getWorkTypes($data->work_type_id);
	// Список документов

	if($data->documents != "null")
		$docs = GetName::getDocsList($data->documents);	
	$img = json_decode($data->object->photoes);

 ?>

<div class="order-title">
	<?php echo CHtml::encode($data->title); ?>
</div>

<div class="order-view">

	<div class="span1">
		<p class="subtitle" align="center">Фото объекта</p>
		<?php if(!empty($img[0])): ?>
			<?php  echo CHtml::image(Yii::app()->baseUrl.$img[0]); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/order-image.png" />
	<?php endif; ?>
	</div>
	<div class="span6">
		<table class="table table-striped">
			<?php if(strtotime($data->end_date) > time() && empty($data->offer_id)): ?>
			<tr class="alert alert-error red-border">
				<td class="header">Прием заявок:</td>
				<td>с <?php echo $data->start_date; ?> по <?php echo $data->end_date; ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="header">Статус:</td>
				<td class="light-blue"><?php echo !empty($data->offer_id) ? "В работе" : "На конкурсе" ?></td>
			</tr>
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($data->object->title); ?></td>
			</tr>
			<?php if(empty($data->offer_id)): ?>
			<tr class="light-blue-border">
				<td class="header">Подрядчик:</td>
				<td class="light-blue">Поступило <?php echo $data->supplierCount ?> предложений</td>
			</tr>
			<?php else: ?>
			<tr>
				<td class="header">Подрядчик:</td>
				<td><?php echo $data->offer->supplier->organizationData[0]->org_name ?></td>
			</tr>
			<?php endif; ?>
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
			<tr class="hidden">
				<td class="header">Документы</h4>
				<td>
					<ol class="doc-list">
						<?php echo $docs->list ?>
					</ol>
				</td>	
			</tr>
		</table>
	</div>
	<div class="comment hidden clearfix">
		<?php echo CHtml::encode($data->description) ?>
	</div>

	<div style="margin-top:10px;">
	<?php if(empty($data->offer_id)): ?>
	<?php echo CHtml::link("Посмотреть предложения поставщиков",array('/orderOffer/list','id'=>$data->id), array('class'=>'btn btn-small pull-left light-blue light-blue-border')); ?>
	<?php endif; ?>
	<?php if(empty($data->offer_id)): 
		echo CHtml::link("Редактировать",array('update','id'=>$data->id), array('class'=>'btn btn-small btn-primary hidden pull-right')); 
 	else: 
	 echo CHtml::link("Заказ выполнен",array('rating', 'id'=>$data->id), array('class'=>'btn btn-small btn-success pull-left'));
	endif;
 		 ?>
	<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-primary btn-small show pull-right')); ?>
	</div>
<div class="clearfix"></div>

</div>