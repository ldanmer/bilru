<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('object_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->object_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photoes')); ?>:</b>
	<?php echo CHtml::encode($data->photoes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blueprints')); ?>:</b>
	<?php echo CHtml::encode($data->blueprints); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documents')); ?>:</b>
	<?php echo CHtml::encode($data->documents); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('region_id')); ?>:</b>
	<?php echo CHtml::encode($data->region_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::encode($data->city_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('house')); ?>:</b>
	<?php echo CHtml::encode($data->house); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('square')); ?>:</b>
	<?php echo CHtml::encode($data->square); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('floors')); ?>:</b>
	<?php echo CHtml::encode($data->floors); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('communications')); ?>:</b>
	<?php echo CHtml::encode($data->communications); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>