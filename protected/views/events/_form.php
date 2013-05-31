<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'events-form',
	'htmlOptions' => array('class' => 'create-form'),
	'enableAjaxValidation'=>false,
)); ?>
<fieldset>
<?php echo $form->textFieldRow($model,'title',array(
	'label'=>false, 
	'maxlength'=>255,
	'placeholder' => 'Введите заголовок',
	'class' => 'span3',
)); ?>

<?php echo $form->textAreaRow($model,'text',array(
	'label'=>false, 
	'placeholder' => 'Текст новости',
	'class' => 'span3',
	'rows'=>5
)); ?>
<div class="clearfix"></div>
<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Сохранить',					
			)); ?>
</fieldset>


<?php $this->endWidget(); ?>

</div><!-- form -->