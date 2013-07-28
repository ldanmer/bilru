<?php
$this->breadcrumbs=array(
	'Отзывы'
);
?>
<div class="order-title">
	Отзывы о компании
</div>
<div class="order-view clearfix" id="user-review">
	<div class="span1">		
  	<?php if(!empty($model[0]->user->settings->avatar)): 
			$avatar = json_decode($model[0]->user->settings->avatar);
		?>
      <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.$avatar[0]), array('user/profile', 'id'=>$model[0]->user_id)); ?>
    <?php else: ?>
      <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/img/avatar_placeholder.png'), array('user/view')); ?>
    <?php endif; ?>
	</div>
	<div class="span3" style="margin-left:30px;">
		<h4 class="header"><?php echo CHtml::encode($model[0]->user->role->role_name) ?></h4>
		<h4><strong><?php echo CHtml::encode($model[0]->user->organizationData->org_name) ?></strong></h4>
		<?php echo CHtml::link("Посмотреть профиль",array('user/profile', 'id'=>$model[0]->user_id), array('class'=>'btn btn-block btn-small pull-left')); ?>
	</div>
	<div class="span2 pull-right">
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
