<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-rating-form',
	'htmlOptions' => array('class' => 'create-form'),
	'enableAjaxValidation'=>false,
)); ?>

	<legend>
		<span>Оставить отзыв</span>
	</legend>
	<fieldset>
	<?php echo $form->errorSummary($model); ?>

	<div class="span1">
		<?php if(!empty($model->user->avatar)): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$model->user->avatar); ?>
		<?php else: ?>
			<img src="<?php echo Yii::app()->baseUrl ?>/img/avatar_placeholder.png" />
		<?php endif; ?>
	</div>
	<?php var_dump($model) ?>
	<div class="span4">
		Поставщик <?php echo CHtml::encode($model->user->organizationData[0]->org_name); ?>
	</div>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Оставить отзыв',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>

	</fieldset>
<?php $this->endWidget(); ?>
