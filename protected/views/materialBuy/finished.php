<?php
$this->breadcrumbs=array(
	'Список закупок',
);
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	    	array('label'=>'Купить', 'url'=>'create'),
        array('label'=>'Активные покупки', 'url'=>'index'),
       	array('label'=>'Завершенные покупки', 'url'=>'finished', 'active' => true), 
	    ),
	)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_finish',
	'template' => '{items}{pager}'
)); ?>
