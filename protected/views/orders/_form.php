<?php 
$today = date("d.m.Y"); 
$monthPlus =  date("d.m.Y", strtotime("+1 month", time()));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'orders-form',
	'htmlOptions' => array('class' => 'create-form','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<!-- Если объекты существуют -->

	<?php if(isset($objects) && is_array($objects)): ?>
	<legend>
		<span>НАЙТИ ПОДРЯДЧИКА НА ОБЪЕКТ</span>
	</legend>
	<fieldset>

		<?php echo $form->radioButtonListRow($model, 'object_id', $objects, array(
				'label'=>false, 
			)); ?>

		<div class="span5">
			<p class="text-info">
			Для создания заказа необходимо выбрать или создать ОБЪЕКТ. В разделе ОБЪЕКТ хранится история ваших заказов, покупок, а также фотографии, чертежи, файлы и информация о ОБЪЕКТЕ.
			</p>
		</div>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'link',
				'url' => $this->createUrl('create', array('object' => 'new')),
				'type'=>'primary',
				'label'=> 'Создать объект',
				'htmlOptions' => array('class' => 'pull-right', 'name' => 'newobject'),				
			)); ?>

		<?php //echo CHtml::link("Создать объект",array('objects/create'), array('class'=>'btn btn-primary')); ?>
	</fieldset>
	
	<!-- Если объектов еще нет -->
	<?php elseif(isset($objects)): ?>

	<?php echo $form->errorSummary($objects); ?>
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

			<div class="span0 pull-right">				
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
				<?php echo $form->checkBoxListRow($objects, 'communications', $objects->communicationTypes, array(
				'label'=>false, 
			)); ?>
			</div>

		</div>

	</fieldset>

	<?php endif; ?>

	<legend>
		<?php $title = isset($objects) ? "Создание" : "Редактирование" ?>
		<span><?php echo $title; ?> заказа</span>
	</legend>
	<fieldset>
		<div class="span3">			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Выберите тип подрядчика',
		    'block'=>true,
		    'toggle' => true,
		    'htmlOptions' => array(
		    	'id' => 'contractor-types',
		    	),
			)); ?>
		</div>
		<div id="contractor-list" class="form-list span6">
			<?php echo $form->checkBoxListRow($model, 'user_role_id', $model->contractorTypes, array(
				'label'=>false, 
			)); ?>
		</div>

		<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Выберите вид работ',
		    'block'=>true,
		    'htmlOptions' => array('id' => 'work-types'),
			)); ?>
		</div>

			<div id="work-list" class="form-list span6">
				<?php echo $form->checkBoxListRow($model, 'work_type_id', GetName::getNames('WorkTypes', 'name'), array(
					'label'=>false, 
				)); ?>
			</div>

		<?php echo $form->textFieldRow($model,'title',array(
			'label'=>false, 
			'maxlength'=>255,
			'placeholder' => 'Введите наименование заказа',
			'class' => 'span6',
			)); ?>

		<?php echo $form->textAreaRow($model,'description',array(
			'rows'=>6, 
			'cols'=>50,
			'label'=>false,
			'placeholder' => 'Описание заказа',
			'class' => 'span6',
			)); ?>

		<div class="span3">
			<h4 class="subtitle">Стоимость работ</h4>
			<div class="grey-field">
				<?php echo $form->textFieldRow($model,'price',array(
						'class' => 'span1',
						'label' => false,
						'prepend' => 'Стоимость',
						'append' => 'руб.',
					)); ?>
			    <label class="checkbox">
		    		По договоренности
      			<input type="checkbox" id="dogovorennost">
    		</label>
			</div>
		</div>
		<div class="span3">
		<h4 class="subtitle" align="center">Прием заявок</h4>
			<div class="span1">
				<h4 class="subtitle" align="center">Начало</h4>				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					    'model' => $model,
					    'attribute' => 'start_date',
					    'language' => 'ru',
					    'htmlOptions' => array(
 								'class' => 'span1',
 								'value' => $today,
					    ),
						));
					?>
			</div>
			<div class="span1 pull-right">
				<h4 class="subtitle" align="center">Окончание</h4>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					    'model' => $model,
					    'attribute' => 'end_date',
					    'language' => 'ru',
					    'htmlOptions' => array(
 								'class' => 'span1',
 								'value' => $monthPlus,
					    ),
						));
					?>
			</div>
		</div>

		<div class="span3">
			<h4 class="subtitle">Материалы на объект</h4>
			<?php echo $form->radioButtonListRow($model, 'material', $model->materialType, array(
				'label'=>false,				
				)); ?>
		</div>

		<div class="span3">
			<h4 class="subtitle">Сроки выполнения работ</h4>
				<?php echo $form->textFieldRow($model,'duration',array(
					'label'=>false,
					'class' => 'span2',
					'append'=>'Дней',
					)); 
				?>
		</div>
		<div class="span3 clearfix">
			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'documents',
              'accept' => 'jpeg|jpg|gif|png|doc|docx|txt|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
		</div>
		<div class="span3">
			<p class="text-info">
			Ваши контакты  подрядчик увидит после того, как вы его отметите как претендента в разделе «ПОСТУПИЛИ ПРЕДЛОЖЕНИЯ»
			</p>
		</div>

		<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Сохранить',
				'htmlOptions' => array('name' => 'save'),			
			)); ?>

			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Разместить заказ',
				'htmlOptions' => array('class' => 'pull-right', 'name' => 'publish'),				
			)); ?>
		</div>
</fieldset>
<?php $this->endWidget(); ?>
