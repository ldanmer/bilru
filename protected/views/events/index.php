<?php
/* @var $this EventsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Кабинет пользователя',
);
?>

<div id="feed-nav">
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
	    'stacked'=>false, // whether this is a stacked menu
	    'items'=>array(
	        array('label'=>'Лента', 'url'=>array('events/index')),
	        array('label'=>'Создать событие', 'url'=>array('events/create')),
	    ),
	)); ?>
</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template' => '{items}',
	'htmlOptions' => array('class' => 'clearfix'),
)); ?>


