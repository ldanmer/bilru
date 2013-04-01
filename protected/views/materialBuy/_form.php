<?php 
$today = date("d.m.Y"); 
$monthPlus =  date("d.m.Y", strtotime("+1 month", time()));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'htmlOptions' => array('class' => 'create-form material-list','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<!-- Если объекты существуют -->

	<?php if(isset($objects) && is_array($objects)): ?>
	<legend>
		<span>ПОКУПКА НА ОБЪЕКТ</span>
	</legend>
	<fieldset>

		<?php echo $form->radioButtonListRow($model, 'object_id', $objects, array(
				'label'=>false, 
			)); ?>

		<div class="span5">
			<p class="text-info">
			Для создания ПОКУПКИ необходимо выбрать или создать ОБЪЕКТ. В разделе ОБЪЕКТ хранится история ваших заказов, покупок, а также фотографии, чертежи, файлы и информация о ОБЪЕКТЕ.
			</p>
		</div>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'link',
				'url' => $this->createUrl('create', array('object' => 'new')),
				'type'=>'primary',
				'label'=> 'Создать объект',
				'htmlOptions' => array('class' => 'pull-right', 'name' => 'newobject'),				
			)); ?>
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
		 <span>Условия</span>
	</legend>
	<fieldset>
		<div>
			<?php echo $form->textFieldRow($model,'title',array(
				'label'=>false, 
				'maxlength'=>255,
				'placeholder' => 'Заголовок',
				'style' => 'width: 98%',
				)); ?>
			</div>
		<div class="span3">
			<?php echo $form->dropDownListRow($model, 'category',$model->categoryList, array(
				'label'=>false, 
				'empty' => 'Выберите тип ПОКУПКИ',
				'class' => 'span3',
			)); ?>

			<?php echo $form->dropDownListRow($model, 'material_type',GetName::getNames('MaterialList', 'name'), array(
				'label'=>false, 
				'empty' => 'Выберите вид ПОКУПКИ',
				'class' => 'span3',
			)); ?>

			<?php echo $form->checkboxRow($model, 'supply'); ?>
			<h4 class="subtitle" align="center">Показывать поставщикам для уточнений</h4>
			<?php echo $form->checkBoxListRow($model, 'show_contact', array('email', 'телефон'), array('label' => false)); ?>	
	</div>


		<div class="span3">
		<h4 class="subtitle" align="center">Срок поставки</h4>
			<div class="span1">
				<h4 class="subtitle" align="center">Начало</h4>				
				<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'name' => 'start_date',
							'language'=>'ru',
					    'model' => $model,
					    'attribute' => 'start_date',
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
							'name' => 'end_date',
							'language'=>'ru',
					    'model' => $model,
					    'attribute' => 'end_date',
					    'htmlOptions' => array(
 								'class' => 'span1',
 								'value' => $monthPlus,
					    ),
						));
					?>
			</div>
			<div class="clearfix"></div>
			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'documents',
              'accept' => 'jpeg|jpg|gif|png|doc|docx|txt|pdf',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>
		</div>
</fieldset>

<legend>
	 <span>Перечень</span>
</legend>


<fieldset>
<div class="grid-view">
	<table class="items table">
		<th>Наименование</th>
		<th>Ед.изм</th>
		<th>Количество</th>
		<tbody id="order-list">
			<?php for ($i=0; $i < 5; $i++): ?>
			<tr>
				<td>
					<input type="text" name="MaterialBuy[goodName][]" id="MaterialBuy_goodName" class="span5">
				</td>
				<td>
					<select class="span0" name="MaterialBuy[unit][]" id="MaterialBuy_unit">
					  <option value="шт.">шт.</option>
					  <option value="упак.">упак.</option>
					  <option value="кг.">кг.</option>
					</select>
				</td>
				<td>
					<input type="number" name="MaterialBuy[quantity][]" id="MaterialBuy_quantity" value="1" class="span0">
				</td>
			</tr>
		<?php endfor; ?>
		</tbody>
	</table>
 <?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Добавить строк',
    'type'=>'null', 
    'size'=>'small',
    'htmlOptions' => array('id'=>'add-lines'),
)); ?> 
</div>
</fieldset>

		<div>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Разместить заказ',
				'htmlOptions' => array('name' => 'save', 'class'=>'pull-right'),			
			)); ?>
		</div>
<?php $this->endWidget(); ?>
