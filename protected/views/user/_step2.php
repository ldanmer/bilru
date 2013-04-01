<!-- Форма Физлица -->
<?php
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'enableClientValidation'=>true,
		'enableAjaxValidation'=>false,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); 
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">

	<div class="span3">
		<?php echo $form->textFieldRow($userData,'first_name', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Имя',
				'hint'=>'например, Иван'
			)); ?>

		<?php echo $form->textFieldRow($userData,'last_name', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Фамилия',
				'hint'=>'например, Петров'
			)); ?>

	</div>

	<div class="span3">
		<?php echo $form->dropDownListRow($userData, 'region_id', array($regionNames), array(
			'hint' => 'Регион',
			'label'=>false, 
			'empty' => '- выберите регион -',
		)); ?>

		<?php echo $form->dropDownListRow($userData, 'city_id', array($cityNames), array(
			'hint' => 'Город',
			'label'=>false, 
			'empty' => '- выберите город -',
		)); ?>
	</div>

	<div class="span3">
		<?php echo $form->textFieldRow($model,'email', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Email',
				'hint'=>'будет являться логином'
			)); ?>		

		<?php echo $form->textFieldRow($userData,'phone1', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Основной телефон',
				'hint'=>'+7(***) ***-**-**'
			)); ?>
	</div>

	<div class="span3">
		<?php echo $form->passwordFieldRow($model,'password',array(
				'maxlength'=>60,
				'label'=>false, 
				'placeholder' => 'Пароль'
			)); ?>

		<?php echo $form->passwordFieldRow($model,'password_repeat',array(
				'maxlength'=>60,
				'label'=>false, 
				'placeholder' => 'Подтверждение пароля'
			)); ?>

		<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->captchaRow($model,'verifyCode',array(
					'label'=>false, 
	        'placeholder'=>'Введите код проверки...',
      	)); ?>
		<?php endif; ?>
  
	</div>

</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Регистрация' : 'Сохранить',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>



