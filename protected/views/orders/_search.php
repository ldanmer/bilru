<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions' => array('class'=>'create-form'),
)); ?>
<?php 
	$def_region = $_GET['Orders']['region_id'];
	$def_orgtype = $_GET['Orders']['org_type'];
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

	<?php echo $form->dropDownListRow($model, 'work_type_id', GetName::getNames('WorkTypes', 'name'), array(
		'label'=>false, 
		'empty' => 'Выберите вид работ',
		'class' => 'span3'
	)); ?>

	<?php echo $form->dropDownListRow($model, 'org_type', array(1=>'Государственный', 3=>'Частный'), array(
		'label'=>false, 
		'empty' => 'Выберите тип заказчика',
		'class' => 'span3',
		'options' => array($def_orgtype=>array('selected'=>true))
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
			'url' => array('/orders/search'),
		)); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
