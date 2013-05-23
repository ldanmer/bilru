<div class="order-title">
	<?php echo CHtml::encode($data->order->title); ?>
</div>

<div class="detail-order">
	<table class="table">
		<tr>
			<td class="header">Статус:</td>
			<td>Работы завершены
				<div class="subtitle pull-right">Ваша оценка 
					<span class="red">	<?php echo GetName::getThisRating($data->order->rating_id)->rating; ?></span>
				</div>
			</td>
		</tr>	
		<?php if($data->order->offer_id): ?>
		<tr>
			<td class="header">Заказчик:</td>
			<td><?php 
				echo CHtml::encode($data->order->object->user->organizationData[0]->org_name); 
				echo CHtml::link('Профиль заказчика', array("user/view", "id"=>$data->order->object->user_id), 
					array('class'=>'btn pull-right light-blue-border'));
				?> </td>
		</tr>	
		<tr class="hidden">
			<td class="header contact">Контактное лицо:</td>
			<td>
				<?php	 echo $data->order->object->user->personalData[0]->first_name . " " . $data->order->object->user->personalData[0]->middle_name . " " . $data->order->object->user->personalData[0]->last_name; 
				?>
			</td>
		</tr>
		<tr class="hidden">
			<td class="header contact">Телефон:</td>
			<td>
				<?php echo $data->order->object->user->personalData[0]->phone1 ?>
			</td>
		</tr>
		<tr class="hidden">
			<td class="header contact">E-mail:</td>
			<td>
				<?php echo $data->order->object->user->email;  ?>
			</td>
		</tr>
		<tr class="hidden">
			<td class="header">Объект</td>
			<td><?php 
					echo CHtml::link('Профиль объекта', array("objects/view", "id"=>$data->order->object_id),
						array('class'=>'btn btn-block'));
			?></td>
		</tr>

		<?php else: ?>
			<tr>
				<td class="header">Прием заявок:</td>
				<td>
					<table>
						<tr>
							<td class="header">Начало</td>
							<td><?php echo CHtml::encode($data->order->start_date); ?></td>
							<td class="header">Окончание</td>
							<td><?php echo CHtml::encode($data->order->end_date); ?></td>
						</tr>
					</table>
				</td>
			</tr>	
		<?php endif; ?>
		<tr>
			<td class="header">Адрес объекта:</td>
			<td>
					<?php echo $data->order->object->region->region_name ?>, 
					ул.<?php echo $data->order->object->street ?>, 
					д.<?php echo $data->order->object->house ?>
			</td>
		</tr>	
		<tr>
			<td class="header">Стоимость работ:</td>
			<td><?php echo CHtml::encode($data->work_price); ?> руб.</td>
		</tr>	
		<tr>
			<td class="header">Стоимость материалов:</td>
			<td><?php echo CHtml::encode($data->material_price); ?> руб.</td>
		</tr>	
		<tr>
			<td class="header">Сроки выполнения работ:</td>
			<td><?php echo CHtml::encode($data->duration); ?> дней</td>
		</tr>		
		<tr class="hidden">
			<td class="header">Документы подряда:</td>
			<td>
				<ol class="doc-list">
			 		<?php echo GetName::getDocsList($data->order->documents)->list; ?>
			 	</ol>				
			</td>
		</tr>	
	</table>
	<p class="comment hidden"><?php echo CHtml::encode($data->order->description); ?></p>
	<div class="hidden">	
		<?php echo CHtml::link("Страница подряда",array('orders/view', 'id'=>$data->order_id),array('class'=>'btn btn-info pull-left')); ?>
	</div>
	<div align="right">	
		<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-primary show pull-right')); ?>
	</div>
	<p class="clearfix"></p>
</div>
