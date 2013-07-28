<?php
$this->breadcrumbs=array(
	'Предложения поставщиков'
);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
	    	array('label'=>'Купить', 'url'=>array('materialBuy/create')),
        array('label'=>'Активные покупки', 'url'=>array('materialBuy/index'), 'active' => true),
       	array('label'=>'Завершенные покупки', 'url'=>'index'), 
	    ),
	)); ?>
</div>

<?php /* if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert alert-success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="alert alert-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; */?>

<?php 
	if($model->materialBuy->object->photoes != "null")
		$objImg = json_decode($model->materialBuy->object->photoes);
 ?>

<div class="order-title">
	Предложения поставщиков
</div>
<div class="order-view clearfix">
	<div class="span1">
		<p class="subtitle" align="center">Фото объекта</p>
		<?php if(!empty($objImg[0])): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$objImg[0]); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/order-image.png" />
	<?php endif; ?>
	</div>
	<div class="span6">
		<table class="table table-striped">	
			<tr class="alert alert-error">
				<td class="header">Срок поставки:</td>
				<td>с <?php echo $model->materialBuy->start_date; ?> по <?php echo $model->materialBuy->end_date; ?></td>
			</tr>			
			<tr>
				<td class="header">Покупка:</td>
				<td><?php echo CHtml::encode($model->materialBuy->title); ?></td>
			</tr>
			<tr>
				<td class="header">Объект:</td>
				<td><?php echo CHtml::encode($model->materialBuy->object->title); ?></td>
			</tr>			
			<tr>
				<td class="header">Категория покупки:</td>
				<td>
					<?php echo CHtml::encode($model->materialBuy->type->name); ?>
				</td>
			</tr>			
		</table>
	</div>
</div>

<div class="order-title">
	Предложение поставщика
</div>
<div class="order-view clearfix">
	<div class="span1">		
		<?php if(!empty($model->supplier->settings->avatar)): 
						$avatar = json_decode($model->supplier->settings->avatar);
		?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$avatar[0]); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/avatar_placeholder.png" />
	<?php endif; ?>
	Рейтинг: <span class="rating">
		<?php echo CHtml::link(GetName::getRating($model->supplier->id)->averageRating, array('userRating/view', 'id'=>$model->supplier->id)); ?>
		</span> 
		Отзывы: <span class="reviews">
			<?php echo CHtml::link(GetName::getRating($model->supplier->id)->count, array('userRating/view', 'id'=>$model->supplier->id)); ?>
		</span>
	</div>
	<div class="span6" style="margin-bottom:10px">
		<table class="table table-striped">			
			<tr>
				<td class="header">Поставщик:</td>
				<td><?php echo CHtml::encode($model->supplier->organizationData->org_name); ?></td>
			</tr>		
			<tr>
				<td class="header">Доставка:</td>
				<td><?php echo $model->delivery === null ? "Без доставки" : $model->delivery." руб."; ?></td>
			</tr>	
			<tr>
				<td class="header">ДАТА ПОСТАВКИ/ОТГРУЗКИ:</td>
				<td><?php echo $model->supply_date; ?></td>
			</tr>		
		</table>
		<?php echo CHtml::link("Посмотреть профиль поставщика",array(''), array('class'=>'btn btn-block pull-left')); ?>
	</div>

<div class="grid-view material-list">
<?php 
	$arrayData = $model->materialBuy->ordersList($model->material_buy_id, $model->id);
	 $this->widget('bootstrap.widgets.TbGridView', array(
  'dataProvider'=>$arrayData,
  'template'=>"{items}",
  'columns'=>array(
      array('name'=>0, 'header'=>'Наименование', 'htmlOptions'=>array('class'=>'span5')),
      array('name'=>1, 'header'=>'Ед.изм', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>2, 'header'=>'Количество', 'htmlOptions'=>array('class'=>'span0')), 	
      array('name'=>3, 'header'=>'Цена за ед.', 'htmlOptions'=>array('class'=>'span0')),
      array('name'=>4, 'header'=>'Сумма', 'htmlOptions'=>array('class'=>'span0 sum')), 		 
  		),
  'htmlOptions'=>array('class'=>'material-list'),
	)); 
 ?>

<?php if(!empty($model->comment)): ?>
<div class="comment" style="margin-bottom:10px">
	<?php echo $model->comment; ?>
</div>
<?php endif; ?>
</div>

<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Принять предложение',
		    'type'=>'primary',
		    'url'=>$this->createUrl($model->id, array('accept' => $model->material_buy_id)),
		    'htmlOptions'=>array(
		        'class' => 'pull-right',
		    ),
		));
 ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Вернуться к предложениям',
		    'url'=>$this->createUrl('list', array('id'=>$model->material_buy_id)),
		    'type'=>'primary',
		    'htmlOptions'=>array(
		        'class' => 'btn-back pull-left',
		    ),
		));
 ?>
</div>