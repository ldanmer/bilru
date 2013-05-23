<?php
/* @var $this EventsController */
/* @var $model Events */

$this->breadcrumbs=array(
	'События'=>array('index'),
	'Создать',
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
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>