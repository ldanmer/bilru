<?php
$this->breadcrumbs=array(
	'Дать предложение',
);

$today = date("d.m.Y"); 
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти подряд', 'url'=>array('orders/search'), 'active' => true),
	        array('label'=>'Мои подряды', 'url'=>array('orderOffer/index')),
	        array('label'=>'Завершенные подряды', 'url'=>array('orderOffer/finished')),
	    ),
	)); ?>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'htmlOptions' => array('class' => 'create-form material-list','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>
	<legend>
		<span>Дать предложение</span>
	</legend>
	<fieldset>
<div class="detail-order">
	<table class="table">
		<tr>
			<td class="header">Наименование подряда:</td>
			<td><?php echo $order->title; ?></td>
		</tr>
		<tr>
			<td class="header">СТОИМОСТЬ РАБОТ:</td>
			<td><?php echo $order->price == 0 ? 'По договоренности' : $order->price; ?></td>
		</tr>
		<tr>
			<td class="header">ПРИЕМ ЗАЯВОК:</td>
			<td>
				<table>
					<tr>
						<td class="header">Начало</td>
						<td><?php echo $order->start_date; ?></td>
						<td class="header">Окончание</td>
						<td><?php echo $order->end_date; ?></td>
					</tr>
				</table>
			</td>
		</tr>			
		<tr>
			<td class="header">АДРЕС ОБЪЕКТА:</td>
			<td>
				<?php echo $order->object->region->region_name ?>, 
				ул.<?php echo $order->object->street ?>, 
				д.<?php echo $order->object->house ?>
			</td>
		</tr>			
		<tr>
			<td class="header">МАТЕРИАЛЫ НА ОБЪЕКТ:</td>
			<td>
				<?php echo $order->materialType[CHtml::encode($order->material)]; ?>
			</td>
		</tr>
		<tr>
			<td class="header">СРОКИ ВЫПОЛНЕНИЯ РАБОТ:</td>
			<td>
				<?php 					
				if($order->duration != 0)
					echo CHtml::encode($order->duration) . " дней"; 
				else
					echo "По договоренности"; 
					 ?>
			</td>
		</tr>			
	</table>
<?php if(empty($already)): ?>
<p>
Для создания предложения введите предлагаемую Вами стоимость работ и материалов. Укажите срок выполнения работ и дату когда Вы готовы приступить к выполнению подряда. Рекомендуем добавить файлы с коммерческим предложением, сметой на работы и материалы, это повысит ваш профессиональный уровень в глазах Заказчика. Короткий, но содержательный комментарий способен привлечь внимание Заказчика именно к Вашему предложению.</p>
<table class="table">
	<tr>
		<td class="header">Стоимость работ:</td>
		<td>
			<?php echo $form->textFieldRow($model,'work_price',array(
				'label'=>false, 
				'placeholder' => 'Введите стоимость работ',
				'style' => 'width: 98%',
				)); ?>			
		</td>
	</tr>
	<tr>
		<td class="header">Стоимость материалов:</td>
		<td>
			<?php echo $form->textFieldRow($model,'material_price',array(
				'label'=>false, 
				'placeholder' => 'Введите стоимость материалов',
				'style' => 'width: 98%',
				)); ?>				
		</td>
	</tr>
	<tr>
		<td class="header">Срок выполнения работ:</td>
		<td>
			<?php echo $form->textFieldRow($model,'duration',array(
				'label'=>false, 
				'placeholder' => 'Количество дней',
				'style' => 'width: 98%',
				)); ?>	
		</td>
	</tr>
	<tr>
		<td class="header">Готов начать:</td>
		<td>
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
		</td>
	</tr>
	<tr>
		<td class="header">Добавить документы:</td>
		<td>
			<?php $this->widget('CMultiFileUpload', array(
        	'name' => 'doc_list',
	        'accept' => 'jpeg|jpg|gif|png|doc|docx|txt|pdf',
	        'duplicate' => 'Дупликат!', 
	        'denied' => 'Неверный тип файла',
	      ));
    	?>			
		</td>
	</tr>
</table>

<?php echo $form->textAreaRow($model, 'comment', array(
	'class'=>'span6', 
	'rows'=>5, 
	'placeholder'=>'Здесь вы можете написать комментарий к Вашему предложению.',
	'label'=>false, 
	)); ?>

<?php 
	$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=> 'Дать предложение',
			'htmlOptions' => array('name' => 'save', 'class'=>'pull-right'),			
		));

	endif;
	$this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>'Вернуться к результатам поиска',
	    'type'=>'primary',
	    'url'=>array('orders/search'),
	    'htmlOptions'=>array(
	        'class' => 'btn-back pull-left',
	    ),
	));
?>
	</div>
</div>

</fieldset>
<?php $this->endWidget(); ?>