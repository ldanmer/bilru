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
		<h4 class="subtitle">Фото объекта</h4>
		<?php if($model->images): ?>
		<div class="viewapartment-main-photo">			
			<?php
			$img = null;
			$res = Images::getMainThumb(300, 200, $model->images);
			$img = CHtml::image($res['thumbUrl'], $res['comment']);
			if($res['link'])
			{
				echo CHtml::link($img, $res['link'], array(
					'rel' => 'fancybox',
					'title' => $res['comment'],
				));
			} 
			else 
				echo $img;
			?>
		</div>
		<?php
			if ($model->images) {
				$this->widget('images.components.ImagesWidget', array(
					'images' => $model->images,
					'objectId' => $model->id,
				));
			}
		?>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif ?>		
		<h4 class="subtitle">Чертежи объекта</h4>
		<?php if($blueprints): ?>
		<div class="image_carousel">
			<div class="carusel">
				<?php foreach ($blueprints as $blueprint) {
					echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$blueprint), Yii::app()->baseUrl.$blueprint, array('rel'=>'fancybox'));
				} ?>
			</div>				
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
		<h4 class="subtitle">Документы</h4>
		<?php if(!is_null($model->documents)): ?>		
		<div>
		 <ol class="doc-list">
		 	<?php echo GetName::getDocsList($model->documents)->list; ?>
		 </ol>
		</div>
		<?php else: ?>
		<div>
			<em>Пользователь пока ничего не добавил</em>
		</div>
		<?php endif; ?>
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
					<?php echo CHtml::encode($data->region->cities[0]->region->region_name); ?>
				</td>
			</tr>
			<tr>
				<td class="header">Город:</td>
				<td>
					<?php echo CHtml::encode($data->region->cities[0]->city_name); ?>
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
				<td class="header">ПЛОЩАДЬ:</td>
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
		<h4 class="subtitle">Наличие коммуникаций</h4>
		<div class="grey-field">
			<?php 			
				echo !empty($model->communications) ? GetName::jsonToString($model->communications, $model->communicationTypes, "<br>") : "коммуникаций нет"; 
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

