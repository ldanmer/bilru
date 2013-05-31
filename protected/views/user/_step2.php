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
		<?php echo $form->dropDownListRow($userData, 'region_id', array($regionNames), array(
			'hint' => 'Регион',
			'label'=>false, 
			'empty' => '- выберите регион -',
			'tabindex'=>70,
		)); ?>

		<?php echo $form->dropDownListRow($userData, 'city_id', array($cityNames), array(
			'hint' => 'Город',
			'label'=>false, 
			'empty' => '- выберите город -',
			'tabindex'=>80,
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
			'label'=>$model->isNewRecord ? 'Регистрация' : 'Сохранить',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'agreement')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">X</a>
    <h4>Позовательское соглашение</h4>
</div>
 
<div class="modal-body">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Suspendisse nisi. Vestibulum vitae enim a nulla suscipit tincidunt. Suspendisse potenti. Phasellus pulvinar. Donec suscipit dui at nisi. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </p>
    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.
    </p>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>



