<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('offer')); ?>:</b>
	<?php echo CHtml::encode($data->offer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_buy_id')); ?>:</b>
	<?php echo CHtml::encode($data->material_buy_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />


</div>