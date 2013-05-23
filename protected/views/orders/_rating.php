<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-rating-form',
	'htmlOptions' => array('class' => 'create-form'),
	'enableAjaxValidation'=>false,
)); ?>

	<legend>
		<span>Оставить отзыв</span>
	</legend>
	<fieldset>
	<?php echo $form->errorSummary($rating); ?>

	<div class="span1">
		<?php if(!empty($model->supplier->avatar)): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$model->supplier->avatar); ?>
		<?php else: ?>
			<img src="<?php echo Yii::app()->baseUrl ?>/img/avatar_placeholder.png" />
		<?php endif; ?>
	</div>
	<div class="span5 dark-blue">
		<div>ПОДРЯДЧИК: 
			<strong><?php echo CHtml::encode($model->supplier->organizationData[0]->org_name); ?></strong>
		</div>
		<table>	
			<tr class="white">
				<td class="subtitle span1">Рейтинг</td>
				<td class="span1" align="center"><?php echo GetName::getRating($model->supplier_id)->averageRating; ?></td>
				<td class="subtitle span1">Отзывов</td>
				<td class="span1" align="center"><?php echo GetName::getRating($model->supplier_id)->count; ?></td>
			</tr>
		</table>
		<div>
		<?php echo CHtml::link("Посмотреть профиль подрядчика",array(''), array('class'=>'btn btn-block pull-left')); ?>
		</div>
	</div>
	<div class="span6">
		<div>Ваша оценка <span class="redback" id="average">0</span></div>
		
		<?php foreach($rating->category as $key => $value):	?>
		<div class="span3 rating-title"><?php echo $value ?>:</div>
		<?php
			$this->widget('ext.dzRaty.DzRaty', array(
				'model' => $rating,
				'name' => "UserRating[score][$key]",
				'options' => array(
	        'number'=>10,
	        'starOff'=>'off.png',
	        'starOn'=>'on.png',
	        'width'=>'300',
	    	),
	    	'htmlOptions'=>array('class'=>'span4'),
			));
	 endforeach;
	 ?>
	 <?php echo $form->textAreaRow($rating, 'review', array('class'=>'span6', 'rows'=>5, 'placeholder'=>'Отзыв пользователя')); ?>
	</div>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Оставить отзыв',
			'htmlOptions' => array('class' => 'pull-right clearfix'),
		)); ?>
	</fieldset>
<?php $this->endWidget(); ?>
