<?php
$this->pageTitle=Yii::app()->name . ' - Восстановление пароля';
$this->breadcrumbs=array(
	'Восстановление пароля',
);
?>

<div class="user-form" id="login-form">

<h3 class="form-title">Восстановление пароля</h3>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
  'type'=>'horizontal',	
)); ?>		

	<?php echo $form->textFieldRow($model,'email',array('placeholder'=>'mail@example.com')); ?>

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
