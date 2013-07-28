<?php
$this->breadcrumbs=array(
	'Объекты',
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
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_finish',
	'template' => '{items}{pager}',
)); ?>
<?php 

$this->widget('ext.fancybox.EFancyBox', array(
    'target'=>'a[rel=fancybox]',
    'config'=>array(),
    ));	

 ?>