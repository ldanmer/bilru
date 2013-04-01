<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'start_date',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'end_date',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textAreaRow($model,'work_type',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'object',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'object_address',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'customer',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'placement',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'material',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'duration',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'contact',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'persona',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'docs',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'link',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
