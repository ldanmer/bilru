<?php 
// Убираем первый элемент из списка ОПФ
array_shift($orgTypes);
 ?>

 <!-- Форма Юрлица -->
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
		<p class="small muted">Организационно-правовая форма</p>
		<?php echo $form->dropDownListRow($model, 'org_type_id', array($orgTypes), array(
			'label'=>false, 
		)); ?>

		<?php echo $form->textFieldRow($orgData,'org_name', array(
				'label'=>false, 
				'placeholder' => 'Название организации',
			)); ?>

		<?php echo $form->textFieldRow($userData,'phone1', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => '+7 (   ) Телефон',
			)); ?>

		<?php echo $form->textFieldRow($userData,'phone2', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => '+7 (   ) Телефон',
				'class' => 'optional',
			)); ?>


		<?php echo $form->textFieldRow($model,'email', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Email',
				'hint'=>'будет являться логином'
			)); ?>	

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
	</div>

	<div class="span3">
		<p class="small text-center"><strong>Контактное лицо</strong></p>
		<?php echo $form->textFieldRow($userData,'first_name', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Имя',
			)); ?>

		<?php echo $form->textFieldRow($userData,'last_name', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Фамилия',
			)); ?>

		<?php echo $form->textFieldRow($userData,'middle_name', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Отчество',
				'class' => 'optional',
			)); ?>

		<p class="small text-center"><strong>Фактический адрес</strong></p>
		<?php echo $form->dropDownListRow($userData, 'region_id', Region::model()->getRegionsList(), array(
			'label'=>false, 
			'empty' => '- выберите регион -',
		)); ?>

		<?php echo $form->textFieldRow($userData,'street', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Улица',
				'class' => 'optional'
			)); ?>
			<div class="clearfix"></div>

				<?php echo $form->textFieldRow($userData,'house', array(
					'maxlength'=>60, 
					'label'=>false, 
					'placeholder' => 'Дом',
					'class' => 'span1 optional'
				)); ?>

				<?php echo $form->textFieldRow($userData,'apartament', array(
					'maxlength'=>60, 
					'label'=>false, 
					'placeholder' => 'Офис',
					'class' => 'span1 optional'
				)); ?>
	</div>
	<div class="span3">
		<p class="small text-center"><strong>Юридический адрес</strong></p>
		<?php echo $form->dropDownListRow($orgData, 'region_id', Region::model()->getRegionsList(), array(
			'label'=>false, 
			'empty' => 'Регион',
			'class' => 'optional'
		)); ?>

		<?php echo $form->textFieldRow($orgData,'street', array(
				'maxlength'=>60, 
				'label'=>false, 
				'placeholder' => 'Улица',
				'class' => 'optional'
			)); ?>

		<?php echo $form->textFieldRow($orgData,'house', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'Дом',
			'class' => 'span1 optional'
		)); ?>

		<?php echo $form->textFieldRow($orgData,'office', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'Офис',
			'class' => 'span1 optional'
		)); ?>
		<?php echo $form->textFieldRow($orgData,'inn', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'ИНН',
			'class' => 'optional'
		)); ?>
		<?php echo $form->textFieldRow($orgData,'kpp', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'КПП',
			'class' => 'optional'
		)); ?>

		<?php echo $form->textFieldRow($orgData,'bank', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'Банк',
			'class' => 'optional'
		)); ?>

		<?php echo $form->textFieldRow($orgData,'bik', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'БИК',
			'class' => 'optional'
		)); ?>

		<?php echo $form->textFieldRow($orgData,'current_account', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'Расчётный счёт',
			'class' => 'optional'
		)); ?>

		<?php echo $form->textFieldRow($orgData,'correspond_account', array(
			'maxlength'=>60, 
			'label'=>false, 
			'placeholder' => 'Корреспондентский счёт',
			'class' => 'optional'
		)); ?>
		<p class="light-blue">Эти поля можно заполнить позже </p>
	</div>
	<div class="span6 clearfix" id="register-captcha">
		<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->captchaRow($model,'verifyCode',array(
					'label'=>false, 
	        'placeholder'=>'Введите код проверки...',
      	)); ?>
		<?php endif; ?>
	</div>
</div>

	<p class="muted small">
		Пользователь гарантирует достоверность всех вводимых при использовании сайта данных. Недостоверные или некорректные данные могут стать причиной отказа в обслуживании и выполнении финансовых операций.
	</p>
	<div class="form-actions">
		<?php echo $form->checkboxRow($userData, 'terms', array('label'=>false)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Регистрация',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-left',
		    ),
		)); ?>
	</div>

<?php $this->endWidget(); ?>