<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'orders-form',
	'htmlOptions' => array('class' => 'create-form','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>	

	<legend>
		<span>Создание объекта</span>
	</legend>
	<fieldset>
		<div class="span3">
			<h4 class="subtitle">Фото объекта</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'photoes',
              'accept' => 'jpeg|jpg|gif|png|doc|docx|txt|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>


			<h4 class="subtitle">Чертежи объекта объекта</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'blueprints',
              'accept' => 'jpeg|jpg|gif|png|doc|docx|txt|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>

			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'objectdocs',
              'accept' => 'jpeg|jpg|gif|png|doc|docx|txt|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
		</div>
		<div class="span3">
			<h4 class="subtitle" align="center">Профиль объекта</h4>
			<?php echo $form->textFieldRow($model,'title',array(
			'label'=>false, 
			'maxlength'=>255,
			'placeholder' => 'Введите название объекта',
			'class' => 'span3',
			)); ?>

			<?php echo $form->dropDownListRow($model, 'object_type_id', $objectTypes, array(
				'label'=>false, 
				'empty'=>'- Тип объекта -',
				'class' => 'span3',
			)); ?>

			<div class="span2">
				<?php echo $form->dropDownListRow($model, 'region_id', $regionNames, array(
					'label'=>false, 
					'empty' => '- выберите регион -',
				)); ?>

				<?php echo $form->dropDownListRow($model, 'city_id', $cityNames, array(
					'label'=>false, 
					'empty' => '- выберите город -',
				)); ?>

				<?php echo $form->textFieldRow($model,'street',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Улица',
				)); ?>	
			
			</div>

			<div class="span0 pull-right">				
				<?php echo $form->textFieldRow($model,'house',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Дом',
				'class' => 'span0',
				)); ?>

				<?php echo $form->textFieldRow($model,'square',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Площадь',
				'class' => 'span0',
				)); ?>

				<?php echo $form->textFieldRow($model,'floors',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Этажей',
				'class' => 'span0',
				)); ?>
			</div>
			<div class="span3">
				<h4 class="subtitle" align="center">Наличие коммуникаций</h4>	
				<?php echo $form->checkBoxListRow($model, 'communications', $communicationTypes, array(
				'label'=>false, 
			)); ?>
			</div>

		</div>

	</fieldset>
		<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Сохранить',
				'htmlOptions' => array('name' => 'save'),			
			)); ?>
		</div>
</fieldset>
<?php $this->endWidget(); ?>