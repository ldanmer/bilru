<?php 
	if($data->materialBuy->doc_list != "null")
	{
		$docs = GetName::getDocsList($data->materialBuy->doc_list);
		$img = $docs->img;
	}

 ?>

<div class="create-form">
<legend><span><?php echo $data->materialBuy->title ?></span></legend>
<fieldset>
<div class="detail-order">
		<table class="table">			
			<tr>
				<td class="header">Статус:</td>
				<td>Поставка завершена 
					<h4 class="subtitle pull-right">Ваша оценка 
					<span class="red">	<?php echo GetName::getThisRating($data->materialBuy->rating_id)->rating; ?></span>
					</h4>
				</td>
			</tr>	
			<tr class="hidden">
				<td class="header">Заказчик:</td>
				<td><?php
					echo CHtml::link(CHtml::encode($data->materialBuy->user->organizationData->org_name),array("user/profile", "id"=>$data->materialBuy->user_id)); 	?></td>
			</tr>
			<tr class="hidden">
				<td class="header">Контакты:</td>
				<td>
					<?php 
							switch ($data->materialBuy->show_contact) {
							case '0':
								echo $data->materialBuy->user->email;
								break;
							case '1':
								echo $data->materialBuy->user->personalData->phone1;
								break;
							case '2':
								echo $data->materialBuy->user->email." / ".$data->materialBuy->user->personalData->phone1;
								break;
							
							default:
								echo '<p class="muted">скрыто</p>';
								break;
						}
						?>
				</td>
			</tr>	
			<tr>
				<td class="header">Категория покупки:</td>
				<td>
					<?php echo CHtml::encode($data->materialBuy->type->name); ?>
				</td>
			</tr>			
			<tr>
				<td class="header">Адрес объекта:</td>
				<td>
					<?php echo $data->materialBuy->object->region->region_name ?>, 
					ул.<?php echo $data->materialBuy->object->street ?>, 
					д.<?php echo $data->materialBuy->object->house ?>
				</td>
			</tr>
			<tr>
				<td class="header">Стоимость поставки:</td>
				<td>
					<?php echo number_format($data->total_price, 2, ',', ' '); ?> руб.
				</td>
			</tr>	
			<tr>
				<td class="header">Срок поставки:</td>
				<td>
					<?php echo CHtml::encode($data->supply_date); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Доставка:</td>
				<td>
					<?php echo !empty($data->delivery) ? $data->delivery." руб." : "Без доставки"; ?>
				</td>
			</tr>	
			<tr class="hidden">
				<td class="header">Документы:</td>
				<td>
					<ol class="doc-list"><?php echo $docs->list ?></ol>	
				</td>
			</tr>				
		</table>

	<br />
	<div class="hidden">

<?php 
	 $this->widget('bootstrap.widgets.TbGridView', array(
  'dataProvider'=>MaterialBuy::model()->ordersList($data->material_buy_id),
  'template'=>"{items}",
  'columns'=>array(
      array('name'=>0, 'header'=>'Наименование', 'htmlOptions'=>array('class'=>'span4')),
      array('name'=>1, 'header'=>'Ед.изм', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>2, 'header'=>'Количество', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>3, 'header'=>'Цена за ед.', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>4, 'header'=>'Сумма', 'htmlOptions'=>array('class'=>'span0 sum')), 	 		 
  		),
  'htmlOptions'=>array('class'=>'material-list result-list'),
	)); 
?>	

	<?php if(!empty($data->comment)): ?>
	<div class="comment" style="margin-bottom:10px;">
		<?php echo $data->comment; ?>
	</div>
	<?php endif; ?>
</div>

	<div align="right">	
	<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-small btn-primary show pull-right')); ?>
	</div>

	<div class="clearfix"></div>

	</div>
	</fieldset>
</div>