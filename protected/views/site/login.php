<?php $this->pageTitle=Yii::app()->name . ' - Вход';?>
<div class="user-form" id="login-form">

<h3 class="form-title">Вход в кабинет</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
	
	<?php if(CHtml::error($model, 'status')): ?>
		<div class="alert">
			<?php echo CHtml::error($model, 'status'); ?>
		</div>
	<?php endif; ?>
		

	<?php echo $form->textFieldRow($model,'username',array('placeholder'=>'mail@example.com')); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('placeholder'=>'******')); ?>

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'block'=>true,
            'label'=>'Войти',
        )); ?>
	</div>

	<p class="text-center small"><?php echo CHtml::link('Восстановление пароля',array('recovery')); ?></p>

<?php $this->endWidget(); ?>

</div><!-- form -->
