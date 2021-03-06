<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions' => array('class'=>'create-form'),
)); ?>
<legend><span>Фильтр</span></legend>
<?php echo CHtml::link('Скрыть','',array('class'=>'search-button')); ?>
<fieldset class="filter-form">
	<div class="span3">
		<h4 class="subtitle">Выберите тип заказчика</h4>
		<?php echo $form->dropDownListRow($model, 'org_type', GetName::getNames('OrgType', 'org_type_name'), array(
			'label'=>false, 
			'class'=>'span3 multiselect',
			'multiple'=>true,
		)); ?>

	<h4 class="subtitle">Выберите тип ПОКУПКИ</h4>
	<?php echo $form->dropDownListRow($model, 'category', $model->categoryList, array(
		'label'=>false, 
		'class'=>'span3 multiselect',
		'multiple'=>true,
	)); ?>
	</div>	
	<div class="span3">
		<h4 class="subtitle">Выберите регион</h4>
	<?php echo $form->dropDownListRow($model, 'region_id', GetName::getNames('Region', 'region_name'), array(
		'label'=>false, 
		'multiple'=>true,
		'class'=>'span3 multiselect',
	)); ?>

		<h4 class="subtitle">Выберите категорию ПОКУПКИ</h4>
		<?php echo $form->dropDownListRow($model, 'material_type', GetName::getNames('MaterialList', 'name'), array(
			'label'=>false, 
			'class'=>'span3 multiselect',
			'multiple'=>true,			
		)); ?>
	</div>
	<?php echo $form->checkboxRow($model, 'subscribe'); ?>
	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'size'=>'small',
			'label'=>'Применить',
			'htmlOptions' => array('class' => 'pull-right'),
		)); ?>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'primary',
			'size'=>'small',
			'label'=>'Сбросить',
			'htmlOptions' => array('class' => ''),
			'url' => array('/materialBuy/search'),
		)); ?>
	</div>
</fieldset>
<?php $this->endWidget(); ?>
