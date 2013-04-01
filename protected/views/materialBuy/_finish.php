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
			<tr>
				<td class="header white">Оценка поставщика: 
					<?php echo GetName::getThisRating($data->rating_id)->rating; ?>
				</td>
				<td>
					<?php 
						$this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>'Ваш отзыв',
					    'block'=>true,
					    'htmlOptions'=>array(
				        'data-toggle'=>'modal',
				        'data-target'=>'#review',
					    ),
						)); ?>
				</td>
			</tr>	
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($data->object->title); ?></td>
			</tr>
			<tr>
				<td class="header">Поставщик:</td>
				<td><?php echo $data->offer->supplier->organizationData[0]->org_name ?></td>
			</tr>
			<tr>
				<td class="header">Стоимость покупки:</td>
				<td>
					<?php echo CHtml::encode($data->offer->total_price) . ' руб.'; 	?>
				</td>
			</tr>
			<tr>
				<td class="header">Категория покупки:</td>
				<td>
					<?php echo CHtml::encode($data->type->name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">ДАТА ПОСТАВКИ/ОТГРУЗКИ:</td>
				<td>		
					<?php echo CHtml::encode($data->offer->supply_date); ?>
				</td>
			</tr>
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
	?>	
	</div>

<?php if(!empty($data->offer->comment)): ?>
<div class="comment hidden" style="margin-bottom:10px;">
	<?php echo $data->offer->comment; ?>
</div>
<?php endif; ?>

<div align="right">
	<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-primary show pull-right')); ?>
</div>

<div class="clearfix"></div>

</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'review')); ?>
 
<div class="modal-body">
  <p><?php echo GetName::getThisRating($data->rating_id)->review; ?></p>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>