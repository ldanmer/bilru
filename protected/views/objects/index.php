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
	        array('label'=>'Мои объекты', 'url'=>array('objects/index')),
	        array('label'=>'Создать объект', 'url'=>array('objects/create')),
	    ),
	)); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
