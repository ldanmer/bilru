<?php $this->pageTitle=Yii::app()->name . ' - Восстановление пароля'; ?>

<div class="user-form" id="login-form">

<h4 class="form-title">Восстановление пароля</h4>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm'); ?>		

	<?php echo $form->textFieldRow($model,'email',array('placeholder'=>'mail@example.com')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'block'=>true,
            'label'=>'Отправить',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
