<?php
$this->breadcrumbs=array(
	'Объекты'=>array('index'),
	'Создать',
);
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Активные объекты', 'url'=>array('objects/index')),
	        array('label'=>'Создать объект', 'url'=>array('objects/create')),
	        array('label'=>'Завершенные', 'url'=>array('objects/finished')),
	    ),
	)); ?>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'htmlOptions' => array('class' => 'create-form material-list','enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $this->renderPartial('/objects/_form', array(
		'objects'=>$objects,	
		'form'=>$form,
)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Сохранить',
				'htmlOptions' => array('class' => 'pull-right', 'name' => 'publish'),				
			)); ?>
<?php $this->endWidget(); ?>
<?php 
	$this->widget('ext.fancybox.EFancyBox', array(
    'target'=>'a[rel=fancybox]',
    'config'=>array(),
    ));	
?>