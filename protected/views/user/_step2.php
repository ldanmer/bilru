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
				'hint'=>'например, Иван',
				'tabindex'=>10,
			)); ?>

		<?php echo $form->passwordFieldRow($model,'password',array(
				'maxlength'=>60,
				'label'=>false, 
				'placeholder' => 'Пароль',
				'tabindex'=>40,
			)); ?>
	</div>

	<div class="span3">
		<?php echo $form->textFieldRow($userData,'last_name', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Фамилия',
				'hint'=>'например, Петров',
				'tabindex'=>20,
			)); ?>

		<?php echo $form->passwordFieldRow($model,'password_repeat',array(
				'maxlength'=>60,
				'label'=>false, 
				'placeholder' => 'Подтверждение пароля',
				'tabindex'=>50
			)); ?>
	</div>

	<div class="span3">
		<?php echo $form->textFieldRow($model,'email', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Email',
				'hint'=>'будет являться логином',
				'tabindex'=>30
			)); ?>		

		<?php echo $form->textFieldRow($userData,'phone1', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => '+7(***) ***-**-**',
				'hint'=>'Телефон (с кодом города)',
				'tabindex'=>60,
			)); ?>
	</div>

	<div class="span3">
		<?php echo $form->dropDownListRow($userData, 'region_id', Region::model()->getRegionsList(), array(
			'hint' => 'Регион',
			'label'=>false, 
			'empty' => '- выберите регион -',
			'tabindex'=>70,
		)); ?>

	</div>
	<div class="span6">
		<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->captchaRow($model,'verifyCode',array(
					'label'=>false, 
	        'placeholder'=>'Введите код проверки...',
	        'tabindex'=>90,
      	)); ?>
		<?php endif; ?> 
	</div>
</div>
	<p class="muted small">
		Пользователь гарантирует достоверность всех вводимых при использовании сайта данных. Недостоверные или некорректные данные могут стать причиной отказа в обслуживании и выполнении финансовых операций.
	</p>
	<div class="form-actions">
		<?php echo $form->checkboxRow($userData, 'terms', array('label'=>false, 'tabindex'=>100)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Регистрация',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>

		<?php 
		$this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-left',
		    ),
		)); ?>
	</div>

<?php $this->endWidget(); ?>