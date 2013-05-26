<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Отзывы', 'url'=>array('userRating/self')),
	    ),
	)); ?>
</div>
<?php  $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_reply',
	'template' => '{items}',
	'htmlOptions' => array('class' => 'clearfix'),
)); ?>