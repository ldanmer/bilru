<?php 
	$paymentList = Bill::model()->paymentList;
	if($model->org_type_id == 1)
		unset($paymentList[array_search("Оплата по счету в безналичной форме",$paymentList)]);
		
 ?>
<table class="items table" id="payment-result">
	<tr>
		<th>Выберите способ оплаты</th>
		<td>
			<?php echo CHtml::dropDownList('mode', '', $paymentList, array('label'=>false, 'class'=>'pull-right', 'style'=>'margin:0;width: 100%;')); ?>
		</td>
	</tr>
	<tr>
		<th>Наименование</th>
		<td class="dark-green" id="payment-title">-</td>
	</tr>
	<tr>
		<th>Стоимость</th>
		<td class="dark-green" id="final-price">0,00 руб.</td>
	</tr>
</table>