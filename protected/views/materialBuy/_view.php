<?php 
	if($data->doc_list != "null")
	{
		$docs = GetName::getDocsList($data->doc_list);
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
			<?php if(strtotime($data->end_date) > time() && empty($data->supplier)): ?>
			<tr class="alert alert-error">
				<td class="header">Срок поставки:</td>
				<td>с <?php echo $data->start_date; ?> по <?php echo $data->end_date; ?></td>
			</tr>	
			<?php endif; ?>		
			<tr>
				<td class="header">Статус:</td>
				<td class="light-blue"><?php echo !empty($data->offer_id) ? "Активная покупка" : "На конкурсе" ?></td>
			</tr>	
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($data->object->title); ?></td>
			</tr>
			<?php if(empty($data->offer_id)): ?>
			<tr class="light-blue-border">
				<td class="header">Поставщик:</td>
				<td class="light-blue">Поступило <?php echo $data->supplierCount ?> предложений</td>
			</tr>
		<?php else: ?>
			<tr>
				<td class="header">Поставщик:</td>
				<td><?php echo $data->offer->supplier->organizationData[0]->org_name ?></td>
			</tr>
		<?php endif; ?>
			<tr>
				<td class="header">Стоимость покупки:</td>
				<td>
					<?php 
					if(!empty($data->offer->total_price))
						echo CHtml::encode($data->offer->total_price) . ' руб.'; 
					else
						echo "Не определена"; 
						?>
				</td>
			</tr>
			<tr>
				<td class="header">Категория покупки:</td>
				<td>
					<?php echo CHtml::encode($data->type->name); ?>
				</td>
			</tr>
			<?php if(!empty($data->offer->supply_date)): ?>
			<tr>
				<td class="header">ДАТА ПОСТАВКИ/ОТГРУЗКИ:</td>
				<td>		
					<?php echo CHtml::encode($data->offer->supply_date); ?>
				</td>
			</tr>
		<?php endif; ?>
			<tr class="hidden">
				<td class="header">Доставка:</td>
				<td>
					<?php echo $data->supply==1 ? "Обязательна" : "По договоренности" ?>
				</td>
			</tr>
			<tr class="hidden">
				<td class="header">Контакты:</td>
				<td>
					<?php 
							switch ($data->show_contact) {
							case '0':
								echo $data->user->email;
								break;
							case '1':
								echo $data->user->personalData[0]->phone1;
								break;
							case '2':
								echo $data->user->email." / ".$data->user->personalData[0]->phone1;
								break;
							
							default:
								echo '<p class="muted">скрыто</p>';
								break;
						}
						?>
				</td>
			</tr>
		</table>
		<div class="hidden">
			<h4 class="subtitle">Документы</h4>
			<ol class="doc-list"><?php echo $docs->list ?></ol>	
		</div>

	</div>	
	<br />
	<div class="hidden">

	<?php
	if(empty($data->supplier)):		
		$arrayData = $data->ordersList($data->id);
		$list = array_pop($arrayData->rawData);
	 $this->widget('bootstrap.widgets.TbGridView', array(
  'dataProvider'=>$arrayData,
  'template'=>"{items}",
  'columns'=>array(
      array('name'=>0, 'header'=>'Наименование', 'htmlOptions'=>array('class'=>'span5')),
      array('name'=>1, 'header'=>'Ед.изм', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>2, 'header'=>'Количество', 'htmlOptions'=>array('class'=>'span0')), 		 
  		),
  'htmlOptions'=>array('class'=>'material-list'),
	)); 

	else:
	 $this->widget('bootstrap.widgets.TbGridView', array(
  'dataProvider'=>$data->ordersList($data->id),
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

	endif;
	?>	

	</div>

	<div align="right">
	<?php if(empty($data->offer_id)): ?>
	<?php echo CHtml::link("Посмотреть предложения поставщиков",array('/byOffer/list','id'=>$data->id), array('class'=>'btn pull-left light-blue light-blue-border')); ?>
	<?php endif; ?>
	<?php if(empty($data->offer_id)): 
		echo CHtml::link("Редактировать",array('update','id'=>$data->id), array('class'=>'btn btn-primary hidden pull-right')); 
 	else: 
	 echo CHtml::link("Дать оценку поставщику",array('rating', 'id'=>$data->id), array('class'=>'btn btn-success pull-left'));
	endif;
 		 ?>

	<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-primary show pull-right')); ?>
	</div>

<div class="clearfix"></div>

</div>