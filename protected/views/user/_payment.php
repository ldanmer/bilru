<table class="items table">
	<tr>
		<td class="blue" width="200">ПЕРИОД  ОПЛАТЫ</td>
		<?php foreach(Bill::model()->terms as $term): ?>
		<td class="blue" width="100"><?php echo $term ?></td>
		<?php endforeach; ?>
	</tr>	
	<tr>
		<td>СУММА</td>
		<?php foreach(GetName::tarifPrice($tarifVal)->mainPrice as $price): ?>
		<td><?php echo $price ?></td>
		<?php endforeach; ?>
	</tr>	
	<tr>
		<td class="dark-green">В ПОДАРОК</td>
		<?php foreach(GetName::tarifPrice($tarifVal)->discount as $discount): ?>
		<td class="dark-green"><?php echo $discount ?></td>
		<?php endforeach; ?>
	</tr>	
	<tr id="sum">
		<td>К ОПЛАТЕ</td>
		<?php foreach(GetName::tarifPrice($tarifVal)->discountPrice as $price): ?>
		<td><?php echo $price ?></td>
		<?php endforeach; ?>
	</tr>	
</table>	
