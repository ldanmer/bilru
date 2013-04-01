<?php
$this->breadcrumbs=array(
	'Объекты'=>array('index'),
	$model->title,
);
?>
<div class="order-title">
	ПРОФИЛЬ ОБЪЕКТА
</div>

<div class="order-view create-form clearfix" id="object-view">

	<div class="span3">
		<p class="subtitle" align="center">Фото объекта</p>
		<div class="image_carousel">
			<div id="photos" class="carusel">
				<?php foreach ($photos as $photo) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$photo), Yii::app()->baseUrl.$photo, array('rel'=>'fancybox'));
				} ?>
			</div>
			<div class="pagination" id="photos_pag"></div>
		</div>
		<p class="subtitle" align="center">Чертежи объекта</p>
		<div class="image_carousel">
			<div id="blueprints" class="carusel">
				<?php foreach ($blueprints as $blueprint) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$blueprint), Yii::app()->baseUrl.$blueprint, array('rel'=>'fancybox'));
				} ?>
			</div>
				<div class="pagination" id="blueprints_pag"></div>
		</div>
		<p class="subtitle" align="center">Документы</p>
		<div>
		<?php 
			if($model->documents != "null"):
				$docs = GetName::getDocsList($model->documents);				
		 ?>
		 <ol class="doc-list">
		 	<?php echo $docs->list; ?>
		 </ol>
		<?php endif; ?>
		</div>

	</div>
	<div class="span3">
		<table class="table table-striped">

			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($model->title); ?></td>
			</tr>
			<tr>
				<td class="header">Тип:</td>
				<td><?php echo CHtml::encode($model->objectType->name); ?></td>
			</tr>
			<tr>
				<td class="header">Регион:</td>
				<td>
					<?php echo CHtml::encode($model->region->region_name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">Город:</td>
				<td>
					<?php echo CHtml::encode($model->city->city_name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">Адрес:</td>
				<td>
					ул.<?php echo CHtml::encode($model->street); ?>,
					д.<?php echo CHtml::encode($model->house); ?>
				</td>
			</tr>
			<tr>
				<td class="header">ПЛОЩАДЬ ОБЪЕКТА:</td>
				<td>
					<?php echo CHtml::encode($model->square); ?> м<sup>2</sup>		
				</td>
			</tr>
			<tr>
				<td class="header">Этажность:</td>
				<td>
					<?php echo CHtml::encode($model->floors); ?>		
				</td>
			</tr>
		</table>
		<p class="subtitle" align="center">Наличие коммуникаций</p>
		<div class="white-list">
			<?php 
				$communications = GetName::jsonToString($model->communications, $model->communicationTypes, "<br>");
				echo !empty($communications) ? $communications : "коммуникаций нет"; 
				?>
		</div>

</div>	
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться',
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-right clearfix',
		    ),
			));
	 ?>
</div>

<?php 

$this->widget('ext.fancybox.EFancyBox', array(
    'target'=>'a[rel=fancybox]',
    'config'=>array(),
    ));	

 ?>

