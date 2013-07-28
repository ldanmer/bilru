<?php 
if(!Yii::app()->user->isGuest)
	echo $form->errorSummary($objects); 
?>	
	<legend>
		<span>Создание объекта</span>
	</legend>
	<fieldset id="create-object">
					<h4 class="subtitle">Фото объекта</h4>
			<?php
			$this->widget('images.components.AdminImagesWidget', array(
				'objectId' => $objects->id,
			));
			?>
		<div class="span3"> 
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Загрузить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change upload',
		    	'data-target'=>'bluprints',
		    	'title'=>'Разрешенные типы файлов: jpeg|jpg|gif|png|pdf',					
				  ),
			)); ?>
			<h4 class="subtitle">Чертежи объекта</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'bluprints',
              'accept' => 'jpeg|jpg|gif|png|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>

      <?php if(!$objects->isNewRecord && !is_null($objects->blueprints)): ?>
			<?php $blueprints = json_decode($objects->blueprints); ?>
			<div class="image_carousel">
				<div class="carusel">
					<?php foreach ($blueprints as $blueprint) {
						echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$blueprint), Yii::app()->baseUrl.$blueprint, array('rel'=>'fancybox'));
					} ?>
				</div>				
			</div>
			<?php endif; ?>
      	
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Загрузить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change upload',
		    	'data-target'=>'objectdocs',
		    	'title'=>'Разрешенные типы файлов: doc|docx|txt|pdf|csv|xls|rtf',
				  ),
			)); ?>
			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'objectdocs',
              'accept' => 'doc|docx|txt|pdf|csv|xls|rtf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
      <?php if(!$objects->isNewRecord && !is_null($objects->documents)): ?>
			<div>
			 <ol class="doc-list">
			 	<?php echo GetName::getDocsList($objects->documents)->list; ?>
			 </ol>
			</div>
			<?php endif; ?>
      	
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
				<?php echo $form->dropDownListRow($objects, 'region_id', Region::model()->getRegionsList(), array(
					'label'=>false, 
					'empty'=>'- Выберите регион -',	
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