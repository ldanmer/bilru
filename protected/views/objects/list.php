<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'objects-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'create-form','enctype' => 'multipart/form-data'),
)); ?>
	<legend>
		<span>НАЙТИ ПОДРЯДЧИКА НА ОБЪЕКТ</span>
	</legend>
	<fieldset>
		<ol>
			<?php foreach ($objects as $object): ?>
			<li>	
			<label class="checkbox">							
			 <?php echo $object->title; ?><input type="checkbox" name="Objects[id]" value="<?php echo $object->id; ?>">
			 </label> 		
			</li>
			<?php endforeach; ?>
		</ol>

		<div class="span5">
			<p class="text-info">
			Для создания заказа необходимо выбрать или создать ОБЪЕКТ. В разделе ОБЪЕКТ хранится история ваших заказов, покупок, а также фотографии, чертежи, файлы и информация о ОБЪЕКТЕ.
			</p>
		</div>
	</fieldset>
<?php $this->endWidget(); ?>