<?php 
$today = date("d.m.Y"); 
$monthPlus =  date("d.m.Y", strtotime("+1 month", time()));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'htmlOptions' => array('class' => 'create-form material-list','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<?php 
	if(!Yii::app()->user->isGuest)
		echo $form->errorSummary($model); 
	else
		echo '<div class="alert">В уcловиях гостевого доступа вы не можете создавать заказы</div>';
	?>

	<!-- Если объекты существуют -->

	<?php if(isset($objects) && is_array($objects)): ?>
	<legend>
		<span>ПОКУПКА НА ОБЪЕКТ</span>
	</legend>
	<fieldset>

		<?php echo $form->radioButtonListRow($model, 'object_id', $objects, array(
				'label'=>false, 
			)); ?>

			<p class="text-info">
			Для создания ПОКУПКИ необходимо выбрать или создать ОБЪЕКТ. В разделе ОБЪЕКТ хранится история ваших заказов, покупок, а также фотографии, чертежи, файлы и информация о ОБЪЕКТЕ.
			</p>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'link',
				'url' => $this->createUrl('objects/create'),
				'type'=>'primary',
				'label'=> 'Создать объект',
				'htmlOptions' => array('class' => 'pull-right', 'name' => 'newobject'),				
			)); ?>
	</fieldset>
	
	<!-- Если объектов еще нет -->
	<?php elseif(isset($objects)): ?>
		
	<?php echo $this->renderPartial('/objects/_form', array(
		'objects'=>$objects,	
		'form'=>$form,
	)); ?>
	
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
			<div class="grey-field">
				<?php echo $form->checkboxRow($model, 'supply'); ?>
			</div>
			<h4 class="subtitle" align="center">Показывать поставщикам для уточнений</h4>
			<div class="grey-field">
				<?php echo $form->checkBoxListRow($model, 'show_contact', array('email', 'телефон'), array('label' => false)); ?>	
			</div>
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
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Загрузить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change upload',
		    	'data-target'=>'documents',
					'title'=>'Разрешенные типы файлов: doc|docx|txt|pdf|csv|xls|rtf',	
					'style'=>'margin-top:5px;',
				  ),
			)); ?>
			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'documents',
              'accept' => 'doc|docx|txt|pdf|csv|xls|rtf',
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
						<?php foreach (MaterialBuy::model()->unit as $value): ?>
					  	<option value="<?php echo $value ?>"><?php echo $value ?></option>
						<?php endforeach; ?>
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
