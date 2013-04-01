<?php
/* @var $this ZakupkiController */
/* @var $data Zakupki */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organization')); ?>:</b>
	<?php echo CHtml::encode($data->organization); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('placement')); ?>:</b>
	<?php echo CHtml::encode($data->placement); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('stop_date')); ?>:</b>
	<?php echo CHtml::encode($data->stop_date); ?>
	<br />

	*/ ?>

</div>