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
	'class' => 'span6',
)); ?>

<?php 
Yii::import('ext.imperavi-redactor-widget.ImperaviRedactorWidget');
$this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'text',
    'options' => array(
      'lang' => 'ru', 
      'imageUpload'=>$this->createUrl('file/upload'),
      'imageGetJson'=>$this->createUrl('file/list'),
      'autoresize'=>true,
      'minHeight' => 200,
      'linebreaks'=> true,
      'buttons'=>array('image','video', 'table', 'bold'),
    ),
));

 ?>
 <br>
<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Сохранить',	
				'htmlOptions'=>array('class'=>'pull-right clearfix'),				
			)); ?>
</fieldset>


<?php $this->endWidget(); ?>

</div><!-- form -->