<?php
$this->breadcrumbs=array(
	$model->title,
);

?>

<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	        array('label'=>'Найти подряд', 'url'=>'search', 'active' => true),
	    ),
	)); ?>
</div>

<form class="create-form">

<legend><span>ИНФОРМАЦИЯ О ПОДРЯДЕ</span></legend>
<fieldset>
<div class="detail-order">
	<div class="span6">
		<table class="table">
			<tr>
				<td class="header">ИНФОРМАЦИЯ О ПОДРЯДЕ:</td>
				<td><?php echo $model->title; ?></td>
			</tr>
			<tr>
				<td class="header">СТОИМОСТЬ РАБОТ:</td>
				<td><?php echo number_format($model->price, 2, ',', ' '); ?></td>
			</tr>
			<tr>
				<td class="header">ПРИЕМ ЗАЯВОК:</td>
				<td>
					<table>
						<tr>
							<td class="header">Начало</td>
							<td><?php echo $model->start_date; ?></td>
							<td class="header">Окончание</td>
							<td><?php echo $model->end_date; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="header">ВИД РАБОТ:</td>
				<td>
					<?php echo $model->category ?>
				</td>
			</tr>
			<tr>
				<td class="header">ОБЪЕКТ:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
						echo $model->object;
					?>
				</td>
			</tr>
			<tr>
				<td class="header">ЗАКАЗЧИК:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
						echo $model->customer ?>
				</td>
			</tr>
			<tr>
				<td class="header">СПОСОБ РАЗМЕЩЕНИЯ:</td>
				<td>
					<?php	echo $model->placement ?>
				</td>
			</tr>
			<tr>
				<td class="header">СРОКИ ВЫПОЛНЕНИЯ РАБОТ:</td>
				<td>
					<?php echo CHtml::encode($model->duration) . " дней"; ?>
				</td>
			</tr>
			<tr>
				<td class="header">КОНТАКТЫ:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
					 echo $model->contact 
					?>
				</td>
			</tr>
			<tr>
				<td class="header contact">Телефон:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
						echo $model->phone ?>
				</td>
			</tr>
			<tr>
				<td class="header contact">E-mail:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
					 echo $model->email ?>
				</td>
			</tr>
			<tr>
				<td class="header contact">Контактное лицо:</td>
				<td>
					<?php
					if(UserSettings::getThisTariff() == 1)
						echo '<p class="text-error">Информация недоступна на тарифном плане «БАЗОВЫЙ»</p>';
					else
					 echo $model->persona ?>
				</td>
			</tr>
			<tr>
				<td class="header">Документы:</td>
				<td>
					<ul>
						<?php echo $model->docs ?>
					</ul>
				</td>
			</tr>
			<tr>
				<td class="header">ОФИЦИАЛЬНЫЙ САЙТ:</td>
				<td>
					<?php 
					if(UserSettings::getThisTariff() == 1):
					$this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>'перейти на официальный сайт подряда',
					    'htmlOptions'=>array(
					        'data-toggle'=>'modal',
					        'data-target'=>'#alert',
					    ),
					));
				else:
					echo CHtml::link('перейти на официальный сайт подряда', $model->link, array('target' => '_blank')); 
				endif;
				?>
				</td>
			</tr>
		</table>
</div>
</div>
</fieldset>
</form>

<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться к результатам поиска',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-right',
		    ),
		));
 ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'alert')); ?>
 
<div class="alert alert-error">
    Информация недоступна на тарифном плане «БАЗОВЫЙ»
</div>

 
<?php $this->endWidget(); ?>