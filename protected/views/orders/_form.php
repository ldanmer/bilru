<?php 
$today = date("d.m.Y"); 
$monthPlus =  date("d.m.Y", strtotime("+1 month", time()));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'orders-form',
	'htmlOptions' => array('class' => 'create-form','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<?php 
	if(!Yii::app()->user->isGuest)
		echo $form->errorSummary($model); 
	else
		echo '<div class="alert">Для создания объекта и размещения заказа необходимо зарегистрироваться</div>';
	?>

	<!-- Если объекты существуют -->
	<?php if(isset($objects) && is_array($objects)): ?>
	<legend>
		<span>НАЙТИ ПОДРЯДЧИКА НА ОБЪЕКТ</span>
	</legend>
	<fieldset>

		<?php echo $form->radioButtonListRow($model, 'object_id', $objects, array(
				'label'=>false, 
			)); ?>

			<p class="text-info">
			Для создания заказа необходимо выбрать или создать ОБЪЕКТ. В разделе ОБЪЕКТ хранится история ваших заказов, покупок, а также фотографии, чертежи, файлы и информация о ОБЪЕКТЕ.
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
		<?php $title = isset($objects) ? "Создание" : "Редактирование" ?>
		<span><?php echo $title; ?> заказа</span>
	</legend>
	<fieldset id="create-order">
		<div class="span3">	
		<h4 class="subtitle">Выберите тип подрядчика</h4>
		<?php echo $form->dropDownListRow($model, 'user_role_id', $model->contractorTypes, array(
			'label'=>false, 
			'multiple'=>true,
			'class'=>'span3 multiselect',			
			)); ?>	
		</div>

		<div class="span3">
			<h4 class="subtitle">Выберите вид работ</h4>
			<?php echo $form->dropDownListRow($model, 'work_type_id',WorkTypes::model()->getCategoryList(),	array(
				'label'=>false, 
				'multiple'=>true,
				'class'=>'span3 multiselect',			
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
			<div class="round-border">
				<?php echo $form->textFieldRow($model,'price',array(
						'class' => 'span1',
						'label' => false,
						'prepend' => 'Стоимость',
						'append' => 'руб.',
						'class'=>'input-prepend'
					)); ?>
			    <label class="checkbox">
		    		По договоренности
      			<input type="checkbox" id="dogovorennost">
    		</label>
    		</div>
			<h4 class="subtitle">Сроки выполнения работ</h4>
				<?php echo $form->textFieldRow($model,'duration',array(
					'label'=>false,
					'class' => 'input-append',
					'append'=>'Дней',
					)); 
				?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Загрузить',
		    'type'=>'primary',
		    'size'=>'mini',		     
		    'htmlOptions' => array(
		    	'class'=>'pull-right change upload',
		    	'data-target'=>'documents',
					'title'=>'Разрешенные типы файлов: doc|docx|txt|pdf|csv|xls',		 
					'style'=>'margin-top:5px',
				  ),
			)); ?>
			<h4 class="subtitle">Документы</h4>
			<?php $this->widget('CMultiFileUpload', array(
              'name' => 'documents',
              'accept' => 'doc|docx|txt|pdf|csv|xls',
              'duplicate' => 'Дупликат!', 
              'denied' => 'Неверный тип файла',
            ));
      ?>      	
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
			<p class="text-info">
			Ваши контакты  подрядчик увидит после того, как вы его отметите как претендента в разделе «ПОСТУПИЛИ ПРЕДЛОЖЕНИЯ»
			</p>
		</div>

			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Разместить заказ',
				'htmlOptions' => array('class' => 'pull-right clearfix', 'name' => 'publish'),				
			)); ?>

</fieldset>
<?php $this->endWidget(); ?>
