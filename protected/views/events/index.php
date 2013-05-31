<?php
$this->pageTitle=Yii::app()->name . ' - Лента новостей';
$this->breadcrumbs=array(
	'Кабинет '. GetName::getCabinetAttributes()->title,
);
?>

<div id="feed-nav">
		<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false,
	    'items'=>array(
	        array('label'=>'Создать событие', 'url'=>array('events/create')),      
	    ),
	    'htmlOptions'=>array('class'=>'pull-right'),
	)); ?>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false,
	    'items'=>array(
	        array('label'=>'Лента', 'url'=>array('events/index')),	        
	    ),
	)); ?>

</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template' => '{items}',
	'htmlOptions' => array('class' => 'clearfix'),
)); ?>


