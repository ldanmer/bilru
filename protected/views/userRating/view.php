<?php
$this->breadcrumbs=array(
	'Отзывы'=>array('index'),
	$model->id,
);
?>
<div>
	<?php $this->widget('bootstrap.widgets.TbMenu', array(
	    'type'=>'tabs', 
	    'stacked'=>false, 
	    'items'=>array(
        array('label'=>'Отзывы', 'url'=>array('index'), 'active' => true),
	    ),
	)); ?>
</div>
<div class="order-title">
	Оставить отзыв
</div>
<div class="order-view clearfix">
		<div class="span1">		
		<?php if(!empty($model[0]->user->avatar)): ?>
			<?php echo CHtml::image(Yii::app()->baseUrl.$model[0]->user->avatar); ?>
		<?php else: ?>
		<img src="<?php echo Yii::app()->baseUrl ?>/img/avatar_placeholder.png" />
		<?php endif; ?>
		<p class="margin-top">
			<img src="<?php echo Yii::app()->baseUrl ?>/img/finger-up.png" class="pull-right" />
		</p>
	</div>
	<div class="span3">
		<h4 class="header"><?php echo CHtml::encode($model[0]->user->role->role_name) ?></h4>
		<h4><strong><?php echo CHtml::encode($model[0]->user->organizationData[0]->org_name) ?></strong></h4>
		<?php echo CHtml::link("Посмотреть профиль",array(''), array('class'=>'btn btn-block pull-left')); ?>
		<div class="clearfix"></div>
		<p class="green margin-top">Этого поставщика рекомендовало 
			<span class="red"><?php echo GetName::getRating($model[0]->user_id)->count ?></span>
			пользователей</p>
	</div>
	<div class="span2 margin-left">
		<div class="subtitle">
			<h4>Рейтинг: <span class="red"><?php echo GetName::getRating($model[0]->user_id)->averageRating ?></span></h4>
		</div>				
			<div class="rating-title"><?php echo $model[0]->category[0] ?>:
				<span class="red pull-right"><?php echo GetName::getRating($model[0]->user_id)->price ?></span>
			</div>
			<div class="rating-title"><?php echo $model[0]->category[1] ?>:
				<span class="red pull-right"><?php echo GetName::getRating($model[0]->user_id)->quality ?></span>
			</div>
			<div class="rating-title"><?php echo $model[0]->category[2] ?>:
				<span class="red pull-right"><?php echo GetName::getRating($model[0]->user_id)->delivery ?></span>
			</div>
			<div class="rating-title"><?php echo $model[0]->category[3] ?>:
				<span class="red pull-right"><?php echo GetName::getRating($model[0]->user_id)->personal ?></span>
			</div>
			<div class="rating-title"><?php echo $model[0]->category[4] ?>:
				<span class="red pull-right"><?php echo GetName::getRating($model[0]->user_id)->assortiment ?></span>
			</div>
			<div class="rating-title"><?php echo $model[0]->category[5] ?>:
				<span class="red pull-right"><?php echo GetName::getRating($model[0]->user_id)->service ?></span>
			</div>
	</div>
</div>
<?php  $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_comment',
	'template' => '{items}',
	'htmlOptions' => array('class' => 'clearfix'),
)); ?>
