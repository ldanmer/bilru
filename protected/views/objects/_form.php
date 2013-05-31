<?php echo $form->errorSummary($objects); ?>	
<legend>
		<span>Создание объекта</span>
	</legend>
	<fieldset id="create-object">
		<div class="span3">
			<h4 class="subtitle">Фото объекта</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'photoes',
              'accept' => 'jpeg|jpg|gif|png',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
      <small class="red">разрешенные типы файлов: jpg, gif, png</small>	
			<h4 class="subtitle">Чертежи объекта</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'bluprints',
              'accept' => 'jpeg|jpg|gif|png|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
      <small class="red">разрешенные типы файлов: jpg, gif, png, pdf</small>	
			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'objectdocs',
              'accept' => 'doc|docx|txt|pdf|csv|xls',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
      <small class="red">разрешенные типы файлов: doc, txt, pdf, csv, xls</small>	
		</div>
		<div class="span3">
			<h4 class="subtitle" align="center">Профиль объекта</h4>
			<?php echo $form->textFieldRow($objects,'title',array(
			'label'=>false, 
			'maxlength'=>255,
			'placeholder' => 'Введите название объекта',
			'class' => 'span3',
			)); ?>

			<?php echo $form->dropDownListRow($objects, 'object_type_id', GetName::getNames('ObjectTypes', 'name'), array(
				'label'=>false, 
				'empty'=>'- Тип объекта -',
				'class' => 'span3',
			)); ?>

			<div class="span2">
				<?php echo $form->dropDownListRow($objects, 'region_id', GetName::getNames('Region', 'region_name'), array(
					'label'=>false, 
					'empty' => '- выберите регион -',
				)); ?>

				<?php echo $form->dropDownListRow($objects, 'city_id', GetName::getNames('City', 'city_name'), array(
					'label'=>false, 
					'empty' => '- выберите город -',
				)); ?>

				<?php echo $form->textFieldRow($objects,'street',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Улица',
				)); ?>	
			
			</div>

			<div class="span0">				
				<?php echo $form->textFieldRow($objects,'house',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Дом',
				'class' => 'span0',
				)); ?>

				<?php echo $form->textFieldRow($objects,'square',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Площадь',
				'class' => 'span0',
				)); ?>

				<?php echo $form->textFieldRow($objects,'floors',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Этажей',
				'class' => 'span0',
				)); ?>
			</div>
			<div class="span3">
				<h4 class="subtitle" align="center">Наличие коммуникаций</h4>	
				<div class="round-border">
					<?php echo $form->checkBoxListRow($objects, 'communications', $objects->communicationTypes, array(
					'label'=>false, 
				)); ?>
				</div>
			</div>
		</div>
	</fieldset>