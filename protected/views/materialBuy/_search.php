<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions' => array('class'=>'create-form'),
)); ?>
<?php 
	$def_region = $_GET['Orders']['region_id'];
 ?>


<legend><span>Фильтр</span></legend>
<?php echo CHtml::link('Скрыть','#',array('class'=>'search-button')); ?>
<fieldset class="filter-form">


	<?php echo $form->dropDownListRow($model, 'region_id', GetName::getNames('Region', 'region_name'), array(
		'label'=>false, 
		'empty' => 'Выберите регион',
		'class' => 'span3',
		'options' => array($def_region=>array('selected'=>true))
	)); ?>

	<?php echo $form->dropDownListRow($model, 'category', $model->categoryList, array(
		'label'=>false, 
		'empty' => 'Выберите тип ПОКУПКИ',
		'class' => 'span3',		
	)); ?>

	<?php echo $form->dropDownListRow($model, 'org_type', GetName::getNames('OrgType', 'org_type_name'), array(
		'label'=>false, 
		'empty' => 'Выберите тип заказчика',
		'class' => 'span3',		
	)); ?>

	<?php echo $form->dropDownListRow($model, 'material_type', GetName::getNames('MaterialList', 'name'), array(
		'label'=>false, 
		'empty' => 'Выберите категорию ПОКУПКИ',
		'class' => 'span3',		
	)); ?>

<div class="span6">
	<?php echo $form->checkboxRow($model, 'email_check'); ?>
</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Применить',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'primary',
			'label'=>'Сбросить',
			'htmlOptions' => array('class' => ''),
			'url' => array('/materialBuy/search'),
		)); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
