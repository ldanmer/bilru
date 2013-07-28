<div class="order-title">
	ПРОФИЛЬ ОБЪЕКТА
</div>

<div class="order-view object-view create-form clearfix">
	<div class="span3">

	<?php $this->widget('bootstrap.widgets.TbButton', array(
				'type'=>'primary',
				'size'=>'small',
				'block'=>true,
				'url'=>array('materialBuy/create'),
				'label'=> 'купить на объект',
				'htmlOptions' => array('class' => 'clearfix'),				
			)); ?>
	<br>
		<div class="subtitle">		
			<h4>Фото объекта</h4>
		</div>
		<?php if(!empty($data->photoes) && !is_null($data->photoes)): 
		 $photoes = json_decode($data->photoes) ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($photoes as $photo) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/site/resized/76x76'.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
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
		<?php if(!empty($data->blueprints) && !is_null($data->blueprints)): ?>
		<?php $blueprints = json_decode($data->blueprints); ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($blueprints as $blueprint) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/site/resized/76x76'.$blueprint), Yii::app()->baseUrl.$blueprint, array('rel'=>'fancybox'));
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
		<?php if(!empty($data->documents) && !is_null($data->documents)): ?>
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
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'type'=>'primary',
				'size'=>'small',
				'block'=>true,
				'url'=>array('orders/create'),
				'label'=> 'найти подрядчика на объект',
				'htmlOptions' => array('class' => 'clearfix'),				
			)); ?>
			<br>
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
					<?php echo CHtml::encode($data->region->region->region_name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">Город:</td>
				<td>
					<?php echo CHtml::encode($data->region->city_name); ?>
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
			<h4>Активность</h4>
		</div>				
		<div class="rating-title">Идут торги (прием заявок):
			<span class="red pull-right"><?php echo $data->ordersCount + $data->buyesCount ?></span>
			<div align="right"><i style="margin-right:30px;"><?php echo CHtml::link('выбор подрядчика', array('orders/index', 'id'=>$data->id), array('class'=>'look')); ?></i> <span class="red"><?php echo $data->ordersCount ?></span></div>
			<div align="right"><i style="margin-right:30px;"><?php echo CHtml::link('выбор поставщика', array('materialBuy/index', 'id'=>$data->id), array('class'=>'look')); ?></i> <span class="red"><?php echo $data->buyesCount ?></span></div>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Подрядов в работе:', array('orders/index', 'id'=>$data->id), array(
			'class'=>'look')); ?>
			<span class="red pull-right"><?php echo $data->ordersCountActive ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Активные покупки:', array('materialBuy/index', 'id'=>$data->id), array('class'=>'look')); ?>
			<span class="red pull-right"><?php echo $data->buyesCountActive ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Завершенные работы:', array('orders/finished', 'id'=>$data->id), array('class'=>'look')); ?>
			<span class="red pull-right"><?php echo $data->ordersCountFinished ?></span>
		</div>
		<div class="rating-title"><?php echo CHtml::link('Завершенные покупки:', array('materialBuy/finished', 'id'=>$data->id), array('class'=>'look')); ?>
			<span class="red pull-right"><?php echo $data->buyesCountFinished ?></span>
		</div>
	</div>	

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>
<?php echo $form->hiddenField($data, 'id'); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'success',			
			'label'=> 'Объект завершен',
			'size'=>'small',
			'htmlOptions' => array('class' => 'pull-left'),				
		)); ?>

<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'size'=>'small',
			'url'=>array('objects/create', 'id'=>$data->id),
			'label'=> 'Редактировать объект',
			'htmlOptions' => array('class' => 'pull-right'),				
		)); ?>

</div>


<br>


