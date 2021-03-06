<div class="order-title">
	<?php echo CHtml::encode($data->order->title); ?>
</div>

<div class="detail-order">
	<table class="table">
		<tr>
			<td class="header">Статус:</td>
			<?php if($data->order->offer_id): ?>
			<td class="alert alert-error red-border">Заказчик принял ваше предложение</td>
			<?php else:  ?>
			<td class="light-blue light-blue-border">Предложение на рассмотрении заказчика</td>
			<?php endif; ?>
		</tr>	
		<?php if($data->order->offer_id): ?>
		<tr>
			<td class="header">Заказчик:</td>
			<td><?php 
				echo CHtml::link(CHtml::encode($data->order->object->user->organizationData->org_name), array("user/profile", "id"=>$data->order->object->user_id)); 
				?> </td>
		</tr>	
		<tr class="hidden">
			<td class="header contact">Контактное лицо:</td>
			<td>
				<?php	 echo $data->order->object->user->personalData->first_name . " " . $data->order->object->user->personalData->middle_name . " " . $data->order->object->user->personalData->last_name; 
				?>
			</td>
		</tr>
		<tr class="hidden">
			<td class="header contact">Телефон:</td>
			<td>
				<?php echo $data->order->object->user->personalData->phone1 ?>
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
						array('class'=>'btn btn-small btn-block'));
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
			<td><?php echo number_format($data->work_price, 2, ',', ' ') ?> руб.</td>
		</tr>	
		<tr>
			<td class="header">Стоимость материалов:</td>
			<td><?php echo number_format($data->material_price, 2, ',', ' ') ?> руб.</td>
		</tr>	
		<tr>
			<td class="header">Сроки выполнения работ:</td>
			<td><?php echo CHtml::encode($data->duration); ?> дней</td>
		</tr>	
		<tr>
			<td class="header">Готов начать:</td>
			<td class="alert alert-error red-border"><?php echo CHtml::encode($data->start_date); ?></td>
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
	<br>
	<div class="hidden">	
		<?php echo CHtml::link("Страница подряда",array('orders/view', 'id'=>$data->order_id),array('class'=>'btn btn-small btn-info pull-left')); ?>
	</div>
	<div align="right">	
		<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-small btn-primary show pull-right')); ?>
	</div>
	<p class="clearfix"></p>
</div>
