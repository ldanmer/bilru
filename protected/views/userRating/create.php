<?php
$this->breadcrumbs=array(
	'Рейтинг'=>array('index'),
	'Создание',
);
?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	    	array('label'=>'Купить', 'url'=>array('materialBuy/create')),
        array('label'=>'Активные покупки', 'url'=>array('materialBuy/index')),
       	array('label'=>'Завершенные покупки', 'url'=>array('materialBuy/finished'), 'active' => true), 
	    ),
	)); ?>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>