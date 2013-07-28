<div class="order-title">
	ПРОФИЛЬ ОБЪЕКТА
</div>

<div class="order-view object-view create-form clearfix">
	<div class="span3">
		<div class="subtitle">		
			<h4>Фото объекта</h4>
		</div>
		<?php if($data->photoes != 'null'): ?>
		<?php $photoes = json_decode($data->photoes) ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($photoes as $photo) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
				} ?>
			</div>
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif ?>

		<div class="subtitle">
			<h4>Чертежи объекта</h4>
		</div>
		<?php if($data->blueprints !='null'): ?>
		<?php $blueprints = json_decode($data->blueprints); ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($blueprints as $blueprint) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$blueprint), Yii::app()->baseUrl.$blueprint, array('rel'=>'fancybox'));
				} ?>
			</div>				
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
		
		<div class="subtitle">
			<h4>Документы</h4>
		</div>
		<?php if($data->documents != 'null'): ?>
		<div>
		 <ol class="doc-list">
		 	<?php echo GetName::getDocsList($data->documents)->list; ?>
		 </ol>
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
	</div>
	<div class="span3">
		<table class="table table-striped">
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($data->title); ?></td>
			</tr>
			<tr>
				<td class="header">Тип:</td>
				<td><?php echo CHtml::encode($data->objectType->name); ?></td>
			</tr>
			<tr>
				<td class="header">Регион:</td>
				<td>
					<?php echo CHtml::encode($data->region->cities[0]->region->region_name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">Город:</td>
				<td>
					<?php echo CHtml::encode($data->region->cities[0]->city_name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">Адрес:</td>
				<td>
					ул.<?php echo CHtml::encode($data->street); ?>,
					д.<?php echo CHtml::encode($data->house); ?>
				</td>
			</tr>
			<tr>
				<td class="header">ПЛОЩАДЬ:</td>
				<td>
					<?php echo CHtml::encode($data->square); ?> м<sup>2</sup>		
				</td>
			</tr>
			<tr>
				<td class="header">Этажность:</td>
				<td>
					<?php echo CHtml::encode($data->floors); ?>		
				</td>
			</tr>
		</table>
		<div class="subtitle">
			<h4>Наличие коммуникаций</h4>
		</div>
		<div class="white well">
			<?php 			
				echo !empty($data->communications) ? GetName::jsonToString($data->communications, $data->communicationTypes, "<br>") : "коммуникаций нет"; 
				?>
		</div>

		<div class="subtitle">
			<h4>История объекта</h4>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Произведено работ:', array('orders/finished', 'id'=>$data->id), array('class'=>'look')); ?>
			<span class="red pull-right"><?php echo $data->ordersCountFinished ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Совершено поставок:', array('materialBuy/finished', 'id'=>$data->id), array('class'=>'look')); ?>
			<span class="red pull-right"><?php echo $data->buyesCountFinished ?></span>
		</div>
		<div class="rating-title">Работало подрядчиков:
			<span class="red pull-right"><?php echo $data->ordersCountFinishedUnique ?></span>
		</div>
		<div class="rating-title">Работало поставщиков:
			<span class="red pull-right"><?php echo $data->buyesCountFinishedUnique ?></span>
		</div>
	</div>	
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>
<?php echo $form->hiddenField($data, 'id'); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',			
			'label'=> 'Восстановить активность объекта',
			'size'=>'small',
			'htmlOptions' => array('class' => 'pull-right'),				
		)); ?>

<?php $this->endWidget(); ?>
</div>
<br>


