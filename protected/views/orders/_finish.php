<?php 
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
			<?php if(empty($data->rating_id)): ?>

			<tr>
				<td class="header white">Оценка поставщика: 
					<span class="red">0</span>
				</td>
				<td>
				<?php 
				echo CHtml::link("Оставить отзыв",array('rating', 'id'=>$data->id), array('class'=>'btn btn-block btn-danger')); 
				?>
				</td>
			</tr>		

			<?php else: ?>
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
		<?php endif; ?>
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($data->object->title); ?></td>
			</tr>
			<tr>
				<td class="header">Подрядчик:</td>
				<td><?php echo $data->offer->supplier->organizationData[0]->org_name ?></td>
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
	<?php echo CHtml::button("Показать полностью",array('class'=>'btn btn-primary show pull-right')); ?>
	</div>
<div class="clearfix"></div>

</div>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'review')); ?>
 
<div class="modal-body">
  <p><?php echo isset($data->rating_id) ? GetName::getThisRating($data->rating_id)->review : ""; ?></p>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>