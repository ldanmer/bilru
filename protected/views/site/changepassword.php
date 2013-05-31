<?php $this->pageTitle=Yii::app()->name . ' - Смена пароля'; ?>

<div class="user-form" id="login-form">

<h3 class="form-title">Смена пароля</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>		

    <?php echo $form->passwordFieldRow($model,'password', array(
      'value'=>'', 
      'label'=>false, 
      'placeholder' => 'Пароль',
      'class'=>'span3'
      )); ?>
    <?php echo $form->passwordFieldRow($model,'password_repeat', array(
      'label'=>false, 
      'placeholder' => 'Подтверждение пароля',
      'class'=>'span3'
    )); ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
           	'size'=>'large',
            'label'=>'Отправить',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
