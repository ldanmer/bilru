<?php
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'enableClientValidation'=>true,
		'type'=>'horizontal',
		'enableAjaxValidation'=>false,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); 
?>

	<?php echo $form->errorSummary($model); ?>

  <?php echo $form->textFieldRow($model,'subject',array('label'=>false, 'placeholder'=>'Заголовок')); ?>

  <?php echo $form->textAreaRow($model,'body',array('rows'=>4,'label'=>false, 'placeholder'=>'Введите свое сообщение')); ?>

	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(           
            'label'=>false,
           	'placeholder'=>'Код проверки',
        )); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'size' => 'small',
            'type'=>'primary',
            'label'=>'Отправить',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

